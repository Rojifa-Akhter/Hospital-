<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\DeliveryService;
use App\Models\GrantUserService;
use App\Traits\MailEngine;
//use App\Library\Template;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
use PDO;

class DeliveryManDashboardController extends Controller
{
    use MailEngine;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getDashboard()
    {
        $user_id = Auth::user()->person_no_fk;
        $delivery_man = DB::table('ecom_order_list_vw')->where('delivery_men_no_fk', $user_id)
            ->selectRaw("count(case when delivery_status = 0 then 1 end) as assigned_orders")
            ->selectRaw("count(case when delivery_status = 1 then 1 end) as pending_orders")
            ->selectRaw("count(case when delivery_status = 2 then 1 end) as delivered_orders")
            ->selectRaw("count(case when delivery_status = 3 then 1 end) as cancelled_orders")
            ->first();
        return view('deliveryMan.dashboard.main', compact('delivery_man'));
    }
    public function getDeliveryManOrderList()
    {
        $service_point = GrantUserService::where('pharmacy_ind', '1')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'default_ind')
            ->orderBy('serviceunit_name', 'asc')->get();
        $user_id = Auth::user()->person_no_fk;
        $order_list = DB::table('ecom_order_list_vw')->where([
            ['delivery_men_no_fk', $user_id],
            ['delivery_status', 0]
        ])->get();
        return view('deliveryMan.dashboard.order_list', compact('order_list', 'service_point'));
    }
    public function pickDelivery(Request $request)
    {

        DB::table('ecom_delivery_service')->where('delivery_service_no_pk',  $request->ecom_service_id)->update(array('status' => 1));
        return redirect()->back();
    }
    public function getPickedOrderList()
    {
        $user_id = Auth::user()->person_no_fk;
        $order_list = DB::table('ecom_order_list_vw')->where([
            ['delivery_men_no_fk', $user_id],
            ['delivery_status', 1]
        ])->get();
        return view('deliveryMan.dashboard.picked_order_list', compact('order_list'));
    }
    public function completeDelivery(Request $request)
    {
        // $id = $request->id;
        // $delivery_service_record = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->first();
        // $order_id = $delivery_service_record->order_no_fk;
        // $auth_id = Auth::id();
        // DB::beginTransaction();
        // // dd($request->walk_in_phone);

        // try {
        //     $walk_in_phone = $request->walk_in_phone ? $request->walk_in_phone : "";
        //     $walk_in_name = "Honorable customer";

        //     $cur_date = date("Y-M-d");
        //     $cur_datetime = date("Y-M-d h:i:s");
        //     $module_id = 0;
        //     $patient_type = !empty($request->patient_type) ? $request->patient_type : '';
        //     $hdn_patient_id = !empty($request->hdn_patient_id) ? $request->hdn_patient_id : '';
        //     $hdn_patient_code = !empty($request->patient_id) ? $request->patient_id : '';
        //     $admission_id = !empty($request->hdn_admission_id) ? $request->hdn_admission_id : '';  //appointment_id
        //     $service_appointment_id = !empty($request->service_appointment_id) ? $request->service_appointment_id : '';
        //     $prescription_id = !empty($request->hdn_prescription_id) ? $request->hdn_prescription_id : '';
        //     $hdn_doctor_id = !empty($request->hdn_doctor_id) ? $request->hdn_doctor_id : '';
        //     $dis_requ_by = !empty($request->dis_requ_by) ? ucwords($request->dis_requ_by) : '';

        //     $hdn_dis_doctor_id = !empty($request->hdn_dis_doctor_id) ? $request->hdn_dis_doctor_id : '';
        //     $hdn_first_referral_id = !empty($request->hdn_first_refer) ? $request->hdn_first_refer : '';
        //     $hdn_second_referral_id = !empty($request->hdn_second_refer) ? $request->hdn_second_refer : '';

        //     $hdn_item_id = $request->hdn_item_id;


        //     $txt_batch = $request->txt_batch;
        //     $txt_expire_date = $request->txt_expire_date;



        //     // $hdn_item_qnty = $request->hdn_item_qnty;

        //     $item_delivery_status = !empty($request->delivery_date) ? $request->item_delivery_status : '';

        //     $hdn_item_deli_date = !empty($request->delivery_date) ? $request->delivery_date : '';
        //     $hdn_item_total_qnty = !empty($request->hdn_item_total_qnty) ? $request->hdn_item_total_qnty : '';

        //     $cmb_discount = $request->cmb_discount; //!empty($request->cmb_discount$request->cmb_discount) ? $request->cmb_discount : '';
        //     $disc_percent_hospital = !empty($request->discount_percent_hospital) ? $request->discount_percent_hospital : '';
        //     $disc_percent_doctor = !empty($request->discount_percent_doctor) ? $request->discount_percent_doctor : '';
        //     $disc_amount_hospital = !empty($request->discount_amount_hospital) ? $request->discount_amount_hospital : '';
        //     $disc_amount_doctor = !empty($request->discount_amount_doctor) ? $request->discount_amount_doctor : '';
        //     $remarks = !empty($request->remarks) ? $request->remarks : " ";
        //     $pay_mode = $request->pay_mode;
        //     $pay_amount = $request->pay_amount;
        //     $given_amount = $request->given_amount;
        //     $change_amount = $request->change_amount;
        //     $item_vat = $request->item_vat;
        //     $urgent_fee = $request->uregent_fee;
        //     $total_urgent_fee = $request->total_urgent_fee;
        //     $s_charge = $request->s_charge;
        //     $total_payment = $request->total_payment;
        //     $entry_session = "session";

        //     $item_total = $request->item_total;
        //     $total_payable = $request->total_payable;
        //     $adj_dis = $request->dis_adj_amt;
        //     $total_discount_amount = $request->total_discount_amount + $adj_dis;
        //     // dd($adj_dis , $request->total_discount_amount , $total_discount_amount );
        //     $discount_remarks = $request->discount_remarks;
        //     //$given_amount ="120";
        //     $bank_name = $request->bank_name;
        //     $bank_name_card = $request->bank_name_card;
        //     $card_no = $request->card_no;
        //     $bkash_txn_id = $request->bkash_txn_id;
        //     $holder_name = $request->holder_name;
        //     $check_no = $request->check_no;
        //     $in_counter_su_no_fk = ($request->service_point != "") ? $request->service_point : 0;

        //     // dd($txt_expire_date , $hdn_item_rate ,$txt_batch  );
        //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //     $hospital_id = $ses_hospital_id;
        //     $null = '';

        //     $out_sl_no = '';
        //     $empty_arr = [];
        //     $numelems = 200;
        //     $zero = 0;

        //     if (empty($check_no)) {
        //         $check_no = $card_no;
        //     }

        //     if (empty($check_no) & empty($card_no)) {
        //         $check_no = $bkash_txn_id;
        //     }
        //     if (empty($bank_name)) {
        //         $bank_name = $bank_name_card;
        //     }



        //     $module_info = DB::table("sysc_module")->where("module_code", "PHR")->select("module_no_pk")->first();
        //     $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";

        //     $i = 0;
        //     $item_arr = [];
        //     $batch_arr = [];
        //     $expire_arr = [];
        //     $quantity_arr = [];
        //     $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr  = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
        //     $hdn_item_rate = [];
        //     $hdn_item_qnty = [];
        //     $whole_sale = [];
        //     $item_dis_amt = [];
        //     $item_dis_pers = [];
        //     $item_level_remarks = [];

        //     for ($i = 0; $i < count($request->txt_batch); $i++) {
        //         $item_data = explode('_', $request->txt_batch[$i]);
        //         $item_arr[$i] =  $item_data[0];
        //         $item_level_remarks[$i] = 0;
        //         $item_batch_no[$i] =  $item_data[1];

        //         $batch_arr[$i] = $item_batch_no[$i] != "0" ?  $item_batch_no[$i] : "";
        //         $whole_sale[$i] = $request->input('wholesale_' . $item_arr[$i]) ? $request->input('wholesale_' . $item_arr[$i]) : "";

        //         if ($whole_sale[$i] == "") {
        //             $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr[$i])->first()->sales_price;
        //         } else {

        //             $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('dealer_sales_price')->where('item_no_pk', $item_arr[$i])->first()->dealer_sales_price;
        //         }
        //         // dd($hdn_item_rate[$i]);
        //         $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
        //         $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

        //         $exp = explode('_', $request->txt_expire_date[$i]);
        //         // $str_date[$i]=$exp[1] ;
        //         $expire_arr[$i] = $exp[1] != 0 ?  str_replace('-', '', $exp[1]) : "";

        //         $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
        //         $hdn_item_qnty[$i] = $checker[0];
        //         $qty_exp = explode('_', $request->batch_qty[$i]);
        //         $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0];
        //         $deli_dt_arr[$i] = (!empty($hdn_item_deli_date[$i]) ? date("d-m-Y", strtotime($hdn_item_deli_date[$i])) : "01-01-1970");
        //         $item_delivery_status_arr[$i] = (isset($item_delivery_status[$i]) ? $item_delivery_status[$i] : 0);
        //         $package_ind_arr[$i] = 0;
        //         $item_mu_arr[$i] = 0;
        //         $hdn_item_urgent_fee_amt[$i] = (isset($urgent_fee[$i]) ? $urgent_fee[$i] : 0);
        //         if ($request->item_dis_radio == 1) {
        //             $item_dis_pers[$i] = $request->item_dis[$i];
        //             $item_dis_amt[$i] = $item_dis_pers[$i] != '' ? (($quantity_arr[$i] *  $hdn_item_rate[$i]) *  $item_dis_pers[$i]) / 100 :  0;
        //         } elseif ($request->item_dis_radio == 2) {
        //             $item_dis_amt[$i] = $request->item_dis[$i];
        //             $item_dis_pers[$i] = $item_dis_amt[$i] != '' ? ($item_dis_amt[$i] / ($quantity_arr[$i] *  $hdn_item_rate[$i])) * 100 :  0;
        //         } else {
        //             $item_dis_amt[$i] = 0;
        //             $item_dis_pers[$i] = 0;
        //         }
        //     }


        //     // dd($item_arr,   $batch_arr, $expire_arr, $quantity_arr, $deli_dt_arr, $item_delivery_status_arr, $package_ind_arr, $item_mu_arr, $hdn_item_rate);
        //     // OUT PAREMETER INITIALIZE
        //     $total_item = count($item_arr);
        //     $invoice_date = "";

        //     // dd($total_item);
        //     $out_invoice_no = $out_invoice_id = $out_error = "";
        //     $item_level_disc_ind = $request->item_dis_ind != '' ? $request->item_dis_ind : 0;

        //     $pdo = DB::getPdo();
        //     $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_phr_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");

        //     $billinvoice->bindParam(':in_invoice_date', $cur_date);
        //     $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
        //     $billinvoice->bindParam(':in_module_no_fk', $module_id);
        //     $billinvoice->bindParam(':in_patient_no_fk', $hdn_patient_id);
        //     $billinvoice->bindParam(':in_patient_code', $hdn_patient_code);
        //     $billinvoice->bindParam(':in_admission_no_pk', $admission_id);
        //     $billinvoice->bindParam(':in_admission_code', $null);
        //     $billinvoice->bindParam(':in_appointment_no_fk', $service_appointment_id);
        //     $billinvoice->bindParam(':in_prescription_no_fk', $prescription_id);
        //     $billinvoice->bindParam(':in_doc_person_no_fk', $hdn_doctor_id);
        //     $billinvoice->bindParam(':in_first_ref_doc', $hdn_first_referral_id);
        //     $billinvoice->bindParam(':in_second_ref_doc', $hdn_second_referral_id);
        //     $billinvoice->bindParam(':in_report_delivary_date', $invoice_date);
        //     $billinvoice->bindParam(':in_report_deli_datetime', $invoice_date);
        //     $billinvoice->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        //     $billinvoice->bindParam(':in_cor_client_no_fk', $null);
        //     $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
        //     $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
        //     $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
        //     $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $patient_type);
        //     $billinvoice->bindParam(':in_dob', $invoice_date);
        //     $billinvoice->bindParam(':in_age', $null);
        //     $billinvoice->bindParam(':in_age_dd', $null);
        //     $billinvoice->bindParam(':in_age_mm', $null);
        //     $billinvoice->bindParam(':in_age_yy', $null);
        //     $billinvoice->bindParam(':in_customer_addr', $walk_in_phone);
        //     $billinvoice->bindParam(':in_customer_name', $walk_in_name);

        //     $billinvoice->bindParam(':in_gender_txt', $null);
        //     $billinvoice->bindParam(':in_marital_status_txt', $null);
        //     $billinvoice->bindParam(':in_blood_group', $null);
        //     $billinvoice->bindParam(':in_phone_mobile', $null);

        //     $billinvoice->bindParam(':in_invoice_remarks', $remarks);
        //     $billinvoice->bindParam(':in_urgent_fee_total', $total_urgent_fee);
        //     $billinvoice->bindParam(':in_invoice_type', $null);
        //     $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        //     $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        //     $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        //     $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        //     $billinvoice->bindParam(':in_item_level_disc_ind', $item_level_disc_ind);
        //     $billinvoice->bindParam(':in_item_count', $total_item);
        //     $billinvoice->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        //     $billinvoice->bindArray(':in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
        //     $billinvoice->bindArray(':in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);

        //     $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
        //     $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
        //     $billinvoice->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
        //     $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
        //     $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
        //     $billinvoice->bindArray(':in_item_disc_percent', $item_dis_pers, count($item_dis_pers), $numelems, SQLT_FLT);
        //     $billinvoice->bindArray(':in_item_disc_amount', $item_dis_amt, count($item_dis_amt), $numelems, SQLT_FLT);
        //     $billinvoice->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        //     $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        //     $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

        //     $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        //     $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
        //     $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
        //     $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
        //     $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);



        //     $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        //     $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        //     $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        //     $billinvoice->execute();

        //     $pat_id = DB::table("finc_ledgermst")->select("patient_no_fk")->where("invoice_no_fk", $out_invoice_no)->first()->patient_no_fk;

        //     if ($out_error == 999) {
        //         dd($out_error . "invoice");
        //         DB::rollback();
        //         $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error',];
        //     } else {

        //         $out_invoice_no2 = $out_ledger_no = $out_error = "";
        //         $pdo1 = DB::getPdo();
        //         $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_phr_wp(
        //              :in_payment_date,
        //              :in_payment_datetime,
        //              :in_invoice_no_fk,
        //              :in_module_no_fk,
        //              :in_patient_no_fk,
        //              :in_admission_no_fk,
        //              :in_prescription_no_fk,
        //              :in_counter_su_no_fk,
        //              :in_ledger_amt_sales,
        //              :in_ledger_amt_payment,
        //              :in_ledger_amt_discount,
        //              :in_urgent_fee,
        //              :in_service_charge,
        //              :in_cor_client_no_fk,
        //              :in_pay_mode,
        //              :in_pay_cqcc_holder_name,
        //              :in_pay_cqcc_number,
        //              :in_pay_cqcc_deduct_percent,
        //              :in_pay_bank_name,
        //              :in_pay_remarks,
        //              :in_given_amt,
        //              :in_disc_type_lookup_no_fk,
        //              :in_disc_remarks,
        //              :in_disc_amt_by_doc,
        //              :in_disc_amt_by_doc_no_fk,
        //              :in_disc_amt_by_hosp,
        //              :in_disc_amt_by_hosp_auth_by,
        //              :in_disc_amt_request_by_name,
        //              :in_au_entry_by,
        //              :in_au_entry_session,
        //              :in_au_entry_hospital_pk_no,
        //              :in_item_count,
        //              :in_item_no_fk,
        //              :in_item_name,
        //              :in_itemtype_no_fk,
        //              :in_item_qty,
        //              :in_item_rate,
        //              :in_item_vat,
        //              :in_itemurgent_fee,
        //              :in_itemservice_charge,
        //              :in_package_item_ind,
        //              :out_invoice_no,
        //              :out_invoice_id,
        //              :out_ledger_no,
        //              :out_error);
        //              end;");

        //         // :in_paymood,
        //         // :in_pay_mood_type,
        //         // :in_bank_name,
        //         // :in_transaction_id,
        //         // :in_bank_card_no,
        //         // :in_acc_holder_name,
        //         // :in_payment_amt,
        //         // :in_paymood_count,

        //         $billpayment->bindParam(':in_payment_date', $cur_date);
        //         $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
        //         $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
        //         $billpayment->bindParam(':in_module_no_fk', $module_id);
        //         $billpayment->bindParam(':in_patient_no_fk', $pat_id);
        //         $billpayment->bindParam(':in_admission_no_fk', $admission_id);
        //         $billpayment->bindParam(':in_prescription_no_fk', $prescription_id);
        //         $billpayment->bindParam(':in_counter_su_no_fk', $in_counter_su_no_fk);
        //         $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
        //         $billpayment->bindParam(':in_ledger_amt_payment', $total_payment);
        //         $billpayment->bindParam(':in_ledger_amt_discount', $total_discount_amount);
        //         $billpayment->bindParam(':in_urgent_fee', $total_urgent_fee);
        //         $billpayment->bindParam(':in_service_charge', $s_charge);
        //         $billpayment->bindParam(':in_cor_client_no_fk', $zero);
        //         $billpayment->bindParam(':in_pay_mode', $pay_mode);
        //         $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
        //         $billpayment->bindParam(':in_pay_cqcc_number', $null);
        //         $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
        //         $billpayment->bindParam(':in_pay_bank_name', $null);
        //         $billpayment->bindParam(':in_pay_remarks', $discount_remarks);
        //         $billpayment->bindParam(':in_given_amt', $given_amount);

        //         // DISCOUNT COLUMN PREPARATION START
        //         $discount_info = LookupItem::where('lookupdata_code', $cmb_discount)->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_name', 'lookupdata_desc')->first();
        //         //dd($discount_info->lookupdata_no_pk);

        //         $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;
        //         $hospital_disc_amt = $total_discount_amount; //$disc_amount_hospital;
        //         // if (!empty($discount_info)) {
        //         //    if ($discount_info->lookupdata_code == "DOCTOR") {
        //         //       $doctor_disc_amt = $disc_amount_doctor;
        //         //       $doctor_id_for_disc = $hdn_dis_doctor_id;
        //         //    }

        //         //    if ($discount_info->lookupdata_code = "GENERAL") {
        //         //       $hospital_disc_amt = $disc_amount_hospital;
        //         //    }

        //         //    if ($discount_info->lookupdata_code = "BOTH") {
        //         //       $doctor_disc_amt = $disc_amount_doctor;
        //         //       $doctor_id_for_disc = $hdn_dis_doctor_id;
        //         //       $hospital_disc_amt = $disc_amount_hospital;
        //         //    }
        //         // }
        //         //dd($in_paymood_arr);
        //         // DISCOUNT COLUMN PREPARATION END
        //         $lookupdata_no_pk = !empty($discount_info) ? $discount_info->lookupdata_no_pk : 0;
        //         $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
        //         $billpayment->bindParam(':in_disc_remarks', $discount_remarks);
        //         $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_disc_amt);
        //         $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
        //         $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_disc_amt);
        //         $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $auth_id); // will be adjust later
        //         $billpayment->bindParam(':in_disc_amt_request_by_name', $dis_requ_by);

        //         $billpayment->bindParam(':in_au_entry_by', $auth_id);
        //         $billpayment->bindParam(':in_au_entry_session', $entry_session);
        //         $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        //         $billpayment->bindParam(':in_item_count', $total_item);
        //         $billpayment->bindArray(':in_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
        //         $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
        //         $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
        //         $billpayment->bindArray(':in_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
        //         $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
        //         $billpayment->bindArray(':in_item_vat', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        //         $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
        //         $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
        //         $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

        //         $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
        //         $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        //         $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
        //         $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        //         //   dd($billpayment);
        //         $billpayment->execute();

        //         if ($out_error == 999) {
        //             dd($out_error, $out_invoice_no2, $out_invoice_no, $total_item, $item_arr);
        //             DB::rollback();
        //             $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
        //         } else {


        //             $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
        //             // dd($paymood_count);
        //             $query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();


        //             $auth_id = Auth::id();

        //             $date = date('Y-m-d');
        //             $in_paymood_arr_t = $request->pay_method_mode;
        //             $in_pay_mood_type_arr_t = $request->mBank_types;
        //             $in_bank_name_arr_t = $request->pay_bank_name;
        //             $in_transaction_id_arr_t = $request->trans_id_no;
        //             $in_bank_card_no_arr_t = $request->card_number;
        //             $in_acc_holder_name_arr_t = $request->acc_holder_name;
        //             $in_payment_amt_arr_t = $request->total_amt;
        //             $in_paymood_count = $paymood_count;
        //             $in_au_entry_by = $auth_id;
        //             $in_au_entry_session = "session";
        //             $in_au_entry_hospital_pk_no = 1;
        //             $invoice_no = (isset($query->invoice_no_fk) ? $query->invoice_no_fk : "");
        //             $ledger_no = (isset($query->ledger_no_pk) ? $query->ledger_no_pk : "");


        //             $i = 0;
        //             if (!empty($in_paymood_arr_t)) {
        //                 foreach ($in_paymood_arr_t as $key => $value) {

        //                     $sc_date = date("d-m-Y");


        //                     $in_paymood_arr_val[$i] = (!empty($value) ? $value : "");
        //                     $in_pay_mood_type_arr_val[$i] = (!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "");
        //                     $in_bank_name_arr_val[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "");
        //                     $in_transaction_id_arr_val[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "");
        //                     $in_bank_card_no_arr_val[$i] = (!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "");
        //                     $in_acc_holder_name_arr_val[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "");
        //                     $in_payment_amt_arr_val[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "");

        //                     $i++;
        //                 }
        //             }
        //             $in_paymood_arr = (!empty($in_paymood_arr_t) ? count($in_paymood_arr_t) : 1);
        //             $in_pay_mood_type_arr = (!empty($in_pay_mood_type_arr_t) ? count($in_pay_mood_type_arr_t) : 1);
        //             $in_bank_name_arr = (!empty($in_bank_name_arr_t) ? count($in_bank_name_arr_t) : 1);
        //             $in_transaction_id_arr = (!empty($in_transaction_id_arr_t) ? count($in_transaction_id_arr_t) : 1);
        //             $in_bank_card_no_arr = (!empty($in_bank_card_no_arr_t) ? count($in_bank_card_no_arr_t) : 1);
        //             $in_acc_holder_name_arr = (!empty($in_acc_holder_name_arr_t) ? count($in_acc_holder_name_arr_t) : 1);
        //             $in_payment_amt_arr = (!empty($in_payment_amt_arr_t) ? count($in_payment_amt_arr_t) : 1);

        //             // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

        //             $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
        //             $pdo2 = DB::getPdo();
        //             $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
        //                 :in_payment_date,
        //                 :in_invoice_no_fk,
        //                 :in_ledger_no_fk,
        //                 :in_paymood,
        //                 :in_pay_mood_type,
        //                 :in_bank_name,
        //                 :in_transaction_id,
        //                 :in_bank_card_no,
        //                 :in_acc_holder_name,
        //                 :in_payment_amt,
        //                 :in_paymood_count,
        //                 :in_au_entry_by ,
        //                 :in_au_entry_session ,
        //                 :in_au_entry_hospital_pk_no ,
        //                 :out_error);
        //                 end;");

        //             $finc_ledger_paymood->bindParam(':in_payment_date', $date);
        //             $finc_ledger_paymood->bindParam(':in_invoice_no_fk', $invoice_no);
        //             $finc_ledger_paymood->bindParam(':in_ledger_no_fk', $ledger_no);
        //             $finc_ledger_paymood->bindArray(':in_paymood', $in_paymood_arr_val, $in_paymood_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_pay_mood_type', $in_pay_mood_type_arr_val, $in_pay_mood_type_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_bank_name', $in_bank_name_arr_val, $in_bank_name_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_transaction_id', $in_transaction_id_arr_val, $in_transaction_id_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_bank_card_no', $in_bank_card_no_arr_val, $in_bank_card_no_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_acc_holder_name', $in_acc_holder_name_arr_val, $in_acc_holder_name_arr, $numelems, SQLT_CHR);
        //             $finc_ledger_paymood->bindArray(':in_payment_amt', $in_payment_amt_arr_val, $in_payment_amt_arr, $numelems, SQLT_FLT);
        //             $finc_ledger_paymood->bindParam(':in_paymood_count', $in_paymood_count);
        //             $finc_ledger_paymood->bindParam(':in_au_entry_by', $in_au_entry_by);
        //             $finc_ledger_paymood->bindParam(':in_au_entry_session', $in_au_entry_session);
        //             $finc_ledger_paymood->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
        //             $finc_ledger_paymood->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        //             $finc_ledger_paymood->execute();

        //             if ($out_error == 999) {
        //                 DB::rollback();
        //                 $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
        //             } else {
        //                 DB::commit();
        //                 $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
        //             }
        //         }
        //         /*  dd($in_paymood_arr_val,$in_pay_mood_type_arr_val);*/



        //         //DB::commit();
        //         //$message = ['msg' => 'New Bill created successfully.Invoice ID = '. $out_invoice_no, 'title' => 'Success'];

        //     }
        // } catch (\Exception $e) {
        //     DB::rollback();

        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        // return response()->json($message);

        //Complete Delivery
        $id = $request->id;
        $delivery_service_record = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->first();
        $database_otp = $delivery_service_record->order_otp_text;
        $customer_otp = $request->otp;
        if ($database_otp == $customer_otp) {
            $delivery_service = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->update(array('status' => 2, 'delivered_date' => date('Y-m-d')));
            $data = [
                'success' => true,
                'message' => 'Your AJAX processed correctly'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'success' => false,
                'message' => 'Your AJAX processed correctly'
            ];
            return response()->json($data, 400);
        }
    }
    public function cancelDelivery(Request $request)
    {
        $id = $request->id;
        $delivery_service = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->first();
        if ($delivery_service) {
            $delivery_service = DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->update(array('status' => 3, 'canceled_date' => date('Y-m-d')));
            $data = [
                'success' => true,
                'message' => 'Your AJAX processed correctly'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'success' => false,
                'message' => 'Your AJAX processed correctly'
            ];
            return response()->json($data, 400);
        }
    }

    public function getDeliveredOrderList(Request $request)
    {
        $user_id = Auth::user()->person_no_fk;
        $order_list = DB::table('ecom_order_list_vw')->where([
            ['delivery_men_no_fk', $user_id],
            ['delivery_status', 2]
        ])->get();

        return view('deliveryMan.dashboard.delivered_order_list', compact('order_list'));
    }
    public function getCancelledOrderList()
    {
        $user_id = Auth::user()->person_no_fk;
        $order_list = DB::table('ecom_order_list_vw')->where([
            ['delivery_men_no_fk', $user_id],
            ['delivery_status', 3]
        ])->get();
        return view('deliveryMan.dashboard.cancelled_order_list', compact('order_list'));
    }
    public function sendOtp($id)
    {
        $customer_phone = DB::table('ecom_order_list_vw')->where('ecom_delivery_no', $id)->first()->phone_mobile;
        $otp = rand(1000, 9999);
        $message_body = "Your delivery order verification code is: $otp. Don't share your verification code.";
        //$this->sendCustomSms($customer_phone, $message_body);
        DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->update(array('order_otp_text' => $otp));
        return $otp;
    }
    public function getDeliveryItemInfo($id)
    {
        $item_details = DB::table('ecom_order_items')
            ->where('order_no_fk', $id)
            ->select('product_name', 'quantity', 'product_price')
            ->get();
        //return response()->json(['item_details' => $item_details], 200);
        return view('deliveryMan.dashboard.order_item_list', ["item_details" => $item_details]);
    }
    public function getDeliveryItemWithBatch($id, $service_point)
    {
        //dd($id, $service_point);
        $auth_id = Auth::id();
        $delivery_service = 1;


        $su_unit_no = $service_point;
        $numelems = 200;
        $outParam = '';
        //$service =  DB::table('ecom_delivery_service')->where('delivery_service_no_pk', $id)->first();
        //$orderId =  $service->order_no_fk;
        $item_details = DB::table('ecom_order_items')->where('order_no_fk', $id)->get();
        $date = date('Y-m-d');
        $update_info = [];
        $pdo = DB::getPdo();
        if (!empty($item_details)) {
            foreach ($item_details as $items) {
                $item_id = $items->product_no_fk;
                $qty =  $items->quantity;
                $entry_session = "Session";
                $hospital_id = 141;
                $itemExpiry = $pdo->prepare("begin pkg_ManageStock.prc_getstockexpiry(:in_stock_su_no_fk,:in_item_no_fk,:in_sales_qty,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_stockexpiry); end;");
                $itemExpiry->bindParam(':in_stock_su_no_fk',  $su_unit_no); // will be adjust later
                $itemExpiry->bindParam(':in_item_no_fk', $item_id);
                $itemExpiry->bindParam(':in_sales_qty', $qty);
                $itemExpiry->bindParam(':in_au_entry_by', $auth_id);
                $itemExpiry->bindParam(':in_au_entry_session', $entry_session);
                $itemExpiry->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $itemExpiry->bindParam(':out_stockexpiry', $outParam, PDO::PARAM_STR, 500);
                $itemExpiry->execute();
                $exp = explode('^', $outParam);
                // $exp=explode("|",$res);

                $update_info = ['expiry_date' => date("Y-m-d", strtotime($exp[1])), 'batch_no' => $exp[0]];
                DB::table('ecom_order_items')->where('order_no_fk', $id)->where('product_no_fk', $item_id)->update($update_info);

                if ($outParam != '') {
                    DB::commit();
                    $message = $exp;
                    // DB::table('ecom_order_items')->where('order_no_fk', $id)->update(array(['status' => 1, 'expiry_date' => date('Y-m-d'), 'batch_no' => 1]));
                } else {
                }
            }
        }

        $item_details = DB::table('ecom_order_items')
            ->where('order_no_fk', $id)
            ->get();
        //dd($item_details);
        //return response()->json(['item_details' => $item_details], 200);
        return view('deliveryMan.dashboard.order_item_list_with_batch', ["item_details" => $item_details]);
    }
    public function getResetPasswordForm()
    {

        return view('deliveryMan.dashboard.reset_password');
    }

    public function getResetPassword(Request $request)
    {

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|min:6',
            'confirm-password' => 'required'
        ]);
        if (!(Hash::check($request->get('current-password'), Auth::user()->user_pass))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        //Change Password
        $user = Auth::user();
        $user->user_pass = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }
}
