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

class InventoryReportController extends Controller
{
    use DatatablesLoader, InvoiceData, LookupData;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function MonthlyInventoryReport()
    {
        $department = DB::select('select distinct stock_su_no_fk,fnc_serviceunitname(stock_su_no_fk) department
        from inv_itemstocktranschd order by department asc');
        return Template::loadview("admin.uhl.inventory.inv_report.monthly_inventory_report", ['department' => $department]);
    }
    public function SearchMonthlyInventoryReport(Request $request)
    {
        $from_date = $request->from_date != ""  ? date("d-m-Y", strtotime($request->from_date)) : "";
        $to_date = $request->to_date != ""  ? date("d-m-Y", strtotime($request->to_date)) : "";
        $department = $request->department;
        $department_con = ($request->department != "") ? "  and chd.stock_su_no_fk = $department " : "";

        $item_con = "";
        if($request->input('item_name') != "") {
            $item_con .= " AND item.item_name = '". $request->input('item_name') . "' ";
        }

        $dataReport = DB::select("select distinct item_no_pk item_no_fk,item.item_name,chd.stock_su_no_fk,fnc_serviceunitname(chd.stock_su_no_fk)  department,item.supplier_pk_no,sales_price , purchase_price, fnc_uomname(item.uom_no_fk) item_uom,
         (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)< to_date('$from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk) op_qty,nvl(GRN,0) GRN ,nvl(GRNRTN,0)GRNRTN,nvl(Internal_issue,0) Internal_issue
        ,nvl(OPEN,0) OPEN ,nvl(RA,0)RA, nvl(CONSUMPTION,0) CONSUMPTION ,nvl(Internal_Receive,0)Internal_Receive,nvl(RS,0)RS,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)< to_date('$from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk)*purchase_price opening_cost,
        nvl(GRN,0)*purchase_price GRN_cost ,nvl(GRNRTN,0)*purchase_price GRNRTN_cost,nvl(Internal_issue,0)*purchase_price Internal_issue_cost
        ,nvl(OPEN,0)*purchase_price OPEN_cost ,nvl(RA,0)*purchase_price RA_cost, nvl(CONSUMPTION,0)*purchase_price  CONSUMPTION_cost ,nvl(Internal_Receive,0)*purchase_price Internal_Receive_cost,nvl(RS,0)*purchase_price RS_cost,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)<= to_date('$to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk  ) closing_qty ,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)<= to_date('$to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk  ) *purchase_price  clo_cost, 0 phy_qty, 0  variance
         from sysc_serviceitem item ,inv_itemstocktranschd chd ,   (select  item_no_fk,chd.stock_su_no_fk, sum(case when TRANS_TYPE_TEXT_CHD='GRN' then stock_trans_qty else 0 end) GRN,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='DIRECT-ISSUE-STORE' then stock_trans_qty else 0 end)) Internal_issue,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='GRNRETURN' then stock_trans_qty else 0 end)) GRNRTN,
         sum(case when TRANS_TYPE_TEXT_CHD='OPEN' then stock_trans_qty else 0 end) OPEN,
         sum(case when TRANS_TYPE_TEXT_CHD='ADJPOS' then stock_trans_qty else 0 end) RA,
           sum(case when TRANS_TYPE_TEXT_CHD='ADJNEG' then stock_trans_qty else 0 end) RS,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='CONSUMPTION' then stock_trans_qty else 0 end)) CONSUMPTION,
         sum(case when TRANS_TYPE_TEXT_CHD='Internal-Receive' then stock_trans_qty else 0 end) Internal_Receive,
         --sum(case when TRANS_TYPE_TEXT_CHD='GRN' then stock_trans_qty else 0 end) GRN,
        sum(stock_trans_qty) qty from inv_itemstocktranschd chd,inv_itemstocktransmst mst
        where trunc(chd.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        and mst.stocktrans_no_pk=chd.stocktrans_no_fk group by item_no_fk,chd.stock_su_no_fk) trans
         where item.item_no_pk=chd.item_no_fk
         and  item.item_no_pk=trans.item_no_fk (+)
         and chd.stock_su_no_fk=trans.stock_su_no_fk(+)
         and item.item_type='INV'
         $department_con $item_con
         order by 2");
        return Template::loadview("admin.uhl.inventory.inv_report.monthly_inventory_report_list", ['dataReport' => $dataReport]);
    }

    public function MonthlyInventoryReportPrint(Request $request)
    {
        $from_date = $request->from_date != ""  ? date("d-m-Y", strtotime($request->from_date)) : "";
        $to_date = $request->to_date != ""  ? date("d-m-Y", strtotime($request->to_date)) : "";
        $department = $request->department;
        $department_con = ($request->department != "") ? "  and chd.stock_su_no_fk = $department " : "";

        $dataReport = DB::select("select distinct item_no_pk item_no_fk,item.item_name,chd.stock_su_no_fk,fnc_serviceunitname(chd.stock_su_no_fk)  department,item.supplier_pk_no,sales_price , purchase_price, fnc_uomname(item.uom_no_fk) item_uom,
         (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)< to_date('$from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk) op_qty,nvl(GRN,0) GRN ,nvl(GRNRTN,0)GRNRTN,nvl(Internal_issue,0) Internal_issue
        ,nvl(OPEN,0) OPEN ,nvl(RA,0)RA, nvl(CONSUMPTION,0) CONSUMPTION ,nvl(Internal_Receive,0)Internal_Receive,nvl(RS,0)RS,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)< to_date('$from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk)*purchase_price opening_cost,
        nvl(GRN,0)*purchase_price GRN_cost ,nvl(GRNRTN,0)*purchase_price GRNRTN_cost,nvl(Internal_issue,0)*purchase_price Internal_issue_cost
        ,nvl(OPEN,0)*purchase_price OPEN_cost ,nvl(RA,0)*purchase_price RA_cost, nvl(CONSUMPTION,0)*purchase_price  CONSUMPTION_cost ,nvl(Internal_Receive,0)*purchase_price Internal_Receive_cost,nvl(RS,0)*purchase_price RS_cost,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)<= to_date('$to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk  ) closing_qty ,
        (select sum(stock_trans_qty) from inv_itemstocktranschd
        where trunc(au_entry_at)<= to_date('$to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk  ) *purchase_price  clo_cost, 0 phy_qty, 0  variance
         from sysc_serviceitem item ,inv_itemstocktranschd chd ,   (select  item_no_fk,chd.stock_su_no_fk, sum(case when TRANS_TYPE_TEXT_CHD='GRN' then stock_trans_qty else 0 end) GRN,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='DIRECT-ISSUE-STORE' then stock_trans_qty else 0 end)) Internal_issue,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='GRNRETURN' then stock_trans_qty else 0 end)) GRNRTN,
         sum(case when TRANS_TYPE_TEXT_CHD='OPEN' then stock_trans_qty else 0 end) OPEN,
         sum(case when TRANS_TYPE_TEXT_CHD='ADJPOS' then stock_trans_qty else 0 end) RA,
           sum(case when TRANS_TYPE_TEXT_CHD='ADJNEG' then stock_trans_qty else 0 end) RS,
         abs(sum(case when TRANS_TYPE_TEXT_CHD='CONSUMPTION' then stock_trans_qty else 0 end)) CONSUMPTION,
         sum(case when TRANS_TYPE_TEXT_CHD='Internal-Receive' then stock_trans_qty else 0 end) Internal_Receive,
         --sum(case when TRANS_TYPE_TEXT_CHD='GRN' then stock_trans_qty else 0 end) GRN,
        sum(stock_trans_qty) qty from inv_itemstocktranschd chd,inv_itemstocktransmst mst
        where trunc(chd.au_entry_at) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')
        and mst.stocktrans_no_pk=chd.stocktrans_no_fk group by item_no_fk,chd.stock_su_no_fk) trans
         where item.item_no_pk=chd.item_no_fk
         and  item.item_no_pk=trans.item_no_fk (+)
         and chd.stock_su_no_fk=trans.stock_su_no_fk(+)
         and item.item_type='INV'
         $department_con
         order by 2");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->hdn_report_type == 'PDF') {
            $pdf = PDF::loadView("admin.uhl.inventory.inv_report.monthly_inventory_report_print", ["po_hospital_details" => $po_hospital_details,'from_date' => $from_date, 'to_date' => $to_date, 'dataReport' => $dataReport])->setPaper('a4', 'landscape');
            return $pdf->download('monthly_inventory_report_print.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf =  ["po_hospital_details" => $po_hospital_details,'from_date' => $from_date, 'to_date' => $to_date, 'dataReport' => $dataReport];
            $fileToExport = "monthly_inventory_report";
            $html = View("admin.uhl.inventory.inv_report.monthly_inventory_report_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }
}
