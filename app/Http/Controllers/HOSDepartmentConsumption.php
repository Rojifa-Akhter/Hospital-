<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LookupData;
use DB;
use Exception;
use Session;
use PDO;
use DateTime;

class HOSDepartmentConsumption extends Controller
{
    //
    use LookupData;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($id = "")
    {
        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $all_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('main_store_ind')
            ->WhereNull('sub_store_ind')
            ->orderBy('main_store_ind', 'asc')
            ->get();

        $constype =  $this->getLookupListByCode('CONSTYPE');
        $edit_info = [];
        $eidt_info_arr = [];
        $cons_save_option = '';
        if ($id != "") {
            $edit_info = DB::table('inv_consumption_vw')->where('inv_consumption_no_pk', $id)->get()->toArray();

            if (!empty($edit_info)) {
                foreach ($edit_info as $key => $value) {
                    $eidt_info_arr[$value->item_no_fk . '_' . $value->item_name][] = $value;
                }
            }

            $save_option = DB::table('inv_consumptionmst')->select('consumption_save_option')->where('inv_consumption_no_pk', $id)->first();

            $cons_save_option = isset($save_option) ? $save_option->consumption_save_option : '';
        }

        // dd( $eidt_info_arr);
        return Template::loadView("admin.uhl.inventory.department-consumption", [
            'stores' => $stores,
            'all_stores_list' => $all_stores_list,
            'constype' => $constype,
            'eidt_info_arr' => $eidt_info_arr,
            'id' => $id,
            'cons_save_option' => $cons_save_option,
        ]);
    }

    public function getSubMainStore(Request $request)
    {
        // $stores =DB::table('sysc_serviceunit')
        // ->select('*')
        // ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        // ->where('main_store_ind', '=', 1)
        // ->orWhere('sub_store_ind', '=', 1)
        // ->orderBy('main_store_ind', 'asc')
        // ->get();



        $store = [];
        if ($request->type == 1) {
            $store = DB::table('sysc_serviceunit')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                // ->where('main_store_ind', '=', 1)
                ->Where('sub_store_ind', '=', 1)
                ->Where('status',  1)
                ->orderBy('sub_store_ind', 'asc')
                ->get();
        } else {
            $store = DB::table('sysc_serviceunit')
                ->select('*')
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereNull('main_store_ind')
                ->WhereNull('sub_store_ind')
                ->Where('status',  1)
                ->orderBy('main_store_ind', 'asc')
                ->get();



            // DB::table('sysc_v1_grant_servieceunit_vw')
            // ->select('*')
            // ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->where('sub_store_ind', '=', 1)
            // // ->orWhere('main_store_ind', '=', 1)
            // ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            // ->get();
        }


        $constype =  $this->getLookupListByCode('CONSTYPE');
        return response()->json($store);
        // return Template::loadView("admin.uhl.inventory.department-consumption", [
        //     'stores' => $stores,
        //     'all_stores_list' => $all_stores_list,
        //     'constype' => $constype,

        // ]);
    }
    public function consumption_batch_no($batch = "")
    {
        $pdo = DB::getPdo();
        DB::beginTransaction();
        $hospital = Session::get('user.ses_hospital_no_pk');
        $main_store_stock = 0;
        $exp_data = explode('*', $batch);
        $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
        $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 12);
        $stmt->bindParam(':IN_ITEM_NO_FK', $exp_data[1], PDO::PARAM_INT);
        $stmt->bindParam(':IN_STORE_SU_NO_FK', $exp_data[0], PDO::PARAM_INT);
        $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
        $stmt->execute();

        $main_stock = floatval($main_store_stock);
        $item_info = DB::table('sysc_serviceitem')->where('item_no_pk', $exp_data[1])->select('item_name', 'item_code')->first();

        $all_batch = DB::table('inv_batchwise_stock_vw')->where('stock_su_no_fk', $exp_data[0])->where('item_no_fk', $exp_data[1])->where('item_qty', '>', 0)->orderBy('internal_batch_no_uq')->get()->toArray();
        $batch_no = $batch;

