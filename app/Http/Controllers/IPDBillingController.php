<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\GrantUserService;
use Illuminate\Http\Request;
use App\Traits\LookupData;
use PDO;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;


class IPDBillingController extends Controller
{
    //
    use LookupData;

    public function ipdServiceBilling(Request $request)
    {
        // dd($request->all());
        $hdn_item_id = [];
        $batch_no_arr = [];
        $expire_dt_arr = [];
       
        $out_patient_no_pk = $request->hdn_patient_no_fk;

        $hdn_item_name = [];
        $hdn_item_type = [];
        $hdn_item_rate = [];
        $item_total = 0;
        $hdn_item_qnty = [];
        $item_mu_arr = $in_package_item_ind = $package_ind_arr = [];
        $item_level_remarks = $deli_dt_arr = $deli_dt_arr=$null_arr  = [
            0 => '',
        ];
        $item_delivery_status_arr = $item_disc_percent =  $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
            0 => 0,
        ];

       
        // dd($request->all());
        $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->first();
        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        if (!empty($request->item_arr)) {
           
            for ($i = 0; $i < count($request->item_arr); $i++) {


                $hdn_item_id[$i] = $request->input("item_no_" .  $request->item_arr[$i]);
                $batch_no_arr[$i] = "";
                $expire_dt_arr[$i] = "";
                $hdn_item_name[$i] = $request->input("item_name_" .  $request->item_arr[$i]);
                $hdn_item_type[$i] = $request->input("item_type_" .  $request->item_arr[$i]);
                $hdn_item_rate[$i] =  $request->input("sales_price_" .  $request->item_arr[$i]);
                $item_total += $request->input("sales_price_" .  $request->item_arr[$i]);
                $hdn_item_qnty[$i] = 1;
                $item_mu_arr[$i] = $in_package_item_ind[$i] = $package_ind_arr[$i] = 0;
                $item_level_remarks[$i] = $deli_dt_arr[$i] = $deli_dt_arr[$i]  = '';
                
                $item_delivery_status_arr[$i] = $item_disc_percent[$i] =  $item_disc_amount[$i] = $item_vat_prse[$i] = $hdn_item_urgent_fee_amt[$i] =$null_arr[$i]= 0;
            }
            $auto_item = DB::table('sysc_serviceitem_auto_vw')->wherein('item_no_fk', $hdn_item_id)->get();
        }else{
            $message = ['msg' => 'please select item' , 'title' => 'Success'];
            return response()->json($message);
        }
        // dd($hdn_item_name, $hdn_item_rate);
        if (!empty($auto_item)) {
            foreach ($auto_item as $item) {

                $hdn_item_id[$i] =  $item->auto_item_no_fk;
                $batch_no_arr[$i] = "";
                $expire_dt_arr[$i] = "";


                $hdn_item_name[$i] =  $item->item_name;
                $hdn_item_type[$i] = $item->itemtype_no_fk;
                $hdn_item_rate[$i] = $item->sales_price;
                $item_total += $item->sales_price;
                $hdn_item_qnty[$i] = 1;
                $item_mu_arr[$i] = $in_package_item_ind[$i] = $package_ind_arr[$i] = 0;
                $item_level_remarks[$i] = $deli_dt_arr[$i] = $deli_dt_arr[$i]  = '';
                $item_delivery_status_arr[$i] = $item_disc_percent[$i] =  $item_disc_amount[$i] = $item_vat_prse[$i] = $hdn_item_urgent_fee_amt[$i] = 0;
                $null_arr[$i]=null;
                $i++;
            }
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $out_invoice_no2 = $out_ledger_no = $out_invoice_no = $out_invoice_id = $out_error = "";
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind ,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:in_provider_no_fk,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");
        //Preparating Data
        $cur_date = date("Y-M-d H:i:s");
        $cur_datetime = date("Y-M-d h:i:s");

        $null = '';
        $zero = 0;
        $module_info = DB::table("sysc_module")->where("module_code", "IPD")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
        $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        $auth_id = Auth::id();
        $entry_session = "Session";
        $hdn_doctor_id = $request->doctor_id;
        $admission_id = $request->hdn_admission_no_pk;
        $billinvoice->bindParam(':in_invoice_date', $cur_date);
        $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
        $billinvoice->bindParam(':in_module_no_fk', $module_id);
        $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
        $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
        $billinvoice->bindParam(':in_admission_no_pk', $admission_id);
        $billinvoice->bindParam(':in_admission_code', $null);
        $billinvoice->bindParam(':in_appointment_no_fk', $zero);
        $billinvoice->bindParam(':in_prescription_no_fk', $zero);
        $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
        $billinvoice->bindParam(':in_first_ref_doc', $zero);
        $billinvoice->bindParam(':in_second_ref_doc', $zero);
        $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
        $billinvoice->bindParam(':in_report_deli_datetime', $cur_date);
        $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
        $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
        $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
        $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
        $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
        $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $zero);
        $billinvoice->bindParam(':in_dob', $cur_date);
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

