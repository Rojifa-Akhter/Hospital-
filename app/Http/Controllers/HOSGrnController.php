<?php

namespace App\Http\Controllers;

use App;
use PDO;
use \PDF;
use DateTime;
use App\Models\Item;
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
use Illuminate\Support\Facades\DB;
use App\Models\UomLookup as Lookup;
use Illuminate\Support\Facades\Auth;
use App\Models\DefaultAttributeValue;
use App\Http\Requests\ItemTypeRequest;
use App\Http\Requests\otherItemRequest;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RadiologyItemRequest;
use App\Repositories\BaseRepository as Repo;
use App\Http\Requests\PathologyItemSetupRequest;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FileResponse;
use PhpParser\Node\Stmt\TryCatch;
use stdClass;

class HOSGrnController extends Controller
{
    use LookupData, ItemData, UtilitiesTrait;

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

    public function index($po_id = "")
    {
        //PKG_V1_INVENTORY_ALL.PRC_ITEMRECEIVE_MS
        //inv_phr_itemreceivemst_grn_vw, INV_REQUISITIONMST_VW and inv_purchaseorder_mst_vw
        //Batch
        //data[0][i].item_no_pk +'_' +data[0][i].entry_qty + '_' + data[0][i].item_rate + '_' +uom_no_fk + '_' + data[0][i].pr_uom_conversion_qty

        $grn = $this->getLookupListByCode("GRNTYPE");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->orderBy('supplier_name', 'asc')->get();
        //$main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $grn_id = '';
        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        return Template::loadView("admin.uhl.inventory.item-receive-grn", [
            'grn_list' => $grn,
            'suppiler_arr' => $suppiler_arr,
            'main_store_list' => $main_store_list,
            'po_id' => $po_id,
            'grn_id' => $grn_id
        ]);
    }