        return Template::loadView("admin.uhl.inventory.department-consumption-batch-no", [
            'batch_no' => $batch_no,
            'main_stock' =>  $main_stock,
            'all_batch' =>  $all_batch,
            'item_id' =>  $exp_data[1],
            'item_info' =>  $item_info,

        ]);
    }
    public function consumption_batch_no_issue($batch = "")
    {
        $pdo = DB::getPdo();
        DB::beginTransaction();
        $hospital = Session::get('user.ses_hospital_no_pk');
        $main_store_stock = 0;
        $exp_data = explode('*', $batch);

        $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
        $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 50);
        $stmt->bindParam(':IN_ITEM_NO_FK', $exp_data[1], PDO::PARAM_INT);
        $stmt->bindParam(':IN_STORE_SU_NO_FK', $exp_data[0], PDO::PARAM_INT);
        $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
        $stmt->execute();

        $main_stock = floatval($main_store_stock);
        $item_info = DB::table('sysc_serviceitem')->where('item_no_pk', $exp_data[1])->select('item_name', 'item_code')->first();

        $all_batchs = DB::table('inv_batchwise_stock_vw')->select(DB::raw('sum(item_qty) as item_qty'), 'internal_batch_no_uq', 'item_no_fk', 'stock_su_no_fk', 'expiry_date', 'batch_no', 'cost_price', 'purchase_price', 'purchaseorderdtl_no_pk', 'inv_requisitiondtl_no_pk', 'invoicedtl_no_pk', 'itemreceivedtl_no_pk')->where('stock_su_no_fk', $exp_data[0])->where('item_no_fk', $exp_data[1])->groupBy('internal_batch_no_uq', 'item_no_fk', 'stock_su_no_fk', 'expiry_date', 'batch_no', 'cost_price', 'purchase_price', 'purchaseorderdtl_no_pk', 'inv_requisitiondtl_no_pk', 'invoicedtl_no_pk', 'itemreceivedtl_no_pk')->orderBy('expiry_date', 'asc')->orderBy('internal_batch_no_uq', 'asc')->get()->toArray();
       
        $all_batch = [];
        if (!empty($all_batchs)) {
            foreach ($all_batchs as $key => $value) {
                if ($value->item_qty > 0) {
                    $all_batch[]=(object) [
                        "item_qty" => $value->item_qty,
                        "internal_batch_no_uq" => $value->internal_batch_no_uq,
                        "item_no_fk" => $value->item_no_fk,
                        "stock_su_no_fk" => $value->stock_su_no_fk,
                        "expiry_date" => $value->expiry_date,
                        "batch_no" => $value->batch_no,
                        "cost_price" => $value->cost_price,
                        "purchase_price" => $value->purchase_price,
                        "purchaseorderdtl_no_pk" => $value->purchaseorderdtl_no_pk,
                        "inv_requisitiondtl_no_pk" => $value->inv_requisitiondtl_no_pk,
                        "invoicedtl_no_pk" => $value->invoicedtl_no_pk,
                        "itemreceivedtl_no_pk" => $value->itemreceivedtl_no_pk,
                    ];
                }
            }
        }
        // dd($all_batchs,$all_batch);
        // dd($exp_data[0], $all_batch);
        $batch_no = $batch;
        return Template::loadView("admin.uhl.inventory.department-consumption-batch-no-issue", [
            'batch_no' => $batch_no,
            'main_stock' =>  $main_stock,
            'all_batch' =>  $all_batch,
            'item_id' =>  $exp_data[1],
            'item_info' =>  $item_info,
            'indent_qty' =>  $exp_data[2],
            'item_uom' =>  $exp_data[3],
            'req_dtl' =>  $exp_data[4],
            'issue_qty' =>  $exp_data[5] != "" ? $exp_data[5] : 0,


        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all()); // PKG_V1_INVENTORY_ALL.PRC_ITEMCONSUMPTION_MS
        // try {
        $numelems = 1000;
        $consumption_no = $request->consumption_no_pk;
        $remarks   = $request->remarks_;
        $out_po_uid = '';
        $null = '';
        $zero = 0;
        $emptyArray = array();
        $null = date('Y');
        $pdo = DB::getPdo();

        $null = "";
        $zero = 0;
        $zero_arr = [];
        $empty_arr = [];
        $in_au_entry_by = Session::get('user.ses_user_pk_no');
        $in_au_entry_session = 'item consumption';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

        $in_to_store_no_fk = $request->department_from;
       
        $in_consumption_save_option = "DRAFT";
        $out_itemreceive_uid = '';
        $out_itemreceive_no_pk = 0;
        $out_error = '';
        $in_patient_no_fk = $request->hdn_patient_id;


        // $in_a_sales_item_price = $in_a_pur_item_price = $in_inv_requisitiondtl_no_pk = $item_no_fk_arr = $in_item_batch_fk = $in_item_expiry_dt =  $in_a_item_pvmsno = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = [];
        // for ($i = 0; $i < count($request->item_id_hidden); $i++) {
        //     $item_no_fk_arr[$i] = $request->item_id_hidden[$i];
        //     $in_item_batch_fk[$i] = $request->item_batch_fk[$i];
        //     $in_item_expiry_dt[$i] =  $request->item_expire_date[$i];;
        //     $in_a_item_pvmsno[$i] = '';
        //     $empty_arr[$i] = 0;
        //     $zero_arr[$i] = "";
        //     $in_a_item_qty[$i] = $request->item_quantity[$i];
        //     $in_a_item_uom[$i] = $request->uom_no_fk[$i];
        //     $in_a_pur_item_price[$i] = 0;//$request->purchase_price[$i];
        //     $in_a_sales_item_price[$i] =0 ;//$request->sales_price[$i];
        //     $in_inv_requisitiondtl_no_pk[$i] = '';
        //     $in_a_entry_serial_dtl[$i] = $i + 1;
        // }
        $all_info =  $in_a_sales_item_price = $in_a_pur_item_price = $in_a_cost_price = $itemreceivedtl_no_pk = $in_inv_requisitiondtl_no_pk = $item_no_fk_arr = $in_internal_item_batch_fk = $in_item_batch_fk = $in_item_expiry_dt =  $in_a_item_pvmsno = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = [];
        for ($i = 0; $i < count($request->hidden_batch_no_qty); $i++) {
            $all_info[$i] = explode('_', $request->hidden_batch_no_qty[$i]);
            $item_no_fk_arr[$i] =  $all_info[$i][3];
            $in_internal_item_batch_fk[$i] =  $all_info[$i][0];
            $in_item_batch_fk[$i] = $all_info[$i][1];
            $date = DateTime::createFromFormat('d/m/Y', $all_info[$i][2]);
            $in_item_expiry_dt[$i]= $date ? $date->format('dmY') : null;
            // $in_item_expiry_dt[$i] = $all_info[$i][2] != "" ? date('Y-m-d', strtotime($all_info[$i][2])) : '';
            $in_a_item_pvmsno[$i] = '';
            $empty_arr[$i] = 0;
            $zero_arr[$i] = "";
            $in_a_item_qty[$i] =  $all_info[$i][4];
            $in_a_item_uom[$i] =  $all_info[$i][7];
            $in_a_pur_item_price[$i] = $all_info[$i][5] != "" ? $all_info[$i][5] : 0;
            $in_a_cost_price[$i] = $all_info[$i][8] != "" ? $all_info[$i][8] : 0;
            $in_a_sales_item_price[$i] = $all_info[$i][6] != "" ? $all_info[$i][6] : 0;
            $itemreceivedtl_no_pk[$i] = $all_info[$i][9] != "" ? $all_info[$i][9] : 0;
            $in_inv_requisitiondtl_no_pk[$i] = '';
            $in_a_entry_serial_dtl[$i] = $i + 1;
        }
        // dd($item_no_fk_arr, $in_internal_item_batch_fk,
        // $in_item_batch_fk,
        //  $in_a_item_qty,
        //  $in_a_item_uom,
        //  $in_a_pur_item_price,
        //                 );


        $main_store_module = ServiceUnit::where('serviceunit_no_pk', $in_to_store_no_fk)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();


        $main_store_module = isset($main_store_module->main_store_module_no_fk) ?
            $main_store_module->main_store_module_no_fk : 0;

        $save_type = $request->save_type;
        $edit_ind = $request->edit_ind != "" ? $request->edit_ind : 0;


        $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemconsumption_ms(
                :in_consumption_type,
                :in_inv_consumption_no_pk ,
                :in_inv_consumption_date ,
                :in_to_store_no_fk ,
                :in_from_store_no_fk ,
                :in_consumption_document_path  ,
                :in_patient_no_fk ,
                :in_admission_no_fk ,
                :in_consumption_by_person_no_fk ,
                :in_consumption_by_event_no_fk ,
                :in_consumption_remarks  ,
                :in_indent_no_fk ,
                :in_source_su_no_fk ,
                :in_consumption_schedule_date ,
                :in_consumption_save_option ,
                :in_module_no_fk ,
                :in_edit_ind,
                :in_a_item_no_fk ,
                :in_a_item_consumption_uom ,
                :in_a_item_consumption_qty ,
                :in_a_internal_batch_no  ,
                :in_a_batch_no ,
                :in_a_expiry_date ,
                :in_a_item_remarks ,
                :in_a_entry_serial_dtl ,
                :in_a_consumption_schedule_date ,
                :in_a_purchaseorderdtl_no_pk ,
                :in_a_inv_requisitiondtl_no_pk ,
                :in_a_itemreceivedtl_no_pk ,
                :in_a_invoicedtl_no_pk ,
                :in_a_cost_price ,
                :in_a_purchase_price ,
                :in_a_sales_price ,
                :in_au_entry_by ,
                :in_au_entry_session ,
                :in_au_entry_hospital_no_fk ,
                :out_itemreceive_no_pk  ,
                :out_itemreceive_uid  ,
                :out_error
                ); end;");



        //dd($empty_arr,$in_inv_requisitiondtl_no_pk, $item_no_fk_arr);
        $in_inv_consumption_date = $request->document_date != "" ?  date('Y-m-d', strtotime($request->document_date)) : '';
        $in_consumption_type = $request->type;


        // dd($in_consumption_type);
        $purchase_order_entry->bindparam('in_consumption_type', $in_consumption_type);
        $purchase_order_entry->bindparam('in_inv_consumption_no_pk',   $consumption_no);
        $purchase_order_entry->bindparam('in_inv_consumption_date', $in_inv_consumption_date);
        $purchase_order_entry->bindparam('in_to_store_no_fk',  $zero);
        $purchase_order_entry->bindparam('in_from_store_no_fk', $in_to_store_no_fk);
        $purchase_order_entry->bindparam('in_consumption_document_path', $null);
        $purchase_order_entry->bindparam('in_patient_no_fk', $in_patient_no_fk);
        $purchase_order_entry->bindparam('in_admission_no_fk', $zero);
        $purchase_order_entry->bindparam('in_consumption_by_person_no_fk', $zero);
        $purchase_order_entry->bindparam('in_consumption_by_event_no_fk', $zero);
        $purchase_order_entry->bindparam('in_consumption_remarks', $remarks);
        $purchase_order_entry->bindparam('in_indent_no_fk', $zero);
        $purchase_order_entry->bindparam('in_source_su_no_fk', $zero);
        $purchase_order_entry->bindparam('in_consumption_schedule_date', $in_inv_consumption_date);
        $purchase_order_entry->bindparam('in_consumption_save_option', $save_type);
        $purchase_order_entry->bindparam('in_module_no_fk', $main_store_module);
        $purchase_order_entry->bindparam('in_edit_ind', $edit_ind);
        $purchase_order_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_item_consumption_uom', $in_a_item_uom, count($in_a_item_uom), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_item_consumption_qty', $in_a_item_qty, count($in_a_item_qty), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_internal_batch_no', $in_internal_item_batch_fk, count($in_internal_item_batch_fk), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_batch_no', $in_item_batch_fk, count($in_item_batch_fk), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_expiry_date', $in_item_expiry_dt, count($in_item_expiry_dt), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_item_remarks', $empty_arr, count($empty_arr), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_entry_serial_dtl', $in_a_entry_serial_dtl, count($in_a_entry_serial_dtl), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_consumption_schedule_date', $zero_arr, count($zero_arr), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_purchaseorderdtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_inv_requisitiondtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_itemreceivedtl_no_pk', $itemreceivedtl_no_pk, count($itemreceivedtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_invoicedtl_no_pk', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_cost_price', $in_a_cost_price, count($in_a_cost_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_purchase_price', $in_a_pur_item_price, count($in_a_pur_item_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_sales_price', $in_a_sales_item_price, count($in_a_sales_item_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
        $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
        $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
        $purchase_order_entry->bindParam('out_itemreceive_no_pk', $out_itemreceive_no_pk, PDO::PARAM_INT);
        $purchase_order_entry->bindParam('out_itemreceive_uid', $out_itemreceive_uid, PDO::PARAM_STR, 500);
        $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($purchase_order_entry);
        $purchase_order_entry->execute();

        DB::commit();

        // PDF URL after storing
        // $pdfUrl = route('departmentIssuedPrint', ['req_id' => $out_itemreceive_no_pk]);

        $message = ['msg' => 'Data saved successfully.<br><strong>Receive UID = ' . $out_itemreceive_uid . '</strong>', 'title' => 'Success'];
        // } catch (Exception $e) {
        //     $message = ['msg' => 'Failed to Recevied.<br><strong>Error Message = ' . $e->getMessage() . '</strong>', 'title' => 'Success'];
        // }

        return response()->json($message);
    }
}
