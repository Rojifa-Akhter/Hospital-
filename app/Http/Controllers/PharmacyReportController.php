<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Library\Template;
use Illuminate\Support\Facades\DB;
use App\Traits\DatatablesLoader;
use App\Traits\InvoiceData;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use App\Models\Designation;
use App\Models\ItemType;
use Cache;
use PDF;
use PDO;
use Auth;
use App;
use App\Models\Supplier;
use Session;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class PharmacyReportController extends Controller
{
    use DatatablesLoader, InvoiceData, LookupData;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pharmacyCashierWiseSummary()
    {
        return Template::loadview("admin.reports.pharmacy.cashier_wise_summary");
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
        return Template::loadview("admin.reports.pharmacy.cashier_wise_summary_list", [
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

        $title = "Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.pharmacy.cashier_wise_summary_report_print", ['data' => $data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');;
        return $pdf->stream('cashier-wise-report.pdf');
    }
    public function stockAdjustmentReport()
    {
        $stock_reports  = DB::table('stock_bill_itemrecon_vw')->where('invoice_date', date('Y-m-d'))->orderBy('bill_item_name', 'asc')->get();
        return Template::loadView('admin.reports.pharmacy.stock_adjustment_report', compact('stock_reports'));
    }
    public function stockAdjustmentReportSearch(Request $request)
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
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(INVOICE_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $stock_reports  = DB::select("select * from stock_bill_itemrecon_vw $sql_cond order by BILL_ITEM_NAME asc");
        // $stock_reports  = DB::table('stock_bill_itemrecon_vw')->where('bill_invoice_date', date('Y-m-d', strtotime($request->search_date_from)))->orderBy('bill_item_name', 'asc')->get();


        return Template::loadView('admin.reports.pharmacy.stock_adjustment_report_table', compact('stock_reports'));
    }
    public function stockAdjustmentReportPdf(Request $request)
    {

        $date = isset($request->search_date_from) ? date('Y-m-d', strtotime($request->search_date_from)) :  date('Y-m-d');

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $title = date('d/m/Y h:i a');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();


        // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
        // ->where('sup.user_no_fk', Auth::id())
        // ->where('med_store_ind', 1)
        // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'));

        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(INVOICE_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $stock_reports  = DB::select("select * from stock_bill_itemrecon_vw $sql_cond order by BILL_ITEM_NAME asc");

        // $stock_reports  = DB::table('stock_bill_itemrecon_vw')->where('bill_invoice_date', $date)->orderBy('bill_item_name', 'asc')->get();

        $data['type'] = 'store';
        $data['po_hospital_details'] = $po_hospital_details;
        // dd($storeWiseStocks);
        // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
        // dd($data);
        // return view('admin.store.stock_ledger_pdf',$data);

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.pharmacy.stock_adjustment_report_pdf', ['stock_reports' => $stock_reports, 'type' => 'store', 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }

    public function supplierWisePurchaseSummaryReport()
    {
        $inv_supplier = Supplier::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.supplier.supplier_wise_summary_report", [
            'inv_supplier' => $inv_supplier
        ]);
    }

    public function searchSupplierWisePurchaseSummaryReport(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        $sql_cond = "";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->supplier_id) ? "and supplier_no_fk ='$request->supplier_id'" : '';



        $supplier_wise =  DB::select("select challan_no,trunc(challan_date) challan_date ,supplier_name,trunc(au_entry_at) au_entry_at,itemreceive_uid,total_received_amount,vat_amount,discount_amount,return_amt_adj from phr_itemreceive_challan_vw where au_entry_hospital_no_fk = $hospital_id and module_code='PHR' $sql_cond group by challan_no,trunc(challan_date),supplier_name,trunc(au_entry_at),itemreceive_uid,total_received_amount,vat_amount,discount_amount,return_amt_adj order by supplier_name asc ");
        // dd( $supplier_wise);
        // DB::select("select challan_no,trunc(challan_date) challan_date ,supplier_name,trunc(au_entry_at) au_entry_at,itemreceive_uid,total_received_amount,discount_amount,vat_amount,return_amt_adj from phr_itemreceive_challan_vw where au_entry_hospital_no_fk = $hospital_id and module_code='PHR' $sql_cond group by challan_no,trunc(challan_date),supplier_name,trunc(au_entry_at),itemreceive_uid,total_received_amount,discount_amount,vat_amount,return_amt_adj order by supplier_name asc ");

        $supplier_wise_count = DB::select("select supplier_name,count(itemreceive_uid) total_receive_count,sum(discount_amount) discount_amount,sum(vat_amount) as vat_amount ,sum(total_received_amount) total_received_amount,sum(return_amt_adj) return_amt_adj from phr_itemreceive_challan_vw where au_entry_hospital_no_fk = $hospital_id  $sql_cond group by supplier_name");
        //dd( $supplier_wise_count);
        $supplier_wise_arr = [];
        $supplier_wise_total = [];
        if (!empty($supplier_wise_count)) {
            foreach ($supplier_wise_count as $supp) {
                $supplier_wise_arr[$supp->supplier_name]  = $supp->total_receive_count;
                $supplier_wise_total[$supp->supplier_name][]  = $supp;
            }
        }
        //dd($supplier_wise_total);
        return Template::loadview("admin.reports.supplier.supplier_wise_summary_report_list", [
            'supplier_wise' => $supplier_wise,
            'supplier_wise_arr' => $supplier_wise_arr,
            'supplier_wise_total' => $supplier_wise_total,

        ]);
    }
    public function supplierWisePurchaseSummaryReportPDF(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        $sql_cond = "";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }
        $sql_cond .=  isset($request->supplier_id) ? "and supplier_no_fk ='$request->supplier_id'" : '';
        $supplier_wise = DB::select("select challan_no,trunc(challan_date) challan_date ,supplier_name,trunc(au_entry_at) au_entry_at,itemreceive_uid,total_received_amount,vat_amount,discount_amount,return_amt_adj from phr_itemreceive_challan_vw where au_entry_hospital_no_fk = $hospital_id and module_code='PHR' $sql_cond group by challan_no,trunc(challan_date),supplier_name,trunc(au_entry_at),itemreceive_uid,total_received_amount,vat_amount,discount_amount,return_amt_adj order by supplier_name asc ");
        $supplier_wise_count = DB::select("select supplier_name,count(itemreceive_uid) total_receive_count,sum(vat_amount) as vat_amount,sum(discount_amount) discount_amount ,sum(total_received_amount) total_received_amount,sum(return_amt_adj) return_amt_adj from phr_itemreceive_challan_vw where au_entry_hospital_no_fk = $hospital_id  $sql_cond group by supplier_name");

        $supplier_wise_arr = [];
        $supplier_wise_total = [];
        if (!empty($supplier_wise_count)) {
            foreach ($supplier_wise_count as $supp) {
                $supplier_wise_arr[$supp->supplier_name]  = $supp->total_receive_count;
                $supplier_wise_total[$supp->supplier_name][]  = $supp;
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_summary_report_pdf', [
            'type' => 'store', 'po_hospital_details' => $po_hospital_details,  'supplier_wise' => $supplier_wise,
            'supplier_wise_arr' => $supplier_wise_arr,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'supplier_wise_total' => $supplier_wise_total,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }
    public function salesReturnReport()
    {
        $inv_supplier = Supplier::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.supplier.sales_return_report", [
            'inv_supplier' => $inv_supplier
        ]);
    }
    public function searchSalesReturnReport(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $sql_cond = "";
        $query = DB::table('finc_pharmacy_sales_cancel')->select('item_name',DB::raw('avg(item_rate) as item_rate'), DB::raw('sum(cancel_qty) as cancel_qty'),DB::raw('sum(cancel_amount) as cancel_amount'), DB::raw('sum(discount_amt) as discount_amt'), DB::raw('sum(refund_amt) as refund_amt'));
        // if ($request->supplier_id != "") {
        //     $query->where('supplier_no_pk', $request->supplier_id);
        // }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $supplier_wise = $query->orderBy('item_name', 'asc')->groupBy('item_name')->get();
    //  dd($supplier_wise);
        return Template::loadview("admin.reports.supplier.sales_return_report_list", ['supplier_wise' => $supplier_wise]);
    }
    public function salesReturnReportPDF(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
      
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
       
        $query = DB::table('finc_pharmacy_sales_cancel')->select('item_name',DB::raw('avg(item_rate) as item_rate'), DB::raw('sum(cancel_qty) as cancel_qty'),DB::raw('sum(cancel_amount) as cancel_amount'), DB::raw('sum(discount_amt) as discount_amt'), DB::raw('sum(refund_amt) as refund_amt'));
        // if ($request->supplier_id != "") {
        //     $query->where('supplier_no_pk', $request->supplier_id);
        // }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $sales_return = $query->orderBy('item_name', 'asc')->groupBy('item_name')->get();
        

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_sales_report_pdf', [
            'po_hospital_details' => $po_hospital_details,  'sales_return' => $sales_return,
            'date_from' => $date_from,
            'date_to' => $date_to,

        ])->setPaper('a4', 'portrait');
        return $pdf->stream("sales_cancel_report", array("Attachment" => false));
    }
    public function supplierWiseSalesReport()
    {
        $inv_supplier = Supplier::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.supplier.supplier_wise_sales_report", [
            'inv_supplier' => $inv_supplier
        ]);
    }
    public function searchSupplierWiseSalesReport(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $sql_cond = "";
        $query = DB::table('finc_invoicedtl_vw')->select(DB::raw('trunc(invoice_date) as invoice_date'), 'supplier_no_pk', 'supplier_name', 'item_rate', 'item_name', DB::raw('sum(item_qty) as item_qty'), DB::raw('sum(cancel_qty) as cancel_qty'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(item_vat) as item_vat'));
        if ($request->supplier_id != "") {
            $query->where('supplier_no_pk', $request->supplier_id);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $supplier_wise = $query->whereIn('module_code', ['PHR', 'PHR-I'])->orderBy('invoice_date', 'desc')->groupBy(DB::raw('trunc(invoice_date)'), 'supplier_no_pk', 'supplier_name', 'item_name', 'item_rate')->get();
        $supplier_wise_arr = [];
        if (!empty($supplier_wise)) {
            foreach ($supplier_wise as  $value) {
                $supplier_wise_arr[$value->supplier_name][] = $value;
            }
        }
        return Template::loadview("admin.reports.supplier.supplier_wise_sales_report_list", ['supplier_wise' => $supplier_wise_arr]);
    }
    public function supplierWiseSalesReportPDF(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $sql_cond = "";
        $query = DB::table('finc_invoicedtl_vw')->select(DB::raw('trunc(invoice_date) as invoice_date'), 'supplier_no_pk', 'supplier_name', 'item_rate', 'item_name', DB::raw('sum(item_qty) as item_qty'), DB::raw('sum(cancel_qty) as cancel_qty'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(item_vat) as item_vat'));
        if ($request->supplier_id != "") {
            $query->where('supplier_no_pk', $request->supplier_id);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $supplier_wise = $query->whereIn('module_code', ['PHR', 'PHR-I'])->orderBy('invoice_date', 'desc')->groupBy(DB::raw('trunc(invoice_date)'), 'supplier_no_pk', 'supplier_name', 'item_name', 'item_rate')->get();
        $supplier_wise_arr = [];
        if (!empty($supplier_wise)) {
            foreach ($supplier_wise as  $value) {
                $supplier_wise_arr[$value->supplier_name][] = $value;
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_sales_report_pdf', [
            'po_hospital_details' => $po_hospital_details,  'supplier_wise' => $supplier_wise_arr,
            'date_from' => $date_from,
            'date_to' => $date_to,

        ])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }
    public function supplierWiseSalesSummaryReport()
    {
        $inv_supplier = Supplier::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.supplier.supplier_wise_sales_summary_report", [
            'inv_supplier' => $inv_supplier
        ]);
    }

    public function searchSupplierWiseSalesSummaryReport(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $sql_cond = "";
        $query = DB::table('finc_invoicedtl_vw')->select( 'supplier_no_pk', 'supplier_name', DB::raw('sum(current_item_qty) as current_item_qty'), DB::raw('sum(total_item_amt) as total_item_amt'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(item_vat) as item_vat'));
        if ($request->supplier_id != "") {
            $query->where('supplier_no_pk', $request->supplier_id);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $supplier_wise = $query->whereIn('module_code', ['PHR', 'PHR-I'])
        ->orderBy('supplier_name', 'asc')        
        ->groupBy( 'supplier_no_pk', 'supplier_name')
        ->get();
        return Template::loadview("admin.reports.supplier.supplier_wise_sales_summary_report_list", ['supplier_wise' => $supplier_wise]);
    }
    public function supplierWiseSalesSummaryReportPDF(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : '';
        $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : '';
        $sql_cond = "";
        $query = DB::table('finc_invoicedtl_vw')->select( 'supplier_no_pk', 'supplier_name', DB::raw('sum(current_item_qty) as current_item_qty'), DB::raw('sum(total_item_amt) as total_item_amt'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(item_vat) as item_vat'));
        if ($request->supplier_id != "") {
            $query->where('supplier_no_pk', $request->supplier_id);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereBetween(DB::raw('trunc(invoice_date)'), [$date_from, $date_to]);
        }
        $supplier_wise = $query->whereIn('module_code', ['PHR', 'PHR-I'])
        ->orderBy('supplier_name', 'asc')        
        ->groupBy( 'supplier_no_pk', 'supplier_name')
        ->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_sales_report_summary_pdf', [
            'po_hospital_details' => $po_hospital_details,  'supplier_wise' => $supplier_wise,
            'date_from' => $date_from,
            'date_to' => $date_to,

        ])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }

    public function supplierWisePurchaseItemReport()
    {
        $inv_supplier = Supplier::where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.reports.supplier.supplier_wise_item_purchase_report", [
            'inv_supplier' => $inv_supplier
        ]);
    }

    public function searchSupplierWisePurchaseItemSummaryReport(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        $sql_cond = "";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->supplier_id) ? "and supplier_no_fk ='$request->supplier_id'" : '';



        $supplier_wise = DB::select("SELECT supplier_name,
        item_no_fk,
        item_name,
        PR_UOM_TRADEPRICE AS purchase_price,
        PR_UOM_LONG AS pr_uom_short,
        generic_name,
        PR_UOM_QTY AS received_quantity,
        vat_amount_itm,
        discount_amount_itm,
        PR_UOM_QTY AS unit_qty
   FROM phr_itemreceive_item_vw  where au_entry_hospital_no_fk = $hospital_id  $sql_cond  order by generic_name asc ");
        // $supplier_wise = DB::select("select supplier_name,item_no_fk,item_name,purchase_price,pr_uom_short,generic_name,received_quantity, vat_amount_itm , discount_amount_itm , (purchase_price /received_quantity) as unit_qty from phr_itemreceive_item_vw  where au_entry_hospital_no_fk = $hospital_id  $sql_cond  order by generic_name asc ");
        // dd( $supplier_wise );

        $supplier_wise_count = DB::select("select supplier_name,generic_name,count(item_no_fk) total_item from phr_itemreceive_item_vw where au_entry_hospital_no_fk = $hospital_id  $sql_cond group by supplier_name,generic_name");
        //dd( $supplier_wise_count);
        $supplier_wise_arr = [];
        $supplier_wise_total = [];
        if (!empty($supplier_wise_count)) {
            foreach ($supplier_wise_count as $supp) {
                $supplier_wise_arr[$supp->supplier_name][$supp->generic_name]  = $supp->total_item;
                //$supplier_wise_total[supplier_name]
            }
        }

        if (!empty($supplier_wise)) {
            foreach ($supplier_wise as $supp) {
                $supplier_wise_total[$supp->supplier_name][]  = $supp;
                //$supplier_wise_total[supplier_name]
            }
        }
        // dd($supplier_wise_total,1);
        return Template::loadview("admin.reports.supplier.supplier_wise_summary_item_purchase_report_list", [
            'supplier_wise' => $supplier_wise,
            'supplier_wise_arr' => $supplier_wise_arr,
            'supplier_wise_total' => $supplier_wise_total,

        ]);
    }
    public function supplierWisePurchaseItemSummaryReportPDF(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";

        $sql_cond = "";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->supplier_id) ? "and supplier_no_fk ='$request->supplier_id'" : '';



        $supplier_wise = DB::select("SELECT supplier_name,
        item_no_fk,
        item_name,
        PR_UOM_TRADEPRICE AS purchase_price,
        PR_UOM_LONG AS pr_uom_short,
        generic_name,
        PR_UOM_QTY AS received_quantity,
        vat_amount_itm,
        discount_amount_itm,
        PR_UOM_QTY AS unit_qty
   FROM phr_itemreceive_item_vw  where au_entry_hospital_no_fk = $hospital_id  $sql_cond  order by generic_name asc ");
        // dd( $supplier_wise );

        $supplier_wise_count = DB::select("select supplier_name,generic_name,count(item_no_fk) total_item from phr_itemreceive_item_vw where au_entry_hospital_no_fk = $hospital_id  $sql_cond group by supplier_name,generic_name");
        //dd( $supplier_wise_count);
        $supplier_wise_arr = [];
        $supplier_wise_total = [];
        if (!empty($supplier_wise_count)) {
            foreach ($supplier_wise_count as $supp) {
                $supplier_wise_arr[$supp->supplier_name][$supp->generic_name]  = $supp->total_item;
                //$supplier_wise_total[supplier_name]
            }
        }

        if (!empty($supplier_wise)) {
            foreach ($supplier_wise as $supp) {
                $supplier_wise_total[$supp->supplier_name][]  = $supp;
                //$supplier_wise_total[supplier_name]
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_purchase_item_summary_report_pdf', [
            'type' => 'store', 'po_hospital_details' => $po_hospital_details,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'supplier_wise' => $supplier_wise,
            'supplier_wise_arr' => $supplier_wise_arr,
            'supplier_wise_total' => $supplier_wise_total,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }

    public function supplierWisePurchaseItemSummaryReport(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";

        $sql_cond = "";
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->supplier_id) ? "and supplier_no_fk ='$request->supplier_id'" : '';



        $supplier_wise = DB::select("SELECT supplier_name, SUM (PR_UOM_TRADEPRICE) AS purchase_price
        FROM phr_itemreceive_item_vw where au_entry_hospital_no_fk = $hospital_id  $sql_cond
    GROUP BY supplier_name");

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.supplier.supplier_wise_purchase_summary_pdf', [
            'type' => 'store', 'po_hospital_details' => $po_hospital_details,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'supplier_wise' => $supplier_wise
        ])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }

    public function invoiceWiseProfitLossReport()
    {
        return Template::loadview("admin.reports.profit_loss.invoice_wise_profit_loss_report");
    }
    public function searchInvoiceWiseProfitLossReport()
    {

        return Template::loadview("admin.reports.profit_loss.invoice_wise_profit_loss_report");
    }






    public function stockAdjustmentInvestgationReport()
    {
        $stock_reports  = db::select("select invoice_date,
                        bill_item_name,
                        sum (bill_item_qty) item_qty,
                        sum (bill_cancel_qty) cancel_qty,
                        sum (bill_net_sales_item_qty) sales_item_qty,
                        bill_item_rate item_rate
                from rpt_01_item_detail_qty_amt_vw
                where trunc (invoice_date)= trunc(sysdate)
                group by invoice_date, bill_item_name, bill_item_rate
                order by invoice_date desc");
        return Template::loadView('admin.reports.pharmacy.stock_adjustment_report_investigation', compact('stock_reports'));
    }
    public function stockAdjustmentReportInvestgationSearch(Request $request)
    {
        // $stock_reports  = DB::table('stock_bill_itemrecon_vw')->where('bill_invoice_date', date('Y-m-d', strtotime($request->search_date_from)))->orderBy('bill_item_name', 'asc')->get();
        // dd($request->all());

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

        $stock_reports = DB::select(" SELECT INVOICE_DATE,
                                BILL_ITEM_NAME,
                                SUM (BILL_ITEM_QTY) item_qty,
                                SUM (BILL_CANCEL_QTY) cancel_qty,
                                SUM (BILL_NET_SALES_ITEM_QTY) sales_item_qty,
                                BILL_ITEM_RATE item_rate
                        FROM RPT_01_ITEM_DETAIL_QTY_AMT_VW $sql_cond
                        GROUP BY INVOICE_DATE, BILL_ITEM_NAME, BILL_ITEM_RATE  order by INVOICE_DATE,BILL_ITEM_NAME ASC");
        // dd($report_data);
        return Template::loadView('admin.reports.pharmacy.stock_adjustment_report_investigation_table', compact('stock_reports'));
    }
    public function stockAdjustmentReporInvestgationtPdf(Request $request)
    {

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

        $stock_reports = DB::select(" SELECT INVOICE_DATE,
                                BILL_ITEM_NAME,
                                SUM (BILL_ITEM_QTY) item_qty,
                                SUM (BILL_CANCEL_QTY) cancel_qty,
                                SUM (BILL_NET_SALES_ITEM_QTY) sales_item_qty,
                                BILL_ITEM_RATE item_rate
                        FROM RPT_01_ITEM_DETAIL_QTY_AMT_VW $sql_cond
                        GROUP BY INVOICE_DATE, BILL_ITEM_NAME, BILL_ITEM_RATE  order by INVOICE_DATE,BILL_ITEM_NAME ASC");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.reports.pharmacy.stock_adjustment_report_investigation_pdf', ['stock_reports' => $stock_reports, 'type' => 'store', 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to,])->setPaper('a4', 'portrait');
        return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
    }


    //inter Department Report
    public function interDepartmentReport()
    {
        $interdept_reports = DB::select("select ITEM_CODE, ITEM_NAME, DPARTMENT, ITEM_TYPE, SALES_PRICE, PURCHASE_PRICE, RE_ORDER_LEVEL, CURRENT_STOCK from inv_reorderlevel_vw order by current_stock desc");
        return Template::loadview("admin.reports.interdepartment.inv_reorder_report", compact('interdept_reports'));
    }
    public function interDepartmentSearch(Request $request)
    {
        dd($request->all());
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

        $interdept_reports = DB::select("select ITEM_CODE, ITEM_NAME, DPARTMENT, ITEM_TYPE, SALES_PRICE, PURCHASE_PRICE, RE_ORDER_LEVEL, CURRENT_STOCK from inv_reorderlevel_vw $sql_cond order by item_name asc");
        dd($interdept_reports);
        return Template::loadView('admin.reports.inv_reorder_search_data', compact('stock_reports'));
    }
    public function interDepartmentPdf(Request $request)
    {

        $interdept_reports = DB::select("select ITEM_CODE, ITEM_NAME, DPARTMENT, ITEM_TYPE, SALES_PRICE, PURCHASE_PRICE, RE_ORDER_LEVEL, CURRENT_STOCK from inv_reorderlevel_vw order by current_stock desc");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($request->hdn_report_type == 'PDF') {
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.reports.interdepartment.inv_reorder_report_pdf', ['po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'interdept_reports' => $interdept_reports])->setPaper('a4', 'portrait');
            return $pdf->stream("dept_wise_ipd_patient", array("Attachment" => false));
        }
        if ($request->hdn_report_type == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'interdept_reports' => $interdept_reports
            ];
            $fileToExport = "inv_reorder_level_report";
            $html = View("admin.reports.interdepartment.inv_reorder_report_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }









    // Purchase Report for EWMCH

    public function pharmacyReportThirtyDays()
    {
        return Template::loadView("admin.pharmacy.reports.purchase_list_thirty_days");
    }


    public function pharmacySummaryReport()
    {
        return Template::loadView("admin.pharmacy.reports.pharmacy_summary_report");
    }

    public function pharmacyProductShortageReport()
    {
        return Template::loadView("admin.pharmacy.reports.pharmacy_product_shortage_report");
    }
    public function pharmacyDrugDepartmentWiseReport()
    {
        return Template::loadView("admin.pharmacy.reports.pharmacy_drug_department_wise_report");
    }

    public function pharmacyDrugDepartmentWiseLedger()
    {
        return Template::loadView("admin.pharmacy.reports.pharmacy_drug_department_wise_ledger");
    }
    public function topSellingItem()
    {
        return Template::loadView("admin.pharmacy.reports.top_selling_item_pharmacy");
    }

    public function topSellingSearch(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        $sql_cond = "";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(dtl.au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->generic_hdn_id) ? "and generic_no_fk ='$request->generic_hdn_id'" : '';



        $report_data = DB::select("
        SELECT 
            item.item_no_pk,
            item.item_name,
            SUM(dtl.item_qty) AS sales_qty,
            SUM(dtl.item_qty - NVL(dtl.cancel_qty, 0)) AS qty,
            item.sales_price,
            item.supplier_pk_no,
            item.generic_no_fk,
            sup.supplier_name,
            gen.generic_name
        FROM 
            finc_invoicemst mst
        JOIN 
            finc_invoicedtl dtl ON mst.invoice_no_pk = dtl.invoice_no_fk
        JOIN 
            sysc_serviceitem item ON item.item_no_pk = dtl.item_no_fk
        JOIN 
            inv_supplier sup ON item.supplier_pk_no = sup.supplier_no_pk
        LEFT JOIN 
            sysc_generic gen ON item.generic_no_fk = gen.generic_no_pk
        JOIN 
            sysc_module mod ON mst.module_no_fk = mod.module_no_pk
        WHERE 
            mst.invoice_no_pk = dtl.invoice_no_fk
            $sql_cond
            AND mod.module_code IN ('PHR','PHR-I','PHR-D','PHR-E','PHR-O')
        GROUP BY 
            item.item_no_pk,
            item.item_name,
            item.sales_price,
            item.supplier_pk_no,
            item.generic_no_fk,
            sup.supplier_name,
            gen.generic_name
        ORDER BY 
            sales_qty DESC
    ");

//         $report_data = DB::select(" SELECT item.item_no_pk,
//         item.item_name,
//         sum (dtl.item_qty ) sales_qty,
//         sum (dtl.item_qty - nvl (dtl.cancel_qty, 0)) qty,
//         item.sales_price,
//         supplier_pk_no,
//         generic_no_fk,
//         supplier_name,
//         generic_name
//    from finc_invoicemst mst,
//    finc_invoicedtl dtl,
//         sysc_serviceitem item,
//         inv_supplier sup,
//         sysc_generic gen,
//         sysc_module mod
//   where item.item_no_pk = dtl.item_no_fk
//   and mst.invoice_no_pk=dtl.invoice_no_fk
//      $sql_cond
//         and mod.module_code in ('PHR','PHR-I','PHR-D','PHR-E','PHR-O')
//         and mst.module_no_fk=mod.module_no_pk
//         and item.supplier_pk_no = sup.supplier_no_pk
//         and item.generic_no_fk = gen.generic_no_pk
// group by item.item_no_pk,
//         item.item_name,
//         item.sales_price,
//         supplier_pk_no,
//         generic_no_fk,
//         supplier_name,
//         generic_name
// order by 3 desc");
      
        // $supplier_wise = DB::select("select supplier_name,item_no_fk,item_name,purchase_price,pr_uom_short,generic_name,received_quantity, vat_amount_itm , discount_amount_itm , (purchase_price /received_quantity) as unit_qty from phr_itemreceive_item_vw  where au_entry_hospital_no_fk = $hospital_id  $sql_cond  order by generic_name asc ");
        //    dd( $report_data );

        return Template::loadview("admin.pharmacy.reports.pharmacy_genetic_wise_item_table", [
            'report_data' => $report_data

        ]);
    }
    public function topSellingPdf(Request $request)
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $date_from = "$request->search_date_from";
        $date_to = "$request->search_date_to";
        $sql_cond = "";

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $sql_cond .= "and trunc(dtl.au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')";
        }

        $sql_cond .=  isset($request->generic_hdn_id) ? "and generic_no_fk ='$request->generic_hdn_id'" : '';



        $report_data = DB::select("
        SELECT 
            item.item_no_pk,
            item.item_name,
            SUM(dtl.item_qty) AS sales_qty,
            SUM(dtl.item_qty - NVL(dtl.cancel_qty, 0)) AS qty,
            item.sales_price,
            item.supplier_pk_no,
            item.generic_no_fk,
            sup.supplier_name,
            gen.generic_name
        FROM 
            finc_invoicemst mst
        JOIN 
            finc_invoicedtl dtl ON mst.invoice_no_pk = dtl.invoice_no_fk
        JOIN 
            sysc_serviceitem item ON item.item_no_pk = dtl.item_no_fk
        JOIN 
            inv_supplier sup ON item.supplier_pk_no = sup.supplier_no_pk
        LEFT JOIN 
            sysc_generic gen ON item.generic_no_fk = gen.generic_no_pk
        JOIN 
            sysc_module mod ON mst.module_no_fk = mod.module_no_pk
        WHERE 
            mst.invoice_no_pk = dtl.invoice_no_fk
            $sql_cond
            AND mod.module_code IN ('PHR','PHR-I','PHR-D','PHR-E','PHR-O')
        GROUP BY 
            item.item_no_pk,
            item.item_name,
            item.sales_price,
            item.supplier_pk_no,
            item.generic_no_fk,
            sup.supplier_name,
            gen.generic_name
        ORDER BY 
            sales_qty DESC
    ");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = "top Sales";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('admin.pharmacy.reports.top_sale_products_pdf', ['po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'barcode_no' => $barcode_no, 'report_data' => $report_data])->setPaper('a4', 'portrait');
        return $pdf->stream("top_sales_products_pdf", array("Attachment" => false));
    }
}