    public function prListPopup(Request $request)
    {
        $date = new DateTime();
        $date->modify('-30 days');
        $from_date = $date->format('Y-m-d');
        $to_date = date('Y-m-d');


        // $pr_data = DB::table('inv_requisition_po_itm_vw')
        // ->leftjoin('PHR_ITEMRECEIVEDTL', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL.INV_REQUISITIONDTL_PO_NO_FK')
        // ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
        // ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status',  'inv_requisition_po_itm_vw.inv_requisition_po_no_pk as test', 'inv_requisition_po_itm_vw.from_store', 'inv_requisition_po_itm_vw.req_quantity', DB::raw('sum(phr_itemreceivedtl.item_qty) as item_qty'))
        // ->where('inv_requisition_po_itm_vw.po_ind', '=', null)
        // ->where('inv_requisition_po_itm_vw.app_status', 1)
        // // ->where('inv_requisition_po_itm_vw.INV_REQUISITION_PO_NO_PK', 2141)
        // ->whereBetween('inv_requisition_po_itm_vw.req_at', [$from_date, $to_date])
        // ->orderBy('inv_requisition_po_no_pk', 'desc')
        // ->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status',  'test', 'inv_requisition_po_itm_vw.from_store', 'inv_requisition_po_itm_vw.req_quantity')



        // ->where(function ($query) {
        //     $query->whereRaw('CAST(inv_requisition_po_itm_vw.req_quantity AS NUMBER) != CAST(item_qty AS NUMBER)')
        //         ->orWhere('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null);
        // })
        // ->get();


        $pr_data = DB::table('inv_requisition_po_itm_vw')
            ->leftjoin('PHR_ITEMRECEIVEDTL', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL.INV_REQUISITIONDTL_PO_NO_FK')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status',  'inv_requisition_po_itm_vw.inv_requisition_po_no_pk as test', 'inv_requisition_po_itm_vw.from_store', DB::raw('sum(phr_itemreceivedtl.item_qty) as item_qty'))
            ->where('inv_requisition_po_itm_vw.po_ind', '=', null)
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->whereBetween('inv_requisition_po_itm_vw.req_at', [$from_date, $to_date])
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status',  'test', 'inv_requisition_po_itm_vw.from_store')

            ->where(function ($query) {
                $query->whereRaw('CAST(inv_requisition_po_itm_vw.req_quantity AS NUMBER) != CAST(item_qty AS NUMBER)')
                    ->orWhere('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null);
            })
            ->get();

        $main_store_list = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();


        return Template::loadView(
            "admin.uhl.inventory.pr-list-popup",
            ['pr_data' => $pr_data, 'main_store_list' => $main_store_list]
        );
    }


    public function searchPRListforPopup(Request $request)
    {



        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.from_store')
            ->where('inv_requisition_po_itm_vw.po_ind', '=', null)->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', '=', null)->where('inv_requisition_po_itm_vw.app_status', 1);



        if (!empty($request->date_from) &&  !empty($request->date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime('+1 day', strtotime($request->date_to)))]);
        } elseif (!empty($request->date_from) &&  !empty($request->date_to) && !empty($request->store)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime('+1 day', strtotime($request->date_to)))])
                ->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->store);
        } elseif (!empty($request->date_from)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->date_from)));
        } elseif (!empty($request->date_to)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->date_to)));
        }

        if ($request->store != "") {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->store);
        }
        $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.from_store');

        $pr_data_list = $query->orderBy('inv_requisition_po_no_pk', 'desc')->get();
        // return Template::loadView(
        //     "admin.uhl.inventory.pr-list-popup-search",
        //     ['pr_data_list' => $pr_data_list]
        // );

        return response()->json(['pr_data_list' => $pr_data_list], 200);
    }



    public function grnFromList($grn_id = "")
    {
        //PKG_V1_INVENTORY_ALL.PRC_ITEMRECEIVE_MS
        //inv_phr_itemreceivemst_grn_vw, INV_REQUISITIONMST_VW and inv_purchaseorder_mst_vw
        //Batch
        //data[0][i].item_no_pk +'_' +data[0][i].entry_qty + '_' + data[0][i].item_rate + '_' +uom_no_fk + '_' + data[0][i].pr_uom_conversion_qty

        $grn = $this->getLookupListByCode("GRNTYPE");
        $suppiler_arr = DB::table("inv_supplier")->select("supplier_name", "supplier_no_pk")->where('status', 1)->orderBy('supplier_name', 'asc')->get();
        //$main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $po_id = '';
        $pr_id = '';
        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $grn_mst = DB::table('phr_itemreceivemst')->select('phr_itemreceivemst.*', 'hrms_personnel.full_name')->leftjoin('hrms_personnel', 'phr_itemreceivemst.received_by_person_no_fk', '=', 'hrms_personnel.person_no_pk')->where('itemreceive_no_pk', $grn_id)->first();

        return Template::loadView("admin.uhl.inventory.item-receive-grn", [
            'grn_list' => $grn,
            'suppiler_arr' => $suppiler_arr,
            'main_store_list' => $main_store_list,
            'po_id' => $po_id,
            'grn_id' => $grn_id,
            'grn_mst' => $grn_mst,
        ]);
    }


    public function storeReceive(Request $request)
    {
        $validationArr = [
            'main_store_id' => 'required',
            'supplier_name' => 'required',
            'challan_date' => 'required',
            'grn_type' => 'required',
            'grn_date'    => 'required',
            // 'invoice_number'    => 'required',
            //'bill_date'    => 'required',
            //'bill_amount'    => 'required',
            //'received_by'    => 'required',
            //'inspected_by'    => 'required',

        ];
        if ($request->type == 'chalan') {
            $validationArr['challan_no'] = 'required';
        }
        $validator = Validator::make($request->all(), $validationArr);

        $validator->validate();
        DB::beginTransaction();

        try {


            $main_store_module = ServiceUnit::where('main_store_ind', 1)->where('serviceunit_no_pk', $request->main_store_id)->first();

            $item_id = [];
            $item_sl = [];
            $batch_no = [];
            $exp_date = [];
            $rcv_qty = [];
            $free_qty = [];
            $purchase_price = [];
            $sales_price = [];
            $cost_price = [];
            $purchase_uom_no_pk = [];
            $purchase_uom_name = [];
            $conversion_qty = [];
            $batch_item_qty = [];
            $pvmsno = [];
            $item_remarks = [];
            $in_vat_percent_itm = [];
            $in_vat_amount_itm = [];
            $in_discount_percent_itm = [];
            $in_discount_amount_itm = [];
            $in_purchaseorderdtl_no_pk = [];
            $in_inv_requisitiondtl_no_pk = [];
            $in_temperature = [];
            $in_store_room_no_pk = [];

            $null = null;
            $zero = 0;

            $out_itemreceive_no_pk = $out_itemreceive_uid = $out_error = 0;
            // dd($request->all());
            // dd($request->request_arr);
            foreach (json_decode($request->request_arr) as $key => $item_info) {
                // dd($item_info,$request->all());
                $item_exp_date = isset($item_info->exp_date) ? strval(date('dmY', strtotime($item_info->exp_date))) : ''; //strval(date('dmY'));
                $item_sl[$key] = $key; // $item_info->sl;
                $item_id[$key] =  intval($item_info->item_id);
                $batch_no[$key] = isset($item_info->batch_no) ? $item_info->batch_no : $null;
                $exp_date[$key] = $item_exp_date; //isset( $item_info->exp_date)? date('dmY',strtotime($item_info->exp_date)):date('dmY');
                $rcv_qty[$key] =  isset($item_info->batch_item_qty) ? floatval($item_info->batch_item_qty) : floatval($item_info->rcv_qty);
                $free_qty[$key] =  isset($item_info->free_qty) ? floatval($item_info->free_qty) : 0;
                $purchase_price[$key] = isset($item_info->purchase_price) ? floatval($item_info->purchase_price) : 0;
                $sales_price[$key] = isset($item_info->sales_price) ? floatval($item_info->sales_price) : 0;
                $cost_price[$key] = isset($item_info->cost_price) ? floatval($item_info->cost_price) : 0;
                $purchase_uom_no_pk[$key] =  intval($item_info->purchase_uom_no_pk);
                $purchase_uom_name[$key] = $item_info->purchase_uom_name;
                $conversion_qty[$key] = isset($item_info->conversion_qty) ? floatval($item_info->conversion_qty) : 1;
                $batch_item_qty[$key] = isset($item_info->batch_item_qty) ? floatval($item_info->batch_item_qty) : floatval($item_info->rcv_qty);
                $empty[$key] = 1;
                $pvmsno[$key] = $null;
                $item_remarks[$key] = '';
                $in_vat_percent_itm[$key] = $request->grn_vat_discount_percent;
                $in_vat_amount_itm[$key] = $request->grn_vat_discount_amount;
                $in_discount_percent_itm[$key] = $request->grn_discount_percent;
                $in_discount_amount_itm[$key] = $request->grn_discount_amount;
                $in_purchaseorderdtl_no_pk[$key] = isset($item_info->purchaseorderdtl_no_pk) ? $item_info->purchaseorderdtl_no_pk : 0;
                $in_purchaseorder_no_pk[$key] = isset($item_info->purchaseorder_no_fk) ? $item_info->purchaseorder_no_fk : 0;
                $in_inv_requisitiondtl_no_pk[$key] = 0;
                $in_temperature[$key] = isset($item_info->temperature) ? $item_info->temperature : '';
                $in_store_room_no_pk[$key] = isset($item_info->item_location) ? $item_info->item_location : 0;
                $inv_requisitiondtl_po_no_fk[$key] = isset($item_info->prdtl_no_pk) ? $item_info->prdtl_no_pk : 0;
            }

            $numelems = 500;
            $in_au_entry_by = Auth::id();

            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = intval(Session::get('user.ses_hospital_no_pk'));
            $grn_type = $request->grn_type;
            $grn_no = $request->grn_no;
            $grn_date = $request->grn_date;
            $requisition_po_no_pk = $request->pr_no;
            $supplier_name = $request->supplier_name;
            $po_no = isset($request->po_no) ? intval($request->po_no) : 0;
            $po_date = $request->po_date;
            $po_amount = $request->po_amount;
            $delivery_order_no = $request->delivery_order_no;
            $challan_date = date("Y-m-d", strtotime($request->challan_date));

            $grn_date = date("Y-m-d", strtotime($request->grn_date));

            $invoice_number = $request->invoice_number;
            $bill_date = $request->bill_date;
            $bill_amount = $request->bill_amount;
            $gate_entry =  isset($request->gate_entry) ? $request->gate_entry : 0;
            $received_by = isset($request->received_by) ? intval($request->received_by) : 0;

            $inspected_by = isset($request->inspected_by) ? intval($request->inspected_by) : 0;
            //$temperature = $request->temperature;
            $remarks = $request->remarks;
            $main_store_id = $request->main_store_id;
            $subtotal_amount = $request->subtotal_amount;
            $bill_grn_charge = $request->bill_grn_charge;
            $round_off_amt = $request->round_off_amt;
            $grn_subtotal_amount = $request->grn_subtotal_amount;
            $grn_currency = $request->grn_currency;
            $grn_curr_rate = $request->grn_curr_rate;
            $grn_amount = $request->grn_amount;
            $grn_discount_radio = $request->grn_discount_radio;
            $grn_discount_percent = isset($request->grn_discount_percent) ? $request->grn_discount_percent : 0;
            $grn_discount_amount = isset($request->grn_discount_amount) ? (int) $request->grn_discount_amount : 0;
            $grn_vat_discount_percent = isset($request->grn_vat_discount_percent) ? $request->grn_vat_discount_percent : 0;
            $grn_vat_discount_amount = isset($request->grn_vat_discount_amount) ? (int) $request->grn_vat_discount_amount : 0;
            $total_exclusive = $request->total_exclusive;

            $main_store_module = isset($main_store_module->main_store_module_no_fk) ? $main_store_module->main_store_module_no_fk : 0;



            //dd( $main_store_module,  $grn_discount_percent,$grn_discount_amount);
            $image_name1 = "";
            if ($request->hasFile('file')) {
                $files = $request->file('file');
                $image_name1 = "item_photo1_" . str_replace(" ", "_", $request->file)  . "." . $files->getClientOriginalExtension();
                //$data['item_photo_1'] = $image_name1;
                $image_name1 = "grn_bill_invoice_" . str_replace(" ", "_", $request->grn_no);
            }

            if ($request->hasFile('file')) {
                $this->uploadImages($files,  $image_name1, 'images/uploads/grn_bill_images/', 'images/uploads/grn_bill_images/thumb/');
            }
            //uploadImages($files, $image_name, $path, $thumb_path = "")

            $rgn_no = $request->grn_no;
            $save_option = '';
            if (!empty($grn_no)) {
                $save_options = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $rgn_no)->first();
                $save_option = $save_options->rcv_save_option;
            }
            $rcv_save_option = $save_option == "DRAFT" ? 'POST' : 'DRAFT';

            $pdo = DB::getPdo();

            $receive_items = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemreceive_ms(
                            :in_itemreceive_no_pk,
                            :in_grn_type,
                            :in_grn_date,
                            :in_inv_requisition_po_no_pk,
                            :in_delivery_order,
                            :in_challan_no,
                            :in_challan_date,
                            :in_gate_entry_number,
                            :in_fiscal_year,
                            :in_year_quarter,
                            :in_received_by_person_no_fk,
                            :in_inspected_by_person_no_fk,
                            :in_store_su_no_fk,
                            :in_demand_no_fk,
                            :in_supplier_no_fk,
                            :in_vat_percent,
                            :in_vat_amount,
                            :in_discount_percent,
                            :in_discount_amount,
                            :in_module_no_fk,
                            :in_requisition_no_fk,
                            :in_requisition_code,
                            :in_purchaseorder_no_pk,
                            :in_notes,
                            :in_bill_image,
                            :in_return_amt,
                            :in_return_note,
                            :in_rcv_save_option,
                            :in_a_item_no_fk,
                            :in_item_batch_fk,
                            :in_item_expiry_dt,
                            :in_a_item_pvmsno,
                            :in_a_item_qty,
                            :in_a_item_uom,
                            :in_a_freeitem_qty,
                            :in_a_freeitem_uom,
                            :in_a_item_price ,
                            :in_a_item_cost_price ,
                            :in_a_entry_serial_dtl ,
                            :in_item_remarks,
                            :in_pr_uom_no_fk ,
                            :in_pr_uom_conversion_qty ,
                            :in_pr_uom_tradeprice ,
                            :in_vat_percent_itm,
                            :in_vat_amount_itm,
                            :in_discount_percent_itm,
                            :in_discount_amount_itm,
                            :in_purchaseorderdtl_no_pk,
                            :in_inv_requisitiondtl_no_pk,
                            :in_temperature,
                            :in_store_room_no_pk,
                            :in_inv_requisitiondtl_po_no_fk,
                            :in_au_entry_by,
                            :in_au_entry_session,
                            :in_au_entry_hospital_no_fk,
                            :out_itemreceive_no_pk,
                            :out_itemreceive_uid,
                            :out_error
                    ); end;");

            $receive_items->bindparam('in_itemreceive_no_pk', $rgn_no);
            $receive_items->bindparam('in_grn_type', $grn_type);
            $receive_items->bindparam('in_grn_date', $grn_date);
            $receive_items->bindparam('in_inv_requisition_po_no_pk', $requisition_po_no_pk);
            $receive_items->bindparam('in_delivery_order', $delivery_order_no);
            $receive_items->bindparam('in_challan_no', $invoice_number);
            $receive_items->bindparam('in_challan_date', $challan_date);
            $receive_items->bindparam('in_gate_entry_number', $gate_entry);
            $receive_items->bindparam('in_fiscal_year', $zero);
            $receive_items->bindparam('in_year_quarter', $null);
            $receive_items->bindparam('in_received_by_person_no_fk', $received_by);
            $receive_items->bindparam('in_inspected_by_person_no_fk', $inspected_by);
            $receive_items->bindparam('in_store_su_no_fk', $main_store_id);
            $receive_items->bindparam('in_demand_no_fk', $po_no);
            $receive_items->bindparam('in_supplier_no_fk', $supplier_name);
            $receive_items->bindparam('in_vat_percent', $grn_vat_discount_percent);
            $receive_items->bindparam('in_vat_amount', $grn_vat_discount_amount);
            $receive_items->bindparam('in_discount_percent', $grn_discount_percent);
            $receive_items->bindparam('in_discount_amount', $grn_discount_amount);
            $receive_items->bindparam('in_module_no_fk', $main_store_module);
            $receive_items->bindparam('in_requisition_no_fk', $zero);
            $receive_items->bindparam('in_requisition_code', $null);
            $receive_items->bindparam('in_purchaseorder_no_pk', $po_no);
            $receive_items->bindparam('in_notes', $remarks);
            $receive_items->bindparam('in_bill_image', $image_name1);
            $receive_items->bindparam('in_return_amt', $zero);
            $receive_items->bindparam('in_return_note', $null);
            $receive_items->bindparam('in_rcv_save_option', $rcv_save_option);
            $receive_items->bindArray('in_a_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_pvmsno', $pvmsno, count($pvmsno), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $rcv_qty, count($rcv_qty), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_qty', $free_qty, count($free_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_price', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_cost_price', $cost_price, count($cost_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_sl, count($item_sl), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_remarks', $item_remarks, count($item_remarks), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_pr_uom_no_fk', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_conversion_qty', $conversion_qty, count($conversion_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_tradeprice', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_temperature', $in_temperature, count($in_temperature), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_store_room_no_pk', $in_store_room_no_pk, count($in_store_room_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_po_no_fk', $inv_requisitiondtl_po_no_fk, count($inv_requisitiondtl_po_no_fk), $numelems, SQLT_INT);
            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindParam('out_itemreceive_no_pk', $out_itemreceive_no_pk, PDO::PARAM_INT);
            $receive_items->bindParam('out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            $receive_items->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($receive_items);
            $receive_items->execute();
            //dd(1, $receive_items);
            DB::commit();

            $this->message = ['msg' => 'Data saved successfully. <br><strong>Receive No = ' . $out_itemreceive_no_pk . ',Transaction No = ' . $out_itemreceive_uid . '</strong>', 'title' => 'Success', 'no' => $out_error];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function po_info(Request $request)
    {
        $purchase_order_id = $request->po_no;

        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();

        $room_arr = [];

        foreach ($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }

        // $po_child_details_info = DB::select(DB::raw("SELECT *

        // FROM inv_purchaseorder_chd poc

        // LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        // LEFT JOIN inv_purchaseorder_mst ps on ps.purchaseorder_no_pk = poc.PURCHASEORDER_NO_FK

        // WHERE poc.purchaseorder_no_fk = $purchase_order_id
        // AND ps.po_save_option in('ISSUE')
        // order By poc.purchaseorderdtl_no_pk"));

        // $po_child_details_info = DB::select(DB::raw("SELECT *
        //     FROM INV_PURCHASEORDER_CHD POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
        //     on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK
        //     JOIN INV_PURCHASEORDER_MST ps
        //     ON PS.PURCHASEORDER_NO_PK = POC.PURCHASEORDER_NO_FK
        //     LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,PO_NO,VAT_PERCENT_ITM,VAT_AMOUNT_ITM
        //     from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
        //     WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
        //     --and po_no=2944
        //     GROUP BY ITEM_NO_FK,PO_NO,VAT_PERCENT_ITM,VAT_AMOUNT_ITM) rec
        //     ON REC.PO_NO=PS.PURCHASEORDER_NO_PK
        //     and REC.item_no_fk=POC.ITEM_NO_FK
        //     WHERE POC.PURCHASEORDER_NO_FK = $purchase_order_id
        //     AND PS.PO_SAVE_OPTION IN('ISSUE') "));

        $po_child_details_info = $purchase_order_id == "" ? [] : DB::select(DB::raw("SELECT poc.item_no_fk,item_name,uom_no_fk,uom_name,item.pr_uom_conversion_qty,item_uom_name_2nd,uom_no_fk_2nd,uom_name,
        uom_no_fk_2nd_conv_ratio,uom_no_fk_3rd,uom_no_fk_3rd_conv_ratio,item_uom_name_3rd,uom_no_fk_4th,
        uom_no_fk_4th_conv_ratio,item_uom_name_4th,purchase_price,item.pr_uom_conversion_qty,POC.item_rate,entry_qty,rcv_qty,store_room_no_pk,
        sales_price,uom,ps.supplier_no_fk,ps.purchase_date,item.mainstore_su_no_fk,ps.discount_percent,ps.vat_percent as vat_percent_itm,poc.purchaseorderdtl_no_pk
        FROM INV_PURCHASEORDER_CHD POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
        on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK
        JOIN INV_PURCHASEORDER_MST ps
        ON PS.PURCHASEORDER_NO_PK = POC.PURCHASEORDER_NO_FK
        LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,PO_NO,STORE_ROOM_NO_PK,PURCHASEORDERDTL_NO_PK
        from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
        WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
        --and po_no=2944
        GROUP BY ITEM_NO_FK,PO_NO,STORE_ROOM_NO_PK,PURCHASEORDERDTL_NO_PK) rec
        ON REC.PO_NO=PS.PURCHASEORDER_NO_PK
        and REC.item_no_fk=POC.ITEM_NO_FK
        and rec.PURCHASEORDERDTL_NO_PK =
                                POC.PURCHASEORDERDTL_NO_PK
        WHERE POC.PURCHASEORDER_NO_FK  = $purchase_order_id--2931
        AND PS.PO_SAVE_OPTION IN('ISSUE','POST')"));



        return response()->json(['data' => $po_child_details_info, 'room_location' => $room_arr], 200);
    }
    public function pr_info(Request $request)
    {
        $purchase_order_id = $request->po_no;

        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();

        $room_arr = [];

        foreach ($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }


        $po_child_details_info = $purchase_order_id == "" ? [] : DB::select(DB::raw("SELECT poc.item_no_fk,POC.item_name,POC.REQ_UOM,POC.REQ_UOM_NAME uom_name,item.uom_no_fk,item.pr_uom_conversion_qty,ITEM.item_uom_name_2nd,ITEM.uom_no_fk_2nd,uom_name,
                        ITEM.uom_no_fk_2nd_conv_ratio,ITEM.uom_no_fk_3rd,ITEM.uom_no_fk_3rd_conv_ratio,ITEM.item_uom_name_3rd,ITEM.uom_no_fk_4th,
                        ITEM.uom_no_fk_4th_conv_ratio,ITEM.item_uom_name_4th,POC.ITEM_PURCHASE_PRICE purchase_price,POC.ITEM_PURCHASE_PRICE item_rate,POC.REQ_QUANTITY entry_qty,nvl(rcv_qty,0) rcv_qty,POC.MAIN_STORE_SU_NO_FK store_room_no_pk,
                        POC.sales_price,POC.SUPPLIER_PK_NO supplier_no_fk,ps.INV_REQUISITION_PO_DATE purchase_date,item.mainstore_su_no_fk,poc.INV_REQUISITIONDTL_PO_NO_PK ,  POC.INV_REQUISITION_PO_NO_PK
                        FROM INV_REQUISITION_PO_ITM_VW POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
                        on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK
                        JOIN INV_REQUISITIONMST_PO ps
                        ON PS.INV_REQUISITION_PO_NO_PK = POC.INV_REQUISITION_PO_NO_PK left JOIN PHR_ITEMRECEIVEDTL_PR_CNT cnt
                        on  cnt.INV_REQUISITIONDTL_PO_NO_FK=POC.INV_REQUISITIONDTL_PO_NO_PK

                        LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,INV_REQUISITION_PO_NO_FK,STORE_ROOM_NO_PK,INV_REQUISITIONDTL_PO_NO_FK
                        from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
                        WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
                        --and po_no=2944
                        GROUP BY ITEM_NO_FK,INV_REQUISITION_PO_NO_FK,STORE_ROOM_NO_PK,INV_REQUISITIONDTL_PO_NO_FK) rec
                        ON rec.INV_REQUISITIONDTL_PO_NO_FK=POC.INV_REQUISITIONDTL_PO_NO_PK
                        -- ON REC.INV_REQUISITION_PO_NO_FK=PS.INV_REQUISITION_PO_NO_PK
                        and REC.item_no_fk=POC.ITEM_NO_FK
                        WHERE POC.INV_REQUISITION_PO_NO_PK = $purchase_order_id
                        AND PS.REQ_PO_SAVE_OPTION IN('POST') and (POC.req_quantity !=NVL(RCV_QTY,0) or  cnt.INV_REQUISITIONDTL_PO_NO_FK is null)
        "));
        // dd(  $po_child_details_info );
        return response()->json(['data' => $po_child_details_info, 'room_location' => $room_arr], 200);
    }

    public function pr_info_html(Request $request)
    {
        $purchase_order_id = $request->po_no;

        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();

        $room_arr = [];


        foreach ($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
        // $item->entry_qty-$item->rcv_qty
        $po_child_details_info = $purchase_order_id == "" ? [] : DB::select(DB::raw("SELECT poc.item_no_fk,POC.item_name,POC.REQ_UOM,POC.REQ_UOM_NAME uom_name,item.uom_no_fk,item.pr_uom_conversion_qty,ITEM.item_uom_name_2nd,ITEM.uom_no_fk_2nd,uom_name,
        ITEM.uom_no_fk_2nd_conv_ratio,ITEM.uom_no_fk_3rd,ITEM.uom_no_fk_3rd_conv_ratio,ITEM.item_uom_name_3rd,ITEM.uom_no_fk_4th,
        ITEM.uom_no_fk_4th_conv_ratio,ITEM.item_uom_name_4th,POC.ITEM_PURCHASE_PRICE purchase_price,POC.ITEM_PURCHASE_PRICE item_rate,POC.REQ_QUANTITY entry_qty,nvl(rcv_qty,0) rcv_qty,POC.MAIN_STORE_SU_NO_FK store_room_no_pk,
        POC.sales_price,POC.SUPPLIER_PK_NO supplier_no_fk,ps.INV_REQUISITION_PO_DATE purchase_date,item.mainstore_su_no_fk,poc.INV_REQUISITIONDTL_PO_NO_PK ,  POC.INV_REQUISITION_PO_NO_PK
        FROM INV_REQUISITION_PO_ITM_VW POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
        on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK left JOIN PHR_ITEMRECEIVEDTL_PR_CNT cnt
        on  cnt.INV_REQUISITIONDTL_PO_NO_FK=POC.INV_REQUISITIONDTL_PO_NO_PK
        JOIN INV_REQUISITIONMST_PO ps
        ON PS.INV_REQUISITION_PO_NO_PK = POC.INV_REQUISITION_PO_NO_PK
        LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,INV_REQUISITION_PO_NO_FK,STORE_ROOM_NO_PK,INV_REQUISITIONDTL_PO_NO_FK
        from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
        WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
        --and po_no=2944
        GROUP BY ITEM_NO_FK,INV_REQUISITION_PO_NO_FK,STORE_ROOM_NO_PK,INV_REQUISITIONDTL_PO_NO_FK) rec
        ON REC.INV_REQUISITIONDTL_PO_NO_FK=POC.INV_REQUISITIONDTL_PO_NO_PK
        -- ON REC.INV_REQUISITION_PO_NO_FK=PS.INV_REQUISITION_PO_NO_PK
        and REC.item_no_fk=POC.ITEM_NO_FK
        WHERE POC.INV_REQUISITION_PO_NO_PK = $purchase_order_id
        AND PS.REQ_PO_SAVE_OPTION IN('POST')  and (POC.req_quantity !=NVL(RCV_QTY,0) or  cnt.INV_REQUISITIONDTL_PO_NO_FK is null)
        "));
        // dd($po_child_details_info);
        return Template::loadView("admin.uhl.inventory.pr_info", [
            'po_child_details_info' =>  $po_child_details_info,
            'room_location' => $room_arr
        ]);
    }


    public function po_info_html(Request $request)
    {
        $purchase_order_id = $request->po_no;

        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();

        $room_arr = [];


        foreach ($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }

        // $po_child_details_info = DB::select(DB::raw("SELECT *

        // FROM inv_purchaseorder_chd poc

        // LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        // LEFT JOIN inv_purchaseorder_mst ps on ps.purchaseorder_no_pk = poc.PURCHASEORDER_NO_FK

        // WHERE poc.purchaseorder_no_fk = $purchase_order_id
        // AND ps.po_save_option in('ISSUE')
        // order By poc.purchaseorderdtl_no_pk"));

        // $po_child_details_info = DB::select(DB::raw("SELECT *
        //     FROM INV_PURCHASEORDER_CHD POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
        //     on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK
        //     JOIN INV_PURCHASEORDER_MST ps
        //     ON PS.PURCHASEORDER_NO_PK = POC.PURCHASEORDER_NO_FK
        //     LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,PO_NO,VAT_PERCENT_ITM,VAT_AMOUNT_ITM
        //     from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
        //     WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
        //     GROUP BY ITEM_NO_FK,PO_NO,VAT_PERCENT_ITM,VAT_AMOUNT_ITM) rec
        //     ON REC.PO_NO=PS.PURCHASEORDER_NO_PK
        //     and REC.item_no_fk=POC.ITEM_NO_FK
        //     WHERE POC.PURCHASEORDER_NO_FK = $purchase_order_id
        //     AND PS.PO_SAVE_OPTION IN('ISSUE') "));

        $po_child_details_info = $purchase_order_id == "" ? [] : DB::select(DB::raw("SELECT poc.item_no_fk,item_name,uom_no_fk,uom_name,item.pr_uom_conversion_qty,item_uom_name_2nd,uom_no_fk_2nd,uom_name,
        uom_no_fk_2nd_conv_ratio,uom_no_fk_3rd,uom_no_fk_3rd_conv_ratio,item_uom_name_3rd,uom_no_fk_4th,
        uom_no_fk_4th_conv_ratio,item_uom_name_4th,purchase_price,item.pr_uom_conversion_qty,POC.item_rate,entry_qty,rcv_qty,store_room_no_pk,
        sales_price,uom,ps.supplier_no_fk,ps.purchase_date,item.mainstore_su_no_fk,ps.discount_percent,ps.vat_percent as vat_percent_itm,poc.purchaseorderdtl_no_pk
        FROM INV_PURCHASEORDER_CHD POC JOIN SYSC_V1_SERVICEITEM_VW ITEM
        on  ITEM.ITEM_NO_PK=POC.ITEM_NO_FK
        JOIN INV_PURCHASEORDER_MST ps
        ON PS.PURCHASEORDER_NO_PK = POC.PURCHASEORDER_NO_FK
        LEFT JOIN (SELECT SUM(ITEM_QTY) RCV_QTY,ITEM_NO_FK,PO_NO,STORE_ROOM_NO_PK,PURCHASEORDERDTL_NO_PK
        from PHR_ITEMRECEIVEMST A, PHR_ITEMRECEIVEDTL B
        WHERE A.ITEMRECEIVE_NO_PK=B.ITEMRECEIVE_NO_FK
        --and po_no=2944
        GROUP BY ITEM_NO_FK,PO_NO,STORE_ROOM_NO_PK,PURCHASEORDERDTL_NO_PK) rec
        ON REC.PO_NO=PS.PURCHASEORDER_NO_PK
        and REC.item_no_fk=POC.ITEM_NO_FK
        and rec.PURCHASEORDERDTL_NO_PK =
                                POC.PURCHASEORDERDTL_NO_PK
        WHERE POC.PURCHASEORDER_NO_FK  = $purchase_order_id--2931
        AND PS.PO_SAVE_OPTION IN('ISSUE','POST')
        "));
        // dd($po_child_details_info);
        return Template::loadView("admin.uhl.inventory.po_info", [
            'po_child_details_info' =>  $po_child_details_info,
            'room_location' => $room_arr
        ]);
    }


    public function saved_grn_info(Request $request)
    {
        $grn_no = $request->grn_no;

        $grn_details_info = DB::select(DB::raw(
            "SELECT
            po.au_entry_at  po_date,
            poc.item_no_fk,
            poc.itemreceive_no_fk,
            poc.purchaseorderdtl_no_pk,
            i.item_name,
            poc.store_room_no_pk,
            i.uom_no_fk,
            i.uom_name,
            poc.uom,
            poc.pr_uom_conversion_qty,
            i.item_uom_name_2nd,
            i.uom_no_fk_2nd,
            i.uom_no_fk_2nd_conv_ratio,
            i.uom_no_fk_3rd,
            i.uom_no_fk_3rd_conv_ratio,
            i.item_uom_name_3rd,
            i.uom_no_fk_4th,
            i.uom_no_fk_4th_conv_ratio,
            i.item_uom_name_4th,
            poc.item_no_fk,
            i.purchase_price,
            poc.trade_price,
            poc.cost_price,
            po.entry_qty,
            i.sales_price,
            poc.store_room_no_pk,
            poc.purchaseorderdtl_no_pk,
            i.mainstore_su_no_fk,
            ps.supplier_no_fk,
            ps.rcv_save_option,
            poc.vat_percent_itm,
            ps.discount_percent,
            ps.challan_no,
            po.purchaseorder_no_fk,
            ps.inv_requisition_po_no_fk,
            ps.receive_type,
            poc.inv_requisitiondtl_po_no_fk,
            sum(poc.freeitem_qty) as freeitem_qty,
            (sum(poc.item_qty) -  sum(poc.freeitem_qty)) as item_qty
        FROM phr_itemreceivedtl poc
        LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        LEFT JOIN phr_itemreceivemst ps on ps.itemreceive_no_pk = poc.itemreceive_no_fk
        LEFT JOIN inv_purchaseorder_chd po on po.purchaseorderdtl_no_pk = poc.purchaseorderdtl_no_pk
        WHERE ps.itemreceive_no_pk = $grn_no
        group by   po.au_entry_at,
            poc.item_no_fk,
            poc.itemreceive_no_fk,
            poc.purchaseorderdtl_no_pk,
            i.item_name,
            poc.store_room_no_pk,
            i.uom_no_fk,
            i.uom_name,
            poc.uom,
            poc.pr_uom_conversion_qty,
            i.item_uom_name_2nd,
            i.uom_no_fk_2nd,
            i.uom_no_fk_2nd_conv_ratio,
            i.uom_no_fk_3rd,
            i.uom_no_fk_3rd_conv_ratio,
            i.item_uom_name_3rd,
            i.uom_no_fk_4th,
            i.uom_no_fk_4th_conv_ratio,
            i.item_uom_name_4th,
            poc.item_no_fk,
            i.purchase_price,
            poc.trade_price,
            poc.cost_price,
            po.entry_qty,
            i.sales_price,
            poc.store_room_no_pk,
            poc.purchaseorderdtl_no_pk,
            i.mainstore_su_no_fk,
            ps.supplier_no_fk,
            ps.rcv_save_option,
            poc.vat_percent_itm,
            ps.discount_percent,
            ps.challan_no,
            po.purchaseorder_no_fk,
            ps.inv_requisition_po_no_fk,
            ps.receive_type,
            poc.inv_requisitiondtl_po_no_fk
        order By poc.itemreceive_no_fk desc"
        ));
        // dd($grn_details_info);

        $grn_batch_info = DB::select(DB::raw("SELECT poc.*,i.*,ps.*,po.entry_qty,po.au_entry_at as po_date
        FROM phr_itemreceivedtl poc
        LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        LEFT JOIN phr_itemreceivemst ps on ps.itemreceive_no_pk = poc.itemreceive_no_fk
        LEFT JOIN inv_purchaseorder_chd po on po.purchaseorderdtl_no_pk = poc.purchaseorderdtl_no_pk
        WHERE ps.itemreceive_no_pk = $grn_no
        and poc.batch_no is not  null
        order By poc.itemreceive_no_fk"));
        // dd($grn_no);
        return response()->json(['data' => $grn_details_info, 'grn_batch_info' => $grn_batch_info], 200);
    }

    public function saved_grn_info_html(Request $request)
    {

        $grn_no = $request->grn_no;

        $grn_details_info = DB::select(DB::raw(
            "SELECT
            --  poc.*,i.*,ps.*,po.entry_qty
            poc.item_no_fk,
            poc.itemreceive_no_fk,
            poc.purchaseorderdtl_no_pk,
            i.item_name,
            poc.store_room_no_pk,
            i.uom_no_fk,
            i.uom_name,
            poc.uom,
            poc.pr_uom_conversion_qty,
            i.item_uom_name_2nd,
            i.uom_no_fk_2nd,
            i.uom_no_fk_2nd_conv_ratio,
            i.uom_no_fk_3rd,
            i.uom_no_fk_3rd_conv_ratio,
            i.item_uom_name_3rd,
            i.uom_no_fk_4th,
            i.uom_no_fk_4th_conv_ratio,
            i.item_uom_name_4th,
            i.purchase_price,
            poc.trade_price,
            poc.cost_price,
            po.entry_qty,
            i.sales_price,
            ps.inv_requisition_po_no_fk,
            poc.inv_requisitiondtl_po_no_fk,
            sum(poc.freeitem_qty) as freeitem_qty,
            sum(poc.item_qty) as item_qty
        FROM phr_itemreceivedtl poc
        LEFT JOIN sysc_v1_serviceitem_vw i ON poc.ITEM_NO_FK = i.ITEM_NO_PK
        LEFT JOIN phr_itemreceivemst ps on ps.itemreceive_no_pk = poc.itemreceive_no_fk
        LEFT JOIN inv_purchaseorder_chd po on po.purchaseorderdtl_no_pk = poc.purchaseorderdtl_no_pk
        WHERE ps.itemreceive_no_pk = $grn_no
        group by poc.item_no_fk,
            poc.itemreceive_no_fk,
            poc.purchaseorderdtl_no_pk,
            i.item_name,
            poc.store_room_no_pk,
            i.uom_no_fk,
            i.uom_name,
            poc.uom,
            poc.pr_uom_conversion_qty,
            i.item_uom_name_2nd,
            i.uom_no_fk_2nd,
            i.uom_no_fk_2nd_conv_ratio,
            i.uom_no_fk_3rd,
            i.uom_no_fk_3rd_conv_ratio,
            i.item_uom_name_3rd,
            i.uom_no_fk_4th,
            i.uom_no_fk_4th_conv_ratio,
            i.item_uom_name_4th,
            i.purchase_price,
            poc.trade_price,
            poc.cost_price,
            po.entry_qty,
            i.sales_price,
            ps.inv_requisition_po_no_fk,
            poc.inv_requisitiondtl_po_no_fk
        order By poc.itemreceive_no_fk desc"
        ));
        // dd( $grn_details_info);
        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();

        $room_arr = [];

        $batch_checked = DB::table('phr_itemreceivedtl')->select('batch_no', 'item_no_fk')->where('itemreceive_no_fk', $grn_no)->distinct()->get();
        $batch_dtl = DB::table('phr_itemreceivedtl')->select('batch_no', 'item_qty', 'item_no_fk')->where('itemreceive_no_fk', $grn_no)->get();
        // dd($batch_checked);
        foreach ($asset_location as $location) {
            $room_arr[] = [
                'room_no_pk' => $location->room_no_pk,
                'room_code' => $location->room_code,
                'room_name' => $location->room_name
            ];
        }
        // dd($room_arr);
        return Template::loadView("admin.uhl.inventory.grn_info", [

            'po_child_details_info' => $grn_details_info,
            'room_location' => $room_arr,
            'batch_checked' => $batch_checked,
            'batch_dtl' => $batch_dtl,
        ]);
    }

    public function grnWorklist()
    {
        if (Session::get('user.ses_hospital_code') == 'UNICO') {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,count(item_no_fk) as item_q,sum(purchase_price*delivered_qty) as total_purchase_amount,vat_amount,discount_amount,rcv_save_option
            from phr_v1_grn_vw
            group by itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,vat_amount,discount_amount,rcv_save_option
            order by itemreceive_no_pk desc
            ");
        } else {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,count(item_no_fk) as item_q,sum(purchase_price*delivered_qty) as total_purchase_amount,vat_amount,discount_amount,rcv_save_option
            from phr_v1_grn_vw
            where module_code = 'INVENTORY'
            group by itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,vat_amount,discount_amount,rcv_save_option
            order by itemreceive_no_pk desc
        ");
            // dd( $grn_worklists);
        }

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadView("admin.uhl.inventory.grn.inventory-grn-worklist", [
            "grn_worklists" => $grn_worklists,
            "allSuppliers" => $allSuppliers,
        ]);
    }

    public function grnReportPrint($receive_no_fk)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $grn_report_list = DB::select(DB::raw("select
        itemreceive_no_pk,
        item_name,
        uom_name,
        order_qty,
        sum(delivered_qty) delivered_qty,
        discount_amount,
        discount_percent,
        vat_percent,vat_amount,
        sum(delivered_qty+freeitem_qty) total_qty,
        sum(delivered_qty*unit_price) amount,
        freeitem_qty,free_uom_name,
        unit_price,
        supplier_name,
        po_no,
        purchase_date,
        challan_date,
        challan_no,
        department,
        delivery_location,
        challan_date,
        receive_date,
        user_fullname_entry_by ,
        rcv_save_option,
        inv_requisitiondtl_no_pk,
        po_by_name,
        pr_no,
        purchaseorderdtl_no_pk,
        inv_requisitionmst_po_no_pk from phr_v1_grn_vw where itemreceive_no_pk = $receive_no_fk group by itemreceive_no_pk,
        item_name,uom_name,order_qty,freeitem_qty,free_uom_name,unit_price,discount_amount,discount_percent,vat_percent,vat_amount,
        supplier_name,po_no,purchase_date,challan_date,challan_no,department,delivery_location,challan_date,receive_date,user_fullname_entry_by ,rcv_save_option,inv_requisitiondtl_no_pk ,po_by_name,pr_no,purchaseorderdtl_no_pk,inv_requisitionmst_po_no_pk order by item_name ASC"));


        $barcode = new BarcodeGenerator();
        $barcode->setText($receive_no_fk);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        if (Session::get('user.ses_hospital_code') != 'EWMCH') {
            $pdf = PDF::loadView("admin.uhl.inventory.grn.grn_report_pdf", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'grn_report_list' => $grn_report_list,
                'invoice_barcode' => $invoice_barcode,
            ]);
        } else {
            $pdf = PDF::loadView("admin.uhl.inventory.grn.grn_report_new_pdf", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'grn_report_list' => $grn_report_list,
                'invoice_barcode' => $invoice_barcode,
            ]);
        }

        return $pdf->stream("GRN_REPORT.pdf", array("Attachment" => false));
    }

    public function search_grn_worklist(Request $request)
    {
        $supplier_cnd =  isset($request->supplier_id) ? "and supplier_no_fk  =  " . $request->supplier_id : '';
        $challan_no_cnd =  isset($request->grn_no) ? "and  itemreceive_no_pk =  " . $request->grn_no : '';
        $po_no =  isset($request->po_no) ? "and  po_no =  " . $request->po_no : '';
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        $grn_date = isset($request->from_date) ? "and trunc(receive_date) between to_date('$from_date','yyyy-mm-dd') and to_date('$to_date','yyyy-mm-dd')" : '';

        if (in_array(Session::get('user.ses_hospital_code'), ['UNICO', 'DMHL'])) {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,discount_amount,rcv_save_option,count(item_no_fk) as item_q,sum(purchase_price*delivered_qty) as total_purchase_amount
            from phr_v1_grn_vw
            where au_entry_hospital_no_fk = $hospital_id  $supplier_cnd   $challan_no_cnd $grn_date $po_no
            group by itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,discount_amount,rcv_save_option
            order by challan_date desc,po_no desc");
            // dd( $challan_no_cnd);
        } else {
            $grn_worklists = DB::select("select itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,discount_amount,rcv_save_option,count(item_no_fk) as item_q,sum(purchase_price*delivered_qty) as total_purchase_amount
            from phr_v1_grn_vw
            where au_entry_hospital_no_fk = $hospital_id  $supplier_cnd   $challan_no_cnd $grn_date $po_no
            and module_code = 'INVENTORY'
            group by itemreceive_no_pk,po_no,challan_date,receive_date,supplier_name,user_fullname_entry_by,discount_amount,rcv_save_option
            order by challan_date desc,po_no desc");
        }



        return Template::loadview("admin.uhl.inventory.grn.inventory-grn-worklist-table", compact('grn_worklists'));
    }


    /* V2 GRN */

    public function indexV2()
    {
        $grn = $this->getLookupListByCode("GRNTYPE");
        $suppiler_arr = $this->getSupplier();
        $main_store_list = $this->mainStore();
        $currency = $this->getCurrency();

        $main_store_list_all = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();


        $conversion_service_item = DB::table('sysc_serviceitem_uom')
            ->select(
                'uom_no_pk',
                'uom_code',
                'uom_label_desc',
                'parent_uom_no_pk',
                'status',
                'default_uom',
                'uom_type',
            )
            ->where('status', 1)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->get();
        return Template::loadView("admin.inventory.v1.grn.item_receive_grn_v2", [
            'grn_list' => $grn,
            'allSuppliers' => $suppiler_arr,
            'main_store_list' => $main_store_list,
            'main_store_list_all' => $main_store_list_all,
            'asset_location' => $asset_location,
            'currency' => $currency,
            'conversion_service_item' => $conversion_service_item
        ]);
    }


    public function searchPRListforPopupV2(Request $request)
    {
        $query = DB::table('inv_requisition_po_itm_vw')
            // ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select(
                'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
                'inv_requisition_po_itm_vw.req_at',
                'inv_requisition_po_itm_vw.req_po_remarks',
                'inv_requisition_po_itm_vw.approval_status_text',
                'inv_requisition_po_itm_vw.approval_level_status_text',
                'inv_requisition_po_itm_vw.app_status',
                'inv_requisition_po_itm_vw.from_store',
                'inv_requisition_po_itm_vw.item_no_fk',
                'inv_requisition_po_itm_vw.item_name',
                'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk',
                'inv_requisition_po_itm_vw.req_quantity',
                'inv_requisition_po_itm_vw.main_store_su_no_fk',
                'inv_requisition_po_itm_vw.pr_uom_no_fk',
                'inv_requisition_po_itm_vw.item_purchase_price',
                'inv_requisition_po_itm_vw.item_pur_uom_name',
                'inv_requisition_po_itm_vw.pr_uom_conversion_qty',
                'inv_requisition_po_itm_vw.sales_price',
                'inv_requisition_po_itm_vw.already_grn',
                'inv_requisition_po_itm_vw.expireable_ind',
                'inv_requisition_po_itm_vw.generic_name',



            )
            ->where('inv_requisition_po_itm_vw.po_ind', '=', null)
            // ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', '=', null)
            ->where('inv_requisition_po_itm_vw.app_status', 1);

        if (!empty($request->date_from) &&  !empty($request->date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime('+1 day', strtotime($request->date_to)))]);
        } elseif (!empty($request->date_from) &&  !empty($request->date_to) && !empty($request->store)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime('+1 day', strtotime($request->date_to)))])
                ->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->store);
        } elseif (!empty($request->date_from)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->date_from)));
        } elseif (!empty($request->date_to)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->date_to)));
        }

        if ($request->store != "") {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->store);
        }
        if (!empty($request->pr_no_modal)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->pr_no_modal);
        }
        // $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status','inv_requisition_po_itm_vw.from_store');

        $pr_data_list = $query->orderBy('inv_requisitiondtl_po_no_pk', 'asc')->get();

        $data = [];
        foreach ($pr_data_list as $item) {

            $grn_qty = ($item->req_quantity == null ? 0 : $item->req_quantity)  - ($item->already_grn == null ? 0 : $item->already_grn);


            $datas = new stdClass();
            //master level
            $datas->store_room_no_pk = null;
            $datas->expireable = $item->expireable_ind;
            $datas->rcv_qty = $item->req_quantity;
            $datas->mainstore_su_no_fk = $item->main_store_su_no_fk;
            $datas->item_uom_name_2nd = '';
            $datas->uom_no_fk_2nd = '';
            $datas->uom_no_fk_2nd_conv_ratio = '';

            $datas->uom_no_fk_3rd = '';
            $datas->item_uom_name_3rd = '';
            $datas->uom_no_fk_3rd_conv_ratio = '';

            $datas->uom_no_fk_4th = '';
            $datas->item_uom_name_4th = '';
            $datas->uom_no_fk_4th_conv_ratio = '';


            //item level
            $datas->item_id = $item->item_no_fk;
            $datas->purchaseorderdtl_no_pk = '';
            $datas->purchaseorder_no_fk = '';
            $datas->prdtl_no_pk = $item->inv_requisitiondtl_po_no_pk;
            $datas->item_name = $item->item_name;
            $datas->subTotal = $item->item_purchase_price * $grn_qty;
            $datas->vat_percent_item = 0;
            $datas->vat_percent_amount = 0;
            $datas->ait_percent_item = 0;
            $datas->ait_percent_amount = 0;
            $datas->sc_percent_item = 0;
            $datas->sc_percent_amount = 0;
            $datas->disPercent = 0;
            $datas->disAmount = 0;
            $datas->pur_item_uom = $item->pr_uom_no_fk;
            $datas->purchase_uom_name = $item->item_pur_uom_name;
            $datas->uom_conversion_qty = $item->pr_uom_conversion_qty;
            $datas->pur_item_location = '';
            $datas->qty = $item->req_quantity;
            $datas->grn_free_qty = 0;
            $datas->temperature = '';
            $datas->temp_deg = '';
            $datas->uPrice = $item->item_purchase_price;
            $datas->item_sales_price = $item->sales_price;
            $datas->item_cost_price = 0;
            $datas->po_qty = $item->req_quantity;

            $datas->grn_qty = $grn_qty;
            $datas->receive_qty = ($item->already_grn == null ? 0 : $item->already_grn);





            // extra value
            $datas->inv_requisition_po_no_pk = $item->inv_requisition_po_no_pk;
            $datas->req_at = $item->req_at;
            $datas->req_po_remarks = $item->req_po_remarks;
            $datas->approval_status_text = $item->approval_status_text;
            $datas->approval_level_status_text = $item->approval_level_status_text;
            $datas->app_status = $item->app_status;
            $datas->from_store = $item->from_store;
            $datas->item_no_fk = $item->item_no_fk;
            $datas->inv_requisitiondtl_po_no_pk = $item->inv_requisitiondtl_po_no_pk;
            $datas->req_quantity = $item->req_quantity;
            $datas->pr_uom_no_fk = $item->pr_uom_no_fk;
            $datas->item_purchase_price = $item->item_purchase_price;
            $datas->item_pur_uom_name = $item->item_pur_uom_name;
            $datas->pr_uom_conversion_qty = $item->pr_uom_conversion_qty;


            $datas->totalAmount = ($datas->subTotal) - ($datas->disAmount) + ($datas->ait_percent_amount) + ($datas->sc_percent_amount) + ($datas->vat_percent_amount);
            $datas->generic_name=$item->generic_name;
            array_push($data, $datas);
        }

        return response()->json(['pr_data_list' => $data], 200);
    }

    public function saveGRNOrderv2(Request $request)
    {
        $request->validate([
            'currency' =>  'required',
            'curr_rate' =>  'required',
            'main_store_id' =>  'required',
            'supplier' =>  'required',
            'grn_type' =>  'required',
            'grn_date' =>  'required',
            'challan_date' =>  'required',
            'invoice_no' =>  'required',
        ]);

       if (isset($request->po_no)) {
            if (Session::get('user.ses_hospital_code') == "KPJ") {
                $po_id_query = DB::table('inv_purchaseorder_mst')
                    ->where('purchase_uid', $request->po_no)
                    ->where('store_no_fk', $request->main_store_id)
                    ->value('purchaseorder_no_pk');
            } else {
                $po_id_query = $request->po_no;
            }
        } else {
            $po_id_query = null;
        }

        try {
            $out_purchase_no_pk = '';
            DB::beginTransaction();
            $grn_no = $request->grn_no;
            $grn_type = $request->grn_type;
            $grn_date = !empty($request->grn_date) ? date("Y-m-d", strtotime($request->grn_date)) : '';
            // $grn_date = null;
            $requisition_po_no_pk = $request->pr_prev_no;
            $delivery_order_no = $request->delivery_no;
            $invoice_number = $request->invoice_no;
            $challan_date = !empty($request->challan_date) ? date("Y-m-d", strtotime($request->challan_date)) : '';
            // $challan_date =  null;
            $gate_entry = $request->gate_entry_no;
            $zero = 0;
            $null = null;
            $received_by = $request->received_by;
            $inspected_by = $request->inspected_by;
            $main_store_id = $request->main_store_id;

            $po_no = isset($request->po_no) ? intval($po_id_query) : 0;
            $supplier = $request->supplier;
            $vat_percent = isset($request->vat_percent) ? $request->vat_percent : 0;
            $vat_amount = isset($request->vat_amount) ? $request->vat_amount : 0;
            $po_amount = $request->po_amount;
            $discount_percent = isset($request->gross_discount_percent) ? $request->gross_discount_percent : 0;
            $discount_amount = isset($request->gross_discount_amount) ? $request->gross_discount_amount : 0;
            $main_store_module = ServiceUnit::where('main_store_ind', 1)->where('serviceunit_no_pk', $request->main_store_id)->value('main_store_module_no_fk');
            $main_store_module = !empty($main_store_module) ? $main_store_module : 0;
            $remarks = $request->remarks;

            $grand_ait_percent = $request->gross_ait_percent;
            $grand_ait_amount =  $request->gross_ait_amount;
            $grand_sc_percent =  $request->gross_sc_percent;
            $granc_sc_amount =   $request->gross_sc_amount;


            $po_amount = !empty($po_amount) ? floatVal($request->po_amount) : 0;
            $gate_entry_no = $request->gate_entry_no;
            $bill_amount = $request->bill_amount;
            $bill_date = !empty($request->bill_date) ? date("Y-m-d", strtotime($request->bill_date)) : '';
            $po_date = !empty($request->po_date) ? date("Y-m-d", strtotime($request->po_date)) : '';
            $gate_entry_by = $request->gate_entry_by;
            $received_by = $request->received_by_hdn;
            $inspected_by = $request->inspected_by_hdn;

            $invoice_no = $request->invoice_no;

            $purchase_type_no = $request->purchase_type;
            $cash_purchase_by  = $request->cash_purchase_by_hdn;
            $cash_purchase_date  = !empty($request->cash_purchase_date) ? date("Y-m-d", strtotime($request->cash_purchase_date)) : '';;


            $save_option = '';
            if (!empty($grn_no)) {
                $save_option = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $grn_no)->value('rcv_save_option');
            }
            $rcv_save_option = $save_option == "DRAFT" ? 'POST' : 'DRAFT';

            $attachment = "";
            if ($request->hasFile('attachment')) {
                $files = $request->file('attachment');
                $attachment = date('Ymdhi') . "." . $files->getClientOriginalExtension();
                $request->attachment->move(public_path('/images/uploads/attachment'), $attachment);
            }

            $free_qty = [];
            $item_id = [];
            $numelems = 500;
            $batch_no = [];
            $exp_date = [];
            $pvmsno = [];
            $rcv_qty = [];
            $purchase_uom_no_pk = [];
            $purchase_price = [];
            $cost_price = [];
            $item_sl = [];
            $item_remarks = [];
            $conversion_qty = [];
            $in_purchaseorderdtl_no_pk = [];
            $in_inv_requisitiondtl_no_pk = [];
            $in_temperature = [];
            $in_store_room_no_pk = [];
            $inv_requisitiondtl_po_no_fk = [];
            $sales_price = [];
            $cost_price = [];
            $purchase_uom_name = [];
            $batch_item_qty = [];
            $empty = [];
            $pvmsno = [];
            $in_vat_percent_itm = [];
            $in_vat_amount_itm = [];
            $in_discount_percent_itm = [];
            $in_discount_amount_itm = [];

            $in_purchaseorderdtl_no_pk = [];
            $in_purchaseorder_no_pk = [];
            $in_inv_requisitiondtl_no_pk = [];

            $in_temperature = [];
            $in_store_room_no_pk = [];
            $inv_requisitiondtl_po_no_fk = [];

            $currency_fk = [];
            $currency_rate = [];
            $in_ait_percent_itm = [];
            $in_ait_amount_itm = [];
            $in_sc_percent_itm = [];
            $in_sc_amount_itm = [];
            $in_margin_percent = [];

            // array requested data
            $batchData = json_decode($request->batchData);
            $count = 0;
            foreach ($batchData as $key => $item) {
                if (in_array($key, $request->item_count_ind)) {
                    foreach (json_decode($item)->batch as $key2 => $item2) {
                        $exp_dates = json_decode($item)->date[$key2];
                        $batch_qty = json_decode($item)->batch_qty[$key2];
                        $batch = $item2;
                        $index = array_search($key, $request->item_count_ind);

                        $item_exp_date = !empty($exp_dates) ? strval(date('dmY', strtotime($exp_dates))) : null;

                        // dd(intval($request->item_id[$index]),$item_exp_date);
                        $currency_fk[$count] = $request->currency;
                        $currency_rate[$count] = $request->curr_rate;

                        $item_sl[$count] = isset($request->po_sl[$index]) ? intval($request->po_sl[$index]) : 1;
                        // $item_sl[$count] = $count;
                        $item_id[$count] =  isset($request->item_id[$index]) ? intval($request->item_id[$index]) : null;
                        $batch_no[$count] = !empty($batch) ? trim($batch) : $null;
                        $exp_date[$count] = $item_exp_date;
                        $rcv_qty[$count] =  isset($batch_qty) ? floatval($batch_qty) : floatval($request->qty[$index]);
                        $free_qty[$count] =  isset($request->grn_free_qty[$index]) ? floatval($request->grn_free_qty[$index]) : 0;
                        $purchase_price[$count] = isset($request->uPrice[$index]) ? floatval($request->uPrice[$index]) : 0;
                        $sales_price[$count] = isset($request->item_sales_price[$index]) ? floatval($request->item_sales_price[$index]) : 0;
                        $cost_price[$count] = isset($request->item_cost_price[$index]) ? floatval($request->item_cost_price[$index]) : 0;
                        $in_margin_percent[$count] = isset($request->margin_percnt[$index]) ? floatval($request->margin_percnt[$index]) : 0;

                        $purchase_uom_no_pk[$count] = isset($request->pur_item_uom[$index]) ? intval($request->pur_item_uom[$index]) : null;
                        $purchase_uom_name[$count] = isset($request->purchase_uom_name[$index]) ? $request->purchase_uom_name[$index] : null;
                        $conversion_qty[$count] = isset($request->item_conv_qty[$index]) ? floatval($request->item_conv_qty[$index]) : 1;
                        $batch_item_qty[$count] = isset($batch_qty) ? floatval($batch_qty) : floatval($request->qty[$index]);
                        $empty[$count] = 1;
                        $pvmsno[$count] = $null;
                        $item_remarks[$count] = null;

                        $in_vat_percent_itm[$count] = isset($request->vat_percent_item[$index]) ? floatval($request->vat_percent_item[$index]) : 0;
                        $in_vat_amount_itm[$count] = isset($request->vat_percent_amount[$index]) ? floatval($request->vat_percent_amount[$index]) : 0;
                        $in_discount_percent_itm[$count] = isset($request->disPercent[$index]) ? floatval($request->disPercent[$index]) : 0;
                        $in_discount_amount_itm[$count] = isset($request->disAmount[$index]) ? floatval($request->disAmount[$index]) : 0;

                        $in_ait_percent_itm[$count] = isset($request->ait_percent_item[$index]) ? floatval($request->ait_percent_item[$index]) : 0;
                        $in_ait_amount_itm[$count] = isset($request->ait_percent_amount[$index]) ? floatval($request->ait_percent_amount[$index]) : 0;
                        $in_sc_percent_itm[$count] = isset($request->sc_percent_item[$index]) ? floatval($request->sc_percent_item[$index]) : 0;
                        $in_sc_amount_itm[$count] = isset($request->sc_percent_amount[$index]) ? floatval($request->sc_percent_amount[$index]) : 0;

                        $in_purchaseorderdtl_no_pk[$count] = isset($request->purchaseorderdtl_no_pk[$index]) ? $request->purchaseorderdtl_no_pk[$index] : 0;
                        $in_purchaseorder_no_pk[$count] = isset($request->purchaseorder_no_fk[$index]) ? $request->purchaseorder_no_fk[$index] : 0;
                        $in_inv_requisitiondtl_no_pk[$count] = 0;
                        $in_temperature[$count] = isset($request->temperature[$index]) ? $request->temperature[$index] : null;
                        $in_store_room_no_pk[$count] = isset($request->pur_item_location[$index]) ? intval($request->pur_item_location[$index]) : 0;
                        $inv_requisitiondtl_po_no_fk[$count] = isset($request->prdtl_no_pk[$index]) ? $request->prdtl_no_pk[$index] : 0;
                        $count++;
                    }
                }
            }

            // dd($item_sl,
            //     $item_id,
            //     $batch_no,
            //     $exp_date,
            //     $rcv_qty,
            //     $free_qty,
            //     $purchase_price,
            //     $sales_price,
            //     $cost_price,
            //     $purchase_uom_no_pk,
            //     $purchase_uom_name,
            //     $conversion_qty,
            //     $batch_item_qty,
            //     $empty,
            //     $pvmsno,
            //     $item_remarks,
            //     $in_vat_percent_itm,
            //     $in_vat_amount_itm,
            //     $in_discount_percent_itm,
            //     $in_discount_amount_itm,
            //     $in_purchaseorderdtl_no_pk,
            //     $in_purchaseorder_no_pk,
            //     $in_inv_requisitiondtl_no_pk,
            //     $in_temperature,
            //     $in_store_room_no_pk,
            //     $inv_requisitiondtl_po_no_fk,
            //     $in_margin_percent,
            //     $cash_purchase_date,
            //     $invoice_no,
            //     $cash_purchase_by,
            //     $purchase_type_no,
            //     $po_no
            // );


            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = intval(Session::get('user.ses_hospital_no_pk'));
            $out_itemreceive_no_pk = $out_itemreceive_uid = $out_error = 0;

            $pdo = DB::getPdo();
            $receive_items = $pdo->prepare("begin pkg_v2_inventory_all.prc_itemreceive_ms_v1(
                                            :in_itemreceive_no_pk,
                                            :in_grn_type,
                                            :in_grn_date,
                                            :in_inv_requisition_po_no_pk,
                                            :in_delivery_order,
                                            :in_challan_no,
                                            :in_challan_date,
                                            :in_gate_entry_number,
                                            :in_fiscal_year,
                                            :in_year_quarter,
                                            :in_received_by_person_no_fk,
                                            :in_inspected_by_person_no_fk,
                                            :in_store_su_no_fk,
                                            :in_demand_no_fk,
                                            :in_supplier_no_fk,
                                            :in_vat_percent,
                                            :in_vat_amount,
                                            :in_discount_percent,
                                            :in_discount_amount,
                                            :in_module_no_fk,
                                            :in_requisition_no_fk,
                                            :in_requisition_code,
                                            :in_purchaseorder_no_pk,
                                            :in_notes,
                                            :in_bill_image,
                                            :in_return_amt,
                                            :in_return_note,
                                            :in_rcv_save_option,
                                            :in_ait_percent,
                                            :in_ait_amount,
                                            :in_service_charge_percent,
                                            :in_service_charge_amount,

                                            :in_po_date,
                                            :in_po_amount,
                                            :in_gate_entry_no,
                                            :in_bill_amount,
                                            :in_bill_date,
                                            :in_gate_entry_by,
                                            :in_received_by,
                                            :in_inspected_by,
                                            :in_purchase_type_no,
                                            :in_cash_purchase_by,
                                            :in_cash_purchase_date ,
                                            :in_bill_or_invoice_no,
                                            :in_a_item_no_fk,
                                            :in_item_batch_fk,
                                            :in_item_expiry_dt,
                                            :in_a_item_pvmsno,
                                            :in_a_item_qty,
                                            :in_a_item_uom,
                                            :in_a_freeitem_qty,
                                            :in_a_freeitem_uom,
                                            :in_a_item_price,
                                            :in_item_sales_price,
                                            :in_a_item_cost_price ,
                                            :in_a_entry_serial_dtl ,
                                            :in_item_remarks,
                                            :in_pr_uom_no_fk ,
                                            :in_pr_uom_conversion_qty ,
                                            :in_pr_uom_tradeprice ,
                                            :in_vat_percent_itm,
                                            :in_vat_amount_itm,
                                            :in_discount_percent_itm,
                                            :in_discount_amount_itm,
                                            :in_purchaseorderdtl_no_pk,
                                            :in_inv_requisitiondtl_no_pk,
                                            :in_temperature,
                                            :in_store_room_no_pk,
                                            :in_inv_requisitiondtl_po_no_fk,

                                            :in_currency_no_fk,
                                            :in_currency_rate,
                                            :in_ait_percent_itm,
                                            :in_ait_amount_itm,
                                            :in_ser_charge_percent_itm,
                                            :in_ser_charge_amount_itm,
                                            :in_margin_percnt,

                                            :in_au_entry_by,
                                            :in_au_entry_session,
                                            :in_au_entry_hospital_no_fk,
                                            :out_itemreceive_no_pk,
                                            :out_itemreceive_uid,
                                            :out_error
                                    ); end;");
            $receive_items->bindparam('in_itemreceive_no_pk', $grn_no);
            $receive_items->bindparam('in_grn_type', $grn_type);
            $receive_items->bindparam('in_grn_date', $grn_date);
            $receive_items->bindparam('in_inv_requisition_po_no_pk', $requisition_po_no_pk);
            $receive_items->bindparam('in_delivery_order', $delivery_order_no);
            $receive_items->bindparam('in_challan_no', $invoice_number);
            $receive_items->bindparam('in_challan_date', $challan_date);
            $receive_items->bindparam('in_gate_entry_number', $gate_entry);
            $receive_items->bindparam('in_fiscal_year', $zero);
            $receive_items->bindparam('in_year_quarter', $null);
            $receive_items->bindparam('in_received_by_person_no_fk', $received_by);
            $receive_items->bindparam('in_inspected_by_person_no_fk', $inspected_by);
            $receive_items->bindparam('in_store_su_no_fk', $main_store_id);
            $receive_items->bindparam('in_demand_no_fk', $po_no);
            $receive_items->bindparam('in_supplier_no_fk', $supplier);
            $receive_items->bindparam('in_vat_percent', $vat_percent);
            $receive_items->bindparam('in_vat_amount', $vat_amount);
            $receive_items->bindparam('in_discount_percent', $discount_percent);
            $receive_items->bindparam('in_discount_amount', $discount_amount);
            $receive_items->bindparam('in_module_no_fk', $main_store_module);
            $receive_items->bindparam('in_requisition_no_fk', $zero);
            $receive_items->bindparam('in_requisition_code', $null);
            $receive_items->bindparam('in_purchaseorder_no_pk', $po_no);
            $receive_items->bindparam('in_notes', $remarks);
            $receive_items->bindparam('in_bill_image', $attachment);
            $receive_items->bindparam('in_return_amt', $zero);
            $receive_items->bindparam('in_return_note', $null);
            $receive_items->bindparam('in_rcv_save_option', $rcv_save_option);
            $receive_items->bindparam('in_ait_percent', $grand_ait_percent);
            $receive_items->bindparam('in_ait_amount', $grand_ait_amount);
            $receive_items->bindparam('in_service_charge_percent', $grand_sc_percent);
            $receive_items->bindparam('in_service_charge_amount', $granc_sc_amount);

            $receive_items->bindparam('in_po_date', $po_date);
            $receive_items->bindparam('in_po_amount', $po_amount);
            $receive_items->bindparam('in_gate_entry_no', $gate_entry_no);
            $receive_items->bindparam('in_bill_amount', $bill_amount);
            $receive_items->bindparam('in_bill_date', $bill_date);
            $receive_items->bindparam('in_gate_entry_by', $gate_entry_by);
            $receive_items->bindparam('in_received_by', $received_by);
            $receive_items->bindparam('in_inspected_by', $inspected_by);

            $receive_items->bindparam('in_purchase_type_no', $purchase_type_no);
            $receive_items->bindparam('in_cash_purchase_by', $cash_purchase_by);
            $receive_items->bindparam('in_cash_purchase_date', $cash_purchase_date);
            $receive_items->bindparam('in_bill_or_invoice_no', $invoice_no);

            $receive_items->bindArray('in_a_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_pvmsno', $pvmsno, count($pvmsno), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $rcv_qty, count($rcv_qty), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_qty', $free_qty, count($free_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_price', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_item_sales_price', $sales_price, count($sales_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_cost_price', $cost_price, count($cost_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_sl, count($item_sl), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_remarks', $item_remarks, count($item_remarks), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_pr_uom_no_fk', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_conversion_qty', $conversion_qty, count($conversion_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_tradeprice', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_temperature', $in_temperature, count($in_temperature), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_store_room_no_pk', $in_store_room_no_pk, count($in_store_room_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_po_no_fk', $inv_requisitiondtl_po_no_fk, count($inv_requisitiondtl_po_no_fk), $numelems, SQLT_INT);

            $receive_items->bindArray('in_currency_no_fk', $currency_fk, count($currency_fk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_currency_rate', $currency_rate, count($currency_rate), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ait_percent_itm', $in_ait_percent_itm, count($in_ait_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ait_amount_itm', $in_ait_amount_itm, count($in_ait_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ser_charge_percent_itm', $in_sc_percent_itm, count($in_sc_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ser_charge_amount_itm', $in_sc_amount_itm, count($in_sc_amount_itm), $numelems, SQLT_FLT);

            $receive_items->bindArray('in_margin_percnt', $in_margin_percent, count($in_margin_percent), $numelems, SQLT_FLT);

            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindParam('out_itemreceive_no_pk', $out_itemreceive_no_pk, PDO::PARAM_INT);
            $receive_items->bindParam('out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            $receive_items->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            // dd( $receive_items);
            $receive_items->execute();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data saved successfully. <br><strong>Receive No = ' . $out_itemreceive_no_pk . ',Transaction No = ' . $out_itemreceive_uid . '</strong>', 'title' => 'Success', 'no' => $out_error], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function getCurrency()
    {
        $curr_data = DB::table('sysc_currency')->select('currency_no_pk', 'rate', 'currency_code', 'status')->where('status', 1)->get();
        return $curr_data;
    }

    public function getSupplier()
    {
        $supplier_arr =  DB::table('INV_SUPPLIER')
            ->select('supplier_no_pk', 'supplier_uid', 'supplier_name', 'company_name', 'status')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->distinct('supplier_name', 'company_name')
            ->where('status', 1)
            ->get();
        return $supplier_arr;
    }

    public function mainStore()
    {
        $store = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk', 'grantsu_no_pk', 'full_name', 'serviceunit_name', 'serviceunit_code', 'status', 'pharmacy_ind')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->orderByRaw("lower(serviceunit_name) asc")
            ->where('status', 1)
            ->get();
        return $store;
    }

    public function pr_infoV2(Request $request)
    {
        $query = DB::table('inv_requisition_po_itm_vw')
            // ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select(
                'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
                'inv_requisition_po_itm_vw.req_at',
                'inv_requisition_po_itm_vw.req_po_remarks',
                'inv_requisition_po_itm_vw.approval_status_text',
                'inv_requisition_po_itm_vw.approval_level_status_text',
                'inv_requisition_po_itm_vw.app_status',
                'inv_requisition_po_itm_vw.from_store',
                'inv_requisition_po_itm_vw.item_no_fk',
                'inv_requisition_po_itm_vw.item_name',
                'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk',
                'inv_requisition_po_itm_vw.req_quantity',
                'inv_requisition_po_itm_vw.main_store_su_no_fk',
                'inv_requisition_po_itm_vw.pr_uom_no_fk',
                'inv_requisition_po_itm_vw.item_purchase_price',
                'inv_requisition_po_itm_vw.item_pur_uom_name',
                'inv_requisition_po_itm_vw.pr_uom_conversion_qty',
                'inv_requisition_po_itm_vw.sales_price',
                'inv_requisition_po_itm_vw.already_grn',
                'inv_requisition_po_itm_vw.generic_name',



            )
            ->where('inv_requisition_po_itm_vw.po_ind', '=', null)
            // ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', '=', null)
            ->where('inv_requisition_po_itm_vw.app_status', 1);

        if (!empty($request->store_no)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->store_no);
        }
        if (!empty($request->pr_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->pr_no);
        }

        $pr_data_list = $query->orderBy('inv_requisition_po_no_pk', 'desc')->get();

        $data = [];
        foreach ($pr_data_list as $item) {

            $grn_qty = ($item->req_quantity == null ? 0 : $item->req_quantity)  - ($item->already_grn == null ? 0 : $item->already_grn);


            $datas = new stdClass();
            //master level
            $datas->store_room_no_pk = null;
            $datas->rcv_qty = $item->req_quantity;
            $datas->mainstore_su_no_fk = $item->main_store_su_no_fk;
            $datas->item_uom_name_2nd = '';
            $datas->uom_no_fk_2nd = '';
            $datas->uom_no_fk_2nd_conv_ratio = '';

            $datas->uom_no_fk_3rd = '';
            $datas->item_uom_name_3rd = '';
            $datas->uom_no_fk_3rd_conv_ratio = '';

            $datas->uom_no_fk_4th = '';
            $datas->item_uom_name_4th = '';
            $datas->uom_no_fk_4th_conv_ratio = '';


            //item level
            $datas->item_id = $item->item_no_fk;
            $datas->purchaseorderdtl_no_pk = '';
            $datas->purchaseorder_no_fk = '';
            $datas->prdtl_no_pk = $item->inv_requisitiondtl_po_no_pk;
            $datas->item_name = $item->item_name;
            $datas->subTotal = $item->item_purchase_price * $grn_qty;
            $datas->vat_percent_item = 0;
            $datas->vat_percent_amount = 0;
            $datas->ait_percent_item = 0;
            $datas->ait_percent_amount = 0;
            $datas->sc_percent_item = 0;
            $datas->sc_percent_amount = 0;
            $datas->disPercent = 0;
            $datas->disAmount = 0;
            $datas->pur_item_uom = $item->pr_uom_no_fk;
            $datas->purchase_uom_name = $item->item_pur_uom_name;
            $datas->uom_conversion_qty = $item->pr_uom_conversion_qty;
            $datas->pur_item_location = '';
            $datas->qty = $item->req_quantity;
            $datas->grn_free_qty = 0;
            $datas->temperature = '';
            $datas->temp_deg = '';
            $datas->uPrice = $item->item_purchase_price;
            $datas->item_sales_price = $item->sales_price;
            $datas->item_cost_price = 0;
            $datas->po_qty = $item->req_quantity;

            $datas->grn_qty = $grn_qty;
            $datas->receive_qty = ($item->already_grn == null ? 0 : $item->already_grn);

            // extra value
            $datas->inv_requisition_po_no_pk = $item->inv_requisition_po_no_pk;
            $datas->req_at = $item->req_at;
            $datas->req_po_remarks = $item->req_po_remarks;
            $datas->approval_status_text = $item->approval_status_text;
            $datas->approval_level_status_text = $item->approval_level_status_text;
            $datas->app_status = $item->app_status;
            $datas->from_store = $item->from_store;
            $datas->item_no_fk = $item->item_no_fk;
            $datas->inv_requisitiondtl_po_no_pk = $item->inv_requisitiondtl_po_no_pk;
            $datas->req_quantity = $item->req_quantity;
            $datas->pr_uom_no_fk = $item->pr_uom_no_fk;
            $datas->item_purchase_price = $item->item_purchase_price;
            $datas->item_pur_uom_name = $item->item_pur_uom_name;
            $datas->pr_uom_conversion_qty = $item->pr_uom_conversion_qty;


            $datas->totalAmount = ($datas->subTotal) - ($datas->disAmount) + ($datas->ait_percent_amount) + ($datas->sc_percent_amount) + ($datas->vat_percent_amount);
            $datas->generic_name=$item->generic_name;
            array_push($data, $datas);
        }

        return response()->json(['data' => $data], 200);
    }


    public function searchPOWorklistGRNV3(Request $request)
    {

        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d-m-Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d-m-Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $query = DB::table('po_popup_list_for_grn_vw')
            ->select(
                'purchaseorder_no_pk',
                'purchase_uid',
                'item_no_fk',
                'item_name',
                'vat_amount_itm',
                'discount_amount_itm',
                'purchase_date',
                'supplier_name',
                'total_qty',
                'vat_percent',
                'vat_amount',
                'discount_percent',
                'discount_amount',
                'total_amount',
                'po_save_option',
                'po_no',
                'total_order_qty',
                'total_delivered_qty',
                'currency_no_fk',
                'currency_sign',
                'dollar_rate',
                'ait_percent',
                'ait_amount',
                'service_charge_percent',
                'service_charge_amount',
                'purchaseorderdtl_no_pk',
                'pvms_no',
                'entry_qty',
                'item_rate',
                'supplier_no_fk',
                'store_no_fk',
                'vat_percent_itm',
                'vat_amount_itm',
                'ait_percent_itm',
                'ait_amount_itm',
                'ser_charge_percent_itm',
                'ser_charge_amount_itm',
                'discount_percent_itm',
                'discount_amount_itm',
                'uom',
                'pr_uom_conversion_qty',
                'currency_no_fk',
                'dollar_rate',
                'currency_sign',
                'item_requisition_no_fk',
                'expireable_ind',
                'uom_name',
                'sales_price',
                'generic_name',
                'approval_level_status_text'

            );


        if (!empty($request->po_no_modal)) {
            if (Session::get('user.ses_hospital_code')=="KPJ") {
                    $query->where('purchase_uid', $request->po_no_modal);
                }
            else {
                $query->where('purchaseorder_no_pk', $request->po_no_modal);
            }

        }

        if (!empty($request->supplier_modal)) {
            $query->where('supplier_no_fk', $request->supplier_modal);
        }
        if (!empty($request->from_date) &&  !empty($request->to_date)) {
            $query->whereBetween('purchase_date', [$from_date, $to_date]);
        }
        if (!empty($request->store)) {
            $query->where('store_no_fk', $request->store);
        } elseif (!empty($request->from_date)) {
            $query->where('purchase_date', $from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('purchase_date', $to_date);
        }
            $query->whereRaw("
                CAST(SUBSTR(approval_level_status_text, 1, INSTR(approval_level_status_text, '/') - 1) AS NUMBER) =
                CAST(SUBSTR(approval_level_status_text, INSTR(approval_level_status_text, '/') + 1) AS NUMBER)
            ");

         $query->orderByDesc('purchaseorder_no_pk');

         $data =  $query->get()->toArray();
        // dd( $data);
        $all_data = [];
        foreach ($data as $item) {

            $grn_qty = ($item->total_qty == null ? 0 : $item->total_qty)  - ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);
            $datas = new stdClass();
            $datas->curr_rate = !empty($item->dollar_rate) ? $item->dollar_rate : 1;
            $datas->expireable = $item->expireable_ind;
            $datas->store_room_no_pk = '';
            $datas->rcv_qty = $item->entry_qty;
            $datas->mainstore_su_no_fk = $item->store_no_fk;
            $datas->item_uom_name_2nd = '';
            $datas->uom_no_fk_2nd = '';
            $datas->uom_no_fk_2nd_conv_ratio = '';

            $datas->uom_no_fk_3rd = '';
            $datas->item_uom_name_3rd = '';
            $datas->uom_no_fk_3rd_conv_ratio = '';

            $datas->uom_no_fk_4th = '';
            $datas->item_uom_name_4th = '';
            $datas->uom_no_fk_4th_conv_ratio = '';

            //item level
            $datas->item_id = $item->item_no_fk;
            $datas->purchaseorderdtl_no_pk = $item->purchaseorderdtl_no_pk;
            $datas->purchaseorder_no_fk = $item->purchaseorder_no_pk;
            $datas->purchase_uid = $item->purchase_uid;
            $datas->prdtl_no_pk = '';
            $datas->item_name = $item->item_name;
            $datas->subTotal = (($item->item_rate / $datas->curr_rate) * $grn_qty);
            $datas->vat_percent_item = $item->vat_percent_itm;
            $datas->vat_percent_amount = ($item->vat_amount_itm / $datas->curr_rate);
            $datas->ait_percent_item = $item->ait_percent_itm;
            $datas->ait_percent_amount = ($item->ait_amount_itm / $datas->curr_rate);
            $datas->sc_percent_item = $item->ser_charge_percent_itm;
            $datas->sc_percent_amount = ($item->ser_charge_amount_itm / $datas->curr_rate);
            $datas->disPercent = $item->discount_percent_itm;
            $datas->disAmount = ($item->discount_amount_itm / $datas->curr_rate);
            $datas->pur_item_uom = $item->uom;
            $datas->purchase_uom_name = $item->uom_name;
            $datas->uom_conversion_qty = $item->pr_uom_conversion_qty;
            $datas->pur_item_location = '';
            $datas->qty = $item->entry_qty;
            $datas->grn_free_qty = 0;
            $datas->temperature = '';
            $datas->temp_deg = '';
            $datas->uPrice = ($item->item_rate / $datas->curr_rate);
            $datas->item_sales_price = ($item->sales_price / $datas->curr_rate);
            $datas->item_cost_price = 0;
            $datas->po_qty = $item->entry_qty;



            $datas->grn_qty = $grn_qty;
            $datas->receive_qty = ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);

            // others
            $datas->purchase_date = $item->purchase_date;
            $datas->supplier_name = $item->supplier_name;
            $datas->supplier_no_fk = $item->supplier_no_fk;
            $datas->currency_no_fk = $item->currency_no_fk;
            $datas->item_requisition_no_fk = $item->item_requisition_no_fk;

            $datas->totalAmount = ($datas->subTotal / $datas->curr_rate) - ($datas->disAmount / $datas->curr_rate) + ($datas->ait_percent_amount / $datas->curr_rate) + ($datas->sc_percent_amount / $datas->curr_rate) + ($datas->vat_percent_amount / $datas->curr_rate);
            $datas->generic_name=$item->generic_name;
            array_push($all_data, $datas);
        }

        return response()->json(['data' => $all_data, 'success' => true], 200);
    }
    public function searchPOWorklistPending(Request $request)
    {

        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d-m-Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d-m-Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $query = DB::table('po_popup_list_for_grn_vw')
            ->select(
                'purchaseorder_no_pk',
                'item_no_fk',
                'item_name',
                'vat_amount_itm',
                'discount_amount_itm',
                'purchase_date',
                'supplier_name',
                'total_qty',
                'vat_percent',
                'vat_amount',
                'discount_percent',
                'discount_amount',
                'total_amount',
                'po_save_option',
                'po_no',
                'total_order_qty',
                'total_delivered_qty',
                'currency_no_fk',
                'currency_sign',
                'dollar_rate',
                'ait_percent',
                'ait_amount',
                'service_charge_percent',
                'service_charge_amount',
                'purchaseorderdtl_no_pk',
                'pvms_no',
                'entry_qty',
                'item_rate',
                'supplier_no_fk',
                'store_no_fk',
                'vat_percent_itm',
                'vat_amount_itm',
                'ait_percent_itm',
                'ait_amount_itm',
                'ser_charge_percent_itm',
                'ser_charge_amount_itm',
                'discount_percent_itm',
                'discount_amount_itm',
                'uom',
                'pr_uom_conversion_qty',
                'currency_no_fk',
                'dollar_rate',
                'currency_sign',
                'item_requisition_no_fk',
                'expireable_ind',
                'uom_name',
                'sales_price'

            );


        if (!empty($request->po_no_modal)) {
            $query->where('purchaseorder_no_pk', $request->po_no_modal);
        }
        if (!empty($request->supplier_modal)) {
            $query->where('supplier_no_fk', $request->supplier_modal);
        }
        if (!empty($request->from_date) &&  !empty($request->to_date)) {
            $query->whereBetween('purchase_date', [$from_date, $to_date]);
        }
        // if (!empty($request->store)) {
        //     $query->where('store_no_fk', $request->store);
        // }
        elseif (!empty($request->from_date)) {
            $query->where('purchase_date', $from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('purchase_date', $to_date);
        }

        $data = $query->orderByDesc('purchaseorder_no_pk')->get()->toArray();


        $all_data = [];
        foreach ($data as $item) {
            if (($item->total_qty == null ? 0 : $item->total_qty)  - ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty) > 0) {

                $grn_qty = ($item->total_qty == null ? 0 : $item->total_qty)  - ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);
                $datas = new stdClass();
                $datas->curr_rate = !empty($item->dollar_rate) ? $item->dollar_rate : 1;
                $datas->expireable = $item->expireable_ind;
                $datas->store_room_no_pk = '';
                $datas->rcv_qty = $item->entry_qty;
                $datas->mainstore_su_no_fk = $item->store_no_fk;
                $datas->item_uom_name_2nd = '';
                $datas->uom_no_fk_2nd = '';
                $datas->uom_no_fk_2nd_conv_ratio = '';

                $datas->uom_no_fk_3rd = '';
                $datas->item_uom_name_3rd = '';
                $datas->uom_no_fk_3rd_conv_ratio = '';

                $datas->uom_no_fk_4th = '';
                $datas->item_uom_name_4th = '';
                $datas->uom_no_fk_4th_conv_ratio = '';

                //item level
                $datas->item_id = $item->item_no_fk;
                $datas->purchaseorderdtl_no_pk = $item->purchaseorderdtl_no_pk;
                $datas->purchaseorder_no_fk = $item->purchaseorder_no_pk;
                $datas->prdtl_no_pk = '';
                $datas->item_name = $item->item_name;
                $datas->subTotal = (($item->item_rate / $datas->curr_rate) * $grn_qty);
                $datas->vat_percent_item = $item->vat_percent_itm;
                $datas->vat_percent_amount = ($item->vat_amount_itm / $datas->curr_rate);
                $datas->ait_percent_item = $item->ait_percent_itm;
                $datas->ait_percent_amount = ($item->ait_amount_itm / $datas->curr_rate);
                $datas->sc_percent_item = $item->ser_charge_percent_itm;
                $datas->sc_percent_amount = ($item->ser_charge_amount_itm / $datas->curr_rate);
                $datas->disPercent = $item->discount_percent_itm;
                $datas->disAmount = ($item->discount_amount_itm / $datas->curr_rate);
                $datas->pur_item_uom = $item->uom;
                $datas->purchase_uom_name = $item->uom_name;
                $datas->uom_conversion_qty = $item->pr_uom_conversion_qty;
                $datas->pur_item_location = '';
                $datas->qty = $item->entry_qty;
                $datas->grn_free_qty = 0;
                $datas->temperature = '';
                $datas->temp_deg = '';
                $datas->uPrice = ($item->item_rate / $datas->curr_rate);
                $datas->item_sales_price = ($item->sales_price / $datas->curr_rate);
                $datas->item_cost_price = 0;
                $datas->po_qty = $item->entry_qty;



                $datas->grn_qty = $grn_qty;
                $datas->receive_qty = ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);

                // others
                $datas->purchase_date = $item->purchase_date;
                $datas->supplier_name = $item->supplier_name;
                $datas->supplier_no_fk = $item->supplier_no_fk;
                $datas->currency_no_fk = $item->currency_no_fk;
                $datas->item_requisition_no_fk = $item->item_requisition_no_fk;

                $datas->totalAmount = ($datas->subTotal / $datas->curr_rate) - ($datas->disAmount / $datas->curr_rate) + ($datas->ait_percent_amount / $datas->curr_rate) + ($datas->sc_percent_amount / $datas->curr_rate) + ($datas->vat_percent_amount / $datas->curr_rate);
                array_push($all_data, $datas);
            }
        }

        return response()->json(['data' => $all_data, 'success' => true], 200);
    }

    public function po_infoV2(Request $request)
    {
        // dd($request->all());
        if (Session::get('user.ses_hospital_code') == "KPJ"){
             $validated = $request->validate([
                'po_no'  => 'required',
                'store'  => 'required|integer',
            ]);
        }else{
                $validated = $request->validate([
                'po_no'  => 'required',
            ]);
        }


        if (Session::get('user.ses_hospital_code') == "KPJ") {
           $purchase_order_no_pk = DB::table('inv_purchaseorder_mst')
                ->where('purchase_uid', $request->po_no)
                ->where('store_no_fk', $request->store)
                ->value('purchaseorder_no_pk');
        }
        else {
            $purchase_order_no_pk = $request->po_no;
        }

        $query = DB::table('po_popup_list_for_grn_vw')
            ->select(
                'purchaseorder_no_pk',
                 'purchase_uid',
                'item_no_fk',
                'item_name',
                'vat_amount_itm',
                'discount_amount_itm',
                'purchase_date',
                'supplier_name',
                'total_qty',
                'vat_percent',
                'vat_amount',
                'discount_percent',
                'discount_amount',
                'total_amount',
                'po_save_option',
                'po_no',
                'total_order_qty',
                'total_delivered_qty',
                'currency_no_fk',
                'currency_sign',
                'dollar_rate',
                'ait_percent',
                'ait_amount',
                'service_charge_percent',
                'service_charge_amount',
                'purchaseorderdtl_no_pk',
                'pvms_no',
                'entry_qty',
                'item_rate',
                'supplier_no_fk',
                'store_no_fk',
                'vat_percent_itm',
                'vat_amount_itm',
                'ait_percent_itm',
                'ait_amount_itm',
                'ser_charge_percent_itm',
                'ser_charge_amount_itm',
                'discount_percent_itm',
                'discount_amount_itm',
                'uom',
                'pr_uom_conversion_qty',
                'currency_no_fk',
                'dollar_rate',
                'currency_sign',
                'item_requisition_no_fk',
                'uom_name',
                'sales_price',
                'generic_name',
                'approval_level_status_text',
                DB::raw('(NVL(total_qty, 0) - NVL(total_delivered_qty, 0)) AS available_qty')
            );


        if (!empty($request->po_no)) {
            $query->where('purchaseorder_no_pk', $purchase_order_no_pk);
        }
        if (!empty($request->store)) {
            $query->where('store_no_fk', $request->store);
        }

        if (!empty($request->store)) {
            $query->where('store_no_fk', $request->store);
        }

        $query->whereRaw("
                CAST(SUBSTR(approval_level_status_text, 1, INSTR(approval_level_status_text, '/') - 1) AS NUMBER) =
                CAST(SUBSTR(approval_level_status_text, INSTR(approval_level_status_text, '/') + 1) AS NUMBER)
            ");

        $query->orderBy('purchaseorderdtl_no_pk', 'desc');
        $data =  $query->get()->toArray();

        $all_data = [];
        foreach ($data as $item) {
            $grn_qty = ($item->total_qty == null ? 0 : $item->total_qty)  - ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);

            $datas = new stdClass();
            $datas->curr_rate = !empty($item->dollar_rate) ? $item->dollar_rate : 1;
            $datas->currency_sign = $item->currency_sign;
            $datas->store_room_no_pk = '';
            $datas->rcv_qty = $item->entry_qty;
            $datas->mainstore_su_no_fk = $item->store_no_fk;
            $datas->item_uom_name_2nd = '';
            $datas->uom_no_fk_2nd = '';
            $datas->uom_no_fk_2nd_conv_ratio = '';

            $datas->uom_no_fk_3rd = '';
            $datas->item_uom_name_3rd = '';
            $datas->uom_no_fk_3rd_conv_ratio = '';

            $datas->uom_no_fk_4th = '';
            $datas->item_uom_name_4th = '';
            $datas->uom_no_fk_4th_conv_ratio = '';

            //item level
            $datas->item_id = $item->item_no_fk;
            $datas->purchaseorderdtl_no_pk = $item->purchaseorderdtl_no_pk;
            $datas->purchaseorder_no_fk = $item->purchaseorder_no_pk;
            $datas->prdtl_no_pk = '';
            $datas->item_name = $item->item_name;
            $datas->subTotal = ($item->item_rate ) * $grn_qty;
            $datas->vat_percent_item = $item->vat_percent_itm;
            $datas->vat_percent_amount = ($item->vat_amount_itm );
            $datas->ait_percent_item = $item->ait_percent_itm;
            $datas->ait_percent_amount = ($item->ait_amount_itm );
            $datas->sc_percent_item = $item->ser_charge_percent_itm;
            $datas->sc_percent_amount = ($item->ser_charge_amount_itm );
            $datas->disPercent = $item->discount_percent_itm;
            $datas->disAmount = ($item->discount_amount_itm );
            $datas->pur_item_uom = $item->uom;
            $datas->purchase_uom_name = $item->uom_name;
            $datas->uom_conversion_qty = $item->pr_uom_conversion_qty;
            $datas->pur_item_location = '';
            $datas->qty = $item->entry_qty; //$item->available_qty;
            $datas->grn_free_qty = 0;
            $datas->temperature = '';
            $datas->temp_deg = '';
            $datas->uPrice = ($item->item_rate/$datas->curr_rate );
            $datas->item_sales_price = ($item->sales_price );
            $datas->item_cost_price = 0;
            $datas->po_qty = $item->entry_qty;
            $datas->purchase_uid = $item->purchase_uid;

            $datas->grn_qty = $grn_qty;
            $datas->receive_qty = ($item->total_delivered_qty == null ? 0 : $item->total_delivered_qty);
            // others
            $datas->purchase_date = $item->purchase_date;
            $datas->supplier_name = $item->supplier_name;
            $datas->supplier_no_fk = $item->supplier_no_fk;
            $datas->currency_no_fk = $item->currency_no_fk;
            $datas->item_requisition_no_fk = $item->item_requisition_no_fk;
            $datas->totalAmount = ($datas->subTotal - $datas->disAmount ) + ($datas->ait_percent_amount  + $datas->sc_percent_amount  + $datas->vat_percent_amount );
            // dd($datas->subTotal,$datas->curr_rate );
            // $datas->totalAmount = ($datas->subTotal / $datas->curr_rate) - ($datas->disAmount / $datas->curr_rate) + ($datas->ait_percent_amount / $datas->curr_rate) + ($datas->sc_percent_amount / $datas->curr_rate) + ($datas->vat_percent_amount / $datas->curr_rate);
            $datas->generic_name=$item->generic_name;
            array_push($all_data, $datas);
        }

        // dd( $all_data );
        return response()->json(['data' => $all_data, 'success' => true], 200);
    }

    public function grnWorklistV1()
    {
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_uid', 'supplier_name', 'company_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $mainStore = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            // ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        return Template::loadView("admin.inventory.v1.grn.grn_worklist_v2", [
            "allSuppliers" => $allSuppliers,
            'mainStore' => $mainStore
        ]);
    }
    public function deleteGrn(Request $request){
        $grnId=$request->grnId;
        try {
            if ($request->grnType =="DRAFT") {
                $grnDtlId=  DB::table('phr_itemreceivedtl')->select('itemreceivedtl_no_pk')->where('itemreceive_no_fk',$grnId)->pluck('itemreceivedtl_no_pk');
                $deleteAsset= DB::table('fas_assetregister')->whereIn('itemreceivedtl_no_fk', $grnDtlId)->delete();
                $deleteDtl=  DB::table('phr_itemreceivedtl')->where('itemreceive_no_fk',$grnId)->delete();

                if ( $deleteDtl) {
                    $deleteMst=  DB::table('phr_itemreceivemst')->where('rcv_save_option','DRAFT')->where('itemreceive_no_pk',$grnId)->delete();
                }
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => $grnId . ' GRN Deleted Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'code' => 422,
                    'message' => $grnId . ' GRN is Not DRAFT'
                ], 422);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => $grnId . ' GRN Not Deleted',
                'error' => $th->getMessage() // optional: helpful for debugging
            ], 500);
        }
    }
    public function deleteIndnet(Request $request){
        $indentId=$request->indentId;
        try {
                $deleteApproval=DB::table('sysc_approvalprocess')->where('approval_for_code','INDENT')->where('primary_key_value',$indentId)->delete();
                if ($deleteApproval) {
                    $deleteMst=  DB::table('inv_requisitionmst')->where('indent_save_option','POST')->where('inv_requisition_no_pk',$indentId)->update(['cancel_ind'=>1,'cancel_by'=>Auth::id(),'cancel_date'=>date('Y-m-d H:i')]);

                    return response()->json([
                        'status' => true,
                        'code' => 200,
                        'message' => $indentId . ' Indent Deleted Successfully'
                    ], 200);
                }else{
                    return response()->json([
                        'status' => false,
                        'code' => 422,
                        'message' => $indentId . ' Indent is Not DRAFT'
                    ], 422);
                }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => $indentId . ' Indent Not Deleted',
                'error' => $th->getMessage() // optional: helpful for debugging
            ], 500);
        }
    }
    public function pendingPoList()
    {
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_uid', 'supplier_name', 'company_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $mainStore = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            // ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        return Template::loadView("admin.inventory.v1.po.pending_po_list", [
            "allSuppliers" => $allSuppliers,
            'mainStore' => $mainStore
        ]);
    }




    public function getSearchGRNWorkListV2(Request $request)
    {

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $data = DB::table('phr_v1_grn_vw')
            ->selectRaw('
                        currency_sign,
                        itemreceive_no_pk,
                        inv_requisition_po_no_fk,
                        po_no,
                        challan_date,
                        currency_rate,
                        currency_name,
                        receive_date,
                        supplier_name,
                        user_fullname_entry_by,
                        rcv_save_option,
                        COUNT(item_no_fk) AS item_q,
                        SUM(vat_amount_itm) AS vat_amount,
                        SUM(ait_amount_itm) AS ait_amount,
                        SUM(SER_CHARGE_AMOUNT_ITM) AS service_charge_amount,
                        SUM(discount_amount_itm) AS discount_amount,
                        SUM(unit_price * delivered_qty) AS total_purchase_amount,
                        itemreceive_uid,
                         purchase_uid
                         ')
            ->where('au_entry_hospital_no_fk', $hospital_id);

        if (!empty($request->po_no)) {

            if (Session::get('user.ses_hospital_code') == "KPJ") {
                $data->where('purchase_uid', $request->po_no);
            } else {
                $data->where('po_no', $request->po_no);
            }
        }

        if (!empty($request->grn_no)) {

            if (Session::get('user.ses_hospital_code') == "KPJ") {
                $data->where('itemreceive_uid', $request->grn_no);
            } else {
                 $data->where('itemreceive_no_pk', $request->grn_no);
            }
        }

        if (!empty($request->main_store)) {
            $data->where('store_su_no_fk', $request->main_store);
        }
        if (!empty($request->supplier_id)) {
            $data->where('supplier_no_fk', $request->supplier_id);
        }
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $data->whereBetween('receive_date', [$from_date, $to_date]);
        } else if (!empty($request->from_date)) {
            $data->where('receive_date', $from_date);
        } else if (!empty($request->to_date)) {
            $data->where('receive_date', $to_date);
        }


        $data = $data->groupBy(
            'currency_sign',
            'itemreceive_no_pk',
            'inv_requisition_po_no_fk',
            'po_no',
            'challan_date',
            'currency_rate',
            'currency_name',
            'receive_date',
            'supplier_name',
            'user_fullname_entry_by',
            'rcv_save_option',
            'itemreceive_uid',
            'purchase_uid'
        )
            ->orderByDesc('itemreceive_no_pk')
            ->get();

        return response()->json(['data' => $data, 'success' => true]);
    }

    public function getGRNWorkListPDF(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        $hospitalCode = $po_hospital_details->hospital_code;

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));

        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }
