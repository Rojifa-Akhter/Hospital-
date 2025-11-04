<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use \PDF;
use Carbon\Carbon;

class RefferalReportController extends Controller
{
    //
    public function refferalPaymentV1()
    {

        $query = [];

        // $payment = DB::table('sysc_referral_payment_ipd')->select("admission_no_fk", "collection_amount", "refpaymentipd_no_pk", "pay_voucher_print_cnt", "head_name", "sales_amount", "paid_amount", "discount_amount")->where('ADMISSION_NO_FK', $request->hdn_admission_id)->get();

        return Template::loadView("admin.refferal.refferal_payment", ['data' => $query]);
    }

    public function searchReferralPaymentV1(Request $request)
    {

        $ref_doctor    = $request->doctor_id;
        $agent         = $request->ref_agent;
        $sec_ref       = $request->second_ref;
        $item_type     = $request->item_id;
        $patient_code  = $request->hdn_patient_id;
        $voucher_no    = $request->hdn_invoice_id;
        $not_processed = $request->process;
        $skipped       = $request->skipped;
        $all           = $request->all;
        // dd($ref_doctor,$request->search_date_from, $request->search_date_to);
        // $query = DB::table('sysc_referral_payment_invd_vw')->where('module_code', "OPD");
        $query = DB::table('sysc_referral_payment_invm_vw')->where('module_code', "OPD");
        //->whereRaw('(referral_amount_doc> 0 or referral_amount_first > 0 or referral_amount_second > 0)');
        if (!empty($voucher_no)) {
            $query->where('invoice_no_pk', $voucher_no);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(process_date)"), '>=', date('Y/m/d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(process_date)"), '<=', date('Y/m/d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(process_date)"), '=', date('Y/m/d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(process_date)"), '=', date('Y/m/d', strtotime($request->search_date_to)));
        }
        if ($ref_doctor != "") {
            $query->where('doc_person_no_fk', $ref_doctor);
        }
        if ($agent != "") {
            $query->where('first_ref_doc_person_no_fk', $agent);
        }
        if ($sec_ref != "") {
            $query->where('second_ref_doc_person_no_fk', $sec_ref);
        }
        if (!empty($item_type)) {
            $query->where('item_name', $item_type);
        }
        if (!empty($patient_code)) {
            $query->where('patient_no_fk', $patient_code);
        }

        if (!empty($not_processed) && $not_processed == "PAID") {
            $query->where('mx_referral_paid_ind', 1);
        }
        if (!empty($not_processed) && $not_processed == "UNPAID") {
            $query->whereRaw('nvl(mx_referral_paid_ind,0) = 0 ');
        }
        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            // $query->whereNotNull('first_ref_doc_person_no_fk');
        }

        $payment = DB::table('sysc_referral_payment_ipd')
            ->select("admission_no_fk", "collection_amount", "refpaymentipd_no_pk", "pay_voucher_print_cnt", "head_name", "sales_amount", "paid_amount", "discount_amount")
            ->where('ADMISSION_NO_FK', $request->hdn_admission_id)->get();

        return Template::loadview("admin.refferal.refferal_payment_list", [
            'data' => $query
                ->selectRaw('ledger_amt_sales,
                ledger_amt_payment,invoice_no_pk ,doc_person_no_fk,first_ref_doc_person_no_fk,
                second_ref_doc_person_no_fk,invoice_date,ledger_amt_sales,ledger_amt_discount
                ,ledger_amt_payment,patient_name,patient_code,inv_item_name
                ,doctor_name,ref0_referral_payable_ind
                ,referral_amount_doc,ref1_referral_payable_ind,first_ref_doc_name,referral_amt,
                ref2_referral_payable_ind,sec_ref_doc_name
                ,doc_person_no_fk,referral_amount_second,referral_amount_first,admission_no_pk,
                mx_referral_paid_ind, referral_amt_original,
                mx_referral_print_cnt , 0 as paid_amount')
                ->orderBy('invoice_date', 'desc')
                ->get()
                ->toArray(),
            'payment' => $payment
        ]);
    }


    public function referralPaymentIndUpdate(Request $request)
    {
        $auth_id = Auth::id();
        $hospital = Session::get('user.ses_hospital_no_pk');

        $inv_ref = $request->is_paid_amount;



        try {
            for ($i = 0; $i < count($inv_ref); $i++) {
                $invoiceDtlArr = DB::table('sysc_referral_payment_invd_vw')->where('invoice_no_pk', $inv_ref[$i])->pluck('invoicedtl_no_pk')->toArray();

                DB::table('finc_invoicedtl')->whereIn('invoicedtl_no_pk', $invoiceDtlArr)->update([
                    'referral_paid_ind' => 1
                ]);
                DB::commit();
            }
            $message = ['msg' => 'Referral Paid Completed successfully.', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => 'Referral Paid Failed', 'title' => 'Error'];
        }








        return response()->json($message);
    }

