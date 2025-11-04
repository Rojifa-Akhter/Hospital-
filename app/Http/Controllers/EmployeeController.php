<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Designation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\LookupData;
use App\Traits\ItemData;
use App\Traits\DoctorData;
use App\Traits\DatatablesLoader;
use App\Models\Doctor;
use App\Models\ServiceUnit;
use App\Models\PatientRegistration;
use App\Http\Requests\DoctorRequest;
use App\Models\ChamberHospital;
use App\Repositories\BaseRepository as Repo;
// use App\Repositories\DoctorRepository;
use App\Models\Item;
use App\Models\DoctorFee;
use App\Models\MachineAttendance;
use DB;
use App\Http\Controllers\Storage;
use Auth;
use App\Traits\UtilitiesTrait;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use PDF;
use PDO;
use Session;
use QR;
use App\Datatables\DataTableClass;

class EmployeeController extends Controller
{
    use LookupData, DatatablesLoader, ItemData, DoctorData, UtilitiesTrait;
    protected $model;
    // protected $doctorRepository;
    protected $doctorfee;

    public function __construct(Doctor $doctor, DoctorFee $doctorfee, MachineAttendance $machineAttendance)
    {
        $this->middleware('auth');
        $this->doctor = new Repo($doctor);
        $this->doctorfee = new Repo($doctorfee);
        $this->model = new Repo($machineAttendance);
        // $this->doctorRepository = new DoctorRepository($doctor);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_type      = $this->getLookupListByCode("JOBTYPE");
        $job_title     = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')
                        ->orderBy('designation_name', 'asc')
                        ->get();
        $hr_type       = $this->getLookupListByCode("HRTYPE");
        $dept          = $this->getLookupListByCode("DEPT");
        $emp_type      = $this->getLookupListByCode("EMPTYPE");
        $service_unit  = ServiceUnit::where('status', '1')
                        ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                        ->get();
        $active        = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive      = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $employee_info = DB::select("SELECT photo_name, person_code,card_no, full_name, age,  gender_txt ,specialization, designation,su_name,phone_mobile, pe_addr1, email_personal, status,person_no_pk, rownum rownumber, au_update_at, au_entry_at FROM employee_info_vw where employee_ind = 1 order By person_no_pk desc FETCH NEXT 20 ROWS ONLY ");

        return Template::loadview("admin.hrm.employee.doctor_list", [
            "employee_info" => $employee_info,
            'service_unit'  => $service_unit,
            'job_type'      => $job_type,
            'job_title'     => $job_title,
            'hr_type'       => $hr_type,
            'emp_type'      => $emp_type,

        ]);
    }

