<?php

namespace App\Repositories;

use App\Models\Billing;
use App\Models\LookupItem;
use App\Models\ServiceUnit;
use App\Repositories\BaseRepository;
use App\Traits\LookupData;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;
use Session;

class BillingRepository extends BaseRepository
{
    use LookupData;

    protected $baseRepository;

    public function __construct(Billing $billing)
    {
        $this->billing = $billing;
        $this->baseRepository = new BaseRepository($billing);
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

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

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
            $out_ledgertrn_no = 0;
            $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = 0;
            // $item_level_disc_ind = $request->patient_itemType_dis_ind  != "" ? $request->patient_itemType_dis_ind : 0;
            $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;
            // dd($request->auto_dis_ind ,$request->discount_percent_hospital, $item_level_disc_ind);
            // $item_disc_percent[]=0;
            // $item_disc_amount[]=0;

            if (array_sum($item_disc_amount) > 0) {
                $item_discount = 1;
            } else {
                $item_discount = "";
            }
            // dd($item_discount , array_sum($item_disc_amount));
            // $item_level_remarks[] = 0;

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
            // dd($billinvoice);
            $billinvoice->execute();

            $out_ledgertrn_no2 = "";
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
                    $message = ['msg' => 'prc_billpayment_wp Failled.', 'title' => 'Error'];
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
                        $message = ['msg' => 'prc_finc_ledger_paymood Failled.', 'title' => 'Error'];
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
    public function createOrUpdateUhlV1($request, $id = null)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();

        // try {
        $page_type = !empty($request->page_type) ? $request->page_type : "";
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
        $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
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

        $payer_type = $request->payer_type;
        $sponsor_ccm_client_no_pk = $request->payer__sponsor;
        $referred_type = $request->refferred_type;
        $source_no_fk = $request->refferred_type;
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
        $payer_amt = [];
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
                $item_disc_amount_doc[$i] = $request->auto_discount_doc[$i];
                $item_disc_amount_doc_no_fk[$i] = $hdn_dis_doctor_id;
                $provider_id[$i] = $request->provider[$i] != "" ? $request->provider[$i] : '';
                $ipd_charge[$i] = $request->service_charge[$i] ?? 0;
                $hdn_item_type[$i] = $request->hdn_item_type[$i];
                $item_disc_percent[$i] = 0; //$request->auto_discount[$i] ;
                $item_level_remarks[$i] = 0;
                $payer_amt[$i] = 0;
                $i++;
            }
        }

        $s_charge = array_sum($ipd_charge);

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
            $corporate_id = $request->payer_details;
            //DB::table('patn_registration')->where('patient_no_pk', $hdn_patient_id)->first()->ccm_client_no_fk;
        } else {
            $corporate_id = '';
        }

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
        // dd($provider_id,$payer_amt);
        $pdo = DB::getPdo();
        // pkg_billing_v0 , pkg_v1_billing
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
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        $billinvoice->execute();

        $out_ledgertrn_no2 = "";
        if ($out_error == 999) {

            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
        } else {

            $depositusage_no = $request->deposit_type;
            $depositusage_type = '';
            if (!empty($depositusage_no)) {
                $depositusage_type = DB::table('sysc_lookupdata')->select('lookupdata_code')->where('lookupdata_no_pk', $depositusage_no)->first()->lookupdata_code;
                // $request->deposit_type;
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
            $billpayment->bindArray(':in_item_disc_amt_by_doc', $item_disc_amount_doc, count($item_disc_amount_doc), $numelems, SQLT_FLT);
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
            // dd($billpayment);
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
                // dd($in_invoice_no_arr, $in_bank_name_arr);
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
                    DB::table('patn_service_schedule')
                        ->where('schedule_no_pk', '=', $request->service_id)
                        ->update(['invoice_no_fk' => $out_invoice_no]);
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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = $ipd_charge = $provider_no = [];
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
        $emergency_ind = 1;
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

        $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $item_disc_percent = $item_disc_amount = $ipd_charge = $provider_no = [];
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
        $daycare_ind = 1;
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
                DB::commit();
                // dd($out_invoice_no,$out_ledgertrn_no);
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
            $admission_id = '';
            $invoice_no = null;
            if (!empty($item_no)) {
                foreach ($item_no as $value) {

                    $item_no_arr[$i] = $request->input('item_no_' . $value);
                    $cencel_q_arr[$i] = $request->input('cancel_qty_' . $value);
                    $admission_id = $request->input('admissin_id_' . $value);
                    $invoice_no = $request->input('invoice_no_' . $value);
                    $i++;


                    $cunter_su_no = 0; //($request->service_point != "") ? $request->service_point : 0;

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
                    $refund_reason = '';
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

        $item_level_disc_ind = 0;
        $out_invoice_no = $request->hdn_invoice_id;

        $in_ledgertrn_no = $out_invoice_no2 = $out_error = $out_ledger_no = "";
        $pdo1 = DB::getPdo();

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
        } elseif ($page_type == 2) {

            $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_wp(:in_payment_date,
            :in_payment_datetime,:in_invoice_no_fk,:in_module_no_fk,:in_patient_no_fk,:in_admission_no_fk,
            :in_prescription_no_fk,:in_counter_su_no_fk,:in_ledger_amt_sales,:in_ledger_amt_payment,
            :in_ledger_amt_discount,:in_urgent_fee,:in_service_charge,:in_cor_client_no_fk,:in_pay_mode,
            :in_pay_cqcc_holder_name,:in_pay_cqcc_number,:in_pay_cqcc_deduct_percent,
            :in_pay_bank_name,:in_pay_remarks,:in_given_amt,:in_disc_type_lookup_no_fk,:in_disc_remarks,
            :in_disc_amt_by_doc,:in_disc_amt_by_doc_no_fk,:in_disc_amt_by_hosp,
            :in_disc_amt_by_hosp_auth_by,:in_disc_amt_request_by_name,:in_au_entry_by,:in_au_entry_session,
            :in_au_entry_hospital_pk_no,:in_item_count,:in_item_level_disc_ind,:in_item_no_fk,:in_item_name,:in_itemtype_no_fk,
            :in_item_qty,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_itemurgent_fee,:in_itemservice_charge,
            :in_package_item_ind,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_ledger_no,:out_error);
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

                if (!empty($in_paymood_arr_t) && !empty($request->invoice_number)) {
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

                //      if ($out_error3 == 999) {
                //         DB::rollback();
                //         $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
                //     } else {
                // DB::commit();
                // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2,'trx_id'=> $out_ledgertrn_no];
                //     }
            }

            // DB::commit();
            // $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];

        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }
    public function POScreateOrUpdateV1($request, $id = null)
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

            // if ($in_counter_su_no_fk != 0) {
            //     $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
            //     if (isset($service_unit_check)) {
            //         if ($service_unit_check->hs_pos_ind == 1) {
            //             $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
            //             $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //         } else {
            //             if (isset($request->hdn_admission_id)) {
            //                 // if ($request->customer_type_radio == 5) {
            //                 //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
            //                 // }elseif ($request->customer_type_radio == 6) {
            //                 //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
            //                 // }elseif ($request->customer_type_radio == 7) {
            //                 //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
            //                 // }else{
            //                 //     $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
            //                 // }
            //                 $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
            //                 $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //                 // dd($module_info ,$module_id);
            //             } else {
            //                 $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
            //                 $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //             }
            //         }
            //     } else {
            //         if (isset($request->hdn_admission_id)) {
            //             $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
            //             $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //         } else {
            //             $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
            //             $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //         }
            //     }
            // } else {
            //     if (isset($request->hdn_admission_id)) {

            //         $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
            //         $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //     } else {
            //         $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
            //         $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            //     }
            // }

            if ($in_counter_su_no_fk != 0) {
                $service_unit_check = ServiceUnit::find($in_counter_su_no_fk);
                if (isset($service_unit_check)) {
                    if ($service_unit_check->hs_pos_ind == 1) {
                        $module_info = DB::table("sysc_module")->where("module_code", "HSPOS")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    } else {
                        if (isset($request->hdn_admission_id)) {
                            if ($request->customer_type_radio == 5) {
                                $module_info = DB::table("sysc_module")->where("module_code", "PHR-E")->select("module_no_pk")->first();
                            } elseif ($request->customer_type_radio == 6) {
                                $module_info = DB::table("sysc_module")->where("module_code", "PHR-D")->select("module_no_pk")->first();
                            } elseif ($request->customer_type_radio == 7) {
                                $module_info = DB::table("sysc_module")->where("module_code", "PHR-O")->select("module_no_pk")->first();
                            } else {
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

                $batch_arr[$i] = $item_batch_no[$i] != "0" ? $item_batch_no[$i] : "";
                $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

                if ($whole_sale[$i] == "") {
                    $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
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
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_phr_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,
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
            $billinvoice->execute();
            $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

            if ($out_error == 999) {
                dd($out_error . "invoice");
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
            } else {
                $out_invoice_no2 = $out_ledger_no = $out_error = "";
                $pdo1 = DB::getPdo();
                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_wp(
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
                    $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
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
                            $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
                            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                            // dd($module_info ,$module_id);
                        } else {
                            $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
                            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                        }
                    }
                } else {
                    if (isset($request->hdn_admission_id)) {
                        $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    } else {
                        $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
                        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    }
                }
            } else {
                if (isset($request->hdn_admission_id)) {

                    $module_info = DB::table("sysc_module")->where("module_code", "CAFE-I")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "CAFE")->select("module_no_pk")->first();
                    $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                }
            }




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
            for ($i = 0; $i < count($request->txt_batch); $i++) {
                $item_data = explode('_', $request->txt_batch[$i]);
                $item_arr[$i] = $item_data[0];
                $item_level_remarks[$i] = 0;
                $item_batch_no[$i] = $item_data[1];

                $batch_arr[$i] = $item_batch_no[$i] != "0" ? $item_batch_no[$i] : "";
                $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

                if ($whole_sale[$i] == "") {
                    $hdn_item_rate[$i] = $request->input('item_rate_' . $item_arr[$i])[0];
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
            $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_phr_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,
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
            $billinvoice->execute();
            $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

            if ($out_error == 999) {
                dd($out_error . "invoice");
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error'];
            } else {
                $out_invoice_no2 = $out_ledger_no = $out_error = "";
                $pdo1 = DB::getPdo();
                $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_phr_wp(
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
                    $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
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
        $in_ledgertrn_no = $outError = $out_invoice_id = $out_invoice_no = $out_ledgertrn_no = '';
        $pdo = DB::getPdo();
        $refund_amount = $request->refund;
        $refund_reason = $request->cancel_reason;
        $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_phr_sales_cancellation(:in_cancel_date,
        :in_invoice_no_pk,
        :in_refund_amount,
        :in_refund_reason,
        :in_item_no_fk,
        :in_cancel_qty,
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
            DB::commit();
            $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no];
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

    //for Ambulance billing

    public function ambulanceBillCreateOrUpdateV1($request, $id = null)
    {

        // $count_pay= $request->pay_method_mode;
        // $paymood_count = count($count_pay);

        $auth_id = Auth::id();
        DB::beginTransaction();

        try {
            $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
            $walk_in_customer_addr = $request->customer_addr ? $request->customer_addr : "";
            $walk_in_name = $request->customer_name != "" ? $request->customer_name : "Honorable customer";

            $page_type = !empty($request->page_type) ? $request->page_type : "";
            date_default_timezone_set('Asia/Dhaka');
            $time = Carbon::now();
            $cur_date = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $cur_datetime = date('Y-m-d H:i:s', strtotime($time)); //date("Y-M-d h:i:s");
            $module_id = 0;
            $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
            $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
            $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
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
            $out_ledgertrn_no = 0;
            $in_ledgertrn_no = $out_invoice_no = $out_invoice_id = $out_error = 0;
            // $item_level_disc_ind = $request->patient_itemType_dis_ind  != "" ? $request->patient_itemType_dis_ind : 0;
            $item_level_disc_ind = $request->auto_dis_ind != "" && $request->discount_percent_hospital <= 0 ? $request->auto_dis_ind : 0;
            // dd($request->auto_dis_ind ,$request->discount_percent_hospital, $item_level_disc_ind);
            // $item_disc_percent[]=0;
            // $item_disc_amount[]=0;

            if (array_sum($item_disc_amount) > 0) {
                $item_discount = 1;
            } else {
                $item_discount = "";
            }
            // dd($item_discount , array_sum($item_disc_amount));
            // $item_level_remarks[] = 0;

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
                // $sequence = DB::getSequence();
                $fixed_rate_ind = $request->rateInd == "Fixed" ? 1 : "";
                $distance_rate_ind = $request->rateInd == "Distance" ? 1 : "";
                // // $ambt_trip_no_pk = $sequence->nextValue('acc_chequeprint_no_pk_seq');
                $ambt_trip_no_pk = 1;
                $data = [
                    'ambt_trip_no_pk' => $ambt_trip_no_pk,
                    'ambt_trip_date' => "",
                    'trip_patient_type' => $request->trip_patient_type,
                    'invoice_no_fk' => $out_invoice_no,
                    'patient_no_fk' => $hdn_patient_id,
                    'patient_name' => !empty($patient_name) ? $patient_name : $walk_in_name,
                    'phone_mobile' => !empty($phone_mobile) ? $phone_mobile : $walk_in_phone,
                    // 'email' => $request->email,
                    // 'dob' => isset($request->patient_dob_hidden) ? date('Y-m-d', strtotime($request->patient_dob_hidden)): "" ,
                    // 'age_dd' => $request->pat_age_d,
                    // 'age_mm' => $request->pat_age_m,
                    // 'age_yy' => $request->pat_age_y,
                    // 'gender_txt' => $request->gender_text,
                    'address' => $walk_in_customer_addr,
                    'item_no_fk' => "",
                    'start_from_location' => $request->start_from_location,
                    'ended_to_location' => $request->ended_to_location,
                    'distince_km' => $request->distance_km,
                    'fixed_rate_ind' => $fixed_rate_ind,
                    'distance_rate_ind' => $distance_rate_ind,
                    'remarks_text' => $request->amb_remarks,
                    // 'ambulance_rate' => $request->amb_fee,
                    'total_bill' => $total_payable,
                    'invoice_code' => isset($finc_invoice_data->invoice_code) ? $finc_invoice_data->invoice_code : "",
                    'module_no_fk' => isset($finc_invoice_data->module_no_fk) ? $finc_invoice_data->module_no_fk : "",
                    'cancel_ind' => isset($finc_invoice_data->invoice_cancel_ind) ? $finc_invoice_data->invoice_cancel_ind : "",
                    'CANCEL_REASON' => isset($finc_invoice_data->invoice_cancel_ind) ? $finc_invoice_data->invoice_cancel_ind : "",
                    'status' => 1,
                    'au_entry_by' => $auth_id,
                    'au_entry_at' =>  date('y-m-d h:i:s'),
                    'au_entry_hospital_pk_no' => session::get('user.ses_hospital_no_pk')
                ];

                DB::table('AMBT_AMBULANCETRIP')->insert($data);
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
}
