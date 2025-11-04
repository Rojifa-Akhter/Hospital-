<?php

namespace App\Http\Controllers;

use App;
use PDO;
use \PDF;
use View;
use DateTime;
use App\Models\Item;
use App\Models\Supplier;
use App\Traits\ItemData;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Traits\DatatablesLoader;
use App\Traits\HospitalStoreData;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderMaster;
use App\Models\UomLookup as Lookup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Exception;
use Carbon\Carbon;

class StoreController extends Controller
{
    use DatatablesLoader, LookupData, ItemData, UtilitiesTrait, HospitalStoreData;

    private $message;

    public function new_receive_by_chalan()
    {
        // echo Session::get('user.ses_hospital_no_pk');
        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $stores = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('HOSPITAL_STORE_IND', '=', 1)
                ->get();
        } else {
            $stores = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('HOSPITAL_STORE_IND', '=', 1)
                ->where('main_store_ind', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->get();
        }


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('*')
            ->get();

        return Template::loadView("admin.store.inventory.new_receive_by_chalan", ['stores' => $stores, 'allSuppliers' => $allSuppliers]);
    }
    public function new_receive_by_chalan_vat()
    {
        // echo Session::get('user.ses_hospital_no_pk');
        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $stores = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('HOSPITAL_STORE_IND', '=', 1)
                ->get();
        } else {
            $stores = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where('HOSPITAL_STORE_IND', '=', 1)
                ->where('main_store_ind', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->get();
        }


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('*')
            ->get();

        return Template::loadView("admin.store.inventory.new_receive_by_chalan_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers]);
    }
    public function pharmacy_new_receive_by_chalan()
    {
        // echo Session::get('user.ses_hospital_no_pk');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('*')
            ->get();

        return Template::loadView("admin.store.new_receive_by_chalan", ['stores' => $stores, 'allSuppliers' => $allSuppliers]);
    }
    public function pharmacy_new_receive_by_chalan_vat()
    {
        // echo Session::get('user.ses_hospital_no_pk');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('*')
            ->get();

        return Template::loadView("admin.store.new_receive_by_chalan_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers]);
    }
    public function pharmacy_new_receive_by_chalan_cafe_optical_vat()
    {
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('CAFETERIA_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('*')
            ->get();

        return Template::loadView("admin.store.new_receive_by_chalan_cafe_optical_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers]);
    }

    public function getModuleCode(Request $request)
    {
        $module_code = DB::table('sysc_module')->where('service_point_su_no_fk', $request->store_id)->where('phr_grn_ind', 1)->where('status', 1)->get();
        return response()->json($module_code);
    }
    public function new_receive_by_chalan_edit($id)
    {

        // echo Session::get('user.ses_hospital_no_pk');
        $purchase_order_id = $id;
        $item_list = DB::select("SELECT i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,rec.received_quantity, rec.PURCHASE_PRICE,i.expireable,rec.sales_price,rec.pr_uom_tradeprice, rec.pr_uom_conversion_qty, rec.pr_uom_no_fk,rec.pr_uom_qty,rec.pr_uom_short, rec.freeitem_qty , rec.freeitem_uom, rec.uom_no_fk as sort_uom_no_fk ,rec.vat_percent_itm,rec.vat_amount_itm,rec.discount_percent_itm,rec.discount_amount_itm FROM phr_itemreceive_item_vw rec
                LEFT JOIN SYSC_SERVICEITEM_VW i ON rec.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE rec.ITEMRECEIVE_NO_PK = $id order by i.item_name asc");

        $item_mst = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $id)->first();
        // dd($item_list);
        // $exp_date_data = DB::table("phr_itemreceivedtl")->select("item_qty", "batch_no", "expiry_date", "item_no_fk", "trade_price")->where("itemreceive_no_fk", $id)->get();

        $exp_date_data = DB::table("phr_itemreceivedtl t")
            ->select(DB::raw('CASE WHEN t.item_qty > 0 THEN t.item_qty / t.pr_uom_conversion_qty ELSE 0 END  as item_qty'), "t.batch_no", "t.expiry_date", "t.item_no_fk", "t.trade_price", "t.pr_uom_no_fk", "t.pr_uom_conversion_qty")
            ->where("t.itemreceive_no_fk", $id)->get();
        // dd($id);
        $exp_date = [];
        $notExp_date = [];
        // dd($exp_date_data);
        foreach ($exp_date_data as  $value) {
            $exp_date[] = $value;
            $notExp_date[$value->item_no_fk] = $value;
        }
        // dd($exp_date_data);
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $receive_chalan = DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
            ->where('ITEMRECEIVE_NO_PK', $id)
            ->orderBy('itemreceive_no_pk', 'desc')
            ->first();

        return Template::loadView("admin.store.inventory.new_receive_by_chalan", ['stores' => $stores, 'allSuppliers' => $allSuppliers, 'item_list' => $item_list, 'receive_chalan' => $receive_chalan, 'exp_date' => $exp_date, 'item_mst' => $item_mst, 'notExp_date' => $notExp_date]);
    }
    public function new_receive_by_chalan_edit_inv_vat($id)
    {

        // echo Session::get('user.ses_hospital_no_pk');
        $purchase_order_id = $id;
        $item_list = DB::select("SELECT i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,rec.received_quantity, rec.PURCHASE_PRICE,i.expireable,rec.sales_price,rec.pr_uom_tradeprice, rec.pr_uom_conversion_qty, rec.pr_uom_no_fk,rec.pr_uom_qty,rec.pr_uom_short, rec.freeitem_qty , rec.freeitem_uom, rec.uom_no_fk as sort_uom_no_fk ,rec.vat_percent_itm,rec.vat_amount_itm,rec.discount_percent_itm,rec.discount_amount_itm FROM phr_itemreceive_item_vw rec
                LEFT JOIN SYSC_SERVICEITEM_VW i ON rec.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE rec.ITEMRECEIVE_NO_PK = $id order by i.item_name asc");

        $item_mst = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $id)->first();
        // dd($item_list);
        // $exp_date_data = DB::table("phr_itemreceivedtl")->select("item_qty", "batch_no", "expiry_date", "item_no_fk", "trade_price")->where("itemreceive_no_fk", $id)->get();

        $exp_date_data = DB::table("phr_itemreceivedtl t")
            ->select(DB::raw('CASE WHEN t.item_qty > 0 THEN t.item_qty / t.pr_uom_conversion_qty ELSE 0 END  as item_qty'), "t.batch_no", "t.expiry_date", "t.item_no_fk", "t.trade_price", "t.pr_uom_no_fk", "t.pr_uom_conversion_qty")
            ->where("t.itemreceive_no_fk", $id)->get();
        // dd($id);
        $exp_date = [];
        $notExp_date = [];
        // dd($exp_date_data);
        foreach ($exp_date_data as  $value) {
            $exp_date[] = $value;
            $notExp_date[$value->item_no_fk] = $value;
        }
        // dd($exp_date_data);
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $receive_chalan = DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
            ->where('ITEMRECEIVE_NO_PK', $id)
            ->orderBy('itemreceive_no_pk', 'desc')
            ->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();
        return Template::loadView("admin.store.inventory.new_receive_by_chalan_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers, 'item_list' => $item_list, 'receive_chalan' => $receive_chalan, 'exp_date' => $exp_date, 'item_mst' => $item_mst, 'notExp_date' => $notExp_date, 'return_adj_amt' => $return_adj_amt]);
    }
    public function pharmacy_new_receive_by_chalan_edit($id)
    {

        // echo Session::get('user.ses_hospital_no_pk');
        $purchase_order_id = $id;
        $item_list = DB::select("SELECT i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,rec.received_quantity, rec.PURCHASE_PRICE,i.expireable,rec.sales_price,rec.pr_uom_tradeprice, rec.pr_uom_conversion_qty, rec.pr_uom_no_fk,rec.pr_uom_qty,rec.pr_uom_short, rec.freeitem_qty , rec.freeitem_uom, rec.uom_no_fk as sort_uom_no_fk FROM phr_itemreceive_item_vw rec
                LEFT JOIN SYSC_SERVICEITEM_VW i ON rec.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE rec.ITEMRECEIVE_NO_PK = $id order by i.item_name asc");

        $item_mst = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $id)->first();
        // dd($item_list);
        // $exp_date_data = DB::table("phr_itemreceivedtl")->select("item_qty", "batch_no", "expiry_date", "item_no_fk", "trade_price")->where("itemreceive_no_fk", $id)->get();

        $exp_date_data = DB::table("phr_itemreceivedtl t")
            ->select(DB::raw('CASE WHEN t.item_qty > 0 THEN t.item_qty / t.pr_uom_conversion_qty ELSE 0 END  as item_qty'), "t.batch_no", "t.expiry_date", "t.item_no_fk", "t.trade_price", "t.pr_uom_no_fk", "t.pr_uom_conversion_qty")
            ->where("t.itemreceive_no_fk", $id)->get();
        // dd($item_list);
        $exp_date = [];
        $notExp_date = [];
        // dd($exp_date_data);
        foreach ($exp_date_data as  $value) {
            $exp_date[] = $value;
            $notExp_date[$value->item_no_fk] = $value;
        }
        // dd($exp_date_data);
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $receive_chalan = DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
            ->where('itemreceive_no_pk', $id)
            ->orderBy('itemreceive_no_pk', 'desc')
            ->first();

        $adj_amt = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(adj_amount) as adj_amount'))->where('itemreceive_no_fk', $id)->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();

        return Template::loadView("admin.store.new_receive_by_chalan", ['stores' => $stores, 'allSuppliers' => $allSuppliers, 'item_list' => $item_list, 'receive_chalan' => $receive_chalan, 'exp_date' => $exp_date, 'item_mst' => $item_mst, 'notExp_date' => $notExp_date, 'adj_amt' => $adj_amt, 'return_adj_amt' => $return_adj_amt]);
    }

    public function pharmacy_new_receive_by_chalan_edit_vat($id)
    {

        // echo Session::get('user.ses_hospital_no_pk');
        $purchase_order_id = $id;
        $item_list = DB::select("SELECT i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,rec.received_quantity, rec.PURCHASE_PRICE,i.expireable,rec.sales_price,rec.pr_uom_tradeprice, rec.pr_uom_conversion_qty, rec.pr_uom_no_fk,rec.pr_uom_qty,rec.pr_uom_short,rec.vat_percent_itm, rec.freeitem_qty,rec.vat_amount_itm ,rec.discount_percent_itm, rec.freeitem_uom, rec.uom_no_fk as sort_uom_no_fk,rec.discount_amount_itm FROM phr_itemreceive_item_vw rec
                LEFT JOIN SYSC_SERVICEITEM_VW i ON rec.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE rec.ITEMRECEIVE_NO_PK = $id order by i.item_name asc");
        //dd($item_list);

        $item_mst = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $id)->first();
        // dd($item_list);
        // $exp_date_data = DB::table("phr_itemreceivedtl")->select("item_qty", "batch_no", "expiry_date", "item_no_fk", "trade_price")->where("itemreceive_no_fk", $id)->get();

        $exp_date_data = DB::table("phr_itemreceivedtl t")
            ->select(DB::raw('CASE WHEN t.item_qty > 0 THEN t.item_qty / t.pr_uom_conversion_qty ELSE 0 END  as item_qty'), "t.batch_no", "t.expiry_date", "t.item_no_fk", "t.trade_price", "t.pr_uom_no_fk", "t.pr_uom_conversion_qty")
            ->where("t.itemreceive_no_fk", $id)->get();
        // dd($id);
        $exp_date = [];
        $notExp_date = [];
        // dd($exp_date_data);
        foreach ($exp_date_data as  $value) {
            $exp_date[] = $value;
            $notExp_date[$value->item_no_fk] = $value;
        }
        // dd($exp_date_data);
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $receive_chalan = DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
            ->where('ITEMRECEIVE_NO_PK', $id)
            ->orderBy('itemreceive_no_pk', 'desc')
            ->first();

        return Template::loadView("admin.store.new_receive_by_chalan_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers, 'item_list' => $item_list, 'receive_chalan' => $receive_chalan, 'exp_date' => $exp_date, 'item_mst' => $item_mst, 'notExp_date' => $notExp_date]);
    }
    public function pharmacy_new_receive_by_chalan_cafe_optical_edit_vat($id)
    {

        // echo Session::get('user.ses_hospital_no_pk');
        $purchase_order_id = $id;
        $item_list = DB::select("SELECT i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,rec.received_quantity, rec.PURCHASE_PRICE,i.expireable,rec.sales_price,rec.pr_uom_tradeprice, rec.pr_uom_conversion_qty, rec.pr_uom_no_fk,rec.pr_uom_qty,rec.pr_uom_short,rec.vat_percent_itm, rec.freeitem_qty,rec.vat_amount_itm ,rec.discount_percent_itm, rec.freeitem_uom, rec.uom_no_fk as sort_uom_no_fk,rec.discount_amount_itm FROM phr_itemreceive_item_vw rec
                LEFT JOIN SYSC_SERVICEITEM_VW i ON rec.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE rec.ITEMRECEIVE_NO_PK = $id order by i.item_name asc");
        //dd($item_list);

        $item_mst = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $id)->first();
        // dd($item_list);
        // $exp_date_data = DB::table("phr_itemreceivedtl")->select("item_qty", "batch_no", "expiry_date", "item_no_fk", "trade_price")->where("itemreceive_no_fk", $id)->get();

        $exp_date_data = DB::table("phr_itemreceivedtl t")
            ->select(DB::raw('CASE WHEN t.item_qty > 0 THEN t.item_qty / t.pr_uom_conversion_qty ELSE 0 END  as item_qty'), "t.batch_no", "t.expiry_date", "t.item_no_fk", "t.trade_price", "t.pr_uom_no_fk", "t.pr_uom_conversion_qty")
            ->where("t.itemreceive_no_fk", $id)->get();
        // dd($id);
        $exp_date = [];
        $notExp_date = [];
        // dd($exp_date_data);
        foreach ($exp_date_data as  $value) {
            $exp_date[] = $value;
            $notExp_date[$value->item_no_fk] = $value;
        }
        // dd($exp_date_data);
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $receive_chalan = DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
            ->where('ITEMRECEIVE_NO_PK', $id)
            ->orderBy('itemreceive_no_pk', 'desc')
            ->first();
        // dd($receive_chalan->module_no_fk);
        $module_code = DB::table('SYSC_MODULE')
            ->where('SERVICE_POINT_SU_NO_FK', $receive_chalan->store_su_no_fk)
            ->where('MODULE_NO_PK', $receive_chalan->module_no_fk)
            ->where('PHR_GRN_IND', 1)
            ->where('status', 1)
            ->select('module_code')
            ->get();

        return Template::loadView("admin.store.new_receive_by_chalan_cafe_optical_vat", ['stores' => $stores, 'allSuppliers' => $allSuppliers, 'item_list' => $item_list, 'receive_chalan' => $receive_chalan, 'exp_date' => $exp_date, 'item_mst' => $item_mst, 'notExp_date' => $notExp_date, 'module_code' => $module_code]);
    }

    public function showBatchPopup($id)
    {
        $pId_qty = explode('_', $id);
        $item_id = $pId_qty[0];
        $qty = $pId_qty[1];
        $item_prices = $pId_qty[2];
        $item_uom_no = $pId_qty[3];
        $item_conversion = $pId_qty[4];
        // dd($id);
        $item_name = Item::select("ITEM_NAME")->where("ITEM_NO_PK", $item_id)->first();
        return Template::loadview("admin.store.show_item_batch", ['item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'item_prices' => $item_prices, 'item_uom_no' => $item_uom_no, 'item_conversion' => $item_conversion]);
    }

    public function itemBatchEditPopup($id)
    {
        // $pId_qty = explode('_', $id);
        // $item_id = $pId_qty[0];
        // $qty = $pId_qty[1];
        // return Template::loadview("admin.store.show_item_batch", ['item_id' => $item_id, 'qty' => $qty]);

        $arry_rep = str_replace('_', ',', $id);
        $id_exp = explode('^', $arry_rep);
        $exp = explode('|', $id_exp[1]);
        $item_id_qty = explode(':', $id_exp[0]);
        // dd( $exp);
        $item_id = $item_id_qty[1];
        $sales_qty = $item_id_qty[0];
        $explo_item_rate = explode(',', $exp[0]);
        $item_prices = $explo_item_rate[3];
        $item_uom_no = $explo_item_rate[4];
        $item_conversion = $explo_item_rate[5];
        // dd($id);

        $item_name = Item::select("ITEM_NAME")->where("ITEM_NO_PK", $item_id)->first();
        $batch = DB::table('stock_ledger_expirey_vw')->select('batch_no', 'expiry_date', 'recieve_qty')->where('item_no_fk', $item_id)->get();

        return Template::loadview("admin.store.show_item_batch", ['exp' => $exp, 'item_id' => $item_id, 'batch' => $batch, 'qty' => $sales_qty, 'item_name' => $item_name, 'item_prices' => $item_prices, 'item_uom_no' => $item_uom_no, 'item_conversion' => $item_conversion]);
    }

    public function saveItemExpireDate(Request $request)
    {

        $batch_dtails = $request->batch_name;
        $explode_batch = explode('^', $batch_dtails);
        //  $replace=str_replace("^",",",$explode_batch);
        // $count=count($explode_batch);
        // dd($count);
        // $i='';
        // $data='';
        // for ($i=0; $i < $count; $i++) {
        //  $data += (int)$explode_batch[$i];
        // }
        $arry_filter = array_filter($explode_batch, function ($value) {
            return !is_null($value) && $value !== '';
        });

        // dd( $arry_filter);
        return json_encode($arry_filter);
    }

    protected function autocomplete_iteminfo(Request $request)
    {
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";

        return $this->getItemListAutoComplete($request->search_data, $item_type);
    }

    protected function inventory_autocomplete_iteminfo(Request $request)
    {

        return $this->getItemListAutoComplete($request->search_data, "INV");

    }

    protected function pharmacy_autocomplete_iteminfo(Request $request)
    {
        return $this->getItemListAutoComplete($request->search_data, "MED");
    }

    public function new_receive_by_item()
    {
        return Template::loadView("admin.store.new_receive_by_item");
    }

    public function pharmacy_stock_ledger()
    {
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('PHARMACY_IND', '=', 1)
            // ->where('hospital_store_ind', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = []; // $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.store.stock_ledger", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }
    public function stockTransferReceive()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $transferData = DB::table('phr_itemadjmentdtl')
            ->select('phr_itemadjmentdtl.*', 'sysc_serviceitem.item_name', 'sysc_serviceitem_uom.uom_code as uom_name', 'from_store.serviceunit_name as from_store', 'to_store.serviceunit_name as to_store', 'wsec_user.user_fullname')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentdtl.uom')
            ->join('sysc_serviceunit from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->join('sysc_serviceunit to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->whereNotIn('phr_itemadjmentdtl.ITEMADJMENTDTLL_NO_PK', function ($query) {
                $query->select('ITEMADJMENTDTLL_NO_FK')
                    ->from('PHR_ITEMADJMENTRCVDTL');
            })
            ->orderBy('phr_itemadjmentdtl.itemadjmentdtll_no_pk', 'desc')
            ->get();
        // dd($transferData);
        $trans_type = DB::table('phr_itemadjmentrcvdtl')->distinct('ITEMADJMENT_TYPE')->select('ITEMADJMENT_TYPE')->get();



        return Template::loadview("admin.store.stock_transfer_receive", [
            'store' => $store,
            'allSuppliers' => $allSuppliers,
            'transferData' => $transferData,
            'trans_type' => $trans_type
        ]);
    }
    public function stockTransferReceiveList(Request $request)
    {

        $stores = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('PHARMACY_IND', '=', 1)
            // ->where('hospital_store_ind', '=', 1)
            ->where(function ($query) {
                $query->where('sub_store_ind', 1)
                    ->orWhere('main_store_ind', 1);
            })
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferDatas = DB::table('phr_itemadjmentdtl')
            ->select('phr_itemadjmentdtl.*', 'sysc_serviceitem.item_name', 'sysc_serviceitem_uom.uom_code as uom_name', 'from_store.serviceunit_name as from_store', 'to_store.serviceunit_name as to_store', 'wsec_user.user_fullname')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentdtl.uom')
            ->join('sysc_serviceunit from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->join('sysc_serviceunit to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->whereNotIn('phr_itemadjmentdtl.ITEMADJMENTDTLL_NO_PK', function ($query) {
                $query->select('ITEMADJMENTDTLL_NO_FK')
                    ->from('PHR_ITEMADJMENTRCVDTL');
            });

        if ($request->type == 2) {
            $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
            $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
            if ($request->from_store != "") {
                $transferDatas->where('phr_itemadjmentdtl.from_store_no_fk', $request->from_store);
            }
            if ($request->to_store != "") {
                $transferDatas->where('phr_itemadjmentdtl.store_su_no_fk', $request->to_store);
            }
            if ($request->trans_type != "") {
                $transferDatas->where('phr_itemadjmentdtl.itemadjment_type', $request->trans_type);
            }
            if ($request->trans_id != "") {
                $transferDatas->where('phr_itemadjmentdtl.itemadjment_no_fk', $request->trans_id);
            }
            if ($request->date_from != "" && $request->date_to) {
                $transferDatas->whereDate('phr_itemadjmentdtl.au_entry_at', '>=', $date_from)
                    ->whereDate('phr_itemadjmentdtl.au_entry_at', '<=', $date_to);
            }

            // $transferDatas->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
            // $transferDatas->addSelect('phr_itemadjmentrcvdtl.au_entry_at'); // Add the new column
            // $transferDatas->groupBy('phr_itemadjmentrcvdtl.au_entry_at');
        }
        $transferData = $transferDatas->orderBy('phr_itemadjmentdtl.itemadjmentdtll_no_pk', 'desc')
            ->get();
        // dd($transferData);

        return Template::loadview("admin.store.stock_transfer_receive_list", [
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,
            'transferData' => $transferData
        ]);
    }
    public function stockTransferReceivePendingList()
    {
        $stores = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('PHARMACY_IND', '=', 1)
            // ->where('hospital_store_ind', '=', 1)
            ->where(function ($query) {
                $query->where('sub_store_ind', 1)
                    ->orWhere('main_store_ind', 1);
            })
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferDataPending =  DB::table('phr_itemadjmentrcvdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty) as receive_qty'),
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname'
            )
            // ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentrcvdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemadjmentrcvdtl.au_entry_by')
            ->groupBy(
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname'
            )
            ->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '<', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)'))
            ->orderBy('phr_itemadjmentrcvdtl.item_no_fk', 'desc') // Use a column in the SELECT clause
            ->get();

        // DB::table('phr_itemadjmentrcvdtl')
        //     ->select(DB::raw('sum(phr_itemadjmentrcvdtl.receive_qty)'),'phr_itemadjmentrcvdtl.item_no_fk','phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk','phr_itemadjmentrcvdtl.itemadjment_no_fk','phr_itemadjmentrcvdtl.uom','phr_itemadjmentrcvdtl.from_store_no_fk','phr_itemadjmentrcvdtl.store_su_no_fk','phr_itemadjmentrcvdtl.itemadjment_type','phr_itemadjmentrcvdtl.internal_batch_no_uq','phr_itemadjmentrcvdtl.batch_no','phr_itemadjmentrcvdtl.expiry_date','phr_itemadjmentrcvdtl.item_qty','phr_itemadjmentrcvdtl.purchase_price','phr_itemadjmentrcvdtl.cost_price','phr_itemadjmentrcvdtl.au_entry_at','sysc_serviceitem_vw.item_name','sysc_serviceitem_vw.uom_name','from_store.serviceunit_name as from_store','to_store.serviceunit_name as to_store','wsec_user.user_fullname')
        //     ->join('sysc_serviceitem_vw','sysc_serviceitem_vw.item_no_pk','phr_itemadjmentrcvdtl.item_no_fk')
        //     ->join('sysc_serviceunit from_store','from_store.serviceunit_no_pk','phr_itemadjmentrcvdtl.from_store_no_fk')
        //     ->join('sysc_serviceunit to_store','to_store.serviceunit_no_pk','phr_itemadjmentrcvdtl.store_su_no_fk')
        //     ->join('wsec_user','wsec_user.user_no_pk','phr_itemadjmentrcvdtl.au_entry_by')
        //     // ->whereNotIn('phr_itemadjmentrcvdtl.ITEMADJMENTDTLL_NO_PK', function($query) {
        //     //     $query->select('ITEMADJMENTDTLL_NO_FK')
        //     //         ->from('PHR_ITEMADJMENTRCVDTL');
        //     // })
        //     ->groupBy('phr_itemadjmentrcvdtl.item_no_fk','phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk','phr_itemadjmentrcvdtl.itemadjment_no_fk','phr_itemadjmentrcvdtl.uom','phr_itemadjmentrcvdtl.from_store_no_fk','phr_itemadjmentrcvdtl.store_su_no_fk','phr_itemadjmentrcvdtl.itemadjment_type','phr_itemadjmentrcvdtl.internal_batch_no_uq','phr_itemadjmentrcvdtl.batch_no','phr_itemadjmentrcvdtl.expiry_date','phr_itemadjmentrcvdtl.item_qty','phr_itemadjmentrcvdtl.purchase_price','phr_itemadjmentrcvdtl.cost_price','phr_itemadjmentrcvdtl.au_entry_at','sysc_serviceitem_vw.item_name','sysc_serviceitem_vw.uom_name','from_store.serviceunit_name as from_store','to_store.serviceunit_name as to_store','wsec_user.user_fullname')
        //     ->orderBy('phr_itemadjmentrcvdtl.itemadjmentrcvdtl_no_pk','desc')
        //     ->get();
        // dd($transferDataPending);

        return Template::loadview("admin.store.stock_transfer_receive_pending_list", [
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,
            'transferDataPending' => $transferDataPending
        ]);
    }
    public function stockTransferReceiveFullReceivedList(Request $request)
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        // $allSuppliers = DB::table('INV_SUPPLIER')
        //     ->select('supplier_no_pk', 'supplier_name')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query =  DB::table('phr_itemadjmentrcvdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty) as receive_qty'),
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
            )
            // ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentrcvdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemadjmentrcvdtl.au_entry_by')
            ->groupBy(
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname'
            );
        // dd($request->type,$twoMonthsAgo,now()->format('Y-m-d'));
        if ($request->type == 1) {
            $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $twoMonthsAgo)
                ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', now()->format('Y-m-d'))
                ->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)'))
                ->orderBy('phr_itemadjmentrcvdtl.item_no_fk', 'desc'); // Use a column in the SELECT clause
        } else {
            $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
            $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
            if ($request->from_store != "") {
                $query->where('from_store_no_fk', $request->from_store);
            }
            if ($request->to_store != "") {
                $query->where('store_su_no_fk', $request->to_store);
            }
            if ($request->trans_type != "") {
                $query->where('itemadjment_type', $request->trans_type);
            }
            if ($request->trans_id != "") {
                $query->where('itemadjment_no_fk', $request->trans_id);
            }
            if ($request->date_from != "" && $request->date_to) {
                $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $date_from)
                    ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', $date_to);
            }

            $query->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
            $query->addSelect('phr_itemadjmentrcvdtl.au_entry_at'); // Add the new column
            $query->groupBy('phr_itemadjmentrcvdtl.au_entry_at');
            // dd($request->all());
        }



        $transferDataPending = $query->get();


        return Template::loadview("admin.store.stock_transfer_receive_full_received_list", [
            'store' => $store,
            'transferDataPending' => $transferDataPending,
            'type' => $request->type
        ]);
    }
    public function stockTransferReceiveFullReceivedPdf(Request $request)
    {
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query =  DB::table('phr_itemadjmentrcvdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty) as receive_qty'),
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
            )
            // ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentrcvdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemadjmentrcvdtl.au_entry_by')
            ->groupBy(
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname'
            );
        // dd($request->pdfType);
        if ($request->pdfType == 1) {
            $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $twoMonthsAgo)
                ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', now()->format('Y-m-d'))
                ->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)'))
                ->orderBy('phr_itemadjmentrcvdtl.item_no_fk', 'desc'); // Use a column in the SELECT clause
        } else {

            $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
            $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

            if ($request->from_store != "") {
                $query->where('from_store_no_fk', $request->from_store);
            }
            if ($request->to_store != "") {
                $query->where('store_su_no_fk', $request->to_store);
            }
            if ($request->trans_type != "") {
                $query->where('itemadjment_type', $request->trans_type);
            }
            if ($request->trans_id != "") {
                $query->where('itemadjment_no_fk', $request->trans_id);
            }
            if ($request->date_from != "" && $request->date_to) {
                $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $date_from)
                    ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', $date_to);
            }

            $query->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
            $query->addSelect('phr_itemadjmentrcvdtl.au_entry_at'); // Add the new column
            $query->groupBy('phr_itemadjmentrcvdtl.au_entry_at');
        }

        // dd($query->get());

        $transferDataPending = $query->get();


        return view("admin.store.stock_transfer_receive_full_received_pdf", [
            'transferDataPending' => $transferDataPending,
            'type' => $request->pdfType
        ]);
    }
    public function stockTransferReportPdf(Request $request)
    {
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query =   DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(NVL(phr_itemadjmentrcvdtl.receive_qty,0)) AS receive_qty'),
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'phr_itemadjmentdtl.remarks',
                'from_store.serviceunit_name AS from_store',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->leftJoin('sysc_serviceunit AS from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->leftJoin('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'phr_itemadjmentdtl.remarks',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc');




        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        if ($request->from_store != "") {
            $query->where('phr_itemadjmentdtl.from_store_no_fk', $request->from_store);
        }
        if ($request->to_store != "") {
            $query->where('phr_itemadjmentdtl.store_su_no_fk', $request->to_store);
        }
        if ($request->trans_type != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_type', $request->trans_type);
        }
        if ($request->trans_id != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_no_fk', $request->trans_id);
        }
        if ($request->date_from != "" && $request->date_to != "") {
            $query->whereDate('phr_itemadjmentdtl.au_entry_at', '>=', $date_from)
                ->whereDate('phr_itemadjmentdtl.au_entry_at', '<=', $date_to);
        }
        //    dd($request->trans_type, $query->get(), $request->all());
        // $query->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
        // $query->addSelect('phr_itemadjmentdtl.au_entry_at'); // Add the new column
        // $query->groupBy('phr_itemadjmentrcvdtl.au_entry_at');


        // dd($query->get());

        $transferDataPending = $query->get();


        return view("admin.store.stock_transfer_report_pdf", [
            'transferDataPending' => $transferDataPending,
            'type' => $request->pdfType
        ]);
    }
    public function supplierReturnReportPdf(Request $request)
    {
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');

        $query = DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                DB::raw('NVL(SUM(phr_expire_medicine_return.total_amount),0) AS total_return_amount'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                'inv_supplier.supplier_name',
            )

            ->leftJoin('phr_expire_medicine_return', function ($join) {
                $join->on('phr_expire_medicine_return.stocktrans_no_pk', '=', 'phr_itemadjmentdtl.itemadjment_no_fk')
                    ->on('phr_expire_medicine_return.item_no_fk', '=', 'phr_itemadjmentdtl.item_no_fk');
            })

            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', 'phr_expire_medicine_return.supplier_no_fk')
            ->leftJoin('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->whereIn('phr_itemadjmentdtl.itemadjment_type', ['SUPRTN', 'SUPRTNRCV'])
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                'inv_supplier.supplier_name',
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc');

        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        if ($request->to_store != "") {
            $query->where('phr_itemadjmentdtl.store_su_no_fk', $request->to_store);
        }
        if ($request->supplier != "") {
            $query->where('phr_expire_medicine_return.supplier_no_fk', $request->supplier);
        }
        if ($request->trans_type != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_type', $request->trans_type);
        }
        if ($request->trans_id != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_no_fk', $request->trans_id);
        }
        if ($request->date_from != "" && $request->date_to) {
            $query->whereDate('phr_itemadjmentdtl.au_entry_at', '>=', $date_from)
                ->whereDate('phr_itemadjmentdtl.au_entry_at', '<=', $date_to);
        }

        $transferDataPending = $query->get();


        return view("admin.store.supplier_return_report_pdf", [
            'transferDataPending' => $transferDataPending,
            'type' => $request->pdfType
        ]);
    }

    public function receiveItemFromTransfer(Request $request)
    {

        try {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $in_au_entry_session = 'transfer receive';
            $null = '';

            $toDate = date('Y-m-d');
            if (!empty($request->item_id)) {
                for ($i = 0; $i < count($request->item_id); $i++) {
                    $item_id = $request->item_id[$i];
                    $itemadjmentdtll_no_fk = $request->itemadjmentdtll_no_fk[$i];
                    $itemadjment_no_fk = $request->itemadjment_no_fk[$i];
                    $uom_no = $request->uom_no[$i];
                    $from_store_no = $request->from_store_no[$i];
                    $to_store_no = $request->to_store_no[$i];
                    $itemadjment_type = $request->itemadjment_type[$i];
                    $internal_batch_no_uq = $request->internal_batch_no_uq[$i];
                    $batch_no = $request->batch_no[$i];
                    $expiry_date = $request->expiry_date[$i];
                    $receive_qty = $request->receive_qty[$i];
                    $transfer_qty = $request->transfer_qty[$i];
                    $purchase_price = $request->purchase_price[$i];
                    $cost_price = $request->cost_price[$i];
                    $entry_sl = $i + 1;

                    $pdo = DB::getPdo();
                    $out_itemtrans_uid = '';
                    $receive_items = $pdo->prepare("begin pkg_v1_inventory_all.PRC_V1_STOCKADJUSTMENT_rec(
                :in_to_store_su_no_fk,
                :in_from_store_su_no_fk,
                :in_transtype,
                :in_adjreason,
                :in_remarks,
                :in_transdate,
                :in_itemadjment_no_fk,
                :in_itemadjmentdtll_no_pk,
                :in_a_item_no_fk,
                :in_item_batch_fk,
                :in_item_expiry_dt,
                :in_a_item_qty,
                :in_rec_item_qty,
                :in_a_item_uom,
                :in_a_item_price,
                :in_a_entry_serial_dtl,
                :in_internal_batch_no_uq,
                :in_cost_price,
                :in_itmremarks,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_no_fk,
                :out_itemtrans_uid
            ); end;");

                    $receive_items->bindparam('in_to_store_su_no_fk', $to_store_no);
                    $receive_items->bindparam('in_from_store_su_no_fk', $from_store_no);
                    $receive_items->bindparam('in_transtype', $itemadjment_type);
                    $receive_items->bindparam('in_adjreason', $null);
                    $receive_items->bindparam('in_remarks', $null);
                    $receive_items->bindparam('in_transdate', $toDate);
                    $receive_items->bindparam('in_itemadjment_no_fk', $itemadjment_no_fk);
                    $receive_items->bindparam('in_itemadjmentdtll_no_pk', $itemadjmentdtll_no_fk);
                    $receive_items->bindparam('in_a_item_no_fk', $item_id);
                    $receive_items->bindparam('in_item_batch_fk', $batch_no);
                    $receive_items->bindparam('in_item_expiry_dt', $expiry_date);
                    $receive_items->bindparam('in_a_item_qty', $transfer_qty);
                    $receive_items->bindparam('in_rec_item_qty', $receive_qty);
                    $receive_items->bindparam('in_a_item_uom', $uom_no);
                    $receive_items->bindparam('in_a_item_price', $purchase_price);
                    $receive_items->bindparam('in_a_entry_serial_dtl', $entry_sl);
                    $receive_items->bindparam('in_internal_batch_no_uq', $internal_batch_no_uq);
                    $receive_items->bindparam('in_cost_price', $cost_price);
                    $receive_items->bindparam('in_itmremarks', $null);
                    $receive_items->bindparam('in_au_entry_by', $auth_id);
                    $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
                    $receive_items->bindparam('in_au_entry_hospital_no_fk', $ses_hospital_id);
                    $receive_items->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
                    // dd($receive_items);
                    $receive_items->execute();
                }
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            return response()->json($message, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            // Set the appropriate HTTP status code based on the error
            $statusCode = 500; // Default to 500 Internal Server Error

            // Optionally, you can set different status codes based on specific exceptions
            if ($th instanceof \Illuminate\Database\QueryException) {
                $statusCode = 400; // Bad Request or other appropriate status code
            } elseif ($th instanceof \Illuminate\Validation\ValidationException) {
                $statusCode = 422; // Unprocessable Entity for validation errors
            }

            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
            return response()->json($message, $statusCode);
        }
    }
    public function expired_medicine_disposal($disposal_id = "")
    {
        //dd('phrmacy');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $disposaldtl = DB::table('phr_med_expire_disposaldtl')->where('disposalmst_no_fk', $disposal_id)->where('au_entry_hospital_pk_no', $hospital_id)->get();
        $disposalMst = DB::table('phr_med_expire_disposalmst')->where('disposalmst_no_pk', $disposal_id)->where('au_entry_hospital_pk_no', $hospital_id)->first();
        // dd( date('d-m-Y', strtotime($disposaldtl[0]->disposaldtl_date)) );



        return Template::loadview("admin.store.expired_medicine_disposal_form", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'disposaldtl' => $disposaldtl,
            'disposalMst' => $disposalMst
        ]);
    }

    public function expired_medicine_disposal_store(Request $request, $type = "")
    {

        $mst_id = $request->disposalMst_no;


        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $disposalmst_no_pk = $sequence->nextValue('disposalmst_no_pk_seq');
        $last_id = $disposalmst_no_pk;
        $dismst_id = $mst_id != "" ? $mst_id : $last_id;
        $draft = '';
        $post = '';
        if (empty($request->item_id)) {
            $message = ['msg' => 'Empty Item', 'title' => 'Error'];
            return response()->json($message);
        }
        try {
            if ($type == 'DRAFT') {
                $post_ind    = 0;
                $post_date   = '';
                $post_by     = '';
            } else {
                $post_ind   = 1;
                $post_date  = date('Y-m-d');
                $post_by    = $auth_id;
            }
            $mst_data = [
                'disposalmst_date'        => $request->disposalmst_date != "" ? date('Y-m-d', strtotime($request->disposalmst_date)) : '',
                'supplier_pk_no'          => $request->suppler_id,
                'su_no_pk'                => $request->store_id,
                'post_ind'                => $post_ind,
                'post_date'               => $post_date,
                'post_by'                 => $post_by,
                'status'                  => 1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,

            ];

            if (!empty($request->item_id)) {
                $dtl_id           = $request->disposalDtl;
                $item_id_hidden   = $request->item_id;
                $item_name        = $request->item_name;
                $hdn_uom          = $request->hdn_uom;
                $uom              = $request->uom;
                $batch_no         = $request->batch_no;
                $expire_date      = $request->expire_date;
                $expired_qty      = $request->expired_qty;
                $p_rate           = $request->p_rate;
                $amount           = $request->amount;
                $disposal_date    = $request->disposalmst_date != "" ? date('Y-m-d', strtotime($request->disposalmst_date)) : '';
                for ($i = 0; $i < count($request->item_id); $i++) {
                    $disposaldtl_no_pk = $sequence->nextValue('disposaldtl_no_pk_seq');
                    $dtl_data = [
                        'disposaldtl_date'          => $disposal_date,
                        'item_no_fk'                =>  $item_id_hidden[$i],
                        'item_name'                 =>  $item_name[$i],
                        'uom_no_fk'                 =>  $hdn_uom[$i],
                        'uom_name'                  => $uom[$i],
                        'batch_no'                  => $batch_no[$i],
                        'expire_date'               => $expire_date[$i] != "" ? date('Y-m-d', strtotime($expire_date[$i])) : '',
                        'qty'                       =>  $expired_qty[$i],
                        'rate'                      =>   $p_rate[$i],
                        'amt'                       =>  $amount[$i],
                        'status'                    => 1,
                        'au_entry_hospital_pk_no'   => $ses_hospital_id,

                    ];

                    if ($dtl_id[$i] == "") {
                        $dtl_data['disposaldtl_no_pk'] =  $disposaldtl_no_pk;
                        $dtl_data['disposalmst_no_fk'] =  $dismst_id;
                        $dtl_data['au_entry_by'] = $auth_id;
                        $dtl_data['au_entry_at'] = date('Y-m-d h:i');
                        DB::table('phr_med_expire_disposaldtl')->insert($dtl_data);
                    } else {

                        // $dtl_data['disposalmst_no_fk'] = $mst_data;
                        $dtl_data['au_update_by'] = $auth_id;
                        $dtl_data['au_update_at'] = date('Y-m-d h:i');
                        DB::table('phr_med_expire_disposaldtl')->where('disposaldtl_no_pk', $dtl_id[$i])->update($dtl_data);
                    }
                }
                // dd( $dtl_data );

            }

            if ($mst_id == "") {

                $mst_data['disposalmst_no_pk'] = $disposalmst_no_pk;
                $mst_data['au_entry_by'] = $auth_id;
                $mst_data['au_entry_at'] = date('Y-m-d h:i');
                DB::table('phr_med_expire_disposalmst')->insert($mst_data);
                // return $res;

            } else {

                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] = date('Y-m-d h:i');
                DB::table('phr_med_expire_disposalmst')->where('disposalmst_no_pk', $mst_id)->update($mst_data);
            }


            if ($type == 'POST') {
                $chalan_no        = '';
                $chalan_date      = '';
                $demand_no        = '';
                $po_no            = '';
                $supplier_no      = $request->suppler_id;
                $su_no            = $request->store_id;
                $transferIn       = 'EXPIRED';
                $numelems         = 500;
                $in_au_entry_session = 'sessoin';
                $out_itemtrans_uid   = '';

                $item_id_hidden_post   = [];
                $hdn_uom_post               = [];
                $uom_post                   = [];
                $expired_qty_post           = [];
                $p_rate_post                = [];
                $item_pvms_post             = [];
                $empty_arr_post             = [];
                $item_entry_dtl             = [];
                $sl                         = 1;
                if (!empty($request->item_id)) {
                    for ($i = 0; $i < count($request->item_id); $i++) {
                        $item_id_hidden_post[$i]   = $request->item_id[$i];
                        $hdn_uom_post[$i]          = $request->hdn_uom[$i];
                        $uom_post[$i]              = $request->uom[$i];
                        $expired_qty_post[$i]      = $request->expired_qty[$i];
                        $p_rate_post[$i]           = $request->p_rate[$i];
                        $item_pvms_post[$i]        = '';
                        $empty_arr_post[$i]        = '';
                        $item_entry_dtl[$i]        = $sl++;
                    }
                }
                $null = null;
                $pdo              = DB::getPdo();
                $expire_adjustment = $pdo->prepare("begin

                pkg_pharmacy.prc_transactioninout(
                :in_challan_no,
                :in_challan_date,
                :in_store_su_no_fk,
                :in_demand_no_fk,
                :in_po_no,
                :in_supplier_no_fk,
                :in_transtype,
                :in_module_no_fk,
                :in_a_item_no_fk,
                :in_a_item_pvmsno,
                :in_a_item_qty,
                :in_a_item_uom,
                :in_a_freeitem_qty,
                :in_a_freeitem_uom,
                :in_a_item_price,
                :in_a_entry_serial_dtl,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_no_fk,
                :out_itemtrans_uid);
                end;
                ");
                $expire_adjustment->bindparam('in_challan_no', $chalan_no);
                $expire_adjustment->bindparam('in_challan_date', $chalan_date);
                $expire_adjustment->bindparam('in_store_su_no_fk', $su_no);
                $expire_adjustment->bindparam('in_demand_no_fk', $demand_no);
                $expire_adjustment->bindparam('in_po_no', $po_no);
                $expire_adjustment->bindparam('in_supplier_no_fk', $supplier_no);


                $expire_adjustment->bindparam('in_transtype', $transferIn);
                $expire_adjustment->bindparam('in_module_no_fk', $null);
                $expire_adjustment->bindArray('in_a_item_no_fk',  $item_id_hidden_post, count($item_id_hidden_post), $numelems, SQLT_INT);
                $expire_adjustment->bindArray('in_a_item_pvmsno', $item_pvms_post, count($item_pvms_post), $numelems, SQLT_CHR);
                $expire_adjustment->bindArray('in_a_item_qty', $expired_qty_post, count($expired_qty_post), $numelems, SQLT_INT);
                $expire_adjustment->bindArray('in_a_item_uom', $hdn_uom_post, count($hdn_uom_post), $numelems, SQLT_INT);
                $expire_adjustment->bindArray('in_a_freeitem_qty', $empty_arr_post, count($empty_arr_post), $numelems, SQLT_INT);
                $expire_adjustment->bindArray('in_a_freeitem_uom', $empty_arr_post, count($empty_arr_post), $numelems, SQLT_INT);
                $expire_adjustment->bindArray('in_a_item_price', $p_rate_post, count($p_rate_post), $numelems, SQLT_FLT);
                $expire_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

                $expire_adjustment->bindparam('in_au_entry_by', $auth_id);
                $expire_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
                $expire_adjustment->bindparam('in_au_entry_hospital_no_fk', $ses_hospital_id);
                $expire_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

                $expire_adjustment->execute();
            }
            DB::commit();

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'disposal_id' => $dismst_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function expired_medicine_disposal_report_print($disposal_id = "")
    {
        // dd($disposal_id);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $disposal_report_list = DB::table('phr_med_expire_disposaldtl')->where('disposalmst_no_fk', $disposal_id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('disposaldtl_no_pk', 'asc')->get();

        $supplier_info = DB::table('phr_med_expire_disposalmst d')->select('s.supplier_name', 'd.disposalmst_no_pk', 'd.disposalmst_date')->leftJoin('suppliers_vw s', 's.supplier_no_pk', '=', 'd.supplier_pk_no')->where('d.disposalmst_no_pk', $disposal_id)->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $grn_barcode = '';
        if (!empty($disposal_report_list)) {
            $disposal_barcode = $disposal_report_list[0]->disposalmst_no_fk;
        }
        $title = $disposal_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.disposal_report', [
            'po_hospital_details' => $po_hospital_details,
            'disposal_barcode' => $disposal_barcode,
            'disposal_barcode_no' => $barcode_no,
            'disposal_report_list' => $disposal_report_list,
            'userInfo' => $userInfo,
            'supplier_info' => $supplier_info

        ]);
        return $pdf->stream('Disposal-report.pdf');
    }
    public function disposal_supplier_report_print(Request $request)
    {
        // dd($disposal_id);
        $store_id = $request->store_id;
        $supplier_id = $request->suppler_id;
        $from_date = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $to_date = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $disposal_report_list = DB::table('phr_med_expire_disposalmst')
            ->select('phr_med_expire_disposalmst.*', 'phr_med_expire_disposaldtl.*', 'suppliers_vw.*')
            ->leftjoin('phr_med_expire_disposaldtl', 'phr_med_expire_disposaldtl.disposalmst_no_fk', '=', 'phr_med_expire_disposalmst.disposalmst_no_pk')
            ->leftjoin('suppliers_vw', 'suppliers_vw.supplier_no_pk', '=', 'phr_med_expire_disposalmst.supplier_pk_no')
            // ->where('phr_med_expire_disposaldtl.disposalmst_no_fk',$disposal_id)
            ->where('phr_med_expire_disposaldtl.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('phr_med_expire_disposaldtl.disposaldtl_no_pk', 'asc');

        if ($store_id != "") {
            $disposal_report_list->where('phr_med_expire_disposalmst.su_no_pk', '=', $store_id);
        }
        if ($supplier_id != "") {
            $disposal_report_list->where('phr_med_expire_disposalmst.supplier_pk_no', '=', $supplier_id);
        }
        if ($from_date != "" && $to_date) {
            $disposal_report_list->whereBetween('phr_med_expire_disposalmst.disposalmst_date', [$from_date, $to_date]);
        }

        $disposal_report_lists =  $disposal_report_list->get();

        $disposal_report_list_arr = [];

        if (!empty($disposal_report_lists)) {
            foreach ($disposal_report_lists as  $value) {
                $disposal_report_list_arr[$value->supplier_no_pk . '_' . $value->supplier_name][] = $value;
            }
        }
        // dd($disposal_report_list_arr);
        // $supplier_info=DB::table('phr_med_expire_disposalmst d')->select('s.supplier_name','d.disposalmst_no_pk','d.disposalmst_date')->leftJoin('suppliers_vw s','s.supplier_no_pk','=','d.supplier_pk_no')->where('d.disposalmst_no_pk',$disposal_id)->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();


        $title = $store_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.disposal_supplier_report_print', [
            'po_hospital_details' => $po_hospital_details,
            'disposal_barcode' => $store_id,
            'disposal_barcode_no' => $barcode_no,
            'disposal_report_list' => $disposal_report_list_arr,
            'userInfo' => $userInfo,
            'from_date' => $from_date,
            'to_date' => $to_date,
            // 'supplier_info' => $supplier_info

        ]);
        return $pdf->stream('Disposal-supplier-wise-report.pdf');
    }

    public function expired_medicine_disposal_worklist()
    {
        //dd('phrmacy');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.store.expired_medicine_disposal_worklist", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }

    public function expired_medicine_disposal_worklist_search(Request $request)
    {
        //  dd($request->module_code);
        // $item_id = $request->item_id;
        $store_id = $request->store_id;
        $supplier_id = $request->supplier_id;
        $from_date = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $to_date = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';


        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($item_id != "") ? " $clause item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause phr_med_expire_disposalmst.su_no_pk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause phr_med_expire_disposalmst.supplier_pk_no = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" &&  $to_date) ? " $clause phr_med_expire_disposalmst.disposalmst_date between '$from_date' and '$to_date'" : "";
        // dd($sql_cond);
        $disposal_mst = DB::select("SELECT phr_med_expire_disposalmst.*,suppliers_vw.*,sysc_serviceunit.*,item_count FROM phr_med_expire_disposalmst LEFT JOIN suppliers_vw ON suppliers_vw.supplier_no_pk = phr_med_expire_disposalmst.supplier_pk_no LEFT JOIN sysc_serviceunit ON sysc_serviceunit.serviceunit_no_pk = phr_med_expire_disposalmst.su_no_pk LEFT JOIN (  SELECT COUNT (PHR_MED_EXPIRE_DISPOSALDTL.DISPOSALDTL_NO_PK) AS item_count, PHR_MED_EXPIRE_DISPOSALDTL.DISPOSALMST_NO_FK FROM PHR_MED_EXPIRE_DISPOSALDTL GROUP BY PHR_MED_EXPIRE_DISPOSALDTL.DISPOSALMST_NO_FK) ON DISPOSALMST_NO_FK = phr_med_expire_disposalmst.disposalmst_no_pk  $sql_cond order by disposalmst_no_pk desc ");
        // print( $disposal_mst);
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // DB::raw("( SELECT count(disposaldtl_no_pk) FROM `phr_med_expire_disposaldtl`
        //           WHERE `disposalmst_no_fk` = ".Auth::id().") as `sub`");

        return Template::loadview("admin.store.expired_medicine_disposal_list", ['disposal_mst' => $disposal_mst, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }
    public function expireReturn()
    {
        //dd('phrmacy');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');


        $expire_med_list = []; //DB::table('inv_itemstock_audit_vw')->select('inv_itemstock_audit_vw.*')->whereDate('inv_itemstock_audit_vw.expiry_date','<=',date('Y-m-d'))->get();
        // dd(  $expire_med_list);
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        $store_name = DB::table('sysc_serviceunit')->where('status', 1)->where('med_store_ind', 1)->where('au_entry_hospital_pk_no',  $hospital_id)->get();
        // if (!empty( $expire_med_list)) {
        // foreach ($expire_med_list as $key => $value) {
        //     if ($value->item_qty >0) {
        //         $total_item[]=$value->item_qty;
        //         $total_amt[]=$value->item_qty * $value->purchase_price ;
        //         $total_sales_amt[]=$value->item_qty * $value->sales_price;
        //     }

        // }
        // }


        return Template::loadview("admin.store.phr_medicine_expire_return", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'expire_med_list' => $expire_med_list,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt,
            'store_name' => $store_name
        ]);
    }
    public function searchExpireReturn(Request $request)
    {
        //dd('phrmacy');
        $supplier_id = $request->supplier_id;
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date)) : '';
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $store_name = DB::table('sysc_serviceunit')->where('status', 1)->where('med_store_ind', 1)->where('au_entry_hospital_pk_no',  $hospital_id)->get();

        $expire_med_lists = DB::table('inv_itemstock_audit_vw')->select('inv_itemstock_audit_vw.*')->where('supplier_pk_no', $supplier_id)->where('inv_itemstock_audit_vw.trans_type_iss_rcv', 'RECEIVE')->where('item_qty', '>', 0)->orderBy('inv_itemstock_audit_vw.expiry_date', 'desc');
        // ->whereDate('inv_itemstock_audit_vw.expiry_date', '<=', date('Y-m-d'));
        // dd(  $expire_med_list);
        if ($item_id != "") {
            $expire_med_lists->when($item_id, function ($query, $item_id) {
                return   $query->where('item_no_fk', $item_id);
            });
        }

        if ($from_date != "" && $to_date != "") {
            $expire_med_lists->when($from_date, function ($query, $from_date) {
                return   $query->whereDate('inv_itemstock_audit_vw.expiry_date', '>=', $from_date);
            });
            $expire_med_lists->when($to_date, function ($query, $to_date) {
                return   $query->whereDate('inv_itemstock_audit_vw.expiry_date', '<=', $to_date);
            });
        } elseif ($from_date != "" && $to_date == "") {
            $expire_med_lists->when($from_date, function ($query, $from_date) {
                return   $query->whereDate('inv_itemstock_audit_vw.expiry_date', '<=', $from_date);
            });
        }

        $expire_med_list = $expire_med_lists->get();
        // dd(  $expire_med_list);
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($expire_med_list)) {
            foreach ($expire_med_list as $key => $value) {
                if ($value->item_qty > 0) {
                    $total_item[] = $value->item_qty;
                    $total_amt[] = $value->item_qty * $value->purchase_price;
                    $total_sales_amt[] = $value->item_qty * $value->sales_price;
                }
            }
        }


        return Template::loadview("admin.store.phr_medicine_expire_return_list", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'expire_med_list' => $expire_med_list,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt,
            'store_name' => $store_name
        ]);
    }




    public function expireReturnAdj($supplier_id, $rec_id = "")
    {
        $supplier_id = $supplier_id;
        $receive_id = $rec_id != "" ? $rec_id : 'null';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $expire_med_return_list = DB::table('phr_expire_medicine_return')->leftjoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'phr_expire_medicine_return.item_no_fk')->where('phr_expire_medicine_return.supplier_no_fk', $supplier_id)->whereRaw('phr_expire_medicine_return.adj_ind IS NULL or phr_expire_medicine_return.itemreceive_no_fk = ' . $receive_id)->where('phr_expire_medicine_return.au_entry_hospital_pk_no', $hospital_id)->get();
        // dd($expire_med_return_list);
        return Template::loadview("admin.store.phr_medicine_adjestment", ['supplier_id' => $supplier_id, 'expire_med_return_list' => $expire_med_return_list, 'rec_id' => $rec_id]);
    }
    public function expireReturnWorklist()
    {
        //dd('phrmacy');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');


        $expire_med_list = DB::table('phr_expire_medicine_return')->select(DB::raw('count(phr_expire_medicine_return.return_no) as total_item'), 'phr_expire_medicine_return.return_no', 'phr_expire_medicine_return.expire_return_code', 'phr_expire_medicine_return.au_entry_at', 'inv_supplier.supplier_name')->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_expire_medicine_return.supplier_no_fk')->whereDate('phr_expire_medicine_return.au_entry_at', date('Y-m-d'))->where('phr_expire_medicine_return.au_entry_hospital_pk_no', $hospital_id)->orderBy('phr_expire_medicine_return.return_no', 'desc')->groupBy('phr_expire_medicine_return.return_no', 'phr_expire_medicine_return.expire_return_code', 'phr_expire_medicine_return.au_entry_at', 'inv_supplier.supplier_name')->get();
        // dd( $expire_med_list);
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];



        return Template::loadview("admin.store.phr_medicine_expire_return_worklist", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'expire_med_list' => $expire_med_list,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }
    public function searchExpireReturnWorklist(Request $request)
    {
        //dd('phrmacy');
        $supplier_id = $request->supplier_id;
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');



        $expire_med_list = DB::table('phr_expire_medicine_return')->select(DB::raw('count(phr_expire_medicine_return.return_no) as total_item'), 'phr_expire_medicine_return.return_no', 'phr_expire_medicine_return.expire_return_code', 'phr_expire_medicine_return.au_entry_at', 'inv_supplier.supplier_name')->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_expire_medicine_return.supplier_no_fk')->where('phr_expire_medicine_return.au_entry_hospital_pk_no', $hospital_id)->where('phr_expire_medicine_return.supplier_no_fk', $supplier_id)->orderBy('phr_expire_medicine_return.return_no', 'desc')->groupBy('phr_expire_medicine_return.return_no', 'phr_expire_medicine_return.expire_return_code', 'phr_expire_medicine_return.au_entry_at', 'inv_supplier.supplier_name')->get();
        // dd(  $expire_med_list);
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // if (!empty($expire_med_list)) {
        //     foreach ($expire_med_list as $key => $value) {
        //         if ($value->item_qty > 0) {
        //             $total_item[] = $value->item_qty;
        //             $total_amt[] = $value->item_qty * $value->purchase_price;
        //             $total_sales_amt[] = $value->item_qty * $value->sales_price;
        //         }
        //     }
        // }


        return Template::loadview("admin.store.phr_medicine_expire_return_worklist_list", [
            'stores' => $stores,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'expire_med_list' => $expire_med_list,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }
    public function expMedicineReturnPdf($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $phr_expire_medicine_return = DB::table('phr_expire_medicine_return')->select('phr_expire_medicine_return.*', 'inv_supplier.supplier_name', 'sysc_serviceunit.serviceunit_name', 'sysc_serviceitem_vw.item_code', 'sysc_serviceitem_vw.item_name', 'sysc_serviceitem_vw.uom_name')->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_expire_medicine_return.supplier_no_fk')->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'phr_expire_medicine_return.store_no_fk')->leftJoin('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_expire_medicine_return.item_no_fk')->where('phr_expire_medicine_return.return_no', $id)->orderBy('expire_return_no_pk', 'desc')->get();
        $return_barcode = '';
        if (!empty($phr_expire_medicine_return)) {
            $return_barcode = $phr_expire_medicine_return[0]->return_no;
        }
        $title = $return_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.phr_medicine_expire_return_print', [
            'po_hospital_details' => $po_hospital_details,
            'grn_barcode_no' => $barcode_no,
            'return_barcode' => $return_barcode,
            'phr_expire_medicine_return' => $phr_expire_medicine_return,
            'userInfo' => $userInfo

        ]);
        return $pdf->stream('phr_medicine_expire_return_print.pdf');
    }
    public function storeExpireReturn(Request $request)
    {
        // dd($request->all());
        try {
            $chalan_no = 0; //$request->indent;
            $chalan_date = ""; //'date("Y-m-d");
            $store_su_no_fk = isset($request->store) ? $request->store : 0;
            $po_no = 0;
            $demand_no = 0;
            $item_pk_no = [];
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $expire_date = [];
            $batch_no = [];
            $stockTrn_no = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $exp_data = [];
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';
            $transferIn = $request->return_type; //EXPIRED OR DAMAGE
            if (!empty($request->return_check)) {
                for ($i = 0; $i < count($request->return_check); $i++) {
                    $exp_data[$i] = explode('_', $request->return_check[$i]);
                    $item_pk_no[$i] = isset($exp_data[$i][0]) ? $exp_data[$i][0] : 0;
                    $item_pvms[$i] = $null;
                    $item_query[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_pk_no[$i])->first();
                    $supplier_name = $item_query[$i]->supplier_pk_no;
                    $item_uom[$i] = $item_query[$i]->uom_no_fk;
                    $item_qty[$i] = isset($exp_data[$i][1]) ? $exp_data[$i][1] : 0;
                    $item_price[$i] = isset($exp_data[$i][2]) ? $exp_data[$i][2] : 0;
                    $expire_date[$i] = isset($exp_data[$i][3]) ? $exp_data[$i][3] : 0;
                    $batch_no[$i] = isset($exp_data[$i][4]) ? $exp_data[$i][4] : 0;
                    $stockTrn_no[$i] = isset($exp_data[$i][5]) ? $exp_data[$i][5] : 0;
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                }
            }
            // save in table
            $phr_expire_medicine_return = DB::table('phr_expire_medicine_return')->orderBy('expire_return_no_pk', 'desc')->first();
            $return_no = !empty($phr_expire_medicine_return) ? $phr_expire_medicine_return->return_no + 1 : 1;

            if (!empty($request->return_check)) {
                for ($j = 0; $j < count($request->return_check); $j++) {
                    DB::beginTransaction();
                    $sequence = DB::getSequence();
                    $expire_return_no_pk_seq  = $sequence->nextValue('expire_return_no_pk_seq ');
                    $null = '';
                    $data = [
                        'expire_return_no_pk' =>  $expire_return_no_pk_seq,
                        'item_no_fk' => $item_pk_no[$j],
                        'expire_return_code' => $transferIn,
                        'expire_date' => $expire_date[$j],
                        'purchase_rate' =>  $item_price[$j],
                        'qty' =>  $item_qty[$j],
                        'total_amount' =>  $item_qty[$j] * $item_price[$j],
                        'supplier_no_fk' => $supplier_name,
                        'store_no_fk' => $store_su_no_fk,
                        'return_no' => $return_no,
                        'batch_no' => $batch_no[$j],
                        'stocktrans_no_pk' => $stockTrn_no[$j],
                        'au_entry_by' => $in_au_entry_by,
                        'au_entry_at' => date('Y-m-d'),
                        'au_entry_session' => 'session',
                        'au_entry_hospital_pk_no' =>  $in_au_entry_hospital_pk_no
                    ];

                    if (DB::table('phr_expire_medicine_return')->insert($data)) {
                        DB::commit();
                    } else {
                        DB::rollBack();
                    }
                };
            }
            // save in table end and start call procidure



            $pdo = DB::getPdo();
            $null = null;
            $stock_adjustment = $pdo->prepare("begin

        pkg_pharmacy.prc_transactioninout(
        :in_challan_no,
        :in_challan_date,
        :in_store_su_no_fk,
        :in_demand_no_fk,
        :in_po_no,
        :in_supplier_no_fk,
        :in_transtype,
        :in_module_no_fk,
        :in_a_item_no_fk,
        :in_a_item_pvmsno,
        :in_a_item_qty,
        :in_a_item_uom,
        :in_a_freeitem_qty,
        :in_a_freeitem_uom,
        :in_a_item_price,
        :in_a_entry_serial_dtl,
        :in_au_entry_by,
        :in_au_entry_session,
        :in_au_entry_hospital_no_fk,
        :out_itemtrans_uid);
        end;
        ");
            $stock_adjustment->bindparam('in_challan_no', $chalan_no);
            $stock_adjustment->bindparam('in_challan_date', $chalan_date);
            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no);
            $stock_adjustment->bindparam('in_po_no', $po_no);
            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_name);


            $stock_adjustment->bindparam('in_transtype', $transferIn);
            $stock_adjustment->bindparam('in_module_no_fk', $null);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

            $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            // dd( $stock_adjustment);

            $stock_adjustment->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully.', 'title' => 'Success', 'no' => $return_no];
        } catch (\Exception $e) {


            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function inventory_stock_ledger()
    {
        //dd('inventory');
        // dd(Session::get('user.ses_hospital_code'));
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        } else {

            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        }

        $item_type = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk')
            ->where('minor_group_ind', 1)
            // ->where('inventory_head_ind', 1)
            ->orderBy('item_name', 'asc')->get();
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $session = Session::get('user');
        $stocks = [];
        //  DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        //     stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // if (!empty($stocks)) {
        //     foreach ($stocks as $key => $value) {
        //         if ($value->current_stock > 0) {
        //             $total_item[] = $value->current_stock;
        //             $total_amt[] = $value->current_stock * $value->purchase_price;
        //             $total_sales_amt[] = $value->current_stock * $value->sales_price;
        //         }
        //     }
        // }

        return Template::loadview("admin.store.inventory.stock_ledger", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'store_id' => '',
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt,
            'item_type' => $item_type
        ]);
    }


    //masum
    public function store_wise_stock()
    {
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        // Main stores (all active main stores)
        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('main_store_ind', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->get();

        // Sub stores
        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        // Merge main + sub stores
        $allStores = $main_store_list->merge($sub_store_list);

        $item_type = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk')
            ->where('minor_group_ind', 1)
            ->orderBy('item_name', 'asc')
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->get();

        $items = DB::table('SYSC_SERVICEITEM')
        ->select('item_no_pk', 'item_name')
        ->orderBy('item_name', 'asc')
        ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        return Template::loadview("admin.store.inventory.store_wise_stock", [
            'allStores'       => $allStores,    
            'pack_type'       => $pack_type,
            'allSuppliers'    => $allSuppliers,
            'stocks'          => [],
            'store_id'        => '',
            'total_item'      => [],
            'total_amt'       => [],
            'total_sales_amt' => [],
            'item_type'       => $item_type,
            'items'       => $items
        ]);
    }


    public function search_store_wise_stock_list(Request $request)
    {
        $store_id     = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $item_id = $request->item_no_fk;

        $query = DB::table('INV_ITEMSTOCKMST as s')
            ->select(
                's.ITEM_NO_FK as item_no_fk',
                's.ITEM_NAME as item_name',
                's.BALANCE_QTY as current_stock',
                's.ITEM_RATE as purchase_price',
                's.ITEM_RATE as sales_price',
                's.STOCK_SU_NO_FK as store_id',
                'st.SERVICEUNIT_NAME as store_name',
                'u.UOM_CODE as uom_code'
            )
            ->leftJoin('SYSC_SERVICEUNIT as st', 'st.SERVICEUNIT_NO_PK', '=', 's.STOCK_SU_NO_FK')
            ->leftJoin('SYSC_SERVICEITEM as si', 'si.ITEM_NO_PK', '=', 's.ITEM_NO_FK')
            ->leftJoin('SYSC_SERVICEITEM_UOM as u', 'u.UOM_NO_PK', '=', 'si.UOM_NO_FK');

        // Filter by store/sub-store
        if (!empty($store_id)) {
            $query->where('s.STOCK_SU_NO_FK', $store_id); 
        }

        if (!empty($sub_store_id)) {
            $query->where('s.STOCK_SU_NO_FK', $sub_store_id); 
        }

        if (!empty($item_id)) {
            $query->where('s.ITEM_NO_FK', $item_id);
        }

        // if (!empty($store_id)) {
        //       $query->where('s.item_no_fk', 26884901); 
        // }
       
        $query->orderBy('s.ITEM_NAME', 'asc');
       
        // Get results
        // $stocks = $query->get()->groupBy('item_no_fk');
        $stocks = $query->get()->groupBy('item_no_fk');
      
        return view('admin.store.store_wise_stock_table', [
            'stocks'          => $stocks,
            'store_id'        => $store_id
        ]);
    }

    public function store_wise_stock_search_items(Request $request)
    {
        $query = $request->get('q', '');

        $items = DB::table('SYSC_SERVICEITEM')
            ->select('item_no_pk', 'item_name', 'item_code')
            ->where(function ($q) use ($query) {
                $q->whereRaw('UPPER(item_name) LIKE ?', ['%' . strtoupper($query) . '%'])
                ->orWhereRaw('UPPER(item_code) LIKE ?', ['%' . strtoupper($query) . '%']);
            })
            ->orderBy('item_name', 'asc')
            ->get();

        return response()->json($items);
    }

    public function grn_item_history()
    {            
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        // Main stores (all active main stores)
        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('main_store_ind', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->get();

        // Sub stores
        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        // Merge main + sub stores
        $allStores = $main_store_list->merge($sub_store_list);

        $item_type = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk')
            ->where('minor_group_ind', 1)
            ->orderBy('item_name', 'asc')
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', $ses_hospital_no_pk)
            ->get();

        $items = DB::table('SYSC_SERVICEITEM')
        ->select('item_no_pk', 'item_name')
        ->orderBy('item_name', 'asc')
        ->get();
        // dd($items);

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        return Template::loadview("admin.store.grn.grn_item_history", [
            'allStores'       => $allStores,    
            'pack_type'       => $pack_type,
            'allSuppliers'    => $allSuppliers,
            'stocks'          => [],
            'store_id'        => '',
            'total_item'      => [],
            'total_amt'       => [],
            'total_sales_amt' => [],
            'item_type'       => $item_type,
            'ite ms'       => $items
        ]);
    }



    //towhid

    public function inventory_stock_ledger_v1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        } else {

            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        }

        $item_type = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk')
            ->where('minor_group_ind', 1)
            // ->where('inventory_head_ind', 1)
            ->orderBy('item_name', 'asc')->get();
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $session = Session::get('user');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.store.inventory.stock_ledger_v1", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt,
            'item_type' => $item_type
        ]);
    }

    public function search_inv_stock_ledger_list_v1(Request $request)
    {
        // SERVICEUNIT_NO_FK
        // dd($request->sub_store_id, $request->store_id);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        if ($store_id != "" ||   $sub_store_id != "") {
            $minor_group = $request->minor_group != "" ? 'and ser.itemtype_no_fk =' . $request->minor_group : '';
        } else {
            $minor_group = $request->minor_group != "" ? 'where ser.itemtype_no_fk =' . $request->minor_group : '';
        }

        if (isset($sub_store_id)) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk , stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, stock_ledger_vw.last_purchase_date, stock_ledger_vw.last_purchase_qty, stock_ledger_vw.last_purchase_prise, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc");
        }

        if (isset($store_id)) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
                stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk , stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, stock_ledger_vw.last_purchase_date, stock_ledger_vw.last_purchase_qty, stock_ledger_vw.last_purchase_prise, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
                from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
                 left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }

        if (isset($sub_store_id) && $store_id) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, stock_ledger_vw.last_purchase_date, stock_ledger_vw.last_purchase_qty, stock_ledger_vw.last_purchase_prise, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.serviceunit_no_fk and $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }

        return Template::loadview("admin.store.stock_ledger_table_v1", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function bin_card_main_store()
    {
        //dd('inventory');
        // dd(Session::get('user.ses_hospital_code'));
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                // ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        } else {

            $main_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('hospital_store_ind', '=', 1)
                ->where('main_store_ind', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('sub_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();

            $sub_store_list = DB::table('SYSC_SERVICEUNIT')
                ->select('*')
                // ->where('SUB_STORE_IND', '=', 1)
                ->where('STATUS', '=', 1)
                ->where('main_store_module_no_fk', '=', 18)
                ->where('main_store_ind', '!=', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->get();
        }

        $item_type = DB::table('item_type_vw')
            ->select('item_name', 'itemtype_no_pk')
            ->where('minor_group_ind', 1)
            // ->where('inventory_head_ind', 1)
            ->orderBy('item_name', 'asc')->get();
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $session = Session::get('user');
        $stocks = [];
        //  DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        //     stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // if (!empty($stocks)) {
        //     foreach ($stocks as $key => $value) {
        //         if ($value->current_stock > 0) {
        //             $total_item[] = $value->current_stock;
        //             $total_amt[] = $value->current_stock * $value->purchase_price;
        //             $total_sales_amt[] = $value->current_stock * $value->sales_price;
        //         }
        //     }
        // }

        return Template::loadview("admin.store.inventory.bin_card_main_store_wise", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt,
            'item_type' => $item_type
        ]);
    }

    //endTowhid



    public function inventory_stock_ledger_subStore()
    {
        // dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();


        // $sub_store_list = DB::table('sysc_serviceunit')
        //     ->select('*')
        //     ->where('sub_store_ind', '=', 1)
        //     ->where('user_no_pk', '=', Auth::user()->user_no_pk)
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();

        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];
        // DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        //     stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // if (!empty($stocks)) {
        //     foreach ($stocks as $key => $value) {
        //         if ($value->current_stock > 0) {
        //             $total_item[] = $value->current_stock;
        //             $total_amt[] = $value->current_stock * $value->purchase_price;
        //             $total_sales_amt[] = $value->current_stock * $value->sales_price;
        //         }
        //     }
        // }

        return Template::loadview("admin.store.inventory.stock_ledger_subStore", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function subStore_stock_all()
    {
        // dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::id())
            ->get();

        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk','serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->distinct()
            // ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();


            // dd($sub_store_list);

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];
        // DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        //     stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        // if (!empty($stocks)) {
        //     foreach ($stocks as $key => $value) {
        //         if ($value->current_stock > 0) {
        //             $total_item[] = $value->current_stock;
        //             $total_amt[] = $value->current_stock * $value->purchase_price;
        //             $total_sales_amt[] = $value->current_stock * $value->sales_price;
        //         }
        //     }
        // }

        return Template::loadview("admin.store.inventory.sub_store_stock_all", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }

    public function grn_receive_report_main_store()
    {
        //dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();


        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];


        return Template::loadview("admin.store.inventory.grn_receive_report_main_store", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }
    public function item_issue_report_main_store()
    {
        //dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();


        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];


        return Template::loadview("admin.store.inventory.item_issue_report_main_store", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function inventory_main_store_stock()
    {
        // dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $sub_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('SUB_STORE_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }

        return Template::loadview("admin.store.inventory.main_store_stock", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }
    public function grnReceiveReport()
    {
        //dd('inventory');
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $sub_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('SUB_STORE_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        // dd($stores);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name, sys_gen.generic_name  from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk  where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and stock_ledger_vw.module_code = 'INVENTORY' order by stock_ledger_vw.item_name ASC ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }

        return Template::loadview("admin.store.inventory.grn_receive_report", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function item_received()
    {

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        return Template::loadview("admin.store.item_received_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'))
                ->orderBy('itemreceive_no_pk', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);

        return Template::loadview("admin.store.item_received_by_chalan");
    }

    public function item_received_worklist()
    {
        // dd('pharmacy');
        $allSuppliers = DB::table('inv_supplier')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $prev_date = date('Y-m-d', strtotime('-7 days'));
        $today = date('Y-m-d', strtotime('+1 days'));

        return Template::loadview("admin.store.item_received_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                ->where('MODULE_CODE', '=', 'PHR')
                ->whereRaw(DB::raw("trunc(au_entry_at) between to_date('$prev_date','YYYY-MM-DD') and to_date('$today','YYYY-MM-DD')"))
                ->where('AU_ENTRY_HOSPITAL_NO_FK', '=', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ITEMRECEIVE_NO_PK', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);

        // return Template::loadview("admin.store.item_received_by_chalan");
    }
    public function item_received_cafe_optical_worklist()
    {
        // dd('pharmacy');
        $allSuppliers = DB::table('inv_supplier')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $prev_date = date('Y-m-d', strtotime('-7 days'));
        $today = date('Y-m-d', strtotime('+1 days'));

        return Template::loadview("admin.store.item_received_cafe_optical_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                ->whereIn('MODULE_CODE', ['OPTICAL', 'CAFE'])
                ->whereRaw(DB::raw("trunc(au_entry_at) between to_date('$prev_date','YYYY-MM-DD') and to_date('$today','YYYY-MM-DD')"))
                ->where('AU_ENTRY_HOSPITAL_NO_FK', '=', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ITEMRECEIVE_NO_PK', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);
    }
    public function inventory_item_received_worklist()
    {
        // dd('inventory');
        $allSuppliers = DB::table('inv_supplier')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadview("admin.store.inventory.item_received_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                ->select('phr_itemreceive_challan_vw.*', DB::raw('(select sum(vat_amount_itm)  from phr_itemreceivedtl where phr_itemreceivedtl.itemreceive_no_fk =phr_itemreceive_challan_vw.itemreceive_no_pk) as vat_amt'), DB::raw('(select sum(discount_amount_itm)  from phr_itemreceivedtl where phr_itemreceivedtl.itemreceive_no_fk =phr_itemreceive_challan_vw.itemreceive_no_pk) as dis_amt'))
                ->where('phr_itemreceive_challan_vw.module_no_fk', 18)
                ->where('phr_itemreceive_challan_vw.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('phr_itemreceive_challan_vw.itemreceive_no_pk', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);

        // return Template::loadview("admin.store.item_received_by_chalan");
    }


    public function item_received_show_popup(Request $request)
    {
        $receive_pk_no = $request->receive_pk_no;
        $receive_item_by_challan = DB::table('phr_itemreceivedtl')
            ->join('sysc_serviceitem', 'phr_itemreceivedtl.item_no_fk', 'sysc_serviceitem.item_no_pk')
            ->where('phr_itemreceivedtl.itemreceive_no_fk', $receive_pk_no)
            ->get();
        return Template::loadview("admin.store.challan_by_item", ['receive_item_by_challan' => $receive_item_by_challan]);
    }

    public function create_inventory_purchase_order()
    {

        // $stores = DB::table('SYS_SERVICEUNIT')
        //             ->select('*')
        //             ->where('PHARMACY_IND', '=', 1)
        //             ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $poTerms =  $this->getLookupListByCode("INV_POTERMS");


        return Template::loadView("admin.store.inventory.create_po_form", ['supplier_arr' => $supplier_arr, 'poTerms' => $poTerms]);
    }
    public function create_pharmacy_purchase_order()
    {

        // $stores = DB::table('SYS_SERVICEUNIT')
        //             ->select('*')
        //             ->where('PHARMACY_IND', '=', 1)
        //             ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");


        return Template::loadView("admin.store.create_po_form", ['supplier_arr' => $supplier_arr, 'poTerms' => $poTerms]);
    }
    public function create_pharmacy_purchase_order_vat()
    {

        // $stores = DB::table('SYS_SERVICEUNIT')
        //             ->select('*')
        //             ->where('PHARMACY_IND', '=', 1)
        //             ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");


        return Template::loadView("admin.store.create_po_form_vat", ['supplier_arr' => $supplier_arr, 'poTerms' => $poTerms]);
    }

    public function inventory_item_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['finalized_ind', '=', 0],
            ['issue_ind', '=', 0],
            ['module_code', '=', 'INVENTORY'],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')],
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();

        //  dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.inventory.item_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function item_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['finalized_ind', '=', 0],
            ['issue_ind', '=', 0],
            ['module_code', '=', 'PHR'],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')],
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();

        // dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.item_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }

    public function purchaseOrderPrint($purchase_order_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set("max_execution_time", 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];
        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT *
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by i.item_name"));

        $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;

        $pdf = PDF::loadView("admin.store.purchase_order_print", [
            'purchase_order_id' => $purchase_order_id,
            'po_master_info' => $po_master_info,
            'po_child_details_info' => $po_child_details_info,
            'userInfo' => $userInfo,
            'po_hospital_details' => $po_hospital_details,
            'invoice_barcode' => $invoice_barcode,
            'terms' =>   $terms,
            'signed_user' => $signed_user
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }


    public function invPurchaseOrderPrint($purchase_order_id)
    {
        //dd('test');
        PDF::setOptions(['isPhpEnabled', 'true']);
        //$pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code","PAYMODE");

        // $po_hospital_details = DB::select(DB::raw("SELECT h.*
        // FROM INV_PURCHASEORDER_MST pom
        // LEFT JOIN WSEC_HOSPITAL h ON pom.AU_ENTRY_HOSPITAL_NO_FK = h.HOSPITAL_NO_PK
        // WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));
        // dd($po_hospital_details);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];

        //dd($po_master_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT *
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by i.item_name"));

        $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();
        //dd($terms);
        //dd($po_hospital_details);

        // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        // return view("admin.store.purchase_order_print", [
        //     'purchase_order_id' => $purchase_order_id,
        //     'po_master_info' => $po_master_info,
        //     'po_child_details_info' => $po_child_details_info,
        //     'userInfo' => $userInfo,
        //     'po_hospital_details' => $po_hospital_details,
        //     'invoice_barcode' => $invoice_barcode,
        //     'terms' =>   $terms
        // ]);
        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;
        //$signed_user =DB::select("select prepared_by_name,passed_by_name,approved_by_name from comparative_statement_vw");
        //dd($signed_user);


        $pdf = PDF::loadView("admin.store.inv_purchase_order_print", [
            'purchase_order_id' => $purchase_order_id,
            'po_master_info' => $po_master_info,
            'po_child_details_info' => $po_child_details_info,
            'userInfo' => $userInfo,
            'po_hospital_details' => $po_hospital_details,
            'invoice_barcode' => $invoice_barcode,
            'terms' =>   $terms,
            'signed_user' => $signed_user
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function purchaseOrderPrintVat($purchase_order_id)
    {
        //dd('test');
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set("max_execution_time", 0);
        //$pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code","PAYMODE");

        // $po_hospital_details = DB::select(DB::raw("SELECT h.*
        // FROM INV_PURCHASEORDER_MST pom
        // LEFT JOIN WSEC_HOSPITAL h ON pom.AU_ENTRY_HOSPITAL_NO_FK = h.HOSPITAL_NO_PK
        // WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"));
        // dd($po_hospital_details);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];

        //dd($po_master_info);
        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT *
                FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by i.item_name"));

        $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();
        //dd($terms);
        //dd($po_hospital_details);

        // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        // return view("admin.store.purchase_order_print", [
        //     'purchase_order_id' => $purchase_order_id,
        //     'po_master_info' => $po_master_info,
        //     'po_child_details_info' => $po_child_details_info,
        //     'userInfo' => $userInfo,
        //     'po_hospital_details' => $po_hospital_details,
        //     'invoice_barcode' => $invoice_barcode,
        //     'terms' =>   $terms
        // ]);
        $selectQuery = DB::select("select csv.prepared_by_name,csv.passed_by_name,csv.approved_by_name from comparative_statement_vw csv
        inner join inv_purchaseorder_mst pom on csv.requisition_code = pom.requisition_code where pom.purchaseorder_no_pk=$purchase_order_id and approved_ind = 1");
        $signed_user = isset($selectQuery[0]) ? $selectQuery[0] : null;
        //$signed_user =DB::select("select prepared_by_name,passed_by_name,approved_by_name from comparative_statement_vw");
        //dd($signed_user);


        $pdf = PDF::loadView("admin.store.purchase_order_print_vat", [
            'purchase_order_id' => $purchase_order_id,
            'po_master_info' => $po_master_info,
            'po_child_details_info' => $po_child_details_info,
            'userInfo' => $userInfo,
            'po_hospital_details' => $po_hospital_details,
            'invoice_barcode' => $invoice_barcode,
            'terms' =>   $terms,
            'signed_user' => $signed_user
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }
    public function pharmacyPurchaseOrderPrint($purchase_order_id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set("max_execution_time", 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
                FROM INV_PURCHASEORDER_MST pom
                LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
                WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];


        $barcode = new BarcodeGenerator();
        $barcode->setText($purchase_order_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $po_child_details_info = DB::select(DB::raw("SELECT poc.*,i.item_name,i.item_code,i.pr_uom_name ,i.uom_name ,poc.pr_uom_tradeprice as pr_uom_tradeprice_po
                FROM INV_PURCHASEORDER_CHD poc
                 JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order by i.item_name"));

        $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();
        $userInfo = Auth::user();
        $pdf = App::make('dompdf.wrapper');

        $pdf = PDF::loadView("admin.store.purchase_order_print", [
            'purchase_order_id' => $purchase_order_id,
            'po_master_info' => $po_master_info,
            'po_child_details_info' => $po_child_details_info,
            'userInfo' => $userInfo,
            'po_hospital_details' => $po_hospital_details,
            'invoice_barcode' => $invoice_barcode,
            'terms' =>   $terms
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function storeReceive(Request $request)
    {

        $validationArr = [
            'store_id' => 'required',
            'supplier_id' => 'required',
            'challan_no' => 'required',
            'date'    => 'required'

        ];

        if ($request->type == 'chalan') {
            $validationArr['challan_no'] = 'required';
        }

        $validator = Validator::make($request->all(), $validationArr);
        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
        });

        $validator->validate();


        try {
            DB::beginTransaction();
            $chalan_no = $request->challan_no;
            $chalan_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
            $store_id = $request->store_id;
            $demand_no_fk = $request->in_purchaseorder_no_fk;

            $in_suplier_no_fk = $request->supplier_id;
            $item_no_fk_arr = $request->item_ids;
            $item_quantities_arr = $request->item_quantities;
            $conv = $request->conversion;

            $i = 0;
            $item_arr = [];
            $batch_arr = [];
            $expire_arr = [];
            $quantity_arr = [];
            $free_qty_withOut_ext = [];
            $free_quantity_arr = [];
            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
            $hdn_item_rate = [];
            $hdn_item_qnty = [];

            $item_uoms_arr = [];
            $item_prices_arr = [];
            $item_serial_dtl_arr = [];
            $remarks_arr = [];
            $conversion = [];
            $sales_uom = [];
            $free_quantity_arr_post = [];
            $in_vat_percent_itm = [];


            $in_vat_amount_itm = [];

            $in_discount_percent_itm = [];
            $in_discount_amount_itm = [];


            for ($i = 0; $i < count($request->txt_batch); $i++) {
                $item_data = explode('_', $request->txt_batch[$i]);
                $item_arr[$i] = $item_data[0];
                $item_batch_no[$i] = $item_data[1];

                $batch_arr[$i] = $item_batch_no[$i] != "0" ? $item_batch_no[$i] : "";
                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr[$i])->first()->sales_price;
                $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
                $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

                $exp = explode('_', $request->txt_expire_date[$i]);

                $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";
                $free_quantity_arr[$i] = $request->input('free_quantities_' . $item_arr[$i]) != null ? $request->input('free_quantities_' . $item_arr[$i]) : 0;

                foreach ($free_quantity_arr as $key => $value) {
                    foreach ($value as $k => $data) {
                        $free_quantity_arr_post[$i] =  $data != "" ? $data : 0;
                    }
                }

                $checker = $request->input('item_quantities_' . $item_arr[$i]);
                $hdn_item_qnty[$i] = $checker[0];
                $qty_exp = explode('_', $request->batch_qty[$i]);

                $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0] + $free_quantity_arr_post[$i];


                $item_p = explode('_', $request->item_prices[$i]);
                $item_prices_arr[$i] = isset($item_p[1]) ? $item_p[1] : 0;
                // dd($item_p , $item_prices_arr);
                // $key[$i] = 0;

                $item_uom = explode('_', $request->item_uoms[$i]);
                $item_con = explode('_', $request->conversion[$i]);
                // $free_qty = explode('_', $request->conversion[$i]);
                $item_uoms_arr[$i] = isset($item_uom[1]) ? $item_uom[1] : 0;
                $conversion[$i] = isset($item_con[1]) ? $item_con[1] : 0;

                $item_serial_dtl_arr[$i] = "";
                $remarks_arr[$i] = isset($request->remarks[$i]) ? $request->remarks[$i] : '';
                $sales_uom[$i] = isset($request->sales_uom[$i]) ? $request->sales_uom[$i] : 0;
                //Tajul Fix
                $in_vat_percent_itm[$i] = isset($request->item_vat[$i])  ? $request->item_vat[$i] : 0;
                $in_vat_amount_itm[$i] = isset($request->vat_amount[$i])  ? $request->vat_amount[$i] : 0;
                $in_discount_percent_itm[$i] = isset($request->item_discount[$i])  ? $request->item_discount[$i] : 0;
                $in_discount_amount_itm[$i] = isset($request->discount_amount[$i])  ? $request->discount_amount[$i] : 0;
            }


            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $numelems = 500;
            $null = '';
            $out_itemreceive_uid = $out_itemtrans_uid = '';

            $emptyArray = array();

            if ($request->receive_id != "") {

                DB::table('phr_itemreceivedtl')->where('itemreceive_no_fk', $request->receive_id)->delete();
                DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $request->receive_id)->delete();
                DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $request->receive_id)->delete();

                $stock_mas =  DB::table('inv_itemstocktransmst')->select('stocktrans_no_pk')->where('transref_no', $request->receive_id)->where('trans_type_text', 'GRN')->first();
                $item_data_arr = DB::table('inv_itemstocktranschd')->select('stock_su_no_fk', 'item_no_fk', 'stock_trans_qty')->where('stocktrans_no_fk', $stock_mas->stocktrans_no_pk)->get();
                // dd($item_data_arr);
                if (!empty($stock_mas)) {
                    if (!empty($item_data_arr)) {
                        foreach ($item_data_arr as $key => $value) {
                            $data = [
                                'recieve_qty' =>  DB::table('inv_itemstockmst')
                                    ->where('item_no_fk', $value->item_no_fk)
                                    ->where('stock_su_no_fk', $value->stock_su_no_fk)
                                    ->value('recieve_qty') -  $value->stock_trans_qty,
                                'balance_qty' =>  DB::table('inv_itemstockmst')
                                    ->where('item_no_fk', $value->item_no_fk)
                                    ->where('stock_su_no_fk', $value->stock_su_no_fk)
                                    ->value('balance_qty') - $value->stock_trans_qty,
                            ];
                            DB::table('inv_itemstockmst')->where('item_no_fk', $value->item_no_fk)->where('stock_su_no_fk', $value->stock_su_no_fk)->update($data);
                        }
                    }

                    DB::table('inv_itemstocktranschd')->where('stocktrans_no_fk', $stock_mas->stocktrans_no_pk)->delete();
                    DB::table('inv_itemstocktransmst')->where('transref_no', $request->receive_id)->where('trans_type_text', 'GRN')->delete();
                }


                $adj_data = $request->stock_trn_dtl_no;
                // dd( $adj_data);
                if (!empty($adj_data)) {
                    $null_val = null;
                    $return_amt = [
                        'adj_amount' => 0,
                        'adj_ind' => $null_val,
                        'itemreceive_no_fk' => $null_val,
                        'adj_at' =>  $null_val,
                        'adj_by' =>  $null_val,

                    ];

                    DB::table('phr_expire_medicine_return')->where('itemreceive_no_fk', $request->receive_id)->update($return_amt);
                }



                $stockdeduct = 'ISSUE';
                $j = 0;
                $item_arr_pre = [];
                $batch_arr_pre = [];
                $expire_arr_pre = [];
                $quantity_arr_pre = [];
                $free_quantities_pre = [];
                $free_uom_pre = [];
                $item_uoms_arr_pre_exp = [];
                $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
                $hdn_item_rate_pre = [];
                $hdn_item_qnty_pre = [];

                $item_uoms_arr_pre = [];
                $item_prices_arr_pre = [];
                $item_serial_dtl_arr_pre = [];

                $null = null;
                for ($j = 0; $j < count($request->item_id_pre); $j++) {
                    // $item_data = explode('_', $request->txt_batch_pre[$j]);
                    $item_arr_pre[$j] = $request->item_id_pre;

                    // $item_batch_no[$j] = $item_data[1];

                    // $batch_arr_pre[$j] = $item_batch_no[$j] != "0" ? $item_batch_no[$j] : "";
                    $hdn_item_rate_pre[$j] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr_pre[$j])->first()->sales_price;
                    $hdn_item_name[$j] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr_pre[$j])->first()->item_name;
                    $hdn_item_type[$j] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr_pre[$j])->first()->itemtype_no_fk;
                    $hdn_item_no[$j] = DB::table('sysc_serviceitem')->select('item_no_pk')->where('item_no_pk', $item_arr_pre[$j])->first()->item_no_pk;

                    // $exp = explode('_', $request->txt_expire_date_pre[$j]);

                    // $expire_arr_pre[$j] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";



                    // $hdn_item_qnty_pre[$j] = $checker[0];
                    // $qty_exp = explode('_', $request->batch_qty_pre[$j]);
                    $checker[$j] = $request->item_quantities_pre[$j];
                    $quantity_arr_pre[$j] = $request->item_quantities_pre[$j] ? $request->item_quantities_pre[$j] : 0;
                    $free_quantities_pre[$j] = $request->free_quantities_pre[$j] ? $request->free_quantities_pre[$j] : 0;
                    $free_uom_pre[$j] = $request->free_uom_pre[$j] ? $request->free_uom_pre[$j] : 0;
                    $item_uoms_arr_pre_exp = isset($request->item_uoms_pre[$j]) ? explode('_', $request->item_uoms_pre[$j]) : "";
                    $item_uoms_arr_pre[$j] = $item_uoms_arr_pre_exp != "" ? $item_uoms_arr_pre_exp[1] : 0;
                    $item_p = explode('_', $request->item_prices_pre[$j]);
                    $item_prices_arr_pre[$j] = isset($item_p[1]) ? $item_p[1] : 0;
                    $item_arr_pre_id[$j] = $item_p[0];

                    // $key[$j] = 0;

                    $item_serial_dtl_arr_pre[$j] = "";
                }

                $pdo1 = DB::getPdo();
            }


            $module_code = $request->module_code;
            $module_info = DB::table("sysc_module")->where("module_code", $module_code)->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";

            $vat_percent = $request->vat_percent;
            $total_vat_amount = $request->total_vat_amount;
            $discount_percent = $request->discount_percent;
            $adj_amt = $request->adj_discount_amount != '' ? $request->adj_discount_amount : 0;
            $total_discount_amount = $request->total_discount_amount != "" || $adj_amt > 0 ? ($request->total_discount_amount + $adj_amt) : 0;

            $pdo = DB::getPdo();
            $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemreceive_ms(
                            :in_challan_no,
                            :in_challan_date,
                            :in_fiscal_year,
                            :in_year_quarter,
                            :in_store_su_no_fk,
                            :in_demand_no_fk,
                            :in_suplier_no_fk,
                            :in_vat_percent,
                            :in_vat_amount,
                            :in_discount_percent,
                            :in_discount_amount,
                            :in_module_no_fk,
                            :in_a_item_no_fk,
                            :in_item_batch_fk,
                            :in_item_expiry_dt,
                            :in_a_item_pvmsno,
                            :in_a_item_qty,
                            :in_a_item_uom,
                            :in_a_freeitem_qty,
                            :in_a_freeitem_uom,
                            :in_a_item_price,
                            :in_a_entry_serial_dtl,
                            :in_item_remarks,
                            :in_pr_uom_no_fk,
                            :in_pr_uom_conversion_qty,
                            :in_pr_uom_tradeprice,
                            :in_vat_percent_itm,
                            :in_vat_amount_itm,
                            :in_discount_percent_itm,
                            :in_discount_amount_itm,
                            :in_au_entry_by,
                            :in_au_entry_session,
                            :in_au_entry_hospital_no_fk,
                            :out_itemreceive_uid
                        ); end;");

            $receive_items->bindparam('in_challan_no', $chalan_no);
            $receive_items->bindparam('in_challan_date', $chalan_date);
            $receive_items->bindparam('in_fiscal_year', $null);
            $receive_items->bindparam('in_year_quarter', $null);
            $receive_items->bindparam('in_store_su_no_fk', $store_id);
            $receive_items->bindparam('in_demand_no_fk', $demand_no_fk);
            $receive_items->bindparam('in_suplier_no_fk', $in_suplier_no_fk);
            $receive_items->bindparam('in_vat_percent', $vat_percent);
            $receive_items->bindparam('in_vat_amount', $total_vat_amount);
            $receive_items->bindparam('in_discount_percent', $discount_percent);
            $receive_items->bindparam('in_discount_amount', $total_discount_amount);
            $receive_items->bindparam('in_module_no_fk', $module_id);
            //$receive_items->bindparam('in_demand_no_fk', $null);

            $receive_items->bindArray('in_a_item_no_fk', $item_arr, count($item_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_batch_fk', $batch_arr, count($batch_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_item_expiry_dt', $expire_arr, count($expire_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_pvmsno', $item_arr, count($item_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $quantity_arr, count($quantity_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_uom', $sales_uom, count($sales_uom), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_qty', $free_quantity_arr_post, count($free_quantity_arr_post), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_uom', $sales_uom, count($sales_uom), $numelems, SQLT_INT);

            $receive_items->bindArray('in_a_item_price', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_remarks', $remarks_arr, count($remarks_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_pr_uom_no_fk', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_conversion_qty', $conversion, count($conversion), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_tradeprice', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);

            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindParam(':out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            // dd($receive_items);
            $receive_items->execute();

            // $sequence = DB::getSequence();
            // $expire_return_no_pk_seq = $sequence->nextValue('expire_return_no_pk_seq');
            $adj_data = $request->stock_trn_dtl_no;
            if (!empty($adj_data)) {

                $i = 0;
                for ($i = 0; $i < count($adj_data); $i++) {
                    $exp_data[$i] = explode('_', $adj_data[$i]);
                    $return_amt = [
                        'adj_amount' => $exp_data[$i][1],
                        'adj_ind' => 1,
                        'itemreceive_no_fk' => $out_itemreceive_uid,
                        'adj_at' => date('Y-m-d'),
                        'adj_by' => $in_au_entry_by,

                    ];

                    DB::table('phr_expire_medicine_return')->where('stocktrans_no_pk', $exp_data[$i][0])->update($return_amt);
                }
            }
            if ($request->return_adj_amt > 0) {
                $sequence = DB::getSequence();
                $supplier_return_adj_no_pk_seq = $sequence->nextValue('supplier_return_adj_no_pk_seq');
                $return_amt_mst = [
                    'supplier_return_adj_no_pk' => $supplier_return_adj_no_pk_seq,
                    'supplier_no_fk' => $in_suplier_no_fk,
                    'adjustment_amount' => $request->return_adj_amt,
                    'itemreceive_no_fk' => $out_itemreceive_uid,
                    'adjestment_date' => date('Y-m-d'),
                    'au_entry_by' => $in_au_entry_by,
                    'au_entry_session' => $in_au_entry_session,
                    'au_entry_hospital_pk_no' =>  $in_au_entry_hospital_pk_no
                ];
                DB::table('supplier_med_return_adj')->insert($return_amt_mst);
            }



            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Receive No = ' . $out_itemreceive_uid . ',Transaction No = ' . $out_itemtrans_uid . '</strong>', 'title' => 'Success', 'no' => $out_itemreceive_uid];
            return response()->json($this->message, 200);
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($this->message, 422);
        }
    }
    public function storeReceiveCancel(Request $request)
    {
        // dd($request->all());

        $validationArr = [
            'store_id' => 'required',
            'supplier_id' => 'required',
            'challan_no' => 'required',

        ];
        if ($request->type == 'chalan') {
            $validationArr['challan_no'] = 'required';
        }
        $validator = Validator::make($request->all(), $validationArr);
        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
        });
        $validator->validate();


        try {

            DB::beginTransaction();
            $chalan_no = $request->challan_no;
            $chalan_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
            $store_id = $request->store_id;
            $demand_no_fk = $request->in_purchaseorder_no_fk;

            $in_suplier_no_fk = $request->supplier_id;
            $item_no_fk_arr = $request->item_ids;
            $item_quantities_arr = $request->item_quantities;
            $conv = $request->conversion;


            $i = 0;
            $item_arr = [];
            $batch_arr = [];
            $expire_arr = [];
            $quantity_arr = [];
            $free_qty_withOut_ext = [];
            $free_quantity_arr = [];
            $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
            $hdn_item_rate = [];
            $hdn_item_qnty = [];

            $item_uoms_arr = [];
            $item_prices_arr = [];
            $item_serial_dtl_arr = [];
            $remarks_arr = [];
            $conversion = [];
            $sales_uom = [];
            $free_quantity_arr_post = [];

            for ($i = 0; $i < count($request->txt_batch); $i++) {
                $item_data = explode('_', $request->txt_batch[$i]);
                $item_arr[$i] = $item_data[0];
                $item_batch_no[$i] = $item_data[1];

                $batch_arr[$i] = $item_batch_no[$i] != "0" ? $item_batch_no[$i] : "";
                $hdn_item_rate[$i] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr[$i])->first()->sales_price;
                $hdn_item_name[$i] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr[$i])->first()->item_name;
                $hdn_item_type[$i] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr[$i])->first()->itemtype_no_fk;

                $exp = explode('_', $request->txt_expire_date[$i]);

                $expire_arr[$i] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";
                $free_quantity_arr[$i] = $request->input('free_quantities_' . $item_arr[$i]) != null ? $request->input('free_quantities_' . $item_arr[$i]) : 0;

                foreach ($free_quantity_arr as $key => $value) {
                    foreach ($value as $k => $data) {
                        $free_quantity_arr_post[$i] =  $data != "" ? $data : 0;
                    }
                }
                $checker = $request->input('item_quantities_' . $item_arr[$i]);
                $hdn_item_qnty[$i] = $checker[0];
                $qty_exp = explode('_', $request->batch_qty[$i]);

                $quantity_arr[$i] = $request->batch_qty[$i] ? $qty_exp[1] : $checker[0] + $free_quantity_arr_post[$i];


                $item_p = explode('_', $request->item_prices[$i]);
                $item_prices_arr[$i] = isset($item_p[1]) ? $item_p[1] : 0;
                // $key[$i] = 0;

                $item_uom = explode('_', $request->item_uoms[$i]);
                $item_con = explode('_', $request->conversion[$i]);
                // $free_qty = explode('_', $request->conversion[$i]);
                $item_uoms_arr[$i] = isset($item_uom[1]) ? $item_uom[1] : 0;
                $conversion[$i] = isset($item_con[1]) ? $item_con[1] : 0;

                $item_serial_dtl_arr[$i] = "";
                $remarks_arr[$i] = isset($request->remarks[$i]) ? $request->remarks[$i] : '';
                $sales_uom[$i] = isset($request->sales_uom[$i]) ? $request->sales_uom[$i] : 0;
            }

            // dd( $request->item_prices, $request->item_uoms ,$request->conversion, $free_qty_withOut_ext,$quantity_arr,$free_quantity_arr_post);
            // dd( $item_prices_arr, $item_uoms_arr ,$conversion ,$free_quantity_arr_post);


            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $numelems = 500;
            $null = '';
            $out_itemreceive_uid = $out_itemtrans_uid = '';

            $emptyArray = array();

            if ($request->receive_id != "") {

                DB::table('phr_itemreceivedtl')->where('itemreceive_no_fk', $request->receive_id)->delete();
                DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $request->receive_id)->delete();
                DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $request->receive_id)->delete();
                $null_val = null;
                $return_amt = [
                    'adj_amount' => 0,
                    'adj_ind' => $null_val,
                    'itemreceive_no_fk' => $null_val,
                    'adj_at' =>  $null_val,
                    'adj_by' =>  $null_val,

                ];
                DB::table('phr_expire_medicine_return')->where('itemreceive_no_fk', $request->receive_id)->update($return_amt);

                $stockdeduct = 'RCVRTN';
                $j = 0;
                $item_arr_pre = [];
                $batch_arr_pre = [];
                $expire_arr_pre = [];
                $quantity_arr_pre = [];
                $free_quantities_pre = [];
                $free_uom_pre = [];
                $item_uoms_arr_pre_exp = [];
                $deli_dt_arr = $item_delivery_status_arr = $item_mu_arr = $package_ind_arr = $item_mu_arr = $hdn_item_urgent_fee_amt = [];
                $hdn_item_rate_pre = [];
                $hdn_item_qnty_pre = [];

                $item_uoms_arr_pre = [];
                $item_prices_arr_pre = [];
                $item_serial_dtl_arr_pre = [];


                for ($j = 0; $j < count($request->item_id_pre); $j++) {
                    // $item_data = explode('_', $request->txt_batch_pre[$j]);
                    $item_arr_pre[$j] = $request->item_id_pre;

                    // $item_batch_no[$j] = $item_data[1];

                    // $batch_arr_pre[$j] = $item_batch_no[$j] != "0" ? $item_batch_no[$j] : "";
                    $hdn_item_rate_pre[$j] = DB::table('sysc_serviceitem')->select('sales_price')->where('item_no_pk', $item_arr_pre[$j])->first()->sales_price;
                    $hdn_item_name[$j] = DB::table('sysc_serviceitem')->select('item_name')->where('item_no_pk', $item_arr_pre[$j])->first()->item_name;
                    $hdn_item_type[$j] = DB::table('sysc_serviceitem')->select('itemtype_no_fk')->where('item_no_pk', $item_arr_pre[$j])->first()->itemtype_no_fk;
                    $hdn_item_no[$j] = DB::table('sysc_serviceitem')->select('item_no_pk')->where('item_no_pk', $item_arr_pre[$j])->first()->item_no_pk;

                    // $exp = explode('_', $request->txt_expire_date_pre[$j]);

                    // $expire_arr_pre[$j] = $exp[1] != 0 ? str_replace('-', '', $exp[1]) : "";



                    // $hdn_item_qnty_pre[$j] = $checker[0];
                    // $qty_exp = explode('_', $request->batch_qty_pre[$j]);
                    $checker[$j] = $request->item_quantities_pre[$j];
                    $quantity_arr_pre[$j] = $request->item_quantities_pre[$j] ? $request->item_quantities_pre[$j] : 0;
                    $free_quantities_pre[$j] = $request->free_quantities_pre[$j] ? $request->free_quantities_pre[$j] : 0;
                    $free_uom_pre[$j] = $request->free_uom_pre[$j] ? $request->free_uom_pre[$j] : 0;
                    $item_uoms_arr_pre_exp = isset($request->item_uoms_pre[$j]) ? explode('_', $request->item_uoms_pre[$j]) : "";
                    $item_uoms_arr_pre[$j] = $item_uoms_arr_pre_exp != "" ? $item_uoms_arr_pre_exp[1] : 0;
                    $item_p = explode('_', $request->item_prices_pre[$j]);
                    $item_prices_arr_pre[$j] = isset($item_p[1]) ? $item_p[1] : 0;
                    $item_arr_pre_id[$j] = $item_p[0];

                    // $key[$j] = 0;

                    $item_serial_dtl_arr_pre[$j] = "";
                }
                $null = null;
                // dd( $item_arr_pre ,$item_arr_pre_id , $item_uoms_arr_pre , $item_prices_arr_pre,$quantity_arr_pre , $free_quantities_pre,$free_uom_pre);
                $pdo1 = DB::getPdo();
                $receive_deduct = $pdo1->prepare("begin pkg_pharmacy.prc_transactioninout(
                        :in_challan_no,
                        :in_challan_date,
                        :in_store_su_no_fk,
                        :in_demand_no_fk,
                        :in_po_no,
                        :in_suplier_no_fk,
                        :in_transtype,
                        :in_module_no_fk,
                        :in_a_item_no_fk,
                        :in_a_item_pvmsno,
                        :in_a_item_qty,
                        :in_a_item_uom,
                        :in_a_freeitem_qty,
                        :in_a_freeitem_uom,
                        :in_a_item_price,
                        :in_a_entry_serial_dtl,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_no_fk,
                        :out_itemtrans_uid
                    ); end;");

                $receive_deduct->bindparam('in_challan_no', $chalan_no);
                $receive_deduct->bindparam('in_challan_date', $chalan_date);
                $receive_deduct->bindparam('in_store_su_no_fk', $store_id);
                $receive_deduct->bindparam('in_demand_no_fk', $demand_no_fk);
                $receive_deduct->bindparam('in_po_no', $demand_no_fk);
                $receive_deduct->bindparam('in_suplier_no_fk', $in_suplier_no_fk);
                $receive_deduct->bindparam('in_transtype', $stockdeduct);
                $receive_deduct->bindparam('in_module_no_fk', $null);
                $receive_deduct->bindArray('in_a_item_no_fk', $item_arr_pre_id, count($item_arr_pre_id), $numelems, SQLT_INT);
                $receive_deduct->bindArray('in_a_item_pvmsno', $item_arr_pre_id, count($item_arr_pre_id), $numelems, SQLT_CHR);
                $receive_deduct->bindArray('in_a_item_qty', $quantity_arr_pre, count($quantity_arr_pre), $numelems, SQLT_INT);
                $receive_deduct->bindArray('in_a_item_uom', $item_uoms_arr_pre, count($item_uoms_arr_pre), $numelems, SQLT_INT);
                $receive_deduct->bindArray('in_a_freeitem_qty', $free_quantities_pre, count($free_quantities_pre), $numelems, SQLT_INT);
                $receive_deduct->bindArray('in_a_freeitem_uom', $free_uom_pre, count($free_uom_pre), $numelems, SQLT_INT);

                $receive_deduct->bindArray('in_a_item_price', $item_prices_arr_pre, count($item_prices_arr_pre), $numelems, SQLT_FLT);
                $receive_deduct->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr_pre, count($item_serial_dtl_arr_pre), $numelems, SQLT_INT);

                $receive_deduct->bindparam('in_au_entry_by', $in_au_entry_by);
                $receive_deduct->bindparam('in_au_entry_session', $in_au_entry_session);
                $receive_deduct->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
                $receive_deduct->bindParam('out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
                // dd($receive_deduct);
                $receive_deduct->execute();
            }


            DB::commit();
            $this->message = ['msg' => 'Receive Issue successfully. <br><strong>Receive No = ' . $out_itemreceive_uid . ',Transaction No = ' . $out_itemtrans_uid . '</strong>', 'title' => 'Success', 'no' => $out_itemreceive_uid];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function item_received_by_item()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')->select('*')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $received_by_item = DB::table('phr_itemreceive_item_vw')
            ->where('module_no_fk', 18)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy("itemreceive_no_pk", "desc")->get();
        return Template::loadview("admin.store.inventory.item_received_by_item", [
            'received_by_item' => $received_by_item,
            'allSuppliers' => $allSuppliers,
        ]);
    }
    public function pharmacy_item_received_by_item()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')->select('*')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $received_by_item = DB::table('phr_itemreceive_item_vw')
            ->where('module_no_fk', 3)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy("itemreceive_no_pk", "desc")->get();
        return Template::loadview("admin.store.item_received_by_item", [
            'received_by_item' => $received_by_item,
            'allSuppliers' => $allSuppliers,
        ]);
    }

    public function search_receive(Request $request)
    {

        $type = $request->type;
        if ($type == 'chalan') {
            return Template::loadView('admin.store.inventory.search_receive_list', [
                'recieves' => $this->receiveByChalanOrItem($request),
            ]);
        } else {
            return Template::loadView('admin.store.inventory.item_received_by_item_list', [
                'received_by_item' => $this->receiveByChalanOrItem($request),
            ]);
        }

        return Template::loadView('admin.store.inventory.search_receive_list', [
            'recieves' => $this->receiveByChalanOrItem($request),
        ]);
    }
    public function pharmacy_search_receive(Request $request)
    {

        $type = $request->type;

        if ($type == 'chalan') {
            return Template::loadView('admin.store.search_receive_list', [
                'recieves' => $this->pharmacy_receiveByChalanOrItem($request),
            ]);
        } else {
            return Template::loadView('admin.store.item_received_by_item_list', [
                'received_by_item' => $this->pharmacy_receiveByChalanOrItem($request),
            ]);
        }

        // return Template::loadView('admin.store.search_receive_list', [
        //     'recieves' => $this->pharmacy_receiveByChalanOrItem($request),
        // ]);
    }
    public function cafe_optical_search_receive(Request $request)
    {
        $type = $request->type;
        return Template::loadView('admin.store.search_receive_cafe_optical_list', [
            'recieves' => $this->cafe_optical_receiveByChalanOrItem($request),
        ]);
    }

    protected function pharmacy_receive_report(Request $request)
    {
        $query = DB::table('phr_itemreceive_challan_vw')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->where('module_code', 'PHR');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('au_entry_at', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('au_entry_at', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to . ' +1 day ')));
        }

        if (!empty($request->po_data)) {
            $query->where('demand_no_fk', 'like', '%' . $request->po_data . '%');
        }



        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }


        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        $grn_arr = [];

        if (!empty($query->get())) {
            foreach ($query->orderBy('supplier_name', 'asc')->orderBy('au_entry_at', 'desc')->get() as $key => $value) {
                $grn_arr[$value->supplier_no_fk . '*' . $value->supplier_name][] = $value;
            }
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        return  view('admin.store.pharmacy_item_received_report', [
            'grn_arr' => $grn_arr,
            'barcode_no' => $barcode_no,
            'po_hospital_details' => $po_hospital_details,
            'date_from' => $request->search_chalan_date_from,
            'date_to' => $request->search_chalan_date_to,
        ]);
    }
    protected function opticalReceiveReport(Request $request)
    {
        $query = DB::table('phr_itemreceive_challan_vw')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->where('module_code', 'OPTICAL');

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('au_entry_at', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('au_entry_at', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to . ' +1 day ')));
        }

        if (!empty($request->po_data)) {
            $query->where('demand_no_fk', 'like', '%' . $request->po_data . '%');
        }
        if (!empty($request->grn_no)) {
            $query->where('itemreceive_no_pk', $request->grn_no);
        }


        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }

        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }


        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        $grn_arr = [];

        if (!empty($query->get())) {
            foreach ($query->orderBy('supplier_name', 'asc')->orderBy('au_entry_at', 'desc')->get() as $key => $value) {
                $grn_arr[$value->supplier_no_fk . '*' . $value->supplier_name][] = $value;
            }
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        return  view('admin.store.pharmacy_item_received_report', [
            'grn_arr' => $grn_arr,
            'barcode_no' => $barcode_no,
            'po_hospital_details' => $po_hospital_details,
            'date_from' => $request->search_chalan_date_from,
            'date_to' => $request->search_chalan_date_to,
        ]);
    }
    public function pharmacy_search_receive_report(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $type = $request->type;
        $date_from = $request->search_chalan_date_from;
        $date_to = $request->search_chalan_date_to;

        $query = DB::table('phr_itemreceive_challan_dtl_vw')->select('total_received_amount', 'challan_no', 'item_name', 'challan_date', 'receive_by', 'stock_qty', 'trade_price', 'supplier_name')->where('au_entry_hospital_no_fk', session::get('user.ses_hospital_no_pk'));

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }
        if (!empty($request->search_year)) {
            $query->where('fiscal_year', $request->search_year);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('challan_date', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('challan_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        if (!empty($request->po_data)) {
            $query->where('demand_no_fk', 'like', '%' . $request->po_data . '%');
        }
        if (!empty($request->search_po_date)) {
            $query->whereDate('au_entry_at', '=', date('Y-m-d', strtotime($request->search_po_date)));
        }
        if (!empty($request->search_quarter)) {
            $query->where('year_quarter', $request->search_quarter);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        $receives = $query->get();

        $receives_dt = [];
        foreach ($receives as $dt) {
            $receives_dt[$dt->challan_date . '~' . $dt->total_received_amount . '~' . $dt->receive_by] = $dt;
        }

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.store.item_receive_report", [
            'po_hospital_details' => $po_hospital_details,
            'from_date' => $date_from,
            'to_date' => $date_to,
            'barcode_no' => $barcode_no,
            'data' => $receives_dt,
        ]);
        return $pdf->download('item_receive_report.pdf');
    }

    public function stock_details(Request $request)
    {
        return Template::loadview("admin.store.stock_details", [
            'transactions' => DB::table('inv_itemstocktransmst as sist')
                ->join('inv_itemstocktranschd as sistd', 'sist.stocktrans_no_pk', '=', 'sistd.stocktrans_no_fk')
                ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'sist.transref_no')
                ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_itemreceivemst.supplier_no_fk')
                ->select('phr_itemreceivemst.itemreceive_uid', 'sistd.expiry_date','sist.transref_no', 'sist.trans_date', 'sist.trans_type_iss_rcv', 'sistd.item_name', 'sistd.item_qty', 'sistd.batch_no', 'sistd.internal_batch_no_uq', 'sistd.trans_type_text_chd', 'sist.trans_type_text', 'sistd.item_rate as cost_price', 'sistd.trans_type', 'inv_supplier.supplier_name')
                ->where([
                    'sistd.item_no_fk' => $request->item_id,
                    'sistd.stock_su_no_fk' => $request->store_id,
                    'sist.au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                ])
                ->orderBy('trans_date', 'asc')
                ->get()
                ->toArray(),
            'store_name' => $request->store_name,
            'item_name' => $request->item_name,
            'opening_qty' => $request->opening_qty,
            'current_stock' => $request->current_stock,
            'item_id' => $request->item_id,
            'store_id' => $request->store_id,
        ]);
    }
    public function search_stock_details(Request $request)
    {
        // dd($request->item_id,(int)$request->store_id);
        $date_from = $request->date_from != '' ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $store_id = (int)$request->store_id_details;
        $item_id = (int)$request->item_id_details;
        $query = DB::table('INV_ITEMSTOCKTRANSMST as sist')
            ->join('INV_ITEMSTOCKTRANSCHD as sistd', 'sist.stocktrans_no_pk', '=', 'sistd.stocktrans_no_fk')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'sist.transref_no')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_itemreceivemst.supplier_no_fk')
            ->select('sist.transref_no', 'sist.trans_date', 'sist.trans_type_iss_rcv', 'sistd.item_name', 'sistd.item_qty', 'sistd.batch_no', 'sistd.internal_batch_no_uq', 'sistd.trans_type_text_chd', 'sist.trans_type_text', 'sistd.cost_price', 'inv_supplier.supplier_name')
            ->where([
                'sistd.item_no_fk' => $item_id,
                'sistd.stock_su_no_fk' => $store_id,
                'sist.au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
            ]);
        if ($date_from != "" && $date_to != "") {
            $query->where(DB::raw("trunc(sist.transref_date)"), '>=', $date_from)
                ->where(DB::raw("trunc(sist.transref_date)"), '<=', $date_to);
        }


        if ($request->grn_ind) {
            $query->where('sist.trans_type_text', 'GRN');
        }
        $data = $query->orderBy('trans_date', 'asc')
            ->get()
            ->toArray();

            // dd($data);
        // dd( $request->item_id_details, $item_id);
        return Template::loadview("admin.store.stock_details_list", [
            'transactions' => $data,
            'store_name' => $request->store_name,
            'item_name' => $request->item_name,
            'opening_qty' => $request->opening_qty,
            'current_stock' => $request->current_stock,
            'item_id' => $request->item_id,
            'store_id' => $request->store_id,
        ]);
    }

    public function bin_card_stock_details(Request $request)
    {
        return Template::loadview("admin.store.bin_card_stck_details", [
            'transactions' => DB::table('INV_ITEMSTOCKTRANSMST as sist')
                ->join('INV_ITEMSTOCKTRANSCHD as sistd', 'sist.stocktrans_no_pk', '=', 'sistd.stocktrans_no_fk')
                ->select(
                    'sist.transref_no',
                    'sist.trans_date',
                    'sist.trans_type_iss_rcv',
                    'sistd.item_name',
                    'sistd.item_qty',
                    'sistd.batch_no',
                    'sistd.internal_batch_no_uq',
                    'sistd.trans_type_text_chd',
                    'sistd.item_no_fk'
                )
                ->where([
                    'sistd.item_no_fk' => $request->item_id,
                    'sistd.stock_su_no_fk' => $request->store_id,
                    'sist.au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                ])
                ->orderBy('trans_date', 'asc')
                ->get()
                ->toArray(),
            'store_name' => $request->store_name,
            'item_name' => $request->item_name,
            'opening_qty' => $request->opening_qty,
            'current_stock' => $request->current_stock,
            'item_id' => $request->item_id,
            'store_id' => $request->store_id,
        ]);
    }

    public function print_bin_card_stkdt(Request $request)
    {
        $data['transactions'] = DB::table('INV_ITEMSTOCKTRANSMST as sist')
            ->join('INV_ITEMSTOCKTRANSCHD as sistd', 'sist.stocktrans_no_pk', '=', 'sistd.stocktrans_no_fk')
            ->select('sist.transref_no', 'sist.trans_date', 'sist.trans_type_iss_rcv', 'sistd.item_name', 'sistd.item_qty')
            ->where(['sistd.item_no_fk' => $request->print_item_id, 'sistd.stock_su_no_fk' => $request->print_store_id])
            ->orderBy('trans_date')
            ->get()
            ->toArray();
        $data['store_name'] = $request->print_store_name;
        $data['item_name'] = $request->print_item_name;
        $data['opening_qty'] = $request->print_opening_qty;
        $data['current_stock'] = $request->print_current_stock;
        $itemId = $data['item_id'] = $request->print_item_id;
        $storeId = $data['store_id'] = $request->print_store_id;

        if ($request->print_type == 'pdf') {
            $pdf = PDF::loadView("admin.store.bin_card_transection_pdf", $data);

            return $pdf->stream("TransactionLedger-{$storeId}-{$itemId}.pdf");
        }

        $file = "TransactionLedger-{$storeId}-{$itemId}.xls";
        $html = View('admin.store.bin_card_transection_pdf')->with($data);
        header("Content-Disposition: attachment; filename=" . $file);
        header("Content-type: application/vnd.ms-excel");
        echo $html;
    }

    public function print_stock_details(Request $request)
    {
        $date_from = date('Y-m-d', strtotime($request->date_from));
        $date_to = date('Y-m-d', strtotime($request->date_to));
        $grn_ind = $request->grn_ind;
        $query = DB::table('inv_itemstocktransmst as sist')
            ->join('inv_itemstocktranschd as sistd', 'sist.stocktrans_no_pk', '=', 'sistd.stocktrans_no_fk')
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', '=', 'sist.transref_no')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'phr_itemreceivemst.supplier_no_fk')
            ->select('phr_itemreceivemst.itemreceive_uid','sist.transref_no', 'sist.trans_date', 'sist.trans_type_iss_rcv', 'sistd.item_name', 'sistd.item_qty', 'sistd.cost_price', 'inv_supplier.supplier_name')
            ->where(['sistd.item_no_fk' => $request->print_item_id, 'sistd.stock_su_no_fk' => $request->print_store_id]);
        if ($request->date_from != "" && $request->date_to != "") {
            $query->where(DB::raw("trunc(sist.transref_date)"), '>=', $date_from)
                ->where(DB::raw("trunc(sist.transref_date)"), '<=', $date_to);
        }
        if ($grn_ind == 1) {
            $query->where('sist.trans_type_text', 'GRN');
        }
        $data['transactions'] = $query->orderBy('trans_date')
            ->get()
            ->toArray();
        // dd($data);
        // transactions
        $data['store_name'] = $request->print_store_name;
        $data['item_name'] = $request->print_item_name;
        $data['opening_qty'] = $request->print_opening_qty;
        $data['current_stock'] = $request->print_current_stock;
        $itemId = $data['item_id'] = $request->print_item_id;
        $storeId = $data['store_id'] = $request->print_store_id;

        if ($request->print_type == 'pdf') {
            $pdf = PDF::loadView("admin.store.transaction_ledger_pdf", $data);

            return $pdf->stream("TransactionLedger-{$storeId}-{$itemId}.pdf");
        }
        $file = "TransactionLedger-{$storeId}-{$itemId}.xls";
        $html = View('admin.store.transaction_ledger_pdf')->with($data);
        header("Content-Disposition: attachment; filename=" . $file);
        header("Content-type: application/vnd.ms-excel");
        echo $html;
    }

    public function pharmacydefaultSupplierItems(Request $request)
    {

        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        // $items = DB::table('PHR_ITEMRECEIVEMST as irm')
        // ->select('i.item_name', 'i.item_no_pk', 'irc.uom', 'l.lookupdata_name', 'irc.trade_price', 'irc.ITEM_QTY')
        // ->leftJoin('PHR_ITEMRECEIVEDTL as irc', 'irm.ITEMRECEIVE_NO_PK', '=', 'irc.ITEMRECEIVE_NO_FK')
        // ->leftJoin('SYSC_SERVICEITEM i', 'i.item_no_pk', '=', 'irc.item_no_fk')
        // ->leftJoin('SYSC_LOOKUPDATA as l', 'irc.uom', '=', 'l.LOOKUPDATA_NO_PK')
        // ->where('irm.supplier_no_fk', $request->supplier_id)
        // ->where('irm.au_entry_hospital_no_fk', $ses_hospital_no_pk)
        // ->get();

        // $items = DB::table('SYSC_SERVICEITEM as i')
        //     ->select('i.item_name', 'i.item_no_pk', 'i.uom_no_fk', 'l.lookupdata_name', 'i.purchase_price')
        //     ->leftJoin('SYSC_LOOKUPDATA as l', 'i.uom_no_fk', '=', 'l.LOOKUPDATA_NO_PK')
        //     ->leftJoin('INV_SUPPLIER as s', 'i.SUPPLIER_PK_NO', '=', 's.SUPPLIER_NO_PK')
        //     ->leftJoin('WSEC_HOSPITAL as h', 's.AU_ENTRY_HOSPITAL_PK_NO', '=', 'h.HOSPITAL_NO_PK')
        //     ->where('i.SUPPLIER_PK_NO', $request->supplier_id)
        //     ->where('s.AU_ENTRY_HOSPITAL_PK_NO', $ses_hospital_no_pk)
        //     ->get();
        $items = DB::table('default_item_stock_vw')
            ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->where('supplier_pk_no',  $request->supplier_id)
            ->where('module_code', "PHR")
            ->orderBy('item_name', 'asc')
            ->get();

        // dd($items);

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        if ($request->has('search_category')) {
            return Template::loadview('admin.store.default_search_items', [
                // 'items' => $query->get()->toArray(),

            ]);
        }
        return Template::loadview('admin.store.default_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function defaultSupplierItems(Request $request)
    {

        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        // $items = DB::table('PHR_ITEMRECEIVEMST as irm')
        // ->select('i.item_name', 'i.item_no_pk', 'irc.uom', 'l.lookupdata_name', 'irc.trade_price', 'irc.ITEM_QTY')
        // ->leftJoin('PHR_ITEMRECEIVEDTL as irc', 'irm.ITEMRECEIVE_NO_PK', '=', 'irc.ITEMRECEIVE_NO_FK')
        // ->leftJoin('SYSC_SERVICEITEM i', 'i.item_no_pk', '=', 'irc.item_no_fk')
        // ->leftJoin('SYSC_LOOKUPDATA as l', 'irc.uom', '=', 'l.LOOKUPDATA_NO_PK')
        // ->where('irm.supplier_no_fk', $request->supplier_id)
        // ->where('irm.au_entry_hospital_no_fk', $ses_hospital_no_pk)
        // ->get();

        // $items = DB::table('SYSC_SERVICEITEM as i')
        //     ->select('i.item_name', 'i.item_no_pk', 'i.uom_no_fk', 'l.lookupdata_name', 'i.purchase_price')
        //     ->leftJoin('SYSC_LOOKUPDATA as l', 'i.uom_no_fk', '=', 'l.LOOKUPDATA_NO_PK')
        //     ->leftJoin('INV_SUPPLIER as s', 'i.SUPPLIER_PK_NO', '=', 's.SUPPLIER_NO_PK')
        //     ->leftJoin('WSEC_HOSPITAL as h', 's.AU_ENTRY_HOSPITAL_PK_NO', '=', 'h.HOSPITAL_NO_PK')
        //     ->where('i.SUPPLIER_PK_NO', $request->supplier_id)
        //     ->where('s.AU_ENTRY_HOSPITAL_PK_NO', $ses_hospital_no_pk)
        //     ->get();
        $items = DB::table('default_item_stock_vw')
            ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->where('supplier_pk_no',  $request->supplier_id)
            ->where('module_code', 'INVENTORY')
            ->orderBy('item_name', 'asc')
            ->get();

        // dd($items);

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        if ($request->has('search_category')) {
            return Template::loadview('admin.store.default_search_items', [
                // 'items' => $query->get()->toArray(),

            ]);
        }
        return Template::loadview('admin.store.default_items', [
            //'items' => $query->get()->toArray(),
            'items' => $items,
            //'item_categories' => $request->item_categories,
            'allSuppliers' => $allSuppliers,
            'selected_supplier' => $request->supplier_id,
        ]);
    }
    public function purchaseOrderWorklist() {}

    public function pharmacylastSupplierPurchaseOrderItems(Request $request)
    {

        $supplier_id = strtoupper($request->supplier_id);


        $supplier_purchase_order = DB::table('inv_po_wl_vw')
            ->where('supplier_no_fk', $request->supplier_id)
            ->where('module_code', "PHR")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('purchaseorder_no_pk', 'desc')->get();

        //$last_purchase_order = $supplier_purchase_order-1;

        return Template::loadView("admin.store.last_purchase_order_data", ['supplier_purchase_order' => $supplier_purchase_order]);
    }
    public function lastSupplierPurchaseOrderItems(Request $request)
    {

        $supplier_id = strtoupper($request->supplier_id);


        $supplier_purchase_order = DB::table('inv_po_wl_vw')
            ->where('supplier_no_fk', $request->supplier_id)
            ->where('module_code', "INVENTORY")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('purchaseorder_no_pk', 'desc')->get();

        //$last_purchase_order = $supplier_purchase_order-1;

        return Template::loadView("admin.store.inventory.last_purchase_order_data", ['supplier_purchase_order' => $supplier_purchase_order]);
    }

    public function storePurchaseOrder(Request $request)
    {

        //dd($request->all());
        // dd($request->termsid);

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'supplier_id' => 'required',
            // 'termsid.*' => 'required'

        ]);
        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
            // if (empty($request->termsid)) {
            //     return $validator->errors()->add('Terms', 'Please Select At least One Terms');
            // }
        });
        $validator->validate();
        DB::beginTransaction();
        try {
            $in_po_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
            // $in_item_category = strtoupper(trim($request->category_id));
            $supplier_id = $request->supplier_id;
            $item_no_fk_arr = $request->item_ids;

            if (!empty($item_no_fk_arr)) {
                foreach ($item_no_fk_arr as $iofa) {
                    $item_barcode_arr[] = $iofa[0];
                }
            }
            $in_term_number = [];
            $in_term_text = [];

            if (!empty($request->termsid)) {
                for ($i = 0; $i < count($request->termsid); $i++) {
                    $requestName  = 'terms_text_' . $request->termsid[$i];
                    $in_term_number[$i] = $request->termsid[$i];
                    $in_term_text[$i] = $request->input($requestName);
                }
            } else {
                $in_term_number[] = 0;
                $in_term_text[] = '';
            }
            // dd(  $in_term_number , $in_term_text);
            $item_uoms_arr = [];
            if (!empty($item_no_fk_arr)) {
                for ($i = 0; $i < count($request->item_uoms); $i++) {
                    $item_uoms_arr[$i] = isset($request->item_uoms[$i])  ? $request->item_uoms[$i] : 0;
                }
            }

            $in_vat_percent_itm = [];
            if (!empty($item_no_fk_arr)) {
                for ($i = 0; $i < count($item_no_fk_arr); $i++) {
                    $in_vat_percent_itm[$i] = isset($request->item_vat[$i])  ? $request->item_vat[$i] : 0;
                }
            }

            $in_vat_amount_itm = [];
            if (!empty($item_no_fk_arr)) {
                for ($i = 0; $i < count($item_no_fk_arr); $i++) {
                    $in_vat_amount_itm[$i] = isset($request->vat_amount[$i])  ? $request->vat_amount[$i] : 0;
                }
            }

            $in_discount_percent_itm = [];
            if (!empty($item_no_fk_arr)) {
                for ($i = 0; $i < count($item_no_fk_arr); $i++) {
                    $in_discount_percent_itm[$i] = isset($request->item_discount[$i])  ? $request->item_discount[$i] : 0;
                }
            }

            $in_discount_amount_itm = [];
            if (!empty($item_no_fk_arr)) {
                for ($i = 0; $i < count($item_no_fk_arr); $i++) {
                    $in_discount_amount_itm[$i] = isset($request->discount_amount[$i])  ? $request->discount_amount[$i] : 0;
                }
            }
            // // dd( $item_uoms_arr);


            $sales_uom = $request->sales_uom;
            $item_quantities_arr = $request->item_quantities;
            $item_prices_arr = $request->item_rates;

            $item_conversion = $request->item_conversion;

            //$in_au_entry_by             = Auth::id();
            $in_au_entry_by = Session::get('user.ses_user_pk_no');
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $in_vat_percent = $request->vat_percent;
            $in_vat_amount = $request->total_vat_amount != "" ? $request->total_vat_amount : 0;
            // $in_vat_percent_itm = $request->item_vat != "" ? $request->item_vat:0;
            // $in_vat_amount_itm = $request->vat_amount != "" ? $request->vat_amount : 0;
            // $in_discount_percent_itm = $request->item_discount != "" ? $request->item_discount:0;
            // $in_discount_amount_itm = $request->discount_amount != "" ? $request->discount_amount : 0;
            //dd("$in_vat_percent_itm ,$in_vat_amount_itm ,$in_discount_percent_itm, $in_discount_amount_itm");
            $item_total = $request->item_total != "" ? $request->item_total : 0;
            $adj_amt = $request->discount_adj_amt != "" ? $request->discount_adj_amt : 0;
            try {
                $adj_perc = ($adj_amt /  $item_total) * 100;
            } catch (\Exception $e) {

                $adj_perc = 0;
            }


            $module_code = $request->module_code;
            $module_info = DB::table("sysc_module")->where("module_code", $module_code)->select("module_no_pk")->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";

            $in_discount_percent = $request->discount_percent + $adj_perc;
            $in_discount_amount = $request->total_discount_amount + $adj_amt;
            $in_po_no = $request->hdn_po_no;
            $in_po_edit_ind = $request->po_edit_ind;
            $in_refer_no = $request->in_refer_no;
            $in_refer_sub = $request->in_refer_sub;
            $in_subject_body = $request->in_subject_body;
            $in_requisition_code = $request->in_requisition_code;
            // dd($in_discount_percent , $in_discount_amount);
            $numelems = 1000;

            $out_po_uid = '';
            $null = '';
            $emptyArray = array();
            $test_date = date('Y');

            $pdo = DB::getPdo();
            $purchase_order_entry = $pdo->prepare("begin PKG_PHARMACY.prc_phr_po_create(
                    :in_PURCHASEORDER_NO_PK,
                    :in_PURCHASEORDER_EDIT_IND,
                    :in_PURCHASE_DATE,
                    :in_SUPPLIER_NO_FK,
                    :in_ITEM_CATEGORY,
                    :in_FISCAL_YEAR,
                    :in_vat_percent,
                    :in_vat_amount,
                    :in_discount_percent,
                    :in_discount_amount,
                    :in_module_no_fk,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :in_refer_no,
                    :in_refer_sub,
                    :in_subject_body,
                    :in_requisition_code,
                    :in_ITEM_NO_FK,
                    :in_ITEM_BARCODE,
                    :in_PVMS_NO,
                    :in_UOM,
                    :in_ENTRY_QTY,
                    :in_ITEM_RATE,
                    :in_term_number,
                    :in_term_text,
                    :in_pr_uom_no_fk,
                    :in_pr_uom_conversion_qty,
                    :in_pr_uom_tradeprice,
                    :in_vat_percent_itm,
                    :in_vat_amount_itm,
                    :in_discount_percent_itm,
                    :in_discount_amount_itm,
                    :out_PURCHASE_UID
                ); end;");

            $purchase_order_entry->bindparam('in_PURCHASEORDER_NO_PK', $in_po_no);
            $purchase_order_entry->bindparam('in_PURCHASEORDER_EDIT_IND', $in_po_edit_ind);
            $purchase_order_entry->bindparam('in_PURCHASE_DATE', $in_po_date);
            $purchase_order_entry->bindparam('in_SUPPLIER_NO_FK', $supplier_id);
            $purchase_order_entry->bindparam('in_ITEM_CATEGORY', $null);
            $purchase_order_entry->bindparam('in_FISCAL_YEAR', $test_date);
            $purchase_order_entry->bindparam('in_vat_percent', $in_vat_percent);
            $purchase_order_entry->bindparam('in_vat_amount', $in_vat_amount);
            $purchase_order_entry->bindparam('in_discount_percent', $in_discount_percent);
            $purchase_order_entry->bindparam('in_discount_amount', $in_discount_amount);
            $purchase_order_entry->bindparam('in_module_no_fk', $module_id);
            $purchase_order_entry->bindparam('in_AU_ENTRY_BY', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_AU_ENTRY_SESSION', $in_au_entry_session);
            $purchase_order_entry->bindparam('in_AU_ENTRY_HOSPITAL_NO_FK', $in_au_entry_hospital_pk_no);


            $purchase_order_entry->bindparam('in_refer_no', $in_refer_no);
            $purchase_order_entry->bindparam('in_refer_sub', $in_refer_sub);
            $purchase_order_entry->bindparam('in_subject_body', $in_subject_body);
            $purchase_order_entry->bindparam('in_requisition_code', $in_requisition_code);

            $purchase_order_entry->bindArray('in_ITEM_NO_FK', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);

            $purchase_order_entry->bindArray('in_ITEM_BARCODE', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_CHR);

            $purchase_order_entry->bindArray('in_PVMS_NO', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_CHR);

            $purchase_order_entry->bindArray('in_UOM', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_ENTRY_QTY', $item_quantities_arr, count($item_quantities_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_ITEM_RATE', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_term_number', $in_term_number, count($in_term_number), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_term_text', $in_term_text, count($in_term_text), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_pr_uom_no_fk', $sales_uom, count($sales_uom), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_conversion_qty', $item_conversion, count($item_conversion), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_pr_uom_tradeprice', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);
            // dd($purchase_order_entry);
            $purchase_order_entry->bindParam(':out_PURCHASE_UID', $out_po_uid, PDO::PARAM_STR, 500);
            // dd($purchase_order_entry);
            $purchase_order_entry->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Purchase Order UID = ' . $out_po_uid . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            // $this->message = ['msg' => 'There is an error', 'title' => 'Error'];
        }

        return response()->json($this->message);
    }


    public function print_store_stock_ledger(Request $request)
    {

        // dd($request->all());

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
        if ($request->print_type == 'excel_store_wise_summary') {
            $query = DB::table('supplier_wise_pharmacy_stock_vw sl')
                ->select('sl.supplier_no_fk', 'sl.supplier_name', DB::raw('sum(current_stock) as current_stock'), DB::raw('sum(current_stock * purchase_price) as total_price'));
            // ->where('sl.module_code', 'PHR');


        } else {
            $query = DB::table('stock_ledger_vw sl')
                ->leftJoin('sysc_serviceitem ser', 'ser.item_no_pk', '=', 'sl.item_no_fk')
                ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no')
                ->leftJoin('sysc_itemtype ty', 'ty.itemtype_no_pk', '=', 'ser.itemtype_no_fk');
            // ->where('sl.module_code', 'PHR');
        }


        // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
        // ->where('sup.user_no_fk', Auth::id())
        // ->where('med_store_ind', 1)
        // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'));
        if (!empty($request->print_store)) {
            $query->where('sl.stock_su_no_fk', $request->print_store);
        }
        if (!empty($request->print_pvms)) {
            $query->where('sl.pvms_no', $request->print_pvms);
        }
        /*if (!empty($request->item_id)) {
            $query->where('item_no_fk', $request->item_id);
            }*/
        if (!empty($request->print_item_name)) {
            $query->where('sl.item_name', $request->print_item_name);
        }
        if (!empty($request->print_pack_type)) {
            $query->where('sl.pack_type', $request->print_pack_type);
        }

        if (!empty($request->store_id)) {

            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        if (!empty($request->item_id)) {
            $query->where('sl.item_no_fk', $request->item_id);
        }
        if (!empty($request->item_generic_id)) {
            $query->where('ser.generic_no_fk', $request->item_generic_id);
        }

        if ($request->stock_type == "sufficient") {
            $query->whereRaw("sl.re_order_level < sl.current_stock ");
        } elseif ($request->stock_type == "drug_running_low") {
            $query->whereRaw("sl.re_order_level > sl.current_stock and sl.current_stock != 0");
        } elseif ($request->stock_type == "0_stock") {
            $query->whereRaw(" sl.current_stock = 0");
        }

        if ($request->print_type == 'excel_store_wise_summary') {
            if (!empty($request->suppler_id)) {
                $query->where('sl.supplier_no_fk', 'like', '%' . $request->suppler_id . '%');
            }
            $stocks_summary = $query->groupBy('sl.supplier_no_fk', 'sl.supplier_name')->orderBy('sl.supplier_name', 'ASC')->get()->toArray();
            // dd($request->store_id, $stocks_summary);

        } else {
            if (!empty($request->suppler_id)) {
                $query->where('supp.supplier_no_pk', $request->suppler_id);
            }
            $stocks = $query->orderBy('sl.item_name', 'ASC')->get()->toArray();
            // dd($request->suppler_id, $stocks);
        }


        // $total_item = [];
        // $total_amt = [];
        // $total_sales_amt = [];
        // if (!empty($stocks)) {
        //     foreach ($stocks as $key => $value) {
        //         if ($value->current_stock > 0) {
        //             $total_item[] = $value->current_stock;
        //             $total_amt[] = $value->current_stock * $value->purchase_price;
        //             $total_sales_amt[] = $value->current_stock * $value->sales_price;
        //         }
        //     }
        // }

        // dd(array_sum($total_item) , array_sum($total_amt),  array_sum($total_sales_amt));
        if ($request->print_type == 'pdf_store_wise' || $request->print_type == 'excel_store_wise' || $request->print_type == 'pdf_store_wise2' ||  $request->print_type == 'excel_store_wise_summary') {

            $storeWiseStocks = [];
            $total_item2 = 0;
            if ($request->print_type == 'pdf_store_wise') {

                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                    // dd($storeWiseStocks);
                }
            }
            if ($request->print_type == 'excel_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }

            $data['type'] = 'store';
            $data['stocks'] = $storeWiseStocks;
            // $stocks_summary['stocks_summary'] = $stocks_summary;
            $data['po_hospital_details'] = $po_hospital_details;
            // dd($request->print_type);
            if ($request->print_type == 'pdf_store_wise') {
                // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
                // dd($data);
                // return view('admin.store.stock_ledger_pdf',$data);

                return view('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no]);
                // $pdf = App::make('dompdf.wrapper');
                // $pdf = PDF::loadView('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
                // return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'excel_store_wise') {
                // dd( $data);
                return $this->generateExcel('admin.store.stock_ledger_excel', 'StoreLedger', $data);
            }

            if ($request->print_type == 'excel_store_wise_summary') {

                // $stocks_summary = $stocks_summary;
                $stocks_summary['stocks_summary'] = $stocks_summary;
                // dd($stocks   _summary);
                // return view('admin.store.stock_ledger_excel_summary', ['stocks_summary'=> $stocks_summary]);
                return $this->generateExcel('admin.store.stock_ledger_excel_summary', 'stocks_summary', $stocks_summary);
            }
            if ($request->print_type == 'pdf_store_wise2') {

                return view('admin.store.stock_ledger_pdf_item_list', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'total_stocks' => $stocks]);
                // $pdf = App::make('dompdf.wrapper');
                // $pdf = PDF::loadView('admin.store.stock_ledger_pdf_item_list', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'total_stocks' => $stocks])->setPaper('a4', 'portrait');
                // return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
            }
        }
    }

    public function print_inv_store_stock_ledger(Request $request)
    {

        // dd($request->all());
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

        $query = DB::table('stock_ledger_vw sl')
            ->select('sl.*', 'ser.*', 'supp.*', 'ty.item_type_name')
            ->leftJoin('sysc_serviceitem ser', 'ser.item_no_pk', '=', 'sl.item_no_fk')
            ->leftJoin('sysc_itemtype ty', 'ty.itemtype_no_pk', '=', 'ser.itemtype_no_fk')
            ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no')
            // ->where('sl.module_code', 'INVENTORY')
            // ->where('sl.current_stock', '>', 0)
        ;

        $sub_store = DB::select("select u.serviceunit_no_pk  from  sysc_serviceunit u  where  nvl(u.main_store_ind, 0) = 0 and nvl(u.sub_store_ind, 0) = 1");

        if (!empty($request->all_store_stock) && $request->sub_store_id === null) {
            $sub_store_ids = array_column($sub_store, 'serviceunit_no_pk');
            $query->where('sl.current_stock', '>', 0);
            $query->whereIn('sl.stock_su_no_fk', $sub_store_ids);
        }
        
        if (!empty($request->print_store)) {
            $query->where('sl.stock_su_no_fk', $request->print_store);
        }
        if (!empty($request->print_pvms)) {
            $query->where('sl.pvms_no', $request->print_pvms);
        }
        if (!empty($request->print_item_name)) {
            $query->where('sl.item_name', $request->print_item_name);
        }
        if (!empty($request->print_pack_type)) {
            $query->where('sl.pack_type', $request->print_pack_type);
        }
        if (!empty($request->suppler_id)) {
            $query->where('supp.supplier_no_pk', $request->suppler_id);
        }
        if (!empty($request->store_id)) {
            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        if (!empty($request->sub_store_id)) {
            $query->where('sl.stock_su_no_fk', $request->sub_store_id);
        }
        if (!empty($request->item_id)) {
            $query->where('sl.item_no_fk', $request->item_id);
        }
        if (!empty($request->minor_group)) {
            $query->where('ser.itemtype_no_fk', $request->minor_group);
        }
        $stocks = $query->orderBy('sl.item_name', 'ASC')->get()->toArray();
        // dd($stocks);


        if ($request->print_type == 'pdf_store_wise' || $request->print_type == 'excel_store_wise') {
            $storeWiseStocks = [];
            if ($request->print_type == 'pdf_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }
            if ($request->print_type == 'excel_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }


            $data['type'] = 'store';
            $data['stocks'] = $storeWiseStocks;
            $data['po_hospital_details'] = $po_hospital_details;
            // dd($storeWiseStocks);
            if ($request->print_type == 'pdf_store_wise') {
                // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
                // dd($data);

                $pdf = App::make('dompdf.wrapper');
                return view('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no]);

                // $pdf = PDF::loadView('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
                // return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'excel_store_wise') {
                // dd( $data);
                return $this->generateExcel('admin.store.stock_ledger_excel', 'StoreLedger', $data);
            }
        }
        if ($request->print_type == 'pdf_item_wise' || $request->print_type == 'excel_item_wise') {
            $itemWiseStocks = [];
            if (!empty($stocks)) {
                $totalStocks = 0;
                foreach ($stocks as $stock) {
                    $itemWiseStocks[$stock->item_no_fk]['item_name'] = $stock->item_name;
                    $itemWiseStocks[$stock->item_no_fk]['item_code'] = $stock->item_code;
                    $itemWiseStocks[$stock->item_no_fk]['purchase_price'] = $stock->purchase_price;
                    $itemWiseStocks[$stock->item_no_fk]['sales_price'] = $stock->sales_price;
                    $itemWiseStocks[$stock->item_no_fk]['pack_type'] = $stock->pack_type;
                    //                    $itemWiseStocks[$stock->item_no_fk]['pvms_no'] = $stock->pvms_no;
                    $itemWiseStocks[$stock->item_no_fk]['uom_name'] = $stock->uom_name;
                    $itemWiseStocks[$stock->item_no_fk]['re_order_level'] = $stock->re_order_level;
                    $itemWiseStocks[$stock->item_no_fk]['current_stocks'][] = $stock->current_stock;
                }
            }

            $data['type'] = 'item';
            $data['stocks'] = $itemWiseStocks;
            //            dd( $data['stocks']);
            if ($request->print_type == 'pdf_item_wise') {
                return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
            }
            if ($request->print_type == 'excel_item_wise') {
                return $this->generateExcel('admin.store.stock_ledger_excel', 'StoreLedger', $data);
            }
        }
    }

    public function print_inv_store_stock_ledger_v1(Request $request)
    {
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
        $query = DB::table('stock_ledger_vw sl')
            ->select('sl.*', 'ser.*', 'supp.*', 'ty.item_type_name', 'sys_gen.generic_name')
            ->leftJoin('sysc_serviceitem ser', 'ser.item_no_pk', '=', 'sl.item_no_fk')
            ->leftJoin('sysc_itemtype ty', 'ty.itemtype_no_pk', '=', 'ser.itemtype_no_fk')
            ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no')
            ->leftJoin('SYSC_GENERIC sys_gen', 'ser.generic_no_fk', '=', 'sys_gen.generic_no_pk')
            // ->where('sl.module_code', 'INVENTORY')
            // ->where('sl.current_stock', '>', 0)
        ;
        if (!empty($request->print_store)) {
            $query->where('sl.stock_su_no_fk', $request->print_store);
        }
        if (!empty($request->print_pvms)) {
            $query->where('sl.pvms_no', $request->print_pvms);
        }
        if (!empty($request->print_item_name)) {
            $query->where('sl.item_name', $request->print_item_name);
        }
        if (!empty($request->print_pack_type)) {
            $query->where('sl.pack_type', $request->print_pack_type);
        }
        if (!empty($request->suppler_id)) {
            $query->where('supp.supplier_no_pk', $request->suppler_id);
        }
        if (!empty($request->store_id)) {
            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        if (!empty($request->sub_store_id)) {
            $query->where('sl.stock_su_no_fk', $request->sub_store_id);
        }
        if (!empty($request->item_id)) {
            $query->where('sl.item_no_fk', $request->item_id);
        }
        if (!empty($request->minor_group)) {
            $query->where('ser.itemtype_no_fk', $request->minor_group);
        }
        $stocks = $query->orderBy('sl.item_name', 'ASC')->get()->toArray();
        // dd($stocks);

        if ($request->print_type == 'pdf_store_wise' || $request->print_type == 'excel_store_wise') {
            $storeWiseStocks = [];
            if ($request->print_type == 'pdf_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }
            if ($request->print_type == 'excel_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }

            $data['type'] = 'store';
            $data['stocks'] = $storeWiseStocks;
            $data['po_hospital_details'] = $po_hospital_details;
            if ($request->print_type == 'pdf_store_wise') {
                // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
                // dd($data);

                $pdf = App::make('dompdf.wrapper');
                return view('admin.store.stock_ledger_pdf_v1', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no]);

                // $pdf = PDF::loadView('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
                // return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'excel_store_wise') {
                // dd( $data);
                return $this->generateExcel('admin.store.stock_ledger_excel_v1', 'StoreLedger', $data);
            }
        }

        if ($request->print_type == 'pdf_item_wise' || $request->print_type == 'excel_item_wise') {
            $itemWiseStocks = [];

            if (!empty($stocks)) {
                $totalStocks = 0;
                foreach ($stocks as $stock) {
                    $itemWiseStocks[$stock->item_no_fk]['item_name'] = $stock->item_name;
                    $itemWiseStocks[$stock->item_no_fk]['item_code'] = $stock->item_code;
                    $itemWiseStocks[$stock->item_no_fk]['purchase_price'] = $stock->purchase_price;
                    $itemWiseStocks[$stock->item_no_fk]['sales_price'] = $stock->sales_price;
                    $itemWiseStocks[$stock->item_no_fk]['pack_type'] = $stock->pack_type;
                    //$itemWiseStocks[$stock->item_no_fk]['pvms_no'] = $stock->pvms_no;
                    $itemWiseStocks[$stock->item_no_fk]['uom_name'] = $stock->uom_name;
                    $itemWiseStocks[$stock->item_no_fk]['re_order_level'] = $stock->re_order_level;
                    $itemWiseStocks[$stock->item_no_fk]['current_stocks'][] = $stock->current_stock;
                }
            }

            $data['type'] = 'item';
            $data['stocks'] = $itemWiseStocks;

            if ($request->print_type == 'pdf_item_wise') {
                return view('admin.store.stock_ledger_pdf_v1', compact('data'));
                return $this->generatePdf('admin.store.stock_ledger_pdf_v1', "StoreLedger", $data);
            }
            if ($request->print_type == 'excel_item_wise') {
                return $this->generateExcel('admin.store.stock_ledger_excel_v1', 'StoreLedger', $data);
            }
        }
    }

    public function print_grn_receive_report_main_store(Request $request)
    {
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



        $item_id = $request->item_name;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        $from_date = $request->indent_date_from != "" ? date('Y-m-d', strtotime($request->indent_date_from)) : '';
        $to_date = $request->indent_date_to != "" ? date('Y-m-d', strtotime($request->indent_date_to)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause phr_v1_grn_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause phr_v1_grn_vw.store_su_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause phr_v1_grn_vw.store_su_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause phr_v1_grn_vw.supplier_no_fk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" && $to_date != "") ? " $clause trunc(phr_v1_grn_vw.receive_date) between '$from_date' and '$to_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date && $to_date == "") ? " $clause trunc(phr_v1_grn_vw.receive_date)='$from_date' " : "";
        // dd($from_date);

        $stocks = DB::select("SELECT phr_v1_grn_vw.* , SYSC_SERVICEITEM_UOM.UOM_CODE
            from phr_v1_grn_vw left join sysc_serviceitem_uom on sysc_serviceitem_uom.uom_no_pk= phr_v1_grn_vw.uom  $sql_cond order by phr_v1_grn_vw.itemreceive_no_pk desc ");


        if ($request->print_type == 'pdf_store_wise') {
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.store.grn_receive_report_pdf', ['type' => 'store', 'stocks' => $stocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'store_id' => $store_id, 'sub_store_id' => $sub_store_id, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'portrait');
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));

            // return $this->generatePdf('admin.store.grn_receive_report_pdf', "StoreLedger", $data);
        }
        // if ($request->print_type == 'excel_item_wise') {
        //     return $this->generateExcel('admin.store.stock_ledger_excel', 'StoreLedger', $data);
        // }

    }
    public function print_item_issue_report_main_store(Request $request)
    {
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

        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        $from_date = $request->indent_date_from != "" ? date('Y-m-d', strtotime($request->indent_date_from)) : '';
        $to_date = $request->indent_date_to != "" ? date('Y-m-d', strtotime($request->indent_date_to)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause inv_requisition_itm_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause inv_requisition_itm_vw.to_store_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause inv_requisition_itm_vw.to_store_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause inv_requisition_itm_vw.supplier_pk_no = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" && $to_date != "") ? " $clause trunc(inv_requisition_itm_vw.issue_at) between '$from_date' and '$to_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date && $to_date == "") ? " $clause trunc(inv_requisition_itm_vw.issue_at)='$from_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause issue_ind= 1 ";

        // dd( $from_date, $to_date);
        $stocks = DB::select("SELECT inv_requisition_itm_vw.* , sysc_serviceitem_uom.uom_code
            from inv_requisition_itm_vw left join sysc_serviceitem_uom on sysc_serviceitem_uom.uom_no_pk= inv_requisition_itm_vw.uom_no_fk  $sql_cond order by inv_requisition_itm_vw.issue_at desc ");


        if ($request->print_type == 'pdf_store_wise') {
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.store.item_issue_report_pdf', ['type' => 'store', 'stocks' => $stocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'store_id' => $store_id, 'sub_store_id' => $sub_store_id, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'portrait');
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));

            // return $this->generatePdf('admin.store.grn_receive_report_pdf', "StoreLedger", $data);
        }
        // if ($request->print_type == 'excel_item_wise') {
        //     return $this->generateExcel('admin.store.stock_ledger_excel', 'StoreLedger', $data);
        // }

    }



    public function print_inv_store_stock(Request $request)
    {

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
        $query = DB::table('stock_ledger_vw sl')
            ->leftJoin('sysc_serviceitem ser', 'ser.item_no_pk', '=', 'sl.item_no_fk')
            ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no')
            ->where('sl.module_code', 'INVENTORY');

        // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
        // ->where('sup.user_no_fk', Auth::id())
        // ->where('med_store_ind', 1)
        // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'));
        if (!empty($request->print_store)) {
            $query->where('sl.stock_su_no_fk', $request->print_store);
        }
        if (!empty($request->print_pvms)) {
            $query->where('sl.pvms_no', $request->print_pvms);
        }
        /*if (!empty($request->item_id)) {
            $query->where('item_no_fk', $request->item_id);
            }*/
        if (!empty($request->print_item_name)) {
            $query->where('sl.item_name', $request->print_item_name);
        }
        if (!empty($request->print_pack_type)) {
            $query->where('sl.pack_type', $request->print_pack_type);
        }
        if (!empty($request->suppler_id)) {
            $query->where('supp.supplier_no_pk', $request->suppler_id);
        }
        if (!empty($request->store_id)) {
            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        if (!empty($request->item_id)) {
            $query->where('sl.item_no_fk', $request->item_id);
        }
        //      $data['stocks'] = $query->get()->toArray();
        $stocks = $query->orderBy('sl.item_name', 'ASC')->get()->toArray();

        if ($request->print_type == 'pdf_store_wise' || $request->print_type == 'excel_store_wise') {
            $storeWiseStocks = [];
            if ($request->print_type == 'pdf_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }
            if ($request->print_type == 'excel_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                        $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }

            $data['type'] = 'store';
            $data['stocks'] = $storeWiseStocks;
            $data['po_hospital_details'] = $po_hospital_details;
            // dd($storeWiseStocks);

            if ($request->print_type == 'pdf_store_wise') {
                // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
                // dd($data);

                $pdf = App::make('dompdf.wrapper');
                $pdf = PDF::loadView('admin.store.main_store_stock_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
                return $pdf->stream("main_store_stock_pdf.pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'excel_store_wise') {
                // dd( $data);
                return $this->generateExcel('admin.store.main_store_stock_excel', 'Main Store Stock', $data);
            }
        }


        if ($request->print_type == 'pdf_item_wise' || $request->print_type == 'excel_item_wise') {
            $itemWiseStocks = [];
            if (!empty($stocks)) {
                $totalStocks = 0;
                foreach ($stocks as $stock) {
                    $itemWiseStocks[$stock->item_no_fk]['item_name'] = $stock->item_name;
                    $itemWiseStocks[$stock->item_no_fk]['item_code'] = $stock->item_code;
                    $itemWiseStocks[$stock->item_no_fk]['purchase_price'] = $stock->purchase_price;
                    $itemWiseStocks[$stock->item_no_fk]['sales_price'] = $stock->sales_price;
                    $itemWiseStocks[$stock->item_no_fk]['pack_type'] = $stock->pack_type;
                    //                    $itemWiseStocks[$stock->item_no_fk]['pvms_no'] = $stock->pvms_no;
                    $itemWiseStocks[$stock->item_no_fk]['uom_name'] = $stock->uom_name;
                    $itemWiseStocks[$stock->item_no_fk]['re_order_level'] = $stock->re_order_level;
                    $itemWiseStocks[$stock->item_no_fk]['current_stocks'][] = $stock->current_stock;
                }
            }

            $data['type'] = 'item';
            $data['stocks'] = $itemWiseStocks;
            //            dd( $data['stocks']);
            if ($request->print_type == 'pdf_item_wise') {

                return $this->generatePdf('admin.store.main_store_stock_pdf', "StoreLedger", $data);
            }
            if ($request->print_type == 'excel_item_wise') {
                return $this->generateExcel('admin.store.main_store_stock_excel', 'StoreLedger', $data);
            }
        }
    }
    public function print_inv_store_stock_grm_report(Request $request)
    {

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
        // $query = DB::table('stock_ledger_vw sl')
        $query = DB::table('phr_v1_grn_vw sl')
            ->leftJoin('sysc_serviceitem_uom_uhl ser', 'ser.uom_no_pk', '=', 'sl.uom')
            // ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no')
            ->where('sl.module_code', 'INVENTORY');

        // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
        // ->where('sup.user_no_fk', Auth::id())
        // ->where('med_store_ind', 1)
        // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'));
        // if (!empty($request->print_store)) {
        //     $query->where('sl.stock_su_no_fk', $request->print_store);
        // }
        // if (!empty($request->print_pvms)) {
        //     $query->where('sl.pvms_no', $request->print_pvms);
        // }
        /*if (!empty($request->item_id)) {
            $query->where('item_no_fk', $request->item_id);
            }*/
        // if (!empty($request->print_item_name)) {
        //     $query->where('sl.item_name', $request->print_item_name);
        // }
        // if (!empty($request->print_pack_type)) {
        //     $query->where('sl.pack_type', $request->print_pack_type);
        // }
        // if (!empty($request->suppler_id)) {
        //     $query->where('supp.supplier_no_pk', $request->suppler_id);
        // }
        if (!empty($request->store_id)) {
            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        // if (!empty($request->item_id)) {
        //     $query->where('sl.item_no_fk', $request->item_id);
        // }


        if (!empty($request->from_date) && !empty($request->to_date)) {
            $todate = date('Y-m-d', strtotime($request->from_date));
            $fromDate = date('Y-m-d', strtotime($request->to_date));
            // $query->whereBetween('sl.receive_date', [date('Y-m-d',strtotime($request->from_date)), date('Y-m-d',strtotime($request->to_date))]);
            $query->whereRaw("trunc(sl.receive_date) BETWEEN '$todate' AND '$fromDate'");
        }

        //      $data['stocks'] = $query->get()->toArray();
        $stocks = $query->orderBy('sl.item_name', 'ASC')->get()->toArray();
        // dd($request->from_date , $request->to_date);

        if ($request->print_type == 'pdf_store_wise' || $request->print_type == 'excel_store_wise') {
            $storeWiseStocks = [];
            if ($request->print_type == 'pdf_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->store_su_no_fk]['store_name'] = $stock->department;
                        $storeWiseStocks[$stock->store_su_no_fk]['stocks'][$stock->supplier_no_fk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }
            if ($request->print_type == 'excel_store_wise') {
                if (!empty($stocks)) {
                    foreach ($stocks as $stock) {
                        $storeWiseStocks[$stock->store_su_no_fk]['store_name'] = $stock->department;
                        $storeWiseStocks[$stock->store_su_no_fk]['stocks'][$stock->supplier_no_fk . '_' . $stock->supplier_name][] = $stock;
                    }
                }
            }

            $data['type'] = 'store';
            $data['stocks'] = $storeWiseStocks;
            $data['po_hospital_details'] = $po_hospital_details;
            // dd($storeWiseStocks);

            if ($request->print_type == 'pdf_store_wise') {
                // return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
                // dd($data);

                $pdf = App::make('dompdf.wrapper');
                $pdf = PDF::loadView('admin.store.main_store_stock_grn_report_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
                return $pdf->stream("main_store_stock_pdf.pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'excel_store_wise') {
                // dd( $data);
                return $this->generateExcel('admin.store.main_store_stock_excel', 'Main Store Stock', $data);
            }
        }


        if ($request->print_type == 'pdf_item_wise' || $request->print_type == 'excel_item_wise') {
            $itemWiseStocks = [];
            if (!empty($stocks)) {
                $totalStocks = 0;
                foreach ($stocks as $stock) {
                    $itemWiseStocks[$stock->item_no_fk]['item_name'] = $stock->item_name;
                    $itemWiseStocks[$stock->item_no_fk]['item_code'] = $stock->item_code;
                    $itemWiseStocks[$stock->item_no_fk]['purchase_price'] = $stock->purchase_price;
                    $itemWiseStocks[$stock->item_no_fk]['sales_price'] = $stock->sales_price;
                    $itemWiseStocks[$stock->item_no_fk]['pack_type'] = $stock->pack_type;
                    //                    $itemWiseStocks[$stock->item_no_fk]['pvms_no'] = $stock->pvms_no;
                    $itemWiseStocks[$stock->item_no_fk]['uom_name'] = $stock->uom_name;
                    $itemWiseStocks[$stock->item_no_fk]['re_order_level'] = $stock->re_order_level;
                    $itemWiseStocks[$stock->item_no_fk]['current_stocks'][] = $stock->current_stock;
                }
            }

            $data['type'] = 'item';
            $data['stocks'] = $itemWiseStocks;
            //            dd( $data['stocks']);
            if ($request->print_type == 'pdf_item_wise') {
                return $this->generatePdf('admin.store.main_store_stock_pdf', "StoreLedger", $data);
            }
            if ($request->print_type == 'excel_item_wise') {
                return $this->generateExcel('admin.store.main_store_stock_excel', 'StoreLedger', $data);
            }
        }
    }

    public function search_stock(Request $request)
    {
        $query = DB::table('stock_ledger_vw sl');
        // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk');
        // ->where('sup.user_no_fk', Auth::id());
        // ->where('med_store_ind', 1)
        // ->where('sl.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if (!empty($request->store_id)) {
            $query->where('sl.stock_su_no_fk', $request->store_id);
        }
        if (!empty($request->supplier_id)) {
            $query->where('sl.supplier_pk_no', $request->supplier_id);
        }
        if (!empty($request->pvms_no)) {
            $query->where('sl.pvms_no', $request->pvms_no);
        }
        /*if (!empty($request->item_id)) {
            $query->where('item_no_fk', $request->item_id);
            }*/
        if (!empty($request->item_name)) {
            $query->where('sl.item_name', $request->item_name);
        }
        if (!empty($request->pack_type)) {
            $query->where('sl.pack_type', $request->pack_type);
        }
        // $stock = $query->tosql();
        // dd($stock);

        return Template::loadview("admin.store.search_stock_ledger", [
            'stocks' => $query->get()->toArray(),
        ]);
    }

    public function stockInOut()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            ->where('t.module_code', 'INVENTORY')
            ->get();

        return Template::loadView("admin.store.inventory.stockInOut", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }
    public function pharmacy_stockInOut()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            ->where('t.module_code', 'PHR')
            ->get();

        return Template::loadView("admin.store.stockInOut", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }
    public function pharmacy_expiredStockInOut()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            //  ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            //  ->where('t.module_code', 'PHR')
            ->where('t.trans_type_text', 'TRANSIN')
            ->get();
        //  dd($allStockInTransactions);

        return Template::loadView("admin.store.expired_stockInOut", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }

    public function stockOutWorklist()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        // $supplier_arr = [];
        // if(!empty($allSuppliers))
        // {
        //    foreach ($allSuppliers as $row) {
        //        $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
        //    }
        // }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_OUT_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            ->where('t.module_code', 'INVENTORY')
            ->get();

        return Template::loadView("admin.store.inventory.stockOutWorklist", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }
    public function pharmacy_stockOutWorklist()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        // $supplier_arr = [];
        // if(!empty($allSuppliers))
        // {
        //    foreach ($allSuppliers as $row) {
        //        $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
        //    }
        // }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_OUT_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            ->where('t.module_code', 'PHR')
            ->get();

        return Template::loadView("admin.store.stockOutWorklist", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }
    public function pharmacy_expiredStockOutWorklist()
    {

        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        // $supplier_arr = [];
        // if(!empty($allSuppliers))
        // {
        //    foreach ($allSuppliers as $row) {
        //        $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
        //    }
        // }

        // $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_IN_VW')
        //   ->select('*')
        //   ->get();

        $allStockInTransactions = DB::table('PHR_TRANSACTION_STOCK_OUT_VW as t')
            ->select('t.*', 's.supplier_name')
            ->leftJoin('INV_SUPPLIER as s', 't.SUPPLIER_NO_FK', '=', 's.SUPPLIER_NO_PK')
            ->where('t.au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no)
            // ->where('t.module_code', 'PHR')
            ->where('t.trans_type_text', 'TRANSOUT')

            ->get();

        return Template::loadView("admin.store.expired_stockOutWorklist", ['allSuppliers' => $allSuppliers, 'allStockInTransactions' => $allStockInTransactions]);
    }

    public function createStockInOut()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        return Template::loadView("admin.store.createStockInOut", ['supplier_arr' => $supplier_arr, 'stores' => $stores]);
    }

    public function storeStockInOut(Request $request)
    {

        $validationArr = [
            'stock_type' => 'required',
            'supplier_id' => 'required',
            'store_id' => 'required',
            'in_purchaseorder_no_fk' => 'required',
            //'challan_no' => 'required',
        ];
        if ($request->type == 'chalan') {
            $validationArr['challan_no'] = 'required';
        }
        $validator = Validator::make($request->all(), $validationArr);
        $validator->after(function ($validator) use ($request) {
            if (empty($request->item_ids)) {
                return $validator->errors()->add('item', 'Items cannot be blank.');
            }
        });
        $validator->validate();
        DB::beginTransaction();

        try {
            $stock_type = $request->stock_type;
            $chalan_no = $request->challan_no;
            $chalan_date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;
            //$fiscal_year = $request->fiscal_year;
            //$quarter_no_fk = $request->quarter;
            $store_id = $request->store_id;
            $demand_no_fk = $request->in_purchaseorder_no_fk;
            $in_po_no = $request->in_purchaseorder_no_fk;
            //$in_purchaseorder_no_fk = 0;

            $in_suplier_no_fk = $request->supplier_id;
            $item_no_fk_arr = $request->item_ids;
            //$item_pvmsno_arr = $request->pvms_nos;
            $item_uoms_arr = $request->item_uoms;
            $item_quantities_arr = $request->item_quantities;
            // $item_prices_arr = $request->item_prices;
            $item_prices_arr = $request->item_rates;
            $item_serial_dtl_arr = [];

            if (!empty($item_no_fk_arr)) {
                foreach ($item_no_fk_arr as $key => $item_no) {
                    $item_serial_dtl_arr[] = $key + 1;
                }
            }

            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $numelems = 500;
            $null = null;
            $out_itemtrans_uid = '';

            $emptyArray = array();

            $pdo = DB::getPdo();
            $transactions_entry = $pdo->prepare("begin pkg_pharmacy.prc_transactioninout(
                :in_challan_no,
                :in_challan_date,
                :in_store_su_no_fk,
                :in_demand_no_fk,
                :in_po_no,
                :in_suplier_no_fk,
                :in_transtype,
                :in_module_no_fk,
                :in_a_item_no_fk,
                :in_a_item_pvmsno,
                :in_a_item_qty,
                :in_a_item_uom,
                :in_a_item_price,
                :in_a_entry_serial_dtl,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_no_fk,
                :out_itemtrans_uid
            ); end;");

            $transactions_entry->bindparam('in_challan_no', $chalan_no);
            $transactions_entry->bindparam('in_challan_date', $chalan_date);
            $transactions_entry->bindparam('in_store_su_no_fk', $store_id);
            $transactions_entry->bindparam('in_demand_no_fk', $demand_no_fk);
            $transactions_entry->bindparam('in_po_no', $in_po_no);
            $transactions_entry->bindparam('in_suplier_no_fk', $in_suplier_no_fk);
            $transactions_entry->bindparam('in_transtype', $stock_type);
            $transactions_entry->bindparam('in_module_no_fk', $null);

            $transactions_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
            $transactions_entry->bindArray('in_a_item_pvmsno', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_CHR);
            $transactions_entry->bindArray('in_a_item_qty', $item_quantities_arr, count($item_quantities_arr), $numelems, SQLT_INT);
            $transactions_entry->bindArray('in_a_item_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $transactions_entry->bindArray('in_a_item_price', $item_prices_arr, count($item_prices_arr), $numelems, SQLT_INT);
            $transactions_entry->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);

            $transactions_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $transactions_entry->bindparam('in_au_entry_session', $in_au_entry_session);
            $transactions_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

            $transactions_entry->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

            $transactions_entry->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Transaction ID = ' . $out_itemtrans_uid . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function test()
    {
        echo "asdasd";
    }

    public function searchStockInItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_in_vw si')
            ->where('si.module_code', 'INVENTORY')
            ->where('si.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_chalan_no)) {
            $query->where('si.challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(si.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            $query->where('si.supplier_no_fk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('si.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchStockInItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }
    public function pharmacy_searchStockInItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_in_vw si')
            // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
            // ->where('sup.user_no_fk', Auth::id());
            // ->where('med_store_ind', 1)
            ->where('si.module_code', 'PHR')
            ->where('si.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_chalan_no)) {
            $query->where('si.challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(si.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            $query->where('si.supplier_no_fk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('si.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchStockInItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }
    public function pharmacy_searchExpiredStockInItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_in_vw si')
            // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
            // ->where('sup.user_no_fk', Auth::id());
            // ->where('med_store_ind', 1)
            // ->where('si.module_code', 'PHR')
            ->where('si.trans_type_text', 'TRANSIN')
            ->where('si.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_transaction_no)) {
            $query->where('si.itemreceive_no_pk', 'like', '%' . $request->search_transaction_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(si.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            $query->where('si.supplier_no_fk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('si.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchExpiredStockInItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }
    public function searchStockOutItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_out_vw so')
            // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
            // ->where('sup.user_no_fk', Auth::id());
            ->where('so.module_code', 'INVENTORY')
            ->where('so.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_chalan_no)) {
            $query->where('so.challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(so.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            // dd($request->supplier_id);
            $query->where('so.supplier_no_pk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('so.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchStockOutItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }
    public function pharmacy_searchStockOutItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_out_vw so')
            // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
            // ->where('sup.user_no_fk', Auth::id());
            ->where('so.module_code', 'PHR')
            ->where('so.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_chalan_no)) {
            $query->where('so.challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(so.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            // dd($request->supplier_id);
            $query->where('so.supplier_no_pk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('so.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchStockOutItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }
    public function pharmacy_searchExpiredStockOutItem(Request $request)
    {

        // dd($request->item_id);
        $query = DB::table('phr_transaction_stock_out_vw so')
            // ->join('sysc_user_store_su_privs_vw sup', 'sl.stock_su_no_fk', '=', 'sup.su_no_fk')
            // ->where('sup.user_no_fk', Auth::id());
            // ->where('so.module_code', 'PHR')
            ->where('so.trans_type_text', 'TRANSOUT')
            ->where('so.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        //dd($query);

        if (!empty($request->search_transaction_no)) {
            $query->where('so.itemreceive_no_pk', 'like', '%' . $request->search_transaction_no . '%');
        }

        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            // dd($request->search_chalan_date_from);
            $query->whereBetween(DB::raw("trunc(so.trans_date)"), [date('Y-m-d', strtotime($request->search_chalan_date_from)), date('Y-m-d', strtotime($request->search_chalan_date_to))]);
            //$query->where('si.trans_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }
        // echo $request->search_chalan_date_to;
        if (!empty($request->supplier_id)) {
            // dd($request->supplier_id);
            $query->where('so.supplier_no_pk', $request->supplier_id);
        }

        if (!empty($request->item_id)) {
            $query->where('so.item_no_fk', $request->item_id);
        }

        // dd($query->get()->toArray());
        return Template::loadview("admin.store.searchExpiredStockOutItem", [
            'allStockInTransactions' => $query->get()->toArray(),
        ]);
    }


    public function inventory_item_received_by_chalan()
    {

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        return Template::loadview("admin.store.inventory.item_received_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                ->where('module_no_fk', 18)
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                //->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_id'))
                ->orderBy('itemreceive_no_pk', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);
    }
    public function pharmacy_item_received_by_chalan()
    {

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->get();

        $prev_date = date('Y-m-d', strtotime('-7 days'));
        $today = date('Y-m-d');
        return Template::loadview("admin.store.item_received_by_chalan", [
            'received_by_chalan' => DB::table('PHR_ITEMRECEIVE_CHALLAN_VW')
                ->where('module_code', 'PHR')
                ->whereBetween('challan_date', [$prev_date, $today])
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('itemreceive_no_pk', 'desc')
                ->get()
                ->toArray(),
            'allSuppliers' => $allSuppliers,
        ]);
    }

    public function get_item_list_by_purchase_order(Request $request)
    {

        $purchase_order_id = $request->purchase_order_id;
        $purchase_item = DB::select("SELECT mst.vat_percent, mst.vat_amount, mst.discount_percent, mst.discount_amount,i.pr_uom_no_fk, i.pr_uom_conversion_qty ,i.pr_uom_tradeprice ,i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,i.pr_uom_name,i.pr_uom_no_fk,mst.supplier_no_fk,poc.entry_qty,
                poc.item_rate,i.expireable ,i.sales_price FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN SYSC_SERVICEITEM_VW i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                    LEFT JOIN  INV_PURCHASEORDER_MST mst on mst.PURCHASEORDER_NO_pk= poc.PURCHASEORDER_NO_FK
                     LEFT JOIN SYSC_MODULE mdl on mst.module_no_fk= mdl.module_no_pk
                 WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id
                and mdl.module_code = 'INVENTORY'
                 order by i.item_name asc");
        //dd(  $purchase_item);
        return $purchase_item;
    }
    public function pharmacy_get_item_list_by_purchase_order(Request $request)
    {

        $purchase_order_id = $request->purchase_order_id;
        $purchase_item = DB::select("SELECT mst.vat_percent, mst.vat_amount, mst.discount_percent, mst.discount_amount,poc.vat_percent_itm, poc.vat_amount_itm, poc.discount_percent_itm, poc.discount_amount_itm,i.pr_uom_no_fk, i.pr_uom_conversion_qty ,i.pr_uom_tradeprice ,i.item_no_pk,i.purchase_price,i.item_code, i.item_name, i.uom_no_fk,i.uom_name,i.pr_uom_name,i.pr_uom_no_fk,mst.supplier_no_fk,poc.entry_qty,
                poc.item_rate,i.expireable ,i.sales_price FROM INV_PURCHASEORDER_CHD poc
                LEFT JOIN SYSC_SERVICEITEM_VW i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
                    LEFT JOIN  INV_PURCHASEORDER_MST mst on mst.PURCHASEORDER_NO_pk= poc.PURCHASEORDER_NO_FK
                     LEFT JOIN SYSC_MODULE mdl on mst.module_no_fk= mdl.module_no_pk
                 WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id
                and mdl.module_code = 'PHR'
                 order by i.item_name asc");
        $return_amt = 0;

        if (!empty($purchase_item)) {
            $return_query = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(purchase_rate * Qty) as adjectment_amt'))->where('supplier_no_fk', $purchase_item[0]->supplier_no_fk)->first();
            $return_amt = $return_query->adjectment_amt;
        }
        // dd($return_amt , $purchase_item);
        return [$purchase_item,  $return_amt];
    }

    public function stock_ledger_list(Request $request)
    {
        $columns = array(
            'sl',
            'item_code',
            'pack_type',
            'item_name',
            'uom_name',
            'current_stock',
            'purchase_price',
            'sales_price',
            'status',
            'store_name',
            'item_no_fk',
            'supplier_name',
        );

        $sql = "SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name,ty.item_type_name from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk";
        // $sql = "SELECT '' as sl,item_code,pack_type,item_name,uom_name,current_stock,purchase_price,
        // sales_price,status,store_name,item_no_fk,
        // rownum rownumber,au_entry_at,au_update_at from stock_ledger_vw";
        $order_by_column = "item_no_fk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);
        echo json_encode($json_data);
    }
    public function search_stock_ledger_list(Request $request)
    {

        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        // dd( $module_code);
        $item_generic_id = $request->item_generic_id;

        $sql_cond = "where stock_ledger_vw.status=1";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause stock_ledger_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause stock_ledger_vw.module_code IN ($module_code)" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supp.supplier_no_pk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_generic_id != "") ? " $clause sys_gen.generic_no_pk = $item_generic_id" : "";

        if ($request->stock_type == "sufficient") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($request->stock_type != "") ? " $clause stock_ledger_vw.re_order_level < stock_ledger_vw.current_stock " : "";
        } elseif ($request->stock_type == "drug_running_low") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($request->stock_type != "") ? " $clause stock_ledger_vw.re_order_level > stock_ledger_vw.current_stock and stock_ledger_vw.current_stock != 0" : "";
        } elseif ($request->stock_type == "0_stock") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($request->stock_type != "") ? " $clause   stock_ledger_vw.current_stock = 0" : "";
        }



        // dd($sql_cond);
        // supp.supplier_no_pk,supp.supplier_name,
        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,stock_ledger_vw.supplier_name,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk , sys_gen.generic_name,stock_ledger_vw.re_order_level,stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major,ty.item_type_name,stock_ledger_vw.last_purchase_date,stock_ledger_vw.last_purchase_prise,stock_ledger_vw.last_purchase_qty
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk
            left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
              left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond order by stock_ledger_vw.item_name asc ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }
        // dd(array_sum($total_item) , array_sum($total_amt),  array_sum($total_sales_amt));
        // dd(   array_sum($total_item),$module_code,count( $stocks) ,$store_id );
        return Template::loadview("admin.store.stock_ledger_table_pharmacy", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function search_inv_stock_ledger_list(Request $request)
    {
        // dd("dd");
        // SERVICEUNIT_NO_FK
        // dd($request->sub_store_id, $request->store_id);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        if ($store_id != "" ||   $sub_store_id != "") {
            $minor_group = $request->minor_group != "" ? 'and ser.itemtype_no_fk =' . $request->minor_group : '';
        } else {
            $minor_group = $request->minor_group != "" ? 'where ser.itemtype_no_fk =' . $request->minor_group : '';
        }


        if (isset($sub_store_id)) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk , stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc");
        }
        if (isset($store_id)) {

            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
                stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk , stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
                from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
                 left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }

        if (isset($sub_store_id) && $store_id) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,stock_ledger_vw.par_item_type_name_major,stock_ledger_vw.par_itemtype_code_major, supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level, ty.item_type_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no left join sysc_itemtype ty on ty.itemtype_no_pk = ser.itemtype_no_fk
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.serviceunit_no_fk and $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }
        // dd($stocks);
        return Template::loadview("admin.store.stock_ledger_table", ['stocks' => $stocks,'store_id' => $store_id, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }


    public function search_inv_bin_card_list(Request $request)
    {
        // SERVICEUNIT_NO_FK
        // dd($request->sub_store_id, $request->store_id);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        if ($store_id != "" ||   $sub_store_id != "") {
            $minor_group = $request->minor_group != "" ? 'and ser.itemtype_no_fk =' . $request->minor_group : '';
        } else {
            $minor_group = $request->minor_group != "" ? 'where ser.itemtype_no_fk =' . $request->minor_group : '';
        }


        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($item_id != "") ? " $clause stock_ledger_vw.item_no_fk = $item_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $store_id" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($sub_store_id != "") ? " $clause ser.serviceunit_no_fk = $sub_store_id" : "";
        // $bar = ($foo == 1) ? "1" : (($foo == 2)  ? "2" : "other");
        // $sql_cond .= ($sub_store_id != "") ? " $clause stock_ledger_vw.serviceunit_no_fk = $sub_store_id" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($supplier_id != "") ? " $clause supp.supplier_no_pk = $supplier_id" : "";
        // dd( $sql_cond);
        $columns = array(
            'sl',
            'item_code',
            'pack_type',
            'item_name',
            'uom_name',
            'current_stock',
            'purchase_price',
            'sales_price',
            'status',
            'store_name',
            'item_no_fk',
        );

        // $sql = "SELECT '' as sl,item_code,pack_type,item_name,uom_name,current_stock,purchase_price,
        //     sales_price,status,store_name,item_no_fk,
        //     rownum rownumber,au_entry_at,au_update_at from stock_ledger_vw $sql_cond";


        // echo "SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        // stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name
        // from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
        //  left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond";

        // $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        // stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name
        // from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
        //  left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond order by stock_ledger_vw.item_name asc ");


        if (isset($sub_store_id)) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }
        if (isset($store_id)) {

            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
                stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level
                from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
                 left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }

        if (isset($sub_store_id) && $store_id) {
            $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name,ser.re_order_level
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk where $sub_store_id = stock_ledger_vw.serviceunit_no_fk and $store_id = stock_ledger_vw.stock_su_no_fk $minor_group order by stock_ledger_vw.item_name asc ");
        }


        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }
        // dd(   $sql_cond);
        return Template::loadview("admin.store.bin_card_table", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function search_inv_stock_ledger_list_subStore(Request $request)
    {
        //  dd($request->module_code);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause stock_ledger_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supp.supplier_no_pk = $supplier_id" : "";
        // dd( $sql_cond);
        $columns = array(
            'sl',
            'item_code',
            'pack_type',
            'item_name',
            'uom_name',
            'current_stock',
            'purchase_price',
            'sales_price',
            'status',
            'store_name',
            'item_no_fk',
        );

        $sql = "SELECT '' as sl,item_code,pack_type,item_name,uom_name,current_stock,purchase_price,
            sales_price,status,store_name,item_no_fk,
            rownum rownumber,au_entry_at,au_update_at from stock_ledger_vw $sql_cond";


        // echo "SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        // stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name
        // from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
        //  left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond";
        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond order by stock_ledger_vw.item_name asc ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }
        // dd(   $sql_cond);
        return Template::loadview("admin.store.stock_ledger_table_subStore", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }


    public function search_subStore_stock_all(Request $request)
    {
        //  dd($request->all());

        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        $all_sub_store_ind = $request->all_sub_store_ind;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause stock_ledger_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause stock_ledger_vw.stock_su_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause supp.supplier_no_pk = $supplier_id" : "";
        // $sql_cond .= " $clause stock_ledger_vw.current_stock > 0 ";

        $sub_store = DB::select("select u.serviceunit_no_pk  from  sysc_serviceunit u  where  nvl(u.main_store_ind, 0) = 0 and nvl(u.sub_store_ind, 0) = 1");

        if ($all_sub_store_ind == 1) {
            $sub_store_ids = array_column($sub_store, 'serviceunit_no_pk');
            $sql_cond = ""; 
            $clause = "WHERE";
            // $sql_cond .= " $clause stock_ledger_vw.current_stock > 0 ";

            $sql_cond = " $clause stock_ledger_vw.stock_su_no_fk IN (" . implode(',', $sub_store_ids) . ") AND stock_ledger_vw.current_stock > 0";
        }

        // dd( $sql_cond);


        $columns = array(
            'sl',
            'item_code',
            'pack_type',
            'item_name',
            'uom_name',
            'current_stock',
            'purchase_price',
            'sales_price',
            'status',
            'store_name',
            'item_no_fk',
        );

        $sql = "SELECT '' as sl,item_code,pack_type,item_name,uom_name,current_stock,purchase_price,
            sales_price,status,store_name,item_no_fk,
            rownum rownumber,au_entry_at,au_update_at from stock_ledger_vw $sql_cond";

            // if ($all_sub_store_ind == 1) {
            //     $sql_cond = ""; 
            // }

            // if ($all_sub_store_ind == 1) {
            //     $sql_cond .= " $clause stock_ledger_vw.current_stock > 0 ";
            // }

        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
            stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk ,supp.supplier_no_pk,supp.supplier_name, sys_gen.generic_name
            from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.supplier_pk_no
             left join SYSC_GENERIC sys_gen  on ser.generic_no_fk = sys_gen.generic_no_pk $sql_cond order by stock_ledger_vw.store_name, stock_ledger_vw.item_name asc ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }
        //  dd(   $sql_cond);
        return Template::loadview("admin.store.stock_ledger_table_all", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function search_grn_receive_report_main_store(Request $request)
    {
        //  dd($request->module_code);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause phr_v1_grn_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause phr_v1_grn_vw.store_su_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause phr_v1_grn_vw.store_su_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause phr_v1_grn_vw.supplier_no_fk = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" && $to_date != "") ? " $clause trunc(phr_v1_grn_vw.receive_date) between '$from_date' and '$to_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date && $to_date == "") ? " $clause trunc(phr_v1_grn_vw.receive_date)='$from_date' " : "";


        $stocks = DB::select("SELECT phr_v1_grn_vw.* , SYSC_SERVICEITEM_UOM.UOM_CODE
            from phr_v1_grn_vw left join sysc_serviceitem_uom on sysc_serviceitem_uom.uom_no_pk= phr_v1_grn_vw.uom  $sql_cond order by phr_v1_grn_vw.itemreceive_no_pk desc ");
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        return Template::loadview("admin.store.table_stock_ledger_table_subStore", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }
    public function search_item_issue_report_main_store(Request $request)
    {
        //  dd($request->module_code);
        $item_id = $request->item_id;
        $store_id = $request->store_id;
        $sub_store_id = $request->sub_store_id;
        $supplier_id = $request->supplier_id;
        $module_code = $request->module_code;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date)) : '';

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_id != "") ? " $clause inv_requisition_itm_vw.item_no_fk = $item_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($store_id != "") ? " $clause inv_requisition_itm_vw.to_store_no_fk = $store_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($sub_store_id != "") ? " $clause inv_requisition_itm_vw.to_store_no_fk = $sub_store_id" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($module_code != "") ? " $clause nvl(stock_ledger_vw.module_code,'PHR') = '$module_code'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause inv_requisition_itm_vw.supplier_pk_no = $supplier_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "" && $to_date != "") ? " $clause trunc(inv_requisition_itm_vw.issue_at) between '$from_date' and '$to_date'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date && $to_date == "") ? " $clause trunc(inv_requisition_itm_vw.issue_at)='$from_date' " : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= " $clause issue_ind= 1 ";


        $stocks = DB::select("SELECT inv_requisition_itm_vw.* , sysc_serviceitem_uom.uom_code
            from inv_requisition_itm_vw left join sysc_serviceitem_uom on sysc_serviceitem_uom.uom_no_pk= inv_requisition_itm_vw.uom_no_fk  $sql_cond order by inv_requisition_itm_vw.issue_at desc ");
        // dd( $stocks );
        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        return Template::loadview("admin.store.item_issue_report_store_list", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function filtter_stock_ledger_list(Request $request)
    {
        dd("ddd");
        $id = $request->id;


        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        if ($id == "sufficient") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond = ($id != "") ? " $clause stock_ledger_vw.re_order_level < stock_ledger_vw.current_stock " : "";
        } elseif ($id == "drug_running_low") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond = ($id != "") ? " $clause stock_ledger_vw.re_order_level > stock_ledger_vw.current_stock and stock_ledger_vw.current_stock != 0" : "";
        } elseif ($id == "0_stock") {
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond = ($id != "") ? " $clause   stock_ledger_vw.current_stock = 0" : "";
        }


        $stocks = DB::select("SELECT '' as sl,stock_ledger_vw.item_code,stock_ledger_vw.item_no_fk,stock_ledger_vw.pack_type,stock_ledger_vw.item_name,stock_ledger_vw.uom_name,stock_ledger_vw.current_stock,stock_ledger_vw.purchase_price,
        stock_ledger_vw.sales_price,stock_ledger_vw.store_name,stock_ledger_vw.status,stock_ledger_vw.item_no_fk,stock_ledger_vw.au_entry_at,stock_ledger_vw.au_update_at,stock_ledger_vw.opening_qty,stock_ledger_vw.stock_su_no_fk,supp.supplier_name ,sys_gen.generic_name from stock_ledger_vw left join sysc_serviceitem ser on ser.item_no_pk = stock_ledger_vw.item_no_fk left join inv_supplier supp on supp.supplier_no_pk = ser.manufacturer_no_fk  left join SYSC_GENERIC sys_gen  on ser.generic_no_fk  =  sys_gen.generic_no_pk   where stock_ledger_vw.au_entry_hospital_pk_no = $hospital_id and nvl(stock_ledger_vw.module_code,'PHR') = 'PHR'
        and stock_ledger_vw.status=1 $sql_cond order by stock_ledger_vw.item_name ASC
        ");

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];
        if (!empty($stocks)) {
            foreach ($stocks as $key => $value) {
                if ($value->current_stock > 0) {
                    $total_item[] = $value->current_stock;
                    $total_amt[] = $value->current_stock * $value->purchase_price;
                    $total_sales_amt[] = $value->current_stock * $value->sales_price;
                }
            }
        }



        return Template::loadview("admin.store.stock_ledger_table", ['stocks' => $stocks, 'total_item' => $total_item, 'total_amt' => $total_amt, 'total_sales_amt' => $total_sales_amt]);
    }

    public function stock_adjustment()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->orWhere('sub_store_ind',1)
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $uom = $this->getLookupListByCode("UOM");

        return Template::loadView("admin.store.inventory.stock_adjustment", ['supplier_arr' => $supplier_arr, 'stores' => $stores, 'uom' => $uom]);
    }
    public function stock_adjustment_sub_main()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $main_stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->get();
        $sub_stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $uom = $this->getLookupListByCode("UOM");

        return Template::loadView("admin.store.inventory.stock_adjustment_sub_main", ['supplier_arr' => $supplier_arr, 'main_stores' => $main_stores, 'sub_stores' => $sub_stores, 'uom' => $uom]);
    }
    public function pharmacy_stock_adjustment()
    {
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('PHARMACY_IND', '=', 1)
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $uom = $this->getLookupListByCode("UOM");

        return Template::loadView("admin.store.stock_adjustment", ['supplier_arr' => $supplier_arr, 'stores' => $stores, 'uom' => $uom]);
    }
    public function store_stock_adjustment(Request $request)
    {
        //dd($request->all());
        try {

            $chalan_date = date('Y-m-d');
            if (!empty($request->date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);  // define date format from user
                $chalan_date = $dateTime->format('Y-m-d'); // define expected format
            }
            $chalan_no = isset($request->challan_no) ? strval($request->challan_no) : ''; //strval()
            $store_su_no_fk = isset($request->store_id) ? $request->store_id : 0;
            $from_store_su_no_fk = isset($request->store_from) ? $request->store_from : 0;
            $po_no = isset($request->in_purchaseorder_no_fk) ? strval($request->in_purchaseorder_no_fk) : '0';
            $supplier_no_fk = isset($request->supplier_id) ? $request->supplier_id : 0;
            $module_code = isset($request->module_code) ? $request->module_code : 0;
            $in_module_no_fk = 0;
            $module_info = DB::table('sysc_module')->where('module_code', $module_code)->first();
            if (isset($module_info->module_no_pk)) {
                $in_module_no_fk =  $module_info->module_no_pk;
            }
            // dd($from_store_su_no_fk ,$store_su_no_fk , $request->stock_type);
            $stock_type = $request->stock_type;
            $item_pk_no = [];
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $service_unit = [];
            $hdn_single_quantity = [];
            $item_uom_phur = [];
            $phur_qty = [];
            $demand_no_fk = 1;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';

            if (!empty($request->item_ids)) {
                for ($i = 0; $i < count($request->item_ids); $i++) {
                    if ($request->item_quantities[$i] != null) {
                        $item_pk_no[$i] = isset($request->item_ids[$i]) ? $request->item_ids[$i] : 0;
                        $item_pvms[$i] = $null;
                        $item_uom[$i] =  0;
                        $item_uom_phur[$i] = isset($request->item_uoms[$i]) ? $request->item_uoms[$i] : 0;
                        $hdn_single_quantity[$i] = $request->hdn_single_quantity[$i];
                        $service_unit[$i] = DB::table('sysc_serviceitem')->select('pr_uom_conversion_qty')->where('item_no_pk', $item_pk_no[$i])->where('pr_uom_no_fk', $item_uom_phur[$i])->first();
                        $phur_qty = !empty($service_unit[$i]) ? $service_unit[$i]->pr_uom_conversion_qty : 1;
                        $item_qty[$i] = isset($request->item_quantities[$i]) ? ($request->item_quantities[$i] *  $phur_qty) +  $hdn_single_quantity[$i] : 0;

                        $item_price[$i] = isset($request->item_prices[$i]) ? $request->item_prices[$i] : 0;
                        $item_entry_dtl[$i] = $i + 1;
                        $empty_arr[$i] = '';
                    } else {
                        $item_pk_no[$i] = isset($request->item_ids[$i]) ? $request->item_ids[$i] : 0;
                        $item_pvms[$i] = $null;
                        $item_uom[$i] =  0;
                        // $item_uom_phur[$i] = isset($request->item_uoms[$i]) ? $request->item_uoms[$i]: 0;
                        $hdn_single_quantity[$i] = $request->hdn_single_quantity[$i];
                        // $service_unit[$i]=DB::table('sysc_serviceitem')->select('pr_uom_conversion_qty')->where('item_no_pk',$item_pk_no[$i])->where('pr_uom_no_fk',$item_uom_phur[$i])->first();
                        // $phur_qty= !empty($service_unit[$i]) ? $service_unit[$i]->pr_uom_conversion_qty : 1;
                        $item_qty[$i] = isset($hdn_single_quantity[$i]) ?  $hdn_single_quantity[$i] : 0;

                        $item_price[$i] = isset($request->item_prices[$i]) ? $request->item_prices[$i] : 0;
                        $item_entry_dtl[$i] = $i + 1;
                        $empty_arr[$i] = '';
                    }
                }
            }
            // isset($request->item_uoms[$i]) ? $request->item_uoms[$i] :
            // dd($item_qty);
            $pdo = DB::getPdo();

            //Stock In

            if ($stock_type === "TRANSFER") {
                $transferIn = 'TRANSIN';

                $stock_adjustment = $pdo->prepare("begin
                    pkg_pharmacy.prc_transactioninout(
                    :in_challan_no,
                    :in_challan_date,
                    :in_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_module_no_fk,
                    :in_a_item_no_fk,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
                $stock_adjustment->bindparam('in_challan_no', $chalan_no);
                $stock_adjustment->bindparam('in_challan_date', $chalan_date);
                $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
                $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
                $stock_adjustment->bindparam('in_po_no', $po_no);
                $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);

                $stock_adjustment->bindparam('in_transtype', $transferIn);
                $stock_adjustment->bindparam('in_module_no_fk', $in_module_no_fk);
                $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
                $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

                $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
                $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
                $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

                $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

                $stock_adjustment->execute();
            }

            //Stock out

            if ($stock_type === "TRANSFER") {
                $transferOut = 'TRANSOUT';
                $stock_adjustment = $pdo->prepare("begin
                    pkg_pharmacy.prc_transactioninout(
                    :in_challan_no,
                    :in_challan_date,
                    :in_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_module_no_fk,
                    :in_a_item_no_fk,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
                $stock_adjustment->bindparam('in_challan_no', $chalan_no);
                $stock_adjustment->bindparam('in_challan_date', $chalan_date);
                $stock_adjustment->bindparam('in_store_su_no_fk', $from_store_su_no_fk);
                $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
                $stock_adjustment->bindparam('in_po_no', $po_no);
                $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);

                $stock_adjustment->bindparam('in_transtype', $transferOut);
                $stock_adjustment->bindparam('in_module_no_fk', $in_module_no_fk);
                $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
                $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

                $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
                $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
                $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

                $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

                $stock_adjustment->execute();
            } else {


                $stock_adjustment = $pdo->prepare("begin
                    pkg_pharmacy.prc_transactioninout(
                    :in_challan_no,
                    :in_challan_date,
                    :in_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_module_no_fk,
                    :in_a_item_no_fk,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
                $stock_adjustment->bindparam('in_challan_no', $chalan_no);
                $stock_adjustment->bindparam('in_challan_date', $chalan_date);
                $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
                $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
                $stock_adjustment->bindparam('in_po_no', $po_no);
                $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);

                $stock_adjustment->bindparam('in_transtype', $stock_type);
                $stock_adjustment->bindparam('in_module_no_fk', $in_module_no_fk);
                $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
                $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_INT);
                $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

                $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
                $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
                $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

                $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

                $stock_adjustment->execute();
            }

            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function item_return_worklist()
    {
        $item_return = DB::table('phr_receive_return_wl_vw')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('challan_date', "DESC")->get(); //->orderBy('ITEMRECEIVE_NO_PK', "DESC")
        return Template::loadView("admin.store.item_return_worklist", ['item_return' => $item_return]);
    }
    public function item_return_by_challan_popup($id)
    {
        $item_list = DB::table('phr_itemreceive_item_vw')->where('ITEMRECEIVE_NO_PK', $id)->get();
        return Template::loadView("admin.store.item_return_by_challan_popup", ['item_list' => $item_list]);
    }

    public function serach_return_item(Request $request)
    {

        $query = DB::table('phr_receive_return_wl_vw')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'));

        if (!empty($request->search_chalan_no)) {
            $query->where('challan_no', 'like', '%' . $request->search_chalan_no . '%');
        }
        if (!empty($request->po_data)) {
            $query->where('po_no', $request->po_data);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if (!empty($request->search_chalan_date_from) && !empty($request->search_chalan_date_to)) {
            $query->where('challan_date', '>=', date('Y-m-d', strtotime($request->search_chalan_date_from)));
            $query->where('challan_date', '<=', date('Y-m-d', strtotime($request->search_chalan_date_to)));
        }

        return Template::loadView('admin.store.item_return_list_table', ['item_return' => $query->get()->toArray()]);
    }
    public function item_po_issue_finalize(Request $request)
    {
        try {
            if ($request->issue_finalize_ind == "finalize") {
                if (!empty($request->purchase_order_pk_no)) {
                    for ($i = 0; $i < count($request->purchase_order_pk_no); $i++) {
                        $purchase_order = PurchaseOrderMaster::find($request->purchase_order_pk_no[$i]);
                        $purchase_order->finalized_ind = 1;
                        $purchase_order->finalized_by = Auth::id();
                        $purchase_order->finalized_at = date('Y/m/d');
                        $purchase_order->au_entry_hospital_no_fk = Session::get('user.ses_hospital_no_pk');
                        $purchase_order->save();
                    }
                    $message = ['msg' => 'PO Finalized Successfully', 'title' => 'Success'];
                }
            }
            if ($request->issue_finalize_ind == "issue") {
                if (!empty($request->purchase_order_pk_no)) {
                    for ($i = 0; $i < count($request->purchase_order_pk_no); $i++) {
                        $purchase_order = PurchaseOrderMaster::find($request->purchase_order_pk_no[$i]);
                        $purchase_order->finalized_ind = 1;
                        $purchase_order->finalized_by = Auth::id();
                        $purchase_order->finalized_at = date('Y/m/d');
                        $purchase_order->au_entry_hospital_no_fk = Session::get('user.ses_hospital_no_pk');
                        $purchase_order->issue_ind = 1;
                        $purchase_order->issue_by = Auth::id();
                        $purchase_order->issue_at = date('Y/m/d');
                        $purchase_order->save();
                    }
                    $message = ['msg' => 'PO Issued Successfully', 'title' => 'Success'];
                }
            }
        } catch (\Exception $e) {
            $message = ['msg' => 'PO Finalize Failed', 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function item_finalize_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['finalized_ind', '=', 1],
            ['issue_ind', '=', 0],
            ['module_code', '=', 'PHR'],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')],
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();
        //dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.item_finalize_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function inventory_item_finalize_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['finalized_ind', '=', 1],
            ['issue_ind', '=', 0],
            ['module_no_fk', '=', 18],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')],
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();
        //dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.inventory.item_finalize_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function item_issue_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['issue_ind', '=', 1],
            ['module_code', '=', 'PHR'],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')]
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();
        //dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.item_issue_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function inventory_item_issue_po_worklist()
    {
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $stores = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            ->where('PHARMACY_IND', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $all_purchased_orders_worklists = DB::table('inv_po_wl_vw')->where([
            ['issue_ind', '=', 1],
            ['module_no_fk', '=', 18],
            ['au_entry_hospital_no_fk', '=', Session::get('user.ses_hospital_no_pk')]
        ])->orderBy('purchaseorder_no_pk', 'desc')->get();
        //dd($all_purchased_orders_worklists);
        return Template::loadview("admin.store.inventory.item_issue_po_worklist", [
            'all_purchased_orders_worklists' => $all_purchased_orders_worklists,
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,

        ]);
    }
    public function item_reorder_level_worklist()
    {
        $item_reorder_level_arr = DB::table('phr_item_reorder_level_vw')->get(); //->orderBy('ITEMRECEIVE_NO_PK', "DESC")
        return Template::loadView("admin.store.item_reorder_worklist", ['item_reorder_level_arr' => $item_reorder_level_arr]);
    }
    public function search_po_worklist(Request $request)
    {
        $query = DB::table('inv_po_wl_vw');

        if (!empty($request->challan_no)) {
            $query->where('purchase_uid', $request->challan_no);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if ($request->type == 1) {
            $query->where([
                ['finalized_ind', '=', 0],
                ['issue_ind', '=', 0],
                ['module_code', '=', 'INVENTORY']
            ]);
            return Template::loadview("admin.store.inventory.item_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        } else if ($request->type == 2) {
            $query->where([
                ['finalized_ind', '=', 1],
                ['issue_ind', '=', 0],
                ['module_code', '=', 'INVENTORY']
            ]);

            return Template::loadview("admin.store.inventory.item_finalize_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        } else if ($request->type == 3) {
            $query->where([
                ['finalized_ind', '=', 1],
                ['issue_ind', '=', 1],
                ['module_code', '=', 'INVENTORY']
            ]);
            return Template::loadview("admin.store.inventory.item_issue_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        }
    }

    public function pharmacy_search_po_worklist(Request $request)
    {
        $query = DB::table('inv_po_wl_vw');

        if (!empty($request->challan_no)) {
            $query->where('purchase_uid', $request->challan_no);
        }
        if (!empty($request->supplier_id)) {
            $query->where('supplier_no_fk', $request->supplier_id);
        }
        if ($request->type == 1) {
            $query->where([
                ['finalized_ind', '=', 0],
                ['issue_ind', '=', 0],
                ['module_code', '=', 'PHR']
            ]);
            return Template::loadview("admin.store.item_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        } else if ($request->type == 2) {
            $query->where([
                ['finalized_ind', '=', 1],
                ['issue_ind', '=', 0],
                ['module_code', '=', 'PHR']
            ]);

            return Template::loadview("admin.store.item_finalize_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        } else if ($request->type == 3) {
            $query->where([
                ['finalized_ind', '=', 1],
                ['issue_ind', '=', 1],
                ['module_code', '=', 'PHR']
            ]);
            return Template::loadview("admin.store.item_issue_po_worklist_table", [
                'all_purchased_orders_worklists' => $query->get()->toArray(),
            ]);
        }
    }

    public function grnReport($id, $type = '')
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $grn_report_list = DB::select(DB::raw("select * from PHR_GRN_VW where itemreceive_no_pk = $id order by item_name ASC"));

        $adj_amt = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(adj_amount) as adj_amount'))->where('itemreceive_no_fk', $id)->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();

        $grn_barcode = '';
        if (!empty($grn_report_list)) {
            $grn_barcode = $grn_report_list[0]->itemreceive_no_pk;
        }




        $title = $grn_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.grn_report', [
            'po_hospital_details' => $po_hospital_details,
            'grn_barcode' => $grn_barcode,
            'grn_barcode_no' => $barcode_no,
            'grn_report_list' => $grn_report_list,
            'type' => $type,
            'userInfo' => $userInfo,
            'adj_amt' => $adj_amt,
            'return_adj_amt' => $return_adj_amt

        ]);
        // $html = PDF::loadView('admin.store.grn_report', [
        //     'po_hospital_details' => $po_hospital_details,
        //     'grn_barcode' => $grn_barcode,
        //     'grn_barcode_no' => $barcode_no,
        //     'grn_report_list' => $grn_report_list,

        // ])->render();
        return $pdf->stream('GRN-report.pdf');
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }
    public function grnReportInvVat($id, $type = '')
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $grn_report_list = DB::select(DB::raw("select * from PHR_GRN_VW where itemreceive_no_pk = $id order by item_name ASC"));

        $adj_amt = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(adj_amount) as adj_amount'))->where('itemreceive_no_fk', $id)->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();

        $grn_barcode = '';
        if (!empty($grn_report_list)) {
            $grn_barcode = $grn_report_list[0]->itemreceive_no_pk;
        }




        $title = $grn_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.grn_report_inv_vat', [
            'po_hospital_details' => $po_hospital_details,
            'grn_barcode' => $grn_barcode,
            'grn_barcode_no' => $barcode_no,
            'grn_report_list' => $grn_report_list,
            'type' => $type,
            'userInfo' => $userInfo,
            'adj_amt' => $adj_amt,
            'return_adj_amt' => $return_adj_amt

        ]);
        // $html = PDF::loadView('admin.store.grn_report', [
        //     'po_hospital_details' => $po_hospital_details,
        //     'grn_barcode' => $grn_barcode,
        //     'grn_barcode_no' => $barcode_no,
        //     'grn_report_list' => $grn_report_list,

        // ])->render();
        return $pdf->stream('GRN-report.pdf');
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }
    public function phrGrnReport($id, $type = '')
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $grn_report_list = DB::select(DB::raw("select supplier_name,po_no,delivery_location,challan_date,item_name,order_qty,pr_uom_conversion_qty,pr_uom_name,freeitem_qty,free_uom_name,uom_name,unit_price,delivered_qty,itemreceive_no_pk,discount_amount,discount_percent,vat_amount,vat_percent from PHR_GRN_VW where itemreceive_no_pk = $id order by item_name ASC"));

        $grn_barcode = '';
        if (!empty($grn_report_list)) {
            $grn_barcode = $grn_report_list[0]->itemreceive_no_pk;
        }

        $adj_amt = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(adj_amount) as adj_amount'))->where('itemreceive_no_fk', $id)->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();


        $title = $grn_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.pharmacy.grn_report', [
            'po_hospital_details' => $po_hospital_details,
            'grn_barcode' => $grn_barcode,
            'grn_barcode_no' => $barcode_no,
            'grn_report_list' => $grn_report_list,
            'type' => $type,
            'userInfo' => $userInfo,
            'adj_amt' => $adj_amt,
            'return_adj_amt' => $return_adj_amt

        ]);
        return $pdf->stream('GRN-report.pdf');
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }
    public function grnReportVat($id, $type = '')
    {

        ini_set("max_execution_time", 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $grn_report_list = DB::select(DB::raw("select * from PHR_GRN_VW where itemreceive_no_pk = $id order by item_name ASC"));
        // dd($grn_report_list);
        $grn_barcode = '';
        if (!empty($grn_report_list)) {
            $grn_barcode = $grn_report_list[0]->itemreceive_no_pk;
        }


        $adj_amt = DB::table('phr_expire_medicine_return')->select(DB::raw('sum(adj_amount) as adj_amount'))->where('itemreceive_no_fk', $id)->first();
        $return_adj_amt = DB::table('supplier_med_return_adj')->where('itemreceive_no_fk', $id)->first();

        $title = $grn_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = PDF::loadView('admin.store.grn_report_vat', [
            'po_hospital_details' => $po_hospital_details,
            'grn_barcode' => $grn_barcode,
            'grn_barcode_no' => $barcode_no,
            'grn_report_list' => $grn_report_list,
            'type' => $type,
            'userInfo' => $userInfo,
            'adj_amt' => $adj_amt,
            'return_adj_amt' => $return_adj_amt

        ]);
        // $html = PDF::loadView('admin.store.grn_report', [
        //     'po_hospital_details' => $po_hospital_details,
        //     'grn_barcode' => $grn_barcode,
        //     'grn_barcode_no' => $barcode_no,
        //     'grn_report_list' => $grn_report_list,

        // ])->render();
        return $pdf->stream('GRN-report.pdf');
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }
    public function populateDefaultItems(Request $request)
    {
        $purchaseItem = DB::table('default_item_stock_vw')
            ->whereIn('item_no_pk', $request->item_no_pk)
            ->get();

        return response()->json($purchaseItem);
    }
    public function populateDefaultItemsFromLastPurchase(Request $request)
    {
        $purchase_order = implode(",", $request->purchase_order);
        $purchaseItem = DB::table('inv_purchaseorder_item_vw')
            ->whereIn('purchaseorder_no_pk', $request->purchase_order)
            ->get();
        return response()->json($purchaseItem);
    }
    public function filterDefaultSupplierItems(Request $request)
    {
        //Note
        // Type = 1 for Below reorder level
        // Type = 2 for All
        if ($request->type == 1) {
            $items = DB::table('default_item_stock_vw')
                ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
                ->where('supplier_pk_no',  $request->supplier_id)
                ->whereRaw('current_stock <=re_order_level')
                ->orderBy('item_name', 'asc')
                ->get();
        }
        if ($request->type == 2) {
            $items = DB::table('default_item_stock_vw')
                ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
                ->where('supplier_pk_no',  $request->supplier_id)
                ->orderBy('item_name', 'asc')
                ->get();
        }

        return Template::loadview('admin.store.default_items_table', [
            'items' => $items,
        ]);
    }

    public function item_po_edit($purchase_order_id)
    {
        $po_child_details_info = DB::select(DB::raw("SELECT *
            FROM INV_PURCHASEORDER_CHD poc
            LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
            WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order By poc.purchaseorderdtl_no_pk"));
        //dd($po_child_details_info);

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
            FROM INV_PURCHASEORDER_MST pom
            LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
            WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];
        // dd($po_master_info);
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        $terms = DB::table("inv_purchaseorder_terms")->where("purchaseorder_no_fk", $purchase_order_id)->get();
        // dd($terms);
        $terms_arr = [];
        if (!empty($terms)) {
            foreach ($terms as $t) {
                $terms_arr[$t->sl] = $t->sl;
            }
        }
        $poTerms =  $this->getLookupListByCode("INV_POTERMS");
        //


        //dd($poTerms);

        return Template::loadview('admin.store.inventory.create_po_form', [
            'po_child_details_info' => $po_child_details_info,
            'supplier_arr' => $supplier_arr,
            'poTerms' => $poTerms,
            'po_master_info' => $po_master_info,
            'terms' => $terms,
            'terms_arr' => $terms_arr,
        ]);
    }
    public function pharmacy_item_po_edit($purchase_order_id)
    {
        $po_child_details_info = DB::select(DB::raw("SELECT *
            FROM INV_PURCHASEORDER_CHD poc
            LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
            WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order By poc.purchaseorderdtl_no_pk"));
        //dd($po_child_details_info);

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
            FROM INV_PURCHASEORDER_MST pom
            LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
            WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];
        // dd($po_master_info);
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");

        return Template::loadview('admin.store.create_po_form', [
            'po_child_details_info' => $po_child_details_info,
            'supplier_arr' => $supplier_arr,
            'poTerms' => $poTerms,
            'po_master_info' => $po_master_info
        ]);
    }
    public function pharmacy_item_po_edit_vat($purchase_order_id)
    {
        $po_child_details_info = DB::select(DB::raw("SELECT *
            FROM INV_PURCHASEORDER_CHD poc
            LEFT JOIN sysc_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
            WHERE poc.PURCHASEORDER_NO_FK = $purchase_order_id order By poc.purchaseorderdtl_no_pk"));
        //dd($po_child_details_info);

        $po_master_info = DB::select(DB::raw("SELECT s.*, pom.*
            FROM INV_PURCHASEORDER_MST pom
            LEFT JOIN INV_SUPPLIER s ON pom.SUPPLIER_NO_FK = s.SUPPLIER_NO_PK
            WHERE pom.PURCHASEORDER_NO_PK = $purchase_order_id"))[0];
        // dd($po_master_info);
        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }

        $poTerms =  $this->getLookupListByCode("PHR_POTERMS");

        return Template::loadview('admin.store.create_po_form_vat', [
            'po_child_details_info' => $po_child_details_info,
            'supplier_arr' => $supplier_arr,
            'poTerms' => $poTerms,
            'po_master_info' => $po_master_info
        ]);
    }

    public function deletePo(Request $request)
    {
        $po_id = $request->po_id;

        try {
            DB::table('inv_purchaseorder_chd')->where('purchaseorder_no_fk', $po_id)->delete();
            DB::table('inv_purchaseorder_terms')->where('purchaseorder_no_fk', $po_id)->delete();
            DB::table('inv_purchaseorder_mst')->where('purchaseorder_no_pk', $po_id)->delete();

            $message = ['msg' => '000'];
        } catch (\Exception $e) {
            $message = ['msg' => '999'];
        }
        return response()->json($message);
    }
    // Stock Adjustment
    public function stockAdjustmentIndex()
    {
        return Template::loadview('admin.store.stock_adjustment_report.index');
    }


    // public function stockAdjustmentList(Request $request)
    // {
    //     $table = 'INV_DAMAGE_ITEM_EXPIRE_ISSUE_VW';
    //     $primaryKey = 'STOCKTRANS_NO_PK';
    //     $columns = array(
    //         array('db' => 'stocktrans_no_pk', 'dt' => 0),
    //         array('db' => 'transref_date', 'dt' => 1),
    //         array('db' => 'transref_no', 'dt' => 2),
    //         array('db' => 'trans_type_iss_rcv', 'dt' => 3),
    //         array('db' => 'supplier_name', 'dt' => 4),
    //         array('db' => 'item_name', 'dt' => 5),
    //         array('db' => 'item_qty', 'dt' => 6),
    //         array('db' => 'item_rate', 'dt' => 7),
    //         // array('db' => 'stocktrans_no_pk', 'dt' => 8),
    //     );
    //     echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
    // }

    public function stockAdjustmentPdf(Request $request)
    {
        $type = $request->type;
        $issue = '';
        $damage = '';
        $expire = '';
        if ($type == 1) {
            $issue =   $type;
        } elseif ($type == 2) {
            $damage = $type;
        } elseif ($type == 3) {
            $expire = $type;
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = "Date Cashier Wise Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to)) : "";
        $stockDatas = DB::table('INV_DAMAGE_ITEM_EXPIRE_ISSUE_VW')
            ->whereBetween(DB::raw("trunc(transref_date)"), [$date_from, $date_to]);
        if ($issue != '') {
            $stockDatas->where('trans_type_iss_rcv', 'ISSUE');
        };
        if ($damage != '') {
            $stockDatas->where('trans_type_iss_rcv', 'DAMAGE');
        }
        if ($expire != '') {
            $stockDatas->where('trans_type_iss_rcv', 'EXPIRED');
        };

        $stockData = $stockDatas->get();

        $pdf = PDF::loadView("admin.store.stock_adjustment_report.stock_adjustment_report_pdf", compact('po_hospital_details', 'barcode_no', 'date_from', 'date_to', 'stockData'))->setPaper('a4', 'portrait');
        return $pdf->stream('stock_adjustment_report.pdf');
        //  $pdf = PDF::loadView("admin.reports.date_cashier_wise_report_print", ['cashier_arr' => $cashier_arr, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details]);
        // return $pdf->download('date-cashier-wise-report.pdf');
    }
    public function stockAdjustmentsearch(Request $request)
    {
        $type = $request->type;
        $issue = '';
        $damage = '';
        $expire = '';
        if ($type == 1) {
            $issue =   $type;
        } elseif ($type == 2) {
            $damage = $type;
        } elseif ($type == 3) {
            $expire = $type;
        }
        // dd(  $type, $issue,  $damage , $expire );
        // $issue = $request->issue;
        // $damage = $request->damage ;
        // $expire = $request->expire;
        $date_from = $request->date_from ? date('Y/m/d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y/m/d', strtotime($request->date_to . '+ 1 Days')) : "";

        // dd($issue,$damage,$expire,$date_from,$date_to);

        $sql_cond = "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause transref_date between '$date_from' and '$date_to' " : "";


        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $issue != "" ? " $clause trans_type_iss_rcv ='ISSUE' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $damage != "" ? " $clause trans_type_iss_rcv ='DAMAGE' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $expire != "" ? " $clause trans_type_iss_rcv ='EXPIRED' " : "";



        $table = 'inv_damage_item_expire_issue_vw';
        $primaryKey = 'stocktrans_no_pk';
        $columns = array(
            array('db' => 'stocktrans_no_pk', 'dt' => 0),
            array('db' => 'transref_date', 'dt' => 1),
            array('db' => 'transref_no', 'dt' => 2),
            array('db' => 'trans_type_iss_rcv', 'dt' => 3),
            array('db' => 'supplier_name', 'dt' => 4),
            array('db' => 'item_name', 'dt' => 5),
            array('db' => 'item_qty', 'dt' => 6),
            array('db' => 'item_rate', 'dt' => 7),
        );

        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }




    public function get_item_list_by_req_no(Request $request)
    {

        $purchase_order_id = $request->req_no;
        $check_comprative = DB::table('inv_comparative_statement')->where('requisition_code', $purchase_order_id)->get();
        if ($check_comprative->isEmpty()) {
            // $my_requsition = DB::table('inv_purchase_requisitionmst')
            //     ->join('inv_purchase_requisitiondtl', 'inv_purchase_requisitiondtl.pur_requisition_no_pk', 'inv_purchase_requisitionmst.pur_requisition_no_pk')
            //     ->leftJoin('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', 'inv_purchase_requisitiondtl.item_no_fk')
            //     //->leftJoin('inv_comparative_statement', 'inv_purchase_requisitionmst.pur_requisition_uid', 'inv_comparative_statement.requisition_code')
            //     // ->whereNotIn('pur_requisition_uid', function ($query) use ($purchase_order_id) {
            //     //     $query->select('requisition_code')->from('inv_comparative_statement')->where('requisition_code', $purchase_order_id); //$purchase_order_id
            //     // })
            //     ->where('pur_requisition_uid', $purchase_order_id)
            //     ->where('inv_purchase_requisitiondtl.is_stock_ok', 0)
            //     //->where('approved_ind',1)
            //     ->get();

            $my_requisition = DB::select("select pr.inv_requisition_po_no_pk,pr.req_po_ind,pr.req_po_save_option,prd.item_name,prd.item_no_fk,prd.req_po_quantity
            from inv_requisitionmst_po pr
            left join inv_requisitiondtl_po prd
            on prd.inv_requisitiondtl_no_pk = pr.inv_requisition_po_no_pk
            where pr.inv_requisition_po_no_pk = $purchase_order_id");

            $suppliers = DB::table('inv_supplier')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
            $uom_data = Lookup::where('uom_code', '!=', 'PC')->orderBy('uom_no_pk', 'asc')->get();

            return ['requisition' => $my_requisition, 'suppliers' => $suppliers, 'uom_data' => $uom_data];
        }
        return ['requisition' => [], 'suppliers' => []];
    }
    public function get_item_list_from_comparative_by_req_no(Request $request)
    {

        $purchase_order_id = $request->req_no;
        $my_requsition = DB::table('sysc_serviceitem_vw')
            ->join('inv_comparative_statement', 'sysc_serviceitem_vw.item_no_pk', 'inv_comparative_statement.item_no_fk')
            ->join('inv_purchase_requisitionmst', 'inv_purchase_requisitionmst.pur_requisition_uid', 'inv_comparative_statement.requisition_code')
            ->join('inv_purchase_requisitiondtl', function ($q) {
                $q->on('inv_purchase_requisitiondtl.pur_requisition_no_pk', '=', 'inv_purchase_requisitionmst.pur_requisition_no_pk')
                    ->on('inv_comparative_statement.item_no_fk', '=', 'inv_purchase_requisitiondtl.item_no_fk'); //second join condition
            })
            ->where('inv_comparative_statement.requisition_code', $purchase_order_id)
            ->where("inv_comparative_statement.supplier_no_fk", $request->supplier_id)
            ->where('inv_comparative_statement.approved_ind', 1)
            ->get();


        return $my_requsition;
    }
    public function get_supplier_list_from_comparative_by_req_no(Request $request)
    {

        $purchase_order_id = $request->req_no;
        $supplier_arr = DB::table('inv_comparative_statement')
            ->join('inv_supplier', 'inv_comparative_statement.supplier_no_fk', 'inv_supplier.supplier_no_pk')
            ->where('inv_comparative_statement.requisition_code', $purchase_order_id)
            ->where('approved_ind', 1)
            ->get();
        return $supplier_arr;
    }
    public function stock_adjustment_worklist()
    {
        $date = date('d/m/Y');
        $consumption_data = DB::select("
        select serviceunit_name,item_name,item_qty,trans_type_text,trans_date,user_fullname from phr_transaction_stockin_adj_vw where module_code = 'PHR' and trunc(trans_date) =TO_DATE('$date','DD/MM/YYYY')
        union
        select serviceunit_name,item_name,item_qty,trans_type_text,trans_date,user_fullname from phr_transaction_stockout_adj_vw where module_code = 'PHR' and trunc(trans_date) = TO_DATE('$date','DD/MM/YYYY')
        ");

        return Template::loadView("admin.store.stock_adjustment_worklist", ['consumption_data' => $consumption_data]);
    }

    public function search_stock_adjustment_worklist(Request $request)
    {

        // dd($request->all());
        $sql_cond = '';
        if (isset($request->from_date) && isset($request->to_date)) {
            $from_date =  date('Y-m-d', strtotime($request->from_date));
            $to_date =  date('Y-m-d', strtotime($request->to_date));


            $sql_cond .= "and  trunc(trans_date) between TO_DATE('$from_date','YYYY-MM-DD') and TO_DATE('$to_date','YYYY-MM-DD') ";
        } elseif (isset($request->from_date)) {
            $from_date =  date('Y-m-d', strtotime($request->from_date));
            $sql_cond .= "and  trunc(trans_date) = TO_DATE('$from_date','YYYY-MM-DD')";
        } elseif (isset($request->to_date)) {
            $to_date =  date('Y-m-d', strtotime($request->to_date));

            $sql_cond .= "and  trunc(trans_date) = TO_DATE('$to_date','YYYY-MM-DD')";
        }

        if (isset($request->item_id)) {

            $sql_cond .= "and  item_no_fk= " . $request->item_id;
        }
        $consumption_data = DB::select("
        select serviceunit_name,item_name,item_qty,trans_type_text,trans_date,user_fullname from phr_transaction_stockin_adj_vw where module_code = 'PHR'   $sql_cond
        union
        select serviceunit_name,item_name,item_qty,trans_type_text,trans_date,user_fullname from phr_transaction_stockout_adj_vw where module_code = 'PHR'   $sql_cond
        ");
        ///dd($query->get(),$request->all());
        return Template::loadView("admin.store.stock_adjustment_worklist_table", ['consumption_data' => $consumption_data]);
    }


    public function storeAdjustmentV1()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();
        return Template::loadView("admin.uhl.inventory.opening-balance-adjustment-entry", ['store' => $store, 'supplier' => $supplier]);
    }
    public function purchaseReturn()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();

        return Template::loadView("admin.uhl.inventory.purchase_return", ['store' => $store, 'supplier' => $supplier]);
    }
    public function purchaseReturnReport()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();

        return Template::loadView("admin.uhl.inventory.purchase_return_report", ['store' => $store, 'supplier' => $supplier]);
    }
    public function purchaseReturnReceive()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();

        return Template::loadView("admin.uhl.inventory.purchase_return_receive", ['store' => $store, 'supplier' => $supplier]);
    }
    public function getSupplierReturnAmt(Request $request)
    {
        $returnAmt = DB::table('phr_expire_medicine_return')
            ->select(DB::raw('sum(total_amount) as total_amount'))
            ->where('supplier_no_fk', $request->supplier_id)
            ->whereNotNull('stocktrans_no_pk')
            ->whereIn('expire_return_code', ['SUPRTN', 'SUPRTNRCV'])
            // ->groupBy('stocktrans_no_pk')
            // ->having(DB::raw('sum(total_amount)'), '>', 0)
            ->first();
        return response()->json($returnAmt);
    }
    public function purchaseReturnReportReceive()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();

        return Template::loadView("admin.uhl.inventory.purchase_return_receive_report", ['store' => $store, 'supplier' => $supplier]);
    }
    public function purchaseReturnReportPdf(Request $request)
    {
        $date_from = $request->indent_date_from != "" ? date('Y-m-d', strtotime($request->indent_date_from)) : '';
        $date_to = $request->indent_date_to != "" ? date('Y-m-d', strtotime($request->indent_date_to)) : '';
        $query = DB::table('inv_itemstocktranschd')
            ->select('inv_itemstocktranschd.stocktrans_no_fk', 'inv_itemstocktranschd.batch_no', 'inv_itemstocktranschd.expiry_date', 'inv_itemstocktranschd.item_name', 'inv_itemstocktranschd.item_qty', 'inv_itemstocktranschd.item_rate', 'inv_itemstocktranschd.internal_batch_no_uq', 'inv_itemstocktranschd.au_entry_at', 'sysc_serviceitem_vw.supplier_name', 'sysc_serviceitem_vw.uom_name', 'sysc_serviceunit.serviceunit_name')
            ->where('trans_type_iss_rcv_chd', "GRNRTN")
            ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'inv_itemstocktranschd.item_no_fk')
            ->join('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_itemstocktranschd.stock_su_no_fk');

        if ($request->suppler_id != "") {
            $query->where('sysc_serviceitem_vw.supplier_pk_no', $request->suppler_id);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween(DB::raw('trunc(inv_itemstocktranschd.au_entry_at)'), [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->whereDate('inv_itemstocktranschd.au_entry_at', $date_from);
        }

        $datas = $query->orderBy('sysc_serviceitem_vw.supplier_name', 'asc')->get()->groupBy('stocktrans_no_fk');
        // dd($datas,$date_from, $date_to);

        $pdf =  ["type" => "pdf", 'data' => $datas, 'date_from' => $date_from, 'date_to' => $date_to];
        $fileToExport = "purchase_return_report_pdf";
        $html = View("admin.uhl.inventory.purchase_return_report_pdf")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }
    public function storeAdjustmentMainSubV2()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();
        $main_stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', Auth::id())
            ->get();
        $sub_stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('SERVICEUNIT_NO_PK', 'SERVICEUNIT_NAME')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', Auth::id())
            ->get();
        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();
        return Template::loadView("admin.uhl.inventory.store_adjustment_main_sub_v2", ['store' => $store, 'supplier' => $supplier, 'main_stores' => $main_stores, 'sub_stores' => $sub_stores]);
    }


    public function cafeteriaStoreAdjustmentV1($type="")
    {
        // dd($type);

        // $store = DB::table('sysc_v1_grant_servieceunit_vw')
        //     ->select('serviceunit_name', 'serviceunit_no_pk')
        //     ->where('user_no_pk', Auth::id())
        //     // ->whereRaw('main_store_ind = 1 or sub_store_ind = 1')
        //     ->where(function ($query) {
        //         $query->where('main_store_ind', 1)
        //             ->orWhere('sub_store_ind', 1);
        //     })
        //     ->get();
        if (Session::get('user.ses_hospital_code')=="UNICO") {
            $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where('cafeteria_ind',1)
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();
        }else{
            $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            // ->whereRaw('main_store_ind = 1 or sub_store_ind = 1')
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();
        }
        // dd( $store);
        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();
        //   dd( $store);
        return Template::loadView("admin.uhl.inventory.opening-balance-adjustment-entry-cafeteria", ['store' => $store, 'supplier' => $supplier,'type'=>$type]);
    }
    public function ipdMealProvide()
    {
       
        
        //   dd( $store);
        return Template::loadView("admin.uhl.ipd_meal_provide");
    }



    public function storeAdjustmentSaveV1(Request $request)
    {
        // dd($request->all());
        try {
            $chalan_no = ''; //strval()
            $chalan_date = '';
            $store_su_no_fk = isset($request->store_to_effect) ? intval($request->store_to_effect) : 0;
            $po_no = '';
            $supplier_no_fk = isset($request->supplier) ? intval($request->supplier) : 0;
            $adjreason = $request->reason_adjustment;
            $remarks = $request->remarksMst;
            $item_pk_no_arr = $request->item_id;
            $trans_date = $request->date != "" ? date('Y-m-d', strtotime($request->date)) : '';
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $internal_batch_id = [];
            $batch_no = [];
            $exp_date = [];
            $itemremarks = [];

            if ($item_pk_no_arr != "") {
                for ($i = 0; $i < count($item_pk_no_arr); $i++) {
                    $item_pvms[$i] = null;
                    $item_pk_no[$i] = intval($request->item_id[$i]);
                    $item_qty[$i] = floatval($request->item_qty[$i]);
                    $item_uom[$i] = intval($request->item_uom_id[$i]);
                    // $item_price[$i] = floatval($request->p_price[$i]);
                    $cost_price[$i] = floatval($request->p_price[$i]);
                    $item_price[$i] = floatval($request->sales_price[$i]);
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                    $itemremarks[$i] = $request->remarks[$i];
                    $internal_batch_id[$i] = $request->internal_batch[$i];
                    $batch_no[$i] = $request->batch[$i];
                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('dmY', strtotime($request->exp_date[$i])) : '';
                }
            }
            $demand_no_fk = 0;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';


            $pdo = DB::getPdo();
            $transferIn = $request->inlineRadioOptions;
            $stock_adjustment = $pdo->prepare("begin
            pkg_v1_inventory_all.prc_stockadjustment(
                    :in_challan_no,
                    :in_challan_date,
                    :in_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_adjreason,
                    :in_remarks,
                    :in_transdate,
                    :in_a_item_no_fk,
                    :in_item_batch_fk,
                    :in_item_expiry_dt,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_internal_batch_no_uq,
                    :in_cost_price,
                    :in_itmremarks,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
            $stock_adjustment->bindparam('in_challan_no', $chalan_no);
            $stock_adjustment->bindparam('in_challan_date', $chalan_date);
            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
            $stock_adjustment->bindparam('in_po_no', $po_no);
            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);
            $stock_adjustment->bindparam('in_transtype', $transferIn);
            $stock_adjustment->bindparam('in_adjreason', $adjreason);
            $stock_adjustment->bindparam('in_remarks', $remarks);
            $stock_adjustment->bindparam('in_transdate', $trans_date);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_cost_price', $cost_price, count($cost_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);
            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            //  dd($stock_adjustment);
            $stock_adjustment->execute();



            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function purchaseReturnStore(Request $request)

    {
        try {
            DB::beginTransaction();
            $chalan_no = ''; //strval()

            $chalan_date = '';

            $store_su_no_fk = isset($request->store_to_effect) ? intval($request->store_to_effect) : 0;

            $po_no = '';

            $supplier_no_fk = isset($request->supplier_id) ? intval($request->supplier_id) : 0;

            $adjreason = $request->reason_adjustment;

            $remarks = $request->remarksMst;

            $item_pk_no_arr = $request->item_id;

            $trans_date = $request->date != "" ? date('Y-m-d', strtotime($request->date)) : '';

            $item_pvms = [];

            $item_qty = [];

            $item_uom = [];

            $item_price = [];

            $item_entry_dtl = [];

            $empty_arr = [];

            $internal_batch_id = [];

            $batch_no = [];

            $exp_date = [];

            $itemremarks = [];

            if ($item_pk_no_arr != "") {

                for ($i = 0; $i < count($item_pk_no_arr); $i++) {

                    $item_pvms[$i] = null;

                    $item_pk_no[$i] = intval($request->item_id[$i]);

                    $item_qty[$i] = floatval($request->item_qty[$i]);

                    $item_uom[$i] = intval($request->item_uom_id[$i]);

                    $item_price[$i] = floatval($request->p_price[$i]);

                    $item_entry_dtl[$i] = $i + 1;

                    $empty_arr[$i] = 0;

                    $itemremarks[$i] = $request->remarks[$i];

                    $internal_batch_id[$i] = $request->internal_batch[$i];

                    $batch_no[$i] = $request->batch[$i];

                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('dmY', strtotime($request->exp_date[$i])) : '';
                }
            }

            $demand_no_fk = 0;

            $in_au_entry_by = Auth::id();

            $in_au_entry_session = 'SESSION';

            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';

            $numelems = 500;

            $null = '';

            $out_itemtrans_uid = '';

            $pdo = DB::getPdo();

            $transferIn =  $transferIn = 'SUPRTN'; // $request->inlineRadioOptions;
            // dd($transferIn);
            $stock_adjustment = $pdo->prepare("begin

            pkg_v1_inventory_all.prc_stockadjustment(

                    :in_challan_no,

                    :in_challan_date,

                    :in_store_su_no_fk,

                    :in_demand_no_fk,

                    :in_po_no,

                    :in_supplier_no_fk,

                    :in_transtype,

                    :in_adjreason,

                    :in_remarks,

                    :in_transdate,

                    :in_a_item_no_fk,

                    :in_item_batch_fk,

                    :in_item_expiry_dt,

                    :in_a_item_pvmsno,

                    :in_a_item_qty,

                    :in_a_item_uom,

                    :in_a_freeitem_qty,

                    :in_a_freeitem_uom,

                    :in_a_item_price,

                    :in_a_entry_serial_dtl,

                    :in_internal_batch_no_uq,

                    :in_cost_price,

                    :in_itmremarks,

                    :in_au_entry_by,

                    :in_au_entry_session,

                    :in_au_entry_hospital_no_fk,

                    :out_itemtrans_uid);

                    end;

                    ");

            $stock_adjustment->bindparam('in_challan_no', $chalan_no);

            $stock_adjustment->bindparam('in_challan_date', $chalan_date);

            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);

            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);

            $stock_adjustment->bindparam('in_po_no', $po_no);

            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);

            $stock_adjustment->bindparam('in_transtype', $transferIn);

            $stock_adjustment->bindparam('in_adjreason', $adjreason);

            $stock_adjustment->bindparam('in_remarks', $remarks);

            $stock_adjustment->bindparam('in_transdate', $trans_date);

            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);

            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);

            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);

            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

            $stock_adjustment->bindParam('out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

            // dd($stock_adjustment);

            $stock_adjustment->execute();

            // save in table

            $phr_expire_medicine_return = DB::table('phr_expire_medicine_return')->orderBy('expire_return_no_pk', 'desc')->first();

            $return_no = !empty($phr_expire_medicine_return) ? $phr_expire_medicine_return->return_no + 1 : 1;

            //  $transferIn = 'SUPRTN';//$request->inlineRadioOptions; //EXPIRED OR DAMAGE
            // dd($out_itemtrans_uid,$request->item_id);
            if (!empty($request->item_id)) {

                for ($j = 0; $j < count($request->item_id); $j++) {

                    DB::beginTransaction();

                    $sequence = DB::getSequence();

                    $expire_return_no_pk_seq  = $sequence->nextValue('expire_return_no_pk_seq');

                    $null = '';

                    $data = [

                        'expire_return_no_pk' =>  $expire_return_no_pk_seq,

                        'item_no_fk' => $item_pk_no[$j],

                        'expire_return_code' => $transferIn,

                        'expire_date' => $request->exp_date[$j] != "" ? date('Y-m-d', strtotime($request->exp_date[$j])) : '',

                        'purchase_rate' =>  $item_price[$j],

                        'qty' =>  $item_qty[$j],

                        'total_amount' =>  $item_qty[$j] * $item_price[$j],

                        'supplier_no_fk' => $request->suppler_id,

                        'store_no_fk' => $store_su_no_fk,

                        'return_no' => $return_no,

                        'batch_no' => $batch_no[$j],

                        'internal_batch_no_uq' => $internal_batch_id[$j],

                        'stocktrans_no_pk' => $out_itemtrans_uid,

                        'au_entry_by' => $in_au_entry_by,

                        'au_entry_at' => date('Y-m-d'),

                        'au_entry_session' => 'purchase_return',

                        'au_entry_hospital_pk_no' =>  $in_au_entry_hospital_pk_no

                    ];

                    // dd( $data);

                    DB::table('phr_expire_medicine_return')->insert($data);

                    DB::commit();
                };
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully.' . $out_itemtrans_uid, 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error', 402];
        }

        return response()->json($message);
    }
    public function purchaseReturnReceiveStore(Request $request)

    {
        try {
            DB::beginTransaction();
            $chalan_no = ''; //strval()

            $chalan_date = '';

            $store_su_no_fk = isset($request->store_to_effect) ? intval($request->store_to_effect) : 0;

            $po_no = '';

            $supplier_no_fk = isset($request->supplier_id) ? intval($request->supplier_id) : 0;

            $adjreason = $request->reason_adjustment;

            $remarks = $request->remarksMst;

            $item_pk_no_arr = $request->item_id;

            $trans_date = $request->date != "" ? date('Y-m-d', strtotime($request->date)) : '';

            $item_pvms = [];

            $item_qty = [];

            $item_uom = [];

            $item_price = [];

            $item_entry_dtl = [];

            $empty_arr = [];

            $internal_batch_id = [];

            $batch_no = [];

            $exp_date = [];

            $itemremarks = [];

            if ($item_pk_no_arr != "") {

                for ($i = 0; $i < count($item_pk_no_arr); $i++) {

                    $item_pvms[$i] = null;

                    $item_pk_no[$i] = intval($request->item_id[$i]);

                    $item_qty[$i] = floatval($request->item_qty[$i]);

                    $item_uom[$i] = intval($request->item_uom_id[$i]);

                    $item_price[$i] = floatval($request->p_price[$i]);

                    $item_entry_dtl[$i] = $i + 1;

                    $empty_arr[$i] = 0;

                    $itemremarks[$i] = $request->remarks[$i];

                    $internal_batch_id[$i] = $request->internal_batch[$i];

                    $batch_no[$i] = $request->batch[$i];

                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('dmY', strtotime($request->exp_date[$i])) : '';
                }
            }

            $demand_no_fk = 0;

            $in_au_entry_by = Auth::id();

            $in_au_entry_session = 'SESSION';

            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';

            $numelems = 500;

            $null = '';

            $out_itemtrans_uid = '';

            $pdo = DB::getPdo();

            $transferIn = 'SUPRTNRCV'; // $request->inlineRadioOptions;
            // dd($transferIn);
            $stock_adjustment = $pdo->prepare("begin

            pkg_v1_inventory_all.prc_stockadjustment(

                    :in_challan_no,

                    :in_challan_date,

                    :in_store_su_no_fk,

                    :in_demand_no_fk,

                    :in_po_no,

                    :in_supplier_no_fk,

                    :in_transtype,

                    :in_adjreason,

                    :in_remarks,

                    :in_transdate,

                    :in_a_item_no_fk,

                    :in_item_batch_fk,

                    :in_item_expiry_dt,

                    :in_a_item_pvmsno,

                    :in_a_item_qty,

                    :in_a_item_uom,

                    :in_a_freeitem_qty,

                    :in_a_freeitem_uom,

                    :in_a_item_price,

                    :in_a_entry_serial_dtl,

                    :in_internal_batch_no_uq,

                    :in_cost_price,

                    :in_itmremarks,

                    :in_au_entry_by,

                    :in_au_entry_session,

                    :in_au_entry_hospital_no_fk,

                    :out_itemtrans_uid);

                    end;

                    ");

            $stock_adjustment->bindparam('in_challan_no', $chalan_no);

            $stock_adjustment->bindparam('in_challan_date', $chalan_date);

            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);

            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);

            $stock_adjustment->bindparam('in_po_no', $po_no);

            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);

            $stock_adjustment->bindparam('in_transtype', $transferIn);

            $stock_adjustment->bindparam('in_adjreason', $adjreason);

            $stock_adjustment->bindparam('in_remarks', $remarks);

            $stock_adjustment->bindparam('in_transdate', $trans_date);

            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);

            $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);

            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);

            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);

            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);

            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

            $stock_adjustment->bindParam('out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

            // dd($stock_adjustment);

            $stock_adjustment->execute();

            // save in table

            $phr_expire_medicine_return = DB::table('phr_expire_medicine_return')->orderBy('expire_return_no_pk', 'desc')->first();

            $return_no = !empty($phr_expire_medicine_return) ? $phr_expire_medicine_return->return_no + 1 : 1;

            //  $transferIn = 'SUPRTN';//$request->inlineRadioOptions; //EXPIRED OR DAMAGE
            // dd($out_itemtrans_uid,$request->item_id);
            if (!empty($request->item_id)) {

                for ($j = 0; $j < count($request->item_id); $j++) {

                    DB::beginTransaction();

                    $sequence = DB::getSequence();

                    $expire_return_no_pk_seq  = $sequence->nextValue('expire_return_no_pk_seq');

                    $null = '';

                    $data = [

                        'expire_return_no_pk' =>  $expire_return_no_pk_seq,

                        'item_no_fk' => $item_pk_no[$j],

                        'expire_return_code' => $transferIn,

                        'expire_date' => $request->exp_date[$j] != "" ? date('Y-m-d', strtotime($request->exp_date[$j])) : '',

                        'purchase_rate' =>  $item_price[$j],

                        'qty' =>  $item_qty[$j],

                        'total_amount' =>  - ($item_qty[$j] * $item_price[$j]),

                        'supplier_no_fk' => $request->suppler_id,

                        'store_no_fk' => $store_su_no_fk,

                        'return_no' => $return_no,

                        'batch_no' => $batch_no[$j],

                        'internal_batch_no_uq' => $internal_batch_id[$j],

                        'stocktrans_no_pk' => $out_itemtrans_uid,

                        'au_entry_by' => $in_au_entry_by,

                        'au_entry_at' => date('Y-m-d'),

                        'au_entry_session' => 'purchase_return',

                        'au_entry_hospital_pk_no' =>  $in_au_entry_hospital_pk_no

                    ];

                    // dd( $data);

                    DB::table('phr_expire_medicine_return')->insert($data);

                    DB::commit();
                };
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully.' . $out_itemtrans_uid, 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error', 402];
        }

        return response()->json($message);
    }

    public function storeAdjustmentSaveV2(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {

            $chalan_no = ''; //strval()
            $chalan_date = '';
            $store_su_no_fk_from = isset($request->store_from) ? intval($request->store_from) : 0;
            $store_su_no_fk_to = isset($request->store_id) ? intval($request->store_id) : 0;
            // dd($store_su_no_fk_from , $store_su_no_fk_to);
            $po_no = '';
            $supplier_no_fk = isset($request->supplier) ? intval($request->supplier) : 0;
            $adjreason = $request->reason_adjustment;
            $remarks = $request->remarksMst;
            $item_pk_no_arr = $request->item_id;
            $trans_date = $request->date != "" ? date('Y-m-d', strtotime($request->date)) : '';
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $internal_batch_id = [];
            $batch_no = [];
            $exp_date = [];
            $itemremarks = [];

            if ($item_pk_no_arr != "") {
                for ($i = 0; $i < count($item_pk_no_arr); $i++) {
                    $item_pvms[$i] = null;
                    $item_pk_no[$i] = intval($request->item_id[$i]);
                    $item_qty[$i] = floatval($request->item_qty[$i]);
                    $item_uom[$i] = intval($request->item_uom_id[$i]);
                    $item_price[$i] = floatval($request->p_price[$i]);
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                    $itemremarks[$i] = $request->remarks[$i];
                    $internal_batch_id[$i] = $request->internal_batch[$i];
                    $batch_no[$i] = $request->batch[$i];
                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('dmY', strtotime($request->exp_date[$i])) : '';
                }
            }
            // dd( $item_pk_no_arr,$item_pk_no ,$item_qty,$item_uom,$item_price, $internal_batch_id ,$batch_no ,  $exp_date );
            $demand_no_fk = 0;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';


            $pdo = DB::getPdo();
            $transferIn = $request->transfer_type;
            $stock_adjustment = $pdo->prepare("begin
            pkg_v1_inventory_all.prc_v1_stockadjustment(
                    :in_challan_no,
                    :in_challan_date,
                    :in_to_store_su_no_fk,
                    :in_from_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_adjreason,
                    :in_remarks,
                    :in_transdate,
                    :in_a_item_no_fk,
                    :in_item_batch_fk,
                    :in_item_expiry_dt,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_internal_batch_no_uq,
                    :in_cost_price,
                    :in_itmremarks,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
            $stock_adjustment->bindparam('in_challan_no', $chalan_no);
            $stock_adjustment->bindparam('in_challan_date', $chalan_date);
            $stock_adjustment->bindparam('in_to_store_su_no_fk',  $store_su_no_fk_to);
            $stock_adjustment->bindparam('in_from_store_su_no_fk', $store_su_no_fk_from);
            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
            $stock_adjustment->bindparam('in_po_no', $po_no);
            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);
            $stock_adjustment->bindparam('in_transtype', $transferIn);
            $stock_adjustment->bindparam('in_adjreason', $adjreason);
            $stock_adjustment->bindparam('in_remarks', $remarks);
            $stock_adjustment->bindparam('in_transdate', $trans_date);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);
            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            // dd($stock_adjustment);
            $stock_adjustment->execute();



            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function storeAdjustmentListV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.opening_balance_adjustment_worklist", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function storeAdjustmentSearchV1(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_itemadjment_vw');

        if ($soter_no != "") {
            $query->where('store_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($type_code != "") {
            $query->where('itemadjment_type', $type_code);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('itemadjment_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('itemadjment_date', $date_from);
        }

        $data = $query->orderBy('itemadjment_no_pk', 'desc')->get();


        return Template::loadview("admin.uhl.inventory.opening_balance_adjustment_list", [
            'data' => $data,
        ]);
    }
    public function storeAdjustmentPdfhV1(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_itemadjment_vw');

        if ($soter_no != "") {
            $query->where('store_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($type_code != "") {
            $query->where('itemadjment_type', $type_code);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('itemadjment_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('itemadjment_date', $date_from);
        }
        $data = $query->get();

        $title = date('d-m-Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();




        return View("admin.uhl.inventory.opening_balance_adjustment_list_pdf", [
            'data' => $data,
            'barcode_no' => $barcode_no,
        ]);
    }


    public function returnToMainStore()
    {
        $sub_store = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->where('sub_store_ind', 1)->where('status', 1)->get();
        $main_store = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->where('main_store_ind', 1)->where('status', 1)->get();
        $supplier = Supplier::select('supplier_no_pk', 'supplier_name')->where('status', 1)->get();
        //   dd( $store);
        return Template::loadView("admin.uhl.inventory.return_to_main_store", ['sub_store' => $sub_store, 'main_store' => $main_store, 'supplier' => $supplier]);
    }



    public function returnToMainStoreSave(Request $request)
    {
        // dd($request->main_store_to_effect);
        try {
            $chalan_no = ''; //strval()
            $chalan_date = '';
            $store_su_no_fk = isset($request->store_to_effect) ? intval($request->store_to_effect) : 0;
            $to_store_su_no_fk = isset($request->main_store_to_effect) ? intval($request->main_store_to_effect) : 0;
            $po_no = '';
            $supplier_no_fk = isset($request->supplier) ? intval($request->supplier) : 0;
            $adjreason = $request->reason_adjustment;
            $remarks = $request->remarksMst;
            $item_pk_no_arr = $request->item_id;
            $trans_date = $request->date != "" ? date('Y-m-d', strtotime($request->date)) : '';
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $internal_batch_id = [];
            $batch_no = [];
            $exp_date = [];
            $itemremarks = [];

            if ($item_pk_no_arr != "") {
                for ($i = 0; $i < count($item_pk_no_arr); $i++) {
                    $item_pvms[$i] = null;
                    $item_pk_no[$i] = intval($request->item_id[$i]);
                    $item_qty[$i] = floatval($request->item_qty[$i]);
                    $item_uom[$i] = intval($request->item_uom_id[$i]);
                    $item_price[$i] = floatval($request->p_price[$i]);
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                    $itemremarks[$i] = $request->remarks[$i];
                    $internal_batch_id[$i] = $request->internal_batch[$i];
                    $batch_no[$i] = $request->batch[$i];
                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('Y-m-d', strtotime($request->exp_date[$i])) : '';
                }
            }
            // dd(
            //     $item_pvms,
            //     $item_qty,
            //     $item_uom,
            //     $item_price,
            //     $item_entry_dtl,
            //     $empty_arr,
            //     $internal_batch_id,
            //     $batch_no,
            //     $exp_date,
            // );
            $demand_no_fk = 0;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';


            $pdo = DB::getPdo();
            $transferIn = $request->inlineRadioOptions;
            $stock_adjustment =  $pdo->prepare("begin pkg_v1_inventory_all.prc_returnstore2store(
                :in_transref_no,
                :in_transref_date,
                :in_stock_su_no_fk_from,
                :in_stock_su_no_fk_to,
                :in_returnreason,
                :in_remarks,
                :in_a_item_no_fk,
                :in_item_batch_fk,
                :in_item_expiry_dt,
                :in_a_item_pvmsno,
                :in_a_item_qty,
                :in_a_item_uom,
                :in_a_item_price,
                :in_a_entry_serial_dtl,
                :in_internal_batch_no_uq,
                :in_cost_price,
                :in_itmremarks,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_no_fk,
                :out_itemreceive_uid
            ); end;");

            $stock_adjustment->bindparam('in_transref_no', $chalan_no);
            $stock_adjustment->bindparam('in_transref_date', $trans_date);
            $stock_adjustment->bindparam('in_stock_su_no_fk_from', $store_su_no_fk);
            $stock_adjustment->bindparam('in_stock_su_no_fk_to', $to_store_su_no_fk);
            $stock_adjustment->bindparam('in_returnreason', $adjreason);
            $stock_adjustment->bindparam('in_remarks', $remarks);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);
            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $stock_adjustment->bindParam(':out_itemreceive_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            $stock_adjustment->execute();
            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function returnToMainStoreListV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $from_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->where('sub_store_ind', 1)->where('status', 1)->get();
        $to_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.return_to_main_store_worklist", [
            'from_store_list' => $from_store_list,
            'to_store_list' => $to_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function returnToMainStoreSearchV1(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $to_store_id = $request->to_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('phr_itemareturnstore_vw');

        if ($soter_no != "") {
            $query->where('from_su_no_fk', $soter_no);
        }
        if ($to_store_id != "") {
            $query->where('to_su_no_fk', $to_store_id);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('itemareturnstore_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('itemareturnstore_date', $date_from);
        }

        $data = $query->orderBy('itemareturnstore_no_pk', 'desc')->get();

        return Template::loadview("admin.uhl.inventory.return_to_main_store_worklist_list", [
            'data' => $data,
        ]);
    }
    // public function storeAdjustmentPdfhV1(Request $request)
    // {
    //     $ses_hospital_id = Session::get('user.ses_hospital_id');
    //     $soter_no=$request->sub_store_id;
    //     $item_id=$request->item_id;
    //     $internal_batch_no=$request->internal_batch_no;
    //     $type_code=$request->type_code;
    //     $date_from=$request->date_from !="" ? date('Y-m-d',strtotime($request->date_from)) : '';
    //     $date_to=$request->date_to !="" ? date('Y-m-d',strtotime($request->date_to)) :'';
    //     $query=DB::table('inv_itemadjment_vw');

    //     if ($soter_no !="") {
    //        $query->where('store_su_no_fk',$soter_no );
    //     }
    //     if ( $item_id !="") {
    //         $query->where('item_no_fk',$item_id );
    //     }
    //     if ( $internal_batch_no !="") {
    //         $query->where('internal_batch_no_uq',$internal_batch_no );
    //     }
    //     if ( $type_code !="") {
    //         $query->where('itemadjment_type',$type_code );
    //     }
    //     if ($date_from !="" && $date_to !="") {
    //         $query->whereBetween('itemadjment_date',[$date_from , $date_to] );
    //     }elseif ($date_from !="") {
    //         $query->where('itemadjment_date',$date_from );
    //     }
    //     $data=$query->get();

    //     $title = date('d-m-Y');
    //     $barcode = new BarcodeGenerator();
    //     $barcode->setText($title);
    //     $barcode->setType(BarcodeGenerator::Code128);
    //     $barcode->setLabel('');
    //     $barcode->setScale(1);
    //     $barcode->setThickness(25);
    //     $barcode->setFontSize(10);
    //     $barcode_no = $barcode->generate();




    //     return View("admin.uhl.inventory.opening_balance_adjustment_list_pdf", [
    //         'data' => $data,
    //         'barcode_no' => $barcode_no,
    //     ]);
    // }




    public function returnToMainStoreApproveListV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $from_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->where('sub_store_ind', 1)->where('status', 1)->get();
        $to_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.return_to_main_store_approve_worklist", [
            'from_store_list' => $from_store_list,
            'to_store_list' => $to_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function returnToMainStoreApproveSearchV1(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $to_store_id = $request->to_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('phr_itemareturnstore_vw');

        if ($soter_no != "") {
            $query->where('from_su_no_fk', $soter_no);
        }
        if ($to_store_id != "") {
            $query->where('to_su_no_fk', $to_store_id);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('itemareturnstore_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('itemareturnstore_date', $date_from);
        }

        $data = $query->orderBy('itemareturnstore_no_pk', 'desc')->get();

        return Template::loadview("admin.uhl.inventory.return_to_main_store_approve_worklist_list", [
            'data' => $data,
        ]);
    }


    public function returnToMainStoreApproveSave(Request $request)
    {
        // dd($request->main_store_to_effect);
        try {
            if (!empty($request->approve_receive)) {
                foreach ($request->approve_receive as $kye => $value) {

                    $return_data = DB::table('phr_itemareturnstore_vw')->where('itemareturnstoredtl_no_pk', $value)->first();
                    $chalan_no = null; //strval()
                    $to_store_su_no_fk = $return_data->to_su_no_fk ? $return_data->to_su_no_fk : null;

                    $itemareturnstoredtl_no_pk[] = $return_data->itemareturnstore_no_pk ? $return_data->itemareturnstore_no_pk : null;
                    $item_pk_no[] = $return_data->item_no_fk ? $return_data->item_no_fk : null;
                    $item_pvms[] =  null;
                    $item_qty[] = $return_data->item_qty ? $return_data->item_qty : null;
                    $item_uom[] = $return_data->uom ? $return_data->uom : null;
                    $item_price[] = $return_data->trade_price ? $return_data->trade_price : null;
                    $item_entry_dtl[] = $kye + 1;
                    $empty_arr[] = '';
                    $internal_batch_id[] = $return_data->internal_batch_no_uq ? $return_data->internal_batch_no_uq : null;
                    $batch_no[] = $return_data->batch_no ? $return_data->batch_no : null;
                    $exp_date[] = $return_data->expiry_date ? $return_data->expiry_date : null;
                    $itemremarks[] = $return_data->itm_remarks ? $return_data->itm_remarks : null;

                    $in_au_entry_by = Auth::id();
                    $in_au_entry_session = 'SESSION';
                    $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
                    $numelems = 500;
                    $null = '';
                    $out_itemtrans_uid = '0';


                    $pdo = DB::getPdo();
                    $transferIn = $request->inlineRadioOptions;
                    $stock_adjustment =  $pdo->prepare("begin pkg_v1_inventory_all.prc_receivestore2store(
                :in_transref_no,
                :in_to_su_no_fk_to,
                :in_itemareturnstoredtl_no_pk,
                :in_a_item_no_fk,
                :in_item_batch_fk,
                :in_item_expiry_dt,
                :in_a_item_pvmsno,
                :in_a_item_qty,
                :in_a_item_uom,
                :in_a_item_price,
                :in_a_entry_serial_dtl,
                :in_internal_batch_no_uq,
                :in_cost_price,
                :in_itmremarks,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_no_fk,
                :out_itemreceive_uid
            ); end;");


                    $stock_adjustment->bindparam('in_transref_no', $chalan_no);
                    $stock_adjustment->bindparam('in_to_su_no_fk_to', $to_store_su_no_fk);
                    $stock_adjustment->bindArray('in_itemareturnstoredtl_no_pk', $itemareturnstoredtl_no_pk, count($itemareturnstoredtl_no_pk), $numelems, SQLT_INT);
                    $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
                    $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
                    $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
                    $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
                    $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
                    $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
                    $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
                    $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);
                    $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);
                    $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
                    $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);
                    $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
                    $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
                    $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
                    $stock_adjustment->bindParam(':out_itemreceive_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
                    // dd( $stock_adjustment);
                    $stock_adjustment->execute();
                    DB::commit();
                    $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
                }
            }
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function grnReportNew()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.grn_report.grn_report", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }

    public function itemIssueReportFMS()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.Item_Issue_Report.item_issue_report_index", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }



    public function itemIssueReportFMSNew()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_serviceunit')
            ->select('*')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            // ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.Item_Issue_Report.item-issue-report-new", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }



    public function expiredItem()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.expired_item", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function expiredItemSearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $all_expiry = $request->all_expiry;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        $query = DB::table('inv_batchwise_stock_vw')->select('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk','sales_price', DB::raw('sum(item_qty) as item_qty'));
        if ($soter_no != "") {
            $query->where('stock_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        $to_date = date('Y-m-d');

        if ($all_expiry != "") {
            $query->where('expiry_date', '<=', $to_date);
        }
        // dd($query);
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('expiry_date', [$date_from, $date_to]);
        }
        $data = $query->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk','sales_price')
            ->having(DB::raw('sum(item_qty)'), '>', 0)
            ->orderBy('expiry_date', 'desc')
            ->get();
        // dd($all_expiry,$soter_no, $datas);
        // $data = [];
        // if (!empty($datas)) {
        //     foreach ($datas as $key => $value) {
        //         if ($value->item_qty > 0) {
        //             $data[] = (object)[
        //                 'internal_batch_no_uq' => $value->internal_batch_no_uq,
        //                 'expiry_date' => $value->expiry_date,
        //                 'batch_no' => $value->batch_no,
        //                 'purchase_price' => $value->purchase_price,
        //                 'item_name' => $value->item_name,
        //                 'serviceunit_name' => $value->serviceunit_name,
        //                 'uom_code' => $value->uom_code,
        //                 'uom_no_pk' => $value->uom_no_pk,
        //                 'item_qty' => $value->item_qty
        //             ];
        //         }
        //     }
        // }
        // dd($data);
        return Template::loadview("admin.uhl.inventory.expired_item_list", [
            'data' => $data,
        ]);
    }

    public function grnItemSearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';


        // $query = DB::table('phr_v1_grn_vw')->select('itemreceive_no_pk', 'au_entry_at', 'po_no', 'pr_no', 'item_no_fk', 'item_name', 'purchase_price', 'batch_no', 'expiry_date', 'uom_name', 'delivered_qty','discount_amount_itm',DB::raw('purchase_price*delivered_qty as total'), DB::raw('purchase_price*delivered_qty - discount_amount_itm as net_total'));
        $query = DB::table('phr_v1_grn_vw')->select('itemreceive_no_pk', 'au_entry_at', 'po_no', 'pr_no', 'item_no_fk', 'item_name', 'purchase_price', 'batch_no', 'expiry_date', 'uom_name', 'delivered_qty', 'discount_amount_itm', DB::raw('purchase_price*delivered_qty as total'), DB::raw('purchase_price*delivered_qty - discount_amount_itm as net_total'));
        // DD($query);
        if ($soter_no != "") {
            $query->where('store_su_no_fk', $soter_no);
        }
        // if ($item_id != "") {
        //     $query->where('item_no_fk', $item_id);
        // }
        // if ($internal_batch_no != "") {
        //     $query->where('internal_batch_no_uq', $internal_batch_no);
        // }


        if ($date_from != "" && $date_to != "") {
            $query->whereBetween(DB::raw("trunc(au_entry_at)"), [$date_from, $date_to]);
            // $query->whereBetween('au_entry_at', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('au_entry_at', $date_from);
        }

        $datas = $query //->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk')
            ->where('delivered_qty', '>', 0)
            ->orderBy('itemreceive_no_pk', 'desc')->get();

        //DD($datas);

        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->delivered_qty > 0) {
                    $data[] = (object)[

                        'itemreceive_no_pk' => $value->itemreceive_no_pk,
                        'au_entry_at' => $value->au_entry_at,
                        'po_no' => $value->po_no,
                        'pr_no' => $value->pr_no,
                        'item_no_fk' => $value->item_no_fk,
                        'item_name' => $value->item_name,
                        'purchase_price' => $value->purchase_price,
                        'batch_no' => $value->batch_no,
                        'expiry_date' => $value->expiry_date,
                        'uom_name' => $value->uom_name,
                        'delivered_qty' => $value->delivered_qty,
                        'discount_amount_itm' => $value->discount_amount_itm,
                        'total' => $value->total,
                        'net_total' => $value->net_total

                        // 'internal_batch_no_uq'=>$value->internal_batch_no_uq,
                        // 'expiry_date'=>$value->expiry_date,
                        // 'batch_no'=>$value->batch_no,
                        // 'purchase_price'=>$value->purchase_price,
                        // 'item_name'=>$value->item_name,
                        // 'serviceunit_name'=>$value->serviceunit_name,
                        // 'uom_code'=>$value->uom_code,
                        // 'uom_no_pk'=>$value->uom_no_pk,
                        // 'item_qty'=>$value->item_qty
                    ];
                }
            }
        }
        // dd($data);
        return Template::loadview("admin.uhl.inventory.grn_report.grn_item_list", [
            'data' => $data,
        ]);
    }


    public function searchItemIssueReportFMS(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        $query = DB::table('phr_itemissue_vw')->select(
            'itemissue_no_pk',
            'issue_date',
            'store_from_su_no_fk',
            'su_name_from',
            'su_name_to',
            'issue_to',
            'item_no_fk',
            'item_name',
            'uom_name',
            'item_qty',
            'trade_price',
            DB::raw('trade_price*item_qty as total'),
        );
        //  DD($query);
        if ($soter_no != "") {
            $query->where('store_from_su_no_fk', $soter_no);
        }
        // if ($item_id != "") {
        //     $query->where('item_no_fk', $item_id);
        // }
        // if ($internal_batch_no != "") {
        //     $query->where('internal_batch_no_uq', $internal_batch_no);
        // }


        if ($date_from != "" && $date_to != "") {
            $query->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to]);
            // $query->whereBetween('au_entry_at', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where(DB::raw("trunc(issue_date)"), $date_from);
        }

        $datas = $query //->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk')
            ->where('item_qty', '>', 0)
            ->orderBy('itemissue_no_pk', 'desc')->get();



        //  DD($datas);

        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->item_qty > 0) {
                    $data[] = (object)[

                        'itemissue_no_pk' => $value->itemissue_no_pk,
                        'issue_date' => $value->issue_date,
                        'store_from_su_no_fk' => $value->store_from_su_no_fk,
                        'su_name_from' => $value->su_name_from,
                        'su_name_to' => $value->su_name_to,
                        'issue_to' => $value->issue_to,
                        'item_no_fk' => $value->item_no_fk,
                        'item_name' => $value->item_name,
                        'uom_name' => $value->uom_name,
                        'item_qty' => $value->item_qty,
                        'trade_price' => $value->trade_price,
                        'total' => $value->total

                    ];
                }
            }
        }
        // dd($data);
        return Template::loadview("admin.uhl.inventory.Item_Issue_Report.issued_item_list_fms", [
            'data' => $data,
        ]);
    }



    public function searchItemIssueReportFMSNew(Request $request)
    {
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        $data = "";
        if ($request->sub_store_id != "" && $request->item_id_hidden != "" && $date_from != "" && $date_to != "") {
            $data = DB::table('item_issued_report_vw')->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
                ->where('store_from_su_no_fk', $request->sub_store_id)
                ->where('item_no', $request->item_id_hidden)
                ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
                ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        }

        if ($request->sub_store_id != "" && $request->item_id_hidden == "" && $date_from != "" && $date_to != "") {
            $data = DB::table('item_issued_report_vw')->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
                ->where('store_from_su_no_fk', $request->sub_store_id)
                ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
                ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        }

        return Template::loadview("admin.uhl.inventory.Item_Issue_Report.issued_item_list_fms_new", [
            'data' => $data,
        ]);
    }




    public function ItemIssueReportFMSPDFNew(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');



        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        $data = "";
        if ($request->sub_store_id != "" && $request->item_id_hidden != "" && $date_from != "" && $date_to != "") {
            $data = DB::table('item_issued_report_vw')->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
                ->where('store_from_su_no_fk', $request->sub_store_id)
                ->where('item_no', $request->item_id_hidden)
                ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
                ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        }

        if ($request->sub_store_id != "" && $request->item_id_hidden == "" && $date_from != "" && $date_to != "") {
            $data = DB::table('item_issued_report_vw')->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
                ->where('store_from_su_no_fk', $request->sub_store_id)
                ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
                ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        }

        // $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        // $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        // if ($request->sub_store_id != "" && $date_from != "" && $date_to != "") {
        //     $data = DB::table('item_issued_report_vw')->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
        //         ->where('store_from_su_no_fk', $request->sub_store_id)
        //         ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
        //         ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        // }

        // if ($request->item_id_hidden != "" && $date_from != "" && $date_to != "") {
        //     $data = DB::table('item_issued_report_vw')
        //         ->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
        //         ->where('item_no', $request->item_id_hidden)
        //         ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
        //         ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        // }

        // if ($date_from != "" && $date_to != "") {
        //     $data = DB::table('item_issued_report_vw')
        //         ->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
        //         ->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to])
        //         ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        // } elseif ($date_from != "") {
        //     $data =  DB::table('item_issued_report_vw')
        //         ->select('item_issued_report_vw.*', DB::raw('qty*rate as total'))
        //         ->where(DB::raw("trunc(issue_date)"), $date_from)
        //         ->where('qty', '>', 0)->orderBy('indent_no', 'desc')->get();
        // }

        $main_store_name = DB::table('sysc_serviceunit')
            ->select('serviceunit_name')
            ->where('serviceunit_no_pk', '=', $request->sub_store_id)
            ->where('main_store_ind', '=', 1)
            ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();

        $title = date('d-m-Y');
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
            $pdf = PDF::loadView("admin.uhl.inventory.Item_Issue_Report.issued-item-list-fms-new-pdf", [
                'data' => $data,
                'main_store_name' => $main_store_name,
                'barcode_no' => $barcode_no,
                'po_hospital_details' => $po_hospital_details
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream('issued_item_list_fms_pdf.pdf');
        }

        if ($request->hdn_report_type == 'EXCEL') {
            $pdf = [
                'data' => $data,
                'main_store_name' => $main_store_name,
                'barcode_no' => $barcode_no,
                'po_hospital_details' => $po_hospital_details
            ];
            $fileToExport = "issued_item_list";
            $html = View("admin.uhl.inventory.Item_Issue_Report.issued-item-list-fms-new-excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }




    public function expiredDatePopup($id)
    {
        $data = DB::table('inv_batchwise_stock_vw')->select('internal_batch_no_uq', 'expiry_date', 'batch_no', 'sales_price', 'item_no_fk')->where('internal_batch_no_uq', $id)->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'sales_price', 'item_no_fk')->orderBy('expiry_date', 'desc')->first();
        // dd( $data );
        return Template::loadview("admin.uhl.inventory.expired_date_popup", [
            'data' => $data,
        ]);
    }
    public function expireItemOutPopup($id, $qty = "", $batch = "", $exp_date = "", $p_price = "", $uom_no = "")
    {

        $data = DB::table('inv_batchwise_stock_vw')->select('internal_batch_no_uq', 'expiry_date', 'item_no_fk', 'item_name', 'stock_su_no_fk')->where('internal_batch_no_uq', $id)->groupBy('internal_batch_no_uq', 'expiry_date', 'item_no_fk', 'item_name', 'stock_su_no_fk')->orderBy('expiry_date', 'desc')->first();
        // dd( $p_price );
        return Template::loadview("admin.uhl.inventory.expired_item_out_popup", [
            'data' => $data,
            'qty' => $qty,
            'batch' => $batch,
            'exp_date' => $exp_date,
            'p_price' => $p_price,
            'uom_no' => $uom_no,
        ]);
    }

    public function expireItemOutUpdate(Request $request)
    {
        dd($request->all());
        try {
            $chalan_no = ''; //strval()
            $chalan_date = '';
            $store_su_no_fk = isset($request->store_id) ? intval($request->store_id) : 0;
            $po_no = '';
            $supplier_no_fk = null;
            $adjreason = '';
            $remarks = '';
            $item_pk_no_arr = $request->item_id;
            $trans_date =  date('Y-m-d', strtotime($request->date));
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $internal_batch_id = [];
            $batch_no = [];
            $exp_date = [];
            $itemremarks = [];

            if ($item_pk_no_arr != "") {
                for ($i = 0; $i < count($item_pk_no_arr); $i++) {
                    $item_pvms[$i] = null;
                    $item_pk_no[$i] = intval($request->item_id[$i]);
                    $item_qty[$i] = floatval($request->qty[$i]);
                    $item_uom[$i] = intval($request->uom_no_pk[$i]);
                    $item_price[$i] = floatval($request->p_price[$i]);
                    $item_entry_dtl[$i] = $i + 1;
                    $empty_arr[$i] = 0;
                    $itemremarks[$i] = $request->remarks[$i];
                    $internal_batch_id[$i] = $request->internal_exp_id[$i];
                    $batch_no[$i] = $request->batch[$i];
                    $exp_date[$i] = $request->exp_date[$i] != "" ? date('dmY', strtotime($request->exp_date[$i])) : '';
                }
            }

            $demand_no_fk = 0;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';


            $pdo = DB::getPdo();
            $transferIn = "EXPIRED";
            $stock_adjustment = $pdo->prepare("begin
            pkg_v1_inventory_all.prc_stockadjustment(
                    :in_challan_no,
                    :in_challan_date,
                    :in_store_su_no_fk,
                    :in_demand_no_fk,
                    :in_po_no,
                    :in_supplier_no_fk,
                    :in_transtype,
                    :in_adjreason,
                    :in_remarks,
                    :in_transdate,
                    :in_a_item_no_fk,
                    :in_item_batch_fk,
                    :in_item_expiry_dt,
                    :in_a_item_pvmsno,
                    :in_a_item_qty,
                    :in_a_item_uom,
                    :in_a_freeitem_qty,
                    :in_a_freeitem_uom,
                    :in_a_item_price,
                    :in_a_entry_serial_dtl,
                    :in_internal_batch_no_uq,
                    :in_cost_price,
                    :in_itmremarks,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_no_fk,
                    :out_itemtrans_uid);
                    end;
                    ");
            $stock_adjustment->bindparam('in_challan_no', $chalan_no);
            $stock_adjustment->bindparam('in_challan_date', $chalan_date);
            $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
            $stock_adjustment->bindparam('in_demand_no_fk', $demand_no_fk);
            $stock_adjustment->bindparam('in_po_no', $po_no);
            $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_no_fk);
            $stock_adjustment->bindparam('in_transtype', $transferIn);
            $stock_adjustment->bindparam('in_adjreason', $adjreason);
            $stock_adjustment->bindparam('in_remarks', $remarks);
            $stock_adjustment->bindparam('in_transdate', $trans_date);
            $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);
            $stock_adjustment->bindArray('in_internal_batch_no_uq', $internal_batch_id, count($internal_batch_id), $numelems, SQLT_CHR);
            $stock_adjustment->bindArray('in_cost_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
            $stock_adjustment->bindArray('in_itmremarks', $itemremarks, count($itemremarks), $numelems, SQLT_CHR);
            $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
            $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
            $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);
            // dd($stock_adjustment);
            $stock_adjustment->execute();



            DB::commit();
            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    // public function expiredDateUpdate(Request $request)
    // {
    //     dd($request->all());
    //     $exp_date = $request->update_expiry_date != "" ?  date('Y-m-d', strtotime($request->update_expiry_date)) : '';
    //     try {
    //         $data = [
    //             'expiry_date' => $exp_date,
    //             'batch_no' => $request->batch_no
    //         ];
    //         // dd($data);
    //         DB::table('inv_itemstocktranschd')->where('internal_batch_no_uq', $request->internal_exp_id)->update($data);
    //         DB::commit();
    //         $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
    //     } catch (\Throwable $th) {
    //         DB::rollback();
    //         $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
    //     }
    //     return response()->json($message);
    // }


    public function expiredDateUpdate(Request $request)
    {
        // dd($request->all());
        $exp_date = $request->update_expiry_date != "" ? date('Y-m-d', strtotime($request->update_expiry_date)) : '';
        $au_update_at = date('Y-m-d');
        $in_au_update_by = Auth::id();
        $in_au_update_session = 'Update slaes Price, batch and expiry';
        try {
            DB::beginTransaction(); // Make sure transaction starts

            // Update expiry_date and batch_no
            DB::table('inv_itemstocktranschd')
                ->where('internal_batch_no_uq', $request->internal_exp_id)
                ->update([
                    'expiry_date' => $exp_date,
                    'batch_no' => $request->batch_no
                ]);

            // Update sales_price in PHR_ITEMRECEIVEDTL
            DB::table('PHR_ITEMRECEIVEDTL')
                ->where('INTERNAL_BATCH_NO_UQ', $request->internal_exp_id)
                ->update([
                    'sales_price' => $request->sales_price,
                    'au_update_at' => $au_update_at,
                    'au_update_by' => $in_au_update_by,
                    'au_update_session' => $in_au_update_session
                ]);

            // Update sales_price in INV_BATCHWISERATE
            DB::table('INV_BATCHWISERATE')
                ->where('INTERNAL_BATCH_NO_UQ', $request->internal_exp_id)
                ->update([
                    'sales_price' => $request->sales_price,
                    'EXPIRE_DATE' => $exp_date,
                    'batch_no' => $request->batch_no,
                    'au_update_at' => $au_update_at,
                    'au_update_by' => $in_au_update_by,
                    'au_update_session' => $in_au_update_session
                ]);
                  // Update sales_price in sysc_serviceitem
                DB::table('sysc_serviceitem')
                ->where('item_no_pk', $request->item_no_fk)
                ->update([
                    'sales_price' => $request->sales_price,
                    'au_update_at' => $au_update_at,
                    'au_update_by' => $in_au_update_by,
                    'au_update_session' => $in_au_update_session
                ]);

            DB::commit();

            $message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollBack(); // Correct spelling: rollBack
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function expiredItemPdf(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $all_expiry = $request->all_expiry;
        $date_from = $request->indent_date_from != "" ? date('Y-m-d', strtotime($request->indent_date_from)) : '';
        $date_to = $request->indent_date_to != "" ? date('Y-m-d', strtotime($request->indent_date_to)) : '';
        $query = DB::table('inv_batchwise_stock_vw')
            ->leftJoin('phr_itemreceivedtl', 'phr_itemreceivedtl.itemreceivedtl_no_pk', 'inv_batchwise_stock_vw.itemreceivedtl_no_pk')
            ->leftJoin('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', 'inv_batchwise_stock_vw.item_no_fk')
            ->select('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.cost_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'phr_itemreceivedtl.itemreceive_no_fk', 'phr_itemreceivedtl.au_entry_at as grn_date', 'sysc_serviceitem_vw.supplier_name', DB::raw('sum(inv_batchwise_stock_vw.item_qty) as item_qty'));

        if ($soter_no != "") {
            $query->where('stock_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        // if ($type_code != "") {
        //     $query->where('itemadjment_type', $type_code);
        // }
        if ($all_expiry != "") {
            $toDate = date('Y-m-d');
            $query->where('inv_batchwise_stock_vw.expiry_date', '<=', $toDate);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('expiry_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('expiry_date', $date_from);
        }

        $datas = $query->groupBy('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.cost_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'phr_itemreceivedtl.itemreceive_no_fk', 'phr_itemreceivedtl.au_entry_at', 'sysc_serviceitem_vw.supplier_name')
            ->having(DB::raw('sum(inv_batchwise_stock_vw.item_qty)'), '>', 0)
            ->orderBy('inv_batchwise_stock_vw.expiry_date', 'desc')
            ->get();
        // dd($all_expiry, $datas);
        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->item_qty > 0) {
                    $data[] = (object)[
                        'internal_batch_no_uq' => $value->internal_batch_no_uq,
                        'expiry_date' => $value->expiry_date,
                        'batch_no' => $value->batch_no,
                        'purchase_price' => $value->purchase_price,
                        'cost_price' => $value->cost_price,
                        'item_name' => $value->item_name,
                        'serviceunit_name' => $value->serviceunit_name,
                        'uom_code' => $value->uom_code,
                        'item_qty' => $value->item_qty,
                        'itemreceive_no_fk' => $value->itemreceive_no_fk,
                        'grn_date' => $value->grn_date,
                        'supplier_name' => $value->supplier_name,
                    ];
                }
            }
        }
        // dd($data);
        $title = date('d-m-Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // return View("admin.uhl.inventory.expired_item_pdf", [
        //     'data' => $data,
        //     'barcode_no' => $barcode_no,
        // ]);

        $pdf =  ["type" => "pdf",   'data' => $data];
        $fileToExport = "expired_item_pdf";
        $html = View("admin.uhl.inventory.expired_item_pdf")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }



    public function grnItemPdf(Request $request)
    {
        //  dd($request);

        // dd($request->print_type);
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        // $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        // $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';


        //   dd($date_from, $date_to,$soter_no);

        $query = DB::table('phr_v1_grn_vw')->select('itemreceive_no_pk', 'au_entry_at', 'po_no', 'pr_no', 'item_no_fk', 'item_name', 'purchase_price', 'batch_no', 'expiry_date', 'uom_name', 'delivered_qty', 'discount_amount_itm', DB::raw('purchase_price*delivered_qty as total'), DB::raw('purchase_price*delivered_qty - discount_amount_itm as net_total'));

        $main_store_name = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_name')
            ->where('serviceunit_no_pk', '=', $soter_no)
            ->where('main_store_ind', '=', 1)
            ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();

        // DD($main_store_name);

        if ($soter_no != "") {
            $query->where('store_su_no_fk', $soter_no);
        }
        // if ($item_id != "") {
        //     $query->where('item_no_fk', $item_id);
        // }
        // if ($internal_batch_no != "") {
        //     $query->where('internal_batch_no_uq', $internal_batch_no);
        // }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween(DB::raw("trunc(au_entry_at)"), [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('au_entry_at', $date_from);
        }

        $datas = $query //->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk')
            ->where('delivered_qty', '>', 0)
            ->orderBy('itemreceive_no_pk', 'desc')->get();

        //DD($datas);

        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->delivered_qty > 0) {
                    $data[] = (object)[

                        'itemreceive_no_pk' => $value->itemreceive_no_pk,
                        'au_entry_at' => $value->au_entry_at,
                        'po_no' => $value->po_no,
                        'pr_no' => $value->pr_no,
                        'item_no_fk' => $value->item_no_fk,
                        'item_name' => $value->item_name,
                        'purchase_price' => $value->purchase_price,
                        'batch_no' => $value->batch_no,
                        'expiry_date' => $value->expiry_date,
                        'uom_name' => $value->uom_name,
                        'delivered_qty' => $value->delivered_qty,
                        'discount_amount_itm' => $value->discount_amount_itm,
                        'total' => $value->total,
                        'net_total' => $value->net_total
                    ];
                }
            }
        }

        $title = date('d-m-Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if ($request->print_type == "pdf_store_wise") {
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView("admin.uhl.inventory.grn_report.grn_item_pdf", [
                'data' => $data,
                'barcode_no' => $barcode_no,
                'main_store_name' => $main_store_name,
            ])->setPaper('a4', 'landscape');
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream('grn_item_pdf.pdf');
        } elseif ($request->print_type == "excel_store_wise") {
            //   dd('Error');
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=grn_report_date_wise_{$date_from}_to_{$date_to}.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", 'GRN No', 'GRN Date', 'PO No', 'PR No', 'Item No', 'Item Name', 'Purchase Price', 'Batch No', 'Expiry Date', 'UoM', 'Qty', 'Total', 'Discount', 'Net Total');
            $callback = function () use ($columns, $data) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($data)) {
                    foreach ($data as $value) {

                        fputcsv($file, array(
                            $c,
                            $value->itemreceive_no_pk,
                            $value->au_entry_at,
                            $value->po_no,
                            $value->pr_no,
                            $value->item_no_fk,
                            $value->item_name,
                            $value->purchase_price,
                            $value->batch_no,
                            $value->expiry_date,
                            $value->uom_name,
                            $value->delivered_qty,
                            $value->total,
                            $value->discount_amount_itm,
                            $value->net_total
                        ));
                        $c++;
                    }
                }


                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
            // return View("admin.uhl.inventory.grn_report.grn_item_pdf", [
            //     'data' => $data,
            //     'barcode_no' => $barcode_no,
            //     'main_store_name' => $main_store_name,
            // ]);
        }
    }


    public function searchItemIssueReportFMSPDF(Request $request)
    {
        //  dd($request);

        // dd($request->print_type);
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->sub_store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';


        $query = DB::table('phr_itemissue_vw')->select(
            'itemissue_no_pk',
            'issue_date',
            'store_from_su_no_fk',
            'su_name_from',
            'su_name_to',
            'issue_to',
            'item_no_fk',
            'item_name',
            'uom_name',
            'item_qty',
            'trade_price',
            DB::raw('trade_price*item_qty as total'),
        );
        $main_store_name = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_name')
            ->where('serviceunit_no_pk', '=', $soter_no)
            ->where('main_store_ind', '=', 1)
            ->where('main_store_module_no_fk', '=', 18)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();

        //  DD($query);
        if ($soter_no != "") {
            $query->where('store_from_su_no_fk', $soter_no);
        }


        if ($date_from != "" && $date_to != "") {
            $query->whereBetween(DB::raw("trunc(issue_date)"), [$date_from, $date_to]);
            // $query->whereBetween('au_entry_at', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where(DB::raw("trunc(issue_date)"), $date_from);
        }

        $datas = $query //->groupBy('internal_batch_no_uq', 'expiry_date', 'batch_no', 'purchase_price', 'item_name', 'serviceunit_name', 'uom_code', 'uom_no_pk')
            ->where('item_qty', '>', 0)
            ->orderBy('itemissue_no_pk', 'desc')->get();



        //  DD($datas);

        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->item_qty > 0) {
                    $data[] = (object)[

                        'itemissue_no_pk' => $value->itemissue_no_pk,
                        'issue_date' => $value->issue_date,
                        'store_from_su_no_fk' => $value->store_from_su_no_fk,
                        'su_name_from' => $value->su_name_from,
                        'su_name_to' => $value->su_name_to,
                        'issue_to' => $value->issue_to,
                        'item_no_fk' => $value->item_no_fk,
                        'item_name' => $value->item_name,
                        'uom_name' => $value->uom_name,
                        'item_qty' => $value->item_qty,
                        'trade_price' => $value->trade_price,
                        'total' => $value->total

                    ];
                }
            }
        }

        $title = date('d-m-Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if ($request->print_type == "pdf_store_wise") {
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView("admin.uhl.inventory.Item_Issue_Report.issued_item_list_fms_pdf", [
                'data' => $data,
                'barcode_no' => $barcode_no,
                'main_store_name' => $main_store_name,
            ]);
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream('issued_item_list_fms_pdf.pdf');
        } elseif ($request->print_type == "excel_store_wise") {
            //   dd('Error');
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=issued_report_date_wise_{$date_from}_to_{$date_to}.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );

            $columns = array("SL", 'Issue No', 'Issue Date', 'Issue From', 'Issue To', 'Item No', 'Item Name', 'UoM', 'Qty', 'Rate', 'Total');
            $callback = function () use ($columns, $data) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($data)) {
                    foreach ($data as $value) {
                        fputcsv($file, array(
                            $c,
                            $value->itemissue_no_pk,
                            $value->issue_date,
                            $value->su_name_from,
                            $value->su_name_to,
                            $value->item_no_fk,
                            $value->item_name,
                            $value->uom_name,
                            $value->item_qty,
                            $value->trade_price,
                            $value->total
                        ));
                        $c++;
                    }
                }


                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
            // return View("admin.uhl.inventory.grn_report.grn_item_pdf", [
            //     'data' => $data,
            //     'barcode_no' => $barcode_no,
            //     'main_store_name' => $main_store_name,
            // ]);
        }
    }




    public function regularItemStockLow()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $sub_store_list = ServiceUnit::select('serviceunit_name', 'serviceunit_no_pk')->whereRaw('main_store_ind = 1 or sub_store_ind =1')->where('status', 1)->get();


        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $stocks = [];

        $total_item = [];
        $total_amt = [];
        $total_sales_amt = [];

        return Template::loadview("admin.uhl.inventory.regular_item_stock_low", [
            'sub_store_list' => $sub_store_list,
            'main_store_list' => $main_store_list,
            'pack_type' => $pack_type,
            'allSuppliers' => $allSuppliers,
            'stocks' => $stocks,
            'total_item' => $total_item,
            'total_amt' => $total_amt,
            'total_sales_amt' => $total_sales_amt
        ]);
    }


    public function regularItemStockLowSearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        // $query = DB::table('inv_batchwise_stock_vw')->select('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', DB::raw('sum(inv_batchwise_stock_vw.item_qty) as item_qty'))->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_batchwise_stock_vw.item_no_fk');
        $query = DB::table('inv_batchwise_stock_vw')->select('inv_batchwise_stock_vw.item_name',  'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', 'inv_batchwise_stock_vw.serviceunit_name', DB::raw('sum(inv_batchwise_stock_vw.item_qty) as item_qty'))->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_batchwise_stock_vw.item_no_fk');

        if ($soter_no != "") {
            $query->where('stock_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('expiry_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('expiry_date', $date_from);
        }

        // $datas = $query
        //     ->where('sysc_serviceitem.regular_inventory_item_ind', 1)
        //     ->groupBy('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level')
        //     ->orderBy('expiry_date', 'desc')->get();
        $datas = $query
            ->where('sysc_serviceitem.regular_inventory_item_ind', 1)
            ->groupBy('inv_batchwise_stock_vw.item_name',  'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', 'inv_batchwise_stock_vw.serviceunit_name')
            ->orderBy('re_order_level', 'asc')->get();
        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->re_order_level >= $value->item_qty && $value->item_qty >= 0) {
                    $data[] = (object) [
                        // 'internal_batch_no_uq' => $value->internal_batch_no_uq,
                        // 'expiry_date' => $value->expiry_date,
                        // 'batch_no' => $value->batch_no,
                        // 'purchase_price' => $value->purchase_price,
                        'item_name' => $value->item_name,
                        'serviceunit_name' => $value->serviceunit_name,
                        'uom_code' => $value->uom_code,
                        're_order_level' => $value->re_order_level,
                        'item_qty' => $value->item_qty,

                    ];
                }
            }
        }
        // dd($data);
        return Template::loadview("admin.uhl.inventory.regular_item_stock_low_list", [
            'data' => $data,
        ]);
    }
    public function regularItemStockLowPdf(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $soter_no = $request->store_id;
        $item_id = $request->item_id;
        $internal_batch_no = $request->internal_batch_no;
        $type_code = $request->type_code;
        $date_from = $request->indent_date_from != "" ? date('Y-m-d', strtotime($request->indent_date_from)) : '';
        $date_to = $request->indent_date_to != "" ? date('Y-m-d', strtotime($request->indent_date_to)) : '';
        // $query = DB::table('inv_batchwise_stock_vw')->select('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', DB::raw('sum(inv_batchwise_stock_vw.item_qty) as item_qty'))->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_batchwise_stock_vw.item_no_fk');

        $query = DB::table('inv_batchwise_stock_vw')->select('inv_batchwise_stock_vw.item_name',  'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', 'inv_batchwise_stock_vw.serviceunit_name', DB::raw('sum(inv_batchwise_stock_vw.item_qty) as item_qty'))->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_batchwise_stock_vw.item_no_fk');

        if ($soter_no != "") {
            $query->where('stock_su_no_fk', $soter_no);
        }
        if ($item_id != "") {
            $query->where('item_no_fk', $item_id);
        }
        if ($internal_batch_no != "") {
            $query->where('internal_batch_no_uq', $internal_batch_no);
        }
        if ($date_from != "" && $date_to != "") {
            $query->whereBetween('expiry_date', [$date_from, $date_to]);
        } elseif ($date_from != "") {
            $query->where('expiry_date', $date_from);
        }

        // $datas = $query
        //     ->where('sysc_serviceitem.regular_inventory_item_ind', 1)
        //     ->groupBy('inv_batchwise_stock_vw.internal_batch_no_uq', 'inv_batchwise_stock_vw.expiry_date', 'inv_batchwise_stock_vw.batch_no', 'inv_batchwise_stock_vw.purchase_price', 'inv_batchwise_stock_vw.item_name', 'inv_batchwise_stock_vw.serviceunit_name', 'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level')
        //     ->orderBy('expiry_date', 'desc')->get();

        $datas = $query
            ->where('sysc_serviceitem.regular_inventory_item_ind', 1)
            ->groupBy('inv_batchwise_stock_vw.item_name',  'inv_batchwise_stock_vw.uom_code', 'sysc_serviceitem.re_order_level', 'inv_batchwise_stock_vw.serviceunit_name')
            ->orderBy('re_order_level', 'asc')->get();
        $data = [];
        if (!empty($datas)) {
            foreach ($datas as $key => $value) {
                if ($value->re_order_level >= $value->item_qty && $value->item_qty >= 0) {
                    $data[] = (object) [
                        // 'internal_batch_no_uq' => $value->internal_batch_no_uq,
                        // 'expiry_date' => $value->expiry_date,
                        // 'batch_no' => $value->batch_no,
                        // 'purchase_price' => $value->purchase_price,
                        'item_name' => $value->item_name,
                        'serviceunit_name' => $value->serviceunit_name,
                        'uom_code' => $value->uom_code,
                        're_order_level' => $value->re_order_level,
                        'item_qty' => $value->item_qty,

                    ];
                }
            }
        }
        $title = date('d-m-Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.uhl.inventory.regular_item_stock_low_pdf", [
            'data' => $data,
            'barcode_no' => $barcode_no,
        ]);
    }

    public function itemIssuePrint($id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $issue_data = DB::table("indent_to_issue_report_vw")
            ->select(
                'indent_to_issue_report_vw.issue_by',
                'indent_to_issue_report_vw.issue_from_store',
                'indent_to_issue_report_vw.issue_to_store',
                'indent_to_issue_report_vw.issue_no',
                'indent_to_issue_report_vw.issue_at',
                'indent_to_issue_report_vw.recv_by_name',
                'indent_to_issue_report_vw.recv_at',
                'indent_to_issue_report_vw.indent_no',
                'indent_to_issue_report_vw.item_no_fk',
                'indent_to_issue_report_vw.item_name',
                'indent_to_issue_report_vw.batch_no',
                'indent_to_issue_report_vw.uom',
                'indent_to_issue_report_vw.issue_qty',
                'indent_to_issue_report_vw.expiry_date',
                'sysc_serviceitem.purchase_price',
            )
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'indent_to_issue_report_vw.item_no_fk')
            ->where('indent_to_issue_report_vw.issue_no', $id)
            ->groupBy(
                'indent_to_issue_report_vw.issue_by',
                'indent_to_issue_report_vw.issue_from_store',
                'indent_to_issue_report_vw.issue_to_store',
                'indent_to_issue_report_vw.issue_no',
                'indent_to_issue_report_vw.issue_at',
                'indent_to_issue_report_vw.recv_by_name',
                'indent_to_issue_report_vw.recv_at',
                'indent_to_issue_report_vw.indent_no',
                'indent_to_issue_report_vw.item_no_fk',
                'indent_to_issue_report_vw.item_name',
                'indent_to_issue_report_vw.batch_no',
                'indent_to_issue_report_vw.uom',
                'indent_to_issue_report_vw.issue_qty',
                'indent_to_issue_report_vw.expiry_date',
                'sysc_serviceitem.purchase_price',
            )
            ->get();
        // dd( $issue_data);

        if (count($issue_data) == 0) {
            return view("admin.components.error_alert");
        }
        //    dd($issue_data);
        $barcode = new BarcodeGenerator();
        $barcode->setText($id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $userInfo = Auth::user();
        $pdf = App::make('dompdf.wrapper');

        $pdf = PDF::loadView("admin.uhl.inventory.issue_print", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'invoice_barcode' => $invoice_barcode,
            'issue_data' => $issue_data
        ]);


        return $pdf->stream("issue_print.pdf", array("Attachment" => false));
    }


    // stockTransferWorklist
    public function stockTransferWorklist()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferData =  DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(NVL(phr_itemadjmentrcvdtl.receive_qty,0)) AS receive_qty'),
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name AS from_store',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->join('sysc_serviceunit AS from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->join('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->whereDate('phr_itemadjmentdtl.au_entry_at', date('Y-m-d'))
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc')
            ->get();



        // dd($transferData);
        $trans_type = DB::table('phr_itemadjmentdtl')->distinct('ITEMADJMENT_TYPE')->select('ITEMADJMENT_TYPE')->where('au_entry_by', Auth::id())->get()->filter(function ($item) {
            return !is_null($item->itemadjment_type);
        });



        return Template::loadview("admin.store.stock_transfer_worklist", [
            'store' => $store,
            'allSuppliers' => $allSuppliers,
            'transferDataPending' => $transferData,
            'trans_type' => $trans_type
        ]);
    }
    public function supplierReturnWorklist()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferData =  DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(NVL(phr_itemadjmentrcvdtl.receive_qty,0)) AS receive_qty'),
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name AS from_store',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->join('sysc_serviceunit AS from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->join('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->whereDate('phr_itemadjmentdtl.au_entry_at', date('Y-m-d'))
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc')
            ->get();



        // dd($transferData);
        $trans_type = DB::table('phr_itemadjmentdtl')->distinct('ITEMADJMENT_TYPE')->select('ITEMADJMENT_TYPE')->where('au_entry_by', Auth::id())->whereIn('ITEMADJMENT_TYPE', ['SUPRTN', 'SUPRTNRCV'])->get()->filter(function ($item) {
            return !is_null($item->itemadjment_type);
        });



        return Template::loadview("admin.store.supplier_return_worklist", [
            'store' => $store,
            'allSuppliers' => $allSuppliers,
            'transferDataPending' => $transferData,
            'trans_type' => $trans_type
        ]);
    }
    public function stockTransferWorkListShow()
    {
        $stores = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('PHARMACY_IND', '=', 1)
            // ->where('hospital_store_ind', '=', 1)
            ->where(function ($query) {
                $query->where('sub_store_ind', 1)
                    ->orWhere('main_store_ind', 1);
            })
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferData = DB::table('phr_itemadjmentdtl')
            ->select(
                'phr_itemadjmentdtl.*',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
                DB::raw('CASE
                    WHEN phr_itemadjmentdtl.ITEMADJMENTDTLL_NO_PK IN (SELECT ITEMADJMENTDTLL_NO_FK FROM PHR_ITEMADJMENTRCVDTL) THEN \'Received\'
                    ELSE \'Pending\'
                END as status')
            )
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->orderBy('phr_itemadjmentdtl.itemadjmentdtll_no_pk', 'desc')
            ->get();
        // dd($transferData);

        return Template::loadview("admin.store.stock_transfer_worklist_list", [
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,
            'transferData' => $transferData
        ]);
    }
    public function stockTransferPendingListShow()
    {
        $stores = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('PHARMACY_IND', '=', 1)
            // ->where('hospital_store_ind', '=', 1)
            ->where(function ($query) {
                $query->where('sub_store_ind', 1)
                    ->orWhere('main_store_ind', 1);
            })
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $transferDataPending =  DB::table('phr_itemadjmentrcvdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty) as receive_qty'),
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname'
            )
            // ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentrcvdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemadjmentrcvdtl.au_entry_by')
            ->groupBy(
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname'
            )
            ->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '<', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)'))
            ->orderBy('phr_itemadjmentrcvdtl.item_no_fk', 'desc') // Use a column in the SELECT clause
            ->get();

        // DB::table('phr_itemadjmentrcvdtl')
        //     ->select(DB::raw('sum(phr_itemadjmentrcvdtl.receive_qty)'),'phr_itemadjmentrcvdtl.item_no_fk','phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk','phr_itemadjmentrcvdtl.itemadjment_no_fk','phr_itemadjmentrcvdtl.uom','phr_itemadjmentrcvdtl.from_store_no_fk','phr_itemadjmentrcvdtl.store_su_no_fk','phr_itemadjmentrcvdtl.itemadjment_type','phr_itemadjmentrcvdtl.internal_batch_no_uq','phr_itemadjmentrcvdtl.batch_no','phr_itemadjmentrcvdtl.expiry_date','phr_itemadjmentrcvdtl.item_qty','phr_itemadjmentrcvdtl.purchase_price','phr_itemadjmentrcvdtl.cost_price','phr_itemadjmentrcvdtl.au_entry_at','sysc_serviceitem_vw.item_name','sysc_serviceitem_vw.uom_name','from_store.serviceunit_name as from_store','to_store.serviceunit_name as to_store','wsec_user.user_fullname')
        //     ->join('sysc_serviceitem_vw','sysc_serviceitem_vw.item_no_pk','phr_itemadjmentrcvdtl.item_no_fk')
        //     ->join('sysc_serviceunit from_store','from_store.serviceunit_no_pk','phr_itemadjmentrcvdtl.from_store_no_fk')
        //     ->join('sysc_serviceunit to_store','to_store.serviceunit_no_pk','phr_itemadjmentrcvdtl.store_su_no_fk')
        //     ->join('wsec_user','wsec_user.user_no_pk','phr_itemadjmentrcvdtl.au_entry_by')
        //     // ->whereNotIn('phr_itemadjmentrcvdtl.ITEMADJMENTDTLL_NO_PK', function($query) {
        //     //     $query->select('ITEMADJMENTDTLL_NO_FK')
        //     //         ->from('PHR_ITEMADJMENTRCVDTL');
        //     // })
        //     ->groupBy('phr_itemadjmentrcvdtl.item_no_fk','phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk','phr_itemadjmentrcvdtl.itemadjment_no_fk','phr_itemadjmentrcvdtl.uom','phr_itemadjmentrcvdtl.from_store_no_fk','phr_itemadjmentrcvdtl.store_su_no_fk','phr_itemadjmentrcvdtl.itemadjment_type','phr_itemadjmentrcvdtl.internal_batch_no_uq','phr_itemadjmentrcvdtl.batch_no','phr_itemadjmentrcvdtl.expiry_date','phr_itemadjmentrcvdtl.item_qty','phr_itemadjmentrcvdtl.purchase_price','phr_itemadjmentrcvdtl.cost_price','phr_itemadjmentrcvdtl.au_entry_at','sysc_serviceitem_vw.item_name','sysc_serviceitem_vw.uom_name','from_store.serviceunit_name as from_store','to_store.serviceunit_name as to_store','wsec_user.user_fullname')
        //     ->orderBy('phr_itemadjmentrcvdtl.itemadjmentrcvdtl_no_pk','desc')
        //     ->get();
        // dd($transferDataPending);

        return Template::loadview("admin.store.stock_transfer_pending_list_show", [
            'stores' => $stores,
            'allSuppliers' => $allSuppliers,
            'transferDataPending' => $transferDataPending
        ]);
    }
    public function stockTransferFullReceivedListShow(Request $request)
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        // $allSuppliers = DB::table('INV_SUPPLIER')
        //     ->select('supplier_no_pk', 'supplier_name')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query =  DB::table('phr_itemadjmentrcvdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty) as receive_qty'),
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
            )
            // ->join('sysc_serviceitem_vw', 'sysc_serviceitem_vw.item_no_pk', '=', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentrcvdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentrcvdtl.uom')
            ->join('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.from_store_no_fk')
            ->join('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', '=', 'phr_itemadjmentrcvdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', '=', 'phr_itemadjmentrcvdtl.au_entry_by')
            ->groupBy(
                'phr_itemadjmentrcvdtl.item_no_fk',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_no_fk',
                'phr_itemadjmentrcvdtl.uom',
                'phr_itemadjmentrcvdtl.from_store_no_fk',
                'phr_itemadjmentrcvdtl.store_su_no_fk',
                'phr_itemadjmentrcvdtl.itemadjment_type',
                'phr_itemadjmentrcvdtl.internal_batch_no_uq',
                'phr_itemadjmentrcvdtl.batch_no',
                'phr_itemadjmentrcvdtl.expiry_date',
                'phr_itemadjmentrcvdtl.item_qty',
                'phr_itemadjmentrcvdtl.purchase_price',
                'phr_itemadjmentrcvdtl.cost_price',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname'
            );
        // dd($request->type,$twoMonthsAgo,now()->format('Y-m-d'));
        if ($request->type == 1) {
            $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $twoMonthsAgo)
                ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', now()->format('Y-m-d'))
                ->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)'))
                ->orderBy('phr_itemadjmentrcvdtl.item_no_fk', 'desc'); // Use a column in the SELECT clause
        } else {
            $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
            $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
            if ($request->from_store != "") {
                $query->where('from_store_no_fk', $request->from_store);
            }
            if ($request->to_store != "") {
                $query->where('store_su_no_fk', $request->to_store);
            }
            if ($request->trans_type != "") {
                $query->where('itemadjment_type', $request->trans_type);
            }
            if ($request->trans_id != "") {
                $query->where('itemadjment_no_fk', $request->trans_id);
            }
            if ($request->date_from != "" && $request->date_to) {
                $query->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '>=', $date_from)
                    ->whereDate('phr_itemadjmentrcvdtl.au_entry_at', '<=', $date_to);
            }

            $query->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
            $query->addSelect('phr_itemadjmentrcvdtl.au_entry_at'); // Add the new column
            $query->groupBy('phr_itemadjmentrcvdtl.au_entry_at');
            // dd($request->all());
        }



        $transferDataPending = $query->get();


        return Template::loadview("admin.store.stock_transfer_receive_full_received_list", [
            'store' => $store,
            'transferDataPending' => $transferDataPending,
            'type' => $request->type
        ]);
    }
    public function stockTransferSearchListShow(Request $request)
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('user_no_pk', Auth::id())
            ->where(function ($query) {
                $query->where('main_store_ind', 1)
                    ->orWhere('sub_store_ind', 1);
            })->get();

        // $allSuppliers = DB::table('INV_SUPPLIER')
        //     ->select('supplier_no_pk', 'supplier_name')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query = DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(NVL(phr_itemadjmentrcvdtl.receive_qty,0)) AS receive_qty'),
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name AS from_store',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->leftJoin('sysc_serviceunit AS from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->leftJoin('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'from_store.serviceunit_name',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentdtl.itemadjmentdtll_no_pk' // Add this line
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc');

        // dd($request->type,$twoMonthsAgo,now()->format('Y-m-d'));

        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';
        if ($request->from_store != "") {
            $query->where('phr_itemadjmentdtl.from_store_no_fk', $request->from_store);
        }
        if ($request->to_store != "") {
            $query->where('phr_itemadjmentdtl.store_su_no_fk', $request->to_store);
        }
        if ($request->trans_type != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_type', $request->trans_type);
        }
        if ($request->trans_id != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_no_fk', $request->trans_id);
        }
        if ($request->date_from != "" && $request->date_to) {
            $query->whereDate('phr_itemadjmentdtl.au_entry_at', '>=', $date_from)
                ->whereDate('phr_itemadjmentdtl.au_entry_at', '<=', $date_to);
        }
        //    dd($request->trans_type);
        // $query->having(DB::raw('SUM(phr_itemadjmentrcvdtl.receive_qty)'), '=', DB::raw('MAX(phr_itemadjmentrcvdtl.item_qty)')); // Add the new column
        // $query->addSelect('phr_itemadjmentdtl.au_entry_at'); // Add the new column
        // $query->groupBy('phr_itemadjmentrcvdtl.au_entry_at');
        // dd($request->all());




        $transferDataPending = $query->get();
        // dd(  $transferDataPending);

        return Template::loadview("admin.store.stock_transfer_worklist_list", [
            'store' => $store,
            'transferDataPending' => $transferDataPending,
            'type' => $request->type
        ]);
    }
    public function supplierReturnListShow(Request $request)
    {
        // $store = DB::table('sysc_v1_grant_servieceunit_vw')
        // ->select('serviceunit_name', 'serviceunit_no_pk')
        // ->where('user_no_pk', Auth::id())
        // ->where(function ($query) {
        //     $query->where('main_store_ind', 1)
        //     ->orWhere('sub_store_ind', 1);
        //  })->get();

        // $allSuppliers = DB::table('INV_SUPPLIER')
        //     ->select('supplier_no_pk', 'supplier_name')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->get();
        $twoMonthsAgo = Carbon::now()->subMonths(2)->format('Y-m-d');
        $query = DB::table('phr_itemadjmentdtl')
            ->select(
                DB::raw('SUM(phr_itemadjmentdtl.item_qty) AS item_qty'),
                DB::raw('NVL(SUM(phr_expire_medicine_return.total_amount),0) AS total_return_amount'),
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'to_store.serviceunit_name AS to_store',
                'wsec_user.user_fullname',
                'inv_supplier.supplier_name',
            )

            ->leftJoin('phr_expire_medicine_return', function ($join) {
                $join->on('phr_expire_medicine_return.stocktrans_no_pk', '=', 'phr_itemadjmentdtl.itemadjment_no_fk')
                    ->on('phr_expire_medicine_return.item_no_fk', '=', 'phr_itemadjmentdtl.item_no_fk');
            })

            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', 'phr_expire_medicine_return.supplier_no_fk')
            ->leftJoin('sysc_serviceunit AS to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->where('phr_itemadjmentdtl.au_entry_by', Auth::id())
            ->whereIn('phr_itemadjmentdtl.itemadjment_type', ['SUPRTN', 'SUPRTNRCV'])
            ->groupBy(
                'phr_itemadjmentdtl.itemadjment_no_fk',
                'phr_itemadjmentdtl.au_entry_at',
                'phr_itemadjmentdtl.itemadjment_type',
                'to_store.serviceunit_name',
                'wsec_user.user_fullname',
                'inv_supplier.supplier_name',
            )
            ->orderBy('phr_itemadjmentdtl.itemadjment_no_fk', 'desc');
        // dd($request->trans_type);
        $date_from = $request->date_from != "" ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to != "" ? date('Y-m-d', strtotime($request->date_to)) : '';

        if ($request->to_store != "") {
            $query->where('phr_itemadjmentdtl.store_su_no_fk', $request->to_store);
        }
        if ($request->supplier != "") {
            $query->where('phr_expire_medicine_return.supplier_no_fk', $request->supplier);
        }
        if ($request->trans_type != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_type', $request->trans_type);
        }
        if ($request->trans_id != "") {
            $query->where('phr_itemadjmentdtl.itemadjment_no_fk', $request->trans_id);
        }
        if ($request->date_from != "" && $request->date_to) {
            $query->whereDate('phr_itemadjmentdtl.au_entry_at', '>=', $date_from)
                ->whereDate('phr_itemadjmentdtl.au_entry_at', '<=', $date_to);
        }





        $transferDataPending = $query->get();
        // dd(  $transferDataPending);

        return Template::loadview("admin.store.supplier_return_worklist_list", [
            'transferDataPending' => $transferDataPending,
            'type' => $request->type
        ]);
    }

    public function stockTransferDetails($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $transferData = DB::table('phr_itemadjmentdtl')
            ->distinct()
            ->select(
                'phr_itemadjmentdtl.*',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
                'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                'phr_itemadjmentrcvdtl.receive_qty',
            )
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentdtl.item_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentdtl.uom')
            ->leftJoin('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->leftJoin('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->where('phr_itemadjmentdtl.itemadjment_no_fk', $id)
            ->orderBy('phr_itemadjmentdtl.itemadjmentdtll_no_pk', 'desc')
            ->get();

        $type = '';
        if (isset($transferData[0]->itemadjment_type) && !empty($transferData[0]->itemadjment_type)) {
            $type = $transferData[0]->itemadjment_type;
        } else {
            $type = '';
        }

        return view('admin.store.stock_transfer_print_worklist', [
            'transferData' => $transferData,
            'po_hospital_details' => $po_hospital_details,
            'type' => $type

        ]);
    }
    public function supplierReturnDetails($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $transferData = DB::table('phr_itemadjmentdtl')
            ->distinct()
            ->select(
                'phr_itemadjmentdtl.*',
                'sysc_serviceitem.item_name',
                'sysc_serviceitem_uom.uom_code as uom_name',
                // 'from_store.serviceunit_name as from_store',
                'to_store.serviceunit_name as to_store',
                'wsec_user.user_fullname',
                // 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk',
                // 'phr_itemadjmentrcvdtl.receive_qty',
                'inv_supplier.supplier_name',
                'phr_expire_medicine_return.total_amount'
            )
            ->join('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'phr_itemadjmentdtl.item_no_fk')
            ->leftJoin('phr_expire_medicine_return', function ($join) {
                $join->on('phr_expire_medicine_return.stocktrans_no_pk', '=', 'phr_itemadjmentdtl.itemadjment_no_fk')
                    ->on('phr_expire_medicine_return.item_no_fk', '=', 'phr_itemadjmentdtl.item_no_fk');
            })
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', 'phr_expire_medicine_return.supplier_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'phr_itemadjmentdtl.uom')
            // ->leftJoin('sysc_serviceunit as from_store', 'from_store.serviceunit_no_pk', 'phr_itemadjmentdtl.from_store_no_fk')
            ->leftJoin('sysc_serviceunit as to_store', 'to_store.serviceunit_no_pk', 'phr_itemadjmentdtl.store_su_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'phr_itemadjmentdtl.au_entry_by')
            // ->leftJoin('phr_itemadjmentrcvdtl', 'phr_itemadjmentrcvdtl.itemadjmentdtll_no_fk', 'phr_itemadjmentdtl.itemadjmentdtll_no_pk')
            ->where('phr_itemadjmentdtl.itemadjment_no_fk', $id)
            ->orderBy('phr_itemadjmentdtl.itemadjmentdtll_no_pk', 'desc')
            ->get();
        // dd($transferData);

        return view('admin.store.supplier_return_print_worklist', [
            'transferData' => $transferData,
            'po_hospital_details' => $po_hospital_details
        ]);
    }

    // In your Controller (e.g., StockController.php)

    public function fetchSelectedStocks(Request $request)
    {
    //    dd($request->all);
        $stockIds = $request->input('stock_ids');
        $storeType = $request->input('storeName');
    //  dd($stockIds,$storeType);
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
        // $query = DB::table('stock_ledger_vw sl')
        //     ->select('sl.*', 'ser.*', 'supp.*', 'ty.item_type_name')
        //     ->leftJoin('sysc_serviceitem ser', 'ser.item_no_pk', '=', 'sl.item_no_fk')
        //     ->leftJoin('sysc_itemtype ty', 'ty.itemtype_no_pk', '=', 'ser.itemtype_no_fk')
        //     ->leftJoin('inv_supplier supp', 'supp.supplier_no_pk', '=', 'ser.supplier_pk_no');
        // if (!empty($stockIds)) {
        //     // Assuming `item_code` is the column you want to filter by
        //     $query->whereIn('sl.item_no_fk', $stockIds); // Filter by item_code
        // }

        // $storeType
        $stocks = DB::select("SELECT
    SL.*,
    SER.*,
    SUPP.*,
    TY.ITEM_TYPE_NAME
FROM
    STOCK_LEDGER_VW SL
    LEFT JOIN SYSC_SERVICEITEM SER ON SER.ITEM_NO_PK = SL.ITEM_NO_FK
    LEFT JOIN SYSC_ITEMTYPE TY ON TY.ITEMTYPE_NO_PK = SER.ITEMTYPE_NO_FK
    LEFT JOIN INV_SUPPLIER SUPP ON SUPP.SUPPLIER_NO_PK = SER.SUPPLIER_PK_NO
WHERE
    SL.item_no_fk IN ($stockIds) and SL.STOCK_SU_NO_FK = $storeType
ORDER BY
    SL.ITEM_NAME ASC");
        $storeWiseStocks = [];
        if (!empty($stocks)) {
            foreach ($stocks as $stock) {
                $storeWiseStocks[$stock->stock_su_no_fk]['store_name'] = $stock->store_name;
                $storeWiseStocks[$stock->stock_su_no_fk]['stocks'][$stock->supplier_no_pk . '_' . $stock->supplier_name][] = $stock;
            }
        }



        $data['type'] = 'store';
        $data['stocks'] = $storeWiseStocks;
        $data['po_hospital_details'] = $po_hospital_details;
        // dd($storeWiseStocks);

        $pdf = App::make('dompdf.wrapper');
        return view('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no]);

        // $pdf = PDF::loadView('admin.store.stock_ledger_pdf', ['type' => 'store', 'stocks' => $storeWiseStocks, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'portrait');
        // return $pdf->stream("stock_ledger_pdf", array("Attachment" => false));

        $itemWiseStocks = [];
        if (!empty($stocks)) {
            $totalStocks = 0;
            foreach ($stocks as $stock) {
                $itemWiseStocks[$stock->item_no_fk]['item_name'] = $stock->item_name;
                $itemWiseStocks[$stock->item_no_fk]['item_code'] = $stock->item_code;
                $itemWiseStocks[$stock->item_no_fk]['purchase_price'] = $stock->purchase_price;
                $itemWiseStocks[$stock->item_no_fk]['sales_price'] = $stock->sales_price;
                $itemWiseStocks[$stock->item_no_fk]['pack_type'] = $stock->pack_type;
                //                    $itemWiseStocks[$stock->item_no_fk]['pvms_no'] = $stock->pvms_no;
                $itemWiseStocks[$stock->item_no_fk]['uom_name'] = $stock->uom_name;
                $itemWiseStocks[$stock->item_no_fk]['re_order_level'] = $stock->re_order_level;
                $itemWiseStocks[$stock->item_no_fk]['current_stocks'][] = $stock->current_stock;
            }
        }

        $data['type'] = 'item';
        $data['stocks'] = $itemWiseStocks;
        return $this->generatePdf('admin.store.stock_ledger_pdf', "StoreLedger", $data);
    }


    //-- UOM Setup --//
    public function uomSetup()
    {
        return Template::loadview("admin.store.uom_setup");
    }

    public function getUom(){
        $uom = DB::table('sysc_serviceitem_uom')
        ->select('sysc_serviceitem_uom.*')
        ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        ->orderBy('au_entry_at', 'desc')
        ->get();

        // dd($uom);
        return response()->json(['data' => $uom]);
    }


    public function uomForm(){
        return Template::loadview("admin.store.create_uom_form");
    }



    public function saveUom(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $au_entry_hospital_no_fk = Session::get('user.ses_hospital_no_pk');


        DB::beginTransaction();
        try {
            if ($id == "") {
                $sequence = DB::getSequence();
                $uom_no_pk  = $sequence->nextValue('uom_no_pk_seq');
                $data = [
                    'uom_no_pk' => $uom_no_pk,
                    'uom_code'  => $request->uom_code,
                    'uom_label_desc' => 1,
                    'STATUS'    => $request->status ? 1 : 0,
                    'au_entry_by' => $auth_id,
                    'au_entry_at' => now(),
                    'au_entry_session' => 'UOMadded',
                    'au_entry_hospital_no_fk' => $au_entry_hospital_no_fk
                ];

                DB::table('sysc_serviceitem_uom')->insert($data);

            } else {
                $data = [
                    'uom_code'  => $request->uom_code,
                    'uom_label_desc' => 1,
                    'STATUS'    => $request->status ? 1 : 0,
                    'au_update_by' => $auth_id,
                    'au_update_at' => now(),
                    'au_update_session' => 'UOMUpdated',
                    'au_update_hospital_no_fk' => $au_entry_hospital_no_fk
                ];

                DB::table('sysc_serviceitem_uom')->where('uom_no_pk', $id)->update($data);
            }

            DB::commit();
            $message = ['msg' => 'UOM Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function editUom($id)
    {
        $uom = DB::table('sysc_serviceitem_uom')
            ->where('uom_no_pk', $id)
            ->first();

        return Template::loadview("admin.store.create_uom_form", ['uom' => $uom]);
    }



    
}