    public function refferalPaymentReportV1()
    {
        $card_no = '';
        return Template::loadview("admin.refferal.refferal_payment_report", ['card_no' => $card_no]);
    }
    public function referralPaymentSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $selectQuery = DB::table('sysc_referral_payment_invm_vw')->where('mx_referral_paid_ind', 1);
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {

            $selectQuery->whereBetween(DB::raw("trunc(invoice_date)"), [$from_date, $to_date]); //refinvoice_date
            // $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '>=', date('Y-m-d', strtotime(request('date_pic'))));
            // $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '<=', date('Y-m-d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            //   $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '=', date('Y-m-d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_invm_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.second_ref_doc_person_no_fk =  '$card_no')");
        }

        return Template::loadview("admin.refferal.refferal_payment_report_list", ['doctor_income' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no]);
    }
    public function referralPaymentPdf(Request $request, $id = '')
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no             = $request->card_hidn;
        $from_date           = $request->date_pic  != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date             = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery  = DB::table('sysc_referral_payment_invm_vw')->where('mx_referral_paid_ind', 1)->where('module_code', '=', 'OPD');

        $selectQuery1 = DB::table('sysc_referral_payment_invm_vw')
            ->leftJoin('ipd_admission', 'ipd_admission.admission_no_pk', 'sysc_referral_payment_invm_vw.admission_no_pk')
            ->where('mx_referral_paid_ind', 1)
            ->select('sysc_referral_payment_invm_vw.*', 'ipd_admission.admission_date')->where('sysc_referral_payment_invm_vw.module_code', '=', 'IPD')->select(DB::raw("ipd_admission.admission_no_pk , ipd_admission.admission_date,sysc_referral_payment_invm_vw.patient_name, sum(invoicemst_amt_payment)  as ledger_amt_sales,
            sum(referral_amount_doc) as referral_amount_doc,
            sum(referral_amount_first) as referral_amount_first,
            sum(referral_amount_second) as referral_amount_second,
            LISTAGG (item_ref_code ,',') WITHIN GROUP (ORDER BY ipd_admission.admission_no_pk) AS item_ref_code"));
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_invm_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.second_ref_doc_person_no_fk =  '$card_no')");
            // $selectQuery->orWhere('first_ref_doc_person_no_fk', $card_no);
            // $selectQuery->orWhere('second_ref_doc_person_no_fk', $card_no);
        }


        if ($from_date != "" && $to_date != "") {
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        $employee = '';
        if ($card_no != '') {
            $selectQuery1->whereRaw("(sysc_referral_payment_invm_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.second_ref_doc_person_no_fk =  '$card_no')");
            // $selectQuery->orWhere('first_ref_doc_person_no_fk', $card_no);
            // $selectQuery->orWhere('second_ref_doc_person_no_fk', $card_no);
            $employee =  DB::table("hrms_personnel")->where('person_no_pk', $card_no)->first();
        }


        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if (Session::get('user.ses_hospital_code') == 'JKMH') {
            if ($id == "PDF") {
                $selectQuery->select(DB::raw("sysc_referral_payment_invm_vw.*"));
                $pdf = PDF::loadView(
                    "admin.refferal.referral_payment_pdf_jkmh",
                    [
                        'doctor_income_opd' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(),
                        'doctor_income_ipd' => $selectQuery1->groupBy('ipd_admission.admission_no_pk', 'ipd_admission.admission_date', 'sysc_referral_payment_invm_vw.patient_name')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee
                    ]
                )->setPaper('a4', 'portarit');
                return $pdf->stream('referral_payment_pdf.pdf');
            } else {
                $pdf = ['doctor_income_opd' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(), 'doctor_income_ipd' => $selectQuery1->groupBy('ipd_admission.admission_no_pk', 'ipd_admission.admission_date', 'sysc_referral_payment_invd_vw.patient_name', 'sysc_referral_payment_invd_vw.rf_ipd_package')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee];

                $fileToExport = "referral_payment_pdf";
                $html = View("admin.refferal.referral_payment_pdf_jkmh")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } else {
            if ($id == "PDF") {
                $pdf = PDF::loadView("admin.refferal.referral_payment_pdf", ['doctor_income' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
                return $pdf->stream('referral_payment_pdf.pdf');
            } else {
                $pdf = ['doctor_income' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date];

                $fileToExport = "referral_payment_pdf";
                $html = View("admin.refferal.referral_payment_pdf")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        }
    }

    public function printReferralPayment($id, $print_id)
    {
        // dd($print_id);
        $id_expl = explode('_', $id);


        $invoice = $id_expl[0];
        $doc_no_fk = $id_expl[1];
        $first_ref_no_fk = $id_expl[2];
        $second_ref_no_fk = $id_expl[3];
        $invoice_dtl = $id_expl[4];
        $ref_comission = [];
        if ($doc_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_invm_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->referral_amt;
        } elseif ($first_ref_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_invm_vw')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->referral_amt;
        } elseif ($second_ref_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_invm_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->referral_amt;
        }
        // dd($ref_comission);

        if ($doc_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_invm_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->doctor_name;
        } elseif ($first_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_invm_vw')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->first_ref_doc_name;
        } elseif ($second_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_invm_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->sec_ref_doc_name;
        }

        $ref_data_invoice = DB::table('pcrm_referral_invoice_idtl_vw')->where('invoice_no_pk', $invoice)->get();
        $ref_data = DB::table('pcrm_referral_invoice_idtl_vw inv')
            ->select("inv.*", "wsec.user_name", "pay.process_date")
            ->leftJoin("sysc_referral_payment pay", "inv.invoice_no_pk", "pay.invoice_no_fk")
            ->leftjoin("wsec_user wsec", "pay.au_entry_by", "wsec.user_no_pk")
            ->where('inv.invoice_no_pk', $invoice)->first();
        // dd($ref_data);

        $invoice_amount = DB::table('finc_voucherwise_vw')->select("sales as ledger_amt_sales", "discount as ledger_amt_discount", "collection as ledger_amt_payment")->where('invoice_no_pk', $invoice)->first();

        // Print save Start
        $invoiceDtlArr = DB::table('sysc_referral_payment_invd_vw')->where('invoice_no_pk', $invoice)->pluck('invoicedtl_no_pk')->toArray();
        $data = [
            'referral_print_cnt' => $print_id + 1,
        ];
        DB::table('finc_invoicedtl')->whereIn('invoicedtl_no_pk', $invoiceDtlArr)->update($data);
        // Print save end

        $print_dt = $print_id + 1;
        //  dd( $invoice);
        $title = $ref_data->invoice_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $ref_data->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_code = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.refferal.referral_process_list_pdf", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt]);
        return $pdf->stream('Referral-payment.pdf');
    }

    public function refferalIPDPaymentV1()
    {

        $query = [];
        return Template::loadView("admin.refferal.refferal_payment_ipd", ['data' => $query]);
    }



    public function searchIPDReferralPaymentV1(Request $request)
    {

        $ref_doctor    = $request->doctor_id;
        $agent         = $request->ref_agent;
        $sec_ref       = $request->second_ref;
        $item_type     = $request->item_id;
        $patient_code  = $request->hdn_patient_id;
        $voucher_no    = $request->hdn_invoice_id;
        $not_processed = $request->process;
        $skipped       = $request->skipped;
        $all           = $request->all;

        $query = DB::table('sysc_referral_payment_invm_vw')
            ->leftJoin('ipd_admitted_patlist_vw', "sysc_referral_payment_invm_vw.admission_no_pk", "ipd_admitted_patlist_vw.admission_no_pk")
            ->selectRaw('sysc_referral_payment_invm_vw.*,ipd_admitted_patlist_vw.bed_name,ipd_admitted_patlist_vw.admission_date')
            ->where('module_code', "IPD");
        //->whereRaw('(referral_amount_doc> 0 or referral_amount_first > 0 or referral_amount_second > 0)');
        if (!empty($voucher_no)) {
            $query->where('invoice_no_pk', $voucher_no);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(sysc_referral_payment_invm_vw.process_date)"), '>=', date('Y/m/d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(sysc_referral_payment_invm_vw.process_date)"), '<=', date('Y/m/d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(sysc_referral_payment_invm_vw.process_date)"), '=', date('Y/m/d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(sysc_referral_payment_invm_vw.process_date)"), '=', date('Y/m/d', strtotime($request->search_date_to)));
        }
        if ($ref_doctor != "") {
            $query->where('sysc_referral_payment_invm_vw.doc_person_no_fk', $ref_doctor);
        }
        if ($agent != "") {
            $query->where('sysc_referral_payment_invm_vw.first_ref_doc_person_no_fk', $agent);
        }
        if ($sec_ref != "") {
            $query->where('sysc_referral_payment_invm_vw.second_ref_doc_person_no_fk', $sec_ref);
        }
        if (!empty($item_type)) {
            $query->where('sysc_referral_payment_invm_vw.item_name', $item_type);
        }
        if (!empty($patient_code)) {
            $query->where('sysc_referral_payment_invm_vw.patient_no_fk', $patient_code);
        }
        if (!empty($patient_code)) {
            $query->where('sysc_referral_payment_invm_vw.patient_no_fk', $patient_code);
        }
        if (!empty($request->hdn_admission_id)) {
            $query->where('sysc_referral_payment_invm_vw.admission_no_pk', $request->hdn_admission_id);
        }

        if (!empty($not_processed) && $not_processed == "PAID") {
            $query->where('sysc_referral_payment_invm_vw.mx_referral_paid_ind', 1);
        }
        if (!empty($not_processed) && $not_processed == "UNPAID") {
            $query->whereRaw('nvl(sysc_referral_payment_invm_vw.mx_referral_paid_ind,0) = 0 ');
        }
        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            // $query->whereNotNull('first_ref_doc_person_no_fk');
        }

        $hdn_admission_id  = isset($request->hdn_admission_id) ? $request->hdn_admission_id : 0;

        $head_wise_payment = DB::select("select admission_no_pk,par_item_type_name, sum(net_sales) as collection_amount,sum(referral_amount) referral_amount,sum(invoicedtl_amt_discount) invoicedtl_amt_discount from finc_invoicedtl_detail_vw where module_code ='IPD' and admission_no_pk ='$hdn_admission_id' and referral_amount > 0 and ref_applicable= 1   group by par_item_type_name,admission_no_pk");

        $payment = DB::table('sysc_referral_payment_ipd')->select("admission_no_fk", "collection_amount", "refpaymentipd_no_pk", "pay_voucher_print_cnt", "head_name", "sales_amount", "paid_amount", "discount_amount")->where('ADMISSION_NO_FK', $request->hdn_admission_id)->get();

        $payment_arr = [];

        if (!empty($payment)) {
            foreach ($payment as $pay) {
                $payment_arr[$pay->admission_no_fk][$pay->head_name] = $pay->paid_amount;
                $payment_arr[$pay->admission_no_fk]["count"][$pay->head_name] = isset($pay->pay_voucher_print_cnt) ? $pay->pay_voucher_print_cnt : 0;
            }
        }
        //dd($payment_arr);

        return Template::loadview("admin.refferal.refferal_payment_list_ipd", [
            'data' => $query
                ->orderBy('invoice_date', 'desc')
                ->get()
                ->toArray(),
            'payment' => $payment,
            'head_wise_payment' => $head_wise_payment,
            'payment_arr' => $payment_arr,
        ]);
    }

    public function adjustingAmountAdmission(Request $request)
    {
        $admission_id_arr =  $request->admission_id;
        for ($i = 0; $i < count($admission_id_arr); $i++) {
            DB::table('sysc_referral_payment_ipd')->where('admission_no_fk', $admission_id_arr[$i])->delete();
            DB::commit();
        }
        $refpaymentipd_no_pk =  $request->refpaymentipd_no_id;


        for ($i = 0; $i < count($request->head_name); $i++) {
            $sequence = DB::getSequence();
            $refpaymentipd_no_pk_seq = $sequence->nextValue('refpaymentipd_no_pk_seq');
            $data = array();
            $data['refpaymentipd_no_pk'] = $refpaymentipd_no_pk_seq;
            $data['paid_amount'] = $request->comission[$i];
            $data['sales_amount'] = $request->sales_amount[$i];
            $data['head_name'] = $request->head_name[$i];
            $data['admission_no_fk'] = $request->admission_id[$i];
            $data['pay_voucher_print_cnt'] = $request->print_id[$i] + 1;
            $data['paid_ind'] = 1;
            $data['paid_date'] = date('Y-m-d');
            $data['paid_by'] = auth::id();
            $data['au_entry_by'] = auth::id();
            $data['au_entry_at'] = date("Y-m-d h:i:s");
            $data['au_entry_session'] = "Adjustment";
            $data['au_entry_hospital_pk_no'] =  Session::get('user.ses_hospital_no_pk');
            DB::table('sysc_referral_payment_ipd')->where('refpaymentipd_no_pk', $refpaymentipd_no_pk[$i])->insert($data);
        }

        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
    }


    public function printReferralPaymentAdm($id, $print_id)
    {
        // dd($id, $print_id);
        $id_expl = explode('_', $id);
        // dd( $id_expl[2]);

        $invoice = $id_expl[0];
        $doc_no_fk = $id_expl[1];
        $first_ref_no_fk = $id_expl[2];
        $second_ref_no_fk = $id_expl[3];
        $admission_id = $id_expl[4];
        // dd($admission_id);
        $comission = [];
        if ($doc_no_fk != 0) {
            $comission = DB::select("select sum(PAID_AMOUNT) paid_comission from sysc_referral_payment_invd_vw
            where ADMISSION_NO_PK = $admission_id");
        } elseif ($first_ref_no_fk != 0) {
            $comission = DB::select("select sum(PAID_AMOUNT) from sysc_referral_payment_invd_vw
            where ADMISSION_NO_PK = $admission_id");
        } elseif ($second_ref_no_fk != 0) {
            $comission = DB::table('sysc_referral_payment_invd_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->paid_amount;
        }
        $ref_comission = 0;
        // dd($invoice,
        // $doc_no_fk);
        $ref_name = '';
        if ($doc_no_fk != 0) {
            $ref_name = DB::table('sysc_referral_payment_invd_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->doctor_name;
        } elseif ($first_ref_no_fk != 0) {
            $ref_name = DB::table('sysc_referral_payment_invd_vw')->select('first_ref_doc_name')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first();
            // dd($ref_name);

        } elseif ($second_ref_no_fk != 0) {
            $ref_name = DB::table('sysc_referral_payment_invd_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->sec_ref_doc_name;
        }

        // $ref_data_invoice = DB::table('pcrm_referral_invoicelist_vw')->where('invoice_no_pk', $invoice)->get();

        // $ref_data_invoice = DB::select("select * from sysc_referral_payment_ipd where admission_no_fk = $admission_id");




        $ref_data_invoice = db::select("select admission_no_fk,
                                    refpaymentipd_no_pk,
                                    pay_voucher_print_cnt,
                                    head_name,
                                    sales_amount as COLLECTION_AMOUNT,
                                    nvl(paid_amount,0) + nvl(discount_amount,0) paid_amount,
                                    discount_minus_ind,
                                    discount_amount,
                                    case when nvl(discount_minus_ind,0) =1 then paid_amount else nvl(paid_amount,0) + nvl(discount_amount,0) end net_commission
                            from sysc_referral_payment_ipd
                            where admission_no_fk = $admission_id");

        $ref_data = DB::table('pcrm_referral_invoice_idtl_vw')->where('admission_no_pk', $admission_id)->first();
        //  dd($ref_data);
        $invoice_amount = DB::table('finc_voucherwise_vw')->select("sales as ledger_amt_sales", "discount as ledger_amt_discount", "collection as ledger_amt_payment")->where('invoice_no_pk', $invoice)->first();

        // Print save Start
        $data = [
            'pay_voucher_print_cnt' => $print_id + 1,
        ];
        DB::table('sysc_referral_payment_ipd')->where('admission_no_fk', $admission_id)->update($data);
        // Print save end
        $adjustment_amount = 0;
        $print_dt = $print_id + 1;

        $title = $ref_data->invoice_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $ref_data->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_code = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        return view("admin.pcrm.referral_v2.referral_payment_admission", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt, 'adjustment_amount' => $adjustment_amount]);
        $pdf = PDF::loadView("admin.pcrm.referral_v2.referral_payment_admission", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt, 'adjustment_amount' => $adjustment_amount]);
        return $pdf->stream('Referral-payment.pdf');
    }

    public function refferalPaymentEdit($invoice_id, $type)
    {
        $invoice_item_list = DB::table('sysc_referral_payment_invd_vw')
            ->select('sysc_referral_payment_invd_vw.*')
            ->where('invoice_no_pk', $invoice_id)
            ->get();

        return Template::loadview('admin.refferal.ref_payment_edit', ['type' => $type, 'invoice_item_list' => $invoice_item_list, 'invoice_id' => $invoice_id]);
    }

    public function refferalPaymentUpdate(Request $request)
    {

        try {
            for ($i = 0; $i < count($request->payment_id); $i++) {
                if ($request->type == 1)
                    DB::table('finc_invoicedtl')
                        ->where('invoicedtl_no_pk', $request->payment_id[$i])
                        ->update(
                            [
                                'referral_amt'         => $request->item_payment_arr[$i],
                                "referra_amt_edit_at"  => date("Y-m-d"),
                                "referra_amt_edit_by"  => Auth::user()->id,
                                "referra_amt_edit_ind" => 1
                            ]
                        );
                if ($request->type == 2)
                    DB::table('finc_invoicedtl')
                        ->where('invoicedtl_no_pk', $request->payment_id[$i])
                        ->update(
                            [
                                'referral_amt'         => $request->item_payment_arr[$i],
                                "referra_amt_edit_at"  => date("Y-m-d"),
                                "referra_amt_edit_by"  => Auth::user()->id,
                                "referra_amt_edit_ind" => 1
                            ]
                        );
                if ($request->type == 3)
                    DB::table('finc_invoicedtl')
                        ->where('invoicedtl_no_pk', $request->payment_id[$i])
                        ->update(
                            [
                                'referral_amt'         => $request->item_payment_arr[$i],
                                "referra_amt_edit_at"  => date("Y-m-d"),
                                "referra_amt_edit_by"  => Auth::user()->id,
                                "referra_amt_edit_ind" => 1
                            ]
                        );
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    //referral patient list
    public function externalReferralPerformanceReport()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $agent_info = DB::table('hrms_personnel')->select("person_no_pk", "full_name", "PERSON_CODE")->where("apps_user_ind", "1")->orderby("au_entry_at", "desc")->get();

        $external_refferal_performance_info = DB::table('finc_doctor_income_appagentrefpay_vw')->whereRaw("trunc(reg_date)=TO_DATE('$today_date', 'YYYY-MM-DD')")->orderby("REG_DATE", "desc")->get();

        return Template::loadView("admin.refferal.external_refferal_performance_report", [
            'external_refferal_performance_info' => $external_refferal_performance_info,
            'agent_info' => $agent_info
        ]);
    }


    public function searchExternalReferralPerformance(Request $request)
    {
        $external_refferal_performance_info = DB::table('finc_doctor_income_appagentrefpay_vw');
        if (isset($request->date_from) && isset($request->date_to)) {
            $external_refferal_performance_info->where(DB::raw('trunc(reg_date)'), '>=', date('Y-m-d', strtotime($request->date_from)));
            $external_refferal_performance_info->where(DB::raw('trunc(reg_date)'), '<=', date('Y-m-d', strtotime($request->date_to)));
        }

        if (isset($request->referral_id)) {
            $external_refferal_performance_info->where('agent_no_fk', $request->referral_id);
        }
        if (!isset($request->date_from) && !isset($request->date_to) && !isset($request->referral_id)) {
            $external_refferal_performance_info = [];
        } else {
            $external_refferal_performance_info = $external_refferal_performance_info->orderby("REG_DATE", "desc")->get();
        }

        return Template::loadView("admin.refferal.external_refferal_performance_table", [
            'external_refferal_performance_info' => $external_refferal_performance_info
        ]);
    }

    public function externalReferralPerformanceReportPrint(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));
        $external_refferal_performance_info = DB::table('finc_doctor_income_appagentrefpay_vw');
        if (isset($request->date_from) && isset($request->date_to)) {
            $external_refferal_performance_info->where(DB::raw('trunc(reg_date)'), '>=', date('Y-m-d', strtotime($request->date_from)));
            $external_refferal_performance_info->where(DB::raw('trunc(reg_date)'), '<=', date('Y-m-d', strtotime($request->date_to)));
        }

        if (isset($request->referral_id)) {
            $external_refferal_performance_info->where('agent_no_fk', $request->referral_id);
        }
        if (!isset($request->date_from) && !isset($request->date_to) && !isset($request->referral_id)) {
            $external_refferal_performance_info = [];
        } else {
            $external_refferal_performance_info = $external_refferal_performance_info->orderby("REG_DATE", "desc")->get();
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.refferal.external_refferal_performance_report_print", ["external_refferal_performance_info" => $external_refferal_performance_info, "po_hospital_details" => $po_hospital_details,'from_date' => $from_date, 'to_date' => $to_date,])->setPaper('a4', 'landscape');
        return $pdf->stream('external_refferal_performance_report_print.pdf');

    }
}

//formula
// Item Wise Payment =
// Sales_AMount = Item_Rate *(item_qty-cancel_qty)
// sales_percentage = (Invoice_amt / Sales_AMount)*100
// Item Wise Payment = sales_percentage of Payment
