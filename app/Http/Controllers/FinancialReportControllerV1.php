<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use Illuminate\Support\Facades\DB;
use PDF;
use Session;
use App\Traits\LookupData;

class FinancialReportControllerV1 extends Controller
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

        return Template::loadView("admin.reports.pharmacy.v1.itemWiseFincReport_v1", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type]);
    }



    public function itemWiseFincDetailsReport()
    {
        $serviceUnitData = [];
        
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

        return Template::loadView("admin.reports.pharmacy.v1.itemWiseFincDetailsReport", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type]);
    }


    public function financialDetailsReportData(Request $request)
    {
        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $from_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));

        $department = $request->department;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $item_name = $request->item_name;

        $query = DB::table('FINC_ITEMWISEREPORT_DTL_VW')
                    ->where(DB::raw('trunc(ledger_date)'), '>=', DB::raw("TO_DATE('$from_date', 'YYYY-MM-DD')"))
                    ->where(DB::raw('trunc(ledger_date)'), '<=', DB::raw("TO_DATE('$to_date', 'YYYY-MM-DD')"));
        
        $data = $query;
        if ($department != "") {
           $data = $query->where('serviceunit_no_fk', '=', $department);
        }
      
        if ($item_type != "") {
            $data = $query->where('item_type', '=', $item_type);
        }
       
        if ($item_id != "" && $item_name != "") {
            $data = $query->where('item_no_fk', '=', $item_id)
                         ->where('item_name', '=', $item_name);
        }

        $result = $data->orderBy('dept', 'ASC')->get();

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        return Template::loadView("admin.reports.pharmacy.v1.itemWiseFincDetailsReport_table", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'department' => $department, 'hospital_info' => $hospital_info]);
    }




    public function itemWiseFincDetailsReportPdf(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 0);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $from_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));

        $department = $request->department;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $item_name = $request->item_name;

        $query = DB::table('FINC_ITEMWISEREPORT_DTL_VW')
                    ->where(DB::raw('trunc(ledger_date)'), '>=', DB::raw("TO_DATE('$from_date', 'YYYY-MM-DD')"))
                    ->where(DB::raw('trunc(ledger_date)'), '<=', DB::raw("TO_DATE('$to_date', 'YYYY-MM-DD')"));
        
        $data = $query;
        if ($department != "") {
           $data = $query->where('serviceunit_no_fk', '=', $department);
        }
      
        if ($item_type != "") {
            $data = $query->where('item_type', '=', $item_type);
        }
       
        if ($item_id != "" && $item_name != "") {
            $data = $query->where('item_no_fk', '=', $item_id)
                         ->where('item_name', '=', $item_name);
        }

        $result = $data->orderBy('dept', 'ASC')->get();

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        if($request->input('download_type') == 'PDF') {
            $pdf = PDF::loadView("admin.reports.pharmacy.v1.item_wise_financial_details_pdf", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
            return $pdf->stream('item_wise_financial_details_pdf.pdf');
        } 
        
        if($request->input('download_type') == 'EXCEL') {
            $data = ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "item_wise_financial_details_report";
            $html = View("admin.reports.pharmacy.v1.item_wise_financial_details_excel")->with($data);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
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
                    FROM finc_itemwisereport_vw mst 
                    WHERE mst.ledger_date BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy') $whereClause
                    GROUP BY item_no_fk, item_name, dept, serviceunit_no_fk
                    ORDER BY dept, item_name";
        $result = DB::select(DB::raw($query));

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        return Template::loadView("admin.reports.pharmacy.v1.itemWiseFincReport_table_v1", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'department' => $department, 'hospital_info' => $hospital_info]);
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
            $whereClause .= " AND item.item_type = '$item_type'";
        }

        if ($item_id != "" && $item_name != "") {
            $whereClause .= " AND item_no_fk = " . $item_id;
        }

        $query = "SELECT item_no_fk, item_name, serviceunit_no_fk, dept, SUM(sales) sales, SUM(salesreturn) salesreturn, SUM(discount) discount, SUM(payment) payment, SUM(refund) refund, SUM(item_qty) item_qty
                    FROM finc_itemwisereport_vw mst 
                    WHERE mst.ledger_date BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy') $whereClause
                    GROUP BY item_no_fk, item_name, dept, serviceunit_no_fk
                    ORDER BY dept, item_name";
        $result = DB::select(DB::raw($query));

        $serviceUnitData = [];
        foreach ($result as $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->dept][] = $value;
        }

        if($request->input('download_type') == 'PDF') {
            $pdf = PDF::loadView("admin.reports.pharmacy.v1.item_wise_financial_pdf_v1", ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
            return $pdf->stream('item_wise_financial_pdf.pdf');
        } 
        
        if($request->input('download_type') == 'EXCEL') {
            $data = ['serviceUnitData' => $serviceUnitData, 'form_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "item_wise_financial_report";
            $html = View("admin.reports.pharmacy.v1.item_wise_financial_excel_v1")->with($data);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    /**
     * ***********************************************************************************
     * ***************************INVENTORY REQUISITION REPORT****************************
     * ***********************************************************************************
     */ 

    public function inventoryRequisitionReport()
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
        $items = DB::table("wsec_user")->take(80)->get();

        return Template::loadView("admin.reports.pharmacy.v1.inventory-requisition-report.index", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type, 'items' => $items]);
    }
}
