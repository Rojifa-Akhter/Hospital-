<?php

namespace App\Http\Controllers;

use QR;
use PDO;
use \PDF;
use Session;
use Carbon\Carbon;
use App\Models\Item;
use App\Library\Template;
use App\Traits\LookupData;
use App\Traits\PatientData;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Dompdf\FrameDecorator\Table;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\DB;
use App\Models\PatientRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository as Repo;
use App\Http\Requests\PateintRegistrationRequest;
use App\Repositories\PatientRegistrationRepository;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use GuzzleHttp\Client;
use DateTime;

class PatientRegistrationController extends Controller
{

    use DatatablesLoader, LookupData, PatientData;
    protected $model;
    protected $patRegRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PatientRegistration $patReg)
    {
        $this->middleware('auth');
        $this->model = new Repo($patReg);
        $this->patRegRepository = new PatientRegistrationRepository($patReg);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $patient_type = DB::table('patient_type_vw')->select('patient_type_no_pk', 'patient_type_code')->where('status',1)->get();
        $corporate_code = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.patient.registration_list", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'patient_type' => $patient_type, 'corporate_code' => $corporate_code]);
    }

    /**
     * Index v1
     */
    public function indexV1()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $patient_type = DB::table('patient_type_vw')->select('patient_type_no_pk', 'patient_type_code')->where('status',1)->get();
        $corporate_code = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $items = DB::table("patient_info_vw")
                    ->where('au_entry_hospital_pk_no', $hospital_id)
                    ->where('status', 1)
                    ->select('patient_no_pk', 'patient_code', 'patient_name', 'dob', 'gender_txt', 'mobile1', 'present_addr', 'email', 'status', 'patient_photo', 'ccm_client_name', 'ccm_client_code', 'contact_person', 'contact_no', 'contract_sign_date', 'agent_name', 'inform_text')
                    ->orderByDesc('PATIENT_NO_PK')
                    ->get();

        return Template::loadView("admin.patient.v1.registration_list_v1", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'patient_type' => $patient_type, 'corporate_code' => $corporate_code, 'items' => $items]);
    }

    /**
     * Filter:: Patient Registration
     */
    public function filter(Request $request)
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $patient_type = DB::table('patient_type_vw')->select('patient_type_no_pk', 'patient_type_code')->where('status',1)->get();
        $corporate_code = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $items = DB::table("patient_info_vw")
                    ->where('au_entry_hospital_pk_no', $hospital_id)
                    ->where('status', 1)
                    ->select('patient_no_pk', 'patient_code', 'patient_name', 'dob', 'gender_txt', 'mobile1', 'present_addr', 'email', 'status', 'patient_photo', 'ccm_client_name', 'ccm_client_code', 'contact_person', 'contact_no', 'contract_sign_date', 'agent_name', 'inform_text');

        if($request->input('hdn_patient_id') != '') {
            $items = $items->where('patient_no_pk', $request->input('hdn_patient_id'));
        }

        if($request->input('patient_gender') != '') {
            $items = $items->where('gender', $request->input('patient_gender'));
        }

        if($request->input('patient_age') != '') {
            $items = $items->where('age_yy', $request->input('patient_age'));
        }

        if($request->input('patient_nid') != '') {
            $items = $items->where('national_id', $request->input('patient_nid'));
        }

        if($request->input('patient_marital_status') != '') {
            $items = $items->where('marital_status', $request->input('patient_marital_status'));
        }

        if($request->input('patient_religion') != '') {
            $items = $items->where('religion', $request->input('patient_religion'));
        }

        if($request->input('patient_status') != '') {
            $items = $items->where('status', $request->input('patient_status'));
        }

        if($request->input('patient_blood') != '') {
            $items = $items->where('blood_group', $request->input('patient_blood'));
        }

        if($request->input('patient_type') != '') {
            $items = $items->where('patient_type_no_pk', $request->input('patient_type'));
        }

        if($request->input('corporate_name') != '') {
            $items = $items->where('ccm_client_no_pk', $request->input('corporate_name'));
        }

        if($request->input('search_date_from') != '') {
            $from_date = Carbon::parse($request->input('search_date_from'))->format('Y-m-d');
            $items = $items->whereDate('reg_date', '>=', $from_date);
        }

        if($request->input('search_date_to') != '') {
            $to_date = Carbon::parse($request->input('search_date_to'))->format('Y-m-d');
            $items = $items->whereDate('reg_date', '<=', $to_date);
        }

        $items = $items
                    ->orderByDesc('PATIENT_NO_PK')
                    ->get();

        $view = '';
        if(Session::get('user.ses_hospital_code') != 'IMPALA') {
            $view = Template::loadView("admin.patient.v1.registration_list_table_v1", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'patient_type' => $patient_type, 'corporate_code' => $corporate_code, 'items' => $items]);
        } else {
            $view = Template::loadView("admin.patient.v1.registration_list_table_impala_v1", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'patient_type' => $patient_type, 'corporate_code' => $corporate_code, 'items' => $items]);
        }

        return $view;
    }

    public function GeneralConsent(){
        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::table('sysc_generalconsent')->select('generalconsent_text')->where('status', 1)->get();

		$pdf = PDF::loadView("admin.patient.general_consent", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "data" => $data])->setPaper('a4', 'potrait');
		return $pdf->stream('General Consent.pdf');
    }

    public function PatientInformationPdf($id = ""){

        ini_set('max_execution_time', 0);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $data = DB::table('patient_info_vw AS p')->select('p.*',DB::raw('pat_age(p.dob,nvl(dod,sysdate))pat_age'))->where('p.patient_no_pk', '=', $id)->where('p.status',1)->first();

        // dd($data);

		$pdf = PDF::loadView("admin.patient.patient_information_pdf", ["type" => "pdf", "po_hospital_details" => $po_hospital_details, "data" => $data])->setPaper('a4', 'potrait');
		return $pdf->stream('Patient_Information.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadList()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        return Template::loadView("admin.patient.registration_list", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg]);
    }

    public function getAllPatients(Request $request)
    {
        $search_param = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $search_string = $request->searchdata;
        $search_dta_arr = parse_str($search_string, $search_param);

        $patient_id = $search_param["patient_id"];
        $hdn_patient_id = $search_param["hdn_patient_id"];
        $patient_gender = $search_param["patient_gender"];
        $patient_age = $search_param["patient_age"];
        $patient_nid = $search_param["patient_nid"];
        $patient_marital_status = $search_param["patient_marital_status"];
        $patient_religion = $search_param["patient_religion"];
        $patient_status = $search_param["patient_status"];

        $clause = ($where == "") ? " and " : " and ";
        $where .= ($hdn_patient_id != "") ? " $clause patient_no_pk=$hdn_patient_id" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_gender != "") ? " $clause gender=$patient_gender" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_age != "") ? " $clause age=$patient_age" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_nid != "") ? " $clause national_id=$patient_nid" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_marital_status != "") ? " $clause marital_status=$patient_marital_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_status != "") ? " $clause status=$patient_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_religion != "") ? " $clause religion=$patient_religion" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .=  "$clause status = 1";

        $table = 'patient_info_vw';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $columns = array(
            array('db' => 'patient_no_pk',   'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob',  'dt' => 3,'formatter'=>function($dob){
                $pat_dob = new \DateTime($dob);
                $current_date = new \DateTime();
                $pat_dob->modify('-1 day');
                $interval = $current_date->diff($pat_dob);
                return $interval->format('%yY %mM %dD');
            }),
            array('db' => 'gender_txt',   'dt' => 4),
            array('db' => 'mobile1',   'dt' => 5),
            array('db' => 'present_addr',   'dt' => 6),
            array('db' => 'email',   'dt' => 7),
            array('db' => 'status',   'dt' => 8),
            array('db' => 'patient_photo', 'dt' => 9),
            array('db' => 'ccm_client_name', 'dt' => 10),
            array('db' => 'ccm_client_code', 'dt' => 11),
            array('db' => 'contact_person', 'dt' => 12),
            array('db' => 'contact_no', 'dt' => 13),
            array('db' => 'contract_sign_date', 'dt' => 14),
            array('db' => 'agent_name', 'dt' => 15),
            array('db' => 'inform_text', 'dt' => 16),
        );
        // dd($sql_cond);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    /**
     * Get all Patient V1
     */
    public function getAllPatientsV1(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $items = DB::table("patient_info_vw")
                    ->where('au_entry_hospital_pk_no', $hospital_id)
                    ->where('status', 1)
                    ->select('patient_no_pk', 'patient_code', 'patient_name', 'dob', 'gender_txt', 'mobile1', 'present_addr', 'email', 'status', 'patient_photo', 'ccm_client_name', 'ccm_client_code', 'contact_person', 'contact_no', 'contract_sign_date', 'agent_name', 'inform_text')
                    ->orderByDesc('PATIENT_NO_PK')
                    ->get();

        return response()->json(["success" => true, "data" => $items], 200);
    }

    public function getHospitalAllPatients(Request $request)
    {
        $search_param = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "p.au_entry_hospital_pk_no = '$hospital_id'";
        $where = "p.au_entry_hospital_pk_no = $hospital_id";
        $search_string = $request->searchdata;
        $hdn_patient_id = ''; // $search_param["hdn_patient_id"];
        $patient_gender = ''; // $search_param["patient_gender"];
        $patient_age = ''; // $search_param["patient_age"];
        $patient_nid = ''; // $search_param["patient_nid"];
        $patient_marital_status = ''; // $search_param["patient_marital_status"];
        $patient_religion = ''; // $search_param["patient_religion"];
        $patient_status = ''; // $search_param["patient_status"];

        $clause = ($where == "") ? " and " : " and ";
        $where .= ($hdn_patient_id != "") ? " $clause p.patient_no_pk=$hdn_patient_id" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_gender != "") ? " $clause p.gender=$patient_gender" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_age != "") ? " $clause p.age=$patient_age" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_nid != "") ? " $clause p.national_id=$patient_nid" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_marital_status != "") ? " $clause p.marital_status=$patient_marital_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_status != "") ? " $clause p.status=$patient_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_religion != "") ? " $clause p.religion=$patient_religion" : "";
        // $clause = ($where == "") ? " where " : " and ";
        // $where .=  " $clause status = 1";

        $table = 'patient_info_vw  p';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $result = DB::select(
            DB::raw("SELECT p.patient_no_pk, p.patient_code, p.patient_name, p.dob, p.gender_txt, p.mobile1,
            p.email, p.status, p.patient_photo, p.ccm_client_name, p.ccm_client_code, p.contact_person, p.contact_no, p.contract_sign_date, p.age, p.patient_type_code, p.print_count,p.au_entry_at,wsec_user.user_fullname,p.au_update_at,entry_user.user_fullname as entry_user_name ,p.present_addr,p.guardian_name FROM $table left join wsec_user on wsec_user.user_no_pk = p.au_update_by left join wsec_user entry_user on entry_user.user_no_pk = p.au_entry_by WHERE $where order by patient_no_pk desc")
        );
        //    dd($result);
        return response()->json(['data' => $result]);
    }

    public function getHospitalAllPatientsOld(Request $request)
    {
        $search_param = [];
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $search_string = $request->searchdata;
        // $search_dta_arr = parse_str($search_string, $search_param);

        // $patient_id = $search_param["patient_id"];
        $hdn_patient_id = ''; // $search_param["hdn_patient_id"];
        $patient_gender = ''; // $search_param["patient_gender"];
        $patient_age = ''; // $search_param["patient_age"];
        $patient_nid = ''; // $search_param["patient_nid"];
        $patient_marital_status = ''; // $search_param["patient_marital_status"];
        $patient_religion = ''; // $search_param["patient_religion"];
        $patient_status = ''; // $search_param["patient_status"];

        $clause = ($where == "") ? " and " : " and ";
        $where .= ($hdn_patient_id != "") ? " $clause patient_no_pk=$hdn_patient_id" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_gender != "") ? " $clause gender=$patient_gender" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_age != "") ? " $clause age=$patient_age" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_nid != "") ? " $clause national_id=$patient_nid" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_marital_status != "") ? " $clause marital_status=$patient_marital_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_status != "") ? " $clause status=$patient_status" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .= ($patient_religion != "") ? " $clause religion=$patient_religion" : "";
        $clause = ($where == "") ? " where " : " and ";
        $where .=  " $clause status=1";

        $table = 'patient_info_vw';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $columns = array(
            array('db' => 'patient_no_pk',   'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob',  'dt' => 3),
            array('db' => 'gender_txt',   'dt' => 4),
            array('db' => 'mobile1',   'dt' => 5),
            array('db' => 'present_addr',   'dt' => 6),
            array('db' => 'email',   'dt' => 7),
            array('db' => 'status',   'dt' => 8),
            array('db' => 'patient_photo', 'dt' => 9),
            array('db' => 'ccm_client_name', 'dt' => 10),
            array('db' => 'ccm_client_code', 'dt' => 11),
            array('db' => 'contact_person', 'dt' => 12),
            array('db' => 'contact_no', 'dt' => 13),
            array('db' => 'contract_sign_date', 'dt' => 14),
            array('db' => 'age', 'dt' => 15),
            array('db' => 'patient_type_code', 'dt' => 16),
            array('db' => 'print_count', 'dt' => 17),

        );
        // dd($sql_cond);
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        // $columns = array(
        //     'sl',
        //     'patient_photo',
        //     'patient_code',
        //     'first_name',
        //     'age_yy',
        //     'gender_txt',
        //     'mobile1',
        //     'present_addr',
        //     'email',
        //     'status',
        //     'patient_no_pk',
        // );

        // $active = '<span class="badge badge-md badge-success"> Active</span>';
        // $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';

        // $sql = "SELECT '' as  sl, patient_photo,patient_code,patient_name first_name,age_dd, age_mm,age_yy,gender_txt,mobile1,present_addr,email, CASE WHEN status = 1 THEN '$active' ELSE '$inactive' END AS status, patient_no_pk, rownum rownumber,au_update_at,au_entry_at from patient_info_vw  $where";
        // $order_by_column = "patient_no_pk";

        // $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        // echo json_encode($json_data);

    }

    public function patientSearch(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        //$sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        //$where = "";

        // $patient_id = $search_param["patient_id"];
        $hdn_patient_id = $request->hdn_patient_id;
        $patient_gender = $request->patient_gender;
        $patient_age = $request->patient_age;
        $patient_nid = $request->patient_nid;
        $patient_marital_status = $request->patient_marital_status;
        $patient_religion = $request->patient_religion;
        $patient_status = $request->patient_status;
        $patient_blood = $request->patient_blood;
        $patient_type = $request->patient_type;
        $corporate_name = $request->corporate_name;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }



        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_id != "") ? " $clause patient_no_pk=$hdn_patient_id" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_gender != "") ? " $clause gender = $patient_gender" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_age != "") ? " $clause age_yy=$patient_age" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_nid != "") ? " $clause national_id=$patient_nid" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_marital_status != "") ? " $clause marital_status=$patient_marital_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_status != "") ? " $clause status=$patient_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_religion != "") ? " $clause religion=$patient_religion" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_blood != "") ? " $clause blood_group=$patient_blood" : "";

        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_type != "") ? " $clause patient_type_no_pk=$patient_type" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($corporate_name != "") ? " $clause ccm_client_no_pk=$corporate_name" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($date_from != "") ? " $clause trunc(reg_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .=  " $clause status=1";

        $table = 'patient_info_vw';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $columns = array(

            array('db' => 'patient_no_pk',   'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob',  'dt' => 3,'formatter'=>function($dob){

                $pat_dob = new \DateTime($dob);
                $current_date = new \DateTime();
                $pat_dob->modify('-1 day');
                $interval = $current_date->diff($pat_dob);
                return $interval->format('%yY %mM %dD');
            }),
            array('db' => 'gender_txt',   'dt' => 4),
            array('db' => 'mobile1',   'dt' => 5),
            array('db' => 'present_addr',   'dt' => 6),
            array('db' => 'email',   'dt' => 7),
            array('db' => 'status',   'dt' => 8),
            array('db' => 'patient_photo', 'dt' => 9),
            array('db' => 'ccm_client_name', 'dt' => 10),
            array('db' => 'ccm_client_code', 'dt' => 11),
            array('db' => 'contact_person', 'dt' => 12),
            array('db' => 'contact_no', 'dt' => 13),
            array('db' => 'contract_sign_date', 'dt' => 14),
            array('db' => 'agent_name', 'dt' => 15),
            array('db' => 'inform_text', 'dt' => 16),

        );
        if (!empty($where)) {

            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
        // return Template::loadView("admin.patient.registration_list_table");
    }

    public function patientPrint(Request $request, $id = '')
    {
        // dd($request->all());
        ini_set('max_execution_time',0);
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        //$sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        //$where = "";

        // $patient_id = $search_param["patient_id"];
        $hdn_patient_id = $request->hdn_patient_id;
        $patient_gender = $request->patient_gender;
        $patient_age = $request->patient_age;
        $patient_nid = $request->patient_nid;
        $patient_marital_status = $request->patient_marital_status;
        $patient_religion = $request->patient_religion;
        $patient_status = $request->patient_status;
        $patient_blood = $request->patient_blood;
        $patient_type = $request->patient_type;
        $corporate_name = $request->corporate_name;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }


        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_id != "") ? " $clause patient_no_pk=$hdn_patient_id" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_gender != "") ? " $clause gender = $patient_gender" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_age != "") ? " $clause age_yy=$patient_age" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_nid != "") ? " $clause national_id=$patient_nid" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_marital_status != "") ? " $clause marital_status=$patient_marital_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_status != "") ? " $clause status=$patient_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_religion != "") ? " $clause religion=$patient_religion" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_blood != "") ? " $clause blood_group=$patient_blood" : "";

        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_type != "") ? " $clause patient_type_no_pk=$patient_type" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($corporate_name != "") ? " $clause ccm_client_no_pk=$corporate_name" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($date_from != "") ? " $clause trunc(REG_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= " $clause status=1";

        $table = 'patient_info_vw';
        // Table's primary key
        $primaryKey = 'patient_no_pk';
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $print_data=DB::select('select * from patient_info_vw where $where');
        $print_data = DB::select(DB::raw("SELECT * FROM patient_info_vw WHERE $where order by REG_DATE asc"));

        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($id == "PDF") {
            $pdf = PDF::loadView("admin.patient.registration_list_pdf", ['print_data' => $print_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'print_type' => $id, 'from_date' => $date_from, 'to_date' => $date_to])->setPaper('a4', 'landscape');
            return $pdf->stream('individual_doctor_performance_details_report_pdf.pdf');
        } else {

            $pdf = ['print_data' => $print_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'print_type' => $id, 'from_date' => $date_from, 'to_date' => $date_to];

            $fileToExport = "registration_list_pdf";
            $html = View("admin.patient.registration_list_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            // header("Content-type: application/vnd.ms-excel");
            header("Content-type: text/csv");
            return $html;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($appoint_no_fk = '')
    {
          $appoint_data = '';
        if(!empty($appoint_no_fk)){
            $appoint_data = DB::table('PATN_APPOINTMENT')
                            ->select(
                                'patient_name',
                                'appoint_no_pk',
                                'PHONE_MOBILE',
                                'EMAIL',
                                'AGE_DD',
                                'AGE_MM',
                                'AGE_YY',
                                'GENDER',
                                'ADDRESS',
                                'DOB',
                                'BLOOD_GROUP',
                                
                                )
                            ->where('appoint_no_pk',$appoint_no_fk)
                            ->first();
            
        }
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $relationAll = $this->getLookupListByCodeAll("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $socialMediaList =[];// DB::table('SYSC_SOCIAL_MEDIA')->where('status',1)->get();
        $inform = $this->getLookupListByCode("INFORM");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.patient.registration", ['marital_status' => $marital_status,'inform' => $inform, 'gender' => $gender, 'religion' => $religion, 'relationAll' => $relationAll, 'bloodg' => $bloodg, 'relation' => $relation, 'page_type' => 'add', 'nationality' => $nationality, 'district' => $district, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info,'inform_agent_id' => '','inform_agent_name' => '','appoint_data' => $appoint_data,'socialMediaList' => $socialMediaList]);
    }

    public function patAllThanaPre(Request $request)
    {
        $doctor_present_thana = '';
        $thana = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $request->disct_value)->orderBy("name", "asc")->get();
        return Template::loadview("admin.patient.pre_thana", ['thana_pre' => $thana, 'doctor_present_thana' => $doctor_present_thana]);
    }
    public function patAllDivisionPre(Request $request)
    {
        $doctor_present_thana = '';
        $divisions = DB::table('sysc_divisions')->select('id', 'name')->where('country_id', $request->country_value)->orderBy("name", "asc")->get();
        $html = ' <option value="">State/Division</option>';
        if (!empty($divisions)) {
            foreach ($divisions as $div) {
                $html .= "   <option value='" . $div->id . "'>" . $div->name . "</option>";
            }
        }

        return $html;
    }
    public function patAllDistrictPre(Request $request)
    {
        $doctor_present_thana = '';
        $divisions = DB::table('sysc_district')->select('id', 'name')->where('division_id', $request->state_division)->orderBy("name", "asc")->get();
        $html = ' <option value="">Select District</option>';
        if (!empty($divisions)) {
            foreach ($divisions as $div) {
                $html .= "   <option value='" . $div->id . "'>" . $div->name . "</option>";
            }
        }

        return $html;
    }
    public function patAllThanaPer(Request $request)
    {
        $doctor_permanent_thana = '';
        $thana = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $request->disct_value)->orderBy("name", "asc")->get();

        return Template::loadview("admin.patient.per_thana", ['thana_per' => $thana, 'doctor_permanent_thana' => $doctor_permanent_thana]);
    }

    public function createQuickRegistration($id = '')
    {
        $billing = $id;
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $religion = $this->getLookupListByCode("RELIGION");
        $inform = $this->getLookupListByCode("INFORM");
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $registration_fee = Item::where('item_type', 'REGFEE')->first();
        if(Session::get('user.ses_hospital_code') == 'AMCSH'){
            if ($id != "") {
                return Template::loadView("admin.patient.patient_quick_registration", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            } else {
                return Template::loadView("admin.patient.patient_quick_registration_singel_amcsh", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            }

        }
        if(Session::get('user.ses_hospital_code') != 'IMPALA'){
            if ($id != "") {
                return Template::loadView("admin.patient.patient_quick_registration", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            } else {
                return Template::loadView("admin.patient.patient_quick_registration_singel", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            }

        }else{
            if ($id != "") {
                return Template::loadView("admin.patient.patient_quick_registration", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            } else {

                return Template::loadView("admin.patient.patient_quick_registration_singel_impala", ['religion' => $religion,'inform' => $inform, 'registration_fee' => $registration_fee, 'paymodes' => $paymodes, 'marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg, 'billing' => $billing, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info]);
            }

        }

    }

    public function calculatePatientAge(Request $request)
    {

        $currentDateTime = Carbon::now();

        if (empty($request->age_year) && empty($request->age_month)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subDays($request->age_day)->toDateString();
        } elseif (empty($request->age_day) && empty($request->age_year)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subMonths($request->age_month)->toDateString();
        } elseif (empty($request->age_day) && empty($request->age_month)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->toDateString();
        } elseif (!empty($request->age_year) && empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subDays($request->age_day)->toDateString();
        } elseif (!empty($request->age_year) && !empty($request->age_month) && empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subMonths($request->age_month)->toDateString();
        } elseif (empty($request->age_year) && !empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subMonths($request->age_month)->subDays($request->age_day)->toDateString();
        } elseif (!empty($request->age_year) && !empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subMonths($request->age_month)->subDays($request->age_day)->toDateString();
        }
        if(Session::get('user.ses_hospital_code') != 'IMPALA'){
            $newDateTime = $currentDateTime->format('m/d/Y');
        }else{
            $newDateTime = $currentDateTime->format('Y-m-d');
        }

        return response()->json(['patient_age' => $newDateTime], 200);
    }
    public function calculatePatientAgev2(Request $request)
    {
        $currentDateTime = Carbon::now();

        if (empty($request->age_year) && empty($request->age_month)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subDays($request->age_day)->toDateString();
        } elseif (empty($request->age_day) && empty($request->age_year)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subMonths($request->age_month)->toDateString();
        } elseif (empty($request->age_day) && empty($request->age_month)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->toDateString();
        } elseif (!empty($request->age_year) && empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subDays($request->age_day)->toDateString();
        } elseif (!empty($request->age_year) && !empty($request->age_month) && empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subMonths($request->age_month)->toDateString();
        } elseif (empty($request->age_year) && !empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subMonths($request->age_month)->subDays($request->age_day)->toDateString();

        } elseif (!empty($request->age_year) && !empty($request->age_month) && !empty($request->age_day)) {

            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->subYears($request->age_year)->subMonths($request->age_month)->subDays($request->age_day)->toDateString();

        }

        $newDateTime = $currentDateTime->format('d-m-Y');

        return response()->json(['patient_age' => $newDateTime], 200);
    }

    public function calculatePatientAgeByDate(Request $request)
    {


        $date = Carbon::parse($request->patient_dob);
        $now = Carbon::now();

        $diff = $date->diff($now)->format('%y years,%m months,%d days');



        $patient_dob = explode(",", $diff);

        $age_month = intval($patient_dob[1]);
        $age_day = intval($patient_dob[2]);
        $age_year = intval($patient_dob[0]);



        return response()->json(['new_month' => $age_month, 'new_day' => $age_day, 'new_year' => $age_year], 200);
    }
    public function calculatePatientAgeByDatev2(Request $request)
    {


        $date = date('Y-m-d', strtotime($request->patient_dob));
        $now = date('Y-m-d');

        $date1 = date_create($date);
        $date2 = date_create($now);
        $diff = date_diff($date1, $date2);

        $months = $diff->format("%m");
        $years = $diff->format("%y");
        $days = $diff->format("%d");


        // $patient_dob = explode(",", $diff);
        if ($months == 0 && $days == 0 && $years == 0) {
            $age_month = intval($months);
            $age_day = intval($days + 1);
            $age_year = intval($years);
        } else {
            $age_month = intval($months);
            $age_day = intval($days);
            $age_year = intval($years);
        }




        return response()->json(['new_month' => $age_month, 'new_day' => $age_day, 'new_year' => $age_year], 200);
    }

    public function patientStatistics()
    {
        return Template::loadView("admin.patient.patient_statistics");
    }

    // public function QuickRegistration()
    // {
    //     $marital_status = $this->getLookupListByCode("MARSTS");
    //     $gender = $this->getLookupListByCode("GENDER");
    //     $bloodg = $this->getLookupListByCode("BLOODG");

    //     return Template::loadView("admin.patient.patient_quick_registration", ['marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function PatientCard($id, $invoice_id = "")
    {
        // $data = $this->model->show($id);
        $hospital_code = Session::get('user.ses_hospital_code');
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $data = PatientRegistration::where('patient_no_pk', '=', $id)
            ->select('patient_no_pk','cor_member_no_pk', 'salutation', 'patient_name', 'patient_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'gender_txt', 'patient_photo')
            ->leftJoin('sysc_lookupdata ld', 'patn_registration.gender', '=', 'ld.lookupdata_no_pk')
            ->leftJoin('sysc_lookupdata ld2', 'patn_registration.blood_group', '=', 'ld2.lookupdata_no_pk')->first();
        // return $data;
        return Template::loadview("admin.patient.patient_card", ['invoice_no' => $invoice_id, 'data' => $data, 'po_hospital_details' => $po_hospital_details]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PateintRegistrationRequest $request)
    {
        // return $request;
        $validated = $request->validated();
        return $this->patRegRepository->createOrUpdate($request, $request->id);
    }
    public function storeV2(PateintRegistrationRequest $request)
    {
        // return $request;
        $validated = $request->validated();
        return $this->patRegRepository->createOrUpdateV2($request, $request->id);
    }

    public function storeQuickRegistration(PateintRegistrationRequest $request)
    {
        $validated = $request->validated();
        return $this->patRegRepository->CreateOrUpdateQuickRegister($request, $request->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('patient_info_vw AS p')->select('p.*',DB::raw('pat_age(p.dob,nvl(dod,sysdate))pat_age'))->where('p.patient_no_pk', '=', $id)->first();
        return Template::loadView("admin.patient.registration_view", [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //  $data = $this->doctor->show($id);
        // $data = $this->model->show($id);
        $data = PatientRegistration::getPatientWithPersonnel($id)[0];
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $relationAll = $this->getLookupListByCodeAll("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $thana_pre = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->present_district)->orderBy("name", "asc")->get();
        $thana_per = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->permanent_district)->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $inform = $this->getLookupListByCode("INFORM");
        // dd($data);

        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();


        $test = ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'data' => $data, 'relation' => $relation, 'nationality' => $nationality, 'district' => $district, 'page_type' => 'edit', 'name_prefix' => $name_prefix, 'thana_pre' => $thana_pre, 'thana_per' => $thana_per, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'inform' => $inform];
        if(Session::get('user.ses_hospital_code') != 'IMPALA'){
            return Template::loadView("admin.patient.registration_form_v2_data", ['marital_status' => $marital_status,'relationAll' => $relationAll, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'data' => $data, 'relation' => $relation, 'nationality' => $nationality, 'district' => $district, 'page_type' => 'edit', 'name_prefix' => $name_prefix, 'thana_pre' => $thana_pre, 'thana_per' => $thana_per, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'inform' => $inform]);
        }else{
            return Template::loadView("admin.patient.registration_form_v2_data_impala", ['marital_status' => $marital_status,'relationAll' => $relationAll, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'data' => $data, 'relation' => $relation, 'nationality' => $nationality, 'district' => $district, 'page_type' => 'edit', 'name_prefix' => $name_prefix, 'thana_pre' => $thana_pre, 'thana_per' => $thana_per, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'inform' => $inform]);
        }
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
    public function createOrUpdatePatientOnlineProfile(PateintRegistrationRequest $request)
    {
        $validated = $request->validated();
        return $this->patRegRepository->createOrUpdatePatientOnlineProfile($request, $request->id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPatientInfoById(Request $request)
    {
        $patient_info = $this->model->findByColumn('patient_code', $request->patient_id, ['patient_no_pk', 'first_name', 'last_name', 'gender_txt', 'dob']);
        if (!empty($patient_info)) {
            $msg = "<table class='table table-bordered border' style='width:50% !important; margin: auto;'><tr><th class='text-left'><input type='hidden' id='patient_id' name='patient_id' value='$patient_info->patient_no_pk' />Patient Name</th><td class='text-left'> $patient_info->first_name $patient_info->last_name </td></tr>";
            $msg .= "<tr><th class='text-left'>Patient Age</th><td class='text-left'> $patient_info->gender_txt </td></tr>";
            $msg .= "<tr><th class='text-left'>Patient DOB</th><td class='text-left'> " . date("d-M-Y", strtotime($patient_info->dob)) . "</td></tr>";
            return $message = ['msg' => $msg, 'title' => 'Success'];
        } else {
            return $message = ['msg' => 'Patient ID is not valid.', 'title' => 'Error'];
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patientInfoJson(Request $request)
    {

        $patient_info = DB::table('patient_info_vw')->select('patient_no_pk', 'patient_code', 'patient_name', 'gender_txt', 'marital_status_txt', 'dob', 'age', 'mobile1', 'blood_group_txt', 'father_name', 'mother_name', 'permanent_addr', 'emergency_contact_name', 'emergency_contact_relation', 'emergency_contact_contact','patient_type_code','ccm_client_name','patient_photo',DB::raw('pat_age(dob,nvl(dod,sysdate))pat_age'))->where('patient_no_pk', $request->patient_id)->first();
        
        $patient_data = [];
        //    dd( $request->patient_id, $patient_info);
        if (!empty($patient_info)) {
            $patient_data = array(
                'patient_id' => $patient_info->patient_no_pk,
                'patient_code' => $patient_info->patient_code,
                'patient_name' => $patient_info->patient_name,
                'age' => $patient_info->age,
                'gender' => $patient_info->gender_txt,
                'dob' => $patient_info->dob,
                'contact' => $patient_info->mobile1,
                'blood_group_txt' => $patient_info->blood_group_txt,
                'marital_status_txt' => $patient_info->marital_status_txt,
                'father_name' => $patient_info->father_name,
                'mother_name' => $patient_info->mother_name,
                'emergency_contact_name' => $patient_info->emergency_contact_name,
                'emergency_contact_relation' => $patient_info->emergency_contact_relation,
                'emergency_contact_contact' => $patient_info->emergency_contact_contact,
                'permanent_addr' => $patient_info->permanent_addr,
                'pat_age' => $patient_info->pat_age,
                'patient_type_code' => $patient_info->patient_type_code,
                'ccm_client_name' => $patient_info->ccm_client_name,
                'patient_photo' => $patient_info->patient_photo,

            );

            return $patient_data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patientInfoAutocomplete(Request $request)
    {
        return $this->getPatientAutocompleteList($request);
    }
    public function donorInfoAutocomplete(Request $request)
    {
        return $this->getDonorAutocompleteList($request);
    }
    public function patientIdInfoAutocomplete(Request $request)
    {
        return $this->getPatientIdAutocompleteList($request);
    }

    public function patientInfoBillingAutocomplete(Request $request)
    {
        return $this->getPatientAutocompleteBillList($request);
    }
    public function patientIdInfoBillingAutocomplete(Request $request)
    {
        return $this->getPatientIdAutocompleteBillList($request);
    }
    public function patientAppointmentInfoBillingAutocomplete(Request $request)
    {
        return $this->getAppointmnetPatientAutocompleteBillList($request);
    }

    // public function getAllPatients(Request $request)
    // {
    //     $columns = array(
    //         array( 'db' => 'patient_no_pk' ),
    //         array( 'db' => 'patient_code' ),
    //         array( 'db' => 'first_name' ),
    //         array( 'db' => 'age_yy' ),
    //         array( 'db' => 'gender_txt' ),
    //         array( 'db' => 'mobile1' ),
    //         array( 'db' => 'present_addr' ),
    //         array( 'db' => 'email' ),
    //         array( 'db' => 'p_status' )
    //     );

    //     $active = '<i class="fa fa-circle online text-success"><small style="color: #92959E"> Active</small></i>';
    //     $inactive = '<i class="fa fa-circle offline text-danger"><small style="color: #92959E"> Inactive</small></i>';

    //     $sql = "SELECT a.patient_no_pk,a.patient_code,a.patient_name first_name,a.age_dd, a.age_mm,a.age_yy,a.gender_txt,a.mobile1,a.present_addr,a.email, CASE WHEN a.status = 1 THEN '$active' ELSE '$inactive' END AS p_status, rownum rownumber,au_update_at,au_entry_at from patn_registration a";
    //     $order_by_column = "patient_name";

    //     $json_data = $this->datatable( $request, $sql, $order_by_column, 'DESC', $columns );

    //     echo json_encode($json_data);

    // }

    public function admissionInfoAutocomplete(Request $request)
    {
        return $this->getAdmissionAutocompleteList($request);
    }
    public function admissionInfoGetData(Request $request)
    {
        return $this->getAdmissionGetData($request);
    }
    public function admissionInfoGetDataByBed(Request $request)
    {
        return $this->getAdmissionGetDataByBed($request);
    }

    public function prescriptionInfoAutocomplete(Request $request)
    {
        return $this->getPrescriptionAutocompleteList($request);
    }
    public function prescriptionInfoGetData(Request $request)
    {
        return $this->getPrescriptionGetData($request);
    }

    public function prescriptionItemInfo(Request $request)
    {
        $prescription_no_pk = $request->prescription_no_pk;
        $corporate_id = $request->corporate_no ? $request->corporate_no : 0;
        $patient_type = $request->patient_type != "" ? $request->patient_type : 0;
        $admission_id = $request->admission_id != "" ? $request->admission_id : "";

        // dd($request->patient_id);
        $testCoveragePercentages =0;
        if (Session::get('user.ses_hospital_code') == "DMHL") {
            $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$request->patient_id)->first();
            $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502';
            $typeCode ='01' ;
          if ($input_value !="") {

            $requestData = [
                'ByUserId' => '8415',
                'PersonId' => '121529',
                'MobileNumber' => '-',
                'UserName' => 'info@divinemercyhospital.com',
                'SearchText' => $input_value, // Replace with your actual input value
                'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                'DiscountTypeCode'=>'01',
                'RequestFrom' => 'HIS'
            ];

            // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';

            $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
            $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';

            // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
            // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

            $client = new Client();

            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'token' => $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $data = json_decode($body, true);
            // dd( $data);
            if (isset($data['Data'])) {
                $dataInside = json_decode($data['Data'], true);
                if (isset($dataInside[0]['TestCoveragePercentages'])) {
                    $testCoveragePercentages = $dataInside[0]['TestCoveragePercentages'];
                }
            }
         }
            // dd($testCoveragePercentages);
        }






        $item = DB::table("psn_t_prescription_dtl_vw")->whereIn('item_type', ["SERVICE", "LAB", "RAD", "IPD", "BED", "SUR", "AMB", "FOOD", "PTET", "PTTE", "OPD", "COMS", "ADM", "OT"])
            ->where("prescription_no_fk", $prescription_no_pk)
            ->get();

        $item_arr = [];
        $item_details_arr = [];
        // DB::executeFunction("pkg_corporate.fnc_get_item_rate", ["in_item_no_pk"=>$details->lookupdata_item_no_fk,"corporate_id" => $corporate_id,"in_current_rate"=>$details->sales_price], PDO::PARAM_INT)
        if (!empty($item)) {
            $apiDiscount_ind=0;
            $discounttypecode=02;
            foreach ($item as $details) {
                $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                $discount = $details->default_discount != "" ? $details->default_discount : 0;
                $item_type_no = DB::table('sysc_itemtype')->where('itemtype_code', $details->item_type)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->first();
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details->lookupdata_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                $ipd_charge = [];
                $sales_price = 0;
                $ipd_charge_prc = 0;
                if ($admission_id != "") {
                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));

                    if ($ipd_charge[0]->ipd_charge_amt != null) {
                        $ipd_charge_prc = $details->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;
                        $sales_price = round($details->sales_price + $ipd_charge_prc);
                    }
                } else {
                    $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                }
                if ($testCoveragePercentages  > 0 && $details->disc_aplicable != 1) {
                    $discount_perc=$testCoveragePercentages ;
                    $apiDiscount_ind=1;
                 }else {
                     $discount_perc=$def_dis[0]->def_discount  != "" && $details->disc_aplicable != 1 ?  $def_dis[0]->def_discount :0 ;
                 }
                // dd($sales_price);
                $item_arr[$details->lookupdata_item_no_fk] = [
                    "serviceunit_name" => $details->serviceunit_name,
                    "lookupdata_item_no_fk" => $details->lookupdata_item_no_fk,
                    "prescrition_data" => htmlspecialchars($details->prescrition_data, ENT_QUOTES),
                    "lookupdata_uid" =>  $details->lookupdata_uid,
                    "sales_price" => $sales_price,
                    "vat_percent" =>  $details->vat_percent,
                    "manual_item_rate_ind" =>  $details->manual_item_rate_ind,
                    "item_type" =>  !empty($item_type_no->par_itemtype_no_fk) ? $item_type_no->par_itemtype_no_fk :'',
                    "urgent_fee_amt" =>  $details->urgent_fee_amt,
                    "item_code" =>  $details->item_code,
                    "item_id" =>  $details->item_code,
                    "discount_cal" => $details->disc_aplicable != null ? $details->disc_aplicable : 0,
                    "default_discount" => $discount_perc,
                    'apiDiscount_ind' => $apiDiscount_ind,
                    'discounttypecode' => $discounttypecode,
                    "ipd_charge_prc" => $ipd_charge_prc,

                ];
                $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();
                //discount_cal 1 used for not calculating discount in service billing
                if (!empty($details_items)) {
                    foreach ($details_items as $details_item_auto) {
                        $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                            "serviceunit_name" => $details_item_auto->serviceunit_name,
                            "lookupdata_item_no_fk" => $details_item_auto->auto_item_no_fk,
                            "prescrition_data" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                            "lookupdata_uid" =>  "LAB",
                            "sales_price" =>  $details_item_auto->sales_price,
                            "vat_percent" =>  $details_item_auto->vat_percent,
                            "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                            "item_type" =>  $details_item_auto->itemtype_no_fk,
                            "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                            "item_code" =>  $details_item_auto->item_code,
                            "item_id" =>  $details_item_auto->item_code,
                            "discount_cal" => $details_item_auto->disc_aplicable != null ?  $details_item_auto->disc_aplicable : 0,
                            "default_discount" => $discount_perc,
                            'apiDiscount_ind' => $apiDiscount_ind,
                            'discounttypecode' => $discounttypecode,
                            "ipd_charge_prc" => 0,
                        ];
                    }
                }
            }
        }
        //dd($item_details_arr);
        $item_arr =   array_merge($item_arr, $item_details_arr);
        //dd($item_arr, $item);
        $auto_item = 0;


        return  json_encode($item_arr);

        // return $this->getPrescriptionAutocompleteList($request);
    }
    public function prescriptionItemInfoV1(Request $request)
    {
        $prescription_no_pk = $request->prescription_no_pk;
        $corporate_id = $request->corporate_no ? $request->corporate_no : 0;
        $patient_type = $request->patient_type != "" ? $request->patient_type : 0;
        $admission_id = $request->admission_id != "" ? $request->admission_id : "";
        $item = DB::table("psn_t_prescription_dtl_vw")->where("prescription_no_fk", $prescription_no_pk)->get();

        $item_arr = [];
        $item_details_arr = [];
        
        $age_years = 0;
        if ($patient_type =="STAFFDEPENDENTCHILD") {
            $birth_date = $request->dob !='' ? date('Y-m-d',strtotime($request->dob)):'' ;
            if ( $birth_date !='') {
                $current_date = date('Y-m-d');
                $birth_date_obj = new DateTime($birth_date);
                $current_date_obj = new DateTime($current_date);
                $diff = $current_date_obj->diff($birth_date_obj);
                $age_years = $diff->y;
            }
            $max_age_discount=DB::table('sysc_discountpolicy')->where('dispolicy_code', $patient_type)->value('max_age')??0;
            // dd( $max_age_discount, $age_years);
            if ($max_age_discount > 0 && $age_years > $max_age_discount) {
                 $patient_type ="GENERAL";
            }           
        }
        // DB::executeFunction("pkg_corporate.fnc_get_item_rate", ["in_item_no_pk"=>$details->lookupdata_item_no_fk,"corporate_id" => $corporate_id,"in_current_rate"=>$details->sales_price], PDO::PARAM_INT)
        if (!empty($item)) {
            foreach ($item as $details) {
                $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                $discount = $details->default_discount != "" ? $details->default_discount : 0;
                $item_type_no = DB::table('sysc_itemtype')->where('itemtype_code', $details->item_type)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->first();
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details->lookupdata_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                $ipd_charge = [];

                // $sales_price = 0;
                $ipd_charge_prc = 0;
                if ($admission_id != "") {

                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));

                    if ($ipd_charge[0]->ipd_charge_amt != null) {
                        $ipd_charge_prc = $details->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;
                        // $sales_price = round($details->sales_price + $ipd_charge_prc);
                    }
                } else {
                    $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                }

                $item_arr[$details->lookupdata_item_no_fk] = [
                    "serviceunit_name" => $details->serviceunit_name,
                    "lookupdata_item_no_fk" => $details->lookupdata_item_no_fk,
                    "prescrition_data" => htmlspecialchars($details->prescrition_data, ENT_QUOTES),
                    "lookupdata_uid" =>  $details->lookupdata_uid,
                    "sales_price" => $sales_price,
                    "vat_percent" =>  $details->vat_percent,
                    "manual_item_rate_ind" =>  $details->manual_item_rate_ind,
                    "item_type" =>   !empty($item_type_no->par_itemtype_no_fk) ? $item_type_no->par_itemtype_no_fk :'',
                    "urgent_fee_amt" =>  $details->urgent_fee_amt,
                    "item_code" =>  $details->item_code,
                    "item_id" =>  $details->item_code,
                    "discount_cal" => $details->disc_aplicable != null ? $details->disc_aplicable : 0,
                    "default_discount" => $def_dis[0]->def_discount != "" && $details->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                    "ipd_charge_prc" => $ipd_charge_prc,

                ];
                $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();
                //discount_cal 1 used for not calculating discount in service billing
                if (!empty($details_items)) {
                    foreach ($details_items as $details_item_auto) {
                        $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                            "serviceunit_name" => $details_item_auto->serviceunit_name,
                            "lookupdata_item_no_fk" => $details_item_auto->auto_item_no_fk,
                            "prescrition_data" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                            "lookupdata_uid" =>  "LAB",
                            "sales_price" =>  $details_item_auto->sales_price,
                            "vat_percent" =>  $details_item_auto->vat_percent,
                            "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                            "item_type" =>  $details_item_auto->itemtype_no_fk,
                            "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                            "item_code" =>  $details_item_auto->item_code,
                            "item_id" =>  $details_item_auto->item_code,
                            "discount_cal" => $details_item_auto->disc_aplicable != null ?  $details_item_auto->disc_aplicable : 0,
                            "default_discount" => $def_dis[0]->def_discount != "" && $details_item_auto->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                            "ipd_charge_prc" => 0,
                        ];
                    }
                }
            }
        }
        //dd($item_details_arr);
        $item_arr =   array_merge($item_arr, $item_details_arr);
        // dd($item_ar  r, $item);
        $auto_item = 0;


        return  json_encode($item_arr);

        // return $this->getPrescriptionAutocompleteList($request);
    }
    public function admissionItemInfo(Request $request)
    {
        $admission_id = $request->admission_no_pk;
        $corporate_id = $request->corporate_id ? $request->corporate_id : 0;
        $patient_type = $request->patient_type ? $request->patient_type : 0;
        // dd($admission_id);
        // $item=DB::table("psn_t_prescription_dtl_vw")->where("prescription_no_fk",$prescription_no_pk)->get();
        $item = DB::table("psn_t_prescription_dtl_vw")->where("admission_pk_no", $admission_id)->get();

        $item_arr = [];
        $item_details_arr = [];
        if (!empty($item)) {
            foreach ($item as $details) {
                $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                $discount = $details->default_discount != "" ? $details->default_discount : 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details->lookupdata_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                $item_type_no =  DB::table('sysc_itemtype')->where('itemtype_code', $details->item_type)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->first();
                $ipd_charge = [];
                $ipd_charge_prc = 0;
                // $sales_price = 0;
                if ($admission_id != "") {

                    // dd( $admission_id, $details->lookupdata_item_no_fk,$corporate_id, $sales_price,$discount, 'belall');
                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));

                    if ($ipd_charge[0]->ipd_charge_amt != null) {

                        $ipd_charge_prc = $details->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;

                        $sales_price = round($details->sales_price + number_format($ipd_charge_prc));

                    }
                } else {
                    $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                }

                $item_arr[$details->lookupdata_item_no_fk] = [
                    "serviceunit_name" => $details->serviceunit_name,
                    "lookupdata_item_no_fk" => $details->lookupdata_item_no_fk,
                    "prescrition_data" => htmlspecialchars($details->prescrition_data, ENT_QUOTES),
                    "lookupdata_uid" =>  $details->lookupdata_uid,
                    "sales_price" =>  $sales_price,
                    "vat_percent" =>  $details->vat_percent,
                    "manual_item_rate_ind" =>  $details->manual_item_rate_ind,
                    "item_type" =>  !empty($item_type_no->par_itemtype_no_fk) ? $item_type_no->par_itemtype_no_fk :'',
                    "urgent_fee_amt" =>  $details->urgent_fee_amt,
                    "item_code" =>  $details->item_code,
                    "item_id" =>  $details->item_code,
                    "discount_cal" =>  $details->disc_aplicable != null ? $details->disc_aplicable : 0,
                    'default_discount' => $def_dis[0]->def_discount != "" && $details->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                    'ipd_charge_prc' => $ipd_charge_prc

                ];
                $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();
                //discount_cal 1 used for not calculating discount in service billing
                if (!empty($details_items)) {
                    foreach ($details_items as $details_item_auto) {
                        $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                            "serviceunit_name" => $details_item_auto->serviceunit_name,
                            "lookupdata_item_no_fk" => $details_item_auto->auto_item_no_fk,
                            "prescrition_data" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                            "lookupdata_uid" =>  "LAB",
                            "sales_price" =>  $details_item_auto->sales_price,
                            "vat_percent" =>  $details_item_auto->vat_percent,
                            "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                            "item_type" =>  $details_item_auto->itemtype_no_fk,
                            "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                            "item_code" =>  $details_item_auto->item_code,
                            "item_id" =>  $details_item_auto->item_code,
                            "discount_cal" => $details_item_auto->disc_aplicable != null ? $details_item_auto->disc_aplicable : 0,
                            'default_discount' => $def_dis[0]->def_discount != "" && $details_item_auto->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                            'ipd_charge_prc' => 0
                        ];
                    }
                }
            }
        }
        // dd(array_merge($item_arr, $item_details_arr));
        $item_arr =   array_merge($item_arr, $item_details_arr);
        return  json_encode($item_arr);

        // return $this->getPrescriptionAutocompleteList($request);
    }
    public function admissionItemInfoV1(Request $request)
    {
        $admission_id = $request->admission_no_pk;
        $corporate_id = $request->corporate_id ? $request->corporate_id : 0;
        $patient_type = $request->patient_type ? $request->patient_type : 0;
        // dd($admission_id);
        // $item=DB::table("psn_t_prescription_dtl_vw")->where("prescription_no_fk",$prescription_no_pk)->get();
        $item = DB::table("psn_t_prescription_dtl_vw")->where("admission_pk_no", $admission_id)->get();
        // dd($item);
        $item_arr = [];
        $item_details_arr = [];
        if (!empty($item)) {
            foreach ($item as $details) {
                $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                $discount = $details->default_discount != "" ? $details->default_discount : 0;
                $rate = DB::select(DB::raw("select pkg_corporate.fnc_get_item_rate ($details->lookupdata_item_no_fk,$corporate_id,$sales_price) as item_rate from dual"));
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount ($details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as def_discount from dual"));
                $item_type_no =  DB::table('sysc_itemtype')->where('itemtype_code', $details->item_type)->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->first();

                $ipd_charge = [];
                $ipd_charge_prc = 0;
                // $sales_price = 0;
                if ($admission_id != "") {
                    // dd( $admission_id, $details->lookupdata_item_no_fk,$corporate_id, $sales_price,$discount, 'belall');
                    $ipd_charge = DB::select(DB::raw("select pkg_corporate.fnc_get_item_add_charge(0,$admission_id,'IPD',$details->lookupdata_item_no_fk,'$patient_type',$corporate_id, $sales_price,0,$discount,'PCT') as ipd_charge_amt from dual"));
                    if ($ipd_charge[0]->ipd_charge_amt != null) {
                        $ipd_charge_prc = $details->sales_price *  $ipd_charge[0]->ipd_charge_amt / 100;
                        // $sales_price = round($details->sales_price + $ipd_charge_prc);
                    }
                } else {
                    $sales_price = $details->sales_price != "" ? $details->sales_price : 0;
                }

                $item_arr[$details->lookupdata_item_no_fk] = [
                    "serviceunit_name" => $details->serviceunit_name,
                    "lookupdata_item_no_fk" => $details->lookupdata_item_no_fk,
                    "prescrition_data" => htmlspecialchars($details->prescrition_data, ENT_QUOTES),
                    "lookupdata_uid" =>  $details->lookupdata_uid,
                    "sales_price" =>  $sales_price,
                    "vat_percent" =>  $details->vat_percent,
                    "manual_item_rate_ind" =>  $details->manual_item_rate_ind,
                    "item_type" =>  !empty($item_type_no->par_itemtype_no_fk) ? $item_type_no->par_itemtype_no_fk :'' ,
                    "urgent_fee_amt" =>  $details->urgent_fee_amt,
                    "item_code" =>  $details->item_code,
                    "item_id" =>  $details->item_code,
                    "discount_cal" =>  $details->disc_aplicable != null ? $details->disc_aplicable : 0,
                    'default_discount' => $def_dis[0]->def_discount != "" && $details->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                    'ipd_charge_prc' => $ipd_charge_prc

                ];

                $details_items = DB::table("SYSC_SERVICEITEM_AUTO_VW")->where('item_no_fk', $details->lookupdata_item_no_fk)->get();

                //discount_cal 1 used for not calculating discount in service billing
                if (!empty($details_items)) {
                    foreach ($details_items as $details_item_auto) {
                        $item_details_arr[$details_item_auto->auto_item_no_fk] = [
                            "serviceunit_name" => $details_item_auto->serviceunit_name,
                            "lookupdata_item_no_fk" => $details_item_auto->auto_item_no_fk,
                            "prescrition_data" => htmlspecialchars($details_item_auto->item_name, ENT_QUOTES),
                            "lookupdata_uid" =>  "LAB",
                            "sales_price" =>  $details_item_auto->sales_price,
                            "vat_percent" =>  $details_item_auto->vat_percent,
                            "manual_item_rate_ind" =>  $details_item_auto->manual_item_rate_ind,
                            "item_type" =>  $details_item_auto->itemtype_no_fk,
                            "urgent_fee_amt" =>  $details_item_auto->urgent_fee_amt,
                            "item_code" =>  $details_item_auto->item_code,
                            "item_id" =>  $details_item_auto->item_code,
                            "discount_cal" => $details_item_auto->disc_aplicable != null ? $details_item_auto->disc_aplicable : 0,
                            'default_discount' => $def_dis[0]->def_discount != "" && $details_item_auto->disc_aplicable != 1 ? $def_dis[0]->def_discount : 0,
                            'ipd_charge_prc' => 0
                        ];
                    }
                }
            }
        }
        // dd($item_details_arr);
        $item_arr =   array_merge($item_arr, $item_details_arr);
        return  json_encode($item_arr);

        // return $this->getPrescriptionAutocompleteList($request);
    }
    public function prescriptionItemInfoPos(Request $request)
    {

        $testCoveragePercentages =0;

        if (Session::get('user.ses_hospital_code') == "DMHL" && $request->patient_no !='') {

            $get_card_no=DB::table('patn_registration')->select('cardnumber')->where('patient_no_pk',$request->patient_no)->first();

            $input_value =!empty( $get_card_no) ? $get_card_no->cardnumber:'';//'0004169502'; // Assuming 'input_value' comes from your form
            //   dd($patient_id , $input_value);
            // !empty( $get_card_no) ? $get_card_no->cardnumber:'';//
            $typeCode ='01' ; // Assuming it's an array and you need the first element
          if ($input_value !="") {

            $requestData = [
                'ByUserId' => '8415',
                'PersonId' => '121529',
                'MobileNumber' => '-',
                'UserName' => 'info@divinemercyhospital.com',
                'SearchText' => $input_value, // Replace with your actual input value
                'TypeCode' => $typeCode, // Replace with your actual TypeCode value
                'DiscountTypeCode'=>'01',
                'RequestFrom' => 'HIS'
            ];

            // $apiUrl ='https://webapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';


            $apiUrl ='https://hisapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';// 'https://webapi.cccul.com/api/HIS_V1/GetMembershipInfo';
            // $token = 'kOhNR/cQrqfOy5tSG1/KkTy2CJwThde3rc32WWesuEaBPtxQXuURyMLaTGdnk4H+QoNuG3rv/5t31mtreOHzHaEsaV59BlMaXM+nZ9ilSNrpG9g3IhEiz95c8P8MlYMjeMWtQiOnU/ANcq0wY5tNkv/YjBg5paYF+22T+nSDtMAb51laQxATDDubjHiGHLMRmUSnauZRKBrH7112K3vwxLnLbkYG4st8wupEhSAMTl+wGOXPnIUt7dmp1EBdLsTT2rnHa9dUgldOXGB0k14dp/eMrudAIucl0dDive1+iyhAhP8kXR9qYDMzffL7GBb4';
            $token = 'kOhNR/cQrqfOy5tSG1/KkQIUBInj2JsnTuHS5TNEobv8Oigr7i/AdcLJP5uAlFC7S/8w7lXG+rGHsXiJevHiKSLF0NtzZ0nGQVSbl00LZ0OVdIsZkou4GPJ4sEPy/W9uUzkE5S/y0h2zDbWKvZFyF4ks66XdCa3NylnEepahlMf9X5ozF4DjRXaiO8F3TCQavW33ljKwhFAg3EEyBlb+BqXCOWHR7fbA9Cqqb7q7tV0dCko4kOqw570XMXc0Joz/yd1zkloyiA4cmYJYOXFOqu3nSt6Lad63sn1AMrGfxfbUIHz4ZYH51HlFV/zh9WYa';


            // $apiUrl ='https://hisstagingapi.cccul.com/api/HIS_V1/GetPersonInsuranceCoverage';
            // $token = 'kOhNR/cQrqfOy5tSG1/Kkff4VrRkYXbS8FOqSmrsAKD5Zc5A6nCxlrrdglnslH8fDeh0nZy4+TLEAJSCp16/CW6oGMtvZ7SS6Bbi/jIKHSuWe5yZBjaYX5m3H8b5JTU0lKTXvoh3ww1PCTN5Ukl2xU0CRwOAEXFbf9XQZ+oHo2NynUSDQ9r4goOx0OPsbkFMUO7G3L4iLDMYC5y46H+Yj1pUSkZnmt3oEy/3AIJOG54tSG0zHpCCTpl9YVugXwAwuPXLvnoOSZ3RwEDKcLRxvdOH7gVJjNjRpkgf92WfwmLS172JC/GPFQYooyl7LZtn';

            $client = new Client();

            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'token' => $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $data = json_decode($body, true);
            if (isset($data['Data'])) {
                $dataInside = json_decode($data['Data'], true);
                if (isset($dataInside[0]['MedicineCoveragePercentages'])) {
                    $testCoveragePercentages = $dataInside[0]['MedicineCoveragePercentages'];
                }
            }
         }
            // dd($testCoveragePercentages);
        }
        $apiDiscount_type=$testCoveragePercentages > 0? 1 :0;
        $prescription_no_pk = $request->prescription_no_pk;
        $service_point=$request->service_point;
        $subquery = DB::table('stockledger_vw_itemwise')
        ->select('item_no_fk', 'current_stock')
        ->where('stock_su_no_fk', $service_point);
            // dd( $subquery->get());
        $item = DB::table("psn_t_prescription_med_vw")
        ->selectRaw('psn_t_prescription_med_vw.*, subquery.current_stock as storeQty ,sysc_serviceitem.disc_aplicable,sysc_serviceitem.default_discount_pct,? as api_percentages , ? as api_discount_type', [$testCoveragePercentages, $apiDiscount_type])
        ->leftJoin('sysc_serviceitem','sysc_serviceitem.item_no_pk','=','psn_t_prescription_med_vw.item_no_fk')
        ->leftJoinSub($subquery, 'subquery', function ($join) {
            $join->on('psn_t_prescription_med_vw.item_no_fk', '=', 'subquery.item_no_fk');
        })
        ->where("prescription_no_fk", $prescription_no_pk)
        ->get();
        // dd( $item);
        return  json_encode($item);
    }
    public function prescriptionItemInfoPosV2(Request $request)
    {

        $prescription_no_pk = $request->prescription_no_pk;
        $service_point=$request->service_point;
        $subquery = DB::table('stockledger_vw_itemwise')
        ->select('item_no_fk', 'current_stock')
        ->where('stock_su_no_fk', $service_point);
        $item = DB::table('psn_t_prescription_med_vw_v2')
        ->select(
            'psn_t_prescription_med_vw_v2.uom_name',
            'psn_t_prescription_med_vw_v2.expireable',
            'psn_t_prescription_med_vw_v2.dealer_sales_price',
            'psn_t_prescription_med_vw_v2.item_type',
            'psn_t_prescription_med_vw_v2.item_no_fk',
            'psn_t_prescription_med_vw_v2.sales_price',
            'psn_t_prescription_med_vw_v2.uom_no_fk',
            'psn_t_prescription_med_vw_v2.item_name',
            'psn_t_prescription_med_vw_v2.item_code',
            'psn_t_prescription_med_vw_v2.prescription_uid',
            'psn_t_prescription_med_vw_v2.patient_no_fk',
            'sysc_serviceitem.disc_aplicable',
            'sysc_serviceitem.default_discount_pct',
            'sysc_serviceitem.generic_no_fk',
            'subquery.current_stock'
        )
        // ->leftJoin('stockledger_vw_itemwise l', 'psn_t_prescription_med_vw_v2.item_no_fk', '=', 'l.item_no_fk')
        ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'psn_t_prescription_med_vw_v2.item_no_fk')
        ->leftJoinSub($subquery, 'subquery', function ($join) {
            $join->on('psn_t_prescription_med_vw_v2.item_no_fk', '=', 'subquery.item_no_fk');
        })
        ->where('psn_t_prescription_med_vw_v2.prescription_no_fk', $prescription_no_pk)
        // ->where(function($query) use ($service_point) {
        //     $query->where('l.stock_su_no_fk', $service_point)
        //           ->orWhereNull('l.stock_su_no_fk');
        // })
        ->get();


         $item_info = [];

        if ($item) {

            foreach ($item as $index=> $value) {
                $discount_perc=0;
                
                    $discount_perc_ptc=$value->default_discount_pct ?? 0 ;
                   
                    if (Session::get('user.ses_hospital_code')=="UNICO" && $value->patient_no_fk !='') {
                        $patInfo =DB::table('pat_registration_wl_vw')->select('ccm_client_no_fk','patient_type_code')->where('patient_no_pk',$value->patient_no_fk)->first();
                        $patient_type=!empty($patInfo) && $patInfo->patient_type_code !='' ? $patInfo->patient_type_code:0; 
                        $corporate_id=!empty($patInfo) && $patInfo->ccm_client_no_fk !='' ? $patInfo->ccm_client_no_fk:0; 
                        $discount_perc_value =DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_fk,'$patient_type',$corporate_id, $value->sales_price,0,$discount_perc_ptc,'PCT') as def_discount from dual"));
                        $discount_perc=$discount_perc_value[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  floatval($discount_perc_value[0]->def_discount) :0 ;
                       
                        
                    }else{
                         $discount_perc=$value->default_discount_pct ?? 0 ;
                    }
                   
                    // if ($index ==1) {
                    //         dd($value->item_no_fk,$patient_type,$corporate_id, $value->sales_price,$discount_perc_ptc,$discount_perc_value, $discount_perc);
                    // }


                //echo $value->item_no_pk; exit;

                $item_info[] = array(
                    'uom_name'              => ucfirst($value->uom_name),
                    'dealer_sales_price'    => $value->dealer_sales_price,
                    'item_type'             => $value->item_type,
                    'item_no_fk'            => $value->item_no_fk,
                    'sales_price'           => $value->sales_price,
                    'uom_no_fk'             => $value->uom_no_fk,
                    'item_name'             => $value->item_name,
                    'item_code'             => $value->item_code,
                    'prescription_uid'      => $value->prescription_uid,
                    'disc_aplicable'        => $value->disc_aplicable,
                    'default_discount_pct'  => $discount_perc,
                    'generic_no_fk'         => $value->generic_no_fk,
                    'current_stock'         => $value->current_stock,
                   
                );
            }
        }
        //   dd($service_point,$item_info);
        return  json_encode($item_info);
    }


    public function getGenericItem($generic_no="",$service_no="",$item_id="")
    {
        // $item =$generic_no !="null" ?  DB::table("sysc_serviceitem")->select('sysc_serviceitem.*')->where("generic_no_fk", $generic_no)->where('status',1)->get():[];
        $item =$generic_no !="null" ?
        DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockledger_vw_itemwise l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->leftJoin('sysc_serviceitem_uom uom', 'uom.uom_no_pk', '=', 's.uom_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                'uom.uom_code as uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.disc_aplicable',
                's.default_discount as default_discount_pct',
                's.expireable',
                'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.vat_percent',
                's.generic_name',
                's.generic_no_fk',
                's.supplier_name',

            )
            ->where("s.generic_no_fk", $generic_no)
            ->where('s.status',1)
            ->where('l.stock_su_no_fk',$service_no)
            ->where('l.current_stock','>',0)
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy("s.item_name")
            ->get()
        :[];
        // dd($item);
        return Template::loadView("admin.billing.pharmacy.get_generic_item", ['item' => $item,'item_id'=>$item_id,'service_no'=>$service_no]);


    }
    public function getGenericItemV2($generic_no="",$service_no="",$item_id="")
    {
        // $item =$generic_no !="null" ?  DB::table("sysc_serviceitem")->select('sysc_serviceitem.*')->where("generic_no_fk", $generic_no)->where('status',1)->get():[];
        $item =$generic_no !="null" ?
        DB::table('sysc_serviceitem_vw s')
            ->leftJoin('stockledger_vw_itemwise l', 's.item_no_pk', '=', 'l.item_no_fk')
            ->leftJoin('sysc_serviceunit ser', 'ser.serviceunit_no_pk', '=', 'l.stock_su_no_fk')
            ->leftJoin('sysc_serviceitem_uom uom', 'uom.uom_no_pk', '=', 's.uom_no_fk')
            ->select(
                's.item_no_pk',
                's.item_name',
                's.purchase_price',
                's.sales_price',
                's.item_code',
                's.serviceunit_no_fk',
                's.serviceunit_name',
                's.itemtype_no_fk',
                's.item_type',
                'uom.uom_code as uom_name',
                's.uom_no_fk',
                's.urgent_fee_amt',
                's.manual_item_rate_ind',
                's.disc_aplicable',
                's.default_discount as default_discount_pct',
                's.expireable',
                'l.current_stock',
                's.dealer_sales_price',
                's.default_discount',
                's.vat_percent',
                's.generic_name',
                's.generic_no_fk',
                's.supplier_name',

            )
            ->where("s.generic_no_fk", $generic_no)
            ->where('s.status',1)
            ->where('l.stock_su_no_fk',$service_no)
            ->where('l.current_stock','>',0)
            ->where('s.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy("s.item_name")
            ->get()
        :[];
        // dd($item);
        return Template::loadView("admin.billing.pharmacy.get_generic_item_v2", ['item' => $item,'item_id'=>$item_id,'service_no'=>$service_no]);


    }



    public function admissionItemInfoPos(Request $request)
    {
        $prescription_no_pk = $request->admission_no_pk;
        $item = DB::table("psn_t_prescription_med_vw")->where("admission_pk_no", $prescription_no_pk);

        $item = $item->get();

        return  json_encode($item);


        // return $this->getPrescriptionAutocompleteList($request);
    }
    public function printPatientRagistration($id)
    {
        $hospital_code = Session::get('user.ses_hospital_code');
        $data = PatientRegistration::where('patient_no_pk', '=', $id)
            ->select('patient_no_pk', 'salutation', 'patient_name', 'patient_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'gender_txt', 'patient_photo', 'mobile1', 'age')
            ->leftJoin('sysc_lookupdata ld', 'patn_registration.gender', '=', 'ld.lookupdata_no_pk', 'email')
            ->leftJoin('sysc_lookupdata ld2', 'patn_registration.blood_group', '=', 'ld2.lookupdata_no_pk')->first();
        $company_details = DB::table('wsec_hospital')->where('status', 1)->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $title = $data->patient_code != null ? strval($data->patient_code) : '';
        $mobile = strval($data->mobile1);
        $email = $data->email != null ? strval($data->email) : '';
        $age = $data->age != null ? strval($data->age) : '';
        $name = $data->patient_name != null ? strval($data->patient_name) : '';
        $gender_txt = $data->gender_txt != null ? strval($data->gender_txt) : '';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $hospital_phone_no=Session::get('user.ses_hospital_mobile_no');
        if (Session::get('user.ses_hospital_code')=="UNICO") {
            $title2 = $data->patient_code != null ? strval($data->patient_code) : '';
            // $title2 = $hospital_phone_no != null ? strval($hospital_phone_no) : '';
        }else{
            $title2 = $data->patient_code != null ? strval($data->patient_code) : '';
            $mobile = strval($data->mobile1);
            $email = $data->email != null ? strval($data->email) : '';
            $age = $data->age != null ? strval($data->age) : '';
            $name = $data->patient_name != null ? strval($data->patient_name) : '';
            $gender_txt = $data->gender_txt != null ? strval($data->gender_txt) : '';
        }

        $barcode_2 = new BarcodeGenerator();
        $barcode_2->setText($title2);
        $barcode_2->setType(BarcodeGenerator::Code128);
        $barcode_2->setLabel('');
        $barcode_2->setScale(1);
        $barcode_2->setThickness(40);
        $barcode_2->setFontSize(15);
        $barcode_no_2 = $barcode_2->generate();
        // $qrcontent_data = QR::qrFactory()
        //     // ->email($email)
        //     //->url("https://moinshareidea.wordpress.com/")
        //     ->text('Patient Code: ', $title)
        //     ->text('Patient Name: ', $name);
        //     if ($age !="") {
        //         $qrcontent_data->text('Patient Age: ', $age);
        //     }
        //     if ($gender_txt !="") {
        //         $qrcontent_data->text('Patient Gender: ', $gender_txt);
        //     }
        //     if ($mobile !="") {
        //         $qrcontent_data->phone('Mobile No: ', $mobile);
        //     }
        //     $qrcontent=  $qrcontent_data->QrCode(200);

            $qrcode_data=$this->qrCodeGenerate($title.','.$name.',Age: '.$age.','.$gender_txt.','.$mobile);
            $print_count=DB::table('patn_registration')->select('print_count')->where('patient_no_pk',$id)->first();
            $print= $print_count->print_count !="" ? $print_count->print_count + 1 : 1;

            if (!(empty($data)) && $id !="") {

                $savedata=[
                    'print_count'=> $print
                ];

                DB::table('patn_registration')->where('patient_no_pk',$id)->update($savedata);
                DB::commit();
            }
        $company_detailss = $lead_unit = \App\Models\Company::where("status", 1)->first();

        if ($hospital_code != 'DMHL' && $hospital_code != 'UNICO') {
            $qrcontent='';
            $pdf = PDF::loadView("admin.patient.patient_registration_pdf", ['data' => $data, 'barcode_no' => $barcode_no, 'qrcode' => $qrcontent, 'company_details' => $company_details]);
            return $pdf->stream('Patient Registration.Pdf');
        }elseif($hospital_code == 'UNICO'){
            return view("admin.patient.patient_registration_pdf_v4", ['data' => $data, 'barcode_no' => $barcode_no_2, 'qrcode' => $qrcode_data, 'company_details' => $company_details]);
        } else{
            return view("admin.patient.patient_registration_pdf_v2", ['data' => $data, 'barcode_no' => $barcode_no_2, 'qrcode' => $qrcode_data, 'company_details' => $company_details]);
        }

    }



    public function printPatientRagistrationAlied($id)
    {
        $hospital_code = Session::get('user.ses_hospital_code');
        $data = PatientRegistration::where('patient_no_pk', '=', $id)
            ->select('patient_no_pk','national_id','cor_member_no_pk', 'salutation', 'patient_name', 'patient_code', 'ld.lookupdata_name as ld_gender_name', 'ld2.lookupdata_name as ld_blood_group', 'dob', 'gender_txt', 'patient_photo', 'mobile1', 'age')
            ->leftJoin('sysc_lookupdata ld', 'patn_registration.gender', '=', 'ld.lookupdata_no_pk', 'email')
            ->leftJoin('sysc_lookupdata ld2', 'patn_registration.blood_group', '=', 'ld2.lookupdata_no_pk')->first();
        $company_details = DB::table('wsec_hospital')->where('status', 1)->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $title = $data->patient_code != null ? strval($data->patient_code) : '';
        $mobile = strval($data->mobile1);
        $email = $data->email != null ? strval($data->email) : '';
        $age = $data->age != null ? strval($data->age) : '';
        $name = $data->patient_name != null ? strval($data->patient_name) : '';
        $gender_txt = $data->gender_txt != null ? strval($data->gender_txt) : '';
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
            ->text('Patient Code: ', $title)
            ->text('Patient Name: ', $name)
            ->text('Patient Age: ', $age)
            ->text('Patient Gender: ', $gender_txt)
            ->phone($mobile)
            ->QrCode(200);
            $print_count=DB::table('patn_registration')->select('print_count')->where('patient_no_pk',$id)->first();
            $print= $print_count->print_count !="" ? $print_count->print_count + 1 : 1;

            if (!(empty($data)) && $id !="") {

                $savedata=[
                    'print_count'=> $print
                ];

                DB::table('patn_registration')->where('patient_no_pk',$id)->update($savedata);
                DB::commit();
            }
            // dd( $data);
        // patient_registration_east_west
        $company_detailss = $lead_unit = \App\Models\Company::where("status", 1)->first();

        return view("admin.patient.patient_registration_card_corporate", ['data' => $data, 'barcode_no' => $barcode_no, 'qrcode' => $qrcontent, 'company_details' => $company_details]);
            // return $pdf->stream('Patient Registration.Pdf');



    }

    //    Guest Registration Added By Nazmul 20/05/2021
    public function createguestRegistration()
    {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");

        return Template::loadView("admin.patient.guest_patient_registration", ['marital_status' => $marital_status, 'gender' => $gender, 'bloodg' => $bloodg]);
    }

    public function storeguestRegistration(PateintRegistrationRequest $request)
    {
        $validated = $request->validated();
        return $this->patRegRepository->CreateOrUpdateGuestRegister($request, $request->id);
    }

    //    Added By Nazmul 30/06/2021
    public function patientAndBillingAutocomplete(Request $request)
    {
        return $this->getPatientAndBilingAutocompleteList($request);
    }
    //Added By Nazmul Date 06/09/2021
    public function labIdAutoComplete(Request $request)
    {
        return $this->labIdAutoCompleteList($request);
    }
    

    public function hospitalPatientSearch(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "p.au_entry_hospital_pk_no = $hospital_id";
        $hdn_patient_id = $request->hdn_patient_id;
        $hdn_patient_patient_name = $request->patient_name;
        $patient_gender = $request->patient_gender;
        $patient_age = $request->patient_age;
        $patient_nid = $request->patient_nid;
        $patient_marital_status = $request->patient_marital_status;
        $patient_religion = $request->patient_religion;
        $patient_status = $request->patient_status;
        $patient_blood = $request->patient_blood;
        $patient_type = $request->patient_type;
        $corporate_name = $request->corporate_name;
        $mobile_number = $request->mobile_number;
        $address = $request->address;

        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_id != "") ? " $clause p.patient_no_pk='$hdn_patient_id'" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_patient_name != "") ? " $clause p.patient_name like '%$hdn_patient_patient_name%' " : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_gender != "") ? " $clause p.gender = $patient_gender" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_age != "") ? " $clause p.age_yy=$patient_age" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_nid != "") ? " $clause p.national_id=$patient_nid" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_marital_status != "") ? " $clause p.marital_status=$patient_marital_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_status != "") ? " $clause p.status=$patient_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_religion != "") ? " $clause p.religion=$patient_religion" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_blood != "") ? " $clause p.blood_group=$patient_blood" : "";

        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_type != "") ? " $clause p.patient_type_no_pk=$patient_type" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($corporate_name != "") ? " $clause p.ccm_client_no_pk=$corporate_name" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($mobile_number != "") ? " $clause p.mobile1 like '%$mobile_number%'" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($address != "") ? " $clause p.present_addr like '%$address%'" : "";

        $table = 'patient_info_vw p';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $columns = array(
            array('db' => 'patient_no_pk',   'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob',  'dt' => 3),
            array('db' => 'gender_txt',   'dt' => 4),
            array('db' => 'mobile1',   'dt' => 5),
            array('db' => 'present_addr',   'dt' => 6),
            array('db' => 'email',   'dt' => 7),
            array('db' => 'status',   'dt' => 8),
            array('db' => 'patient_photo', 'dt' => 9),
            array('db' => 'ccm_client_name', 'dt' => 10),
            array('db' => 'ccm_client_code', 'dt' => 11),
            array('db' => 'contact_person', 'dt' => 12),
            array('db' => 'contact_no', 'dt' => 13),
            array('db' => 'contract_sign_date', 'dt' => 14),
            array('db' => 'age', 'dt' => 15),
            array('db' => 'patient_type_code', 'dt' => 16),
            array('db' => 'print_count', 'dt' => 17),

        );
        // dd($sql_cond);

        $query = "SELECT p.patient_no_pk, p.patient_code, p.patient_name, p.dob, p.gender_txt, p.mobile1,
        p.email, p.status, p.patient_photo, p.ccm_client_name, p.ccm_client_code, p.contact_person, p.contact_no, p.contract_sign_date, p.age, p.patient_type_code, p.print_count, p.au_entry_at,p.au_entry_at,wsec_user.user_fullname,p.au_update_at ,entry_user.user_fullname as entry_user_name ,p.present_addr,p.guardian_name FROM $table left join wsec_user on wsec_user.user_no_pk = p.au_update_by left join wsec_user entry_user on entry_user.user_no_pk = p.au_entry_by WHERE $where";
        $result = DB::select($query);
        return response()->json(['data' => $result]);
    }

    public function hospitalPatientSearchOld(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        //$sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        //$where = "";

        // $patient_id = $search_param["patient_id"];
        $hdn_patient_id = $request->hdn_patient_id;
        $hdn_patient_patient_name = $request->patient_name;
        $patient_gender = $request->patient_gender;
        $patient_age = $request->patient_age;
        $patient_nid = $request->patient_nid;
        $patient_marital_status = $request->patient_marital_status;
        $patient_religion = $request->patient_religion;
        $patient_status = $request->patient_status;
        $patient_blood = $request->patient_blood;
        $patient_type = $request->patient_type;
        $corporate_name = $request->corporate_name;
        $mobile_number = $request->mobile_number;
        $address = $request->address;


        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_id != "") ? " $clause patient_no_pk='$hdn_patient_id'" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($hdn_patient_patient_name != "") ? " $clause patient_name like '%$hdn_patient_patient_name%' " : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_gender != "") ? " $clause gender = $patient_gender" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_age != "") ? " $clause age_yy=$patient_age" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_nid != "") ? " $clause national_id=$patient_nid" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_marital_status != "") ? " $clause marital_status=$patient_marital_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_status != "") ? " $clause status=$patient_status" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_religion != "") ? " $clause religion=$patient_religion" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_blood != "") ? " $clause blood_group=$patient_blood" : "";

        $clause = ($where != "") ?  " and " : "";
        $where .= ($patient_type != "") ? " $clause patient_type_no_pk=$patient_type" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($corporate_name != "") ? " $clause ccm_client_no_pk=$corporate_name" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($mobile_number != "") ? " $clause mobile1='$mobile_number'" : "";
        $clause = ($where != "") ?  " and " : "";
        $where .= ($address != "") ? " $clause present_addr like '%$address%'" : "";

        $table = 'patient_info_vw';
        // Table's primary key
        $primaryKey = 'patient_no_pk';

        $columns = array(
            array('db' => 'patient_no_pk',   'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'dob',  'dt' => 3),
            array('db' => 'gender_txt',   'dt' => 4),
            array('db' => 'mobile1',   'dt' => 5),
            array('db' => 'present_addr',   'dt' => 6),
            array('db' => 'email',   'dt' => 7),
            array('db' => 'status',   'dt' => 8),
            array('db' => 'patient_photo', 'dt' => 9),
            array('db' => 'ccm_client_name', 'dt' => 10),
            array('db' => 'ccm_client_code', 'dt' => 11),
            array('db' => 'contact_person', 'dt' => 12),
            array('db' => 'contact_no', 'dt' => 13),
            array('db' => 'contract_sign_date', 'dt' => 14),
            array('db' => 'age', 'dt' => 15),
            array('db' => 'patient_type_code', 'dt' => 16),
            array('db' => 'print_count', 'dt' => 17),

        );
        // dd($sql_cond);
        if (!empty($where)) {

            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
        // return Template::loadView("admin.patient.registration_list_table");
    }

    public function checkMembershipNumber(Request $request){
        $membership_no=$request->cardValue;
        $patName_phone=$request->name_phone;
        $requrn_value=false;
        
        if ($membership_no =="" && $patName_phone=="") {
            $requrn_value=false;
        }else{
            if ( $membership_no !="") {
                $checkData=DB::table('patn_registration')->where('cardnumber',$membership_no)->first();
                $requrn_value=!empty($checkData) ? false : true ;
            }elseif ($patName_phone !="") {
                $all_data=explode('_',$patName_phone);
                $name=explode('*',$all_data[0]);
                $salutation=$name[0];
                $first_name=$name[1];
                $last_name=$name[2];
                $checkData=DB::table('patn_registration')
                ->select(DB::raw('UPPER(salutation) AS salutation'), DB::raw('UPPER(first_name) AS first_name'), DB::raw('UPPER(last_name) AS last_name'))
                ->where('mobile1', $all_data[1])
                ->where(DB::raw('UPPER(salutation)'), strtoupper(trim($salutation)))
                ->where(DB::raw('UPPER(first_name)'), strtoupper(trim($first_name)))
                ->where(DB::raw('UPPER(last_name)'), strtoupper(trim($last_name)))
                ->first();

                $requrn_value=!empty($checkData) ? false : true ;
            }

        }
        return response()->json($requrn_value);
    }


    public function prescriptionItemInfoPosIndent(Request $request)
    {
        $indent_no = $request->med_req_id;
        $item = DB::select("select * from (
            select PSN_T_PRESCRIPTION_MED_VW.PRESCRIPTION_MED_NO_PK,
             PSN_T_PRESCRIPTION_MED_VW.PRESCRIPTION_NO_FK,
              PSN_T_PRESCRIPTION_MED_VW.PRESCRIPTION_UID,
             PSN_T_PRESCRIPTION_MED_VW.APPOINTMENT_PK_NO,
              tmed.PATIENT_NO_FK,
               PSN_T_PRESCRIPTION_MED_VW.PATIENT_CODE,
              PSN_T_PRESCRIPTION_MED_VW.PATIENT_NAME,
               PSN_T_PRESCRIPTION_MED_VW.SERVICE_NUMBER,
                PSN_T_PRESCRIPTION_MED_VW.ENTRY_SERIAL,
               tmed.ITEM_NO_FK,
                 nvl(PSN_T_PRESCRIPTION_MED_VW.BRAND_NAME,SYSC_SERVICEITEM.ITEM_NAME) ITEM_NAME,
                nvl( PSN_T_PRESCRIPTION_MED_VW.GENERIC_NAME,
                fnc_generic(SYSC_SERVICEITEM.GENERIC_NO_fk)) GENERIC_NAME,
               nvl(PSN_T_PRESCRIPTION_MED_VW.BRAND_NAME,SYSC_SERVICEITEM.ITEM_NAME) BRAND_NAME ,
                PSN_T_PRESCRIPTION_MED_VW.DOSAGE,
                 PSN_T_PRESCRIPTION_MED_VW.DURATION,
                  PSN_T_PRESCRIPTION_MED_VW.PACK_TYPE,
               PSN_T_PRESCRIPTION_MED_VW.UOM_NO_FK,
                PSN_T_PRESCRIPTION_MED_VW.UOM_TXT,
                 PSN_T_PRESCRIPTION_MED_VW.ITEM_QTY,
                PSN_T_PRESCRIPTION_MED_VW.INSTRUCTION_TAKE,
                 PSN_T_PRESCRIPTION_MED_VW.MEDICINE_COMMENT,
                  PSN_T_PRESCRIPTION_MED_VW.CHRONIC_IND,
                PSN_T_PRESCRIPTION_MED_VW.ROUTE,
                 PSN_T_PRESCRIPTION_MED_VW.STRENGTH,
                  PSN_T_PRESCRIPTION_MED_VW.CONTINUE_IND,
                   PSN_T_PRESCRIPTION_MED_VW.DURATION_COMMENT,
                PSN_T_PRESCRIPTION_MED_VW.DURATION_MU,
                 PSN_T_PRESCRIPTION_MED_VW.EYE_DROP,
                 PSN_T_PRESCRIPTION_MED_VW.EYE,
                PSN_T_PRESCRIPTION_MED_VW.MIX_MEDICINE_IND,
                 PSN_T_PRESCRIPTION_MED_VW.MIX_MEDICINE_GROUP,
                 PSN_T_PRESCRIPTION_MED_VW.ADMISSION_PK_NO,
                 PSN_T_PRESCRIPTION_MED_VW.ADMISSION_UID,
                  PSN_T_PRESCRIPTION_MED_VW.IPD_ITEM_TAKEN_IND,
                   PSN_T_PRESCRIPTION_MED_VW.IPD_ITEM_TAKEN_BY,
                 PSN_T_PRESCRIPTION_MED_VW.IPD_ITEM_TAKEN_TIME,
                 PSN_T_PRESCRIPTION_MED_VW.STATUS,
                 PSN_T_PRESCRIPTION_MED_VW.AU_ENTRY_BY,
                  PSN_T_PRESCRIPTION_MED_VW.AU_UPDATE_AT,
                   PSN_T_PRESCRIPTION_MED_VW.HOSPITAL_UID,
                    PSN_T_PRESCRIPTION_MED_VW.IPD_IND,
                  PSN_T_PRESCRIPTION_MED_VW.AU_ENTRY_AT,
                   PSN_T_PRESCRIPTION_MED_VW.IPD_INSTRUCT_DOC_PERSON_NO_FK,
                    PSN_T_PRESCRIPTION_MED_VW.IPD_INSTRUCTED_DOC_NAME,
                   PSN_T_PRESCRIPTION_MED_VW.IPD_INSTRUCT_MEDIA_NAME,
                    PSN_T_PRESCRIPTION_MED_VW.AU_ENTRY_HOSPITAL_NO_FK,
                     PSN_T_PRESCRIPTION_MED_VW.HOSPITAL_CODE,
                   PSN_T_PRESCRIPTION_MED_VW.HOSPITAL_NAME,

                   (SELECT SALES_PRICE FROM SYSC_SERVICEITEM s where s.ITEM_NO_PK = tmed.item_no_fk) SALES_PRICE,


                    PSN_T_PRESCRIPTION_MED_VW.DEALER_SALES_PRICE,

                    (SELECT SUM(NVL(current_stock, 0)) FROM STOCKWITHOUTEXPIRE stock where stock.ITEM_NO_FK = tmed.item_no_fk and STOCK_SU_NO_FK=tmed.STORE_NO_FK) CURRENT_STOCK,


                    PSN_T_PRESCRIPTION_MED_VW.EXPIREABLE, PSN_T_PRESCRIPTION_MED_VW.ITEM_TYPE,
                    (SELECT ITEM_CODE FROM SYSC_SERVICEITEM s where s.ITEM_NO_PK = tmed.item_no_fk) ITEM_CODE,



                    PSN_T_PRESCRIPTION_MED_VW.DOCTOR_SIGNATURE, PSN_T_PRESCRIPTION_MED_VW.DEGREE1, PSN_T_PRESCRIPTION_MED_VW.DEGREE2,
                    PSN_T_PRESCRIPTION_MED_VW.DEGREE3, PSN_T_PRESCRIPTION_MED_VW.DEGREE4, PSN_T_PRESCRIPTION_MED_VW.FULL_NAME,
                    PSN_T_PRESCRIPTION_MED_VW.SERVICEUNIT_NO_FK, PSN_T_PRESCRIPTION_MED_VW.USER_FULLNAME, PSN_T_PRESCRIPTION_MED_VW.MULTIDOSE_TXT,
                      PSN_T_PRESCRIPTION_MED_VW.APPROVE_IND, PSN_T_PRESCRIPTION_MED_VW.APPROVE_BY, PSN_T_PRESCRIPTION_MED_VW.APPROVE_DATE
            , SYSC_SERVICEITEM.DISC_APLICABLE, SYSC_SERVICEITEM.GENERIC_NO_FK, SYSC_SERVICEITEM.DEFAULT_DISCOUNT_PCT as DEFAULT_DISCOUNT_PCT_OLD,
            tmed.PATMEDTRAN_NO_PK, RX_NO,tmed.admission_no_fk,
               tmed.ITEM_QTY
                   - NVL((SELECT SUM(ITEM_QTY)
                     FROM PHR_IPDPATMEDTRAN
                        WHERE  PHR_IPDPATMEDTRAN.TRAN_TYPE = 'RI' and PHR_IPDPATMEDTRAN.REF_TRAN_ID = tmed.PATMEDTRAN_NO_PK ),0) as titem_qty
                           from  PHR_IPDPATMEDTRAN tmed
                            join SYSC_SERVICEITEM on SYSC_SERVICEITEM.ITEM_NO_PK = tmed.ITEM_NO_FK
                           left join PSN_T_PRESCRIPTION_MED_VW
                            on tmed.RX_NO = PSN_T_PRESCRIPTION_MED_VW.PRESCRIPTION_MED_NO_PK
            where  tmed.MED_REQ_ID = $indent_no
            and NVL(tmed.DELIVERY_IND,0) = 0
            and tmed.TRAN_TYPE = 'IR'
            )
            where titem_qty > 0");
            // PSN_T_PRESCRIPTION_MED_VW.MEDICINE_ENDDATE,
          if (!empty($item)) {
            foreach ($item as $key => $value) {
                $discount_perc =0;
                if (Session::get('user.ses_hospital_code')=="UNICO" ) {
                    $discount_perc_ptc=$value->default_discount_pct_old ?? 0 ;
                    $patInfo =DB::table('pat_registration_wl_vw')->select('ccm_client_no_fk','patient_type_code')->where('patient_no_pk',$value->patient_no_fk)->first();
                    $patient_type=!empty($patInfo) && $patInfo->patient_type_code !='' ? $patInfo->patient_type_code:0; 
                    $corporate_id=!empty($patInfo) && $patInfo->ccm_client_no_fk !='' ? $patInfo->ccm_client_no_fk:0; 
                    $sales_price_for_discount= $value->sales_price !="" ? $value->sales_price :0;
                    $discount_perc_value =DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($value->item_no_fk,'$patient_type',$corporate_id, $sales_price_for_discount,0,$discount_perc_ptc,'PCT') as def_discount from dual"));
                    $discount_perc=$discount_perc_value[0]->def_discount  != "" && $value->disc_aplicable != 1 ?  $discount_perc_value[0]->def_discount :0 ;
                    $value->default_discount_pct = $discount_perc;
                    // dd($value->item_no_pk,$patient_type,$corporate_id, $value->sales_price,$discount_perc_value);
                }else{
                        $discount_perc=$value->default_discount_pct_old ?? 0 ;
                        $value->default_discount_pct = $discount_perc;
                }
            }
          }
            
        // dd($item);

        return  json_encode($item);
    }
}
