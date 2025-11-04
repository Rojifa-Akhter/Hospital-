<?php

namespace App\Http\Controllers;

use DB;
use \PDF;
use Session;
use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\Company;
use App\Models\ItemType;
use App\Traits\ItemData;
use App\Library\Template;
use App\Models\OtherItem;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Models\RadiologyItem;
use App\Traits\UtilitiesTrait;
use App\Datatables\DataTableClass;
use App\Http\Requests\ItemRequest;
use App\Models\UomLookup as Lookup;
use Illuminate\Support\Facades\Auth;
use App\Models\DefaultAttributeValue;
use App\Http\Requests\ItemTypeRequest;
use App\Http\Requests\otherItemRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\RadiologyItemRequest;
use App\Repositories\BaseRepository as Repo;
use App\Http\Requests\PathologyItemSetupRequest;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Support\Str;


class HOSItemController extends Controller
{
    use LookupData, ItemData, UtilitiesTrait;

    protected $model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemType $itemtype, Item $item, ItemSupplier $itemSupplier, RadiologyItem $RadiologyItem, OtherItem $otherItem, DefaultAttributeValue $DefaultAttributeValue)
    {
        $this->middleware('auth');

        $this->itemTypeModel = new Repo($itemtype);
        $this->itemModel = new Repo($item);
        $this->itemSupplierModel = new Repo($itemSupplier);
        $this->RadiologyItem = new Repo($RadiologyItem);
        $this->otherItem = new Repo($otherItem);
        $this->DefaultAttributeValue = new Repo($DefaultAttributeValue);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$item_type = $this->getLookupListByCode('ITEMTYPE');
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();

        return Template::loadview("admin.uhl.inventory.uhl-item-list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
        ]);
    }
    public function inventoryItemListCafe($type="")
    {
       
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        $service_unit = ServiceUnit::where('status', '1')->where('hospital_store_ind', '=', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store = ServiceUnit::where('status', '1')->where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        return Template::loadview("admin.uhl.inventory.uhl-inventory-item-list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'main_store' => $main_store,
            'suppiler_arr' => $suppiler_arr,
            'type' => $type,
        ]);
    }
    public function inventoryItemList($type="")
    {
       
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        $service_unit = ServiceUnit::where('status', '1')->where('hospital_store_ind', '=', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store = ServiceUnit::where('status', '1')->where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        return Template::loadview("admin.uhl.inventory.uhl-inventory-item-list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'main_store' => $main_store,
            'suppiler_arr' => $suppiler_arr,
            'type' => $type,
        ]);
    }

    // item rate list 
    public function itemRateList($type="")
    {
       
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();

        // $service_unit = ServiceUnit::where('status', '1')->where('hospital_store_ind', '=', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store = ServiceUnit::where('status', '1')->where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();


        return Template::loadview("admin.uhl.inventory.uhl-item-rate-list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'main_store' => $main_store,
            'suppiler_arr' => $suppiler_arr,
            'type' => $type,
        ]);
    }


    public function showItemRate($id, $ind = "")
    {
        $itemRates = DB::table('sysc_serviceitemrate')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'sysc_serviceitemrate.item_no_fk')
            ->leftJoin('WSEC_USER', 'WSEC_USER.USER_NO_PK', '=', 'sysc_serviceitemrate.au_entry_by')
            ->select(
                'sysc_serviceitemrate.*',
                'sysc_serviceitem.item_code',
                'sysc_serviceitem.purchase_price',
                'sysc_serviceitem.item_name',
                'WSEC_USER.USER_FULLNAME as entry_by_name'
            )
            ->where('sysc_serviceitemrate.item_no_fk', $id)
            ->orderByDesc('sysc_serviceitemrate.au_entry_at')
            ->get();

        return view('admin.uhl.inventory.uhl-item-rate-list-details', [
            'itemRates' => $itemRates,
            'ind' => $ind,
            'id' => $id,
        ]);
    }

        


    public function pharmacyItemList()
    {
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();

        $service_unit = ServiceUnit::where('status', '1')->where('pharmacy_ind', '=', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store = ServiceUnit::where('status', '1')->where('pharmacy_ind', '=', 1)->where('main_store_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        return Template::loadview("admin.uhl.inventory.uhl-pharmacy-item-list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'main_store' => $main_store,
        ]);
    }


    public function item_setup($id = null)
    {
        $page_type = "quick";

        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->orderBy('item_name')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        if ($id !== null) {
            $item = DB::table('sysc_serviceitem')->where('item_no_pk', $id)->get();
        } else {
            $item = [];
        }

        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name')->get();
        $acc_map_service_unit = ServiceUnit::where('fin_mapping_ind', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $rack = DB::table('sysc_rack')->where('status', '1')->get();
        $uom = $this->getLookupListByCode("UOM");
        $uom_1 = $this->getLookupListByCode("UOM-1");
        $uom_2 = $this->getLookupListByCode("UOM-2");
        $uom_3 = $this->getLookupListByCode("UOM-3");
        $uom_4 = $this->getLookupListByCode("UOM-4");

        $uom_data = Lookup::where('uom_code', '!=', 'PC')->orderBy('uom_no_pk', 'asc')->get(); //UOM Lookup
        $uom_data_pc = Lookup::where('uom_code', 'PC')->get(); //UOM Lookup
        $uom_data_strip = Lookup::where('uom_code', 'STRIP')->get(); //UOM Lookup
        $uom_data_box = Lookup::where('uom_code', 'BOX')->get(); //UOM Lookup
        $uom_data_carton = Lookup::where('uom_code', 'CARTON')->get(); //UOM Lookup

        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

        // $crg_group = $this->getLookupListByCode("CRG_GROUP");

        $crg_group = DB::table('sysc_lookup')
        ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
        ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc', 'sysc_lookupdata.lookupdata_code')
        ->where('sysc_lookup.lookup_code', '=', "CRG_GROUP")
        ->where('sysc_lookupdata.status', 1)
        ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->whereNull('ipd_consultant_ind')
        //->orderBy('sysc_lookupdata.serial_no', 'asc')
        ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
        ->get();


        $route = $this->getPresLookupListByCode("ROUTE");
        //dd($route);
        $dose = $this->getPresLookupListByCode("DOSE");

        $code = "ECITEMCAT";
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();

        $item_cat_data = [];
        if (!empty($item_cat_arr)) {
            foreach ($item_cat_arr as $row) {
                $item_cat_data[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        $major_group_option = DB::select('SELECT ITEMTYPE_NO_PK, ITEMTYPE_CODE, ITEM_TYPE_NAME FROM  sysc_itemtype WHERE fin_majorgroup_ind = 1');

        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        $item_type_lookup = $this->getLookupListByCode("ITEMTYPE");


        return Template::loadView("admin.uhl.uhl-new-item", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'acc_map_service_unit' => $acc_map_service_unit,
            'main_store_list' => $main_store_list,
            'route' => $route,
            'rack' => $rack,
            'dose' => $dose,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'item' => $item,
            'uom_data_pc' => $uom_data_pc,
            'uom_data_strip' => $uom_data_strip,
            'uom_data_box' => $uom_data_box,
            'uom_data_carton' => $uom_data_carton,
            'uom_data' => $uom_data,
            'major_group_option' => $major_group_option,
            'item_type_lookup' => $item_type_lookup,
            'crg_group' => $crg_group,
        ]);
    }

    /**
     * Filter
     */
    public function getInventoryMinorGroup($major_id = null)
    {
        if(isset($major_id)) {
            $item_type = DB::table('item_type_vw')
                        // ->where('MINOR_GROUP_IND', 1)
                        ->where('MAJOR_GROUP_NO', $major_id)
                        ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                        ->orderBy('item_name')
                        ->get();
        } else {
            $item_type = DB::table('item_type_vw')
                            // ->where('MINOR_GROUP_IND', 1)
                            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                            ->orderBy('item_name')
                            ->get();
        }

        return response()->json(['item_type' => $item_type]);
    }

    public function inventory_item_setup($id = null, $ind = null, $rp_type = null)
    {
        $page_type = "quick";

        $major_group = DB::table('item_type_vw')
                            ->where('MAJOR_GROUP_IND', 1)
                            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                            ->orderBy('item_name')
                            ->get();
        $major_group_option = DB::select('SELECT ITEMTYPE_NO_PK, ITEMTYPE_CODE, ITEM_TYPE_NAME FROM  sysc_itemtype WHERE fin_majorgroup_ind = 1');

        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')
                            // ->where('MINOR_GROUP_IND', 1)
                            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                            ->orderBy('item_name')
                            ->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        if ($id !== null) {
            $item = DB::table('sysc_serviceitem')->where('item_no_pk', $id)->get();
        } else {
            $item = [];
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $acc_map_service_unit = ServiceUnit::where('fin_mapping_ind', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $rack = DB::table('sysc_rack')->where('status', '1')->get();
        $uom = $this->getLookupListByCode("UOM");
        $uom_1 = $this->getLookupListByCode("UOM-1");
        $uom_2 = $this->getLookupListByCode("UOM-2");
        $uom_3 = $this->getLookupListByCode("UOM-3");
        $uom_4 = $this->getLookupListByCode("UOM-4");

        $uom_data = Lookup::where('uom_code', '!=', 'PC')->orderBy('uom_no_pk', 'asc')->get(); //UOM Lookup
        $uom_data_pc = Lookup::where('uom_code', 'PC')->get(); //UOM Lookup
        $uom_data_strip = Lookup::where('uom_code', 'STRIP')->get(); //UOM Lookup
        $uom_data_box = Lookup::where('uom_code', 'BOX')->get(); //UOM Lookup
        $uom_data_carton = Lookup::where('uom_code', 'CARTON')->get(); //UOM Lookup

        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");
        // $crg_group = $this->getLookupListByCode("CRG_GROUP");

        $crg_group = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc', 'sysc_lookupdata.lookupdata_code')
            ->where('sysc_lookup.lookup_code', '=', "CRG_GROUP")
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ipd_consultant_ind')
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
            ->get();

        $route = $this->getPresLookupListByCode("ROUTE");
        //dd($route);
        $dose = $this->getPresLookupListByCode("DOSE");

        $code = "ECITEMCAT";
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();

        $item_cat_data = [];
        if (!empty($item_cat_arr)) {
            foreach ($item_cat_arr as $row) {
                $item_cat_data[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        $item_type_lookup = $this->getLookupListByCode("ITEMTYPE");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();


        return Template::loadView("admin.uhl.uhl-new-inventory-item", [
            'major_group' => $major_group,
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'acc_map_service_unit' => $acc_map_service_unit,
            'main_store_list' => $main_store_list,
            'route' => $route,
            'rack' => $rack,
            'dose' => $dose,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'crg_group' => $crg_group,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'item' => $item,
            'uom_data_pc' => $uom_data_pc,
            'uom_data_strip' => $uom_data_strip,
            'uom_data_box' => $uom_data_box,
            'uom_data_carton' => $uom_data_carton,
            'uom_data' => $uom_data,
            'item_type_lookup' => $item_type_lookup,
            'major_group_option' => $major_group_option,
            'ind' => $ind,
            'type' => $rp_type
        ]);
    }



    public function quick_inventory_item_setup($id = null)
    {

        $page_type = "quick";

        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        if ($id !== null) {
            $item = DB::table('sysc_serviceitem')->where('item_no_pk', $id)->get();
        } else {
            $item = [];
        }

        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $rack = DB::table('sysc_rack')->where('status', '1')->get();
        $uom = $this->getLookupListByCode("UOM");
        $uom_1 = $this->getLookupListByCode("UOM-1");
        $uom_2 = $this->getLookupListByCode("UOM-2");
        $uom_3 = $this->getLookupListByCode("UOM-3");
        $uom_4 = $this->getLookupListByCode("UOM-4");

        $uom_data = Lookup::where('uom_code', '!=', 'PC')->orderBy('uom_no_pk', 'asc')->get(); //UOM Lookup
        $uom_data_pc = Lookup::where('uom_code', 'PC')->get(); //UOM Lookup
        $uom_data_strip = Lookup::where('uom_code', 'STRIP')->get(); //UOM Lookup
        $uom_data_box = Lookup::where('uom_code', 'BOX')->get(); //UOM Lookup
        $uom_data_carton = Lookup::where('uom_code', 'CARTON')->get(); //UOM Lookup

        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

        $route = $this->getPresLookupListByCode("ROUTE");
        //dd($route);
        $dose = $this->getPresLookupListByCode("DOSE");
        

        $code = "ECITEMCAT";
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();

        $item_cat_data = [];
        if (!empty($item_cat_arr)) {
            foreach ($item_cat_arr as $row) {
                $item_cat_data[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        $item_type_lookup = $this->getLookupListByCode("ITEMTYPE");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();


        return Template::loadView("admin.uhl.quick-new-inventory", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'main_store_list' => $main_store_list,
            'route' => $route,
            'rack' => $rack,
            'dose' => $dose,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'item' => $item,
            'uom_data_pc' => $uom_data_pc,
            'uom_data_strip' => $uom_data_strip,
            'uom_data_box' => $uom_data_box,
            'uom_data_carton' => $uom_data_carton,
            'uom_data' => $uom_data,
            'item_type_lookup' => $item_type_lookup,
        ]);
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $ind = "")
    {
        //  dd($id, $ind);
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        //$item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $acc_map_service_unit = ServiceUnit::where('fin_mapping_ind', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $rack = DB::table('sysc_rack')->where('status', '1')->get();

        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        //$item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        $data = DB::table('sysc_serviceitem s')
                ->select('s.*', 'w.generic_name', 'w.item_uom_name_2nd', 'w.item_uom_name_3rd', 'w.item_uom_name_4th')
                ->leftjoin('sysc_v1_serviceitem_vw w', 'w.item_no_pk', '=', 's.item_no_pk')
                ->where('s.item_no_pk', $id)
                ->first();

        $acc_head = DB::table('acct_chart_of_accounts')->where('account_no_pk', $data->budgeted_head_no_fk)->first();
        // $data = Item::find($id);
        // dd($data);

        $uom_data = Lookup::all(); //UOM Lookup
        $uom_data_pc = Lookup::where('uom_code', 'PC')->get(); //UOM Lookup
        $uom_data_strip = Lookup::where('uom_code', 'STRIP')->get(); //UOM Lookup
        $uom_data_box = Lookup::where('uom_code', 'BOX')->get(); //UOM Lookup
        $uom_data_carton = Lookup::where('uom_code', 'CARTON')->get(); //UOM Lookup

        $route = $this->getPresLookupListByCode("ROUTE");
        //dd($route);
        $dose = $this->getPresLookupListByCode("DOSE");

        // $crg_group = $this->getLookupListByCode("CRG_GROUP");

        $crg_group = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc', 'sysc_lookupdata.lookupdata_code')
            ->where('sysc_lookup.lookup_code', '=', "CRG_GROUP")
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ipd_consultant_ind')
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
            ->get();




        $page_type = 'edit';
        $code = "ECITEMCAT";
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();
        $item_cat_data = [];
        if (!empty($item_cat_arr)) {
            foreach ($item_cat_arr as $row) {
                $item_cat_data[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }

        $major_group_option = DB::select('SELECT ITEMTYPE_NO_PK, ITEMTYPE_CODE, ITEM_TYPE_NAME FROM  sysc_itemtype WHERE fin_majorgroup_ind = 1');
        $item_type_lookup = $this->getLookupListByCode("ITEMTYPE");

        return Template::loadview("admin.uhl.uhl-new-item",  [
            'ind' => $ind,
            'item' => $data,
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'acc_map_service_unit' => $acc_map_service_unit,
            'main_store_list' => $main_store_list,
            'route' => $route,
            'rack' => $rack,
            'dose' => $dose,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_sub,
            'item_cat_sub_data_1' => $item_cat_sub_1,
            'item_cat_sub_data_2' => $item_cat_sub_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'uom_data_pc' => $uom_data_pc,
            'uom_data_strip' => $uom_data_strip,
            'uom_data_box' => $uom_data_box,
            'uom_data_carton' => $uom_data_carton,
            'uom_data' => $uom_data,
            'acc_head' => $acc_head,
            'major_group_option' => $major_group_option,
            'item_type_lookup' => $item_type_lookup,
            'crg_group' => $crg_group,
            
        ]);
    }
    public function inventoryEdit($id, $ind = null,$rp_type = null)
    {
        //  dd($id, $ind, $rp_type);
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();


        // $type = $rp_type;

        // dd($id, $ind,$rp_type);
        // if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
        //     $item_type = DB::table('item_type_vw')->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')->get();
        // } else {
        //     $item_type = $this->getLookupListByCode("1018");
        // }

        //$item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $acc_map_service_unit = ServiceUnit::where('fin_mapping_ind', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $rack = DB::table('sysc_rack')->where('status', '1')->get();

        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        //$item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        $data = DB::table('sysc_serviceitem s')->select('s.*', 'w.generic_name', 'w.item_uom_name_2nd', 'w.item_uom_name_3rd', 'w.item_uom_name_4th')->leftjoin('sysc_v1_serviceitem_vw w', 'w.item_no_pk', '=', 's.item_no_pk')->where('s.item_no_pk', $id)->first();

        $acc_head = DB::table('acct_chart_of_accounts')->where('account_no_pk', $data->budgeted_head_no_fk)->first();
        // $data = Item::find($id);
        // dd($data);

        $uom_data = Lookup::all(); //UOM Lookup
        $uom_data_pc = Lookup::where('uom_code', 'PC')->get(); //UOM Lookup
        $uom_data_strip = Lookup::where('uom_code', 'STRIP')->get(); //UOM Lookup
        $uom_data_box = Lookup::where('uom_code', 'BOX')->get(); //UOM Lookup
        $uom_data_carton = Lookup::where('uom_code', 'CARTON')->get(); //UOM Lookup
        // $crg_group = $this->getLookupListByCode("CRG_GROUP");

        $crg_group = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc', 'sysc_lookupdata.lookupdata_code')
            ->where('sysc_lookup.lookup_code', '=', "CRG_GROUP")
            ->where('sysc_lookupdata.status', 1)
            ->where('sysc_lookup.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sysc_lookupdata.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ipd_consultant_ind')
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.lookupdata_name', 'asc')
            ->get();




        $route = $this->getPresLookupListByCode("ROUTE");
        //dd($route);
        $dose = $this->getPresLookupListByCode("DOSE");

        $page_type = 'edit';
        $code = "ECITEMCAT";
        $item_cat_arr = DB::table('sysc_lookup')
            ->join('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_desc')
            ->where('sysc_lookup.lookup_code', '=', $code)
            ->where('sysc_lookupdata.status', 1)
            ->where('lookupdata_pk_no_parent', '=', null)
            //->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->orderBy('sysc_lookupdata.serial_no', 'asc')
            ->get();
        $item_cat_data = [];
        if (!empty($item_cat_arr)) {
            foreach ($item_cat_arr as $row) {
                $item_cat_data[$row->lookupdata_no_pk] = $row->lookupdata_name;
            }
        }
        $item_type_lookup = $this->getLookupListByCode("ITEMTYPE");
        //dd($item_cat_data, $data->item_cat_lookupdata_no_fk);
        // dd($data);

        $major_group_no = DB::table('item_type_vw')
                    ->where('ITEMTYPE_NO_PK', $data->itemtype_no_fk)
                    ->orderBy('item_name')
                    ->pluck('major_group_no')
                    ->first();

        $major_group = DB::table('item_type_vw')
                            ->where('MAJOR_GROUP_IND', 1)
                            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                            ->orderBy('item_name')
                            ->get();
        $major_group_option = DB::select('SELECT ITEMTYPE_NO_PK, ITEMTYPE_CODE, ITEM_TYPE_NAME FROM  sysc_itemtype WHERE fin_majorgroup_ind = 1');
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')
                            // ->where('minor_group_ind', 1)
                            ->where('MAJOR_GROUP_NO', $major_group_no)
                            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
                            ->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }

        return Template::loadview("admin.uhl.uhl-new-inventory-item",  [
            'major_group' => $major_group,
            'major_group_no' => $major_group_no,
            'ind' => $ind,
            'item' => $data,
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'acc_map_service_unit' => $acc_map_service_unit,
            'main_store_list' => $main_store_list,
            'route' => $route,
            'rack' => $rack,
            'dose' => $dose,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_sub,
            'item_cat_sub_data_1' => $item_cat_sub_1,
            'item_cat_sub_data_2' => $item_cat_sub_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'uom_data_pc' => $uom_data_pc,
            'uom_data_strip' => $uom_data_strip,
            'uom_data_box' => $uom_data_box,
            'uom_data_carton' => $uom_data_carton,
            'uom_data' => $uom_data,
            'acc_head' => $acc_head,
            'item_type_lookup' => $item_type_lookup,
            'major_group_option' => $major_group_option,
            'type' => $rp_type,
            'crg_group' => $crg_group

        ]);
    }

    public function checkItemStock(Request $request){    
        $message=0;   
        if ($request->item_id) {
           $itemStock=DB::table('inv_itemstockmst')->where('item_no_fk',$request->item_id)->sum('balance_qty');     
           $message= ['qty' =>  $itemStock,'message'=>'This item already has a stock quantity of ' . $itemStock . '. It cannot be set to inactive.'];   
        }
        return response()->json($message);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ItemRequest $request)
    {
       
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($request->item_type != "") {
            $item_type = ItemType::where("itemtype_no_pk", $request->item_type)->first();
        }


        if (Session::get('user.ses_hospital_code') == "KPJ") {
            $crg_group_d = $request->crg_group;
            $item_code_from_request = $request->item_code;

            $should_generate_code = empty($item_code_from_request) || !Str::startsWith($item_code_from_request, $crg_group_d);

            if ($should_generate_code) {
                $max_item_code = DB::table('sysc_serviceitem')
                    ->where('item_code', 'like', $crg_group_d . '%')
                    ->orderBy('item_code', 'desc')
                    ->value('item_code');

                if ($max_item_code) {
                    $suffix = substr($max_item_code, strlen($crg_group_d));

                    $incremented = str_pad(((int)$suffix + 1), strlen($suffix), '0', STR_PAD_LEFT);

                    // prefix + updated number
                    $cc_item_code = $crg_group_d . $incremented;
                } else {
                    $cc_item_code = $crg_group_d . '0001';
                }
            } else {
                $cc_item_code = $item_code_from_request;
            }
        } else {
            $cc_item_code = $request->item_code;
        }



        
        


       
        // dd('New Item Code: ' . $cc_item_code, 'Max Item Code: ' . $max_item_code);
       

        $files = $request->file('item_photo');
        $files1 = $request->file('item_photo1');
        $files2 = $request->file('item_photo2');
        $files3 = $request->file('item_photo3');
        DB::beginTransaction();
        try {
            $item_type_no=DB::table('sysc_lookupdata')->where('lookupdata_code', $request->item_type_lookup)->value('lookupdata_no_pk');
            
            $data = [
                // 'item_code' => $cc_item_code,
                'item_short_name' => $request->item_short_name,
                'report_header' => $request->item_type != "" ? $item_type->itemtype_code : '',
                'item_type' => $request->item_type_lookup != "" ? $request->item_type_lookup : '',
                'dis_item_type' => $request->item_discount_type != "" ? $request->item_discount_type : '',
                'itemtype_no_fk' => $request->item_type,
                'uom_no_fk' => $request->item_uom,
                'pr_uom_no_fk' => $request->pr_uom_no_fk,
                'uom_no_fk_2nd' => $request->item_uom_2,
                'uom_no_fk_3rd' => $request->item_uom_3,
                'uom_no_fk_4th' => $request->item_uom_4,
                'pack_type' => $request->item_pack_type,
                'sales_price' => $request->item_sales_price ? $request->item_sales_price : 0,
                'budgeted_head_no_fk' => $request->budgetd_head_id, //accounts head from chart of accounts
                'item_name' => $request->item_name,
                'brand' => $request->brand,
                //"item_generic_name" => "Ascabiol"
                'generic_no_fk' => $request->item_generic_id,
                'serviceunit_no_fk' => $request->service_unit,
                'mainstore_su_no_fk' => $request->mainstore_su_no_fk,
                'manufacturer_no_fk' => $request->supplier_name,
                'supplier_pk_no' => $request->supplier_name,
                'uom_no_fk_2nd_conv_ratio' => $request->uom_no_fk_2nd_conv_ratio,
                'uom_no_fk_3rd_conv_ratio' => $request->uom_no_fk_3rd_conv_ratio,
                'uom_no_fk_4th_conv_ratio' => $request->uom_no_fk_4th_conv_ratio,
                'purchase_price' => $request->item_purchase_price ? $request->item_purchase_price : 0,
                "purchasediscount_pct" => $request->purchase_discount,
                'vat_percent' => $request->item_vat_persent,
                'purchasevat_pct' => $request->purchase_item_vat_persent,
                'pr_uom_conversion_qty' => $request->box_conversion_qty,
                're_order_level' => $request->re_order_level ? $request->re_order_level : 0,
                'accounts_mapping_su_no_fk' => $request->accounts_service_unit,
                // 'non_stock_ind' => $request->stock_type,
                'status' => $request->item_status == '1' ? 1 : 0,
                'refferral_pay_calc_ind' => isset($request->ref_payment) && $request->ref_payment == 1 ? 1 : 0,
                'expireable' => $request->expireable_ind,
                'analyzer_ind' => $request->analyzer_ind,
                'mrp_ind' => $request->mrp_ind,
                //'requisition_trackable' => $request->requisition_trackable,
                'dealer_sales_price' => $request->item_dealers_price,
                'urgent_fee_amt' => $request->urgent_fee_amt ? $request->urgent_fee_amt : 0,
                'temperature' => $request->temperature,
                'item_cat_lookupdata_no_fk' => $request->item_category,
                'item_subcat_lookupdata_no_fk' => $request->item_category_sub,
                'item_sub1cat_lookupdata_no_fk' => $request->item_category_sub_1,
                'item_sub2cat_lookupdata_no_fk' => $request->item_category_sub_2,
                "note_text" => $request->short_desc,
                "plain_text" => $request->long_desc,
                'closeforindent_ind' => $request->closeforindent_ind,
                'closeforsales_ind' => $request->closeforsales_ind,
                'expireable' => $request->expireable_ind,
                'consignment_ind' => $request->consignment_ind,
                'slow_moving_ind' => $request->slow_moving_ind,
                'profile_allow_ind' => $request->profile_allow_ind,
                'reusable_ind' => $request->reusable_ind,
                'consumable_ind' => $request->consumable_ind,
                'disposal_ind' => $request->disposal_ind,
                'regular_inventory_item_ind' => $request->regular_item_ind,
                'autoindent_on_admission_ind' => $request->autoindent_on_admission_ind,
                'non_stock_ind'       => $request->input('stock_type'),
                "saleonstriponly_ind" => $request->saleonstriponly_ind,
                'billable_ind' => $request->billable_ind,
                'breakable_ind' => $request->breakable_ind,
                'asset_ind' => $request->asset_ind,
                'individualidentify_ind' => $request->individualidentify_ind,
                'pkg_referral_ind' => $request->pkg_referral_ind,
                'disc_aplicable' => $request->disc_aplicable,
                'salesnoprescription_otc_ind' => $request->salesnoprescription_otc_ind,
                'medicalprovider_ind' => $request->medicalprovider_ind,
                'packagerestricted_ind' => $request->packagerestricted_ind,
                'narcoticdrug_ind' => $request->narcoticdrug_ind,
                'rack_id_fk' => $request->rack_id_fk,
                'route_no_fk' => $request->route_no_fk,
                'item_req_trackable_ind' => $request->item_req_trackable_ind,
                'batchnorequired_ind' => $request->lot_batch_no,
                'manual_item_rate_ind' => $request->rate_editable,
                'qty_edit_ind' => $request->quatity_editable,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'capital_in_progress_ind' => $request->capital_in_progress_ind,
                'dollar_ind' => $request->currency,
                'cssd_ind'  => $request->cssd_ind,
                'washable_ind' => $request->washable_ind,
                'fin_major_group_no' => $request->fin_major_group_no,
                'foreign_item_ind' => $request->foreign_item_ind,
                'item_type_fnb' => $request->item_type_fnb,
            ];

            // Conditionally add 'crg_group' only if hospital code is "KPJ"
            if (Session::get('user.ses_hospital_code') === "KPJ") {
                $data['crg_group'] = $request->crg_group;
            }



            // dd($data);

            $image_name = "";
            $image_name1 = "";
            $image_name2 = "";
            $image_name3 = "";
            if ($files = $request->file('item_photo')) {
                $image_name = "item_photo_" . str_replace(" ", "_", $request->item_name)  . "." . $files->getClientOriginalExtension();
                $data['item_photo'] = $image_name;
                $image_name = "item_photo_" . str_replace(" ", "_", $request->item_name);
            }
            if ($files = $request->file('item_photo1')) {
                $image_name1 = "item_photo1_" . str_replace(" ", "_", $request->item_name)  . "." . $files1->getClientOriginalExtension();
                $data['item_photo_1'] = $image_name1;
                $image_name1 = "item_photo1_" . str_replace(" ", "_", $request->item_name);
            }
            if ($files = $request->file('item_photo2')) {
                $image_name2 = "item_photo2_" . str_replace(" ", "_", $request->item_name)  . "." . $files2->getClientOriginalExtension();
                $data['item_photo_2'] = $image_name2;
                $image_name2 = "item_photo2_" . str_replace(" ", "_", $request->item_name);
            }
            if ($files = $request->file('item_photo3')) {
                $image_name3 = "item_photo3_" . str_replace(" ", "_", $request->item_name)  . "." . $files3->getClientOriginalExtension();
                $data['item_photo_3'] = $image_name3;
                $image_name3 = "item_photo3_" . str_replace(" ", "_", $request->item_name);
            }
            if ($files = $request->file('item_photo')) {
                $this->uploadImages($files, $image_name, 'images/uploads/item_images/', 'images/uploads/item_images/thumb/');
            }
            if ($files = $request->file('item_photo1')) {
                $this->uploadImages($files,  $image_name1, 'images/uploads/item_images/', 'images/uploads/item_images/thumb/');
            }
            if ($files = $request->file('item_photo2')) {
                $this->uploadImages($files,   $image_name2, 'images/uploads/item_images/', 'images/uploads/item_images/thumb/');
            }
            if ($files = $request->file('item_photo3')) {
                $this->uploadImages($files,  $image_name3, 'images/uploads/item_images/', 'images/uploads/item_images/thumb/');
            }

            $suppliers = $request->supplier_manufac ? $request->supplier_manufac : [];
            if (in_array($request->supplier_name, $suppliers)) {
                $suppliers = $suppliers;
            } else {
                if (!empty($request->supplier_name)) {
                    array_push($suppliers, $request->supplier_name);
                } else {
                    $suppliers = $suppliers;
                }
            }

            // Fetch old sales_price before update
            $existingItem = DB::table('sysc_serviceitem')->where('item_no_pk', $id)->first();
            $old_sales_price = $existingItem->sales_price ?? 0;
            $new_sales_price = $request->item_sales_price ?? 0;

            if ($id == null) {
                $data['item_code'] = $cc_item_code;
               
                // dd($data);
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $response = $this->itemModel->create($data);
                $item_id = $response->item_no_pk;

                // dd($item_id);

                if (!empty($suppliers)) {
                    foreach ($suppliers as $value) {
                        $supplierData = [
                            'ITEM_NO_FK' => $item_id,
                            'SUPPLIER_NO_FK' => $value,
                            'au_entry_at' => $auth_id,
                            'au_entry_hospital_pk_no' => $ses_hospital_id,
                        ];
                        $this->itemSupplierModel->create($supplierData);
                    }
                }
            } else {
                $data['item_code'] = $request->item_code;

                // dd($data,$id);
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                // $this->itemModel->update($data, $id);
                // dd($data,$id);
                DB::table('sysc_serviceitem')->where('item_no_pk',$id)->update($data);
                $item_id = $id;
                DB::table('SYSC_SERVICEITEM_SUPPLIER')->where('ITEM_NO_FK', $item_id)->delete();
                if (!empty($suppliers)) {
                    foreach ($suppliers as $value) {
                        $supplierData = [
                            'ITEM_NO_FK' => $item_id,
                            'SUPPLIER_NO_FK' => $value,
                            'au_entry_at' => $auth_id,
                            'au_entry_hospital_pk_no' => $ses_hospital_id,
                        ];
                        $this->itemSupplierModel->create($supplierData);
                    }
                }
                if ($old_sales_price != $new_sales_price) {
                    DB::table('SYSC_SERVICEITEMRATE')->insert([
                        'ITEM_NO_FK' => $item_id,
                        'ITEM_CODE' => $cc_item_code,
                        'PAYERTYPE_NO_FK' => 1, 
                        'BASE_RATE' => $old_sales_price, 
                        'RATE' => $new_sales_price,
                        'PURCHASE_PRICE' => $request->item_purchase_price ? $request->item_purchase_price : 0,
                        'EFFECT_DATE' => now(),
                        'STATUS' => 1,
                        'AU_ENTRY_BY' => $auth_id,
                        'AU_ENTRY_AT' => now(),
                        'AU_ENTRY_SESSION' => 'INVITEM_IMP' . $item_id,
                        'AU_ENTRY_HOSPITAL_PK_NO' => $ses_hospital_id,
                        'ITEM_TYPE' => $request->item_type, 
                    ]);
                }
            }

            DB::commit();

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'item_id' => $item_id, 'item_name' => $request->item_name];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];

            // dd($message);
        }

        return response()->json($message);
    }


    public function searchItemList(Request $request)
    {
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;

        // $sql_cond = "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($item_type != "") ? " $clause si.item_type = '$item_type'" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($service_unit != "") ? " $clause si.serviceunit_no_fk = $service_unit" : "";


        $table = 'service_item_list_vw';

        // Table's primary key
        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && !empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit and itemtype_no_fk = $item_type";
        }

        if (!empty($item_type) && empty($service_unit)) {
            $where = "itemtype_no_fk = $item_type";
        }

        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit ";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        //$where = "au_entry_hospital_pk_no = $hospital_id and item_type != 'MED'";
        $where .= " and au_entry_hospital_pk_no = $hospital_id";
        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where = "item_type = 'MED'";
        }
        // dd( $where);
        // if (!empty($service_unit) && empty($item_type)) {
        //     $where = " serviceunit_no_fk = $service_unit";
        // }

        // if (!empty($item_type) && empty($service_unit)) {
        //     $where = " itemtype_no_fk = '$item_type'";
        // }

        // if (!empty($item_type) && !empty($service_unit)) {
        //     $where = " serviceunit_no_fk = $service_unit and item_type = '$item_type'";
        // }

        //dd($where);
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'sl', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            //array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 6),
            array('db' => 'vat_percent', 'dt' => 7),
            array('db' => 'item_no_pk', 'dt' => 8),
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        //$request->request->add(['start' => 0, 'length' => 10]);

        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchItemListV1(Request $request)
    {

        $item_type = $request->item_type;
        $service_unit = $request->service_unit;

        $table = 'sysc_v1_serviceitem_vw';

        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && !empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit and itemtype_no_fk = $item_type";
        }

        if (!empty($item_type) && empty($service_unit)) {
            $where = "itemtype_no_fk = $item_type";
        }

        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit ";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where .=  $where != "" ? " and au_entry_hospital_pk_no = $hospital_id and item_type != 'INV'" : " au_entry_hospital_pk_no = $hospital_id and item_type != 'INV'";
        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where = "item_type = 'MED'";
        }

        $columns = array(
            array('db' => 'item_no_pk', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            //array('db' => 'manufacturer_no_fk', 'dt' => 6),
            //array('db' => 'main_store_name', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 6),
            array('db' => 'vat_percent', 'dt' => 7),
            array('db' => 'item_no_pk', 'dt' => 8),
            array('db' => 'item_uom_name_2nd', 'dt' => 9),
            array('db' => 'item_uom_name_3rd', 'dt' => 10),
            array('db' => 'item_uom_name_4th', 'dt' => 11),
            array('db' => 'uom_no_fk_2nd_conv_ratio', 'dt' => 12),
            array('db' => 'uom_no_fk_3rd_conv_ratio', 'dt' => 13),
            array('db' => 'uom_no_fk_4th_conv_ratio', 'dt' => 14),
        );
        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function invSearchItemListV1(Request $request)
    {

        //   dd('no');

        $item_type = $request->item_type;
        $service_unit_main_store = $request->main_unit;
        $service_unit = $request->service_unit;
        $supplier_id = $request->supplier_id;
        $type = $request->type;
       
        $table = 'sysc_v1_serviceitem_vw';

        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit_main_store) && !empty($item_type)) {
            $where = " mainstore_su_no_fk = $service_unit_main_store and itemtype_no_fk = $item_type";
        }

        if (!empty($item_type) && empty($service_unit_main_store)) {
            $where = "itemtype_no_fk = $item_type";
        }
        // dd($item_type);
        if (!empty($service_unit_main_store) && empty($item_type)) {
            $where = " mainstore_su_no_fk = $service_unit_main_store";
        }
        if ($service_unit !="") {
            $where =  " serviceunit_no_fk = $service_unit";
        }
        if ($supplier_id !="") {
            $where = "supplier_pk_no = $supplier_id";
        }
     
        if ($type !="") {
            if ($type =="INV") {
                 $where .= $where !="" ? " and item_type = 'INV'":"item_type = 'INV'";
            }elseif ($type=="PHR") {
               $where .=$where !="" ?  " and item_type = 'MED'" : " item_type = 'MED'";
            }elseif ($type=="SERVICE") {
              $allType = DB::table('sysc_itemtype_workflow')
                ->where('service_billing_ind', 1)
                ->pluck('workflow_code') 
                ->toArray(); 
                $quoted = "'" . implode("','", $allType) . "'";
               $where .=$where !="" ?  " and item_type in ($quoted)" : " item_type in ($quoted)";
            }elseif ($type=="CAFE") {
               $where .=$where !="" ?  " and item_type = 'CAFE'" : " item_type = 'CAFE'";
            }
        }else{
             
                $allType = DB::table('sysc_itemtype_workflow')
                ->where('service_billing_ind', 1)
                ->pluck('workflow_code') 
                ->toArray(); 
                $quoted = "'" . implode("','", $allType) . "'";
                 $where .=$where !="" ? " and item_type not in ( 'MED','INV',$quoted)" : " item_type not in ( 'MED','INV',$quoted)";
        }

       
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        //  dd($where,$hospital_id);
        // $where .=  $where != "" ? " and au_entry_hospital_pk_no = $hospital_id and item_type in ('INV','OPTICAL','CAFE')" : "au_entry_hospital_pk_no = $hospital_id and item_type = 'INV'";
        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where = "item_type = 'MED'";
        }

        $columns = array(
            array('db' => 'rownum', 'dt' => 0, 'sl' => 0),
            array('db' => 'item_code', 'dt' => 1, 'sl' => 1),
            array('db' => 'item_name', 'dt' => 2, 'sl' => 2),
            array('db' => 'generic_name', 'dt' => 3, 'sl' => 3),
            array('db' => 'par_item_type_name', 'dt' => 4, 'sl' => 4),
            array('db' => 'item_type_name', 'dt' => 5, 'sl' => 5),
            array('db' => 'item_type', 'dt' => 6, 'sl' => 6),
            array('db' => 'main_store_name', 'dt' => 7, 'sl' => 7),
            array('db' => 'sales_price', 'dt' => 8, 'sl' => 8),
            array('db' => 'vat_percent', 'dt' => 9, 'sl' => 9),
            array('db' => 'item_no_pk', 'dt' => 10, 'sl' => 10),
            array('db' => 'uom_name', 'dt' => 11, 'sl' => 11),
            array('db' => 'pr_uom_name', 'dt' => 12, 'sl' => 12),
            array('db' => 'purchase_price', 'dt' => 13, 'sl' => 13)
            // array('db' => 'serviceunit_name', 'dt' => 5),
            //array('db' => 'manufacturer_no_fk', 'dt' => 6),
            // array('db' => 'item_uom_name_2nd', 'dt' => 10),
            // array('db' => 'item_uom_name_3rd', 'dt' => 11),
            // array('db' => 'item_uom_name_4th', 'dt' => 12),
            // array('db' => 'uom_no_fk_2nd_conv_ratio', 'dt' => 13),
            // array('db' => 'uom_no_fk_3rd_conv_ratio', 'dt' => 14),
            // array('db' => 'uom_no_fk_4th_conv_ratio', 'dt' => 15),
            // array('db' => 'uom_name', 'dt' => 10),
        );
        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //   dd('no');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns));
        }

    }
    public function pharmacySearchItemListV1(Request $request)
    {

        $item_type = $request->item_type;
        $service_unit_main_store = $request->main_unit;
        $service_unit = $request->service_unit;

        $table = 'sysc_v1_serviceitem_vw';

        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit_main_store) && !empty($item_type)) {
            $where = " mainstore_su_no_fk = $service_unit_main_store and itemtype_no_fk = $item_type";
        }

        if (!empty($item_type) && empty($service_unit_main_store)) {
            $where = "itemtype_no_fk = $item_type";
        }
        // dd($item_type);
        if (!empty($service_unit_main_store) && empty($item_type)) {
            $where = " mainstore_su_no_fk = $service_unit_main_store";
        }
        if ($service_unit !="") {
            $where = " serviceunit_no_fk = $service_unit";
        }


        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where .=  $where != "" ? " and au_entry_hospital_pk_no = $hospital_id and item_type in ('MED','OPTICAL','CAFE')" : " au_entry_hospital_pk_no = $hospital_id and item_type = 'MED'";


        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'main_store_name', 'dt' => 5),
            array('db' => 'sales_price', 'dt' => 6),
            array('db' => 'vat_percent', 'dt' => 7),
            array('db' => 'item_no_pk', 'dt' => 8),
            array('db' => 'item_uom_name_2nd', 'dt' => 9),
            array('db' => 'item_uom_name_3rd', 'dt' => 10),
            array('db' => 'item_uom_name_4th', 'dt' => 11),
            array('db' => 'uom_no_fk_2nd_conv_ratio', 'dt' => 12),
            array('db' => 'uom_no_fk_3rd_conv_ratio', 'dt' => 13),
            array('db' => 'uom_no_fk_4th_conv_ratio', 'dt' => 14),
        );
        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

    }


    public function ItemListPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $hospital_code = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause si.itemtype_no_fk = '$item_type'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause si.serviceunit_no_fk = $service_unit" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause si.au_entry_hospital_pk_no = $hospital_code ";

        $sql = DB::select(DB::raw("SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, si.serviceunit_name,si.main_store_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price,si.item_sub1cat_lookupdata_no_fk,
        si.item_sub2cat_lookupdata_no_fk,
        si.item_subcat_lookupdata_no_fk,
        si.item_cat_lookupdata_no_fk, si.vat_percent,si.item_no_pk,si.main_store_name  from sysc_v1_serviceitem_vw si left join
        sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join
        sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join
         sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join
        sysc_serviceitem_uom umo on umo.uom_no_pk = si.uom_no_fk
        left join sysc_serviceitem_uom umo_2nd on umo_2nd.uom_no_pk = si.uom_no_fk_2nd
        left join sysc_serviceitem_uom umo_3rd on umo_3rd.uom_no_pk = si.uom_no_fk_3rd
        left join sysc_serviceitem_uom umo_4th on umo_4th.uom_no_pk = si.uom_no_fk_4th
        $sql_cond order by si.item_name asc,su.serviceunit_name asc"));

        // dd( $sql_cond);

        if ($request->hdn_report_type == "EXCEL") {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=Item_list.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", "Item Code", "Item Name", "Item Short Name", "Item Type", "Main Store", "Service Unit", "Price");
            $callback = function () use ($columns, $sql) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($sql)) {
                    foreach ($sql as $value) {

                        fputcsv($file, array($c, $value->item_code, $value->item_name, $value->item_short_name, $value->item_type, $value->main_store_name, $value->serviceunit_name, $value->sales_price));
                        $c++;
                    }
                }


                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        } else {
            $title = "Item List Report";
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $pdf = PDF::loadView("admin.settings.item.item_list_print", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
            return $pdf->download('item-list-report.pdf');
        }
    }
    public function InventoryItemListPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $item_type = $request->item_type;
        $service_unit = $request->main_unit;
        $supplier_id = $request->supplier;
        $hospital_code = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause si.itemtype_no_fk = '$item_type'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause si.mainstore_su_no_fk = $service_unit" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($supplier_id != "") ? " $clause si.supplier_pk_no = $supplier_id" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause si.au_entry_hospital_pk_no = $hospital_code ";
      
        // and si.item_type in ('INV','MED')
        $sql = DB::select(DB::raw("SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.purchase_price,si.sales_price,si.item_sub1cat_lookupdata_no_fk,
        si.item_sub2cat_lookupdata_no_fk,
        si.item_subcat_lookupdata_no_fk,
        si.par_item_type_name, si.item_type_name,
        si.item_cat_lookupdata_no_fk, si.vat_percent,si.item_no_pk,si.main_store_name  from sysc_v1_serviceitem_vw si left join
        sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join
        sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join
         sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join
        sysc_serviceitem_uom umo on umo.uom_no_pk = si.uom_no_fk
        left join sysc_serviceitem_uom umo_2nd on umo_2nd.uom_no_pk = si.uom_no_fk_2nd
        left join sysc_serviceitem_uom umo_3rd on umo_3rd.uom_no_pk = si.uom_no_fk_3rd
        left join sysc_serviceitem_uom umo_4th on umo_4th.uom_no_pk = si.uom_no_fk_4th
        $sql_cond order by si.par_item_type_name asc, si.item_type_name asc, si.item_name asc, su.serviceunit_name asc"));

        // dd( $sql);

        if ($request->hdn_report_type == "EXCEL") {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=Item_list.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", "Major Group", "Minor Group", "Item Code", "Item Name", "Item Short Name", "Item Type", "Main Store", "Purchase Price","Sales Price" ,"Service Unit");
            $callback = function () use ($columns, $sql) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($sql)) {
                    foreach ($sql as $value) {

                        fputcsv($file, array($c, $value->par_item_type_name, $value->item_type_name, $value->item_code, $value->item_name, $value->item_short_name, $value->item_type, $value->main_store_name, $value->purchase_price,$value->sales_price ,$value->serviceunit_name));
                        $c++;
                    }
                }

                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        } else {
            $title = "Item List Report";
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $pdf = PDF::loadView("admin.settings.item.item_list_print", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
            return $pdf->download('item-list-report.pdf');
        }
    }
    public function pharmacyItemListPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $item_type = $request->item_type;
        $service_unit = $request->main_unit;
        $hospital_code = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause si.itemtype_no_fk = '$item_type'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause si.mainstore_su_no_fk = $service_unit" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  " $clause si.au_entry_hospital_pk_no = $hospital_code and si.item_type = 'MED'";


        $sql = DB::select(DB::raw("SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price,si.item_sub1cat_lookupdata_no_fk,
        si.item_sub2cat_lookupdata_no_fk,
        si.item_subcat_lookupdata_no_fk,
        si.item_cat_lookupdata_no_fk, si.vat_percent,si.item_no_pk,si.main_store_name,si.supplier_name  from sysc_v1_serviceitem_vw si left join
        sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join
        sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join
        sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join
        sysc_serviceitem_uom umo on umo.uom_no_pk = si.uom_no_fk
        left join sysc_serviceitem_uom umo_2nd on umo_2nd.uom_no_pk = si.uom_no_fk_2nd
        left join sysc_serviceitem_uom umo_3rd on umo_3rd.uom_no_pk = si.uom_no_fk_3rd
        left join sysc_serviceitem_uom umo_4th on umo_4th.uom_no_pk = si.uom_no_fk_4th
        $sql_cond order by si.item_name asc,su.serviceunit_name asc"));

        // dd( $sql_cond);

        if ($request->hdn_report_type == "EXCEL") {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=Item_list.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", "Item Code", "Item Name", "Item Short Name", "Item Type", "Main Store", "Price");
            $callback = function () use ($columns, $sql) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($sql)) {
                    foreach ($sql as $value) {
                        fputcsv($file, array($c, $value->item_code, $value->item_name, $value->item_short_name, $value->item_type, $value->main_store_name, $value->sales_price));
                        $c++;
                    }
                }

                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        } else {
            $title = "Item List Report";
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            return view("admin.settings.item.item_list_print", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);

            // $pdf = PDF::loadView("admin.settings.item.item_list_print", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
            // return $pdf->download('item-list-report.pdf');
        }
    }
}
