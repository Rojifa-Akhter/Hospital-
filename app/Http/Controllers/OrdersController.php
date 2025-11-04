<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function orderList()
    {
        //        $ecom_date = DB::table('ecom_orders')
        //            ->select('ecom_orders.au_entry_at',DB::raw('COUNT(unique(ecom_orders.user_no_fk)) as users,COUNT(ecom_orders.order_no_pk) as orders'))
        //            ->leftjoin('ecom_order_items','ecom_orders.order_no_pk','ecom_order_items.order_no_fk')
        //            ->leftJoin('wsec_user','ecom_orders.user_no_fk','wsec_user.user_no_pk')
        //            ->groupby('ecom_orders.au_entry_at')
        //            ->get();
        //        $ecommerce_date = [];
        //        foreach ($ecom_date as $dt){
        //            $ecommerce_date[date('d/m/Y',strtotime($dt->au_entry_at))][]= date('d/m/Y',strtotime($dt->au_entry_at))."_".$dt->users."_".$dt->orders;
        //        }
        //
        //
        //        $customer = DB::table('ecom_orders')
        //            ->select('ecom_orders.user_no_fk','ecom_orders.order_no_pk',DB::raw('COUNT(unique(ecom_orders.user_no_fk)) as users,COUNT(ecom_orders.order_no_pk) as orders,SUM(ecom_order_items.quantity) as product_quantity'))
        //            ->leftjoin('ecom_order_items','ecom_orders.order_no_pk','ecom_order_items.order_no_fk')
        //            ->leftJoin('wsec_user','ecom_orders.user_no_fk','wsec_user.user_no_pk')
        //            ->groupby(DB::raw("ecom_orders.user_no_fk"))
        //            ->groupby(DB::raw("ecom_orders.order_no_pk"))
        //            ->get();
        //
        //        $customer_data =[];
        //        foreach ($customer as $cus_row){
        //            $customer_data[$cus_row->user_no_fk][]= $cus_row->user_no_fk.",".$cus_row->order_no_pk.",".$cus_row->users.",".$cus_row->orders.",".$cus_row->product_quantity;
        //        }
        //
        //
        //
        //
        //        $total_orders = DB::table('ecom_orders')
        //            ->select('ecom_orders.order_no_pk','ecom_orders.user_no_fk',DB::raw('SUM(ecom_order_items.quantity) as product_quantity,SUM(ecom_order_items.product_price) as total_money'))
        //            ->leftjoin('ecom_order_items','ecom_orders.order_no_pk','ecom_order_items.order_no_fk')
        //            ->leftJoin('wsec_user','ecom_orders.user_no_fk','wsec_user.user_no_pk')
        //            ->groupby(DB::raw("ecom_orders.user_no_fk"))
        //            ->groupby(DB::raw("ecom_orders.order_no_pk"))
        //            ->get();
        //        $orders_data =[];
        //        foreach ($total_orders as $order_row){
        //            $orders_data[$order_row->order_no_pk][]= $order_row->user_no_fk."-".$order_row->product_quantity."-".$order_row->total_money;
        //        }
        //
        //        $total_products = DB::table('ecom_orders')
        //            ->select('ecom_orders.order_no_pk',DB::raw('SUM(ecom_order_items.quantity) as product_quantity,SUM(ecom_order_items.product_price) as total_money'))
        //            ->leftjoin('ecom_order_items','ecom_orders.order_no_pk','ecom_order_items.order_no_fk')
        //            ->leftJoin('wsec_user','ecom_orders.user_no_fk','wsec_user.user_no_pk')
        //            ->groupby(DB::raw("ecom_orders.order_no_pk"))
        //            ->get();
        //        $products_data =[];
        //        foreach ($total_products as $product_row){
        //            $products_data[$product_row->order_no_pk][]= $product_row->product_quantity."/".$product_row->total_money;
        //        }



        $ecommerce_data = DB::table('ecom_orders')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
            ->leftJoin('wsec_user', 'ecom_orders.user_no_fk', 'wsec_user.user_no_pk')
            //            ->where('ecom_orders.user_no_fk',$patient_id)
            ->where('ecom_order_items.au_entry_at', date('Y-m-d'))
            ->get();

        $ecom_order = [];
        foreach ($ecommerce_data as $ecom_row) {
            $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->product_name . "_" . $ecom_row->product_price . "_" . $ecom_row->address_id . "_" . date('d/m/Y', strtotime($ecom_row->au_entry_at)) . "_" . $ecom_row->quantity . "_" . $ecom_row->user_no_fk . "_" . $ecom_row->user_fullname;
        }

        $total_orders = DB::table('ecom_orders')
            ->select(DB::raw("SUM(ecom_order_items.quantity) as total_quantity"), 'ecom_orders.order_no_pk')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
            //            ->where('ecom_orders.user_no_fk',$patient_id)
            ->groupBy(DB::raw("ecom_orders.order_no_pk"))
            ->get();

        $orders_row = [];
        foreach ($total_orders as $orders_data) {
            $orders_row[$orders_data->order_no_pk] = $orders_data->total_quantity;
        }

        return Template::loadview("admin.ecommerce.orders_list", [
            'ecommerce_data' => $ecommerce_data, 'ecom_order' => $ecom_order, 'orders_row' => $orders_row
        ]);
    }

    public function orderListSearch(Request $request)
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
        $sql_cond .= ($date_from != "") ? " $clause trunc(ecom_order_items . au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $ecommerce_data = DB::select(DB::raw(" select * from  ecom_orders  left join  ecom_order_items  on  ecom_orders . order_no_pk  =  ecom_order_items . order_no_fk  left join  wsec_user  on  ecom_orders . user_no_fk  =  wsec_user . user_no_pk  $sql_cond"));
        $ecom_order = [];
        foreach ($ecommerce_data as $ecom_row) {
            $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->product_name . "_" . $ecom_row->product_price . "_" . $ecom_row->address_name . "_" . date('d/m/Y', strtotime($ecom_row->au_entry_at)) . "_" . $ecom_row->quantity . "_" . $ecom_row->user_no_fk . "_" . $ecom_row->user_fullname;
        }

        $total_orders = DB::table('ecom_orders')
            ->select(DB::raw("SUM(ecom_order_items.quantity) as total_quantity"), 'ecom_orders.order_no_pk')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
            //            ->where('ecom_orders.user_no_fk',$patient_id)
            ->groupBy(DB::raw("ecom_orders.order_no_pk"))
            ->get();

        $orders_row = [];
        foreach ($total_orders as $orders_data) {
            $orders_row[$orders_data->order_no_pk] = $orders_data->total_quantity;
        }
        return Template::loadview("admin.ecommerce.ecommerce_orders_list_data", [
            'ecommerce_data' => $ecommerce_data, 'ecom_order' => $ecom_order, 'orders_row' => $orders_row, 'date_from' => $date_from, 'date_to' => $date_to
        ]);
    }
}