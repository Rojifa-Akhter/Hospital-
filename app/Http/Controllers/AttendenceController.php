<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RosterRequest;
use App\Models\shift;
use App\Library\Template;
use App\Models\ManualAttendence;
use App\Models\Roster;
use App\Models\Savingfund;
use App\Models\EmployeeRoster;
use App\Models\SalaryBonus;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\BankWiseService;
use App\Models\ServiceUnit;
use App\Models\Designation;
use DB;
use Auth;
use PDO;
use \PDF;
use Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Traits\LookupData;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
use DateTime;

class AttendenceController extends Controller
{

    use LookupData, DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(ManualAttendence $ManualAttendence, Roster $Roster, EmployeeRoster $EmployeeRoster, Savingfund $savingfund, SalaryBonus $salaryBonus, BankWiseService $BankWiseService)

    {
        $this->middleware('auth');

        $this->model = new Repo($ManualAttendence);
        $this->model2 = new Repo($Roster);
        $this->model4 = new Repo($savingfund);
        $this->model3 = new Repo($EmployeeRoster);
        $this->model5 = new Repo($salaryBonus);
        $this->model_bank_charge = new Repo($BankWiseService);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date("d-M-Y");
        $shift = DB::SELECT("SELECT shift_no_pk,shift_code,shift_desc, start_time,end_time FROM hrms_shift where status = 1");
        // dd($shift);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $attendence_data = DB::select("select '' sl, personnel.photo_name,trunc(daily.attendance_date) attendance_date, daily.person_card_no,personnel.full_name,service.serviceunit_name,designation.designation_name,shift.shift_code,daily.in_time, daily.out_time, daily.duty_in_time,daily.duty_out_time,daily.lunch_out_time,daily.lunch_in_time,daily.over_time_min,daily.late_time_min, daily.mattendance_no_pk, rownum rownumber, daily.au_update_at,daily.au_entry_at from hrms_attendance_daily_manual daily left join hrms_shift shift on daily.duty_shift_no_fk = shift.shift_no_pk left join hrms_personnel personnel on daily.person_card_no = personnel.card_no left join hrms_designation designation on personnel.jobtitle_lookup_no_fk = designation.designation_no_pk left join sysc_serviceunit service on personnel.serviceunit_no_fk = service.serviceunit_no_pk where trunc(daily.attendance_date) =to_date('$date','dd/mm/yyyy') and daily.au_entry_hospital_pk_no=$hospital_id order by attendance_date ASC");;
        return Template::loadview("admin.hrm.attendence.manual_attendence", ['shift' => $shift, 'attendence_data' => $attendence_data]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $date = date('d/m/Y');
        $validateData = $request->validate([
            // 'attendance_date' => 'required',
            // 'person_card_no' => 'required',
            // 'duty_shift_no_fk' => 'required',
        ]);
        //return $request;
        $card_num = DB::table('hrms_personnel')->select('card_no')->where('person_no_pk', $request->card_num)->first();
        // dd($card_num->person_code);
        $id = $request->id;

        if (date('H:i', strtotime($request->in_time)) > date('H:i', strtotime($request->shift_start_time))) {
            $duty_time = date('H:i', strtotime($request->in_time) - strtotime($request->shift_start_time));
            $timesplit = explode(':', $duty_time);
            $late_min = ($timesplit[0] * 60) + ($timesplit[1]);
        } else {
            $late_min = '';
        }


        $au_update_at = Carbon::now();
        $au_update_at = $au_update_at->toDateString();

        // dd($late_min);
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            // dd(date("Y-m-d h:m:s",strtotime($request->out_time)),date("Y-m-d h:m:s",strtotime($request->in_time)));


            if ($id == null) {
                $data = [
                    'attendance_date' =>  date("Y-m-d", strtotime($request->attendence_date)),
                    'person_card_no' => $card_num->card_no,
                    'duty_shift_no_fk' => $request->shift_type,
                    'duty_in_time' =>  date("Y-m-d H:i", strtotime($request->shift_start_time)),
                    'duty_out_time' =>  date("Y-m-d H:i", strtotime($request->shift_end_time)),
                    'in_time' => ($request->in_time != '') ? date("Y-m-d H:i", strtotime($request->in_time)) : '',
                    'out_time' => ($request->out_time != '') ? date("Y-m-d H:i", strtotime($request->out_time)) : '',
                    'late_time_min' => $late_min,
                    'lunch_out_time' => ($request->lunch_out != '') ? date("Y-m-d H:i", strtotime($request->lunch_out)) : '',
                    'lunch_in_time' => ($request->lunch_in != '') ? date("Y-m-d H:i", strtotime($request->lunch_in)) : '',
                    'remarks' => $request->remarks ? $request->remarks : '',
                    // 'status' => $request->manual_status ? 1 : null,
                    'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'au_entry_session' => 1,
                    // 'au_entry_by' => 1,
                    // 'au_entry_at' => $date,
                    'entry_type' => 1,
                ];
                // dd($data);
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model->create($data);
            } else {

                if (date('H:i', strtotime($request->in_time1)) > date('H:i', strtotime($request->shift_start_time1))) {
                    $duty_time = date('H:i', strtotime($request->in_time1) - strtotime($request->shift_start_time1));
                    $timesplit = explode(':', $duty_time);
                    $late_min = ($timesplit[0] * 60) + ($timesplit[1]);
                } else {
                    $late_min = '';
                }

                $attendance_date = date("Y-m-d", strtotime($request->attendence_date1));

                $data = [
                    'attendance_date' => $attendance_date,
                    'person_card_no' => $request->card_num1,
                    'duty_shift_no_fk' => $request->shift_type1,
                    'duty_in_time' => date("Y-m-d H:i", strtotime($request->shift_start_time1)),
                    'duty_out_time' => date("Y-m-d H:i", strtotime($request->shift_end_time1)),
                    'in_time' => ($request->in_time1 != '') ? date("Y-m-d H:i", strtotime($request->in_time1)) : '',
                    'out_time' => ($request->out_time1 != '') ? date("Y-m-d H:i", strtotime($request->out_time1)) : '',
                    'late_time_min' => $late_min,
                    'lunch_in_time' => ($request->lunch_in != '') ? date("Y-m-d H:i", strtotime($request->lunch_in)) : '',
                    'lunch_out_time' => ($request->lunch_out != '') ? date("Y-m-d H:i", strtotime($request->lunch_out)) : '',
                    'remarks' => $request->remarks ? $request->remarks : '',
                    // 'status' => $request->manual_status ? 1 : null,
                    'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'au_entry_session' => "Session",
                    // 'au_entry_by' => 1,
                    // 'au_entry_at' => $date,
                    'entry_type' => 1,
                ];

                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;

                $this->model->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function searchEmployee(Request $request)
    {
        $card_num = $request->employee_code_search;

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $card_num_cond = ($card_num != '') ? $card_num : '';
        $attendence_data = DB::select("select '' sl, personnel.photo_name,to_char(daily.attendance_date,'DD/MM/YYYY') attendance_date, daily.person_card_no,personnel.full_name,service.serviceunit_name,designation.designation_name,shift.shift_code,daily.in_time, daily.out_time, daily.duty_in_time,daily.duty_out_time,daily.lunch_out_time,daily.lunch_in_time,daily.over_time_min,daily.late_time_min, daily.mattendance_no_pk, rownum rownumber, daily.au_update_at,daily.au_entry_at from hrms_attendance_daily_manual daily left join hrms_shift shift on daily.duty_shift_no_fk = shift.shift_no_pk left join hrms_personnel personnel on daily.person_card_no = personnel.card_no left join hrms_designation designation on personnel.jobtitle_lookup_no_fk = designation.designation_no_pk left join sysc_serviceunit service on personnel.serviceunit_no_fk = service.serviceunit_no_pk
    		where daily.person_card_no = '$card_num_cond' and  daily.au_entry_hospital_pk_no= $ses_hospital_id order by attendance_date ASC");

        // dd($attendence_data);
        return Template::loadview('admin.hrm.attendence.manual_attendence_list', ['attendence_data' => $attendence_data]);
    }
    

    public function manualAttendenceEdit($id)
    {
        $attendence_data = $this->model->show($id);
                 $date   = date("d-M-Y");
                 $shift  = DB::SELECT("SELECT shift_no_pk,shift_code,shift_desc,start_time,end_time FROM hrms_shift where status = 1");
        return template::loadview('admin.hrm.attendence.attendence_popup', ['attendence_data' => $attendence_data, 'shift' => $shift]);
    }
    public function manualAttendenceDelete(Request $request)
    {
        $attendence_data = $this->model->delete($request->attendence);
    }
    public function deleteManualOvertime(Request $request)
    {
        DB::table('hrms_over_time_requisition_manual')->where('over_time_req_no_pk', $request->over_time_req_no_pk)->delete();
        DB::commit();
        $message = ['msg' => 'Data Deleted Successfully', 'title' => 'Success'];
    }

    public function manualOvertime()
    {
        $date = date("d-M-Y");
        $shift = DB::SELECT("SELECT shift_no_pk,shift_code,shift_desc, start_time,end_time FROM hrms_shift where status = 1");

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $attendence_data = DB::select("select '' sl, personnel.photo_name,trunc(daily.attendance_date) attendance_date, daily.person_card_no,personnel.full_name,service.serviceunit_name,designation.designation_name, daily.over_time, daily.over_time_req_no_pk from hrms_over_time_requisition_manual daily left join hrms_personnel personnel on daily.person_card_no = personnel.card_no left join hrms_designation designation on personnel.jobtitle_lookup_no_fk = designation.designation_no_pk left join sysc_serviceunit service on personnel.serviceunit_no_fk = service.serviceunit_no_pk where trunc(daily.attendance_date) =to_date('$date','dd/mm/yyyy') and daily.au_entry_hospital_pk_no=$hospital_id order by attendance_date ASC");


        return Template::loadview("admin.hrm.attendence.manual_overtime", ['attendence_data' => $attendence_data]);
    }

    public function editManualOvertime($id)
    {

        $attendence_data = DB::table('hrms_over_time_requisition_manual')->first();
        $date = date("d-M-Y");
        $shift = DB::SELECT("SELECT shift_no_pk,shift_code,shift_desc,start_time,end_time FROM hrms_shift where status = 1");

        return template::loadview('admin.hrm.attendence.manual_overtime_popup', ['attendence_data' => $attendence_data, 'shift' => $shift]);
    }

    public function storeManualOvertime(Request $request)
    {
        $card_num = DB::table('hrms_personnel')->select('card_no')->where('person_no_pk', $request->card_num)->first();

        $id = $request->id;

        if (date('H:i', strtotime($request->in_time)) > date('H:i', strtotime($request->shift_start_time))) {
            $duty_time = date('H:i', strtotime($request->in_time) - strtotime($request->shift_start_time));
            $timesplit = explode(':', $duty_time);
            $late_min = ($timesplit[0] * 60) + ($timesplit[1]);
        } else {
            $late_min = '';
        }

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        // dd($late_min);
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sequence = DB::getSequence();
        DB::beginTransaction();
        try {
            if ($id == null) {
                $over_time_req_no_pk = $sequence->nextValue('over_time_req_no_pk_seq');
                $data = [
                    'attendance_date' =>  date("Y-m-d", strtotime($request->attendence_date)),
                    'person_card_no' => $card_num->card_no,
                    'over_time' => $request->overtime,
                    'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'au_entry_by' => $auth_id,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_session' => "overtime",
                    'over_time_req_no_pk' => $over_time_req_no_pk
                ];

                DB::table("hrms_over_time_requisition_manual")->insert($data);
            } else {

                if (date('H:i', strtotime($request->in_time1)) > date('H:i', strtotime($request->shift_start_time1))) {
                    $duty_time = date('H:i', strtotime($request->in_time1) - strtotime($request->shift_start_time1));
                    $timesplit = explode(':', $duty_time);
                    $late_min = ($timesplit[0] * 60) + ($timesplit[1]);
                } else {
                    $late_min = '';
                }

                $attendance_date = date("Y-m-d", strtotime($request->attendence_date1));
                // dd($request->card_num1);
                $data = [
                    'attendance_date' =>  $attendance_date,
                    'person_card_no' => $request->card_num1,
                    'over_time' => $request->overtime,
                    'au_update_hospital_pk_no' =>  $ses_hospital_id,
                    'au_update_by' => $auth_id,
                    'au_update_at' => $au_entry_at
                ];

                DB::table("hrms_over_time_requisition_manual")->where('over_time_req_no_pk', $id)->update($data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    //process attendence ..
    public function process_attendance(Request $request)
    {
        $status = $this->getLookupListByCode('ATTENDANCE');

        // $query = DB::table("hrms_attendance_daily daily")
        // ->select('personnel.photo_name','daily.attendance_date', 'daily.person_card_no','personnel.full_name','service.serviceunit_name','designation.designation_name','shift.shift_code','daily.in_time', 'daily.out_time', 'daily.duty_in_time','daily.duty_out_time','daily.lunch_out_time','daily.lunch_in_time','daily.over_time_min','daily.late_time_min', 'daily.attendance_no_pk')
        // ->leftJoin('hrms_shift shift', 'daily.duty_shift_no_fk' ,'shift.shift_no_pk')
        // ->leftJoin('hrms_personnel personnel','daily.person_no_fk', 'personnel.person_no_pk')
        // ->leftJoin('hrms_designation designation','personnel.jobtitle_lookup_no_fk' ,
        //    'designation.designation_no_pk')
        // ->leftJoin('sysc_serviceunit service','personnel.serviceunit_no_fk' ,'service.serviceunit_no_pk');
        // if (!empty($request->date_pic)) {
        //     $query->where(('daily.attendance_date'), date('Y-m-d', strtotime($request->date_pic)));
        // }
        return template::loadview('admin.hrm.attendence.process_attendance', [
            'status' => $status,

            // 'attendence_data' => $query
            // ->orderBy('daily.attendance_date', 'DESC')
            // ->get()
            // ->toArray()
        ]);
    }
    //process attendance cutoff
    public function processAttendanceCutoff(Request $request)
    {
        $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
        from sysc_serviceunit unit,hrms_personnel per
        where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
        order by 2');
        return template::loadview('admin.hrm.attendence.process_attendance_cut_off', [
            'service_unit' => $service_unit
        ]);
    }
    public function attendenceCutoffStore(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $year = $request->year;
            $month = $request->month;
            $month_year = $year . $month;
            $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
            if (isset($salaryData) && $salaryData->cut_off_ind == 1) {
                $startDate = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
                $endtDate = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
            } else {
                $startDate = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
                $endtDate = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
            }
            $procedureName = "pkg_v1_hrms_payroll.prc_v1_attendance_monthly ";
            $outError = $out_invoice_id = $out_invoice_no = '';

            $dataBindingArr = [
                'in_from_dt' => $startDate,
                'in_to_dt' => $endtDate,
                'in_au_entry_by' => Auth::id(),
                'in_au_entry_session' => 'session',
                'in_au_entry_hospital_pk_no' => $ses_hospital_id,
                'out_process_no_pk' => [
                    'value' => &$out_invoice_no,
                    'type' => PDO::PARAM_INT
                ],
                'out_process_uid' => [
                    'value' => &$out_invoice_id,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ],
                'out_error' => [
                    'value' => &$outError,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ]
            ];
            // dd($dataBindingArr);
            $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'Attendance Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Attendance Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function attendenceCutOffSearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $year = $request->year;
        $month = $request->month;

        $attendence_month = $year . '' . $month;
        $department = $request->department;
        $card_num = $request->card_num;
        //dd($card_num);

        $query = DB::table("hrms_attendance_monthly_v1 m")
            ->select(
                'm.person_card_no',
                'p.full_name',
                's.serviceunit_no_pk',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk',
                'd.designation_name',
                's.serviceunit_name',
                's.serviceunit_code',
                'm.month_attend_no_pk',
                'm.attendance_yyyymm',
                'm.month_days',
                'm.working_days',
                'm.attendance_days',
                'p.person_code',
                'p.serviceunit_no_fk',
                'p.job_type_lookup_no_fk',
                'p.person_no_pk',
                'm.late_days',
                'm.absent_days',
                'm.late_days',
                'm.leave_days',
                'm.leave_withoutpay_days',
                'm.amount_deduct',
                'm.amount_allowance',
                'm.status',
                // 'm.holiday',
                'm.casual_leave',
                'm.sick_leave',
                'm.general_festival_days',
                'm.holidays',
                'm.ot_time',
                'jobtype.serial_no'
            )
            ->leftjoin('hrms_personnel p', 'm.person_card_no', 'p.person_code')
            ->leftjoin('sysc_lookupdata jobtype', 'jobtype.lookupdata_no_pk', 'p.job_type_lookup_no_fk')
            ->leftjoin('sysc_serviceunit s', 'p.serviceunit_no_fk', 's.serviceunit_no_pk')
            ->leftjoin(
                'hrms_designation d',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk'
            )
            ->where('m.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('p.employee_ind', 1)
            ->where('p.status', 1)
            ->where('p.virtual_ind', '!=', 1);


        if (!empty($attendence_month)) {
            $query->where('m.attendance_yyyymm', $attendence_month);
        }
        if (!empty($department)) {
            $query->where('p.serviceunit_no_fk', $department);
        }
        if (!empty($card_num)) {
            $query->where('p.person_no_pk', $card_num);
        }
        $data = $query
            ->orderBy('jobtype.serial_no', 'ASC')
            ->orderBy('m.person_card_no', 'ASC')
            ->orderBy('m.au_entry_at', 'DESC')
            ->get()
            ->toArray();
        return template::loadview('admin.hrm.attendence.process_attendance_cut_off_list', [
            "data" => $data
        ]);
    }
    
    public function checkInOutProcess()
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $out_error = "";
        // DB::select('EXEC pkg_machine_att.prc_machine_att_wp_live_scheduler');
        $pdo2 = DB::getPdo();
        $in_out = $pdo2->prepare("begin pkg_machine_att.prc_machine_att_wp_live_scheduler_app(
            :in_in_au_entry_hospital_pk_no,
            :out_error);
            end;");

        $in_out->bindParam(':in_in_au_entry_hospital_pk_no', $hospital_id);
        $in_out->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        $in_out->execute();
        // dd($in_out);

        if ($out_error == 999) {
            DB::rollback();
            $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
        } else {
            DB::commit();
            $message = ['msg' => ' successfully. ', 'title' => 'Success'];
        }

        // $message = ['msg' => 'successfully',  'title' => 'Success'];
        return response()->json($message);
    }


    public function monthlyAttendencestore(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {

            $year = $request->year;
            $month = $request->month;

            $procedureName = "pkg_hrms_payroll.prc_attendance_monthly";
            $outError = $out_invoice_id = $out_invoice_no = '';
            $dataBindingArr = [
                'in_yyyymm' => $year . '' . $month,
                'in_au_entry_by' => Auth::id(),
                'in_au_entry_session' => 'session',
                'in_au_entry_hospital_pk_no' => $ses_hospital_id,
                'out_process_no_pk' => [
                    'value' => &$out_invoice_no,
                    'type' => PDO::PARAM_INT
                ],
                'out_process_uid' => [
                    'value' => &$out_invoice_id,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ],
                'out_error' => [
                    'value' => &$outError,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ]
            ];
            $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'Attendance Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Attendance Process Failed' . $outError, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function process_attendance_daily_store(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        // dd($request);
        DB::beginTransaction();
        try {

            $procedureName = "pkg_hrms_payroll.prc_attendance_daily_wp";
            $outError = $out_invoice_id = $out_invoice_no = '';
            $daily_date = isset($request->daily_date) ? $request->daily_date : "0";


            $dataBindingArr = [
                'in_date_from' => date('Y-m-d', strtotime($request->from_date)),
                'in_date_to' => ($daily_date == 1) ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d', strtotime($request->to_date)),
                'in_au_entry_by' => Auth::id(),
                'in_au_entry_session' => 'session',
                'in_au_entry_hospital_pk_no' =>  $ses_hospital_id,
                'out_process_no_pk' => [
                    'value' => &$out_invoice_no,
                    'type' => PDO::PARAM_INT
                ],
                'out_process_uid' => [
                    'value' => &$out_invoice_id,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ],
                'out_error' => [
                    'value' => &$outError,
                    'type' => PDO::PARAM_STR,
                    'length' => 500
                ]
            ];
            // dd($dataBindingArr);



            $result = DB::executeProcedure($procedureName, $dataBindingArr);

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'Attendance Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Attendance Process Failed' . $outError, 'title' => 'Error'];
                dd($outError);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function process_attendance_daily_store_v1(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($request);
        DB::beginTransaction();
        try {
           
            $outError = $out_invoice_id = $out_invoice_no = '';
            $daily_date = isset($request->daily_date) ? $request->daily_date : "0";
            $card_hidn = $request->card_hidn;
            if(isset($request->card_hidn)){
                $procedureName = "pkg_hrms_payroll.prc_attendance_unit_daily_wp";
                $dataBindingArr = [
                    'in_date_from' => date('Y-m-d', strtotime($request->from_date)),
                    'in_date_to' => ($daily_date == 1) ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d', strtotime($request->to_date)),
                    'in_person_no_pk' => $card_hidn,
                    'in_au_entry_by' => Auth::id(),
                    'in_au_entry_session' => 'session',
                    'in_au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'out_process_no_pk' => [
                        'value' => &$out_invoice_no,
                        'type' => PDO::PARAM_INT
                    ],
                    'out_process_uid' => [
                        'value' => &$out_invoice_id,
                        'type' => PDO::PARAM_STR,
                        'length' => 500
                    ],
                    'out_error' => [
                        'value' => &$outError,
                        'type' => PDO::PARAM_STR,
                        'length' => 500
                    ]
                ];
                $result = DB::executeProcedure($procedureName, $dataBindingArr);  

            }else{
                $procedureName = "pkg_hrms_payroll.prc_attendance_daily_wp";
                $dataBindingArr = [
                    'in_date_from' => date('Y-m-d', strtotime($request->from_date)),
                    'in_date_to' => ($daily_date == 1) ? date('Y-m-d', strtotime($request->from_date)) : date('Y-m-d', strtotime($request->to_date)),
                    'in_au_entry_by' => Auth::id(),
                    'in_au_entry_session' => 'session',
                    'in_au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'out_process_no_pk' => [
                        'value' => &$out_invoice_no,
                        'type' => PDO::PARAM_INT
                    ],
                    'out_process_uid' => [
                        'value' => &$out_invoice_id,
                        'type' => PDO::PARAM_STR,
                        'length' => 500
                    ],
                    'out_error' => [
                        'value' => &$outError,
                        'type' => PDO::PARAM_STR,
                        'length' => 500
                    ]
                ];

                $result = DB::executeProcedure($procedureName, $dataBindingArr);
            }

            if ($outError == '000') {
                DB::commit();
                $message = ['msg' => 'Attendance Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Attendance Process Failed' . $outError, 'title' => 'Error'];
                dd($outError);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function processAttendenceSearchByDate(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');


        $query = DB::table("hrms_attendance_daily daily")

            ->select('personnel.photo_name', 'daily.attendance_date', 'daily.person_card_no', 'personnel.full_name', 'service.serviceunit_name', 'designation.designation_name', 'shift.shift_code', 'daily.in_time', 'daily.out_time', 'daily.duty_in_time', 'daily.duty_out_time', 'daily.lunch_out_time', 'daily.lunch_in_time', 'daily.over_time_min', 'daily.late_time_min', 'daily.attendance_no_pk')
            ->leftJoin('hrms_shift shift', 'daily.duty_shift_no_fk', 'shift.shift_no_pk')
            ->leftJoin('hrms_personnel personnel', 'daily.person_no_fk', 'personnel.person_no_pk')
            ->leftJoin(
                'hrms_designation designation',
                'personnel.jobtitle_lookup_no_fk',
                'designation.designation_no_pk'
            )
            ->leftJoin('sysc_serviceunit service', 'personnel.serviceunit_no_fk', 'service.serviceunit_no_pk')
            ->where(('daily.attendance_date'), date('Y-m-d', strtotime($request->date_pic)))
            ->where('daily.au_entry_hospital_pk_no', $ses_hospital_id);

        return template::loadview('admin.hrm.attendence.process_attendance_list', [
            'attendence_data' => $query
                ->orderBy('daily.attendance_date', 'DESC')
                ->get()
                ->toArray(),
        ]);
    }

    public function processAttendenceSearch(Request $request)
    {

        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $query = DB::table("hrms_attendance_daily daily")

            ->select('personnel.photo_name', 'daily.attendance_date', 'daily.entry_type', 'daily.person_card_no', 'personnel.full_name', 'service.serviceunit_name', 'designation.designation_name', 'shift.shift_code', 'daily.in_time', 'daily.out_time', 'daily.duty_in_time', 'daily.duty_out_time', 'daily.lunch_out_time', 'daily.lunch_in_time', 'daily.over_time_min', 'daily.late_time_min', 'daily.attendance_no_pk', 'daily.manual_status')
            ->leftJoin('hrms_shift shift', 'daily.duty_shift_no_fk', 'shift.shift_no_pk')
            ->leftJoin('hrms_personnel personnel', 'daily.person_no_fk', 'personnel.person_no_pk')
            ->leftJoin(
                'hrms_designation designation',
                'personnel.jobtitle_lookup_no_fk',
                'designation.designation_no_pk'
            )
            ->leftJoin('sysc_serviceunit service', 'personnel.serviceunit_no_fk', 'service.serviceunit_no_pk')
            ->where('personnel.au_entry_hospital_pk_no', $hospital_id);


        if (!empty($request->status)) {
            $query->where('attendance_status', $request->status);
        }
        if (!empty($request->card_num)) {
            $query->where('daily.person_no_fk', $request->card_num);
        }
        if (!empty($request->date_pic)) {
            $query->where('attendance_date', date('Y-m-d', strtotime($request->date_pic)));
        }

        return template::loadview('admin.hrm.attendence.process_attendance_list', [
            'attendence_data' => $query
                ->orderBy('daily.attendance_date', 'DESC')
                ->get()
                ->toArray(),
        ]);
    }

    //salary process
    public function salaryProcessStore(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $year2 = $request->year;
        $month2 = $request->month;
        $year_month2 = $year2 . $month2;
        $salary_ind = DB::table('hrms_personnel_salary_process')->select('salary_yyyymm', 'salary_lock_ind')->where('salary_yyyymm', $year_month2)->first();

        $salary_lock = !empty($salary_ind) ? $salary_ind->salary_lock_ind != 1 : $year2 != "" && $month2 != "";
        // dd($salary_lock);
        if ($salary_lock) {


            DB::beginTransaction();
            try {
                $year = $request->year;
                $month = $request->month;
                $procedureName = "pkg_v1_hrms_payroll.prc_v1_salarycalc";
                $outError = $out_invoice_id = $out_process_no_pk = '';
                $dataBindingArr = [
                    'in_yyyymm' => $year . '' . $month,
                    'in_salary_bonus_ind' => 1,
                    'in_proceau_entry_by' => Auth::id(),
                    'in_au_entry_session' => 'session',
                    'in_au_entry_hospital_pk_no' => $hospital_id,
                    'out_process_no_pk' => [
                        'value' => &$out_process_no_pk,
                        'type' => PDO::PARAM_INT
                    ],
                    'out_process_uid' => [
                        'value' => &$out_invoice_id,
                        'type' => PDO::PARAM_STR,
                        'length' => 500
                    ],
                    'out_error' => [
                        'value' => &$outError,
                        'type' => PDO::PARAM_STR,
                        'length' => 1000
                    ]
                ];

                $result = DB::executeProcedure($procedureName, $dataBindingArr);
                //echo $outError;
                //dd($result);
                if ($outError == '000') {

                    DB::commit();
                    $message = ['msg' => 'Salary Process completed successfully.', 'title' => 'Success'];
                } else {

                    DB::rollback();
                    $message = ['msg' => 'Salary Process Failed' . $outError, 'title' => 'Error'];
                }
            } catch (\Exception $e) {

                DB::rollback();
                $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            // return "Salary Lock For This Month and Year"
        } else {
            $message = ['msg' => 'Salary Lock For This Month ', 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function salaryProcessIndex()
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $data = DB::select("select per.card_no,per.FULL_NAME,s.SERVICEUNIT_NAME , ms.gross_salary,ms.basic_salary,ms.medical_allowance,ms.house_rent,ms.attendance_bonus,ms.conveyance_allowance,ms.utility_allowance,
    		ms.other_allowance,ms.festival_bonus_amount,ms.loan_deduct_amount,pf.pf_bank_name,ms.att_deduct_amount,g.grade_name,p.salary_yyyymm,p.au_entry_at from hrms_personnel per
    		left join sysc_serviceunit s
    		on per.serviceunit_no_fk=s.serviceunit_no_pk left join hrms_personnel_salary_monthly ms
    		on ms.person_no_fk=per.person_no_pk left join hrms_grade g
    		on ms.grade_no_fk=G.GRADE_NO_PK left join hrms_personnel_salary_process p
    		on P.PROCESS_NO_PK=ms.process_no_fk left join hrms_provident_fund_setup pf
    		on PF.PF_NO_PK=ms.PF_NO_fk where s.au_entry_hospital_pk_no = $hospital_id AND employee_ind=1 and virtual_ind != 1 order By p.au_entry_at Desc ");


        return template::loadview('admin.hrm.salaryProcess.salary_process', ['data' => $data]);
    }
    public function salaryProcessSearch(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $year = $request->year;
        $month = $request->month;
        $year_month = $request->year . $request->month;
        $data = db::table('hrms_personnel_salary_monthly ms')
            ->select(
                'per.card_no',
                'per.full_name',
                's.serviceunit_name',
                'ms.gross_salary',
                'ms.basic_salary',
                'ms.medical_allowance',
                'ms.house_rent',
                'ms.attendance_bonus',
                'ms.conveyance_allowance',
                'ms.utility_allowance',
                'ms.other_allowance',
                'ms.festival_bonus_amount',
                'ms.loan_deduct_amount',
                'ms.pf_presonnel_amount',
                'ms.other_deduct_amount',
                'ms.att_deduct_amount',
                'ms.salary_advance_amount',
                'g.grade_name',
                'p.salary_yyyymm',
                'p.au_entry_at'
            )
            ->leftjoin('hrms_personnel per', 'ms.person_no_fk', 'per.person_no_pk')
            ->leftjoin('sysc_serviceunit s', 'per.serviceunit_no_fk', 's.serviceunit_no_pk')
            ->leftjoin('hrms_grade g', 'ms.grade_no_fk', 'g.grade_no_pk')
            ->leftjoin('hrms_personnel_salary_process p', 'p.process_no_pk', 'ms.process_no_fk')
            ->leftjoin('hrms_provident_fund_setup pf', 'pf.pf_no_pk', 'ms.pf_no_fk')
            ->where('p.salary_yyyymm', $year_month)
            ->where('ms.au_entry_hospital_pk_no', $hospital_id)
            ->orderby('p.au_entry_at', 'desc')
            ->get();
        return template::loadview('admin.hrm.salaryProcess.salary_process_list', ['data' => $data]);
    }

    // Attendence Monthly..

    public function attendenceMonthlyData()
    {
        $serviceunit_name = DB::table('sysc_serviceunit')->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        // dd($serviceunit_name);
        return template::loadview('admin.hrm.monthlyAttendence.month_view', ['depart' => $serviceunit_name]);
    }

    public function attendenceMonthlySearch(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $year = $request->year;
        $month = $request->month;

        $attendence_month = $year . '' . $month;
        $department = $request->department;
        $card_num = $request->card_num;
        //dd($card_num);

        $query = DB::table("hrms_attendance_monthly m")
            ->select(
                'm.person_card_no',
                'p.full_name',
                's.serviceunit_no_pk',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk',
                'd.designation_name',
                's.serviceunit_name',
                's.serviceunit_code',
                'm.month_attend_no_pk',
                'm.attendance_yyyymm',
                'm.month_days',
                'm.working_days',
                'm.attendance_days',
                'p.person_code',
                'p.serviceunit_no_fk',
                'p.job_type_lookup_no_fk',
                'p.person_no_pk',
                'm.late_days',
                'm.absent_days',
                'm.late_days',
                'm.leave_days',
                'm.leave_withoutpay_days',
                'm.amount_deduct',
                'm.amount_allowance',
                'm.status',
                // 'm.holiday',
                'm.casual_leave',
                'm.sick_leave',
                'm.general_festival_days',
                'm.holidays',
                'm.ot_time',
                'jobtype.serial_no'
            )
            ->leftjoin('hrms_personnel p', 'm.person_card_no', 'p.person_code')
            ->leftjoin('sysc_lookupdata jobtype', 'jobtype.lookupdata_no_pk', 'p.job_type_lookup_no_fk')
            ->leftjoin('sysc_serviceunit s', 'p.serviceunit_no_fk', 's.serviceunit_no_pk')
            ->leftjoin(
                'hrms_designation d',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk'
            )
            ->where('m.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('p.employee_ind', 1)
            ->where('p.status', 1)
            ->where('p.virtual_ind', '!=', 1);


        if (!empty($attendence_month)) {
            $query->where('m.attendance_yyyymm', $attendence_month);
        }
        if (!empty($department)) {
            $query->where('p.serviceunit_no_fk', $department);
        }
        if (!empty($card_num)) {
            $query->where('p.person_no_pk', $card_num);
        }
        // $d = $query
        //     ->orderBy('m.au_entry_at', 'DESC')
        //     ->get()
        //     ->toArray();
        //     dd($d);
        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            return template::loadview('admin.hrm.monthlyAttendence.monthly_attendence_search_list', [
                'data' => $query->orderBy('m.person_card_no', 'ASC')->get()->toArray()
            ]);
        } else {
            return template::loadview('admin.hrm.monthlyAttendence.monthly_attendence_search_list', [
                'data' => $query
                    ->orderBy('jobtype.serial_no', 'ASC')
                    ->orderBy('m.person_card_no', 'ASC')
                    ->orderBy('m.au_entry_at', 'DESC')
                    ->get()
                    ->toArray()
            ]);
        }
    }

    public function attendenceEdit($id)
    {
        $salary_process_data = DB::table('hrms_monthly_salary_wl_vw')->where('month_attend_no_pk', $id)->first();
        if (session('user.ses_hospital_code') == "JKMH") {
            return Template::loadview("admin.reports.hrm.monthly_attendence_edit", ['salary_process_data' => $salary_process_data]);
        }

        //dd($salary_process_data);
        return Template::loadview("admin.reports.hrm.monthly_salary_sheet_edit", ['salary_process_data' => $salary_process_data]);
    }


    public function attendenceMonthlyPdf(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $year = $request->year;
        $month = $request->month;
        $month_year = $year . $month;
        $attendence_month = $year . '' . $month;
        $attendence_month_date = $year . '-' . $month . '-01';
        $department = $request->department;
        $card_num = $request->card_num;
        $month_year_con = ($month_year != "") ? " and salary_yyyymm=$month_year" : "";
        $card_no = $request->card_num;
        $card_no_con = ($request->card_no != "") ? " and person_no_pk=$card_no" : "";
        if (isset($month) && isset($year)) {
            $firstDay = Carbon::create($year, $month, 1)->startOfMonth();
            $lastDay = Carbon::create($year, $month, 1)->endOfMonth();
            $from_date = $firstDay->toDateString();
            $to_date = $lastDay->toDateString();
        } else {
            $from_date = "";
            $to_date = "";
        }

        $query = DB::table("hrms_attendance_monthly m")

            ->select(
                'm.person_card_no',
                'p.full_name',
                's.serviceunit_no_pk',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk',
                'd.designation_name',
                's.serviceunit_name',
                's.serviceunit_code',
                'm.attendance_yyyymm',
                'm.month_days',
                'm.working_days',
                'm.attendance_days',
                'p.person_code',
                'p.serviceunit_no_fk',
                'p.person_no_pk',
                'm.late_days',
                'm.absent_days',
                'm.late_days',
                'm.leave_withoutpay_days',
                'm.leave_days',
                'm.amount_deduct',
                'm.amount_allowance',
                'm.status',
                // 'm.holiday',
                'm.casual_leave',
                'm.sick_leave',
                'm.general_festival_days',
                'm.holidays',
                'm.ot_time',
                'jobtype.serial_no',
                'jobtype.lookupdata_desc'
            )
            ->leftjoin('hrms_personnel p', 'm.person_card_no', 'p.person_code')
            ->leftjoin('sysc_lookupdata jobtype', 'jobtype.lookupdata_no_pk', 'p.job_type_lookup_no_fk')
            ->leftjoin('sysc_serviceunit s', 'p.serviceunit_no_fk', 's.serviceunit_no_pk')
            ->leftjoin(
                'hrms_designation d',
                'p.jobtitle_lookup_no_fk',
                'd.designation_no_pk'
            )
            ->where('m.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('p.employee_ind', 1)
            ->where('p.status', 1)
            ->where('p.virtual_ind', '!=', 1);


        if (!empty($attendence_month)) {
            $query->where('m.attendance_yyyymm', $attendence_month);
        }
        if (!empty($department)) {
            $query->where('p.serviceunit_no_fk', $department);
        }
        if (!empty($card_num)) {
            $query->where('p.person_no_pk', $card_num);
        }

        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $attendance_data = $query->orderBy('m.person_card_no', 'ASC')->get()->toArray();
        } else {
            $attendance_data = $query->orderBy('jobtype.serial_no', 'ASC')
                ->orderBy('m.person_card_no', 'ASC')
                ->orderBy('m.au_entry_at', 'DESC')
                ->get()
                ->toArray();
        }

        $attend_data = [];
        if (!empty($attendance_data)) {
            foreach ($attendance_data as $data) {
                $attend_data[$data->lookupdata_desc][$data->person_no_pk] = $data;
            }
        }
        $total_employee = DB::select("select lookupdata_desc, count(person_no_pk)  total_emp from hrms_monthly_salary_wl_vw  where status=1   $card_no_con $month_year_con group by lookupdata_desc");
        $count_depart_emp = [];
        if (!empty($total_employee)) {
            foreach ($total_employee as $value) {
                $count_depart_emp[$value->lookupdata_desc] = $value->total_emp;
            }
        }
        $emp_info_arr = [];
        if (!empty($attendance_data)) {
            foreach ($attendance_data as $data) {
                $daily_attend_data =  DB::table('hrms_attendance_daily')->whereRaw("attendance_date between trunc(to_date('$from_date', 'YYYY-MM-DD')) and trunc(to_date('$to_date','YYYY-MM-DD'))")
                    ->where('person_no_fk', $data->person_no_pk)->get();

                    if (count($daily_attend_data) > 0) {
                    foreach ($daily_attend_data as $singleData) {
                        if (isset($singleData->leave_entry_ind) && $singleData->leave_entry_ind == 1) {
                            $status = "L";
                        } elseif ($singleData->attendance_status == '7') {
                            $status = "NH";
                        } elseif ($singleData->attendance_status == '6') {
                            $status = "DO";
                        } elseif (isset($singleData->in_time) && isset($singleData->out_time) && ($singleData->in_time != $singleData->out_time)) {
                            $status = "P";
                        } elseif (isset($singleData->in_time) && !isset($singleData->out_time)) {
                            $status = "OL";
                        } elseif (isset($singleData->in_time) && isset($singleData->out_time) && $singleData->in_time == $singleData->out_time) {
                            $status = "OL";
                        } else {
                            $status = "A";
                        }
                        $emp_info_arr[$data->person_no_pk] = $data->person_no_pk;
                        $attendance_arr[date('Y-m-d', strtotime($singleData->attendance_date))][$data->person_no_pk] = [
                            'status' => $status,
                        ];
                    }
                } else {
                    $emp_info_arr[$data->person_no_pk] = $data->person_no_pk;
                }
            }
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if (Session::get('user.ses_hospital_code') == 'UNICO' || Session::get('user.ses_hospital_code') == 'DMHL') {
            $pdf = PDF::loadView("admin.hrm.monthlyAttendence.attendence_monthly_search_pdf_unico", [
                'attendance_data' => $attendance_data,
                'attend_data' => $attend_data,
                'po_hospital_details' => $po_hospital_details,
                'attendence_month_date' => $attendence_month_date,
                'count_depart_emp' => $count_depart_emp,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'emp_info_arr' => $emp_info_arr,
                'attendance_arr' => $attendance_arr
            ])->setPaper('legal', 'landscape');
        } else {
            $pdf = PDF::loadView("admin.hrm.monthlyAttendence.attendence_monthly_search_pdf", [
                'data' => $attendance_data,
                'attend_data' => $attend_data,
                'po_hospital_details' => $po_hospital_details,
                'attendence_month_date' => $attendence_month_date,
                'count_depart_emp' => $count_depart_emp,
            ])->setPaper('a4', 'landscape');
        }

        return $pdf->stream('daily_attendance_report_print.pdf');
    }

    public function createRosterTemplate()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')
            ->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->get();
        $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))
            ->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->groupBy('roster_temp_code')->get();

        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        // dd($shift);
        return template::loadview('admin.hrm.roster.create_roster_template', ['shift' => $shift, 'dutyArea' => $dutyArea, 'roster_data' => $roster, 'roster_unique' => $roster_unique]);
    }

    public function rosterTemplateList()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $roster = DB::table('hrms_roster_template roster')->select('roster.roster_temp_no_pk', 'roster.schedule_day_fri', 'roster.schedule_day_sat', 'roster.schedule_day_sun', 'roster.schedule_day_mon', 'roster.schedule_day_tue', 'roster.schedule_day_wed', 'roster.schedule_day_thu', 'roster.roster_temp_code', 'roster.duty_start_time', 'roster.duty_end_time', 'shift.shift_code', 'lookup_fri.lookupdata_name as friday', 'lookup_sat.lookupdata_name as saterday', 'lookup_sun.lookupdata_name as sunday', 'lookup_mon.lookupdata_name as monday', 'lookup_tue.lookupdata_name as tuesday', 'lookup_wed.lookupdata_name as wednesday', 'lookup_thu.lookupdata_name  as thusday')
            ->leftJoin('hrms_shift shift', 'shift.shift_no_pk', '=', 'roster.shift_no_fk')
            ->leftJoin('sysc_lookupdata lookup_fri', 'lookup_fri.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_sat', 'lookup_sat.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_sun', 'lookup_sun.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_mon', 'lookup_mon.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_tue', 'lookup_tue.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_wed', 'lookup_wed.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_thu', 'lookup_thu.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            // ->leftJoin('sysc_lookupdata lookup_sat', 'lookup_sat.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sat')
            // ->leftJoin('sysc_lookupdata lookup_sun', 'lookup_sun.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sun')
            // ->leftJoin('sysc_lookupdata lookup_mon', 'lookup_mon.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_mon')
            // ->leftJoin('sysc_lookupdata lookup_tue', 'lookup_tue.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_tue')
            // ->leftJoin('sysc_lookupdata lookup_wed', 'lookup_wed.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_wed')
            // ->leftJoin('sysc_lookupdata lookup_thu', 'lookup_thu.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_thu')

            ->where('roster.au_entry_hospital_pk_no', $ses_hospital_id)
            ->orderBy('roster.roster_temp_no_pk', 'asc')
            ->get();


        return template::loadview('admin.hrm.roster.roster_template_list', ['roster' => $roster]);
    }
    public function editRosterTemplate($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $roster = DB::table('hrms_roster_template')->where('roster_temp_code', $id)->get();

        $roster_data = Roster::select('roster_temp_no_pk', 'roster_temp_code')->get();
        // dd($shift);
        return template::loadview('admin.hrm.roster.create_roster_template', ['shift' => $shift, 'roster' => $roster, 'roster_data' => $roster_data, 'dutyArea' => $dutyArea]);
    }


    public function employeeRoster()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))->where('au_entry_hospital_pk_no', $ses_hospital_id)->groupBy('roster_temp_code')->get();
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('status', '=', 1)->get();
        //dd($dutyArea, $shift,$roster);
        return template::loadview('admin.hrm.roster.employee_roster', ['roster' => $roster, 'roster_unique' => $roster_unique, 'shift' => $shift, 'dutyArea' => $dutyArea]);
    }

    public function autocomplete_search_dep(Request $request)
    {

        if ($request->has('employee')) {
            $variable = $request->input('employee');
            return  DB::table('hrms_personnel')
                ->where('status', 1)
                ->whereIn('serviceunit_no_fk', function ($query) {
                    return $query->select('serviceunit_no_pk')
                        ->from('sysc_grant_servieceunit_vw')
                        ->where('user_no_pk', '=', Auth::user()->user_no_pk);
                })
                ->get();
        }
    }

    public function employeeRosterTemplate(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $roster_id = explode("_", $request->roster_value);
        $roster_temp = DB::table('hrms_roster_template roster')->select('roster.roster_temp_no_pk', 'roster.roster_temp_code', 'roster.duty_start_time', 'roster.duty_end_time', 'shift.shift_code', 'lookup_fri.lookupdata_name as friday', 'lookup_sat.lookupdata_name as saterday', 'lookup_sun.lookupdata_name as sunday', 'lookup_mon.lookupdata_name as monday', 'lookup_tue.lookupdata_name as tuesday', 'lookup_wed.lookupdata_name as wednesday', 'lookup_thu.lookupdata_name  as thusday')
            ->leftJoin('hrms_shift shift', 'shift.shift_no_pk', '=', 'roster.shift_no_fk')
            ->leftJoin('sysc_lookupdata lookup_fri', 'lookup_fri.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
            ->leftJoin('sysc_lookupdata lookup_sat', 'lookup_sat.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sat')
            ->leftJoin('sysc_lookupdata lookup_sun', 'lookup_sun.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sun')
            ->leftJoin('sysc_lookupdata lookup_mon', 'lookup_mon.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_mon')
            ->leftJoin('sysc_lookupdata lookup_tue', 'lookup_tue.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_tue')
            ->leftJoin('sysc_lookupdata lookup_wed', 'lookup_wed.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_wed')
            ->leftJoin('sysc_lookupdata lookup_thu', 'lookup_thu.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_thu')
            ->where('roster.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('roster_temp_code', $request->roster_value)->get();
        // dd($roster_temp);

        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $shift = DB::table('hrms_shift')->get();

        $roster_temp = DB::table('hrms_roster_template')->where('roster_temp_code', $request->roster_value)->get();


        // dd($roster);
        return template::loadview('admin.hrm.roster.roster_temp', ['roster_temp' => $roster_temp, 'shift' => $shift, 'dutyArea' => $dutyArea]);
    }

    public function setCreateRosterTemplate(Request $request)
    {
        if ($request->roster_value != '') {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $roster_id = $request->roster_value;
            $roster_temp = DB::table('hrms_roster_template roster')->select('roster.roster_temp_no_pk', 'roster.roster_temp_code', 'roster.duty_start_time', 'roster.duty_end_time', 'shift.shift_code', 'lookup_fri.lookupdata_name as friday', 'lookup_sat.lookupdata_name as saterday', 'lookup_sun.lookupdata_name as sunday', 'lookup_mon.lookupdata_name as monday', 'lookup_tue.lookupdata_name as tuesday', 'lookup_wed.lookupdata_name as wednesday', 'lookup_thu.lookupdata_name  as thusday')
                ->leftJoin('hrms_shift shift', 'shift.shift_no_pk', '=', 'roster.shift_no_fk')
                ->leftJoin('sysc_lookupdata lookup_fri', 'lookup_fri.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_fri')
                ->leftJoin('sysc_lookupdata lookup_sat', 'lookup_sat.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sat')
                ->leftJoin('sysc_lookupdata lookup_sun', 'lookup_sun.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_sun')
                ->leftJoin('sysc_lookupdata lookup_mon', 'lookup_mon.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_mon')
                ->leftJoin('sysc_lookupdata lookup_tue', 'lookup_tue.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_tue')
                ->leftJoin('sysc_lookupdata lookup_wed', 'lookup_wed.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_wed')
                ->leftJoin('sysc_lookupdata lookup_thu', 'lookup_thu.lookupdata_no_pk', '=', 'roster.duty_area_su_no_fk_thu')
                ->where('roster.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('roster_temp_code', $roster_id)->get();
            // dd($roster_temp);

            $dutyArea = $this->getLookupListByCode('DUTYAREA');
            $shift = DB::table('hrms_shift')->get();

            $roster_temp = DB::table('hrms_roster_template')->where('roster_temp_code', $roster_id)->get();


            // dd($roster);
            return template::loadview('admin.hrm.roster.set_roster_temp', ['roster' => $roster_temp, 'shift' => $shift, 'dutyArea' => $dutyArea]);
        }

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')->get();
        $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))->groupBy('roster_temp_code')->get();

        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();

        return template::loadview('admin.hrm.roster.set_roster_temp', ['roster' => collect([]), 'roster_data' => $roster, 'shift' => $shift, 'dutyArea' => $dutyArea, 'roster_unique' => $roster_unique]);
    }

    public function validateRoster(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($ses_hospital_id);
        if (!empty($request->personal_id)) {
            $personal_id = $request->personal_id;
            Session::put('roster_emp_card', $request->personal_id);
        } else {
            //Session::forget('roster_emp_card');
        }

        if (!Session::has('roster_emp_card')) {
            Session::put('roster_emp_card', $request->personal_id);
        }

        $personal_id = Session::get('roster_emp_card');

        if (!empty($request->from_date) && !empty($request->end_date)) {

            Session::put('roster_from_dt', date("Y-m-d", strtotime($request->from_date)));
            Session::put('roster_to_dt', date("Y-m-d", strtotime($request->end_date)));
        } else {
            //Session::forget('roster_from_dt');
            //Session::forget('roster_to_dt');
        }
        // Session::forget('roster_from_dt');
        //     Session::forget('roster_to_dt');
        //     Session::forget('roster_emp_card');
        $from_date = Session::get('roster_from_dt');
        $to_date = Session::get('roster_to_dt');


        $personal_cond = ($personal_id != "") ? " and person_no_fk=$personal_id" : "";
        $date_cond = ($from_date != '') ? " a.roster_date between trunc(to_date('$from_date', 'YYYY-MM-DD')) and trunc(to_date('$to_date','YYYY-MM-DD'))" : '';


        $roster_validate = DB::select("select trunc(a.roster_date) roster_date, c.lookupdata_name ,a.person_no_fk, b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,duty_end_time from hrms_roster a left join hrms_shift b on a.shift_no_fk=b.shift_no_pk left join sysc_lookupdata c on c.lookupdata_no_pk =a.duty_area_su_no_fk  where $date_cond $personal_cond and a.au_entry_hospital_pk_no =  $ses_hospital_id ORDER BY roster_date ASC");

        // dd($roster_validate);
        return template::loadview('admin.hrm.roster.roster_validate', ['roster_validate' => $roster_validate]);
    }

    public function emp_roster_pdf(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($ses_hospital_id);
        if (!empty($request->personal_id)) {
            $personal_id = $request->personal_id;
            Session::put('roster_emp_card', $request->personal_id);
        } else {
            //Session::forget('roster_emp_card');
        }

        if (!Session::has('roster_emp_card')) {
            Session::put('roster_emp_card', $request->personal_id);
        }

        $personal_id = Session::get('roster_emp_card');

        if (!empty($request->from_date) && !empty($request->end_date)) {

            Session::put('roster_from_dt', date("Y-m-d", strtotime($request->from_date)));
            Session::put('roster_to_dt', date("Y-m-d", strtotime($request->end_date)));
        } else {
            //Session::forget('roster_from_dt');
            //Session::forget('roster_to_dt');
        }
        // Session::forget('roster_from_dt');
        //     Session::forget('roster_to_dt');
        //     Session::forget('roster_emp_card');
        $from_date = Session::get('roster_from_dt');
        $to_date = Session::get('roster_to_dt');

        $personal_cond = ($personal_id != "") ? " and person_no_fk=$personal_id" : "";
        $date_cond = ($from_date != '') ? " a.roster_date between trunc(to_date('$from_date', 'YYYY-MM-DD')) and trunc(to_date('$to_date','YYYY-MM-DD'))" : '';

        //return "select trunc(a.roster_date) roster_date, c.lookupdata_name , b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,duty_end_time from hrms_roster a left join hrms_shift b on a.shift_no_fk=b.shift_no_pk left join sysc_lookupdata c on c.lookupdata_no_pk =a.duty_area_su_no_fk  where $date_cond $personal_cond and a.au_entry_hospital_pk_no =  $ses_hospital_id ORDER BY roster_date ASC";
        $roster_validate = DB::select("select trunc(a.roster_date) roster_date, c.lookupdata_name , b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,duty_end_time from hrms_roster a left join hrms_shift b on a.shift_no_fk=b.shift_no_pk left join sysc_lookupdata c on c.lookupdata_no_pk =a.duty_area_su_no_fk  where $date_cond $personal_cond and a.au_entry_hospital_pk_no =  $ses_hospital_id ORDER BY roster_date ASC");
        // dd($from_date);

        $emp_info = DB::table('HRMS_PERSONNEL_VW')
            ->where('person_no_pk', '=', $personal_id)
            ->select('person_code', 'full_name', 'su_name')
            ->first();

        $title = "Attendance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.hrm.roster.employee_roster_pdf", ["po_hospital_details" => $po_hospital_details, 'value' => $roster_validate, 'from_date' => $from_date, 'to_date' => $to_date, 'barcode_no' => $barcode_no, 'emp_info' => $emp_info])->setPaper('a4', 'landscape');
        return $pdf->stream('daily_attendance_report_print.pdf');
    }

    public function validateRosterEdit($id)
    {
        // dd($id);
        $roster_id = $id;
        $shift = DB::table('hrms_shift')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();
        $dutyArea = $this->getLookupListByCode('DUTYAREA');

        $roster_validate = DB::table('hrms_roster a ')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('a.roster_no_pk', $roster_id)->first();
        // dd($roster_validate);
        return template::loadview('admin.hrm.roster.roster_validate_edit', ['roster_validate' => $roster_validate, 'shift' => $shift, 'dutyArea' => $dutyArea]);
    }

    public function validateRosterDelete(Request $request)
    {
        $validate_roster = $request->roster_id;

        $roster_validate = DB::table('hrms_roster')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('roster_no_pk', $validate_roster)->delete();
        // dd($roster_validate);
        // return template::loadview('admin.hrm.roster.roster_validate_edit', ['roster_validate'=>$roster_validate,'shift'=> $shift, 'dutyArea'=> $dutyArea]);
    }

    public function allRosterDelete(Request $request)
    {
        // dd($request->all());
        $roster_validate = DB::table('hrms_roster')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('person_no_fk', $request->person_no)->delete();
    }

    public function storevalidateRosterEdit(Request $request)
    {
        $shift = explode('_', $request->shift_type_no);

        $id = $request->roster_id;

        $auth_id = Auth::id();

        $roster_info = EmployeeRoster::find($id);
        $roster_day = date("D", strtotime($roster_info->roster_date));


        DB::beginTransaction();
        try {

            $data = [
                'duty_area_su_no_fk'       => $request->duty_area_no,
                'shift_no_fk'            => $shift[2],
                'duty_start_time'        => date('Y-m-d H:i:s', strtotime($request->duty_start_time)),
                'duty_end_time'          => date('Y-m-d H:i:s', strtotime($request->duty_end_time)),
                'au_update_by'              =>  $auth_id

            ];
            // dd($data);
            if ($shift[3] == "OFFDAY") {
                if ($roster_day == "Sat") {
                    $data['schedule_day_sat'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Sun") {
                    $data['schedule_day_sun'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Mon") {
                    $data['schedule_day_mon'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Tue") {
                    $data['schedule_day_tue'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Wed") {
                    $data['schedule_day_wed'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Thu") {
                    $data['schedule_day_thu'] = 2;
                    $data['dayoff_ind'] = 1;
                }
                if ($roster_day == "Fri") {
                    $data['schedule_day_fri'] = 2;
                    $data['dayoff_ind'] = 1;
                }
            } else {
                if ($roster_day == "Sat") {
                    $data['schedule_day_sat'] = 1;
                }
                if ($roster_day == "Sun") {
                    $data['schedule_day_sun'] = 1;
                }
                if ($roster_day == "Mon") {
                    $data['schedule_day_mon'] = 1;
                }
                if ($roster_day == "Tue") {
                    $data['schedule_day_tue'] = 1;
                }
                if ($roster_day == "Wed") {
                    $data['schedule_day_wed'] = 1;
                }
                if ($roster_day == "Thu") {
                    $data['schedule_day_thu'] = 1;
                }
                if ($roster_day == "Fri") {
                    $data['schedule_day_fri'] = 1;
                }
            }



            //dd($data);

            $this->model3->update($data, $id);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function storeRosterTemplate(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //return $request;


        // $start_time= explode(' ', $time[0]);
        // $end_time= explode(' ', $time[1]);
        // $shift_no_fk= explode(' ', $time[2]);
        // dd($time[1]);
        $id = $request->id;
        // dd($id);
        $auth_id = Auth::id();


        DB::beginTransaction();

        try {

            $fl_fri = 0;
            $fl_sat = 0;
            $fl_sun = 0;
            $fl_mon = 0;
            $fl_tue = 0;
            $fl_wed = 0;
            $fl_thu = 0;


            //if($fl_fri == 0) {
            foreach ($request->shift_type as $key => $shift) {

                $shift = $shift;
                $time = explode('_', $shift);

                $data = [
                    'roster_temp_code'       => $request->roster_code,
                    'shift_no_fk'            => $time[2],
                    'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
                    'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',
                    'schedule_day_fri'       => @$request->schedule_day[$key],

                    'duty_area_su_no_fk_fri' => !empty($request->duty_area[$key]) ? @$request->duty_area[$key] : 0,
                    'status' => 1,
                    'au_entry_hospital_pk_no' => $ses_hospital_id
                ];

                if ($id == null) {
                    $data['au_entry_by'] = $auth_id;
                    $this->model2->create($data);
                } else {
                    // AU_UPDATE_BY
                    // dd($data);
                    $data['au_update_by'] = $auth_id;
                    $this->model2->update($data, $request->id[$key]);
                }

                DB::commit();
                //$fl_fri = 1;
            }
            //}

            // if($fl_sat == 0) {
            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',
            //             'schedule_day_sat'       => $request->sat,
            //             'duty_area_su_no_fk_fri' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();
            //         $fl_sat = 1;
            //     }
            // }


            // if($fl_sun == 0) {
            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',

            //             'schedule_day_sun'       => $request->sun,
            //             'duty_area_su_no_fk_sun' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();
            //         $fl_sun = 1;
            //     }
            // }



            // if($fl_mon == 0) {
            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',

            //             'schedule_day_mon'       => $request->mon,
            //             'duty_area_su_no_fk_mon' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();
            //         $fl_mon = 1;
            //     }
            // }


            // if($fl_tue == 0) {
            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',

            //             'schedule_day_tue'       => $request->tue,
            //             'duty_area_su_no_fk_tue' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();
            //         $fl_tue = 1;
            //     }
            // }

            // if($fl_wed == 0) {

            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',

            //             'schedule_day_wed'       => $request->wed,
            //             'duty_area_su_no_fk_wed' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();
            //         $fl_wed = 1;
            //     }
            // }


            // if($fl_thu == 0) {
            //     foreach($request->shift_type as $key => $shift) {

            //         $shift = $shift;
            //         $time = explode('_', $shift);

            //         $data = [
            //             'roster_temp_code'       => $request->roster_code,
            //             'shift_no_fk'            => $time[2],
            //             'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //             'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',

            //             'schedule_day_thu'       => $request->thu,
            //             'duty_area_su_no_fk_thu' => $request->duty_area[$key],
            //             'status' => 1,
            //             'au_entry_hospital_pk_no' => $ses_hospital_id
            //         ];

            //         if ($id == null) {
            //             $data['au_entry_by'] = $auth_id;
            //             $this->model2->create($data);
            //         } else {
            //             // AU_UPDATE_BY
            //             // dd($data);
            //             $data['au_update_by'] = $auth_id;
            //             $this->model2->update($data, $id);
            //         }

            //         DB::commit();

            //         $fl_thu = 1;
            //     }

            // }


            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function storeEmployeeRoster(RosterRequest $request)
    {

        $roster_code = $request->roster_template; //explode('_', $request->roster_template);

        $id = $request->id;
        $auth_id = Auth::id();

        //dd($request->all());
        DB::beginTransaction();
        try {
            $date = new Carbon($request->start_date);
            $end_date = new Carbon($request->end_date);
            $DstartDate = date("Y-M-d", strtotime($date->toDateString()));
            $DendDate = date("Y-M-d", strtotime($end_date->toDateString()));
            $period = CarbonPeriod::create($DstartDate, $DendDate);

            $hospital_id = Session::get('user.ses_hospital_no_pk');


            //dd($request->duty_area_1);
            foreach ($period as $key => $date) {
                $selected_date = date("Y-M-d", strtotime($date->toDateString()));
                $checkroster = DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$selected_date', 'YYYY-MM-DD')) and trunc(to_date('$selected_date','YYYY-MM-DD'))")
                ->where('person_no_fk', $request->hidn_personal)->first();
                if(!isset($checkroster)){
                    $friday     = strtoupper(date('D', strtotime($selected_date))) == $request->fri ? 1 : '';
                    $saterday     = strtoupper(date('D', strtotime($selected_date))) == $request->sat ? 2 : '';
                    $sunday     = strtoupper(date('D', strtotime($selected_date))) == $request->sun ? 3 : '';
                    $monday     = strtoupper(date('D', strtotime($selected_date))) == $request->mon ? 4 : '';
                    $tuesday     = strtoupper(date('D', strtotime($selected_date))) == $request->tue ? 5 : '';
                    $wednesday     = strtoupper(date('D', strtotime($selected_date))) == $request->wed ? 6 : '';
                    $thursday     = strtoupper(date('D', strtotime($selected_date))) == $request->thu ? 7 : '';

                    //dd('day ',strtoupper(date('D', strtotime($selected_date))));
                    //dd($friday,$saterday,$sunday,$monday,$tuesday,$wednesday,$thursday);


                    if (!empty($request->shift_type_1)) {
                        if ($friday == 1) {
                            $shift_1 = explode('_', $request->shift_type_1);
                            //dd($shift_1);
                            $duty_area             = $request->duty_area_1;
                            $shift_type         = @$shift_1[2];
                            $dayOff             = (@$shift_1[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_1));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_1));
                            $day_name1              = (@$shift_1[3] == "OFFDAY") ? 2 : 1;
                            $day_name2           = 0;
                            $day_name3           = 0;
                            $day_name4           = 0;
                            $day_name5           = 0;
                            $day_name6           = 0;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_2)) {
                        if ($saterday == 2) {
                            $shift_2 = explode('_', $request->shift_type_2);
                            $duty_area             = $request->duty_area_2;
                            $shift_type         = $shift_2[2];
                            $dayOff             = (@$shift_2[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_2));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_2));
                            $day_name1          = 0;
                            $day_name2           = (@$shift_2[3] == "OFFDAY") ? 2 : 1;
                            $day_name3           = 0;
                            $day_name4           = 0;
                            $day_name5           = 0;
                            $day_name6           = 0;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_3)) {
                        if ($sunday == 3) {
                            $shift_3 = explode('_', $request->shift_type_3);
                            $duty_area             = $request->duty_area_3;
                            $shift_type         = $shift_3[2];
                            $dayOff             = (@$shift_3[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_3));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_3));
                            $day_name1          = 0;
                            $day_name2           = 0;
                            $day_name3           = (@$shift_3[3] == "OFFDAY") ? 2 : 1;
                            $day_name4           = 0;
                            $day_name5           = 0;
                            $day_name6           = 0;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_4)) {
                        if ($monday == 4) {
                            $shift_4 = explode('_', $request->shift_type_4);
                            $duty_area             = $request->duty_area_4;
                            $shift_type         = $shift_4[2];
                            $dayOff             = (@$shift_4[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_4));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_4));
                            $day_name1          = 0;
                            $day_name2           = 0;
                            $day_name3           = 0;
                            $day_name4           = (@$shift_4[3] == "OFFDAY") ? 2 : 1;
                            $day_name5           = 0;
                            $day_name6           = 0;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_5)) {
                        if ($tuesday == 5) {
                            $shift_5 = explode('_', $request->shift_type_5);
                            $duty_area             = $request->duty_area_5;
                            $shift_type         = $shift_5[2];
                            $dayOff             = (@$shift_5[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_5));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_5));
                            $day_name1          = 0;
                            $day_name2           = 0;
                            $day_name3           = 0;
                            $day_name4           = 0;
                            $day_name5           = (@$shift_5[3] == "OFFDAY") ? 2 : 1;
                            $day_name6           = 0;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_6)) {
                        if ($wednesday == 6) {
                            $shift_6 = explode('_', $request->shift_type_6);
                            $duty_area             = $request->duty_area_6;
                            $shift_type         = $shift_6[2];
                            $dayOff             = (@$shift_6[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_6));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_6));
                            $day_name1          = 0;
                            $day_name2           = 0;
                            $day_name3           = 0;
                            $day_name4           = 0;
                            $day_name5           = 0;
                            $day_name6           = (@$shift_6[3] == "OFFDAY") ? 2 : 1;
                            $day_name7           = 0;
                        }
                    }

                    if (!empty($request->shift_type_7)) {
                        if ($thursday == 7) {
                            $shift_7 = explode('_', $request->shift_type_7);
                            $duty_area             = $request->duty_area_7;
                            $shift_type         = $shift_7[2];
                            $dayOff             = (@$shift_7[3] == "OFFDAY") ? 1 : 0;
                            $start_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_start_7));
                            $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $request->duty_end_7));
                            $day_name1          = 0;
                            $day_name2           = 0;
                            $day_name3           = 0;
                            $day_name4           = 0;
                            $day_name5           = 0;
                            $day_name6           = 0;
                            $day_name7           = (@$shift_7[3] == "OFFDAY") ? 2 : 1;
                        }
                    }

                    $data = [
                        'roster_code'            => (isset($roster_code)) ? isset($roster_code) : 1,
                        'roster_date'            => $selected_date,
                        'person_no_fk'           => $request->hidn_personal,
                        'duty_area_su_no_fk'     => @$duty_area,
                        'shift_no_fk'            => @$shift_type,
                        'duty_start_time'        => @$start_time,
                        'duty_end_time'          => @$end_time,
                        'schedule_day_fri'       => @$day_name1,
                        'schedule_day_sat'       => @$day_name2,
                        'schedule_day_sun'       => @$day_name3,
                        'schedule_day_mon'       => @$day_name4,
                        'schedule_day_tue'       => @$day_name5,
                        'schedule_day_wed'       => @$day_name6,
                        'schedule_day_thu'       => @$day_name7,
                        'roster_temp_no_fk'      => 1, //$roster_code ? $roster_code : '',
                        'dayoff_ind'             => @$dayOff,
                        'status'                 => 1,
                        'au_entry_by'            => 1,
                        'au_entry_hospital_pk_no' => $hospital_id
                    ];
                    //dd($data);
                    $this->model3->create($data);
                    DB::commit();
                }
            }

            //foreach($request->shift_type as $key => $shift) {
            // foreach ($period as $key => $date) {
            //     $selected_date = date("Y-M-d", strtotime($date->toDateString()));

            //     $shift = $request->shift_type[$key];
            //     $time = explode('_', $shift);

            //     $dayOff             = ($request->shift_type[$key] == "OFFDAY") ? 1 : "";

            //     $data = [
            //         'roster_code'       => $request->roster_code,
            //         'roster_date'            => @$selected_date,
            //         'person_no_fk'           => @$request->hidn_personal,
            //         'shift_no_fk'            => @$time[2],
            //         'duty_start_time'        => !empty($time[0]) ? date('Y-m-d H:i:s', strtotime($time[0])) : '',
            //         'duty_end_time'          => !empty($time[1]) ? date('Y-m-d H:i:s', strtotime($time[1])) : '',
            //         'schedule_day_fri'       => @$request->schedule_day[$key],

            //         'duty_area_su_no_fk' => !empty($request->duty_area[$key]) ? @$request->duty_area[$key] : 0,
            //         'status' => 1,
            //         'dayoff_ind' => @$dayOff,
            //         'au_entry_by'            => $auth_id,
            //         'au_entry_hospital_pk_no' => $hospital_id
            //     ];

            //     if ($id == null) {
            //         $data['au_entry_by'] = $auth_id;
            //         $this->model3->create($data);
            //     } else {
            //         // AU_UPDATE_BY
            //         // dd($data);
            //         $data['au_update_by'] = $auth_id;
            //         //$this->model2->update($data, $request->id[$key]);
            //     }

            //     DB::commit();
            //     //$fl_fri = 1;
            // }


            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }



    //saving fund
    public function add_saving_fund()
    {
        return template::loadview('admin.hrm.savingFund.add_saving_fund_form');
    }
    public function saving_fund()
    {
        return template::loadview('admin.hrm.savingFund.saving_fund');
    }

    public function saving_fund_list(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $saving_fund =  DB::select("select * from hrms_personnel_save_fund_vw where au_entry_hospital_pk_no =  $hospital_id order by au_entry_at desc");
        // dd($saving_fund);
        return template::loadview('admin.hrm.savingFund.saving_fund_list', ['saving_fund' => $saving_fund]);
    }



    public function saving_fund_store(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $id = $request->savings_id;
        // dd($savings_id);
        $auth_id = Auth::id();
        DB::beginTransaction();
        $year = $request->year;
        $month = $request->month;
        $yyyymm = $year . $month;
        try {
            $data = [

                'person_no_fk' => $request->card_num,
                'personal_savings_amount' => $request->amount,
                'salary_yyyymm' => $yyyymm,
                'au_entry_hospital_pk_no' => $hospital_id,
                'withdraw_ind' => '1',
                'status' => '1',
                'au_entry_session' => 'session',
                'AU_ENTRY_AT' => '1'
            ];
            //            dd($data);
            if ($id == "") {
                // dd($data);
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $this->model4->create($data);
                // return $res;

            } else {

                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;

                $this->model4->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function editSavingFund($id)
    {
        $savingFund = DB::table('hrms_personnel_save_fund')->where('monthly_save_fund_no_pk', $id)->first();
        $name = DB::table('hrms_personnel')->select('full_name')->where('person_no_pk', $savingFund->person_no_fk)->first();
        //        dd($savingFund);
        return template::loadview('admin.hrm.savingFund.add_saving_fund_form', ['savingFund' => $savingFund, 'name' => $name]);
    }
    public function deleteSavingFund(Request $request)
    {
        // dd($request->fund_id);
        DB::table('hrms_personnel_save_fund')->where('monthly_save_fund_no_pk', $request->fund_id)->delete();
        // return \Redirect::route("hrm.saving-fund-list");
        // $view= template::loadview('admin.hrm.savingFund.saving_fund_list');
        // return response()->json(['url'=>route('hrm.saving-fund-list')]);

    }
    public function updateSavingFinalizeInd(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();

        try {
            $data = [

                'finalyzed_by_ind' => '1',
                'au_entry_session' => 'session',
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => $hospital_id,
            ];
            DB::table('hrms_personnel_save_fund')->update($data);
            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->model4->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model4->update($data, $id);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function searchSavingFund(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $card_num = $request->card_num;
        $card_num_cond = ($card_num != "") ? " and f.person_no_fk = $card_num" : "";
        $year = $request->year;
        $month = $request->month;
        $year_mm = $year . $month;
        $year_mm_cond = ($year_mm != "") ? "and f.salary_yyyymm = $year_mm" : "";

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_num != "") ? " $clause f.person_no_fk=$card_num" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($year != "") ? " $clause SUBSTR(f.salary_yyyymm,0,4) = $year" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($month != "") ? " $clause SUBSTR(f.salary_yyyymm,5,6)= $month" : "";

        $saving_fund =  DB::select("SELECT p.person_code,
        p.full_name,
        f.monthly_save_fund_no_pk,
        f.finalyzed_by_ind,
        d.designation_name,
        s.serviceunit_name,
        f.personal_savings_amount,
        f.salary_yyyymm,
        ROWNUM rownumber,
        f.au_update_at,
        f.au_entry_at
   FROM hrms_personnel_save_fund f
        LEFT JOIN hrms_personnel p
           ON f.person_no_fk = p.person_no_pk
        LEFT JOIN hrms_designation d
           ON d.designation_no_pk = p.jobtitle_lookup_no_fk
        LEFT JOIN sysc_serviceunit s
           ON p.serviceunit_no_fk = s.serviceunit_no_pk
     $sql_cond and f.status = 1 and f.au_entry_hospital_pk_no = $hospital_id  order by f.salary_yyyymm ASC");
        //        dd($saving_fund);
        return template::loadview('admin.hrm.savingFund.saving_fund_list_data', ['saving_fund' => $saving_fund]);
    }




    public function monthlySalarySlipPrint($id, $salary)
    {
        $slip = DB::table('hrms_monthly_salary_wl_vw')->select('card_no', 'monthly_salary_no_pk', 'overtime_hours', 'overtime_rate', 'overtime_amount', 'other_allowance', 'conveyance_allowance', 'ta_da_allowance', 'full_name', 'designation_name', 'gross_salary', 'basic_salary', 'medical_allowance', 'house_rent', 'attendance_bonus', 'att_deduct_amount', 'loan_deduct_amount', 'payable_amount', 'attendance_days', 'late_days', 'absent_days', 'leave_days', 'working_days', 'leave_withoutpay_days', 'personal_savings_amount', 'salary_yyyymm', 'residence_fee', 'disciplinary_action')->where('monthly_salary_no_pk', $id)->first();
        // dd($slip);

        $title = "Salary Slip";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        // return template::loadview('admin.reports.hrm.salary_slip', ['data' => $slip]);

        $pdf = PDF::loadView("admin.reports.hrm.salary_slip", ['data' => $slip, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'salary' => $salary])->setPaper('a4', 'portrait');
        return $pdf->download('salary_slip.pdf');
    }


    public function salaryBonus()
    {

        $json_data = DB::table('hrms_salary_bonus')->orderBy('au_entry_at', 'DESC')->get();
        return template::loadview('admin.hrm.bonus.bonus_salary', [
            'json_data' => $json_data
        ]);
    }
    public function salaryBonusStore(Request $request)
    {

        $card_num = DB::table('hrms_personnel')->select('card_no')->where('person_no_pk', $request->card_num)->first();
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'person_card_no'    => (isset($card_num->card_no) ? $card_num->card_no : ''),
                'bonus_name' => $request->bonus_name,
                'effective_date' => date("Y-m-d", strtotime($request->effective_date)),
                'callculate_on' => $request->calculate_value,
                'bonus_percent_ind' => $request->bonus_per_ind,
                'value_percent' => $request->bonus_per,
                'bonus_amount_ind' => $request->bonus_amount_ind,
                'value_amount' => $request->bonus_amount,
                'status' => $request->active,
                'au_entry_session' => 'session',
                'au_entry_hospital_pk_no' => 1,
                'au_entry_by' => $auth_id,
            ];
            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model5->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model5->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function getAllsalaryBonus(Request $request)
    {
        $columns = array(
            'sl',
            'bonus_name',
            'callculate_on',
            'effective_date',
            'status',
            'value_amount',
            'value_percent',
            'bonus_no_pk'

        );

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $sql = "select '' as sl, bonus.bonus_name, bonus.callculate_on, bonus.effective_date,CASE WHEN bonus.status  = 1  THEN '$active' ELSE '$inactive' END AS status, bonus.value_amount, bonus.value_percent,bonus.bonus_no_pk,rownum rownumber, au_update_at,au_entry_at
    from HRMS_SALARY_BONUS bonus";
        $order_by_column = "bed_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }
    public function salaryBonusEdit(Request $request, $id)
    {
        $full_name = DB::table('hrms_personnel')->select('full_name')->where('card_no', $request->card_num)->first();
        $data = DB::table('hrms_salary_bonus')->where('bonus_no_pk', $id)->first();
        return template::loadview('admin.hrm.bonus.create_new_salary_bonus_form', [
            'data' => $data,
            'full_name' => $full_name
        ]);
    }

    // public function bankWiseCharge(){
    //    $card_type = $this->getLookupListByCode('CARDTYPE');
    //        $bank = $this->getLookupListByCode('BANK');
    //        return template::loadview('admin.settings.card_service.create_bank_service',[
    //            'card_type' => $card_type,
    //            'bank' => $bank
    //        ]);
    //    }


    public function bankServiceChargeList()
    {
        $card_type = $this->getLookupListByCode('CARDTYPE');
        $bank = $this->getLookupListByCode('BANK');

        return template::loadview('admin.settings.card_service.bank_service_charge_list', [
            'card_type' => $card_type,
            'bank' => $bank
        ]);
    }
    public function bankWiseChargeStore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            $data = [
                'bank_charge_code' => $request->bank_code,
                'card_type' => $request->card_type,
                'service_charge_percent' => $request->service_charge,
                'bank_no_fk' => $request->bank_name,
                'au_entry_by' => $auth_id,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_bank_charge->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_bank_charge->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function bankWiseChargeEdit($id)
    {
        $bank_service_data = $this->model_bank_charge->show($id);
        $card_type = $this->getLookupListByCode('CARDTYPE');
        $bank = $this->getLookupListByCode('BANK');

        return template::loadview('admin.settings.card_service.card_service_charge_edit', [
            'card_type' => $card_type,
            'bank' => $bank,
            'bank_service_data' => $bank_service_data
        ]);
    }
    public function getAllbankWiseCharge(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'bank_charge_code',
            'bank_name',
            'card_type',
            'service_charge_percent',
            'bank_charge_no_pk'
        );

        $sql = "select * from bank_service_charge_vw where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "bank_charge_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }
    // public function all_employeeRoster()
    // {
    //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
    //     // $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
    //     // $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))->where('au_entry_hospital_pk_no', $ses_hospital_id)->groupBy('roster_temp_code')->get();
    //     // $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
    //         ->where('status', '=', 1)
    //         ->get();
    //     $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();


    //     // DB::table('sysc_grant_servieceunit_vw')
    //     //     ->where('user_no_pk', '=', Auth::user()->user_no_pk)
    //     //     ->leftJoin('hrms_personnel emp', 'emp.SERVICEUNIT_NO_FK', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //     //     // ->select('emp.person_no_pk', 'emp.full_name')
    //     //     ->whereRaw("upper(emp.full_name) like upper('%$variable%')")
    //     //     ->get()

    //     // $hod_emp = DB::table('sysc_grant_servieceunit_vw')
    //     //     ->where('user_no_pk', '!=', Auth::user()->user_no_pk)
    //     //     ->where('emp.status', '=', 1)
    //     //     ->leftJoin('hrms_personnel emp', 'emp.serviceunit_no_fk', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //     //     ->where('emp.serviceunit_no_fk', Session::get('user.su_pk_no'))
    //     //     ->get();

    //     $hod_emp = DB::table('hrms_personnel_vw')
    //         ->where('status', 1)
    //         ->whereIn('serviceunit_no_fk', function ($query) {
    //             return $query->select('serviceunit_no_pk')
    //                 ->from('sysc_grant_servieceunit_vw')
    //                 ->where('user_no_pk', '=', Auth::user()->user_no_pk);
    //         })
    //         ->get();

    //     $emp_info_arr = [];
    //     if (!empty($hod_emp)) {
    //         foreach ($hod_emp as $emp) {

    //             $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //         }
    //     }
    //     $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     // dd($shift);
    //     return template::loadview('admin.hrm.roster.all_employee_roster', compact('emp_info_arr', 'hod_emp', 'shift', 'dutyArea', 'service_unit'));
    // }

    public function all_employeeRoster($type = null)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)
            ->get();
        $su_pk_no = Session::get('user.su_pk_no');
        $ses_user_pk_no = Session::get('user.ses_user_pk_no');
        
        if($type == 'hr'){
            // $service_unit   = ServiceUnit::where('status', '1')->where('hr_dept_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
            // $units          = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

            $service_unit = DB::select(
                'select distinct SERVICEUNIT_NO_FK_DEPT, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.SERVICEUNIT_NO_FK_DEPT=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
            $units = DB::select(
                'select distinct serviceunit_no_fk, serviceunit_name
                from hrms_personnel per, sysc_serviceunit unit
                where per.serviceunit_no_fk=unit.serviceunit_no_pk order by serviceunit_name asc'
            );
        }else{
            // $service_unit = DB::table('sysc_serviceunit as su')
            //             ->leftJoin('sysc_grant_su as sgsu', 'su.serviceunit_no_pk', '=', 'sgsu.su_no_fk')
            //             ->select('su.serviceunit_no_pk', 'su.serviceunit_name', 'su.serviceunit_code')
            //             ->where('su.status', 1)
            //             ->where('su.hr_dept_ind', 1)
            //             // ->where('sgsu.default_ind', 1)
            //             ->where('sgsu.status', 1)
            //             ->where('sgsu.user_no_fk', $ses_user_pk_no)
            //             ->orderBy('su.serviceunit_name', 'asc')
            //             ->get();

            // $units = DB::table('sysc_serviceunit as su')
            //             ->leftJoin('sysc_grant_su as sgsu', 'su.serviceunit_no_pk', '=', 'sgsu.su_no_fk')
            //             ->select('su.serviceunit_no_pk', 'su.serviceunit_name', 'su.serviceunit_code')
            //             ->where('su.status', 1)
            //             ->where('su.hr_unit_ind', 1)
            //             // ->where('sgsu.default_ind', 1)
            //             ->where('sgsu.status', 1)
            //             ->where('sgsu.user_no_fk', $ses_user_pk_no)
            //             ->orderBy('su.serviceunit_name', 'asc')
            //             ->get();
            $service_unit = DB::select(
                'SELECT DISTINCT unit.SERVICEUNIT_NO_PK AS SERVICEUNIT_NO_FK_DEPT, unit.serviceunit_name
                FROM hrms_personnel per
                JOIN sysc_serviceunit unit ON per.SERVICEUNIT_NO_FK_DEPT = unit.serviceunit_no_pk
                JOIN sysc_grant_su gnt ON gnt.SU_NO_FK = unit.serviceunit_no_pk
                WHERE gnt.hr_dept_ind = 1 AND gnt.USER_NO_FK = ?
                ORDER BY unit.serviceunit_name ASC',
                [$ses_user_pk_no]
            );
    
            $units = DB::select(
                'SELECT DISTINCT unit.serviceunit_no_pk AS serviceunit_no_fk, unit.serviceunit_name
                    FROM hrms_personnel per
                    JOIN sysc_serviceunit unit ON per.serviceunit_no_fk = unit.serviceunit_no_pk
                    JOIN sysc_grant_su gnt ON gnt.SU_NO_FK = unit.serviceunit_no_pk
                    WHERE gnt.hr_unit_ind = 1 AND gnt.USER_NO_FK = ?
                    ORDER BY unit.serviceunit_name ASC', 
                [$ses_user_pk_no]
            );
        }

        

        $hod_emp = [];
        $emp_info_arr = [];
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        // dd($shift);
        return template::loadview('admin.hrm.roster.all_employee_roster', compact('emp_info_arr', 'hod_emp', 'shift', 'dutyArea', 'service_unit', 'units', 'type'));
    }
    public function all_employeeRosterV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)
            ->get();
        $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
        from sysc_serviceunit unit,hrms_personnel per
        where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
        order by 2');

        $hod_emp = [];
        $emp_info_arr = [];
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        // dd($shift);
        return template::loadview('admin.hrm.roster.all_employee_roster_v1', compact('emp_info_arr', 'hod_emp', 'shift', 'dutyArea', 'service_unit'));
    }

    // public function all_employee_roster_search(Request $request)
    // {
    //     //dd($request->all());
    //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
    //     // $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
    //     // $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))->where('au_entry_hospital_pk_no', $ses_hospital_id)->groupBy('roster_temp_code')->get();
    //     // $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
    //         ->where('status', '=', 1)
    //         ->get();
    //     $from_date = $request->start_date;
    //     $to_date = $request->end_date;

    //     // dd($request->all(), $from_date,$to_date);
    //     if (isset($request->hidn_personal)) {

    //         $hod_emp = DB::table('sysc_grant_servieceunit_vw')
    //             //->where('user_no_pk', '=', Auth::user()->user_no_pk)
    //             ->where('emp.status', '=', 1)
    //             ->leftJoin('hrms_personnel emp', 'emp.serviceunit_no_fk', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //             ->where('emp.person_no_pk', $request->hidn_personal)
    //             // ->select('emp.person_no_pk', 'emp.full_name')
    //             // ->whereRaw("upper(emp.full_name) like upper('%$variable%')")
    //             ->get();
    //     } else {
    //         //dd(Session::get('user.su_pk_no'));
    //         // $hod_emp = DB::table('sysc_grant_servieceunit_vw')
    //         //     ->where('user_no_pk', '=', Auth::user()->user_no_pk)
    //         //     ->where('emp.status', '=', 1)
    //         //     ->leftJoin('hrms_personnel emp', 'emp.serviceunit_no_fk', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //         //     ->where('emp.serviceunit_no_fk', Session::get('user.su_pk_no'))
    //         //     ->get();

    //         $hod_data = DB::table('hrms_personnel_vw') ->where('status', 1);
    //         if(isset($request->service_unit)){
    //             $hod_data->where('serviceunit_no_fk', $request->service_unit);
    //         }
    //         $hod_emp = $hod_data->whereIn('serviceunit_no_fk', function ($query) {
    //                 return $query->select('serviceunit_no_pk')
    //                     ->from('sysc_grant_servieceunit_vw')
    //                     ->where('user_no_pk', '=', Auth::user()->user_no_pk);
    //             })
    //             ->get();

    //         //dd($hod_emp);
    //     }


    //     $roster_arr = [];
    //     $from_date1 = date('Y-m-d', strtotime($from_date));
    //     $to_date1 = date('Y-m-d', strtotime($to_date));
    //     $emp_info_arr = [];
    //     if (!empty($hod_emp)) {
    //         foreach ($hod_emp as $emp) {
    //             if (isset($request->duty_area)) {

    //                 $roaster_info =  DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                     ->where('duty_area_su_no_fk', $request->duty_area)
    //                     ->where('person_no_fk', $emp->person_no_pk)->first();
    //                 if (isset($roaster_info)) {
    //                     $roaster_data =  DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                         // ->where('duty_area_su_no_fk', $request->duty_area)
    //                         ->where('person_no_fk', $emp->person_no_pk)->get();
    //                     foreach ($roaster_data as $roaster) {
    //                         $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                         $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
    //                             'shift' => $roaster->shift_no_fk,
    //                             'duty_area' => $roaster->duty_area_su_no_fk,
    //                         ];
    //                     }
    //                 }
    //             } else {

    //                 $roaster_data =  DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                     ->where('person_no_fk', $emp->person_no_pk)->get();

    //                 if (count($roaster_data) > 0) {
    //                     foreach ($roaster_data as $roaster) {
    //                         $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                         $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
    //                             'shift' => $roaster->shift_no_fk,
    //                             'duty_area' => $roaster->duty_area_su_no_fk,
    //                         ];
    //                     }
    //                 } else {
    //                     $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                 }
    //             }
    //         }
    //     }

    //     // dd( $emp_info_arr);
    //     $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     // dd(  $hod_emp);
    //     // dd($ $to_date );STATUS
    //     return template::loadview('admin.hrm.roster.all_employee_roster_details', compact('emp_info_arr', 'roster_arr', 'dutyArea', 'hod_emp', 'shift', 'from_date', 'to_date'));
    // }

    public function all_employee_roster_search(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)
            ->get();
        $month = $request->month;
        $year = $request->year;
        if (isset($month) && isset($year)) {
            $firstDay = Carbon::create($year, $month, 1)->startOfMonth();
            $lastDay = Carbon::create($year, $month, 1)->endOfMonth();
            $from_date = $firstDay->toDateString();
            $to_date = $lastDay->toDateString();
        } else {
            $from_date = "";
            $to_date = "";
        }
        // if (isset($request->from_date) && isset($request->to_date)) {
        //     $from_date = $request->from_date;
        //     $to_date = $request->to_date;
        // } else {
        //     $from_date = "";
        //     $to_date = "";
        // } 
        $hod_data = DB::table('employee_info_vw')->where('employee_ind', 1)->where('status', 1)->where('duty_roster_type', 'ROSTER')->orderBy("person_code", "asc");

        if (isset($request->service_unit)) {
            $hod_data->where('serviceunit_no_fk_dept', $request->service_unit);
        }
        if (isset($request->unit)) {
            $hod_data->where('serviceunit_no_fk', $request->unit);
        }
        if (isset($request->hidn_personal)) {
            $hod_data->where('PERSON_NO_PK', $request->hidn_personal);
        }

        $hod_emp = $hod_data->get();
    // dd($hod_emp);
        $roster_arr = [];
        $from_date1 = date('Y-m-d', strtotime($from_date));
        $to_date1 = date('Y-m-d', strtotime($to_date));
        $emp_info_arr = [];
        if (!empty($hod_emp)) {
            foreach ($hod_emp as $emp) {
                if (isset($request->duty_area)) {
                    $roaster_info =  DB::table('hrms_roster')->select('hrms_roster.shift_no_fk', 'hrms_roster.duty_area_su_no_fk', 'hrms_shift.shift_code', 'hrms_shift.sheft_hour', 'hrms_roster.roster_date')
                    ->leftJoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_roster.shift_no_fk')
                    ->whereRaw("hrms_roster.roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                        ->where('hrms_roster.duty_area_su_no_fk', $request->duty_area)
                        ->where('hrms_roster.person_no_fk', $emp->person_no_pk)->first();
                    if (isset($roaster_info)) {
                        $roaster_data =  DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                            // ->where('duty_area_su_no_fk', $request->duty_area)
                            ->where('person_no_fk', $emp->person_no_pk)->get();
                        foreach ($roaster_data as $roaster) {
                            $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                            $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
                                'shift' => $roaster->shift_no_fk,
                                'duty_area' => $roaster->duty_area_su_no_fk,
                                'shift_hour' => $roaster->sheft_hour,
                                'shift_code' => $roaster->shift_code,
                            ];
                        }
                    }
                } else {
                    $roaster_data =  DB::table('hrms_roster')->select('hrms_roster.shift_no_fk', 'hrms_roster.duty_area_su_no_fk', 'hrms_shift.shift_code', 'hrms_shift.sheft_hour', 'hrms_roster.roster_date')
                    ->leftJoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_roster.shift_no_fk')
                    ->whereRaw("hrms_roster.roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                        ->where('hrms_roster.person_no_fk', $emp->person_no_pk)->get();
                    if (count($roaster_data) > 0) {
                        foreach ($roaster_data as $roaster) {
                            $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                            $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
                                'shift' => $roaster->shift_no_fk,
                                'duty_area' => $roaster->duty_area_su_no_fk,
                                'shift_hour' => $roaster->sheft_hour,
                                'shift_code' => $roaster->shift_code,
                            ];
                        }
                    } else {
                        $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                    }
                }
            }
        }
        // dd($roster_arr);
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $month = $request->month;
        $year = $request->year;
        $firstDateOfMonth = Carbon::create($year, $month)
            ->firstOfMonth()
            ->format('d/m/Y');
        $lastDateOfMonth = Carbon::create($year, $month)
            ->lastOfMonth()
            ->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')"); $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        // dd($holidayData);
        $holidays = count($holidayData);
        $weekendCount = countFridaysInMonth($year, $month);
        $lastDayOfMonth = Carbon::create($year, $month)->endOfMonth();
        $totalDaysInMonth = $lastDayOfMonth->day;
        $card_no = $request->hidn_personal;
        $type = $request->type;
        return template::loadview('admin.hrm.roster.all_employee_roster_details', compact('emp_info_arr', 'roster_arr', 'dutyArea', 'hod_emp', 'shift', 'from_date', 'to_date', 'totalDaysInMonth', 'holidays', 'weekendCount', 'holidayData', 'card_no', 'type'));
    }

    public function storeEmployeeRosterDetails(Request $request)
    {

        $roster_code = $request->roster_template; //explode('_', $request->roster_template);

        $id = $request->id;
        $auth_id = Auth::id();

        //dd($request->all());
        DB::beginTransaction();
        try {
            $date = new Carbon($request->start_date);
            $end_date = new Carbon($request->end_date);
            $DstartDate = date("Y-M-d", strtotime($date->toDateString()));
            $DendDate = date("Y-M-d", strtotime($end_date->toDateString()));
            $period = CarbonPeriod::create($DstartDate, $DendDate);

            $hospital_id = Session::get('user.ses_hospital_no_pk');

            $from_date = $request->from_dt;
            $to_date = $request->to_date;
            //dd($request->duty_area_1);
            for ($i = 0; $i < count($request->user_arr); $i++) {
                $from_date1 = date('Y-m-d', strtotime($from_date));
                $to_date1 = date('Y-m-d', strtotime($to_date));
                $start_date = new DateTime($from_date);
                $end_date = new DateTime($to_date);
                $j = 0;
                DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                    ->where('person_no_fk', $request->user_arr[$i])->delete();
                ///->whereRaw(" trunc(duty_start_time) >=  '$from_date' and trunc(duty_start_time) <= '$to_date'   ")
                for ($start_date; $start_date <= $end_date; $start_date->modify('+1 day')) {
                    $selected_date =  $start_date->format('Y-m-d'); //date("Y-m-d", strtotime($start_date));
                    // dd($selected_date);
                    $friday     = strtoupper(date('D', strtotime($selected_date))) == "FRI" ? 1 : 0;
                    $saterday     = strtoupper(date('D', strtotime($selected_date))) == 'SAT' ? 1 : 0;
                    $sunday     = strtoupper(date('D', strtotime($selected_date))) == 'SUN' ? 1 : 0;
                    $monday     = strtoupper(date('D', strtotime($selected_date))) == 'MON' ? 1 : 0;
                    $tuesday     = strtoupper(date('D', strtotime($selected_date))) == 'TUE' ? 1 : 0;
                    $wednesday     = strtoupper(date('D', strtotime($selected_date))) == 'WED' ? 1 : 0;
                    $thursday     = strtoupper(date('D', strtotime($selected_date))) == 'THU' ? 1 : 0;

                    //dd('day ',strtoupper(date('D', strtotime($selected_date))));
                    //dd($friday,$saterday,$sunday,$monday,$tuesday,$wednesday,$thursday);
                    $duty_shift = $request->input('duty_shift_' . $request->user_arr[$i]);
                    $duty_area = $request->input('duty_area_' . $request->user_arr[$i]);
               
                    if (isset($duty_shift[$j])) {
                        $shift_1 = explode('_', $duty_shift[$j]);
                        //dd($shift_1);
                        $ss =  date('H:i', strtotime($shift_1[0]));
                        $en =  date('H:i', strtotime($shift_1[1]));

                        // $duty_area             = $request->duty_area_1;
                        $shift_type         = @$shift_1[2];
                        $dayOff             = (@$shift_1[4] == "0") ? 1 : 0;
                        $start_time           = date("Y-m-d H:i", strtotime($selected_date . " " . $ss));
                        $end_time            = date("Y-m-d H:i", strtotime($selected_date . " " . $en));
                        $day_name1           = (@$shift_1[4] == "0") ? (($friday == 1) ? 1 : 0) :    $friday;
                        $day_name2           = (@$shift_1[4] == "0") ? (($saterday == 1) ? 1 : 0) :  $saterday;
                        $day_name3           = (@$shift_1[4] == "0") ? (($sunday == 1) ? 1 : 0) :    $sunday;
                        $day_name4           = (@$shift_1[4] == "0") ? (($monday == 1) ? 1 : 0) :    $monday;
                        $day_name5           = (@$shift_1[4] == "0") ? (($tuesday == 1) ? 1 : 0) :   $tuesday;
                        $day_name6           = (@$shift_1[4] == "0") ? (($wednesday == 1) ? 1 : 0) : $wednesday;
                        $day_name7           = (@$shift_1[4] == "0") ? (($thursday == 1) ? 1 : 0) :  $thursday;

                        $data = [
                            'roster_code'            => (isset($roster_code)) ? isset($roster_code) : 1,
                            'roster_date'            => $selected_date,
                            'person_no_fk'           => $request->user_arr[$i],
                            'duty_area_su_no_fk'     => @$duty_area[$j],
                            'shift_no_fk'            => @$shift_type,
                            'duty_start_time'        => @$start_time,
                            'duty_end_time'          => @$end_time,
                            'schedule_day_fri'       => @$day_name1,
                            'schedule_day_sat'       => @$day_name2,
                            'schedule_day_sun'       => @$day_name3,
                            'schedule_day_mon'       => @$day_name4,
                            'schedule_day_tue'       => @$day_name5,
                            'schedule_day_wed'       => @$day_name6,
                            'schedule_day_thu'       => @$day_name7,
                            'roster_temp_no_fk'      => 1, //$roster_code ? $roster_code : '',
                            'dayoff_ind'             => @$dayOff,
                            'status'                 => 1,
                            'au_entry_by'            => 1,
                            'au_entry_hospital_pk_no' => $hospital_id
                        ];
                        //dd($data);
                        $this->model3->create($data);
                        DB::commit();
                    }
                    $j++;
                }
            }


            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    // public function all_employee_roster_search_print(Request $request)
    // {
    //     // dd($request->all());
    //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
    //     // $roster = Roster::select('roster_temp_no_pk', 'roster_temp_code')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
    //     // $roster_unique = Roster::select('roster_temp_code', DB::raw("count(*) as template_code"))->where('au_entry_hospital_pk_no', $ses_hospital_id)->groupBy('roster_temp_code')->get();
    //     // $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
    //         ->where('status', '=', 1)
    //         ->get();
    //     $from_date = $request->start_date;
    //     $to_date = $request->end_date;

    //     // dd($request->all(), $from_date,$to_date);
    //     if (isset($request->hidn_personal)) {
    //         $hod_emp = DB::table('sysc_grant_servieceunit_vw')
    //             //->where('user_no_pk', '=', Auth::user()->user_no_pk)
    //             ->where('emp.status', '=', 1)
    //             ->leftJoin('hrms_personnel emp', 'emp.serviceunit_no_fk', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //             ->where('emp.person_no_pk', $request->hidn_personal)
    //             // ->select('emp.person_no_pk', 'emp.full_name')
    //             // ->whereRaw("upper(emp.full_name) like upper('%$variable%')")
    //             ->get();
    //     } else {
    //         // $hod_emp = DB::table('sysc_grant_servieceunit_vw')
    //         //     ->where('user_no_pk', '=', Auth::user()->user_no_pk)
    //         //     ->where('emp.status', '=', 1)
    //         //     ->leftJoin('hrms_personnel emp', 'emp.serviceunit_no_fk', '=', 'sysc_grant_servieceunit_vw.serviceunit_no_pk')
    //         //     // ->select('emp.person_no_pk', 'emp.full_name')
    //         //     // ->whereRaw("upper(emp.full_name) like upper('%$variable%')")
    //         //     ->get();





    //         $hod_data = DB::table('hrms_personnel_vw')->where('status', 1);
    //         if (isset($request->service_unit)) {
    //             $hod_data->where('serviceunit_no_fk', $request->service_unit);
    //         }
    //         $hod_emp = $hod_data->whereIn('serviceunit_no_fk', function ($query) {
    //             return $query->select('serviceunit_no_pk')
    //                 ->from('sysc_grant_servieceunit_vw')
    //                 ->where('user_no_pk', '=', Auth::user()->user_no_pk);
    //         })
    //             ->get();

    //         //dd($hod_emp);
    //     }

    //     $roster_arr = [];
    //     $shift_arr = [];
    //     $emp_info_arr = [];
    //     $from_date1 = date('Y-m-d', strtotime($from_date));
    //     $to_date1 = date('Y-m-d', strtotime($to_date));

    //     // $roster_validate = DB::select("select  from hrms_roster a left join hrms_shift b on a.shift_no_fk=b.shift_no_pk left join sysc_lookupdata c on c.lookupdata_no_pk =a.duty_area_su_no_fk  where $date_cond $personal_cond and a.au_entry_hospital_pk_no =  $ses_hospital_id ORDER BY roster_date ASC");
    //     if (!empty($hod_emp)) {
    //         foreach ($hod_emp as $emp) {
    //             if (isset($request->duty_area)) {
    //                 $roaster_info =  DB::table('hrms_roster a')
    //                     ->leftjoin('hrms_shift b', 'a.shift_no_fk', 'b.shift_no_pk')
    //                     ->leftjoin('sysc_lookupdata c', 'c.lookupdata_no_pk', 'a.duty_area_su_no_fk')
    //                     ->select(DB::raw('trunc(a.roster_date) roster_date, c.lookupdata_name , b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,a.duty_end_time'))
    //                     ->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                     ->where('duty_area_su_no_fk', $request->duty_area)
    //                     ->where('person_no_fk', $emp->person_no_pk)->first();
    //                 if (isset($roaster_info)) {
    //                     $roaster_data =  DB::table('hrms_roster a')
    //                         ->leftjoin('hrms_shift b', 'a.shift_no_fk', 'b.shift_no_pk')
    //                         ->leftjoin('sysc_lookupdata c', 'c.lookupdata_no_pk', 'a.duty_area_su_no_fk')
    //                         ->select(DB::raw('trunc(a.roster_date) roster_date, c.lookupdata_name , b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,a.duty_end_time'))
    //                         ->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                         //  ->where('duty_area_su_no_fk', $request->duty_area)
    //                         ->where('person_no_fk', $emp->person_no_pk)->get();
    //                     foreach ($roaster_data as $roaster) {
    //                         $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                         $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
    //                             'shift' => $roaster->shift_code,
    //                             'duty_area' => $roaster->lookupdata_name,
    //                             'duty_start_time' => $roaster->duty_start_time,
    //                             'duty_end_time' => $roaster->duty_end_time,
    //                         ];
    //                         $shift_arr[$roaster->shift_code] = $roaster->shift_code;
    //                     }
    //                 }
    //             } else {
    //                 $roaster_data =  DB::table('hrms_roster a')
    //                     ->leftjoin('hrms_shift b', 'a.shift_no_fk', 'b.shift_no_pk')
    //                     ->leftjoin('sysc_lookupdata c', 'c.lookupdata_no_pk', 'a.duty_area_su_no_fk')
    //                     ->select(DB::raw('trunc(a.roster_date) roster_date, c.lookupdata_name , b.shift_code,a.duty_start_time,a.duty_area_su_no_fk,a.roster_no_pk,a.duty_end_time'))
    //                     ->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
    //                     ->where('person_no_fk', $emp->person_no_pk)->get();
    //                 if (count($roaster_data) > 0) {
    //                     foreach ($roaster_data as $roaster) {
    //                         $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                         $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
    //                             'shift' => $roaster->shift_code,
    //                             'duty_area' => $roaster->lookupdata_name,
    //                             'duty_start_time' => $roaster->duty_start_time,
    //                             'duty_end_time' => $roaster->duty_end_time
    //                         ];
    //                         $shift_arr[$roaster->shift_code] = $roaster->shift_code;
    //                     }
    //                 } else {
    //                     $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
    //                 }
    //             }
    //         }
    //     }
    //     $personal_id = Session::get('roster_emp_card');

    //     $emp_info = DB::table('HRMS_PERSONNEL_VW')
    //         ->where('person_no_pk', '=',  Auth::user()->person_no_fk)
    //         ->select('person_code', 'full_name', 'su_name')
    //         ->first();

    //     $dutyArea = $this->getLookupListByCode('DUTYAREA');
    //     // dd(  $hod_emp);
    //     // dd($ $to_date );STATUS

    //     $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
    //     $pdf = PDF::loadView("admin.hrm.roster.employee_details_roster_pdf", ["emp_info_arr" => $emp_info_arr, "shift_arr" => $shift_arr, "emp_info" => $emp_info, "po_hospital_details" => $po_hospital_details, "roster_arr" => $roster_arr, 'dutyArea' => $dutyArea, 'from_date' => $from_date, 'to_date' => $to_date, 'hod_emp' => $hod_emp, 'shift' => $shift])->setPaper('a4', 'landscape');
    //     return $pdf->stream('daily_attendance_report_print.pdf');
    // }

    public function all_employee_roster_search_print(Request $request)
    {
    
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $emp_info = DB::table('HRMS_PERSONNEL_VW')
            ->where('person_no_pk', '=',  Auth::user()->person_no_fk)
            ->select('person_code', 'full_name', 'su_name')
            ->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $shiftGroupedData = [];
        $shift = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)->get();
        if(Session::get('user.ses_hospital_code') == 'EWMCH'){
            $shiftGroup = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)->take(30)->orderBy('shift_no_pk', 'asc')->get();
        }else{
            $shiftGroup = DB::table('hrms_shift')->where('au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('status', '=', 1)->orderBy('shift_no_pk', 'asc')->get();
        }
        foreach ($shiftGroup->chunk(3) as $chunk) {
            $shiftGroupedData[] = $chunk->toArray();
        }
        // dd($shiftGroupedData);
        $month = $request->month;
        $year = $request->year;
        $firstDateOfMonth = Carbon::create($year, $month)
            ->firstOfMonth()
            ->format('d/m/Y');
        $lastDateOfMonth = Carbon::create($year, $month)
            ->lastOfMonth()
            ->format('d/m/Y');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        $holidays = count($holidayData);
        $weekendCount = countFridaysInMonth($year, $month);
        $lastDayOfMonth = Carbon::create($year, $month)->endOfMonth();
        $totalDaysInMonth = $lastDayOfMonth->day;
        // $carbonDate = Carbon::createFromFormat('m', $month);
        $carbonDate = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-'.'01');
        $monthName = $carbonDate->format('F');
        $monthYear = $monthName . ', ' . $year;
        if (isset($month) && isset($year)) {
            $firstDay = Carbon::create($year, $month, 1)->startOfMonth();
            $lastDay = Carbon::create($year, $month, 1)->endOfMonth();
            $from_date = $firstDay->toDateString();
            $to_date = $lastDay->toDateString();
        } else {
            $from_date = "";
            $to_date = "";
        }

        $hod_data = DB::table('employee_info_vw')->where('employee_ind', 1)->where('status', 1)->where('duty_roster_type', 'ROSTER')->orderBy("person_code", "asc");

        if (isset($request->service_unit)) {
            $hod_data->where('serviceunit_no_fk_dept', $request->service_unit);
        }
        if (isset($request->unit)) {
            $hod_data->where('serviceunit_no_fk', $request->unit);
        }
        if (isset($request->hidn_personal)) {
            $hod_data->where('PERSON_NO_PK', $request->hidn_personal);
        }

        $hod_emp = $hod_data->get();
        $su_name = count($hod_emp) > 0 ? $hod_emp[0]->su_name : null;
        $roster_arr = [];
        $from_date1 = date('Y-m-d', strtotime($from_date));
        $to_date1 = date('Y-m-d', strtotime($to_date));
        $emp_info_arr = [];
        if (!empty($hod_emp)) {
            foreach ($hod_emp as $emp) {
                if (isset($request->duty_area)) {

                    $roaster_info =  DB::table('hrms_roster')->select('hrms_roster.shift_no_fk', 'hrms_roster.duty_area_su_no_fk', 'hrms_shift.shift_code', 'hrms_shift.sheft_hour', 'hrms_roster.roster_date')
                    ->leftJoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_roster.shift_no_fk')
                    ->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                        ->where('duty_area_su_no_fk', $request->duty_area)
                        ->where('person_no_fk', $emp->person_no_pk)->first();
                    if (isset($roaster_info)) {
                        $roaster_data =  DB::table('hrms_roster')->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                            // ->where('duty_area_su_no_fk', $request->duty_area)
                            ->where('person_no_fk', $emp->person_no_pk)->get();
                        foreach ($roaster_data as $roaster) {
                            $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                            $rosterDate = date('Y-m-d', strtotime($roaster->roster_date));
                            $leaveInfo = DB::table('hrms_leave_entry')
                            ->select('leave_code')
                            ->where('person_no_fk', $emp->person_no_pk)
                            ->where('approved_ind', 1)
                            ->whereRaw("TO_DATE('$rosterDate', 'YYYY-MM-DD') BETWEEN TRUNC(FROM_DATE) AND TRUNC(TO_DATES)")
                            ->first();
                            $leaveCode = isset($leaveInfo) ? $leaveInfo->leave_code : null;
                            $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
                                'shift' => $roaster->shift_no_fk,
                                'duty_area' => $roaster->duty_area_su_no_fk,
                                'shift_hour' => $roaster->sheft_hour,
                                'shift_code' => $roaster->shift_code,
                                'leave_code' => $leaveCode
                            ];
                        }
                    }
                } else {
                    $roaster_data =  DB::table('hrms_roster')->select('hrms_roster.shift_no_fk', 'hrms_roster.duty_area_su_no_fk', 'hrms_shift.shift_code', 'hrms_shift.sheft_hour', 'hrms_roster.roster_date')
                    ->leftJoin('hrms_shift', 'hrms_shift.shift_no_pk', '=', 'hrms_roster.shift_no_fk')
                    ->whereRaw("roster_date between trunc(to_date('$from_date1', 'YYYY-MM-DD')) and trunc(to_date('$to_date1','YYYY-MM-DD'))")
                        ->where('person_no_fk', $emp->person_no_pk)->get();
                    if (count($roaster_data) > 0) {
                        foreach ($roaster_data as $roaster) {
                            $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                            $rosterDate = date('Y-m-d', strtotime($roaster->roster_date));
                            $leaveInfo = DB::table('hrms_leave_entry')
                            ->select('leave_code')
                            ->where('person_no_fk', $emp->person_no_pk)
                            ->where('approved_ind', 1)
                            ->whereRaw("TO_DATE('$rosterDate', 'YYYY-MM-DD') BETWEEN TRUNC(FROM_DATE) AND TRUNC(TO_DATES)")
                            ->first();
                            $leaveCode = isset($leaveInfo) ? $leaveInfo->leave_code : null;
                            $roster_arr[date('Y-m-d', strtotime($roaster->roster_date))][$emp->person_no_pk] = [
                                'shift' => $roaster->shift_no_fk,
                                'duty_area' => $roaster->duty_area_su_no_fk,
                                'shift_hour' => $roaster->sheft_hour,
                                'shift_code' => $roaster->shift_code,
                                'leave_code' => $leaveCode
                            ];
                        }
                    } else {
                        $emp_info_arr[$emp->person_no_pk] = $emp->person_no_pk;
                    }
                }
            }
        }
        $dutyArea = $this->getLookupListByCode('DUTYAREA');
        $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')"); $holidayData = DB::select("select holiday_date from HRMS_HOLIDAY where trunc(HOLIDAY_DATE) between TO_DATE('$firstDateOfMonth', 'DD/MM/YYYY') and TO_DATE('$lastDateOfMonth', 'DD/MM/YYYY')");
        // return template::loadview('admin.hrm.roster.all_employee_roster_details', compact('emp_info_arr', 'roster_arr', 'dutyArea', 'hod_emp', 'shift', 'from_date', 'to_date', 'emp_info', 'monthYear'));
        // dd($hod_emp);
        $pdf = PDF::loadView("admin.hrm.roster.employee_details_roster_pdf", compact('emp_info_arr', 'roster_arr', 'dutyArea', 'hod_emp', 'shift', 'from_date', 'to_date', 'emp_info', 'monthYear', 'po_hospital_details', 'weekendCount', 'holidays', 'totalDaysInMonth', 'shiftGroupedData', 'holidayData', 'su_name'))->setPaper('a4', 'landscape');
        return $pdf->stream('daily_attendance_report_print.pdf');
    }

    // overtime requisition
    public function overtimeRequisition()
    {
        $to_date = date('d-m-Y');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $overtimeRequisitiondata = DB::select("select a.attendance_no_pk, a.entry_type, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name, a.person_no_fk, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_attendance_dailyot dailyot ON a.person_no_fk = dailyot.person_no_fk and a.attendance_date = dailyot.attendance_date
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(a.ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and dailyot.attendance_no_fk IS NULL and b.status = 1 and b.ot_payable_ind = 1 and to_char(a.out_time,'HH24:MI:SS')  > '19:00:59' and nvl(b.virtual_ind,0)=0 $from_date_cond order by trunc(a.ATTENDANCE_DATE) desc");
        return Template::loadview("admin.hrm.overtimeRequisition.overtime_requisition", ['overtimeRequisitiondata' => $overtimeRequisitiondata, 'dept' => $dept, 'desig' => $desig]);
       
    }

    public function searchOvertimeRequisition(Request $request)
    {
        $personal_no_pk = $request->card_hidn;
        $att_status = $request->att_status;
        $designation = $request->designation_name;
        $loginUser = Session::get('user.ses_person_no_fk');
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;

        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        if (isset($salaryData) && $salaryData->cut_off_ind == 1) {
            $start_date = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $end_date = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $start_date = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        $from_date = date("d-m-Y", strtotime($start_date));
        $to_date = date("d-m-Y", strtotime($end_date));

        $from_date_cond = ($request->month != "" && $request->year != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : ""; 
        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        $att_status_con = ($att_status != "") ? " and case when nvl(lv.LEAVE_NO_PK,0) > 0 then 3 when attendance_status in (6, 7) then 4 when trunc(a.in_time) is not null and trunc(a.OUT_TIME) is null then 99 when trunc(ATTENDANCE_DATE)=trunc(a.in_time) then 1 else 5 end = $att_status" : "";

        $overtimeRequisitiondata = DB::select("select a.attendance_no_pk, a.entry_type, a.manual_status, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name, a.person_no_fk, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_attendance_dailyot dailyot ON a.person_no_fk = dailyot.person_no_fk and a.attendance_date = dailyot.attendance_date
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(a.ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and dailyot.attendance_no_fk IS NULL and b.status = 1 and b.ot_payable_ind = 1 and to_char(a.out_time,'HH24:MI:SS')  > '18:00:59' and nvl(b.virtual_ind,0)=0 and (b.emp_hod1_person_no_fk = $loginUser or b.emp_supvisor1_person_no_fk = $loginUser)  $from_date_cond $department_con $designation_con $card_no_con $att_status_con order by trunc(a.ATTENDANCE_DATE) desc, person_card_no asc");
     
        return Template::loadview("admin.hrm.overtimeRequisition.overtime_requisition_list", ['overtimeRequisitiondata' => $overtimeRequisitiondata]);
    }
    public function allOvertimeRequisition()
    {
        $to_date = date('d-m-Y');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";

        $overtimeRequisitiondata = DB::select("select a.attendance_no_pk, a.entry_type, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name, a.person_no_fk, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_attendance_dailyot dailyot ON a.person_no_fk = dailyot.person_no_fk and a.attendance_date = dailyot.attendance_date
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(a.ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and dailyot.attendance_no_fk IS NULL and b.status = 1 and b.ot_payable_ind = 1 and to_char(a.out_time,'HH24:MI:SS')  > '19:00:59' and nvl(b.virtual_ind,0)=0 $from_date_cond order by trunc(a.ATTENDANCE_DATE) desc");
        return Template::loadview("admin.hrm.overtimeRequisition.all_overtime_requisition", ['overtimeRequisitiondata' => $overtimeRequisitiondata, 'dept' => $dept, 'desig' => $desig]);
       
    }

    public function searchAllOvertimeRequisition(Request $request)
    {
        $personal_no_pk = $request->card_hidn;
        $att_status = $request->att_status;
        $designation = $request->designation_name;
        $loginUser = Session::get('user.ses_person_no_fk');
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $personal_no_pk)->first();
        $department = $request->department_name;
        $department_con = ($request->department_name != "") ? "  and b.serviceunit_no_fk = $department" : "";
        $designation_con = ($designation != "") ? "  and b.jobtitle_lookup_no_fk = $designation" : "";
        $month = $request->month;
        $year = $request->year;
        $month_year = $year . $month;

        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        if (isset($salaryData) && $salaryData->cut_off_ind == 1) {
            $start_date = isset($salaryData->cut_off_strday) ? getPreviousMonthSpecificDate($month_year, $salaryData->cut_off_strday)->format('Y-m-d') : "";
            $end_date = isset($salaryData->cut_off_endday) ? getCurrentMonthSpecificDate($month_year, $salaryData->cut_off_endday)->format('Y-m-d') : "";
        } else {
            $start_date = Carbon::create($year, $month)->firstOfMonth()->format('Y-m-d');
            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');
        }
        $from_date = date("d-m-Y", strtotime($start_date));
        $to_date = date("d-m-Y", strtotime($end_date));
        
        $from_date_cond = ($request->month != "" && $request->year != "") ? " and a.attendance_date between  to_date('$from_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : ""; 
        $card_no_con = ($request->card_no != "") ? " and a.person_card_no='$card_no->person_code'" : "";
        $att_status_con = ($att_status != "") ? " and case when nvl(lv.LEAVE_NO_PK,0) > 0 then 3 when attendance_status in (6, 7) then 4 when trunc(a.in_time) is not null and trunc(a.OUT_TIME) is null then 99 when trunc(ATTENDANCE_DATE)=trunc(a.in_time) then 1 else 5 end = $att_status" : "";

        $overtimeRequisitiondata = DB::select("select a.attendance_no_pk, a.entry_type, a.manual_status, a.early_time_min, a.attendance_date
        ,a.duty_in_time,a.duty_out_time,a.in_time,a.out_time,a.over_time_min,
        a.late_time_min,b.photo_name, a.person_no_fk, a.person_card_no,a.attendance_status_text,a.attendance_status, b.full_name,c.designation_name
        , su.serviceunit_name, shift.shift_code, case when nvl(lv.LEAVE_NO_PK,0) >0 then 1 else 0 end LEAVE_ENTRY_IND, lv.LEAVE_REASON, LOOKUPDATA_CODE LEAVE_TYPE_CODE, LOOKUPDATA_NAME LEAVE_TYPE_NAME
        from hrms_attendance_daily a
        left join hrms_attendance_dailyot dailyot ON a.person_no_fk = dailyot.person_no_fk and a.attendance_date = dailyot.attendance_date
        left join hrms_personnel b ON b.person_code = a.person_card_no
        left join hrms_designation c ON c.designation_no_pk = b.jobtitle_lookup_no_fk
        left join sysc_serviceunit su ON su.serviceunit_no_pk = b.serviceunit_no_fk
        left join hrms_shift shift on a.duty_shift_no_fk = shift.shift_no_pk
        left join (select PERSON_NO_FK, FROM_DATE, TO_DATES, LEAVE_REASON, LEAVE_NO_PK, LOOKUPDATA_CODE, LOOKUPDATA_NAME from HRMS_LEAVE_ENTRY_VW
        where nvl(APPROVED_DEPT_IND,0) = 1 and nvl(APPROVED_HR_IND,0) = 1) lv
        on b.person_no_pk = lv.PERSON_NO_FK and trunc(a.ATTENDANCE_DATE) between FROM_DATE and TO_DATES
        where a.person_card_no IS NOT NULL and dailyot.attendance_no_fk IS NULL and b.status = 1 and b.ot_payable_ind = 1 and to_char(a.out_time,'HH24:MI:SS')  > '18:00:59' and nvl(b.virtual_ind,0)=0  $from_date_cond $department_con $designation_con $card_no_con $att_status_con order by trunc(a.ATTENDANCE_DATE) desc");
     
        return Template::loadview("admin.hrm.overtimeRequisition.all_overtime_requisition_list", ['overtimeRequisitiondata' => $overtimeRequisitiondata]);
    }

    public function overtimeRequisitionApprove(Request $request)
    {
        $ids             = isset($request->requisition_item) ? $request->requisition_item : [];
        $person_no_fk    = isset($request->person_no_fk) ? $request->person_no_fk : [];
        $person_card_no  = isset($request->person_card_no) ? $request->person_card_no : [];
        $attendance_date = isset($request->attendance_date) ? $request->attendance_date : [];
        $duty_in_time    = isset($request->duty_in_time) ? $request->duty_in_time : [];
        $duty_out_time   = isset($request->duty_out_time) ? $request->duty_out_time : [];
        $overtime        = isset($request->overtime) ? $request->overtime : [];
        $overtime_hidden = isset($request->overtime_hidden) ? $request->overtime_hidden : [];
        $auth_id         = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $au_entry_at     = Carbon::now();
        $au_entry_at     = $au_entry_at->toDateString();
        $sequence        = DB::getSequence();
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {

                $dailyot_no_pk_seq = $sequence->nextValue('dailyot_no_pk_seq');
                $overTimePartition = isset($overtime[$id]) ? explode(":", $overtime[$id]) : [];
                $overTimeMin = intval($overTimePartition[0] * 60) + intval($overTimePartition[1]);
                $actualOverTimePartition = isset($overtime_hidden[$id]) ? explode(":", $overtime_hidden[$id]) : [];
                $actualOverTimeMin = intval($actualOverTimePartition[0] * 60) + intval($actualOverTimePartition[1]);
                $data = [
                    'dailyot_no_pk'           => $dailyot_no_pk_seq,
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_entry_at'             => $au_entry_at,
                    'au_entry_by'             => $auth_id,
                    'approve_by'              => $auth_id,
                    'approve_date'            => $au_entry_at,
                    'au_entry_session'        => "overtime",
                    'attendance_no_fk'        => isset($id) ? $id : "",
                    'person_no_fk'            => isset($person_no_fk[$id]) ? $person_no_fk[$id] : "",
                    'person_card_no'          => isset($person_card_no[$id]) ? $person_card_no[$id] : "",
                    'attendance_date'         => isset($attendance_date[$id]) ? $attendance_date[$id] : "",
                    'attendance_yyyymm'       => isset($attendance_date[$id]) ? str_replace("-", "", date("Y-m", strtotime($attendance_date[$id]))) : "",
                    'duty_out_time'           => isset($duty_out_time[$id]) ? $duty_out_time[$id] : "",
                    'ot_time'                 => isset($overTimeMin) ? $overTimeMin : "",
                    'actual_ot_time'          => isset($actualOverTimeMin) ? $actualOverTimeMin : "",
                    'duty_in_time'            => isset($duty_in_time[$id]) ? $duty_in_time[$id] : "",
                ];

                DB::table('HRMS_ATTENDANCE_DAILYOT')->insert($data);
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
    public function overtimeRequisitionFinalize(Request $request)
    {
        $ids             = isset($request->ot_item) ? $request->ot_item : [];
        $overtime        = isset($request->overtime) ? $request->overtime : [];
        $auth_id         = Auth::id();
        $au_entry_at     = Carbon::now();
        $au_entry_at     = $au_entry_at->toDateString();
        $sequence        = DB::getSequence();
        DB::beginTransaction();
        try {
            foreach ($ids as $key => $id) {
                $overTimePartition = isset($overtime[$id]) ? explode(":", $overtime[$id]) : [];
                $overTimeMin = intval($overTimePartition[0] * 60) + intval($overTimePartition[1]);
                $data = [
                    'finalize_ind'           => 1,
                    'finalize_by'             => $auth_id,
                    'finalize_date'            => $au_entry_at,
                    'ot_time'                 => isset($overTimeMin) ? $overTimeMin : "",
                ];

                DB::table('hrms_attendance_dailyot')
                ->where('dailyot_no_pk', $id)
                ->update($data);
            }
            if(count($ids) > 0){
                DB::commit();
                $message = ['msg' => 'Finalized Successfully', 'title' => 'Success'];
            }else{
                $message = ['msg' => 'Please check the checkbox !!', 'title' => 'Error'];
            } 
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function overtimeRequisitionApproved()
    {
        $to_date = date('d-m-Y');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $from_date_cond = ($to_date != "") ? " and a.attendance_date between  to_date('$to_date','DD-MM-YYYY') and   to_date('$to_date','DD-MM-YYYY') " : "";
        $overtimeRequisitiondata = [];

        return Template::loadview("admin.hrm.overtimeRequisition.overtime_requisition_approved_list", ['overtimeRequisitiondata' => $overtimeRequisitiondata, 'dept' => $dept, 'desig' => $desig]);
    }
    public function searchOvertimeRequisitionApproved(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->card_hidn)->first();
        $year_month = $request->year . $request->month;
        $year_month_cond = ($year_month != "") ? " and dailyot.attendance_yyyymm =  $year_month" : "";
        $card_no_con = ($request->card_no != "") ? " and dailyot.person_card_no='$card_no->person_code'" : "";
        $dep_con = ($request->department_name != "") ? " and emp.serviceunit_no_fk=$request->department_name" : "";

        $overtimeRequisitiondata = DB::select("select dailyot.person_no_fk, dailyot.person_card_no, emp.full_name, fnc_serviceunitname(emp.serviceunit_no_fk) department, sum(dailyot.ot_time) ot_time, sum(dailyot.actual_ot_time) actual_ot_time, dailyot.attendance_yyyymm, usr.user_fullname, dailyot.finalize_ind from hrms_attendance_dailyot dailyot
        left join hrms_personnel emp on dailyot.person_no_fk = emp.person_no_pk 
        left join wsec_user usr on dailyot.approve_by = usr.user_no_pk 
        where dailyot.au_entry_hospital_pk_no = $ses_hospital_id and emp.ot_payable_ind = 1 $year_month_cond $card_no_con $dep_con
        group by dailyot.person_no_fk, dailyot.person_card_no, emp.full_name, emp.serviceunit_no_fk, dailyot.attendance_yyyymm, usr.user_fullname, dailyot.finalize_ind");
        // dd($overtimeRequisitiondata);

        return Template::loadview("admin.hrm.overtimeRequisition.overtime_requisition_approved_list_table", ['overtimeRequisitiondata' => $overtimeRequisitiondata]);
    }

    public function overtimeRequisitionApprovedDetail($id, $att_yyyymm, $finalize_ind = null)
    {
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
// dd($finalize_ind);
        $finalize_condition = is_null($finalize_ind) ? "dailyot.finalize_ind IS NULL" : "dailyot.finalize_ind = $finalize_ind";
        $overtimeRequisitionDetailData = DB::select("select dailyot.dailyot_no_pk, dailyot.attendance_date, dailyot.person_card_no, dailyot.ot_time, dailyot.actual_ot_time,emp.full_name, fnc_serviceunitname(emp.serviceunit_no_fk) department , usr.user_fullname, dailyot.approve_date, dailyot.approve_date, dailyot.finalize_ind from hrms_attendance_dailyot dailyot
        left join hrms_personnel emp on dailyot.person_no_fk = emp.person_no_pk
        left join wsec_user usr on dailyot.approve_by = usr.user_no_pk 
        where dailyot.au_entry_hospital_pk_no = $hospital_pk_no and dailyot.person_no_fk=$id and dailyot.attendance_yyyymm=$att_yyyymm and $finalize_condition  order by dailyot.attendance_date asc");

        $finalizedData = array_filter($overtimeRequisitionDetailData, function($item) {
            return $item->finalize_ind == 1; // Check if finalize_ind is 1
        });
        // dd(count($finalizedData));
        return Template::loadView("admin.hrm.overtimeRequisition.overtime_requisition_approved_detail", [
            'overtimeRequisitionDetailData' => $overtimeRequisitionDetailData,
            'finalizedData' => $finalizedData
        ]);
    }
    // late list
    public function lateList()
    {
        $to_date = date('d-m-Y');
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $desig = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $lateListdata = [];

        return Template::loadview("admin.hrm.lateList.late_list", ['lateListdata' => $lateListdata, 'dept' => $dept, 'desig' => $desig, 'year_month' => ""]);
    }
    public function searchLateList(Request $request)
    {
        
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $card_no = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $request->card_hidn)->first();
        $year_month = $request->month . $request->year;
        $year_month_cond = ($year_month != "") ? " and late.attendance_month =  $year_month" : "";
        $card_no_con = ($request->card_no != "") ? " and late.person_card_no='$card_no->person_code'" : "";
        $dep_con = ($request->department_name != "") ? " and emp.serviceunit_no_fk=$request->department_name" : "";

        $lateListdata = DB::select("select late.person_no_fk, late.person_card_no, emp.full_name, fnc_serviceunitname(emp.serviceunit_no_fk) department, late.attendance_month, count(late.person_no_fk) as late_count from hrms_emp_latelist late  left join hrms_personnel emp on late.person_no_fk = emp.person_no_pk where emp.au_entry_hospital_pk_no = $ses_hospital_id $year_month_cond $card_no_con $dep_con group by late.person_no_fk, late.person_card_no, emp.full_name, emp.serviceunit_no_fk, late.attendance_month HAVING COUNT(late.person_no_fk) > 2 order by person_card_no ASC");
        $personNos = DB::table('hrms_emplatededuction')
        ->where('deduction_month', $year_month)
        ->pluck('person_no_fk')
        ->toArray();
        return Template::loadview("admin.hrm.lateList.late_list_table", ['lateListdata' => $lateListdata, 'year_month' => $year_month, 'personNos' => $personNos]);
    }

    public function lateDetail($id, $att_yyyymm)
    {
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $lateDetaildata = DB::select("select late.attendance_date, late.duty_in_time, late.duty_out_time, late.person_card_no, emp.full_name, fnc_serviceunitname(emp.serviceunit_no_fk) department, late.attendance_month, late.in_time, late.out_time, shift.shift_code from hrms_emp_latelist late left join hrms_personnel emp on late.person_no_fk = emp.person_no_pk left join hrms_shift shift on shift.shift_no_pk = late.duty_shift_no_fk where emp.au_entry_hospital_pk_no = $hospital_pk_no and late.person_no_fk=$id and late.attendance_month= $att_yyyymm order by late.attendance_date asc");

        return Template::loadView("admin.hrm.lateList.late_detail", [
            'lateDetaildata' => $lateDetaildata
        ]);
    }

    public function approvedLateDetail($id, $att_yyyymm)
    {
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $lateDeductiondata = DB::select("select late.deduction_type, late.leave_code, late.no_of_days, emp.person_code, emp.full_name, fnc_serviceunitname(emp.serviceunit_no_fk) department, late.deduction_month from hrms_emplatededuction late left join hrms_personnel emp on late.person_no_fk = emp.person_no_pk  where emp.au_entry_hospital_pk_no = $hospital_pk_no and late.person_no_fk=$id and late.deduction_month= $att_yyyymm order by late.latededuction_no_pk asc");

        return Template::loadView("admin.hrm.lateList.approved_late_detail", [
            'lateDeductiondata' => $lateDeductiondata
        ]);
    }
    
    public function storeEmpLateDeductionInfo(Request $request){
        $ids             = isset($request->late_deduction_item) ? $request->late_deduction_item : [];
        $person_no_fk    = isset($request->person_no_fk) ? $request->person_no_fk : [];
        $no_of_days      = isset($request->no_of_days) ? $request->no_of_days : [];
        $auth_id         = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');;
        $au_entry_at     = Carbon::now();
        $au_entry_at     = $au_entry_at->toDateString();
        $year_month     = $request->year_month;
        $sequence        = DB::getSequence();
        DB::beginTransaction();
        try {
            if(count($ids) > 0){
                foreach ($ids as $key => $id) {
                    if(isset($no_of_days[$id]) && $no_of_days[$id] > 0){
                        $leaveBalances = DB::table('hrms_personal_leave_vw')
                        ->where('person_no_pk', $person_no_fk[$id])
                        ->whereIn('leave_code', ['CL', 'EL', 'SL'])
                        ->pluck('balance', 'leave_code'); 
            
                        $late = (int) floor($no_of_days[$id]/3);
                        $cl = $leaveBalances['CL'] ?? 0;
                        $el = $leaveBalances['EL'] ?? 0;
                        $sl = $leaveBalances['SL'] ?? 0; 
                        $leaveData = calculatedLeaves($late, $sl, $cl, $el);
                        $resultArray = array_filter($leaveData, fn($value) => $value !== 0);
                        $insertData = collect($resultArray)->map(fn($value, $key) => [
                            'latededuction_no_pk'     => $sequence->nextValue('latededuction_no_pk'),
                            'person_no_fk'            => $person_no_fk[$id] ?? "",
                            'no_of_days'              => $value, 
                            'leave_code'              => $key, 
                            'deduction_type'          => ($key == 'ABSENT') ?  $key : 'LEAVE', 
                            'deduction_month'         => $year_month,
                            'deduction_date'          => $au_entry_at,
                            'status'                  => 1,
                            'au_entry_hospital_pk_no' => $ses_hospital_id,
                            'au_entry_at'             => $au_entry_at,
                            'au_entry_by'             => $auth_id,
                            'au_entry_session'        => "late deduction",   
                        ])->toArray();
                        // Bulk insert into the database
                        DB::table('hrms_emplatededuction')->insert($insertData);
                        DB::commit();
                        $message = ['msg' => 'Data Saved Successfully !!', 'title' => 'Success'];
                    }else{
                        $message = ['msg' => 'Please select any employee !!', 'title' => 'Error']; 
                    }  
                }  
            }else{
                $message = ['msg' => 'Please select any employee', 'title' => 'Error']; 
            }
            return response()->json($message);
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
    }

    public function showEmployeeAttendenceforHOD(Request $request)
    {
        $user_info = Auth::user();

        $data = DB::select("select t1.person_no_pk,t1.full_name, t1.contact_number, t1.duty_roster_type, t1.serviceunit_name,t1.designation_name,t1.card_no, ma.att_date, ma.in_time, ma.out_time
        from(select distinct a.person_no_pk, a.full_name, b.contact_number, b.duty_roster_type, c.serviceunit_name, d.designation_name, b.card_no
        from hrms_personal_leave_vw a
        left Join  hrms_personnel b on a.person_no_pk=b.person_no_pk
        left Join sysc_serviceunit c on b.serviceunit_no_fk=c.serviceunit_no_pk
        left Join hrms_designation d on b.jobtitle_lookup_no_fk=d.designation_no_pk
        where b.person_no_pk = $user_info->person_no_fk
        or b.person_no_pk in (select person_no_pk from hrms_personnel where emp_supvisor1_person_no_fk = $user_info->person_no_fk or emp_supvisor2_person_no_fk = $user_info->person_no_fk)) t1
        left join hrms_macattendence_vw ma on t1.CARD_NO = ma.card_no
        WHERE trunc(ma.att_date) between to_date(to_char(sysdate-1,'dd/mm/yyyy'),'dd/mm/yyyy') and to_date(to_char(sysdate,'dd/mm/yyyy'),'dd/mm/yyyy')");
        return Template::loadView("admin.v1.hrm.show-employee-attendance-for-hod", ['data' => $data]);
    }


    public function searchEmployeeAttendenceforHOD(Request $request)
    {
        $user_info = Auth::user();
        $from      = $request->search_date_from ? date('d-m-Y', strtotime($request->search_date_from)) : '';
        $to        = $request->search_date_to ? date('d-m-Y', strtotime($request->search_date_to)) : '';
     
        $card_no   = $request->card_hidn;
        $sql = "select t1.person_no_pk, t1.full_name, t1.contact_number, t1.duty_roster_type, t1.serviceunit_name,t1.designation_name, t1.card_no, ma.att_date, ma.in_time, ma.out_time
        from(select distinct a.person_no_pk, a.full_name, b.contact_number, b.duty_roster_type, c.serviceunit_name, d.designation_name, b.card_no
        from hrms_personal_leave_vw a
        left Join hrms_personnel b on a.person_no_pk = b.person_no_pk
        left Join sysc_serviceunit c on b.serviceunit_no_fk = c.serviceunit_no_pk
        left Join hrms_designation d on b.jobtitle_lookup_no_fk = d.designation_no_pk
        where b.person_no_pk = $user_info->person_no_fk
        or b.person_no_pk in (select person_no_pk FROM hrms_personnel where emp_supvisor1_person_no_fk = $user_info->person_no_fk or emp_supvisor2_person_no_fk = $user_info->person_no_fk or emp_hod1_person_no_fk = $user_info->person_no_fk or emp_hod2_person_no_fk = $user_info->person_no_fk)) t1
        left join hrms_macattendence_vw ma on t1.card_no = ma.card_no";

        if (!empty($from) && !empty($to)) {
            $sql .= " WHERE trunc(ma.att_date) BETWEEN to_date('$from', 'dd-mm-yyyy') AND to_date('$to', 'dd-mm-yyyy')";
        }

        if (!empty($card_no)) {
            // if (!empty($from) && !empty($to)) {
                $sql .= " and t1.person_no_pk = '$card_no'";
            // } else {
            //     $sql .= " where trunc(ma.att_date) between to_date(to_char(sysdate-1,'dd/mm/yyyy'),'dd/mm/yyyy') and to_date(to_char(sysdate,'dd/mm/yyyy'),'dd/mm/yyyy') and t1.person_no_pk = '$card_no'";
            // }
        }
        $data = DB::select($sql);

        return Template::loadView("admin.v1.hrm.show-employee-attendance-for-hod-search", ['data' => $data]);
    }

    public function showEmployeeAttendenceforHR(Request $request)
    {
        $departments = DB::select("select distinct unit.serviceunit_no_pk,serviceunit_name
                        from sysc_serviceunit unit,hrms_personnel per
                        where unit.serviceunit_no_pk=per.serviceunit_no_fk
                        order by 2");
        $user_info   = Auth::user();

        $data = DB::select("select t1.person_no_pk,t1.full_name, t1.contact_number, t1.duty_roster_type, t1.serviceunit_name,t1.designation_name,t1.card_no, ma.att_date, ma.in_time, ma.out_time
        from(select distinct b.person_no_pk, b.full_name, b.contact_number, b.duty_roster_type, c.serviceunit_name, d.designation_name, b.card_no
        from hrms_personnel b left join sysc_serviceunit c on b.serviceunit_no_fk=c.serviceunit_no_pk
        left join hrms_designation d on b.jobtitle_lookup_no_fk=d.designation_no_pk where b.employee_ind =1) t1
        left join (select card_no,att_date,in_time,out_time from hrms_macattendence_vw  where trunc(att_date) between to_date(to_char(sysdate-1,'dd/mm/yyyy'),'dd/mm/yyyy') and to_date(to_char(sysdate,'dd/mm/yyyy'),'dd/mm/yyyy')) ma
        on t1.card_no = ma.card_no");
        return Template::loadView("admin.v1.hrm.show-employee-attendance-for-hr", ['data' => $data, 'departments' => $departments]);
    }


    public function searchEmployeeAttendenceforHR(Request $request)
    {
        $user_info  = Auth::user();
        $from       = $request->search_date_from ? date('d-m-Y', strtotime($request->search_date_from)) : '';
        $to         = $request->search_date_to ? date('d-m-Y', strtotime($request->search_date_to)) : '';
        $department = $request->dept;
        $card_no    = $request->card_no;

        $sql3 = "";
        if (!empty($from) && !empty($to)) {
            $sql3 = " where trunc(att_date) between to_date('$from','dd/mm/yyyy') and to_date('$to','dd/mm/yyyy')";
        } else {
            $toDate = date('d/m/Y');
            $sql3 = " where trunc(att_date) between to_date('$toDate','dd/mm/yyyy') and to_date('$toDate','dd/mm/yyyy')";
        }

        $sql2 = "select card_no,att_date,in_time,out_time from hrms_macattendence_vw" . $sql3;

        $sql = "select t1.person_no_pk,t1.full_name, t1.contact_number, t1.duty_roster_type, t1.serviceunit_name,t1.serviceunit_no_pk,t1.designation_name,t1.card_no, ma.att_date, ma.in_time, ma.out_time
        from(select distinct b.person_no_pk, b.full_name, b.contact_number, b.duty_roster_type, c.serviceunit_name, d.designation_name, b.card_no,c.serviceunit_no_pk from hrms_personnel b
        left join sysc_serviceunit c on b.serviceunit_no_fk=c.serviceunit_no_pk
        left join hrms_designation d on b.jobtitle_lookup_no_fk=d.designation_no_pk
        where b.employee_ind =1) t1 left join (" . $sql2 . ") ma on t1.card_no = ma.card_no where 1=1";
        if (!empty($department)) {
            $sql .= " and t1.serviceunit_no_pk = '$department'";
        }

        if (!empty($card_no)) {
            $sql .= " and t1.card_no = '$card_no'";
        }

        $data = DB::select($sql);
        return Template::loadView("admin.v1.hrm.show-employee-attendance-for-hr-search", ['data' => $data]);
    }

    public function ceckAttendanceDate(Request $request)
    {
        $check_date = date('m/d/Y', strtotime($request->manual_date));
        $user_info  = Auth::user();
        $data       = DB::select("select in_time, out_time from hrms_macattendence_vw where card_no = $user_info->user_code
                       and att_date = to_date('$check_date', 'mm/dd/yyyy')");
        return response()->json($data);
    }

    public function saveManualAttendanceV1(Request $request)
    {
        DB::beginTransaction();
        $sequence = DB::getSequence();
        try {
            $user_info       = Auth::user();
            $card_no         = $user_info->user_code;
            $entry_session   = Session()->get('user.ses_user_pk_no');
            $req_date        = date('Y-m-d');
            $attendance_date = $request->attendance_date != '' ? date('Y-m-d', strtotime($request->attendance_date)) : '';
            $in_time         = $request->in_time ? date('Y-m-d H:i', strtotime($request->attendance_date . ' ' . $request->in_time)) : '';
            $out_time        = $request->out_time ? date('Y-m-d H:i', strtotime($request->attendance_date . ' ' . $request->out_time)) : '';
           
            $check_data      = DB::select("SELECT in_time, out_time FROM hrms_macattendence_vw WHERE card_no = :card_no AND att_date = to_date(:attendance_date, 'YYYY-MM-DD')", [
                               'card_no' => $user_info->user_code,
                               'attendance_date' => $attendance_date ]);
            $check_date = DB::table('hrms_attendance_requsition')->select('requsition_no_pk')->where('person_card_no', $user_info->user_code)->where(DB::raw('trunc(attendance_date)'), '=', date('Y-m-d', strtotime($request->attendance_date)))->first();
            // if (!empty($check_data) && $check_data[0]->in_time != null) {
            //     $message = ['msg' => 'Attendance has already exists', 'title' => 'error'];
            //     return response()->json($message);
            // // }
            if (isset($check_date) && !isset($request->req_no_pk)) {
                $message = ['msg' => 'In that date manual attendance already exists, so you can edit before approved !!', 'title' => 'Error'];
                return response()->json($message);
            }else{
                $data = [
					'req_date'                => $req_date,
					'person_no_fk'            => $user_info->person_no_fk,
					'person_card_no'          => $card_no,
					'attendance_date'         => $attendance_date,
					'in_time'                 => $in_time,
					'out_time'                => $out_time,
					'remarks'                 => $request->remarks ? $request->remarks : '',
                    'manual_ind'              => 1,
					'au_entry_by'             => auth::user()->user_no_pk,
					'au_entry_at'             => date('Y-m-d'),
					'au_entry_session'        => $entry_session,
					'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
				];

                if (empty($request->req_no_pk)) {
                    $requsition_no_pk         = $sequence->nextValue('att_requsition_no_pk');
                    $data['requsition_no_pk'] = $requsition_no_pk;
                    DB::table("hrms_attendance_requsition")->insert($data);
                } else {
                    $requsition_no_pk = $request->req_no_pk;
                              $data['au_update_by']   = auth::user()->user_no_pk;
                              $data['au_update_at']   = date('Y-m-d');
                    $data['au_update_session']        = $entry_session;
                    $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                    DB::table("hrms_attendance_requsition")
                        ->where('requsition_no_pk', $request->req_no_pk)
                        ->update($data);
                }

                if (!empty($request->req_no_pk)) {
                    $check_pervious = DB::select("select count(*) num from SYSC_APPROVALPROCESS_VW where APPROVAL_FOR_CODE='ATTNREQ'
                                      and PRIMARY_KEY_VALUE=$request->req_no_pk");
                }
                if (!empty($check_pervious) && $check_pervious[0]->num > 1) {
                    DB::update(
                        "update SYSC_APPROVALPROCESS set REMARKS=:remarks where APPROVAL_FOR_CODE='ATTNREQ' and PRIMARY_KEY_VALUE= :req_no_pk",
                        ['remarks' => $request->remarks . '.' .  ' Attendance Date:' . $attendance_date . ' In time:' . $in_time . ' Out time:' . $out_time, 'req_no_pk' => $request->req_no_pk]
                    );
                } else {
                    $ses_hospital_id       = Session::get('user.ses_hospital_no_pk');
                    $au_entry_by           = auth::user()->user_no_pk;
                    $au_entry_session      = Session()->get('user.ses_user_pk_no');
                    $code                  = 'ATTNREQ';
                    $pdo                   = DB::getPdo();
                    $rem                   = $request->remarks . '.' . ' Attendance Date:' . $attendance_date . ' In time:' . $in_time . ' Out time:' . $out_time;
                    $out_apprprocess_no_pk = $out_apprprocess_uid = $out_error = '';
                    $in_primary_key_uid    = $requsition_no_pk;
                    $leave_appllication    = $pdo->prepare("begin pkg_v1_approvalprocess.prc_setapproval(
                                            :in_approval_for_code,
                                            :in_primary_key_value,
                                            :in_primary_key_uid,
                                            :in_remarks,
                                            :in_au_entry_by,
                                            :in_au_entry_session,
                                            :in_au_entry_hospital_pk_no,
                                            :out_apprprocess_no_pk,
                                            :out_apprprocess_uid,
                                            :out_error); end;");

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
            }
        } catch (\Exception $th) {
            DB::rollback();
            $message = ['msg' => $th->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function attenRequestReportforApproval($id = ""){
        $hospital_pk_no         = session()->get('user.ses_hospital_no_pk');
        $attendance_report_data = DB::table('sysc_approvalprocess_vw a')
                                ->leftJoin('wsec_user', 'a.au_entry_by', 'wsec_user.user_no_pk')
                                ->select("a.approval_for_code", "a.apprprocess_no_pk", "a.level_status_text", "a.remarks", "wsec_user.user_fullname")
                                ->where("a.au_entry_hospital_pk_no", $hospital_pk_no)
                                ->where("a.apprprocess_no_pk", $id)
                                ->first();

        $po_hospital_details    = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.reports.hrm.attendance_request_report_for_approval", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'attendance_report_data' => $attendance_report_data])->setPaper('a4', 'potrait');
		return $pdf->stream('Leave Report.pdf');
    }

    public function approvalLevelTrackingAttendanceRequ($id = ""){
        $approval_matrix_id = $id;
        $loginUser          = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no     = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo    = DB::table('sysc_approvalprocess_vw')
                                ->select("status_text")
                                ->where("primary_key_value", $approval_matrix_id)
                                ->where("approval_for_code", "ATTNREQ")
                                ->where("au_entry_hospital_pk_no", $hospital_pk_no)
                                ->first();
        return Template::loadView("admin.v1.hrm.employee_portal.approval-tracking-attendance-requsition", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }

    public function editManualAttendanceV1($requsition_no_pk = ""){
			$param            = explode("*", $requsition_no_pk);
			$attendance_date  = $param[0];
			$in               = $param[1];
			$out              = $param[2];
			$requsition_no_pk = $param[3];

			$previous         =  DB::table('hrms_attendance_requsition')
                                ->select('hrms_attendance_requsition.*')
                                ->where('hrms_attendance_requsition.requsition_no_pk', $requsition_no_pk)
                                ->first();
			return Template::loadView('admin.v1.hrm.employee_portal.edit-manual-attendancev1', 
            [
                'attendance_date'  =>$attendance_date, 
                'in'               =>$in, 
                'out'              =>$out, 
                'requsition_no_pk' =>$requsition_no_pk, 
                'previous'         =>$previous
            ]);

    }


    public function searchManualAttendancev1(Request $request){
        $user_info = Auth::user();
        $card_no   = $user_info->user_code;

        if ($request->search_date_from && $request->search_date_to) {
            $manual_attendance_data = DB::table('hrms_attendance_requsition a')
                                    ->select('a.requsition_no_pk', 'a.req_date', 'a.person_card_no', 'a.attendance_date', 
                                    'a.in_time', 'a.out_time', 'a.remarks', 'a.manual_ind', 'a.app_status')
                                    ->where('a.person_card_no', $card_no)
                                    ->where('a.manual_ind', 1)
                                    ->where(DB::raw('trunc(a.attendance_date)'), '>=', date('Y-m-d', strtotime($request->search_date_from)))
                                    ->where(DB::raw('trunc(a.attendance_date)'), '<=', date('Y-m-d', strtotime($request->search_date_to)))
                                    ->distinct('a.requsition_no_pk')
                                    ->get();
        }
        return Template::loadView('admin.v1.hrm.employee_portal.manual-attendance-search-tablev1', ['manual_attendance_data' => $manual_attendance_data]);
    }

}