    public function loadEmployeeListV1()
    {
         $job_type    = $this->getLookupListByCode("JOBTYPE");
         $job_title   = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')
                        ->orderBy('designation_name', 'asc')
                        ->get();
        $hr_type  = $this->getLookupListByCode("HRTYPE");
        $emp_type = $this->getLookupListByCode("EMPTYPE");

        $service_unit = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $departments   = ServiceUnit::where('status', '1')->where('hr_dept_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        // $service_unit = DB::select("select distinct unit.serviceunit_no_pk,serviceunit_name
        //                 from sysc_serviceunit unit,hrms_personnel per
        //                 where unit.serviceunit_no_pk=per.serviceunit_no_fk
        //                 order by 2");

        return Template::loadview("admin.v1.hrm.employee_setup.employee_list_v1", [
            'service_unit' => $service_unit,
            'departments' => $departments,
            'job_type'     => $job_type,
            'job_title'    => $job_title,
            'hr_type'      => $hr_type,
            'emp_type'     => $emp_type,
        ]);
    }

    public function employeeSearchV1(Request $request)
    {
        $search_param   = [];
        $hospital_id    = Session::get('user.ses_hospital_no_pk');
        $sql_cond       = "au_entry_hospital_pk_no = '$hospital_id'";
        $where          = "au_entry_hospital_pk_no = $hospital_id and employee_ind = 1 ";
        $emp_id         = $request->emp_id;
        $service_unit   = $request->service_unit;
        $department     =  $request->department;
        $hr_type        = $request->hr_type;
        $job_type       = $request->job_type;
        $roster_type    = $request->roster_type;
        $emp_ind        = $request->emp_ind;
        $doc_ind        = $request->doc_ind;
        $ref_ind        = $request->ref_ind;
        $status         = $request->status;

        $clause = ($where == "") ? "  " : " and ";
        $where .= ($emp_id != "") ? " $clause person_no_pk =$emp_id" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($department != "") ? " $clause serviceunit_no_fk_dept =$department" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($service_unit != "") ? " $clause serviceunit_no_fk =$service_unit" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($hr_type != "") ? " $clause hr_type_lookup_no_fk =$hr_type" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($job_type != "") ? " $clause job_type_lookup_no_fk =$job_type" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($roster_type != "") ? " $clause duty_roster_type ='$roster_type'" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($emp_ind != "") ? " $clause employee_ind =$emp_ind" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($doc_ind != "") ? " $clause doctor_ind =$doc_ind" : "";
        $clause = ($where == "") ? "  " : " and ";
        $where .= ($ref_ind != "") ? " $clause referal_ind =$ref_ind" : "";

        if ($status == 4 || $status == 5) {
            $clause = ($where == "") ? "  " : " and ";
            $where .= ($status != "") ? " $clause emp_status =$status" : "";
        } else {
            $clause = ($where == "") ? "  " : " and ";
            $where .= ($status != "") ? " $clause status =$status" : "";
        }

        $employee_info = DB::table('employee_info_vw')
                            ->select('photo_name', 'person_code', 'card_no', 'full_name', 'age', 'gender_txt',
                            'specialization', 'phone_mobile', 'pe_addr1', 'designation', 'su_name', 'serviceunit_no_fk_dept_name', 'email_personal',
                            'status', 'person_no_pk', 'au_update_at', 'au_entry_at')
                            ->whereRaw($where)
                            ->orderBy('card_no', 'asc')
                            ->get();

        return Template::loadview("admin.v1.hrm.employee_setup.employee_info_v1", [
            'employee_info' => $employee_info
        ]);
    }

    public function getUnitsByDepartment(Request $request)
    {
        $service_unit = DB::table("sysc_serviceunit")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->where('serviceunit_no_parent_fk', $request->department_id)->where('status', 1)->orderBy('serviceunit_name', 'asc')
        ->get();
        return response()->json($service_unit);
    }

    public function getReferral()
    {
        $service_unit   = ServiceUnit::where('status', '1')
                            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                            ->get();
        $specialization = $this->getLookupListByCode("DOCSPL");
        return Template::loadview("admin.hrm.referral.referral_list", ['service_unit' => $service_unit, 'specialization' => $specialization]);
    }
    public function empMachineAttendance()
    {
        return Template::loadview("admin.hrm.machineAttendance.machine_attendance");
    }
    public function empMachineData(Request $request)
    {
        $machineData = DB::table('employee_info_vw')
                        ->select('person_code', 'full_name', 'specialization', 'su_name', 'photo_name')
                        ->where('person_code', $request->personId)
                        ->first();
        return Template::loadview("admin.hrm.machineAttendance.get_machine_data", ['machineData' => $machineData]);
    }
    public function storeAttendance(Request $request)
    {
        $id      = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $to_date = date('Y-m-d');
            $time = date('H:i');
            $data = [
                'person_card_no'          => $request->user_id,
                'attendance_date'         => date("Y/m/d", strtotime($to_date)),
                'attandance_data'         => date(" h:i", strtotime($time)),
                'au_entry_by'             => $auth_id,
                'au_entry_hospital_pk_no' => 1,
                'au_entry_session'        => 'SESSION',
            ];

            $data['au_entry_by'] = $auth_id;
            $this->model->create($data);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function saveImage($id = "")
    {
        $employee_info = DB::table('hrms_personnel a')->select('a.person_code', 'a.photo_name', 'a.full_name',
                            'c.designation_name', 'su.serviceunit_name')
                            ->leftJoin('hrms_designation c', 'c.designation_no_pk', '=', 'a.jobtitle_lookup_no_fk')
                            ->leftJoin('sysc_serviceunit su', 'su.serviceunit_no_pk', '=', 'a.serviceunit_no_fk')
                            ->where('person_code', $id)
                            ->first();

        if ($employee_info != "") {
            $url = '';
            $filename = $id . '_' . date('YmdHis') . '.jpeg';
            if (move_uploaded_file($_FILES['webcam']['tmp_name'], public_path("images/uploads/attendance_images/$filename"))) {
                $url = public_path("images/uploads/attendance_images/$filename");

                $auth_id = Auth::id();
                DB::beginTransaction();

                $to_date = date('Y-m-d');
                $time    = date('H:i');
                $data = [
                    'person_card_no'          => (isset($employee_info->person_code)) ? $employee_info->person_code : '',
                    'attendance_date'         => date("Y/m/d", strtotime($to_date)),
                    'attandance_data'         => date("H:i", strtotime($time)),
                    'punch_time_photo'        =>  $filename,
                    'au_entry_by'             => $auth_id,
                    'au_entry_hospital_pk_no' => 1,
                    'au_entry_session'        => 'SESSION',
                ];

                $this->model->create($data);
                DB::commit();
                return    json_encode($employee_info); //['employee_info' => ];

            }
        } else {
            return [];
        }
    }

    public function saveMachineAtt(Request $request)
    {
        $employee_info = DB::table('hrms_personnel a')->select('a.person_code', 'a.photo_name', 'a.full_name',
                        'c.designation_name', 'su.serviceunit_name')
                        ->leftJoin('hrms_designation c', 'c.designation_no_pk', '=', 'a.jobtitle_lookup_no_fk')
                        ->leftJoin('sysc_serviceunit su', 'su.serviceunit_no_pk', '=', 'a.serviceunit_no_fk')
                        ->where('person_code', $request->service_number)
                        ->first();

        if ($employee_info != "") {
            $auth_id = Auth::id();
            DB::beginTransaction();

            $to_date = date('Y-m-d');
            $time    = date('H:i');
            $data = [
                'person_card_no'          => (isset($employee_info->person_code)) ? $employee_info->person_code : '',
                'attendance_date'         => date("Y/m/d", strtotime($to_date)),
                'attandance_data'         => date("H:i", strtotime($time)),
                'au_entry_by'             => $auth_id,
                'au_entry_hospital_pk_no' => 1,
                'au_entry_session'        => 'SESSION',
            ];

            $this->model->create($data);
            DB::commit();
            return  json_encode($employee_info);
        } else {
            return [];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $marital_status     = $this->getLookupListByCode("MARSTS");
        $gender             = $this->getLookupListByCode("GENDER");
        $religion           = $this->getLookupListByCode("RELIGION");
        $bloodg             = $this->getLookupListByCode("BLOODG");
        $specialization     = $this->getLookupListByCode("DOCSPL");
        $job_type           = $this->getLookupListByCode("JOBTYPE");
        $job_title          = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $hr_type            = $this->getLookupListByCode("HRTYPE");
        $dept               = $this->getLookupListByCode("DEPT");
        $emp_type           = $this->getLookupListByCode("EMPTYPE");
        // $service_unit       = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $service_unit   = ServiceUnit::where('status', '1')->where('hr_dept_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $units          = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $district           = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $relation           = $this->getLookupListByCode("RELATION");
        $degree             = $this->getLookupListByCode("DEGREE");
        $agent_banking      = $this->getLookupListByCode("AGENTBANKING");
        $gradePer           = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        $grade              = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $salary_factor      = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");
        $out_uid            =  $this->getAutoGenerateUID('HRMS_PERSONNEL', 'PERSON_CODE', '', '');
        $visit_type         = $this->getLookupListByCode("VISITTYPE");
        $name_prefix        = $this->getLookupListByCode("NAMEPREFIX");
        $leave_emp_category = $this->getLookupListByCode("LEAVECATEGORY");
        $benifit_tpye       = $this->getLookupListByCode("MEDICALBENEFITTYPE");

        // dd($benifit_tpye);

        return Template::loadview("admin.hrm.employee.add_new_doctor", [
            'marital_status'     => $marital_status,
            'gender'             => $gender,
            'religion'           => $religion,
            'bloodg'             => $bloodg,
            'specialization'     => $specialization,
            'service_unit'       => $service_unit,
            'units'              => $units,
            'job_type'           => $job_type,
            'job_title'          => $job_title,
            'hr_type'            => $hr_type,
            'dept'               => $dept,
            'emp_type'           => $emp_type,
            'district'           => $district,
            'relation'           => $relation,
            'grade'              => $grade,
            'degree'             => $degree,
            'agent_banking'      => $agent_banking,
            'gradePer'           => $gradePer,
            'salary_factor'      => $salary_factor,
            'visit_type'         => $visit_type,
            'page_type'          => 'add',
            'name_prefix'        => $name_prefix,
            'out_uid'            => $out_uid,
            'leave_emp_category' => $leave_emp_category,
            'benifit_tpye'       => $benifit_tpye,
        ]);
    }

    public function createReferral()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender         = $this->getLookupListByCode("GENDER");
        $religion       = $this->getLookupListByCode("RELIGION");
        $bloodg         = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type       = $this->getLookupListByCode("JOBTYPE");
        $job_title      = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $hr_type        = $this->getLookupListByCode("HRTYPE");
        $dept           = $this->getLookupListByCode("DEPT");
        $emp_type       = $this->getLookupListByCode("EMPTYPE");
        $service_unit   = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $district       = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $coverage_area  = DB::table('pcrm_marketing_area')->select('area_no_pk', 'area_code')->orderBy("area_code", "asc")->get();
        $relation       = $this->getLookupListByCode("RELATION");
        $degree         = $this->getLookupListByCode("DEGREE");
        $agent_banking  = $this->getLookupListByCode("AGENTBANKING");
        $gradePer       = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        $grade          = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $salary_factor  = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");
        $name_prefix    = $this->getLookupListByCode("NAMEPREFIX");
        return Template::loadview("admin.hrm.referral.create_referral", [
            'marital_status' => $marital_status,
            'gender'         => $gender,
            'religion'       => $religion,
            'bloodg'         => $bloodg,
            'specialization' => $specialization,
            'service_unit'   => $service_unit,
            'job_type'       => $job_type,
            'job_title'      => $job_title,
            'hr_type'        => $hr_type,
            'dept'           => $dept,
            'emp_type'       => $emp_type,
            'district'       => $district,
            'relation'       => $relation,
            'grade'          => $grade,
            'degree'         => $degree,
            'agent_banking'  => $agent_banking,
            'gradePer'       => $gradePer,
            'salary_factor'  => $salary_factor,
            'coverage_area'  => $coverage_area,
            'service_unit'   => $service_unit,
            'name_prefix'    => $name_prefix,
            'page_type'      => 'edit'
        ]);
    }
    public function createReferralPopup()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type = $this->getLookupListByCode("JOBTYPE");
        $job_title = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();


        $hr_type = $this->getLookupListByCode("HRTYPE");
        $dept = $this->getLookupListByCode("DEPT");
        $emp_type = $this->getLookupListByCode("EMPTYPE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        // $district = $this->getLookupListByCode("DISTRICT");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $coverage_area = DB::table('pcrm_marketing_area')->select('area_no_pk', 'area_code')->orderBy("area_code", "asc")->get();
        // $thana = DB::table('sysc_upazilas')->select('id','name')->orderBy("name","asc")->get();
        // $thana = $this->getLookupListByCode("THANA");
        $relation = $this->getLookupListByCode("RELATION");
        $degree = $this->getLookupListByCode("DEGREE");
        $agent_banking = $this->getLookupListByCode("AGENTBANKING");
        $gradePer = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        $grade = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        // return ['district' => $district];
        return Template::loadview("admin.hrm.referral.create_referral_form", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'religion' => $religion,
            'bloodg' => $bloodg,
            'specialization' => $specialization,
            'service_unit' => $service_unit,
            'job_type' => $job_type,
            'job_title' => $job_title,
            'hr_type' => $hr_type,
            'dept' => $dept,
            'emp_type' => $emp_type,
            'district' => $district,
            // 'thana' => $thana,
            'relation' => $relation,
            'grade' => $grade,
            'degree' => $degree,
            'agent_banking' => $agent_banking,
            'gradePer' => $gradePer,
            'salary_factor' => $salary_factor,
            'coverage_area' => $coverage_area,
            'service_unit' => $service_unit,
            'name_prefix' => $name_prefix,
            'page_type' => 'edit'
        ]);
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



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->doctor->show($id);

        $salaryInfo     = DB::table("hrms_personnel_salary")
                            ->where("person_no_fk", $id)
                            ->first();
        $user_into      = DB::table("wsec_user")->where("person_no_fk", $id)->first();
        $educationInfo  = DB::table("hrms_personnel_education")->where("person_no_fk", $id)->get();
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender         = $this->getLookupListByCode("GENDER");
        $religion       = $this->getLookupListByCode("RELIGION");
        $bloodg         = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type       = $this->getLookupListByCode("JOBTYPE");
        $emp_type       = $this->getLookupListByCode("EMPTYPE");
        $job_title      = Designation::where('status', '1')
                                ->select('designation_no_pk', 'designation_name')
                                ->orderBy('designation_name', 'asc')
                                ->get();
        $hr_type        = $this->getLookupListByCode("HRTYPE");
        $service_unit   = ServiceUnit::where('status', '1')
                                ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                                ->get();
        $grade          = Grade::where("status", "1")->select("grade_no_pk", "grade_name")
                                ->orderBy("grade_name", "asc")
                                ->get();
        $district       = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $thana_pre      = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')
                                ->where('district_id', $data->pr_addr_dist)->orderBy("name", "asc")
                                ->get();
        $thana_per      = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')
                                ->where('district_id', $data->pe_addr_dist)->orderBy("name", "asc")
                                ->get();
        $relation       = $this->getLookupListByCode("RELATION");
        $dept           = $this->getLookupListByCode("DEPT");
        $degree         = $this->getLookupListByCode("DEGREE");
        $agent_banking  = $this->getLookupListByCode("AGENTBANKING");
        $gradePer       = DB::table('hrms_grade')->select('grade_no_pk', 'grade_name')->get();
        $salary_factor  = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");

        $datafee        = DoctorFee::where('person_no_fk', $id)
                                ->select('hrms_doctorfee.doctorfee_no_pk', 'hrms_doctorfee.item_no_fk',
                                'hrms_doctorfee.visit_type_lookup_no_fk', 'sysc_serviceitem.item_name')
                                ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'hrms_doctorfee.item_no_fk')
                                ->get();
        $fee_arr = [];
        if (!empty($datafee)) {
            foreach ($datafee as $key => $value) {
                $fee_arr[$value->visit_type_lookup_no_fk]['doc_fee_id'] = $value->doctorfee_no_pk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_id']    = $value->item_no_fk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_name']  = $value->item_name;
            }
        }
        $visit_type  = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $chamberList = ChamberHospital::all();


