<?php

namespace App\Repositories;

use PDO;
use DateTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Billing;
use App\Events\TVUpdate;
use App\Core\TV\TVService;
use App\Models\LookupItem;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use App\Events\PharmacyTVUpdate;
use App\Core\TV\PharmacyTVService;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BillingRepository extends BaseRepository
{
    use LookupData;

    protected $baseRepository;
    protected $tv_information;

    protected $pharmacy_tv_information;
    public function __construct(Billing $billing, TVService $tv_information, PharmacyTVService $pharmacy_tv_information)
    {
        $this->billing = $billing;
        $this->baseRepository = new BaseRepository($billing);
        $this->tv_information = $tv_information;
        $this->pharmacy_tv_information = $pharmacy_tv_information;
    }

    public function all()
    {
        return $this->billing->all();
    }

    public function createOrUpdate($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        //  $prescription_id = !empty($request->prescription_id) ? $request->prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        $hdn_item_type = $request->hdn_item_type;
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $total_discount_amount = $request->total_discount_amount;
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $report_delivery_date = $request->raport_delivery_date != "" ? date('Y-m-d', strtotime($request->raport_delivery_date)) : '';

        // $in_paymood_arr_t = $request->pay_method_mode;
        // $in_pay_mood_type_arr_t = $request->mBank_types;
        // $in_bank_name_arr_t = $request->pay_bank_name;
        // $in_transaction_id_arr_t = $request->trans_id_no;
        // $in_bank_card_no_arr_t = $request->trans_id_no;
        // $in_acc_holder_name_arr_t = $request->acc_holder_name ;
        // $in_payment_amt_arr_t = $request->total_amt;
        // $in_paymood_count = $paymood_count;

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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = [];
        $i = 0;

        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $i++;
            }
        }
        // dd($urgent_fee,  $hdn_item_urgent_fee_amt);
        // dd(  $item_disc_amount);
        // $i = 0;
        // if (!empty($in_paymood_arr_t)) {
        //       foreach ($in_paymood_arr_t as $key=>$value) {
        //             $sc_date = date("d-m-Y");
        //             $in_paymood_arr[$i] = $value;
        //             $in_pay_mood_type_arr[$i] =(!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "null") ;
        //             $in_bank_name_arr[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "null");
        //             $in_transaction_id_arr[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "null");
        //             $in_bank_card_no_arr[$i] =(!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "null") ;
        //             $in_acc_holder_name_arr[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "null") ;
        //             $in_payment_amt_arr[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "null");

        //             $i++;
        //       }
        // }

        // dd($admission_id);
        //  if ($page_type == 1) {
        if ($admission_id != "") {
            $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        } else {
            if ($service_appointment_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }
        if ($hdn_patient_id != "") {
            $corporate_id = DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
        } else {
            $corporate_id = '';
        }
        // dd($corporate_id);
        //  }

        //  if ($page_type == 2) {
        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        //     $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //  }

        // OUT PAREMETER INITIALIZE
        $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->patient_itemType_dis_ind != "" ? $request->patient_itemType_dis_ind : 0;
        // $item_disc_percent[]=0;
        // $item_disc_amount[]=0;
        $item_level_remarks[] = 0;
        // dd($item_level_disc_ind);
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");

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
        $billinvoice->bindParam(':in_customer_addr', $null);
        $billinvoice->bindParam(':in_customer_name', $null);

        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);

        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
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
        $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

        $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        $billinvoice->execute();

        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_wp(
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
                     :out_invoice_no,
                     :out_invoice_id,
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
            //dd($discount_info->lookupdata_no_pk);

            $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = $hospital_id_for_disc = 0;

            if (!empty($discount_info)) {
                if ($discount_info->lookupdata_code == "DOCTOR") {
                    $doctor_disc_amt = $disc_amount_doctor;
                    $doctor_id_for_disc = $hdn_dis_doctor_id;
                }

                if ($discount_info->lookupdata_code = "GENERAL") {
                    $hospital_disc_amt = $disc_amount_hospital;
                    $hospital_id_for_disc = $hdn_dis_doctor_id;
                }

                if ($discount_info->lookupdata_code = "BOTH") {
                    $doctor_disc_amt = $disc_amount_doctor;
                    $doctor_id_for_disc = $hdn_dis_doctor_id;
                    $hospital_disc_amt = $disc_amount_hospital;
                }
            }

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
            $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);

            $billpayment->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);

            $billpayment->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
                $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
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
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
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
    public function POScreateOrUpdate($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();
        // dd($request->walk_in_phone);

        // try {
        $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
        $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";
        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        // $cur_date = date("Y-M-d");
        // $cur_datetime = date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;

        $txt_batch = $request->txt_batch;
        $txt_expire_date = $request->txt_expire_date;

        // $hdn_item_qnty = $request->hdn_item_qnty;

        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
        $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
        $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
        $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
        $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
        $remarks = !empty($request->remarks) ? $request->remarks : " ";
        $pay_mode = $request->pay_mode;
        $pay_amount = $request->pay_amount;
        $given_amount = $request->given_amount;
        $change_amount = $request->change_amount;
        $item_vat = $request->item_vat;
        $urgent_fee = $request->uregent_fee;
        $total_urgent_fee = $request->total_urgent_fee;
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $adj_dis = $request->dis_adj_amt;
        $total_discount_amount = $request->total_discount_amount + $adj_dis;
        // dd($adj_dis , $request->total_discount_amount , $total_discount_amount );
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;

        // dd($txt_expire_date , $hdn_item_rate ,$txt_batch  );
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

        // $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = [];
        // $i = 0;

        // if (!empty($hdn_item_id)) {
        //    foreach ($hdn_item_id as $deli_date) {
        //       $sc_date = date("d-m-Y");
        //       $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
        //       $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
        //       $package_ind_arr[$i] = 0;
        //       $item_mu_arr[$i] = 0;
        //       $hdn_item_urgent_fee_amt[$i] = ($hdn_item_urgent_fee[$i] == null) ? 0 : $hdn_item_urgent_fee[$i];

        //       $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
        //       $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
        //       $i++;
        //    }
        // }

        //   dd($batch_no_arr);

        //  if ($page_type == 1) {
        //     if ($admission_id != "") {
        //        $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
        //        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //     } else {
        //        $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
        //        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //     }
        //  }
        //  if ($page_type == 2) {

        if ($in_counter_su_no_fk != 0) {
            $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
            if (isset($service_unit_check)) {
                if ($service_unit_check->hs_pos_ind == 1) {
                    $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    if (isset($request->hdn_admission_id)) {

                        $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                        // dd($module_info ,$module_id);
                    } else {
                        $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    }
                }
            } else {
                if (isset($request->hdn_admission_id)) {

                    $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    // dd($module_info ,$module_id);
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
        } else {
            if (isset($request->hdn_admission_id)) {

                $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                // dd($module_info ,$module_id);
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }

        //  }

        $i = 0;
        $item_arr = [];
        $batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
        $hdn_item_rate = [];
        $hdn_item_qnty = [];
        $whole_sale = [];
        $hdn_item_dis = [];
        $item_dis_amt = [];
        $item_dis_pers = [];
        $item_level_remarks = [];
        // dd( $request->txt_batch );
        // if (!empty($request->txt_batch)) {
        for ($i = 0; $i < count($request->txt_batch); $i++) {
            $item_data = explode('_', $request->txt_batch[$i]);
            $item_arr[$i] = $item_data[0];
            $item_level_remarks[$i] = 0;
            $item_batch_no[$i] = $item_data[1];

            $batch_arr[$i] = $item_batch_no[$i] != "0" ? $item_batch_no[$i] : "";
            $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

            if ($whole_sale[$i] == "") {
                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr[$i])->first()->sales_price;
            } else {

                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('dealer_sales_price')->where('item_no_pk', $item_arr[$i])->first()->dealer_sales_price;
            }

            // dd($hdn_item_rate[$i]);
            $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
            $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

            $exp = explode('_', $request->txt_expire_date[$i]);
            // $str_date[$i]=$exp[1] ;
            $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";

            $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
            $hdn_item_qnty[$i] = $checker[0];
            $qty_exp = explode('_', $request->batch_qty[$i]);
            $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0];
            $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
            $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
            $package_ind_arr[$i] = 0;
            $item_mu_arr[$i] = 0;
            $hdn_item_urgent_fee_amt[$i] = (isset($urgent_fee[$i]) ? $urgent_fee[$i] : 0);

            if ($request->item_dis_radio == 1) {
                $item_dis_pers[$i] = $item_data[2];
                $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
            } elseif ($request->item_dis_radio == 2) {
                $item_dis_amt[$i] = $item_data[2];
                $item_dis_pers[$i] = $item_dis_amt[$i] != '' ? ($item_dis_amt[$i] / ($quantity_arr[$i] * $hdn_item_rate[$i])) * 100 : 0;
            } else {
                $item_dis_amt[$i] = 0;
                $item_dis_pers[$i] = 0;
            }
        }

        // dd($hdn_item_name,  $item_dis_amt, $quantity_arr,$hdn_item_rate);
        // }
        //    else{
        //   $item_count=$request->hdn_item_id ?  count($request->hdn_item_id) : 0;
        //   $batch_count=$request->txt_batch ? count($request->txt_batch) : 0;
        //   $arr_count=$batch_count >0 ? $batch_count : $item_count;

        //       for ($i = 0; $i < $arr_count; $i++) {
        //          // $item_data = explode('_', $request->txt_batch[$i]);
        //          $item_arr[$i] =$request->hdn_item_id; //  $item_data[0];

        //          $batch_arr[$i] = 0;//$item_data[1];
        //          $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr[$i])->first()->sales_price;

        //          $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
        //          $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

        //          $exp = explode('_', $request->txt_expire_date[$i]);
        //          $expire_arr[$i] ="01-01-1970"; //$exp[1];
        //          $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
        //          $hdn_item_qnty[$i] = $checker[0];
        //          //dd($checker[0],  $checker);
        //          $qty_exp = explode('_', $request->batch_qty[$i]);
        //          $quantity_arr[$i] =$checker[0]; //$qty_exp[1];
        //          $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
        //          $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
        //          $package_ind_arr[$i] = 0;
        //          $item_mu_arr[$i] = 0;
        //          $hdn_item_urgent_fee_amt[$i] = (isset($hdn_item_urgent_fee[$i]) ? $hdn_item_urgent_fee[$i] : 0);
        //       }
        //    }

        //   dd($item_dis_pers,$item_dis_amt);
        // dd($item_arr,   $batch_arr, $expire_arr, $quantity_arr, $deli_dt_arr, $item_delivery_status_arr, $package_ind_arr, $item_mu_arr, $hdn_item_rate);
        // OUT PAREMETER INITIALIZE
        $total_item = count($item_arr);
        $invoice_date = "";

        // dd($total_item);
        $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->item_dis_ind != '' ? $request->item_dis_ind : 0;

        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_phr_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");

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
        $billinvoice->bindParam(':in_report_delivary_date', $invoice_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        $billinvoice->bindParam(':in_cor_client_no_fk', $null);
        $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
        $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
        $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
        $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $patient_type);
        $billinvoice->bindParam(':in_dob', $invoice_date);
        $billinvoice->bindParam(':in_age', $null);
        $billinvoice->bindParam(':in_age_dd', $null);
        $billinvoice->bindParam(':in_age_mm', $null);
        $billinvoice->bindParam(':in_age_yy', $null);
        $billinvoice->bindParam(':in_customer_addr', $walk_in_phone);
        $billinvoice->bindParam(':in_customer_name', $walk_in_name);

        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);

        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $total_urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        $billinvoice->bindParam(':in_item_count', $total_item);
        $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);

        $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

        $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);

        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        // dd($billinvoice);
        $billinvoice->execute();

        $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

        // dd($pat_id);
        if ($out_error == 999) {
            dd($out_error . "invoice");
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_phr_wp(
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
                     :out_invoice_no,
                     :out_invoice_id,
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
            $billpayment->bindParam(':in_patient_no_fk', $pat_id);
            $billpayment->bindParam(':in_admission_no_fk', $admission_id);
            $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
            $billpayment->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
            $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
            $billpayment->bindParam(':in_ledger_amt_payment', $total_payment);
            $billpayment->bindParam(':in_ledger_amt_discount', $total_discount_amount);
            $billpayment->bindParam(':in_urgent_fee', $total_urgent_fee);
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
            //dd($discount_info->lookupdata_no_pk);

            $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;
            $hospital_disc_amt = $total_discount_amount; //$disc_amount_hospital;
            // if (!empty($discount_info)) {
            //    if ($discount_info->lookupdata_code == "DOCTOR") {
            //       $doctor_disc_amt = $disc_amount_doctor;
            //       $doctor_id_for_disc = $hdn_dis_doctor_id;
            //    }

            //    if ($discount_info->lookupdata_code = "GENERAL") {
            //       $hospital_disc_amt = $disc_amount_hospital;
            //    }

            //    if ($discount_info->lookupdata_code = "BOTH") {
            //       $doctor_disc_amt = $disc_amount_doctor;
            //       $doctor_id_for_disc = $hdn_dis_doctor_id;
            //       $hospital_disc_amt = $disc_amount_hospital;
            //    }
            // }
            //dd($in_paymood_arr);
            // DISCOUNT COLUMN PREPARATION END
            $lookupdata_no_pk = !empty($discount_info) ? $discount_info->lookupdata_no_pk : 0;
            $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
            $billpayment->bindParam(':in_disc_remarks', $discount_remarks);
            $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_disc_amt);
            $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
            $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_disc_amt);
            $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $auth_id); // will be adjust later
            $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);

            $billpayment->bindParam(':in_au_entry_by', $auth_id);
            $billpayment->bindParam(':in_au_entry_session', $entry_session);
            $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $billpayment->bindParam(':in_item_count', $total_item);
            $billpayment->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
            $billpayment->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            //   dd($billpayment);
            $billpayment->execute();

            if ($out_error == 999) {
                dd($out_error, $out_invoice_no2, $out_invoice_no, $total_item, $item_arr);
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
            } else {

                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                // dd($paymood_count);
                $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                $auth_id = Auth::id();
                date_default_timezone_set('Asia/Dhaka');
                $time = Carbon::now();

                $date = date('Y-m-d h:i:s', strtotime($time));
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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
                $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
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

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {
                    DB::commit();
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
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

    public function cancelation($request)
    {

        // $coun=0;
        /*foreach ($request->cancel_checkbox as $key => $value) {
        $coun +=$value;
        }*/
        $coun = count($request->cancel_checkbox);
        // dd($coun);
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();

            $cancel_date = date('Y-m-d h:i:s', strtotime($time));
            $invoice_no = $request->hdn_invoice_no_fk;
            $item_no = $request->cancel_ind;
            $cencel_q = $request->cancel_checkbox;
            $i = 0;
            $item_no_arr = [];
            $cencel_q_arr = [];
            foreach ($item_no as $value) {
                $item_no_arr[$i] = $value;
                $cencel_q_arr[$i] = $cencel_q[$i]; //
                $i++;
            }
            //dd($item_no_arr, $cencel_q_arr);
            // $module_no=1;
            // $admission_no=1;
            $cunter_su_no = ($request->service_point != "") ? $request->service_point : 0;

            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            // $coun=3;
            $admission_id = $request->admission_no_pk;
            if ($admission_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            // $procedureName = "pkg_billing_dev_2.prc_sales_cancellation";
            $outError = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();

            $billinvoice = $pdo->prepare("begin pkg_billing.prc_sales_cancellation(:in_cancel_date,:in_invoice_no_pk,:in_item_no_fk,:in_cancel_qty,:in_item_count,:in_module_no_fk,:in_admission_no_fk,:in_counter_su_no_fk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_invoice_no,:out_invoice_id,:out_error); end;");

            $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
            $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
            $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_FLT);
            $billinvoice->bindParam(':in_item_count', $coun);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
            $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
            // dd($billinvoice);
            $billinvoice->execute();

            // $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success'];
            } else {
                DB::rollback();
                $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function pos_cancelation($request)
    {

        // $coun=0;
        /*foreach ($request->cancel_checkbox as $key => $value) {
        $coun +=$value;
        }*/
        $coun = count($request->cancel_checkbox);
        // dd($coun);
        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {

        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();

        $cancel_date = date('Y-m-d h:i:s', strtotime($time));
        $invoice_no = $request->hdn_invoice_no_fk;
        $item_no = $request->cancel_ind;
        $cencel_q = $request->cancel_checkbox;
        $i = 0;
        $item_no_arr = [];
        $cencel_q_arr = [];
        foreach ($item_no as $value) {
            $item_no_arr[$i] = $value;
            $cencel_q_arr[$i] = $cencel_q[$i]; //
            $i++;
        }
        // dd($item_no_arr, $cencel_q_arr);
        // $module_no=1;
        // $admission_no=1;
        $cunter_su_no = ($request->service_point != "") ? $request->service_point : 0;

        $entry_session = "session";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $numelems = 200;
        // $coun=3;
        $admission_id = $request->admission_no_pk;
        // if ($admission_id != "") {
        //    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
        //    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        // } else {
        $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        // }

        // $procedureName = "pkg_billing_dev_2.prc_sales_cancellation";
        $outError = $out_invoice_id = $out_invoice_no = '';
        $pdo = DB::getPdo();

        $billinvoice = $pdo->prepare("begin pkg_billing.prc_phr_sales_cancellation(:in_cancel_date,:in_invoice_no_pk,:in_item_no_fk,:in_cancel_qty,:in_item_count,:in_module_no_fk,:in_admission_no_fk,:in_counter_su_no_fk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_invoice_no,:out_invoice_id,:out_error); end;");

        $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
        $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
        $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_FLT);
        $billinvoice->bindParam(':in_item_count', $coun);
        $billinvoice->bindParam(':in_module_no_fk', $module_id);
        $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
        $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
        //   dd($billinvoice);
        $billinvoice->execute();

        // $result = DB::executeProcedure($procedureName, $dataBindingArr);

        if ($outError == '000') {
            DB::commit();
            $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success'];
        } else {

            DB::rollback();
            $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
        }

        // } catch (\Exception $e) {
        //    DB::rollback();
        //    $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }

    public function dueCollect($request)
    {

        $auth_id = Auth::id();
        DB::beginTransaction();

        try {
            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d h:i:s', strtotime($time));
            $cur_datetime = date('Y-m-d h:i:s', strtotime($time));

            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;
            $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
            $hdn_item_name = $request->hdn_item_name;
            $hdn_item_type = $request->hdn_item_type;
            $total_item = count($hdn_item_id);

            $txt_batch = $request->txt_batch;
            $txt_expire_date = $request->txt_expire_date;
            $hdn_item_rate = $request->hdn_item_rate;
            if ($page_type == 1) {
                $hdn_item_qnty = $request->hdn_item_qnty;
            } elseif ($page_type == 2) {
                // $hdn_item=$request->hdn_item_qnty;
                // $cancel_item=$request->actual_qty;
                $hdn_item_qnty = $request->actual_qty;
            }

            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

            $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
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
            $total_payment = $request->pay_amount;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
            $hospital_dis = ($request->discount_amt != "") ? $request->discount_amt : 0;
            $doctor_dis = ($request->doctor_amt != "") ? $request->doctor_amt : 0;

            $total_discount_amount = $hospital_dis + $doctor_dis;
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
            $numelems = 200;
            $zero = 0;

            if (empty($check_no)) {
                $check_no = $card_no;
            }
            if (empty($bank_name)) {
                $bank_name = $bank_name_card;
            }

            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = [];
            $i = 0;

            if (!empty($hdn_item_id)) {
                foreach ($hdn_item_id as $deli_date) {
                    $sc_date = date("d-m-Y");
                    $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
                    $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                    $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                    $hdn_item_urgent_fee_amt[$i] = ($hdn_item_urgent_fee[$i] == null) ? 0 : $hdn_item_urgent_fee[$i];

                    $i++;
                }
            }

            if ($page_type == 1) {
                if ($admission_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
            if ($page_type == 2) {
                $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            $out_invoice_no = $request->hdn_invoice_id;
            $item_dis_pers[] = 0;
            $item_dis_amt[] = 0;
            $in_item_level_disc_ind = 0;
            $out_invoice_no2 = $out_error = $out_ledger_no = "";
            $pdo1 = DB::getPdo();
            if ($page_type == 1) {

                $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_wp(:in_payment_date,
                  :in_payment_datetime,:in_invoice_no_fk,:in_module_no_fk,:in_patient_no_fk,:in_admission_no_fk,
                  :in_prescription_no_fk,:in_counter_su_no_fk,:in_ledger_amt_sales,:in_ledger_amt_payment,
                  :in_ledger_amt_discount,:in_urgent_fee,:in_service_charge,:in_cor_client_no_fk,:in_pay_mode,
                  :in_pay_cqcc_holder_name,:in_pay_cqcc_number,:in_pay_cqcc_deduct_percent,
                  :in_pay_bank_name,:in_pay_remarks,:in_given_amt,:in_disc_type_lookup_no_fk,:in_disc_remarks,
                  :in_disc_amt_by_doc,:in_disc_amt_by_doc_no_fk,:in_disc_amt_by_hosp,
                  :in_disc_amt_by_hosp_auth_by,:in_disc_amt_request_by_name,:in_au_entry_by,:in_au_entry_session,
                  :in_au_entry_hospital_pk_no,:in_item_count,:in_item_level_disc_ind,
                  :in_item_no_fk,:in_item_name,
                  :in_itemtype_no_fk,
                  :in_item_qty,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_itemurgent_fee,:in_itemservice_charge,
                  :in_package_item_ind,:out_invoice_no,:out_invoice_id,:out_ledger_no,:out_error);
                  end;");
            } elseif ($page_type == 2) {

                $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_phr_wp(:in_payment_date,
            :in_payment_datetime,:in_invoice_no_fk,:in_module_no_fk,:in_patient_no_fk,:in_admission_no_fk,
            :in_prescription_no_fk,:in_counter_su_no_fk,:in_ledger_amt_sales,:in_ledger_amt_payment,
            :in_ledger_amt_discount,:in_urgent_fee,:in_service_charge,:in_cor_client_no_fk,:in_pay_mode,
            :in_pay_cqcc_holder_name,:in_pay_cqcc_number,:in_pay_cqcc_deduct_percent,
            :in_pay_bank_name,:in_pay_remarks,:in_given_amt,:in_disc_type_lookup_no_fk,:in_disc_remarks,
            :in_disc_amt_by_doc,:in_disc_amt_by_doc_no_fk,:in_disc_amt_by_hosp,
            :in_disc_amt_by_hosp_auth_by,:in_disc_amt_request_by_name,:in_au_entry_by,:in_au_entry_session,
            :in_au_entry_hospital_pk_no,:in_item_count,:in_item_level_disc_ind,
            :in_item_no_fk,:in_item_name,
            :in_itemtype_no_fk,
            :in_item_qty,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_item_vat,:in_itemurgent_fee,:in_itemservice_charge,
            :in_package_item_ind,:out_invoice_no,:out_invoice_id,:out_ledger_no,:out_error);
            end;");
            }
            $billpayment->bindParam(':in_payment_date', $cur_date);
            $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
            $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
            $billpayment->bindParam(':in_module_no_fk', $module_id);
            $billpayment->bindParam(':in_patient_no_fk', $hdn_patient_id);

            $billpayment->bindParam(':in_admission_no_fk', $admission_id);
            $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
            $billpayment->bindParam(':in_counter_su_no_fk', $cunter_su_no);

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
            $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $auth_id); // will be adjust later
            $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);
            $billpayment->bindParam(':in_au_entry_by', $auth_id);
            $billpayment->bindParam(':in_au_entry_session', $entry_session);
            $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billpayment->bindParam(':in_item_count', $total_item);
            $billpayment->bindParam(':in_item_level_disc_ind', $in_item_level_disc_ind);
            $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            $billpayment->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
            } else {

                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);

                $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                // dd($query);

                $auth_id = Auth::id();

                date_default_timezone_set('Asia/Dhaka');
                $time = Carbon::now();

                $date = date('Y-m-d h:i:s', strtotime($time));
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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
                $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
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

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {
                    DB::commit();
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
                }

                // DB::commit();
                // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function createOrUpdateV1($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();

        try {
            
            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

            $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;
            $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
            $hdn_item_name = $request->hdn_item_name;
            $hdn_item_type = $request->hdn_item_type;
            $total_item = count($hdn_item_id);
            $txt_batch = $request->txt_batch;
            $item_vat_prse = $request->vat_pers;
            $provider_no = $request->hdn_provider;

            $txt_expire_date = $request->txt_expire_date;
            $hdn_item_rate = $request->hdn_item_rate;
            $hdn_item_qnty = $request->hdn_item_qnty;
            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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

            $total_payment = $request->total_payment;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
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
                    $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                    $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                    $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                    $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                    $item_disc_amount[$i] = $request->auto_discount[$i];
                    $ipd_charge[$i] = $request->ipd_charge[$i];
                    $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                    $item_level_remarks[$i] = 0;
                    $i++;
                }
            }
            $s_charge =$request->service_charge !="" ? $request->service_charge :0;// array_sum($ipd_charge);

            if ($admission_id != "") {
                // dd($admission_id,$request->emergency,$request->daycare);
                if ($request->emergency ==1) {
                    $module_info = DB::table("sysc_module")->where("module_code", "EMR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }elseif ($request->daycare==1) {
                    $module_info = DB::table("sysc_module")->where("module_code", "DYC")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }elseif ($request->ot==1) {
                    $module_info = DB::table("sysc_module")->where("module_code", "OT")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }else{
                    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
               
            } else {
                if ($service_appointment_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
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
         
            $emergency_ind=$request->emergency;
            $daycare_ind=$request->daycare;

            $pdo = DB::getPdo();
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(
            :in_invoice_date,
            :in_invoice_datetime,
            :in_module_no_fk,
            :in_patient_no_fk,
            :in_patient_code,
            :in_admission_no_pk,
            :in_admission_code,
            :in_appointment_no_fk,
            :in_prescription_no_fk,
            :in_doc_person_no_fk,
            :in_first_ref_doc,
            :in_second_ref_doc,
            :in_report_delivary_date,
            :in_report_deli_datetime,
            :in_counter_su_no_fk,
            :in_cor_client_no_fk,
            :in_cor_client_card_no_fk,
            :in_relation_lookup_no_fk,
            :in_ref_invoice_no_fk,
            :in_pat_type_lookup_no_fk,
            :in_dob,:in_age,
            :in_age_dd,
            :in_age_mm,
            :in_age_yy,
            :in_customer_addr,
            :in_customer_name,
            :in_gender_txt,
            :in_marital_status_txt,
            :in_blood_group,
            :in_phone_mobile,
            :in_invoice_remarks,
            :in_urgent_fee_total,
            :in_invoice_type,
            :in_emergency_ind,
            :in_daycare_ind,
            :in_ot_ind,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :in_item_level_disc_ind,
            :in_item_count,
            :in_item_no_fk,
            :in_item_batch_fk,
            :in_item_expiry_dt,
            :in_item_name,
            :in_itemtype_no_fk,
            :in_item_qty,
            :in_item_mu,
            :in_item_rate,
            :in_item_disc_percent,
            :in_item_disc_amount,
            :in_item_vat,
            :in_urgent_fee,
            :in_service_charge,
            :in_report_deli_date,
            :in_report_deli_time,
            :in_deli_status_lookup,
            :in_package_item_ind,
            :in_item_level_remarks,
            :in_provider_no_fk,
            :in_ledgertrn_no,
            :out_invoice_no,
            :out_invoice_id,
            :out_ledgertrn_no,
            :out_error); end;");

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
            $billinvoice->bindParam(':in_customer_addr', $null);
            $billinvoice->bindParam(':in_customer_name', $null);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $null);

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
            
            $billinvoice->execute();

            $out_ledgertrn_no2 = "";
            $responseBody='';
            if ($out_error == 999) {
                // dd($out_error);
                DB::rollback();
                $message = ['msg' => 'prc_billinvoice_wp create Failled.' . $out_error, 'title' => 'Error'];
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
                $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
                    $message = ['msg' => 'prc_billpayment_wp create Failled.', 'title' => 'Error'];
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
                    if ($out_error !=999) {

                       if (!empty($in_paymood_arr_t)) {
                        foreach ($in_paymood_arr_t as $key => $value) {
                            $data=[
                                'card_invoice_no'=>  $request->invoice_number[$j],
                            ];
                            $in_bank_name_arr_val[$j] = (!empty($in_bank_name_arr_t[$j]) ? $in_bank_name_arr_t[$j] : "");
                            $payment_details[$j]=DB::table('finc_ledger_paymood')->where('invoice_no_fk',$invoice_no)->where('ledger_no_fk',$ledger_no)->where('paymood','CARD')
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
                       
                        if (Session::get('user.ses_hospital_code') == "DMHL" && $request->apiDiscount_ind == 1) {
                            $discount_perc_amt=0;
                            if (!empty($hdn_item_id)) {                              
                                foreach ($hdn_item_id as $key => $value) {
                                    $item_info=DB::table('sysc_serviceitem')->select('default_discount_pct','sales_price','disc_aplicable')->where('item_no_pk',$value)->first();
                                    $discount = $item_info->default_discount_pct != null ? $item_info->default_discount_pct : 0;
                                    $sales_price = $item_info->sales_price != null ? $item_info->sales_price : 0;
                                    $corporate_id_info=$corporate_id !=''? $corporate_id :0;
                                    $patient_type_code=$request->patient_type_code;
                                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value,'$patient_type_code',$corporate_id_info, $sales_price,0,$discount,'AMTPCT') as def_discount from dual"));//AMT, PTC
                                    $discount_perc_amt +=$def_dis[0]->def_discount  != "" && $item_info->disc_aplicable != 1 ?  $def_dis[0]->def_discount :0 ;
                                    // dd($hdn_item_id,$request->auto_discount, $discount_perc,$patient_type_code,$corporate_id_info);
                                }
                            }
                            $get_card_no = DB::table('patn_registration')->select('membershid_id')->where('patient_no_pk', $hdn_patient_id)->first();          
                            $input_value = $get_card_no->membershid_id ?? '';
                        
                            $total_discount = $total_discount_amount ?? 0;                          
                            $total_payment_amt = $total_payment ?? 0;                           
                            $totalhcsclaimamountpl = $request->total_payable;
                            $item_total_amount = array_sum($request->hdn_item_total_qnty);
                        
                            $null = '';
                            $zoro="0";
                            $typeCode =$request->discounttypecode;
                            // dd( $typeCode);
                            if ($input_value != "") {
                                // Define the API endpoint URL
                                
                                $url = 'https://hisapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';          
                                // $token = 'kOhNR/cQrqfOy5tSG1/KkRFUFZHBV/O20tv91jnSM6GuiGwAcOtbSMtIByYQRlj3cvu4Qdj76qrDM2nyi1ei/7E4occAJHXFeW5wG+FK2cVs2x2fnn2Txk7/eHfyRWmx+9D5nzXDMSAV0hDXkWxxwlb60rIWkMBxJDJElZWbNCsBLHRnzTH1eo1g2/RAtB9Ck1OZe8wLBLwplSqKSMwUjAAUpv26MIikFvv2COHU3qbyRau/FdL67v3/8epOZctjaPUQK/cDohVXAO5u97SVrvSJ0pxb2V2GLqX7ak29qvhMAvqnIFRFUhryi4pavxxo';
                                $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';
                                
                                // $url = 'https://hisstagingapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                                // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';
    
                                // Prepare the data to be sent in the POST request
                                $data =(object) [
                                    "ByUserId"          => "8415",
                                    "PersonId"          => "121529",
                                    "MemberIdentity"    => $input_value,
                                    "BillNo"            => $out_invoice_no,
                                    "DiscountDetails"   => [(object)[
                                        "DiscountTypeCode"      => $typeCode,
                                        "DCDiscountPercentage"  => $zoro,
                                        "DCDiscountAmount"      => $total_discount,
                                        "DMHDiscountPercentage" => $zoro,
                                        "DMHDiscountAmount"     => $discount_perc_amt,
                                        "AfterDiscountAmount"   => $totalhcsclaimamountpl
                                    ]],
                                    "TotalHCSClaimAmount"=> strval($total_discount),
                                    "FinalPayment"       =>  $totalhcsclaimamountpl,
                                    "BillDate"           => $cur_date,                                    
                                    "Remarks"            => $null,
                                    "DiseaseName"        => $null,
                                    "VoucherStatus"      => 1,
                                    "MobileNumber"       => "-",
                                    "UserName"           => "info@divinemercyhospital.com",
                                    "RequestFrom"        => "HIS"
                                ];
                                
                                try {
                                    // Create a Guzzle client instance
                                    $client = new Client();                       
                                    // Make the POST request with the authorization token and data
                                    $response = $client->post($url, [
                                        'headers' => [
                                            // 'Authorization' => 'Bearer ' . $token,
                                            'token'=>$token,
                                            'Content-Type' => 'application/json',
                                        ],
                                        'json' => $data
                                    ]);
                                    
                                    // Check response status code
                                    if ($response->getStatusCode() == 200) {
                                        // Get the response body
                                        $responseBody = json_decode($response->getBody(), true);
                                        // dd( $responseBody);
                                        DB::table('finc_ledgermst')->where('invoice_no_fk',$out_invoice_no)->update(['apidiscount_type'=>$typeCode]);
                                        $ledger_dtl = DB::table('finc_ledgermst')
                                        ->where('invoice_no_fk', $out_invoice_no)
                                        ->update([  
                                            'hospital_total_discount' => $discount_perc_amt,
                                            'api_total_discount' => $total_discount
                                        ]);
                                        // ->pluck('ledger_no_pk')
                                        // ->toArray();
                                        // DB::table('finc_ledgerdtl')
                                        // ->whereIn('ledger_no_fk', $ledger_dtl)
                                        // ->update([
                                        //     'hospital_total_discount' => $discount_perc_amt,
                                        //     'api_total_discount' => $total_discount
                                        // ]);
                                        


                                        DB::commit();
                                        $message = [
                                            'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                            'title' => 'Success', 
                                            'insert_id' => $out_invoice_no2, 
                                            'trx_id' => $out_ledgertrn_no,
                                            'responseBody' => $responseBody
                                        ];
                                    } else {
                                        $message=[
                                            'message' => 'Request failed',
                                            'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                        ];
                                        // return response()->json([
                                        //     'message' => 'Request failed',
                                        //     'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                        // ], $response->getStatusCode());
                                    }
                        
                                } catch (\GuzzleHttp\Exception\RequestException $e) {
                                    // Handle request exceptions
                                    $message =[
                                        'message' => 'Request failed',
                                        'error' => $e->getMessage()
                                    ];
                                    // return response()->json([
                                    //     'message' => 'Request failed',
                                    //     'error' => $e->getMessage()
                                    // ], $e->getCode());
                                }
                            }
                        } else {
                            DB::commit();
                            $message = [
                                'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                'title' => 'Success', 
                                'insert_id' => $out_invoice_no2, 
                                'trx_id' => $out_ledgertrn_no
                            ];
                        }
                        
 
                        // DB::commit();
                        // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                    }
                }
                /*  dd($in_paymood_arr_val,$in_pay_mood_type_arr_val);*/


                // TV Update
                if(DB::table('SYSC_TVSCREENSETUP')->where('TVTAG','APPOINTMENTTV')->value('status') == 1){
                    DB::table('opd_patdisplay')->where('APPOINT_NO_FK', $service_appointment_id)->update(['BIL_IND' => 1]);
                    DB::commit();
                    $data = $this->tv_information->get_tv_data(null);
                    event(new TVUpdate($data));
                }
                else{
                    DB::commit(); 
                }
                // TV Update
                
                $message = [
                    'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                    'title' => 'Success', 
                    'insert_id' => $out_invoice_no2, 
                    'trx_id' => $out_ledgertrn_no,
                    'responseBody' => $responseBody
                ];


                

            }
        } catch (\Exception $e) {
            DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function createOrUpdateV2($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
       
        try {
            
           
            $out_patient_no_pk = $out_patient_code = $patient_out_error = "";
            if ($request->hdn_patient_id =="") {
                DB::beginTransaction();
                $pdo                            = DB::getPdo();
                $pat_salutation                 = '';
                $patient_no                     = $request->hdn_patient_no_pk;
                $corporate_id                   = $request->corporate_name;
                $corporate_name                 = '';
                if ($corporate_id              != "") {
                    $corporate_name            = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
                }
                $appoint_source                = 'WEB';
                $entry_session                 = 'session';
                $hospital_id                   = Session::get('user.ses_hospital_no_pk');
                $is_pay_consultation           = $request->is_pay_consultation;
                $dob                           = $request->patient_dob;
                $patient_name                  = $request->input_patient_name;
                $pat_email                     = $request->in_email;
                $pat_age_d                     = $request->pat_age_d;
                $pat_age_m                     = $request->pat_age_m;
                $pat_age_y                     = $request->pat_age_y;
                $age                           =$request->pat_age_d.' '. $request->pat_age_m .' '.$request->pat_age_y;
                $patient_dob                   =$request->patient_dob !="" ? date('Y-m-d', strtotime($request->patient_dob)):'';
                $temp                          = explode("_", $request->input_gender);
                $patient_gender                = isset($temp[0]) ? $temp[0] : 0;
                $gender_txt                    = isset($temp[1]) ? $temp[1] : 0;
                $temp_mari                     = explode("_", $request->marital_status);
                $marital_status                = isset($temp_mari[0]) ? $temp_mari[0] : 0;
                $marital_status_txt            = isset($temp_mari[1]) ? $temp_mari[1] : 0;
    
                $phone_no                      = $request->input_mobile_no;
                $pat_religion                  = $request->religion;
                $pat_address                   = $request->pat_address;
                $pat_address1                  = $pat_address2 = '';
                $blood_group                   = $request->blood_group;
                $patient_type                  = $request->patient_type;
                $phone_no                      = $request->input_mobile_no;
                $zero                          = 0;
                $null                          = null;
                $in_father_name                = $request->in_father_name;
                $in_mother_name                = $request->in_mother_name;
                $in_spouse_name                = $request->in_spouse_name;
                $in_national_id                = $request->in_national_id;
    
                $in_pr_addr_thana              = $request->in_pr_addr_thana;
                $in_pe_addr_thana              = $request->in_per_addr_thana;
                $in_present_district           = $request->in_present_district;
                $in_present_post_code          = $request->in_present_post_code;
                $in_pr_addr_country            = $request->in_pr_addr_country;
                $in_permanent_addr             = $request->in_permanent_addr;
                $in_permanent_district         = $request->in_permanent_district;
                $in_pe_addr_country            = $request->in_pe_addr_country;
                $in_emergency_contact_name     = $request->emr_name;
                $in_emergency_contact_relation = $request->in_emergency_contact_relation;
                $in_emergency_contact_contact  = $request->in_emergency_contact_contact;
                $in_payer_type_code            = $request->payer_type;
                $in_occupation                 = $request->in_occupation;
                $in_vip_ind                    = $request->in_occupation;
                $in_vip_narration              = $request->in_vip_narration;
                $in_reg_remarks                = $request->in_reg_remarks;
                $in_last_edit_reason           = $request->in_last_edit_reason;
                $passport_no                   = $request->passport_id;
                $in_mobile2_alt                = $request->in_mobile2_alt;
                $hdn_patient_id                = $request->hdn_patient_id;
                $hdn_doctor_id                 = $request->hdn_doctor_id;
                $realation_pat                 = $request->realation_pat;
    
                $in_fall_risk                  = $request->in_fall_risk;
                $in_n_masking                  = $request->in_n_masking;
                $in_h_with_care                = $request->in_h_with_care;
                $in_guardian_name              = $request->in_guardian_name;
                $in_nationality                = $request->nationality;
                $in_status                     = 1;// $request->in_status;
                $auth_id                       = Auth::user()->user_no_pk;
                $per_state_division            = $request->per_state_division;
                $state_division                = $request->state_division;
                $imageName                     = " ";
                $visa_validity                 = $request->visa_validity;
                // OUT PAREMETER INITIALIZE
                
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_patregistration_quick(
                    :in_patient_no_pk,
                    :in_salutation,
                    :in_patient_name,
                    :in_phone_mobile,
                    :in_mobile2_alt,
                    :in_email,
                    :in_dob,
                    :in_age_dd,
                    :in_age_mm,
                    :in_age_yy,
                    :in_age,
                    :in_gender,
                    :in_gender_txt,
                    :in_marital_status,
                    :in_marital_status_txt,
                    :in_religion,
                    :in_address,
                    :in_address1,
                    :in_address2,
                    :in_blood_group,
                    :in_patient_type_no_fk,
                    :in_ref_patient_no_fk,
                    :in_ref_person_no_fk,
                    :in_ref_person_no_fk_rel,
                    :in_father_name,
                    :in_mother_name,
                    :in_spouse_name,
                    :in_national_id,
                    :in_present_addr,
                    :in_pr_addr_thana,
                    :in_present_district,
                    :in_present_post_code,
                    :in_pr_addr_country,
                    :in_permanent_addr,
                    :in_pe_addr_thana,
                    :in_permanent_district,
                    :in_permanent_post_code,
                    :in_pe_addr_country,
                    :in_emergency_contact_name,
                    :in_emergency_contact_addr,
                    :in_emergency_contact_relation,
                    :in_emergency_contact_contact,
                    :in_payer_type_code,
                    :in_occupation,
                    :in_vip_ind,
                    :in_vip_narration,
                    :in_last_edit_reason,
                    :in_reg_remarks,
                    :in_ccm_client_no_fk,
                    :in_ccm_client_name,
                    :in_passport_no,
                    :in_patient_photo,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :in_fall_risk,
                    :in_n_masking,
                    :in_h_with_care,
                    :in_guardian_name,
                    :in_nationality,
                    :in_status,
                    :in_present_state,
                    :in_parmamnent_state,
                    :in_sponsor_no_fk,
                    :in_visa_validate,
                    :out_patient_no_pk,
                    :out_patient_code,
                    :out_error
                ); end;");
    
                $stmt->bindParam(':in_patient_no_pk', $patient_no);
                $stmt->bindParam(':in_salutation', $pat_salutation);
                $stmt->bindParam(':in_patient_name', $patient_name);
                $stmt->bindParam(':in_phone_mobile', $phone_no);
                $stmt->bindParam(':in_mobile2_alt', $in_mobile2_alt);
                $stmt->bindParam(':in_email', $pat_email, PDO::PARAM_STR, 255);
                $stmt->bindParam(':in_dob', $patient_dob);
                $stmt->bindParam(':in_age_dd', $pat_age_d);
                $stmt->bindParam(':in_age_mm', $pat_age_m);
                $stmt->bindParam(':in_age_yy', $pat_age_y);
                $stmt->bindParam(':in_age', $age, PDO::PARAM_INT);
                $stmt->bindParam(':in_gender', $patient_gender);
                $stmt->bindParam(':in_gender_txt', $gender_txt);
                $stmt->bindParam(':in_marital_status', $marital_status);
                $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
                $stmt->bindParam(':in_religion', $pat_religion);
                $stmt->bindParam(':in_address', $pat_address);
                $stmt->bindParam(':in_address1', $pat_address1);
                $stmt->bindParam(':in_address2', $pat_address2);
                $stmt->bindParam(':in_blood_group', $blood_group);
                $stmt->bindParam(':in_patient_type_no_fk', $patient_type, PDO::PARAM_INT);
                $stmt->bindParam(':in_ref_patient_no_fk', $hdn_patient_id);
                $stmt->bindParam(':in_ref_person_no_fk', $hdn_doctor_id);
                $stmt->bindParam(':in_ref_person_no_fk_rel', $realation_pat);
                $stmt->bindParam(':in_father_name', $in_father_name);
                $stmt->bindParam(':in_mother_name', $in_mother_name);
                $stmt->bindParam(':in_spouse_name', $in_spouse_name);
                $stmt->bindParam(':in_national_id', $in_national_id);
                $stmt->bindParam(':in_present_addr', $pat_address);
                $stmt->bindParam(':in_pr_addr_thana', $in_pr_addr_thana);
                $stmt->bindParam(':in_present_district', $in_present_district);
                $stmt->bindParam(':in_present_post_code', $in_present_post_code);
                $stmt->bindParam(':in_pr_addr_country', $in_pr_addr_country);
                $stmt->bindParam(':in_permanent_addr', $in_permanent_addr);
                $stmt->bindParam(':in_pe_addr_thana', $in_pe_addr_thana);
                $stmt->bindParam(':in_permanent_district', $in_permanent_district);
                $stmt->bindParam(':in_permanent_post_code', $zero);
                $stmt->bindParam(':in_pe_addr_country', $in_pe_addr_country);
                $stmt->bindParam(':in_emergency_contact_name', $in_emergency_contact_name);
                $stmt->bindParam(':in_emergency_contact_addr', $null);
                $stmt->bindParam(':in_emergency_contact_relation', $in_emergency_contact_relation);
                $stmt->bindParam(':in_emergency_contact_contact', $in_emergency_contact_contact);
                $stmt->bindParam(':in_payer_type_code', $in_payer_type_code);
                $stmt->bindParam(':in_occupation', $in_occupation);
                $stmt->bindParam(':in_vip_ind', $in_vip_ind);
                $stmt->bindParam(':in_vip_narration', $in_vip_narration);
                $stmt->bindParam(':in_last_edit_reason', $in_last_edit_reason);
                $stmt->bindParam(':in_reg_remarks', $in_reg_remarks);
                $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
                $stmt->bindParam(':in_ccm_client_name', $corporate_name);
                $stmt->bindParam(':in_passport_no', $passport_no);
                $stmt->bindParam(':in_patient_photo', $imageName);
                $stmt->bindParam(':in_au_entry_by', $auth_id);
                $stmt->bindParam(':in_au_entry_session', $entry_session);
                $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $stmt->bindParam(':in_fall_risk', $in_fall_risk);
                $stmt->bindParam(':in_n_masking', $in_n_masking);
                $stmt->bindParam(':in_h_with_care', $in_h_with_care);
                $stmt->bindParam(':in_guardian_name', $in_guardian_name);
                $stmt->bindParam(':in_nationality', $in_nationality);
                $stmt->bindParam(':in_status', $in_status);
                $stmt->bindParam(':in_present_state', $state_division);
                $stmt->bindParam(':in_parmamnent_state', $per_state_division);
                $stmt->bindParam(':in_sponsor_no_fk', $zero, PDO::PARAM_INT);
                $stmt->bindParam(':in_visa_validate', $visa_validity);
                $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
                $stmt->bindParam(':out_error', $patient_out_error, PDO::PARAM_STR, 500);
                // dd( $stmt);
                $stmt->execute();
                // DB::commit();
            }
           
            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : $out_patient_no_pk;
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id :  $out_patient_code;
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

            $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;
            $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
            $hdn_item_name = $request->hdn_item_name;
            $hdn_item_type = $request->hdn_item_type;
            $total_item = count($hdn_item_id);
            $txt_batch = $request->txt_batch;
            $item_vat_prse = $request->vat_pers;
            $provider_no = $request->hdn_provider;

            $txt_expire_date = $request->txt_expire_date;
            $hdn_item_rate = $request->hdn_item_rate;
            $hdn_item_qnty = $request->hdn_item_qnty;
            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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

            $total_payment = $request->total_payment;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
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
                    $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                    $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                    $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                    $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                    $item_disc_amount[$i] = $request->auto_discount[$i];
                    $ipd_charge[$i] = $request->ipd_charge[$i];
                    $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                    $item_level_remarks[$i] = 0;
                    $i++;
                }
            }
            $s_charge =$request->service_charge !="" ? $request->service_charge :0;// array_sum($ipd_charge);

            if ($admission_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                if ($service_appointment_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
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
         
            $emergency_ind=$request->emergency;
            $daycare_ind=$request->daycare;

            $pdo = DB::getPdo();
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(
            :in_invoice_date,
            :in_invoice_datetime,
            :in_module_no_fk,
            :in_patient_no_fk,
            :in_patient_code,
            :in_admission_no_pk,
            :in_admission_code,
            :in_appointment_no_fk,
            :in_prescription_no_fk,
            :in_doc_person_no_fk,
            :in_first_ref_doc,
            :in_second_ref_doc,
            :in_report_delivary_date,
            :in_report_deli_datetime,
            :in_counter_su_no_fk,
            :in_cor_client_no_fk,
            :in_cor_client_card_no_fk,
            :in_relation_lookup_no_fk,
            :in_ref_invoice_no_fk,
            :in_pat_type_lookup_no_fk,
            :in_dob,:in_age,
            :in_age_dd,
            :in_age_mm,
            :in_age_yy,
            :in_customer_addr,
            :in_customer_name,
            :in_gender_txt,
            :in_marital_status_txt,
            :in_blood_group,
            :in_phone_mobile,
            :in_invoice_remarks,
            :in_urgent_fee_total,
            :in_invoice_type,
            :in_emergency_ind,
            :in_daycare_ind,
            :in_ot_ind,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :in_item_level_disc_ind,
            :in_item_count,
            :in_item_no_fk,
            :in_item_batch_fk,
            :in_item_expiry_dt,
            :in_item_name,
            :in_itemtype_no_fk,
            :in_item_qty,
            :in_item_mu,
            :in_item_rate,
            :in_item_disc_percent,
            :in_item_disc_amount,
            :in_item_vat,
            :in_urgent_fee,
            :in_service_charge,
            :in_report_deli_date,
            :in_report_deli_time,
            :in_deli_status_lookup,
            :in_package_item_ind,
            :in_item_level_remarks,
            :in_provider_no_fk,
            :in_ledgertrn_no,
            :out_invoice_no,
            :out_invoice_id,
            :out_ledgertrn_no,
            :out_error); end;");

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
            $billinvoice->bindParam(':in_dob', $null);
            $billinvoice->bindParam(':in_age', $null);
            $billinvoice->bindParam(':in_age_dd', $null);
            $billinvoice->bindParam(':in_age_mm', $null);
            $billinvoice->bindParam(':in_age_yy', $null);
            $billinvoice->bindParam(':in_customer_addr', $null);
            $billinvoice->bindParam(':in_customer_name', $null);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $null);

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
            
            $billinvoice->execute();

            $out_ledgertrn_no2 = "";
            $responseBody='';
            if ($out_error == 999) {
                // dd($out_error);
                DB::rollback();
                $message = ['msg' => 'prc_billinvoice_wp create Failled.' . $out_error, 'title' => 'Error'];
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
                $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
                    $message = ['msg' => 'prc_billpayment_wp create Failled.', 'title' => 'Error'];
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
                    if ($out_error !=999) {

                       if (!empty($in_paymood_arr_t)) {
                        foreach ($in_paymood_arr_t as $key => $value) {
                            $data=[
                                'card_invoice_no'=>  $request->invoice_number[$j],
                            ];
                            $in_bank_name_arr_val[$j] = (!empty($in_bank_name_arr_t[$j]) ? $in_bank_name_arr_t[$j] : "");
                            $payment_details[$j]=DB::table('finc_ledger_paymood')->where('invoice_no_fk',$invoice_no)->where('ledger_no_fk',$ledger_no)->where('paymood','CARD')
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
                      
                       
                        if (Session::get('user.ses_hospital_code') == "DMHL" && $request->apiDiscount_ind == 1) {
                            $discount_perc_amt=0;
                            if (!empty($hdn_item_id)) {                              
                                foreach ($hdn_item_id as $key => $value) {
                                    $item_info=DB::table('sysc_serviceitem')->select('default_discount_pct','sales_price','disc_aplicable')->where('item_no_pk',$value)->first();
                                    $discount = $item_info->default_discount_pct != null ? $item_info->default_discount_pct : 0;
                                    $sales_price = $item_info->sales_price != null ? $item_info->sales_price : 0;
                                    $corporate_id_info=$corporate_id !=''? $corporate_id :0;
                                    $patient_type_code=$request->patient_type_code;
                                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value,'$patient_type_code',$corporate_id_info, $sales_price,0,$discount,'AMTPCT') as def_discount from dual"));//AMT, PTC
                                    $discount_perc_amt +=$def_dis[0]->def_discount  != "" && $item_info->disc_aplicable != 1 ?  $def_dis[0]->def_discount :0 ;
                                    // dd($hdn_item_id,$request->auto_discount, $discount_perc,$patient_type_code,$corporate_id_info);
                                }
                            }
                            $get_card_no = DB::table('patn_registration')->select('membershid_id')->where('patient_no_pk', $hdn_patient_id)->first();          
                            $input_value = $get_card_no->membershid_id ?? '';
                        
                            $total_discount = $total_discount_amount ?? 0;                          
                            $total_payment_amt = $total_payment ?? 0;                           
                            $totalhcsclaimamountpl = $request->total_payable;
                            $item_total_amount = array_sum($request->hdn_item_total_qnty);
                        
                            $null = '';
                            $zoro="0";
                            $typeCode =$request->discounttypecode;
                            // dd( $typeCode);
                            if ($input_value != "") {
                                // Define the API endpoint URL
                                
                                $url = 'https://hisapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';          
                                // $token = 'kOhNR/cQrqfOy5tSG1/KkRFUFZHBV/O20tv91jnSM6GuiGwAcOtbSMtIByYQRlj3cvu4Qdj76qrDM2nyi1ei/7E4occAJHXFeW5wG+FK2cVs2x2fnn2Txk7/eHfyRWmx+9D5nzXDMSAV0hDXkWxxwlb60rIWkMBxJDJElZWbNCsBLHRnzTH1eo1g2/RAtB9Ck1OZe8wLBLwplSqKSMwUjAAUpv26MIikFvv2COHU3qbyRau/FdL67v3/8epOZctjaPUQK/cDohVXAO5u97SVrvSJ0pxb2V2GLqX7ak29qvhMAvqnIFRFUhryi4pavxxo';
                                $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';
                                
                                // $url = 'https://hisstagingapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                                // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';
    
                                // Prepare the data to be sent in the POST request
                                $data =(object) [
                                    "ByUserId"          => "8415",
                                    "PersonId"          => "121529",
                                    "MemberIdentity"    => $input_value,
                                    "BillNo"            => $out_invoice_no,
                                    "DiscountDetails"   => [(object)[
                                        "DiscountTypeCode"      => $typeCode,
                                        "DCDiscountPercentage"  => $zoro,
                                        "DCDiscountAmount"      => $total_discount,
                                        "DMHDiscountPercentage" => $zoro,
                                        "DMHDiscountAmount"     => $discount_perc_amt,
                                        "AfterDiscountAmount"   => $totalhcsclaimamountpl
                                    ]],
                                    "TotalHCSClaimAmount"=> strval($total_discount),
                                    "FinalPayment"       =>  $totalhcsclaimamountpl,
                                    "BillDate"           => $cur_date,                                    
                                    "Remarks"            => $null,
                                    "DiseaseName"        => $null,
                                    "VoucherStatus"      => 1,
                                    "MobileNumber"       => "-",
                                    "UserName"           => "info@divinemercyhospital.com",
                                    "RequestFrom"        => "HIS"
                                ];
                                
                                try {
                                    // Create a Guzzle client instance
                                    $client = new Client();                       
                                    // Make the POST request with the authorization token and data
                                    $response = $client->post($url, [
                                        'headers' => [
                                            // 'Authorization' => 'Bearer ' . $token,
                                            'token'=>$token,
                                            'Content-Type' => 'application/json',
                                        ],
                                        'json' => $data
                                    ]);
                                    
                                    // Check response status code
                                    if ($response->getStatusCode() == 200) {
                                        // Get the response body
                                        $responseBody = json_decode($response->getBody(), true);
                                        // dd( $responseBody);
                                        DB::table('finc_ledgermst')->where('invoice_no_fk',$out_invoice_no)->update(['apidiscount_type'=>$typeCode]);
                                        DB::commit();
                                        $message = [
                                            'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                            'title' => 'Success', 
                                            'insert_id' => $out_invoice_no2, 
                                            'trx_id' => $out_ledgertrn_no,
                                            'responseBody' => $responseBody
                                        ];
                                    } else {
                                        $message=[
                                            'message' => 'Request failed',
                                            'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                        ];
                                        // return response()->json([
                                        //     'message' => 'Request failed',
                                        //     'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                        // ], $response->getStatusCode());
                                    }
                        
                                } catch (\GuzzleHttp\Exception\RequestException $e) {
                                    // Handle request exceptions
                                    $message =[
                                        'message' => 'Request failed',
                                        'error' => $e->getMessage()
                                    ];
                                    // return response()->json([
                                    //     'message' => 'Request failed',
                                    //     'error' => $e->getMessage()
                                    // ], $e->getCode());
                                }
                            }
                        } else {
                            DB::commit();
                            $message = [
                                'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                'title' => 'Success', 
                                'insert_id' => $out_invoice_no2, 
                                'trx_id' => $out_ledgertrn_no
                            ];
                        }
                        
 
                        // DB::commit();
                        // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                    }
                }
                /*  dd($in_paymood_arr_val,$in_pay_mood_type_arr_val);*/

                DB::commit();
                $message = [
                    'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                    'title' => 'Success', 
                    'insert_id' => $out_invoice_no2, 
                    'trx_id' => $out_ledgertrn_no,
                    'responseBody' => $responseBody
                ];

            }
        } catch (\Exception $e) {
            DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }



    public function createOrUpdateUhlV1($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();

        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d H:i:s', strtotime($time)); 
        $cur_datetime = date('Y-m-d H:i:s', strtotime($time));
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $patient_type_no = !empty($request->patient_type) ? $request->patient_type : 0;
       
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        $cmb_discount = $request->cmb_discount;
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
        $urgent_fee = $request->urgent_fee ?? 0;
        $total_payment = $request->total_payment;
        $entry_session = "session";
        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
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
        // $payer_type = $request->payer_type;
        $payer_type = $request->patient_type;
        // $sponsor_ccm_client_no_pk = $request->payer__sponsor;
        $sponsor_ccm_client_no_pk = $request->corporate_name;
        $referred_type = isset($request->refferred_type) ? $request->refferred_type :'' ;
        $source_no_fk = isset($request->source) ? $request->source :'' ;
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

        $payer_amt=[];
        $in_purchaseorderdtl_no_pk = [];
        $in_inv_requisitiondtl_no_pk = [];
        $in_itemreceivedtl_no_pk = [];
        $in_cost_price = [];
        $in_internal_batch_no_uq = [];
        $regisFeeInd=true;
        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $item_disc_amount_doc[$i]=$request->auto_discount_doc[$i];
                $item_disc_amount_doc_no_fk[$i]=$hdn_dis_doctor_id ;
                $provider_id[$i]=$request->hdn_provider[$i] !="" ? $request->hdn_provider[$i]: '';
                $ipd_charge[$i] = $request->service_charge[$i] ?? 0;
                $hdn_item_type[$i] = $request->hdn_item_type[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $item_level_remarks[$i] = 0;
                $payer_amt[$i] = 0;

                $in_purchaseorderdtl_no_pk[$i] = 0;
                $in_inv_requisitiondtl_no_pk[$i] = 0;
                $in_itemreceivedtl_no_pk[$i] = 0;
                $in_cost_price[$i] = 0;
                $in_internal_batch_no_uq[$i] = 'test batch';
                //    ($request->bill_type=="app" || $request->bill_type=="PKG") &&
                if ( Session::get('user.ses_hospital_code')=="UNICO" ) {
                    $reg_fee=DB::table('sysc_serviceitem')->select('item_code')->where('item_no_pk',$deli_date)->first();
                   
                    if (!empty($reg_fee) && $reg_fee->item_code=="REGFEE" && $regisFeeInd==true) {                     
                        DB::table('patn_registration')->where('patient_no_pk',$hdn_patient_id)->update(['reg_card_fee_paid_ind'=> 1]);
                         $regisFeeInd==false;
                    }
                   
                }
               
                $i++;
            }
        }
        
        $s_charge = array_sum($ipd_charge);
       
        if (!empty($admission_id)) {
            if(strtoupper($request->bill_type)=="OT"){
                $module_info = DB::table("sysc_module")->where("module_code", "OT")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }else{
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            
            
        } else {
            if (!empty($service_appointment_id)) {
                if (strtoupper($request->bill_type)=="PKG") {
                    $module_info = DB::table("sysc_module")->where("module_code", "PKG")->select("module_no_pk")->first();
                }else{
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                }
               
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }

        if (!empty($hdn_patient_id)) {
            // $corporate_id = $request->corporate_name;
            $corporate_id = $request->corporate_name;
        } else {
            $corporate_id = null;
        }
        // dd($corporate_id);
        // OUT PAREMETER INITIALIZE
        $out_ledgertrn_no = 0;
     
        $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;
        
        if (array_sum($item_disc_amount) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }

        $email_ind = null;
        $email_id = null;


        $out_invoice_id = null;
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_v1_billing.prc_billinvoice_wp(
                                                :in_invoice_date,
                                                :in_invoice_datetime,
                                                :in_module_no_fk,
                                                :in_patient_no_fk,
                                                :in_patient_code,
                                                :in_admission_no_pk,
                                                :in_admission_code,
                                                :in_appointment_no_fk,
                                                :in_prescription_no_fk,
                                                :in_doc_person_no_fk,
                                                :in_first_ref_doc_person_no_fk,
                                                :in_second_ref_doc_person_no_fk,
                                                :in_report_delivary_date,
                                                :in_report_deli_datetime,
                                                :in_counter_su_no_fk,
                                                :in_cor_client_no_fk,
                                                :in_cor_client_card_no_fk,
                                                :in_relation_lookup_no_fk,
                                                :in_ref_invoice_no_fk,
                                                :in_pat_type_lookup_no_fk,
                                                :in_pat_type,
                                                :in_dob,
                                                :in_age,
                                                :in_age_dd,
                                                :in_age_mm,
                                                :in_age_yy,
                                                :in_customer_addr,
                                                :in_customer_name,
                                                :in_gender_txt,
                                                :in_marital_status_txt,
                                                :in_blood_group,
                                                :in_phone_mobile,
                                                :in_invoice_remarks,
                                                :in_urgent_fee_total,
                                                :in_invoice_type,
                                                :in_au_entry_by,
                                                :in_au_entry_session,
                                                :in_au_entry_hospital_pk_no,
                                                :in_payer_type,
                                                :in_sponsor_ccm_client_no_pk,
                                                :in_referred_type,
                                                :in_source_no_fk,
                                                :in_email_ind,
                                                :in_email_id,
                                                :in_item_level_disc_ind,
                                                :in_item_count,
                                                :in_item_no_fk,
                                                :in_item_batch_fk,
                                                :in_item_expiry_dt,
                                                :in_item_name,
                                                :in_itemtype_no_fk,
                                                :in_item_qty,
                                                :in_item_mu,
                                                :in_item_rate,
                                                :in_item_disc_percent,
                                                :in_item_disc_amount,
                                                :in_item_disc_amt_by_doc,
                                                :in_item_disc_amt_by_doc_no_fk,
                                                :in_item_vat,
                                                :in_urgent_fee,
                                                :in_service_charge,
                                                :in_report_delivery_date,
                                                :in_report_delivery_time,
                                                :in_delivery_status_lookup_no_fk,
                                                :in_package_item_ind,
                                                :in_item_level_remarks,
                                                :in_provider_person_no_fk,
                                                :in_payer_amt,
                                                :in_purchaseorderdtl_no_pk,
                                                :in_inv_requisitiondtl_no_pk,
                                                :in_itemreceivedtl_no_pk,
                                                :in_cost_price,
                                                :in_internal_batch_no_uq,
                                                :in_ledgertrn_no,
                                                :out_invoice_no,
                                                :out_invoice_id,
                                                :out_ledgertrn_no,
                                                :out_error); end;"
        );
      
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
        $billinvoice->bindParam(':in_first_ref_doc_person_no_fk', $hdn_first_referral_id);
        $billinvoice->bindParam(':in_second_ref_doc_person_no_fk', $hdn_second_referral_id);
        $billinvoice->bindParam(':in_report_delivary_date', $report_delivery_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        $billinvoice->bindParam(':in_cor_client_no_fk', $corporate_id);
        $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
        $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
        $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
        $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $patient_type_no);
        $billinvoice->bindParam(':in_pat_type', $patient_type);
        $billinvoice->bindParam(':in_dob', $invoice_date);
        $billinvoice->bindParam(':in_age', $null);
        $billinvoice->bindParam(':in_age_dd', $null);
        $billinvoice->bindParam(':in_age_mm', $null);
        $billinvoice->bindParam(':in_age_yy', $null);
        $billinvoice->bindParam(':in_customer_addr', $null);
        $billinvoice->bindParam(':in_customer_name', $null);
        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);
        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billinvoice->bindParam(':in_payer_type', $payer_type);
        $billinvoice->bindParam(':in_sponsor_ccm_client_no_pk', $sponsor_ccm_client_no_pk);
        $billinvoice->bindParam(':in_referred_type', $referred_type);
        $billinvoice->bindParam(':in_source_no_fk', $source_no_fk);
        $billinvoice->bindParam(':in_email_ind', $email_ind);
        $billinvoice->bindParam(':in_email_id', $email_id);
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
        $billinvoice->bindArray(':in_item_disc_amt_by_doc', $item_disc_amount_doc, count($item_disc_amount_doc), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_amt_by_doc_no_fk', $item_disc_amount_doc_no_fk, count($item_disc_amount_doc_no_fk), $numelems, SQLT_INT);
      
        $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_service_charge', $ipd_charge, count($ipd_charge), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_report_delivery_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_delivery_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_delivery_status_lookup_no_fk', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_provider_person_no_fk', $provider_id, count($provider_id), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_payer_amt', $payer_amt, count($payer_amt), $numelems, SQLT_FLT);
       
        $billinvoice->bindArray(':in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_itemreceivedtl_no_pk', $in_itemreceivedtl_no_pk, count($in_itemreceivedtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_cost_price', $in_cost_price, count($in_cost_price), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_internal_batch_no_uq', $in_internal_batch_no_uq, count($in_internal_batch_no_uq), $numelems, SQLT_CHR);
      
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($billinvoice);
        $billinvoice->execute();
        
        $out_ledgertrn_no2 = "";
        if ($out_error == 999) {
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $depositusage_no=$request->deposit_type;
            $depositusage_type='';
            if (!empty( $depositusage_no)) {
                $depositusage_type=DB::table('sysc_lookupdata')->select('lookupdata_code')->where('lookupdata_no_pk', $depositusage_no)->first()->lookupdata_code;
            }

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_v1_billing.prc_billpayment_wp(
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
                                            :in_depositusage_type,
                                            :in_deposit_no_fk,
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
                                            :in_item_disc_amt_by_doc,
                                            :in_item_disc_amt_by_doc_no_fk,
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
            $billpayment->bindParam(':in_depositusage_type', $depositusage_type);
            $billpayment->bindParam(':in_deposit_no_fk', $depositusage_no);
            $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
            $billpayment->bindParam(':in_pay_cqcc_number', $null);
            $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
            $billpayment->bindParam(':in_pay_bank_name', $null);
            $billpayment->bindParam(':in_pay_remarks', $discount_remarks);
            $billpayment->bindParam(':in_given_amt', $given_amount);

            // DISCOUNT COLUMN PREPARATION START
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
            $billpayment->bindArray(':in_item_disc_amt_by_doc',$item_disc_amount_doc, count($item_disc_amount_doc), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amt_by_doc_no_fk', $item_disc_amount_doc_no_fk, count($item_disc_amount_doc_no_fk), $numelems, SQLT_INT);
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
            $billpayment->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
            } else {
                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
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
                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();

                $finc_ledger_paymood = $pdo2->prepare("begin pkg_v1_billing.prc_finc_ledger_paymood(
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

                if ($page_type == "physio") {
                    DB::table('patn_service_schedule')->where('schedule_no_pk', '=', $request->service_id)->update(['invoice_no_fk' => $out_invoice_no]);
                }

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {
                    DB::table('finc_invoicemst')->where('invoice_no_pk',$out_invoice_no)->update(['bill_type'=>$request->bill_type]);


                   // TV Update
                   if(DB::table('SYSC_TVSCREENSETUP')->where('TVTAG','APPOINTMENTTV')->value('status') == 1){
                        DB::table('opd_patdisplay')->where('APPOINT_NO_FK', $service_appointment_id)->update(['BIL_IND' => 1]);
                        DB::commit();
                        $data = $this->tv_information->get_tv_data(null);
                        event(new TVUpdate($data));
                   }else{
                        DB::commit();
                   }
                    // TV Update
    
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'bill_ind'=>1, 'trx_id' => $out_ledgertrn_no];
                }
            }
        }


        return response()->json($message);
    }
    public function createOrUpdateUhlV4($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();

        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d H:i:s', strtotime($time)); 
        $cur_datetime = date('Y-m-d H:i:s', strtotime($time));
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $patient_type_no = !empty($request->patient_type) ? $request->patient_type : 0;
       
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        $cmb_discount = $request->cmb_discount;
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
        $urgent_fee = $request->urgent_fee ?? 0;
        $total_payment = $request->total_payment;
        $entry_session = "session";
        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
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
        // $payer_type = $request->payer_type;
        $payer_type = $request->patient_type;
        // $sponsor_ccm_client_no_pk = $request->payer__sponsor;
        $sponsor_ccm_client_no_pk = $request->corporate_name;
        $referred_type = isset($request->refferred_type) ? $request->refferred_type :'' ;
        $source_no_fk = isset($request->source) ? $request->source :'' ;
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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_discount_type = $item_disc_amount = $ipd_charge = [];
        $i = 0;

        $payer_amt=[];
        $in_purchaseorderdtl_no_pk = [];
        $in_inv_requisitiondtl_no_pk = [];
        $in_itemreceivedtl_no_pk = [];
        $in_cost_price = [];
        $in_internal_batch_no_uq = [];
        $regisFeeInd=true;
        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $item_discount_type[$i] = isset($request->discount_type[$i]) ?  $request->discount_type[$i]:'';
                $item_disc_amount_doc[$i]=$request->auto_discount_doc[$i];
                $item_disc_amount_doc_no_fk[$i]=$hdn_dis_doctor_id ;
                $provider_id[$i]=$request->hdn_provider[$i] !="" ? $request->hdn_provider[$i]: '';
                $ipd_charge[$i] = $request->service_charge[$i] ?? 0;
                $hdn_item_type[$i] = $request->hdn_item_type[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $item_level_remarks[$i] = 0;
                $payer_amt[$i] = 0;

                $in_purchaseorderdtl_no_pk[$i] = 0;
                $in_inv_requisitiondtl_no_pk[$i] = 0;
                $in_itemreceivedtl_no_pk[$i] = 0;
                $in_cost_price[$i] = 0;
                $in_internal_batch_no_uq[$i] = 'test batch';
                //    ($request->bill_type=="app" || $request->bill_type=="PKG") &&
                if ( Session::get('user.ses_hospital_code')=="UNICO" ) {
                    $reg_fee=DB::table('sysc_serviceitem')->select('item_code')->where('item_no_pk',$deli_date)->first();
                   
                    if (!empty($reg_fee) && $reg_fee->item_code=="REGFEE" && $regisFeeInd==true) {                     
                        DB::table('patn_registration')->where('patient_no_pk',$hdn_patient_id)->update(['reg_card_fee_paid_ind'=> 1]);
                         $regisFeeInd==false;
                    }
                   
                }
               
                $i++;
            }
        }

            // dd($item_discount_type,$provider_id);
        $s_charge = array_sum($ipd_charge);
       
        if (!empty($admission_id)) {
            if(strtoupper($request->bill_type)=="OT"){
                $module_info = DB::table("sysc_module")->where("module_code", "OT")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }else{
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            
            
        } else {
            if (!empty($service_appointment_id)) {
                if (strtoupper($request->bill_type)=="PKG") {
                    $module_info = DB::table("sysc_module")->where("module_code", "PKG")->select("module_no_pk")->first();
                }else{
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                }
               
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }

        if (!empty($hdn_patient_id)) {
            // $corporate_id = $request->corporate_name;
            $corporate_id = $request->corporate_name;
        } else {
            $corporate_id = null;
        }
        // dd($corporate_id);
        // OUT PAREMETER INITIALIZE
        $out_ledgertrn_no = 0;
     
        $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;
        
        if (array_sum($item_disc_amount) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }

        $email_ind = null;
        $email_id = null;


        $out_invoice_id = null;
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_v2_billing.prc_billinvoice_wp(
                                                :in_invoice_date,
                                                :in_invoice_datetime,
                                                :in_module_no_fk,
                                                :in_patient_no_fk,
                                                :in_patient_code,
                                                :in_admission_no_pk,
                                                :in_admission_code,
                                                :in_appointment_no_fk,
                                                :in_prescription_no_fk,
                                                :in_doc_person_no_fk,
                                                :in_first_ref_doc_person_no_fk,
                                                :in_second_ref_doc_person_no_fk,
                                                :in_report_delivary_date,
                                                :in_report_deli_datetime,
                                                :in_counter_su_no_fk,
                                                :in_cor_client_no_fk,
                                                :in_cor_client_card_no_fk,
                                                :in_relation_lookup_no_fk,
                                                :in_ref_invoice_no_fk,
                                                :in_pat_type_lookup_no_fk,
                                                :in_pat_type,
                                                :in_dob,
                                                :in_age,
                                                :in_age_dd,
                                                :in_age_mm,
                                                :in_age_yy,
                                                :in_customer_addr,
                                                :in_customer_name,
                                                :in_gender_txt,
                                                :in_marital_status_txt,
                                                :in_blood_group,
                                                :in_phone_mobile,
                                                :in_invoice_remarks,
                                                :in_urgent_fee_total,
                                                :in_invoice_type,
                                                :in_au_entry_by,
                                                :in_au_entry_session,
                                                :in_au_entry_hospital_pk_no,
                                                :in_payer_type,
                                                :in_sponsor_ccm_client_no_pk,
                                                :in_referred_type,
                                                :in_source_no_fk,
                                                :in_email_ind,
                                                :in_email_id,
                                                :in_item_level_disc_ind,
                                                :in_item_count,
                                                :in_item_no_fk,
                                                :in_item_batch_fk,
                                                :in_item_expiry_dt,
                                                :in_item_name,
                                                :in_itemtype_no_fk,
                                                :in_item_qty,
                                                :in_item_mu,
                                                :in_item_rate,
                                                :in_item_disc_percent,
                                                :in_item_disc_amount,
                                                :in_item_disc_amt_by_doc,
                                                :in_item_disc_amt_by_doc_no_fk,
                                                :in_item_disc_type,
                                                :in_item_vat,
                                                :in_urgent_fee,
                                                :in_service_charge,
                                                :in_report_delivery_date,
                                                :in_report_delivery_time,
                                                :in_delivery_status_lookup_no_fk,
                                                :in_package_item_ind,
                                                :in_item_level_remarks,
                                                :in_provider_person_no_fk,
                                                :in_payer_amt,
                                                :in_purchaseorderdtl_no_pk,
                                                :in_inv_requisitiondtl_no_pk,
                                                :in_itemreceivedtl_no_pk,
                                                :in_cost_price,
                                                :in_internal_batch_no_uq,
                                                :in_ledgertrn_no,
                                                :out_invoice_no,
                                                :out_invoice_id,
                                                :out_ledgertrn_no,
                                                :out_error); end;"
        );
      
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
        $billinvoice->bindParam(':in_first_ref_doc_person_no_fk', $hdn_first_referral_id);
        $billinvoice->bindParam(':in_second_ref_doc_person_no_fk', $hdn_second_referral_id);
        $billinvoice->bindParam(':in_report_delivary_date', $report_delivery_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        $billinvoice->bindParam(':in_cor_client_no_fk', $corporate_id);
        $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
        $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
        $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
        $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $patient_type_no);
        $billinvoice->bindParam(':in_pat_type', $patient_type);
        $billinvoice->bindParam(':in_dob', $invoice_date);
        $billinvoice->bindParam(':in_age', $null);
        $billinvoice->bindParam(':in_age_dd', $null);
        $billinvoice->bindParam(':in_age_mm', $null);
        $billinvoice->bindParam(':in_age_yy', $null);
        $billinvoice->bindParam(':in_customer_addr', $null);
        $billinvoice->bindParam(':in_customer_name', $null);
        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);
        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billinvoice->bindParam(':in_payer_type', $payer_type);
        $billinvoice->bindParam(':in_sponsor_ccm_client_no_pk', $sponsor_ccm_client_no_pk);
        $billinvoice->bindParam(':in_referred_type', $referred_type);
        $billinvoice->bindParam(':in_source_no_fk', $source_no_fk);
        $billinvoice->bindParam(':in_email_ind', $email_ind);
        $billinvoice->bindParam(':in_email_id', $email_id);
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
        $billinvoice->bindArray(':in_item_disc_amt_by_doc', $item_disc_amount_doc, count($item_disc_amount_doc), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_amt_by_doc_no_fk', $item_disc_amount_doc_no_fk, count($item_disc_amount_doc_no_fk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_disc_type', $item_discount_type, count($item_discount_type), $numelems, SQLT_INT);
      
        $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_service_charge', $ipd_charge, count($ipd_charge), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_report_delivery_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_delivery_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_delivery_status_lookup_no_fk', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_provider_person_no_fk', $provider_id, count($provider_id), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_payer_amt', $payer_amt, count($payer_amt), $numelems, SQLT_FLT);
       
        $billinvoice->bindArray(':in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_itemreceivedtl_no_pk', $in_itemreceivedtl_no_pk, count($in_itemreceivedtl_no_pk), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_cost_price', $in_cost_price, count($in_cost_price), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_internal_batch_no_uq', $in_internal_batch_no_uq, count($in_internal_batch_no_uq), $numelems, SQLT_CHR);
      
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($billinvoice);
        $billinvoice->execute();
        
        $out_ledgertrn_no2 = "";
        if ($out_error == 999) {
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $depositusage_no=$request->deposit_type;
            $depositusage_type='';
            if (!empty( $depositusage_no)) {
                $depositusage_type=DB::table('sysc_lookupdata')->select('lookupdata_code')->where('lookupdata_no_pk', $depositusage_no)->first()->lookupdata_code;
            }

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_v2_billing.prc_billpayment_wp(
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
                                            :in_depositusage_type,
                                            :in_deposit_no_fk,
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
                                            :in_item_disc_amt_by_doc,
                                            :in_item_disc_amt_by_doc_no_fk,
                                            :in_item_disc_type,
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
            $billpayment->bindParam(':in_depositusage_type', $depositusage_type);
            $billpayment->bindParam(':in_deposit_no_fk', $depositusage_no);
            $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
            $billpayment->bindParam(':in_pay_cqcc_number', $null);
            $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
            $billpayment->bindParam(':in_pay_bank_name', $null);
            $billpayment->bindParam(':in_pay_remarks', $discount_remarks);
            $billpayment->bindParam(':in_given_amt', $given_amount);

            // DISCOUNT COLUMN PREPARATION START
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
            $billpayment->bindArray(':in_item_disc_amt_by_doc',$item_disc_amount_doc, count($item_disc_amount_doc), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amt_by_doc_no_fk', $item_disc_amount_doc_no_fk, count($item_disc_amount_doc_no_fk), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_disc_type', $item_discount_type, count($item_discount_type), $numelems, SQLT_INT);
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
            $billpayment->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
            } else {
                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
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
                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();

                $finc_ledger_paymood = $pdo2->prepare("begin pkg_v1_billing.prc_finc_ledger_paymood(
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

                if ($page_type == "physio") {
                    DB::table('patn_service_schedule')->where('schedule_no_pk', '=', $request->service_id)->update(['invoice_no_fk' => $out_invoice_no]);
                }

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {
                    DB::table('finc_invoicemst')->where('invoice_no_pk',$out_invoice_no)->update(['bill_type'=>$request->bill_type]);


                   // TV Update
                   if(DB::table('SYSC_TVSCREENSETUP')->where('TVTAG','APPOINTMENTTV')->value('status') == 1){
                        DB::table('opd_patdisplay')->where('APPOINT_NO_FK', $service_appointment_id)->update(['BIL_IND' => 1]);
                        DB::commit();
                        $data = $this->tv_information->get_tv_data(null);
                        event(new TVUpdate($data));
                   }else{
                        DB::commit();
                   }
                    // TV Update
    
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'bill_ind'=>1, 'trx_id' => $out_ledgertrn_no];
                }
            }
        }


        return response()->json($message);
    }
    public function emergencyBillCreateOrUpdateV1($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        //  $prescription_id = !empty($request->prescription_id) ? $request->prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        $hdn_item_type = $request->hdn_item_type;
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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

        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $total_discount_amount = $request->total_discount_amount;
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $report_delivery_date = $request->raport_delivery_date != "" ? date('Y-m-d', strtotime($request->raport_delivery_date)) : '';

        $invoice_date = "";

        // $in_paymood_arr_t = $request->pay_method_mode;
        // $in_pay_mood_type_arr_t = $request->mBank_types;
        // $in_bank_name_arr_t = $request->pay_bank_name;
        // $in_transaction_id_arr_t = $request->trans_id_no;
        // $in_bank_card_no_arr_t = $request->trans_id_no;
        // $in_acc_holder_name_arr_t = $request->acc_holder_name ;
        // $in_payment_amt_arr_t = $request->total_amt;
        // $in_paymood_count = $paymood_count;

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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = $ipd_charge=$provider_no = [];
        $i = 0;

        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $ipd_charge[$i] = $request->ipd_charge[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $item_level_remarks[$i] = 0;
                $provider_no[$i] = null;
                $i++;
            }
        }
        $s_charge = array_sum($ipd_charge);

        // dd($item_disc_amount,  $ipd_charge);
        // dd(  $item_disc_amount);
        // $i = 0;
        // if (!empty($in_paymood_arr_t)) {
        //       foreach ($in_paymood_arr_t as $key=>$value) {
        //             $sc_date = date("d-m-Y");
        //             $in_paymood_arr[$i] = $value;
        //             $in_pay_mood_type_arr[$i] =(!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "null") ;
        //             $in_bank_name_arr[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "null");
        //             $in_transaction_id_arr[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "null");
        //             $in_bank_card_no_arr[$i] =(!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "null") ;
        //             $in_acc_holder_name_arr[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "null") ;
        //             $in_payment_amt_arr[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "null");

        //             $i++;
        //       }
        // }

        // dd($admission_id);
        //  if ($page_type == 1) {
        if ($admission_id != "") {
            $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        } else {
            if ($service_appointment_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "EMR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }
        if ($hdn_patient_id != "") {
            $corporate_id = DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
        } else {
            $corporate_id = '';
        }
        // dd($corporate_id);
        //  }

        //  if ($page_type == 2) {
        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        //     $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //  }

        // OUT PAREMETER INITIALIZE
        $out_ledgertrn_no = 0;
        $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = "";
        // $item_level_disc_ind = $request->patient_itemType_dis_ind  != "" ? $request->patient_itemType_dis_ind : 0;
        $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;

        // $item_disc_percent[]=0;
        // $item_disc_amount[]=0;

        if (array_sum($item_disc_amount) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }
        // dd($item_discount , array_sum($item_disc_amount));
        // $item_level_remarks[] = 0;
        // dd($item_level_disc_ind);
        $emergency_ind=1;
        $pdo = DB::getPdo();
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
        $billinvoice->bindParam(':in_customer_addr', $null);
        $billinvoice->bindParam(':in_customer_name', $null);

        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);

        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_emergency_ind', $emergency_ind);
        $billinvoice->bindParam(':in_daycare_ind', $null);
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

        $billinvoice->execute();

        $out_ledgertrn_no2 = "";
        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
            //dd($in_paymood_arr);
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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
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
    public function dayCareBillCreateOrUpdateV1($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        //  $prescription_id = !empty($request->prescription_id) ? $request->prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        $hdn_item_type = $request->hdn_item_type;
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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

        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $total_discount_amount = $request->total_discount_amount;
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $report_delivery_date = $request->raport_delivery_date != "" ? date('Y-m-d', strtotime($request->raport_delivery_date)) : '';

        $invoice_date = "";

        // $in_paymood_arr_t = $request->pay_method_mode;
        // $in_pay_mood_type_arr_t = $request->mBank_types;
        // $in_bank_name_arr_t = $request->pay_bank_name;
        // $in_transaction_id_arr_t = $request->trans_id_no;
        // $in_bank_card_no_arr_t = $request->trans_id_no;
        // $in_acc_holder_name_arr_t = $request->acc_holder_name ;
        // $in_payment_amt_arr_t = $request->total_amt;
        // $in_paymood_count = $paymood_count;

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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = $ipd_charge=$provider_no = [];
        $i = 0;

        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $ipd_charge[$i] = $request->ipd_charge[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $item_level_remarks[$i] = 0;
                $provider_no[$i] = 0;
                $i++;
            }
        }
        $s_charge = array_sum($ipd_charge);

        // dd($item_disc_amount,  $ipd_charge);
        // dd(  $item_disc_amount);
        // $i = 0;
        // if (!empty($in_paymood_arr_t)) {
        //       foreach ($in_paymood_arr_t as $key=>$value) {
        //             $sc_date = date("d-m-Y");
        //             $in_paymood_arr[$i] = $value;
        //             $in_pay_mood_type_arr[$i] =(!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "null") ;
        //             $in_bank_name_arr[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "null");
        //             $in_transaction_id_arr[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "null");
        //             $in_bank_card_no_arr[$i] =(!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "null") ;
        //             $in_acc_holder_name_arr[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "null") ;
        //             $in_payment_amt_arr[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "null");

        //             $i++;
        //       }
        // }

        // dd($admission_id);
        //  if ($page_type == 1) {
        if ($admission_id != "") {
            $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        } else {
            if ($service_appointment_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "DYC")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }
        if ($hdn_patient_id != "") {
            $corporate_id = DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
        } else {
            $corporate_id = '';
        }
        // dd($corporate_id);
        //  }

        //  if ($page_type == 2) {
        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        //     $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //  }

        // OUT PAREMETER INITIALIZE
        $out_ledgertrn_no = 0;
        $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = "";
        // $item_level_disc_ind = $request->patient_itemType_dis_ind  != "" ? $request->patient_itemType_dis_ind : 0;
        $item_level_disc_ind = $request->auto_dis_ind != "" ? $request->auto_dis_ind : 0;

        // $item_disc_percent[]=0;
        // $item_disc_amount[]=0;

        if (array_sum($item_disc_amount) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }
        // dd($item_discount , array_sum($item_disc_amount));
        // $item_level_remarks[] = 0;
        // dd($item_level_disc_ind);
        $daycare_ind=1;
        $pdo = DB::getPdo();
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
        $billinvoice->bindParam(':in_customer_addr', $null);
        $billinvoice->bindParam(':in_customer_name', $null);

        $billinvoice->bindParam(':in_gender_txt', $null);
        $billinvoice->bindParam(':in_marital_status_txt', $null);
        $billinvoice->bindParam(':in_blood_group', $null);
        $billinvoice->bindParam(':in_phone_mobile', $null);

        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_emergency_ind', $null);
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

        $billinvoice->execute();

        $out_ledgertrn_no2 = "";
        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
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
            //dd($in_paymood_arr);
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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
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

    public function cancelationV1($request)
    {
        // $coun=0;
        /*foreach ($request->cancel_checkbox as $key => $value) {
        $coun +=$value;
        }*/
        $coun = count($request->cancel_checkbox);
        // dd($coun);
        $user_id = '';
        if ($request->hdn_doctor_id != "") {
            $user_id = DB::table('wsec_user')->select('user_no_pk')->where('person_no_fk', $request->hdn_doctor_id)->first();
        }
        // dd( $user_id);
        $auth_id = !empty($user_id->user_no_pk) ? $user_id->user_no_pk : Auth::id();
        DB::beginTransaction();
        try {
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();

            $cancel_date = date('Y-m-d h:i:s', strtotime($time));
            $invoice_no = $request->hdn_invoice_no_fk;
            $item_no = $request->cancel_ind;
            $cencel_q = $request->cancel_checkbox;
            $i = 0;
            $item_no_arr = [];
            $cencel_q_arr = [];
            foreach ($item_no as $value) {
                $item_no_arr[$i] = $value;
                $cencel_q_arr[$i] = $cencel_q[$i]; //
                $i++;
            }
            //dd($item_no_arr, $cencel_q_arr);
            // $module_no=1;
            // $admission_no=1;
            $responseBody='';
            $cunter_su_no = ($request->service_point != "") ? $request->service_point : 0;

            $entry_session = "session";
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $numelems = 200;
            // $coun=3;
            $admission_id = $request->admission_no_pk;
            if ($admission_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            // $procedureName = "pkg_billing_dev_2.prc_sales_cancellation";
            $in_ledgertrn_no = 0;
            $out_ledgertrn_no = $outError = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();
            $refund_reason = $request->cancel_reason;
            $refund_amount = $request->refund;
            // pkg_v1_billing
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_sales_cancellation(:in_cancel_date,:in_invoice_no_pk,:in_refund_amount,:in_refund_reason,:in_item_no_fk,:in_cancel_qty,:in_item_count,:in_module_no_fk,:in_admission_no_fk,:in_counter_su_no_fk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");

            $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
            $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
            $billinvoice->bindParam(':in_refund_amount', $refund_amount);
            $billinvoice->bindParam(':in_refund_reason', $refund_reason);
            $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_FLT);
            $billinvoice->bindParam(':in_item_count', $coun);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
            $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
            // dd($billinvoice);
            $billinvoice->execute();

            // $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                if (Session::get('user.ses_hospital_code') == "DMHL" && $request->apidiscount_type != '') {
                    $get_card_no = DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk', $request->hdn_patient_id)->first();          
                    $input_value = $get_card_no->cardnumber ?? '';
                
                    $total_discount = $request->cancel_discounted_amount ?? 0;                          
                    $total_payment_amt = $total_payment ?? 0;                           
                    $totalhcsclaimamountpl = $request->cencel_net_amount;
                    $item_total_amount =0;// array_sum($request->hdn_item_total_qnty);
                    
                    $null = '';
                    $zoro="0";
                    $typeCode = $request->discounttypecode;
                    
                    if ($input_value != "") {
                        
                        $url = 'https://hisapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';    
                        // $token = 'kOhNR/cQrqfOy5tSG1/KkRFUFZHBV/O20tv91jnSM6GuiGwAcOtbSMtIByYQRlj3cvu4Qdj76qrDM2nyi1ei/7E4occAJHXFeW5wG+FK2cVs2x2fnn2Txk7/eHfyRWmx+9D5nzXDMSAV0hDXkWxxwlb60rIWkMBxJDJElZWbNCsBLHRnzTH1eo1g2/RAtB9Ck1OZe8wLBLwplSqKSMwUjAAUpv26MIikFvv2COHU3qbyRau/FdL67v3/8epOZctjaPUQK/cDohVXAO5u97SVrvSJ0pxb2V2GLqX7ak29qvhMAvqnIFRFUhryi4pavxxo';
                        $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';
                        
                        // $url = 'https://hisstagingapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                        // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

                        // Prepare the data to be sent in the POST request
                        $data =(object) [
                            "ByUserId"          => "8415",
                            "PersonId"          => "121529",
                            "MemberIdentity"    => $input_value,
                            "BillNo"            => $out_invoice_no,
                            "DiscountDetails"   => [(object)[
                                "DiscountTypeCode"      => $request->apidiscount_type,
                                "DCDiscountPercentage"  => $zoro,
                                "DCDiscountAmount"      => $total_discount,
                                "DMHDiscountPercentage" => $zoro,
                                "DMHDiscountAmount"     => $zoro,
                                "AfterDiscountAmount"   => $totalhcsclaimamountpl
                            ]],
                            "TotalHCSClaimAmount"=> strval($total_discount),
                            "FinalPayment"       =>  $totalhcsclaimamountpl,
                            "BillDate"           => $cancel_date,                                    
                            "Remarks"            => $null,
                            "DiseaseName"        => $null,
                            "VoucherStatus"      => 0,
                            "MobileNumber"       => "-",
                            "UserName"           => "info@divinemercyhospital.com",
                            "RequestFrom"        => "HIS"
                        ];
                        
                        try {
                            // Create a Guzzle client instance
                            $client = new Client();                       
                            // Make the POST request with the authorization token and data
                            $response = $client->post($url, [
                                'headers' => [
                                    'token'=> $token,
                                    'Content-Type' => 'application/json',
                                ],
                                'json' => $data
                            ]);
                
                            // Check response status code
                            if ($response->getStatusCode() == 200) {
                                // Get the response body
                                $responseBody = json_decode($response->getBody(), true);
                                DB::table('finc_ledgermst')->where('invoice_no_fk',$out_invoice_no)->update(['apidiscount_type'=> $request->apidiscount_type]);
                                DB::commit();
                                $message = [
                                    'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                    'title' => 'Success', 
                                    'insert_id' => $out_invoice_no, 
                                    'trx_id' => $out_ledgertrn_no,
                                    'responseBody' => $responseBody,
                                ];
                            } else {
                                return response()->json([
                                    'message' => 'Request failed',
                                    'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                ], $response->getStatusCode());
                            }
                
                        } catch (\GuzzleHttp\Exception\RequestException $e) {
                            // Handle request exceptions
                            return response()->json([
                                'message' => 'Request failed',
                                'error' => $e->getMessage()
                            ], $e->getCode());
                        }
                    }
                } else {
                    DB::commit();
                    $message = [
                        'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                        'title' => 'Success', 
                        'insert_id' => $out_invoice_no, 
                        'trx_id' => $out_ledgertrn_no,
                        'responseBody' => $responseBody,
                    ];
                }
                // DB::commit();
                // $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no];
            } else {

                   
                DB::rollback();
                $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function ipdCancelationV1($request)
    {
        // $coun=0;
        /*foreach ($request->cancel_checkbox as $key => $value) {
        $coun +=$value;
        }*/

        $coun = count($request->cancel_checkbox);

        $user_id = '';
        if ($request->hdn_doctor_id != "") {
            $user_id = DB::table('wsec_user')->select('user_no_pk')->where('person_no_fk', $request->hdn_doctor_id)->first();
        }

        $auth_id = !empty($user_id->user_no_pk) ? $user_id->user_no_pk : Auth::id();
        DB::beginTransaction();
        try {
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();

            $cancel_date = date('Y-m-d h:i:s', strtotime($time));
            // $invoice_no = $request->hdn_invoice_no_fk;
            $item_no = $request->cancel_checkbox;
            $cencel_q = $request->cancel_checkbox;
            // dd( $item_no);
            $i = 0;
            $item_no_arr = [];
            $cencel_q_arr = [];
            $admission_id='';
            $invoice_no=null;
        if (!empty($item_no)) {
            foreach ($item_no as $value) {

                $item_no_arr[$i] = $request->input('item_no_'.$value);
                $cencel_q_arr[$i] = $request->input('cancel_qty_'.$value);
                $admission_id=$request->input('admissin_id_'.$value);
                $invoice_no=$request->input('invoice_no_'.$value);
                $i++;


                $cunter_su_no = 0;//($request->service_point != "") ? $request->service_point : 0;

                $entry_session = "session";
                $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
                $hospital_id = $ses_hospital_id;
                $numelems = 200;
                if ($admission_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
                $in_ledgertrn_no = 0;
                $out_ledgertrn_no = $outError = $out_invoice_id = $out_invoice_no = '';
                $pdo = DB::getPdo();
                $refund_reason ='';
                $refund_amount = 0;
                $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_sales_cancellation(:in_cancel_date,:in_invoice_no_pk,:in_refund_amount,:in_refund_reason,:in_item_no_fk,:in_cancel_qty,:in_item_count,:in_module_no_fk,:in_admission_no_fk,:in_counter_su_no_fk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");

                $billinvoice->bindParam(':in_cancel_date', $cancel_date);
                $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
                $billinvoice->bindParam(':in_refund_amount', $refund_amount);
                $billinvoice->bindParam(':in_refund_reason', $refund_reason);
                $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_FLT);
                $billinvoice->bindParam(':in_item_count', $coun);
                $billinvoice->bindParam(':in_module_no_fk', $module_id);
                $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
                $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
                $billinvoice->bindParam(':in_au_entry_by', $auth_id);
                $billinvoice->bindParam(':in_au_entry_session', $entry_session);
                $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
                $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
                $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
                // dd($billinvoice);
                $billinvoice->execute();

            }
        }

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no];
            } else {
                DB::rollback();
                $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function dueCollectV1($request)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {
            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d h:i:s', strtotime($time));
            $cur_datetime = date('Y-m-d h:i:s', strtotime($time));

            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;
            $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
            $hdn_item_vat_amt = $request->hdn_item_vat_amt;
            $hdn_item_name = $request->hdn_item_name;
            $hdn_item_type = $request->hdn_item_type;
            $total_item = count($hdn_item_id);
            $j = 0;
            $item_disc_percent = $item_disc_amount = [];
            if (!empty($hdn_item_id)) {
                foreach ($hdn_item_id as $value) {
                    $item_disc_percent[$j] = 0;
                    $item_disc_amount[$j] = 0;
                    $j++;
                }
            }

            $txt_batch = $request->txt_batch;
            $txt_expire_date = $request->txt_expire_date ;
            $internal_batch_no = $request->internal_batch_no;
            $hdn_item_rate = $request->hdn_item_rate;
            if ($page_type == 1) {
                $hdn_item_qnty = $request->hdn_item_qnty;
            } elseif ($page_type == 2) {
                // $hdn_item=$request->hdn_item_qnty;
                // $cancel_item=$request->actual_qty;
                $hdn_item_qnty = $request->actual_qty;
            }

            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

            $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
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
            $total_payment = $request->pay_amount;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
            $hospital_dis = ($request->discount_amt != "") ? $request->discount_amt : 0;
            $doctor_dis = ($request->doctor_amt != "") ? $request->doctor_amt : 0;

            $total_discount_amount = $hospital_dis + $doctor_dis;
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
            $numelems = 200;
            $zero = 0;

            if (empty($check_no)) {
                $check_no = $card_no;
            }
            if (empty($bank_name)) {
                $bank_name = $bank_name_card;
            }

            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = [];
            $i = 0;
            // dd($txt_batch,$txt_expire_date,$internal_batch_no);
            if (!empty($hdn_item_id)) {
                foreach ($hdn_item_id as $deli_date) {
                    $sc_date = date("d-m-Y");
                    $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
                    $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                    $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? date('dmY',strtotime($txt_expire_date[$i])) : '');
                    $internal_batch_no[$i] = (!empty($internal_batch_no[$i]) ? $internal_batch_no[$i] : '');
                    $hdn_item_urgent_fee_amt[$i] = ($hdn_item_urgent_fee[$i] == null) ? 0 : $hdn_item_urgent_fee[$i];

                    $i++;
                }
            }

            if ($page_type == 1) {
                if ($admission_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
            if ($page_type == 2) {
                $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }

            $item_level_disc_ind = 0;
            $out_invoice_no = $request->hdn_invoice_id;

            $in_ledgertrn_no = $out_invoice_no2 = $out_error = $out_ledger_no = "";
            $pdo1 = DB::getPdo();
        //    dd($page_type);
            if ($page_type == 1) {
              
                // pkg_billing_v0
                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_wp(:in_payment_date,
                  :in_payment_datetime,:in_invoice_no_fk,:in_module_no_fk,:in_patient_no_fk,:in_admission_no_fk,
                  :in_prescription_no_fk,:in_counter_su_no_fk,:in_ledger_amt_sales,:in_ledger_amt_payment,
                  :in_ledger_amt_discount,:in_urgent_fee,:in_service_charge,:in_cor_client_no_fk,:in_pay_mode,
                  :in_pay_cqcc_holder_name,:in_pay_cqcc_number,:in_pay_cqcc_deduct_percent,
                  :in_pay_bank_name,:in_pay_remarks,:in_given_amt,:in_disc_type_lookup_no_fk,:in_disc_remarks,
                  :in_disc_amt_by_doc,:in_disc_amt_by_doc_no_fk,:in_disc_amt_by_hosp,
                  :in_disc_amt_by_hosp_auth_by,:in_disc_amt_request_by_name,:in_au_entry_by,:in_au_entry_session,
                  :in_au_entry_hospital_pk_no,:in_item_count,:in_item_level_disc_ind,
                  :in_item_no_fk,:in_item_name,
                  :in_itemtype_no_fk,
                  :in_item_qty,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_itemurgent_fee,:in_itemservice_charge,
                  :in_package_item_ind,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_ledger_no,:out_error);
                  end;");
                  $billpayment->bindParam(':in_payment_date', $cur_date);
                  $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
                  $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
                  $billpayment->bindParam(':in_module_no_fk', $module_id);
                  $billpayment->bindParam(':in_patient_no_fk', $hdn_patient_id);
      
                  $billpayment->bindParam(':in_admission_no_fk', $admission_id);
                  $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
                  $billpayment->bindParam(':in_counter_su_no_fk', $cunter_su_no);
      
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
                  $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                  $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                  $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                  $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                  $out_ledgertrn_no = "";
                  $billpayment->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
                  $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
                  $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                  $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
                  $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
                  $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                  // dd( $billpayment);
                  $billpayment->execute();
            } elseif ($page_type == 2) {

                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_stock_wp(:in_payment_date,
            :in_payment_datetime,:in_invoice_no_fk,:in_module_no_fk,:in_patient_no_fk,:in_admission_no_fk,
            :in_prescription_no_fk,:in_counter_su_no_fk,:in_ledger_amt_sales,:in_ledger_amt_payment,
            :in_ledger_amt_discount,:in_urgent_fee,:in_service_charge,:in_cor_client_no_fk,:in_pay_mode,
            :in_pay_cqcc_holder_name,:in_pay_cqcc_number,:in_pay_cqcc_deduct_percent,
            :in_pay_bank_name,:in_pay_remarks,:in_given_amt,:in_disc_type_lookup_no_fk,:in_disc_remarks,
            :in_disc_amt_by_doc,:in_disc_amt_by_doc_no_fk,:in_disc_amt_by_hosp,
            :in_disc_amt_by_hosp_auth_by,:in_disc_amt_request_by_name,:in_au_entry_by,:in_au_entry_session,
            :in_au_entry_hospital_pk_no,:in_item_count,:in_item_level_disc_ind,:in_item_no_fk,:in_item_name,:in_item_batch_fk,:in_item_expiry_dt,:in_intern_batch_fk,:in_itemtype_no_fk,
            :in_item_qty,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_itemurgent_fee,:in_itemservice_charge,
            :in_package_item_ind,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_ledger_no,:out_error);
            end;");

            $billpayment->bindParam(':in_payment_date', $cur_date);
            $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
            $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
            $billpayment->bindParam(':in_module_no_fk', $module_id);
            $billpayment->bindParam(':in_patient_no_fk', $hdn_patient_id);

            $billpayment->bindParam(':in_admission_no_fk', $admission_id);
            $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
            $billpayment->bindParam(':in_counter_su_no_fk', $cunter_su_no);

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
            $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $hospital_id_for_disc); // will be adjust later
            $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);
            $billpayment->bindParam(':in_au_entry_by', $auth_id);
            $billpayment->bindParam(':in_au_entry_session', $entry_session);
            $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billpayment->bindParam(':in_item_count', $total_item);
            $billpayment->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
            $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_batch_fk', $batch_no_arr, count($batch_no_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_expiry_dt', $expire_dt_arr, count($expire_dt_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_intern_batch_fk', $internal_batch_no, count($internal_batch_no), $numelems, SQLT_CHR);

            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $out_ledgertrn_no = "";
            $billpayment->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd( $billpayment);
            $billpayment->execute();
            }
         

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Payment create Failled.', 'title' => 'Error'.$out_error];
            } else {

                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);

                $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                // dd($query);

                $auth_id = Auth::id();

                date_default_timezone_set('Asia/Dhaka');
                $time = Carbon::now();

                $date = date('Y-m-d h:i:s', strtotime($time));
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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
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

                if ($out_error !=999) {

                   if (!empty($in_paymood_arr_t) && !empty($request->invoice_number)) {
                    foreach ($in_paymood_arr_t as $key => $value) {
                        $data=[
                            'card_invoice_no'=>  $request->invoice_number[$j],
                        ];
                        $in_bank_name_arr_val[$j] = (!empty($in_bank_name_arr_t[$j]) ? $in_bank_name_arr_t[$j] : "");
                        $payment_details[$j]=DB::table('finc_ledger_paymood')->where('invoice_no_fk',$invoice_no)->where('ledger_no_fk',$ledger_no)->where('paymood','CARD')
                        ->where('bank_name', $in_bank_name_arr_val[$j])
                        ->update($data);
                        $j++;
                    }
                }
                }

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {

                    if ($request->total_refund != "") {
                        date_default_timezone_set('Asia/Dhaka');
                        $time = Carbon::now();
                        $cancel_date = date('Y-m-d h:i:s', strtotime($time));
                        // $cancel_time =  date('h:i:s', strtotime($time));
                        $refund_amount = $request->total_refund != "" ? $request->total_refund : 0;
                        $in_au_entry_by = $auth_id;
                        $in_au_entry_session = "session";
                        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
                        $out_invoice_no3 = $out_ledger_no3 = $out_ledgertrn_no3 = $empty = $out_error3 = $full_invoice_refund_ind = "";
                        $full_invoice_refund_ind = null;
                        $pdo2 = DB::getPdo();
                        $refund = $pdo2->prepare("begin pkg_billing_v0.prc_payment_cancellation_amt(
                             :in_cancel_date,
                             :in_cancel_datetime,
                             :in_invoice_no_pk,
                             :in_refund_amount,
                             :in_refund_reason,
                             :in_full_invoice_refund_ind,
                             :in_module_no_fk,
                             :in_admission_no_fk,
                             :in_counter_su_no_fk,
                             :in_au_entry_by,
                             :in_au_entry_session,
                             :in_au_entry_hospital_pk_no ,
                             :in_ledgertrn_no ,
                             :out_ledgertrn_no ,
                             :out_error);
                             end;");

                        $refund->bindParam(':in_cancel_date', $cancel_date);
                        $refund->bindParam(':in_cancel_datetime', $cancel_date);
                        $refund->bindParam(':in_invoice_no_pk', $out_invoice_no);
                        $refund->bindParam(':in_refund_amount', $refund_amount);
                        $refund->bindParam(':in_refund_reason', $empty);
                        $refund->bindParam(':in_full_invoice_refund_ind', $full_invoice_refund_ind);
                        $refund->bindParam(':in_module_no_fk', $module_id);
                        $refund->bindParam(':in_admission_no_fk', $admission_id);
                        $refund->bindParam(':in_counter_su_no_fk', $cunter_su_no);
                        $refund->bindParam(':in_au_entry_by', $in_au_entry_by);
                        $refund->bindParam(':in_au_entry_session', $in_au_entry_session);
                        $refund->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
                        $refund->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
                        $refund->bindParam(':out_ledgertrn_no', $out_ledgertrn_no3);
                        $refund->bindParam(':out_error', $out_error3, PDO::PARAM_STR, 500);
                        $refund->execute();
                        if ($out_error3 == 999) {
                            DB::rollback();
                            $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
                        } else {
                            DB::commit();
                            $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                        }
                    } else {
                        DB::commit();
                        $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                    }

                }
            }
        return response()->json($message);
    }
    public function POScreateOrUpdateV1($request, $id = null)
    {
        $auth_id = Auth::id();
       
        try {
            DB::beginTransaction();
        $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
        $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
        $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";

        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
      
        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;

        $txt_batch = $request->txt_batch;
        $txt_expire_date = $request->txt_expire_date;

        // $hdn_item_qnty = $request->hdn_item_qnty;

        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
        $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
        $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
        $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
        $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
        $remarks = !empty($request->remarks) ? $request->remarks : " ";
        $pay_mode = $request->pay_mode;
        $pay_amount = $request->pay_amount;
        $given_amount = $request->given_amount;
        $change_amount = $request->change_amount;
        $item_vat = $request->item_vat;
        $urgent_fee = $request->uregent_fee;
        $total_urgent_fee = $request->total_urgent_fee;
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $adj_dis = $request->dis_adj_amt;
        $total_discount_amount = $request->total_discount_amount + $adj_dis;

        // dd($adj_dis , $request->total_discount_amount , $total_discount_amount );
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $null = '';

        $out_sl_no = '';
        $empty_arr = [];
        $numelems = 500;
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

       

        if ($in_counter_su_no_fk != 0) {
            $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
            if (isset($service_unit_check)) {
               
                if ($service_unit_check->hs_pos_ind == 1) {
                    
                    $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                  
                    if (isset($request->hdn_admission_id) && $request->hdn_admission_id >0) {
                        if ($request->customer_type_radio == 5) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 6) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 7) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 9) {
                            $module_info = DB::table("sysc_module")->where("module_code", "H-KEEP")->select("module_no_pk")->first();
                        }else{
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        }

                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                        // dd($module_info ,$module_id);
                    } else {
                        $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    }
                }
            } else {
               
                if (isset($request->hdn_admission_id)) {
                        if ($request->customer_type_radio == 5) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 6) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 7) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 9) {
                            $module_info = DB::table("sysc_module")->where("module_code", "H-KEEP")->select("module_no_pk")->first();
                        }else{
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        }
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
        } else {
           
            if (isset($request->hdn_admission_id)) {

                        if ($request->customer_type_radio == 5) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 6) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 7) {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                        }elseif ($request->customer_type_radio == 9) {
                            $module_info = DB::table("sysc_module")->where("module_code", "H-KEEP")->select("module_no_pk")->first();
                        }else{
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        }
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }
        // dd( $module_id);
        // dd($module_id,$module_info,$request->customer_type_radio ,$request->hdn_admission_id);
        $i = 0;
        $item_arr = [];
        $batch_arr = [];
        $intern_batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
        $hdn_item_rate = [];
        $hdn_item_qnty = [];
        $whole_sale = [];
        $hdn_item_dis = [];
        $item_dis_amt = [];
        $item_dis_pers = [];
        $item_level_remarks = [];
        
        for ($i = 0; $i < count($request->txt_batch); $i++) {
            $item_datas = explode('_', $request->txt_batch[$i]);
            $item_arr[$i] = $item_datas[0];
            $item_level_remarks[$i] = 0;         
            $item_batch_no[$i] = $item_datas[1];
           
            $intern_batch[$i] = trim($request->internal_batch_no[$i]);// $item_data[1];

            $batch_arr[$i] = $item_batch_no[$i] != "0" || $item_batch_no[$i] != '' ? trim($item_batch_no[$i]) : "";
            $intern_batch_arr[$i] = $intern_batch[$i] != "" ? trim($intern_batch[$i]) : "";
           
            $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

            if ($whole_sale[$i] == "") {
                if ($request->batch_wise_sales_price[$i] !=null ) {
                    $hdn_item_rate[$i] = $request->batch_wise_sales_price[$i];
                    // dd($hdn_item_rate[$i],1);
                }else{
                    $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
                }
               
            } else {

                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('dealer_sales_price')->where('item_no_pk', $item_arr[$i])->first()->dealer_sales_price;
            }
            $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
            $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

            $exp = explode('_', $request->txt_expire_date[$i]);
            $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";

            $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
            $hdn_item_qnty[$i] = $checker[0];
            $qty_exp = explode('_', $request->batch_qty[$i]);
            $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0];
            $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
            $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
            $package_ind_arr[$i] = 0;
            $item_mu_arr[$i] = 0;
            $hdn_item_urgent_fee_amt[$i] = (isset($urgent_fee[$i]) ? $urgent_fee[$i] : 0);

            if (in_array(Session::get('user.ses_hospital_code'), ["UNICO","KPJ"])) {
                $item_dis_pers[$i] = $item_dis_pers[$i] = $item_datas[2] > 0 ? $item_datas[2] : $item_datas[2];
                $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
            }else{
                if ($request->item_dis_radio == 1) {
                    $item_dis_pers[$i] = $item_datas[2];
                    $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
                } elseif ($request->item_dis_radio == 2) {
                    $item_dis_amt[$i] = $item_datas[2];
                    $item_dis_pers[$i] = $item_dis_amt[$i] != '' ? ($item_dis_amt[$i] / ($quantity_arr[$i] * $hdn_item_rate[$i])) * 100 : 0;
                } else {
                    $item_dis_amt[$i] = 0;
                    $item_dis_pers[$i] = 0;
                }
            }
           
        }

        //  dd( $batch_arr ,$item_dis_pers,$item_dis_amt);
        $total_item = count($item_arr);
        $invoice_date = "";

        if (array_sum($item_dis_amt) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }

        // dd(array_sum($request->item_dis_amt));
        $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->item_dis_ind != '' ? $request->item_dis_ind : 0;
        $responseBody='';
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_stock_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_intern_batch_fk,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,
        :in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");
        // dd($item_dis_pers , $item_dis_amt);
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
        $billinvoice->bindParam(':in_report_delivary_date', $invoice_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        $billinvoice->bindParam(':in_cor_client_no_fk', $null);
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
        $billinvoice->bindParam(':in_phone_mobile',  $walk_in_phone);
        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $total_urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_emergency_ind', $null);
        $billinvoice->bindParam(':in_daycare_ind', $null);
        $billinvoice->bindParam(':in_ot_ind', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        $billinvoice->bindParam(':in_item_count', $total_item);
        $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
        $out_ledgertrn_no = $in_ledgertrn_no = "";
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        //  dd( $billinvoice);
        $billinvoice->execute();
       
        $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

        if ($out_error == 999) {
            // dd($out_error . "invoice");
            DB::rollback();
            $message = ['msg' => 'Bill billinvoice Failled.' . $out_error, 'title' => 'Error'];
        } else {
            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_stock_wp(
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
                     :in_item_batch_fk,
                     :in_item_expiry_dt,
                     :in_intern_batch_fk,
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

            $billpayment->bindParam(':in_payment_date', $cur_date);
            $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
            $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
            $billpayment->bindParam(':in_module_no_fk', $module_id);
            $billpayment->bindParam(':in_patient_no_fk', $pat_id);
            $billpayment->bindParam(':in_admission_no_fk', $admission_id);
            $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
            $billpayment->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
            $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
            $billpayment->bindParam(':in_ledger_amt_payment', $total_payment);
            $billpayment->bindParam(':in_ledger_amt_discount', $total_discount_amount);
            $billpayment->bindParam(':in_urgent_fee', $total_urgent_fee);
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();

            $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = $hospital_id_for_disc = 0;
            $hospital_disc_amt = $total_discount_amount; //$disc_amount_hospital;
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
            $billpayment->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
          
            $billpayment->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $out_ledgertrn_no2 = "";
            $billpayment->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            //   dd($billpayment);
            $billpayment->execute();

            if ($out_error == 999) {
                // dd($out_error, $out_invoice_no2, $out_invoice_no, $total_item, $item_arr);
                DB::rollback();
                $message = ['msg' => 'Bill payment Failled.','out_error'=>$out_error ,'title' => 'Error'];
            } else {

                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                $auth_id = Auth::id();
                date_default_timezone_set('Asia/Dhaka');
                $time = Carbon::now();

                $date = date('Y-m-d h:i:s', strtotime($time));
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

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
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

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {

                    if (Session::get('user.ses_hospital_code') == "DMHL" && $request->apiDiscount_ind == 1 && $pat_id !='') {
                        $get_card_no = DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk', $pat_id)->first(); 
                        
                        $discount_perc_amt=0;
                        if (!empty($item_arr)) {                              
                            foreach ($item_arr as $key => $value) {
                                $item_info=DB::table('sysc_serviceitem')->select('default_discount_pct','sales_price','disc_aplicable')->where('item_no_pk',$value)->first();
                                $pat_registration=DB::table('pat_registration_wl_vw')->select('ccm_client_no_fk','patient_type_code')->where('patient_no_pk', $pat_id)->first();
                                $discount = $item_info->default_discount_pct != null ? $item_info->default_discount_pct : 0;
                                $sales_price = $item_info->sales_price != null ? $item_info->sales_price : 0;
                                $corporate_id_info=$pat_registration->ccm_client_no_fk !=''? $pat_registration->ccm_client_no_fk :0;
                                $patient_type_code=$pat_registration->patient_type_code;
                                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value,'$patient_type_code',$corporate_id_info, $sales_price,0,$discount,'AMT') as def_discount from dual"));//AMT, PTC
                                $discount_perc_amt +=$def_dis[0]->def_discount  != "" && $item_info->disc_aplicable != 1 ?  $def_dis[0]->def_discount :0 ;
                                // dd($hdn_item_id,$request->auto_discount, $discount_perc,$patient_type_code,$corporate_id_info);
                            }
                        }
                        $input_value = $get_card_no->cardnumber ?? '';
                    
                        $total_discount = $total_discount_amount ?? 0;                          
                        $total_payment_amt = $total_payment ?? 0;                           
                        $totalhcsclaimamountpl = $request->total_payable;
                        $item_total_amount = array_sum($request->hdn_item_total_qnty);
                    
                        $null = '';
                        $zoro="0";
                        $typeCode ='03';// $request->apiDiscount_ind;
                        
                        if ($input_value != "") {
                            // Define the API endpoint URL
                           
                            $url = 'https://hisapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';        
                            // $token = 'kOhNR/cQrqfOy5tSG1/KkRFUFZHBV/O20tv91jnSM6GuiGwAcOtbSMtIByYQRlj3cvu4Qdj76qrDM2nyi1ei/7E4occAJHXFeW5wG+FK2cVs2x2fnn2Txk7/eHfyRWmx+9D5nzXDMSAV0hDXkWxxwlb60rIWkMBxJDJElZWbNCsBLHRnzTH1eo1g2/RAtB9Ck1OZe8wLBLwplSqKSMwUjAAUpv26MIikFvv2COHU3qbyRau/FdL67v3/8epOZctjaPUQK/cDohVXAO5u97SVrvSJ0pxb2V2GLqX7ak29qvhMAvqnIFRFUhryi4pavxxo';
                            $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';
                            
                            // $url = 'https://hisstagingapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                            // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

                            // Prepare the data to be sent in the POST request
                            $data =(object) [
                                "ByUserId"          => "8415",
                                "PersonId"          => "121529",
                                "MemberIdentity"    => $input_value,
                                "BillNo"            => $out_invoice_no,
                                "DiscountDetails"   => [(object)[
                                    "DiscountTypeCode"      => $typeCode,
                                    "DCDiscountPercentage"  => $zoro,
                                    "DCDiscountAmount"      => $total_discount,
                                    "DMHDiscountPercentage" => $zoro,
                                    "DMHDiscountAmount"     => $discount_perc_amt,
                                    "AfterDiscountAmount"   => $totalhcsclaimamountpl
                                ]],
                                "TotalHCSClaimAmount"=> strval($total_discount),
                                "FinalPayment"       =>  $totalhcsclaimamountpl,
                                "BillDate"           => $cur_date,                                    
                                "Remarks"            => $null,
                                "DiseaseName"        => $null,
                                "VoucherStatus"      => 1,
                                "MobileNumber"       => "-",
                                "UserName"           => "info@divinemercyhospital.com",
                                "RequestFrom"        => "HIS"
                            ];
                            
                            try {
                                // Create a Guzzle client instance
                                $client = new Client();                       
                                // Make the POST request with the authorization token and data
                                $response = $client->post($url, [
                                    'headers' => [
                                        'token' => $token,
                                        'Content-Type' => 'application/json',
                                    ],
                                    'json' => $data
                                ]);
                    
                                // Check response status code
                                if ($response->getStatusCode() == 200) {
                                    // Get the response body

                                    // Pharmacy TV Update
                                    if(DB::table('SYSC_TVSCREENSETUP')->where('TVTAG','PHARMACYTV')->value('status') == 1){
                                        $data = $this->pharmacy_tv_information->get_pharmacy_tv_data(null);
                                        event(new PharmacyTVUpdate($data));
                                    }
                                    // Pharmacy TV Update

                                    $responseBody = json_decode($response->getBody(), true);
                                    DB::table('finc_ledgermst')->where('invoice_no_fk',$out_invoice_no)->update(['apidiscount_type'=>3]);
                                    DB::commit();
                                    $message = [
                                        'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                        'title' => 'Success', 
                                        'insert_id' => $out_invoice_no2, 
                                        'trx_id' => $out_ledgertrn_no,
                                        'responseBody' => $responseBody,
                                    ];
                                } else {
                                    return response()->json([
                                        'message' => 'Request failed',
                                        'error' => 'Unexpected response status: ' . $response->getStatusCode()
                                    ], $response->getStatusCode());
                                }
                    
                            } catch (\GuzzleHttp\Exception\RequestException $e) {
                                // Handle request exceptions
                                return response()->json([
                                    'message' => 'Request failed',
                                    'error' => $e->getMessage()
                                ], $e->getCode());
                            }
                        }
                    } else {
                        DB::commit();
                        // Pharmacy TV Update
                        if(DB::table('SYSC_TVSCREENSETUP')->where('TVTAG','PHARMACYTV')->value('status') == 1){
                            $data = $this->pharmacy_tv_information->get_pharmacy_tv_data(null);
                            event(new PharmacyTVUpdate($data));
                        }
                        // Pharmacy TV Update
                        $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'bill_ind'=>'pos', 'trx_id' => $out_ledgertrn_no,'responseBody'=>$responseBody];
                    }
                    // DB::commit();
                    // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'bill_ind'=>'pos', 'trx_id' => $out_ledgertrn_no];
                }
            }

        }
        return response()->json($message);
        } catch (\Exception $e) {
            DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message,400);
        }

       
    }
    public function cafeteriacreateOrUpdateV1($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
        $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
        $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
        $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";

        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;

        $txt_batch = $request->txt_batch;
        $txt_expire_date = $request->txt_expire_date;

        // $hdn_item_qnty = $request->hdn_item_qnty;

        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
        $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
        $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
        $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
        $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
        $remarks = !empty($request->remarks) ? $request->remarks : " ";
        $pay_mode = $request->pay_mode;
        $pay_amount = $request->pay_amount;
        $given_amount = $request->given_amount;
        $change_amount = $request->change_amount;
        $item_vat = $request->item_vat;
        $urgent_fee = $request->uregent_fee;
        $total_urgent_fee = $request->total_urgent_fee;
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $adj_dis = $request->dis_adj_amt;
        $total_discount_amount = $request->total_discount_amount + $adj_dis;

        // dd($adj_dis , $request->total_discount_amount , $total_discount_amount );
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $null = '';

        $out_sl_no = '';
        $empty_arr = [];
        $numelems = 500;
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
       
        if ($in_counter_su_no_fk != 0) {
            $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
           
            if (isset($service_unit_check)) {
                if ($service_unit_check->hs_pos_ind == 1) {
                    $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    
                    if (isset($request->hdn_admission_id)) {
                        // if ($request->customer_type_radio == 5) {
                        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                        // }elseif ($request->customer_type_radio == 6) {
                        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                        // }elseif ($request->customer_type_radio == 7) {
                        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                        // }else{
                        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        // }
                        $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE-I","OPTICAL-I","COFFEE-I"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                        $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
                        // dd($module_info ,$module_id);
                    } else {
                        
                        $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE","OPTICAL","COFFEE"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                        $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
                        // dd($in_counter_su_no_fk,$module_info);
                    }
                }
            } else {
                if (isset($request->hdn_admission_id)) {
                    $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE-I","OPTICAL-I","COFFEE-I"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                    $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE","OPTICAL","COFFEE"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                    $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
                }
            }
        } else {
            if (isset($request->hdn_admission_id)) {

                $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE-I","OPTICAL-I","COFFEE-I"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->whereIn("module_code", ["CAFE","OPTICAL","COFFEE"])->where('service_point_su_no_fk', $in_counter_su_no_fk)->select("module_no_pk")->get();
                $module_id = isset($module_info[0]->module_no_pk) ? $module_info[0]->module_no_pk : "0";
            }
        }
       



        $i = 0;
        $item_arr = [];
        $batch_arr = [];
        $intern_batch_arr = [];
        $expire_arr = [];
        $quantity_arr = [];
        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt =$vat_percent_arr= [];
        $hdn_item_rate = [];
        $hdn_item_qnty = [];
        $whole_sale = [];
        $hdn_item_dis = [];
        $item_dis_amt = [];
        $item_dis_pers = [];
        $item_level_remarks = [];
        for ($i = 0; $i < count($request->txt_batch); $i++) {
            $item_data = explode('_', $request->txt_batch[$i]);
            $item_arr[$i] = $item_data[0];
            $item_level_remarks[$i] = 0;
            $item_batch_no[$i] = $item_data[1];
            $intern_batch[$i] = trim($request->internal_batch_no[$i]);
            $intern_batch_arr[$i] = $intern_batch[$i] != "" ? trim($intern_batch[$i]) : "";
            $batch_arr[$i] = $item_batch_no[$i] != "0" ? trim($item_batch_no[$i]) : "";
            $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

            if ($whole_sale[$i] == "") {
                // $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
                if ($request->batch_wise_sales_price[$i] !=null ) {
                    $hdn_item_rate[$i] = $request->batch_wise_sales_price[$i];
                    // dd($hdn_item_rate[$i],1);
                }else{
                    $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
                }
            } else {

                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('dealer_sales_price')->where('item_no_pk', $item_arr[$i])->first()->dealer_sales_price;
            }
            $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
            $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

            $exp = explode('_', $request->txt_expire_date[$i]);
            $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";

            $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
            $hdn_item_qnty[$i] = $checker[0];
            $qty_exp = explode('_', $request->batch_qty[$i]);
            $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0];
            $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
            $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
            $package_ind_arr[$i] = 0;
            $vat_percent_arr[$i] =$request->input('item_vat_pers_' . $item_arr[$i])[0] !="" ? ($hdn_item_rate[$i] *  $request->input('item_vat_pers_' . $item_arr[$i])[0]) / 100 : 0;
            // $vat_percent_arr[$i] =$request->input('item_vat_pers_' . $item_arr[$i])[0] !="" ? (($quantity_arr[$i] * $hdn_item_rate[$i]) *  $request->input('item_vat_pers_' . $item_arr[$i])[0]) / 100 : 0;
            $item_mu_arr[$i] = 0;
            $hdn_item_urgent_fee_amt[$i] = (isset($urgent_fee[$i]) ? $urgent_fee[$i] : 0);

            if ($request->item_dis_radio == 1) {
                $item_dis_pers[$i] = $item_data[2];
                $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
            } elseif ($request->item_dis_radio == 2) {
                $item_dis_amt[$i] = $item_data[2];
                $item_dis_pers[$i] = $item_dis_amt[$i] != '' ? ($item_dis_amt[$i] / ($quantity_arr[$i] * $hdn_item_rate[$i])) * 100 : 0;
            } else {
                $item_dis_amt[$i] = 0;
                $item_dis_pers[$i] = 0;
            }
        }
        // dd($vat_percent_arr , $item_arr);
        $total_item = count($item_arr);
        $invoice_date = "";

        if (array_sum($item_dis_amt) > 0) {
            $item_discount = 1;
        } else {
            $item_discount = "";
        }

        // dd($module_id);
        $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->item_dis_ind != '' ? $request->item_dis_ind : 0;

        $pdo = DB::getPdo();
        // pkg_billing_v0.prc_billinvoice_phr_wp
        $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_stock_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_intern_batch_fk,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,
        :in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");

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
        $billinvoice->bindParam(':in_report_delivary_date', $invoice_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        $billinvoice->bindParam(':in_cor_client_no_fk', $null);
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
        $billinvoice->bindParam(':in_phone_mobile',  $walk_in_phone);

        $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        $billinvoice->bindParam(':in_urgent_fee_total', $total_urgent_fee);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_emergency_ind', $null);
        $billinvoice->bindParam(':in_daycare_ind', $null);
        $billinvoice->bindParam(':in_ot_ind', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        $billinvoice->bindParam(':in_item_count', $total_item);
        $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);

        $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_item_vat', $vat_percent_arr, count($vat_percent_arr), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

        $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);

        $out_ledgertrn_no = $in_ledgertrn_no = "";
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($billinvoice);
        $billinvoice->execute();
        $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

        if ($out_error == 999) {
            dd($out_error . "invoice");
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {
            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_stock_wp(
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
                     :in_item_batch_fk,
                     :in_item_expiry_dt,
                     :in_intern_batch_fk,
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

            $billpayment->bindParam(':in_payment_date', $cur_date);
            $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
            $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
            $billpayment->bindParam(':in_module_no_fk', $module_id);
            $billpayment->bindParam(':in_patient_no_fk', $pat_id);
            $billpayment->bindParam(':in_admission_no_fk', $admission_id);
            $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
            $billpayment->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
            $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
            $billpayment->bindParam(':in_ledger_amt_payment', $total_payment);
            $billpayment->bindParam(':in_ledger_amt_discount', $total_discount_amount);
            $billpayment->bindParam(':in_urgent_fee', $total_urgent_fee);
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();

            $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = $hospital_id_for_disc = 0;
            $hospital_disc_amt = $total_discount_amount; //$disc_amount_hospital;
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
            $billpayment->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $out_ledgertrn_no2 = "";
            $billpayment->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            //   dd($billpayment);
            $billpayment->execute();

            if ($out_error == 999) {
                dd($out_error, $out_invoice_no2, $out_invoice_no, $total_item, $item_arr);
                DB::rollback();
                $message = ['msg' => 'Bill create Failled Payment.', 'title' => 'Error'];
            } else {
                if ($request->emp_id !="") {
                    DB::table('finc_invoicemst')->where('invoice_no_pk', $out_invoice_no)->update(['employee_no_fk'=>$request->emp_id,'department_no'=>$request->service_unit]);
                }                
                $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                $auth_id = Auth::id();
                date_default_timezone_set('Asia/Dhaka');
                $time = Carbon::now();

                $date = date('Y-m-d h:i:s', strtotime($time));
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

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
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

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                } else {

                    DB::commit();
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2, 'trx_id' => $out_ledgertrn_no];
                }
            }

        }
        } catch (\Exception $e) {
            DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function pos_cancelation_v1($request)
    {

      
        $coun = count($request->cancel_checkbox);
    
        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {

        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();

        $cancel_date = date('Y-m-d h:i:s', strtotime($time));
        $invoice_no = $request->hdn_invoice_no_fk;
        $item_no = $request->cancel_ind;
        $cencel_q = $request->cancel_checkbox;

        $expiry_date = $request->expiry_date;
        $batch_no = $request->batch_no;
        $internal_batch_no_uq = $request->internal_batch_no_uq;
        $i = 0;
        $item_no_arr = [];
        $cencel_q_arr = [];

        $expiry_date_arr = [];
        $batch_no_arr = [];
        $internal_batch_no_uq_arr = [];
        foreach ($item_no as $value) {
            $data_expl=explode('*',$value);
            $item_no_arr[$i] =$data_expl[0];//$value;
            $cencel_q_arr[$i] = $cencel_q[$i]; 
            $expiry_date_arr[$i] =$data_expl[1] !='' ? date('dmY',strtotime($data_expl[1])) :'';//$expiry_date[$i];
            $batch_no_arr[$i] =$data_expl[2];//$batch_no[$i];
            $internal_batch_no_uq_arr[$i] =$data_expl[3];// $internal_batch_no_uq[$i];
            $i++;
        }
        // dd($item_no_arr, $cencel_q_arr,$expiry_date_arr,$batch_no_arr, $internal_batch_no_uq_arr);
        // $module_no=1;
        // $admission_no=1;
        $cunter_su_no = ($request->service_point != "") ? $request->service_point : 0;

        $entry_session = "session";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $numelems = 200;
        // $coun=3;
        $admission_id = $request->admission_no_pk;
        // if ($admission_id != "") {
        //    $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
        //    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        // } else {
        // $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        // $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        // }
        $module_id = DB::table("finc_invoicemst")->where("invoice_no_pk", $invoice_no)->select("module_no_fk")->first()->module_no_fk;
        // dd( $module_id );
        $responseBody='';
        // $procedureName = "pkg_billing_dev_2.prc_sales_cancellation";
        $in_ledgertrn_no = $outError = $out_invoice_id = $out_invoice_no = $out_ledgertrn_no = '';
        $pdo = DB::getPdo();
        $refund_amount = $request->refund;
        $refund_reason = $request->cancel_reason;
        // $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_phr_sales_cancellation(:in_cancel_date,
        // :in_invoice_no_pk,
        // :in_refund_amount,
        // :in_refund_reason,
        // :in_item_no_fk,
        // :in_cancel_qty,
        // :in_item_count,
        // :in_module_no_fk,
        // :in_admission_no_fk,
        // :in_counter_su_no_fk,
        // :in_au_entry_by,
        // :in_au_entry_session,
        // :in_au_entry_hospital_pk_no,
        // :in_ledgertrn_no,
        // :out_invoice_no,
        // :out_invoice_id,
        // :out_ledgertrn_no,
        // :out_error); end;");
        // $refund_reason = " Dtabse issue";
        // $refund_amount = round($refund_amount);
        // $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
        // $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
        // $billinvoice->bindParam(':in_refund_amount', $refund_amount);
        // $billinvoice->bindParam(':in_refund_reason', $refund_reason);
        // $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
        // $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_INT);
        // $billinvoice->bindParam(':in_item_count', $coun);
        // $billinvoice->bindParam(':in_module_no_fk', $module_id);
        // $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
        // $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
        // $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        // $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        // $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        // $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        // $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        // $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 10000);
        // $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        // $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 100000);
        // //   dd($billinvoice);
        // $billinvoice->execute();
        $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_phr_sales_cancel_batch_exp(
        :in_cancel_date,
        :in_invoice_no_pk,
        :in_refund_amount,
        :in_refund_reason,
        :in_item_no_fk,
        :in_cancel_qty,
        :in_item_batch_fk,
        :in_item_expiry_dt,
        :in_intern_batch_fk,
        :in_item_count,
        :in_module_no_fk,
        :in_admission_no_fk,
        :in_counter_su_no_fk,
        :in_au_entry_by,
        :in_au_entry_session,
        :in_au_entry_hospital_pk_no,
        :in_ledgertrn_no,
        :out_invoice_no,
        :out_invoice_id,
        :out_ledgertrn_no,
        :out_error); end;");
        $refund_reason = " Dtabse issue";
        $refund_amount = round($refund_amount);
        $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
        $billinvoice->bindParam(':in_invoice_no_pk', $invoice_no);
        $billinvoice->bindParam(':in_refund_amount', $refund_amount);
        $billinvoice->bindParam(':in_refund_reason', $refund_reason);
        $billinvoice->bindArray(':in_item_no_fk', $item_no_arr, count($item_no_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_cancel_qty', $cencel_q_arr, count($cencel_q_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_batch_fk', $batch_no_arr, count($batch_no_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_item_expiry_dt', $expiry_date_arr, count($expiry_date_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_intern_batch_fk', $internal_batch_no_uq_arr, count($internal_batch_no_uq_arr), $numelems, SQLT_CHR);
        $billinvoice->bindParam(':in_item_count', $coun);
        $billinvoice->bindParam(':in_module_no_fk', $module_id);
        $billinvoice->bindParam(':in_admission_no_fk', $admission_id);
        $billinvoice->bindParam(':in_counter_su_no_fk', $cunter_su_no);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 10000);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 100000);
        //   dd($billinvoice);
        $billinvoice->execute();

        // $result = DB::executeProcedure($procedureName, $dataBindingArr);

        if ($outError == '000') {

            // dd($request->apidiscount_type,$request->hdn_patient_id);
            if (Session::get('user.ses_hospital_code') == "DMHL" && $request->apidiscount_type != '' && $request->hdn_patient_id !='') {
                $get_card_no = DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk', $request->hdn_patient_id)->first();          
                $input_value = $get_card_no->cardnumber ?? '';
            
                $total_discount = $request->cancel_discounted_amount ?? 0;                          
                $total_payment_amt = $total_payment ?? 0;                           
                $totalhcsclaimamountpl = $request->cencel_net_amount;
                $item_total_amount =0;// array_sum($request->hdn_item_total_qnty);
                
                $null = '';
                $zoro="0";
                $typeCode = $request->discounttypecode;
                
                if ($input_value != "") {
                    // Define the API endpoint URL
                   
                    $url = 'https://hisapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                    // $token = 'kOhNR/cQrqfOy5tSG1/KkRFUFZHBV/O20tv91jnSM6GuiGwAcOtbSMtIByYQRlj3cvu4Qdj76qrDM2nyi1ei/7E4occAJHXFeW5wG+FK2cVs2x2fnn2Txk7/eHfyRWmx+9D5nzXDMSAV0hDXkWxxwlb60rIWkMBxJDJElZWbNCsBLHRnzTH1eo1g2/RAtB9Ck1OZe8wLBLwplSqKSMwUjAAUpv26MIikFvv2COHU3qbyRau/FdL67v3/8epOZctjaPUQK/cDohVXAO5u97SVrvSJ0pxb2V2GLqX7ak29qvhMAvqnIFRFUhryi4pavxxo';
                    $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

                    // $url = 'https://hisstagingapi.cccul.com/api/his_V1/SavePersonInsuranceClaim';
                    // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

                    // Prepare the data to be sent in the POST request
                    $data =(object) [
                        "ByUserId"          => "8415",
                        "PersonId"          => "121529",
                        "MemberIdentity"    => $input_value,
                        "BillNo"            => $out_invoice_no,
                        "DiscountDetails"   => [(object)[
                            "DiscountTypeCode"      => 03,//$request->apidiscount_type,
                            "DCDiscountPercentage"  => $zoro,
                            "DCDiscountAmount"      => $total_discount,
                            "DMHDiscountPercentage" => $zoro,
                            "DMHDiscountAmount"     => $zoro,
                            "AfterDiscountAmount"   => $totalhcsclaimamountpl
                        ]],
                        "TotalHCSClaimAmount"=> strval($total_discount),
                        "FinalPayment"       =>  $totalhcsclaimamountpl,
                        "BillDate"           => $cancel_date,                                    
                        "Remarks"            => $null,
                        "DiseaseName"        => $null,
                        "VoucherStatus"      => 0,
                        "MobileNumber"       => "-",
                        "UserName"           => "info@divinemercyhospital.com",
                        "RequestFrom"        => "HIS"
                    ];
                    
                    try {
                        // Create a Guzzle client instance
                        $client = new Client();                       
                        // Make the POST request with the authorization token and data
                        $response = $client->post($url, [
                            'headers' => [
                                'token' => $token,
                                'Content-Type' => 'application/json',
                            ],
                            'json' => $data
                        ]);
            
                        // Check response status code
                        if ($response->getStatusCode() == 200) {
                            // Get the response body
                            $responseBody = json_decode($response->getBody(), true);
                            DB::table('finc_ledgermst')->where('invoice_no_fk',$out_invoice_no)->update(['apidiscount_type'=> 03]);
                            DB::commit();
                            $message = [
                                'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                                'title' => 'Success', 
                                'insert_id' => $out_invoice_no, 
                                'trx_id' => $out_ledgertrn_no,
                                'responseBody' => $responseBody,
                            ];
                        } else {
                            return response()->json([
                                'message' => 'Request failed',
                                'error' => 'Unexpected response status: ' . $response->getStatusCode()
                            ], $response->getStatusCode());
                        }
            
                    } catch (\GuzzleHttp\Exception\RequestException $e) {
                        // Handle request exceptions
                        return response()->json([
                            'message' => 'Request failed',
                            'error' => $e->getMessage()
                        ], $e->getCode());
                    }
                }
            } else {
                DB::commit();
                $message = [
                    'msg' => 'New Bill created successfully. Invoice ID = ' . $out_invoice_no, 
                    'title' => 'Success', 
                    'insert_id' => $out_invoice_no, 
                    'trx_id' => $out_ledgertrn_no,
                    'responseBody' => $responseBody,
                ];
            }
            DB::commit();
            $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no,'responseBody' => $responseBody];
        } else {

            DB::rollback();
            $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
        }

        //}
        // catch (\Exception $e) {
        //        DB::rollback();
        //        $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }

    public function ambulanceBillCreateOrUpdateV1($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();
        // driver_name
        try {
            $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
            $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
            $walk_in_name = $request->customer_name != "" ? $request->customer_name : "customer";

            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_driver_id = !empty($request->hdn_driver_id) ? $request->hdn_driver_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
            $patient_name = !empty($request->patient_name) ? $request->patient_name : '';
            $phone_mobile = !empty($request->phone_mobile) ? $request->phone_mobile : '';
            $patient_code = !empty($request->patient_code) ? $request->patient_code : '';
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';

            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

            $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;
            $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
            $hdn_item_name = $request->hdn_item_name;
            $hdn_item_type = $request->hdn_item_type;
            $total_item = count($hdn_item_id);
            $txt_batch = $request->txt_batch;
            $item_vat_prse = $request->vat_pers;
            $provider_no = $request->hdn_provider;

            $txt_expire_date = $request->txt_expire_date;
            $hdn_item_rate = $request->hdn_item_rate;
            $hdn_item_qnty = $request->hdn_item_qnty;
            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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

            $total_payment = $request->total_payment;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
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

            // $in_paymood_arr_t = $request->pay_method_mode;
            // $in_pay_mood_type_arr_t = $request->mBank_types;
            // $in_bank_name_arr_t = $request->pay_bank_name;
            // $in_transaction_id_arr_t = $request->trans_id_no;
            // $in_bank_card_no_arr_t = $request->trans_id_no;
            // $in_acc_holder_name_arr_t = $request->acc_holder_name ;
            // $in_payment_amt_arr_t = $request->total_amt;
            // $in_paymood_count = $paymood_count;

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
                    $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                    $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                    $package_ind_arr[$i] = 0;
                    $item_mu_arr[$i] = 0;
                    $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                    $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                    $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                    $item_disc_amount[$i] = $request->auto_discount[$i];
                    $ipd_charge[$i] = $request->ipd_charge[$i];
                    $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                    $item_level_remarks[$i] = 0;
                    $i++;
                }
            }
            $s_charge = $request->service_charge != "" ? $request->service_charge : 0; // array_sum($ipd_charge);

            if ($admission_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                if ($service_appointment_id != "") {
                    $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
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
                $sequence = DB::getSequence();
                $fixed_rate_ind = $request->rateInd == "Fixed" ? 1 : "";
                $distance_rate_ind = $request->rateInd == "Distance" ? 1 : "";
                // $ambt_trip_no_pk = $sequence->nextValue('ambt_trip_no_pk_seq');
                $ambt_trip_no_pk = $request->trip_id;
                $data = [
                    // 'ambt_trip_no_pk' => $ambt_trip_no_pk,
                    // 'ambt_trip_date' => "",
                    // 'trip_patient_type' => $request->trip_patient_type,
                    'invoice_no_fk' => $out_invoice_no,
                    // 'patient_no_fk' => $hdn_patient_id,
                    // 'patient_name' => !empty($patient_name) ? $patient_name : $walk_in_name,
                    // 'phone_mobile' => !empty($phone_mobile) ? $phone_mobile : $walk_in_phone,
                    // 'patient_code' => !empty($patient_code) ? $patient_code : 'P000000000000',
                    // 'email' => $request->email,
                    // 'dob' => isset($request->patient_dob_hidden) ? date('Y-m-d', strtotime($request->patient_dob_hidden)): "" ,
                    // 'age_dd' => $request->pat_age_d,
                    // 'age_mm' => $request->pat_age_m,
                    // 'age_yy' => $request->pat_age_y,
                    // 'gender_txt' => $request->gender_text,
                    // 'person_no_fk' => $hdn_driver_id,
                    // 'address' => $walk_in_customer_addr,
                    // 'item_no_fk' => "",
                    // 'start_from_location' => $request->start_from_location,
                    // 'ended_to_location' => $request->ended_to_location,
                    // 'distince_km' => $request->distance_km,
                    'fixed_rate_ind' => $fixed_rate_ind,
                    'distance_rate_ind' => $distance_rate_ind,
                    'remarks_text' => $request->amb_remarks,
                    // 'ambulance_rate' => $request->amb_fee,
                    'total_bill' => $total_payable,
                    'payment_amt' => $total_payment??0,
                    'invoice_code' => isset($finc_invoice_data->invoice_code) ? $finc_invoice_data->invoice_code : "",
                    'module_no_fk' => isset($finc_invoice_data->module_no_fk) ? $finc_invoice_data->module_no_fk : "",
                    'cancel_ind' => isset($finc_invoice_data->invoice_cancel_ind) ? $finc_invoice_data->invoice_cancel_ind : "",
                    'CANCEL_REASON' => isset($finc_invoice_data->invoice_cancel_ind) ? $finc_invoice_data->invoice_cancel_ind : "",
                    'status' => 1,
                    'au_update_by' => $auth_id,
                    'au_update_at' =>  date('y-m-d h:i:s'),
                    'au_update_hospital_pk_no' => session::get('user.ses_hospital_no_pk')
                ];

                DB::table('ambt_ambulancetrip')->where('ambt_trip_no_pk',$ambt_trip_no_pk)->update($data);
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

                $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();

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
        } catch (\Exception $e) {
            DB::rollback();

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function abmulanceBillcreateOrUpdate($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
        $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
        $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
        $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";

        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $module_id = 0;
        $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; //appointment_id
        $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        //  $prescription_id = !empty($request->prescription_id) ? $request->prescription_id : '';

        $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        $hdn_item_id = $request->hdn_item_id;
        $hdn_item_urgent_fee = $request->hdn_item_urgent_fee;
        $hdn_item_name = $request->hdn_item_name;
        $hdn_item_type = $request->hdn_item_type;
        $total_item = count($hdn_item_id);
        $txt_batch = $request->txt_batch;
        $item_vat_prse = $request->vat_pers;

        $txt_expire_date = $request->txt_expire_date;
        $hdn_item_rate = $request->hdn_item_rate;
        $hdn_item_qnty = $request->hdn_item_qnty;
        $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        $hdn_item_deli_date = $request->delivery_date != null ? $request->delivery_date : '';

        $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

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
        $s_charge = $request->s_charge;
        $total_payment = $request->total_payment;
        $entry_session = "session";

        $item_total = $request->item_total;
        $total_payable = $request->total_payable;
        $total_discount_amount = $request->total_discount_amount;
        $discount_remarks = $request->discount_remarks;
        //$given_amount ="120";
        $bank_name = $request->bank_name;
        $bank_name_card = $request->bank_name_card;
        $card_no = $request->card_no;
        $bkash_txn_id = $request->bkash_txn_id;
        $holder_name = $request->holder_name;
        $check_no = $request->check_no;
        $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
        $report_delivery_date = $request->raport_delivery_date != "" ? date('Y-m-d', strtotime($request->raport_delivery_date)) : '';

        // $in_paymood_arr_t = $request->pay_method_mode;
        // $in_pay_mood_type_arr_t = $request->mBank_types;
        // $in_bank_name_arr_t = $request->pay_bank_name;
        // $in_transaction_id_arr_t = $request->trans_id_no;
        // $in_bank_card_no_arr_t = $request->trans_id_no;
        // $in_acc_holder_name_arr_t = $request->acc_holder_name ;
        // $in_payment_amt_arr_t = $request->total_amt;
        // $in_paymood_count = $paymood_count;

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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = [];
        $i = 0;

        if (!empty($hdn_item_id)) {
            foreach ($hdn_item_id as $deli_date) {
                $sc_date = date("d-m-Y");
                $deli_dt_arr[$i] = ($hdn_item_deli_date[$i] != null ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (!empty($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $batch_no_arr[$i] = (!empty($txt_batch[$i]) ? $txt_batch[$i] : '');
                $expire_dt_arr[$i] = (!empty($txt_expire_date[$i]) ? $txt_expire_date[$i] : '');
                $hdn_item_urgent_fee_amt[$i] = $request->item_delivery_status[$i] == 2 ? $hdn_item_urgent_fee[$i] : 0;
                $item_disc_amount[$i] = $request->auto_discount[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $i++;
            }
        }
        // dd($urgent_fee,  $hdn_item_urgent_fee_amt);
        // dd(  $item_disc_amount);
        // $i = 0;
        // if (!empty($in_paymood_arr_t)) {
        //       foreach ($in_paymood_arr_t as $key=>$value) {
        //             $sc_date = date("d-m-Y");
        //             $in_paymood_arr[$i] = $value;
        //             $in_pay_mood_type_arr[$i] =(!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "null") ;
        //             $in_bank_name_arr[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "null");
        //             $in_transaction_id_arr[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "null");
        //             $in_bank_card_no_arr[$i] =(!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "null") ;
        //             $in_acc_holder_name_arr[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "null") ;
        //             $in_payment_amt_arr[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "null");

        //             $i++;
        //       }
        // }

        // dd($admission_id);
        //  if ($page_type == 1) {
        if ($admission_id != "") {
            $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        } else {
            if ($service_appointment_id != "") {
                $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            } else {
                $module_info = DB::table("sysc_module")->where("module_code", "AMB")->select("module_no_pk")->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            }
        }
        if ($hdn_patient_id != "") {
            $corporate_id = DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
        } else {
            $corporate_id = '';
        }
        // dd($corporate_id);
        //  }

        //  if ($page_type == 2) {
        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        //     $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        //  }

        // OUT PAREMETER INITIALIZE
        $out_invoice_no = $out_invoice_id = $out_error = "";
        $item_level_disc_ind = $request->patient_itemType_dis_ind != "" ? $request->patient_itemType_dis_ind : 0;
        // $item_disc_percent[]=0;
        // $item_disc_amount[]=0;
        $item_level_remarks[] = 0;
        // dd($item_level_disc_ind);
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");

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
        $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

        $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        $billinvoice->execute();

        if ($out_error == 999) {
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $out_invoice_no2 = $out_ledger_no = $out_error = "";
            $pdo1 = DB::getPdo();
            $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_wp(
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
                     :out_invoice_no,
                     :out_invoice_id,
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
            $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
            //dd($discount_info->lookupdata_no_pk);

            $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = $hospital_id_for_disc = 0;

            if (!empty($discount_info)) {
                if ($discount_info->lookupdata_code == "DOCTOR") {
                    $doctor_disc_amt = $disc_amount_doctor;
                    $doctor_id_for_disc = $hdn_dis_doctor_id;
                }

                if ($discount_info->lookupdata_code = "GENERAL") {
                    $hospital_disc_amt = $disc_amount_hospital;
                    $hospital_id_for_disc = $hdn_dis_doctor_id;
                }

                if ($discount_info->lookupdata_code = "BOTH") {
                    $doctor_disc_amt = $disc_amount_doctor;
                    $doctor_id_for_disc = $hdn_dis_doctor_id;
                    $hospital_disc_amt = $disc_amount_hospital;
                }
            }

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
            $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);

            $billpayment->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);

            $billpayment->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

            $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
            $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
            $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

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

                // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                $pdo2 = DB::getPdo();
                $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
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
                    $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
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

    public function POScreateOrUpdateIndentV1($request, $id = null)
    {
        // dd($request->all(), "OK");

        try {
            $auth_id = Auth::id();
            DB::beginTransaction();
            $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
            $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
            $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";

            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d h:i:s', strtotime($time)); 
            $cur_datetime = date('Y-m-d h:i:s', strtotime($time)); 
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
            $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : ''; 
            $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
            $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        
            $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
            $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

            $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
            $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
            $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

            $hdn_item_id = $request->hdn_item_id;

            $txt_batch = $request->txt_batch;
            $txt_expire_date = $request->txt_expire_date;

            $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

            $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
            $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

            $cmb_discount = $request->cmb_discount; 
            $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
            $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
            $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
            $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
            $remarks = !empty($request->remarks) ? $request->remarks : " ";
            $pay_mode = $request->pay_mode;
            $pay_amount = $request->pay_amount;
            $given_amount = $request->given_amount;
            $change_amount = $request->change_amount;
            $item_vat = $request->item_vat;
            $urgent_fee = $request->uregent_fee;
            $total_urgent_fee = $request->total_urgent_fee;
            $s_charge = $request->s_charge;
            $total_payment = $request->total_payment;
            $entry_session = "session";

            $item_total = $request->item_total;
            $total_payable = $request->total_payable;
            $adj_dis = $request->dis_adj_amt;
            $total_discount_amount = $request->total_discount_amount + $adj_dis;
            $discount_remarks = $request->discount_remarks;
            $bank_name = $request->bank_name;
            $bank_name_card = $request->bank_name_card;
            $card_no = $request->card_no;
            $bkash_txn_id = $request->bkash_txn_id;
            $holder_name = $request->holder_name;
            $check_no = $request->check_no;
            $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $null = '';

            $out_sl_no = '';
            $empty_arr = [];
            $numelems = 500;
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

            if ($in_counter_su_no_fk != 0) {
                $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
                if (isset($service_unit_check)) {
                    if ($service_unit_check->hs_pos_ind == 1) {
                        $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    } else {
                        if (isset($request->hdn_admission_id)) {

                            // if ($request->customer_type_radio == 5) {
                            //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                            // }elseif ($request->customer_type_radio == 6) {
                            //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                            // }elseif ($request->customer_type_radio == 7) {
                            //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                            // }else{
                            //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                            // }
                            $module_code= $request->module !=''?  $request->module:"PHR-I" ;
                            $module_info = DB::table("sysc_module")->where("module_code",  $module_code)->select("module_no_pk")->first();
                            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                            // dd( $module_id);

                        } else {
                            $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                        }
                    }
                } else {
                    if (isset($request->hdn_admission_id)) {
                        $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    } else {
                        $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    }
                }
            } else {
                if (isset($request->hdn_admission_id)) {
                    $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }
           

            $i = 0;
            $item_arr = [];
            $batch_arr = [];
            $expire_arr = [];
            $intern_batch_arr = [];
            $quantity_arr = [];
            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
            $hdn_item_rate = [];
            $hdn_item_qnty = [];
            $whole_sale = [];
            $hdn_item_dis = [];
            $item_dis_amt = [];
            $item_dis_pers = [];
            $item_level_remarks = [];
            
            for ($i = 0; $i < count($request->txt_batch); $i++) {
                $item_data = explode('_', $request->txt_batch[$i]);
                $item_arr[$i] = $item_data[0];
                $item_level_remarks[$i] = 0;
                $item_batch_no[$i] = $item_data[1];
                $intern_batch[$i] = trim($request->internal_batch_no[$i]);
                $batch_arr[$i] = $item_batch_no[$i] != "0" ? trim($item_batch_no[$i]) : "";
                $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

                if ($whole_sale[$i] == "") {
                    // $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
                    if ($request->batch_wise_sales_price[$i] !=null ) {
                        $hdn_item_rate[$i] = $request->batch_wise_sales_price[$i];
                        // dd($hdn_item_rate[$i],1);
                    }else{
                        $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
                    }
                } else {

                    $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('dealer_sales_price')->where('item_no_pk', $item_arr[$i])->first()->dealer_sales_price;
                }
                $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
                $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

                $exp = explode('_', $request->txt_expire_date[$i]);
                $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";
                $intern_batch_arr[$i] = $intern_batch[$i] != "" ? trim($intern_batch[$i]) : "";
                $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
                $hdn_item_qnty[$i] = $checker[0];
                $qty_exp = explode('_', $request->batch_qty[$i]);
                $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0];
                $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "");
                $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
                $package_ind_arr[$i] = 0;
                $item_mu_arr[$i] = 0;
                $hdn_item_urgent_fee_amt[$i] = (isset($urgent_fee[$i]) ? $urgent_fee[$i] : 0);

                if (Session::get('user.ses_hospital_code') == "UNICO") {
                    $item_dis_pers[$i] = $item_data[2];
                    $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
                }else{
                    if ($request->item_dis_radio == 1) {
                        $item_dis_pers[$i] = $item_data[2];
                        $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] * $hdn_item_rate[$i]) * $item_dis_pers[$i]) / 100 : 0;
                    } elseif ($request->item_dis_radio == 2) {
                        $item_dis_amt[$i] = $item_data[2];
                        $item_dis_pers[$i] = $item_dis_amt[$i] != '' ? ($item_dis_amt[$i] / ($quantity_arr[$i] * $hdn_item_rate[$i])) * 100 : 0;
                    } else {
                        $item_dis_amt[$i] = 0;
                        $item_dis_pers[$i] = 0;
                    }
                }
            
            }
            $total_item = count($item_arr);
            $invoice_date = "";

            if (array_sum($item_dis_amt) > 0) {
                $item_discount = 1;
            } else {
                $item_discount = "";
            }

            // dd($total_item);
            $out_invoice_no = $out_invoice_id = $out_error = "";
            $item_level_disc_ind = $request->item_dis_ind != '' ? $request->item_dis_ind : 0;
        
            $pdo = DB::getPdo();
            // pkg_billing_v0.prc_billinvoice_phr_wp
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_stock_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_intern_batch_fk,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,
            :in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");
            // dd($item_dis_pers , $item_dis_amt);
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
            $billinvoice->bindParam(':in_report_delivary_date', $invoice_date);
            $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
            $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
            $billinvoice->bindParam(':in_cor_client_no_fk', $null);
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
            $billinvoice->bindParam(':in_phone_mobile',  $walk_in_phone);

            $billinvoice->bindParam(':in_invoice_remarks', $remarks);
            $billinvoice->bindParam(':in_urgent_fee_total', $total_urgent_fee);
            $billinvoice->bindParam(':in_invoice_type', $null);
            $billinvoice->bindParam(':in_emergency_ind', $null);
            $billinvoice->bindParam(':in_daycare_ind', $null);
            $billinvoice->bindParam(':in_ot_ind', $null);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
            $billinvoice->bindParam(':in_item_count', $total_item);
            $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

            $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);

            $out_ledgertrn_no = $in_ledgertrn_no = "";
            $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($billinvoice);
            $billinvoice->execute();
        
            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Bill billinvoice Failled.' . $out_error, 'title' => 'Error'];
                return response()->json($message,422);
            } else {
                $out_invoice_no2 = $out_ledger_no = $out_error = "";
                $pdo1 = DB::getPdo();
                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_stock_wp(
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
                        :in_item_batch_fk,
                        :in_item_expiry_dt,
                        :in_intern_batch_fk,
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
                $billpayment->bindParam(':in_urgent_fee', $total_urgent_fee);
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
                $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();

                $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = $hospital_id_for_disc = 0;
                $hospital_disc_amt = $total_discount_amount; //$disc_amount_hospital;
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
                $billpayment->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_intern_batch_fk', $intern_batch_arr, count($intern_batch_arr), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                $out_ledgertrn_no2 = "";
                $billpayment->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
                $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
                $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no2, PDO::PARAM_INT);
                $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
                $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                //   dd($billpayment);
                $billpayment->execute();

                if ($out_error == 999) {
                 
                    DB::rollback();
                    $message = ['msg' => 'Bill payment Failled.', 'title' => 'Error'];
                    return response()->json($message,422);
                } else {

                    $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                    $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();

                    $auth_id = Auth::id();
                    date_default_timezone_set('Asia/Dhaka');
                    $time = Carbon::now();

                    $date = date('Y-m-d h:i:s', strtotime($time));
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

                    $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                    $pdo2 = DB::getPdo();
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

                    if ($out_error == 999) {
                        DB::rollback();
                        $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                        return response()->json($message,422);
                    } 
                }
            }





            // indent entry
            $sequence = DB::getSequence();
            // $master_id = $sequence->nextValue('ipdpatmedtran');
            // $med_req_id = $request->patmedtran_no_pk;

            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            $nurse_station_fk = '';
            $store_no_fk = DB::table('sysc_serviceunit')->where('ipdphr_ind', 1)->value('serviceunit_no_pk');
            // dd($request->txt_batch,$request['prescription_no_fk']);
            for ($j = 0; $j < count($request->txt_batch); $j++) {
                // $item_data = explode('_', $request->txt_batch[$j]);
                // $item_arr[$j] = $item_data[0];              
                // $item_batch_no[$j] = $item_data[1];
                // $intern_batch[$j] = trim($request->internal_batch_no[$j]);
                // $batch_arr[$j] = $item_batch_no[$j] != "0" ? trim($item_batch_no[$j]) : "";   
                $exp2 = explode('_', $request->txt_expire_date[$j]);
                $expire_arr2[$j] = $exp2[1] != 0 ? date('Y-m-d', strtotime( $exp2[1])) : "";
                // $expire_arr[$j] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";
                // $intern_batch_arr[$j] = $intern_batch[$j] != "" ? trim($intern_batch[$j]) : "";
                // $checker = $request->input('hdn_item_qnty_' . $item_arr[$j]);
                // $hdn_item_qnty[$j] = $checker[0];
                // $qty_exp = explode('_', $request->batch_qty[$j]);
                // $quantity_arr[$j] = $request->batch_qty[$j] ? $qty_exp[1] : $checker[0];
              
            
                $sequence = DB::getSequence();
                $seq = $sequence->nextValue('seq_patmedtran');
                $prescription_id = isset($request['prescription_no_fk'][$j]) && $request['prescription_no_fk'][$j] != 'null' ? $request['prescription_no_fk'][$j] : null ;
                $rx_no = isset( $request['rx_no'][$j]) && $request['rx_no'][$j] != "null" ? $request['rx_no'][$j] : null ;
                
                $generic_no_fk = DB::table("sysc_serviceitem")->where('item_no_pk', $item_arr[$j])->value('generic_no_fk');
                if(empty($nurse_station_fk)){
                    $nurse_station_fk = DB::table('IPD_V1_ADMITTED_PAT_NSREQ_WL_VW')->where('MOVEMENT_NO',2)->where('admission_no_pk', $request->hdn_admission_id)->where('patient_no_fk', $request->hdn_patient_id)->value('ns_no_fk');
                }

                $query = DB::table("phr_ipdpatmedtran")->where('admission_no_fk', $request->hdn_admission_id)
                                    ->where('patient_no_fk', $request->hdn_patient_id)
                                    ->where('med_req_id', $request->med_req_id)
                                    ->where('tran_type','IR')
                                    ->where('item_no_fk', $item_arr[$j]);
                if(!empty($prescription_id)){
                    $query->where('pres_no_fk', $prescription_id);
                }

                $ref_tran_id  = $query->value('patmedtran_no_pk');

                    $data = [
                        'TRAN_DATE' => $au_entry_at,
                        'PATMEDTRAN_NO_PK' => $seq,
                        'SL_NO' => $j + 1,
                        'INVOICE_NO_FK' => $out_invoice_no,
                        'STATUS' => 1,                      
                        'PATIENT_NO_FK' => $request->hdn_patient_id,
                        'PRES_NO_FK' => $prescription_id,
                        'ITEM_QTY' => $quantity_arr[$j],
                        'ITEM_NO_FK' =>$item_arr[$j],
                        'ADMISSION_NO_FK' => $request->hdn_admission_id,
                        'AU_ENTRY_BY' => Auth::id(),
                        'AU_ENTRY_AT' => $au_entry_at,
                        'AU_ENTRY_SESSION' => $entry_session,
                        'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_pk_no,
                        'RX_NO' => $rx_no,
                        'TRAN_EMP' => null,
                        'STORE_NO_FK' => $store_no_fk,
                        'TRAN_TYPE' => 'RI',
                        'REF_TRAN_ID' => $ref_tran_id,
                        'READY_IND' => null,
                        'READY_BY' => null,
                        'READY_AT' => null,
                        'NURSESTATION_NO_FK' => $nurse_station_fk,
                        'MED_REQ_ID' => $request->med_req_id,
                        'GENERIC_NO' => $generic_no_fk,
                        'BATCH_NO' => $batch_arr[$j],
                        'INTERNAL_BATCH_NO' => $intern_batch_arr[$j],
                        'EXP_DATE' => $expire_arr2[$j],
                        'DELIVERY_IND' => null,
                        'DELIVERY_BY' => null,
                        'DELIVERY_AT' => null,
                        'COMMENTS' => null,
                        'LEDGERTRN_NO_FK' => $out_ledgertrn_no
                    ];
                    // dd($data);
                    if (DB::table('PHR_IPDPATMEDTRAN')->insert($data)) {
                        DB::commit(); 
                    }else{
                        DB::rollback();
                    }
              


            }



            // foreach($request->hdn_item_id as $key => $value){

                
            //     $sequence = DB::getSequence();
            //     $seq = $sequence->nextValue('seq_patmedtran');
            //     $prescription_id = $request['prescription_no_fk'][$key] != 'null' ? $request['prescription_no_fk'][$key] : null ;
            //     $rx_no = $request['rx_no'][$key] != "null" ? $request['rx_no'][$key] : null ;
                
            //     $generic_no_fk = DB::table("sysc_serviceitem")->where('item_no_pk', $value)->value('generic_no_fk');
            //     if(empty($nurse_station_fk)){
            //         $nurse_station_fk = DB::table('IPD_V1_ADMITTED_PAT_NSREQ_WL_VW')->where('MOVEMENT_NO',2)->where('admission_no_pk', $request->hdn_admission_id)->where('patient_no_fk', $request->hdn_patient_id)->value('ns_no_fk');
            //     }

            //     $query = DB::table("phr_ipdpatmedtran")->where('admission_no_fk', $request->hdn_admission_id)
            //                         ->where('patient_no_fk', $request->hdn_patient_id)
            //                         ->where('med_req_id', $request->med_req_id)
            //                         ->where('tran_type','IR')
            //                         ->where('item_no_fk', $value);
            //     if(!empty($prescription_id)){
            //         $query->where('pres_no_fk', $prescription_id);
            //     }

            //     $ref_tran_id  = $query->value('patmedtran_no_pk');

            //         $data = [
            //             'TRAN_DATE' => $au_entry_at,
            //             'PATMEDTRAN_NO_PK' => $seq,
            //             'SL_NO' => $key + 1,
            //             'INVOICE_NO_FK' => $out_invoice_no,
            //             'STATUS' => 1,                      
            //             'PATIENT_NO_FK' => $request->hdn_patient_id,
            //             'PRES_NO_FK' => $prescription_id,
            //             'ITEM_QTY' => $quantity_arr[$key],
            //             'ITEM_NO_FK' => $value,
            //             'ADMISSION_NO_FK' => $request->hdn_admission_id,
            //             'AU_ENTRY_BY' => Auth::id(),
            //             'AU_ENTRY_AT' => $au_entry_at,
            //             'AU_ENTRY_SESSION' => $entry_session,
            //             'AU_ENTRY_HOSPITAL_PK_NO' => $hospital_pk_no,
            //             'RX_NO' => $rx_no,
            //             'TRAN_EMP' => null,
            //             'STORE_NO_FK' => $store_no_fk,
            //             'TRAN_TYPE' => 'RI',
            //             'REF_TRAN_ID' => $ref_tran_id,
            //             'READY_IND' => null,
            //             'READY_BY' => null,
            //             'READY_AT' => null,
            //             'NURSESTATION_NO_FK' => $nurse_station_fk,
            //             'MED_REQ_ID' => $request->med_req_id,
            //             'GENERIC_NO' => $generic_no_fk,
            //             'EXP_DATE' => null,
            //             'DELIVERY_IND' => null,
            //             'DELIVERY_BY' => null,
            //             'DELIVERY_AT' => null,
            //             'COMMENTS' => null,
            //             'BATCH_NO' => null,
            //             'LEDGERTRN_NO_FK' => $out_ledgertrn_no
            //         ];

            //         DB::table('PHR_IPDPATMEDTRAN')->insert($data);
            // }

            DB::commit();
            $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'bill_ind'=>'pos', 'trx_id' => $out_ledgertrn_no];
            return response()->json($message,200);
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message,422);
        }
    }
}
