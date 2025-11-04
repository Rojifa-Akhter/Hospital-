<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeTaskController extends Controller
{
    public function index(){
        $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name','wsec_user.person_no_fk')
                    ->get(); 
        return Template::loadview("admin.user_ticket.employeeManageTask",compact('users'));
    }

    public function getEmloyeeTask(Request $request){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $conditon = [
            'hrms_issue_form.au_entry_hospital_pk_no' => $hospital_pk_no,
        ];
        $person_no_fk = Session()->get('user.ses_person_no_fk');
        $data = DB::table('hrms_issue_form')->where($conditon)
                ->leftJoin('employee_info_vw','hrms_issue_form.person_no_fk','=','employee_info_vw.person_no_pk')
                ->leftJoin('employee_info_vw as task_vw','hrms_issue_form.task_person_no_fk','=','task_vw.person_no_pk')
                ->leftJoin('employee_info_vw as task_assigned_by_vw','hrms_issue_form.task_assigned_by','=','task_assigned_by_vw.person_no_pk')
                ->select(
                    'hrms_issue_form.issue_no_pk',
                    'hrms_issue_form.issue_code',
                    'hrms_issue_form.issue_name',
                    'hrms_issue_form.issue_person_name',
                    'hrms_issue_form.issue_date',
                    'hrms_issue_form.issue_document',
                    'hrms_issue_form.issue_descriptions',
                    'hrms_issue_form.status',
                    'hrms_issue_form.feedback',
                    'hrms_issue_form.progress_status',
                    'employee_info_vw.phone_mobile',
                    'employee_info_vw.su_name',
                    'employee_info_vw.designation',
                    'employee_info_vw.photo_name',
                    'hrms_issue_form.task_assigned_at',
                    'hrms_issue_form.priority_type_no',
                    'task_vw.full_name as task_full_name',
                    'task_vw.phone_mobile as task_phone_mobile',
                    'task_vw.su_name as task_su_name',
                    'task_vw.designation as task_designation',
                    'task_assigned_by_vw.full_name as task_assigned_full_name',
                    'task_assigned_by_vw.phone_mobile as task_assigned_phone_mobile',
                    'task_assigned_by_vw.su_name as task_assigned_su_name',
                    'task_assigned_by_vw.designation as task_assigned_designation',
                    'task_assigned_by_vw.photo_name as task_assigned_photo',
                )->where('hrms_issue_form.task_person_no_fk',$person_no_fk);

                if(!empty($request->progress)){
                    $data->where('progress_status',$request->progress);
                }
                
                if(!empty($request->employeer)){
                    $data->where('task_person_no_fk',$request->employeer);
                }
                
                if(!empty($request->from_date) && !empty($request->to_date)){
                    $from_date = date("Y-m-d", strtotime($request->from_date));
                    $to_date = date("Y-m-d", strtotime($request->to_date));
                    $data->whereRaw("to_char(hrms_issue_form.task_assigned_at, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date'");
                }
                
                $data->orderBy('hrms_issue_form.progress_status','asc');
                $data = $data->get();
        return response()->json(['success' => true, 'data' => $data],200);
    }


    public function getEmployeeTaskById($id){

        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        
        $conditon = [
            'hrms_issue_form.au_entry_hospital_pk_no' => $hospital_pk_no,
        ];
        
        $data = DB::table('hrms_issue_form')->where($conditon)
                ->leftJoin('employee_info_vw as employee_vw','hrms_issue_form.person_no_fk','=','employee_vw.person_no_pk')
                ->leftJoin('employee_info_vw as task_vw','hrms_issue_form.task_person_no_fk','=','task_vw.person_no_pk')
                ->leftJoin('employee_info_vw as task_assigned_by_vw','hrms_issue_form.task_assigned_by','=','task_assigned_by_vw.person_no_pk')
                ->select(
                    'hrms_issue_form.issue_no_pk',
                    'hrms_issue_form.issue_name',
                    'hrms_issue_form.issue_person_name',
                    'hrms_issue_form.issue_date',
                    'hrms_issue_form.issue_document',
                    'hrms_issue_form.issue_descriptions',
                    'hrms_issue_form.status',
                    'hrms_issue_form.feedback',
                    'hrms_issue_form.progress_status',
                    'hrms_issue_form.priority_type_no',
                    'hrms_issue_form.task_person_no_fk',
                    'hrms_issue_form.task_assigned_ind',
                    'hrms_issue_form.task_notes',
                    'hrms_issue_form.task_assigned_by',
                    'hrms_issue_form.task_assigned_at',
                    'employee_vw.phone_mobile',
                    'employee_vw.su_name',
                    'employee_vw.designation',              
                    'task_vw.full_name as task_full_mobile',
                    'task_vw.phone_mobile as task_phone_mobile',
                    'task_vw.su_name as task_su_name',
                    'task_vw.designation as task_designation',
                    'task_assigned_by_vw.full_name as task_assigned_full_name',
                    'task_assigned_by_vw.phone_mobile as task_assigned_phone_mobile',
                    'task_assigned_by_vw.su_name as task_assigned_su_name',
                    'task_assigned_by_vw.designation as task_assigned_designation',
                );
                
                $data->where('hrms_issue_form.issue_no_pk',$id);
                $data->orderBy('hrms_issue_form.progress_status','asc');
                $data = $data->first();

                $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name','wsec_user.person_no_fk')
                    ->get(); 
        return Template::loadView("admin.user_ticket.modal.update_employee_task", ['data' => $data, 'users' => $users]);
    }

    public function updateEmployeeTask(Request $request){
        $request->validate([
            'issue_no_pk' => 'required',
            'progress_modal' => 'required'
        ]);
        try {
            $au_entry_at  = Carbon::now();
            $au_entry_at  = $au_entry_at->toDateString();
            $person_no_pk = Session()->get('user.ses_person_no_fk');
            
            $feedback = str_replace("'", "", $request->feedback);
            $data = [
                'progress_status'=> $request->progress_modal,
                'task_notes' => $request->notes,
            ];
            DB::table('hrms_issue_form')->where('issue_no_pk',$request->issue_no_pk)->update($data);
            return response()->json(['success' => true, 'title' => 'Success', 'msg' => 'Successfully Updated'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(), 'title' => 'Error'],422);
        }
    }
}