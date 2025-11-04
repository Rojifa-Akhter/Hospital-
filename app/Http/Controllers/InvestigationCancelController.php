<?php

namespace App\Http\Controllers;

use DB;
use App;
use PDF;
use PDO;
use Auth;
use Session;
use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Events\PharmacyTVUpdate;
use App\Core\TV\PharmacyTVService;
use App\Http\Controllers\Controller;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Datatables\DataTableClass;
class InvestigationCancelController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $pharmacy_tv_information;

    public function __construct(PharmacyTVService $pharmacy_tv_information)
    {
        $this->pharmacy_tv_information = $pharmacy_tv_information;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patient_info = [];
        $item_info = [];
        return Template::loadview("admin.investigation_cancel.investigation_cancel_create", ['item_info' => $item_info, 'patient_info' => $patient_info]);
    }
    public function createRad()
    {
        $patient_info = [];
        $item_info = [];
        return Template::loadview("admin.investigation_cancel.investigation_cancel_create_rad", ['item_info' => $item_info, 'patient_info' => $patient_info]);
    }
    public function cancelInvestigation(Request $request)
    {

        // dd($all_item);
        $query = DB::table('labt_invoicedtl_step_can_vw');
        if ($request->cancel_invoice_id != null) {
            $query->where('invoice_no_fk', $request->cancel_invoice_id);
        } else {
            $query->where('lab_no_pk', $request->lab_no);
        }
        $item_info_detatils = $query->orderBy('lab_no_pk', 'asc')->get();

        $patient_info = [];
        $item_info = [];
        if (!$item_info_detatils->isEmpty()) {
            // dd($item_info);
            $patient_info = $item_info_detatils[0];
            // dd($patient_info);
            // DB::table('finc_invoicemst_sum_vw')->where('invoice_no_pk', $item_info[0]->invoice_no_fk)->first();
        }

        $all_item = DB::table('finc_invoicedtl')->select('finc_invoicedtl.invoice_no_fk', 'finc_invoicedtl.item_name', 'finc_invoicedtl.item_no_fk')->leftjoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'finc_invoicedtl.item_no_fk')->where('finc_invoicedtl.invoice_no_fk', $request->cancel_invoice_id)->where('sysc_serviceitem.container_ind', null)->where('sysc_serviceitem.item_type', 'LAB')->whereNotIn('finc_invoicedtl.item_no_fk', DB::table('labt_invoicedtl_step_can_vw')->where('invoice_no_fk', $request->cancel_invoice_id)->pluck('item_no_pk'))->get()->toArray();
        // dd($item_info_detatils);

        $item_info = $item_info_detatils;
        return Template::loadview("admin.investigation_cancel.investigation_cancel_create_form", ['item_info' => $item_info, 'patient_info' => $patient_info, 'all_item' => $all_item]);
        // if (!$item_info_detatils->isEmpty()) {
        // } else {
        //     $item_info = 'Error';
        //     // dd($item_info);
        //     return json_encode($item_info);
        // }

        // return Template::loadview("admin.investigation_cancel.investigation_cancel_create_form", ['item_info' => $item_info, 'patient_info' => $patient_info]);



    }
    public function cancelInvestigationRad(Request $request)
    {
        $query = DB::table('radt_invoicedtl_step_can_vw');
        if ($request->cancel_invoice_id != null) {
            $query->where('invoice_no_pk', $request->cancel_invoice_id);
        }
        //  else {
        //     $query->where('lab_no_pk', $request->lab_no);
        // }
        $item_info_detatils = $query->orderBy('radinvoicedtl_no_pk', 'asc')->get();

        $patient_info = [];
        $item_info = [];
        if (!$item_info_detatils->isEmpty()) {
            $patient_info = $item_info_detatils[0];
        }
        if (!$item_info_detatils->isEmpty()) {
            $item_info = $item_info_detatils;
            return Template::loadview("admin.investigation_cancel.investigation_cancel_create_form_rad", ['item_info' => $item_info, 'patient_info' => $patient_info]);
        } else {
            $item_info = 'Error';
            // dd($item_info);
            return json_encode($item_info);
        }
    }

    public function cancelInvestigationItem(Request $request)
    {

        $code_lab_rep_exp = explode('_', $request->code_lab_repot);

        $code = $code_lab_rep_exp[0];
        $lab_no = $code_lab_rep_exp[1];
        $report_no = $code_lab_rep_exp[2];
        $item_no = $code_lab_rep_exp[3];
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $to_date = date('Y-m-d');
            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            $out_errmsg = '';
            $pdo = DB::getPdo();
            $step_cancel = $pdo->prepare("begin pkg_emr.pathology_step_cancel(
            :in_lab_no_pk,
            :in_report_no_fk,
            :in_item_no_fk,
            :in_step_code,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_no_pk,
            :out_errmsg); end;");

            $step_cancel->bindParam(':in_lab_no_pk', $lab_no);
            $step_cancel->bindParam(':in_report_no_fk', $report_no);
            $step_cancel->bindParam(':in_item_no_fk', $item_no);
            $step_cancel->bindParam(':in_step_code', $code);
            $step_cancel->bindParam(':in_au_entry_by', $auth_id);
            $step_cancel->bindParam(':in_au_entry_at', $to_date);
            $step_cancel->bindParam(':in_au_entry_session', $entry_session);
            $step_cancel->bindParam(':in_au_entry_hospital_no_pk', $hospital_id);
            $step_cancel->bindParam(':out_errmsg', $out_errmsg, PDO::PARAM_STR, 500);
            // dd($step_cancel);
            $step_cancel->execute();
            if ($out_errmsg == '000') {
                DB::commit();
                $message = ['msg' => 'cancel Process successfully.', 'title' => 'Success'];
                // dd($out_errmsg);
            } else {

                DB::rollback();
                $message = ['msg' => 'cancel Process Failed' . $out_errmsg, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function splitInvestigationData(Request $request)
    {
        $invoiceId = $request->invoice_id;
        $reportId = $request->report_id;
        $itemId = $request->item_id;
        $labId = $request->lab_id;



        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $to_date = date('Y-m-d');
            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            $out_errmsg = $out_prescription_no_pk = '';
            $zero = 0;
            $pdo = DB::getPdo();
            $split_cancel = $pdo->prepare("begin pkg_emr.pathology_report_split(
            :in_REPORT_NO_FK,
            :in_REPORT_NO_FK_TO,
            :in_item_no_fk,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_no_pk,
            :out_REPORT_NO_FK_new,
            :out_errmsg); end;");

            $split_cancel->bindParam(':in_REPORT_NO_FK', $reportId);
            $split_cancel->bindParam(':in_REPORT_NO_FK_TO', $zero); //need to talk
            $split_cancel->bindParam(':in_item_no_fk', $itemId);
            $split_cancel->bindParam(':in_au_entry_by', $auth_id);
            $split_cancel->bindParam(':in_au_entry_at', $to_date);
            $split_cancel->bindParam(':in_au_entry_session', $entry_session);
            $split_cancel->bindParam(':in_au_entry_hospital_no_pk', $hospital_id);
            $split_cancel->bindParam(':out_REPORT_NO_FK_new', $out_prescription_no_pk, PDO::PARAM_INT);
            $split_cancel->bindParam(':out_errmsg', $out_errmsg, PDO::PARAM_STR, 500);
            // dd($step_cancel);
            $split_cancel->execute();
            if ($out_errmsg == '000') {
                DB::commit();
                $message = ['msg' => 'Split Process successfully.', 'title' => 'Success'];
                // dd($out_errmsg);
            } else {

                DB::rollback();
                $message = ['msg' => 'Split Process Failed' . $out_errmsg, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function cancelInvestigationItemRad(Request $request)
    {

        $code_lab_rep_exp = explode('_', $request->code_lab_repot);
        $code = $code_lab_rep_exp[0];
        $rad_no = $code_lab_rep_exp[1];
        $report_no = $code_lab_rep_exp[2];
        $auth_id = Auth::id();
        DB::beginTransaction();
        // dd( $code_lab_rep_exp );
        try {
            $to_date = date('Y-m-d');
            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            $out_errmsg = '';
            $pdo = DB::getPdo();
            $step_cancel = $pdo->prepare("begin pkg_emr.radiology_step_cancel(
            :in_radinvoicedtl_no_pk,
            :in_report_no_fk,
            :in_step_code,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_no_pk,
            :out_errmsg); end;");

            $step_cancel->bindParam(':in_radinvoicedtl_no_pk', $rad_no);
            $step_cancel->bindParam(':in_report_no_fk', $report_no);
            $step_cancel->bindParam(':in_step_code', $code);
            $step_cancel->bindParam(':in_au_entry_by', $auth_id);
            $step_cancel->bindParam(':in_au_entry_at', $to_date);
            $step_cancel->bindParam(':in_au_entry_session', $entry_session);
            $step_cancel->bindParam(':in_au_entry_hospital_no_pk', $hospital_id);
            $step_cancel->bindParam(':out_errmsg', $out_errmsg, PDO::PARAM_STR, 500);
            // dd($step_cancel);
            $step_cancel->execute();
            if ($out_errmsg == '000') {
                DB::commit();
                $message = ['msg' => 'cancel Process successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'cancel Process Failed' . $out_errmsg, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function reStructure(Request $request)
    {
        $auth_id = Auth::id();
        $invoice_id = $request->invoice;
        $item_id = $request->item;
        DB::beginTransaction();
        // dd( $code_lab_rep_exp );
        try {
            $to_date = date('Y-m-d');
            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            $out_error = '';
            $pdo = DB::getPdo();
            $step_cancel = $pdo->prepare("begin pkg_emr.pathology_struct_rebuild(
            :in_invoice_no_pk,
            :in_item_no_pk,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_no_pk,
            :out_error); end;");

            $step_cancel->bindParam(':in_invoice_no_pk', $invoice_id);
            $step_cancel->bindParam(':in_item_no_pk', $item_id);
            $step_cancel->bindParam(':in_au_entry_by', $auth_id);
            $step_cancel->bindParam(':in_au_entry_at', $to_date);
            $step_cancel->bindParam(':in_au_entry_session', $entry_session);
            $step_cancel->bindParam(':in_au_entry_hospital_no_pk', $hospital_id);
            $step_cancel->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($step_cancel);
            $step_cancel->execute();
            if ($out_error == '000') {
                DB::commit();
                $message = ['msg' => 'Structure Process Completed Successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Structure Process Failed' . $out_error, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function setItemRestructure(Request $request)
    {

        // $item_id = $request->item;
        DB::beginTransaction();
        // dd( $code_lab_rep_exp );
        try {
            $to_date = date('Y-m-d');
            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            $out_error = '';
            $pdo = DB::getPdo();
            $auth_id = Auth::id();
            $invoice_id = $request->item_stacture;
            $invoice_no = 0;
            $item_no = 0;

            if ($invoice_id != "") {

                $item_invoice = explode('_', $invoice_id);
                $invoice_no = $item_invoice[0];
                $item_no = $item_invoice[1];
            } else {

                $message = ['msg' => 'Structure Process Failed' . $out_error, 'title' => 'Error'];
                return;
            }
            $setItemRestructure = $pdo->prepare("begin pkg_emr.pathology_struct_rerun_item(
            :in_invoice_no_pk,
            :in_item_no_fk,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_no_pk,
            :out_error
           ); end;");

            $setItemRestructure->bindParam(':in_invoice_no_pk', $invoice_no);
            $setItemRestructure->bindParam(':in_item_no_fk', $item_no);
            $setItemRestructure->bindParam(':in_au_entry_by', $auth_id);
            $setItemRestructure->bindParam(':in_au_entry_at', $to_date);
            $setItemRestructure->bindParam(':in_au_entry_session', $entry_session);
            $setItemRestructure->bindParam(':in_au_entry_hospital_no_pk', $hospital_id);
            $setItemRestructure->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($setItemRestructure);
            $setItemRestructure->execute();
            if ($out_error == '000') {
                DB::commit();
                $message = ['msg' => 'Structure Process Completed Successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Structure Process Failed' . $out_error, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function PathSampleCollectionLifeCycle()
    {
        $patient_info = [];
        $item_info = [];
        return Template::loadview("admin.investigation_cancel.path_sample_collection_life_cycle", ['item_info' => $item_info, 'patient_info' => $patient_info]);
    }
    public function PathSampleCollectionLifeCycleSearch(Request $request)
    {

        // dd($all_item);
        // ,'samp_coll.user_fullname as collector_name','samp_receive.user_fullname as receiver_name','samp_prepared.user_fullname as prepared_name','samp_verify.user_fullname as verified_name','samp_finalize.user_fullname as finalized_name','samp_printed.user_fullname as printed_name','samp_delivered.user_fullname as delivered_name'
        $query = DB::table('labt_invoicedtl_step_can_vw')
            ->select('labt_invoicedtl_step_can_vw.*', 'samp_coll.user_fullname as collector_name', 'samp_receive.user_fullname as receiver_name', 'samp_prepared.user_fullname as prepared_name', 'samp_verify.user_fullname as verified_name', 'samp_finalize.user_fullname as finalized_name', 'samp_printed.user_fullname as printed_name', 'samp_delivered.user_fullname as delivered_name')
            ->leftjoin('wsec_user samp_coll', 'samp_coll.user_no_pk', 'labt_invoicedtl_step_can_vw.sc_sample_coll_keyed_by')
            ->leftjoin('wsec_user samp_receive', 'samp_receive.user_no_pk', 'labt_invoicedtl_step_can_vw.lab_rcv_from_sp_keyed_by')
            ->leftjoin('wsec_user samp_prepared', 'samp_prepared.user_no_pk', 'labt_invoicedtl_step_can_vw.result_prepared_keyed_by')
            ->leftjoin('wsec_user samp_verify', 'samp_verify.user_no_pk', 'labt_invoicedtl_step_can_vw.result_verify_keyed_by')
            ->leftjoin('wsec_user samp_finalize', 'samp_finalize.user_no_pk', 'labt_invoicedtl_step_can_vw.result_final_keyed_by')
            ->leftjoin('wsec_user samp_printed', 'samp_printed.user_no_pk', 'labt_invoicedtl_step_can_vw.result_print_keyed_by')
            ->leftjoin('wsec_user samp_delivered', 'samp_delivered.user_no_pk', 'labt_invoicedtl_step_can_vw.report_delivered_keyed_by')
        ;
        if ($request->cancel_invoice_id != null) {
            $query->where('invoice_no_fk', $request->cancel_invoice_id);

        } else {
            $query->where('lab_no_pk', $request->lab_no);
        }
        $item_info_detatils = $query->orderBy('lab_no_pk', 'asc')->get();
        // dd($request->cancel_invoice_id,$item_info_detatils );
        $patient_info = [];
        $item_info = [];
        if (!$item_info_detatils->isEmpty()) {
            // dd($item_info);
            $patient_info = $item_info_detatils[0];
            // dd($patient_info);
            // DB::table('finc_invoicemst_sum_vw')->where('invoice_no_pk', $item_info[0]->invoice_no_fk)->first();
        }

        $all_item = DB::table('finc_invoicedtl')->select('finc_invoicedtl.invoice_no_fk', 'finc_invoicedtl.item_name', 'finc_invoicedtl.item_no_fk')->leftjoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'finc_invoicedtl.item_no_fk')->where('finc_invoicedtl.invoice_no_fk', $request->cancel_invoice_id)->where('sysc_serviceitem.container_ind', null)->where('sysc_serviceitem.item_type', 'LAB')->whereNotIn('finc_invoicedtl.item_no_fk', DB::table('labt_invoicedtl_step_can_vw')->where('invoice_no_fk', $request->cancel_invoice_id)->pluck('item_no_pk'))->get()->toArray();


        $item_info = $item_info_detatils;
        return Template::loadview("admin.investigation_cancel.path_sample_collection_life_cycle_list", ['item_info' => $item_info, 'patient_info' => $patient_info, 'all_item' => $all_item]);

    }

    /**
     *
     */
    public function laboratoryLifeCycle(Request $request)
    {
        return Template::loadview("admin.investigation_cancel.v1.path_sample_collection_life_cycle_list_v1");
    }

    public function getData(Request $request)
    {
        // dd($request->all());

        // $items = DB::table('labt_invoicedtl_step_can_vw')
        // ->select(
        //     'invoice_code', 'lab_code', 'item_name', 'sc_sample_coll_keyed_time', 'lab_rcv_from_sp_keyed_time', 'result_ent_keyed_time', 'result_verify_keyed_time', 'result_final_keyed_time', 'report_procees_keyed_time', 'report_delivered_time', 'report_rcb_keyed_time', 'labt_invoicedtl_step_can_vw.patient_code',
        //     'samp_coll.user_fullname as sc_sample_coll_keyed_name', 'samp_receive.user_fullname as lab_rcv_from_sp_keyed_name', 'samp_entry.full_name as result_ent_keyed_name', 'samp_verify.full_name as result_verify_keyed_name', 'samp_finalize.full_name as result_final_keyed_name', 'samp_process.user_fullname as report_procees_keyed_name', 'samp_delivered.user_fullname as report_delivered_keyed_name', 'samp_rcb.user_fullname as report_rcb_keyed_name','labt_invoicedtl_step_can_vw.patient_name','labt_invoicedtl_step_can_vw.mac_result_date','labt_invoicedtl_step_can_vw.delivery_status_no'
        // )
        // ->leftJoin('wsec_user samp_coll', 'samp_coll.user_no_pk', 'labt_invoicedtl_step_can_vw.sc_sample_coll_keyed_by')
        // ->leftjoin('wsec_user samp_receive', 'samp_receive.user_no_pk', 'labt_invoicedtl_step_can_vw.lab_rcv_from_sp_keyed_by')
        // ->leftjoin('hrms_personnel samp_entry', 'samp_entry.person_no_pk', 'labt_invoicedtl_step_can_vw.result_prepared_keyed_by')
        // ->leftjoin('hrms_personnel samp_verify', 'samp_verify.person_no_pk', 'labt_invoicedtl_step_can_vw.result_verify_keyed_by')
        // ->leftjoin('hrms_personnel samp_finalize', 'samp_finalize.person_no_pk', 'labt_invoicedtl_step_can_vw.result_final_keyed_by')
        // ->leftjoin('wsec_user samp_process', 'samp_process.user_no_pk', 'labt_invoicedtl_step_can_vw.report_procees_keyed_by')
        // ->leftjoin('wsec_user samp_delivered', 'samp_delivered.user_no_pk', 'labt_invoicedtl_step_can_vw.report_delivered_keyed_by')
        // ->leftjoin('wsec_user samp_rcb', 'samp_rcb.user_no_pk', 'labt_invoicedtl_step_can_vw.report_rcb_keyed_by')
        // ->whereRaw('nvl(CANCEL_IND,0) = 0')
        // ->orderBy('labt_invoicedtl_step_can_vw.delivery_status_no', 'desc')
        // ->orderByDesc('invoice_date')
        // ->get();


        $table = 'labt_invoicedtl_step_can_vw';
        $primaryKey = 'lab_no_pk';  // Primary key
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $to_date = date('Y-m-d');

        // Define the condition for the `whereRaw` clause
        $where = "nvl(cancel_ind,0) = 0  AND au_entry_hospital_pk_no = $hospital_id";



        // Define the columns you want to select
        $columns = array(
            array('db' => 'invoice_code', 'dt' => 0), //1
            array('db' => 'lab_code', 'dt' => 1),//1
            array('db' => 'item_name', 'dt' => 2),//5
            array('db' => 'sc_sample_coll_keyed_time', 'dt' => 3),
            array('db' => 'lab_rcv_from_sp_keyed_time', 'dt' => 4),
            array('db' => 'result_ent_keyed_time', 'dt' => 5),
            array('db' => 'result_verify_keyed_time', 'dt' => 6),
            array('db' => 'result_final_keyed_time', 'dt' => 7),
            array('db' => 'report_procees_keyed_time', 'dt' => 8),
            array('db' => 'report_delivered_time', 'dt' => 9),
            array('db' => 'report_rcb_keyed_time', 'dt' => 10),
            array('db' => 'patient_code', 'dt' => 11), //3
            array('db' => 'sc_sample_coll_keyed_name', 'dt' => 12),  // Added new column
            array('db' => 'lab_rcv_from_sp_keyed_name', 'dt' => 13),  // Added new column
            array('db' => 'result_ent_keyed_name', 'dt' => 14),  // Added new column
            array('db' => 'result_verify_keyed_name', 'dt' => 15),  // Added new column
            array('db' => 'result_final_keyed_name', 'dt' => 16),  // Added new column
            array('db' => 'report_procees_keyed_name', 'dt' => 17),  // Added new column
            array('db' => 'report_delivered_keyed_name', 'dt' => 18),  // Added new column
            array('db' => 'report_rcb_keyed_name', 'dt' => 19),  // Added new column
            array('db' => 'patient_name', 'dt' => 20), //2
            array('db' => 'mac_result_date', 'dt' => 21),
            array('db' => 'delivery_status_no', 'dt' => 22),
        );
        // dd($columns);

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns));
        }
        // dd($items );

        // return response()->json(["success" => true, "data" => $items], 200);
    }

    protected function formatDate($dateString)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        return $myDateTime->format('Y-m-d');
    }

    /**
     * Filter Laboratory Life Cycle
     */
    public function filter(Request $request)
    {
        // dd($request->all());
        $invoice_id = $request->input('invoice_id');
        $patient_code = $request->input('patient_code');
        $lab_id = $request->input('lab_id');
        $search_date_from = $request->input('search_date_from') != "" ? $this->formatDate($request->input('search_date_from')) : '';
        $search_date_to = $request->input('search_date_to') != "" ? $this->formatDate($request->input('search_date_to')) : '';

        $items = DB::table('labt_invoicedtl_step_can_vw')
            ->select(
                'invoice_code',
                'lab_code',
                'item_name',
                'sc_sample_coll_keyed_time',
                'lab_rcv_from_sp_keyed_time',
                'result_prepared_keyed_time',
                'result_verify_keyed_time',
                'result_final_keyed_time',
                'report_procees_keyed_time',
                'report_delivered_time',
                'report_rcb_keyed_time',
                'labt_invoicedtl_step_can_vw.patient_code',
                'samp_coll.user_fullname as sc_sample_coll_keyed_name',
                'samp_receive.user_fullname as lab_rcv_from_sp_keyed_name',
                'samp_entry.full_name as result_ent_keyed_name',
                'samp_verify.full_name as result_verify_keyed_name',
                'samp_finalize.full_name as result_final_keyed_name',
                'samp_process.user_fullname as report_procees_keyed_name',
                'samp_delivered.user_fullname as report_delivered_keyed_name',
                'samp_rcb.user_fullname as report_rcb_keyed_name',
                'labt_invoicedtl_step_can_vw.patient_name',
                'labt_invoicedtl_step_can_vw.mac_result_date',
                'labt_invoicedtl_step_can_vw.delivery_status_no'
            )
            ->leftJoin('wsec_user samp_coll', 'samp_coll.user_no_pk', 'labt_invoicedtl_step_can_vw.sc_sample_coll_keyed_by')
            ->leftjoin('wsec_user samp_receive', 'samp_receive.user_no_pk', 'labt_invoicedtl_step_can_vw.lab_rcv_from_sp_keyed_by')
            ->leftjoin('hrms_personnel samp_entry', 'samp_entry.person_no_pk', 'labt_invoicedtl_step_can_vw.result_prepared_keyed_by')
            ->leftjoin('hrms_personnel samp_verify', 'samp_verify.person_no_pk', 'labt_invoicedtl_step_can_vw.result_verify_keyed_by')
            ->leftjoin('hrms_personnel samp_finalize', 'samp_finalize.person_no_pk', 'labt_invoicedtl_step_can_vw.result_final_keyed_by')
            ->leftjoin('wsec_user samp_process', 'samp_process.user_no_pk', 'labt_invoicedtl_step_can_vw.report_procees_keyed_by')
            ->leftjoin('wsec_user samp_delivered', 'samp_delivered.user_no_pk', 'labt_invoicedtl_step_can_vw.report_delivered_keyed_by')
            ->leftjoin('wsec_user samp_rcb', 'samp_rcb.user_no_pk', 'labt_invoicedtl_step_can_vw.report_rcb_keyed_by');

        if (!empty($invoice_id)) {
            $items = $items->where('invoice_code', $invoice_id);
        }

        if (!empty($patient_code)) {
            $items = $items->where('labt_invoicedtl_step_can_vw.patient_code', $patient_code);
        }

        if (!empty($lab_id)) {
            $items = $items->where('lab_code', $lab_id);
        }

        if (!empty($search_date_from) && !empty($search_date_to)) {
            // To include the whole 'search_date_to' day, append time to 23:59:59
            $startDateTime = $search_date_from . ' 00:00:00';
            $endDateTime = $search_date_to . ' 23:59:59';
            $items = $items->whereBetween('invoice_date', [$startDateTime, $endDateTime]);
        } elseif (!empty($search_date_from)) {
            // Search from the start of search_date_from
            $startDateTime = $search_date_from . ' 00:00:00';
            $items = $items->where('invoice_date', '>=', $startDateTime);
        } elseif (!empty($search_date_to)) {
            // Search up to the end of search_date_to
            $endDateTime = $search_date_to . ' 23:59:59';
            $items = $items->where('invoice_date', '<=', $endDateTime);
        }



        // if(!empty($search_date_from)) {
        //     $items = $items->whereDate('invoice_date', '>=', $search_date_from);
        // }

        // if(!empty($search_date_to)) {
        //     $items = $items->where('invoice_date', '<=', $search_date_to);
        // }

        $items = $items->whereRaw('nvl(CANCEL_IND,0) = 0')
            ->orderByDesc('labt_invoicedtl_step_can_vw.delivery_status_no')
            ->orderByDesc('invoice_date')
            ->get();

        return Template::loadview("admin.investigation_cancel.v1.path_sample_collection_life_cycle_table_filter_v1", ['items' => $items]);
    }


    public function serviceItemFromPrescription()
    {
        $type = "SERVICE";
        return Template::loadview("admin.pathology.service_item_from_prescription", ['type' => $type]);
    }
    public function medItemFromPrescription()
    {
        $type = "MED";
        return Template::loadview("admin.pathology.service_item_from_prescription", ['type' => $type]);
    }
    public function medItemDelivery()
    {
        $type = "MED";

        return Template::loadview("admin.pathology.medicine_delevery", ['type' => $type]);
    }

    public function serviceItemFromPrescriptionGetData(Request $request)
    {
        $toDate = date('Y-m-d');
        $type = $request->type;

        if ($request->type == "MED") {
            $items = DB::table('PRES_MEDICINE_VW itemView')
                ->leftJoin('FINC_INVOICEMST', 'FINC_INVOICEMST.PRESCRIPTION_NO_FK', '=', 'itemView.prescription_no_pk')
                ->leftJoin('sysc_module', 'sysc_module.module_no_pk', '=', 'finc_invoicemst.module_no_fk')
                ->distinct('itemView.prescription_no_pk')
                ->select('itemView.prescription_no_pk', 'itemView.prescription_uid', 'itemView.prescription_date', 'itemView.patient_name', 'itemView.uhid as patient_code', 'itemView.doctor_name',)
                ->whereDate('itemView.prescription_date', '=', $toDate)
                ->whereNull('itemView.invoice_no_pk')
                ->orderByDesc('itemView.prescription_date')
                ->get();

                dd($items);
        } else {

            $items =
                DB::table('pres_investigation_vw')
                    ->leftJoin('finc_invoicemst', 'finc_invoicemst.prescription_no_fk', '=', 'pres_investigation_vw.prescription_no_pk')
                    ->leftJoin('sysc_module', 'sysc_module.module_no_pk', '=', 'finc_invoicemst.module_no_fk')
                    ->distinct('pres_investigation_vw.prescription_no_pk')
                    ->select('pres_investigation_vw.prescription_no_pk', 'pres_investigation_vw.prescription_uid', 'pres_investigation_vw.prescription_date', 'pres_investigation_vw.patient_name', 'pres_investigation_vw.patient_code', 'pres_investigation_vw.doctor_name')
                    ->whereDate('pres_investigation_vw.prescription_date', '=', $toDate)
                    ->whereNull('pres_investigation_vw.invoice_no_pk')
                    ->orderByDesc('pres_investigation_vw.prescription_date')
                    ->get();
            // dd($items);
            //  DB::table('pres_investigation_vw')
            //     ->leftJoin('finc_invoicemst', 'finc_invoicemst.prescription_no_fk', '=', 'pres_investigation_vw.prescription_no_pk')
            //     ->distinct('pres_investigation_vw.prescription_no_pk')
            //     ->select('pres_investigation_vw.prescription_no_pk','pres_investigation_vw.prescription_uid','pres_investigation_vw.prescription_date','pres_investigation_vw.patient_name','pres_investigation_vw.patient_code','pres_investigation_vw.doctor_name')
            //     ->whereDate('pres_investigation_vw.prescription_date', '=', $toDate)
            //     // ->whereNotIn('finc_invoicemst.module_no_fk',[3])
            //     ->whereNull('finc_invoicemst.prescription_no_fk')
            //     ->orderByDesc('pres_investigation_vw.prescription_date')
            //     ->get();
        }

        return response()->json(["success" => true, "data" => $items, 'type' => $type], 200);
    }
    public function medItemFromPrescriptionGetData(Request $request)
    {
        $toDate = date('Y-m-d');
        $type = $request->type;
        $data = DB::table('phr_patmedtran phrMed')
            ->leftJoin('psn_t_prescription_vw pres', 'pres.prescription_no_pk', '=', 'phrMed.pres_no_fk')
            ->select('pres.prescription_no_pk', 'pres.prescription_uid', 'pres.prescription_date', 'pres.patient_name', 'pres.patient_code as patient_code', 'phrMed.invoice_no_fk', 'phrMed.tran_date', 'phrMed.sl_no')
            ->where('tran_type', 'RI')
            ->where('ready_ind', '=', null)
            // ->whereDate('itemView.prescription_date', '=', $toDate)
            // ->orWhereNull('FINC_INVOICEMST.PRESCRIPTION_NO_FK')
            ->orderByDesc(DB::raw('trunc(phrMed.tran_date)'))
            ->orderBy('phrMed.sl_no')
            ->get();

        $invoiceIds = $data->pluck('invoice_no_fk')->unique();

        $ledgerNumbers = [];
        foreach ($invoiceIds as $invoiceId) {
            $ledgerNumbers[$invoiceId] = DB::table('finc_ledgermst')
                ->select('ledgertrn_no_fk')
                ->where('invoice_no_fk', $invoiceId)
                ->orderBy('invoice_no_fk', 'DESC')
                ->first();
        }
        // dd($invoiceId,$ledgerNumbers);
        $data->transform(function ($item) use ($ledgerNumbers) {
            $invoiceId = $item->invoice_no_fk;
            $item->ledgertrn_no_fk = $ledgerNumbers[$invoiceId]->ledgertrn_no_fk ?? null;
            return $item;
        });
        // dd($data);
        $counter_no = $this->getLookupListByCode("PHRDEL");// $this->getLookupListByCode("PHRDEL");
        // dd($data);
        return response()->json(["success" => true, "data" => $data, 'type' => $type, 'counter_no' => $counter_no], 200);
    }
    public function medItemFromPrescriptionReadyGetData(Request $request)
    {
        $toDate = date('Y-m-d');
        $type = $request->type;

        $data = DB::table('phr_patmedtran phrMed')
            ->leftJoin('psn_t_prescription_vw pres', 'pres.prescription_no_pk', '=', 'phrMed.pres_no_fk')
            ->select('pres.prescription_no_pk', 'pres.prescription_uid', 'pres.prescription_date', 'pres.patient_name', 'pres.patient_code as patient_code', 'phrMed.invoice_no_fk', 'phrMed.tran_date', 'phrMed.sl_no')
            ->where('tran_type', 'RI')
            ->where('ready_ind', 1)
            // ->whereDate('itemView.prescription_date', '=', $toDate)
            ->orderByDesc(DB::raw('trunc(phrMed.tran_date)'))
            ->orderBy('phrMed.sl_no')
            ->get();

        $invoiceIds = $data->pluck('invoice_no_fk')->unique();

        $ledgerNumbers = [];
        foreach ($invoiceIds as $invoiceId) {
            $ledgerNumbers[$invoiceId] = DB::table('finc_ledgermst')
                ->select('ledgertrn_no_fk')
                ->where('invoice_no_fk', $invoiceId)
                ->orderBy('invoice_no_fk', 'DESC')
                ->first();
        }
        // dd($ledgerNumbers);
        $data->transform(function ($item) use ($ledgerNumbers) {
            $invoiceId = $item->invoice_no_fk;
            $item->ledgertrn_no_fk = $ledgerNumbers[$invoiceId]->ledgertrn_no_fk ?? null;
            return $item;
        });
        $counter_no = $this->getLookupListByCode("PHRDEL");
        return response()->json(["success" => true, "data" => $data, 'type' => $type, 'counter_no' => $counter_no], 200);
    }
    public function medItemDelivered(Request $request)
    {
        $toDate = date('Y-m-d');
        $type = $request->type;

        $data = DB::table('phr_patmedtran phrMed')
            ->leftJoin('psn_t_prescription_vw pres', 'pres.prescription_no_pk', '=', 'phrMed.pres_no_fk')
            ->select('pres.prescription_no_pk', 'pres.prescription_uid', 'pres.prescription_date', 'pres.patient_name', 'pres.patient_code as patient_code', 'phrMed.invoice_no_fk', 'phrMed.tran_date', 'phrMed.sl_no', 'phrMed.delivery_at')
            ->where('phrMed.tran_type', 'ID')
            ->where('phrMed.delivery_ind', 1)
            ->whereDate(DB::raw('trunc(phrMed.delivery_at)'), '=', $toDate)
            // ->whereDate('phrMed.delivery_at', '=', $toDate)
            // ->orWhereNull('FINC_INVOICEMST.PRESCRIPTION_NO_FK')
            ->orderByDesc(DB::raw('trunc(phrMed.delivery_at)'))
            ->orderBy('phrMed.sl_no')
            ->get();
        // dd( $data);
        $invoiceIds = $data->pluck('invoice_no_fk')->unique();

        $ledgerNumbers = [];
        foreach ($invoiceIds as $invoiceId) {
            $ledgerNumbers[$invoiceId] = DB::table('finc_ledgermst')
                ->select('ledgertrn_no_fk')
                ->where('invoice_no_fk', $invoiceId)
                ->orderBy('invoice_no_fk', 'DESC')
                ->first();
        }
        // dd($ledgerNumbers);
        $data->transform(function ($item) use ($ledgerNumbers) {
            $invoiceId = $item->invoice_no_fk;
            $item->ledgertrn_no_fk = $ledgerNumbers[$invoiceId]->ledgertrn_no_fk ?? null;
            return $item;
        });
        return response()->json(["success" => true, "data" => $data, 'type' => $type], 200);
    }
    public function medItemSearch(Request $request)
    {
        $search_date_from = $request->input('search_date_from') != "" ? $this->formatDate($request->input('search_date_from')) : '';
        $search_date_to = $request->input('search_date_to') != "" ? $this->formatDate($request->input('search_date_to')) : '';

        $datas = DB::table('phr_patmedtran phrMed')
            ->leftJoin('psn_t_prescription_vw pres', 'pres.prescription_no_pk', '=', 'phrMed.pres_no_fk')
            ->select('pres.prescription_no_pk', 'pres.prescription_uid', 'pres.prescription_date', 'pres.patient_name', 'pres.patient_code as patient_code', 'phrMed.invoice_no_fk', 'phrMed.tran_date', 'phrMed.sl_no')
            ->where('phrMed.tran_type', 'ID')
            ->where('phrMed.delivery_ind', 1);

        if (!empty($search_date_from)) {
            $query = $datas->whereDate('phrMed.delivery_at', '>=', $search_date_from);
        }
        if (!empty($search_date_to)) {
            $query = $datas->whereDate('phrMed.delivery_at', '<=', $search_date_to);
        }
        $data = $query->orderByDesc(DB::raw('trunc(phrMed.delivery_at)'))
            ->orderBy('phrMed.sl_no')
            ->get();
        // dd($data);
        $invoiceIds = $data->pluck('invoice_no_fk')->unique();

        $ledgerNumbers = [];
        foreach ($invoiceIds as $invoiceId) {
            $ledgerNumbers[$invoiceId] = DB::table('finc_ledgermst')
                ->select('ledgertrn_no_fk')
                ->where('invoice_no_fk', $invoiceId)
                ->orderBy('invoice_no_fk', 'DESC')
                ->first();
        }
        // dd($ledgerNumbers);
        $data->transform(function ($item) use ($ledgerNumbers) {
            $invoiceId = $item->invoice_no_fk;
            $item->ledgertrn_no_fk = $ledgerNumbers[$invoiceId]->ledgertrn_no_fk ?? null;
            return $item;
        });
        return response()->json(["success" => true, "data" => $data], 200);
    }
    public function dosePrint($invoice, $pres_id)
    {
        // PSN_T_PRESCRIPTION_MED replaced by psn_t_prescription_med_vw
        $data = DB::table('finc_invoicemst as mst')
            ->join('finc_invoicedtl as dtl', 'dtl.invoice_no_fk', '=', 'mst.invoice_no_pk')
            ->join('psn_t_prescription_med_vw as pres', function ($join) {
                $join->on('pres.prescription_no_fk', '=', 'mst.prescription_no_fk')
                    ->on('pres.item_no_fk', '=', 'dtl.item_no_fk');
            })
            // ->join('phr_pharmacy_vw as pharmacy', 'pharmacy.item_no_fk', '=', 'dtl.item_no_fk')
            ->select('pres.brand_name', 'pres.dosage', 'pres.instruction_take', 'pres.route', 'pres.duration', 'pres.duration_mu', 'pres.prescription_no_fk', 'pres.patient_name', 'pres.patient_code', 'pres.full_name as doctor_name', 'dtl.item_no_fk', 'mst.invoice_no_pk', 'pres.au_entry_at', 'pres.generic_name')
            ->where('mst.invoice_no_pk', $invoice)
            ->where('dtl.cancel_ind', null)
            // ->distinct()
            ->get();

        return view("admin.pathology.dose_print", ['data' => $data]);
        //    $pdf = App::make('dompdf.wrapper');
        //    $pdf = PDF::loadView("admin.pathology.dose_print", ['data' => $data]);
        //    return $pdf->stream("medicine dose.pdf", array("Attachment" => false));
    }
    public function dosePrintIpd($invoice, $requ_id)
    {
        // PSN_T_PRESCRIPTION_MED replaced by psn_t_prescription_med_vw
        $data = DB::table('finc_invoicemst as mst')
            ->join('finc_invoicedtl as dtl', 'dtl.invoice_no_fk', '=', 'mst.invoice_no_pk')
            ->join('ipd_admitted_patlist_vw as adm', 'adm.admission_no_pk', '=', 'mst.admission_no_pk')
            ->join('psn_t_prescription_med_vw as pres', function ($join) {
                $join->on('pres.prescription_no_fk', '=', 'mst.prescription_no_fk')
                    ->on('pres.item_no_fk', '=', 'dtl.item_no_fk');
            })
            // ->join('phr_pharmacy_vw as pharmacy', 'pharmacy.item_no_fk', '=', 'dtl.item_no_fk')
            ->select('pres.brand_name', 'pres.dosage', 'pres.instruction_take', 'pres.route', 'pres.duration', 'pres.duration_mu', 'pres.prescription_no_fk', 'pres.patient_name', 'pres.patient_code', 'pres.full_name as doctor_name', 'dtl.item_no_fk', 'mst.invoice_no_pk', 'pres.au_entry_at', 'pres.generic_name','adm.new_bed_name','adm.new_ward_name','adm.admission_no_pk')
            ->where('mst.invoice_no_pk', $invoice)
            ->where('dtl.cancel_ind', null)
            // ->distinct()
            ->get();
        $req_data=DB::table('phr_ipdpatmedtran')->select('tran_date','wsec_user.user_fullname','wsec_user.user_code')->leftJoin('wsec_user','wsec_user.user_no_pk','=','phr_ipdpatmedtran.au_entry_by')->where('med_req_id',$requ_id)->where('tran_type','IR')->first();
            // dd($requ_id, $req_data);
        return view("admin.pathology.dose_print_ipd", ['data' => $data,'req_data'=>$req_data]);
        //    $pdf = App::make('dompdf.wrapper');
        //    $pdf = PDF::loadView("admin.pathology.dose_print", ['data' => $data]);
        //    return $pdf->stream("medicine dose.pdf", array("Attachment" => false));
    }
    public function prescripedMedListPdf($pres_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
    

        $prescription_mst =DB::table('psn_t_prescription_vw')
        ->select('psn_t_prescription_vw.*','patn_registration.mobile1')
        ->select('psn_t_prescription_vw.*','patn_registration.mobile1',DB::raw('pat_age(patn_registration.dob,nvl(psn_t_prescription_vw.prescription_date,sysdate))pat_age'))
        ->leftJoin('patn_registration','PATIENT_NO_FK','PATIENT_NO_pK')
        ->where('prescription_no_pk', '=', $pres_id)->first();


        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $pres_id)->orderBy('entry_serial', 'ASC')->get();


         $pres_med = [];
        foreach ($prescription_med as $med) {
            $key = $med->route . '^' . $med->dosage . '^' . $med->duration . '^' .
                $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' .
                $med->continue_ind . '^' . $med->multidose_txt;

            // unique রাখার জন্য multidose_txt এবং index ব্যবহার
            $pres_med[$med->brand_name][] = $med;
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();


        return view("admin.pathology.prescriped-medicine-list-pdf", ['patient_barcode' => $patient_barcode, 'prescription_barcode' => $prescription_barcode, 'prescription_mst' => $prescription_mst, 'pres_med' => $pres_med, 'prescription_med' => $prescription_med, 'po_hospital_details' => $po_hospital_details]);
        // dd( $pres_med);


        //    $pdf = App::make('dompdf.wrapper');
        //    $pdf = PDF::loadView("admin.pathology.prescriped-medicine-list-pdf", ['pres_med' => $pres_med,'invoice_mst_info'=>$invoice_mst_info,'prescription_med'=>$prescription_med,'po_hospital_details'=>$po_hospital_details])->setPaper('a5', 'portrait');
        //    return $pdf->stream("medicine dose.pdf", array("Attachment" => false));
    }

    public function expiryDatedosePrint($item_no, $invoice)
    {
        $invoice = intval($invoice);
        $item_no = intval($item_no);
        $exp_date = DB::table("phr_pharmacy_vw")
            ->select("expiry_date", "item_no_fk", "batch_no")
            ->where("invoice_no_fk", $invoice)
            ->where("item_no_fk", $item_no)
            ->get();
        // dd($invoice, $item_no , $exp_date);
        return $exp_date;
    }

    public function serviceItemfilter(Request $request)
    {


        $prescription_id = $request->input('prescription_id');
        $hdn_patient_id = $request->input('hdn_patient_id');
        $lab_id = $request->input('lab_id');
        $search_date_from = $request->input('search_date_from') != "" ? $this->formatDate($request->input('search_date_from')) : '';
        $search_date_to = $request->input('search_date_to') != "" ? $this->formatDate($request->input('search_date_to')) : '';

        if ($request->type == "MED") {
            $items = DB::table('PRES_MEDICINE_VW itemView')->distinct('itemView.prescription_no_pk')
                ->leftJoin('FINC_INVOICEMST', 'FINC_INVOICEMST.PRESCRIPTION_NO_FK', '=', 'itemView.prescription_no_pk')
                ->select('itemView.prescription_no_pk', 'itemView.prescription_uid', 'itemView.prescription_date', 'itemView.patient_name', 'itemView.uhid as patient_code', 'itemView.doctor_name')
                ->whereNull('itemView.invoice_no_pk');
        } else {
            $items = DB::table('pres_investigation_vw itemView')->distinct('itemView.prescription_no_pk')
                ->leftJoin('finc_invoicemst', 'finc_invoicemst.prescription_no_fk', '=', 'itemView.prescription_no_pk')
                ->select('itemView.prescription_no_pk', 'itemView.prescription_uid', 'itemView.prescription_date', 'itemView.patient_name', 'itemView.patient_code', 'itemView.doctor_name')
                ->whereNull('itemView.invoice_no_pk');
        }

        if (!empty($prescription_id)) {
            $items = $items->where('itemView.PRESCRIPTION_UID', $prescription_id);
        }
        if (!empty($hdn_patient_id)) {
            $items = $items->where('itemView.PATIENT_NO_FK', $hdn_patient_id);
        }
        if (!empty($search_date_from)) {
            $items = $items->whereDate('itemView.PRESCRIPTION_DATE', '>=', $search_date_from);
        }
        if (!empty($search_date_to)) {
            $items = $items->whereDate('itemView.PRESCRIPTION_DATE', '<=', $search_date_to);
        }
        $items = $items->orderByDesc('itemView.PRESCRIPTION_DATE')
            ->get();

        return Template::loadview("admin.pathology.service_item_from_prescription_list_filter", ['items' => $items, 'type' => $request->type]);
    }
    public function medItemReady(Request $request)
    {
        $invoice_no = $request->invoice_no;

        try {
            if ($invoice_no != "") {
                $data = [
                    'ready_ind' => 1,
                    'ready_at' => date('Y-m-d H:i'),
                    'ready_by' => Auth::id(),
                ];
                DB::table('phr_patmedtran')->where('invoice_no_fk', $invoice_no)->update($data);
                $tv_no = DB::table('opd_phrtvscreendisplay')->select('tvscreen_no_fk')->where('counter_no_fk', $request->counter_no)->first();
                $tv_no_fk = !empty($tv_no) ? $tv_no->tvscreen_no_fk : '';
                DB::table('opd_phrpatdisplay')->where('invoice_no_fk', $invoice_no)->update(['movement_type_no' => 2, 'counter_name' => $request->counter_name, 'counter_no' => $request->counter_no, 'tvscreen_no_fk' => $tv_no_fk]);
                DB::commit();

                //Pharmacy TV Update
                if (DB::table('SYSC_TVSCREENSETUP')->where('TVTAG', 'PHARMACYTV')->value('status') == 1) {
                    $data = $this->pharmacy_tv_information->get_pharmacy_tv_data(null);
                    event(new PharmacyTVUpdate($data));
                }
                //Pharmacy TV Update

                $message = ['msg' => 'Medicine Ready For Delivery', 'title' => 'Success'];
            }
        } catch (\Throwable $th) {
            //throw $th;

            $message = ['msg' => 'Medicine Not Ready For Delivery', 'title' => 'Error', 'error_reason' => $th];
        }
        return response()->json($message);

    }
    public function medItemDeliveryDone(Request $request)
    {
        $invoice_no = $request->invoice_no;

        try {
            if ($invoice_no != "") {
                $data = [
                    'TRAN_TYPE' => 'ID',
                    'delivery_ind' => 1,
                    'delivery_at' => date('Y-m-d H:i'),
                    'delivery_by' => Auth::id(),
                ];
                DB::table('phr_patmedtran')->where('invoice_no_fk', $invoice_no)->update($data);
                DB::table('opd_phrpatdisplay')->where('invoice_no_fk', $invoice_no)->update(['movement_type_no' => 3]);


                DB::commit();
                $message = ['msg' => 'Medicine  Delivery Successful', 'title' => 'Success'];


                //Pharmacy TV Update
                if (DB::table('SYSC_TVSCREENSETUP')->where('TVTAG', 'PHARMACYTV')->value('status') == 1) {
                    $data = $this->pharmacy_tv_information->get_pharmacy_tv_data(null);
                    event(new PharmacyTVUpdate($data));
                }
                //Pharmacy TV Update
            }
        } catch (\Throwable $th) {
            //throw $th;

            $message = ['msg' => 'Medicine Not Delivery', 'title' => 'Error', 'error_reason' => $th];
        }
        return response()->json($message);

    }
    public function medItemfilter(Request $request)
    {

        $prescription_id = $request->input('prescription_id');
        $hdn_patient_id = $request->input('hdn_patient_id');
        $lab_id = $request->input('lab_id');
        $search_date_from = $request->input('search_date_from') != "" ? $this->formatDate($request->input('search_date_from')) : '';
        $search_date_to = $request->input('search_date_to') != "" ? $this->formatDate($request->input('search_date_to')) : '';
        if ($request->type == "MED") {
            $items = DB::table('PRES_MEDICINE_VW itemView')->distinct('itemView.prescription_no_pk')
                ->leftJoin('FINC_INVOICEMST', 'FINC_INVOICEMST.PRESCRIPTION_NO_FK', '=', 'itemView.prescription_no_pk')
                ->select('itemView.prescription_no_pk', 'itemView.prescription_uid', 'itemView.prescription_date', 'itemView.patient_name', 'itemView.uhid as patient_code', 'itemView.doctor_name')
                ->orWhereNull('FINC_INVOICEMST.PRESCRIPTION_NO_FK');
        } else {
            $items = DB::table('PRES_INVESTIGATION_VW itemView')->distinct('itemView.prescription_no_pk')
                ->select('itemView.prescription_no_pk', 'itemView.prescription_uid', 'itemView.prescription_date', 'itemView.patient_name', 'itemView.patient_code', 'itemView.doctor_name');
        }

        if (!empty($prescription_id)) {
            $items = $items->where('itemView.PRESCRIPTION_UID', $prescription_id);
        }
        if (!empty($hdn_patient_id)) {
            $items = $items->where('itemView.PATIENT_NO_FK', $hdn_patient_id);
        }
        if (!empty($search_date_from)) {
            $items = $items->whereDate('itemView.PRESCRIPTION_DATE', '>=', $search_date_from);
        }
        if (!empty($search_date_to)) {
            $items = $items->whereDate('itemView.PRESCRIPTION_DATE', '<=', $search_date_to);
        }
        $items = $items->orderByDesc('itemView.PRESCRIPTION_DATE')
            ->get();

        return Template::loadview("admin.pathology.med_billing_list", ['items' => $items, 'type' => $request->type]);
    }
}
