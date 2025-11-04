<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveChild;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\Designation;
use App\Models\ServiceUnit;
use Auth;
use DB;
use Redirect;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PDO;
use PDF;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
use Exception;
use Illuminate\Support\Facades\Session;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use DatatablesLoader;
    protected $model;
    public function __construct(Leave $leave, LeaveChild $LeaveChild)
    {
        $this->middleware('auth');

        $this->model = new Repo($leave);
        $this->model2 = new Repo($LeaveChild);
    }

    public function index()
    {
        $leave_info  = DB::table("hrms_leavetype_days")->select("leave_type_lkp_no_fk", "leave_type_lkp_name", "no_of_days", "leave_code")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("status", 1)
            ->get();

        $user_info = Auth::user();
        // dd($leave_info);
        $session = Session::get('user.ses_hospital_no_pk');
        $leave_status = DB::select("select a.leave_code,a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at, count(b.leavedtl_no_pk) total_days
        from hrms_leave_entry a,hrms_leave_entrydtl b, sysc_lookupdata c
        where a.leave_no_pk=b.leave_no_fk and a.leave_type_lkp_no_fk=c.lookupdata_no_pk and b.leave_status!=2 and a.person_no_fk=$user_info->person_no_fk
        and a.au_entry_hospital_pk_no = $session group by a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at ,a.leave_code  ORDER BY a.au_entry_at DESC");
        // dd($leave_status);
        // echo "select a.leave_code,a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at, count(b.leavedtl_no_pk) total_days
        // from hrms_leave_entry a,hrms_leave_entrydtl b, sysc_lookupdata c
        // where a.leave_no_pk=b.leave_no_fk and a.leave_type_lkp_no_fk=c.lookupdata_no_pk and b.leave_status!=2 and a.person_no_fk=$user_info->person_no_fk
        // and a.au_entry_hospital_pk_no = $session group by a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at ,a.leave_code  ORDER BY a.au_entry_at DESC";

        return Template::loadview("admin.settings.leave.leave_entry", ["leave_info" => $leave_info, "user_info" => $user_info, "leave_status" => $leave_status]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leave = DB::table('hrms_leavetype_days')->select('leave_code')->where('leave_type_lkp_no_fk', $request->leave_name)->first();

        $validatedData   = $request->validate([
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
                'leave_code'               => $leave->leave_code,
                'person_no_fk'             => $request->hdn_item_item_id_0,
                'leave_type_lkp_no_fk'     => $request->leave_name,
                'from_date'                => date('Y-M-d', strtotime($request->from_date)),
                'to_dates'                 => date('Y-M-d', strtotime($request->to_dates)),
                'leave_reason'             => $request->leave_reason,
                'status'                   => 1,
                'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
                'leave_for_extra_duty'     => ($request->extra_duty_on) ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
                'au_entry_session'         => 'session',
                'au_entry_hospital_pk_no'  => $hostpital,
            ];

            if ($id == "") {
                $data['au_entry_by'] = $auth_id;

                $response            = $this->model->create($data);
                $last_id             = $response->leave_no_pk;
          
                $date                = new Carbon($request->from_date);
                $end_date            = new Carbon($request->to_dates);
                $startDate           = date("Y-M-d", strtotime($date->toDateString()));
                $endDate             = date("Y-M-d", strtotime($end_date->toDateString()));
                $period              = CarbonPeriod::create($startDate, $endDate);

                foreach ($period as $key => $date) {
                    $selected_date  = date("Y-M-d", strtotime($date->toDateString()));
                    $sequence       = DB::getSequence();
                    $leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
                    $child_table = [
                        'leavedtl_no_pk'          => $leavedtl_no_pk,
                        'leave_no_fk'             => $last_id,
                        'leave_type_lkp_no_fk'    => $request->leave_name,
                        'leave_dates'             => $selected_date,
                        'leave_reason'            => $request->leave_reason,
                        'leave_status'            => 1,
                        'status'                  => 1,
                        'au_entry_session'        => 'session',
                        'au_entry_hospital_pk_no' => $hostpital,
                        'au_entry_by'             => $auth_id,
                    ];

                    $child_table['au_entry_at']   = date("Y-m-d");
                    DB::table('hrms_leave_entrydtl')->insert($child_table);
                }
            } else {
                $updateData = [
                    'leave_type_lkp_no_fk'     => $request->leave_name,
                    'from_date'                => $request->from_date ? date('Y-M-d', strtotime($request->from_date)) : "",
                    'to_dates'                 => $request->to_dates ? date('Y-M-d', strtotime($request->to_dates)) : "",
                    'leave_reason'             => $request->leave_reason,
                    'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
                    'leave_for_extra_duty'     => $request->extra_duty_on ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
                ];
                // AU_UPDATE_BY
                $updateData['au_update_by'] = $auth_id;
                $this->model->update($updateData, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchEmployeeLeaveStatus(Request $request)
    {
        $employee_id = $request->employee_id;
        $session = Session::get('user.ses_hospital_no_pk');
        $leave_status = DB::select("select a.leave_code,a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at, count(b.leavedtl_no_pk) total_days
    		from hrms_leave_entry a,hrms_leave_entrydtl b, sysc_lookupdata c
    		where a.leave_no_pk=b.leave_no_fk and a.leave_type_lkp_no_fk=c.lookupdata_no_pk and b.leave_status!=2 and a.person_no_fk=$employee_id and a.au_entry_hospital_pk_no = $session
    		group by a.leave_no_pk,a.leave_type_lkp_no_fk,a.person_no_fk,a.from_date,a.to_dates,a.leave_reason,c.lookupdata_name,c.lookupdata_no_pk,a.approved_hr_ind,a.approved_dept_ind,a.au_entry_at ,a.leave_code ORDER BY a.au_entry_at DESC");
        $leave_info  = DB::table("hrms_leavetype_days")->select("leave_type_lkp_no_fk", "leave_type_lkp_name", "no_of_days")
            ->where("status", 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        return Template::loadview("admin.settings.leave.leave_list", ["leave_status" => $leave_status, "leave_info" => $leave_info]);
    }

    public function leaveCancel($id)
    {

        $leave_cancel  = DB::table("hrms_leave_entrydtl a")->select("a.leavedtl_no_pk", "a.leave_type_lkp_no_fk", "a.leave_dates", "a.leave_reason", "a.leave_status", "b.lookupdata_name", "a.leave_status")->leftjoin("sysc_lookupdata b", "a.leave_type_lkp_no_fk", "b.lookupdata_no_pk")
            ->where("leave_no_fk", $id)->where("a.leave_status", 1)
            ->get();
        // dd($leave_cancel);
        return Template::loadview("admin.settings.leave.leave_cancel", ["leave_cancel" => $leave_cancel]);
    }

    public function deleteLeave(Request $request)
    {
        $auth_id = Auth::id();
        $leave_status['leave_status'] = 2;
        $leave_status['au_update_by'] = $auth_id;

        DB::table('hrms_leave_entrydtl')->where("leavedtl_no_pk",  $request->leavedtl)->update($leave_status);
    }

    public function leaveApplication()
    {
        return Template::loadview("admin.settings.leave.leave_application");
    }

    public function ManualLeaveHR(Request $request){
        $user_info = Auth::user();
        $leave_type = DB::table('hrms_personal_leave_vw')
        ->select('leave_type_lkp_name', 'leave_type_lkp_no_fk', DB::raw('NO_OF_DAYS - LEAVE no_of_days'))
        ->where('person_no_pk', $user_info->person_no_fk)
        ->get();

        $manual_leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
        ->leftJoin('hrms_leave_entry', 'a.leave_no_pk', 'hrms_leave_entry.leave_no_pk')
        ->leftJoin('hrms_personnel', 'hrms_leave_entry.person_no_fk', 'hrms_personnel.person_no_pk')
        ->select('a.*', 'hrms_leave_entry.leave_attch', 'hrms_personnel.full_name')
        ->where('hrms_leave_entry.manual_lv_ind', 1)
        ->orderBy('a.leave_no_pk', 'desc')
        ->get();

        return Template::loadView("admin.v1.hrm.manual-leave.create-manual-leave-hr", ["leave_type" => $leave_type, "manual_leave_data" => $manual_leave_data]);
    }

    public function SaveManualLeave(Request $request){
        $leave_name = explode('-', $request->leave_name);
		$leave = DB::table('hrms_leavetype_days')->select('leave_code')->where('leave_type_lkp_no_fk', $leave_name[0])->first();
		$validatedData = $request->validate([
			'leave_name' => 'required',
		]);

		$id = $request->id;
		$hostpital = Session::get('user.ses_hospital_no_pk');
		$sequence = DB::getSequence();
		$sysc_leave_seq = $sequence->nextValue('leave_no_pk_seq');
		$auth_id = Auth::id();
		DB::beginTransaction();

		try {
			$data = [
				'leave_no_pk' => $sysc_leave_seq,
				'leave_code' => $leave->leave_code,
				'person_no_fk' => $request->hdn_item_item_id_0,
				'leave_type_lkp_no_fk' => $leave_name[0],
				'from_date' => date('Y-M-d', strtotime($request->from_date)),
				'to_dates' => date('Y-M-d', strtotime($request->to_dates)),
				'leave_reason' => $request->leave_reason,
				'status' => 1,
				'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
				'leave_for_extra_duty' => ($request->extra_duty_on) ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
                'manual_lv_ind' => 1,
				'au_entry_session' => 'session',
				'au_entry_hospital_pk_no' => $hostpital,
                'approved_ind' => 1
			];

			if ($id == "") {
				$user_info = Auth::user();

				$date = new Carbon($request->from_date);
				$end_date = new Carbon($request->to_dates);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate = date("Y-M-d", strtotime($end_date->toDateString()));
				$period = CarbonPeriod::create($startDate, $endDate);

				$data['au_entry_by'] = $auth_id;
				$response = $this->model->create($data);
				$last_id = $response->leave_no_pk;

				foreach ($period as $key => $date) {
					$selected_date = date("Y-M-d", strtotime($date->toDateString()));
					$sequence = DB::getSequence();
					$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
					$child_table = [
						'leavedtl_no_pk' => $leavedtl_no_pk,
						'leave_no_fk' => $last_id,
						// 'leave_type_lkp_no_fk' => $request->leave_name,
						'leave_type_lkp_no_fk' => $leave_name[0],
						'leave_dates' => $selected_date,
						'leave_reason' => $request->leave_reason,
						'leave_status' => 1,
						'status' => 1,
                        'manual_lv_ind' => 1,
						'au_entry_session' => 'session',
						'au_entry_hospital_pk_no' => $hostpital,
						'au_entry_by' => $auth_id,
					];

					$child_table['au_entry_at'] = date("Y-m-d");
					DB::table('hrms_leave_entrydtl')->insert($child_table);
				}
			} else {

				$date = new Carbon($request->from_date);
				$end_date = new Carbon($request->to_dates);
				$startDate = date("Y-M-d", strtotime($date->toDateString()));
				$endDate = date("Y-M-d", strtotime($end_date->toDateString()));
				$period = CarbonPeriod::create($startDate, $endDate);

					$updateData = [
						// 'leave_type_lkp_no_fk' => $request->leave_name,
                        'leave_code' => $leave->leave_code,
				        'person_no_fk' => $request->hdn_item_item_id_0,
						'leave_type_lkp_no_fk' => $leave_name[0],
						'from_date' => $request->from_date ? date('Y-M-d', strtotime($request->from_date)) : "",
						'to_dates' => $request->to_dates ? date('Y-M-d', strtotime($request->to_dates)) : "",
						'leave_reason' => $request->leave_reason,
						'leave_for_extra_assignto' => $request->hdn_item_item_id_0_search,
						'leave_for_extra_duty' => $request->extra_duty_on ? date('Y-M-d', strtotime($request->extra_duty_on)) : '',
                        'manual_lv_ind' => 1,
                        'approved_ind' => 1
					];
					$updateData['au_update_by'] = $auth_id;

					$this->model->update($updateData, $id);

					// child table delete and insert
					DB::table('hrms_leave_entrydtl')->where('leave_no_fk',$id)->delete();

					foreach ($period as $key => $date) {
						$selected_date = date("Y-M-d", strtotime($date->toDateString()));
						$sequence = DB::getSequence();
						$leavedtl_no_pk = $sequence->nextValue('leavedtl_no_pk');
						$child_table = [
							'leavedtl_no_pk' => $leavedtl_no_pk,
							'leave_no_fk' => $id,
							// 'leave_type_lkp_no_fk' => $request->leave_name,
							'leave_type_lkp_no_fk' => $leave_name[0],
							'leave_dates' => $selected_date,
							'leave_reason' => $request->leave_reason,
							'leave_status' => 1,
							'status' => 1,
                            'manual_lv_ind' => 1,
							'au_entry_session' => 'session',
							'au_entry_hospital_pk_no' => $hostpital,
							'au_entry_by' => $auth_id,
						];

						$child_table['au_entry_at'] = date("Y-m-d");
						DB::table('hrms_leave_entrydtl')->insert($child_table);
					}
			}

			DB::commit();
			$message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
		} catch (\Exception $e) {
			DB::rollback();
			$message = ['msg' => $e->getMessage(), 'title' => 'Error'];
		}
		return response()->json($message);
    }


    public function SearchManualLeave(Request $request){

        if ($request->hdn_item_item_id_1_search) {
            $manual_leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
            ->leftJoin('hrms_leave_entry', 'a.leave_no_pk', 'hrms_leave_entry.leave_no_pk')
            ->leftJoin('hrms_personnel', 'hrms_leave_entry.person_no_fk', 'hrms_personnel.person_no_pk')
            ->select('a.*', 'hrms_leave_entry.leave_attch', 'hrms_personnel.full_name')
            ->where('hrms_leave_entry.manual_lv_ind', 1)
            ->where('hrms_leave_entry.person_no_fk', $request->hdn_item_item_id_1_search)
            ->orderBy('a.leave_no_pk', 'desc')
            ->get();
        }
        if ($request->date_from && $request->date_to) {
            $manual_leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
            ->leftJoin('hrms_leave_entry', 'a.leave_no_pk', 'hrms_leave_entry.leave_no_pk')
            ->leftJoin('hrms_personnel', 'hrms_leave_entry.person_no_fk', 'hrms_personnel.person_no_pk')
            ->select('a.*', 'hrms_leave_entry.leave_attch', 'hrms_personnel.full_name')
            ->where('hrms_leave_entry.manual_lv_ind', 1)
            ->where(DB::raw('trunc(hrms_leave_entry.au_entry_at)'), '>=', date('Y-m-d', strtotime($request->date_from)))
            ->where(DB::raw('trunc(hrms_leave_entry.au_entry_at)'), '<=', date('Y-m-d', strtotime($request->date_to)))
            ->orderBy('a.leave_no_pk', 'desc')
            ->get();
        }
        if ($request->hdn_item_item_id_1_search && $request->date_from && $request->date_to) {
            $manual_leave_data = DB::table('hrms_leave_entry_for_approval_vw as a')
            ->leftJoin('hrms_leave_entry', 'a.leave_no_pk', 'hrms_leave_entry.leave_no_pk')
            ->leftJoin('hrms_personnel', 'hrms_leave_entry.person_no_fk', 'hrms_personnel.person_no_pk')
            ->select('a.*', 'hrms_leave_entry.leave_attch', 'hrms_personnel.full_name')
            ->where('hrms_leave_entry.manual_lv_ind', 1)
            ->where('hrms_leave_entry.person_no_fk', $request->hdn_item_item_id_1_search)
            ->where(DB::raw('trunc(hrms_leave_entry.au_entry_at)'), '>=', date('Y-m-d', strtotime($request->date_from)))
            ->where(DB::raw('trunc(hrms_leave_entry.au_entry_at)'), '<=', date('Y-m-d', strtotime($request->date_to)))
            ->orderBy('a.leave_no_pk', 'desc')
            ->get();
        }

        // dd($manual_leave_data);
        return Template::loadView("admin.v1.hrm.manual-leave.search-manual-leave-hr", ["manual_leave_data" => $manual_leave_data]);
    }

    public function ManualLeaveEdit($id = "")
	{
        $user_info = Auth::user();
        $leave_type = DB::table('hrms_personal_leave_vw')
        // ->select('leave_type_lkp_name', 'leave_type_lkp_no_fk', DB::raw('NO_OF_DAYS - LEAVE no_of_days'))
        ->select('leave_type_lkp_name', 'leave_type_lkp_no_fk')
        ->where('person_no_pk', $user_info->person_no_fk)
        // ->whereRaw('no_of_days - leave > 0')
        ->get();

		$data = DB::table('hrms_leave_entry a')
			->leftJoin('hrms_personnel b', 'a.leave_for_extra_assignto', 'b.person_no_pk')
			->leftJoin('hrms_personnel c', 'a.person_no_fk', 'c.person_no_pk')
			->select('a.person_no_fk', 'a.leave_no_pk', 'a.leave_type_lkp_no_fk', 'a.leave_reason', 'a.from_date', 'a.to_dates', 'a.leave_for_extra_duty', 'a.leave_for_extra_assignto', 'b.full_name', 'c.full_name as p_full_name')
			->where('leave_no_pk', $id)
			->first();

        return template::loadview("admin.v1.hrm.manual-leave.manual-leave-edit", ["leave_type" => $leave_type,"data" => $data]);
	}

    /**
     * Leave Deduction due to Late Attendance
     */
    public function leaveDeduction()
    {
        return template::loadview("admin.hrm.leave.leave-deduction");
    }

    public function getLeaveDeductionData()
    {
        $monthYear = date('m-Y');
        $monthAndYear = explode('-', $monthYear);

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $from_date = '';
        $to_date = '';

        // $whereClause = " AND PERSON_CARD_NO ='10003' ";
        $whereClause = "";
        if (!empty($monthAndYear)) {
            // $whereClause .= ' AND SERVICEUNIT_NO_FK = ' . $department;
            $result = $this->getMonthRange($monthAndYear);
            $from_date = $result['from_date'];
            $to_date = $result['to_date'];
        }

        $orderByClause = ' order by';
        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $orderByClause .= ' PERSON_CARD_NO ASC';
        } else {
            $orderByClause .= ' PERSON_CARD_NO ASC AND au_entry_at DESC';
        }

        $firstDateOfMonth = '01/' . $monthAndYear[0] . '/' . $monthAndYear[1];

        $query = "SELECT PERSON_CARD_NO, full_name, fnc_serviceunitname(SERVICEUNIT_NO_FK) dept, (to_date('$to_date','dd/mm/yyyy') - to_date('$from_date','dd/mm/yyyy'))+1 workingday, designation_name, lookupdata_desc, person_no_pk
        , sum(case when Attendance_status = 6 then 1 else 0 end) WEEKEND
        , sum(case when (Attendance_status in( 1, 2, 0)) then 1 else 0 end) ATTENDANCE_DAYS--sum(case when (Attendance_status = 1) OR (Attendance_status = 2 AND NVL(LATE_TIME_MIN,0) =0) then 1 else 0 end) ATTENDANCE_DAYS
        , sum(case when Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 then 1 else 0 end) LATE_DAYS
        , floor(sum(case when Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 then 1 else 0 end) / 3) LEAVE_DEDUCTION
        , sum(case when Attendance_status = 5 then 1 else 0 end) ABSENT_DAYS
        , sum(case when Attendance_status = 3 then 1 else 0 end) LEAVE_DAYS
        , sum(case when Attendance_status = 8 then 1 else 0 end) CASUAL_LEAVE
        , sum(case when Attendance_status = 9 then 1 else 0 end) SICK_LEAVE
        , sum(case when Attendance_status = 7 then 1 else 0 end) national_holiday
        , sum(case when Attendance_status = 4 then 1 else 0 end) LEAVE_WITHOUTPAY_DAYS
        , ld.reason
        FROM HRMS_ATTENDANCE_DAILY att 
            JOIN hrms_personnel per ON per.PERSON_NO_pk = att.PERSON_NO_FK 
            JOIN hrms_designation desi ON per.jobtitle_lookup_no_fk = desi.DESIGNATION_NO_PK
            JOIN sysc_lookupdata jobtype ON jobtype.lookupdata_no_pk = per.job_type_lookup_no_fk
            LEFT JOIN hrms_empleavededuction ld ON per.PERSON_NO_pk = ld.PERSON_NO_FK AND ld.LEAVE_DATE = to_date('$firstDateOfMonth','dd/mm/yyyy')
            WHERE trunc(ATTENDANCE_DATE) BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy')  --to_number(to_char(ATTENDANCE_DATE,'YYYYMM')) = in_yyyymm
            AND att.AU_ENTRY_HOSPITAL_PK_NO = '$ses_hospital_id'
            AND per.PERSON_NO_pk = att.PERSON_NO_FK
            AND per.jobtitle_lookup_no_fk = desi.DESIGNATION_NO_PK
            AND jobtype.lookupdata_no_pk = per.job_type_lookup_no_fk
            AND per.STATUS = 1
            AND employee_ind = 1
            AND virtual_ind != 1
            $whereClause
            HAVING sum(CASE WHEN Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 THEN 1 ELSE 0 END) > 2
            GROUP BY full_name, PERSON_CARD_NO,SERVICEUNIT_NO_FK, DESIGNATION_NAME, lookupdata_desc, person_no_pk, reason --, trunc(ATTENDANCE_DATE)
            $orderByClause
        ";
        $attendance_data = DB::select(DB::raw($query));

        # Get Current Month Year
        $monthYear = date('m-Y');
        $monthAndYear = explode('-', $monthYear);
        $result = $this->getMonthRange($monthAndYear);
        $from_date = $result['from_date'];
        $to_date = $result['to_date'];

        return response()->json(["success" => true, "data" => $attendance_data, "from_date" => $from_date, "to_date" => $to_date, "monthYear" => $monthYear], 200);        
    }

    /**
     * Leave deduction Filter
     * according to CUT OFF MONTH.
     * Ex: Month start from 21th to 20th.
     */
    public function leaveDeductionFilter(Request $request)
    {
        $monthYear = $request->input('monthYear');
        $monthAndYear = explode('-', $monthYear);

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $from_date = '';
        $to_date = '';

        // $whereClause = " AND PERSON_CARD_NO ='10003' ";
        $whereClause = "";
        if (!empty($monthAndYear)) {
            // $whereClause .= ' AND SERVICEUNIT_NO_FK = ' . $department;
            $result = $this->getMonthRange($monthAndYear);
            $from_date = $result['from_date'];
            $to_date = $result['to_date'];
        }

        $orderByClause = 'ORDER BY';
        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $orderByClause .= ' PERSON_CARD_NO ASC';
        } else {
            $orderByClause .= ' PERSON_CARD_NO ASC AND au_entry_at DESC';
        }

        $firstDateOfMonth = '01/' . $monthAndYear[0] . '/' . $monthAndYear[1];

        $query = "SELECT PERSON_CARD_NO, full_name, fnc_serviceunitname(SERVICEUNIT_NO_FK) dept, (to_date('$to_date','dd/mm/yyyy') - to_date('$from_date','dd/mm/yyyy'))+1 workingday, designation_name, lookupdata_desc, person_no_pk
        , sum(case when Attendance_status = 6 then 1 else 0 end) WEEKEND
        , sum(case when (Attendance_status in( 1, 2, 0)) then 1 else 0 end) ATTENDANCE_DAYS--sum(case when (Attendance_status = 1) OR (Attendance_status = 2 AND NVL(LATE_TIME_MIN,0) =0) then 1 else 0 end) ATTENDANCE_DAYS
        , sum(case when Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 then 1 else 0 end) LATE_DAYS
        , floor(sum(case when Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 then 1 else 0 end) / 3) LEAVE_DEDUCTION
        , sum(case when Attendance_status = 5 then 1 else 0 end) ABSENT_DAYS
        , sum(case when Attendance_status = 3 then 1 else 0 end) LEAVE_DAYS
        , sum(case when Attendance_status = 8 then 1 else 0 end) CASUAL_LEAVE
        , sum(case when Attendance_status = 9 then 1 else 0 end) SICK_LEAVE
        , sum(case when Attendance_status = 7 then 1 else 0 end) national_holiday
        , sum(case when Attendance_status = 4 then 1 else 0 end) LEAVE_WITHOUTPAY_DAYS
        , ld.reason
        FROM HRMS_ATTENDANCE_DAILY att 
            JOIN hrms_personnel per ON per.PERSON_NO_pk = att.PERSON_NO_FK 
            JOIN hrms_designation desi ON per.jobtitle_lookup_no_fk = desi.DESIGNATION_NO_PK
            JOIN sysc_lookupdata jobtype ON jobtype.lookupdata_no_pk = per.job_type_lookup_no_fk
            LEFT JOIN hrms_empleavededuction ld ON per.PERSON_NO_pk = ld.PERSON_NO_FK AND ld.LEAVE_DATE = to_date('$firstDateOfMonth','dd/mm/yyyy')
            WHERE trunc(ATTENDANCE_DATE) BETWEEN to_date('$from_date','dd/mm/yyyy') AND to_date('$to_date','dd/mm/yyyy')  --to_number(to_char(ATTENDANCE_DATE,'YYYYMM')) = in_yyyymm
            AND att.AU_ENTRY_HOSPITAL_PK_NO = '$ses_hospital_id'
            AND per.PERSON_NO_pk = att.PERSON_NO_FK
            AND per.jobtitle_lookup_no_fk = desi.DESIGNATION_NO_PK
            AND jobtype.lookupdata_no_pk = per.job_type_lookup_no_fk
            AND per.STATUS = 1
            AND employee_ind = 1
            AND virtual_ind != 1
            $whereClause
            HAVING sum(CASE WHEN Attendance_status = 2 AND NVL(LATE_TIME_MIN, 0) > 0 THEN 1 ELSE 0 END) > 2
            GROUP BY full_name, PERSON_CARD_NO,SERVICEUNIT_NO_FK, DESIGNATION_NAME, lookupdata_desc, person_no_pk, reason --, trunc(ATTENDANCE_DATE)
            $orderByClause
        ";
        $attendance_data = DB::select(DB::raw($query));

        return template::loadview("admin.hrm.leave.leave-deduction-table", compact('attendance_data', 'from_date', 'to_date', 'monthYear'));
    }

    /**
     * Leave Deduction details modal
     */
    public function leaveDeductionDetails($id)
    {
        $from_date          = request()->get('from_date');
        $to_date            = request()->get('to_date');
        $ses_hospital_id    = Session::get('user.ses_hospital_no_pk');

        $query = "SELECT full_name, ATTENDANCE_DATE, IN_TIME, OUT_TIME
            FROM HRMS_ATTENDANCE_DAILY ATT, hrms_personnel per
            WHERE TRUNC(ATTENDANCE_DATE) BETWEEN TO_DATE('$from_date','DD/MM/YYYY') AND TO_DATE('$to_date','DD/MM/YYYY')
            AND ATT.AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id
            and per.PERSON_NO_pk=att.PERSON_NO_FK
            AND PERSON_CARD_NO = '$id'
            HAVING SUM(CASE WHEN ATTENDANCE_STATUS = 2 AND NVL(LATE_TIME_MIN, 0) > 0 THEN 1 ELSE 0 END) > 0
            GROUP BY full_name, ATTENDANCE_DATE, IN_TIME, OUT_TIME
            ORDER BY ATTENDANCE_DATE DESC
        ";
        $result = DB::select(DB::raw($query));

        return template::loadview("admin.hrm.leave.leave-deduction-details", compact('result'));
    }

    public function lateDeduction($person_no_fk, $monthYear, $to_be_deducted, $full_name)
    {
        $leave_types = DB::table('hrms_personal_leave_vw')
                        ->select('leave_type_lkp_name', 'leave_type_lkp_no_fk', DB::raw('NO_OF_DAYS - LEAVE no_of_days'))
                        ->where('person_no_pk', $person_no_fk)
                        ->get();
        
        $monthName = explode('-', $monthYear);
        $monthName = $monthName[1].'-'.$monthName[0].'-01';

        return Template::loadview("admin.hrm.leave.late-deduction-form", compact('leave_types', 'person_no_fk', 'monthYear', 'to_be_deducted', 'full_name', 'monthName'));
    }

    public function lateDeductionStore(Request $request)
    {
        $leaveName = $this->getLeaveNameAccordingToLeaveTypeNo($request->input('leave_types'), $request->input('leave_no_fk'));
        $leaveDate = $this->getFirstDateAccordingToMonthYear($request->input('monthYear'));

        try {
            DB::beginTransaction();

            DB::table('hrms_empleavededuction')->insert([
                'EMPLEAVEDEDUCTION_NO_PK'   => $this->getSequence('empleavededuction_no_pk_seq'),
                'PERSON_NO_FK'              => $request->input('person_no_fk'),
                'LEAVE_TYPE'                => $leaveName,
                'LEAVE_NO_FK'               => $request->input('leave_no_fk'),
                'NO_OF_DAYS'                => $request->input('no_of_days'),
                'LEAVE_DATE'                => $leaveDate,
                'REASON'                    => $request->input('reason'),
                'STATUS'                    => 1,
                'AU_ENTRY_BY'               => Auth::id(),
                'AU_ENTRY_AT'               => Carbon::now()->toDateString(),
                'AU_ENTRY_SESSION'          => auth()->user()->user_name,
                'AU_ENTRY_HOSPITAL_NO_FK'   => session()->get('user.ses_hospital_no_pk'),
            ]);

            DB::commit();
            $message = ['msg' => 'Leave Deducted Successfully', 'title' => 'Success'];
        } catch(Exception $exception) {
            DB::rollback();
            $message = ['msg' => $exception->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    protected function getLeaveNameAccordingToLeaveTypeNo($leave_types, $leave_no_fk)
    {
        $result = '';
        foreach(json_decode($leave_types) as $item) {
            if($item->leave_type_lkp_no_fk == $leave_no_fk) {
                $result = $item->leave_type_lkp_name;
            }
        }
        return $result;
    }

    protected function getFirstDateAccordingToMonthYear($monthYear)
    {
        $monthAndYear = explode('-', $monthYear);
        return $monthAndYear[1] . '-' . $monthAndYear[0] . '-01';
    }

    /**
     * Cut off Month:: Get date range from month and year field
     */
    protected function getMonthRange($monthAndYear)
    {
        $month = $monthAndYear[0];
        $year = $monthAndYear[1];

        $previousMonth = str_pad((int) $month - 1, 2, '0', STR_PAD_LEFT);

        $from_date = '21/'.$previousMonth.'/'.$year;
        $to_date   = '20/'.$month.'/'.$year;

        return  [
            'from_date' => $from_date,
            'to_date'   => $to_date,
        ];
    }


    public function LeaveReportWorklist()  {
        $service_unit = DB::select("select distinct unit.serviceunit_no_pk,serviceunit_name
                        from sysc_serviceunit unit,hrms_personnel per
                        where unit.serviceunit_no_pk=per.serviceunit_no_fk
                        order by serviceunit_name");
       
        $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->orderBy('b.full_name', 'desc')
                    ->get();
        return Template::loadView('admin.settings.leave_list.leave-report-worklist', ['service_unit'=>$service_unit, 'datas' => $datas]);
    }

    public function LeaveReportWorklistSearch(Request $request){

        if (isset($request->su_name) && isset($request->card_no)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->where('b.card_no', $request->card_no)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->su_name) && isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 
                            'd.leave_type_lkp_name', 'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', '=', 'hrms_designation.designation_no_pk')
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->where('a.approved_ind', 1)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 
                            'd.leave_type_lkp_name', 'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', '=', 'hrms_designation.designation_no_pk')
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->where('a.approved_ind', 1)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }
        
        if (isset($request->su_name)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->card_no)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('b.card_no', $request->card_no)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        return Template::loadView('admin.settings.leave_list.leave-report-worklist-table', ['datas' => $datas]);
    }

    public function searchLeaveReportPdfDownload(Request $request){

        if (isset($request->su_name) && isset($request->card_no)) {
            $datas = DB::table('hrms_leave_entry as a')
                     ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                        'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 
                        'd.leave_type_lkp_name', 'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->where('b.card_no', $request->card_no)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->su_name) && isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 
                            'd.leave_type_lkp_name', 'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', '=', 'hrms_designation.designation_no_pk')
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->where('a.approved_ind', 1)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->from_date) && isset($request->to_date)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 
                            'd.leave_type_lkp_name', 'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', '=', 'hrms_designation.designation_no_pk')
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '>=', date('Y-m-d', strtotime($request->from_date)))
                    ->where(DB::raw('trunc(hrms_leave_entrydtl.leave_dates)'), '<=', date('Y-m-d', strtotime($request->to_date)))
                    ->where('a.approved_ind', 1)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }
        
        if (isset($request->su_name)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()        
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('sysc_serviceunit.serviceunit_no_pk', $request->su_name)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        if (isset($request->card_no)) {
            $datas = DB::table('hrms_leave_entry as a')
                    ->select('a.leave_no_pk', 'a.person_no_fk', 'a.from_date', 'a.to_dates', 'a.leave_reason', 'a.leave_code',
                            'a.leave_for_extra_assignto', 'b.full_name', 'b.card_no', 'sysc_serviceunit.serviceunit_name', 'd.leave_type_lkp_name', 
                            'hrms_designation.designation_name', 'hrms_leave_entrydtl.leave_dates')
                    ->distinct()
                    ->leftJoin('hrms_personnel as b', 'a.person_no_fk', '=', 'b.person_no_pk')
                    ->leftJoin('hrms_leave_entrydtl', 'a.leave_no_pk', '=', 'hrms_leave_entrydtl.leave_no_fk')
                    ->leftJoin('hrms_leavetype_days as d', 'a.leave_type_lkp_no_fk', '=', 'd.leave_type_lkp_no_fk')
                    ->leftJoin('sysc_serviceunit', 'b.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
                    ->leftJoin('hrms_designation', 'b.jobtitle_lookup_no_fk', 'hrms_designation.designation_no_pk')
                    ->where('a.approved_ind', 1)
                    ->where('b.card_no', $request->card_no)
                    ->orderBy('hrms_leave_entrydtl.leave_dates', 'desc')
                    ->get();
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
		$pdf                = PDF::loadView("admin.settings.leave_list.leave-report-worklist-pdf",
                            ['type'                => 'pdf', 
                             'po_hospital_details' => $po_hospital_details, 
                             "datas"               => $datas, 
                             'from_date'           => $request->from_date, 
                             'to_date'             => $request->to_date])->setPaper('a4', 'potrait');
		return $pdf->stream('Leave-Report.pdf');
       

    }
       // pending leave list
       public function pendingLeaveList()
       {
           $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
           $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();

            return Template::loadview("admin.v1.hrm.pending-leave.pending_leave", ['dept' => $dept, 'desig' => $desig, 'pendingLeavedata' => []]);  
       }
   
       public function searchPendingLeaveList(Request $request)
       {
            $query = DB::table('hrms_leave_entry_for_approval_vw')
            ->select('card_no', 'full_name', 'department', 'designation_name', 'leave_type_name', 'to_dates', 'from_date')
            ->where('approved_ind', '!=', 1)
            ->where('approval_status_text', 'NOT LIKE', '%REJECTED%');
            if (isset($request->from_date) &&  isset($request->to_date)) {
                $query->where(DB::raw('trunc(au_entry_at)'), '>=', date('Y-m-d', strtotime($request->from_date)));
                $query->where(DB::raw('trunc(au_entry_at)'), '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            if ($request->department != "") {
                $query->where('serviceunit_no_fk', $request->department);
            }
            if ($request->card_hidn != "") {
                $query->where('person_no_fk', $request->card_hidn);
            }
            $pendingLeavedata = $query->orderBy('card_no', 'asc')->get();
            // dd($pendingLeavedata);
            return Template::loadview("admin.v1.hrm.pending-leave.pending_leave_list", ['pendingLeavedata' => $pendingLeavedata]);
       }
       public function printPendingLeaveList(Request $request)
       {
            $query = DB::table('hrms_leave_entry_for_approval_vw')
            ->select('card_no', 'full_name', 'department', 'designation_name', 'leave_type_name', 'to_dates', 'from_date')
            ->where('approved_ind', '!=', 1)
            ->where('approval_status_text', 'NOT LIKE', '%REJECTED%');
            if (isset($request->from_date) &&  isset($request->to_date)) {
                $query->where(DB::raw('trunc(au_entry_at)'), '>=', date('Y-m-d', strtotime($request->from_date)));
                $query->where(DB::raw('trunc(au_entry_at)'), '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            if ($request->department != "") {
                $query->where('serviceunit_no_fk', $request->department);
            }
            if ($request->card_hidn != "") {
                $query->where('person_no_fk', $request->card_hidn);
            }
            $pendingLeavedata = $query->orderBy('card_no', 'asc')->get();
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
            $from_date = date('d-m-Y', strtotime($request->from_date));
            $to_date = date('d-m-Y', strtotime($request->to_date));
            return view("admin.v1.hrm.pending-leave.print_pending_leave_list", ['pendingLeavedata' => $pendingLeavedata, 'po_hospital_details' => $po_hospital_details, 'from_date'=>$from_date, 'to_date'=>$to_date]);
       }

       //pending leave application
       public function pendingLeaveApplication()
       {
           $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
           $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
           $fromDate = Carbon::now()->subDays(10)->format('Y-m-d');
           $toDate = Carbon::now()->format('Y-m-d');

           $pendingLeavedata = DB::table('hrms_leave_entry_for_approval_vw applied')
            ->select('applied.card_no', 'applied.person_no_fk', 'applied.full_name', 'applied.department', 'applied.designation_name')
            ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1)
            // ->where('applied.approved_ind', '!=', 1)
            // ->where('applied.approval_status_text', 'NOT LIKE', '%REJECTED%')
            ->where(DB::raw('trunc(applied.au_entry_at)'), '>=', $fromDate)
            ->where(DB::raw('trunc(applied.au_entry_at)'), '<=', $toDate)
            ->groupBy('applied.card_no', 'applied.person_no_fk', 'applied.full_name', 'applied.department', 'applied.designation_name')
            ->orderBy('applied.card_no', 'asc')->get();

            return Template::loadview("admin.v1.hrm.pending-leave-application.pending_leave_application", ['dept' => $dept, 'desig' => $desig, 'pendingLeavedata' => $pendingLeavedata, 'status'=> null]);  
       }
   
       public function searchPendingLeaveApplication(Request $request)
       {
            $query = DB::table('hrms_leave_entry_for_approval_vw applied')
            ->select('applied.card_no', 'applied.person_no_fk', 'applied.full_name', 'applied.department', 'applied.designation_name')
            ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1);
            // ->where('applied.approved_ind', '!=', 1)
            // ->where('applied.approval_status_text', 'NOT LIKE', '%REJECTED%');
            if (isset($request->from_date) &&  isset($request->to_date)) {
                $query->where(DB::raw('trunc(applied.au_entry_at)'), '>=', date('Y-m-d', strtotime($request->from_date)));
                $query->where(DB::raw('trunc(applied.au_entry_at)'), '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            if ($request->department != "") {
                $query->where('applied.serviceunit_no_fk', $request->department);
            }
            if ($request->card_hidn != "") {
                $query->where('applied.person_no_fk', $request->card_hidn);
            }
            $pendingLeavedata = $query->groupBy('applied.card_no', 'applied.person_no_fk','applied.full_name', 'applied.department', 'applied.designation_name')->orderBy('applied.card_no', 'asc')->get();
          
            return Template::loadview("admin.v1.hrm.pending-leave-application.pending_leave_application_list", ['pendingLeavedata' => $pendingLeavedata, 'status'=> 1]);
       }
       public function leaveDetail($id = ""){
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
				->where('PERSON_NO_PK', $id)
				->select('full_name', 'su_name', 'designation', 'person_code')
				->first();
				
		$info = DB::table('HRMS_PERSONAL_LEAVE_VW')
		->where('person_no_pk', $id)
		->get();

		$availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
        ->where('a.person_no_fk', $id)
        ->where('a.approved_ind', 1)
        ->where(DB::raw("TO_CHAR(a.TO_DATES, 'DD-Mon-YY')"), 'like', '%-' . date('y')) 
        ->orderBy('a.leave_no_pk', 'desc')
        ->get();
		// $appliedLeave = DB::table('hrms_leave_entry_for_approval_vw as applied')
        // ->where('applied.person_no_fk', $id)
        // ->where('applied.approved_ind', '!=', 1)
        // ->where('applied.approval_status_text', 'NOT LIKE', '%REJECTED%')
        // ->orderBy('applied.leave_no_pk', 'desc')
        // ->get();
        $appliedLeave = DB::table('hrms_leave_entry_for_approval_vw as applied')
            ->select('applied.leave_no_pk','applied.leave_type_name','applied.from_date','applied.to_dates','applied.leave_reason','applied.al_dayoff_date', 'sap.person_no_fk', 'sap.APPROVED_AT', 'sap.apprprocess_no_pk')
            ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
            ->where('applied.person_no_fk', $id)
            // ->where('sap.leave_no_fk', $leave)
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1)
            ->orderBy('applied.leave_no_pk', 'asc')
            ->get();
        // dd($appliedLeave);
		$po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return Template::loadview("admin.v1.hrm.pending-leave-application.leave_detail", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'info' => $info, 'availedInfo' => $availedInfo, 'appliedLeave' => $appliedLeave, 'personDetails' => $personDetails]);
		
	    }
        //hr approval
       public function hrApproval(Request $request)
       {
            $departments = DB::select(
                'select distinct SERVICEUNIT_NO_FK_DEPT, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.SERVICEUNIT_NO_FK_DEPT=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
            $units = DB::select(
                'select distinct serviceunit_no_fk, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.serviceunit_no_fk=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
           $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
           $fromDate = Carbon::now()->format('Y-m-d');
           $toDate = Carbon::now()->format('Y-m-d');

           $leaveType = DB::table('hrms_leavetype_days')    
           ->select('leave_type_lkp_no_fk','leave_type_lkp_name')
           ->where('status', 1)
           ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
           ->groupBy( 'leave_type_lkp_no_fk', 'leave_type_lkp_name',)
           ->orderBy('leave_type_lkp_name', 'asc')->get();
  
           $pendingLeavedata = DB::table('hrms_leave_entry_for_approval_vw applied')
            ->select('applied.card_no', 'applied.person_no_fk', 'applied.full_name', 'applied.department', 'applied.unit','applied.designation_name', 'applied.leave_no_pk', 'applied.leave_type_name', 'applied.from_date', 'applied.to_dates', 'applied.leave_reason')
            ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1)
            ->where(DB::raw('trunc(applied.au_entry_at)'), '>=', $fromDate)
            ->where(DB::raw('trunc(applied.au_entry_at)'), '<=', $toDate)
            ->orderBy('applied.card_no', 'asc')->get();

            return Template::loadview("admin.v1.hrm.hr_approval.hr_approval", ['desig' => $desig, 'pendingLeavedata' => $pendingLeavedata, 'status'=> null, 'leaveType' => $leaveType, 'departments' => $departments, 'units' => $units]);  
        }

       public function searchHrApprovalList(Request $request)
       {
            $query = DB::table('hrms_leave_entry_for_approval_vw applied')
            ->select('applied.card_no', 'applied.person_no_fk', 'applied.full_name', 'applied.department', 'applied.unit', 'applied.designation_name', 'applied.leave_no_pk', 'applied.leave_type_name', 'applied.from_date', 'applied.to_dates', 'applied.leave_reason')
            ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1);
            if (isset($request->from_date) &&  isset($request->to_date)) {
                $query->where(DB::raw('trunc(applied.au_entry_at)'), '>=', date('Y-m-d', strtotime($request->from_date)));
                $query->where(DB::raw('trunc(applied.au_entry_at)'), '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            if ($request->department != "") {
                $query->where('applied.serviceunit_no_fk', $request->department);
            }
            if ($request->unit != "") {
                $query->where('applied.serviceunit_no_fk', $request->unit);
            }
            if ($request->card_hidn != "") {
                $query->where('applied.person_no_fk', $request->card_hidn);
            }
            if ($request->leave_type != "") {
                $query->where('applied.leave_type_lkp_no_fk', $request->leave_type);
            }
            if ($request->day_no != "") {
                $query->whereRaw("(applied.to_dates - applied.from_date) + 1 = ?", [$request->day_no]);
            }
            $pendingLeavedata = $query->orderBy('applied.card_no', 'asc')->get();
            return Template::loadview("admin.v1.hrm.hr_approval.hr_approval_list", ['pendingLeavedata' => $pendingLeavedata, 'status'=> 1]);
       }

       public function employeeLeaveDetail($id = ""){
            ini_set("max_execution_time",0);
            $person = DB::table('wsec_user a')
            ->select('person_no_fk')
            ->where('user_no_pk', $id)
            ->first();

            $personDetails = DB::table('EMPLOYEE_INFO_VW')
                    ->where('PERSON_NO_PK', $id)
                    ->select('full_name', 'su_name', 'designation', 'person_code')
                    ->first();
                    
            $info = DB::table('HRMS_PERSONAL_LEAVE_VW')
            ->where('person_no_pk', $id)
            ->get();

            $availedInfo = DB::table('hrms_leave_entry_for_approval_vw as a')
            ->where('a.person_no_fk', $id)
            ->where('a.approved_ind', 1)
            ->where(DB::raw("TO_CHAR(a.TO_DATES, 'DD-Mon-YY')"), 'like', '%-' . date('y')) 
            ->orderBy('a.leave_no_pk', 'desc')
            ->get();
            $appliedLeave = DB::table('hrms_leave_entry_for_approval_vw as applied')
                ->select('applied.leave_no_pk','applied.leave_type_name','applied.from_date','applied.to_dates','applied.leave_reason','applied.al_dayoff_date', 'sap.person_no_fk', 'sap.APPROVED_AT', 'sap.apprprocess_no_pk')
                ->leftJoin('sysc_approvalprocess as sap', 'applied.leave_no_pk', '=', 'sap.leave_no_fk')
                ->where('applied.person_no_fk', $id)
                ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
                ->where('sap.approved_ind', '!=', 1)
                ->where('sap.reject_ind', '!=', 1)
                ->orderBy('applied.leave_no_pk', 'asc')
                ->get();
            $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

            return Template::loadview("admin.v1.hrm.hr_approval.employee_leave_detail", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'info' => $info, 'availedInfo' => $availedInfo, 'appliedLeave' => $appliedLeave, 'personDetails' => $personDetails]);
		
	    }

        public function check_leave_approval_status($leave_id = null){
            $leave_info = [];
            if(isset($leave_id)){
                $leaveApprovalData = DB::table('sysc_approvalprocess_vw')
                ->select('apprprocess_no_pk', 'approval_for_code', 'approved_ind', 'hold_ind', 'own_level')
                ->where('leave_no_fk', $leave_id)
                ->where('user_no_pk', Session()->get('user.ses_user_pk_no'))
                ->orderBy('approval_sequnece', 'desc')
                ->get();
            
                $own_level = isset($leaveApprovalData[0]->own_level) ? $leaveApprovalData[0]->own_level : null;
                $checkApprovalData = DB::table('sysc_approvalprocess_vw')
                ->select('apprprocess_no_pk', 'approval_for_code', 'approved_ind', 'hold_ind', 'own_level')
                ->where('leave_no_fk', $leave_id)
                ->where('own_level', '<', $own_level)
                ->get();
                
                if(count($checkApprovalData) > 0){
                    $approval_status = $checkApprovalData->every(fn($row) => $row->approved_ind == 1) ? 1 : 0;
                }elseif($leaveApprovalData[0]->own_level == 1){
                    $approval_status =1; 
                }else{
                    $approval_status =null; 
                }
                $hold_status = isset($leaveApprovalData[0]->hold_ind) ? ($leaveApprovalData[0]->hold_ind == 1 ? 1 : 0) : null;
                $leave_info['apprprocess_no_pk'] = isset($leaveApprovalData[0]->apprprocess_no_pk) ? $leaveApprovalData[0]->apprprocess_no_pk : null;
                $leave_info['approval_for_code'] = isset($leaveApprovalData[0]->approval_for_code) ? $leaveApprovalData[0]->approval_for_code : null;
                $leave_info['approval_status'] = $approval_status;
                $leave_info['hold_status'] = $hold_status;
            }else{
                $leave_info['apprprocess_no_pk'] = null;
                $leave_info['approval_for_code'] =  null;
                $leave_info['approval_status'] =  null;
                $leave_info['hold_status'] = null;
            }
            return $leave_info;
        }

        public function check_attendance_approval_status($attn_id = null){
            $attn_info = [];
            if(isset($attn_id)){
                $attnApprovalData = DB::table('sysc_approvalprocess_vw')
                ->select('apprprocess_no_pk', 'approval_for_code', 'approved_ind', 'hold_ind', 'own_level')
                ->where('primary_key_value', $attn_id)
                ->where('user_no_pk', Session()->get('user.ses_user_pk_no'))
                ->orderBy('approval_sequnece', 'desc')
                ->get();
            
                $own_level = isset($attnApprovalData[0]->own_level) ? $attnApprovalData[0]->own_level : null;
                $checkApprovalData = DB::table('sysc_approvalprocess_vw')
                ->select('apprprocess_no_pk', 'approval_for_code', 'approved_ind', 'hold_ind', 'own_level')
                ->where('primary_key_value', $attn_id)
                ->where('own_level', '<', $own_level)
                ->get();
                
                if(count($checkApprovalData) > 0){
                    $approval_status = $checkApprovalData->every(fn($row) => $row->approved_ind == 1) ? 1 : 0;
                }elseif($attnApprovalData[0]->own_level == 1){
                    $approval_status =1; 
                }else{
                    $approval_status =null; 
                }
                $hold_status = isset($attnApprovalData[0]->hold_ind) ? ($attnApprovalData[0]->hold_ind == 1 ? 1 : 0) : null;
                $attn_info['apprprocess_no_pk'] = isset($attnApprovalData[0]->apprprocess_no_pk) ? $attnApprovalData[0]->apprprocess_no_pk : null;
                $attn_info['approval_for_code'] = isset($attnApprovalData[0]->approval_for_code) ? $attnApprovalData[0]->approval_for_code : null;
                $attn_info['approval_status'] = $approval_status;
                $attn_info['hold_status'] = $hold_status;
            }else{
                $attn_info['apprprocess_no_pk'] = null;
                $attn_info['approval_for_code'] =  null;
                $attn_info['approval_status'] =  null;
                $attn_info['hold_status'] = null;
            }
            return $attn_info;
        }

        public function hrAttendanceApproval(Request $request)
        {
            $departments = DB::select(
                'select distinct serviceunit_no_fk_dept, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.SERVICEUNIT_NO_FK_DEPT=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
            $units = DB::select(
                'select distinct serviceunit_no_fk, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.serviceunit_no_fk=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
            $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
            $fromDate = Carbon::now()->format('Y-m-d');
            $toDate = Carbon::now()->format('Y-m-d');
 
            $pendingAttData = DB::table('hrms_attrequest_vw att')
             ->select('att.person_card_no', 'att.full_name', 'att.department', 'att.designation_name','att.unit', 'att.attendance_date', 'att.in_time', 'att.out_time', 'att.remarks', 'att.requsition_no_pk')
             ->leftJoin('sysc_approvalprocess as sap', 'att.requsition_no_pk', '=', 'sap.primary_key_value')
             ->where('sap.approval_for_code', '=', 'ATTNREQ')
             ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
             ->where('sap.approved_ind', '!=', 1)
             ->where('sap.reject_ind', '!=', 1)
             ->where(DB::raw('trunc(att.req_date)'), '>=', $fromDate)
             ->where(DB::raw('trunc(att.req_date)'), '<=', $toDate)
             ->orderBy('att.person_card_no', 'asc')->get();

             return Template::loadview("admin.v1.hrm.hr_approval.hr_approval_attendance", ['departments' => $departments, 'units' => $units,'desig' => $desig, 'pendingAttData' => $pendingAttData, 'status'=> null]);  
         }

        public function searchHrApprovalAttnList(Request $request)
        {
            $query = DB::table('hrms_attrequest_vw att')
            ->select('att.person_card_no', 'att.full_name', 'att.department', 'att.designation_name','att.unit', 'att.attendance_date', 'att.in_time', 'att.out_time', 'att.remarks', 'att.requsition_no_pk')
            ->leftJoin('sysc_approvalprocess as sap', 'att.requsition_no_pk', '=', 'sap.primary_key_value')
            ->where('sap.approval_for_code', '=', 'ATTNREQ')
            ->where('sap.person_no_fk', Session()->get('user.ses_person_no_fk'))
            ->where('sap.approved_ind', '!=', 1)
            ->where('sap.reject_ind', '!=', 1);
            if (isset($request->from_date) &&  isset($request->to_date)) {
                $query->where(DB::raw('trunc(att.req_date)'), '>=', date('Y-m-d', strtotime($request->from_date)));
                $query->where(DB::raw('trunc(att.req_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
            }
            if ($request->department != "") {
                $query->where('att.serviceunit_no_fk_dept', $request->department);
            }
            if ($request->unit != "") {
                $query->where('att.serviceunit_no_fk', $request->unit);
            }
            if ($request->card_hidn != "") {
                $query->where('att.person_no_pk', $request->card_hidn);
            }
            $pendingAttData = $query->orderBy('att.person_card_no', 'asc')->get();
            return Template::loadview("admin.v1.hrm.hr_approval.hr_approval_attn_list", ['pendingAttData' => $pendingAttData, 'status'=> 1]);
        }
}
