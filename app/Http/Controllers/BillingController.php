<?php

namespace App\Http\Controllers;

use DB;
use App;
use PDO;
use \PDF;
use Auth;
use View;
use Session;
use Response;
use Carbon\Carbon;
use App\Models\Item;
use GuzzleHttp\Client;
use App\Models\Billing;
use App\Library\Template;
use App\Core\TV\TVService;
use App\Models\LookupItem;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Models\GrantUserService;
use App\Traits\DatatablesLoader;
use App\Core\TV\PharmacyTVService;
use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Models\PhysiotherapySchedule;
use App\Repositories\BillingRepository;
use App\Repositories\BaseRepository as Repo;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;


class BillingController extends Controller
{

    use LookupData, DatatablesLoader;

    protected $base;
    protected $billingRepository;

    public $patientId = "";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Billing $billing, PhysiotherapySchedule $physiotherapyschedule,  TVService $tv_information, PharmacyTVService $pharmacy_tv_information)
    {
        $this->middleware('auth');
        $this->base = new Repo($billing);
        $this->billingRepository = new BillingRepository($billing, $tv_information, $pharmacy_tv_information);
        $this->physiotherapyschedule = new Repo($physiotherapyschedule);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '=', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();


        return Template::loadView("admin.billing.billing_list", ['corporate_info' => $corporate_info]);
    }
    public function emergencyBillingListIndex(Request $request)
    {
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '=', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        // dd( $corporate_info);
        return Template::loadView("admin.billing.emergency_billing_list", ['corporate_info' => $corporate_info]);
    }
    public function dayCareBillingListIndex(Request $request)
    {
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '=', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        // dd( $corporate_info);
        return Template::loadView("admin.billing.day_care_billing_list", ['corporate_info' => $corporate_info]);
    }

    public function enquiryActivities(Request $request)
    {
        $corporate_info = DB::table('ccm_corporateclient_vw')
            ->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')
            ->where('active_status', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)
            ->where("GRANTSU_STATUS", "1")
            ->where("cash_counter_ind", "1")
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')
            ->orderBy('serviceunit_name', 'asc')
            ->get();

        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $paymodes  = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $patient_types = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_desc')->get();

        return Template::loadView("admin.billing.enquiry_activities",[
            'corporate_info' => $corporate_info,
            'service_point'  => $service_point,
            'bank_name'      => $bank_name,
            'paymodes'       => $paymodes,
            'patient_types'  => $patient_types,
        ]);
    }

    public function pos_billing_list(Request $request)
    {

        $module_code_list=DB::table('finc_phr_inv_billing_list_vw')->distinct()->select('module_code','module_name')->get();
        $counter=DB::table('sysc_serviceunit')->where('status',1)->where('pharmacy_ind',1)->select('serviceunit_no_pk','serviceunit_name')->orderBy('serviceunit_name')->get();

        return Template::loadView("admin.billing.pharmacy.pos_billing_list",['module_code_list'=>$module_code_list,'counter'=>$counter]);
    }
    public function cafe_billing_list($type="CAFE")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_billing_list",['type'=>$type]);
    }
    public function optical_billing_list($type="OPTICAL")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_billing_list",['type'=>$type]);
    }
    public function coffee_billing_list($type="COFFEE")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_billing_list",['type'=>$type]);
    }
    public function cafe_ipd_billing_list(Request $request,$type="CAFE-I")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_ipd_billing_list",['type'=>$type]);
    }
    public function coffee_ipd_billing_list(Request $request,$type="COFFEE-I")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_ipd_billing_list",['type'=>$type]);
    }
    public function optical_ipd_billing_list(Request $request,$type="OPTICAL-I")
    {
        return Template::loadView("admin.billing.pharmacy.cafe_ipd_billing_list",['type'=>$type]);
    }

    public function ipd_billing_list(Request $request)
    {
        return Template::loadView("admin.billing.ipd.ipd_billing_list");
    }

    public function emr_billing_list(Request $request)
    {
        return Template::loadView("admin.billing.ipd.emr_billing_list");
    }
    public function pos_billing_list_ipd(Request $request)
    {
        // $bill_info = DB::table('billing_list_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('invoice_date', date('Y-m-d'))->whereIn('module_code', ['PHR','PHR-I'])->whereNotNull('admission_no_pk')->orderBy('invoice_code', 'desc')->get();
        $bill_info =[];
        //  DB::table('finc_inv_billing_list_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('invoice_date', date('Y-m-d'))->whereIn('module_code', ['PHR', 'PHR-I', 'PHR-E','PHR-D','PHR-O'])->whereNotNull('admission_no_pk')->orderBy('invoice_code', 'desc')->get();
        // dd($bill_info);
        $module_code_list=DB::table('finc_opd_inv_billing_list_vw')->distinct()->select('module_code')->get();

        $item_info = [];
        if (!empty($bill_info)) {
            $inv_arr = [];
            foreach ($bill_info as $key => $value) {
                $inv_arr[$key] = $value->invoice_no_pk;
            }

            $item_info =[];// DB::table('finc_invoicedtl_vw')->whereIn('invoice_no_fk', $inv_arr)->get();
            // dd($item_info);
        }
        // dd($bill_info);
        return Template::loadView("admin.billing.pharmacy.pos_billing_list_ipd", ['bill_info' => $bill_info, 'item_info' => $item_info,'module_code_list'=>$module_code_list]);
    }
    public function pos_billing_list_ipd_payment(Request $request)
    {
        // billing_list_vw
        $bill_info =[];// DB::table('billing_list_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('invoice_date', date('Y-m-d'))->whereIn('module_code', ['PHR', 'PHR-I', 'PHR-E','PHR-D','PHR-O'])->whereNotNull('admission_no_pk')->orderBy('invoice_code', 'desc')->get();
        // dd($bill_info);

        $item_info = [];
        if (!empty($bill_info)) {
            $inv_arr = [];
            foreach ($bill_info as $key => $value) {
                $inv_arr[$key] = $value->invoice_no_pk;
            }

            $item_info = [];// DB::table('finc_invoicedtl_vw')->whereIn('invoice_no_fk', $inv_arr)->get();
            // dd($item_info);
        }
        // dd($item_info);
        // $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("pharmacy_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $service_point = GrantUserService::where('pharmacy_ind', '1') //->orWhere('hs_pos_ind', 1)
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind', 'hs_pos_ind')
            ->where('user_no_pk', Auth::id())
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('serviceunit_name', 'asc')
            ->distinct()
            ->get();
        return Template::loadView("admin.billing.pharmacy.pos_billing_list_ipd_payment", ['bill_info' => $bill_info, 'item_info' => $item_info, "paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name]);
    }


    public function ipdPaymentStroe(Request $request)
    {
        try {
            //code...

        // dd($request->all());
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date =  date('Y-m-d h:i:s', strtotime($time));
        $cur_datetime =  date('Y-m-d h:i:s', strtotime($time));
        $cmb_discount = $request->cmb_discount;
        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
        $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
        $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
        $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
        $remarks = !empty($request->remarks) ? $request->remarks : " ";
        $pay_mode = $request->pay_mode;
        $pay_amount = $request->pay_amount;
        $given_amount = $request->given_amount;
        $change_amount = $request->change_amount;
        $item_vat = 0;
        $urgent_fee = 0;
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment_amt;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $hospital_dis = 0; //($request->discount_amt != "") ? $request->discount_amt : 0;
        $hospital_dis_ipd_phr = ($request->discount_amt != "") ? $request->discount_amt : 0;
        // dd($hospital_dis);
        $doctor_dis = ($request->doctor_amt != "") ? $request->doctor_amt : 0;

        $total_discount_amount = $hospital_dis_ipd_phr + $doctor_dis;
        // dd($total_discount_amount);
        $discount_remarks = $request->remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $cunter_su_no = ($request->service_point != "") ? $request->service_point : 0;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $null = '';

        $out_sl_no = '';
        $empty_arr = [];
        $numelems = 10000;
        $zero = 0;

        if (empty($check_no)) {
            $check_no = $card_no;
        }
        if (empty($bank_name)) {
            $bank_name = $bank_name_card;
        }

        $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);

        $query = [];
        //DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

        // dd($query);

        $auth_id = Auth::id();
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();

        $date =  date('Y-m-d h:i:s', strtotime($time));
        $in_paymood_arr_t = $request->pay_method_mode;
        $in_pay_mood_type_arr_t = $request->mBank_types;
        $in_bank_name_arr_t = $request->pay_bank_name;
        $in_transaction_id_arr_t = $request->trans_id_no;
        $in_bank_card_no_arr_t = $request->card_number;
        $in_acc_holder_name_arr_t = $request->acc_holder_name;
        $in_payment_amt_arr_t = $request->total_amt;
        $in_paymood_count = $paymood_count;
        $in_au_entry_by = $auth_id;
        $in_au_entry_session = "session";
        $in_au_entry_hospital_pk_no =  Session::get('user.ses_hospital_no_pk');
        $invoice_no = (isset($query->invoice_no_fk) ? $query->invoice_no_fk : "");
        $ledger_no = (isset($query->ledger_no_pk) ? $query->ledger_no_pk : "");


        $i = 0;
        if (!empty($in_paymood_arr_t)) {
            foreach ($in_paymood_arr_t as $key => $value) {
                $sc_date = date("d-m-Y");
                $in_paymood_arr_val[$i] = (!empty($value) ? $value : "");
                $in_pay_mood_type_arr_val[$i] = (!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "");
                $in_bank_name_arr_val[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "");
                $in_transaction_id_arr_val[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "");
                $in_bank_card_no_arr_val[$i] = (!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "");
                $in_acc_holder_name_arr_val[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "");
                $in_payment_amt_arr_val[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "");

                $i++;
            }
        }

        $in_paymood_arr = (!empty($in_paymood_arr_t) ? count($in_paymood_arr_t) : 1);
        $in_pay_mood_type_arr = (!empty($in_pay_mood_type_arr_t) ? count($in_pay_mood_type_arr_t) : 1);
        $in_bank_name_arr = (!empty($in_bank_name_arr_t) ? count($in_bank_name_arr_t) : 1);
        $in_transaction_id_arr = (!empty($in_transaction_id_arr_t) ? count($in_transaction_id_arr_t) : 1);
        $in_bank_card_no_arr = (!empty($in_bank_card_no_arr_t) ? count($in_bank_card_no_arr_t) : 1);
        $in_acc_holder_name_arr = (!empty($in_acc_holder_name_arr_t) ? count($in_acc_holder_name_arr_t) : 1);
        $in_payment_amt_arr = (!empty($in_payment_amt_arr_t) ? count($in_payment_amt_arr_t) : 1);
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';
        $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";

        $admission_invoice_due = $request->payment;
        $admission_no = [];
        $invoice_no = [];
        $due_amt = [];
        $expl = [];
        // dd( $admission_invoice_due);
        $i = 0;
        foreach ($admission_invoice_due as $key => $value) {
            $expl = explode('_', $value);
            $admission_no = $expl[0];
            $invoice_no[$key] = $expl[1];
            $due_amt[$key] = $expl[2];
        }
        $patient_no = 0;
        if ($admission_no != "") {
            $patient_no = DB::table('ipd_admitted_patlist_vw')->select('patient_no_fk')->where('admission_no_pk', $admission_no)->first()->patient_no_fk;
        }
        $invoice_count = count($invoice_no);
        $given_amt = 0;
        // dd( $admission_no,$invoice_no,$due_amt);
        $in_ledgertrn_no = 0;
        $out_ledgertrn_no = $out_multiinv_group_nonuq_no = $out_error = "";
        $pdo1 = DB::getPdo();
        $billpayment = $pdo1->prepare("begin pkg_billing_ipd_v0.prc_billpayment_ipdphr_invl_wp(
            :in_payment_date,
            :in_payment_datetime,
            :in_module_no_fk,
            :in_counter_su_no_fk,
            :in_patient_no_fk,
            :in_admission_no_fk,
            :in_a_invoice_no_fk,
            :in_a_invoice_due,
            :in_total_paid,
            :in_total_discount,
            :in_invoice_count,
            :in_given_amt,
            :in_disc_type_lookup_no_fk,
            :in_disc_remarks,
            :in_disc_amt_by_doc,
            :in_disc_amt_by_doc_no_fk,
            :in_disc_amt_by_hosp,
            :in_disc_amt_by_hosp_auth_by,
            :in_disc_amt_request_by_name,
            :in_paymood,
            :in_pay_mood_type,
            :in_bank_name,
            :in_transaction_id,
            :in_bank_card_no,
            :in_acc_holder_name,
            :in_payment_amt,
            :in_paymood_count,
            :in_ledgertrn_no,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :out_ledgertrn_no,
            :out_multiinv_group_nonuq_no,
            :out_error);
            end;");
        $billpayment->bindParam(':in_payment_date', $cur_date);
        $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
        $billpayment->bindParam(':in_module_no_fk', $module_id);
        $billpayment->bindParam(':in_counter_su_no_fk', $cunter_su_no);
        $billpayment->bindParam(':in_patient_no_fk',   $patient_no);

        $billpayment->bindParam(':in_admission_no_fk',  $admission_no);
        $billpayment->bindArray(':in_a_invoice_no_fk', $invoice_no, count($invoice_no), $numelems, SQLT_INT);
        $billpayment->bindArray(':in_a_invoice_due', $due_amt, count($due_amt), $numelems, SQLT_FLT);

        $billpayment->bindParam(':in_total_paid', $total_payment);
        $billpayment->bindParam(':in_total_discount', $total_discount_amount);
        $billpayment->bindParam(':in_invoice_count', $invoice_count);

        $billpayment->bindParam(':in_given_amt', $given_amt);

        // DISCOUNT COLUMN PREPARATION START
        $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
        //dd($discount_info->lookupdata_no_pk);

        $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;

        if (!empty($discount_info)) {
            if ($discount_info->lookupdata_code == "DOCTOR") {
                $doctor_disc_amt = $disc_amount_doctor;
                $doctor_id_for_disc = $hdn_doctor_id;
            }

            if ($discount_info->lookupdata_code = "GENERAL") {
                $hospital_disc_amt = $disc_amount_hospital;
                $hospital_id_for_disc = $hdn_doctor_id ?? $auth_id;
            }

            if ($discount_info->lookupdata_code = "BOTH") {
                $doctor_disc_amt = $disc_amount_doctor;
                $doctor_id_for_disc = $hdn_doctor_id;
                $hospital_disc_amt = $disc_amount_hospital;
            }
        }
        // DISCOUNT COLUMN PREPARATION END
        $lookupdata_no_pk = $discount_info->lookupdata_no_pk;
        $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
        $billpayment->bindParam(':in_disc_remarks', $discount_remarks);
        $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_dis);
        $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
        $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_dis);
        $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $hospital_id_for_disc);
        $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);

        $billpayment->bindArray(':in_paymood', $in_paymood_arr_val, $in_paymood_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_pay_mood_type', $in_pay_mood_type_arr_val, $in_pay_mood_type_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_bank_name', $in_bank_name_arr_val, $in_bank_name_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_transaction_id', $in_transaction_id_arr_val, $in_transaction_id_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_bank_card_no', $in_bank_card_no_arr_val, $in_bank_card_no_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_acc_holder_name', $in_acc_holder_name_arr_val, $in_acc_holder_name_arr, $numelems, SQLT_CHR);
        $billpayment->bindArray(':in_payment_amt', $in_payment_amt_arr_val, $in_payment_amt_arr, $numelems, SQLT_FLT);
        $billpayment->bindParam(':in_paymood_count',    $in_paymood_arr);
        $billpayment->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billpayment->bindParam(':in_au_entry_by', $auth_id);
        $billpayment->bindParam(':in_au_entry_session', $entry_session);
        $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billpayment->bindParam(':out_multiinv_group_nonuq_no', $out_multiinv_group_nonuq_no, PDO::PARAM_INT);
        $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd( $billpayment);
        $billpayment->execute();

        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error',];
        } else {
            DB::commit();
            $message = ['msg' => ' Bill created successfully.', 'title' => 'Success', 'insert_id' => $out_multiinv_group_nonuq_no];
        }
    } catch (\Throwable $th) {
           DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
    }
        return response()->json($message);
    }
    public function ipdPosPaymentSlip($group_id = "")
    {
        $all_trn_no = DB::table('finc_ledgertrnmultiinv')->select('ledgertrn_no_fk','invoice_no_fk')->where('multiinv_group_nonuq_no', $group_id)->get();
        $trn_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $trn_no[] = $value->ledgertrn_no_fk;
            }
        }
        $invoice_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $invoice_no[] = $value->invoice_no_fk;
            }
        }

        $trn_id = $group_id;
        $payment_details = DB::table('finc_inv_c022_sum_amount_vw')->select('invoice_no_pk','discount','net_collection','patient_code','ledgertrn_no_pk','au_entry_at','patient_name','patient_type_code','dob','invoice_date','age','gender_txt','mobile1','present_addr')->whereIn('ledgertrn_no_pk', $trn_no)->get();
        $payment_sales_price = DB::table('finc_invoicemst_c022_sum_vw')->select('sales', 'invoice_no_pk', 'discount', 'net_collection', 'sales_cancel')->whereIn('invoice_no_pk', $invoice_no)->get();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_hosp', 'disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $payment_details[0]->invoice_no_pk)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
            // dd( $ledgermst_paydisc);
        $ledger_no = DB::table("finc_ledgermst")
        ->select('ledger_no_pk')
            ->whereIn("ledgertrn_no_fk", $trn_no)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->get();

        $l_date = [];
        if (!empty($ledger_no)) {
            foreach ($ledger_no as $value) {
                $l_date[] =  $value->ledger_no_pk;
            }
        }


        $paymood = DB::table("finc_ledger_paymood")
            ->select('paymood','pay_amount','pay_mood_type')
            ->whereIn("LEDGER_NO_FK", $l_date)
            ->get();
        // dd($paymood);
        return Template::loadview("admin.billing.ipd_pharmacy_payment_invoice", ['payment_details' => $payment_details,  'ledgermst_paydisc' => $ledgermst_paydisc, 'paymood' => $paymood, 'trn_id' => $trn_id, 'payment_sales_price' => $payment_sales_price]);

        // dd($trn_id);
    }
    public function ipdPosPaymentSlipPrint($group_id = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $all_trn_no = DB::table('finc_ledgertrnmultiinv')->where('multiinv_group_nonuq_no', $group_id)->get();
        $trn_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $trn_no[] = $value->ledgertrn_no_fk;
            }
        }
        $invoice_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $invoice_no[] = $value->invoice_no_fk;
            }
        }

        $trn_id = $group_id;
        $payment_details = DB::table('finc_inv_c022_sum_amount_vw')->select('finc_inv_c022_sum_amount_vw.*')->whereIn('ledgertrn_no_pk', $trn_no)->get();
        $payment_sales_price = DB::table('finc_invoicemst_c022_sum_vw')->select('sales', 'invoice_no_pk', 'discount', 'net_collection', 'sales_cancel')->whereIn('invoice_no_pk', $invoice_no)->get();
        // dd(  $payment_details );
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.invoice_no_pk', $payment_details[0]->invoice_no_pk)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $payment_details[0]->invoice_no_pk)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $ledger_no = DB::table("finc_ledgermst")
            // ->where("invoice_no_fk",$payment_details[0]->invoice_no_pk)
            ->whereIn("ledgertrn_no_fk", $trn_no)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->get();

        $l_date = [];
        if (!empty($ledger_no)) {
            foreach ($ledger_no as $value) {
                $l_date[] =  $value->ledger_no_pk;
            }
        }


        $paymood = DB::table("finc_ledger_paymood")
            // ->where("invoice_no_fk", $payment_details[0]->invoice_no_pk)
            ->whereIn("LEDGER_NO_FK", $l_date)
            ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($trn_id);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($payment_details[0]->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();


        $pdf = PDF::loadView("admin.billing.ipd_pharmacy_payment_invoice_print", ['payment_details' => $payment_details, 'discout_by' => $discout_by, 'ledgermst_paydisc' => $ledgermst_paydisc, 'paymood' => $paymood, 'trn_id' => $trn_id, 'po_hospital_details' => $po_hospital_details, 'invoice_barcode' => $invoice_barcode, 'pat_barcode' => $pat_barcode, 'payment_sales_price' => $payment_sales_price])->setPaper('a5', 'portrait');

        return $pdf->stream("invoice.pdf", array("Attachment" => false));


        // return Template::loadview("admin.billing.ipd_pharmacy_payment_invoice_print",['payment_details'=>$payment_details,'discout_by'=>$discout_by,'ledgermst_paydisc'=>$ledgermst_paydisc,'paymood'=>$paymood,'trn_id'=>$trn_id,'po_hospital_details'=>$po_hospital_details,'invoice_barcode'=>$invoice_barcode,'pat_barcode'=>$pat_barcode]);

        // dd($trn_id);
    }

    public function ipdPosPaymentSlipPrintPhr($group_id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $all_trn_no = DB::table('finc_ledgertrnmultiinv')->select('ledgertrn_no_fk','invoice_no_fk')->where('multiinv_group_nonuq_no', $group_id)->get();
        $trn_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $trn_no[] = $value->ledgertrn_no_fk;
            }
        }
        $invoice_no = [];
        if (!empty($all_trn_no)) {
            foreach ($all_trn_no as $value) {
                $invoice_no[] = $value->invoice_no_fk;
            }
        }

        $trn_id = $group_id;
        $payment_details = DB::table('finc_inv_c022_sum_amount_vw')->select('invoice_no_pk','discount','net_collection','patient_code','ledgertrn_no_pk','au_entry_at','patient_name','patient_type_code','dob','invoice_date','age','gender_txt','mobile1','present_addr','admission_no_pk','doctor_name','first_doc_name','second_doc_name','invoice_code')->whereIn('ledgertrn_no_pk', $trn_no)->get();

        $payment_sales_price = DB::table('finc_invoicemst_c022_sum_vw')->select('sales', 'invoice_no_pk', 'discount', 'net_collection', 'sales_cancel')->whereIn('invoice_no_pk', $invoice_no)->get();

        // dd($group_id, $all_trn_no, $payment_details );
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.invoice_no_pk', $payment_details[0]->invoice_no_pk)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp', 'disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $payment_details[0]->invoice_no_pk)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $ledger_no = DB::table("finc_ledgermst")
        ->select('ledger_no_pk')
            ->whereIn("ledgertrn_no_fk", $trn_no)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->get();

        $l_date = [];
        if (!empty($ledger_no)) {
            foreach ($ledger_no as $value) {
                $l_date[] =  $value->ledger_no_pk;
            }
        }


        $paymood = DB::table("finc_ledger_paymood")
            ->select('paymood','pay_amount','pay_mood_type')
            ->whereIn("LEDGER_NO_FK", $l_date)
            ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($trn_id);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($payment_details[0]->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();



        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);

        $pdf->loadView("admin.billing.ipd_pharmacy_payment_invoice_print_phr", ['payment_details' => $payment_details, 'discout_by' => $discout_by, 'ledgermst_paydisc' => $ledgermst_paydisc, 'paymood' => $paymood, 'trn_id' => $trn_id, 'po_hospital_details' => $po_hospital_details, 'invoice_barcode' => $invoice_barcode, 'pat_barcode' => $pat_barcode, 'payment_sales_price' => $payment_sales_price]);
        $item_count = count($payment_details) * 10;
        $canvas = $pdf->getDomPDF()->get_canvas();
        $height = ($canvas->get_height());
        // dd($height);
        $pdf->setPaper(array(0, 0, 226.77, $height + 20));
        return $pdf->stream("pos-invoice.pdf", array("Attachment" => false));
    }
    public function posSearchBillListIpd(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;
        $module_code = $request->module_code;


        $phr = "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";


        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime("+1 day", strtotime($request->date_to))) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";

        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause invoice_date between '$date_from' and '$date_to' " : "";


        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_fk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";
        // FINC_PHR_INV_BILLING_LIST_VW finc_inv_billing_list_vw
        $bill_info = DB::select('select ledger_amt_sales,sales_cancel,sales,refund,discount,collection,invoice,invoice_date,au_entry_time,admission_no_pk,patient_code,patient_name,patient_gender,mobile1,invoice_no_pk from FINC_PHR_INV_BILLING_LIST_VW  where  ' . $sql_cond . ' and au_entry_hospital_pk_no = ' . Session::get("user.ses_hospital_no_pk") . ' and  admission_no_pk is not null');

        // dd($bill_info);
        $item_info = [];
        if (!empty($bill_info)) {
            $inv_arr = [];
            foreach ($bill_info as $key => $value) {
                $inv_arr[$key] = $value->invoice_no_pk;
            }

            $item_info = DB::table('finc_invoicedtl_vw')->select('invoice_no_fk','item_name','item_qty','cancel_qty','total_item_amt')->whereIn('invoice_no_fk', $inv_arr)->get();
            // dd($item_info);
        }
        //  dd($bill_info);
        return Template::loadView("admin.billing.pharmacy.pos_billing_list_include_ipd", ['bill_info' => $bill_info, 'item_info' => $item_info]);
    }
    public function posSearchBillListIpdPayment(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;


        $phr ="";// "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";


        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";
        // dd($date_from ,  $date_to);
        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause trunc(invoice_date) between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - discount) - collection > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause ((urgent_fee + ledger_amt_sales) - discount) - collection = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";

        // finc_inv_billing_list_vw FINC_PHR_INV_BILLING_LIST_VW
        $bill_info = DB::select('select ledger_amt_sales,sales_cancel,sales,refund,discount,collection,invoice,invoice_date,au_entry_time,admission_no_pk,patient_code,patient_name,patient_gender,mobile1,invoice_no_pk,invoice_trn_list   from FINC_PHR_INV_BILLING_LIST_VW   where  ' . $sql_cond . ' and au_entry_hospital_pk_no = ' . Session::get("user.ses_hospital_no_pk") . ' and  admission_no_pk is not null');
        $item_info = [];
        $advance_paid_inv = [];
        $advance_paid = [];
        if (!empty($bill_info)) {
            $inv_arr = [];
            foreach ($bill_info as $key => $value) {
                $inv_arr[$key] = $value->invoice_no_pk;
            }

            $item_info = DB::table('finc_invoicedtl_vw')->select('invoice_no_fk','item_name','item_qty','cancel_qty','total_item_amt','current_item_qty')->whereIn('invoice_no_fk', $inv_arr)->get();
            $advance_paid_inv = DB::table('finc_invoicedtl_vw')->select('invoice_no_fk')->whereIn('invoice_no_fk', $inv_arr)->where('ITEM_CODE', 'ADVANCE')->get();
            $advance_inv_arr = [];
            foreach ($advance_paid_inv as $key => $data) {
                $advance_inv_arr[$key] = $data->invoice_no_fk;
            }
            $advance_paid  = DB::table('FINC_INV_C022_SUM_AMOUNT_VW')->select(DB::raw('sum(net_collection) net_collection'))->whereIn('invoice_no_pk', $advance_inv_arr)->first();

        }

        // dd($bill_info);

        // $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("pharmacy_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $service_point = GrantUserService::where('pharmacy_ind', '1') //->orWhere('hs_pos_ind', 1)
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind', 'hs_pos_ind')
            ->where('user_no_pk', Auth::id())
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('serviceunit_name', 'asc')
            ->distinct()
            ->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadView("admin.billing.pharmacy.pos_billing_list_include_ipd_payment", ['bill_info' => $bill_info, 'item_info' => $item_info, "paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name, 'advance_paid' => $advance_paid]);
    }
    public function posPdfBillListIpd(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $phr ="";// "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";

        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to)) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";

        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause a.invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause a.invoice_date between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause a.au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause a.patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause a.present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause a.admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause ((a.urgent_fee +a.ledger_amt_sales) - a.discount) - a.collection > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause ((a.urgent_fee + a.ledger_amt_sales) - a.discount) - a.collection = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause a.invoice_no_pk is not null" : "";

        $title = "POS ipd bill";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // FINC_PHR_INV_BILLING_LIST_VW  finc_inv_billing_list_vw


        $bill_info = DB::select('select adm.ADMISSION_DATE,a.ledger_amt_sales,a.sales_cancel,a.sales,a.refund,a.discount,a.collection,a.invoice,a.invoice_date,a.au_entry_time,a.admission_no_pk,a.patient_code,a.patient_name,a.patient_gender,a.mobile1,a.invoice_no_pk,ADM.age, X.SERVICEUNIT_NAME AS SU_NAME,BED.BED_NAME,WD.WARD_NAME,pat.dob   from FINC_PHR_INV_BILLING_LIST_VW a LEFT JOIN IPD_ADMISSION ADM ON adm.ADMISSION_NO_PK = A.ADMISSION_NO_PK left join IPDS_BED BED on BED.BED_NO_PK = ADM.CURR_BED_NO_FK  LEFT JOIN IPDS_WARD WD ON bed.WARD_NO_FK = WD.WARD_NO_PK LEFT JOIN SYSC_SERVICEUNIT x ON ADM.SU_NO_FK = X.SERVICEUNIT_NO_PK left join PATN_REGISTRATION pat on pat.PATIENT_NO_PK = a.PATIENT_NO_PK where  ' . $sql_cond . ' and a.au_entry_hospital_pk_no = ' . Session::get("user.ses_hospital_no_pk") . ' and  a.admission_no_pk is not null');

        $item_info = [];
        if (!empty($bill_info)) {
            $inv_arr = [];
            foreach ($bill_info as $key => $value) {
                $inv_arr[$key] = $value->invoice_no_pk;
            }
            $item_info = DB::table('finc_invoicedtl_vw')->select('invoice_no_fk','item_name','item_qty','cancel_qty','total_item_amt')->whereIn('invoice_no_fk', $inv_arr)->get();
            // dd($item_info);
        }



        //DB::select('select * from finc_invoicedtl_vw where  '.$sql_cond.' and au_entry_hospital_pk_no = '.Session::get("user.ses_hospital_no_pk").' and  admission_no_pk is not null');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.billing.pharmacy.pos_billing_list_ipd_pdf", ['bill_info' => $bill_info, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'item_info' => $item_info])->setPaper('a4', 'portrait');
        return $pdf->stream('pos_billing_list_ipd_pdf.pdf');

        // return Template::loadView("admin.billing.pharmacy.pos_billing_list_ipd_pdf",['bill_info'=>$bill_info,'barcode_no'=>$barcode_no]);



    }

    public function billList(Request $request)
    {

        // $table = 'billing_list_vw';
        // $table = 'finc_inv_billing_list_vw';
        $table = 'finc_opd_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        $to_date = date('Y-m-d');
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "trunc(INVOICE_DATE) = '$to_date' and au_entry_hospital_pk_no =$hospital_id  "; //and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),

            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),

            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),

            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),
            array('db' => 'bill_type', 'dt' => 36),

        );


        // dd($request, $table, $primaryKey, $columns, null, $where);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function emergencyBillList(Request $request)
    {

        // $table = 'billing_list_vw';
        $table = 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "au_entry_hospital_pk_no =$hospital_id  and module_code in ('EMR') ";

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),

            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),

            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),

            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),

        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function dayCareBillList(Request $request)
    {

        // $table = 'billing_list_vw';
        $table = 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "au_entry_hospital_pk_no =$hospital_id  and module_code in ('DYC') ";

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),

            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),

            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),

            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),

        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function posBillList(Request $request)
    {
        $toDate = date('Y-m-d');
        $sql_cond = "invoice_date =  '$toDate'";
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $table ='FINC_PHR_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $where = " au_entry_hospital_pk_no ='$hospital_id' and trunc(invoice_date) =  '$toDate' and  invoice_trn_list is not null";//module_code in ('PHR' , 'PHR-I', 'PHR-E','PHR-D','PHR-O') and
        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),

            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),

            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'present_addr', 'dt' => 27),
            array('db' => 'au_entry_time', 'dt' => 28),
            array('db' => 'invoice_trn_list', 'dt' => 29),
            array('db' => 'sales_cancel', 'dt' => 30),
            array('db' => 'sales', 'dt' => 31),
            array('db' => 'prescription_no_fk', 'dt' => 32),
        );
        // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function cafeBillList(Request $request,$type="")
    {

        $toDate = date('Y-m-d');
        $sql_cond = "invoice_date =  '$toDate'";
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $table ='FINC_CAFE_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $where = " au_entry_hospital_pk_no ='$hospital_id' and trunc(invoice_date) =  '$toDate' and  invoice_trn_list is not null and module_code ='$type'";//module_code in ('PHR' , 'PHR-I', 'PHR-E','PHR-D','PHR-O') and
        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'collection', 'dt' =>9 ),
            array('db' => 'due', 'dt' =>10 ),
            array('db' => 'refund', 'dt' =>11 ),
            array('db' => 'discount', 'dt' =>12 ),
            array('db' => 'ledger_amt_sales', 'dt' =>13 ),
            array('db' => 'au_entry_time', 'dt' =>14  ),
            array('db' => 'invoice_trn_list', 'dt' =>15 ),
            array('db' => 'sales_cancel', 'dt' =>16 ),

        );
        // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function cafeIpdBillList(Request $request,$type="")
    {
        $toDate = date('Y-m-d');
        $sql_cond = "invoice_date =  '$toDate'";
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $table ='FINC_CAFE_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $where = " au_entry_hospital_pk_no ='$hospital_id' and trunc(invoice_date) =  '$toDate' and  invoice_trn_list is not null and module_code ='$type'";//module_code in ('PHR' , 'PHR-I', 'PHR-E','PHR-D','PHR-O') and
        $columns = array(
            // array('db' => 'invoice', 'dt' => 0),
            // array('db' => 'invoice_no_pk', 'dt' => 1),
            // array('db' => 'invoice_code', 'dt' => 2),
            // array('db' => 'invoice_date', 'dt' => 3),
            // array('db' => 'patient_code', 'dt' => 4),
            // array('db' => 'patient_name', 'dt' => 5),
            // array('db' => 'patient_gender', 'dt' => 6),
            // array('db' => 'mobile1', 'dt' => 7),
            // array('db' => 'patient_no_pk', 'dt' => 8),
            // array('db' => 'person_no_fk', 'dt' => 9),
            // array('db' => 'full_name', 'dt' => 10),
            // array('db' => 'doctor_gender', 'dt' => 11),
            // array('db' => 'specialization', 'dt' => 12),
            // array('db' => 'phone_mobile', 'dt' => 13),

            // // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // // array('db' => 'urgent_fee', 'dt' => 15),
            // // array('db' => 'total_bill', 'dt' => 16),
            // array('db' => 'collection', 'dt' => 14),
            // array('db' => 'due', 'dt' => 15),
            // array('db' => 'refund', 'dt' => 16),

            // array('db' => 'photo_name', 'dt' => 17),
            // array('db' => 'person_code', 'dt' => 18),
            // array('db' => 'degree1', 'dt' => 19),
            // array('db' => 'degree2', 'dt' => 20),
            // array('db' => 'degree3', 'dt' => 21),
            // array('db' => 'degree4', 'dt' => 22),
            // array('db' => 'au_entry_at', 'dt' => 23),
            // array('db' => 'au_update_at', 'dt' => 24),

            // array('db' => 'discount', 'dt' => 25),
            // array('db' => 'ledger_amt_sales', 'dt' => 26),
            // array('db' => 'present_addr', 'dt' => 27),
            // array('db' => 'au_entry_time', 'dt' => 28),
            // array('db' => 'invoice_trn_list', 'dt' => 29),
            // array('db' => 'sales_cancel', 'dt' => 30),
            // array('db' => 'sales', 'dt' => 31),
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'collection', 'dt' =>9 ),
            array('db' => 'due', 'dt' =>10 ),
            array('db' => 'refund', 'dt' =>11 ),
            array('db' => 'discount', 'dt' =>12 ),
            array('db' => 'ledger_amt_sales', 'dt' =>13 ),
            array('db' => 'au_entry_time', 'dt' =>14  ),
            array('db' => 'invoice_trn_list', 'dt' =>15 ),
            array('db' => 'sales_cancel', 'dt' =>16 ),
            array('db' => 'admission_no_pk', 'dt' => 17),

        );
        // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function ipdBillList(Request $request)
    {

        // $table = 'billing_list_vw';
        if (Session::get('user.ses_hospital_code') == "GMC")
            $table = 'finc_inv_v0_billing_list_vw';
        else
            $table = 'finc_ipd_inv_billing_list_vw';//'finc_inv_billing_list_vw';
        // Table's primary key

        $toDate = date('Y-m-d');
        $primaryKey = 'invoice_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk'); //and (not serviceunit_name='IPD')
        $where = "au_entry_hospital_pk_no =$hospital_id and trunc(invoice_date) =  '$toDate'";// and module_code in ('IPD')
        if (Session::get('user.ses_hospital_code') == "GMC") {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),

                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),

                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),

                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),

                array('db' => 'ledger_amt_deposite', 'dt' => 36),


            );
        } else {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),

                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),

                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),

                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),

            );
        }

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function posSearchBillList(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;
        $module_code = $request->module_code;
        $counter = $request->counter;

        $phr ="";// "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";

        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to . ' +1 day')) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";
        // dd($from_time, $to_time);
        // $sql_cond = "";
        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause invoice_date between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause round(due) > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($module_code != "") ? "$clause  module_code = '" . $module_code . "'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($counter != "") ? "$clause  counter_su_no_fk = '" . $counter . "'" : "";

        // dd( $sql_cond, $module_code);
        $table ='FINC_PHR_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),
            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),
            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'present_addr', 'dt' => 27),
            array('db' => 'au_entry_time', 'dt' => 28),
            array('db' => 'invoice_trn_list', 'dt' => 29),
            array('db' => 'sales_cancel', 'dt' => 30),
            array('db' => 'sales', 'dt' => 31),
            array('db' => 'prescription_no_fk', 'dt' => 32),

        );

        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }


    public function posBillingReport(Request $request) {

        if (!empty($request->date_from) && !empty($request->date_to)) {
            $pos_datas = DB::table('finc_phr_inv_billing_list_vw')
            ->select('invoice_no_pk', 'patient_no_pk', 'patient_name', 'sales',
            'invoice_date', 'discount', 'collection', 'full_name as doctor_name', 'au_entry_by')
            // ->leftJoin('wsec_user', 'finc_phr_inv_billing_list_vw.au_entry_by', '=', 'wsec_user.user_no_pk')
            ->where(DB::raw('trunc(invoice_date)'), '>=', date('Y-m-d', strtotime($request->date_from)))
            ->where(DB::raw('trunc(invoice_date)'), '<=', date('Y-m-d', strtotime($request->date_to)));
            if ($request->module_code !="") {
                $pos_datas->where('module_code',$request->module_code);
            }

            if ($request->counter !="") {
                $pos_datas->where('counter_su_no_fk',$request->counter);
            }
            $pos_data= $pos_datas->orderby('invoice_no_pk', 'desc')->get();
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		// $pdf = PDF::loadView("admin.billing.pharmacy.pos-details-report-pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "pos_data" => $pos_data])->setPaper('a4', 'potrait');
		return view("admin.billing.pharmacy.pos-details-report-pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "pos_data" => $pos_data, 'from_date' => $request->date_from, 'to_date' => $request->date_to]);
		return $pdf->stream('Pos-Details-Report.pdf');
    }



    public function cafeSearchBillList(Request $request,$type="")
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $phr ="module_code ='$type'";// "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";

        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to . ' +1 day')) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";
        // dd($from_time, $to_time);
        // $sql_cond = "";
        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause invoice_date between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause round(due) > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";

        // dd( $sql_cond);
        $table ='FINC_CAFE_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'collection', 'dt' =>9 ),
            array('db' => 'due', 'dt' =>10 ),
            array('db' => 'refund', 'dt' =>11 ),
            array('db' => 'discount', 'dt' =>12 ),
            array('db' => 'ledger_amt_sales', 'dt' =>13 ),
            array('db' => 'au_entry_time', 'dt' =>14  ),
            array('db' => 'invoice_trn_list', 'dt' =>15 ),
            array('db' => 'sales_cancel', 'dt' =>16 ),

        );

        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function cafeIpdSearchBillList(Request $request,$type="")
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $walking_phone = $request->walking_phone;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $phr ="module_code = '$type'";// "module_code in ('PHR','PHR-I', 'PHR-E','PHR-D','PHR-O')";

        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to . ' +1 day')) : "";
        $from_time = $request->from_time ? date('h:i A', strtotime($request->from_time)) : '';
        $to_time = $request->to_time ? date('h:i A', strtotime($request->to_time)) : "";
        // dd($from_time, $to_time);
        // $sql_cond = "";
        $sql_cond = $phr;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause invoice_date between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $from_time && $to_time != "" ? " $clause au_entry_time between '$from_time' and '$to_time' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $walking_phone != "" ? " $clause present_addr = '$walking_phone' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause round(due) > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";

        // dd( $sql_cond);
        $table ='FINC_CAFE_INV_BILLING_LIST_VW';// 'finc_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';

        $columns = array(
            // array('db' => 'invoice', 'dt' => 0),
            // array('db' => 'invoice_no_pk', 'dt' => 1),
            // array('db' => 'invoice_code', 'dt' => 2),
            // array('db' => 'invoice_date', 'dt' => 3),
            // array('db' => 'patient_code', 'dt' => 4),
            // array('db' => 'patient_name', 'dt' => 5),
            // array('db' => 'patient_gender', 'dt' => 6),
            // array('db' => 'mobile1', 'dt' => 7),
            // array('db' => 'patient_no_pk', 'dt' => 8),
            // array('db' => 'person_no_fk', 'dt' => 9),
            // array('db' => 'full_name', 'dt' => 10),
            // array('db' => 'doctor_gender', 'dt' => 11),
            // array('db' => 'specialization', 'dt' => 12),
            // array('db' => 'phone_mobile', 'dt' => 13),
            // // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // // array('db' => 'urgent_fee', 'dt' => 15),
            // // array('db' => 'total_bill', 'dt' => 16),
            // array('db' => 'collection', 'dt' => 14),
            // array('db' => 'due', 'dt' => 15),
            // array('db' => 'refund', 'dt' => 16),
            // array('db' => 'photo_name', 'dt' => 17),
            // array('db' => 'person_code', 'dt' => 18),
            // array('db' => 'degree1', 'dt' => 19),
            // array('db' => 'degree2', 'dt' => 20),
            // array('db' => 'degree3', 'dt' => 21),
            // array('db' => 'degree4', 'dt' => 22),
            // array('db' => 'au_entry_at', 'dt' => 23),
            // array('db' => 'au_update_at', 'dt' => 24),
            // array('db' => 'discount', 'dt' => 25),
            // array('db' => 'ledger_amt_sales', 'dt' => 26),
            // array('db' => 'present_addr', 'dt' => 27),
            // array('db' => 'au_entry_time', 'dt' => 28),
            // array('db' => 'invoice_trn_list', 'dt' => 29),
            // array('db' => 'sales_cancel', 'dt' => 30),
            // array('db' => 'sales', 'dt' => 31),
            // array('db' => 'admission_no_pk', 'dt' => 32),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'collection', 'dt' =>9 ),
            array('db' => 'due', 'dt' =>10 ),
            array('db' => 'refund', 'dt' =>11 ),
            array('db' => 'discount', 'dt' =>12 ),
            array('db' => 'ledger_amt_sales', 'dt' =>13 ),
            array('db' => 'au_entry_time', 'dt' =>14  ),
            array('db' => 'invoice_trn_list', 'dt' =>15 ),
            array('db' => 'sales_cancel', 'dt' =>16 ),
            array('db' => 'admission_no_pk', 'dt' => 17),


        );

        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchBillList(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_code = $request->hdn_doctor_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $sql_cond != "" ? "$clause module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')"  : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0"  : "";

        $table ='finc_opd_inv_billing_list_vw';// 'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';

        // $data=DB::select("select coun(invoice_no_pk) from finc_inv_billing_list_vw  $sql_cond");
        // dd($data);
        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),
            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),
            // array('db' => 'ledger_amt_discount', 'dt' => 25),
            // array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),
            array('db' => 'bill_type', 'dt' => 36),

        );
        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function searchEmergencyBillList(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause module_code in ('EMR')"  : "";

        $table = 'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),
            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),
            // array('db' => 'ledger_amt_discount', 'dt' => 25),
            // array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),

        );
        // dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function searchDayCareBillList(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause module_code in ('DYC')"  : "";

        $table = 'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),
            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),

            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),
            // array('db' => 'ledger_amt_discount', 'dt' => 25),
            // array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),

        );
        // dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchIPDBillList(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_code = $request->hdn_doctor_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk')  : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $sql_cond != "" ? "$clause" . $request->bill_type . " > 0" : "";


        $clause = ($sql_cond != "") ? " and" : " ";
        if ($request->bill_type != "") {
            if ($request->bill_type == "ipd_cnt") {
                $sql_cond .= ($request->bill_type) != "" ? "$clause nvl(LAB_CNT,0) = 0 and nvl(RAD_CNT,0) = 0 "  : "";
            } else {
                $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0"  : "";
            }
        }



        if (Session::get('user.ses_hospital_code') == "GMC")
            $table = 'finc_inv_v0_billing_list_vw';
        else
            $table = 'finc_ipd_inv_billing_list_vw';//'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';
        if (Session::get('user.ses_hospital_code') == "GMC") {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),
                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),
                // array('db' => 'ledger_amt_discount', 'dt' => 25),
                // array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),
                array('db' => 'ledger_amt_deposite', 'dt' => 36),

            );
        } else {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),
                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),
                // array('db' => 'ledger_amt_discount', 'dt' => 25),
                // array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),

            );
        }

        // dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    //emr search
    public function emrBillList(Request $request)
    {


            $table = 'finc_ipd_inv_billing_list_vw';//'finc_inv_billing_list_vw';
        // Table's primary key

        $toDate = date('Y-m-d');
        $primaryKey = 'invoice_no_pk';
        $hospital_id =  Session::get('user.ses_hospital_no_pk'); //and (not serviceunit_name='IPD')
        $where = "au_entry_hospital_pk_no =$hospital_id and trunc(invoice_date) =  '$toDate'";// and module_code in ('IPD')

            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),

                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),

                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),

                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),

            );


        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function searchEmrBillList(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_code = $request->hdn_doctor_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $all_paid != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk')  : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $sql_cond != "" ? "$clause" . $request->bill_type . " > 0" : "";


        $clause = ($sql_cond != "") ? " and" : " ";
        if ($request->bill_type != "") {
            if ($request->bill_type == "ipd_cnt") {
                $sql_cond .= ($request->bill_type) != "" ? "$clause nvl(LAB_CNT,0) = 0 and nvl(RAD_CNT,0) = 0 "  : "";
            } else {
                $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0"  : "";
            }
        }



        if (Session::get('user.ses_hospital_code') == "GMC")
            $table = 'finc_inv_v0_billing_list_vw';
        else
            $table = 'finc_ipd_inv_billing_list_vw';//'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';
        if (Session::get('user.ses_hospital_code') == "GMC") {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),
                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),
                // array('db' => 'ledger_amt_discount', 'dt' => 25),
                // array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),
                array('db' => 'ledger_amt_deposite', 'dt' => 36),

            );
        } else {
            $columns = array(
                array('db' => 'invoice', 'dt' => 0),
                array('db' => 'invoice_no_pk', 'dt' => 1),
                array('db' => 'invoice_code', 'dt' => 2),
                array('db' => 'invoice_date', 'dt' => 3),
                array('db' => 'patient_code', 'dt' => 4),
                array('db' => 'patient_name', 'dt' => 5),
                array('db' => 'patient_gender', 'dt' => 6),
                array('db' => 'mobile1', 'dt' => 7),
                array('db' => 'patient_no_pk', 'dt' => 8),
                array('db' => 'person_no_fk', 'dt' => 9),
                array('db' => 'full_name', 'dt' => 10),
                array('db' => 'doctor_gender', 'dt' => 11),
                array('db' => 'specialization', 'dt' => 12),
                array('db' => 'phone_mobile', 'dt' => 13),
                // array('db' => 'ledger_amt_payment', 'dt' => 14),
                // array('db' => 'urgent_fee', 'dt' => 15),
                // array('db' => 'total_bill', 'dt' => 16),
                array('db' => 'collection', 'dt' => 14),
                array('db' => 'due', 'dt' => 15),
                array('db' => 'refund', 'dt' => 16),

                array('db' => 'photo_name', 'dt' => 17),
                array('db' => 'person_code', 'dt' => 18),
                array('db' => 'degree1', 'dt' => 19),
                array('db' => 'degree2', 'dt' => 20),
                array('db' => 'degree3', 'dt' => 21),
                array('db' => 'degree4', 'dt' => 22),
                array('db' => 'au_entry_at', 'dt' => 23),
                array('db' => 'au_update_at', 'dt' => 24),
                // array('db' => 'ledger_amt_discount', 'dt' => 25),
                // array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'discount', 'dt' => 25),
                array('db' => 'ledger_amt_sales', 'dt' => 26),
                array('db' => 'appoint_service_no_fk', 'dt' => 27),
                array('db' => 'admission_no_pk', 'dt' => 28),
                array('db' => 'ccm_client_name', 'dt' => 29),
                array('db' => 'contact_no', 'dt' => 30),
                array('db' => 'contact_person', 'dt' => 31),
                array('db' => 'module_code', 'dt' => 32),
                array('db' => 'invoice_trn_list', 'dt' => 33),
                array('db' => 'sales_cancel', 'dt' => 34),
                array('db' => 'sales', 'dt' => 35),

            );
        }

        // dd($sql_cond);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCode("DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $pay_mode = ["CS" => "Cash"];

        return Template::loadView("admin.billing.opd_billing", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createServiceBilling($id = "")
    {
        $patientId = explode('-', $id);

        if ($id == '') {

            $patient_info = [];
            $item_info = [];
            $ref_info = [];
            $item_type = "";
            $page_type = "";
            $service_id = "";
        } elseif ($id != "" && $patientId[2] == 'physio') {
            // $patient_info=DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk',$patientId[1])->select('*')->first();
            // 'app.first_ref_name','app.first_ref_code','app.first_ref_phone_no','app.second_ref_code','app.second_ref_name','app.second_ref_phone_no','app.first_referral_no_fk','app.second_referral_no_fk'
            $ref_info = [];

            $page_type = $patientId[2];
            $service_id = $patientId[1];
            $item_type = "lab_rad";
            $patient_info = DB::table('patn_service_schedule b')
                ->leftjoin('patn_appointment_vw app', 'b.patient_no_fk', '=', 'app.patient_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->select('app.patient_code', 'app.patient_name', 'app.gender_txt', 'app.age', 'app.phone_mobile', 'app.patient_no_pk', 'app.admission_no_pk', 'b.schedule_no_pk as appoint_no_pk', 'b.selected_service_no', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_code', 'corp.ccm_client_name', 'corp.contact_no', 'corp.contact_person', 'corp.contact_mobile', 'ptv.patient_type_no_pk')
                ->where("schedule_no_pk", $patientId[1])
                ->where('b.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->first();

            if (!empty($patient_info)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                $service_item_ids = explode(",", $patient_info->selected_service_no);
                $item_info_data = DB::table("SYSC_SERVICEITEM_VW")->select("item_no_pk as item_no_fk", "item_name", "serviceunit_name as su_name", "sales_price", "item_type", "vat_percent", "disc_aplicable", "default_discount", DB::raw("SUM(sales_price) as total_price"))->whereIn("item_no_pk", $service_item_ids)->groupBy('item_no_pk', 'item_name', 'serviceunit_name', 'sales_price', 'item_type', 'vat_percent', 'disc_aplicable', 'default_discount')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
                // dd($item_info_data);

                $item_info_arr = [];
                $item_details_arr = [];
                if (!empty($item_info_data)) {
                    foreach ($item_info_data as $item_row) {
                        $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                        $discount = $item_row->default_discount != "" ? $item_row->default_discount : 0;
                        $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                        $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                        $item_info_arr[$item_row->item_no_fk] = [
                            'item_no_fk' => $item_row->item_no_fk,
                            'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                            'su_name' => $item_row->su_name,
                            'sales_price' => $rate[0]->item_rate ?? $item_row->sales_price,
                            'item_type' => $item_row->item_type,
                            'vat_percent' => $item_row->vat_percent,
                            'total_price' => $item_row->total_price,
                            "discount_cal" => $item_row->disc_aplicable != null ?  $item_row->disc_aplicable : 0,
                            "default_discount_amt" => $def_dis[0]->def_discount ?? $item_row->default_discount,
                        ];
                        $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->select("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount", DB::raw("SUM(sales_price) as total_price"))->where('item_no_fk', $item_row->item_no_fk)->groupBy("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount")->get();
                        if (!empty($details_items)) {
                            foreach ($details_items as $details_item_auto) {
                                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                                    "item_no_fk" => $details_item_auto->auto_item_no_fk,
                                    "item_name" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                                    "su_name" => $details_item_auto->serviceunit_name,
                                    "sales_price" =>  $details_item_auto->sales_price,
                                    "item_type" =>  $details_item_auto->item_type,
                                    "vat_percent" =>  $details_item_auto->vat_percent != null ? $details_item_auto->vat_percent : 0,
                                    'total_price' => $details_item_auto->total_price,
                                    "discount_cal" => $details_item_auto->discount_applicable_ind != null ? $details_item_auto->discount_applicable_ind : 0,
                                    "default_discount_amt" => $def_dis[0]->def_discount ?? $details_item_auto->default_discount,
                                ];
                            }
                        }
                    }
                }
                $item_info =   array_merge($item_info_arr, $item_details_arr);
                // dd($item_info);
            }
        } elseif ($id != "" && $patientId[2] == 'app') {
            $page_type = $patientId[2];
            $service_id = '';
            $ref_info = [];
            $item_type = "fee";
            $patient_info = DB::table('patn_appointment_vw app')
                // ->select('app.*', 'pt.patient_type_code', 'ptv.applied_consult_percent as maximum_percent', 'ptv.patient_type_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->where('app.appoint_no_pk', $patientId[1])
                ->first();
            // dd($patientId[1],$patient_info);
            $item_info_data = DB::table('patn_appointment_vw a')
                ->leftJoin('doctor_wise_consult_fee_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                ->where('a.appoint_no_pk', $patientId[1])
                ->where('b.doc_id', $patient_info->doctor_no_fk)
                ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable')
                ->get();
            // dd($item_info_data);


            $ConsultancyCoveragePercentages =0;
            $apiDiscount_ind=0;
            if (Session::get('user.ses_hospital_code') == "DMHL") {
                $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$patientId[0])->first();

                $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502'; // Assuming 'input_value' comes from your form
                $typeCode ='01' ; // Assuming it's an array and you need the first element

                if ($input_value !="") {
                    // dd($patientId[1], $input_value);
                $requestData = [
                    'ByUserId' => '8415',
                    'PersonId' => '121529',
                    'MobileNumber' => '-',
                    'UserName' => 'info@divinemercyhospital.com',
                    'SearchText' => $input_value, // Replace with your actual input value
                    'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                    'DiscountTypeCode'=>'01',
                    'RequestFrom' => 'HIS'
                ];

                // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';

                $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
                // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
                $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

                // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
                // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

                $client = new Client();

                $response = $client->request('POST', $apiUrl, [
                    'headers' => [
                        'token' => $token,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $requestData,
                ]);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();
                //    dd($body);
                $data = json_decode($body, true);
                if (isset($data['Data'])) {
                    $dataInside = json_decode($data['Data'], true);
                    if (isset($dataInside[0]['ConsultancyCoveragePercentages'])) {
                        $ConsultancyCoveragePercentages = $dataInside[0]['ConsultancyCoveragePercentages'];

                    }
                }
            }

        }

            $item_info = [];
            $item_info_arr = [];

            if (!empty($item_info_data)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_code != "" ? $patient_info->patient_type_code : 0;
                foreach ($item_info_data as $item_row) {
                    $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                    $discount = 0;
                    $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));

                    if ($ConsultancyCoveragePercentages > 0) {
                        $discount_perc=$ConsultancyCoveragePercentages;
                        $apiDiscount_ind=1;
                    }else{
                        $discount_perc=$def_dis[0]->def_discount && $item_row->disc_aplicable !=1 ?$def_dis[0]->def_discount : 0;
                    }
                    // dd($apiDiscount_ind, $ConsultancyCoveragePercentages);
                    // dd($patient_type);
                    $item_info_arr[$item_row->item_no_fk] = [
                        'item_no_fk' => $item_row->item_no_fk,
                        'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                        'su_name' => $item_row->su_name,
                        'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                        'item_type' => $item_row->item_type,
                        'vat_percent' => 0,
                        'total_price' => $item_row->total_price,
                        "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                        "default_discount_amt" => $discount_perc,
                        "apiDiscount_ind" => $apiDiscount_ind,
                        "discounttypecode" => 01,

                    ];
                }
            }
            $item_info =   array_merge($item_info_arr);
        } elseif ($id != "" && $patientId[2] == 'ipd') {
            $page_type =  $patientId[2];
            $service_id = '';
            $item_type = "";
            $patient_info = DB::table('ipd_admitted_patlist_vw a')
                // ->select('b.*','ptv.*','pt.*','corp.*','a.*','a.primary_doctor_no_fk as doctor_no_fk'
                //     // 'b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk'
                //     )
                ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
                ->where('a.admission_no_pk', $patientId[1])
                ->first();
            // dd( $patient_info);
            $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
            // dd($ref_info);
            $item_info = [];
            // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
            // dd($item_info);

        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $reg_type = $this->getLookupListByCode("REGTYPE");

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        //$service_point = ServiceUnit::where('cash_counter_ind', '1')->where("status","1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $mBanking = $this->getLookupListByCode("MBANKING");
        // dd( $bank_name);
        $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type_list=[];
        if (!empty($item_type)) {
            foreach ($item_type as $key => $value) {
                $item_type_list[]=$value->workflow_code;
            }
        }
         $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

        $pay_mode = ["CS" => "Cash"];

        $check = request('su');

        return Template::loadView("admin.billing.service_billing", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,
            'reg_type' => $reg_type,
            'service_unit' => $service_unit,
            'service_point' => $service_point,
            'patientId' => $patient_info,
            'check' => $check,
            'item_info' => $item_info,
            'item_type' => $item_type,
            'page_type' => $page_type,
            'service_id' => $service_id,
            'bank_name' => $bank_name,
            'mBanking' => $mBanking,
            'ref_info' => $ref_info,
            'po_hospital_details' => $po_hospital_details,
            'item_type_lists' => $item_type_lists,

        ]);
    }
    public function createServiceBillingV3($id = "")
    {

        $patientId = explode('-', $id);

        if ($id == '') {

            $patient_info = [];
            $item_info = [];
            $ref_info = [];
            $item_type = "";
            $page_type = "";
            $service_id = "";
        } elseif ($id != "" && $patientId[2] == 'physio') {
            // $patient_info=DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk',$patientId[1])->select('*')->first();
            // 'app.first_ref_name','app.first_ref_code','app.first_ref_phone_no','app.second_ref_code','app.second_ref_name','app.second_ref_phone_no','app.first_referral_no_fk','app.second_referral_no_fk'
            $ref_info = [];

            $page_type = $patientId[2];
            $service_id = $patientId[1];
            $item_type = "lab_rad";
            $patient_info = DB::table('patn_service_schedule b')
                ->leftjoin('patn_appointment_vw app', 'b.patient_no_fk', '=', 'app.patient_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->select('app.patient_code', 'app.patient_name', 'app.gender_txt', 'app.age', 'app.phone_mobile', 'app.patient_no_pk', 'app.admission_no_pk', 'b.schedule_no_pk as appoint_no_pk', 'b.selected_service_no', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_code', 'corp.ccm_client_name', 'corp.contact_no', 'corp.contact_person', 'corp.contact_mobile', 'ptv.patient_type_no_pk')
                ->where("schedule_no_pk", $patientId[1])
                ->where('b.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->first();

            if (!empty($patient_info)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                $service_item_ids = explode(",", $patient_info->selected_service_no);
                $item_info_data = DB::table("SYSC_SERVICEITEM_VW")->select("item_no_pk as item_no_fk", "item_name", "serviceunit_name as su_name", "sales_price", "item_type", "vat_percent", "disc_aplicable", "default_discount", DB::raw("SUM(sales_price) as total_price"))->whereIn("item_no_pk", $service_item_ids)->groupBy('item_no_pk', 'item_name', 'serviceunit_name', 'sales_price', 'item_type', 'vat_percent', 'disc_aplicable', 'default_discount')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
                // dd($item_info_data);

                $item_info_arr = [];
                $item_details_arr = [];
                if (!empty($item_info_data)) {
                    foreach ($item_info_data as $item_row) {
                        $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                        $discount = $item_row->default_discount != "" ? $item_row->default_discount : 0;
                        $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                        $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                        $item_info_arr[$item_row->item_no_fk] = [
                            'item_no_fk' => $item_row->item_no_fk,
                            'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                            'su_name' => $item_row->su_name,
                            'sales_price' => $rate[0]->item_rate ?? $item_row->sales_price,
                            'item_type' => $item_row->item_type,
                            'vat_percent' => $item_row->vat_percent,
                            'total_price' => $item_row->total_price,
                            "discount_cal" => $item_row->disc_aplicable != null ?  $item_row->disc_aplicable : 0,
                            "default_discount_amt" => $def_dis[0]->def_discount ?? $item_row->default_discount,
                        ];
                        $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->select("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount", DB::raw("SUM(sales_price) as total_price"))->where('item_no_fk', $item_row->item_no_fk)->groupBy("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount")->get();
                        if (!empty($details_items)) {
                            foreach ($details_items as $details_item_auto) {
                                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                                    "item_no_fk" => $details_item_auto->auto_item_no_fk,
                                    "item_name" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                                    "su_name" => $details_item_auto->serviceunit_name,
                                    "sales_price" =>  $details_item_auto->sales_price,
                                    "item_type" =>  $details_item_auto->item_type,
                                    "vat_percent" =>  $details_item_auto->vat_percent != null ? $details_item_auto->vat_percent : 0,
                                    'total_price' => $details_item_auto->total_price,
                                    "discount_cal" => $details_item_auto->discount_applicable_ind != null ? $details_item_auto->discount_applicable_ind : 0,
                                    "default_discount_amt" => $def_dis[0]->def_discount ?? $details_item_auto->default_discount,
                                ];
                            }
                        }
                    }
                }
                $item_info =   array_merge($item_info_arr, $item_details_arr);
                // dd($item_info);
            }
        } elseif ($id != "" && $patientId[2] == 'app') {

            $page_type = $patientId[2];
            $service_id = '';
            $ref_info = [];
            $item_type = "fee";
            $patient_info = DB::table('patn_appointment_vw app')
                // ->select('app.*', 'pt.patient_type_code', 'ptv.applied_consult_percent as maximum_percent', 'ptv.patient_type_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->where('app.appoint_no_pk', $patientId[1])
                ->first();
            // dd($patientId[1],$patient_info);
            $item_info_data = DB::table('patn_appointment_vw a')
                ->leftJoin('doctor_wise_consult_fee_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                ->where('a.appoint_no_pk', $patientId[1])
                ->where('b.doc_id', $patient_info->doctor_no_fk)
                ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable')
                ->get();
            // dd($item_info_data);


            $ConsultancyCoveragePercentages =0;
            $apiDiscount_ind=0;
            if (Session::get('user.ses_hospital_code') == "DMHL") {
                $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$patientId[0])->first();

                $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502'; // Assuming 'input_value' comes from your form
                $typeCode ='01' ; // Assuming it's an array and you need the first element

                if ($input_value !="") {
                    // dd($patientId[1], $input_value);
                $requestData = [
                    'ByUserId' => '8415',
                    'PersonId' => '121529',
                    'MobileNumber' => '-',
                    'UserName' => 'info@divinemercyhospital.com',
                    'SearchText' => $input_value, // Replace with your actual input value
                    'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                    'DiscountTypeCode'=>'01',
                    'RequestFrom' => 'HIS'
                ];

                // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';

                $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
                // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
                $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

                // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
                // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

                $client = new Client();

                $response = $client->request('POST', $apiUrl, [
                    'headers' => [
                        'token' => $token,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $requestData,
                ]);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();
                //    dd($body);
                $data = json_decode($body, true);
                if (isset($data['Data'])) {
                    $dataInside = json_decode($data['Data'], true);
                    if (isset($dataInside[0]['ConsultancyCoveragePercentages'])) {
                        $ConsultancyCoveragePercentages = $dataInside[0]['ConsultancyCoveragePercentages'];

                    }
                }
            }

        }

            $item_info = [];
            $item_info_arr = [];

            if (!empty($item_info_data)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_code != "" ? $patient_info->patient_type_code : 0;
                foreach ($item_info_data as $item_row) {
                    $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                    $discount = 0;
                    $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));

                    if ($ConsultancyCoveragePercentages > 0) {
                        $discount_perc=$ConsultancyCoveragePercentages;
                        $apiDiscount_ind=1;
                    }else{

                        $discount_perc=$def_dis[0]->def_discount && $item_row->disc_aplicable !=1 ?$def_dis[0]->def_discount : 0;
                    }
                    // dd($apiDiscount_ind, $ConsultancyCoveragePercentages);
                    // dd($patient_type);
                    $item_info_arr[$item_row->item_no_fk] = [
                        'item_no_fk' => $item_row->item_no_fk,
                        'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                        'su_name' => $item_row->su_name,
                        'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                        'item_type' => $item_row->item_type,
                        'vat_percent' => 0,
                        'total_price' => $item_row->total_price,
                        "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                        "default_discount_amt" => $discount_perc,
                        "apiDiscount_ind" => $apiDiscount_ind,
                        "discounttypecode" => 01,

                    ];
                }
            }
            $item_info =   array_merge($item_info_arr);
        } elseif ($id != "" && $patientId[2] == 'ipd') {
            $page_type =  $patientId[2];
            $service_id = '';
            $item_type = "";
            $patient_info = DB::table('ipd_admitted_patlist_vw a')
                // ->select('b.*','ptv.*','pt.*','corp.*','a.*','a.primary_doctor_no_fk as doctor_no_fk'
                //     // 'b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk'
                //     )
                ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
                ->where('a.admission_no_pk', $patientId[1])
                ->first();
            // dd( $patient_info);
            $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
            // dd($ref_info);
            $item_info = [];
            // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
            // dd($item_info);

        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $reg_type = $this->getLookupListByCode("REGTYPE");

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        //$service_point = ServiceUnit::where('cash_counter_ind', '1')->where("status","1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type_list=[];
        if (!empty($item_type)) {
            foreach ($item_type as $key => $value) {
                $item_type_list[]=$value->workflow_code;
            }
        }
         $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

        $pay_mode = ["CS" => "Cash"];

        $check = request('su');

        return Template::loadView("admin.billing.service_billing_v3", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,
            'reg_type' => $reg_type,
            'service_unit' => $service_unit,
            'service_point' => $service_point,
            'patientId' => $patient_info,
            'check' => $check,
            'item_info' => $item_info,
            'item_type' => $item_type,
            'page_type' => $page_type,
            'service_id' => $service_id,
            'bank_name' => $bank_name,
            'ref_info' => $ref_info,
            'po_hospital_details' => $po_hospital_details,
            'item_type_lists' => $item_type_lists,

        ]);
    }
    public function emergencyBilling($id = "")
    {

        $patientId = explode('-', $id);

        if ($id == '') {

            $patient_info = [];
            $item_info = [];
            $ref_info = [];
            $item_type = "";
            $page_type = "";
            $service_id = "";
        } elseif ($id != "" && $patientId[2] == 'physio') {
            // $patient_info=DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk',$patientId[1])->select('*')->first();
            // 'app.first_ref_name','app.first_ref_code','app.first_ref_phone_no','app.second_ref_code','app.second_ref_name','app.second_ref_phone_no','app.first_referral_no_fk','app.second_referral_no_fk'
            $ref_info = [];

            $page_type = $patientId[2];
            $service_id = $patientId[1];
            $item_type = "lab_rad";
            $patient_info = DB::table('patn_service_schedule b')
                ->leftjoin('patn_appointment_vw app', 'b.patient_no_fk', '=', 'app.patient_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->select('app.patient_code', 'app.patient_name', 'app.gender_txt', 'app.age', 'app.phone_mobile', 'app.patient_no_pk', 'app.admission_no_pk', 'b.schedule_no_pk as appoint_no_pk', 'b.selected_service_no', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_code', 'corp.ccm_client_name', 'corp.contact_no', 'corp.contact_person', 'corp.contact_mobile', 'ptv.patient_type_no_pk')
                ->where("schedule_no_pk", $patientId[1])
                ->where('b.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->first();

            if (!empty($patient_info)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                $service_item_ids = explode(",", $patient_info->selected_service_no);
                $item_info_data = DB::table("SYSC_SERVICEITEM_VW")->select("item_no_pk as item_no_fk", "item_name", "serviceunit_name as su_name", "sales_price", "item_type", "vat_percent", "disc_aplicable", "default_discount", DB::raw("SUM(sales_price) as total_price"))->whereIn("item_no_pk", $service_item_ids)->groupBy('item_no_pk', 'item_name', 'serviceunit_name', 'sales_price', 'item_type', 'vat_percent', 'disc_aplicable', 'default_discount')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
                // dd($item_info_data);

                $item_info_arr = [];
                $item_details_arr = [];
                if (!empty($item_info_data)) {
                    foreach ($item_info_data as $item_row) {
                        $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                        $discount = $item_row->default_discount != "" ? $item_row->default_discount : 0;
                        $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                        $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                        $item_info_arr[$item_row->item_no_fk] = [
                            'item_no_fk' => $item_row->item_no_fk,
                            'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                            'su_name' => $item_row->su_name,
                            'sales_price' => $rate[0]->item_rate ?? $item_row->sales_price,
                            'item_type' => $item_row->item_type,
                            'vat_percent' => $item_row->vat_percent,
                            'total_price' => $item_row->total_price,
                            "discount_cal" => $item_row->disc_aplicable != null ?  $item_row->disc_aplicable : 0,
                            "default_discount_amt" => $def_dis[0]->def_discount ?? $item_row->default_discount,
                        ];
                        $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->select("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount", DB::raw("SUM(sales_price) as total_price"))->where('item_no_fk', $item_row->item_no_fk)->groupBy("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount")->get();
                        if (!empty($details_items)) {
                            foreach ($details_items as $details_item_auto) {
                                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                                    "item_no_fk" => $details_item_auto->auto_item_no_fk,
                                    "item_name" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                                    "su_name" => $details_item_auto->serviceunit_name,
                                    "sales_price" =>  $details_item_auto->sales_price,
                                    "item_type" =>  $details_item_auto->item_type,
                                    "vat_percent" =>  $details_item_auto->vat_percent != null ? $details_item_auto->vat_percent : 0,
                                    'total_price' => $details_item_auto->total_price,
                                    "discount_cal" => $details_item_auto->discount_applicable_ind != null ? $details_item_auto->discount_applicable_ind : 0,
                                    "default_discount_amt" => $def_dis[0]->def_discount ?? $details_item_auto->default_discount,
                                ];
                            }
                        }
                    }
                }
                $item_info =   array_merge($item_info_arr, $item_details_arr);
                // dd($item_info);
            }
        } elseif ($id != "" && $patientId[2] == 'app') {
            $page_type = $patientId[2];
            $service_id = '';
            $ref_info = [];
            $item_type = "fee";
            $patient_info = DB::table('patn_appointment_vw app')
                // ->select('app.*', 'pt.patient_type_code', 'ptv.applied_consult_percent as maximum_percent', 'ptv.patient_type_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->where('app.appoint_no_pk', $patientId[1])
                ->first();
            // dd($patient_info);
            $item_info_data = DB::table('patn_appointment_vw a')
                ->leftJoin('doctor_wise_consult_fee_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                ->where('a.appoint_no_pk', $patientId[1])
                ->where('b.doc_id', $patient_info->doctor_no_fk)
                ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable')
                ->get();
            // dd($item_info_data);
            $item_info = [];
            $item_info_arr = [];
            if (!empty($item_info_data)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                foreach ($item_info_data as $item_row) {
                    $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                    $discount = 0;
                    $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                    $item_info_arr[$item_row->item_no_fk] = [
                        'item_no_fk' => $item_row->item_no_fk,
                        'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                        'su_name' => $item_row->su_name,
                        'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                        'item_type' => $item_row->item_type,
                        'vat_percent' => 0,
                        'total_price' => $item_row->total_price,
                        "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                        "default_discount_amt" => $def_dis[0]->def_discount ?? 0,

                    ];
                }
            }
            $item_info =   array_merge($item_info_arr);
        } elseif ($id != "" && $patientId[2] == 'ipd') {
            $page_type = ''; // $patientId[2];
            $service_id = '';
            $item_type = "";
            $patient_info = DB::table('ipd_admitted_patlist_vw a')
                // ->select('b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk')
                ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
                ->where('a.admission_no_pk', $patientId[1])
                ->first();
            // dd( $patient_info);
            $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
            // dd($ref_info);
            $item_info = [];
            // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
            // dd($item_info);

        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $reg_type = $this->getLookupListByCode("REGTYPE");

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        // $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $pay_mode = ["CS" => "Cash"];

        $check = request('su');

        return Template::loadView("admin.billing.emergency_billing", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,
            'reg_type' => $reg_type,
            'service_unit' => $service_unit,
            'service_point' => $service_point,
            'patientId' => $patient_info,
            'check' => $check,
            'item_info' => $item_info,
            'item_type' => $item_type,
            'page_type' => $page_type,
            'service_id' => $service_id,
            'bank_name' => $bank_name,
            'ref_info' => $ref_info,
            'po_hospital_details' => $po_hospital_details,

        ]);
    }
    public function dayCareBilling($id = "")
    {

        $patientId = explode('-', $id);

        if ($id == '') {

            $patient_info = [];
            $item_info = [];
            $ref_info = [];
            $item_type = "";
            $page_type = "";
            $service_id = "";
        } elseif ($id != "" && $patientId[2] == 'physio') {
            // $patient_info=DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk',$patientId[1])->select('*')->first();
            // 'app.first_ref_name','app.first_ref_code','app.first_ref_phone_no','app.second_ref_code','app.second_ref_name','app.second_ref_phone_no','app.first_referral_no_fk','app.second_referral_no_fk'
            $ref_info = [];

            $page_type = $patientId[2];
            $service_id = $patientId[1];
            $item_type = "lab_rad";
            $patient_info = DB::table('patn_service_schedule b')
                ->leftjoin('patn_appointment_vw app', 'b.patient_no_fk', '=', 'app.patient_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->select('app.patient_code', 'app.patient_name', 'app.gender_txt', 'app.age', 'app.phone_mobile', 'app.patient_no_pk', 'app.admission_no_pk', 'b.schedule_no_pk as appoint_no_pk', 'b.selected_service_no', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'corp.ccm_client_no_pk', 'corp.ccm_client_code', 'corp.ccm_client_name', 'corp.contact_no', 'corp.contact_person', 'corp.contact_mobile', 'ptv.patient_type_no_pk')
                ->where("schedule_no_pk", $patientId[1])
                ->where('b.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->first();

            if (!empty($patient_info)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                $service_item_ids = explode(",", $patient_info->selected_service_no);
                $item_info_data = DB::table("SYSC_SERVICEITEM_VW")->select("item_no_pk as item_no_fk", "item_name", "serviceunit_name as su_name", "sales_price", "item_type", "vat_percent", "disc_aplicable", "default_discount", DB::raw("SUM(sales_price) as total_price"))->whereIn("item_no_pk", $service_item_ids)->groupBy('item_no_pk', 'item_name', 'serviceunit_name', 'sales_price', 'item_type', 'vat_percent', 'disc_aplicable', 'default_discount')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
                // dd($item_info_data);

                $item_info_arr = [];
                $item_details_arr = [];
                if (!empty($item_info_data)) {
                    foreach ($item_info_data as $item_row) {
                        $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                        $discount = $item_row->default_discount != "" ? $item_row->default_discount : 0;
                        $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                        $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                        $item_info_arr[$item_row->item_no_fk] = [
                            'item_no_fk' => $item_row->item_no_fk,
                            'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                            'su_name' => $item_row->su_name,
                            'sales_price' => $rate[0]->item_rate ?? $item_row->sales_price,
                            'item_type' => $item_row->item_type,
                            'vat_percent' => $item_row->vat_percent,
                            'total_price' => $item_row->total_price,
                            "discount_cal" => $item_row->disc_aplicable != null ?  $item_row->disc_aplicable : 0,
                            "default_discount_amt" => $def_dis[0]->def_discount ?? $item_row->default_discount,
                        ];
                        $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->select("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount", DB::raw("SUM(sales_price) as total_price"))->where('item_no_fk', $item_row->item_no_fk)->groupBy("auto_item_no_fk", "item_name", "serviceunit_name", "sales_price", "item_type", "vat_percent", "default_discount")->get();
                        if (!empty($details_items)) {
                            foreach ($details_items as $details_item_auto) {
                                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                                    "item_no_fk" => $details_item_auto->auto_item_no_fk,
                                    "item_name" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                                    "su_name" => $details_item_auto->serviceunit_name,
                                    "sales_price" =>  $details_item_auto->sales_price,
                                    "item_type" =>  $details_item_auto->item_type,
                                    "vat_percent" =>  $details_item_auto->vat_percent != null ? $details_item_auto->vat_percent : 0,
                                    'total_price' => $details_item_auto->total_price,
                                    "discount_cal" => $details_item_auto->discount_applicable_ind != null ? $details_item_auto->discount_applicable_ind : 0,
                                    "default_discount_amt" => $def_dis[0]->def_discount ?? $details_item_auto->default_discount,
                                ];
                            }
                        }
                    }
                }
                $item_info =   array_merge($item_info_arr, $item_details_arr);
                // dd($item_info);
            }
        } elseif ($id != "" && $patientId[2] == 'app') {
            $page_type = $patientId[2];
            $service_id = '';
            $ref_info = [];
            $item_type = "fee";
            $patient_info = DB::table('patn_appointment_vw app')
                // ->select('app.*', 'pt.patient_type_code', 'ptv.applied_consult_percent as maximum_percent', 'ptv.patient_type_no_pk')
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'app.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'app.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'app.ccm_client_no_pk')
                ->where('app.appoint_no_pk', $patientId[1])
                ->first();
            // dd($patient_info);
            $item_info_data = DB::table('patn_appointment_vw a')
                ->leftJoin('doctor_wise_consult_fee_vw b', 'b.visit_type_lookup_no_fk', '=', 'a.appoint_type')
                ->where('a.appoint_no_pk', $patientId[1])
                ->where('b.doc_id', $patient_info->doctor_no_fk)
                ->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable', DB::raw("SUM(b.sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', 'b.disc_aplicable')
                ->get();
            // dd($item_info_data);
            $item_info = [];
            $item_info_arr = [];
            if (!empty($item_info_data)) {
                $corporate_id = $patient_info->ccm_client_no_pk != "" ? $patient_info->ccm_client_no_pk : 0;
                $patient_type = $patient_info->patient_type_no_pk != "" ? $patient_info->patient_type_no_pk : 0;
                foreach ($item_info_data as $item_row) {
                    $sales_price = $item_row->sales_price != "" ? $item_row->sales_price : 0;
                    $discount = 0;
                    $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($item_row->item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($item_row->item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                    $item_info_arr[$item_row->item_no_fk] = [
                        'item_no_fk' => $item_row->item_no_fk,
                        'item_name' => htmlspecialchars($item_row->item_name, ENT_QUOTES),
                        'su_name' => $item_row->su_name,
                        'sales_price' =>  $rate[0]->item_rate ?? $item_row->sales_price,
                        'item_type' => $item_row->item_type,
                        'vat_percent' => 0,
                        'total_price' => $item_row->total_price,
                        "discount_cal" => $item_row->disc_aplicable != null ? $item_row->disc_aplicable : 0,
                        "default_discount_amt" => $def_dis[0]->def_discount ?? 0,

                    ];
                }
            }
            $item_info =   array_merge($item_info_arr);
        } elseif ($id != "" && $patientId[2] == 'ipd') {
            $page_type = ''; // $patientId[2];
            $service_id = '';
            $item_type = "";
            $patient_info = DB::table('ipd_admitted_patlist_vw a')
                // ->select('b.patient_code', 'b.patient_name', 'b.gender_txt', 'b.age', 'a.admission_no_pk', 'a.mobile1 as phone_mobile', 'pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'b.patient_no_pk','corp.ccm_client_code', 'corp.ccm_client_name','corp.contact_no', 'corp.contact_person', 'corp.ccm_client_no_pk','ptv.patient_type_no_pk')
                ->leftjoin("pat_registration_wl_vw b", "b.patient_no_pk", "=", "a.patient_no_fk")
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'b.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'b.patient_type')
                ->leftJoin('ccm_corporateclient_vw corp', 'corp.ccm_client_no_pk', '=', 'b.ccm_client_no_fk')
                ->where('a.admission_no_pk', $patientId[1])
                ->first();
            // dd( $patient_info);
            $ref_info = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $patientId[1])->first();
            // dd($ref_info);
            $item_info = [];
            // DB::table('PATN_APPOINTMENT_VW a')->where('a.APPOINT_NO_PK', $patientId[1])->where('b.DOC_ID', $patient_info->doctor_no_fk)->leftJoin('DOCTOR_WISE_CONSULT_FEE_VW b', 'b.VISIT_TYPE_LOOKUP_NO_FK', '=', 'a.APPOINT_TYPE')->select('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type', DB::raw("SUM(sales_price) as total_price"))->groupBy('b.ITEM_NO_FK', 'b.ITEM_NAME', 'b.SALES_PRICE', 'a.su_name', 'b.item_type')->get();
            // dd($item_info);

        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $reg_type = $this->getLookupListByCode("REGTYPE");

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        // $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $pay_mode = ["CS" => "Cash"];

        $check = request('su');

        return Template::loadView("admin.billing.day_care_billing", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,
            'reg_type' => $reg_type,
            'service_unit' => $service_unit,
            'service_point' => $service_point,
            'patientId' => $patient_info,
            'check' => $check,
            'item_info' => $item_info,
            'item_type' => $item_type,
            'page_type' => $page_type,
            'service_id' => $service_id,
            'bank_name' => $bank_name,
            'ref_info' => $ref_info,
            'po_hospital_details' => $po_hospital_details,

        ]);
    }

    public function billingInvoice()
    {
        return Template::loadview("admin.billing.invoice");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function billingInvoicePrint()
    {
        return Template::loadview("admin.billing.billing_invoice_print");
    }

    public function bill_invoice_print_A4($invoice_id, $page = "")
    {


        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk")
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $pdf = PDF::loadView("admin.billing.billing_invoice_print_a4", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc])->setPaper('a4', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_print_A5($invoice_id, $page = "", $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_code')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->select('pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','invoice_no_pk','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
         $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_dtl) as service_charge_dtl'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        $pdf = App::make('dompdf.wrapper');
        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details])->setPaper('a5', 'portrait');
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_print_A5_v1($invoice_id, $page = "", $trx = "")
    {
        // dd($trx);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('finc_inv_patientdetail_vw.*','patient_info_vw.ccm_client_name')
            ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','finc_inv_patientdetail_vw.patient_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
                WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
                WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no", "ledgerdtl_amt_sales")
            // ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind","item_type")
            // ->orderByRaw("DECODE(item_type , 'LAB','RAD') asc")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        // dd( $invoice_dtls_info);
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_dtl) as service_charge_dtl'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        // return view("admin.billing.billing_invoice_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'finc_inv_sum_amount'=>$finc_inv_sum_amount,'finc_inv_collection_amount' =>$finc_inv_collection_amount]);

        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_v1", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details])->setPaper('a5', 'portrait');
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_print_A5_pkg($invoice_id, $page = "", $trx = "")
    {
        // dd($trx);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
                WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
                WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk","item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no", "ledgerdtl_amt_sales")
            // ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind","item_type")
            // ->orderByRaw("DECODE(item_type , 'LAB','RAD') asc")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        // dd( $invoice_dtls_info);
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_dtl) as service_charge_dtl'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        // return view("admin.billing.billing_invoice_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'finc_inv_sum_amount'=>$finc_inv_sum_amount,'finc_inv_collection_amount' =>$finc_inv_collection_amount]);

        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_pgk_v1", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details])->setPaper('a5', 'portrait');
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }


    public function bill_invoice_app_print($invoice_id, $page = "", $trx = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','appoint_service_no_fk','au_entry_by','doc_serviceunit_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();
        $app_id = $invoice_mst_info->appoint_service_no_fk != "" ? $invoice_mst_info->appoint_service_no_fk : '';
        $appoint_type = '';
        if ($app_id != "") {
            $appoint_type = DB::table('patn_appointment_vw')->select('appoint_typename')->where('appoint_no_pk', $app_id)->first()->appoint_typename;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledger_no_fk", $l_date)
            ->get();
        $ledger_no = DB::select("SELECT paymood,pay_mood_type, pay_amount FROM FINC_LEDGER_PAYMOOD WHERE  invoice_no_fk = $invoice_id and ledger_no_fk = $l_date");
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();
        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee')->first();
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');
        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();
        if ($po_hospital_details->hospital_code != 'KBMH')
            $pdf = PDF::loadView("admin.billing.billing_invoice_app_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'appoint_type' => $appoint_type, 'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_app_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'appoint_type' => $appoint_type, 'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_app_print_v2($invoice_id, $page = "", $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw as fipv")
        ->select(
    'fipv.invoice_code',
            'fipv.patient_code',
            'fipv.patient_name',
            'fipv.dob',
            'fipv.gender_txt',
            'fipv.mobile1',
            'fipv.present_addr',
            'fipv.doctor_name',
            'fipv.first_doc_name',
            'fipv.person_code',
            'fipv.second_doc_name',
            'fipv.report_delivary_date',
            'fipv.invoice_date',
            'fipv.report_delivary_datetime',
            'fipv.admission_no_pk',
            'fipv.au_entry_at',
            'fipv.patient_type_code',
            'fipv.age',
            'fipv.invoice_remarks',
            'fipv.invoice_no_pk',
            'fipv.appoint_service_no_fk',
            'fipv.au_entry_by',
            'fipv.doc_serviceunit_name',
            'fipv.degree',
            'patient_info_vw.ccm_client_name'
        )
        ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','fipv.patient_no_pk')
            ->where("fipv.invoice_no_pk", $invoice_id)
            ->orderBy("fipv.ledger_datetime", "DESC")
            ->first();
        $app_id = $invoice_mst_info->appoint_service_no_fk != "" ? $invoice_mst_info->appoint_service_no_fk : '';
        $appoint_type = '';
        if ($app_id != "") {
            $appoint_type = DB::table('patn_appointment_vw')->select('appoint_typename')->where('appoint_no_pk', $app_id)->first()->appoint_typename;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledger_no_fk", $l_date)
            ->get();
        $ledger_no = DB::select("SELECT paymood,pay_mood_type, pay_amount FROM FINC_LEDGER_PAYMOOD WHERE  invoice_no_fk = $invoice_id and ledger_no_fk = $l_date");
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            // ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat","item_rate_orig", "service_charge", "cancel_ind","invoicedtl_no_pk")
            ->orderBy('invoicedtl_no_pk','asc')
            ->get();
            // dd(  $invoice_dtls_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(ledger_amt_sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');
        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();
        if ($po_hospital_details->hospital_code != 'KBMH')
            $pdf = PDF::loadView("admin.billing.billing_invoice_app_print_v2", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'appoint_type' => $appoint_type, 'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_app_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'appoint_type' => $appoint_type, 'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_ipd_print($invoice_id, $page = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //  dd($po_hospital_details);
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }
        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $payment_status=DB::table('finc_ledgermst')->select('pay_type')->where('invoice_no_fk',$invoice_id)->where('trn_type_code','PAYMENT')->first();

        $userInfo = Auth::user();
        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);


        if ($po_hospital_details->hospital_code != 'KBMH') {

            $pdf = PDF::loadView("admin.billing.billing_invoice_ipd_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
            return $pdf->stream("invoice.pdf", array("Attachment" => false));
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_ipd_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
            return $pdf->stream("invoice.pdf", array("Attachment" => false));
        }
    }
    public function bill_invoice_ipd_print_v2($invoice_id, $page = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //  dd($po_hospital_details);
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->select('finc_invoicemst_sum_vw.*','patient_info_vw.ccm_client_name')
            ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','finc_invoicemst_sum_vw.patient_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }
        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $payment_status=DB::table('finc_ledgermst')->select('pay_type')->where('invoice_no_fk',$invoice_id)->where('trn_type_code','PAYMENT')->first();

        $userInfo = Auth::user();
        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);


        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.billing_invoice_ipd_print_v2", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
            return $pdf->stream("invoice.pdf", array("Attachment" => false));
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_ipd_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
            return $pdf->stream("invoice.pdf", array("Attachment" => false));
        }
    }

    public function bill_invoice_pos_print($invoice_id, $page = "", $trx = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("LEDGER_NO_FK", $l_date)
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','bed_name')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        // $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        // WHERE invoice_no_pk = $invoice_id");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }
        // $total_discount = DB::select("SELECT SUM(ledger_amt_discount_phr) ledger_amt_discount FROM finc_invoicemst_sum_vw
        // WHERE invoice_no_pk = $invoice_id");
        // foreach ($total_discount as $dis) {
        //     $total_dis = $dis;
        // }
        // $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        // if (isset($ledger_payment)) {
        //     foreach ($ledger_payment as $value) {
        //         $ledger_pay_amount = $value;
        //     }
        // }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->get();

        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        // $item_type = DB::table("finc_invoicedtl_vw")
        //     ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
        //     ->select("item_type_name", "item_no_fk")->first();

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }

        // dd($exp_date);
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $pdf = App::make('dompdf.wrapper');

        $pdf = PDF::loadView("admin.billing.pharmacy.billing_invoice_pos_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'exp_date' => $exp_date, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_pos_printV2($invoice_id, $page = "", $trx = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("LEDGER_NO_FK", $l_date)
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('finc_inv_patientdetail_vw.patient_code',
                          'finc_inv_patientdetail_vw.patient_name',
                          'finc_inv_patientdetail_vw.admission_no_pk',
                          'finc_inv_patientdetail_vw.present_addr',
                          'finc_inv_patientdetail_vw.mobile1',
                          'finc_inv_patientdetail_vw.age',
                          'finc_inv_patientdetail_vw.gender_txt',
                          'finc_inv_patientdetail_vw.doctor_name',
                          'finc_inv_patientdetail_vw.first_doc_name',
                          'finc_inv_patientdetail_vw.second_doc_name',
                          'finc_inv_patientdetail_vw.au_entry_at',
                          'finc_inv_patientdetail_vw.invoice_code',
                          'finc_inv_patientdetail_vw.queue_no_sl',
                          'finc_inv_patientdetail_vw.bed_name',
                          'finc_inv_patientdetail_vw.ward_name',
                          'finc_inv_patientdetail_vw.patient_type_code',
                          'patient_info_vw.ccm_client_name')
            ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','finc_inv_patientdetail_vw.patient_no_pk')
            ->where("finc_inv_patientdetail_vw.invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();


        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk","disc_amount")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk","disc_amount")
            ->get();

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                ->get();
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $pdf = App::make('dompdf.wrapper');

        //    return view("admin.billing.pharmacy.billing_invoice_pos_print_v2", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'exp_date' => $exp_date, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
        $pdf = PDF::loadView("admin.billing.pharmacy.billing_invoice_pos_print_v2", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'exp_date' => $exp_date, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_pos_print_pos($invoice_id, $page = "", $trx = "")
    {
        ini_set("max_execution_time",0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no = DB::table("finc_ledgermst")
            // ->select('paymood','pay_mood_type','pay_amount','ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        // dd($ledger_no);
        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("LEDGER_NO_FK", $l_date)
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
            // dd($invoice_mst_info);
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        // $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        //  WHERE invoice_no_pk = $invoice_id");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }
        // $total_discount = DB::select("SELECT SUM(ledger_amt_discount_phr) ledger_amt_discount FROM finc_invoicemst_sum_vw
        //  WHERE invoice_no_pk = $invoice_id");
        // foreach ($total_discount as $dis) {
        //     $total_dis = $dis;
        // }
        // $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        // if (isset($ledger_payment)) {
        //     foreach ($ledger_payment as $value) {
        //         $ledger_pay_amount = $value;
        //     }
        // }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->get();
        // dd($invoice_dtls_info);
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        // $item_type = DB::table("finc_invoicedtl_vw")
        //     ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
        //     ->select("item_type_name", "item_no_fk")->first();

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }

        // dd($exp_date);
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        // dd($finc_inv_collection_amount);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);

        $pdf->loadView("admin.billing.pharmacy.billing_invoice_pos_phr_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'exp_date' => $exp_date, 'pdf' => $pdf, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
        $item_count = count($invoice_dtls_info) * 10;
        $canvas = $pdf->getDomPDF()->get_canvas();
        $height = ($canvas->get_height());

        $width = $canvas->get_width();
        // dd($height + $width);
        $page_width = Session::get('user.ses_hospital_code') == "GMC" ?  226.77 : 226.77;
        $pdf->setPaper(array(0, 0, $page_width, ($height + 800) + $width));
        // dd($height);
        // $pdf->setPaper(array(0, 0, 226.77, $height + 20));
        return $pdf->stream("pos-invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_physio_print_a5($invoice_id, $page = "", $trx = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }
        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);
        $pdf = PDF::loadView("admin.billing.billing_invoice_physio_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_invoice_physio_print_a4($invoice_id, $page = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }
        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView("admin.billing.billing_invoice_physio_print_a4", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $pay_mode, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc])->setPaper('a4', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function due_invoice_print($invoice_id, $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.disc_amt_by_doc_no_fk')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();
        // dd($discout_by);

        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        //bed information added
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")
            ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')



            ->get();

        // dd( $invoice_dtls_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

            $return_reson= DB::table("finc_ledgermst")
        ->select('refund_reason')
        ->where("invoice_no_fk", $invoice_id)
        ->where("ledgertrn_no_fk", $trx)
        ->where("trn_type_code", 'SALESR')
        ->first();
        //   dd($return_reson);


        if ($po_hospital_details->hospital_code != 'KBMH') {

            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');


        } else {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function due_invoice_print_v2($invoice_id, $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.disc_amt_by_doc_no_fk')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();
        // dd($discout_by);

        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw as fip")
            ->select('fip.invoice_code','fip.patient_code','fip.patient_name','fip.dob','fip.gender_txt','fip.mobile1','fip.present_addr','fip.doctor_name','fip.first_doc_name','fip.person_code',
            'fip.second_doc_name','fip.report_delivary_date','fip.invoice_date','fip.report_delivary_datetime','fip.admission_no_pk','fip.admission_date','fip.invoice_remarks','fip.au_entry_by',
            'fip.second_doc_person_code','fip.degree','fip.patient_type_code','patient_info_vw.ccm_client_name')
            ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','fip.patient_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        //bed information added
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount","dis_amt", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no","current_item_qty")
            ->where('item_no_fk','!=',0)
            ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();

        // dd( $invoice_dtls_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

            $return_reson= DB::table("finc_ledgermst")
        ->select('refund_reason')
        ->where("invoice_no_fk", $invoice_id)
        ->where("ledgertrn_no_fk", $trx)
        ->where("trn_type_code", 'SALESR')
        ->first();
        //   dd($return_reson);


        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_v2", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');


        } else {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function due_invoice_print_v2_pkg($invoice_id, $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.disc_amt_by_doc_no_fk')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();
        // dd($discout_by);

        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','second_doc_person_code','degree')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        //bed information added
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk","item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")
            // ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();

        // dd( $invoice_dtls_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

            $return_reson= DB::table("finc_ledgermst")
        ->select('refund_reason')
        ->where("invoice_no_fk", $invoice_id)
        ->where("ledgertrn_no_fk", $trx)
        ->where("trn_type_code", 'SALESR')
        ->first();
        //   dd($return_reson);


        if ($po_hospital_details->hospital_code != 'KBMH') {

            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_v2_pkg", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');


        } else {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function carParkingInvoice($invoice_id, $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.disc_amt_by_doc_no_fk')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();
        // dd($discout_by);

        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        //bed information added
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")
            ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')



            ->get();

        // dd( $invoice_dtls_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

            $return_reson= DB::table("finc_ledgermst")
            ->select('refund_reason')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'SALESR')
            ->first();

            $vehicle_data=DB::table('carp_transaction')->where('invoice_no_fk', $invoice_id)->first();
            // dd( $invoice_id, $vehicle_data);



            $pdf = PDF::loadView("admin.billing.due_collection.car_parking_invoice_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'return_reson'=>$return_reson,'vehicle_data'=>$vehicle_data])->setPaper('a5', 'portrait');



        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function getAttribute($item_no){

        $item_no_array = array_map('intval', explode(',', $item_no));

        $attr_list = DB::table('labs_teststructure_vw')
                            ->select('attr')
                            ->whereIn('item_no_fk', $item_no_array)
                            ->where('hide_permanent', 0)
                            ->orderBy('sl_no', 'asc')
                            ->get();


        // $attr_list=DB::table('labs_teststructure_vw')->select('attr')->whereIn('item_no_fk',$item_no_array)->where('hide_permanent',0)->orderBy('sl_no','asc')->get();

        //  dd($attr_list->all());

        return json_decode($attr_list);
    }

    public function samList($samId){
        $item_id = DB::table('LABT_INVOICEDTL_VW')
        ->select('item_no_pk')
        ->where('lab_code', $samId)
        ->first()->item_no_pk;

        $samlist = DB::table('LABS_TESTSTRUCTURE')
        ->where('item_no_fk', $item_id)
        ->get();
        if ($samlist) {
            return $samlist;
        }

    }

    public function checkCollection($samId){

        $invoice_id = DB::table('labt_samplecoll_wl_vw')
        ->select('invoice_no_fk')
        ->where('lab_code', $samId)
        ->first()->invoice_no_fk;

        $labIdCount = DB::table('labt_samplecoll_wl_vw')
        ->select('sc_sample_coll_key_ind','lab_code')
        ->where('invoice_no_fk', $invoice_id)
        ->orderBy('lab_code', 'asc')
        ->get()[0];

        $samlist = DB::table('LABT_INVOICEDTL_VW')
        ->where('LAB_CODE', $labIdCount->lab_code)
        ->get();
        ;
        $samStatus = DB::table('labt_samplecoll_wl_vw')
                       ->select('sc_sample_coll_key_ind')
                       ->where('lab_code', $labIdCount->lab_code)
                       ->first();
        if ($samStatus) {
            return $samStatus->sc_sample_coll_key_ind;
        }

    }

    public function invoice_print_lab($lab_id,$invoice_id='',$type='')
    {

        //  dd($lab_id,$invoice_id,$type);


        $lab_no_exp=explode('_',$lab_id);
        $lab_no_arr=  array_filter($lab_no_exp);

        // dd($lab_no_exp, $lab_no_arr);


        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','second_doc_person_code')
        ->where("invoice_no_pk", $invoice_id)
        ->orderBy("ledger_datetime", "DESC")
        ->first();

        $type=$type=='collect'  || $type=='ipd_collect'? null :1;

        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->select('labt_samplecoll_wl_vw.test_name_list','labt_samplecoll_wl_vw.test_no_list','labt_samplecoll_wl_vw.item_count','labt_samplecoll_wl_vw.serviceunit_name','labt_samplecoll_wl_vw.container_item_name','labt_samplecoll_wl_vw.lab_code')
                    ->WhereIn("lab_no_pk",$lab_no_arr)
                    // ->where("sc_sample_coll_key_ind", $type)
                    ->where('cancel_ind', NULL)
                    ->orderBy("lab_code", "asc")
                    ->get();

        // dd($sample_collection_arr);

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();




        //    dd($sample_collection_arr->groupBy(['container_item_name','serviceunit_name']));
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        // dd($sample_collection_arr->groupBy(['container_item_name','serviceunit_name']));
        if ($po_hospital_details->hospital_code == 'DMHL') {
            $pdf = PDF::loadView("admin.billing.due_collection.invoice_print_for_lab", [ 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'sample_collection_arr' => $sample_collection_arr->groupBy(['container_item_name','serviceunit_name','lab_code']),'invoice_barcode' => $invoice_barcode,  'po_hospital_details' => $po_hospital_details,'pat_barcode'=>$pat_barcode,'bed_details'=>$bed_details])->setPaper('a5', 'portrait');

        }else{
            // dd($sample_collection_arr->groupBy(['container_item_name','serviceunit_name','lab_code']));
            $pdf = PDF::loadView("admin.billing.due_collection.invoice_print_for_lab", [ 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'sample_collection_arr' => $sample_collection_arr->groupBy(['container_item_name','serviceunit_name','lab_code']),'invoice_barcode' => $invoice_barcode,  'po_hospital_details' => $po_hospital_details,'pat_barcode'=>$pat_barcode,'bed_details'=>$bed_details])->setPaper('a5', 'portrait');
            // $pdf = PDF::loadView("admin.billing.due_collection.invoice_print_for_lab_uhl", [ 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'sample_collection_arr' => $sample_collection_arr->groupBy(['container_item_name','serviceunit_name']),'invoice_barcode' => $invoice_barcode,  'po_hospital_details' => $po_hospital_details,'pat_barcode'=>$pat_barcode,'bed_details'=>$bed_details])->setPaper('a5', 'portrait');

        }

        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }


     public function ogttWorklist($lab_id,$invoice_id)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','second_doc_person_code')
        ->where("invoice_no_pk", $invoice_id)
        ->orderBy("ledger_datetime", "DESC")
        ->first();


        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->select('labt_samplecoll_wl_vw.test_name_list','labt_samplecoll_wl_vw.test_no_list','labt_samplecoll_wl_vw.item_count','labt_samplecoll_wl_vw.serviceunit_name','labt_samplecoll_wl_vw.container_item_name','labt_samplecoll_wl_vw.lab_code')
                    ->Where("lab_code",$lab_id)
                    // ->where("sc_sample_coll_key_ind", $type)
                    ->where('cancel_ind', NULL)
                    ->orderBy("lab_code", "asc")
                    ->get();

        $samlist = DB::table('labt_samplecoll_wl_vw')
        ->select('lab_code')
        ->where('invoice_no_fk', $invoice_id)
        ->where('test_name_list','OGTT-2 Samples')
        ->orderBy('lab_code', 'asc')
        ->get();


        $firstLabCode = optional($samlist->first())->lab_code; // প্রথম lab_code
        $lastLabCode = optional($samlist->last())->lab_code;   // শেষ lab_code
        $middleLabCode = optional($samlist->slice(1, 1)->first())->lab_code; // দ্বিতীয় (মাঝের) lab_code

        $clickedLabCode = $selectedLabCode ?? null; // ক্লিক করা lab_code (যে ID ক্লিক হয়েছে)
        // dd($lab_id,$firstLabCode,$invoice_id);
        // নিশ্চিত করুন যে ক্লিক করা lab_code বিদ্যমান
        if (!is_null($lab_id) && !is_null($firstLabCode)) {
            if ($lab_id == $firstLabCode) {
                $attr_name = "1 . Fasting Blood Sugar (FBS)";
            } elseif (!is_null($middleLabCode) && $lab_id == $middleLabCode) {
                $attr_name = "2 . 2 hrs After 75gm Glucose";
            } elseif ($lab_id == $lastLabCode) {
                $attr_name = "3 . Random Blood Sugar (RBS)";
            } else {
                $attr_name = "Invalid lab code";
            }
        } else {
            $attr_name = "Invalid lab code";
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();


        //    dd($sample_collection_arr->groupBy(['container_item_name','serviceunit_name']));
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        // dd($sample_collection_arr->groupBy(['container_item_name','serviceunit_name']));
        $pdf = PDF::loadView("admin.billing.due_collection.invoice_print_for_lab_ogtt", [ 'invoice_id' => $invoice_id,'attr_name'=>$attr_name, 'invoice_mst_info' => $invoice_mst_info, 'sample_collection_arr' => $sample_collection_arr->groupBy(['container_item_name','serviceunit_name']),'invoice_barcode' => $invoice_barcode,  'po_hospital_details' => $po_hospital_details,'pat_barcode'=>$pat_barcode,'bed_details'=>$bed_details])->setPaper('a5', 'portrait');

        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }


    public function pos_due_invoice_print($invoice_id, $trx = "")
    {

        $transaction_id = $trx;
        $trx = 0;
        ini_set("max_execution_time",0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledger_no = DB::table("finc_ledgermst")
                        ->select('ledger_no_pk')
                        ->where("invoice_no_fk", $invoice_id)
                        ->where("trn_type_code", 'PAYMENT')
                        ->where("ledgertrn_no_fk", $trx)
                        ->orderBy("LEDGER_CODE", "DESC")
                        ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
                        ->select('pay_mood_type','pay_amount','paymood')
                        ->where("invoice_no_fk", $invoice_id)
                        ->where("LEDGER_NO_FK", $l_date)
                        ->orderBy("LEDGER_NO_FK", "DESC")
                        ->get();


        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk','au_entry_by','bed_name','ward_name')
                                ->where("invoice_no_pk", $invoice_id)
                                ->orderBy("ledger_datetime", "DESC")
                                ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
                                ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
                                ->where("invoice_no_pk", $invoice_id)
                                ->orderBy("ledger_no_pk", "desc")
                                ->first();


        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
                                ->where("invoice_no_fk", $invoice_id)
                                ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "current_item_qty", "item_no_fk")
                                ->orderBy("cancel_qty", "DESC")
                                ->get();
        // dd( $invoice_dtls_info );
        $exp_detail = DB::table("finc_invoicedtl_vw")
                            ->where("invoice_no_fk", $invoice_id)
                            ->select("item_no_fk")
                            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                ->get();
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();


        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund','collection')->where('invoice_no_pk', $invoice_id)->first();

        $collector_info = DB::select("select
                                        finc_ledgertrn.ledgertrn_datetime,
                                        wsec_user.user_fullname,
                                        finc_ledgertrn.au_entry_by,
                                        finc_ledgertrn.au_entry_by

                                        from finc_ledgertrn

                                        join wsec_user on wsec_user.user_no_pk = finc_ledgertrn.au_entry_by and ledgertrn_no_pk = '$transaction_id' and invoice_no_fk = '$invoice_id'");

        $pdf = PDF::loadView("admin.billing.pharmacy.pos_due_invoice_print", ['collector_info' => $collector_info,'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no,  'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'exp_date' => $exp_date, 'preparedBy' => $preparedBy,  'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function pos_due_invoice_print_v2($invoice_id, $trx = "")
    {

        $transaction_id = $trx;
        $trx = 0;
        ini_set("max_execution_time",0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledger_no = DB::table("finc_ledgermst")
                        ->select('ledger_no_pk')
                        ->where("invoice_no_fk", $invoice_id)
                        ->where("trn_type_code", 'PAYMENT')
                        ->where("ledgertrn_no_fk", $trx)
                        ->orderBy("LEDGER_CODE", "DESC")
                        ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
                        ->select('pay_mood_type','pay_amount','paymood')
                        ->where("invoice_no_fk", $invoice_id)
                        ->where("LEDGER_NO_FK", $l_date)
                        ->orderBy("LEDGER_NO_FK", "DESC")
                        ->get();


        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
                            ->select('finc_inv_patientdetail_vw.patient_code',
                                'finc_inv_patientdetail_vw.patient_name',
                                'finc_inv_patientdetail_vw.admission_no_pk',
                                'finc_inv_patientdetail_vw.present_addr',
                                'finc_inv_patientdetail_vw.mobile1',
                                'finc_inv_patientdetail_vw.age',
                                'finc_inv_patientdetail_vw.gender_txt',
                                'finc_inv_patientdetail_vw.doctor_name',
                                'finc_inv_patientdetail_vw.first_doc_name',
                                'finc_inv_patientdetail_vw.second_doc_name',
                                'finc_inv_patientdetail_vw.au_entry_at',
                                'finc_inv_patientdetail_vw.invoice_code',
                                'finc_inv_patientdetail_vw.invoice_remarks',
                                'finc_inv_patientdetail_vw.invoice_no_pk',
                                'finc_inv_patientdetail_vw.au_entry_by',
                                'finc_inv_patientdetail_vw.queue_no_sl',
                                'finc_inv_patientdetail_vw.patient_type_code',
                                'patient_info_vw.ccm_client_name')
                                ->leftJoin('patient_info_vw','patient_info_vw.patient_no_pk','=','finc_inv_patientdetail_vw.patient_no_pk')
                                ->where("invoice_no_pk", $invoice_id)
                                ->orderBy("ledger_datetime", "DESC")
                                ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
                                ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
                                ->where("invoice_no_pk", $invoice_id)
                                ->orderBy("ledger_no_pk", "desc")
                                ->first();


        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
                                ->where("invoice_no_fk", $invoice_id)
                                ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "current_item_qty", "item_no_fk","disc_amount")
                                ->orderBy("cancel_qty", "DESC")
                                ->get();

        $exp_detail = DB::table("finc_invoicedtl_vw")
                            ->where("invoice_no_fk", $invoice_id)
                            ->select("item_no_fk")
                            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                ->get();
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();


        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund','collection')->where('invoice_no_pk', $invoice_id)->first();

        $collector_info = DB::select("select
                                        finc_ledgertrn.ledgertrn_datetime,
                                        wsec_user.user_fullname,
                                        finc_ledgertrn.au_entry_by,
                                        finc_ledgertrn.au_entry_by

                                        from finc_ledgertrn

                                        join wsec_user on wsec_user.user_no_pk = finc_ledgertrn.au_entry_by and ledgertrn_no_pk = '$transaction_id' and invoice_no_fk = '$invoice_id'");

        $pdf = PDF::loadView("admin.billing.pharmacy.pos_due_invoice_print_v2", ['collector_info' => $collector_info,'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no,  'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'exp_date' => $exp_date, 'preparedBy' => $preparedBy,  'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function due_invoice_pos_print_pos($invoice_id, $trx = "")
    {
        ini_set('max_execution_time',0);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();


        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->select('patient_code','au_entry_by','invoice_code','admission_no_pk','mobile1')
            ->orderBy("ledger_datetime", "DESC")
            ->first();
            // dd($invoice_mst_info);
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "current_item_qty", "item_no_fk")
            // ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "current_item_qty", "item_no_fk")
            ->orderBy("cancel_qty", "DESC")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->orderBy("cancel_qty", "DESC")
        // ->get();
        // dd(count($invoice_dtls_info));
        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund','collection')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();


        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);

        // return view("admin.billing.pharmacy.pos_due_invoice_print_phr", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood, 'ledger_no' => $ledger_no,  'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'exp_date' => $exp_date, 'preparedBy' => $preparedBy,'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
        $pdf = PDF::loadView("admin.billing.pharmacy.pos_due_invoice_print_phr", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'paymood' => $paymood, 'ledger_no' => $ledger_no,  'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'exp_date' => $exp_date, 'preparedBy' => $preparedBy,'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);


        $canvas = $pdf->getDomPDF()->get_canvas();
        $height = ($canvas->get_height());
        $width = $canvas->get_width();
        $page_width = Session::get('user.ses_hospital_code') == "GMC" ?  226.77 : 226.77;
        $pdf->setPaper(array(0, 0, $page_width, ($height + 800) + $width));
        return $pdf->stream("pos-due-collection.pdf", array("Attachment" => false));
        $canvas = $pdf->getDomPDF()->get_canvas();
        $height = ($canvas->get_height());
        $pdf->setPaper(array(0, 0, 226.77, $height + 20));
        return $pdf->stream("pos-due-collection.pdf", array("Attachment" => false));

    }

    public function bill_cancel_print($invoice_id, $trx = "")
    {
        // dd($invoice_id);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','au_entry_by','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $return_reson= DB::table("finc_ledgermst")
        ->select('refund_reason')
        ->where("invoice_no_fk", $invoice_id)
        ->where("ledgertrn_no_fk", $trx)
        ->where("trn_type_code", 'SALESR')
        ->first();

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        // $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id ");
        // foreach ($c_dis as $value) {
        //     $c_discount = $value;
        // }

        // $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind = 1");
        // foreach ($c_dis_cancel as $value) {
        //     $c_dis_cancelation = $value;
        // }

        // // foreach ($c_dis_cancel as  $value) {
        // //   $c_dis_cancelation = $value;
        // // }

        // $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment , SUM(abs(LEDGER_AMT_DISCOUNT)) LEDGER_AMT_DISCOUNT FROM finc_invoicemst_sum_vw
        //  WHERE invoice_no_pk = $invoice_id ");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }

        // $finc_vouchermas_sum = DB::table('finc_vouchermst_sum_vw')->where('invoice_no_pk', $invoice_id)->first();
        // $test= $total_sales->ledger_amt_discount - $c_discount->disc_amount;
        // dd( number_format($test));

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_pk', $invoice_id)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
        ->select('ledgertrn_no_pk','collection','refund')
            ->where('invoice_no_pk', $invoice_id)
            ->where('ledgertrn_no_pk', '=', $trx)
            ->first();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView("admin.billing.billing_cancelation.billing_cancel_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'po_hospital_details' => $po_hospital_details,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }
    public function bill_cancel_print_v2($invoice_id, $trx = "")
    {
        // dd($invoice_id);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','au_entry_by','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $return_reson= DB::table("finc_ledgermst")
        ->select('refund_reason')
        ->where("invoice_no_fk", $invoice_id)
        ->where("ledgertrn_no_fk", $trx)
        ->where("trn_type_code", 'SALESR')
        ->first();

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->orderBy("cancel_qty", "DESC")
            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_pk', $invoice_id)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
        ->select('ledgertrn_no_pk','collection','refund')
            ->where('invoice_no_pk', $invoice_id)
            ->where('ledgertrn_no_pk', '=', $trx)
            ->first();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView("admin.billing.billing_cancelation.billing_cancel_print_v2", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode, 'po_hospital_details' => $po_hospital_details,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'return_reson'=>$return_reson])->setPaper('a5', 'portrait');
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function pos_cancel_print($invoice_id, $page = "", $trx = "")
    {
        // dd($invoice_id);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk','au_entry_by')
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        // dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk","cancel_qty","item_vat")
            ->where("invoice_no_fk", $invoice_id)
            ->orderBy("cancel_qty", "DESC")
            ->get();
        // dd($invoice_dtls_info);
        // $c_dis = DB::select("select SUM(disc_amount_phr) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id ");
        // foreach ($c_dis as $value) {
        //     $c_discount = $value;
        // }

        // $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind = 1");
        // foreach ($c_dis_cancel as $value) {
        //     $c_dis_cancelation = $value;
        // }

        // $cancel_sale = DB::select("SELECT A.LAST_CAN_QTY,A. LEDGERDTL_AMT_SALES as ledger_amt_sales FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,SUM(LMST.LEDGER_AMT_SALES) LEDGERDTL_AMT_SALES ,
        // DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        // finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        // join finc_ledgerdtl dtl
        // on dtl.ledger_no_fk=lmst.ledger_no_pk
        // where LMST.TRN_TYPE_CODE='SALESR'  and mst.invoice_no_pk=$invoice_id
        // GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        // ORDER BY DTL.au_ENTRY_AT DESC) A
        // where ROWNUM=1");

        // foreach ($cancel_sale as $value) {
        //     $cancel_sales = $value;
        // }

        // $cancel_discount = DB::select("SELECT A.LAST_CAN_QTY,A.LEDGERDTL_AMT_DISCOUNT as ledger_amt_discount FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,
        // SUM(LMST.LEDGER_AMT_DISCOUNT)LEDGERDTL_AMT_DISCOUNT,DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        // finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        // join finc_ledgerdtl dtl
        // on dtl.ledger_no_fk=lmst.ledger_no_pk
        // where LMST.TRN_TYPE_CODE='DISCOUNTR' and mst.invoice_no_pk=$invoice_id
        // GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        // ORDER BY DTL.au_ENTRY_AT DESC) A
        // where ROWNUM=1");
        // if ($cancel_discount) {
        //     foreach ($cancel_discount as $value) {
        //         $cancel_dis = $value;
        //     }
        // } else {
        //     $cancel_dis = [];
        // }

        // dd($cancel_dis);

        //DB::table('finc_ledgermst')->select('ledger_amt_discount')->where('invoice_no_fk' , $invoice_id)->where('trn_type_code' , 'DISCOUNTR')->where('ledger_amt_discount', '<', 0.00  )->orderBy('ledger_no_pk', 'desc')->first();

        // $total_sale = DB::select("SELECT  ledger_amt_payment , abs(ledger_amt_discount),ledger_amt_sales_can,ledger_amt_dis_can FROM finc_invoicemst_sum_vw
        //  WHERE invoice_no_pk = $invoice_id ");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }
        // dd($total_sales);
        // $test= $total_sales->ledger_amt_discount - $c_discount->disc_amount;
        // dd( number_format($test));

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();
        // $finc_vouchermas_sum = DB::table('finc_vouchermst_sum_vw')->where('invoice_no_pk', $invoice_id)->first();
        $pdf = App::make('dompdf.wrapper');



        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_pk', $invoice_id)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
             ->select('ledgertrn_no_pk','refund')
            ->where('invoice_no_pk', $invoice_id)
            ->where('ledgertrn_no_pk', '=', $trx)
            ->first();


        $pdf = PDF::loadView("admin.billing.pharmacy.pos_cancelation_print", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,   'po_hospital_details' => $po_hospital_details,  'exp_date' => $exp_date,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        return $pdf->stream("pos.pdf", array("Attachment" => false));
    }
    public function cancel_invoice_pos_print_pos($invoice_id, $page = "", $trx = "")
    {
        // dd($invoice_id);
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk','au_entry_by')
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        // dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk","cancel_qty","item_vat")
            ->where("invoice_no_fk", $invoice_id)
            ->orderBy("cancel_qty", "DESC")
            ->get();
        // $c_dis = DB::select("select SUM(disc_amount_phr) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id ");
        // foreach ($c_dis as $value) {
        //     $c_discount = $value;
        // }
        $c_fee = DB::select("select SUM(urgent_fee) urgent_fee FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id ");
        foreach ($c_fee as $value) {
            $c_urgent_fee = $value;
        }

        // $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind = 1");
        // foreach ($c_dis_cancel as $value) {
        //     $c_dis_cancelation = $value;
        // }

        // $cancel_sale = DB::select("SELECT A.LAST_CAN_QTY,A. LEDGERDTL_AMT_SALES as ledger_amt_sales FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,SUM(LMST.LEDGER_AMT_SALES) LEDGERDTL_AMT_SALES ,
        // DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        // finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        // join finc_ledgerdtl dtl
        // on dtl.ledger_no_fk=lmst.ledger_no_pk
        // where LMST.TRN_TYPE_CODE='SALESR'  and mst.invoice_no_pk=$invoice_id
        // GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        // ORDER BY DTL.au_ENTRY_AT DESC) A
        // where ROWNUM=1");

        // foreach ($cancel_sale as $value) {
        //     $cancel_sales = $value;
        // }

        // $cancel_discount = DB::select("SELECT A.LAST_CAN_QTY,A.LEDGERDTL_AMT_DISCOUNT as ledger_amt_discount FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,
        // SUM(LMST.LEDGER_AMT_DISCOUNT)LEDGERDTL_AMT_DISCOUNT,DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        // finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        // join finc_ledgerdtl dtl
        // on dtl.ledger_no_fk=lmst.ledger_no_pk
        // where LMST.TRN_TYPE_CODE='DISCOUNTR' and mst.invoice_no_pk=$invoice_id
        // GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        // ORDER BY DTL.au_ENTRY_AT DESC) A
        // where ROWNUM=1");
        // if ($cancel_discount) {
        //     foreach ($cancel_discount as $value) {
        //         $cancel_dis = $value;
        //     }
        // } else {
        //     $cancel_dis = [];
        // }
        $cancel_refund = DB::select("SELECT A.LAST_CAN_QTY,A.URGENT_FEE as cancel_urgent_fee FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,
        SUM(LMST.urgent_fee)urgent_fee,DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        join finc_ledgerdtl dtl
        on dtl.ledger_no_fk=lmst.ledger_no_pk
        where LMST.TRN_TYPE_CODE='SALESR' and mst.invoice_no_pk=$invoice_id
        GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        ORDER BY DTL.au_ENTRY_AT DESC) A
        where ROWNUM=1");
        if ($cancel_refund) {
            foreach ($cancel_refund as $value) {
                $cancel_fee = $value;
            }
        } else {
            $cancel_fee = [];
        }

        // dd($cancel_dis);

        //DB::table('finc_ledgermst')->select('ledger_amt_discount')->where('invoice_no_fk' , $invoice_id)->where('trn_type_code' , 'DISCOUNTR')->where('ledger_amt_discount', '<', 0.00  )->orderBy('ledger_no_pk', 'desc')->first();

        // $total_sale = DB::select("SELECT  ledger_amt_payment , abs(ledger_amt_discount),ledger_amt_sales_can,ledger_amt_dis_can FROM finc_invoicemst_sum_vw
        //  WHERE invoice_no_pk = $invoice_id ");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }
        // dd($total_sales);
        // $test= $total_sales->ledger_amt_discount - $c_discount->disc_amount;
        // dd( number_format($test));

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_pk', $invoice_id)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select('ledgertrn_no_pk','refund')
            ->where('invoice_no_pk', $invoice_id)
            ->where('ledgertrn_no_pk', '=', $trx)
            ->first();
        // $pdf = App::make('dompdf.wrapper');
        // dd($c_urgent_fee->urgent_fee , $cancel_fee->cancel_urgent_fee);
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        // $finc_vouchermas_sum = DB::table('finc_vouchermst_sum_vw')->where('invoice_no_pk', $invoice_id)->first();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        $pdf = PDF::loadView("admin.billing.pharmacy.pos_cancelation_print_phr", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,    'po_hospital_details' => $po_hospital_details,  'exp_date' => $exp_date, 'cancel_fee' => $cancel_fee, 'c_urgent_fee' => $c_urgent_fee,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
        // ->setPaper('a5', 'portrait');
        $item_count = count($invoice_dtls_info) * 10;
        $canvas = $pdf->getDomPDF()->get_canvas();
        $height = ($canvas->get_height());

        $width = $canvas->get_width();


        $page_width = Session::get('user.ses_hospital_code') == "GMC" ?  226.77 : 226.77;
        $pdf->setPaper(array(0, 0, $page_width, ($height + 800) + $width));
        // $pdf->setPaper(array(0, 0, 226.77,  $height + 20));
        return $pdf->stream("pos-cancelation.pdf", array("Attachment" => false));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            if (Session::get('user.ses_hospital_code')=="DG") {
                return $this->billingRepository->createOrUpdateV2($request, $request->id);
            }else{
                return $this->billingRepository->createOrUpdateV1($request, $request->id);
            }

        } else {
            return $this->billingRepository->createOrUpdate($request, $request->id);
        }
    }
    public function storeUhl(Request $request)
    {

        if (Session::get('user.ses_hospital_version') == "V0") {
            // if (Session::get('user.ses_hospital_code') == "KPJ") {
            //     return $this->billingRepository->createOrUpdateUhlV4($request, $request->id);
            // }else{
                return $this->billingRepository->createOrUpdateUhlV1($request, $request->id);
            // }

        } else {
            return $this->billingRepository->createOrUpdate($request, $request->id);
        }
    }
    public function storeUhlV4(Request $request)
    {

        if (Session::get('user.ses_hospital_version') == "V0") {
            // if (Session::get('user.ses_hospital_code') == "KPJ") {
                return $this->billingRepository->createOrUpdateUhlV4($request, $request->id);
            // }else{
            //     return $this->billingRepository->createOrUpdateUhlV1($request, $request->id);
            // }

        } else {
            return $this->billingRepository->createOrUpdate($request, $request->id);
        }
    }
    public function emergencyBillingStore(Request $request)
    {

        if (Session::get('user.ses_hospital_version') == "V0") {

            return $this->billingRepository->emergencyBillCreateOrUpdateV1($request, $request->id);
        } else {
            return 'create ses_hospital_version == V0';
        }
    }
    public function dayCareStore(Request $request)
    {

        if (Session::get('user.ses_hospital_version') == "V0") {

            return $this->billingRepository->dayCareBillCreateOrUpdateV1($request, $request->id);
        } else {
            return 'create ses_hospital_version == V0';
        }
    }
    public function savePOS(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            return $this->billingRepository->POScreateOrUpdateV1($request, $request->id);
        } else {
            return $this->billingRepository->POScreateOrUpdate($request, $request->id);
        }
    }
    public function saveCafeteria(Request $request)
    {
        return $this->billingRepository->cafeteriacreateOrUpdateV1($request, $request->id);
    }

    public function saveIndentPOS(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            // return response()->json(['data' => $request->all()],422);
            return $this->billingRepository->POScreateOrUpdateIndentV1($request, $request->id);
        } else {
            return $this->billingRepository->POScreateOrUpdate($request, $request->id);
        }
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
    public function edit($id)
    {
        //
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

    public function bill_invoice($invoice_id, $trx = "")
    {
        // dd($invoice_id);
        $page_type = "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->select('pay_amount','pay_mood_type','paymood')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','au_entry_at','patient_type_code','age','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();
        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.billing_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'paymood' => $paymood,'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details]);


    }
    public function bill_invoice_v1($invoice_id, $trx = "")
    {
        // dd($invoice_id);
        $page_type = "";

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind", "ledgerdtl_amt_sales")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind", "ledgerdtl_amt_sales")
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk = $l_date");
        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.billing_invoice_v1", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details]);

        //     $ledger_no = DB::table("FINC_INVOICEMST_SUM_VW")
        //     ->where("invoice_no_pk", $invoice_id)
        //     ->orderBy("LEDGER_DATETIME", "DESC")
        //     ->first();

        //     $l_date= $ledger_no->ledger_datetime;

        //     $ledger_payment = DB::table("FINC_LEDGER_PAYMOOD")
        //     ->select(DB::raw("SUM(pay_amount) as pay_amount") )
        //     ->where("invoice_no_fk", $invoice_id)
        //     // ->where("LEDGER_PAYMOOD_DATE", $l_date )
        //     ->orderBy("LEDGER_PAYMOOD_DATE", "DESC")
        //     ->get();

        //     if(isset($ledger_payment)){
        //         foreach ($ledger_payment as  $value) {
        //          $ledger_pay_amount = $value ;
        //      }
        //  }
        //  // dd($ledger_pay_amount);

        //  $paymood =  DB::table("FINC_LEDGER_PAYMOOD")
        //  ->where("invoice_no_fk", $invoice_id)
        //  // ->where("LEDGER_PAYMOOD_DATE", $l_date )
        //  ->orderBy("LEDGER_PAYMOOD_DATE", "DESC")
        //  ->get();

        //  $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
        //  ->where("invoice_no_pk", $invoice_id)
        //  ->orderBy("ledger_datetime", "DESC")
        //  ->first();
        //  $total_sale =DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        //     WHERE invoice_no_pk = $invoice_id");
        //  foreach ($total_sale as  $value) {
        //     $total_sales = $value;
        // }

        // $total_item_rate =DB::select("SELECT SUM(ledger_amt_sales) ledger_amt_sales, SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        //     WHERE invoice_no_pk=$invoice_id");
        // foreach ($total_item_rate as  $value) {
        //     $total_item_rates = $value;
        // }

        //    $c_dis= DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind is null");
        //     foreach ($c_dis as  $value) {
        //         $c_discount = $value;
        //     }

        //     $c_dis_cancel= DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind = 1");
        //     foreach ($c_dis_cancel as  $value) {
        //         $c_dis_cancelation = $value;
        //     }

        // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        // ->where("invoice_no_fk", $invoice_id)

        // ->select("item_code","report_delivery_date","delivery_status_lookup_no_fk","item_qty","item_rate","itemtype_no_fk","item_name","urgent_fee", "disc_amount" ,"cancel_qty")
        // ->groupBy("itemtype_no_fk","item_code","report_delivery_date","delivery_status_lookup_no_fk","item_qty","item_rate","itemtype_no_fk","item_name","urgent_fee", "disc_amount" ,"cancel_qty")
        // ->orderBy("cancel_qty" ,"DESC")
        // ->get();

        // return Template::loadView("admin.billing.billing_invoice", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info, 'total_sales' => $total_sales, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'total_item_rates' =>$total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation]);
    }

    public function bill_invoice_app($invoice_id, $trx = "")
    {
        $page_type = "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'),'invoice_no_pk', 'urgent_fee')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee')->first();
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.billing_invoice_app", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'paymood' => $paymood, 'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }

    public function bill_invoice_ipd($id)
    {
        $invoice_id = DB::table("finc_ledgermst")->select("invoice_no_fk")->where("ledger_no_pk", $id)->first()->invoice_no_fk;

        $page_type = "";

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE
        -- LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND
        invoice_no_fk = $invoice_id");
        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }

        return Template::loadView("admin.billing.billing_invoice_ipd", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'total_dis' => $total_dis, 'total_sales' => $total_sales]);
    }
    public function bill_invoice_physio($invoice_id, $trx = "")
    {

        $page_type = "";

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();

        $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");
        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }
        // dd( $ledger_pay_amount);

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.billing_invoice_physio", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'paymood' => $paymood, 'ledger_pay_amount' => $ledger_pay_amount, 'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }

    public function pos_invoice($invoice_id, $trx = "")
    {
        $page_type = "pos";
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->select('hospital_name','addrress1')->first();
        // $paymood = DB::table("finc_ledger_paymood")
        //     ->where("invoice_no_fk", $invoice_id)
        //     ->get();
        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        // dd($ledger_no);
        // $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('patient_code','au_entry_at','patient_name','admission_no_pk','age','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','second_doc_name','invoice_remarks','invoice_no_pk','invoice_code')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
            // dd($invoice_mst_info);
        // $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk")
            ->get();


        // $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        // WHERE invoice_no_pk = $invoice_id");
        // foreach ($total_sale as $value) {
        //     $total_sales = $value;
        // }

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();
            $exp_date =[];
        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }
        // dd($exp_date);

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('refund','ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        // dd( $invoice_id,$invoice_mst_info,$invoice_dtls_info,$paymodes,$paymood,$page_type,$po_hospital_details,$exp_date,$finc_inv_sum_amount,$finc_inv_collection_amount);
        return Template::loadView("admin.billing.pharmacy.billing_invoice_pos", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'paymood' => $paymood, 'page_type' => $page_type,  'po_hospital_details' => $po_hospital_details, 'exp_date' => $exp_date, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }

    public function appointment_invoice($appointment_id)
    {
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")->where("appoint_service_no_fk", $appointment_id)->first();

        if (!empty($invoice_mst_info)) {
            $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
                ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
                ->get();
        }

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_mst_info->invoice_no_pk");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }



        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
      WHERE invoice_no_pk = $invoice_mst_info->invoice_no_pk");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }


        return Template::loadView("admin.billing.billing_invoice_appointment", ['invoice_id' => $invoice_mst_info->invoice_no_pk, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'total_sales' => $total_sales, 'total_dis' => $total_dis]);
    }

    public function billing_invoice_print($appointment_id)
    {
        //  return $appointment_id;
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("appoint_service_no_fk", $appointment_id)
            ->first();

        if (!empty($invoice_mst_info)) {
            $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
                ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
                ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name")
                ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name")
                ->get();
        }

        $invoice_number = str_pad($invoice_mst_info->invoice_code, 11, "0", STR_PAD_LEFT);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_number);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        // return Template::loadView("admin.billing.billing_invoice_appointment_pdf", ['invoice_id'=>$invoice_mst_info->invoice_no_pk,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $paymodes]);

        $pdf = PDF::loadView("admin.billing.billing_invoice_appointment_pdf", ['invoice_id' => $appointment_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'invoice_barcode' => $invoice_barcode, 'pat_barcode' => $pat_barcode]);

        //return view("admin.billing.billing_invoice_print", compact('invoice_id','invoice_mst_info','invoice_dtls_info','pay_mode'));

        return $pdf->download('Appointment-Consultation-Invoice-' . $appointment_id . '.pdf');
    }

    public function pharmacyPOS($press_code="",$press_id="")
    {

        $pay_mode = ["CS" => "Cash"];
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $category_arr = $sub_category_arr = [];
        $category_info = DB::table("sysc_lookupdata_vw")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->whereIn("lookup_code", ["ITEMCAT", "ITEMCATSUB", "ITEMCATSUB1", "ITEMCATSUB2"])->get();
        // dd($disctype);
        if (!empty($category_info)) {
            foreach ($category_info as $row) {
                $category_arr[$row->lookup_code][] = $row->lookupdata_no_pk . "_" . $row->lookupdata_name;
                if (isset($sub_category_arr[$row->lookup_code])) {
                    $sub_category_arr[$row->lookup_code]++;
                } else {
                    $sub_category_arr[$row->lookup_code] = 0;
                }
            }
        }
        $service_point = GrantUserService::where('pharmacy_ind', '1') //->orWhere('hs_pos_ind', 1)
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind', 'hs_pos_ind')
            ->where('user_no_pk', Auth::id())
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('serviceunit_name', 'asc')
            ->distinct()
            ->get();

        // dd($category_arr,$sub_category_arr);
        return Template::loadview("admin.billing.pharmacy.pos", ["category_arr" => $category_arr, "sub_category_arr" => $sub_category_arr, 'paymodes' => $paymodes, 'service_point' => $service_point, '$pay_mode' => $pay_mode, 'disctype' => $disctype, 'bank_name' => $bank_name,'press_code' => $press_code,'press_id' => $press_id,]);
    }
    public function pharmacyPOSV2($press_code="",$press_id="")
    {
        $pay_mode = ["CS" => "Cash"];
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $category_arr = $sub_category_arr = [];
        $category_info = DB::table("sysc_lookupdata_vw")
                        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                        ->whereIn("lookup_code", ["ITEMCAT", "ITEMCATSUB", "ITEMCATSUB1", "ITEMCATSUB2"])
                        ->get();

        if (!empty($category_info)) {
            foreach ($category_info as $row) {
                $category_arr[$row->lookup_code][] = $row->lookupdata_no_pk . "_" . $row->lookupdata_name;
                if (isset($sub_category_arr[$row->lookup_code])) {
                    $sub_category_arr[$row->lookup_code]++;
                } else {
                    $sub_category_arr[$row->lookup_code] = 0;
                }
            }
        }
        $service_point = GrantUserService::where('pharmacy_ind', '1')
            ->select('serviceunit_no_pk',
             'serviceunit_name',
             'serviceunit_code',
              'default_ind',
              'hs_pos_ind')
            ->where('user_no_pk', Auth::id())
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('serviceunit_name', 'asc')
            ->distinct()
            ->get();

        $card_type=$this->getLookupListByCode("CARDTYPE");
        return Template::loadview("admin.billing.pharmacy.posV2", [
                                "category_arr" => $category_arr,
                                "sub_category_arr" => $sub_category_arr,
                                'paymodes' => $paymodes,
                                'service_point' => $service_point,
                                '$pay_mode' => $pay_mode,
                                'disctype' => $disctype,
                                'bank_name' => $bank_name,
                                'press_code' => $press_code,
                                'press_id' => $press_id,
                                'card_type' => $card_type,
                            ]);
    }
    public function cafeterriaPOS()
    {
        $pay_mode = ["CS" => "Cash"];
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $category_arr = $sub_category_arr = [];
        $category_info = DB::table("sysc_lookupdata_vw")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->whereIn("lookup_code", ["ITEMCAT", "ITEMCATSUB", "ITEMCATSUB1", "ITEMCATSUB2"])->get();
        // dd($disctype);
        if (!empty($category_info)) {
            foreach ($category_info as $row) {
                $category_arr[$row->lookup_code][] = $row->lookupdata_no_pk . "_" . $row->lookupdata_name;
                if (isset($sub_category_arr[$row->lookup_code])) {
                    $sub_category_arr[$row->lookup_code]++;
                } else {
                    $sub_category_arr[$row->lookup_code] = 0;
                }
            }
        }
        $service_point =
        GrantUserService::select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind', 'hs_pos_ind')
                        ->where('cafeteria_ind', '1') //->orWhere('hs_pos_ind', 1)
                        ->where('grantsu_status', '1')
                        ->where('user_no_pk', Auth::id())
                        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                        ->orderBy('serviceunit_name', 'asc')
                        ->distinct()
                        ->get();
        $card_type=$this->getLookupListByCode("CARDTYPE");
        $serviceUnit=DB::table('sysc_serviceunit')
                    ->where('status',1)
                    ->get();

        return Template::loadview("admin.billing.pharmacy.cafeterriaPos", ["category_arr" => $category_arr, "sub_category_arr" => $sub_category_arr, 'paymodes' => $paymodes, 'service_point' => $service_point, '$pay_mode' => $pay_mode, 'disctype' => $disctype, 'bank_name' => $bank_name,  'card_type' => $card_type,'serviceUnit'=>$serviceUnit]);
    }

    public function posExpireEdit($id)
    {
        $arry_rep = str_replace('_', ',', $id);
        $id_exp = explode('^', $arry_rep);
        $exp = explode('|', $id_exp[1]);
        $item_id_qty = explode(':', $id_exp[0]);
        $item_id = $item_id_qty[1];
        $sales_qty = $item_id_qty[0];

        $item_name = Item::select("ITEM_NAME")->where("ITEM_NO_PK", $item_id)->first();
        $batch = DB::table('stock_ledger_expirey_vw')->select('batch_no', 'expiry_date', 'recieve_qty')->where('item_no_fk', $item_id)->get();

        return Template::loadview("admin.billing.pharmacy.pos_expire_edit", ['exp' => $exp, 'id' => $item_id, 'batch' => $batch, 'sales_qty' => $sales_qty, 'item_name' => $item_name]);
    }
    public function showBatchDropdown(Request $request)
    {
        $id_exp = $request->batch_id;

        $batch_data = DB::select("select batch_no, TO_CHAR(expiry_date, 'DD-MM-YYYY') expiry_date, recieve_qty from stock_ledger_expirey_vw  where batch_no = '$id_exp'");

        // DB::table('stock_ledger_expirey_vw')->select('batch_no',trunc(expiry_date),'recieve_qty')->where('batch_no',$id_exp)->first();

        foreach ($batch_data as $value) {
            $batch = $value;
        }

        return json_encode($batch);
    }
    public function posQtyEdit($id)
    {

        return Template::loadview("admin.billing.pharmacy.pos_qty_edit");
    }
    public function posExpireShow(Request $request)
    {
        // dd($request->all());
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $qty = $request->qty;
            $item_no = $request->item_id;
            $su_unit_no = ($request->su_unit_no != "") ? $request->su_unit_no : 0;
            // dd($qty ,  $item_no,   $su_unit_no);
            $entry_session = "session";
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $numelems = 200;
            $outParam = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();
            // dd( $qty ,$item_no ,$su_unit_no);
            $itemExpiry = $pdo->prepare("begin pkg_ManageStock.prc_getstockexpiry(:in_stock_su_no_fk,:in_item_no_fk,:in_sales_qty,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_stockexpiry); end;");

            $itemExpiry->bindParam(':in_stock_su_no_fk', $su_unit_no); // will be adjust later
            $itemExpiry->bindParam(':in_item_no_fk', $item_no);
            $itemExpiry->bindParam(':in_sales_qty', $qty);
            $itemExpiry->bindParam(':in_au_entry_by', $auth_id);
            $itemExpiry->bindParam(':in_au_entry_session', $entry_session);
            $itemExpiry->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $itemExpiry->bindParam(':out_stockexpiry', $outParam, PDO::PARAM_STR, 500);
            //dd($itemExpiry);
            $itemExpiry->execute();

            $exp = str_replace('^', ',', trim($outParam));

            // dd($exp);
            // $exp=explode("|",$res);
            // dd($outParam);
            if ($outParam != '') {
                DB::commit();
                $message = $exp;
                // dd($message);

            } else {

                DB::rollback();
                $message = "";
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        //dd($message);
        return json_encode($message);

        // Template::loadview("admin.billing.pharmacy.pos");
    }

    public function saveExpireDate(Request $request)
    {

        $batch_dtails = $request->batch_name;
        $explode_batch = explode('^', $batch_dtails);
        //  $replace=str_replace("^",",",$explode_batch);
        // $count=count($explode_batch);
        // dd($count);
        // $i='';
        // $data='';
        // for ($i=0; $i < $count; $i++) {
        //  $data += (int)$explode_batch[$i];
        // }
        $arry_filter = array_filter($explode_batch, function ($value) {
            return !is_null($value) && $value !== '';
        });

        return json_encode($arry_filter);
    }

    public function billingDueCollection()
    {
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.billing.due_collection.billing_due_collection", ["paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name]);
    }
    public function cafeBillingDueCollection()
    {
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cafeteria_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.billing.pharmacy.cafe_billing_due_collection", ["paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name]);
    }
    public function posBillingDueCollection()
    {
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("pharmacy_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.billing.pharmacy.pos_billing_due_collection", ["paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name]);
    }
    public function billingCancelation()
    {
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        return Template::loadview("admin.billing.billing_cancelation.billibg_cancelation", ["paymodes" => $paymodes, "disctype" => $disctype, 'service_point' => $service_point]);
    }
    public function billingCancelationEdit()
    {

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type_list=[];
        if (!empty($item_type)) {
            foreach ($item_type as $key => $value) {
                $item_type_list[]=$value->workflow_code;
            }
        }
         $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

        return Template::loadview("admin.billing.billing_cancelation.billibg_cancelation_edit", ["paymodes" => $paymodes, "disctype" => $disctype, "service_point" => $service_point, 'bank_name' => $bank_name,'item_type_lists'=>$item_type_lists]);

        // return Template::loadview("admin.billing.billing_cancelation.billibg_cancelation_edit", ["paymodes" => $paymodes, "disctype" => $disctype, 'service_point' => $service_point]);
    }
    public function jakatNonMuslim()
    {
        $jakat_non_muslim=DB::table('hrms_personnel')->select('full_name','person_no_pk')->whereIn('person_code',['ZAKATFUND','NONMUSLIMFUND'])->get();
        return Template::loadview("admin.billing.billing_cancelation.jakat_non_muslim", ["jakat_non_muslim" => $jakat_non_muslim]);

    }
    public function storeJakatNonMuslim(Request $request)
    {
        try {
            $empty=null;
            if ($request->edit_cance =='0') {
                $data=[
                    'disc_amt_by_doc_no_fk'=>$empty,
                    'disc_amt_by_hosp_auth_by'=>$empty,
                ];
            }else{
                $data=[
                    'disc_amt_by_doc_no_fk'=>$request->edit_cancel,
                    'disc_amt_by_hosp_auth_by'=>$request->edit_cancel,
                ];
            }
           DB::table('finc_ledgermst')->where('invoice_no_fk',$request->voucher_no)->where('trn_type_code','DISCOUNT')->update($data);
           DB::commit();
           $message = ['msg' => 'successfull', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => ' Failled.' , 'title' => 'Error'];
        }
        return response()->json($message);

    }
    public function posCancelation()
    {

        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)
        ->where("GRANTSU_STATUS", "1")
        ->where("pharmacy_ind", "1")
        ->where("status", 1)
        // ->orWhere('cafeteria_ind', '1')
        ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')
        ->orderBy('serviceunit_name', 'asc')
        ->distinct()
        ->get();
        // dd( $service_point );
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        return Template::loadview("admin.billing.pharmacy.pos_cancelation", ["paymodes" => $paymodes, "disctype" => $disctype, 'service_point' => $service_point]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getPosItemsList(Request $request)
    {
        $category_arr = $sub_category_arr = [];
        $category_info = DB::table("sysc_lookupdata_vw")->whereIn("lookup_code", ["ITEMCAT", "ITEMCATSUB", "ITEMCATSUB1", "ITEMCATSUB2"])->get();
        //dd($category_info);
        if (!empty($category_info)) {
            foreach ($category_info as $row) {
                $category_arr[$row->lookup_code][] = $row->lookupdata_no_pk . "_" . $row->lookupdata_name;
                if (isset($sub_category_arr[$row->lookup_code])) {
                    $sub_category_arr[$row->lookup_code]++;
                } else {
                    $sub_category_arr[$row->lookup_code] = 0;
                }
            }
        }

        $item_code = $request->item_code;
        $item_info = DB::table("sysc_serviceitem")->whereRaw("((item_cat_lookupdata_no_fk =$item_code) or (item_subcat_lookupdata_no_fk =$item_code) or (item_sub1cat_lookupdata_no_fk =$item_code) or (item_sub2cat_lookupdata_no_fk =$item_code))")->get();

        return Template::loadview("admin.billing.pharmacy.pos_items_list", ["item_info" => $item_info, "category_arr" => $category_arr]);
    }
    public function get_billing_invoice_list()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt", "ledger_amt_vat")->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rate = DB::select("SELECT SUM(total_item_amt) ledger_amt_sales FROM finc_invoicedtl_vw
        WHERE invoice_no_fk = $voucher_no ");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind is null");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->leftJoin('labt_invoicedtl_vw', function($join) {
                $join->on('labt_invoicedtl_vw.item_no_pk', '=', 'finc_inv_itemdtl_vw.item_no_fk')
                    ->on('labt_invoicedtl_vw.invoice_no_fk', '=', 'finc_inv_itemdtl_vw.invoice_no_fk');
            })
            ->leftJoin('radt_invoicedtl', function($join) {
                $join->on('radt_invoicedtl.item_no_fk', '=', 'finc_inv_itemdtl_vw.item_no_fk')
                    ->on('radt_invoicedtl.invoice_no_fk', '=', 'finc_inv_itemdtl_vw.invoice_no_fk');
            })
            ->where("finc_inv_itemdtl_vw.invoice_no_fk", $voucher_no)
            ->select("finc_inv_itemdtl_vw.invoice_no_fk", "finc_inv_itemdtl_vw.item_name", "finc_inv_itemdtl_vw.item_code", "finc_inv_itemdtl_vw.item_type_name", "finc_inv_itemdtl_vw.item_qty", "finc_inv_itemdtl_vw.item_rate", "finc_inv_itemdtl_vw.delivery_status_lookup_no_fk", "finc_inv_itemdtl_vw.investigation_status", "finc_inv_itemdtl_vw.invoicedtl_no_pk", "finc_inv_itemdtl_vw.report_delivery_date", "finc_inv_itemdtl_vw.disc_perc", "finc_inv_itemdtl_vw.disc_amount", "finc_inv_itemdtl_vw.invoice_no_fk", "finc_inv_itemdtl_vw.item_no_fk", "finc_inv_itemdtl_vw.itemtype_no_fk", "finc_inv_itemdtl_vw.urgent_fee", "finc_inv_itemdtl_vw.cancel_ind", "finc_inv_itemdtl_vw.cancel_qty","finc_inv_itemdtl_vw.item_type","labt_invoicedtl_vw.sc_sample_coll_key_ind",DB::raw("NVL(radt_invoicedtl.ic_image_capture_key_ind, radt_invoicedtl.finalize_key_ind) AS rad_capture_or_finalize_ind"))
            ->orderBy("finc_inv_itemdtl_vw.cancel_ind", "DESC")
            ->get();

        // dd($invoice_item_list);
        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();
        // ->where('ledgertrn_no_pk','=',$trx)
        return Template::loadview("admin.billing.due_collection.cust_info_payment_history_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'bank_name' => $bank_name, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function get_pos_billing_invoice_list()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt")->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rate = DB::select("SELECT SUM(total_item_amt) ledger_amt_sales FROM finc_invoicedtl_vw
        WHERE invoice_no_fk = $voucher_no ");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $c_dis = DB::select("select SUM(disc_amount_phr) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no ");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        // $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
        //     ->where("invoice_no_fk", $voucher_no)
        //     ->select("invoice_no_fk", "item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_ind", "cancel_qty", "disc_amount_phr")
        //     ->orderBy("cancel_ind", "DESC")
        //     ->get();
        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $voucher_no)
            ->select("invoice_no_fk", "item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_ind", "cancel_qty","batch_no","expiry_date","internal_batch_no_uq")
            ->orderBy("cancel_ind", "DESC")
            ->get();

        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();

        return Template::loadview("admin.billing.pharmacy.cust_pos_info_payment_history_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'bank_name' => $bank_name, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function get_cafe_billing_invoice_list()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt")->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rate = DB::select("SELECT SUM(total_item_amt) ledger_amt_sales FROM finc_invoicedtl_vw
        WHERE invoice_no_fk = $voucher_no ");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $c_dis = DB::select("select SUM(disc_amount_phr) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no ");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        // $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
        //     ->where("invoice_no_fk", $voucher_no)
        //     ->select("invoice_no_fk", "item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_ind", "cancel_qty", "disc_amount_phr")
        //     ->orderBy("cancel_ind", "DESC")
        //     ->get();
        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $voucher_no)
            ->select("invoice_no_fk", "item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_ind", "cancel_qty","item_vat","batch_no","expiry_date","internal_batch_no_uq")
            ->orderBy("cancel_ind", "DESC")
            ->get();

        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();

        return Template::loadview("admin.billing.pharmacy.cust_cafe_info_payment_history_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'bank_name' => $bank_name, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }

    public function get_billing_cancel_invoice_list()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt")->first();


        // If linked to an admission, check revenue_ind or lock_ind
        if (!empty($patient_info->admission_no_pk)) {
            $ipd_admission = DB::table('ipd_admission')
                ->where('admission_no_pk', $patient_info->admission_no_pk)
                ->select('revenue_ind', 'lock_ind')
                ->first();

            if (!empty($ipd_admission)) {
                if ($ipd_admission->revenue_ind) {
                    throw new \Exception('This Patient Invoice has already been posted for revenue, cannot be canceled.');
                }
                if ($ipd_admission->lock_ind) {
                    throw new \Exception('This Patient admission is locked and cannot be canceled.');
                }
            }
        }


        $total_sale = DB::select("SELECT SUM(ledger_amt_sales) ledger_amt_sales, SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk=$voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rates = DB::table('finc_vouchermst_sum_vw')->where('invoice_no_pk', $voucher_no)->first();


        // $total_item_rate = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment, SUM(ledger_amt_sales_can) ledger_amt_sales_can  FROM finc_invoicemst_sum_vw
        // WHERE invoice_no_pk = $voucher_no");
        // foreach ($total_item_rate as $value) {

        //     $total_item_rates =$value->ledger_amt_payment + $value->ledger_amt_sales_can;

        // }

        $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind is null");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        // dd($total_sales);

        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->distinct()
            ->leftJoin('labt_invoicedtl_vw', function($join) {
                $join->on('labt_invoicedtl_vw.item_no_pk', '=', 'finc_inv_itemdtl_vw.item_no_fk')
                    ->on('labt_invoicedtl_vw.invoice_no_fk', '=', 'finc_inv_itemdtl_vw.invoice_no_fk');
            })
            ->leftJoin('radt_invoicedtl', function($join) {
                $join->on('radt_invoicedtl.item_no_fk', '=', 'finc_inv_itemdtl_vw.item_no_fk')
                    ->on('radt_invoicedtl.invoice_no_fk', '=', 'finc_inv_itemdtl_vw.invoice_no_fk');
            })
            ->where("finc_inv_itemdtl_vw.invoice_no_fk", $voucher_no)
            ->select("finc_inv_itemdtl_vw.item_name", "finc_inv_itemdtl_vw.item_code", "finc_inv_itemdtl_vw.item_type_name", "finc_inv_itemdtl_vw.item_qty", "finc_inv_itemdtl_vw.item_rate", "finc_inv_itemdtl_vw.delivery_status_lookup_no_fk", "finc_inv_itemdtl_vw.investigation_status", "finc_inv_itemdtl_vw.invoicedtl_no_pk", "finc_inv_itemdtl_vw.report_delivery_date", "finc_inv_itemdtl_vw.disc_perc", "finc_inv_itemdtl_vw.disc_amount", "finc_inv_itemdtl_vw.invoice_no_fk", "finc_inv_itemdtl_vw.item_no_fk", "finc_inv_itemdtl_vw.itemtype_no_fk", "finc_inv_itemdtl_vw.urgent_fee", "finc_inv_itemdtl_vw.cancel_qty", "finc_inv_itemdtl_vw.item_vat", "finc_inv_itemdtl_vw.current_item_qty","finc_inv_itemdtl_vw.item_type","labt_invoicedtl_vw.sc_sample_coll_key_ind",DB::raw("NVL(radt_invoicedtl.ic_image_capture_key_ind, radt_invoicedtl.finalize_key_ind) AS rad_capture_or_finalize_ind"))
            ->orderBy("finc_inv_itemdtl_vw.cancel_qty", "DESC")
            ->get();
        // dd( $invoice_item_list);
        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();
        $apiDiscount_ind=DB::table('finc_ledgermst')->select('apidiscount_type')->where('invoice_no_fk',$voucher_no)->first();
        return Template::loadview("admin.billing.billing_cancelation.cust_info_cancel_histry_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'apiDiscount_ind'=>$apiDiscount_ind]);
    }
    public function get_billing_cancel_invoice_list_edit()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt", "ledger_amt_vat")->first();

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rate = DB::select("SELECT SUM(total_item_amt) ledger_amt_sales FROM finc_invoicedtl_vw
        WHERE invoice_no_fk = $voucher_no ");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind is null");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $voucher_no)
            ->select("invoice_no_fk", "item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_ind", "cancel_qty")
            ->orderBy("cancel_ind", "DESC")
            ->get();



        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();
        // ->where('ledgertrn_no_pk','=',$trx)

        $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type_list=[];
        if (!empty($item_type)) {
            foreach ($item_type as $key => $value) {
                $item_type_list[]=$value->workflow_code;
            }
        }
         $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

        return Template::loadview("admin.billing.billing_cancelation.cust_info_cancel_histry_item_list_edit", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'bank_name' => $bank_name, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'item_type_lists'=>$item_type_lists]);
        // return Template::loadview("admin.billing.billing_cancelation.cust_info_cancel_histry_item_list_edit", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }


    public function get_billing_pos_cancel_invoice_list()
    {
        $voucher_no = $_GET['voucher_no'];
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("invoice_no_pk", $voucher_no)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt")->first();

        // If linked to an admission, check revenue_ind or lock_ind
        if (!empty($patient_info->admission_no_pk)) {
            $ipd_admission = DB::table('ipd_admission')
                ->where('admission_no_pk', $patient_info->admission_no_pk)
                ->select('revenue_ind', 'lock_ind')
                ->first();

            if (!empty($ipd_admission)) {
                if ($ipd_admission->revenue_ind) {
                    throw new \Exception('This Patient Invoice has already been posted for revenue, cannot be canceled.');
                }
                if ($ipd_admission->lock_ind) {
                    throw new \Exception('This Patient admission is locked and cannot be canceled.');
                }
            }
        }

        $total_sale = DB::select("SELECT SUM(ledger_amt_sales) ledger_amt_sales, SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk=$voucher_no");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }

        $total_item_rate = DB::select("SELECT ledger_amt_dis_can, ledger_amt_payment , ledger_amt_sales_can FROM finc_invoicemst_sum_vw
        WHERE invoice_no_pk = $voucher_no");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $c_dis = DB::select("select SUM(disc_amount_phr) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no ");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $voucher_no and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        // $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
        //     ->where("invoice_no_fk", $voucher_no)
        //     ->select("item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount_phr", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_qty")
        //     ->orderBy("cancel_qty", "DESC")
        //     ->get();
        //test code for live
        $invoice_item_list = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $voucher_no)
            ->select("item_name", "item_code", "item_type_name", "item_qty", "item_rate", "delivery_status_lookup_no_fk", "investigation_status", "invoicedtl_no_pk", "report_delivery_date", "disc_perc", "disc_amount", "invoice_no_fk", "item_no_fk", "itemtype_no_fk", "urgent_fee", "cancel_qty", "item_vat", "current_item_qty","expiry_date","batch_no","internal_batch_no_uq",DB::raw("'' as apidiscount_type"))
            ->orderBy("cancel_qty", "DESC")
            ->get();

        $invoice_pay_dis_his = DB::table("finc_ledgermst_paydisc_vw")->where("invoice_no_pk", $voucher_no)->select("*")->where("ledger_amt_sales", 0)->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'),DB::raw('sum(ledger_amt_vat_cancel) as ledger_amt_vat_cancel'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('invoice_no_pk', $voucher_no)
            ->groupby('invoice_no_pk')
            ->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $voucher_no)
            ->first();
        $apiDisType=DB::table('finc_ledgermst')->select('apidiscount_type')->where('invoice_no_fk', $voucher_no)->first();
        return Template::loadview("admin.billing.pharmacy.cust_info_pos_cancel_histry_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'apiDisType'=>$apiDisType]);
    }
    public function due_collection_invoice($invoice_id, $trx = "")
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $l_date = isset($ledger_no->ledger_code) ? $ledger_no->ledger_code : 0;

        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();

        // dd($paymood);

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('bill_type','invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','au_entry_at','patient_type_code','age','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy("cancel_qty", "DESC")
            ->get();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        return Template::loadView("admin.billing.due_collection.due_collection_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'paymood' => $paymood, 'ledger_no' => $ledger_no, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'preparedBy' => $preparedBy, 'bed_details' => $bed_details]);
    }
    public function invoice_edit($invoice_id, $trx = "")
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no = DB::table("finc_ledgermst")
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $l_date = isset($ledger_no->ledger_code) ? $ledger_no->ledger_code : 0;

        $ledger_payment = DB::table("FINC_LEDGER_PAYMOOD")
            ->select(DB::raw("SUM(pay_amount) as pay_amount"))
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();

        if (isset($ledger_payment)) {
            foreach ($ledger_payment as $value) {
                $ledger_pay_amount = $value;
            }
        }

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();

        // dd($paymood);

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }

        $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk = $invoice_id");
        foreach ($total_discount as $dis) {
            $total_dis = $dis;
        }

        $total_item_rate = DB::select("SELECT SUM(ledger_amt_sales) ledger_amt_sales, SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
    WHERE invoice_no_pk=$invoice_id");
        foreach ($total_item_rate as $value) {
            $total_item_rates = $value;
        }

        $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind is null");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }
        $item_sub_total = DB::select("select SUM(item_rate*item_qty) item_rate FROM finc_invoicedtl where invoice_no_fk = $invoice_id and cancel_ind is null");
        foreach ($item_sub_total as $value) {
            $sub_total = $value->item_rate;
        }

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy("cancel_qty", "DESC")
            ->get();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        return Template::loadView("admin.billing.due_collection.due_collection_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info, 'pay_mode' => $paymodes, 'total_sales' => $total_sales, 'total_dis' => $total_dis, 'paymood' => $paymood, 'ledger_no' => $ledger_no, 'ledger_pay_amount' => $ledger_pay_amount, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'sub_total' => $sub_total, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'preparedBy' => $preparedBy, 'bed_details' => $bed_details]);
    }
    public function invoiceEdit($invoice_id, $trx = "")
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();
        // dd( $invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy("cancel_qty", "DESC")
            ->get();
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.due_collection.invoice_edit", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info,  'po_hospital_details' => $po_hospital_details, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function invoiceUpdate(Request $request)
    {


        try {

            $data = [
                'person_no_fk' => $request->doc_ref ?? "",
                'first_ref_doc_person_no_fk' => $request->first_ref ?? "",
                'second_ref_doc_person_no_fk' => $request->second_ref ??  "",
                'invoice_remarks' => $request->remarks ??  "",
            ];
            //    dd(  $data);
            DB::table('finc_invoicemst')->where('invoice_no_pk', $request->invoice_no)->update($data);
            DB::commit();
            $message = ['msg' => 'Successfull', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function pos_due_collection_invoice($invoice_id, $trx = "")
    {

        $po_hospital_details = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("trn_type_code", 'PAYMENT')
            ->where("ledgertrn_no_fk", $trx)
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
            ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $l_date = !empty($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;

        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
        ->select('pay_mood_type','pay_amount','paymood')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();

        // dd($paymood);

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "disc_amount", "cancel_qty", "current_item_qty", "item_no_fk")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "disc_amount", "cancel_qty", "current_item_qty", "item_no_fk")
            ->orderBy("cancel_qty", "DESC")
            ->get();

            $exp_detail = DB::table("finc_invoicedtl_vw")
                ->where("invoice_no_fk", $invoice_id)
                ->select("item_no_fk")
                ->get();

            foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
                // ->where("ITEM_NO_FK", $value->item_no_fk)
                // ->groupBy("item_no_fk")
                ->get();
        }

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','refund','collection')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();


        return Template::loadView("admin.billing.pharmacy.pos_due_collection_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,   'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'exp_date' => $exp_date, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function billing_cancelation_invoice($invoice_id, $trx = "")
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $invoice_mst_info = DB::table("FINC_INVOICEMST_SUM_VW")
        ->leftJoin('finc_invoicemst','FINC_INVOICEMST_SUM_VW.invoice_no_pk','=','finc_invoicemst.invoice_no_pk')
        ->select('finc_invoicemst_sum_vw.invoice_code','finc_invoicemst_sum_vw.patient_code','finc_invoicemst_sum_vw.patient_name','finc_invoicemst_sum_vw.dob','finc_invoicemst_sum_vw.gender_txt','finc_invoicemst_sum_vw.mobile1','finc_invoicemst_sum_vw.present_addr','finc_invoicemst_sum_vw.doctor_name','finc_invoicemst_sum_vw.first_doc_name','finc_invoicemst_sum_vw.person_code','finc_invoicemst_sum_vw.second_doc_name','finc_invoicemst_sum_vw.report_delivary_date','finc_invoicemst_sum_vw.invoice_date','finc_invoicemst_sum_vw.report_delivary_datetime','finc_invoicemst_sum_vw.admission_no_pk','finc_invoicemst_sum_vw.au_entry_at','finc_invoicemst_sum_vw.patient_type_code','finc_invoicemst_sum_vw.age','finc_invoicemst_sum_vw.ledger_amt_discount','finc_invoicemst_sum_vw.invoice_remarks','finc_invoicemst_sum_vw.invoice_no_pk','finc_invoicemst.bill_type')
            ->where("FINC_INVOICEMST_SUM_VW.invoice_no_pk", $invoice_id)
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy("cancel_qty", "DESC")
            ->get();


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), 'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.billing.billing_cancelation.cancelation_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'po_hospital_details' => $po_hospital_details, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }

    public function pos_cancelation_invoice($invoice_id, $trx = "")
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('patient_code','patient_name','admission_no_pk','present_addr','mobile1','age','gender_txt','doctor_name','first_doc_name','second_doc_name','au_entry_at','invoice_code','invoice_remarks','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "item_no_fk","cancel_qty","item_vat")
            ->orderBy("cancel_qty", "DESC")
            ->get();

        $c_fee = DB::select("select SUM(urgent_fee) urgent_fee FROM finc_invoicedtl_vw where invoice_no_fk = $invoice_id ");
        foreach ($c_fee as $value) {
            $c_urgent_fee = $value;
        }


        $cancel_refund = DB::select("SELECT A.LAST_CAN_QTY,A.URGENT_FEE as cancel_urgent_fee FROM (select sum(DTL.CANCEL_QTY) LAST_CAN_QTY,
        SUM(LMST.urgent_fee)urgent_fee,DTL.au_ENTRY_AT, mst.invoice_no_pk from finc_invoicemst mst join
        finc_ledgermst lmst on mst.invoice_no_pk=lmst.invoice_no_fk
        join finc_ledgerdtl dtl
        on dtl.ledger_no_fk=lmst.ledger_no_pk
        where LMST.TRN_TYPE_CODE='SALESR' and mst.invoice_no_pk=$invoice_id
        GROUP BY DTL.au_ENTRY_AT, mst.invoice_no_pk
        ORDER BY DTL.au_ENTRY_AT DESC) A
        where ROWNUM=1");
        if ($cancel_refund) {
            foreach ($cancel_refund as $value) {
                $cancel_fee = $value;
            }
        } else {
            $cancel_fee = [];
        }

        $exp_detail = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_no_fk")
            ->get();

        foreach ($exp_detail as $value) {
            $exp_date = DB::table("phr_pharmacy_vw")
                ->select("expiry_date", "item_no_fk", "batch_no")
                ->where("invoice_no_fk", $invoice_id)
               ->get();
        }


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_pk', $invoice_id)
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select('ledgertrn_no_pk','refund')
            ->where('invoice_no_pk', $invoice_id)
            ->where('ledgertrn_no_pk', '=', $trx)
            ->first();

        return Template::loadView("admin.billing.pharmacy.pos_cancelation_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'po_hospital_details' => $po_hospital_details,  'exp_date' => $exp_date, 'c_urgent_fee' => $c_urgent_fee, 'cancel_fee' => $cancel_fee,  'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function store_due_collection(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            return $this->billingRepository->dueCollectV1($request, $request->id);
        } else {
            return $this->billingRepository->dueCollect($request, $request->id);
        }
    }
    public function store_invoice_edit(Request $request)
    {
        try {
            DB::beginTransaction();

            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d h:i:s', strtotime($time));
            $cur_datetime = date('Y-m-d h:i:s', strtotime($time));
            $hospital_dis = ($request->discount_amt != "") ? $request->discount_amt : 0;
            $doctor_dis = ($request->doctor_amt != "") ? $request->doctor_amt : 0;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $entry_session = "session";
            $auth_id = Auth::id();
            $item_level_disc_ind = 1;
            $total_item = count($request->hdn_item_id);
            $null = '';
            $invoice_no = $request->hdn_invoice_id;
            $item_no = $invoice_dtl = $item_name = $item_type_no = $item_qty = $item_rate = $item_dis_perc = $item_dis_amt = $item_vat = $urgent_fee = $service_charge = $delivery_date = $delivery_time = $delivery_status_no = $pkg_ind = $provider_no = $editable_ind = $remarks = [];
            for ($i = 0; $i < $total_item; $i++) {
                $invoice_dtl[$i] = $request->hdn_invoice_dtl_no[$i];
                $item_no[$i] = $request->hdn_item_id[$i];
                $item_name[$i] = $request->hdn_item_name[$i];
                $item_type_no[$i] = $request->hdn_item_type[$i];
                $item_qty[$i] = $request->edit_qty_[$i] != "" ? $request->edit_qty_[$i] : $request->old_qty_[$i];
                $item_rate[$i] = $request->hdn_item_rate[$i];
                $item_dis_perc[$i] = 0;
                $item_dis_amt[$i] = $request->item_dis_amt[$i] ? $request->item_dis_amt[$i]  : 0;
                $item_vat[$i] = 0;
                $urgent_fee[$i] = $request->hdn_item_urgent_fee[$i] ?? 0;
                $service_charge[$i] = $request->ipd_charge[$i] ?? 0;
                $delivery_date[$i] = null;
                $delivery_time[$i] = null;
                $delivery_status_no[$i] = $request->item_delivery_status[$i];
                $pkg_ind[$i] = null;
                $provider_no[$i] = $request->hdn_provider_no[$i];
                $editable_ind[$i] = $request->edit_ind[$i];
                $remarks[$i] = null;
            }
            // dd( $item_dis_amt);
            $numelems = 100;
            $in_ledgertrn_no = $out_invoice_no2 = $out_error = $out_ledger_no = $out_ledgertrn_no = $out_invoice_no = "";
            $pdo1 = DB::getPdo();
            $invoiceEdit = $pdo1->prepare("begin pkg_billing_v0.prc_billinvoice_edit(
        :in_invoice_no_pk,
        :in_au_entry_by,
        :in_au_entry_session,
        :in_au_entry_hospital_pk_no,
        :in_item_level_disc_ind,
        :in_item_count,
        :in_invoicedtl_no_pk,
        :in_ITEM_NO_FK,
        :in_ITEM_NAME,
        :in_ITEMTYPE_NO_FK,
        :in_ITEM_QTY,
        :in_ITEM_RATE,
        :in_item_disc_percent,
        :in_item_disc_amount,
        :in_ITEM_VAT,
        :in_URGENT_FEE,
        :in_SERVICE_CHARGE,
        :in_REPORT_DELIVERY_DATE,
        :in_REPORT_DELIVERY_TIME,
        :in_DELIVERY_STATUS_LOOKUP_NO_FK,
        :in_PACKAGE_ITEM_IND,
        :in_PROVIDER_NO_FK,
        :in_edited_ind,
        :in_item_level_remarks,
        :out_invoice_no,
        :out_invoice_id,
        :out_ledgertrn_no,
        :out_error);
        end;");

            $invoiceEdit->bindParam(':in_invoice_no_pk', $invoice_no);
            $invoiceEdit->bindParam(':in_au_entry_by', $auth_id);
            $invoiceEdit->bindParam(':in_au_entry_session', $entry_session);
            $invoiceEdit->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $invoiceEdit->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
            $invoiceEdit->bindParam(':in_item_count', $total_item);

            $invoiceEdit->bindArray(':in_invoicedtl_no_pk', $invoice_dtl, count($invoice_dtl), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_item_no_fk', $item_no, count($item_no), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_item_name', $item_name, count($item_name), $numelems, SQLT_CHR);
            $invoiceEdit->bindArray(':in_itemtype_no_fk', $item_type_no, count($item_type_no), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_item_rate', $item_rate, count($item_rate), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_item_disc_percent', $item_dis_perc, count($item_dis_perc), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_item_vat', $item_vat, count($item_vat), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_urgent_fee', $urgent_fee, count($urgent_fee), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_service_charge', $service_charge, count($service_charge), $numelems, SQLT_FLT);
            $invoiceEdit->bindArray(':in_report_delivery_date', $delivery_date, count($delivery_date), $numelems, SQLT_CHR);
            $invoiceEdit->bindArray(':in_report_delivery_time', $delivery_time, count($delivery_time), $numelems, SQLT_CHR);
            $invoiceEdit->bindArray(':in_delivery_status_lookup_no_fk', $delivery_status_no, count($delivery_status_no), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_package_item_ind', $pkg_ind, count($pkg_ind), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_edited_ind', $editable_ind, count($editable_ind), $numelems, SQLT_INT);
            $invoiceEdit->bindArray(':in_item_level_remarks', $remarks, count($remarks), $numelems, SQLT_CHR);
            $invoiceEdit->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $invoiceEdit->bindParam(':out_invoice_id', $out_invoice_no, PDO::PARAM_STR, 500);
            $invoiceEdit->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $invoiceEdit->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($invoiceEdit);
            $invoiceEdit->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
            } else {
                DB::commit();
                $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function deleteInvoice(Request $request)
    {
        try {
            if ($request->voucher_no == "") {

                $message = ['msg' => 'Invoice No Empty.', 'title' => 'Error'];
                return response()->json($message);
            }
            DB::beginTransaction();
            $invice_no = $request->voucher_no;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $entry_session = "session";
            $auth_id = Auth::id();
            $out_invoice_no = $out_error = '';

            $numelems = 100;
            $pdo1 = DB::getPdo();
            $invoiceDelete = $pdo1->prepare("begin pkg_billing_v0.prc_billinvoice_delete(
        :in_invoice_no_fk,
        :in_au_entry_by,
        :in_au_entry_session,
        :in_au_entry_hospital_pk_no,
        :out_error
       );
        end;");

            $invoiceDelete->bindParam(':in_invoice_no_fk', $invice_no);
            $invoiceDelete->bindParam(':in_au_entry_by', $auth_id);
            $invoiceDelete->bindParam(':in_au_entry_session', $entry_session);
            $invoiceDelete->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $invoiceDelete->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($invoiceDelete);
            $invoiceDelete->execute();

            if ($out_error != 000) {
                DB::rollback();
                $message = ['msg' => $out_error, 'title' => 'Error'];
            } else {
                DB::commit();
                $message = ['msg' => 'Invoice Deleted .Invoice ID = ' . $out_invoice_no, 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Invoice Delete Fail'];
        }
        return response()->json($message);
    }
    public function store_cancelation(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            return $this->billingRepository->cancelationV1($request);
        } else {
            return $this->billingRepository->cancelation($request);
        }
    }
    public function ipdItemCancel(Request $request)
    {

        if (Session::get('user.ses_hospital_version') == "V0") {
            return $this->billingRepository->ipdCancelationV1($request);
        }
    }
    public function store_pos_cancelation(Request $request)
    {
        if (Session::get('user.ses_hospital_version') == "V0") {
            return $this->billingRepository->pos_cancelation_v1($request);
        } else {
            return $this->billingRepository->pos_cancelation($request);
        }
    }

    public function getAutoItemName(Request $request)
    {
        $item_id = $request->item_id;
        $auto_item_details = DB::table('sysc_serviceitem_auto_vw')->where('item_no_fk', $request->item_id)->where('status', 1)->get();

        // $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();
        //discount_cal 1 used for not calculating discount in service billing
        $corporate_id =  $request->ccm_client_no_pk != "" ? $request->ccm_client_no_pk : 0;
        $patient_type = $request->patient_type != "" ? $request->patient_type : 0;
        $item_details_arr = [];
        if (!empty($auto_item_details)) {
            foreach ($auto_item_details as $details_item_auto) {

                $sales_price = $details_item_auto->sales_price != "" ? $details_item_auto->sales_price : 0;
                $discount = $details_item_auto->default_discount != "" ? $details_item_auto->default_discount : 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details_item_auto->auto_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));

                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details_item_auto->auto_item_no_fk,$patient_type,$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));

                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                    "serviceunit_name" => $details_item_auto->serviceunit_name,
                    "auto_item_no_fk" => $details_item_auto->auto_item_no_fk,
                    "item_name" => $details_item_auto->item_name,
                    "lookupdata_uid" =>  "LAB",
                    "sales_price" => $rate[0]->item_rate ?? $details_item_auto->sales_price,
                    "vat_percent" =>  $details_item_auto->vat_percent,
                    "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                    "item_type" =>  $details_item_auto->itemtype_no_fk,
                    "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                    "item_code" =>  $details_item_auto->item_code,
                    "item_id" =>  $details_item_auto->item_code,
                    "discount_applicable_ind" => $details_item_auto->disc_aplicable != null ?  $details_item_auto->disc_aplicable : 0,
                    "default_discount" =>$def_dis[0]->def_discount  != "" && $details_item_auto->disc_aplicable != 1 ? $details_item_auto->default_discount : 0,
                    'ipd_charge' => 0,
                ];
            }
        }
        // dd($item_details_arr);
        return response()->json($item_details_arr);
    }
    public function getAutoItemNameV1(Request $request)
    {
        $item_id = $request->item_id;
        $auto_item_details = DB::table('sysc_serviceitem_auto_vw')->where('item_no_fk', $request->item_id)->where('status', 1)->orderBy('autoitemlst_no_pk','asc')->get();


        // $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();
        //discount_cal 1 used for not calculating discount in service billing
        $corporate_id =  $request->ccm_client_no_pk != "" ? $request->ccm_client_no_pk : 0;
        $patient_type = $request->patient_type != "" ? $request->patient_type : 0;
        $item_details_arr = [];
        if (!empty($auto_item_details)) {
            foreach ($auto_item_details as $details_item_auto) {

                $sales_price = $details_item_auto->sales_price != "" ? $details_item_auto->sales_price : 0;
                $discount = $details_item_auto->default_discount != "" ? $details_item_auto->default_discount : 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details_item_auto->auto_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));

                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details_item_auto->auto_item_no_fk,$patient_type,$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));

                $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                    "serviceunit_name" => $details_item_auto->serviceunit_name,
                    "auto_item_no_fk" => $details_item_auto->auto_item_no_fk,
                    "item_name" => $details_item_auto->item_name,
                    "lookupdata_uid" =>  "LAB",
                    "sales_price" => $rate[0]->item_rate ?? $details_item_auto->sales_price,
                    "vat_percent" =>  $details_item_auto->vat_percent,
                    "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                    "item_type" =>  $details_item_auto->itemtype_no_fk,
                    "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                    "item_code" =>  $details_item_auto->item_code,
                    "item_id" =>  $details_item_auto->item_code,
                    "discount_applicable_ind" => $details_item_auto->disc_aplicable != null ?  $details_item_auto->disc_aplicable : 0,
                    "default_discount" => $def_dis[0]->def_discount  != "" && $details_item_auto->disc_aplicable != 1 ? $details_item_auto->default_discount : 0,
                    'ipd_charge' => 0,
                ];
            }
        }
        // dd($item_details_arr);
        return response()->json($item_details_arr);
    }
    public function patientTotalDueCalculation(Request $request)
    {
        $html = '';
        if (Session::get('user.ses_hospital_code') == 'GMC') {
            $pdo = DB::getPdo();
            $cal_patient_due = $pdo->prepare("begin pkg_tools.prc_get_patient_due(
            :in_hospital_no_pk,
            :in_patient_no_pk,
            :in_admission_no_pk,
            :out_bill_amt,
            :out_discount_amt,
            :out_paid_amt,
            :out_due_amt);
            end;");
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $patient_no_fk = $request->patient_id;
            $in_admission_no_pk = isset($request->admission_no_pk) ? $request->admission_no_pk : 0;
            $out_bill_amt = '';
            $out_discount_amt = '';
            $out_paid_amt = '';
            $out_due_amt = '';
            $cal_patient_due->bindParam(':in_hospital_no_pk', $ses_hospital_id);
            $cal_patient_due->bindParam(':in_patient_no_pk', $patient_no_fk);
            $cal_patient_due->bindParam(':in_admission_no_pk', $in_admission_no_pk);
            $cal_patient_due->bindParam(':out_bill_amt', $out_bill_amt, PDO::PARAM_STR, 500);
            $cal_patient_due->bindParam(':out_discount_amt', $out_discount_amt, PDO::PARAM_STR, 500);
            $cal_patient_due->bindParam(':out_paid_amt', $out_paid_amt, PDO::PARAM_STR, 500);
            $cal_patient_due->bindParam(':out_due_amt', $out_due_amt, PDO::PARAM_STR, 500);
            $cal_patient_due->execute();


            if (isset($out_bill_amt)) {
                $html .= '  <strong>Patient Total Bill:</strong>
            <span class="btn btn-outline-danger btn-md"
                id="patient_total_available_due">' . $out_bill_amt . '</span>';
            }

            if (isset($out_discount_amt)) {
                $html .= '  <strong>Total Discount:</strong>
            <span class="btn btn-outline-danger btn-md"
                id="patient_total_available_due">' . $out_discount_amt . '</span>';
            }

            if (isset($out_paid_amt)) {
                $html .= '  <strong>Total Advance:</strong>
            <span class="btn btn-outline-danger btn-md"
                id="patient_total_available_due">' . $out_paid_amt . '</span>';
            }

            if (isset($out_due_amt)) {
                $html .= '  <strong>Total Due:</strong>
            <span class="btn btn-outline-danger btn-md"
                id="patient_total_available_due">' . $out_due_amt . '</span>';
            }
        }
        return $html;
    }


    public function due_invoice_ipd_print($invoice_id, $trx = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.disc_amt_by_doc_no_fk')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();
        // dd($discout_by);

        $ledger_no = DB::table("finc_ledgermst")
        ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','au_entry_by','second_doc_person_code')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();
        //bed information added
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }


        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $invoice_dtls_info = DB::table("finc_v0_inv_itemdtl_vw ")
                ->where("invoice_no_fk", $invoice_id)
                ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no", "ledger_amt_deposite")
                ->orderBy("cancel_qty", "DESC")
                ->orderBy('su_sl_no', 'asc')
                ->orderBy('invoicedtl_no_pk', 'asc')
                ->get();
        } else {
            $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
                ->where("invoice_no_fk", $invoice_id)
                ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")
                ->orderBy("cancel_qty", "DESC")
                ->orderBy('su_sl_no', 'asc')
                ->orderBy('invoicedtl_no_pk', 'asc')
                ->get();
        }

        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), DB::raw('sum(ledger_amt_deposite) as ledger_amt_deposite'),  'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();
            $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        } else {
            $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(service_charge) as service_charge'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'),  'invoice_no_pk')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk')->first();
            $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        }




        $userInfo = Auth::user();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

            $return_reson= DB::table("finc_ledgermst")
            ->select('refund_reason')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'SALESR')
            ->first();
            $payment_status=DB::table('finc_ledgermst')->select('pay_type')->where('invoice_no_fk',$invoice_id)->where('trn_type_code','PAYMENT')->first();
        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_ipd_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'return_reson'=>$return_reson,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
        } else {
            $pdf = PDF::loadView("admin.billing.due_collection.due_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no,   'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount,'payment_status'=>$payment_status])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function due_collection_ipd_invoice($invoice_id, $trx = "")
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no = DB::table("finc_ledgermst")
        ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name', 'mst.ledger_no_pk')->orderby('mst.ledger_no_pk', 'desc')->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $l_date = isset($ledger_no->ledger_code) ? $ledger_no->ledger_code : 0;

        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','au_entry_by')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy("cancel_qty", "DESC")
            ->get();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(sales_cancel) as sales_cancel'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_cancel) as service_charge_cancel'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();
        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();

        return Template::loadView("admin.billing.due_collection.due_collection_ipd_invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'paymood' => $paymood, 'ledger_no' => $ledger_no,  'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'preparedBy' => $preparedBy, 'bed_details' => $bed_details]);
    }

    public function deleteItemInvoice(Request $request)
    {
        try {
            if ($request->voucher_no == "") {

                $message = ['msg' => 'Invoice No Empty.', 'title' => 'Error'];
                return response()->json($message);
            }
            $invice_no = $request->voucher_no;
            $due_payment = $request->due_payment;
            $invoice_info =  DB::table('finc_invoicemst')->where('invoice_no_pk',$invice_no )->first();
            $module_no_fk =  $invoice_info->module_no_fk;
            $admission_no_pk =  $invoice_info->admission_no_pk;
            $counter_su_no_fk =  $invoice_info->counter_su_no_fk;
            $in_refund_reason = null;

            DB::beginTransaction();
            //dd($request->all(),  $invoice_info);
            $item_id = $request->item_id;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $entry_session = "Invoice Dlt";
            $auth_id = Auth::id();
            $out_invoice_no = 0;
            $out_invoice_id = $out_error = '';
            $in_cancel_date = date('Y-m-d');
            $numelems = 100;
            $pdo1 = DB::getPdo();
            $invoiceDelete = $pdo1->prepare("begin pkg_billing_v0.prc_invoice_item_delete(
                :in_cancel_date,
                :in_canceled_by_user_no_fk,
                :in_invoice_no_fk,
                :in_item_no_fk,
                :in_refund_amount,
                :in_refund_reason,
                :in_module_no_fk,
                :in_admission_no_fk,
                :in_counter_su_no_fk,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_invoice_no,
                :out_invoice_id,
                :out_error
                );
                end;");

            $invoiceDelete->bindParam(':in_cancel_date', $in_cancel_date);
            $invoiceDelete->bindParam(':in_canceled_by_user_no_fk', $auth_id);
            $invoiceDelete->bindParam(':in_invoice_no_fk', $invice_no);
            $invoiceDelete->bindParam(':in_item_no_fk', $item_id);
            $invoiceDelete->bindParam(':in_refund_amount', $due_payment);
            $invoiceDelete->bindParam(':in_refund_reason', $in_refund_reason);
            $invoiceDelete->bindParam(':in_module_no_fk', $module_no_fk);
            $invoiceDelete->bindParam(':in_admission_no_fk', $admission_no_pk);
            $invoiceDelete->bindParam(':in_counter_su_no_fk', $counter_su_no_fk);
            $invoiceDelete->bindParam(':in_au_entry_by', $auth_id);
            $invoiceDelete->bindParam(':in_au_entry_session', $entry_session);
            $invoiceDelete->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $invoiceDelete->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $invoiceDelete->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
            $invoiceDelete->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($invoiceDelete);
            $invoiceDelete->execute();

            if ($out_error != 000) {
                DB::rollback();
                $message = ['msg' => $out_error, 'title' => 'Error'];
            } else {
                DB::commit();
                $message = ['msg' => 'Invoice Item Deleted .Invoice ID = ' . $out_invoice_no, 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Invoice Delete Fail'];
        }
        return response()->json($message);
    }


    // pharmacy pos bill generate
    public function pharmacyPOSBillGenerate($admission_id = "",$moduleNo="")
    {

        $pay_mode = ["CS" => "Cash"];
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $category_arr = $sub_category_arr = [];
        $category_info = DB::table("sysc_lookupdata_vw")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->whereIn("lookup_code", ["ITEMCAT", "ITEMCATSUB", "ITEMCATSUB1", "ITEMCATSUB2"])->get();
        // dd($disctype);
        if (!empty($category_info)) {
            foreach ($category_info as $row) {
                $category_arr[$row->lookup_code][] = $row->lookupdata_no_pk . "_" . $row->lookupdata_name;
                if (isset($sub_category_arr[$row->lookup_code])) {
                    $sub_category_arr[$row->lookup_code]++;
                } else {
                    $sub_category_arr[$row->lookup_code] = 0;
                }
            }
        }
        $service_point = GrantUserService::where('pharmacy_ind', '1') //->orWhere('hs_pos_ind', 1)
                        ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind', 'hs_pos_ind')
                        ->where('user_no_pk', Auth::id())
                        ->where('sub_store_ind', 1)
                        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                        ->orderBy('serviceunit_name', 'asc')
                        ->distinct()
                        ->get();
                        $module = DB::table('sysc_module')->where('phr_ind',1)->where('status',1)->select('module_code','module_name')->get();
        // dd($category_arr,$sub_category_arr);
        return Template::loadview("admin.billing.pharmacy.bill_generate.pos_bill_generate", ["category_arr" => $category_arr, "sub_category_arr" => $sub_category_arr, 'paymodes' => $paymodes, 'service_point' => $service_point, '$pay_mode' => $pay_mode, 'disctype' => $disctype, 'bank_name' => $bank_name,'admission_id' => $admission_id,'module'=>$module,'moduleNo'=>$moduleNo]);
    }

      public function indentBillGenerate($med_req_id = ""){
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $service_point = GrantUserService::where('pharmacy_ind', '1')
                                            ->select(
                                                    'serviceunit_no_pk',
                                                    'serviceunit_name',
                                                    'serviceunit_code',
                                                    'default_ind',
                                                    'hs_pos_ind'
                                                )
                                            ->where('user_no_pk', Auth::id())
                                            ->where('ipdphr_ind', 1)
                                            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                                            ->orderBy('serviceunit_name', 'asc')
                                            ->distinct()
                                            ->get();


        // $admission_id = DB::table('phr_ipdpatmedtran')->where('med_req_id',$med_req_id)->whereNotNull('admission_no_fk')->value('admission_no_fk');
        $module = DB::table('sysc_module')->where('phr_ind',1)->where('status',1)->select('module_code','module_name')->get();
        // $admission_id = DB::table('phr_ipdpatmedtran')->where('med_req_id',$med_req_id)->whereNotNull('admission_no_fk')->value('admission_no_fk');
        $admission_id = DB::table('phr_ipdpatmedtran')
                    ->where('med_req_id', $med_req_id)
                    ->whereNotNull('admission_no_fk')
                    ->select('admission_no_fk', 'pres_no_fk') // replace with your 2nd column
                    ->first();
        // dd($med_req_id, $admission_id );

        return Template::loadview("admin.billing.pharmacy.bill_generate.pos_indent_bill_generate", [
                                    'service_point' => $service_point,
                                    'disctype' => $disctype,
                                    'bank_name' => $bank_name,
                                    'med_req_id' => $med_req_id,
                                    'admission_id' => $admission_id,
                                    'module' => $module,
                                ]);
    }

    public function opdList(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_code = $request->hdn_doctor_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;
        $patient_type_no = $request->patient_type_no;

        $opd = 'due > 1'; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_pk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_type_no != "" ? " $clause patient_type = $patient_type_no " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 1" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $sql_cond != "" ? "$clause module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')"  : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0"  : "";

        $table = 'finc_v1_opd_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        // $to_date = date('Y-m-d');
        // $hospital_id =  Session::get('user.ses_hospital_no_pk');
        // $where = "trunc(INVOICE_DATE) = '$to_date' and au_entry_hospital_pk_no =$hospital_id  "; //and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')

        $columns = array(
            array('db' => 'invoice', 'dt' => 0),
            array('db' => 'invoice_no_pk', 'dt' => 1),
            array('db' => 'invoice_code', 'dt' => 2),
            array('db' => 'invoice_date', 'dt' => 3),
            array('db' => 'patient_code', 'dt' => 4),
            array('db' => 'patient_name', 'dt' => 5),
            array('db' => 'patient_gender', 'dt' => 6),
            array('db' => 'mobile1', 'dt' => 7),
            array('db' => 'patient_no_pk', 'dt' => 8),
            array('db' => 'person_no_fk', 'dt' => 9),
            array('db' => 'full_name', 'dt' => 10),
            array('db' => 'doctor_gender', 'dt' => 11),
            array('db' => 'specialization', 'dt' => 12),
            array('db' => 'phone_mobile', 'dt' => 13),
            // array('db' => 'ledger_amt_payment', 'dt' => 14),
            // array('db' => 'urgent_fee', 'dt' => 15),
            // array('db' => 'total_bill', 'dt' => 16),
            array('db' => 'collection', 'dt' => 14),
            array('db' => 'due', 'dt' => 15),
            array('db' => 'refund', 'dt' => 16),
            array('db' => 'photo_name', 'dt' => 17),
            array('db' => 'person_code', 'dt' => 18),
            array('db' => 'degree1', 'dt' => 19),
            array('db' => 'degree2', 'dt' => 20),
            array('db' => 'degree3', 'dt' => 21),
            array('db' => 'degree4', 'dt' => 22),
            array('db' => 'au_entry_at', 'dt' => 23),
            array('db' => 'au_update_at', 'dt' => 24),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'ledger_amt_sales', 'dt' => 26),
            array('db' => 'appoint_service_no_fk', 'dt' => 27),
            array('db' => 'admission_no_pk', 'dt' => 28),
            array('db' => 'ccm_client_name', 'dt' => 29),
            array('db' => 'contact_no', 'dt' => 30),
            array('db' => 'contact_person', 'dt' => 31),
            array('db' => 'module_code', 'dt' => 32),
            array('db' => 'invoice_trn_list', 'dt' => 33),
            array('db' => 'sales_cancel', 'dt' => 34),
            array('db' => 'sales', 'dt' => 35),
            array('db' => 'bill_type', 'dt' => 36),

        );


        // dd($request, $table, $primaryKey, $columns, null, $where);
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function ipdList(Request $request)
    {
        $patient_id = $request->hdn_patient_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;
        $patient_type_no = $request->patient_type_no;

        $ipd = 'due > 5'; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $ipd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_fk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_type_no != "" ? " $clause patient_type_no_fk = $patient_type_no " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_pk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_pk  = $corporate_name" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 1" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";

        $table = 'finc_ipdpatientlist_vw';
        $primaryKey = 'patient_no_fk';

        $columns = array(
            array('db' => 'admission_date',   'dt' => 0),
            array('db' => 'patient_no_fk',    'dt' => 1),
            array('db' => 'patient_name',     'dt' => 2),
            array('db' => 'admission_no_pk',  'dt' => 3),
            array('db' => 'dis_date',         'dt' => 4),
            array('db' => 'sales',            'dt' => 5),
            array('db' => 'payment',          'dt' => 6),
            array('db' => 'due',              'dt' => 7),
            array('db' => 'discount',         'dt' => 8),
            array('db' => 'patient_code',     'dt' => 9),
            array('db' => 'bed_name',         'dt' => 10),
            array('db' => 'ccm_client_name',  'dt' => 11),
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function getMrnOutstanding(Request $request)
    {
        try {
            $patient_id = $request->input('hdn_patient_id');
            $corporate_client_id = $request->input('corporate_client_id');

            //previous
            // $out_op_amt = DB::table('finc_ledgermst as lmst')
            //     ->join('finc_invoicemst as mst', 'lmst.invoice_no_fk', '=', 'mst.invoice_no_pk')
            //     ->where(DB::raw('NVL(mst.admission_no_pk, 0)'), '=', 0)
            //     ->where('mst.patient_no_fk', $patient_id)
            //     ->selectRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) as out_op_amt')
            //     ->value('out_op_amt');


            $out_op_amt = DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'lmst.invoice_no_fk', '=', 'mst.invoice_no_pk')
                ->where(DB::raw('NVL(mst.admission_no_pk, 0)'), '=', 0)
                ->when($patient_id, function ($query, $patient_id) {
                    return $query->where('mst.patient_no_fk', $patient_id);
                })
                ->when($corporate_client_id, function ($query, $corporate_client_id) {
                    return $query->where('mst.cor_client_no_fk', $corporate_client_id);
                })
                ->selectRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) as out_op_amt')
                ->value('out_op_amt');

            // $out_ip_amt = DB::table('finc_ledgermst as lmst')
            //     ->join('finc_invoicemst as mst', 'lmst.invoice_no_fk', '=', 'mst.invoice_no_pk')
            //     ->where(DB::raw('NVL(mst.admission_no_pk, 0)'), '>', 0)
            //     ->where('mst.patient_no_fk', $patient_id)
            //     ->selectRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) as out_ip_amt')
            //     ->value('out_ip_amt');

            //previous
            // $out_ip_amt = DB::table('finc_ledgermst as lmst')
            //     ->join('finc_invoicemst as mst', 'lmst.invoice_no_fk', '=', 'mst.invoice_no_pk')
            //     ->join('ipd_admission as ipd', 'mst.admission_no_pk', '=', 'ipd.admission_no_pk')
            //     ->where('ipd.dis_ind', 1)
            //     ->where('mst.patient_no_fk', $patient_id)
            //     ->selectRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) as out_ip_amt')
            //     ->havingRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) > ?', [5])
            //     ->value('out_ip_amt');

            $out_ip_amt = DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'lmst.invoice_no_fk', '=', 'mst.invoice_no_pk')
                ->join('ipd_admission as ipd', 'mst.admission_no_pk', '=', 'ipd.admission_no_pk')
                ->where('ipd.dis_ind', 1)
                ->when($patient_id, function ($query, $patient_id) {
                    return $query->where('mst.patient_no_fk', $patient_id);
                })
                ->when($corporate_client_id, function ($query, $corporate_client_id) {
                    return $query->where('ipd.ccm_client_no_fk', $corporate_client_id);
                })
                ->selectRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) as out_ip_amt')
                ->havingRaw('SUM(lmst.ledger_amt_sales) - (SUM(lmst.ledger_amt_payment) + SUM(lmst.ledger_amt_discount)) > ?', [5])
                ->value('out_ip_amt');

            $out_er_amt = 0;

            return response()->json([
                'op_amount' => number_format($out_op_amt ?? 0, 2),
                'ip_amount' => number_format($out_ip_amt ?? 0, 2),
                'er_amount' => number_format($out_er_amt ?? 0, 2),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeDueBill(Request $request)
    {
        DB::beginTransaction();

        try {
            $rows = $request->rows ?? [];
            $paymentData = $request->payment_data ?? [];

            // dd($rows, $paymentData);

            // ================= PREPARE ARRAY VALUES =================
            $patientIds     = array_column($rows, 'patient_id');
            $invoiceIds     = array_column($rows, 'invoice_id');
            $admissionIds   = array_column($rows, 'admission_id');
            $paymentAmounts = array_column($rows, 'payment_amount');
            $tabTypes       = array_column($rows, 'tab_type');
            $servicePoints  = array_column($rows, 'service_point');

            $recordCount = count($patientIds);
            $paymentAmtDelimited = array_sum($paymentAmounts);

            // ================= PAYMENT INFO =================
            $paymodeDelimited = (isset($paymentData['payment_mode']) && $paymentData['payment_mode'] === 'CS')
                                ? 'CASH'
                                : ($paymentData['payment_mode'] ?? 'CASH');

            $payModeTypeDelimited     = $paymentData['card_type'] ?? null;
            $bankNameDelimited        = $paymentData['bank_name'] ?? null;
            $transactionIdDelimited   = $paymentData['transaction_id'] ?? null;
            $bankCardNoDelimited      = $paymentData['card_no'] ?? null;
            $accHolderNameDelimited   = $paymentData['holder_name'] ?? null;

            $numelems      = 500;
            $paymodeCount  = 1;
            $paymentOpdIpd = strtoupper($tabTypes[0] ?? 'OPD'); // default OPD if missing

            // ================= AUDIT INFO =================
            $entrySession   = 'AR_PAYMENT';
            $authId         = Auth::id();
            $hospitalId     = Session::get('user.ses_hospital_no_pk');
            $outError       = '';

            // ================= PDO CALL =================
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("
                BEGIN pkg_billing_ipd_v0.prc_ipdpayment_adm_inv_array(
                    :in_admission_no_fk,
                    :in_invoice_no_fk,
                    :in_counter_su_no_fk,
                    :in_payment_amt,
                    :in_record_count,

                    :in_paymood_delimited,
                    :in_pay_mood_type_delimited,
                    :in_bank_name_delimited,
                    :in_transaction_id_delimited,
                    :in_bank_card_no_delimited,
                    :in_acc_holder_name_delimited,
                    :in_payment_amt_delimited,
                    :in_paymode_count,
                    :in_payment_OPD_IPD,

                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_error
                );
                END;
            ");

            // ================= ARRAY BINDINGS =================
            $stmt->bindArray(':in_admission_no_fk', $admissionIds, count($admissionIds), $numelems, SQLT_INT);
            $stmt->bindArray(':in_invoice_no_fk', $invoiceIds, count($invoiceIds), $numelems, SQLT_INT);
            $stmt->bindArray(':in_counter_su_no_fk', $servicePoints, count($servicePoints), $numelems, SQLT_INT);
            $stmt->bindArray(':in_payment_amt', $paymentAmounts, count($paymentAmounts), $numelems, SQLT_FLT);

            // ================= SCALAR BINDINGS =================
            $stmt->bindParam(':in_record_count', $recordCount, PDO::PARAM_INT);
            $stmt->bindParam(':in_paymood_delimited', $paymodeDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_pay_mood_type_delimited', $payModeTypeDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_bank_name_delimited', $bankNameDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_transaction_id_delimited', $transactionIdDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_bank_card_no_delimited', $bankCardNoDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_acc_holder_name_delimited', $accHolderNameDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_payment_amt_delimited', $paymentAmtDelimited, PDO::PARAM_STR);
            $stmt->bindParam(':in_paymode_count', $paymodeCount, PDO::PARAM_INT);
            $stmt->bindParam(':in_payment_OPD_IPD', $paymentOpdIpd, PDO::PARAM_STR);

            // audit info
            $stmt->bindParam(':in_au_entry_by', $authId, PDO::PARAM_INT);
            $stmt->bindParam(':in_au_entry_session', $entrySession, PDO::PARAM_STR);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospitalId, PDO::PARAM_INT);

            // output
            $stmt->bindParam(':out_error', $outError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 500);

            // ================= EXECUTE =================
            $stmt->execute();


            // ================= INSERT AR LEDGER =================
            $lastLedgerDtlNoPk = (int) DB::table('finc_arledgerdtl')->max('arledgerdtl_no_pk') ?? 0;
            $arInvoiceNoPk     = (int) DB::table('finc_arledgerdtl')->orderByDesc('arledgerdtl_date')->value('ar_invoice_no_pk') ?? 0;

            $arInvoiceNoPk++;

            foreach ($rows as $row) {
                $lastLedgerDtlNoPk++;
                DB::table('finc_arledgerdtl')->insert([
                    'arledgerdtl_no_pk'       => $lastLedgerDtlNoPk,
                    'ar_invoice_no_pk'        => $arInvoiceNoPk,
                    'arledgerdtl_date'        => Carbon::now(),
                    'patient_no_fk'           => $row['patient_id'],
                    'admission_no_fk'         => $row['admission_id'],
                    'invoice_no_fk'           => $row['invoice_id'],
                    'cor_client_no_fk'        => $row['corporate_client_id'],
                    'amount'                  => $row['payment_amount'],
                    'pay_mode'                => $paymentData['payment_mode'],
                    'pay_type'                => $paymentData['card_type'] ?? null,
                    'card_no'                 => $paymentData['card_no'] ?? null,
                    'transaction_id'          => $paymentData['transaction_id'] ?? null,
                    'status'                  => true,
                    'au_entry_by'             => $authId,
                    'au_entry_session'        => "AR_COLLECTION",
                    'au_entry_hospital_pk_no' => $hospitalId,
                ]);
            }

            if (!empty($outError) && $outError !== '000') {
                DB::rollBack();
                return response()->json([
                    'msg'   => $outError,
                    'title' => 'Error',
                ], 400);
            }

            DB::commit();
            return response()->json([
                'msg'   => 'Payment Successfully Done',
                'title' => 'Success',
                'invoice_no' => $arInvoiceNoPk,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg'   => $e->getMessage(),
                'title' => 'Payment Fail',
            ], 500);
        }
    }

    public function dueBillReport(Request $request, $type)
    {
        if (empty($request->patient_id) && empty($request->corporate_name)) {
            abort(400, "MRN number or corporate name are required");
        }

        $opdRepords = DB::table('finc_v1_opd_inv_billing_list_vw')
                ->when($request->patient_id, function ($query, $patient_id) {
                    return $query->where('patient_no_pk', $patient_id);
                })
                ->when($request->corporate_name, function ($query, $corporate_name) {
                    return $query->where('ccm_client_no_fk', $corporate_name);
                })
                ->where('due', '>', 1)
                ->get();

        $ipdRepords = DB::table('finc_ipdpatientlist_vw')
                ->when($request->patient_id, function ($query, $patient_id) {
                    return $query->where('patient_no_fk', $patient_id);
                })
                ->when($request->corporate_name, function ($query, $corporate_name) {
                    return $query->where('ccm_client_no_pk', $corporate_name);
                })
                ->where('due', '>', 1)
                ->get();

        return view("admin.billing.due_bill_report", compact('opdRepords', 'ipdRepords', 'type'));
    }
}
