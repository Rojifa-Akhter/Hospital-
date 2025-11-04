<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use Auth;
use DB;
use Redirect;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PDO;
use PDF;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\Session;

class PurchaseAccountBookController extends Controller
{
    use DatatablesLoader;

    public function __construct()
	{
		$this->middleware('auth');
	}

    public function purchaseAccountBook(){
        return Template::loadView("admin.uhl.inventory.purchase-account-book");
    }
   
    public function purchaseAccountBookPDF(Request $request){
        $d =$request->date !="" ?  date('Y-m-d', strtotime($request->date)):"";
        $data = DB::select("select opening_qty,trade_price opening_rate,challan_no,challan_date,itemreceive_no_pk,dtl.item_no_fk,fnc_serviceitemname(dtl.item_no_fk) item_name,round(item_qty) qty, uom_code, trade_price, vat_amount_itm, discount_amount_itm,
        supplier_name,  addr1, supp_tin,consumption_qty, trade_price con_rate, mst.remarks
        from phr_itemreceivemst mst join phr_itemreceivedtl dtl
        on mst.itemreceive_no_pk=dtl.itemreceive_no_fk
        join sysc_serviceitem_uom uom
        on dtl.uom=uom.uom_no_pk
        join inv_supplier supp
        on supp.supplier_no_pk=mst.supplier_no_fk
        left join (select round(sum(stock_trans_qty)) opening_qty ,avg(item_rate) opening_rate,chd.stock_su_no_fk,item_no_fk
        from inv_itemstocktranschd chd, inv_itemstocktransmst mst 
        where mst.stocktrans_no_pk=chd.stocktrans_no_fk
        and trunc(chd.au_entry_at) < '$d'
        group by chd.stock_su_no_fk,item_no_fk) ope
        on dtl.item_no_fk=ope.item_no_fk
        and mst.store_su_no_fk=ope.stock_su_no_fk
        left join (select abs(sum(stock_trans_qty))consumption_qty ,avg(item_rate) consump_rate,chd.stock_su_no_fk,item_no_fk
        from inv_itemstocktranschd chd, inv_itemstocktransmst mst 
        where mst.stocktrans_no_pk=chd.stocktrans_no_fk
        and trunc(chd.au_entry_at) = '$d'
        and stock_trans_qty < 0
        group by chd.stock_su_no_fk,item_no_fk) con 
        on dtl.item_no_fk=con.item_no_fk
        and mst.store_su_no_fk=con.stock_su_no_fk
        where trunc(mst.au_entry_at) = '$d'
        order by challan_no,item_name");
        // dd($data);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.purchase-register-report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "data"=>$data, "d"=>$d])->setPaper('a4', 'landscape');
		return $pdf->stream('purchase-account-book.pdf');
    
    }


    public function leadTimeReport(Request $request){
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.lead-time-report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details])->setPaper('a4', 'landscape');
		return $pdf->stream('lead-time-report.pdf');

    }


}
