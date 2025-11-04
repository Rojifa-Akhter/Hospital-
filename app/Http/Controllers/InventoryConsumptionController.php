<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Session;
use DB;
use PDF;

class InventoryConsumptionController extends Controller
{
    //
    public function index()
    {

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->get();

        return Template::loadView("admin.store.inventory.consumption.item_consumption", ['stores' => $stores]);
    }
    public function stockTransferRecord()
    {

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('serviceunit_no_pk', '=', Session::get('user.su_pk_no'))
            ->get();

        return Template::loadView("admin.store.inventory.consumption.item_stock_transfer_record", ['stores' => $stores]);
    }
    public function searchInventoryTransfer()
    {

        $query = DB::table('inv_itemstocktransmstchd_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('trans_type_iss_rcv', 'TRANSIN')->where('stock_su_no_fk_to', '=', Session::get('user.su_pk_no'));
        if (isset($request->from_date) && isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                ->where(DB::raw('trunc(trans_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        } elseif (isset($request->from_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->from_date)));
        } elseif (isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->to_date)));
        }
        if (isset($request->store_id)) {
            $query->where('stock_su_no_fk_to', '=', $request->store_id);
        }
        if (isset($request->item_id)) {
            $query->where('item_no_fk', '=', $request->item_id);
        }

        ///dd($query->get(),$request->all());
        return Template::loadView("admin.store.inventory.consumption.item_consumption_table", ['consumption_data' =>  $query->orderBy('item_name', 'asc')->get()]);
    }
    public function searchInventoryConsumption(Request $request)
    {

        // dd($request->all());

        $query = DB::table('inv_itemstocktransmstchd_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('trans_type_iss_rcv', 'TRANSIN');
        if (isset($request->from_date) && isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                ->where(DB::raw('trunc(trans_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        } elseif (isset($request->from_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->from_date)));
        } elseif (isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->to_date)));
        }
        if (isset($request->store_id)) {
            $query->where('stock_su_no_fk_to', '=', $request->store_id);
        }
        if (isset($request->item_id)) {
            $query->where('item_no_fk', '=', $request->item_id);
        }

        ///dd($query->get(),$request->all());
        return Template::loadView("admin.store.inventory.consumption.item_consumption_table", ['consumption_data' =>  $query->orderBy('item_name', 'asc')->get()]);
    }
    public function searchInventoryConsumptionpdf(Request $request)
    {

        // dd($request->all());

        $query = DB::table('inv_itemstocktransmstchd_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('trans_type_iss_rcv', 'TRANSIN');
        if (isset($request->from_date) && isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                ->where(DB::raw('trunc(trans_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        } elseif (isset($request->from_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->from_date)));
        } elseif (isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->to_date)));
        }
        if (isset($request->store_id)) {
            $query->where('stock_su_no_fk_to', '=', $request->store_id);
        }
        if (isset($request->item_id)) {
            $query->where('item_no_fk', '=', $request->item_id);
        }
        $print_type = "PDF";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        ///dd($query->get(),$request->all());
        $pdf = PDF::loadView("admin.store.inventory.consumption.item_consumption_pdf", ['consumption_data' =>  $query->orderBy('item_name', 'asc')->get(), 'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->stream('inventory_cosumption_pdf.pdf');
    }
    public function inventoryTransferpdf(Request $request)
    {
        // dd($request->all());
        $query = DB::table('inv_itemstocktransmstchd_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('trans_type_iss_rcv', 'TRANSIN')->where('stock_su_no_fk_to', '=', Session::get('user.su_pk_no'));
        if (isset($request->from_date) && isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                ->where(DB::raw('trunc(trans_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        } elseif (isset($request->from_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->from_date)));
        } elseif (isset($request->to_date)) {
            $query->where(DB::raw('trunc(trans_date)'), '=', date('Y-m-d', strtotime($request->to_date)));
        }
        if (isset($request->store_id)) {
            $query->where('stock_su_no_fk_to', '=', $request->store_id);
        }
        if (isset($request->item_id)) {
            $query->where('item_no_fk', '=', $request->item_id);
        }
        $print_type = "PDF";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        ///dd($query->get(),$request->all());
        $pdf = PDF::loadView("admin.store.inventory.consumption.item_transfer_record_pdf", ['consumption_data' =>  $query->orderBy('item_name', 'asc')->get(), 'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details]);
        return $pdf->stream('inventory_cosumption_pdf.pdf');
    }
}
