<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use DB;
use Illuminate\Support\Facades\Session;

class GRNController extends Controller
{

    public function __construct(){$this->middleware('auth');}
    public function phr_grnView()
    {
        $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
         from PHR_GRN_VW
        where au_entry_at >sysdate-2 and module_code = 'PHR'
        group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
        ORDER BY au_entry_at DESC
        ");
        $allSuppliers = DB::table('INV_SUPPLIER')
        ->select('*')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->get();
        // dd($grn_worklists);
        return Template::loadview("admin.store.grn.grn_work_list",compact('grn_worklists','allSuppliers'));
    }

    public function phr_search_grn(Request $request){
        $supplier_id = $request->supplier_id ? : '';
        $challan_no = $request->challan_no ? : '';

        if ($supplier_id && $challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where SUPPLIER_NO_FK = '$supplier_id' and po_no = '$challan_no' and module_code = 'PHR'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } elseif ($supplier_id && !$challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where SUPPLIER_NO_FK = '$supplier_id' and module_code = 'PHR'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } elseif (!$supplier_id && $challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where po_no = '$challan_no' and  module_code = 'PHR'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } else {
            $grn_worklists = [];
        }

    //    dd($grn_worklists);
       return Template::loadview("admin.store.grn.grn_work_list_table",compact('grn_worklists'));
    }

    public function inv_grnView()
    {
        $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
         from PHR_GRN_VW
        where au_entry_at >sysdate-2 and module_code = 'INVENTORY'
        group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
        ORDER BY au_entry_at DESC
        ");

        $allSuppliers = DB::table('INV_SUPPLIER')
        ->select('*')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->get();
        // dd($grn_worklists);
        return Template::loadview("admin.store.grn.inv_grn_work_list",compact('grn_worklists','allSuppliers'));
    }

    public function inv_search_grn(Request $request){
        $supplier_id = $request->supplier_id ? : '';
        $challan_no = $request->challan_no ? : '';

        if ($supplier_id && $challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where SUPPLIER_NO_FK = '$supplier_id' and po_no = '$challan_no' and module_code = 'INVENTORY'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } elseif ($supplier_id && !$challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where SUPPLIER_NO_FK = '$supplier_id' and module_code = 'INVENTORY'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } elseif (!$supplier_id && $challan_no) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price,sum(order_qty) as item_q,sum(purchase_price*order_qty) as total_purchase_amount
                from PHR_GRN_VW
            where po_no = '$challan_no' and  module_code = 'INVENTORY'
            group by itemreceive_no_pk,po_no,au_entry_at,supplier_name,order_qty,purchase_price
            ORDER BY au_entry_at DESC
            ");
        } else {
            $grn_worklists = [];
        }

    //    dd($grn_worklists);
       return Template::loadview("admin.store.grn.inv_grn_work_list_table",compact('grn_worklists'));
    }
}
