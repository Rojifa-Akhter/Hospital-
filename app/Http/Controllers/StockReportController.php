<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Session;
use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Models\UomLookup as Lookup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class StockReportController extends Controller
{

    public function pharmacyStockReport()
    {

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-stock-report", [
            "stores" => $stores
        ]);
    }



    /*
    | Invoice Wise Stock Report. Developed By MAI
    */
    public function searchPharmacyStockReport(Request $request)
    {
        ini_set('max_execution_time', -1);
        //ini_set('memory_limit', '64M');

        $date_from = "$request->search_date_from";
        if (!empty($request->from_date)) {

            $date_from = "$request->from_date";
            $date_to = "$request->to_date";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();
        $item_list            = DB::select("select * from phr_v1_medicine_profitloss_vw  $sql_cond order by invoice_datetime asc");
        // dd( $date_from,  $item_list  );

        $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-transaction-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-transaction-wise-pdf.pdf');
    }


    /*
    | Invoice Item Wise Profit Report. Developed By MAI
    */
    public function pharmacyProfitReportTransactionWise()
    {
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-transaction-wise");
    }


    /*
    | Invoice Item Wise Profit Report. Developed By MAI
    */
    public function searchPharmacyProfitReportTransactionWise(Request $request)
    {

        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') AND TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();
        $item_list            = DB::select("select * from phr_v1_medicine_profitloss_vw  $sql_cond order by invoice_datetime asc");
        // dd( $date_from,  $item_list  );

        $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-transaction-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-transaction-wise-pdf.pdf');
    }


    public function searchPharmacyProfitReportItemWise(Request $request)
    {
        ini_set('max_execution_time', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }



        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();
        //$item_list            = DB::select("select * from phr_v1_medicine_profitloss_vw  $sql_cond order by invoice_datetime asc");
        $item_list            = DB::select("select item_no_fk,item_name,item_rate,nvl(cost_price,0) cost_price,sum(item_qty) item_qty,sum(nvl(cancel_qty,0)) cancel_qty,sum(sales_amt) sales_amt,sum(cost_amt) cost_amt,sum(item_profit) item_profit
                                            from PHR_V1_MEDICINE_PROFITLOSS_VW
                                            $sql_cond
                                            group by item_no_fk,item_name,item_rate,cost_price");


        $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-transaction-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-transaction-wise-pdf.pdf');
    }



    /*
    | Invoice Wise Profit Report. Developed By MAI
    */
    public function pharmacyProfitReportMonthWiseItem()
    {
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-month-wise-item");
    }


    /*
    | Invoice Wise Profit Report. Developed By MAI
    */
    public function searchPharmacyProfitReportMonthWiseItem(Request $request)
    {
        //ini_set('memory_limit', '64M');
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();
        $item_list            = DB::select("select item_name, item_rate,cost_price,
        sum(item_qty) as item_qty,
        sum(cancel_qty) as cancel_qty,
        sum(sales_amt) as sales_amt,
        sum(cost_amt) as cost_amt,
        sum(item_profit) as item_profit,
        sum(ladger_sales) as ladger_sales,
        sum(ladger_discount) as ladger_discount,
        sum(sum_invoice_cost) as sum_invoice_cost


        from phr_v1_medicine_profitloss_vw  $sql_cond group by item_name, item_rate,cost_price order by item_name asc");


        $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-month-wise-item-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-month-wise-item-pdf.pdf');
    }


    /*
    | Invoice Wise Profit summery Report. Developed By MAI
    */
    public function pharmacyProfitSummeryReport()
    {
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-profit-summery-report");
    }


    /*
    | Invoice Wise Profit Report. Developed By MAI
    */
    public function pharmacyProfitReportInvoiceWise()
    {
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise");
    }
    public function storeWiseOpeningClosingReport()
    {
        return Template::loadView("admin.uhl.pharmacy_report.store_wise_opening_closing_repot");
    }


    public function storeWiseOpeningClosingReportPrint(Request $request)
    {
        ini_set('memory_limit', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();



        $stock_price = DB::select("select SERVICEUNIT_NAME, round(sum (op_blance),2) op_blance,round(sum(clos_blance),2) clos_blance from (select chd.stock_su_no_fk,SERVICEUNIT_NAME,
            chd.item_no_fk , purchase_price, purchase_price*
              (select sum (stock_trans_qty)
                 from inv_itemstocktranschd
                where trunc (au_entry_at) <
                         to_date ('$date_from', 'dd/mm/yyyy')
                      and stock_su_no_fk = chd.stock_su_no_fk
                      and item_no_fk = item.item_no_pk )
                 op_blance,
               purchase_price* (select  sum (stock_trans_qty)
                 from inv_itemstocktranschd
                where trunc (au_entry_at) <=
                         to_date ('$date_to', 'dd/mm/yyyy')
                      and stock_su_no_fk = chd.stock_su_no_fk
                      and item_no_fk = item.item_no_pk )
                 clos_blance
         from sysc_serviceitem item,
              inv_itemstocktranschd chd,
          SYSC_SERVICEUNIT unit
        where     item.item_no_pk = chd.item_no_fk
             and chd.stock_su_no_fk = unit.SERVICEUNIT_NO_PK
             and MAIN_STORE_IND = 1
            group by chd.stock_su_no_fk,item.item_no_pk ,purchase_price, chd.item_no_fk,SERVICEUNIT_NAME ) group by SERVICEUNIT_NAME ");


        $pdf = PDF::loadView("admin.uhl.pharmacy_report.store_wise_opening_closing_balance_print", ['from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'stock_price' => $stock_price]);
        return $pdf->stream('store-wise-opening-closing-balance-print.pdf');
    }

    /*
    | Invoice Wise Profit Report. Developed By MAI
    */
    public function searchPharmacyProfitReportInvoiceWise(Request $request)
    {
        ini_set('memory_limit', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {

            $item_list = DB::select("select invoice_no_fk, invoice_datetime,item_count ,sum_sales_amt_gross sales_amt_gross, sum_sales_amt,sum_cancel_amt,ladger_sales,ladger_discount,sum_invoice_cost,zakat,ladger_payment
                                                    from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_no_fk, invoice_datetime,item_count ,sum_sales_amt_gross, sum_sales_amt ,sum_cancel_amt, ladger_sales,
                                                    ladger_discount,sum_invoice_cost,zakat,ladger_payment order by invoice_datetime asc");

            return view("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')

        } else {

            if ($request->shop_type == 'PHR') {
                $module_code = 'AND (module_no_fk = 3 OR module_no_fk = 22 OR module_no_fk = 23 OR module_no_fk = 16 OR module_no_fk = 321)';
            } elseif ($request->shop_type == 'OPT') {
                $module_code = 'AND (module_no_fk = 27 OR module_no_fk = 28)';
            } elseif ($request->shop_type == 'COFFE') {
                $module_code = 'AND (module_no_fk = 53 OR module_no_fk = 54 OR module_no_fk = 25 OR module_no_fk = 26)';
            }

            $item_list = DB::select("select invoice_no_fk, invoice_datetime,item_count ,sum(sales_amt_gross) as sales_amt_gross, sum_sales_amt, sum_cancel_amt,ladger_discount,sum_invoice_cost,zakat,ladger_payment
                                        from phr_v1_medicine_profitloss_vw  $sql_cond $module_code
                                        group by invoice_no_fk, invoice_datetime,item_count , sum_sales_amt, sum_cancel_amt,ladger_discount,sum_invoice_cost,zakat,ladger_payment order by invoice_datetime asc");


            $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'report_type' => $request->shop_type]);  //->setPaper('a4', 'landscape')
            return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
        }
    }
    public function searchPharmacyProfitReportDateWise(Request $request)
    {
        ini_set('memory_limit', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();

        if (session()->get('user.ses_hospital_code') == "IMPERIAL") {

            $item_list = DB::select("select invoice_datetime, sum(sales_amt_gross) sales_amt_gross, sum(sum_sales_amt) sum_sales_amt, sum(sum_cancel_amt)  sum_cancel_amt,sum(ladger_sales)  ladger_sales,sum(ladger_discount)  ladger_discount,round(sum(sum_invoice_cost),2) sum_invoice_cost,
            sum(zakat) zakat,sum(ladger_payment) ladger_payment
            from (select trunc(invoice_datetime) as invoice_datetime ,invoice_no_fk,sum_sales_amt_gross as sales_amt_gross, sum_sales_amt as sum_sales_amt,sum_cancel_amt as sum_cancel_amt,
            ladger_sales as ladger_sales,ladger_discount as ladger_discount,sum_invoice_cost as sum_invoice_cost,zakat as zakat,ladger_payment as ladger_payment
            from phr_v1_medicine_profitloss_vw $sql_cond
            group by trunc(invoice_datetime),sum_sales_amt_gross , sum_sales_amt ,sum_cancel_amt ,invoice_no_fk,
            ladger_sales ,ladger_discount ,sum_invoice_cost ,zakat ,ladger_payment)
            group by invoice_datetime  order by invoice_datetime asc");



            return view("admin.uhl.pharmacy_report.pharmacy-profit-report-date-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
        } else {

            if ($request->shop_type == 'PHR') {
                $module_code = 'AND (module_no_fk = 3 OR module_no_fk = 22 OR module_no_fk = 23 OR module_no_fk = 16 OR module_no_fk = 321)';
            } elseif ($request->shop_type == 'OPT') {
                $module_code = 'AND (module_no_fk = 27 OR module_no_fk = 28)';
            } elseif ($request->shop_type == 'COFFE') {
                $module_code = 'AND (module_no_fk = 53 OR module_no_fk = 54 OR module_no_fk = 25 OR module_no_fk = 26)';
            }

            $stock_price = DB::select("select SERVICEUNIT_NAME, round(sum (op_blance),2) op_blance,round(sum(clos_blance),2) clos_blance from (select chd.stock_su_no_fk,SERVICEUNIT_NAME,
                            chd.item_no_fk , purchase_price, purchase_price*
                            (select sum (stock_trans_qty)
                                from inv_itemstocktranschd
                                where trunc (au_entry_at) <
                                        to_date ('$date_from', 'dd/mm/yyyy')
                                    and stock_su_no_fk = chd.stock_su_no_fk
                                    and item_no_fk = item.item_no_pk )
                                op_blance,
                            purchase_price* (select  sum (stock_trans_qty)
                                from inv_itemstocktranschd
                                where trunc (au_entry_at) <=
                                        to_date ('$date_to', 'dd/mm/yyyy')
                                    and stock_su_no_fk = chd.stock_su_no_fk
                                    and item_no_fk = item.item_no_pk )
                                clos_blance
                        from sysc_serviceitem item,
                            inv_itemstocktranschd chd,
                        SYSC_SERVICEUNIT unit
                        where     item.item_no_pk = chd.item_no_fk
                            and chd.stock_su_no_fk = unit.SERVICEUNIT_NO_PK
                            and MAIN_STORE_IND = 1
                            group by chd.stock_su_no_fk,item.item_no_pk ,purchase_price, chd.item_no_fk,SERVICEUNIT_NAME ) group by SERVICEUNIT_NAME ");

            // $item_list = DB::select("select invoice_datetime, sum(sales_amt_gross) sales_amt_gross, sum(sum_sales_amt) sum_sales_amt, sum(sum_cancel_amt)  sum_cancel_amt,sum(ladger_sales)  ladger_sales,sum(case when zakat =1 then 0 else ladger_discount end )  ladger_discount,round(sum(sum_invoice_cost),2) sum_invoice_cost,
            // 0 zakat,sum(ladger_payment) ladger_payment
            // from (select trunc(invoice_datetime) as invoice_datetime ,invoice_no_fk ,sum_sales_amt_gross as sales_amt_gross, sum_sales_amt as sum_sales_amt,sum_cancel_amt as sum_cancel_amt,
            // ladger_sales as ladger_sales,ladger_discount as ladger_discount,sum_invoice_cost as sum_invoice_cost,zakat as zakat,ladger_payment as ladger_payment
            // from phr_v1_medicine_profitloss_vw $sql_cond and module_no_fk = 3
            // group by trunc(invoice_datetime),sum_sales_amt_gross , sum_sales_amt ,sum_cancel_amt ,invoice_no_fk,
            // ladger_sales ,ladger_discount ,sum_invoice_cost ,zakat ,ladger_payment)
            // group by invoice_datetime  order by invoice_datetime asc");
            $item_list = DB::select("
                SELECT invoice_datetime,
                    SUM(sales_amt_gross) AS sales_amt_gross,
                    SUM(sum_sales_amt) AS sum_sales_amt,
                    SUM(sum_cancel_amt) AS sum_cancel_amt,
                    SUM(ladger_sales) AS ladger_sales,
                    SUM(CASE WHEN zakat = 1 THEN 0 ELSE ladger_discount END) AS ladger_discount,
                    ROUND(SUM(sum_invoice_cost), 2) AS sum_invoice_cost,
                    0 AS zakat,
                    SUM(ladger_payment) AS ladger_payment
                FROM (
                    SELECT TRUNC(invoice_datetime) AS invoice_datetime,
                        invoice_no_fk,
                        sum_sales_amt_gross AS sales_amt_gross,
                        sum_sales_amt AS sum_sales_amt,
                        sum_cancel_amt AS sum_cancel_amt,
                        ladger_sales AS ladger_sales,
                        ladger_discount AS ladger_discount,
                        sum_invoice_cost AS sum_invoice_cost,
                        zakat AS zakat,
                        ladger_payment AS ladger_payment
                    FROM phr_v1_medicine_profitloss_vw
                    $sql_cond
                    $module_code
                    GROUP BY TRUNC(invoice_datetime), sum_sales_amt_gross, sum_sales_amt, sum_cancel_amt,
                            invoice_no_fk, ladger_sales, ladger_discount, sum_invoice_cost, zakat, ladger_payment
                )
                GROUP BY invoice_datetime
                ORDER BY invoice_datetime ASC
            ");


            $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-date-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'stock_price' => $stock_price, 'report_type' => $request->shop_type]);  //->setPaper('a4', 'landscape')
            return $pdf->stream('pharmacy-profit-report-date-wise-pdf.pdf');
        }
    }



    /*
    | Invoice Wise Profit Report. Developed By MAI
    */
    public function searchPharmacyProfitSummeryReport(Request $request)
    {
        ini_set('memory_limit', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {

            // dd("select invoice_datetime ,sum(ladger_sales) ladger_sales,sum(ladger_discount) ladger_discount,sum(sum_invoice_cost) sum_invoice_cost,sum(zakat) zakat,sum(ladger_payment) ladger_payment
            // from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_datetime order by invoice_datetime asc");

            $item_list = DB::select("select distinct trunc(invoice_datetime) invoice_datetime, sum(ladger_sales) ladger_sales,sum(ladger_discount) ladger_discount,sum(sum_invoice_cost) sum_invoice_cost,sum(zakat) zakat,sum(ladger_payment) ladger_payment
                                                    from phr_v2_medicine_profitloss_vw  $sql_cond group by trunc(invoice_datetime) order by invoice_datetime asc");

            return view("admin.uhl.pharmacy_report.pharmacy-profit-report-summery", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')

        } else {

            $item_list = DB::select("select invoice_datetime,item_count ,ladger_sales,ladger_discount,sum_invoice_cost,zakat,ladger_payment
                                        from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_datetime,item_count ,ladger_sales,ladger_discount,sum_invoice_cost,zakat,ladger_payment order by invoice_datetime asc");

            $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
            return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
        }

        // // dd("select invoice_datetime,sum(item_count) item_count ,sum(ladger_sales) ladger_sales,sum(ladger_discount) ladger_discount,sum(sum_invoice_cost) sum_invoice_cost,sum(zakat) zakat,sum(ladger_payment) ladger_payment
        // // from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_datetime order by invoice_datetime asc");

        // $item_list            = DB::select("select invoice_datetime,sum(item_count) item_count ,sum(ladger_sales) ladger_sales,sum(ladger_discount) ladger_discount,sum(sum_invoice_cost) sum_invoice_cost,sum(zakat) zakat,sum(ladger_payment) ladger_payment
        // from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_datetime order by invoice_datetime asc");


        //return view("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        //$pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        //return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
    }




    public function excelPharmacyProfitReportInvoiceWise(Request $request)
    {

        ini_set('memory_limit', -1);
        $date_from = "$request->search_date_from";
        $date_to   = "$request->search_date_to";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from";
            $date_to   = "$request->search_date_to";
        } else {
            $date_from = "";
            $date_to   = "";
        }

        $sql_cond             = "";
        $clause               = ($sql_cond == "") ? " where" : " and";
        $sql_cond            .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD-MM-YYYY') and TO_DATE('$date_to','DD-MM-YYYY')" : "";
        $po_hospital_details  = DB::table("WSEC_HOSPITAL")->first();
        $item_list            = DB::select("select invoice_no_fk, invoice_datetime,item_count ,ladger_sales,ladger_discount,sum_invoice_cost,zakat,ladger_payment,sum_cancel_amt,sum_sales_amt
        from phr_v1_medicine_profitloss_vw  $sql_cond group by invoice_no_fk, invoice_datetime,item_count  , ladger_sales,
        ladger_discount,sum_invoice_cost,zakat,ladger_payment,sum_cancel_amt,sum_sales_amt order by invoice_datetime asc");

        $fileToExport = "Pharmacy_Profit_Loss_Report_Invoice_Wise";
        $html = view('admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-excel', ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;

        $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-profit-report-invoice-wise-pdf", ['item_list' => $item_list, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
    }


    public function store_stock_report()
    {
        return Template::loadView("admin.uhl.pharmacy_report.store_stock_report");
    }

    public function store_stock_report_print(Request $request)
    {
        ini_set('max_execution_time', -1);



        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $total_cache_record = 0;
        $total_record = 0;

        $current_stock_rec = 0;

        if (Cache::has('qty_cacheable_' . $from_date . "_" . $to_date)) {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            $current_stock_rec = intval($check_cacheable[0]->total_record);
        } else {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);
        }





        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        if (Cache::has('stock_' . $from_date . "_" . $to_date) && (intval(Cache::get('qty_cacheable_' . $from_date . "_" . $to_date)) == $current_stock_rec)) {

            return view("admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf", ['stock_item' => Cache::get('stock_' . $from_date . "_" . $to_date), 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        } else {

            Cache::forget('stock_' . $from_date . "_" . $to_date);

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);

            $stock = DB::select("
                select stock.item_name ,opening_blance.op_bal, sum(openqty) openqty,avg(opencost) opencost,sum(grnqty) grnqty,avg(grncost) grncost,sum(internalissueqty) internalissueqty ,avg(internalissuecost) internalissuecost,
                sum(internalreceiveqty) internalreceiveqty,avg(internalreceivecost) internalreceivecost,sum(salesqty) salesqty, avg(salescost) salescost,sum(salesreturnqty) salesreturnqty,avg(salesreturncost) salesreturncost,
                sum(rcvrtnqty) rcvrtnqty,avg(rcvrtncost) rcvrtncost,sum(damageqty) damageqty,avg(damagecost) damagecost,
                sum(expiredqty) expiredqty,avg(expiredcost) expiredcost,sum(transinqty) transinqty,avg(transincost) transincost,sum(transouqty) transouqty,avg(transoutcost) transoutcost,closing_blance.cl_bal
                from phr_stock_openclose_vw stock ,(select op_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$from_date','yyyy-mm-dd') and stock_su_no_fk=20001) opening_blance,
                (select cl_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$to_date','yyyy-mm-dd') and stock_su_no_fk=20001) closing_blance
                where tran_date between '$from_date' and '$to_date'
                and stock.item_name=opening_blance.item_name
                and stock.item_name=closing_blance.item_name
                and stock_su_no_fk=20001
                group by stock.item_name,opening_blance.op_bal,closing_blance.cl_bal
            ");

            Cache::forever('stock_' . $from_date . "_" . $to_date, $stock);
        }


        //$pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf", ['stock_item' => $stock, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return view("admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf", ['stock_item' => $stock, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
    }


    public function store_stock_report_excel(Request $request)
    {
        ini_set('max_execution_time', -1);



        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $total_cache_record = 0;
        $total_record = 0;

        $current_stock_rec = 0;

        if (Cache::has('qty_cacheable_' . $from_date . "_" . $to_date)) {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            $current_stock_rec = intval($check_cacheable[0]->total_record);
        } else {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);
        }





        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        if (Cache::has('stock_' . $from_date . "_" . $to_date) && (intval(Cache::get('qty_cacheable_' . $from_date . "_" . $to_date)) == $current_stock_rec)) {


            $fileToExport = "Store Stock Report";
            $html = view('admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf', ['stock_item' => Cache::get('stock_' . $from_date . "_" . $to_date), 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);

            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        } else {

            Cache::forget('stock_' . $from_date . "_" . $to_date);

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);

            $stock = DB::select("
                select stock.item_name ,opening_blance.op_bal, sum(openqty) openqty,avg(opencost) opencost,sum(grnqty) grnqty,avg(grncost) grncost,sum(internalissueqty) internalissueqty ,avg(internalissuecost) internalissuecost,
                sum(internalreceiveqty) internalreceiveqty,avg(internalreceivecost) internalreceivecost,sum(salesqty) salesqty, avg(salescost) salescost,sum(salesreturnqty) salesreturnqty,avg(salesreturncost) salesreturncost,
                sum(rcvrtnqty) rcvrtnqty,avg(rcvrtncost) rcvrtncost,sum(damageqty) damageqty,avg(damagecost) damagecost,
                sum(expiredqty) expiredqty,avg(expiredcost) expiredcost,sum(transinqty) transinqty,avg(transincost) transincost,sum(transouqty) transouqty,avg(transoutcost) transoutcost,closing_blance.cl_bal
                from phr_stock_openclose_vw stock ,(select op_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$from_date','yyyy-mm-dd') and stock_su_no_fk=20001) opening_blance,
                (select cl_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$to_date','yyyy-mm-dd') and stock_su_no_fk=20001) closing_blance
                where tran_date between '$from_date' and '$to_date'
                and stock.item_name=opening_blance.item_name
                and stock.item_name=closing_blance.item_name
                and stock_su_no_fk=20001
                group by stock.item_name,opening_blance.op_bal,closing_blance.cl_bal
            ");

            Cache::forever('stock_' . $from_date . "_" . $to_date, $stock);
        }


        $fileToExport = "Store Stock Report";
        $html = view('admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf', ['stock_item' => $stock, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);

        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }


    public function store_stock_detail_report()
    {
        return Template::loadView("admin.uhl.pharmacy_report.store_stock_detail_report");
    }

    public function store_stock_report_detail_print(Request $request)
    {
        ini_set('max_execution_time', -1);



        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $total_cache_record = 0;
        $total_record = 0;

        $current_stock_rec = 0;

        if (Cache::has('qty_cacheable_' . $from_date . "_" . $to_date)) {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            $current_stock_rec = intval($check_cacheable[0]->total_record);
        } else {

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);
        }





        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        if (Cache::has('stock_' . $from_date . "_" . $to_date) && (intval(Cache::get('qty_cacheable_' . $from_date . "_" . $to_date)) == $current_stock_rec)) {

            return view("admin.uhl.pharmacy_report.pharmacy-store-stock-detial", ['stock_item' => Cache::get('stock_' . $from_date . "_" . $to_date), 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);
        } else {

            Cache::forget('stock_' . $from_date . "_" . $to_date);

            $check_cacheable = DB::select("select count(*) total_record
                from phr_stockledger_details_vw
                where tran_date between '$from_date' and '$to_date'
                and stock_su_no_fk=20001");

            Cache::forever('qty_cacheable_' . $from_date . "_" . $to_date, $check_cacheable[0]->total_record);

            $stock = DB::select("
                select stock.item_name ,opening_blance.op_bal, sum(openqty) openqty,avg(opencost) opencost,sum(grnqty) grnqty,avg(grncost) grncost,sum(internalissueqty) internalissueqty ,avg(internalissuecost) internalissuecost,
                sum(internalreceiveqty) internalreceiveqty,avg(internalreceivecost) internalreceivecost,sum(salesqty) salesqty, avg(salescost) salescost,sum(salesreturnqty) salesreturnqty,avg(salesreturncost) salesreturncost,
                sum(rcvrtnqty) rcvrtnqty,avg(rcvrtncost) rcvrtncost,sum(damageqty) damageqty,avg(damagecost) damagecost,
                sum(expiredqty) expiredqty,avg(expiredcost) expiredcost,sum(transinqty) transinqty,avg(transincost) transincost,sum(transouqty) transouqty,avg(transoutcost) transoutcost,closing_blance.cl_bal
                from phr_stock_openclose_vw stock ,(select op_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$from_date','yyyy-mm-dd') and stock_su_no_fk=20001) opening_blance,
                (select cl_bal,item_name from phr_stock_openclose_vw where tran_date = to_date('$to_date','yyyy-mm-dd') and stock_su_no_fk=20001) closing_blance
                where tran_date between '$from_date' and '$to_date'
                and stock.item_name=opening_blance.item_name
                and stock.item_name=closing_blance.item_name
                and stock_su_no_fk=20001
                group by stock.item_name,opening_blance.op_bal,closing_blance.cl_bal
            ");

            Cache::forever('stock_' . $from_date . "_" . $to_date, $stock);
        }


        //$pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-store-stock-report-pdf", ['stock_item' => $stock, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return view("admin.uhl.pharmacy_report.pharmacy-store-stock-detial", ['stock_item' => $stock, 'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details]);  //->setPaper('a4', 'landscape')
        return $pdf->stream('pharmacy-profit-report-invoice-wise-pdf.pdf');
    }




    public function test()
    {
        //
        $approved_pr = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option
                                    from inv_requisitionmst_po pr
                                    left join sysc_approvalprocess_vw apr
                                    on apr.primary_key_value = pr.inv_requisition_po_no_pk
                                    where apr.approved_ind = 1");

        $uom_data = Lookup::where('uom_code', '!=', 'PC')->orderBy('uom_no_pk', 'asc')->get();

        $suppliers = DB::table('inv_supplier')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $requisitions = DB::table("inv_requisitionmst")->orderBy('inv_requisition_no_pk')->get();

        return Template::loadView('admin.pcrm.test.test', [
            'suppliers' => $suppliers,
            'approved_pr' => $approved_pr,
            'uom_data' => $uom_data,
            'requisitions' => $requisitions
        ]);
    }


    public function pharmacyStockReportV1(Request $request)
    {
        $suppliers_name = DB::table("inv_supplier")
            ->select("supplier_name", "supplier_no_pk")
            ->where('status', 1)
            ->where('pharmacy_ind', 1)
            ->orderBy('supplier_name', 'asc')
            ->get();

        $department = ServiceUnit::where('status', '1')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->where('pharmacy_ind', 1)
            ->orwhere('main_store_ind', 1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-stock-report-v1", ['suppliers_name' => $suppliers_name, 'department' => $department]);
    }

    public function pharmacyStockReportSearchV1(Request $request)
    {
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {
            $conditon .= " and item_type='MED'";
        }

        $data = DB::select("select distinct item_no_pk item_no_fk,item.item_name,gen.generic_name,chd.stock_su_no_fk,fnc_serviceunitname(chd.stock_su_no_fk) department,item.supplier_pk_no, supp.supplier_name,sales_price, purchase_price, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)< to_date('$request->from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk
            and item_no_fk=item.item_no_pk) op_qty,nvl(stock_in,0) stock_in ,nvl(stock_out,0)stock_out, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)<= to_date('$request->to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk) clos_qty from sysc_serviceitem item ,inv_itemstocktranschd chd, (select item_no_fk,chd.stock_su_no_fk,sum(case when stock_trans_qty >0 then stock_trans_qty else 0 end) stock_in, abs(sum (case when stock_trans_qty < 0 then stock_trans_qty else 0 end)) stock_out, sum(stock_trans_qty) qty from inv_itemstocktranschd chd,inv_itemstocktransmst mst where trunc(chd.au_entry_at) between to_date('$request->from_date','dd/mm/yyyy') and to_date('$request->to_date','dd/mm/yyyy') and mst.stocktrans_no_pk=chd.stocktrans_no_fk group by item_no_fk,chd.stock_su_no_fk) trans ,inv_supplier supp,sysc_generic gen where item.item_no_pk=chd.item_no_fk and  item.item_no_pk=trans.item_no_fk (+) and chd.stock_su_no_fk=trans.stock_su_no_fk(+) and item.supplier_pk_no=supp.supplier_no_pk(+) and item.generic_no_fk=gen.generic_no_pk(+) $conditon order by chd.stock_su_no_fk, item.item_name");

        // dd($data);
        return Template::loadView("admin.uhl.pharmacy_report.pharmacy-stock-report-search-table-v1", ['data' => $data]);
    }

    public function pharmacyStockReportPrintV1(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        $datas = DB::select("select distinct item_no_pk item_no_fk,item.item_name,gen.generic_name,chd.stock_su_no_fk,fnc_serviceunitname(chd.stock_su_no_fk) department,item.supplier_pk_no, supp.supplier_name,sales_price, purchase_price, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)< to_date('$request->from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk
        and item_no_fk=item.item_no_pk) op_qty,nvl(stock_in,0) stock_in ,nvl(stock_out,0)stock_out, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)<= to_date('$request->to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk) clos_qty from sysc_serviceitem item ,inv_itemstocktranschd chd, (select item_no_fk,chd.stock_su_no_fk,sum(case when stock_trans_qty >0 then stock_trans_qty else 0 end) stock_in, abs(sum (case when stock_trans_qty < 0 then stock_trans_qty else 0 end)) stock_out, sum(stock_trans_qty) qty from inv_itemstocktranschd chd,inv_itemstocktransmst mst where trunc(chd.au_entry_at) between to_date('$request->from_date','dd/mm/yyyy') and to_date('$request->to_date','dd/mm/yyyy') and mst.stocktrans_no_pk=chd.stocktrans_no_fk group by item_no_fk,chd.stock_su_no_fk) trans ,inv_supplier supp,sysc_generic gen where item.item_no_pk=chd.item_no_fk and  item.item_no_pk=trans.item_no_fk (+) and chd.stock_su_no_fk=trans.stock_su_no_fk(+) and item.supplier_pk_no=supp.supplier_no_pk(+) and item.generic_no_fk=gen.generic_no_pk(+) $conditon order by chd.stock_su_no_fk, item.item_name");

        // dd($datas);
        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                $data[$value->department][$value->supplier_name][] = $value;
            }
        }


        return view("admin.uhl.pharmacy_report.pharmacy-stock-report-print-v1", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        // $pdf = PDF::loadView("admin.uhl.pharmacy_report.pharmacy-stock-report-print-v1", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data, 'from_date' => $request->from_date, 'to_date' => $request->to_date])->setPaper('a4', 'potrait');
        // return $pdf->stream('pharmacy_stock_print_report.pdf');

    }

    public function pharmacyStockReportexcelV1(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        $datas = DB::select("select distinct item_no_pk item_no_fk,item.item_name,gen.generic_name,chd.stock_su_no_fk,fnc_serviceunitname(chd.stock_su_no_fk) department,item.supplier_pk_no, supp.supplier_name,sales_price, purchase_price, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)< to_date('$request->from_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk
        and item_no_fk=item.item_no_pk) op_qty,nvl(stock_in,0) stock_in ,nvl(stock_out,0)stock_out, (select sum(stock_trans_qty) from inv_itemstocktranschd where trunc(au_entry_at)<= to_date('$request->to_date','dd/mm/yyyy') and stock_su_no_fk=chd.stock_su_no_fk and item_no_fk=item.item_no_pk) clos_qty from sysc_serviceitem item ,inv_itemstocktranschd chd, (select item_no_fk,chd.stock_su_no_fk,sum(case when stock_trans_qty >0 then stock_trans_qty else 0 end) stock_in, abs(sum (case when stock_trans_qty < 0 then stock_trans_qty else 0 end)) stock_out, sum(stock_trans_qty) qty from inv_itemstocktranschd chd,inv_itemstocktransmst mst where trunc(chd.au_entry_at) between to_date('$request->from_date','dd/mm/yyyy') and to_date('$request->to_date','dd/mm/yyyy') and mst.stocktrans_no_pk=chd.stocktrans_no_fk group by item_no_fk,chd.stock_su_no_fk) trans ,inv_supplier supp,sysc_generic gen where item.item_no_pk=chd.item_no_fk and  item.item_no_pk=trans.item_no_fk (+) and chd.stock_su_no_fk=trans.stock_su_no_fk(+) and item.supplier_pk_no=supp.supplier_no_pk(+) and item.generic_no_fk=gen.generic_no_pk(+) $conditon order by chd.stock_su_no_fk, item.item_name");

        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                $data[$value->supplier_name . '*' . $value->department][] = $value;
            }
        }
        // dd($data);

        $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $data, 'from_date' => $request->from_date, 'to_date' => $request->to_date];
        $fileToExport = "pharmacy_stock_print_report";
        $html = View("admin.uhl.pharmacy_report.pharmacy-stock-report-excel-v1")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }


    public function stockAsOnReportV1(Request $request)
    {
        $suppliers_name = DB::table("inv_supplier")
            ->select("supplier_name", "supplier_no_pk")
            ->where('status', 1)
            ->where('pharmacy_ind', 1)
            ->orderBy('supplier_name', 'asc')
            ->get();

        $department = ServiceUnit::where('status', '1')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->where('pharmacy_ind', 1)
            ->orwhere('main_store_ind', 1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        return Template::loadView("admin.uhl.pharmacy_report.stock-as-on-report", ['suppliers_name' => $suppliers_name, 'department' => $department]);
    }

    public function stockAsOnReportSearchV1(Request $request)
    {
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {
            $conditon .= " and item_type='MED'";
        }

        $datas = DB::select("SELECT DISTINCT
         item_no_pk item_no_fk,
         item.item_name,
         gen.generic_name,
         chd.stock_su_no_fk,
         CHD.EXPIRY_DATE,
         chd.BATCH_NO,
         chd.INTERNAL_BATCH_NO_UQ,
         fnc_serviceunitname (chd.stock_su_no_fk) department,
         item.supplier_pk_no,
         supp.supplier_name,
         item.sales_price,
         item.purchase_price,
         (SELECT SUM (stock_trans_qty)
            FROM inv_itemstocktranschd
           WHERE     TRUNC (au_entry_at) <
                        TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                 AND stock_su_no_fk = chd.stock_su_no_fk
                 AND item_no_fk = item.item_no_pk)
            op_qty,
         NVL (stock_in, 0) stock_in,
         NVL (stock_out, 0) stock_out,
         (SELECT SUM (stock_trans_qty)
            FROM inv_itemstocktranschd
           WHERE     TRUNC (au_entry_at) <=
                        TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                 AND stock_su_no_fk = chd.stock_su_no_fk
                 AND item_no_fk = item.item_no_pk)
            clos_qty,
            grn.itemreceive_no_fk,
            grn.au_entry_at as grn_date,
            scat.ITEM_TYPE_NAME AS item_sub_category,
            cat.ITEM_TYPE_NAME AS item_category
    FROM sysc_serviceitem item,
         inv_itemstocktranschd chd,
         (  SELECT item_no_fk,
                   chd.stock_su_no_fk,
                   SUM (
                      CASE
                         WHEN stock_trans_qty > 0 THEN stock_trans_qty
                         ELSE 0
                      END)
                      stock_in,
                   ABS (
                      SUM (
                         CASE
                            WHEN stock_trans_qty < 0 THEN stock_trans_qty
                            ELSE 0
                         END))
                      stock_out,
                   SUM (stock_trans_qty) qty
              FROM inv_itemstocktranschd chd, inv_itemstocktransmst mst
             WHERE     TRUNC (chd.au_entry_at) BETWEEN TO_DATE ('$request->from_date',
                                                                'dd/mm/yyyy')
                                                   AND TO_DATE ('$request->from_date',
                                                                'dd/mm/yyyy')
                   AND mst.stocktrans_no_pk = chd.stocktrans_no_fk
          GROUP BY item_no_fk, chd.stock_su_no_fk) trans,
         inv_supplier supp,
         sysc_generic gen,
        phr_itemreceivedtl grn,
        SYSC_ITEMTYPE scat,
        SYSC_ITEMTYPE cat
   WHERE     item.item_no_pk = chd.item_no_fk
         AND item.item_no_pk = trans.item_no_fk(+)
         AND chd.stock_su_no_fk = trans.stock_su_no_fk(+)
         AND item.supplier_pk_no = supp.supplier_no_pk(+)
         AND item.generic_no_fk = gen.generic_no_pk(+)
         AND  chd.itemreceivedtl_no_pk = grn.itemreceivedtl_no_pk(+)
         and item.itemtype_no_fk = scat.itemtype_no_pk(+)
         AND scat.PAR_ITEMTYPE_NO_FK = cat.itemtype_no_pk(+)
          $conditon
         AND ( (SELECT SUM (stock_trans_qty)
                  FROM inv_itemstocktranschd
                 WHERE     TRUNC (au_entry_at) <= TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                       AND stock_su_no_fk = chd.stock_su_no_fk
                       AND item_no_fk = item.item_no_pk)
              ) > 0  -- Ensure closing quantity is greater than 0
ORDER BY chd.stock_su_no_fk, item.item_name");
        return Template::loadView("admin.uhl.pharmacy_report.stock-as-on-report-data", ['data' => $datas]);
    }

    public function stockAsOnReportPrintV1(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {
            $conditon .= " and item_type='MED'";
        }

        $datas = DB::select("SELECT DISTINCT
        item_no_pk item_no_fk,
        item.item_name,
        gen.generic_name,
        chd.stock_su_no_fk,
        chd.expiry_date,
        chd.batch_no,
        chd.internal_batch_no_uq,
        fnc_serviceunitname (chd.stock_su_no_fk) department,
        item.supplier_pk_no,
        supp.supplier_name,
        item.sales_price,
        item.purchase_price,
        (SELECT SUM (stock_trans_qty)
           FROM inv_itemstocktranschd
          WHERE     TRUNC (au_entry_at) <
                       TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                AND stock_su_no_fk = chd.stock_su_no_fk
                AND item_no_fk = item.item_no_pk)
           op_qty,
        NVL (stock_in, 0) stock_in,
        NVL (stock_out, 0) stock_out,
        (SELECT SUM (stock_trans_qty)
           FROM inv_itemstocktranschd
          WHERE     TRUNC (au_entry_at) <=
                       TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                AND stock_su_no_fk = chd.stock_su_no_fk
                AND item_no_fk = item.item_no_pk)
           clos_qty,
           grn.itemreceive_no_fk,
           grn.au_entry_at as grn_date,
           scat.ITEM_TYPE_NAME AS item_sub_category,
           cat.ITEM_TYPE_NAME AS item_category
   FROM sysc_serviceitem item,
        inv_itemstocktranschd chd,
        (  SELECT item_no_fk,
                  chd.stock_su_no_fk,
                  SUM (
                     CASE
                        WHEN stock_trans_qty > 0 THEN stock_trans_qty
                        ELSE 0
                     END)
                     stock_in,
                  ABS (
                     SUM (
                        CASE
                           WHEN stock_trans_qty < 0 THEN stock_trans_qty
                           ELSE 0
                        END))
                     stock_out,
                  SUM (stock_trans_qty) qty
             FROM inv_itemstocktranschd chd, inv_itemstocktransmst mst
            WHERE     TRUNC (chd.au_entry_at) BETWEEN TO_DATE ('$request->from_date',
                                                               'dd/mm/yyyy')
                                                  AND TO_DATE ('$request->from_date',
                                                               'dd/mm/yyyy')
                  AND mst.stocktrans_no_pk = chd.stocktrans_no_fk
         GROUP BY item_no_fk, chd.stock_su_no_fk) trans,
        inv_supplier supp,
        sysc_generic gen,
       phr_itemreceivedtl grn,
       SYSC_ITEMTYPE scat,
       SYSC_ITEMTYPE cat
  WHERE     item.item_no_pk = chd.item_no_fk
        AND item.item_no_pk = trans.item_no_fk(+)
        AND chd.stock_su_no_fk = trans.stock_su_no_fk(+)
        AND item.supplier_pk_no = supp.supplier_no_pk(+)
        AND item.generic_no_fk = gen.generic_no_pk(+)
        AND  chd.itemreceivedtl_no_pk = grn.itemreceivedtl_no_pk(+)
        and item.itemtype_no_fk = scat.itemtype_no_pk(+)
        AND scat.PAR_ITEMTYPE_NO_FK = cat.itemtype_no_pk(+)
         $conditon
        AND ( (SELECT SUM (stock_trans_qty)
                 FROM inv_itemstocktranschd
                WHERE     TRUNC (au_entry_at) <= TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                      AND stock_su_no_fk = chd.stock_su_no_fk
                      AND item_no_fk = item.item_no_pk)
             ) > 0  -- Ensure closing quantity is greater than 0
ORDER BY chd.stock_su_no_fk, item.item_name");

        return view("admin.uhl.pharmacy_report.stock-as-on-report-print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $datas, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);
    }

    public function stockAsOnReportexcelV1(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $conditon = ($request->department != '') ? "and chd.stock_su_no_fk = $request->department" : "";
        $conditon .= ($request->supplier_name != '') ? "and SUPP.SUPPLIER_NO_PK = $request->supplier_name" : "";

        if (session()->get('user.ses_hospital_code') === "IMPERIAL") {
            $conditon .= " and item_type='MED'";
        }

        $datas = DB::select("SELECT DISTINCT
        item_no_pk item_no_fk,
        item.item_name,
        gen.generic_name,
        chd.stock_su_no_fk,
        chd.expiry_date,
        chd.batch_no,
        chd.internal_batch_no_uq,
        fnc_serviceunitname (chd.stock_su_no_fk) department,
        item.supplier_pk_no,
        supp.supplier_name,
        item.sales_price,
        item.purchase_price,
        (SELECT SUM (stock_trans_qty)
           FROM inv_itemstocktranschd
          WHERE     TRUNC (au_entry_at) <
                       TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                AND stock_su_no_fk = chd.stock_su_no_fk
                AND item_no_fk = item.item_no_pk)
           op_qty,
        NVL (stock_in, 0) stock_in,
        NVL (stock_out, 0) stock_out,
        (SELECT SUM (stock_trans_qty)
           FROM inv_itemstocktranschd
          WHERE     TRUNC (au_entry_at) <=
                       TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                AND stock_su_no_fk = chd.stock_su_no_fk
                AND item_no_fk = item.item_no_pk)
           clos_qty,
           grn.itemreceive_no_fk,
           grn.au_entry_at as grn_date,
           scat.ITEM_TYPE_NAME AS item_sub_category,
           cat.ITEM_TYPE_NAME AS item_category
   FROM sysc_serviceitem item,
        inv_itemstocktranschd chd,
        (  SELECT item_no_fk,
                  chd.stock_su_no_fk,
                  SUM (
                     CASE
                        WHEN stock_trans_qty > 0 THEN stock_trans_qty
                        ELSE 0
                     END)
                     stock_in,
                  ABS (
                     SUM (
                        CASE
                           WHEN stock_trans_qty < 0 THEN stock_trans_qty
                           ELSE 0
                        END))
                     stock_out,
                  SUM (stock_trans_qty) qty
             FROM inv_itemstocktranschd chd, inv_itemstocktransmst mst
            WHERE     TRUNC (chd.au_entry_at) BETWEEN TO_DATE ('$request->from_date',
                                                               'dd/mm/yyyy')
                                                  AND TO_DATE ('$request->from_date',
                                                               'dd/mm/yyyy')
                  AND mst.stocktrans_no_pk = chd.stocktrans_no_fk
         GROUP BY item_no_fk, chd.stock_su_no_fk) trans,
        inv_supplier supp,
        sysc_generic gen,
       phr_itemreceivedtl grn,
       SYSC_ITEMTYPE scat,
       SYSC_ITEMTYPE cat
  WHERE     item.item_no_pk = chd.item_no_fk
        AND item.item_no_pk = trans.item_no_fk(+)
        AND chd.stock_su_no_fk = trans.stock_su_no_fk(+)
        AND item.supplier_pk_no = supp.supplier_no_pk(+)
        AND item.generic_no_fk = gen.generic_no_pk(+)
        AND  chd.itemreceivedtl_no_pk = grn.itemreceivedtl_no_pk(+)
        and item.itemtype_no_fk = scat.itemtype_no_pk(+)
        AND scat.PAR_ITEMTYPE_NO_FK = cat.itemtype_no_pk(+)
         $conditon
        AND ( (SELECT SUM (stock_trans_qty)
                 FROM inv_itemstocktranschd
                WHERE     TRUNC (au_entry_at) <= TO_DATE ('$request->from_date', 'dd/mm/yyyy')
                      AND stock_su_no_fk = chd.stock_su_no_fk
                      AND item_no_fk = item.item_no_pk)
             ) > 0  -- Ensure closing quantity is greater than 0
ORDER BY chd.stock_su_no_fk, item.item_name");


        $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'data' => $datas, 'from_date' => $request->from_date, 'to_date' => $request->to_date];
        $fileToExport = "pharmacy_stock_print_report";
        $html = View("admin.uhl.pharmacy_report.stock-as-on-report-excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }
}
