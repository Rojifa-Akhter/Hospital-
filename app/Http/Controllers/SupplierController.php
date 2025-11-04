<?php

namespace App\Http\Controllers;

use App;
use PDF;
use PDO;
use Session;
use Carbon\Carbon;
use App\Models\Supplier;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplierRequest;
use App\Models\SupplierPaymentRequest;
use App\Http\Controllers\LookupRequest;
use App\Repositories\BaseRepository as Repo;
use Illuminate\Support\Facades\DB as FacadesDB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
use App\Enums\AccountIndicator;

class SupplierController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    protected $chart_of_acc;



    public function __construct(
        Supplier $supplier,
        ChartOfAccounts $chart_of_acc
    ) {
        $this->middleware('auth');

        $this->chart_of_acc = $chart_of_acc;

        $this->model = new Repo($supplier);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Supplier::all();
        //  dd($data);
        return Template::loadview("admin.settings.supplier.supplier_list");
    }

    public function supplierListPDF(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $supplier_data = DB::table('suppliers_vw')
            ->orderBy('file_no', 'asc')
            ->orderBy('supplier_name', 'asc')
            ->get();

        // if ($request->hdn_report_type == 'PDF') {
        //     return view("admin.reports.due_reports.due_invoice_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'due_data' => $due_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no]);
        //     return $pdf->stream('due_invoice_print_report.pdf');
        // }
        // if ($request->hdn_report_type == 'EXCEL') {
        $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'supplier_data' => $supplier_data];
        $fileToExport = "supplier_list";
        $html = View("admin.settings.supplier.supplier_list_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
        // }
    }

    public function supplierListPopup()
    {
        $country_no = $this->getLookupListByCode("COUNTRY");
        $supplier_type = $this->getLookupListByCode("SUPP_TYPE");
        $banks = $this->getLookupListByCode("AGENTBANKING");
        // dd($banks);
        $subledger = DB::table('acct_subledger_name')
            ->Join('acct_subledger_type', 'acct_subledger_type.acct_subledger_typeno_pk', 'acct_subledger_name.acct_subledger_typeno_fk')
            ->where('acct_subledger_type.subledgertype_code', 'VNDR')
            ->where('acct_subledger_name.status', 1)
            ->select('acct_subledger_name.acct_subledger_no_pk', 'acct_subledger_name.subledger_code', 'acct_subledger_name.subledger_name', 'acct_subledger_name.acct_subledger_typeno_fk', 'acct_subledger_name.status')
            ->get();

        return Template::loadview("admin.settings.supplier.supplier_list_popup", ['country' => $country_no, 'subledger' => $subledger, 'supplier_type' => $supplier_type, 'banks' => $banks]);
    }

    public function supplierListCreate()
    {
        $country_no = $this->getLookupListByCode("COUNTRY");
        return Template::loadview("admin.settings.supplier.create", ['country' => $country_no]);
    }

    // public function supplierListStore(Request $request)
    // {
    //     $id = $request->id;
    //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
    //     $auth_id = Auth::id();

    //     $pharmacy_ind = '';
    //     $inventory_ind = '';
    //     if (!empty($request->is_pharmacy)) {
    //        $pharmacy_ind = $request->is_pharmacy == 1 ? '1' : '';
    //        $inventory_ind = $request->is_pharmacy == 2 ? '1' : '';
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $data = [
    //             'supplier_uid'  => $request->supplier_uid,
    //             'supplier_name' => $request->supplier_name,
    //             'phone' => $request->mobile_number,
    //             'company_name'      => $request->company_name,
    //             'contact_person' => $request->Contact_person,
    //             'mobile1'      => $request->phone_1,
    //             'mobile2'      => $request->phone_2,
    //             'cp_jobtitle' => $request->Contact_person_job_title,
    //             'cp_phone'      => $request->Contact_person_phone,
    //             'e_mail'      => $request->email,
    //             'fax'      => $request->fax,
    //             'addr1'      => $request->address,
    //             'status' => $request->status ? $request->status : 0,
    //             'descr'      => $request->description,
    //             'acct_subledger_no_fk' => $request->subledger,
    //             'country_no'      => $request->supplier_country,
    //             'supp_type_lookup_no_fk' => $request->supplier_type,
    //             'file_no' => $request->file_no,
    //             'cp_email' => $request->Contact_person_email,
    //             'pharmacy_ind' => $pharmacy_ind,
    //             'inventory_ind' => $inventory_ind,

    //             'bank_account_name' => $request->bank_account_name,
    //             'bankaccount'       => $request->bankaccount,
    //             'bank_no_fk'        => $request->bank_no_fk,
    //             'bank_branch_name'  => $request->bank_branch_name,
    //             'routing'           => $request->routing,

    //             'au_entry_at' => date("Y-m-d h:i:s"),
    //             'au_update_at' => date("Y-m-d h:i:s"),
    //             'au_entry_hospital_pk_no'  => $ses_hospital_id,
    //             // 'STATUS'      => $request->supplier_status
    //         ];
    //         // dd($data);

    //         if ($id == null || $id == "") {

    //             $data['au_entry_by'] = $auth_id;
    //             $this->model->create($data);
    //         } else {
    //             // AU_UPDATE_BY
    //             $data['au_update_by'] = $auth_id;
    //             $this->model->update($data, $id);
    //         }


    //         DB::commit();
    //         $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
    //     }

    //     return response()->json($message);
    // }

    public function supplierListStore(Request $request)
    {
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        $pharmacy_ind = $request->is_pharmacy == 1 ? '1' : '';
        $inventory_ind = $request->is_pharmacy == 2 ? '1' : '';

        $uploadPath = 'images/uploads/supplier_documents';
        $supplierId = $id ?? uniqid();

        // Default: Use old image paths if no new file is uploaded
        $supp_tin_image_path = $request->input('old_supp_tin_image_path', '');
        $supp_bin_image_path = $request->input('old_supp_bin_image_path', '');
        $supp_tradelicense_image_path = $request->input('old_supp_tradelicense_image_path', '');

        // Handle new TIN image upload
        if ($request->hasFile('supp_tin_image_path')) {
            $filename = $supplierId . '_TIN_' . date('YmdHis') . '.' . $request->file('supp_tin_image_path')->getClientOriginalExtension();
            $request->file('supp_tin_image_path')->move(public_path($uploadPath), $filename);
            $supp_tin_image_path = $uploadPath . '/' . $filename;
        }

        // Handle new BIN image upload
        if ($request->hasFile('supp_bin_image_path')) {
            $filename = $supplierId . '_BIN_' . date('YmdHis') . '.' . $request->file('supp_bin_image_path')->getClientOriginalExtension();
            $request->file('supp_bin_image_path')->move(public_path($uploadPath), $filename);
            $supp_bin_image_path = $uploadPath . '/' . $filename;
        }

        // Handle new Trade License image upload
        if ($request->hasFile('supp_tradelicense_image_path')) {
            $filename = $supplierId . '_TRADE_' . date('YmdHis') . '.' . $request->file('supp_tradelicense_image_path')->getClientOriginalExtension();
            $request->file('supp_tradelicense_image_path')->move(public_path($uploadPath), $filename);
            $supp_tradelicense_image_path = $uploadPath . '/' . $filename;
        }

        DB::beginTransaction();
        try {
            $data = [
                'supplier_uid'       => $request->supplier_uid,
                'supplier_name'      => $request->supplier_name,
                'phone'              => $request->mobile_number,
                'company_name'       => $request->company_name,
                'contact_person'     => $request->Contact_person,
                'mobile1'            => $request->phone_1,
                'mobile2'            => $request->phone_2,
                'cp_jobtitle'        => $request->Contact_person_job_title,
                'cp_phone'           => $request->Contact_person_phone,
                'e_mail'             => $request->email,
                'fax'                => $request->fax,
                'addr1'              => $request->address,
                'status'             => $request->status ?? 0,
                'descr'              => $request->description,
                'acct_subledger_no_fk' => $request->subledger,
                'country_no'         => $request->supplier_country,
                'supp_type_lookup_no_fk' => $request->supplier_type,
                'file_no'            => $request->file_no,
                'cp_email'           => $request->Contact_person_email,
                'pharmacy_ind'       => $pharmacy_ind,
                'inventory_ind'      => $inventory_ind,

                'bank_account_name'  => $request->bank_account_name,
                'bankaccount'        => $request->bankaccount,
                'bank_no_fk'         => $request->bank_no_fk,
                'bank_branch_name'   => $request->bank_branch_name,
                'routing'            => $request->routing,

                // ✅ Images and fields
                'supp_tin'                     => $request->supp_tin,
                'supp_tin_image_path'          => $supp_tin_image_path,
                'supp_bin'                     => $request->supp_bin,
                'supp_bin_image_path'          => $supp_bin_image_path,
                'supp_tradelicense_image_path' => $supp_tradelicense_image_path,
                'trade_license'                => $request->trade_license,

                'au_update_at' => now(),
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if (empty($id)) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] = now();
                $this->model->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }

            DB::commit();
            return response()->json(['msg' => 'Data Saved Successfully', 'title' => 'Success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        }
    }


    /**
     * Supplier List table data
     */
    public function getAllSupplier(Request $request)
{
    $hospital_id = Session::get('user.ses_hospital_no_pk');

    // Table
    $table = 'suppliers_vw';
    $primaryKey = 'supplier_no_pk';

    // Columns mapping (match <thead> index)
    $columns = array(
        array('db' => 'rownum', 'dt' => 0),
        array('db' => 'supplier_uid', 'dt' => 1),
        array('db' => 'file_no', 'dt' => 2),
        array('db' => 'supplier_name', 'dt' => 3),
        array('db' => 'mobile1', 'dt' => 4),
        array('db' => 'mobile2', 'dt' => 5),
        array('db' => 'contact_person', 'dt' => 6),

        array('db' => 'bank_account_name', 'dt' => 7),
        array('db' => 'bank_no_fk', 'dt' => 8),
        array('db' => 'bank_name', 'dt' => 9),
        array('db' => 'bank_branch_name', 'dt' => 10),
        array('db' => 'routing', 'dt' => 11),

        array('db' => 'company_name', 'dt' => 12),
        array('db' => 'e_mail', 'dt' => 13),
        array('db' => 'country_name', 'dt' => 14),

        array('db' => 'supp_tin', 'dt' => 15),
        array('db' => 'supp_tin_image_path', 'dt' => 16),
        array('db' => 'supp_bin', 'dt' => 17),
        array('db' => 'supp_bin_image_path', 'dt' => 18),
        array('db' => 'trade_license', 'dt' => 19),
        array('db' => 'supp_tradelicense_image_path', 'dt' => 20),

        array('db' => 'supplier_no_pk', 'dt' => 21) // Actions
    );

    // Condition for hospital
    $where = "au_entry_hospital_pk_no = $hospital_id";

    $response = !empty($where)
        ? DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where)
        : DataTableClass::simple($request, $table, $primaryKey, $columns);

    // Ensure response is JSON with 'data' key for front-end
    return response()->json($response);
}


    public function edit_Supplier($id)
    {
        // dd($id);
        $supplier = $this->model->show($id);
        // dd($supplier);
        // $supplier_data = $data = supplier::all();;
        $country_no = $this->getLookupListByCode("COUNTRY");
        $supplier_type = $this->getLookupListByCode("SUPP_TYPE");
        $banks = $this->getLookupListByCode("AGENTBANKING");
        $subledger = DB::select("select acct_subledger_no_pk, subledger_code, subledger_name, sub.status
                        from acct_subledger_name sub,acct_subledger_type type
                        where sub.acct_subledger_typeno_fk=type.acct_subledger_typeno_pk
                        and subledgertype_code='VNDR'
                        order by 3");

        return Template::loadView("admin.settings.supplier.supplier_list_popup", ['supplier' => $supplier, 'country' => $country_no, 'supplier_type' => $supplier_type, 'banks' => $banks, 'subledger' => $subledger]);
    }
    public function suplierPaymentRequsition()
    {
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.supplier_payment_requisition");
    }
    public function suplierPaymentPoList(Request $request)
    {
        $supplier_id = $request->sup_id;
        $payment_vouchar = DB::table('inv_supplierpayment_po_vw')->select('supledger_no_pk')->latest('supledger_no_pk')->first()->supledger_no_pk;
        if ($request->pay_type == 'ADVANCE') {
            $supplier_po_info = DB::select("select pur.no_of_item,pur.po_amount,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date,pur.po_status,grn.challan_date,grn.itemreceive_no_pk,grn.po_no
            item_q, total_purchase_amount
                  from inv_purchaseorder_vw pur
                   left join (select po_no,challan_date,itemreceive_no_pk,sum(order_qty*price) as total_purchase_amount, count(item_no_fk) as item_q from phr_grn_vw group by  challan_date,itemreceive_no_pk,po_no) grn on pur.purchaseorder_no_pk = grn.po_no
                   where pur.supplier_no_fk = $supplier_id and grn.po_no is null and pur.po_paid_ind = 0
                   group by grn.po_no,grn.itemreceive_no_pk,grn.challan_date,
                   pur.po_amount,pur.no_of_item,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date, pur.po_status, item_q, total_purchase_amount
                   order by pur.purchase_uid desc");
            // dd($supplier_po_info);
        } else {
            $supplier_po_info = DB::select("select pur.no_of_item,pur.po_amount,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date,pur.po_status,grn.challan_date,grn.itemreceive_no_pk,
        item_q, total_purchase_amount
              from inv_purchaseorder_vw pur
               inner join (select po_no,challan_date,itemreceive_no_pk,sum(order_qty*price) as total_purchase_amount, count(item_no_fk) as item_q from phr_grn_vw group by  challan_date,itemreceive_no_pk,po_no) grn on pur.purchaseorder_no_pk = grn.po_no
               where pur.supplier_no_fk = $supplier_id and pur.po_paid_ind = 0
               group by grn.po_no,grn.itemreceive_no_pk,grn.challan_date,
               pur.po_amount,pur.no_of_item,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date, pur.po_status, item_q, total_purchase_amount
               order by pur.purchase_uid desc");
        }
        //  else
        //  {
        //     $supplier_po_info = DB::select("select pur.po_amount,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date,pur.po_status,grn.challan_date,grn.itemreceive_no_pk,
        //     item_q, total_purchase_amount
        //           from inv_purchaseorder_vw pur
        //            left join (select po_no,challan_date,itemreceive_no_pk,sum(order_qty*price) as total_purchase_amount, count(item_no_fk) as item_q from phr_grn_vw group by  challan_date,itemreceive_no_pk,po_no) grn on pur.purchaseorder_no_pk = grn.po_no
        //            where pur.supplier_no_fk = $supplier_id
        //            group by grn.po_no,grn.itemreceive_no_pk,grn.challan_date,
        //            pur.po_amount,pur.po_paid_amount,pur.po_discount,pur.purchase_date,pur.po_last_paid_date,pur.po_amount_deduct,pur.po_amount_discount,pur.purchaseorder_no_pk,pur.purchase_uid,pur.delivery_date, pur.po_status, item_q, total_purchase_amount
        //            order by pur.purchase_uid desc");
        //  }

        return response()->json([$supplier_po_info, $payment_vouchar]);
    }

    public function suplierPaymentPoStore(Request $request)
    {

        $po_id = $request->hdn_po_id;
        $hdn_supplier_id = $request->hdn_supplier_id;
        // dd($hdn_supplier_id);
        $payment_amount = floor($request->total_paid);
        $payment_deduct = floor($request->total_diduct);
        $payment_discount = floor($request->discount_amt);
        $advance_amt = $request->total_advance;
        $regular_amt = $request->total_regular;
        $payment_regular_ind = $payment_advance_ind = $payment_deduct_ind = 0;
        if ($request->pay_type == "ADVANCE") {
            $payment_advance_ind = 1;
        }
        if ($request->pay_type == "REGULAR") {
            $payment_regular_ind = 1;
        }
        if ($request->pay_type == "DEDUCT") {
            $payment_deduct_ind = 1;
        }

        // if ($request->pay_type == 'REGULAR') {
        //     $payment_regular_ind = 1;
        // } elseif ($request->pay_type == 'ADVANCE') {
        //     $payment_advance_ind = 1;
        // } elseif ($request->pay_type == 'DEDUCT') {
        //     $payment_deduct_ind = 1;
        // }
        $payment_note = $request->payment_note;
        $bill_challan_number = $request->challan;
        $bill_challan_date = $request->challan_date ? date('Y-m-d', strtotime($request->challan_date)) : '';
        $pay_mode = $request->pay_mode;
        $pay_cqcc_number = $request->pay_cqcc_number ? $request->pay_cqcc_number : '';
        $pay_cqcc_holder_name = $request->pay_cqcc_holder_name ? $request->pay_cqcc_holder_name : '';
        $pay_bank_name = $request->pay_bank_name ? $request->pay_bank_name : '';
        $pay_mode_remarks = $request->pay_mode_remarks ? $request->pay_mode_remarks : '';

        $i = 0;
        $index = 0;
        $op_id_no = $op_amount = $po_paid_amount = $paid_amt = $due_amt = $paid_ind = $dis_amt = $po_amount_deduct = $entry_sl = [];
        for ($i = 0; $i < count($po_id); $i++) {
            $op_id_no[$i] = $po_id[$i];
            if ($request->paid_amt[$i] > 0 || $request->deduct_amt[$i] > 0) {

                $op_amount[$i] = $request->po_amount[$i];
                $po_paid_amount[$i] = $request->po_paid_amount[$i];
                $po_amount_deduct[$i] = $request->deduct_amt[$i];
                $dis_amt[$i] = ($request->discout_amt[$i] != "" || $request->discout_amt[$i] != "NaN") ? $request->discout_amt[$i] : 0;
                $paid_amt[$i] = $request->paid_amt[$i];
                // dd($request->po_paid_amount[$i] , $request->paid_amt[$i] , $request->po_amount[$i], $dis_amt[$i]);
                $due_amt[$i] = ($request->po_paid_amount[$i] + $request->paid_amt[$i]) != null ? floor($request->po_amount[$i]) - (($request->po_paid_amount[$i] + floor($request->paid_amt[$i])) - $dis_amt[$i]) : 1;

                $paid_ind[$i] = $due_amt[$i] <= 0  ? 1 : 0;
                $entry_sl[$i] = $index + 1;
                $index++;
            }
        }
        //  dd($op_id_no, $op_amount ,$po_paid_amount, $paid_amt ,$due_amt, $paid_ind ,$dis_amt, $po_amount_deduct ,$entry_sl);


        $op_id_no_rep = array_values($op_id_no);
        $op_amount_rep = array_values($op_amount);
        $po_paid_amount_rep = array_values($po_paid_amount);
        $po_amount_deduct_rep = array_values($po_amount_deduct);
        $paid_amt_rep = array_values($paid_amt);
        $due_amt_rep = array_values($due_amt);
        $dis_amt_rep = array_values($dis_amt);
        $paid_ind_rep = array_values($paid_ind);
        $entry_sl_rep = array_values($entry_sl);
        //    dd($op_id_no_rep, $op_amount_rep, $po_paid_amount_rep,$po_amount_deduct_rep, $paid_amt_rep,  $due_amt_rep, $paid_ind_rep,$entry_sl_rep,$dis_amt_rep);
        // dd($paid_amt_rep);
        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {
        $payment_date = date('Y-m-d');
        $entry_session = "session";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $numelems = 200;
        $outError = $out_supledger_no_pk = $out_supledger_uid = '';
        $pdo = DB::getPdo();
        $supllierPayment = $pdo->prepare("begin inv_inventory.prc_supplier_payment(
            :in_supplier_no_fk,
            :in_payment_date,
            :in_payment_amount,
            :in_payment_deduct,
            :in_payment_discount,
            :in_payment_regular_ind,
            :in_payment_advance_ind,
            :in_payment_deduct_ind,
            :in_payment_note,
            :in_bill_challan_number,
            :in_bill_challan_date,
            :in_pay_mode,
            :in_pay_cqcc_number,
            :in_pay_cqcc_holder_name,
            :in_pay_bank_name,
            :in_pay_mode_remarks,
            :in_a_purchaseorder_no_fk,
            :in_a_purchase_uid,
            :in_a_po_amount_payment,
            :in_a_po_amount_deduct,
            :in_a_po_amount_discount,
            :in_a_po_amount,
            :in_a_po_fullpaid_ind,
            :in_a_entry_serial_dtl,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_supledger_no_pk,
            :out_supledger_uid,
            :out_error); end;");


        $supllierPayment->bindParam(':in_supplier_no_fk', $hdn_supplier_id);
        $supllierPayment->bindParam(':in_payment_date', $payment_date);
        $supllierPayment->bindParam(':in_payment_amount', $payment_amount);
        $supllierPayment->bindParam(':in_payment_deduct', $payment_deduct);
        $supllierPayment->bindParam(':in_payment_discount', $payment_discount);
        $supllierPayment->bindParam(':in_payment_regular_ind', $payment_regular_ind);
        $supllierPayment->bindParam(':in_payment_advance_ind', $payment_advance_ind);
        $supllierPayment->bindParam(':in_payment_deduct_ind', $payment_deduct_ind);
        $supllierPayment->bindParam(':in_payment_note', $payment_note);
        $supllierPayment->bindParam(':in_bill_challan_number', $bill_challan_number);
        $supllierPayment->bindParam(':in_bill_challan_date', $bill_challan_date);
        $supllierPayment->bindParam(':in_pay_mode', $pay_mode);
        $supllierPayment->bindParam(':in_pay_cqcc_number', $pay_cqcc_number);
        $supllierPayment->bindParam(':in_pay_cqcc_holder_name', $pay_cqcc_holder_name);
        $supllierPayment->bindParam(':in_pay_bank_name', $pay_bank_name);
        $supllierPayment->bindParam(':in_pay_mode_remarks', $pay_mode_remarks);

        $supllierPayment->bindArray(':in_a_purchaseorder_no_fk', $op_id_no_rep, count($op_id_no_rep), $numelems, SQLT_INT);
        $supllierPayment->bindArray(':in_a_purchase_uid', $op_id_no_rep, count($op_id_no_rep), $numelems, SQLT_CHR);
        $supllierPayment->bindArray(':in_a_po_amount_payment', $paid_amt_rep, count($paid_amt_rep), $numelems, SQLT_FLT);
        $supllierPayment->bindArray(':in_a_po_amount_deduct', $po_amount_deduct_rep, count($po_amount_deduct_rep), $numelems, SQLT_FLT);
        $supllierPayment->bindArray(':in_a_po_amount_discount', $dis_amt_rep, count($dis_amt_rep), $numelems, SQLT_FLT);
        $supllierPayment->bindArray(':in_a_po_amount', $op_amount_rep, count($op_amount_rep), $numelems, SQLT_FLT);
        $supllierPayment->bindArray(':in_a_po_fullpaid_ind', $paid_ind_rep, count($paid_ind_rep), $numelems, SQLT_INT);
        $supllierPayment->bindArray(':in_a_entry_serial_dtl', $entry_sl_rep, count($entry_sl_rep), $numelems, SQLT_INT);

        $supllierPayment->bindParam(':in_au_entry_by', $auth_id);
        $supllierPayment->bindParam(':in_au_entry_session', $entry_session);
        $supllierPayment->bindParam(':in_au_entry_hospital_no_fk', $hospital_id);
        $supllierPayment->bindParam(':out_supledger_no_pk', $out_supledger_no_pk, PDO::PARAM_INT);
        $supllierPayment->bindParam(':out_supledger_uid', $out_supledger_uid, PDO::PARAM_STR, 500);
        $supllierPayment->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
        //  dd($supllierPayment);
        $supllierPayment->execute();

        // $result = DB::executeProcedure($procedureName, $dataBindingArr);

        if ($outError == '000') {
            DB::commit();
            $message = ['msg' => 'supplier payment successfully.', 'title' => 'Success', 'insert_id' => $out_supledger_no_pk];
        } else {

            DB::rollback();
            $message = ['msg' => 'supplier payment successfully Failed' . $outError, 'title' => 'Error', 'msg' => 'paid not successfull'];
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error', 'msg' => 'paid not successfull'];
        // }

        return response()->json($message);
    }

    public function suplierPaymentinvoice($invoice_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $payment_info = DB::table('inv_supplierpayment_po_vw')->where('supledger_no_pk', $invoice_id)->get();
        $supplier_info = DB::table('inv_supplierpayment_po_vw')->where('supledger_no_pk', $invoice_id)->first();
        $suppledger_id = $invoice_id;

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.supplier_payment_invoice", ['payment_info' => $payment_info, 'po_hospital_details' => $po_hospital_details, 'supplier_info' => $supplier_info, 'suppledger_id' => $suppledger_id]);
    }
    public function suplierPaymentInvoicePrint($invoice_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $payment_info = DB::table('inv_supplierpayment_po_vw')->where('supledger_no_pk', $invoice_id)->get();
        $supplier_info = DB::table('inv_supplierpayment_po_vw')->where('supledger_no_pk', $invoice_id)->first();
        $user = session::get('user.ses_user_name');
        $barcode = new BarcodeGenerator();
        $barcode->setText($supplier_info->supplier_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.supplier_payment_invoice_print", ['payment_info' => $payment_info, 'po_hospital_details' => $po_hospital_details, 'supplier_info' => $supplier_info, 'user' => $user, 'invoice_barcode' => $invoice_barcode])->setPaper('a5', 'portrait');
        return $pdf->stream("supplier payment invoice.pdf", array("Attachment" => false));
    }

    public function SuppliPaymentRequestProcurement()
    {
        // $grn_data = DB::table('phr_itemgrn_worklist_vw')->select('itemreceive_no_pk', 'challan_no', 'serviceunit_name', 'supplier_name', 'po_no', 'vat_amount', 'discount_amount', 'item_qty', 'cost_price', 'rtn_item_qty')->where('itemreceive_no_pk', 4623)->get();
        // dd( $grn_data);

        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        return Template::loadview("admin.supplier_payment.supplier_payment_request_procurement", compact('supplier_list'));
    }
    public function SuppliPaymentRequestProcurementSearch(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $grn_no = $request->grn_no;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query =
            DB::table('phr_itemgrn_worklist_vw')->select(
                'itemreceive_no_pk',
                'serviceunit_name',
                'itemreceive_uid',
                'supplier_name',
                'po_no',
                'purchase_uid',
                'store_su_no_fk',
                'supplier_no_fk',
                'challan_no',
                DB::raw('sum(NVL(discount_amount_itm,0)) as discount_amount'),
                DB::raw('sum(NVL(vat_amount_itm,0)) as vat_amount'),
                DB::raw('ait_amount as ait_amount'),
                DB::raw('sum(NVL(ser_charge_amount_itm,0)) as ser_charge_amount_itm'),
                DB::raw('sum(NVL(item_qty,0) * NVL(trade_price,0)) as total_grn_amt'),
                DB::raw('sum(NVL(rtn_item_qty,0) * NVL(trade_price,0)) as return_amt'),
                DB::raw('(sum(NVL(item_qty,0) * NVL(trade_price,0)) + sum(NVL(vat_amount_itm,0))+ nvl(ait_amount,0) + sum(NVL(ser_charge_amount_itm,0))) - (sum(NVL(rtn_item_qty,0) * NVL(trade_price,0))  + sum(NVL(discount_amount_itm,0))) as current_amt')
            );

            // dd($query->get());

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('grn_date', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('grn_date', $date_from);
        }

        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'itemreceive_uid' : 'itemreceive_no_pk';
            $query->where($column, $grn_no);
        }

        if ($supplier != "") {
            $query->where('supplier_no_fk', $supplier);
        }
        $grn_data = $query->whereIn('store_su_no_fk', function ($query) {
            $query->select('serviceunit_no_pk')
                ->where('user_no_pk', Auth::id())
                ->where('main_store_ind', 1)
                ->where('status', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->from('sysc_v1_grant_servieceunit_vw');
        })->whereNotIn('itemreceive_no_pk', function ($query) {
            $query->select('itemreceive_no_fk')
                ->from('inv_supp_payment_reqdtl');
        })->groupBy('itemreceive_no_pk','itemreceive_uid',  'serviceunit_name', 'supplier_name', 'po_no','purchase_uid', 'store_su_no_fk', 'supplier_no_fk', 'challan_no', 'ait_amount')->get();
        // dd( $grn_data);
        if(Session::get('user.ses_hospital_code') == "KPJ") {
             return Template::loadview("admin.supplier_payment.supplier_payment_request_procurement_list_kpj", ['grn_data' => $grn_data]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_request_procurement_list", ['grn_data' => $grn_data]);
        }

    }
    public function SuppliPaymentRequestWorklist()
    {
        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();

        return Template::loadview("admin.supplier_payment.supplier_payment_request_worklist", compact('supplier_list'));
    }
    public function SuppliPaymentRequestSearch(Request $request)
    {
        $grn_no = $request->grn_no;
        $status = $request->status;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_supp_payment_reqdtl')
            ->select('inv_supp_payment_reqdtl.*','phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid',
            'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name','inv_purchaseorder_mst.purchaseorder_no_pk', 'inv_purchaseorder_mst.purchase_uid'
            )
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_supp_payment_reqdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_supp_payment_reqdtl.serviceunit_no_fk_ms')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_supp_payment_reqdtl.supplier_no_fk');

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_supp_payment_reqdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_supp_payment_reqdtl.au_entry_at', $date_from);
        }

        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_supp_payment_reqdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }
        if ($supplier != "") {
            $query->where('supplier_no_fk', $supplier);
        }
        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_supp_payment_reqdtl.approval_ind', 1);
            } else {
                $query->where('inv_supp_payment_reqdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('pmnt_reqdtl_no_pk', 'desc')->get();

        // dd($grn_data);

        if(Session::get('user.ses_hospital_code') == "KPJ") {
            return Template::loadview("admin.supplier_payment.supplier_payment_request_list_kpj", ['grn_data_arr' => $grn_data]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_request_list", ['grn_data_arr' => $grn_data]);
        }


    }
    public function SuppliPaymentRequestPdf($id)
    {
        $grn_data = DB::table('inv_supp_payment_reqdtl')->select('inv_supp_payment_reqdtl.*', 'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name', 'phr_itemreceivemst.bill_or_invoice_no')
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_supp_payment_reqdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_supp_payment_reqdtl.itemreceive_no_fk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_supp_payment_reqdtl.supplier_no_fk')
            ->where('inv_supp_payment_reqdtl.pmnt_reqmst_no_fk', $id)->orderby('pmnt_reqdtl_no_pk', 'desc')->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $title = $id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.supplier_payment.supplier_payment_request_pdf", ['grn_data_arr' => $grn_data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo])->setPaper('a4', 'portrait');
        return $pdf->stream('supplier_payment_request_pdf.pdf');
        // return Template::loadview("admin.supplier_payment.supplier_payment_request_pdf", ['grn_data_arr' => $grn_data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details,'userInfo'=>$userInfo]);
    }
    public function SuppliPaymentProcurmentWorklist()
    {
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();


        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        return Template::loadview("admin.supplier_payment.supplier_payment_procurment_worklist", ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list]);
    }


    public function SuppliPaymentProcurmentSearch(Request $request)
    {
        $grn_no = $request->grn_no;
        $status = $request->status;
        $department = $request->department;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_supp_payment_reqdtl')->select('inv_supp_payment_reqdtl.*','phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid',
         'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name', 'wsec_user.user_fullname','inv_purchaseorder_mst.purchaseorder_no_pk', 'inv_purchaseorder_mst.purchase_uid')
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_supp_payment_reqdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_supp_payment_reqdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_supp_payment_reqdtl.supplier_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_supp_payment_reqdtl.au_entry_by')
            ->whereNotIn('itemreceive_no_fk', function ($query) {
                $query->select('itemreceive_no_fk')
                    ->from('inv_accbillprocessdtl');
            });

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_supp_payment_reqdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_supp_payment_reqdtl.au_entry_at', $date_from);
        }
        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_supp_payment_reqdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }

        if ($department != "") {
            $query->where('inv_supp_payment_reqdtl.serviceunit_no_fk_ms', $department);
        }
        if ($supplier != "") {
            $query->where('inv_supp_payment_reqdtl.supplier_no_fk', $supplier);
        }
        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_supp_payment_reqdtl.approval_ind', 1);
            } else {
                $query->where('inv_supp_payment_reqdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('pmnt_reqdtl_no_pk', 'desc')->get();
        // dd($grn_data);
        if(Session::get('user.ses_hospital_code') == "KPJ") {
            return Template::loadview("admin.supplier_payment.supplier_payment_procurment_list_kpj", ['grn_data_arr' => $grn_data]);
        } else
        {
           return Template::loadview("admin.supplier_payment.supplier_payment_procurment_list", ['grn_data_arr' => $grn_data]);
        }
    }
    public function SuppliPaymentSendToAccountsWorklist()
    {
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();

        return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts_worklist", ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list]);
    }
    public function SuppliPaymentSendToAccountsSearch(Request $request)
    {
        $grn_no = $request->grn_no;
        $status = $request->status;
        $department = $request->department;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_supp_payment_reqdtl')->select('inv_supp_payment_reqdtl.*','phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid',
         'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name', 'inv_accbillprocessdtl.accbillprocessdtl_no_pk', 'inv_accbillprocessdtl.approval_ind'
         ,'inv_purchaseorder_mst.purchaseorder_no_pk', 'inv_purchaseorder_mst.purchase_uid'
         )
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_supp_payment_reqdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_supp_payment_reqdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_supp_payment_reqdtl.supplier_no_fk')
            ->leftJoin('inv_accbillprocessdtl', 'inv_accbillprocessdtl.itemreceive_no_fk', '=', 'inv_supp_payment_reqdtl.itemreceive_no_fk')
            ->where('inv_supp_payment_reqdtl.approval_ind', 1);

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_supp_payment_reqdtl.approval_date', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_supp_payment_reqdtl.approval_date', $date_from);
        }
        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_supp_payment_reqdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }

        if ($supplier != "") {
            $query->where('inv_supp_payment_reqdtl.supplier_no_fk', $supplier);
        }
        if ($department != "") {
            $query->where('inv_supp_payment_reqdtl.serviceunit_no_fk_ms', $department);
        }
        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_supp_payment_reqdtl.approval_ind', 1);
            } else {
                $query->where('inv_supp_payment_reqdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('pmnt_reqdtl_no_pk', 'desc')->get();

        if(Session::get('user.ses_hospital_code') == "KPJ") {
            return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts_list_kpj", ['grn_data_arr' => $grn_data]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts_list", ['grn_data_arr' => $grn_data]);
        }
    }
    public function SuppliPaymentSendToAccountsSave(Request $request)
    {
        // dd($request->all());
        try {
            $id = '';
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $grn_arr = $request->payment_select;

            DB::beginTransaction();
            $sequence_mst = DB::getSequence();
            $sequenceNumberMst = $sequence_mst->nextValue('accbillprocessmst_no_pk_seq');

            $data_mst = [
                'process_by'               => $auth_id,
                'process_date'             => date("Y-m-d h:i:s"),
                'status'                   => 1,
                'au_entry_hospital_no_fk'  => $ses_hospital_id,
            ];
            // dd($data_mst);
            if ($id == null || $id == "") {
                $data_mst['accbillprocessmst_no_pk'] = $sequenceNumberMst;
                $data_mst['au_entry_at'] =  date("Y-m-d h:i:s");
                $data_mst['au_entry_by'] = $auth_id;
                DB::table('inv_accbillprocessmst')->insert($data_mst);
            } else {
                // $data_mst['au_update_at'] = date("Y-m-d h:i:s");
                // $data_mst['au_update_by'] = $auth_id;
                // DB::table('inv_supp_payment_reqmst')->update($data_mst, $id);
            }
            $grn_no = $po_no = $challan_no = $store_id = $supplier_no = $total_grn_amt = $return_amt = $current_amt = [];
            for ($i = 0; $i < count($grn_arr); $i++) {
                $grn_no[$i] = $grn_arr[$i];
                $pmnt_reqdtl_no_pk[$i] = $request->input('pmnt_reqdtl_no_pk_' . $grn_arr[$i]);
                $po_no[$i] = $request->input('po_no_' . $grn_arr[$i]);
                $challan_no[$i] = $request->input('challan_no_' . $grn_arr[$i]);
                $store_id[$i] = $request->input('store_no_' . $grn_arr[$i]);
                $supplier_no[$i] = $request->input('supplier_no_' . $grn_arr[$i]);
                $total_grn_amt[$i] = $request->input('total_grn_amt_' . $grn_arr[$i]);
                $return_amt[$i] = $request->input('return_amt_' . $grn_arr[$i]);
                $current_amt[$i] = $request->input('current_amt_' . $grn_arr[$i]);
                $sequence = DB::getSequence();
                $sequenceNumber = $sequence->nextValue('accbillprocessdtl_no_pk_seq');

                $data = [
                    'pmnt_reqdtl_no_fk'        => $pmnt_reqdtl_no_pk[$i],
                    'itemreceive_no_fk'        => $grn_no[$i],
                    'accbillprocessmst_no_fk'  =>  $sequenceNumberMst,
                    'purchaseorder_no_fk'      => $po_no[$i],
                    'challan_no'               => $challan_no[$i],
                    'serviceunit_no_fk_ms'     => $store_id[$i],
                    'supplier_no_fk'           => $supplier_no[$i],
                    'grnmst_amnt'              => $total_grn_amt[$i],
                    'grnrtn_amt'               => $return_amt[$i],
                    'payable_amnt'             => $current_amt[$i],
                    'au_entry_hospital_no_fk'  => $ses_hospital_id,
                ];
                // dd($data);
                if ($id == null || $id == "") {
                    $data['accbillprocessdtl_no_pk'] = $sequenceNumber;
                    $data['au_entry_at'] =  date("Y-m-d h:i:s");
                    $data['au_entry_by'] = $auth_id;
                    DB::table('inv_accbillprocessdtl')->insert($data);
                }
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function SuppliPaymentSendToAccountsList()
    {
        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts1", ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list]);
    }
    public function suppliPaymentSendToAccountsListSearch(Request $request)
    {

        $grn_no = $request->grn_no;
        $status = $request->status;
        $department = $request->department;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_accbillprocessdtl')
            ->select('inv_accbillprocessdtl.*','inv_purchaseorder_mst.purchaseorder_no_pk', 'inv_purchaseorder_mst.purchase_uid',
            'phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid',
            'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name'
            )
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_accbillprocessdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_accbillprocessdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_accbillprocessdtl.supplier_no_fk');

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_accbillprocessdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_accbillprocessdtl.au_entry_at', $date_from);
        }

        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_accbillprocessdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }

        if ($department != "") {
            $query->where('inv_accbillprocessdtl.serviceunit_no_fk_ms', $department);
        }
        if ($supplier != "") {
            $query->where('inv_accbillprocessdtl.supplier_no_fk', $supplier);
        }
        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_accbillprocessdtl.approval_ind', 1);
            } else {
                $query->where('inv_accbillprocessdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('inv_accbillprocessdtl.accbillprocessdtl_no_pk', 'desc')->get();

        if(Session::get('user.ses_hospital_code') == "KPJ") {
            return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts1_list_kpj", ['grn_data_arr' => $grn_data]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_send_to_accounts1_list", ['grn_data_arr' => $grn_data]);
        }


    }
    public function SuppliPaymentSendToAccountsAllPdf(Request $request)
    {

        $grn_no = $request->grn_no;
        $status = $request->status;
        $department = $request->department;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_accbillprocessdtl')->select('inv_accbillprocessdtl.*', 'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name')
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_accbillprocessdtl.serviceunit_no_fk_ms')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_accbillprocessdtl.supplier_no_fk');
        // ->leftJoin('inv_accbillprocessdtl','inv_accbillprocessdtl.itemreceive_no_fk','=','inv_supp_payment_reqdtl.itemreceive_no_fk')
        // ->where('inv_supp_payment_reqdtl.approval_ind',1);

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_accbillprocessdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_accbillprocessdtl.au_entry_at', $date_from);
        }
        if ($grn_no != "") {
            $query->where('inv_accbillprocessdtl.itemreceive_no_fk', $grn_no);
        }
        if ($department != "") {
            $query->where('inv_accbillprocessdtl.serviceunit_no_fk_ms', $department);
        }
        if ($supplier != "") {
            $query->where('inv_accbillprocessdtl.supplier_no_fk', $supplier);
        }
        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_accbillprocessdtl.approval_ind', 1);
            } else {
                $query->where('inv_accbillprocessdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('inv_accbillprocessdtl.accbillprocessdtl_no_pk', 'desc')->get();
        return View("admin.supplier_payment.supplier_payment_send_to_accounts1_excel", ['grn_data_arr' => $grn_data]);
        // dd( $grn_data);
        // $pdf =  ['grn_data_arr' => $grn_data];
        // $fileToExport = "supplier_list";
        // $html = View("admin.supplier_payment.supplier_payment_send_to_accounts1_excel")->with($pdf);
        // header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        // header("Content-type: application/vnd.ms-excel");
        // return $html;

    }
    public function SuppliPaymentSendToAccountsPdf($id)
    {
        $grn_data = DB::table('inv_accbillprocessdtl')->select('inv_accbillprocessdtl.*', 'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name', 'phr_itemreceivemst.bill_or_invoice_no')
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_accbillprocessdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_accbillprocessdtl.itemreceive_no_fk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_accbillprocessdtl.supplier_no_fk')
            ->where('inv_accbillprocessdtl.accbillprocessmst_no_fk', $id)->orderby('accbillprocessmst_no_fk', 'desc')->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $title = $id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.supplier_payment.supplier_payment_send_to_accounts1_pdf", ['grn_data_arr' => $grn_data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo])->setPaper('a4', 'portrait');
        return $pdf->stream('supplier_payment_request_pdf.pdf');
        // return Template::loadview("admin.supplier_payment.supplier_payment_request_pdf", ['grn_data_arr' => $grn_data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details,'userInfo'=>$userInfo]);
    }
    public function SuppliPaymentAccountsWorklist()
    {
        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        return Template::loadview("admin.supplier_payment.supplier_payment_accounts_worklist", ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list]);
    }
    public function SuppliPaymentAccountsSearch(Request $request)
    {
        $grn_no = $request->grn_no;
        $status = $request->status;
        $department = $request->department;
        $supplier = $request->supplier;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_accbillprocessdtl')->select('inv_accbillprocessdtl.*', 'sysc_serviceunit_vw.serviceunit_name', 'inv_supplier.supplier_name'
        ,'inv_purchaseorder_mst.purchaseorder_no_pk', 'inv_purchaseorder_mst.purchase_uid', 'phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid'
        )
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_accbillprocessdtl.serviceunit_no_fk_ms')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_accbillprocessdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_accbillprocessdtl.supplier_no_fk');
        // ->leftJoin('inv_accbillprocessdtl','inv_accbillprocessdtl.itemreceive_no_fk','=','inv_supp_payment_reqdtl.itemreceive_no_fk')
        // ->where('inv_supp_payment_reqdtl.approval_ind',1);

        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('inv_accbillprocessdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_accbillprocessdtl.au_entry_at', $date_from);
        }

        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_accbillprocessdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }

        if ($supplier != "") {
            $query->where('inv_accbillprocessdtl.supplier_no_fk', $supplier);
        }
        if ($department != "") {
            $query->where('inv_accbillprocessdtl.serviceunit_no_fk_ms', $department);
        }

        if ($status != "") {
            if ($status == 1) {
                $query->where('inv_accbillprocessdtl.approval_ind', 1);
            } else {
                $query->where('inv_accbillprocessdtl.approval_ind', null);
            }
        }
        $grn_data = $query->orderby('inv_accbillprocessdtl.accbillprocessdtl_no_pk', 'desc')->get();

        if(Session::get('user.ses_hospital_code') == "KPJ") {
            return Template::loadview("admin.supplier_payment.supplier_payment_accounts_list_kpj", ['grn_data_arr' => $grn_data]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_accounts_list", ['grn_data_arr' => $grn_data]);
        }
    }
    public function SuppliPaymentAccountsSave(Request $request)
    {
        // dd($request->all());
        try {
            $auth_id = Auth::id();
            $grn_arr = $request->payment_select;
            DB::beginTransaction();

            $grn_no = $po_no = $challan_no = $store_id = $supplier_no = $total_grn_amt = $return_amt = $current_amt = [];
            for ($i = 0; $i < count($grn_arr); $i++) {
                $grn_no[$i] = $grn_arr[$i];
                $data = [
                    'approval_ind'  => 1,
                    'approval_by'   => $auth_id,
                    'approval_date' =>  date("Y-m-d h:i:s"),
                ];
                DB::table('inv_accbillprocessdtl')->where('itemreceive_no_fk', $grn_no[$i])->update($data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function SuppliPaymentApprovalSave(Request $request)
    {
        // dd($request->all());
        try {
            $id = '';
            $grn_arr = $request->payment_select;
            DB::beginTransaction();
            $grn_no = [];
            for ($i = 0; $i < count($grn_arr); $i++) {
                $grn_no[$i] = $grn_arr[$i];
                $data = [
                    'approval_ind' => 1,
                    'approval_by' => Auth::id(),
                    'approval_date' => date('Y-m-d h:i'),
                ];
                // dd($data);

                SupplierPaymentRequest::where('itemreceive_no_fk', $grn_no[$i])->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function SuppliPaymentRequestSave(Request $request)
    {
        //  dd($request->all());
        try {
            $id = '';
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $grn_arr = $request->payment_select;
            DB::beginTransaction();
            $sequence_mst = DB::getSequence();
            $sequenceNumberMst = $sequence_mst->nextValue('pmnt_reqmst_no_pk_seq');

            $data_mst = [
                'request_ind'              => 1,
                'request_by'               => $auth_id,
                'request_date'             => date("Y-m-d h:i:s"),
                'au_entry_hospital_no_fk'  => $ses_hospital_id,
            ];
            // dd($data_mst);
            if ($id == null || $id == "") {
                $data_mst['pmnt_reqmst_no_pk'] = $sequenceNumberMst;
                $data_mst['au_entry_at'] =  date("Y-m-d h:i:s");
                $data_mst['au_entry_by'] = $auth_id;
                DB::table('inv_supp_payment_reqmst')->insert($data_mst);
            } else {
                // $data_mst['au_update_at'] = date("Y-m-d h:i:s");
                // $data_mst['au_update_by'] = $auth_id;
                // DB::table('inv_supp_payment_reqmst')->update($data_mst, $id);
            }
            $grn_no = $po_no = $challan_no = $store_id = $supplier_no = $total_grn_amt = $return_amt = $current_amt = [];
            for ($i = 0; $i < count($grn_arr); $i++) {
                $grn_no[$i] = $grn_arr[$i];
                $po_no[$i] = $request->input('po_no_' . $grn_arr[$i]);
                $challan_no[$i] = $request->input('challan_no_' . $grn_arr[$i]);
                $store_id[$i] = $request->input('store_no_' . $grn_arr[$i]);
                $supplier_no[$i] = $request->input('supplier_no_' . $grn_arr[$i]);
                $total_grn_amt[$i] = ($request->input('total_grn_amt_' . $grn_arr[$i]) + $request->input('vat_amt_' . $grn_arr[$i]) +   $request->input('alt_amt_' . $grn_arr[$i]) +   $request->input('ser_charge_amount_itm_' . $grn_arr[$i])) - $request->input('discount_' . $grn_arr[$i]);
                $return_amt[$i] = $request->input('return_amt_' . $grn_arr[$i]);
                $current_amt[$i] = $request->input('current_amt_' . $grn_arr[$i]);
                $sequence = DB::getSequence();
                $sequenceNumber = $sequence->nextValue('pmnt_reqdtl_no_pk_seq');

                $data = [
                    'itemreceive_no_fk'        => $grn_no[$i],
                    'pmnt_reqmst_no_fk'        =>  $sequenceNumberMst,
                    'purchaseorder_no_fk'      => $po_no[$i],
                    'challan_no'               => $challan_no[$i],
                    'serviceunit_no_fk_ms'     => $store_id[$i],
                    'supplier_no_fk'           => $supplier_no[$i],
                    'grnmst_amnt'              => $total_grn_amt[$i],
                    'grnrtn_amt'               => $return_amt[$i],
                    'payable_amnt'             => $current_amt[$i],
                    'au_entry_hospital_no_fk'  => $ses_hospital_id,
                ];
                if ($id == null || $id == "") {
                    $data['pmnt_reqdtl_no_pk'] = $sequenceNumber;
                    $data['au_entry_at'] =  date("Y-m-d h:i:s");
                    $data['au_entry_by'] = $auth_id;
                    SupplierPaymentRequest::insert($data);
                }
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Show the Supplier Profile under the menu "Supply Chain Management"
     */
    public function profile()
    {
        $suppliers = DB::table('inv_supplier')
            ->where('au_entry_hospital_pk_no', session('user.ses_hospital_no_pk'))
            ->orderByRaw('lower(supplier_name) asc')
            ->select('SUPPLIER_NO_PK', 'SUPPLIER_NAME')
            ->get();

        $purchaseOrders = DB::select("select
            supp.supplier_name, purchaseorder_no_pk, purchase_uid, purchase_date, po_doc_attachment_path
            from inv_purchaseorder_mst po, inv_supplier supp
            where po.supplier_no_fk = supp.supplier_no_pk
            order by 2
        ");
        $purchaseOrders = collect($purchaseOrders)->groupBy('supplier_name');

        return Template::loadview("admin.supplier.profile", [
            'suppliers'         => $suppliers,
            'purchaseOrders'    => $purchaseOrders
        ]);
    }

    /**
     * Supplier Profile Filter
     */
    public function profileFilter(Request $request)
    {
        $supplier_no_pk = $request->input('supplier_id');
        $indent_date_from = date('d/m/Y', strtotime($request->input('indent_date_from')));
        $indent_date_to = date('d/m/Y', strtotime($request->input('indent_date_to')));

        $supplierQuery = '';
        $dateRangePart = '';
        if (!empty($supplier_no_pk)) {
            $supplierQuery = " and supp.supplier_no_pk = $supplier_no_pk ";
        }

        if (!empty($indent_date_from) && !empty($indent_date_to)) {
            $dateRangePart = " and trunc(purchase_date) between to_date('" . $indent_date_from . "','dd/mm/yyyy') and to_date('" . $indent_date_to . "','dd/mm/yyyy') ";
        }

        $purchaseOrders = DB::select("select
            supp.supplier_name, purchaseorder_no_pk, purchase_uid, purchase_date, po_doc_attachment_path
            from inv_purchaseorder_mst po, inv_supplier supp
            where po.supplier_no_fk = supp.supplier_no_pk
            $supplierQuery
            $dateRangePart
            order by 2
        ");

        $purchaseOrders = collect($purchaseOrders)->groupBy('supplier_name');

        return Template::loadview("admin.supplier.purchaseOrdersTable", [
            'purchaseOrders'    => $purchaseOrders
        ]);
    }




    public function supplierPaymentWorklist()
    {
        $chartof_accounts = $this->chart_of_acc->get_chart_of_account();

        $chartof_accounts = collect($chartof_accounts->getData()->data)
            ->whereIn('bank_ind', [
                AccountIndicator::PETTY_CASH,
                AccountIndicator::BANK,
                AccountIndicator::CASH
            ])
            ->where('control_acc_ind', 1);

            // dd($chartof_accounts);


        $voucher_type = db::table('acct_voucher_type')
            ->select('voucher_type_no_pk', 'voucher_type_name')
            ->where('voucher_type_code' , "PV")
            // ->whereraw('lower(voucher_type_name) like ?', ['%payment%'])
            ->get();
        // dd($voucher_type);
        $verifiedChequeNos = DB::table('acct_checquedtl')
            ->select('checque_no', 'checquedtl_no_pk')
            ->whereRaw('NVL(use_ind, 0) = 0')
            ->whereRaw('NVL(status, 0) = 1')
            ->get();

        $supplier_list = DB::table('suppliers_vw')->select('supplier_no_pk', 'supplier_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();

        if(Session::get('user.ses_hospital_code') == "KPJ") {
             return Template::loadview("admin.supplier_payment.supplier_payment_worklist_v2_kpj",
             ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list, 'chartof_accounts' => $chartof_accounts,
             'voucher_type' => $voucher_type, 'verifiedChequeNos' => $verifiedChequeNos]);
        } else
        {
            return Template::loadview("admin.supplier_payment.supplier_payment_worklist_v1",
             ['main_store_list' => $main_store_list, 'supplier_list' => $supplier_list, 'chartof_accounts' => $chartof_accounts,
             'voucher_type' => $voucher_type, 'verifiedChequeNos' => $verifiedChequeNos]);
        }



    }


    public function SuppliPaymentSearch(Request $request)
    {
        // dd($request->all());
        $grn_no = $request->grn_no;
        $supplier = $request->supplier;

        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        $query = DB::table('inv_accbillprocessdtl')->select(
            'inv_accbillprocessdtl.*',
            'sysc_serviceunit_vw.serviceunit_name',
            'inv_supplier.supplier_name',
            'phr_itemreceivemst.itemreceive_no_pk','phr_itemreceivemst.itemreceive_uid',
            'inv_purchaseorder_mst.purchaseorder_no_pk','inv_purchaseorder_mst.purchase_uid',
            DB::raw("
                        (SELECT NVL(SUM(grn_amt),0)
                                FROM inv_accsupplierpaymentdtl
                                WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                            ) as paid_amount
                        "),
            DB::raw("
                        (SELECT NVL(SUM(paymentdtl_vat),0)
                                FROM inv_accsupplierpaymentdtl
                                WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                            ) as vat_amount
                        "),
            DB::raw("
                        (SELECT NVL(SUM(paymentdtl_tax),0)
                                FROM inv_accsupplierpaymentdtl
                                WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                            ) as tax_amount
                        ")
        )
            ->leftJoin('sysc_serviceunit_vw', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'inv_accbillprocessdtl.serviceunit_no_fk_ms')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_accbillprocessdtl.supplier_no_fk')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'inv_accbillprocessdtl.itemreceive_no_fk')
            ->leftJoin('inv_purchaseorder_mst', 'phr_itemreceivemst.purchaseorder_no_pk', '=', 'inv_purchaseorder_mst.purchaseorder_no_pk')
            ->where('inv_accbillprocessdtl.approval_ind', 1);

        //   dd($query);


        if (!empty($date_from) && !empty($date_to)) {
            $query->whereBetween('inv_accbillprocessdtl.au_entry_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);
        } elseif (!empty($date_from)) {
            $query->whereDate('inv_accbillprocessdtl.au_entry_at', $date_from);
        } elseif (!empty($date_to)) {
            $query->whereDate('inv_accbillprocessdtl.au_entry_at', $date_to);
        }

        if (!empty($grn_no)) {
            $column = (Session::get('user.ses_hospital_code') == "KPJ") ? 'phr_itemreceivemst.itemreceive_uid' : 'inv_accbillprocessdtl.itemreceive_no_fk';
            $query->where($column, $grn_no);
        }

        if (!empty($supplier)) {
            $query->where('inv_supplier.supplier_no_pk', $supplier);
        }


        $payment_status = $request->payment_status;
        if (!empty($payment_status) && $payment_status == 1) {

            $query->whereRaw(DB::raw("
            (SELECT NVL(SUM(grn_amt),0)+NVL(SUM(paymentdtl_tax),0)+NVL(SUM(paymentdtl_vat),0)
                    FROM inv_accsupplierpaymentdtl
                    WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                ) = 0
            "));

        }
        if (!empty($payment_status) && $payment_status == 2) {
            $query->whereRaw(DB::raw("
            (SELECT NVL(SUM(grn_amt),0)+NVL(SUM(paymentdtl_tax),0)+NVL(SUM(paymentdtl_vat),0)
                    FROM inv_accsupplierpaymentdtl
                    WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                ) > 0
            "));
            $query->whereRaw(DB::raw("
            (SELECT NVL(SUM(grn_amt),0)+NVL(SUM(paymentdtl_tax),0)+NVL(SUM(paymentdtl_vat),0)
                    FROM inv_accsupplierpaymentdtl
                    WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                ) != inv_accbillprocessdtl.payable_amnt
            "));
        }

        if (!empty($payment_status) && $payment_status == 3) {
            $query->whereRaw(DB::raw("
            (SELECT NVL(SUM(grn_amt),0)+NVL(SUM(paymentdtl_tax),0)+NVL(SUM(paymentdtl_vat),0)
                    FROM inv_accsupplierpaymentdtl
                    WHERE inv_accsupplierpaymentdtl.itemreceive_no_fk = inv_accbillprocessdtl.itemreceive_no_fk
                ) = inv_accbillprocessdtl.payable_amnt
            "));
        }

        $grn_data = $query->orderby('inv_accbillprocessdtl.accbillprocessdtl_no_pk', 'desc')->get();

        // dd($grn_data);

        return response()->json(['data' => $grn_data, 'success' => true], 200);
    }

    public function grnBillProgress($id)
    {
        $data = DB::table("grn_tracking_vw")
            ->where('itemreceive_no_pk', $id)
            ->select(
                'PO_NO',
                'PO_DATE',
                'ITEMRECEIVE_NO_PK',
                'GRN_DATE',
                'BILLSENDDATEP',
                'BILLSENDDATEACC',
                'BILLRECDATEP',
                'BILLRECDATEACC',
            )
            ->first();


        $payment_data = DB::table('inv_accsupplierpaymentdtl')
            ->leftJoin('inv_accsupplierpaymentmst', 'inv_accsupplierpaymentmst.ACCSUPPLIERPAYMENTMST_NO_PK', 'inv_accsupplierpaymentdtl.ACCSUPPLIERPAYMENTMST_NO_FK')
            ->select(
                'inv_accsupplierpaymentmst.journal_code',
                'inv_accsupplierpaymentdtl.remarks',
                'inv_accsupplierpaymentdtl.payment_date',
                'inv_accsupplierpaymentdtl.grn_amt',
                'inv_accsupplierpaymentdtl.accsupplierpaymentdtl_no_pk',
                'inv_accsupplierpaymentdtl.itemreceive_no_fk'
            )
            ->where('inv_accsupplierpaymentdtl.itemreceive_no_fk', $id)
            ->where('inv_accsupplierpaymentdtl.status', 1)
            ->orderBy('inv_accsupplierpaymentdtl.accsupplierpaymentdtl_no_pk')
            ->get();

        return Template::loadview("admin.supplier_payment.modal.grn_bill_progress", compact('data', 'payment_data'));
    }


    public function partialSupplierPayment($id)
    {

        $chartof_accounts = $this->chart_of_acc->get_chart_of_account();

        $chartof_accounts = collect($chartof_accounts->getData()->data)
            ->whereIn('bank_ind', [1, 2])
            ->where('control_acc_ind', 1);


        $voucher_type = db::table('acct_voucher_type')
            ->select('voucher_type_no_pk', 'voucher_type_name')
            ->whereraw('lower(voucher_type_name) like ?', ['%payment%'])
            ->get();
        $verifiedChequeNos = DB::table('acct_checque_verified_listing')
            ->select('checque_no')
            ->whereRaw('NVL(cheque_dispach_ind, 0) = 0')
            ->whereRaw('NVL(status, 0) = 1')
            ->get();

        $payment_data = DB::table('inv_accsupplierpaymentdtl')->where('itemreceive_no_fk', $id)->where('status', 1)->get();
        $total_amount = DB::table('inv_accbillprocessdtl')->where('itemreceive_no_fk', $id)->value('payable_amnt');

        $current_payment = DB::table('inv_accsupplierpaymentdtl')
            ->where('itemreceive_no_fk', $id)
            ->where('status', 1)
            ->get();

        $tax_payment = DB::table('inv_accsupplierpaymentdtl')
            ->where('itemreceive_no_fk', $id)
            ->where('status', 1)
            ->get();
        $vat_payment = DB::table('inv_accsupplierpaymentdtl')
            ->where('itemreceive_no_fk', $id)
            ->where('status', 1)
            ->get();


        $data = [];
        $data['total_payment'] = collect($payment_data)->sum('grn_amt');
        $data['current_payment'] = collect($current_payment)->sum('grn_amt');
        $data['tax_payment'] = collect($tax_payment)->sum('paymentdtl_tax');
        $data['vat_payment'] = collect($vat_payment)->sum('paymentdtl_vat');

        $data['due'] = $total_amount - ($data['current_payment'] + $data['tax_payment'] + $data['vat_payment']);
        $data['total_amount'] = $total_amount;
        $data['grn_no'] = $id;
        return Template::loadView("admin.supplier_payment.modal.pay_supplier_partial_payment", [
            'data' => $data,
            'grn_no' => $id,
            'chartof_accounts' => $chartof_accounts,
            'voucher_type' => $voucher_type,
            'verifiedChequeNos' => $verifiedChequeNos
        ]);
    }

    public function partialSupplierPaymentEntry(Request $request)
    {
        $request->validate([
            'paid_amount' => 'required',
            'remarks'     => 'max:500',
            'grn_no'      => 'required',
        ]);

        try {
            $au_entry_at = now()->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session  = session()->get('user.ses_user_pk_no');
            $grn_no         = $request->grn_no;

            $payment_data = DB::table('inv_accsupplierpaymentdtl')
                ->where('itemreceive_no_fk', $grn_no)
                ->where('status', 1)
                ->get();

            $total_amount = DB::table('inv_accbillprocessdtl')
                ->where('itemreceive_no_fk', $grn_no)
                ->value('payable_amnt');

            $paid_amount = floatval(str_replace(",", "", $request->paid_amount));
            $prev_paid = $payment_data->sum('grn_amt');
            $total_paid = $paid_amount + $prev_paid;

            if ($paid_amount <= 0) {
                return response()->json(['title' => '', 'msg' => 'Zero amount is invalid', 'success' => false], 422);
            }

            if ($total_paid > $total_amount) {
                return response()->json(['title' => '', 'msg' => 'Paid amount can\'t exceed the due amount.', 'success' => false], 422);
            }

            // Insert into master table
            $seq_master = $this->getSequence('accsupplierpaymentmst_no_pk_seq');
            DB::table('inv_accsupplierpaymentmst')->insert([
                'accsupplierpaymentmst_no_pk' => $seq_master,
                'total_amt' => $paid_amount,
                'payment_date' => date('Y-m-d'),
                'status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_no_fk' => $hospital_pk_no,
            ]);

            $last_id = DB::table('inv_accsupplierpaymentmst')->max('accsupplierpaymentmst_no_pk');

            // Insert into detail table
            $seq = $this->getSequence('accsupplierpaymentdtl_no_pk_seq');

            DB::table('inv_accsupplierpaymentdtl')->insert([
                'accsupplierpaymentdtl_no_pk' => $seq,
                'itemreceive_no_fk' => $grn_no,
                'payment_date' => $au_entry_at,
                'grn_amt' => $paid_amount,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_no_fk' => $hospital_pk_no,
                'status' => 1,
                'remarks' => $request->remarks,
                'accsupplierpaymentmst_no_fk' => $last_id,
                'paymentdtl_vat' => $request->amount_vat,
                'paymentdtl_tax' => $request->amount_tax,
            ]);

            // Stored procedure call
            $pdo = DB::getPdo();
            $bill_info = DB::table('inv_accbillprocessdtl')
                ->where('itemreceive_no_fk', $grn_no)
                ->select('serviceunit_no_fk_ms', 'supplier_no_fk')
                ->first();

            $in_store_no_fk          = $bill_info->serviceunit_no_fk_ms;
            $in_supplier_no_fk       = $bill_info->supplier_no_fk;
            $in_narration            = 'Check Payable';
            $in_integration_type     = 'SUPPPAYMENT';
            $in_amount               = $paid_amount;
            $in_general_ledger       = $request->general_ledger ?? 0;
            $in_payment_type         = $request->payment_type ?? 'CASH PAYMENT';
            $in_cheque_no            = $request->cheque_no ?? 'NA';
            // $in_cheque_date          = $request->cheque_date ? date('d-M-Y', strtotime($request->cheque_date)) : null;
            $in_cheque_date          = $request->cheque_date ? date('Y-m-d', strtotime($request->cheque_date)) : null;
            $in_amount_vat           = $request->amount_vat ?? 0;
            $in_amount_tax           = $request->amount_tax ?? 0;
            $in_grn_no               = $grn_no ?? 0;
            $in_au_entry_by          = Auth::id();
            $in_au_entry_session     = $entry_session;
            $in_au_entry_hospital_pk_no = $hospital_pk_no;

            $out_jurnal_code = null;
            $out_error       = null;

            $supplier_payment = $pdo->prepare("begin pkg_v1_accounts.prc_journal_entrypayable(
                :in_STORE_no_fk,
                :in_supplier_no_fk,
                :in_narration,
                :in_integration_type,
                :in_amount,
                :in_gl_acc_no_fk,
                :in_payment_type,
                :in_check_no,
                :in_check_date,
                :in_vat_amt,
                :in_tax_amt,
                :in_grn_no,
                :in_AU_ENTRY_BY,
                :in_au_entry_session,
                :in_AU_ENTRY_HOSPITAL_PK_NO,
                :out_jurnal_code,
                :out_error
            ); end;");

            $supplier_payment->bindParam('in_STORE_no_fk', $in_store_no_fk);
            $supplier_payment->bindParam('in_supplier_no_fk', $in_supplier_no_fk);
            $supplier_payment->bindParam('in_narration', $in_narration);
            $supplier_payment->bindParam('in_integration_type', $in_integration_type);
            $supplier_payment->bindParam('in_amount', $in_amount);
            $supplier_payment->bindParam('in_gl_acc_no_fk', $in_general_ledger);
            $supplier_payment->bindParam('in_payment_type', $in_payment_type);
            $supplier_payment->bindParam('in_check_no', $in_cheque_no);
            $supplier_payment->bindParam('in_check_date', $in_cheque_date);
            $supplier_payment->bindParam('in_vat_amt', $in_amount_vat, PDO::PARAM_STR);
            $supplier_payment->bindParam('in_tax_amt', $in_amount_tax, PDO::PARAM_STR);
            $supplier_payment->bindParam('in_grn_no', $in_grn_no);
            $supplier_payment->bindParam('in_AU_ENTRY_BY', $in_au_entry_by);
            $supplier_payment->bindParam('in_au_entry_session', $in_au_entry_session);
            $supplier_payment->bindParam('in_AU_ENTRY_HOSPITAL_PK_NO', $in_au_entry_hospital_pk_no);
            $supplier_payment->bindParam('out_jurnal_code', $out_jurnal_code, PDO::PARAM_STR, 500);
            $supplier_payment->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $supplier_payment->execute();

            // Update master with journal code
            DB::table('inv_accsupplierpaymentmst')
                ->where('accsupplierpaymentmst_no_pk', $last_id)
                ->update(['journal_code' => $out_jurnal_code]);

            return response()->json(['title' => 'Success', 'msg' => 'Successfully Paid', 'success' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['title' => 'Failed', 'msg' => $th->getMessage(), 'success' => false], 422);
        }
    }

    public function partialSupplierPaymentHistory($id)
    {

        $payment_data = DB::table('inv_accsupplierpaymentdtl')
            ->select(

                'remarks',
                'payment_date',
                'grn_amt',
                'accsupplierpaymentdtl_no_pk',
                'itemreceive_no_fk'
            )
            ->where('itemreceive_no_fk', $id)
            ->where('status', 1)
            ->get();


        return Template::loadView("admin.supplier_payment.modal.supplier_payment_history", ['data' => $payment_data, 'grn_no' => $id]);
    }



    public function partialSupplierPaymentEntryAll(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'grn_no' => 'required',
            'amount' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            $seq_master = $this->getSequence('accsupplierpaymentmst_no_pk_seq');

            $data = [
                'accsupplierpaymentmst_no_pk' => $seq_master,
                'mst_remarks' => $request->remarks,
                'cheque_no' => $request->cheque_no,
                'total_amt' => array_sum($request->amount),
                'payment_date' => date('Y-m-d'),
                'status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_no_fk' => $hospital_pk_no,

            ];

            DB::table('inv_accsupplierpaymentmst')->insert($data);
            $last_id =  DB::table('inv_accsupplierpaymentmst')->orderByDesc('accsupplierpaymentmst_no_pk')->value('accsupplierpaymentmst_no_pk');

            foreach ($request->grn_no as $key => $value) {
                $grn_no = $value;

                $vat_amount = 0;
                $tax_amount = 0;


                if ($request->amount[$key] > 0) {

                    $payment_data = DB::table('inv_accsupplierpaymentdtl')->where('itemreceive_no_fk', $grn_no)->where('status', 1)->get();
                    $total_amount = DB::table('inv_accbillprocessdtl')->where('itemreceive_no_fk', $grn_no)->value('payable_amnt');

                    $paid_amount = str_replace(",", "", $request->amount[$key]);
                    $paid_amount = floatval($paid_amount);

                    $prev_paid = collect($payment_data)->sum('grn_amt');
                    $total_paid = floatVal($paid_amount) + floatVal($prev_paid);

                    if ($paid_amount  == 0 || empty($paid_amount)) {
                        return response()->json(['title' => '', 'message' => 'Zero amount is invalid', 'success' => ''], 422);
                    }
                    if ($total_paid > $total_amount) {
                        return response()->json(['title' => '', 'message' => 'Paid amount can\'t exceed the due amount.', 'success' => ''], 422);
                    }

                    $seq = $this->getSequence('accsupplierpaymentdtl_no_pk_seq');
                    $data = [
                        'accsupplierpaymentdtl_no_pk' => $seq,
                        'itemreceive_no_fk' => $grn_no,
                        'payment_date' => $au_entry_at,
                        'grn_amt' => $paid_amount,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_no_fk' => $hospital_pk_no,
                        'status' => 1,
                        'remarks' => $request->remarks,
                        'accsupplierpaymentmst_no_fk' => $last_id,
                        'paymentdtl_vat' => $request->amount_vat[$key],
                        'paymentdtl_tax' => $request->amount_tax[$key],
                    ];
                    DB::table('inv_accsupplierpaymentdtl')->insert($data);
                }
                // dd($data);
                $vat_amount += array_sum($request->amount_vat);
                $tax_amount += array_sum($request->amount_tax);
            }

            // dd($vat_amount, $tax_amount);
            // Accounts Integration Procedure call


            $in_au_entry_by = Auth::id();
            $in_au_entry_session = $entry_session;
            $in_au_entry_hospital_pk_no = $hospital_pk_no;

            $bill_info = DB::table('inv_accbillprocessdtl')->where('itemreceive_no_fk', $grn_no)->select('serviceunit_no_fk_ms', 'supplier_no_fk')->first();
            $in_store_no_fk =  $bill_info->serviceunit_no_fk_ms;
            $in_narration = 'Check Payable';
            $in_supplier_no_fk = $bill_info->supplier_no_fk;
            $in_integration_type = 'SUPPPAYMENT';
            $in_amount = array_sum($request->amount);
            $out_jurnal_code = null;

            $in_general_ledger       = $request->general_ledger ?? 0;
            $in_payment_type         = $request->payment_type ?? 'CASH PAYMENT';
            $in_cheque_no            = $request->cheque_no ?? 'NA';
            $checquedtl_no_pk        = $request->checquedtl_no_pk ?? 'NA';
            $in_pay_date             = $request->pay_date ? date('Y-m-d', strtotime($request->pay_date)) : null;
            $in_cheque_date          = $request->cheque_date ? date('Y-m-d', strtotime($request->cheque_date)) : null;
            // $in_cheque_date          = $request->cheque_date ? date('d-M-Y', strtotime($request->cheque_date)) : null;
            $in_amount_vat           = $vat_amount ?? 0;
            $in_amount_tax           = $tax_amount ?? 0;
            $in_grn_no               = $grn_no ?? 0;

            $out_error = 0;
            $pdo = DB::getPdo();
            $supplier_payment = $pdo->prepare("begin pkg_v1_accounts.prc_journal_entrypayable(
                                        :in_STORE_no_fk,
                                        :in_supplier_no_fk,
                                        :in_payment_date,
                                        :in_narration,
                                        :in_integration_type,
                                        :in_amount,
                                        :in_gl_acc_no_fk,
                                        :in_payment_type,
                                        :in_check_no,
                                        :in_check_date,
                                        :in_vat_amt,
                                        :in_tax_amt,
                                        :in_grn_no,
                                        :in_AU_ENTRY_BY,
                                        :in_au_entry_session,
                                        :in_AU_ENTRY_HOSPITAL_PK_NO,
                                        :out_jurnal_code,
                                        :out_error
                                ); end;");
            $supplier_payment->bindparam('in_STORE_no_fk', $in_store_no_fk);
            $supplier_payment->bindparam('in_supplier_no_fk', $in_supplier_no_fk);
            $supplier_payment->bindParam('in_payment_date', $in_pay_date);
            $supplier_payment->bindparam('in_narration', $in_narration);
            $supplier_payment->bindparam('in_integration_type', $in_integration_type);
            $supplier_payment->bindparam('in_amount', $in_amount);
            $supplier_payment->bindParam('in_gl_acc_no_fk', $in_general_ledger);
            $supplier_payment->bindParam('in_payment_type', $in_payment_type);
            $supplier_payment->bindParam('in_check_no', $in_cheque_no);
            $supplier_payment->bindParam('in_check_date', $in_cheque_date);
            $supplier_payment->bindParam('in_vat_amt', $in_amount_vat, PDO::PARAM_STR);
            $supplier_payment->bindParam('in_tax_amt', $in_amount_tax, PDO::PARAM_STR);
            $supplier_payment->bindParam('in_grn_no', $in_grn_no);
            $supplier_payment->bindparam('in_AU_ENTRY_BY', $in_au_entry_by);
            $supplier_payment->bindparam('in_au_entry_session', $in_au_entry_session);
            $supplier_payment->bindparam('in_AU_ENTRY_HOSPITAL_PK_NO', $in_au_entry_hospital_pk_no);

            $supplier_payment->bindParam('out_jurnal_code', $out_jurnal_code, PDO::PARAM_INT);
            $supplier_payment->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $supplier_payment->execute();
            // Close Accounts Integration Procedure call

            DB::table('inv_accsupplierpaymentmst')->where('accsupplierpaymentmst_no_pk', $last_id)->update(['journal_code' => $out_jurnal_code]);
            if($request->checquedtl_no_pk){
                DB::table('acct_checquedtl')->where('checquedtl_no_pk', $checquedtl_no_pk)->update(['use_ind' => 1]);
            }
            DB::commit();
            return response()->json(['title' => 'Success', 'message' => 'Successfully Paid', 'success' => true], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['title' => 'Failed', 'message' => $th->getMessage(), 'success' => false], 422);
        }
    }
}
