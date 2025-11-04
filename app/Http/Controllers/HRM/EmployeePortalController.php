<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Designation;
use App\Models\ServiceUnit;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Session;
use PDF;
use App\Models\Leave;
use App\Models\LeaveChild;
use Redirect;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
class EmployeePortalController extends Controller
{
	use UtilitiesTrait, LookupData;
	use DatatablesLoader;
	protected $model;
	public function __construct(Leave $leave, LeaveChild $LeaveChild)
	{
		$this->middleware('auth');

		$this->model = new Repo($leave);
		$this->model2 = new Repo($LeaveChild);
	}

	public function employeePortal()
	{
		$i = auth::user()->user_no_pk;
		$ii = auth::user()->person_no_fk;	
		if ( Session::get('user.ses_hospital_code') == 'DMHL') {
			$alternativeDates = DB::select("select attendance_date, in_time, out_time from  hrms_attendance_daily att where in_time is not null and out_time is not null and person_no_fk = '$ii' and not exists (select 1 from  HRMS_LEAVE_ENTRY ad where ad.person_no_fk=att.person_no_fk and trunc(att.attendance_date) =trunc(AL_DAYOFF_DATE)) and attendance_status in (7 ,6)") ;
		}else{
			$alternativeDates = DB::select("select attendance_date, in_time, out_time from  hrms_attendance_daily att where in_time is not null and out_time is not null and person_no_fk = '$ii' and not exists (select 1 from  HRMS_LEAVE_ENTRY ad where ad.person_no_fk=att.person_no_fk and trunc(att.attendance_date) =trunc(AL_DAYOFF_DATE)) and attendance_status in (7 ,6) and trunc (att.attendance_date) between trunc (sysdate - 90) and trunc(sysdate)") ;
		}

		$data = DB::table('hrms_personnel as person')
			->leftJoin('wsec_user', 'wsec_user.person_no_fk', '=', 'person.person_no_pk')
			// ->leftJoin('sysc_serviceunit as u', 'u.serviceunit_no_pk', '=', 'person.serviceunit_no_fk')
			->leftJoin('hrms_personnel as hod_01', 'hod_01.person_no_pk', '=', 'person.emp_hod1_person_no_fk')
			->leftJoin('hrms_personnel as hod_02', 'hod_02.person_no_pk', '=', 'person.emp_hod2_person_no_fk')
			->leftJoin('hrms_personnel as supvisor_1', 'supvisor_1.person_no_pk', '=', 'person.emp_supvisor1_person_no_fk')
			->leftJoin('hrms_personnel as supvisor_2', 'supvisor_2.person_no_pk', '=', 'person.emp_supvisor2_person_no_fk')
			->select('person.person_no_pk', 'person.person_code', 'person.salutation', 'person.full_name', 'person.fname', 'person.lname', 'person.dob', 'person.email_personal', 'person.join_date', 'person.confirmation_date', 'person.photo_name', 'person.bank_acc_no', 'person.bank_name', 'person.bank_acc_name', 'person.leave_category_lookup_no_fk', 'wsec_user.person_no_fk',
			'hod_01.full_name as hod_01_name', 'hod_01.person_code as hod_01_card_no', 'hod_02.full_name as hod_02_name', 'hod_02.person_code as hod_02_card_no', 'supvisor_1.full_name as supvisor_1_name', 'supvisor_1.person_code as supvisor_1_card_no', 'supvisor_2.full_name as supvisor_2_name', 'supvisor_2.person_code as supvisor_2_card_no',
			DB::raw('fnc_serviceunitname(person.serviceunit_no_fk) as unit'),
			DB::raw('fnc_serviceunitname(person.serviceunit_no_fk_dept) as dept')
			)
			->where('wsec_user.person_no_fk', $ii)
			->first();
		$alterLeaveName = DB::select("select leave_type_lkp_name,leavetypedays_no_pk, leave_type_lkp_no_fk from hrms_leavetype_days where leave_code='AD'");
	
		$education_data = DB::table('hrms_personnel_education')
			->select('hrms_personnel_education.education_no_pk', 'hrms_personnel_education.degree_name', 'hrms_personnel_education.person_no_fk', 'hrms_personnel_education.board_university', 'hrms_personnel_education.institute_name', 'hrms_personnel_education.passing_year', 'hrms_personnel_education.result_text', 'hrms_personnel_education.major_sub_or_gr', 'hrms_personnel_education.education_cert_url')
			->where('hrms_personnel_education.person_no_fk', $i)
			->get();

		$training_info = DB::table('hrms_personnel_cert_tr')
			->select('cert_tr_no_pk', 'person_no_fk', 'cert_tr_tittle', 'institute_name', 'emp_from_date', 'emp_to_date', 'certification_date', 'tr_cert_file', 'tr_cert_url', 'training_duration')
			->where('person_no_fk', $i)
			->get();

		$experience_info = DB::table('hrms_personnel_experience')
			->select('experience_no_pk', 'person_no_fk', 'company_name', 'designation_name', 'emp_from_date', 'emp_to_date')
			->where('person_no_fk', $i)
			->get();

		$nominee_info = DB::table('hrms_nominee_info')
			->select('nominee_info_pk', 'person_no_fk', 'nominee_name', 'nominee_nid', 'nominee_dob', 'relationship', 'photo')
			->where('person_no_fk', $i)
			->get();

		$dependent_info = DB::table('hrms_dependent_info')
			->select('dependent_info_pk', 'person_no_fk', 'dependent_name', 'dependent_nid', 'dependent_dob', 'relationship', 'photo')
			->where('person_no_fk', $i)
			->get();

		$leave_cate_id = DB::table('hrms_personnel')
			->leftJoin('wsec_user', 'wsec_user.person_no_fk', '=', 'hrms_personnel.person_no_pk')
			// ->leftJoin('wsec_user', 'wsec_user.person_no_fk', '=', 'hrms_personnel.person_no_pk')
			->select('hrms_personnel.leave_category_lookup_no_fk')
			->where('wsec_user.user_no_pk', $i)
			->first();

		$user_info = Auth::user();

		if (!empty($leave_cate_id)) {
			$leaveCategoryLookupNo = $leave_cate_id->leave_category_lookup_no_fk;

				 $leave_type = DB::table('hrms_personal_leave_vw')
			 	->select('leave_type_lkp_name', 'leave_type_lkp_no_fk', 'balance',DB::raw('NO_OF_DAYS - LEAVE no_of_days'))
			 	->where('person_no_pk', $user_info->person_no_fk)
				->whereRaw('no_of_days - leave > 0')
				 ->get();

		}
		$session = Session::get('user.ses_hospital_no_pk');
		$leave_status = DB::select("select a.leave_code,a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at, count(b.leavedtl_no_pk) total_days
        from hrms_leave_entry a,hrms_leave_entrydtl b, sysc_lookupdata c
        where a.leave_no_pk=b.leave_no_fk and a.leave_type_lkp_no_fk=c.lookupdata_no_pk and b.leave_status!=2 and a.person_no_fk=$user_info->person_no_fk
        and a.au_entry_hospital_pk_no = $session group by a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at ,a.leave_code  ORDER BY a.au_entry_at DESC");

		$requested_leave = DB::table('hrms_leave_entry_for_approval_vw')
			// ->where('approval_level_status_text', '!=', '2/2')
			->where('approved_ind', '!=', 1)
			->where('person_no_fk', $user_info->person_no_fk)
			->count();

		$info = DB::table('hrms_personal_leave_vw')
		->where('person_no_pk', $user_info->person_no_fk)
		->get();
		$alternativeLeaveinfo = DB::table('hrms_aldayoff_vw')
		->where('person_no_fk', $user_info->person_no_fk)
		->get();
		$leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
			->leftJoin('hrms_leave_entry', 'a.leave_no_pk', 'hrms_leave_entry.leave_no_pk')
			->select('a.*', 'hrms_leave_entry.leave_attch', 'hrms_leave_entry.manual_lv_ind')
			->where('a.person_no_fk', $user_info->person_no_fk)
			->orderBy('a.leave_no_pk', 'desc')
			->get();

		$card_no = $user_info->user_code; 

		$attend_data = DB::select("select nvl(trunc(man.attendance_date),trunc(mac.check_time)) att_date, case when trunc(man.attendance_date)  is not null then min(to_date(to_char(trunc(man.attendance_date) ,'yyyymmdd') ||  to_char(man.in_time,'hh24:mi:ss'),'yyyymmddhh24:mi:ss')  )
        else  min(mac.check_time) end in_time, case when trunc(man.attendance_date) is not null then max(to_date(to_char(trunc(man.attendance_date) ,'yyyymmdd') ||  to_char(man.out_time,'hh24:mi:ss'),'yyyymmddhh24:mi:ss')  ) else case when  min(mac.check_time) =max(mac.check_time) then
        null else max(mac.check_time) end end out_time,att_edit.req_date, att_edit.requsition_no_pk, att_edit.REQUSITION_NO_PK primary_key_value, 
         case when att_edit.APP_STATUS =1 then 'Approved' when att_edit.APP_STATUS =2 then 'Rejected' else 'Pending' end level_status_text 
		from hrms_check_in_out mac full outer join hrms_attendance_daily_manual man
        on mac.card_no=man.person_card_no and trunc(mac.check_time)=trunc(man.attendance_date)
        LEFT JOIN hrms_attendance_requsition att_edit
        ON att_edit.person_card_no = mac.card_no
        AND TRUNC (mac.check_time) = TRUNC (att_edit.attendance_date)
        where nvl(trunc(man.attendance_date), TRUNC(mac.check_time)) BETWEEN TRUNC(SYSDATE)-6  AND TRUNC(SYSDATE)
        and nvl(man.person_card_no ,mac.card_no )= :card_no    
        group by trunc(mac.check_time), trunc(man.attendance_date),att_edit.req_date, att_edit.requsition_no_pk,
		case when att_edit.APP_STATUS =1 then 'Approved' when att_edit.APP_STATUS =2 then 'Rejected' else 'Pending' end order by att_date desc", ['card_no' => $card_no]);

		$user_info = Auth::user();
		$card_no = $user_info->user_code;

		$manual_attendance_data = DB::table('hrms_attendance_requsition a')
			->select('a.requsition_no_pk', 'a.req_date', 'a.person_card_no', 'a.attendance_date', 'a.in_time', 'a.out_time', 'a.remarks', 'a.manual_ind', 'a.app_status')
			// ->leftJoin('sysc_approvalprocess_vw', 'a.requsition_no_pk', '=', 'sysc_approvalprocess_vw.primary_key_value')
			->where('a.person_card_no', $card_no)
			->where('a.manual_ind', 1)
			->where('a.req_date', '>=', DB::raw('sysdate - 7'))
			->distinct('a.requsition_no_pk')
			->get();

		return Template::loadView('admin.v1.hrm.employee_portal.employee-portal', ['data' => $data, 'education_data' => $education_data, 'training_info' => $training_info, 'experience_info' => $experience_info, 'nominee_info' => $nominee_info, 'dependent_info' => $dependent_info, 'leave_type' => $leave_type, 'leave_status' => $leave_status, 'leave_data' => $leave_data, 'requested_leave' => $requested_leave, 'info'=>$info, 'attend_data'=>$attend_data, 'manual_attendance_data'=>$manual_attendance_data, 'alternativeLeaveinfo' => $alternativeLeaveinfo, 'alterLeaveName' => $alterLeaveName, 'alternativeDates' => $alternativeDates]);
	}


		public function myAttendanceSearchV1(Request $request){
			$user_info = Auth::user();
			$card_no = $user_info->user_code; 

			if ($request->search_date_from && $request->search_date_to) {
				
				$attend_data = DB::select("select nvl(trunc(man.attendance_date),trunc(mac.check_time)) att_date, case when trunc(man.attendance_date)  is not null then min(to_date(to_char(trunc(man.attendance_date) ,'yyyymmdd') ||  to_char(man.in_time,'hh24:mi:ss'),'yyyymmddhh24:mi:ss')  )
				else  min(mac.check_time) end in_time, case when trunc(man.attendance_date) is not null then max(to_date(to_char(trunc(man.attendance_date) ,'yyyymmdd') ||  to_char(man.out_time,'hh24:mi:ss'),'yyyymmddhh24:mi:ss')  ) else case when  min(mac.check_time) =max(mac.check_time) then
				null else max(mac.check_time) end end out_time,att_edit.req_date, att_edit.requsition_no_pk, att_edit.REQUSITION_NO_PK primary_key_value, 
				 case when att_edit.APP_STATUS =1 then 'Approved' when att_edit.APP_STATUS =2 then 'Rejected' else 'Pending' end level_status_text 
				from hrms_check_in_out mac full outer join hrms_attendance_daily_manual man
				on mac.card_no=man.person_card_no and trunc(mac.check_time)=trunc(man.attendance_date)
				LEFT JOIN hrms_attendance_requsition att_edit
				ON att_edit.person_card_no = mac.card_no
				AND TRUNC (mac.check_time) = TRUNC (att_edit.attendance_date)
				where nvl(trunc(man.attendance_date), TRUNC(mac.check_time)) between  to_date('$request->search_date_from', 'dd/mm/yyyy')  and to_date('$request->search_date_to', 'dd/mm/yyyy')
				and nvl(man.person_card_no ,mac.card_no )= :card_no    
				group by trunc(mac.check_time), trunc(man.attendance_date),att_edit.req_date, att_edit.requsition_no_pk,
				case when att_edit.APP_STATUS =1 then 'Approved' when att_edit.APP_STATUS =2 then 'Rejected' else 'Pending' end order by att_date desc", ['card_no' => $card_no]);
				
			}
			return Template::loadView('admin.v1.hrm.employee_portal.my-attendance-list-search-table', ['attend_data'=>$attend_data]);
		}

		public function editMyAttendance($requsition_no_pk = ""){
			$param = explode("*", $requsition_no_pk);
		
			$attendance_date = $param[0];      
			$in = $param[1];                     
			$out = $param[2];                    
			$requsition_no_pk = $param[3];
			
			$previous =  DB::table('hrms_attendance_requsition')
			->select('hrms_attendance_requsition.*')
			->where('hrms_attendance_requsition.requsition_no_pk', $requsition_no_pk)
			->first();

			return Template::loadView('admin.v1.hrm.employee_portal.edit-my-attendance', ['attendance_date'=>$attendance_date, 'in'=>$in, 'out'=>$out, 'requsition_no_pk'=>$requsition_no_pk, 'previous'=>$previous]);
		}

		public function saveMyLateAttendance(Request $request){
			$sequence = DB::getSequence();
			try {
			    $user_info = Auth::user();
				$card_no = $user_info->user_code;
				$entry_session = Session()->get('user.ses_user_pk_no');
				$req_date = date('Y-m-d');
				$attendance_date = $request->attendance_date != '' ? date('Y-m-d', strtotime($request->attendance_date)) : '';
				$in_time = $request->in_time ? date('Y-m-d H:i', strtotime($request->attendance_date . ' ' . $request->in_time)) : '';
				$out_time = $request->out_time ? date('Y-m-d H:i', strtotime($request->attendance_date . ' ' . $request->out_time)) : '';

				$data = [
					'req_date' => $req_date,
					'person_no_fk' => $user_info->person_no_fk,
					'person_card_no' => $card_no,
					'attendance_date' => $attendance_date,
					'in_time'  => $in_time,
					'out_time' => $out_time,
					'remarks'  => $request->remarks ? $request->remarks : '',
					'au_entry_by' => auth::user()->user_no_pk,
					'au_entry_at' => date('Y-m-d'),
					'au_entry_session' => $entry_session,
					'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
				];

				if (empty($request->req_no_pk)) {
					$requsition_no_pk = $sequence->nextValue('att_requsition_no_pk');
					$data['requsition_no_pk'] = $requsition_no_pk;
					DB::table("hrms_attendance_requsition")->insert($data);
                }else{
					$requsition_no_pk = $request->req_no_pk;
					$data['au_update_by'] = auth::user()->user_no_pk;
					$data['au_update_at'] = date('Y-m-d');
					$data['au_update_session'] = $entry_session;
					$data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
					DB::table("hrms_attendance_requsition")->where('requsition_no_pk', $request->req_no_pk)->update($data);
				}
			
				if (!empty($request->req_no_pk)) {
					$check_pervious = DB::select("select count(*) num from SYSC_APPROVALPROCESS_VW where APPROVAL_FOR_CODE='ATTNREQ'
				    and PRIMARY_KEY_VALUE=$request->req_no_pk");
					
				}
				if (!empty($check_pervious) && $check_pervious[0]->num > 1) {
					DB::update("update SYSC_APPROVALPROCESS set REMARKS=:remarks where APPROVAL_FOR_CODE='ATTNREQ' and PRIMARY_KEY_VALUE= :req_no_pk",
						['remarks' => $request->remarks.'||'.  ' Attendance Date:' . $attendance_date . '||'. ' In time:' . $in_time . '||' .' Out time:' . $out_time, 'req_no_pk' => $request->req_no_pk]);
				}else{
					$ses_hospital_id  = Session::get('user.ses_hospital_no_pk');
					$au_entry_by      = auth::user()->user_no_pk;
					$au_entry_session = Session()->get('user.ses_user_pk_no');
					$code = 'ATTNREQ';
					$pdo = DB::getPdo();
					$rem = $request->remarks. '||' . ' Attendance Date:' . $attendance_date . '||'. ' In time:' . $in_time . '||' .' Out time:' . $out_time;
					$out_apprprocess_no_pk = $out_apprprocess_uid = $out_error = '';
					$in_primary_key_uid = $requsition_no_pk;
					$leave_appllication = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
						:in_approval_for_code,
						:in_primary_key_value,
						:in_primary_key_uid,
						:in_remarks,
						:in_au_entry_by,
						:in_au_entry_session,
						:in_au_entry_hospital_pk_no,
						:out_apprprocess_no_pk,
						:out_apprprocess_uid,
						:out_error
					); end;");
		
					$leave_appllication->bindParam(':in_approval_for_code', $code);
					$leave_appllication->bindParam(':in_primary_key_value', $requsition_no_pk);
					$leave_appllication->bindParam(':in_primary_key_uid', $in_primary_key_uid);
					$leave_appllication->bindParam(':in_remarks', $rem);
					$leave_appllication->bindParam(':in_au_entry_by', $au_entry_by);
					$leave_appllication->bindParam(':in_au_entry_session', $au_entry_session);
					$leave_appllication->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
					$leave_appllication->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
					$leave_appllication->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 100000);
					$leave_appllication->bindParam(':out_error', $out_error, PDO::PARAM_STR, 100000);
					$leave_appllication->execute();
				}
				
				DB::commit();
				$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			} catch (\Exception $th) {
				DB::rollback();
				$message = ['msg' => $th->getMessage(), 'title' => 'Error'];
			}
			return response()->json($message);
		}
		
	public function storeLeaveApplication(Request $request){

		$leave_name = explode('-', $request->leave_name);
		$from_year = date('Y', strtotime($request->from_date));
		$to_year = date('Y', strtotime($request->to_date));
		if ($from_year != $to_year) {
			$message = ['msg' => 'You can not apply for different year !!', 'title' => 'Error'];
			return response()->json($message);
		}

		$from = \Carbon\Carbon::parse($request->from_date);
		$to = \Carbon\Carbon::parse($request->to_date);
		if ($from->gt($to)) {
			$message = ['msg' => 'Day From can not be greater than Day To !!', 'title' => 'Error'];
			return response()->json($message);
		}
		
		$pending_leave_check = DB::table('hrms_leave_entry')
						->select('leave_code')
						->where('leave_type_lkp_no_fk', $leave_name[0])
						->whereRaw("TO_CHAR(FROM_DATE, 'YYYY') = ?", [$from_year])
						->where('person_no_fk', $request->person_no_pk)
						->where('status', '1')
						->where('approved_ind', '0')
						->where('reject_ind', '0')
						->where('hold_ind', '0')
						->first();
	
		if (isset($pending_leave_check)) {
			$message = ['msg' => 'In pending list this leave type is already exist. After apporving you can apply again !!', 'title' => 'Error'];
			return response()->json($message);
		}		

		$leave      = DB::table('hrms_leavetype_days')
						->select('leave_code')
						->where('leave_type_lkp_no_fk', $leave_name[0])
						->first();
		$validatedData = $request->validate([
			'leave_name' => 'required',
		]);

		$id             = $request->id;
		$hostpital      = Session::get('user.ses_hospital_no_pk');
		$sequence       = DB::getSequence();
		$sysc_leave_seq = $sequence->nextValue('leave_no_pk_seq');
		$auth_id        = Auth::id();
		DB::beginTransaction();
		
		try {
			$data = [
				'leave_no_pk'              => $sysc_leave_seq,
				'leave_code'               => $leave->leave_code,
				'person_no_fk'             => $request->person_no_pk,
				'leave_type_lkp_no_fk'     => $leave_name[0],
				'from_date'                => $request->from_date ? date('Y-M-d', strtotime($request->from_date)) : "",
				'to_dates'                 => $request->to_date ? date('Y-M-d', strtotime($request->to_date)) : "",
				'leave_reason'             => $request->leave_reason,
				'status'                   => 1,
				'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
				'leave_for_extra_duty'     => ($request->extra_duty_on) ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
				'au_entry_session'         => 'session',
				'au_entry_hospital_pk_no'  => $hostpital,
			];

			if ($id == "") {
				$user_info = Auth::user();
				$existingDates = DB::table('hrms_leave_entrydtl')
				->leftJoin('hrms_leave_entry', 'hrms_leave_entrydtl.leave_no_fk', 'hrms_leave_entry.leave_no_pk')
				->where('hrms_leave_entry.person_no_fk', $user_info->person_no_fk)
				->where(function($query) use ($request) {
					$query->whereBetween('leave_dates', [
						date('Y-M-d', strtotime($request->from_date)),
						date('Y-M-d', strtotime($request->to_date))
					]);
				})->count();
			
				if ($existingDates > 0) {
					$message = ['msg' => 'Leave dates already exist !!', 'title' => 'Error'];
					return response()->json($message);
				}

				if (isset($request->leave_file)) {
					$fileName = time() . '.' . $request->leave_file->extension();
					$request->leave_file->move(public_path('uploads/leave_file/'), $fileName);
					$data['leave_attch'] = $fileName;
				}else{
					$data['leave_attch'] = '';
				}
				// remarks
				$date = new Carbon($request->from_date);
				$end_date = new Carbon($request->to_date);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate = date("Y-M-d", strtotime($end_date->toDateString()));
				$period = CarbonPeriod::create($startDate, $endDate);
				$totalDays = $period->count();

				if ($totalDays > $leave_name[2]) {
					$message = ['msg' => 'Leave balance is insufficient !!', 'title' => 'Error'];
				    return response()->json($message);
				} else {
					if ($leave_name[1] == 'Casual Leave' && $totalDays >3) {
						$message = ['msg' => 'Casual leave is not allowed for more than 3 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
	
					if ($leave_name[1] == 'Earned Leave' && $totalDays >5) {
						$message = ['msg' => 'Casual leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
					
					if ($leave_name[1] == 'Paternity Leave' && $totalDays >5) {
						$message = ['msg' => 'Paternity leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
				}
				
				$data['au_entry_by'] = $auth_id;
				$response = $this->model->create($data);
				$last_id = $response->leave_no_pk;

				foreach ($period as $key => $date) {
					$selected_date = date("Y-M-d", strtotime($date->toDateString()));
					$sequence = DB::getSequence();
					$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
					$child_table = [
						'leavedtl_no_pk'          => $leavedtl_no_pk,
						'leave_no_fk'             => $last_id,
						// 'leave_type_lkp_no_fk' => $request->leave_name,
						'leave_type_lkp_no_fk'    => $leave_name[0],
						'leave_dates'             => $selected_date,
						'leave_reason'            => $request->leave_reason,
						'leave_status'            => 1,
						'status'                  => 1,
						'au_entry_session'        => 'session',
						'au_entry_hospital_pk_no' => $hostpital,
						'au_entry_by'             => $auth_id,
					];

					$child_table['au_entry_at'] = date("Y-m-d");
					DB::table('hrms_leave_entrydtl')->insert($child_table);
				}
			} else {
				$date      = new Carbon($request->from_date);
				$end_date  = new Carbon($request->to_date);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate   = date("Y-M-d", strtotime($end_date->toDateString()));
				$period    = CarbonPeriod::create($startDate, $endDate);
				$totalDays = $period->count();

					$updateData = [
						// 'leave_type_lkp_no_fk'  => $request->leave_name,
						'leave_type_lkp_no_fk'     => $leave_name[0],
						'from_date'                => $request->from_date ? date('Y-M-d', strtotime($request->from_date)) : "",
						'to_dates'                 => $request->to_date ? date('Y-M-d', strtotime($request->to_date)) : "",
						'leave_reason'             => $request->leave_reason,
						'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
						'leave_for_extra_duty'     => $request->extra_duty_on ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
					];
					$updateData['au_update_by']    = $auth_id;

					if (isset($request->leave_file1)) {
						$fileName1 = time() . '.' . $request->leave_file1->extension();
						$request->leave_file1->move(public_path('uploads/leave_file/'), $fileName1);
						$updateData['leave_attch'] = $fileName1;
					}

					if ($totalDays > $leave_name[2]) {
						$message = ['msg' => 'Leave balance is insufficient!!', 'title' => 'Error'];
						return response()->json($message);
					} else {

					if ($leave_name[1] == 'Casual Leave' && $totalDays >3) {
						$message = ['msg' => 'Casual leave is not allowed for more than 3 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
	
					if ($leave_name[1] == 'Earned Leave' && $totalDays >5) {
						$message = ['msg' => 'Casual leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}

					if ($leave_name[1] == 'Paternity Leave' && $totalDays >5) {
						$message = ['msg' => 'Paternity leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
				  }

					$this->model->update($updateData, $id);
	
					// child table delete and insert
					DB::table('hrms_leave_entrydtl')->where('leave_no_fk', $id)->delete();
	
					foreach ($period as $key => $date) {
						$selected_date  = date("Y-M-d", strtotime($date->toDateString()));
						$sequence       = DB::getSequence();
						$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
						$child_table = [
							'leavedtl_no_pk' => $leavedtl_no_pk,
							'leave_no_fk' => $id,
							// 'leave_type_lkp_no_fk' => $request->leave_name,
							'leave_type_lkp_no_fk'    => $leave_name[0],
							'leave_dates'             => $selected_date,
							'leave_reason'            => $request->leave_reason,
							'leave_status'            => 1,
							'status'                  => 1,
							'au_entry_session'        => 'session',
							'au_entry_hospital_pk_no' => $hostpital,
							'au_entry_by'             => $auth_id,
						];
	
						$child_table['au_entry_at'] = date("Y-m-d");
						DB::table('hrms_leave_entrydtl')->insert($child_table);
					}
			}

			if ($id == "") {
				$approval_id = $last_id;
			}else{
				$approval_id = $id;
			}

			if (!empty($approval_id)) {
				$check_pervious = DB::select("select count(*) num from SYSC_APPROVALPROCESS_VW where APPROVAL_FOR_CODE='LEAVEAPP'
				and PRIMARY_KEY_VALUE=$approval_id");
			}

			if ($totalDays >1) {
				$total = $totalDays . ' Days';
			}else{
				$total = $totalDays . ' Day';
			}

			if (!empty($check_pervious) && $check_pervious[0]->num > 0) {

				$from_date_formatted = !empty($request->from_date) ? date('Y-M-d', strtotime($request->from_date)) : '';
				$to_dates_formatted  = !empty($request->to_date) ? date('Y-M-d', strtotime($request->to_date)) : '';

				$remarks = $request->leave_reason . ' | ' . $leave_name[1] . ' | ' . $total . ' | ' .
			               'From: ' . $from_date_formatted . ' To: ' . $to_dates_formatted . ' ' .
			               'Assigned to - ' . $request->search_employee_code;
				// DB::update("update SYSC_APPROVALPROCESS set REMARKS=:remarks where APPROVAL_FOR_CODE='LEAVEAPP' and PRIMARY_KEY_VALUE= :leave_no_pk",
				// 	['remarks' => $request->leave_reason . ' | ' . $leave_name[1] . ' | ' . $total . ' | ' . ' From: ' . date('Y-M-d', strtotime($request->from_date)) . ' To: ' . date('Y-M-d', strtotime($request->to_dates)) . ' Assigned to - ' . $request->search_employee_code, 'leave_no_pk' => $approval_id]);
				// dd($remarks);
				DB::update("UPDATE SYSC_APPROVALPROCESS SET REMARKS = :remarks WHERE APPROVAL_FOR_CODE = 'LEAVEAPP' AND PRIMARY_KEY_VALUE = :leave_no_pk",
               ['remarks' => $remarks, 'leave_no_pk' => $approval_id]);

			}else {
				$ses_hospital_id  = Session::get('user.ses_hospital_no_pk');
				$au_entry_by      = auth::user()->user_no_pk;
				$au_entry_session = Session()->get('user.ses_user_pk_no');
				$code             = 'LEAVEAPP';
				$pdo              = DB::getPdo();

				$from_date_formatted = !empty($request->from_date) ? date('Y-M-d', strtotime($request->from_date)) : '';
				$to_dates_formatted  = !empty($request->to_date) ? date('Y-M-d', strtotime($request->to_date)) : '';

				$rem = $request->leave_reason . ' | ' . $leave_name[1] . ' | ' . $total . ' | ' .
			           'From: ' . $from_date_formatted . ' To: ' . $to_dates_formatted . ' ' .
			           'Assigned to - ' . $request->search_employee_code;
				$out_apprprocess_no_pk = $out_apprprocess_uid = $out_error = '';
				
				$leave_appllication = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
					:in_approval_for_code,
					:in_primary_key_value,
					:in_primary_key_uid,
					:in_remarks,
					:in_au_entry_by,
					:in_au_entry_session,
					:in_au_entry_hospital_pk_no,
					:out_apprprocess_no_pk,
					:out_apprprocess_uid,
					:out_error
				); end;");
	
				$leave_appllication->bindParam(':in_approval_for_code', $code);
				$leave_appllication->bindParam(':in_primary_key_value', $approval_id);
				$leave_appllication->bindParam(':in_primary_key_uid', $approval_id);
				$leave_appllication->bindParam(':in_remarks', $rem);
				$leave_appllication->bindParam(':in_au_entry_by', $au_entry_by);
				$leave_appllication->bindParam(':in_au_entry_session', $au_entry_session);
				$leave_appllication->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
				$leave_appllication->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
				$leave_appllication->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 100000);
				$leave_appllication->bindParam(':out_error', $out_error, PDO::PARAM_STR, 100000);
				$leave_appllication->execute();
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message, 200);
		} catch (\Exception $e) {
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
			return response()->json($message, 422);
		}
		
	}
	
	public function storeAlternativeLeaveApplication(Request $request){

		$leave_name = explode('-', $request->leave_name);
		$leave      = DB::table('hrms_leavetype_days')
					->select('leave_code')
					->where('leave_type_lkp_no_fk', $leave_name[0])
					->first();
		
		$validatedData = $request->validate([
			'leave_name' => 'required',
		]);

		$id             = $request->id;
		$hostpital      = Session::get('user.ses_hospital_no_pk');
		$sequence       = DB::getSequence();
		$sysc_leave_seq = $sequence->nextValue('leave_no_pk_seq');
		$auth_id        = Auth::id();
		DB::beginTransaction();
		try {
			$data = [
				'leave_no_pk'              => $sysc_leave_seq,
				'leave_code'               => $leave->leave_code,
				'person_no_fk'             => $request->person_no_pk,
				'leave_type_lkp_no_fk'     => $leave_name[0],
				'from_date'                => $request->altFromDate ? date('Y-M-d', strtotime($request->altFromDate)) : "",
				'to_dates'                 => $request->altFromDate ? date('Y-M-d', strtotime($request->altFromDate)) : "",
				'leave_reason'             => $request->leave_reason,
				'status'                   => 1,
				'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
				'leave_for_extra_duty'     => ($request->extra_duty_on) ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
				'al_dayoff_date'           => isset($request->holiday_date) ? date('Y-m-d', strtotime($request->holiday_date)) : "",
				'au_entry_session'         => 'session',
				'au_entry_hospital_pk_no'  => $hostpital,
			];

			if ($id == "") {
				$user_info = Auth::user();
				$existingDates = DB::table('hrms_leave_entrydtl')
				->leftJoin('hrms_leave_entry', 'hrms_leave_entrydtl.leave_no_fk', 'hrms_leave_entry.leave_no_pk')
				->where('hrms_leave_entry.person_no_fk', $user_info->person_no_fk)
				->where(function($query) use ($request) {
					$query->whereBetween('leave_dates', [
						date('Y-M-d', strtotime($request->altFromDate)),
						date('Y-M-d', strtotime($request->altFromDate))
					]);
				})->count();

				if ($existingDates > 0) {
					$message = ['msg' => 'Leave dates already exist !!', 'title' => 'Error'];
					return response()->json($message);
				}

				if (isset($request->leave_file)) {
					$fileName = time() . '.' . $request->leave_file->extension();
					$request->leave_file->move(public_path('uploads/leave_file/'), $fileName);
					$data['leave_attch'] = $fileName;
				}else{
					$data['leave_attch'] = '';
				}
				
				// remarks
				$date = new Carbon($request->altFromDate);
				$end_date = new Carbon($request->altFromDate);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate = date("Y-M-d", strtotime($end_date->toDateString()));
				$period = CarbonPeriod::create($startDate, $endDate);
				$totalDays = $period->count();

				$data['au_entry_by'] = $auth_id;
				$response = $this->model->create($data);
				$last_id = $response->leave_no_pk;

				foreach ($period as $key => $date) {
					$selected_date = date("Y-M-d", strtotime($date->toDateString()));
					$sequence = DB::getSequence();
					$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
					$child_table = [
						'leavedtl_no_pk'          => $leavedtl_no_pk,
						'leave_no_fk'             => $last_id,
						// 'leave_type_lkp_no_fk' => $request->leave_name,
						'leave_type_lkp_no_fk'    => $leave_name[0],
						'leave_dates'             => $selected_date,
						'leave_reason'            => $request->leave_reason,
						'leave_status'            => 1,
						'status'                  => 1,
						'au_entry_session'        => 'session',
						'au_entry_hospital_pk_no' => $hostpital,
						'au_entry_by'             => $auth_id,
					];

					$child_table['au_entry_at'] = date("Y-m-d");
					DB::table('hrms_leave_entrydtl')->insert($child_table);
				}
			} else {
				$date      = new Carbon($request->from_date);
				$end_date  = new Carbon($request->to_dates);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate   = date("Y-M-d", strtotime($end_date->toDateString()));
				$period    = CarbonPeriod::create($startDate, $endDate);
				$totalDays = $period->count();

					$updateData = [
						// 'leave_type_lkp_no_fk'  => $request->leave_name,
						'leave_type_lkp_no_fk'     => $leave_name[0],
						'from_date'                => $request->altFromDate ? date('Y-M-d', strtotime($request->altFromDate)) : "",
						'to_dates'                 => $request->to_dates ? date('Y-M-d', strtotime($request->to_dates)) : "",
						'leave_reason'             => $request->leave_reason,
						'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
						'leave_for_extra_duty'     => $request->extra_duty_on ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
					];
					$updateData['au_update_by']    = $auth_id;

					if (isset($request->leave_file1)) {
						$fileName1 = time() . '.' . $request->leave_file1->extension();
						$request->leave_file1->move(public_path('uploads/leave_file/'), $fileName1);
						$updateData['leave_attch'] = $fileName1;
					}

					if ($totalDays > $leave_name[2]) {
						$message = ['msg' => 'Leave balance is insufficient !!', 'title' => 'Error'];
						return response()->json($message);
					} else {

					if ($leave_name[1] == 'Casual Leave' && $totalDays >3) {
						$message = ['msg' => 'Casual leave is not allowed for more than 3 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
	
					if ($leave_name[1] == 'Earned Leave' && $totalDays >5) {
						$message = ['msg' => 'Casual leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}

					if ($leave_name[1] == 'Paternity Leave' && $totalDays >5) {
						$message = ['msg' => 'Paternity leave is not allowed for more than 5 days !!', 'title' => 'Error'];
						return response()->json($message);
					}
				  }

					$this->model->update($updateData, $id);
	
					// child table delete and insert
					DB::table('hrms_leave_entrydtl')->where('leave_no_fk', $id)->delete();
	
					foreach ($period as $key => $date) {
						$selected_date  = date("Y-M-d", strtotime($date->toDateString()));
						$sequence       = DB::getSequence();
						$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
						$child_table = [
							'leavedtl_no_pk' => $leavedtl_no_pk,
							'leave_no_fk' => $id,
							// 'leave_type_lkp_no_fk' => $request->leave_name,
							'leave_type_lkp_no_fk'    => $leave_name[0],
							'leave_dates'             => $selected_date,
							'leave_reason'            => $request->leave_reason,
							'leave_status'            => 1,
							'status'                  => 1,
							'au_entry_session'        => 'session',
							'au_entry_hospital_pk_no' => $hostpital,
							'au_entry_by'             => $auth_id,
						];
	
						$child_table['au_entry_at'] = date("Y-m-d");
						DB::table('hrms_leave_entrydtl')->insert($child_table);
					}
			}

			if ($id == "") {
				$approval_id = $last_id;
			}else{
				$approval_id = $id;
			}

			if (!empty($approval_id)) {
				$check_pervious = DB::select("select count(*) num from SYSC_APPROVALPROCESS_VW where APPROVAL_FOR_CODE='LEAVEAPP'
				and PRIMARY_KEY_VALUE=$approval_id");
			}

			if ($totalDays >1) {
				$total = $totalDays . ' Days';
			}else{
				$total = $totalDays . ' Day';
			}

			if (!empty($check_pervious) && $check_pervious[0]->num == 2) {

				$from_date_formatted = !empty($request->altFromDate) ? date('Y-M-d', strtotime($request->altFromDate)) : '';
				$to_dates_formatted  = !empty($request->to_dates) ? date('Y-M-d', strtotime($request->to_dates)) : '';
				$holiday_date = !empty($request->holiday_date) ? date('Y-m-d', strtotime($request->holiday_date)) : "";

				$remarks = $request->leave_reason . ' | ' . $leave_name[1] . ' | ' .
				'HD: ' . $holiday_date . ' | ' . $total . ' | ' .
			               'From: ' . $from_date_formatted . ' To: ' . $to_dates_formatted . ' ' .
			               'Assigned to - ' . $request->search_employee_code;
				// DB::update("update SYSC_APPROVALPROCESS set REMARKS=:remarks where APPROVAL_FOR_CODE='LEAVEAPP' and PRIMARY_KEY_VALUE= :leave_no_pk",
				// 	['remarks' => $request->leave_reason . ' | ' . $leave_name[1] . ' | ' . $total . ' | ' . ' From: ' . date('Y-M-d', strtotime($request->from_date)) . ' To: ' . date('Y-M-d', strtotime($request->to_dates)) . ' Assigned to - ' . $request->search_employee_code, 'leave_no_pk' => $approval_id]);
				DB::update("UPDATE SYSC_APPROVALPROCESS SET REMARKS = :remarks WHERE APPROVAL_FOR_CODE = 'LEAVEAPP' AND PRIMARY_KEY_VALUE = :leave_no_pk",
               ['remarks' => $remarks, 'leave_no_pk' => $approval_id]);

			}else {
				$ses_hospital_id  = Session::get('user.ses_hospital_no_pk');
				$au_entry_by      = auth::user()->user_no_pk;
				$au_entry_session = Session()->get('user.ses_user_pk_no');
				$code             = 'LEAVEAPP';
				$pdo              = DB::getPdo();

				$from_date_formatted = !empty($request->altFromDate) ? date('Y-M-d', strtotime($request->altFromDate)) : '';
				$to_dates_formatted  = !empty($request->to_dates) ? date('Y-M-d', strtotime($request->to_dates)) : '';
				$holiday_date = !empty($request->holiday_date) ? date('Y-m-d', strtotime($request->holiday_date)) : "";

				$rem = $request->leave_reason . ' | ' . $leave_name[1] . ' | ' .
				'HD: ' . $holiday_date . ' | ' . $total . ' | ' .
			           'From: ' . $from_date_formatted . ' To: ' . $to_dates_formatted . ' ' .
			           'Assigned to - ' . $request->search_employee_code;
				$out_apprprocess_no_pk = $out_apprprocess_uid = $out_error = '';
				
				$leave_appllication = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
					:in_approval_for_code,
					:in_primary_key_value,
					:in_primary_key_uid,
					:in_remarks,
					:in_au_entry_by,
					:in_au_entry_session,
					:in_au_entry_hospital_pk_no,
					:out_apprprocess_no_pk,
					:out_apprprocess_uid,
					:out_error
				); end;");
	
				$leave_appllication->bindParam(':in_approval_for_code', $code);
				$leave_appllication->bindParam(':in_primary_key_value', $approval_id);
				$leave_appllication->bindParam(':in_primary_key_uid', $approval_id);
				$leave_appllication->bindParam(':in_remarks', $rem);
				$leave_appllication->bindParam(':in_au_entry_by', $au_entry_by);
				$leave_appllication->bindParam(':in_au_entry_session', $au_entry_session);
				$leave_appllication->bindParam(':in_au_entry_hospital_pk_no', $ses_hospital_id);
				$leave_appllication->bindParam(':out_apprprocess_no_pk', $out_apprprocess_no_pk, PDO::PARAM_INT);
				$leave_appllication->bindParam(':out_apprprocess_uid', $out_apprprocess_uid, PDO::PARAM_STR, 100000);
				$leave_appllication->bindParam(':out_error', $out_error, PDO::PARAM_STR, 100000);
				$leave_appllication->execute();
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
			return response()->json($message, 200);
		} catch (\Exception $e) {
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
			return response()->json($message, 422);
		}
		
	}
	
	public function leaveEdit($id = "")
	{
		$approvalCnt = DB::table('SYSC_APPROVALPROCESS')
			->where('APPROVAL_FOR_CODE', 'LEAVEAPP')
			->where('PRIMARY_KEY_VALUE', $id)
			->whereRaw('NVL(APPROVED_IND, 0) = 1')
			->count();
			// dd($approvalCnt);
		$i = auth::user()->user_no_pk;
		$leave_cate_id = DB::table('hrms_personnel')
			->leftJoin('wsec_user', 'wsec_user.person_no_fk', '=', 'hrms_personnel.person_no_pk')
			->leftJoin('wsec_user', 'wsec_user.person_no_fk', '=', 'hrms_personnel.person_no_pk')
			->select('hrms_personnel.leave_category_lookup_no_fk')
			->where('wsec_user.user_no_pk', $i)
			->first();

		if (!empty($leave_cate_id)) {
			$user_info  = Auth::user();

			$leave_type = DB::table('hrms_personal_leave_vw')
						  ->select('leave_type_lkp_name', 'leave_type_lkp_no_fk', 'balance',DB::raw('NO_OF_DAYS - LEAVE no_of_days'))
						  ->where('person_no_pk', $user_info->person_no_fk)
		    			  ->whereRaw('no_of_days - leave > 0')
						  ->get();
		}
		$data = DB::table('hrms_leave_entry a')
				->leftJoin('hrms_personnel b', 'a.leave_for_extra_assignto', 'b.person_no_pk')
				->select('a.leave_no_pk', 'a.leave_type_lkp_no_fk', 'a.leave_reason', 'a.from_date', 'a.to_dates', 'a.leave_for_extra_duty', 'a.leave_for_extra_assignto', 'b.full_name',
				DB::raw("(a.to_dates - a.from_date + 1) AS leave_days")
				)
				->where('leave_no_pk', $id)
				// ->where('leave_type_lkp_no_fk', $leaveCategoryLookupNo)
				->first();
		return template::loadview('admin.settings.leave_list.leave_emp_edit_new', ['data' => $data, 'leave_type' => $leave_type, 'approvalCnt'=>$approvalCnt]);
	}


	public function deleteLeaveApplication(Request $request){
		DB::transaction(function () use ($request) {
			DB::table('hrms_leave_entry')
				->where('leave_no_pk', $request->leave_no_pk)
				->delete();
		
			DB::table('hrms_leave_entrydtl')
				->where('leave_no_fk', $request->leave_no_pk)
				->delete();
		
			DB::table('sysc_approvalprocess')
				->where('primary_key_value', $request->leave_no_pk)
				->where('approval_for_code', 'LEAVEAPP')
				->delete();
		});
		$user_info = Auth::user();
		$leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
			->where('a.person_no_fk', $user_info->person_no_fk)
			->orderBy('a.leave_no_pk', 'desc')
			->get();
		return Template::loadView("admin.v1.hrm.employee_portal.leave-status-include", ['leave_data'=>$leave_data]);
		// return response()->json($delete);
		
	}

	
    public function dailyAttendanceReportV1(Request $request){
		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.uhl.daily-attendance-reportv1", ["type" => "pdf", "po_hospital_details" => $po_hospital_details])->setPaper('a4', 'potrait');
		return $pdf->stream('daily-attendance-report.pdf');
    }

	public function leaveReportforApproval($id = ""){
		ini_set("max_execution_time",0);
		// $person = DB::table('wsec_user a')
		// ->leftJoin('hrms_leave_entry b', 'a.user_no_pk', 'b.au_entry_by')
		// ->select('b.person_no_fk')
		// ->where('b.au_entry_by', $id)
		// ->first();

		$person = DB::table('wsec_user a')

		->select('person_no_fk')
		->where('user_no_pk', $id)
		->first();

		$personDetails = DB::table('EMPLOYEE_INFO_VW')
				->where('PERSON_NO_PK', $person->person_no_fk)
				->select('full_name', 'su_name', 'designation', 'person_code')
				->first();
				
		$info = DB::table('HRMS_PERSONAL_LEAVE_VW')
		->where('person_no_pk', $person->person_no_fk)
		->get();	
		
		$availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
        ->where('a.person_no_fk', $person->person_no_fk)
        ->where('a.approved_ind', 1)
        ->orderBy('a.leave_no_pk', 'desc')
        ->get();

		$appliedLeave = DB::table('hrms_leave_entry_for_approval_vw as applied')
        ->where('applied.person_no_fk', $person->person_no_fk)
        ->where('applied.approved_ind', '!=', 1)
        ->where('applied.approval_status_text', 'NOT LIKE', '%REJECTED%')
        ->orderBy('applied.leave_no_pk', 'desc')
        ->get();

		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

		$pdf = PDF::loadView("admin.reports.hrm.leave_report_for_approval", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'info' => $info, 'availedInfo' => $availedInfo, 'appliedLeave' => $appliedLeave, 'personDetails' => $personDetails])->setPaper('a4', 'potrait');
		return $pdf->stream('Leave Report.pdf');
	}

	public function LevelTrackingforLeaveApplication($id = ""){
		$approval_matrix_id = $id; 
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
            ->where("approval_for_code", "LEAVEAPP")
            // ->where("person_no_fk", $loginUser)
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.v1.hrm.employee_portal.approval-tracking-leave-application", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
	}
}
