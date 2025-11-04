<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Session;
use PDO;
use PDF;
use App\Traits\MailEngine;
use App;
use Illuminate\Contracts\Session\Session as SessionSession;

class HOSDepartmentIndentController extends Controller
{
    use MailEngine;
    //
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));
        $sub_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk','serviceunit_name')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('status', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
      

        $su_no = [];
        if (!empty($sub_store_list)) {
            foreach ($sub_store_list as  $value) {
                $su_no[] = $value->serviceunit_no_pk;
            }
        }
        // $main_su_no=!empty( $su_no) ? implode(",",$su_no) :'';


        $requisition_list_drafts = DB::table('inv_requisitionlist_vw')
            ->whereIn('from_store_no_fk', $su_no)
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'DRAFT')
            ->whereNull('cancel_ind');

        if (Session::get('user.inv_hod_ind') == null) {
            $requisition_list_drafts->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
        }
        $requisition_list_draft = $requisition_list_drafts->orderBy('inv_requisition_no_pk', 'desc')->get()->toArray();

        $two_days_ago_post = date("Y-m-d", strtotime("-10 day"));

        $requisition_list_posts = DB::table('inv_requisitionlist_vw')
            ->select(DB::raw('distinct INV_REQUISITION_NO_PK, INV_REQUISITION_UID, INV_REQUISITION_DATE, REQ_AT, TO_STORE_NO_FK, TO_STORE, FROM_STORE_NO_FK, FROM_STOR, REQ_TYPE, REQ_TYPE_BY, REF_INDENT_NO_FK, INDENT_REMARKS,
            AU_ENTRY_BY, USER_NAME, AU_ENTRY_SESSION, AU_ENTRY_HOSPITAL_PK_NO, INDENT_SAVE_OPTION, APPROVAL_STATUS_TEXT, APPROVAL_LEVEL_STATUS_TEXT'))
            ->where('inv_requisition_date', '>', $two_days_ago_post)
            ->where('indent_save_option', '=', "POST")
            ->whereIn('from_store_no_fk', $su_no)
            ->whereNull('cancel_ind');
        if (Session::get('user.inv_hod_ind') == null) {
            $requisition_list_posts->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
        }

        $requisition_list_post = $requisition_list_posts->whereNull('recv_ind')->whereNull('issue_ind')->orderBy('inv_requisition_no_pk', 'desc')
            ->get()->toArray();

        //    dd(  $requisition_list_post);
        return  Template::loadView("admin.uhl.inventory.department-indent-worklist", [
            'requisition_list' => array_merge($requisition_list_draft, $requisition_list_post),
            'sub_store_list'=>$sub_store_list
        ]);
    }

    public function create()
    {
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('main_store_ind', '!=', 1)
            // ->where('pharmacy_ind', '!=',1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        // dd( $all_stores_list);
        // DB::table('sysc_serviceunit')
        //     ->select('*')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->where('main_store_ind', '=', 1)
        //     ->Where('sub_store_ind', '!=', 1)
        //     ->orderBy('main_store_ind', 'asc')
        //     ->get();

        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->get();

        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('minor_group_ind', 1)->where('inventory_head_ind', 1)->orderBy('item_name', 'asc')->get();
        // dd($item_type);
        return Template::loadView("admin.uhl.inventory.department-indent", [
            'hospital_list' => $hospital_list,
            'stores' => $stores,
            'main_stores_list' => $main_stores_list,
            'all_stores_list' => $all_stores_list,
            'item_type' => $item_type,
        ]);
    }
    public function create_indent_v2()
    {
      
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('main_store_ind', '!=', 1)
            ->where('hospital_store_ind', '!=', 1)
            ->where('pharmacy_ind', '1')
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('hospital_store_ind', '=', 1)
            // ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)           
            ->get();

        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('minor_group_ind', 1)->where('inventory_head_ind', 1)->orderBy('item_name', 'asc')->get();
        // dd($item_type);
        return Template::loadView("admin.uhl.inventory.department-indent-v2", [
            'hospital_list' => $hospital_list,
            'stores' => $stores,
            'main_stores_list' => $main_stores_list,
            'all_stores_list' => $all_stores_list,
            'item_type' => $item_type,
        ]);
    }

    public function minorGroupList(Request $request){
        // $item_type_arr = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('asset_su_no_fk', $request->store_id)->where('minor_group_ind', 1)->where('inventory_head_ind', 1)->orderBy('item_name', 'asc')->get();

        $item_type=[];
        if ($request->asset_ind == 1) {
            $item_type= DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('asset_su_no_fk', $request->store_id)->where('minor_group_ind', 1)->where('inventory_head_ind', 1)->orderBy('item_name', 'asc')->get();
            // dd( $item_type);
        }else{
            $item_type= DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->whereNull('asset_su_no_fk')->where('minor_group_ind', 1)->where('inventory_head_ind', 1)->orderBy('item_name', 'asc')->get();
        }
        // dd( $item_type);
        return response()->json($item_type);
    }

    public function store(Request $request)
    {
        try {
            $approval_id = $request->approval_id;

            $in_indent_no = isset($request->indent_no) ? $request->indent_no : 0;
            $in_edit_ind = isset($request->indent_no) ? 1 : 0;
            $in_indent_date = !empty($request->indent_Date) ? date('Y-m-d', strtotime($request->indent_Date)) : date('Y-m-d');

            $department_from =  $request->department_from;
            $department_to =  $request->department_to;
            $requested_by_type =  $request->requested_by_type;

            $hdn_patient_id =  isset($request->hdn_patient_id) ? $request->hdn_patient_id : 0;
            $hdn_doctor_id =  isset($request->hdn_doctor_id) ? $request->hdn_doctor_id : 0;
            $hdn_event_id =  isset($request->hdn_event_id) ? $request->hdn_event_id : 0;
            $indent_remarks =  $request->indent_remarks;
            $ref_req_no =  isset($request->ref_req_no) ? $request->ref_req_no : 0;
            $null = null;
            $item_no_fk_arr = [];
            $pvmsno_arr = [];
            $item_uoms_arr = [];
            $item_quantities_arr = [];
            $in_a_entry_serial_dtl = [];
            $in_a_urgent_ind = [];
            $in_a_exact_ind = [];
            $in_a_item_remarks = [];
            $in_expect_date = [];
            $in_au_entry_by = Auth::user()->user_no_pk;
            $in_au_entry_session = 'UHL Department Indent';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $out_inv_requisition_no_pk = 0;
            $out_purchase_uid = '';
            $out_error = '';
            $in_req_saveoption = $request->in_req_saveoption;
            $zero = 0;
            $numelems = 6500;

            $pdo = DB::getPdo();

            $purchase_order_entry = $pdo->prepare(
                "begin pkg_v1_inventory_all.prc_itemrequisition(
                    :in_indent_no,
                    :in_indent_date ,
                    :in_store_from_su_no_fk ,
                    :in_store_to_su_no_fk ,
                    :in_patient_no_fk ,
                    :in_admission_no_fk ,
                    :in_req_by_person_no_fk ,
                    :in_req_by_event_no_fk ,
                    :in_indent_remarks ,
                    :in_ref_indent_no_fk ,
                    :in_return_reason ,
                    :in_req_type     ,
                    :in_req_saveoption ,
                    :in_source_su_no_fk,
                    :in_edit_ind,
                    :in_a_item_no_fk ,
                    :in_a_item_pvmsno ,
                    :in_a_item_qty ,
                    :in_a_item_uom ,
                    :in_a_urgent_ind ,
                    :in_a_exact_ind ,
                    :in_a_item_remarks ,
                    :in_a_entry_serial_dtl,
                    :in_expect_date,
                    :in_au_entry_by ,
                    :in_au_entry_session ,
                    :in_au_entry_hospital_no_fk ,
                    :out_inv_requisition_no_pk  ,
                    :out_requisition_uid  ,
                    :out_error
            ); end;"
            );

            if (!empty($request->item_id_hidden)) {
                for ($i = 0; $i < count($request->item_id_hidden); $i++) {
                    $item_no_fk_arr[$i] = $request->item_id_hidden[$i];
                    $pvmsno_arr[$i] = 0;
                    $in_a_entry_serial_dtl[$i] = $i + 1;
                    $item_quantities_arr[$i] = isset($request->item_quantity[$i]) ? $request->item_quantity[$i] : 0;
                    $item_uoms_arr[$i] = isset($request->uom_no_fk[$i]) ? $request->uom_no_fk[$i] : 0;
                    $in_a_item_remarks[$i] = isset($request->remarks[$i]) ? $request->remarks[$i] : 0;
                    $in_a_urgent_ind[$i] = isset($request->urgent_ind[$i]) ? ($request->urgent_ind[$i] == 'Y' ? 1 : 0) : 0;
                    $in_a_exact_ind[$i] = isset($request->exact_ind[$i]) ? ($request->exact_ind[$i] == 'Y' ? 1 : 0) : 0;
                    $in_expect_date[$i] = isset($request->expected_date[$i]) ? date('d-m-Y', strtotime($request->expected_date[$i])) : "";
                }
            }

            $purchase_order_entry->bindparam('in_indent_no', $in_indent_no);
            $purchase_order_entry->bindparam('in_indent_date', $in_indent_date);
            $purchase_order_entry->bindparam('in_store_from_su_no_fk', $department_from);
            $purchase_order_entry->bindparam('in_store_to_su_no_fk', $department_to);
            $purchase_order_entry->bindparam('in_patient_no_fk', $hdn_patient_id);
            $purchase_order_entry->bindparam('in_admission_no_fk', $zero);
            $purchase_order_entry->bindparam('in_req_by_person_no_fk', $hdn_doctor_id);
            $purchase_order_entry->bindparam('in_req_by_event_no_fk', $hdn_event_id);
            $purchase_order_entry->bindparam('in_indent_remarks', $indent_remarks);
            $purchase_order_entry->bindparam('in_ref_indent_no_fk', $ref_req_no);
            $purchase_order_entry->bindparam('in_return_reason', $null);
            $purchase_order_entry->bindparam('in_req_type', $requested_by_type);
            $purchase_order_entry->bindparam('in_req_saveoption', $in_req_saveoption);
            $purchase_order_entry->bindparam('in_source_su_no_fk', $zero);
            $purchase_order_entry->bindparam('in_edit_ind', $in_edit_ind);
            $purchase_order_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_item_pvmsno', $pvmsno_arr, count($pvmsno_arr), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_item_qty', $item_quantities_arr, count($item_quantities_arr), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_item_uom', $item_uoms_arr, count($item_uoms_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_urgent_ind', $in_a_urgent_ind, count($in_a_urgent_ind), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_exact_ind', $in_a_exact_ind, count($in_a_exact_ind), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_item_remarks', $in_a_item_remarks, count($in_a_item_remarks), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_entry_serial_dtl', $in_a_entry_serial_dtl, count($in_a_entry_serial_dtl), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_expect_date', $in_expect_date, count($in_expect_date), $numelems, SQLT_CHR);
            $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
            $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $purchase_order_entry->bindParam('out_inv_requisition_no_pk', $out_inv_requisition_no_pk, PDO::PARAM_INT);
            $purchase_order_entry->bindParam('out_requisition_uid', $out_purchase_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            // dd(  $purchase_order_entry);
            $purchase_order_entry->execute();

            DB::commit();

            if ($out_error == "000") {
                if ($request->remove_item_id != "") {
                    $req_no_exp = explode(',', $request->remove_item_id);
                    foreach ($req_no_exp as $key => $value) {
                        DB::table('inv_requisitiondtl')->where('inv_requisitiondtl_no_pk', $value)->delete();
                    }
                }
                if ($approval_id != "") {
                    $approval_level = Session::get('user.approvalmatrix_level_num') == "" ? 1 : '';

                    $null = '';
                    $au_entry_at = date('Y-m-d');
                    DB::beginTransaction();
                    $sequence = DB::getSequence();
                    //    dd( $approval_id,  $approval_level);
                    DB::table('sysc_approvalprocess')
                        ->where('apprprocess_no_pk', $approval_id)
                        ->where('own_level', $approval_level)
                        ->update(
                            [
                                'approved_ind' => 1,
                                'approved_at' => $au_entry_at,
                                'approved_by' => Auth::id(),
                                'approved_remarks' => $null,
                                'hold_ind' => 0,
                                'hold_at' => "",
                                'hold_by' => "",
                                'hold_reason' => "",
                                'reject_ind' => 0,
                                'reject_at' => "",
                                'reject_by' => "",
                                'reject_reason' => "",
                            ]
                        );
                }
                if (Session::get('user.email_send_ind') == 1) {

                    $approvalMst = DB::table('sysc_approvalmatrixmst')->select('dept_base_approval_ind')->where('approval_for_code', 'INDENT')->first();

                    if (!empty($approvalMst) && $approvalMst->dept_base_approval_ind == 1) {
                        $approval_matrix = DB::table('sysc_approvalmatrix_dept_vw')->select('sysc_approvalmatrix_dept_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'INDENT')->where('dept_su_no_fk', Session::get('user.su_pk_no'))->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_dept_vw.person_no_fk')->get();
                    } else {
                        $approval_matrix = DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'INDENT')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_vw.person_no_fk')->get();
                    }


                    if (!empty($approval_matrix)) {
                        $app_arr = [];
                        foreach ($approval_matrix as $key => $value) {
                            $app_arr[$key] = $value->email_personal;
                        }

                        $this->inventoryMail($app_arr, $out_inv_requisition_no_pk, $value->approval_for_code, Auth::user()->user_fullname);
                    }
                }


                DB::commit();
                $message = ['msg' => 'Data saved successfully. <br><strong>Indent UID = ' . $out_purchase_uid . '</strong>', 'title' => 'Success'];
            } else {
                DB::rollBack();
                $message = ['msg' => 'Save Failed. <br><strong>Error  = ' . $out_error . '</strong>', 'title' => 'Success'];
            }
        } catch (Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function searchDepartmentIndent(Request $request)
    {
       
        $main_store_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->distinct()
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('status', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $su_no = [];
        if (!empty($main_store_list)) {
            foreach ($main_store_list as  $value) {
                $su_no[] = $value->serviceunit_no_pk;
            }
        }
        // dd($main_store_list,Auth::user()->user_no_pk);
        $query = DB::table('inv_requisitionlist_vw');
        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }
        if (isset($request->from_store)) {
            $query->where('from_store_no_fk', $request->from_store);
        }
        if (isset($request->save_option)) {
            $query->where('indent_save_option', $request->save_option);
        }
        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }


        $requisition_list = $query
            // ->where('from_store_no_fk', Session::get("user.su_pk_no"))
            ->whereIn('from_store_no_fk', $su_no)
            // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('cancel_ind')
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        // dd(Session::get("user.su_pk_no"),$request->requsion_no ,$request->indent_date_from, $requisition_list );
        return  Template::loadView("admin.uhl.inventory.department-indent-table-worklist", [
            'requisition_list' => $requisition_list
        ]);
    }

    
    public function searchUniformIssueList(Request $request)
    {
    //    dd($request->all());
        
        $query = DB::table('HRMS_EMPUNIFORMDTL as req')
            ->join('sysc_serviceitem as ITEM', 'req.ITEM_NO_FK', '=', 'ITEM.ITEM_NO_PK')
            ->join('wsec_user as US', 'req.REQ_BY', '=', 'US.USER_NO_PK')
            ->join('HRMS_PERSONNEL as PER', 'US.PERSON_NO_FK', '=', 'PER.PERSON_NO_PK')
            ->join('SYSC_SERVICEUNIT as SUN', 'PER.SERVICEUNIT_NO_FK', '=', 'SUN.SERVICEUNIT_NO_PK')
            ->select(
                'req.EMPUNIFORMDTL_NO_PK',
                'req.ITEM_NO_FK',
                'ITEM.ITEM_NAME',
                'PER.FULL_NAME',
                'SUN.SERVICEUNIT_NO_PK',
                'SUN.SERVICEUNIT_NAME',
                'req.REQ_QTY',
                'req.REQ_AT',
                'req.ISSUE_QTY',
                'REQ.ISSUE_AT',
                'REQ.YEAR_YYYY',
                'req.REQ_BY',
                'req.REQ_BY_REMARKS',
                'PER.PERSON_NO_PK',
                'req.ITEM_SIZE'
            );

            if (isset($request->req_by_search)) {
                $query->where('PER.PERSON_NO_PK', '=', $request->req_by_search);
            }
            if (isset($request->req_type) && $request->req_type == 'NREQ') {
                $query->whereRaw('COALESCE(req.REQ_QTY, 0) > COALESCE(req.ISSUE_QTY, 0)');
            }
            if (isset($request->req_type) && $request->req_type == 'PISSUED') {
                $query->whereRaw('COALESCE(req.REQ_QTY, 0) != COALESCE(req.ISSUE_QTY, 0)')
                ->whereRaw('COALESCE(req.ISSUE_QTY, 0) != 0');
            }
            if (isset($request->req_type) && $request->req_type == 'ISSUED') {
                $query->whereRaw('COALESCE(req.REQ_QTY, 0) <= COALESCE(req.ISSUE_QTY, 0)');
            }

            if (isset($request->req_date_searchfrom) && isset($request->req_date_searchto)) {
               
                $fromDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->req_date_searchfrom)->startOfDay();
                $toDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->req_date_searchto)->endOfDay();
                $query->whereBetween('req.REQ_AT', [$fromDate, $toDate]);
            }

        $requisition_list = $query->get();

        // dd($requisition_list->all());
        
        return  Template::loadView("admin.uniform.uniform-request-table-worklist", [
            'requisition_list' => $requisition_list
        ]);


    }

    public function departmentIndentPrint($req_id)
    {

        ini_set("max_execution_time",0);
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_requisitionlist_vw')
                            ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
                            ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                            ->where('inv_requisition_no_pk', $req_id)
                            ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
                                ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
                                ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisitiondtl.item_no_fk')
                                ->leftJoin('sysc_generic', 'sysc_generic.generic_no_pk', 'sysc_serviceitem.generic_no_fk')
                                ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code", "sysc_serviceitem.item_code", "sysc_serviceitem.purchase_price","sysc_generic.generic_name")
                                ->where('inv_requisition_no_fk', $req_id)
                                ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'asc')
                                ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $signature_data = DB::table('sysc_approvalprocess_vw')
                            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image','sysc_approvalprocess_vw.approved_at')
                            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                            ->where('sysc_approvalprocess_vw.primary_key_value', $req_id)
                            ->where('sysc_approvalprocess_vw.approval_for_code', 'INDENT')
                            ->get();

        if (Session::get('user.ses_hospital_code') != 'EWMCH') {
            $pdf = PDF::loadView("admin.uhl.inventory.requisition_issue_form_pdf", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'my_requsition' => $my_requsition,
                'my_requsition_items' => $my_requsition_items,
                'invoice_barcode' => $invoice_barcode,
                'signature_data' => $signature_data,
            ]);
        } else {
            $pdf = PDF::loadView("admin.uhl.inventory.requisition_issue_form_new_pdf", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'my_requsition' => $my_requsition,
                'my_requsition_items' => $my_requsition_items,
                'invoice_barcode' => $invoice_barcode,
            ]);
        }

        return $pdf->stream("requisition_form_pdf.pdf", array("Attachment" => false));
    }
    public function departmentReceivedPrint($req_id)
    {

        ini_set("max_execution_time",0);
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_requisitionlist_vw')
                            ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
                            ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                            ->where('inv_requisition_no_pk', $req_id)
                            ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
                                ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
                                ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisitiondtl.item_no_fk')
                                ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code", "sysc_serviceitem.item_code", "sysc_serviceitem.purchase_price")
                                ->where('inv_requisition_no_fk', $req_id)
                                ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'asc')
                                ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $signature_data = DB::table('sysc_approvalprocess_vw')
                            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image','sysc_approvalprocess_vw.approved_at')
                            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                            ->where('sysc_approvalprocess_vw.primary_key_value', $req_id)
                            ->where('sysc_approvalprocess_vw.approval_for_code', 'INDENT')
                            ->get();

      
            $pdf = PDF::loadView("admin.uhl.inventory.requisition_issue_received_pdf", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'my_requsition' => $my_requsition,
                'my_requsition_items' => $my_requsition_items,
                'invoice_barcode' => $invoice_barcode,
                'signature_data' => $signature_data,
            ]);
       

        return $pdf->stream("requisition_form_pdf.pdf", array("Attachment" => false));
    }

    public function departmentIssueIndentPrint($req_id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")
                                ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
                                ->first();

        $my_requsition = DB::table('inv_requisitionlist_vw')
                        ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
                        ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                        ->where('inv_requisition_no_pk', $req_id)
                        ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
                        ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
                        ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisitiondtl.item_no_fk')
                        ->leftJoin('sysc_generic', 'sysc_generic.generic_no_pk', 'sysc_serviceitem.generic_no_fk')
                        ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code", "sysc_serviceitem.item_code", "sysc_serviceitem.purchase_price","sysc_generic.generic_name")
                        ->where('inv_requisition_no_fk', $req_id)
                        ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');



        $pdf = PDF::loadView("admin.uhl.inventory.requisition_issue_form_pdf", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition' => $my_requsition,
            'my_requsition_items' => $my_requsition_items,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }


    public function departmentPartialIssuedPrint($req_id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_requisitionlist_vw')
            ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
            ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('inv_requisition_no_pk', $req_id)
            ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisitiondtl.item_no_fk')
            ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code", "sysc_serviceitem.item_code", "sysc_serviceitem.purchase_price")
            ->where('inv_requisition_no_fk', $req_id)
            ->get();

        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');



        $pdf = PDF::loadView("admin.uhl.inventory.partial_reqisi_issued_frm", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition' => $my_requsition,
            'my_requsition_items' => $my_requsition_items,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function departmentIssuedPrint($req_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_requisitionlist_vw')
            ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
            ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('inv_requisition_no_pk', $req_id)
            ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisitiondtl.item_no_fk')
            ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code", "sysc_serviceitem.purchase_price")
            ->where('inv_requisition_no_fk', $req_id)
            ->get();
        // dd(  $my_requsition_items);
        $barcode = new BarcodeGenerator();
        $barcode->setText($req_id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();


        $userInfo = Auth::user();

        $pdf = App::make('dompdf.wrapper');

        $signature_data = DB::table('sysc_approvalprocess_vw')
                            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image','sysc_approvalprocess_vw.approved_at')
                            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
                            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
                            ->where('sysc_approvalprocess_vw.primary_key_value', $req_id)
                            ->where('sysc_approvalprocess_vw.approval_for_code', 'INDENT')
                            ->get();



        $pdf = PDF::loadView("admin.uhl.inventory.requi_issued_frm", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition' => $my_requsition,
            'my_requsition_items' => $my_requsition_items,
            'invoice_barcode' => $invoice_barcode,
            'signature_data' => $signature_data,
        ]);
        return $pdf->stream("purchase_order_print.pdf", array("Attachment" => false));
    }

    public function edit($indent_no)
    {


        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('main_store_ind', '!=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->get();
        //

        $requisition_info = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_no_pk', $indent_no)
            ->first();

        $requisition_itens = DB::table('inv_requisitiondtl')
                            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
                            ->where('inv_requisition_no_fk', $indent_no)
                            ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'asc')
                            ->get();


        return Template::loadView("admin.uhl.inventory.department-indent", [
            'hospital_list' => $hospital_list,
            'stores' => $stores,
            'main_stores_list' => $main_stores_list,
            'requisition_info' => $requisition_info,
            'requisition_itens' => $requisition_itens,
            'all_stores_list' => $all_stores_list,
        ]);
    }
    public function editFromApproval($indent_no)
    {
      
        $indent_no_app = explode('.', $indent_no);
       
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        
        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('main_store_ind', '!=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
          
        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
           
        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        //
       
        $requisition_info = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_no_pk', $indent_no_app[0])
            ->first();

        $requisition_itens = DB::table('inv_requisitiondtl')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->where('inv_requisition_no_fk', $indent_no_app[0])
            ->get();

       
        return Template::loadView("admin.uhl.inventory.department-indent", [
            'hospital_list' => $hospital_list,
            'stores' => $stores,
            'main_stores_list' => $main_stores_list,
            'requisition_info' => $requisition_info,
            'requisition_itens' => $requisition_itens,
            'all_stores_list' => $all_stores_list,
            'approval_id' => $indent_no_app[1],
        ]);
    }


    public function departmentIndentListView($req_id)
    {

        $my_requsition = DB::table('inv_requisitionlist_vw')
            ->leftJoin('wsec_user', 'inv_requisitionlist_vw.au_entry_by', 'wsec_user.user_no_pk')
            ->leftJoin('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('inv_requisition_no_pk', $req_id)
            ->first();

        $my_requsition_items = DB::table('inv_requisitiondtl')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->select("inv_requisitiondtl.*", "sysc_serviceitem_uom.uom_code")
            ->where('inv_requisition_no_fk', $req_id)
            ->get();

        return Template::loadView("admin.uhl.inventory.requisition_issue_list_view", [
            'my_requsition' => $my_requsition,
            'my_requsition_items' => $my_requsition_items,
        ]);
    }
}
