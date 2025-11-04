<?php

namespace App\Http\Controllers;

use Exception;
use Session;
use PDO;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\TryCatch;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository as Repo;
use \PDF;
use App\Models\ServiceUnit;
use DateTime;
use Illuminate\Support\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HousekeepingController extends Controller
{

    protected $houseKeeping;
    use LookupData;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hk_data = DB::table('stock_ledger_hk_vw')->where('AU_ENTRY_BY', Auth::id())->get();
        return Template::loadview("admin.housekeeping.index", compact('hk_data'));
    }

    public function worklist()
    {
        $hk_data = DB::table('hkpt_washingrequest_item_vw')->whereNull('RETURN_RCV_IND')->orderBy('wash_req_uid', 'DESC')->get();
        return Template::loadview("admin.housekeeping.washing_worklist", compact('hk_data'));
    }
    public function consumptionCreate($item_id)
    {
        $constype =  $this->getLookupListByCode('CONSTYPE');
        $hk_data = DB::table('stock_ledger_hk_vw')
        // ->join('sysc_serviceitem')
        ->where('AU_ENTRY_BY', Auth::id())->where('item_no_fk',$item_id)->first();
        return Template::loadview("admin.housekeeping.consumption_form",['constype'=>$constype,'hk_data'=>$hk_data]);
    }

    public function washedWorklist(Request $request)
    {
        if ($request->tab_type == 1) {
            $hk_data = DB::table('hkpt_washingrequest_item_vw')->whereNull('return_rcv_ind')->orderBy('wash_req_uid', 'DESC')->get();
            return Template::loadview("admin.housekeeping.unwashed_worklist_data", compact('hk_data'));
        } elseif ($request->tab_type == 2) {
            $hk_data = DB::table('hkpt_washingrequest_item_vw')->where('return_rcv_ind', 1)->orderBy('wash_req_uid', 'DESC')->get();
            return Template::loadview("admin.housekeeping.washed_worklist_data", compact('hk_data'));
        }
    }

    public function loundryRequest()
    {
        return Template::loadview("admin.housekeeping.laundry_request_form");
    }

    public function loundryRequestStore(Request $request)
    {
        $laundry_name = $request->laundry_name;
        $date_l = $request->date_l;
        $laundry_person = $request->laundry_person;
        $laundry_contact = $request->laundry_contact;
        $sendindg_user = $request->doctor_id;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        // array part
        $item_name = $request->item_name;
        $item_hidden_id = $request->item_hidden_id;
        $qty = $request->qty;
        $item_remarks = $request->item_remarks;
        $sequence = DB::getSequence();
        $wash_req_no_pk_seq = $sequence->nextValue('wash_req_no_pk_seq');

        DB::beginTransaction();
        try {
            // for master
            $data = [
                'wash_req_no_pk'    => $wash_req_no_pk_seq,
                'wash_req_uid'      => $wash_req_no_pk_seq,
                'wash_req_date'     => date('Y/m/d H:i', strtotime($date_l)),
                'wash_req_by_user_no_fk'  => $sendindg_user,
                'wash_sent_laundry_name'  => $laundry_name,
                'wash_sent_laundry_person_name'  => $laundry_person,
                'wash_sent_laundry_contact'  => $laundry_contact,
                // 'wash_remarks'  => $request->department_name,
                'sent_at'           => date("Y/m/d"), //date('Y/m/d H:i', strtotime($date_l)),
                'sent_ind'          => 1,
                'sent_by'           => $auth_id,
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session'  =>   $request->user_name,
                'au_entry_at'       =>   date("Y/m/d"),
                'au_entry_by'       =>   $auth_id,
            ];
            $wash_data = DB::table('hkpt_washingrequestmst')->insert($data);

            // dd($item_hidden_id);
            // for dtl

            $max_wash_req_no_pk = DB::select('SELECT MAX(wash_req_no_pk) id FROM hkpt_washingrequestmst');
            $item_array_count = sizeof($request->item_name);
            if (!empty($item_name)) {


                $item_name_arr = $item_hidden_id_arr = $qty_arr = $item_remarks_arr = [];
                for ($i = 0; $i < $item_array_count; $i++) {
                    if ($item_name[$i] != null) {

                        $sequence1 = DB::getSequence();
                        $wash_reqdtl_no_pk_seq = $sequence1->nextValue('wash_reqdtl_no_pk_seq');

                        $dtl_data = [
                            'wash_req_no_fk'    => $max_wash_req_no_pk[0]->id,
                            'wash_reqdtl_no_pk'    => $wash_reqdtl_no_pk_seq,
                            'item_no_fk'        => (isset($item_hidden_id[$i])) ? $item_hidden_id[$i] : '',
                            'wash_item_qty'    => (isset($qty[$i])) ? $qty[$i] : '',
                            'wash_item_remarks'    => (isset($item_remarks[$i])) ? $item_remarks[$i] : '',
                            'sent_item_at'           => date("Y-m-d H:i"),
                            'sent_item_ind'          => 1,
                            'sent_item_by'           => $auth_id,
                            'au_entry_hospital_pk_no' => session::get('user.ses_hospital_no_pk'),
                            'au_entry_session'  =>   'session',
                            'au_entry_at'       =>   date("Y-m-d H:i"),
                            'au_entry_by'       =>   $auth_id,
                            'status'       =>   1,
                        ];
                        // dd($dtl_data);
                        $wash_data_dtl = DB::table('hkpt_washingrequestdtl')->insert($dtl_data);
                    }

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

    public function loundryReceivedStore(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();
        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {
            $wash_req_uid = $request->wash_req_uid;
            for ($j = 0; $j < count($wash_req_uid); $j++) {
                $received_data_mst = [
                    'return_rcv_at'           => $date,
                    'return_rcv_ind'          => 1,
                    'return_rcv_by'           => $auth_id,
                    'au_entry_hospital_pk_no' => session::get('user.ses_hospital_no_pk'),
                    'au_entry_session'  =>   'session',
                    'au_entry_at'       =>   $date,
                    'au_entry_by'       =>   $auth_id,
                ];
                $wash_data_mst = db::table('hkpt_washingrequestmst')->where('wash_req_no_pk', $wash_req_uid[$j])->update($received_data_mst);
            }


            $wash_reqdtl_no_pk = $request->wash_reqdtl_no_pk;
            for ($k = 0; $k < count($wash_reqdtl_no_pk); $k++) {
                $received_data_dtl = [
                    'return_rcv_item_at'           => $date,
                    'return_rcv_item_ind'          => 1,
                    'return_rcv_item_by'           => $auth_id,
                    'au_entry_hospital_pk_no' => session::get('user.ses_hospital_no_pk'),
                    'au_entry_session'  =>   'session',
                    'au_entry_at'       =>   $date,
                    'au_entry_by'       =>   $auth_id,
                ];
                $wash_data_dtl = db::table('hkpt_washingrequestdtl')->where('wash_reqdtl_no_pk', $wash_reqdtl_no_pk[$k])->update($received_data_dtl);
            }

            DB::commit();
            $message = ['msg' => 'Data Received Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function consumptionStore(Request $request)
    {
        // dd($request->all()); // PKG_V1_INVENTORY_ALL.PRC_ITEMCONSUMPTION_MS
        // try {


            $numelems = 1000;
            $consumption_no=$request->consumption_no_pk;

            $out_po_uid = '';
            $null = '';
            $zero = 0;
            $emptyArray = array();
            $null = date('Y');
            $pdo = DB::getPdo();

            $null = "";
            $zero = 0;
            $zero_arr = [];
            $empty_arr = [];
            $in_au_entry_session = 'UHL TEST';
            $in_au_entry_by = Session::get('user.ses_user_pk_no');
            $in_au_entry_session = 'UHL TEST';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

            $in_to_store_no_fk = $request->department_from;
            $remarks   = $request->remarks_;
            $in_consumption_save_option = "DRAFT";
            $out_itemreceive_uid = '';
            $out_itemreceive_no_pk = 0;
            $out_error = '';

            // $in_a_sales_item_price = $in_a_pur_item_price = $in_inv_requisitiondtl_no_pk = $item_no_fk_arr = $in_item_batch_fk = $in_item_expiry_dt =  $in_a_item_pvmsno = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = [];
            // for ($i = 0; $i < count($request->item_id_hidden); $i++) {
            //     $item_no_fk_arr[$i] = $request->item_id_hidden[$i];
            //     $in_item_batch_fk[$i] = $request->item_batch_fk[$i];
            //     $in_item_expiry_dt[$i] =  $request->item_expire_date[$i];;
            //     $in_a_item_pvmsno[$i] = '';
            //     $empty_arr[$i] = 0;
            //     $zero_arr[$i] = "";
            //     $in_a_item_qty[$i] = $request->item_quantity[$i];
            //     $in_a_item_uom[$i] = $request->uom_no_fk[$i];
            //     $in_a_pur_item_price[$i] = 0;//$request->purchase_price[$i];
            //     $in_a_sales_item_price[$i] =0 ;//$request->sales_price[$i];
            //     $in_inv_requisitiondtl_no_pk[$i] = '';
            //     $in_a_entry_serial_dtl[$i] = $i + 1;
            // }
            $all_info=  $in_a_sales_item_price = $in_a_pur_item_price=$in_a_cost_price=$itemreceivedtl_no_pk = $in_inv_requisitiondtl_no_pk = $item_no_fk_arr =$in_internal_item_batch_fk= $in_item_batch_fk = $in_item_expiry_dt =  $in_a_item_pvmsno = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = [];
            for ($i = 0; $i < count($request->hidden_batch_no_qty); $i++) {
                $all_info[$i]=explode('_',$request->hidden_batch_no_qty[$i]);
                $item_no_fk_arr[$i] =  $all_info[$i][3] ;
                $in_internal_item_batch_fk[$i] =  $all_info[$i][0];
                $in_item_batch_fk[$i] = $all_info[$i][1];
                
                $date = DateTime::createFromFormat('d/m/Y', $all_info[$i][2]);
                $in_item_expiry_dt[$i]= $date ? $date->format('dmY') : null;
                // $in_item_expiry_dt[$i] = $all_info[$i][2] !="" ? date('Y-m-d',strtotime($all_info[$i][2])) : '';
                $in_a_item_pvmsno[$i] = '';
                $empty_arr[$i] = 0;
                $zero_arr[$i] = "";
                $in_a_item_qty[$i] =  $all_info[$i][4];
                $in_a_item_uom[$i] =  $all_info[$i][7];
                $in_a_pur_item_price[$i] = $all_info[$i][5] !="" ? $all_info[$i][5]:0;
                $in_a_cost_price[$i] = $all_info[$i][8] !="" ? $all_info[$i][8]:0;
                $in_a_sales_item_price[$i] =$all_info[$i][6] !="" ? $all_info[$i][6]:0;
                $itemreceivedtl_no_pk[$i] =$all_info[$i][9] !="" ? $all_info[$i][9]:0;
                $in_inv_requisitiondtl_no_pk[$i] = '';
                $in_a_entry_serial_dtl[$i] = $i + 1;
            }
// dd($item_no_fk_arr, $in_internal_item_batch_fk,$in_a_cost_price ,  $itemreceivedtl_no_pk);
            // dd($item_no_fk_arr, $in_internal_item_batch_fk,
            // $in_item_batch_fk,
            //  $in_a_item_qty,
            //  $in_a_item_uom,
            //  $in_a_pur_item_price,
            //                 );


            $main_store_module = ServiceUnit::where('serviceunit_no_pk', $in_to_store_no_fk)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();


            $main_store_module = isset($main_store_module->main_store_module_no_fk) ?
                $main_store_module->main_store_module_no_fk : 0;

                $save_type=$request->save_type;
                $edit_ind=$request->edit_ind !="" ? $request->edit_ind : 0;


            $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemconsumption_ms(
                :in_consumption_type,
                :in_inv_consumption_no_pk ,
                :in_inv_consumption_date ,
                :in_to_store_no_fk ,
                :in_from_store_no_fk ,
                :in_consumption_document_path  ,
                :in_patient_no_fk ,
                :in_admission_no_fk ,
                :in_consumption_by_person_no_fk ,
                :in_consumption_by_event_no_fk ,
                :in_consumption_remarks  ,
                :in_indent_no_fk ,
                :in_source_su_no_fk ,
                :in_consumption_schedule_date ,
                :in_consumption_save_option ,
                :in_module_no_fk ,
                :in_edit_ind,
                :in_a_item_no_fk ,
                :in_a_item_consumption_uom ,
                :in_a_item_consumption_qty ,
                :in_a_internal_batch_no  ,
                :in_a_batch_no ,
                :in_a_expiry_date ,
                :in_a_item_remarks ,
                :in_a_entry_serial_dtl ,
                :in_a_consumption_schedule_date ,
                :in_a_purchaseorderdtl_no_pk ,
                :in_a_inv_requisitiondtl_no_pk ,
                :in_a_itemreceivedtl_no_pk ,
                :in_a_invoicedtl_no_pk ,
                :in_a_cost_price ,
                :in_a_purchase_price ,
                :in_a_sales_price ,
                :in_au_entry_by ,
                :in_au_entry_session ,
                :in_au_entry_hospital_no_fk ,
                :out_itemreceive_no_pk  ,
                :out_itemreceive_uid  ,
                :out_error
                ); end;");



            //dd($empty_arr,$in_inv_requisitiondtl_no_pk, $item_no_fk_arr);
            $in_inv_consumption_date =$request->document_date !=""?  date('Y-m-d', strtotime($request->document_date)):'';
            $in_consumption_type = $request->type;

            // dd($in_consumption_type);
            $purchase_order_entry->bindparam('in_consumption_type', $in_consumption_type);
            $purchase_order_entry->bindparam('in_inv_consumption_no_pk',   $consumption_no);
            $purchase_order_entry->bindparam('in_inv_consumption_date', $in_inv_consumption_date);
            $purchase_order_entry->bindparam('in_to_store_no_fk',  $zero);
            $purchase_order_entry->bindparam('in_from_store_no_fk',$in_to_store_no_fk);
            $purchase_order_entry->bindparam('in_consumption_document_path', $null);
            $purchase_order_entry->bindparam('in_patient_no_fk', $zero);
            $purchase_order_entry->bindparam('in_admission_no_fk', $zero);
            $purchase_order_entry->bindparam('in_consumption_by_person_no_fk', $zero);
            $purchase_order_entry->bindparam('in_consumption_by_event_no_fk', $zero);
            $purchase_order_entry->bindparam('in_consumption_remarks', $remarks);
            $purchase_order_entry->bindparam('in_indent_no_fk', $zero);
            $purchase_order_entry->bindparam('in_source_su_no_fk', $zero);
            $purchase_order_entry->bindparam('in_consumption_schedule_date', $in_inv_consumption_date);
            $purchase_order_entry->bindparam('in_consumption_save_option', $save_type);
            $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);
            $purchase_order_entry->bindparam('in_edit_ind', $edit_ind);
            $purchase_order_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_item_consumption_uom', $in_a_item_uom, count($in_a_item_uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_item_consumption_qty', $in_a_item_qty, count($in_a_item_qty), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_internal_batch_no', $in_internal_item_batch_fk, count( $in_internal_item_batch_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_batch_no', $in_item_batch_fk, count($in_item_batch_fk), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_expiry_date', $in_item_expiry_dt, count($in_item_expiry_dt), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_item_remarks', $empty_arr, count($empty_arr), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_entry_serial_dtl', $in_a_entry_serial_dtl, count($in_a_entry_serial_dtl), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_consumption_schedule_date', $zero_arr, count($zero_arr), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_purchaseorderdtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_inv_requisitiondtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_itemreceivedtl_no_pk', $itemreceivedtl_no_pk, count($itemreceivedtl_no_pk), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_invoicedtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_cost_price', $in_a_cost_price, count($in_a_cost_price), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_purchase_price', $in_a_pur_item_price, count($in_a_pur_item_price), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_sales_price', $in_a_sales_item_price, count($in_a_sales_item_price), $numelems, SQLT_FLT);
            $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
            $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $purchase_order_entry->bindParam('out_itemreceive_no_pk', $out_itemreceive_no_pk, PDO::PARAM_INT);
            $purchase_order_entry->bindParam('out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $purchase_order_entry->execute();

            DB::commit();
            $message = ['msg' => 'Data saved successfully.<br><strong>Receive UID = ' . $out_itemreceive_uid . '</strong>', 'title' => 'Success'];
        // } catch (Exception $e) {
        //     $message = ['msg' => 'Failed to Recevied.<br><strong>Error Message = ' . $e->getMessage() . '</strong>', 'title' => 'Success'];
        // }

        return response()->json($message);
    }


    // housekeeping Report
    public function housekeepingReport()
    {
        return Template::loadview("admin.housekeeping.housekeeping_report");
    }
    public function housekeepingReportSearch(Request $request)
    {
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person = $doctor_id" : "";


        // $query = DB::select(DB::raw("select * from FINC_CASHIER_WISE_REPORTS_VW $sql_cond  "));
        $query = DB::select(DB::raw("select * from finc_voucherwise_vw_phr $sql_cond  "));

        return Template::loadview("admin.reports.pharmacy.cashier-wise-search-data", [
            'data' => $query
        ]);
    }
    public function housekeepingReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(wash_req_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select * from hkpt_washingrequest_item_vw $sql_cond order by wash_req_date desc");

        $data = [];
        foreach ($report_data as $key => $dt) {
            $data[$dt->wash_req_date][] = $dt;
        }


        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.housekeeping.housekeeping_report_print", ['report_data' => $data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no]);

        return $pdf->download('housekeeping_report.pdf');
    }

    public function housekeepingReportPdfId($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $report_data = db::select("select * from hkpt_washingrequest_item_vw where WASH_REQ_UID = $id order by wash_req_date desc");

        $data = [];
        foreach ($report_data as $key => $dt) {
            $data[$dt->wash_req_date][] = $dt;
        }


        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.housekeeping.housekeeping_report_print", ['report_data' => $data, 'po_hospital_details' => $po_hospital_details, 'from_date' => '', 'to_date' => '', 'barcode_no' => $barcode_no]);

        return $pdf->download('housekeeping_report.pdf');
    }


      //    housekeeping_discharge_worklist
      public function housekeepingReqList()
      {
  
          return Template::loadview("admin.ipd.discharge.housekeeping_req_list", [
              'dis_reqLists' => DB::table('ipd_admitted_patlist_vw ')
                  ->where('dis_req_ind', 1)
                  ->where('dis_ind', '<>', 1)
                  ->where(DB::raw("trunc(dis_req_time)"), date('Y-m-d'))
                  // ->where(DB::raw("trunc(admission_date)"), date('Y-m-d'))
                  ->get(),
              'ipds_wards' => DB::table('ipds_ward')
                  ->select("ward_name", "ward_no_pk")
                  ->orderBy('ward_no_pk', 'asc')
                  ->get()
                  ->toArray(),
          ]);
      }

      public function searchHousekeepingReqList(Request $request)
    {
        //        dd($request->hdn_patient_id);
        $qury = DB::table('ipd_admitted_patlist_vw');
        if (!empty(request('discharge_ward'))) {
            $qury->where('ward_no_pk', request('discharge_ward'));
        }
        if (!empty(request('card_hidn'))) {
            $qury->where('primary_doctor_no_fk', request('card_hidn'));
        }
        if (!empty(request('hdn_patient_id'))) {
            $qury->where('patient_no_fk', request('hdn_patient_id'));
        }

        if (!empty(request('hdn_admission_id'))) {
            $qury->where('admission_no_pk', request('hdn_admission_id'));
        }
        if (!empty(request('admission_date_from')) && !empty(request('admission_date_to'))) {
            $qury->where(DB::raw("trunc(dis_req_time)"), '>=', date('Y-m-d', strtotime(request('admission_date_from'))));
            $qury->where(DB::raw("trunc(dis_req_time)"), '<=', date('Y-m-d', strtotime(request('admission_date_to'))));
        } elseif (!empty(request('admission_date_from'))) {
            $qury->where(DB::raw("trunc(dis_req_time)"), '=', date('Y-m-d', strtotime(request('admission_date_from'))));
        } elseif (!empty(request('admission_date_to'))) {
            $qury->where(DB::raw("trunc(dis_req_time)"), '=', date('Y-m-d', strtotime(request('admission_date_to'))));
        }
        return Template::loadview("admin.ipd.discharge.search_discharge_req_list", [
            'dis_reqLists' => $qury
                ->where('dis_req_ind', 1)
                ->where('dis_ind', '<>', 1)
                ->get()
                ->toArray(),
        ]);
    }
}
