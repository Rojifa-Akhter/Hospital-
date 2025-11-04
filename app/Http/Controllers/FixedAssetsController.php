<?php

namespace App\Http\Controllers;

use App;
use PDO;
use \PDF;
use Session;
use DateTime;
use Carbon\Carbon;

use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Core\Accounts\AccountsReport\AccountsReportJournal;

class FixedAssetsController extends Controller
{
    use UtilitiesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $depreciation;

    public function __construct(AccountsReportJournal $depreciation){
        $this->depreciation = $depreciation;
     }

    public function index()
    {
        //
    }


    public function assetsReceive()
    {
        // $class = DB::table('fass_assetclass')->where('status', 1)->get();
        // $category = DB::table('fass_assetcategory')->where('status', 1)->get();
        $major_group = DB::table('sysc_itemtype')->where('major_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $minor_group = DB::table('sysc_itemtype')->where('minor_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $department = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('main_store_ind', 1)->where('status', 1)->get();
        return Template::loadView("admin.uhl.fixed_assets.asset-received", ['major_group' => $major_group, 'minor_group' => $minor_group, 'department' => $department]);
    }
    public function assetsReceiveSearch(Request $request)
    {
        $asset_receive_data = DB::table('fass_assetreceive_vw');

        if ($request->asset_id != "") {
            $asset_receive_data->where('item_no_fk', $request->asset_id);
        }
        // if ($request->asset_type !="") {
        //     $asset_receive_data->where('itemreceivedtl_no_pk', $request->asset_type);
        // }
        if ($request->department_asset != "") {
            $asset_receive_data->where('store_su_no_fk', $request->department_asset);
        }
        if ($request->major_group != "") {
            $asset_receive_data->where('par_itemtype_code', $request->major_group);
        }
        if ($request->minor_group != "") {
            $asset_receive_data->where('ity_group_header_code', $request->minor_group);
        }
        if ($request->received_date_from != "" && $request->received_date_to != "") {

            $asset_receive_data->whereBetween('grn_date', [date('Y-m-d', strtotime($request->received_date_from)), date('Y-m-d', strtotime($request->received_date_to . '+1 days'))]);
        } elseif ($request->received_date_from != "") {
            $asset_receive_data->whereDate('grn_date', date('Y-m-d', strtotime($request->received_date_from)));
        }

        $asset_receive_data_arr = $asset_receive_data
            ->whereRaw(' grn_qty> NVL(tag_qty,0)')
            ->orderBy('item_name')->get();
        // dd($asset_receive_data_arr);
        return Template::loadView("admin.uhl.fixed_assets.asset-received-list", ['asset_receive_data_arr' => $asset_receive_data_arr]);
    }

    public function createTagPopup($id)
    {
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $asset_receive_data = DB::table('fass_assetreceive_vw')->where('itemreceivedtl_no_pk', $id)->first();
        $existing_data = DB::table('fas_assetregister')->where('itemreceivedtl_no_fk', $id)->get();

        return Template::loadView("admin.uhl.fixed_assets.create_tag_popup", ['asset_receive_data' => $asset_receive_data, 'existing_data' => $existing_data, 'location' => $location]);
    }

    public function generateTag(Request $request)
    {
        try {
            $current_qty = $request->current_qty;
            DB::beginTransaction();
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_id = $ses_hospital_id;
            $entry_session = "session";
            $auth_id = Auth::id();
            $out_uid = '';
            $numelems = 100;
            $table_name = 'fas_assetregister';
            $column_name = 'asset_tag_uid';
            $null = null;
            $myArray = [];
            if ($current_qty != "" || $current_qty > 0) {

                for ($i = 0; $i < $current_qty; $i++) {
                    $pdo1 = DB::getPdo();
                    $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                            :in_table_name_txt,
                            :in_column_name_txt,
                            :in_hos_yyyymmdd_ind,
                            :in_special_code,
                            :in_au_entry_by,
                            :in_au_entry_session,
                            :in_au_entry_hospital_pk_no,
                            :out_uid
                            );
                            end;");

                    $tagGenerate->bindParam(':in_table_name_txt', $table_name);
                    $tagGenerate->bindParam(':in_column_name_txt', $column_name);
                    $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
                    $tagGenerate->bindParam(':in_special_code', $null);
                    $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
                    $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
                    $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
                    $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
                    $tagGenerate->execute();
                    DB::commit();
                    array_push($myArray, $out_uid);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Not gererated tag'];
        }
        return response()->json($myArray);
    }

    public function SaveGenerateTag(Request $request)
    {
        // dd($request->last_room_no_fk);
        if (count($request->current_tag_no) > 0) {
            try {
                $rgnDtl = $request->grnDtlNo;
                $item_no = $request->asset_id;
                $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
                $auth_id = Auth::id();
                $to_date = date('Y-m-d h:i');
                $entry_session = 'session';
                DB::beginTransaction();
                for ($i = 0; $i < count($request->current_tag_no); $i++) {
                    $sequence = DB::getSequence();
                    $no_pk_seq = $sequence->nextValue('ast_register_no_pk_seq');
                    $out_uid = '';
                    $table_name = 'fas_assetregister';
                    $column_name = 'ast_register_uid';
                    $null = null;
                    $pdo1 = DB::getPdo();
                    $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                        :in_table_name_txt,
                        :in_column_name_txt,
                        :in_hos_yyyymmdd_ind,
                        :in_special_code,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :out_uid
                        );
                        end;");

                    $tagGenerate->bindParam(':in_table_name_txt', $table_name);
                    $tagGenerate->bindParam(':in_column_name_txt', $column_name);
                    $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
                    $tagGenerate->bindParam(':in_special_code', $null);
                    $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
                    $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
                    $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
                    $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
                    $tagGenerate->execute();
                    DB::commit();

                    $module_code = DB::table('sysc_module')->select('module_no_pk')->where('module_code', 'FAS')->first();
                    $sub_store = DB::table('sysc_serviceitem')->select('serviceunit_no_fk')->where('item_no_pk', $item_no)->first();
                    $sub_store_no = !empty($sub_store) ? $sub_store->serviceunit_no_fk : null;
                    $data = [
                        'ast_register_no_pk' => $no_pk_seq,
                        'ast_register_uid' => $out_uid,
                        'itemreceivedtl_no_fk' =>  $rgnDtl,
                        'item_no_fk' =>  $item_no,
                        'asset_tag_ind' =>  1,
                        'asset_tag_uid' =>  $request->current_tag_no[$i],
                        'asset_tag_by' =>   $auth_id,
                        'asset_tag_at' =>   $to_date,
                        'ast_register_date' =>   $to_date,
                        'ast_register_name' =>  Auth::user()->user_fullname,
                        'person_no_fk' =>  Auth::user()->person_no_fk,
                        'main_store_su_no_fk' =>   $request->store_id,
                        'curr_store_su_no_fk' =>   $sub_store_no,
                        'curr_room_no_fk' =>   $request->asset_location,
                        'module_no_fk' =>   !empty($module_code) ?  $module_code->module_no_pk : "",
                        'last_store_su_no_fk' => $request->last_store_su_no_fk,
                        'last_room_no_fk' => $request->last_room_no_fk,
                        'item_model_number' => $request->item_model_number,
                        'country_of_origin' => $request->country_of_origin,
                        'item_serial_number' => $request->item_serial_number,
                        'depreciation_residual_val_pct' => $request->depreciation_residual_val_pct,
                        'depreciation_residual_val_amt' => $request->depreciation_residual_val_amt,
                        'usage_status' => $request->usage_status,
                        'au_entry_by' =>   $auth_id,
                        'au_entry_at' =>   $to_date,
                        'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    ];

                    // dd($data);
                    DB::table('fas_assetregister')->insert($data);
                }
                DB::commit();
                $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $no_pk_seq];
            } catch (\Throwable $e) {
                DB::rollback();
                $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($message);
        }
    }
    public function printGenerateTag($id)
    {
        $label_info = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'sysc_v1_serviceitem_vw.item_type_name', 'sysc_v1_serviceitem_vw.serviceunit_code', 'sysc_v1_serviceitem_vw.brand', 'sysc_v1_serviceitem_vw.model_info', 'phr_itemreceivedtl.au_entry_at as grn_date')
            ->leftjoin('sysc_v1_serviceitem_vw', 'sysc_v1_serviceitem_vw.item_no_pk', '=', 'fas_assetregister.item_no_fk')
            ->leftjoin('sysc_itemtype', 'sysc_itemtype.itemtype_no_pk', '=', 'sysc_v1_serviceitem_vw.itemtype_no_fk')
            ->leftjoin('sysc_v1_serviceitem_vw', 'sysc_v1_serviceitem_vw.serviceunit_no_fk', '=', 'sysc_itemtype.asset_su_no_fk')
            ->leftjoin('phr_itemreceivedtl', 'phr_itemreceivedtl.itemreceivedtl_no_pk', '=', 'fas_assetregister.itemreceivedtl_no_fk')
            ->where('ast_register_no_pk', $id)->first();
        // dd($label_info);

        $head = $label_info->item_type_name != "" ? '/' . $label_info->item_type_name : "";
        $department = $label_info->serviceunit_code != "" ? '/' . $label_info->serviceunit_code : "";
        $barcode_label = Session::get('user.ses_hospital_code') . $head . $department . '/' . $label_info->asset_tag_uid;

        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->asset_tag_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(5);

        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;

        // dd($label_info);
        // return View("admin.pathology.sample_print", $data);
        $pdf = PDF::loadView("admin.uhl.fixed_assets.asset_tag_print", $data);
        return $pdf->stream("SM-$label_info->asset_tag_uid.pdf");
    }
    public function printEquipmentDetail($id)
    {
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $floors = DB::table('sysc_physicalstructfloor')->where('status', 1)->get();
        $building = DB::table('sysc_physicalstructurebuilding')->where('status', 1)->get();

        $asset_register_data = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'fass_assetreceive_vw.par_item_type_name', 'fass_assetreceive_vw.ity_group_header_name', 'room.physicalstrucure_no_fk', 'building.physicalstruct_build_sl', 'floor.physicalstruct_floor_sl', 'room.room_name', 'building.physicalstruct_build_name', 'floor.physicalstruct_name', 'current_su.serviceunit_name as current_store', 'current_person.full_name', 'current_person.su_name as person_department', 'last_room.room_name as last_location', 'last_room.physicalstruct_name_fl_bld as physicalstruct_name_fl_bld', 'current_room.physicalstruct_name_fl_bld as currentphysicalstruct_name_fl_bld', 'current_room.room_name as current_room', 'phr_v1_grn_vw.refer_item_specification', 'phr_v1_grn_vw.receive_date')
            ->leftjoin('sysc_room room', 'fas_assetregister.curr_room_no_fk', 'room.room_no_pk')
            ->leftjoin('sysc_physicalstructfloor floor', 'room.physicalstrucure_no_fk', 'floor.physicalstruct_no_pk')
            ->leftjoin('sysc_physicalstructurebuilding building', 'floor.physicalstruct_building_no_fk', 'building.physicalstruct_build_no_pk')
            ->leftjoin('sysc_serviceunit current_su', 'current_su.serviceunit_no_pk', '=', 'fas_assetregister.curr_store_su_no_fk')
            ->leftjoin('fass_assetreceive_vw', 'fass_assetreceive_vw.itemreceivedtl_no_pk', '=', 'fas_assetregister.itemreceivedtl_no_fk')
            ->leftjoin('employee_info_vw current_person', 'current_person.person_no_pk', '=', 'fas_assetregister.person_no_fk')
            ->leftjoin('room_list_vw current_room', 'current_room.room_no_pk', '=', 'fas_assetregister.curr_room_no_fk')
            ->leftjoin('room_list_vw last_room', 'last_room.room_no_pk', '=', 'fas_assetregister.last_room_no_fk')
            ->leftjoin('phr_v1_grn_vw', function ($join) {
                $join->on('fas_assetregister.itemreceivedtl_no_fk', '=', 'phr_v1_grn_vw.itemreceivedtl_no_pk')
                    ->on('fas_assetregister.item_no_fk', '=', 'phr_v1_grn_vw.item_no_fk');
            })
            ->where('ast_register_no_pk', $id)->first();
        // dd($asset_register_data);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.uhl.fixed_assets.equpment-register-detail-print", [
            'po_hospital_details' => $po_hospital_details,
            'asset_register_data' => $asset_register_data,
            'building' => $building,
            'floors' => $floors,
            'location' => $location,
        ])->setPaper('a4', 'protrait');
        return $pdf->stream('equpment-register-detail-print.pdf');
    }

    public function assetsRegister()
    {
        $item_types = DB::table('item_type_vw')
                        ->select('item_name', 'itemtype_no_pk', 'itemtype_code')
                        ->orderBy('item_name')
                        ->get();

        // $class = DB::table('fass_assetclass')->where('status', 1)->get();
        // $category = DB::table('fass_assetcategory')->where('status', 1)->get();
        $major_group = DB::table('sysc_itemtype')->where('major_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $minor_group = DB::table('sysc_itemtype')->where('minor_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();

        // $department = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('main_store_ind', 1)->where('status', 1)->get();

        $auth_id = Auth::id();
        // dd($auth_id);
        $department = DB::table('sysc_v1_grant_servieceunit_vw')
            // ->leftJoin('sysc_serviceunit', 'sysc_v1_grant_servieceunit_vw.grantsu_no_pk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('sysc_v1_grant_servieceunit_vw.serviceunit_no_pk', 'sysc_v1_grant_servieceunit_vw.serviceunit_name')
            ->where('sysc_v1_grant_servieceunit_vw.user_no_pk', '=', $auth_id)
            // ->where('sysc_v1_grant_servieceunit_vw.main_store_ind', 1)
            ->where('sysc_v1_grant_servieceunit_vw.asset_ind', 1)
            ->where('sysc_v1_grant_servieceunit_vw.status', 1)
            ->get();
        $asset_register_data_arr = []; //DB::table('fas_assetregister')->leftjoin('fass_assetreceive_vw','fass_assetreceive_vw.item_no_fk','=','fas_assetregister.item_no_fk')->get();
        return Template::loadView("admin.uhl.fixed_assets.asset-register", ['major_group' => $major_group, 'minor_group' => $minor_group, 'department' => $department, 'location' => $location, 'item_types' => $item_types]);
    }


    public function assetsRegisterSearch(Request $request)
    {

        $asset_register_data = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'phr_v1_grn_vw.refer_item_specification','phr_v1_grn_vw.supplier_name', 'phr_v1_grn_vw.receive_date', 'phr_v1_grn_vw.po_no', 'phr_v1_grn_vw.itemreceive_no_pk', 'fass_assetreceive_vw.*', 'current_su.serviceunit_name as current_store', 'current_room.room_name as current_room', 'current_person.full_name', 'current_person.su_name as person_department', 'last_room.room_name as last_location', 'last_room.physicalstruct_name_fl_bld as physicalstruct_name_fl_bld', 'current_room.physicalstruct_name_fl_bld as currentphysicalstruct_name_fl_bld', 'sysc_v1_serviceitem_vw.item_type_name', 'sysc_v1_serviceitem_vw.serviceunit_code', 'inv_po_wl_vw.po_doc_attachment_path', 'inv_po_wl_vw.pr_doc_attachment_path')
            ->leftjoin('fass_assetreceive_vw', 'fass_assetreceive_vw.itemreceivedtl_no_pk', '=', 'fas_assetregister.itemreceivedtl_no_fk')
            // ->leftjoin('fas_assettransfer','fas_assettransfer.asset_tag_uid','=','fas_assetregister.asset_tag_uid')
            ->leftjoin('room_list_vw current_room', 'current_room.room_no_pk', '=', 'fas_assetregister.curr_room_no_fk')
            ->leftjoin('room_list_vw last_room', 'last_room.room_no_pk', '=', 'fas_assetregister.last_room_no_fk')
            ->leftjoin('sysc_serviceunit current_su', 'current_su.serviceunit_no_pk', '=', 'fas_assetregister.curr_store_su_no_fk')
            // ->leftjoin('sysc_serviceunit trans_su','trans_su.serviceunit_no_pk','=','fas_assettransfer.curr_store_su_no_fk')
            // ->leftjoin('sysc_serviceunit main_su','main_su.serviceunit_no_pk','=','fas_assettransfer.curr_store_su_no_fk')
            ->leftjoin('employee_info_vw current_person', 'current_person.person_no_pk', '=', 'fas_assetregister.person_no_fk')

            ->leftjoin('sysc_v1_serviceitem_vw', 'sysc_v1_serviceitem_vw.item_no_pk', '=', 'fas_assetregister.item_no_fk')
            // ->leftjoin('sysc_itemtype', 'sysc_itemtype.itemtype_no_pk', '=', 'sysc_v1_serviceitem_vw.itemtype_no_fk')
            // ->leftjoin('sysc_v1_serviceitem_vw', 'sysc_v1_serviceitem_vw.serviceunit_no_fk', '=', 'sysc_itemtype.asset_su_no_fk')

            ->leftjoin('phr_v1_grn_vw', function ($join) {
                $join->on('fas_assetregister.itemreceivedtl_no_fk', '=', 'phr_v1_grn_vw.itemreceivedtl_no_pk')
                    ->on('fas_assetregister.item_no_fk', '=', 'phr_v1_grn_vw.item_no_fk');
            })
            ->leftjoin('inv_po_wl_vw', 'inv_po_wl_vw.purchaseorder_no_pk', '=', 'phr_v1_grn_vw.po_no');

        // dd($asset_register_data->get());
        // FAS_ASSETTRANSFER
        // ,DB::raw('(select trans_to_room_no_fk from fas_assettransfer t_room where t_room.trans_to_room_no_fk < fas_assettransfer.curr_store_su_no_fk ) as trans_to_room_no_fk')
        // dd($request->setup_status);
        if ($request->asset_id != "") {
            $asset_register_data->where('fas_assetregister.item_no_fk', $request->asset_id);
        }
        // if ($request->asset_type !="") {
        //     $asset_register_data->where('itemreceivedtl_no_pk', $request->asset_type);
        // }
        if ($request->department_asset != "") {
            $asset_register_data->where('fass_assetreceive_vw.item_serviceunit_no_fk', $request->department_asset);
        }
        if ($request->major_group != "") {
            $asset_register_data->where('fass_assetreceive_vw.par_itemtype_code', $request->major_group);
        }
        if ($request->minor_group != "") {
            $asset_register_data->where('fass_assetreceive_vw.ity_group_header_code', $request->minor_group);
        }
        if ($request->asset_location != "") {
            $asset_register_data->where('fas_assetregister.curr_room_no_fk', $request->asset_location);
        }
        if ($request->setup_status == "notSet") {
            $asset_register_data->where('fas_assetregister.curr_room_no_fk', '=', null);
        } elseif ($request->setup_status == "set") {
            $asset_register_data->where('fas_assetregister.curr_room_no_fk', '!=', null);
        }
        if ($request->received_date_from != "" && $request->received_date_to != "") {

            $asset_register_data->whereBetween('fas_assetregister.asset_tag_at', [date('Y-m-d', strtotime($request->received_date_from)), date('Y-m-d', strtotime($request->received_date_to . '+1 days'))]);
        } elseif ($request->received_date_from != "") {
            $asset_register_data->whereDate('fas_assetregister.asset_tag_at', date('Y-m-d', strtotime($request->received_date_from)));
        }

        if ($request->item_id_hidden != "") {
            $asset_register_data->where('fas_assetregister.item_no_fk', $request->item_id_hidden);
        }

        $asset_register_data_arr = $asset_register_data
            ->orderBy('fas_assetregister.asset_tag_uid', 'desc')->get();
    //    dd($asset_register_data_arr);

        return Template::loadView("admin.uhl.fixed_assets.asset-register-list", ['asset_register_data_arr' => $asset_register_data_arr]);
    }


    public function transferRequest($id, $receivedtl_id)
    {
        $building = DB::table('sysc_physicalstructurebuilding')->where('status', 1)->get();
        $floors = DB::table('sysc_physicalstructfloor')->where('status', 1)->get();
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $department = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('sub_store_ind', 1)->where('status', 1)->get();
        $location_info = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'current_su.serviceunit_name as current_store', 'current_room.room_name as current_room', 'current_person.full_name', 'current_person.su_name as person_department', 'last_room.room_name as last_location', 'last_room.room_no_pk as room_no_pk', 'room_list_vw.physicalstruct_name_fl_bld as physicalstruct_name_fl_bld')
            ->leftjoin('fass_assetreceive_vw', 'fass_assetreceive_vw.item_no_fk', '=', 'fas_assetregister.item_no_fk')
            ->leftjoin('sysc_room current_room', 'current_room.room_no_pk', '=', 'fas_assetregister.curr_room_no_fk')
            ->leftjoin('sysc_room last_room', 'last_room.room_no_pk', '=', 'fas_assetregister.last_room_no_fk')
            ->leftjoin('sysc_serviceunit current_su', 'current_su.serviceunit_no_pk', '=', 'fas_assetregister.curr_store_su_no_fk')
            ->leftjoin('employee_info_vw current_person', 'current_person.person_no_pk', '=', 'fas_assetregister.person_no_fk')
            ->leftjoin('room_list_vw', 'current_room.room_no_pk', '=', 'room_list_vw.room_no_pk')
            ->where('fas_assetregister.ast_register_no_pk', $id)
            ->orderBy('fas_assetregister.asset_tag_uid', 'asc')
            ->first();
        // dd($location_info);
        $store = DB::table('fas_assetregister')->select('store_name', 'store_su_no_fk')->leftjoin('fass_assetreceive_vw', 'fass_assetreceive_vw.item_no_fk', '=', 'fas_assetregister.item_no_fk')->where('ast_register_no_pk', $id)->first();
        // dd($store);
        $register_info = DB::table('fas_assetregister')->select('fas_assetregister.*', 'sysc_serviceitem.item_name')->leftjoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'fas_assetregister.item_no_fk')->where('ast_register_no_pk', $id)->first();

        return Template::loadView("admin.uhl.fixed_assets.create_transfer_popup", ['receivedtl_id' => $receivedtl_id, 'location_info' => $location_info, 'register_info' => $register_info, 'location' => $location, 'building' => $building, 'floors' => $floors, 'department' => $department, 'store' => $store]);
    }
    public function assetDetails($id)
    {
        $asset_register_data = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'room.physicalstrucure_no_fk', 'building.physicalstruct_build_sl', 'floor.physicalstruct_floor_sl', 'floor.physicalstruct_name', 'room.room_name')
            ->leftjoin('sysc_room room', 'fas_assetregister.curr_room_no_fk', 'room.room_no_pk')
            ->leftjoin('sysc_physicalstructfloor floor', 'room.physicalstrucure_no_fk', 'floor.physicalstruct_no_pk')
            ->leftjoin('sysc_physicalstructurebuilding building', 'floor.physicalstruct_building_no_fk', 'building.physicalstruct_build_no_pk')
            ->where('ast_register_no_pk', $id)->first();

        $photo_name = DB::table('sysc_serviceitem_vw')->where('item_no_pk', $id)->select('item_photo', 'item_no_pk')->first();
        // dd($photo_name);
        return Template::loadView("admin.uhl.fixed_assets.create_asset_details_popup", ['photo_name' => $photo_name, 'asset_register_data' => $asset_register_data]);
    }

    public function saveDetails(Request $request)
    {

        try {
            $id = $request->item_no;
            // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            // $auth_id = Auth::id();
            // $to_date = date('Y-m-d h:i');
            // $entry_session = 'Asset Register';
            DB::beginTransaction();
            $random_text = Str::random(5);
            $image_name = "";
            if ($files = $request->file('item_photo')) {
                $image_name = $random_text . "." . $files->getClientOriginalExtension();
                // $image_name = $last_id . "." . $files->getClientOriginalExtension();
            }
            // dd(  $request->file('item_photo'));
            $update_image['item_photo'] = $image_name;
            if ($image_name != "") {
                DB::table('sysc_serviceitem')->update($update_image, $id);
                if ($files = $request->file('item_photo')) {
                    $this->uploadImages($files, $random_text, 'images/uploads/item_images/', 'images/uploads/item_images/thumb/');
                }
            }

            // DB::table('sysc_serviceitem')->update($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function saveTransfer(Request $request)
    {
        // dd("pppp");
        try {
            $location = $request->asset_location;
            $store = $request->hdn_asset_store;
            $department = $request->asset_deprt;
            $transfer_by = $request->hdn_person_id;
            $register_no = $request->register_no;
            $item_no = $request->item_no;
            $sl_no = $request->sl_no;
            $receivedtl_no = $request->receivedtl_no;
            $tag_no = $request->tag_no;
            $manual_tag = $request->manual_tag;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $no_pk_seq = $sequence->nextValue('ast_trans_no_pk_seq');
            $out_uid = '';
            $table_name = 'fas_assettransfer';
            $column_name = 'ast_trans_uid';
            $null = null;
            $pdo1 = DB::getPdo();
            $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                        :in_table_name_txt,
                        :in_column_name_txt,
                        :in_hos_yyyymmdd_ind,
                        :in_special_code,
                        :in_au_entry_by,
                        :in_au_entry_session,
                        :in_au_entry_hospital_pk_no,
                        :out_uid
                        );
                        end;");

            $tagGenerate->bindParam(':in_table_name_txt', $table_name);
            $tagGenerate->bindParam(':in_column_name_txt', $column_name);
            $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
            $tagGenerate->bindParam(':in_special_code', $null);
            $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
            $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
            $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
            $tagGenerate->execute();
            DB::commit();
            $null = null;
            $data = [
                'ast_trans_no_pk' => $no_pk_seq,
                'itemreceivedtl_no_fk' => $receivedtl_no,
                'ast_trans_uid' => $out_uid,
                'ast_trans_req_date' =>   $to_date,
                'ast_register_no_fk' =>  $register_no,
                'item_no_fk' =>  $item_no,
                'asset_tag_uid' =>   $tag_no,
                'trans_to_store_su_no_fk' =>   $store,
                'trans_to_room_no_fk' =>   $location,
                'trans_to_person_no_fk' =>  $transfer_by,
                'trans_to_patient_no_fk' =>  $null,
                'main_store_su_no_fk' =>   $request->main_store,
                'curr_store_su_no_fk' =>   $request->current_store,
                'curr_room_no_fk' =>   $request->current_room,
                'module_no_fk' =>   $request->module_no,
                'ast_trans_rcv_ind' =>   1,
                'ast_trans_rcv_date' => $to_date,
                'ast_trans_rcv_by' =>  $auth_id,
                'status' =>   1,
                'au_entry_by' =>   $auth_id,
                'au_entry_at' =>   $to_date,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                'manual_tag' =>  $manual_tag
            ];
            $register_data = [
                'curr_store_su_no_fk' => $store,
                'curr_store_trans_date' => $to_date,
                'curr_room_no_fk' =>   $location,
                'item_serial_number' =>  $sl_no,
                'last_store_su_no_fk' => $request->current_store,
                'last_room_no_fk' => $request->current_room,
                'person_no_fk' => $transfer_by,
            ];
            // dd($register_data);
            DB::table('fas_assettransfer')->insert($data);
            DB::table('fas_assetregister')->where('ast_register_no_pk', $register_no)->update($register_data);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $no_pk_seq];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function assetsTransferConform()
    {
        $userDepartment = session('user.su_pk_no');
        $class = DB::table('fass_assetclass')->where('status', 1)->get();
        $category = DB::table('fass_assetcategory')->where('status', 1)->get();
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $department = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('main_store_ind', 1)->where('status', 1)->get();
        $asset_register_data_arr = []; //DB::table('fas_assetregister')->leftjoin('fass_assetreceive_vw','fass_assetreceive_vw.item_no_fk','=','fas_assetregister.item_no_fk')->get();
        $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE FAS_ASSETTRANSFER.AST_TRANS_RCV_IND IS NULL and CURRENT_PERSON.SERVICEUNIT_NO_FK = $userDepartment
                ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");

        return Template::loadView("admin.uhl.fixed_assets.asset-transfer", ['class' => $class, 'category' => $category, 'department' => $department, 'location' => $location, 'asset_register_data_arr' => $asset_register_data_arr]);
    }


    public function assetsTransferConformSearch(Request $request)
    {
        $department = session('user.su_pk_no');
        // $asset_register_data = DB::table('fas_assettransfer')
        //     ->select('fas_assettransfer.*', 'fass_assetreceive_vw.*', 'current_su.serviceunit_name as current_store', 'current_room.room_name as current_room', 'current_person.full_name', 'current_person.su_name as person_department', 'to_room.room_name as to_room', 'to_su.serviceunit_name as to_su')
        //     ->leftjoin('fass_assetreceive_vw', 'fass_assetreceive_vw.itemreceivedtl_no_pk', '=', 'fas_assettransfer.itemreceivedtl_no_fk')
        //     ->leftjoin('sysc_room current_room', 'current_room.room_no_pk', '=', 'fas_assettransfer.curr_room_no_fk')
        //     ->leftjoin('sysc_serviceunit current_su', 'current_su.serviceunit_no_pk', '=', 'fas_assettransfer.curr_store_su_no_fk')
        //     ->leftjoin('sysc_room to_room', 'to_room.room_no_pk', '=', 'fas_assettransfer.trans_to_room_no_fk')
        //     ->leftjoin('sysc_serviceunit to_su', 'to_su.serviceunit_no_pk', '=', 'fas_assettransfer.trans_to_store_su_no_fk')
        //     ->leftjoin('employee_info_vw current_person', 'current_person.person_no_pk', '=', 'fas_assettransfer.trans_to_person_no_fk');
        if ($request->status != "") {
            if ($request->status == 'requested') {

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE FAS_ASSETTRANSFER.AST_TRANS_RCV_IND IS NULL and CURRENT_PERSON.SERVICEUNIT_NO_FK = $department
                ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            } elseif ($request->status == 'transferred') {

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE fas_assettransfer.AST_TRANS_RCV_IND = 1 and CURRENT_PERSON.SERVICEUNIT_NO_FK = $department
                ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            } elseif ($request->status == 'all') {
                // $asset_register_data->where('fas_assettransfer.ast_trans_rcv_ind', 1);

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                            FASS_ASSETRECEIVE_VW.*,
                            CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                            CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                            CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                            CURRENT_PERSON.FULL_NAME,
                            CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                            TO_ROOM.ROOM_NAME AS TO_ROOM,
                            TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                            TO_SU.SERVICEUNIT_NAME AS TO_SU
                            FROM FAS_ASSETTRANSFER
                            JOIN FASS_ASSETRECEIVE_VW
                            ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                                    FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                            LEFT JOIN SYSC_ROOM CURRENT_ROOM
                            ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                            LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                            ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                            LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                            ON CURRENT_SU.SERVICEUNIT_NO_PK =
                                    FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                            LEFT JOIN SYSC_ROOM TO_ROOM
                            ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                            LEFT JOIN ROOM_LIST_VW TO_FLOOR
                            ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                            LEFT JOIN SYSC_SERVICEUNIT TO_SU
                            ON TO_SU.SERVICEUNIT_NO_PK =
                                    FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                            LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                            ON CURRENT_PERSON.PERSON_NO_PK =
                                    FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                            LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                            ON GRN.ITEMRECEIVEDTL_NO_PK =
                                    FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                                    Where CURRENT_PERSON.SERVICEUNIT_NO_FK = $department
                    ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            }
        }

        return Template::loadView("admin.uhl.fixed_assets.asset-transfer-list", ['asset_register_data_arr' => $asset_register_data_arr]);
    }

    public function assetsTransferConformSearchform(Request $request)
    {
        $department = session('user.su_pk_no');
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($request->asset_tag != "") ? " $clause FAS_ASSETTRANSFER.ASSET_TAG_UID = '$request->asset_tag'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " $clause trunc(fas_assettransfer.ast_trans_req_date) between TO_DATE('$request->search_date_from','DD/MM/YYYY') and TO_DATE('$request->search_date_to','DD/MM/YYYY')" : "";

        if ($request->status != "") {
            if ($request->status == 'requested') {

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE FAS_ASSETTRANSFER.AST_TRANS_RCV_IND IS NULL and CURRENT_PERSON.SERVICEUNIT_NO_FK = $department $sql_cond ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            } elseif ($request->status == 'transferred') {

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE FAS_ASSETTRANSFER.AST_TRANS_RCV_IND = 1 and CURRENT_PERSON.SERVICEUNIT_NO_FK = $department $sql_cond ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            } elseif ($request->status == 'all') {

                $asset_register_data_arr = db::select("  SELECT FAS_ASSETTRANSFER.*,
                FASS_ASSETRECEIVE_VW.*,
                CURRENT_SU.SERVICEUNIT_NAME AS CURRENT_STORE,
                CURRENT_ROOM.ROOM_NAME AS CURRENT_ROOM,
                CURRENT_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS CURRENT_FLOOR,
                CURRENT_PERSON.FULL_NAME,
                CURRENT_PERSON.SU_NAME AS PERSON_DEPARTMENT,
                TO_ROOM.ROOM_NAME AS TO_ROOM,
                TO_FLOOR.PHYSICALSTRUCT_NAME_FL_BLD AS TO_FLOOR,
                TO_SU.SERVICEUNIT_NAME AS TO_SU
                FROM FAS_ASSETTRANSFER
                JOIN FASS_ASSETRECEIVE_VW
                ON FASS_ASSETRECEIVE_VW.ITEMRECEIVEDTL_NO_PK =
                        FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                LEFT JOIN SYSC_ROOM CURRENT_ROOM
                ON CURRENT_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW CURRENT_FLOOR
                ON CURRENT_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.CURR_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT CURRENT_SU
                ON CURRENT_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.CURR_STORE_SU_NO_FK

                LEFT JOIN SYSC_ROOM TO_ROOM
                ON TO_ROOM.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN ROOM_LIST_VW TO_FLOOR
                ON TO_FLOOR.ROOM_NO_PK = FAS_ASSETTRANSFER.TRANS_TO_ROOM_NO_FK

                LEFT JOIN SYSC_SERVICEUNIT TO_SU
                ON TO_SU.SERVICEUNIT_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_STORE_SU_NO_FK
                LEFT JOIN EMPLOYEE_INFO_VW CURRENT_PERSON
                ON CURRENT_PERSON.PERSON_NO_PK =
                        FAS_ASSETTRANSFER.TRANS_TO_PERSON_NO_FK

                LEFT JOIN PHR_ITEMRECEIVEDTL GRN
                ON GRN.ITEMRECEIVEDTL_NO_PK =  FAS_ASSETTRANSFER.ITEMRECEIVEDTL_NO_FK
                WHERE NVL(FAS_ASSETTRANSFER.AST_TRANS_RCV_IND,0) IN (1, 0)  and CURRENT_PERSON.SERVICEUNIT_NO_FK = $department $sql_cond ORDER BY FAS_ASSETTRANSFER.AST_TRANS_NO_PK DESC");
            }
        }

        return Template::loadView("admin.uhl.fixed_assets.asset-transfer-list", ['asset_register_data_arr' => $asset_register_data_arr]);
    }

    public function assetsTransferConformSave(Request $request)
    {
        // dd($request->all());
        try {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            $to_store = $request->to_store == "NaN" ? "" : $request->to_store;
            $last_store = $request->last_store == "NaN" ? "" : $request->last_store;
            // dd("ppp", $to_store);
            $null = null;
            $register_data = [
                'curr_store_su_no_fk' => $to_store ? $request->to_store  : "",
                'curr_store_trans_date' => $to_date,
                'curr_room_no_fk' =>  $request->to_room,
                'last_store_su_no_fk' => $last_store ? $request->last_store : "",
                'last_room_no_fk' => $request->last_room,
                'person_no_fk' => $request->to_person,
                'au_update_by' =>   $auth_id,
                'au_update_at' =>   $to_date,
                'au_update_hospital_pk_no' =>  $ses_hospital_id,
            ];

            // dd($register_data);
            if (DB::table('fas_assetregister')->where('ast_register_no_pk', $request->register_id)->update($register_data)) {
                $transfer_data = [
                    'ast_trans_rcv_ind' => 1,
                    'ast_trans_rcv_date' => $to_date,
                    'ast_trans_rcv_by' =>  $auth_id,
                    'au_update_by' =>   $auth_id,
                    'au_update_at' =>   $to_date,
                    'au_update_hospital_pk_no' =>  $ses_hospital_id,
                ];
                DB::table('fas_assettransfer')->where('ast_register_no_fk', $request->register_id)->update($transfer_data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function updatePopup($id = "")
    {
        // dd($id);
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $floors = DB::table('sysc_physicalstructfloor')->where('status', 1)->get();
        $building = DB::table('sysc_physicalstructurebuilding')->where('status', 1)->get();

        $asset_register_data = DB::table('fas_assetregister')
            ->select('fas_assetregister.*', 'room.physicalstrucure_no_fk', 'building.physicalstruct_build_sl', 'floor.physicalstruct_floor_sl', 'phr_v1_grn_vw.refer_item_specification')
            ->leftjoin('sysc_room room', 'fas_assetregister.curr_room_no_fk', 'room.room_no_pk')
            ->leftjoin('sysc_physicalstructfloor floor', 'room.physicalstrucure_no_fk', 'floor.physicalstruct_no_pk')
            ->leftjoin('sysc_physicalstructurebuilding building', 'floor.physicalstruct_building_no_fk', 'building.physicalstruct_build_no_pk')
            ->leftjoin('phr_v1_grn_vw', function ($join) {
                $join->on('fas_assetregister.itemreceivedtl_no_fk', '=', 'phr_v1_grn_vw.itemreceivedtl_no_pk')
                    ->on('fas_assetregister.item_no_fk', '=', 'phr_v1_grn_vw.item_no_fk');
            })
            ->where('ast_register_no_pk', $id)->first();
        // dd($asset_register_data);
        return Template::loadView("admin.uhl.fixed_assets.asset-register-update-popup", ['asset_register_data' => $asset_register_data, 'location' => $location, 'building' => $building, 'floors' => $floors]);
    }


    public function updateAssetRegister(Request $request)
    {

        try {

            $item_no = $request->asset_id;
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $no_pk_seq = $sequence->nextValue('ast_register_no_pk_seq');
            $data = [
                'country_of_origin' => $request->country_of_origin,
                'curr_room_no_fk' => $request->asset_location,
                'item_model_number' => $request->item_model_number,
                'item_serial_number' => $request->item_serial_number,
                'usage_status' => $request->usage_status,
                'depreciation_residual_val_pct' => $request->depreciation_residual_val_pct,
                'depreciation_residual_val_amt' => $request->depreciation_residual_val_amt,
                'asst_brand' => $request->brand_name,
                'vendor_pm' => $request->vendor_pm,
                'assign_engr_name' => $request->assign_engr,
                'install_date' => $request->ins_date ? date('Y-m-d', strtotime($request->ins_date)) : "",
                'warrenty_start_date' => $request->starting_date ? date('Y-m-d', strtotime($request->starting_date)) : "",
                'warrany_year' => $request->warranty_yr,
                'spare_parts_list' => $request->spare_parts_list,
                'vendor_name' => $request->L_vendor_name,
                'contact_number' => $request->c_number,
                'cmc_start_date' => $request->cmc_start_date ? date('Y-m-d', strtotime($request->cmc_start_date)) : "",
                'handover_date' => $request->handover_date ? date('Y-m-d', strtotime($request->handover_date)) : "",
                'breakdown_time' => $request->breakdown_time,
                'training_date' => $request->training_date ? date('Y-m-d', strtotime($request->training_date)) : "",
                'inhouse_pm_date' => $request->inhouse_pm_date ? date('Y-m-d', strtotime($request->inhouse_pm_date)) : "",
                'physicalstruct_build_no_fk' => $request->asset_building,
                'engineer_name' => $request->engr_name,
                'physicalstruct_no_fk' => $request->asset_floor,
                'responsible_person' => $request->res_person,
                'next_maintanance_date' => $request->next_maintanance_date ? date('Y-m-d', strtotime($request->next_maintanance_date)) : "",
                'maintanance_engr_contact' => $request->maintanance_engr_contact,
                'maintanance_date' => $request->maintanance_date ? date('Y-m-d', strtotime($request->maintanance_date)) : "",
                'free_support_date' => $request->free_support_date ? date('Y-m-d', strtotime($request->free_support_date)) : "",
                'licenance_number' => $request->licenance_number,

                'au_update_by' =>   $auth_id,
                'au_update_at' =>   $date,
                'au_update_hospital_pk_no' =>  $ses_hospital_id,
            ];

            // dd($data);
            DB::table('fas_assetregister')->where('ast_register_no_pk', $request->ast_register_no_pk)->update($data);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $no_pk_seq];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function assetsClass()
    {
        $class_data = DB::table('fass_assetclass')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('assetclass_no_pk', 'desc')->get();
        $class_name = DB::table('fass_assetclass')->get();
        $accounts_head = DB::table('acct_chart_of_accounts')->where('status', 1)->get();

        return Template::loadView("admin.uhl.fixed_assets.asset-setup", ['class_data' => $class_data, 'class_name' => $class_name, 'accounts_head' => $accounts_head]);
    }

    public function assetsTabChange(Request $request)
    {
        $tab_label = $request->tab_lebel;
        if ($tab_label == 2) {
            $category_data = DB::table('fass_assetcategory')
                ->select('fass_assetcategory.*', 'fass_assetclass.*', 'cost.account_name as cost', 'acc_depr.account_name as acc_depr', 'depreciation.account_name as depreciation', 'revalue.account_name as revalue', 'impairment.account_name as impairment', 'bs.account_name as bs', 'tax_is.account_name as is', 'profit.account_name as profit')
                ->leftJoin('fass_assetclass', 'fass_assetclass.assetclass_no_pk', '=', 'fass_assetcategory.assetclass_no_fk')
                ->leftJoin('acct_chart_of_accounts cost', 'cost.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_cost')
                ->leftJoin('acct_chart_of_accounts acc_depr', 'acc_depr.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_accum_depr')
                ->leftJoin('acct_chart_of_accounts depreciation', 'depreciation.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_depr')
                ->leftJoin('acct_chart_of_accounts revalue', 'revalue.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_revaluation')
                ->leftJoin('acct_chart_of_accounts impairment', 'impairment.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_impairment')
                ->leftJoin('acct_chart_of_accounts bs', 'bs.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_deftax_bs')
                ->leftJoin('acct_chart_of_accounts tax_is', 'tax_is.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_deftax_is')
                ->leftJoin('acct_chart_of_accounts profit', 'profit.account_no_pk', '=', 'fass_assetcategory.acat_acc_code_salesprofit')
                ->get();
            // dd($category_data);
            return Template::loadView("admin.uhl.fixed_assets.category_list", ['category_data' => $category_data]);
        } elseif ($tab_label == 3) {
            $tax_data = DB::table('fass_assettaxcode')->where('status', 1)->get();

            return Template::loadView("admin.uhl.fixed_assets.tax_code_list", ['tax_data' => $tax_data]);
        }
    }
    public function assetsClassSave(Request $request)
    {
        try {

            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $no_pk_seq = $sequence->nextValue('assetclass_no_pk_seq');
            $out_uid = '';
            $table_name = 'fass_assetclass';
            $column_name = 'assetclass_uid';
            $null = null;
            $pdo1 = DB::getPdo();
            $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                    :in_table_name_txt,
                    :in_column_name_txt,
                    :in_hos_yyyymmdd_ind,
                    :in_special_code,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_uid
                    );
                    end;");

            $tagGenerate->bindParam(':in_table_name_txt', $table_name);
            $tagGenerate->bindParam(':in_column_name_txt', $column_name);
            $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
            $tagGenerate->bindParam(':in_special_code', $null);
            $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
            $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
            $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
            $tagGenerate->execute();
            DB::commit();
            $null = null;
            $data = [
                'assetclass_no_pk' => $no_pk_seq,
                'assetclass_uid' => $out_uid,
                'assetclass_name' => $request->asset_name,
                'status' =>   1,
                'au_entry_by' =>   $auth_id,
                'au_entry_at' =>   $to_date,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
            ];
            $data_update = [
                'assetclass_name' => $request->asset_name,
                'status' =>   1,
                'au_update_by' =>   $auth_id,
                'au_update_at' =>   $to_date,
                'au_update_hospital_pk_no' =>  $ses_hospital_id,
            ];

            if ($request->class_id == "") {
                DB::table('fass_assetclass')->insert($data);
            } else {
                DB::table('fass_assetclass')->where('assetclass_no_pk', $request->class_id)->update($data_update);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function assetsCategorySave(Request $request)
    {
        try {

            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $no_pk_seq = $sequence->nextValue('assetcat_no_pk_seq');
            $out_uid = '';
            $table_name = 'fass_assetcategory';
            $column_name = 'assetcat_uid';
            $null = null;
            $pdo1 = DB::getPdo();
            $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                    :in_table_name_txt,
                    :in_column_name_txt,
                    :in_hos_yyyymmdd_ind,
                    :in_special_code,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_uid
                    );
                    end;");

            $tagGenerate->bindParam(':in_table_name_txt', $table_name);
            $tagGenerate->bindParam(':in_column_name_txt', $column_name);
            $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
            $tagGenerate->bindParam(':in_special_code', $null);
            $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
            $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
            $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
            $tagGenerate->execute();
            DB::commit();
            $null = null;
            $data = [
                'assetcat_no_pk' => $no_pk_seq, // $no_pk_seq,
                'assetcat_uid' => $out_uid,
                'assetclass_no_fk' => $request->asset__class,
                'assetcat_name' => $request->asset__name,
                'acat_acc_code_cost' => $request->asset__cost,
                'acat_acc_code_accum_depr' => $request->asset__depr,
                'acat_acc_code_depr' => $request->asset_depre,
                'acat_acc_code_revaluation' => $request->asset_revalue,
                'acat_acc_code_impairment' => $request->asset_impairment,
                'acat_acc_code_deftax_bs' => $request->asset_def,
                'acat_acc_code_deftax_is' => $request->asset_defis,
                'acat_acc_code_salesprofit' => $request->profit,
                'depreciation_percent' => $request->depreciation_percent,
                'life_year' => $request->life_year,
                'status' =>   1,
                'au_entry_by' =>   $auth_id,
                'au_entry_at' =>   $to_date,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
            ];
            $data_update = [
                'assetclass_no_fk' => $request->asset__class,
                'assetcat_name' => $request->asset__name,
                'acat_acc_code_cost' => $request->asset__cost,
                'acat_acc_code_accum_depr' => $request->asset__depr,
                'acat_acc_code_depr' => $request->asset_depre,
                'acat_acc_code_revaluation' => $request->asset_revalue,
                'acat_acc_code_impairment' => $request->asset_impairment,
                'acat_acc_code_deftax_bs' => $request->asset_def,
                'acat_acc_code_deftax_is' => $request->asset_defis,
                'acat_acc_code_salesprofit' => $request->profit,
                'acat_acc_code_salesprofit' => $request->profit,
                'depreciation_percent' => $request->depreciation_percent,
                'status' =>   1,
                'au_update_by' =>   $auth_id,
                'au_update_at' =>   $to_date,
                'au_update_hospital_pk_no' =>  $ses_hospital_id,
            ];

            if ($request->asset_cat__no_fk == "") {
                DB::table('fass_assetcategory')->insert($data);
            } else {
                DB::table('fass_assetcategory')->where('assetcat_no_pk', $request->asset_cat__no_fk)->update($data_update);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function assetsTaxSave(Request $request)
    {
        try {

            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $no_pk_seq = $sequence->nextValue('taxcode_no_pk_seq');
            $out_uid = '';
            $table_name = 'fass_assettaxcode';
            $column_name = 'taxcode_uid';
            $null = null;
            $pdo1 = DB::getPdo();
            $tagGenerate = $pdo1->prepare("begin pkg_tools.prc_getuid(
                    :in_table_name_txt,
                    :in_column_name_txt,
                    :in_hos_yyyymmdd_ind,
                    :in_special_code,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no,
                    :out_uid
                    );
                    end;");

            $tagGenerate->bindParam(':in_table_name_txt', $table_name);
            $tagGenerate->bindParam(':in_column_name_txt', $column_name);
            $tagGenerate->bindParam(':in_hos_yyyymmdd_ind', $null);
            $tagGenerate->bindParam(':in_special_code', $null);
            $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
            $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
            $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
            $tagGenerate->bindParam(':out_uid', $out_uid, PDO::PARAM_STR, 500);
            $tagGenerate->execute();
            DB::commit();
            $null = null;
            $data = [

                'taxcode_no_pk' => $no_pk_seq, // $no_pk_seq,
                'taxcode_uid' => $out_uid,
                'asset_forfeiture_ind' => $request->asset__app,
                'taxcode_name' => $request->asset__name,
                'tax_year1_pct' => $request->asset_year_one,
                'tax_year2_pct' => $request->asset_year_two,
                'tax_year3_pct' => $request->asset_year_three,
                'tax_year4_pct' => $request->asset_year_four,
                'tax_year5_pct' => $request->asset_year_five,
                'tax_year1to5_pct' => $request->asset_year_five_total,
                'status' =>   1,
                'au_entry_by' =>   $auth_id,
                'au_entry_at' =>   $to_date,
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
            ];
            $data_update = [
                'asset_forfeiture_ind' => $request->asset__app,
                'taxcode_name' => $request->asset__name,
                'tax_year1_pct' => $request->asset_year_one,
                'tax_year2_pct' => $request->asset_year_two,
                'tax_year3_pct' => $request->asset_year_three,
                'tax_year4_pct' => $request->asset_year_four,
                'tax_year5_pct' => $request->asset_year_five,
                'tax_year1to5_pct' => $request->asset_year_five_total,
                'status' =>   1,
                'au_update_by' =>   $auth_id,
                'au_update_at' =>   $to_date,
                'au_update_hospital_pk_no' =>  $ses_hospital_id,
            ];

            if ($request->asset_tax__no_fk == "") {
                DB::table('fass_assettaxcode')->insert($data);
            } else {
                DB::table('fass_assettaxcode')->where('taxcode_no_pk', $request->asset_tax__no_fk)->update($data_update);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function depreciationStore(Request $request)
    {
        try {

            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $auth_id = Auth::id();
            $to_date = date('Y-m-d h:i');
            $entry_session = 'session';
            DB::beginTransaction();

            $year = $request->year;
            $month = $request->monthy;
            $out_uid = '';
            $table_name = 'fass_assettaxcode';
            $column_name = 'taxcode_uid';
            $null = null;
            $pdo1 = DB::getPdo();
            $tagGenerate = $pdo1->prepare("begin pkg_fixedasset.prc_depreciation_calc_monthly_new(
                    :in_year_to_calc,
                    :in_month_to_calc,
                    :in_main_asset_store_su_no_fk,
                    :in_module_no_fk,
                    :in_status,
                    :in_au_entry_by,
                    :in_au_entry_session,
                    :in_au_entry_hospital_pk_no
                    );
                    end;");

            $tagGenerate->bindParam(':in_year_to_calc', $year);
            $tagGenerate->bindParam(':in_month_to_calc', $month);
            $tagGenerate->bindParam(':in_main_asset_store_su_no_fk', $null);
            $tagGenerate->bindParam(':in_module_no_fk', $null);
            $tagGenerate->bindParam(':in_status', $null);
            $tagGenerate->bindParam(':in_au_entry_by', $auth_id);
            $tagGenerate->bindParam(':in_au_entry_session', $entry_session);
            $tagGenerate->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);

            $tagGenerate->execute();


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function depreciation()
    {
        $minor_group = DB::table('sysc_itemtype')->where('minor_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $asset_item = DB::table('sysc_v1_serviceitem_vw')->select('item_no_pk', 'item_name')->where('asset_group_ind', 1)->where('asset_ind', 1)->where('status', 1)->get();

        return Template::loadView("admin.uhl.fixed_assets.depreciation-calculation", ['minor_group' => $minor_group, 'asset_item' => $asset_item]);
    }
    public function depreciationWorkList()
    {
        return Template::loadView("admin.uhl.fixed_assets.depreciation-work-list");
    }
    public function depreciationWorkListSearch(Request $request)
    {

        $depreciation = DB::table('fas_depreciation_monthly_vw')
            ->select('year_to_calc', 'month_to_calc', 'processed_date', 'processed_by_name', 'date_from_calc', 'date_to_calc', DB::raw('SUM(no_of_unit) AS no_of_unit'));

        $string1 =  $request->date_from;
        $character1 = '/';
        $string2 =  $request->date_to;
        $character2 = '/';

        $position1 = strpos($string1, $character1);
        $position2 = strpos($string2, $character2);
        $depreciation_arr = [];

        if ($request->date_from != "" && $request->date_to != "" && $position1 == true && $position2 == true) {
            $y_d_from = explode('/', $request->date_from);
            $y_d_to = explode('/', $request->date_to);

            $depreciation->whereBetween('year_to_calc',  [$y_d_from[0],  $y_d_to[0]])
                ->whereBetween('month_to_calc', [$y_d_from[1],  $y_d_to[1]]);
            $depreciation_arr = $depreciation->orderBy('year_to_calc', 'asc')->groupBy('year_to_calc', 'month_to_calc', 'processed_date', 'processed_by_name', 'date_from_calc', 'date_to_calc')->orderBy('month_to_calc', 'asc')->get();
        } elseif ($request->date_from != "" && $position1 == true) {
            $y_d = explode('/', $request->date_from);
            $depreciation->where('year_to_calc',  $y_d[0])->where('month_to_calc',  $y_d[1]);
            $depreciation_arr = $depreciation->orderBy('year_to_calc', 'asc')->groupBy('year_to_calc', 'month_to_calc', 'processed_date', 'processed_by_name', 'date_from_calc', 'date_to_calc')->orderBy('month_to_calc', 'asc')->get();
        }


        // $depreciation_arr_group = [];
        // if (!empty($depreciation_arr)) {
        //     foreach ($depreciation_arr as $key => $value) {
        //         $depreciation_arr_group['Month of ' . ' ' . date('F', mktime(0, 0, 0, $value->month_to_calc, 1)) . ' ' . $value->year_to_calc][] = $value;
        //     }
        // }

        return Template::loadView("admin.uhl.fixed_assets.depreciation-work-list-search", ['depreciation_arr' => $depreciation_arr]);
    }
    public function depreciationSearch(Request $request)
    {

        $depreciation = DB::table('fas_depreciation_monthly_vw')
            ->select(
                'processed_date',
                'processed_by_name',
                'major_group_name',
                'dept_rate',
                'month_to_calc',
                'year_to_calc',
                'major_group_no_fk',
                'month_of_calc_yyyymm',
                DB::raw('SUM(cost_balance) as cost_balance'),
                DB::raw('SUM(cost_addition_during_month) as cost_addition_during_month'),
                DB::raw('SUM(cost_disposal_adj) as cost_disposal_adj'),
                DB::raw('SUM(cost_closing_balance) as cost_closing_balance'),
                DB::raw('SUM(dept_balance) as dept_balance'),
                DB::raw('SUM(depr_charged) as depr_charged'),
                DB::raw('SUM(depr_disposal_adj) as depr_disposal_adj'),
                DB::raw('SUM(dept_closing_balance) as dept_closing_balance'),
                DB::raw('SUM(wdv) as wdv')
            );

        // if ($request->asset_id != "") {
        //     $depreciation->where('item_no_fk', $request->asset_id);
        // }
        // if ($request->department_asset != "") {
        //     $depreciation->where('store_su_no_fk', $request->department_asset);
        // }
        // if ($request->major_group != "") {
        //     $depreciation->where('par_itemtype_code', $request->major_group);
        // }
        // if ($request->minor_group != "") {
        //     $depreciation->where('par_itemtype_code', $request->minor_group);
        // }
        $string1 =  $request->date_from;
        $character1 = '/';
        $string2 =  $request->date_to;
        $character2 = '/';

        $position1 = strpos($string1, $character1);
        $position2 = strpos($string2, $character2);
        $depreciation_arr = [];

        if ($request->date_from != "" && $request->date_to != "" && $position1 == true && $position2 == true) {
            $y_d_from = explode('/', $request->date_from);
            $y_d_to = explode('/', $request->date_to);

            $depreciation->whereBetween('year_to_calc',  [$y_d_from[0],  $y_d_to[0]])
                ->whereBetween('month_to_calc', [$y_d_from[1],  $y_d_to[1]]);
            $depreciation_arr = $depreciation;
        } elseif ($request->date_from != "" && $position1 == true) {
            $y_d = explode('/', $request->date_from);
            $depreciation->where('year_to_calc',  $y_d[0])->where('month_to_calc',  $y_d[1]);
            $depreciation_arr = $depreciation;
        }

        $data = $depreciation_arr->groupBy('processed_date', 'processed_by_name', 'major_group_name', 'dept_rate', 'month_to_calc', 'year_to_calc', 'major_group_no_fk', 'month_of_calc_yyyymm')->orderBy('processed_date', 'asc')->get();

        $depreciation_arr = $data;


        $depreciation_arr_group = [];
        if (!empty($depreciation_arr)) {
            foreach ($depreciation_arr as $key => $value) {
                $depreciation_arr_group['Month of ' . ' ' . date('F', mktime(0, 0, 0, $value->month_to_calc, 1)) . ' ' . $value->year_to_calc][] = $value;
            }
        }

        return Template::loadView("admin.uhl.fixed_assets.depreciation-calculation-list", ['depreciation_arr_group' => $depreciation_arr_group]);
    }
    public function depreciationCalculationDetails($code = "", $yearmonth)
    {
        $depreciation_details = DB::table('fas_depreciation_monthly_vw')
            ->select('fas_assetregister_full_vw.*', 'fas_depreciation_monthly_vw.wdv', 'fas_depreciation_monthly_vw.cost_balance', 'fas_depreciation_monthly_vw.cost_closing_balance', 'fas_depreciation_monthly_vw.depr_charged')
            ->leftjoin('fas_assetregister_full_vw', 'fas_depreciation_monthly_vw.ast_register_no_fk', 'fas_assetregister_full_vw.ast_register_no_pk')
            ->where('fas_depreciation_monthly_vw.major_group_no_fk', $code)->where('fas_depreciation_monthly_vw.month_of_calc_yyyymm', $yearmonth)->get();

        return Template::loadView("admin.uhl.fixed_assets.depreciation_calculation_details", ['depreciation_details' => $depreciation_details]);
    }
    public function depreciationCalculationPdfExcel(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $from_date = $request->received_date_from != "" ? date('Y-m-d', strtotime($request->received_date_from)) : '';
        $to_date = $request->received_date_to != "" ? date('Y-m-d', strtotime($request->received_date_to)) : '';
        $title = date('d/m/Y h:i a');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $depreciation = DB::table('fas_depreciation_monthly_vw')
            ->select(
                'processed_date',
                'processed_by_name',
                'major_group_name',
                'dept_rate',
                'month_to_calc',
                'year_to_calc',
                'major_group_no_fk',
                'month_of_calc_yyyymm',
                DB::raw('SUM(cost_balance) as cost_balance'),
                DB::raw('SUM(cost_addition_during_month) as cost_addition_during_month'),
                DB::raw('SUM(cost_disposal_adj) as cost_disposal_adj'),
                DB::raw('SUM(cost_closing_balance) as cost_closing_balance'),
                DB::raw('SUM(dept_balance) as dept_balance'),
                DB::raw('SUM(depr_charged) as depr_charged'),
                DB::raw('SUM(depr_disposal_adj) as depr_disposal_adj'),
                DB::raw('SUM(dept_closing_balance) as dept_closing_balance'),
                DB::raw('SUM(wdv) as wdv')
            );
        if (!empty($request->year_dropdown) && !empty($request->monthy_dropdown_from) &&  !empty($request->monthy_dropdown_to)) {
            $depreciation->where('year_to_calc', $request->year_dropdown)->whereBetween('month_to_calc', [$request->monthy_dropdown_from, $request->monthy_dropdown_to]);
        } else if (!empty($request->year_dropdown) &&  !empty($request->monthy_dropdown_from)) {
            $depreciation->where('year_to_calc', $request->year_dropdown)->where('month_to_calc', $request->monthy_dropdown_from);
        } else if (!empty($request->year_dropdown)) {
            $depreciation->where('year_to_calc', $request->year_dropdown);
        }
        if ($request->minor_group != "") {
            $depreciation->where('minor_group_code', $request->minor_group);
        }
        if ($request->item_name != "") {
            $depreciation->where('minor_group_code', $request->item_name);
        }


        $data = $depreciation->groupBy('processed_date', 'processed_by_name', 'major_group_name', 'dept_rate', 'month_to_calc', 'year_to_calc', 'major_group_no_fk', 'month_of_calc_yyyymm')->orderBy('processed_date', 'asc')->get();

        $depreciation_arr = $data;


        $depreciation_arr_group = [];
        if (!empty($depreciation_arr)) {
            foreach ($depreciation_arr as $key => $value) {
                $depreciation_arr_group['Month of ' . ' ' . date('F', mktime(0, 0, 0, $value->month_to_calc, 1)) . ' ' . $value->year_to_calc][] = $value;
            }
        }

        //  $data['barcode_no'] = $barcode_no;
        // $data['depreciation_arr_group'] = $depreciation_arr_group;
        if ($from_date != "" &&  $to_date != "") {
            $item_no = $request->item_name != "" ? 'and asset_item_no_fk =' . $request->item_name : '';
            $depreciation_date_wise = DB::select("SELECT * FROM fas_depreciationmst_daily_vw WHERE trunc(date_of_depreciation) BETWEEN '$from_date' AND ' $to_date' $item_no");
            $depreciation_arr_group = [];
            if (!empty($depreciation_date_wise)) {
                foreach ($depreciation_date_wise as $key => $value) {
                    $depreciation_arr_group['Month of ' . ' ' . date('F', mktime(0, 0, 0, $value->month_to_calc, 1)) . ' ' . $value->year_to_calc][] = $value;
                }
            }



            if ($request->print_type == 'STOREPDF') {
                $pdf = App::make('dompdf.wrapper');
                $pdf = PDF::loadView('admin.uhl.fixed_assets.depreciation-calculation-print-date-wise', ['barcode_no' => $barcode_no, 'depreciation_arr_group' => $depreciation_arr_group, 'type' => 'PDF', 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                return $pdf->stream("depreciation-calculation-print.pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'STOREEXCL') {

                $pdf =  ['barcode_no' => $barcode_no, 'depreciation_arr_group' => $depreciation_arr_group, 'type' => 'excel', 'from_date' => $from_date, 'to_date' => $to_date];

                $fileToExport = "depreciation-calculation-print-date-wise";
                $html = View("admin.uhl.fixed_assets.depreciation-calculation-print-date-wise")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } else {
            if ($request->print_type == 'STOREPDF') {

                $pdf = App::make('dompdf.wrapper');
                $pdf = PDF::loadView('admin.uhl.fixed_assets.depreciation-calculation-print', ['barcode_no' => $barcode_no, 'depreciation_arr_group' => $depreciation_arr_group, 'type' => 'PDF'])->setPaper('a4', 'landscape');

                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                return $pdf->stream("depreciation-calculation-print.pdf", array("Attachment" => false));
            }
            if ($request->print_type == 'STOREEXCL') {

                $pdf =  ['barcode_no' => $barcode_no, 'depreciation_arr_group' => $depreciation_arr_group, 'type' => 'excel'];

                $fileToExport = "depreciation-calculation-print";
                $html = View("admin.uhl.fixed_assets.depreciation-calculation-print")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        }
    }


    public function fixedAssetRegFinc()
    {
        $major_group = DB::table('sysc_itemtype')->where('major_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $minor_group = DB::table('sysc_itemtype')->where('minor_group_ind', 1)->where('asset_group_ind', 1)->where('status', 1)->get();
        $location = DB::table('sysc_room')->whereRaw('asset_location_ind = 1 or store_location_ind= 1 or open_location_ind= 1')->where('status', 1)->get();
        $department = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('main_store_ind', 1)->where('status', 1)->get();
        return Template::loadView("admin.uhl.fixed_assets.fixed-asset-register", ['major_group' => $major_group, 'minor_group' => $minor_group, 'department' => $department, 'location' => $location]);
    }


    public function fixedAssetRegFincSearch(Request $request)
    {

        $depreciation = DB::table('fas_assetregister_full_vw');

        $depreciation_arr = [];

        if ($request->major_group != "") {
            $depreciation->where('par_itemtype_code', $request->major_group);
        }
        if ($request->minor_group != "") {
            $depreciation->where('ity_group_header_code', $request->minor_group);
        }
        if ($request->category_asset != "") {
            $depreciation->where('curr_store_su_no_fk', $request->category_asset);
        }
        if ($request->asset_location != "") {
            $depreciation->where('curr_room_no_fk', $request->asset_location);
        }




        if ($request->date_from != "" && $request->date_to != "") {

            $depreciation->whereBetween(DB::raw('trunc(asset_tag_at)'), [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime($request->date_to . '+1 days'))]);
        } elseif ($request->date_from != "") {
            $depreciation->whereDate('asset_tag_at', date('Y-m-d', strtotime($request->date_from)));
        }

        $depreciation_arr = $depreciation->orderBy('asset_tag_at', 'desc')->get();

        // dd($depreciation_arr);
        return Template::loadView("admin.uhl.fixed_assets.fixed-asset-register-finc-list", ['depreciation_arr' => $depreciation_arr]);
    }
    public function fixedAssetRegFincPrint(Request $request)
    {

        $depreciation = DB::table('fas_assetregister_full_vw');

        $depreciation_arr = [];

        if ($request->major_group != "") {
            $depreciation->where('par_itemtype_code', $request->major_group);
        }
        if ($request->minor_group != "") {
            $depreciation->where('ity_group_header_code', $request->minor_group);
        }
        if ($request->category_asset != "") {
            $depreciation->where('curr_store_su_no_fk', $request->category_asset);
        }
        if ($request->asset_location != "") {
            $depreciation->where('curr_room_no_fk', $request->asset_location);
        }




        if ($request->date_from != "" && $request->date_to != "") {

            $depreciation->whereBetween(DB::raw('trunc(asset_tag_at)'), [date('Y-m-d', strtotime($request->date_from)), date('Y-m-d', strtotime($request->date_to . '+1 days'))]);
        } elseif ($request->date_from != "") {
            $depreciation->whereDate('asset_tag_at', date('Y-m-d', strtotime($request->date_from)));
        }

        $depreciation_arr = $depreciation->orderBy('asset_tag_at', 'desc')->get();

        if ($request->print_type == 'STOREPDF') {

            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('admin.uhl.fixed_assets.fixed-asset-register-finc-print', ['depreciation_arr' => $depreciation_arr, 'type' => 'PDF'])->setPaper('a4', 'landscape');

            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->stream("depreciation-calculation-print.pdf", array("Attachment" => false));

            // return $this->generatePdf('admin.uhl.fixed_assets.pepreciation-calculation-print', "depreciation_arr_group", $data);
        }
        if ($request->print_type == 'STOREEXCL') {

            $pdf =  ['depreciation_arr' => $depreciation_arr, 'type' => 'excel'];

            $fileToExport = "fixed-asset-register-finc-print";
            $html = View("admin.uhl.fixed_assets.fixed-asset-register-finc-print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
        // dd($depreciation_arr);
        return Template::loadView("admin.uhl.fixed_assets.fixed-asset-register-finc-list", ['depreciation_arr' => $depreciation_arr]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function buildingFloorList(Request $request)
    {
        return Template::loadView('admin.uhl.fixed_assets.asset_register_floor', [
            'floors' => DB::table('sysc_physicalstructfloor')->where('physicalstruct_building_no_fk', $request->building)->where('status', 1)->get()
        ]);
    }
    public function buildingLoctionList(Request $request)
    {
        $location = db::select("select * from sysc_room where physicalstrucure_no_fk = $request->location");
        return Template::loadView('admin.uhl.fixed_assets.asset_register_location', [
            'location' => $location
        ]);
    }


    public function buildingFloorListEdit(Request $request)
    {
        return Template::loadView('admin.uhl.fixed_assets.asset_register_floor_edit', [
            'floors' => DB::table('sysc_physicalstructfloor')->where('physicalstruct_building_no_fk', $request->building)->where('status', 1)->get(), 'asset_register_data' => DB::table('fas_assetregister')
                ->select('fas_assetregister.*', 'room.physicalstrucure_no_fk', 'building.physicalstruct_build_sl', 'floor.physicalstruct_floor_sl')
                ->leftjoin('sysc_room room', 'fas_assetregister.curr_room_no_fk', 'room.room_no_pk')
                ->leftjoin('sysc_physicalstructfloor floor', 'room.physicalstrucure_no_fk', 'floor.physicalstruct_no_pk')
                ->leftjoin('sysc_physicalstructurebuilding building', 'floor.physicalstruct_building_no_fk', 'building.physicalstruct_build_no_pk')
                ->where('item_no_fk', $request->id)->first()
        ]);
    }
    public function buildingLoctionListEdit(Request $request)
    {
        $location = db::select("select * from sysc_room where physicalstrucure_no_fk = $request->location");
        return Template::loadView('admin.uhl.fixed_assets.asset_register_location_edit', [
            'location' => $location, 'asset_register_data' =>  DB::table('fas_assetregister')
                ->select('fas_assetregister.*', 'room.physicalstrucure_no_fk', 'building.physicalstruct_build_sl', 'floor.physicalstruct_floor_sl')
                ->leftjoin('sysc_room room', 'fas_assetregister.curr_room_no_fk', 'room.room_no_pk')
                ->leftjoin('sysc_physicalstructfloor floor', 'room.physicalstrucure_no_fk', 'floor.physicalstruct_no_pk')
                ->leftjoin('sysc_physicalstructurebuilding building', 'floor.physicalstruct_building_no_fk', 'building.physicalstruct_build_no_pk')
                ->where('item_no_fk', $request->id)->first()
        ]);
    }
    public function getLastMonthData()
    {
        $data = DB::select("select MONTH_OF_CALC_YYYYMM from FAS_DEPRECIATION_MONTHLY_VW order by PROCESSED_DATE desc");
        $process_data = [];
        if (!empty($data)) {
            $process_data = $data[0]->month_of_calc_yyyymm;
        }
        return response()->json($process_data);
    }


    public function getLastMonthDataCancel(Request $request)
    {
        $lastCalMonth = $request->yearMonth;
        DB::table('fas_depreciationdtl_monthly')->where('MONTH_OF_CALC_YYYYMM', $lastCalMonth)->delete();

        DB::commit();
        $message = ['msg' => 'Depreciation Data Deleted Successfully', 'title' => 'Success'];
        return response()->json($message);

        return redirect()->route('v1.depreciation-calculation');
    }

    public function depreciationV2()
    {
        return Template::loadView("admin.uhl.fixed_assets.v2.depreciation-calculation_v2");
    }

    public function getDepreciationV2(){
        $gl = $this->depreciation->get_fixed_asset_depreciation_details();

        $to_date = date('Y-m-d');
        $from_date = date('Y-m-d');


        $first_day_of_current_month = date('Y-m-01');
        $last_day_of_last_month = date('Y-m-d', strtotime('-1 day', strtotime($first_day_of_current_month)));
        $data = [];
        foreach ($gl as $key => $value) {

           $dr_cr_amount = $this->depreciation->datewise_balance_sheet_without_depreciation($to_date, $to_date, $value->account_no_pk);

           $total_depreciation = 0;
           if(!empty($value->dep_account_no_pk)){
            $total_depreciation = $this->depreciation->fixedAssetDepreciationDaily($to_date, $value->dep_account_no_pk);
           }

           $last_month_depreciation = $this->depreciation->lastMonthDepreciation($value->dep_account_no_pk);

           $balance = $this->depreciation->datewise_balance_sheet($to_date, $value->account_no_pk);
           $rate = DB::select("select avg(ASSET_DEPRECIATION_PCT) dep_pct from sysc_itemtype where ACC_LEDGER_NO_FK='$value->account_no_pk'");
           $current_month_dep =  (floatval($rate[0]->dep_pct / 12) * floatval($dr_cr_amount[0]->dr_amount))/100;
           $temp = (object)[
                    'account_code' => $value->account_code,
                    'account_no_pk' => $value->account_no_pk,
                    'account_name' => $value->account_name,
                    'dep_account_no_pk' => $value->dep_account_no_pk,
                    'dr_amount' => $dr_cr_amount[0]->dr_amount,
                    'cr_amount' => $dr_cr_amount[0]->cr_amount,
                    'total_depreciation_amount' => $total_depreciation,
                    'balance' => $balance[0]->amount,
                    'rate'    => $rate[0]->dep_pct,
                    'current_month_depreciation'=> $current_month_dep,
                    'last_month_amount' => isset($last_month_depreciation->amount) ? $last_month_depreciation->amount : 0,
                    'last_generated_date' => isset($last_month_depreciation->journal_date) ? $last_month_depreciation->journal_date : '',
                ];
            array_push($data, $temp);
        }

        return response()->json(['data' => $data],200);
    }

    public function generateDepreciationV2(Request $request){
        $request->validate([
            'account_no_pk' => 'required',
            'current_month_depreciation' => 'required',
        ]);

        try {

            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($request->account_no_pk)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 422);
            }

            //get journal code
            $journal_no = DB::table('acct_journal_entry')->select('journal_no')->orderBy('journal_no_pk','desc')->first();
            $journal_type = DB::table('acct_voucher_type')->whereRaw("lower(voucher_type_name) = 'journal'")
                                                          ->orwhereRaw("lower(voucher_type_name) = 'journal voucher'")
                                                          ->orwhereRaw("lower(voucher_type_name) = 'journal invoice'")->select('voucher_type_code','voucher_type_no_pk')->first();


             if(!isset($journal_type->voucher_type_code)){
                return response()->json(['success' => false, 'message' => 'Journal Voucher Not Found'], 422);
            }


            $data['journal_type'] = $journal_type->voucher_type_code;
            $journal_type_pk = $journal_type->voucher_type_no_pk;
            $journal_type = $journal_type->voucher_type_code;
            if (empty($journal_no->journal_no)) {
                $journal_no = 1;
            } else {
                $journal_no = $journal_no->journal_no+1;
            }
            // dd($journal_no);


            $dateString = date('m/d/Y');
            $dateTimeObj = DateTime::createFromFormat('m/d/Y', $dateString);
            $timestamp = $dateTimeObj->getTimestamp();
            $current_my = date('Y-m-d', $timestamp);
            $formattedDate = substr($current_my,0,7);

            $journal_count = DB::table('acct_journal_entry')
                ->selectRaw("voucher_type_no_fk,journal_code,journal_date")
                ->where('voucher_type_no_fk', $data['journal_type'])
                ->whereRaw("SUBSTR(to_char(journal_date,'YYYY-MM-DD'), 0,7) = '$formattedDate'")
                ->groupBy('voucher_type_no_fk','journal_code','journal_date')
                ->orderBy('journal_code','asc')
                ->get();

            $journal_count = count($journal_count) + 1;
            $voucher_no = $journal_type.date("Ym").str_pad(@$journal_count, 4, '0', STR_PAD_LEFT);
            $voucher_no = $this->checkVoucherCode($voucher_no);


            // close get journal code
            if($voucher_no == '' || empty($voucher_no) || $voucher_no == null){
                return response()->json(['success' => false, 'message' => 'Something Went Wrong. Please Try Again Letter'], 422);
            }

            if(DB::table('acct_journal_entry')->where('journal_code',$voucher_no)->count() > 0){
                return response()->json(['success' => false, 'message' => 'This Voucher No already Exists!'], 422);
            }

            $sequence = DB::getSequence();
            $journal_master_no_pk = $sequence->nextValue('journalmst_no_pk_seq');
            $module_no = DB::table('sysc_module')->select('module_no_pk')->where('module_code','ACCOUNTS')->first();
            $total_dr = array_sum($request->current_month_depreciation);

            $datas = [
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'voucher_type_no_fk' => $journal_type_pk,
                'status' => 1,
                'journal_date' => date("Y-m-d"),
                'auto_posting_ind' => 0,
                'voucher_remarks' => 'Voucher Generated from fixed asset Depreciation'

            ];

            DB::beginTransaction();
            if(!DB::table('acct_journal_entrymst')->where($datas)->exists()){

                $datas['dr_account_amount'] = $total_dr;
                $datas['cr_account_amount'] = $total_dr;
                $datas['doc_date'] = date("Y-m-d");
                $datas['module_no_fk'] = $module_no->module_no_pk;
                $datas['journal_code'] = $voucher_no;
                $datas['journalmst_no_pk'] = $journal_master_no_pk;
                $datas['au_entry_at'] = $au_entry_at;
                DB::table('acct_journal_entrymst')->insert($datas);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Today Aready Generated'], 422);
            }

            $lastInsertedId = DB::table('acct_journal_entrymst')
                                    ->orderByDesc('journalmst_no_pk')
                                    ->value('journalmst_no_pk');

             if(empty($lastInsertedId)){
                return response()->json(['success' => false, 'message' => 'Something went wrong!'], 422);
             }
            // Cr Entry
            $dep_amount_total = 0;
            foreach($request->account_no_pk as $key => $item){
                $child_sequence = DB::getSequence();
                $journal_child_no_pk = $child_sequence->nextValue('journal_no_pk_seq');
                $balance = $this->depreciation->datewise_balance_sheet(date("Y-m-d"), $request->account_pk[$key]);

                $dep_amount = str_replace(',', '', $request->current_month_depreciation[$key]);

                if(isset($balance[0]->amount)){
                   if($balance[0]->amount > 0){
                        if($dep_amount > $balance[0]->amount){
                            $dep_amount = $balance[0]->amount;
                        }

                        $child_data = [
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,
                            'journal_no_pk' => $journal_child_no_pk,
                            'journal_date' => date("Y-m-d"),
                            'voucher_type_no_fk' => $journal_type_pk,
                            'trn_account_no_fk' => $item,
                            'trn_account_code' => $request->account_code[$key],
                            'narration_text' => 'Depreciation Generated on'.date("Y-m-d"),
                            'auto_posting_ind' => 0,
                            'journal_no' => $journal_no,
                            'journal_code' => $voucher_no,
                            'acct_subledger_no_fk' => 0,
                            'acct_subledger_type_fk' => 0,
                            'costcenter_no_fk' => 0,
                            'module_no_fk' => $module_no->module_no_pk,
                            'voucher_remarks' =>  'Voucher Generated from fixed asset Depreciation',
                            'person_no_fk' => null,
                            'supplier_no_fk' => null,
                            'patient_no_fk' => null,
                            'auto_posting_ref_value' => 0,
                            'auto_posting_ref_by' => null,
                            'auto_posting_ref_type' => null,
                            'verify_req_ind' => 0,
                            'verified_ind' => 0,
                            'verified_entry_by' => null,
                            'verified_entry_at' => null,
                            'finalized_ind' => 0,
                            'finalized_entry_by' => null,
                            'finalized_entry_at' => null,
                            'bank_cheq_number'  => null,
                            'bank_cheq_date'   => null


                        ];

                        $child_data['trn_dr_account_amount'] = 0;
                        $child_data['trn_cr_account_amount'] = $dep_amount;

                        if(!DB::table('acct_journal_entry')->where($child_data)->exists()){
                            $child_data['journalmst_no_fk'] = $lastInsertedId;
                            DB::table('acct_journal_entry')->insert($child_data);
                            $dep_amount_total+=$dep_amount;
                        }
                   }
                }

            }

            // Dr Entry
            $child_sequence = DB::getSequence();
            $journal_child_no_pk = $child_sequence->nextValue('journal_no_pk_seq');
            $trn_account = DB::table('acct_chart_of_accounts')->where('depreciation_exp_ind',1)->select('account_code','account_no_pk')->first();

            if(!isset($trn_account->account_code)){
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Expense Head not Found'], 422);
            }

            $child_data = [
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'journal_no_pk' => $journal_child_no_pk,
                'journal_date' => date("Y-m-d"),
                'voucher_type_no_fk' => $journal_type_pk,
                'trn_account_no_fk' => $trn_account->account_no_pk ,
                'trn_account_code' => $trn_account->account_code,
                'narration_text' => 'Depreciation Generated on'.date("Y-m-d"),
                'auto_posting_ind' => 0,
                'journal_no' => $journal_no,
                'journal_code' => $voucher_no,
                'acct_subledger_no_fk' => 0,
                'acct_subledger_type_fk' => 0,
                'costcenter_no_fk' => 0,
                'module_no_fk' => $module_no->module_no_pk,
                'voucher_remarks' =>  'Voucher Generated from fixed asset Depreciation',
                'person_no_fk' => null,
                'supplier_no_fk' => null,
                'patient_no_fk' => null,
                'auto_posting_ref_value' => 0,
                'auto_posting_ref_by' => null,
                'auto_posting_ref_type' => null,
                'verify_req_ind' => 0,
                'verified_ind' => 0,
                'verified_entry_by' => null,
                'verified_entry_at' => null,
                'finalized_ind' => 0,
                'finalized_entry_by' => null,
                'finalized_entry_at' => null,
                'bank_cheq_number'  => null,
                'bank_cheq_date'   => null


            ];

            $child_data['trn_dr_account_amount'] =  $dep_amount_total;
            $child_data['trn_cr_account_amount'] = 0;

            if(!DB::table('acct_journal_entry')->where($child_data)->exists()){
                $child_data['journalmst_no_fk'] = $lastInsertedId;
                DB::table('acct_journal_entry')->insert($child_data);
            }

            if($total_dr != $dep_amount_total){
                DB::table('acct_journal_entrymst')->where('journalmst_no_pk',$lastInsertedId)->update(['dr_account_amount' => $dep_amount_total, 'cr_account_amount' => $dep_amount_total ]);
            }
            DB::commit();

            $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
            return response()->json(['success' => true, 'message' => 'Successfully Saved','voucher'=> $voucher_no,'hospital_code'=> $hospital_code], 200);

        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function checkVoucherCode($voucher_no){
        if(DB::table('acct_journal_entry')->where('journal_code',$voucher_no)->count() > 0){
            $lastFourDigits = intval(substr($voucher_no, -4)) + 1;
            $modifiedCode = substr_replace($voucher_no, str_pad($lastFourDigits, 4, '0', STR_PAD_LEFT), -4);
            return $this->checkVoucherCode($modifiedCode);
        }
        else{
            return $voucher_no;
        }
    }

    public function depreciationWorklistV2(){
        return Template::loadView("admin.uhl.fixed_assets.v2.depreciation-worklist_v2");
    }

    public function getDepreciationWorklistV2(){

        $query = DB::table('ACCT_JOURNALENTRY_DTL_VW')
                ->select("journal_code",DB::raw("TO_CHAR(journal_date,'YYYY-MM-DD') as journal_date"),"verified_ind","voucher_type_name")
                ->selectRaw('SUM(trn_cr_account_amount) as cr, SUM(trn_dr_account_amount) as dr')
                ->where('BAL_INC_TAG','DEPEXPENSE')
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
        $query->groupBy('journal_code','journal_date','verified_ind','voucher_type_name')
                ->orderBy('journal_code','asc');

        $data = $query->get();

        return response()->json(['data' => $data],200);
    }

}
