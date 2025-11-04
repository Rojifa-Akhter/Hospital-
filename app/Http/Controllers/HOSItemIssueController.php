<?php

namespace App\Http\Controllers;

use App;
use PDF;
use PDO;
use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use App\Traits\MailEngine;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HOSItemIssueController extends Controller
{
    use MailEngine, LookupData;
    //
    use UtilitiesTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // dd("ookkk");
        $thirty_days_ago = date("Y-m-d", strtotime("-30 day"));

        $issu_requisition_lists = DB::table('inv_requisitionlist_vw')
            ->distinct()
            ->whereDate('inv_requisition_date', '>=', $thirty_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', null);

        if (Session::get('user.ses_hospital_code') == "DMHL") {
            $grant_service = DB::table('sysc_grant_servieceunit_vw')->where('user_no_pk', Auth::id())->pluck('serviceunit_no_pk');
            $issu_requisition_lists->whereIn('to_store_no_fk', $grant_service);
        }
        // $issu_requisition_list = $issu_requisition_lists->orderBy('inv_requisition_no_pk', 'desc')
        //     ->get();
        $issu_requisition_list = $issu_requisition_lists
        ->orderByRaw('APPROVED_AT DESC NULLS LAST')
        ->get();



        // dd($issu_requisition_list);
        $issued_requisition_list = DB::table('inv_requisitionlist_vw')
            ->distinct()
            ->whereDate('inv_requisition_date', '>=', $thirty_days_ago)
            ->where('indent_save_option', '=', 'POST')
            //->where('issue_ind','=',1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();

        $sub_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_name', 'serviceunit_code', 'serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->get();
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_name', 'serviceunit_code', 'serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->get();


        return Template::loadView("admin.uhl.inventory.item-issues-worklist", [
            'requisition_list' => $issu_requisition_list,
            'issued_requisition_list' => $issued_requisition_list,
            'sub_store_list'  => $sub_store_list,
            'main_store_list'  => $main_store_list,
        ]);
    }
    public function prWorkList()
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_po_itm_vw.app_date', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'), DB::raw('count(inv_requisition_po_itm_vw.assign_ind) as assign_count'));

        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_po_itm_vw.app_date')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime("-30 days" . date('Y-m-d'))), date('Y-m-d', strtotime(date('Y-m-d')))])
            ->get();
        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'app_date'                   => $value->app_date,
                    'item_count'                 => $value->item_count,
                    'assign_count'                 => $value->assign_count,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header')
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadView("admin.uhl.inventory.pr-worklist", [
            'requisition_list' => $issu_requisition_list,
            'main_store_list' => $main_store_list

        ]);
    }
    public function prWorkListPhr()
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'), DB::raw('count(inv_requisition_po_itm_vw.assign_ind) as assign_count'));

        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime("-30 days" . date('Y-m-d'))), date('Y-m-d', strtotime(date('Y-m-d')))])
            ->where('sysc_serviceunit.pharmacy_ind', 1)
            ->get();
        // dd(  $issu_requisition_list_data);
        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'item_count'                 => $value->item_count,
                    'assign_count'                 => $value->assign_count,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header')
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('pharmacy_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadView("admin.uhl.inventory.pr-worklist", [
            'requisition_list' => $issu_requisition_list,
            'main_store_list' => $main_store_list

        ]);
    }
    public function prAssignWorkList()
    {
        $keyword = "APPROVED";
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $issu_requisition_list = [];
        return Template::loadView("admin.uhl.inventory.pr-assign-worklist", [
            'requisition_list' => $issu_requisition_list,

        ]);
    }
    public function prAssignDepartmentWorkList()
    {
        $keyword = "APPROVED";
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }
        $main_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('main_store_ind', 'serviceunit_no_pk', 'serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $issu_requisition_list = [];
        return Template::loadView("admin.uhl.inventory.pr-assign-department-worklist", [
            'requisition_list' => $issu_requisition_list,
            'main_stores_list' => $main_stores_list,

        ]);
    }

    public function search_pr_list(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_po_itm_vw.app_date', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'), DB::raw('count(inv_requisition_po_itm_vw.assign_ind) as assign_count'));
        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if ($request->status == "APPROVED") {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.app_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime("+1 days" . $request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        } else {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        }

        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_po_itm_vw.app_date')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();


        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'app_date'                    => $value->app_date,
                    'item_count'                 => $value->item_count,
                    'assign_count'                 => $value->assign_count,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        return Template::loadView("admin.uhl.inventory.pr-worklist-table", [
            'requisition_list' => $issu_requisition_list,

        ]);
    }
    public function search_assign_pr_list(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }
        $emp_id = $request->emp_id;
        $assign_status = $request->assign_status;

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'assign_by', 'assign_by_name', 'assign_ind', 'assign_at', 'item_name', 'req_quantity', 'item_pur_uom_name', 'inv_requisitiondtl_po_no_pk', 'inv_requisition_po_itm_vw.item_no_fk');



        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($emp_id) && !empty($emp_id)) {
            $query->where('inv_requisition_po_itm_vw.assign_by', $emp_id);
        }

        if (isset($assign_status) && !empty($assign_status)) {

            if ($assign_status == "ASSIGNED") {
                $query->where('inv_requisition_po_itm_vw.assign_ind', 1);
            } else {
                $query->where('inv_requisition_po_itm_vw.assign_ind', null);
            }
        }
        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issu_requisition_list_data = $query
            ->where('assign_by', Session::get('user.ses_person_no_fk'))
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();
        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'item_no_fk'   => $value->item_no_fk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'assign_by'                  => $value->assign_by,
                    'assign_by_name'             => $value->assign_by_name,
                    'assign_ind'                 => $value->assign_ind,
                    'assign_at'                  => $value->assign_at,
                    'item_name'                  => $value->item_name,
                    'req_quantity'                => $value->req_quantity,
                    'item_pur_uom_name'           => $value->item_pur_uom_name,
                    'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        return Template::loadView("admin.uhl.inventory.pr-assign-worklist-table", [
            'requisition_list' => $issu_requisition_list,

        ]);
    }
    public function search_assign_department_pr_list(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }
        $emp_id = $request->emp_id;
        $assign_status = $request->assign_status;

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'assign_by', 'assign_by_name', 'assign_ind', 'assign_at', 'item_name', 'req_quantity', 'item_pur_uom_name', 'inv_requisitiondtl_po_no_pk', 'inv_requisition_po_itm_vw.item_no_fk');



        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($emp_id) && !empty($emp_id)) {
            $query->where('inv_requisition_po_itm_vw.assign_by', $emp_id);
        }

        if (isset($assign_status) && !empty($assign_status)) {

            if ($assign_status == "ASSIGNED") {
                $query->where('inv_requisition_po_itm_vw.assign_ind', 1);
            } else {
                $query->where('inv_requisition_po_itm_vw.assign_ind', null);
            }
        }
        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }
        if (isset($request->department_to)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->department_to);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issu_requisition_list_data = $query
            // ->where('assign_by',Session::get('user.ses_person_no_fk'))
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();
        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'item_no_fk'   => $value->item_no_fk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'assign_by'                  => $value->assign_by,
                    'assign_by_name'             => $value->assign_by_name,
                    'assign_ind'                 => $value->assign_ind,
                    'assign_at'                  => $value->assign_at,
                    'item_name'                  => $value->item_name,
                    'req_quantity'                => $value->req_quantity,
                    'item_pur_uom_name'           => $value->item_pur_uom_name,
                    'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        return Template::loadView("admin.uhl.inventory.pr-assign-department-worklist-table", [
            'requisition_list' => $issu_requisition_list,

        ]);
    }
    public function assign_pr_list_pdf(Request $request)
    {

        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }
        $emp_id = $request->emp_id;
        $assign_status = $request->assign_status;

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'assign_by', 'assign_by_name', 'assign_ind', 'assign_at', 'item_name', 'req_quantity', 'item_pur_uom_name', 'inv_requisitiondtl_po_no_pk');

        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($emp_id) && !empty($emp_id)) {
            $query->where('inv_requisition_po_itm_vw.assign_by', $emp_id);
        }

        if (isset($assign_status) && !empty($assign_status)) {

            if ($assign_status == "ASSIGNED") {
                $query->where('inv_requisition_po_itm_vw.assign_ind', 1);
            } else {
                $query->where('inv_requisition_po_itm_vw.assign_ind', null);
            }
        }
        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $issu_requisition_list_data = $query
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();
        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'assign_by'                  => $value->assign_by,
                    'assign_by_name'             => $value->assign_by_name,
                    'assign_ind'                 => $value->assign_ind,
                    'assign_at'                  => $value->assign_at,
                    'item_name'                  => $value->item_name,
                    'req_quantity'                => $value->req_quantity,
                    'item_pur_uom_name'           => $value->item_pur_uom_name,
                    'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        return view("admin.uhl.inventory.pr-assign-worklist-pdf", [
            'requisition_list' => $issu_requisition_list,

        ]);
    }

    public function assign_assign(Request $request)
    {
        try {
            DB::table('inv_prassignment')->where('inv_requisition_no_fk', $request->pr_dtl_no)->where('item_no_fk', $request->item_no)->delete();
            DB::commit();
            $message = ['message' => 'Clear Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['message' => ' Clear Failed'];
        }
        return response()->json($message);
    }

    public function search_pr_list2(Request $request)
    {
        $query = DB::table('inv_requisitionmst_po')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisitionmst_po.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisitionmst_po.req_po_by')
            ->select('inv_requisitionmst_po.*', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisitionmst_po.inv_requisition_po_no_pk) as item_count'));
        if (isset($request->requsion_no)) {
            $query->where('inv_requisitionmst_po.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisitionmst_po.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisitionmst_po.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisitionmst_po.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }


        $requisition_list = $query->orderBy('inv_requisition_po_no_pk', 'desc')->get();
        // dd($requisition_list);


        $hospital_id = Session::get('user.ses_hospital_no_pk');
        foreach ($requisition_list as $value) {
            $pk = $value->inv_requisition_po_no_pk;

            $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

            $requisition_list_data[] = array(
                'inv_requisition_po_no_pk' => $value->inv_requisition_po_no_pk,
                'inv_requisition_po_uid'   => $value->inv_requisition_po_uid,
                'inv_requisition_po_date'  => $value->inv_requisition_po_date,
                'main_store_su_no_fk'      => $value->main_store_su_no_fk,
                'req_po_at'                => $value->req_po_at,
                'req_po_by'                => $value->req_po_by,
                'req_po_ind'               => $value->req_po_ind,
                'req_po_remarks'           => $value->req_po_remarks,
                'req_po_save_option'       => $value->req_po_save_option,
                'po_at'                    => $value->po_at,
                'po_by'                    => $value->po_by,
                'po_ind'                   => $value->po_ind,
                'single_po_ind'            => $value->single_po_ind,
                'req_po_type'              => $value->req_po_type,
                'ref_requisition_po_no_fk' => $value->ref_requisition_po_no_fk,
                'purchaseorder_no_fk'      => $value->purchaseorder_no_fk,
                'status'                   => $value->status,
                'au_entry_by'              => $value->au_entry_by,
                'au_entry_at'              => $value->au_entry_at,
                'au_entry_session'         => $value->au_entry_session,
                'au_entry_hospital_pk_no'  => $value->au_entry_hospital_pk_no,
                'au_update_by'             => $value->au_update_by,
                'au_update_at'             => $value->au_update_at,
                'au_update_session'        => $value->au_update_session,
                'au_update_hospital_pk_no' => $value->au_update_hospital_pk_no,
                'au_sync_hospital_pk_no'   => $value->au_sync_hospital_pk_no,
                'au_sync_at'               => $value->au_sync_at,
                'pr_doc_attachment_path'   => $value->pr_doc_attachment_path,
                'serviceunit_name'         => $value->serviceunit_name,
                'user_fullname'            => $value->user_fullname,
                'item_count'               => $value->item_count,
                'multiple_remarks'         => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                // 'multiple_remarks'         => $multiple_remarks
            );
        }

        return Template::loadView("admin.uhl.inventory.search-pr-worklist", [
            // 'requisition_list' => $requisition_list,
            'requisition_list' => $requisition_list_data,
            //'issued_requisition_list' => $issued_requisition_list
        ]);
    }
    public function prPrint($id = "")
    {
        ini_set("max_execution_time", 0);
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        //   inv_requisitionmst_po
        $req_mst =
            DB::table('inv_requisition_po_itm_vw')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname', 'sysc_serviceunit.pharmacy_ind')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            // ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname')
            ->where('inv_requisition_po_no_pk', $id)
            ->first();
        $pr_mst = DB::table('inv_requisitionmst_po')
            ->select('inv_supplier.supplier_name', 'inv_requisitionmst_po.main_store_su_no_fk')
            ->leftJoin('inv_supplier', 'inv_supplier.supplier_no_pk', '=', 'inv_requisitionmst_po.supplier_no_fk')
            ->where('inv_requisition_po_no_pk', $id)
            ->first();

        // inv_requisitiondtl_po
        $my_requsition_items = DB::table('inv_requisition_po_itm_vw')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.from_store', 'inv_requisition_po_itm_vw.item_purchase_price', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.req_uom_name', 'inv_requisitiondtl.inv_requisition_no_fk', 'sysc_serviceitem_inv_vw.lpp')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftJoin('inv_requisition_po_itm_vw', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk')
            ->leftJoin('inv_requisitiondtl', 'inv_requisitiondtl.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisitiondtl.au_entry_by')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            ->where('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', $id)
            ->orderBy('inv_requisitiondtl_po_no_pk', 'asc')
            ->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        foreach ($my_requsition_items as $value) {
            $pk = $value->inv_requisition_po_no_pk;

            $requisition_date = date('Y-m-d', strtotime($value->inv_requisition_po_date));
            $requisition_date_before_90 = Carbon::createFromFormat("Y-m-d", $requisition_date)->subDays(90)->format('Y-m-d');

            $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

            $avg_qty = DB::select("SELECT ABS(SUM(stock_trans_qty)) AS consumption
                            FROM inv_itemstocktranschd
                            WHERE stock_trans_qty < 0
                            AND TRUNC(au_entry_at) BETWEEN TO_DATE('$requisition_date_before_90', 'YYYY-MM-DD') AND TO_DATE('$requisition_date', 'YYYY-MM-DD')
                            AND item_no_fk = $value->item_no_fk AND stock_su_no_fk = $pr_mst->main_store_su_no_fk");
            // dd( $requisition_date_before_90, $avg_qty);
            $global_stock_qty = DB::table('inv_itemstockmst')->select(DB::raw('sum(balance_qty) as global_stock_qty'))->where('item_no_fk', $value->item_no_fk)->first();

            // pr_uom_conversion_qty
            $my_requsition_items_list[] = array(
                'inv_requisition_po_no_pk'    => $value->inv_requisition_po_no_pk,
                'inv_requisition_po_date'     => $value->inv_requisition_po_date,
                'inv_requisitiondtl_no_pk'    => $value->inv_requisitiondtl_no_pk,
                'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                'item_no_fk'                  => $value->item_no_fk,
                'item_name'                   => $value->item_name,
                'item_code'                   => $value->item_code,
                'generic_name'                   => $value->generic_name,
                'supplier_pk_no'              => $value->supplier_pk_no,
                'supp_name'                   => $value->supp_name,
                'pvmsno'                      => $value->pvmsno,
                'req_uom'                     => $value->req_uom,
                'req_uom_name'                => $value->req_uom_name,
                'uom_no_fk'                   => $value->uom_no_fk,
                'sales_uom'                   => $value->sales_uom,
                'pr_uom_no_fk'                => $value->pr_uom_no_fk,
                'item_pur_uom_name'           => $value->item_pur_uom_name,
                'pr_uom_conversion_qty'       => $value->pr_uom_conversion_qty ?? 0,
                'item_purchase_price'         => $value->item_purchase_price ?? 0,
                'main_store_su_no_fk'         => $value->main_store_su_no_fk,
                'from_store'                  => $value->from_store,
                'req_at'                      => $value->req_at,
                'req_by'                      => $value->req_by,
                'req_po_remarks'              => $value->req_po_remarks,
                'req_by_name'                 => $value->req_by_name,
                'req_ind'                     => $value->req_ind,
                'req_quantity'                => $value->req_quantity ?? 0,
                'req_po_save_option'          => $value->req_po_save_option,
                'po_quantity'                 => $value->po_quantity ?? 0,
                'po_at'                       => $value->po_at,
                'po_by'                       => $value->po_by,
                'po_ind'                      => $value->po_ind,
                'single_po_ind'               => $value->single_po_ind,
                'req_po_type'                 => $value->req_po_type,
                'requisitiondtl_no_pk_list'   => $value->requisitiondtl_no_pk_list,
                'urgent_ind'                  => $value->urgent_ind,
                'expect_date'                 => $value->expect_date,
                'entry_serial_dtl'            => $value->entry_serial_dtl,
                'item_remarks'                => $value->item_remarks,
                'generic_stock'               => $value->generic_stock,
                'con_from_stock'              => $value->con_from_stock,
                'con_curr_stock'              => $value->con_curr_stock,
                'stock_f_store'               => $value->stock_f_store,
                'current_stock'               => $value->current_stock,
                'global_stock_qty'            => !empty($global_stock_qty) ? $global_stock_qty->global_stock_qty : 0,
                'approval_status_text'        => $value->approval_status_text,
                'approval_level_status_text'  => $value->approval_level_status_text,
                'app_status'                  => $value->app_status,
                'pr_doc_attachment_path'      => $value->pr_doc_attachment_path,
                'dollar_rate'                 => $value->dollar_rate ?? 0,
                'currency_sign'               => $value->currency_sign,
                'user_fullname'               => $value->user_fullname,
                'vat_percent'                 => $value->vat_percent ?? 0,
                'inv_requisition_no_fk'       => $value->inv_requisition_no_fk,
                'lpp'                         => $value->lpp ?? 0,
                'multiple_remarks'            => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : '',
                'three_month_avg_qty'         => $avg_qty ?  $avg_qty[0]->consumption : 0
            );
        }
        //    dd($my_requsition_items_list);
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

        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'PR')
            ->orderBy('own_level', 'asc')
            ->get();


        if (Session::get('user.ses_hospital_code') != 'EWMCH') {

            if ($req_mst->pharmacy_ind == 1) {

                $pdf = PDF::loadView("admin.uhl.inventory.pr_print_v2", [
                    'po_hospital_details' => $po_hospital_details,
                    'userInfo' => $userInfo,
                    'my_requsition_items' => $my_requsition_items_list,
                    'req_mst' => $req_mst,
                    'invoice_barcode' => $invoice_barcode,
                    'signature_data' => $signature_data,
                    'pr_mst' => $pr_mst,
                ]);
            } else {
                $pdf = PDF::loadView("admin.uhl.inventory.pr_print", [
                    'po_hospital_details' => $po_hospital_details,
                    'userInfo' => $userInfo,
                    'my_requsition_items' => $my_requsition_items_list,
                    'req_mst' => $req_mst,
                    'invoice_barcode' => $invoice_barcode,
                    'signature_data' => $signature_data,
                ]);
            }
            // if (Session::get('user.ses_hospital_code') == 'DMHL') {
            //     $pdf = PDF::loadView("admin.uhl.inventory.pr_print_v2", [
            //         'po_hospital_details' => $po_hospital_details,
            //         'userInfo' => $userInfo,
            //         'my_requsition_items' => $my_requsition_items_list,
            //         'req_mst' => $req_mst,
            //         'invoice_barcode' => $invoice_barcode,
            //         'signature_data' => $signature_data,
            //     ]);
            // }else{
            //     $pdf = PDF::loadView("admin.uhl.inventory.pr_print", [
            //         'po_hospital_details' => $po_hospital_details,
            //         'userInfo' => $userInfo,
            //         'my_requsition_items' => $my_requsition_items_list,
            //         'req_mst' => $req_mst,
            //         'invoice_barcode' => $invoice_barcode,
            //         'signature_data' => $signature_data,
            //     ]);
            // }

        } else {
            $pdf = PDF::loadView("admin.uhl.inventory.pr_print_new", [
                'po_hospital_details' => $po_hospital_details,
                'userInfo' => $userInfo,
                'my_requsition_items' => $my_requsition_items_list,
                'req_mst' => $req_mst,
                'invoice_barcode' => $invoice_barcode,
            ]);
        }
        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));
        // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream("pr_print.pdf", array("Attachment" => false));
    }

    public function prPrintImperial($id = "")
    {
        ini_set("max_execution_time", 0);
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $req_mst = DB::table('inv_requisition_po_itm_vw')
            //   ->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname')
            ->where('inv_requisition_po_no_pk', $id)
            ->first();

        $my_requsition_items = DB::table('inv_requisition_po_itm_vw')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.from_store', 'inv_requisition_po_itm_vw.item_purchase_price', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.req_uom_name', 'inv_requisitiondtl.inv_requisition_no_fk', 'sysc_serviceitem_inv_vw.lpp')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftJoin('inv_requisition_po_itm_vw', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk')
            ->leftJoin('inv_requisitiondtl', 'inv_requisitiondtl.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisitiondtl.au_entry_by')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            ->where('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', $id)
            ->orderBy('INV_REQUISITIONDTL_PO_NO_PK', 'asc')
            ->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        foreach ($my_requsition_items as $value) {
            $pk = $value->inv_requisition_po_no_pk;

            $requisition_date = date('Y-m-d', strtotime($value->inv_requisition_po_date));
            $requisition_date_before_30 = Carbon::createFromFormat("Y-m-d", $requisition_date)->subDays(30)->format('Y-m-d');

            $data = DB::select("select ITEM_QTY, AU_ENTRY_AT last_po_date, TRADE_PRICE
                                from PHR_ITEMRECEIVEDTL
                                where item_no_fk= $id
                                and TRUNC(AU_ENTRY_AT) < TO_DATE('$requisition_date', 'YYYY-MM-DD')
                                and AU_ENTRY_AT = (select max(AU_ENTRY_AT) from PHR_ITEMRECEIVEDTL
                                where item_no_fk = $id
                                and TRUNC(AU_ENTRY_AT) < TO_DATE('$requisition_date', 'YYYY-MM-DD'))
                            ");

            $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

            $avg_qty = DB::select("SELECT ABS(SUM(stock_trans_qty)) AS consumption
                            FROM inv_itemstocktranschd
                            WHERE stock_trans_qty < 0
                            AND TRUNC(au_entry_at) BETWEEN TO_DATE('$requisition_date_before_30', 'YYYY-MM-DD') AND TO_DATE('$requisition_date', 'YYYY-MM-DD')
                            AND item_no_fk = $value->item_no_fk");

            $my_requsition_items_list[] = array(
                'inv_requisition_po_no_pk'    => $value->inv_requisition_po_no_pk,
                'inv_requisition_po_date'     => $value->inv_requisition_po_date,
                'inv_requisitiondtl_no_pk'    => $value->inv_requisitiondtl_no_pk,
                'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                'item_no_fk'                  => $value->item_no_fk,
                'item_name'                   => $value->item_name,
                'item_code'                   => $value->item_code,
                'supplier_pk_no'              => $value->supplier_pk_no,
                'supp_name'                   => $value->supp_name,
                'pvmsno'                      => $value->pvmsno,
                'req_uom'                     => $value->req_uom,
                'req_uom_name'                => $value->req_uom_name,
                'uom_no_fk'                   => $value->uom_no_fk,
                'sales_uom'                   => $value->sales_uom,
                'pr_uom_no_fk'                => $value->pr_uom_no_fk,
                'item_pur_uom_name'           => $value->item_pur_uom_name,
                'pr_uom_conversion_qty'       => $value->pr_uom_conversion_qty,
                'item_purchase_price'         => $value->item_purchase_price,
                'main_store_su_no_fk'         => $value->main_store_su_no_fk,
                'from_store'                  => $value->from_store,
                'req_at'                      => $value->req_at,
                'req_by'                      => $value->req_by,
                'req_po_remarks'              => $value->req_po_remarks,
                'req_by_name'                 => $value->req_by_name,
                'req_ind'                     => $value->req_ind,
                'req_quantity'                => $value->req_quantity,
                'req_po_save_option'          => $value->req_po_save_option,
                'po_quantity'                 => $value->po_quantity,
                'po_at'                       => $value->po_at,
                'po_by'                       => $value->po_by,
                'po_ind'                      => $value->po_ind,
                'single_po_ind'               => $value->single_po_ind,
                'req_po_type'                 => $value->req_po_type,
                'requisitiondtl_no_pk_list'   => $value->requisitiondtl_no_pk_list,
                'urgent_ind'                  => $value->urgent_ind,
                'expect_date'                 => $value->expect_date,
                'entry_serial_dtl'            => $value->entry_serial_dtl,
                'item_remarks'                => $value->item_remarks,
                'generic_stock'               => $value->generic_stock,
                'con_from_stock'              => $value->con_from_stock,
                'con_curr_stock'              => $value->con_curr_stock,
                'stock_f_store'               => $value->stock_f_store,
                'current_stock'               => $value->current_stock ? $value->current_stock : 0,
                'approval_status_text'        => $value->approval_status_text,
                'approval_level_status_text'  => $value->approval_level_status_text,
                'app_status'                  => $value->app_status,
                'pr_doc_attachment_path'      => $value->pr_doc_attachment_path,
                'dollar_rate'                 => $value->dollar_rate,
                'currency_sign'               => $value->currency_sign,
                'user_fullname'               => $value->user_fullname,
                'vat_percent'                 => $value->vat_percent,
                'inv_requisition_no_fk'       => $value->inv_requisition_no_fk,
                'lpp'                         => $value->lpp,
                'multiple_remarks'            => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : '',
                'one_month_avg_qty'           => $avg_qty ?  $avg_qty[0]->consumption : '',
                'item_qty'                    => $data['item_qty'] ?? 0,
                'item_qty'                    => $data['item_qty'] ?? 0,
                'trade_price'                 => $data['trade_price'] ?? 0,
                'last_po_date'                => $data['last_po_date'] ?? '',
                'one_month_avg_qty'           => $data['one_month_avg_qty'] ?? 0,
            );
        }

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

        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'PR')
            ->orderBy('own_level', 'asc')
            ->get();

        $pdf = PDF::loadView("admin.uhl.inventory.pr_print_new_imperial", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition_items' => $my_requsition_items_list,
            'req_mst' => $req_mst,
            'invoice_barcode' => $invoice_barcode,
        ]);

        $dom_pdf = $pdf->getDomPDF();
        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(482, 818, "Powered By: NEXTGEN IT", null, 7, array(0, 0, 0));
        $canvas->page_text(32, 818, "Staff ID: $userInfo->user_code. Printing Date & Time: " . date('d/m/Y, h:ia'), null, 7, array(0, 0, 0));
        // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream("pr_print_imperial.pdf", array("Attachment" => false));
    }

    public function prExcel($id = "")
    {
        // PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        //   inv_requisitionmst_po
        $req_mst = DB::table('inv_requisition_po_itm_vw')
            //   ->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname')
            ->where('inv_requisition_po_no_pk', $id)
            ->first();
        // dd($req_mst);
        //   inv_requisitiondtl_po
        $my_requsition_items = DB::table('inv_requisition_po_itm_vw')
            ->select('inv_requisition_po_itm_vw.*', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.from_store', 'inv_requisition_po_itm_vw.item_purchase_price', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.req_uom_name', 'inv_requisitiondtl.inv_requisition_no_fk', 'sysc_serviceitem_inv_vw.lpp')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftJoin('inv_requisition_po_itm_vw', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk')
            ->leftJoin('inv_requisitiondtl', 'inv_requisitiondtl.inv_requisitiondtl_no_pk', '=', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisitiondtl.au_entry_by')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            ->where('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', $id)
            ->orderBy('INV_REQUISITIONDTL_PO_NO_PK', 'asc')
            ->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        foreach ($my_requsition_items as $value) {
            $pk = $value->inv_requisition_po_no_pk;

            $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));
            $avg_qty = DB::table('inv_itemstocktranschd')
                ->selectRaw('ABS(SUM(stock_trans_qty)) AS consumption')
                ->whereRaw('TRUNC(au_entry_at) BETWEEN TO_DATE(SYSDATE-90) AND TO_DATE(SYSDATE)')
                ->where('stock_trans_qty', '<', 0)
                ->where('item_no_fk', $value->item_no_fk)
                ->first();
            $my_requsition_items_list[] = array(
                'inv_requisition_po_no_pk'    => $value->inv_requisition_po_no_pk,
                'inv_requisition_po_date'     => $value->inv_requisition_po_date,
                'inv_requisitiondtl_no_pk'    => $value->inv_requisitiondtl_no_pk,
                'inv_requisitiondtl_po_no_pk' => $value->inv_requisitiondtl_po_no_pk,
                'item_no_fk'                  => $value->item_no_fk,
                'item_name'                   => $value->item_name,
                'item_code'                   => $value->item_code,
                'supplier_pk_no'              => $value->supplier_pk_no,
                'supp_name'                   => $value->supp_name,
                'pvmsno'                      => $value->pvmsno,
                'req_uom'                     => $value->req_uom,
                'req_uom_name'                => $value->req_uom_name,
                'uom_no_fk'                   => $value->uom_no_fk,
                'sales_uom'                   => $value->sales_uom,
                'pr_uom_no_fk'                => $value->pr_uom_no_fk,
                'item_pur_uom_name'           => $value->item_pur_uom_name,
                'pr_uom_conversion_qty'       => $value->pr_uom_conversion_qty,
                'item_purchase_price'         => $value->item_purchase_price,
                'main_store_su_no_fk'         => $value->main_store_su_no_fk,
                'from_store'                  => $value->from_store,
                'req_at'                      => $value->req_at,
                'req_by'                      => $value->req_by,
                'req_po_remarks'              => $value->req_po_remarks,
                'req_by_name'                 => $value->req_by_name,
                'req_ind'                     => $value->req_ind,
                'req_quantity'                => $value->req_quantity,
                'req_po_save_option'          => $value->req_po_save_option,
                'po_quantity'                 => $value->po_quantity,
                'po_at'                       => $value->po_at,
                'po_by'                       => $value->po_by,
                'po_ind'                      => $value->po_ind,
                'single_po_ind'               => $value->single_po_ind,
                'req_po_type'                 => $value->req_po_type,
                'requisitiondtl_no_pk_list'   => $value->requisitiondtl_no_pk_list,
                'urgent_ind'                  => $value->urgent_ind,
                'expect_date'                 => $value->expect_date,
                'entry_serial_dtl'            => $value->entry_serial_dtl,
                'item_remarks'                => $value->item_remarks,
                'generic_stock'               => $value->generic_stock,
                'con_from_stock'              => $value->con_from_stock,
                'con_curr_stock'              => $value->con_curr_stock,
                'stock_f_store'               => $value->stock_f_store,
                'current_stock'               => $value->current_stock,
                'approval_status_text'        => $value->approval_status_text,
                'approval_level_status_text'  => $value->approval_level_status_text,
                'app_status'                  => $value->app_status,
                'pr_doc_attachment_path'      => $value->pr_doc_attachment_path,
                'dollar_rate'                 => $value->dollar_rate,
                'currency_sign'               => $value->currency_sign,
                'user_fullname'               => $value->user_fullname,
                'vat_percent'                 => $value->vat_percent,
                'inv_requisition_no_fk'       => $value->inv_requisition_no_fk,
                'lpp'                         => $value->lpp,
                'multiple_remarks'            => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : '',
                'three_month_avg_qty'         => $avg_qty ?  $avg_qty->consumption : ''

            );
        }
        // dd($my_requsition_items_list);
        $barcode = new BarcodeGenerator();
        $barcode->setText($id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $userInfo = Auth::user();

        // $pdf = App::make('dompdf.wrapper');

        $signature_data = DB::table('sysc_approvalprocess_vw')
            ->select('sysc_approvalprocess_vw.user_fullname', 'sysc_approvalprocess_vw.level_status_text', 'employee_info_vw.designation', 'employee_info_vw.doctor_signature_image', 'sysc_approvalprocess_vw.approved_at')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 'sysc_approvalprocess_vw.user_no_pk')
            ->leftJoin('employee_info_vw', 'employee_info_vw.person_no_pk', 'wsec_user.person_no_fk')
            ->where('sysc_approvalprocess_vw.primary_key_value', $id)
            ->where('sysc_approvalprocess_vw.approval_for_code', 'PR')
            ->get();


        $pdf = [
            "type" => "pdf",
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition_items' => $my_requsition_items_list,
            'req_mst' => $req_mst,
            'invoice_barcode' => $invoice_barcode,
            'signature_data' => $signature_data,
        ];
        // dd( $pdf);
        $fileToExport = "PR";
        $html = View("admin.uhl.inventory.pr_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
        // $dom_pdf = $pdf->getDomPDF();
        // $canvas = $dom_pdf->get_canvas();
        // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // return $pdf->stream("pr_print.pdf", array("Attachment" => false));
    }

    public function prViewPopup($id)
    {

        $items = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            // ->leftjoin('phr_itemreceivemst_pr_cnt', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'phr_itemreceivemst_pr_cnt.inv_requisition_po_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
            // ->where('supplier_pk_no',  $request->supplier_id)
            ->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null)
            ->where('inv_requisition_po_no_pk', $id)
            // ->where('issue_ind', 1)
            // ->where('recv_ind','=', null)
            ->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk', 'asc')
            ->get();


        return Template::loadView("admin.uhl.inventory.pr-view-popup", ["items" => $items]);
    }
    public function prCurrencyChange($id)
    {
        $currency = $this->getLookupListByCode("CURRENCYSIGN");
        $pr_data = DB::table('inv_requisitiondtl_po')->select('currency_sign', 'dollar_rate')->where('inv_requisitiondtl_no_pk', $id)->first();
        // dd($pr_data,$id);
        return Template::loadView("admin.uhl.inventory.pr_currency_change", ["currency" => $currency, 'id' => $id, 'pr_data' => $pr_data]);
    }
    public function updatePrCurrency(Request $request)
    {
        try {
            $item_list = DB::table('inv_requisitiondtl_po')->select('item_no_fk')->where('inv_requisitiondtl_no_pk', $request->pr_no)->get();

            if (!empty($item_list)) {
                foreach ($item_list as $key => $value) {
                    $item = [
                        'dollar_ind' => $request->currency_sign == "USD" ? 1 : 2,
                    ];
                    // dd( $value , $item);
                    DB::table('sysc_serviceitem')->where('item_no_pk', $value->item_no_fk)->update($item);
                }
            }
            $data = [
                'currency_sign' => $request->currency_sign,
                'dollar_rate' => $request->dollar_rate
            ];
            DB::table('inv_requisitiondtl_po')->where('inv_requisitiondtl_no_pk', $request->pr_no)->update($data);
            DB::commit();
            $message = ['msg' => 'Successfully.', 'title' => 'Success'];
        } catch (\Throwable $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function consumptionWorkList()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }
        $issu_requisition_list = DB::table('inv_consumptionmst')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_consumptionmst.consumption_by')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_consumptionmst.from_store_no_fk')
            ->select('inv_consumptionmst.*', 'wsec_user.user_fullname', 'sysc_serviceunit.serviceunit_name', DB::raw('(select count(DISTINCT item_no_fk)  from inv_consumption_vw where inv_consumptionmst.inv_consumption_no_pk=inv_consumption_vw.inv_consumption_no_pk )  as item_count'))
            ->whereIn('from_store_no_fk', $all_su_no)
            ->orderBy('inv_consumption_no_pk', 'desc')
            ->get();

        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        return Template::loadView("admin.uhl.inventory.consumption_worklist", [
            'requisition_list' => $issu_requisition_list,
            'stores' => $stores,

        ]);
    }
    public function search_consumption_list(Request $request)
    {
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $from_date = '';
        $to_date = '';
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('d-m-Y'); // define expected format
        }
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);  // define date format from user
            $to_date = $dateTime->format('d-m-Y'); // define expected format
        }

        $query = DB::table('inv_consumptionmst')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_consumptionmst.consumption_by')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_consumptionmst.from_store_no_fk')
            ->select('inv_consumptionmst.*', 'wsec_user.user_fullname', 'sysc_serviceunit.serviceunit_name', DB::raw('(select count(inv_consumption_no_pk)  from inv_consumption_vw where inv_consumptionmst.inv_consumption_no_pk=inv_consumption_vw.inv_consumption_no_pk)  as item_count'))
            ->whereIn('from_store_no_fk', $all_su_no);

        if (isset($request->department)) {
            $query->where('from_store_no_fk', $request->department);
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_consumption_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        } elseif (!empty($from_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($to_date)));
        }


        $requisition_list = $query->orderBy('inv_consumption_no_pk', 'desc')->get();

        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        return Template::loadView("admin.uhl.inventory.search_consumption_worklist", [
            'requisition_list' => $requisition_list,
            'stores' => $stores,
        ]);
    }
    public function consumptionPrint($id = "")
    {
        PDF::setOptions(['isPhpEnabled', 'true']);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();



        $userInfo = Auth::user();

        $issu_requisition_list_mst = DB::table('inv_consumptionmst')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_consumptionmst.consumption_by')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_consumptionmst.from_store_no_fk')
            ->select('inv_consumptionmst.*', 'wsec_user.user_fullname', 'sysc_serviceunit.serviceunit_name', DB::raw('(select count(inv_consumption_no_pk)  from inv_consumption_vw where inv_consumptionmst.inv_consumption_no_pk=inv_consumption_vw.inv_consumption_no_pk)  as item_count'))
            ->where('inv_consumption_no_pk', $id)
            ->orderBy('inv_consumption_no_pk', 'desc')
            ->first();

        $issu_requisition_list = DB::table('inv_consumption_vw')
            ->where('inv_consumption_no_pk', $id)
            ->orderBy('inv_consumption_no_pk', 'desc')
            ->get();
        $pdf = App::make('dompdf.wrapper');

        $barcode = new BarcodeGenerator();
        $barcode->setText($id);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();



        
        $patient_info = DB::table('pat_registration_wl_vw')
        ->select('patient_name', 'patient_code')
        ->where('patient_no_pk', $issu_requisition_list_mst->patient_no_fk)
        ->first();
        


        $pdf = PDF::loadView("admin.uhl.inventory.consumption_print", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'patient_info' => $patient_info,
            'issu_requisition_list' => $issu_requisition_list,
            'issu_requisition_list_mst' => $issu_requisition_list_mst,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("pr_print.pdf", array("Attachment" => false));
    }
    public function consumptionWorkListItemWise()
    {


        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $item_name = DB::select("select distinct item_no_fk,item.item_name
            from INV_ITEMSTOCKTRANSCHD dtl,sysc_serviceitem item
            where  dtl.item_no_fk=item.item_no_pk");

        return Template::loadView("admin.uhl.inventory.consumption_worklist_item_wise", [
            'stores' => $stores,
            'item_name' => $item_name,

        ]);
    }
    public function search_consumption_list_item_wise(Request $request)
    {
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $from_date = '';
        $to_date = '';
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('d-m-Y'); // define expected format
        }
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);  // define date format from user
            $to_date = $dateTime->format('d-m-Y'); // define expected format
        }

        $query = DB::table('inv_consumption_vw')
            ->whereIn('from_store_no_fk', $all_su_no);

        if (isset($request->department)) {
            $query->where('from_store_no_fk', $request->department);
        }

        if (isset($request->item_name)) {
            $query->where('item_no_fk', $request->item_name);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_consumption_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        } elseif (!empty($from_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($to_date)));
        }

        $requisition_list = $query->orderBy('inv_consumption_no_pk', 'desc')->get();

        return Template::loadView("admin.uhl.inventory.search_consumption_worklist_item_wise", [
            'requisition_list' => $requisition_list,
        ]);
    }
    public function consumptionPrintItemWise(Request $request)
    {
        if ($request->indent_date_from == '' && $request->indent_date_to == '' && $request->department_from == '') {
            $requisition_list = [];
            return view("admin.uhl.inventory.search_consumption_worklist_item_wise_print", [
                'requisition_list' => $requisition_list,
            ]);
        }
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $from_date = '';
        $to_date = '';
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('d-m-Y'); // define expected format
        }
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);  // define date format from user
            $to_date = $dateTime->format('d-m-Y'); // define expected format
        }

        $query = DB::table('inv_consumption_vw')
            ->whereIn('from_store_no_fk', $all_su_no);

        if (isset($request->department_from)) {
            $query->where('from_store_no_fk', $request->department_from);
        }
        if (isset($request->item_name)) {
            $query->where('item_no_fk', $request->item_name);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_consumption_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        } elseif (!empty($from_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($from_date)));
        } elseif (!empty($to_date)) {
            $query->where('inv_consumption_date', date('Y-m-d', strtotime($to_date)));
        }

        $requisition_list = $query->orderBy('inv_consumption_no_pk', 'desc')->get();
        if ($request->print_type == "PDF") {
            return view("admin.uhl.inventory.search_consumption_worklist_item_wise_print", [
                'requisition_list' => $requisition_list,
            ]);
        } else {
            $excel = ['requisition_list' => $requisition_list];

            $fileToExport = "consumption report Excel";
            $html = View("admin.uhl.inventory.search_consumption_worklist_item_wise_print")->with($excel);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }
    }

    public function only_issue_work_list()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));
        $issu_requisition_list = DB::table('inv_requisitionlist_vw')
            ->distinct()
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', null)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();

        $issued_requisition_list = DB::table('inv_requisitionlist_vw')
            ->distinct()
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            //->where('issue_ind','=',1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return view("admin.uhl.inventory.only-item-issue-worklist", [
            'requisition_list' => $issu_requisition_list,
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function only_partial_issued_work_list(Request $request)
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $query = DB::table('inv_requisitionlist_vw');

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }

        if (isset($request->subtore)) {
            $query->where('from_store_no_fk', $request->subtore);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_to)));
        } else {
            $query->where('inv_requisition_date', '>', $two_days_ago);
        }

        if (Session::get('user.ses_hospital_code') == "DMHL") {
            $grant_service = DB::table('sysc_grant_servieceunit_vw')->where('user_no_pk', Auth::id())->pluck('serviceunit_no_pk');
            $query->whereIn('to_store_no_fk', $grant_service);
        }

        $issu_requisition_list =   $query
            // ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        // dd($issu_requisition_list);
        // $issued_requisition_list = DB::table('inv_requisitionlist_vw')
        //     ->where('inv_requisition_date', '>', $two_days_ago)
        //     ->where('indent_save_option', '=', 'POST')
        //     //->where('issue_ind','=',1)
        //     ->orderBy('inv_requisition_no_pk', 'desc')
        //     ->get();




        // dd($issu_requisition_list);
        return view("admin.uhl.inventory.only-partial-item-issued-worklist", [
            'requisition_list' => $issu_requisition_list,
            // 'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function search_issue_indent_list(Request $request)
    {
        // dd($request->subtore);
        $query = DB::table('inv_requisitionlist_vw');
        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }

        if (isset($request->subtore)) {
            $query->where('from_store_no_fk', $request->subtore);
        }
        if (isset($request->mainStore)) {
            $query->where('to_store_no_fk', $request->mainStore);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_date', date('Y-m-d', strtotime($request->indent_date_to)));
        }

        if (Session::get('user.ses_hospital_code') == "DMHL") {
            $grant_service = DB::table('sysc_grant_servieceunit_vw')->where('user_no_pk', Auth::id())->pluck('serviceunit_no_pk');
            $query->whereIn('to_store_no_fk', $grant_service);
            // dd($query->get());
        }

        $requisition_list = $query
            ->distinct()
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', null)
            // ->orderBy('inv_requisition_no_pk', 'desc')
            ->orderByRaw('APPROVED_AT DESC NULLS LAST')
            ->get();

        //  dd($requisition_list->all());

        return Template::loadView("admin.uhl.inventory.search-item-issues-worklist", [
            'requisition_list' => $requisition_list,
            //'issued_requisition_list' => $issued_requisition_list
        ]);
    }

    public function search_issued_indent_list(Request $request)
    {

        // $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
        //     ->select('serviceunit_no_pk')
        //     ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->where('sub_store_ind', '=', 1)
        //     // ->orWhere('main_store_ind', '=', 1)
        //     ->where('user_no_pk', '=', Auth::user()->user_no_pk)
        //     ->get();
        // $all_su_no = [];
        // if (!empty($grant_su)) {
        //     foreach ($grant_su as  $value) {
        //         $all_su_no[] = $value->serviceunit_no_pk;
        //     }
        // }

        // $query = DB::table('inv_requisitionlist_vw')->where('au_entry_by', '=', Auth::user()->user_no_pk);
        $query = DB::table('inv_requisitionlist_vw')
            // ->select(DB::raw('distinct INV_REQUISITION_NO_PK, INV_REQUISITION_UID, INV_REQUISITION_DATE, REQ_AT, TO_STORE_NO_FK, TO_STORE, FROM_STORE_NO_FK, FROM_STOR, REQ_TYPE, REQ_TYPE_BY, REF_INDENT_NO_FK, INDENT_REMARKS,
            //             AU_ENTRY_BY, USER_NAME, AU_ENTRY_SESSION, AU_ENTRY_HOSPITAL_PK_NO, INDENT_SAVE_OPTION, APPROVAL_STATUS_TEXT, APPROVAL_LEVEL_STATUS_TEXT'))
            // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }

        $from_date = "";
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $to_date = "";
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', $to_date);
        }


        // if (!empty($all_su_no)) {
        //     $query->whereIn('from_store_no_fk', $all_su_no);
        // }
        // whereNull('recv_ind')

        // dd($request->receive_received);
        if ($request->receive_received == "issue") {
            $requisition_list = $query->where('indent_save_option', '=', 'POST')
                ->where('issue_ind', 1)
                // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
                ->orderBy('inv_requisition_no_pk', 'desc')
                ->get();
            // dd( $requisition_list);
            return Template::loadView("admin.uhl.inventory.search-item-issued-worklist", [
                'issued_requisition_list' => $requisition_list
            ]);
        } else if ($request->receive_received == "issued") {

            $issued_requisition_lists = $query
                ->where('indent_save_option', '=', 'POST')
                ->where('issue_ind', '=', 1);
            //  ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
            //  ->where('recv_ind', '=', 1);
            $issued_requisition_list = $issued_requisition_lists
                ->orderBy('inv_requisition_no_pk', 'desc')
                ->get();
            return Template::loadView("admin.uhl.inventory.only-issued-partial-item-worklist", [
                'issued_requisition_list' => $issued_requisition_list
            ]);
        } else if ($request->receive_received == "receive") {

            $issued_requisition_lists = $query
                ->where('indent_save_option', '=', 'POST')
                ->where('recv_ind', '=', null)
                ->where('issue_ind', '=', 1)
                ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
            $issued_requisition_list = $issued_requisition_lists
                ->orderBy('inv_requisition_no_pk', 'desc')
                ->get();
            // dd($issued_requisition_list);
            return Template::loadView("admin.uhl.inventory.indent-received-worklist", [
                'issued_requisition_list' => $issued_requisition_list
            ]);
        } else if ($request->receive_received == "received") {

            $issued_requisition_lists = $query
                ->where('indent_save_option', '=', 'POST')
                ->where('issue_ind', '=', 1)
                ->where('recv_ind', '=', 1)
                ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
            $issued_requisition_list = $issued_requisition_lists
                ->orderBy('inv_requisition_no_pk', 'desc')
                ->get();
            // dd( $issued_requisition_list);
            return Template::loadView("admin.uhl.inventory.indent-received-worklist-all", [
                'issued_requisition_list' => $issued_requisition_list
            ]);
        }
    }
    public function search_issued_indent_list_all_dept(Request $request)
    {
        $query = DB::table('inv_requisitionlist_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }
        if (isset($request->from_store)) {
            $query->where('from_store_no_fk', $request->from_store);
        }

        $from_date = "";
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $to_date = "";
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', $to_date);
        }
        if ($request->receive_received == "receive") {

            $issued_requisition_lists = $query
                ->where('indent_save_option', '=', 'POST')
                ->where('recv_ind', '=', null)
                ->where('issue_ind', '=', 1);
            // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
            $issued_requisition_list = $issued_requisition_lists
                ->orderBy('inv_requisition_no_pk', 'desc')
                ->get();
            // dd($issued_requisition_list);
            return Template::loadView("admin.uhl.inventory.indent-received-worklist", [
                'issued_requisition_list' => $issued_requisition_list,
                'type' => $request->all_dept
            ]);
        }
    }
    public function print_issued_indent_list_all_dept(Request $request)
    {

        $query = DB::table('inv_requisitionlist_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_uid', $request->requsion_no);
        }
        if (isset($request->from_store)) {
            $query->where('from_store_no_fk', $request->from_store);
        }

        $from_date = "";
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $to_date = "";
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisition_date', $to_date);
        }



        $issued_requisition_lists = $query
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', null)
            ->where('issue_ind', '=', 1);
        // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        // dd($issued_requisition_list);

        if ($request->report_type == 'Excel') {
            $pdf = ['issued_requisition_list' => $issued_requisition_list];

            $fileToExport = "pending_receive Excel";
            $html = View("admin.uhl.inventory.indent_received_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        } else {
            return view("admin.uhl.inventory.indent_received_print", [
                'issued_requisition_list' => $issued_requisition_list

            ]);
        }
    }

    public function search_pending_issue_indent_list(Request $request)
    {

        $query = DB::table('inv_requisitiondtl')
            ->join('inv_requisitionmst', 'inv_requisitionmst.inv_requisition_no_pk', 'inv_requisitiondtl.inv_requisition_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'inv_requisitionmst.req_by')
            ->join('sysc_serviceunit from_store', 'from_store.serviceunit_no_pk', 'inv_requisitionmst.from_store_no_fk')
            ->join('sysc_serviceunit to_store', 'to_store.serviceunit_no_pk', 'inv_requisitionmst.to_store_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->leftJoin('inv_itemstockmst as from_stock', function ($join) {
                $join->on('from_stock.stock_su_no_fk', '=', 'from_store.serviceunit_no_pk')
                    ->whereRaw('from_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->leftJoin('inv_itemstockmst as to_stock', function ($join) {
                $join->on('to_stock.stock_su_no_fk', '=', 'to_store.serviceunit_no_pk')
                    ->whereRaw('to_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->select(
                'inv_requisitiondtl.inv_requisition_no_fk',
                'inv_requisitiondtl.item_name',
                'inv_requisitiondtl.req_quantity',
                'inv_requisitiondtl.issue_quantity',
                'inv_requisitiondtl.recv_quantity',
                'wsec_user.user_name',
                'from_store.serviceunit_name as from_stor',
                'to_store.serviceunit_name as to_store',
                'inv_requisitionmst.inv_requisition_date',
                'inv_requisitiondtl.urgent_ind',
                'inv_requisitiondtl.exact_ind',
                'from_stock.balance_qty as from_stock',
                'to_stock.balance_qty as to_stock',
                'sysc_serviceitem_uom.uom_code',
            )
            ->whereRaw('inv_requisitiondtl.req_quantity > inv_requisitiondtl.issue_quantity')
            ->where('inv_requisitiondtl.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));


        if (isset($request->requsion_no)) {
            $query->where('inv_requisitiondtl.inv_requisition_no_fk', $request->requsion_no);
        }
        if (isset($request->sub_store)) {
            $query->where('inv_requisitionmst.from_store_no_fk', $request->sub_store);
        }

        $from_date = "";
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $to_date = "";
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisitionmst.inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $to_date);
        }

        $issued_requisition_list = $query
            ->where('inv_requisitiondtl.issue_ind', 1)
            ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'desc')
            ->get();

        // dd($issued_requisition_list);
        return Template::loadView("admin.uhl.inventory.issue_pending_partial_item_worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }
    public function search_issue_pending_indent_list(Request $request)
    {

        $query = DB::table('indent_to_issue_report_vw')->select('indent_no', 'issue_no', 'issue_from_store', 'issue_to_store', 'issue_at', 'issue_by');


        if (isset($request->requsion_no)) {
            $query->where('indent_no', $request->requsion_no);
        }
        if (isset($request->issue_no)) {
            $query->where('issue_no', $request->issue_no);
        }
        if (isset($request->sub_store)) {
            $query->where('issue_from_store_no', $request->sub_store);
        }

        $from_date = "";
        if (!empty($request->indent_date_from)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime->format('Y-m-d'); // define expected format
        }


        $to_date = "";
        if (!empty($request->indent_date_to)) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('issue_at', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('issue_at', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('issue_at', $to_date);
        }

        $issued_requisition_list = $query
            // ->where('inv_requisitiondtl.issue_ind', 1)
            ->groupBy('indent_no', 'issue_no', 'issue_from_store', 'issue_to_store', 'issue_at', 'issue_by')
            ->orderBy('indent_no', 'desc')
            ->get();

        // dd($issued_requisition_list);
        return Template::loadView("admin.uhl.inventory.issue_pending_item_worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }
    public function pending_issue_item_pdf(Request $request)
    {

        $query = DB::table('inv_requisitiondtl')
            ->join('inv_requisitionmst', 'inv_requisitionmst.inv_requisition_no_pk', 'inv_requisitiondtl.inv_requisition_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'inv_requisitionmst.req_by')
            ->join('sysc_serviceunit from_store', 'from_store.serviceunit_no_pk', 'inv_requisitionmst.from_store_no_fk')
            ->join('sysc_serviceunit to_store', 'to_store.serviceunit_no_pk', 'inv_requisitionmst.to_store_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->leftJoin('inv_itemstockmst as from_stock', function ($join) {
                $join->on('from_stock.stock_su_no_fk', '=', 'from_store.serviceunit_no_pk')
                    ->whereRaw('from_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->leftJoin('inv_itemstockmst as to_stock', function ($join) {
                $join->on('to_stock.stock_su_no_fk', '=', 'to_store.serviceunit_no_pk')
                    ->whereRaw('to_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->select(
                'inv_requisitiondtl.inv_requisition_no_fk',
                'inv_requisitiondtl.item_name',
                'inv_requisitiondtl.req_quantity',
                'inv_requisitiondtl.issue_quantity',
                'inv_requisitiondtl.recv_quantity',
                'wsec_user.user_name',
                'from_store.serviceunit_name as from_stor',
                'to_store.serviceunit_name as to_store',
                'inv_requisitionmst.inv_requisition_date',
                'inv_requisitiondtl.urgent_ind',
                'inv_requisitiondtl.exact_ind',
                'from_stock.balance_qty as from_stock',
                'to_stock.balance_qty as to_stock',
                'sysc_serviceitem_uom.uom_code',
            )
            ->whereRaw('inv_requisitiondtl.req_quantity > inv_requisitiondtl.issue_quantity')
            ->where('inv_requisitiondtl.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));


        if (isset($request->requsion_no)) {
            $query->where('inv_requisitiondtl.inv_requisition_no_fk', $request->requsion_no);
        }
        if (isset($request->sub_store)) {
            $query->where('inv_requisitionmst.from_store_no_fk', $request->sub_store);
        }

        $from_date = "";

        if (!empty($request->indent_date_from)) {
            $dateTime_from = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime_from->format('Y-m-d'); // define expected format
        }


        $to_date = "";

        if (!empty($request->indent_date_to)) {
            $dateTime_to = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime_to->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisitionmst.inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $to_date);
        }

        $issued_requisition_list = $query
            ->where('inv_requisitiondtl.issue_ind', 1)
            ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'desc')
            ->get();


        return view("admin.uhl.inventory.pending_issue_item_pdf", [
            'issued_requisition_list' => $issued_requisition_list,
            'dateTime_from' => $from_date,
            'dateTime_to' => $to_date,
        ]);
    }
    public function pending_issue_item_excel(Request $request)
    {

        $query = DB::table('inv_requisitiondtl')
            ->join('inv_requisitionmst', 'inv_requisitionmst.inv_requisition_no_pk', 'inv_requisitiondtl.inv_requisition_no_fk')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'inv_requisitionmst.req_by')
            ->join('sysc_serviceunit from_store', 'from_store.serviceunit_no_pk', 'inv_requisitionmst.from_store_no_fk')
            ->join('sysc_serviceunit to_store', 'to_store.serviceunit_no_pk', 'inv_requisitionmst.to_store_no_fk')
            ->leftJoin('sysc_serviceitem_uom', 'sysc_serviceitem_uom.uom_no_pk', 'inv_requisitiondtl.uom')
            ->leftJoin('inv_itemstockmst as from_stock', function ($join) {
                $join->on('from_stock.stock_su_no_fk', '=', 'from_store.serviceunit_no_pk')
                    ->whereRaw('from_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->leftJoin('inv_itemstockmst as to_stock', function ($join) {
                $join->on('to_stock.stock_su_no_fk', '=', 'to_store.serviceunit_no_pk')
                    ->whereRaw('to_stock.item_no_fk = inv_requisitiondtl.item_no_fk');
            })
            ->select(
                'inv_requisitiondtl.inv_requisition_no_fk',
                'inv_requisitiondtl.item_name',
                'inv_requisitiondtl.req_quantity',
                'inv_requisitiondtl.issue_quantity',
                'inv_requisitiondtl.recv_quantity',
                'wsec_user.user_name',
                'from_store.serviceunit_name as from_stor',
                'to_store.serviceunit_name as to_store',
                'inv_requisitionmst.inv_requisition_date',
                'inv_requisitiondtl.urgent_ind',
                'inv_requisitiondtl.exact_ind',
                'from_stock.balance_qty as from_stock',
                'to_stock.balance_qty as to_stock',
                'sysc_serviceitem_uom.uom_code',
            )
            ->whereRaw('inv_requisitiondtl.req_quantity > inv_requisitiondtl.issue_quantity')
            ->where('inv_requisitiondtl.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));


        if (isset($request->requsion_no)) {
            $query->where('inv_requisitiondtl.inv_requisition_no_fk', $request->requsion_no);
        }
        if (isset($request->sub_store)) {
            $query->where('inv_requisitionmst.from_store_no_fk', $request->sub_store);
        }

        $from_date = "";

        if (!empty($request->indent_date_from)) {
            $dateTime_from = DateTime::createFromFormat('d/m/Y', $request->indent_date_from);  // define date format from user
            $from_date = $dateTime_from->format('Y-m-d'); // define expected format
        }


        $to_date = "";

        if (!empty($request->indent_date_to)) {
            $dateTime_to = DateTime::createFromFormat('d/m/Y', $request->indent_date_to);
            $to_date = $dateTime_to->format('Y-m-d');
        }


        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisitionmst.inv_requisition_date', [$from_date, $to_date]);
        } elseif (!empty($from_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $from_date);
        } elseif (!empty($to_date)) {
            $query->where('inv_requisitionmst.inv_requisition_date', $to_date);
        }

        $issued_requisition_list = $query
            ->where('inv_requisitiondtl.issue_ind', 1)
            ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'desc')
            ->get();


        // return view("admin.uhl.inventory.pending_issue_item_pdf", [
        //     'issued_requisition_list' => $issued_requisition_list,
        //     'dateTime_from'=>$from_date,
        //     'dateTime_to'=>$to_date,
        // ]);

        $result = [
            'issued_requisition_list' => $issued_requisition_list,
            'dateTime_from' => $from_date,
            'dateTime_to' => $to_date
        ];
        $fileToExport = "issue-requisition-report";
        $html = View("admin.uhl.inventory.pending_issue_item_pdf")->with($result);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function get_issued_indent_details($indent_id)
    {
        $indent_details = DB::table("INV_REQUISITIONDTL")
            ->where('inv_requisition_no_fk', $indent_id)
            // ->whereIn('issue_ind',[ 1])
            ->orderBy('inv_requisitiondtl_no_pk', 'desc')
            ->get();
        // dd($indent_details);
        return $indent_details;
    }

    public function get_received_indent_details($indent_id)
    {
        $indent_details = DB::table("INV_REQUISITIONDTL")
            ->where('inv_requisition_no_fk', $indent_id)
            ->where('issue_ind', 1)
            ->orderBy('inv_requisitiondtl_no_pk', 'desc')
            ->get();
        return $indent_details;
    }

    public function get_indent_details($indent_id)
    {
        $indent_details = DB::table("INV_REQUISITIONDTL")
            ->select('inv_requisitiondtl.*', DB::raw('NVL(inv_requisitiondtl_po.req_po_quantity,0) as req_pr_quantity'))
            ->leftJoin('inv_requisitiondtl_po', 'inv_requisitiondtl_po.requisitiondtl_no_pk_list', '=', 'inv_requisitiondtl.inv_requisitiondtl_no_pk')
            ->where('inv_requisitiondtl.inv_requisition_no_fk', $indent_id)
            ->orderBy('inv_requisitiondtl.inv_requisitiondtl_no_pk', 'desc')
            ->get();
        // dd($indent_details);
        return $indent_details;
    }

    public function indent_issued_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $issued_requisition_list = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.item-issued-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }
    public function pending_issue_worklist()
    {
        $sub_stores_list = DB::table('sysc_serviceunit')
            ->select('sysc_serviceunit.serviceunit_no_pk', 'sysc_serviceunit.serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->get();
        return Template::loadView("admin.uhl.inventory.item_pending_issue_worklist", ['sub_stores_list' => $sub_stores_list]);
    }
    public function issue_pending_list()
    {
        $sub_stores_list = DB::table('sysc_serviceunit')
            ->select('sysc_serviceunit.serviceunit_no_pk', 'sysc_serviceunit.serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '=', 1)
            ->get();
        return Template::loadView("admin.uhl.inventory.item_issue_pending_list", ['sub_stores_list' => $sub_stores_list]);
    }

    public function indent_receive_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->select(DB::raw('distinct INV_REQUISITION_NO_PK, INV_REQUISITION_UID, INV_REQUISITION_DATE, REQ_AT, TO_STORE_NO_FK, TO_STORE, FROM_STORE_NO_FK, FROM_STOR, REQ_TYPE, REQ_TYPE_BY, REF_INDENT_NO_FK, INDENT_REMARKS,
                                        AU_ENTRY_BY, USER_NAME, AU_ENTRY_SESSION, AU_ENTRY_HOSPITAL_PK_NO, INDENT_SAVE_OPTION, APPROVAL_STATUS_TEXT, APPROVAL_LEVEL_STATUS_TEXT'))
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', NULL)
            ->where('issue_ind', '=', 1)
            ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));

        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.indent-receive-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }
    public function indent_receive_worklistAll()
    {

        // $two_days_ago = date("Y-m-d", strtotime("-10 day"));
        $sub_store = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('status', '=', 1)
            // ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        // $all_su_no = [];
        // if (!empty($grant_su)) {
        //     foreach ($grant_su as  $value) {
        //         $all_su_no[] = $value->serviceunit_no_pk;
        //     }
        // }

        $issued_requisition_lists = [];
        // DB::table('inv_requisitionlist_vw')
        // //->where('inv_requisition_date', '>', $two_days_ago)
        // ->select(DB::raw('distinct INV_REQUISITION_NO_PK, INV_REQUISITION_UID, INV_REQUISITION_DATE, REQ_AT, TO_STORE_NO_FK, TO_STORE, FROM_STORE_NO_FK, FROM_STOR, REQ_TYPE, REQ_TYPE_BY, REF_INDENT_NO_FK, INDENT_REMARKS,
        // AU_ENTRY_BY, USER_NAME, AU_ENTRY_SESSION, AU_ENTRY_HOSPITAL_PK_NO, INDENT_SAVE_OPTION, APPROVAL_STATUS_TEXT, APPROVAL_LEVEL_STATUS_TEXT'))
        // ->where('indent_save_option', '=', 'POST')
        // ->where('recv_ind', '=', NULL)
        // ->where('issue_ind', '=', 1);
        // // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));

        // if (!empty($all_su_no)) {
        //     $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        // }
        $issued_requisition_list = []; //$issued_requisition_lists->orderBy('inv_requisition_no_pk', 'desc')->get();
        //    dd( $issued_requisition_list);
        return Template::loadView("admin.uhl.inventory.indent-receive-worklist", [
            'issued_requisition_list' => $issued_requisition_list,
            'sub_store' => $sub_store,
            'type' => 'ALLDEPT'
        ]);
    }


    public function indent_receive_worklist_all()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            //->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->select(DB::raw('distinct INV_REQUISITION_NO_PK, INV_REQUISITION_UID, INV_REQUISITION_DATE, REQ_AT, TO_STORE_NO_FK, TO_STORE, FROM_STORE_NO_FK, FROM_STOR, REQ_TYPE, REQ_TYPE_BY, REF_INDENT_NO_FK, INDENT_REMARKS,
            AU_ENTRY_BY, USER_NAME, AU_ENTRY_SESSION, AU_ENTRY_HOSPITAL_PK_NO, INDENT_SAVE_OPTION, APPROVAL_STATUS_TEXT, APPROVAL_LEVEL_STATUS_TEXT'))
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', NULL)
            ->where('issue_ind', '=', 1);
        //->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));

        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        // if (  !empty($all_su_no)) {
        //     $issued_requisition_list->whereIn('from_store_no_fk',[implode(',', $all_su_no)]);
        // }
        // $issued_requisition_list->orderBy('inv_requisition_no_pk', 'desc')->get();
        // dd( $issued_requisition_list);
        // dd($issued_requisition_list);
        return Template::loadView("admin.uhl.inventory.indent-receive-worklist-all", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function receive_pending_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        // implode(',', $grant_su)
        // dd(implode(',', $all_su_no));
        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', NULL)
            ->where('issue_ind', '=', 1);

        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        // if (  !empty($all_su_no)) {
        //     $issued_requisition_list->whereIn('from_store_no_fk',[implode(',', $all_su_no)]);
        // }
        // $issued_requisition_list->orderBy('inv_requisition_no_pk', 'desc')->get();
        // dd( $issued_requisition_list);

        return Template::loadView("admin.uhl.inventory.receive-pending-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }

    public function search_indent_receive_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', NULL)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('issue_ind', '=', 1);
        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.search-indent-receive-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function search_indent_receive_worklist_all()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            //->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('recv_ind', '=', NULL)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            //->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('issue_ind', '=', 1);
        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.search-indent-receive-worklist-all", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }

    public function indent_received_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('recv_ind', '=', 1);
        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.indent-received-worklist-all", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function indent_received_worklist_all()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            // ->orWhere('main_store_ind', '=', 1)
            // ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $all_su_no = [];
        if (!empty($grant_su)) {
            foreach ($grant_su as  $value) {
                $all_su_no[] = $value->serviceunit_no_pk;
            }
        }

        $issued_requisition_lists = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'))
            ->where('recv_ind', '=', 1);
        if (!empty($all_su_no)) {
            $issued_requisition_lists->whereIn('from_store_no_fk', $all_su_no);
        }
        $issued_requisition_list = $issued_requisition_lists
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.indent-received-worklist-all", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }


    public function only_indent_issued_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $issued_requisition_list = DB::table('inv_requisitionlist_vw')
            ->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.only-issued-item-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }

    public function only_indent_partial_issued_worklist()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $issued_requisition_list = DB::table('inv_requisitionlist_vw')
            //->where('inv_requisition_date', '>', $two_days_ago)
            ->where('indent_save_option', '=', 'POST')
            ->where('issue_ind', '=', 1)
            ->orderBy('inv_requisition_no_pk', 'desc')
            ->get();
        return Template::loadView("admin.uhl.inventory.only-issued-partial-item-worklist", [
            'issued_requisition_list' => $issued_requisition_list
        ]);
    }

    public function create(Request $request)
    {

        // dd($request->all());


        $sql = "begin
            pkg_v1_inventory_all.prc_invrequisition_info_refcur(
                :p_ref_invrequisition_info,
                :p_inv_requisition_no_pk,
                :p_item_name,
                :p_main_su_no_fk,
                :in_au_entry_hospital_no_fk
            );
            end;";
        $pdo = DB::getPdo();
        $requisition_no = $request->requisition_no;
        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];

        $stmt = $pdo->prepare($sql);

        

        $stmt->bindParam(':p_ref_invrequisition_info', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':p_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        $stmt->bindParam(':p_item_name', $empty, PDO::PARAM_STR, 100);
        $stmt->bindParam(':p_main_su_no_fk', $text, PDO::PARAM_INT);
        $stmt->bindParam(':in_au_entry_hospital_no_fk', $text, PDO::PARAM_INT);

        $stmt->execute();
        // fix
        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);

        $requisition_list =  $array;
        // dd( $requisition_list);
        return Template::loadView("admin.uhl.inventory.item-issue", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no
        ]);
    }

    public function pr_info($req_detail_id, $item_id)
    {
        $pr = DB::table("inv_requisitiondtl_po")
            ->where('requisitiondtl_no_pk_list', $req_detail_id)
            ->where('item_no_fk', $item_id)
            ->sum('req_po_quantity');

        return $pr;
    }


    public function pr_requested_indent_item(Request $request)
    {
        $sql = "begin
        pkg_v1_inventory_all.prc_invrequisition_set_info_refcur(
                :p_ref_invrequisition_info,
                :p_inv_requisition_no_pk,
                :p_item_name,
                :p_main_su_no_fk,
                :p_sub_su_no_fk,
                :in_au_entry_hospital_no_fk
            );
            end;";
        $pdo = DB::getPdo();
        $text = null;
        $empty = "";
        $zero = 0;
        $lista = [];
        $requisition_no = isset($request->requisition_no) ? $request->requisition_no : $text;
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':p_ref_invrequisition_info', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':p_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        $stmt->bindParam(':p_item_name', $empty, PDO::PARAM_STR, 100);
        $stmt->bindParam(':p_main_su_no_fk', $text, PDO::PARAM_INT);
        $stmt->bindParam(':p_sub_su_no_fk', $text, PDO::PARAM_INT);
        $stmt->bindParam(':in_au_entry_hospital_no_fk', $text, PDO::PARAM_INT);
        $stmt->execute();

        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);

        $requisition_list = []; //  $array;

        // dd( $requisition_list);

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();


        // dd($requisition_list);
        return Template::loadView("admin.uhl.inventory.requested-pr-item", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no,
            'main_store_list' => $main_store_list,
            'all_stores_list' => $all_stores_list
        ]);
    }


    public function search_pr_requested_indent_item(Request $request)
    {
        $sql = "begin
        pkg_v1_inventory_all.prc_invrequisition_set_info_refcur(
                :p_ref_invrequisition_info,
                :p_inv_requisition_no_pk,
                :p_item_name,
                :p_main_su_no_fk,
                :p_sub_su_no_fk,
                :in_au_entry_hospital_no_fk
            );
            end;";
        $pdo = DB::getPdo();
        $text = null;
        $main_store = $request->main_store_id;
        $empty = "";
        $zero = 0;
        $lista = [];
        $requisition_no = isset($request->requisition_no) ? $request->requisition_no : $text;
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':p_ref_invrequisition_info', $lista, PDO::PARAM_STMT);
        $stmt->bindParam(':p_inv_requisition_no_pk', $requisition_no, PDO::PARAM_INT);
        $stmt->bindParam(':p_item_name', $empty, PDO::PARAM_STR, 100);
        $stmt->bindParam(':p_main_su_no_fk', $main_store, PDO::PARAM_INT);
        $stmt->bindParam(':p_sub_su_no_fk', $text, PDO::PARAM_INT);
        $stmt->bindParam(':in_au_entry_hospital_no_fk', $text, PDO::PARAM_INT);
        $stmt->execute();

        oci_execute($lista, OCI_DEFAULT);
        oci_fetch_all($lista, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        oci_free_cursor($lista);

        $requisition_list =  $array;
        // dd($requisition_list);

        $main_store_list = ServiceUnit::where('main_store_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $all_stores_list = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '!=', 1)
            ->where('main_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();

        //dd($requisition_list);
        //dd(  $requisition_list, $requisition_no);
        return Template::loadView("admin.uhl.inventory.search-requested-pr-item", [
            "requisition_list" => $requisition_list,
            'requisition_no' => $requisition_no,
            'main_store_list' => $main_store_list,
            'all_stores_list' => $all_stores_list
        ]);
    }

    public function store(Request $request)
    {
        if (!isset($request->item_quantity)) {
            $message = ['msg' => '<strong>Issue qty. can not empty.</strong><br>', 'title' => 'error'];
            return response()->json($message);
        }
        $numelems = 1000;

        $out_po_uid = '';
        $out_itemissue_no_fk = '';
        $out_error = '';
        $out_purchase_uid = '';
        $person_no = $request->hdn_person_no == 0 ? '' : $request->hdn_person_no;

        $null = '';
        $zero = 0;
        $emptyArray = array();
        $null = date('Y');
        $out_purchase_no_pk = 0;
        $pdo = DB::getPdo();
        $requisition_info = DB::table('inv_requisitionlist_vw')->where('inv_requisition_no_pk', $request->requisition_no)->first();


        $in_issue_to = "STORE";
        $in_issue_ref_no = $request->requisition_no;
        $in_issue_date = date("Y-m-d");
        //Reverse From Requisition.
        $in_store_from_su_no_fk = $requisition_info->to_store_no_fk;
        $in_store_to_su_no_fk = $requisition_info->from_store_no_fk;
        $null = "";
        $zero = 0;
        $empty_arr = [];
        $in_au_entry_session = 'UHL Department Issue';
        $in_au_entry_by = Session::get('user.ses_user_pk_no');
        $in_au_entry_session = 'UHL TEST';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');


        $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemissue_ss(
             :in_issue_to,
             :in_issue_ref_no,
             :in_issue_date,
             :in_store_from_su_no_fk,
             :in_store_to_su_no_fk,
             :in_patient_no_fk,
             :in_person_no_fk,
             :in_event_lookup_no_fk,
             :in_event_name,
             :in_a_item_no_fk,
             :in_item_batch_fk,
             :in_item_expiry_dt,
             :in_a_item_pvmsno,
             :in_a_item_qty,
             :in_a_item_uom,
             :in_a_item_price,
             :in_a_entry_serial_dtl,
             :in_purchaseorderdtl_no_pk,
             :in_inv_requisitiondtl_no_pk,
             :in_itemreceivedtl_no_pk,
             :in_internal_batch_no_uq,
             :in_cost_price,
             :in_invoicedtl_no_pk,
             :in_a_purchase_price,
             :in_a_sales_price,
             :in_au_entry_by,
             :in_au_entry_session,
             :in_au_entry_hospital_no_fk,
             :out_itemissue_no_fk,
             :out_itemissue_uid,
             :out_error
                ); end;");

        $all_exp =  $internal_item_batch_fk = $cost_price = $in_inv_requisitiondtl_no_pk = $item_no_fk_arr = $in_item_batch_fk = $in_item_expiry_dt =  $in_a_item_pvmsno = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = [];
        // for ($i = 0; $i < count($request->item_name); $i++) {
        //     if (isset($request->item_quantity[$i])) {
        //         $item_no_fk_arr[$i] = $request->item_name[$i];
        //         $in_item_batch_fk[$i] = $request->item_batch_fk[$i];
        //         $in_item_expiry_dt[$i] =  $request->item_expire_date[$i];;
        //         $in_a_item_pvmsno[$i] = '';
        //         $empty_arr[$i] = 0;
        //         $in_a_item_qty[$i] = $request->item_quantity[$i];
        //         $in_a_item_uom[$i] = $request->item_uom[$i];
        //         $in_a_item_price[$i] = $request->item_price[$i];
        //         $in_inv_requisitiondtl_no_pk[$i] = $request->in_inv_requisitiondtl_no_pk[$i];
        //         $in_a_entry_serial_dtl[$i] = $i + 1;
        //     }
        // }


        for ($i = 0; $i < count($request->hidden_batch_no_qty); $i++) {

            $all_exp[$i] = explode('_', $request->hidden_batch_no_qty[$i]);


            $item_no_fk_arr[$i] = intval($all_exp[$i][3]);
            $internal_item_batch_fk[$i] = $all_exp[$i][0];
            $in_item_batch_fk[$i] = $all_exp[$i][1];
            $in_item_expiry_dt[$i] =  $all_exp[$i][2] != "" ? date('dmY', strtotime($all_exp[$i][2])) : '';
            $in_a_item_pvmsno[$i] = '';
            $empty_arr[$i] = 0;
            $in_a_item_qty[$i] = floatval($all_exp[$i][4]);
            $cost_price[$i] = $all_exp[$i][5] != "" ? floatval($all_exp[$i][5]) : 0;
            $in_a_item_uom[$i] = intval($all_exp[$i][7]);
            $in_a_item_price[$i] = floatval($all_exp[$i][6]);
            $in_inv_requisitiondtl_no_pk[$i] = $all_exp[$i][8];
            $purchaseorderdtl_no_pk[$i] = $all_exp[$i][9];
            $invoicedtl_no_pk[$i] = $all_exp[$i][10] != "" ? $all_exp[$i][10] : null;
            $itemreceivedtl_no_pk[$i] = $all_exp[$i][11];
            $in_a_entry_serial_dtl[$i] = $i + 1;
        }

        // dd($empty_arr,$in_inv_requisitiondtl_no_pk, $item_no_fk_arr, $internal_item_batch_fk, $in_item_batch_fk , $cost_price ,               $in_a_item_uom);
        $purchase_order_entry->bindparam('in_issue_to', $in_issue_to);
        $purchase_order_entry->bindparam('in_issue_ref_no', $in_issue_ref_no);
        $purchase_order_entry->bindparam('in_issue_date', $in_issue_date);
        $purchase_order_entry->bindparam('in_store_from_su_no_fk', $in_store_from_su_no_fk);
        $purchase_order_entry->bindparam('in_store_to_su_no_fk', $in_store_to_su_no_fk);
        $purchase_order_entry->bindparam('in_patient_no_fk', $null);
        $purchase_order_entry->bindparam('in_person_no_fk', $person_no);
        $purchase_order_entry->bindparam('in_event_lookup_no_fk', $zero);
        $purchase_order_entry->bindparam('in_event_name', $null);
        $purchase_order_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_item_batch_fk', $in_item_batch_fk, count($in_item_batch_fk), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_item_expiry_dt', $in_item_expiry_dt, count($in_item_expiry_dt), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_item_pvmsno', $in_a_item_pvmsno, count($in_a_item_pvmsno), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_a_item_qty', $in_a_item_qty, count($in_a_item_qty), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_item_uom', $in_a_item_uom, count($in_a_item_uom), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_item_price', $in_a_item_price, count($in_a_item_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_entry_serial_dtl', $in_a_entry_serial_dtl, count($in_a_entry_serial_dtl), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_purchaseorderdtl_no_pk', $purchaseorderdtl_no_pk, count($purchaseorderdtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_inv_requisitiondtl_no_pk', $in_inv_requisitiondtl_no_pk, count($in_inv_requisitiondtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_itemreceivedtl_no_pk', $itemreceivedtl_no_pk, count($itemreceivedtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_internal_batch_no_uq', $internal_item_batch_fk, count($internal_item_batch_fk), $numelems, SQLT_CHR);
        $purchase_order_entry->bindArray('in_cost_price', $cost_price, count($cost_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_invoicedtl_no_pk', $invoicedtl_no_pk, count($invoicedtl_no_pk), $numelems, SQLT_INT);
        $purchase_order_entry->bindArray('in_a_purchase_price', $in_a_item_price, count($in_a_item_price), $numelems, SQLT_FLT);
        $purchase_order_entry->bindArray('in_a_sales_price', $empty_arr, count($empty_arr), $numelems, SQLT_FLT);
        $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
        $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
        $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
        $purchase_order_entry->bindParam('out_itemissue_no_fk', $out_itemissue_no_fk, PDO::PARAM_INT, 500);
        $purchase_order_entry->bindParam('out_itemissue_uid', $out_po_uid, PDO::PARAM_STR, 500);
        $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
        // dd( $purchase_order_entry);
        $purchase_order_entry->execute();

        DB::commit();
        $message = [
            'msg' => 'Data saved successfully.<br><strong>Issue UID = ' . $out_po_uid . '</strong>',
            'title' => 'Success',
            'print_url' => route('v1.department-issued-indent-print', ['id' => $request->requisition_no])
        ];
        // dd($message);
        return response()->json($message);
    }


    public function direct_pr()
    {
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
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
            ->where('sub_store_ind', '!=', 1)
            ->get();
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();
        $approval_id = '';
        $minor_group = DB::table('item_type_vw')
            ->where('minor_group_ind', 1)
            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
            ->orderBy('item_name')
            ->get();
        if (in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO", "KPJ"])) {

            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition_v2", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'approval_id' => $approval_id,
                'allSuppliers' => $allSuppliers,
                'minor_group' => $minor_group,
            ]);
        } else {
            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'approval_id' => $approval_id,
                'allSuppliers' => $allSuppliers,
                'minor_group' => $minor_group,
            ]);
        }
    }


    public function direct_pr_phr()
    {
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
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
            ->where('sub_store_ind', '!=', 1)
            ->get();
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();
        $approval_id = '';
        $minor_group = DB::table('item_type_vw')
            ->where('minor_group_ind', 1)
            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
            ->orderBy('item_name')
            ->get();
        if (in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"])) {

            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition_v2_phr", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'approval_id' => $approval_id,
                'allSuppliers' => $allSuppliers,
                'minor_group' => $minor_group,
            ]);
        } else {
            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'approval_id' => $approval_id,
                'allSuppliers' => $allSuppliers,
                'minor_group' => $minor_group,
            ]);
        }
    }

    public function getReorderLavelItem(Request $request)
    {

        $store_id = intval($request->store_id);
        // dd(  $request->Manufacturer_id);
        // $sub_store_id = intval($request->department_from);

        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                DB::raw('sum(balance_qty) as stock_qty'),
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',
                // 'inv.stock_qty',
            )
            ->rightJoin('inv_itemstockmst', 'inv_itemstockmst.item_no_fk', '=', 's.item_no_pk')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->where('s.manufacturer_no_fk', $request->Manufacturer_id)
            ->orderBy("s.item_name")
            ->groupBy(
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',
            )
            ->having('s.re_order_level', '>=', DB::raw('SUM(balance_qty)'))
            ->get();
        //    dd($result);
        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {

                DB::beginTransaction();

                $hospital = Session::get('user.ses_hospital_no_pk');
                $main_store_stock = 0;
                // $sub_store_stock = 0;
                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 500);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();


                // $stmt = $pdo->prepare("begin :sub_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                // $stmt->bindParam(':sub_store_stock', $sub_store_stock, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 500);
                // $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_STORE_SU_NO_FK', $sub_store_id, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                // $stmt->execute();

                $main_stock = intval($main_store_stock);
                // $sub_stock = intval($sub_store_stock);
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
                    'lpd'                       => $value->lpd != "" ? date('d/m/Y', strtotime($value->lpd)) : '',
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($sub_stock) && $sub_stock != null ? $sub_stock : 0, //isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0, //isset($main_stock) && $main_stock != null ? $main_stock : 0,//
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'l3mac'            => isset($value->l3mac) ? $value->l3mac : 0,
                    'l3mc'            => isset($value->l3mc) ? $value->l3mc : 0,
                );
            }
        }
        return $item_info;
        //  dd( $item_info);
    }


    public function getSupplierWiseItem(Request $request)
    {

        $store_id = intval($request->store_id);
        // dd(  $request->main_store_id);

        // $sub_store_id = intval($request->department_from);

        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                DB::raw('sum(balance_qty) as stock_qty'),
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',
                // 'inv.stock_qty',
            )
            ->leftJoin('inv_itemstockmst', 'inv_itemstockmst.item_no_fk', '=', 's.item_no_pk')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->where('s.manufacturer_no_fk', $request->Manufacturer_id)
            ->where('s.mainstore_su_no_fk', $request->main_store_id)
            ->orderBy("s.item_name")
            ->groupBy(
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',

            )
            //->having('s.re_order_level', '>=', DB::raw('SUM(balance_qty)'))
            ->get();
        // dd($result);
        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {

                DB::beginTransaction();

                $hospital = Session::get('user.ses_hospital_no_pk');
                $main_store_stock = 0;
                // $sub_store_stock = 0;
                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 500);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();


                // $stmt = $pdo->prepare("begin :sub_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                // $stmt->bindParam(':sub_store_stock', $sub_store_stock, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 500);
                // $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_STORE_SU_NO_FK', $sub_store_id, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                // $stmt->execute();

                $main_stock = intval($main_store_stock);
                // $sub_stock = intval($sub_store_stock);
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
                    'lpd'                       => $value->lpd != "" ? date('d/m/Y', strtotime($value->lpd)) : '',
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($sub_stock) && $sub_stock != null ? $sub_stock : 0, //isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0, //isset($main_stock) && $main_stock != null ? $main_stock : 0,//
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'l3mac'            => isset($value->l3mac) ? $value->l3mac : 0,
                    'l3mc'            => isset($value->l3mc) ? $value->l3mc : 0,
                );
            }
        }
        return $item_info;
        // dd( $item_info);
    }


    public function getMinorGroupItem(Request $request)
    {

        $store_id = intval($request->store_id);
        // dd(  $request->main_store_id);

        // $sub_store_id = intval($request->department_from);

        $result  = DB::table('sysc_v1_serviceitem_vw s')
            ->select(
                DB::raw('sum(balance_qty) as stock_qty'),
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',

                // 'inv.stock_qty',
            )
            ->leftJoin('inv_itemstockmst', 'inv_itemstockmst.item_no_fk', '=', 's.item_no_pk')
            ->leftJoin('sysc_serviceitem_inv_vw inv', 'inv.item_no_fk', 's.item_no_pk')
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('s.status', 1)
            // ->where('l.store_name', 'PHARMACY')
            ->where('s.itemtype_no_fk', $request->Manufacturer_id)
            ->where('s.mainstore_su_no_fk', $request->main_store_id)
            ->orderBy("s.item_name")
            ->groupBy(
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
                'inv.stock_store',
                'inv.con_qty7days',
                'inv.con_qty30days',
                'inv.generic_stock',
                'inv.l3mc',
                'inv.l3mac',

            )
            //->having('s.re_order_level', '>=', DB::raw('SUM(balance_qty)'))
            ->get();
        // dd($result);
        $item_info = [];

        $pdo = DB::getPdo();

        if (!empty($result)) {

            foreach ($result as $value) {

                DB::beginTransaction();

                $hospital = Session::get('user.ses_hospital_no_pk');
                $main_store_stock = 0;
                // $sub_store_stock = 0;
                $stmt = $pdo->prepare("begin :main_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                $stmt->bindParam(':main_store_stock', $main_store_stock, PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 500);
                $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                $stmt->bindParam(':IN_STORE_SU_NO_FK', $store_id, PDO::PARAM_INT);
                $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                $stmt->execute();


                // $stmt = $pdo->prepare("begin :sub_store_stock := PKG_V1_INVENTORY_ALL.get_store_stock(:IN_ITEM_NO_FK,:IN_STORE_SU_NO_FK,:IN_AU_ENTRY_HOSPITAL_NO_FK); end;");
                // $stmt->bindParam(':sub_store_stock', $sub_store_stock, \PDO::PARAM_STR|\PDO::PARAM_INPUT_OUTPUT, 500);
                // $stmt->bindParam(':IN_ITEM_NO_FK', $value->item_no_pk, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_STORE_SU_NO_FK', $sub_store_id, PDO::PARAM_INT);
                // $stmt->bindParam(':IN_AU_ENTRY_HOSPITAL_NO_FK', $hospital, PDO::PARAM_INT);
                // $stmt->execute();

                $main_stock = intval($main_store_stock);
                // $sub_stock = intval($sub_store_stock);
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
                    'lpd'                       => $value->lpd != "" ? date('d/m/Y', strtotime($value->lpd)) : '',
                    'lpp'                       => isset($value->lpp) ? $value->lpp : 0,
                    'generic_global_stock'      => isset($value->generic_global_stock) ? $value->generic_global_stock : 0,
                    'generic_stock_store'       => isset($value->generic_stock_store) ? $value->generic_stock_store : 0,
                    'stock_store'               => isset($sub_stock) && $sub_stock != null ? $sub_stock : 0, //isset($value->stock_store) ? $value->stock_store : 0,
                    'con_qty7days'              => isset($value->con_qty7days) ? $value->con_qty7days : 0,
                    'con_qty30days'             => isset($value->con_qty30days) ? $value->con_qty30days : 0,
                    'generic_stock'             => isset($value->generic_stock) ? $value->generic_stock : 0,
                    'stock_qty'                 => isset($value->stock_qty) ? $value->stock_qty : 0, //isset($main_stock) && $main_stock != null ? $main_stock : 0,//
                    're_order_level'            => isset($value->re_order_level) ? $value->re_order_level : 0,
                    'l3mac'            => isset($value->l3mac) ? $value->l3mac : 0,
                    'l3mc'            => isset($value->l3mc) ? $value->l3mc : 0,
                );
            }
        }
        return $item_info;
        // dd( $item_info);
    }


    public function edit_direct_pr($id, $app_status)
    {
        $pr_id_exp = explode('.', $id);
        $approval_id = isset($pr_id_exp[1]) ? $pr_id_exp[1] : '';
        $hospital_list  = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
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
            ->where('sub_store_ind', '!=', 1)
            ->get();

        $requistion_po_mst = DB::table("inv_requisitionmst_po")
            ->select('sysc_serviceunit.serviceunit_name', 'inv_requisitionmst_po.main_store_su_no_fk', 'inv_requisitionmst_po.req_po_remarks', 'inv_requisitionmst_po.req_po_save_option', 'supplier_no_fk')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisitionmst_po.main_store_su_no_fk')
            ->where('inv_requisition_po_no_pk', $pr_id_exp[0])
            ->first();
        $requisition_items = DB::table("inv_requisition_po_itm_vw")
            ->select('inv_requisition_po_itm_vw.*', 'sysc_serviceitem_inv_vw.lpp')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', '=', 'inv_requisition_po_itm_vw.item_no_fk')
            ->where('inv_requisitiondtl_no_pk', $pr_id_exp[0])
            ->orderBy('inv_requisitiondtl_po_no_pk')
            ->get();
        // dd($requisition_items);
        foreach ($requisition_items as $item) {
            $global_stock_qty = DB::table('inv_itemstockmst')
                ->select(DB::raw('SUM(balance_qty) as global_stock_qty'))
                ->where('item_no_fk', $item->item_no_fk) // Use the correct property
                ->first();

            // Add global_stock_qty to the item
            $item->global_stock_qty = $global_stock_qty->global_stock_qty ?? 0; // Default to 0 if no stock found
        }
        // dd( $requisition_items);
        $approvals = DB::table('sysc_approvalprocess_vw')->select('level_status_text')->where('primary_key_value', $pr_id_exp[0])->where('approval_for_code', 'PR')->get();

        $approvalTexts = [];
        foreach ($approvals as $approval) {
            $approvalTexts[] = $approval->level_status_text;
        }
        $approvalArray = implode(',', $approvalTexts);
        $allSuppliers = DB::table('inv_supplier')
            ->select('supplier_no_pk', 'supplier_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw("lower(supplier_name) asc")
            ->get();

        $minor_group = DB::table('item_type_vw')
            ->where('minor_group_ind', 1)
            ->select('item_name', 'asset_su_no_fk', 'itemtype_no_pk')
            ->orderBy('item_name')
            ->get();
        if (in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"])) {
            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition_v2", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'requistion_po_mst' => $requistion_po_mst,
                'requisition_items' => $requisition_items,
                'requisition_id' => $pr_id_exp[0],
                'approval_id' => $approval_id,
                'approval' => $approvalArray,
                'app_status' => $app_status,
                'allSuppliers' => $allSuppliers,
                'minor_group' => $minor_group,
            ]);
        } else {
            return Template::loadView("admin.uhl.inventory.direct-purchase-requisition", [
                'hospital_list' => $hospital_list,
                'main_stores_list' => $main_stores_list,
                'all_stores_list' => $all_stores_list,
                'requistion_po_mst' => $requistion_po_mst,
                'requisition_items' => $requisition_items,
                'requisition_id' => $pr_id_exp[0],
                'approval_id' => $approval_id,
                'approval' => $approvalArray,
                'app_status' => $app_status,
            ]);
        }
    }




    public function save_for_pr(Request $request)
    {

        DB::beginTransaction();
        try {
            foreach ($request->go_pr as $item) {

                try {
                    $check_req = DB::table("inv_requisitiondtl")
                        ->where('item_no_fk', $item)
                        ->where('inv_requisition_no_fk', $request->requisition_no)
                        ->get();
                    // dd($check_req[0]->purchase_req_set_ind);
                    if (isset($check_req[0]->purchase_req_set_ind) && $check_req[0]->purchase_req_set_ind == 1) {

                        $message = ['msg' => 'This Indent already in PR list', 'title' => 'error'];
                        return response()->json($message);
                    }
                } catch (\Exception $e) {
                }
                DB::table("inv_requisitiondtl")
                    ->where('item_no_fk', $item)
                    ->where('inv_requisition_no_fk', $request->requisition_no)
                    ->update([
                        'purchase_req_set_ind' => 1,
                        'purchase_req_set_by' => Auth::id(),
                        'purchase_req_set_at' => date("Y-m-d h:i:s")
                    ]);
            }

            $message = ['msg' => 'Data saved successfully.<br>', 'title' => 'Success'];
            DB::commit();
        } catch (\Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'error'];
            DB::rollback();
        }

        return response()->json($message);
    }


    public function store_requested_pr_item_to_pr(Request $request)
    {
        // dd($request->all());
        try {
            if ($files = $request->file('attachment')) {
                $fileSize =  $request->file('attachment')->getSize() / 1024 / 1024;
                if ($fileSize > 50) {
                    // return $validator->errors()->add('item', 'The file cannot be uploaded more than 10 MB.');
                    $message = ['msg' => 'The file cannot be uploaded more than 10 MB.', 'title' => 'Error'];
                    return response()->json($message);
                }
            }
            $numelems = 1000;
            $out_po_uid = '';
            $out_requisition_no_pk = 0;
            $out_error = '';
            $null = '';
            $zero = 0;
            $null = date('Y');
            $pdo = DB::getPdo();
            $requisition_info = DB::table('inv_requisitionlist_vw')->where('inv_requisition_no_pk', $request->requisition_no)->first();
            $in_req_saveoption = $request->in_req_saveoption;
            // dd($in_req_saveoption);
            $null = "";
            $zero = 0;
            $in_au_entry_session = 'PR';
            $in_au_entry_by = Session::get('user.ses_user_pk_no');
            $in_au_entry_session = 'PR';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

            $in_requisition_po_date = date("Y-m-d");
            $in_main_store_su_no_fk = isset($request->go_pr) ? $request->main_store_id :  $request->department_to; //

            $request->hdn_main_store_id;
            $in_ref_requisition_po_no_fk = $request->inv_requisition_no_pk;
            $in_req_po_remarks = $request->indent_remarks;
            $in_requisition_po_no_pk = isset($request->requisition_id) ? intval($request->requisition_id) : $zero;
            $in_single_po_ind = isset($request->requisition_id) ? 1 : $zero;
            $in_edit_ind = isset($request->requisition_id) ? 1 : $zero;

            // dd( $in_main_store_su_no_fk );
            // $req_url = 'https://api.exchangerate.host/latest?base=USD';
            // $response_json = file_get_contents($req_url);
            // $response = json_decode($response_json);
            // dd( $response);




            $purchase_order_entry = $pdo->prepare("begin pkg_v1_inventory_all.prc_itemrequisition_po(
            :in_requisition_po_no_pk,
            :in_requisition_po_date,
            :in_main_store_su_no_fk,
            :in_ref_requisition_po_no_fk,
            :in_req_po_remarks,
            :in_req_po_type,
            :in_edit_ind,
            :in_req_saveoption,
            :in_single_po_ind,
            :in_a_item_no_fk,
            :in_a_item_qty,
            :in_a_item_rate,
            :in_a_item_uom,
            :in_a_urgent_ind,
            :in_a_exact_ind,
            :in_a_item_remarks,
            :in_a_entry_serial_dtl,
            :in_expect_date,
            :in_requisitiondtl_no_pk_list,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_requisition_po_no_pk,
            :out_requisition_po_uid,
            :out_error
                ); end;");

            $in_inv_requisitiondtl_no_pk = $item_no_fk_arr = $in_item_batch_fk = $in_item_expiry_dt =  $in_expect_date = $in_requisitiondtl_no_pk_list = $in_a_urgent_ind = $in_a_exact_ind = $in_a_item_remarks = $in_a_item_qty = $in_a_item_uom = $in_a_item_price = $in_a_entry_serial_dtl = $dollar_ind = [];

            if (isset($request->go_pr)) {

                for ($i = 0; $i < count($request->go_pr); $i++) {
                    $item_no_fk_arr[$i] = $request->input('item_name_' .  $request->go_pr[$i]);
                    $dollar_ind[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_no_fk_arr)->select('dollar_ind')->first()->dollar_ind . '_' . $request->input('item_name_' .  $request->go_pr[$i]);
                    $in_a_urgent_ind[$i] = $request->input('in_a_urgent_ind_' .  $request->go_pr[$i]);
                    $in_a_exact_ind[$i] = $request->input('in_a_exact_ind_' .  $request->go_pr[$i]);
                    $in_a_item_remarks[$i] = $request->input('in_a_item_remarks_' .  $request->go_pr[$i]);
                    $in_expect_date[$i] = date("d-m-Y");
                    $in_a_item_qty[$i] = $request->input('item_quantity_' .  $request->go_pr[$i]);
                    $in_a_item_rate[$i] = $request->input('item_price_' .  $request->go_pr[$i]);
                    $in_a_item_uom[$i] = $request->input('item_uom_' .  $request->go_pr[$i]);
                    $in_requisitiondtl_no_pk_list[$i] = $request->input('in_inv_requisitiondtl_no_pk_' .  $request->go_pr[$i]);
                    $in_a_entry_serial_dtl[$i] = $i + 1;
                }
                // dd($dollar_ind);
            } else {
                for ($i = 0; $i < count($request->item_id_hidden); $i++) {
                    $item_no_fk_arr[$i] = $request->item_id_hidden[$i];
                    $dollar_ind[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $request->item_id_hidden[$i])->select('dollar_ind')->first()->dollar_ind . '_' . $request->item_id_hidden[$i];
                    $in_a_urgent_ind[$i] = $null; //$request->in_a_urgent_ind[$i];
                    $in_a_exact_ind[$i] = $null; //$request->in_a_exact_ind[$i];
                    $in_a_item_remarks[$i] = $request->remarks[$i];
                    $in_expect_date[$i] = date("d-m-Y");

                    $in_a_item_qty[$i] = $request->item_quantity[$i];
                    $in_a_item_rate[$i] = $request->last_pp[$i];
                    $in_a_item_uom[$i] = $request->uom_no_fk[$i];
                    $in_requisitiondtl_no_pk_list[$i] = $null; //$request->in_inv_requisitiondtl_no_pk[$i];
                    $in_a_entry_serial_dtl[$i] = $i + 1;
                }
            }

            // dd($request->item_id_hidden,$request->uom_no_fk,$request->item_quantity,$request->last_pp,$request->remarks);
            $purchase_order_entry->bindparam('in_requisition_po_no_pk', $in_requisition_po_no_pk);
            $purchase_order_entry->bindparam('in_requisition_po_date', $in_requisition_po_date);
            $purchase_order_entry->bindparam('in_main_store_su_no_fk', $in_main_store_su_no_fk);
            $purchase_order_entry->bindparam('in_ref_requisition_po_no_fk', $zero);
            $purchase_order_entry->bindparam('in_req_po_remarks', $in_req_po_remarks);

            $purchase_order_entry->bindparam('in_req_po_type', $null);

            $purchase_order_entry->bindparam('in_edit_ind', $in_edit_ind);
            $purchase_order_entry->bindparam('in_req_saveoption', $in_req_saveoption);
            $purchase_order_entry->bindparam('in_single_po_ind', $in_single_po_ind);

            $purchase_order_entry->bindArray('in_a_item_no_fk', $item_no_fk_arr, count($item_no_fk_arr), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_a_item_qty', $in_a_item_qty, count($in_a_item_qty), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_item_rate', $in_a_item_rate, count($in_a_item_rate), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_item_uom', $in_a_item_uom, count($in_a_item_uom), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_urgent_ind', $in_a_urgent_ind, count($in_a_urgent_ind), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_exact_ind', $in_a_exact_ind, count($in_a_exact_ind), $numelems, SQLT_FLT);
            $purchase_order_entry->bindArray('in_a_item_remarks', $in_a_item_remarks, count($in_a_item_remarks), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_a_entry_serial_dtl', $in_a_entry_serial_dtl, count($in_a_entry_serial_dtl), $numelems, SQLT_INT);
            $purchase_order_entry->bindArray('in_expect_date', $in_expect_date, count($in_expect_date), $numelems, SQLT_CHR);
            $purchase_order_entry->bindArray('in_requisitiondtl_no_pk_list', $in_requisitiondtl_no_pk_list, count($in_requisitiondtl_no_pk_list), $numelems, SQLT_CHR);
            $purchase_order_entry->bindparam('in_au_entry_by', $in_au_entry_by);
            $purchase_order_entry->bindparam('in_au_entry_session', $in_au_entry_session);
            $purchase_order_entry->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $purchase_order_entry->bindParam('out_requisition_po_no_pk', $out_requisition_no_pk, PDO::PARAM_INT);
            $purchase_order_entry->bindParam('out_requisition_po_uid', $out_po_uid, PDO::PARAM_STR, 500);
            $purchase_order_entry->bindParam('out_error', $out_error, PDO::PARAM_STR, 500);
            // dd(isset($request->go_pr),$purchase_order_entry);
            $purchase_order_entry->execute();



            $req_id = !empty($out_requisition_no_pk) ? $out_requisition_no_pk : $request->requisition_id;
            if ($out_error == '000') {
                if ($request->supplier_id != "") {
                    $in_main_store_su_no_fk = isset($request->go_pr) ? $request->main_store_id :  $request->department_to; //
                    $pharmacy_ind = DB::table('sysc_serviceunit')->select('pharmacy_ind')->where('serviceunit_no_pk', $in_main_store_su_no_fk)->first();
                    if (isset($pharmacy_ind) && $pharmacy_ind->pharmacy_ind != "") {
                        DB::table('inv_requisitionmst_po')->where('inv_requisition_po_no_pk', $req_id)->update(['supplier_no_fk' => $request->supplier_id]);
                    }
                }
                if ($request->hasFile('attachment')) {
                    if ($files = $request->file('attachment')) {
                        $data['pr_doc_attachment_path'] = date('Ymdhi') . "." . $files->getClientOriginalExtension();
                    }

                    if ($files = $request->file('attachment')) {
                        //$this->uploadImages($files, $data['pr_doc_attachment_path'], 'images/uploads/attachment/', 'images/uploads/attachment/thumb/');

                        $image = $request->file('attachment');

                        // Generate a unique name for the image
                        $filename = $data['pr_doc_attachment_path']; //uniqid() . '.' . $image->getClientOriginalExtension();

                        // Save the image to the public directory
                        $request->attachment->move(public_path('/images/uploads/attachment'), $filename);
                    }
                    // dd($data);
                    DB::table('inv_requisitionmst_po')->where('inv_requisition_po_no_pk', $req_id)->update($data);
                }


                // dd($item_no_fk_arr, $dollar_ind);

                if (isset($dollar_ind)) {
                    for ($i = 0; $i < count($dollar_ind); $i++) {
                        $dollar_item_no[$i] = explode('_', $dollar_ind[$i]);
                        if ($dollar_item_no[$i][0] == 1) {
                            // $req_url = 'https://api.exchangerate.host/latest?base=USD';
                            // $response_json = file_get_contents($req_url);
                            // $response = json_decode($response_json);
                            // $response->rates->BDT
                            DB::table('inv_requisitiondtl_po')->where('inv_requisitiondtl_no_pk', $req_id)->where('item_no_fk', $dollar_item_no[$i][1])->update(['dollar_rate' => isset($request->go_pr) && !empty($request->go_pr) ? '' : $request->dollar_rate[0], 'currency_sign' => 'USD']);
                        } elseif ($dollar_item_no[$i][0] == 2) {
                            // $req_url = 'https://api.exchangerate.host/latest?base=EUR';
                            // $response_json = file_get_contents($req_url);
                            // $response = json_decode($response_json);
                            // $response->rates->BDT
                            DB::table('inv_requisitiondtl_po')->where('inv_requisitiondtl_no_pk', $req_id)->where('item_no_fk', $dollar_item_no[$i][1])->update(['dollar_rate' => isset($request->go_pr) ? '' : $request->dollar_rate[0], 'currency_sign' => 'EUR']);
                        }
                    }
                }

                if (isset($request->go_pr)) {
                    for ($i = 0; $i < count($request->go_pr); $i++) {
                        DB::table("inv_requisitiondtl")
                            ->where('item_no_fk',  $request->input('item_name_' .  $request->go_pr[$i]))
                            ->where('inv_requisition_no_fk', $request->input('inv_requisition_no_pk__' .  $request->go_pr[$i]))
                            ->update([
                                'purchase_req_ind' => 1,
                                'purchase_req_by' => Auth::id(),
                                'purchase_req_at' => date("Y-m-d h:i:s")
                            ]);
                    }
                }
                if (!empty($request->emp_id) && !empty($request->assesment)) {

                    for ($i = 0; $i < count($request->assesment); $i++) {
                        $sequence              = DB::getSequence();
                        $prassignment_no_pk_seq = $sequence->nextValue('prassignment_no_pk_seq');
                        DB::table("inv_prassignment")
                            // ->where('item_no_fk',  $request->assesment[$i])
                            // ->where('inv_requisitiondtl_no_pk',  $req_id)
                            ->insert([
                                'prassignment_no_pk' => $prassignment_no_pk_seq,
                                'inv_requisition_no_fk' => $req_id,
                                'item_no_fk' =>  $request->assesment[$i],
                                'assignment_ind' => 1,
                                'assignment_by' => $request->emp_id,
                                'assignment_at' => date("Y-m-d h:i:s"),
                                'au_entry_by' => $in_au_entry_by,
                                'au_entry_at' =>  date("Y-m-d h:i:s"),
                                'au_entry_session' => 'direct pr',
                                'au_entry_hospital_pk_no' => $in_au_entry_hospital_pk_no,
                            ]);
                    }
                    DB::commit();
                }



                if ($request->approval_id != "") {
                    $approval_level = Session::get('user.approvalmatrix_level_num');
                    $null = '';
                    $au_entry_at = date('Y-m-d');

                    // DB::beginTransaction();
                    DB::table('sysc_approvalprocess')
                        ->where('apprprocess_no_pk', $request->approval_id)
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

                    if ($in_req_saveoption == "POST") {

                        $approvalMst = DB::table('sysc_approvalmatrixmst')->select('dept_base_approval_ind')->where('approval_for_code', 'PR')->first();

                        if (!empty($approvalMst) && $approvalMst->dept_base_approval_ind == 1) {
                            $approval_matrix = DB::table('sysc_approvalmatrix_dept_vw')->select('sysc_approvalmatrix_dept_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PR')->where('dept_su_no_fk', Session::get('user.su_pk_no'))->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_dept_vw.person_no_fk')->get();
                        } else {
                            $approval_matrix = DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*', 'hrms_personnel.email_personal')->where('approval_for_code', 'PR')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'sysc_approvalmatrix_vw.person_no_fk')->get();
                        }


                        // $approval_matrix=DB::table('sysc_approvalmatrix_vw')->select('sysc_approvalmatrix_vw.*','hrms_personnel.email_personal')->where('approval_for_code','PR')->leftJoin('hrms_personnel','hrms_personnel.person_no_pk','=','sysc_approvalmatrix_vw.person_no_fk')->get();
                        if (!empty($approval_matrix) && count($approval_matrix) > 0) {

                            $app_arr = [];
                            foreach ($approval_matrix as $key => $value) {
                                $app_arr[$key] = $value->email_personal;
                            }
                            $this->inventoryMail($app_arr, $req_id, $value->approval_for_code, Auth::user()->user_fullname);
                        }
                    }
                }
            }

            DB::commit();
            $message = ['msg' => 'Data saved successfully.<br><strong>Issue UID = ' . $out_po_uid . '</strong>', 'title' => 'Success'];
            return response()->json($message, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => 'Data saved Faild.' . $th->getMessage(), 'title' => 'Error'];
            return response()->json($message, 500);
        }
    }


    function getExpireDate(Request $request)
    {
        // dd($request->all());
        $requisition_info = DB::table('inv_requisitionlist_vw')->where('inv_requisition_no_pk', $request->requisition_no)->first();

        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $qty = $request->qty; // $request->qty;
            $item_no = $request->item_id;
            $su_unit_no = $requisition_info->to_store_no_fk;
            $entry_session = "session";
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $numelems = 200;
            $outParam = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();

            $itemExpiry = $pdo->prepare("begin pkg_v1_managestock.prc_getstockexpiry(:in_stock_su_no_fk,:in_item_no_fk,:in_sales_qty,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_stockexpiry); end;");

            $itemExpiry->bindParam(':in_stock_su_no_fk', $su_unit_no); // will be adjust later
            $itemExpiry->bindParam(':in_item_no_fk', $item_no);
            $itemExpiry->bindParam(':in_sales_qty', $qty);
            $itemExpiry->bindParam(':in_au_entry_by', $auth_id);
            $itemExpiry->bindParam(':in_au_entry_session', $entry_session);
            $itemExpiry->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $itemExpiry->bindParam(':out_stockexpiry', $outParam, PDO::PARAM_STR, 500);
            // dd($billinvoice);
            $itemExpiry->execute();
            $exp = str_replace('^', ',', $outParam);
            // $exp=explode("|",$res);
            // dd($exp);
            if ($outParam != '') {
                DB::commit();
                $message = $exp;
                // dd($message);

            } else {

                DB::rollback();
                $message = "";
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return json_encode($message);
    }


    public function indent_pr_list()
    {
        $two_days_ago = date("Y-m-d", strtotime("-10 day"));

        $requisition_list = DB::table('inv_requisition_po_itm_vw')
            ->select("inv_requisition_po_no_pk", "from_store", "req_by_name", DB::raw("COUNT(item_no_fk) total_qty"), DB::raw("SUM(req_quantity) total"))
            //->where('inv_requisition_po_date', '>', $two_days_ago)
            ->whereIn('req_po_save_option', ["POST", "DRAFT"])
            ->groupBy("inv_requisition_po_no_pk", "from_store", "req_by_name")
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();
        //dd($requisition_list);
        return  Template::loadView("admin.uhl.inventory.indent-pr-list", [
            'requisition_list' => $requisition_list
        ]);
    }

    public function get_main_store($main_store_id)
    {
        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            // ->where('main_store_ind', '=', 1)
            // ->where('sub_store_ind', '!=', 1)
            ->where('serviceunit_no_pk', $main_store_id)
            ->get();

        return $main_stores_list;
    }

    public function get_sub_store($sub_store_id)
    {
        $main_stores_list = DB::table('sysc_serviceunit')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('main_store_ind', '!=', 1)
            ->where('sub_store_ind', '=', 1)
            ->where('serviceunit_no_pk', $sub_store_id)
            ->get();

        return $main_stores_list;
    }

    public function PRWorklistPrint(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'));
        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }
        if ($request->status == "APPROVED") {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.app_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        } else {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        }

        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();

        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'item_count'                 => $value->item_count,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        // dd($issu_requisition_list);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.uhl.inventory.pr_worklist_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'issu_requisition_list' => $issu_requisition_list])->setPaper('a4', 'potrait');
        return $pdf->stream('PR.pdf');
    }


    public function PRWorklistExcel(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'inv_requisition_po_itm_vw.req_by')
            ->select('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'));
        if (isset($request->status)) {
            if ($request->status == "HOLD") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%HOLD%');
            } elseif ($request->status == "REJECTED") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%REJECTED%');
            } elseif ($request->status == "PENDING") {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%PENDING%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%HOLD%');
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%REJECTED%');
            } else {
                $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
                $query->where($keywords);
            }
        }

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if ($request->status == "APPROVED") {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.app_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.app_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        } else {
            if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
                $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
            } elseif (isset($request->indent_date_from)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_from)));
            } elseif (isset($request->indent_date_to)) {
                $query->where('inv_requisition_po_itm_vw.inv_requisition_po_date', date('Y-m-d', strtotime($request->indent_date_to)));
            }
        }
        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'wsec_user.user_fullname', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();

        if (count($issu_requisition_list_data) > 0) {
            foreach ($issu_requisition_list_data as $value) {
                $pk = $value->inv_requisition_po_no_pk;

                $multiple_remarks = DB::select(DB::raw('select pkg_v1_inventory_all.get_multiindent2pr_remarks(' . $pk . ', ' . $hospital_id . ') as multiple_indent_remarks from dual'));

                $issu_requisition_list[] = array(
                    'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                    'req_at'                     => $value->req_at,
                    'req_po_remarks'             => $value->req_po_remarks,
                    'req_po_save_option'         => $value->req_po_save_option,
                    'approval_status_text'       => $value->approval_status_text,
                    'approval_level_status_text' => $value->approval_level_status_text,
                    'app_status'                 => $value->app_status,
                    'serviceunit_name'           => $value->serviceunit_name,
                    'user_fullname'              => $value->user_fullname,
                    'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                    'item_count'                 => $value->item_count,
                    'multiple_remarks'           => !empty($multiple_remarks) ? $multiple_remarks[0]->multiple_indent_remarks : ''
                    // 'multiple_remarks'         => $multiple_remarks
                );
            }
        } else {
            $issu_requisition_list = [];
        }

        // dd($issu_requisition_list);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'issu_requisition_list' => $issu_requisition_list];
        $fileToExport = "Purchase Requisition";
        $html = View("admin.uhl.inventory.pr_worklist_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function pendingPRItemWorkList(Request $request)
    {
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header')
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $issu_requisition_list = [];
        return Template::loadView("admin.uhl.inventory.pending_pr_item_worklist", [
            'requisition_list' => $issu_requisition_list,
            'main_store_list' => $main_store_list

        ]);
    }


    public function searchPendingPRItemWorkList(Request $request)
    {
        // dd($request->main_store);
        // $items = DB::table('inv_requisition_po_itm_vw')
        // ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
        // ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
        // ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
        // // ->leftjoin('phr_itemreceivemst_pr_cnt', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'phr_itemreceivemst_pr_cnt.inv_requisition_po_no_fk')
        // ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
        // // ->select('item_no_pk', 'pr_uom_tradeprice', 'current_stock', 'item_name', 're_order_level')
        // ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
        // // ->where('supplier_pk_no',  $request->supplier_id)
        // ->whereNull('inv_requisition_po_itm_vw.po_ind')
        // ->where('inv_requisition_po_itm_vw.app_status', 1)
        // ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null)
        // // ->where('inv_requisition_po_no_pk', $id)
        // // ->where('inv_requisition_po_no_pk')
        // // ->where('issue_ind', 1)
        // // ->where('recv_ind','=', null)
        // ->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
        // ->get();
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
            ->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null);

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->requsion_no) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->indent_date_from && $request->indent_date_to) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $items = $query->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
            ->get();

        // dd($items);
        return Template::loadView("admin.uhl.inventory.pending-pr-item-worklist-table", [
            'items' => $items

        ]);
    }

    public function pendingPRItemWorklistPrint(Request $request)
    {
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
            ->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null);

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->requsion_no) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->indent_date_from && $request->indent_date_to) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $items = $query->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
            ->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.uhl.inventory.pending_pr_item_worklist_print", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'items' => $items])->setPaper('a4', 'potrait');
        return $pdf->stream('Pending PR Item.pdf');
    }

    public function pendingPRItemWorklistExcel(Request $request)
    {

        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceitem_inv_vw', 'sysc_serviceitem_inv_vw.item_no_fk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftJoin('inv_requisition_itm_vw', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'inv_requisition_po_itm_vw.requisitiondtl_no_pk_list')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', 'inv_requisition_po_itm_vw.item_no_fk')
            ->leftjoin('PHR_ITEMRECEIVEDTL_PR_CNT', 'inv_requisition_po_itm_vw.INV_REQUISITIONDTL_PO_NO_PK', 'PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK')
            ->select('sysc_serviceitem_inv_vw.*', 'inv_requisition_po_itm_vw.*', 'inv_requisition_po_itm_vw.item_no_fk as req_item_no_fk', 'inv_requisition_itm_vw.req_by_name as indent_req_by_name', 'inv_requisition_itm_vw.from_store as indent_from_store', 'inv_requisition_itm_vw.inv_requisitiondtl_no_pk', 'sysc_serviceitem.purchasevat_pct as vat_percent', 'inv_requisition_po_itm_vw.dollar_rate', 'inv_requisition_po_itm_vw.currency_sign', 'inv_requisition_po_itm_vw.pr_doc_attachment_path', 'inv_requisition_itm_vw.inv_requisition_no_pk')
            ->whereNull('inv_requisition_po_itm_vw.po_ind')
            ->where('inv_requisition_po_itm_vw.app_status', 1)
            ->where('PHR_ITEMRECEIVEDTL_PR_CNT.INV_REQUISITIONDTL_PO_NO_FK', null);

        if (isset($request->main_store)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store);
        }

        if (isset($request->requsion_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->requsion_no) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->requsion_no);
        }

        if (isset($request->main_store) && $request->indent_date_from && $request->indent_date_to) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->main_store)
                ->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        }

        if (isset($request->indent_date_from) &&  isset($request->indent_date_to)) {
            $query->whereBetween('inv_requisition_po_itm_vw.req_at', [date('Y-m-d', strtotime($request->indent_date_from)), date('Y-m-d', strtotime($request->indent_date_to))]);
        } elseif (isset($request->indent_date_from)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_from)));
        } elseif (isset($request->indent_date_to)) {
            $query->where('inv_requisition_po_itm_vw.req_at', date('Y-m-d', strtotime($request->indent_date_to)));
        }
        $items = $query->orderBy('inv_requisition_po_itm_vw.inv_requisitiondtl_no_pk', 'desc')
            ->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf =  ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'items' => $items];
        $fileToExport = "Pending PR Item";
        $html = View("admin.uhl.inventory.pending_pr_item_worklist_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function prAssign()
    {


        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header')
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadView("admin.uhl.inventory.pr_assign_v2", [
            'main_store_list' => $main_store_list
        ]);
    }


    public function searchPRList(Request $request)
    {
        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('inv_prassigndtl', function ($q) {
                $q->on('inv_prassigndtl.inv_requisition_po_no_fk', '=', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk');
                $q->on('inv_prassigndtl.inv_requisitiondtl_po_no_fk', '=', 'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk');
                $q->where('inv_prassigndtl.inv_requisitiondtl_po_no_fk', null);
                $q->orWhere('inv_prassigndtl.revoked_ind', 1);
            })

            ->select(
                'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
                'inv_requisition_po_itm_vw.req_at',
                'inv_requisition_po_itm_vw.req_po_remarks',
                'inv_requisition_po_itm_vw.req_po_save_option',
                'inv_requisition_po_itm_vw.approval_status_text',
                'inv_requisition_po_itm_vw.approval_level_status_text',
                'inv_requisition_po_itm_vw.app_status',
                'sysc_serviceunit.serviceunit_name',
                DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'),

            );


        $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
        $query->whereNull('inv_requisition_po_itm_vw.po_ind');
        $query->whereRaw("(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) != (select count(*) from PR_ASSIGN_VW where inv_requisition_po_itm_vw.inv_requisition_po_no_pk = pr_assign_vw.inv_requisition_po_no_fk and pr_assign_vw.revoked_ind = 0)");
        $query->where($keywords);



        if (isset($request->department)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->department);
        }
        if (isset($request->pr_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->pr_no);
        }
        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $issu_requisition_list_data = $query->groupBy(
            'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
            'inv_requisition_po_itm_vw.req_at',
            'inv_requisition_po_itm_vw.req_po_remarks',
            'inv_requisition_po_itm_vw.req_po_save_option',
            'sysc_serviceunit.serviceunit_name',
            'inv_requisition_po_itm_vw.approval_status_text',
            'inv_requisition_po_itm_vw.approval_level_status_text',
            'inv_requisition_po_itm_vw.app_status',
        )
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();


        $assigned_data = $this->assigned_pr_data($from_date, $to_date, $request->department, $request->pr_no, $request->emp_name_search, $request->emp_id_search);


        return response()->json(['success' => true, 'not_assigned_data' => $issu_requisition_list_data, 'assigned_data' => $assigned_data], 200);
    }

    public function assigned_pr_data($from_date, $to_date, $department, $pr_no, $emp_name = null, $emp_id = null)
    {




        $query = DB::table('pr_assign_vw')

            ->select(
                'inv_requisition_po_no_fk',
                'inv_requisition_po_date',
                'assign_at',
                'assign_by',
                'emp_name',
                'department_name'
            );

        if (Session::get('user.ses_hospital_code') != 'DMHL') {
            $query->whereNull('pr_assign_vw.po_ind');
        }
        if (isset($department)) {
            $query->where('main_store_su_no_fk', $department);
        }
        if (!empty($emp_id) && !empty($emp_name)) {
            $query->where('assign_by', $emp_id);
        }
        if (isset($pr_no)) {
            $query->where('inv_requisition_po_no_fk', $pr_no);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $issu_requisition_list_data = $query->groupBy('inv_requisition_po_no_fk', 'inv_requisition_po_date', 'assign_at', 'assign_by', 'emp_name', 'department_name')
            // ->orderBy('assign_at', 'desc')
            ->orderBy('inv_requisition_po_no_fk', 'desc')
            ->get();


        return $issu_requisition_list_data;
    }


    public function showPRStatus(Request $request)
    {

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $query = DB::table('PR_ASSIGN_VW')->select('*');

        if (isset($request->department)) {
            $query->where('main_store_su_no_fk', $request->department);
        }
        if (!empty($request->emp_id_search) && !empty($request->emp_name_search)) {
            $query->where('assign_by', $request->emp_id_search);
        }

        if (isset($request->pr_no)) {
            $query->where('inv_requisition_po_no_fk', $request->pr_no);
        }
        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }
        $data = $query
            // ->orderBy('assign_at', 'desc')
            ->orderBy('inv_requisition_po_no_fk', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function assignPR(Request $request)
    {
        $request->validate([
            'emp_id' => 'required',
            'emp_name' => 'required'
        ]);
        try {
            if (count($request->assigned) == 0) {
                return response()->json(['success' => false, 'message' => 'Please Select at least one PR', 'title' => 'Failed'], 422);
            }

            $au_entry_at = Carbon::now();
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            DB::beginTransaction();
            $sequence = DB::getSequence();
            $pr_assign_master = $sequence->nextValue('prassignmst_no_pk_seq');
            $data = [
                'prassignmst_no_pk' => $pr_assign_master,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'assign_by' => $request->emp_id,
                'assign_at' => $au_entry_at,
            ];

            DB::table('inv_prassignmst')->insert($data);
            $last_id = DB::table('inv_prassignmst')->orderByDesc('prassignmst_no_pk')->value('prassignmst_no_pk');

            foreach ($request->assigned as $key => $value) {

                $items = DB::table('inv_requisition_po_itm_vw')
                    ->leftJoin('inv_prassigndtl', function ($q) {
                        $q->on("inv_prassigndtl.inv_requisitiondtl_po_no_fk", "=", "inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk");
                        $q->where('inv_prassigndtl.revoked_ind', 0);
                    })
                    ->whereNull('inv_prassigndtl.inv_requisitiondtl_po_no_fk')
                    ->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $value)
                    ->select('inv_requisition_po_itm_vw.item_no_fk', 'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk')
                    ->get();


                foreach ($items  as $key => $item) {
                    $child_seq = $sequence->nextValue('prassignment_no_pk_seq');
                    $child = [
                        'prassigndtl_no_pk' => $child_seq,
                        'prassignmst_no_fk' => $last_id,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'item_no_fk' => $item->item_no_fk,
                        'inv_requisitiondtl_po_no_fk' => $item->inv_requisitiondtl_po_no_pk,
                        'revoked_ind' => 0,
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,
                        'inv_requisition_po_no_fk' => $value,
                        'status' => 1
                    ];

                    DB::table('inv_prassigndtl')->insert($child);
                }
            }
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'], 422);
        }
    }

    public function assignedPRPDF($id)
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $my_requsition = DB::table('inv_prassign_vw')
            ->select('prassignmst_no_pk', 'assign_by', 'assign_at', 'remarks', 'inv_requisition_po_no_fk', 'inv_requisition_po_date', 'main_store_su_no_fk', 'department')
            ->where('prassignmst_no_pk', $id)
            ->first();

        $my_requsition_items = DB::table('pr_assign_vw')
            ->leftJoin('inv_requisitionmst_po', 'inv_requisitionmst_po.inv_requisition_po_no_pk', '=', 'pr_assign_vw.inv_requisition_po_no_fk')
            ->select(
                'pr_assign_vw.prassigndtl_no_pk',
                'pr_assign_vw.prassignmst_no_fk',
                'pr_assign_vw.inv_requisition_po_no_fk',
                'pr_assign_vw.item_name',
                'pr_assign_vw.item_no_fk',
                'inv_requisitionmst_po.inv_requisition_po_date',
                'inv_requisitionmst_po.req_po_remarks'
            )
            ->where('pr_assign_vw.prassignmst_no_fk', $id)
            ->where('pr_assign_vw.revoked_ind', 0)
            ->get();

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
        $pdf = PDF::loadView("admin.uhl.inventory.export.pr_assigned_report", [
            'po_hospital_details' => $po_hospital_details,
            'userInfo' => $userInfo,
            'my_requsition' => $my_requsition,
            'my_requsition_items' => $my_requsition_items,
            'invoice_barcode' => $invoice_barcode,
        ]);
        return $pdf->stream("pr_assigned.pdf");
    }


    public function prAssignedList()
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $main_store_list = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header')
            ->where('main_store_ind', '=', 1)
            ->where('sub_store_ind', '!=', 1)
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadView("admin.uhl.inventory.pr_assigned_list", [
            'main_store_list' => $main_store_list

        ]);
    }



    public function user_wise_assigned_pr_data($from_date, $to_date, $department, $pr_no, $person_id)
    {

        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('INV_PRASSIGN_VW', 'INV_PRASSIGN_VW.inv_requisition_po_no_fk', '=', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk')
            ->select('INV_PRASSIGN_VW.inv_requisition_po_no_fk', 'INV_PRASSIGN_VW.prassignmst_no_pk', 'INV_PRASSIGN_VW.assign_by', 'INV_PRASSIGN_VW.assign_at', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'sysc_serviceunit.serviceunit_name', 'inv_requisition_po_itm_vw.pr_doc_attachment_path')
            ->whereNotNull('INV_PRASSIGN_VW.inv_requisition_po_no_fk');
        $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
        $query->where('INV_PRASSIGN_VW.ASSIGN_BY_NO', $person_id);
        $query->whereNull('inv_requisition_po_itm_vw.po_ind');

        $query->where($keywords);


        if (isset($department)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $department);
        }

        if (isset($pr_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $pr_no);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween(DB::raw("TRUNC(INV_PRASSIGN_VW.assign_at)"), [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $issu_requisition_list_data = $query->groupBy('INV_PRASSIGN_VW.inv_requisition_po_no_fk', 'INV_PRASSIGN_VW.prassignmst_no_pk', 'inv_prassign_vw.assign_by', 'inv_prassign_vw.assign_at', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk', 'inv_requisition_po_itm_vw.req_at', 'inv_requisition_po_itm_vw.req_po_remarks', 'inv_requisition_po_itm_vw.req_po_save_option', 'sysc_serviceunit.serviceunit_name', 'inv_requisition_po_itm_vw.approval_status_text', 'inv_requisition_po_itm_vw.approval_level_status_text', 'inv_requisition_po_itm_vw.app_status', 'inv_requisition_po_itm_vw.pr_doc_attachment_path')
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();

        $issu_requisition_list = [];
        foreach ($issu_requisition_list_data as $value) {
            if (DB::table('INV_PRASSIGNDTL')->where('PRASSIGNMST_NO_FK', $value->prassignmst_no_pk)->where('REVOKED_IND', 1)->count() ==  DB::table('INV_PRASSIGNDTL')->where('PRASSIGNMST_NO_FK', $value->prassignmst_no_pk)->count()) {
                continue;
            }

            $issu_requisition_list[] = array(
                'inv_requisition_po_no_pk'   => $value->inv_requisition_po_no_pk,
                'req_at'                     => $value->req_at,
                'req_po_remarks'             => $value->req_po_remarks,
                'req_po_save_option'         => $value->req_po_save_option,
                'approval_status_text'       => $value->approval_status_text,
                'approval_level_status_text' => $value->approval_level_status_text,
                'app_status'                 => $value->app_status,
                'serviceunit_name'           => $value->serviceunit_name,
                'pr_doc_attachment_path'     => $value->pr_doc_attachment_path,
                'prassignmst_no_pk'          => $value->prassignmst_no_pk,
                'assign_by'          => $value->assign_by,
                'assign_at'          => $value->assign_at,
            );
        }

        return $issu_requisition_list;
    }


    public function searchAssignedPRList(Request $request)
    {

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }
        $person_id = Session::get('user.ses_person_no_fk');
        $assigned_data = $this->user_wise_assigned_pr_data($from_date, $to_date, $request->department, $request->pr_no, $person_id);


        return response()->json(['success' => true, 'data' => $assigned_data], 200);
    }

    public function prAssignPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();

        $hospital_id =  Session::get('user.ses_hospital_no_pk');

        $keys = ['PENDING', 'HOLD', 'REJECTED'];
        $keywords = [];
        foreach ($keys as $key) {
            $keywords[] = ['inv_requisition_po_itm_vw.approval_status_text', 'NOT LIKE', '%' . $key . '%'];
        }

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('inv_requisition_po_itm_vw')
            ->leftJoin('sysc_serviceunit', 'sysc_serviceunit.serviceunit_no_pk', '=', 'inv_requisition_po_itm_vw.main_store_su_no_fk')
            ->leftJoin('inv_prassigndtl', function ($q) {
                $q->on('inv_prassigndtl.inv_requisition_po_no_fk', '=', 'inv_requisition_po_itm_vw.inv_requisition_po_no_pk');
                $q->on('inv_prassigndtl.inv_requisitiondtl_po_no_fk', '=', 'inv_requisition_po_itm_vw.inv_requisitiondtl_po_no_pk');
                $q->where('inv_prassigndtl.inv_requisitiondtl_po_no_fk', null);
                $q->orWhere('inv_prassigndtl.revoked_ind', 1);
            })

            ->select(
                'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
                'inv_requisition_po_itm_vw.req_at',
                'inv_requisition_po_itm_vw.req_po_remarks',
                'inv_requisition_po_itm_vw.req_po_save_option',
                'inv_requisition_po_itm_vw.approval_status_text',
                'inv_requisition_po_itm_vw.approval_level_status_text',
                'inv_requisition_po_itm_vw.app_status',
                'sysc_serviceunit.serviceunit_name',
                DB::raw('(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) as item_count'),

            );


        $query->where('inv_requisition_po_itm_vw.approval_status_text', 'LIKE', '%APPROVED%');
        $query->whereNull('inv_requisition_po_itm_vw.po_ind');
        $query->whereRaw("(SELECT COUNT(*) FROM inv_requisitiondtl_po WHERE inv_requisitiondtl_po.inv_requisitiondtl_no_pk = inv_requisition_po_itm_vw.inv_requisition_po_no_pk) != (select count(*) from PR_ASSIGN_VW where inv_requisition_po_itm_vw.inv_requisition_po_no_pk = pr_assign_vw.inv_requisition_po_no_fk and pr_assign_vw.revoked_ind = 0)");
        $query->where($keywords);



        if (isset($request->department)) {
            $query->where('inv_requisition_po_itm_vw.main_store_su_no_fk', $request->department);
        }
        if (isset($request->pr_no)) {
            $query->where('inv_requisition_po_itm_vw.inv_requisition_po_no_pk', $request->pr_no);
        }
        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_itm_vw.inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $issu_requisition_list_data = $query->groupBy(
            'inv_requisition_po_itm_vw.inv_requisition_po_no_pk',
            'inv_requisition_po_itm_vw.req_at',
            'inv_requisition_po_itm_vw.req_po_remarks',
            'inv_requisition_po_itm_vw.req_po_save_option',
            'sysc_serviceunit.serviceunit_name',
            'inv_requisition_po_itm_vw.approval_status_text',
            'inv_requisition_po_itm_vw.approval_level_status_text',
            'inv_requisition_po_itm_vw.app_status',
        )
            ->orderBy('inv_requisition_po_no_pk', 'desc')
            ->get();


        $assigned_data = $this->assigned_pr_data($from_date, $to_date, $request->department, $request->pr_no, $request->emp_name_search, $request->emp_id_search);

        if ($request->report_type == 'PDF') {
            $pdf = PDF::loadView("admin.uhl.inventory.pr_assign_pdf", ['from_date' => $from_date, 'to_date' => $to_date, 'success' => true, 'not_assigned_data' => $issu_requisition_list_data, 'assigned_data' => $assigned_data])->setPaper('a4', 'landscape');
            return $pdf->stream("assign_list.pdf", array("Attachment" => false));
        } else {
            $pdf = ['from_date' => $from_date, 'to_date' => $to_date, 'success' => true, 'not_assigned_data' => $issu_requisition_list_data, 'assigned_data' => $assigned_data];

            $fileToExport = "assign_listt Excel";
            $html = View("admin.uhl.inventory.pr_assign_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: text/csv");
            return $html;
        }
    }

    public function  partialAssignPR($pr_id)
    {
        $available_item = DB::table('inv_requisition_po_itm_vw as req')
            ->where('req.inv_requisition_po_no_pk', $pr_id)
            ->select('req.item_no_fk', 'req.item_name', 'req.item_code', 'req.inv_requisitiondtl_po_no_pk', 'req.sales_uom', 'req.req_quantity')
            ->get();
        $available_item_new = [];
        foreach ($available_item as $item) {
            $exist = DB::table('pr_assign_vw')
                ->where('item_no_fk', $item->item_no_fk)
                ->where('inv_requisitiondtl_po_no_fk', $item->inv_requisitiondtl_po_no_pk)
                ->where('revoked_ind', 0)
                ->exists();

            if (!$exist) {
                array_push($available_item_new, $item);
            }
        }

        $available_item = $available_item_new;
        return Template::loadview("admin.uhl.inventory.modal.partial_pr_assign", compact('pr_id', 'available_item'));
    }

    public function assignPartialPR(Request $request)
    {
        $request->validate([
            'emp_id_modal' => 'required',
            'emp_name_modal' => 'required',
            'inv_requisition_po_no_fk' => 'required',
        ]);
        try {
            if (count($request->inv_requisitiondtl_po_no_pk) == 0) {
                return response()->json(['success' => false, 'message' => 'Please Select at least one Item', 'title' => 'Failed'], 422);
            }

            $au_entry_at = Carbon::now();
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            DB::beginTransaction();
            $sequence = DB::getSequence();
            $pr_assign_master = $sequence->nextValue('prassignmst_no_pk_seq');
            $data = [
                'prassignmst_no_pk' => $pr_assign_master,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'assign_by' => $request->emp_id_modal,
                'assign_at' => $au_entry_at,
            ];

            DB::table('inv_prassignmst')->insert($data);

            $inv_requisition_po_no_fk = $request->inv_requisition_po_no_fk;
            foreach ($request->inv_requisitiondtl_po_no_pk as $key => $value) {

                $item_no_fk = DB::table('inv_requisition_po_itm_vw')->where('inv_requisitiondtl_po_no_pk', $value)->value('item_no_fk');

                $child_seq = $sequence->nextValue('prassignment_no_pk_seq');
                $child = [
                    'prassigndtl_no_pk' => $child_seq,
                    'prassignmst_no_fk' => $pr_assign_master,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'inv_requisition_po_no_fk' => $inv_requisition_po_no_fk,
                    'item_no_fk' => $item_no_fk,
                    'inv_requisitiondtl_po_no_fk' => $value,
                    'revoked_ind' => 0,
                    'status' => 1
                ];
                DB::table('inv_prassigndtl')->insert($child);
            }
            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Successfully Saved', 'title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $th->getMessage(), 'title' => 'Failed'], 422);
        }
    }

    public function  revokeAssignPR($prassignmst_no_pk)
    {
        $available_item = DB::table('pr_assign_vw')
            ->where('prassignmst_no_pk', $prassignmst_no_pk)
            ->whereNull('po_ind')
            ->where('revoked_ind', 0)
            ->select('item_no_fk', 'item_name', 'inv_requisition_po_no_fk', 'revoked_ind', 'item_no_fk', 'assign_by', 'prassigndtl_no_pk')
            ->get();
        return Template::loadview("admin.uhl.inventory.modal.revoked_pr_assign", compact('prassignmst_no_pk', 'available_item'));
    }

    public function revokedPartialPR(Request $request)
    {

        $request->validate([
            'prassignmst_no_pk' => 'required'
        ]);
        try {
            if (count($request->prassigndtl_no_pk) == 0) {
                return response()->json(['success' => false, 'message' => 'Please Select at least one Item', 'title' => 'Failed'], 422);
            }

            $au_entry_at = Carbon::now();
            $au_entry_at = new DateTime('now');

            DB::beginTransaction();
            $prassignmst_no_pk = $request->prassignmst_no_pk;
            foreach ($request->prassigndtl_no_pk as $key => $value) {
                $data = [
                    'revoked_ind' => 1,
                    'REVOKED_BY' => Auth::id(),
                    'REVOKED_AT' => $au_entry_at,
                ];
                DB::table('inv_prassigndtl')->where('prassignmst_no_fk', $prassignmst_no_pk)->where('prassigndtl_no_pk', $value)->update($data);
            }
            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Successfully Revoked', 'title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $th->getMessage(), 'title' => 'Failed'], 422);
        }
    }


    public function  partialPRStatus($inv_requisition_po_no_fk)
    {
        $available_item = DB::table('pr_assign_vw')
            ->where('inv_requisition_po_no_fk', $inv_requisition_po_no_fk)
            ->select('item_no_fk', 'item_name', 'inv_requisition_po_no_fk', 'emp_name', 'revoked_ind', 'item_no_fk', 'assign_by', 'po_ind', 'prassignmst_no_pk', 'assign_at')
            ->orderBy('assign_at', 'desc')
            ->orderBy('inv_requisition_po_no_fk', 'desc')
            ->get();
        return Template::loadview("admin.uhl.inventory.modal.pr_assign_status", compact('inv_requisition_po_no_fk', 'available_item'));
    }



    public function downloadPRStatusExcelV2(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('max_execution_time', 0);

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $query = DB::table('PR_ASSIGN_VW')->select('*');

        if (isset($request->department)) {
            $query->where('main_store_su_no_fk', $request->department);
        }
        if (!empty($request->emp_id_search) && !empty($request->emp_name_search)) {
            $query->where('assign_by', $request->emp_id_search);
        }

        if (isset($request->pr_no)) {
            $query->where('inv_requisition_po_no_fk', $request->pr_no);
        }
        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $data = $query
            // ->orderBy('assign_at', 'desc')
            ->orderBy('inv_requisition_po_no_fk', 'desc')
            ->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $userInfo = Auth::user();

        $html = view("admin.uhl.inventory.export.pr_assign_status_excel", compact('data', 'from_date', 'to_date', 'po_hospital_details', 'userInfo'));
        $fileToExport = 'assigned_status.xls';
        $response = new Response($html);
        $response->header('Content-Type', 'application/vnd.ms-excel');
        $response->header('Content-Disposition', 'attachment; filename="' . $fileToExport . '"');
        return $response;
    }

    public function downloadPRStatusPdfV2(Request $request)
    {
        ini_set('max_execution_time', 0);

        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $query = DB::table('PR_ASSIGN_VW')->select('*');

        if (isset($request->department)) {
            $query->where('main_store_su_no_fk', $request->department);
        }
        if (!empty($request->emp_id_search) && !empty($request->emp_name_search)) {
            $query->where('assign_by', $request->emp_id_search);
        }

        if (isset($request->pr_no)) {
            $query->where('inv_requisition_po_no_fk', $request->pr_no);
        }
        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween('inv_requisition_po_date', [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        $data = $query
            // ->orderBy('assign_at', 'desc')
            ->orderBy('inv_requisition_po_no_fk', 'desc')
            ->get();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $userInfo = Auth::user();
        $pdf = PDF::loadView("admin.uhl.inventory.export.pr_assign_status_pdf", compact('data', 'from_date', 'to_date', 'po_hospital_details', 'userInfo'))->setPaper('a4', 'landscape');
        return $pdf->download('assigned_status.pdf');
    }


    // slow moving not moving
    public function slowMovingNotMoving()
    {
        return Template::loadView("admin.uhl.inventory.slow_moving_not_moving", [
            'store' => DB::table('sysc_v1_grant_servieceunit_vw')
                ->select('serviceunit_name', 'serviceunit_no_pk')
                ->where('user_no_pk', Auth::id())
                ->where(function ($query) {
                    $query->where('main_store_ind', 1);
                })->get(),
        ]);
    }

    public function searchslowMovingNotMoving(Request $request)
    {
        // dd($request->all());
        $reptype = $request->reptype;
        $store_name = $request->store_name;
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($store_name != "") ? " $clause mainstore_su_no_fk = $store_name" : "";


        $sql_cond1 = "";
        $clause = ($sql_cond1 == "") ? " where" : " and";
        $sql_cond1 .= ($date_from != "") ? " $clause trunc(stk1.au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $report_data = DB::select("
SELECT *
FROM (  SELECT item_no_fk,
               GEN.GENERIC_NAME,
               item.item_name,
               subcat.item_type_name sub_catagory,
               cat.item_type_name catagory,
               supplier_name,
               sales_price,
               purchase_price,
               fnc_serviceunitname (mainstore_su_no_fk) store,
               (SELECT SUM (stock_trans_qty)
                  FROM inv_itemstocktranschd cstk
                 WHERE item_no_fk = stk.item_no_fk and cstk.STOCK_SU_NO_FK = mainstore_su_no_fk and tRUNC  ( cstk.au_entry_at)<= TO_DATE('$date_to','DD/MM/YYYY'))
                  curr_stk
          FROM inv_itemstocktranschd stk,
               sysc_serviceitem item,
               inv_supplier supp,
               sysc_itemtype subcat,
               sysc_itemtype cat,
               SYSC_GENERIC gen
         WHERE     item.item_no_pk = stk.item_no_fk
               AND item.supplier_pk_no = supp.supplier_no_pk(+)
               AND subcat.itemtype_no_pk = item.itemtype_no_fk
               AND ITEM.GENERIC_NO_FK = GEN.GENERIC_NO_PK(+)
               AND subcat.par_itemtype_no_fk = cat.itemtype_no_pk(+)
               AND item_no_fk NOT IN
                      (SELECT item_no_fk
                         FROM inv_itemstocktranschd stk1
                        $sql_cond1
                              AND stock_trans_qty < 0 ) $sql_cond and trunc(ITEM.AU_ENTRY_AT ) < TO_DATE ('$date_from','DD/MM/YYYY')
      GROUP BY item_no_fk,
               gen.GENERIC_NAME,
               item.item_name,
               supplier_name,
               subcat.item_type_name,
               cat.item_type_name,
               mainstore_su_no_fk,
               sales_price,
               purchase_price) where curr_stk > 0
ORDER BY 2
");
        // }

        return Template::loadView("admin.uhl.inventory.slow_moving_not_moving_list", ['report_data' => $report_data, 'reptype' => $reptype]);
    }



    public function slowMovingNotMovingPrint(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // dd($request->all());
        $reptype = $request->reptype;
        $store_name = $request->store_name;
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($store_name != "") ? " $clause mainstore_su_no_fk = $store_name" : "";


        $sql_cond1 = "";
        $clause = ($sql_cond1 == "") ? " where" : " and";
        $sql_cond1 .= ($date_from != "") ? " $clause trunc(stk1.au_entry_at) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        $report_data = DB::select("
SELECT *
FROM (  SELECT item_no_fk,
               GEN.GENERIC_NAME,
               item.item_name,
               subcat.item_type_name sub_catagory,
               cat.item_type_name catagory,
               supplier_name,
               sales_price,
               purchase_price,
               fnc_serviceunitname (mainstore_su_no_fk) store,
               (SELECT SUM (stock_trans_qty)
                  FROM inv_itemstocktranschd cstk
                 WHERE item_no_fk = stk.item_no_fk and cstk.STOCK_SU_NO_FK = mainstore_su_no_fk and tRUNC  ( cstk.au_entry_at)<= TO_DATE('$date_to','DD/MM/YYYY'))
                  curr_stk
          FROM inv_itemstocktranschd stk,
               sysc_serviceitem item,
               inv_supplier supp,
               sysc_itemtype subcat,
               sysc_itemtype cat,
               SYSC_GENERIC gen
         WHERE     item.item_no_pk = stk.item_no_fk
                AND item.supplier_pk_no = supp.supplier_no_pk(+)
               AND subcat.itemtype_no_pk = item.itemtype_no_fk
               AND ITEM.GENERIC_NO_FK = GEN.GENERIC_NO_PK(+)
               AND subcat.par_itemtype_no_fk = cat.itemtype_no_pk(+)
               AND item_no_fk NOT IN
                      (SELECT item_no_fk
                         FROM inv_itemstocktranschd stk1
                        $sql_cond1
                              AND stock_trans_qty < 0 ) $sql_cond and trunc(ITEM.AU_ENTRY_AT ) < TO_DATE ('$date_from','DD/MM/YYYY')
      GROUP BY item_no_fk,
               gen.GENERIC_NAME,
               item.item_name,
               supplier_name,
               subcat.item_type_name,
               cat.item_type_name,
               mainstore_su_no_fk,
               sales_price,
               purchase_price) where curr_stk > 0
ORDER BY 2
");
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();




        if ($request->print_type == 'PDF') {

            return view("admin.uhl.inventory.slow_moving_not_moving_print", [
                'report_data' => $report_data,
                'barcode_no' => $barcode_no,
                'store_name_txt' => '',
                'po_hospital_details' => $po_hospital_details,
                'reptype' => $reptype
            ]);
        }
        if ($request->print_type == 'EXCEL') {
            $pdf = [
                'report_data' => $report_data,
                'barcode_no' => $barcode_no,
                'store_name_txt' => '',
                'po_hospital_details' => $po_hospital_details,
                'reptype' => $reptype
            ];
            $fileToExport = "non_moving_report";
            $html = View("admin.uhl.inventory.slow_moving_not_moving_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }







    // Department Wise Indent Worklist
    public function department_wise_indent_receive_worklist()
    {
        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        return Template::loadView("admin.uhl.inventory.indent_receive.department-wise-indent-receive", [
            'grant_su' => $grant_su
        ]);
    }

    public function department_wise_indent(Request $request)
    {
        $from_date = "";
        $to_date = "";
        if (isset($request->from_date)) {
            if (!empty($request->from_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->from_date);
                $from_date = $dateTime->format('Y-m-d');
            }
        }

        if (isset($request->to_date)) {
            if (!empty($request->to_date)) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $request->to_date);
                $to_date = $dateTime->format('Y-m-d');
            }
        }

        $indent_no = $request->indent_no;

        $grant_su = DB::table('sysc_v1_grant_servieceunit_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->pluck('serviceunit_no_pk');


        $receive_indent = $this->getReceiveIndent($from_date, $to_date, $indent_no, $request->department, $grant_su);
        $received_indent = $this->getReceivedIndent($from_date, $to_date, $indent_no, $request->department, $grant_su);

        return response()->json(['success' => true, 'receive_indent' => $receive_indent, 'received_indent' => $received_indent], 200);
    }

    public function getReceiveIndent($from_date, $to_date, $indent_no,  $department, $grant_su)
    {
        $query = DB::table('inv_requisitionlist_vw')
            ->select(
                'inv_requisition_no_pk',
                'inv_requisition_uid',
                'inv_requisition_date',
                'req_at',
                'to_store_no_fk',
                'to_store',
                'from_store_no_fk',
                'from_stor',
                'req_type',
                'req_type_by',
                'ref_indent_no_fk',
                'indent_remarks',
                'au_entry_by',
                'user_name',
                'au_entry_session',
                'au_entry_hospital_pk_no',
                'indent_save_option',
                'approval_status_text',
                'approval_level_status_text'
            );

        $query->where('indent_save_option', '=', 'POST');
        $query->where('recv_ind', '=', NULL);
        $query->where('issue_ind', '=', 1);
        // $query->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));

        if (!empty($indent_no)) {
            $query->where('inv_requisition_no_pk', '=', $indent_no);
        }

        if (isset($department) && !empty($department)) {
            $query->where('from_store_no_fk', '=', $department);
        } else {
            $query->whereIn('from_store_no_fk', $grant_su);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween(DB::raw("TRUNC(inv_requisition_date)"), [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        return $query->orderBy('inv_requisition_no_pk', 'desc')->get();
    }

    public function getReceivedIndent($from_date, $to_date, $indent_no, $department, $grant_su)
    {
        $query = DB::table('inv_requisitionlist_vw')
            ->select(
                'inv_requisition_no_pk',
                'inv_requisition_uid',
                'inv_requisition_date',
                'req_at',
                'to_store_no_fk',
                'to_store',
                'from_store_no_fk',
                'from_stor',
                'req_type',
                'req_type_by',
                'ref_indent_no_fk',
                'indent_remarks',
                'au_entry_by',
                'user_name',
                'au_entry_session',
                'au_entry_hospital_pk_no',
                'indent_save_option',
                'approval_status_text',
                'approval_level_status_text',
                'recv_by_name',
                'recv_at'
            );

        $query->where('indent_save_option', '=', 'POST');
        $query->where('recv_ind', '=', 1);
        $query->where('issue_ind', '=', 1);
        // $query->where('au_entry_by', '=', Session::get('user.ses_user_pk_no'));

        if (!empty($indent_no)) {
            $query->where('inv_requisition_no_pk', '=', $indent_no);
        }

        if (isset($department) && !empty($department)) {
            $query->where('from_store_no_fk', '=', $department);
        } else {
            $query->whereIn('from_store_no_fk', $grant_su);
        }

        if (!empty($from_date) &&  !empty($to_date)) {
            $query->whereBetween(DB::raw("TRUNC(inv_requisition_date)"), [date('Y-m-d', strtotime($from_date)), date('Y-m-d', strtotime($to_date))]);
        }

        return $query->orderBy('inv_requisition_no_pk', 'desc')->get();
    }
}
