<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Session;
use PDF;

class MPOWiseReferPFMController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function mpoWiseRefPerformance()
    {
        return Template::loadView("admin.pcrm.mpo.mpo_wise_report");
    }


    public function referralPaymentSearch(Request $request)
    {

        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $selectQuery = DB::table('sysc_referral_payment_invm_vw'); //->where('mx_referral_paid_ind', 1)
        // dd(  $selectQuery);
        // $doctor_income = [];

        if ($from_date != "" && $to_date != "") {

            $selectQuery->whereBetween(DB::raw("trunc(invoice_date)"), [$from_date, $to_date]); //invoice_date
            // $selectQuery->where(DB::raw("trunc(invoice_date)"), '>=', date('Y-m-d', strtotime(request('date_pic'))));
            // $selectQuery->where(DB::raw("trunc(invoice_date)"), '<=', date('Y-m-d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            //   $selectQuery->where(DB::raw("trunc(invoice_date)"), '=', date('Y-m-d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_invm_vw.ref0_agent_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.ref1_agent_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.ref2_agent_person_no_fk =  '$card_no')");
        }

        return Template::loadview("admin.pcrm.mpo.mpo_wise_report_details", ['doctor_income' => $selectQuery->orderBy('invoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no]);
    }

    public function referralPaymentPdf(Request $request, $id = '')
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery = DB::table('sysc_referral_payment_invm_vw')->where('module_code', "OPD");//->where('mx_referral_paid_ind', 1)

        $selectQuery1 = DB::table('sysc_referral_payment_invm_vw')
            ->leftJoin('ipd_admission', 'ipd_admission.admission_no_pk', 'sysc_referral_payment_invm_vw.admission_no_pk')
            // ->where('mx_referral_paid_ind', 1)
            ->where('module_code', "IPD")
            ->select('sysc_referral_payment_invm_vw.*', 'ipd_admission.admission_date')
        ->select(DB::raw("ipd_admission.admission_no_pk , ipd_admission.admission_date,sysc_referral_payment_invm_vw.patient_name, sum(ledger_amt_payment)  as ledger_amt_sales,
        sum(referral_amount_doc) as referral_amount_doc,
        sum(referral_amount_first) as referral_amount_first,
        sum(referral_amount_second) as referral_amount_second,
        LISTAGG (item_ref_code ,',') WITHIN GROUP (ORDER BY ipd_admission.admission_no_pk) AS item_ref_code "));
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_invm_vw.invoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_invm_vw.ref0_agent_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.ref1_agent_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.ref2_agent_person_no_fk =  '$card_no')");
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
            $selectQuery1->whereRaw("(sysc_referral_payment_invm_vw.ref0_agent_person_no_fk = '$card_no' or sysc_referral_payment_invm_vw.ref1_agent_person_no_fk = '$card_no' or  sysc_referral_payment_invm_vw.ref2_agent_person_no_fk =  '$card_no')");
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

        if ($id == "PDF") {
            $pdf = PDF::loadView("admin.pcrm.mpo.mpo_payment_pdf_jkmh", [
                'doctor_income_opd' => $selectQuery->select(DB::raw(' nvl(doctor_name,first_ref_doc_name) doctor_name,sum(ledger_amt_sales) as ledger_amt_sales_net,sum(referral_amt) as total_ref_payment'))->groupByRaw(" nvl(doctor_name,first_ref_doc_name) ")->get(),
                'doctor_income_ipd' => $selectQuery1->select(DB::raw(' nvl(doctor_name,first_ref_doc_name) doctor_name,sum(ledger_amt_sales) as ledger_amt_sales_net,sum(referral_amt) as total_ref_payment'))->groupByRaw(" nvl(doctor_name,first_ref_doc_name) ")
                    ->get(),
                'card_no' => $card_no,
                'print_type' => $id,
                'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee
            ])->setPaper('a4', 'portarit');
            return $pdf->stream('mpo_payment_report.pdf');
        } else {
            $pdf = [
                'doctor_income_opd' => $selectQuery->select(DB::raw(' nvl(doctor_name,first_ref_doc_name) doctor_name,sum(ledger_amt_sales_net) as ledger_amt_sales_net,sum(referral_amount_doc+referral_amount_first+referral_amount_second) as total_ref_payment'))->groupByRaw(" nvl(doctor_name,first_ref_doc_name) ")->get(),
                'doctor_income_ipd' => $selectQuery1->select(DB::raw(' nvl(doctor_name,first_ref_doc_name) doctor_name,sum(ledger_amt_sales) as ledger_amt_sales,sum(referral_amount_doc+referral_amount_first+referral_amount_second) as total_ref_payment'))->groupByRaw(" nvl(doctor_name,first_ref_doc_name) ")
                    ->get(),
                'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee
            ];

            $fileToExport = "mpo_payment_report";
            $html = View("admin.pcrm.mpo.mpo_payment_pdf_jkmh")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
}
