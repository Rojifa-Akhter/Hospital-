<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use Illuminate\Support\Facades\DB;
use PDF;
use Session;
use App\Traits\LookupData;

class IPDFinancialReportController extends Controller
{
    use LookupData;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function itemWiseFincReport()
    {
        $serviceUnitData = [];
        
        # Departments
        // $service_unit = DB::table('sysc_serviceunit')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $service_unit_query = "SELECT DISTINCT unit.serviceunit_name,unit.serviceunit_no_pk
                                FROM sysc_serviceitem item, sysc_serviceunit unit
                                WHERE item.serviceunit_no_fk=unit.serviceunit_no_pk
                                AND unit.au_entry_hospital_pk_no = ".Session::get('user.ses_hospital_no_pk')."
                                ORDER BY 1";
        $service_unit = DB::select(DB::Raw($service_unit_query));

        $module_code = DB::table('sysc_module')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status', 1)
            ->get();

        # Item Type
        // $item_type =DB::table('item_type_vw')->select('item_name',  'itemtype_no_pk','itemtype_code')->get();
        $item_type_query = "select distinct item_type,WORKFLOW_NAME
                                from sysc_serviceitem item, SYSC_ITEMTYPE_WORKFLOW itype
                                where item.item_type=itype.WORKFLOW_CODE
                                order by 1";

        $item_type = DB::select(DB::Raw($item_type_query));

        return Template::loadView("admin.reports.pharmacy.ipd.itemWiseFincReportIPD", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type]);
    }

    public function financialReportData(Request $request)
    {
        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $from_date = date('d/m/Y', strtotime($request->date_from));
        $to_date = date('d/m/Y', strtotime($request->date_to));

        $department = $request->department;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $item_name = $request->item_name;

        $whereClause = "";
        if ($department != "") {
            $whereClause .= " AND serviceunit_no_fk = " . $department;
        }

        if ($item_type != "") {
            $whereClause .= " AND item_type = '$item_type'";
        }

        if ($item_id != "" && $item_name != "") {
            $whereClause .= " AND item_no_fk = " . $item_id;
        }

        $query = "SELECT item_no_fk, item_name, serviceunit_no_fk, dept, SUM(sales) sales, SUM(salesreturn) salesreturn, SUM(discount) discount, SUM(payment) payment, SUM(refund) refund, SUM(item_qty) item_qty
                    FROM FINC_IPDITEMWISEREPORT_VW mst 
                    WHERE mst.ledger_date BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy') $whereClause 
                    GROUP BY item_no_fk, item_name, dept, serviceunit_no_fk
                    ORDER BY dept, item_name";
        $result = DB::select(DB::raw($query));

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        return Template::loadView("admin.reports.pharmacy.ipd.itemWiseFincReport_table_ipd", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'department' => $department, 'hospital_info' => $hospital_info]);
    }

    public function itemWiseFincReportPdf(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 0);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $from_date = date('d/m/Y', strtotime($request->date_from));
        $to_date = date('d/m/Y', strtotime($request->date_to));

        $department = $request->department;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $item_name = $request->item_name;

        $whereClause = "";
        if ($department != "") {
            $whereClause .= " AND serviceunit_no_fk = " . $department;
        }

        if ($item_type != "") {
            $whereClause .= " AND item_type = '$item_type'";
        }

        if ($item_id != "" && $item_name != "") {
            $whereClause .= " AND item_no_fk = " . $item_id;
        }

        $query = "SELECT item_no_fk, item_name, serviceunit_no_fk, dept, SUM(sales) sales, SUM(salesreturn) salesreturn, SUM(discount) discount, SUM(payment) payment, SUM(refund) refund, SUM(item_qty) item_qty
                    FROM FINC_IPDITEMWISEREPORT_VW mst 
                    WHERE mst.ledger_date BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy') $whereClause 
                    GROUP BY item_no_fk, item_name, dept, serviceunit_no_fk
                    ORDER BY dept, item_name";
        $result = DB::select(DB::raw($query));

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        if($request->input('download_type') == 'PDF') {
            $pdf = PDF::loadView("admin.reports.pharmacy.ipd.item_wise_financial_pdf_ipd", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
            return $pdf->stream('ipd_item_wise_financial_pdf.pdf');
        } 
        
        if($request->input('download_type') == 'EXCEL') {
            $data = ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "ipd_item_wise_financial_report";
            $html = View("admin.reports.pharmacy.ipd.item_wise_financial_excel_ipd")->with($data);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
}
