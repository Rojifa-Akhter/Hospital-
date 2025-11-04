<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemTypeRequest;
use App\Http\Requests\otherItemRequest;
use App\Http\Requests\PathologyItemSetupRequest;
use App\Http\Requests\RadiologyItemRequest;
use App\Library\Template;
use App\Models\Company;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\OtherItem;
use App\Models\RadiologyItem;
use App\Models\ServiceUnit;
use App\Models\Supplier;
use App\Models\DefaultAttributeValue;
use App\Repositories\BaseRepository as Repo;
use App\Traits\DatatablesLoader;
use App\Traits\ItemData;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Auth;
use Carbon\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use Response;
use Illuminate\Support\Facades\Response;
use Session;
use \PDF;
use PhpParser\Node\Stmt\Else_;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ItemController extends Controller
{
    use DatatablesLoader, LookupData, ItemData, UtilitiesTrait;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemType $itemtype, Item $item, RadiologyItem $RadiologyItem, OtherItem $otherItem, DefaultAttributeValue $DefaultAttributeValue)
    {
        $this->middleware('auth');

        $this->itemTypeModel = new Repo($itemtype);
        $this->itemModel = new Repo($item);
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
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();

        return Template::loadview("admin.settings.item.item_list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
        ]);
    }

    public function getItemWithStock()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $admission_id = $_POST['admission_id'];
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        if (strtoupper(Session::get('user.ses_hospital_code')) == 'IMPERIAL') {
            return $this->getItemListWithStockAutoCompleteImperial($keyword, $item_type);
        } else {
            return $this->getItemListWithStockAutoComplete($keyword, $item_type,'','','','','','',$admission_id);
        }
    }

    public function getItemWithStockSubstore()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        $patient_id=$_POST['patient_id']??'';
        $admission_id = $_POST['admission_id'];
        if (strtoupper(Session::get('user.ses_hospital_code')) == 'IMPERIAL') {
            return $this->getItemListWithStockAutoCompleteImperial($keyword, $item_type, '', '', '','', $_POST['sub_store']);

        } else {

            return $this->getItemListWithStockAutoComplete($keyword, $item_type, '', '', '','', $_POST['sub_store'],$patient_id,$admission_id);

        }
    }


    public function getItemWithStockV2()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $sub_store = strtoupper(strval($_POST['sub_store']));
        $patient_no = strtoupper(strval($_POST['patient_no']));
        $admission_id = strtoupper(strval($_POST['admission_id']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";

        return $this->getItemListWithStockAutoCompleteV2($keyword, $item_type,'','','','',$sub_store, $patient_no,$admission_id);
    }
    public function getCafeItemWithStock()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        $service_unit = isset($_POST['service_unit']) ? $_POST['service_unit'] : "";
        $empId = isset($_POST['empId']) ? $_POST['empId'] : "";

            return $this->getCafeItemListWithStockAutoComplete($keyword, $item_type,$service_unit,"","","","",$empId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            // $item_type = $this->getLookupListByCode("1018");
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        }
        $page_type = 'edit';
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $itemTypelookupdata = DB::table('sysc_itemtype_workflow')
            ->select('workflow_no_pk', 'workflow_name', 'workflow_code')
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('workflow_name', 'asc')
            ->get();

        $item_type_lookup = [];
        if (!empty($itemTypelookupdata)) {
            foreach ($itemTypelookupdata as $row) {
                $item_type_lookup[$row->workflow_code] = $row->workflow_name;
            }
        }

        $suppiler_arr = Supplier::where('status', 1)->get();
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

        return Template::loadview("admin.settings.item.create_item_form", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'item_type_lookup' => $item_type_lookup,
            'pack_type' => $pack_type,
            'suppiler_arr' => $suppiler_arr,
            'item_cat_data' => $item_cat_data,
            'page_type' => $page_type
        ]);
    }

    public function itemTypeCreate()
    {
        $asset_sub_store =  DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('asset_sub_store_ind', 1)->where('status', 1)->get();
        $item_type_parent = ItemType::where('MAJOR_GROUP_IND', 1)->select('itemtype_no_pk', 'item_type_name')->get();

        return Template::loadview("admin.settings.item.create_item_type", [
            'item_type_parent' => $item_type_parent,
            'asset_sub_store' => $asset_sub_store,
        ]);
    }

    public function itemTypeCreate_form()
    {
        // $asset_sub_store =  DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('asset_sub_store_ind', 1)->where('status', 1)->get();
        $asset_sub_store =  DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('status', 1)->get();
        //   dd($asset_sub_store);
        $item_type_parent = ItemType::where('par_itemtype_no_fk', '=', 0)->select('itemtype_no_pk', 'item_type_name')->get();
        return Template::loadview("admin.settings.item.create_item_type_form", [
            'item_type_parent' => $item_type_parent,
            'asset_sub_store' => $asset_sub_store,
        ]);
    }

    /**
     * Item Type List
     */
    public function itemType()
    {
        $item_type = ItemType::where('status', '1')
                        ->where('MAJOR_GROUP_IND', 1)
                        // ->where('par_itemtype_no_fk', '=', 0)
                        ->orderBy('item_type_name')
                        ->select('item_type_name', 'itemtype_no_pk')
                        ->get();

        return Template::loadview("admin.settings.item.item_type_list", [
            'item_type' => $item_type,
        ]);
    }

    /**
     * Item Type List
     */
    public function itemTypeV1()
    {
        $item_type = ItemType::where('status', '1')
                        ->where('MAJOR_GROUP_IND', 1)
                        // ->where('par_itemtype_no_fk', '=', 0)
                        ->orderBy('item_type_name')
                        ->select('item_type_name', 'itemtype_no_pk')
                        ->get();

        return Template::loadview("admin.settings.item.v1.item_type_list_v1", [
            'item_type' => $item_type,
        ]);
    }

    /**
     * Get all item type data to feed datatable
     */
    public function getData()
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $items = DB::table('ITEM_TYPE_VW')
                        ->where('au_entry_hospital_pk_no', $hospital_id)
                        ->select('parent_type_name', 'item_name', 'sl_no', 'default_discount', 'acc_ledger_no_fk', 'acc_par_itemtype_no_fk', 'type_auto_con_flag', 'status', 'itemtype_no_pk')
                        ->orderBy('item_name')
                        ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Filter: Item Type
     */
    public function filter(Request $request)
    {
        $item_type = $request->input('item_type');

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $items = DB::table('ITEM_TYPE_VW')
                    ->where('au_entry_hospital_pk_no', $hospital_id)
                    ->select('parent_type_name', 'item_name', 'sl_no', 'default_discount', 'acc_ledger_no_fk', 'acc_par_itemtype_no_fk', 'type_auto_con_flag', 'status', 'itemtype_no_pk')
                    ->orderBy('item_name');

        if($item_type != "") {
            $items = $items->where('parent_type_name', $item_type);
        }

        $items = $items->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    /**
     * Item Type List
     */
    public function getItemTypeList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'ITEM_TYPE_VW';
        // Table's primary key
        $primaryKey = 'itemtype_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'parent_type_name', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'sl_no', 'dt' => 3),
            array('db' => 'default_discount', 'dt' => 4),
            array('db' => 'acc_ledger_no_fk', 'dt' => 5),
            array('db' => 'acc_par_itemtype_no_fk', 'dt' => 6),
            array('db' => 'type_auto_con_flag', 'dt' => 7),
            array('db' => 'status', 'dt' => 8),
            array('db' => 'itemtype_no_pk', 'dt' => 9),
        );
        // dd($sql_cond);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        //        $columns = array(
        //            'sl',
        //            'parent_type_name',
        //            'item_name',
        //            'sl_no',
        //            'acc_ledger_no_fk',
        //            'acc_par_itemtype_no_fk',
        //            'type_auto_con_flag',
        //            'status',
        //            'itemtype_no_pk',
        //        );
        //
        //        $sql = "select * from ITEM_TYPE_VW";
        //        $order_by_column = "itemtype_no_pk";
        //
        //        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);
        //
        //        echo json_encode($json_data);
    }

    public function itemTypeStore(ItemTypeRequest $request)
    {
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'itemtype_code' => $request->item_type_code,
                'item_type_name' => $request->item_type_name,
                'par_itemtype_no_fk' => $request->parent_type,
                'sl_no' => $request->item_serial_number,
                'default_discount' => $request->default_discount,
                'acc_ledger_no_fk' => $request->account_ledger ? 1 : 0,
                'type_auto_con_flag' => $request->auto_posting ? 1 : 0,
                'acc_par_itemtype_no_fk' => $request->parent_ledger ? 1 : 0,
                'status' => $request->item_status ? 1 : 0,
                'asset_depreciation_pct' => $request->asset_depreciation_pct,
                'asset_depreciation_life_year' => $request->asset_depreciation_life_year,
                'depreciation_residual_val_pct' => $request->depreciation_residual_val_pct,
                'major_group_ind' => $request->major_group_ind ? 1 : 0,
                'minor_group_ind' => $request->minor_group_ind ? 1 : 0,
                'ipd_discount_head_ind' => $request->ipd_discount_head_ind ? 1 : 0,
                'ipd_bill_summary_head_ind' => $request->ipd_bill_summary_head_ind ? 1 : 0,
                'referral_payment_head_ind' => $request->referral_payment_head_ind ? 1 : 0,
                'inventory_head_ind' => $request->inventory_ind ? 1 : 0,
                'asset_group_ind' => $request->asset_group_ind ? 1 : 0,
                'asset_su_no_fk' => $request->asset_sub_store,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data);
            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->itemTypeModel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->itemTypeModel->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function itemTypeEdit($id)
    {
        // $asset_sub_store =  DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('asset_sub_store_ind', 1)->where('status', 1)->get();

        $asset_sub_store =  DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('status', 1)->get();
        $data = $this->itemTypeModel->show($id);
        $item_type_parent = ItemType::where('MAJOR_GROUP_IND', 1)->select('itemtype_no_pk', 'item_type_name')->get();

        return Template::loadView("admin.settings.item.create_item_type_form", [
            'item_type' => $data,
            'item_type_parent' => $item_type_parent,
            'asset_sub_store' => $asset_sub_store,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create_item_form()
    {
        $page_type = "main";
        //$item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();

        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = Supplier::where('status', 1)->get();

        dd(1);
        //       dd($item_cat_sub_data_2);
        return Template::loadview("admin.settings.item.create_item_form", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create_quick_item_form()
    {
        $page_type = "quick";
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        // $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $itemCode = "ITEMTYPE";
        $itemTypelookupdata = DB::table('sysc_itemtype_workflow')
            ->select('workflow_no_pk', 'workflow_name', 'workflow_code')
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('workflow_name', 'asc')
            ->get();

        $item_type_lookup = [];
        if (!empty($itemTypelookupdata)) {
            foreach ($itemTypelookupdata as $row) {
                $item_type_lookup[$row->workflow_code] = $row->workflow_name;
            }
        }

        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

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

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();

        //dd($service_unit);

        return Template::loadview("admin.settings.item.create_item_form_elements", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'item_type_lookup' => $item_type_lookup,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'main_store_list' => $main_store_list,
        ]);
    }
    public function create_quick_item_form_po()
    {
        $page_type = "quick";
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        // $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            // $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
            $item_type = DB::table('sysc_itemtype_workflow')
            ->select('workflow_no_pk as itemtype_no_pk', 'workflow_name', 'workflow_code as item_name')
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('workflow_name', 'asc')
            ->get();
            // dd($itemTypelookupdata,$item_type);
        // $item_type_lookup = [];
        // if (!empty($itemTypelookupdata)) {
        //     foreach ($itemTypelookupdata as $row) {
        //         $item_type_lookup[$row->workflow_code] = $row->workflow_name;
        //     }
        // }
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

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


        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();


        $itemTypelookupdata = DB::table('sysc_itemtype_workflow')
                                ->select('workflow_no_pk', 'workflow_name', 'workflow_code')
                                ->where('status', 1)
                                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                                ->orderBy('workflow_name', 'asc')
                                ->get();

        $item_type_lookup = [];
        if (!empty($itemTypelookupdata)) {
            foreach ($itemTypelookupdata as $row) {
                $item_type_lookup[$row->workflow_code] = $row->workflow_name;
            }
        }

        //dd($service_unit);

        return Template::loadview("admin.settings.item.create_item_form_element_po", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'genaric_name' => $genaric_name,
            'item_type_lookup' => $item_type_lookup,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
        ]);
    }


    public function getNewItemInfo(Request $request)
    {
        $item_info = DB::table('sysc_serviceitem_vw')->where('item_no_pk', $request->item_id)->first();

        return response()->json($item_info);
    }
    public function addNewGenericItem(Request $request)
    {

        $generic_name = $request->generic_name;
        // dd($generic_name);
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        $sequence = DB::getSequence();
        $generic_no_pk_seq = $sequence->nextValue('generic_no_pk_seq');
        try {
            $data = [
                'generic_no_pk' => $generic_no_pk_seq,
                'generic_name' =>   $generic_name,
                'au_entry_session' => "session",
                'au_entry_hospital_no_fk' => $hospital_no_pk,
                'au_entry_by' => $auth_id,
                'au_entry_at' => date("Y-m-d"),
                'status' => 1,
            ];
            DB::table('sysc_generic')->insert($data);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $generic_no_pk_seq];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);


        return response()->json();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function item_type_list()
    {
        // return Template::loadview("admin.settings.item.item_type_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_item_type()
    {

        return Template::loadview("admin.settings.item.create_item_type");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_item_type_form()
    {
        return Template::loadview("admin.settings.item.create_item_type_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ItemRequest $request)
    {
        // dd($request->all());
        //return $request;
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($request->item_type != "") {
            $item_type = ItemType::where("itemtype_no_pk", $request->item_type)->first();
        }

        $files = $request->file('item_photo');
        $files1 = $request->file('item_photo1');
        $files2 = $request->file('item_photo2');
        $files3 = $request->file('item_photo3');
        DB::beginTransaction();
        try {

            $data = [
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'item_short_name' => $request->item_short_name,
                'generic_no_fk' => $request->item_generic_id,
                'itemtype_no_fk' => $request->item_type,
                'serviceunit_no_fk' => $request->service_unit,
                'item_type' => $request->item_type_lookup != "" ? $request->item_type_lookup : '',
                'sales_price' => $request->item_sales_price ? $request->item_sales_price : 0,
                'purchase_price' => $request->item_purchase_price ? $request->item_purchase_price : 0,
                'dealer_sales_price' => $request->item_dealers_price ? $request->item_dealers_price : 0,
                'urgent_fee_amt' => $request->urgent_fee_amt ? $request->urgent_fee_amt : 0,
                'temperature' => $request->temperature,
                're_order_level' => $request->re_order_level ? $request->re_order_level : 0,
                'reorder_type' => $request->re_order_type,
                'manufacturer_no_fk' => $request->manufacturer_no_fk,
                'supplier_pk_no' => $request->supplier_name,
                'vat_percent' => $request->item_vat_persent,
                'uom_no_fk' => $request->item_uom,
                'note_text' => $request->short_desc,
                'plain_text' => $request->long_desc,
                'item_cat_lookupdata_no_fk' => $request->item_category,
                'item_subcat_lookupdata_no_fk' => $request->item_category_sub,
                'item_sub1cat_lookupdata_no_fk' => $request->item_category_sub_1,
                'item_sub2cat_lookupdata_no_fk' => $request->item_category_sub_2,
                'status' => isset($request->item_status) ? 1 : 0,
                'refferral_pay_calc_ind' => isset($request->ref_payment) && $request->ref_payment == 1 ? 1 : 0,
                'housekeeping_ind' => isset($request->housekeeping_ind) && $request->housekeeping_ind == 1 ? 1 : 0,
                'housekeeping_washable_ind' => isset($request->washable_ind) && $request->washable_ind == 1 ? 1 : 0,
                'pkg_referral_ind' => isset($request->pkg_ref_ind) ? 1 : 0,
                'manual_item_rate_ind' => $request->rate_ind,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'pr_uom_no_fk' => $request->purchase_uom,
                'pr_uom_conversion_qty' => $request->box_conversion_qty,
                'pr_box_qty' => $request->pr_box_qty,
                'pr_uom_tradeprice' => $request->box_purchase_price,
                'expireable' => $request->expireable_ind,
                'disc_aplicable' => $request->dis_inapplicable ? $request->dis_inapplicable : 0,
                'accounts_mapping_su_no_fk' => $request->accounts_service_unit,
                'non_stock_ind' => $request->stock_type,
                'analyzer_ind' => $request->analyzer_ind,
                'pack_type' => $request->item_pack_type,

                'mrp_ind' => $request->mrp_ind,
                'expensive_ind' => $request->expensive_ind,
                'freezing_ind' => $request->tempature_ind,
                'slow_moving_ind' => $request->slow_moving_ind,
                'narcoticdrug_ind' => $request->narcotic_ind,
                'package_ind' => $request->package_ind,
                'referral_pay_amt' => $request->referral_pay_amt,
                'referral_pay_pct' => $request->referral_pay_pct,
                'provider_pay_amt' => $request->provider_pay_amt,
                'provider_pay_pct' => $request->provider_pay_pct,
                'default_discount_pct' => $request->default_discount_pct,
                'mainstore_su_no_fk' => $request->mainstore_su_no_fk,
            ];
            $image_name = "";
            $image_name1 = "";
            $image_name2 = "";
            $image_name3 = "";
            if ($files = $request->file('item_photo')) {
                $image_name = "item_photo1_" . $request->item_name  . "." . $files->getClientOriginalExtension();
                $data['item_photo'] = $image_name;
                $image_name = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo1')) {
                $image_name1 = "item_photo2_" . $request->item_name  . "." . $files1->getClientOriginalExtension();
                $data['item_photo_1'] = $image_name1;
                $image_name1 = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo2')) {
                $image_name2 = "item_photo3_" . $request->item_name  . "." . $files2->getClientOriginalExtension();
                $data['item_photo_2'] = $image_name2;
                $image_name2 = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo3')) {
                $image_name3 = "item_photo4_" . $request->item_name  . "." . $files3->getClientOriginalExtension();
                $data['item_photo_3'] = $image_name3;
                $image_name3 = "item_photo1_" . $request->item_name;
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

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $response = $this->itemModel->create($data);
                $item_id = $response->item_no_pk;
            } else {

                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->itemModel->update($data, $id);
                $item_id = $id;
            }

            DB::commit();

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'item_id' => $item_id, 'item_name' => $request->item_name];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    // Attribute Group
    public function attindex()
    {
        $item = DB::table('LABS_TESTATTRGROUP')
            ->orderBy('TEST_GROUP_NO_PK', 'desc')
            ->get();
        // dd($item->all());
        return Template::loadview("admin.settings.item.create_attribute_group", compact('item'));
    }

    public function attstore(Request $request)
    {
        $validData = Validator::make($request->all(), [
            't_att_group_name' => 'required',
            'att_group_name' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('TEST_GROUP_NO_PK_seq') + 1;
                DB::table('LABS_TESTATTRGROUP')->insert([
                    'TEST_GROUP_NO_PK' => $sysc_pat_no_pk_seq,
                    'TEST_GROUP_CODE' => $request->t_att_group_name,
                    'ATTRGROUP' => $request->att_group_name,
                    'AU_ENTRY_AT' => date("Y-M-d H:i:s"),
                    'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                    'STATUS' => $request->status,
                    'AU_ENTRY_SESSION' => 'hospital',
                ]);
                $this->message = ['msg' => 'Data Added Successfully!!!', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }


    public function editAtt($edit_id)
    {
        $item = DB::table('LABS_TESTATTRGROUP')->where('TEST_GROUP_NO_PK', $edit_id)->first();
        // dd($item);
        return Template::loadview("admin.settings.item.create_attribute_group_edit", compact('item'));
    }

    public function updatetAtt(Request $request, $update_id)
    {
        $validData = Validator::make($request->all(), [
            't_att_group_name' => 'required',
            'att_group_name' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $data = [
                    'TEST_GROUP_CODE' => $request->t_att_group_name,
                    'ATTRGROUP' => $request->att_group_name,
                    'STATUS' => $request->status,
                ];
                DB::table('LABS_TESTATTRGROUP')->where('TEST_GROUP_NO_PK', $update_id)->update($data);
                $this->message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }


    public function getItemList(Request $request)
    {



        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";

        $table = 'service_item_list_vw';
        // Table's primary key
        $primaryKey = 'item_no_pk';

        $columns = array(
            array('db' => 'sl', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),
            array('db' => 'item_no_pk', 'dt' => 9),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        //        $columns = array(
        //            'sl',
        //            'item_code',
        //            'item_name',
        //            'item_short_name',
        //            'item_type',
        //            'serviceunit_name',
        //            'manufacturer_no_fk',
        //            'sales_price',
        ////            'item_sub1cat_lookupdata_no_fk',
        ////            'item_sub2cat_lookupdata_no_fk',
        ////            'item_subcat_lookupdata_no_fk',
        ////            'item_cat_lookupdata_no_fk',
        //            'vat_percent',
        //            'item_no_pk',
        //        );
        //
        //        $sql = "SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price,
        //       si.vat_percent,si.item_no_pk,  rownum rownumber, si.au_update_at, si.au_entry_at from sysc_serviceitem si left join sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join sysc_lookupdata umo on umo.lookupdata_no_pk = si.uom_no_fk";
        //        $order_by_column = "item_no_pk";
        //
        //        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);
        //        echo json_encode($json_data);
    }

    public function getItemListAll(Request $request)
    {

        $columns = array(
            'sl',
            'item_name',
            'generic_name',
            'item_type_name',
            'item_no_pk',
        );

        $sql = "SELECT '' as sl, si.item_name, sl.lookupdata_name as generic_name, it.item_type_name, si.item_no_pk,  rownum rownumber, si.au_update_at, si.au_entry_at from sysc_serviceitem si left join sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk ";

        $order_by_column = "item_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        //$item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");

        $itemTypelookupdata = DB::table('sysc_itemtype_workflow')
        ->select('workflow_no_pk', 'workflow_name', 'workflow_code')
        ->where('status', 1)
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->orderBy('workflow_name', 'asc')
        ->get();

        $item_type_lookup = [];
        if (!empty($itemTypelookupdata)) {
            foreach ($itemTypelookupdata as $row) {
                $item_type_lookup[$row->workflow_code] = $row->workflow_name;
            }
        }

        //$item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        $data = DB::table('sysc_serviceitem s')->select('s.*', 'w.generic_name')->leftjoin('sysc_serviceitem_vw w', 'w.item_no_pk', '=', 's.item_no_pk')->where('s.item_no_pk', $id)->first();
        // $data = Item::find($id);
        // dd( $pack_type);
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

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();


        // dd($data);
        return Template::loadview("admin.settings.item.create_item_form_elements", [
            'item' => $data,
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'pack_type' => $pack_type,
            'item_type_lookup' => $item_type_lookup,
            'item_cat_data' => $item_cat_data,
            'item_cat_sub' => $item_cat_sub,
            'item_cat_sub_1' => $item_cat_sub_1,
            'item_cat_sub_2' => $item_cat_sub_2,
            'suppiler_arr' => $suppiler_arr,
            'page_type' => $page_type,
            'main_store_list' => $main_store_list,
        ]);
    }
    public function edit_quick_item_form_po($id)
    {
        // dd($id);
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        //$item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        //$item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        // $data = item::find($id);
        $data = DB::table('sysc_serviceitem s')->select('s.*', 'w.generic_name')->leftjoin('sysc_serviceitem_vw w', 'w.item_no_pk', '=', 's.item_no_pk')->where('s.item_no_pk', $id)->first();
        // dd($data);
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

        $itemTypelookupdata = DB::table('sysc_itemtype_workflow')
                                ->select('workflow_no_pk', 'workflow_name', 'workflow_code')
                                ->where('status', 1)
                                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                                ->orderBy('workflow_name', 'asc')
                                ->get();

        $item_type_lookup = [];
        if (!empty($itemTypelookupdata)) {
            foreach ($itemTypelookupdata as $row) {
                $item_type_lookup[$row->workflow_code] = $row->workflow_name;
            }
        }

        // dd($data);
        return Template::loadview("admin.settings.item.create_item_form_element_po", [
            'item' => $data,
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'pack_type' => $pack_type,
            'item_type_lookup' => $item_type_lookup,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_sub' => $item_cat_sub,
            'item_cat_sub_1' => $item_cat_sub_1,
            'item_cat_sub_2' => $item_cat_sub_2,
            'suppiler_arr' => $suppiler_arr,
            'page_type' => $page_type
        ]);
    }


    public function getItemTypeInfoById($id)
    {
        return $id;
    }

    public function getItemTypes(Request $request)
    {
        //

    }

    public function getItemName()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        $corporate_id = isset($_POST['corporate_id']) ? $_POST['corporate_id'] : "";
        $patient_type = isset($_POST['patient_type']) ? $_POST['patient_type'] : "";
        $admission_id = isset($_POST['admission_id']) ? $_POST['admission_id'] : "";
        $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : "";
        $item_type_void = isset($_POST['item_type_void']) ? strtoupper(strval($_POST['item_type_void'])) : "";
        $su_no_id = isset($_POST['su_no_id']) ? $_POST['su_no_id'] : "";

        return $this->getItemListAutoComplete($keyword, $item_type, 0, 0, $item_type_void, $su_no_id, $corporate_id, $patient_type, $admission_id,$patient_id   );
    }
    public function getItemNameV1()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        $corporate_id = isset($_POST['corporate_id']) ? $_POST['corporate_id'] : "";
        $patient_type = isset($_POST['patient_type']) ? $_POST['patient_type'] : "";
        $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : "";
        $admission_id = isset($_POST['admission_id']) ? $_POST['admission_id'] : "";
        $item_type_void = isset($_POST['item_type_void']) ? strtoupper(strval($_POST['item_type_void'])) : "";
        $su_no_id = isset($_POST['su_no_id']) ? $_POST['su_no_id'] : "";

        return $this->getItemListAutoCompleteV1($keyword, $item_type, 0, 0, $item_type_void, $su_no_id, $corporate_id, $patient_type, $admission_id,$patient_id);
    }

    public function pathologyItemSetup()
    {
        $gender = $this->getLookupListByCode("GENDER");
        $pathology = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $default_analyzer = DB::table("sysc_serviceitem")->select('item_no_pk', 'item_name')->where("analyzer_ind", 1)->get();
        $container_ind = DB::table("sysc_serviceitem")->select('item_no_pk', 'item_name')->where("container_ind", 1)->get();

        $labs_testtemplate = DB::table("labs_testtemplate")->select('test_temp_no_pk', 'temp_name')->where('status', 1)->get();
        $labs_sample = DB::table("labs_sample")->select('sam_no_pk', 'sam_name')->where('status', 1)->get();

        return Template::loadview("admin.settings.item.pathology_item_setup", ['gender' => $gender, 'pathology' => $pathology, 'default_analyzer' => $default_analyzer, 'container_ind' => $container_ind, 'labs_testtemplate' => $labs_testtemplate, 'labs_sample' => $labs_sample]);
    }

    public function pathologyItemStore(PathologyItemSetupRequest $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            $data = [
                'item_type' => 'LAB',
                'item_code' => $request->exam_setup_item_id,
                'active_stat' => $request->exam_active,
                'item_short_name' => $request->exam_short_name,
                'item_name' => $request->exam_item_name,
                'serviceunit_no_fk' => $request->exam_setup_department,
                'sales_price' => $request->exam_rate,
                'normal_delivery_hour' => $request->normal_delivery_time,
                'urgent_delivery_hour' => $request->urgent_delivery_time,
                'no_of_label' => $request->no_of_label,
                'testbygender_ind' => $request->exam_by_gender,
                'sc_min_volume' => $request->minimum_collection_volume,
                'report_group' => $request->exam_setup_report_group,
                'default_analyzer_no_fk' => $request->default_analyzer,
                'sam_no_fk' => $request->exam_setup_sample,
                'con_no_fk' => $request->exam_setup_container,
                'report_header' => $request->report_header,
                'test_temp_no_fk' => $request->exam_template,
                'sc_instructions' => $request->sample_collection_instructions,
                'test_method' => $request->item_method,
                'note_text' => $request->notes,
                'interpretation' => $request->interpretation,
                'comments_text' => $request->comments,
                'plain_text' => $request->other_plain_text,
                'status' => $request->exam_setup_status,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $response = $this->itemModel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->itemModel->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function pathologyItemSearch(Request $request)
    {
        $item_id = $request->hdn_item_item_id_0;
        $pathology_setup_item_name = $request->pathology_setup_item_name;
        $pathology_setup_sample = $request->pathology_setup_sample;
        $pathology_setup_department = $request->pathology_setup_department;
        $pathology_setup_template = $request->pathology_setup_template;
        $pathology_exam_list_status = $request->pathology_exam_list_status;

        $pathologyquery = DB::table("sysc_serviceitem")
            ->select('item_no_pk', 'item_code', 'item_name')
            ->where('item_type', 'LAB');
        if ($pathology_exam_list_status != 2) {
            $pathologyquery->when($pathology_exam_list_status, function ($query, $pathology_exam_list_status) {
                return $query->where('status', $pathology_exam_list_status);
            });
        }
        if ($item_id != "") {
            $pathologyquery->when($item_id, function ($query, $item_id) {
                return $query->where('item_no_pk', $item_id);
            });
        }
        if ($pathology_setup_item_name != "") {
            $pathologyquery->when($pathology_setup_item_name, function ($query, $pathology_setup_item_name) {
                return $query->where('item_name', $pathology_setup_item_name);
            });
        }
        if ($pathology_setup_sample != "") {
            $pathologyquery->when($pathology_setup_sample, function ($query, $pathology_setup_sample) {
                return $query->where('sam_no_fk', $pathology_setup_sample);
            });
        }
        if ($pathology_setup_department != "") {
            $pathologyquery->when($pathology_setup_department, function ($query, $pathology_setup_department) {
                return $query->where('serviceunit_no_fk', $pathology_setup_department);
            });
        }
        if ($pathology_setup_template != "") {
            $pathologyquery->when($pathology_setup_template, function ($query, $pathology_setup_template) {
                return $query->where('test_temp_no_fk', $pathology_setup_template);
            });
        }
        $pathology = $pathologyquery->get();

        $table_data = '<table id="data-table" class="table data-table table-bordered table-hover table-striped mt-2 border mb-0">
        <thead class="bg-light">
        <tr>
        <th class="text-left w-5">ID</th>
        <th class="text-left">Name</th>
        <th class="text-left">Action</th>

        </tr>
        </thead>
        <tbody>';
        foreach ($pathology as $value) {
            $table_data .= '<tr>';
            $table_data .= '<td class="text-left">' . $value->item_code . '</td>';
            $table_data .= '<td>' . $value->item_name . '</td>';
            $table_data .= '<td><span class="edit_item fas fa-edit" data-item_id="' . $value->item_no_pk . '" data-action="' . route('pathology-item-setup-edit') . '"></span></td>';
            $table_data .= '</tr>';
        }
        $table_data .= '</tbody></table>';

        echo $table_data;
    }

    public function pathologyItemEdit()
    {
        $item_id = $_GET['item_id'];
        $item_info = DB::table("sysc_serviceitem")->where("item_no_pk", $item_id)->first();
        $gender = $this->getLookupListByCode("GENDER");
        $pathology = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $default_analyzer = DB::table("sysc_serviceitem")->select('item_no_pk', 'item_name')->where("analyzer_ind", 1)->get();
        $container_ind = DB::table("sysc_serviceitem")->select('item_no_pk', 'item_name')->where("container_ind", 1)->get();

        $labs_testtemplate = DB::table("labs_testtemplate")->select('test_temp_no_pk', 'temp_name')->where('status', 1)->get();
        $labs_sample = DB::table("labs_sample")->select('sam_no_pk', 'sam_name')->where('status', 1)->get();

        return Template::loadview("admin.settings.item.pathology_item_setup_form", ["item_info" => $item_info, 'gender' => $gender, 'pathology' => $pathology, 'default_analyzer' => $default_analyzer, 'container_ind' => $container_ind, 'labs_testtemplate' => $labs_testtemplate, 'labs_sample' => $labs_sample]);
    }

    public function radiologyItemSetup()
    {
        $dept = DB::table('sysc_serviceunit')->where('radiology_ind', 1)->where('status', 1)->get();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $radiology_data = DB::table('sysc_serviceitem si')->select(
            'si.item_code',
            'si.report_header',
            'si.serviceunit_no_fk',
            'si.stat_delivery_hour',
            'si.item_name',
            'si.item_no_pk',
            'si.item_pack_type',
            'si.item_short_name',
            'si.sales_price',
            'si.urgent_fee_amt',
            'si.normal_delivery_hour',
            'si.urgent_delivery_hour',
            'su.radiology_ind',
            'si.active_stat',
            'su.serviceunit_name'
        )->leftjoin('sysc_serviceunit su', 'si.serviceunit_no_fk', 'su.serviceunit_no_pk')
            ->where('su.radiology_ind', 1)
            ->where('si.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('item_no_pk', 'desc')
            ->get();
        // dd($radiology_data);
        return Template::loadview("admin.settings.item.radiology_item_setup", ['dept' => $dept, 'radiology_data' => $radiology_data]);
    }
    public function RadiologyItemStore(RadiologyItemRequest $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'item_name' => $request->item_name,
                'report_header' => $request->report_header,
                'item_code' => $request->item_no_barcode,
                'item_short_name' => $request->short_name,
                'normal_delivery_hour' => $request->normal_delivery_hour,
                'urgent_delivery_hour' => $request->urgent_delivery_hour,
                'sales_price' => $request->item_price,
                'urgent_fee_amt' => $request->urgent_item_price,
                'ITEM_TYPE' => 'RAD',
                'serviceunit_no_fk' => $request->item_department,
                'stat_delivery_hour' => $request->stat_delivery_hour,
                'active_stat' => $request->radiology_active,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data)

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->RadiologyItem->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->RadiologyItem->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function radiologyItemEdit($id)
    {
        $dept = DB::table('sysc_serviceunit')->where('radiology_ind', 1)->where('status', 1)->get();
        $radiology = DB::table('sysc_serviceitem si')->select(
            'si.item_code',
            'si.report_header',
            'si.serviceunit_no_fk',
            'si.stat_delivery_hour',
            'si.item_name',
            'si.item_no_pk',
            'si.item_pack_type',
            'si.item_short_name',
            'si.sales_price',
            'si.urgent_fee_amt',
            'si.normal_delivery_hour',
            'si.urgent_delivery_hour',
            'si.active_stat',
            'su.serviceunit_name'
        )
            ->leftjoin('sysc_serviceunit su', 'si.serviceunit_no_fk', 'su.serviceunit_no_pk')
            ->where('si.item_no_pk', $id)
            ->first();
        return Template::loadview("admin.settings.item.radiology_item_form", ['dept' => $dept, 'radiology' => $radiology]);
    }

    // Other Item
    public function otherItemSetup()
    {
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $supplier = DB::table('inv_supplier')->where('manufecturer_flag', null)->get();
        $manufacturer = DB::table('inv_supplier')->where('manufecturer_flag', 1)->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        // $afmsd = $this->getLookupListByCode("AFMSDCAT");
        $itemType = $this->getLookupListByCode("ITEMTYPE");
        return Template::loadview("admin.settings.item.other_item_setup", [
            'service_unit' => $service_unit,
            'supplier' => $supplier,
            'uom' => $uom,
            'pack_type' => $pack_type,
            'itemType' => $itemType,
            'manufacturer' => $manufacturer,
            // 'afmsd'         => $afmsd
        ]);
    }
    public function OtherItemStore(otherItemRequest $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            $data = [
                'item_type' => $request->otherOtDiet_item_setup,
                'item_code' => $request->item_no_barcode,
                'item_name' => $request->item_name,
                'test_short_name' => $request->short_name,
                'itemtype_no_fk' => $request->item_type,
                // 'item_uom_name'         =>$request->item_map_type,
                'uom_no_fk' => $request->uom,
                'serviceunit_no_fk' => $request->item_department,
                'sales_price' => $request->sales_price,
                'purchase_price' => $request->purchase_unit_price,
                'discount_per' => $request->discount_amount,
                'report_header' => $request->report_header,
                'anaesthesia_cat_ind' => $request->edsims_category,
                // 'supplier_no_fk'        =>$request->supplier,
                'manufacturer_no_fk' => $request->manufacturer,
                'ot_service_ind' => $request->ot_duration,
                'active_stat' => $request->active,
                'expireable' => $request->expirable,
                'dk_current_ind' => $request->demand_flag,
                'in_box_qty' => $request->re_order_qty,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $response = $this->otherItem->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->otherItem->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function otherItemWorklist()
    {
        // $data = DB::table('sysc_serviceitem_vw')->orderBy('item_no_pk','DESC')->get();
        $data = DB::select("select * from sysc_serviceitem_vw
            where item_type = 'LAB' or
            item_type = 'RAD' or
            item_type = 'OTHERS' or
            item_type = 'SUR' or
            item_type = 'FOOD' or
            item_type = 'MED' or
            item_type = 'SERVICE' or
            item_type = 'ANALYZER' or
            item_type = 'VACUTTE' or
            item_type = 'MODALITY'
            ORDER BY item_no_pk DESC ");

        return Template::loadview("admin.settings.item.other_item_worklist", [
            'data' => $data,
        ]);
    }
    public function otherItemGetAllData(Request $request)
    {
        $columns = array(
            'sl',
            'item_code',
            'item_name',
            'serviceunit_no_fk',
            'anaesthesia_cat_ind',
            'item_uom_name',
            'dk_current_ind',
            'expireable',
            'active_stat',
            'item_no_pk',
        );

        $sql = "SELECT '' as sl, item_code, item_name,serviceunit_no_fk,anaesthesia_cat_ind,item_uom_name,dk_current_ind,expireable,active_stat,item_no_pk, rownum rownumber, au_update_at, au_entry_at from sys_serviceitem ";
        $order_by_column = "item_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function otherItemEdit($id)
    {
        // dd($id);

        $other_item_data = $this->otherItem->show($id);
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $supplier = DB::table('inv_supplier')->where('manufecturer_flag', null)->get();
        $manufacturer = DB::table('inv_supplier')->where('manufecturer_flag', 1)->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        // $afmsd = $this->getLookupListByCode("AFMSDCAT");
        $itemType = $this->getLookupListByCode("ITEMTYPE");
        return template::loadview('admin.settings.item.other_item_popup', [
            'other_item_data' => $other_item_data,
            'service_unit' => $service_unit,
            'supplier' => $supplier,
            'uom' => $uom,
            'pack_type' => $pack_type,
            'itemType' => $itemType,
            'manufacturer' => $manufacturer,
            // 'afmsd'         => $afmsd
        ]);
    }

    /**
     * Item Type Search
     */
    public function itemTypeSearch(Request $request)
    {
        $item_type = $request->item_type;
        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_pk = $item_type" : "";

        $columns = array(
            'sl',
            'parent_type_name',
            'item_name',
            'sl_no',
            'default_discount',
            'acc_ledger_no_fk',
            'acc_par_itemtype_no_fk',
            'type_auto_con_flag',
            'status',
            'itemtype_no_pk',
        );

        $sql = "select * from ITEM_TYPE_VW $sql_cond";
        //        dd($sql);
        $order_by_column = "itemtype_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }
    public function searchItemList(Request $request)
    {

        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $table = 'SERVICE_ITEM_LIST_VW';
        // Table's primary key
        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && !empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit and itemtype_no_fk = $item_type";
        }

        if (!empty($item_type) && empty($service_unit)) {
            $where = " itemtype_no_fk = $item_type";
        }

        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit ";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where .=  $where != "" ? " and au_entry_hospital_pk_no = $hospital_id and item_type != 'MED'" : " au_entry_hospital_pk_no = $hospital_id and item_type != 'MED'";

        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where .= "and item_type = 'MED'";
        }

        $columns = array(
            array('db' => 'sl', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),
            array('db' => 'item_no_pk', 'dt' => 9),
            array('db' => 'status', 'dt' => 10),
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

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= (strtoupper($hospital_code) == 'MCARE') ? " and item_type == 'MED'" : " and item_type != 'MED'";
      
        $sql = DB::select(DB::raw("SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price,item_sub1cat_lookupdata_no_fk,si.status,
        item_sub2cat_lookupdata_no_fk,
        item_subcat_lookupdata_no_fk,
        item_cat_lookupdata_no_fk, si.vat_percent,si.item_no_pk,si.purchase_price,supp.supplier_name from sysc_serviceitem si 
        left join inv_supplier supp on supp.supplier_no_pk = si.supplier_pk_no 
        left join sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk 
        left join sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk
        left join sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk
        left join sysc_lookupdata umo on umo.lookupdata_no_pk = si.uom_no_fk $sql_cond order by si.item_name asc,su.serviceunit_name asc"));
  
        if ($request->hdn_report_type == "EXCEL") {
            // $headers = array(
            //     "Content-type" => "text/csv",
            //     "Content-Disposition" => "attachment; filename=Item_list.csv",
            //     "Pragma" => "no-cache",
            //     "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            //     "Expires" => "0",
            // );
            // $columns = array("SL", "Item Code", "Item Name", "Item Short Name", "Item Type", "Service Unit", "Price");
            // $callback = function () use ($columns, $sql) {
            //     $c = 1;
            //     $file = fopen('php://output', 'w');
            //     fputcsv($file, $columns);
            //     if (!empty($sql)) {
            //         foreach ($sql as $value) {

            //             fputcsv($file, array($c, $value->item_code, $value->item_name, $value->item_short_name, $value->item_type, $value->serviceunit_name, $value->sales_price));
            //             $c++;
            //         }
            //     }

            //     fclose($file);
            // };
            // return Response::stream($callback, 200, $headers);
            $title = "Item List Report";
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details];

            $fileToExport = "item_list_print";
            $html = View("admin.settings.item.item_list_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            // header("Content-type: application/vnd.ms-excel");
            header("Content-type: text/csv");
            return $html;
      
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
    public function getCategoryWiseSubCategory(Request $request)
    {
        $sub_cate = DB::table('sysc_lookupdata')->where('lookupdata_pk_no_parent', $request->category_id)->get();

        return Template::loadView("admin.settings.item.category_dropdown", ['sub_cate' => $sub_cate]);
    }



    public function pathologyValue()
    {

        $pathAttrubute = DB::select(DB::raw("select item_name,item_no_pk from sysc_serviceitem where item_type = 'LAB'"));
        $test_attributes = DB::select(DB::raw("select teststruct_no_pk,attr from LABS_TESTSTRUCT"));

        return Template::loadView("admin.settings.path_attribute.create_attribute_value", [
            'pathAttrubute' => $pathAttrubute,
            'test_attributes' => $test_attributes
        ]);
    }

    public function attValueEdit($id)
    {

        $pathAttrubute = DB::select(DB::raw("select item_name,item_no_pk from sysc_serviceitem where item_type = 'LAB'"));
        $test_attributes = DB::select(DB::raw("select teststruct_no_pk,attr from LABS_TESTSTRUCT"));
        $data = $this->DefaultAttributeValue->show($id);
        return Template::loadView("admin.settings.path_attribute.create_attribute_value_form", [
            'pathAttrubute' => $pathAttrubute,
            'test_attributes' => $test_attributes,
            'testAttribute' => $data
        ]);
    }

    public function pathologyDefaultCreate()
    {

        $pathAttrubute = DB::select(DB::raw("select item_name,item_no_pk from sysc_serviceitem where item_type = 'LAB'"));
        $test_attributes = DB::select(DB::raw("select teststruct_no_pk,attr from LABS_TESTSTRUCT"));

        return Template::loadView("admin.settings.path_attribute.create_attribute_value_form", [
            'pathAttrubute' => $pathAttrubute,
            'test_attributes' => $test_attributes
        ]);
    }

    public function attList()
    {
        $att_values = DB::table('labs_teststructval')->get();
        return Template::loadView("admin.settings.path_attribute.path_attribute_list_value", [
            'att_values' => $att_values
        ]);
    }


    public function pathologyAttData(Request $request)
    {
        $item_id = $request->item_id;
        $test_attributes = DB::select(DB::raw("select teststruct_no_pk,attr from LABS_TESTSTRUCT where item_no_fk = $item_id"));

        return Template::loadView("admin.settings.path_attribute.path_attribute_value_list", [
            'test_attributes' => $test_attributes
        ]);
    }

    public function PathologyAttributeDefaultStore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $teststructval_no_pk_seq = $sequence->nextValue('teststructval_no_pk_seq');
            $data = [
                'teststructval_no_pk' => $teststructval_no_pk_seq,
                'teststruct_no_fk' => $request->attribute_name,
                'item_no_fk' => $request->item_name_parent,
                'test_result' => $request->default_value,
                'default_ind' => $request->default_ind,
                'status' => $request->status,
                'au_entry_at' => date('Y-m-d'),
                'au_update_at' => date('Y-m-d'),
                'au_entry_session' => 'Session',
                'au_update_session' => 'Session',
                'au_entry_hospital_pk_no' => 1,
                'au_update_hospital_pk_no' => 1,
            ];


            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->DefaultAttributeValue->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->DefaultAttributeValue->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function pathologyAttributeAllData(Request $request)
    {

        $table = 'Labs_attributevalue_list_vw';
        // Table's primary key
        $primaryKey = 'teststructval_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_name', 'dt' => 1),
            array('db' => 'attr',  'dt' => 2),
            array('db' => 'test_result',   'dt' => 3),
            array('db' => 'default_ind',   'dt' => 4),
            array('db' => 'status',   'dt' => 5),
            array('db' => 'teststructval_no_pk',   'dt' => 6)
        );
        echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));





        // $columns = array(
        //     'sl',
        //     'item_name',
        //     'attr',
        //     'test_result',
        //     'default_ind',
        //     'status',
        //     'teststructval_no_pk'
        // );

        // $active = '<span class="badge badge-md badge-success"> Active</span>';
        // $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';
        // $yes = '<span class="badge badge-md badge-success"> Yes</span>';
        // $no = '<span class="badge badge-md badge-secondary"> No</span>';

        // $sql = "select '' sl,item.item_name,
        //         tests.attr,
        //         test_val.test_result,
        //         case test_val.default_ind when 1 then '$yes' else '$no' end
        //         case test_val.status when 1 then '$active' else '$inactive' end status,
        //         test_val.teststructval_no_pk,
        //         rownum rownumber,
        //         test_val.au_update_at,
        //         test_val.au_entry_at
        // from labs_teststruct tests
        //         left join labs_teststructval test_val
        //         on teststruct_no_pk = teststruct_no_fk
        //         left join sysc_serviceitem item
        //         on tests.item_no_fk = item.item_no_pk";
        // $order_by_column = "teststructval_no_pk";

        // $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        // echo json_encode($json_data);
    }



    // medicine item Setup

    public function create_medicine_form()
    {
        $page_type = "main";
        //$item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();

        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");
        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");
        $suppiler_arr = Supplier::where('status', 1)->get();
        //       dd($item_cat_sub_data_2);
        return Template::loadview("admin.settings.medicine.create_item_form_elements", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create_medicine()
    {
        $page_type = "quick";
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        // $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk', 'itemtype_code')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

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


        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();

        //dd($service_unit);

        return Template::loadview("admin.settings.medicine.create_item_form", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
        ]);
    }

    public function MedicineitemStore(ItemRequest $request)
    {

        //return $request;
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($request->item_type != "") {
            $item_type = ItemType::where("itemtype_no_pk", $request->item_type)->first();
        }

        $files = $request->file('item_photo');
        $files1 = $request->file('item_photo1');
        $files2 = $request->file('item_photo2');
        $files3 = $request->file('item_photo3');
        DB::beginTransaction();
        try {

            $data = [
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'item_short_name' => $request->item_short_name,
                'generic_no_fk' => $request->item_generic_id,
                'itemtype_no_fk' => $request->item_type,
                'serviceunit_no_fk' => $request->service_unit,
                'item_type' => $request->item_type != "" ? $item_type->itemtype_code : '',
                'sales_price' => $request->item_sales_price ? $request->item_sales_price : 0,
                'purchase_price' => $request->item_purchase_price ? $request->item_purchase_price : 0,
                'dealer_sales_price' => $request->item_dealers_price ? $request->item_dealers_price : 0,
                'urgent_fee_amt' => $request->urgent_fee_amt ? $request->urgent_fee_amt : 0,
                'temperature' => $request->temperature,
                're_order_level' => $request->re_order_level ? $request->re_order_level : 0,
                'reorder_type' => $request->re_order_type,
                'manufacturer_no_fk' => $request->supplier_name,
                'vat_percent' => $request->item_vat_persent,
                'uom_no_fk' => $request->item_uom,
                'note_text' => $request->short_desc,
                'plain_text' => $request->long_desc,
                'item_cat_lookupdata_no_fk' => $request->item_category,
                'item_subcat_lookupdata_no_fk' => $request->item_category_sub,
                'item_sub1cat_lookupdata_no_fk' => $request->item_category_sub_1,
                'item_sub2cat_lookupdata_no_fk' => $request->item_category_sub_2,
                'status' => isset($request->item_status) ? 1 : 0,
                'manual_item_rate_ind' => $request->rate_ind,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'pr_uom_no_fk' => $request->purchase_uom,
                'pr_uom_conversion_qty' => $request->box_conversion_qty,
                'pr_uom_tradeprice' => $request->box_purchase_price,
                'expireable' => $request->expireable_ind,
            ];
            //   dd($data);
            $image_name = "";
            $image_name1 = "";
            $image_name2 = "";
            $image_name3 = "";
            if ($files = $request->file('item_photo')) {
                $image_name = "item_photo1_" . $request->item_name  . "." . $files->getClientOriginalExtension();
                $data['item_photo'] = $image_name;
                $image_name = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo1')) {
                $image_name1 = "item_photo2_" . $request->item_name  . "." . $files1->getClientOriginalExtension();
                $data['item_photo_1'] = $image_name1;
                $image_name1 = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo2')) {
                $image_name2 = "item_photo3_" . $request->item_name  . "." . $files2->getClientOriginalExtension();
                $data['item_photo_2'] = $image_name2;
                $image_name2 = "item_photo1_" . $request->item_name;
            }
            if ($files = $request->file('item_photo3')) {
                $image_name3 = "item_photo4_" . $request->item_name  . "." . $files3->getClientOriginalExtension();
                $data['item_photo_3'] = $image_name3;
                $image_name3 = "item_photo1_" . $request->item_name;
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


            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $response = $this->itemModel->create($data);
                $item_id = $response->item_no_pk;
            } else {

                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->itemModel->update($data, $id);
                $item_id = $id;
            }

            DB::commit();

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'item_id' => $item_id, 'item_name' => $request->item_name];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function getMedItemListAll(Request $request)
    {

        $columns = array(
            'sl',
            'item_name',
            'generic_name',
            'item_type_name',
            'item_no_pk',
        );

        $sql = "SELECT '' as sl, si.item_name, sl.lookupdata_name as generic_name, it.item_type_name, si.item_no_pk,  rownum rownumber, si.au_update_at, si.au_entry_at from sysc_serviceitem si left join sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk ";

        $order_by_column = "item_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function medicineSearchItemList(Request $request)
    {

        $item_type = $request->item_type;
        $service_unit = $request->service_unit;


        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause si.ITEM_TYPE = '$item_type'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause si.serviceunit_no_fk = $service_unit" : "";

        //     $columns = array(
        //         'sl',
        //         'item_code',
        //         'item_name',
        //         'item_short_name',
        //         'item_type',
        //         'serviceunit_name',
        //         'manufacturer_no_fk',
        //         'sales_price',

        //         'vat_percent',
        //         'item_no_pk',
        //     );

        //     $sql = "SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price,
        //    si.vat_percent,si.item_no_pk,  rownum rownumber,
        //     si.au_update_at, si.au_entry_at from sysc_serviceitem si left join
        //     sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join
        //     sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join
        //      sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join
        //     sysc_lookupdata umo on umo.lookupdata_no_pk = si.uom_no_fk $sql_cond";
        //     $order_by_column = "item_no_pk";

        //     $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);
        //     echo json_encode($json_data);

        $table = 'SERVICE_ITEM_LIST_VW';

        // Table's primary key
        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit";
        }

        if (!empty($item_type) && empty($service_unit)) {
            $where = " ITEM_TYPE = '$item_type'";
        }

        if (!empty($item_type) && !empty($service_unit)) {
            $where = " serviceunit_no_fk = $service_unit and ITEM_TYPE = '$item_type'";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $where = "item_type = 'MED'";

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
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),
            array('db' => 'item_no_pk', 'dt' => 9),
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

    public function medItem()
    {
        //$item_type = $this->getLookupListByCode('ITEMTYPE');
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();

        return Template::loadview("admin.settings.medicine.item_list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
        ]);
    }


    //Pharmaci Item


    public function pharmacyindex()
    {
        //$item_type = $this->getLookupListByCode('ITEMTYPE');
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $supplier_data = DB::table('inv_supplier')->select('supplier_no_pk','supplier_name')->where('status',1)->get();

        return Template::loadview("admin.settings.item.pharmacy_item_list", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
            'supplier_data' => $supplier_data,
        ]);
    }

    public function searchPharmacyitemList(Request $request)
    {
        // dd("ppp");
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;

        $table = 'SERVICE_ITEM_LIST_VW';

        // Table's primary key
        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit";
        }


        if (!empty($item_type) && empty($service_unit)) {
            $where = " itemtype_no_fk = '$item_type'";
        }

        if (!empty($item_type) && !empty($service_unit)) {
            $where = " serviceunit_no_fk = $service_unit and ITEM_TYPE = '$item_type'";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id' ";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where = "au_entry_hospital_pk_no = $hospital_id and item_type = 'MED'";
        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where .= "and item_type = 'MED'";
        }

        $columns = array(
            array('db' => 'sl', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),
            array('db' => 'item_no_pk', 'dt' => 9),
        );

        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function pharmacyitemTypeSearch(Request $request)
    {
        $item_type = $request->item_type;
        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_pk = $item_type" : "";

        $columns = array(
            'sl',
            'parent_type_name',
            'item_name',
            'sl_no',
            'default_discount',
            'acc_ledger_no_fk',
            'acc_par_itemtype_no_fk',
            'type_auto_con_flag',
            'status',
            'itemtype_no_pk',
        );

        $sql = "select * from ITEM_TYPE_VW $sql_cond";
        //        dd($sql);
        $order_by_column = "itemtype_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function pharmacyitemListPrint(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $supplier = $request->supplier;

        $sql_cond = "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($item_type != "") ? " $clause si.item_type = '$item_type' " : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($service_unit != "") ? " $clause si.serviceunit_no_fk = $service_unit " : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($supplier != "") ? " $clause si.manufacturer_no_fk = $supplier " : "";

        $sql = DB::select(DB::raw("SELECT '' as sl,si.item_code, si.item_name, si.item_short_name, si.generic_no_fk, si.itemtype_no_fk, si.item_type, si.serviceunit_no_fk, su.serviceunit_name, si.uom_no_fk, si.manufacturer_no_fk, si.sales_price, inv_sup.supplier_name, item_sub1cat_lookupdata_no_fk,
        item_sub2cat_lookupdata_no_fk,
        item_subcat_lookupdata_no_fk,
        si.purchase_price,
        item_cat_lookupdata_no_fk, si.vat_percent,si.item_no_pk from sysc_serviceitem si left join
        sysc_lookupdata sl on sl.lookupdata_no_pk = si.generic_no_fk left join
        sysc_itemtype it on it.itemtype_no_pk = si.itemtype_no_fk left join
        sysc_serviceunit su on su.serviceunit_no_pk = si.serviceunit_no_fk left join
        inv_supplier inv_sup on inv_sup.supplier_no_pk = si.manufacturer_no_fk left join
        sysc_lookupdata umo on umo.lookupdata_no_pk = si.uom_no_fk where si.item_type = 'MED'  $sql_cond order by si.item_name asc"));


        if ($request->hdn_report_type == "EXCEL") {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=Item_list.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", "Item Code", "Item Name", "Item Short Name", "Item Type", "Service Unit", "Supplier Name", "Purchase Price","Sales Price");
            $callback = function () use ($columns, $sql) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($sql)) {
                    foreach ($sql as $value) {

                        fputcsv($file, array($c, $value->item_code, $value->item_name, $value->item_short_name, $value->item_type, $value->serviceunit_name, $value->supplier_name, $value->purchase_price, $value->sales_price));
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

            $pdf = PDF::loadView("admin.settings.item.item_list_print", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details ' => $po_hospital_details ]);
            return $pdf->download('item-list-report.pdf');
        }
    }


    public function create_quick_pharmacyitem_form()
    {
        $page_type = "quick";
        //        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->get();
        // $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $uom = $this->getLookupListByCode("UOM");
        $pack_type = $this->getLookupListByCode("PACKTYPE");
        $genaric_name = $this->getLookupListByCode("ITEMTYPE");
        $item_cat_data = $this->getLookupListByCode("ITEMCAT");
        $item_cat_data = $this->getLookupListByCode("ECITEMCAT");

        $item_cat_data_sub = $this->getLookupListByCode("ITEMCATSUB");
        $item_cat_sub_data_1 = $this->getLookupListByCode("ITEMCATSUB1");
        $item_cat_sub_data_2 = $this->getLookupListByCode("ITEMCATSUB2");

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


        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->get();
        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        //dd($service_unit);
        //dd($item_type);

        return Template::loadview("admin.settings.item.create_pharmacyitem_form_elements", [
            'item_type' => $item_type,
            'pack_type' => $pack_type,
            'service_unit' => $service_unit,
            'uom' => $uom,
            'genaric_name' => $genaric_name,
            'item_cat_data' => $item_cat_data,
            'item_cat_data_sub' => $item_cat_data_sub,
            'item_cat_sub_data_1' => $item_cat_sub_data_1,
            'item_cat_sub_data_2' => $item_cat_sub_data_2,
            'page_type' => $page_type,
            'suppiler_arr' => $suppiler_arr,
            'main_store_list' => $main_store_list,
        ]);
    }

    public function searchpharmacyitem(Request $request)
    {
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $supplier = $request->supplier;
        // dd($service_unit);
        $supplier = $request->supplier;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $table = 'SERVICE_ITEM_LIST_VW';

        // Table's primary key
        $primaryKey = 'item_no_pk';
        $where = "au_entry_hospital_pk_no = $hospital_id and item_type = 'MED' and status = 1";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($item_type != "") ? " $clause itemtype_no_fk=$item_type" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($supplier != "") ? " $clause manufacturer_no_fk=$supplier" : "";
        $columns = array(
            array('db' => 'sl', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),
            array('db' => 'item_no_pk', 'dt' => 9),
        );

        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function pharmacyStockindex()
    {
        //$item_type = $this->getLookupListByCode('ITEMTYPE');
        if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE') {
            $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        } else {
            $item_type = $this->getLookupListByCode("1018");
        }


        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();

        return Template::loadview("admin.settings.item.pharmacy_stock_item", [
            'item_type' => $item_type,
            'service_unit' => $service_unit,
        ]);
    }

    public function searchPharmacyStockItemList(Request $request)
    {
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        // dd('ok');

        $table = 'PHR_SERVICEITEM_VW';

        // Table's primary key
        $primaryKey = 'item_no_pk';

        $where = "";
        if (!empty($service_unit) && empty($item_type)) {
            $where = " serviceunit_no_fk = $service_unit";
        }

        if (!empty($item_type) && empty($service_unit)) {
            $where = " itemtype_no_fk = '$item_type'";
        }

        if (!empty($item_type) && !empty($service_unit)) {
            $where = " serviceunit_no_fk = $service_unit and ITEM_TYPE = '$item_type'";
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id' ";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();
        $where = "au_entry_hospital_pk_no = $hospital_id and item_type = 'MED'";
        if (strtoupper($hospitalCode->hospital_code) == 'MCARE') {
            $where .= "and item_type = 'MED'";
        }

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),

            array('db' => 'expensive_ind', 'dt' => 9),
            array('db' => 'freezing_ind', 'dt' => 10),
            array('db' => 'slow_moving_ind', 'dt' => 11),
            array('db' => 'narcoticdrug_ind', 'dt' => 12),

            array('db' => 'item_no_pk', 'dt' => 13),
        );

        if (!empty($where)) {
            //dd('ok');
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            //  dd('no');
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }


    public function searchpharmacyItemStock(Request $request)
    {

        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $expensive = $request->expensive;
        $slow_mobing = $request->slow_mobing;
        $narcoting = $request->narcoting;
        $freezing = $request->freezing;

        $table = 'PHR_SERVICEITEM_VW';
        // Table's primary key
        $primaryKey = 'item_no_pk';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "";
        if (!empty($freezing)) {
            $where = " freezing_ind = '$freezing'";
        }
        if (!empty($slow_mobing)) {
            $where = " slow_moving_ind = '$slow_mobing'";
        }
        if (!empty($narcoting)) {
            $where = " narcoticdrug_ind = '$narcoting'";
        }
        if (!empty($expensive_ind)) {
            $where = " expensive_ind = '$expensive'";
        }
        if (!empty($item_type)) {
            $where = " itemtype_no_fk = $item_type and au_entry_hospital_pk_no = $hospital_id  and status = 1 and item_type = 'MED'";
        }

        $sql_cond = "au_entry_hospital_pk_no = $hospital_id";
        $hospitalCode = Company::where('hospital_no_pk', $hospital_id)->first();

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_code', 'dt' => 1),
            array('db' => 'item_name', 'dt' => 2),
            array('db' => 'item_short_name', 'dt' => 3),
            array('db' => 'item_type', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'manufacturer_no_fk', 'dt' => 6),
            array('db' => 'sales_price', 'dt' => 7),
            array('db' => 'vat_percent', 'dt' => 8),

            array('db' => 'expensive_ind', 'dt' => 9),
            array('db' => 'freezing_ind', 'dt' => 10),
            array('db' => 'slow_moving_ind', 'dt' => 11),
            array('db' => 'narcoticdrug_ind', 'dt' => 12),

            array('db' => 'item_no_pk', 'dt' => 13),
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
    public function pharmacyitemListPrintStock(Request $request)
    {
        //  dd($request->all());
        $item_type = $request->item_type;
        $service_unit = $request->service_unit;
        $expensive = $request->expensive;
        $slow_mobing = $request->slow_mobing;
        $narcoting = $request->narcoting;
        $freezing = $request->freezing;
        $ind_name = "";
        if (!empty($request->expensive)) {
            $ind_name = 'Expensive';
        } elseif (!empty($request->slow_mobing)) {
            if ($request->slow_mobing == 1) {
                $ind_name = 'Slow';
            } else {
                $ind_name = 'Fast';
            }

            // $ind_name = "Slow Moving";
        } elseif (!empty($request->narcoting)) {
            $ind_name = 'Narcoting';
        } elseif (!empty($request->freezing)) {
            $ind_name = 'Freezing';
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($expensive != "") ? " $clause  expensive_ind = $expensive" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($slow_mobing != "") ? " $clause  slow_moving_ind  = $slow_mobing" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($narcoting != "") ? " $clause  narcoticdrug_ind = $narcoting" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($freezing != "") ? " $clause  freezing_ind = $freezing" : "";

        $sql = DB::select(DB::raw("select * from PHR_SERVICEITEM_VW $sql_cond"));

        if ($request->hdn_report_type == "EXCEL") {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=Pharmacy_item_stock_list.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );
            $columns = array("SL", "Item Code", "Item Name", "Item Type", "Price", "Vat(%)");
            $callback = function () use ($columns, $sql) {
                $c = 1;
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                if (!empty($sql)) {
                    foreach ($sql as $value) {

                        fputcsv($file, array($c, $value->item_code, $value->item_name,  $value->item_type, $value->sales_price, $value->vat_percent));
                        $c++;
                    }
                }

                fclose($file);
            };
            return Response::stream($callback, 200, $headers);
        } else {
            $title = "item_stock_list";
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $pdf = PDF::loadView("admin.settings.item.pharmacy_stock_list_pdf", ['data' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, "ind_name" => $ind_name]);
            return $pdf->download('item-list-report.pdf');
        }
    }




    // Get User item

    public function itemPrevilize()
    {
        return Template::loadview("admin.settings.item.user_wise_item_setup");
    }

    public function getAllUserItemPrevilegeSetup(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'user_fullname',
            'serviceunit_name',
            'room_name',
            'lookupmap_no_pk'
        );

        $sql = "SELECT '' as sl, wsec_user.user_fullname,sysc_serviceunit.SERVICEUNIT_NAME, sysc_room.room_name, sysc_lookupmap.lookupmap_no_pk, rownum rownumber, sysc_lookupmap.au_update_at,sysc_lookupmap.au_entry_at from sysc_lookupmap LEFT JOIN wsec_user ON wsec_user.user_no_pk = sysc_lookupmap.user_no_fk LEFT JOIN
         sysc_room ON sysc_room.room_no_pk = sysc_lookupmap.room_no_fk LEFT JOIN sysc_serviceunit ON sysc_serviceunit.SERVICEUNIT_NO_PK = sysc_lookupmap.su_no_fk where sysc_lookupmap.au_entry_hospital_no_fk = $ses_hospital_id";
        $order_by_column = "sysc_lookupmap.lookupmap_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }


    public function userItemSetupPopup()
    {
        $user_name = DB::table("wsec_user")->select('user_no_pk', 'user_fullname')->where('status', '1')->get();
        $department_name = DB::table('sysc_serviceunit')->where('status', '1')->get();
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        return Template::loadview("admin.settings.item.user_item_setup_popup", ["user_name" => $user_name, "department_name" => $department_name, "item_type" => $item_type]);
    }


    public function storeItemPrevilize(LookUpMapRequest $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        $lookup_id = $this->getLookupIDByCode("USERROOM");
        DB::beginTransaction();
        try {
            $data = [
                'user_no_fk' => $request->user_no_fk,
                'su_no_fk' => $request->su_no_fk,
                'room_no_fk' => $request->room_no_fk,
                'lookup_no_fk' => $lookup_id,
                'status' => 1,
                'au_entry_hospital_no_fk' => $ses_hospital_id,

            ];

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model2->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
            }




            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }

    public function billingItemType()
    {
        return Template::loadview("admin.settings.item.billing_item_type_list");
    }

    public function createBillingItemType()
    {
        return Template::loadview("admin.settings.item.create_billing_item_type");
    }

    public function storeBillingItemType(Request $request)
    {
        //return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $sequence = DB::getsequence();
            $workflow_no_pk_seq = $sequence->nextvalue('workflow_no_pk_seq');
            $data = [
                'workflow_code' => $request->item_type_code,
                'workflow_name' => $request->item_type_name,
                'workflow_desc' => $request->item_type_desc,
                'status' => $request->item_type_status,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['workflow_no_pk'] = $workflow_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                $data['au_entry_at'] = Date('Y-m-d');
                $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                DB::table('sysc_itemtype_workflow')->insert($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_at'] = Date('Y-m-d');
                $data['au_update_by'] = $auth_id;
                DB::table('sysc_itemtype_workflow')->where('workflow_no_pk', $id)->update($data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function editBillingItemType($id)
    {

        $data = DB::table('sysc_itemtype_workflow')->select('workflow_no_pk', 'workflow_code', 'workflow_name', 'workflow_desc', 'status')->where('workflow_no_pk', $id)->first();

        return Template::loadview("admin.settings.item.create_billing_item_type", ['itemTypeData' => $data]);
    }

    public function getAllItemType(Request $request)
    {
        $hospital_id = session::get('user.ses_hospital_no_pk');
        $sql_cond = '';
        $where = '';
        $table = 'sysc_itemtype_workflow';
        // table's primary key
        $primaryKey = 'workflow_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'workflow_code', 'dt' => 1),
            array('db' => 'workflow_name', 'dt' => 2),
            array('db' => 'workflow_desc',  'dt' => 3),
            array('db' => 'workflow_no_pk',  'dt' => 4)

        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    // for ewmch Prescription
    public function getItemWithStockPrescription()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        // dd($item_type);
        return $this->getItemListWithStockAutoCompletePrescription($keyword, $item_type);
    }
    public function getItemWithStockPrescriptionStoreWise()
    {
        $keyword = strtoupper(strval($_POST['query']));
        $item_type = isset($_POST['item_type']) ? strtoupper(strval($_POST['item_type'])) : "";
        $store_id = $_POST['store_id'];
        return $this->getItemListWithStockAutoCompletePrescriptionStoreWise($keyword, $item_type, $store_id);
    }


    public function uomCreate()
    {
        return Template::loadView("admin.settings.item.uomCreate");
    }
}
