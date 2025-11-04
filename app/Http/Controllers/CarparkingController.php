<?php

namespace App\Http\Controllers;

use App\Core\Carparking\CarparkingPolicy\CarparkingPolicy;
use Illuminate\Http\Request;
use App\Library\Template;
use Auth;
use Session;
use DB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use \PDF;
use PDO;
use DateTime;
use Carbon\Carbon;
use App\Models\GrantUserService;

class CarparkingController extends Controller
{

    protected $CarparkingPolicy;


    public function __construct(CarparkingPolicy $CarparkingPolicy)
    {
        $this->CarparkingPolicy = $CarparkingPolicy;
    }

    // Carparking policy Settings
    public function carparkingPolicy()
    {
        $vehicle_data = $this->CarparkingPolicy->carparking();
        return Template::loadView("admin.uhl.carParking.car-parking-policy", [
            'vehicle_data' => $vehicle_data
        ]);
    }

    public function carparkingPolicyList(Request $request)
    {
        $this->CarparkingPolicy->carparkingData($request);
    }

    public function carparkingPolicyStore(Request $request)
    {
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {

            $sequence = DB::getsequence();
            $ratepolicy_no_pk_seq = $sequence->nextvalue('ratepolicy_no_pk_seq');
            if($request->id == ""){
                $carparking = [
                    "ratepolicy_no_pk" => $ratepolicy_no_pk_seq,
                    'ratepolicy_uid' => $ratepolicy_no_pk_seq,
                    'ratepolicy_date' => date("y-m-d"),
                    'vehicle_type' => isset($request->vehicle_type) ? $request->vehicle_type : "",
                    'minimum_rate' => isset($request->minimum_rate) ? $request->minimum_rate : "",
                    'MINIMUM_HOUR' => isset($request->minimum_hr) ? $request->minimum_hr : "",
                    'hourly_rate' => isset($request->hourly_rate) ? $request->hourly_rate : "",
                    'status' => 1,
                    'au_entry_session' => "session",
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_entry_by' => $auth_id,
                    'au_entry_at' => date("y-m-d")
                ];
                DB::table('carp_ratepolicy')->insert($carparking);
            }else{
                $carparking = [
                    'ratepolicy_date' => date("y-m-d"),
                    'vehicle_type' => isset($request->vehicle_type) ? $request->vehicle_type : "",
                    'minimum_rate' => isset($request->minimum_rate) ? $request->minimum_rate : "",
                    'MINIMUM_HOUR' => isset($request->minimum_hr) ? $request->minimum_hr : "",
                    'hourly_rate' => isset($request->hourly_rate) ? $request->hourly_rate : "",
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_update_by' => $auth_id,
                    'au_update_at' => date("y-m-d")
                ];
                DB::table('carp_ratepolicy')->where('ratepolicy_no_pk', $request->id)->update($carparking);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function carparkingPolicyEdit($policy_id)
    {
        $carp_policy_data = DB::table('carp_ratepolicy')->where('ratepolicy_no_pk', $policy_id)->first();
        $vehicle_data = $this->CarparkingPolicy->carparking();

        return Template::loadview("admin.uhl.carParking.edit-car-parking", [
            'carp_policy_data' => $carp_policy_data,
            'vehicle_data' => $vehicle_data,
        ]);
    }

    public function carparkingPolicyDelete($policy_id)
    {
        DB::table('carp_ratepolicy')->where('ratepolicy_no_pk', $policy_id)->delete();
        return Template::loadView("admin.uhl.carParking.car-parking-policy");
    }

    public function carPparkingIn(){
        $vehicle_data = $this->CarparkingPolicy->carparking();
       
        return Template::loadView("admin.uhl.carParking.car-parking-in",[
            'vehicle_data' => $vehicle_data,
        ]);
    }
    public function carPparkingOut(){
    //     $service_point = GrantUserService::where('pharmacy_ind', '1')->select('serviceunit_no_pk',
    //     'serviceunit_name', 
    //     'serviceunit_code',
    //      'default_ind', 
    //      'hs_pos_ind')
    //    ->where('user_no_pk', Auth::id())
    //    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    //    ->orderBy('serviceunit_name', 'asc')
    //    ->distinct()
    //    ->get();

       $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        return Template::loadView("admin.uhl.carParking.car-parking-out",[
            'service_point' => $service_point,
        ]);
    }
    public function getParkingData(Request $request){
        $vehicle_data = DB::table('carp_transaction')->where('carp_trans_uid',$request->parking_id)->first();
        $policy=DB::table('carp_ratepolicy')->where('vehicle_type', $vehicle_data->vehicle_type)->first();
        return response()->json(['vehicle_data'=>$vehicle_data,'policy'=>$policy]);
    }

    public function storeCarParkingIn(Request $request){
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $sequence = DB::getsequence();
            $carp_trans_no_pk_seq = $sequence->nextvalue('carp_trans_no_pk_seq');
            $carp_trans = 1;
            // date_default_timezone_set('Asia/Dhaka');
            if($request->id == ""){
                $data = [
                    "carp_trans_no_pk" => $carp_trans_no_pk_seq,
                    'carp_trans_uid' => $carp_trans_no_pk_seq,
                    'start_date' => date("Y-m-d H:i"),
                    // 'start_time' =>  date('H:i:s'),
                    'car_number' => isset($request->car_number) ? $request->car_number : "",
                    'vehicle_type' => isset($request->vehicle_type) ? $request->vehicle_type : "",
                    'driver_name' => isset($request->name) ? $request->name : "",
                    'driver_mobile' => isset($request->mobile_no) ? $request->mobile_no : "",
                    'status' => 1,
                    'au_entry_session' => "session",
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_entry_by' => $auth_id,
                    'au_entry_at' => date("Y-m-d H:i")
                ];

                DB::table('carp_transaction')->insert([$data]);

            }else{

            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];

        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);

    }

    public function carParkingWorklist(){

        $carParkingData = DB::table('carp_transaction')
        ->select('*')
        ->where(DB::raw('trunc(start_date)'),date('Y-m-d'))
        ->where('status', 1)        
        ->orderBy('carp_trans_no_pk', 'desc')
        ->get();
        
        $vehicle_data = $this->CarparkingPolicy->carparking();
        return Template::loadView("admin.uhl.carParking.car-parking-worklist", [
            'carParkingData' => $carParkingData,
            'vehicle_data' => $vehicle_data,
        ]);
    }
    public function carParkingSearch(Request $request){

        $carParkingDatas = DB::table('carp_transaction');
        
        $from_date = $request->from_date !="" ? date('Y-m-d',strtotime($request->from_date)) :'';
        $to_date = $request->to_date !="" ? date('Y-m-d',strtotime($request->to_date)) :'';
   
        if ($request->from_date != "" && $request->to_date != "") {
            $carParkingDatas->where(DB::raw('trunc(start_date)'), '>=', $from_date)
                            ->where(DB::raw('trunc(start_date)'), '<=', $to_date);
        } elseif ($request->from_date != "") {
            $carParkingDatas->where(DB::raw('trunc(start_date)'), '=', $from_date);
        }
        if ($request->vehicale_type !="") {
            $carParkingDatas->where('vehicle_type',$request->vehicale_type);
        }
        if ($request->car_number !="") {
            $carParkingDatas->where('car_number',$request->car_number);
        }
        if ($request->token !="") {
            $carParkingDatas->where('carp_trans_uid',$request->token);
        }
        $carParkingData=$carParkingDatas->where('status', 1)        
        ->orderBy('carp_trans_no_pk', 'desc')
        ->get();
        // dd($request->token, $carParkingData);
        // $vehicle_data = $this->CarparkingPolicy->carparking();
        return Template::loadView("admin.uhl.carParking.car-parking-table-list", [
            'carParkingData' => $carParkingData,
        ]);
    }

    public function printCarParkingToken($id)
    {

        $tokenInfo = DB::table('carp_transaction')->select('carp_trans_uid', 'car_number', 'start_date')->where('carp_trans_no_pk', $id)->first();

        $barcode = new BarcodeGenerator();
        // $barcode->setText($label_info->asset_tag_uid);
        $barcode->setText('5869544');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(5);

        $data['token_no_barcode'] = $barcode->generate();
        $data['tokenInfo'] = $tokenInfo;
        $pdf = PDF::loadView("admin.uhl.carParking.print-car-parking-token", $data);
        return $pdf->stream("car_parking_token.pdf");
    }




    public function parkingServiceBill(Request $request)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
            $patient_info=DB::table('patn_registration')->where('patient_code','P000000000000')->first();
            $walk_in_phone ='';// $request->walk_in_phone ? $request->walk_in_phone : "";
            $walk_in_customer_addr ='';// $request->customer_addr ? $request->customer_addr : "";
            $walk_in_name = '';//$request->customer_name != "" ? $request->customer_name : "customer";

            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($patient_info->patient_no_pk) ? $patient_info->patient_no_pk : '';
            $hdn_driver_id = !empty($request->hdn_driver_id) ? $request->hdn_driver_id : '';
            $hdn_patient_code = !empty($patient_info->patient_code) ? $patient_info->patient_code : '';
            $patient_name = !empty($request->patient_name) ? $request->patient_name : '';
            $phone_mobile = !empty($request->phone_mobile) ? $request->phone_mobile : '';
            
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

            $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $item_info = DB::table('sysc_serviceitem')->where('item_code','PARKINGSERVICE')->first();
            // dd($item_info);
            $hdn_item_id = [$item_info->item_no_pk];
            $hdn_item_urgent_fee =[''];
            $hdn_item_name = [$item_info->item_name];
            $hdn_item_type = [$item_info->item_type];
            $total_item = count($hdn_item_id);
            $txt_batch = [''];
            $item_vat_prse = [''];
            $provider_no = [''];
          
            $txt_expire_date = [''];
            $hdn_item_rate = [$request->bill_amt];
            $hdn_item_qnty = [1];
            $item_delivery_status = [''];

            $hdn_item_deli_date = [''];

            $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
            $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
            $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
            $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
            $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
            $remarks = !empty($request->bill_remarks) ? $request->bill_remarks : " ";
            $pay_mode = $request->pay_mode;
            $pay_amount = $request->pay_amount;
            $given_amount = $request->given_amount;
            $change_amount = $request->change_amount;
            $item_vat = $request->item_vat;
            $urgent_fee = $request->urgent_fee;
        
            $total_payment = $request->bill_amt;
            $entry_session = "session";

            $item_total = $request->bill_amt;
            $total_payable =$request->bill_amt;
            $total_discount_amount = $request->total_discount_amount;
            $discount_remarks = $request->discount_remarks;

            $bank_name = $request->bank_name;
            $bank_name_card = $request->bank_name_card;
            $card_no = $request->card_no;
            $bkash_txn_id = $request->bkash_txn_id;
            $holder_name = $request->holder_name;
            $check_no = $request->check_no;
            $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
            $report_delivery_date = $request->raport_delivery_date != "" ? date('Y-m-d', strtotime($request->raport_delivery_date)) : '';

            $invoice_date = "";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

            $hospital_id = $ses_hospital_id;
            $null = '';

            $out_sl_no = '';
            $empty_arr = [];
            $numelems = 200;
            $zero = 0;

            if (empty($check_no)) {
                $check_no = $card_no;
            }

            if (empty($check_no) & empty($card_no)) {
                $check_no = $bkash_txn_id;
            }
            if (empty($bank_name)) {
                $bank_name = $bank_name_card;
            }

            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = $ipd_charge = [];
            $i = 0;

            if (!empty($hdn_item_id)) {
                foreach ($hdn_item_id as $deli_date) {
                    $sc_date = date("d-m-Y");
                    $deli_dt_arr[$i] = '';
                    $item_delivery_status_arr[$i] = '';
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = '';
                    $expire_dt_arr[$i] = '';
                    $hdn_item_urgent_fee_amt[$i] = '';
                    $item_disc_amount[$i] = '';
                    $ipd_charge[$i] = '';
                    $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                    $item_level_remarks[$i] = 0;
                    $i++;
                }
            }
            $s_charge = $request->service_charge != "" ? $request->service_charge : 0; // array_sum($ipd_charge);

            if ($admission_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "CAR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                if ($service_appointment_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "CAR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "CAR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
            if ($hdn_patient_id != "") {
                $corporate_id = DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
            } else {
                $corporate_id = '';
            }
          

            // OUT PAREMETER INITIALIZE
            $out_ledgertrn_no = 0;
            $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = 0;        
            $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;
          
            if (array_sum($item_disc_amount) > 0) {
                $item_discount = 1;
            } else {
                $item_discount = "";
            }
            $emergency_ind = $request->emergency;
            $daycare_ind = $request->daycare;
          
            $pdo = DB::getPdo();
            // pkg_billing_v0 , pkg_v1_billing
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:in_provider_no_fk,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");

            $billinvoice->bindParam(':in_invoice_date', $cur_date);
            $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_patient_no_fk', $hdn_patient_id);
            $billinvoice->bindParam(':in_patient_code', $hdn_patient_code);
            $billinvoice->bindParam(':in_admission_no_pk', $admission_id);
            $billinvoice->bindParam(':in_admission_code', $null);
            $billinvoice->bindParam(':in_appointment_no_fk', $service_appointment_id);
            $billinvoice->bindParam(':in_prescription_no_fk', $prescription_id);
            $billinvoice->bindParam(':in_doc_person_no_fk', $hdn_doctor_id);
            $billinvoice->bindParam(':in_first_ref_doc', $hdn_first_referral_id);
            $billinvoice->bindParam(':in_second_ref_doc', $hdn_second_referral_id);
            $billinvoice->bindParam(':in_report_delivary_date', $report_delivery_date);
            $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
            $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
            $billinvoice->bindParam(':in_cor_client_no_fk', $corporate_id);
            $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
            $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
            $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
            $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $patient_type);
            $billinvoice->bindParam(':in_dob', $invoice_date);
            $billinvoice->bindParam(':in_age', $null);
            $billinvoice->bindParam(':in_age_dd', $null);
            $billinvoice->bindParam(':in_age_mm', $null);
            $billinvoice->bindParam(':in_age_yy', $null);
            $billinvoice->bindParam(':in_customer_addr', $walk_in_customer_addr);
            $billinvoice->bindParam(':in_customer_name', $walk_in_name);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $walk_in_phone);

            $billinvoice->bindParam(':in_invoice_remarks', $remarks);
            $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
            $billinvoice->bindParam(':in_invoice_type', $null);
            $billinvoice->bindParam(':in_emergency_ind', $emergency_ind);
            $billinvoice->bindParam(':in_daycare_ind', $daycare_ind);
            $billinvoice->bindParam(':in_ot_ind', $null);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
            $billinvoice->bindParam(':in_item_count', $total_item);
            $billinvoice->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_batch_fk', $batch_no_arr, count($batch_no_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_expiry_dt', $expire_dt_arr, count($expire_dt_arr), $numelems, SQLT_CHR);

