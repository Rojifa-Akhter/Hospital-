<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\ServiceUnit;
use App\Models\Designation;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class LeaveEntryListController extends Controller
{
    public function index()
    {
        $dep = DB::table('sysc_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status',1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        //  dd($dep);
        return template::loadview('admin.settings.leave_list.index', compact('dep'));
    }
    public function indexDep()
    {
        $dep = DB::table('sysc_grant_servieceunit_vw')
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status',1)
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        //  dd($dep);
        return template::loadview('admin.settings.leave_list.index_dep', compact('dep'));
    }
    public function indexHr()
    {
        $hrDat = DB::table('sysc_grant_servieceunit_vw')
            ->select('serviceunit_name', 'serviceunit_no_pk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status',1)
            ->orderBy('serviceunit_name', 'asc')
            ->get();
        //  dd($dep);
        return template::loadview('admin.settings.leave_list.index_hr', compact('hrDat'));
    }

    public function currentLeaveList(Request $request)
    {
        $current_date = date('Y-m-d');

        $sql_cond = "";
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= $current_date != "" ? " $clause trunc(au_entry_at) ='$current_date'" : "";

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        $table = 'hrms_leave_entry_vw';
        $primaryKey = 'leave_no_pk';
        $columns = array(
            array('db' => 'leave_no_pk', 'dt' => 0),
            array('db' => 'full_name', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'designation_name', 'dt' => 3),
            array('db' => 'leave_reason', 'dt' => 4),
            array('db' => 'from_date', 'dt' => 5),
            array('db' => 'to_dates', 'dt' => 6),
            array('db' => 'su_name', 'dt' => 7),
            array('db' => 'total_leave', 'dt' => 8),
            array('db' => 'assignto_name', 'dt' => 9),
            // array('db' => 'leave_no_pk', 'dt' => 10),
            array('db' => 'approved_dept_ind', 'dt' => 10),
            array('db' => 'approved_hr_ind', 'dt' => 11),
            array('db' => 'leave_for_extra_duty', 'dt' => 12),
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function currentLeaveListDep(Request $request)
    {
        //dd('tst');
        $current_date = date('Y-m-d');
        //    $hospitalPk= Session::get('user.su_pk_no');
        $dep = DB::table('sysc_grant_servieceunit_vw')
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('serviceunit_no_pk')
            ->get();

        $su_no = [];

        if (!$dep->isEmpty()) {
            $department_filter = $dep;
            foreach ($department_filter as  $value) {
                if ($value->serviceunit_no_pk != null) {
                    array_push($su_no, $value->serviceunit_no_pk);
                }
            }
        }

        $sql_cond = "";
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= $current_date != "" ? " $clause trunc(au_entry_at) ='$current_date'" : "";
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= !empty($su_no) ? " $clause serviceunit_no_fk in(" . implode(",", $su_no) . ")" : "";

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        $table = 'hrms_leave_entry_vw';
        $primaryKey = 'leave_no_pk';
        $columns = array(
            array('db' => 'leave_no_pk', 'dt' => 0),
            array('db' => 'full_name', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'designation_name', 'dt' => 3),
            array('db' => 'leave_reason', 'dt' => 4),
            array('db' => 'from_date', 'dt' => 5),
            array('db' => 'to_dates', 'dt' => 6),
            array('db' => 'su_name', 'dt' => 7),
            array('db' => 'total_leave', 'dt' => 8),
            array('db' => 'assignto_name', 'dt' => 9),
            array('db' => 'approved_dept_ind', 'dt' => 10),
            array('db' => 'approved_hr_ind', 'dt' => 11),
            array('db' => 'leave_for_extra_duty', 'dt' => 12),
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchLeaveList(Request $request)
    {
        //dd($request->date_from);
        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to . '+ 1 Days')) : "";

        $dep = DB::table('sysc_grant_servieceunit_vw')
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select(DB::raw("LISTAGG(serviceunit_no_pk, ', ') WITHIN GROUP (ORDER BY serviceunit_no_pk) serviceunit_no_pk"))
            ->orderBy('serviceunit_name', 'asc')
            ->get();

        $service_unit_list = $dep[0]->serviceunit_no_pk;
        // dd($service_unit_list);
        $sql_cond = "";

        // if (empty($request->dep_name) && !empty($date_from) && !empty($date_to)) {
        //     $clause = ($sql_cond != "") ? "and" : " ";
        //     $sql_cond .= $date_from && $date_to != "" ? " $clause au_entry_at between '$date_from' and '$date_to' and serviceunit_no_fk in($service_unit_list) " : "";
        // } else {
            $clause = ($sql_cond != "") ? " and" : " ";
            $sql_cond .= $date_from && $date_to != "" ? " $clause au_entry_at between '$date_from' and '$date_to'" : "";
            $clause = ($sql_cond != "") ? " and" : " ";
            $sql_cond .= $request->dep_name != '' ? " $clause serviceunit_no_fk =$request->dep_name " : "";
        // }
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        // dd($sql_cond);
        $table = 'hrms_leave_entry_vw';
        $primaryKey = 'leave_no_pk';
        $columns = array(
            array('db' => 'leave_no_pk', 'dt' => 0),
            array('db' => 'full_name', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'designation_name', 'dt' => 3),
            array('db' => 'leave_reason', 'dt' => 4),
            array('db' => 'from_date', 'dt' => 5),
            array('db' => 'to_dates', 'dt' => 6),
            array('db' => 'su_name', 'dt' => 7),
            array('db' => 'total_leave', 'dt' => 8),
            array('db' => 'assignto_name', 'dt' => 9),
            // array('db' => 'leave_no_pk', 'dt' => 10),
            array('db' => 'approved_dept_ind', 'dt' => 10),
            array('db' => 'approved_hr_ind', 'dt' => 11),
            array('db' => 'leave_for_extra_duty', 'dt' => 12),

        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchLeaveList_hr(Request $request)
    {
        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to . '+ 1 Days')) : "";

        $sql_cond = "";
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause au_entry_at between '$date_from' and '$date_to' " : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $request->dep_name != '' ? " $clause serviceunit_no_fk =$request->dep_name " : "";

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= "$clause au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'hrms_leave_entry_vw';
        $primaryKey = 'leave_no_pk';
        $columns = array(
            array('db' => 'leave_no_pk', 'dt' => 0),
            array('db' => 'full_name', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'designation_name', 'dt' => 3),
            array('db' => 'leave_reason', 'dt' => 4),
            array('db' => 'from_date', 'dt' => 5),
            array('db' => 'to_dates', 'dt' => 6),
            array('db' => 'su_name', 'dt' => 7),
            array('db' => 'total_leave', 'dt' => 8),
            array('db' => 'assignto_name', 'dt' => 9),
            // array('db' => 'leave_no_pk', 'dt' => 10),
            array('db' => 'approved_dept_ind', 'dt' => 10),
            array('db' => 'approved_hr_ind', 'dt' => 11),
            array('db' => 'leave_for_extra_duty', 'dt' => 12),
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function leavepopUpCreateByDep($id, $type = '')
    {
        $page = $type;
        // dd($page);
        $data = DB::table('hrms_leave_entry')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('leave_no_pk', '=', $id)
            ->first();
        return template::loadview('admin.settings.leave_list.create_form_dep', compact('data', 'page'));
    }

    public function leavepopUpCreateByHr($id, $type = '')
    {
        $page = $type;
        // dd($page);
        $data = DB::table('hrms_leave_entry')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('leave_no_pk', '=', $id)
            ->first();
        return template::loadview('admin.settings.leave_list.create_form_hr', compact('data', 'page'));
    }
    public function leaveEmployeeView($id)
    {
        $data = DB::table('HRMS_LEAVE_ENTRY_VW a')
            ->where('leave_no_pk', '=', $id)
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->leftJoin('WSEC_USER dep', 'a.APPROVED_DEPT_BY', '=', 'dep.USER_NO_PK')
            ->leftJoin('WSEC_USER hr', 'a.APPROVED_HR_BY', '=', 'hr.USER_NO_PK')
            ->select(
                'a.person_no_fk',
                'a.person_code',
                'a.leave_no_pk',
                'a.au_entry_at',
                'a.full_name',
                'a.full_name_dept',
                'a.designation_name',
                'a.from_date',
                'a.to_dates',
                'a.total_leave',
                'a.available_leave',
                'a.dep_approve_note',
                'a.dep_reject_note',
                'a.hr_approve_note',
                'a.hr_reject_note',
                'a.approved_dept_at',
                'a.approved_hr_at',
                'a.leave_reason',
                'a.su_name',
                'dep.user_fullname as dep_user_name',
                'hr.user_fullname as hr_user_name',
            )
            ->first();

        $emp_id = DB::table('HRMS_LEAVE_ENTRY_VW')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('leave_no_pk', '=', $id)
            ->select('HRMS_LEAVE_ENTRY_VW.person_no_fk')
            ->first();


        // hrms_leave_sum_vw
        $leave_sum = DB::table('hrms_leave_sum_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('person_no_fk', '=', $emp_id->person_no_fk)
            ->first();
        // dd($leave_sum);



        $total_leave_count = DB::table('HRMS_LEAVE_ENTRY_VW a')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('person_no_fk', '=', $emp_id->person_no_fk)
            ->where('approved_hr_ind', '=', 1)
            ->select(DB::raw('sum(a.total_leave) as total_leave'))->first();
        // dd( $total_leave_count);
        return template::loadview('admin.settings.leave_list.leave_emp_view', compact('data', 'total_leave_count', 'leave_sum'));
    }
    public function leaveEmployeeEdit($id)
    {
        $data = DB::table('HRMS_LEAVE_ENTRY_VW a')
            ->where('leave_no_pk', '=', $id)
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->leftJoin('WSEC_USER dep', 'a.APPROVED_DEPT_BY', '=', 'dep.USER_NO_PK')
            ->leftJoin('WSEC_USER hr', 'a.APPROVED_HR_BY', '=', 'hr.USER_NO_PK')
            ->select(
                'a.person_no_fk',
                'a.leave_type_lkp_no_fk',
                'a.person_code',
                'a.leave_no_pk',
                'a.au_entry_at',
                'a.full_name',
                'a.full_name_dept',
                'a.designation_name',
                'a.from_date',
                'a.to_dates',
                'a.leave_for_extra_duty',
                'a.total_leave',
                'a.available_leave',
                'a.dep_approve_note',
                'a.dep_reject_note',
                'a.hr_approve_note',
                'a.hr_reject_note',
                'a.approved_dept_at',
                'a.approved_hr_at',
                'a.leave_reason',
                'a.su_name',
                'a.leave_for_extra_assignto',
                'a.assignto_name',
                'dep.user_fullname as dep_user_name',
                'hr.user_fullname as hr_user_name',
            )
            ->first();
// dd($data);
        $emp_id = DB::table('HRMS_LEAVE_ENTRY_VW')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('leave_no_pk', '=', $id)
            ->select('HRMS_LEAVE_ENTRY_VW.person_no_fk')
            ->first();


        // hrms_leave_sum_vw
        $leave_sum = DB::table('hrms_leave_sum_vw')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('person_no_fk', '=', $emp_id->person_no_fk)
            ->first();
        // dd($leave_sum);

        $total_leave_count = DB::table('HRMS_LEAVE_ENTRY_VW a')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('person_no_fk', '=', $emp_id->person_no_fk)
            ->where('approved_hr_ind', '=', 1)
            ->select(DB::raw('sum(a.total_leave) as total_leave'))->first();
        $leave_info  = DB::table("hrms_leavetype_days")->select("leave_type_lkp_no_fk", "leave_type_lkp_name", "no_of_days", "leave_code")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("status", 1)
            ->get();
        // dd( $total_leave_count);
        return template::loadview('admin.settings.leave_list.leave_emp_edit', compact('data', 'total_leave_count', 'leave_sum', 'leave_info'));
    }

    public function leave_view_Print(Request $request)
    {
        $hospital_code = Session::get('user.ses_hospital_no_pk');
        $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.leave_reason,a.approved_dept_ind,a.approved_hr_ind,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave,dep.user_fullname head_name , hr.user_fullname hr_name,a.approved_hr_at,a.approved_dept_at,a.assignto_name,a.leave_for_extra_duty
            from hrms_leave_entry_vw a
            LEFT JOIN wsec_user hr ON a.approved_hr_by = hr.user_no_pk
            LEFT JOIN wsec_user dep ON a.approved_dept_by = dep.user_no_pk
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where a.leave_no_pk = $request->leave_no_pk
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc
            ");
        // dd($leave_summary);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.settings.leave_list.leave_request_form", compact('po_hospital_details', 'leave_summary'));

        return $pdf->stream('leave_request_form.pdf');
    }

    public function leave_Report()
    {

        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $to_date =  date('d-m-Y');

        $hospital_code = Session::get('user.ses_hospital_no_pk');
        $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(au_entry_at) = to_date('$to_date','DD-MM-YYYY')
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc
            ");

        // dd($leave_summary);
        return template::loadview('admin.settings.leave_list.leave_summary_report', compact('leave_summary'));
    }

    public function leave_ReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));
        $hospital_code = Session::get('user.ses_hospital_no_pk');

        if ($card_no == "") {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc
            ");
        } else {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.person_no_fk = '$card_no'
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc

            ");
        }
        return template::loadview('admin.settings.leave_list.leave_summary_report_list', compact('leave_summary'));
    }
    public function leave_ReportPrint(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = date("d/m/Y", strtotime($request->from_date));
        $to_date = date("d/m/Y", strtotime($request->to_date));
        $hospital_code = Session::get('user.ses_hospital_no_pk');

        if ($card_no == "") {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc
            ");
        } else {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a
            LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.person_no_fk = '$card_no'
            and a.au_entry_hospital_pk_no = $hospital_code
            order by a.au_entry_at desc

            ");
        }


        // dd($leave_summary);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.settings.leave_list.leave_summary_print", compact('po_hospital_details', 'leave_summary', 'from_date', 'to_date'));

        return $pdf->stream('leave_summary_print.pdf');
    }
    public function leave_Reportexcel(Request $request)
    {
        $card_no       = $request->card_hidn;
        $from_date     = date("d/m/Y", strtotime($request->from_date));
        $to_date       = date("d/m/Y", strtotime($request->to_date));
        $hospital_code = Session::get('user.ses_hospital_no_pk');

        if ($card_no == "") {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.au_entry_hospital_pk_no = $hospital_code order by a.au_entry_at desc");
        } else {
            $leave_summary = DB::select("select a.au_entry_at,a.person_code,a.full_name,a.designation_name,a.su_name,a.from_date, a.to_dates,b.all_leave,b.ramaining_leave
            from hrms_leave_entry_vw a LEFT JOIN hrms_leave_sum_vw b ON a.person_no_fk = b.person_no_fk
            where trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')
            and a.person_no_fk = '$card_no' and a.au_entry_hospital_pk_no = $hospital_code order by a.au_entry_at desc");
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = ['po_hospital_details' => $po_hospital_details, 'leave_summary' => $leave_summary, 'from_date' => $from_date, 'to_date' => $to_date];
        $fileToExport = "leave_summary_print_excel";
        $html         = View("admin.settings.leave_list.leave_summary_print_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function depApprove(Request $request)
    {
        $primaryKey = $request->approved_dept_ind;
        $approveId  = $request->dep_app_id;
        $rejectId   = $request->dep_rej_id;
        date_default_timezone_set('Asia/Dhaka');
        $time       = Carbon::now();
        $cur_date   =  date('Y-m-d h:i:s', strtotime($time));

        try {
            $data = [];
            $data = [
                'APPROVED_DEPT_BY' => Auth::id(),
                'APPROVED_DEPT_AT' => $cur_date,
            ];

            if (isset($approveId)) {
                $data['approved_dept_ind'] = $approveId;
                $data['DEP_APPROVE_NOTE']  = $request->dep_approval_note;
                DB::table('hrms_leave_entry')
                    ->where('leave_no_pk', $primaryKey)
                    ->update($data);
                $message = ['msg' => 'Approved Successfully!!', 'title' => 'Success'];
            } elseif (isset($rejectId)) {
                $data['approved_dept_ind'] = $rejectId;
                $data['DEP_REJECT_NOTE']   = $request->dep_reject_note;
                DB::table('hrms_leave_entry')
                    ->where('leave_no_pk', $primaryKey)
                    ->update($data);
                $message = ['msg' => 'Rejected Successfully!!', 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function hrpApprove(Request $request)
    {
        $primaryKey = $request->approved_dept_ind;
        $approveId  = $request->dep_app_id;
        $rejectId   = $request->dep_rej_id;
        date_default_timezone_set('Asia/Dhaka');
        $time       = Carbon::now();
        $cur_date   =  date('Y-m-d h:i:s', strtotime($time));

        try {
            $data = [];
            $data = [
                'APPROVED_HR_BY' => Auth::id(),
                'APPROVED_HR_AT' => $cur_date
            ];

            if (isset($approveId)) {
                $data['approved_hr_ind'] = $approveId;
                $data['HR_APPROVE_NOTE'] = $request->dep_approval_note;
                DB::table('hrms_leave_entry')
                    ->where('leave_no_pk', $primaryKey)
                    ->update($data);
                $message = ['msg' => 'Approved Successfully!!', 'title' => 'Success'];
            } elseif (isset($rejectId)) {
                $data['approved_hr_ind'] = $rejectId;
                $data['HR_REJECT_NOTE']  = $request->dep_reject_note;
                DB::table('hrms_leave_entry')
                    ->where('leave_no_pk', $primaryKey)
                    ->update($data);
                $message = ['msg' => 'Rejected Successfully!!', 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function hrCancel(Request $request){
        $leave_no_pk = $request->leave_no_fk;
        $time        = Carbon::now();
        $cur_date    =  date('Y-m-d h:i:s', strtotime($time));

        try {
            $data = [
                'APPROVED_HR_BY' => Auth::id(),
                'APPROVED_HR_AT' => $cur_date,
                'approved_hr_ind' => 2 
            ];
            DB::table('hrms_leave_entry')
                ->where('leave_no_pk', $leave_no_pk)
                ->update($data);
        $message = ['msg' => 'Cancel Successfully!!', 'title' => 'Success'];

        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function showBalanceLeaveHR(Request $request){
        $service_unit = DB::select("select distinct unit.serviceunit_no_pk,serviceunit_name
                        from sysc_serviceunit unit,hrms_personnel per
                        where unit.serviceunit_no_pk=per.serviceunit_no_fk
                        order by serviceunit_name");

        return Template::loadView('admin.settings.leave_list.show-balance-leave-hr', ['service_unit'=>$service_unit]);
    }

    public function searchBalanceLeaveHR(Request $request){
        if (!isset($request->su_name) && !isset($request->card_no)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                                    ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                                    ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                                    ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                                    ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                                    ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                                    ->get();
        }
            if (isset($request->su_name)) {
                $balance_leave = DB::table('hrms_personal_leave_vw as a')
                                    ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                                    ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                                    ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                                    ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                                    ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                                    ->get();
            }

            if (isset($request->card_no)) {
                $balance_leave = DB::table('hrms_personal_leave_vw as a')
                                    ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                                    ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                                    ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                                    ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                                    ->where('hrms_personnel.card_no', $request->card_no)
                                    ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                                    ->get();
            }
        return Template::loadView('admin.settings.leave_list.search-balance-leave-table-hr', ['balance_leave'=>$balance_leave]);
    }

    public function searchBalancePdfDownload(Request $request)
    {
        if (!isset($request->su_name) && !isset($request->card_no)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                            ->get();
        }

        if (isset($request->su_name)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', 'hrms_personnel.join_date', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no', 'hrms_personnel.join_date')
                            ->get();
        }

        if (isset($request->card_no)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->where('hrms_personnel.card_no', $request->card_no)
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                            ->get();
        }

        foreach($balance_leave as $leave) {
               $info     = DB::table('hrms_personal_leave_vw')
                            ->where('person_no_pk', $leave->person_no_pk)
                            ->get();

            $availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
                            ->where('a.person_no_fk', $leave->person_no_pk)
                            ->whereYear('from_date', date('Y'))
                            ->whereYear('to_dates', date('Y'))
                            ->where('a.approved_ind', 1)
                            ->orderBy('a.leave_no_pk', 'desc')
                            ->get();

            $leave->availed_info = $info;

            $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
            foreach($info as $item) {
                $leaveTypeWiseAvailedInfo = $availedInfo->where("leave_type_lkp_no_fk", $item->leave_type_lkp_no_fk);

                foreach($months as $month) {
                    $item->$month = 0;
                }

                foreach($leaveTypeWiseAvailedInfo as $data) {
                    $dates = getDatesFromRange($data->from_date, $data->to_dates);
                    foreach($dates as $date) {
                        $monthIdx     = (int) date('m', strtotime($date)) - 1;
                        $month        = $months[$monthIdx];
                        $total        = ++$item->$month;
                        $item->$month = $total;
                    }
                }
            }
        }
        
        if ($request->hdn_report_type == "SUMMARY") {
            $pdf = PDF::loadView("admin.reports.leaves.leave-report-pdf", ['leaves' => $balance_leave])->setPaper('a4', 'landscape');;
            return $pdf->stream('leave-report.pdf');
        } else {
           return view("admin.reports.leaves.leave-report-pdf", ['leaves' => $balance_leave]);
        }
    }

    /**
     * Get Leave Details
     */
    public function showLeaveDetailsfoHR($id = "") {
        $info = DB::table('hrms_personal_leave_vw')
                    ->where('person_no_pk', $id)
                    ->get();

        $availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
                        ->where('a.person_no_fk', $id)
                        ->whereYear('from_date', date('Y'))
                        ->whereYear('to_dates', date('Y'))
                        ->where('a.approved_ind', 1)
                        ->orderBy('a.leave_no_pk', 'desc')
                        ->get();

        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
        foreach($info as $index => $item) {
            $leaveTypeWiseAvailedInfo = $availedInfo->where("leave_type_lkp_no_fk", $item->leave_type_lkp_no_fk);

            foreach($months as $month) {
                $item->$month = 0;
            }

            foreach($leaveTypeWiseAvailedInfo as $data) {
                $dates = getDatesFromRange($data->from_date, $data->to_dates);
                foreach($dates as $date) {
                    $monthIdx     = (int) date('m', strtotime($date)) - 1;
                    $month        = $months[$monthIdx];
                    $total        = ++$item->$month;
                    $item->$month = $total;
                }
            }
        }

        return Template::loadView('admin.settings.leave_list.show-leave-details-popup-hr', ['info'=>$info]);
    }

    public function showLeaveDetailsfoHROld($id = ""){
        $info = DB::table('hrms_personal_leave_vw')
                ->where('person_no_pk', $id)
                ->get();

        return DB::select("
            SELECT hrms_personal_leave_vw.*,
            (CASE WHEN (from_date LIKE '%-01-%') THEN ((TO_DATE(TO_CHAR(to_dates, 'YYYY-MM-DD'),'YYYY-MM-DD') - TO_DATE(TO_CHAR(from_date, 'YYYY-MM-DD'),'YYYY-MM-DD')) + 1) ELSE 0 END) jan,
            (CASE WHEN (from_date LIKE '%-02-%') THEN ((TO_DATE(TO_CHAR(to_dates, 'YYYY-MM-DD'),'YYYY-MM-DD') - TO_DATE(TO_CHAR(from_date, 'YYYY-MM-DD'),'YYYY-MM-DD')) + 1) ELSE 0 END) feb
            FROM hrms_personal_leave_vw JOIN hrms_leave_entry_for_approval_vw ON hrms_personal_leave_vw.person_no_pk = hrms_leave_entry_for_approval_vw.person_no_fk
            AND hrms_personal_leave_vw.leave_type_lkp_no_fk = hrms_leave_entry_for_approval_vw.leave_type_lkp_no_fk WHERE
            person_no_fk = $id AND hrms_leave_entry_for_approval_vw.approved_ind = 1");

        $info = DB::table('hrms_personal_leave_vw')
                    ->leftJoin('hrms_leave_entry_for_approval_vw', 'hrms_personal_leave_vw.person_no_pk', 'hrms_leave_entry_for_approval_vw.person_no_fk')
                    ->leftJoin('hrms_leave_entry_for_approval_vw', 'hrms_personal_leave_vw.leave_type_lkp_no_fk', 'hrms_leave_entry_for_approval_vw.leave_type_lkp_no_fk')
                    ->where('person_no_fk', 13975)
                    ->where('hrms_leave_entry_for_approval_vw.approved_ind', 1)
                    ->where('hrms_personal_leave_vw.leave_type_lkp_no_fk', 543)
                    ->select(
                        'from_date', 'to_dates',
                        'hrms_personal_leave_vw.*',
                        'hrms_leave_entry_for_approval_vw.*')->get();
        return $info; 
        return Template::loadView('admin.settings.leave_list.show-leave-details-popup-hr', ['info'=>$info]);
    }

    public function showAvailedDetails($id = ""){
        $availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
                        ->where('a.person_no_fk', $id)
                        ->where('a.approved_ind', 1)
                        ->orderBy('a.leave_no_pk', 'desc')
                        ->get();

        return Template::loadView('admin.settings.leave_list.show-availed-leave-details-popup', ['availedInfo'=>$availedInfo]);
    }

    public function showBalanceLeaveHOD(Request $request){
            $user_info     = Auth::user();
            $balance_leave = DB::select("select a.person_no_pk, a.full_name, sysc_serviceunit.serviceunit_name, hrms_designation.designation_name, hrms_personnel.card_no, sum(a.no_of_days) as total_balance, sum(a.leave) as total_leave from hrms_personal_leave_vw a left Join
                            hrms_personnel  on  a.person_no_pk=hrms_personnel.person_no_pk left Join sysc_serviceunit on
                            hrms_personnel.serviceunit_no_fk=sysc_serviceunit.serviceunit_no_pk
                            left Join hrms_designation
                            on  hrms_personnel.jobtitle_lookup_no_fk=hrms_designation.designation_no_pk
                            where hrms_personnel.person_no_pk = $user_info->person_no_fk
                            or hrms_personnel.person_no_pk in (select person_no_pk from  hrms_personnel where EMP_SUPVISOR1_PERSON_NO_FK =$user_info->person_no_fk or EMP_SUPVISOR2_PERSON_NO_FK=$user_info->person_no_fk)
                            group By a.person_no_pk, a.full_name, sysc_serviceunit.serviceunit_name,hrms_designation.designation_name, hrms_personnel.card_no");

        return Template::loadView('admin.settings.leave_list.show-balance-leave-hod', ['balance_leave'=>$balance_leave]);
    }

    public function searchBalanceLeaveHOD(Request $request){
        $user_info = Auth::user();

        if (isset($request->card_no)) {
            $balance_leave = DB::select("select a.person_no_pk, a.full_name, sysc_serviceunit.serviceunit_name, hrms_designation.designation_name, hrms_personnel.card_no, sum(a.no_of_days) as total_balance, sum(a.leave) as total_leave from hrms_personal_leave_vw a left Join
                            hrms_personnel on a.person_no_pk = hrms_personnel.person_no_pk left Join sysc_serviceunit on
                            hrms_personnel.serviceunit_no_fk = sysc_serviceunit.serviceunit_no_pk
                            left Join hrms_designation
                            on hrms_personnel.jobtitle_lookup_no_fk = hrms_designation.designation_no_pk
                            where (hrms_personnel.person_no_pk = $user_info->person_no_fk
                            or hrms_personnel.person_no_pk in (select person_no_pk from hrms_personnel where EMP_SUPVISOR1_PERSON_NO_FK = $user_info->person_no_fk or EMP_SUPVISOR2_PERSON_NO_FK = $user_info->person_no_fk)) and hrms_personnel.card_no = '$request->card_no'
                            group By a.person_no_pk, a.full_name, sysc_serviceunit.serviceunit_name, hrms_designation.designation_name, hrms_personnel.card_no");
        }

    return Template::loadView('admin.settings.leave_list.search-balance-leave-table-hod', ['balance_leave'=>$balance_leave]);
}

public function dailyAttendanceReportV1()
{
        $to_date        = date('d-m-Y');
        $dept           = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig          = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $dailAttendanceReportSearch = DB::select("select a.entry_type, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0 $from_date_cond order by trunc(ATTENDANCE_DATE) desc");

        return Template::loadview("admin.reports.hrm.daily_attendance_reportv1", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch, 'dept' => $dept, 'desig' => $desig]);
    }


    public function dailyAttendanceReportSearchV1(Request $request)
    {
        $personal_no_pk  = $request->card_hidn;
        $att_status      = $request->att_status;
        $designation     = $request->designation_name;
        $card_no         = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();

        $from_date       = date("d-m-Y", strtotime($request->date_pic));
        $to_date         = date("d-m-Y", strtotime($request->date_pic2));
        $department      = $request->department_name;
        $department_con  = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $from_date_cond  = ($request->date_pic != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";
        $card_no_con     = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        if ($att_status == 1) {
            $att_status_con = ($att_status != "") ? " and a.attendance_status between  1 and  2" : "";
        } else {
            $att_status_con = ($att_status != "") ? " and a.attendance_status = $att_status " : "";
        }

        $dailAttendanceReportSearch = DB::select("select a.attendance_date, a.entry_type, a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min, jobtype.lookupdata_desc, a.late_time_min,b.photo_name,a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name, su.serviceunit_name, shift.shift_code from hrms_attendance_daily a left join hrms_personnel b ON b.person_code = a.person_card_no left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk left join sysc_lookupdata jobtype
                                                 on jobtype.lookupdata_no_pk = b.job_type_lookup_no_fk where a.person_card_no IS NOT NULL and b.status = 1 and nvl(b.virtual_ind,0)=0  $card_no_con $from_date_cond  $department_con $att_status_con  $designation_con order by jobtype.serial_no asc, a.person_card_no  asc, a.attendance_date desc");

        return Template::loadview("admin.reports.hrm.daily_attendance_report_listv1", ['dailAttendanceReportSearch' => $dailAttendanceReportSearch]);
    }
    //leave carry forward
    public function leaveCarryForward(Request $request) {
        $to_date = date('d-m-Y');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $leaveCarryForwardData = [];
        return Template::loadview("admin.settings.carry_forward.leave_carry_forward", ['leaveCarryForwardData' => $leaveCarryForwardData, 'dept' => $dept, 'year' => '']);
       
    }
    public function searchLeaveCarryForward(Request $request) {
    
        $year = $request->year; // Ensure this contains only the year (e.g., "2025")

        $department_con = ($request->department_name != "") ? " AND per.serviceunit_no_fk = '$request->department_name'" : "";
        $card_no_con = ($request->card_hidn != "") ? " AND per.person_no_pk = '$request->card_hidn'" : "";
        if (Session::get('user.ses_hospital_code') == 'DMHL') {
            $leaveCarryForwardData = DB::select("SELECT PERSON_NO_PK, PERSON_CODE, serviceunit_name, designation_name, FULL_NAME, LEAVE_TYPE_LKP_NO_FK, LEAVE_TYPE_LKP_NAME, LEAVE_CODE, leave_balance,
            NO_OF_DAYS, LEAVE, NO_OF_DAYS - NVL(LEAVE, 0) balance
            FROM (
                SELECT per.person_no_pk, per.full_name, per.person_code, pleave.leave_type_lkp_no_fk, pleave.leave_type_lkp_name, pleave.leave_code, dep.serviceunit_name, prev_leave.leave_balance, desg.designation_name,
                        CASE
                    WHEN LEAVE_CODE = 'AL'
                    THEN
                        CASE
                        WHEN ( (TO_DATE('31-12-' || $year, 'DD-MM-YYYY') - JOIN_DATE) / 365) < 1
                        THEN
                                ROUND (
                                    (pleave.no_of_days / 365)
                                * (  ADD_MONTHS (
                                        TRUNC (JOIN_DATE, 'YEAR'),
                                        12)
                                    - JOIN_DATE))       -- pleave.no_of_days
                            + NVL (
                                (SELECT LEAVE_BALANCE
                                    FROM HRMS_PREVIOUS_LEAVE_BALANCE
                                    WHERE PERSON_NO_FK = per.PERSON_NO_PK),
                                0)
                        WHEN ( (TO_DATE('31-12-' || $year, 'DD-MM-YYYY') - JOIN_DATE) / 365) > 1
                        THEN
                                pleave.no_of_days
                                * CEIL (
                                    (  (  TO_DATE('31-12-' || $year, 'DD-MM-YYYY')
                                        - TO_DATE ('01/01/2024',
                                                    'dd/mm/yyyy'))
                                    / 365))
                            + NVL (
                                (SELECT LEAVE_BALANCE
                                    FROM HRMS_PREVIOUS_LEAVE_BALANCE
                                    WHERE PERSON_NO_FK = per.PERSON_NO_PK),
                                0)
                        END
                        END AS no_of_days,
                        NVL(
                            (SELECT SUM(1) AS no_of_daysleave
                            FROM hrms_leave_entry a
                            JOIN HRMS_LEAVE_ENTRYDTL d ON a.LEAVE_NO_pK = d.LEAVE_NO_FK
                            WHERE APPROVED_IND = 1
                            AND a.au_entry_hospital_pk_no = pleave.au_entry_hospital_pk_no
                            AND TRUNC(LEAVE_DATES) BETWEEN TO_DATE('01-01-' || $year, 'DD-MM-YYYY')
                                                        AND TO_DATE('31-12-' || $year, 'DD-MM-YYYY')
                            AND a.LEAVE_TYPE_LKP_NO_FK = pleave.LEAVE_TYPE_LKP_NO_FK
                            AND a.PERSON_NO_FK = per.PERSON_NO_PK),
                            0) AS leave
                FROM hrms_personnel per
                LEFT JOIN sysc_serviceunit dep ON dep.serviceunit_no_pk = per.serviceunit_no_fk
                LEFT JOIN hrms_designation desg ON desg.designation_no_pk = per.jobtitle_lookup_no_fk
                JOIN hrms_leavetype_days pleave ON per.leave_category_lookup_no_fk = pleave.leave_category_lookup_no_fk
                LEFT JOIN HRMS_PREVIOUS_LEAVE_BALANCE prev_leave
                ON prev_leave.PERSON_NO_FK = per.PERSON_NO_PK
                AND prev_leave.YEAR_YYYY = $year
                WHERE per.status = 1
                $department_con $card_no_con
                AND LEAVE_CODE IN ('AL')
                AND (NVL(pleave.GENDER, 'Both') = 'Both'
                        OR (pleave.GENDER =
                            (SELECT LOOKUPDATA_NAME FROM SYSC_LOOKUPDATA
                            WHERE LOOKUPDATA_NO_PK = PER.GENDER_LOOKUP_NO_FK)
                        AND per.MARITAL_LOOKUP_NO_FK =
                            (SELECT LOOKUPDATA_NO_PK FROM SYSC_LOOKUPDATA
                            WHERE LOOKUPDATA_CODE = 'M')))
            )
            WHERE (NO_OF_DAYS - NVL(LEAVE, 0)) IS NOT NULL ORDER BY PERSON_CODE ASC");

        }else{
            $leaveCarryForwardData = DB::select("
                    SELECT PERSON_NO_PK, PERSON_CODE, serviceunit_name, designation_name, FULL_NAME, LEAVE_TYPE_LKP_NO_FK, LEAVE_TYPE_LKP_NAME, LEAVE_CODE, leave_balance,
                    NO_OF_DAYS, LEAVE, NO_OF_DAYS - NVL(LEAVE, 0) balance
            FROM (
                SELECT per.person_no_pk, per.full_name, per.person_code, pleave.leave_type_lkp_no_fk, pleave.leave_type_lkp_name, pleave.leave_code, dep.serviceunit_name, prev_leave.leave_balance, desg.designation_name,
                        CASE
                            WHEN (LEAVE_CODE = 'EL' AND (TO_DATE('31-12-' || $year, 'DD-MM-YYYY') - JOIN_DATE) > 365)
                            THEN
                                CASE
                                    WHEN ((TO_DATE('31-12-' || $year, 'DD-MM-YYYY') - JOIN_DATE) / 365) < 1
                                    THEN 0 + NVL(
                                            (SELECT LEAVE_BALANCE FROM HRMS_PREVIOUS_LEAVE_BALANCE
                                            WHERE PERSON_NO_FK = per.PERSON_NO_PK and YEAR_YYYY=$year), 0)
                                    ELSE pleave.no_of_days + NVL(
                                            (SELECT LEAVE_BALANCE FROM HRMS_PREVIOUS_LEAVE_BALANCE
                                            WHERE PERSON_NO_FK = per.PERSON_NO_PK and YEAR_YYYY=$year), 0)
                                END
                        END AS no_of_days,
                        NVL(
                            (SELECT SUM(1) AS no_of_daysleave
                            FROM hrms_leave_entry a
                            JOIN HRMS_LEAVE_ENTRYDTL d ON a.LEAVE_NO_pK = d.LEAVE_NO_FK
                            WHERE APPROVED_IND = 1
                            AND a.au_entry_hospital_pk_no = pleave.au_entry_hospital_pk_no
                            AND TRUNC(LEAVE_DATES) BETWEEN TO_DATE('01-01-' || $year, 'DD-MM-YYYY')
                                                        AND TO_DATE('31-12-' || $year, 'DD-MM-YYYY')
                            AND a.LEAVE_TYPE_LKP_NO_FK = pleave.LEAVE_TYPE_LKP_NO_FK
                            AND a.PERSON_NO_FK = per.PERSON_NO_PK),
                            0) AS leave
                FROM hrms_personnel per
                LEFT JOIN sysc_serviceunit dep ON dep.serviceunit_no_pk = per.serviceunit_no_fk
                LEFT JOIN hrms_designation desg ON desg.designation_no_pk = per.jobtitle_lookup_no_fk
                JOIN hrms_leavetype_days pleave ON per.leave_category_lookup_no_fk = pleave.leave_category_lookup_no_fk

                LEFT JOIN HRMS_PREVIOUS_LEAVE_BALANCE prev_leave 
                ON prev_leave.PERSON_NO_FK = per.PERSON_NO_PK 
                AND prev_leave.YEAR_YYYY = $year

                WHERE per.status = 1 
                $department_con $card_no_con
                AND LEAVE_CODE IN ('EL')
                AND (NVL(pleave.GENDER, 'Both') = 'Both'
                        OR (pleave.GENDER =
                            (SELECT LOOKUPDATA_NAME FROM SYSC_LOOKUPDATA
                            WHERE LOOKUPDATA_NO_PK = PER.GENDER_LOOKUP_NO_FK)
                        AND per.MARITAL_LOOKUP_NO_FK =
                            (SELECT LOOKUPDATA_NO_PK FROM SYSC_LOOKUPDATA
                            WHERE LOOKUPDATA_CODE = 'M')))
            )
            WHERE (NO_OF_DAYS - NVL(LEAVE, 0)) IS NOT NULL ORDER BY PERSON_CODE ASC");

        }
        
//  DD($leaveCarryForwardData);
        return Template::loadview("admin.settings.carry_forward.leave_carry_forward_list", ['leaveCarryForwardData' => $leaveCarryForwardData, 'year' => $year]);
    }
    public function saveLeaveCarryForward(Request $request)
    {
        $ids             = isset($request->leave_item) ? $request->leave_item : [];
        $person_no_pk    = isset($request->person_no_pk) ? $request->person_no_pk : [];
        $person_code  = isset($request->person_code) ? $request->person_code : [];
        $full_name = isset($request->full_name) ? $request->full_name : [];
        $leave_type_lkp_no_fk    = isset($request->leave_type_lkp_no_fk) ? $request->leave_type_lkp_no_fk : [];
        $balance   = isset($request->balance) ? $request->balance : [];
        $year   = isset($request->year) ? $request->year : '';
        $auth_id         = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $au_entry_at     = Carbon::now();
        $au_entry_at     = $au_entry_at->toDateString();
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                $data = [
                    'PERSON_NO_FK'        => isset($person_no_pk[$id]) ? $person_no_pk[$id] : "",
                    'CARD_NO'             => isset($person_code[$id]) ? $person_code[$id] : "",
                    'EMP_NAME'            => isset($full_name[$id]) ? $full_name[$id] : "",
                    'LEAVETYPEDAYS_NO_FK' => isset($leave_type_lkp_no_fk[$id]) ? $leave_type_lkp_no_fk[$id] : "",
                    'LEAVE_BALANCE'       => isset($balance[$id]) ? $balance[$id] : "",
                    'YEAR_YYYY'           => $year,
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_entry_at'             => $au_entry_at,
                    'au_entry_by'             => $auth_id,
                    'au_entry_session'        => "carry forward"
                ];

                DB::table('HRMS_PREVIOUS_LEAVE_BALANCE')->insert($data);
            }
            if(count($ids) > 0){
                DB::commit();
                $message = ['msg' => 'Approved Successfully', 'title' => 'Success'];
            }else{
                $message = ['msg' => 'Please check the checkbox !!', 'title' => 'Error'];
            }
           
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function leaveCarryForwardPdf(Request $request)
    {
        if (!isset($request->su_name) && !isset($request->card_no)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                            ->get();
        }

        if (isset($request->su_name)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', 'hrms_personnel.join_date', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no', 'hrms_personnel.join_date')
                            ->get();
        }

        if (isset($request->card_no)) {
            $balance_leave = DB::table('hrms_personal_leave_vw as a')
                            ->select('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name', 'hrms_designation.designation_name', 'hrms_personnel.card_no', DB::raw('sum(a.no_of_days) as total_balance'), DB::raw('sum(a.leave) as total_leave'))
                            ->leftJoin('hrms_personnel', 'a.person_no_pk', 'hrms_personnel.person_no_pk')
                            ->leftJoin('sysc_serviceunit', 'hrms_personnel.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
                            ->leftJoin('hrms_designation', 'hrms_personnel.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                            ->where('hrms_personnel.card_no', $request->card_no)
                            ->groupBy('a.person_no_pk', 'a.full_name', 'sysc_serviceunit.serviceunit_name','hrms_designation.designation_name', 'hrms_personnel.card_no')
                            ->get();
        }

        foreach($balance_leave as $leave) {
               $info     = DB::table('hrms_personal_leave_vw')
                            ->where('person_no_pk', $leave->person_no_pk)
                            ->get();

            $availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
                            ->where('a.person_no_fk', $leave->person_no_pk)
                            ->whereYear('from_date', date('Y'))
                            ->whereYear('to_dates', date('Y'))
                            ->where('a.approved_ind', 1)
                            ->orderBy('a.leave_no_pk', 'desc')
                            ->get();

            $leave->availed_info = $info;

            $months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
            foreach($info as $item) {
                $leaveTypeWiseAvailedInfo = $availedInfo->where("leave_type_lkp_no_fk", $item->leave_type_lkp_no_fk);

                foreach($months as $month) {
                    $item->$month = 0;
                }

                foreach($leaveTypeWiseAvailedInfo as $data) {
                    $dates = getDatesFromRange($data->from_date, $data->to_dates);
                    foreach($dates as $date) {
                        $monthIdx     = (int) date('m', strtotime($date)) - 1;
                        $month        = $months[$monthIdx];
                        $total        = ++$item->$month;
                        $item->$month = $total;
                    }
                }
            }
        }
        
        if ($request->hdn_report_type == "SUMMARY") {
            $pdf = PDF::loadView("admin.reports.leaves.leave-report-pdf", ['leaves' => $balance_leave])->setPaper('a4', 'landscape');;
            return $pdf->stream('leave-report.pdf');
        } else {
           return view("admin.reports.leaves.leave-report-pdf", ['leaves' => $balance_leave]);
        }
    }



}




