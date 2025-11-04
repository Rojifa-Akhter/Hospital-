<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use PDF;

class DoctorReportController extends Controller
{
    //

    public function doctorWiseIncomeSummery()
    {
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.reports.doctors.doctor_monthly_income_summary", ['card_no' => $card_no, 'serviceDepts' => $serviceDepts]);
    }
    public function doctorWiseIncomeSummerySearch(Request $request)
    {
        /*$card_no = $request->card_hidn;
        $request_department = $request->request_department;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $doctor_income = [];
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());


        $doctor_income =  DB::select("select TO_CHAR (income_date, 'mm') income_month,INITCAP(to_char(income_date,'Month')) income_date, person_no_pk, full_name, sum(total_appointment) total_appointment , sum(patient_free) patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) patient_new_paid, sum(total_patient_paid) total_patient_paid, sum(sur_amt) sur_amt, sum(lab_amt) lab_amt, sum(rad_amt) rad_amt, sum(ipd_service_amt) ipd_service_amt, sum(all_other_amt) all_other_amt, sum(sur_amt_count) sur_amt_count, sum(ipd_service_amt_count) ipd_service_amt_count, sum(total_admission_no) total_admission_no, sum(pathology_amt_count) pathology_amt_count, sum(radiology_amt_count) radiology_amt_count from finc_doctor_income_dt_vw   $sql_cond  group by TO_CHAR (income_date, 'mm'),INITCAP(to_char(income_date,'Month')),  person_no_pk, full_name order by income_month asc");

        return Template::loadview("admin.reports.doctors.doctor_monthly_income_summary_list", ['doctor_income' => $doctor_income, 'card_no' => $card_no]);
        */

        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';


        $request_department = $request->request_department;

        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('serviceunit_no_pk', $request_department)
            ->first();

        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $doctor_income = [];
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }

        $selectQuery = DB::select("select person_no_pk, full_name, sum(total_appointment)total_appointment, sum(patient_free)patient_free, sum(patient_followup_free)patient_followup_free, sum(patient_new_paid)patient_new_paid, sum(total_patient_paid)total_patient_paid, sum(sur_amt)sur_amt, sum(lab_amt)lab_amt, sum(rad_amt)rad_amt, sum(ipd_service_amt)ipd_service_amt, sum(all_other_amt)all_other_amt, sum(sur_amt_count)sur_amt_count, sum(ipd_service_amt_count)ipd_service_amt_count, sum(total_admission_no)total_admission_no, sum(pathology_amt_count)pathology_amt_count, sum(radiology_amt_count)radiology_amt_count from finc_doctor_income_refpay_vw $sql_cond group by person_no_pk, full_name");
        $doctor_income = [];

        // if ($from_date != "" && $to_date != "") {
        //     $selectQuery->where(DB::raw("trunc(income_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
        //     $selectQuery->where(DB::raw("trunc(income_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        // } elseif ($from_date != "") {
        //     $selectQuery->where(DB::raw("trunc(income_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        // }

