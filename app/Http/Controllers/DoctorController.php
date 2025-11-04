<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Traits\LookupData;
use App\Traits\ItemData;
use App\Traits\DoctorData;
use App\Traits\DatatablesLoader;
use App\Models\Doctor;
use App\Models\ServiceUnit;
use App\Http\Requests\DoctorRequest;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\DoctorRepository;
use App\Models\Item;
use App\Models\Users;
use App\Models\DoctorFee;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;
use \PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Datatables\DataTableClass;
use App\Models\ChamberHospital;
use App\Traits\UtilitiesTrait;
use Carbon\Carbon;

class DoctorController extends Controller
{
    use LookupData, DatatablesLoader, ItemData, DoctorData, UtilitiesTrait;
    protected $model;
    protected $doctor;
    protected $doctorfee;
    protected $users;
    protected $doctorRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor, DoctorFee $doctorfee, Users $users)
    {
        $this->middleware('auth');
        $this->doctor           = new Repo($doctor);
        $this->doctorfee        = new Repo($doctorfee);
        $this->doctorRepository = new DoctorRepository($doctor);
        $this->users            = new Repo($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $specialization = $this->getLookupListByCode("DOCSPL");
        return Template::loadview("admin.hrm.doctor.doctor_list", ['service_unit' => $service_unit, 'specialization' => $specialization]);
    }


    public function employeeSearch(Request $request)
    {
        $search_param = [];
        $hospital_id    = Session::get('user.ses_hospital_no_pk');
        // $where          = "au_entry_hospital_pk_no = $hospital_id and employee_ind = 1 ";
        $where          = "au_entry_hospital_pk_no = $hospital_id ";
        $search_string  = $request->searchdata;
        $search_dta_arr = parse_str($search_string, $search_param);

        $emp_id       = $request->emp_id;
        $service_unit = $request->service_unit;
        $hr_type      = $request->hr_type;
        $job_type     = $request->job_type;
        $roster_type  = $request->roster_type;
        $emp_ind      = $request->emp_ind;
        $doc_ind      = $request->doc_ind;
        $ref_ind      = $request->ref_ind;
        $status      = $request->status;
        // dd($status);
        // dd($search_param);
        // $where = "";

        $clause = ($where == "") ? "  " : " and ";
        $where .= ($emp_id != "") ? " $clause person_no_pk =$emp_id" : "";
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



        // $active = '<span class="badge badge-md badge-success"> Active</span>';
        // $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        // $employee_info = DB::select("SELECT employee_ind,doctor_ind,referal_ind,photo_name, person_code, full_name, age,  gender_txt ,specialization,designation,su_name, phone_mobile, pe_addr1, email_personal, status,person_no_pk,job_type_lookup_no_fk,serviceunit_no_fk,hr_type_lookup_no_fk,duty_roster_type, rownum rownumber, au_update_at, au_entry_at FROM employee_info_vw where status=1 $emp_id_con  $service_unit_con  $hr_type_con $job_type_con $roster_type_con $emp_ind_con $doc_ind_con $ref_ind_con order By person_no_pk desc");


        // return Template::loadview("admin.hrm.employee.emp_info", [
        //     "employee_info" => $employee_info
        // ]);

        // echo json_encode($json_data);
        // $hospital_id = Session::get('user.ses_hospital_no_pk');
        // $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";

        $table = 'employee_info_vw';
        // Table's primary key
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
            array('db' => 'email_personal',   'dt' => 11),
            array('db' => 'pe_addr1',   'dt' => 12),
            array('db' => 'status',   'dt' => 13),
            array('db' => 'person_no_pk',   'dt' => 14),
            array('db' => 'emp_status',   'dt' => 15)
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function empPrint(Request $request)
    {
        $emp_id = $request->emp_id;
        $service_unit = $request->service_unit;
        $hr_type = $request->hr_type;
        $job_type = $request->job_type;
        $roster_type = $request->roster_type;
        $emp_ind = $request->emp_ind;
        $doc_ind = $request->doc_ind;
        $ref_ind = $request->ref_ind;
        $status = $request->status;

        $whereClause = "";
        ($emp_id != "") ? $whereClause .= " and person_no_pk = '$emp_id' " : "";
        ($service_unit != "") ? $whereClause .= " and serviceunit_no_fk = $service_unit " : "";
        ($hr_type != "") ? $whereClause .= " and hr_type_lookup_no_fk = $hr_type " : "";
        ($job_type != "") ? $whereClause .= " and job_type_lookup_no_fk = $job_type " : "";
        ($roster_type != "") ? $whereClause .= " and duty_roster_type = '$roster_type' " : "";
        ($emp_ind != "") ? $whereClause .= " and employee_ind = '$emp_ind' " : "";
        ($doc_ind != "") ? $whereClause .= " and doctor_ind = '$doc_ind' " : "";
        ($ref_ind != "") ? $whereClause .= " and referal_ind = $ref_ind " : "";
        if ($status == 4 || $status == 5) {
            ($status != "") ? $whereClause .= " and emp_status = $status " : "";
        } else {
            ($status != "") ? $whereClause .= " and status = $status " : "";
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $employee_info = DB::select("SELECT person_no_pk,employee_ind,doctor_ind,referal_ind,photo_name, person_code, full_name, age,  gender_txt ,specialization,designation,su_name, phone_mobile, pe_addr1, email_personal, status,person_no_pk,job_type_lookup_no_fk,serviceunit_no_fk,hr_type_lookup_no_fk,duty_roster_type, rownum rownumber, au_update_at, au_entry_at FROM employee_info_vw where au_entry_hospital_pk_no = $ses_hospital_no_pk $whereClause");

        $title = "employee list";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.hrm.employee.emp_print_html", ['employee_info' => $employee_info, 'barcode_no' => $barcode_no, 'emp_ind' => $emp_ind, 'doc_ind' => $doc_ind, 'ref_ind' => $ref_ind, 'po_hospital_details' => $po_hospital_details]);

            // $pdf = PDF::loadView("admin.hrm.employee.emp_print", ['employee_info' => $employee_info, 'barcode_no' => $barcode_no, 'emp_ind' => $emp_ind, 'doc_ind' => $doc_ind, 'ref_ind' => $ref_ind, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
            //  return $pdf->download('emp_print.pdf');

            //  return Template::loadview("admin.hrm.employee.emp_info",[
            //      "employee_info" => $employee_info]);


            //     $pdf = PDF::loadView("admin.hrm.employee.emp_print", ['employee_info' => $employee_info, 'barcode_no' => $barcode_no, 'emp_ind' => $emp_ind, 'doc_ind' =>
        }

        if ($request->hdn_report_type == 'EXCEL') {
            $pdf = ['employee_info' => $employee_info, 'barcode_no' => $barcode_no, 'emp_ind' => $emp_ind, 'doc_ind' => $doc_ind, 'ref_ind' => $ref_ind, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "emp_print";
            $html = View("admin.hrm.employee.emp_print")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }

    public function empPrintV1(Request $request)
    {
        $emp_id = $request->emp_id;
        $service_unit = $request->service_unit;
        $hr_type = $request->hr_type;
        $job_type = $request->job_type;
        $roster_type = $request->roster_type;
        $emp_ind = $request->emp_ind;
        $doc_ind = $request->doc_ind;
        $ref_ind = $request->ref_ind;
        $status      = $request->status;

        $emp_id_con = ($emp_id != "") ? " and person_no_pk = '$emp_id' " : "";
        $service_unit_con = ($service_unit != "") ? " and serviceunit_no_fk = $service_unit " : "";
        $hr_type_con = ($hr_type != "") ? " and hr_type_lookup_no_fk = $hr_type " : "";
        $job_type_con = ($job_type != "") ? " and job_type_lookup_no_fk = $job_type " : "";
        $roster_type_con = ($roster_type != "") ? " and duty_roster_type = '$roster_type' " : "";
        $emp_ind_con = ($emp_ind != "") ? " and employee_ind = '$emp_ind' " : "";
        $doc_ind_con = ($doc_ind != "") ? " and doctor_ind = '$doc_ind' " : "";
        $ref_ind_con = ($ref_ind != "") ? " and referal_ind = $ref_ind " : "";
        if ($status == 4 || $status == 5) {
            $status_con = ($status != "") ? " and emp_status = $status " : "";
        } else {
            $status_con = ($status != "") ? " and status = $status " : "";
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $ses_hospital_no_pk = Session::get('user.ses_hospital_no_pk');

        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $employee_info = DB::select("SELECT person_no_pk,employee_ind,doctor_ind, card_no, full_name,lname, age, gender_txt, dob, specialization,designation, join_date, confirmation_date, su_name, bank_acc_no, phone_mobile, pe_addr1, email_personal, status,person_no_pk,job_type_lookup_no_fk,job_type,serviceunit_no_fk,hr_type_lookup_no_fk,rownum rownumber, au_update_at, au_entry_at FROM hrms_personnel_vw where au_entry_hospital_pk_no = $ses_hospital_no_pk $emp_id_con  $service_unit_con  $hr_type_con $job_type_con $roster_type_con $emp_ind_con $doc_ind_con $ref_ind_con $status_con order by card_no asc");

        $title = "employee list";

        if ($request->hdn_report_type == 'PDF') {
            return view("admin.hrm.employee.emp_print_html_v1", ['employee_info' => $employee_info, 'doc_ind' => $doc_ind, 'ref_ind' => $ref_ind, 'po_hospital_details' => $po_hospital_details]);
        }
        if ($request->hdn_report_type == 'EXCEL') {
            // dd('ok');
            $pdf = ['employee_info' => $employee_info, 'emp_ind' => $emp_ind, 'doc_ind' => $doc_ind, 'ref_ind' => $ref_ind, 'po_hospital_details' => $po_hospital_details];
            $fileToExport = "emp_info_print";
            $html = View("admin.hrm.employee.emp_print_excel_v1")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }





    public function get_grade_amount(Request $request)
    {

        $grade_amt = DB::table('hrms_grade')->where('grade_no_pk', $request->grade_value)->first();
        // dd($grade_amt);
        return Template::loadview("admin.hrm.employee.salary_info", ['grade_amt' => $grade_amt]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender         = $this->getLookupListByCode("GENDER");
        $religion       = $this->getLookupListByCode("RELIGION");
        $bloodg         = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type       = $this->getLookupListByCode("JOBTYPE");
        $job_title      = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();

        $hr_type       = $this->getLookupListByCode("HRTYPE");
        $dept          = $this->getLookupListByCode("DEPT");
        $emp_type      = $this->getLookupListByCode("EMPTYPE");
        $service_unit  = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $district      = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $relation      = $this->getLookupListByCode("RELATION");
        $degree        = $this->getLookupListByCode("DEGREE");
        $agent_banking = $this->getLookupListByCode("AGENTBANKING");
        $gradePer      = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        $grade         = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");

        $visit_type  = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");

        $chamberList = ChamberHospital::all();

        // doctor code for KPJ
        if (Session::get('user.ses_hospital_code') === 'KPJ') {
                $result = DB::selectOne("
                    SELECT MAX(TO_NUMBER(SUBSTR(person_code, 3))) + 1 AS next_uid
                    FROM hrms_personnel
                    WHERE person_code LIKE '%DR%'
                    AND REGEXP_LIKE(person_code, '^DR[0-9]+$')
                ");
                $result1 = DB::selectOne("
                    SELECT MAX(TO_NUMBER(SUBSTR(person_code, 3))) + 1 AS next_uid1
                    FROM hrms_personnel
                    WHERE person_code LIKE '%VD%'
                    AND REGEXP_LIKE(person_code, '^VD[0-9]+$')
                ");
                $result2 = DB::selectOne("
                    SELECT MAX(TO_NUMBER(SUBSTR(person_code, 3))) + 1 AS next_uid2
                    FROM hrms_personnel
                    WHERE person_code LIKE '%MO%'
                    AND REGEXP_LIKE(person_code, '^MO[0-9]+$')
                ");

                $nextNumber = $result->next_uid ?? 1;
                $nextNumber1 = $result1->next_uid1 ?? 1;
                $nextNumber2 = $result2->next_uid2 ?? 1;
                $out_uid = 'DR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                $out_uid1 = 'VD' . str_pad($nextNumber1, 4, '0', STR_PAD_LEFT);
                $out_uid2 = 'MO' . str_pad($nextNumber2, 4, '0', STR_PAD_LEFT);
            } else {
                $out_uid = $this->getAutoGenerateUID('HRMS_PERSONNEL', 'PERSON_CODE', '', '');
                $out_uid1 = $out_uid;
                $out_uid2 = $out_uid;
            }


        // $out_uid = SELECT MAX(TO_NUMBER(SUBSTR(a.person_code, 3)))+1 into l_generate_uid_no_pk FROM hrms_personnel a WHERE a.person_code LIKE '%DR%';



        return Template::loadview("admin.hrm.doctor.create_doctor", [
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
            'visit_type'     => $visit_type,
            'page_type'      => 'edit',
            'name_prefix'    => $name_prefix,
            'chamberList'    => $chamberList,
            'out_uid'        => $out_uid,
            'out_uid1'       => $out_uid1,
            'out_uid2'       => $out_uid2,
        ]);
    }



    public function createEmployeeV1()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender         = $this->getLookupListByCode("GENDER");
        $religion       = $this->getLookupListByCode("RELIGION");
        $bloodg         = $this->getLookupListByCode("BLOODG");
        $name_prefix    = $this->getLookupListByCode("NAMEPREFIX");
        $district       = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $degree         = $this->getLookupListByCode("DEGREE");
        $dept           = $this->getLookupListByCode("DEPT");
        $job_type       = $this->getLookupListByCode("JOBTYPE");
        // $emp_type       = $this->getLookupListByCode("EMPTYPE");
        $hr_type        = $this->getLookupListByCode("HRTYPE");
        $job_nature     = $this->getLookupListByCode("JOBNATURE");
        $fringebenefit  = $this->getLookupListByCode("FRINGEBENEFIT");
        $bank_name      = $this->getLookupListByCode("BANK");
        $conveyance     = $this->getLookupListByCode("TRANSDESIG");
        $employee_type_data = $this->getLookupListByCode("EMPLOYEETYPE");
        $leave_emp_category = $this->getLookupListByCode("LEAVECATEGORY");
        $out_uid        =  $this->getAutoGenerateUID('HRMS_PERSONNEL', 'PERSON_CODE', '', '');

        $service_unit   = ServiceUnit::where('status', '1')->where('hr_dept_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $units          = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $job_title      = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();

        return Template::loadView('admin.v1.hrm.employee_setup.create_employeev1', [
            'marital_status' => $marital_status,
            'gender'         => $gender,
            'religion'       => $religion,
            'bloodg'         => $bloodg,
            'name_prefix'    => $name_prefix,
            'district'       => $district,
            'degree'         => $degree,
            'dept'           => $dept,
            'out_uid'        => $out_uid,
            'job_title'      => $job_title,
            'dept'           => $dept,
            'service_unit'   => $service_unit,
            'units'          => $units,
            'job_type'       => $job_type,
            // 'emp_type'       => $emp_type,
            'hr_type'        => $hr_type,
            'page_type'      => 'edit',
            'job_nature'     => $job_nature,
            'fringebenefit'  => $fringebenefit,
            'bank'           => $bank_name,
            'conveyance'     => $conveyance,
            'leave_emp_category' => $leave_emp_category,
            'employee_type_data' => $employee_type_data
        ]);
    }


    public function allThanaPre(Request $request)
    {
        $doctor_present_thana = '';
        $thana = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $request->disct_value)->orderBy("name", "asc")->get();
        return Template::loadview("admin.hrm.employee.pre_thana", ['thana_pre' => $thana, 'doctor_present_thana' => $doctor_present_thana]);
    }
    public function allThanaPer(Request $request)
    {
        $doctor_permanent_thana = '';
        $thana = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $request->disct_value)->orderBy("name", "asc")->get();
        return Template::loadview("admin.hrm.employee.per_thana", ['thana_per' => $thana, 'doctor_permanent_thana' => $doctor_permanent_thana]);
    }

    public function loadList()
    {

        $job_type = $this->getLookupListByCode("JOBTYPE");
        $job_title = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $hr_type = $this->getLookupListByCode("HRTYPE");
        $emp_type = $this->getLookupListByCode("EMPTYPE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $active = '<span class="badge badge-md badge-success"> Active</span>';
        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        $employee_info = DB::select("SELECT photo_name, person_code, full_name, age,  gender_txt ,specialization, phone_mobile, pe_addr1,designation,su_name, email_personal, status,person_no_pk, rownum rownumber, au_update_at, au_entry_at FROM employee_info_vw FETCH NEXT 20 ROWS ONLY");
        // return ['district' => $district];

        // dd($service_unit);
        return Template::loadview("admin.hrm.employee.doctor_list", [
            'service_unit' => $service_unit,
            'job_type' => $job_type,
            'job_title' => $job_title,
            'hr_type' => $hr_type,
            'emp_type' => $emp_type,
            'employee_info' => $employee_info
        ]);
    }

    public function employeeCard($id)
    {
        // $data = $this->model->show($id);
        // dd(Session::get('user.ses_hospital_code'));
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = Doctor::where('person_no_pk', '=', $id)
            ->select('salutation', 'full_name', 'person_code', 'card_no', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'photo_name', 'person_no_pk')
            ->leftJoin('sysc_lookupdata ld', 'hrms_personnel.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')
            ->leftJoin('sysc_lookupdata ld2', 'hrms_personnel.blood_group_lookup_no_fk', '=', 'ld2.lookupdata_no_pk')->first();
        // return $data;
        // dd($data);
        return Template::loadview("admin.hrm.employee.employee_card", [
            'data' => $data,
            'po_hospital_details' => $po_hospital_details,
        ]);
    }

    public function create_form()
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
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $grade = Grade::where('status', '1')->select('grade_no_pk', 'grade_name')->get();
        $district = $this->getLookupListByCode("DISTRICT");
        $relation = $this->getLookupListByCode("RELATION");
        $degree = $this->getLookupListByCode("DEGREE");
        $agent_banking = $this->getLookupListByCode("AGENTBANKING");
        $gradePer = DB::table('hrms_grade')->get();

        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");

        // return ['district' => $district];


        return Template::loadview("admin.hrm.employee.add_new_doctor_form", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'religion' => $religion,
            'bloodg' => $bloodg,
            'specialization' => $specialization,
            'service_unit' => $service_unit,
            'grade' => $grade,
            'job_type' => $job_type,
            'job_title' => $job_title,
            'hr_type' => $hr_type,
            'dept' => $dept,
            'emp_type' => $emp_type,
            'district' => $district,
            'relation' => $relation,
            'degree' => $degree,
            'agent_banking' => $agent_banking,
            'gradePer' => $gradePer,
            'salary_factor' => $salary_factor,
            'page_type' => 'edit',
        ]);
    }

    public function createQuickRegistration($doc_type = null)
    {

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");

        return Template::loadview("admin.hrm.employee.doctor_quick_register", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'doc_type' => $doc_type,
            'specialization' => $specialization,
            'name_prefix' => $name_prefix
        ]);
    }

    public function createQuickRegistrationPres($doc_type = 1)
    {

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $service_unit = ServiceUnit::where('status', '1')
        ->where('hr_dept_ind', 1)
        ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
        ->get();
        return Template::loadview("admin.hrm.employee.doctor_quick_register_ext", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'doc_type' => $doc_type,
            'specialization' => $service_unit,
            'name_prefix' => $name_prefix
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function add_new_doctor_form()
    {
        return Template::loadview("admin.hrm.employee.add_new_doctor_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function doctor_list()
    {
        return Template::loadview("admin.hrm.employee.doctor_list_v2");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function doctor_list_v3()
    {
        //        $doctors = Doctor::all();
        $doctors = Doctor::whereBetween('au_entry_at', [
            \carbon\Carbon::now()->subdays(30)->format('Y-m-d'),
            \carbon\Carbon::now()->subday()->format('Y-m-d')
        ])
            ->where("au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->get();


        return Template::loadview("admin.hrm.employee.doctor_list_v3", ['doctors' => $doctors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(DoctorRequest $request)
    {
        // dd($request->benefit_type_no_fk);
        $validated = $request->validated();

        return $this->doctorRepository->createOrUpdate($request, $request->id);
    }


    public function storeV1(DoctorRequest $request)
    {
        $validated = $request->validated();
        return $this->doctorRepository->createOrUpdateV1($request, $request->id);
    }


    public function LastCardNumberV1(Request $request)
    {
        // if ($request->selected_value == 1) {
        //     $card_no = DB::table('hrms_personnel')->select('card_no')->where('card_type_ind', $request->selected_value)->orderBy('person_no_pk', 'desc')->first();
        //     $card_no_sl = 10001;

        //     if (!empty($card_no)) {
        //         $card_no_sl = intval($card_no->card_no) + 1;
        //     }
        // } else {
        //     $card_no = DB::table('hrms_personnel')->select('card_no')->where('card_type_ind', $request->selected_value)->orderBy('card_no', 'desc')->first();
        //     $card_no_sl = 11001;

        //     if (!empty($card_no)) {
        //         $card_no_sl = intval($card_no->card_no) + 1;
        //     }
        // }


            if ($request->selected_value == 1) {
                $card_no = DB::table('hrms_personnel')
                            ->where('card_type_ind', $request->selected_value)
                            ->select(DB::raw('MAX(TO_NUMBER(card_no)) as max_card_no'))
                            ->value('max_card_no');

            //    dd($card_no);

                if ($card_no > 0) {
                    $card_no_sl = intval($card_no) + 1;
                }else{
                    $card_no_sl = 10001;
                    $card_no_sl = intval($card_no_sl) + 1;
                }
            } else {
                $card_no = DB::table('hrms_personnel')
                            ->where('card_type_ind', $request->selected_value)
                            ->select(DB::raw('MAX(TO_NUMBER(card_no)) as max_card_no'))
                            ->value('max_card_no');


                if ($card_no > 0) {
                    $card_no_sl = intval($card_no) + 1;
                }else{
                    $card_no_sl = 11001;
                    $card_no_sl = intval($card_no_sl) + 1;
                }
            }


        return response()->json($card_no_sl);
    }




    public function storeQuickRegistration(DoctorRequest $request)
    {
        $validated = $request->validated();
        return $this->doctorRepository->createOrUpdateQuickRegister($request, $request->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = "")
    {
        $data = DB::table('hrms_personnel AS d')
            ->select('d.person_no_pk', 'd.salutation', 'd.full_name', 'd.father_name', 'd.mother_name', 'd.spouse_name', 'gen.lookupdata_name AS gender', 'mar.lookupdata_name AS marital', 'd.dob', 'ser.serviceunit_name AS service_unit', 'd.join_date', 'jti.lookupdata_name AS job_title', 'jty.lookupdata_name AS job_type', 'hrt.lookupdata_name AS hr_type', 'empt.lookupdata_name AS emp_type', 'blo.lookupdata_name AS blood_group', 'rel.lookupdata_name AS religion', 'spe.lookupdata_name AS specialization', 'd.phone_home', 'd.phone_mobile', 'd.phone_office', 'd.nationality', 'd.pe_addr1', 'd.pe_addr_dist', 'd.pe_addr_country', 'd.pr_addr1', 'd.pr_addr_dist', 'd.pr_addr_country', 'd.emergency_contact_name', 'd.emergency_contact_addr', 'd.emergency_contact_relation', 'd.emergency_contact_contact', 'd.email_personal', 'd.passport_no', 'd.place_of_birth', 'd.card_no', 'd.inv_director_admin_ind', 'd.inv_director_acc_ind', 'd.inv_gen_man_proc_ind', 'd.inv_manager_acc_ind', 'd.inv_proc_ind', 'd.inv_store_ind', 'd.emp_serial_in_salary_sheet', 'd.emp_status', 'd.status', 'd.inactivate_date')
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
        return Template::loadview("admin.hrm.employee.doctor_view", [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // dd($id);
        $data = $this->doctor->show($id);

        $salaryInfo = DB::table("hrms_personnel_salary")->where("person_no_fk", $id)->first();
        $user_into = DB::table("wsec_user")->where("person_no_fk", $id)->first();
        $educationInfo = DB::table("hrms_personnel_education")->where("person_no_fk", $id)->get();
        // dd($educationInfo);
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type = $this->getLookupListByCode("JOBTYPE");
        $emp_type = $this->getLookupListByCode("EMPTYPE");
        $job_title = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $hr_type = $this->getLookupListByCode("HRTYPE");
        // $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $service_unit   = ServiceUnit::where('status', '1')->where('hr_dept_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $units          = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $grade = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $thana_pre = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->pr_addr_dist)->orderBy("name", "asc")->get();
        $thana_per = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->pe_addr_dist)->orderBy("name", "asc")->get();

        $relation = $this->getLookupListByCode("RELATION");
        $dept = $this->getLookupListByCode("DEPT");
        $degree = $this->getLookupListByCode("DEGREE");
        $agent_banking = $this->getLookupListByCode("AGENTBANKING");
        $gradePer = DB::table('hrms_grade')->select('grade_no_pk', 'grade_name')->get();
        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");

        $datafee = DoctorFee::where('person_no_fk', $id)->select('hrms_doctorfee.doctorfee_no_pk', 'hrms_doctorfee.item_no_fk', 'hrms_doctorfee.visit_type_lookup_no_fk', 'sysc_serviceitem.item_name')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'hrms_doctorfee.item_no_fk')
            ->get();
        $fee_arr = [];
        if (!empty($datafee)) {
            foreach ($datafee as $key => $value) {
                $fee_arr[$value->visit_type_lookup_no_fk]['doc_fee_id'] = $value->doctorfee_no_pk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_id'] = $value->item_no_fk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_name'] = $value->item_name;
            }
        }
        $visit_type = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");

        $hod1_name = DB::table('hrms_personnel')
                        ->leftJoin('hrms_personnel as hrms_personnel1', 'hrms_personnel.emp_hod1_person_no_fk', '=', 'hrms_personnel1.person_no_pk')
                        ->select('hrms_personnel.person_no_pk', 'hrms_personnel1.full_name as hname1', 'hrms_personnel.emp_hod1_person_no_fk', 'hrms_personnel1.person_no_pk as hod_pk' )
                        ->where('hrms_personnel.person_no_pk', $id)
                        ->first();

        $hod2_name = DB::table('hrms_personnel')
                        ->leftJoin('hrms_personnel as hrms_personnel2', 'hrms_personnel.emp_hod2_person_no_fk', '=', 'hrms_personnel2.person_no_pk')
                        ->select('hrms_personnel.person_no_pk', 'hrms_personnel2.full_name as hname2', 'hrms_personnel.emp_hod2_person_no_fk', 'hrms_personnel2.person_no_pk as hod_pk' )
                        ->where('hrms_personnel.person_no_pk', $id)
                        ->first();

        $sup1_name = DB::table('hrms_personnel')
                        ->leftJoin('hrms_personnel as hrms_personnel3', 'hrms_personnel.emp_supvisor1_person_no_fk', '=', 'hrms_personnel3.person_no_pk')
                        ->select('hrms_personnel.person_no_pk', 'hrms_personnel3.full_name as supname1', 'hrms_personnel.emp_supvisor1_person_no_fk', 'hrms_personnel3.person_no_pk as sup_pk' )
                        ->where('hrms_personnel.person_no_pk', $id)
                        ->first();

        $leave_emp_category = $this->getLookupListByCode("LEAVECATEGORY");
        $benifit_tpye       = $this->getLookupListByCode("MEDICALBENEFITTYPE");

        return Template::loadview("admin.hrm.employee.add_new_doctor_form", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'religion' => $religion,
            'bloodg' => $bloodg,
            'specialization' => $specialization,
            'service_unit' => $service_unit,
            'units' => $units,
            'job_type' => $job_type,
            'job_title' => $job_title,
            'emp_type' => $emp_type,
            'hr_type' => $hr_type,
            'data' => $data,
            'district' => $district,
            'thana_pre' => $thana_pre,
            'thana_per' => $thana_per,
            'relation' => $relation,
            'salaryInfo' => $salaryInfo,
            'educationInfo' => $educationInfo,
            'page_type' => 'edit',
            'grade' => $grade,
            'dept' => $dept,
            'degree' => $degree,
            'salary_factor' => $salary_factor,
            'gradePer' => $gradePer,
            'agent_banking' => $agent_banking,
            'visit_type' => $visit_type,
            'fee_arr' => $fee_arr,
            'user_into' => $user_into,
            'name_prefix' => $name_prefix,
            'leave_emp_category' => $leave_emp_category,
            'hod1_name' => $hod1_name,
            'hod2_name' => $hod2_name,
            'sup1_name' => $sup1_name,
            'benifit_tpye' => $benifit_tpye,
        ]);
    }


    public function editV1($id)
    {
        $hod1_name = DB::table('hrms_personnel')
        ->leftJoin('hrms_personnel as hrms_personnel1', 'hrms_personnel.emp_hod1_person_no_fk', '=', 'hrms_personnel1.person_no_pk')
        ->select('hrms_personnel.person_no_pk', 'hrms_personnel1.full_name as hname1', 'hrms_personnel.emp_hod1_person_no_fk', 'hrms_personnel1.person_no_pk as hod_pk' )
        ->where('hrms_personnel.person_no_pk', $id)
        ->first();

        $hod2_name = DB::table('hrms_personnel')
        ->leftJoin('hrms_personnel as hrms_personnel2', 'hrms_personnel.emp_hod2_person_no_fk', '=', 'hrms_personnel2.person_no_pk')
        ->select('hrms_personnel.person_no_pk', 'hrms_personnel2.full_name as hname2', 'hrms_personnel.emp_hod2_person_no_fk', 'hrms_personnel2.person_no_pk as hod_pk' )
        ->where('hrms_personnel.person_no_pk', $id)
        ->first();

        $sup1_name = DB::table('hrms_personnel')
        ->leftJoin('hrms_personnel as hrms_personnel3', 'hrms_personnel.emp_supvisor1_person_no_fk', '=', 'hrms_personnel3.person_no_pk')
        ->select('hrms_personnel.person_no_pk', 'hrms_personnel3.full_name as supname1', 'hrms_personnel.emp_supvisor1_person_no_fk', 'hrms_personnel3.person_no_pk as sup_pk')
        ->where('hrms_personnel.person_no_pk', $id)
        ->first();

        $sup2_name = DB::table('hrms_personnel')
        ->leftJoin('hrms_personnel as hrms_personnel4', 'hrms_personnel.emp_supvisor2_person_no_fk', '=', 'hrms_personnel4.person_no_pk')
        ->select('hrms_personnel.person_no_pk', 'hrms_personnel4.full_name as supname2', 'hrms_personnel.emp_supvisor2_person_no_fk', 'hrms_personnel4.person_no_pk as sup_pk' )
        ->where('hrms_personnel.person_no_pk', $id)
        ->first();

        $data = $this->doctor->show($id);

        // dd($data);

        $salaryInfo = DB::table("hrms_personnel_salary")->where("person_no_fk", $id)->first();
        $user_into = DB::table("wsec_user")->where("person_no_fk", $id)->first();
        $educationInfo = DB::table("hrms_personnel_education")->where("person_no_fk", $id)->get();
        $experienceInfo = DB::table("hrms_personnel_experience")->where("person_no_fk", $id)->get();
        $trainingInfo = DB::table("hrms_personnel_cert_tr")->where("person_no_fk", $id)->get();
        $nomineeInfo = DB::table("hrms_nominee_info")->where("person_no_fk", $id)->get();
        $dependentInfo = DB::table("hrms_dependent_info")->where("person_no_fk", $id)->get();
        $fringebenefitInfo = DB::table("hrms_fringe_benefit")->where("person_no_fk", $id)->get();
        $bank_name      = $this->getLookupListByCode("BANK");
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $specialization = $this->getLookupListByCode("DOCSPL");
        $job_type = $this->getLookupListByCode("JOBTYPE");
        // $emp_type = $this->getLookupListByCode("EMPTYPE");
        $leave_emp_category = $this->getLookupListByCode("LEAVECATEGORY");
        $employee_type_data = $this->getLookupListByCode("EMPLOYEETYPE");
        $job_title = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        $hr_type = $this->getLookupListByCode("HRTYPE");
        $service_unit = ServiceUnit::where('status', '1')->where('hr_dept_ind',1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $units          = ServiceUnit::where('status', '1')->where('hr_unit_ind', 1)->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();

        $grade = Grade::where("status", "1")->select("grade_no_pk", "grade_name")->orderBy("grade_name", "asc")->get();
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();

        $thana_pre = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', (int)$data->pr_addr_dist)->orderBy("name", "asc")->get();
        $thana_per = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', (int)$data->pe_addr_dist)->orderBy("name", "asc")->get();

        $relation = $this->getLookupListByCode("RELATION");
        $dept = $this->getLookupListByCode("DEPT");
        $degree = $this->getLookupListByCode("DEGREE");
        $agent_banking = $this->getLookupListByCode("AGENTBANKING");
        $gradePer = DB::table('hrms_grade')->select('grade_no_pk', 'grade_name')->get();
        $salary_factor = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTOR");
        $conveyance     = $this->getLookupListByCode("TRANSDESIG");
        $fringebenefit  = $this->getLookupListByCode("FRINGEBENEFIT");
        $job_nature     = $this->getLookupListByCode("JOBNATURE");
        $datafee = DoctorFee::where('person_no_fk', $id)->select('hrms_doctorfee.doctorfee_no_pk', 'hrms_doctorfee.item_no_fk', 'hrms_doctorfee.visit_type_lookup_no_fk', 'sysc_serviceitem.item_name')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'hrms_doctorfee.item_no_fk')
            ->get();
        $fee_arr = [];
        if (!empty($datafee)) {
            foreach ($datafee as $key => $value) {
                $fee_arr[$value->visit_type_lookup_no_fk]['doc_fee_id'] = $value->doctorfee_no_pk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_id'] = $value->item_no_fk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_name'] = $value->item_name;
            }
        }
        $visit_type = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");

        return Template::loadview("admin.v1.hrm.employee_setup.create_employee_formv1", [
            'marital_status'  => $marital_status,
            'gender'          => $gender,
            'religion'        => $religion,
            'bloodg'          => $bloodg,
            'specialization'  => $specialization,
            'service_unit'    => $service_unit,
            'job_type'        => $job_type,
            'job_title'       => $job_title,
            // 'emp_type'        => $emp_type,
            'hr_type'         => $hr_type,
            'data'            => $data,
            'district'        => $district,
            'thana_pre'       => $thana_pre,
            'thana_per'       => $thana_per,
            'relation'        => $relation,
            'salaryInfo'      => $salaryInfo,
            'educationInfo'   => $educationInfo,
            'experienceInfo'  => $experienceInfo,
            'trainingInfo'    => $trainingInfo,
            'nomineeInfo'     => $nomineeInfo,
            'dependentInfo'   => $dependentInfo,
            'page_type'       => 'edit',
            'grade'           => $grade,
            'dept'            => $dept,
            'degree'          => $degree,
            'salary_factor'   => $salary_factor,
            'gradePer'        => $gradePer,
            'agent_banking'   => $agent_banking,
            'visit_type'      => $visit_type,
            'fee_arr'         => $fee_arr,
            'user_into'       => $user_into,
            'name_prefix'     => $name_prefix,
            'hod1_name'       => $hod1_name,
            'hod2_name'       => $hod2_name,
            'sup1_name'       => $sup1_name,
            'sup2_name'       => $sup2_name,
            'conveyance'      => $conveyance,
            'bank'            => $bank_name,
            'fringebenefit'   => $fringebenefit,
            'fringebenefitInfo' => $fringebenefitInfo,
            'units'           => $units,
            'job_nature'     => $job_nature,
            'leave_emp_category' => $leave_emp_category,
            'employee_type_data' => $employee_type_data
        ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getDoctorInfoById($id)
    {
        return $id;
    }

    public function getAllDoctors(Request $request)
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id and employee_ind = 1 ";

        $table = 'employee_info_vw';
        // Table's primary key
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
            array('db' => 'email_personal',   'dt' => 11),
            array('db' => 'pe_addr1',   'dt' => 12),
            array('db' => 'status',   'dt' => 13),
            array('db' => 'person_no_pk',   'dt' => 14),
            array('db' => 'emp_status',   'dt' => 15)

        );
        // dd($sql_cond);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function get_doctors_by_specl(Request $request)
    {
        return $this->getDoctorsBySpecl($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function get_doctors_list_by_specl(Request $request)
    {
        return $this->getDoctorsListBySpecl($request);
    }

    public function get_doctors_list_by_specl_date(Request $request)
    {
        return $this->getDoctorsListBySpeclDate($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function doctorInfoJson(Request $request)
    {
        return $this->doctorInfoByCodeJson($request);
    }


    public function doctorFeeSetup($doctorId)
    {

        $data = $this->doctor->show($doctorId);
        $datafee = DoctorFee::where('person_no_fk', $doctorId)
            ->select('hrms_doctorfee.doctorfee_no_pk', 'hrms_doctorfee.item_no_fk', 'hrms_doctorfee.visit_type_lookup_no_fk', 'sysc_serviceitem.item_name')
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'hrms_doctorfee.item_no_fk')
            ->get();

        $fee_arr = [];

        if (!empty($datafee)) {

            foreach ($datafee as $key => $value) {
                $fee_arr[$value->visit_type_lookup_no_fk]['doc_fee_id'] = $value->doctorfee_no_pk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_id'] = $value->item_no_fk;
                $fee_arr[$value->visit_type_lookup_no_fk]['item_name'] = $value->item_name;
            }
        }

        $visit_type = $this->getLookupListByCode("VISITTYPE");

        return Template::loadview("admin.hrm.employee.doctor_fee_setup", [
            'visit_type' => $visit_type,
            'data' => $data,
            'fee_arr' => $fee_arr,
        ]);
    }

    public function doctorFeeSetupStore(Request $request)
    {
        if ($request->doctor_pk_no) {
            $insertData = array();
            if (!empty($request->visit_type_pk_no)) {
                foreach ($request->visit_type_pk_no as $key => $value) {
                    if ($value && ($request->item_name[$key])) {


                        $check = DoctorFee::where('visit_type_lookup_no_fk', '=', $value)
                            ->where('person_no_fk', '=', $request->doctor_pk_no)->first();

                        if ($check) {
                            //update
                            DoctorFee::where('visit_type_lookup_no_fk', '=', $value)
                                ->where('person_no_fk', '=', $request->doctor_pk_no)
                                ->update(['item_no_fk' => $request->item_id[$key]]);
                            $last_id = $request->doctor_pk_no;
                        } else {
                            //insert
                            $data = [
                                'person_no_fk' => $request->doctor_pk_no,
                                'item_no_fk' => $request->item_id[$key],
                                'visit_type_lookup_no_fk' => $value,
                            ];
                            // $result = $this->doctorfee->create($data);
                            $last_id = $request->doctor_pk_no;
                        }
                    }
                }
                $message = ['msg' => 'Doctor Consultation Fee Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
            }
        }
        return response()->json($message);
    }

    public function getItemName()
    {
        $keyword = strval($_POST['query']);
        $countryResult = $this->getItemListAutoComplete($keyword);


        return response()->json($countryResult);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function doctorInfoAutocomplete(Request $request)
    {
        return $this->getDoctorAutocompleteList($request);
    }
    public function doctorInfoAutocompleteAll(Request $request)
    {
        return $this->getDoctorAutocompleteListAll($request);
    }

    public function doctorDegreeAutocomplete(Request $request)
    {
        return $this->getDoctorDegreeAutocomplete($request);
    }
    public function doctorInfoAutocompletev3(Request $request)
    {
        return $this->getDoctorAutocompleteListv3($request);
    }



    //manage profile
    //Added By Nazmul hasan 10 may 2021

    public function manageProfile($id)
    {

        $data = DB::table('wsec_user a')->leftJoin('hrms_personnel p', 'p.person_no_pk', '=', 'a.person_no_fk')->where('a.user_no_pk', $id)->first();
        $hospital = DB::table('wsec_hospital')->select('hospital_no_pk', 'hospital_name')->where('status', 1)->get();
        $ses_job_type_name = Session::get('user.ses_job_type_name');
        $ses_current_hospital = Session::get('user.ses_hospital_id');
        $po_hospital_details = \Illuminate\Support\Facades\DB::table("WSEC_HOSPITAL")->first();
        //dd($data);

        return Template::loadview("admin.hrm.doctor.profile.management_profile", [
            'data' => $data,
            'ses_job_type_name' => $ses_job_type_name,
            'ses_current_hospital' => $ses_current_hospital,
            'hospital' => $hospital,
            'po_hospital_details' => $po_hospital_details,
            'page_type' => 'edit'
        ]);
    }

    public function profileUpdate(Request $request)
    {

        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $ses_user_pk_no = Session::get('user.ses_user_pk_no');
        $ses_person_no_fk = Session::get('user.ses_person_no_fk');
        // dd(  $ses_person_no_fk);
        // dd( Auth::user());
        //$ses_user_pk_no = Session::get('user.ses_user_pk_no');
        //         $passwordMatch = Hash::check($request->password,Auth::user()->user_pass);

        $passwordMatch = true;
        if ($request->tab_type == 2) {
            $passwordMatch = Hash::check($request->password, Auth::user()->user_pass);
            if ($passwordMatch == true) {
                if ($request->new_password == $request->confirm_password) {
                    $passwordMatch = true;
                } else {
                    $passwordMatch = false;
                }
            }
        }


        DB::beginTransaction();
        try {
            $fname = $request->first_name;
            $lname = $request->last_name;

            $image_name = "";
            if ($files = $request->file('doc_photo')) {
                $image_name =  $ses_person_no_fk . "." . $files->getClientOriginalExtension();
            }

            $person_data = [
                'phone_mobile' => $request->doctor_mobile,
                'fname' => $fname,
                'lname' => $lname,
                'full_name' => $fname . ' ' . $lname,
                'email_personal' => $request->doctor_email,
                //                'photo_name'     => $image_name,
            ];


            $psersonuser_data = [
                'user_fullname' => $fname . ' ' . $lname,
                'email' => $request->doctor_email,
            ];
            //dd($psersonuser_data);

            if ($request->tab_type == 1) {
                //  dd(1,$ses_person_no_fk);
                $person_data['au_update_by'] = $auth_id;
                $psersonuser_data['au_update_by'] = $auth_id;
                if ($ses_person_no_fk != "") {

                    if ($files = $request->file('doc_photo')) {

                        $person_data['photo_name'] = $image_name;
                        $this->doctorRepository->uploadImages($files, $ses_person_no_fk, 'images/uploads/doctor_images/', 'images/uploads/doctor_images/thumb/');
                    }
                    $this->doctor->update($person_data, $ses_person_no_fk);
                }

                $this->doctor->update($person_data, $ses_person_no_fk);
            }

            $user_data = [
                'user_pass' => Hash::make($request->new_password),
                'user_name_access_code' => $request->new_password,
            ];

            if ($request->tab_type == 2 && $passwordMatch == true) {
                $user_data['au_update_by'] = $auth_id;
                $this->users->update($user_data, $auth_id);
            }

            $other_data = [
                'degree1' => $request->doctor_degree1,
                'degree2' => $request->doctor_degree2,
                'degree3' => $request->doctor_degree3,
                'doctor_signature' => $request->signature,
            ];

            if ($request->tab_type == 3) {

                if (!empty($request->change_hospital)) {
                    $hospital_no_pk = explode('_', $request->change_hospital);
                    $hospital_no['hospital_no_fk'] = $hospital_no_pk[0];
                    $hospital_no['au_update_by'] = $auth_id;
                    $this->users->update($hospital_no, $auth_id);
                }

                if (!empty($ses_person_no_fk)) {

                    //                    dd($ses_person_no_fk);
                    $other_data['au_update_by'] = $auth_id;
                    $this->doctor->update($other_data, $ses_person_no_fk);
                }
            }

            DB::commit();
            if (!empty($hospital_no_pk)) {
                session(['user.ses_hospital_name' => $hospital_no_pk[1]]);
                session(['user.ses_hospital_id' => $hospital_no_pk[0]]);
                session()->save();
            }
            if ($passwordMatch == "true") {
                $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } else {
                $message = ['msg' => 'Password Incorrect', 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function checkIfEmailExits(Request $request)
    {
        if ($request->doctor_id != "") {

            $verify_employee = DB::table("wsec_user")->select("email")->where("email", $request->email)->where([["person_no_fk", "!=", $request->doctor_id]])->get();
        } else {

            $verify_employee = DB::table("wsec_user")->select("email")->where("email", $request->email)->get();
        }

        return count($verify_employee);
    }
    public function checkIfUsernameExits(Request $request)
    {
        if ($request->doctor_id != "") {

            $verify_employee = DB::table("wsec_user")->select("user_name")->where("user_name", $request->username)->where([["person_no_fk", "!=", $request->doctor_id]])->get();
        } else {

            $verify_employee = DB::table("wsec_user")->select("user_name")->where("user_name", $request->username)->get();
        }

        return count($verify_employee);
    }

    public function employeeCardSearch(Request $request)
    {
        $doctors = Doctor::where('person_no_pk', $request->doctor_id)->get();
        return Template::loadview("admin.hrm.employee.card_list_data", ['doctors' => $doctors]);
    }

    public function employeeDt($emp_id = null)
    {
        $degree        = $this->getLookupListByCode("DEGREE");
        $eduboard        = $this->getLookupListByCode("EDUCATIONBOARD");
        $employee_info = DB::table('EMPLOYEE_INFO_VW')->where('PERSON_NO_PK', $emp_id)->first();
        $educationInfo = DB::table('hrms_personnel_education')->where('person_no_fk', $emp_id)->get();
        $experience_dt = DB::table('hrms_personnel_experience')->where('person_no_fk', $emp_id)->get();
        $certificate_dt = DB::table('hrms_personnel_cert_tr')->where('person_no_fk', $emp_id)->get();
        return Template::loadView("admin.uhl.employee-detail-information", [
            'employee_info'     => $employee_info,
            'degree'            => $degree,
            'eduboard'          => $eduboard,
            'educationInfo'     => $educationInfo,
            'experience_dt'     => $experience_dt,
            'certificate_dt'    => $certificate_dt,
        ]);
    }

    public function employeeStoreInformation(Request $request)
    {

        $auth_id = Auth::id();
        $person_id = $request->employee_name;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            // for education
            $edu_array_count = sizeof($request->input("name"));
            $name = $request->input("name");
            $education_board = $request->input("education_board");
            $highest_edu = $request->input("highest_edu");
            $certificate_link = $request->input("certificate_link");
            $institution = $request->input("institution");
            $result = $request->input("result");
            $p_year = $request->input("p_year");
            DB::table('hrms_personnel_education')->where('person_no_fk', $person_id)->delete();
            DB::table('hrms_personnel_experience')->where('person_no_fk', $person_id)->delete();
            DB::table('hrms_personnel_cert_tr')->where('person_no_fk', $person_id)->delete();
            if (isset($name)) {
                // DB::table('hrms_personnel_education')->where('person_no_fk',$person_id)->delete();
                for ($i = 0; $i < $edu_array_count; $i++) {
                    if ($name[$i] != null) {
                        $sequence = DB::getSequence();
                        $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                        $educationData = [
                            "education_no_pk" => $education_no_pk_seq,
                            'person_no_fk' => $person_id,
                            'degree_name' => (isset($name[$i])) ? $name[$i] : '',
                            'institute_name' => (isset($institution[$i + 1])) ? $institution[$i + 1] : '',
                            'passing_year' => (isset($p_year[$i + 1])) ? $p_year[$i + 1] : '',
                            'result_text' => (isset($result[$i + 1])) ?  $result[$i + 1] : '',
                            'board_university' => (isset($education_board[$i + 1])) ?  $education_board[$i + 1] : '',
                            // 'result_text' => (isset($highest_edu[$i + 1])) ?  $highest_edu[$i + 1] : '',
                            'education_cert_url' => (isset($certificate_link[$i + 1])) ?  $certificate_link[$i + 1] : '',
                            'au_entry_session' => "session",
                            'au_entry_hospital_pk_no' => $ses_hospital_id
                        ];
                        $educationData['au_entry_by'] = $auth_id;
                        $educationData['au_entry_at'] = date("Y-m-d");
                        DB::table('hrms_personnel_education')->insert($educationData);
                    }
                }
            }

            // for Experience
            $edu_array_count_one = sizeof($request->input("company_name"));
            $company_name = $request->input("company_name");
            $company_location = $request->input("company_location");
            $designation = $request->input("designation");
            // $start_date = date('Y-m-d', strtotime($request->start_date));
            // $end_date = date('Y-m-d', strtotime($request->end_date));
            $number_of_years = $request->input("number_of_years");
            $reason_of_resign = $request->input("reason_of_resign");
            $current_job = $request->input("current_job");

            if (isset($company_name)) {

                for ($i = 0; $i < $edu_array_count_one; $i++) {
                    if ($company_name[$i] != null) {
                        $sequence = DB::getSequence();
                        $emp_experience_no_pk_seq = $sequence->nextValue('emp_experience_no_pk_seq');
                        $experienceData = [
                            "experience_no_pk" => $emp_experience_no_pk_seq,
                            'person_no_fk' => $person_id,
                            'company_name' => (isset($company_name[$i])) ? $company_name[$i] : '',
                            'company_address' => (isset($company_location[$i])) ? $company_location[$i] : '',
                            'designation_name' => (isset($designation[$i])) ? $designation[$i] : '',
                            // 'emp_from_date' => (isset($start_date[$i])) ? $start_date[$i] : '',
                            // 'emp_to_date' => (isset($end_date[$i])) ? $end_date[$i] : '',
                            // 'experience_cert_file' => (isset($number_of_years[$i])) ? $number_of_years[$i] : '',
                            'reason_of_resign' => (isset($reason_of_resign[$i])) ? $reason_of_resign[$i] : '',
                            'current_job_ind' => (isset($current_job[$i])) ? $current_job[$i] : '',
                            'au_entry_session' => "session",
                            'au_entry_hospital_pk_no' => $ses_hospital_id
                        ];
                        $experienceData['au_entry_by'] = $auth_id;
                        $experienceData['au_entry_at'] = date("y-m-d");

                        db::table('hrms_personnel_experience')->insert($experienceData);
                    }
                }
            }

            // for Certificate
            $edu_array_count_two = sizeof($request->input("certificate_title"));
            $certificate_title = $request->input("certificate_title");
            $institude_name = $request->input("institude_name");
            $certificate_start_date = $request->input("certificate_start_date");
            $certificate_end_date = $request->input("certificate_end_date");
            $certificate__date = $request->input("certificate__date");
            $highest_education = $request->input("highest_education");
            $certificate_link = $request->input("certificate_link");
            // $start_date = date('Y-m-d', strtotime($request->start_date));
            // $end_date = date('Y-m-d', strtotime($request->end_date));

            if (isset($certificate_title)) {

                for ($i = 0; $i < $edu_array_count_two; $i++) {
                    if ($certificate_title[$i] != null) {
                        $sequence = DB::getSequence();
                        $emp_cert_tr_no_pk_seq = $sequence->nextValue('emp_cert_tr_no_pk_seq');
                        $certificateData = [
                            "cert_tr_no_pk" => $emp_cert_tr_no_pk_seq,
                            'person_no_fk' => $person_id,
                            'cert_tr_tittle' => (isset($certificate_title[$i])) ? $certificate_title[$i] : '',
                            'institute_name' => (isset($institude_name[$i])) ? $institude_name[$i] : '',
                            'emp_from_date' => (isset($certificate_start_date[$i])) ? $certificate_start_date[$i] : '',
                            'emp_to_date' => (isset($certificate_end_date[$i])) ? $certificate_end_date[$i] : '',
                            'certification_date' => (isset($certificate__date[$i])) ? $certificate__date[$i] : '',
                            // 'company_name' => (isset($highest_education[$i])) ? $highest_education[$i] : '',
                            'tr_cert_url' => (isset($certificate_link[$i])) ? $certificate_link[$i] : '',
                            'au_entry_session' => "session",
                            'au_entry_hospital_pk_no' => $ses_hospital_id
                        ];
                        $certificateData['au_entry_by'] = $auth_id;
                        $certificateData['au_entry_at'] = date("y-m-d");
                        db::table('hrms_personnel_cert_tr')->insert($certificateData);
                    }
                }
            }


            DB::table('hrms_personnel')->where('person_no_pk', $request->employee_name)->update([
                'skill' => $request->skill,
                // 'FULL_NAME' => $request->employee_name,
                // 'FNAME' => $request->employee_name,
                // 'skill' => $request->emp_designation,
                // 'skill' => $request->emp_department,
                // 'skill' => $request->emp_dob,
                // 'PHONE_MOBILE' => $request->emp_mobile,
                // 'skill' => $request->emp_gender,
                // 'EMAIL_PERSONAL' => $request->emp_email,
                // 'skill' => $request->emp_joining_date,
            ]);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $person_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

     //doctor payment setup
     public function doctorPaymentSetup($id = null)
     {
        $docerShareData = DB::table('hrms_docershare as doc')
        ->select('doc.docershare_no_pk', 'doc.person_no_fk', 'doc.item_no_fk', 'doc.effdate', 'doc.pat_type', 'doc.drprcnt', 'doc.stfpercent', 'per.person_code', 'per.full_name', 'ser.item_code', 'ser.item_name')
        ->leftJoin('hrms_personnel as per', 'per.person_no_pk', '=', 'doc.person_no_fk')
        ->leftJoin('sysc_serviceitem as ser', 'ser.item_no_pk', '=', 'doc.item_no_fk')
        ->where('doc.docershare_no_pk', $id)
        ->first();
         return Template::loadView("admin.doctor_payment.doctor_payment_setup", [
             "doctorPaymentData" => [],
             "docerShareData" => $docerShareData,
         ]);
     }

     public function storeDoctorPayment(Request $request)
     {
         DB::beginTransaction();
         try {
             $sequence = DB::getSequence();
             $au_entry_at = Carbon::now();
             $au_entry_at = $au_entry_at->toDateTimeString();
             $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
             $data = [
                 'docershare_no_pk' =>  $sequence->nextvalue('docershare_no_pk_seq'),
                 'person_no_fk' => $request->hdn_doctor_id,
                 'item_no_fk' => $request->hdn_item_id,
                 'effdate' => isset($request->effdate) ? date('Y-m-d', strtotime($request->effdate)): '',
                 'pat_type' => $request->pat_type,
                 'drprcnt' => $request->drprcnt,
                 'stfpercent' => $request->stfpercent,
                 'status' => 1
             ];

             if (isset($request->docershare_no_pk)) {
                 $data['au_update_at'] = $au_entry_at;
                 $data['au_update_by'] = Auth::id();
                 $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                 DB::table("hrms_docershare")->where('docershare_no_pk', $request->docershare_no_pk)
                     ->update($data);
             } else {
                 $data['au_entry_at'] = $au_entry_at;
                 $data['au_entry_by'] = Auth::id();
                 $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                 $data['au_entry_session'] = 'DOCSHARE';
                 DB::table("hrms_docershare")->insert($data);
             }
             DB::commit();
             $this->message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
         } catch (\Exception $e) {
             DB::rollback();
             $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
         }

         return response()->json($this->message);
     }
     public function doctorPaymentWorklist()
     {
         return Template::loadView("admin.doctor_payment.doctor_payment_worklist", [
            //  "salaryData" => $salaryData
         ]);
     }
     public function searchDoctorPayment(Request $request)
     {
        $query = db::table('hrms_docershare as doc')->select('doc.docershare_no_pk', 'doc.effdate', 'doc.pat_type', 'doc.drprcnt', 'doc.stfpercent', 'per.person_code', 'per.full_name', 'ser.item_code', 'ser.item_name')
        ->leftJoin('hrms_personnel as per', 'per.person_no_pk', '=', 'doc.person_no_fk')
        ->leftJoin('sysc_serviceitem as ser', 'ser.item_no_pk', '=', 'doc.item_no_fk');
        if(($request->has('hdn_doctor_id') && $request->hdn_doctor_id != '')) {
            $query->where('doc.person_no_fk', $request->hdn_doctor_id);
        }
        if(($request->has('hdn_item_id') && $request->hdn_item_id != '')) {
            $query->where('doc.item_no_fk', $request->hdn_item_id);
        }
        if(($request->has('pat_type') && $request->pat_type != '')) {
            $query->where('doc.pat_type', $request->pat_type);
        }
        $doctorPaymentData = $query->orderBy('doc.effdate', 'desc')
        ->get();
        return Template::loadview("admin.doctor_payment.doctor_payment_list_container", [
            "doctorPaymentData" => $doctorPaymentData,
        ]);
     }
     public function downloadDoctorShareList(Request $request) {

        $query = db::table('hrms_docershare as doc')->select('doc.docershare_no_pk', 'doc.effdate', 'doc.pat_type', 'doc.drprcnt', 'doc.stfpercent', 'per.person_code', 'per.full_name', 'ser.item_code', 'ser.item_name')
        ->leftJoin('hrms_personnel as per', 'per.person_no_pk', '=', 'doc.person_no_fk')
        ->leftJoin('sysc_serviceitem as ser', 'ser.item_no_pk', '=', 'doc.item_no_fk');
        if(($request->has('hdn_doctor_id') && $request->hdn_doctor_id != '')) {
            $query->where('doc.person_no_fk', $request->hdn_doctor_id);
        }
        if(($request->has('hdn_item_id') && $request->hdn_item_id != '')) {
            $query->where('doc.item_no_fk', $request->hdn_item_id);
        }
        if(($request->has('pat_type') && $request->pat_type != '')) {
            $query->where('doc.pat_type', $request->pat_type);
        }
        $doctorPaymentData = $query->orderBy('doc.effdate', 'desc')
        ->get();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if ($request->status == 'excel') {
            $pdf =  ["type" => "excel", "po_hospital_details" => $po_hospital_details, 'doctorPaymentData' => $doctorPaymentData];
            $fileToExport = "doctor_share_report";
            $html = View("admin.doctor_payment.doctor_share_report")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }else{
            return View("admin.doctor_payment.doctor_share_report", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, 'doctorPaymentData' => $doctorPaymentData]);
            // ->setPaper('a4');
            // return $pdf->stream('doctor_share_report.pdf');
        }
    }
}