            $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_service_charge', $ipd_charge, count($ipd_charge), $numelems, SQLT_FLT);

            $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);

            $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($billinvoice);
            $billinvoice->execute();
            $finc_invoice_data = DB::table('finc_invoicemst')->select('invoice_no_pk', 'invoice_code', 'invoice_date', 'module_no_fk', 'invoice_cancel_ind', 'invoicemst_amt_payment', 'invoicemst_amt_sales')->where("INVOICE_NO_PK", $out_invoice_no)->first();
            // dd($finc_invoice_data);
            if (!empty($finc_invoice_data)) {   
                $end_time=$request->end_time !="" ? date('Y-m-d H:i',strtotime($request->end_time)) :"";           
                $data = [
                    'end_date'=>$end_time,
                    'end_out_ind'=>1,
                    'total_hour'=>$request->total_hour,
                    'total_bill'=>$request->bill_amt,
                    'invoice_no_fk'=>$out_invoice_no,
                    'module_no_fk'=>$module_id,
                    'end_out_by' => $auth_id,
                    'end_out_date' =>  date('Y-m-d h:i:s'),
                ];
             
                DB::table('carp_transaction')->where('carp_trans_no_pk',$request->parking_id)->update($data);
            }
            $out_ledgertrn_no2 = "";
            if ($out_error == 999) {
                // dd($out_error);
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
            } else {

                $out_invoice_no2 = $out_ledger_no = $out_error = "";
                $pdo1 = DB::getPdo();
                // pkg_billing_v0
                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_wp(
                     :in_payment_date,
                     :in_payment_datetime,
                     :in_invoice_no_fk,
                     :in_module_no_fk,
                     :in_patient_no_fk,
                     :in_admission_no_fk,
                     :in_prescription_no_fk,
                     :in_counter_su_no_fk,
                     :in_ledger_amt_sales,
                     :in_ledger_amt_payment,
                     :in_ledger_amt_discount,
                     :in_urgent_fee,
                     :in_service_charge,
                     :in_cor_client_no_fk,
                     :in_pay_mode,
                     :in_pay_cqcc_holder_name,
                     :in_pay_cqcc_number,
                     :in_pay_cqcc_deduct_percent,
                     :in_pay_bank_name,
                     :in_pay_remarks,
                     :in_given_amt,
                     :in_disc_type_lookup_no_fk,
                     :in_disc_remarks,
                     :in_disc_amt_by_doc,
                     :in_disc_amt_by_doc_no_fk,
                     :in_disc_amt_by_hosp,
                     :in_disc_amt_by_hosp_auth_by,
                     :in_disc_amt_request_by_name,
                     :in_au_entry_by,
                     :in_au_entry_session,
                     :in_au_entry_hospital_pk_no,
                     :in_item_count,
                     :in_item_level_disc_ind,
                     :in_item_no_fk,
                     :in_item_name,
                     :in_itemtype_no_fk,
                     :in_item_qty,
                     :in_item_rate,
                     :in_item_disc_percent,
                     :in_item_disc_amount,
                     :in_item_vat,
                     :in_itemurgent_fee,
                     :in_itemservice_charge,
                     :in_package_item_ind,
                     :in_ledgertrn_no,
                     :out_invoice_no,
                     :out_invoice_id,
                     :out_ledgertrn_no,
                     :out_ledger_no,
                     :out_error);
                     end;");

                // :in_paymood,
                // :in_pay_mood_type,
                // :in_bank_name,
                // :in_transaction_id,
                // :in_bank_card_no,
                // :in_acc_holder_name,
                // :in_payment_amt,
                // :in_paymood_count,

                $billpayment->bindParam(':in_payment_date', $cur_date);
                $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
                $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
                $billpayment->bindParam(':in_module_no_fk', $module_id);
                $billpayment->bindParam(':in_patient_no_fk', $hdn_patient_id);
                $billpayment->bindParam(':in_admission_no_fk', $admission_id);
                $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
                $billpayment->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
                $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
                $billpayment->bindParam(':in_ledger_amt_payment', $total_payment);
                $billpayment->bindParam(':in_ledger_amt_discount', $total_discount_amount);
                $billpayment->bindParam(':in_urgent_fee', $urgent_fee);
                $billpayment->bindParam(':in_service_charge', $s_charge);
                $billpayment->bindParam(':in_cor_client_no_fk', $zero);
                $billpayment->bindParam(':in_pay_mode', $pay_mode);
                $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
                $billpayment->bindParam(':in_pay_cqcc_number', $null);
                $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
                $billpayment->bindParam(':in_pay_bank_name', $null);
                $billpayment->bindParam(':in_pay_remarks', $discount_remarks);
                $billpayment->bindParam(':in_given_amt', $given_amount);

                // DISCOUNT COLUMN PREPARATION START
                $discount_info =[];// LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
                //dd($discount_info->lookupdata_no_pk);

                $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;

                if (!empty($discount_info)) {
                    if ($discount_info->lookupdata_code == "DOCTOR") {
                        $doctor_disc_amt = $disc_amount_doctor;
                        $doctor_id_for_disc = $hdn_dis_doctor_id;
                    }

                    if ($discount_info->lookupdata_code = "GENERAL") {
                        $hospital_disc_amt = $disc_amount_hospital;
                        $hospital_id_for_disc = $hdn_dis_doctor_id ?? $auth_id;
                    }

                    if ($discount_info->lookupdata_code = "BOTH") {
                        $doctor_disc_amt = $disc_amount_doctor;
                        $doctor_id_for_disc = $hdn_dis_doctor_id;
                        $hospital_disc_amt = $disc_amount_hospital;
                    }
                }
                // dd($discount_info);
                // DISCOUNT COLUMN PREPARATION END
                $lookupdata_no_pk = !empty($discount_info) ? $discount_info->lookupdata_no_pk : 0;
                $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
                $billpayment->bindParam(':in_disc_remarks', $discount_remarks);
                $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_disc_amt);
                $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
                $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_disc_amt);
                $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $hospital_id_for_disc); // will be adjust later
                $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);

                $billpayment->bindParam(':in_au_entry_by', $auth_id);
                $billpayment->bindParam(':in_au_entry_session', $entry_session);
                $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $billpayment->bindParam(':in_item_count', $total_item);
                $billpayment->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
                $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemservice_charge', $ipd_charge, count($ipd_charge), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                $billpayment->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
                $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
                $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no2, PDO::PARAM_INT);
                $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
                $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                // dd( $billpayment);
                $billpayment->execute();

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
                } else {

                    $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                    // dd($paymood_count);
                    $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                    $auth_id = Auth::id();

                    $date = date('Y-m-d');
                    $in_paymood_arr_t = $request->pay_method_mode;
                    $in_pay_mood_type_arr_t = $request->mBank_types;
                    $in_bank_name_arr_t = $request->pay_bank_name;
                    $in_transaction_id_arr_t = $request->trans_id_no;
                    $in_bank_card_no_arr_t = $request->card_number;
                    $in_invoice_no_arr_t = $request->invoice_number;
                    $in_acc_holder_name_arr_t = $request->acc_holder_name;
                    $in_payment_amt_arr_t = $request->total_amt;
                    $in_paymood_count = $paymood_count;
                    $in_au_entry_by = $auth_id;
                    $in_au_entry_session = "session";
                    $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
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
                            $in_invoice_no_arr_t[$i] = (!empty($in_invoice_no_arr_t[$i]) ? $in_invoice_no_arr_t[$i] : "");
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
                    $in_invoice_no_arr = (!empty($in_invoice_no_arr_t) ? count($in_invoice_no_arr_t) : 1);
                    $in_acc_holder_name_arr = (!empty($in_acc_holder_name_arr_t) ? count($in_acc_holder_name_arr_t) : 1);
                    $in_payment_amt_arr = (!empty($in_payment_amt_arr_t) ? count($in_payment_amt_arr_t) : 1);
                    // dd( $in_bank_card_no_arr , $in_bank_name_arr , $in_invoice_no_arr_t);
                    // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                    $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                    $pdo2 = DB::getPdo();
                    // pkg_billing_v0
                    $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing_v0.prc_finc_ledger_paymood(
                        :in_payment_date,
                        :in_invoice_no_fk,
                        :in_ledger_no_fk,
                        :in_paymood,
                        :in_pay_mood_type,
                        :in_bank_name,
                        :in_transaction_id,
                        :in_bank_card_no,
                        :in_acc_holder_name,
                        :in_payment_amt,
                        :in_paymood_count,
                        :in_au_entry_by ,
                        :in_au_entry_session ,
                        :in_au_entry_hospital_pk_no ,
                        :out_error);
                        end;");

                    $finc_ledger_paymood->bindParam(':in_payment_date', $date);
                    $finc_ledger_paymood->bindParam(':in_invoice_no_fk', $invoice_no);
                    $finc_ledger_paymood->bindParam(':in_ledger_no_fk', $ledger_no);
                    $finc_ledger_paymood->bindArray(':in_paymood', $in_paymood_arr_val, $in_paymood_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_pay_mood_type', $in_pay_mood_type_arr_val, $in_pay_mood_type_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_bank_name', $in_bank_name_arr_val, $in_bank_name_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_transaction_id', $in_transaction_id_arr_val, $in_transaction_id_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_bank_card_no', $in_bank_card_no_arr_val, $in_bank_card_no_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_acc_holder_name', $in_acc_holder_name_arr_val, $in_acc_holder_name_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_payment_amt', $in_payment_amt_arr_val, $in_payment_amt_arr, $numelems, SQLT_FLT);
                    $finc_ledger_paymood->bindParam(':in_paymood_count', $in_paymood_count);
                    $finc_ledger_paymood->bindParam(':in_au_entry_by', $in_au_entry_by);
                    $finc_ledger_paymood->bindParam(':in_au_entry_session', $in_au_entry_session);
                    $finc_ledger_paymood->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
                    $finc_ledger_paymood->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                    $finc_ledger_paymood->execute();

                    $j = 0;
                    if ($out_error != 999) {

                        if (!empty($in_paymood_arr_t)) {
                            foreach ($in_paymood_arr_t as $key => $value) {
                                $data = [
                                    'card_invoice_no' =>  $request->invoice_number[$j],
                                ];
                                $in_bank_name_arr_val[$j] = (!empty($in_bank_name_arr_t[$j]) ? $in_bank_name_arr_t[$j] : "");
                                $payment_details[$j] = DB::table('finc_ledger_paymood')->where('invoice_no_fk', $invoice_no)->where('ledger_no_fk', $ledger_no)->where('paymood', 'CARD')
                                    ->where('bank_name', $in_bank_name_arr_val[$j])
                                    ->update($data);
                                $j++;
                            }
                        }
                    }

                    if ($page_type == "physio") {
                        DB::table('patn_service_schedule')
                            ->where('schedule_no_pk', '=', $request->service_id)
                            ->update(['invoice_no_fk' => $out_invoice_no]);
                        //   $data=[invoice_no_fk => $out_invoice_no ];
                    }

                    if ($out_error == 999) {
                        DB::rollback();
                        $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                    } else {
                        DB::commit();
                        $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                    }
                }
                /*  dd($in_paymood_arr_val,$in_pay_mood_type_arr_val);*/

                //DB::commit();
                //$message = ['msg' => 'New Bill created successfully.Invoice ID = '. $out_invoice_no, 'title' => 'Success'];

            }
        // } catch (\Exception $e) {
        //     DB::rollback();

        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }
}