        // if ($card_no != '') {
        //     $selectQuery->where('person_no_pk', $card_no);
        // }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wise_income_summery_monthly_list", ['doctor_income' => $selectQuery, 'card_no' => $card_no, 'department' => $serviceDepts]);
    }
    public function doctorWiseIncomeSummeryPdf(Request $request, $id = '')
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        // $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        // $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        // $request_department = $request->request_department;
        // $sql_cond = "";
        // if ($from_date != "" && $to_date != "") {
        //     $sql_cond .= $sql_cond != "" ? "and " : "where ";
        //     $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        // } elseif ($from_date != "") {
        //     $sql_cond .= $sql_cond != "" ? "and " : "where ";
        //     $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        // }
        // if ($card_no != '') {
        //     $sql_cond .= $sql_cond != "" ? "and " : "where ";
        //     $sql_cond .= "person_no_pk = $card_no";
        // }
        // if ($request_department != '') {
        //     $sql_cond .= $sql_cond != "" ? "and " : "where ";
        //     $sql_cond .= "serviceunit_no_fk = $request_department";
        // }



        // $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $card_no = $request->card_hidn;
        // $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        // $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';


        $percentage = $request->percentage;
        $request_department = $request->request_department;

        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('serviceunit_no_pk', $request_department)
            ->get();

        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $doctor_income = [];
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        }
        // if ($card_no != '') {
        //     $sql_cond .= $sql_cond != "" ? "and " : "where ";
        //     $sql_cond .= "person_no_pk = $card_no";
        // }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }

        $selectQuery = DB::select("select person_no_pk, full_name, sum(total_appointment)total_appointment, sum(patient_free)patient_free, sum(patient_followup_free)patient_followup_free, sum(patient_new_paid)patient_new_paid, sum(total_patient_paid)total_patient_paid, sum(sur_amt)sur_amt, sum(lab_amt)lab_amt, sum(rad_amt)rad_amt, sum(ipd_service_amt)ipd_service_amt, sum(all_other_amt)all_other_amt, sum(sur_amt_count)sur_amt_count, sum(ipd_service_amt_count)ipd_service_amt_count, sum(total_admission_no)total_admission_no, sum(pathology_amt_count)pathology_amt_count, sum(radiology_amt_count)radiology_amt_count from finc_doctor_income_refpay_vw $sql_cond group by person_no_pk, full_name");
        //$doctor_income = [];



        // dd($selectQuery->skip(1300)->get());
        //$doctor_income =  DB::select("select TO_CHAR (income_date, 'mm') income_month,INITCAP(to_char(income_date,'Month')) income_date, person_no_pk, full_name, sum(total_appointment) total_appointment , sum(patient_free) patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) patient_new_paid, sum(total_patient_paid) total_patient_paid, sum(sur_amt) sur_amt, sum(lab_amt) lab_amt, sum(rad_amt) rad_amt, sum(ipd_service_amt) ipd_service_amt, sum(all_other_amt) all_other_amt, sum(sur_amt_count) sur_amt_count, sum(ipd_service_amt_count) ipd_service_amt_count, sum(total_admission_no) total_admission_no, sum(pathology_amt_count) pathology_amt_count, sum(radiology_amt_count) radiology_amt_count from finc_doctor_income_dt_vw   $sql_cond  group by TO_CHAR (income_date, 'mm'),INITCAP(to_char(income_date,'Month')),  person_no_pk, full_name order by income_month asc");



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
            //$pdf = PDF::loadView("admin.reports.doctors.doctor_wish_income_summery_pdf", ['doctor_income' => $doctor_income, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id])->setPaper('a4', 'landscape');
            //return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');

            $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wise_income_summery_monthly_pdf", ['percentage' => $percentage, 'doctor_income' => $selectQuery, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'department' => $serviceDepts])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {
            $pdf = ['doctor_income' => $selectQuery, 'percentage' => $percentage, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'department' => $serviceDepts];

            $fileToExport = "doctor_wish_income_summery_excel";
            $html = view("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wise_income_summery_monthly_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
    public function doctorShareReport()
    {
        return Template::loadView("admin.reports.doctors.doctor_share_report");
    }
    public function doctorWiseShareReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery = DB::table('doctor_share_summary_income_vw')->select("sur_type,itemtype_code,module_code,person_no_fk,
        count(invoice_no_pk),invoice_date,doctor_income,sur_amt,lab_amt,rad_amt,ipd_service_amt,all_other_amt,sur_amt_count,ipd_service_amt_count,pathology_amt_count,radiology_amt_count whereIn('module_code',['IPD','OPD','OPDC']) group by person_no_fk sur_type,itemtype_code,module_code,
        invoice_no_pk,invoice_date,doctor_income,sur_amt,lab_amt,rad_amt,ipd_service_amt,all_other_amt,sur_amt_count,ipd_service_amt_count,pathology_amt_count,radiology_amt_count");
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(invoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(invoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(invoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->where('person_no_pk', $card_no);
        }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());
        dd($selectQuery->orderBy('invoice_date', 'ASC')->get());
        return Template::loadview("admin.reports.doctors.doctor_wise_share_report_list", ['doctor_share' => $selectQuery->orderBy('invoice_date', 'DESC')->get(), 'card_no' => $card_no]);
    }

    // Reports
    public function incomeDetailsPrint($id, $date, $from_date, $type)
    {
        // dd($id, $date, $from_date, $type);
        $date =  date('m/d/Y', strtotime($date));
        $from_date =  date('m/d/Y', strtotime($from_date));
        if ($type == 'DEPT') {
            $service_unit = $id;
        }

        if ($type != 'DEPT') {
            // $income_details = DB::select("SELECT distinct ( CASE WHEN ITEMTYPE_CODE IN ('SERVICE', 'BED', 'IPD') THEN 'IPD SERVICE Item - SERVICE, BED, IPD' WHEN ITEMTYPE_CODE IN ('RAD') THEN 'Radiology Item - RAD' WHEN ITEMTYPE_CODE IN ('LAB') THEN 'Pathology Item - LAB' WHEN ITEMTYPE_CODE IN ('SUR','OT') THEN 'SUR_AMT - SUR, OT' WHEN ITEMTYPE_CODE IN ('CONS') THEN 'OPD' ELSE 'OTHERS' END) SUR_TYPE, ITEMTYPE_CODE, PERSON_NO_FK, ADMISSION_NO_PK,
            // TRUNC (INVOICE_DATE) INVOICE_DATE, INVOICE_NO_PK, ITEM_NO_FK, ITEM_NAME, SUM (NVL (NET_SALES, 0) - NVL (REFUND, 0) + NVL (ITEM_LEVEL_DIST_ADJ_AMT, 0) + NVL (URGENT_FEE, 0) + NVL (SERVICE_CHARGE, 0)) income, PATIENT_NAME, FULL_NAME FROM CORE_FINC_SUM_INV_ITEM_LD_VW join sysc_serviceitem si on ITEM_NO_FK = ITEM_NO_PK join hrms_personnel per on person_no_fk = per.person_no_pk join patn_registration pat on pat.patient_no_pk = patient_no_fk where PERSON_NO_FK = '$id' and TRUNC(INVOICE_DATE) between to_date('$from_date','mm/dd/yyyy') and TO_DATE('$date','mm/dd/yyyy') GROUP BY ITEMTYPE_CODE, PERSON_NO_FK, ADMISSION_NO_PK, TRUNC (INVOICE_DATE),
            // INVOICE_NO_PK, ITEM_NO_FK, ITEM_NAME, PATIENT_NAME, FULL_NAME ORDER BY SUR_TYPE");

            $income_details = DB::select("SELECT distinct ( CASE WHEN ITEMTYPE_CODE IN ('SERVICE', 'BED', 'IPD') THEN 'IPD SERVICE Item - SERVICE, BED, IPD' WHEN ITEMTYPE_CODE IN ('RAD') THEN 'Radiology Item - RAD' WHEN ITEMTYPE_CODE IN ('LAB') THEN 'Pathology Item - LAB' WHEN ITEMTYPE_CODE IN ('SUR','OT') THEN 'SUR_AMT - SUR, OT' WHEN ITEMTYPE_CODE IN ('CONS') THEN 'OPD' ELSE 'OTHERS' END) SUR_TYPE, ITEMTYPE_CODE, PERSON_NO_FK, ADMISSION_NO_PK,
            TRUNC (INVOICE_DATE) INVOICE_DATE, INVOICE_NO_PK, ITEM_NO_FK, ITEM_NAME, SUM (NVL (NET_SALES, 0) - NVL (REFUND, 0) + NVL (ITEM_LEVEL_DIST_ADJ_AMT, 0) + NVL (URGENT_FEE, 0) + NVL (SERVICE_CHARGE, 0)) income, PATIENT_NAME, FULL_NAME FROM CORE_FINC_SUM_INV_ITEM_LD_VW join sysc_serviceitem si on ITEM_NO_FK = ITEM_NO_PK join hrms_personnel per on person_no_fk = per.person_no_pk join patn_registration pat on  pat.patient_no_pk = patient_no_fk where PERSON_NO_FK = '$id' and  TRUNC(INVOICE_DATE) between to_date('$from_date','mm/dd/yyyy') and TO_DATE('$date','mm/dd/yyyy') GROUP BY ITEMTYPE_CODE, PERSON_NO_FK, ADMISSION_NO_PK, TRUNC (INVOICE_DATE),
            INVOICE_NO_PK, ITEM_NO_FK, ITEM_NAME, PATIENT_NAME, FULL_NAME ORDER BY SUR_TYPE");
        } else {

            $income_details = db::select(DB::raw("SELECT (itemdtl.current_item_qty) AS current_item_qty,
            (itemdtl.total_item_amt) AS total_item_amt,
            (itemdtl.disc_amount) AS disc_amount,
            (itemdtl.ledgerdtl_amt_payment) AS ledgerdtl_amt_payment,
            itemdtl.serviceunit_no_fk,
            itemdtl.serviceunit_name,
            INVM.PATIENT_NAME,
            itemdtl.item_type_name,
            itemdtl.INVOICE_NO_FK,
            ITEM_NAME,
            TRUNC (itemdtl.INVOICE_DATE) INVOICE_DATE
       FROM    finc_inv_itemdtl_vw itemdtl

            JOIN
               FINC_INVOICEMST_VW invm
            ON itemdtl.INVOICE_NO_FK = INVM.INVOICE_NO_PK
      WHERE MODULE_CODE = 'OPD' and itemdtl.serviceunit_NO_FK = '$service_unit' and  TRUNC(itemdtl.INVOICE_DATE) = to_date('$date','dd/mm/yyyy')
   ORDER BY INVOICE_DATE ASC"));
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($type != 'DEPT') {
            // $doc_data = [];
            // if (!empty($income_details)) {
            //     foreach ($income_details as $key => $details) {
            //         $doc_data[$key] = $details;
            //     }
            // }
            $doc_data = [];
            if (!empty($income_details)) {
                foreach ($income_details as $key => $details) {
                    $doc_data[$key] = $details;
                }
            }

            $patient_data = [];
            if (!empty($income_details)) {
                foreach ($income_details as $key => $pat_details) {
                    $patient_data[$pat_details->patient_name][] = $pat_details;
                }
            }
        } else {
            $dept_data = [];
            $su_name = [];
            $su_pt = [];
            $date = [];

            if (!empty($income_details)) {
                foreach ($income_details as $key => $details) {
                    $dept_data[$details->serviceunit_name . '_' . $details->serviceunit_no_fk . '_' . $details->invoice_date][] = $details;
                    $su_name = $details->serviceunit_name;
                    $su_pt = $details->serviceunit_no_fk;
                    $date = $details->invoice_date;
                }
            }
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // return $report_data;
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($type != 'DEPT') {
            $pdf = PDF::loadView("admin.ipd.reports.doctor_wise_details_print", [
                'income_details' => $income_details,
                'po_hospital_details' => $po_hospital_details,
                'barcode_no' => $barcode_no,
                'date' => $date,
                'doc_data' => $doc_data,
                'patient_data' => $patient_data,
                'type' => $type
            ])->setPaper('a4', 'landscape');

            return $pdf->download('doctor_wise_details_print.pdf');
        } else {
            $pdf = PDF::loadView("admin.ipd.reports.doctor_wise_details_print", [
                'income_details' => $income_details,
                'po_hospital_details' => $po_hospital_details,
                'barcode_no' => $barcode_no,
                'date' => $date,
                'dept_data' => $dept_data,
                'su_name' => $su_name,
                'su_pt' => $su_pt,
                'date' => $date,
                'type' => $type
            ])->setPaper('a4', 'landscape');
            return $pdf->download('department_wise_details_print.pdf');
        }
    }

    public function doctorWiseCommissionSummery()
    {
        $default = 10;
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $request_type = '';
        return Template::loadview("admin.reports.doctors.doctor_monthly_commission_summary", ['default' => $default, 'card_no' => $card_no, 'serviceDepts' => $serviceDepts, 'request_type' => $request_type]);
    }
    public function doctorWiseCommissionSummerySearch(Request $request)
    {

        $default = $request->doc_share;
        $card_no = $request->card_hidn;
        $request_department = $request->request_department;
        $request_type = $request->request_type;
        $from_date = $request->date_pic != "" ? date("Y/m/d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y/m/d", strtotime($request->date_pic2)) : '';
        $doctor_income = [];
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "income_date >='$from_date' and income_date <= '$to_date'";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "income_date >= '$from_date'";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());
        // lab_dis_amt
        // rad_dis_amt

        $doctor_income =  DB::select("select  person_no_pk, full_name, sum(total_appointment) total_appointment , sum(patient_free) patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) patient_new_paid, sum(total_patient_paid) total_patient_paid, sum(sur_amt) sur_amt, sum(lab_amt) lab_amt, sum(rad_amt) rad_amt, sum(ipd_service_amt) ipd_service_amt, sum(all_other_amt) all_other_amt, sum(sur_amt_count) sur_amt_count, sum(ipd_service_amt_count) ipd_service_amt_count, sum(total_admission_no) total_admission_no, sum(pathology_amt_count) pathology_amt_count, sum(radiology_amt_count) radiology_amt_count,  sum(sur_discount_amt ) as sur_discount_amt , sum(opd_discount_amt ) as opd_discount_amt , sum(ipd_discount_amt ) as ipd_discount_amt, sum(lab_dis_amt ) as lab_dis_amt,sum(rad_dis_amt ) as rad_dis_amt from finc_doctor_income_dt_vw   $sql_cond  group by  person_no_pk, full_name ");
        // dd(  $doctor_income );
        return Template::loadview("admin.reports.doctors.doctor_monthly_commission_summary_list", ['default' => $default, 'doctor_income' => $doctor_income, 'card_no' => $card_no, 'request_type' => $request_type]);
    }

    public function doctorWiseCommissionSummeryPdf(Request $request, $id = '')
    {
        $default = $request->doc_share;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $request_department = $request->request_department;
        $request_type = $request->request_type;
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "income_date >= '$from_date' and income_date <= '$to_date'";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "income_date >= '$from_date'";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }
        // dd($selectQuery->skip(1300)->get());
        $doctor_income =  DB::select("select  person_no_pk, full_name, sum(total_appointment) total_appointment , sum(patient_free) patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) patient_new_paid, sum(total_patient_paid) total_patient_paid, sum(sur_amt) sur_amt, sum(lab_amt) lab_amt, sum(rad_amt) rad_amt, sum(ipd_service_amt) ipd_service_amt, sum(all_other_amt) all_other_amt, sum(sur_amt_count) sur_amt_count, sum(ipd_service_amt_count) ipd_service_amt_count, sum(total_admission_no) total_admission_no, sum(pathology_amt_count) pathology_amt_count, sum(radiology_amt_count) radiology_amt_count,  sum(sur_discount_amt ) as sur_discount_amt , sum(opd_discount_amt ) as opd_discount_amt , sum(ipd_discount_amt ) as ipd_discount_amt,sum(lab_dis_amt ) as lab_dis_amt,sum(rad_dis_amt ) as rad_dis_amt from finc_doctor_income_dt_vw   $sql_cond  group by  person_no_pk, full_name");

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
            $pdf = PDF::loadView("admin.reports.doctors.doctor_wish_commission_summery_pdf", ['default' => $default, 'doctor_income' => $doctor_income, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'request_type' => $request_type])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {
            $pdf = ['doctor_income' => $doctor_income, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'default' => $default, 'request_type' => $request_type];

            $fileToExport = "doctor_wish_income_summery_excel";
            $html = View("admin.reports.doctors.doctor_wish_commission_summery_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }


    public function doctorOpdConsultSummery()
    {
        $default = 10;
        $card_no = '';
        $month_def = 0;
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.reports.doctors.doctor_opd_consult_summary", ['default' => $default, 'card_no' => $card_no, 'serviceDepts' => $serviceDepts, 'month_def' => $month_def, 'start_time' => 0]);
    }
    public function doctorOPDSummerySearch(Request $request)
    {
        $default = $request->doc_share;
        $card_no = $request->card_hidn;
        $request_department = $request->request_department;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $doctor_income = [];
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());
        $datetime1 = date_create($from_date);
        $datetime2 = date_create($to_date);

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);

        // Printing result in years & months format
        $start_time = date("m", strtotime($request->date_pic));
        $month_def = $interval->format('%m') + 1;
        $doctor_income =  DB::select("select  person_no_pk, full_name,specialization from finc_doctor_income_dt_vw   $sql_cond  group by  person_no_pk, full_name,specialization");
        //, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt
        // $doctor_income =  DB::select("select  person_no_pk, full_name, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt from finc_doctor_income_dt_vw   $sql_cond  group by  person_no_pk, full_name");

        return Template::loadview("admin.reports.doctors.doctor_opd_consult_summary_list", ['default' => $default, 'doctor_income' => $doctor_income, 'card_no' => $card_no, 'month_def' => $month_def, 'start_time' => $start_time, 'from_date' => $from_date, 'to_date' => $to_date, 'sql_cond' => $sql_cond]);
    }

    public function doctorOPDSummerySearchPdf(Request $request, $id = '')
    {
        $default = $request->doc_share;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $request_department = $request->request_department;
        $sql_cond = "";
        if ($from_date != "" && $to_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd') and trunc(income_date) <= to_date('$to_date','yyyy-mm-dd')";
        } elseif ($from_date != "") {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "trunc(income_date) >= to_date('$from_date','yyyy-mm-dd')";
        }
        if ($card_no != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "person_no_pk = $card_no";
        }
        if ($request_department != '') {
            $sql_cond .= $sql_cond != "" ? "and " : "where ";
            $sql_cond .= "serviceunit_no_fk = $request_department";
        }
        // dd($selectQuery->skip(1300)->get());
        $datetime1 = date_create($from_date);
        $datetime2 = date_create($to_date);
        $interval = date_diff($datetime1, $datetime2);
        $start_time = date("m", strtotime($request->date_pic));
        $month_def = $interval->format('%m') + 1;
        $doctor_income =  DB::select("select  person_no_pk, full_name,specialization from finc_doctor_income_dt_vw   $sql_cond  group by  person_no_pk, full_name,specialization");

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
            $pdf = PDF::loadView("admin.reports.doctors.doctor_wise_opd_consultant_pdf", ['default' => $default, 'doctor_income' => $doctor_income, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'month_def' => $month_def, 'start_time' => $start_time, 'from_date' => $from_date, 'to_date' => $to_date, 'sql_cond' => $sql_cond])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {
            $pdf = ['default' => $default, 'doctor_income' => $doctor_income, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id, 'month_def' => $month_def, 'start_time' => $start_time, 'from_date' => $from_date, 'to_date' => $to_date, 'sql_cond' => $sql_cond];

            $fileToExport = "doctor_wish_income_summery_excel";
            $html = View("admin.reports.doctors.doctor_wise_opd_consultant_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function doctorIpdConsultSummery()
    {
        $default = 10;
        $card_no = '';
        $month_def = 0;
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.reports.doctors.doctor_ipd_consult_summary", ['default' => $default, 'card_no' => $card_no, 'serviceDepts' => $serviceDepts, 'month_def' => $month_def, 'start_time' => 0]);
    }
}