        return Template::loadview("admin.hrm.doctor.create_doctor_form", [
            'marital_status' => $marital_status,
            'gender'         => $gender,
            'religion'       => $religion,
            'bloodg'         => $bloodg,
            'specialization' => $specialization,
            'service_unit'   => $service_unit,
            'job_type'       => $job_type,
            'job_title'      => $job_title,
            'emp_type'       => $emp_type,
            'hr_type'        => $hr_type,
            'data'           => $data,
            'district'       => $district,
            'thana_pre'      => $thana_pre,
            'thana_per'      => $thana_per,
            'relation'       => $relation,
            'salaryInfo'     => $salaryInfo,
            'educationInfo'  => $educationInfo,
            'page_type'      => 'edit',
            'grade'          => $grade,
            'dept'           => $dept,
            'degree'         => $degree,
            'salary_factor'  => $salary_factor,
            'gradePer'       => $gradePer,
            'agent_banking'  => $agent_banking,
            'visit_type'     => $visit_type,
            'fee_arr'        => $fee_arr,
            'user_into'      => $user_into,
            'name_prefix'    => $name_prefix,
            'chamberList'    => $chamberList

        ]);
    }

    public function editReferral($id)
    {

        $data  = $this->doctor->show($id);
        $refer = DB::table("employee_info_vw")
                    ->select("full_name", "ref_agent_person_no_fk")
                    ->where("person_no_pk", $data->ref_agent_person_no_fk)
                    ->first();

        $reference_name = DB::table("hrms_personnel a ")
                            ->join('hrms_personnel b', 'a.ref_agent_person_no_fk', 'b.person_no_pk')
                            ->select("b.full_name as reference_name", "a.ref_agent_person_no_fk")
                            ->where("a.ref_agent_person_no_fk", $data->ref_agent_person_no_fk)
                            ->first();
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender         = $this->getLookupListByCode("GENDER");
        $religion       = $this->getLookupListByCode("RELIGION");
        $relation       = $this->getLookupListByCode("RELATION");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $name_prefix    = $this->getLookupListByCode("NAMEPREFIX");
        $coverage_area  = DB::table('pcrm_marketing_area')
                            ->select('area_no_pk', 'area_code')
                            ->orderBy("area_code", "asc")
                            ->get();

        return Template::loadview("admin.hrm.referral.create_referral_form", [
            'marital_status' => $marital_status,
            'gender'         => $gender,
            'religion'       => $religion,
            'data'           => $data,
            'relation'       => $relation,
            'specialization' => $specialization,
            'coverage_area'  => $coverage_area,
            'name_prefix'    => $name_prefix,
            'refer'          => $refer,
            'reference_name' => $reference_name,
            'page_type'      => 'edit',

        ]);
    }



    public function getAllDoctor(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        // $where = "au_entry_hospital_pk_no = $hospital_id and doctor_ind = 1";
        if (Session::get('user.ses_hospital_code') != "DMHL") {
            $where = "au_entry_hospital_pk_no = $hospital_id and doctor_ind = 1";
        }else {
            $where = "au_entry_hospital_pk_no = $hospital_id and doctor_ind = 1 and internal_doctor_ind = 1";
        }

        $table = 'doctor_info_vw';
        $primaryKey = 'person_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'photo_name', 'dt' => 1),
            array('db' => 'person_code',  'dt' => 2),
            array('db' => 'card_no',   'dt' => 3),
            array('db' => 'full_name',   'dt' => 4),
            array('db' => 'age',   'dt' => 5),
            array('db' => 'gender_txt',   'dt' => 6),
            array('db' => 'specialization',   'dt' => 7),
            array('db' => 'designation',   'dt' => 8),
            array('db' => 'su_name',   'dt' => 9),
            array('db' => 'phone_mobile',   'dt' => 10),
            array('db' => 'pe_addr1',   'dt' => 11),
            array('db' => 'email_personal',   'dt' => 12),
            array('db' => 'status',   'dt' => 13),
            array('db' => 'person_no_pk',   'dt' => 14),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function getAllDoctorSearch(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $table             = 'doctor_info_vw';
        $primaryKey        = 'person_no_pk';
        $sql_cond          = "au_entry_hospital_pk_no = $hospital_id and doctor_ind = 1 ";
        $doc_id            = $request->doc_id;
        $su_id             = $request->su_id;
        $specialization    = $request->specialization_id;
        $doctor_type       = $request->doctor_type;

        if($doctor_type == 'internal') $doctor_type = 1;
        else if($doctor_type == 'external') $doctor_type = 0;
        else {}

        $doc_code = DB::table('doctor_info_vw')->select('person_code')->where('person_no_pk', $doc_id)->first();

        // $sql_cond = "where doctor_ind = 1 ";
        $clause = ($sql_cond == "") ? "  " : " and ";
        $sql_cond .= ($doc_id != "") ? " $clause person_code = '$doc_code->person_code'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($su_id != "") ? " $clause serviceunit_no_fk = '$su_id'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($specialization != "") ? " $clause specialization_lookup_no_fk = '$specialization'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_type != "") ? " $clause internal_doctor_ind = '$doctor_type'" : "";

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'photo_name', 'dt' => 1),
            array('db' => 'person_code',  'dt' => 2),
            array('db' => 'card_no',   'dt' => 3),
            array('db' => 'full_name',   'dt' => 4),
            array('db' => 'age',   'dt' => 5),
            array('db' => 'gender_txt',   'dt' => 6),
            array('db' => 'specialization',   'dt' => 7),
            array('db' => 'designation',   'dt' => 8),
            array('db' => 'su_name',   'dt' => 9),
            array('db' => 'phone_mobile',   'dt' => 10),
            array('db' => 'pe_addr1',   'dt' => 11),
            array('db' => 'email_personal',   'dt' => 12),
            array('db' => 'status',   'dt' => 13),
            array('db' => 'person_no_pk',   'dt' => 14),
        );
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

    }

    public function docPrint(Request $request)
    {
        $doc_id = $request->doc_id;
        $su_id = $request->service_unit;
        $specialization = $request->specialization_id;
        $doctor_type = $request->doctor_type;

        if($doctor_type == 'internal') $doctor_type = 1;
        else if($doctor_type == 'external') $doctor_type = 0;
        else {}

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $doc_code = DB::table('doctor_info_vw')->select('person_code')->where('person_no_pk', $doc_id)->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $sql_cond =  "where au_entry_hospital_pk_no = $ses_hospital_id";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doc_id != "") ? " $clause person_code = '$doc_code->person_code'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($su_id != "") ? " $clause serviceunit_no_fk = $su_id" : "";

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($specialization != "") ? " $clause specialization_lookup_no_fk = '$specialization'" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_type != "") ? " $clause internal_doctor_ind = '$doctor_type'" : "";

        $sql = DB::select("SELECT a.photo_name, a.person_code, a.full_name, a.age,  a.gender_txt ,a.specialization,a.designation,a.su_name, a.phone_mobile, a.pe_addr1, a.email_personal, a.person_no_pk ,a.status
        FROM doctor_info_vw a $sql_cond order By person_no_pk asc");

        $title = "123456";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $userInfo = Auth::user();

        if ($request->hdn_report_type == 'PDF') {
            // $pdf = App::make('dompdf.wrapper');
            // $pdf = PDF::loadView('admin.hrm.doctor.doctor_list_print', ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
            // return $pdf->stream("doctor_list", array("Attachment" => false));
            return view("admin.hrm.doctor.doctor_list_print_html", ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo]);
            // $pdf = PDF::loadView("admin.hrm.doctor.doctor_list_print", ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');

            // return $pdf->download('doctor_list.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            // dd('ok');
            $pdf = ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo];
            $fileToExport = "doctor_list";
            $html = View("admin.hrm.doctor.doctor_list_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function refPrint(Request $request)
    {
        $doc_id = $request->doc_id;
        $su_id = $request->service_unit;
        $specialization = $request->specialization_id;
        $doc_code = DB::table('Referral_Agent_vw')->select('person_code')->where('person_no_pk', $doc_id)->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $sql_cond = "";
        if ($request->ref_type != 4) {
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($doc_id != "") ? " $clause person_code = '$doc_code->person_code'" : "";
        } else {
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($doc_id != "") ? " $clause REF_AGENT_PERSON_NO_FK = '$doc_id'" : "";
        }

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($su_id != "") ? " $clause serviceunit_no_fk = $su_id" : "";


        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';


        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($specialization != "") ? " $clause specialization_lookup_no_fk = '$specialization'" : "";


        $sql = DB::select("SELECT a.photo_name, a.person_code, a.full_name, a.age,  a.gender_txt ,a.specialization,a.serviceunit_name, a.phone_mobile, a.pe_addr1, a.email_personal, a.person_no_pk ,a.status
        FROM Referral_Agent_vw a where REFERENCE_MPO_CODE is not null $sql_cond ");

        $title = "123456";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();




        if ($request->hdn_report_type == 'PDF') {
            $pdf = PDF::loadView("admin.hrm.referral.referral_list_print", ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
            return $pdf->stream('referral_list.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf = ['sql' => $sql, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "doctor_list";
            $html = View("admin.hrm.referral.referral_list_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }


    public function getAllReferral(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'photo_name',
            'reference_mpo_name',
            'person_code',
            'full_name',
            'age',
            'gender_txt',
            'specialization',
            'phone_mobile',
            'pr_addr1',
            'email_personal',
            'status',
            'person_no_pk'
        );

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        //
        $sql = "SELECT '' as sl,a.photo_name, CASE
        WHEN  a.ref_agent_person_no_fk !=0 THEN  a.reference_mpo_name || ' (' || a.reference_mpo_code || ')'
        ELSE  ''
         END as reference_mpo_name, a.person_code, a.full_name, a.age,  a.gender_txt ,a.specialization, a.phone_mobile, a.pr_addr1,
        a.email_personal, CASE WHEN a.status = 1 THEN '$active' ELSE '$inactive' END AS status,a.person_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at
        FROM Referral_Agent_vw a where a.REFERRAL_AGENT_IND = 1 and AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id and REFERENCE_MPO_CODE is not null  ";
        // dd($sql);where a.referal_ind = 3
        $order_by_column = "person_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }

    public function searchReferral(Request $request)
    {
        $ref_id = $request->ref_id;
        $su_id = $request->su_id;
        $specialization = $request->specialization_id;
        $ref_ind = $agent_type = $both_in  = $mpo_ind = '';
        if ($request->ref_type == 1) {
            $ref_ind = 1;
        } elseif ($request->ref_type == 2) {
            $agent_type = 2;
        } elseif ($request->ref_type == 3) {
            $both_in = 3;
        } elseif ($request->ref_type == 4) {
            $mpo_ind = 4;
        }



        // $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($ref_id != "") ? " $clause person_no_pk = '$ref_id'" : "";


        $doc_code = DB::table('hrms_personnel')->select('person_code')->where('person_no_pk', $ref_id)->first();
        // dd($doc_code);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $sql_cond = "";
        if ($mpo_ind == 4) {
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($ref_id != "") ? " $clause ref_agent_person_no_fk = '$ref_id'" : "";
        } else {
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($ref_id != "") ? " $clause person_code = '$doc_code->person_code'" : "";
        }

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($su_id != "") ? " $clause serviceunit_no_fk = $su_id" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($specialization != "") ? " $clause specialization_lookup_no_fk = '$specialization'" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($ref_ind != "") ? " $clause referal_ind = $ref_ind and referral_agent_ind != 2" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($agent_type != "") ? " $clause referral_agent_ind = $agent_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($both_in != "") ? " $clause  (referal_ind = 1 or referral_agent_ind = 2)" : "";
        if ($ref_id == '') {
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($mpo_ind != "") ? " $clause  (mpo_ind= 1)" : "";
        }

        $columns = array(
            'sl',
            'photo_name',
            'reference_mpo_name',
            'person_code',
            'full_name',
            'agent_institute_name',
            'gender_txt',
            'specialization',
            'phone_mobile',
            'pr_addr1',
            'email_personal',
            'status',
            'person_no_pk'
        );

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';


        $sql = "SELECT '' as sl,a.photo_name,  CASE
        WHEN  a.ref_agent_person_no_fk !=0 THEN  a.reference_mpo_name || ' (' || a.reference_mpo_code || ')'
        ELSE  ''
         END as reference_mpo_name, a.person_code, a.full_name,a.agent_institute_name,  a.gender_txt ,a.specialization, a.phone_mobile, a.pr_addr1, a.email_personal, CASE WHEN a.status = 1 THEN '$active' ELSE '$inactive' END AS status,a.person_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at  FROM Referral_Agent_vw a  $sql_cond order by person_code asc";
        //  dd($sql);
        // where a.referal_ind = 3

        $order_by_column = "person_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
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

    public function DoctorCard($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', $ses_hospital_id)->first();
        $data = Doctor::where('person_no_pk', '=', $id)
                        ->select('salutation', 'full_name', 'person_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'photo_name', 'person_no_pk')
                        ->leftJoin('sysc_lookupdata ld', 'hrms_personnel.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
                        ->leftJoin('sysc_lookupdata ld2', 'hrms_personnel.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')
                        ->where("hrms_personnel.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
                        ->first();
        return Template::loadview("admin.hrm.doctor.doctor_card", ['data' => $data, 'po_hospital_details' => $po_hospital_details]);
    }

    public function referralCard($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = Doctor::where('person_no_pk', '=', $id)
                        ->select('salutation', 'full_name', 'person_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'photo_name', 'person_no_pk')
                        ->leftJoin('sysc_lookupdata ld', 'hrms_personnel.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
                        ->leftJoin('sysc_lookupdata ld2', 'hrms_personnel.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')
                        ->first();
        return Template::loadview("admin.hrm.referral.referral_card", [
            'data' => $data,
            'po_hospital_details' => $po_hospital_details,
        ]);
    }
    public function referralCardPrint($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::table('hrms_personnel a')
                    ->select('a.doctor_signature_image', 'a.person_no_pk', 'a.salutation', 'a.card_no', 'ld3.designation', 'a.full_name', 'a.person_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'a.dob', 'a.photo_name', 'ld3.SPECIALIZATION', 'ld3.SU_NAME', 'ld3.JOIN_DATE')
                    ->leftJoin('sysc_lookupdata ld', 'a.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
                    ->leftJoin('sysc_lookupdata ld2', 'a.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')
                    ->leftJoin('EMPLOYEE_INFO_VW ld3', 'a.person_no_pk', '=', 'ld3.person_no_pk')
                    ->where('a.person_no_pk', '=', $id)
                    ->first();

        $title   = $data->person_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // return $data;
        // $pdf = PDF::loadView("admin.hrm.referral.referral_card_print", ['data' => $data, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
        // return $pdf->download('Employee_Id_Card.pdf');

        $director_signature_image = DB::table('hrms_personnel')->select('full_name', 'inv_auth_director_ind', 'doctor_signature_image')->where('inv_auth_director_ind', 1)->where('doctor_signature_image', '!=', null)->first();
        $ceo_sign=DB::table('employee_info_vw')->select('doctor_signature_image')->where('designation','CEO')->where('status',1)->first();
        // \Storage::download('http://192.168.1.13/kbmh/public/asset/backside_employee.pdf');
        if (Session::get('user.ses_hospital_code')=="DMHL") {
            $html = view('admin.hrm.referral.emp_card_print_v2', ['data' => $data, 'id' => $id, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'director_signature_image' => $director_signature_image,'ceo_sign'=>$ceo_sign])->render();
        }elseif(Session::get('user.ses_hospital_code') == 'AMCSH'){
            $html = view('admin.hrm.referral.referral_card_print_amcsh', ['data' => $data, 'id' => $id, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'director_signature_image' => $director_signature_image])->render();
        }else{
            $html = view('admin.hrm.referral.referral_card_print', ['data' => $data, 'id' => $id, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'director_signature_image' => $director_signature_image])->render();
        }


        // return @\PDF::loadHTML($html, 'utf-8')->stream();
        return $html;

        // return view('admin.employee.backside',['po_hospital_details'=>$po_hospital_details,'data' => $data])->render();
        // return Template::loadview("admin.hrm.referral.referral_card", ['data' => $data]);
    }
    public function empCardBackPrint()
    {

        // \Storage::download('http://192.168.1.13/kbmh/public/asset/backside_employee.pdf');

            $html = view('admin.hrm.referral.emp_card_back_print_v2')->render();



        // return @\PDF::loadHTML($html, 'utf-8')->stream();
        return $html;

        // return view('admin.employee.backside',['po_hospital_details'=>$po_hospital_details,'data' => $data])->render();
        // return Template::loadview("admin.hrm.referral.referral_card", ['data' => $data]);
    }


    public function employeeCardPrintUHL($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::table('hrms_personnel a')
                    ->select('a.doctor_signature_image', 'a.person_no_pk', 'a.salutation', 'a.card_no', 'ld3.designation',
                    'a.full_name', 'a.person_code','a.nid_no','a.pr_addr1', 'a.contact_number', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group',
                    'a.dob', 'a.photo_name', 'ld3.SPECIALIZATION', 'ld3.SU_NAME', 'ld3.JOIN_DATE')
                    ->leftJoin('sysc_lookupdata ld', 'a.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
                    ->leftJoin('sysc_lookupdata ld2', 'a.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')
                    ->leftJoin('EMPLOYEE_INFO_VW ld3', 'a.person_no_pk', '=', 'ld3.person_no_pk')
                    ->where('a.person_no_pk', '=', $id)
                    ->first();

        $title   = $data->person_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // dd($data);
        $director_signature_image = DB::table('hrms_personnel')->select('full_name', 'inv_auth_director_ind', 'doctor_signature_image')->where('inv_auth_director_ind', 1)->where('doctor_signature_image', '!=', null)->first();

        $html = view('admin.hrm.referral.referral_card_print_uhl', ['data' => $data, 'id' => $id, 'barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'director_signature_image' => $director_signature_image])->render();

        // return @\PDF::loadHTML($html, 'utf-8')->stream();
        return $html;

        // return view('admin.employee.backside',['po_hospital_details'=>$po_hospital_details,'data' => $data])->render();
        // return Template::loadview("admin.hrm.referral.referral_card", ['data' => $data]);
    }

    public function backside($id)
    {
        $data = DB::table('hrms_personnel a')
                    ->select('a.person_no_pk', 'a.salutation', 'ld3.designation', 'a.full_name', 'a.person_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'a.dob', 'a.photo_name', 'ld3.SPECIALIZATION', 'ld3.SU_NAME', 'ld3.JOIN_DATE')
                    ->leftJoin('sysc_lookupdata ld', 'a.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
                    ->leftJoin('sysc_lookupdata ld2', 'a.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')
                    ->leftJoin('EMPLOYEE_INFO_VW ld3', 'a.person_no_pk', '=', 'ld3.person_no_pk')
                    ->where('a.person_no_pk', '=', $id)
                    ->first();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        return view('admin.employee.backside', ['po_hospital_details' => $po_hospital_details, 'data' => $data])->render();
    }

    public function show($id)
    {
        $data = DB::table('hrms_personnel AS d')
                    ->select('d.person_no_pk', 'd.salutation', 'd.full_name', 'd.father_name', 'd.mother_name',
                     'd.spouse_name', 'gen.lookupdata_name AS gender', 'mar.lookupdata_name AS marital', 'd.dob',
                     'ser.serviceunit_name AS service_unit', 'd.join_date', 'jti.lookupdata_name AS job_title',
                     'jty.lookupdata_name AS job_type', 'hrt.lookupdata_name AS hr_type', 'empt.lookupdata_name AS emp_type',
                     'blo.lookupdata_name AS blood_group', 'rel.lookupdata_name AS religion', 'spe.lookupdata_name AS specialization',
                     'd.phone_home', 'd.phone_mobile', 'd.phone_office', 'd.nationality', 'd.pe_addr1', 'd.pe_addr_dist', 'd.pe_addr_country',
                     'd.pr_addr1', 'd.pr_addr_dist', 'd.pr_addr_country', 'd.emergency_contact_name', 'd.emergency_contact_addr',
                     'd.emergency_contact_relation', 'd.emergency_contact_contact', 'd.email_personal', 'd.passport_no', 'd.place_of_birth',
                     'd.card_no', 'd.emp_serial_in_salary_sheet')
                    ->leftJoin('sysc_lookupdata AS gen', 'gen.lookupdata_no_pk', '=', 'd.gender_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS mar', 'mar.lookupdata_no_pk', '=', 'd.marital_lookup_no_fk')
                    ->leftJoin('sysc_serviceunit AS ser', 'ser.serviceunit_no_pk', '=', 'd.serviceunit_no_fk')
                    ->leftJoin('sysc_lookupdata AS jti', 'jti.lookupdata_no_pk', '=', 'd.jobtitle_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS jty', 'jty.lookupdata_no_pk', '=', 'd.job_type_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS hrt', 'hrt.lookupdata_no_pk', '=', 'd.hr_type_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS empt', 'empt.lookupdata_no_pk', '=', 'd.emp_type_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS blo', 'blo.lookupdata_no_pk', '=', 'd.blood_group_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS rel', 'rel.lookupdata_no_pk', '=', 'd.religion_lookup_no_fk')
                    ->leftJoin('sysc_lookupdata AS spe', 'spe.lookupdata_no_pk', '=', 'd.specialization_lookup_no_fk')
                    ->where('d.person_no_pk', '=', $id)
                    ->first();

        // return $data;
        // $data = $this->doctor->show($id);
        return Template::loadview("admin.hrm.doctor.doctor_view", [
            'data' => $data
        ]);
    }

    public function referralShow($id)
    {
        $data = DB::table('hrms_personnel AS d')
            ->select('d.person_no_pk', 'd.salutation', 'd.full_name', 'd.father_name', 'd.mother_name', 'd.spouse_name', 'gen.lookupdata_name AS gender', 'mar.lookupdata_name AS marital', 'd.dob', 'ser.serviceunit_name AS service_unit', 'd.join_date', 'jti.lookupdata_name AS job_title', 'jty.lookupdata_name AS job_type', 'hrt.lookupdata_name AS hr_type', 'empt.lookupdata_name AS emp_type', 'blo.lookupdata_name AS blood_group', 'rel.lookupdata_name AS religion', 'spe.lookupdata_name AS specialization', 'd.phone_home', 'd.phone_mobile', 'd.phone_office', 'd.nationality', 'd.pe_addr1', 'd.pe_addr_dist', 'd.pe_addr_country', 'd.pr_addr1', 'd.pr_addr_dist', 'd.pr_addr_country', 'd.emergency_contact_name', 'd.emergency_contact_addr', 'd.emergency_contact_relation', 'd.emergency_contact_contact', 'd.email_personal', 'd.passport_no', 'd.place_of_birth', 'd.card_no', 'd.AGENT_INSTITUTE_NAME', 'd.AGENT_INSTITUTE_NAME', 'd.PE_ADDR1')
            ->leftJoin('sysc_lookupdata AS gen', 'gen.lookupdata_no_pk', '=', 'd.gender_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS mar', 'mar.lookupdata_no_pk', '=', 'd.marital_lookup_no_fk')
            ->leftJoin('sysc_serviceunit AS ser', 'ser.serviceunit_no_pk', '=', 'd.serviceunit_no_fk')
            ->leftJoin('sysc_lookupdata AS jti', 'jti.lookupdata_no_pk', '=', 'd.jobtitle_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS jty', 'jty.lookupdata_no_pk', '=', 'd.job_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS hrt', 'hrt.lookupdata_no_pk', '=', 'd.hr_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS empt', 'empt.lookupdata_no_pk', '=', 'd.emp_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS blo', 'blo.lookupdata_no_pk', '=', 'd.blood_group_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS rel', 'rel.lookupdata_no_pk', '=', 'd.religion_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS spe', 'spe.lookupdata_no_pk', '=', 'd.specialization_lookup_no_fk')
            ->where('d.person_no_pk', '=', $id)
            ->first();

        // return $data;
        // $data = $this->doctor->show($id);
        return Template::loadview("admin.hrm.referral.referral_view", [
            'data' => $data
        ]);
    }

    public function referralAgentShowCard($id)
    {

        $hospital_code = Session::get('user.ses_hospital_code');
        $data = DB::select("SELECT per.full_name mpo_name,
                agent.full_name agent_name,
                area.area_code,
                per.person_code,
                per.agent_institute_name,
                per.phone_mobile,
                per.person_no_pk,
                per.pr_addr1
        FROM hrms_personnel per
                inner JOIN hrms_personnel agent
                ON per.ref_agent_person_no_fk = agent.person_no_pk
                LEFT JOIN pcrm_marketing_area area
                ON area.area_no_pk = per.area_no_pk
        WHERE   per.person_no_pk = $id");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        return Template::loadview("admin.refferal.referral_id_card_popup", [
            'data' => $data, 'po_hospital_details' => $po_hospital_details, 'id' => $id
        ]);
    }


    public function referralAgentShow($id)
    {
        $hospital_code = Session::get('user.ses_hospital_code');
        $data = DB::select("SELECT per.full_name mpo_name,
                agent.full_name agent_name,
                area.area_code,
                per.person_code,
                per.agent_institute_name,
                per.phone_mobile,
                per.person_no_pk,
                per.pr_addr1
        FROM hrms_personnel per
                inner JOIN hrms_personnel agent
                ON per.ref_agent_person_no_fk = agent.person_no_pk
                LEFT JOIN pcrm_marketing_area area
                ON area.area_no_pk = per.area_no_pk
        WHERE   per.person_no_pk = $id");
        $company_details = DB::table('wsec_hospital')->where('status', 1)->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $title = $data[0]->agent_name != null ? strval($data[0]->agent_name) : '';
        $mobile = strval($data[0]->phone_mobile);
        $agent_name = $data[0]->agent_name != null ? strval($data[0]->agent_name) : '';
        $person_code = $data[0]->person_code != null ? strval($data[0]->person_code) : '';
        $mpo_name = $data[0]->mpo_name != null ? strval($data[0]->mpo_name) : '';
        $agent_institute_name = $data[0]->agent_institute_name != null ? strval($data[0]->agent_institute_name) : '';
        $area_code = $data[0]->area_code != null ? strval($data[0]->area_code) : '';

        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $qrcontent = QR::qrFactory()
            // ->email($email)
            //->url("https://moinshareidea.wordpress.com/")
            ->text('MPO Code: ', $person_code)
            ->text('MPO Name: ', $mpo_name)
            ->text('Agent Name: ', $agent_name)
            ->text('Pharmacy / Institude Name Name: ', $agent_institute_name)
            ->text('Area Name: ', $area_code)
            ->phone($mobile)
            ->QrCode(200);
        $pdf = PDF::loadView("admin.refferal.referral_id_card", ['data' => $data, 'barcode_no' => $barcode_no, 'qrcode' => $qrcontent, 'company_details' => $company_details]);
        return $pdf->stream('MPO_Membership.Pdf');
    }
    //referral patient list
    public function referralPatientList()
    {
        // $today_date = date("Y-m-d");
        $today_date = Carbon::now()->format('Y-m-d');
        $referral_patient_info = DB::table('api_registration_apps_wl_vw')->where("reg_source_app_web", "APP")
            ->whereRaw("trunc(reg_date)=TO_DATE('$today_date', 'YYYY-MM-DD')")->orderby("REG_DATE", "desc")->get();
        return Template::loadView("admin.hrm.referral.referral_patient_list", [
            'referral_patient_info' => $referral_patient_info,
        ]);
    }


    public function searchReferralPatientList(Request $request)
    {
        $referral_patient_info = DB::table('api_registration_apps_wl_vw')->where("reg_source_app_web", "APP");
        if (isset($request->date_from) && isset($request->date_to)) {
            $referral_patient_info->where(DB::raw('trunc(reg_date)'), '>=', date('Y-m-d', strtotime($request->date_from)));
            $referral_patient_info->where(DB::raw('trunc(reg_date)'), '<=', date('Y-m-d', strtotime($request->date_to)));
        }
        if (isset($request->hdn_patient_id)) {
            $referral_patient_info->where('patient_no_pk', $request->hdn_patient_id);
        }
        if (isset($request->mobile_no)) {
            $referral_patient_info->where('contact_official', $request->mobile_no);
        }
        if (!isset($request->date_from) && !isset($request->date_to) && !isset($request->hdn_patient_id) && !isset($request->mobile_no)) {
            $referral_patient_info = [];
        } else {
            $referral_patient_info = $referral_patient_info->orderby("reg_date", "desc")->get();
        }
        // dd($referral_patient_info);
        return Template::loadView("admin.hrm.referral.referral_patient_list_table", [
            'referral_patient_info' => $referral_patient_info
        ]);
    }
    //employee salary setup
    public function employeeSalary()
    {
        $hospital_id    = Session::get('user.ses_hospital_no_pk');
        $salarydata = db::table('employee_info_vw as em ')->select('em.person_no_pk','em.person_code','em.full_name','em.su_name','em.designation','s.gross_salary','s.basic_salary','s.medical_allow','s.ta_da','s.house_rent','s.utility_allow', 's.entertainment', 's.conveyance_allow', 's.festival_bonus', 's.salary_no_pk', 's.ca_sal', 's.sa_sal', 's.ica_sal', 's.ra_sal')
        ->leftjoin('hrms_personnel_salary as s', 's.person_no_fk', '=', 'em.person_no_pk')
        ->where('em.status', '=', 1)->where('em.employee_ind', '=', 1)->where('em.au_entry_hospital_pk_no', '=', $hospital_id)->orderby('em.au_entry_at', 'desc')->get();

        $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
        from sysc_serviceunit unit,hrms_personnel per
        where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
        order by 2');
        return Template::loadview("admin.hrm.salarySetup.employee_salary", [
            "salarydata" => $salarydata,
            "service_unit" => $service_unit
        ]);

    }

    public function SearchEmployeeSalary(Request $request){
        $service_unit = $request->service_unit;
        $card_no = $request->card_hidn;
        $salarydata = db::table('employee_info_vw as em ')->select('em.person_no_pk','em.person_code','em.full_name','em.su_name','em.designation','s.gross_salary','s.basic_salary','s.medical_allow','s.ta_da','s.house_rent','s.utility_allow', 's.entertainment', 's.conveyance_allow', 's.festival_bonus','s.salary_no_pk', 's.ca_sal', 's.sa_sal', 's.ica_sal', 's.ra_sal')
        ->leftjoin('hrms_personnel_salary as s', 's.person_no_fk', '=', 'em.person_no_pk');
        if(isset($card_no)){
            $salarydata->where('person_no_pk', $card_no);
        }
        if(isset($service_unit)){
            $salarydata->where('SERVICEUNIT_NO_FK', $service_unit);
        }
        $salarydata = $salarydata->where('em.status', '=', 1)->where('em.employee_ind', '=', 1)->where('em.au_entry_hospital_pk_no', '=', Session::get('user.ses_hospital_no_pk'))->orderBy('em.au_entry_at', 'desc')->get();

        $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
        from sysc_serviceunit unit,hrms_personnel per
        where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
        order by 2');
        return Template::loadview("admin.hrm.salarySetup.employee_salary_list", [
            "salarydata" => $salarydata,
            "service_unit" => $service_unit
        ]);
    }

    public function createEmployeeSalary($id = null)
    {
        $person_id = $id;
        $salarySetupData = DB::table("hrms_hospital_wise_salary_setup")->where('status', 1)->first();
        if(!empty($person_id)){
            $salaryInfo = DB::table('hrms_personnel_salary')->where('person_no_fk', $person_id)->first();
        }else{
            $salaryInfo = [];
        }
        $grade         = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");
        $employee_info = db::table('employee_info_vw ')->select('person_code', 'full_name', 'su_name', 'designation')->where('person_no_pk', $person_id)->first();
        return Template::loadview("admin.hrm.salarySetup.create_employee_salary",[
            'employee_info' => $employee_info,
            'salaryInfo' => $salaryInfo,
            "salarySetupData" => $salarySetupData,
            "grade" => $grade,
            "salary_factor" => $salary_factor,
            "person_id" => $person_id
        ]);
    }

    public function storeEmployeeSalary(Request $request)
    {
        $salary_id = $request->salary_id;
        $person_no_pk = $request->person_id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $salary_no_pk_seq = $sequence->nextValue('salary_no_pk_seq');
        try {
            $dataSalary = [
                'gross_salary' => $request->gross_salary,
                'basic_salary' => $request->basic_salary,
                'basic_salary_perc' => $request->basic_salary_per,
                'house_rent' => $request->house_rent,
                'house_rent_perc' => $request->house_rent_per,
                'medical_allow' => $request->medical_allowance,
                'medical_allow_perc' => $request->medical_allowance_per,
                'ta_da' => $request->ta_da,
                'ta_da_perc' => $request->ta_da_per,
                'conveyance_allow' => $request->conveyance_allowance,
                'conveyance_allow_perc' => $request->conveyance_allowance_per,
                'utility_allow' => $request->utility,
                'utility_allow_perc' => $request->utility_per,
                'festival_bonus' => $request->festival_bonus,
                'festival_bonus_perc' => $request->festival_bonus_per,
                'entertainment' => $request->entertainment,
                'entertainment_perc' => $request->entertainment_per,
                'ca_sal' => $request->critical,
                'ca_perc' => $request->critical_per,
                'sa_sal' => $request->special,
                'sa_perc' => $request->special_per,
                'ica_sal' => $request->incharge,
                'ica_prea' => $request->incharge_per,
                'ra_sal' => $request->risk,
                'ra_prec' => $request->risk_per,
                'salary_factor' => $request->salary_factor,
                'grade_no_fk' => ($request->salary_factor == 'GRADEBASED') ? $request->grade_factor : ''
            ];
            if ($salary_id == null) {
                $dataSalary['person_no_fk'] = $person_no_pk;
                $dataSalary['status'] = 1;
                $dataSalary['salary_no_pk'] = $salary_no_pk_seq;
                $dataSalary['au_entry_by'] = $auth_id;
                $dataSalary['au_entry_session'] = 'salary';
                $dataSalary['au_entry_at'] =  date('Y-m-d h:i:s');
                $dataSalary['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('hrms_personnel_salary')->insert($dataSalary);
                DB::table('hrms_personnel')
                ->where('person_no_pk', $person_no_pk)
                ->update(['salary_ind' => 1]);
            } else {
                $dataSalary['au_update_by'] = $auth_id;
                $dataSalary['au_update_at'] =  date('Y-m-d h:i:s');
                $dataSalary['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

                DB::table('hrms_personnel_salary')
                    ->where('salary_no_pk', $salary_id)
                    ->update($dataSalary);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function gradeFactor(Request $request)
    {
        $salaryInfo = DB::table('hrms_grade')->where('grade_no_pk', $request->grade_value)->first();
        return Template::loadview("admin.hrm.salarySetup.salary_info", ['salaryInfo' => $salaryInfo, 'gradeStatus' => '1']);
    }

      //employee tax deduction
      public function employeeTaxDeduction()
      {
          $hospital_id    = Session::get('user.ses_hospital_no_pk');
          $salarydata = db::table('employee_info_vw as em ')->select('em.person_no_pk','em.person_code','em.full_name','em.su_name','em.designation','s.gross_salary', 'tds.tds_amt', 'tds.tds_amt', 'tds.person_no_fk', 'tds.personneltds_no_pk')
          ->leftjoin('hrms_personnel_salary as s', 's.person_no_fk', '=', 'em.person_no_pk')
          ->leftjoin('hrms_personneltds as tds', 'tds.person_no_fk', '=', 'em.person_no_pk')
          ->where('em.status', '=', 1)->where('em.employee_ind', '=', 1)->where('em.au_entry_hospital_pk_no', '=', $hospital_id)->orderBy('person_code', 'asc')->get();

          $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
          from sysc_serviceunit unit,hrms_personnel per
          where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
          order by 2');
          return Template::loadview("admin.hrm.taxDeduction.tax_deduction", [
              "salarydata" => $salarydata,
              "service_unit" => $service_unit
          ]);

      }

      public function searchEmployeeTaxDeduction(Request $request){
          $service_unit = $request->service_unit;
          $card_no = $request->card_hidn;
          $hospital_id    = Session::get('user.ses_hospital_no_pk');
          $salarydata = db::table('employee_info_vw as em ')->select('em.person_no_pk','em.person_code','em.full_name','em.su_name','em.designation','s.gross_salary', 'tds.tds_amt', 'tds.tds_amt', 'tds.person_no_fk', 'tds.personneltds_no_pk')
          ->leftjoin('hrms_personnel_salary as s', 's.person_no_fk', '=', 'em.person_no_pk')
          ->leftjoin('hrms_personneltds as tds', 'tds.person_no_fk', '=', 'em.person_no_pk');
          if(isset($card_no)){
              $salarydata->where('person_no_pk', $card_no);
          }
          if(isset($service_unit)){
              $salarydata->where('serviceunit_no_fk', $service_unit);
          }
          $salarydata = $salarydata->where('em.status', '=', 1)->where('em.employee_ind', '=', 1)->where('em.au_entry_hospital_pk_no', '=', $hospital_id)->orderBy('person_code', 'asc')->get();

          $service_unit = DB::select('select distinct UNIT.SERVICEUNIT_NO_PK,SERVICEUNIT_NAME
          from sysc_serviceunit unit,hrms_personnel per
          where UNIT.SERVICEUNIT_NO_PK=PER.SERVICEUNIT_NO_FK
          order by 2');
          return Template::loadview("admin.hrm.taxDeduction.tax_deduction_list", [
              "salarydata" => $salarydata,
              "service_unit" => $service_unit
          ]);
      }

      public function taxDeductionUpdate(Request $request)
      {
          $ids = $request->ids;
          $personneltds_nos = $request->personneltds_nos;
          $tds = $request->tds;
          $auth_id = Auth::id();
          $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
          $sequence = DB::getSequence();
          $personneltds_no_pk_seq = $sequence->nextValue('personneltds_no_pk_seq');
          DB::beginTransaction();
          try {
              foreach ($ids as $key => $id) {
                  $data = [
                      'tds_amt' => $tds[$key] ? $tds[$key] : 0,
                      'status' => 1,
                  ];
                  if (empty($personneltds_nos[$key])) {
                      $data['personneltds_no_pk'] = $personneltds_no_pk_seq;
                      $data['person_no_fk'] = $id;
                      $data['tds_date'] = date('Y-m-d h:i:s');
                      $data['au_entry_by'] = $auth_id;
                      $data['au_entry_at'] = date('Y-m-d h:i:s');
                      $data['au_entry_hospital_no_fk'] = $ses_hospital_id;
                      $data['au_entry_session'] = 'TDS';
                      DB::table('hrms_personneltds')->insert($data);
                  }else{
                      $data['au_update_by'] = $auth_id;
                      $data['au_update_at'] = date('Y-m-d h:i:s');
                      DB::table('hrms_personneltds')->where('personneltds_no_pk', $personneltds_nos[$key])->where('person_no_fk', $id)->update($data);
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
      //pre employee report
      public function preEmployeeReport()
      {
        $preEmployeeData = DB::select("
        select
            invoice_no_pk,
            trunc(invoice_date) invoice_date,
            item_name,
            patient_no_fk,
            pat.patient_code,
            person_code,
            pers.person_no_pk,
            nvl(full_name,patient_name) full_name,
            remarks,
            preempcertificate_no_pk,
            cerificate_code,
            certificate_date,
            case
                when cer.EMP_STATUS=1 then 'Medically Fit'
                when cer.EMP_STATUS=2 then 'Unfit'
                when cer.EMP_STATUS=3 then 'Temporary Unfit'
                else null
            end EMP_STATUS
        from
            finc_invoicemst mst,
            patn_registration pat,
            hrms_personnel pers,
            finc_invoicedtl dtl,
            HRMS_PREEMPCERTIFICATE cer
        where
            BILL_TYPE='PKG'
            and MST.PATIENT_NO_FK = PAT.PATIENT_NO_PK
            and MST.INVOICE_NO_PK = DTL.INVOICE_NO_FK
            and dtl.item_no_fk in (26879439, 26879442)
            and MST.INVOICE_NO_PK = cer.INVOICE_NO_FK(+)
            and to_char(PAT.EMP_ID) = PERS.PERSON_CODE(+)
            and trunc(invoice_date) = trunc(sysdate) -- Filter for today's date
        order by
            invoice_no_pk,
            person_code
    ");
    $person_no_pk = Session::get('user.ses_person_no_fk');
    $doc_info = DB::table('hrms_personnel')->select('doctor_ind')->where('person_no_pk', $person_no_pk)->first();
    return Template::loadview("admin.hrm.pre_employee.pre_employee_report", ['preEmployeeData' => $preEmployeeData, 'doc_info' => $doc_info]);

    }
    public function searchPreEmployee(Request $request)
    {
        $person_no_pk = Session::get('user.ses_person_no_fk');
        $doc_info = DB::table('hrms_personnel')->select('doctor_ind')->where('person_no_pk', $person_no_pk)->first();
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));

        $from_date_cond = ($request->from_date != "" && $request->to_date != "")
        ? " and TRUNC(MST.invoice_date) between to_date('$from_date', 'DD-MM-YYYY') and to_date('$to_date', 'DD-MM-YYYY') "
        : "";
        $from_uhid_cond = ($request->uhid != "")
        ? " and  pat.patient_code = $request->uhid "
        : "";

        $preEmployeeData = DB::select("select invoice_no_pk,trunc(invoice_date) invoice_date,item_name,patient_no_fk, pat.patient_code, person_code, pers.person_no_pk,  nvl(full_name,patient_name) full_name, remarks, preempcertificate_no_pk, cerificate_code, certificate_date,
        case  when cer.EMP_STATUS=1 then 'Medically Fit' when  cer.EMP_STATUS=2 then 'Unfit' when  cer.EMP_STATUS=3 then 'Temporary Unfit' else null  end EMP_STATUS from finc_invoicemst mst , patn_registration pat, hrms_personnel pers,finc_invoicedtl dtl ,HRMS_PREEMPCERTIFICATE cer where BILL_TYPE='PKG'and MST.PATIENT_NO_FK=PAT.PATIENT_NO_PK and MST.INVOICE_NO_PK=DTL.INVOICE_NO_FK and dtl.item_no_fk in (26879439,26879442) and MST.INVOICE_NO_PK=cer.INVOICE_NO_FK(+) and to_char(PAT.EMP_ID)=PERS.PERSON_CODE(+) $from_date_cond $from_uhid_cond order by invoice_no_pk, person_code");

        return Template::loadview("admin.hrm.pre_employee.pre_employee_list", ['preEmployeeData' => $preEmployeeData, 'doc_info' => $doc_info]);
    }
    public function preEmployeeCertificate($id = "")
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $certificateData = DB::select("select invoice_no_pk,trunc(invoice_date) invoice_date,item_name,patient_no_fk, pat.patient_code, patient_name, person_code, pers.person_no_pk, full_name, cer.doctor_no_fk, remarks, preempcertificate_no_pk, cerificate_code, certificate_date,
        // case  when cer.EMP_STATUS=1 then 'Medically Fit' when  cer.EMP_STATUS=2 then 'Unfit' when  cer.EMP_STATUS=3 then 'Temporary Unfit' else null  end EMP_STATUS from finc_invoicemst mst , patn_registration pat, hrms_personnel pers,finc_invoicedtl dtl ,HRMS_PREEMPCERTIFICATE cer where BILL_TYPE='PKG'and MST.PATIENT_NO_FK=PAT.PATIENT_NO_PK and MST.INVOICE_NO_PK=DTL.INVOICE_NO_FK and dtl.item_no_fk in (26879439,26879442) and MST.INVOICE_NO_PK=cer.INVOICE_NO_FK(+) and to_char(PAT.EMP_ID)=PERS.PERSON_CODE and MST.INVOICE_NO_PK= $id order by invoice_no_pk, person_code");
        $certificateData = DB::select("
        SELECT
            invoice_no_pk,
            TRUNC(invoice_date) AS invoice_date,
            item_name,
            patient_no_fk,
            pat.patient_code,
            person_code,
            pers.person_no_pk,
            pers.gender_lookup_no_fk,
            nvl(full_name,patient_name) full_name,
            cer.doctor_no_fk,
            remarks,
            preempcertificate_no_pk,
            cerificate_code,
            certificate_date,
            cer.au_update_at,
            CASE
                WHEN cer.EMP_STATUS = 1 THEN 'Medically Fit'
                WHEN cer.EMP_STATUS = 2 THEN 'Unfit'
                WHEN cer.EMP_STATUS = 3 THEN 'Temporary Unfit'
                ELSE NULL
            END AS EMP_STATUS,
            pat_age(nvl(pers.dob,pat.dob), invoice_date) AS pat_age
        FROM
            finc_invoicemst mst
        JOIN
            patn_registration pat ON MST.PATIENT_NO_FK = PAT.PATIENT_NO_PK
        JOIN
            finc_invoicedtl dtl ON MST.INVOICE_NO_PK = DTL.INVOICE_NO_FK
        LEFT JOIN
            HRMS_PREEMPCERTIFICATE cer ON MST.INVOICE_NO_PK = cer.INVOICE_NO_FK
        LEFT JOIN
            hrms_personnel pers ON TO_CHAR(PAT.EMP_ID) = PERS.PERSON_CODE
        WHERE
            BILL_TYPE = 'PKG'
            AND dtl.item_no_fk IN (26879439, 26879442)
            AND MST.INVOICE_NO_PK = ?
        ORDER BY
        invoice_no_pk, person_code", [$id]);

        if(isset($certificateData[0]->doctor_no_fk)){
            $doctorData =  DB::table('hrms_personnel')->select('doctor_signature', 'doctor_signature_image')->where('person_no_pk', $certificateData[0]->doctor_no_fk)->first();
            $doctor_signature = $doctorData->doctor_signature;
            $doctor_signature_image = $doctorData->doctor_signature_image;
        }else{
            $doctor_signature = "";
        }

        return view("admin.hrm.pre_employee.pre_employee_certificate", [
            'certificateData' => $certificateData,
            'po_hospital_details' => $po_hospital_details,
            'doctor_signature' => $doctor_signature,
            'doctor_signature_image' => $doctor_signature_image,
        ]);
    }
    public function preEmployeeCertificateForm($id = "", $person_id = "", $patient_id = "")
    {
         $certificateData =  DB::table('finc_invoicemst mst')->select('cer.preempcertificate_no_pk', 'cer.cerificate_code', 'cer.certificate_date', 'cer.doctor_no_fk', 'cer.emp_status', 'cer.remarks', 'perr.full_name', 'per.person_no_pk')
        ->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.person_no_fk')
        ->leftJoin('hrms_preempcertificate cer', 'cer.invoice_no_fk', '=', 'mst.invoice_no_pk')
        ->leftJoin('hrms_personnel perr', 'perr.person_no_pk', '=', 'cer.doctor_no_fk')
        ->where('mst.invoice_no_pk', $id)->first();

        return Template::loadView("admin.hrm.pre_employee.pre_employee_certificate_form", [
            'invoice_no_fk' => $id,
            'person_id' => $person_id,
            'patient_id' => $patient_id,
            'certificateData' => $certificateData,
            'certificate_id' => isset($certificateData) ? $certificateData->preempcertificate_no_pk : "",
        ]);
    }
    public function storePreEmployeeCertificate(Request $request){

        $auth_id = Auth::id();
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $preempcertificate_no_pk_seq = $sequence->nextValue('preempcertificate_no_pk_seq');

        try {
            $data= [
                'doctor_no_fk' => $request->doc_id,
                'emp_status' => $request->checkup_result,
                'certificate_date' => date('Y-m-d h:i:s'),
                'person_no_fk' => $request->person_id,
                'remarks' => $request->remarks,
                'invoice_no_fk' => $request->invoice_no_fk,
            ];

            if ($request->certificate_id == "") {
                $data['preempcertificate_no_pk'] = $preempcertificate_no_pk_seq;
                $data['cerificate_code'] = "C".$preempcertificate_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'certificate';
                $data['au_entry_at'] =  date('Y-m-d h:i:s');
                $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('hrms_preempcertificate')->insert($data);

            } else {
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] =  date('Y-m-d h:i:s');
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('hrms_preempcertificate')
                    ->where('preempcertificate_no_pk', $request->certificate_id)
                    ->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    //excel data upload for salary
    public function salaryExcelDataUpload()
    {
        $recruit_type = $this->getLookupListByCode("POLICERECUIRTMENTTYPE");
        return Template::loadView('admin.hrm.salary_data_upload.salary_excel_data_upload', [
            'recruit_type' => $recruit_type
        ]);
    }

    public function salaryInfoSave(Request $request)
    {
        $excelData = $request->input('excelData');
        if (!$excelData || !is_array($excelData)) {
            $message = ['msg' => 'Invalid data !!', 'title' => 'Error'];
            return response()->json($message);
        }
        $salary_yyyymm = $request->year . $request->month;
        foreach ($excelData as $row) {
            $person = DB::table('hrms_personnel')->select('person_no_pk')->where('person_code', $row['card_no'])->first();

            if(isset($person->person_no_pk)){
                $checkAddDed = DB::table('hrms_addition_deduction_monthly')->where('person_no_fk', $person->person_no_pk)->where('salary_yyyymm', $salary_yyyymm)->first();
                if(!isset($checkAddDed)){
                    $person_no_pk = $person->person_no_pk;
                    $auth_id = Auth::id();
                    $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
                    $sequence = DB::getSequence();
                    $addndeduct_no_pk_seq = $sequence->nextValue('addndeduct_no_pk_seq');
                    DB::beginTransaction();
                    try {
                            if (isset($row['add_revision'])) {
                                $data['add_revision'] = $row['add_revision'];
                            }
                            if (isset($row['add_arrear'])) {
                                $data['add_arrear'] = $row['add_arrear'];
                            }
                            if (isset($row['ded_food_bill'])) {
                                $data['ded_food_bill'] = $row['ded_food_bill'];
                            }
                            if (isset($row['ded_pf'])) {
                                $data['ded_pf'] = $row['ded_pf'];
                            }
                            if (isset($row['ded_adv'])) {
                                $data['ded_adv'] = $row['ded_adv'];
                            }
                            if (isset($row['ded_med_bill'])) {
                                $data['ded_med_bill'] = $row['ded_med_bill'];
                            }
                            if (isset($row['ded_salary'])) {
                                $data['ded_salary'] = $row['ded_salary'];
                            }
                            if (isset($row['ded_lwp'])) {
                                $data['ded_lwp'] = $row['ded_lwp'];
                            }
                            if (isset($row['ded_emb'])) {
                                $data['ded_emb'] = $row['ded_emb'];
                            }
                            if (isset($row['ded_others'])) {
                                $data['ded_others'] = $row['ded_others'];
                            }
                            $data['addndeduct_no_pk'] = $addndeduct_no_pk_seq;
                            $data['au_entry_by'] = $auth_id;
                            $data['au_entry_at'] = date('Y-m-d h:i:s');
                            $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                            $data['au_entry_session'] = 'Salary';
                            $data['person_no_fk'] = $person_no_pk;
                            $data['salary_yyyymm'] = $salary_yyyymm;
                            DB::table('hrms_addition_deduction_monthly')->insert($data);
                            DB::commit();
                    } catch (\Exception $e) {
                        DB::rollback();
                        $message = ['msg' => 'Invalid Data !!', 'title' => 'Error'];
                    }
                }
            }
        }
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
    }
    // HOD Assign AL/OT
    public function hodAssignAlOt()
    {
        return Template::loadView("admin.hrm.assign_al_ot.hod_assign_al_ot", [
            "hodAssigndata" => []
        ]);
    }
    public function searchHodAssignAlOt(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $loginUser = Session::get('user.ses_person_no_fk');
        $person_no = $request->card_hidn;
        $hodAssigndata = DB::table('hrms_personnel')
            ->select('person_no_pk','full_name', 'person_code', 'duty_roster_type')
            ->where('status', 1)
            ->where('employee_ind', 1)
            ->where('person_no_pk', $person_no)
            ->where(function ($query) use ($loginUser) {
                $query->where('EMP_HOD1_PERSON_NO_FK', $loginUser)
                    ->orWhere('EMP_HOD2_PERSON_NO_FK', $loginUser)
                    ->orWhere('EMP_SUPVISOR1_PERSON_NO_FK', $loginUser)
                    ->orWhere('EMP_SUPVISOR2_PERSON_NO_FK', $loginUser);
            })
            ->first();
        $persondata = db::table('employee_info_vw')->select('person_code', 'full_name', 'su_name', 'serviceunit_no_fk_dept_name', 'duty_roster_type')->where('person_no_pk', $person_no)->first();
        // Get holiday dates
        $holidays = DB::table('hrms_holiday')->select('holiday_date')
            ->whereYear('holiday_date', Carbon::create($year, $month)->year)
            ->whereMonth('holiday_date', Carbon::create($year, $month)->month)
            ->get()
            ->pluck('holiday_date')
            ->map(fn($date) => Carbon::parse($date)->format('d-m-Y'))
            ->toArray();
        $dayOffData = [];
        $fridays = [];
        // dd($hodAssigndata);
        if (isset($hodAssigndata) && $hodAssigndata->duty_roster_type == 'ROSTER') {
            // Get day off (roster) dates
            $dayOffData = DB::table('HRMS_ROSTER')->select('roster_date')
                ->whereYear('roster_date', Carbon::create($year, $month)->year)
                ->whereMonth('roster_date', Carbon::create($year, $month)->month)
                ->where('dayoff_ind', 1)
                ->where('person_no_fk', $person_no)
                ->get()
                ->pluck('roster_date')
                ->map(fn($date) => Carbon::parse($date)->format('d-m-Y'))
                ->toArray();
            $combinedDates = array_unique(array_merge($holidays, $dayOffData));
        } elseif (isset($hodAssigndata) && $hodAssigndata->duty_roster_type == 'General') {
            $fridays = getFridaysOfMonthOfYear($year, $month);
            $combinedDates = array_unique(array_merge($holidays, $fridays));
        } else {
            $combinedDates = [];
        }
        sort($combinedDates);
        // dd($holidays, $dayOffData, $fridays, $combinedDates);
        // Format final array
        $formattedDates = [];
        foreach ($combinedDates as $date) {
            $isHoliday = in_array($date, $holidays);
            $isDayOff = in_array($date, $dayOffData);
            $isFriday = in_array($date, $fridays);

            if ($isHoliday && $isDayOff) {
                $label = 'holiday/dayoff';
            } elseif ($isHoliday) {
                $label = 'holiday';
            } elseif ($isDayOff) {
                $label = 'dayoff';
            } elseif ($isHoliday && $isFriday) {
                $label = 'holiday/dayoff';
            } elseif ($isFriday) {
                $label = 'dayoff';
            } else {
                $label = '';
            }

            $formattedDates[$date] = "$date ($label)";
        }
        return Template::loadView("admin.hrm.assign_al_ot.hod_assign_container", [
            "hodAssigndata" => $hodAssigndata,
            "dayOffHlidayData" => $formattedDates,
            "persondata" => $persondata,
        ]);
    }

    public function storeHodAssignAlOt(Request $request){
        $auth_id = Auth::id();
        $sequence = DB::getSequence();
        $duty_assign_no_pk_seq = $sequence->nextValue('duty_assign_no_pk_seq');
        DB::beginTransaction();
        try {
            $data= [
                'duty_assign_no_pk' => $duty_assign_no_pk_seq,
                'assign_date' => isset($request->dayoff_holiday) ? date('Y-m-d', strtotime($request->dayoff_holiday)) : '',
                'assign_by_person_no_fk' => Session::get('user.ses_person_no_fk'),
                'assign_to_person_no_fk' => $request->person_no_pk,
                'leave_type' => $request->person_no_pk,
                'al_ind' => $request->assign_type == 'al' ? 1 : '',
                'ot_ind' => $request->assign_type == 'ot' ? 1 : '',
                'ot_start_time' => '',
                'ot_end_time' => '',
                'status' => 1,
            ];

            $data['au_entry_by'] = $auth_id;
            $data['au_entry_session'] = 'assign';
            $data['au_entry_at'] =  date('Y-m-d h:i:s');
            $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('hrms_duty_assign_byhod')->insert($data);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];

        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function hodAssignDutyWorklist()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $assignDutydata = DB::table('hrms_duty_assign_byhod as assign')
            ->select(
                'emp.full_name',
                'emp.person_code',
                'emp.serviceunit_no_fk_dept_name',
                'emp.su_name',
                'emp.duty_roster_type',
                'assign.assign_date',
                'assign.al_ind',
                'assign.ot_ind',
                'assign.leave_type',
                'assign.duty_assign_no_pk'
            )
            ->leftJoin('EMPLOYEE_INFO_VW as emp', 'assign.assign_to_person_no_fk', '=', 'emp.person_no_pk')
            ->whereYear('assign.assign_date', $currentYear)
            ->whereMonth('assign.assign_date', $currentMonth)
            ->where( 'assign.assign_by_person_no_fk', Session::get('user.ses_person_no_fk'))
            ->get();
        return Template::loadView("admin.hrm.assign_al_ot.hod_assign_duty_worklist", [
            "assignDutydata" => $assignDutydata
        ]);
    }

    public function searchHodAssignDuty(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $person_no = $request->card_hidn;
        $assignDutydata = DB::table('hrms_duty_assign_byhod as assign')
            ->select(
                'emp.full_name',
                'emp.person_code',
                'emp.serviceunit_no_fk_dept_name',
                'emp.su_name',
                'emp.duty_roster_type',
                'assign.assign_date',
                'assign.al_ind',
                'assign.ot_ind',
                'assign.leave_type',
                'assign.duty_assign_no_pk'
            )
            ->leftJoin('EMPLOYEE_INFO_VW as emp', 'assign.assign_to_person_no_fk', '=', 'emp.person_no_pk')
            ->whereYear('assign.assign_date', $year)
            ->whereMonth('assign.assign_date', $month)
            ->where('assign.assign_by_person_no_fk', Session::get('user.ses_person_no_fk'));
        if(isset($person_no)){
            $assignDutydata->where('assign.assign_to_person_no_fk', $person_no);
        }
        $assignDutydata = $assignDutydata->get();
        return Template::loadView("admin.hrm.assign_al_ot.hod_assign_duty_container", [
            "assignDutydata" => $assignDutydata
        ]);
    }

}
