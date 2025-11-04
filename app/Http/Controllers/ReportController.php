<?php

namespace App\Http\Controllers;

use App;
use PDF;
use PDO;
use Auth;
use Cache;
use DateTime;
use Exception;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\ItemType;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\Designation;
use App\Models\ServiceUnit;
use App\Traits\InvoiceData;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyTestEmail;
use Illuminate\Support\Facades\Storage;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;

class ReportController extends Controller
{
    use DatatablesLoader, InvoiceData, LookupData;

    public function __construct(
     ChartOfAccounts $chart_of_acc
    )
    {
        $this->middleware('auth');

        $this->chart_of_acc = $chart_of_acc;
    }


    public function financialReport()
    {
        $ref_doctors = DB::table('wl_referral_list_vw')->select('person_no_pk', 'full_name')->get();
        return Template::loadView("admin.reports.financial.financial", ['ref_doctors' => $ref_doctors]);
    }

    public function financialReportData(Request $request)
    {
        // return $request;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        //    return $request->date_from;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_voucherwise_vw   $sql_cond order by invoice_code DESC");
        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.financial.financial_table", ['report_data' => $report_data]);
    }

    public function reportInvoiceView($invoice_id)
    {
        // $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code","PAYMODE");

        $invoice_mst_info = DB::table("finc_voucherwise_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->first();

        // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();

        return Template::loadView("admin.reports.financial.invoice_view", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info]);
    }

    public function reportFinancialPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_voucherwise_vw $sql_cond order by invoice_code DESC");

        foreach ($report_data as $row) {

            $title = $row->invoice_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
        }




        //  return view("admin.reports.financial.financial_print_pdf", [
        //     'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details

        // ]);




        $pdf = PDF::loadView("admin.reports.financial.financial_print_pdf", [
            'report_data' => $report_data,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Financial-Invoice.pdf');
    }

    public function invoiceInfoAutocomplete(Request $request)
    {
        return $this->getInvoiceAutocompleteList($request);
    }
    public function invoiceInfoAutocompleteOp(Request $request)
    {
        return $this->getInvoiceAutocompleteListOp($request);
    }
    public function posInvoiceInfoAutocomplete(Request $request)
    {
        return $this->getPosInvoiceAutocompleteList($request);
    }
    public function cafeInvoiceInfoAutocomplete(Request $request)
    {
        return $this->getCafeInvoiceAutocompleteList($request);
    }

    public function appointmentInfoAutocomplete(Request $request)
    {
        return $this->getAppointmentAutocompleteList($request);
    }

    public function financialSummaryReport()
    {
        return Template::loadView("admin.reports.financial_summary.financial_summary");
    }

    public function financialSummaryReportData(Request $request)
    {

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));
        //dd()

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw $sql_cond order by invoice_date asc");
        // return $report_data;
        // dd($report_data);


        return Template::loadView("admin.reports.financial_summary.financial_summary_table", ['report_data' => $report_data]);
    }

    public function reportFinancialSummaryPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw $sql_cond order by invoice_date DESC");

        // DB::select("SELECT TO_CHAR(invoice_date, 'DD-MM-YYYY') invo_date, total_invoice_cnt,referral, total_consult_cnt, ledgerdtl_amt_discount_others, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others, ledgerdtl_amt_payment_consul, ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul,service_referral,no_of_service, ledgerdtl_amt_discount_service, (ledgerdtl_amt_sales_service + ledgerdtl_amt_sales_others) payable,discount,net_payable, (ledgerdtl_amt_payment_consul + ledgerdtl_amt_payment_service + ledgerdtl_amt_payment_others) paid, ((ledgerdtl_amt_sales_service + ledgerdtl_amt_sales_others) - (ledgerdtl_amt_discount_consul + ledgerdtl_amt_discount_service)) - (  ledgerdtl_amt_payment_consul + ledgerdtl_amt_payment_service + ledgerdtl_amt_payment_others) due
        //        FROM finc_summarystatement_dt_vw $sql_cond");

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

        $pdf = PDF::loadView("admin.reports.financial_summary.financial_summary_report", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no]);

        return $pdf->download('Financial-Summary-Invoice.pdf');
    }

    public function dailySalesReport()
    {
        $type = 'Sales';

        return Template::loadView("admin.reports.daily_report.daily_sales", ['type' => $type]);
    }

    public function dailyCollectionReport()
    {
        $type = 'Collection';
        return Template::loadView("admin.reports.daily_report.daily_collection", ['type' => $type]);
    }

    public function dailyDiscountReport()
    {
        $type = 'Discount';
        if (Session::get('user.ses_hospital_code') == 'IMPALA') {

            return Template::loadView("admin.reports.daily_report.daily_discount_impala", ['type' => $type]);
        } else {
            return Template::loadView("admin.reports.daily_report.daily_discount", ['type' => $type]);
        }
    }

    public function dailyReportData(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        //    $clause = ($sql_cond == "") ? " where" : " and";
        //    $sql_cond .= ($referral_id != "") ? " $clause doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $report_data = DB::select("SELECT invoice_no_fk,
			invoice_code,
			TO_CHAR (invoice_date, 'DD-MM-YYYY') invc_date,
			patient_no_fk,
			patient_code,
			patient_name,
			age,
			gender,
			mobile,

			ledgerdtl_amt_sales_consul,
			ledgerdtl_amt_sales_service,
			ledgerdtl_amt_sales_others,
			ledgerdtl_amt_sales_path,
			ledgerdtl_amt_sales_rad,
			ledgerdtl_amt_sales_hos,
			ledgerdtl_amt_sales_amb,

			ledgerdtl_amt_payment_amb,
			ledgerdtl_amt_payment_consul,
			ledgerdtl_amt_payment_hos,
			ledgerdtl_amt_payment_others,
			ledgerdtl_amt_payment_path,
			ledgerdtl_amt_payment_rad,
			ledgerdtl_amt_payment_service,

			ledgerdtl_amt_discount_amb,
			ledgerdtl_amt_discount_consul,
			ledgerdtl_amt_discount_hos,
			ledgerdtl_amt_discount_others,
			ledgerdtl_amt_discount_path,
			ledgerdtl_amt_discount_rad,
			ledgerdtl_amt_discount_service,
            item_name_list


			FROM finc_financialstatement_dtl_vw $sql_cond and module_no_fk <>3 order by invoice_code DESC");

        // dd($report_data);
        if (Session::get('user.ses_hospital_code') == 'IMPALA') {
            return Template::loadView("admin.reports.daily_report.daily_report_table_impala", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details,  'type' => $type]);
        } else {
            return Template::loadView("admin.reports.daily_report.daily_report_table", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details,  'type' => $type]);
        }
    }

    public function reportDailyPrint(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        //    $clause = ($sql_cond == "") ? " where" : " and";
        //    $sql_cond .= ($referral_id != "") ? " $clause doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $report_data = DB::select("SELECT invoice_no_fk,
			invoice_code,
			TO_CHAR (invoice_date, 'DD-MM-YYYY') invc_date,
			patient_no_fk,
			patient_code,
			patient_name,
			age,
			gender,
			mobile,

			ledgerdtl_amt_sales_consul,
			ledgerdtl_amt_sales_service,
			ledgerdtl_amt_sales_others,
			ledgerdtl_amt_sales_path,
			ledgerdtl_amt_sales_rad,
			ledgerdtl_amt_sales_hos,
			ledgerdtl_amt_sales_amb,

			ledgerdtl_amt_payment_amb,
			ledgerdtl_amt_payment_consul,
			ledgerdtl_amt_payment_hos,
			ledgerdtl_amt_payment_others,
			ledgerdtl_amt_payment_path,
			ledgerdtl_amt_payment_rad,
			ledgerdtl_amt_payment_service,

			ledgerdtl_amt_discount_amb,
			ledgerdtl_amt_discount_consul,
			ledgerdtl_amt_discount_hos,
			ledgerdtl_amt_discount_others,
			ledgerdtl_amt_discount_path,
			ledgerdtl_amt_discount_rad,
			ledgerdtl_amt_discount_service,
            item_name_list


			FROM finc_financialstatement_dtl_vw $sql_cond and module_no_fk <>3 order by invoice_code ASC");

        //    $type = $request->type;
        // return $type;
        // dd($report_data);
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_no_fk, patient_code, patient_name, age, gender, mobile, ledgerdtl_amt_sales_consul, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others,ledgerdtl_amt_payment_consul,ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul, ledgerdtl_amt_discount_service, ledgerdtl_amt_discount_others FROM finc_financialstatement_dtl_vw");
        if (Session::get('user.ses_hospital_code') == 'IMPALA') {
            $pdf = PDF::loadView("admin.reports.daily_report.daily_sales_print_impala", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
        } else {
            $pdf = PDF::loadView("admin.reports.daily_report.daily_sales_print", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
        }


        return $pdf->download('Daily-Invoice.pdf');
    }

    public function dailyPatientAppointmentReport()
    {
        return Template::loadView("admin.reports.daily_report.daily_appointment_patient");
    }

    public function dailyPatientAppointmentReportData(Request $request)
    {
        // return $request;
        $appointment_id = $request->appointment_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $date_from = date('d-m-Y', strtotime($request->date_from));
        $date_to = date('d-m-Y', strtotime($request->date_to));

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_pk=$patient_id" : "";
        $sql_cond .= ($appointment_id != "") ? " $clause appoint_code=$appointment_id" : "";
        $sql_cond .= ($referral_id != "") ? " $clause doctor_no_fk=$referral_id" : "";
        // $sql_cond .= ($date_from!="")? " $clause invoice_date between $date_from and $date_to":"";

        $report_data = DB::select("SELECT appoint_code, TO_CHAR(appoint_date, 'DD-MON-RR') appoint_date, patient_no_pk, patient_code, patient_name, age, gender_txt, mobile1, doctor_no_fk, full_name, phone_mobile, specialization, cancel_ind, chif_complain FROM wl_patn_appointment_vw $sql_cond");
        // return $report_data;

        return Template::loadView("admin.reports.daily_report.daily_appointment_patient_table", ['report_data' => $report_data]);
    }

    public function dailyPatientAppointmentPrint()
    {
        // return $type;

        $report_data = DB::select("SELECT appoint_code, TO_CHAR(appoint_date, 'DD-MON-RR') appoint_date, patient_no_pk, patient_code, patient_name, age, gender_txt, mobile1, doctor_no_fk, full_name, phone_mobile, specialization, cancel_ind, chif_complain FROM wl_patn_appointment_vw");

        $pdf = PDF::loadView("admin.reports.daily_report.daily_appointment_patient_print", ['report_data' => $report_data]);

        return $pdf->download('Daily-Appointment-Patient-Report.pdf');
    }

    public function doctorWiseDailyAppointment()
    {
        $data = DB::select("select a . doctor_no_fk,a . appoint_date, a . doctor_name,
			sum(case when a . appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new,
			sum(case when a . appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup
			from doctor_wise_appoint_consult_vw a
			group by  a . doctor_no_fk,a . appoint_date,a . doctor_name");
        return Template::loadview("admin.reports.daily_report.doctor_wise_daily_appointment", ['value' => $data]);
    }

    public function doctorWiseDailyAppointmentPopUp($appointment_data)
    {
        $data = explode("_", $appointment_data);
        $appointment_date = $data[0];
        $appointment_doctor_no_fk = $data[1];
        $appointment_appoint_type = $data[2];
        $data = DB::select("select a.patient_name,a.age,a.gender_txt,a.chif_complain from doctor_wise_appoint_consult_vw a where (a.appoint_date='$appointment_date' and a.doctor_no_fk='$appointment_doctor_no_fk') and a.appoint_type_code='$appointment_appoint_type'");
        $type = "1";
        return Template::loadview("admin.reports.daily_report.doctor_wise_daily_appointment_popup", ["value" => $data, "appointment_data" => $appointment_data, "type" => $type]);
    }

    public function doctorWiseDailyConsultation()
    {
        $today = date("d-m-Y");
        $doctorWiseDailyConsultation = DB::select("select a.doctor_no_fk, trunc(a.appoint_date) appoint_date,a.full_name doctor_name, count(a.appoint_no_pk ) total_appointment, sum( b.ledger_amt_sales ) amount from patn_appointment_vw a
			join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk
			where trunc(a.appoint_date)=TO_DATE('$today','dd/mm/yyyy')
			group by a.appoint_date,a.full_name, a.doctor_no_fk order by a.full_name asc");
        return Template::loadview("admin.reports.daily_report.doctorWiseDailyConsultation", ['doctorWiseDailyConsultation' => $doctorWiseDailyConsultation]);
    }

    public function doctorWiseDailyConsultationSearch(Request $request)
    {
        $appoint_date_from = date("d-m-Y", strtotime($request->appointment_date_from));
        $appoint_date_to = date("d-m-Y", strtotime($request->appointment_date_to));
        $doctor_id = $request->doctor_id;
        $doctor_name = $request->doctor_name;

        $date_cond_from = ($request->appointment_date_from != "") ? "and a.APPOINT_DATE between to_date('$appoint_date_from','dd/mm/yyyy') AND to_date('$appoint_date_to', 'dd/mm/yyyy')" : "";
        // $date_cond_to = ($request->appointment_date_to !="")?" and trunc(a.appoint_date)=TO_DATE('$appoint_date_to','dd/mm/yyyy')":"";
        $doctor_cond = ($request->doctor_name != "") ? " and DOCTOR_NO_FK=$doctor_id" : "";

        $doctorWiseDailyConsultation = DB::select("select a.doctor_no_fk, trunc(a.appoint_date) appoint_date,a.full_name doctor_name, count(a.appoint_no_pk ) total_appointment, sum( b.ledger_amt_sales ) amount from patn_appointment_vw a join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk where a.status=1 $date_cond_from $doctor_cond group by a.doctor_no_fk, a.appoint_date,a.full_name order by a.full_name asc");
        return Template::loadview("admin.reports.daily_report.doctor_wise_daily_consultation_list", ['doctorWiseDailyConsultation' => $doctorWiseDailyConsultation]);
    }

    public function doctorWiseDailyConsultationPopUp($appointment_data)
    {
        $data = explode("_", $appointment_data);
        $appointment_date = $data[0];
        $appointment_doctor_no_fk = $data[1];

        $data = DB::select("select b.patient_name,b.age,b.gender_txt,a.chif_complain from patn_appointment_vw a join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk where (a.appoint_date='$appointment_date' and a.doctor_no_fk='$appointment_doctor_no_fk')");
        $type = "2";
        return Template::loadview("admin.reports.daily_report.doctor_wise_daily_appointment_popup", ["value" => $data, "appointment_data" => $appointment_data, "type" => $type]);
    }

    public function doctorWiseDailyConsultationPrint(request $request)
    {

        $appoint_date_from = date("d-m-Y", strtotime($request->appointment_date_from));
        $appoint_date_to = date("d-m-Y", strtotime($request->appointment_date_to));
        $today = date("d-m-Y");
        $doctor_id = $request->doctor_id;
        $doctor_name = $request->doctor_name;

        $date_cond_from = ($request->appointment_date_from != "") ? "and a.APPOINT_DATE between to_date('$appoint_date_from','dd/mm/yyyy') AND to_date('$appoint_date_to', 'dd/mm/yyyy')" : "";

        $doctor_cond = ($request->doctor_name != "") ? " and DOCTOR_NO_FK=$doctor_id" : "";

        $print_data = DB::select("select a.doctor_no_fk, trunc(a.appoint_date) appoint_date,a.full_name doctor_name, count(a.appoint_no_pk ) total_appointment, sum( b.ledger_amt_sales ) amount from patn_appointment_vw a join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk where a.status=1 $date_cond_from $doctor_cond group by a.doctor_no_fk, a.appoint_date,a.full_name order by a.full_name asc");
        $pdf = PDF::loadView("admin.reports.daily_report.doctor-wise-daily-consultation-print", ['print_data' => $print_data]);
        return $pdf->download('Doctor-wise-patient-consultation.pdf');
    }


    //PDF Genenrate
    public function ReportDoctorWisePatientApoinment()
    {
        $report_data = DB::select("select a . appoint_date, a . doctor_name,
			(case when a . appoint_type_code = 'NEWCONS' then count(a . appoint_no_pk) else 0 end) total_new,
			(case when a . appoint_type_code = 'FOLLOWUP' then count(a . appoint_no_pk) else 0 end) total_followup
			from doctor_wise_appoint_consult_vw a
			group by a . appoint_date,a . doctor_name,a . appoint_type_code");
        $pdf = PDF::loadView("admin.reports.daily_report.doctor_wise_daily_report_appointment", ['report_data' => $report_data]);

        return $pdf->download('Doctor-wise-patient-apoinment.pdf');
    }

    // public function getAllDoctorWiseDailyConsultation (Request $request){

    //  $columns = array(
    //      'sl',
    //      'appoint_date',
    //      'doctor_name',
    //      'total_appointment',
    //      'amount',
    //      'APPOINT_NO_PK'
    //    );

    //    $sql = "SELECT '' as sl, a . appoint_date,a . full_name doctor_name, count(a . appoint_no_pk) total_appointment, sum(b . ledger_amt_sales) amount, APPOINT_NO_PK
    //    from patn_appointment_vw a
    //    join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk
    //    group by a.appoint_date,a.full_name
    //    ";
    //    $order_by_column = "APPOINT_NO_PK";

    //    $json_data = $this->datatable( $request, $sql, $order_by_column, 'desc', $columns);

    //    echo json_encode($json_data);


    // }

    public function doctorWiseDailyAppointmentSearch(Request $request)
    {
        $doctor_id = $request->doctor_id;
        $doctor_name = $request->doctor_name;
        $from_date = date("d-m-Y", strtotime($request->appointment_date_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_date_to));


        //When Condition for Search Query..
        /*
		   $doctor_wise_daily_appointment_query = DB::table("doctor_wise_appoint_consult_vw")
			   ->select('doctor_no_fk', 'appoint_date', 'doctor_name', DB::raw("sum(case when appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup"))
			   ->where("status", "=", 1);
		   if ($doctor_id != "") {
			   $doctor_wise_daily_appointment_query->when($doctor_id, function ($query, $doctor_id) {
				   return $query->where('doctor_no_fk', $doctor_id);
			   });
		   }
		   $doctor_wise_daily_appointment_query->when($request, function($query) use ($request) {
			   $from_date = date("d-m-Y", strtotime($request->appointment_date_form));
			   $to_date = date("d-m-Y", strtotime($request->appointment_date_to));
			   return $query->where(DB::raw("appoint_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')"));
		   });

		   $doctorWiseDailyAppointment = $doctor_wise_daily_appointment_query->toSql();
		   dd($doctorWiseDailyAppointment);
				$doctorWiseDailyAppointment = DB::table("doctor_wise_appoint_consult_vw")
					   ->select('doctor_no_fk', 'appoint_date', 'doctor_name')
					   ->where("status", 1)
					   ->when($request->appointment_date_form, function ($query) use ($from_date, $to_date) {
						   return $query->whereBetween('appoint_date', [$from_date, $to_date]);
					   })
					   ->when($request->$doctor_name, function ($query) use ($request) {
						   return $query->where('DOCTOR_NO_FK', $request->doctor_name);
					   })->groupBy('doctor_no_fk', 'appoint_date', 'doctor_name')
					   ->get();  */
        //Not Required
        $date_cond = ($request->appointment_date_form != "") ? " and a.appoint_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $doctor_cond = ($request->doctor_name != "") ? " and DOCTOR_NO_FK=$doctor_id" : "";
        $doctorWiseDailyAppointment = DB::select("select a.doctor_no_fk,a.appoint_date,A.START_TIME,A.END_TIME, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1  group by  a.doctor_no_fk,a.appoint_date,a.doctor_name,A.START_TIME,A.END_TIME");


        return Template::loadview("admin.reports.daily_report.doctor_wise_daily_appointment_list", ['value' => $doctorWiseDailyAppointment]);
    }

    public function doctorWiseDailyAppointmentPrint(Request $request)
    {


        $data = explode("_", $request->input("appointment_data"));
        if ($request->input("type") == "1") {
            $appointment_date = $data[0];
            $appointment_doctor_no_fk = $data[1];
            $appointment_appoint_type = $data[2];
            $report_data = DB::select("select a.patient_name,a.age,a.gender_txt,a.chif_complain,a.slot_sl,a.appoint_code,a.doctor_name,a.appoint_date from doctor_wise_appoint_consult_vw a where (a.appoint_date='$appointment_date' and a.doctor_no_fk='$appointment_doctor_no_fk') and a.appoint_type_code='$appointment_appoint_type' order by a.slot_sl ");
        } else {
            $appointment_date = $data[0];
            $appointment_doctor_no_fk = $data[1];
            $report_data = DB::select("select b.patient_name,b.age,b.gender_txt,a.chif_complain,a.slot_sl,a.appoint_code,a.full_name as doctor_name,a.appoint_date from patn_appointment_vw a join finc_invoicemst_sum_vw b on a.appoint_no_pk=b.appoint_service_no_fk where (a.appoint_date='$appointment_date' and a.doctor_no_fk='$appointment_doctor_no_fk')");
        }

        $pdf = PDF::loadView("admin.reports.daily_report.doctor_wise_daily_report_appointment_list_pdf", ['report_data' => $report_data, 'data' => $data[0]]);

        return $pdf->download('Doctor-wise-patient-appointment-list.pdf');
    }


    public function dailyAttendanceReport()
    {
        // dd(Session::get('user.ses_hospital_code'));
        $to_date = date('d-m-Y');
        // $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

        $dept = DB::select("select distinct unit.serviceunit_no_pk, serviceunit_name, serviceunit_code
        from sysc_serviceunit unit,hrms_personnel per
        where unit.serviceunit_no_pk=per.serviceunit_no_fk
        order by serviceunit_name");
        // dd($dept);

        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";


        if (Session::get('user.ses_hospital_code') == 'EWMCH' || Session::get('user.ses_hospital_code') == 'AMCSH' || Session::get('user.ses_hospital_code') == 'IMPERIAL' || Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL' || Session::get('user.ses_hospital_code') == 'IMPALA') {
            $dailAttendanceReportSearch = DB::select("select a.entry_type, a.early_time_min, a.attendance_date
            ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
            a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
            , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
            from hrms_attendance_daily a
            left join hrms_personnel b ON b.person_code = a.person_card_no
            left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
            left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
            left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
            left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
            where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
            on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
            where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond order by trunc(ATTENDANCE_DATE) desc");

            return Template::loadview("admin.reports.hrm.daily_attendance_report_ewmch", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch, 'dept' => $dept, 'desig' => $desig]);
        } else {
            $dailAttendanceReportSearch = DB::select("select a.entry_type, a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min, jobtype.lookupdata_desc, a.lunch_in_time,a.lunch_out_time ,a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk  left join sysc_lookupdata jobtype on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where person_card_no IS NOT NULL and  a.attendance_date =to_date('$to_date','DD-MM-YYYY') and nvl(b.virtual_ind,0)=0  order by jobtype.serial_no, a.person_card_no asc ");
            // $dailAttendanceReportSearch = DB::select("select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,
            // a.lunch_in_time,a.lunch_out_time ,a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where  person_card_no IS NOT NULL and  a.attendance_date =to_date('$to_date','DD-MM-YYYY') and nvl(b.virtual_ind,0)=0  ");

            return Template::loadview("admin.reports.hrm.daily_attendance_report", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch, 'dept' => $dept, 'desig' => $desig]);
        }
    }


    public function new_daily_statement(Request $request)
    {
        $date = date("Y-m-d");

        $from_date = isset($request->date_pic) ? date("Y-m-d", strtotime($request->date_pic)) : date("Y-m-d");
        $to_date = isset($request->date_pic2) ? date("Y-m-d", strtotime($request->date_pic2)) : date("Y-m-d");

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        if (date("Y-m-d", strtotime($date)) >= date("Y-m-d", strtotime($from_date)) && date("Y-m-d", strtotime($date)) <= date("Y-m-d", strtotime($to_date))) {
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("begin prc_dialy_statement_data_pop(:in_trans_date); end;");
            $stmt->bindParam(':in_trans_date', $date);
            $stmt->execute();
        }



        $ipd_currentday_statement = DB::select("SELECT NVL(ward,'Not Specified') ward,to_char(sum(previous_patient)) previous_patient,
        to_char(sum(admission)) admission, to_char(sum(discharge)) discharge,
        to_char(sum(present_p)) present_p
        FROM DSTMT_IPD_ADMITTED_PATLIST
        where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        group by ward");

        $ipd_patients = [];
        foreach ($ipd_currentday_statement as $records) {
            array_push($ipd_patients, [
                'ward' => $records->ward,
                'previous_patient' => (int)$records->previous_patient,
                'admission' => (int)$records->admission,
                'discharge' => (int)$records->discharge
            ]);
        }
        // dd($ipd_patients);

        $result = array_reduce($ipd_patients, function ($carry, $item) {
            if (!isset($carry[$item['ward']])) {
                $carry[$item['ward']] = [
                    'ward' => $item['ward'],
                    'previous_patient' => $item['previous_patient'],
                    'admission' => $item['admission'],
                    'discharge' => $item['discharge']
                ];
            } else {
                $carry[$item['ward']]['previous_patient'] += $item['previous_patient'];
                $carry[$item['ward']]['admission'] += $item['admission'];
                $carry[$item['ward']]['discharge'] += $item['discharge'];
            }
            return $carry;
        });

        $opd_statement = DB::select("SELECT department, sum(new_patient) new_patient,sum(old_patient) old_patient,sum(night_patient) night_patient
                                        FROM DSTMT_DEPT_PATIENT
                                        where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                        group by department");


        $daily_group_income_statement = DB::select("SELECT item_type_head,sum(total_collection) total_collection
                                                    FROM DSTMT_ITEM_TYPE_HEAD_COLL
                                                    where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                                    group by item_type_head");

        $daily_income_statement = DB::select("SELECT item_type_head,nvl(serviceunit_name,'Not Defined') serviceunit_name,sum(total_collection) total_collection
                                                FROM DSTMT_ITEM_TYPE_HEAD_SU_COLL
                                                where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                                group by item_type_head,serviceunit_name");

        $zakat_fund_muslim = DB::select("SELECT CASE
        WHEN general_acc IN ('General A/C','Pharmacy A/C')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C'
        END  general_acc
    , to_char(sum(muslim)) muslim, '' non_muslim
    FROM DSTMT_ZAKAT_FUND_MUSLIM
    WHERE TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
    group by general_acc");

        $zakat_fund_non_muslim = DB::select("SELECT CASE
        WHEN general_acc IN ('General A/C','Pharmacy A/C')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C'
        END  general_acc
    , '' muslim, to_char(sum(non_muslim)) non_muslim
    FROM DSTMT_ZAKAT_FUND_NONMUSLIM
    WHERE TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
    group by general_acc");



        $zakat_fund_arr = [];

        if (!empty($zakat_fund_muslim)) {
            foreach ($zakat_fund_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['ISLAM'] = isset($zakat_fund_arr[$zakat->general_acc]['ISLAM']) ? $zakat_fund_arr[$zakat->general_acc]['ISLAM'] + $zakat->muslim : $zakat->muslim;
            }
        }
        if (!empty($zakat_fund_non_muslim)) {
            foreach ($zakat_fund_non_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['OTHERS'] = isset($zakat_fund_arr[$zakat->general_acc]['OTHERS']) ? $zakat_fund_arr[$zakat->general_acc]['OTHERS'] + $zakat->non_muslim : $zakat->non_muslim; //$zakat->non_muslim;
            }
        }

        return Template::loadview("admin.reports.financial.new_daily_statement", [
            'zakat_fund_arr' => $zakat_fund_arr,
            'group_records' => $result,
            'opd_statement' => $opd_statement,
            'daily_income_statement' => $daily_income_statement,
            'daily_group_income_statement' => $daily_group_income_statement,
            'zakat_fund_muslim' => $zakat_fund_muslim,
            'zakat_fund_non_muslim' => $zakat_fund_non_muslim,
            'hospital_info' => $hospital_info
        ]);
    }


    public function search_new_daily_statement(Request $request)
    {
        $date = date("Y-m-d");

        $from_date = isset($request->date_pic) ? date("Y-m-d", strtotime($request->date_pic)) : date("Y-m-d");
        $to_date = isset($request->date_pic2) ? date("Y-m-d", strtotime($request->date_pic2)) : date("Y-m-d");

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        if (date("Y-m-d", strtotime($date)) >= date("Y-m-d", strtotime($from_date)) && date("Y-m-d", strtotime($date)) <= date("Y-m-d", strtotime($to_date))) {

            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("begin prc_dialy_statement_data_pop(:in_trans_date); end;");
            $stmt->bindParam(':in_trans_date', $date);
            $stmt->execute();
        }



        $ipd_currentday_statement = DB::select("
        select NVL(ward_name,'Not Specified') word,to_char(count(admission_no_pk)) previous_patient,'' admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) < TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,to_char(count(admission_no_pk)) admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,'' admission, to_char(count(admission_no_pk)) discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(dis_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        and dis_ind = 1
        group by ward_name

        ");

        // DB::select("SELECT NVL(ward,'Not Specified') ward,to_char(sum(previous_patient)) previous_patient,
        //                                             to_char(sum(admission)) admission, to_char(sum(discharge)) discharge,
        //                                             to_char(sum(present_p)) present_p
        //                                             FROM DSTMT_IPD_ADMITTED_PATLIST
        //                                             where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //                                             group by ward");
        $ipd_patients = [];
        foreach ($ipd_currentday_statement as $records) {
            array_push($ipd_patients, [
                'ward' => $records->word,
                'previous_patient' => (int)$records->previous_patient,
                'admission' => (int)$records->admission,
                'discharge' => (int)$records->discharge
            ]);
        }


        $result = array_reduce($ipd_patients, function ($carry, $item) {
            if (!isset($carry[$item['ward']])) {
                $carry[$item['ward']] = [
                    'ward' => $item['ward'],
                    'previous_patient' => $item['previous_patient'],
                    'admission' => $item['admission'],
                    'discharge' => $item['discharge']
                ];
            } else {
                $carry[$item['ward']]['previous_patient'] += $item['previous_patient'];
                $carry[$item['ward']]['admission'] += $item['admission'];
                $carry[$item['ward']]['discharge'] += $item['discharge'];
            }
            return $carry;
        });

        $opd_statement = DB::select("SELECT department, sum(new_patient) new_patient,sum(old_patient) old_patient,sum(night_patient) night_patient
                                        FROM DSTMT_DEPT_PATIENT
                                        where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                        group by department");

        // DSTMT_ITEM_TYPE_HEAD_COLL
        $daily_group_income_statement = DB::select("SELECT item_type_head,sum(total_collection) total_collection
                                                        FROM DSTMT_ITEM_TYPE_HEAD_COLL
                                                        where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                                        group by item_type_head");

        $daily_income_statement = DB::select("SELECT item_type_head,nvl(serviceunit_name,'Not Defined') serviceunit_name,sum(total_collection) total_collection
                                                    FROM DSTMT_ITEM_TYPE_HEAD_SU_COLL
                                                    where TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                                                    group by item_type_head,serviceunit_name");

        $zakat_fund_muslim = DB::select("SELECT CASE
            WHEN general_acc = 'General A/C'
            THEN
                'General A/C'
            ELSE
                'Pharmacy A/C'
            END  general_acc
        , to_char(sum(muslim)) muslim, '' non_muslim
        FROM DSTMT_ZAKAT_FUND_MUSLIM
        WHERE TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        group by general_acc");

        $zakat_fund_non_muslim = DB::select("SELECT CASE
            WHEN general_acc = 'General A/C'
            THEN
                'General A/C'
            ELSE
                'Pharmacy A/C'
            END  general_acc
        , '' muslim, to_char(sum(non_muslim)) non_muslim
        FROM DSTMT_ZAKAT_FUND_NONMUSLIM
        WHERE TRUNC(TRANS_DATE) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        group by general_acc");


        $zakat_fund_arr = [];

        if (!empty($zakat_fund_muslim)) {
            foreach ($zakat_fund_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['ISLAM'] = isset($zakat_fund_arr[$zakat->general_acc]['ISLAM']) ? $zakat_fund_arr[$zakat->general_acc]['ISLAM'] + $zakat->muslim : $zakat->muslim;
            }
        }
        if (!empty($zakat_fund_non_muslim)) {
            foreach ($zakat_fund_non_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['OTHERS'] = isset($zakat_fund_arr[$zakat->general_acc]['OTHERS']) ? $zakat_fund_arr[$zakat->general_acc]['OTHERS'] + $zakat->non_muslim : $zakat->non_muslim; //$zakat->non_muslim;
            }
        }

        return Template::loadview("admin.reports.financial.new_daily_statement_list", [
            'zakat_fund_arr' => $zakat_fund_arr,
            'group_records' => $result,
            'opd_statement' => $opd_statement,
            'daily_income_statement' => $daily_income_statement,
            'daily_group_income_statement' => $daily_group_income_statement,
            'zakat_fund_muslim' => $zakat_fund_muslim,
            'zakat_fund_non_muslim' => $zakat_fund_non_muslim,
            'hospital_info' => $hospital_info
        ]);
    }


    public function dailyStatement()
    {

        $to_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime('-1 Day'));

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        // dd($from_date);
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();

        // echo " select NVL(ward_name,'Not Specified') word,to_char(count(admission_no_pk)) previous_patient,'' admission, '' discharge, '' present_p
        // from IPD_ADMITTED_PATLIST_VW
        // where  TRUNC(admission_date) < TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) and  dis_ind = 0
        // group by ward_name";die;
        $ipd_currentday_statement = DB::select("
        select NVL(ward_name,'Not Specified') word,to_char(count(admission_no_pk)) previous_patient,'' admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where  TRUNC(admission_date) < TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) and  dis_ind = 0
        and EMERGENCY_DAYCARE_IND_TXT is null
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,to_char(count(admission_no_pk)) admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
         AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
         and EMERGENCY_DAYCARE_IND_TXT is null
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,'' admission, to_char(count(admission_no_pk)) discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(dis_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        and dis_ind = 1
        and EMERGENCY_DAYCARE_IND_TXT is null
        group by ward_name");
        // TRUNC(dis_date) <= TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))



        $ipd_patients = [];
        foreach ($ipd_currentday_statement as $records) {
            array_push($ipd_patients, [
                'word' => $records->word,
                'previous_patient' => (int)$records->previous_patient,
                'admission' => (int)$records->admission,
                'discharge' => (int)$records->discharge
            ]);
        }


        $result = array_reduce($ipd_patients, function ($carry, $item) {
            if (!isset($carry[$item['word']])) {
                $carry[$item['word']] = [
                    'word' => $item['word'],
                    'previous_patient' => $item['previous_patient'],
                    'admission' => $item['admission'],
                    'discharge' => $item['discharge']
                ];
            } else {
                $carry[$item['word']]['previous_patient'] += $item['previous_patient'];
                $carry[$item['word']]['admission'] += $item['admission'];
                $carry[$item['word']]['discharge'] += $item['discharge'];
            }
            return $carry;
        });



        // $opd_statement = DB::select("
        //             select NVL(su_name,'Not Defined') department,to_char(sum(patient_followup_total)) old_patient,'' new_patient, '' night_patient
        //             from FINC_DOCTOR_INCOME_DT_VW
        //             where TRUNC(income_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by su_name
        //             UNION ALL
        //             select NVL(su_name,'Not Defined') department,'' old_patient,to_char(sum(patient_new_total)) new_patient, '' night_patient
        //             from FINC_DOCTOR_INCOME_DT_VW
        //             where TRUNC(income_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by su_name");

        // $opd_patients = [];

        // foreach ($opd_statement as $records) {
        //     array_push($opd_patients, [
        //         'department' => $records->department,
        //         'new_patient' => (int)$records->new_patient,
        //         'old_patient' => (int)$records->old_patient
        //     ]);
        // }


        // $opd_result = array_reduce($opd_patients, function ($carry, $item) {
        //     if (!isset($carry[$item['department']])) {
        //         $carry[$item['department']] = [
        //             'department' => $item['department'],
        //             'new_patient' => $item['new_patient'],
        //             'old_patient' => $item['old_patient']
        //         ];
        //     } else {
        //         $carry[$item['department']]['new_patient'] += $item['new_patient'];
        //         $carry[$item['department']]['old_patient'] += $item['old_patient'];
        //     }
        //     return $carry;
        // });

        $opd_statement = DB::table('finc_c023_daily_count_stmt_vw')->where('income_date', date('Y-m-d'))->get();
        // FINC_C023_DAILY_COLL_STMT_VW
        $daily_group_income_statement = DB::select("
                    select item_type_head,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head
                    order by item_type_head asc
                    ");


        $daily_income_statement = DB::select("
                    select item_type_head,nvl(serviceunit_name,'Not Defined') serviceunit_name,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head,serviceunit_name
                    order by item_type_head,serviceunit_name asc
                    ");

        $zakat_fund_muslim =
            DB::select(
                "SELECT CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  general_acc,

                     SUM ( case when PERSON_CODE in ('ZAKATFUND','DIRECTORFUND')   then DISC_AMT_BY_HOSP else 0 end) muslim,
                       SUM ( case when PERSON_CODE='NONMUSLIMFUND'   then DISC_AMT_BY_HOSP else 0 end) non_muslim
                   FROM FINC_LEDGERMST mst
                        JOIN HRMS_PERSONNEL hp
                           ON mst.DISC_AMT_BY_HOSP_AUTH_BY = hp.PERSON_NO_PK
                           join sysc_module mod
                           on mod.MODULE_NO_PK=mst.MODULE_NO_fK
                  WHERE PERSON_CODE IN
                           ('ZAKATFUND', 'DIRECTORFUND', 'NONMUSLIMFUND')
                             and trunc(LEDGER_DATE) between to_date('$to_date','YYYY-MM-DD') and to_date('$to_date','YYYY-MM-DD')
              GROUP BY CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  "
            );
        // DB::select(
        //     "select  CASE
        //     WHEN MODULE_CODE IN ('PHR','PHR-I')
        //     THEN
        //         'Pharmacy A/C'
        //     ELSE
        //         'General A/C '
        // END  general_acc
        // , to_char(sum(zakatfund)) muslim, '' non_muslim
        //             from finc_c022_sum_amount_zakat_vw
        //             where fund_type = 'ZAKATFUND' and  zakatfund !=0
        //             and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by CASE
        //                       WHEN MODULE_CODE IN ('PHR','PHR-I')
        //                       THEN
        //                           'Pharmacy A/C'
        //                       ELSE
        //                           'General A/C '
        //                   END "
        // );
        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");
        $zakat_fund_arr = [];
        if (!empty($zakat_fund_muslim)) {
            foreach ($zakat_fund_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['ISLAM'] = isset($zakat_fund_arr[$zakat->general_acc]['ISLAM']) ? $zakat_fund_arr[$zakat->general_acc]['ISLAM'] + $zakat->muslim : $zakat->muslim;
            }
        }
        if (!empty($zakat_fund_non_muslim)) {
            foreach ($zakat_fund_non_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['OTHERS'] = isset($zakat_fund_arr[$zakat->general_acc]['OTHERS']) ? $zakat_fund_arr[$zakat->general_acc]['OTHERS'] + $zakat->non_muslim : $zakat->non_muslim; //$zakat->non_muslim;
            }
        }



        // $zakat_fund_non_muslim = DB::select("select '' general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
        //             from finc_c022_sum_amount_zakat_vw
        //             where religion_txt != 'Islam'

        //             and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))");

        // echo "select '' general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
        // from finc_c022_sum_amount_zakat_vw
        // where religion_txt != 'Islam'
        // and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))";

        return Template::loadview("admin.reports.financial.daily_statement", ['zakat_fund_arr' => $zakat_fund_arr, 'group_records' => $result, 'opd_statement' => $opd_statement, 'daily_income_statement' => $daily_income_statement, 'daily_group_income_statement' => $daily_group_income_statement, 'zakat_fund_muslim' => $zakat_fund_muslim, 'zakat_fund_non_muslim' => $zakat_fund_non_muslim, 'hospital_info' => $hospital_info]);
    }

    public function dailyStatementSearch(Request $request)
    {
        ini_set("max_execution_time", -1);
        $from_date = date("Y-m-d", strtotime($request->date_pic));
        $from_date1 = date("Y-m-d", strtotime('-1 day', strtotime($from_date)));

        $to_date = date("Y-m-d", strtotime($request->date_pic2));

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $ipd_currentday_statement = DB::select("
        select NVL(ward_name,'Not Specified') word,to_char(count(admission_no_pk)) previous_patient,'' admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) < TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,to_char(count(admission_no_pk)) admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,'' admission, to_char(count(admission_no_pk)) discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(dis_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        and dis_ind = 1
        group by ward_name

        ");

        $ipd_patients = [];
        foreach ($ipd_currentday_statement as $records) {
            array_push($ipd_patients, [
                'word' => $records->word,
                'previous_patient' => (int)$records->previous_patient,
                'admission' => (int)$records->admission,
                'discharge' => (int)$records->discharge
            ]);
        }


        $result = array_reduce($ipd_patients, function ($carry, $item) {
            if (!isset($carry[$item['word']])) {
                $carry[$item['word']] = [
                    'word' => $item['word'],
                    'previous_patient' => $item['previous_patient'],
                    'admission' => $item['admission'],
                    'discharge' => $item['discharge']
                ];
            } else {
                $carry[$item['word']]['previous_patient'] += $item['previous_patient'];
                $carry[$item['word']]['admission'] += $item['admission'];
                $carry[$item['word']]['discharge'] += $item['discharge'];
            }
            return $carry;
        });


        // $opd_statement = DB::select("
        // select NVL(su_name,'Not Defined') department,to_char(sum(patient_followup_total)) old_patient,'' new_patient, '' night_patient
        //             from FINC_DOCTOR_INCOME_DT_VW
        //             where TRUNC(income_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by su_name
        //             UNION ALL
        //             select NVL(su_name,'Not Defined') department,'' old_patient,to_char(sum(patient_new_total)) new_patient, '' night_patient
        //             from FINC_DOCTOR_INCOME_DT_VW
        //             where TRUNC(income_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by su_name");

        // $opd_patients = [];

        // foreach ($opd_statement as $records) {
        //     array_push($opd_patients, [
        //         'department' => $records->department,
        //         'new_patient' => (int)$records->new_patient,
        //         'old_patient' => (int)$records->old_patient
        //     ]);
        // }


        // $opd_result = array_reduce($opd_patients, function ($carry, $item) {
        //     if (!isset($carry[$item['department']])) {
        //         $carry[$item['department']] = [
        //             'department' => $item['department'],
        //             'new_patient' => $item['new_patient'],
        //             'old_patient' => $item['old_patient']
        //         ];
        //     } else {
        //         $carry[$item['department']]['new_patient'] += $item['new_patient'];
        //         $carry[$item['department']]['old_patient'] += $item['old_patient'];
        //     }
        //     return $carry;
        // });

        $opd_statement = DB::select("select department, sum(new_patient) new_patient,sum(old_patient) old_patient,sum(night_patient) night_patient  from  finc_c023_daily_count_stmt_vw where TRUNC(income_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) group by department");
        // FINC_C023_DAILY_COLL_STMT_VW
        $daily_group_income_statement = DB::select("
                    select item_type_head,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head
                    order by item_type_head asc
                    ");

        // echo "select item_type_head,sum(item_wise_collection) total_collection
        // from FINC_C023_DAILY_COLL_STMT_VW
        // where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        // group by item_type_head
        // order by item_type_head asc";die;

        $daily_income_statement = DB::select("
                    select item_type_head,nvl(serviceunit_name,'Not Defined') serviceunit_name,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head,serviceunit_name
                    order by item_type_head,serviceunit_name asc
                    ");


        // $zakat_fund_muslim = DB::select(
        //     "select '' general_acc, to_char(sum(zakatfund)) muslim, '' non_muslim
        //             from FINC_C022_SUM_AMOUNT_ZAKAT_VW
        //             where religion_txt = 'Islam'
        //             and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))"
        // );


        // $zakat_fund_non_muslim = DB::select("select '' general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
        //             from FINC_C022_SUM_AMOUNT_ZAKAT_VW
        //             where religion_txt != 'Islam'

        //             and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))");


        $zakat_fund_muslim =
            DB::select(
                "SELECT CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  general_acc,

                     SUM ( case when PERSON_CODE in ('ZAKATFUND','DIRECTORFUND')   then DISC_AMT_BY_HOSP else 0 end) muslim,
                       SUM ( case when PERSON_CODE='NONMUSLIMFUND'   then DISC_AMT_BY_HOSP else 0 end) non_muslim
                   FROM FINC_LEDGERMST mst
                        JOIN HRMS_PERSONNEL hp
                           ON mst.DISC_AMT_BY_HOSP_AUTH_BY = hp.PERSON_NO_PK
                           join sysc_module mod
                           on mod.MODULE_NO_PK=mst.MODULE_NO_fK
                  WHERE PERSON_CODE IN
                           ('ZAKATFUND', 'DIRECTORFUND', 'NONMUSLIMFUND')
                             and trunc(LEDGER_DATE) between to_date('$from_date','YYYY-MM-DD') and to_date('$to_date','YYYY-MM-DD')
              GROUP BY CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  "
            );
        // dd($zakat_fund_muslim);
        //  DB::select(
        //     "select  CASE
        //     WHEN MODULE_CODE IN ('PHR','PHR-I')
        //     THEN
        //         'Pharmacy A/C'
        //     ELSE
        //         'General A/C '
        // END  general_acc
        // , to_char(sum(zakatfund)) muslim, '' non_muslim
        //             from finc_c022_sum_amount_zakat_vw
        //             where fund_type = 'ZAKATFUND' and  zakatfund !=0
        //             and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        //             group by CASE
        //                       WHEN MODULE_CODE IN ('PHR','PHR-I')
        //                       THEN
        //                           'Pharmacy A/C'
        //                       ELSE
        //                           'General A/C '
        //                   END "
        // );
        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");
        // dd($zakat_fund_muslim );
        $zakat_fund_arr = [];

        if (!empty($zakat_fund_muslim)) {
            foreach ($zakat_fund_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['ISLAM'] = isset($zakat_fund_arr[$zakat->general_acc]['ISLAM']) ? $zakat_fund_arr[$zakat->general_acc]['ISLAM'] + $zakat->muslim : $zakat->muslim;
            }
        }
        if (!empty($zakat_fund_non_muslim)) {
            foreach ($zakat_fund_non_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['OTHERS'] = isset($zakat_fund_arr[$zakat->general_acc]['OTHERS']) ? $zakat_fund_arr[$zakat->general_acc]['OTHERS'] + $zakat->non_muslim : $zakat->non_muslim; //$zakat->non_muslim;
            }
        }


        return Template::loadview("admin.reports.financial.daily_statement_list", ['zakat_fund_arr' => $zakat_fund_arr, 'group_records' => $result, 'opd_statement' => $opd_statement, 'daily_income_statement' => $daily_income_statement, 'daily_group_income_statement' => $daily_group_income_statement, 'zakat_fund_muslim' => $zakat_fund_muslim, 'zakat_fund_non_muslim' => $zakat_fund_non_muslim, 'hospital_info' => $hospital_info]);
    }


    public function pdfDailyStatementSearch(Request $request)
    {

        ini_set("max_execution_time", -1);
        $from_date = date("Y-m-d", strtotime($request->date_pic));
        $to_date = date("Y-m-d", strtotime($request->date_pic2));
        $from_date1 = date("Y-m-d", strtotime('-1 day', strtotime($from_date)));

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        // dd($from_date1);
        $ipd_currentday_statement = DB::select("
        select NVL(ward_name,'Not Specified') word,to_char(count(admission_no_pk)) previous_patient,'' admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) < TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))  and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,to_char(count(admission_no_pk)) admission, '' discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(admission_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) and  dis_ind = 0
        group by ward_name
        UNION ALL
        select NVL(ward_name,'Not Specified') word,'' previous_patient,'' admission, to_char(count(admission_no_pk)) discharge, '' present_p
        from IPD_ADMITTED_PATLIST_VW
        where TRUNC(dis_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
        and dis_ind = 1
        group by ward_name

        ");

        $ipd_patients = [];
        foreach ($ipd_currentday_statement as $records) {
            array_push($ipd_patients, [
                'word' => $records->word,
                'previous_patient' => (int)$records->previous_patient,
                'admission' => (int)$records->admission,
                'discharge' => (int)$records->discharge
            ]);
        }


        $result = array_reduce($ipd_patients, function ($carry, $item) {
            if (!isset($carry[$item['word']])) {
                $carry[$item['word']] = [
                    'word' => $item['word'],
                    'previous_patient' => $item['previous_patient'],
                    'admission' => $item['admission'],
                    'discharge' => $item['discharge']
                ];
            } else {
                $carry[$item['word']]['previous_patient'] += $item['previous_patient'];
                $carry[$item['word']]['admission'] += $item['admission'];
                $carry[$item['word']]['discharge'] += $item['discharge'];
            }
            return $carry;
        });

        $opd_statement = DB::select("select department, sum(new_patient) new_patient,sum(old_patient) old_patient,sum(night_patient) night_patient  from  finc_c023_daily_count_stmt_vw where TRUNC(income_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) group by department ");

        $daily_group_income_statement = DB::select("
                    select item_type_head,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head
                    order by item_type_head asc
                    ");

        $daily_income_statement = DB::select("
                    select item_type_head,nvl(serviceunit_name,'Not Defined') serviceunit_name,sum(item_wise_collection) total_collection
                    from FINC_V01_DAILY_STMT_VW
                    where TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by item_type_head,serviceunit_name
                    order by item_type_head,serviceunit_name asc
                    ");
        $zakat_fund_muslim =
            DB::select(
                "SELECT CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  general_acc,

                     SUM ( case when PERSON_CODE in ('ZAKATFUND','DIRECTORFUND')   then DISC_AMT_BY_HOSP else 0 end) muslim,
                       SUM ( case when PERSON_CODE='NONMUSLIMFUND'   then DISC_AMT_BY_HOSP else 0 end) non_muslim
                   FROM FINC_LEDGERMST mst
                        JOIN HRMS_PERSONNEL hp
                           ON mst.DISC_AMT_BY_HOSP_AUTH_BY = hp.PERSON_NO_PK
                           join sysc_module mod
                           on mod.MODULE_NO_PK=mst.MODULE_NO_fK
                  WHERE PERSON_CODE IN
                           ('ZAKATFUND', 'DIRECTORFUND', 'NONMUSLIMFUND')
                             and trunc(LEDGER_DATE) between to_date('$from_date','YYYY-MM-DD') and to_date('$to_date','YYYY-MM-DD')
              GROUP BY CASE
            WHEN mod.MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
            END  "
            );

        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");
        // dd($zakat_fund_muslim );
        $zakat_fund_arr = [];

        if (!empty($zakat_fund_muslim)) {
            foreach ($zakat_fund_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['ISLAM'] = isset($zakat_fund_arr[$zakat->general_acc]['ISLAM']) ? $zakat_fund_arr[$zakat->general_acc]['ISLAM'] + $zakat->muslim : $zakat->muslim;
            }
        }
        if (!empty($zakat_fund_non_muslim)) {
            foreach ($zakat_fund_non_muslim as $zakat) {
                $zakat_fund_arr[$zakat->general_acc]['OTHERS'] = isset($zakat_fund_arr[$zakat->general_acc]['OTHERS']) ? $zakat_fund_arr[$zakat->general_acc]['OTHERS'] + $zakat->non_muslim : $zakat->non_muslim; //$zakat->non_muslim;
            }
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        $pdf = PDF::loadView("admin.reports.financial.daily_statement_list_pdf", ['zakat_fund_arr' => $zakat_fund_arr, 'po_hospital_details' => $po_hospital_details, "userInfo" => $userInfo, 'group_records' => $result, 'opd_statement' => $opd_statement, 'daily_income_statement' => $daily_income_statement, 'daily_group_income_statement' => $daily_group_income_statement, 'zakat_fund_muslim' => $zakat_fund_muslim, 'zakat_fund_non_muslim' => $zakat_fund_non_muslim, 'from_date' => $from_date, 'to_date' => $to_date, 'hospital_info' => $hospital_info]);
        return $pdf->stream("pat-vitals-report.pdf", array("Attachment" => false));
        //return Template::loadview
    }


    public function dailyMachineAttendanceReport()
    {
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $to_date = date('d-m-Y');

        $dailMachineAttendanceReportSearch = DB::select("select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time ,a.over_time_min,
							a.late_time_min, a.attendance_status_text, a.in_time_photo, a.out_time_photo, a.person_card_no,b.photo_name, b.full_name,c.designation_name, su.serviceunit_name from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk where  person_card_no IS NOT NULL and attendance_date =to_date('$to_date','DD-MM-YYYY') order by a.attendance_date ASC");
        // dd($dailMachineAttendanceReportSearch); 'sysc_serviceunit su', 'su.serviceunit_no_pk', '=', 'a.serviceunit_no_fk'

        // dd($dailMachineAttendanceReportSearch);


        return Template::loadview("admin.reports.hrm.daily_machine_attendance", ['machine_data' => $dailMachineAttendanceReportSearch, 'dept' => $dept]);
    }

    public function jobCard()
    {
        $to_date = date('d-m-Y');

        $dailAttendanceReportSearch = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time,d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk  where attendance_date =to_date('$to_date','DD-MM-YYYY')  ");

        return Template::loadview("admin.reports.hrm.job_card", ['value' => $dailAttendanceReportSearch]);
    }

    public function emp_att_rep()
    {
        return Template::loadview("admin.reports.hrm.emp_att_rep");
    }


    public function dailyLateReport()
    {
        $to_date = date('d-m-Y');
        $dailLateReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2 and attendance_date =to_date('$to_date','DD-MM-YYYY') ");

        // dd($dailLateReportSearch);
        return Template::loadview("admin.reports.hrm.daily_late_report", ['value' => $dailLateReportSearch]);
    }

    public function dailyAbsentReport()
    {
        $to_date = date('d-m-Y');
        $dailAttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name ,a.duty_in_time,a.in_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1 and attendance_date =to_date('$to_date','DD-MM-YYYY') ");

        return Template::loadview("admin.reports.hrm.daily_absent_report", ['value' => $dailAttendanceReportSearch]);
    }

    public function attendanceReport()
    {
        $to_date = date('d-m-Y');
        $AttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.out_time,a.late_time_min,a.over_time_min, a.conflict_comments,a.late_early_leave_note from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1and attendance_date =to_date('$to_date','DD-MM-YYYY') and nvl(virtual_ind,0)=0");


        return Template::loadview("admin.reports.hrm.attendance_report", ['value' => $AttendanceReportSearch]);
    }

    public function dailyLeaveReport()
    {
        $date = date('d-m-Y');
        $from_date_cond = "and to_date('$date','dd/mm/yyyy') between a.from_date   AND a.to_date ";
        // $to_date_cond ="or a.to_date between to_date('$date','dd/mm/yyyy') AND to_date('$date', 'dd/mm/yyyy')";
        $dailyLeaveReport = DB::select("select b.person_code, b.full_name,c.designation_name,b.join_date,trunc(a.from_date) from_date , trunc(a.to_date) to_date, a.leave_reason from hrms_leave_entry a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.status=1 $from_date_cond ");


        return Template::loadview("admin.reports.hrm.daily_leave_report", ['value' => $dailyLeaveReport]);
    }

    public function dailyQuestionableEntryReport()
    {
        return Template::loadview("admin.reports.hrm.daily_questionable_entry_report");
    }

    public function dailyAttendanceSummaryReport()
    {
        return Template::loadview("admin.reports.hrm.daily_attendance_summary_report");
    }

    public function departmentWiseDailySummaryReport()
    {
        return Template::loadview("admin.reports.hrm.department_wise_daily_attendance_summary_report");
    }

    public function dailyManpowerSummaryReport()
    {
        return Template::loadview("admin.reports.hrm.daily_manpower_summary_report");
    }

    public function dailyAdjustedEntriesReport()
    {
        return Template::loadview("admin.reports.hrm.daily_adjusted_entries_report");
    }

    public function monthlyAttendanceDetails()
    {
        return Template::loadview("admin.reports.hrm.monthly_attendance_details_report");
    }

    public function detailedJobCardSummaryReport()
    {
        return Template::loadview("admin.reports.hrm.detailed_job_card_summary_report");
    }

    //Monthly Late report

    public function monthlyLateReport()
    {
        $serviceunit_name = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        // dd($serviceunit_name);
        return template::loadview('admin.reports.hrm.monthly_late_report', ['depart' => $serviceunit_name]);
    }

    public function monthlyLateReportSearch(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $card_num = $request->card_num;
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $card_num)->first();
        $department = $request->department_name;
        $month_year_con = ($month_year != "") ? " and TO_CHAR(a.ATTENDANCE_DATE,'yyyymm') = '$month_year'" : "";
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $card_no_con = ($request->card_num != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        //    dd($card_num);
        $monthlyLateData = DB::select("select a.person_card_no, a.person_no_fk, b.full_name, su.serviceunit_name, shift.shift_code, count(person_card_no) as late_days from hrms_attendance_daily a
       left join hrms_personnel b ON b.person_code = a.person_card_no
       left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
       left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
       where a.person_card_no IS NOT NULL and b.status = 1  and  a.in_time  > a.duty_in_time $month_year_con $department_con $card_no_con group by a.person_card_no, a.person_no_fk, b.full_name, su.serviceunit_name, shift.shift_code");

        return Template::loadview("admin.reports.hrm.monthly_late_report_list", ['monthlyLateData' => $monthlyLateData, 'month_year' => $month_year, 'department' => $department, 'card_num' => $card_num]);
    }

    public function employeeLateDetail($id, $month_year = null, $department = null, $card_num = null)
    {
        $card_num = $card_num;
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $card_num)->first();
        $month_year_con = ($month_year != "") ? " and TO_CHAR(a.ATTENDANCE_DATE,'yyyymm') = '$month_year'" : "";
        $department_con = ($department != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $card_no_con = ($card_num != "") ? " and a.person_card_no='$card_no->person_code'" : "";

        $monthlyLateData = DB::select("select a.person_card_no, a.person_no_fk, a.late_time_min, a.attendance_date, b.full_name, su.serviceunit_name, shift.shift_code, a.duty_in_time, a.duty_out_time, a.in_time, a.out_time  from hrms_attendance_daily a
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        where a.person_card_no IS NOT NULL and a.person_no_fk = $id and b.status = 1  and  a.in_time  > a.duty_in_time $month_year_con $department_con $card_no_con");
        // dd($monthlyLateData);

        return Template::loadView("admin.reports.hrm.employee_late_detail", [
            'monthlyLateData' => $monthlyLateData
        ]);
    }

    public function leaveSummaryReport()
    {
        $to_date = date('d-m-Y');
        $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) = to_date('$to_date','DD-MM-YYYY')
            group by person_code,full_name,designation_name,su_name
            ");
        // dd($leave_summary);

        // $leave_summary = DB::select("select * from hrms_leave_entry_vw where trunc(au_entry_at) = to_date('$to_date','DD-MM-YYYY')");

        return Template::loadview("admin.reports.hrm.leave_summary_report", compact('leave_summary'));
    }

    public function monthlyQuestionableEntryReport()
    {
        return Template::loadview("admin.reports.hrm.monthly_questionable_entry_report");
    }

    public function manuallyAdjustedEntriesMonthlyReport()
    {
        return Template::loadview("admin.reports.hrm.manually_adjusted_entries_monthly");
    }

    public function overTimeSheet()
    {
        return Template::loadview("admin.reports.hrm.overtime_sheet");
    }

    public function summaryWagesSheet()
    {
        return Template::loadview("admin.reports.hrm.summary_wages_sheet");
    }

    public function punchCardTakerList()
    {
        return Template::loadview("admin.reports.hrm.punch_card_taker");
    }

    public function yearlyLateReport()
    {
        return Template::loadview("admin.reports.hrm.yearly_late_report");
    }

    public function yearlyAbsentReport()
    {
        return Template::loadview("admin.reports.hrm.yearly_absent_report");
    }

    public function monthlyAbsentReport()
    {
        return Template::loadview("admin.reports.hrm.monthly_absent_report");
    }

    public function employeeCard()
    {
        // $emp_info=DB::table('employee_info_vw')->first();

        // $title= $emp_info->person_code;
        // $barcode = new BarcodeGenerator();
        // $barcode->setText( $title );
        // $barcode->setType(BarcodeGenerator::Code128);
        // $barcode->setLabel('');
        // $barcode->setScale(1);
        // $barcode->setThickness(25);
        // $barcode->setFontSize(15);
        // $barcode_no = $barcode->generate();

        return Template::loadview("admin.reports.hrm.employee_card");
    }

    public function employeeCardSearch(Request $request)
    {
        $person_code = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->hidn_card)->first();

        $emp_code = $person_code->person_code;
        $emp_info = DB::table('employee_info_vw')->where('person_code', $emp_code)->first();

        $title = $emp_info->person_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(15);
        $barcode_no = $barcode->generate();
        // dd($emp_info);
        return Template::loadview("admin.reports.hrm.employee_id_card_info", ['emp_info' => $emp_info, 'barcode_no' => $barcode_no]);
    }

    public function employeeCardPrint(Request $request)
    {

        $person_code = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->hidn_card)->first();

        $emp_code = $person_code->person_code;
        $emp_info = DB::table('employee_info_vw')->where('person_code', $emp_code)->first();

        $title = $emp_info->person_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(15);
        $barcode_no = $barcode->generate();
        // dd($emp_info)
        $pdf = PDF::loadview("admin.reports.hrm.employee_id_card_print", ['emp_info' => $emp_info, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');

        return $pdf->download('employee_id_card_print.pdf');
    }

    public function monthlySalarySheet()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.hrm.monthly_salary_sheet", [
            'bank_name' => $bank_name
        ]);
    }
    public function monthlySalarySheet2()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        if (Session::get('user.ses_hospital_code') == 'AMCSH') {

            return Template::loadview("admin.reports.hrm.monthly_salary_sheet_amcsh", [
                'bank_name' => $bank_name
            ]);
        } elseif (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            return Template::loadview("admin.reports.hrm.monthly_salary_sheet_unico", [
                'bank_name' => $bank_name
            ]);
        } else {
            return Template::loadview("admin.reports.hrm.monthly_salary_sheet2", [
                'bank_name' => $bank_name
            ]);
        }
    }
    //salary sheet
    public function monthlySalarySheetV1()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.hrm.monthly_salary_sheet_v1", [
            'bank_name' => $bank_name
        ]);
    }

    public function monthlySalarySearchV1(Request $request)
    {
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        // $cutoff_start = $salaryData->cut_off_strday;
        // $cutoff_end = $salaryData->cut_off_endday;
        $table = " HRMS_v1_MONTHLY_SALARY_WL_VW ";
        if (isset($salaryData) && $salaryData->cut_off_ind == 1) {
            $startDate = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $endtDate = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $startDate = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $endtDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        // no of days from a month/date range calculation
        $totalDaysInMonth = isset($startDate) && isset($endtDate) ? countDays($startDate, $endtDate) + 1 : "";
        // no of fridays from a month/date range calculation
        $weekendCount = isset($startDate) && isset($endtDate) ? countFridays($startDate, $endtDate) : "";
        //holidays
        $firstDateOfMonth = Carbon::parse($startDate)->format('d/m/Y');
        $lastDateOfMonth = Carbon::parse($endtDate)->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        $holidayArray = [];
        if (!empty($holidayData)) {
            foreach ($holidayData as $data) {
                $partData = explode(" ", $data->holiday_date);
                $holidayArray[] = ($partData[0]);
            }
        }
        $holidays = array_unique($holidayArray);
        //
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $bank_name" : "";

        $monthlySalaryReportSearch = DB::select("select working_hour, other_deduct_amount, ot_time, card_no,monthly_salary_no_pk,overtime_hours, serviceunit_name, residence_fee, person_no_pk,overtime_rate,overtime_amount,salary_yyyymm ,other_allowance, full_name,designation_name, gross_salary,basic_salary, medical_allowance,house_rent,attendance_bonus,att_deduct_amount,loan_deduct_amount, payable_amount,attendance_days, late_days, absent_days, leave_days,leave_withoutpay_days,sick_leave,casual_leave,general_festival_days, personal_savings_amount,agent_banking_type_name,conveyance_allowance, ta_da_allowance, night_allowance, revenue_stamp, advance_amt, incometax_deduct_amount, revenue_stamp,working_days, join_date, addndeduct_no_pk, add_revision, add_arrear, add_ot, ded_ait, ded_food_bill, ded_pf, ded_adv, ded_med_bill, ded_salary, ded_lwp, ded_emb, ded_others, holiday, servicedept_name, bank_acc_no, ra_sal, ica_sal, sa_sal, ca_sal, remarks, ot_time, withheld_ind from $table where status=1 and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con $bank_no_con order by card_no asc");

        return Template::loadview("admin.reports.hrm.monthly_salary_list_v1", ['value' => $monthlySalaryReportSearch, 'countTotalDaysInMonth' => $totalDaysInMonth, 'countWeekend' => $weekendCount, 'month' => $month, 'year' => $year, 'holidays' => $holidays, 'startDate' => $startDate, 'endtDate' => $endtDate]);
    }

    public function monthlySalaryPrintV1(Request $request)
    {
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        $cutoff_start = "21";
        $cutoff_end = "20";
        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        $table = ' hrms_v1_monthly_salary_wl_vw ';

        if (isset($salaryData) &&  $salaryData->cut_off_ind == 1) {
            $startDate = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $endtDate = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $startDate = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $endtDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        // no of days from a month/date range calculation
        $totalDaysInMonth = isset($cutoff_start) && isset($cutoff_end) ? countDays($startDate, $endtDate) + 1 : "";
        // no of fridays from a month/date range calculation
        $weekendCount = isset($cutoff_start) && isset($cutoff_end) ? countFridays($startDate, $endtDate) : "";
        //holidays
        $firstDateOfMonth = Carbon::parse($startDate)->format('d/m/Y');
        $lastDateOfMonth = Carbon::parse($endtDate)->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        $holidayArray = [];
        if (!empty($holidayData)) {
            foreach ($holidayData as $data) {
                $partData = explode(" ", $data->holiday_date);
                $holidayArray[] = ($partData[0]);
            }
        }
        $holidays = array_unique($holidayArray);
        //
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $bank_name" : "";

        $monthlySalaryReportprint = DB::select("select working_hour, lookupdata_desc, serial_no, ot_time, other_deduct_amount, person_no_pk,card_no,serviceunit_name,monthly_salary_no_pk,
        person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance, full_name,
        designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,
        att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days,
        residence_fee, leave_days, sick_leave, casual_leave, leave_withoutpay_days, working_days, personal_savings_amount, conveyance_allowance,
        ta_da_allowance, night_allowance, advance_amt, incometax_deduct_amount, revenue_stamp, join_date, addndeduct_no_pk, add_revision, add_arrear, add_ot, ded_ait, ded_food_bill, ded_pf, ded_adv, ded_med_bill, ded_salary, ded_lwp, ded_emb, ded_others, holiday, servicedept_name, bank_acc_no, ra_sal, ica_sal, sa_sal, ca_sal, remarks
        from $table where status=1 and (withheld_ind = 0 or withheld_ind is null) and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con order by card_no asc");

        $total_employee = DB::select("select lookupdata_desc, count(person_no_pk)  total_emp from $table  where status=1   $card_no_con $month_year_con group by lookupdata_desc");

        $t_salary = DB::select("select  lookupdata_desc, sum(payable_amount)  total_emp_salary, sum(gross_salary) as total_gross_salary,
        sum(night_allowance) as total_night_allowance, sum(advance_amt) as total_advance_amt, sum(incometax_deduct_amount) as total_incometax_deduct_amount,
        sum(revenue_stamp) as total_revenue_stamp from $table  where status=1  and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con group by  lookupdata_desc");
        // dd($t_salary);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->lookupdata_desc][$salarySheet->person_no_pk] = $salarySheet;
            }
        }
        // dd($emp_data);
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->lookupdata_desc] = $value->total_emp;
            }
        }
        $total_salary = [];
        if (!empty($t_salary)) {
            foreach ($t_salary as $value) {
                // $total_salary[$value->serviceunit_name] = $value->total_emp_salary;
                $total_salary[$value->lookupdata_desc] = $value->total_gross_salary + $value->total_night_allowance - $value->total_advance_amt - $value->total_incometax_deduct_amount
                    - $value->total_revenue_stamp;
            }
        }

        $from_date = date('d/m/Y');
        $title = " monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_v1", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'po_hospital_details' => $po_hospital_details, 'monthlySalaryReportprint' => $monthlySalaryReportprint, 'countTotalDaysInMonth' => $totalDaysInMonth, 'countWeekend' => $weekendCount, 'holidays' => $holidays, 'startDate' => $startDate, 'endtDate' => $endtDate])->setPaper([0, 0, 792, 1224], 'landscape');
        return $pdf->download('monthly_salary_print_v1.pdf');
    }



    public function specificMonthlySalarySheetUpdate(Request $request)
    {
        $ids = $request->ids;
        $person_no_pk = $request->person_no_pk;
        $salary_yyyymm = $request->salary_yyyymm;
        $revision = $request->revision;
        $arrear = $request->arrear;
        $ot = $request->ot;
        $ait = $request->ait;
        $food_bill = $request->food_bill;
        $pf_ded = $request->pf_ded;
        $adv = $request->adv;
        $medical_bill = $request->medical_bill;
        $salary_ded = $request->salary_ded;
        $lwp = $request->lwp;
        $mobile_bill = $request->mobile_bill;
        $others = $request->others;
        $remarks = $request->remarks;
        $withheld = $request->withheld;
        $addndeduct_nos = $request->addndeduct_nos;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sequence = DB::getSequence();
        $addndeduct_no_pk_seq = $sequence->nextValue('addndeduct_no_pk_seq');
        // dd($person_no_pk, $salary_yyyymm, $addndeduct_nos);
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                $data = [
                    'add_revision' => $revision[$key],
                    'add_arrear' => $arrear[$key],
                    'add_ot' => isset($ot[$key]) ? $ot[$key] : "0",
                    // 'ded_ait' => $ait[$key],
                    'ded_food_bill' => $food_bill[$key],
                    'ded_pf' => $pf_ded[$key],
                    'ded_adv' => $adv[$key],
                    'ded_med_bill' => $medical_bill[$key],
                    'ded_salary' => $salary_ded[$key],
                    'ded_lwp' => $lwp[$key],
                    'ded_emb' => $mobile_bill[$key],
                    'ded_others' => $others[$key],
                    'remarks' => $remarks[$key],
                    'withheld_ind' => isset($withheld[$id]) ?  $withheld[$id] : 0,
                ];


                if (empty($addndeduct_nos[$key])) {
                    $data['addndeduct_no_pk'] = $sequence->nextValue('addndeduct_no_pk_seq');
                    $data['au_entry_by'] = $auth_id;
                    $data['au_entry_at'] = date('Y-m-d h:i:s');
                    $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                    $data['au_entry_session'] = 'Salary';
                    $data['person_no_fk'] = $person_no_pk[$key];
                    $data['salary_yyyymm'] = $salary_yyyymm[$key];

                    DB::table('hrms_addition_deduction_monthly')->insert($data);
                } else {
                    // dd($addndeduct_nos[$key], $data);
                    $data['au_update_by'] = $auth_id;
                    $data['au_update_at'] = date('Y-m-d h:i:s');
                    DB::table('hrms_addition_deduction_monthly')->where('person_no_fk', $person_no_pk[$key])->where('salary_yyyymm', $salary_yyyymm[$key])->update($data);
                }
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function dailyAttendanceReportSearch(Request $request)
    {

        // $card_no = $request->card_hidn;

        $personal_no_pk = $request->card_hidn;

        $att_status = $request->att_status;
        $designation = $request->designation_name;

        // $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();


        // dd($card_no);
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        if ($att_status == 1) {
            $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        } else {
            $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        }

        // dd($date_cond);
        $dailAttendanceReportSearch = DB::select("select a.attendance_date, a.entry_type, a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min, jobtype.lookupdata_desc, a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk left join sysc_lookupdata jobtype
        on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0  $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");

        //    echo "select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        //    a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0  $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by a.attendance_date ASC";
        // dd($dailAttendanceReportSearch);

        // "select a.attendance_date, a.person_card_no, b.full_name,c.designation_name,a.in_time,a.out_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.person_card_no IS NOT NULL $from_date_cond  $card_no_con order by a.attendance_date ASC"


        return Template::loadview("admin.reports.hrm.daily_attendance_report_list", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch]);
    }

    public function ewmchDailyAttendanceReportSearch(Request $request)
    {

        // $card_no = $request->card_hidn;

        $personal_no_pk = $request->card_hidn;

        $att_status = $request->att_status;
        $designation = $request->designation_name;
        // dd($att_status);
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();
        // dd($personal_no_pk, $card_no);
        // dd($card_no);
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $department = $request->department_name;
        // dd($department);
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        // if ($att_status == 1) {
        //     $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        // } else {
        //     $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        // }
        $att_status_con = ($att_status != "") ? " and case when nvl(lv.LEAVE_NO_PK,0) > 0 then 3 when attendance_status in (6, 7) then 4 when trunc(a.in_time) is not null and trunc(a.OUT_TIME) is null then 99 when trunc(ATTENDANCE_DATE)=trunc(a.in_time) then 1 else 5 end = $att_status" : "";

        // if ($att_status == 1) {
        //     $att_status_con = ($att_status != "") ? " and a.in_time IS NOT NULL" : "";
        // } elseif($att_status == 3) {
        //     $att_status_con = ($att_status != "") ? " and a.leave_entry_ind IS '1'" : "";
        // } elseif($att_status == 4) {
        //     $att_status_con = ($att_status != "") ? " and a.shift_code = 'OFFDAY' OR  a.shift_code = 'DAYOFF'" : "";
        // }
        // else{
        //     $att_status_con = ($att_status != "") ? " and a.in_time IS NULL" : "";

        // }



        $dailAttendanceReportSearch = DB::select("select a.entry_type, a.manual_status, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when a.attendance_status in (8,9,3,4) then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond $department_con $designation_con $card_no_con $att_status_con order by trunc(ATTENDANCE_DATE) desc");
        // dd($dailAttendanceReportSearch);
        //    echo "select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        //    a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0  $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by a.attendance_date ASC";
        // dd($dailAttendanceReportSearch);

        // "select a.attendance_date, a.person_card_no, b.full_name,c.designation_name,a.in_time,a.out_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.person_card_no IS NOT NULL $from_date_cond  $card_no_con order by a.attendance_date ASC"


        return Template::loadview("admin.reports.hrm.daily_attendance_report_list_ewmch", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch]);
    }


    public function dailyMachineAttendanceReportSearch(Request $request)
    {
        $pk_no = $request->card_hidn;
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $pk_no)->first();
        // dd($card_no);
        $department = $request->department_name;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));

        $card_no_con = ($request->card_no != "") ? "  and a.person_card_no='$card_no->person_code'" : "";
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";


        $dailMachineAttendanceReportSearch = DB::select("select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,
							a.late_time_min ,a.in_time_photo,  a.attendance_status_text, a.out_time_photo, a.person_card_no,b.photo_name, b.full_name,c.designation_name, su.serviceunit_name from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk where person_card_no IS NOT NULL and b.status = 1  $card_no_con $from_date_cond  $department_con order by a.attendance_date ASC");


        return Template::loadview("admin.reports.hrm.daily_machine_attendance_list", ['machine_data' => $dailMachineAttendanceReportSearch]);
    }


    public function jobCardSearch(Request $request)
    {
        $personal_no_pk = $request->card_hidn;

        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $from_date_cond = ($request->date_pic != "") ? "  a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";
        // dd($card_no);
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";
        // dd($card_no_con);

        if (!empty($card_no_con)) {

            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();
            // dd($details);


            $dailAttendanceReportSearch = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time,d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $from_date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $dailAttendanceReportSearch = [];
            $details = [];
        }

        return Template::loadview("admin.reports.hrm.job_card_list", ['value' => $dailAttendanceReportSearch, 'details' => $details, 'from_date' => $from_date]);
    }

    public function emp_att_rep_search(Request $request)
    {
        $personal_no_pk = $request->card_hidn;

        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $from_date_cond = ($request->date_pic != "") ? "  a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";
        // dd($card_no);
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";
        // dd($card_no_con);

        if (!empty($card_no_con)) {

            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();
            // dd($details);


            $dailAttendanceReportSearch = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time,d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $from_date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $dailAttendanceReportSearch = [];
            $details = [];
        }

        return Template::loadview("admin.reports.hrm.emp_att_rep_list", ['value' => $dailAttendanceReportSearch, 'details' => $details, 'from_date' => $from_date]);
    }
    public function dailyLateReportSearch(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->card_hidn;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(attendance_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        $dailLateReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2 $sql_cond ");
        // dd($dailLateReportSearch);
        // echo "select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2 $sql_cond";
        return Template::loadview("admin.reports.hrm.daily_late_report_list", ['value' => $dailLateReportSearch]);
    }

    public function dailyAbsentReportSearch(Request $request)
    {

        // dd('dddd');
        $card_no = $request->card_hidn;

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name ,a.duty_in_time,a.in_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1 $date_cond  $card_no_con ");

        return Template::loadview("admin.reports.hrm.daily_absent_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function attendanceReportSearch(Request $request)
    {
        // dd('dddd');
        $card_no = $request->card_hidn;

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $AttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.out_time,a.late_time_min,a.over_time_min, a.conflict_comments,a.late_early_leave_note,
        a.early_time_min from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_lookupdata jobtype
        on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where a.attendance_status=1 and nvl(virtual_ind,0)=0 $date_cond  $card_no_con order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");


        return Template::loadview("admin.reports.hrm.attendance_report_list", ['value' => $AttendanceReportSearch]);
    }

    public function dailyLeaveReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $from_date_cond = ($request->date_pic != "") ? "and to_date('$from_date','dd/mm/yyyy') between a.from_date   AND a.to_date " : "";
        $to_date_cond = ($request->date_pic != "") ? "and to_date('$to_date','dd/mm/yyyy') between a.from_date   AND a.to_date " : "";
        // $date_cond = ($request->date_pic != "") ? " and from_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $date_cond = ($request->date_pic !="")?"and a.from_date between to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date', 'dd/mm/yyyy')":"";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk= $card_no" : "";

        $dailyLeaveReportSearch = DB::select("select b.person_code, b.full_name,c.designation_name,b.join_date,trunc(a.from_date) from_date , trunc(a.to_date) to_date, a.leave_reason from hrms_leave_entry a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.status=1 $from_date_cond $to_date_cond  $card_no_con ");


        return Template::loadview("admin.reports.hrm.daily_leave_report_list", ['value' => $dailyLeaveReportSearch]);
    }

    public function dailyQuestionableEntryReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk, a.appoint_date, a.doctor_name, sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) as total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status = 1 $date_cond $card_no_con group by a.doctor_no_fk, a.appoint_date, a.doctor_name");

        return Template::loadview("admin.reports.hrm.daily_questionable_entry_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function dailyAttendanceSummaryReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.daily_attendance_summary_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function departmentWiseDailySummaryReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.department_wise_daily_attendance_summary_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function dailyManpowerSummaryReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.daily_manpower_summary_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function dailyAdjustedEntriesReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.daily_adjusted_entries_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function monthlyAttendanceDetailsSearch(Request $request)
    {
        // dd('dddd');
        $card_no = $request->card_hidn;

        //  $from_date = date("d-m-Y", strtotime($request->date_pic));
        //  $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name ,a.duty_in_time,a.in_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1  $card_no_con ");


        return Template::loadview("admin.reports.hrm.monthly_attendance_details_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function detailedJobCardSummarySearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.detailed_job_card_summary_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function leaveSummaryReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        // dd( $card_no );
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));

        if ($card_no == "") {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            group by person_code,full_name,designation_name,su_name
            ");
        } else {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and person_no_fk = '$card_no'
            group by person_code,full_name,designation_name,su_name
            ");
        }


        return Template::loadview("admin.reports.hrm.leave_summary_report_list", ['leave_summary' => $leave_summary]);
    }

    public function monthlyQuestionableEntryReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.monthly_questionable_entry_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function manuallyAdjustedEntriesMonthlySearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.manually_adjusted_entries_monthly_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function overTimeSheetSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.overtime_sheet_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function summaryWagesSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.summary_wages_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function punchCardTakerSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.punch_card_taker_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function yearlyLateReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.yearly_late_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function yearlyAbsentReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.yearly_absent_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function monthlyAbsentReportSearch(Request $request)
    {
        $card_no = $request->card_no;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");


        return Template::loadview("admin.reports.hrm.monthly_absent_report_list", ['value' => $dailAttendanceReportSearch]);
    }

    public function monthlySalarySearch(Request $request)
    {
        // dd($request->card_hidn);
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $bank_name" : "";


        $monthlySalaryReportSearch = DB::select("select other_deduct_amount, card_no,monthly_salary_no_pk,overtime_hours, residence_fee, person_no_pk,overtime_rate,overtime_amount,salary_yyyymm ,other_allowance, full_name,designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days, leave_days,leave_withoutpay_days,personal_savings_amount,agent_banking_type_name
							from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con $bank_no_con");


        return Template::loadview("admin.reports.hrm.monthly_salary_list", ['value' => $monthlySalaryReportSearch]);
    }

    public function monthlySalarySearch2(Request $request)
    {
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        // $cutoff_start = "21";
        // $cutoff_end = "20";
        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        if (isset($salaryData) && $salaryData->cut_off_ind == 1) {
            $startDate = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $endtDate = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $startDate = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $endtDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        // no of days from a month/date range calculation
        $totalDaysInMonth = isset($startDate) && isset($endtDate) ? countDays($startDate, $endtDate) + 1 : "";
        // no of fridays from a month/date range calculation
        $weekendCount = isset($startDate) && isset($endtDate) ? countFridays($startDate, $endtDate) : "";
        //holidays
        $firstDateOfMonth = Carbon::parse($startDate)->format('d/m/Y');
        $lastDateOfMonth = Carbon::parse($endtDate)->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        $holidayArray = [];
        if (!empty($holidayData)) {
            foreach ($holidayData as $data) {
                $partData = explode(" ", $data->holiday_date);
                $holidayArray[] = ($partData[0]);
            }
        }
        $holidays = array_unique($holidayArray);
        //
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $bank_name" : "";

        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $monthlySalaryReportSearch = DB::select("select working_hour, other_deduct_amount, ot_time, card_no,monthly_salary_no_pk,overtime_hours, serviceunit_name, residence_fee, person_no_pk,overtime_rate,overtime_amount,salary_yyyymm ,other_allowance, full_name,designation_name, gross_salary,basic_salary, medical_allowance,house_rent,attendance_bonus,att_deduct_amount,loan_deduct_amount, payable_amount,attendance_days, late_days, absent_days, leave_days,leave_withoutpay_days,sick_leave,casual_leave,general_festival_days, personal_savings_amount,agent_banking_type_name,conveyance_allowance, ta_da_allowance, night_allowance, revenue_stamp, advance_amt, incometax_deduct_amount, absent_amount,  revenue_stamp,working_days, join_date, addndeduct_no_pk, add_revision, add_arrear, add_ot, ded_ait, ded_food_bill, ded_pf, ded_adv, ded_med_bill, ded_salary, ded_lwp, ded_emb, ded_others, holiday, servicedept_name, bank_acc_no from hrms_monthly_salary_wl_vw where status=1 and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con $bank_no_con order by card_no asc");
        } else {
            $monthlySalaryReportSearch = DB::select("select working_hour, other_deduct_amount, ot_time, card_no,monthly_salary_no_pk,overtime_hours, residence_fee, person_no_pk,overtime_rate,overtime_amount,salary_yyyymm ,other_allowance, full_name,designation_name,
            gross_salary,basic_salary, medical_allowance,house_rent,attendance_bonus,att_deduct_amount,loan_deduct_amount,
            payable_amount,attendance_days, late_days, absent_days, leave_days,leave_withoutpay_days,sick_leave,casual_leave,general_festival_days,
            personal_savings_amount,agent_banking_type_name,conveyance_allowance, ta_da_allowance, night_allowance, revenue_stamp,
            advance_amt, incometax_deduct_amount, absent_amount, revenue_stamp,working_days, join_date from hrms_monthly_salary_wl_vw
            where status=1 and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con $bank_no_con order by serial_no asc, card_no asc");
        }

        if (Session::get('user.ses_hospital_code') == 'AMCSH') {
            return Template::loadview("admin.reports.hrm.monthly_salary_list_amcsh", ['value' => $monthlySalaryReportSearch, 'totalDaysInMonth' => $totalDaysInMonth, 'weekendCount' => $weekendCount]);
        } elseif (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {

            return Template::loadview("admin.reports.hrm.monthly_salary_list_unico", ['value' => $monthlySalaryReportSearch, 'totalDaysInMonth' => $totalDaysInMonth, 'weekendCount' => $weekendCount, 'month' => $month, 'year' => $year, 'holidays' => $holidays, 'startDate' => $startDate, 'endtDate' => $endtDate]);
        } else {
            return Template::loadview("admin.reports.hrm.monthly_salary_list2", ['value' => $monthlySalaryReportSearch]);
        }
    }

    public function dailyAttendanceReportPrint(Request $request)
    {
        $dept  = ServiceUnit::where('serviceunit_no_pk', $request->department_name)->select('serviceunit_name')->first();
        $desig = Designation::where('designation_no_pk', $request->designation_name)->select('designation_name')->first();

                    $dept_con  = (!empty($dept) ? $dept->serviceunit_name : "");
                   $desig_con  = (!empty($desig) ? $desig->designation_name : "");
        $att_status_condition  = (!empty($request->att_status) ? $request->att_status : "");

            $personal_no_pk    = $request->card_hidn;
            $att_status        = $request->att_status;
            $designation       = $request->designation_name;
        // $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();

        $card = (!empty($card_no) ? $card_no->person_code : "");

        $from_date       = date("d-m-Y", strtotime($request->date_pic));
        $to_date         = date("d-m-Y", strtotime($request->date_pic2));
        $department      = $request->department_name;
        $department_con  = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond  = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con     = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";

        $att_status_con  = ($att_status != "") ? " and case when nvl(lv.LEAVE_NO_PK,0) > 0 then 3 when attendance_status in (6, 7) then 4 when trunc(a.in_time) is not null and trunc(a.OUT_TIME) is null then 99 when trunc(ATTENDANCE_DATE)=trunc(a.in_time) then 1 else 5 end = $att_status" : "";
        if (Session::get('user.ses_hospital_code') == 'EWMCH' || Session::get('user.ses_hospital_code') == 'AMCSH' || Session::get('user.ses_hospital_code') == 'IMPERIAL' || Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL' || Session::get('user.ses_hospital_code') == 'IMPALA') {

            $dailAttendanceReportPrint = DB::select("select a.entry_type, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond $department_con $designation_con $card_no_con $att_status_con order by trunc(ATTENDANCE_DATE) desc");
        } else {
            $dailAttendanceReportPrint = DB::select("select a.entry_type, a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min, jobtype.lookupdata_desc,
            jobtype.serial_no, a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code
            from hrms_attendance_daily a left join hrms_personnel b on b.person_code = a.person_card_no
             left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk
              left join sysc_serviceunit su on su.serviceunit_no_pk = b.serviceunit_no_fk
              left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
               left join sysc_lookupdata jobtype
               on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk
                where a.person_card_no is not null
            and nvl(b.virtual_ind,0)=0 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con
            order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");
        }

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if (Session::get('user.ses_hospital_code') == 'EWMCH' || Session::get('user.ses_hospital_code') == 'AMCSH' || Session::get('user.ses_hospital_code') == 'IMPERIAL' || Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL' || Session::get('user.ses_hospital_code') == 'IMPALA') {

            if ($request->hdn_report_type == 'PDF') {
                $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_print_report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition])->setPaper('a4', 'landscape');
                return $pdf->stream('daily_attendance_print_report.pdf');
            }
            if ($request->hdn_report_type == 'EXCEL') {

                $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition];
                $fileToExport = "daily_attendance_print_report";
                $html = View("admin.reports.hrm.daily_attendance_print_report")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } else {
            $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition])->setPaper('a4', 'landscape');
            return $pdf->stream('daily_attendance_report_print.pdf');
        }
    }




    public function dailyAttendanceReportPrintV1(Request $request)
    {
                        $dept  = ServiceUnit::where('serviceunit_no_pk', $request->department_name)->select('serviceunit_name')->first();
                        $desig = Designation::where('designation_no_pk', $request->designation_name)->select('designation_name')->first();

                    $dept_con  = (!empty($dept) ? $dept->serviceunit_name : "");
                    $desig_con = (!empty($desig) ? $desig->designation_name : "");
        $att_status_condition  = (!empty($request->att_status) ? $request->att_status : "");

        $personal_no_pk  = $request->card_hidn;
        $att_status      = $request->att_status;
        $designation     = $request->designation_name;
        $card_no         = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();

        $card            = (!empty($card_no) ? $card_no->person_code : "");

        $from_date       = $request->date_pic ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date         = $request->date_pic2 ? date("d-m-Y", strtotime($request->date_pic2)) : '';
        $department      = $request->department_name;
        $department_con  = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond  = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con     = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";

        $att_status_con  = ($att_status != "") ? " and case when nvl(lv.LEAVE_NO_PK,0) > 0 then 3 when attendance_status in (6, 7) then 4 when trunc(a.in_time) is not null and trunc(a.OUT_TIME) is null then 99 when trunc(ATTENDANCE_DATE)=trunc(a.in_time) then 1 else 5 end = $att_status" : "";

        $dailAttendanceReportPrints = DB::select("select a.entry_type, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, a.leave_details, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when a.attendance_status in (8,9,3,4) then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond $department_con $designation_con $card_no_con $att_status_con order by a.person_card_no, trunc(a.attendance_date) asc");

        $dailAttendanceReportPrint = [];
        if (!empty($dailAttendanceReportPrints)) {
            foreach ($dailAttendanceReportPrints as $key => $value) {
                $dailAttendanceReportPrint[$value->full_name . '*' . $value->person_card_no . '*' . $value->serviceunit_name . '*' . $value->designation_name][] = $value;
            }
        }

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.reports.hrm.daily_attendance_print_report_v1", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition]);
            return $pdf->stream('daily_attendance_print_report.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {

            $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition];
            $fileToExport = "daily_attendance_print_report";
            $html = View("admin.reports.hrm.daily_attendance_print_report_v1")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function individualDailyAttendanceReport(Request $request)
    {
        return Template::loadview("admin.reports.hrm.individual_daily_attendance_report");
    }

    public function individualDailyAttendanceReportSearch(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $user_info = Auth::user();
        $card_no = $user_info->user_code;

        $from_date_cond = ($request->date_pic != ""  && $request->date_pic2 != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $dailAttendanceReportSearch = DB::select("select a.entry_type, a.manual_status, a.early_time_min, a.attendance_date
      ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
      a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
      , su.serviceunit_name, shift.shift_code, case when a.attendance_status in (8,9,3,4) then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
      from hrms_attendance_daily a
      left join hrms_personnel b ON b.person_code = a.person_card_no
      left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
      left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
      left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
      left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
      where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
      on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
      where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 and a.person_card_no='$card_no' $from_date_cond order by trunc(ATTENDANCE_DATE) asc");
        // dd($dailAttendanceReportSearch);
      return Template::loadview("admin.reports.hrm.individual_daily_attendance_report_list", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch]);
    }

    public function individualDailyAttendanceReportPrintV1(Request $request)
    {

        $report_type = $request->hdn_report_type;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $user_info = Auth::user();
        $card_no = $user_info->user_code;

        $from_date_cond = ($request->date_pic != ""  && $request->date_pic2 != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $dailAttendanceReportPrints = DB::select("select a.entry_type, a.manual_status, a.early_time_min, a.attendance_date
      ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
      a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
      , su.serviceunit_name, shift.shift_code, case when a.attendance_status in (8,9,3,4) then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
      from hrms_attendance_daily a
      left join hrms_personnel b ON b.person_code = a.person_card_no
      left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
      left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
      left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
      left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
      where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
      on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
      where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 and a.person_card_no='$card_no' $from_date_cond order by trunc(ATTENDANCE_DATE) asc");

        $dailAttendanceReportPrint = [];
        if (!empty($dailAttendanceReportPrints)) {
            foreach ($dailAttendanceReportPrints as $key => $value) {
                $dailAttendanceReportPrint[$value->full_name . '*' . $value->person_card_no . '*' . $value->serviceunit_name . '*' . $value->designation_name][] = $value;
            }
        }

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.reports.hrm.individual_daily_attendance_print_report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no]);
            return $pdf->stream('daily_attendance_print_report.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no];
            $fileToExport = "daily_attendance_print_report";
            $html = View("admin.reports.hrm.individual_daily_attendance_print_report")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }




    public function dailyAttendanceReportNightPrint(Request $request)
    {
        $dept = ServiceUnit::where('serviceunit_no_pk', $request->department_name)->select('serviceunit_name')->first();
        $desig = Designation::where('designation_no_pk', $request->designation_name)->select('designation_name')->first();

        $dept_con = (!empty($dept) ? $dept->serviceunit_name : "");
        // dd($dept_con);
        $desig_con = (!empty($desig) ? $desig->designation_name : "");
        $att_status_condition = (!empty($request->att_status) ? $request->att_status : "");

        $personal_no_pk = $request->card_hidn;
        $att_status = $request->att_status;
        $designation = $request->designation_name;
        // dd($designation);
        $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $card = (!empty($card_no) ? $card_no->person_card_no : "");

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_card_no'" : "";
        if ($att_status == 1) {
            $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        } else {
            $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        }
        // dd($date_cond);
        $dailAttendanceReportPrint = DB::select("select a.attendance_date,
        a.duty_in_time,
        a.duty_out_time,
        a.in_time,
        a.out_time,
        a.over_time_min,
        a.late_time_min,
        b.photo_name,
        a.person_card_no,
        a.attendance_status_text,
        a.attendance_status,
        b.full_name,
        c.designation_name,
        su.serviceunit_name,
        shift.shift_code
   from hrms_attendance_daily a
        left join hrms_personnel b
           on b.person_code = a.person_card_no
        left join hrms_designation c
           on c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su
           on su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift
           on a.duty_shift_no_fk = shift.shift_no_pk
  where a.person_card_no is not null
  and shift.shift_desc = 'NIGHT' and b.status = 1 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by a.attendance_date ASC");


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition])->setPaper('a4', 'landscape');
        return $pdf->stream('daily_attendance_report_print.pdf');
    }


    public function dailyAttendanceReportexcel(Request $request)
    {

        $dept = ServiceUnit::where('serviceunit_no_pk', $request->department_name)->select('serviceunit_name')->first();
        $desig = Designation::where('designation_no_pk', $request->designation_name)->select('designation_name')->first();

        $dept_con = (!empty($dept) ? $dept->serviceunit_name : "");
        // dd($dept_con);
        $desig_con = (!empty($desig) ? $desig->designation_name : "");
        $att_status_condition = (!empty($request->att_status) ? $request->att_status : "");

        $personal_no_pk = $request->card_hidn;
        $att_status = $request->att_status;
        $designation = $request->designation_name;
        // dd($designation);
        $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $card = (!empty($card_no) ? $card_no->person_card_no : "");

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_card_no'" : "";
        if ($att_status == 1) {
            $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        } else {
            $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        }
        // dd($date_cond);
        if (Session::get('user.ses_hospital_code') == 'EWMCH') {

            //$from_date_cond = " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$from_date','DD-MM-YYYY') ";
            $dailAttendanceReportPrint = DB::select("select a.entry_type, a.early_time_min, a.attendance_date
            ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
            a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
            , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
            from hrms_attendance_daily a
            left join hrms_personnel b ON b.person_code = a.person_card_no
            left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
            left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
            left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
            left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
            where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
            on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
            where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond");
        } else {
            $dailAttendanceReportPrint = DB::select("select a.entry_type, a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,
            a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and nvl(b.virtual_ind,0)=0 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by a.attendance_date ASC");
        }



        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ["po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition])->setPaper('a4', 'landscape');
        // return $pdf->stream('daily_attendance_report_print.pdf');

        $pdf = ["po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition];

        if (Session::get('user.ses_hospital_code') == 'EWMCH') {
            $fileToExport = "daily_attendance_report_print_excel_ewmch";
            $html = View("admin.reports.hrm.daily_attendance_report_excel_ewmch")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
        } else {
            $fileToExport = "daily_attendance_report_print_excel";
            $html = View("admin.reports.hrm.daily_attendance_report_excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
        }

        return $html;
    }


    public function dailyAttendanceReportDataPrint(Request $request)
    {
        $dept = ServiceUnit::where('serviceunit_no_pk', $request->department_name)->select('serviceunit_name')->first();
        $desig = Designation::where('designation_no_pk', $request->designation_name)->select('designation_name')->first();

        $dept_con = (!empty($dept) ? $dept->serviceunit_name : "");
        // dd($dept_con);
        $desig_con = (!empty($desig) ? $desig->designation_name : "");
        $att_status_condition = (!empty($request->att_status) ? $request->att_status : "");

        $personal_no_pk = $request->card_hidn;
        $att_status = $request->att_status;
        $designation = $request->designation_name;
        // dd($designation);
        $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $card = (!empty($card_no) ? $card_no->person_card_no : "");

        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_card_no'" : "";
        if ($att_status == 1) {
            $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        } else {
            $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        }
        // // dd($date_cond);
        //                         $dailAttendanceReportPrint = DB::select("select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,
        //                             a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by a.attendance_date ASC");

        $dailAttendanceReportPrint = DB::select("select b.person_no_pk,b.join_date, a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,
							a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time , a.over_time_min,a.late_time_min,b.photo_name, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code ,b.person_no_pk,b.join_date order by serviceunit_name");


        $total_employee = DB::select("select e.serviceunit_no_fk, e.su_name, count (a.person_no_fk)  total_emp from hrms_attendance_daily a left join employee_info_vw e on e.person_no_pk =  a.person_no_fk left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by e.serviceunit_no_fk, e.su_name ");


        $att_status = DB::select("select e.serviceunit_no_fk, e.su_name, count (a.attendance_status)  attendance_status from hrms_attendance_daily a left join employee_info_vw e on e.person_no_pk =  a.person_no_fk left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and a.attendance_status between  1 and  2 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by e.serviceunit_no_fk, e.su_name ");

        $absent_status = DB::select("select e.serviceunit_no_fk, e.su_name, count (a.attendance_status)  attendance_status from hrms_attendance_daily a left join employee_info_vw e on e.person_no_pk =  a.person_no_fk left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and a.attendance_status = 5 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by e.serviceunit_no_fk, e.su_name ");

        $leave_status = DB::select("select e.serviceunit_no_fk, e.su_name, count (a.attendance_status)  attendance_status from hrms_attendance_daily a left join employee_info_vw e on e.person_no_pk =  a.person_no_fk left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and a.attendance_status = 3 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by e.serviceunit_no_fk, e.su_name ");

        $offDay_status = DB::select("select e.serviceunit_no_fk, e.su_name, count (a.attendance_status)  attendance_status from hrms_attendance_daily a left join employee_info_vw e on e.person_no_pk =  a.person_no_fk left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk where a.person_card_no IS NOT NULL and a.attendance_status = 6 $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con group by e.serviceunit_no_fk, e.su_name ");


        $emp_data = [];
        if (!empty($dailAttendanceReportPrint)) {
            foreach ($dailAttendanceReportPrint as $attendance) {
                $emp_data[$attendance->serviceunit_name][$attendance->person_no_pk] = $attendance;
            }
        }
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->su_name] = $value->total_emp;
            }
        }
        $attendance_status = [];
        if (!empty($att_status)) {
            foreach ($att_status as $value) {
                $attendance_status[$value->su_name] = $value->attendance_status;
            }
        }
        $abs_status = [];
        if (!empty($absent_status)) {
            foreach ($absent_status as $value) {
                $abs_status[$value->su_name] = $value->attendance_status;
            }
        }
        $l_status = [];
        if (!empty($leave_status)) {
            foreach ($leave_status as $value) {
                $l_status[$value->su_name] = $value->attendance_status;
            }
        }
        $offD_status = [];
        if (!empty($offDay_status)) {
            foreach ($offDay_status as $value) {
                $offD_status[$value->su_name] = $value->attendance_status;
            }
        }


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_data_print", ['po_hospital_details' => $po_hospital_details, 'emp_data' => $emp_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition, 'count_depart_emp' => $count_depart_emp, 'attendance_status' => $attendance_status, 'abs_status' => $abs_status, 'l_status' => $l_status, 'offD_status' => $offD_status])->setPaper('a4', 'portrait');
        return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function dailyMachineAttendanceReportPrint(Request $request)
    {
        $pk_no = $request->card_hidn;
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $pk_no)->first();
        // dd($card_no);
        $department = $request->department_name;
        $from_date = date("d-m-Y", strtotime($request->date_pic));
        $to_date = date("d-m-Y", strtotime($request->date_pic2));

        $card_no_con = ($request->card_no != "") ? "  and a.person_card_no='$card_no->person_code'" : "";
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $from_date_cond = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();


        $dailMachineAttendanceReportSearch = DB::select("select a.attendance_date,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time ,a.over_time_min,
							a.late_time_min , a.attendance_status_text,a.in_time_photo,a.out_time_photo ,a.person_card_no,b.photo_name, b.full_name,c.designation_name, su.serviceunit_name from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk where person_card_no IS NOT NULL $card_no_con $department_con $from_date_cond order by a.attendance_date ASC");
        // dd($dailMachineAttendanceReportSearch); 'sysc_serviceunit su', 'su.serviceunit_no_pk', '=', 'a.serviceunit_no_fk'

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        // dd( $po_hospital_details);
        // dd($dailMachineAttendanceReportSearch);
        $pdf = PDF::loadView("admin.reports.hrm.daily_machine_attendance_pdf", ['machine_data' => $dailMachineAttendanceReportSearch, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->download('daily_machine_attendance_pdf.pdf');
    }


    public function jobCardPrint(Request $request)
    {
        $name = $request->card_no;
        $personal_no_pk = $request->card_hidn;
        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);
        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $to_date = date("d/m/Y", strtotime($request->date_pic2));
        $date_cond = ($request->date_pic != "") ? "  a.attendance_date between to_date('$from_date','DD/MM/YYYY') and to_date('$to_date','DD/MM/YYYY') " : "";
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";

        // dd($from_date);


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if (!empty($card_no_con)) {
            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();


            $jobCardPrint = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time, d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $jobCardPrint = [];
            $details = [];
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.reports.hrm.job_card_print", ['po_hospital_details' => $po_hospital_details, 'value' => $jobCardPrint, 'date' => $from_date, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'ta_date' => $to_date, 'details' => $details])->setPaper('a4', 'portrait');
        return $pdf->stream('job_card_print.pdf');
    }

    public function emp_att_rep_print(Request $request)
    {
        $name = $request->card_no;
        $personal_no_pk = $request->card_hidn;
        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);
        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $to_date = date("d/m/Y", strtotime($request->date_pic2));
        $date_cond = ($request->date_pic != "") ? "  a.attendance_date between to_date('$from_date','DD/MM/YYYY') and to_date('$to_date','DD/MM/YYYY') " : "";
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";

        // dd($from_date);


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if (!empty($card_no_con)) {
            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();


            $jobCardPrint = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time, d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $jobCardPrint = [];
            $details = [];
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.reports.hrm.emp_att_rep_print", ['po_hospital_details' => $po_hospital_details, 'value' => $jobCardPrint, 'date' => $from_date, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'ta_date' => $to_date, 'details' => $details])->setPaper('a4', 'portrait');
        return $pdf->stream('Employee_Attendance_Report.pdf');
    }
    public function emp_att_rep_excel(Request $request)
    {
        $name = $request->card_no;
        $personal_no_pk = $request->card_hidn;
        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);
        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $to_date = date("d/m/Y", strtotime($request->date_pic2));
        $date_cond = ($request->date_pic != "") ? "  a.attendance_date between to_date('$from_date','DD/MM/YYYY') and to_date('$to_date','DD/MM/YYYY') " : "";
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";

        // dd($from_date);


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if (!empty($card_no_con)) {
            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();


            $jobCardPrint = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time, d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $jobCardPrint = [];
            $details = [];
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();



        $pdf = ['po_hospital_details' => $po_hospital_details, 'value' => $jobCardPrint, 'date' => $from_date, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'ta_date' => $to_date, 'details' => $details];

        $fileToExport = "Employee_Attendance_Report";
        $html = View("admin.reports.hrm.emp_att_rep_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function jobCardexcel(Request $request)
    {
        $name = $request->card_no;
        $personal_no_pk = $request->card_hidn;
        $card_no = DB::table('hrms_attendance_daily_vw')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        // dd($card_no);
        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $to_date = date("d/m/Y", strtotime($request->date_pic2));
        $date_cond = ($request->date_pic != "") ? "  a.attendance_date between to_date('$from_date','DD/MM/YYYY') and to_date('$to_date','DD/MM/YYYY') " : "";
        $card_no_con = (!empty($card_no->person_card_no)) ? " and a.person_card_no='$card_no->person_card_no'" : "";

        // dd($from_date);


        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if (!empty($card_no_con)) {
            $details = DB::table('hrms_attendance_daily_vw')->select('hrms_attendance_daily_vw.person_card_no', 'hrms_personnel.duty_roster_type', 'hrms_attendance_daily_vw.full_name', 'hrms_attendance_daily_vw.salutation', 'hrms_attendance_daily_vw.department', 'specialization_wise_doc_count_vw.specialization_name', 'hrms_attendance_daily_vw.join_date', 'hrms_attendance_daily_vw.phone_mobile', 'hrms_attendance_daily_vw.photo_name', 'hrms_designation.designation_name', 'hrms_grade.grade_name')->leftjoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'hrms_attendance_daily_vw.person_no_fk')->leftjoin('hrms_designation', 'hrms_designation.designation_no_pk', '=', 'hrms_personnel.jobtitle_lookup_no_fk')->leftjoin('hrms_grade', 'hrms_grade.grade_no_pk', '=', 'hrms_personnel.grade_no_fk')->leftjoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_attendance_daily_vw.duty_shift_no_fk')->leftjoin('specialization_wise_doc_count_vw', 'specialization_wise_doc_count_vw.specialization_id', '=', 'hrms_personnel.specialization_lookup_no_fk')->where('hrms_attendance_daily_vw.person_card_no', $card_no->person_card_no)->first();


            $jobCardPrint = DB::select("select a.attendance_date,a.attendance_status,a.attendance_status_text, a.person_card_no, a.full_name,c.designation_name,a.in_time,a.late_time_min,a.out_time,a.over_time_min,a.lunch_out_time, a.lunch_in_time, d.shift_code,d.start_time, d.end_time from hrms_attendance_daily_vw a left join hrms_personnel b on b.person_no_pk = a.person_no_fk left join hrms_designation c on c.designation_no_pk = b.jobtitle_lookup_no_fk left join hrms_shift d on d.shift_no_pk = a.duty_shift_no_fk where  $date_cond  $card_no_con order by a.attendance_date ASC");
        } else {
            $jobCardPrint = [];
            $details = [];
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();



        $pdf = ['po_hospital_details' => $po_hospital_details, 'value' => $jobCardPrint, 'date' => $from_date, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'ta_date' => $to_date, 'details' => $details];

        $fileToExport = "job_card_print_excel";
        $html = View("admin.reports.hrm.job_card_print_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function dailyLateReportPrint(Request $request)
    {
        // dd('dddd');
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->card_hidn;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(attendance_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        $dailLateReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2 $sql_cond ");

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // $dailLateReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2  $date_cond  $card_no_con ");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.reports.hrm.daily_late_report_print", ['po_hospital_details' => $po_hospital_details, 'value' => $dailLateReportSearch, 'date_from' => $date_from, 'date_to' => $date_to, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->stream('daily_late_report_print.pdf');
    }

    public function dailyLateReportExcel(Request $request)
    {
        $card_no = $request->card_hidn;

        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $dailLateReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.late_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=2  $date_cond  $card_no_con ");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $pdf = ['po_hospital_details' => $po_hospital_details, 'value' => $dailLateReportSearch, 'date' => $from_date, 'barcode_no' => $barcode_no];

        $fileToExport = "daily_late_report_excel";
        $html = View("admin.reports.hrm.daily_late_report_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function dailyAbsentReportPrint(Request $request)
    {
        // dd('dddd');
        $card_no = $request->card_hidn;

        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $dailAbsentReportPrint = DB::select("select a.person_card_no, b.full_name, c.designation_name,a.duty_in_time,a.in_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1   $date_cond  $card_no_con ");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.reports.hrm.daily_absent_report_print", ['po_hospital_details' => $po_hospital_details, 'value' => $dailAbsentReportPrint, 'date' => $from_date, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->stream('daily_absent_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function dailyAbsentReportExcel(Request $request)
    {
        $card_no = $request->card_hidn;

        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $dailAbsentReportPrint = DB::select("select a.person_card_no, b.full_name, c.designation_name,a.duty_in_time,a.in_time, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.attendance_status=1   $date_cond  $card_no_con ");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $pdf = ['po_hospital_details' => $po_hospital_details, 'value' => $dailAbsentReportPrint, 'date' => $from_date, 'barcode_no' => $barcode_no];

        $fileToExport = "daily_absent_report_excel.blade";
        $html = View("admin.reports.hrm.daily_absent_report_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function attendanceReportPrint(Request $request)
    {
        // dd('dddd');
        $card_no = $request->card_hidn;

        $from_date = date("d/m/Y", strtotime($request->date_pic));
        //dd(    $from_date);
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $AttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.out_time,a.late_time_min,a.over_time_min, a.conflict_comments,a.late_early_leave_note,
        a.early_time_min from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_lookupdata jobtype
        on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where a.attendance_status=1 and nvl(virtual_ind,0)=0   $date_cond  $card_no_con order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = date("Y-m-d", strtotime($request->date_pic));
        $pdf = PDF::loadView("admin.reports.hrm.attendance_report_print", ['po_hospital_details' => $po_hospital_details, 'value' => $AttendanceReportSearch, 'from_date' => $from_date, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->stream('attendance_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function attendanceReportexcel(Request $request)
    {
        $card_no = $request->card_hidn;

        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $date_cond = ($request->date_pic != "") ? " and attendance_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk=$card_no" : "";

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $AttendanceReportSearch = DB::select("select a.person_card_no, b.full_name,c.designation_name,a.duty_in_time,a.in_time,a.out_time,a.late_time_min,a.over_time_min, a.conflict_comments from hrms_attendance_daily a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_lookupdata jobtype
        on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where a.attendance_status=1
        and nvl(virtual_ind,0)=0   $date_cond  $card_no_con order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf =  ['po_hospital_details' => $po_hospital_details, 'value' => $AttendanceReportSearch, 'date' => $from_date, 'barcode_no' => $barcode_no];

        $fileToExport = "attendance_report_print_excel";
        $html = View("admin.reports.hrm.attendance_report_print_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function dailyLeaveReportPrint(Request $request)
    {


        $card_no = $request->card_hidn;
        $from_date = date("d/m/Y", strtotime($request->date_pic));
        $to_date = date("d/m/Y", strtotime($request->date_pic2));
        $from_date_cond = "and to_date('$from_date','dd/mm/yyyy') between a.from_date   AND a.to_date ";
        $to_date_cond = "and to_date('$to_date','dd/mm/yyyy') between a.from_date   AND a.to_date ";
        $card_no_con = ($request->card_no != "") ? " and person_no_fk= $card_no" : "";

        $title = "Daily Leave Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $dailyLeaveReportSearch = DB::select("select b.person_code, b.full_name,c.designation_name,b.join_date,trunc(a.from_date) from_date , trunc(a.to_date) to_date, a.leave_reason from hrms_leave_entry a left join hrms_personnel b ON b.person_no_pk = a.person_no_fk left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk where a.status=1 $from_date_cond $to_date_cond $card_no_con  ");

        $pdf = PDF::loadView("admin.reports.hrm.daily_leave_report_print", ['value' => $dailyLeaveReportSearch, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->download('daily_leave_report_print.pdf');
    }

    public function dailyQuestionableEntryReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.daily_questionable_entry_report_print");
        return $pdf->download('daily_questionable_entry_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function dailyAttendanceSummaryReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_summary_report_print");
        return $pdf->download('daily_attendance_summary_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function departmentWiseDailySummaryReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.department_wise_daily_attendance_summary_report_print");
        return $pdf->download('department_wise_daily_attendance_summary_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function dailyManpowerSummaryReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.daily_manpower_summary_report_print");
        return $pdf->download('daily_manpower_summary_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function dailyAdjustedEntriesReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.daily_adjusted_entries_report_print");
        return $pdf->download('daily_adjusted_entries_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function monthlyAttendanceDetailsPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.monthly_attendance_details_report_print");
        return $pdf->download('monthly_attendance_details_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function detailedJobCardSummaryPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.detailed_job_card_summary_print");
        return $pdf->download('detailed_job_card_summary_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function monthlyLateReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.monthly_late_print");
        return $pdf->download('monthly_late_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function leaveSummaryReportPrint(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));

        if ($card_no == "") {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            group by person_code,full_name,designation_name,su_name
            ");
        } else {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and person_no_fk = '$card_no'
            group by person_code,full_name,designation_name,su_name
            ");
        }

        // dd($leave_summary);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.reports.hrm.leave_summary_print", compact('po_hospital_details', 'leave_summary', 'from_date', 'to_date'));

        return $pdf->stream('leave_summary_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function leaveSummaryReportexcel(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));

        if ($card_no == "") {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            group by person_code,full_name,designation_name,su_name
            ");
        } else {
            $leave_summary = DB::select("select person_code,full_name,designation_name,su_name,sum(total_leave) leave_request,sum(available_leave) available_leave,count(approved_hr_ind) approved_leave
            from hrms_leave_entry_vw
            where approved_hr_ind = 1
            and approved_dept_ind = 1
            and trunc(au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and person_no_fk = '$card_no'
            group by person_code,full_name,designation_name,su_name
            ");
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $pdf = ['po_hospital_details' => $po_hospital_details, 'leave_summary' => $leave_summary, 'from_date' => $from_date, 'to_date' => $to_date];
        $fileToExport = "leave_summary_print_excel";
        $html = View("admin.reports.hrm.leave_summary_print_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function monthlyQuestionableEntryReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.monthly_questionable_entry_report_print");
        return $pdf->download('monthly_questionable_entry_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function manuallyAdjustedEntriesMonthlyPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.manually_adjusted_entries_monthly_print");
        return $pdf->download('manually_adjusted_entries_monthly_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function overTimeSheetPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.overtime_sheet_print");
        return $pdf->download('overtime_sheet_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function summaryWagesPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.summary_wages_print");
        return $pdf->download('summary_wages_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function punchCardTakerPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.punch_card_taker_print");
        return $pdf->download('punch_card_taker_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function yearlyLateReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.yearly_late_report_print");
        return $pdf->download('yearly_late_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function yearlyAbsentReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.yearly_absent_report_print");
        return $pdf->download('yearly_absent_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function monthlyAbsentReportPrint(Request $request)
    {
        // $card_no = $request->card_no;
        // $from_date = date("d-m-Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD-MM-YYYY') " : "";
        // $card_no_con = ($request->card_no != "") ? " and DOCTOR_NO_FK=$card_no" : "";

        // $dailAttendanceReportSearch = DB::select("select a.doctor_no_fk,a.appoint_date, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 $date_cond $card_no_con ");

        $pdf = PDF::loadView("admin.reports.hrm.monthly_absent_report_print");
        return $pdf->download('monthly_absent_report_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }


    public function monthlySalaryPrint(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";

        $monthlySalaryReportprint = DB::select("select other_deduct_amount, person_no_pk,card_no,serviceunit_name,monthly_salary_no_pk,
                                                    person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance, full_name,
                                                    designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,
                                                    att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days,
                                                    residence_fee, leave_days,leave_withoutpay_days,personal_savings_amount
                                                    from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con order by serviceunit_name");

        // dd($monthlySalaryReportprint);
        $total_employee = DB::select("select  serviceunit_name, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  serviceunit_name");

        $t_salary = DB::select("select  serviceunit_name, sum(payable_amount)  total_emp_salary from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  serviceunit_name");
        // dd($monthlySalaryReportprint);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->serviceunit_name][$salarySheet->person_no_pk] = $salarySheet;
            }
        }
        //dd($total_employee, $emp_data);
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->serviceunit_name] = $value->total_emp;
            }
        }

        $total_salary = [];
        if (!empty($t_salary)) {
            foreach ($t_salary as $value) {
                $total_salary[$value->serviceunit_name] = $value->total_emp_salary;
            }
        }

        // dd($count_depart_emp);

        $from_date = date('d/m/Y');
        $title = " monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->stream('monthly_salary_print.pdf');
    }


    public function monthlySalaryPrintPk(Request $request)
    {
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        // $cutoff_start = $salaryData->cut_off_strday;
        // $cutoff_end = $salaryData->cut_off_endday;
        if (isset($salaryData) &&  $salaryData->cut_off_ind == 1) {
            $startDate = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $endtDate = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $startDate = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $endtDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        // no of days from a month/date range calculation
        $totalDaysInMonth = isset($startDate) && isset($endtDate) ? countDays($startDate, $endtDate) + 1 : "";
        // no of fridays from a month/date range calculation
        $weekendCount = isset($startDate) && isset($endtDate) ? countFridays($startDate, $endtDate) : "";
        //holidays
        $firstDateOfMonth = Carbon::parse($startDate)->format('d/m/Y');
        $lastDateOfMonth = Carbon::parse($endtDate)->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        $holidayArray = [];
        if (!empty($holidayData)) {
            foreach ($holidayData as $data) {
                $partData = explode(" ", $data->holiday_date);
                $holidayArray[] = ($partData[0]);
            }
        }
        $holidays = array_unique($holidayArray);
        //
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $bank_name" : "";

        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $monthlySalaryReportprint = DB::select("select working_hour, lookupdata_desc, serial_no, ot_time, other_deduct_amount, person_no_pk,card_no,serviceunit_name,monthly_salary_no_pk,
            person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance, full_name,
            designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,
            att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days,
            residence_fee, leave_days,leave_withoutpay_days, working_days, personal_savings_amount, conveyance_allowance,
            ta_da_allowance, night_allowance, advance_amt, incometax_deduct_amount, absent_amount,  revenue_stamp, join_date, addndeduct_no_pk, add_revision, add_arrear, add_ot, ded_ait, ded_food_bill, ded_pf, ded_adv, ded_med_bill, ded_salary, ded_lwp, ded_emb, ded_others, holiday, servicedept_name, bank_acc_no
            from hrms_monthly_salary_wl_vw  where status=1  and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con order by serial_no asc, card_no asc");
        } else {
            $monthlySalaryReportprint = DB::select("select working_hour, lookupdata_desc, serial_no, ot_time, other_deduct_amount, person_no_pk,card_no,serviceunit_name,monthly_salary_no_pk,
            person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance, full_name,
            designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,
            att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days,
            residence_fee, leave_days,leave_withoutpay_days, working_days, personal_savings_amount, conveyance_allowance,
            ta_da_allowance, night_allowance, advance_amt, incometax_deduct_amount, absent_amount, revenue_stamp, join_date
            from hrms_monthly_salary_wl_vw  where status=1 and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con order by serial_no asc, card_no asc");
        }

        $total_employee = DB::select("select lookupdata_desc, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by lookupdata_desc");

        $t_salary = DB::select("select  lookupdata_desc, sum(payable_amount)  total_emp_salary, sum(gross_salary) as total_gross_salary,
        sum(night_allowance) as total_night_allowance, sum(advance_amt) as total_advance_amt, sum(incometax_deduct_amount) as total_incometax_deduct_amount,
        sum(revenue_stamp) as total_revenue_stamp from hrms_monthly_salary_wl_vw  where status=1  and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con group by  lookupdata_desc");
        // dd($t_salary);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->lookupdata_desc][$salarySheet->person_no_pk] = $salarySheet;
            }
        }
        // dd($emp_data);
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->lookupdata_desc] = $value->total_emp;
            }
        }

        $total_salary = [];
        if (!empty($t_salary)) {
            foreach ($t_salary as $value) {
                // $total_salary[$value->serviceunit_name] = $value->total_emp_salary;
                $total_salary[$value->lookupdata_desc] = $value->total_gross_salary + $value->total_night_allowance - $value->total_advance_amt - $value->total_incometax_deduct_amount
                    - $value->total_revenue_stamp;
            }
        }

        // dd($count_depart_emp);

        $from_date = date('d/m/Y');
        $title = " monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        if (Session::get('user.ses_hospital_code') == 'AMCSH') {
            $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_pk_amcsh", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'po_hospital_details' => $po_hospital_details, 'monthlySalaryReportprint' => $monthlySalaryReportprint, 'totalDaysInMonth' => $totalDaysInMonth, 'weekendCount' => $weekendCount])->setPaper('a4', 'landscape');
            return $pdf->download('monthly_salary_print_pk_amcsh.pdf');
        } elseif (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_pk_unico", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'po_hospital_details' => $po_hospital_details, 'monthlySalaryReportprint' => $monthlySalaryReportprint, 'totalDaysInMonth' => $totalDaysInMonth, 'weekendCount' => $weekendCount, 'holidays' => $holidays, 'startDate' => $startDate, 'endtDate' => $endtDate])->setPaper('a2', 'landscape');
            return $pdf->download('monthly_salary_print_unico.pdf');
        } else {
            $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_pk", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
            // $dom_pdf = $pdf->getDomPDF();
            // $canvas = $dom_pdf->get_canvas();
            // $canvas->page_text(520, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->download('monthly_salary_print_jk.pdf');
        }
    }
    public function monthlySalarySlipPrintV1($id, $salary)
    {
        $slip = DB::table('hrms_monthly_salary_wl_vw')->select('card_no', 'monthly_salary_no_pk', 'overtime_hours', 'overtime_rate', 'overtime_amount', 'other_allowance', 'conveyance_allowance', 'ta_da_allowance', 'full_name', 'designation_name', 'gross_salary', 'basic_salary', 'medical_allowance', 'house_rent', 'attendance_bonus', 'att_deduct_amount', 'loan_deduct_amount', 'payable_amount', 'attendance_days', 'late_days', 'absent_days', 'leave_days', 'working_days', 'leave_withoutpay_days', 'personal_savings_amount', 'salary_yyyymm', 'residence_fee', 'disciplinary_action', 'join_date', 'servicedept_name', 'bank_acc_no', 'add_arrear', 'add_revision', 'add_ot', 'ded_emb', 'ded_food_bill', 'ded_pf', 'ded_others', 'ded_ait', 'ded_adv', 'ded_med_bill', 'ded_salary', 'ded_lwp', 'incometax_deduct_amount')->where('monthly_salary_no_pk', $id)->first();
        $carbonDate = Carbon::createFromFormat('Ym', $slip->salary_yyyymm);
        $outputDate = $carbonDate->format("M'Y");
        // dd($slip);
        $title = "Salary Slip";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.reports.hrm.salary_slip_v1", ['data' => $slip, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'salary' => $salary, 'outputDate' => $outputDate,])->setPaper('a4', 'portrait');
        return $pdf->download('salary_slip.pdf');
    }


    public function monthlySalaryPrintBankWise(Request $request)
    {

        // dd($request->card_hidn);
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $request->bank_id" : "";

        $monthlySalaryReportprint = DB::select("select other_deduct_amount, person_no_pk,agent_banking_type_name,card_no,serviceunit_name,monthly_salary_no_pk,person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance, full_name,designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,att_deduct_amount,loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days, residence_fee, leave_days,leave_withoutpay_days,personal_savings_amount from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con $bank_no_con order by serviceunit_name");


        // $total_employee =  DB::select("select agent_banking_type,serviceunit_no_pk, serviceunit_name, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where  status=1   $card_no_con $month_year_con group by agent_banking_type,serviceunit_no_pk, serviceunit_name");

        // $t_salary =  DB::select("select  agent_banking_type,serviceunit_name, sum(payable_amount)  total_emp_salary from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  serviceunit_name, agent_banking_type");

        $total_employee_bank_wise = DB::select("select agent_banking_type, agent_banking_type_name, count(person_no_pk)  total_emp_bank_wise from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by agent_banking_type, agent_banking_type_name");

        $t_salary_bank_wise = DB::select("select  agent_banking_type_name, sum(payable_amount)  total_emp_salary_bank_wise from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  agent_banking_type_name");
        // dd($monthlySalaryReportprint);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->agent_banking_type_name][$salarySheet->serviceunit_name][$salarySheet->person_no_pk] = $salarySheet;
            }
        }


        $count_depart_emp_bank_wise = [];
        if (!empty($total_employee_bank_wise)) {
            foreach ($total_employee_bank_wise as $value) {
                $count_depart_emp_bank_wise[$value->agent_banking_type_name] = $value->total_emp_bank_wise;
            }
        }

        $total_salary_bank_wise = [];
        if (!empty($t_salary_bank_wise)) {
            foreach ($t_salary_bank_wise as $value) {
                $total_salary_bank_wise[$value->agent_banking_type_name] = $value->total_emp_salary_bank_wise;
            }
        }

        // dd($total_salary_bank_wise);

        $from_date = date('d/m/Y');
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_bank_wise", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'total_salary_bank_wise' => $total_salary_bank_wise, 'count_depart_emp_bank_wise' => $count_depart_emp_bank_wise])->setPaper('a4', 'landscape');
        return $pdf->download('monthly_salary_print_bank_wise.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function monthlySalaryPrintBankWisePk(Request $request)
    {

        // dd($request->card_hidn);
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and agent_banking_type = $request->bank_id" : "";

        $monthlySalaryReportprint = DB::select("select other_deduct_amount, person_no_pk,agent_banking_type_name,card_no,
        serviceunit_name,monthly_salary_no_pk,person_no_pk,overtime_hours,overtime_rate,overtime_amount ,other_allowance,
        full_name,designation_name,gross_salary,basic_salary,medical_allowance,house_rent,attendance_bonus,att_deduct_amount,
        loan_deduct_amount,payable_amount,attendance_days, late_days, absent_days, residence_fee, leave_days,
        leave_withoutpay_days,personal_savings_amount, conveyance_allowance,  ta_da_allowance, night_allowance,
        advance_amt, incometax_deduct_amount, revenue_stamp from hrms_monthly_salary_wl_vw
         where status=1 and au_entry_hospital_pk_no = $hospital_no_pk $card_no_con $month_year_con $bank_no_con order by serviceunit_name");


        // $total_employee =  DB::select("select agent_banking_type,serviceunit_no_pk, serviceunit_name, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where  status=1   $card_no_con $month_year_con group by agent_banking_type,serviceunit_no_pk, serviceunit_name");

        // $t_salary =  DB::select("select  agent_banking_type,serviceunit_name, sum(payable_amount)  total_emp_salary from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  serviceunit_name, agent_banking_type");

        $total_employee_bank_wise = DB::select("select agent_banking_type, agent_banking_type_name, count(person_no_pk)  total_emp_bank_wise from hrms_monthly_salary_wl_vw  where status=1 and au_entry_hospital_pk_no = $hospital_no_pk  $card_no_con $month_year_con group by agent_banking_type, agent_banking_type_name");

        $t_salary_bank_wise = DB::select("select  agent_banking_type_name, sum(payable_amount)  total_emp_salary_bank_wise from hrms_monthly_salary_wl_vw  where status=1 and au_entry_hospital_pk_no = $hospital_no_pk  $card_no_con $month_year_con group by  agent_banking_type_name");
        // dd($monthlySalaryReportprint);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->agent_banking_type_name][$salarySheet->serviceunit_name][$salarySheet->person_no_pk] = $salarySheet;
            }
        }
        // dd($emp_data);
        // $count_depart_emp = [];
        // if(!empty($total_employee)){
        //     foreach ($total_employee as  $value) {
        //         $count_depart_emp[$value->agent_banking_type][$value->serviceunit_name]= $value->total_emp;
        //         //$count_depart_emp[$value->agent_banking_type]['bank_id'] = $value->
        //     }
        // }
        // dd($count_depart_emp);

        // $total_salary = [];
        // if(!empty($t_salary)){
        //     foreach ($t_salary as  $value) {
        //         $total_salary[$value->agent_banking_type][$value->serviceunit_name]= $value->total_emp_salary;
        //     }
        // }


        $count_depart_emp_bank_wise = [];
        if (!empty($total_employee_bank_wise)) {
            foreach ($total_employee_bank_wise as $value) {
                $count_depart_emp_bank_wise[$value->agent_banking_type_name] = $value->total_emp_bank_wise;
            }
        }

        $total_salary_bank_wise = [];
        if (!empty($t_salary_bank_wise)) {
            foreach ($t_salary_bank_wise as $value) {
                $total_salary_bank_wise[$value->agent_banking_type_name] = $value->total_emp_salary_bank_wise;
            }
        }

        // dd($total_salary_bank_wise);

        $from_date = date('d/m/Y');
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.hrm.monthly_salary_print_bank_wise_pk", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'total_salary_bank_wise' => $total_salary_bank_wise, 'count_depart_emp_bank_wise' => $count_depart_emp_bank_wise])->setPaper('a4', 'landscape');
        return $pdf->download('monthly_salary_print_bank_wise_pk.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }


    public function employeeSalary()
    {
        // dd('ok');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $emp_salary = DB::table('hrms_personnel_salary s')
            ->leftjoin('employee_info_vw e', 'e.person_no_pk', '=', 's.person_no_fk')
            ->select('e.card_no', 'e.full_name', 'e.join_date', 'e.blood_group', 'e.bank_name', 'e.bank_acc_name', 'e.bank_acc_no', 'e.photo_name', 's.basic_salary', 's.house_rent', 's.medical_allow', 's.gross_salary', 's.personal_savings_amount', 'e.su_name', 'e.designation', 'e.person_no_pk', "e.serviceunit_no_fk")->get();

        $total_employee = DB::table("hrms_personnel_salary s")
            ->leftjoin("employee_info_vw e", 'e.person_no_pk', '=', 's.person_no_fk')
            ->select("e.serviceunit_no_fk", "e.su_name", DB::Raw("count (s.person_no_fk) as total_emp"), DB::Raw("sum (s.gross_salary) as total_salary"))
            ->groupBy("e.serviceunit_no_fk", "e.su_name")
            ->get();
        // dd($total_employee);
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->su_name] = $value->total_emp;
            }
        }

        $sum_salary = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $sum_salary[$value->su_name] = $value->total_salary;
            }
        }

        // dd($sum_salary);

        $salary_data = [];
        if (!empty($emp_salary)) {
            foreach ($emp_salary as $salary) {
                $salary_data[$salary->su_name][$salary->person_no_pk] = $salary;
            }
        }

        // dd($salary_data);
        return Template::loadview("admin.reports.hrm.employee_salary", ['salary_data' => $salary_data, 'count_depart_emp' => $count_depart_emp, 'sum_salary' => $sum_salary, 'dept' => $dept]);
    }

    public function employeeSalarySearch(Request $request)
    {
        $personal_no_pk = $request->card_hidn;
        $designation = $request->designation_name;
        $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and e.serviceunit_no_fk = $department" : "";
        $card_no_con = ($request->card_no != "") ? " and e.card_no='$card_no->person_card_no'" : "";


        $emp_salary = DB::select("select  e.card_no, e.full_name,e.join_date, e.blood_group, e.bank_name, e.bank_acc_name, e.bank_acc_no,e.photo_name ,s.basic_salary, s.house_rent, s.medical_allow, s.gross_salary, s.personal_savings_amount, e.su_name, e.designation, e.person_no_pk,e.serviceunit_no_fk from hrms_personnel_salary s left join employee_info_vw e on e.person_no_pk =  s.person_no_fk where s.status=1 $department_con $card_no_con ");


        $total_employee = DB::select("select e.serviceunit_no_fk, e.su_name, count (s.person_no_fk)  total_emp, sum (s.gross_salary) total_salary from hrms_personnel_salary s left join employee_info_vw e on e.person_no_pk =  s.person_no_fk where s.status=1 $department_con $card_no_con group by e.serviceunit_no_fk, e.su_name ");

        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->su_name] = $value->total_emp;
            }
        }

        $sum_salary = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $sum_salary[$value->su_name] = $value->total_salary;
            }
        }

        $salary_data = [];
        if (!empty($emp_salary)) {
            foreach ($emp_salary as $salary) {
                $salary_data[$salary->su_name][$salary->person_no_pk] = $salary;
            }
        }


        return Template::loadview("admin.reports.hrm.employee_salary_list", ['salary_data' => $salary_data, 'count_depart_emp' => $count_depart_emp, 'sum_salary' => $sum_salary]);
    }


    public function employeeSalaryPrint(Request $request)
    {
        $personal_no_pk = $request->card_hidn;
        $designation = $request->designation_name;
        $card_no = DB::table('hrms_attendance_daily')->select('person_card_no')->where('person_no_fk', $personal_no_pk)->first();
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and e.serviceunit_no_fk = $department" : "";
        $card_no_con = ($request->card_no != "") ? " and e.card_no='$card_no->person_card_no'" : "";

        $emp_salary = DB::select("select  e.card_no, e.full_name,e.join_date, e.blood_group, e.bank_name, e.bank_acc_name, e.bank_acc_no,e.photo_name ,s.basic_salary, s.house_rent, s.medical_allow, s.gross_salary, s.personal_savings_amount, e.su_name, e.designation, e.person_no_pk,e.serviceunit_no_fk from hrms_personnel_salary s left join employee_info_vw e on e.person_no_pk =  s.person_no_fk where s.status=1 $department_con $card_no_con ");


        $total_employee = DB::select("select e.serviceunit_no_fk, e.su_name, count (s.person_no_fk)  total_emp, sum (s.gross_salary) total_salary from hrms_personnel_salary s left join employee_info_vw e on e.person_no_pk =  s.person_no_fk where s.status=1 $department_con $card_no_con group by e.serviceunit_no_fk, e.su_name ");


        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->su_name] = $value->total_emp;
            }
        }

        $sum_salary = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $sum_salary[$value->su_name] = $value->total_salary;
            }
        }

        // dd($sum_salary);

        $salary_data = [];
        if (!empty($emp_salary)) {
            foreach ($emp_salary as $salary) {
                $salary_data[$salary->su_name][$salary->person_no_pk] = $salary;
            }
        }


        $from_date = date('d/m/Y');
        $title = " monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadview("admin.reports.hrm.employee_salary_print", ['salary_data' => $salary_data, 'count_depart_emp' => $count_depart_emp, 'sum_salary' => $sum_salary, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->download('employee_salary_print.pdf');
    }

    public function salaryProcessEdit($id)
    {
        $salary_process_data = DB::table('hrms_monthly_salary_wl_vw')->where('monthly_salary_no_pk', $id)->first();
        if (session('user.ses_hospital_code') == "JKMH") {
            return Template::loadview("admin.reports.hrm.monthly_salary_sheet_edit_jk", ['salary_process_data' => $salary_process_data]);
        }

        //dd($salary_process_data);
        return Template::loadview("admin.reports.hrm.monthly_salary_sheet_edit", ['salary_process_data' => $salary_process_data]);
    }

    public function monthlySalarySheetUpdate(Request $request)
    {

        // $id = $request->hdn_salary;
        $auth_id = Auth::id();
        // $salaryDate = DB::table('hrms_personnel_salary_monthly')->select('salary_yyyymm')->where('monthly_salary_no_pk',$id)->first();
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {


            $procedureName = "pkg_hrms_payroll.prc_salarysheet";
            $outError = $out_invoice_id = $out_invoice_no = '';
            $dataBindingArr = [
                'in_monthly_salary_no_pk' => $request->hdn_salary,
                'in_month_attend_no_pk' => $request->attend_hdn_month,
                'in_monthly_save_fund_no_pk' => $request->saving_hdn_month,
                'in_yyyymm' => $request->yearmonth,
                'in_attendance_bonus' => $request->attendance_bonus,
                'in_other_allowance' => $request->other_allowance,
                'in_overtime_hours' => $request->overtime_hours,
                'in_overtime_rate' => $request->overtime_rate,
                'in_overtime_amount' => $request->overtime_amount,
                'in_att_deduct_amount' => $request->abs_ded_amount,
                'in_GENERAL_FESTIVAL_DAYS' => $request->general_festival_days,
                'in_holidays' => $request->holidays,
                'in_loan_deduct_amount' => $request->advance,
                'in_other_deduct_amount' => $request->others_deduction,
                'in_late_days' => $request->late_day,
                'in_leave_days' => $request->leave_days,
                'in_leave_withoutpay_days' => $request->leave_withoutpay_days,
                'in_sick_leave_days' => $request->sick_leave,
                'in_casual_leave_days' => $request->casual_leave,
                'in_absent_days' => $request->absent_days,
                'in_attendance_days' => $request->present_day,
                'in_personal_savings_amount' => $request->saving_fund,
                'in_au_entry_by' => Auth::id(),
                'in_au_entry_session' => 'session',
                'in_au_entry_hospital_pk_no' => $hospital_no_pk,
                'out_process_no_pk' => [
                    'value' => &$out_invoice_no,
                    'type' => PDO::PARAM_INT
                ],
                'out_process_uid' => [
                    'value' => &$out_invoice_id,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ],
                'out_error' => [
                    'value' => &$outError,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ]
            ];
            //dd($dataBindingArr);
            $result = DB::executeProcedure($procedureName, $dataBindingArr);
            // dd($result);
            // echo $outError;
            // die;

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'Monthly Salary Process Completed Successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Monthly Salary sheet Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function monthlySalarySheetUpdateFromAttendance(Request $request)
    {

        // $id = $request->hdn_salary;
        $auth_id = Auth::id();
        // $salaryDate = DB::table('hrms_personnel_salary_monthly')->select('salary_yyyymm')->where('monthly_salary_no_pk',$id)->first();
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        try {

            foreach ($request->person_card_no as $i => $val) {
                DB::table("hrms_attendance_monthly")
                    ->where('person_card_no', $request->person_card_no[$i])
                    ->where('attendance_yyyymm', isset($request->attendance_yyyymm[$i]) ? $request->attendance_yyyymm[$i] : '')
                    ->update([
                        'general_festival_days' => isset($request->general_festival_days[$i]) ? $request->general_festival_days[$i] : '',
                        'holidays' => isset($request->holidays[$i]) ? $request->holidays[$i] :  '',
                        'late_days' => isset($request->late_days[$i]) ?  $request->late_days[$i] :  '',
                        'leave_withoutpay_days' => isset($request->leave_withoutpay_days[$i]) ? $request->leave_withoutpay_days[$i] : '',
                        'sick_leave' => isset($request->sick_leave[$i]) ? $request->sick_leave[$i] : '',
                        'casual_leave' => isset($request->casual_leave[$i]) ? $request->casual_leave[$i] : '',
                        'absent_days' => isset($request->absent_days[$i]) ? $request->absent_days[$i] : '',
                        // 'attendance_days' => $request->present_day[$i],
                    ]);
            }
            $message = ['msg' => 'Monthly attendance Process Completed Successfully.', 'title' => 'Success'];
            // if ($outError == '000') {
            //     DB::commit();
            //     $message = ['msg' => 'Monthly Salary Process Completed Successfully.', 'title' => 'Success'];
            // } else {
            //     DB::rollback();
            //     $message = ['msg' => 'Monthly Salary sheet Process Failed', 'title' => 'Error'];
            // }
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function specificMonthlySalarySheetUpdate2(Request $request)
    {
        $ids = $request->ids;
        $night_allowances = $request->night_allowances;
        $advances = $request->advances;
        $income_tax = $request->income_tax;
        $rs = $request->rs;
        $absent_amount = $request->absent_amount;

        $auth_id = Auth::id();

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                $data = [
                    'night_allowance' => str_replace(',', '', $night_allowances[$key]),
                    'advance_amt' => str_replace(',', '', $advances[$key]),
                    'absent_amount' => str_replace(',', '', $absent_amount[$key]),
                    'revenue_stamp' => str_replace(',', '', $rs[$key]),
                    'incometax_deduct_amount' => str_replace(',', '', $income_tax[$key]),
                    'au_update_hospital_pk_no' => $ses_hospital_id
                ];

                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;

                DB::table('HRMS_PERSONNEL_SALARY_MONTHLY')->where('monthly_salary_no_pk', $id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function deleteMonthlySalarySheet(Request $request)
    {
        //dd($request->salary_id);
        DB::table('hrms_personnel_salary_monthly')->where('monthly_salary_no_pk', $request->salary_id)->delete();
    }

    // cashier-wise-report discount details

    public function cashierWiseReportDiscountDetails(Request $request, $person_code)
    {


        $date_from = $request->date_from ?? date('d/m/Y');
        $date_to   = $request->date_to ?? date('d/m/Y');




        $user = DB::table('WSEC_USER')
        ->where('USER_CODE', $person_code)
        ->first();

        $user_no_pk = null;

        if ($user) {
            $user_no_pk = $user->user_no_pk;
        } else {
            $user_no_pk = null;
        }


        $discounts = DB::select("
            SELECT
                mst.invoice_no_fk,
                imst.patient_no_fk,
                SUM(mst.ledger_amt_sales) AS sales,
                SUM(mst.ledger_amt_payment) AS collection,
                SUM(mst.ledger_amt_discount) AS discount
            FROM finc_ledgermst mst
            JOIN finc_invoicemst imst
                ON imst.invoice_no_pk = mst.invoice_no_fk
            WHERE mst.au_entry_by = :person_code
            AND trunc(mst.ledger_date) BETWEEN to_date(:date_from,'dd/mm/yyyy') AND to_date(:date_to,'dd/mm/yyyy')
            GROUP BY mst.invoice_no_fk, imst.patient_no_fk
        ", [
            'person_code' => $user_no_pk,
            'date_from'   => $date_from,
            'date_to'     => $date_to,
        ]);

        // dd($discounts);

        return view('admin.reports.discount_details_modal', compact('discounts'));
    }





    public function cashierWiseReport()
    {

        //    $date = date('Y-m-d');
        //    $query = DB::table('Finc_Cashier_Wise_Reports_VW');
        //    if (!empty($date)) {
        //        $query->where(DB::raw("trunc(invoice_date)"), '=', date('Y-m-d'));
        //    }
        return Template::loadview("admin.reports.cashier_wise_report");
    }


    public function dateWiseCashierReport()
    {

        return Template::loadView("admin.reports.date_wise_cashier_report", [
            'modules'  => DB::table('sysc_module')->select('module_name', 'module_no_pk', 'module_code')->get()
        ]);
    }
    public function dateWiseIpdOpdReport()
    {
        return Template::loadView("admin.reports.date_wise_ipd_opd_report", [
            'modules'  => DB::table('sysc_module')->select('module_name', 'module_no_pk', 'module_code')->get()
        ]);
    }
    public function pharmacyDateWiseCashierReport()
    {
        return Template::loadView("admin.reports.pharmacy_date_wise_cashier_report");
    }

    // public function dateWiseCounterReport(){
    //     $counterdata=DB::table('finc_invoicemst_sum_vw ')->limit(10)->get();  // ->orderBy('hospital_no_pk', 'desc')->
    // //   return $counterdata;
    //     return view('admin.reports.date_cashier_wise_search_data',['counterdata'=>$counterdata]);
    // }

    public function referralReportDetail()
    {
        return Template::loadView("admin.reports.referral_report_detail");
    }

    public function referralReportSummary()
    {
        return Template::loadView("admin.reports.referral_report_summary");
    }

    public function dateWiseCompleteSummary()
    {
        return Template::loadView("admin.reports.date_wise_complete_summary");
    }


    public function dailySalesV02()
    {
        return Template::loadView("admin.reports.daily_sales_v02");
    }


    public function cashierWiseReportSearch(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk= $doctor_id" : "";

        //  echo "select * from  FINC_C022_CASHIER_WISE_RPT_VW  $sql_cond ";


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($po_hospital_details->hospital_code === 'GMC' || $po_hospital_details->hospital_code == 'KBMH') {
            $query = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
            sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
            sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
            sum(sales)  sales,
            sum(sales_cancel)  sales_cancel,
            sum(discount)discount  ,
            sum(net_sales) net_sales  ,
            sum(collection) collection ,
            sum(due) due ,
            sum(refund) refund ,
            sum(net_collection) net_collection ,
            sum(pay_amount_cash) pay_amount_cash ,
            sum(pay_amount_cash_net)  pay_amount_cash_net,
            sum(pay_amount_others) pay_amount_others
            from finc_c022_cashier_wise_modrp_vw  $sql_cond and module_code_phr_nonphr = 'NONPHR' group by full_name,person_code , ledgertrn_date order by ledgertrn_date Desc  ")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW

        } else {
            $query = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
        sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        sum(sales)  sales,
        sum(sales_cancel)  sales_cancel,
        sum(discount)discount  ,
        sum(net_sales) net_sales  ,
        sum(collection) collection ,
        sum(due)  due ,
        sum(refund) refund ,
        sum(net_collection) net_collection ,
        sum(pay_amount_cash) pay_amount_cash ,
        sum(pay_amount_cash_net)  pay_amount_cash_net,
        sum(pay_amount_others) pay_amount_others

        from  finc_c022_cashier_wise_rpt_vw   $sql_cond group by  full_name,person_code , ledgertrn_date order by ledgertrn_date Desc")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW

        }

        // $query = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        // sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
        // sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        // sum(sales)  sales,
        // sum(discount)discount  ,
        // sum(net_sales) net_sales  ,
        // sum(collection) collection ,
        // sum(due)  due ,
        // sum(refund) refund ,
        // sum(net_collection) net_collection ,
        // sum(pay_amount_cash) pay_amount_cash ,
        // sum(pay_amount_cash_net)  pay_amount_cash_net,
        // sum(pay_amount_others) pay_amount_others

        // from  finc_c022_cashier_wise_rpt_vw   $sql_cond group by  full_name,person_code , ledgertrn_date ")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW
        return Template::loadview("admin.reports.cashier-wise-search-data", [
            'data' => $query,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function cashierWiseReportPrint(Request $request)
    {

        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == "SUMMARY") {

            $data = DB::select("SELECT full_name,
            person_code,ledgertrn_date,
            SUM (total_invoice_cnt_new) total_invoice_cnt_new,
            SUM (COALESCE (total_invoice_cnt_old, 0)) total_invoice_cnt_old,
            SUM (sales) sales,
            sum(sales_cancel)  sales_cancel,
            SUM (discount) discount,
            SUM (net_sales) net_sales,
            SUM (collection) collection,
            SUM (due) due,
            SUM (refund) refund,
            SUM (net_collection) net_collection,
            SUM (pay_amount_cash) pay_amount_cash,
            SUM (pay_amount_cash_net) pay_amount_cash_net,
            SUM (pay_amount_others) pay_amount_others
            FROM finc_c022_cashier_wise_modrp_vw
            $sql_cond
            GROUP BY full_name, person_code,ledgertrn_date order by ledgertrn_date desc");
        } else {
            if ($po_hospital_details->hospital_code === 'GMC' || $po_hospital_details->hospital_code == 'KBMH') {
                $data = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
                sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
                sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
                sum(sales)  sales,
                sum(sales_cancel)  sales_cancel,
                sum(discount)discount  ,
                sum(net_sales) net_sales  ,
                sum(collection) collection ,
                sum(due) due ,
                sum(refund) refund ,
                sum(net_collection) net_collection ,
                sum(pay_amount_cash) pay_amount_cash ,
                sum(pay_amount_cash_net)  pay_amount_cash_net,
                sum(pay_amount_others) pay_amount_others
                from finc_c022_cashier_wise_modrp_vw  $sql_cond and module_code_phr_nonphr = 'NONPHR' group by full_name,person_code , ledgertrn_date  order by ledgertrn_date Desc ")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW

            } else {
                $data = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
            sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
            sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
            sum(sales)  sales,
            sum(sales_cancel)  sales_cancel,
            sum(discount)discount  ,
            sum(net_sales) net_sales  ,
            sum(collection) collection ,
            sum(due)  due ,
            sum(refund) refund ,
            sum(net_collection) net_collection ,
            sum(pay_amount_cash) pay_amount_cash ,
            sum(pay_amount_cash_net)  pay_amount_cash_net,
            sum(pay_amount_others) pay_amount_others

            from  finc_c022_cashier_wise_rpt_vw   $sql_cond group by  full_name,person_code , ledgertrn_date order by ledgertrn_date desc ")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW

            }
        }

        $title = "Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();


        if ($request->hdn_report_type == "SUMMARY") {
            $pdf = PDF::loadView("admin.reports.cashier_wise_print_summary", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
            return $pdf->stream('cashier-wise-report.pdf');
        } else {
            $pdf = PDF::loadView("admin.reports.cashier_wise_report_print", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
            return $pdf->stream('cashier-wise-report.pdf');
        }
    }

    public function dateCashierWiseReportSearch(Request $request)
    {
        $due = "";
        $pathology_due = "";
        $modules = $request->modules;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
            $pathology_due = $request->pathology_due;
            $due = $request->due_amt;
        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause nvl(trunc(ledger_datetime),trunc(invoice_date)) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($pathology_due != "") ? " $clause cnt_lab_item > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($modules != "") ? " $clause module_code = '$modules'" : "";
        //  dd( $sql_cond);

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.sales_cancel ,
            per.full_name
            from finc_c022_vrmst_sum_invoice_vw invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        } else {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.sales_cancel,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.admission_no_pk,
            per.full_name
            from FINC_C022_VRMST_SUM_CASHIER_VW invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        }
        $cashier_arr = [];

        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }

        $invoice_codes = array_column($cashier_data, 'invoice_code');
        $distinct_invoice_count = count(array_unique($invoice_codes));

        return Template::loadview("admin.reports.date_cashier_wise_search_data", [
            'cashier_arr'            => $cashier_arr,
            'distinct_invoice_count' => $distinct_invoice_count,
        ]);
    }
    public function dateCashierWiseIpdOpdReportSearch(Request $request)
    {
        $due = "";
        $pathology_due = "";
        $modules = $request->modules;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
            $pathology_due = $request->pathology_due;
            $due = $request->due_amt;
        } else {
            $date_from = "";
            $date_to = "";
        }
        $collection = $request->collection;
        $doctor_id = $request->doctor_id;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause nvl(trunc(ledger_datetime),trunc(invoice_date)) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($collection != "") ? " $clause net_collection > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($pathology_due != "") ? " $clause cnt_lab_item > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($modules != "") ? " $clause module_code = '$modules'" : "";
        //  dd( $sql_cond);

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.sales_cancel ,
            per.full_name
            from finc_c022_vrmst_sum_invoice_vw invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        } else {
            $cashier_data = DB::select(DB::raw("select
            invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.sales_cancel,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.module_code,
            per.full_name
            from FINC_C022_VRMST_SUM_CASHIER_VW invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        }

        $invoice_codes = array_column($cashier_data, 'invoice_code');
        $distinct_invoice_count = count(array_unique($invoice_codes));
        $cashier_collection = collect($cashier_data);
        $cashier_arr = $cashier_collection->groupBy(['full_name', 'module_code'])->toArray();

        return Template::loadview("admin.reports.date_cashier_wise_ipd_opd_search_data", [
            'cashier_arr' => $cashier_arr,
            'distinct_invoice_count' => $distinct_invoice_count,
        ]);
    }
    public function pharmacyDateCashierWiseReportSearch(Request $request)
    {
        //dd($request->all())
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
            $due = $request->due_amt;
        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "where invoice.module_code in('PHR','PHR-I')";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        // dd( $sql_cond);

        $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
                                            invoice.invoice_code,
                                            invoice.counter_name,
                                            invoice.patient_type,
                                            invoice.serviceunit_no_pk,
                                            invoice.invoice_date,
                                            invoice.customer_name,
                                            invoice.counter_su_no_fk,
                                            invoice.sales as ledger_amt_sales,
                                            invoice.discount as ledger_amt_discount,
                                            invoice.collection as ledger_amt_payment,
                                            invoice.net_sales as ledger_amt_sales_net,
                                            invoice.due as ledger_amt_due,
                                            invoice.refund,
                                            invoice.net_collection,
                                            invoice.mobile1,
                                            invoice.discount_detail,
                                            per.full_name
                                    from finc_vouchermst_sum_cashier_vw invoice
                                            left join wsec_user us
                                            -- hrms_personnel per
                                            on invoice.invoice_entry_by = us.user_no_pk
                                            left join hrms_personnel per
           on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice_date DESC "));


        $cashier_arr = [];

        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }
        // dd($doctor_id);
        //dd($cashier_arr);
        return Template::loadview("admin.reports.pharmacy_date_cashier_wise_search_data", [
            'cashier_arr' => $cashier_arr
        ]);
    }

    public function dateCashierWiseReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $due = $request->due_amt;
        $pathology_due = $request->pathology_due;
        $modules = $request->modules;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_datetime) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($pathology_due != "") ? " $clause cnt_lab_item > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($modules != "") ? " $clause module_code = '$modules'" : "";

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.sales_cancel,
            per.full_name
            from finc_c022_vrmst_sum_invoice_vw invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        } else {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.sales_cancel,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            per.full_name
            from FINC_C022_VRMST_SUM_CASHIER_VW invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        }
        $cashier_arr = [];
        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }

        $invoice_codes = array_column($cashier_data, 'invoice_code');
        $distinct_invoice_count = count(array_unique($invoice_codes));
        $title = "Date Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if($request->download_type == 'EXCEL'){
            $fileToExport = "Date Wise Cashier Report";
            $html = view("admin.reports.date_cashier_wise_report_print", [
                'cashier_arr' => $cashier_arr,
                'barcode_no' => $barcode_no,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'po_hospital_details' => $po_hospital_details,
                'distinct_invoice_count' => $distinct_invoice_count,
            ]);

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }else{
                return view("admin.reports.date_cashier_wise_report_print", [
                    'cashier_arr' => $cashier_arr,
                    'barcode_no' => $barcode_no,
                    'from_date' => $date_from,
                    'to_date' => $date_to,
                    'po_hospital_details' => $po_hospital_details,
                    'distinct_invoice_count' => $distinct_invoice_count,
                ]);
            }


    }
    public function dateCashierWiseIpdOpdReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $due = $request->due_amt;
        $pathology_due = $request->pathology_due;
        $modules = $request->modules;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $collection = $request->collection;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_datetime) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($collection != "") ? " $clause net_collection > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($pathology_due != "") ? " $clause cnt_lab_item > 0" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($modules != "") ? " $clause module_code = '$modules'" : "";

        if (Session::get('user.ses_hospital_code') == "GMC") {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.sales_cancel,
            per.full_name
            from finc_c022_vrmst_sum_invoice_vw invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        } else {
            $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
            invoice.invoice_code,
            invoice.ledgertrn_no_pk,
            invoice.ledger_datetime,
            invoice.counter_name,
            invoice.patient_type,
            invoice.serviceunit_no_pk,
            invoice.invoice_date,
            invoice.customer_name,
            invoice.counter_su_no_fk,
            invoice.sales as ledger_amt_sales,
            invoice.sales_cancel,
            invoice.discount as ledger_amt_discount,
            invoice.collection as ledger_amt_payment,
            invoice.net_sales as ledger_amt_sales_net,
            invoice.due as ledger_amt_due,
            invoice.refund,
            invoice.net_collection,
            invoice.mobile1,
            invoice.discount_detail,
            invoice.module_code,
            per.full_name
            from FINC_C022_VRMST_SUM_CASHIER_VW invoice
            left join wsec_user us
            on invoice.invoice_entry_by = us.user_no_pk
            left join hrms_personnel per
            on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));
        }
        $invoice_codes = array_column($cashier_data, 'invoice_code');
        $distinct_invoice_count = count(array_unique($invoice_codes));
        $cashier_collection = collect($cashier_data);
        $cashier_arr = $cashier_collection->groupBy(['full_name', 'module_code'])->toArray();

        $title = "Date Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return view("admin.reports.date_cashier_wise_ipd_opd_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'distinct_invoice_count' => $distinct_invoice_count]);
    }
    public function pharmacyDateCashierWiseReportPrint(Request $request)
    {
        //  dd('test');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $due = $request->due_amt;
        //        $query = DB::table('finc_datewise_cashier_report_vw');
        //        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
        //            $query->where(DB::raw("trunc(invoice_date)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
        //            $query->where(DB::raw("trunc(invoice_date)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        //        } elseif (!empty($request->search_date_from)) {
        //            $query->where(DB::raw("trunc(invoice_date)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        //        } elseif (!empty($request->search_date_to)) {
        //            $query->where(DB::raw("trunc(invoice_date)"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        //        }
        //        $data = $query
        //            ->orderBy('invoice_date', 'desc')
        //            ->get()
        //            ->toArray();
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "where invoice.module_code in('PHR','PHR-I')";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        // $discount = DB::select(DB::raw("select * from finc_datewise_cashier_report_vw $sql_cond order by invoice_date ASC "));


        $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
                invoice.invoice_code,
                invoice.counter_name,
                invoice.patient_type,
                invoice.serviceunit_no_pk,
                invoice.invoice_date,
                invoice.customer_name,
                invoice.counter_su_no_fk,
                invoice.sales as ledger_amt_sales,
                invoice.discount as ledger_amt_discount,
                invoice.collection as ledger_amt_payment,
                invoice.net_sales as ledger_amt_sales_net,
                invoice.due as ledger_amt_due,
                invoice.refund,
                invoice.net_collection,
                invoice.mobile1,
                per.full_name
        from finc_vouchermst_sum_cashier_vw invoice
                left join wsec_user us
                -- hrms_personnel per
                on invoice.invoice_entry_by = us.user_no_pk
                left join hrms_personnel per
        on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice_date DESC "));


        $cashier_arr = [];

        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }
        //dd($cashier_arr);

        // dd($monthlySalaryReportprint);
        // $total_serviceunit = DB::select("select serviceunit_no_pk, serviceunit_name from finc_datewise_cashier_report_vw  where status=1 $sql_cond group by serviceunit_no_pk, serviceunit_name");





        $title = "Pharmacy Date Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        //return view("admin.reports.date_cashier_wise_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to,'po_hospital_details'=>$po_hospital_details]);
        $pdf = PDF::loadView("admin.reports.pharmacy_date_cashier_wise_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->download('pharmacy-date-cashier-wise-report.pdf');
    }


    public function referralWiseSearchDetail(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $referral_id = $request->hdn_first_referral_id;
        $type = $request->type;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 1) ? " $clause doctor_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 2) ? " $clause referal_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 3) ? " $clause referral_agent_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause voucher_no = '$invoice_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";

        $sql_cond .= ($referral_id != "") ? " $clause person_no_pk = '$referral_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_referral_report_detail_vw $sql_cond  and module_no_fk <>3 order by voucher_no DESC");

        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.referral_detail_data", ['data' => $report_data]);
    }

    public function referralDetailPrint(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $referral_id = $request->hdn_first_referral_id;
        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 1) ? " $clause doctor_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 2) ? " $clause referal_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 3) ? " $clause referral_agent_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause voucher_no = '$invoice_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_pk = '$referral_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_referral_report_detail_vw $sql_cond  and module_no_fk <>3 order by voucher_no DESC");


        $title = "Referral Detail Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.referral_detail_print", ['data' => $report_data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to]);
        return $pdf->download('Referral-Detail-wise-report.pdf');
    }

    public function referralSummaryWiseSearchDetail(Request $request)
    {
        //    $query = DB::table('finc_ref_report_summary_vw');
        //
        //    if (!empty($request->type)) {
        //        $query->where('doctor_ind', $request->type);
        //    } elseif (!empty($request->type)) {
        //        $query->where('referal_ind', $request->type);
        //    } elseif (!empty($request->type)) {
        //        $query->where('referral_agent_ind', $request->type);
        //    }
        //    return Template::loadview("admin.reports.referral_summary_detail_data", [
        //        'data' => $query->get()
        //            ->toArray(),
        //    ]);
        $invoice_id = $request->invoice_id;
        $referral_id = $request->hdn_first_referral_id;
        $type = $request->type;
        $doctor_id = $request->primary_doctor;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 1) ? " $clause doctor_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 2) ? " $clause referal_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 3) ? " $clause referral_agent_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_pk = '$referral_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_ref_report_summary_vw $sql_cond order by voucher_no DESC");

        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.referral_summary_detail_data", ['data' => $report_data]);
    }

    public function referralSummaryDetailPrint(Request $request)
    {
        // dd($request->all());
        $invoice_id = $request->invoice_id;
        $referral_id = $request->hdn_first_referral_id;
        $type = $request->type;
        $doctor_id = $request->primary_doctor;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 1) ? " $clause doctor_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 2) ? " $clause referal_ind = 1" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($type == 3) ? " $clause referral_agent_ind = 1" : "";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_pk = '$referral_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause voucher_no = '$invoice_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause full_name = '$doctor_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $report_data = DB::select("select * from finc_ref_report_summary_vw $sql_cond order by voucher_no DESC");

        $title = "Referral Summary Detail Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.referral_summary_detail_print", ['data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to]);
        return $pdf->stream('Referral-Summary-wise-report.pdf');
    }

    public function MonthlyBonusReport(Request $request)
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.hrm.bonus.bonus_report", [
            'bank_name' => $bank_name
        ]);
    }

    public function bonusReportSearch(Request $request)
    {

        //        dd($request->card_hidn);
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $bank_name = $request->bank_id;
        $card_no = $request->card_hidn;
        $bonus_date = date("d/m/Y", strtotime($request->bonus_date));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $month_year_con = ($month_year != "") ? " and a.salary_yyyymm=$month_year" : "";
        $card_no_con = ($request->card_no != "") ? " and a.person_no_pk=$card_no" : "";
        $bank_name_con = ($request->bank_id != "") ? " and a.agent_banking_type=$bank_name" : "";


        $monthlySalaryReportSearch = DB::select("select a.person_no_pk,A.FULL_NAMe,a.salary_yyyymm,a.SALARY_NO_FK,A.DESIGNATION_NAME,A.SALARY_YYYYMM,A.GROSS_SALARY,B.CARD_NO,B.JOIN_DATE
			from hrms_monthly_salary_wl_vw a
			left join employee_info_vw b
			on A.PERSON_NO_PK = B.PERSON_NO_PK where a.status = 1 and a.bonus_elig_ind =1 $card_no_con $month_year_con $bank_name_con
			group by a.person_no_pk,A.FULL_NAMe,a.salary_yyyymm,a.SALARY_NO_FK,A.DESIGNATION_NAME,A.SALARY_YYYYMM,A.GROSS_SALARY,B.CARD_NO,B.JOIN_DATE");


        return Template::loadview("admin.reports.bonus_search_data", ['data' => $monthlySalaryReportSearch]);
    }

    public function bonusReportPrint(Request $request)
    {
        // dd($request->card_hidn);
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and a.person_no_pk=$card_no" : "";

        $monthlySalaryReportprint = DB::select("select a.person_no_pk,a.serviceunit_name,a.full_name,a.designation_name,a.salary_yyyymm,a.gross_salary,a.card_no,b.join_date
			from hrms_monthly_salary_wl_vw a
			left join employee_info_vw b
			on a.person_no_pk = b.person_no_pk where a.status = 1 and a.bonus_elig_ind =1 and b.employee_ind = 1 $card_no_con $month_year_con
			");

        //         dd($monthlySalaryReportprint);
        $total_employee = DB::select("select a.serviceunit_no_pk, a.serviceunit_name, count(a.person_no_pk)  total_emp from hrms_monthly_salary_wl_vw a where a.status=1   $card_no_con $month_year_con group by a.serviceunit_no_pk, a.serviceunit_name");

        $t_salary = DB::select("select  a.serviceunit_name, sum(a.payable_amount)  total_emp_salary ,sum(a.gross_salary) total_gross_salary from hrms_monthly_salary_wl_vw a where a.status=1   $card_no_con $month_year_con group by  a.serviceunit_name");
        // dd($monthlySalaryReportprint);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->serviceunit_name][$salarySheet->person_no_pk] = $salarySheet;
            }
        }
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->serviceunit_name] = $value->total_emp;
            }
        }

        $total_salary = [];
        if (!empty($t_salary)) {
            foreach ($t_salary as $value) {
                $total_salary[$value->serviceunit_name] = $value->total_emp_salary;
            }
        }
        $total_gros_salary = [];
        if (!empty($t_salary)) {
            foreach ($t_salary as $value) {
                $total_gros_salary[$value->serviceunit_name] = $value->total_gross_salary;
            }
        }

        $from_date = date('d/m/Y');
        $title = "Bonus salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.hrm.bonus.bonus_data_print", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'count_depart_emp' => $count_depart_emp, 'total_salary' => $total_salary, 'total_gros_salary' => $total_gros_salary])->setPaper('a4', 'landscape');
        return $pdf->download('Bonus_salary_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function leaveEntryReport()
    {
        return Template::loadview("admin.reports.leave_entry_report");
    }

    public function leaveEntryReportSearch(Request $request)
    {
        $query = DB::table('hrms_leave_entrydtl a')
            ->leftJoin('hrms_leave_entry b', 'a.leave_no_fk', 'leave_no_pk')
            ->leftJoin('employee_info_vw c', 'c.person_no_pk', 'b.person_no_fk')
            ->leftJoin('hrms_monthly_salary_wl_vw d', 'c.person_no_pk', 'd.person_no_pk')
            ->select('c.card_no', 'c.designation', 'd.gross_salary', 'c.join_date', 'c.person_no_pk', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'd.working_days', 'd.leave_days', 'd.absent_days')
            ->groupBy('c.card_no', 'c.full_name', 'c.designation', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'c.person_no_pk', 'd.gross_salary', 'c.join_date', 'd.working_days', 'd.leave_days', 'd.absent_days');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(leave_dates)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(leave_dates)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(leave_dates)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("leave_dates"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        return Template::loadview("admin.reports.hrm.leave-entry-search-data", [
            'value' => $query
                ->orderBy('a.leave_dates', 'desc')
                ->get()
                ->toArray(),
        ]);
    }

    public function leaveReportPrint(Request $request)
    {
        $query = DB::table('hrms_leave_entrydtl a')
            ->leftJoin('hrms_leave_entry b', 'a.leave_no_fk', 'leave_no_pk')
            ->leftJoin('hrms_personnel c', 'c.person_no_pk', 'b.person_no_fk')
            ->select('c.card_no', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates')
            ->groupBy('c.card_no', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(leave_dates)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(leave_dates)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(leave_dates)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("leave_dates"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        $data = $query
            ->orderBy('a.leave_dates', 'desc')
            ->get()
            ->toArray();

        $title = 'Leave Entry Report';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.hrm.leave_entry_print_list", ['value' => $data, 'barcode_no' => $barcode_no]);
        return $pdf->download('Leave Entry Report.pdf');
    }

    public function leaveEntryReportData(Request $request, $id)
    {
        $query = DB::table('hrms_leave_entrydtl a')
            ->leftJoin('hrms_leave_entry b', 'a.leave_no_fk', 'leave_no_pk')
            ->leftJoin('hrms_personnel c', 'c.person_no_pk', 'b.person_no_fk')
            ->select('c.card_no', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates')
            ->where('c.person_no_pk', $id)
            ->get();
        //        dd($query[0]->card_no);
        $title = "Leave Entry Slip Slip";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // return template::loadview('admin.reports.hrm.salary_slip', ['data' => $slip]);

        $pdf = PDF::loadView("admin.reports.hrm.leave_entry_print", [
            'barcode_no' => $barcode_no,
            'data' => $query
        ])->setPaper('a4', 'portrait');
        return $pdf->download('report_print.pdf');
    }

    public function BonusSalarySlipPrint($id, $salary)
    {
        $slip = DB::table('hrms_monthly_salary_wl_vw a')
            ->leftJoin('employee_info_vw b', 'a.person_no_pk', 'b.person_no_pk')
            ->select(
                'a.card_no',
                'a.monthly_salary_no_pk',
                'a.overtime_hours',
                'a.overtime_rate',
                'a.overtime_amount',
                'a.other_allowance',
                'a.full_name',
                'a.designation_name',
                'a.gross_salary',
                'a.basic_salary',
                'a.medical_allowance',
                'a.house_rent',
                'a.attendance_bonus',
                'a.att_deduct_amount',
                'a.loan_deduct_amount',
                'a.payable_amount',
                'a.attendance_days',
                'a.late_days',
                'a.absent_days',
                'a.leave_days',
                'a.working_days',
                'a.leave_withoutpay_days',
                'a.personal_savings_amount',
                'a.salary_yyyymm',
                'b.join_date',
                'a.residence_fee',
                'a.disciplinary_action'
            )
            ->where('a.salary_no_fk', $id)
            ->where('a.salary_yyyymm', $salary)
            ->first();

        //        $monthlySalaryReportprint = DB::select("select a.person_no_pk,a.serviceunit_name,a.full_name,a.designation_name,a.salary_yyyymm,a.gross_salary,a.card_no,b.join_date
        // from hrms_monthly_salary_wl_vw a
        // left join employee_info_vw b
        // on a.person_no_pk = b.person_no_pk where salary_no_fk = $id");
        //        dd($slip);

        $title = $slip->card_no;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // return template::loadview('admin.reports.hrm.salary_slip', ['data' => $slip]);

        $pdf = PDF::loadView("admin.reports.hrm.bonus_slip", ['data' => $slip, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->download('Bonus_slip.pdf');
    }


    public function monthlyBonusSalaryPrintBankWise(Request $request)
    {
        //return $request->bank_id;
        if (Cache::has('bank_id') && Cache::get('bank_id') == $request->bank_id) {
        } else {

            Cache::put('bank_id', $request->bank_id);
        }

        // dd($request->card_hidn);
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        // $from_date = date("d/m/Y", strtotime($request->date_pic));
        // $date_cond = ($request->date_pic != "") ? " and a.appoint_date = to_date('$from_date','DD/MM/YYYY') " : "";
        $card_no_con = ($request->card_no != "") ? " and a.person_no_pk=$card_no" : "";
        $bank_no_con = ($request->bank_id != "") ? " and a.agent_banking_type = $request->bank_id" : "";

        $request_bank_id = $request->bank_id;

        $monthlySalaryReportprint = DB::select("select a.other_deduct_amount, a.person_no_pk,a.agent_banking_type_name,a.card_no,a.serviceunit_name,a.monthly_salary_no_pk,a.person_no_pk,a.overtime_hours,a.overtime_rate,a.overtime_amount ,a.other_allowance, a.full_name,a.designation_name,a.gross_salary,a.basic_salary,a.medical_allowance,a.house_rent,a.attendance_bonus,a.att_deduct_amount,a.loan_deduct_amount,a.payable_amount,a.attendance_days, a.late_days, a.absent_days, a.residence_fee, a.leave_days,a.leave_withoutpay_days,a.personal_savings_amount,b.join_date
			from hrms_monthly_salary_wl_vw a
			left join employee_info_vw b  on a.person_no_pk = b.person_no_pk
			where a.status=1 and a.bonus_elig_ind =1 and b.employee_ind = 1 $card_no_con $month_year_con $bank_no_con order by serviceunit_name");


        // $total_employee =  DB::select("select agent_banking_type,serviceunit_no_pk, serviceunit_name, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where  status=1   $card_no_con $month_year_con group by agent_banking_type,serviceunit_no_pk, serviceunit_name");

        // $t_salary =  DB::select("select  agent_banking_type,serviceunit_name, sum(payable_amount)  total_emp_salary from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by  serviceunit_name, agent_banking_type");

        $total_employee_bank_wise = DB::select("select a.agent_banking_type_name,a.person_no_pk from hrms_monthly_salary_wl_vw a where a.status=1 and a.bonus_elig_ind =1  $card_no_con $month_year_con group by  a.agent_banking_type_name,a.person_no_pk");

        $t_salary_bank_wise = DB::select("select  a.agent_banking_type_name, sum(a.payable_amount)  total_emp_salary_bank_wise from hrms_monthly_salary_wl_vw a where a.status=1   $card_no_con $month_year_con group by  a.agent_banking_type_name");
        // dd($monthlySalaryReportprint);
        $emp_data = [];
        if (!empty($monthlySalaryReportprint)) {
            foreach ($monthlySalaryReportprint as $salarySheet) {
                $emp_data[$salarySheet->agent_banking_type_name][$salarySheet->serviceunit_name][$salarySheet->person_no_pk] = $salarySheet;
            }
        }

        $count_depart_emp_bank_wise = [];
        if (!empty($total_employee_bank_wise)) {
            foreach ($total_employee_bank_wise as $value) {
                $count_depart_emp_bank_wise[$value->agent_banking_type_name] = isset($count_depart_emp_bank_wise[$value->agent_banking_type_name]) ? $count_depart_emp_bank_wise[$value->agent_banking_type_name] + 1 : 1;
            }
        }


        $total_salary_bank_wise = [];
        //        $total_summery_bonus = [];
        if (!empty($t_salary_bank_wise)) {
            foreach ($t_salary_bank_wise as $value) {
                $total_salary_bank_wise[$value->agent_banking_type_name] = $value->total_emp_salary_bank_wise;
            }
        }
        //dd($total_salary_bank_wise);


        //        $total_gros_salary = [];
        //        if (!empty($t_salary_bank_wise)) {
        //            foreach ($t_salary_bank_wise as $value) {
        //                $total_gros_salary[$value->agent_banking_type_name] = $value->total_gross_salary;
        //            }
        //        }
        //         dd($total_gros_salary);

        $from_date = date('d/m/Y');
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $total_bonus =  $this->totalBonus($emp_data);
        $pdf = PDF::loadView("admin.reports.hrm.bank_wise_bonus_list", ['emp_data' => $emp_data, 'barcode_no' => $barcode_no, 'month' => $month, 'year' => $year, 'total_salary_bank_wise' => $total_salary_bank_wise, 'total_bonus' => $total_bonus, 'count_depart_emp_bank_wise' => $count_depart_emp_bank_wise, 'request_bank_id' => $request_bank_id])->setPaper('a4', 'landscape');
        return $pdf->download('bank_wise_salary_print_bank_wise.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');


    }
    public function totalBonus($emp_data)
    {
        $bonus_data = 0;
        $total_bonus = 0;
        $bank_wise = [];
        //    dd($emp_data);
        foreach ($emp_data as $bank => $bank_data) {
            foreach ($bank_data as $dept => $dept_data) {
                foreach ($dept_data as $desig => $data) {

                    $this_month = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                    $start_month = \Carbon\Carbon::parse(date('Y-m-d', strtotime($data->join_date)))->floorMonth(); // returns 2019-06-01
                    $diff = $start_month->diffInMonths($this_month);  // returns 1

                    if ($diff < 3) {
                        $bonus = ($data->gross_salary) * 10 / 100;
                    } elseif ($diff == 3 || $diff < 6) {
                        $bonus = ($data->gross_salary) * 30 / 100;
                    } elseif ($diff == 6 || $diff < 12) {
                        $bonus = ($data->gross_salary) * 40 / 100;
                    } else {
                        $bonus = ($data->gross_salary) * 50 / 100;
                    }


                    $bonus_data += $bonus;
                    $total_bonus += $bonus_data;

                    $bank_wise[$bank] = $bonus_data; //isset($bank_wise[$bank])? $total_bonus:$bonus;
                }
            }
        }
        return $bank_wise;
        //dd($bonus_data);

    }



    public function employePerfermanceReport()
    {
        return Template::loadview("admin.reports.hrm.employee_perfermance_report");
    }

    public function employeePerfermanceSearchData(Request $request)
    {

        $query = DB::table('hrms_leave_entrydtl a')
            ->leftJoin('hrms_leave_entry b', 'a.leave_no_fk', 'leave_no_pk')
            ->leftJoin('employee_info_vw c', 'c.person_no_pk', 'b.person_no_fk')
            ->leftJoin('hrms_monthly_salary_wl_vw d', 'c.person_no_pk', 'd.person_no_pk')
            ->select('c.card_no', 'c.designation', 'd.gross_salary', 'c.join_date', 'c.person_no_pk', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'd.working_days', 'd.leave_days', 'd.absent_days')
            ->groupBy('c.card_no', 'c.full_name', 'c.designation', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'c.person_no_pk', 'd.gross_salary', 'c.join_date', 'd.working_days', 'd.leave_days', 'd.absent_days');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(leave_dates)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(leave_dates)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(leave_dates)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("leave_dates"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        //    $value = $query
        //    ->orderBy('a.leave_dates', 'desc')
        //    ->get()
        //    ->toArray();
        //dd($value);
        return Template::loadview("admin.reports.hrm.employee_performance_search_data", [
            'value' => $query
                ->orderBy('a.leave_dates', 'desc')
                ->get()
                ->toArray(),
        ]);
    }

    public function employeePerfermanceSearchDataPrint(Request $request)
    {
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $query = DB::table('hrms_leave_entrydtl a')
            ->leftJoin('hrms_leave_entry b', 'a.leave_no_fk', 'leave_no_pk')
            ->leftJoin('employee_info_vw c', 'c.person_no_pk', 'b.person_no_fk')
            ->leftJoin('hrms_monthly_salary_wl_vw d', 'c.person_no_pk', 'd.person_no_pk')
            ->select('c.card_no', 'c.designation', 'd.gross_salary', 'c.join_date', 'c.person_no_pk', 'c.full_name', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'd.working_days', 'd.leave_days', 'd.absent_days')
            ->groupBy('c.card_no', 'c.full_name', 'c.designation', 'a.leave_dates', 'a.leave_reason', 'b.from_date', 'b.to_dates', 'c.person_no_pk', 'd.gross_salary', 'c.join_date', 'd.working_days', 'd.leave_days', 'd.absent_days');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(leave_dates)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(leave_dates)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(leave_dates)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("leave_dates"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        return Template::loadview("admin.reports.hrm.employee_performance_print_data", [
            'value' => $query
                ->orderBy('a.leave_dates', 'desc')
                ->get()
                ->toArray(),
            'from_data' => $from_date,
            'to_date' => $to_date
        ]);
    }

    //    Daily Collection
    public function dailyhrmCollectionReport()
    {
        return Template::loadview("admin.reports.hrm.daily_collection_report");
    }

    public function dailyCollectionSearchData(Request $request)
    {

        $query = DB::table('FINC_LEDGERMST_PAYDISC_VW');
        if (!empty($request->date)) {
            $query->where(DB::raw("invoice_date"), '=', date('Y-m-d', strtotime($request->date)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        return Template::loadview("admin.reports.hrm.daily_collection_report_search_data", [
            'data' => $query
                ->orderBy('invoice_date', 'DESC')
                ->get()

                ->toArray(),
        ]);
    }

    public function dailyCollectionSearchDataPrint(Request $request)
    {

        $invoice_date =  date('Y-m-d', strtotime($request->date));
        $query = DB::table('FINC_LEDGERMST_PAYDISC_VW');
        if (!empty($request->date)) {
            $query->where(DB::raw("invoice_date"), '=', date('Y-m-d', strtotime($request->date)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        //    dd($query->get());

        //    service unit
        $service_unit = DB::select('select SERVICEUNIT_NO_PK,SERVICEUNIT_NAME from SYSC_SERVICEUNIT where status = 1');
        /*Get Emergency service Data */

        $emergencyInfo = DB::table('FINC_LEDGERMST_PAYDISC_VW');
        if (!empty($request->date)) {
            $emergencyInfo->where(DB::raw("invoice_date"), '=', date('Y-m-d', strtotime($request->date)));
        }
        $emergencyInfo->where(DB::raw('serviceunit_name'), '=', "CASH COUNTER");


        //    $emergencyDatas =  DB::SELECT("select * from FINC_LEDGERMST_PAYDISC_VW where invoice_date = $invoice_date AND serviceunit_name ='EMERGENCY' ");
        //    dd($emergencyInfo->get());
        $from_date = date('d/m/Y');
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $html = view('admin.reports.hrm.daily_collection_data_print', [
            'barcode_no' => $barcode_no,
            'service_unit' => $service_unit,
            'data' => $query
                ->get()
                ->toArray(),
            'from_date' => $from_date,
            'invoice_date' => $invoice_date
        ])->render();
        return @\PDF::loadHTML($html, 'utf-8')->stream();

        //$pdf = PDF::loadView("admin.reports.hrm.daily_collection_data_print", [
        //'barcode_no' => $barcode_no,
        //'data' => $query
        //->get()
        //->toArray(),
        //'from_date' => $from_date,
        //'invoice_date' => $invoice_date
        //])->setPaper('a4', 'landscape');
        //return $pdf->download('Daily_collection_data_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    //    Cashier Wise collection
    public function CashierWiseCollectionReport()
    {
        return Template::loadview("admin.reports.hrm.cashier_wise_collection_report");
    }

    public function CashierWiseCollectionSearchData(Request $request)
    {
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;

        $doctor_id = $request->doctor_id;
        //    $date_from = date('d-m-Y', strtotime($request->search_date_from));
        //    $date_to = date('d-m-Y', strtotime($request->search_date_to));

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause invoice_date between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')
		" : "";
        //    dd($sql_cond);

        $query = DB::select(DB::raw("select * from FINC_CASHIER_WISE_ITEMTYPE_VW $sql_cond order by invoice_date DESC,full_name Asc"));


        //    $inv_date = [];
        //foreach ($query as $date){
        //    $inv_date = date('Y-m-d',strtotime($date->invoice_date));
        //}
        //
        //    $date_data =  DB::select(DB::raw("select * from FINC_CASHIER_WISE_ITEMTYPE_VW where  $inv_date = $query->invoice_date $sql_cond"));
        //
        //$name_data = DB::select(DB::raw("select full_name,person_no_pk from FINC_CASHIER_WISE_ITEMTYPE_VW where invoice_date = '$inv_date' "));
        //dd($name_data);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return Template::loadview("admin.reports.hrm.cashier_wise_collection_data_list", [
            'data' => $query,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'po_hospital_details' => $po_hospital_details
            //    ,'name_data'=>$name_data,'inv_date'=>$inv_date,'date_data'=>$date_data
        ]);
    }

    public function CashierWiseCollectionSearchDataPrint(Request $request)
    {
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $doctor_id = $request->doctor_id;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause invoice_date between TO_DATE('$date_from', 'DD/MM/YYYY') and TO_DATE('$date_to', 'DD/MM/YYYY')" : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($sql_cond);
        $query = DB::select(DB::raw("select * from FINC_CASHIER_WISE_ITEMTYPE_VW $sql_cond order by invoice_date DESC ,full_name Asc"));

        foreach ($query as $query_data) {
            $title = $query_data->invoice_date;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
        }

        $pdf = PDF::loadView("admin.reports.hrm.cashier_wise_collection_data_print", ['data' => $query, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->download('Cashier-Wise-Collection-Report.pdf');
    }
    public function CashierWiseCollectionTypeReport()
    {
        return Template::loadview("admin.reports.hrm.cashier_wise_collection_type_report");
    }

    public function CashierWiseCollectionTypeSearchData(Request $request)
    {
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;

        $doctor_id = $request->doctor_id;
        //    $date_from = date('d-m-Y', strtotime($request->search_date_from));
        //    $date_to = date('d-m-Y', strtotime($request->search_date_to));

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause au_entry_at between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')
		" : "";


        $query = DB::select(DB::raw("select sum(cash) as cash,sum(card) as card,sum(mbanking) as mbanking,sum(cheque) as cheque,sum(refund) as refund,user_fullname,user_code from finc_cashiercollection_vw $sql_cond group By user_fullname,user_code order by user_fullname Asc "));




        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return Template::loadview("admin.reports.hrm.cashier_wise_collection_type_data_list", [
            'data' => $query,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'po_hospital_details' => $po_hospital_details
            //    ,'name_data'=>$name_data,'inv_date'=>$inv_date,'date_data'=>$date_data
        ]);
    }
    public function CashierWiseCollectionTypePrint(Request $request)
    {

        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;

        $doctor_id = $request->doctor_id;
        //    $date_from = date('d-m-Y', strtotime($request->search_date_from));
        //    $date_to = date('d-m-Y', strtotime($request->search_date_to));

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause au_entry_at between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')
		" : "";


        $query =  DB::select(DB::raw("select sum(cash) as cash,sum(card) as card,sum(mbanking) as mbanking,sum(cheque) as cheque,sum(refund) as refund,user_fullname,user_code from finc_cashiercollection_vw $sql_cond group By user_fullname,user_code order by user_fullname Asc "));




        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return view("admin.reports.hrm.cashier_wise_collection_type_data_print", [
            'data' => $query,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'po_hospital_details' => $po_hospital_details
            //    ,'name_data'=>$name_data,'inv_date'=>$inv_date,'date_data'=>$date_data
        ]);
    }




    //Single Cashier Collection

    public function SingleCashierCollection(Request $request)
    {

        $invoice_date =  date('Y-m-d', strtotime($request->date));
        $query = DB::table('FINC_LEDGERMST_PAYDISC_VW');
        if (!empty($request->date)) {
            $query->where(DB::raw("invoice_date"), '=', date('Y-m-d', strtotime($request->date)));
        }
        if (!empty($request->card_hidn)) {
            $query->where(DB::raw('person_no_fk'), '=', $request->card_hidn);
        }
        //    dd($query->get());

        //    service unit
        $service_unit = DB::select('select SERVICEUNIT_NO_PK,SERVICEUNIT_NAME from SYSC_SERVICEUNIT where status = 1');
        /*Get Emergency service Data */

        $emergencyInfo = DB::table('FINC_LEDGERMST_PAYDISC_VW');
        if (!empty($request->date)) {
            $emergencyInfo->where(DB::raw("invoice_date"), '=', date('Y-m-d', strtotime($request->date)));
        }
        $emergencyInfo->where(DB::raw('serviceunit_name'), '=', "CASH COUNTER");


        //    $emergencyDatas =  DB::SELECT("select * from FINC_LEDGERMST_PAYDISC_VW where invoice_date = $invoice_date AND serviceunit_name ='EMERGENCY' ");
        //    dd($emergencyInfo->get());
        $from_date = date('d/m/Y');
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $html = view('admin.reports.hrm.daily_collection_data_print', [
            'barcode_no' => $barcode_no,
            'service_unit' => $service_unit,
            'data' => $query
                ->get()
                ->toArray(),
            'from_date' => $from_date,
            'invoice_date' => $invoice_date
        ])->render();
        return @\PDF::loadHTML($html, 'utf-8')->stream();

        //$pdf = PDF::loadView("admin.reports.hrm.daily_collection_data_print", [
        //'barcode_no' => $barcode_no,
        //'data' => $query
        //->get()
        //->toArray(),
        //'from_date' => $from_date,
        //'invoice_date' => $invoice_date
        //])->setPaper('a4', 'landscape');
        //return $pdf->download('Daily_collection_data_print.pdf');
        // $pdf = PDF::loadView("admin.reports.hrm.daily_attendance_report_print", ['print_data' => $dailAttendanceReportSearch]);
        // return $pdf->download('daily_attendance_report_print.pdf');
    }

    public function cardPaymentReport()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        $mBanking = $this->getLookupListByCode("MBANKING");
        return Template::loadview("admin.reports.card_payment_report", [
            'bank_name' => $bank_name,
            'mBanking' => $mBanking,
            'counter' => ""
        ]);
    }

    public function cardPaymentReportPhr()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.card_payment_report", [
            'bank_name' => $bank_name,
            'counter' => "Pharmacy"
        ]);
    }

    public function cardPaymentReportSearch(Request $request)
    {
        //  dd($request->all());
        // return $report_data;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $mbs_id = $request->mbs_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $bank = $request->bank;
        $mbs = $request->mbs;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //        $date_from = date('Y/m/d', strtotime($request->date_from));
        //        $date_to = date('Y/m/d', strtotime($request->date_to));

        $doctor_id = $request->doctor_id;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id' " : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($mbs_id != "") ? " $clause pay_mood_type ='$mbs_id' and paymood = 'Mbanking'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_paymood_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause us.PERSON_NO_fK = $doctor_id" : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($bank != "") ? " $clause bank_name is not null" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($mbs != "") ? " $clause paymood = 'Mbanking' and pay_mood_type is not null " : "";


        if ($request->module == "Pharmacy") {
            $report_data = db::select("SELECT paymood,
                            pay_mood_type,
                            transaction_id,
                            card_invoice_no,
                            pay_amount,
                            patient_no_fk,
                            pat.patient_name,
                            pat.patient_code,
                            TRUNC (ledger_paymood_date) receipt_date,
                            TRUNC (invoice_date) invoice_date,
                            pay.au_entry_by,
                            fnc_username (pay.au_entry_by) user_name
                    FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat, sysc_module md
                    WHERE     mst.invoice_no_pk = pay.invoice_no_fk
                            AND mst.patient_no_fk = pat.patient_no_pk
                            and mst.module_no_fk = md.module_no_pk
                            and PAYMOOD <> 'CASH' and md.MODULE_CODE in  ('PHR','PHR-I') $sql_cond ");
        } else {
            $report_data = db::select("SELECT paymood,
            pay_mood_type,
            transaction_id,
            card_invoice_no,
            pay_amount,
            mst.patient_no_fk,
            pat.patient_name,
            pat.patient_code,
            TRUNC (ledger_paymood_date) receipt_date,
            TRUNC (invoice_date) invoice_date,
            pay.au_entry_by,
            fnc_username (pay.au_entry_by) user_name
       FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat , wsec_user  us
      WHERE     mst.invoice_no_pk = pay.invoice_no_fk
            AND mst.patient_no_fk = pat.patient_no_pk
            and us.user_no_pk = pay.au_entry_by
            AND PAYMOOD <> 'CASH'  $sql_cond ");
            // dd($report_data);
        }



        //  echo  "select paymood,          pay_mood_type,          transaction_id,          pay_amount,          patient_no_fk,          pat.patient_name,          pat.patient_code,
        //  trunc (ledger_paymood_date) receipt_date,          trunc (invoice_date) invoice_date,          pay.au_entry_by,          fnc_username (pay.au_entry_by) user_name
        //  from finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat
        //  where     mst.invoice_no_pk = pay.invoice_no_fk
        //      and mst.patient_no_fk = pat.patient_no_pk
        //      and PAYMOOD <> 'CASH'  $sql_cond ";
        //          dd($report_data);

        return Template::loadView("admin.reports.card_payment_report_table", ['report_data' => $report_data]);
    }

    public function cardPaymentReportPrint(Request $request)
    {
        $module = $request->module;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $mbs_id = $request->mbs_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $bank = $request->bank;
        $mbs = $request->mbs;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //        $date_from = date('Y/m/d', strtotime($request->date_from));
        //        $date_to = date('Y/m/d', strtotime($request->date_to));

        $doctor_id = $request->doctor_id;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id' " : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($mbs_id != "") ? " $clause pay_mood_type ='$mbs_id' and paymood = 'Mbanking'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_paymood_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause us.PERSON_NO_fK = $doctor_id" : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($bank != "") ? " $clause bank_name is not null" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($mbs != "") ? " $clause paymood = 'Mbanking' and pay_mood_type is not null " : "";


        if ($request->hdn_report_type == "CASHIER") {
            if ($request->module == "Pharmacy") {
                $report_data = db::select("SELECT paymood,
                                pay_mood_type,
                                transaction_id,
                                card_invoice_no,
                                pay_amount,
                                patient_no_fk,
                                pat.patient_name,
                                pat.patient_code,
                                TRUNC (ledger_paymood_date) receipt_date,
                                TRUNC (invoice_date) invoice_date,
                                pay.au_entry_by,
                                fnc_username (pay.au_entry_by) user_name
                        FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat, sysc_module md
                        WHERE     mst.invoice_no_pk = pay.invoice_no_fk
                                AND mst.patient_no_fk = pat.patient_no_pk
                                and mst.module_no_fk = md.module_no_pk
                                and PAYMOOD <> 'CASH' and md.MODULE_CODE in  ('PHR','PHR-I') $sql_cond ");
            } else {
                $report_data = db::select("SELECT paymood,
                        pay_mood_type,
                        sum(pay_amount) collection,
                        fnc_username (pay.au_entry_by) user_name
                FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat
                WHERE     mst.invoice_no_pk = pay.invoice_no_fk
                        AND mst.patient_no_fk = pat.patient_no_pk
                        AND PAYMOOD <> 'CASH'  $sql_cond
                        group by  paymood,
                        pay_mood_type,
                        pay.au_entry_by  ");

                $report_dt = [];
                foreach ($report_data as $dt) {
                    $report_dt[$dt->user_name][] = $dt;
                }
            }
        } else {

            if ($request->module == "Pharmacy") {
                $report_data = db::select("SELECT paymood,
                                    pay_mood_type,
                                    transaction_id,
                                    card_invoice_no,
                                    pay_amount,
                                    patient_no_fk,
                                    pat.patient_name,
                                    pat.patient_code,
                                    TRUNC (ledger_paymood_date) receipt_date,
                                    TRUNC (invoice_date) invoice_date,
                                    pay.au_entry_by,
                                    fnc_username (pay.au_entry_by) user_name
                            FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat, sysc_module md
                            WHERE     mst.invoice_no_pk = pay.invoice_no_fk
                                    AND mst.patient_no_fk = pat.patient_no_pk
                                    and mst.module_no_fk = md.module_no_pk
                                    and PAYMOOD <> 'CASH' and md.MODULE_CODE in  ('PHR','PHR-I') $sql_cond ");
            } else {
                $report_data = db::select("SELECT paymood,
                    pay_mood_type,
                    transaction_id,
                    card_invoice_no,
                    pay_amount,
                    mst.patient_no_fk,
                    pat.patient_name,
                    pat.patient_code,
                    TRUNC (ledger_paymood_date) receipt_date,
                    TRUNC (invoice_date) invoice_date,
                    pay.au_entry_by,
                    fnc_username (pay.au_entry_by) user_name
               FROM finc_invoicemst mst, finc_ledger_paymood pay, patn_registration pat , wsec_user  us
              WHERE     mst.invoice_no_pk = pay.invoice_no_fk
                    AND mst.patient_no_fk = pat.patient_no_pk
                    and us.user_no_pk = pay.au_entry_by
                    AND PAYMOOD <> 'CASH'  $sql_cond ");
            }
        }

        //    dd($report_data);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // dd($mbs);
        if ($request->hdn_report_type == "CASHIER") {
            $pdf = PDF::loadView("admin.reports.card_payment_report_print_cashier", [
                'report_data' => $report_data,
                'report_dt' => $report_dt,
                'po_hospital_details' => $po_hospital_details,
                'barcode_no' => $barcode_no,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'bank_name' => $mbs_id,
                'module' => $module,
                'bank' => $bank,
                'mbs' => $mbs
            ]);
            return $pdf->download('bank_details_report_cashier.pdf');
        } else {
            $pdf = PDF::loadView("admin.reports.card_payment_details_print", [
                'report_data' => $report_data,
                'po_hospital_details' => $po_hospital_details,
                'barcode_no' => $barcode_no,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'bank_name' => $mbs_id,
                'module' => $module,
                'bank' => $bank,
                'mbs' => $mbs
            ]);
            return $pdf->download('bank_details_report.pdf');
        }
    }


    public function doctorIncomeDetails()
    {
        return Template::loadview("admin.reports.doctor_income_details", [
            'ipds_wards' => DB::table('ipds_ward')
                ->select("ward_name", "ward_no_pk")
                ->orderBy('ward_no_pk', 'asc')
                ->get()
                ->toArray()
        ]);
    }



    //discharge
    public function dischargeReport($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $discharge_data = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $id)->get();
        $admission_details = DB::table('ipd_admission_details')->where('admission_no_pk', $id)
            ->first();
        // $med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->where("continue_ind", 0)->get();
        $med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->get();
        $receive_med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->where("continue_ind", 1)->get();
        $investigation_data = DB::table("ipd_discharge_investigation")->where("admission_no_fk", $id)->get();
        $item = ["LAB", "RAD"];
        $receive_investigation_data = DB::table("finc_ipd_invoicedtl_vw")->where("admission_no_fk", $id)->whereIn("item_type", $item)->get();
        $instructions = $this->getPresLookupListByCode("INSTRUCTION");
        $admite_id = $id;
        $patient_id = $discharge_data[0]->patient_code;
        //    dd($investigation_data);
        $title = $admite_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $patient_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode_no = $barcode->generate();

        $pdf = App::make('dompdf.wrapper');
        $userInfo  = Auth::user();

        // $pdf = PDF::loadView(
        //     // 'admin.ipd.discharge.discharge_report',
        //     'admin.ipd.discharge.discharge_report_v2',
        //     [
        //         'po_hospital_details' => $po_hospital_details,
        //         'discharge_data' => $discharge_data,
        //         'userInfo' => $userInfo,
        //         'admission_details' => $admission_details,
        //         'barcode_no' => $barcode_no,
        //         'patient_barcode_no' => $patient_barcode_no,
        //         'med_data' => $med_data,
        //         'instructions' => $instructions,
        //         'investigation_data' => $investigation_data,
        //         'receive_med_data' => $receive_med_data,
        //         'receive_investigation_data' => $receive_investigation_data,
        //     ]
        // );
        // dd($med_data);
        return view(
            // 'admin.ipd.discharge.discharge_report',
            'admin.ipd.discharge.discharge_report_v2',
            [
                'po_hospital_details' => $po_hospital_details,
                'discharge_data' => $discharge_data,
                'userInfo' => $userInfo,
                'admission_details' => $admission_details,
                'barcode_no' => $barcode_no,
                'patient_barcode_no' => $patient_barcode_no,
                'med_data' => $med_data,
                'instructions' => $instructions,
                'investigation_data' => $investigation_data,
                'receive_med_data' => $receive_med_data,
                'receive_investigation_data' => $receive_investigation_data,
            ]
        );

        // return $pdf->stream("Discharge Certificate.pdf", array("Attachment" => false));
    }

    //discharge new
    public function dischargeNewReport($id)
    {
         $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU");
        $gender = $this->getLookupListByCode("GENDER");
        $route = $this->getPresLookupListByCode("ROUTE");
        $dose = $this->getPresLookupListByCode("DOSE");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $discharge_data = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $id)->get();
        $patient_data = DB::table('ipd_patient_history_all')->where('admission_no_pk', $id)->first();
       $admission_details = DB::table('ipd_admission_details')
        ->select(
            'ipd_admission_details.*',
            'prep_doc.doctor_signature as prepare_doctor_signature',
            'prep_doc.doctor_signature_image as prepare_doctor_signature_image',
            'verify_doc.doctor_signature as verify_doctor_signature',
            'verify_doc.doctor_signature_image as verify_doctor_signature_image',
            'referral_doc.doctor_signature as referral_doctor_signature',
            'pre_anaesthetia.full_name as pre_ot_anaesthetia_name',
            'pre_surgeon.full_name as pre_ot_surgeon_name',
            'pre_anaesthetist.full_name as pre_ot_anaesthetist_name',
        )
        ->leftJoin('hrms_personnel as pre_anaesthetia', 'pre_anaesthetia.person_no_pk', '=', 'ipd_admission_details.pre_ot_anaesthesia_no')
        ->leftJoin('hrms_personnel as pre_surgeon', 'pre_surgeon.person_no_pk', '=', 'ipd_admission_details.pre_ot_surgeon_no')
        ->leftJoin('hrms_personnel as pre_anaesthetist', 'pre_anaesthetist.person_no_pk', '=', 'ipd_admission_details.pre_ot_anaesthetist_no')
        ->leftJoin('hrms_personnel as prep_doc', 'ipd_admission_details.prepare_doc_person_no_fk', '=', 'prep_doc.person_no_pk')
        ->leftJoin('hrms_personnel as verify_doc', 'ipd_admission_details.verified_doc_person_no_fk', '=', 'verify_doc.person_no_pk')
        ->leftJoin('hrms_personnel as referral_doc', 'ipd_admission_details.referral_doc_person_no_fk', '=', 'referral_doc.person_no_pk')
        ->where('ipd_admission_details.admission_no_pk', $id)
        ->first();

        // dd( $admission_details);
        $med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)
        ->orderBy('discharge_med_pk_no', 'asc')
        ->get();

        $merged_med_info = collect();
        if ($med_data->isNotEmpty()) {
            $merged_med_info = $med_data;
        }
        // $medicine_details = DB::table('psn_t_prescription_med')
        //     ->where('admission_pk_no', $id)
        //     // ->where('continue_ind', 1)
        //     ->where('DISCONTINE_IND',  0)
        //     ->get()
        //     ->map(function($item){
        //         $item->item_no_fk = $item->item_no_fk ?? $item->item_no_pk ?? null;
        //         $item->item_name = $item->brand_name ?? $item->generic_name ?? '';
        //         $item->med_taken_instruction = $item->instruction_take ?? '';
        //         $item->route = $item->route ?? '';
        //         return $item;
        //     });

        // if ($med_data->isNotEmpty()) {
        //     $merged_med_info = $med_data;
        // } else {
        //     $merged_med_info = $medicine_details;
        // }

        // $receive_med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->where("continue_ind", 1)->get();
        // $investigation_data = DB::table("ipd_discharge_investigation")->where("admission_no_fk", $id)->get();
        $investigation_data = DB::table('ipd_discharge_investigation')
        ->leftJoin('sysc_serviceitem_vw', 'ipd_discharge_investigation.item_no_fk', '=', 'sysc_serviceitem_vw.item_no_pk')
        ->where('ipd_discharge_investigation.admission_no_fk', $id)
        ->whereNotIn('sysc_serviceitem_vw.item_type',['PROC'])
        ->select('ipd_discharge_investigation.*','sysc_serviceitem_vw.item_type')->get();


        $investigation_data_proc = DB::table('ipd_discharge_investigation')
        ->leftJoin('sysc_serviceitem_vw','ipd_discharge_investigation.item_no_fk', '=', 'sysc_serviceitem_vw.item_no_pk')
        ->where('ipd_discharge_investigation.admission_no_fk',$id)
        ->where('sysc_serviceitem_vw.item_type',['PROC'])
        ->select('ipd_discharge_investigation.*', 'sysc_serviceitem_vw.item_type as item_type')->get();
        // dd($investigation_data,$investigation_data_proc);
        $doc_signature = DB::table('ipd_admitted_patlist_vw')
        ->leftJoin('hrms_personnel', 'ipd_admitted_patlist_vw.discharge_doc_person_no_fk', '=', 'hrms_personnel.person_no_pk')
        ->where('ipd_admitted_patlist_vw.admission_no_pk', $id)
        ->select(
            'hrms_personnel.doctor_signature',
            'hrms_personnel.doctor_signature_image'
        )
        ->first();




        $item = ["LAB", "RAD"];
        $receive_investigation_data = DB::table("finc_ipd_invoicedtl_vw")->where("admission_no_fk", $id)->whereIn("item_type", $item)->get();
        $instructions = $this->getPresLookupListByCode("INSTRUCTION");
        $admite_id = $id;
        $patient_id = $discharge_data[0]->patient_code;
        //    dd($patient_data);
        $title = $admite_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $patient_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode_no = $barcode->generate();

        $pdf = App::make('dompdf.wrapper');
        $userInfo  = Auth::user();

        return view(
            // 'admin.ipd.discharge.discharge_report',
            'admin.ipd.discharge.discharge_new_report_v2',
            [
                'po_hospital_details' => $po_hospital_details,
                'discharge_data' => $discharge_data,
                'userInfo' => $userInfo,
                'admission_details' => $admission_details,
                'barcode_no' => $barcode_no,
                'patient_barcode_no' => $patient_barcode_no,
                'med_data' => $merged_med_info,
                'instructions' => $instructions,
                'investigation_data' => $investigation_data,
                'merged_med_info' => $merged_med_info,
                'receive_investigation_data' => $receive_investigation_data,
                'investigation_data_proc' => $investigation_data_proc,
                'patient_data' => $patient_data,
                // 'medicine_details' => $medicine_details,
                'doc_signature' => $doc_signature,
                'gender' => $gender,
                'route' => $route,
                'dose' => $dose,
            ]
        );

    }


    //Pharmacy Report

    public function financialPharmacyReport()
    {
        $ref_doctors = DB::table('wl_referral_list_vw')->select('person_no_pk', 'full_name')->get();
        return Template::loadView("admin.reports.pharmacy.financial", ['ref_doctors' => $ref_doctors]);
    }

    public function financialReportPharmacyData(Request $request)
    {
        // return $request;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $ipd_opd = $request->ipd_opd;
        // dd($referral_id);
        //    return $request->date_from;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->due_ind != "") ? " $clause NVL(finc_voucherwise_vw_phr.due,0) >0" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause finc_voucherwise_vw_phr.patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause finc_voucherwise_vw_phr.invoice_no_pk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause finc_voucherwise_vw_phr.doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($ipd_opd != "") ? " $clause finc_voucherwise_vw_phr.module_code='$ipd_opd'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(finc_voucherwise_vw_phr.invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select finc_voucherwise_vw_phr.* , finc_phr_inv_billing_list_vw.invoice_trn_list from FINC_VOUCHERWISE_VW_PHR left join FINC_PHR_INV_BILLING_LIST_VW on finc_phr_inv_billing_list_vw.invoice_no_pk = finc_voucherwise_vw_phr.invoice_no_pk $sql_cond order by finc_voucherwise_vw_phr.invoice_code DESC");
        // dd($report_data);
        // $report_data = DB::select("select * from finc_voucherwise_vw   $sql_cond order by invoice_code DESC");

        return Template::loadView("admin.reports.pharmacy.financial_table", ['report_data' => $report_data]);
    }

    public function reportPharmacyFinancialPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->due_ind != "") ? " $clause NVL(finc_voucherwise_vw_phr.due,0) >0" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from FINC_VOUCHERWISE_VW_PHR $sql_cond order by invoice_code DESC");
        // $report_data = DB::select("select * from finc_voucherwise_vw   $sql_cond order by invoice_code DESC");

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.financial_print_pdf", [
            'report_data' => $report_data,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('Pharmacy-Financial-Invoice.pdf');
    }


    public function financialPharmacySummaryReportData()
    {
        return Template::loadView("admin.reports.pharmacy.financial_summary");
    }

    public function financialPharmacySummaryReport(Request $request)
    {

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));
        //dd()

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        // $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw $sql_cond order by invoice_date DESC");
        $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw_phr $sql_cond order by invoice_date DESC");



        return Template::loadView("admin.reports.pharmacy.financial_summary_table", ['report_data' => $report_data]);
    }

    public function reportFinancialPharmacySummaryPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));
        ////dd()

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        // $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw $sql_cond order by invoice_date DESC");
        $report_data = DB::select("SELECT * FROM finc_summarystatement_dt_vw_phr $sql_cond order by invoice_date DESC");


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

        $pdf = PDF::loadView("admin.reports.pharmacy.financial_summary_report", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no]);

        return $pdf->download('Pharmacy Financial-Summary-Invoice.pdf');
    }


    public function dailyPharmacySalesReport()
    {
        $type = 'Sales';

        return Template::loadView("admin.reports.pharmacy.daily_sales", ['type' => $type]);
    }
    public function dailyPharmacySalesSummaryReport()
    {
        $type = 'Sales';

        return Template::loadView("admin.reports.pharmacy.daily_sales_summary", ['type' => $type]);
    }

    public function dailyPharmacyCollectionReport()
    {
        $type = 'Collection';
        return Template::loadView("admin.reports.pharmacy.daily_collection", ['type' => $type]);
    }

    public function dailyPharmacyDiscountReport()
    {
        $type = 'Discount';
        return Template::loadView("admin.reports.pharmacy.daily_discount", ['type' => $type]);
    }

    public function dailyPharmacyReportData(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
            $due = $request->due_amt;

            $ipd_amt = $request->ipd_amt;
            $opd_amt = $request->opd_amt;
            $all_amt = $request->all_amt;
        } else {
            $date_from = "";
            $date_to = "";
            $due = "";
        }
        $doctor_id = $request->doctor_id;
        $sql_cond = '';
        if ($request->opd_amt == 'OPD') {
            $sql_cond = "where module_code in ('PHR')";
        } else if ($request->ipd_amt == 'IPD') {
            $sql_cond = "where module_code in ('PHR-I')";
        } else if ($request->ipd_amt == 'OT') {
            $sql_cond = "where module_code in ('PHR-O')";
        } else if ($request->ipd_amt == 'DIALYSIS') {
            $sql_cond = "where module_code in ('PHR-D')";
        } else if ($request->ipd_amt == 'EMERGENCY') {
            $sql_cond = "where module_code in ('PHR-E')";
        } else {
            $sql_cond = "where module_code in ('PHR','PHR-I','PHR-O','PHR-D','PHR-E')";
        }

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause nvl(trunc(ledger_datetime),trunc(invoice_date)) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";

        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($ipd_amt != "") ? "   and  invoice.admission_no_pk  is not NULL" : "";
        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($opd_amt != "") ? "   and invoice.admission_no_pk is null" : "";

        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($all_amt != "") ? "   and invoice.module_code = $doctor_id" : "";

        $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
        invoice.invoice_code,
        invoice.ledgertrn_no_pk,
        invoice.ledger_datetime,
        invoice.counter_name,
        invoice.patient_type,
        invoice.serviceunit_no_pk,
        invoice.invoice_date,
        invoice.customer_name,
        invoice.counter_su_no_fk,
        invoice.sales as ledger_amt_sales,
        invoice.sales_cancel,
        invoice.discount as ledger_amt_discount,
        invoice.collection as ledger_amt_payment,
        invoice.net_sales as ledger_amt_sales_net,
        invoice.due as ledger_amt_due,
        invoice.refund,
        invoice.net_collection,
        invoice.mobile1,
        invoice.discount_detail,
        invoice.admission_no_pk,
        per.full_name
        from FINC_C022_VRMST_SUM_CASHIER_VW invoice
        left join wsec_user us
        -- hrms_personnel per
        on invoice.invoice_entry_by = us.user_no_pk
        left join hrms_personnel per
        on per.person_no_pk = us.person_no_fk  $sql_cond  order by invoice.ledgertrn_no_pk DESC "));
        // dd($cashier_data);
        $cashier_arr = [];

        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }

        // return Template::loadView("admin.reports.pharmacy.daily_report_table", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details,  'type' => $type]);
        return Template::loadview("admin.reports.date_cashier_wise_search_data", [
            'cashier_arr' => $cashier_arr
        ]);
    }
    public function dailyPharmacySummaryReportData(Request $request)
    {

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
            $due = $request->due_amt;

            $ipd_amt = $request->ipd_amt;
            $opd_amt = $request->opd_amt;
            $all_amt = $request->all_amt;
        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;
        $sql_cond = '';
        if ($request->opd_amt == 'OPD') {
            $sql_cond = "where module_code in ('PHR')";
        } else if ($request->ipd_amt == 'IPD') {
            $sql_cond = "where module_code in ('PHR-I')";
        } else if ($request->ipd_amt == 'OT') {
            $sql_cond = "where module_code in ('PHR-O')";
        } else if ($request->ipd_amt == 'DIALYSIS') {
            $sql_cond = "where module_code in ('PHR-D')";
        } else if ($request->ipd_amt == 'EMERGENCY') {
            $sql_cond = "where module_code in ('PHR-E')";
        } else {
            $sql_cond = "where module_code in ('PHR','PHR-I','PHR-O','PHR-D','PHR-E')";
        }


        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";

        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($ipd_amt != "") ? "   and  invoice.admission_no_pk  is not NULL" : "";
        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($opd_amt != "") ? "   and invoice.admission_no_pk is null" : "";

        // $clause = ($sql_cond == "") ? " where" : "and";
        // $sql_cond .= ($all_amt != "") ? "   and invoice.module_code = $doctor_id" : "";

        $cashier_data = DB::select(DB::raw("select
        per.full_name,
        trunc(invoice.invoice_date) as invoice_date,
         sum(invoice.sales) as ledger_amt_sales,
         sum(invoice.discount) as ledger_amt_discount,
         sum(invoice.collection) as ledger_amt_payment,
         sum(invoice.net_sales) as ledger_amt_sales_net,
         sum(invoice.due )as ledger_amt_due,
         sum(invoice.refund) as refund,
         sum(invoice.net_collection) as net_collection
         from FINC_C022_VRMST_SUM_CASHIER_VW invoice
         left join wsec_user us
         on invoice.invoice_entry_by = us.user_no_pk
         left join hrms_personnel per
        on per.person_no_pk = us.person_no_fk  $sql_cond
        group by
        trunc(invoice.invoice_date),
        per.full_name
        order by  trunc(invoice.invoice_date)  DESC "));
        return Template::loadview("admin.reports.date_cashier_wise_search_data_summary", [
            'cashier_arr' => $cashier_data
        ]);
    }

    public function reportPharmacyDailyPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $due = $request->due_amt;
        $ipd_amt = $request->ipd_amt;
        $opd_amt = $request->opd_amt;
        $all_amt = $request->all_amt;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = '';
        if ($request->opd_amt == 'OPD') {
            $sql_cond = "where module_code in ('PHR')";
        } else if ($request->ipd_amt == 'IPD') {
            $sql_cond = "where module_code in ('PHR-I')";
        } else if ($request->ipd_amt == 'OT') {
            $sql_cond = "where module_code in ('PHR-O')";
        } else if ($request->ipd_amt == 'DIALYSIS') {
            $sql_cond = "where module_code in ('PHR-D')";
        } else if ($request->ipd_amt == 'EMERGENCY') {
            $sql_cond = "where module_code in ('PHR-E')";
        } else {
            $sql_cond = "where module_code in ('PHR','PHR-I','PHR-O','PHR-D','PHR-E')";
        }

        //$sql_cond = "where module_code in ('PHR' , 'PHR-I')";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_datetime) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";
        $cashier_data = DB::select(DB::raw("select invoice.invoice_no_pk,
        invoice.invoice_code,
        invoice.ledgertrn_no_pk,
        invoice.ledger_datetime,
        invoice.counter_name,
        invoice.patient_type,
        invoice.serviceunit_no_pk,
        invoice.invoice_date,
        invoice.customer_name,
        invoice.counter_su_no_fk,
        invoice.sales as ledger_amt_sales,
        invoice.sales_cancel,
        invoice.discount as ledger_amt_discount,
        invoice.collection as ledger_amt_payment,
        invoice.net_sales as ledger_amt_sales_net,
        invoice.due as ledger_amt_due,
        invoice.refund,
        invoice.net_collection,
        invoice.mobile1,
        invoice.discount_detail,
        per.full_name
        from FINC_C022_VRMST_SUM_CASHIER_VW invoice
        left join wsec_user us
        -- hrms_personnel per
        on invoice.invoice_entry_by = us.user_no_pk
        left join hrms_personnel per
        on per.person_no_pk = us.person_no_fk  $sql_cond order by invoice.ledgertrn_no_pk DESC "));


        $cashier_arr = [];

        foreach ($cashier_data as $cashier_no) {
            $cashier_arr[$cashier_no->full_name][$cashier_no->counter_su_no_fk . "_" . $cashier_no->counter_name][] = $cashier_no;
        }

        $title = "Date Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        return view("admin.reports.date_cashier_wise_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
    }
    public function reportPharmacyDailySummaryPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $due = $request->due_amt;
        $ipd_amt = $request->ipd_amt;
        $opd_amt = $request->opd_amt;
        $all_amt = $request->all_amt;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = '';
        if ($request->opd_amt == 'OPD') {
            $sql_cond = "where module_code in ('PHR')";
        } else if ($request->ipd_amt == 'IPD') {
            $sql_cond = "where module_code in ('PHR-I')";
        } else if ($request->ipd_amt == 'OT') {
            $sql_cond = "where module_code in ('PHR-O')";
        } else if ($request->ipd_amt == 'DIALYSIS') {
            $sql_cond = "where module_code in ('PHR-D')";
        } else if ($request->ipd_amt == 'EMERGENCY') {
            $sql_cond = "where module_code in ('PHR-E')";
        } else {
            $sql_cond = "where module_code in ('PHR','PHR-I','PHR-O','PHR-D','PHR-E')";
        }

        //$sql_cond = "where module_code in ('PHR' , 'PHR-I')";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person_no_fk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($due != "") ? " $clause due > 0" : "";

        $cashier_data = DB::select(DB::raw("select
        per.full_name,
        trunc(invoice.invoice_date) as invoice_date,
         sum(invoice.sales) as ledger_amt_sales,
         sum(invoice.discount) as ledger_amt_discount,
         sum(invoice.collection) as ledger_amt_payment,
         sum(invoice.net_sales) as ledger_amt_sales_net,
         sum(invoice.due )as ledger_amt_due,
         sum(invoice.refund) as refund,
         sum(invoice.net_collection) as net_collection
         from FINC_C022_VRMST_SUM_CASHIER_VW invoice
         left join wsec_user us
         on invoice.invoice_entry_by = us.user_no_pk
         left join hrms_personnel per
        on per.person_no_pk = us.person_no_fk  $sql_cond
        group by
        trunc(invoice.invoice_date),
        per.full_name
        order by  trunc(invoice.invoice_date)  DESC "));

        $title = "Date Cashier Wise Summary Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        return view("admin.reports.date_cashier_wise_summary_report_print", ['cashier_arr' => $cashier_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
        // $pdf = PDF::loadView("admin.reports.date_cashier_wise_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
        // return $pdf->stream('date-cashier-wise-report.pdf');
    }
    public function PharmacyCashierWiseReport()
    {
        return Template::loadview("admin.reports.pharmacy.cashier_wise_report");
    }


    public function PharmacyCashierWiseReportSearch(Request $request)
    {
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause module_code NOT IN ('PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')" ;


        // $query = DB::select(DB::raw("select * from FINC_CASHIER_WISE_REPORTS_VW $sql_cond  "));
        $query = DB::select(DB::raw("select * from finc_voucherwise_vw_phr $sql_cond  "));

        return Template::loadview("admin.reports.pharmacy.cashier-wise-search-data", [
            'data' => $query
        ]);
    }

    public function PharmacyCashierWiseReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = "$request->search_date_from";
        $to_date = "$request->search_date_to";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause module_code NOT IN ('PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')" ;



        // $data = DB::select(DB::raw("select * from FINC_CASHIER_WISE_REPORTS_VW $sql_cond  "));
        $data = DB::select(DB::raw("select * from finc_voucherwise_vw_phr $sql_cond  "));


        $title = "Pharmacy Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.cashier_wise_report_print", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->download('Pharmacy-date-wise-report.pdf');
    }

    //cashier wise ipd pharmacy report
    public function PharmacyCashierWiseReportIpd()
    {
        return Template::loadview("admin.reports.pharmacy.cashier_wise_report_ipd");
    }
    public function PharmacyCashierWiseIpdReportSearch(Request $request)
    {
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause module_code IN ('PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')" ;


        // $query = DB::select(DB::raw("select * from FINC_CASHIER_WISE_REPORTS_VW $sql_cond  "));
        $query = DB::select(DB::raw("select * from finc_voucherwise_vw_phr $sql_cond  "));

        return Template::loadview("admin.reports.pharmacy.cashier-wise-search-data-ipd", [
            'data' => $query
        ]);
    }

    public function PharmacyCashierWiseIpdReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $from_date = "$request->search_date_from";
        $to_date = "$request->search_date_to";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause user_person = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause module_code IN ('PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')" ;


        // $data = DB::select(DB::raw("select * from FINC_CASHIER_WISE_REPORTS_VW $sql_cond  "));
        $data = DB::select(DB::raw("select * from finc_voucherwise_vw_phr $sql_cond  "));


        $title = "Pharmacy Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.cashier_wise_report_print", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->download('Pharmacy-date-wise-report.pdf');
    }


    //    Cashier Wise collection
    public function PharmacyCashierWiseCollectionReport()
    {
        return Template::loadview("admin.reports.pharmacy.cashier_wise_collection_report");
    }

    public function PharmacyCashierWiseCollectionSearchData(Request $request)
    {

        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";
        $query = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        sum(total_invoice_cnt_new) total_invoice_cnt_new,
        sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        sum(sales)  sales,
        sum(discount)discount,
        sum(net_sales) net_sales,
        sum(collection) collection,
        sum(refund) refund,
        sum(sales_calncel) sales_calncel,
        sum(net_collection) net_collection
        from  finc_cashierwisesummary_vw     $sql_cond and module_code_phr_nonphr in ('PHR','PHR-I') group by  full_name,person_code , ledgertrn_date order by ledgertrn_date asc"));

        return Template::loadview("admin.reports.pharmacy.cashier_wise_collection_data_list", [
            'data' => $query,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function PharmacyCashierWiseCollectionSearchDataPrint(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
        sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        sum(sales)  sales,
        sum(discount)discount  ,
        sum(net_sales) net_sales  ,
        sum(collection) collection ,
        sum(refund) refund ,
        sum(sales_calncel) sales_calncel ,
        sum(net_collection) net_collection
        from  finc_cashierwisesummary_vw    $sql_cond  and module_code_phr_nonphr in ('PHR','PHR-I') group by  full_name,person_code , ledgertrn_date order by ledgertrn_date asc"));

        $title = "Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.cashier_wise_collection_data_print", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
        return $pdf->stream('cashier-wise-report.pdf');
    }
    public function pharmacyCardPaymentReport()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.pharmacy.card_payment_details.pharmacy_card_payment_report", [
            'bank_name' => $bank_name
        ]);
    }

    public function pharmacyCardPaymentReportSearch(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select * from finc_ledger_paymod_srvchrg_vw_phr $sql_cond order by invoice_code DESC ");

        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.pharmacy.card_payment_details.pharmacy_card_payment_report_table", ['report_data' => $report_data]);
    }

    public function pharmacyCardPaymentReportPrint(Request $request)
    {
        // return $report_data;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $from = $request->date_from;
        $to = $request->date_to;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $report_data = DB::select("select * from finc_ledger_paymod_srvchrg_vw_phr $sql_cond order by invoice_code ASC  ");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        foreach ($report_data as $row) {
            $title = $row->invoice_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
        }

        $pdf = PDF::loadView("admin.reports.pharmacy.card_payment_details.pharmacy_card_payment_details_print", [
            'report_data' => $report_data,
            'po_hospital_details' => $po_hospital_details,
            'barcode_no' => $barcode_no,
            'from_date' => $from,
            'to_date' => $to
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Pharmacy-Card-Payment-Invoice.pdf');
    }

    //    item_type_wise Report

    public function itemTypeWiseReport()
    {
        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.item_type_wise_report", [
            'item_type' => $item_type
        ]);
    }
    public function phrProfitLose()
    {
        $to_date = date('Y-m-d');
        $item_data = DB::table('finc_itemmedwise_profit_calculate')->where('au_entry_at',  $to_date)->get();
        return Template::loadview("admin.reports.phr_profit_lose_report", [
            'item_data' => $item_data
        ]);
    }


    public function phrProfitLoseSearch(Request $request)
    {
        // return $report_data;
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $from_date = date("Y-m-d", strtotime($request->date_from));
        $from_to = date("Y-m-d", strtotime($request->date_to));

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk =$doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $item_data = DB::select("select * from finc_itemmedwise_profit_calculate $sql_cond order by au_entry_at DESC ");


        $zakat_fund_muslim = DB::select(
            "select  CASE
            WHEN MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
        END  general_acc
        , to_char(sum(zakatfund)) muslim, '' non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'ZAKATFUND' and  zakatfund !=0
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END "
        );


        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");


        $zakat_muslim = collect($zakat_fund_muslim)->sum('muslim');
        $zakat_nonmuslim = collect($zakat_fund_non_muslim)->sum('non_muslim');

        //dd($zakat_fund_muslim);
        //dd($zakat_muslim,$zakat_nonmuslim);

        // dd($item_data );
        return Template::loadView("admin.reports.phr_profit_lose_report_list", ['item_data' => $item_data, 'zakat_muslim' => $zakat_muslim, 'zakat_nonmuslim' => $zakat_nonmuslim]);
    }

    public function phrProfitLosePrint(Request $request)
    {
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $from_date = date("Y-m-d", strtotime($request->date_from));
        $from_to = date("Y-m-d", strtotime($request->date_to));


        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk =$doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $item_data = DB::select("select * from finc_itemmedwise_profit_calculate $sql_cond order by au_entry_at DESC ");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $zakat_fund_muslim = DB::select(
            "select  CASE
            WHEN MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
        END  general_acc
        , to_char(sum(zakatfund)) muslim, '' non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'ZAKATFUND' and  zakatfund !=0
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END "
        );


        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");


        $zakat_muslim = collect($zakat_fund_muslim)->sum('muslim');
        $zakat_nonmuslim = collect($zakat_fund_non_muslim)->sum('non_muslim');


        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.phr_profit_lose_report_print", [
            'item_data' => $item_data,
            'po_hospital_details' => $po_hospital_details,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'zakat_muslim' => $zakat_muslim,
            'zakat_nonmuslim' => $zakat_nonmuslim
        ]);
        return $pdf->download('Pharmacy Profit-lose Report.pdf');
    }


    public function phrProfitLosePrintExcel(Request $request)
    {
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $from_date = date("Y-m-d", strtotime($request->date_from));
        $from_to = date("Y-m-d", strtotime($request->date_to));


        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk =$doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $item_data = DB::select("select * from finc_itemmedwise_profit_calculate $sql_cond order by au_entry_at DESC ");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        $zakat_fund_muslim = DB::select(
            "select  CASE
            WHEN MODULE_CODE IN ('PHR','PHR-I')
            THEN
                'Pharmacy A/C'
            ELSE
                'General A/C '
        END  general_acc
        , to_char(sum(zakatfund)) muslim, '' non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'ZAKATFUND' and  zakatfund !=0
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END "
        );


        $zakat_fund_non_muslim = DB::select("select CASE
        WHEN MODULE_CODE IN ('PHR','PHR-I')
        THEN
            'Pharmacy A/C'
        ELSE
            'General A/C '
        END  general_acc, '' muslim, to_char(sum(zakatfund)) non_muslim
                    from finc_c022_sum_amount_zakat_vw
                    where fund_type = 'NONMUSLIMFUND'
                    and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$from_to','YYYY-MM-DD'))
                    group by CASE
                              WHEN MODULE_CODE IN ('PHR','PHR-I')
                              THEN
                                  'Pharmacy A/C'
                              ELSE
                                  'General A/C '
                          END

                    ");


        $zakat_muslim = collect($zakat_fund_muslim)->sum('muslim');
        $zakat_nonmuslim = collect($zakat_fund_non_muslim)->sum('non_muslim');


        // $title = '123456';
        // $barcode = new BarcodeGenerator();
        // $barcode->setText($title);
        // $barcode->setType(BarcodeGenerator::Code128);
        // $barcode->setLabel('');
        // $barcode->setScale(1);
        // $barcode->setThickness(25);
        // $barcode->setFontSize(10);
        // $barcode_no = $barcode->generate();

        $fileToExport = "Pharmacy Profit-lose Report";
        $html = view("admin.reports.phr_profit_lose_report_excel", [
            'item_data' => $item_data,
            'po_hospital_details' => $po_hospital_details,
            'from_date' => $date_from,
            'to_date' => $date_to
        ]);

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;




        // $pdf = PDF::loadView("admin.reports.phr_profit_lose_report_print", [
        //     'item_data' => $item_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'zakat_muslim' => $zakat_muslim, 'zakat_nonmuslim' => $zakat_nonmuslim
        // ]);
        // return $pdf->download('Pharmacy Profit-lose Report.pdf');
    }



    public function itemTypeWiseSearch(Request $request)
    {
        // return $report_data;
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk =$doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select * from FINC_ITEMTYPE_WISE_VW $sql_cond order by invoice_date DESC ");
        $data_arr = [];
        foreach ($report_data as $data) {
            $data_arr[$data->invoice_date][$data->item_type_name] =  $data;
        }
        return Template::loadView("admin.reports.item_type_wise_report_table", ['data' => $report_data, 'data_arr' => $data_arr]);
    }

    public function itemTypeWisePrint(Request $request)
    {
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select * from FINC_ITEMTYPE_WISE_VW $sql_cond order by invoice_date DESC ");
        $data_arr = [];
        foreach ($report_data as $data) {
            $data_arr[$data->invoice_date][$data->item_type_name] =  $data;
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.item_type_wise_report_pdf", [
            'data' => $report_data,
            'po_hospital_details' => $po_hospital_details,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'data_arr' => $data_arr
        ]);
        return $pdf->download('item-type-wise-report.pdf');
    }

    public function itemTypeWiseReportPrintItem($id)
    {
        $item_type = DB::table('finc_cashier_wise_itemtype_vw')
            ->where("person_no_pk", $id)
            ->get();

        dd($item_type);
    }



    //    Ipd All Reports

    public function ipdFinancialReport()
    {
        $ref_doctors = DB::table('wl_referral_list_vw')->select('person_no_pk', 'full_name')->get();
        return Template::loadView("admin.reports.ipd.financial.ipd_financial", ['ref_doctors' => $ref_doctors]);
    }

    public function ipdFinancialReportData(Request $request)
    {
        // return $request;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        //    return $request->date_from;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";

        $sql_cond .= ($referral_id != "") ? " $clause person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT admission_no_pk,
			TO_CHAR (invoice_date, 'DD-MM-YYYY') invc_date,
			patient_code,
			patient_name,
			age,
			gender_txt,
			mobile1,
			prescribed_physio_name,
			first_ref_doc_name,doctor_name,
			ledger_amt_sales,
			nvl(ledger_amt_discount,0) ledger_amt_discount,
			(ledger_amt_sales - nvl(ledger_amt_discount,0)) net_payable,
			nvl(ledger_amt_payment,0) ledger_amt_payment,
			( (ledger_amt_sales - nvl(ledger_amt_discount,0)) - nvl(ledger_amt_payment,0)) due,
			au_update_at,
			au_entry_at
			FROM finc_voucherwise_vw_ipd $sql_cond and module_no_fk <>3 order by admission_no_pk DESC ");

        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.ipd.financial.ipd_financial_table", ['report_data' => $report_data]);
    }

    public function ipdReportFinancialPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($referral_id != "") ? " $clause person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT  TO_CHAR(invoice_date, 'DD-MM-YYYY') invc_date,
			patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name,doctor_name, ledger_amt_sales,
			ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, au_update_at, au_entry_at FROM finc_voucherwise_vw_ipd $sql_cond and module_no_fk <>3 order by admission_no_pk ASC ");



        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.ipd.financial.ipd_financial_print_pdf", [
            'report_data' => $report_data,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Ipd-Financial-Invoice.pdf');
    }

    public function ipdFinancialSummaryReport()
    {
        return Template::loadView("admin.reports.ipd.financial_summary.ipd_financial_summary");
    }

    public function ipdFinancialSummaryReportData(Request $request)
    {

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));
        //dd()

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT TO_CHAR(invoice_date, 'DD-MM-YYYY') invo_date, total_invoice_cnt,referral, total_consult_cnt, ledgerdtl_amt_discount_others, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others, ledgerdtl_amt_payment_consul, ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul,service_referral,no_of_service, ledgerdtl_amt_discount_service,payable,discount,net_payable,paid,
			(net_payable - paid ) due, rownum rownumber, au_entry_at
			FROM finc_summarystatement_dt_vw_ipd $sql_cond order by invoice_date DESC");
        // return $report_data;


        return Template::loadView("admin.reports.ipd.financial_summary.ipd_financial_summary_table", ['report_data' => $report_data]);
    }

    public function ipdReportFinancialSummaryPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));
        ////dd()

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT TO_CHAR(invoice_date, 'DD-MM-YYYY') invo_date, total_invoice_cnt,referral, total_consult_cnt, ledgerdtl_amt_discount_others, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others, ledgerdtl_amt_payment_consul, ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul,service_referral,no_of_service, ledgerdtl_amt_discount_service,payable,discount,net_payable,paid,
			(net_payable - paid ) due, rownum rownumber, au_entry_at
			FROM finc_summarystatement_dt_vw_ipd $sql_cond order by invoice_date DESC");

        // DB::select("SELECT TO_CHAR(invoice_date, 'DD-MM-YYYY') invo_date, total_invoice_cnt,referral, total_consult_cnt, ledgerdtl_amt_discount_others, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others, ledgerdtl_amt_payment_consul, ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul,service_referral,no_of_service, ledgerdtl_amt_discount_service, (ledgerdtl_amt_sales_service + ledgerdtl_amt_sales_others) payable,discount,net_payable, (ledgerdtl_amt_payment_consul + ledgerdtl_amt_payment_service + ledgerdtl_amt_payment_others) paid, ((ledgerdtl_amt_sales_service + ledgerdtl_amt_sales_others) - (ledgerdtl_amt_discount_consul + ledgerdtl_amt_discount_service)) - (  ledgerdtl_amt_payment_consul + ledgerdtl_amt_payment_service + ledgerdtl_amt_payment_others) due
        //        FROM finc_summarystatement_dt_vw $sql_cond");

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

        $pdf = PDF::loadView("admin.reports.ipd.financial_summary.ipd_financial_summary_report", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no]);

        return $pdf->download('ipd-Financial-Summary-Invoice.pdf');
    }

    public function ipdDailySalesReport()
    {
        $type = 'Sales';

        return Template::loadView("admin.reports.ipd.daily_report.ipd_daily_sales", ['type' => $type]);
    }

    public function ipdDailyCollectionReport()
    {
        $type = 'Collection';
        return Template::loadView("admin.reports.ipd.daily_report.ipd_daily_collection", ['type' => $type]);
    }

    public function ipdDailyDiscountReport()
    {
        $type = 'Discount';
        return Template::loadView("admin.reports.ipd.daily_report.ipd_daily_discount", ['type' => $type]);
    }

    public function ipdDailyReportData(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        //    $date_from = date('Y/m/d', strtotime($request->date_from));
        //    $date_to = date('Y/m/d', strtotime($request->date_to));

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        //    $clause = ($sql_cond == "") ? " where" : " and";
        //    $sql_cond .= ($referral_id != "") ? " $clause doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $report_data = DB::select("SELECT invoice_no_fk,
			invoice_code,
			TO_CHAR (invoice_date, 'DD-MM-YYYY') invc_date,
			patient_no_fk,
			patient_code,
			patient_name,
			age,
			gender,
			mobile,

			ledgerdtl_amt_sales_consul,
			ledgerdtl_amt_sales_service,
			ledgerdtl_amt_sales_others,
			ledgerdtl_amt_sales_path,
			ledgerdtl_amt_sales_rad,
			ledgerdtl_amt_sales_hos,
			ledgerdtl_amt_sales_amb,

			ledgerdtl_amt_payment_amb,
			ledgerdtl_amt_payment_consul,
			ledgerdtl_amt_payment_hos,
			ledgerdtl_amt_payment_others,
			ledgerdtl_amt_payment_path,
			ledgerdtl_amt_payment_rad,
			ledgerdtl_amt_payment_service,

			ledgerdtl_amt_discount_amb,
			ledgerdtl_amt_discount_consul,
			ledgerdtl_amt_discount_hos,
			ledgerdtl_amt_discount_others,
			ledgerdtl_amt_discount_path,
			ledgerdtl_amt_discount_rad,
			ledgerdtl_amt_discount_service


			FROM finc_financialstatement_dtl_vw_ipd $sql_cond and module_no_fk <>3 order by invoice_code DESC");
        return Template::loadView("admin.reports.ipd.daily_report.ipd_daily_report_table", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details,  'type' => $type]);
    }

    public function ipdReportDailyPrint(Request $request)
    {
        // ini_set('max_execution_time', 0);
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $referral_id = $request->hdn_first_referral_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        //    $clause = ($sql_cond == "") ? " where" : " and";
        //    $sql_cond .= ($referral_id != "") ? " $clause doctor_person_no_fk=$referral_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $report_data = DB::select("SELECT invoice_no_fk,
			invoice_code,
			TO_CHAR (invoice_date, 'DD-MM-YYYY') invc_date,
			patient_no_fk,
			patient_code,
			patient_name,
			age,
			gender,
			mobile,

			ledgerdtl_amt_sales_consul,
			ledgerdtl_amt_sales_service,
			ledgerdtl_amt_sales_others,
			ledgerdtl_amt_sales_path,
			ledgerdtl_amt_sales_rad,
			ledgerdtl_amt_sales_hos,
			ledgerdtl_amt_sales_amb,

			ledgerdtl_amt_payment_amb,
			ledgerdtl_amt_payment_consul,
			ledgerdtl_amt_payment_hos,
			ledgerdtl_amt_payment_others,
			ledgerdtl_amt_payment_path,
			ledgerdtl_amt_payment_rad,
			ledgerdtl_amt_payment_service,

			ledgerdtl_amt_discount_amb,
			ledgerdtl_amt_discount_consul,
			ledgerdtl_amt_discount_hos,
			ledgerdtl_amt_discount_others,
			ledgerdtl_amt_discount_path,
			ledgerdtl_amt_discount_rad,
			ledgerdtl_amt_discount_service


			FROM finc_financialstatement_dtl_vw_ipd $sql_cond and module_no_fk <>3 order by invoice_code ASC");

        //    $type = $request->type;
        // return $type;

        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_no_fk, patient_code, patient_name, age, gender, mobile, ledgerdtl_amt_sales_consul, ledgerdtl_amt_sales_service, ledgerdtl_amt_sales_others,ledgerdtl_amt_payment_consul,ledgerdtl_amt_payment_service, ledgerdtl_amt_payment_others, ledgerdtl_amt_discount_consul, ledgerdtl_amt_discount_service, ledgerdtl_amt_discount_others FROM finc_financialstatement_dtl_vw");

        return view("admin.reports.ipd.daily_report.ipd_daily_sales_print", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);


        // $pdf = PDF::loadView("admin.reports.ipd.daily_report.ipd_daily_sales_print", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
        // return $pdf->download('Ipd-Daily-Invoice.pdf');
    }

    public function ipdCardPaymentReport()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.ipd.card_payment_details.ipd_card_payment_report", [
            'bank_name' => $bank_name
        ]);
    }

    public function ipdCardPaymentReportSearch(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select * from finc_ledger_paymod_srvchrg_vw_ipd $sql_cond order by invoice_code DESC ");

        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.ipd.card_payment_details.ipd_card_payment_report_table", ['report_data' => $report_data]);
    }

    public function ipdCardPaymentReportPrint(Request $request)
    {
        // return $report_data;
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $bank_id = $request->bank_id;
        $from = $request->date_from;
        $to = $request->date_to;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        //        $date_from = date('Y/m/d', strtotime($request->date_from));
        //        $date_to = date('Y/m/d', strtotime($request->date_to));

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_no_fk=$patient_id" : "";
        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_fk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($bank_id != "") ? " $clause bank_name ='$bank_id'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $report_data = DB::select("select * from finc_ledger_paymod_srvchrg_vw_ipd $sql_cond order by invoice_code ASC  ");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //     foreach ($report_data as $row) {
        $title = '124526';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        //        }

        $pdf = PDF::loadView("admin.reports.ipd.card_payment_details.ipd_card_payment_details_print", [
            'report_data' => $report_data,
            'po_hospital_details' => $po_hospital_details,
            'barcode_no' => $barcode_no,
            'from_date' => $from,
            'to_date' => $to
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Ipd-Card-Payment-Invoice.pdf');
    }
    public function getIndividualDoctorPerformanceDetails()
    {
        $card_no = '';
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.individual_doctor_performance_details_report", ['card_no' => $card_no]);
    }
    public function getIndividualDoctorPerformanceDetailsSearch(Request $request)
    {
        // $card_no = $request->doctor_hidn;
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('finc_doc_appoint_sum_vw')->select('ledger_amt_sales', 'ledger_amt_payment', 'ledger_amt_discount', 'appoint_service_no_fk', 'patient_name', 'doctor_name', 'invoice_date', 'patient_code', 'age', 'dob', 'gender_txt');
        $referral_detail_data = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $referral_detail_data = $selectQuery->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        } elseif ($from_date != "") {
            $referral_detail_data = $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }
        if ($card_no != null) {
            $referral_detail_data = $selectQuery->where('person_no_fk', $card_no)->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }


        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.individual_doctor_performance_details_report_list", ['referral_detail_data' => $referral_detail_data, 'card_no' => $card_no]);
    }
    public function getIndividualDoctorPerformanceDetailsPdf(Request $request)
    {
        $card_no = $request->card_hidn;
        $service_unit_name = '';

        if ($request->service_unit != "") {

            $su_exp = explode('_', $request->service_unit);

            $service_unit_no = $su_exp[0];

            $service_unit_name = $su_exp[1];
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ref_info = DB::table('employee_info_vw')->where('person_no_pk', $card_no)->first();

        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $referral_detail_data = [];
        $selectQuery = DB::table('finc_doc_appoint_sum_vw')->select('ledger_amt_sales', 'ledger_amt_payment', 'ledger_amt_discount', 'appoint_service_no_fk', 'patient_name', 'doctor_name', 'invoice_date', 'patient_code', 'age', 'dob', 'gender_txt');

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $referral_detail_data = $selectQuery->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        } elseif ($from_date != "") {
            $referral_detail_data = $selectQuery->where(DB::raw("trunc(INVOICE_DATE)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }
        if ($card_no != null) {
            $referral_detail_data = $selectQuery->where('person_no_fk', $card_no)->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
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
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.individual_doctor_performance_details_report_pdf", ['barcode_no' => $barcode_no, 'referral_detail_data' => $referral_detail_data,  'from_date' => $from_date, 'to_date' => $to_date, 'card_no' => $card_no, 'ref_info' => $ref_info, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('individual_doctor_performance_details_report_pdf.pdf');
    }

    public function doctorWiseIncomeSummery()
    {
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            // ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery", ['card_no' => $card_no, 'serviceDepts' => $serviceDepts]);
    }
    public function doctorWiseIncomeSummerySearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";



        if (Session::get('user.ses_hospital_code') == "EWMCH") {
            $report_data = db::select("select su_name,
                    person_no_pk,
                    full_name,
                    sum (total_appointment) total_appointment,
                    sum (patient_free) patient_free,
                    sum (patient_followup_free) patient_followup_free,
                    sum (patient_new_paid) patient_new_paid,
                    sum (total_patient_paid) total_patient_paid,
                    sum (sur_amt) sur_amt,
                    sum (lab_amt) lab_amt,
                    sum (rad_amt) rad_amt,
                    sum (ipd_service_amt) ipd_service_amt,
                    sum (all_other_amt) all_other_amt,
                    sum (sur_amt_count) sur_amt_count,
                    sum (ipd_service_amt_count) ipd_service_amt_count,
                    sum (total_admission_no) total_admission_no,
                    sum (pathology_amt_count) pathology_amt_count,
                    sum (radiology_amt_count) radiology_amt_count,
                    sum (others_discount_amt) others_discount_amt,
                    sum (rad_discount_amt) rad_discount_amt,
                    sum (lab_discount_amt) lab_discount_amt,
                    sum (ipd_discount_amt) ipd_discount_amt,
                    sum (sur_discount_amt) sur_discount_amt,
                    sum (procedure_amout_discount) procedure_amout_discount,
                    sum (procedure_amount) procedure_amount,
                    sum (prcedure_amout_count) prcedure_amout_count,
                    sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count,
                    sum (ipd_docvisit_amt) ipd_docvisit_amt,
                    SUM (IPD_DOCVISIT_AMT) IPD_DOCVISIT_AMT,
                    SUM (IPD_DOCVISIT_discount) IPD_DOCVISIT_discount
                    from FINC_DOCTOR_INCOME_REFPAY_VW_EWMCH
                    $sql_cond
                    group by person_no_pk, full_name, su_name
                    order by full_name asc");
        } else {
            $report_data = db::select("select su_name,
                        person_no_pk,
                        full_name,
                        sum (total_appointment) total_appointment,
                        sum (patient_free) patient_free,
                        sum (patient_followup_free) patient_followup_free,
                        sum (patient_new_paid) patient_new_paid,
                        sum (total_patient_paid) total_patient_paid,
                        sum (sur_amt) sur_amt,
                        sum (lab_amt) lab_amt,
                        sum (rad_amt) rad_amt,
                        sum (ipd_service_amt) ipd_service_amt,
                        sum (all_other_amt) all_other_amt,
                        sum (sur_amt_count) sur_amt_count,
                        sum (ipd_service_amt_count) ipd_service_amt_count,
                        sum (total_admission_no) total_admission_no,
                        sum (pathology_amt_count) pathology_amt_count,
                        sum (radiology_amt_count) radiology_amt_count,
                        sum (others_discount_amt) others_discount_amt,
                        sum (rad_discount_amt) rad_discount_amt,
                        sum (lab_discount_amt) lab_discount_amt,
                        sum (ipd_discount_amt) ipd_discount_amt,
                        sum (sur_discount_amt) sur_discount_amt,
                        sum (procedure_amout_discount) procedure_amout_discount,
                        sum (procedure_amount) procedure_amount,
                        sum (ipd_docvisit_amt) ipd_docvisit_amt,
                        sum (prcedure_amout_count) prcedure_amout_count,
                        sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count
                        from finc_doctor_income_refpay_vw
                        $sql_cond
                        group by person_no_pk, full_name, su_name
                        order by full_name asc");
        }


        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_list", ['doctor_income' => $report_data, 'card_no' => $card_no, 'from_date' => $from_date, 'to_date' => $to_date]);
    }



    public function doctorReferalWiseIncomeSummery()
    {
        $card_no = '';
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_referal_wish_income_summery", ['card_no' => $card_no]);
    }
    public function doctorReferalWiseIncomeSummerySearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery = DB::table('finc_doctor_income_dt_vw')->select('income_date', 'person_no_pk', 'full_name', 'total_appointment', 'patient_free', 'patient_followup_free', 'patient_new_paid', 'total_patient_paid', 'sur_amt', 'lab_amt', 'rad_amt', 'ipd_service_amt', 'all_other_amt', 'sur_amt_count', 'ipd_service_amt_count', 'total_admission_no', 'pathology_amt_count', 'radiology_amt_count');
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(income_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(income_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(income_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->where('person_no_pk', $card_no);
        }
        // dd($selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get());

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_list", ['doctor_income' => $selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no]);
    }


    public function doctorReferalWiseIncomeSummeryPdf(Request $request, $id = '')
    {

        $percentage = $request->percentage;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery = DB::table('finc_doctor_income_dt_vw')->select('income_date', 'person_no_pk', 'full_name', 'total_appointment', 'patient_free', 'patient_followup_free', 'patient_new_paid', 'total_patient_paid', 'sur_amt', 'lab_amt', 'rad_amt', 'ipd_service_amt', 'all_other_amt', 'sur_amt_count', 'ipd_service_amt_count', 'total_admission_no', 'pathology_amt_count', 'radiology_amt_count');
        // dd($selectQuery->skip(1300)->get());

        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(income_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(income_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(income_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->where('person_no_pk', $card_no);
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
            $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_pdf", ['percentage' => $percentage, 'doctor_income' => $selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {
            $pdf = ['percentage' => $percentage, 'doctor_income' => $selectQuery->orderBy('income_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id];

            $fileToExport = "doctor_wish_income_summery_excel";
            $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }




    public function doctorWiseIncomeSummeryPdf(Request $request, $id = '')
    {
        ini_set("max_execution_time", 0);
        $percentage = $request->percentage;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';
        $dept = $request->request_department;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";



        if (Session::get('user.ses_hospital_code') == "EWMCH") {
            $report_data = db::select("select su_name,
                                person_no_pk,
                                full_name,
                                sum (total_appointment) total_appointment,
                                sum (patient_free) patient_free,
                                sum (patient_followup_free) patient_followup_free,
                                sum (patient_new_paid) patient_new_paid,
                                sum (total_patient_paid) total_patient_paid,
                                sum (sur_amt) sur_amt,
                                sum (lab_amt) lab_amt,
                                sum (rad_amt) rad_amt,
                                sum (ipd_service_amt) ipd_service_amt,
                                sum (all_other_amt) all_other_amt,
                                sum (sur_amt_count) sur_amt_count,
                                sum (ipd_service_amt_count) ipd_service_amt_count,
                                sum (total_admission_no) total_admission_no,
                                sum (pathology_amt_count) pathology_amt_count,
                                sum (radiology_amt_count) radiology_amt_count,
                                sum (others_discount_amt) others_discount_amt,
                                sum (rad_discount_amt) rad_discount_amt,
                                sum (lab_discount_amt) lab_discount_amt,
                                sum (ipd_discount_amt) ipd_discount_amt,
                                sum (sur_discount_amt) sur_discount_amt,
                                sum (procedure_amout_discount) procedure_amout_discount,
                                sum (procedure_amount) procedure_amount,
                                sum (prcedure_amout_count) prcedure_amout_count,
                                sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count,
                                SUM (IPD_DOCVISIT_AMT) IPD_DOCVISIT_AMT,
                                SUM (IPD_DOCVISIT_discount) IPD_DOCVISIT_discount
                                from FINC_DOCTOR_INCOME_REFPAY_VW_EWMCH
                        $sql_cond
                        group by person_no_pk, full_name, su_name
                        order by full_name asc");
        } else {
            $report_data = db::select("select su_name,
                            person_no_pk,
                            full_name,
                            sum (total_appointment) total_appointment,
                            sum (patient_free) patient_free,
                            sum (patient_followup_free) patient_followup_free,
                            sum (patient_new_paid) patient_new_paid,
                            sum (total_patient_paid) total_patient_paid,
                            sum (sur_amt) sur_amt,
                            sum (lab_amt) lab_amt,
                            sum (rad_amt) rad_amt,
                            sum (ipd_service_amt) ipd_service_amt,
                            sum (all_other_amt) all_other_amt,
                            sum (sur_amt_count) sur_amt_count,
                            sum (ipd_service_amt_count) ipd_service_amt_count,
                            sum (total_admission_no) total_admission_no,
                            sum (pathology_amt_count) pathology_amt_count,
                            sum (radiology_amt_count) radiology_amt_count,
                            sum (others_discount_amt) others_discount_amt,
                            sum (rad_discount_amt) rad_discount_amt,
                            sum (lab_discount_amt) lab_discount_amt,
                            sum (ipd_discount_amt) ipd_discount_amt,
                            sum (sur_discount_amt) sur_discount_amt,
                            sum (procedure_amout_discount) procedure_amout_discount,
                            sum (procedure_amount) procedure_amount,
                            sum (ipd_docvisit_amt) ipd_docvisit_amt,
                            sum (prcedure_amout_count) prcedure_amout_count,
                            sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count
                            from finc_doctor_income_refpay_vw
                            $sql_cond
                            group by person_no_pk, full_name, su_name
                            order by full_name asc");
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
            $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_pdf", ['percentage' => $percentage, 'doctor_income' => $report_data, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {
            $pdf = ['percentage' => $percentage, 'doctor_income' => $report_data, 'card_no' => $card_no, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'print_type' => $id];
            $fileToExport = "doctor_wish_income_summery_excel";
            $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function getSupplierWisePo()
    {
        $card_no = "";
        return Template::loadview("admin.supplier_wise_po.supplier_wise_po_report", ['card_no' => $card_no]);
    }

    public function getSupplierWisePoSearch(Request $request)
    {

        $supplier_no_fk = $request->hdn_supplier_id;
        $po = $request->p_o;
        //dd($supplier_no_fk);
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('inv_purchaseorder_vw')->select('purchase_uid', 'supplier_uid', 'purchase_date', 'supplier_name', 'no_of_item', 'po_amount', 'po_status');
        $supplierwisePo = [];
        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $supplierwisePo = $selectQuery->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        } elseif ($from_date != "") {
            $supplierwisePo = $selectQuery->where(DB::raw("trunc(purchase_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }
        if ($supplier_no_fk != null) {
            $supplierwisePo = $selectQuery
                ->where('supplier_no_fk', $supplier_no_fk)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
        }
        if ($po != null) {
            $supplierwisePo = $selectQuery
                ->where(function ($query) use ($po) {
                    $query->where('purchaseorder_no_pk', $po);
                })->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }
        return Template::loadview("admin.supplier_wise_po.supplier_wise_po_report_list", ['supplierwisePo' => $supplierwisePo]);
    }
    public function getSupplierWisePoPdf(Request $request)
    {
        $supplier_no_fk = $request->hdn_supplier_id;
        //dd($supplier_no_fk);
        $po = $request->p_o;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('inv_purchaseorder_vw')->select('purchase_uid', 'supplier_uid', 'purchase_date', 'supplier_name', 'no_of_item', 'po_amount', 'po_status');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $supplierwisePo = [];
        $supplier_name = '';
        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $supplierwisePo = $selectQuery->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        } elseif ($from_date != "") {
            $supplierwisePo = $selectQuery->where(DB::raw("trunc(purchase_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }
        if ($supplier_no_fk != null) {
            $supplierwisePo = $selectQuery
                ->where('supplier_no_fk', $supplier_no_fk)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
            $supplier_name = $supplierwisePo[0]->supplier_name;
        }
        if ($po != null) {
            $supplierwisePo = $selectQuery
                ->where(function ($query) use ($po) {
                    $query->where('purchaseorder_no_pk', $po);
                })->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }

        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.supplier_wise_po.supplier_wise_po_report_pdf", ['barcode_no' => $barcode_no, 'supplierwisePo' => $supplierwisePo,  'from_date' => $from_date, 'to_date' => $to_date, 'supplier_name' => $supplier_name, 'po' => $po, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('supplier_wise_po.supplier_wise_po_report_pdf.pdf');
    }
    public function getSupplierWisePoItemDetails()
    {
        $code = "";
        return Template::loadview("admin.supplier_wise_po.supplier_wise_po_item_details_report", ['code' => $code]);
    }
    public function getSupplierWisePoItemDetailsReportSearch(Request $request)
    {
        $supplier_no_fk = $request->hdn_supplier_id;
        $po = $request->p_o;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('inv_purchaseorder_item_vw')->select('purchase_uid', 'purchase_date', 'supplier_name', 'item_code', 'item_name', 'item_rate', 'approved_qty', 'po_status');
        $supplierwisePoItemDetails = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $supplierwisePoItemDetails = $selectQuery->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        } elseif ($from_date != "") {
            $supplierwisePoItemDetails = $selectQuery->where(DB::raw("trunc(purchase_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }
        if ($supplier_no_fk != null) {
            $supplierwisePoItemDetails = $selectQuery
                ->where('supplier_no_fk', $supplier_no_fk)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
            $supplier_name = $selectQuery->where('supplier_no_fk', $supplier_no_fk)->first()->supplier_name;
        }
        if ($po != null) {
            $supplierwisePoItemDetails = $selectQuery
                ->where('purchaseorder_no_pk', $po)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
        }
        return Template::loadview("admin.supplier_wise_po.supplier_wise_po_item_details_report_list", ['supplierwisePoItemDetails' => $supplierwisePoItemDetails]);
    }
    public function getSupplierWisePoItemDetailsReportPdf(Request $request)
    {
        $supplier_no_fk = $request->hdn_supplier_id;
        $po = $request->p_o;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $selectQuery = DB::table('inv_purchaseorder_item_vw')->select('purchase_uid', 'purchase_date', 'supplier_name', 'item_code', 'item_name', 'item_rate', 'approved_qty', 'po_status');
        $supplierwisePoItemDetails = [];
        $supplier_name = '';

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(purchase_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $supplierwisePoItemDetails = $selectQuery->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        } elseif ($from_date != "") {
            $supplierwisePoItemDetails = $selectQuery->where(DB::raw("trunc(purchase_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')->get();
        }
        if ($supplier_no_fk != null) {
            $supplierwisePoItemDetails = $selectQuery
                ->where('supplier_no_fk', $supplier_no_fk)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
            $supplier_name = $selectQuery->where('supplier_no_fk', $supplier_no_fk)->first()->supplier_name;
        }
        if ($po != null) {
            $supplierwisePoItemDetails = $selectQuery
                ->where('purchaseorder_no_pk', $po)
                ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
                ->get();
        }

        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.supplier_wise_po.supplier_wise_po_item_details_report_pdf", ['barcode_no' => $barcode_no, 'supplierwisePoItemDetails' => $supplierwisePoItemDetails,  'from_date' => $from_date, 'to_date' => $to_date, 'supplier_name' => $supplier_name, 'po' => $po, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('supplier_wise_po_item_details_report_pdf.pdf');
    }

    public function getSupplierLedger()
    {
        return Template::loadview("admin.supplier-ledger.supplier_ledger_report");
    }
    public function getSupplierId($id)
    {
        $supplierwisePo = DB::table('inv_purchaseorder_vw')
            ->select('purchaseorder_no_pk', 'purchase_uid', 'supplier_uid', 'purchase_date', 'no_of_item', 'po_amount', 'po_status', 'po_discount', 'delivery_date', 'po_paid_amount', 'po_last_paid_date')
            ->where('supplier_no_fk', $id)
            ->orderBy('purchase_uid', 'ASC', 'purchase_date', 'ASC')
            ->get();
        return Template::loadview("admin.supplier-ledger.supplier_wise_po_report_list", ['supplierwisePo' => $supplierwisePo]);
    }
    public function getPONo($no)
    {
        $payment = DB::table('inv_supplierpayment_po_vw')->select('supledger_no_uid', 'payment_date', 'payment_amount')
            ->where('purchaseorder_no_fk', $no)
            ->orderBy('payment_date', 'ASC')
            ->get();
        return Template::loadview("admin.supplier-ledger.supplier_wise_po_wise_payment", ['payment' => $payment]);
    }
    public function getSupplierLedgerSearch(Request $request)
    {
        $supplier_no_fk = $request->hdn_supplier_id;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $supplier_ledger = DB::table('inv_supplierledger_vw')->select('supplier_no_fk', 'supplier_uid', 'supplier_name', 'no_of_po', 'no_of_item', 'total_po_amount', 'total_po_discount', 'regular_payment_amount', 'advance_payment_amount', 'total_deduct');
        $ledger = [];
        if ($supplier_no_fk != null) {
            $ledger = $supplier_ledger->where('supplier_no_fk', $supplier_no_fk)->get();
        }
        return Template::loadview("admin.supplier-ledger.supplier_ledger_report_list", ['ledger' => $ledger]);
    }
    public function getSupplierLedgerReportPdf(Request $request)
    {
        $supplier_no_fk = $request->hdn_supplier_id;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $supplier_ledger = DB::table('inv_supplierledger_vw')->select('supplier_uid', 'supplier_name', 'no_of_po', 'no_of_item', 'total_po_amount', 'total_po_discount', 'regular_payment_amount', 'advance_payment_amount', 'total_deduct');
        $ledger = [];
        if ($supplier_no_fk != null) {
            $ledger = $supplier_ledger->where('supplier_no_fk', $supplier_no_fk)->get();
            $supplier_name = $supplier_ledger->where('supplier_no_fk', $supplier_no_fk)->first()->supplier_name;
        }
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.supplier-ledger.supplier_ledger_report_pdf", ['barcode_no' => $barcode_no, 'ledger' => $ledger,  'from_date' => $from_date, 'to_date' => $to_date, 'supplier_name' => $supplier_name, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('supplier_ledger_report_pdf.pdf');
    }
    public function getNurseStationReport()
    {
        return Template::loadview("admin.appointment.nurse_station_report");
    }
    public function getNurseStationReportSearch(Request $request)
    {

        $code = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('opd_nurse_station_wl_vw')->select('vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name', 'user_fullname');
        $nurseInfo = [];
        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(vital_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(vital_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $nurseInfo = $selectQuery->groupBy('user_fullname', 'vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name')->orderBy('vital_date', 'ASC')->get();
        } elseif ($from_date != "") {
            $nurseInfo = $selectQuery->where(DB::raw("trunc(vital_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->groupBy('user_fullname', 'vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name')->orderBy('vital_date', 'ASC')->get();
        }
        if ($code != null) {
            $nurseInfo = $selectQuery->where('au_entry_by', $code)->groupBy('user_fullname', 'vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name')->orderBy('vital_date', 'ASC')->get();
        }

        $nurse_arr = [];
        if (!empty($nurseInfo)) {
            foreach ($nurseInfo as  $value) {
                $nurse_arr[$value->user_fullname][] = $value;
            }
        }

        // dd($nurse_arr);


        return Template::loadview("admin.appointment.nurse_station_report_list", ['code' => $code, 'nurse_arr' => $nurse_arr]);
    }
    public function getNurseStationReportPdf(Request $request)
    {
        $code = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $nurseInfo = DB::table('opd_nurse_station_wl_vw')->select('vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name', 'user_fullname');

        if ($from_date != "" && $to_date != "") {
            $nurseInfo->where(DB::raw("trunc(vital_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $nurseInfo->where(DB::raw("trunc(vital_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $nurseInfo->where(DB::raw("trunc(vital_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($code != null) {
            $nurseInfo->where('au_entry_by', $code);
        }

        $nurseInfo->groupBy('user_fullname', 'vital_date', 'patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code', 'serviceunit_name', 'slot_sl', 'appoint_date', 'full_name')->orderBy('vital_date', 'ASC');
        $nurse_arr = [];
        foreach ($nurseInfo->get() as  $value) {
            $nurse_arr[$value->user_fullname][] = $value;
        }
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.appointment.nurse_station_report_pdf", ['barcode_no' => $barcode_no, 'code' => $code, 'nurse_arr' => $nurse_arr,  'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('nurse_station_report_pdf.pdf');
    }
    public function getDeliveryServiceReport()
    {
        return Template::loadview("admin.settings.delivery.delivery_service_report");
    }
    public function getDeliveryServiceReportSearch(Request $request)
    {

        $code = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('ecom_order_list_vw')->select('order_no', 'assign_name', 'tot_amount', 'order_date', 'delivered_date', 'quantity');
        $deliveryInfo = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(delivered_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(delivered_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $deliveryInfo = $selectQuery->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        } elseif ($from_date != "") {
            $deliveryInfo = $selectQuery->where(DB::raw("trunc(delivered_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        }
        if ($code != null) {
            $deliveryInfo = $selectQuery->where('delivery_men_no_fk', $code)->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        }

        $delivery_arr = [];
        if (!empty($deliveryInfo)) {
            foreach ($deliveryInfo as  $value) {
                $delivery_arr[$value->assign_name][] = $value;
            }
        }
        return Template::loadview("admin.settings.delivery.delivery_service_report_list", ['code' => $code, 'delivery_arr' => $delivery_arr]);
    }
    public function getDeliveryServiceReportPdf(Request $request)
    {

        $code = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $selectQuery = DB::table('ecom_order_list_vw')->select('order_no', 'assign_name', 'tot_amount', 'order_date', 'delivered_date', 'quantity');
        $deliveryInfo = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(delivered_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(delivered_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $deliveryInfo = $selectQuery->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        } elseif ($from_date != "") {
            $deliveryInfo = $selectQuery->where(DB::raw("trunc(delivered_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        }
        if ($code != null) {
            $deliveryInfo = $selectQuery->where('delivery_men_no_fk', $code)->groupBy('assign_name', 'order_no', 'tot_amount', 'order_date', 'delivered_date', 'quantity')->orderBy('delivered_date', 'DESC')->get();
        }

        $delivery_arr = [];
        if (!empty($deliveryInfo)) {
            foreach ($deliveryInfo as  $value) {
                $delivery_arr[$value->assign_name][] = $value;
            }
        }
        $title = "Bank wise monthly salary sheet";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.settings.delivery.delivery_service_report_pdf", ['barcode_no' => $barcode_no, 'code' => $code, 'delivery_arr' => $delivery_arr,  'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('delivery_service_report_pdf.pdf');
    }







    // Dept wise Doctor Report

    public function deptWisePerformanceReport()
    {
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.individual_dept_wise_report", ['serviceDepts' => $serviceDepts]);
    }
    public function deptWisePerformanceDetailsSearch(Request $request)
    {

        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectquery = db::table('finc_doc_appoint_sum_dt_su_vw')->select('appoint_date', 'patient_followup_free', 'patient_free', 'patient_new_paid', 'serviceunit_name', 'serviceunit_no_pk', 'ledger_amt_payment', 'total_appointment');
        $dept_detail_data = [];

        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $dept_detail_data = $selectquery->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        } elseif ($from_date != "") {
            $dept_detail_data = $selectquery->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }
        if ($service_unit != null) {
            $dept_detail_data = $selectquery->where('serviceunit_no_pk', $service_unit)->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        }


        $date_data = [];
        if (!empty($dept_detail_data)) {
            foreach ($dept_detail_data as $detail_data) {
                $date = date("d/m/Y", strtotime($detail_data->appoint_date));
                $date_data[$date][] = $detail_data;
            }
        }

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.deptServiceunitWiseDeptData", ['date_data' => $date_data, 'dept_detail_data' => $dept_detail_data]);
    }
    public function deptWisePerformanceDetailsPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectquery = db::table('finc_doc_appoint_sum_dt_su_vw')->select('appoint_date', 'patient_followup_free', 'patient_free', 'patient_new_paid', 'serviceunit_name', 'serviceunit_no_pk', 'ledger_amt_payment', 'total_appointment');
        $dept_detail_data = [];

        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $dept_detail_data = $selectquery->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        } elseif ($from_date != "") {
            $dept_detail_data = $selectquery->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }
        if ($service_unit != null) {
            $dept_detail_data = $selectquery->where('serviceunit_no_pk', $service_unit)->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        }


        $date_data = [];
        if (!empty($dept_detail_data)) {
            foreach ($dept_detail_data as $detail_data) {
                $date = date("d/m/Y", strtotime($detail_data->appoint_date));
                $date_data[$date][] = $detail_data;
            }
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
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_report_pdf", ['barcode_no' => $barcode_no, 'date_data' => $date_data, 'dept_detail_data' => $dept_detail_data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->download('Department_Wise_Performance_Report.pdf');
    }

    public function deptWisePerformanceDetailsExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectquery = db::table('finc_doc_appoint_sum_dt_su_vw')->select('appoint_date', 'patient_followup_free', 'patient_free', 'patient_new_paid', 'serviceunit_name', 'serviceunit_no_pk', 'ledger_amt_payment', 'total_appointment');
        $dept_detail_data = [];

        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $dept_detail_data = $selectquery->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        } elseif ($from_date != "") {
            $dept_detail_data = $selectquery->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->orderBy('invoice_date', 'ASC', 'doctor_name', 'ASC')->get();
        }
        if ($service_unit != null) {
            $dept_detail_data = $selectquery->where('serviceunit_no_pk', $service_unit)->orderBy('appoint_date', 'ASC', 'doctor_name', 'ASC')->get();
        }


        $date_data = [];
        if (!empty($dept_detail_data)) {
            foreach ($dept_detail_data as $detail_data) {
                $date = date("d/m/Y", strtotime($detail_data->appoint_date));
                $date_data[$date][] = $detail_data;
            }
        }


        $pdf = ['date_data' => $date_data, 'dept_detail_data' => $dept_detail_data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];

        $fileToExport = "department_wise_performance_report";
        $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_report_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }



    # Doctor Wise Schedule Report
    public function doctorWiseScheduleReport()
    {
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wise_schedule_report", ['serviceDepts' => $serviceDepts]);
    }

    public function doctorWiseScheduleReportFilter(Request $request)
    {
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : date("d-m-Y");
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : date("d-m-Y");

        $whereClause = '';
        if ($service_unit != null) {
            $whereClause .= " AND app.su_no_fk = $service_unit ";
        }

        $selectQuery = DB::select("SELECT SU_NAME, FULL_NAME, SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '08:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '16:00' THEN 1 ELSE 0 END) MORNING,
                        SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '16:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '23:59' THEN 1 ELSE 0 END) EVENING, COUNT(*) TOTAL_PATIENT
                        FROM PATN_APPOINTMENT APP
                        JOIN PAT_REGISTRATION_WL_VW PREG ON PREG.PATIENT_NO_PK = APP.PATIENT_NO_FK
                        JOIN SYSC_SERVICEUNIT SU ON SU.SERVICEUNIT_NO_PK = APP.SU_NO_FK
                        JOIN FINC_INVOICEMST INMST ON APP.CONSULT_VOUCHER_NO_PK = INMST.INVOICE_NO_PK --APPOINT_SERVICE_NO_FK
                        LEFT JOIN (SELECT INVOICE_NO_FK, MAX (CANCEL_IND) INVDTL_CANCEL_IND
                                    FROM FINC_INVOICEDTL
                                    GROUP BY INVOICE_NO_FK) DTL
                        ON INMST.INVOICE_NO_PK = DTL.INVOICE_NO_FK
                        LEFT JOIN DOCTOR_INFO_VW DOC ON DOC.PERSON_NO_PK = APP.DOCTOR_NO_FK
                        WHERE NVL(INVDTL_CANCEL_IND,0) = 0 AND NVL (CANCEL_IND, 0) = 0 $whereClause
                        AND TRUNC(APPOINT_DATE) BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
                        GROUP BY SU_NAME, FULL_NAME
                        ORDER BY 1,2");

        $result = [];
        foreach ($selectQuery as $row) {
            if (!isset($result[$row->su_name])) $result[$row->su_name] = [$row];
            else array_push($result[$row->su_name], $row);
        }

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctorWiseScheduleReportTable", ['result' => $result]);
    }

    public function doctorWiseScheduleReportExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : date("d-m-Y");
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : date("d-m-Y");

        $whereClause = '';
        if ($service_unit != null) {
            $whereClause .= " AND su_no_fk = $service_unit ";
        }

        $selectQuery = DB::select("SELECT SU_NAME, FULL_NAME, SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '08:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '16:00' THEN 1 ELSE 0 END) MORNING,
                        SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '16:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '23:59' THEN 1 ELSE 0 END) EVENING, COUNT(*) TOTAL_PATIENT
                        FROM PATN_APPOINTMENT APP
                        JOIN PAT_REGISTRATION_WL_VW PREG ON PREG.PATIENT_NO_PK = APP.PATIENT_NO_FK
                        JOIN SYSC_SERVICEUNIT SU ON SU.SERVICEUNIT_NO_PK = APP.SU_NO_FK
                        JOIN FINC_INVOICEMST INMST ON APP.CONSULT_VOUCHER_NO_PK = INMST.INVOICE_NO_PK --APPOINT_SERVICE_NO_FK
                        LEFT JOIN (SELECT INVOICE_NO_FK, MAX (CANCEL_IND) INVDTL_CANCEL_IND
                                    FROM FINC_INVOICEDTL
                                    GROUP BY INVOICE_NO_FK) DTL
                        ON INMST.INVOICE_NO_PK = DTL.INVOICE_NO_FK
                        LEFT JOIN DOCTOR_INFO_VW DOC ON DOC.PERSON_NO_PK = APP.DOCTOR_NO_FK
                        WHERE NVL(INVDTL_CANCEL_IND,0) = 0 AND NVL (CANCEL_IND, 0) = 0 $whereClause
                        AND TRUNC(APPOINT_DATE) BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
                        GROUP BY SU_NAME, FULL_NAME
                        ORDER BY 1,2");

        $result = [];
        foreach ($selectQuery as $row) {
            if (!isset($result[$row->su_name])) $result[$row->su_name] = [$row];
            else array_push($result[$row->su_name], $row);
        }

        $pdf = ['result' => $result, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];

        $fileToExport = "shift-wise-doctor-performance-report";
        $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor-wise-schedule-report")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function doctorWiseScheduleReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : date("d-m-Y");
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : date("d-m-Y");

        $whereClause = '';
        if ($service_unit != null) {
            $whereClause .= " AND su_no_fk = $service_unit ";
        }

        $selectQuery = DB::select("SELECT SU_NAME, FULL_NAME, SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '08:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '16:00' THEN 1 ELSE 0 END) MORNING,
                        SUM(CASE WHEN TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') > '16:00' AND TO_CHAR(INMST.INVOICE_DATE,'hh24:mi') < '23:59' THEN 1 ELSE 0 END) EVENING, COUNT(*) TOTAL_PATIENT
                        FROM PATN_APPOINTMENT APP
                        JOIN PAT_REGISTRATION_WL_VW PREG ON PREG.PATIENT_NO_PK = APP.PATIENT_NO_FK
                        JOIN SYSC_SERVICEUNIT SU ON SU.SERVICEUNIT_NO_PK = APP.SU_NO_FK
                        JOIN FINC_INVOICEMST INMST ON APP.CONSULT_VOUCHER_NO_PK = INMST.INVOICE_NO_PK --APPOINT_SERVICE_NO_FK
                        LEFT JOIN (SELECT INVOICE_NO_FK, MAX (CANCEL_IND) INVDTL_CANCEL_IND
                                    FROM FINC_INVOICEDTL
                                    GROUP BY INVOICE_NO_FK) DTL
                        ON INMST.INVOICE_NO_PK = DTL.INVOICE_NO_FK
                        LEFT JOIN DOCTOR_INFO_VW DOC ON DOC.PERSON_NO_PK = APP.DOCTOR_NO_FK
                        WHERE NVL(INVDTL_CANCEL_IND,0) = 0 AND NVL (CANCEL_IND, 0) = 0 $whereClause
                        AND TRUNC(APPOINT_DATE) BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
                        GROUP BY SU_NAME, FULL_NAME
                        ORDER BY 1,2");

        $result = [];
        foreach ($selectQuery as $row) {
            if (!isset($result[$row->su_name])) $result[$row->su_name] = [$row];
            else array_push($result[$row->su_name], $row);
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

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.doctor-wise-schedule-report-pdf", ['barcode_no' => $barcode_no, 'result' => $result, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->download('shift-wise-doctor-performance-report.pdf');
    }

    // marketing reports
    public function marketingReport()
    {
        $thana = $this->getLookupListByCode("THANA");
        $marketing_area = $this->getLookupListByCode("MARKETINGAREA");
        return Template::loadview("admin.reports.marketing_reports.marketing_reports", [
            'thana' => $thana,
            'marketing_area' => $marketing_area
        ]);
    }

    // area

    public function marketingAreaReportSearch(Request $request)
    {

        $type = $request->type;
        if ($type != "AREA") {
            $area_no_pk = $request->ref_doc;
        } else {

            $area_no_pk = $request->hdn_area_code;
        }

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        if ($type != "AREA") {
            $sql_cond .= ($area_no_pk != "") ? " $clause first_ref_doc_person_no_fk = '$area_no_pk'" : "";
        } else {
            $sql_cond .= ($area_no_pk != "") ? " $clause patient_area_no_fk = '$area_no_pk'" : "";
        }
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause invoice_date between to_date ('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($type != "AREA") {
            $report_data = db::select(db::raw("select admission_code,
            first_ref_doc_person_no_fk,
            second_ref_doc_person_no_fk,
                   age,
                   first_doc_name,
                   blood_group_txt,
                   invoice_code,
                   invoice_date,
                   patient_area_no_fk,
                   patient_area_name,
                   patient_code,
                   patient_name,
                   sales,
                   collection,
                   discount,
                   net_sales,
                   refund,
                   due,
                   net_collection,
                   doctor_name,
                   gender_txt,
                   patient_area_name,
                   patient_photo,
                   mobile1,
                   invoice_no_pk,
                   ledgertrn_no_pk
              from finc_c022_vrmst_sum_areampo_vw
             $sql_cond and first_ref_doc_person_no_fk is not null"));

            $marketing_list = [];
            foreach ($report_data as $key => $dt) {
                $marketing_list[$dt->first_doc_name][] = $dt;
            }
            return Template::loadView("admin.reports.marketing_reports.marketing_mpo_report_list", ['marketing_list' => $marketing_list]);
        } else {
            $report_data = db::select(db::raw("select admission_code,
                            age,
                            blood_group_txt,
                            invoice_code,
                            invoice_date,
                            patient_area_no_fk,
                            patient_area_name,
                            patient_code,
                            patient_name,
                            sales,
                            collection,
                            discount,
                            net_sales,
                            refund,
                            due,
                            net_collection,
                            doctor_name,
                            gender_txt,
                            patient_area_name,
                            patient_photo,
                            mobile1,
                            invoice_no_pk,
                            ledgertrn_no_pk
                        from finc_c022_vrmst_sum_areampo_vw $sql_cond order by invoice_date DESC"));

            $marketing_list = [];
            foreach ($report_data as $key => $dt) {
                $marketing_list[$dt->patient_area_name][] = $dt;
            }

            return Template::loadView("admin.reports.marketing_reports.marketing_area_report_list", ['marketing_list' => $marketing_list]);
        }
    }

    public function marketingAreaReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $type = $request->type;
        if ($type != "AREA") {
            $area_no_pk = $request->ref_doc;
        } else {

            $area_no_pk = $request->hdn_area_code;
        }

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        if ($type != "AREA") {
            $sql_cond .= ($area_no_pk != "") ? " $clause first_ref_doc_person_no_fk = '$area_no_pk'" : "";
        } else {
            $sql_cond .= ($area_no_pk != "") ? " $clause patient_area_no_fk = '$area_no_pk'" : "";
        }
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause invoice_date between to_date ('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($type != "AREA") {
            $report_data = db::select(db::raw("select admission_code,
            first_ref_doc_person_no_fk,
            second_ref_doc_person_no_fk,
                   age,
                   first_doc_name,
                   blood_group_txt,
                   invoice_code,
                   invoice_date,
                   patient_area_no_fk,
                   patient_area_name,
                   patient_code,
                   patient_name,
                   sales,
                   collection,
                   discount,
                   net_sales,
                   refund,
                   due,
                   net_collection,
                   doctor_name,
                   gender_txt,
                   patient_area_name,
                   patient_photo,
                   mobile1,
                   invoice_no_pk,
                   ledgertrn_no_pk
               from finc_c022_vrmst_sum_areampo_vw
               $sql_cond and first_ref_doc_person_no_fk is not null"));
            $marketing_list = [];
            foreach ($report_data as $key => $dt) {
                $marketing_list[$dt->first_doc_name][] = $dt;
            }

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

            $pdf = PDF::loadView("admin.reports.marketing_reports.marketing_area_pdf", ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no, 'type' => 'MPO']);

            return $pdf->download('MPO_wise_report.pdf');
            //  return view("admin.reports.marketing_reports.marketing_area_pdf", [
            //    , ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no,'type'=> $type]);


        } else {
            $report_data = db::select(db::raw("select admission_code,
                            age,
                            blood_group_txt,
                            invoice_code,
                            invoice_date,
                            patient_area_no_fk,
                            patient_area_name,
                            patient_code,
                            patient_name,
                            sales,
                            collection,
                            discount,
                            net_sales,
                            refund,
                            due,
                            net_collection,
                            doctor_name,
                            gender_txt,
                            patient_area_name,
                            patient_photo,
                            mobile1,
                            invoice_no_pk,
                            ledgertrn_no_pk
                        from finc_c022_vrmst_sum_areampo_vw $sql_cond order by invoice_date DESC"));

            $marketing_list = [];
            foreach ($report_data as $key => $dt) {
                $marketing_list[$dt->patient_area_name][] = $dt;
            }

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

            $pdf = PDF::loadView("admin.reports.marketing_reports.marketing_area_pdf", ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no, 'type' => "Area"]);

            return $pdf->download('Area_wise_report.pdf');
        }
    }

    public function marketingReportDetails($search_dt, $year, $month, $type)
    {
        // dd($area, $year, $month, $type);
        $year_month = $year / $month;
        $area_no_fk = $search_dt;

        if ($type != 'AREA') {
            $mpo_dt = $search_dt;
        } else {
            $area_dt = $search_dt;
        }
    }


    // MPO

    public function marketingMpoReportSearch(Request $request)
    {
        // dd($request->all());
        $ref_doc = $request->ref_doc;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($ref_doc != "") ? " $clause first_ref_doc_person_no_fk = '$ref_doc'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select year_month,
        sum (invoice_count) invoice_count,
        sum (non_referred_cnt) non_referred_cnt,
        sum (referred_cnt) referred_cnt,
        first_ref_doc_person_no_fk,first_refferal_name
        from hrms_marketing_refferal_reports_vw
        $sql_cond and first_ref_doc_person_no_fk is not null and first_refferal_name is not null
        group by year_month, first_ref_doc_person_no_fk, first_refferal_name
        order by year_month desc");
        // dd($report_data);

        return Template::loadView("admin.reports.marketing_reports.marketing_mpo_report_list", ['report_data' => $report_data]);
    }

    public function marketingMpoReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ref_doc = $request->ref_doc;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($ref_doc != "") ? " $clause first_ref_doc_person_no_fk = '$ref_doc'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select year_month,
        sum (invoice_count) invoice_count,
        sum (non_referred_cnt) non_referred_cnt,
        sum (referred_cnt) referred_cnt,
        first_ref_doc_person_no_fk,first_refferal_name
        from hrms_marketing_refferal_reports_vw
        $sql_cond and first_ref_doc_person_no_fk is not null and first_refferal_name is not null
        group by year_month, first_ref_doc_person_no_fk, first_refferal_name
        order by year_month desc");


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

        $pdf = PDF::loadView("admin.reports.marketing_reports.marketing_mpo_report_pdf", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no]);

        return $pdf->download('Financial-Summary-Invoice.pdf');
    }

    /**
     * Pharmacy profit loss report
     *
     * @return void
     */
    public function pharmacy_profit_loss()
    {
        return template::loadview('admin.reports.pharmacy.pharmacy_profit_loss_report');
    }

    public function pharmacy_profit_loss_html(Request $request)
    {
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));

        $profit_loss_qry = DB::select("select invoicedtl_no_pk, to_char(au_entry_at,'DD/MM/YYYY') bill_date,
                    CASE  WHEN cancel_qty>  0
                        then 'Return Bill'
                        else 'Sales'
                    END return_bill,

                    CASE WHEN module_no_fk = 3
                        THEN 'PHARMACY'
                        WHEN module_no_fk = 9
                        THEN 'OPDC'
                        WHEN module_no_fk = 12
                        THEN 'OUTDOOR'
                        WHEN module_no_fk = 22
                        THEN 'PHARMACY IPD'
                        WHEN module_no_fk = 23
                        THEN 'POINT OF SALE'
                        WHEN module_no_fk = 2
                        THEN 'INDDOR'
                        ELSE 'UNDEFINE'
                    END customer_type,

                    customer_name,
                    total_sales_price,
                    total_cancel_price,
                    total_purchase_price,
                    profit
                    --CASE WHEN item_qty > 0
                    --THEN sales_price*item_qty
                    --END sales_amount,

                    --CASE WHEN cancel_qty > 0
                    --THEN sales_price*cancel_qty
                    --END sales_return_amount,

                    --CASE WHEN cancel_qty > 0
                    --THEN purchase_price*cancel_qty
                    --WHEN item_qty > 0
                    --THEN purchase_price*item_qty
                    --END purchase_amount
                    from FINC_VRWISE_PROFIT_CALC_VW
                    WHERE TRUNC(au_entry_at) between TO_DATE('$from_date', 'DD/MM/YYYY') AND TO_DATE('$to_date','DD/MM/YYYY')
        ");

        return view("admin.reports.pharmacy.pharmacy_profit_loss_html", compact('profit_loss_qry', 'from_date', 'to_date'));
    }

    public function pharmacy_profit_loss_pdf(Request $request)
    {
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));

        $profit_loss_qry = DB::select("select invoicedtl_no_pk, to_char(au_entry_at,'DD/MM/YYYY') bill_date,
                    CASE  WHEN cancel_qty>  0
                        then 'Return Bill'
                        else 'Sales'
                    END return_bill,

                    CASE WHEN module_no_fk = 3
                        THEN 'PHARMACY'
                        WHEN module_no_fk = 9
                        THEN 'OPDC'
                        WHEN module_no_fk = 12
                        THEN 'OUTDOOR'
                        WHEN module_no_fk = 22
                        THEN 'PHARMACY IPD'
                        WHEN module_no_fk = 23
                        THEN 'POINT OF SALE'
                        WHEN module_no_fk = 2
                        THEN 'INDDOR'
                        ELSE 'UNDEFINE'
                    END customer_type,

                    customer_name,
                    total_sales_price,
                    total_cancel_price,
                    total_purchase_price,
                    profit
                    --CASE WHEN item_qty > 0
                    --THEN sales_price*item_qty
                    --END sales_amount,

                    --CASE WHEN cancel_qty > 0
                    --THEN sales_price*cancel_qty
                    --END sales_return_amount,

                    --CASE WHEN cancel_qty > 0
                    --THEN purchase_price*cancel_qty
                    --WHEN item_qty > 0
                    --THEN purchase_price*item_qty
                    --END purchase_amount
                    from FINC_VRWISE_PROFIT_CALC_VW
                    WHERE TRUNC(au_entry_at) between TO_DATE('$from_date', 'DD/MM/YYYY') AND TO_DATE('$to_date','DD/MM/YYYY')
        ");

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

        $pdf = PDF::loadView("admin.reports.pharmacy.pharmacy_profit_loss_html", compact('profit_loss_qry', 'from_date', 'to_date'));

        return $pdf->stream('pharmacy_profit_loss.pdf');
    }


    // Cashier Sumary Report
    public function CashierSummaryReport()
    {
        return Template::loadView("admin.pathology.reports.cahier_wise_summary");
    }
    public function financialDueReport()
    {
        $module = DB::table('sysc_module')->whereIn('module_code', ['OPD', 'PHR'])->where('status', 1)->get();
        return Template::loadView("admin.pathology.reports.financial_due_report", ['module' => $module]);
    }
    public function financialDueReportSearch(Request $request)
    {
        $doctor_id = $request->doctor_id;
        // dd($doctor_id);


        $user_no_pk = null;
        if (!empty($doctor_id)) {
            $userRow = DB::table('wsec_user')
                ->select('user_no_pk')
                ->where('person_no_fk', $doctor_id)
                ->first();
            // dd($userRow);

            if ($userRow) {
                $user_no_pk = $userRow->user_no_pk;
            }
        }


        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $module = $request->module;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause au_entry_by = $user_no_pk" : "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .=  $request->module != ""  ? "$clause module_no_fk =  $module" : '';
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= $request->paid != "" ?  "$clause due = 0" : "$clause due != 0";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $report_data = DB::select("SELECT * FROM finc_c022_vrmst_due_invoice_vw $sql_cond order by invoice_date DESC");

        return Template::loadView("admin.reports.financial_due_report_list", ['report_data' => $report_data]);
    }
    public function financialDueReportPdf(Request $request)
    {
        // PDF::setOptions(['isPhpEnabled', 'true']);
        // PDF::setOptions(['compress', 'true']);
        // PDF::setOptions(['isRemoteEnabled', 'false']);
        // PDF::setOptions(['isPhpEnabled', 'false']);
        // PDF::setOptions(['isJavascriptEnabled', 'false']);
        // PDF::setOptions(['isHtml5MediaEnabled', 'false']);
        // PDF::setOptions(['isCssFloatEnabled', 'false']);
        // PDF::setOptions(['isFontSubsettingEnabled', 'false']);
        // PDF::setOptions(['compressionLevel', '6']);


        $po_hospital_details = DB::table("wsec_hospital")->first();
        $doctor_id = $request->doctor_id;

        $user_no_pk = null;
        if (!empty($doctor_id)) {
            $userRow = DB::table('wsec_user')
                ->select('user_no_pk')
                ->where('person_no_fk', $doctor_id)
                ->first();
            // dd($userRow);

            if ($userRow) {
                $user_no_pk = $userRow->user_no_pk;
            }
        }

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $module = $request->module;
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause au_entry_by = $user_no_pk" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .=  $request->module != ""  ? "$clause module_no_fk =  $module" : '';
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= $request->paid != "" ?  "$clause due = 0" : "$clause due != 0";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT * FROM finc_c022_vrmst_due_invoice_vw $sql_cond order by invoice_date DESC");

        $pdf = PDF::loadView("admin.pathology.reports.financial_due_report_pdf", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to])->setPaper('a4', 'landscape');

        return $pdf->stream('cahier_wise_summary_report_pdf');
    }

    public function paymentDepositReport()
    {
        return Template::loadView("admin.ipd.payment_deposit_report");
    }

    public function paymentDepositReportSearch(Request $request)
    {
        $patient_id = $request->hd_patient_id;
        $date_from = $request->date_from;
        $date_to   = $request->date_to;
        $status     = $request->status;

        $query = DB::table('finc_ipddepositmst as f')
            ->select(
                'f.deposit_no_pk',
                'f.patient_no_fk',
                'f.corporate_no_fk',
                'f.admission_no_fk',
                'f.invoice_no_fk',
                'f.status',
                'f.au_entry_by',
                'f.au_entry_at',
                'f.pay_amount',
                'f.re_invoice_no_fk',
                'p.patient_code',
                'p.patient_name',
                'u.user_fullname as cashier_name',
                'u.user_code as cashier_code'
            )
            ->leftJoin('patn_registration as p', 'p.patient_no_pk', '=', 'f.patient_no_fk')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'f.au_entry_by');

        if (!empty($patient_id)) {
            $query->where('f.patient_no_fk', $patient_id);
        }

        if (!empty($date_from) && !empty($date_to)) {
            $query->whereRaw(
                "TRUNC(f.au_entry_at) BETWEEN TO_DATE(?, 'DD/MM/YYYY') AND TO_DATE(?, 'DD/MM/YYYY')",
                [$date_from, $date_to]
            );
        }

        // Status filtering
        if (!empty($status)) {
            if ($status === 'refund') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNotNull('f.re_invoice_no_fk')
                    ->where('f.pay_amount', '<', 0);
            } elseif ($status === 'cancel') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNotNull('f.re_invoice_no_fk')
                    ->where('f.pay_amount', '>', 0);
            } elseif ($status === 'allocate') {
                $query->whereNotNull('f.admission_no_fk');
            } elseif ($status === 'unallocate') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNull('f.re_invoice_no_fk');
            }
        }

        $report_data = $query->orderBy('f.au_entry_at', 'desc')->get();

        return Template::loadView(
            "admin.ipd.payment_deposit_report_list",
            ['report_data' => $report_data]
        );
    }




    public function paymentDepositReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("wsec_hospital")->first();

        $patient_id = $request->hd_patient_id;
        $date_from  = $request->date_from;
        $date_to    = $request->date_to;
        $status     = $request->status;


        $query = DB::table('finc_ipddepositmst as f')
            ->select(
                'f.deposit_no_pk',
                'f.patient_no_fk',
                'f.corporate_no_fk',
                'f.admission_no_fk',
                'f.invoice_no_fk',
                'f.status',
                'f.au_entry_by',
                'f.au_entry_at',
                'f.pay_amount',
                'f.re_invoice_no_fk',
                'p.patient_code',
                'p.patient_name',
                'u.user_fullname as cashier_name',
                'u.user_code as cashier_code'
            )
            ->leftJoin('patn_registration as p', 'p.patient_no_pk', '=', 'f.patient_no_fk')
            ->leftJoin('wsec_user as u', 'u.user_no_pk', '=', 'f.au_entry_by');

        if (!empty($patient_id)) {
            $query->where('f.patient_no_fk', $patient_id);
        }

        if (!empty($date_from) && !empty($date_to)) {
            $query->whereRaw(
                "TRUNC(f.au_entry_at) BETWEEN TO_DATE(?, 'DD/MM/YYYY') AND TO_DATE(?, 'DD/MM/YYYY')",
                [$date_from, $date_to]
            );
        }

        // 🔹 Status filtering
        if (!empty($status)) {
            if ($status === 'refund') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNotNull('f.re_invoice_no_fk')
                    ->where('f.pay_amount', '<', 0);
            } elseif ($status === 'cancel') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNotNull('f.re_invoice_no_fk')
                    ->where('f.pay_amount', '>', 0);
            } elseif ($status === 'allocate') {
                $query->whereNotNull('f.admission_no_fk');
            } elseif ($status === 'unallocate') {
                $query->whereNull('f.admission_no_fk')
                    ->whereNull('f.re_invoice_no_fk');
            }
        }

        $report_data = $query->orderBy('f.au_entry_at', 'desc')->get();

        $pdf = PDF::loadView(
            "admin.ipd.payment_deposit_report_pdf",
            [
                'report_data' => $report_data,
                'po_hospital_details' => $po_hospital_details,
                'from_date' => $date_from,
                'to_date' => $date_to
            ]
        )->setPaper('a4', 'landscape');

        return $pdf->stream('payment_deposit_report_pdf');
    }


    public function CashierSummaryReportSearch(Request $request)
    {
        $doctor_id = $request->doctor_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $report_data = DB::select("SELECT * FROM finc_cashier_wise_reports_vw $sql_cond order by invoice_date DESC");
        return Template::loadView("admin.pathology.reports.cahier_wise_summary_table", ['report_data' => $report_data]);
    }

    public function CashierSummaryReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $doctor_id = $request->doctor_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $report_data = DB::select("SELECT * FROM finc_cashier_wise_reports_vw $sql_cond order by invoice_date DESC");

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

        $pdf = PDF::loadView("admin.pathology.reports.cahier_wise_summary_report_pdf", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no])->setPaper('a4', 'landscape');

        return $pdf->download('Cashier-Summary-Report.pdf');
    }

    public function doctorWiseIncomeSummeryDetails($person_no_pk, $date, $from_date, $type)
    {
        $to_date = date('Y-m-d', strtotime($date));
        $date =  date('d/m/Y', strtotime($date));
        $from_date =  date('d/m/Y', strtotime($from_date));

        if ($type == 'DEPT') {
            $service_unit = $person_no_pk;
        }

        if ($type != 'DEPT') {
            $income_details = DB::select("SELECT
                                        item_type sur_type,
                                        person_no_fk,
                                        item_no_fk,
                                        item_name,
                                        SUM (item_qty - NVL (cancel_qty, 0)) qty,
                                        SUM (invoicedtl_amt_sales) sales,
                                        round( sum(  CASE WHEN NVL (admission_no_pk, 0) > 0 AND module_code IN ('IPD', 'EMR', 'DAYCARE') THEN ITEM_WISE_DISCOUNT_IPD ELSE NVL (INVOICEDTL_AMT_DISCOUNT,  0)END)) discount,
                                        ROUND (SUM (invoicedtl_amt_sales) - sum(  CASE WHEN NVL (admission_no_pk, 0)> 0 AND module_code IN ('IPD', 'EMR', 'DAYCARE') THEN ITEM_WISE_DISCOUNT_IPD ELSE NVL (INVOICEDTL_AMT_DISCOUNT,  0) END)) net_sales,
                                        ROUND (SUM (invoicedtl_amt_sales) - sum(  CASE WHEN NVL (admission_no_pk, 0) > 0 AND module_code IN ('IPD', 'EMR','DAYCARE') THEN ITEM_WISE_DISCOUNT_IPD ELSE NVL (INVOICEDTL_AMT_DISCOUNT,  0) END)) income,

                                        listagg (invoice_no_pk, ',') within group (order by PERSON_NO_FK) invoice_no

                                        FROM finc_invoicedtl_detail_vw

                                        where PERSON_NO_FK = '$person_no_pk'
                                        and TRUNC(INVOICE_DATE) between to_date('$from_date','dd/mm/yyyy') and TO_DATE('$date','DD/MM/YYYY')
                                        AND NVL(ref_applicable, 1) = 1
                                        AND item_qty - NVL(cancel_qty, 0) > 0

                                        GROUP BY
                                        person_no_fk,
                                        item_no_fk,
                                        item_name,
                                        item_type

                                        ORDER BY item_type,
                                        item_name
                                    ");
        } else {
            $income_details = db::select("SELECT distinct ( CASE WHEN ITEMTYPE_CODE IN ('SERVICE', 'BED', 'IPD') THEN 'IPD SERVICE Item - SERVICE, BED, IPD' WHEN ITEMTYPE_CODE IN ('RAD') THEN 'Radiology Item - RAD' WHEN ITEMTYPE_CODE IN ('LAB') THEN 'Pathology Item - LAB' WHEN ITEMTYPE_CODE IN ('SUR','OT') THEN 'SUR_AMT - SUR, OT'  WHEN ITEMTYPE_CODE IN ('CONS') THEN 'OPD' ELSE 'OTHERS' END) SUR_TYPE, ITEMTYPE_CODE, PERSON_NO_FK, ADMISSION_NO_PK,
            TRUNC (INVOICE_DATE) INVOICE_DATE, INVOICE_NO_PK, ITEM_NO_FK, ITEM_NAME, SALES, NET_SALES, DISCOUNT, SUM (
            NVL (NET_SALES, 0) - NVL (REFUND, 0) + NVL (ITEM_LEVEL_DIST_ADJ_AMT, 0) + NVL (URGENT_FEE, 0) + NVL (SERVICE_CHARGE, 0)) income, PATIENT_NAME FROM finc_doc_appoint_sum_date_vw where serviceunit_no_pk = '$service_unit' and  trunc(invoice_date) = to_date('$date','dd/mm/yyyy') group by  invoice_date, serviceunit_no_pk, serviceunit_name, status, trunc(au_entry_at), au_entry_hospital_pk_no");
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($type != 'DEPT') {
            $doc_data = [];
            if (!empty($income_details)) {
                foreach ($income_details as $key => $details) {
                    $doc_data[$key] = $details;
                }
            }
        } else {
            $dept_data = [];
            if (!empty($income_details)) {
                foreach ($income_details as $key => $details) {
                    $dept_data[$key] = $details;
                }
            }
        }


        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_details", [
            'income_details' => $income_details,
            'po_hospital_details' => $po_hospital_details,
            'doc_data' => $doc_data,
            'type' => $type,
            'to_date' => $to_date,
            'from_date' => $from_date,
        ]);
    }
    public function test()
    {
        $doctor_income =  DB::select("SELECT
     to_char(inc.INCOME_DATE,'MONTH') as column1,
               --dvw.PERSON_NO_PK,
               dvw.FULL_NAME column2,
               --dvw.specialization_lookup_no_fk,
               --dvw.SPECIALIZATION,
               sum(inc.TOTAL_APPOINTMENT) column3,
                 sum(inc.PATIENT_NEW_PAID) column4,
               sum(inc.PATIENT_FREE) column5,
               sum(inc.PATIENT_FOLLOWUP_FREE) column6,
               sum(inc.TOTAL_PATIENT_PAID) column7,
                   sum(inc.SUR_AMT_count) column8,
                      sum(inc.SUR_AMT) column9,
                      sum(ipd.TOTAL_ADMISSION_NO) column10,
                         sum(inc.IPD_SERVICE_AMT_count) column11,
                               sum(inc.IPD_SERVICE_AMT) column12,
                               sum(inc.PATHOLOGY_AMT_count) column13,
                                  sum(inc.LAB_AMT) column14,
                                   sum(inc.RADIOLOGY_AMT_count) column3,
                                       sum(inc.RAD_AMT) column3,
                                              sum(inc.ALL_OTHER_AMT)
          FROM (SELECT CASE
                          WHEN appv.PERSON_NO_FK = inv.PERSON_NO_FK
                          THEN
                             inv.PERSON_NO_FK
                          WHEN appv.PERSON_NO_FK IS NOT NULL
                               AND inv.PERSON_NO_FK IS NULL
                          THEN
                             appv.PERSON_NO_FK
                          WHEN appv.PERSON_NO_FK IS NULL
                               AND inv.PERSON_NO_FK IS NOT NULL
                          THEN
                             inv.PERSON_NO_FK
                          ELSE
                             NULL
                       END
                          PERSON_NO_PK,
                       CASE
                          WHEN appv.APPOINT_DATE = inv.INVOICE_DATE
                          THEN
                             inv.INVOICE_DATE
                          WHEN appv.APPOINT_DATE IS NOT NULL
                               AND inv.INVOICE_DATE IS NULL
                          THEN
                             appv.APPOINT_DATE
                          WHEN appv.APPOINT_DATE IS NULL
                               AND inv.INVOICE_DATE IS NOT NULL
                          THEN
                             inv.INVOICE_DATE
                          ELSE
                             NULL
                       END
                          income_DATE,
                       appv.TOTAL_APPOINTMENT,
                       appv.PATIENT_FREE,
                       appv.PATIENT_FOLLOWUP_FREE,
                       appv.PATIENT_NEW_PAID,
                       --appv.TOTAL_PATIENT_PAID,
                       appv.LEDGER_AMT_PAYMENT TOTAL_PATIENT_PAID,
                       inv.SUR_AMT,
                       inv.LAB_AMT,
                       inv.RAD_AMT,
                       inv.IPD_SERVICE_AMT,
                       inv.ALL_OTHER_AMT,
                       inv.SUR_AMT_count,
                       inv.IPD_SERVICE_AMT_count,
                       INV.PATHOLOGY_AMT_count,
                       inv.RADIOLOGY_AMT_count
                  FROM    FINC_DOC_APPOINT_SUM_DT_VW appv
                       FULL OUTER JOIN
                          (  SELECT PERSON_NO_FK,
                                    INVOICE_DATE,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN ('SUR', 'OT')
                                          THEN
                                             income
                                          ELSE
                                             0
                                       END)
                                       SUR_AMT,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE = 'LAB' THEN income
                                          ELSE 0
                                       END)
                                       LAB_AMT,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE = 'RAD' THEN income
                                          ELSE 0
                                       END)
                                       RAD_AMT,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN
                                                  ('SERVICE', 'BED', 'IPD')
                                          THEN
                                             income
                                          ELSE
                                             0
                                       END)
                                       IPD_SERVICE_AMT,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE NOT IN
                                                  ('SERVICE',
                                                   'BED',
                                                   'IPD',
                                                   'SUR',
                                                   'OT',
                                                   'LAB',
                                                   'RAD',
                                                   'DOCBILL',
                                                   'CONS')
                                               OR ITEMTYPE_CODE IS NULL
                                          THEN
                                             income
                                          ELSE
                                             0
                                       END)
                                       ALL_OTHER_AMT,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN ('SUR', 'OT')
                                               AND income > 0
                                          THEN
                                             1
                                          ELSE
                                             0
                                       END)
                                       SUR_AMT_count,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN
                                                  ('SERVICE', 'BED', 'IPD')
                                               AND income > 0
                                          THEN
                                             1
                                          ELSE
                                             0
                                       END)
                                       IPD_SERVICE_AMT_count,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN ('LAB')
                                               AND income > 0
                                          THEN
                                             1
                                          ELSE
                                             0
                                       END)
                                       PATHOLOGY_AMT_count,
                                    SUM (
                                       CASE
                                          WHEN ITEMTYPE_CODE IN ('RAD')
                                               AND income > 0
                                          THEN
                                             1
                                          ELSE
                                             0
                                       END)
                                       RADIOLOGY_AMT_count
                               FROM (  SELECT ITEMTYPE_CODE,
                                              PERSON_NO_FK,
                                              ADMISSION_NO_PK,
                                              TRUNC (INVOICE_DATE) INVOICE_DATE,
                                              INVOICE_NO_PK,
                                              ITEM_NO_FK,
                                              SUM (
                                                   NVL (NET_SALES, 0)
                                                 - NVL (REFUND, 0)
                                                 + NVL (ITEM_LEVEL_DIST_ADJ_AMT, 0)
                                                 + NVL (URGENT_FEE, 0)
                                                 + NVL (SERVICE_CHARGE, 0))
                                                 income
                                         FROM CORE_FINC_SUM_INV_ITEM_LD_VW
                                     GROUP BY ITEMTYPE_CODE,
                                              PERSON_NO_FK,
                                              ADMISSION_NO_PK,
                                              TRUNC (INVOICE_DATE),
                                              INVOICE_NO_PK,
                                              ITEM_NO_FK)
                           GROUP BY PERSON_NO_FK, INVOICE_DATE) inv
                       ON appv.PERSON_NO_FK = inv.PERSON_NO_FK
                          AND inv.INVOICE_DATE = appv.APPOINT_DATE) inc
               JOIN DOCTOR_INFO_VW dvw
                  ON dvw.PERSON_NO_PK = inc.PERSON_NO_PK
               LEFT JOIN (  SELECT COUNT (DISTINCT (ADMISSION_NO_PK))
                                      TOTAL_ADMISSION_NO,
                                   PRIMARY_DOCTOR_NO_FK,
                                   TRUNC (ADMISSION_DATE) ADMISSION_DATE
                              FROM ipd_admission
                          GROUP BY PRIMARY_DOCTOR_NO_FK, TRUNC (ADMISSION_DATE)) ipd
                  ON ipd.PRIMARY_DOCTOR_NO_FK = inc.PERSON_NO_pK
                     AND IPD.ADMISSION_DATE = inc.INCOME_DATE where dvw.SPECIALIZATION = 'Ophthalmologist' group by to_char(inc.INCOME_DATE,'MONTH'),dvw.PERSON_NO_PK,
               dvw.FULL_NAME,
               dvw.specialization_lookup_no_fk,
               dvw.SPECIALIZATION order by dvw.PERSON_NO_PK  ");


        return view("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_list", compact('doctor_income'));
    }


    public function jakatFundReport()
    {
        $bank_name = $this->getLookupListByCode("AGENTBANKING");
        return Template::loadview("admin.reports.jakat.jakat_fund_report", [
            'bank_name' => $bank_name
        ]);
    }
    public function scheduleJakatFundReport(Request $request)
    {

        $to_date = date("Y-m-d");
        if ($to_date != "") {
            $selectQuery = DB::select("select patient_code, patient_name, present_addr, serviceunit_name, invoice_date, sales, zakatfund,religion_txt,module_code
                            from finc_c022_sum_amount_zakat_vw
                            where zakatfund > 0
                            and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$to_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))
                            order by ledgertrn_date desc
                            ");

            return Template::loadview("admin.reports.jakat.schedule_jakat_fund_report", ['jakat' => $selectQuery]);
        }
    }
    public function scheduleJakatFundReportSearch(Request $request)
    {
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $sql_cond  =  '';
        if ($from_date != "" && $to_date != "") {
            $sql_cond  .=  "and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))";
        }
        if (isset($request->religion)) {
            if ($request->religion == 'Islam') {
                $sql_cond  .= " and UPPER(FUND_TYPE) in ('ZAKATFUND', 'DIRECTORFUND')";
            } else {
                $sql_cond  .= " and UPPER(FUND_TYPE) = 'NONMUSLIMFUND'";
            }
        }
        if (isset($request->report_type)) {
            $report_type = $request->report_type;
            if ($request->report_type == 'OPD') {
                $sql_cond  .= " and module_code = '$report_type'";
            } elseif ($request->report_type == 'IPD') {
                $sql_cond  .= " and module_code = '$report_type'";
            } elseif ($request->report_type == 'GENERAL') {
                $sql_cond  .= " and module_code in ('OPD','IPD')";
            } elseif ($request->report_type == 'PHR') {
                $sql_cond  .= " and module_code in ('PHR-I','PHR')";
            }
        }
        $selectQuery = DB::select("select patient_code, patient_name, present_addr, serviceunit_name, invoice_date, sales, zakatfund,religion_txt,module_code
            from finc_c022_sum_amount_zakat_vw
            where zakatfund > 0
            $sql_cond
            order by ledgertrn_date desc
            ");
        return Template::loadview("admin.reports.jakat.schedule_jakat_fund_report_table", ['jakat' => $selectQuery]);
    }
    public function scheduleJakatFundReportPdf(Request $request)
    {
        //dd('test');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $sql_cond  =  '';
        if ($from_date != "" && $to_date != "") {
            $sql_cond  .=  "and TRUNC(ledgertrn_date) between TRUNC(TO_DATE('$from_date','YYYY-MM-DD')) AND TRUNC(TO_DATE('$to_date','YYYY-MM-DD'))";
        }
        if (isset($request->religion)) {
            if ($request->religion == 'Islam') {
                $sql_cond  .= " and UPPER(FUND_TYPE) in ('ZAKATFUND', 'DIRECTORFUND')";
            } else {
                $sql_cond  .= " and UPPER(FUND_TYPE) = 'NONMUSLIMFUND'";
            }
        }
        if (isset($request->report_type)) {
            $report_type = $request->report_type;
            if ($request->report_type == 'OPD') {
                $sql_cond  .= " and module_code = '$report_type'";
            } elseif ($request->report_type == 'IPD') {
                $sql_cond  .= " and module_code = '$report_type'";
            } elseif ($request->report_type == 'GENERAL') {
                $sql_cond  .= " and module_code in ('OPD','IPD')";
            } elseif ($request->report_type == 'PHR') {
                $sql_cond  .= " and module_code in ('PHR-I','PHR')";
            }
        }
        $selectQuery = DB::select("select patient_code, patient_name, present_addr, serviceunit_name, invoice_date, sales, zakatfund,religion_txt,module_code
            from finc_c022_sum_amount_zakat_vw
            where zakatfund > 0
            $sql_cond
            order by ledgertrn_date desc
            ");

        $title = "Zakat Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        //return view("admin.reports.jakat.schedule_jakat_fund_report_pdf");
        $pdf = PDF::loadView("admin.reports.jakat.schedule_jakat_fund_report_pdf", ['religion' => $request->religion, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'jakat' => $selectQuery,  'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->stream("schedule_jakat_fund_report_pdf.pdf", array("Attachment" => false));
    }

    public function ipdPatientRefundDueReportList(Request $request)
    {
        $type = $request->type;
        $date_from = $request->search_date_from;
        $date_to = $request->search_date_to;
        if (!empty($date_from) && !empty($date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select invoice_code,
                                        invoice_date,
                                        invoice_time,
                                        sum(due) due,
                                        patient_code,
                                        patient_name,
                                        age,
                                        gender_txt,
                                        mobile1,
                                        doctor_name
                                    from finc_voucherwise_vw
                                    where nvl (due, 0) > 0 $sql_cond
                                    group by invoice_code,
                                        invoice_date,
                                        invoice_time,
                                        patient_code,
                                        patient_name,
                                        age,
                                        gender_txt,
                                        mobile1,
                                        doctor_name ");
        return Template::loadView("admin.ipd.reports.ipd_refund_due_patient_list", ['report_data' => $report_data, 'type' => $type]);
    }

    //Pharmacy Summary Report

    public function pharmacyCashierSummaryReport()
    {
        return Template::loadView("admin.reports.pharmacy.summary.cashier_summary_report");
    }


    public function pharmacyCashierSummaryReportSearch(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        //  echo "select * from  FINC_C022_CASHIER_WISE_RPT_VW  $sql_cond ";

        $query = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
        sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        sum(sales)  sales,
        sum(discount)discount  ,
        sum(net_sales) net_sales  ,
        sum(collection) collection ,
        sum(due)  due ,
        sum(refund) refund ,
        sum(net_collection) net_collection ,
        sum(pay_amount_cash) pay_amount_cash ,
        sum(pay_amount_cash_net)  pay_amount_cash_net,
        sum(pay_amount_others) pay_amount_others

        from  finc_c022_cashier_wise_rpt_vw   $sql_cond group by  full_name,person_code , ledgertrn_date ")); //FINC_CASHIER_WISE_REPORTS_VW FINC_C022_CASHIER_WISE_RPT_VW
        return Template::loadview("admin.reports.pharmacy.summary.cashier_summary_report_list", [
            'data' => $query,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function pharmacyCashierSummaryReportPrint(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::select(DB::raw("select full_name,person_code, ledgertrn_date,
        sum(total_invoice_cnt_new) total_invoice_cnt_new  ,
        sum(coalesce(total_invoice_cnt_old,0)) total_invoice_cnt_old,
        sum(sales)  sales,
        sum(discount)discount  ,
        sum(net_sales) net_sales  ,
        sum(collection) collection ,
        sum(due)  due ,
        sum(refund) refund ,
        sum(net_collection) net_collection ,
        sum(pay_amount_cash) pay_amount_cash ,
        sum(pay_amount_cash_net)  pay_amount_cash_net,
        sum(pay_amount_others) pay_amount_others
        from  finc_c022_cashier_wise_rpt_vw   $sql_cond group by  full_name,person_code , ledgertrn_date "));

        $title = "pharmacy-Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.summary.cashier_summary_report_pdf", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
        return $pdf->stream('pharmacy-cashier-wise-report.pdf');
    }



    public function marketingReportSummary()
    {
        $thana = $this->getLookupListByCode("THANA");
        $marketing_area = $this->getLookupListByCode("MARKETINGAREA");
        return Template::loadview("admin.reports.marketing_reports.marketing_summary_report", [
            'thana' => $thana,
            'marketing_area' => $marketing_area
        ]);
    }

    // area

    public function marketingAreaReportSearchSummary(Request $request)
    {

        $type = $request->type;
        if ($type != "AREA") {
            $area_no_pk = $request->ref_doc;
        } else {

            $area_no_pk = $request->hdn_area_code;
        }

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        if ($type != "AREA") {
            $sql_cond .= ($area_no_pk != "") ? " $clause first_ref_doc_person_no_fk = '$area_no_pk'" : "";
        } else {
            $sql_cond .= ($area_no_pk != "") ? " $clause patient_area_no_fk = '$area_no_pk'" : "";
        }
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause invoice_date between to_date ('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($type != "AREA") {
            $marketing_list = db::select(db::raw("select first_ref_doc_person_no_fk,
                   person_code,
                   first_doc_name,
                   count (person_no_fk) total_patient,
                   sum (sales) total_sales,
                   sum (collection) total_collection,
                   sum (discount) total_discount,
                   sum (net_sales) total_net_sales,
                   sum (refund) total_refund,
                   sum (due) total_due,
                   sum (net_collection) total_net_collection
              from finc_c022_vrmst_sum_areampo_vw $sql_cond and  first_ref_doc_person_no_fk is not null
          group by first_ref_doc_person_no_fk,person_code,
                   first_doc_name"));

            return Template::loadView("admin.reports.marketing_reports.marketing_mpo_summary_list", ['marketing_list' => $marketing_list]);
        } else {
            $marketing_list = db::select(db::raw("select patient_area_no_fk,
            patient_area_name,
            count(person_no_fk) total_patient,
            sum (sales) total_sales,
            sum (collection) total_collection,
            sum (discount) total_discount,
            sum (net_sales) total_net_sales,
            sum (refund) total_refund,
            sum (due) total_due,
            sum (net_collection) total_net_collection
       from finc_c022_vrmst_sum_areampo_vw $sql_cond and  patient_area_no_fk is not null
   group by patient_area_no_fk, patient_area_name "));


            return Template::loadView("admin.reports.marketing_reports.marketing_area_summary_list", ['marketing_list' => $marketing_list]);
        }
    }

    public function marketingAreaSummaryReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $type = $request->type;
        if ($type != "AREA") {
            $area_no_pk = $request->ref_doc;
        } else {

            $area_no_pk = $request->hdn_area_code;
        }

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        if ($type != "AREA") {
            $sql_cond .= ($area_no_pk != "") ? " $clause first_ref_doc_person_no_fk = '$area_no_pk'" : "";
        } else {
            $sql_cond .= ($area_no_pk != "") ? " $clause patient_area_no_fk = '$area_no_pk'" : "";
        }
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause invoice_date between to_date ('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($type != "AREA") {
            $marketing_list = db::select(db::raw("select first_ref_doc_person_no_fk,
                   person_code,
                   first_doc_name,
                   count (person_no_fk) total_patient,
                   sum (sales) total_sales,
                   sum (collection) total_collection,
                   sum (discount) total_discount,
                   sum (net_sales) total_net_sales,
                   sum (refund) total_refund,
                   sum (due) total_due,
                   sum (net_collection) total_net_collection
              from finc_c022_vrmst_sum_areampo_vw $sql_cond and  first_ref_doc_person_no_fk is not null
          group by first_ref_doc_person_no_fk,person_code,
                   first_doc_name"));


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

            $pdf = PDF::loadView("admin.reports.marketing_reports.marketing_summary_pdf", ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no, 'type' => 'MPO']);

            return $pdf->download('MPO_wise_summary_report.pdf');
            //  return view("admin.reports.marketing_reports.marketing_area_pdf", [
            //    , ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no,'type'=> $type]);


        } else {
            $marketing_list = db::select(db::raw("select patient_area_no_fk,
            patient_area_name,
            count(person_no_fk) total_patient,
            sum (sales) total_sales,
            sum (collection) total_collection,
            sum (discount) total_discount,
            sum (net_sales) total_net_sales,
            sum (refund) total_refund,
            sum (due) total_due,
            sum (net_collection) total_net_collection
        from finc_c022_vrmst_sum_areampo_vw $sql_cond and  patient_area_no_fk is not null
        group by patient_area_no_fk, patient_area_name"));

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

            $pdf = PDF::loadView("admin.reports.marketing_reports.marketing_summary_pdf", ['marketing_list' => $marketing_list, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no, 'type' => "AREA"]);

            return $pdf->download('Area_wise_summary_report.pdf');
        }
    }


    // punch Time Details

    public function punchTimeDetails($person_no_pk, $date)
    {
        //Query By Moin Sir
        $date =  date('d/m/Y', strtotime($date));
        $person_code = $person_no_pk;
        $punch_details = DB::select("select * from machine_punch_datadtl_vw where person_code = '$person_code' and  trunc(ATTENDANCE_DATE) = to_date('$date','dd/mm/yyyy')");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $punch_dt = [];

        foreach ($punch_details as $dt) {
            $punch_dt[$dt->full_name . '~' . $dt->attendance_date][] = $dt;
        }
        return Template::loadview("admin.reports.hrm.punch_time_details", [
            'punch_dt' => $punch_dt,
            'po_hospital_details' => $po_hospital_details
        ]);
    }




    // Dept wise Patient Summary Depts Report

    public function deptWiseSumPerformanceReport()
    {
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.individual_dept_sum_wise_report", ['serviceDepts' => $serviceDepts]);
    }
    public function deptWiseSumPerformanceDetailsSearch(Request $request)
    {

        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : "";

        $selectquery = DB::table('finc_doc_appoint_sum_dt_su_vw')
            ->select(DB::raw("sum(patient_followup_free) patient_followup_free , sum(patient_free) patient_free, sum(patient_new_paid) patient_new_paid, serviceunit_name, serviceunit_no_pk, sum(ledger_amt_payment) ledger_amt_payment , sum(total_appointment) total_appointment "));
        //'patient_followup_free', 'patient_free', 'patient_new_paid', 'serviceunit_name', 'serviceunit_no_pk', 'ledger_amt_payment', 'total_appointment'
        $dept_detail_data = [];

        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectquery
                ->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($service_unit != null) {
            $dept_detail_data = $selectquery
                ->where('serviceunit_no_pk', $service_unit);
        }
        $dept_detail_data = $selectquery->groupBy("serviceunit_name", "serviceunit_no_pk")->get();

        //dd( $dept_detail_data );

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.deptServiceunitSumWiseDeptData", ['dept_detail_data' => $dept_detail_data]);
    }
    public function deptWiseSumPerformanceDetailsPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectquery = DB::table('finc_doc_appoint_sum_dt_su_vw')
            ->select(DB::raw("sum(patient_followup_free) patient_followup_free , sum(patient_free) patient_free, sum(patient_new_paid) patient_new_paid, serviceunit_name, serviceunit_no_pk, sum(ledger_amt_payment) ledger_amt_payment , sum(total_appointment) total_appointment "));


        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($service_unit != null) {
            $selectquery->where('serviceunit_no_pk', $service_unit);
        }
        $dept_detail_data = $selectquery->groupBy("serviceunit_name", "serviceunit_no_pk")->get();


        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.dept_sum_wise_report_pdf", ['barcode_no' => $barcode_no, 'dept_detail_data' => $dept_detail_data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->stream('Department_Wise_Performance_Report.pdf');
    }

    public function deptWiseSumPerformanceDetailsExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectquery = DB::table('finc_doc_appoint_sum_dt_su_vw')
            ->select(DB::raw("sum(patient_followup_free) patient_followup_free , sum(patient_free) patient_free, sum(patient_new_paid) patient_new_paid, serviceunit_name, serviceunit_no_pk, sum(ledger_amt_payment) ledger_amt_payment , sum(total_appointment) total_appointment "));


        if ($from_date != "" && $to_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectquery->where(DB::raw("trunc(appoint_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectquery->where(DB::raw("trunc(appoint_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($service_unit != null) {
            $selectquery->where('serviceunit_no_pk', $service_unit);
        }
        $dept_detail_data = $selectquery->groupBy("serviceunit_name", "serviceunit_no_pk")->get();

        $pdf = ['dept_detail_data' => $dept_detail_data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];

        $fileToExport = "department_wise_performance_report"; //dept_sum_wise_report_excel
        $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_report_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }





    // Dept wise Item Summary Depts Report

    public function deptWiseSummaryReport()
    {
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.individual_dept_summary_wise_report", ['serviceDepts' => $serviceDepts]);
    }
    public function deptWiseSummaryDetailsSearch(Request $request)
    {
        // dd($request->all());

        $service_unit = $request->request_department;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause su_no_fk=$service_unit" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select department_name,no_of_invoice,
                                    round (sales) sales,
                                    round (payment) payment,
                                    round (discount) discount
                            from (  select su_no_fk,
                                            fnc_serviceunitname (su_no_fk) department_name,
                                            count(1) no_of_invoice,
                                            sum (item_rate * (item_qty - nvl (cancel_qty, 0))) sales,
                                            sum (invoicedtl_amt_payment) payment,
                                            sum (invoicedtl_amt_discount) discount
                                        from finc_invoicedtl dtl, finc_invoicemst mst
                                        where nvl (cancel_ind, 0) = 0
                                            and dtl.invoice_no_fk = mst.invoice_no_pk
                                            $sql_cond
                                    group by su_no_fk)
                            order by 1");

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.deptServiceunitSummaryWiseDeptData", ['dept_detail_data' => $report_data]);
    }
    public function deptWiseSummaryDetailsPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause su_no_fk=$service_unit" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select department_name,no_of_invoice,
                    round (sales) sales,
                    round (payment) payment,
                    round (discount) discount
            from (  select su_no_fk,
                            fnc_serviceunitname (su_no_fk) department_name,
                            count(1) no_of_invoice,
                            sum (item_rate * (item_qty - nvl (cancel_qty, 0))) sales,
                            sum (invoicedtl_amt_payment) payment,
                            sum (invoicedtl_amt_discount) discount
                        from finc_invoicedtl dtl, finc_invoicemst mst
                        where nvl (cancel_ind, 0) = 0
                            and dtl.invoice_no_fk = mst.invoice_no_pk
                            $sql_cond
                    group by su_no_fk)
            order by 1");


        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_summary_report_pdf", ['barcode_no' => $barcode_no, 'dept_detail_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->stream('Department_Wise_Performance_Report.pdf');
    }

    public function deptWiseSummaryDetailsExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $service_unit = $request->request_department;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause su_no_fk=$service_unit" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select department_name,no_of_invoice,
                    round (sales) sales,
                    round (payment) payment,
                    round (discount) discount
            from (  select su_no_fk,
                            fnc_serviceunitname (su_no_fk) department_name,
                            count(1) no_of_invoice,
                            sum (item_rate * (item_qty - nvl (cancel_qty, 0))) sales,
                            sum (invoicedtl_amt_payment) payment,
                            sum (invoicedtl_amt_discount) discount
                        from finc_invoicedtl dtl, finc_invoicemst mst
                        where nvl (cancel_ind, 0) = 0
                            and dtl.invoice_no_fk = mst.invoice_no_pk
                            $sql_cond
                    group by su_no_fk)
            order by 1");
        $dept_detail_data = $report_data;

        $pdf = ['dept_detail_data' => $dept_detail_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];

        $fileToExport = "department_wise_summary_performance_report"; //dept_sum_wise_report_excel
        $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_summmary_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }






    // Dept wise Item Summary Depts Report

    public function pathologySummaryReport()
    {
        // $minor_group_list  = DB::table('sysc_itemtype')->select('item_type_name', 'itemtype_no_pk')->where('minor_group_ind', 1)->get();
        // dd($minor_group_list);
        $serviceDepts = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.pahthology_summary_wise_report", [
            'serviceDepts' => $serviceDepts
        ]);
    }
    public function pathologySummaryDetailsSearch(Request $request)
    {
        //  dd($request->all());

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $service_unit = $request->request_department;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause serviceunit_no_fk=$service_unit" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        $report_data = db::select("select serviceunit_name,item_name, sum(net_item_qty) as net_item_qty,sum(opd_item_qty) as opd_item_qty,
        sum(ipd_item_qty) as ipd_item_qty,
        sum(emrg_item_qty) as emrg_item_qty from rpt_lab_item_dt_count_vw  $sql_cond
         group by  serviceunit_name,item_name  order by serviceunit_name,item_name asc");

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.pathologySummaryWiseDeptData", ['dept_detail_data' => $report_data]);
    }
    public function pathologySummaryDetailsPdf(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $service_unit = $request->request_department;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause serviceunit_no_fk=$service_unit" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select serviceunit_name,item_name, sum(net_item_qty) as net_item_qty,sum(opd_item_qty) as opd_item_qty,
        sum(ipd_item_qty) as ipd_item_qty,
        sum(emrg_item_qty) as emrg_item_qty from rpt_lab_item_dt_count_vw  $sql_cond
         group by  serviceunit_name,item_name  order by serviceunit_name,item_name asc");



        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.pathology_summary_report_pdf", ['barcode_no' => $barcode_no, 'dept_detail_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->stream('Department_Wise_Performance_Report.pdf');
    }




    // Dept wise Item Summary Depts Report

    public function pathologySummaryReportAdmission()
    {
        // $minor_group_list  = DB::table('sysc_itemtype')->select('item_type_name', 'itemtype_no_pk')->where('minor_group_ind', 1)->get();
        // dd($minor_group_list);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.pahthology_summary_wise_report_admission");
    }
    public function pathologySummaryDetailsSearchAdmission(Request $request)
    {
        //  dd($request->all());

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause su_no_fk=$service_unit" : "";

        $report_data = db::select("select serviceunit_name,item_name, sum(net_item_qty) as net_item_qty,sum(opd_item_qty) as opd_item_qty,
        sum(ipd_item_qty) as ipd_item_qty,
        sum(emrg_item_qty) as emrg_item_qty from rpt_lab_item_dt_count_vw  $sql_cond
         group by  serviceunit_name,item_name  order by serviceunit_name,item_name asc");

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.pathologySummaryWiseDeptDataIp", ['dept_detail_data' => $report_data]);
    }
    public function pathologySummaryDetailsPdfAdmission(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = db::select("select serviceunit_name,item_name, sum(net_item_qty) as net_item_qty,sum(opd_item_qty) as opd_item_qty,
        sum(ipd_item_qty) as ipd_item_qty,
        sum(emrg_item_qty) as emrg_item_qty from rpt_lab_item_dt_count_vw  $sql_cond
         group by  serviceunit_name,item_name  order by serviceunit_name,item_name asc");



        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.pathology_summary_report_pdf_ipd", ['barcode_no' => $barcode_no, 'dept_detail_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->stream('Department_Wise_Performance_Report.pdf');
    }



    //income report


    public function incomeReport()
    {
        return Template::loadview("admin.reports.income.income_reports");
    }
    public function incomeDetailsSearch(Request $request)
    {

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(MST.LEDGER_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $daily_group_income_statement = DB::select("  SELECT ITY_GROUP_HEADER_NAME item_type_head,
        ITY_GROUP_HEADER_CODE,
        SUM (
           CASE WHEN LEDGER_AMT_PAYMENT > 0 THEN LEDGER_AMT_PAYMENT ELSE 0 END)
           collection,
        ABS (
           SUM (
              CASE
                 WHEN LEDGER_AMT_PAYMENT < 0 THEN LEDGER_AMT_PAYMENT
                 ELSE 0
              END))
           refund,
        SUM (
           CASE WHEN LEDGER_AMT_PAYMENT > 0 THEN LEDGER_AMT_PAYMENT ELSE 0 END)
        + SUM (
             CASE
                WHEN LEDGER_AMT_PAYMENT < 0 THEN LEDGER_AMT_PAYMENT
                ELSE 0
             END)
           total_collection
   FROM FINC_INVOICEDTL_DETAIL_VW dtl, finc_ledgermst mst
  WHERE dtl.invoice_no_pk = mst.invoice_no_fk
        $sql_cond
GROUP BY ITY_GROUP_HEADER_NAME, ITY_GROUP_HEADER_CODE
ORDER BY 1");
        return Template::loadview("admin.reports.income.income_reports_search", ['daily_group_income_statement' => $daily_group_income_statement]);
    }
    public function incomeDetailsPdf(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(MST.LEDGER_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $daily_group_income_statement = DB::select("  SELECT ITY_GROUP_HEADER_NAME item_type_head,
        ITY_GROUP_HEADER_CODE,
        SUM (
           CASE WHEN LEDGER_AMT_PAYMENT > 0 THEN LEDGER_AMT_PAYMENT ELSE 0 END)
           collection,
        ABS (
           SUM (
              CASE
                 WHEN LEDGER_AMT_PAYMENT < 0 THEN LEDGER_AMT_PAYMENT
                 ELSE 0
              END))
           refund,
        SUM (
           CASE WHEN LEDGER_AMT_PAYMENT > 0 THEN LEDGER_AMT_PAYMENT ELSE 0 END)
        + SUM (
             CASE
                WHEN LEDGER_AMT_PAYMENT < 0 THEN LEDGER_AMT_PAYMENT
                ELSE 0
             END)
           total_collection
   FROM FINC_INVOICEDTL_DETAIL_VW dtl, finc_ledgermst mst
  WHERE dtl.invoice_no_pk = mst.invoice_no_fk
        $sql_cond
GROUP BY ITY_GROUP_HEADER_NAME, ITY_GROUP_HEADER_CODE
ORDER BY 1");

        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.reports.income.income_reports_pdf", ['barcode_no' => $barcode_no, 'daily_group_income_statement' => $daily_group_income_statement, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrate');
        return $pdf->stream('income_report.pdf');
    }




    //    Corporate Reports

    public function corporateReport()
    {
        return Template::loadView("admin.reports.ipd.financial.corporate_report");
    }

    public function corporateDetailsSearch(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_id = $request->hdn_doctor_id;
        //    return $request->date_from;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause mst.PATIENT_NO_FK = $patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("SELECT CCM_CLIENT_NAME,
                    CUSTOMER_NAME,
                    invoice_date,
                    SUM (LEDGER_AMT_SALES) sales,
                    SUM (LEDGER_AMT_DISCOUNT) discount,
                    SUM (LEDGER_AMT_PAYMENT) payment
            FROM finc_invoicedtl_detail_vw inv,
                    finc_ledgermst mst,
                    CCM_CORPORATECLIENT ccm
            WHERE     PATIENT_TYPE_CODE = 'CORPORATE'
                    AND mst.invoice_no_fk = inv.invoice_no_pk
                    AND ccm.CCM_CLIENT_NO_PK = mst.COR_CLIENT_NO_FK
                      $sql_cond
            GROUP BY CCM_CLIENT_NAME, CUSTOMER_NAME, invoice_date
            ORDER BY 1");

        return Template::loadView("admin.reports.ipd.financial.corporate_report_table", ['report_data' => $report_data]);
    }

    public function corporateDetailsPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_id = $request->hdn_patient_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($patient_id != "") ? " $clause mst.PATIENT_NO_FK = $patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        if ($request->print_type == 'SUMMARY') {
            $report_data = DB::select("SELECT CCM_CLIENT_NAME,CLIENT_ADDRESS,
                    SUM (LEDGER_AMT_SALES) sales,
                    SUM (LEDGER_AMT_DISCOUNT) discount,
                    SUM (LEDGER_AMT_PAYMENT) payment
            FROM finc_invoicedtl_detail_vw inv,
                    finc_ledgermst mst,
                    CCM_CORPORATECLIENT ccm
            WHERE     PATIENT_TYPE_CODE = 'CORPORATE'
                    AND mst.invoice_no_fk = inv.invoice_no_pk
                    AND ccm.CCM_CLIENT_NO_PK = mst.COR_CLIENT_NO_FK
                    $sql_cond
        GROUP BY CCM_CLIENT_NAME,CLIENT_ADDRESS
        ORDER BY 1");
        } else {
            $report_data = DB::select("SELECT CCM_CLIENT_NAME,
                    CUSTOMER_NAME,
                    invoice_date,
                    SUM (LEDGER_AMT_SALES) sales,
                    SUM (LEDGER_AMT_DISCOUNT) discount,
                    SUM (LEDGER_AMT_PAYMENT) payment
            FROM finc_invoicedtl_detail_vw inv,
                    finc_ledgermst mst,
                    CCM_CORPORATECLIENT ccm
            WHERE     PATIENT_TYPE_CODE = 'CORPORATE'
                    AND mst.invoice_no_fk = inv.invoice_no_pk
                    AND ccm.CCM_CLIENT_NO_PK = mst.COR_CLIENT_NO_FK
                      $sql_cond
            GROUP BY CCM_CLIENT_NAME, CUSTOMER_NAME, invoice_date
            ORDER BY 1");
        }

        $report_type = $request->print_type;
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();



        $pdf = PDF::loadView("admin.reports.ipd.financial.corporate_report_table_pdf", [
            'report_data' => $report_data,
            'report_type' => $report_type,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('corporate-Financial-report.pdf');
    }




    // Dept Wise Item Report



    //    Corporate Reports

    public function deptWiseIpd($type = '')
    {
        $type = 'IPD';
        return Template::loadView("admin.reports.dept.dept_wise_reports", ['type' => $type]);
    }
    public function deptWiseOpd($type = '')
    {
        $type = 'OPD';
        return Template::loadView("admin.reports.dept.dept_wise_reports", ['type' => $type]);
    }

    public function deptWiseSearch(Request $request)
    {
        $type = $request->type;
        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        if ($type == "OPD") {
            $report_data = DB::select("  SELECT ITEM_SERVICEUNIT_NAME,
                TRUNC (INVOICE_DATE) INVOICE_DATE,
                ITEM_NO_FK bill_ITEM_NO_FK,
                ITEM_NAME bill_ITEM_NAME,
                SUM (ITEM_QTY) item_qty,
                SUM (CANCEL_QTY) cancel_qty,
                SUM (NVL (ITEM_QTY, 0) - NVL (CANCEL_QTY, 0)) sales_item_qty,
                MAX (NVL (ITEM_RATE, 0) - NVL (SERVICE_CHARGE, 0)) item_rate,
                'PC' bill_uom_name
        FROM FINC_INVOICEDTL_DETAIL_VW
        WHERE item_type <> 'MED' AND  NVL (admission_no_pk, 0) = 0 $sql_cond
        GROUP BY TRUNC (INVOICE_DATE),
                ITEM_NO_FK,
                ITEM_NAME,
                ITEM_SERVICEUNIT_NAME
                order by invoice_date desc,ITEM_SERVICEUNIT_NAME asc,ITEM_NAME asc");
        } else {
            $report_data = DB::select("  SELECT ITEM_SERVICEUNIT_NAME,
                TRUNC (INVOICE_DATE) INVOICE_DATE,
                ITEM_NO_FK bill_ITEM_NO_FK,
                ITEM_NAME bill_ITEM_NAME,
                SUM (ITEM_QTY) item_qty,
                SUM (CANCEL_QTY) cancel_qty,
                SUM (NVL (ITEM_QTY, 0) - NVL (CANCEL_QTY, 0)) sales_item_qty,
                MAX (NVL (ITEM_RATE, 0) - NVL (SERVICE_CHARGE, 0)) item_rate,
                'PC' bill_uom_name
        FROM FINC_INVOICEDTL_DETAIL_VW
        WHERE item_type <> 'MED' AND NVL (admission_no_pk, 0) > 0 $sql_cond
        GROUP BY TRUNC (INVOICE_DATE),
                ITEM_NO_FK,
                ITEM_NAME,
                ITEM_SERVICEUNIT_NAME
                order by invoice_date desc,ITEM_SERVICEUNIT_NAME asc,ITEM_NAME asc");
        }
        $dept = [];
        foreach ($report_data as $data) {
            $dept[$data->item_serviceunit_name][] = $data;
        }

        return Template::loadView("admin.reports.dept.dept_wise_item_search", ['report_data' => $report_data, 'dept' => $dept]);
    }

    public function deptWiseReportPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $type = $request->type;
        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        if ($type == "OPD") {
            $report_data = DB::select("  SELECT ITEM_SERVICEUNIT_NAME,
                TRUNC (INVOICE_DATE) INVOICE_DATE,
                ITEM_NO_FK bill_ITEM_NO_FK,
                ITEM_NAME bill_ITEM_NAME,
                SUM (ITEM_QTY) item_qty,
                SUM (CANCEL_QTY) cancel_qty,
                SUM (NVL (ITEM_QTY, 0) - NVL (CANCEL_QTY, 0)) sales_item_qty,
                MAX (NVL (ITEM_RATE, 0) - NVL (SERVICE_CHARGE, 0)) item_rate,
                'PC' bill_uom_name
        FROM FINC_INVOICEDTL_DETAIL_VW
        WHERE item_type <> 'MED' AND  NVL (admission_no_pk, 0) = 0 $sql_cond
        GROUP BY TRUNC (INVOICE_DATE),
                ITEM_NO_FK,
                ITEM_NAME,
                ITEM_SERVICEUNIT_NAME
                order by invoice_date desc,ITEM_SERVICEUNIT_NAME asc,ITEM_NAME asc");
        } else {
            $report_data = DB::select("  SELECT ITEM_SERVICEUNIT_NAME,
                TRUNC (INVOICE_DATE) INVOICE_DATE,
                ITEM_NO_FK bill_ITEM_NO_FK,
                ITEM_NAME bill_ITEM_NAME,
                SUM (ITEM_QTY) item_qty,
                SUM (CANCEL_QTY) cancel_qty,
                SUM (NVL (ITEM_QTY, 0) - NVL (CANCEL_QTY, 0)) sales_item_qty,
                MAX (NVL (ITEM_RATE, 0) - NVL (SERVICE_CHARGE, 0)) item_rate,
                'PC' bill_uom_name
        FROM FINC_INVOICEDTL_DETAIL_VW
        WHERE item_type <> 'MED' AND NVL (admission_no_pk, 0) > 0 $sql_cond
        GROUP BY TRUNC (INVOICE_DATE),
                ITEM_NO_FK,
                ITEM_NAME,
                ITEM_SERVICEUNIT_NAME
                order by invoice_date desc,ITEM_SERVICEUNIT_NAME asc,ITEM_NAME asc");
        }
        $dept = [];
        foreach ($report_data as $data) {
            $dept[$data->item_serviceunit_name][] = $data;
        }
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.dept.dept_wise_item_pdf", [
            'report_data' => $report_data,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details,
            'type' => $type,
            'dept' => $dept
        ])->setPaper('a4', 'portrait');
        if ($type == 'OPD') {
            return $pdf->download('department-wise-item-OPD-report.pdf');
        } else {
            return $pdf->download('department-wise-item-IPD-report.pdf');
        }
    }


    // ageing supplier report

    public function ageingSupplierReport()
    {
        $suppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_uid', 'supplier_name as sup_name')
            ->orderBy('supplier_name', 'asc')
            ->get();

        return Template::loadView("admin.reports.ageing.ageing_supplier_report", [
            'suppliers' => $suppliers
        ]);
    }

    public function ageingSupplierReportSearch(Request $request)
    {
        $reportDate = $request->input('date');
        $supplierId = $request->input('supplier_id');

        if (empty($reportDate)) {
            return response()->json(['error' => 'Date is required.'], 422);
        }

        $dateArray = explode('/', $reportDate);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

        $reportData = $this->getAgeingSupplierData($formattedDate, $supplierId);

        if (empty($reportData)) {
            return '<div class="alert alert-warning text-center">No records found for the selected criteria.</div>';
        }

        return view('admin.reports.ageing.ageing_supplier_report_data', [
            'report_data' => $reportData,
            'report_date' => $reportDate,
        ]);
    }

    private function getAgeingSupplierData($date = null, $supplierId = null)
    {
        $supplierFilter = $supplierId ? "AND agrn.supplier_no_fk = {$supplierId}" : "";

        $query = "
            SELECT supplier_no_fk,
                supplier_uid,
                sup_name,
                SUM(f1to30) f1to30,
                SUM(f31to60) f31to60,
                SUM(f61to90) f61to90,
                SUM(f91to120) f91to120,
                SUM(f121to150) f121to150,
                SUM(f151to180) f151to180,
                SUM(f181to210) f181to210,
                SUM(f211to360) f211to360,
                SUM(f360) f360
            FROM (
                SELECT agrn.supplier_no_fk,
                    supp.supplier_uid,
                    supp.supplier_name sup_name,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 1 AND 30 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f1to30,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 31 AND 60 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f31to60,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 61 AND 90 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f61to90,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 91 AND 120 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f91to120,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 121 AND 150 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f121to150,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 151 AND 180 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f151to180,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 181 AND 210 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f181to210,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) BETWEEN 211 AND 360 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f211to360,
                    CASE WHEN TRUNC(SYSDATE) - TRUNC(approval_date) > 360 THEN grnmst_amnt - NVL(pay_amt, 0) ELSE 0 END f360
                FROM inv_accbillprocessdtl agrn
                JOIN phr_itemreceivemst grn ON agrn.itemreceive_no_fk = grn.itemreceive_no_pk
                JOIN inv_supplier supp ON agrn.supplier_no_fk = supp.supplier_no_pk
                LEFT JOIN (
                    SELECT NVL(SUM(grn_amt + NVL(paymentdtl_vat,0) + NVL(paymentdtl_tax,0)),0) pay_amt, itemreceive_no_fk
                    FROM inv_accsupplierpaymentdtl
                    GROUP BY itemreceive_no_fk
                ) paydtl ON agrn.itemreceive_no_fk = paydtl.itemreceive_no_fk
                WHERE grnmst_amnt > NVL(pay_amt,0)
                {$supplierFilter}
            )
            GROUP BY supplier_no_fk, supplier_uid, sup_name
            ORDER BY sup_name
        ";

        return DB::select($query);
    }


    public function ageingSupplierReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $type = $request->hdn_report_type;
        $date = $request->input('date', date('d/m/Y'));
        $supplierId = $request->input('supplier_id');

        $dateArray = explode('/', $date);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

        $report_data_raw = $this->getAgeingSupplierData($formattedDate, $supplierId);

        $report_data = [];
        if (!empty($report_data_raw)) {
            foreach ($report_data_raw as $data) {
                $report_data[] = (object)[
                    'supplier_uid' => $data->supplier_uid ?? 'N/A',
                    'sup_name' => $data->sup_name ?? 'N/A',
                    'f1to30' => (float)($data->f1to30 ?? 0),
                    'f31to60' => (float)($data->f31to60 ?? 0),
                    'f61to90' => (float)($data->f61to90 ?? 0),
                    'f91to120' => (float)($data->f91to120 ?? 0),
                    'f121to150' => (float)($data->f121to150 ?? 0),
                    'f151to180' => (float)($data->f151to180 ?? 0),
                    'f181to210' => (float)($data->f181to210 ?? 0),
                    'f211to360' => (float)($data->f211to360 ?? 0),
                    'f360' => (float)($data->f360 ?? 0),
                ];
            }
        }

        $params = [
            'report_data' => $report_data,
            'report_date' => $formattedDate,
            'po_hospital_details' => $po_hospital_details,
            'supplier_id' => $supplierId,
        ];

        if ($type === 'PDF') {
            $pdf = PDF::loadView("admin.reports.ageing.ageing_supplier_report_pdf", $params)
                ->setPaper('a4', 'landscape');
            return $pdf->stream('ageing_supplier_report.pdf');
        }

        if ($type === 'EXCEL') {
            $fileToExport = "Ageing_Supplier_Report_" . str_replace('/', '_', $params['report_date']);
            $html = View("admin.reports.ageing.ageing_supplier_report_pdf")->with($params);
            return response($html)
                ->header("Content-Disposition", "attachment; filename={$fileToExport}.xls")
                ->header("Content-Type", "application/vnd.ms-excel");
        }

        return back()->with('error', 'Invalid report type selected.');
    }






    // ageing summary report
    public function ageingSummaryReport()
    {
        $patient_types = DB::table('patient_type_vw')
            ->select('patient_type_no_pk', 'patient_type_desc')
            ->orderBy('patient_type_desc', 'asc')
            ->get();

        return Template::loadView("admin.reports.ageing.ageing_summary_reports", [
            'patient_types' => $patient_types
        ]);
    }

    public function ageingSummaryReportSearch(Request $request)
    {
        $date = $request->input('date');
        $patientType = $request->input('patient_type');

        $dateArray = explode('/', $date);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

        // Fetch filtered data
        $reportData = $this->getAgeingSummaryData($formattedDate, $patientType);

        return view('admin.reports.ageing.ageing_summary_report_data', [
            'report_data' => $reportData,
            'report_date' => $date,
            'patient_type' => $patientType,
        ]);
    }

    private function getAgeingSummaryData($date = null, $patientType = null)
    {
        $formattedDate = date('d/m/Y', strtotime($date ?? now()));

        $query = "
            SELECT
                pat_type,
                SUM(one_mon) AS \"1-30\",
                SUM(two_mon) AS \"31-60\",
                SUM(three_mon) AS \"61-90\",
                SUM(four_mon) AS \"91-120\",
                SUM(five_mon) AS \"121-150\",
                SUM(six_mon) AS \"151-180\",
                SUM(seven_mon) AS \"181-210\",
                SUM(eight_mon) AS \"211-365\",
                SUM(nine_mon) AS \">365\"
            FROM (
                -- OPD / Non-admission invoices
                SELECT
                    NVL(PATIENT_TYPE_DESC, 'Unknown') AS pat_type,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 1 AND 30 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS one_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 31 AND 60 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS two_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 61 AND 90 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS three_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 91 AND 120 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS four_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 121 AND 150 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS five_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 151 AND 180 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS six_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 181 AND 210 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS seven_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 211 AND 365 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS eight_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) >= 366 THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) AS nine_mon
                FROM FINC_INVOICEMST MST
                JOIN FINC_LEDGERMST LMST ON MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                LEFT JOIN PATIENT_TYPE_VW TYP ON MST.PAT_TYPE_LOOKUP_NO_FK = TYP.PATIENT_TYPE_NO_PK
                WHERE TRUNC(INVOICE_DATE) <= TO_DATE(:report_date, 'dd/mm/yyyy')
                AND NVL(MST.ADMISSION_NO_PK, 0) = 0
                AND LEDGER_AMT_SALES > LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT
                GROUP BY NVL(PATIENT_TYPE_DESC, 'Unknown')

                UNION ALL

                -- IPD / Discharged patients dues
                SELECT
                    pat_type,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 1 AND 30 THEN due ELSE 0 END) AS one_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 31 AND 60 THEN due ELSE 0 END) AS two_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 61 AND 90 THEN due ELSE 0 END) AS three_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 91 AND 120 THEN due ELSE 0 END) AS four_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 121 AND 150 THEN due ELSE 0 END) AS five_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 151 AND 180 THEN due ELSE 0 END) AS six_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 181 AND 210 THEN due ELSE 0 END) AS seven_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) BETWEEN 211 AND 365 THEN due ELSE 0 END) AS eight_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(dis_date) >= 366 THEN due ELSE 0 END) AS nine_mon
                FROM (
                    SELECT
                        NVL(PATIENT_TYPE_DESC, 'Unknown') AS pat_type,
                        SUM(LEDGER_AMT_SALES) - (SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT)) AS due,
                        AMD.ADMISSION_NO_PK,
                        TRUNC(DIS_DATE) AS dis_date
                    FROM FINC_INVOICEMST MST
                    JOIN FINC_LEDGERMST LMST ON MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                    LEFT JOIN PATIENT_TYPE_VW TYP ON MST.PAT_TYPE_LOOKUP_NO_FK = TYP.PATIENT_TYPE_NO_PK
                    JOIN IPD_ADMISSION AMD ON MST.ADMISSION_NO_PK = AMD.ADMISSION_NO_PK
                    WHERE TRUNC(DIS_DATE) <= TO_DATE(:report_date, 'dd/mm/yyyy')
                    AND DIS_IND = 1
                    GROUP BY NVL(PATIENT_TYPE_DESC, 'Unknown'), AMD.ADMISSION_NO_PK, TRUNC(DIS_DATE)
                    HAVING SUM(LEDGER_AMT_SALES) > SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT)
                    AND SUM(LEDGER_AMT_SALES) - (SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT)) > 5
                )
                GROUP BY pat_type
            )
            GROUP BY pat_type
            ORDER BY pat_type
        ";

        $bindings = ['report_date' => $formattedDate];

        if (!empty($patientType)) {
            $query = "SELECT * FROM ($query) WHERE UPPER(pat_type) LIKE UPPER(:patient_type)";
            $bindings['patient_type'] = '%' . $patientType . '%';
        }

        return DB::select($query, $bindings);
    }

    public function ageingSummaryReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $type = $request->hdn_report_type;

        $date = $request->input('date');
        $patientType = $request->input('patient_type');
        $dateArray = explode('/', $date);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

        $report_data = $this->getAgeingSummaryData($formattedDate, $patientType);

        $ageing_data = [];
        foreach ($report_data as $data) {
            $ageing_data[$data->pat_type] = [
                (float)$data->{'1-30'},
                (float)$data->{'31-60'},
                (float)$data->{'61-90'},
                (float)$data->{'91-120'},
                (float)$data->{'121-150'},
                (float)$data->{'151-180'},
                (float)$data->{'181-210'},
                (float)$data->{'211-365'},
                (float)$data->{'>365'},
            ];
        }

        $params = [
            'report_data' => $ageing_data,
            'report_date' => $formattedDate,
            'po_hospital_details' => $po_hospital_details,
        ];

        if ($type === 'PDF') {
            $pdf = PDF::loadView("admin.reports.ageing.ageing_summary_report_pdf", $params)
                ->setPaper('a4', 'landscape');
            return $pdf->stream('ageing_summary_report.pdf');
        }

        if ($type === 'EXCEL') {
            $fileToExport = "Ageing_Summary_Report_" . str_replace('/', '_', $params['report_date']);
            $html = View("admin.reports.ageing.ageing_summary_report_pdf")->with($params);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }

        return back()->with('error', 'Invalid report type selected.');
    }
    // end ageing summary report




    // AGEING BY DEBTOR REPORT
    public function ageingByDebtorReport()
    {
         $patient_types = DB::table('patient_type_vw')
            ->select('patient_type_no_pk', 'patient_type_desc')
            ->orderBy('patient_type_desc', 'asc')
            ->get();

        return Template::loadView("admin.reports.ageing.ageing_by_debtor_reports", [
            'patient_types' => $patient_types
        ]);
    }


    public function ageingByDebtorReportSearch(Request $request)
    {
        $date = $request->input('date');
        $patientType = $request->input('patient_type');
        $debtorId = $request->input('debtor_id');
        if (empty($date)) {
            return response()->json(['error' => 'Date is required.'], 422);
        }
        $dateArray = explode('/', $date);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
        $reportData = $this->getAgeingByDebtorData($formattedDate, $patientType, $debtorId);
        if (empty($reportData)) {
            return '<div class="alert alert-warning text-center">No records found for the selected filters.</div>';
        }
        return view('admin.reports.ageing.ageing_by_debtor_report_data', [
            'report_data' => $reportData,
            'report_date' => $date,
            'patient_type' => $patientType,
        ]);
    }


    private function getAgeingByDebtorData($date = null, $patientType = null)
    {
        $formattedDate = date('d/m/Y', strtotime($date ?? now()));

        $query = "
            SELECT
                pat_type,
                CCM_CLIENT_NAME,
                SUM(one_mon) AS \"1-30\",
                SUM(two_mon) AS \"31-60\",
                SUM(three_mon) AS \"61-90\",
                SUM(four_mon) AS \"91-120\",
                SUM(five_mon) AS \"121-150\",
                SUM(six_mon) AS \"151-180\",
                SUM(seven_mon) AS \"181-210\",
                SUM(eight_mon) AS \"211-365\",
                SUM(nine_mon) AS \">365\"
            FROM (
                -- OPD / Non-admission invoices
                SELECT
                    NVL(PATIENT_TYPE_DESC, 'Unknown') pat_type,
                    COR.CCM_CLIENT_NAME,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 1 AND 30
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) one_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 31 AND 60
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) two_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 61 AND 90
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) three_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 91 AND 120
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) four_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 121 AND 150
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) five_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 151 AND 180
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) six_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 181 AND 210
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) seven_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) BETWEEN 211 AND 365
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) eight_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(INVOICE_DATE) >= 366
                        THEN LEDGER_AMT_SALES - (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT) ELSE 0 END) nine_mon
                FROM FINC_INVOICEMST MST
                JOIN FINC_LEDGERMST LMST ON MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                LEFT JOIN PATIENT_TYPE_VW TYP ON MST.PAT_TYPE_LOOKUP_NO_FK = TYP.PATIENT_TYPE_NO_PK
                LEFT JOIN PATN_REGISTRATION PAT ON MST.PATIENT_NO_FK = PAT.PATIENT_NO_PK
                LEFT JOIN CCM_CORPORATECLIENT COR ON PAT.CCM_CLIENT_NO_FK = COR.CCM_CLIENT_NO_PK
                WHERE TRUNC(INVOICE_DATE) <= TO_DATE(:report_date, 'dd/mm/yyyy')
                    AND NVL(MST.ADMISSION_NO_PK, 0) = 0
                    AND LEDGER_AMT_SALES > (LEDGER_AMT_DISCOUNT + LEDGER_AMT_PAYMENT)
                GROUP BY NVL(PATIENT_TYPE_DESC, 'Unknown'), COR.CCM_CLIENT_NAME

                UNION

                -- IPD / Admission invoices
                SELECT
                    pat_type,
                    CCM_CLIENT_NAME,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 1 AND 30 THEN due ELSE 0 END) one_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 31 AND 60 THEN due ELSE 0 END) two_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 61 AND 90 THEN due ELSE 0 END) three_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 91 AND 120 THEN due ELSE 0 END) four_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 121 AND 150 THEN due ELSE 0 END) five_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 151 AND 180 THEN due ELSE 0 END) six_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 181 AND 210 THEN due ELSE 0 END) seven_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) BETWEEN 211 AND 365 THEN due ELSE 0 END) eight_mon,
                    SUM(CASE WHEN TRUNC(SYSDATE) - TRUNC(DIS_DATE) >= 366 THEN due ELSE 0 END) nine_mon
                FROM (
                    SELECT
                        NVL(PATIENT_TYPE_DESC, 'Unknown') pat_type,
                        COR.CCM_CLIENT_NAME,
                        SUM(LEDGER_AMT_SALES) - (SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT)) AS due,
                        AMD.ADMISSION_NO_PK,
                        TRUNC(DIS_DATE) DIS_DATE
                    FROM FINC_INVOICEMST MST
                    JOIN FINC_LEDGERMST LMST ON MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                    LEFT JOIN PATIENT_TYPE_VW TYP ON MST.PAT_TYPE_LOOKUP_NO_FK = TYP.PATIENT_TYPE_NO_PK
                    JOIN IPD_ADMISSION AMD ON MST.ADMISSION_NO_PK = AMD.ADMISSION_NO_PK
                    LEFT JOIN CCM_CORPORATECLIENT COR ON AMD.CCM_CLIENT_NO_FK = COR.CCM_CLIENT_NO_PK
                    WHERE TRUNC(DIS_DATE) <= TO_DATE(:report_date, 'dd/mm/yyyy')
                        AND DIS_IND = 1
                    GROUP BY NVL(PATIENT_TYPE_DESC, 'Unknown'), AMD.ADMISSION_NO_PK, TRUNC(DIS_DATE), COR.CCM_CLIENT_NAME
                    HAVING SUM(LEDGER_AMT_SALES) > (SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT))
                        AND SUM(LEDGER_AMT_SALES) - (SUM(LEDGER_AMT_DISCOUNT) + SUM(LEDGER_AMT_PAYMENT)) > 5
                )
                GROUP BY pat_type, CCM_CLIENT_NAME
            )
            GROUP BY pat_type, CCM_CLIENT_NAME
            ORDER BY pat_type, CCM_CLIENT_NAME
        ";

        $bindings = ['report_date' => $formattedDate];
        if (!empty($patientType)) {
            $query = "SELECT * FROM ($query) WHERE UPPER(pat_type) LIKE UPPER(:patient_type)";
            $bindings['patient_type'] = '%' . $patientType . '%';
        }

        return DB::select($query, $bindings);
    }

    public function ageingByDebtorReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $type = $request->hdn_report_type;

        $date = $request->input('date', date('d/m/Y'));
        $patientType = $request->input('patient_type');

        $dateArray = explode('/', $date);
        $formattedDate = $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];

        $report_data_raw = $this->getAgeingByDebtorData($formattedDate, $patientType);

        $report_data = [];
        if (!empty($report_data_raw)) {
            foreach ($report_data_raw as $data) {
                $report_data[] = (object)[
                    'pat_type' => $data->pat_type,
                    'ccm_client_name' => $data->ccm_client_name ?? 'N/A',
                    '1-30' => (float) ($data->{'1-30'} ?? 0),
                    '31-60' => (float) ($data->{'31-60'} ?? 0),
                    '61-90' => (float) ($data->{'61-90'} ?? 0),
                    '91-120' => (float) ($data->{'91-120'} ?? 0),
                    '121-150' => (float) ($data->{'121-150'} ?? 0),
                    '151-180' => (float) ($data->{'151-180'} ?? 0),
                    '181-210' => (float) ($data->{'181-210'} ?? 0),
                    '211-365' => (float) ($data->{'211-365'} ?? 0),
                    '>365' => (float) ($data->{'>365'} ?? 0),
                ];
            }
        }

        $params = [
            'report_data' => $report_data,
            'report_date' => $formattedDate,
            'po_hospital_details' => $po_hospital_details,
            'patient_type' => $patientType,
        ];

        if ($type === 'PDF') {
            $pdf = PDF::loadView("admin.reports.ageing.ageing_by_debtor_report_pdf", $params)
                ->setPaper('a4', 'landscape');
            return $pdf->stream('ageing_by_debtor_report.pdf');
        }

        if ($type === 'EXCEL') {
            $fileToExport = "Ageing_By_Debtor_Report_" . str_replace('/', '_', $params['report_date']);
            $html = View("admin.reports.ageing.ageing_by_debtor_report_pdf")->with($params);
            return response($html)
                ->header("Content-Disposition", "attachment; filename={$fileToExport}.xls")
                ->header("Content-Type", "application/vnd.ms-excel");
        }

        return back()->with('error', 'Invalid report type selected.');
    }


    // end AGEING BY DEBTOR REPORT

    // SALES REPORT
    public function salesReport()
    {
        return Template::loadView("admin.reports.sales.sales_reports", [
            'report_data' => []
        ]);
    }

    public function salesReportSearch(Request $request)
    {
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $report_data = DB::select("
            SELECT
                patient_no_pk,
                patient_code,
                patient_name,
                SUM(op_count) AS op_count,
                SUM(op_sales) AS op_sales,
                SUM(ip_count) AS ip_count,
                SUM(ip_sales) AS ip_sales
            FROM (
                SELECT
                    patient_no_pk,
                    pat.patient_code,
                    pat.patient_name,
                    COUNT(DISTINCT mst.invoice_no_pk) AS op_count,
                    0 AS ip_count,
                    SUM(ledger_amt_sales - ledger_amt_discount) AS op_sales,
                    0 AS ip_sales
                FROM finc_invoicemst mst
                    JOIN finc_ledgermst lmst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN patn_registration pat ON mst.patient_no_fk = pat.patient_no_pk
                WHERE TRUNC(ledger_date) BETWEEN TO_DATE(?, 'dd/mm/yyyy') AND TO_DATE(?, 'dd/mm/yyyy')
                AND NVL(mst.admission_no_pk, 0) = 0
                GROUP BY patient_no_pk, pat.patient_code, pat.patient_name

                UNION ALL

                SELECT
                    patient_no_pk,
                    pat.patient_code,
                    pat.patient_name,
                    0 AS op_count,
                    COUNT(DISTINCT mst.admission_no_pk) AS ip_count,
                    0 AS op_sales,
                    SUM(ledger_amt_sales) - SUM(ledger_amt_discount) AS ip_sales
                FROM finc_invoicemst mst
                    JOIN finc_ledgermst lmst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN ipd_admission amd ON mst.admission_no_pk = amd.admission_no_pk
                    JOIN patn_registration pat ON mst.patient_no_fk = pat.patient_no_pk
                WHERE TRUNC(dis_date) BETWEEN TO_DATE(?, 'dd/mm/yyyy') AND TO_DATE(?, 'dd/mm/yyyy')
                AND dis_ind = 1
                GROUP BY patient_no_pk, pat.patient_code, pat.patient_name
            )
            GROUP BY patient_no_pk, patient_code, patient_name
            ORDER BY patient_name ASC
        ", [$date_from, $date_to, $date_from, $date_to]);

        // dd($report_data);
        return Template::loadView("admin.reports.sales.sales_report_data", [
            'report_data' => $report_data
        ]);
    }

    public function salesReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")
            ->where('AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $type = $request->input('hdn_report_type');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $report_data_raw = DB::select("
            SELECT
                patient_no_pk,
                patient_code,
                patient_name,
                SUM(op_count) AS op_count,
                SUM(op_sales) AS op_sales,
                SUM(ip_count) AS ip_count,
                SUM(ip_sales) AS ip_sales
            FROM (
                SELECT
                    patient_no_pk,
                    pat.patient_code,
                    pat.patient_name,
                    COUNT(DISTINCT mst.invoice_no_pk) AS op_count,
                    0 AS ip_count,
                    SUM(ledger_amt_sales - ledger_amt_discount) AS op_sales,
                    0 AS ip_sales
                FROM finc_invoicemst mst
                    JOIN finc_ledgermst lmst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN patn_registration pat ON mst.patient_no_fk = pat.patient_no_pk
                WHERE TRUNC(ledger_date) BETWEEN TO_DATE(?, 'dd/mm/yyyy') AND TO_DATE(?, 'dd/mm/yyyy')
                AND NVL(mst.admission_no_pk, 0) = 0
                GROUP BY patient_no_pk, pat.patient_code, pat.patient_name

                UNION ALL

                SELECT
                    patient_no_pk,
                    pat.patient_code,
                    pat.patient_name,
                    0 AS op_count,
                    COUNT(DISTINCT mst.admission_no_pk) AS ip_count,
                    0 AS op_sales,
                    SUM(ledger_amt_sales) - SUM(ledger_amt_discount) AS ip_sales
                FROM finc_invoicemst mst
                    JOIN finc_ledgermst lmst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN ipd_admission amd ON mst.admission_no_pk = amd.admission_no_pk
                    JOIN patn_registration pat ON mst.patient_no_fk = pat.patient_no_pk
                WHERE TRUNC(dis_date) BETWEEN TO_DATE(?, 'dd/mm/yyyy') AND TO_DATE(?, 'dd/mm/yyyy')
                AND dis_ind = 1
                GROUP BY patient_no_pk, pat.patient_code, pat.patient_name
            )
            GROUP BY patient_no_pk, patient_code, patient_name
            ORDER BY patient_name ASC
        ", [$date_from, $date_to, $date_from, $date_to]);

        $report_data = [];
        if (!empty($report_data_raw)) {
            foreach ($report_data_raw as $data) {
                $report_data[] = (object)[
                    'patient_no_pk' => $data->patient_no_pk,
                    'patient_code' => $data->patient_code,
                    'patient_name' => trim($data->patient_name ?? 'N/A'),
                    'op_count'     => (int) ($data->op_count ?? 0),
                    'op_sales'     => (float) ($data->op_sales ?? 0),
                    'ip_count'     => (int) ($data->ip_count ?? 0),
                    'ip_sales'     => (float) ($data->ip_sales ?? 0),
                ];
            }
        }

        $params = [
            'report_data' => $report_data,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details,
        ];

        if ($type === 'PDF') {
            $pdf = PDF::loadView("admin.reports.sales.sales_report_pdf", $params)
                ->setPaper('a4', 'portrait');
            return $pdf->stream('sales_report.pdf');
        }

        if ($type === 'EXCEL') {
            $fileToExport = "Sales_Report_" . str_replace('/', '_', $date_from) . "_to_" . str_replace('/', '_', $date_to);
            $html = View("admin.reports.sales.sales_report_pdf")->with($params);
            return response($html)
                ->header("Content-Disposition", "attachment; filename={$fileToExport}.xls")
                ->header("Content-Type", "application/vnd.ms-excel");
        }

        return back()->with('error', 'Invalid report type selected.');
    }

    // END SALES REPORT


    //    Department Wise IPD Reports
    public function deptWiseIpdReport($type = '')
    {
        return Template::loadView("admin.reports.dept.dept_wise_ipd_reports");
    }
    public function deptWiseIpdReportSearch(Request $request)
    {
        $date = $request->date;
        $report_data = DB::select("  SELECT fnc_serviceunitname (serviceunit_no_fk) department,
         SUM (
            CASE
               WHEN TRUNC (admission_date) =
                       TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            admitted_patient,
         SUM (
            CASE
               WHEN TRUNC (admission_date) <
                       TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            previous_patient,
         SUM (
            CASE
               WHEN TRUNC (dis_date) = TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            discharge_patient,
         SUM (
            CASE
               WHEN TRUNC (admission_date) <=
                       TO_DATE ('$date', 'dd/mm/yyyy')
                    AND TRUNC (NVL (dis_date, SYSDATE +1)) >
                           TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            current_patient
    FROM ipd_admission ipd,
         patn_registration reg,
         patn_patienttype TYPE,
         hrms_personnel docdept
   WHERE     ipd.patient_no_fk = reg.patient_no_pk
         AND reg.patient_type = TYPE.PATIENT_TYPE_NO_PK
         AND ipd.PRIMARY_DOCTOR_NO_FK = docdept.PERSON_NO_PK
         AND TRUNC (admission_date) <= TO_DATE ('$date', 'dd/mm/yyyy')
         AND TRUNC (NVL (dis_date, SYSDATE)) >=
                TO_DATE ('$date', 'dd/mm/yyyy')
         AND EMERGENCY_DAYCARE_IND_TXT IS NULL
GROUP BY serviceunit_no_fk
ORDER BY 1");
        // dd($report_data);
        $dept = [];
        foreach ($report_data as $data) {
            $dept[$data->department][] = $data;
        }
        return Template::loadView("admin.reports.dept.dept_wise_ipd_report_data", ['report_data' => $report_data, 'dept' => $dept]);
    }
    public function deptWiseIpdReportPdf(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $type = $request->hdn_report_type;
        $date = $request->date;
        $from_date = '$request->date';
        $report_data = DB::select("  SELECT fnc_serviceunitname (serviceunit_no_fk) department,
         SUM (
            CASE
               WHEN TRUNC (admission_date) =
                       TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            admitted_patient,
         SUM (
            CASE
               WHEN TRUNC (admission_date) <
                       TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            previous_patient,
         SUM (
            CASE
               WHEN TRUNC (dis_date) = TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            discharge_patient,
         SUM (
            CASE
               WHEN TRUNC (admission_date) <=
                       TO_DATE ('$date', 'dd/mm/yyyy')
                    AND TRUNC (NVL (dis_date, SYSDATE +1)) >
                           TO_DATE ('$date', 'dd/mm/yyyy')
               THEN
                  1
               ELSE
                  0
            END)
            current_patient
    FROM ipd_admission ipd,
         patn_registration reg,
         patn_patienttype TYPE,
         hrms_personnel docdept
   WHERE     ipd.patient_no_fk = reg.patient_no_pk
         AND reg.patient_type = TYPE.PATIENT_TYPE_NO_PK
         AND ipd.PRIMARY_DOCTOR_NO_FK = docdept.PERSON_NO_PK
         AND TRUNC (admission_date) <= TO_DATE ('$date', 'dd/mm/yyyy')
         AND TRUNC (NVL (dis_date, SYSDATE)) >=
                TO_DATE ('$date', 'dd/mm/yyyy')
         AND EMERGENCY_DAYCARE_IND_TXT IS NULL
GROUP BY serviceunit_no_fk
ORDER BY 1");
        $dept = [];
        foreach ($report_data as $data) {
            $dept[$data->department][] = $data;
        }
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if ($type == 'PDF') {
            $pdf = PDF::loadView("admin.reports.dept.dept_wise_ipd_patient", [
                'dept' => $dept,
                'date_data' => $date,
                'po_hospital_details' =>
                $po_hospital_details,
                'barcode_no' => $barcode_no,
                'report_data' => $report_data
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('dept_wise_ipd_patient.pdf');
        }
        if ($type == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'dept' => $dept,
                'date_data' => $date,
                'po_hospital_details' =>
                $po_hospital_details,
                'barcode_no' => $barcode_no,
                'report_data' => $report_data
            ];
            $fileToExport = "Dept_wise_report_excel";
            $html = View("admin.reports.dept.dept_wise_ipd_patient")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }


    //inter report


    public function interpartmentalReport()
    {
        return Template::loadview("admin.reports.interdepartmental.interdepartmental");
    }
    public function interpartmentalReportSearch(Request $request)
    {
        //    return $request->date_from;

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_interdepartmentalreferral_vw $sql_cond");


        return Template::loadView("admin.reports.interdepartmental.interdepartmental_search_data", ['report_data' => $report_data]);
    }

    public function interpartmentalReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("select * from finc_interdepartmentalreferral_vw $sql_cond");


        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.interdepartmental.interdepartmental_pdf", [
            'report_data' => $report_data,
            'barcode_no' => $barcode_no,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('interdepartmental-report.pdf');
    }


    //inter report


    public function itemTypeReport()
    {
        return Template::loadview("admin.reports.item_type.item_type_report", ['item_type' => '']);
    }
    public function itemTypeReportSearch(Request $request)
    {

        if ($request->item_type == 2) {
            $doctor_id = $request->card_hidn;

            if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

                $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
                $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

            } else {
                $date_from = "";
                $date_to = "";
            }

            $sql_cond = "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(finalize_keyed_time) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($doctor_id != "") ? " $clause finalize_keyed_by = $doctor_id" : "";

            $report_data = DB::select("   SELECT finalize_keyed_by,
         fnc_empname (finalize_keyed_by) finalize_by,
         COUNT (1) no_of_test,
         fnc_serviceunitname (serviceunit_no_fk) deparment,
         SUM (item_rate * (item_qty - NVL (cancel_qty, 0))) sales
    FROM radt_invoicedtl dtl, sysc_serviceitem item, finc_invoicedtl inv
   WHERE     finalize_key_ind = 1
         AND dtl.item_no_fk = item.item_no_pk
         AND inv.invoice_no_fk = dtl.invoice_no_fk
         AND inv.item_no_fk = dtl.item_no_fk and finalize_keyed_by <> 0
        $sql_cond
GROUP BY finalize_keyed_by, serviceunit_no_fk");
        } else {
            $doctor_id = $request->card_hidn;

            if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

                $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
                $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

            } else {
                $date_from = "";
                $date_to = "";
            }

            $sql_cond = "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(lab_result_final_keyed_time) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($doctor_id != "") ? " $clause lab_result_final_keyed_by = $doctor_id" : "";

            $report_data = DB::select("  SELECT
            LAB_RESULT_FINAL_KEYED_BY finalize_keyed_by,
            fnc_empname (LAB_RESULT_FINAL_KEYED_BY) finalize_by,
            COUNT (1) no_of_test,
            fnc_serviceunitname (serviceunit_no_fk) deparment
       FROM LABT_INVOICEDTL dtl, sysc_serviceitem item
      WHERE LAB_RESULT_FINAL_KEY_IND = 1 AND dtl.item_no_fk = item.item_no_pk
            $sql_cond
   GROUP BY LAB_RESULT_FINAL_KEYED_BY, serviceunit_no_fk");
        }


        return Template::loadView("admin.reports.item_type.item_type_report_data", ['date_from' => $date_from, 'date_to' => $date_to, 'report_data' => $report_data, 'item_type' => $request->item_type]);
    }

    public function itemTypeReportDetails($to_date, $from_date, $person_no_pk, $item_type, $dept)
    {

        if ($item_type == 2) {
            $report_data = DB::select("     SELECT finalize_keyed_by,
            fnc_empname (finalize_keyed_by) finalize_by,
            COUNT (1) no_of_test,inv.item_name,
            SUM (item_rate * (item_qty - NVL (cancel_qty, 0))) sales, fnc_serviceunitname (serviceunit_no_fk) deparment
            FROM radt_invoicedtl dtl, sysc_serviceitem item, finc_invoicedtl inv
            WHERE     finalize_key_ind = 1
                    AND dtl.item_no_fk = item.item_no_pk
                    AND inv.invoice_no_fk = dtl.invoice_no_fk
                    AND inv.item_no_fk = dtl.item_no_fk
                    AND finalize_keyed_by <> 0 and trunc(finalize_keyed_time) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY') and finalize_keyed_by = $person_no_pk AND fnc_serviceunitname (serviceunit_no_fk) = '$dept'
        GROUP BY finalize_keyed_by,inv.item_name, serviceunit_no_fk");
        } else {
            $report_data = DB::select("  SELECT LAB_RESULT_FINAL_KEYED_BY as finalize_keyed_by,
            fnc_empname (LAB_RESULT_FINAL_KEYED_BY) finalize_by,
            COUNT (1) no_of_test,
            ITEM.ITEM_NAME, fnc_serviceunitname (serviceunit_no_fk) deparment
       FROM LABT_INVOICEDTL dtl, sysc_serviceitem item
      WHERE LAB_RESULT_FINAL_KEY_IND = 1 AND dtl.item_no_fk = item.item_no_pk and trunc(lab_result_final_keyed_time) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')
      and lab_result_final_keyed_by = $person_no_pk AND fnc_serviceunitname (serviceunit_no_fk) = '$dept'
   GROUP BY LAB_RESULT_FINAL_KEYED_BY, ITEM.ITEM_NAME, serviceunit_no_fk");
        }
        return Template::loadView("admin.reports.item_type.item_type_report_data_details", ['from_date' => $from_date, 'to_date' => $to_date, 'report_data' => $report_data, 'item_type' => $item_type]);
    }

    public function itemTypeReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if ($request->item_type == 2) {
            $doctor_id = $request->card_hidn;

            if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

                $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
                $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

            } else {
                $date_from = "";
                $date_to = "";
            }

            $sql_cond = "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(finalize_keyed_time) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($doctor_id != "") ? " $clause finalize_keyed_by = $doctor_id" : "";

            $report_data = DB::select("    SELECT finalize_keyed_by,
         fnc_empname (finalize_keyed_by) finalize_by,
         COUNT (1) no_of_test,
         fnc_serviceunitname (serviceunit_no_fk) deparment,
         SUM (item_rate * (item_qty - NVL (cancel_qty, 0))) sales
    FROM radt_invoicedtl dtl, sysc_serviceitem item, finc_invoicedtl inv
   WHERE     finalize_key_ind = 1
         AND dtl.item_no_fk = item.item_no_pk
         AND inv.invoice_no_fk = dtl.invoice_no_fk
         AND inv.item_no_fk = dtl.item_no_fk and finalize_keyed_by <> 0
        $sql_cond
GROUP BY finalize_keyed_by, serviceunit_no_fk");
        } else {
            $doctor_id = $request->card_hidn;

            if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

                $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
                $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

            } else {
                $date_from = "";
                $date_to = "";
            }

            $sql_cond = "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(lab_result_final_keyed_time) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($doctor_id != "") ? " $clause lab_result_final_keyed_by = $doctor_id" : "";

            $report_data = DB::select("  SELECT
            LAB_RESULT_FINAL_KEYED_BY,
            fnc_empname (LAB_RESULT_FINAL_KEYED_BY) finalize_by,
            COUNT (1) no_of_test,
            fnc_serviceunitname (serviceunit_no_fk) deparment
       FROM LABT_INVOICEDTL dtl, sysc_serviceitem item
      WHERE LAB_RESULT_FINAL_KEY_IND = 1 AND dtl.item_no_fk = item.item_no_pk
            $sql_cond
   GROUP BY LAB_RESULT_FINAL_KEYED_BY, serviceunit_no_fk");
        }
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();




        if ($request->hdn_report_type == 'PDF') {

            $pdf = PDF::loadView("admin.reports.item_type.item_type_report_pdf", [
                'report_data' => $report_data,
                'barcode_no' => $barcode_no,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'po_hospital_details' => $po_hospital_details,
                'item_type' => $request->item_type
            ])->setPaper('a4', 'landscape');
            return $pdf->download('item-type-report.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'report_data' => $report_data,
                'barcode_no' => $barcode_no,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'po_hospital_details' => $po_hospital_details,
                'item_type' => $request->item_type
            ];
            $fileToExport = "item_type_report";
            $html = View("admin.reports.item_type.item_type_report_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function billingRefundReport()
    {
        return Template::loadview("admin.reports.refund.billing-refund-due-report", [
            'type' => 'Refund'
        ]);
    }

    public function billingRefundDueReportSearch(Request $request)
    {
        $type = $request->type;
        $report_type = $request->report_type;
        if ($type == 'Due') {
            $ipd_admission = $request->ipd_add;
        }

        $date_from = $request->search_date_from;
        $date_to = $request->search_date_to;
        if (!empty($date_from) && !empty($date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        if ($type == 'Due') {
            $sql_cond_type = "";
            $clause_type = ($sql_cond_type == "") ? " where" : "and";
            if ($report_type == "IPD") {
                $clause = ($sql_cond == "") ? " where" : "and";
                $sql_cond .= ($ipd_admission != "") ? " $clause admission_no_pk = $ipd_admission" : "";
                $clause = ($sql_cond == "") ? " and" : " and";
                $sql_cond .= ($date_from != "") ? " $clause trunc(ipd.admission_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

                $sql_cond_type .= ($report_type != "") ? " $clause_type due > 0 AND finc.module_code = 'IPD'" : "";
            } else {
                $clause = ($sql_cond == "") ? " where" : "and";
                $sql_cond .= ($ipd_admission != "") ? " $clause admission_no_pk = $ipd_admission" : "";
                $clause = ($sql_cond == "") ? " and" : " and";
                $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


                $sql_cond_type .= ($report_type != "") ? " $clause_type due > 0 AND finc.module_code = 'OPD'" : "";
            }
        } else {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

            $sql_cond_type = "";
            $clause_type = ($sql_cond_type == "IPD") ? " where" : "where";
            $sql_cond_type .= ($report_type != "") ? " $clause_type refund > 0" : "";
        }




        if ($type == "Refund") {
            $report_data = db::select("select * from finc_inv_cancelbilling_list_vw $sql_cond_type  $sql_cond");
        } elseif ($type == "Due") {
            if ($report_type == "IPD") {
                $report_data = db::select("
            SELECT finc.admission_no_pk,
                   finc.customer_name,
                   SUM (finc.due) due,
                   finc.patient_code,
                   finc.patient_name,
                   finc.gender_txt,
                   ipd.age,
                   ipd.admission_date,
                   finc.mobile1
              FROM    finc_invoicemst_c022_sum_vw finc
                   left JOIN
                      ipd_admission ipd
                   ON finc.admission_no_pk = ipd.admission_no_pk
             $sql_cond_type
             $sql_cond
          GROUP BY finc.admission_no_pk,
                   finc.customer_name,
                   finc.patient_code,
                   finc.patient_name,
                   finc.gender_txt,
                   ipd.age,
                   ipd.admission_date,
                   finc.mobile1 order by  ipd.admission_date desc");
            } else {
                $report_data = db::select("SELECT invoice_code,finc.customer_name,
                    SUM (finc.due) due,
                    finc.patient_code,
                    finc.patient_name,
                    finc.gender_txt,
                    ipd.age,
                    invoice_date,
                    finc.mobile1
                FROM    finc_invoicemst_c022_sum_vw finc
                    LEFT JOIN
                        ipd_admission ipd
                    ON finc.admission_no_pk = ipd.admission_no_pk
                    $sql_cond_type  $sql_cond
            GROUP BY invoice_code,
                    finc.customer_name,
                    finc.patient_code,
                    finc.patient_name,
                    finc.gender_txt,
                    ipd.age,
                    invoice_date,
                    finc.mobile1");
            }
        }
        // dd($report_data);
        return Template::loadView("admin.reports.refund.billing-refund-due-list", ['report_data' => $report_data, 'type' => $type, 'report_type' => $report_type]);
    }

    public function billingRefundDueReportPdf(Request $request)
    {
        $type = $request->type;
        $report_type = $request->report_type;
        if ($type == 'Due') {
            $ipd_admission = $request->ipd_add;
        }

        $date_from = $request->search_date_from;
        $date_to = $request->search_date_to;
        if (!empty($date_from) && !empty($date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        if ($type == 'Due') {
            $sql_cond_type = "";
            $clause_type = ($sql_cond_type == "") ? " where" : "and";
            if ($report_type == "IPD") {
                $clause = ($sql_cond == "") ? " where" : "and";
                $sql_cond .= ($ipd_admission != "") ? " $clause admission_no_pk = $ipd_admission" : "";
                $clause = ($sql_cond == "") ? " and" : " and";
                $sql_cond .= ($date_from != "") ? " $clause trunc(ipd.admission_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

                $sql_cond_type .= ($report_type != "") ? " $clause_type due > 0 AND finc.module_code = 'IPD'" : "";
            } else {
                $clause = ($sql_cond == "") ? " where" : "and";
                $sql_cond .= ($ipd_admission != "") ? " $clause admission_no_pk = $ipd_admission" : "";
                $clause = ($sql_cond == "") ? " and" : " and";
                $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


                $sql_cond_type .= ($report_type != "") ? " $clause_type due > 0 AND finc.module_code = 'OPD'" : "";
            }
        } else {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

            $sql_cond_type = "";
            $clause_type = ($sql_cond_type == "IPD") ? " where" : "where";
            $sql_cond_type .= ($report_type != "") ? " $clause_type refund > 0" : "";
        }




        if ($type == "Refund") {
            $report_data = db::select("select * from finc_inv_cancelbilling_list_vw $sql_cond_type  $sql_cond");
        } elseif ($type == "Due") {
            if ($report_type == "IPD") {
                $report_data = db::select("
            SELECT finc.admission_no_pk,
                   finc.customer_name,
                   SUM (finc.due) due,
                   finc.patient_code,
                   finc.patient_name,
                   finc.gender_txt,
                   ipd.age,
                   ipd.admission_date,
                   finc.mobile1
              FROM    finc_invoicemst_c022_sum_vw finc
                   left JOIN
                      ipd_admission ipd
                   ON finc.admission_no_pk = ipd.admission_no_pk
             $sql_cond_type
             $sql_cond
          GROUP BY finc.admission_no_pk,
                   finc.customer_name,
                   finc.patient_code,
                   finc.patient_name,
                   finc.gender_txt,
                   ipd.age,
                   ipd.admission_date,
                   finc.mobile1 order by  ipd.admission_date desc");
            } else {
                $report_data = db::select("SELECT invoice_code,finc.customer_name,
                    SUM (finc.due) due,
                    finc.patient_code,
                    finc.patient_name,
                    finc.gender_txt,
                    ipd.age,
                    invoice_date,
                    finc.mobile1
                FROM    finc_invoicemst_c022_sum_vw finc
                    LEFT JOIN
                        ipd_admission ipd
                    ON finc.admission_no_pk = ipd.admission_no_pk
                    $sql_cond_type  $sql_cond
            GROUP BY invoice_code,
                    finc.customer_name,
                    finc.patient_code,
                    finc.patient_name,
                    finc.gender_txt,
                    ipd.age,
                    invoice_date,
                    finc.mobile1");
            }
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = '124526';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.refund.billing-refund-due-list-pdf", [
            'report_data' => $report_data,
            'po_hospital_details' => $po_hospital_details,
            'barcode_no' => $barcode_no,
            'report_type' => $report_type,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'type' => $type
        ]);
        return $pdf->download($type . '.pdf');
    }


    public function dueCollectionReport()
    {
        $ref_doctors = DB::table('wl_referral_list_vw')->select('person_no_pk', 'full_name')->get();
        return Template::loadView("admin.reports.due-collection-report", ['ref_doctors' => $ref_doctors]);
    }

    public function dueCollectionReportSearch(Request $request)
    {
        // return $request;
        $invoice_id = $request->invoice_id;
        $casher_id = $request->doctor_id;
        // dd($casher_id);
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($casher_id != "") ? " $clause person_no_fk = $casher_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause due_collection != 0";

        $report_data = DB::select("select * from finc_invocedetails_vw   $sql_cond order by ledger_date DESC");
        // dd($report_data);
        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.due-collection-report-table", ['report_data' => $report_data]);
    }

    public function dueCollectionReportPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $invoice_id = $request->invoice_id;
        $casher_id = $request->doctor_id;
        // dd($casher_id);
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($casher_id != "") ? " $clause person_no_fk = $casher_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause due_collection != 0";

        $report_data = DB::select("select * from finc_invocedetails_vw   $sql_cond order by ledger_date DESC");
        // dd($report_data);
        // foreach ($report_data as $row) {

        //     $title = $row->invoice_code;
        //     $barcode = new BarcodeGenerator();
        //     $barcode->setText($title);
        //     $barcode->setType(BarcodeGenerator::Code128);
        //     $barcode->setLabel('');
        //     $barcode->setScale(1);
        //     $barcode->setThickness(25);
        //     $barcode->setFontSize(10);
        //     $barcode_no = $barcode->generate();
        // }




        //  return view("admin.reports.financial.financial_print_pdf", [
        //     'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details

        // ]);




        $pdf = PDF::loadView("admin.reports.due-collection-report-pdf", [
            'report_data' => $report_data,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Due-Collection-Report.pdf');
    }



    public function referedReport()
    {
        return Template::loadView("admin.reports.referred.referred_doctor_item");
    }

    public function referedReportSearch(Request $request)
    {
        // return $request;
        $invoice_id = $request->invoice_id;
        $casher_id = $request->doctor_id;
        // dd($casher_id);
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($casher_id != "") ? " $clause person_no_fk = $casher_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause due_collection != 0";

        $report_data = DB::select("select * from finc_invocedetails_vw   $sql_cond order by ledger_date DESC");
        // dd($report_data);
        // echo  "SELECT invoice_no_fk, invoice_code, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw $sql_cond";

        return Template::loadView("admin.reports.referred.referred_doctor_item_list", ['report_data' => $report_data]);
    }

    public function referedReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        //    dd($po_hospital_details);
        //    dd($request->all());
        //    $report_data = DB::select("SELECT invoice_no_fk, invoice_code, TO_CHAR(invoice_date, 'DD-MON-RR') invc_date, patient_code, patient_name, age, gender_txt, mobile1, prescribed_physio_name, first_ref_doc_name, ledger_amt_sales, ledger_amt_discount, (ledger_amt_sales - ledger_amt_discount) net_payable, ledger_amt_payment,  ((ledger_amt_sales - ledger_amt_discount) - ledger_amt_payment) due, rownum rownumber, au_update_at, au_entry_at FROM finc_voucherwise_vw");
        $invoice_id = $request->invoice_id;
        $casher_id = $request->doctor_id;
        // dd($casher_id);
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($casher_id != "") ? " $clause person_no_fk = $casher_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause due_collection != 0";

        $report_data = DB::select("select * from finc_invocedetails_vw   $sql_cond order by ledger_date DESC");
        // dd($report_data);
        // foreach ($report_data as $row) {

        //     $title = $row->invoice_code;
        //     $barcode = new BarcodeGenerator();
        //     $barcode->setText($title);
        //     $barcode->setType(BarcodeGenerator::Code128);
        //     $barcode->setLabel('');
        //     $barcode->setScale(1);
        //     $barcode->setThickness(25);
        //     $barcode->setFontSize(10);
        //     $barcode_no = $barcode->generate();
        // }




        //  return view("admin.reports.financial.financial_print_pdf", [
        //     'report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details

        // ]);




        $pdf = PDF::loadView("admin.reports.due-collection-report-pdf", [
            'report_data' => $report_data,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'po_hospital_details' => $po_hospital_details
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Due-Collection-Report.pdf');
    }


    // Cashier Wise Summary Report
    public function cashierWiseSummaryReport()
    {
        return Template::loadview("admin.reports.cashier_wise_summary_report");
    }


    public function cashierWiseReportSummarySearch(Request $request)
    {
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        //  echo "select * from  FINC_C022_CASHIER_WISE_RPT_VW  $sql_cond ";


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $query = DB::select(DB::raw("  SELECT
        -- TRUNC (lmst.ledger_date) trans_date,
                    lmst.au_entry_by,
                    fnc_username (lmst.au_entry_by) cashier_name,
                    SUM (
                    CASE
                        WHEN TRUNC (lmst.ledger_date) = TRUNC (mst.INVOICE_DATE) THEN 1
                        ELSE 0
                    END)
                    new_invoice,
                    SUM (
                    CASE
                        WHEN TRUNC (lmst.ledger_date) <> TRUNC (mst.INVOICE_DATE) THEN 1
                        ELSE 0
                    END)
                    old_invoice,
                    SUM (CASE WHEN ledger_amt_sales > 0 THEN ledger_amt_sales ELSE 0 END)
                    sales,
                    SUM (CASE WHEN ledger_amt_sales < 0 THEN ledger_amt_sales ELSE 0 END)
                    salesr,
                    SUM (ledger_amt_discount) discount,
                    SUM (
                    CASE WHEN ledger_amt_payment > 0 THEN ledger_amt_payment ELSE 0 END)
                    collection,
                    SUM (
                    CASE WHEN ledger_amt_payment < 0 THEN ledger_amt_payment ELSE 0 END)
                    refund,
                    SUM (ledger_amt_payment) net_collection
            FROM finc_ledgermst lmst, finc_invoicemst mst
            WHERE lmst.invoice_no_fk = mst.invoice_no_pk
            $sql_cond
        GROUP BY lmst.au_entry_by
        ORDER BY 1 DESC"));

        return Template::loadview("admin.reports.cashier-wise-summary-search-data", [
            'data' => $query,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

    public function cashierWiseReportPrintSummary(Request $request)
    {

        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $doctor_id = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_pk = $doctor_id" : "";

        //  echo "select * from  FINC_C022_CASHIER_WISE_RPT_VW  $sql_cond ";


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $query = DB::select(DB::raw("  SELECT
        -- TRUNC (lmst.ledger_date) trans_date,
                    lmst.au_entry_by,
                    fnc_username (lmst.au_entry_by) cashier_name,
                    SUM (
                    CASE
                        WHEN TRUNC (lmst.ledger_date) = TRUNC (mst.INVOICE_DATE) THEN 1
                        ELSE 0
                    END)
                    new_invoice,
                    SUM (
                    CASE
                        WHEN TRUNC (lmst.ledger_date) <> TRUNC (mst.INVOICE_DATE) THEN 1
                        ELSE 0
                    END)
                    old_invoice,
                    SUM (CASE WHEN ledger_amt_sales > 0 THEN ledger_amt_sales ELSE 0 END)
                    sales,
                    SUM (CASE WHEN ledger_amt_sales < 0 THEN ledger_amt_sales ELSE 0 END)
                    salesr,
                    SUM (ledger_amt_discount) discount,
                    SUM (
                    CASE WHEN ledger_amt_payment > 0 THEN ledger_amt_payment ELSE 0 END)
                    collection,
                    SUM (
                    CASE WHEN ledger_amt_payment < 0 THEN ledger_amt_payment ELSE 0 END)
                    refund,
                    SUM (ledger_amt_payment) net_collection
            FROM finc_ledgermst lmst, finc_invoicemst mst
            WHERE lmst.invoice_no_fk = mst.invoice_no_pk
            $sql_cond
        GROUP BY lmst.au_entry_by
        ORDER BY 1 DESC"));

        $title = "Cashier Wise Summary Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.reports.ipd.financial.cashier_wise_summary_pdf", ['data' => $query, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
        return $pdf->stream('cashier-wise-report.pdf');
    }
    public function referralWiseIncomeSummery()
    {
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            // ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_wish_income_summery", ['card_no' => $card_no, 'serviceDepts' => $serviceDepts]);
    }

    public function referralWiseIncomeSummerySearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        if (Session::get('user.ses_hospital_code') == "EWMCH") {
            $report_data = db::select("select su_name,
                    person_no_pk,
                    full_name,
                    sum (total_appointment) total_appointment,
                    sum (patient_free) patient_free,
                    sum (patient_followup_free) patient_followup_free,
                    sum (patient_new_paid) patient_new_paid,
                    sum (total_patient_paid) total_patient_paid,
                    sum (sur_amt) sur_amt,
                    sum (lab_amt) lab_amt,
                    sum (rad_amt) rad_amt,
                    sum (ipd_service_amt) ipd_service_amt,
                    sum (all_other_amt) all_other_amt,
                    sum (sur_amt_count) sur_amt_count,
                    sum (ipd_service_amt_count) ipd_service_amt_count,
                    sum (total_admission_no) total_admission_no,
                    sum (pathology_amt_count) pathology_amt_count,
                    sum (radiology_amt_count) radiology_amt_count,
                    sum (others_discount_amt) others_discount_amt,
                    sum (rad_discount_amt) rad_discount_amt,
                    sum (lab_discount_amt) lab_discount_amt,
                    sum (ipd_discount_amt) ipd_discount_amt,
                    sum (sur_discount_amt) sur_discount_amt,
                    sum (procedure_amout_discount) procedure_amout_discount,
                    sum (procedure_amount) procedure_amount,
                    sum (prcedure_amout_count) prcedure_amout_count,
                    sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count,
                    SUM (IPD_DOCVISIT_AMT) IPD_DOCVISIT_AMT,
                    SUM (IPD_DOCVISIT_discount) IPD_DOCVISIT_discount
                    from FINC_DOCTOR_INCOME_REFPAY_VW_EWMCH
                    $sql_cond
                    group by person_no_pk, full_name, su_name
                    order by full_name asc");
        } else {
            $report_data = db::select("select su_name,
                        person_no_pk,
                        full_name,
                        sum (total_appointment) total_appointment,
                        sum (patient_free) patient_free,
                        sum (patient_followup_free) patient_followup_free,
                        sum (patient_new_paid) patient_new_paid,
                        sum (total_patient_paid) total_patient_paid,
                        sum (sur_amt) sur_amt,
                        sum (lab_amt) lab_amt,
                        sum (rad_amt) rad_amt,
                        sum (ipd_service_amt) ipd_service_amt,
                        sum (all_other_amt) all_other_amt,
                        sum (sur_amt_count) sur_amt_count,
                        sum (ipd_service_amt_count) ipd_service_amt_count,
                        sum (total_admission_no) total_admission_no,
                        sum (pathology_amt_count) pathology_amt_count,
                        sum (radiology_amt_count) radiology_amt_count,
                        sum (others_discount_amt) others_discount_amt,
                        sum (rad_discount_amt) rad_discount_amt,
                        sum (lab_discount_amt) lab_discount_amt,
                        sum (ipd_discount_amt) ipd_discount_amt,
                        sum (sur_discount_amt) sur_discount_amt,
                        sum (procedure_amout_discount) procedure_amout_discount,
                        sum (procedure_amount) procedure_amount,
                        sum (prcedure_amout_count) prcedure_amout_count,
                        sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count
                        from finc_doctor_income_refpay_vw
                        $sql_cond
                        group by person_no_pk, full_name, su_name
                        order by full_name asc");
        }
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_wish_income_summery_list", ['doctor_income' => $report_data, 'card_no' => $card_no, 'from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function incomeSummaryReportDummy()
    {
        return Template::loadview("admin.reports.financial_summary.income_summary_report_dummy");
    }
    public function incomeSummaryReportDummySearch(Request $request)
    {
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $incomeSummaryData = DB::table('finc_ledgermst_dummy')->select('finc_ledgermst_dummy.invoice_no_fk', 'finc_ledgermst_dummy.invoice_date', 'finc_ledgermst_dummy.patient_name', 'finc_ledgermst_dummy.admission_no_fk', 'finc_ledgermst_dummy.patient_age', 'finc_ledgermst_dummy.cashier_name', 'finc_ledgermst_dummy.ledger_amt_sales', 'finc_ledgermst_dummy.ledger_amt_discount', 'finc_ledgermst_dummy.ledger_amt_payment', 'patient_info_vw.patient_code', 'patient_info_vw.gender_txt')->leftJoin('patient_info_vw', 'patient_info_vw.patient_no_pk', '=', 'finc_ledgermst_dummy.patient_no_fk')->whereBetween(DB::raw('trunc(finc_ledgermst_dummy.invoice_date)'), [$date_from, $date_to])->orderBy('finc_ledgermst_dummy.invoice_date', 'desc')->get()->toArray();

        return Template::loadview("admin.reports.financial_summary.income_summary_report_dummy_list", ['data' => $incomeSummaryData]);
    }
    public function incomeSummaryReportDummyPdf(Request $request, $id)
    {
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        if ($id == "invoice") {
            $incomeSummaryData = DB::table('finc_ledgermst_dummy')->select('finc_ledgermst_dummy.invoice_no_fk', 'finc_ledgermst_dummy.invoice_date', 'finc_ledgermst_dummy.patient_name', 'finc_ledgermst_dummy.admission_no_fk', 'finc_ledgermst_dummy.patient_age', 'finc_ledgermst_dummy.cashier_name', 'finc_ledgermst_dummy.ledger_amt_sales', 'finc_ledgermst_dummy.ledger_amt_discount', 'finc_ledgermst_dummy.ledger_amt_payment', 'patient_info_vw.patient_code', 'patient_info_vw.gender_txt')->leftJoin('patient_info_vw', 'patient_info_vw.patient_no_pk', '=', 'finc_ledgermst_dummy.patient_no_fk')->whereBetween(DB::raw('trunc(finc_ledgermst_dummy.invoice_date)'), [$date_from, $date_to])->orderBy('finc_ledgermst_dummy.invoice_date', 'desc')->get()->toArray();

            // $pdf =  ['data' => $incomeSummaryData, 'po_hospital_details' => $po_hospital_details];
            // $fileToExport = "income_summary_report_dummy_pdf";
            // $html = View("admin.reports.financial_summary.income_summary_report_dummy_pdf")->with($pdf);
            // header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            // header("Content-type: application/vnd.ms-excel");
            // return $html;
            return view("admin.reports.financial_summary.income_summary_report_dummy_pdf", ['data' => $incomeSummaryData, 'po_hospital_details' => $po_hospital_details, 'date_from' => $date_from, 'date_to' => $date_to]);
        } elseif ($id == "date") {
            $incomeSummaryDateWiseData =  DB::table('finc_ledgermst_dummy')->select(DB::raw('trunc(finc_ledgermst_dummy.invoice_date) as invoice_date'), DB::raw('sum(finc_ledgermst_dummy.ledger_amt_sales) as ledger_amt_sales'), DB::raw('sum(finc_ledgermst_dummy.ledger_amt_discount) as ledger_amt_discount'), DB::raw('sum(finc_ledgermst_dummy.ledger_amt_payment) as ledger_amt_payment'))->whereBetween(DB::raw('trunc(finc_ledgermst_dummy.invoice_date)'), [$date_from, $date_to])->groupBy('invoice_date')->orderBy('finc_ledgermst_dummy.invoice_date', 'asc')->get()->toArray();

            return view("admin.reports.financial_summary.income_date_wise_summary_report_dummy_pdf", ['data' => $incomeSummaryDateWiseData, 'po_hospital_details' => $po_hospital_details, 'date_from' => $date_from, 'date_to' => $date_to]);
        }
    }
    public function incomeSummaryReportDummyProcess(Request $request)
    {
        $dis_percent = $request->discount_percent;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';


        try {
            DB::beginTransaction();
            $auth_id = Auth::id();
            $out_error = '';
            $pdo1 = DB::getPdo();
            $incomeSummary = $pdo1->prepare("begin prc_ledgerdiscount(
                :in_from_date,
                :in_to_date,
                :in_discountpct,
                :in_au_entry_by,
                :out_error
                );
                end;");
            $incomeSummary->bindParam(':in_from_date', $date_from);
            $incomeSummary->bindParam(':in_to_date', $date_to);
            $incomeSummary->bindParam(':in_discountpct', $dis_percent);
            $incomeSummary->bindParam(':in_au_entry_by', $auth_id);
            $incomeSummary->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $incomeSummary->execute();

            if ($out_error != 'Process Complete') {
                DB::rollback();
                $incomeSummaryData = [];
                $message = ['msg' => $out_error, 'title' => 'Error'];
            } else {

                DB::commit();
                $incomeSummaryData = DB::table('finc_ledgermst_dummy')->select('finc_ledgermst_dummy.*', 'patient_info_vw.patient_code', 'patient_info_vw.gender_txt')->leftJoin('patient_info_vw', 'patient_info_vw.patient_no_pk', '=', 'finc_ledgermst_dummy.patient_no_fk')->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to])->orderBy('invoice_date', 'desc')->get()->toArray();
                $message = ['msg' => 'Invoice Item Deleted .Invoice ID = ', 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $incomeSummaryData = [];
            $message = ['msg' => $e->getMessage(), 'title' => 'Invoice Delete Fail'];
        }
        return Template::loadview("admin.reports.financial_summary.income_summary_report_dummy_list", ['data' => $incomeSummaryData]);
    }

    /**
     * Daily Attendance Report by Date Range
     */
    public function dailyAttendanceReportMonthlyPrint(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $department = $request->department_name;
        $designation = $request->input('designation_name');
        $card_num = $request->card_hidn;
        // $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_hidn;
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";

        $from_date = Carbon::parse($request->input('date_pic'))->format('d/m/Y');
        $to_date = Carbon::parse($request->input('date_pic2'))->format('d/m/Y');

        $whereClause = '';
        if (!empty($department)) {
            $whereClause .= ' AND SERVICEUNIT_NO_FK = ' . $department;
        }
        if (!empty($designation)) {
            $whereClause .= ' AND designation_no_pk = ' . $designation;
        }
        if (!empty($card_num)) {
            $whereClause .= " AND person_no_pk = '$card_num'";
        }

        $orderByClause = ' order by';
        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $orderByClause .= ' PERSON_CARD_NO ASC';
        } else {
            $orderByClause .= ' PERSON_CARD_NO ASC AND au_entry_at DESC';
        }

        $query = "SELECT PERSON_CARD_NO,full_name,fnc_serviceunitname(SERVICEUNIT_NO_FK) dept,  ( to_date('$to_date','dd/mm/yyyy') - to_date('$from_date','dd/mm/yyyy'))+1  workingday, designation_name, lookupdata_desc, person_no_pk
        , sum(case when Attendance_status = 6 then 1 else 0 end) WEEKEND
        , sum(case when (Attendance_status in( 1, 2, 0)) then 1 else 0 end) ATTENDANCE_DAYS--sum(case when (Attendance_status = 1) OR (Attendance_status = 2 AND NVL(LATE_TIME_MIN,0) =0) then 1 else 0 end) ATTENDANCE_DAYS
        , sum(case when Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 then 1 else 0 end) LATE_DAYS
        , sum(case when Attendance_status = 5 then 1 else 0 end) ABSENT_DAYS
        , sum(case when Attendance_status = 3 then 1 else 0 end) LEAVE_DAYS
        , sum(case when Attendance_status = 8 then 1 else 0 end) CASUAL_LEAVE
        , sum(case when Attendance_status = 9 then 1 else 0 end) SICK_LEAVE
        , sum(case when Attendance_status = 7 then 1 else 0 end) national_holiday
        , sum(case when Attendance_status = 4 then 1 else 0 end) LEAVE_WITHOUTPAY_DAYS
        from HRMS_ATTENDANCE_DAILY att, hrms_personnel per , hrms_designation desi, sysc_lookupdata jobtype
            where trunc(ATTENDANCE_DATE) between to_date('$from_date','dd/mm/yyyy') and    to_date('$to_date','dd/mm/yyyy')  --to_number(to_char(ATTENDANCE_DATE,'YYYYMM')) = in_yyyymm
            and att.AU_ENTRY_HOSPITAL_PK_NO = '$ses_hospital_id'
            and per.PERSON_NO_pk=att.PERSON_NO_FK
            and per.jobtitle_lookup_no_fk=desi.DESIGNATION_NO_PK(+)
            and per.job_type_lookup_no_fk=jobtype.lookupdata_no_pk(+)
            and per.STATUS = 1
            and employee_ind = 1
            and virtual_ind != 1
            $whereClause
            group by full_name, PERSON_CARD_NO,SERVICEUNIT_NO_FK, DESIGNATION_NAME, lookupdata_desc, person_no_pk --, trunc(ATTENDANCE_DATE)
            $orderByClause
        ";
        $attendance_data = DB::select(DB::raw($query));
        $attend_data = [];
        if (!empty($attendance_data)) {
            foreach ($attendance_data as $data) {
                $attend_data[$data->lookupdata_desc][$data->person_no_pk] = $data;
            }
        }
        $total_employee = DB::select("select lookupdata_desc, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where status=1 $card_no_con group by lookupdata_desc");
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->lookupdata_desc] = $value->total_emp;
            }
        }

        $from_date = Carbon::parse($request->input('date_pic'))->format('Y-m-d');
        $to_date = Carbon::parse($request->input('date_pic2'))->format('Y-m-d');

        $emp_info_arr = [];
        if (!empty($attendance_data)) {
            foreach ($attendance_data as $data) {
                $daily_attend_data = DB::table('hrms_attendance_daily')->whereRaw("attendance_date between trunc(to_date('$from_date', 'YYYY-MM-DD')) and trunc(to_date('$to_date','YYYY-MM-DD'))")
                    ->where('person_no_fk', $data->person_no_pk)->get();

                if (count($daily_attend_data) > 0) {
                    foreach ($daily_attend_data as $singleData) {
                        if ($singleData->attendance_status == '3' || $singleData->attendance_status == '4' || $singleData->attendance_status == '8' || $singleData->attendance_status == '9') {
                            $status = $singleData->leave_code;
                        } elseif ($singleData->attendance_status == '7') {
                            $status = "NH";
                        } elseif ($singleData->attendance_status == '6') {
                            $status = "DO";
                        } elseif (isset($singleData->in_time) && isset($singleData->out_time) && ($singleData->in_time != $singleData->out_time)) {
                            $status = "P";
                        } elseif (isset($singleData->in_time) && !isset($singleData->out_time)) {
                            $status = "P";
                        } elseif (isset($singleData->in_time) && isset($singleData->out_time) && $singleData->in_time == $singleData->out_time) {
                            $status = "P";
                        } else {
                            $status = "A";
                        }
                        $emp_info_arr[$data->person_no_pk] = $data->person_no_pk;
                        $attendance_arr[date('Y-m-d', strtotime($singleData->attendance_date))][$data->person_no_pk] = [
                            'status' => $status,
                        ];
                    }
                } else {
                    $emp_info_arr[$data->person_no_pk] = $data->person_no_pk;
                }
            }
        }

        $dateRange = date('M d, Y', strtotime($from_date)) . " - " . date('M d, Y', strtotime($to_date));

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $pdf = PDF::loadView("admin.hrm.monthlyAttendence.attendence_date_range_search_pdf_unico", [
                'attendance_data'       => $attendance_data,
                'attend_data'           => $attend_data,
                'po_hospital_details'   => $po_hospital_details,
                // 'attendence_month_date' => $attendence_month_date,
                'count_depart_emp'      => $count_depart_emp,
                'from_date'             => $from_date,
                'to_date'               => $to_date,
                'emp_info_arr'          => $emp_info_arr,
                'attendance_arr'        => $attendance_arr,
                'date_range'            => $dateRange,
            ])->setPaper('legal', 'landscape');
        // } else {
        //     $pdf = PDF::loadView("admin.hrm.monthlyAttendence.attendence_monthly_search_pdf", [
        //         'data' => $attendance_data,
        //         'attend_data' => $attend_data,
        //         'po_hospital_details' => $po_hospital_details,
        //         // 'attendence_month_date' => $attendence_month_date,
        //         'count_depart_emp' => $count_depart_emp,
        //     ])->setPaper('a4', 'landscape');
        // }

        return $pdf->stream('daily_attendance_report_print.pdf');
    }

    /**
     * Prescribe & Sales Medicine
     */
    public function prescribeSalesMedicineReport()
    {
        $from_date  = date('d/m/Y');
        $to_date    = date('d/m/Y');

        // $items = DB::select("select case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,prescription_no_pk,gen.generic_name,item.item_name
        //     from sysc_serviceitem item, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //     where item.item_no_pk=presmed.item_no_fk
        //     and gen.generic_no_pk=item.generic_no_fk(+)
        //     and pres.prescription_no_pk=presmed.prescription_no_fk
        //     and trunc(pres.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //     order by 1, 2");

        // $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,gen.generic_name,itema.item_name, (select nvl(sum(STOCK_TRANS_QTY),0) from INV_ITEMSTOCKTRANSCHD skt where trunc(skt.AU_ENTRY_AT) <=to_date('$to_date','dd/mm/yyyy') and skt.ITEM_NO_FK=itema.item_no_pk) stk_qty
        //         from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //         where itema.item_no_pk=presmed.item_no_fk
        //         and gen.generic_no_pk=itema.generic_no_fk(+)
        //         and pres.prescription_no_pk=presmed.prescription_no_fk
        //         and itema.generic_no_fk not in
        //         (
        //             select generic_no_pk
        //             from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
        //             where item.item_no_pk=dtl.item_no_fk
        //             and gen.generic_no_pk=item.generic_no_fk
        //             and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //         )
        //         and trunc(pres.PRESCRIPTION_DATE) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //         order by 1,2");

        // $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
        //             case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name, (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty
        //             from psn_t_prescription_med presmed,psn_t_prescription pres,sysc_serviceitem itema, sysc_generic gen
        //             where pres.prescription_no_pk=presmed.prescription_no_fk
        //             and presmed.item_no_fk=itema.item_no_pk(+)
        //             and itema.generic_no_fk=gen.generic_no_pk(+)
        //             and nvl(itema.generic_no_fk,0) in
        //             (
        //                 select generic_no_pk
        //                 from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
        //                 where item.item_no_pk=dtl.item_no_fk
        //                 and gen.generic_no_pk=item.generic_no_fk
        //                 and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             )
        //             and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             order by 1,2");

        $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
                    case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name,
                        (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where
                        trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
                        (
                            select count(1)
                            from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
                            where item.item_no_pk=dtl.item_no_fk
                            and gen1.generic_no_pk=item.generic_no_fk
                            and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                            and  gen1.generic_no_pk=gen.generic_no_pk
                        ) sales_status
                        from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
                        where  pres.prescription_no_pk=presmed.prescription_no_fk
                        and presmed.item_no_fk=itema.item_no_pk (+)
                        and  itema.generic_no_fk=gen.generic_no_pk(+)
                        and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                        order by 1,2");

        $prescribeMedicine = [];
        foreach ($items as $item) {
            if (!isset($prescribeMedicine[$item->doc_name])) $prescribeMedicine[$item->doc_name] = [];
            array_push($prescribeMedicine[$item->doc_name], $item);
        }

        $salesMedicine = DB::select("select distinct generic_name,item.item_name
            from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
            where item.item_no_pk=dtl.item_no_fk
            and gen.generic_no_pk=item.generic_no_fk(+)
            and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
            order by 1");

        return Template::loadview("admin.reports.prescribe-sales-medicine.prescribe-sales-medicine-report", ['prescribeMedicine' => $prescribeMedicine, 'salesMedicine' => $salesMedicine]);
    }

    /**
     * Filter::Prescribe & Sales Medicine
     */
    public function prescribeSalesMedicineReportFilter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $request->input('from_date') : date('d/m/Y');
        $to_date = $request->input('to_date') != "" ? $request->input('to_date') : date('d/m/Y');

        // $items = DB::select("select case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,prescription_no_pk,gen.generic_name,item.item_name
        //     from sysc_serviceitem item, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //     where item.item_no_pk=presmed.item_no_fk
        //     and gen.generic_no_pk=item.generic_no_fk(+)
        //     and pres.prescription_no_pk=presmed.prescription_no_fk
        //     and trunc(pres.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //     order by 1, 2");

        // $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,gen.generic_name,itema.item_name, (select nvl(sum(STOCK_TRANS_QTY),0) from INV_ITEMSTOCKTRANSCHD skt where trunc(skt.AU_ENTRY_AT) <=to_date('$to_date','dd/mm/yyyy') and skt.ITEM_NO_FK=itema.item_no_pk) stk_qty
        //     from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //     where itema.item_no_pk=presmed.item_no_fk
        //     and gen.generic_no_pk=itema.generic_no_fk(+)
        //     and pres.prescription_no_pk=presmed.prescription_no_fk
        //     and itema.generic_no_fk not in
        //     (
        //         select generic_no_pk
        //         from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
        //         where item.item_no_pk=dtl.item_no_fk
        //         and gen.generic_no_pk=item.generic_no_fk
        //         and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //     )
        //     and trunc(pres.PRESCRIPTION_DATE) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //     order by 1,2");

        // $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
        //                     case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name, (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty
        //                 from psn_t_prescription_med presmed,psn_t_prescription pres,sysc_serviceitem itema, sysc_generic gen
        //                 where pres.prescription_no_pk=presmed.prescription_no_fk
        //                 and presmed.item_no_fk=itema.item_no_pk(+)
        //                 and itema.generic_no_fk=gen.generic_no_pk(+)
        //                 and nvl(itema.generic_no_fk,0) in
        //                 (
        //                     select generic_no_pk
        //                     from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
        //                     where item.item_no_pk=dtl.item_no_fk
        //                     and gen.generic_no_pk=item.generic_no_fk
        //                     and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //                 )
        //                 and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //                 order by 1,2");

        $items = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
                    case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name,
                        (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where
                        trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
                        (
                            select count(1)
                            from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
                            where item.item_no_pk=dtl.item_no_fk
                            and gen1.generic_no_pk=item.generic_no_fk
                            and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                            and  gen1.generic_no_pk=gen.generic_no_pk
                        ) sales_status
                        from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
                        where  pres.prescription_no_pk=presmed.prescription_no_fk
                        and presmed.item_no_fk=itema.item_no_pk (+)
                        and  itema.generic_no_fk=gen.generic_no_pk(+)
                        and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                        order by 1,2");

        $prescribeMedicine = [];
        foreach ($items as $item) {
            if (!isset($prescribeMedicine[$item->doc_name])) $prescribeMedicine[$item->doc_name] = [];
            array_push($prescribeMedicine[$item->doc_name], $item);
        }

        $salesMedicine = DB::select("select distinct generic_name,item.item_name
            from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
            where item.item_no_pk=dtl.item_no_fk
            and gen.generic_no_pk=item.generic_no_fk(+)
            and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
            order by 1");

        return Template::loadview("admin.reports.prescribe-sales-medicine.prescribe-sales-medicine-report-table", ['prescribeMedicine' => $prescribeMedicine, 'salesMedicine' => $salesMedicine]);
    }

    /**
     * Excel / PDF Download
     */
    public function prescribeSalesMedicineReportExport(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $request->input('from_date') : date('d/m/Y');
        $to_date = $request->input('to_date') != "" ? $request->input('to_date') : date('d/m/Y');

        // $items = DB::select("select case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,prescription_no_pk,gen.generic_name,item.item_name
        //     from sysc_serviceitem item, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //     where item.item_no_pk=presmed.item_no_fk
        //     and gen.generic_no_pk=item.generic_no_fk(+)
        //     and pres.prescription_no_pk=presmed.prescription_no_fk
        //     and trunc(pres.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //     order by 1, 2");

        // $items = DB::select("select case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,gen.generic_name,itema.item_name, (select nvl(sum(STOCK_TRANS_QTY),0) from INV_ITEMSTOCKTRANSCHD skt where trunc(skt.AU_ENTRY_AT) <=to_date('$to_date','dd/mm/yyyy') and skt.ITEM_NO_FK=itema.item_no_pk) stk_qty
        //         from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //         where itema.item_no_pk=presmed.item_no_fk
        //         and gen.generic_no_pk=itema.generic_no_fk(+)
        //         and pres.prescription_no_pk=presmed.prescription_no_fk
        //         and itema.generic_no_fk not in
        //         (
        //             select generic_no_pk
        //             from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
        //             where item.item_no_pk=dtl.item_no_fk
        //             and gen.generic_no_pk=item.generic_no_fk
        //             and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //         )
        //         and trunc(pres.PRESCRIPTION_DATE) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //         order by 1,2");

        // $prescribeMedicine = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,gen.generic_name,itema.item_name,
        //         (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
        //         (
        //             select count(1)
        //             from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
        //             where item.item_no_pk=dtl.item_no_fk
        //             and gen1.generic_no_pk=item.generic_no_fk
        //             and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             and  gen1.generic_no_pk=gen.generic_no_pk
        //             ) sales_status
        //             from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //             where itema.item_no_pk=presmed.item_no_fk
        //             and gen.generic_no_pk=itema.generic_no_fk(+)
        //             and pres.prescription_no_pk=presmed.prescription_no_fk
        //             and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             order by 1,2");

        // $prescribeMedicine = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
        //     case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name,
        //         (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
        //         (
        //             select count(1)
        //             from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
        //             where item.item_no_pk=dtl.item_no_fk
        //             and gen1.generic_no_pk=item.generic_no_fk
        //             and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             and  gen1.generic_no_pk=gen.generic_no_pk
        //             ) sales_status
        //             from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //             where pres.prescription_no_pk=presmed.prescription_no_fk
        //             and presmed.item_no_fk=itema.item_no_pk (+)
        //             and itema.generic_no_fk=gen.generic_no_pk(+)
        //             and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             order by 1,2");

        // $prescribeMedicine = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
        //     case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name,
        //         (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
        //         (
        //             select count(1)
        //             from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
        //             where item.item_no_pk=dtl.item_no_fk
        //             and gen1.generic_no_pk=item.generic_no_fk
        //             and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             and  gen1.generic_no_pk=gen.generic_no_pk
        //             ) sales_status
        //             from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
        //             where pres.prescription_no_pk=presmed.prescription_no_fk
        //             and presmed.item_no_fk=itema.item_no_pk (+)
        //             and itema.generic_no_fk=gen.generic_no_pk(+)
        //             and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        //             order by 1,2");

        $prescribeMedicine = DB::select("select distinct case when doctor_person_no_fk <> 0 then fnc_empname(doctor_person_no_fk) else fnc_username(pres.au_entry_by) end doc_name,
            case when item_no_fk=0 then presmed.generic_name||(' (FHM)') else gen.generic_name end generic_name,case when item_no_fk=0 then presmed.brand_name else itema.item_name end item_name,
                (select nvl(sum(stock_trans_qty),0) from inv_itemstocktranschd skt where
                trunc(skt.au_entry_at) <= to_date('$to_date','dd/mm/yyyy') and skt.item_no_fk=itema.item_no_pk) stk_qty,
                (
                    select count(1)
                    from sysc_serviceitem item, sysc_generic gen1,finc_invoicedtl dtl
                    where item.item_no_pk=dtl.item_no_fk
                    and gen1.generic_no_pk=item.generic_no_fk
                    and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                    and  gen1.generic_no_pk=gen.generic_no_pk
                ) sales_status
                from sysc_serviceitem itema, sysc_generic gen,psn_t_prescription_med presmed,psn_t_prescription pres
                where  pres.prescription_no_pk=presmed.prescription_no_fk
                and presmed.item_no_fk=itema.item_no_pk (+)
                and  itema.generic_no_fk=gen.generic_no_pk(+)
                and trunc(pres.prescription_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
                order by 1,2");

        // $prescribeMedicine = [];
        // foreach($items as $item) {
        //     if(!isset($prescribeMedicine[$item->doc_name])) $prescribeMedicine[$item->doc_name] = [];
        //     array_push($prescribeMedicine[$item->doc_name], $item);
        // }

        $salesMedicine = DB::select("select distinct generic_name,item.item_name
            from sysc_serviceitem item, sysc_generic gen,finc_invoicedtl dtl
            where item.item_no_pk=dtl.item_no_fk
            and gen.generic_no_pk=item.generic_no_fk(+)
            and trunc(dtl.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
            order by 1");


        if ($request->print_type == 'PDF') {
            $page_name = "admin.reports.prescribe-sales-medicine.prescribe-sales-medicine-report-table-pdf";
            $data = ['prescribeMedicine' => $prescribeMedicine, 'salesMedicine' => $salesMedicine, 'from_date' => $from_date, 'to_date' => $to_date];
            return view($page_name, $data);
        }
        if ($request->print_type == 'EXCEL') {
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

            $data = ['prescribeMedicine' => $prescribeMedicine, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "prescribe-medicine-audit-report";
            $html = View("admin.reports.prescribe-sales-medicine.prescribe-sales-medicine-doctor-wise-report-excel")->with($data);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function dateWiseCollectionReport()
    {
        return Template::loadView("admin.reports.date-wise-collection-report");
    }

    public function doctorPerformanceSummary()
    {
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            // ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary", ['card_no' => $card_no, 'serviceDepts' => $serviceDepts]);
    }

    public function doctorPerformanceSummarySearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        $query = "select su_name,
                    person_no_pk,
                    full_name,
                    INTERNAL_DOCTOR_IND,
                    sum (total_appointment) total_appointment,
                    sum (patient_free) patient_free,
                    sum (patient_followup_free) patient_followup_free,
                    sum (patient_new_paid) patient_new_paid,
                    sum (total_patient_paid) total_patient_paid,
                    sum (sur_amt) sur_amt,
                    sum (lab_amt) lab_amt,
                    sum (rad_amt) rad_amt,
                    sum (ipd_service_amt) ipd_service_amt,
                    sum (all_other_amt) all_other_amt,
                    sum (sur_amt_count) sur_amt_count,
                    sum (ipd_service_amt_count) ipd_service_amt_count,
                    sum (total_admission_no) total_admission_no,
                    sum (pathology_amt_count) pathology_amt_count,
                    sum (radiology_amt_count) radiology_amt_count,
                    sum (others_discount_amt) others_discount_amt,
                    sum (rad_discount_amt) rad_discount_amt,
                    sum (lab_discount_amt) lab_discount_amt,
                    sum (ipd_discount_amt) ipd_discount_amt,
                    sum (sur_discount_amt) sur_discount_amt,
                    sum (procedure_amout_discount) procedure_amout_discount,
                    sum (procedure_amount) procedure_amount,
                    sum (prcedure_amout_count) prcedure_amout_count,
                    sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count
                    from FINC_v1_DOCTOR_INCOME_REFPAY_VW
                    $sql_cond
                    group by person_no_pk, full_name, su_name, INTERNAL_DOCTOR_IND
                    ";
        $report_data = DB::select($query);

        $internal_doctors = collect($report_data)->where('internal_doctor_ind', "1");
        $external_doctors = collect($report_data)->where('internal_doctor_ind', "0");

        $ids = collect([]);
        foreach ($internal_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt) - ($row->ipd_discount_amt + $row->rad_discount_amt + $row->lab_discount_amt + $row->others_discount_amt + $row->sur_discount_amt + $row->procedure_amout_discount);
            $row->total_overall_income = $total;
        }

        $ids = collect($internal_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        $eds = collect([]);
        foreach ($external_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt) - ($row->ipd_discount_amt + $row->rad_discount_amt + $row->lab_discount_amt + $row->others_discount_amt + $row->sur_discount_amt + $row->procedure_amout_discount);
            $row->total_overall_income = $total;
        }

        $eds = collect($external_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        $result = [
            "internal_doctors" => $ids,
            "external_doctors" => $eds,
        ];

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table", ['result' => $result, 'doctor_income' => $report_data, 'card_no' => $card_no, 'from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function doctorPerformanceSummaryDownload(Request $request, $type)
    {
        if ($type == "" || ($type != "EXCEL" && $type != "PDF")) {
            throw new Exception("Sorry! Invalid Request.");
        }

        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        $query = "select su_name,
                    person_no_pk,
                    full_name,
                    INTERNAL_DOCTOR_IND,
                    sum (total_appointment) total_appointment,
                    sum (patient_free) patient_free,
                    sum (patient_followup_free) patient_followup_free,
                    sum (patient_new_paid) patient_new_paid,
                    sum (total_patient_paid) total_patient_paid,
                    sum (sur_amt) sur_amt,
                    sum (lab_amt) lab_amt,
                    sum (rad_amt) rad_amt,
                    sum (ipd_service_amt) ipd_service_amt,
                    sum (all_other_amt) all_other_amt,
                    sum (sur_amt_count) sur_amt_count,
                    sum (ipd_service_amt_count) ipd_service_amt_count,
                    sum (total_admission_no) total_admission_no,
                    sum (pathology_amt_count) pathology_amt_count,
                    sum (radiology_amt_count) radiology_amt_count,
                    sum (others_discount_amt) others_discount_amt,
                    sum (rad_discount_amt) rad_discount_amt,
                    sum (lab_discount_amt) lab_discount_amt,
                    sum (ipd_discount_amt) ipd_discount_amt,
                    sum (sur_discount_amt) sur_discount_amt,
                    sum (procedure_amout_discount) procedure_amout_discount,
                    sum (procedure_amount) procedure_amount,
                    sum (prcedure_amout_count) prcedure_amout_count,
                    sum (ipd_docvisit_amt_count) ipd_docvisit_amt_count
                    from FINC_v1_DOCTOR_INCOME_REFPAY_VW
                    $sql_cond
                    group by person_no_pk, full_name, su_name, INTERNAL_DOCTOR_IND
                    ";
        $report_data = DB::select($query);

        $internal_doctors = collect($report_data)->where('internal_doctor_ind', "1");
        $external_doctors = collect($report_data)->where('internal_doctor_ind', "0");

        $ids = collect([]);
        foreach ($internal_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt) - ($row->ipd_discount_amt + $row->rad_discount_amt + $row->lab_discount_amt + $row->others_discount_amt + $row->sur_discount_amt + $row->procedure_amout_discount);
            $row->total_overall_income = $total;
        }

        $ids = collect($internal_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        $eds = collect([]);
        foreach ($external_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt) - ($row->ipd_discount_amt + $row->rad_discount_amt + $row->lab_discount_amt + $row->others_discount_amt + $row->sur_discount_amt + $row->procedure_amout_discount);
            $row->total_overall_income = $total;
        }

        $eds = collect($external_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        if ($type == "EXCEL") {
            $result = ["internal_doctors" => $ids, "external_doctors" => $eds, "from_date" => $request->input("date_pic"), "to_date" => $request->input("date_pic2")];
            $fileToExport = "doctor-performance-summary";
            $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_excel")->with($result);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    /**
     * Patient Flow Summary
     */
    public function patientFlowSummary()
    {
        return Template::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.patient_summary_flow");
    }

    /**
     * Patient Flow Summary Report
     */
    public function patientFlowSummaryReport(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';
        // $today = date('d/m/Y');

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $opd = DB::select("select sum(to_day_TOT_PATIENT) today_patient, sum(to_day_NEW_PATIENT) today_newpat,sum(to_day_FOLLOWUP_PAT) today_follow,
            sum(to_day_FREE_PATIENT) today_free,sum(TOT_PATIENT) total_patient,
            sum(NEW_PATIENT) total_new,sum(FOLLOWUP_PAT) total_followup, sum(FREE_PATIENT) total_free
            from (
            SELECT 0 to_day_TOT_PATIENT,0 to_day_NEW_PATIENT,0 to_day_FOLLOWUP_PAT,0 to_day_FREE_PATIENT,SUM(TOTAL_APPOINTMENT) TOT_PATIENT,
            SUM(Patient_new_paid) NEW_PATIENT,SUM(PATIENT_FOLLOWUP_TOTAL) FOLLOWUP_PAT,SUM(PATIENT_FREE) +SUM(PATIENT_FOLLOWUP_FREE) FREE_PATIENT
            FROM FINC_DOC_APPOINT_SUM_DT_VW
            WHERE APPOINT_DATE BETWEEN TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
            union
            SELECT SUM(TOTAL_APPOINTMENT) to_day_TOT_PATIENT,SUM(Patient_new_paid) to_day_NEW_PATIENT,SUM(PATIENT_FOLLOWUP_TOTAL) to_day_FOLLOWUP_PAT,
            SUM(PATIENT_FREE)+SUM(PATIENT_FOLLOWUP_FREE) to_day_FREE_PATIENT ,0 ,0,0,0
            FROM FINC_DOC_APPOINT_SUM_DT_VW
            WHERE APPOINT_DATE = TO_DATE('$to_date','dd/mm/yyyy') )");




            $ipd = DB::select("select sum(case when trunc(ADMISSION_DATE) = TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 1 then 1
            else 0 end) todayadmitted_patient ,
            sum(case when trunc(ADMISSION_DATE) < TO_DATE('$to_date','dd/mm/yyyy') AND trunc(nvl(DIS_DATE,sysdate+1)) >= TO_DATE('$to_date','dd/mm/yyyy')  and iptype_ind = 1
            then 1 else 0 end)  pre_patient,
            sum(case when  trunc(DIS_DATE) = TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 1 then 1
            else 0 end)  todaydis_patient,
            sum(case when trunc(ADMISSION_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') AND trunc(nvl(DIS_DATE,sysdate+1)) > TO_DATE('$to_date','dd/mm/yyyy')  and iptype_ind = 1
            then 1 else 0 end)  curr_patient,
            sum(case when trunc(ADMISSION_DATE) >= TO_DATE('$to_date','dd/mm/yyyy')and trunc(ADMISSION_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 1 then 1
            else 0 end) admitted_aptient ,
            sum(case when  trunc(DIS_DATE) >= TO_DATE('$from_date','dd/mm/yyyy') and trunc(DIS_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 1  then 1
            else 0 end)  dis_patient,
            sum(case when  trunc(ADMISSION_DATE) >= TO_DATE('$from_date','dd/mm/yyyy') and trunc(ADMISSION_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 1 then 1
            else 0 end) total_patient,
            sum(case when trunc(ADMISSION_DATE) = TO_DATE('$from_date','dd/mm/yyyy') and REF_FROM_EMR_IND = 1 then 1
            else 0 end) reff2ipd
            from ipd_admission
            where  trunc(nvl(DIS_DATE,sysdate)) between TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
        or trunc(ADMISSION_DATE) between TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
        ");

        $emergency = DB::select("select sum(case when trunc(ADMISSION_DATE) = TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 2 then 1
            else 0 end) todayadmitted_patient ,
            sum(case when trunc(ADMISSION_DATE) < TO_DATE('$to_date','dd/mm/yyyy') AND trunc(nvl(DIS_DATE,sysdate+1)) >= TO_DATE('$to_date','dd/mm/yyyy')  and iptype_ind = 2
            then 1 else 0 end)  pre_patient,
            sum(case when  trunc(DIS_DATE) = TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 2  then 1
            else 0 end)  todaydis_patient,
            sum(case when trunc(ADMISSION_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') AND trunc(nvl(DIS_DATE,sysdate+1)) > TO_DATE('$to_date','dd/mm/yyyy')  and iptype_ind = 2
            then 1 else 0 end)  curr_patient,
            sum(case when trunc(ADMISSION_DATE) >= TO_DATE('$to_date','dd/mm/yyyy')and trunc(ADMISSION_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 2 then 1
            else 0 end) admitted_aptient ,
            sum(case when  trunc(DIS_DATE) >= TO_DATE('$from_date','dd/mm/yyyy') and trunc(DIS_DATE) <= TO_DATE('$to_date','dd/mm/yyyy') and iptype_ind = 2  then 1
            else 0 end)  dis_patient,
            count(case when iptype_ind = 2 then 1 else null end) total_patient,
            sum(case when trunc(ADMISSION_DATE) = TO_DATE('$from_date','dd/mm/yyyy') and REF_FROM_EMR_IND = 1 then 1
            else 0 end) refffromipd
            from ipd_admission
            where  trunc(nvl(DIS_DATE,sysdate)) between TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
        or trunc(ADMISSION_DATE) between TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
        ");

        $netSales = DB::select("select mod.MODULE_NO_pK,MODULE_NAME,(select sum(LEDGER_AMT_PAYMENT) from finc_ledgermst ob
            where trunc(LEDGER_DATE) < TO_DATE('$from_date','dd/mm/yyyy')
            and  ob.MODULE_NO_FK = mod.MODULE_NO_pK) ob, sum(case when trunc(LEDGER_DATE)=TO_DATE('$to_date','dd/mm/yyyy') then
                        LEDGER_AMT_PAYMENT else 0 end ) today_collection,sum(LEDGER_AMT_PAYMENT) total_collection
                        from finc_ledgermst lmst,finc_invoicemst mst, sysc_module mod
                        where lmst.invoice_no_fk=mst.invoice_no_pk
                        and MST.MODULE_NO_FK = MOD.MODULE_NO_PK
                        and trunc(LEDGER_DATE) between TO_DATE('$from_date','dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')
                        group by MODULE_NAME,mod.MODULE_NO_pK
                        order by 2");

        $result = ["opd" => $opd, "ipd" => $ipd, "netSales" => $netSales, "from_date" => $from_date, "to_date" => $to_date,'emergency' => $emergency];

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.patient_summary_flow_report", ["result" => $result, "po_hospital_details" => $po_hospital_details,])->setPaper('a4', 'landscape');
        return $pdf->stream("Patient Flow Summary.pdf", array("Attachment" => false));
    }

    public function hospitalCollection()
    {
        $collectionTypes = DB::select("select distinct module_no_pk,mod.module_name
                            from finc_invoicemst mst,sysc_module mod
                            where mst.module_no_fk=mod.module_no_pk
                            order by 2");

        $from_date = date('d/m/Y');
        $to_date = date('d/m/Y');

        $items = DB::select("select mst.module_no_fk, mod.module_name, sum(ledger_amt_payment) total_amount
            from finc_ledgermst lmst,finc_invoicemst mst,sysc_module mod
            where mst.invoice_no_pk=lmst.invoice_no_fk
            and mst.module_no_fk=mod.module_no_pk
            and trunc(ledger_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
            group by mst.module_no_fk,mod.module_name
            order by 2");

        return Template::loadview("admin.reports.hospital-collection.hospital-collection-report", compact('collectionTypes', 'items'));
    }

    public function hospitalCollectionFilter(Request $request)
    {
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');

        $whereClause = '';

        if ($request->collection_type != null) {
            $whereClause .= " AND mst.module_no_fk = " . $request->collection_type;
        }

        $items = DB::select("select mst.module_no_fk, mod.module_name, sum(ledger_amt_payment) total_amount
            from finc_ledgermst lmst,finc_invoicemst mst,sysc_module mod
            where mst.invoice_no_pk=lmst.invoice_no_fk
            and mst.module_no_fk=mod.module_no_pk
            and trunc(ledger_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy') $whereClause
            group by mst.module_no_fk,mod.module_name
            order by 2");

        return Template::loadview("admin.reports.hospital-collection.hospital-collection-report-table", compact('items'));
    }

    public function hospitalCollectionPdf(Request $request)
    {
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');

        $whereClause = '';

        if ($request->collection_type != null) {
            $whereClause .= " AND mst.module_no_fk = " . $request->collection_type;
        }

        $items = DB::select("select mst.module_no_fk, mod.module_name, sum(ledger_amt_payment) total_amount
            from finc_ledgermst lmst,finc_invoicemst mst,sysc_module mod
            where mst.invoice_no_pk=lmst.invoice_no_fk
            and mst.module_no_fk=mod.module_no_pk
            and trunc(ledger_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy') $whereClause
            group by mst.module_no_fk,mod.module_name
            order by 2");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.reports.hospital-collection.hospital-collection-report-pdf", ["items" => $items, "po_hospital_details" => $po_hospital_details, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
        return $pdf->stream("Diet Chart Report.pdf", array("Attachment" => false));
    }



    public function testMail()
    {
        $purchase_order_id = 3403;
        $showWithHeader = true;

        try {
            ini_set('max_execution_time', 0);

            PDF::setOptions(['isPhpEnabled', 'true']);
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
            $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*,pov.approval_status_text,pov.approval_level_status_text, fnc_poheader($purchase_order_id) poheader
                    FROM INV_PURCHASEORDER_MST pom
                    LEFT JOIN inv_po_wl_vw pov ON pov.purchaseorder_no_pk = pom.purchaseorder_no_pk
                    LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                    WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));

            if (count($po_master_info) > 0) {
                $po_master_info = $po_master_info[0];
            }



            $barcode = new BarcodeGenerator();
            $barcode->setText($purchase_order_id);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $invoice_barcode = $barcode->generate();

            $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.*,u.*,d.dollar_ind,curr.currency_code,curr.currency_name
                    FROM INV_PURCHASEORDER_CHD poc
                    LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                    LEFT JOIN sysc_serviceitem d ON d.item_no_pk = poc.item_no_fk
                    left join sysc_serviceitem_uom u on poc.uom  =u.uom_no_pk
                    left join sysc_currency curr on poc.CURRENCY_NO_FK  = curr.currency_no_pk
                    WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by poc.purchaseorderdtl_no_pk asc

                    "));


            // dd($po_child_details_info);
            $curr_rate = isset($po_child_details_info[0]->dollar_rate) ? $po_child_details_info[0]->dollar_rate : 0;


            $term = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)
                ->orderBy('purchaseorder_terms_no_pk', 'asc')
                ->orderBy('sl', 'asc')->get();

            $terms = [];
            if (!empty($term)) {
                foreach ($term as $key => $value) {
                    $terms[$value->termscon_header][] = $value;
                }
            }

            $userInfo = Auth::user();

            $pdf = App::make('dompdf.wrapper');

            $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
            inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
            $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

            $signature_data = DB::table('sysc_approvalprocess_vw')
                ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
                ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                ->where('sysc_approvalprocess_vw.primary_key_value', $purchase_order_id)
                ->where('sysc_approvalprocess_vw.approval_for_code', 'PO')
                ->orderBy('own_level', 'asc')
                ->get();

            $viewFile = "";
            if (Session::get('user.ses_hospital_code') == "IMPERIAL" || $showWithHeader == true) {
                $viewFile = "admin.inventory.v1.po.purchase_order_print_v2_imperial";
            } else {
                $viewFile = "admin.inventory.v1.po.purchase_order_print_v2";
            }

            $data = [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'curr_rate' => $curr_rate,
                'signature_data' => $signature_data,
            ];

            $viewFile = 'admin.inventory.v1.po.email';

            $pdf = PDF::loadView($viewFile, [
                'purchase_order_id' => $purchase_order_id,
                'po_master_info' => $po_master_info,
                'po_child_details_info' => $po_child_details_info,
                'userInfo' => $userInfo,
                'po_hospital_details' => $po_hospital_details,
                'invoice_barcode' => $invoice_barcode,
                'terms' =>   $terms,
                'signed_user' => $signed_user,
                'curr_rate' => $curr_rate,
                'signature_data' => $signature_data,
            ]);

            $path = Storage::put('public/storage/uploads/' . '-' . rand() . '_' . time() . '.pdf', $pdf->output());
            Storage::put($path, $pdf->output());
            // dd('san');

            // $path = '';

            // return $pdf->stream("purchase_order_print_".$purchase_order_id.".pdf", array("Attachment" => false));

            // Mail::to('test@test.test')->send(new MyTestEmail($pdf, $path, $data));

            Mail::send($viewFile, $data, function ($msg) use ($pdf) {
                $msg->to('test@test.test');
                $msg->attachData($pdf->output(), 'test.pdf', ['mime' => 'application/pdf']);
                $msg->subject('PO');
            });

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function itemWiseStock()
    {
        $item_types = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk', 'itemtype_code')
            ->orderBy('item_name')
            ->get();

        // $items = DB::select("select itm.item_code, itm.item_name, itm.generic_no_fk, gen.generic_name, itm.supplier_pk_no, sup.supplier_name, item_type, sum(balance_qty) stock_qty, itm.ITEM_NO_PK, itm.purchase_price, itm.sales_price
        //     from inv_itemstockmst stk, sysc_serviceitem itm, inv_supplier sup, sysc_generic gen
        //     where itm.item_no_pk = stk.item_no_fk
        //     and itm.supplier_pk_no = sup.supplier_no_pk(+)
        //     and itm.generic_no_fk = gen.generic_no_pk(+)
        //     group by itm.item_code, itm.item_name, itm.generic_no_fk, itm.supplier_pk_no, item_type, sup.supplier_name, gen.generic_name, itm.ITEM_NO_PK, itm.purchase_price, itm.sales_price
        //     order by item_type, 2");

        $items = [];

        return Template::loadView("admin.reports.item-wise-stock", compact("item_types", "items"));
    }

    public function itemWiseStockDetails(Request $request)
    {
        $items = DB::select("select item.item_name,fnc_serviceunitname(stock_su_no_fk) department, sum(stock_trans_qty) qty, item.item_no_pk
                    from inv_itemstocktranschd chd, sysc_serviceitem item
                    where item_no_fk = $request->id
                    and chd.item_no_fk = item.item_no_pk
                    group by item.item_name, stock_su_no_fk, item.item_no_pk
                    order by 2, 1");

        return Template::loadview("admin.reports.item-wise-stock-details", compact("items"));
    }

    public function itemWiseStockDetailsDownload(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        $items = DB::select("select item.item_name,fnc_serviceunitname(stock_su_no_fk) department, sum(stock_trans_qty) qty, item.item_no_pk
                    from inv_itemstocktranschd chd, sysc_serviceitem item
                    where item_no_fk = $request->id
                    and chd.item_no_fk = item.item_no_pk
                    group by item.item_name, stock_su_no_fk, item.item_no_pk
                    order by 2, 1");

        $pdf = PDF::loadView("admin.reports.item-wise-stock-details-pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'userInfo' => $userInfo, 'items' => $items]);
        return $pdf->stream('daily_attendance_print_report.pdf');
    }

    public function itemWiseStockFilter(Request $request)
    {
        $whereClause = "";

        if ($request->item_type != null) {
            $whereClause .= " AND item_type = '" . $request->item_type . "'";
        }

        if ($request->item_name != null) {
            $whereClause .= " AND itm.item_name = '" . $request->item_name . "'";
        }

        $items = DB::select("select itm.item_code, itm.item_name,store.serviceunit_name, itm.generic_no_fk, gen.generic_name, itm.supplier_pk_no, sup.supplier_name, item_type, sum(balance_qty) stock_qty, itm.ITEM_NO_PK, itm.purchase_price, itm.sales_price
            from inv_itemstockmst stk, sysc_serviceitem itm, inv_supplier sup, sysc_generic gen,sysc_serviceunit_vw store
            where itm.item_no_pk = stk.item_no_fk
            and itm.supplier_pk_no = sup.supplier_no_pk(+)
            and itm.generic_no_fk = gen.generic_no_pk(+)
            and store.serviceunit_no_pk =stk.stock_su_no_fk  $whereClause
            group by itm.item_code, itm.item_name,store.serviceunit_name, itm.generic_no_fk, itm.supplier_pk_no, item_type, sup.supplier_name, gen.generic_name, itm.ITEM_NO_PK, itm.purchase_price, itm.sales_price
            order by item_type, 2");
        // dd($items);
        return Template::loadView("admin.reports.item-wise-stock-table", compact("items"));
    }

    public function itemWiseStockDownload(Request $request)
    {
        $whereClause = "";

        if ($request->item_type != null) {
            $whereClause .= " AND item_type = '" . $request->item_type . "'";
        }

        if ($request->item_name != null) {
            $whereClause .= " AND itm.item_name = '" . $request->item_name . "'";
        }

        $items = DB::select("select itm.item_code, itm.item_name,store.serviceunit_name, itm.generic_no_fk, gen.generic_name, itm.supplier_pk_no, sup.supplier_name, item_type, sum(balance_qty) stock_qty, itm.purchase_price, itm.sales_price
            from inv_itemstockmst stk, sysc_serviceitem itm, inv_supplier sup, sysc_generic gen ,sysc_serviceunit_vw store
            where itm.item_no_pk = stk.item_no_fk
            and itm.supplier_pk_no = sup.supplier_no_pk(+)
            and itm.generic_no_fk = gen.generic_no_pk(+)
            and store.serviceunit_no_pk =stk.stock_su_no_fk $whereClause
            group by itm.item_code, itm.item_name,store.serviceunit_name, itm.generic_no_fk, itm.supplier_pk_no, item_type, sup.supplier_name, gen.generic_name, itm.purchase_price, itm.sales_price
            order by item_type, 2");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        if ($request->input('print_type') === 'pdf') {
            $pdf = PDF::loadView("admin.reports.item-wise-stock-pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'userInfo' => $userInfo, 'items' => $items])->setPaper('a4', 'landscape');
            return $pdf->stream('daily_attendance_print_report.pdf');
        }

        if ($request->input('print_type') === 'excel') {
            $result = ["po_hospital_details" => $po_hospital_details, 'userInfo' => $userInfo, 'items' => $items];
            $fileToExport = "item-wise-stock-report";
            $html = View("admin.reports.item-wise-stock-excel")->with($result);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function assetWorklist()
    {
        $item_types = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk', 'itemtype_code')
            ->orderBy('item_name')
            ->get();

        $service_units = DB::select("SELECT DISTINCT serviceunit_no_pk, serviceunit_name
                            FROM SYSC_SERVICEUNIT WHERE ASSET_IND = 1 OR ASSET_SUB_STORE_IND = 1 AND AU_ENTRY_HOSPITAL_PK_NO = " . Session::get('user.ses_hospital_no_pk') . " ORDER BY serviceunit_name ASC");

        $items = collect([]);

        return Template::loadView("admin.reports.asset-worklist.index", compact("item_types", "service_units", "items"));
    }

    private function getFilterData(Request $request)
    {
        $whereClause = " '1' = '1' ";

        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : "";
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : "";

        if ($from_date != "" && $to_date != "") {
            $whereClause .= " AND GRN_DATE BETWEEN TO_DATE('$from_date', 'dd/mm/yyyy') AND TO_DATE('$to_date','dd/mm/yyyy')";
        }

        if ($request->input('department') != "") {
            $whereClause .= " AND ITEM_SERVICEUNIT_NAME = '" . $request->input('department') . "'";
        }

        if ($request->input('item_id') != "") {
            $whereClause .= " AND ITEM_NO_FK = '" . $request->input('item_id') . "'";
        }

        // $items = DB::select("SELECT GRN_DATE, ITEM_NAME, ASSET_TAG_UID, ITEM_SERVICEUNIT_NAME, CURR_USER_INCHARGE, UNIT_VALUE,      CURR_LOCATION_ROOM, CURR_LOCATION_ROOM_NAME, building_name, floor_name, item_serviceunit_code, ITY_GROUP_HEADER_CODE
        //             FROM FAS_ASSETREGISTER_FULL_VW WHERE $whereClause");

        $items = DB::select("SELECT GRN_DATE,
                            ITEM_NAME,
                            ASSET_TAG_UID,
                            ITEM_SERVICEUNIT_NAME,
                            CURR_USER_INCHARGE,
                            UNIT_VALUE,
                            CURR_LOCATION_ROOM,
                            CURR_LOCATION_ROOM_NAME,
                            building_name,
                            floor_name,
                            item_serviceunit_code,
                            ITY_GROUP_HEADER_CODE,
                            UNIT.SERVICEUNIT_NAME AS person_dept
                        FROM FAS_ASSETREGISTER_FULL_VW
                            LEFT JOIN hrms_personnel pers ON PERSON_NO_FK = pers.PERSON_NO_pK
                            LEFT JOIN sysc_serviceunit unit
                                ON pers.SERVICEUNIT_NO_FK = unit.SERVICEUNIT_NO_pK WHERE $whereClause");

        return $items;
    }

    public function assetWorklistFilter(Request $request)
    {
        $items = $this->getFilterData($request);

        return Template::loadView("admin.reports.asset-worklist.table", compact("items"));
    }

    public function assetWorklistDownload(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        $items = $this->getFilterData($request);

        if ($request->input('print_type') === 'pdf') {
            $pdf = PDF::loadView("admin.reports.asset-worklist.pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'userInfo' => $userInfo, 'items' => $items])->setPaper('a4', 'landscape');
            return $pdf->stream('daily_attendance_print_report.pdf');
        }

        if ($request->input('print_type') === 'excel') {

            $result = ["po_hospital_details" => $po_hospital_details, 'userInfo' => $userInfo, 'items' => $items];
            $fileToExport = "asset-report";
            $html = View("admin.reports.asset-worklist.excel")->with($result);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    protected function formatDate($dateString)
    {
        return $dateString;
    }

    public function fincOPDCollection()
    {
        $service_unit = DB::select("select distinct serviceunit_name
                        from finc_opdcollection order by serviceunit_name");
        $module_name = DB::select("select distinct Item_type_head
                        from finc_opdcollection order by Item_type_head");

          $datas      = DB::table('finc_opdcollection')
                        ->where('LEDGERTRN_DATE', '>=', DB::raw('SYSDATE - 7'))
                        ->orderBy('invoice_no_fk', 'desc')
                        ->get();

        return Template::loadView('admin.reports.financial.finc_opdcollection', ['datas' => $datas, 'service_unit' => $service_unit, 'module_name' => $module_name]);
    }

    public function fincOPDCollectionSearch(Request $request)
    {
        if ($request->su_name) {
            $datas = DB::table('finc_opdcollection')
                    ->where('serviceunit_name', '=', $request->su_name)
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if ($request->module_name) {
            $datas = DB::table('finc_opdcollection')
                    ->where('item_type_head', '=', $request->module_name)
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date) && isset($request->module_name)) {
            $datas = DB::table('finc_opdcollection')
                    ->where('item_type_head', '=', $request->module_name)
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('finc_opdcollection')
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->su_name) && isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('finc_opdcollection')
                    ->where('serviceunit_name', '=', $request->su_name)
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }
        // dd($datas);
        return Template::loadView('admin.reports.financial.finc_opdcollection_search', ['datas' => $datas]);
    }


    public function fincOPDCollectionReportPDF(Request $request)
    {
        if ($request->su_name) {
            $datas = DB::table('finc_opdcollection')
                    ->where('serviceunit_name', '=', $request->su_name)
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if ($request->module_name) {
            $datas = DB::table('finc_opdcollection')
                    ->where('item_type_head', '=', $request->module_name)
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date) && isset($request->module_name)) {
            $datas = DB::table('finc_opdcollection')
                    ->where('item_type_head', '=', $request->module_name)
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('finc_opdcollection')
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }

        if (isset($request->su_name) && isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('finc_opdcollection')
                    ->where('serviceunit_name', '=', $request->su_name)
                    ->where(DB::raw('trunc(ledgertrn_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(ledgertrn_date)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->orderBy('invoice_no_fk', 'desc')
                    ->get();
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // $pdf = PDF::loadView("admin.reports.financial.finc_opdcollection_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "datas" => $datas])->setPaper('a4', 'potrait');
        // return View("admin.reports.financial.finc_opdcollection_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "datas" => $datas]);
        // return $pdf->stream('OPD-Financial-Coleection-Report.pdf');

        if($request->input('download_type') == 'PDF') {
            $pdf = PDF::loadView("admin.reports.financial.finc_opdcollection_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "datas" => $datas])->setPaper('a4', 'potrait');
            return $pdf->stream('OPD-Financial-Coleection-Report.pdf');
            // return view("admin.reports.hrm.daily_attendance_print_report_v1", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $dailAttendanceReportPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'dept' => $dept_con, 'desig' => $desig_con, 'card' => $card, 'att_status_con' => $att_status_condition]);
            // return $pdf->stream('daily_attendance_print_report.pdf');
        }

        if($request->input('download_type') == 'EXCEL') {
            $data = ["po_hospital_details" => $po_hospital_details, "datas" => $datas];
            // dd($data);
            $fileToExport = "OPD-Financial-Coleection-Report";
            $html = View("admin.reports.financial.finc_opdcollection_report_excel")->with($data);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }



    public function OPDSellsReport()
    {

        $item_name = DB::select("select distinct item_no_fk,item.item_name
                        from INV_ITEMSTOCKTRANSCHD dtl,sysc_serviceitem item
                        where  dtl.item_no_fk=item.item_no_pk
                        and TRANS_TYPE in ('SALES','SALESRETURN')");
        $department_name = DB::select("select distinct serviceunit_no_pk,serviceunit_name departmet
                        from inv_itemstocktranschd dtl,sysc_serviceunit unit
                        where  dtl.stock_su_no_fk=unit.serviceunit_no_pk
                        and trans_type in ('SALES','SALESRETURN')");
        return Template::loadView('admin.reports.opd_sells_report', ['item_name' => $item_name, 'department_name' => $department_name]);
    }


    public function OPDSellsSearch(Request $request)
    {

        //    $dpt      = explode('-', $request->department);
        //    $dpt_no   = $dpt[0];
        //    $dpt_name = $dpt[1];
        //     if (isset($request->department)) {
        //         $data = DB::select("select item_no_fk, gen.generic_name, item.item_name,
        //                     sum(nvl(case when TRANS_TYPE='SALES' then abs(STOCK_TRANS_QTY) end, 0) - nvl(case when TRANS_TYPE='SALESRETURN' then STOCK_TRANS_QTY end, 0)) qty,
        //                     item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
        //                     from INV_ITEMSTOCKTRANSCHD dtl, sysc_serviceitem item, sysc_serviceunit unit, inv_supplier supp, sysc_generic gen
        //                     where item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
        //                     and dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
        //                     and dtl.item_no_fk = item.item_no_pk
        //                     and gen.generic_no_pk = item.generic_no_fk
        //                     and TRANS_TYPE in ('SALES', 'SALESRETURN')
        //                     and unit.serviceunit_no_pk = :serviceunit_no_pk
        //                     group by item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE", ['serviceunit_no_pk' => $dpt_no]);
        //     }

        //     if (isset($request->item_name)) {
        //         $data = DB::select("select item_no_fk, gen.generic_name, item.item_name,
        //                     sum(nvl(case when TRANS_TYPE='SALES' then abs(STOCK_TRANS_QTY) end, 0) - nvl(case when TRANS_TYPE='SALESRETURN' then STOCK_TRANS_QTY end, 0)) qty,
        //                     item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
        //                     from INV_ITEMSTOCKTRANSCHD dtl, sysc_serviceitem item, sysc_serviceunit unit, inv_supplier supp, sysc_generic gen
        //                     where item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
        //                     and dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
        //                     and dtl.item_no_fk = item.item_no_pk
        //                     and gen.generic_no_pk = item.generic_no_fk
        //                     and TRANS_TYPE in ('SALES', 'SALESRETURN')
        //                     and item.item_no_pk = :item_no_pk
        //                     group by item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE", ['item_no_pk' => $request->item_name]);
        //     }

        //     if (isset($request->from_date) && isset($request->to_date)) {

        //         $data = DB::select("select item_no_fk,gen.generic_name,item.item_name,
        //                     sum(nvl(case when TRANS_TYPE='SALES' then abs(STOCK_TRANS_QTY) end,0) - nvl(case  when TRANS_TYPE='SALESRETURN' then STOCK_TRANS_QTY end,0)) qty,
        //                     item_rate, PURCHASE_PRICE, serviceunit_name store_name,SUPPLIER_NAME supplier_name
        //                     from INV_ITEMSTOCKTRANSCHD dtl,sysc_serviceitem item,sysc_serviceunit unit,inv_supplier supp,sysc_generic gen
        //                     where ITEM.SUPPLIER_PK_NO=SUPP.SUPPLIER_NO_PK
        //                     and dtl.STOCK_SU_NO_FK=unit.serviceunit_no_pk
        //                     and dtl.item_no_fk=item.item_no_pk
        //                     and gen.generic_no_pk=item.generic_no_fk
        //                     and TRANS_TYPE in ('SALES','SALESRETURN')
        //                     and trunc(dtl.AU_ENTRY_AT) between to_date('$request->from_date','dd/mm/yyyy') and to_date('$request->to_date','dd/mm/yyyy')
        //                     group by item_no_fk,item.item_name,serviceunit_name,item_rate,SUPPLIER_NAME,gen.generic_name,PURCHASE_PRICE");
        //     }

        //     if (isset($request->department) && isset($request->from_date) && isset($request->to_date)) {
        //         $data = DB::select("select item_no_fk, gen.generic_name, item.item_name,
        //         sum(nvl(case when TRANS_TYPE='SALES' then abs(STOCK_TRANS_QTY) end, 0) - nvl(case when TRANS_TYPE='SALESRETURN' then STOCK_TRANS_QTY end, 0)) qty,
        //         item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
        //         from INV_ITEMSTOCKTRANSCHD dtl, sysc_serviceitem item, sysc_serviceunit unit, inv_supplier supp, sysc_generic gen
        //         where item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
        //         and dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
        //         and dtl.item_no_fk = item.item_no_pk
        //         and gen.generic_no_pk = item.generic_no_fk
        //         and TRANS_TYPE in ('SALES', 'SALESRETURN')
        //         and unit.serviceunit_no_pk = :serviceunit_no_pk
        //         and trunc(dtl.AU_ENTRY_AT) between to_date(:from_date, 'dd/mm/yyyy') and to_date(:to_date, 'dd/mm/yyyy')
        //         group by item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE", [
        //             'serviceunit_no_pk' => $dpt_no,
        //             'from_date' => $request->from_date,
        //             'to_date' => $request->to_date
        //         ]);
        //     }

        //     if (isset($request->item_name) && isset($request->from_date) && isset($request->to_date)) {
        //         $data = DB::select("select item_no_fk, gen.generic_name, item.item_name,
        //                     sum(nvl(case when TRANS_TYPE='SALES' then abs(STOCK_TRANS_QTY) end, 0) - nvl(case when TRANS_TYPE='SALESRETURN' then STOCK_TRANS_QTY end, 0)) qty,
        //                     item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
        //                     from INV_ITEMSTOCKTRANSCHD dtl, sysc_serviceitem item, sysc_serviceunit unit, inv_supplier supp, sysc_generic gen
        //                     where item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
        //                     and dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
        //                     and dtl.item_no_fk = item.item_no_pk
        //                     and gen.generic_no_pk = item.generic_no_fk
        //                     and TRANS_TYPE in ('SALES', 'SALESRETURN')
        //                     and item.item_no_pk = :item_no_pk
        //                     and trunc(dtl.AU_ENTRY_AT) between to_date(:from_date, 'dd/mm/yyyy') and to_date(:to_date, 'dd/mm/yyyy')
        //                     group by item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE", [
        //                         'item_no_pk' => $request->item_name,
        //                         'from_date' => $request->from_date,
        //                         'to_date' => $request->to_date
        //                     ]);
        //     }




        if (isset($request->department)) {
            $dpt = explode('-', $request->department);

            if (count($dpt) < 2) {
                return response()->json(['error' => 'Invalid department format'], 400);
            }

            $dpt_no = $dpt[0];
            $dpt_name = $dpt[1];
        }

        $query = "SELECT item_no_fk, gen.generic_name, item.item_name,
                SUM(NVL(CASE WHEN TRANS_TYPE='SALES' THEN ABS(STOCK_TRANS_QTY) END, 0)
                - NVL(CASE WHEN TRANS_TYPE='SALESRETURN' THEN STOCK_TRANS_QTY END, 0)) qty,
                item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
              FROM INV_ITEMSTOCKTRANSCHD dtl
              JOIN sysc_serviceitem item ON dtl.item_no_fk = item.item_no_pk
              JOIN sysc_serviceunit unit ON dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
              JOIN inv_supplier supp ON item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
              JOIN sysc_generic gen ON gen.generic_no_pk = item.generic_no_fk
              WHERE TRANS_TYPE IN ('SALES', 'SALESRETURN')";

        $params = [];


        if (isset($dpt_no)) {
            $query .= " AND unit.serviceunit_no_pk = :serviceunit_no_pk";
            $params['serviceunit_no_pk'] = $dpt_no;
        }


        if (isset($request->item_name)) {
            $query .= " AND item.item_no_pk = :item_no_pk";
            $params['item_no_pk'] = $request->item_name;
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $query .= " AND TRUNC(dtl.AU_ENTRY_AT) BETWEEN TO_DATE(:from_date, 'dd/mm/yyyy') AND TO_DATE(:to_date, 'dd/mm/yyyy')";
            $params['from_date'] = $request->from_date;
            $params['to_date'] = $request->to_date;
        }

        $query .= " GROUP BY item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE";

        $data = DB::select($query, $params);
        // dd($data);
        return Template::loadView('admin.reports.opd_sells_report_search', ['datas' => $data]);
    }


    public function OPDSellsReportPDF(Request $request)
    {
        $dpt_name = '';
        if (isset($request->department)) {
            $dpt = explode('-', $request->department);

            if (count($dpt) < 2) {
                return response()->json(['error' => 'Invalid department format'], 400);
            }

            $dpt_no = $dpt[0];
            $dpt_name = $dpt[1];
        }

        $query = "SELECT item_no_fk, gen.generic_name, item.item_name,
                    SUM(NVL(CASE WHEN TRANS_TYPE='SALES' THEN ABS(STOCK_TRANS_QTY) END, 0)
                    - NVL(CASE WHEN TRANS_TYPE='SALESRETURN' THEN STOCK_TRANS_QTY END, 0)) qty,
                    item_rate, PURCHASE_PRICE, serviceunit_name store_name, SUPPLIER_NAME supplier_name
                  FROM INV_ITEMSTOCKTRANSCHD dtl
                  JOIN sysc_serviceitem item ON dtl.item_no_fk = item.item_no_pk
                  JOIN sysc_serviceunit unit ON dtl.STOCK_SU_NO_FK = unit.serviceunit_no_pk
                  JOIN inv_supplier supp ON item.SUPPLIER_PK_NO = supp.SUPPLIER_NO_PK
                  JOIN sysc_generic gen ON gen.generic_no_pk = item.generic_no_fk
                  WHERE TRANS_TYPE IN ('SALES', 'SALESRETURN')";

        $params = [];


        if (isset($dpt_no)) {
            $query .= " AND unit.serviceunit_no_pk = :serviceunit_no_pk";
            $params['serviceunit_no_pk'] = $dpt_no;
        }

        if (isset($request->item_name)) {
            $query .= " AND item.item_no_pk = :item_no_pk";
            $params['item_no_pk'] = $request->item_name;
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $query .= " AND TRUNC(dtl.AU_ENTRY_AT) BETWEEN TO_DATE(:from_date, 'dd/mm/yyyy') AND TO_DATE(:to_date, 'dd/mm/yyyy')";
            $params['from_date'] = $request->from_date;
            $params['to_date'] = $request->to_date;
        }

        $query .= " GROUP BY item_no_fk, item.item_name, serviceunit_name, item_rate, SUPPLIER_NAME, gen.generic_name, PURCHASE_PRICE";

        $data = DB::select($query, $params);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        if($request->hdn_report_type === 'PDF'){
            // $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            // $barcode = new BarcodeGenerator();
            // $barcode->setText($title);
            // $barcode->setType(BarcodeGenerator::Code128);
            // $barcode->setLabel('');
            // $barcode->setScale(1);
            // $barcode->setThickness(25);
            // $barcode->setFontSize(10);
            // $barcode_no = $barcode->generate();
            $pdf = PDF::loadView('admin.reports.opd_sells_report_pdf', ['datas' => $data, "type" => "pdf", "po_hospital_details" => $po_hospital_details, 'dpt_name' => $dpt_name])->setPaper('a4', 'potrait');
            return $pdf->stream('OPD-Sells-Report.pdf');

        }else{

            $fileToExport = "OPD-Sells-Report";
            $html = View('admin.reports.opd_sells_report_exl', ['datas' => $data, "type" => "pdf", "po_hospital_details" => $po_hospital_details, 'dpt_name' => $dpt_name]);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }


    }

    // Doctor Performance report v2 added 05/10/2024
    public function doctorPerformanceSummaryv2()
    {
        $card_no = '';
        $serviceDepts = DB::table('sysc_serviceunit')
            // ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_v2", ['card_no' => $card_no, 'serviceDepts' => $serviceDepts]);
    }


    public function doctorPerformanceSummaryV2Search(Request $request)
    {
        // dd($request->all());
        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        $query = "select su_name,
                    person_no_pk,
                    full_name,
                    INTERNAL_DOCTOR_IND,
                    sum (total_appointment) total_appointment,
                    sum (patient_free) patient_free,
                    sum (total_patient_paid) total_patient_paid,
                    sum (sur_amt) sur_amt,
                    sum (lab_amt) lab_amt,
                    sum (rad_amt) rad_amt,
                    sum (ipd_service_amt) ipd_service_amt,
                    sum (all_other_amt) all_other_amt,
                    sum(ipd_docvisit_amt) ipd_docvisit_amt_count,
                    sum (total_admission_no) total_admission_no,
                    sum (procedure_amount) procedure_amount
                    from FINC_V2_DOCTOR_INCOME_REFPAY_VW
                    $sql_cond
                    group by person_no_pk, full_name, su_name, INTERNAL_DOCTOR_IND
                    order by all_other_amt desc
                    ";
        // echo "select su_name,
        // person_no_pk,
        // full_name,
        // INTERNAL_DOCTOR_IND,
        // sum (total_appointment) total_appointment,
        // sum (patient_free) patient_free,
        // sum (patient_followup_free) patient_followup_free,
        // sum (patient_new_paid) patient_new_paid,
        // sum (total_patient_paid) total_patient_paid,
        // sum (sur_amt) sur_amt,
        // sum (lab_amt) lab_amt,
        // sum (rad_amt) rad_amt,
        // sum (ipd_service_amt) ipd_service_amt,
        // sum (all_other_amt) all_other_amt,
        // sum (total_admission_no) total_admission_no,
        // sum (procedure_amount) procedure_amount
        // from FINC_V2_DOCTOR_INCOME_REFPAY_VW
        // $sql_cond
        // group by person_no_pk, full_name, su_name, INTERNAL_DOCTOR_IND";
        $report_data = DB::select($query);

        $internal_doctors = collect($report_data)->where('internal_doctor_ind', "1");
        $external_doctors = collect($report_data)->where('internal_doctor_ind', "0");
        $ffs_doctors = collect($report_data)->where('internal_doctor_ind', "2");

        $ids = collect([]);
        foreach ($internal_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
            $row->total_overall_income = $total;
        }

        $ids = collect($internal_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        $eds = collect([]);
        foreach ($external_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
            $row->total_overall_income = $total;
        }

        $eds = collect($external_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });


       // for ffs
       $ffs = collect([]);
       foreach ($ffs_doctors as $row) {
           $total = 0;
           $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
           $row->total_overall_income = $total;
       }

       $ffs = collect($ffs_doctors)->sort(function ($a, $b) {
           if ($a->total_overall_income == $b->total_overall_income) {
               return 0;
           }

           return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
       });


       if($request->type === 'INTERNAL'){
           $result = [
               "internal_doctors" => $ids,
               "external_doctors" =>[],
               "ffs_doctors" =>[],
           ];
       }elseif($request->type === 'EXTERNAL'){
           $result = [
               "internal_doctors" => [],
               "external_doctors" => $eds,
               "ffs_doctors" =>[],
           ];
       }elseif($request->type === 'FFS'){
           $result = [
               "internal_doctors" => [],
               "external_doctors" => [],
               "ffs_doctors" =>$ffs,
           ];
       }else{
           $result = [
               "internal_doctors" => $ids,
               "external_doctors" => $eds,
               "ffs_doctors" =>$ffs
           ];
       }
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table_v2", ['result' => $result, 'doctor_income' => $report_data, 'card_no' => $card_no, 'from_date' => $from_date, 'to_date' => $to_date]);
    }

    public function doctorPerformanceReportPdfV2(Request $request)
    {

        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $dept = $request->request_department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause person_no_pk=$card_no" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk=$dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(income_date) between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        $query = "select su_name,
                     person_no_pk,
                     full_name,
                     INTERNAL_DOCTOR_IND,
                     sum (total_appointment) total_appointment,
                     sum (patient_free) patient_free,
                     sum (total_patient_paid) total_patient_paid,
                     sum (sur_amt) sur_amt,
                     sum (lab_amt) lab_amt,
                     sum (rad_amt) rad_amt,
                     sum (ipd_service_amt) ipd_service_amt,
                     sum(ipd_docvisit_amt) ipd_docvisit_amt_count,
                     sum (all_other_amt) all_other_amt,
                     sum (total_admission_no) total_admission_no,
                     sum (procedure_amount) procedure_amount
                     from FINC_V2_DOCTOR_INCOME_REFPAY_VW
                     $sql_cond
                     group by person_no_pk, full_name, su_name, INTERNAL_DOCTOR_IND
                     order by all_other_amt desc
                     ";



        $report_data = DB::select($query);
        // dd($report_data);

        $internal_doctors = collect($report_data)->where('internal_doctor_ind', "1");
        $external_doctors = collect($report_data)->where('internal_doctor_ind', "0");
        $ffs_doctors = collect($report_data)->where('internal_doctor_ind', "2");

        $ids = collect([]);
        foreach ($internal_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
            $row->total_overall_income = $total;
        }

        $ids = collect($internal_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });

        $eds = collect([]);
        foreach ($external_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
            $row->total_overall_income = $total;
        }

        $eds = collect($external_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });


        // for ffs
        $ffs = collect([]);
        foreach ($ffs_doctors as $row) {
            $total = 0;
            $total += ($row->total_patient_paid + $row->procedure_amount + $row->sur_amt + $row->ipd_service_amt + $row->lab_amt + $row->rad_amt + $row->all_other_amt);
            $row->total_overall_income = $total;
        }

        $ffs = collect($ffs_doctors)->sort(function ($a, $b) {
            if ($a->total_overall_income == $b->total_overall_income) {
                return 0;
            }

            return ($a->total_overall_income < $b->total_overall_income) ? 1 : -1;
        });


        if($request->type === 'INTERNAL'){
            $result = [
                "internal_doctors" => $ids,
                "external_doctors" =>[],
                "ffs_doctors" =>[],
            ];
        }elseif($request->type === 'EXTERNAL'){
            $result = [
                "internal_doctors" => [],
                "external_doctors" => $eds,
                "ffs_doctors" =>[],
            ];
        }elseif($request->type === 'FFS'){
            $result = [
                "internal_doctors" => [],
                "external_doctors" => [],
                "ffs_doctors" =>$ffs,
            ];
        }else{
            $result = [
                "internal_doctors" => $ids,
                "external_doctors" => $eds,
                "ffs_doctors" =>$ffs
            ];
        }

        if($request->report_type === 'PDF'){
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            return View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table_v2_pdf", ['barcode_no' => $barcode_no, 'result' => $result, 'doctor_income' => $report_data, 'card_no' => $card_no, 'from_date' => $from_date, 'to_date' => $to_date ,'po_hospital_details' => $po_hospital_details]);

        }else{
            $pdf = ['result' => $result, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];

        $fileToExport = "doctor_performance_summary_report";
        $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_table_v2_pdf")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: text/csv");
        return $html;
        }
    }
    //daliy attendance all punch
    public function dailyAttendanceAllPunch()
    {
        $to_date = date('d-m-Y');
        $dept = DB::select("select distinct unit.serviceunit_no_pk, serviceunit_name, serviceunit_code
        from sysc_serviceunit unit,hrms_personnel per
        where unit.serviceunit_no_pk=per.serviceunit_no_fk
        order by serviceunit_name");
        // dd($dept);
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $allPunchdata = [];

        return Template::loadview("admin.reports.hrm.daily_attendance_all_punch", ['allPunchdata' => $allPunchdata, 'dept' => $dept, 'desig' => $desig]);
    }

    public function searchDailyAttendanceAllPunch(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $personal_no_pk = $request->card_hidn;
        $designation = $request->designation_name;
        $department_name = $request->department_name;
        // dd("ppp");
        // dd($from_date, $to_date);
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();
        // dd($card_no);
        $allPunchdata = DB::table('hrms_check_in_out as chk')
        ->select([
            DB::raw("TO_CHAR(chk.check_time, 'DD-Mon-YY') as check_date"), 'chk.card_no', 'per.full_name', 'desig.designation_name', 'su.serviceunit_name',
            DB::raw("LISTAGG(TO_CHAR(chk.check_time, 'HH:MI AM'), ', ') WITHIN GROUP (ORDER BY chk.check_time) AS checktimes")    ])
        ->leftJoin('hrms_personnel as per', 'per.person_code', '=', 'chk.card_no')
        ->leftJoin('hrms_designation as desig', 'desig.designation_no_pk', '=', 'per.jobtitle_lookup_no_fk')
        ->leftJoin('sysc_serviceunit as su', 'su.serviceunit_no_pk', '=', 'per.serviceunit_no_fk')
        // ->leftJoin('hrms_attendance_daily as att', 'att.PERSON_CARD_NO', '=', 'per.serviceunit_no_fk')
        ->whereBetween(DB::raw('trunc(chk.check_time)'),[$from_date, $to_date])
        ->when(isset($card_no->person_code) && !empty($card_no->person_code), function ($query) use ($card_no) {
            return $query->where('chk.card_no', $card_no->person_code);
        })
        ->when(isset($designation) && !empty($designation), function ($query) use ($designation) {
            return $query->where('per.jobtitle_lookup_no_fk', $designation);
        })
        ->when(isset($department_name) && !empty($department_name), function ($query) use ($department_name) {
            return $query->where('per.serviceunit_no_fk', $department_name);
        })
        ->groupBy( DB::raw("TO_CHAR(chk.check_time, 'DD-Mon-YY')"), 'chk.card_no', 'per.full_name', 'desig.designation_name', 'su.serviceunit_name')
        ->orderBy('chk.card_no', 'asc')
        ->get();

        return Template::loadview("admin.reports.hrm.daily_attendance_all_punch_list", ['allPunchdata' => $allPunchdata]);
    }

    public function printDailyAttendanceAllPunch(Request $request)
    {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $personal_no_pk = $request->card_hidn;
        $designation = $request->designation_name;
        $department_name = $request->department_name;
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();
        $allPunchdata = DB::table('hrms_check_in_out as chk')
        ->select([
            DB::raw("TO_CHAR(chk.check_time, 'DD-Mon-YY') as check_date"), 'chk.card_no', 'per.full_name', 'desig.designation_name', 'su.serviceunit_name',
            DB::raw("LISTAGG(TO_CHAR(chk.check_time, 'HH:MI AM'), ', ') WITHIN GROUP (ORDER BY chk.check_time) AS checktimes")    ])
        ->leftJoin('hrms_personnel as per', 'per.person_code', '=', 'chk.card_no')
        ->leftJoin('hrms_designation as desig', 'desig.designation_no_pk', '=', 'per.jobtitle_lookup_no_fk')
        ->leftJoin('sysc_serviceunit as su', 'su.serviceunit_no_pk', '=', 'per.serviceunit_no_fk')
        ->whereBetween(DB::raw('trunc(chk.check_time)'),[$from_date, $to_date])
        ->when(isset($card_no->person_code) && !empty($card_no->person_code), function ($query) use ($card_no) {
            return $query->where('chk.card_no', $card_no->person_code);
        })
        ->when(isset($designation) && !empty($designation), function ($query) use ($designation) {
            return $query->where('per.jobtitle_lookup_no_fk', $designation);
        })
        ->when(isset($department_name) && !empty($department_name), function ($query) use ($department_name) {
            return $query->where('per.serviceunit_no_fk', $department_name);
        })
        ->groupBy( DB::raw("TO_CHAR(chk.check_time, 'DD-Mon-YY')"), 'chk.card_no', 'per.full_name', 'desig.designation_name', 'su.serviceunit_name')
        ->orderBy('chk.card_no', 'asc')
        ->get();

        $allPunchdataForPrint = [];
        if (!empty($allPunchdata)) {
            foreach ($allPunchdata as $key => $value) {
                $allPunchdataForPrint[$value->full_name . '*' . $value->card_no . '*' . $value->serviceunit_name . '*' . $value->designation_name][] = $value;
            }
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return view("admin.reports.hrm.print_daily_attendance_all_punch", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'value' => $allPunchdataForPrint, 'from_date' => $from_date, 'to_date' => $to_date, 'dept' => $department_name, 'desig' => $designation, 'card' => isset($card_no->person_code) ? $card_no->person_code : ""]);

    }

     //employee bonus
     public function employeeBonus(Request $request) {
        $festivalList = DB::select("select lookupdata_no_pk, lookupdata_name, religion_lookup_no_fk
        from sysc_lookup look, sysc_lookupdata data
        where look.lookup_no_pk=data.lookup_no_fk
        and look.lookup_code='FESTIVAL'");
        return Template::loadview("admin.hrm.employee_bonus.employee_bonus", ['bonusData' => [], 'festivalList' => $festivalList]);

    }
    public function searchEmployeeBonus(Request $request) {
        $festival_date = isset($request->festival_date) ? date("Y-m-d", strtotime($request->festival_date)) : "";
        $festival_cond = ($request->festival != "") ? " and per.religion_lookup_no_fk =  '$request->festival'" : "";
        $bonusData = DB::select("
                    SELECT
                    SAL.PERSON_NO_FK,
                    PERSON_CODE,
                    FULL_NAME,
                    deg.DESIGNATION_NAME designation,
                    JOIN_DATE,
                    ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) SERVICE_LENGTH,
                    FNC_SERVICEUNITNAME(SERVICEUNIT_NO_FK_DEPT) DEPARTMENT,
                    FNC_SERVICEUNITNAME(SERVICEUNIT_NO_FK) UNIT,
                    BOSUSIND.LOOKUPDATA_NAME nature_of_emp,
                    rel.LOOKUPDATA_NAME religion,
                    SAL.GROSS_SALARY,
                    SAL.BASIC_SALARY,
                    CASE
                        WHEN ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) >= 180
                        THEN 100
                        ELSE ROUND(100/180 * ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE))
                    END || '%' bonus_per,
                    CASE
                        WHEN ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) > 180
                        THEN SAL.BASIC_SALARY
                        ELSE ROUND(SAL.BASIC_SALARY/180 * ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE))
                    END bonus_amt,
                    BANK_ACC_NO,
                    BNKNAME.LOOKUPDATA_NAME AS BANK_NAME,
                    BONUS.BONUS_NO_PK,
                    BONUS.REMARKS
                FROM HRMS_PERSONNEL_SALARY SAL,
                    HRMS_PERSONNEL PER,
                    SYSC_LOOKUPDATA BOSUSIND,
                    SYSC_LOOKUPDATA rel,
                    HRMS_DESIGNATION deg,
                    HRMS_PERSONNEL_BONUS bonus,
                    SYSC_LOOKUPDATA bnkname
                WHERE PER.PERSON_NO_PK = SAL.PERSON_NO_FK
                    AND PER.STATUS = 1
                    AND PER.EMP_TYPE_LOOKUP_NO_FK = BOSUSIND.LOOKUPDATA_NO_PK
                    AND PER.RELIGION_LOOKUP_NO_FK = rel.LOOKUPDATA_NO_PK (+)
                    AND PER.JOBTITLE_LOOKUP_NO_FK = deg.DESIGNATION_NO_PK (+)
                    AND SAL.PERSON_NO_FK = BONUS.PERSON_NO_FK(+)
                    AND PER.BANK_LOOK_UP_DATA_FK = BNKNAME.LOOKUPDATA_NO_PK(+)
                    AND BOSUSIND.BONUS_IND = 1
                    AND PER.EMPLOYEE_IND = 1
                    AND SALARY_IND = 1
                    $festival_cond
                    AND ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) > 90
                ORDER BY PERSON_CODE
            ");

            return Template::loadview("admin.hrm.employee_bonus.employee_bonus_list", ['bonusData' => $bonusData, 'festival' => $request->festivalText]);
    }
    public function downloadEmployeeBonus(Request $request) {

        $festival_date = isset($request->festival_date) ? date("Y-m-d", strtotime($request->festival_date)) : "";
        $festival_cond = ($request->festival != "") ? " and per.religion_lookup_no_fk =  '$request->festival'" : "";
        $bonusData = DB::select("
                            SELECT
                            SAL.PERSON_NO_FK,
                            PERSON_CODE,
                            FULL_NAME,
                            deg.DESIGNATION_NAME designation,
                            JOIN_DATE,
                            ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) SERVICE_LENGTH,
                            FNC_SERVICEUNITNAME(SERVICEUNIT_NO_FK_DEPT) DEPARTMENT,
                            FNC_SERVICEUNITNAME(SERVICEUNIT_NO_FK) UNIT,
                            BOSUSIND.LOOKUPDATA_NAME nature_of_emp,
                            rel.LOOKUPDATA_NAME religion,
                            SAL.GROSS_SALARY,
                            SAL.BASIC_SALARY,
                            CASE
                                WHEN ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) >= 180
                                THEN 100
                                ELSE ROUND(100/180 * ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE))
                            END || '%' bonus_per,
                            CASE
                                WHEN ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) > 180
                                THEN SAL.BASIC_SALARY
                                ELSE ROUND(SAL.BASIC_SALARY/180 * ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE))
                            END bonus_amt,
                            BANK_ACC_NO,
                            BNKNAME.LOOKUPDATA_NAME AS BANK_NAME,
                            BONUS.BONUS_NO_PK,
                            BONUS.REMARKS
                        FROM HRMS_PERSONNEL_SALARY SAL,
                            HRMS_PERSONNEL PER,
                            SYSC_LOOKUPDATA BOSUSIND,
                            SYSC_LOOKUPDATA rel,
                            HRMS_DESIGNATION deg,
                            HRMS_PERSONNEL_BONUS bonus,
                            SYSC_LOOKUPDATA bnkname
                        WHERE PER.PERSON_NO_PK = SAL.PERSON_NO_FK
                            AND PER.STATUS = 1
                            AND PER.EMP_TYPE_LOOKUP_NO_FK = BOSUSIND.LOOKUPDATA_NO_PK
                            AND PER.RELIGION_LOOKUP_NO_FK = rel.LOOKUPDATA_NO_PK (+)
                            AND PER.JOBTITLE_LOOKUP_NO_FK = deg.DESIGNATION_NO_PK (+)
                            AND SAL.PERSON_NO_FK = BONUS.PERSON_NO_FK(+)
                            AND PER.BANK_LOOK_UP_DATA_FK = BNKNAME.LOOKUPDATA_NO_PK(+)
                            AND BOSUSIND.BONUS_IND = 1
                            AND PER.EMPLOYEE_IND = 1
                            AND SALARY_IND = 1
                            $festival_cond
                            AND ROUND(TO_DATE('$festival_date', 'YYYY-MM-DD') - JOIN_DATE) > 90
                        ORDER BY PERSON_CODE
            ");
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

            if ($request->status == 'excel') {
                $pdf =  ["type" => "excel", "po_hospital_details" => $po_hospital_details, 'bonusData' => $bonusData, 'festival' => $request->festivalText, 'year'=> $festival_date ? date("Y", strtotime($festival_date)) : ""];
                $fileToExport = "employee_bonus_report";
                $html = View("admin.hrm.employee_bonus.employee_bonus_report")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }else{
                $pdf = PDF::loadView("admin.hrm.employee_bonus.employee_bonus_report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'bonusData' => $bonusData, 'festival' => $request->festivalText, 'year'=> $festival_date ? date("Y", strtotime($festival_date)) : ""])->setPaper('a4', 'landscape');
                return $pdf->stream('employee_bonus_report.pdf');
            }

    }

       // ItemWise summary  Report

    public function itemWiseSummaryReport()
    {

        // $serviceDepts = DB::table('sysc_serviceunit')
        //      ->where('pathology_ind', 1)
        //      ->where('radiology_ind', 1)
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get(['serviceunit_name', 'serviceunit_no_pk']);

            $serviceDepts = DB::table('sysc_serviceunit')
                ->where(function ($query) {
                    $query->where('pathology_ind', 1)
                        ->orWhere('radiology_ind', 1);
                })
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $items = DB::table('sysc_serviceitem_vw')
            ->whereIn('item_type', ['LAB', 'RAD'])
            ->whereNull('container_ind')
            // ->whereNull('analyzer_ind')
            ->get();

            $totalpatient = DB::select("SELECT count(distinct patient_code) as total_patient FROM path_mis_report_vw path WHERE trunc(path.au_entry_at) = trunc(sysdate) AND nvl(path.sc_sample_coll_key_ind, 0) = 1");
            $totalpatientCount = $totalpatient[0]->total_patient ?? 0; // Use null coalescing to default to 0

            $opdpatient = DB::select("SELECT count(distinct patient_code) as opd_patient FROM path_mis_report_vw path WHERE trunc(path.au_entry_at) = trunc(sysdate) AND nvl(path.sc_sample_coll_key_ind, 0) = 1 AND nvl(path.admission_no_fk,0) = 0");
            $opdpatientCount = $opdpatient[0]->opd_patient ?? 0;

            $ipdpatient = DB::select("SELECT count(distinct patient_code) as ipd_patient FROM path_mis_report_vw path WHERE trunc(path.au_entry_at) = trunc(sysdate) AND nvl(path.sc_sample_coll_key_ind, 0) = 1 AND nvl(path.admission_no_fk,0) > 1");
            $ipdpatientCount = $ipdpatient[0]->ipd_patient ?? 0;
$data = [
    'totalpatient' => $totalpatientCount,
    'opdpatient' => $opdpatientCount,
    'ipdpatient' => $ipdpatientCount,
];

        return Template::loadview("admin.reports.item_wise_summary", array_merge(['serviceDepts' => $serviceDepts, 'items' => $items],$data));
    }

public function deptWiseItemListReport(Request $request){
        $items = DB::table('sysc_serviceitem_vw')
        ->where('item_type', 'LAB')
        ->whereNull('container_ind')
        ->where('serviceunit_no_fk',$request->dept)
        ->get();
        return Template::loadview("admin.reports.item_wise_summary_item", ['items' => $items]);
    }
    public function itemWiseSummaryReportSearch(Request $request)
    {
        // dd($request->all());
        $item_name = $request->item_name;
        $entry_point = $request->entry_point;
        $service_unit = $request->request_department;
        $from_date = $request->date_pic;
        $to_date = $request->date_pic2;

        // Initialize SQL conditions
        $sql_cond = [];

        if (!empty($item_name)) {
            $sql_cond[] = "item_no_pk = $item_name";
        }

        // if (!empty($entry_point)) {
        //     $sql_cond[] = "appoint_no_fk = '$entry_point'"; // Use single equals
        // }

        if (!empty($service_unit)) {
            $sql_cond[] = "serviceunit_no_fk = $service_unit";
        }

        if (!empty($from_date) && !empty($to_date)) {
            $sql_cond[] = "trunc(mis.au_entry_at) BETWEEN TO_DATE('$from_date', 'DD/MM/YYYY') AND TO_DATE('$to_date', 'DD/MM/YYYY')";
        }

        // Build the where clause
        $whereClause = !empty($sql_cond) ? 'WHERE ' . implode(' AND ', $sql_cond) : '';

        // Execute the query

        if($entry_point == 'OPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK = 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else if($entry_point == 'IPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK <> 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else{
        $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }

        // Organize data into a structured array
        $data = [];
        if (!empty($query)) {
            foreach ($query as $dt) {
                $data[$dt->serviceunit_name][] = $dt;
            }
        }


        return Template::loadview("admin.reports.item_wise_summary_list", ['data' => $data]);
    }

    public function itemWiseSummaryReportPdf(Request $request)
    {
        //  dd($request->all());

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $item_name = $request->item_name;
        $entry_point = $request->entry_point;
        $service_unit = $request->request_department;
        $from_date = $request->date_pic;
        $to_date = $request->date_pic2;

        // Initialize SQL conditions
        $sql_cond = [];

        if (!empty($item_name)) {
            $sql_cond[] = "item_no_pk = $item_name";
        }

        // if (!empty($entry_point)) {
        //     $sql_cond[] = "appoint_no_fk = '$entry_point'"; // Use single equals
        // }

        if (!empty($service_unit)) {
            $sql_cond[] = "serviceunit_no_fk = $service_unit";
        }

        if (!empty($from_date) && !empty($to_date)) {
            $sql_cond[] = "trunc(mis.au_entry_at) BETWEEN TO_DATE('$from_date', 'DD/MM/YYYY') AND TO_DATE('$to_date', 'DD/MM/YYYY')";
        }

        // Build the where clause
        $whereClause = !empty($sql_cond) ? 'WHERE ' . implode(' AND ', $sql_cond) : '';

        // Execute the query

        if($entry_point == 'OPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK = 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else if($entry_point == 'IPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK <> 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else{
        $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }

        // Organize data into a structured array
        $data = [];
        if (!empty($query)) {
            foreach ($query as $dt) {
                $data[$dt->serviceunit_name][] = $dt;
            }
        }
        // dd($data);
        // dd($data);
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.reports.item_wise_summary_pdf", ['barcode_no' => $barcode_no, 'data' => $data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        // return $pdf->download('item_wise_summary.pdf');


    }

    public function itemWiseSummaryReportExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $item_name = $request->item_name;
        $entry_point = $request->entry_point;
        $service_unit = $request->request_department;
        $from_date = $request->date_pic;
        $to_date = $request->date_pic2;

        // Initialize SQL conditions
        $sql_cond = [];

        if (!empty($item_name)) {
            $sql_cond[] = "item_no_pk = $item_name";
        }

        // if (!empty($entry_point)) {
        //     $sql_cond[] = "appoint_no_fk = '$entry_point'"; // Use single equals
        // }

        if (!empty($service_unit)) {
            $sql_cond[] = "serviceunit_no_fk = $service_unit";
        }

        if (!empty($from_date) && !empty($to_date)) {
            $sql_cond[] = "trunc(mis.au_entry_at) BETWEEN TO_DATE('$from_date', 'DD/MM/YYYY') AND TO_DATE('$to_date', 'DD/MM/YYYY')";
        }

        // Build the where clause
        $whereClause = !empty($sql_cond) ? 'WHERE ' . implode(' AND ', $sql_cond) : '';

        // Execute the query

        if($entry_point == 'OPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK = 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else if($entry_point == 'IPD'){
            $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
                and mis.ADMISSION_NO_FK <> 0
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }else{
        $query = DB::select(DB::raw("
            SELECT
                item_name,
                COUNT(CASE WHEN SC_SAMPLE_COLL_KEY_IND = 1 THEN 1 END) AS collect_quantity,
                COUNT(CASE WHEN LAB_RCV_FROM_SP_KEY_IND = 1 THEN 1 END) AS received_qty,
                COUNT(CASE WHEN LAB_RESULT_VERIFY_KEY_IND = 1 THEN 1 END) AS verified_qty,
                COUNT(CASE WHEN LAB_RESULT_FINAL_KEY_IND = 1 THEN 1 END) AS finalized_qty,
                UNIT.SERVICEUNIT_NAME
            FROM
                PATH_MIS_REPORT_VW mis
                LEFT JOIN sysc_serviceunit unit ON MIS.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $whereClause
            GROUP BY
                item_name,
                UNIT.SERVICEUNIT_NAME
                Order BY UNIT.SERVICEUNIT_NAME, item_name
        "));
        }

        // Organize data into a structured array
        $data = [];
        if (!empty($query)) {
            foreach ($query as $dt) {
                $data[$dt->serviceunit_name][] = $dt;
            }
        }
        // dd($data);
        $pdf = ['data' => $data, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];
        $fileToExport = "item_summary_report_excel";
        $html = View("admin.reports.item_wise_summary_pdf")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function saveEmployeeBonus(Request $request)
    {
        $ids             = isset($request->person_no_fk) ? $request->person_no_fk : [];
        $remarks        = isset($request->remarks) ? $request->remarks : [];
        $bonus_no_pk    = isset($request->bonus_no_pk) ? $request->bonus_no_pk : [];
        $auth_id         = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $au_entry_at     = Carbon::now();
        $au_entry_at     = $au_entry_at->toDateString();
        $sequence = DB::getSequence();
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                $data = [
                    'remarks' => isset($remarks[$id]) ? $remarks[$id] : ""
                ];
                if (empty($bonus_no_pk[$id])) {
                    $data['bonus_no_pk'] = $sequence->nextValue('bonus_no_pk_seq');
                    $data['bonus_yyyymm'] = 2025;
                    $data['person_no_fk'] = $id;
                    $data['au_entry_by'] = $auth_id;
                    $data['au_entry_at'] = $au_entry_at;
                    $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                    $data['au_entry_session'] = 'bonus remarks';
                    DB::table('hrms_personnel_bonus')->insert($data);
                } else {
                    $data['au_update_by'] = $auth_id;
                    $data['au_update_at'] = date('Y-m-d h:i:s');
                    DB::table('hrms_personnel_bonus')->where('bonus_no_pk', $bonus_no_pk[$id])->update($data);
                }
            }
            DB::commit();
            $message = ['msg' => 'Data Save Successfully', 'title' => 'Success'];

        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function cashierWiseReceiptDaily()
    {

            $collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                        ->select([
                            DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'crl.user_code',
                            'crl.cashier_name',
                            'crl.collection',
                            'crl.refund_cash',
                            'crl.refund_card',
                            'crl.refund_mb',
                            'crl.refund_cq',
                            'crl.bkash',
                            'crl.nogod',
                            'crl.rocket',
                            'crl.others',
                            'crl.mbanking',
                            'crl.card',
                            'crl.cheque',
                            'crl.cash',
                            'crl.banglaqr',
                            'crl.refund',
                            'crl.net_collection',
                            'crl.net_cash',
                        ])
                        // ->where('crl.collection', '>', 0)
                        ->whereDate('crl.ledger_date', Carbon::today()->toDateString())
                        ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                        ->get();
            $refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                        ->select([
                            DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'crl.user_code',
                            'crl.cashier_name',
                            'crl.collection',
                            'crl.refund_cash',
                            'crl.refund_mb',
                            'crl.refund_card',
                            'crl.refund_cq',
                            'crl.bkash',
                            'crl.nogod',
                            'crl.rocket',
                            'crl.others',
                            'crl.mbanking',
                            'crl.card',
                            'crl.cheque',
                            'crl.cash',
                            'crl.banglaqr',
                            'crl.refund',
                            'crl.net_collection',
                            'crl.net_cash',
                        ])
                        ->where('crl.refund', '>', 0)
                        ->whereDate('crl.ledger_date', Carbon::today()->toDateString())
                        ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                        ->get();
                        // dd($refunds);

        return Template::loadView('admin.reports.cashier_wise_receipt_listing', [
            'cashier_collections' => $collections,'cashier_refunds' => $refunds,
        ]);
    }
    // doctor payment ladger invoice details
    public function doctorPaymentLedgerInvoiceDetails(Request $request, $invoice_no_pk)
    {
        $invoices = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_serviceitem as si', 'si.item_no_pk', '=', 'dtl.item_no_fk')
            ->join('sysc_itemtype as it', 'it.itemtype_no_pk', '=', 'si.itemtype_no_fk')
            ->select(
                'dtl.item_no_fk',
                'si.item_name',
                'it.item_type_name',
                DB::raw('SUM(dtl.ledgerdtl_amt_sales) as sales'),
                DB::raw('SUM(dtl.ledgerdtl_amt_discount) as discount'),
                DB::raw('SUM(dtl.ledgerdtl_amt_payment) as payment')
            )
            ->where('mst.invoice_no_fk', $invoice_no_pk)
            ->groupBy('dtl.item_no_fk', 'si.item_name', 'it.item_type_name')
            ->get();

        // dd($invoices);

        return view('admin.reports.invoice_details_modal', compact('invoices' , 'invoice_no_pk'));
    }

    // Extranal doctor payment ladger
    // public function externalDoctorPaymentLedger()
    // {
    //     $allData = DB::table('finc_salaried_docledger_vw as doc_ledger')
    //         ->select([
    //             'doc_ledger.invoice_no_pk',
    //             'doc_ledger.invoice_code',
    //             DB::raw("TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date"),
    //             'doc_ledger.patient_no_fk',
    //             'doc_ledger.patient_code',
    //             'doc_ledger.patient_name',
    //             'doc_ledger.cons_type',
    //             'doc_ledger.person_no_fk_doc',
    //             'doc_ledger.doc_code',
    //             'doc_ledger.doc_name',
    //             'doc_ledger.ledger_amt_sales',
    //             'doc_ledger.ledger_amt_payment',
    //             'doc_ledger.ledger_amt_discount',
    //             'doc_ledger.doc_amt',
    //             'doc_ledger.itemtype_no_fk',
    //             'doc_ledger.item_type_name',
    //             'doc_ledger.status',
    //             DB::raw("(doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) as payable"),
    //             DB::raw("((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) as due"),
    //         ])
    //         ->whereRaw("TRUNC(doc_ledger.invoice_date) = TRUNC(SYSDATE)")
    //         ->where('doc_ledger.ledger_amt_sales', '>', 0)
    //         ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name, doc_ledger.patient_no_fk')
    //         ->get();


    //     $doctorLedgers = $allData;

    //     // itemTypes object আকারে
    //     $itemTypes = $allData->unique('itemtype_no_fk')
    //         ->map(function ($i) {
    //             return (object) [
    //                 'itemtype_no_fk' => $i->itemtype_no_fk,
    //                 'item_type_name' => $i->item_type_name,
    //             ];
    //         })
    //         ->sortBy('item_type_name')
    //         ->values();

    //     // doctorData object আকারে
    //     $doctorData = $allData->unique('person_no_fk_doc')
    //         ->map(function ($d) {
    //             return (object) [
    //                 'doc_code' => $d->doc_code,
    //                 'doc_name' => $d->doc_name,
    //                 'person_no_fk_doc' => $d->person_no_fk_doc,
    //             ];
    //         })
    //         ->sortBy('doc_name')
    //         ->values();

    //     return Template::loadView('admin.reports.external_doctor_payment_ledger', [
    //         'doctorLedgers' => $doctorLedgers,
    //         'itemTypes' => $itemTypes,
    //         'doctorData' => $doctorData,
    //     ]);
    // }


    public function externalDoctorPaymentLedger()
    {
        // $doctorData = DB::table('finc_invoicemst as mst')
        //     ->join('hrms_personnel as per', 'mst.person_no_fk', '=', 'per.person_no_pk')
        //     ->join('patn_registration as reg', 'mst.patient_no_fk', '=', 'reg.patient_no_pk')
        //     ->where('per.EMPLOYEE_IND', 1)
        //     ->where('per.DOCTOR_IND', 1)
        //     ->select('mst.person_no_fk as person_no_fk_doc', 'per.full_name as doc_name')
        //     ->distinct()
        //     ->orderBy('per.full_name', 'asc')
        //     ->get();


        // $itemTypes = DB::table('finc_ledgerdtl as ldtl')
        //     ->join('sysc_itemtype as typ', 'ldtl.itemtype_no_fk', '=', 'typ.itemtype_no_pk')
        //     ->select('ldtl.itemtype_no_fk', 'typ.item_type_name')
        //     ->distinct()
        //     ->orderBy('typ.item_type_name', 'asc')
        //     ->get();


        $doctorData = DB::table('hrms_personnel')
            ->where('EMPLOYEE_IND', 1)
            ->where('DOCTOR_IND', 1)
            ->select('person_no_pk as person_no_fk_doc', 'full_name as doc_name')
            ->orderBy('full_name', 'asc')
            ->get();

        $itemTypes = DB::table('sysc_doctorfeemst as dfm')
            ->join('sysc_itemtype as typ', 'dfm.itemtype_no_fk', '=', 'typ.itemtype_no_pk')
            ->select('dfm.itemtype_no_fk', 'typ.item_type_name')
            ->distinct()
            ->orderBy('typ.item_type_name', 'asc')
            ->get();

        // dd($itemTypes);


        $doctorLedgers = collect();

        return Template::loadView('admin.reports.external_doctor_payment_ledger', [
            'doctorLedgers' => $doctorLedgers,
            'itemTypes' => $itemTypes,
            'doctorData' => $doctorData,
        ]);
    }





    public function externalDoctorPaymentLedgerSearch(Request $request)
    {
        $validated = $request->validate([
            'from_date'  => 'required|date_format:d-m-Y',
            'to_date'    => 'required|date_format:d-m-Y',
            'doctor_id'  => 'nullable',  // optional
            'invoice_id' => 'nullable',  // optional
        ]);

        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate   = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        $sql = "
            SELECT
                doc_ledger.invoice_no_pk,
                doc_ledger.invoice_code,
                TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date,
                doc_ledger.patient_no_fk,
                doc_ledger.patient_code,
                doc_ledger.patient_name,
                doc_ledger.cons_type,
                doc_ledger.person_no_fk_doc,
                doc_ledger.doc_code,
                doc_ledger.doc_name,
                doc_ledger.ledger_amt_sales,
                doc_ledger.ledger_amt_payment,
                doc_ledger.ledger_amt_discount,
                doc_ledger.doc_amt,
                doc_ledger.itemtype_no_fk,
                doc_ledger.item_type_name,
                doc_ledger.status,
                (doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) AS payable,
                ((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) AS due
            FROM
                finc_salaried_docledger_vw doc_ledger
            WHERE
                TRUNC(doc_ledger.invoice_date)
                BETWEEN TO_DATE(?, 'YYYY-MM-DD')
                    AND TO_DATE(?, 'YYYY-MM-DD')
                AND doc_ledger.ledger_amt_sales > 0
        ";

        $params = [$fromDate, $toDate];

        if (!empty($request->doctor_id)) {
            $sql .= " AND doc_ledger.person_no_fk_doc = ? ";
            $params[] = $request->doctor_id;
        }

        if (!empty($request->invoice_id)) {
            $sql .= " AND doc_ledger.invoice_no_pk = ? ";
            $params[] = $request->invoice_id;
        }
        if (!empty($request->itemtype_no_fk)) {
            $sql .= " AND doc_ledger.itemtype_no_fk = ? ";
            $params[] = $request->itemtype_no_fk;
        }

        $sql .= "
            ORDER BY
                TRUNC(doc_ledger.invoice_date),
                doc_ledger.patient_no_fk ASC,
                doc_ledger.doc_name
        ";

        $doctorLedgers = DB::select($sql, $params);
        // dd($doctorLedgers);

        return view('admin.reports.external_payment_container', compact('doctorLedgers'));
    }

    public function printExternalDoctorPaymentLedger(Request $request)
    {
        // Fetch hospital details
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // Validate request dates
        $validated = $request->validate([
            'from_date' => 'required|date_format:d-m-Y',
            'to_date'   => 'required|date_format:d-m-Y',
        ]);

        // Convert input dates to Y-m-d for Oracle queries
        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate   = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        // Query for doctor ledger
        $doctorLedgers = DB::table('finc_salaried_docledger_vw as doc_ledger')
            ->select([
                'doc_ledger.invoice_no_pk',
                'doc_ledger.invoice_code',
                DB::raw("TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date"),
                'doc_ledger.patient_no_fk',
                'doc_ledger.patient_code',
                'doc_ledger.patient_name',
                'doc_ledger.cons_type',
                'doc_ledger.person_no_fk_doc',
                'doc_ledger.doc_code',
                'doc_ledger.doc_name',
                'doc_ledger.ledger_amt_sales',
                'doc_ledger.ledger_amt_payment',
                'doc_ledger.ledger_amt_discount',
                'doc_ledger.doc_amt',
                'doc_ledger.itemtype_no_fk',
                'doc_ledger.status',
                DB::raw("(doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) AS payable"),
                DB::raw("((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) AS due")
            ])
            ->whereRaw(
                "TRUNC(doc_ledger.invoice_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                [$fromDate, $toDate]
            )
            ->where('doc_ledger.person_no_fk_doc', $request->doctor_id)
            ->where('doc_ledger.ledger_amt_sales', '>', 0)
            // Add optional filter for itemtype_no_fk
            ->when(!empty($request->itemtype_no_fk), function ($query) use ($request) {
                $query->where('doc_ledger.itemtype_no_fk', $request->itemtype_no_fk);
            })
            ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name')
            ->orderBy('doc_ledger.patient_no_fk', 'asc')
            ->get()
            ->toArray();

        // Check if Excel export
        if ($request->input('Excel') === 'Excel') {
            $fileToExport = "doctor_payment_ledger_excel";
            $html = view('admin.reports.doctor_payment_ledger_excel', compact(
                'po_hospital_details',
                'doctorLedgers',
                'fromDate',
                'toDate'
            ));

            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.reports.doctor_payment_ledger_pdf', [
            'po_hospital_details' => $po_hospital_details,
            'doctorLedgers'       => $doctorLedgers,
            'form_date'           => $fromDate,
            'to_date'             => $toDate,
            'pdf'                 => true
        ]);

        // Add page numbers
        $canvas = $pdf->getDomPDF()->get_canvas();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Courier New", "Courier");
        $canvas->page_text(760, 580, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, [0,0,0]);

        return $pdf->stream('doctor_payment_ledger.pdf');
    }

    public function externalDoctorPaymentLedgerSubmit(Request $request)
    {
        $validated = $request->validate([
            'selected_rows' => 'required|array|min:1',
            'rows' => 'required|array',
        ]);

        $selectedIndexes = $validated['selected_rows'];
        $rows = $validated['rows'];

        $processedRows = [];
        $authId = Auth::id();
        $hospitalId = Session::get('user.ses_hospital_no_pk');
        $entryDate = now()->toDateString();
        $sequence = DB::getSequence();

        $doctorPersonIds = [];
        $totalSales = 0;
        $totalDoctorAmount = 0;

        foreach ($selectedIndexes as $index) {
            if (!isset($rows[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => "Row index [$index] is missing from payload.",
                ], 422);
            }

            $row = $rows[$index];

            if (empty($row['person_no_fk_doc'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Doctor code missing in selected row: $index",
                ], 422);
            }

            $doctorPersonIds[] = $row['person_no_fk_doc'];
            $totalSales += floatval($row['ledger_amt_sales'] ?? 0);
            $totalDoctorAmount += floatval($row['doc_amt'] ?? 0);
        }

        $uniqueDoctors = array_unique($doctorPersonIds);
        if (count($uniqueDoctors) > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Multiple doctors selected. Please select rows for only one doctor at a time.',
            ], 422);
        }

        try {
            DB::beginTransaction();

            $doctorpaymstNoPk = $sequence->nextValue('doctorpaymst_no_pk_seq');

            DB::table('finc_cons_doctorpaymst')->insert([
                'doctorpaymst_no_pk'       => $doctorpaymstNoPk,
                'doctor_person_no_fk'      => $uniqueDoctors[0],
                'payment_process_date'     => DB::raw('SYSDATE'),
                'payment_date'             => null,
                'voucher_no'               => null,
                'ledger_amt_sales'         => $totalSales,
                'doc_amt_total'            => $totalDoctorAmount,
                'status'                   => 1,
                'au_entry_by'              => $authId,
                'au_entry_at'              => DB::raw('SYSDATE'),
                'au_entry_session'         => 'Doctor_Payment',
                'au_entry_hospital_pk_no'  => $hospitalId,
            ]);

            foreach ($selectedIndexes as $index) {
                $row = $rows[$index];

                $processedRows[] = [
                    'doctorpaydtl_no_pk'      => $sequence->nextValue('doctorpaydtl_no_pk_seq'),
                    'doctorpaymst_no_fk'      => $doctorpaymstNoPk,
                    'doctor_person_no_fk'     => $row['person_no_fk_doc'],
                    'item_no_fk'              => $row['itemtype_no_fk'] ?? null,
                    'item_typeno_fk'          => $row['itemtype_no_fk'] ?? null,
                    'invoice_no_fk'           => $row['invoice_no_pk'] ?? null,
                    'patient_no_fk'           => $row['patient_no_fk'] ?? null,
                    'cons_type'               => $row['cons_type'] ?? null,
                    'ledgerdtl_amt_sales'     => $row['ledger_amt_sales'] ?? 0,
                    'doc_amt_item'            => $row['doc_amt'] ?? 0,
                    'au_entry_by'             => $authId,
                    'au_entry_at'             => $entryDate,
                    'au_entry_session'        => 'Doctor_Payment',
                    'au_entry_hospital_pk_no' => $hospitalId,
                ];
            }

            DB::table('finc_cons_doctorpaydtl')->insert($processedRows);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Doctor payments submitted successfully.',
                'data' => [
                    'master_id' => $doctorpaymstNoPk,
                    'rows' => $processedRows,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Submission failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    //End Extranal doctor payment ladger



    public function doctorPaymentLedger()
    {
        // $doctorLedgers = DB::table('finc_opd_ipd_cons_doctor_ledger as doc_ledger')
        //     ->select([
        //         'doc_ledger.invoice_no_pk',
        //         'doc_ledger.invoice_code',
        //         DB::raw("TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date"),
        //         'doc_ledger.patient_no_fk',
        //         'doc_ledger.patient_code',
        //         'doc_ledger.patient_name',
        //         'doc_ledger.cons_type',
        //         'doc_ledger.person_no_fk_doc',
        //         'doc_ledger.doc_code',
        //         'doc_ledger.doc_name',
        //         'doc_ledger.ledger_amt_sales',
        //         'doc_ledger.ledger_amt_payment',
        //         'doc_ledger.ledger_amt_discount',
        //         'doc_ledger.doc_amt',
        //         'doc_ledger.itemtype_no_fk',
        //         'doc_ledger.item_type_name',
        //         'doc_ledger.status',
        //         DB::raw("(doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) as payable"),
        //         DB::raw("((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) as due"),
        //     ])
        //     ->whereDate('doc_ledger.invoice_date', Carbon::today()->toDateString())
        //         ->where('doc_ledger.ledger_amt_sales', '>' ,'0')
        //         ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name')
        //         ->orderBy('doc_ledger.patient_no_fk','asc')
        //         ->get();

        // $itemTypes = DB::table('finc_opd_ipd_cons_doctor_ledger')
        //     ->select('itemtype_no_fk', 'item_type_name')
        //     ->distinct()
        //     ->orderBy('item_type_name', 'asc')
        //     ->get();

        // $doctorData = DB::table('finc_opd_ipd_cons_doctor_ledger')
        //     ->select('doc_code', 'doc_name', 'person_no_fk_doc')
        //     ->distinct()
        //     ->orderBy('doc_name', 'asc')
        //     ->get();


        $itemTypes = DB::table('sysc_doctorfeemst as dfm')
            ->join('sysc_itemtype as typ', 'dfm.itemtype_no_fk', '=', 'typ.itemtype_no_pk')
            ->select('dfm.itemtype_no_fk', 'typ.item_type_name')
            ->distinct()
            ->orderBy('typ.item_type_name', 'asc')
            ->get();
        $doctorData = DB::table('hrms_personnel')
            ->select('person_no_pk as person_no_fk_doc', 'full_name as doc_name')
            ->whereRaw('NVL(EMPLOYEE_IND, 0) = 0')
            ->where('DOCTOR_IND', 1)
            ->orderBy('full_name', 'asc')
            ->get();
        $doctorLedgers = collect();

        return Template::loadView('admin.reports.doctor_payment_ledger', [
            'doctorLedgers' => $doctorLedgers,
            'itemTypes' => $itemTypes,
            'doctorData' => $doctorData,
        ]);
    }


    public function doctorPaymentMaster()
    {
           $doctorPayments = DB::table('finc_cons_doctorpaymst as doc_pay')
                    ->join('hrms_personnel as doc', 'doc_pay.doctor_person_no_fk', '=', 'doc.person_no_pk')
                    ->select([
                        'doc_pay.doctorpaymst_no_pk',
                        'doc_pay.doctor_person_no_fk',
                        DB::raw("TO_CHAR(doc_pay.payment_process_date, 'DD/MM/YYYY') AS payment_process_date"),
                        DB::raw("TO_CHAR(doc_pay.payment_date, 'DD/MM/YYYY') AS payment_date"),
                        'doc_pay.voucher_no',
                        'doc_pay.ledger_amt_sales',
                        'doc_pay.doc_amt_total',
                        DB::raw("doc.full_name as doc_name"),
                        DB::raw("doc.person_code as doc_code"),
                        DB::raw("NVL(doc_pay.acc_pay_amount, 0) as doc_debit_note_amt"),
                    ])
                    ->whereDate('doc_pay.payment_process_date', Carbon::today()->toDateString())
                    ->orderBy('doc_pay.doctor_person_no_fk', 'asc')
                    ->orderBy('doc_pay.payment_date', 'asc')
                    ->get();

        return Template::loadView('admin.reports.doctor_payment_master', [
            'doctorPayments' => $doctorPayments,
        ]);
    }


    public function doctorPaymentLedgerListing()
    {
            $doctorLedgers = DB::table('finc_opd_ipd_cons_doctorledger_listing as doc_ledger')
                ->select([
                    'doc_ledger.*',
                ])
                ->whereDate('doc_ledger.invoice_date', Carbon::today()->toDateString())
                ->where('doc_ledger.ledger_amt_sales', '>' ,'0')
                // ->where('doc_ledger.doc_payment_ind', '=', '1')
                ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name')
                ->orderBy('doc_ledger.patient_no_fk','asc')
                ->get();


            $itemTypes = DB::table('finc_opd_ipd_cons_doctor_ledger')
            ->select('itemtype_no_fk', 'item_type_name')
            ->distinct()
            ->orderBy('item_type_name', 'asc')
            ->get();

                // dd($doctorLedgers);
        return Template::loadView('admin.reports.doctor_payment_ledger_listing', [
            'doctorLedgers' => $doctorLedgers,
            'itemTypes' => $itemTypes,
        ]);
    }


    public function itemIssuedSummaryReport()
    {

         $mainStore = ServiceUnit::where('status', '1')->where('main_store_ind', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

            $issuedSummary = DB::table('inv_l3mstore_issued_summary_vw')
            ->select(
                'serviceunit_no_pk',
                'serviceunit_name',
                'item_no_pk',
                'item_name',
                'supplier_name',
                'current_stock',
                'total_issued',
                'l3missued',
                'lmissued',
                'l3maissued'
            )
            ->where('serviceunit_no_pk', 38035) //initial pharmacy
            ->get();

            $issuedSummaryGroup = $issuedSummary->groupBy('supplier_name')->sortKeys();
           // dd($refunds);

        return Template::loadView('admin.reports.item_issued_summary_report', [
            'issuedSummaryGroup' => $issuedSummaryGroup,'mainStore'=>$mainStore
        ]);
    }


    public function cashierWiseReceiptByType()
    {

            $collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                        ->select([
                            DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'crl.user_code',
                            'crl.cashier_name',
                            'crl.collection',
                            'crl.refund_cash',
                            'crl.refund_card',
                            'crl.refund_mb',
                            'crl.refund_cq',
                            'crl.bkash',
                            'crl.nogod',
                            'crl.rocket',
                            'crl.others',
                            'crl.mbanking',
                            'crl.card',
                            'crl.cheque',
                            'crl.cash',
                            'crl.banglaqr',
                            'crl.refund',
                            'crl.net_collection',
                            'crl.net_cash',
                        ])
                        // ->where('crl.collection', '>', 0)
                        ->whereDate('crl.ledger_date', Carbon::today()->toDateString())
                        ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                        ->get();
            $refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                        ->select([
                            DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'crl.user_code',
                            'crl.cashier_name',
                            'crl.collection',
                            'crl.refund_cash',
                            'crl.refund_mb',
                            'crl.refund_card',
                            'crl.refund_cq',
                            'crl.bkash',
                            'crl.nogod',
                            'crl.rocket',
                            'crl.others',
                            'crl.mbanking',
                            'crl.card',
                            'crl.cheque',
                            'crl.cash',
                            'crl.banglaqr',
                            'crl.refund',
                            'crl.net_collection',
                            'crl.net_cash',
                        ])
                        // ->where('crl.refund', '>', 0)
                        ->whereDate('crl.ledger_date', Carbon::today()->toDateString())
                        ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                        ->get();
                        // dd($refunds);

        return Template::loadView('admin.reports.cashier_receipt_listing_by_type', [
            'cashier_collections' => $collections,'cashier_refunds' => $refunds,
        ]);
    }


    public function cashierWiseReceiptByTypeSearch(Request $request)
        {
             $validated = $request->validate([
                'from_date' => 'required|date_format:d-m-Y',
                'to_date'   => 'required|date_format:d-m-Y',
            ]);

            // Parse dates from dd-mm-yyyy string to Carbon instance (Y-m-d format internally)
            $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

            $cashier_collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                ->select([
                    DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                    'crl.user_code',
                    'crl.cashier_name',
                    'crl.collection',
                    'crl.refund_cash',
                    'crl.refund_card',
                    'crl.refund_cq',
                    'crl.refund_mb',
                    'crl.bkash',
                    'crl.nogod',
                    'crl.rocket',
                    'crl.others',
                    'crl.mbanking',
                    'crl.card',
                    'crl.cheque',
                    'crl.cash',
                    'crl.banglaqr',
                    'crl.refund',
                    'crl.net_collection',
                    'crl.net_cash',
                ])
                // ->where('crl.collection', '>', 0)
                ->whereRaw(
                    "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                    [$fromDate, $toDate]
                )
                ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                ->get();

            $cashier_refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                ->select([
                    DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                    'crl.user_code',
                    'crl.cashier_name',
                    'crl.collection',
                    'crl.refund_cash',
                    'crl.refund_card',
                    'crl.refund_cq',
                    'crl.refund_mb',
                    'crl.bkash',
                    'crl.nogod',
                    'crl.rocket',
                    'crl.others',
                    'crl.mbanking',
                    'crl.card',
                    'crl.cheque',
                    'crl.cash',
                    'crl.banglaqr',
                    'crl.refund',
                    'crl.net_collection',
                    'crl.net_cash',
                ])
                // ->where('crl.refund', '>', 0)
                ->whereRaw(
                    "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                    [$fromDate, $toDate]
                )
                ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                ->get();

               return view('admin.reports.cashier_receipt_listing_bytype_container', compact('cashier_collections', 'cashier_refunds'));
        }

    public function printcashierWiseReceiptByType(Request $request)
    {
              // Fetch hospital details
                $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

                // Validate request dates
                $validated = $request->validate([
                    'from_date' => 'required|date_format:d-m-Y',
                    'to_date'   => 'required|date_format:d-m-Y',
                ]);

                // Convert input dates to Y-m-d for Oracle queries
                $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

                // Query for cashier collections
                $cashier_collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                    ->select([
                        DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                        'crl.user_code',
                        'crl.cashier_name',
                        'crl.collection',
                        'crl.refund_cash',
                        'crl.refund_mb',
                        'crl.refund_card',
                        'crl.refund_cq',
                        'crl.bkash',
                        'crl.nogod',
                        'crl.rocket',
                        'crl.others',
                        'crl.mbanking',
                        'crl.card',
                        'crl.cheque',
                        'crl.cash',
                        'crl.banglaqr',
                        'crl.refund',
                        'crl.net_collection',
                        'crl.net_cash',
                    ])
                    // ->where('crl.collection', '>', 0)
                    ->whereRaw(
                        "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                        [$fromDate, $toDate]
                    )
                    ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                    ->get()->toArray();

                // Query for cashier refunds
                $cashier_refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                    ->select([
                        DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                        'crl.user_code',
                        'crl.cashier_name',
                        'crl.collection',
                        'crl.refund_cash',
                        'crl.refund_card',
                        'crl.refund_mb',
                        'crl.refund_cq',
                        'crl.bkash',
                        'crl.nogod',
                        'crl.rocket',
                        'crl.others',
                        'crl.mbanking',
                        'crl.card',
                        'crl.cheque',
                        'crl.cash',
                        'crl.banglaqr',
                        'crl.refund',
                        'crl.net_collection',
                        'crl.net_cash',
                    ])
                    // ->where('crl.refund', '>', 0)
                    ->whereRaw(
                        "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                        [$fromDate, $toDate]
                    )
                    ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                    ->get()->toArray();

                // Check if user requested Excel export
                if ($request->input('Excel') === 'Excel') {
                    $fileToExport = "cashier_collection_summary_listing_excel";
                    $html = view('admin.reports.cashier_receipt_listing_by_type_excel', compact(
                        'po_hospital_details',
                        'cashier_collections',
                        'cashier_refunds',
                        'fromDate',
                        'toDate',
                    ));

                    // Send Excel headers
                    return response($html)
                        ->header('Content-Type', 'application/vnd.ms-excel')
                        ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
                }

                // Otherwise generate PDF
                $pdf = PDF::loadView('admin.reports.cashier_receipt_listing_by_type_pdf', [
                    'po_hospital_details' => $po_hospital_details,
                    'cashier_collections' => $cashier_collections,
                    'cashier_refunds' => $cashier_refunds,
                    'form_date' => $fromDate,
                    'to_date' => $toDate,
                    'pdf' => true
                ]);
                // $pdf->setPaper('A4', 'landscape');
                // Add page numbers to PDF footer
                $canvas = $pdf->getDomPDF()->get_canvas();
                $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Helvetica", "normal");
                $canvas->page_text(520, 810, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

                // Stream the PDF to browser
                return $pdf->stream('cashier-report-summary-by-type_' . $fromDate . '_' . $toDate . '.pdf');

    }


    public function cashierWiseReceiptDailySearch(Request $request)
        {
             $validated = $request->validate([
                'from_date' => 'required|date_format:d-m-Y',
                'to_date'   => 'required|date_format:d-m-Y',
            ]);

            // Parse dates from dd-mm-yyyy string to Carbon instance (Y-m-d format internally)
            $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

            $cashier_collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                ->select([
                    DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                    'crl.user_code',
                    'crl.cashier_name',
                    'crl.collection',
                    'crl.refund_cash',
                    'crl.refund_card',
                    'crl.refund_cq',
                    'crl.refund_mb',
                    'crl.bkash',
                    'crl.nogod',
                    'crl.rocket',
                    'crl.others',
                    'crl.mbanking',
                    'crl.card',
                    'crl.cheque',
                    'crl.cash',
                    'crl.banglaqr',
                    'crl.refund',
                    'crl.net_collection',
                    'crl.net_cash',
                ])
                // ->where('crl.collection', '>', 0)
                ->whereRaw(
                    "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                    [$fromDate, $toDate]
                )
                ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                ->get();

            $cashier_refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                ->select([
                    DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                    'crl.user_code',
                    'crl.cashier_name',
                    'crl.collection',
                    'crl.refund_cash',
                    'crl.refund_card',
                    'crl.refund_cq',
                    'crl.refund_mb',
                    'crl.bkash',
                    'crl.nogod',
                    'crl.rocket',
                    'crl.others',
                    'crl.mbanking',
                    'crl.card',
                    'crl.cheque',
                    'crl.cash',
                    'crl.banglaqr',
                    'crl.refund',
                    'crl.net_collection',
                    'crl.net_cash',
                ])
                ->where('crl.refund', '>', 0)
                ->whereRaw(
                    "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                    [$fromDate, $toDate]
                )
                ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                ->get();

               return view('admin.reports.cashier_receipt_listing_container', compact('cashier_collections', 'cashier_refunds'));
        }


    public function doctorPaymentLedgerSearch(Request $request)
    {
        $validated = $request->validate([
            'from_date'  => 'required|date_format:d-m-Y',
            'to_date'    => 'required|date_format:d-m-Y',
            'doctor_id'  => 'nullable',  // optional
            'invoice_id' => 'nullable',  // optional
        ]);

        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate   = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        $sql = "
            SELECT
                doc_ledger.invoice_no_pk,
                doc_ledger.invoice_code,
                TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date,
                doc_ledger.patient_no_fk,
                doc_ledger.patient_code,
                doc_ledger.patient_name,
                doc_ledger.cons_type,
                doc_ledger.person_no_fk_doc,
                doc_ledger.doc_code,
                doc_ledger.doc_name,
                doc_ledger.ledger_amt_sales,
                doc_ledger.ledger_amt_payment,
                doc_ledger.ledger_amt_discount,
                doc_ledger.doc_amt,
                doc_ledger.itemtype_no_fk,
                doc_ledger.item_type_name,
                doc_ledger.status,
                (doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) AS payable,
                ((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) AS due
            FROM
                finc_opd_ipd_cons_doctor_ledger doc_ledger
            WHERE
                TRUNC(doc_ledger.invoice_date)
                BETWEEN TO_DATE(?, 'YYYY-MM-DD')
                    AND TO_DATE(?, 'YYYY-MM-DD')
                AND doc_ledger.ledger_amt_sales > 0
        ";

        $params = [$fromDate, $toDate];

        if (!empty($request->doctor_id)) {
            $sql .= " AND doc_ledger.person_no_fk_doc = ? ";
            $params[] = $request->doctor_id;
        }

        if (!empty($request->invoice_id)) {
            $sql .= " AND doc_ledger.invoice_no_pk = ? ";
            $params[] = $request->invoice_id;
        }
        if (!empty($request->itemtype_no_fk)) {
            $sql .= " AND doc_ledger.itemtype_no_fk = ? ";
            $params[] = $request->itemtype_no_fk;
        }

        $sql .= "
            ORDER BY
                TRUNC(doc_ledger.invoice_date),
                doc_ledger.patient_no_fk ASC,
                doc_ledger.doc_name
        ";

        $doctorLedgers = DB::select($sql, $params);
        // dd($doctorLedgers);

        return view('admin.reports.payment_container', compact('doctorLedgers'));
    }



    public function doctorPaymentMasterSearch(Request $request)
        {

            // dd($request->all());
             $validated = $request->validate([
                'from_date' => 'required|date_format:d-m-Y',
                'to_date'   => 'required|date_format:d-m-Y',
            ]);

            $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

            $doctorPayments = DB::table('finc_cons_doctorpaymst as doc_pay')
                ->join('hrms_personnel as doc', 'doc_pay.doctor_person_no_fk', '=', 'doc.person_no_pk')
                    ->select([

                        'doc_pay.doctorpaymst_no_pk',
                        'doc_pay.doctor_person_no_fk',
                        DB::raw("TO_CHAR(doc_pay.payment_process_date, 'DD/MM/YYYY') AS payment_process_date"),
                        DB::raw("TO_CHAR(doc_pay.payment_date, 'DD/MM/YYYY') AS payment_date"),
                        'doc_pay.voucher_no',
                        'doc_pay.ledger_amt_sales',
                        'doc_pay.doc_amt_total',
                        'doc.full_name as doc_name',
                        'doc.person_code as doc_code',
                        DB::raw("NVL(doc_pay.acc_pay_amount, 0) as doc_debit_note_amt"),
                    ])
                    ->whereRaw(
                        "TRUNC(doc_pay.payment_process_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                        [$fromDate, $toDate]
                    )
                    ->when($request->doctor_id, function ($query, $doctorId) {
                                return $query->where('doc_pay.doctor_person_no_fk', $doctorId);
                            })
                    // ->where('doc_pay.doctor_person_no_fk', $request->doctor_id)
                    ->orderBy('doc_pay.doctor_person_no_fk', 'asc')
                    ->orderBy('doc_pay.payment_date', 'asc')
                    ->get();
               return view('admin.reports.payment_container_master', compact('doctorPayments'));
        }


    public function doctorPaymentLedgerListingSearch(Request $request)
    {
        $validated = $request->validate([
            'from_date'  => 'required|date_format:d-m-Y',
            'to_date'    => 'required|date_format:d-m-Y',
            'doctor_id'  => 'required',
            'itemtype_no_fk' => 'nullable'
        ]);

        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate   = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        $query = DB::table('finc_opd_ipd_cons_doctorledger_listing as doc_ledger')
            ->select([
                'doc_ledger.*',
                // 'doc_ledger.invoice_no_pk',
                // 'doc_ledger.itemtype_no_fk',
                // 'doc_ledger.item_type_name',
                // 'doc_ledger.invoice_code',
                // 'doc_ledger.invoice_date',
                // 'doc_ledger.patient_code',
                // 'doc_ledger.patient_no_fk',
                // 'doc_ledger.patient_name',
                // 'doc_ledger.doc_code',
                // 'doc_ledger.doc_name',
                // 'doc_ledger.cons_type',
                // 'doc_ledger.ledger_amt_sales',
                // 'doc_ledger.ledger_amt_payment',
                // 'doc_ledger.ledger_amt_discount',
                // 'doc_ledger.drprcnt',
            ])
            ->whereRaw(
                "TRUNC(doc_ledger.invoice_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                [$fromDate, $toDate]
            )
            // ->where('doc_ledger.doc_payment_ind', '=', '1')
            ->where('doc_ledger.person_no_fk_doc', $request->doctor_id)
            ->where('doc_ledger.ledger_amt_sales', '>', 0);


        // Optional filter by Item Type
        if (!empty($request->itemtype_no_fk)) {
            $query->where('doc_ledger.itemtype_no_fk', $request->itemtype_no_fk);
        }

        if (!empty($request->doc_pay_status)) {
            if($request->doc_pay_status == 1){
                $query->where('doc_ledger.doc_payment_ind', '=', 1);
            } elseif($request->doc_pay_status == 2){
                $query->whereNull('doc_ledger.doc_payment_ind');
            }
        }

        $doctorLedgers = $query
            ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name')
            // ->orderBy('doc_ledger.invoice_date', 'asc')
            ->orderBy('doc_ledger.patient_no_fk', 'asc')
            ->get();


        return view('admin.reports.payment_container_listing', compact('doctorLedgers'));
    }



    public function itemIssuedSummaryReportSearch(Request $request)
        {
             $mainStore = $request->store;

            $issuedSummary = DB::table('inv_l3mstore_issued_summary_vw')
            ->select(
                'serviceunit_no_pk',
                'serviceunit_name',
                'item_no_pk',
                'item_name',
                'supplier_name',
                'current_stock',
                'total_issued',
                'l3missued',
                'lmissued',
                'l3maissued'
            )
            ->where('serviceunit_no_pk', $mainStore) //initial pharmacy
            ->get();

            $issuedSummaryGroup = $issuedSummary->groupBy('supplier_name')->sortKeys();
           // dd($refunds);

               return view('admin.reports.issued_summary_container', compact('issuedSummaryGroup'));
        }


    public function printCashierWiseReceiptListingDaily(Request $request)
    {
              // Fetch hospital details
                $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

                // Validate request dates
                $validated = $request->validate([
                    'from_date' => 'required|date_format:d-m-Y',
                    'to_date'   => 'required|date_format:d-m-Y',
                ]);

                // Convert input dates to Y-m-d for Oracle queries
                $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

                // Query for cashier collections
                $cashier_collections = DB::table('cashier_wise_receipt_listing_vw as crl')
                    ->select([
                        DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                        'crl.user_code',
                        'crl.cashier_name',
                        'crl.collection',
                        'crl.refund_cash',
                        'crl.refund_mb',
                        'crl.refund_card',
                        'crl.refund_cq',
                        'crl.bkash',
                        'crl.nogod',
                        'crl.rocket',
                        'crl.others',
                        'crl.mbanking',
                        'crl.card',
                        'crl.cheque',
                        'crl.cash',
                        'crl.banglaqr',
                        'crl.refund',
                        'crl.net_collection',
                        'crl.net_cash',
                    ])
                    // ->where('crl.collection', '>', 0)
                    ->whereRaw(
                        "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                        [$fromDate, $toDate]
                    )
                    ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                    ->get()->toArray();

                // Query for cashier refunds
                $cashier_refunds = DB::table('cashier_wise_receipt_listing_vw as crl')
                    ->select([
                        DB::raw("TO_CHAR(crl.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                        'crl.user_code',
                        'crl.cashier_name',
                        'crl.collection',
                        'crl.refund_cash',
                        'crl.refund_card',
                        'crl.refund_mb',
                        'crl.refund_cq',
                        'crl.bkash',
                        'crl.nogod',
                        'crl.rocket',
                        'crl.others',
                        'crl.mbanking',
                        'crl.card',
                        'crl.cheque',
                        'crl.cash',
                        'crl.banglaqr',
                        'crl.refund',
                        'crl.net_collection',
                        'crl.net_cash',
                    ])
                    ->where('crl.refund', '>', 0)
                    ->whereRaw(
                        "TRUNC(crl.ledger_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                        [$fromDate, $toDate]
                    )
                    ->orderByRaw('TRUNC(crl.ledger_date), crl.cashier_name')
                    ->get()->toArray();

                // Check if user requested Excel export
                if ($request->input('Excel') === 'Excel') {
                    $fileToExport = "cashier_collection_summary_listing_excel";
                    $html = view('admin.reports.cashier_wise_receipt_listing_excel', compact(
                        'po_hospital_details',
                        'cashier_collections',
                        'cashier_refunds',
                        'fromDate',
                        'toDate',
                    ));

                    // Send Excel headers
                    return response($html)
                        ->header('Content-Type', 'application/vnd.ms-excel')
                        ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
                }

                // Otherwise generate PDF
                $pdf = PDF::loadView('admin.reports.cashier_wise_receipt_listing_pdf', [
                    'po_hospital_details' => $po_hospital_details,
                    'cashier_collections' => $cashier_collections,
                    'cashier_refunds' => $cashier_refunds,
                    'form_date' => $fromDate,
                    'to_date' => $toDate,
                    'pdf' => true // pass this to the view to enable page numbering
                ]);

                // Add page numbers to PDF footer
                $canvas = $pdf->getDomPDF()->get_canvas();
                $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Helvetica", "normal");
                $canvas->page_text(520, 810, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

                // Stream the PDF to browser
                return $pdf->stream('cashier-report.pdf');
    }


    public function printDoctorPaymentLedger(Request $request)
    {
        // Fetch hospital details
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // Validate request dates
        $validated = $request->validate([
            'from_date' => 'required|date_format:d-m-Y',
            'to_date'   => 'required|date_format:d-m-Y',
        ]);

        // Convert input dates to Y-m-d for Oracle queries
        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate   = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        // Query for doctor ledger
        $doctorLedgers = DB::table('finc_opd_ipd_cons_doctor_ledger as doc_ledger')
            ->select([
                'doc_ledger.invoice_no_pk',
                'doc_ledger.invoice_code',
                DB::raw("TO_CHAR(doc_ledger.invoice_date, 'DD/MM/YYYY') AS invoice_date"),
                'doc_ledger.patient_no_fk',
                'doc_ledger.patient_code',
                'doc_ledger.patient_name',
                'doc_ledger.cons_type',
                'doc_ledger.person_no_fk_doc',
                'doc_ledger.doc_code',
                'doc_ledger.doc_name',
                'doc_ledger.ledger_amt_sales',
                'doc_ledger.ledger_amt_payment',
                'doc_ledger.ledger_amt_discount',
                'doc_ledger.doc_amt',
                'doc_ledger.status',
                'doc_ledger.itemtype_no_fk',
                DB::raw("(doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) AS payable"),
                DB::raw("((doc_ledger.ledger_amt_sales - doc_ledger.ledger_amt_discount) - doc_ledger.ledger_amt_payment) AS due")
            ])
            ->whereRaw(
                "TRUNC(doc_ledger.invoice_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                [$fromDate, $toDate]
            )
            ->where('doc_ledger.person_no_fk_doc', $request->doctor_id)
            ->where('doc_ledger.ledger_amt_sales', '>', 0)
            // Add optional filter for itemtype_no_fk
            ->when(!empty($request->itemtype_no_fk), function ($query) use ($request) {
                $query->where('doc_ledger.itemtype_no_fk', $request->itemtype_no_fk);
            })
            ->orderByRaw('TRUNC(doc_ledger.invoice_date), doc_ledger.doc_name')
            ->orderBy('doc_ledger.patient_no_fk', 'asc')
            ->get()
            ->toArray();

        // Check if Excel export
        if ($request->input('Excel') === 'Excel') {
            $fileToExport = "doctor_payment_ledger_excel";
            $html = view('admin.reports.doctor_payment_ledger_excel', compact(
                'po_hospital_details',
                'doctorLedgers',
                'fromDate',
                'toDate'
            ));

            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.reports.doctor_payment_ledger_pdf', [
            'po_hospital_details' => $po_hospital_details,
            'doctorLedgers'       => $doctorLedgers,
            'form_date'           => $fromDate,
            'to_date'             => $toDate,
            'pdf'                 => true
        ]);

        // Add page numbers
        $canvas = $pdf->getDomPDF()->get_canvas();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Courier New", "Courier");
        $canvas->page_text(760, 580, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, [0,0,0]);

        return $pdf->stream('doctor_payment_ledger.pdf');
    }





    public function printDoctorPaymentLedgerListing(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $validated = $request->validate([
            'from_date' => 'required|date_format:d-m-Y',
            'to_date'   => 'required|date_format:d-m-Y',
        ]);

        $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
        $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

        $doctorLedgers = DB::table('finc_opd_ipd_cons_doctorledger_listing as doc_ledger')
            ->select(['doc_ledger.*'])
            ->whereRaw(
                "TRUNC(doc_ledger.invoice_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')",
                [$fromDate, $toDate]
            )
            ->when(!empty($request->doctor_id), function ($query) use ($request) {
                $query->where('doc_ledger.person_no_fk_doc', $request->doctor_id);
            })
            ->where('doc_ledger.ledger_amt_sales', '>', '0')
            ->when(!empty($request->itemtype_no_fk), function ($query) use ($request) {
                $query->where('doc_ledger.itemtype_no_fk', $request->itemtype_no_fk);
            })
            ->when(!empty($request->doc_pay_status), function ($query) use ($request) {
                if ($request->doc_pay_status == 1) {
                    // Paid
                    $query->where('doc_ledger.doc_payment_ind', '=', 1);
                } elseif ($request->doc_pay_status == 2) {
                    // Due
                    $query->whereNull('doc_ledger.doc_payment_ind')
                        ->orWhere('doc_ledger.doc_payment_ind', '=', 0);
                }
            })
            ->orderByRaw('TRUNC(doc_ledger.invoice_date)')
            ->orderBy('doc_ledger.patient_no_fk', 'asc')
            ->get()
            ->toArray();

        // Export Excel
        if ($request->input('Excel') === 'Excel') {
            $fileToExport = "doctor_payment_ledger_excel";
            $html = view('admin.reports.doctor_payment_ledger_listing_excel', compact(
                'po_hospital_details',
                'doctorLedgers',
                'fromDate',
                'toDate',
            ));

            return response($html)
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.reports.doctor_payment_ledger_listing_pdf', [
            'po_hospital_details' => $po_hospital_details,
            'doctorLedgers' => $doctorLedgers,
            'form_date' => $fromDate,
            'to_date' => $toDate,
            'pdf' => true
        ]);

        // Add page numbers
        $canvas = $pdf->getDomPDF()->get_canvas();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Courier New", "Courier");
        $canvas->page_text(760, 580, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, [0, 0, 0]);

        return $pdf->stream('doctor_payment_ledger.pdf');

    }




    public function printItemIssuedSummaryReport(Request $request)
    {
              // Fetch hospital details
                $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

                // Validate request dates
                   $mainStore = $request->store;

            $issuedSummary = DB::table('inv_l3mstore_issued_summary_vw')
            ->select(
                'serviceunit_no_pk',
                'serviceunit_name',
                'item_no_pk',
                'item_name',
                'supplier_name',
                'current_stock',
                'total_issued',
                'l3missued',
                'lmissued',
                'l3maissued'
            )
            ->where('serviceunit_no_pk', $mainStore) //initial pharmacy
            ->get();

            $issuedSummaryGroup = $issuedSummary->groupBy('supplier_name')->sortKeys();

                // Check if user requested Excel export
                if ($request->input('Excel') === 'Excel') {
                    $fileToExport = "item_issued_summary_report";
                    $html = view('admin.reports.item_issued_summary_excel', compact(
                        'po_hospital_details',
                        'issuedSummaryGroup',
                    ));

                    // Send Excel headers
                    return response($html)
                        ->header('Content-Type', 'application/vnd.ms-excel')
                        ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '.xls"');
                }

                // Otherwise generate PDF
                $pdf = PDF::loadView('admin.reports.item_issued_summary_pdf', [
                    'po_hospital_details' => $po_hospital_details,
                    'issuedSummaryGroup' => $issuedSummaryGroup,
                    'pdf' => true // pass this to the view to enable page numbering
                ]);

                // Add page numbers to PDF footer
                $canvas = $pdf->getDomPDF()->get_canvas();
                $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Helvetica", "normal");
                $canvas->page_text(520, 810, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

                // Stream the PDF to browser
                return $pdf->stream('item_issued_summary_report.pdf');
    }



    public function corporateAgingReport()
    {

            $corporateClientInfo = DB::table('ccm_corporate_due_aging_vw as ca')
                        ->select([
                            DB::raw("TO_CHAR(ca.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'ca.invoice_no_fk',
                            'ca.patient_no_fk',
                            'ca.patient_code',
                            'ca.patient_name',
                            'ca.ledger_amt_sales',
                            'ca.ledger_amt_payment',
                            'ca.ledger_amt_discount',
                            'ca.cor_client_no_fk',
                            'ca.ccm_client_code',
                            'ca.ccm_client_name',
                            'ca.due',
                            'ca.days_old',
                            'ca.one_to_30',
                            'ca.thirtyone_to_sixty',
                            'ca.sixtyone_to_90',
                            'ca.ninetyone_to_120',
                            'ca.hundred21_to_150',
                            'ca.hundred51_to_365',
                            'ca.above_365',
                            'ca.module_code'
                        ])
                        ->where('ca.due', '!=', 0)
                        ->orderByRaw( 'ca.ccm_client_name,TRUNC(ca.ledger_date)')
                        ->get();
                        $corporateClientCollection = collect($corporateClientInfo);

                        $groupedClientInfo = $corporateClientCollection->groupBy('ccm_client_code');
                        // dd($corporateClientInfo);

        return Template::loadView('admin.reports.corporate_client_aging_report', [
            'groupedClientInfo' => $groupedClientInfo,//'cashier_refunds' => $refunds,
        ]);
    }


    public function corporateAgingReportSearch(Request $request)
        {
                $validated = $request->validate([
                    // 'from_date' => 'required|date_format:d-m-Y',
                    'to_date'   => 'required|date_format:d-m-Y',
                ]);

                // dd($request);

                // Parse dates from dd-mm-yyyy string to Carbon instance (Y-m-d format internally)
                // $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

                $corporateClientInfo = DB::table('ccm_corporate_due_aging_vw as ca')
                            ->select([
                                DB::raw("TO_CHAR(ca.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                                'ca.invoice_no_fk',
                                'ca.patient_no_fk',
                                'ca.patient_code',
                                'ca.patient_name',
                                'ca.ledger_amt_sales',
                                'ca.ledger_amt_payment',
                                'ca.ledger_amt_discount',
                                'ca.cor_client_no_fk',
                                'ca.ccm_client_code',
                                'ca.ccm_client_name',
                                'ca.due',
                                'ca.days_old',
                                'ca.one_to_30',
                                'ca.thirtyone_to_sixty',
                                'ca.sixtyone_to_90',
                                'ca.ninetyone_to_120',
                                'ca.hundred21_to_150',
                                'ca.hundred51_to_365',
                                'ca.above_365',
                                'ca.module_code'
                            ])
                            ->where('ca.due', '!=', 0)
                            ->whereRaw("TRUNC(ca.ledger_date) <= TO_DATE(?, 'YYYY-MM-DD')", [$toDate])
                            ->orderByRaw( 'ca.ccm_client_name,TRUNC(ca.ledger_date)')
                            ->get();
                            // dd($corporateClientInfo);
                            $corporateClientCollection = collect($corporateClientInfo);

                            $groupedClientInfo = $corporateClientCollection->groupBy('ccm_client_code');

                return view('admin.reports.corporate_aging_detail_container', compact('groupedClientInfo'));
        }

    public function printcorporateAgingReport(Request $request)
    {
                $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

                 $validated = $request->validate([
                    //  'from_date' => 'required|date_format:d-m-Y',
                    'to_date'   => 'required|date_format:d-m-Y',
                 ]);

                // $fromDate = Carbon::createFromFormat('d-m-Y', $validated['from_date'])->format('Y-m-d');
                $toDate = Carbon::createFromFormat('d-m-Y', $validated['to_date'])->format('Y-m-d');

                $today = Carbon::today()->format('d-m-Y');

                $corporateClientInfo = DB::table('ccm_corporate_due_aging_vw as ca')
                        ->select([
                            DB::raw("TO_CHAR(ca.ledger_date, 'DD/MM/YYYY') AS ledger_date"),
                            'ca.invoice_no_fk',
                            'ca.patient_no_fk',
                            'ca.patient_code',
                            'ca.patient_name',
                            'ca.ledger_amt_sales',
                            'ca.ledger_amt_payment',
                            'ca.ledger_amt_discount',
                            'ca.cor_client_no_fk',
                            'ca.ccm_client_code',
                            'ca.ccm_client_name',
                            'ca.due',
                            'ca.days_old',
                            'ca.one_to_30',
                            'ca.thirtyone_to_sixty',
                            'ca.sixtyone_to_90',
                            'ca.ninetyone_to_120',
                            'ca.hundred21_to_150',
                            'ca.hundred51_to_365',
                            'ca.above_365',
                            'ca.module_code'
                        ])
                        ->where('ca.due', '!=', 0)
                        ->whereRaw("TRUNC(ca.ledger_date) <= TO_DATE(?, 'YYYY-MM-DD')", [$toDate])
                        ->orderByRaw( 'ca.ccm_client_name,TRUNC(ca.ledger_date)')
                        ->get();
                        $corporateClientCollection = collect($corporateClientInfo);

                        $groupedClientInfo = $corporateClientCollection->groupBy('ccm_client_code');


                if ($request->input('Excel') === 'Excel') {
                    $fileToExport = "debtor_aging_report";

                    $html = view('admin.reports.corporate_aging_report_excel', compact(
                        'po_hospital_details',
                        'groupedClientInfo',
                        'toDate',
                    ));

                    return response($html)
                        ->header('Content-Type', 'application/vnd.ms-excel')
                        ->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '_' . $today . '.xls"');
                }

                $pdf = PDF::loadView('admin.reports.corporate_aging_report_pdf', [
                                'po_hospital_details' => $po_hospital_details,
                                'groupedClientInfo' => $groupedClientInfo,
                                'toDate' => $toDate,
                                'pdf' => true
                            ]);
                $canvas = $pdf->getDomPDF()->get_canvas();
                $font = $pdf->getDomPDF()->getFontMetrics()->getFont("Helvetica", "normal");
                $canvas->page_text(520, 810, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

                // Stream the PDF to browser
                return $pdf->stream('debtor_details_report' . '_' . $today . '.pdf');

    }

    public function doctorPaymentLedgerSubmit(Request $request)
    {
        $validated = $request->validate([
            'selected_rows' => 'required|array|min:1',
            'rows' => 'required|array',
        ]);

        $selectedIndexes = $validated['selected_rows'];
        $rows = $validated['rows'];

        $processedRows = [];
        $authId = Auth::id();
        $hospitalId = Session::get('user.ses_hospital_no_pk');
        $entryDate = now()->toDateString(); // Laravel helper
        $sequence = DB::getSequence();

        $doctorPersonIds = [];
        $totalSales = 0;
        $totalDoctorAmount = 0;

        foreach ($selectedIndexes as $index) {
            if (!isset($rows[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => "Row index [$index] is missing from payload.",
                ], 422);
            }

            $row = $rows[$index];

            if (empty($row['person_no_fk_doc'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Doctor code missing in selected row: $index",
                ], 422);
            }

            $doctorPersonIds[] = $row['person_no_fk_doc'];
            $totalSales += floatval($row['ledger_amt_sales'] ?? 0);
            $totalDoctorAmount += floatval($row['doc_amt'] ?? 0);
        }

        // Ensure only one doctor is selected
        $uniqueDoctors = array_unique($doctorPersonIds);
        if (count($uniqueDoctors) > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Multiple doctors selected. Please select rows for only one doctor at a time.',
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Insert master record
            $doctorpaymstNoPk = $sequence->nextValue('doctorpaymst_no_pk_seq');

            DB::table('finc_cons_doctorpaymst')->insert([
                'doctorpaymst_no_pk'       => $doctorpaymstNoPk,
                'doctor_person_no_fk'      => $uniqueDoctors[0],
                'payment_process_date'     => DB::raw('SYSDATE'),
                'payment_date'             => null,
                'voucher_no'               => null,
                'ledger_amt_sales'         => $totalSales,
                'doc_amt_total'            => $totalDoctorAmount,
                'status'                   => 1,
                'au_entry_by'              => $authId,
                'au_entry_at'              => DB::raw('SYSDATE'),
                'au_entry_session'         => 'Doctor_Payment',
                'au_entry_hospital_pk_no'  => $hospitalId,
            ]);

            // Prepare detail rows
            foreach ($selectedIndexes as $index) {
                $row = $rows[$index];

                $processedRows[] = [
                    'doctorpaydtl_no_pk'      => $sequence->nextValue('doctorpaydtl_no_pk_seq'),
                    'doctorpaymst_no_fk'      => $doctorpaymstNoPk,
                    'doctor_person_no_fk'     => $row['person_no_fk_doc'],
                    'item_no_fk'              => $row['itemtype_no_fk'] ?? null,
                    'item_typeno_fk'          => $row['itemtype_no_fk'] ?? null,
                    'invoice_no_fk'           => $row['invoice_no_pk'] ?? null,
                    'patient_no_fk'           => $row['patient_no_fk'] ?? null,
                    'cons_type'               => $row['cons_type'] ?? null,
                    'ledgerdtl_amt_sales'     => $row['ledger_amt_sales'] ?? 0,
                    'doc_amt_item'            => $row['doc_amt'] ?? 0,
                    'au_entry_by'             => $authId,
                    'au_entry_at'             => $entryDate,
                    'au_entry_session'        => 'Doctor_Payment',
                    'au_entry_hospital_pk_no' => $hospitalId,
                ];
            }

            DB::table('finc_cons_doctorpaydtl')->insert($processedRows);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Doctor payments submitted successfully.',
                'data' => [
                    'master_id' => $doctorpaymstNoPk,
                    'rows' => $processedRows,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Submission failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroyPaymentMaster($id)
    {

        $result = DB::select(
                'SELECT VOUCHER_NO FROM finc_cons_doctorpaymst WHERE DOCTORPAYMST_NO_PK = :id',
                ['id' => $id]
            );

            $voucher_no = $result[0]->VOUCHER_NO ?? null;

            if ($voucher_no == null) {
                try {
                    DB::beginTransaction(); // ✅ Start transaction

                    DB::table('finc_cons_doctorpaydtl')->where('doctorpaymst_no_fk', $id)->delete();
                    DB::table('finc_cons_doctorpaymst')->where('doctorpaymst_no_pk', $id)->delete();

                    DB::commit(); // ✅ Commit if successful

                    return redirect()->back()->with('success', 'Doctor payment deleted successfully.');
                } catch (\Exception $e) {
                    DB::rollBack(); // 🔁 Rollback on error

                    return redirect()->back()->with('error', 'Error deleting doctor payment: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Doctor payment cannot be deleted.');
            }

    }


    public function paymentDetailsDhow($id)
            {
                $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
                $today = Carbon::today()->format('d-m-Y');

                $results = db::select("
                    select
                        dpv.doctorpaymst_no_pk,
                        dpv.doctor_person_no_fk,
                        dpv.doc_code,
                        dpv.doc_name,
                        dpv.payment_process_date,
                        dpv.payment_date,
                        dpv.voucher_no,
                        dpv.item_no_fk,
                        dpv.item_name,
                        dpv.invoice_no_fk,
                        dpv.patient_no_fk,
                        dpv.cons_type,
                        dpv.acc_payment_status,
                        dpv.ledgerdtl_amt_sales,
                        dpv.doc_amt_item
                    from acc_doctor_payment_details_vw dpv
                    where dpv.doctorpaymst_no_pk = :id
                ", ['id' => $id]);
                return view('admin.reports.doctor_pay_acc_details', ['results' => $results, 'today' => $today,  'po_hospital_details' => $po_hospital_details]);
            }




 public function showDoctorPartialPayment($id)
                {
                    $chartof_accounts = $this->chart_of_acc->get_chart_of_account();

                    $chartof_accounts = collect($chartof_accounts->getData()->data)
                        ->whereIn('bank_ind', [1, 2]);

                    $voucher_type = db::table('acct_voucher_type')
                        ->select('voucher_type_no_pk', 'voucher_type_name')
                        ->whereraw('lower(voucher_type_name) like ?', ['%payment%'])
                        ->get();
                    $verifiedChequeNos = DB::table('acct_checque_verified_listing')
                    ->select('checque_no')
                    ->whereRaw('NVL(cheque_dispach_ind, 0) = 0')
                    ->whereRaw('NVL(status, 0) = 1')
                    ->get();
                    $payment = DB::table('finc_cons_doctorpaymst')
                            ->select(
                                'doctorpaymst_no_pk',
                                'doctor_person_no_fk',
                                'payment_process_date',
                                'payment_date',
                                'voucher_no',
                                DB::raw('COALESCE(ledger_amt_sales, 0) as ledger_amt_sales'),
                                DB::raw('COALESCE(doc_amt_total, 0) as doc_amt_total'),
                                DB::raw('COALESCE(acc_pay_amount, 0) as acc_pay_amount'),
                                DB::raw('COALESCE(vat_amount, 0) as vat_amount'),
                                DB::raw('COALESCE(tax_amount, 0) as tax_amount'),
                                DB::raw('COALESCE(doc_amt_total, 0) - (COALESCE(vat_amount, 0) + COALESCE(tax_amount, 0) + COALESCE(acc_pay_amount, 0)) as due')
                            )
                            ->where('doctorpaymst_no_pk', $id)
                            ->first();
// dd($payment);


                    return view('admin.reports.doctor_payment_modal', compact('payment', 'chartof_accounts', 'voucher_type', 'verifiedChequeNos'));
                }

public function doctorPaymentEntry(Request $request)
{
       $request->validate([
        'paid_amount'   => 'required|numeric|min:0',
        'remarks'       => 'nullable|max:500',
        'grn_no'        => 'required|integer|exists:finc_cons_doctorpaymst,doctorpaymst_no_pk',
        'amount_vat'    => 'nullable|numeric|min:0',
        'amount_tax'    => 'nullable|numeric|min:0',
        'cheque_no'     => 'nullable|string|max:50',
        'cheque_date'   => 'nullable|date',
        'general_ledger'=> 'nullable|integer',
        'payment_type'  => 'nullable|string|max:100'
    ]);

    DB::beginTransaction();

    try {
        $au_entry_at        = now()->toDateString();
        $hospital_pk_no     = session()->get('user.ses_hospital_no_pk');
        $entry_session      = session()->get('user.ses_user_pk_no');
        $grn_no             = $request->grn_no;

        $payment_data = DB::table('finc_cons_doctorpaymst')
            ->where('doctorpaymst_no_pk', $grn_no)
            ->where('status', 1)
            ->first();

        if ($request->paid_amount == 0) {
            return response()->json(['title' => 'Error', 'msg' => 'Paid Amount will be greater than Zero(0)', 'success' => false], 422);
        }

        if (!$payment_data) {
            return response()->json(['title' => 'Error', 'msg' => 'Invalid Doctor or inactive payment record.', 'success' => false], 422);
        }

        $doctor_person_no = $payment_data->doctor_person_no_fk;

        $pre_paid_amount = DB::table('acct_cons_doctorpaydtl')
            ->where('doctorpaymst_no_fk', $grn_no)
            ->sum('paid_amount');

        $pre_paid_amount_vat = DB::table('acct_cons_doctorpaydtl')
            ->where('doctorpaymst_no_fk', $grn_no)
            ->sum('paid_amt_vat');

        $pre_paid_amount_tax = DB::table('acct_cons_doctorpaydtl')
            ->where('doctorpaymst_no_fk', $grn_no)
            ->sum('paid_amt_tax');

        // Prepare stored procedure inputs
        $pdo = DB::getPdo();
        $in_narration            = $request->remarks ?? 'Doctor Payment';
        $in_integration_type     = 'SUPPPAYMENT';
        $in_amount               = $request->paid_amount ?? 0;
        $in_general_ledger       = $request->general_ledger ?? 0;
        $in_payment_type         = $request->payment_type ?? 'CASH PAYMENT';
        $in_cheque_no            = $request->cheque_no ?? 'NA';
        $in_cheque_date          = $request->cheque_date ? date('d-M-Y', strtotime($request->cheque_date)) : $au_entry_at;
        $in_amount_vat           = $request->amount_vat ?? 0;
        $in_amount_tax           = $request->amount_tax ?? 0;
        $in_au_entry_by          = Auth::id();
        $in_au_entry_session     = $entry_session;
        $in_au_entry_hospital_pk_no = $hospital_pk_no;

        // Output params
        $out_jurnal_code = null;
        $out_error = null;

        // Stored procedure call
        $supplier_payment = $pdo->prepare("begin pkg_v1_accounts.prc_journal_doctorpayment(
            :in_person_no_fk,
            :in_narration,
            :in_integration_type,
            :in_amount,
            :in_gl_acc_no_fk,
            :in_payment_type,
            :in_check_no,
            :in_check_date,
            :in_vat_amt,
            :in_tax_amt,
            :in_grn_no,
            :in_AU_ENTRY_BY,
            :in_au_entry_session,
            :in_AU_ENTRY_HOSPITAL_PK_NO,
            :out_jurnal_code,
            :out_error
        ); end;");

        $supplier_payment->bindParam('in_person_no_fk', $doctor_person_no);
        $supplier_payment->bindParam('in_narration', $in_narration);
        $supplier_payment->bindParam('in_integration_type', $in_integration_type);
        $supplier_payment->bindParam('in_amount', $in_amount);
        $supplier_payment->bindParam('in_gl_acc_no_fk', $in_general_ledger);
        $supplier_payment->bindParam('in_payment_type', $in_payment_type);
        $supplier_payment->bindParam('in_check_no', $in_cheque_no);
        $supplier_payment->bindParam('in_check_date', $in_cheque_date);
        $supplier_payment->bindParam('in_vat_amt', $in_amount_vat, PDO::PARAM_STR);
        $supplier_payment->bindParam('in_tax_amt', $in_amount_tax, PDO::PARAM_STR);
        $supplier_payment->bindParam('in_grn_no', $grn_no);
        $supplier_payment->bindParam('in_AU_ENTRY_BY', $in_au_entry_by);
        $supplier_payment->bindParam('in_au_entry_session', $in_au_entry_session);
        $supplier_payment->bindParam('in_AU_ENTRY_HOSPITAL_PK_NO', $in_au_entry_hospital_pk_no);
        $supplier_payment->bindParam('out_jurnal_code', $out_jurnal_code, PDO::PARAM_STR, 500);
        $supplier_payment->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);

        $supplier_payment->execute();

        // Check for errors
        if ($out_error != '000') {
            DB::rollBack();
            \Log::error("Stored procedure error: " . $out_error);
            return response()->json(['title' => 'Error', 'msg' => $out_error, 'success' => false], 422);
        }

        // Proceed if journal code returned
        if (!empty($out_jurnal_code)) {
            // Calculate totals
            $total_paid_amount = $in_amount + $pre_paid_amount;
            $total_vat_amount  = $in_amount_vat + $pre_paid_amount_vat;
            $total_tax_amount  = $in_amount_tax + $pre_paid_amount_tax;

            // Update master table
            DB::table('finc_cons_doctorpaymst')
                ->where('doctorpaymst_no_pk', $grn_no)
                ->update([
                    'voucher_no'     => $out_jurnal_code,
                    'payment_date'   => $au_entry_at,
                    'acc_pay_amount' => $total_paid_amount,
                    'vat_amount'     => $total_vat_amount,
                    'tax_amount'     => $total_tax_amount
                ]);

            // Insert into detail table
            $seq_acct_details = $this->getSequence('accdoctorpaydtl_no_pk_seq');

            DB::table('acct_cons_doctorpaydtl')->insert([
                'accdoctorpaydtl_no_pk'      => $seq_acct_details,
                'doctorpaymst_no_fk'         => $grn_no,
                'doctor_person_no_fk'        => $doctor_person_no,
                'voucher_no'                 => $out_jurnal_code,
                'paid_amount'                => $in_amount,
                'paid_amt_vat'               => $in_amount_vat,
                'paid_amt_tax'               => $in_amount_tax,
                'status'                     => 1,
                'au_entry_at'                => $au_entry_at,
                'au_entry_by'                => $in_au_entry_by,
                'au_entry_session'           => $in_au_entry_session,
                'au_entry_hospital_pk_no'    => $in_au_entry_hospital_pk_no,
            ]);

            DB::commit();

            return response()->json([
                'title' => 'Success',
                'msg' => 'Successfully Paid. Journal Code: ' . $out_jurnal_code,
                'success' => true
            ], 200);
        } else {
            DB::rollBack();
            return response()->json([
                'title' => 'Error',
                'msg' => 'Journal code not generated.',
                'success' => false
            ], 422);
        }

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Doctor payment failed: " . $e->getMessage());
        return response()->json([
            'title' => 'Failed',
            'msg' => $e->getMessage(),
            'success' => false
        ], 500);
    }
}

public function processDebitNote(Request $request)
    {
        $request->validate([
            'doctorpaymst_no_pk' => 'required|integer',
            'doctor_person_no_fk' => 'required|integer',
            'doc_amt_total' => 'required|numeric',
            'debit_note_amt' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {


            $au_entry_at        = now()->toDateString();
            $hospital_pk_no     = session()->get('user.ses_hospital_no_pk');
            $entry_session      = session()->get('user.ses_user_pk_no');
            $reference_no            = $request->doctorpaymst_no_pk;

            $moduleRow = DB::table('sysc_module')
                    ->where('module_code', 'DOC')
                    ->select('module_no_pk')
                    ->first();

            $module_no_pk = $moduleRow->module_no_pk ?? 0;

            $payment_data = DB::table('finc_cons_doctorpaymst')
                ->where('doctorpaymst_no_pk', $reference_no)
                ->where('status', 1)
                ->first();

            if ($request->doc_amt_total == 0) {
                return response()->json(['title' => 'Error', 'msg' => 'Paid Amount will be greater than Zero(0)', 'success' => false], 422);
            }

            if (!$payment_data) {
                return response()->json(['title' => 'Error', 'msg' => 'Invalid Doctor or inactive payment record.', 'success' => false], 422);
            }

            $doctor_person_no = $payment_data->doctor_person_no_fk;

            // Start Get  Sub-Ledger No

            $personcode = DB::table('hrms_personnel')
                        ->where('person_no_pk', $doctor_person_no)
                        ->value('person_code');

                    $personName = DB::table('hrms_personnel')
                        ->where('person_no_pk', $doctor_person_no)
                        ->value('full_name');

                        // dd($personcode,$personName);

            // $personcode = DB::table('hrms_personnel')
            //         ->where('person_no_pk', $doctor_person_no)
            //         ->select('person_code')
            //         ->first();

            // $personName = DB::table('hrms_personnel')
            //         ->where('person_no_pk', $doctor_person_no)
            //         ->select('full_name')
            //         ->first();

            $existing = DB::table('acct_subledger_name')
                ->where('subledger_code', $personcode)
                ->where('acct_subledger_typeno_fk', 1009)
                ->first();



            if (!$existing) {

                DB::beginTransaction();

                $nextId = $this->getSequence('acct_subledger_no_pk_seq');

                DB::table('acct_subledger_name')->insert([
                    'acct_subledger_no_pk'      => $nextId,
                    'subledger_code'            => $personcode,
                    'subledger_name'            => $personName,
                    'acct_subledger_typeno_fk'  => 1009,
                    'notes'                     => 'Visiting Doctor',
                    'status'                    => 1,
                    'au_entry_by'               => Auth::id() ?? 1,
                    'au_entry_at'               => $au_entry_at,
                    'au_entry_session'          => 'DOCTOR',
                    'au_entry_hospital_pk_no'   => $hospital_pk_no ?? 141

                ]);

                DB::commit();
            }

            $sub_ledger_no = DB::table('acct_subledger_name')
                ->where('subledger_code', $personcode)
                ->where('acct_subledger_typeno_fk', 1009)->first();

            // End Get  Sub-Ledger No

            $pre_paid_amount = DB::table('acct_cons_doctorpaydtl')
                ->where('doctorpaymst_no_fk', $reference_no)
                ->sum('paid_amount');

            $pre_paid_amount_vat = DB::table('acct_cons_doctorpaydtl')
                ->where('doctorpaymst_no_fk', $reference_no)
                ->sum('paid_amt_vat');

            $pre_paid_amount_tax = DB::table('acct_cons_doctorpaydtl')
                ->where('doctorpaymst_no_fk', $reference_no)
                ->sum('paid_amt_tax');

            $sub_ledger_id = $sub_ledger_no->acct_subledger_no_pk ?? null;

            // Prepare stored procedure inputs
            $pdo = DB::getPdo();


            $in_narration              = 'Doctor Debit Note';
            $in_integration_type       = 'DN';
            $in_module_no_fk           = $module_no_pk;
            $in_REF_NO_fk              = $reference_no;
            $in_subledger_NO_fk        = $sub_ledger_no->acct_subledger_no_pk ?? 0;
            $in_amount                 = $request->doc_amt_total ?? 0;
            $in_au_entry_by            = Auth::id();
            $in_au_entry_session       = $entry_session;
            $in_au_entry_hospital_pk_no = $hospital_pk_no;

            $out_jurnal_code = '';
            $out_error = '';

            $supplier_payment = $pdo->prepare("
                BEGIN
                    pkg_v1_accounts.prc_doc_debitnote(
                        :in_narration,
                        :in_integration_type,
                        :in_module_no_fk,
                        :in_REF_NO_fk,
                        :in_subledger_NO_fk,
                        :in_amount,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :out_jurnal_code,
                        :out_error
                    );
                END;
            ");

            $supplier_payment->bindParam(':in_narration', $in_narration);
            $supplier_payment->bindParam(':in_integration_type', $in_integration_type);
            $supplier_payment->bindParam(':in_module_no_fk', $in_module_no_fk);
            $supplier_payment->bindParam(':in_REF_NO_fk', $in_REF_NO_fk);
            $supplier_payment->bindParam(':in_subledger_NO_fk', $in_subledger_NO_fk);
            $supplier_payment->bindParam(':in_amount', $in_amount);
            $supplier_payment->bindParam(':in_au_entry_by', $in_au_entry_by);
            $supplier_payment->bindParam(':in_au_entry_session', $in_au_entry_session);
            $supplier_payment->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);

            $supplier_payment->bindParam(':out_jurnal_code', $out_jurnal_code, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 500);
            $supplier_payment->bindParam(':out_error', $out_error, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 500);

            $supplier_payment->execute();

            // dd($out_error,$out_jurnal_code);

            if ($out_error != '000') {
                DB::rollBack();
                \Log::error("Stored procedure error: " . $out_error);
                return response()->json(['title' => 'Error', 'msg' => $out_error, 'success' => false], 422);
            }

            // Proceed if journal code returned
            if (!empty($out_jurnal_code)) {
                // Calculate totals
                $total_paid_amount = $in_amount + $pre_paid_amount;
                $total_vat_amount  =  $pre_paid_amount_vat;
                $total_tax_amount  =  $pre_paid_amount_tax;

                // Update master table
                DB::table('finc_cons_doctorpaymst')
                    ->where('doctorpaymst_no_pk', $reference_no)
                    ->update([
                        'voucher_no'     => $out_jurnal_code,
                        'payment_date'   => $au_entry_at,
                        'acc_pay_amount' => $total_paid_amount,
                        'vat_amount'     => $total_vat_amount,
                        'tax_amount'     => $total_tax_amount
                    ]);

                // Insert into detail table
                $seq_acct_details = $this->getSequence('accdoctorpaydtl_no_pk_seq');

                DB::table('acct_cons_doctorpaydtl')->insert([
                    'accdoctorpaydtl_no_pk'      => $seq_acct_details,
                    'doctorpaymst_no_fk'         => $reference_no,
                    'doctor_person_no_fk'        => $doctor_person_no,
                    'voucher_no'                 => $out_jurnal_code,
                    'paid_amount'                => $in_amount,
                    'paid_amt_vat'               => 0,
                    'paid_amt_tax'               => 0,
                    'status'                     => 1,
                    'au_entry_at'                => $au_entry_at,
                    'au_entry_by'                => $in_au_entry_by,
                    'au_entry_session'           => $in_au_entry_session,
                    'au_entry_hospital_pk_no'    => $in_au_entry_hospital_pk_no,
                ]);

                DB::commit();

                return response()->json([
                    'title' => 'Success',
                    'msg' => 'Successfully Paid. Journal Code: ' . $out_jurnal_code,
                    'success' => true
                ], 200);
            } else {
                DB::rollBack();
                return response()->json([
                    'title' => 'Error',
                    'msg' => 'Journal code not generated.',
                    'success' => false
                ], 422);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Doctor payment failed: " . $e->getMessage());
            return response()->json([
                'title' => 'Failed',
                'msg' => $e->getMessage(),
                'success' => false
            ], 500);
        }


    }


}





