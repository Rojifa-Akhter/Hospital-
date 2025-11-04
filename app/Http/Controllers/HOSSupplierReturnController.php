<?php

namespace App\Http\Controllers;

use DB;
use App;
use PDO;
use \PDF;
use Session;
use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HOSSupplierReturnController extends Controller
{


    public function __construct()
    {
    }

    public function index()
    {
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->orderBy('supplier_name', 'asc')->get();
        return Template::loadView("admin.uhl.inventory.supplier-return", [
            'suppiler_arr' => $suppiler_arr,
            'mode'         => 'list'
        ]);
    }

    public function edit_supplier_return(Request $request)
    {
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->orderBy('supplier_name', 'asc')->get();

        $supplier_return_list = DB::table("phr_itemreturnsupp_wl_vw")
            ->where('itemreturn_no_pk', $request->rtn_id)
            ->get();


        // dd($supplier_return_list);
        return Template::loadView("admin.uhl.inventory.supplier-return", [
            'suppiler_arr' => $suppiler_arr,
            'supplier_return_list' => $supplier_return_list,
            'mode'         => 'edit'
            
        ]);
    }

    public function grn_info($grn_id, $item_dtl_id)
    {
        $grn_item = DB::table("phr_itemgrn_worklist_vw")
            ->where('itemreceive_no_pk', $grn_id)
            ->where('itemreceivedtl_no_pk', $item_dtl_id)
            ->first();

        return $grn_item;
    }

    public function get_grn_item_list(Request $request)
    {
        $hospital = Session::get('user.ses_hospital_no_pk');

        $grn_item = DB::table("phr_itemgrn_worklist_vw")
            ->where('itemreceive_no_pk', $request->grn_no)
            ->get();

        $pdo = DB::getPdo();

        $item_arr = [];

        foreach ($grn_item as $item) {

            $main_store_stock = 0;
            $main_store_id = $item->store_su_no_fk;

            if (DB::table("phr_itemreturnsupp_wl_vw")
                ->where('itemreceive_no_fk', $item->itemreceive_no_pk)
                ->exists()
            ) {
                $supp_rtn_info = DB::table("phr_itemreturnsupp_wl_vw")
                    ->where('itemreceive_no_fk', $item->itemreceive_no_pk)
                    ->first();
            } else {
                $supp_rtn_info = NULL;
            }

            $item_no = intval($item->item_no_fk);
            $main_store = intval($item->store_su_no_fk);
            $hospital_id = intval($hospital);


            $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
            $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 12);
            $stmt->bindParam(':IN_ITEM_NO_FK', $item_no, PDO::PARAM_INT);
            $stmt->bindParam(':IN_STORE_SU_NO_FK', $main_store, PDO::PARAM_INT);
            $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital_id, PDO::PARAM_INT);
            $stmt->execute();

            //dd($item_no,$main_store,$hospital_id,$main_store_stock);


            array_push($item_arr, [
                'itemreceive_no_pk' => $item->itemreceive_no_pk,
                'itemreceivedtl_no_pk' => $item->itemreceivedtl_no_pk,
                'store_su_no' => $main_store_id,
                'challan_date' => date("Y-m-d", strtotime($item->challan_date)),
                'serviceunit_name' => $item->serviceunit_name,
                'challan_no' => $item->challan_no,
                'supplier_no_fk' => $item->supplier_no_fk,
                'supplier_name' => $item->supplier_name,
                'item_no_fk' => $item->item_no_fk,
                'item_name' => $item->item_name,
                'item_qty' => $item->item_qty,
                'item_uom' => $item->uom,
                'vat_percent' => $item->vat_percent,
                'vat_amount' => $item->vat_amount,
                'discount_percent' => $item->discount_percent,
                'discount_amount' => $item->discount_amount,
                'trade_price' => $item->trade_price,
                'batch_no' => $item->batch_no,
                'expiry_date' => $item->expiry_date,
                'module_no_fk' => $item->module_no_fk,
                'po_no' => $item->po_no,
                'internal_batch_no_uq' => $item->internal_batch_no_uq,
                'inv_requisitiondtl_no_pk' => $item->inv_requisitiondtl_no_pk,
                'invoice_no' => isset($item->challan_no) ? $item->challan_no : 0,
                'main_store_stock' => $main_store_stock,
                'cost_price' => $item->cost_price,
                'rtn_item_qty' => $item->rtn_item_qty,
                'itemreturn_date' => !empty($supp_rtn_info) ? $supp_rtn_info->itemreturn_date : NULL,
                'return_type_text' => !empty($supp_rtn_info) ? $supp_rtn_info->return_type_text : NULL,
                'return_reason_type' => !empty($supp_rtn_info) ? $supp_rtn_info->return_reason_type : NULL,
                'getpass_no_fk' => !empty($supp_rtn_info) ? $supp_rtn_info->getpass_no_fk : NULL,
            ]);
        }

        return view("admin.uhl.inventory.supplier_return_grn_item", compact('item_arr'));
    }

    public function save_supplier_return(Request $request)
    {
        $numelems = 1000;

        $out_po_uid = '';
        $out_requisition_no_pk = 0;
        $out_error = '';
        $null = '';
        $zero = 0;
        $null = date('Y');

       if($request->in_req_saveoption != 'POST'){
        if(DB::table('phr_itemreturnsupp_wl_vw')->whereIn('item_no_fk',$request->item_no_fk)->where('supret_save_option','DRAFT')->exists()){
            return response()->json(['msg'=>'Already in Draft. Please POST at First','title' => 'Error'],422);
        }
       }
        

        
        $pdo = DB::getPdo();

        $requisition_info = DB::table('inv_requisitionlist_vw')->where('inv_requisition_no_pk', $request->requisition_no)->first();



        $in_req_saveoption = $request->in_req_saveoption;
        $null = "";
        $zero = 0;
        $in_au_entry_session = 'SUPPLIER RETURN';
        $in_au_entry_by = intval(Session::get('user.ses_user_pk_no'));
        $in_au_entry_hospital_no_fk = intval(Session::get('user.ses_hospital_no_pk'));

        $in_inv_itemreturn_date = isset($request->return_date) ? date("Y-m-d", strtotime($request->return_date)) : date("Y-m-d");
        $in_main_store_su_no_fk = $request->hdn_main_store_id;
        $in_ref_requisition_po_no_fk = $request->inv_requisition_no_pk;
        $in_req_po_remarks = $request->indent_remarks;

        $in_inv_itemreturn_no_pk = isset($request->return_no) ? intval($request->return_no) : NULL;
        $in_return_type_text = isset($request->return_type) ? $request->return_type : $null;
        $in_return_reason_type = isset($request->status_type) ? $request->status_type : $null;
        $in_itemreturn_reason = isset($request->return_reason) ? $request->return_reason : $null;
        $in_supplier_no_fk = isset($request->supplier_no_fk) ? intval($request->supplier_no_fk) : $zero;
        $in_store_no_fk = isset($request->store_su_no_fk) ? intval($request->store_su_no_fk) : $zero;
        $in_challan_no = isset($request->challan_no) ? $request->challan_no : $null;
        $in_challan_date = isset($request->challan_date) ? date("Y-m-d", strtotime($request->challan_date)) : NULL;
        $in_itemreceive_no_fk = isset($request->itemreceive_no_pk) ? intval($request->itemreceive_no_pk) : $zero;
        $in_module_no_fk = isset($request->module_no_fk) ? intval($request->module_no_fk) : $zero;
        $in_vat_percent = isset($request->vat_percent) ? intval($request->vat_percent) : $zero;
        $in_vat_amount = isset($request->vat_amount) ? intval($request->vat_amount) : $zero;
        $in_discount_percent = isset($request->discount_percent) ? intval($request->discount_percent) : $zero;
        $in_discount_amount = isset($request->discount_amount) ? intval($request->discount_amount) : $zero;
        $in_return_amt = isset($request->total_amt) ? intval($request->total_amt) : $zero;
        $in_getpass_no_fk = isset($request->gate_pass_no) ? intval($request->gate_pass_no) : $zero;
        $in_edit_ind = isset($request->in_req_saveoption) &&  $request->in_req_saveoption == 'DRAFT' ? 0 : 1;
        $in_ret_saveoption = isset($request->in_req_saveoption) ? $request->in_req_saveoption : $null;




        $in_single_po_ind = isset($request->requisition_id) ? 1 : $zero;
        //$in_edit_ind = isset($request->requisition_id) ? 1 : $zero;

        $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemreturnsupplier_ms(
            :in_inv_itemreturn_no_pk,
            :in_inv_itemreturn_date,
            :in_return_type_text,
            :in_return_reason_type,
            :in_supplier_no_fk,
            :in_store_no_fk,
            :in_itemreturn_reason,
            :in_challan_no,
            :in_challan_date,
            :in_indent_no_fk,
            :in_itemreceive_no_fk,
            :in_module_no_fk,
            :in_vat_percent,
            :in_vat_amount,
            :in_discount_percent,
            :in_discount_amount,
            :in_return_amt,
            :in_getpass_no_fk,
            :in_edit_ind,
            :in_ret_saveoption,
            :in_item_no_fk,
            :in_item_uom,
            :in_item_qty,
            :in_item_rate,
            :in_internal_batch_no,
            :in_batch_no,
            :in_expiry_date ,
            :in_item_remarks,
            :in_entry_serial_dtl,
            :in_inv_requisitiondtl_no_pk,
            :in_invoicedtl_no_pk,
            :in_purchaseorderdtl_no_pk,
            :in_itemreceivedtl_no_pk,
            :in_cost_price,
            :in_purchase_price,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_inv_itemreturn_no_pk,
            :out_inv_itemreturn_uid,
            :out_error
                ); end;");




        $item_no_fk_arr = $in_a_item_remarks =  $in_expect_date = $in_item_rate = $in_item_qty = $in_item_uom = $in_inv_requisitiondtl_no_pk = $in_internal_batch_no = $in_invoicedtl_no_pk = $in_purchaseorderdtl_no_pk = $in_itemreceivedtl_no_pk = $in_inv_requisitiondtl_no_pk = $in_cost_price = $in_purchase_price = $in_entry_serial_dtl = [];
        $in_indent_no_fk = 0;
        $out_inv_itemreturn_no_pk = 0;
        $out_inv_itemreturn_uid = '';
        $out_error = '';

        if (isset($request->chk_total_amt)) {
            for ($i = 0; $i < count($request->chk_total_amt); $i++) {
                $item_no_fk_arr[$i] = isset($request->chk_total_amt) ? intval($request->chk_total_amt[$i]) : $zero;
                //$in_a_urgent_ind[$i] = $request->in_a_urgent_ind[$i];
                //$in_a_exact_ind[$i] = $request->in_a_exact_ind[$i];

                $in_batch_no[$i] = isset($request->batch_no) ? $request->batch_no[$i] : $null;
                $in_expiry_date[$i] = isset($request->expiry_date) ? $request->expiry_date[$i] : $null;
                $in_item_remarks[$i] = $null;


                $in_a_item_remarks[$i] = isset($request->item_remarks) ? $request->item_remarks[$i] : $null;
                $in_expect_date[$i] = date("d-m-Y");
                $in_item_rate[$i] = $zero;
                $in_item_qty[$i] = isset($request->rtn_item_qty) ? intval($request->rtn_item_qty[$i]) : $zero;
                $in_item_uom[$i] = isset($request->item_uom) ? intval($request->item_uom[$i]) : $zero;
                $in_inv_requisitiondtl_no_pk[$i] = $zero;
                $in_internal_batch_no[$i] =  isset($request->internal_batch_no_uq) ? $request->internal_batch_no_uq[$i] : $null;
                $in_invoicedtl_no_pk[$i] =  isset($request->invoice_no) ? intval($request->invoice_no) : $zero;
                $in_purchaseorderdtl_no_pk[$i] =  isset($request->po_no) ? intval($request->po_no[$i]) : $zero;
                $in_itemreceivedtl_no_pk[$i] =  isset($request->itemreceivedtl_no_pk) ? intval($request->itemreceivedtl_no_pk[$i]) : $zero;
                $in_inv_requisitiondtl_no_pk[$i] = isset($request->inv_requisitiondtl_no_pk) ? intval($request->inv_requisitiondtl_no_pk) : $zero;
                $in_cost_price[$i] = isset($request->cost_price) ? floatval($request->cost_price[$i]) : $zero;
                $in_purchase_price[$i] = isset($request->purchase_price) ? floatval($request->purchase_price[$i]) : $zero;
                $in_entry_serial_dtl[$i] = $i + 1;
            }
        }



        $purchase_order_entry->bindparam('in_inv_itemreturn_no_pk', $in_inv_itemreturn_no_pk);
        $purchase_order_entry->bindparam('in_inv_itemreturn_date', $in_inv_itemreturn_date);
        $purchase_order_entry->bindparam('in_return_type_text', $in_return_type_text);
        $purchase_order_entry->bindparam('in_return_reason_type', $in_return_reason_type);
        $purchase_order_entry->bindparam('in_supplier_no_fk', $in_supplier_no_fk);
        $purchase_order_entry->bindparam('in_store_no_fk', $in_store_no_fk);
        $purchase_order_entry->bindparam('in_itemreturn_reason', $in_itemreturn_reason);
        $purchase_order_entry->bindparam('in_challan_no', $in_challan_no);
        $purchase_order_entry->bindparam('in_challan_date', $in_challan_date);
        $purchase_order_entry->bindparam('in_indent_no_fk', $in_indent_no_fk);
        $purchase_order_entry->bindparam('in_itemreceive_no_fk', $in_itemreceive_no_fk);
        $purchase_order_entry->bindparam('in_module_no_fk', $in_module_no_fk);
        $purchase_order_entry->bindparam('in_vat_percent', $in_vat_percent);
        $purchase_order_entry->bindparam('in_vat_amount', $in_vat_amount);
        $purchase_order_entry->bindparam('in_discount_percent', $in_discount_percent);
        $purchase_order_entry->bindparam('in_discount_amount', $in_discount_amount);
        $purchase_order_entry->bindparam('in_return_amt', $in_return_amt);
        $purchase_order_entry->bindparam('in_getpass_no_fk', $in_getpass_no_fk);
        $purchase_order_entry->bindparam('in_edit_ind', $in_edit_ind);
        $purchase_order_entry->bindparam('in_ret_saveoption', $in_ret_saveoption);


        $purchase_order_entry->bindArray('in_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_item_qty', $in_item_qty, count($in_item_qty), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_item_uom', $in_item_uom, count($in_item_uom), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_item_rate', $in_item_rate, count($in_item_rate), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_internal_batch_no', $in_internal_batch_no, count($in_internal_batch_no), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_batch_no', $in_batch_no, count($in_batch_no), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_expiry_date', $in_expiry_date, count($in_expiry_date), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_item_remarks', $in_item_remarks, count($in_item_remarks), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_entry_serial_dtl', $in_entry_serial_dtl, count($in_entry_serial_dtl), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_invoicedtl_no_pk', $in_invoicedtl_no_pk, count($in_invoicedtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_itemreceivedtl_no_pk', $in_itemreceivedtl_no_pk, count($in_itemreceivedtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_cost_price', $in_cost_price, count($in_cost_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_purchase_price', $in_purchase_price, count($in_purchase_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
        $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
        $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_no_fk);
        $purchase_order_entry->bindParam('out_inv_itemreturn_no_pk', $out_inv_itemreturn_no_pk, PDO::PARAM_INT);
        $purchase_order_entry->bindParam('out_inv_itemreturn_uid', $out_inv_itemreturn_uid, PDO::PARAM_STR, 500);
        $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
        $purchase_order_entry->execute();

        DB::commit();
        $message = ['msg' => 'Data saved successfully.<br><strong>Return UID = ' . $out_inv_itemreturn_uid . '</strong>', 'title' => 'Success'];

        if ($out_error == '000') {
       
            if (isset($request->go_pr)) {
                for ($i = 0; $i < count($request->go_pr); $i++) {
                    DB::table("inv_requisitiondtl")
                        ->where('item_no_fk', $request->item_name[$i])
                        ->where('inv_requisition_no_fk', $request->inv_requisition_no_pk[$i])
                        ->update([
                            'purchase_req_ind' => 1,
                            'purchase_req_by' => Auth::id(),
                            'purchase_req_at' => date("Y-m-d h:i:s")
                        ]);


                        
                }
            }
        }

        return response()->json($message);
    }


    public function supplier_return_WorkList()
    {
        $start_days = date("Y-m-d", strtotime("-30 day"));
        $end_days = date("Y-m-d");

        $supplier_return_list = DB::select("select itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms,count(item_no_fk)
        from phr_itemreturnsupp_wl_vw
        where TRUNC(itemreturn_date) between TO_DATE('$start_days','YYYY-MM-DD') and TO_DATE('$end_days','YYYY-MM-DD')
        group by itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms order by itemreturn_date desc");

        return Template::loadView("admin.uhl.inventory.supplier-return-worklist", [
            'supplier_return_list' => $supplier_return_list,

        ]);
    }

    public function srch_supplier_return_WorkList(Request $request)
    {
        $start_days = isset($request->indent_date_from) ? date("Y-m-d", strtotime($request->indent_date_from)) : date("Y-m-d"); //date("Y-m-d", strtotime("-30 day"));
        $end_days = isset($request->indent_date_to) ? date("Y-m-d", strtotime($request->indent_date_to)) : date("Y-m-d");
        $requsion_no = $request->requsion_no;

        if (isset($request->indent_date_from) && isset($request->indent_date_to)) {
            $supplier_return_list = DB::select("select itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms,count(item_no_fk)
            from phr_itemreturnsupp_wl_vw
            where TRUNC(itemreturn_date) between TO_DATE('$start_days','YYYY-MM-DD') and TO_DATE('$end_days','YYYY-MM-DD')
            group by itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms");
        }

        if (isset($request->requsion_no)) {
            $supplier_return_list = DB::select("select itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms,count(item_no_fk)
            from phr_itemreturnsupp_wl_vw
            where itemreturn_no_pk = $request->requsion_no
            group by itemreturn_no_pk,itemreturn_date,return_type_text,itemreceive_no_fk,supret_save_option,serviceunit_name_ms");
        }

        return Template::loadView("admin.uhl.inventory.search_supplier_return", [
            'supplier_return_list' => $supplier_return_list,

        ]);
    }


    public function supplier_return_prnt($id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
    
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $req_mst = DB::table('phr_itemreturnsuppliermst')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'phr_itemreturnsuppliermst.store_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemreturnsuppliermst.au_entry_by')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_itemreturnsuppliermst.supplier_no_fk')
            ->select('phr_itemreturnsuppliermst.*', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_supplier.supplier_no_pk', 'inv_supplier.supplier_name')
            ->where('itemreturn_no_pk', $id)
            ->first();

        $my_requsition_items = DB::table('phr_itemreturnsupp_wl_vw') 
            ->where('itemreturn_no_pk', $id)
            ->get(); 
        // dd($req_mst);
        $barcode = new BarcodeGenerator();
        $barcode->setText($id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');
        // dd($my_requsition_items);
        $pdf = PDF::loadView("admin.uhl.inventory.supplier_return_prnt", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition_items' => $my_requsition_items,
            'req_mst' => $req_mst,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("pr_print.pdf", array("Attachment" => false));
    }


    public function test(Request $request){




 





        try {
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

        if (!empty($item_no_fk_arr)) {

            foreach ($item_no_fk_arr as $iofa) {

                $item_barcode_arr[] = $iofa[0];

            }

        }

        $in_term_number = [];
        $in_term_text = [];
        $in_header = [];

        if (!empty($request->terms_text)) {

            $in_term_number = $request->terms_sl;

            $in_term_text = $request->terms_text;

            $in_header = $request->header_name;

        }

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
}