        $billinvoice->bindParam(':in_invoice_remarks', $null);
        $billinvoice->bindParam(':in_urgent_fee_total', $null);
        $billinvoice->bindParam(':in_invoice_type', $null);
        $billinvoice->bindParam(':in_emergency_ind', $null);
        $billinvoice->bindParam(':in_daycare_ind', $null);
        $billinvoice->bindParam(':in_ot_ind', $null);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $numelems = 5000;
        $total_item = count($hdn_item_id);
        $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
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
        $in_ledgertrn_no = $out_ledgertrn_no = "";
        $billinvoice->bindArray(':in_provider_no_fk', $null_arr, count($null_arr), $numelems, SQLT_INT);
        $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);

        $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
        $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);


        $billinvoice->execute();
        $out_invoice_no1  = $out_invoice_no;

        if ($out_error == 999) {

          
            // dd($out_error);
            DB::rollback();
            $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error',];
        } else {
            if (!empty($request->item_arr)) {
                $data=[
                    'bill_ind'=>1,
                ];
               DB::table('psn_t_prescription_dtl')->whereIn('prescription_dtl_no_pk',$request->item_arr)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no];
        }
        return response()->json($message);
    }
    public function billingCancelation()
    {
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("pharmacy_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();

        return Template::loadview("admin.ipd.billing.billing_cancelation", ['service_point' => $service_point]);
    }
    public function get_billing_cancel_invoice_list(Request $request)
    {
        $hdn_admission_id = $request->hdn_admission_id;
        $patient_info = DB::table("finc_invoicemst_sum_vw")->where("admission_no_pk", $hdn_admission_id)
            ->select("invoice_no_pk", "patient_name", "age", "gender_txt", "blood_group", "present_addr", "urgent_fee", "ledger_amt_discount", "ledger_amt_payment", "ledger_amt_sales", "patient_no_pk", "admission_no_pk", "marital_status_txt", "blood_group_txt")->first();
        $total_sale = DB::select("SELECT SUM(ledger_amt_sales) ledger_amt_sales, SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
        WHERE admission_no_pk=$hdn_admission_id");
        foreach ($total_sale as $value) {
            $total_sales = $value;
        }
        $total_item_rates = DB::table('finc_vouchermst_sum_vw')->where('admission_no_pk', $hdn_admission_id)->first();


        // $total_item_rate = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment, SUM(ledger_amt_sales_can) ledger_amt_sales_can  FROM finc_invoicemst_sum_vw
        // WHERE invoice_no_pk = $voucher_no");
        // foreach ($total_item_rate as $value) {

        //     $total_item_rates =$value->ledger_amt_payment + $value->ledger_amt_sales_can;

        // }

        $c_dis = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where admission_no_pk = $hdn_admission_id and cancel_ind is null");
        foreach ($c_dis as $value) {
            $c_discount = $value;
        }

        $c_dis_cancel = DB::select("select SUM(disc_amount) disc_amount FROM finc_invoicedtl_vw where admission_no_pk = $hdn_admission_id and cancel_ind = 1");
        foreach ($c_dis_cancel as $value) {
            $c_dis_cancelation = $value;
        }

        // dd($total_sales);

        $invoice_item_list = DB::select("select item_no_fk,item_name, item_code, item_type_name, sum(item_qty) item_qty, sum(cancel_qty) cancel_qty, sum(current_item_qty) current_item_qty from  finc_inv_itemdtl_vw where admission_no_pk ='$hdn_admission_id' and item_type ='MED' group by item_name, item_code, item_type_name,item_no_fk order by item_name desc");


        $invoice_pay_dis_his = DB::select("select admission_no_pk,sum(net_sales) net_sales , sum(collection) collection,sum(due) due from finc_inv_c022_sum_amount_vw where admission_no_pk=' $hdn_admission_id'  and module_code  in ('PHR-I') group by admission_no_pk "); //->where("admission_no_pk", $hdn_admission_id)->select("*")->where("ledger_amt_sales", 0)->get();

        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(urgent_fee) as urgent_fee'), DB::raw('sum(ledger_amt_vat) as ledger_amt_vat'), DB::raw('sum(cancel_discount) as cancel_discount'), DB::raw('sum(ledger_amt_sales) as ledger_amt_sales'), 'invoice_no_pk')
            // ->where('ledgertrn_no_pk','<=',$trx)
            ->where('invoice_no_pk', $hdn_admission_id)
            ->where('module_code',['PHR-I'])
            ->groupby('invoice_no_pk')
            ->first();
        // dd( $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')
            ->where('invoice_no_pk', $hdn_admission_id)
            ->where('module_code',['PHR-I'])
            ->first();
        return Template::loadview("admin.ipd.billing.cust_info_cancel_histry_item_list", ['patient_info' => $patient_info, 'invoice_item_list' => $invoice_item_list, 'paymodes' => $paymodes, 'disctype' => $disctype, 'invoice_pay_dis_his' => $invoice_pay_dis_his, 'total_sales' => $total_sales, 'total_item_rates' => $total_item_rates, 'c_discount' => $c_discount, 'c_dis_cancelation' => $c_dis_cancelation, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
    public function store_cancelation(Request $request)
    {
        // $coun = count($request->cancel_checkbox);
        // dd($coun);
        $user_id = '';
        if ($request->hdn_doctor_id != "") {
            $user_id = DB::table('wsec_user')->select('user_no_pk')->where('person_no_fk', $request->hdn_doctor_id)->first();
        }
        $auth_id = !empty($user_id->user_no_pk) ? $user_id->user_no_pk  : Auth::id();
        DB::beginTransaction();
        // try {

        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();

        $cancel_date =  date('Y-m-d h:i:s', strtotime($time));
        $hdn_addmission_id = $request->hdn_addmission_id;
        $item_no = $request->cancel_ind;
        $cencel_q = $request->cancel_checkbox;
        $i = 0;
        $item_no_arr = [];
        $cencel_q_arr = [];

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
        if ($hdn_addmission_id != "") {
            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        } else {
            $module_info = DB::table("sysc_module")->where("module_code", "PHR-I")->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
        }

        // $procedureName = "pkg_billing_dev_2.prc_sales_cancellation";

        $pdo = DB::getPdo();



        for ($i = 0; $i < count($request->return_item); $i++) {
            $in_ledgertrn_no = 0;
            $out_ledgertrn_no = $outError = $out_invoice_id = $out_invoice_no = '';
            $in_item_no_fk  = $request->return_item[$i];
            $in_refund_reasons  = $request->input('return_reason_' . $request->return_item[$i]);
            $in_cancel_qty  = $request->input('return_qty_' . $request->return_item[$i]);

            $billinvoice = $pdo->prepare("begin pkg_billing_ipd_v0.prc_phr_ipd_sales_cancellation(
                :in_cancel_date,
                :in_refund_reason,
                :in_item_no_fk,
                :in_cancel_qty,
                :in_module_no_fk ,
                :in_admission_no_fk ,
                :in_counter_su_no_fk ,
                :in_au_entry_by ,
                :in_au_entry_session ,
                :in_au_entry_hospital_pk_no ,
                :in_ledgertrn_no,
                :out_invoice_no,
                :out_invoice_id,
                :out_ledgertrn_no,
                :out_error);
                end;");

            $billinvoice->bindParam(':in_cancel_date', $cancel_date); // will be adjust later
            $billinvoice->bindParam(':in_refund_reason', $in_refund_reasons);
            $billinvoice->bindParam(':in_item_no_fk', $in_item_no_fk);
            $billinvoice->bindParam(':in_cancel_qty',  $in_cancel_qty);
            $billinvoice->bindParam(':in_module_no_fk', $module_id,);
            $billinvoice->bindParam(':in_admission_no_fk', $hdn_addmission_id);
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
            // dd($outError);


            // $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                DB::commit();
                // dd($out_invoice_no,$out_ledgertrn_no);
                $message = ['msg' => 'cancelation Process completed successfully.', 'title' => 'Success', 'insert_id' => $out_invoice_no, 'trx_id' => $out_ledgertrn_no];
            } else {
                DB::rollback();
                $message = ['msg' => 'cancelation Process Failed' . $outError, 'title' => 'Error'];
            }
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }


        return response()->json($message);
    }

    public function ipdInvoiceAdjustment(Request $request)
    {
        $in_admission_no_pk = $request->admission_id;
        $zero = 0;
        $out_ledgertrn_no_pk = 0;
        $out_multiinv_group_nonuq_no = 0;
        $auth_id = Session::get('user.ses_user_pk_no');
        $entry_session = "IPD Invoice Adjustment";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $outError = '';
        $pdo = DB::getPdo();
        $billinvoice = $pdo->prepare("begin pkg_billing_ipd_v0.prc_billpayment_ipd_invadj_wp (
            :in_admission_no_pk                ,
            :in_counter_su_no_fk               ,
            :in_au_entry_by                    ,
            :in_au_entry_session               ,
            :in_au_entry_hospital_pk_no        ,
            :out_ledgertrn_no_pk            ,
            :out_multiinv_group_nonuq_no    ,
            :out_error);
            end;");

        $billinvoice->bindParam(':in_admission_no_pk', $in_admission_no_pk); // will be adjust later
        $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
        $billinvoice->bindParam(':in_au_entry_by', $auth_id);
        $billinvoice->bindParam(':in_au_entry_session', $entry_session);
        $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        // $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);
        $billinvoice->bindParam(':out_ledgertrn_no_pk', $out_ledgertrn_no_pk, PDO::PARAM_INT);
        $billinvoice->bindParam(':out_multiinv_group_nonuq_no', $out_multiinv_group_nonuq_no, PDO::PARAM_INT, 500);
        $billinvoice->bindParam(':out_error', $outError, PDO::PARAM_STR, 500);
        // dd($billinvoice);
        $billinvoice->execute();
        // dd($outError);


        // $result = DB::executeProcedure($procedureName, $dataBindingArr);

        if ($outError == '') {
            DB::commit();
            // dd($out_invoice_no,$out_ledgertrn_no);
            $message = ['msg' => 'Invoice Adjustment.', 'title' => 'Success'];
        } else {
            DB::rollback();
            $message = ['msg' => 'Invoice Adjustment Failed' . $outError, 'title' => 'Error'];
        }
        return response()->json($message);
    }
}