// itemreceive_uid

// purchase_uid


        $data = DB::table('phr_v1_grn_vw')
            ->selectRaw('currency_sign,purchase_uid, itemreceive_uid, vat_amount,ait_amount,service_charge_amount, itemreceive_no_pk, po_no, challan_date, currency_rate, currency_name, receive_date, supplier_name, user_fullname_entry_by, discount_amount, rcv_save_option, COUNT(item_no_fk) AS item_q, SUM(purchase_price * delivered_qty) AS total_purchase_amount')
            ->where('au_entry_hospital_no_fk', $hospital_id);

        if (!empty($request->po_no)) {
                if ($hospitalCode === "KPJ") {
                    $data->where('purchase_uid', $request->po_no);
                } else {
                    $data->where('purchaseorder_no_pk', $request->po_no);
                    }
                }

        if (!empty($request->grn_no)) {
                if ($hospitalCode === "KPJ") {
                    $data->where('itemreceive_uid', $request->grn_no);
                } else {
                    $data->where('itemreceive_no_pk', $request->grn_no);
                    }
                }

        if (!empty($request->main_store)) {
            $data->where('store_su_no_fk', $request->main_store);
        }

        if (!empty($request->supplier_id)) {
            $data->where('supplier_no_fk', $request->supplier_id);
        }

        if (!empty($request->from_date) && !empty($request->to_date)) {
            $data->whereBetween('receive_date', [$from_date, $to_date]);
        } else if (!empty($request->from_date)) {
            $data->where('receive_date', $from_date);
        } else if (!empty($request->to_date)) {
            $data->where('receive_date', $to_date);
        }

        $data = $data->groupBy('purchase_uid', 'itemreceive_uid','currency_sign', 'vat_amount', 'ait_amount', 'service_charge_amount', 'itemreceive_no_pk', 'po_no', 'challan_date', 'currency_rate', 'currency_name', 'receive_date', 'supplier_name', 'user_fullname_entry_by', 'discount_amount', 'rcv_save_option')
            ->orderByDesc('itemreceive_no_pk')
            ->get();

        if ($request->report_type == 'PDF') {
            $pdf = PDF::loadView("admin.inventory.v1.grn.report", ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
            return $pdf->stream("GRN Worklist.pdf", array("Attachment" => false));
        } else {
            $pdf = ["data" => $data, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo, 'from_date' => $from_date, 'to_date' => $to_date];

            $fileToExport = "GRN Worklist Excel";
            $html = View("admin.inventory.v1.grn.excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }
    }

    public function prPendingOrPartialReport()
    {

        $mainStore = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        //F:\xampp\htdocs\h360\resources\views\admin\inventory\v1\PR\pr_pending_or_partial_worklist.blade.php
        return Template::loadView("admin.inventory.v1.PR.pr_pending_or_partial_worklist", [
            "mainStore" => $mainStore,
        ]);
    }


    public function getSearchprPendingOrPartialReport(Request $request)
    {
        //  dd($request);

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $pr_status_id = $request->pr_status_id;
        // dd($pr_status_id);
        $pr_no = $request->pr_no;
        //  dd($pr_no);
        $mainstore_id = $request->mainstore_id;
        //  dd($pr_status_id);
        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $data = DB::table('pr_pendig_parcial_report_vw')
            ->select(
                'pr_no',
                'pr_date',
                'pr_dtl_no',
                'item_no_fk',
                'item_name',
                'uom_no_fk',
                'uom_name',
                'main_store_no',
                'main_store_name',
                'pr_qty',
                'po_ind',
                'indent_no',
                'approval_status',
                'app_status',
                'po_qty',
                'grn_qty',
                'pr_status'
            )
            ->where('main_store_no', $request->mainstore_id);
        if ($request->from_date != '' && $request->to_date != '') {
            $data = $data->whereRaw("PR_DATE between TO_DATE(?, 'YYYY-MM-DD') and TO_DATE(?, 'YYYY-MM-DD')", [$from_date, $to_date]);
        }
        if ($pr_no != '') {
            $data =  $data->where('pr_no', $pr_no);;
        }


        switch ($pr_status_id) {
                // case 1: // No specific status selected, return all
                //     $data = $data;
                //     break;
            case 2:
                $data = $data->where('pr_status', $pr_status_id);
                break;
            case 3:
                $data = $data->where('pr_status', $pr_status_id);
                break;
            case 4:
                $data = $data->whereIn('pr_status', [2, 3]);
                break;
            default:
                return response()->json(['error' => 'Invalid pr_status_id'], 400);
        }

        $data = $data->get();
        // dd($data);
        return response()->json(['data' => $data, 'success' => true]);
    }


    public function prPendingOrPartialReportDownload(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        $pr_status_id = $request->pr_status_id;
        $pr_no = $request->pr_no;
        $mainstore_id = $request->mainstore_id;

        if (!empty($request->from_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
            $from_date = $dateTime->format('Y-m-d');
        }

        if (!empty($request->to_date)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
            $to_date = $dateTime->format('Y-m-d');
        }

        $data = DB::table('pr_pendig_parcial_report_vw')
            ->select(
                'pr_no',
                'pr_date',
                'pr_dtl_no',
                'item_no_fk',
                'item_name',
                'uom_no_fk',
                'uom_name',
                'main_store_no',
                'main_store_name',
                'pr_qty',
                'po_ind',
                'indent_no',
                'approval_status',
                'app_status',
                'po_qty',
                'grn_qty',
                'pr_status'
            )
            ->where('main_store_no', $request->mainstore_id);
        if ($request->from_date != '' && $request->to_date != '') {
            $data = $data->whereRaw("PR_DATE between TO_DATE(?, 'YYYY-MM-DD') and TO_DATE(?, 'YYYY-MM-DD')", [$from_date, $to_date]);
        }
        if ($pr_no != '') {
            $data =  $data->where('pr_no', $pr_no);;
        }
        switch ($pr_status_id) {
                // case 1:
                //     $data = $data;
                //     break;
            case 2:
                $data = $data->where('pr_status', $pr_status_id);
                break;
            case 3:
                $data = $data->where('pr_status', $pr_status_id);
                break;
            case 4:
                $data = $data->whereIn('pr_status', [2, 3]);
                break;
            default:
                return response()->json(['error' => 'Invalid pr_status_id'], 400);
        }

        $datas = $data->get()->toArray();
        $title = '';
        if ($pr_status_id == 1) {
            $title = 'All';
        } else if ($pr_status_id == 2) {
            $title = 'Pending';
        } else if ($pr_status_id == 2) {
            $title = 'Partial';
        } else if ($pr_status_id == 2) {
            $title = 'Pending & Partial';
        }

        // $title = match ($pr_status_id) {
        //     1 => 'All';
        //     2 => 'Pending',
        //     3 => 'Partial',
        //     4 => 'Pending & Partial',
        // };
        $html = view("admin.inventory.v1.PR.pr_pending_partial_download", compact('datas', 'from_date', 'to_date', 'title'));
        $fileToExport = 'pr_pending_partial.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }



    public function grnPOSTV2($grn_id)
    {
        $grn = $this->getLookupListByCode("GRNTYPE");
        $suppiler_arr = $this->getSupplier();
        $main_store_list = $this->mainStore();
        $currency = $this->getCurrency();

        $main_store_list_all = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $asset_location = DB::table("sysc_room")
            ->select('room_no_pk', 'room_code', 'room_name')
            ->where('store_location_ind', 1)
            ->orWhere('open_location_ind', 1)
            ->orWhere('asset_location_ind', 1)
            ->get();


        $conversion_service_item = DB::table('sysc_serviceitem_uom')
            ->select(
                'uom_no_pk',
                'uom_code',
                'uom_label_desc',
                'parent_uom_no_pk',
                'status',
                'default_uom',
                'uom_type',
            )
            ->where('status', 1)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $grn_details_info = DB::select(DB::raw(
            "select
                                    currency_name,
                                    currency_rate,
                                    itemreceive_no_pk,
                                    item_name,
                                    uom_name,
                                    order_qty,
                                    sum(delivered_qty) delivered_qty,
                                    sum(rec_qty) rec_qty,
                                    discount_amount,
                                    discount_percent,vat_percent,
                                    vat_amount,
                                    sum(delivered_qty+freeitem_qty) total_qty,
                                    sum(delivered_qty*unit_price) amount,
                                    freeitem_qty,
                                    free_uom_name,
                                    unit_price,
                                    supplier_name,
                                    po_no,
                                    purchase_date,
                                    challan_date,
                                    challan_no,
                                    department,
                                    delivery_location,
                                    challan_date,
                                    receive_date,
                                    user_fullname_entry_by ,
                                    rcv_save_option,
                                    grninv_requisitiondtl_po_no_fk as inv_requisitiondtl_no_pk,
                                    store_su_no_fk,
                                    po_by_name,
                                    pr_no,
                                    inv_requisitionmst_po_no_pk,
                                    service_charge_percent,
                                    service_charge_amount,
                                    ait_percent,
                                    ait_amount,
                                    currency_sign,
                                    item_no_fk,
                                    au_update_at,
                                    purchaseorderdtl_no_pk,
                                    itemreceivedtl_no_pk,
                                    entry_serial,
                                    pr_uom_conversion_qty,
                                    price,
                                    uom,
                                    currency_no_fk,
                                    temperature,
                                    expireable,
                                    purchase_price,
                                    sales_price,
                                    cost_price,
                                    store_room_no_pk,
                                    discount_percent_itm,
                                    discount_amount_itm,
                                    vat_percent_itm,
                                    vat_amount_itm,
                                    ait_percent_itm,
                                    ait_amount_itm,
                                    ser_charge_percent_itm,
                                    ser_charge_amount_itm,
                                    batch_no,
                                    au_entry_at,
                                    generic_name

                                    from phr_v1_grn_vw where itemreceive_no_pk = $grn_id

                                    group by
                                    currency_name,
                                    currency_rate,
                                    itemreceive_no_pk,
                                    item_name,
                                    uom_name,
                                    order_qty,
                                    freeitem_qty,
                                    free_uom_name,
                                    unit_price,
                                    discount_amount,
                                    discount_percent,
                                    vat_percent,
                                    vat_amount,
                                    supplier_name,
                                    po_no,
                                    purchase_date,
                                    challan_date,
                                    challan_no,
                                    department,
                                    delivery_location,
                                    challan_date,
                                    receive_date,
                                    user_fullname_entry_by ,
                                    rcv_save_option,
                                    grninv_requisitiondtl_po_no_fk,
                                    store_su_no_fk,
                                    po_by_name,pr_no,
                                    inv_requisitionmst_po_no_pk,
                                    service_charge_percent,
                                    service_charge_amount,
                                    ait_percent,
                                    ait_amount,
                                    currency_sign,
                                    item_no_fk,
                                    au_update_at,
                                    purchaseorderdtl_no_pk,
                                    itemreceivedtl_no_pk,
                                    entry_serial,
                                    pr_uom_conversion_qty,
                                    price,
                                    uom,
                                    currency_no_fk,
                                    temperature,
                                    expireable,
                                    purchase_price,
                                    sales_price,
                                    cost_price,
                                    store_room_no_pk,
                                    discount_percent_itm,
                                    discount_amount_itm,
                                    vat_percent_itm,
                                    vat_amount_itm,
                                    ait_percent_itm,
                                    ait_amount_itm,
                                    ser_charge_percent_itm,
                                    ser_charge_amount_itm,
                                    batch_no,
                                    au_entry_at,
                                    generic_name
                                    order By entry_serial asc"
        ));

        //    dd($grn_details_info);

        $save_option = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $grn_id)->value('rcv_save_option');
        // if($save_option == 'POST' || count($grn_details_info) == 0){
        //     return view("admin.components.error_alert");
        // }

        $grn_batch_info = DB::select(DB::raw("SELECT poc.itemreceivedtl_no_pk, poc.item_no_fk, poc.item_qty/poc.pr_uom_conversion_qty as item_qty, poc.expiry_date,poc.batch_no
                            FROM phr_itemreceivedtl poc
                            WHERE poc.ITEMRECEIVE_NO_FK = $grn_id
                            and poc.batch_no is not  null
                            order By poc.itemreceive_no_fk"));



        // dd($grn_batch_info);
        $grn_mst = DB::table('phr_itemreceivemst')->select(
            'phr_itemreceivemst.*',
            'hrms_personnel.full_name as full_name',
            'hrms_personnel2.full_name as cash_purchase_by_name',
            'hrms_personne3.full_name as inspected_by_name',
            'hrms_personne4.full_name as received_by_name',
        )
            ->leftjoin('hrms_personnel', 'phr_itemreceivemst.received_by_person_no_fk', '=', 'hrms_personnel.person_no_pk')
            ->leftjoin('hrms_personnel as hrms_personnel2', 'phr_itemreceivemst.cash_purchase_by', '=', 'hrms_personnel2.person_no_pk')
            ->leftjoin('hrms_personnel as hrms_personne3', 'phr_itemreceivemst.inspected_by', '=', 'hrms_personne3.person_no_pk')
            ->leftjoin('hrms_personnel as hrms_personne4', 'phr_itemreceivemst.received_by', '=', 'hrms_personne4.person_no_pk')
            ->where('itemreceive_no_pk', $grn_id)->first();



        $targetDate = new DateTime($grn_mst->receive_date);
        $currentDate = new DateTime();
        $currentDateFormat = $currentDate->format('Y-m-d');

        // if ($targetDate->format('Y-m-d') != $currentDateFormat) {
        //     if($save_option != "DRAFT"){
        //         return view("admin.components.error_alert");
        //     }
        // }
        return Template::loadView("admin.inventory.v1.grn.post_item_receive_grn_v2", [
            'grn_list' => $grn,
            'allSuppliers' => $suppiler_arr,
            'main_store_list' => $main_store_list,
            'main_store_list_all' => $main_store_list_all,
            'asset_location' => $asset_location,
            'currency' => $currency,
            'grn_mst' => $grn_mst,
            'grn_details_info' => $grn_details_info,
            'grn_batch_info' => $grn_batch_info,
            'grn_mst' => $grn_mst,
            'conversion_service_item' => $conversion_service_item
        ]);
    }


    public function updateGRNOrderv2(Request $request)
    {

        //  dd($request->all());

        $request->validate([
            'currency' =>  'required',
            'curr_rate' =>  'required',
            'main_store_id' =>  'required',
            'supplier' =>  'required',
            'grn_type' =>  'required',
            'grn_date' =>  'required',
            'challan_date' =>  'required',
            'invoice_no' =>  'required',
        ]);

       if (isset($request->po_no)) {
            if (Session::get('user.ses_hospital_code') == "KPJ") {
                $po_id_query = DB::table('inv_purchaseorder_mst')
                    ->where('purchase_uid', $request->po_no)
                    ->where('store_no_fk', $request->main_store_id)
                    ->value('purchaseorder_no_pk');
            } else {
                $po_id_query = $request->po_no;
            }
        } else {
            $po_id_query = null;
        }

        try {
            $grn_no = $request->grn_no;
            $postStatus = DB::table('phr_v1_grn_vw')->select('rcv_save_option')->where('itemreceive_no_pk', $grn_no)->first();

            if ($postStatus->rcv_save_option == 'POST') {
                return response()->json(['success' => false, 'message' => 'Already Posted'], 422);
            }


            $out_purchase_no_pk = '';
            DB::beginTransaction();
            $grn_type = $request->grn_type;
            $grn_date = !empty($request->grn_date) ? date("Y-m-d", strtotime($request->grn_date)) : '';
            // $grn_date = null;
            $requisition_po_no_pk = $request->pr_prev_no;
            $delivery_order_no = $request->delivery_no;
            $invoice_number = $request->invoice_no;
            $challan_date = !empty($request->challan_date) ? date("Y-m-d", strtotime($request->challan_date)) : '';
            // $challan_date =  null;
            $gate_entry = $request->gate_entry_no;
            $zero = 0;
            $null = null;
            $received_by = $request->received_by;
            $inspected_by = $request->inspected_by;
            $main_store_id = $request->main_store_id;
            $po_no = isset($request->po_no) ? intval($po_id_query) : 0;
            $supplier = $request->supplier;
            $vat_percent = isset($request->vat_percent) ? $request->vat_percent : 0;
            $vat_amount = isset($request->vat_amount) ? $request->vat_amount : 0;
            $po_amount = $request->po_amount;
            $discount_percent = isset($request->gross_discount_percent) ? $request->gross_discount_percent : 0;
            $discount_amount = isset($request->gross_discount_amount) ? $request->gross_discount_amount : 0;
            $main_store_module = ServiceUnit::where('main_store_ind', 1)->where('serviceunit_no_pk', $request->main_store_id)->value('main_store_module_no_fk');
            $main_store_module = !empty($main_store_module) ? $main_store_module : 0;
            $remarks = $request->remarks;

            $grand_ait_percent = $request->gross_ait_percent;
            $grand_ait_amount =  $request->gross_ait_amount;
            $grand_sc_percent =  $request->gross_sc_percent;
            $granc_sc_amount =   $request->gross_sc_amount;

            $po_date =  !empty($request->po_date) ? date("Y-m-d", strtotime($request->po_date)) : '';
            $po_amount = $request->po_amount;
            $gate_entry_no = $request->gate_entry_no;
            $bill_amount = $request->bill_amount;
            $bill_date = !empty($request->bill_date) ? date("Y-m-d", strtotime($request->bill_date)) : '';
            $po_date = !empty($request->po_date) ? date("Y-m-d", strtotime($request->po_date)) : '';
            $gate_entry_by = $request->gate_entry_by;
            $received_by = $request->received_by_hdn;
            $inspected_by = $request->inspected_by_hdn;

            $invoice_no = $request->invoice_no;

            $purchase_type_no = $request->purchase_type;
            $cash_purchase_by  = $request->cash_purchase_by_hdn;
            $cash_purchase_date  = !empty($request->cash_purchase_date) ? date("Y-m-d", strtotime($request->cash_purchase_date)) : '';;


            $rcv_save_option = $request->post_draft;

            $attachment = "";
            if ($request->grn_attachment_ind == 1) {
                $image1 = public_path('images/uploads/attachment/') . '/' . $request->old_image;
                if (file_exists($image1)) {
                    @unlink($image1);
                }
            } else {
                $grn_image = DB::table('phr_itemreceivemst')->where('itemreceive_no_pk', $grn_no)->value('bill_image');
                $attachment = $grn_image;
            }

            if ($request->hasFile('attachment')) {
                $files = $request->file('attachment');
                $attachment = date('Ymdhi') . "." . $files->getClientOriginalExtension();
                $request->attachment->move(public_path('/images/uploads/attachment'), $attachment);
            }

            $free_qty = [];
            $item_id = [];
            $numelems = 500;
            $batch_no = [];
            $exp_date = [];
            $pvmsno = [];
            $rcv_qty = [];
            $purchase_uom_no_pk = [];
            $purchase_price = [];
            $cost_price = [];
            $item_sl = [];
            $item_remarks = [];
            $conversion_qty = [];
            $in_purchaseorderdtl_no_pk = [];
            $in_inv_requisitiondtl_no_pk = [];
            $in_temperature = [];
            $in_store_room_no_pk = [];
            $inv_requisitiondtl_po_no_fk = [];
            $sales_price = [];
            $cost_price = [];
            $purchase_uom_name = [];
            $batch_item_qty = [];
            $empty = [];
            $pvmsno = [];
            $in_vat_percent_itm = [];
            $in_vat_amount_itm = [];
            $in_discount_percent_itm = [];
            $in_discount_amount_itm = [];

            $in_purchaseorderdtl_no_pk = [];
            $in_purchaseorder_no_pk = [];
            $in_inv_requisitiondtl_no_pk = [];

            $in_temperature = [];
            $in_store_room_no_pk = [];
            $inv_requisitiondtl_po_no_fk = [];

            $currency_fk = [];
            $currency_rate = [];
            $in_ait_percent_itm = [];
            $in_ait_amount_itm = [];
            $in_sc_percent_itm = [];
            $in_sc_amount_itm = [];
            $in_margin_percent = [];

            // array requested data
            $batchData = json_decode($request->batchData);
            $count = 0;
            foreach ($batchData as $key => $item) {
                if (in_array($key, $request->item_count_ind)) {
                    foreach (json_decode($item)->batch as $key2 => $item2) {

                        $exp_dates = json_decode($item)->date[$key2];
                        $batch_qty = json_decode($item)->batch_qty[$key2];
                        $batch = $item2;
                        $index = array_search($key, $request->item_count_ind);

                        $item_exp_date = !empty($exp_dates) ? strval(date('dmY', strtotime($exp_dates))) : null;

                        // dd(intval($request->item_id[$index]),$item_exp_date);
                        $currency_fk[$count] = $request->currency;
                        $currency_rate[$count] = $request->curr_rate;

                        $item_sl[$count] =  isset($request->po_sl[$index]) ? intval($request->po_sl[$index]) : 1;
                        // $item_sl[$count] = $count;
                        $item_id[$count] =  intval($request->item_id[$index]);
                        $batch_no[$count] = !empty($batch) ? $batch : $null;
                        $exp_date[$count] = $item_exp_date;
                        $rcv_qty[$count] =  isset($batch_qty) ? floatval($batch_qty) : floatval($request->qty[$index]);
                        $free_qty[$count] =  isset($request->grn_free_qty[$index]) ? floatval($request->grn_free_qty[$index]) : 0;
                        $purchase_price[$count] = isset($request->uPrice[$index]) ? floatval($request->uPrice[$index]) : 0;
                        $sales_price[$count] = isset($request->item_sales_price[$index]) ? floatval($request->item_sales_price[$index]) : 0;
                        $cost_price[$count] = isset($request->item_cost_price[$index]) ? floatval($request->item_cost_price[$index]) : 0;
                        $in_margin_percent[$count] = isset($request->margin_percnt[$index]) ? floatval($request->margin_percnt[$index]) : 0;

                        $purchase_uom_no_pk[$count] = isset($request->pur_item_uom[$index]) ? intval($request->pur_item_uom[$index]) : null;
                        $purchase_uom_name[$count] = isset($request->purchase_uom_name[$index]) ? $request->purchase_uom_name[$index] : null;
                        $conversion_qty[$count] = isset($request->item_conv_qty[$index]) ? floatval($request->item_conv_qty[$index]) : 1;
                        $batch_item_qty[$count] = isset($batch_qty) ? floatval($batch_qty) : floatval($request->qty[$index]);
                        $empty[$count] = 1;
                        $pvmsno[$count] = $null;
                        $item_remarks[$count] = null;

                        $in_vat_percent_itm[$count] = isset($request->vat_percent_item[$index]) ? floatval($request->vat_percent_item[$index]) : 0;
                        $in_vat_amount_itm[$count] = isset($request->vat_percent_amount[$index]) ? floatval($request->vat_percent_amount[$index]) : 0;
                        $in_discount_percent_itm[$count] = isset($request->disPercent[$index]) ? floatval($request->disPercent[$index]) : 0;
                        $in_discount_amount_itm[$count] = isset($request->disAmount[$index]) ? floatval($request->disAmount[$index]) : 0;

                        $in_ait_percent_itm[$count] = isset($request->ait_percent_item[$index]) ? floatval($request->ait_percent_item[$index]) : 0;
                        $in_ait_amount_itm[$count] = isset($request->ait_percent_amount[$index]) ? floatval($request->ait_percent_amount[$index]) : 0;
                        $in_sc_percent_itm[$count] = isset($request->sc_percent_item[$index]) ? floatval($request->sc_percent_item[$index]) : 0;
                        $in_sc_amount_itm[$count] = isset($request->sc_percent_amount[$index]) ? floatval($request->sc_percent_amount[$index]) : 0;

                        $in_purchaseorderdtl_no_pk[$count] = isset($request->purchaseorderdtl_no_pk[$index]) ? $request->purchaseorderdtl_no_pk[$index] : 0;
                        $in_purchaseorder_no_pk[$count] = isset($request->purchaseorder_no_fk[$index]) ? $request->purchaseorder_no_fk[$index] : 0;
                        $in_inv_requisitiondtl_no_pk[$count] = 0;
                        $in_temperature[$count] = isset($request->temperature[$index]) ? $request->temperature[$index] : null;
                        $in_store_room_no_pk[$count] = isset($request->pur_item_location[$index]) ? intval($request->pur_item_location[$index]) : 0;
                        $inv_requisitiondtl_po_no_fk[$count] = isset($request->prdtl_no_pk[$index]) ? $request->prdtl_no_pk[$index] : 0;
                        $count++;
                    }
                }
            }



            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = intval(Session::get('user.ses_hospital_no_pk'));
            $out_itemreceive_no_pk = $out_itemreceive_uid = $out_error = 0;

            $pdo = DB::getPdo();
            $receive_items = $pdo->prepare("begin pkg_v2_inventory_all.prc_itemreceive_ms_v1(
                                            :in_itemreceive_no_pk,
                                            :in_grn_type,
                                            :in_grn_date,
                                            :in_inv_requisition_po_no_pk,
                                            :in_delivery_order,
                                            :in_challan_no,
                                            :in_challan_date,
                                            :in_gate_entry_number,
                                            :in_fiscal_year,
                                            :in_year_quarter,
                                            :in_received_by_person_no_fk,
                                            :in_inspected_by_person_no_fk,
                                            :in_store_su_no_fk,
                                            :in_demand_no_fk,
                                            :in_supplier_no_fk,
                                            :in_vat_percent,
                                            :in_vat_amount,
                                            :in_discount_percent,
                                            :in_discount_amount,
                                            :in_module_no_fk,
                                            :in_requisition_no_fk,
                                            :in_requisition_code,
                                            :in_purchaseorder_no_pk,
                                            :in_notes,
                                            :in_bill_image,
                                            :in_return_amt,
                                            :in_return_note,
                                            :in_rcv_save_option,
                                            :in_ait_percent,
                                            :in_ait_amount,
                                            :in_service_charge_percent,
                                            :in_service_charge_amount,

                                            :in_po_date,
                                            :in_po_amount,
                                            :in_gate_entry_no,
                                            :in_bill_amount,
                                            :in_bill_date,
                                            :in_gate_entry_by,
                                            :in_received_by,
                                            :in_inspected_by,
                                            :in_purchase_type_no,
                                            :in_cash_purchase_by,
                                            :in_cash_purchase_date ,
                                            :in_bill_or_invoice_no,
                                            :in_a_item_no_fk,
                                            :in_item_batch_fk,
                                            :in_item_expiry_dt,
                                            :in_a_item_pvmsno,
                                            :in_a_item_qty,
                                            :in_a_item_uom,
                                            :in_a_freeitem_qty,
                                            :in_a_freeitem_uom,
                                            :in_a_item_price ,
                                            :in_item_sales_price,
                                            :in_a_item_cost_price ,
                                            :in_a_entry_serial_dtl ,
                                            :in_item_remarks,
                                            :in_pr_uom_no_fk ,
                                            :in_pr_uom_conversion_qty ,
                                            :in_pr_uom_tradeprice ,
                                            :in_vat_percent_itm,
                                            :in_vat_amount_itm,
                                            :in_discount_percent_itm,
                                            :in_discount_amount_itm,
                                            :in_purchaseorderdtl_no_pk,
                                            :in_inv_requisitiondtl_no_pk,
                                            :in_temperature,
                                            :in_store_room_no_pk,
                                            :in_inv_requisitiondtl_po_no_fk,

                                            :in_currency_no_fk,
                                            :in_currency_rate,
                                            :in_ait_percent_itm,
                                            :in_ait_amount_itm,
                                            :in_ser_charge_percent_itm,
                                            :in_ser_charge_amount_itm,
                                            :in_margin_percnt,

                                            :in_au_entry_by,
                                            :in_au_entry_session,
                                            :in_au_entry_hospital_no_fk,
                                            :out_itemreceive_no_pk,
                                            :out_itemreceive_uid,
                                            :out_error
                                    ); end;");
            $receive_items->bindparam('in_itemreceive_no_pk', $grn_no);
            $receive_items->bindparam('in_grn_type', $grn_type);
            $receive_items->bindparam('in_grn_date', $grn_date);
            $receive_items->bindparam('in_inv_requisition_po_no_pk', $requisition_po_no_pk);
            $receive_items->bindparam('in_delivery_order', $delivery_order_no);
            $receive_items->bindparam('in_challan_no', $invoice_number);
            $receive_items->bindparam('in_challan_date', $challan_date);
            $receive_items->bindparam('in_gate_entry_number', $gate_entry);
            $receive_items->bindparam('in_fiscal_year', $zero);
            $receive_items->bindparam('in_year_quarter', $null);
            $receive_items->bindparam('in_received_by_person_no_fk', $received_by);
            $receive_items->bindparam('in_inspected_by_person_no_fk', $inspected_by);
            $receive_items->bindparam('in_store_su_no_fk', $main_store_id);
            $receive_items->bindparam('in_demand_no_fk', $po_no);
            $receive_items->bindparam('in_supplier_no_fk', $supplier);
            $receive_items->bindparam('in_vat_percent', $vat_percent);
            $receive_items->bindparam('in_vat_amount', $vat_amount);
            $receive_items->bindparam('in_discount_percent', $discount_percent);
            $receive_items->bindparam('in_discount_amount', $discount_amount);
            $receive_items->bindparam('in_module_no_fk', $main_store_module);
            $receive_items->bindparam('in_requisition_no_fk', $zero);
            $receive_items->bindparam('in_requisition_code', $null);
            $receive_items->bindparam('in_purchaseorder_no_pk', $po_no);
            $receive_items->bindparam('in_notes', $remarks);
            $receive_items->bindparam('in_bill_image', $attachment);
            $receive_items->bindparam('in_return_amt', $zero);
            $receive_items->bindparam('in_return_note', $null);
            $receive_items->bindparam('in_rcv_save_option', $rcv_save_option);
            $receive_items->bindparam('in_ait_percent', $grand_ait_percent);
            $receive_items->bindparam('in_ait_amount', $grand_ait_amount);
            $receive_items->bindparam('in_service_charge_percent', $grand_sc_percent);
            $receive_items->bindparam('in_service_charge_amount', $granc_sc_amount);

            $receive_items->bindparam('in_po_date', $po_date);
            $receive_items->bindparam('in_po_amount', $po_amount);
            $receive_items->bindparam('in_gate_entry_no', $gate_entry_no);
            $receive_items->bindparam('in_bill_amount', $bill_amount);
            $receive_items->bindparam('in_bill_date', $bill_date);
            $receive_items->bindparam('in_gate_entry_by', $gate_entry_by);
            $receive_items->bindparam('in_received_by', $received_by);
            $receive_items->bindparam('in_inspected_by', $inspected_by);

            $receive_items->bindparam('in_purchase_type_no', $purchase_type_no);
            $receive_items->bindparam('in_cash_purchase_by', $cash_purchase_by);
            $receive_items->bindparam('in_cash_purchase_date', $cash_purchase_date);
            $receive_items->bindparam('in_bill_or_invoice_no', $invoice_no);

            $receive_items->bindArray('in_a_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_batch_fk', $batch_no, count($batch_no), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_item_expiry_dt', $exp_date, count($exp_date), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_pvmsno', $pvmsno, count($pvmsno), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $rcv_qty, count($rcv_qty), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_qty', $free_qty, count($free_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_freeitem_uom', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_price', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_item_sales_price', $sales_price, count($sales_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_item_cost_price', $cost_price, count($cost_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_sl, count($item_sl), $numelems, SQLT_INT);
            $receive_items->bindArray('in_item_remarks', $item_remarks, count($item_remarks), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_pr_uom_no_fk', $purchase_uom_no_pk, count($purchase_uom_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_conversion_qty', $conversion_qty, count($conversion_qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_pr_uom_tradeprice', $purchase_price, count($purchase_price), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_percent_itm', $in_vat_percent_itm, count($in_vat_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_vat_amount_itm', $in_vat_amount_itm, count($in_vat_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_percent_itm', $in_discount_percent_itm, count($in_discount_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_discount_amount_itm', $in_discount_amount_itm, count($in_discount_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_purchaseorderdtl_no_pk', $in_purchaseorderdtl_no_pk, count($in_purchaseorderdtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_temperature', $in_temperature, count($in_temperature), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_store_room_no_pk', $in_store_room_no_pk, count($in_store_room_no_pk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_inv_requisitiondtl_po_no_fk', $inv_requisitiondtl_po_no_fk, count($inv_requisitiondtl_po_no_fk), $numelems, SQLT_INT);

            $receive_items->bindArray('in_currency_no_fk', $currency_fk, count($currency_fk), $numelems, SQLT_INT);
            $receive_items->bindArray('in_currency_rate', $currency_rate, count($currency_rate), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ait_percent_itm', $in_ait_percent_itm, count($in_ait_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ait_amount_itm', $in_ait_amount_itm, count($in_ait_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ser_charge_percent_itm', $in_sc_percent_itm, count($in_sc_percent_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_ser_charge_amount_itm', $in_sc_amount_itm, count($in_sc_amount_itm), $numelems, SQLT_FLT);
            $receive_items->bindArray('in_margin_percnt', $in_margin_percent, count($in_margin_percent), $numelems, SQLT_FLT);

            // dd($receive_items);
            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindParam('out_itemreceive_no_pk', $out_itemreceive_no_pk, PDO::PARAM_INT);
            $receive_items->bindParam('out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
            $receive_items->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            $receive_items->execute();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'GRN ' . $rcv_save_option . ' successfully. <br><strong>Receive No = ' . $grn_no, 'title' => 'Success', 'no' => $out_error, 'grn_no' =>  $grn_no], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }


    public function grnReportPrintV2($receive_no_fk = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $grn_report_list = DB::select(DB::raw(
            "select                             item_type,item_code,
                                                itemreceive_uid,purchase_uid,
                                                currency_name,
                                                currency_rate,
                                                itemreceive_no_pk,
                                                item_name,
                                                uom_name,
                                                order_qty,
                                                sum(delivered_qty) delivered_qty,
                                                discount_amount,
                                                discount_percent,vat_percent,
                                                vat_amount,
                                                sum(delivered_qty+freeitem_qty) total_qty,
                                                sum(delivered_qty*unit_price) amount,
                                                freeitem_qty,
                                                free_uom_name,
                                                unit_price,
                                                supplier_name,
                                                po_no,
                                                purchase_date,
                                                challan_date,
                                                challan_no,
                                                department,
                                                delivery_location,
                                                challan_date,
                                                receive_date,
                                                received_by,
                                                user_fullname_entry_by ,
                                                rcv_save_option,
                                                inv_requisitiondtl_no_pk,
                                                store_su_no_fk,
                                                po_by_name,
                                                pr_no,
                                                inv_requisitionmst_po_no_pk,
                                                service_charge_percent,
                                                service_charge_amount,
                                                ait_percent,
                                                ait_amount,
                                                currency_sign,
                                                item_no_fk,
                                                au_update_at,
                                                purchaseorderdtl_no_pk,
                                                itemreceivedtl_no_pk,
                                                entry_serial,
                                                pr_uom_conversion_qty,
                                                remarks,
                                                batch_no,
                                                expiry_date,
                                                au_entry_at,
                                                pharmacy_ind,
                                                generic_name,
                                                ait_percent_itm,
                                                ait_amount_itm,
                                                ser_charge_percent_itm,
                                                ser_charge_amount_itm,
                                                vat_percent_itm,
                                                vat_amount_itm,
                                                discount_percent_itm,
                                                discount_amount_itm

                                                from phr_v1_grn_vw where itemreceive_no_pk = $receive_no_fk

                                                group by

                                                item_type,
                                                item_code,
                                                itemreceive_uid,purchase_uid,
                                                currency_name,
                                                currency_rate,
                                                itemreceive_no_pk,
                                                item_name,
                                                uom_name,
                                                order_qty,
                                                freeitem_qty,
                                                free_uom_name,
                                                unit_price,
                                                discount_amount,
                                                discount_percent,
                                                vat_percent,
                                                vat_amount,
                                                supplier_name,
                                                po_no,
                                                purchase_date,
                                                challan_date,
                                                challan_no,
                                                department,
                                                delivery_location,
                                                challan_date,
                                                receive_date,
                                                received_by,
                                                user_fullname_entry_by ,
                                                rcv_save_option,
                                                inv_requisitiondtl_no_pk ,
                                                store_su_no_fk,
                                                po_by_name,pr_no,
                                                inv_requisitionmst_po_no_pk,
                                                service_charge_percent,
                                                service_charge_amount,
                                                ait_percent,
                                                ait_amount,
                                                currency_sign,
                                                item_no_fk,
                                                au_update_at,
                                                purchaseorderdtl_no_pk,
                                                itemreceivedtl_no_pk,
                                                entry_serial,
                                                pr_uom_conversion_qty,
                                                remarks,
                                                batch_no,
                                                expiry_date,
                                                au_entry_at,
                                                pharmacy_ind,
                                                generic_name,
                                                ait_percent_itm,
                                                ait_amount_itm,
                                                ser_charge_percent_itm,
                                                ser_charge_amount_itm,
                                                vat_percent_itm,
                                                vat_amount_itm,
                                                discount_percent_itm,
                                                discount_amount_itm
                                                order by entry_serial asc"
        ));



        //  dd($grn_report_list);

        $grnNo = $grn_report_list[0]->itemreceive_no_pk;
        $grnUID = $grn_report_list[0]->itemreceive_uid;


        $autoEntryGRN = DB::table('ACCT_JOURNAL_ENTRY as j')
            ->join('ACCT_CHART_OF_ACCOUNTS as acc', 'j.TRN_ACCOUNT_NO_FK', '=', 'acc.ACCOUNT_NO_PK')
            ->leftJoin('ACCT_SUBLEDGER_NAME as s', 'j.ACCT_SUBLEDGER_NO_FK', '=', 's.ACCT_SUBLEDGER_NO_PK')
            ->where('j.TRN_DR_ACCOUNT_AMOUNT', '>', 0)
            ->where('j.AUTO_POSTING_REF_TYPE', '=', 'GRN')
            ->where('j.AUTO_POSTING_REF_VALUE', '=', $grnNo)
            ->select(
                'j.JOURNAL_CODE',
                'j.JOURNAL_DATE',
                'j.TRN_ACCOUNT_NO_FK',
                'j.TRN_ACCOUNT_CODE',
                'j.TRN_DR_ACCOUNT_AMOUNT',
                's.SUBLEDGER_CODE',
                's.SUBLEDGER_NAME',
                'acc.ACCOUNT_CODE',
                'acc.ACCOUNT_NO_PK',
                'acc.ACCOUNT_NAME'
            )
            ->get();



        $barcode = new BarcodeGenerator();

        if (Session::get('user.ses_hospital_code') == 'KPJ') {
             $barcode->setText($grnUID);
        }else
        {
             $barcode->setText($receive_no_fk);
        }
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');



        if (Session::get('user.ses_hospital_code') == 'KPJ') {
            $pdf = PDF::loadView("admin.inventory.v1.grn.grn_report_pdf_kpj", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'grn_report_list' => $grn_report_list,
            'invoice_barcode' => $invoice_barcode,
            'ae_grn' => $autoEntryGRN,
        ]);
        } else {
            $pdf = PDF::loadView("admin.inventory.v1.grn.grn_report_pdf_pharmacy", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'grn_report_list' => $grn_report_list,
            'invoice_barcode' => $invoice_barcode,
            'autoEntryGRN' => $autoEntryGRN,
            ]);
        };




        // if(DB::table('sysc_serviceunit')->where('serviceunit_no_pk', $grn_report_list[0]->store_su_no_fk)->value('pharmacy_ind') == 1){
        //     $pdf = PDF::loadView("admin.inventory.v1.grn.grn_report_pdf_pharmacy", [
        //         'po_hospital_details' => $po_hospital_details,
        //         'userInfo' => $userInfo,
        //         'grn_report_list' => $grn_report_list,
        //         'invoice_barcode' => $invoice_barcode,
        //     ]);
        // }else{
        //     $pdf = PDF::loadView("admin.inventory.v1.grn.grn_report_pdf_v2", [
        //         'po_hospital_details' => $po_hospital_details,
        //         'userInfo' => $userInfo,
        //         'grn_report_list' => $grn_report_list,
        //         'invoice_barcode' => $invoice_barcode,
        //     ]);
        // }

        return $pdf->stream("GRN_REPORT.pdf", array("Attachment" => false));
    }

    public function getLastBatch(Request $request)
    {
        $item_id = $request->item_id;
        $batch = DB::table("PHR_ITEMRECEIVEDTL")
            ->leftJoin('phr_itemreceivemst', 'phr_itemreceivemst.itemreceive_no_pk', 'phr_itemreceivedtl.itemreceive_no_fk')
            ->where('PHR_ITEMRECEIVEDTL.item_no_fk', $item_id)
            ->whereNotNull('PHR_ITEMRECEIVEDTL.batch_no')
            ->where('phr_itemreceivemst.rcv_save_option', 'POST')
            ->orderByDesc('PHR_ITEMRECEIVEDTL.itemreceivedtl_no_pk')
            ->value('PHR_ITEMRECEIVEDTL.batch_no');
        return response()->json(['data' => $batch, 'success' => true], 200);
    }


    public function grnRegisterItemWise()
    {
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_uid', 'supplier_name', 'company_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $mainStore = DB::table('SYSC_SERVICEUNIT')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            // ->where('hospital_store_ind', '=', 1)
            ->where('main_store_ind', '=', 1)
            // ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $items = DB::table('sysc_serviceitem')
            ->select('item_no_pk','item_name')
            ->get();
        return Template::loadView("admin.inventory.v1.grn.grn_register_item_wise", [
            "allSuppliers" => $allSuppliers,
            "items" => $items,
            'mainStore' => $mainStore
        ]);
    }
}
