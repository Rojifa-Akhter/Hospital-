<?php

namespace App\Http\Controllers;

use App;
use PDF;
use PDO;
use Image;
use DateTime;
use Exception;
use PDOException;
use App\Library\Template;
use App\Traits\LookupData;
use App\Traits\MailEngine;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use League\CommonMark\Extension\Autolink\EmailAutolinkProcessor;
use Illuminate\Support\Facades\Config;
class HOSPurchaseOrder extends Controller
{
    use LookupData, MailEngine;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
                    ->select('*')
                    ->where('PHARMACY_IND', '=', 1)
                    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                    ->get();

        $allSuppliers = DB::table('inv_supplier')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw('lower(supplier_name) asc')
            ->get();

        //   $userDept=DB::table('hrms_personnel')->select('serviceunit_no_fk')->where('person_no_pk', Session::get('user.ses_person_no_fk'))->first();
        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $su_no = [];
        if (!empty($main_store_list)) {
            foreach ($main_store_list as  $value) {
                $su_no[] = $value->serviceunit_no_pk;
            }
        }

        $sevenDaysAgo = now()->subDays(7);

        $all_purchased_orders_worklist = DB::table('inv_po_wl_vw')
            ->whereIn('store_no_fk', $su_no)
            ->whereDate('purchase_date', '>=', $sevenDaysAgo)
            ->where('au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk'));

        if (Session::get('user.inv_hod_ind') == null) {
            $all_purchased_orders_worklist->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
        }
        $all_purchased_orders_worklists = $all_purchased_orders_worklist->orderBy('au_entry_at', 'desc')
            ->get();

        // dd($all_purchased_orders_worklists);
        return Template::loadview("admin.uhl.inventory.purchase-order-worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $po_master_info = [];
        //$main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $aproval_count = '';
        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");
        return  Template::loadView("admin.uhl.inventory.create-purchase-order", ['main_store_list' => $main_store_list, 'supplier_arr' => $supplier_arr, 'poTerms' => $poTerms, 'po_master_info' => $po_master_info, 'aproval_count' => $aproval_count]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {


        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'delivery_date' => 'required',
            'supplier_id' => 'required',
            'in_store_no_fk' => 'required',
            'hdn_pur_um_name.*' => 'required',
            'item_rates.*' => 'required|numeric|gt:0'
        ]);

        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
        });



        if ($files = $request->file('attachment')) {

            $fileSize =  $request->file('attachment')->getSize() / 1024 / 1024;

            if (number_format($fileSize) > number_format(50)) {

                // return $validator->errors()->add('item', 'The file cannot be uploaded more than 10 MB.');

                $message = ['msg' => 'The file cannot be uploaded more than 10 MB.', 'title' => 'Error'];

                return response()->json($message);

            }

        }



        $validator->validate();

        DB::beginTransaction();

        try {

        $in_po_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;

        $in_delivery_date = !empty($request->delivery_date) ? date('Y-m-d', strtotime($request->delivery_date)) : null;

        // $in_item_category = strtoupper(trim($request->category_id));

        $supplier_id = $request->supplier_id;

        $item_no_fk_arr = $request->item_ids;

        $indent_no_arr = $request->indent_no;

        $dollar_rate = $request->dollar_rate;

        $currency_sign = $request->currency_sign;

        $pr_doc_attachment_path = $request->pr_doc_attachment_path;

        $item_specification = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $item_specification[$i] = $request->item_specification[$i];

            }

        }

        // dd($item_no_fk_arr ,$item_specification);







        if (!empty($item_no_fk_arr)) {

            foreach ($item_no_fk_arr as $iofa) {

                $item_barcode_arr[] = $iofa[0];

            }

        }

        $in_term_number = [];

        $in_term_text = [];

        $in_header = [];

        // if (!empty($request->termsid)) {

        //     for ($i = 0; $i < count($request->termsid); $i++) {

        //         $requestName  = 'terms_text_' . $request->termsid[$i];

        //         $in_term_number[$i] = $request->termsid[$i];

        //         $in_term_text[$i] = $request->input($requestName);

        //     }

        // } else {

        //     $in_term_number[] = 0;

        //     $in_term_text[] = '';

        // }

        if (!empty($request->terms_text)) {

            $in_term_number = $request->terms_sl;

            $in_term_text = $request->terms_text;

            $in_header = $request->header_name;

        }





        // dd( count( $in_term_text) , $in_term_text ,   $in_header);



        $item_uoms_arr = [];

        $empty = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $item_uoms_arr[$i] = isset($request->item_uoms[$i])  ? $request->item_uoms[$i] : 0;

                $empty[$i] = 0;

            }

        }



        $in_vat_percent_itm = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $in_vat_percent_itm[$i] = isset($request->item_vat[$i])  ? $request->item_vat[$i] : 0;

            }

        }



        $in_vat_amount_itm = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $in_vat_amount_itm[$i] = isset($request->vat_amount[$i])  ? $request->vat_amount[$i] : 0;

            }

        }



        $in_discount_percent_itm = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $in_discount_percent_itm[$i] = isset($request->item_discount[$i])  ? $request->item_discount[$i] : 0;

            }

        }



        $in_discount_amount_itm = [];

        if (!empty($item_no_fk_arr)) {

            for ($i = 0; $i < count($item_no_fk_arr); $i++) {

                $in_discount_amount_itm[$i] = isset($request->discount_amount[$i])  ? $request->discount_amount[$i] : 0;

            }

        }

        // // dd( $item_uoms_arr);





        $sales_uom = $request->sales_uom;

        $item_quantities_arr = $request->item_quantities;

        $item_prices_arr = $request->item_rates;



        $item_conversion = $request->item_conversion;

        $in_store_no_fk =  $request->in_store_no_fk;

        $main_store_module = ServiceUnit::where('serviceunit_no_pk', $request->in_store_no_fk)
                                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $main_store_module = isset($main_store_module->main_store_module_no_fk) ?

            $main_store_module->main_store_module_no_fk : 0;







        //$in_au_entry_by             = Auth::id();

        $in_au_entry_by = Session::get('user.ses_user_pk_no');

        $in_au_entry_session = 'UHL PO';

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

        $in_vat_percent = $request->vat_percent;

        $in_vat_amount = $request->total_vat_amount != "" ? $request->total_vat_amount : 0;

        // $in_vat_percent_itm = $request->item_vat != "" ? $request->item_vat:0;

        // $in_vat_amount_itm = $request->vat_amount != "" ? $request->vat_amount : 0;

        // $in_discount_percent_itm = $request->item_discount != "" ? $request->item_discount:0;

        // $in_discount_amount_itm = $request->discount_amount != "" ? $request->discount_amount : 0;

        //dd("$in_vat_percent_itm ,$in_vat_amount_itm ,$in_discount_percent_itm, $in_discount_amount_itm");

        $item_total = $request->item_total != "" ? $request->item_total : 0;

        $adj_amt = $request->discount_adj_amt != "" ? $request->discount_adj_amt : 0;

        try {
            $adj_perc = ($adj_amt /  $item_total) * 100;
        } catch (\Exception $e) {
            $adj_perc = 0;
        }



        $in_discount_percent = $request->discount_percent + $adj_perc;

        $in_discount_amount = $request->total_discount_amount + $adj_amt;

        $in_po_no = $request->hdn_po_no;

        $in_po_edit_ind = $request->po_edit_ind;

        $in_refer_no = $request->ref_no;

        $in_refer_sub = $request->subject_details;

        $refer_contact_name = $request->contact_person;

        $refer_contact_mobile = $request->contact_number;

        $refer_contact_email = $request->contact_email;

        $refer_contact_email = $request->contact_email;

        $refer_quotation_ref = $request->quotation_ref;

        $refer_item_specification = ""; //$request->item_specification;

        $in_subject_body = $request->message_body;

        $in_requisition_code = $request->in_requisition_code;

        $in_req_saveoption = $request->in_req_saveoption;

        // dd($in_discount_percent , $in_discount_amount);

        // dd($request->message_body);

        $numelems = 1000;



        $out_po_uid = '';

        $out_purchase_uid = '';

        $null = '';

        $zero = 0;

        $emptyArray = array();

        $test_date = date('Y');

        $out_purchase_no_pk = 0;

        $pdo = DB::getPdo();

        $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_generic_po_create(

                    :in_purchaseorder_no_pk,

                    :in_purchaseorder_edit_ind,

                    :in_purchase_date,

                    :in_supplier_no_fk,

                    :in_item_category,

                    :in_fiscal_year,

                    :in_vat_percent,

                    :in_vat_amount,

                    :in_discount_percent,

                    :in_discount_amount,

                    :in_module_no_fk,

                    :in_refer_no,

                    :in_refer_sub,

                    :in_refer_contact_name,

                    :in_refer_contact_mobile,

                    :in_refer_contact_email,

                    :in_subject_body,

                    :in_requisition_no_fk,

                    :in_requisition_code,

                    :in_store_no_fk,

                    :in_notes,

                    :in_budget_no_fk,

                    :in_po_save_option,

                    :in_delivery_date,

                    :in_item_no_fk,

                    :in_item_barcode,

                    :in_pvms_no,

                    :in_uom,

                    :in_entry_qty,

                    :in_item_rate,

                    :in_term_number,

                    :in_term_text,

                    :in_pr_uom_no_fk,

                    :in_pr_uom_conversion_qty,

                    :in_pr_uom_tradeprice,

                    :in_vat_percent_itm,

                    :in_vat_amount_itm,

                    :in_discount_percent_itm,

                    :in_discount_amount_itm,

                    :in_item_requisition_no_fk,

                    :in_item_level_notes,

                    :in_inv_requisitiondtl_no_pk,

                    :in_termscon_header,

                    :in_refer_item_specification,

                    :in_au_entry_by ,

                    :in_au_entry_hospital_no_fk ,

                    :in_au_entry_session ,

                    :out_purchase_no_pk ,

                    :out_purchase_uid,

                    :out_error

                ); end;");



        $purchase_order_entry->bindparam('in_purchaseorder_no_pk', $in_po_no);

        $purchase_order_entry->bindparam('in_purchaseorder_edit_ind', $in_po_edit_ind);

        $purchase_order_entry->bindparam('in_purchase_date', $in_po_date);

        $purchase_order_entry->bindparam('in_supplier_no_fk', $supplier_id);

        $purchase_order_entry->bindparam('in_item_category', $null);

        $purchase_order_entry->bindparam('in_fiscal_year', $test_date);

        $purchase_order_entry->bindparam('in_vat_percent', $in_vat_percent);

        $purchase_order_entry->bindparam('in_vat_amount', $in_vat_amount);

        $purchase_order_entry->bindparam('in_discount_percent', $in_discount_percent);

        $purchase_order_entry->bindparam('in_discount_amount', $in_discount_amount);

        $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);

        $purchase_order_entry->bindparam('in_refer_no', $in_refer_no);

        $purchase_order_entry->bindparam('in_refer_sub', $in_refer_sub);

        $purchase_order_entry->bindparam('in_refer_contact_name', $refer_contact_name);

        $purchase_order_entry->bindparam('in_refer_contact_mobile', $refer_contact_mobile);

        $purchase_order_entry->bindparam('in_refer_contact_email', $refer_contact_email);

        $purchase_order_entry->bindparam('in_subject_body', $in_subject_body);

        $purchase_order_entry->bindparam('in_requisition_no_fk', $zero);

        $purchase_order_entry->bindparam('in_requisition_code', $in_requisition_code);

        $purchase_order_entry->bindparam('in_store_no_fk', $in_store_no_fk);

        $purchase_order_entry->bindparam('in_notes', $null);

        $purchase_order_entry->bindparam('in_budget_no_fk', $zero);

        $purchase_order_entry->bindparam('in_po_save_option', $in_req_saveoption);

        $purchase_order_entry->bindparam('in_delivery_date', $in_delivery_date);

        $purchase_order_entry->bindArray('in_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);

        $purchase_order_entry->bindArray('in_item_barcode', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_CHR);

        $purchase_order_entry->bindArray('in_pvms_no', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_CHR);

        $purchase_order_entry->bindArray('in_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);

        $purchase_order_entry->bindArray('in_entry_qty', $item_quantities_arr, count($item_quantities_arr), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_item_rate', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_term_number', $in_term_number, count($in_term_number), $numelems, SQLT_INT);

        $purchase_order_entry->bindArray('in_term_text', $in_term_text, count($in_term_text), $numelems, SQLT_CHR);

        $purchase_order_entry->bindArray('in_pr_uom_no_fk', $sales_uom, count($sales_uom), $numelems, SQLT_INT);

        $purchase_order_entry->bindArray('in_pr_uom_conversion_qty', $item_conversion, count($item_conversion), $numelems, SQLT_INT);

        $purchase_order_entry->bindArray('in_pr_uom_tradeprice', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_item_requisition_no_fk', $empty, count($empty), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_item_level_notes', $empty, count($empty), $numelems, SQLT_CHR);

        $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk', $empty, count($empty), $numelems, SQLT_FLT);

        $purchase_order_entry->bindArray('in_termscon_header', $in_header, count($in_header), $numelems, SQLT_CHR);

        $purchase_order_entry->bindArray('in_refer_item_specification', $item_specification, count($item_specification), $numelems, SQLT_CHR);

        $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);

        $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

        $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);

        $purchase_order_entry->bindParam('out_purchase_no_pk', $out_purchase_no_pk, PDO::PARAM_INT);

        $purchase_order_entry->bindParam('out_purchase_uid', $out_purchase_uid, PDO::PARAM_STR, 500);

        $purchase_order_entry->bindParam('out_error', $out_po_uid, PDO::PARAM_STR, 500);

        // dd( $purchase_order_entry);

        $purchase_order_entry->execute();

        // dd($request->file('attachment'));

        // dd(json_decode($request->delete_pr_item_map));

        $po_id = $in_po_no != "" ? $in_po_no : $out_purchase_no_pk;



        if ($in_po_no != "" || $out_purchase_no_pk != "") {



            if (!empty($refer_quotation_ref)) {

                $data = [
                    'quotation_ref' => $refer_quotation_ref,
                    'copy_to' => $request->copy_to
                ];

                if (!empty($out_purchase_no_pk)) {

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $out_purchase_no_pk)->update($data);

                } else {

                    // dd($out_purchase_no_pk , $in_po_no);

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $in_po_no)->update($data);

                }

            }

            if (isset($request->indent_pr) && !empty($request->indent_pr)) {

                $pr_indent_exp = explode(',', $request->indent_pr);

                foreach ($pr_indent_exp as $key => $value) {

                    $arr_exp = explode('_', $value);

                    foreach ($request->item_id as  $item) {

                        if ($item == $arr_exp[0]) {

                            $data = [
                                'po_ind' => 1,
                                'purchaseorder_no_fk' => $po_id,
                            ];

                            DB::table('inv_requisitiondtl_po')->where('inv_requisitiondtl_po_no_pk', $arr_exp[2])->update($data);

                        }

                    }

                }

            }

            if (!empty($request->delete_pr_item)) {

                $delete_pr_item = explode(',', $request->delete_pr_item);



                foreach ($delete_pr_item  as  $item) {

                    $data = [

                        'po_ind' => null,

                        'purchaseorder_no_fk' => null,

                    ];

                    DB::table('inv_requisitiondtl_po')->where('purchaseorder_no_fk', $po_id)->where('item_no_fk', $item)->update($data);

                }

            }

            if (!empty($dollar_rate) && !empty($currency_sign)) {

                for ($i = 0; $i < count($dollar_rate); $i++) {

                    $data = [

                        'dollar_rate' => $dollar_rate[$i],

                        'currency_sign' => $currency_sign[$i],



                    ];

                    if (!empty($out_purchase_no_pk)) {

                        DB::table('inv_purchaseorder_chd')->where('purchaseorder_no_fk', $out_purchase_no_pk)->where('item_no_fk', $item_no_fk_arr[$i])->update($data);

                    } else {

                        DB::table('inv_purchaseorder_chd')->where('purchaseorder_no_fk', $in_po_no)->where('item_no_fk', $item_no_fk_arr[$i])->update($data);

                    }

                }

            }

            if (!empty($pr_doc_attachment_path)) {
                $data = ['pr_doc_attachment_path' => $pr_doc_attachment_path[0]];
                if (!empty($out_purchase_no_pk)) {

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $out_purchase_no_pk)->update($data);

                } else {

                    // dd($out_purchase_no_pk , $in_po_no);

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $in_po_no)->update($data);

                }

            }

            if ($request->hasFile('attachment')) {
                if ($files = $request->file('attachment')) {
                    $data['po_doc_attachment_path'] = date('Ymdhis') . "." . $files->getClientOriginalExtension();
                }

                if ($files = $request->file('attachment')) {

                    $data['po_doc_attachment_path'] = date('Ymdhi') . "." . $files->getClientOriginalExtension();

                }



                if ($files = $request->file('attachment')) {
                    // Generate a unique name for the image
                    $filename = $data['po_doc_attachment_path'];
                    // Save the image to the public directory
                    $request->attachment->move(public_path('/images/uploads/attachment'), $filename);
                }

                if (!empty($out_purchase_no_pk)) {

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $out_purchase_no_pk)->update($data);

                } else {

                    DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $in_po_no)->update($data);

                }

            }

            if (Session::get('user.email_send_ind') == 1) {
                if ($in_req_saveoption == "POST") {
                    $approvalMst = DB::table('sysc_approvalmatrixmst')->select('dept_base_approval_ind')->where('approval_for_code', 'PO')->first();
                    $approval_matrix = [];
                    if (!empty($approvalMst) && $approvalMst->dept_base_approval_ind == 1) {
                        $approval_matrix = DB::table('sysc_approvalmatrix_dept_vw')->select('sysc_approvalmatrix_dept_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->where('dept_su_no_fk', Session::get('user.su_pk_no'))->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_dept_vw.person_no_fk')->get()->toArray();

                    } else {

                        $approval_matrix = DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_vw.person_no_fk')->get()->toArray();

                    }
                    // $approval_matrix=DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*','hrms_personnel.email_personal')->where('approval_for_code','PO')->leftJoin('hrms_personnel','hrms_personnel.person_no_pk','=','sysc_approvalmatrix_vw.person_no_fk')->get();

                    if (!empty($approval_matrix)) {

                        $app_arr = [];

                        foreach ($approval_matrix as $key => $value) {

                            $app_arr[$key] = $value->email_personal;

                        }

                        $this->inventoryMail($app_arr, $in_po_no, $value->approval_for_code, Auth::user()->user_fullname);

                    }

                }

            }


            if ($request->indent_pr != "" || $request->delete_pr_item != "") {
                if ($out_purchase_no_pk != "" && $in_po_no == "" && $request->indent_pr != "") {



                    DB::beginTransaction();

                    $sequence = DB::getSequence();

                    $pr_indent_seq = $sequence->nextValue('purchaseorder_map_no_pk_seq');

                    $pr_indent_exp = explode(',', $request->indent_pr);

                    foreach ($pr_indent_exp as $key => $value) {

                        $arr_exp = explode('_', $value);

                        foreach ($request->item_id as  $item) {

                            if ($item == $arr_exp[0]) {

                                $data = [

                                    'purchaseorder_map_no_pk' => $pr_indent_seq,

                                    'purchaseorder_no_fk' => $out_purchase_no_pk,

                                    'item_no_fk' => $arr_exp[0],

                                    'inv_requisitiondtl_no_fk' => $arr_exp[1],

                                    'inv_requisitiondtl_po_no_fk' => $arr_exp[2],

                                    'au_entry_by' => $in_au_entry_by,

                                    'au_entry_at' => date('Y-m-d'),

                                    'au_entry_session' => $in_au_entry_session,

                                    'au_entry_hospital_no_fk' =>  $in_au_entry_hospital_pk_no,







                                ];



                                DB::table('inv_purchaseorder_pr_req_map')->insert($data);

                            }

                        }

                    }

                    DB::commit();

                } else {

                    if (isset($request->delete_pr_item) && $request->delete_pr_item != "") {

                        $delete_pr_exp = explode(',', $request->delete_pr_item);

                        foreach ($delete_pr_exp as $key => $value) {

                            DB::table('inv_purchaseorder_pr_req_map')->where('purchaseorder_no_fk', $in_po_no)->where('item_no_fk', $value)->delete();

                        }

                    }

                    DB::beginTransaction();

                    $sequence = DB::getSequence();

                    $pr_indent_seq = $sequence->nextValue('purchaseorder_map_no_pk_seq');

                    $pr_indent_exp = explode(',', $request->indent_pr);

                    foreach ($pr_indent_exp as $key => $value) {

                        $arr_exp = explode('_', $value);

                        foreach ($request->item_id as  $item) {

                            if ($item == $arr_exp[0]) {

                                $data = [

                                    'purchaseorder_map_no_pk' => $pr_indent_seq,

                                    'purchaseorder_no_fk' => $in_po_no,

                                    'item_no_fk' => $arr_exp[0],

                                    'inv_requisitiondtl_no_fk' => $arr_exp[1],

                                    'inv_requisitiondtl_po_no_fk' => $arr_exp[2],

                                    'au_entry_by' => $in_au_entry_by,

                                    // 'au_entry_at' => date('Y-m-d h:i:s a'),

                                    'au_entry_session' => $in_au_entry_session,

                                    'au_entry_hospital_no_fk' =>  $in_au_entry_hospital_pk_no,

                                ];

                                DB::table('inv_purchaseorder_pr_req_map')->insert($data);

                            }

                            DB::commit();

                        }

                    }

                }

            }

        }



        DB::commit();



        $message = ['msg' => 'Data saved successfully. <br><strong>Purchase Order UID = ' .  $po_id . '</strong>', 'title' => 'Success'];

        } catch (Exception $e) {

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];

        }

        return response()->json($message);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($purchase_order_id)
    {
        //
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");

        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->orderBy('purchaseorder_terms_no_pk', 'asc')->orderBy('sl', 'asc')->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }


        $po_child_details_info = DB::select(DB::raw("SELECT poc.* , l.* ,i.*,u.* ,poc.item_no_fk as req_item_no_fk
        FROM INV_PURCHASEORDER_CHD poc
        LEFT JOIN sysc_serviceitem_inv_vw l ON poc.ITEM_NO_FK = l.ITEM_NO_FK
        LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
        WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order By poc.purchaseorderdtl_no_pk"));

        $po_map = DB::table('inv_purchaseorder_pr_req_map')->select('inv_requisitiondtl_po_no_fk', 'item_no_fk')->distinct()->where('purchaseorder_no_fk', $purchase_order_id)->get()->toArray();

        $filteredArray_dollar = array_filter($po_child_details_info, function ($value) {
            return  strpos($value->currency_sign, 'USD') !== false || strpos($value->currency_sign, 'EUR') !== false;
        });
        // dd($po_child_details_info, $filteredArray_dollar);
        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*,v.approval_level_status_text
        FROM INV_PURCHASEORDER_MST pom
        LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
        LEFT JOIN INV_PO_WL_VW v ON pom.purchaseorder_no_pk = v.purchaseorder_no_pk
        WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];

        // $purchase_orders_terms = DB::table('inv_purchaseorder_terms')
        //     ->where('purchaseorder_no_fk', $purchase_order_id)
        //     ->get();
        //    // dd( $purchase_orders_terms );
        // $terms_arr = [];
        // if (!empty($purchase_orders_terms)) {
        //     foreach ($purchase_orders_terms as $terms) {
        //         $terms_arr[$terms->sl] =  $terms->description;
        //     }
        // }

        // dd( $terms);

        $aproval_counts = DB::table('sysc_approvalmatrixmst')->leftJoin('sysc_approvalmatrixdtl', 'sysc_approvalmatrixdtl.approvalmatrixmst_no_fk', '=', 'sysc_approvalmatrixmst.approvalmatrixmst_no_pk')->select('sysc_approvalmatrixdtl.approval_sequnece', 'sysc_approvalmatrixmst.no_of_level')->where('sysc_approvalmatrixmst.approval_for_code', "PO")->where('person_no_fk', Session::get('user.ses_person_no_fk'))->first();

        $aproval_count = '';
        // dd($aproval_count);
        if (!empty($aproval_counts)) {
            $aproval_count = $aproval_counts->approval_sequnece == $aproval_counts->no_of_level ? $aproval_counts->approval_sequnece : '';
        }
        // dd($aproval_count);
        return  Template::loadView(
            "admin.uhl.inventory.create-purchase-order",
            [
                'main_store_list' => $main_store_list,
                'supplier_arr' => $supplier_arr,
                'poTerms' => $poTerms,
                'po_child_details_info' => $po_child_details_info,
                'po_master_info' => $po_master_info,
                'terms' => $terms,
                'aproval_count' => $aproval_count,
                'filteredArray_dollar' => $filteredArray_dollar,
                'po_map' => json_encode($po_map),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pharmacylastSupplierPurchaseOrderItems(Request $request)
    {

        $supplier_id = strtoupper($request->supplier_id);
        $supplier_purchase_order = DB::table('inv_po_wl_vw')
            ->where('supplier_no_fk', $request->supplier_id)
            ->where('module_code', "PHR")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('purchaseorder_no_pk', 'desc')->get();

        //$last_purchase_order = $supplier_purchase_order-1;

        return Template::loadView("admin.uhl.inventory.last_purchase_order_data", ['supplier_purchase_order' => $supplier_purchase_order]);
    }
    public function populateDefaultItemsFromLastPurchase(Request $request)
    {
        $purchase_order = implode(",", $request->purchase_order);


        $item_arr = [];

        $purchaseItem = DB::table('inv_purchaseorder_item_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_purchaseorder_item_vw.item_no_fk')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_purchaseorder_item_vw.item_no_fk')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_purchaseorder_item_vw.*', 'inv_purchaseorder_item_vw.item_no_fk as req_item_no_fk', 'sysc_serviceitem.purchase_price')
            ->whereIn('purchaseorder_no_pk', $request->purchase_order)
            ->get();

        //dd($purchaseItem);

        $item_neww_arr = [];

        foreach ($purchaseItem as $item) {
            $item_arr[] = [
                'req_item_no_fk' => $item->req_item_no_fk,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'lpqty' => $item->lpqty,
                'lpp' => $item->lpp,
                'lpd' => $item->lpd,
                'uom_name' => $item->uom_name,
                'uom_no_fk' => $item->uom_no_fk,
                'pr_uom_tradeprice' => $item->purchase_price,
                'pr_uom_conversion_qty' => $item->pr_uom_conversion_qty,

            ];
        }

        $item_unique_arr = array_unique($item_arr, SORT_REGULAR);

        foreach ($item_unique_arr as $item_single) {
            $item_neww_arr[] = [
                'req_item_no_fk' => $item_single['req_item_no_fk'],
                'item_code' => $item_single['item_code'],
                'item_name' => $item_single['item_name'],
                'lpqty' => $item_single['lpqty'],
                'lpp' => $item_single['lpp'],
                'lpd' => $item_single['lpd'],
                'uom_name' => $item_single['uom_name'],
                'uom_no_fk' => $item_single['uom_no_fk'],
                'pr_uom_tradeprice' => $item_single['pr_uom_tradeprice'],
                'pr_uom_conversion_qty' => $item_single['pr_uom_conversion_qty'],

            ];
        }

        //dd(array_unique($item_arr, SORT_REGULAR));
        //$item_collection = collect(array_unique($item_arr, SORT_REGULAR));
        //dd($item_collection);

        return response()->json(['data' => $item_neww_arr], 200);
    }


    public function pharmacydefaultSupplierItems(Request $request)
    {

        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $items = DB::table('default_item_stock_vw')
            ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->where('supplier_pk_no',  $request->supplier_id)
            //->where('module_code', "PHR")
            // ->whereNotNull('module_code')
            ->orderBy('item_name', 'asc')
            ->get();

        // dd($items);

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        if ($request->has('search_category')) {
            return Template::loadview('admin.uhl.inventory.default_search_items', [
                // 'items' => $query->get()->toArray(),

            ]);
        }
        return Template::loadview('admin.uhl.inventory.default_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function indentItems(Request $request)
    {
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        // $pr_date_to =  date('Y-m-d', strtotime(date('Y-m-d'), ' + 15days'));
        $date = new DateTime();
        $date->modify('-15 days');
        $pr_date_from = $date->format('Y-m-d');
        $pr_date_to = date('Y-m-d');
        //   dd($pr_date_from, $pr_date_to);
        // inv_requisition_no_pk
        $items = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftjoin('phr_itemreceivemst_pr_cnt', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'phr_itemreceivemst_pr_cnt.inv_requisition_po_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null)
            ->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [$pr_date_from, $pr_date_to])
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
            ->get();
        // dd( $items);

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        return Template::loadview('admin.uhl.inventory.indent_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function searchPrItem(Request $request)
    {
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $pr_date_from = $request->pr_date_from != "" ? date('Y-m-d', strtotime($request->pr_date_from)) : '';
        $pr_date_to = $request->pr_date_to != "" ? date('Y-m-d', strtotime($request->pr_date_to)) : '';
        $pr_no = $request->pr_no != "" ? $request->pr_no : '';

        if ($pr_date_from == '' && $pr_date_to == '' && $pr_no) {
            $items = [];
        }
        // dd($pr_date_from  ,$pr_date_to );
        $item = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftjoin('phr_itemreceivemst_pr_cnt', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'phr_itemreceivemst_pr_cnt.inv_requisition_po_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk');

        if ($pr_date_from != '' && $pr_date_to != '') {
            //$item->where(DB::raw('trunc(inv_requisition_po_itm_vw.inv_requisition_po_date) between  "'.$pr_date_from.'" and "'.$pr_date_to.'"') );
            $item->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [$pr_date_from, $pr_date_to]);
        }

        if($pr_no != ""){
            $item->where("inv_requisition_po_itm_vw.inv_requisition_po_no_pk", $pr_no );
        }
        // ->where('supplier_pk_no',  $request->supplier_id)
        $items = $item->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null)
            ->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
            ->get()->toArray();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        return Template::loadview('admin.uhl.inventory.indent_items_table', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            //'item_categories' => $request->item_categories,
            // 'allSuppliers' => $allSuppliers,
            // 'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function prPoPostItem()
    {
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $items = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->where('po_ind', 1)
            ->whereDate('po_at', date('Y-m-d'))
            // ->where('req_ind', 1)
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisitiondtl_no_pk', 'asc')
            ->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        // $sub_store_list = DB::table('SYSC_SERVICEUNIT')
        //     ->select('*')
        //     // ->where('hospital_store_ind', '=', 1)
        //     ->where('main_store_ind', '=', 1)
        //     ->whereOr('sub_store_ind', '=', 1)
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        return Template::loadview('admin.uhl.inventory.pr_po_post_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            'main_store_list' => $main_store_list,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            // 'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function prBeforePoPostItem()
    {
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $items = DB::table('inv_req_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_req_po_itm_vw.item_no_fk')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_req_po_itm_vw.*', 'inv_req_po_itm_vw.item_no_fk as req_item_no_fk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->where('po_ind', null)
            // ->whereDate('inv_requisition_po_date', date('Y-m-d'))
            // ->where('req_ind', 1)
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisitiondtl_no_pk', 'asc')
            ->get();

        //   dd(5);
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        // $sub_store_list = DB::table('SYSC_SERVICEUNIT')
        //     ->select('*')
        //     // ->where('hospital_store_ind', '=', 1)
        //     ->where('main_store_ind', '=', 1)
        //     ->whereOr('sub_store_ind', '=', 1)
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        return Template::loadview('admin.uhl.inventory.pr_before_po_post_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            'main_store_list' => $main_store_list,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            // 'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function searchPrBeforePoPostItem(Request $request)
    {
        $store_id = $request->sub_store_id;
        $item_id = $request->item_id;
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $items = DB::table('inv_req_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_req_po_itm_vw.item_no_fk')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_req_po_itm_vw.*', 'inv_req_po_itm_vw.item_no_fk as req_item_no_fk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->where('po_ind', null)
            // ->whereDate('po_at', date('Y-m-d'))
            // ->where('req_ind', 1)
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisitiondtl_no_pk', 'asc');

        if ($store_id != "") {
            $items->where('inv_req_po_itm_vw.main_store_su_no_fk', $store_id);
        }
        if ($item_id != "") {
            $items->where('inv_req_po_itm_vw.item_no_fk', $item_id);
        }



        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $sub_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->whereOr('sub_store_ind', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadview('admin.uhl.inventory.pr_before_po_post_items_table', [
            //'items' => $query->get()->toArray(),
            'items' => $items->get(),
            'sub_store_list' => $sub_store_list,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            // 'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function searchPrPoPostItem(Request $request)
    {
        $store_id = $request->sub_store_id;
        $item_id = $request->item_id;
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $items = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->where('po_ind', 1)
            // ->whereDate('po_at', date('Y-m-d'))
            // ->where('req_ind', 1)
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisitiondtl_no_pk', 'asc');

        if ($store_id != "") {
            $items->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $store_id);
        }
        if ($item_id != "") {
            $items->where('inv_requisition_po_itm_vw.item_no_fk', $item_id);
        }



        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $sub_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->whereOr('sub_store_ind', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadview('admin.uhl.inventory.pr_po_post_items_table', [
            //'items' => $query->get()->toArray(),
            'items' => $items->get(),
            'sub_store_list' => $sub_store_list,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            // 'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function populateDefaultItems(Request $request)
    {

        $purchaseItem = DB::table('default_item_stock_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'default_item_stock_vw.item_no_pk')
            ->select('default_item_stock_vw.*', 'sysc_serviceitem_inv_vw.*', 'default_item_stock_vw.item_no_pk as dutault_item_no')
            ->whereIn('item_no_pk',  $request->item_no_pk)
            // ->whereNotNull('module_code')
            ->get();
        // dd($purchaseItem);
        return response()->json($purchaseItem);
    }

    public function item_finalize_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['po_save_option', '=', "POST"],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')],
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();
        //dd($all_purchased_orders_worklists);
        return Template::loadview("admin.uhl.inventory.item_finalize_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function item_issue_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $all_purchased_orders_worklists_arr =  DB::select("SELECT
            PURCHASEORDER_NO_PK,
            vat_amount_itm,
            discount_amount_itm,
            purchase_date,
            supplier_name,
            total_qty,
            vat_percent,
            vat_amount,
            discount_percent,
            discount_amount,
            total_amount,
            po_save_option,
            PO_NO,
            SUM (ORDER_QTY) total_ORDER_QTY,
            SUM (DELIVERED_QTY) total_DELIVERED_QTY
            FROM    INV_PO_WL_VW
                    LEFT JOIN
                    (  SELECT PO_NO,
                                ITEM_NO_FK,
                                ORDER_QTY,
                                SUM (NVL (DELIVERED_QTY, 0)) AS DELIVERED_QTY
                            FROM PHR_GRN_VW
                        WHERE NVL (ORDER_QTY, 0) != 0 AND NVL (DELIVERED_QTY, 0) != 0
                        GROUP BY PO_NO, ITEM_NO_FK, ORDER_QTY
                        ORDER BY PO_NO DESC) subquery
                    ON SUBQUERY.PO_NO = INV_PO_WL_VW.PURCHASEORDER_NO_PK
            WHERE PO_SAVE_OPTION IN ('ISSUE', 'POST')
            GROUP BY INV_PO_WL_VW.PURCHASEORDER_NO_PK,
            vat_amount_itm,
            discount_amount_itm,
            purchase_date,
            supplier_name,
            total_qty,
            vat_percent,
            vat_amount,
            discount_percent,
            discount_amount,
            total_amount,
            po_save_option,
            PO_NO
            ORDER BY PURCHASEORDER_NO_PK DESC");
        $all_purchased_orders_worklists = [];
        if (!empty($all_purchased_orders_worklists_arr)) {
            foreach ($all_purchased_orders_worklists_arr as $key => $value) {
                if ($value->total_order_qty == null || $value->total_delivered_qty == null || $value->total_order_qty != $value->total_delivered_qty) {

                    $all_purchased_orders_worklists[] = (object)[
                        'purchaseorder_no_pk' => $value->purchaseorder_no_pk,
                        'vat_amount_itm' => $value->vat_amount_itm,
                        'discount_amount_itm' => $value->discount_amount_itm,
                        'purchase_date' => $value->purchase_date,
                        'supplier_name' => $value->supplier_name,
                        'total_qty' => $value->total_qty,
                        'vat_percent' => $value->vat_percent,
                        'vat_amount' => $value->vat_amount,
                        'discount_percent' => $value->discount_percent,
                        'discount_amount' => $value->discount_amount,
                        'total_amount' => $value->total_amount,
                        'po_save_option' => $value->po_save_option,
                        'po_no' => $value->po_no,
                        'total_order_qty' => $value->total_order_qty,
                        'total_delivered_qty' => $value->total_delivered_qty
                    ];
                }
            }
        }
        // DB::table('inv_po_wl_vw')
        // ->whereIn('po_save_option', ["ISSUE", "POST"])
        // ->where('au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk'))
        // ->join(
        //     DB::raw('(SELECT "PO_NO" FROM "PHR_GRN_VW" WHERE NVL (ORDER_QTY, 0) != 0  and NVL (DELIVERED_QTY, 0) != 0 and NVL (ORDER_QTY, 0) != NVL (DELIVERED_QTY, 0) GROUP BY "PO_NO" ORDER BY "PO_NO" DESC) AS subquery'),
        //     'subquery.PO_NO',
        //     '=',
        //     'inv_po_wl_vw.purchaseorder_no_pk'
        // )
        // ->orderBy('purchaseorder_no_pk', 'desc')
        // ->get();

        // dd($all_purchased_orders_worklists);
        return Template::loadview("admin.uhl.inventory.item_issue_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }

    public function searchPOWorklist(Request $request)
    {
        $query = DB::table('inv_po_wl_vw');

        // dd(date('Y-m-d', strtotime($request->indent_date_from)));
        if (!empty($request->challan_no)) {
            $query->where('purchaseorder_no_pk', $request->challan_no);
        }
        if (!empty($request->save_option)) {
            $query->where('po_save_option', $request->save_option);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('purchase_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        if ($request->type == 1) {

            $query->where([
                ['finalized_ind', '=', 0],
                ['issue_ind', '=', 0],
            ]);

            return Template::loadview("admin.uhl.inventory.item_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->orderByDesc('purchaseorder_no_pk')->get()->toArray(),
            ]);
            // ->where('store_no_fk',Session::get("user.su_pk_no"))
        } else if ($request->type == 2) {
            $query->where([
                ['finalized_ind', '=', 1],
                ['issue_ind', '=', 0],
            ]);



            return Template::loadview("admin.uhl.inventory.item_finalize_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->orderByDesc('purchaseorder_no_pk')->get()->toArray(),
            ]);
        } else if ($request->type == 3) {
            if (!empty($request->challan_no)) {
                $query->where('purchaseorder_no_pk', $request->challan_no);
            }
            if (!empty($request->supplier_id)) {
                $query->where('supplier_no_fk', $request->supplier_id);
            }

            $cluse = "and";
            $squl = $cluse != "" && $request->supplier_id != "" ? "$cluse supplier_no_fk = $request->supplier_id" : '';
            $squl .= $cluse != "" && $request->challan_no != "" ? " $cluse purchaseorder_no_pk = $request->challan_no" : '';


            // dd( $squl);
            // $query->whereIn('po_save_option', ['ISSUE', 'POST']);
            $all_purchased_orders_worklists_arr =  DB::select("SELECT
            PURCHASEORDER_NO_PK,
            vat_amount_itm,
            discount_amount_itm,
            purchase_date,
            supplier_name,
            total_qty,
            vat_percent,
            vat_amount,
            discount_percent,
            discount_amount,
            total_amount,
            po_save_option,
            PO_NO,
            SUM (ORDER_QTY) total_ORDER_QTY,
            SUM (DELIVERED_QTY) total_DELIVERED_QTY
            FROM    INV_PO_WL_VW
                    LEFT JOIN
                    (  SELECT PO_NO,
                                ITEM_NO_FK,
                                ORDER_QTY,
                                SUM (NVL (DELIVERED_QTY, 0)) AS DELIVERED_QTY
                            FROM PHR_GRN_VW
                        WHERE NVL (ORDER_QTY, 0) != 0 AND NVL (DELIVERED_QTY, 0) != 0
                        GROUP BY PO_NO, ITEM_NO_FK, ORDER_QTY
                        ORDER BY PO_NO DESC) subquery
                    ON SUBQUERY.PO_NO = INV_PO_WL_VW.PURCHASEORDER_NO_PK
            WHERE PO_SAVE_OPTION IN ('ISSUE', 'POST')
            $squl
            GROUP BY INV_PO_WL_VW.PURCHASEORDER_NO_PK,
            vat_amount_itm,
            discount_amount_itm,
            purchase_date,
            supplier_name,
            total_qty,
            vat_percent,
            vat_amount,
            discount_percent,
            discount_amount,
            total_amount,
            po_save_option,
            PO_NO
            ORDER BY PURCHASEORDER_NO_PK DESC");
            $all_purchased_orders_worklists = [];
            if (!empty($all_purchased_orders_worklists_arr)) {
                foreach ($all_purchased_orders_worklists_arr as $key => $value) {
                    if ($value->total_order_qty == null || $value->total_delivered_qty == null || $value->total_order_qty != $value->total_delivered_qty) {
                        $all_purchased_orders_worklists[] = (object)[
                            'purchaseorder_no_pk' => $value->purchaseorder_no_pk,
                            'vat_amount_itm' => $value->vat_amount_itm,
                            'discount_amount_itm' => $value->discount_amount_itm,
                            'purchase_date' => $value->purchase_date,
                            'supplier_name' => $value->supplier_name,
                            'total_qty' => $value->total_qty,
                            'vat_percent' => $value->vat_percent,
                            'vat_amount' => $value->vat_amount,
                            'discount_percent' => $value->discount_percent,
                            'discount_amount' => $value->discount_amount,
                            'total_amount' => $value->total_amount,
                            'po_save_option' => $value->po_save_option,
                            'po_no' => $value->po_no,
                            'total_order_qty' => $value->total_order_qty,
                            'total_delivered_qty' => $value->total_delivered_qty
                        ];
                    }
                }
            }

            return Template::loadview("admin.uhl.inventory.item_issue_po_worklist_table", [
                'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            ]);
        }
    }


    public function purchaseOrderPrint($purchase_order_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set('max_execution_time',0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*,pov.approval_status_text,pov.approval_level_status_text, fnc_poheader($purchase_order_id) poheader
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];

        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*,d.dollar_ind
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.item_barcode

                "));

        $dollar_euro = '';
        $dollar_rate = 0;
        if (!empty($po_child_details_info)) {
            foreach ($po_child_details_info as  $value) {

                if ($value->dollar_ind == 1) {
                    $dollar_euro = '1';
                    $dollar_rate = $value->dollar_rate . '_' . $value->currency_sign;

                    break;
                } elseif ($value->dollar_ind == 2) {
                    $dollar_euro = '2';
                    $dollar_rate = $value->dollar_rate . '_' . $value->currency_sign;
                    break;
                }
            }
        }
        //    dd($dollar_rate);
        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                        // ->orderBy('purchaseorder_terms_no_pk', 'asc')
                        ->orderBy('sl', 'asc')->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        // return view("admin.store.purchase_order_print", [
        //     'purchase_order_id' => $purchase_order_id,
        //     'po_master_info' => $po_master_info,
        //     'po_child_details_info' => $po_child_details_info,
        //     'userInfo' => $userInfo,
        //     'po_hospital_details' => $po_hospital_details,
        //     'invoice_barcode' => $invoice_barcode,
        //     'terms' =>   $terms
        // ]);
        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;
        //$signed_user =DB::select("select prepared_by_name,passed_by_name,approved_by_name from comparative_statement_vw");
        //dd($signed_user);


        // $pdf = PDF::loadView("admin.uhl.inventory.purchase_order_print", [
        //     'purchase_order_id' => $purchase_order_id,
        //     'po_master_info' => $po_master_info,
        //     'po_child_details_info' => $po_child_details_info,
        //     'userInfo' => $userInfo,
        //     'po_hospital_details' => $po_hospital_details,
        //     'invoice_barcode' => $invoice_barcode,
        //     'terms' =>   $terms,
        //     'signed_user' => $signed_user,
        //     'dollar_euro' => $dollar_euro,
        //     'dollar_rate_currency' => $dollar_rate,
        // ]);
        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
            ->get();
        if (Session::get('user.ses_hospital_code') != 'EWMCH') {

            $pdf = PDF::loadView("admin.uhl.inventory.purchase_order_print", [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'dollar_euro' => $dollar_euro,
                'dollar_rate_currency' => $dollar_rate,
                'signature_data' => $signature_data,
            ]);
        } else {
            $pdf = PDF::loadView("admin.uhl.inventory.purchase_order_new_print", [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'dollar_euro' => $dollar_euro,
                'dollar_rate_currency' => $dollar_rate,
                'signature_data' => $signature_data,
            ]);
        }


        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        // Will show this line to the bottom left side of the pdf
        $canvas->page_text(42, 822, "Prepared By: $userInfo->user_fullname. Printing Date & Time: " . date('d/m/Y') . " Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        // $canvas->page_text(482, 820, "Powered By: NEXTGEN IT", 10, 7, array(0, 0, 0));

        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function purchaseOrderPrintWithMD($purchase_order_id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        // $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*,pov.approval_status_text,pov.approval_level_status_text, fnc_poheader($purchase_order_id) poheader
        //         FROM INV_PURCHASEORDER_MST pom
        //         LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
        //         LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
        //         WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];



        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*, store.pharmacy_ind ,pov.approval_status_text,pov.approval_level_status_text, fnc_poheader($purchase_order_id) poheader
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                LEFT JOIN sysc_serviceunit store ON store.serviceunit_no_pk = pom.store_no_fk
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));

        if(count($po_master_info) > 0){
            $po_master_info = $po_master_info[0];
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*,d.dollar_ind
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.item_barcode

                "));
        $dollar_euro = '';
        $dollar_rate = 0;
        if (!empty($po_child_details_info)) {
            foreach ($po_child_details_info as  $value) {

                if ($value->dollar_ind == 1) {
                    $dollar_euro = '1';
                    $dollar_rate = $value->dollar_rate . '_' . $value->currency_sign;

                    break;
                } elseif ($value->dollar_ind == 2) {
                    $dollar_euro = '2';
                    $dollar_rate = $value->dollar_rate . '_' . $value->currency_sign;
                    break;
                }
            }
        }
        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                        // ->orderBy('purchaseorder_terms_no_pk', 'asc')
                        ->orderBy('sl', 'asc')->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }
        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
            ->get();

        $md_information = DB::table('hrms_personnel')->select('full_name')->where('person_code','MD')->first();

        $pdf = PDF::loadView("admin.uhl.inventory.purchase_order_print_with_md", [
            'purchase_order_id' => $purchase_order_id,
            'po_master_info' => $po_master_info,
            'po_child_details_info' => $po_child_details_info,
            'userInfo' => $userInfo,
            'po_hospital_details' => $po_hospital_details,
            'invoice_barcode' => $invoice_barcode,
            'terms' =>   $terms,
            'signed_user' => $signed_user,
            'dollar_euro' => $dollar_euro,
            'dollar_rate_currency' => $dollar_rate,
            'signature_data' => $signature_data,
            'md_information' => $md_information
        ]);

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

        // Will show this line to the bottom left side of the pdf
        $canvas->page_text(42, 822, "Prepared By: $userInfo->user_fullname. Printing Date & Time: " . date('d/m/Y') . " Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        // $canvas->page_text(482, 820, "Powered By: NEXTGEN IT", 10, 7, array(0, 0, 0));

        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function purchaseOrderPrintWithMDV2($purchase_order_id)
    {
        ini_set('max_execution_time',0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*, store.pharmacy_ind ,pov.approval_status_text,pov.approval_level_status_text, fnc_poheader($purchase_order_id) poheader
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                LEFT JOIN sysc_serviceunit store ON store.serviceunit_no_pk = pom.store_no_fk
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));

        if(count($po_master_info) > 0){
            $po_master_info = $po_master_info[0];
        }



        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*, sg.generic_name, d.dollar_ind,curr.currency_code,curr.currency_name
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                LEFT JOIN sysc_generic sg ON sg.GENERIC_NO_PK = d.GENERIC_NO_FK
                left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                left join sysc_currency curr on poc.CURRENCY_NO_FK  = curr.currency_no_pk
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.purchaseorderdtl_no_pk asc

                "));


        $curr_rate = isset($po_child_details_info[0]->dollar_rate) ? $po_child_details_info[0]->dollar_rate : 0;

        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                        ->orderBy('purchaseorder_terms_no_pk', 'asc')
                        ->orderBy('sl', 'asc')
                        ->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

        $signature_data = DB::table('sysc_approvalprocess_vw')
                        ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
                        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                        ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                        ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
                        ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
                        ->get();
        $md_information = DB::table('hrms_personnel')->select('full_name')->where('person_code','MD')->first();
        $pdf = PDF::loadView("admin.inventory.v1.po.purchase_order_print_v2_with_md", [
                'md_information' => $md_information,
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'curr_rate' => $curr_rate,
                'signature_data' => $signature_data,
            ]);



        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream("purchase_order_print_".$purchase_order_id.".pdf", array("Attachment" => false));
    }


    public function poIssueFinalize(Request $request)
    {
        try {
            if ($request->issue_finalize_ind == "finalize") {
                if (!empty($request->purchase_order_pk_no)) {
                    for ($i = 0; $i < count($request->purchase_order_pk_no); $i++) {
                        $purchase_order = PurchaseOrderMaster::find($request->purchase_order_pk_no[$i]);
                        $purchase_order->finalized_ind = 1;
                        $purchase_order->finalized_by = Auth::id();
                        $purchase_order->finalized_at = date('Y/m/d');
                        $purchase_order->au_entry_hospital_no_fk = Session::get('user.ses_hospital_no_pk');
                        $purchase_order->save();
                    }
                    $message = ['msg' => 'PO Finalized Successfully', 'title' => 'Success'];
                }
            }
            if ($request->issue_finalize_ind == "issue") {
                if (!empty($request->purchase_order_pk_no)) {
                    for ($i = 0; $i < count($request->purchase_order_pk_no); $i++) {
                        $purchase_order = PurchaseOrderMaster::find($request->purchase_order_pk_no[$i]);
                        $purchase_order->finalized_ind = 1;
                        $purchase_order->finalized_by = Auth::id();
                        $purchase_order->finalized_at = date('Y/m/d');
                        $purchase_order->au_entry_hospital_no_fk = Session::get('user.ses_hospital_no_pk');
                        $purchase_order->issue_ind = 1;
                        $purchase_order->issue_by = Auth::id();
                        $purchase_order->issue_at = date('Y/m/d');
                        $purchase_order->save();
                    }
                    $message = ['msg' => 'PO Issued Successfully', 'title' => 'Success'];
                }
            }
        } catch (\Exception $e) {
            $message = ['msg' => 'PO Finalize Failed', 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function deletePO(Request $request)
    {
        $po_id = $request->po_id;

        try {
            DB::table('inv_purchaseorder_chd')->where('purchaseorder_no_fk', $po_id)->delete();
            DB::table('inv_purchaseorder_terms')->where('purchaseorder_no_fk', $po_id)->delete();
            DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $po_id)->delete();

            $message = ['msg' => '000'];
        } catch (\Exception $e) {
            $message = ['msg' => '999'];
        }
        return response()->json($message);
    }


    public function getTermsCondition(Request $request)
    {
        $store_id = $request->store_id;
        if ($store_id == null) {
            $terms = [];
            $head_arr = [];
            return response()->json(['terms_header' => $head_arr, 'terms' => $terms], 200);
        }
        $terms_header_unique = [];
        $terms_header = DB::table('sysc_termscondition')
            ->where('supplier_no_fk', $store_id)
            // ->where('store_su_no_fk', $store_id)
            ->whereNotNull('termscon_header')
            ->orderBy('header_sl', 'asc')->orderBy('terms_sl', 'asc')->get()->toArray();


        foreach (array_unique($terms_header, SORT_REGULAR) as $terms_head) {
            array_push($terms_header_unique, $terms_head->termscon_header);
        }


        $terms = DB::table('sysc_termscondition')
            ->whereNotNull('termscon_header')
            ->where('supplier_no_fk', $store_id)
            // ->where('store_su_no_fk', $store_id)
            ->orderBy('header_sl', 'asc')->orderBy('terms_sl', 'asc')->get();



        $head_arr = [];
        foreach (array_unique($terms_header_unique, SORT_REGULAR) as $header) {
            $head_arr[] = $header;
        }
        //dd($head_arr,$terms);
        return response()->json(['terms_header' => $head_arr, 'terms' => $terms], 200);
    }

    public function get_all_terms_condition()
    {
        $terms = DB::table('sysc_termscondition')->where('status', 1)->get()->toArray();
        // dd($terms);
        return Template::loadview("admin.uhl.inventory.terms_condition", [
            'terms' => $terms,
        ]);
    }
    public function get_default_terms_condition()
    {
        // $terms = DB::table('sysc_termscondition')->where('default_terms_ind',1)->where('status', 1)->get()->toArray();
        $terms_header_unique = [];
        $terms_header = DB::table('sysc_termscondition')
            ->where('default_terms_ind',1)
            ->where('status', 1)
            ->whereNotNull('termscon_header')
            ->orderBy('header_sl', 'asc')->orderBy('terms_sl', 'asc')->get()->toArray();


        foreach (array_unique($terms_header, SORT_REGULAR) as $terms_head) {
            array_push($terms_header_unique, $terms_head->termscon_header);
        }


        $terms = DB::table('sysc_termscondition')
            ->whereNotNull('termscon_header')
            ->where('default_terms_ind',1)
            ->where('status', 1)
            ->orderBy('header_sl', 'asc')->orderBy('terms_sl', 'asc')->get();



        $head_arr = [];
        foreach (array_unique($terms_header_unique, SORT_REGULAR) as $header) {
            $head_arr[] = $header;
        }
        //dd($head_arr,$terms);
        return response()->json(['terms_header' => $head_arr, 'terms' => $terms], 200);

    }


    function POWorklistPrint(Request $request)
    {
        $query = DB::table('inv_po_wl_vw');

        if (!empty($request->challan_no)) {
            $query->where('purchaseorder_no_pk', $request->challan_no);
        }
        if (!empty($request->save_option)) {
            $query->where('po_save_option', $request->save_option);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('purchase_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        if ($request->type == 1) {
            $query->where([
                ['finalized_ind', '=', 0],
                ['issue_ind', '=', 0],
            ]);
            $all_purchased_orders_worklists = $query->orderBy('purchase_date', 'asc')->get()->toArray();


            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

            $pdf = PDF::loadView("admin.uhl.inventory.item_po_worklist_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'all_purchased_orders_worklists' => $all_purchased_orders_worklists])->setPaper('a4', 'potrait');
            return $pdf->stream('PO.pdf');
        }
    }


    function POWorklistExcel(Request $request)
    {
        $query = DB::table('inv_po_wl_vw');

        if (!empty($request->challan_no)) {
            $query->where('purchaseorder_no_pk', $request->challan_no);
        }
        if (!empty($request->save_option)) {
            $query->where('po_save_option', $request->save_option);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('purchase_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('purchase_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        if ($request->type == 1) {
            $query->where([
                ['finalized_ind', '=', 0],
                ['issue_ind', '=', 0],
            ]);
            $all_purchased_orders_worklists = $query->orderBy('purchase_date', 'asc')->get()->toArray();

            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'all_purchased_orders_worklists' => $all_purchased_orders_worklists];
            $fileToExport = "Purchase Order";
            $html = View("admin.uhl.inventory.item_po_worklist_excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }



    /*Purchase Order V1 */

    public function getSupplier(){
        $supplier_arr =  DB::table('INV_SUPPLIER')
                        ->select('supplier_no_pk','supplier_uid','supplier_name','company_name','status')
                        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                        ->orderByRaw("lower(supplier_name) asc")
                        ->distinct('supplier_name','company_name')
                        ->where('status', 1)
                        ->get();
        return $supplier_arr;
    }

    public function mainStore(){
       $store = DB::table('sysc_v1_grant_servieceunit_vw')
                    ->select('serviceunit_no_pk','grantsu_no_pk','full_name','serviceunit_name','serviceunit_code','status')
                    ->distinct()
                    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                    ->where('main_store_ind', '=', 1)
                    ->where('user_no_pk', '=', Auth::user()->user_no_pk)
                    ->orderByRaw("lower(serviceunit_name) asc")
                    ->where('status', 1)
                    ->get();
        return $store;
    }

    public function purchaseOrderV2()
    {
        $allSuppliers = $this->getSupplier();
        $main_store_list = $this->mainStore();
        $terms =  $this->getLookupListByCode("PHR_POTERMS");
        $currency = $this->getCurrency();
        return  Template::loadView("admin.inventory.v1.po.create_po_v1", compact('allSuppliers','main_store_list','terms','currency'));
    }
    public function purchaseOrderNewV2()
    {
        $allSuppliers = $this->getSupplier();
        $main_store_list = $this->mainStore();
        $terms =  $this->getLookupListByCode("PHR_POTERMS");
        $currency = $this->getCurrency();
        return  Template::loadView("admin.inventory.v1.po.create_po_v2", compact('allSuppliers','main_store_list','terms','currency'));
    }

    public function editPOV2($purchase_order_id){
        $allSuppliers = $this->getSupplier();
        $main_store_list = $this->mainStore();
        $terms =  $this->getLookupListByCode("PHR_POTERMS");
        $currency = $this->getCurrency();

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $term = DB::table("inv_purchaseorder_terms")
                    ->where("purchaseorder_no_fk", $purchase_order_id)
                    ->orderBy('purchaseorder_terms_no_pk', 'asc')
                    ->orderBy('sl', 'asc')
                    ->get();

        $poTerms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $poTerms[$value->termscon_header][] = $value;
            }
        }


        $po_child_details_info = DB::select(DB::raw("
                                        SELECT poc.*,
                                        l.*,
                                        i.*,
                                        u.*,
                                        poc.item_no_fk as req_item_no_fk

                                        FROM INV_PURCHASEORDER_CHD poc
                                        LEFT JOIN sysc_serviceitem_inv_vw l ON poc.ITEM_NO_FK = l.ITEM_NO_FK
                                        LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                                        LEFT JOIN sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk

                                        WHERE
                                        poc.PURCHASEORDER_NO_FK = $purchase_order_id
                                        order By poc.purchaseorderdtl_no_pk
                                    "));

        foreach ($po_child_details_info as $key => $item) {

            $value = DB::table('INV_REQUISITION_PO_ITM_VW')
                                ->where('ITEM_NO_FK', $item->item_no_fk)
                                ->where('inv_requisition_po_no_pk', $item->item_requisition_no_fk)
                                ->selectRaw('nvl(req_quantity,0) - nvl(already_po_qty,0) as remaining_quantity')
                                ->value('remaining_quantity');

            $item->avail_qty = $value != 0 ? $value : $item->entry_qty;
        }

        // dd($po_child_details_info);
        $po_map = DB::table('inv_purchaseorder_pr_req_map')->select('inv_requisitiondtl_po_no_fk', 'item_no_fk')->distinct()->where('purchaseorder_no_fk', $purchase_order_id)->get()->toArray();

        $po_master_info = DB::select(DB::raw("
                                        SELECT s.*,
                                        pom.*,
                                        v.approval_level_status_text
                                        FROM INV_PURCHASEORDER_MST pom
                                        LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                                        LEFT JOIN INV_PO_WL_VW v ON pom.purchaseorder_no_pk = v.purchaseorder_no_pk
                                        WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id
                                    "))[0];

        // dd($po_master_info);

        $aproval_counts = DB::table('sysc_approvalmatrixmst')->leftJoin('sysc_approvalmatrixdtl', 'sysc_approvalmatrixdtl.approvalmatrixmst_no_fk', '=', 'sysc_approvalmatrixmst.approvalmatrixmst_no_pk')->select('sysc_approvalmatrixdtl.approval_sequnece', 'sysc_approvalmatrixmst.no_of_level')->where('sysc_approvalmatrixmst.approval_for_code', "PO")->where('person_no_fk', Session::get('user.ses_person_no_fk'))->first();
        $aproval_count = '';

        if (!empty($aproval_counts)) {
            $aproval_count = $aproval_counts->approval_sequnece == $aproval_counts->no_of_level ? $aproval_counts->approval_sequnece : '';
        }

        return Template::loadView("admin.inventory.v1.po.edit_po_v1",
                compact('allSuppliers','main_store_list','terms','currency','poTerms','po_child_details_info','po_map','po_master_info','purchase_order_id')
        );
    }

    public function getCurrency(){
        $curr_data = DB::table('sysc_currency')->select('currency_no_pk','rate','currency_code','status')->where('status',1)->get();
        return $curr_data;
    }

    public function getStoreWiseItem($store_id){
        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                's.model_info',
                's.dollar_ind',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            )
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)

            ->where('l.mainstore_su_no_fk', 'PHARMACY')

            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $su_no_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];
    }

    public function getTermsConditions(Request $request){
        try {
            $storePharmacyInd=DB::table('sysc_serviceunit')->where('serviceunit_no_pk',$request->storeId)->value('pharmacy_ind');

            $terms_condition = DB::table('sysc_termscondition');
            if($request->ind == 1){
                $terms_condition->where('default_terms_ind',1);
            }

            if ( $storePharmacyInd==1 && in_array(Session::get('user.ses_hospital_code'),["UNICO","KPJ"])) {
                $terms_condition->where('store_su_no_fk',$request->storeId);
                //  dd(Session::get('user.ses_hospital_code'),$request->storeId);
            }else{
                $storePharmacyId=DB::table('sysc_serviceunit')->where('pharmacy_ind', 1)->pluck('serviceunit_no_pk');
                $terms_condition->whereNotIn('store_su_no_fk',$storePharmacyId);
            }
            $terms_condition = $terms_condition->where('status', 1)
                                ->select('termscon_no_pk','termscon_header','termscon_text1','termscon_text2','terms_sl')
                                ->whereNotNull('termscon_header')

                                ->orderBy('header_sl', 'asc')->orderBy('terms_sl', 'asc')->get()->toArray();
            // dd($terms_condition);
            return response()->json(['data'=> $terms_condition,'sucess' =>true],200);
        } catch (\Throwable $th) {
            return response()->json(['data'=> [],'sucess' =>false], 422);
        }
    }

    public function savePurchaseOrderv2(Request $request){

        $request->validate([
            'po_date' =>'required',
            'delivery_date' =>'required',
            'currency' =>'required',
            'curr_rate' =>'required',
            'main_store_id' =>'required',
            'supplier' =>'required',
            'remarks' =>'max:500',
        ]);

        if(!isset($request->item)){
            return response()->json(['success' => false, 'title' => 'Failed', 'message'=> 'Please Add at least one item'],422);
        }
        try {
            DB::beginTransaction();
            $main_store_module = ServiceUnit::where('serviceunit_no_pk', $request->main_store_id)
                                            ->select('main_store_module_no_fk')
                                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

            $main_store_module = isset($main_store_module->main_store_module_no_fk) ? $main_store_module->main_store_module_no_fk : 0 ;

            $in_au_entry_by = Session::get('user.ses_user_pk_no');
            $in_au_entry_session = 'PO';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $adj_percent = 0;
            $adj_amt = $request->gross_adj_dis_amount;
            $in_discount_percent = $request->gross_discount_percent + $adj_percent;
            $in_discount_amount = $request->gross_discount_amount + $adj_amt;

            $in_refer_no = $request->ref_no;
            $in_refer_sub = $request->subject_details;
            $refer_contact_name = $request->contact_person;
            $refer_contact_mobile = $request->contact_number;
            $refer_contact_email = $request->contact_email;
            $refer_quotation_ref = $request->quotation_ref;
            // $copy_to = $request->copy_to;
            $copy_to = '';

            $in_subject_body = $request->message_body;
            $in_requisition_code = '0';
            $in_req_saveoption = 'DRAFT';
            $numelems = 1000;
            $in_po_no = null;
            $in_po_edit_ind = 0;
            $pdo = DB::getPdo();
            $zero = 0;
            $blank = '';

            $out_purchase_no_pk = 0;
            $out_purchase_uid = 0;
            $out_po_uid = 0;

            $vat_percent = $request->vat_percent;
            $vat_amount = $request->vat_amount;
            $discount_percent = $request->gross_discount_percent;
            $discount_amount = $request->gross_discount_amount;
            $store_id = $request->main_store_id;
            $item_no_fk = $request->item;
            $uom = $request->uom;
            $qty = $request->qty;
            $uPrice = $request->uPrice;
            $terms_sl = $request->terms_sl;
            $tc =  $request->tc;

            $vat_amount_item = $request->vat_percent_amount;
            $discount_percent_item = $request->disPercent;
            $discount_amount_item = $request->disAmount;
            $item_requisition_no_fk = $request->item_requisition_no_fk;
            $item_requisitiondtl_no_fk = $request->item_requisitiondtl_no_pk;
            $item_level_notes = $request->item_level_notes;
            $requisitiondtl_no_pk_list = $request->requisitiondtl_no_pk_list;
            $header_name = $request->header_name;
            $specification = $request->specification;
            $curr_rate = $request->curr_rate;
            $currency = $request->currency;

            $ait_percent_master = $request->gross_ait_percent;
            $ait_amount_master = $request->gross_ait_amount;
            $sc_percent_master = $request->gross_sc_percent;
            $sc_amount_master = $request->gross_sc_amount;

            $ait_percent_child = $request->ait_percent_item;
            $ait_amount_child = $request->ait_percent_amount;

            $sc_percent_child = $request->sc_percent_item;
            $sc_amount_child = $request->sc_percent_amount;
            $in_notes = $request->remarks;


            // dd($request->all());
            $cur_sign = DB::table('sysc_currency')->where('currency_no_pk',$currency)->value('currency_sign');
            $vat_percent_item = [];

            foreach($request->item as $key => $value){
               array_push($vat_percent_item, $request->vat_percent);
            }

            $attachment = "";
            if($request->hasFile('attachment')){
                $files = $request->file('attachment');
                $attachment = date('Ymdhi') . time(). "." . $files->getClientOriginalExtension();
                $request->attachment->move(public_path('/images/uploads/attachment'), $attachment);
            }

            $year = date('Y');
            $item_conversion = $request->item_conversion;

            if(!empty($request->po_date)){
                $dateObject = DateTime::createFromFormat('d/m/Y', $request->po_date);
                $po_date = $dateObject->format('Y-m-d');
            }
            if(!empty($request->delivery_date)){
                $dateObject = DateTime::createFromFormat('d/m/Y', $request->delivery_date);
                $delivery_date = $dateObject->format('Y-m-d');
            }
            $supplier = $request->supplier;
            $purchase_order_entry = $pdo->prepare("begin pkg_v2_inventory_all.prc_generic_po_create_v1(
                                                    :in_purchaseorder_no_pk,
                                                    :in_purchaseorder_edit_ind,
                                                    :in_purchase_date,
                                                    :in_supplier_no_fk,
                                                    :in_item_category,
                                                    :in_fiscal_year,
                                                    :in_vat_percent,
                                                    :in_vat_amount,
                                                    :in_discount_percent,
                                                    :in_discount_amount,
                                                    :in_module_no_fk,
                                                    :in_refer_no,
                                                    :in_refer_sub,
                                                    :in_refer_contact_name,
                                                    :in_refer_contact_mobile,
                                                    :in_refer_contact_email,
                                                    :in_subject_body,
                                                    :in_requisition_no_fk,
                                                    :in_requisition_code,
                                                    :in_store_no_fk,
                                                    :in_notes,
                                                    :in_budget_no_fk,
                                                    :in_po_save_option,
                                                    :in_delivery_date,
                                                    :in_quotation_ref,
                                                    :in_copy_to,
                                                    :in_currency_rate,
                                                    :in_currency_sign,
                                                    :in_po_doc_attach_path,
                                                    :in_currency_no_fk,

                                                    :in_ait_percent,
                                                    :in_ait_amount,
                                                    :in_service_charge_percent,
                                                    :in_service_charge_amount,

                                                    :in_item_no_fk,
                                                    :in_item_barcode,
                                                    :in_pvms_no,
                                                    :in_uom,
                                                    :in_entry_qty,
                                                    :in_item_rate,
                                                    :in_term_number,
                                                    :in_term_text,
                                                    :in_pr_uom_no_fk,
                                                    :in_pr_uom_conversion_qty,
                                                    :in_pr_uom_tradeprice,
                                                    :in_vat_percent_itm,
                                                    :in_vat_amount_itm,
                                                    :in_discount_percent_itm,
                                                    :in_discount_amount_itm,
                                                    :in_item_requisition_no_fk,
                                                    :in_item_level_notes,
                                                    :in_inv_requisitiondtl_no_pk,
                                                    :in_inv_requisitiondtl_no_pk_list,
                                                    :in_termscon_header,
                                                    :in_refer_item_specification,

                                                    :in_ait_percent_itm,
                                                    :in_ait_amount_itm,
                                                    :in_ser_charge_percent_itm,
                                                    :in_ser_charge_amount_itm,

                                                    :in_au_entry_by ,
                                                    :in_au_entry_hospital_no_fk ,
                                                    :in_au_entry_session ,
                                                    :out_purchase_no_pk ,
                                                    :out_purchase_uid,
                                                    :out_error
                                                    ); end;");
            $purchase_order_entry->bindparam('in_purchaseorder_no_pk', $in_po_no);
            $purchase_order_entry->bindparam('in_purchaseorder_edit_ind', $in_po_edit_ind);
            $purchase_order_entry->bindparam('in_purchase_date', $po_date);
            $purchase_order_entry->bindparam('in_supplier_no_fk', $supplier);
            $purchase_order_entry->bindparam('in_item_category', $blank);
            $purchase_order_entry->bindparam('in_fiscal_year', $year);
            $purchase_order_entry->bindparam('in_vat_percent', $vat_percent);
            $purchase_order_entry->bindparam('in_vat_amount', $vat_amount);
            $purchase_order_entry->bindparam('in_discount_percent', $discount_percent);
            $purchase_order_entry->bindparam('in_discount_amount', $discount_amount);
            $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);
            $purchase_order_entry->bindparam('in_refer_no', $in_refer_no);
            $purchase_order_entry->bindparam('in_refer_sub', $in_refer_sub);
            $purchase_order_entry->bindparam('in_refer_contact_name', $refer_contact_name);
            $purchase_order_entry->bindparam('in_refer_contact_mobile', $refer_contact_mobile);
            $purchase_order_entry->bindparam('in_refer_contact_email', $refer_contact_email);
            $purchase_order_entry->bindparam('in_subject_body', $in_subject_body);
            $purchase_order_entry->bindparam('in_requisition_no_fk', $zero);
            $purchase_order_entry->bindparam('in_requisition_code', $in_requisition_code);
            $purchase_order_entry->bindparam('in_store_no_fk', $store_id);
            $purchase_order_entry->bindparam('in_notes', $in_notes);
            $purchase_order_entry->bindparam('in_budget_no_fk', $zero);
            $purchase_order_entry->bindparam('in_po_save_option', $in_req_saveoption);
            $purchase_order_entry->bindparam('in_delivery_date', $delivery_date);

            $purchase_order_entry->bindparam('in_quotation_ref', $refer_quotation_ref);
            $purchase_order_entry->bindparam('in_copy_to', $copy_to);
            $purchase_order_entry->bindparam('in_currency_rate', $curr_rate);
            $purchase_order_entry->bindparam('in_currency_sign', $cur_sign);
            $purchase_order_entry->bindparam('in_po_doc_attach_path',$attachment);
            $purchase_order_entry->bindparam('in_currency_no_fk', $currency);

            $purchase_order_entry->bindparam('in_ait_percent', $ait_percent_master);
            $purchase_order_entry->bindparam('in_ait_amount', $ait_amount_master);
            $purchase_order_entry->bindparam('in_service_charge_percent', $sc_percent_master);
            $purchase_order_entry->bindparam('in_service_charge_amount', $sc_amount_master);

            $purchase_order_entry->bindArray('in_item_no_fk', $item_no_fk, count($item_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_item_barcode', $item_no_fk, count($item_no_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_pvms_no', $item_no_fk, count($item_no_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_uom', $uom, count($uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_entry_qty', $qty, count($qty), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_item_rate', $uPrice, count($uPrice), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_term_number', $terms_sl, count($terms_sl), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_term_text', $tc, count($tc), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_pr_uom_no_fk', $uom, count($uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_conversion_qty', $item_conversion, count($item_conversion), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_tradeprice', $uPrice, count($uPrice), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_percent_itm', $vat_percent_item, count($vat_percent_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_amount_itm', $vat_amount_item, count($vat_amount_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_percent_itm', $discount_percent_item, count($discount_percent_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_amount_itm', $discount_amount_item, count($discount_amount_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_item_requisition_no_fk', $item_requisition_no_fk, count($item_requisition_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_item_level_notes', $item_level_notes, count($item_level_notes), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk', $item_requisitiondtl_no_fk, count($item_requisitiondtl_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk_list', $requisitiondtl_no_pk_list, count($requisitiondtl_no_pk_list), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_termscon_header', $header_name, count($header_name), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_refer_item_specification', $specification, count($specification), $numelems, SQLT_CHR);

            $purchase_order_entry->bindArray('in_ait_percent_itm', $ait_percent_child, count($ait_percent_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ait_amount_itm', $ait_amount_child, count($ait_amount_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ser_charge_percent_itm', $sc_percent_child, count($sc_percent_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ser_charge_amount_itm', $sc_amount_child, count($sc_amount_child), $numelems, SQLT_FLT);


            $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);

            $purchase_order_entry->bindParam('out_purchase_no_pk', $out_purchase_no_pk, PDO::PARAM_INT);
            $purchase_order_entry->bindParam('out_purchase_uid', $out_purchase_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->bindParam('out_error', $out_po_uid, PDO::PARAM_STR, 500);
            // dd( $purchase_order_entry);
            $purchase_order_entry->execute();

            if (Session::get('user.email_send_ind') == 1) {
                if ($in_req_saveoption == "POST") {
                    $approvalMst = DB::table('sysc_approvalmatrixmst')->select('dept_base_approval_ind')->where('approval_for_code', 'PO')->first();
                    $approval_matrix = [];
                    if (!empty($approvalMst) && $approvalMst->dept_base_approval_ind == 1) {
                        $approval_matrix = DB::table('sysc_approvalmatrix_dept_vw')->select('sysc_approvalmatrix_dept_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->where('dept_su_no_fk', Session::get('user.su_pk_no'))->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_dept_vw.person_no_fk')->get()->toArray();
                    } else {
                        $approval_matrix = DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_vw.person_no_fk')->get()->toArray();
                    }

                    if (!empty($approval_matrix)) {
                        $app_arr = [];
                        foreach ($approval_matrix as $key => $value) {
                            $app_arr[$key] = $value->email_personal;
                        }
                        $this->inventoryMail($app_arr, $in_po_no, $value->approval_for_code, Auth::user()->user_fullname);
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved','voucher'=> $out_purchase_no_pk,'title' => 'Success'], 200);
        }
        catch (Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function getPRv2(Request $request){
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $from_date = $request->pr_date_from;
        $to_date = $request->pr_date_to;
        $supplier_no = $request->supplier_no !='' ? $request->supplier_no :$request->supplier_no_filter_pr ;
        $phr_ind=DB::table('sysc_serviceunit')->where('serviceunit_no_pk', $request->store_no)->value('pharmacy_ind');

        $pr_date_from = '';
        $pr_date_to = '';
        if(!empty($from_date)){
            $pr_date_from = DateTime::createFromFormat('d/m/Y', $from_date);
            $pr_date_from = $pr_date_from->format('Y-m-d');
        }
        if(!empty($from_date)){
            $pr_date_to = DateTime::createFromFormat('d/m/Y', $to_date);
            $pr_date_to = $pr_date_to->format('Y-m-d');
        }



        $pr_no = !empty($request->pr_no) ? $request->pr_no : '';
        $store_no = !empty($request->store_no) ? $request->store_no : '';

        $item = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftjoin('phr_itemreceivedtl_pr_cnt', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select(
                'inv_requisition_po_itm_vw.req_at',
                'inv_requisition_po_itm_vw.item_name',
                'inv_requisition_po_itm_vw.req_quantity',
                'inv_requisition_po_itm_vw.already_po_qty',
                'inv_requisition_po_itm_vw.req_by_name',
                'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
                'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk',
                'inv_requisition_po_itm_vw.supplier_pk_no',
                'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk',
                'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk',
                'inv_requisition_itm_vw.req_by_name as indent_req_by_name',
                'inv_requisition_itm_vw.from_store as indent_from_store',
                'sysc_serviceitem.purchasevat_pct as vat_percent',
                'sysc_serviceitem.purchase_price as item_setup_pp',
                'inv_requisition_po_itm_vw.dollar_rate',
                'inv_requisition_po_itm_vw.currency_sign',
                'inv_requisition_po_itm_vw.pr_doc_attachment_path',
                'inv_requisition_itm_vw.inv_requisition_no_pk',
                'inv_requisition_itm_vw.indent_remarks',
                'inv_requisition_itm_vw.item_remarks',
                'inv_requisition_itm_vw.generic_name',
                'inv_requisition_po_itm_vw.item_no_fk',
                'inv_requisition_po_itm_vw.pr_uom_no_fk as uom_no_fk',
                'inv_requisition_po_itm_vw.pr_uom_conversion_qty as conversion_qty',
                'inv_requisition_po_itm_vw.item_pur_uom_name as uom_name',
                'inv_requisition_po_itm_vw.item_purchase_price as purchase_price',
                'sysc_serviceitem_inv_vw.lpp',
                'sysc_serviceitem_inv_vw.lpd',
                'sysc_serviceitem_inv_vw.lpqty',
                'inv_requisition_po_itm_vw.supp_name as supplier_name',
                )->selectRaw("NVL(inv_requisition_po_itm_vw.req_quantity,0) - NVL(inv_requisition_po_itm_vw.already_po_qty,0)  as purchase_qty");

        if ($pr_date_from != '' && $pr_date_to != '') {
            $item->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [$pr_date_from, $pr_date_to]);
        }

        if($pr_no != ""){
            $item->where("inv_requisition_po_itm_vw.inv_requisition_po_no_pk", $pr_no );
        }

        if($store_no != ""){
            $item->where("inv_requisition_po_itm_vw.main_store_su_no_fk", $store_no);
        }

        if($phr_ind == 1 && $supplier_no !=''){
           if ($supplier_no =='null') {
             $item->whereNull("inv_requisition_po_itm_vw.supplier_pk_no");
           }else{
             $item->where("inv_requisition_po_itm_vw.supplier_pk_no",  $supplier_no);
           }

        }
        // elseif($phr_ind == 1 && $supplier_no ==''){
        //     return response()->json(['validation'=> 'select supplier','data' => ''],200);
        // }
        $items =  $item
                ->where('inv_requisition_po_itm_vw.app_status', 1)
                ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null)
                ->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk', 'asc')
                ->get();

                        // whereNull('inv_requisition_po_itm_vw.po_ind')

        return response()->json(['success'=> true,'data' => $items],200);
    }

    public function getDefaultPOv2(Request $request){
        $request->validate([
            'supplier_id' => 'required',
            'type' => 'required',
        ]);

        $items = DB::table('default_item_stock_vw')

                        ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'default_item_stock_vw.item_no_pk')
                        ->select(

                                'default_item_stock_vw.item_no_pk as item_no_fk',
                                'default_item_stock_vw.item_name',
                                'default_item_stock_vw.generic_name',

                                'default_item_stock_vw.re_order_level',
                                'default_item_stock_vw.current_stock',
                                'default_item_stock_vw.pr_uom_tradeprice',
                                'default_item_stock_vw.supplier_pk_no',


                                'default_item_stock_vw.purchase_price',
                                'default_item_stock_vw.pr_uom_conversion_qty as conversion_qty',
                                'default_item_stock_vw.uom_no_fk',
                                'default_item_stock_vw.uom_name',

                                DB::raw('0 as inv_requisition_po_no_pk'),
                                DB::raw('0 as inv_requisitiondtl_po_no_pk'),

                                'sysc_serviceitem_inv_vw.lpp',
                                'sysc_serviceitem_inv_vw.lpd',
                                'sysc_serviceitem_inv_vw.lpqty',
                                'sysc_serviceitem_inv_vw.lpqty as purchase_qty',
                            )



                        ->where('default_item_stock_vw.supplier_pk_no',  $request->supplier_id);
                        if ($request->type == 0) {
                            $items->whereRaw('default_item_stock_vw.current_stock <= default_item_stock_vw.re_order_level');
                        }

        $items =  $items->orderBy('default_item_stock_vw.item_name', 'asc')
                                ->get();


        return response()->json(['success' => true, 'data' => $items],200);
    }

    public function getLastPOV2(Request $request){
        $request->validate([
            'supplier_id' => 'required'
        ]);
        $supplier_id = $request->supplier_id;
        $supplier_purchase_order = DB::table('inv_po_wl_vw')
                                    ->where('supplier_no_fk', $request->supplier_id)
                                    // ->where('module_code', "PHR")
                                    ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                                    ->select('purchase_uid','purchase_date','purchaseorder_no_pk','total_amount','total_qty')
                                    ->selectRaw("supplier_no_fk as supplier_pk_no")
                                    ->orderBy('purchase_date', 'desc')->get();
        return response()->json(['success' => true,'data' => $supplier_purchase_order],200);
    }

    public function getLastPOItemV2(Request $request){
        $item_arr = [];
        $purchaseItem = DB::table('inv_purchaseorder_item_vw')
                        ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_purchaseorder_item_vw.item_no_fk')
                        ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_purchaseorder_item_vw.item_no_fk')
                        ->select('sysc_serviceitem_inv_vw.*', 'inv_purchaseorder_item_vw.*', 'inv_purchaseorder_item_vw.item_no_fk as req_item_no_fk', 'sysc_serviceitem.purchase_price')
                        ->whereIn('purchaseorder_no_pk', $request->choose_last_po)
                        ->get();

        $item_neww_arr = [];
        foreach ($purchaseItem as $item) {
            $item_arr[] = [
                'item_no_fk' => $item->req_item_no_fk,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'generic_name' => $item->generic_name,
                'lpqty' => $item->lpqty,
                'lpp' => $item->lpp,
                'lpd' => $item->lpd,
                'uom_name' => $item->uom_name,
                'uom_no_fk' => $item->uom_no_fk,
                'purchase_price' => $item->purchase_price,
                'conversion_qty' => $item->pr_uom_conversion_qty,
                'purchase_qty' => $item->approved_qty,
                'inv_requisition_po_no_pk' => 0,
                'inv_requisitiondtl_po_no_pk' => 0,
            ];
        }
        $item_unique_arr = array_unique($item_arr, SORT_REGULAR);
        foreach ($item_unique_arr as $item_single) {
            $item_neww_arr[] = [
                'item_no_fk' => $item_single['item_no_fk'],
                'item_code' => $item_single['item_code'],
                'item_name' => $item_single['item_name'],
                'generic_name' => $item_single['generic_name'],
                'lpqty' => $item_single['lpqty'],
                'lpp' => $item_single['lpp'],
                'lpd' => $item_single['lpd'],
                'uom_name' => $item_single['uom_name'],
                'uom_no_fk' => $item_single['uom_no_fk'],
                'purchase_price' => $item_single['purchase_price'],
                'conversion_qty' => $item_single['conversion_qty'],
                'purchase_qty' => $item_single['purchase_qty'],
                'inv_requisition_po_no_pk' => 0,
                'inv_requisitiondtl_po_no_pk' => 0,

            ];
        }
        return response()->json(['success' => true, 'data' => $item_neww_arr], 200);
    }

    public function getPOListV2(){
        $allSuppliers = $this->getSupplier();

        $main_store_list = $this->mainStore();
        return Template::loadview("admin.inventory.v1.po.worklist.purchase_order_worklist_v2", [
            'allSuppliers' => $allSuppliers,
            'main_store_list' => $main_store_list,

        ]);
    }

    public function getReviewPOListV2(){
        $allSuppliers = $this->getSupplier();

        $main_store_list = $this->mainStore();
        return Template::loadview("admin.inventory.v1.po.worklist.review_purchase_order_worklist_v2", [
            'allSuppliers' => $allSuppliers,
            'main_store_list' => $main_store_list,

        ]);
    }

    public function searchPOWorklistV2(Request $request){

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
            // $from_date = date('Y-m-d', strtotime($request->from_date));
        }

        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
            // $to_date = date('Y-m-d', strtotime($request->to_date));
        }
         $hospitalCode = $request->session()->get('user.ses_hospital_code');

        // dd($from_date,$to_date);
        $query = DB::table('inv_po_wl_vw')
                     ->select(
                        'total_amount',
                        'vat_amount',
                        'discount_amount',
                        'vat_percent',
                        'discount_percent',
                        'discount_amount',
                        'approval_level_status_text',
                        'approval_status_text',
                        'purchaseorder_no_pk',
                        'purchase_uid',
                        'pr_doc_attachment_path',
                        'po_doc_attachment_path',
                        'purchase_date',
                        'supplier_name',
                        'total_qty',
                        'po_save_option',
                        'dollar_rate',
                        'currency_sign',
                        'ait_percent',
                        'ait_amount',
                        'service_charge_percent',
                        'service_charge_amount',
                        'store_no_fk',
                        'supp_email',
                        'email_ind',
                        'submit_ind'
                     );

        if (!empty($request->po_no)) {
            if ($hospitalCode === "KPJ") {
                $query->where('purchase_uid', $request->po_no);
            } else {
                $query->where('purchaseorder_no_pk', $request->po_no);
            }
        }

        if (!empty($request->status)) {
            $query->where('po_save_option', $request->status);
        }
        if (!empty($request->main_store_id)) {
            $query->where('store_no_fk', $request->main_store_id);
        }
        if (!empty($request->supplier)) {
            $query->where('supplier_no_fk', $request->supplier);
        }
        if (!empty($request->from_date) &&  !empty($request->to_date)) {
            $query->whereBetween('purchase_date', [$from_date, $to_date]);
        }
        elseif (!empty($request->from_date)) {
            $query->where('purchase_date', $from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('purchase_date', $to_date);
        }

        $query->where([
            ['finalized_ind', '=', 0],
            ['issue_ind', '=', 0]
        ]);

        return response()->json(['data' => $query->orderByDesc('purchaseorder_no_pk')->get()->toArray(),'success'=>true],200);
    }

    public function searchReviewPOWorklistV2(Request $request){

        if(!empty($request->from_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
            // $from_date = date('Y-m-d', strtotime($request->from_date));
        }

        if(!empty($request->to_date)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
            // $to_date = date('Y-m-d', strtotime($request->to_date));
        }

        // dd($from_date,$to_date);
        $query = DB::table('inv_po_wl_vw')
                     ->select(
                        'total_amount',
                        'vat_amount',
                        'discount_amount',
                        'vat_percent',
                        'discount_percent',
                        'discount_amount',
                        'approval_level_status_text',
                        'approval_status_text',
                        'purchaseorder_no_pk',
                        'pr_doc_attachment_path',
                        'po_doc_attachment_path',
                        'purchase_date',
                        'supplier_name',
                        'total_qty',
                        'po_save_option',
                        'dollar_rate',
                        'currency_sign',
                        'ait_percent',
                        'ait_amount',
                        'service_charge_percent',
                        'service_charge_amount',
                        'store_no_fk',
                        'supp_email',
                        'email_ind',
                        'submit_ind'
                    );

        if (!empty($request->po_no)) {
            $query->where('purchaseorder_no_pk', $request->po_no);
        }
        if (!empty($request->status)) {
            $query->where('po_save_option', $request->status);
        }
        if (!empty($request->main_store_id)) {
            $query->where('store_no_fk', $request->main_store_id);
        }
        if (!empty($request->supplier)) {
            $query->where('supplier_no_fk', $request->supplier);
        }
        if (!empty($request->from_date) &&  !empty($request->to_date)) {
            $query->whereBetween('purchase_date', [$from_date, $to_date]);
        }
        elseif (!empty($request->from_date)) {
            $query->where('purchase_date', $from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('purchase_date', $to_date);
        }

        $query->where([
            ['finalized_ind', '=', 0],
            ['issue_ind', '=', 0],
            ['grn_ind', '=', 0]
        ]);

        return response()->json(['data' => $query->orderByDesc('purchaseorder_no_pk')->get()->toArray(),'success'=>true],200);
    }

    public function purchaseOrderPrintV2($purchase_order_id, $showWithHeader = false)
    {

        ini_set('max_execution_time',0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        // dd($po_hospital_details);
        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*, store.pharmacy_ind ,pov.approval_status_text,pov.approval_level_status_text,
        user_name.user_fullname as created_by, fnc_poheader($purchase_order_id) poheader, fnc_empdesignation_byuser(pom.prepared_by) as prepared_by_desig,
        fnc_username(pom.prepared_by) as prepared_by_name, fnc_username(pom.submit_by) as submit_by_name, fnc_empdesignation_byuser(pom.submit_by) as submit_by_desig,
        fnc_username(pom.au_update_by) as posted_by_name, fnc_empdesignation_byuser(pom.au_update_by) as posted_by_desig
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN WSEC_USER user_name ON user_name.user_no_pk = pom.au_entry_by
                LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                LEFT JOIN sysc_serviceunit store ON store.serviceunit_no_pk = pom.store_no_fk
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));
        // dd( $po_master_info);
        $pharmacy_ind='';
        if(count($po_master_info) > 0){
            $po_master_info = $po_master_info[0];
            $pharmacy_ind= $po_master_info->pharmacy_ind;
        }

        $barcode = new BarcodeGenerator();
        if (isset($po_hospital_details->hospital_code) && $po_hospital_details->hospital_code == "KPJ") {
            $barcode->setText($po_master_info->purchase_uid);
        } else
        {
            $barcode->setText($purchase_order_id);
        }

        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*, sg.generic_name, d.dollar_ind,curr.currency_code,curr.currency_name
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                LEFT JOIN sysc_generic sg ON sg.GENERIC_NO_PK = d.GENERIC_NO_FK
                left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                left join sysc_currency curr on poc.CURRENCY_NO_FK  = curr.currency_no_pk
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.purchaseorderdtl_no_pk asc

                "));

        // dd($po_master_info);

        $curr_rate = isset($po_child_details_info[0]->dollar_rate) ? $po_child_details_info[0]->dollar_rate : 0;

        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                        ->orderBy('purchaseorder_terms_no_pk', 'asc')
                        ->orderBy('sl', 'asc')->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

        $signature_data = DB::table('sysc_approvalprocess_vw')
                        ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at', 'sysc_approvalprocess_vw.approval_promt')
                        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                        ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                        ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
                        ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
                        ->orderBy('own_level', 'asc')
                        ->get();

        $viewFile = "";
        if(Session::get('user.ses_hospital_code') == "IMPERIAL" || $showWithHeader == true) {
            $viewFile = "admin.inventory.v1.po.purchase_order_print_v2_imperial";
            // $viewFile = "admin.inventory.v1.po.purchase_order_print_v3_kpj";

        }else if(Session::get('user.ses_hospital_code') == "KPJ") {
            $viewFile = "admin.inventory.v1.po.purchase_order_print_v3_kpj";
        }else {

            if ($pharmacy_ind == 1) {
                // $viewFile = "admin.inventory.v1.po.purchase_order_print_v2";
                $viewFile = "admin.inventory.v1.po.purchase_order_print_v3_with_md";
            }else{

                $viewFile = "admin.inventory.v1.po.purchase_order_print_v2";
            }

        }

        // dd($po_master_info);


        $pdf = PDF::loadView($viewFile, [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'curr_rate' => $curr_rate,
                'signature_data' => $signature_data,
            ]);



        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();

        // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // $canvas->page_text(42, 822, "Prepared By: $userInfo->user_fullname. Printing Date & Time: " . date('d/m/Y') . " Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        if(Session::get('user.ses_hospital_code') != "KPJ"){
            $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
            $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));
        } else
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));


        return $pdf->stream("purchase_order_print_".$purchase_order_id.".pdf", array("Attachment" => false));
    }
    public function purchaseOrderPrintV2WithHeader(Request $request)
    {
        try {
            //code...

        ini_set('max_execution_time',0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $purchase_order_id=$request->report_id;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $po_master_info = DB::select(DB::raw("SELECT s.*,s.e_mail as send_to_mail, pom.*, store.pharmacy_ind ,pov.approval_status_text,pov.approval_level_status_text, user_name.user_fullname as created_by,fnc_poheader($purchase_order_id) poheader
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN WSEC_USER user_name ON user_name.user_no_pk = pom.au_entry_by
                LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                LEFT JOIN sysc_serviceunit store ON store.serviceunit_no_pk = pom.store_no_fk
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));

        if(count($po_master_info) > 0){
            $po_master_info = $po_master_info[0];
        }



        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*, sg.generic_name, d.dollar_ind,curr.currency_code,curr.currency_name
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                LEFT JOIN sysc_generic sg ON sg.GENERIC_NO_PK = d.GENERIC_NO_FK
                left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                left join sysc_currency curr on poc.CURRENCY_NO_FK  = curr.currency_no_pk
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.purchaseorderdtl_no_pk asc

                "));



        $curr_rate = isset($po_child_details_info[0]->dollar_rate) ? $po_child_details_info[0]->dollar_rate : 0;


        $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                        ->orderBy('purchaseorder_terms_no_pk', 'asc')
                        ->orderBy('sl', 'asc')->get();

        $terms = [];
        if (!empty($term)) {
            foreach ($term as $key => $value) {
                $terms[$value->termscon_header][] = $value;
            }
        }

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

        $signature_data = DB::table('sysc_approvalprocess_vw')
                        ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
                        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                        ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                        ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
                        ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
                        ->orderBy('own_level', 'asc')
                        ->get();

        $viewFile = "";
        // if(Session::get('user.ses_hospital_code') == "IMPERIAL" || $showWithHeader == true) {
        //     $viewFile = "admin.inventory.v1.po.purchase_order_print_v2_imperial";
            // return view("admin.inventory.v1.po.purchase_order_print_v2_imperial", [
            //     'purchase_order_id' => $purchase_order_id,
            //     'po_master_info' => $po_master_info,
            //     'po_child_details_info' => $po_child_details_info,
            //     'userInfo' => $userInfo,
            //     'po_hospital_details' => $po_hospital_details,
            //     'invoice_barcode' => $invoice_barcode,
            //     'terms' =>   $terms,
            //     'signed_user' => $signed_user,
            //     'curr_rate' => $curr_rate,
            //     'signature_data' => $signature_data,
            // ]);
        // } else {
            $viewFile = "admin.inventory.v1.po.purchase_order_print_v2";
            // $viewFile = "admin.inventory.v1.po.purchase_order_print_v2_imperial";
        // }
        // dd($po_child_details_info);
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView($viewFile, [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'curr_rate' => $curr_rate,
                'signature_data' => $signature_data,
            ]);



        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();

        // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // $canvas->page_text(42, 822, "Prepared By: $userInfo->user_fullname. Printing Date & Time: " . date('d/m/Y') . " Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));

        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));

        // $pdf->stream("purchase_order_print_".$purchase_order_id.".pdf", array("Attachment" => false));


        $subject=$po_master_info->reference_sub;
        $user_emmail=Session::get('user.email_personal');
        $messageBody= '<p>Dear Concerned,<p/> Greetings form Divine Mercy Hospital Limited! Please see the attached Purchase Order (Ref: PO No. ' .$po_master_info->purchaseorder_no_pk. ') for ' .$po_master_info->reference_sub. '. Please acknowledge the Purchase Order as soon as possible. If you have any further query, please send email to: ' .$user_emmail. '. <p> Sincerely yours <p/> Supply Chain of Divine Mercy Hospital.';
        // 'Purchase Order No '. $po_master_info->purchaseorder_no_pk;
        // $pat_info->email
        // dd( $po_master_info->send_to_mail,$user_emmail);
        $mail_id=[$po_master_info->send_to_mail,$user_emmail,Config::get('mail.username')];
        //    dd($mail_id);
        $this->sendCustomMail( $mail_id, '', $subject, $messageBody, $pdf);

        $message = ['msg' => 'Email Send to User', 'title' => 'Success'];

        $data=[
            'mail_ind'=>1
        ];
        DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk',$purchase_order_id)->update($data);
        DB::commit();

        } catch (\Throwable $th) {
             DB::rollback();
            $message = ['msg' => 'Email not Send', 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function editPurchaseOrderv2(Request $request){


        $request->validate([
            'po_date' =>'required',
            'po_no' =>'required',
            'delivery_date' =>'required',
            'currency' =>'required',
            'curr_rate' =>'required',
            'main_store_id' =>'required',
            'supplier' =>'required',
            'remarks' =>'max:500',
        ]);
        // dd($request->all());
        if(!isset($request->item)){
            return response()->json(['success' => false, 'title' => 'Failed', 'message'=> 'Please Add at least one item'],422);
        }
        try {

            if(!empty($request->po_no)){
                if(DB::table('INV_PURCHASEORDER_MST')->where('PURCHASEORDER_NO_PK',$request->po_no)->value('SUBMIT_IND') != 1 && $request->post_draft == 'POST'){
                    return response()->json(['success' => false, 'title' => 'Failed', 'message'=> 'Not Ready for POST'],422);
                }
            }

            DB::beginTransaction();
            $main_store_module = ServiceUnit::where('serviceunit_no_pk', $request->main_store_id)
                                            ->select('main_store_module_no_fk')
                                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

            $main_store_module = isset($main_store_module->main_store_module_no_fk) ? $main_store_module->main_store_module_no_fk : 0 ;

            $in_au_entry_by = Session::get('user.ses_user_pk_no');
            $in_au_entry_session = 'PO';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $adj_percent = 0;
            $adj_amt = $request->gross_adj_dis_amount;
            $in_discount_percent = $request->gross_discount_percent + $adj_percent;
            $in_discount_amount = $request->gross_discount_amount + $adj_amt;

            $in_refer_no = $request->ref_no;
            $in_refer_sub = $request->subject_details;
            $refer_contact_name = $request->contact_person;
            $refer_contact_mobile = $request->contact_number;
            $refer_contact_email = $request->contact_email;
            $refer_quotation_ref = $request->quotation_ref;
            // $copy_to = $request->copy_to;
            $copy_to = '';

            $in_subject_body = $request->message_body;
            $in_requisition_code = '0';
            $in_req_saveoption = $request->post_draft;
            $numelems = 5000;
            $in_po_no = $request->po_no;
            $in_po_edit_ind = 1;
            $pdo = DB::getPdo();
            $zero = 0;
            $blank = '';

            $out_purchase_no_pk = $request->po_no;
            $out_purchase_uid = 0;
            $out_po_uid = 0;

            $vat_percent = $request->vat_percent;
            $vat_amount = $request->vat_amount;
            $discount_percent = $request->gross_discount_percent;
            $discount_amount = $request->gross_discount_amount;
            $store_id = $request->main_store_id;
            $item_no_fk = $request->item;
            $uom = $request->uom;
            $qty = $request->qty;
            $uPrice = $request->uPrice;
            $terms_sl = $request->terms_sl;
            $tc =  $request->tc;

            $vat_amount_item = $request->vat_percent_amount;
            $discount_percent_item = $request->disPercent;
            $discount_amount_item = $request->disAmount;
            $item_requisition_no_fk = $request->item_requisition_no_fk;
            $item_requisitiondtl_no_fk = $request->item_requisitiondtl_no_pk;
            $item_level_notes = $request->item_level_notes;
            $requisitiondtl_no_pk_list = $request->requisitiondtl_no_pk_list;
            $header_name = $request->header_name;
            $specification = $request->specification;
            $curr_rate = $request->curr_rate;
            $currency = $request->currency;

            $ait_percent_master = $request->gross_ait_percent;
            $ait_amount_master = $request->gross_ait_amount;
            $sc_percent_master = $request->gross_sc_percent;
            $sc_amount_master = $request->gross_sc_amount;

            $ait_percent_child = $request->ait_percent_item;
            $ait_amount_child = $request->ait_percent_amount;
            $sc_percent_child = $request->sc_percent_item;
            $sc_amount_child = $request->sc_percent_amount;
            $in_notes = $request->remarks;


            $cur_sign = DB::table('sysc_currency')->where('currency_no_pk',$currency)->value('currency_sign');
            $vat_percent_item = [];

            foreach($request->item as $key => $value){
               array_push($vat_percent_item, $request->vat_percent);
            }




            $attachment = "";
            if($request->po_attachment_ind == 1){
                $image1 = public_path('images/uploads/attachment/').'/'.$request->old_image;
                if(file_exists($image1)){
                    @unlink($image1);
                }
            }
            else{
                $po_master_info = DB::select(DB::raw("
                                        SELECT s.*,
                                        pom.*,
                                        v.approval_level_status_text
                                        FROM INV_PURCHASEORDER_MST pom
                                        LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                                        LEFT JOIN INV_PO_WL_VW v ON pom.purchaseorder_no_pk = v.purchaseorder_no_pk
                                        WHERE pom.PURCHASEORDER_NO_PK = $in_po_no
                                    "))[0];

                if(isset($po_master_info->po_doc_attachment_path)){
                    $attachment = $po_master_info->po_doc_attachment_path;
                }
            }

            if($request->hasFile('attachment')){
                $files = $request->file('attachment');
                $attachment = date('Ymdhi') . time(). "." . $files->getClientOriginalExtension();
                $request->attachment->move(public_path('/images/uploads/attachment'), $attachment);
            }



            $year = date('Y');
            $item_conversion = $request->item_conversion;

            if(!empty($request->po_date)){
                $dateObject = DateTime::createFromFormat('d/m/Y', $request->po_date);
                $po_date = $dateObject->format('Y-m-d');
            }
            if(!empty($request->delivery_date)){
                $dateObject = DateTime::createFromFormat('d/m/Y', $request->delivery_date);
                $delivery_date = $dateObject->format('Y-m-d');
            }
            $supplier = $request->supplier;


            $purchase_order_entry = $pdo->prepare("begin pkg_v2_inventory_all.prc_generic_po_create_v1(
                                                    :in_purchaseorder_no_pk,
                                                    :in_purchaseorder_edit_ind,
                                                    :in_purchase_date,
                                                    :in_supplier_no_fk,
                                                    :in_item_category,
                                                    :in_fiscal_year,
                                                    :in_vat_percent,
                                                    :in_vat_amount,
                                                    :in_discount_percent,
                                                    :in_discount_amount,
                                                    :in_module_no_fk,
                                                    :in_refer_no,
                                                    :in_refer_sub,
                                                    :in_refer_contact_name,
                                                    :in_refer_contact_mobile,
                                                    :in_refer_contact_email,
                                                    :in_subject_body,
                                                    :in_requisition_no_fk,
                                                    :in_requisition_code,
                                                    :in_store_no_fk,
                                                    :in_notes,
                                                    :in_budget_no_fk,
                                                    :in_po_save_option,
                                                    :in_delivery_date,
                                                    :in_quotation_ref,
                                                    :in_copy_to,
                                                    :in_currency_rate,
                                                    :in_currency_sign,
                                                    :in_po_doc_attach_path,
                                                    :in_currency_no_fk,

                                                    :in_ait_percent,
                                                    :in_ait_amount,
                                                    :in_service_charge_percent,
                                                    :in_service_charge_amount,

                                                    :in_item_no_fk,
                                                    :in_item_barcode,
                                                    :in_pvms_no,
                                                    :in_uom,
                                                    :in_entry_qty,
                                                    :in_item_rate,
                                                    :in_term_number,
                                                    :in_term_text,
                                                    :in_pr_uom_no_fk,
                                                    :in_pr_uom_conversion_qty,
                                                    :in_pr_uom_tradeprice,
                                                    :in_vat_percent_itm,
                                                    :in_vat_amount_itm,
                                                    :in_discount_percent_itm,
                                                    :in_discount_amount_itm,
                                                    :in_item_requisition_no_fk,
                                                    :in_item_level_notes,
                                                    :in_inv_requisitiondtl_no_pk,
                                                    :in_inv_requisitiondtl_no_pk_list,
                                                    :in_termscon_header,
                                                    :in_refer_item_specification,

                                                    :in_ait_percent_itm,
                                                    :in_ait_amount_itm,
                                                    :in_ser_charge_percent_itm,
                                                    :in_ser_charge_amount_itm,

                                                    :in_au_entry_by ,
                                                    :in_au_entry_hospital_no_fk ,
                                                    :in_au_entry_session ,
                                                    :out_purchase_no_pk ,
                                                    :out_purchase_uid,
                                                    :out_error
                                                    ); end;");
            $purchase_order_entry->bindparam('in_purchaseorder_no_pk', $in_po_no);
            $purchase_order_entry->bindparam('in_purchaseorder_edit_ind', $in_po_edit_ind);
            $purchase_order_entry->bindparam('in_purchase_date', $po_date);
            $purchase_order_entry->bindparam('in_supplier_no_fk', $supplier);
            $purchase_order_entry->bindparam('in_item_category', $blank);
            $purchase_order_entry->bindparam('in_fiscal_year', $year);
            $purchase_order_entry->bindparam('in_vat_percent', $vat_percent);
            $purchase_order_entry->bindparam('in_vat_amount', $vat_amount);
            $purchase_order_entry->bindparam('in_discount_percent', $discount_percent);
            $purchase_order_entry->bindparam('in_discount_amount', $discount_amount);
            $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);
            $purchase_order_entry->bindparam('in_refer_no', $in_refer_no);
            $purchase_order_entry->bindparam('in_refer_sub', $in_refer_sub);
            $purchase_order_entry->bindparam('in_refer_contact_name', $refer_contact_name);
            $purchase_order_entry->bindparam('in_refer_contact_mobile', $refer_contact_mobile);
            $purchase_order_entry->bindparam('in_refer_contact_email', $refer_contact_email);
            $purchase_order_entry->bindparam('in_subject_body', $in_subject_body);
            $purchase_order_entry->bindparam('in_requisition_no_fk', $zero);
            $purchase_order_entry->bindparam('in_requisition_code', $in_requisition_code);
            $purchase_order_entry->bindparam('in_store_no_fk', $store_id);
            $purchase_order_entry->bindparam('in_notes', $in_notes);
            $purchase_order_entry->bindparam('in_budget_no_fk', $zero);
            $purchase_order_entry->bindparam('in_po_save_option', $in_req_saveoption);
            $purchase_order_entry->bindparam('in_delivery_date', $delivery_date);

            $purchase_order_entry->bindparam('in_quotation_ref', $refer_quotation_ref);
            $purchase_order_entry->bindparam('in_copy_to', $copy_to);
            $purchase_order_entry->bindparam('in_currency_rate', $curr_rate);
            $purchase_order_entry->bindparam('in_currency_sign', $cur_sign);
            $purchase_order_entry->bindparam('in_po_doc_attach_path',$attachment);
            $purchase_order_entry->bindparam('in_currency_no_fk', $currency);

            $purchase_order_entry->bindparam('in_ait_percent', $ait_percent_master);
            $purchase_order_entry->bindparam('in_ait_amount', $ait_amount_master);
            $purchase_order_entry->bindparam('in_service_charge_percent', $sc_percent_master);
            $purchase_order_entry->bindparam('in_service_charge_amount', $sc_amount_master);

            $purchase_order_entry->bindArray('in_item_no_fk', $item_no_fk, count($item_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_item_barcode', $item_no_fk, count($item_no_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_pvms_no', $item_no_fk, count($item_no_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_uom', $uom, count($uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_entry_qty', $qty, count($qty), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_item_rate', $uPrice, count($uPrice), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_term_number', $terms_sl, count($terms_sl), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_term_text', $tc, count($tc), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_pr_uom_no_fk', $uom, count($uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_conversion_qty', $item_conversion, count($item_conversion), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_tradeprice', $uPrice, count($uPrice), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_percent_itm', $vat_percent_item, count($vat_percent_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_amount_itm', $vat_amount_item, count($vat_amount_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_percent_itm', $discount_percent_item, count($discount_percent_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_amount_itm', $discount_amount_item, count($discount_amount_item), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_item_requisition_no_fk', $item_requisition_no_fk, count($item_requisition_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_item_level_notes', $item_level_notes, count($item_level_notes), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk', $item_requisitiondtl_no_fk, count($item_requisitiondtl_no_fk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk_list', $requisitiondtl_no_pk_list, count($requisitiondtl_no_pk_list), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_termscon_header', $header_name, count($header_name), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_refer_item_specification', $specification, count($specification), $numelems, SQLT_CHR);

            $purchase_order_entry->bindArray('in_ait_percent_itm', $ait_percent_child, count($ait_percent_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ait_amount_itm', $ait_amount_child, count($ait_amount_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ser_charge_percent_itm', $sc_percent_child, count($sc_percent_child), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_ser_charge_amount_itm', $sc_amount_child, count($sc_amount_child), $numelems, SQLT_FLT);


            $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);

            $purchase_order_entry->bindParam('out_purchase_no_pk', $out_purchase_no_pk, PDO::PARAM_INT);
            $purchase_order_entry->bindParam('out_purchase_uid', $out_purchase_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->bindParam('out_error', $out_po_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->execute();

            if (Session::get('user.email_send_ind') == 1) {
                if ($in_req_saveoption == "POST") {
                    $approvalMst = DB::table('sysc_approvalmatrixmst')->select('dept_base_approval_ind')->where('approval_for_code', 'PO')->first();
                    $approval_matrix = [];
                    if (!empty($approvalMst) && $approvalMst->dept_base_approval_ind == 1) {
                        $approval_matrix = DB::table('sysc_approvalmatrix_dept_vw')->select('sysc_approvalmatrix_dept_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->where('dept_su_no_fk', Session::get('user.su_pk_no'))->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_dept_vw.person_no_fk')->get()->toArray();
                    } else {
                        $approval_matrix = DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PO')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_vw.person_no_fk')->get()->toArray();
                    }

                    if (!empty($approval_matrix)) {
                        $app_arr = [];
                        foreach ($approval_matrix as $key => $value) {
                            $app_arr[$key] = $value->email_personal;
                        }
                        $this->inventoryMail($app_arr, $in_po_no, $value->approval_for_code, Auth::user()->user_fullname);
                    }
                }
            }


            if($request->review_ind == 1){
                if(!empty($request->po_no)){
                    DB::table('INV_PURCHASEORDER_MST')->where('PURCHASEORDER_NO_PK',$request->po_no)->update(['review_no' => DB::raw('review_no + 1')]);
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Updated','voucher'=> $request->po_no,'title' => 'Success'], 200);
        }
        catch (Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function getSupplierInfoV2($id){
        $supplier =  DB::table('supplier_info_for_po_vw')
                        ->select('supplier_no_pk','company_name','contact_person','cp_mobile','quotation_ref','reference_no','reference_sub','reference_sub_body','refer_contact_email')
                        ->where('supplier_no_pk', $id)
                        ->first();
        return response()->json(['success' => true,'data'=>$supplier],200);
    }


    public function getBillTracking(){
        $stores = $this->mainStore();
        return Template::loadview("admin.inventory.v1.bill_tracking.bill_tracking", [
            'stores' => $stores,

        ]);
    }

    public function poReadyPOST($po_no){
        try {

            $au_entry_at = new DateTime('now');
            $data = [
                'submit_ind' => 1,
                'SUBMIT_BY' => Auth::id(),
                'SUBMIT_AT' => $au_entry_at,
            ];
           DB::table('INV_PURCHASEORDER_MST')->where('PURCHASEORDER_NO_PK',$po_no)->update($data);
           return response(['message'=>' Successfully Ready to POST', 'success' => true], 200);
        } catch (\Throwable $th) {
            return response(['message'=> $th->getMessage(), 'success' => true], 200);
        }
    }
}
