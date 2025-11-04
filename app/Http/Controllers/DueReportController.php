<?php

namespace App\Http\Controllers;

use App;
use PDF;
use PDO;
use Auth;
use Cache;
use Session;
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
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class DueReportController extends Controller
{
    use DatatablesLoader, InvoiceData, LookupData;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function DueInvoiceList()
    {
        $module = DB::table('finc_dueinvoicelist_vw')
        ->select('module_code', 'module_name')->distinct()->get();

        $due_data = DB::table('finc_dueinvoicelist_vw')
        ->select('invoice_no_pk', 'invoice_date', 'patient_no_fk', 'patient_name', 'module_no_fk', 'module_code', 'module_name', 'sales', 'payment', 'discount', 'due')
        // ->where('module_code', '=','OPD')
        // ->whereDate('invoice_date', '>=', now()->subMonth())
        ->whereDate('invoice_date',date('Y-m-d'))
        ->orderBy('invoice_date', 'desc')
        ->get();

        return Template::loadview("admin.reports.due_reports.due_invoice_list", ['module' => $module, 'due_data' => $due_data]);
    }
 
    public function SearchDueInvoiceList(Request $request)
    {
        $module_code = $request->module != "" ? $request->module : "";

        $from_date = '';
        $to_date = '';

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);
            $from_date = $dateTime->format('m/d/Y');
        }
 
        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);
            $to_date = $dateTime->format('m/d/Y');
        }

        $selectquery = DB::table('finc_dueinvoicelist_vw')
        ->select('invoice_no_pk', 'invoice_date', 'patient_no_fk', 'patient_name', 'module_no_fk', 'module_code', 'module_name', 'sales', 'payment', 'discount', 'due');
        $due_data = [];
 
        if ($from_date != "" && $to_date != "") {
            $selectquery->whereRaw("TO_DATE(TO_CHAR(invoice_date, 'MM/DD/YYYY'), 'MM/DD/YYYY') BETWEEN TO_DATE('$from_date', 'MM/DD/YYYY') AND TO_DATE('$to_date', 'MM/DD/YYYY')");
        } 

        if ($module_code != null) {
            $selectquery->where('module_code', '=' , $module_code);
        }

        $due_data = $selectquery->orderBy('invoice_date', 'desc')->get();

        return Template::loadview("admin.reports.due_reports.due_invoice_list_search_table", ['due_data' => $due_data]);
    }

    public function DueInvoiceReportPdfExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $module_code = $request->module != "" ? $request->module : "";

        $from_date = '';
        $to_date = '';

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);
            $from_date = $dateTime->format('m/d/Y');
        }
 
        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);
            $to_date = $dateTime->format('m/d/Y');
        }

        $selectquery = DB::table('finc_dueinvoicelist_vw')
                            ->select(
                                'invoice_no_pk',
                                 'invoice_date',
                                  'patient_no_fk', 'patient_name', 'module_no_fk', 'module_code', 'module_name', 'sales', 'payment', 'discount', 'due');
        $due_data = [];
 
        if ($from_date != "" && $to_date != "") {
            $selectquery->whereRaw("TO_DATE(TO_CHAR(invoice_date, 'MM/DD/YYYY'), 'MM/DD/YYYY') BETWEEN TO_DATE('$from_date', 'MM/DD/YYYY') AND TO_DATE('$to_date', 'MM/DD/YYYY')");
        } 

        if ($module_code != null) {
            $selectquery->where('module_code', '=' , $module_code);
        }

        $due_data = $selectquery->orderBy('invoice_date', 'desc')->get();

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
            return view("admin.reports.due_reports.due_invoice_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'due_data' => $due_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no]);
            return $pdf->stream('due_invoice_print_report.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'due_data' => $due_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no];
            $fileToExport = "due_invoice_report";
            $html = View("admin.reports.due_reports.due_invoice_report_excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }


    public function DuePatientList(Request $request){
        $module = DB::table('finc_dueinvoicelist_vw')
                      ->select('module_code', 'module_name')->distinct()->get();

        $due_patient_data = DB::table('finc_dueipdpatientlist_vw')
                                ->select('admission_no_pk', 'admission_date', 'patient_no_fk', 'patient_name', 'dis_date', 'sales', 'payment', 'discount', 'due')
                                // ->whereDate('admission_date', '>=', now()->subMonth())
                                ->orderBy('admission_date', 'asc')
                                ->orderBy('admission_no_pk', 'asc')
                                ->get();
        // dd($due_patient_data);
        return Template::loadview("admin.reports.due_reports.due_discharge_patient_list", ['module' => $module, 'due_patient_data' => $due_patient_data]);
    }

    public function SearchDuePatientList(Request $request){

        $patient_id = $request->patient_id != "" ? $request->patient_id : "";
        $from_date = '';
        $to_date = '';

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);
            $from_date = $dateTime->format('m/d/Y');
        }
 
        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);
            $to_date = $dateTime->format('m/d/Y');
        }

        $selectquery = DB::table('finc_dueipdpatientlist_vw')
                           ->select('admission_no_pk','admission_date', 'patient_no_fk', 'patient_name', 'dis_date', 'sales', 'payment', 'discount', 'due');
        $due_patient_data = [];
 
        if ($from_date != "" && $to_date != "") {
            $selectquery->whereRaw("TO_DATE(TO_CHAR(dis_date, 'MM/DD/YYYY'), 'MM/DD/YYYY') BETWEEN TO_DATE('$from_date', 'MM/DD/YYYY') AND TO_DATE('$to_date', 'MM/DD/YYYY')");
        } 

        if ($patient_id != null) {
            $selectquery->where('patient_no_fk', '=' , $patient_id);
        }

        $due_patient_data = $selectquery->orderBy('admission_date', 'asc')->orderBy('admission_no_pk', 'asc')->get();

        return Template::loadview("admin.reports.due_reports.due_discharge_patient_search_table", ['due_patient_data' => $due_patient_data]);
    }


    public function DuePatientReportPdfExcel(Request $request){
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $patient_id = $request->patient_id != "" ? $request->patient_id : "";
        $from_date = '';
        $to_date = '';

        if(!empty($request->date_from)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_from);
            $from_date = $dateTime->format('m/d/Y');
        }
 
        if(!empty($request->date_to)){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date_to);
            $to_date = $dateTime->format('m/d/Y');
        }

        $selectquery = DB::table('finc_dueipdpatientlist_vw')
                           ->select('admission_no_pk','admission_date', 'patient_no_fk', 'patient_name', 'dis_date', 'sales', 'payment', 'discount', 'due');
        $due_patient_data = [];
 
        if ($from_date != "" && $to_date != "") {
            $selectquery->whereRaw("TO_DATE(TO_CHAR(dis_date, 'MM/DD/YYYY'), 'MM/DD/YYYY') BETWEEN TO_DATE('$from_date', 'MM/DD/YYYY') AND TO_DATE('$to_date', 'MM/DD/YYYY')");
        } 

        if ($patient_id != null) {
            $selectquery->where('patient_no_fk', '=' , $patient_id);
        }

        $due_patient_data = $selectquery->orderBy('admission_date', 'asc')->orderBy('admission_no_pk', 'asc')->get();
        

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
            return view("admin.reports.due_reports.due_discharge_report_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'due_patient_data' => $due_patient_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no]);
            return $pdf->stream('due_discharge_patient_print_report.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'due_patient_data' => $due_patient_data, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no];
            $fileToExport = "due_discharge_patient_print_report";
            $html = View("admin.reports.due_reports.due_discharge_report_excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }

    }

   
}
