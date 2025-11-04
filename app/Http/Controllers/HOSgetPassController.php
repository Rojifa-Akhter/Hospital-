<?php

namespace App\Http\Controllers;

use App;
use PDO;
use PDF;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB as FacadesDB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HOSgetPassController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = "")
    {
        $uom = FacadesDB::table("sysc_serviceitem_uom")->select("uom_no_pk", "uom_code")->where("status", 1)->get();

        $allSuppliers = DB::table('INV_SUPPLIER')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $supplier_arr = [];
        if (!empty($allSuppliers)) {
            foreach ($allSuppliers as $row) {
                $supplier_arr[$row->supplier_no_pk] = $row->supplier_name;
            }
        }
        // $gatepass_type = $this->getLookupListByCode("GATEPASSTYPE");
        $gatepass_type = DB::table('sysc_lookup')
            ->leftJoin('sysc_lookupdata', 'sysc_lookup.lookup_no_pk', '=', 'sysc_lookupdata.lookup_no_fk')
            ->select('sysc_lookupdata.lookupdata_no_pk', 'sysc_lookupdata.lookupdata_name', 'sysc_lookupdata.lookupdata_code')
            // ->where('sysc_lookup.lookup_code', '=', 'gatepasstype')
            ->where('sysc_lookup.lookup_code', 'GATEPASSTYPE')
            ->get();

        // dd($gatepass_type);


        $gatepassMst = [];
        $gatepassDtl = [];
        if ($id != "") {
            if (Session::get("user.approval_ind") == 1) {
                $gatepassMst = DB::table('inv_gatepass_vw')->where('gatepass_no_pk', $id)->first();
            } else {
                $gatepassMst = DB::table('inv_gatepass_vw')->where('gatepass_no_pk', $id)->where('store_no_fk', Session::get('user.su_pk_no'))->first();
            }

            // dd($gatepassMst);
            $gatepassDtl = DB::table('inv_gatepassdtl')->where('gatepass_no_pk', $gatepassMst->gatepass_no_pk)->get()->toArray();
        }

        return Template::loadView("admin.uhl.inventory.gatepass-entry", ['supplier_arr' => $supplier_arr, 'gatepassMst' => $gatepassMst, 'gatepassDtl' => $gatepassDtl, 'gatepass_type' => $gatepass_type, 'uom' => $uom]);
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
       $personal_no = Session::get('user.ses_person_no_fk');

        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {

        $item_id = $item_name = $item_code = $item_qty = $item_model = $item_uom_name = $item_uom_no = $item_remarks = $zero_arr = $empty_arr = $serial = [];

        if (!empty($request->item_id)) {

            $item_count = count($request->item_id);
            for ($i = 0; $i < $item_count; $i++) {
                $item_id[$i] = $request->item_id[$i];
                $item_name[$i] = $request->item_name[$i];
                $item_code[$i] = $request->item_code[$i];
                $item_qty[$i] = $request->item_qty[$i];
                $item_model[$i] = $request->model_name[$i];
                $item_uom_name[$i] = $request->uon_name[$i];
                $item_uom_no[$i] = $request->uon_no[$i];
                $item_remarks[$i] = $request->item_remarks[$i];
                $serial[$i] = $i + 1;
                $zero_arr[$i] = 0;
                $empty_arr[$i] = "";
            }
        }
        // dd($item_id,$item_name,$item_code,$item_qty,$item_model,$item_uom_name,$item_uom_no,$item_remarks,$serial);

        $entry_session = "session";
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $hospital_id = $ses_hospital_id;
        $numelems = 1000;

        $out_getpass_no = $outError = $out_getpass_uid = '';
        $pdo = DB::getPdo();

        $getpass = $pdo->prepare("begin pkg_v1_inventory_all.prc_gatepass(
            :in_gatepass_no_pk,
            :in_gatepass_type,
            :in_supplier_no_fk,
            :in_vendor_supplier_name,
            :in_store_no_fk,
            :in_itemreturn_reason,
            :in_issued_to_name,
            :in_issued_to_contact_number,
            :in_issue_date,
            :in_gatepass_purpose_short,
            :in_gatepass_purpose_desc,
            :in_return_date,
            :in_allowed_dates_from,
            :in_allowed_dates_to,
            :in_returnable_ind,
            :in_onetime_use_ind,
            :in_gate_pass_referrance_type,
            :in_ref_primary_key_value,
            :in_itemreturn_no_fk,
            :in_gatepass_note,
            :in_person_no_fk,
            :in_patient_no_fk,
            :in_sec_in_out,
            :in_edit_ind,
            :in_gatepass_save_option,
            :in_item_no_fk,
            :in_item_name,
            :in_item_code,
            :in_item_model,
            :in_item_uom,
            :in_item_uom_text,
            :in_item_qty,
            :in_item_rate,
            :in_internal_batch_no,
            :in_batch_no,
            :in_expiry_date,
            :in_item_remarks,
            :in_entry_serial_dtl,
            :in_itemreturndtl_no_fk,
            :in_inv_requisitiondtl_no_pk,
            :in_invoicedtl_no_pk,
            :in_purchaseorderdtl_no_pk,
            :in_itemreceivedtl_no_pk,
            :in_cost_price,
            :in_purchase_price,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_gatepass_no_pk,
            :out_gatepass_uid,
            :out_error
        ); end;");

        $getpassId = $request->getpassId != "" ? $request->getpassId : 0;
        $getpass_type = $request->gate_pass_type;
        if ($request->gatepass_name != "") {
            $getpass_name = $request->gatepass_name;
        } else {
            $getpass_name = $request->internal_gatepass_name;
        }

        $phone_no = $request->phone_no;
        // $personal_no = $request->personal_no;
        $getpass_date = $request->gatepass_date != "" ? date('Y-m-d', strtotime($request->gatepass_date)) : '';
        $purpose_problem = $request->purpose_problem;
        $vendor_no = $request->vendor_name;
        $return_date = $request->return_date != "" ? date('Y-m-d', strtotime($request->return_date)) : '';
        $allowed_dates_from = $request->allowed_dates_from != "" ? date('Y-m-d', strtotime($request->allowed_dates_from)) : '';
        $allowed_dates_to = $request->allowed_dates_to != "" ? date('Y-m-d', strtotime($request->allowed_dates_to)) : '';
        $description = $request->description;
        $returnable = $request->returnable;
        $onetime_pass = $request->onetime_pass;
        $department = $request->department;
        $in_out = $request->in_out;
        $zero = 0;
        $empty = '';

        $supplier_id = DB::table('inv_supplier')->select('supplier_name')->where('supplier_no_pk', $vendor_no)->first();
        $supplier_name = !empty($supplier_id) ? $supplier_id->supplier_name : '';
        $save_option = $request->save_option;
        if ($save_option == "POST") {
            $edit_ind = 1;
        } else {
            $edit_ind = 0;
        }
        $getpass->bindParam(':in_gatepass_no_pk', $getpassId);
        $getpass->bindParam(':in_gatepass_type', $getpass_type);
        $getpass->bindParam(':in_supplier_no_fk', $vendor_no);
        $getpass->bindParam(':in_vendor_supplier_name', $supplier_name);
        $getpass->bindParam(':in_store_no_fk', $department);
        $getpass->bindParam(':in_itemreturn_reason', $empty);
        $getpass->bindParam(':in_issued_to_name', $getpass_name);
        $getpass->bindParam(':in_issued_to_contact_number', $phone_no);
        $getpass->bindParam(':in_issue_date', $getpass_date);
        $getpass->bindParam(':in_gatepass_purpose_short', $purpose_problem);
        $getpass->bindParam(':in_gatepass_purpose_desc', $description);
        $getpass->bindParam(':in_return_date', $return_date);
        $getpass->bindParam(':in_allowed_dates_from', $allowed_dates_from);
        $getpass->bindParam(':in_allowed_dates_to', $allowed_dates_to);
        $getpass->bindParam(':in_returnable_ind', $returnable);
        $getpass->bindParam(':in_onetime_use_ind', $onetime_pass);
        $getpass->bindParam(':in_gate_pass_referrance_type', $empty);
        $getpass->bindParam(':in_ref_primary_key_value', $zero);
        $getpass->bindParam(':in_itemreturn_no_fk', $zero);
        $getpass->bindParam(':in_gatepass_note', $empty);
        $getpass->bindParam(':in_person_no_fk', $personal_no);
        $getpass->bindParam(':in_patient_no_fk', $zero);
        $getpass->bindParam(':in_sec_in_out', $in_out);
        $getpass->bindParam(':in_edit_ind', $edit_ind);
        $getpass->bindParam(':in_gatepass_save_option', $save_option);

        $getpass->bindArray(':in_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
        $getpass->bindArray(':in_item_name', $item_name, count($item_name), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_item_code', $item_code, count($item_code), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_item_model', $item_model, count($item_model), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_item_uom', $item_uom_no, count($item_uom_no), $numelems, SQLT_INT);
        $getpass->bindArray(':in_item_uom_text', $item_uom_name, count($item_uom_name), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_item_qty', $item_qty, count($item_qty), $numelems, SQLT_FLT);
        $getpass->bindArray(':in_item_rate', $zero_arr, count($zero_arr), $numelems, SQLT_FLT);
        $getpass->bindArray(':in_internal_batch_no', $empty_arr, count($empty_arr), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_batch_no', $empty_arr, count($empty_arr), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_expiry_date', $empty_arr, count($empty_arr), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_item_remarks', $item_remarks, count($item_remarks), $numelems, SQLT_CHR);
        $getpass->bindArray(':in_entry_serial_dtl', $serial, count($serial), $numelems, SQLT_INT);
        $getpass->bindArray(':in_itemreturndtl_no_fk', $zero_arr, count($zero_arr), $numelems, SQLT_INT);
        $getpass->bindArray(':in_inv_requisitiondtl_no_pk', $zero_arr, count($zero_arr), $numelems, SQLT_INT);
        $getpass->bindArray(':in_invoicedtl_no_pk', $zero_arr, count($zero_arr), $numelems, SQLT_INT);
        $getpass->bindArray(':in_purchaseorderdtl_no_pk', $zero_arr, count($zero_arr), $numelems, SQLT_INT);
        $getpass->bindArray(':in_itemreceivedtl_no_pk', $zero_arr, count($zero_arr), $numelems, SQLT_INT);
        $getpass->bindArray(':in_cost_price', $zero_arr, count($zero_arr), $numelems, SQLT_FLT);
        $getpass->bindArray(':in_purchase_price', $zero_arr, count($zero_arr), $numelems, SQLT_FLT);

        $getpass->bindParam(':in_au_entry_by', $auth_id);
        $getpass->bindParam(':in_au_entry_session', $entry_session);
        $getpass->bindParam(':in_au_entry_hospital_no_fk', $ses_hospital_id);
        $getpass->bindParam(':out_gatepass_no_pk', $out_getpass_no, PDO::PARAM_INT);
        $getpass->bindParam(':out_gatepass_uid', $out_getpass_uid, PDO::PARAM_STR, 100000);
        $getpass->bindParam(':out_error', $outError, PDO::PARAM_STR, 100000);
        //   dd($getpass);
        $getpass->execute();

        if ($outError == 000) {
            DB::commit();
            $message = ['msg' => ' successfully.', 'title' => 'Success'];
        } else {

            DB::rollback();
            $message = ['msg' => 'Failed' . $outError, 'title' => 'Error'];
        }

        //}
        // catch (\Exception $e) {
        //        DB::rollback();
        //        $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }

    public function gatePassWorkList()
    {
        // ->where('store_no_fk',Session::get('user.su_pk_no'))

        $getapassMstDraft = DB::table('inv_gatepass_vw')
            ->select('department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
            // ->leftjoin('inv_supplier','inv_supplier.supplier_no_pk','=','inv_gatepassmst.vendor_supplier_no_fk')
            // ->leftjoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_gatepassmst.store_no_fk')
            ->where('store_no_fk', Session::get('user.su_pk_no'))
            ->whereDate('gatepass_date', date('Y-m-d'))
            ->orderBy('gatepass_no_pk', 'desc')
            ->distinct('gatepass_no_pk')
            ->get();

        $getapassMstPost = []; //DB::table('inv_gatepassmst')->select('inv_gatepassmst.*','inv_supplier.supplier_name','sysc_serviceunit.serviceunit_name',DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepassmst.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))->leftjoin('inv_supplier','inv_supplier.supplier_no_pk','=','inv_gatepassmst.vendor_supplier_no_fk')->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_gatepassmst.store_no_fk')->where('store_no_fk',Session::get('user.su_pk_no'))->where('gatepass_save_option','POST')->whereDate('inv_gatepassmst.gatepass_date',date('Y-m-d'))->orderBy('gatepass_no_pk','desc')->get();


        // dd($getapassMstDraft);
        return Template::loadView("admin.uhl.inventory.gatepass-worklist", ['getapassMstDraft' => $getapassMstDraft, 'getapassMstPost' => $getapassMstPost]);
    }

    public function returnablegatePassWorkList(){
        $dept = DB::table('inv_gatepass_vw')
                    ->select('store_no_fk','department')
                    ->where('returnable_ind', 1)
                    ->where('print_ind', '1')
                    ->groupBy('store_no_fk','department')
                    ->orderByRaw('lower(department) asc')->get();

        return Template::loadView("admin.uhl.inventory.returnable-gate-pass-worklist",compact('dept'));
    }

    public function gatePassWorkListSecurityIncharge()
    {
        // ->where('store_no_fk',Session::get('user.su_pk_no'))

        $getapassMstDraft = DB::table('inv_gatepass_vw')
            ->select('inv_gatepass_vw.*', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))->whereDate('inv_gatepass_vw.gatepass_date', date('Y-m-d'))->orderBy('gatepass_no_pk', 'desc')->get();

        $getapassMstPost = [];
        // dd($getapassMstPost);
        return Template::loadView("admin.uhl.inventory.gatepass-worklist-security-incharge", ['getapassMstDraft' => $getapassMstDraft, 'getapassMstPost' => $getapassMstPost]);
    }
    public function SearchGatePassWorkListDraftSIncharge(Request $request)
    {
        $gid = $request->gid;
        $serial_no = $request->serial_no;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';

        $getapassMstDrafts = DB::table('inv_gatepass_vw')
            ->select('inv_gatepass_vw.*', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'));


        if ($serial_no != "") {
            $getapassMstDrafts->where('sl_no', $serial_no);
        }
        if ($gid != "") {
            $getapassMstDrafts->where('gatepass_uid', $gid);
        }
        if ($request->save_optin != "") {
            $getapassMstDrafts->where('gatepass_save_option', $request->save_optin);
        }
        if ($from_date != "" &&  $to_date != "") {
            $getapassMstDrafts->whereBetween('gatepass_date', [$from_date, $to_date]);
        } else if ($from_date != "") {
            $getapassMstDrafts->whereDate('gatepass_date', $from_date);
        }
        $getapassMstDraft =   $getapassMstDrafts->orderBy('gatepass_no_pk', 'desc')->get();
        return Template::loadView("admin.uhl.inventory.gatepass_worklist_draft", ['getapassMstDraft' => $getapassMstDraft]);
    }

    public function SearchGatePassWorkListDraft(Request $request)
    {
        // $serial_no = $request->serial_no;
        // $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        // $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';

        // $getapassMstDrafts = DB::table('inv_gatepass_vw')
        //     ->select('inv_gatepass_vw.*', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'));


        // if ($serial_no != "") {
        //     $getapassMstDrafts->where('sl_no', $serial_no);
        // }
        // if ($request->save_optin != "") {
        //     $getapassMstDrafts->where('gatepass_save_option', $request->save_optin);
        // }
        // if ($from_date != "" &&  $to_date != "") {
        //     $getapassMstDrafts->whereBetween('gatepass_date', [$from_date, $to_date]);
        // } else if ($from_date != "") {
        //     $getapassMstDrafts->whereDate('gatepass_date', $from_date);
        // }
        // $getapassMstDraft =   $getapassMstDrafts->where('store_no_fk', Session::get('user.su_pk_no'))->orderBy('gatepass_no_pk', 'desc')->get();

        $gid = $request->gid;
        $serial_no = $request->serial_no;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';

        $getapassMstDrafts = DB::table('inv_gatepass_vw')
            ->select('department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
            ->where('store_no_fk', Session::get('user.su_pk_no'))
            ->orderBy('gatepass_no_pk', 'desc')
            ->distinct('gatepass_no_pk');


        // if ($serial_no != "") {
        //     $getapassMstDrafts->where('sl_no', $serial_no);
        // }

        if ($gid != "") {
            $getapassMstDrafts->where('gatepass_uid', $gid);
        }

        if ($request->save_optin != "") {
            $getapassMstDrafts->where('gatepass_save_option', $request->save_optin);
        }
        if ($from_date != "" &&  $to_date != "") {
            $getapassMstDrafts->whereBetween('gatepass_date', [$from_date, $to_date]);
        } else if ($from_date != "") {
            $getapassMstDrafts->whereDate('gatepass_date', $from_date);
        }
        $getapassMstDraft =   $getapassMstDrafts->get();
        // dd($getapassMstDraft);

        return Template::loadView("admin.uhl.inventory.gatepass_worklist_draft", ['getapassMstDraft' => $getapassMstDraft]);
    }

    public function SearchGatePassWorkListReturnable(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required'
        ]);

        try {

            $gid = $request->gid;
            $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
            $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';

            $returnableGetPassData = DB::table('inv_gatepass_vw')
                                        ->select('store_no_fk','rcv_department','rcv_designation','rcv_email','rcv_name','rcv_contact','rcv_photo_name','rcv_remarks','rcv_date','rcv_by','rcv_ind','emp_name','emp_department','emp_designation','emp_email','emp_contact','emp_photo_name','department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
                                        // ->where('store_no_fk', Session::get('user.su_pk_no'))
                                        ->where('returnable_ind', 1)
                                        // ->where('gatepass_save_option', 'POST')
                                        ->where('print_ind', '1')
                                        ->orderBy('gatepass_no_pk', 'desc')
                                        ->distinct('gatepass_no_pk');

            if (!empty($gid)) {
                $returnableGetPassData->where('gatepass_uid', $gid);
            }
            if (!empty($request->department)) {
                $returnableGetPassData->where('store_no_fk', $request->department);
            }

            if(!empty($request->status)) {
                 $returnableGetPassData->where('rcv_ind',$request->status);
            }

            if (!empty($from_date) &&  !empty($to_date)) {
                $returnableGetPassData->whereBetween('gatepass_date', [$from_date, $to_date]);
            }

            $data =   $returnableGetPassData->get();
        return response()->json(['success' => true,'data' => $data],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => true,'data' => []],200);
        }
    }

    public function SearchGatePassWorkListReturnableEdit($id){
        $returnableGetPassData = DB::table('inv_gatepass_vw')
                                    ->select('rcv_department','rcv_designation','rcv_email','rcv_name','rcv_contact','rcv_photo_name','rcv_remarks','rcv_date','rcv_by','rcv_ind','emp_name','emp_department','emp_designation','emp_email','emp_contact','emp_photo_name','department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
                                    ->where('store_no_fk', Session::get('user.su_pk_no'))
                                    ->where('returnable_ind', 1)
                                    // ->where('gatepass_save_option', 'POST')
                                    ->where('print_ind', '1')
                                    ->where('gatepass_no_pk', $id)
                                    ->where('rcv_ind', 0)
                                    ->first();

          if(empty($returnableGetPassData)){
              dd('You have no access!');
          }

        return Template::loadView("admin.uhl.inventory.modal.gate_pass_edit", ['data' => $returnableGetPassData]);
    }

    public function SearchGatePassWorkListReturnableReceive(Request $request){
       $request->validate([
            'gatepass_no_pk' => 'required',
            'receive_date' => 'required'
        ]);
        try {
            $receive_date = date("Y-m-d",strtotime($request->receive_date));
            $entry_session = Session()->get('user.ses_user_pk_no');
            DB::table('inv_gatepassmst')
                            ->where('gatepass_no_pk',$request->gatepass_no_pk)
                            ->update([
                                'rcv_remarks' => $request->notes,
                                'rcv_by' => Auth::id(),
                                'rcv_ind' => $request->status,
                                'rcv_date' => $receive_date,

                            ]);

             return response()->json(['success' => true,'msg' => 'Successfully Received','title' => 'Success'],200);
        } catch(\Exception $e) {

            return response()->json(['success' => false,'msg' => $e->getMessage(),'title' => 'Error'],422);

        }
    }

    public function returnReceiveGatePassPdf(Request $request){
            $gid = $request->gid;
            $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
            $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';
            $cur_date = date('Y-m-d H:i:s');
            $returnableGetPassData = DB::table('inv_gatepass_vw')
                ->select('rcv_remarks','rcv_date','rcv_by','rcv_ind','emp_name','emp_department','emp_designation','emp_email','emp_contact','emp_photo_name','department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
                ->where('returnable_ind', 1)
                // ->where('gatepass_save_option', 'POST')
                ->where('print_ind', '1')
                ->orderBy('rcv_ind','asc')
                ->orderBy('return_date','desc')
                ->selectRaw("TO_DATE('$cur_date', 'YYYY-MM-DD HH24:MI:SS') - TO_DATE(return_date, 'YYYY-MM-DD HH24:MI:SS') AS day_difference")
                ->distinct('gatepass_no_pk');

            if ($gid != "") {
                $returnableGetPassData->where('gatepass_uid', $gid);
            }

            if($request->status != "") {
                 $returnableGetPassData->where('rcv_ind',$request->status);
            }
            if (!empty($request->department)) {
                $returnableGetPassData->where('store_no_fk', $request->department);
            }
            if ($from_date != "" &&  $to_date != "") {
                $returnableGetPassData->whereBetween('gatepass_date', [$from_date, $to_date]);
            }

            else if ($from_date != "") {
                $returnableGetPassData->whereDate('gatepass_date', $from_date);
            }

            $data =   $returnableGetPassData->get();


            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $status = $request->status;

            $pdf = PDF::loadView("admin.uhl.inventory.export.return_receive_gate_pass", compact('data', 'from_date', 'to_date','status'));
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(750, 520, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $pdf->setPaper('a4', 'landscape')->download('return_receive_gate_pass.pdf');

    }

    // public function SearchGatePassWorkListPost(Request $request){
    //     $serial_no=$request->serial_no;
    //     $from_date=$request->from_date !="" ? date('Y-m-d',strtotime($request->from_date)) :'';
    //     $to_date=$request->to_date !="" ? date('Y-m-d',strtotime($request->to_date)) :'';

    //     $getapassMstPosts=DB::table('inv_gatepassmst')->select('inv_gatepassmst.*','inv_supplier.supplier_name',DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepassmst.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))->leftjoin('inv_supplier','inv_supplier.supplier_no_pk','=','inv_gatepassmst.vendor_supplier_no_fk');
    //     if ( $serial_no !="") {
    //         $getapassMstPosts->where('sl_no', $serial_no);
    //     }
    //     if ($from_date !="" &&  $to_date!="") {
    //         $getapassMstPosts->whereBetween('gatepass_date', [$from_date, $to_date]);
    //     }else if($from_date !=""){
    //         $getapassMstPosts->whereDate('gatepass_date', $from_date);
    //     }
    //     $getapassMstPost=   $getapassMstPosts->where('store_no_fk',Session::get('user.su_pk_no'))->where('gatepass_save_option','POST')->orderBy('gatepass_no_pk','desc')->get();

    //     return Template::loadView("admin.uhl.inventory.gatepass_worklist_post",['getapassMstPost'=>$getapassMstPost]);
    // }

    public function gatePassWorkListPrint($id)
    {

        PDF::setOptions(['isHtml5ParserEnabled', 'true']);
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();


        $userInfo = Auth::user();

        $inv_gatepassdtl = DB::table('inv_gatepassdtl')
            ->where('gatepass_no_pk', $id)
            ->orderBy('gatepassdtl_no_pk', 'desc')
            ->get();

        $inv_gatepassmst = DB::table('inv_gatepassmst')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_gatepassmst.vendor_supplier_no_fk')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_gatepassmst.store_no_fk')
            ->select('inv_gatepassmst.*', 'inv_supplier.supplier_name', 'sysc_serviceunit.serviceunit_name')
            ->where('gatepass_no_pk', $id)
            ->orderBy('gatepass_no_pk', 'asc')
            ->first();
        // dd($inv_gatepassmst);
        $pdf = App::make('dompdf.wrapper');

        $barcode = new BarcodeGenerator();
        $barcode->setText($id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'ent_desig.designation as ent_designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.user_fullname_ent', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->leftJoin('wsec_user ent', 'ent.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk_ent')
            ->leftJoin('employee_info_vw ent_desig', 'ent_desig.person_no_pk', 'ent.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'GATEPASS')
            ->get();
        // dd($signature_data );
        // return view("admin.uhl.inventory.gatepass_print", [
        //     'po_hospital_details' => $po_hospital_details,
        //     'userInfo' => $userInfo,
        //     'inv_gatepassdtl' => $inv_gatepassdtl,
        //     'inv_gatepassmst' => $inv_gatepassmst,
        //     'invoice_barcode' => $invoice_barcode,
        //     'signature_data' => $signature_data,
        // ]);


    //    return view("admin.uhl.inventory.gatepass_print", [
    //         'po_hospital_details' => $po_hospital_details,
    //         'userInfo' => $userInfo,
    //         'inv_gatepassdtl' => $inv_gatepassdtl,
    //         'inv_gatepassmst' => $inv_gatepassmst,
    //         'invoice_barcode' => $invoice_barcode,
    //         'signature_data' => $signature_data,
    //     ]);
        $pdf = PDF::loadView("admin.uhl.inventory.gatepass_print", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'inv_gatepassdtl' => $inv_gatepassdtl,
            'inv_gatepassmst' => $inv_gatepassmst,
            'invoice_barcode' => $invoice_barcode,
            'signature_data' => $signature_data,
        ]);
        $dom_pdf = $pdf->getDomPDF();
        $dom_pdf->setPaper('a5', 'portrait');
        // $pdf->setOptions(['isPhpEnabled' => true]);
        // $canvas = $dom_pdf->get_canvas();
        // $canvas->page_text(300, 300, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream("gatePass_print.pdf", array("Attachment" => false));
    }


    public function allGatePasses(Request $request)
    {
        $getapassMstDraft = DB::table('inv_gatepass_vw')
            ->select('department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'print_ind', 'approval_status_text', DB::raw('(select count(item_no_fk) from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
            ->where('approval_level_status_text', '2/2')
            // ->where('gatepass_date', '>=', DB::raw('sysdate - 7'))
            ->whereRaw('trunc(gatepass_date) = trunc(sysdate)')
            ->orderBy('gatepass_no_pk', 'desc')
            ->distinct('gatepass_no_pk')
            ->get();

        $deptName  = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();

        return Template::loadView("admin.uhl.inventory.all-gate-passes-worklist", ['getapassMstDraft' => $getapassMstDraft, 'deptName' => $deptName]);
    }


    public function SearchAllGatePasses(Request $request)
    {
        $dept = $request->department;
        $from_date = $request->from_date != "" ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date != "" ? date('Y-m-d', strtotime($request->to_date . '+1 day')) : '';
        $issue_status = $request->issue_status;

        $getapassMstDrafts = DB::table('inv_gatepass_vw')
            ->select('approval_status_text', 'department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'print_ind', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
            // ->where('approval_level_status_text', '2/2')
            // ->orWhere('approval_level_status_text', '1/2')
            ->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
            ->whereRaw("approval_status_text NOT LIKE '%HOLD%'")
            ->whereRaw("approval_status_text NOT LIKE '%PENDING%'")
            ->orderBy('gatepass_no_pk', 'desc')
            ->distinct('gatepass_no_pk');

        // $getapassMstDrafts = DB::table('inv_gatepass_vw')
        //     ->select('approval_status_text', 'department', 'gatepass_uid', 'sl_no', 'gatepass_date', 'issued_to_name', 'issue_date', 'return_date', 'gatepass_purpose_short', 'vendor_supplier_name', 'returnable_ind', 'onetime_use_ind', 'gatepass_save_option', 'approval_level_status_text', 'gatepass_no_pk', 'print_ind', 'approval_status_text', DB::raw('(select count(item_no_fk)  from inv_gatepassdtl where inv_gatepass_vw.gatepass_no_pk = inv_gatepassdtl.gatepass_no_pk) as item_count'))
        //     ->where(function($query) {
        //         $query->where('approval_level_status_text', '2/2')
        //             ->orWhere('approval_level_status_text', '1/2');
        //     })
        //     ->whereRaw("approval_status_text NOT LIKE '%REJECTED%'")
        //     ->orderBy('gatepass_no_pk', 'desc')
        //     ->distinct('gatepass_no_pk');


        if ($dept != "") {
            $getapassMstDrafts->where('store_no_fk', $dept);
        }

        if ($issue_status != "" && $issue_status == 'issued') {
            $getapassMstDrafts->where('print_ind', 1);
        } elseif ($issue_status != "" && $issue_status == 'not_issued') {
            $getapassMstDrafts->whereRaw("NVL(print_ind, 0)= 0");
        }

        if ($from_date != "" &&  $to_date != "") {
            $getapassMstDrafts->whereBetween('gatepass_date', [$from_date, $to_date]);
        } else if ($from_date != "") {
            $getapassMstDrafts->whereDate('gatepass_date', $from_date);
        }
        $getapassMstDraft =   $getapassMstDrafts->get();
        // dd($getapassMstDraft);

        return Template::loadView("admin.uhl.inventory.all_gatepasses_worklist_for_print", ['getapassMstDraft' => $getapassMstDraft]);
    }


    public function updateGatepassPrintInd(Request $request)
    {
        $gatepass_no_pk = $request->gatepass_no_pk;
        $IsPrinted = $request->IsPrintedCheckbox;
        $person_no_fk = null;
        if($IsPrinted == 1){
            $person_no_fk = Session::get('user.ses_person_no_fk');
        }
        DB::table('inv_gatepassmst')->where('gatepass_no_pk', $gatepass_no_pk)->update(array('print_ind' => $IsPrinted,'person_no_fk' => $person_no_fk));
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
}
