<?php

namespace App\Http\Controllers;

use Auth;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SupportTeamTicketController extends Controller
{
    public function __construct(){$this->middleware('auth');}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = DB::table('hrms_issue_form')->get();
        //    dd($data);
        return Template::loadview("support-team.index", compact('data'));
    }

    public function create()
    {
        return Template::loadview("support-team.create");
    }

    public function popUpCreate()
    {
        return template::loadview('support-team.create_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $id = $request->id;
        try {
            $filename=$request->image;
            if ($request->hasFile('upload_img')) {
                $destination = 'images/uploads/issue/file/'.$request->image;
                if(File::exists($destination)){
                    File::delete($destination);
                }

                $file = $request->file('upload_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/uploads/issue/file', $filename);
            }
            $sequence = DB::getSequence();
            $auth_id = Auth::id();
            $sysc_pat_no_pk_seq = $sequence->nextValue('issue_no_pk_seq') + 1;
            // dd(date('d-m-Y', strtotime($request->issue_date)));
            // dd(date('Y-m-d', strtotime($request->issue_date)));
            $data = [];
            $data = [
                // 'ISSUE_NO_PK' => $sysc_pat_no_pk_seq,
                'ISSUE_NAME' => $request->issue_name,
                'ISSUE_PERSON_NAME' => Auth::user()->user_name,
                'ISSUE_DATE' => $request->issue_date ? date('Y-m-d', strtotime($request->issue_date)) : '',
                'ISSUE_DOCUMENT' => $filename,
                'ISSUE_DESCRIPTIONS' => $request->description,
                'AU_ENTRY_AT' => date("Y-M-d H:i:s"),
                'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                'STATUS' => '0',
                'AU_ENTRY_SESSION' => 'hospital',
                // 'AU_ENTRY_BY' => $auth_id,
            ];

            if ($id == null || $id == "") {
                $data['ISSUE_NO_PK'] = $sysc_pat_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                DB::table('hrms_issue_form')->insert($data);
            } else {
                $data['au_update_by'] = $auth_id;
                DB::table('hrms_issue_form')
                    ->where('ISSUE_NO_PK', $id)
                    ->update($data);
            }
            $message = ['msg' => 'Data Saved Successfully!!', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function getAllIssueList(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $table = 'hrms_issue_form';
        $primaryKey = 'ISSUE_NO_PK';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'issue_no_pk', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'issue_name', 'dt' => 3),
            array('db' => 'issue_person_name', 'dt' => 4),
            array('db' => 'issue_descriptions', 'dt' => 5),
            array('db' => 'issue_date', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'issue_document', 'dt' => 8),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function issueSearch(Request $request){
        // dd($request->form_date , $request->to_date);
        $date_from = $request->form_date ? date('Y/m/d', strtotime($request->form_date)) : '';
        $date_to = $request->to_date ? date('Y/m/d', strtotime($request->to_date.'+ 1 Days')) : "";

        $sql_cond = "";
        $clause = ($sql_cond != "") ? "and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause au_entry_at between $date_from and $date_to " : "";



        // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $table = 'hrms_issue_form';
        $primaryKey = 'ISSUE_NO_PK';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'issue_no_pk', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'issue_name', 'dt' => 3),
            array('db' => 'issue_person_name', 'dt' => 4),
            array('db' => 'issue_descriptions', 'dt' => 5),
            array('db' => 'issue_date', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'issue_document', 'dt' => 8),
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

    }

    public function editAllSupportTeamTricketList($id)
    {
        //    dd($id);

        $data = DB::table('hrms_issue_form')
            ->where('issue_no_pk', '=', $id)
            ->first();
        // dd($data);

        return Template::loadview('support-team.create_form', compact('data'));
    }


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

    public function getSupportTeamIssueList(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $table = 'hrms_issue_form';
        $primaryKey = 'ISSUE_NO_PK';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'issue_no_pk', 'dt' => 1),
            array('db' => 'au_entry_at', 'dt' => 2),
            array('db' => 'issue_name', 'dt' => 3),
            array('db' => 'issue_person_name', 'dt' => 4),
            array('db' => 'issue_descriptions', 'dt' => 5),
            array('db' => 'issue_date', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'issue_document', 'dt' => 8),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    
    public function home(){

        $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name','wsec_user.person_no_fk')
                    ->get(); 
        return Template::loadview("admin.user_ticket.manageTicket",compact('users'));
    }


    public function getTicketById($id){

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
        return Template::loadView("admin.user_ticket.modal.update_user_ticket", ['data' => $data, 'users' => $users]);
    }

    public function getSupportTicketById($id){
        try {
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

            return response()->json(['data' => $data, 'success' => true],200);
        } catch (\Throwable $th) {
            return response()->json(['data' => '', 'success' => false], 422);
        }
    }

      
    public function getsupportTicket(Request $request){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $conditon = [
            'hrms_issue_form.au_entry_hospital_pk_no' => $hospital_pk_no,
        ];
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
                    
                    'task_vw.full_name as task_full_name',
                    'task_vw.phone_mobile as task_phone_mobile',
                    'task_vw.su_name as task_su_name',
                    'task_vw.designation as task_designation',
                    
                    'task_assigned_by_vw.full_name as task_assigned_full_name',
                    'task_assigned_by_vw.phone_mobile as task_assigned_phone_mobile',
                    'task_assigned_by_vw.su_name as task_assigned_su_name',
                    'task_assigned_by_vw.designation as task_assigned_designation',
                );

                if(!empty($request->progress)){
                    $data->where('progress_status',$request->progress);
                }
                
                if(!empty($request->employeer)){
                    $data->where('task_person_no_fk',$request->employeer);
                }
                
                if(!empty($request->from_date) && !empty($request->to_date)){
                    $from_date = date("Y-m-d", strtotime($request->from_date));
                    $to_date = date("Y-m-d", strtotime($request->to_date));
                    $data->whereRaw("to_char(hrms_issue_form.issue_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date'");
                }
                
                $data->orderBy('hrms_issue_form.progress_status','asc');
                $data = $data->get();
        return response()->json(['success' => true, 'data' => $data],200);
    }
    
    public function getsupportTicketList(){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $conditon = [
            'hrms_issue_form.au_entry_hospital_pk_no' => $hospital_pk_no,
        ];
        $data = DB::table('hrms_issue_form')->where($conditon)
                ->leftJoin('employee_info_vw','hrms_issue_form.person_no_fk','=','employee_info_vw.person_no_pk')
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
                    'employee_info_vw.phone_mobile',
                    'employee_info_vw.su_name',
                    'employee_info_vw.designation',
                );
                $data->orderBy('hrms_issue_form.progress_status','asc');
                $data = $data->get();
        return response()->json(['success' => true, 'data' => $data],200);
    }

    public function updateTicket(Request $request){
        $request->validate([
            'issue_no_pk' => 'required',
            'progress_modal' => 'required'
        ]);
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $person_no_pk = Session()->get('user.ses_person_no_fk');
            
            $feedback = str_replace("'", "", $request->feedback);
            $data = [
                'progress_status'=> $request->progress_modal,
                'feedback' => $feedback,
                'task_assigned_by' => $person_no_pk,
                'task_assigned_at' => $au_entry_at,
                'task_person_no_fk' => $request->users_modal,
                'task_notes' => $request->notes_modal,
                'priority_type_no' => $request->priority_modal,
                'task_assigned_ind' => empty($request->users_modal) ? 0 : 1,
            ];
            DB::table('hrms_issue_form')->where('issue_no_pk',$request->issue_no_pk)->update($data);
            return response()->json(['success' => true, 'title' => 'Success', 'msg' => 'Successfully Updated'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage(), 'title' => 'Error'],422);
        }
    }
}