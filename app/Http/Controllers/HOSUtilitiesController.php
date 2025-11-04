<?php

namespace App\Http\Controllers;

use DB;
use Cache;
use PDO;
use Session;
use Illuminate\Http\Request;
use App\Models\UomLookup as Lookup;

class HOSUtilitiesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getUOMData($uom_id)
    {
        $uom = Lookup::where('uom_no_pk', $uom_id)->first();
        return intval($uom->uom_label_desc);
    }

    public function itemAutocomplete(Request $request)
    {
        $store_id = intval($request->store_id);
        $sub_store_id = intval($request->department_from);
        $supplier_id=$request->suppiler_id;
        $minor_group_no=$request->minor_group_no;
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        $group=$request->group !="" ? 'and s.itemtype_no_fk =' . $request->group: '';
        $su_no_cond = ($group != "") ? "$group" : "";
        $su_no_cond.= ($request->store_id != "") ? " and s.mainstore_su_no_fk = '$request->store_id' $group" : "";
        $su_no_cond.= ( $su_no_cond !="" && $request->suppiler_id != "") ? " and s.supplier_pk_no = $request->suppiler_id" : "";
        $su_no_cond.= ( $su_no_cond !="" && $minor_group_no != "") ? " and s.itemtype_no_fk = $minor_group_no" : "";
            //  dd($request->suppiler_id, $su_no_cond );

        // $cacheKeyAllData = "all_item_data_cache";
        // $item_info = Cache::get($cacheKeyAllData);
        // if (!$item_info) {
        //     $result = DB::table('sysc_v1_serviceitem_vw s')
        //         ->select(
        //             's.item_no_pk',
        //             's.item_name',
        //             's.purchase_price',
        //             's.sales_price',
        //             's.item_code',
        //             's.serviceunit_no_fk',
        //             's.mainstore_su_no_fk',
        //             's.supplier_pk_no',
        //             's.serviceunit_name',
        //             's.itemtype_no_fk',
        //             's.item_type',
        //             's.uom_name',
        //             's.uom_no_fk',
        //             's.urgent_fee_amt',
        //             's.manual_item_rate_ind',
        //             's.expireable',
        //             's.dealer_sales_price',
        //             's.pr_uom_tradeprice',
        //             's.pr_uom_conversion_qty',
        //             's.pr_uom_no_fk',
        //             's.pr_uom_name',
        //             's.supplier_name',
        //             's.vat_percent',
        //             's.disc_aplicable',
        //             's.default_discount',
        //             's.generic_name',
        //             's.uom_no_fk_2nd',
        //             's.uom_no_fk_3rd',
        //             's.uom_no_fk_4th',
        //             's.uom_no_fk_2nd_conv_ratio',
        //             's.uom_no_fk_3rd_conv_ratio',
        //             's.uom_no_fk_4th_conv_ratio',
        //             's.item_uom_name_2nd',
        //             's.item_uom_name_3rd',
        //             's.item_uom_name_4th',
        //             's.re_order_level',
        //             's.model_info',
        //             's.dollar_ind',
        //             'inv.lpqty',
        //             'inv.lpd',
        //             'inv.lpp',
        //             'inv.generic_global_stock',
        //             'inv.generic_stock_store',
        //             'inv.pr_uom_conversion_qty as lpp_conversion_qty',
        //             'inv.stock_store',
        //             'inv.con_qty7days',
        //             'inv.con_qty30days',
        //             'inv.generic_stock',
        //             'inv.stock_qty',
        //             's.pr_box_qty'
        //         )
        //         ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', '=', 's.item_no_pk')
        //         ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //         ->where('s.status', 1)
        //         ->orderBy('s.item_name')
        //         ->get();

        //     Cache::put($cacheKeyAllData, $result, 3600);
        //     $item_info = $result;
        // }
        // $filtered_item_info = collect($item_info)->filter(function ($item) use ($keyword, $su_no_cond,$store_id, $supplier_id) {
        
        //     $matchesKeyword = stripos($item->item_name, $keyword) !== false ||
        //                     stripos($item->item_code, $keyword) !== false ||
        //                     stripos($item->generic_name, $keyword) !== false;
        //     $matchesStoreCondition = true;
        //         if ($su_no_cond) {            
        //         if (strpos($su_no_cond, 's.mainstore_su_no_fk') !== false && $item->mainstore_su_no_fk != $store_id) {
        //             $matchesStoreCondition = false;
        //         }
        //         if (strpos($su_no_cond, 's.supplier_pk_no') !== false && $item->supplier_pk_no != $supplier_id) {
        //             $matchesStoreCondition = false;
        //         }
        //     }
        //     return $matchesKeyword && $matchesStoreCondition;
        // });
        // $filtered_item_info = $filtered_item_info->values()->all();
        // dd($filtered_item_info);
          
        // dd($filtered_item_info);
        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                's.model_info',
                's.dollar_ind',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.pr_uom_conversion_qty as lpp_conversion_qty',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
                's.pr_box_qty',
            )
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $su_no_cond"))
            ->orderBy("s.item_name")
             ->get();
            
            // dd($query);
        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {

                DB::beginTransaction();
                
                $hospital = Session::get('user.ses_hospital_no_pk');
                $main_store_stock = 0;
                $sub_store_stock = 0;
        
        
        
                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 500);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();
                    
        
                $stmt = $pdo->prepare("begin :sub_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':sub_store_stock', $sub_store_stock, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 500);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $sub_store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);               
                $stmt->execute();
              
                $main_stock = intval($main_store_stock);
                $sub_stock = intval($sub_store_stock);
                $global_stock_qty=DB::table('inv_itemstockmst')->select(DB::raw('sum(balance_qty) as global_stock_qty'))->where('item_no_fk',$value->item_no_pk)->first();
                // dd($sub_stock, $sub_store_id , $value->item_no_pk);
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;



                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => $value->item_name,
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'global_stock_qty'          => !empty( $global_stock_qty) ?$global_stock_qty->global_stock_qty:0,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'model_info'                => $value->model_info,
                    'dollar_ind'                => $value->dollar_ind,
                    'lpqty'                     => $value->lpqty,
                    'lpp_conversion_qty'        => $value->lpp_conversion_qty,
                    'lpd'                       => $value->lpd !=""? date('d/m/Y' , strtotime($value->lpd)):'',
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($sub_stock) && $sub_stock != null ? $sub_stock : 0,//isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($main_stock) && $main_stock != null ? $main_stock : 0,//isset($value->stock_qty) ? $value->stock_qty : 0,
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'pr_box_qty'            => isset($value->pr_box_qty) ? $value->pr_box_qty : 'N/A',
                );
            }
        }
        // dd($item_info);
        return $item_info;
    }
    public function itemAutocompleteGatepass(Request $request)
    {
        //dd($request->store_id);
        // dd($patient_type);
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);
       
        $store_id = intval($request->store_id);
        $itemtype = $request->item_type;
        $sub_store_id = intval($request->department_from);
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        if ($itemtype != "") {
            $item_type_arr = explode(",", $itemtype);
            foreach ($item_type_arr as $itype) {
                $item_type .= "'" . $itype . "',";
            }
            $itemtypes = rtrim($item_type, ", ");
        }
        $item_type_cond = ($itemtype != "") ? " and s.item_type in($itemtypes)" : "";
        $su_no_cond = ($request->store_id != "") ? " and s.mainstore_su_no_fk = '$request->store_id'" : "";
 
        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                's.model_info',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            )
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $su_no_cond $item_type_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {

                DB::beginTransaction();
                
                $hospital = Session::get('user.ses_hospital_no_pk');
                $main_store_stock = 0;
                $sub_store_stock = 0;
        
        
        
                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 12);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();
                    
        

                $stmt = $pdo->prepare("begin :sub_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':sub_store_stock', $sub_store_stock, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 12);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $sub_store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();

                $main_stock = intval($main_store_stock);
                $sub_stock = intval($sub_store_stock);

                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;



                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => $value->item_name,
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'model_info'                => $value->model_info,
                    'lpqty'                     => $value->lpqty,
                    'lpd'                       => $value->lpd !=""? date('d/m/Y' , strtotime($value->lpd)):'',
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($sub_stock) && $sub_stock != null ? $sub_stock : 0,//isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($main_stock) && $main_stock != null ? $main_stock : 0,//isset($value->stock_qty) ? $value->stock_qty : 0,
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                );
            }
        }
    
        return $item_info;
    }
    public function itemAutocompleteStockWise(Request $request)
    {

        // dd($patient_type);
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);


        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";

        $su_no_cond = ($request->store_id != "") ? " and s.stock_su_no_fk = '$request->store_id'" : "";
        $result  = DB::table('stock_v0_ledger_vw s')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%') $su_no_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;



                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => htmlspecialchars(ucfirst($value->item_name), ENT_QUOTES),
                    'generic_name'              => '',
                    'item_code'                 => '',
                    'supplier_name'             => '',
                    'current_stock'             => $value->current_stock,
                    'store_name'                => $value->store_name,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                  => $value->uom_no_fk,
                    'stock_su_no_fk'             => $value->stock_su_no_fk,
                    'purchase_price'             => $value->purchase_price,
                    'sales_price'                => $value->sales_price,

                );
            }
        }
        return $item_info;
    }


    public function itemAutocompleteStoreSupplier(Request $request)
    { 
        $asset_location = DB::table("sysc_room")
                                ->select('room_no_pk','room_code','room_name')
                                ->where('store_location_ind',1)
                                ->orWhere('open_location_ind',1)
                                ->orWhere('asset_location_ind',1)
                                ->get();

        $room_arr = [];

        foreach($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
      
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        $supplier_id=$request->supplier_id;
        $store_id=$request->store_id;
        $store_ind=$request->store_ind;
        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        // $sql_cond = ($request->store_id != "" && $request->store_ind==1) ? " and inv.store_su_no_fk = '$request->store_id '" : "";
        $sql_cond = ($request->store_id != "" && $request->store_ind == '') ? " and s.mainstore_su_no_fk = '$request->store_id '" : "";
        $sql_cond.= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";


        // $cacheKeyAllData = "all_item_data_cache";
        // $item_info = Cache::get($cacheKeyAllData);
        // if (!$item_info) {
        //     $result = DB::table('sysc_v1_serviceitem_vw s')
        //         ->select(
        //             's.item_no_pk',
        //             's.item_name',
        //             's.purchase_price',
        //             's.sales_price',
        //             's.item_code',
        //             's.serviceunit_no_fk',
        //             's.mainstore_su_no_fk',
        //             's.supplier_pk_no',
        //             's.serviceunit_name',
        //             's.itemtype_no_fk',
        //             's.item_type',
        //             's.uom_name',
        //             's.uom_no_fk',
        //             's.urgent_fee_amt',
        //             's.manual_item_rate_ind',
        //             's.expireable',
        //             's.dealer_sales_price',
        //             's.pr_uom_tradeprice',
        //             's.pr_uom_conversion_qty',
        //             's.pr_uom_no_fk',
        //             's.pr_uom_name',
        //             's.supplier_name',
        //             's.vat_percent',
        //             's.disc_aplicable',
        //             's.default_discount',
        //             's.generic_name',
        //             's.uom_no_fk_2nd',
        //             's.uom_no_fk_3rd',
        //             's.uom_no_fk_4th',
        //             's.uom_no_fk_2nd_conv_ratio',
        //             's.uom_no_fk_3rd_conv_ratio',
        //             's.uom_no_fk_4th_conv_ratio',
        //             's.item_uom_name_2nd',
        //             's.item_uom_name_3rd',
        //             's.item_uom_name_4th',
        //             's.re_order_level',
        //             's.model_info',
        //             's.dollar_ind',
        //             'inv.lpqty',
        //             'inv.lpd',
        //             'inv.lpp',
        //             'inv.generic_global_stock',
        //             'inv.generic_stock_store',
        //             'inv.pr_uom_conversion_qty as lpp_conversion_qty',
        //             'inv.stock_store',
        //             'inv.con_qty7days',
        //             'inv.con_qty30days',
        //             'inv.generic_stock',
        //             'inv.stock_qty',
        //             's.pr_box_qty'
        //         )
        //         ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', '=', 's.item_no_pk')
        //         ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //         ->where('s.status', 1)
        //         ->orderBy('s.item_name')
        //         ->get();
        //     Cache::put($cacheKeyAllData, $result, 3600);
        //     $item_info = $result;
        // }
        // $filtered_item_info = collect($item_info)->filter(function ($item) use ($keyword, $sql_cond,$store_id, $supplier_id,$store_ind) {
        //     $matchesKeyword = stripos($item->item_name, $keyword) !== false ||
        //                     stripos($item->item_code, $keyword) !== false ||
        //                     stripos($item->generic_name, $keyword) !== false;
        //     $matchesStoreCondition = true;
        //     if ($sql_cond) {
        //         if (strpos($sql_cond, 's.mainstore_su_no_fk') !== false && $item->mainstore_su_no_fk != $store_id  && $store_ind == '') {
        //             $matchesStoreCondition = false;
        //         }
        //         if (strpos($sql_cond, 's.supplier_pk_no') !== false && $item->supplier_pk_no != $supplier_id) {
        //             $matchesStoreCondition = false;
        //         }
        //     }

        //     return $matchesKeyword && $matchesStoreCondition;
        // });
        // $filtered_item_info = $filtered_item_info->values()->all();

        // dd( $filtered_item_info);


        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            )
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $sql_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $internal_batchs=
                 DB::table('inv_batchwise_stock_vw')	
                ->select(DB::raw('sum(item_qty) as item_qty'),DB::raw('sum(purchase_price) as purchase_price'),DB::raw('count(internal_batch_no_uq) as batch_count'),'internal_batch_no_uq','item_no_fk','expiry_date','batch_no')	
                ->where('stock_su_no_fk',$request->store_id)
                ->where('item_no_fk',$value->item_no_pk)	
                ->groupBy('internal_batch_no_uq','item_no_fk','expiry_date','batch_no')	
                ->orderBy('internal_batch_no_uq','desc')	
                ->get()	
                ->toArray();
                $store_wise_stock=DB::table('INV_ITEMSTOCKMST')->select('balance_qty as current_stock')->where('item_no_fk',$value->item_no_pk)->where('stock_su_no_fk', $request->store_id)->first();
                // $request->store_id != "" && $request->store_ind
                // dd($store_wise_stock,$value->item_no_pk,$request->store_id);
                $internal_batch=[];
                if (!empty($internal_batchs)) {
                   foreach ($internal_batchs as  $data) {
                    if ($data->item_qty > 0) {
                        $item_price= DB::table('phr_itemreceivedtl')->select('pr_uom_tradeprice')->where('internal_batch_no_uq',$data->internal_batch_no_uq)->first();
                        $internal_batch[]=array(
                            'item_qty' =>$data->item_qty,
                            'internal_batch_no_uq' =>$data->internal_batch_no_uq,
                            'item_no_fk' =>$data->item_no_fk,
                            'expiry_date' =>$data->expiry_date,
                            'batch_no' =>$data->batch_no,
                            'purchase_price' =>  $item_price->pr_uom_tradeprice ?? 0 , 
                        );
                    }
                   
                   }
                }

                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => ucfirst($value->item_name),
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'lpqty'                     => $value->lpqty,
                    'lpd'                       => $value->lpd,
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 =>  $request->store_id != "" && $request->store_ind==1 && !empty($store_wise_stock) ? $store_wise_stock->current_stock : (isset($value->stock_qty) ?  $value->stock_qty :0),
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'room_location'             => $room_arr,
                    'internal_batch'             => $internal_batch,
                );
            }
        }
        return $item_info;
    }
    public function itemAutocompleteStoreSupplierCafe(Request $request)
    { 
        // $asset_location = DB::table("sysc_room")
        //                         ->select('room_no_pk','room_code','room_name')
        //                         ->where('store_location_ind',1)
        //                         ->orWhere('open_location_ind',1)
        //                         ->orWhere('asset_location_ind',1)
        //                         ->get();

        $room_arr = [];

        // foreach($asset_location as $location) {
        //     $room_arr[] = [
        //         'room_no_pk' => $location->room_no_pk,
        //         'room_code' => $location->room_code,
        //         'room_name' => $location->room_name
        //     ];
        // }
      
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
        $supplier_id=$request->supplier_id;
        $store_id=$request->store_id;
        $store_ind=$request->store_ind;
      
        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        // $sql_cond = ($request->store_id != "" && $request->store_ind==1) ? " and inv.store_su_no_fk = '$request->store_id '" : "";
        $sql_cond = ( $request->store_fnb_ind == '') ? " and s.fnb_store_ind = 1" : "and stockMst.stock_su_no_fk = '$request->store_id '";
        $sql_cond.= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";
        if (Session::get('user.ses_hospital_code')=="UNICO" && $request->stock_type_data =="CAFE") {
            $sql_cond.= ( $request->item_type != '') ? " and s.item_type in ($request->item_type)" : "";
        }
        // dd($request->stock_type_data);
       
       


        $results  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            );
            if ($request->store_fnb_ind != '') {
                $results->leftJoin('inv_itemstockmst stockMst', 'stockMst.item_no_fk', 's.item_no_pk');
            }
            $result=$results->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $sql_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $internal_batchs=
                 DB::table('inv_batchwise_stock_vw')	
                ->select(DB::raw('sum(item_qty) as item_qty'),DB::raw('sum(purchase_price) as purchase_price'),DB::raw('count(internal_batch_no_uq) as batch_count'),'internal_batch_no_uq','item_no_fk','expiry_date','batch_no','sales_price')	
                ->where('stock_su_no_fk',$request->store_id)
                ->where('item_no_fk',$value->item_no_pk)	
                ->groupBy('internal_batch_no_uq','item_no_fk','expiry_date','batch_no','sales_price')	
                ->orderBy('internal_batch_no_uq','desc')	
                ->get()	
                ->toArray();
                $store_wise_stock=DB::table('INV_ITEMSTOCKMST')->select('balance_qty as current_stock')->where('item_no_fk',$value->item_no_pk)->where('stock_su_no_fk', $request->store_id)->first();
                // $request->store_id != "" && $request->store_ind
                // dd($store_wise_stock,$value->item_no_pk,$request->store_id);
                $internal_batch=[];
                if (!empty($internal_batchs)) {
                   foreach ($internal_batchs as  $data) {
                    if ($data->item_qty > 0) {
                        $item_price= DB::table('phr_itemreceivedtl')->select('pr_uom_tradeprice')->where('internal_batch_no_uq',$data->internal_batch_no_uq)->first();
                        $internal_batch[]=array(
                            'item_qty' =>$data->item_qty,
                            'internal_batch_no_uq' =>$data->internal_batch_no_uq,
                            'item_no_fk' =>$data->item_no_fk,
                            'expiry_date' =>$data->expiry_date,
                            'batch_no' =>$data->batch_no,
                            'purchase_price' =>  $item_price->pr_uom_tradeprice ?? 0 ,                            
                            'sales_price' =>$data->sales_price,
                        );
                    }
                   
                   }
                }

                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => ucfirst($value->item_name),
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'lpqty'                     => $value->lpqty,
                    'lpd'                       => $value->lpd,
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 =>  $request->store_id != "" && $request->store_ind==1 && !empty($store_wise_stock) ? $store_wise_stock->current_stock : (isset($value->stock_qty) ?  $value->stock_qty :0),
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'room_location'             => $room_arr,
                    'internal_batch'             => $internal_batch,
                );
            }
        }
        return $item_info;
    }
    public function itemAutocompleteStoreAddOut(Request $request)
    { 
        $asset_location = DB::table("sysc_room")
                                ->select('room_no_pk','room_code','room_name')
                                ->where('store_location_ind',1)
                                ->orWhere('open_location_ind',1)
                                ->orWhere('asset_location_ind',1)
                                ->get();

        $room_arr = [];

        foreach($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
      
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";

        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        $sql_cond =''; 
    
        // condition remove for shuvo vai and nazia apu requierment. item search from stock ledger. which item is already stock
        // if ($request->store_ind =='ADJNEG') {
            $sql_cond .= $request->store_id != "" ? " and stockMst.stock_su_no_fk = '$request->store_id '" : "";
        // }
        
        // $sql_cond = ($request->store_id != "" && $request->store_ind == '') ? " and s.mainstore_su_no_fk = '$request->store_id '" : "";
        $sql_cond.= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";
        $results  = DB::table('sysc_v1_serviceitem_vw s');
        if ($request->store_ind =='ADJPOS') {
            $results->distinct('s.item_no_pk'); 
        }
        $results->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',               
        );
            // if ($request->store_ind =='ADJNEG') {
            $results->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->leftJoin('inv_itemstockmst stockMst', 'stockMst.item_no_fk', 's.item_no_pk');
            // }
           
            $results->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $sql_cond"));
            // if ($request->store_ind =='ADJNEG') {
                $results->addSelect('inv.lpqty'); 
                $results->addSelect('inv.lpd'); 
                $results->addSelect('inv.lpp'); 
                $results->addSelect('inv.generic_global_stock'); 
                $results->addSelect('inv.generic_stock_store'); 
                $results->addSelect('inv.stock_store'); 
                $results->addSelect('inv.con_qty7days'); 
                $results->addSelect('inv.con_qty30days'); 
                $results->addSelect('inv.generic_stock'); 
                $results->addSelect('stockMst.balance_qty as stock_qty'); 
            // }           
            
            $result= $results->orderBy("s.item_name")->get();

        $item_info = [];
        $item_info_stock =[];
        // dd( $result);
        $pdo = DB::getPdo();

        // if (!empty($result)) {

        //     foreach ($result as $value) {
        //         $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
        //         $internal_batchs= DB::table('inv_batchwise_stock_vw')	
        //         ->select(DB::raw('sum(item_qty) as item_qty'),DB::raw('sum(purchase_price) as purchase_price'),DB::raw('count(internal_batch_no_uq) as batch_count'),'internal_batch_no_uq','item_no_fk','expiry_date','batch_no')	
        //         ->where('stock_su_no_fk',$request->store_id)
        //         ->where('item_no_fk',$value->item_no_pk)	
        //         ->groupBy('internal_batch_no_uq','item_no_fk','expiry_date','batch_no')	
        //         ->orderBy('internal_batch_no_uq','desc')	
        //         ->get()
	
        //         ->toArray();
        //         $store_wise_stock=DB::table('stock_ledger_vw')->select('current_stock')->where('item_no_fk',$value->item_no_pk)->where('stock_su_no_fk', $request->store_id)->first();
        //         // $request->store_id != "" && $request->store_ind
        //         // dd($store_wise_stock,$value->item_no_pk,$request->store_id);
        //         $internal_batch=[];
        //         if (!empty($internal_batchs)) {
        //            foreach ($internal_batchs as  $data) {
        //             if ($data->item_qty > 0) {
        //                 $item_price= DB::table('phr_itemreceivedtl')->select('pr_uom_tradeprice')->where('internal_batch_no_uq',$data->internal_batch_no_uq)->first();
        //                 $internal_batch[]=array(
        //                     'item_qty' =>$data->item_qty,
        //                     'internal_batch_no_uq' =>$data->internal_batch_no_uq,
        //                     'item_no_fk' =>$data->item_no_fk,
        //                     'expiry_date' =>$data->expiry_date,
        //                     'batch_no' =>$data->batch_no,
        //                     'purchase_price' =>  $item_price->pr_uom_tradeprice ?? 0 , 
        //                 );
        //             }
                   
        //            }
        //         }

        //         $item_info[] = array(
        //             'item_id'                   => $value->item_no_pk,
        //             'item_name'                 => ucfirst($value->item_name),
        //             'purchase_price'            => $value->purchase_price,
        //             'item_rate'                 => $sales_price,
        //             'item_code'                 => $value->item_code,
        //             'item_dept_id'              => $value->serviceunit_no_fk,
        //             'item_dept'                 => $value->serviceunit_name,
        //             'item_type'                 => $value->itemtype_no_fk,
        //             'itemtype_code'             => $value->item_type,
        //             'uom_name'                  => $value->uom_name,
        //             'uom_no_fk'                 => $value->uom_no_fk,
        //             'pr_uom_name'               => $value->pr_uom_name,
        //             'pr_uom_no_fk'              => $value->pr_uom_no_fk,
        //             'urgent_fee_amt'            => $value->urgent_fee_amt,
        //             'manual_item_rate_ind'      => $value->manual_item_rate_ind,
        //             'expireable'                => $value->expireable,
        //             'current_stock'             => 'N/A', //$value->current_stock,
        //             'dealer_sales_price'        => $value->dealer_sales_price,
        //             'stock_status_text'         => 'N/A', //$value->stock_status_text,
        //             'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
        //             'item_sales_uom'            =>  $value->uom_no_fk,
        //             'supplier_name'             => $value->supplier_name,
        //             'vat_percent'               => $value->vat_percent,
        //             'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
        //             'generic_name'              => $value->generic_name,
        //             "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
        //             "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
        //             "uom_no_fk_4th"             => $value->uom_no_fk_4th,
        //             "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
        //             "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
        //             "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
        //             'item_uom_name_2nd'         => $value->item_uom_name_2nd,
        //             'item_uom_name_3rd'         => $value->item_uom_name_3rd,
        //             'item_uom_name_4th'         => $value->item_uom_name_4th,
                    
        //             're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
        //             'room_location'             => $room_arr,
        //             'internal_batch'             => $internal_batch,
        //         );

               
        //         if ($request->store_ind =='ADJNEG') {
                   
        //                 $item_info['lpqty'] = $value->lpqty;
        //                 $item_info['lpd'] = $value->lpd;
        //                 $item_info['lpp'] = isset($value->lpp) ? $value->lpp : 0;
        //                 $item_info['generic_global_stock'] = isset($value->generic_global_stock) ? $value->generic_global_stock : 0;
        //                 $item_info['generic_stock_store'] = isset($value->generic_stock_store) ? $value->generic_stock_store : 0;
        //                 $item_info['stock_store'] = isset($value->stock_store) ? $value->stock_store : 0;
        //                 $item_info['con_qty7days'] = isset($value->con_qty7days) ? $value->con_qty7days : 0;
        //                 $item_info['con_qty30days'] = isset($value->con_qty30days) ? $value->con_qty30days : 0;
        //                 $item_info['generic_stock'] = isset($value->generic_stock) ? $value->generic_stock : 0;
        //                 $item_info['stock_qty'] = $request->store_id != "" && $request->store_ind==1 && !empty($store_wise_stock) ? $store_wise_stock->current_stock : (isset($value->stock_qty) ? $value->stock_qty :0);
                   
        //         }  
                
        //     }
        // }


        if (!empty($result)) {
            foreach ($result as $value) {
                // Initialize sales price, defaulting to 0 if empty
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
        
                // Fetch batchwise stock details for the current item
                $internal_batchs = DB::table('inv_batchwise_stock_vw')
                    ->select(
                        DB::raw('sum(item_qty) as item_qty'),
                        DB::raw('sum(purchase_price) as purchase_price'),
                        DB::raw('count(internal_batch_no_uq) as batch_count'),
                        'internal_batch_no_uq', 'item_no_fk', 'expiry_date', 'batch_no','sales_price'
                    )
                    ->where('stock_su_no_fk', $request->store_id)
                    ->where('item_no_fk', $value->item_no_pk)
                    ->groupBy('internal_batch_no_uq', 'item_no_fk', 'expiry_date', 'batch_no','sales_price')
                    ->orderBy('internal_batch_no_uq', 'desc')
                    ->get()->toArray();
        
                // Fetch store-wise stock data for the item
                $store_wise_stock = DB::table('stock_ledger_vw')
                    ->select('current_stock')
                    ->where('item_no_fk', $value->item_no_pk)
                    ->where('stock_su_no_fk', $request->store_id)
                    ->first();
        
                $internal_batch = [];
                if (!empty($internal_batchs)) {
                    // Loop through the batchwise stock details
                    foreach ($internal_batchs as $data) {
                        if ($data->item_qty > 0) {
                            // Fetch item price for the batch
                            $item_price = DB::table('phr_itemreceivedtl')
                                ->select('pr_uom_tradeprice')
                                ->where('internal_batch_no_uq', $data->internal_batch_no_uq)
                                ->first();
                            
                            // Store batch info
                            $internal_batch[] = array(
                                'item_qty' => $data->item_qty,
                                'internal_batch_no_uq' => $data->internal_batch_no_uq,
                                'item_no_fk' => $data->item_no_fk,
                                'expiry_date' => $data->expiry_date,
                                'batch_no' => $data->batch_no,
                                'purchase_price' => $item_price->pr_uom_tradeprice ?? 0,
                                'sales_price' => $data->sales_price,
                            );
                        }
                    }
                }
        
                // Add item details to the item_info array
                $item_info[] = array(
                    'item_id' => $value->item_no_pk,
                    'item_name' => ucfirst($value->item_name),
                    'purchase_price' => $value->purchase_price,
                    'item_rate' => $sales_price,
                    'item_code' => $value->item_code,
                    'item_dept_id' => $value->serviceunit_no_fk,
                    'item_dept' => $value->serviceunit_name,
                    'item_type' => $value->itemtype_no_fk,
                    'itemtype_code' => $value->item_type,
                    'uom_name' => $value->uom_name,
                    'uom_no_fk' => $value->uom_no_fk,
                    'pr_uom_name' => $value->pr_uom_name,
                    'pr_uom_no_fk' => $value->pr_uom_no_fk,
                    'urgent_fee_amt' => $value->urgent_fee_amt,
                    'manual_item_rate_ind' => $value->manual_item_rate_ind,
                    'expireable' => $value->expireable,
                    'current_stock' => 'N/A', // Default value, can be updated later
                    'dealer_sales_price' => $value->dealer_sales_price,
                    'stock_status_text' => 'N/A', // Default value
                    'pr_uom_conversion_qty' => $value->pr_uom_conversion_qty,
                    'item_sales_uom' => $value->uom_no_fk,
                    'supplier_name' => $value->supplier_name,
                    'vat_percent' => $value->vat_percent,
                    'disc_aplicable' => $value->disc_aplicable ?? 0,
                    'generic_name' => $value->generic_name,
                    'uom_no_fk_2nd' => $value->uom_no_fk_2nd,
                    'uom_no_fk_3rd' => $value->uom_no_fk_3rd,
                    'uom_no_fk_4th' => $value->uom_no_fk_4th,
                    'uom_no_fk_2nd_conv_ratio' => $value->uom_no_fk_2nd_conv_ratio,
                    'uom_no_fk_3rd_conv_ratio' => $value->uom_no_fk_3rd_conv_ratio,
                    'uom_no_fk_4th_conv_ratio' => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd' => $value->item_uom_name_2nd,
                    'item_uom_name_3rd' => $value->item_uom_name_3rd,
                    'item_uom_name_4th' => $value->item_uom_name_4th,
                    're_order_level' => $value->re_order_level ?? 0,
                    'room_location' => $room_arr, // Ensure $room_arr is defined
                    'internal_batch' => $internal_batch,
                );
        
                // Additional fields for 'ADJNEG' condition
                if ($request->store_ind == 'ADJNEG') {
                    $item_info[count($item_info) - 1]['lpqty'] = $value->lpqty;
                    $item_info[count($item_info) - 1]['lpd'] = $value->lpd;
                    $item_info[count($item_info) - 1]['lpp'] = $value->lpp ?? 0;
                    $item_info[count($item_info) - 1]['generic_global_stock'] = $value->generic_global_stock ?? 0;
                    $item_info[count($item_info) - 1]['generic_stock_store'] = $value->generic_stock_store ?? 0;
                    $item_info[count($item_info) - 1]['stock_store'] = $value->stock_store ?? 0;
                    $item_info[count($item_info) - 1]['con_qty7days'] = $value->con_qty7days ?? 0;
                    $item_info[count($item_info) - 1]['con_qty30days'] = $value->con_qty30days ?? 0;
                    $item_info[count($item_info) - 1]['generic_stock'] = $value->generic_stock ?? 0;
                    $item_info[count($item_info) - 1]['stock_qty'] = $store_wise_stock->current_stock ?? 0;
                }
            }
        }
        
        // dd($item_info );
        return  $item_info;
    }
    public function itemAutocompleteStoreToStore(Request $request)
    { 
        $asset_location = DB::table("sysc_room")
                                ->select('room_no_pk','room_code','room_name')
                                ->where('store_location_ind',1)
                                ->orWhere('open_location_ind',1)
                                ->orWhere('asset_location_ind',1)
                                ->get();

        $room_arr = [];

        foreach($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
      
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";

        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        $sql_cond = ($request->store_id != "") ? " and inv.stock_su_no_fk = '$request->store_id '" : "";
        $sql_cond .= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";
        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                // 'inv.lpqty',
                // 'inv.lpd',
                // 'inv.lpp',
                // 'inv.generic_global_stock',
                // 'inv.generic_stock_store',
                // 'inv.stock_store',
                // 'inv.con_qty7days',
                // 'inv.con_qty30days',
                // 'inv.generic_stock',
                'inv.current_stock as stock_qty',
            )
            ->leftJoin('stock_ledger_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $sql_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $internal_batchs= DB::table('inv_batchwise_stock_vw')->select(DB::raw('sum(item_qty) as item_qty'), DB::raw('sum(purchase_price) as purchase_price'),'internal_batch_no_uq','item_no_fk','expiry_date','batch_no','sales_price')->where('stock_su_no_fk',$request->store_id)->where('item_no_fk',$value->item_no_pk)->groupBy('internal_batch_no_uq','item_no_fk','expiry_date','batch_no','sales_price')->orderBy('internal_batch_no_uq','desc')->get()->toArray();
                // dd($internal_batch);
                $internal_batch=[];
                if (!empty($internal_batchs)) {
                   foreach ($internal_batchs as  $data) {
                    if ($data->item_qty > 0) {
                                $item_price = DB::table('phr_itemreceivedtl')
                                ->select('pr_uom_tradeprice')
                                ->where('internal_batch_no_uq', $data->internal_batch_no_uq)
                                ->first();
                        $internal_batch[]=array(
                            'item_qty' =>$data->item_qty,
                            'internal_batch_no_uq' =>$data->internal_batch_no_uq,
                            'item_no_fk' =>$data->item_no_fk,
                            'expiry_date' =>$data->expiry_date,
                            'batch_no' =>$data->batch_no,
                            'purchase_price' => $item_price->pr_uom_tradeprice ?? 0,
                            'sales_price' => $data->sales_price,
                        );
                    }
                   
                   }
                }

                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => ucfirst($value->item_name),
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    // 'lpqty'                     => $value->lpqty,
                    // 'lpd'                       => $value->lpd,
                    // 'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    // 'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    // 'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    // 'stock_store'               => isset($value->stock_store) ? $value->stock_store : 0,
                    // 'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    // 'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    // 'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0,
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'room_location'             => $room_arr,
                    'internal_batch'             => $internal_batch,
                );
            }
        }
        return $item_info;
    }
    public function itemAutocompleteSubStoreSupplier(Request $request)
    {       
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);

        $asset_location = DB::table("sysc_room")
                                ->select('room_no_pk','room_code','room_name')
                                ->where('store_location_ind',1)
                                ->orWhere('open_location_ind',1)
                                ->orWhere('asset_location_ind',1)
                                ->get();

        $room_arr = [];

        foreach($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
      
        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";
// dd($request->store_id);
        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        // $sql_cond = ($request->store_id != "") ? " and s.mainstore_su_no_fk = '$request->store_id '" : "";
        $sql_cond = ($request->store_id != "") ? " and stock.stock_su_no_fk = '$request->store_id '" : "";
        $sql_cond .= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";
        $result  = DB::table('inv_itemstockmst stock')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            )
            ->leftJoin('sysc_v1_serviceitem_vw s', 'stock.item_no_fk', 's.item_no_pk')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')            
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%') $sql_cond"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;
                $internal_batchs= $all_batch=DB::table('inv_batchwise_stock_vw')->select(DB::raw('sum(item_qty) as item_qty'),'internal_batch_no_uq','item_no_fk','expiry_date','batch_no')->where('stock_su_no_fk',$request->store_id)->where('item_no_fk',$value->item_no_pk)->groupBy('internal_batch_no_uq','item_no_fk','expiry_date','batch_no')->orderBy('internal_batch_no_uq','desc')->get()->toArray();
                // dd($internal_batch);
                $internal_batch=[];
                if (!empty($internal_batchs)) {
                   foreach ($internal_batchs as  $data) {
                    if ($data->item_qty > 0) {
                        $internal_batch[]=array(
                            'item_qty' =>$data->item_qty,
                            'internal_batch_no_uq' =>$data->internal_batch_no_uq,
                            'item_no_fk' =>$data->item_no_fk,
                            'expiry_date' =>$data->expiry_date,
                            'batch_no' =>$data->batch_no,
                        );
                    }
                   
                   }
                }

                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => ucfirst($value->item_name),
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'lpqty'                     => $value->lpqty,
                    'lpd'                       => $value->lpd,
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0,
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'room_location'             => $room_arr,
                    'internal_batch'             => $internal_batch,
                );
            }
        }
        return $item_info;
    }


    public function swhowAllitemAutocomplete(Request $request)
    {

        // dd($patient_type);
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);


        $keyword = strtoupper($request->search_data);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";

        //$su_no_cond = ''; //($request->store_id != "") ? " and s.serviceunit_no_fk = '$request->store_id '" : "";
        //$sql_cond = ($request->store_id != "") ? " and s.mainstore_su_no_fk = '$request->store_id '" : "";
        //$sql_cond .= ($request->supplier_id != "") ? " and s.supplier_pk_no = '$request->supplier_id '" : "";
        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                's.uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.expireable',
                's.dealer_sales_price',
                's.pr_uom_tradeprice',
                's.pr_uom_conversion_qty',
                's.pr_uom_no_fk',
                's.pr_uom_name',
                's.supplier_name',
                's.vat_percent',
                's.disc_aplicable',
                's.default_discount',
                's.generic_name',
                's.uom_no_fk_2nd',
                's.uom_no_fk_3rd',
                's.uom_no_fk_4th',
                's.uom_no_fk_2nd_conv_ratio',
                's.uom_no_fk_3rd_conv_ratio',
                's.uom_no_fk_4th_conv_ratio',
                's.item_uom_name_2nd',
                's.item_uom_name_3rd',
                's.item_uom_name_4th',
                's.re_order_level',
                'inv.lpqty',
                'inv.lpd',
                'inv.lpp',
                'inv.generic_global_stock',
                'inv.generic_stock_store',
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.stock_qty',
            )
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.item_name) like '%$keyword%' or upper(s.item_code) like '%$keyword%' or upper(s.generic_name) like '%$keyword%')"))
            ->orderBy("s.item_name")
            ->get();

        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {
                $sales_price = $value->sales_price != "" ? $value->sales_price : 0;



                $item_info[] = array(
                    'item_id'                   => $value->item_no_pk,
                    'item_name'                 => htmlspecialchars(ucfirst($value->item_name), ENT_QUOTES),
                    'purchase_price'            => $value->purchase_price,
                    'item_rate'                 => $sales_price,
                    'item_code'                 => $value->item_code,
                    'item_dept_id'              => $value->serviceunit_no_fk,
                    'item_dept'                 => $value->serviceunit_name,
                    'item_type'                 => $value->itemtype_no_fk,
                    'itemtype_code'             => $value->item_type,
                    'uom_name'                  => $value->uom_name,
                    'uom_no_fk'                 => $value->uom_no_fk,
                    'pr_uom_name'               => $value->pr_uom_name,
                    'pr_uom_no_fk'              => $value->pr_uom_no_fk,
                    'urgent_fee_amt'            => $value->urgent_fee_amt,
                    'manual_item_rate_ind'      => $value->manual_item_rate_ind,
                    'expireable'                => $value->expireable,
                    'current_stock'             => 'N/A', //$value->current_stock,
                    'dealer_sales_price'        => $value->dealer_sales_price,
                    'stock_status_text'         => 'N/A', //$value->stock_status_text,
                    'pr_uom_conversion_qty'     => $value->pr_uom_conversion_qty,
                    'item_sales_uom'            =>  $value->uom_no_fk,
                    'supplier_name'             => $value->supplier_name,
                    'vat_percent'               => $value->vat_percent,
                    'disc_aplicable'            => $value->disc_aplicable != null ? $value->disc_aplicable : 0,
                    'generic_name'              => $value->generic_name,
                    "uom_no_fk_2nd"             => $value->uom_no_fk_2nd,
                    "uom_no_fk_3rd"             => $value->uom_no_fk_3rd,
                    "uom_no_fk_4th"             => $value->uom_no_fk_4th,
                    "uom_no_fk_2nd_conv_ratio"  => $value->uom_no_fk_2nd_conv_ratio,
                    "uom_no_fk_3rd_conv_ratio"  => $value->uom_no_fk_3rd_conv_ratio,
                    "uom_no_fk_4th_conv_ratio"  => $value->uom_no_fk_4th_conv_ratio,
                    'item_uom_name_2nd'         => $value->item_uom_name_2nd,
                    'item_uom_name_3rd'         => $value->item_uom_name_3rd,
                    'item_uom_name_4th'         => $value->item_uom_name_4th,
                    'lpqty'                     => $value->lpqty,
                    'lpd'                       => $value->lpd,
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0,
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                );
            }
        }
        return $item_info;
    }


    public function genericWiseItemList(Request $request)
    {
        $generic_id =  $request->generic_no_pk;
        $supplier_id =  $request->supplier_id;
     
        $item_lists = DB::table('sysc_v1_serviceitem_vw s')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where("generic_no_fk",  $generic_id);
        if ( $supplier_id !='') {
            $item_lists->where("supplier_pk_no",  $supplier_id);
        }

        $item_list= $item_lists->get();
        $html = '<select class="form-control form-control-sm select2" ><option>Select One</option>';
        // onchange="setHiddenValue(this)"
        if (!empty($item_list)) {
            foreach ($item_list as $item) {
                $html .= "<option value='" . $item->item_no_pk . "' data-uom_no_fk='" . $item->uom_no_fk . "'
                data-item_uom='" . $item->uom_name . "'
                data-item_name='" . $item->item_name . "'
                data-last_pp='" . $item->lpp . "'
                data-global_stock='" . $item->generic_global_stock . "'
                data-global_stock_store='" . $item->generic_stock_store . "'
                data-stock_store='" . $item->stock_store . "'
                data-cons_qty='" . $item->con_qty7days . "'
                data-cons_last_month='" . $item->con_qty30days . "'
                data-stock_quantity='" . $item->stock_qty . "'
                data-rol='" . $item->re_order_level . "'
                data-generic_stock='" . $item->generic_stock . "'

                >" . $item->item_name . "</option>";
            }
        }
        $html .= '</select>';
        return $html;
    }
    public function getEventList(Request $request)
    {

        // dd($patient_type);
        // $result =  DB::executeFunction('fnc_gettest', ['patient_no_pk' => $patient_no], PDO::PARAM_INT);


        $keyword = strtoupper($request->search_data);
        $lookup_code = strtoupper($request->lookup_code);
        $item_type = $itemtypes = $itemtypevoid = $item_type_void = "";

        $lookup_cond = ($request->lookup_code != "") ? " and s.lookup_code = '$request->lookup_code'" : "";
        $result  = DB::table('sysc_lookupdata_vw s')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->whereRaw(DB::raw("(upper(s.lookupdata_name) like '%$keyword%') $lookup_cond"))
            ->orderBy("s.lookupdata_name")
            ->get();


        return $result;
    }


    public function getItemWiseBatch(Request $request)
    {
        $item_batch_list = DB::table('inv_trn_chd_vw')
            ->where('item_no_fk', $request->item_id)
            ->where('stock_su_no_fk', $request->stock_su_no_fk)
            ->get();
        $html = '<option value="">Select One</option>';
        foreach ($item_batch_list as $row) {
            $expiry_date =  $row->expiry_date != "" ? date('d-m-Y', strtotime($row->expiry_date)) : '';
            $html .= '<option value="' . $row->item_no_fk . '" data-expdata="' . $expiry_date . '">' . $row->batch_no . '</option>';
        }
        return    $html;
    }

    
}