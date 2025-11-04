<?php

namespace App\Http\Controllers;

use App\Http\Requests\PabxAppointmentRequest;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Traits\LookupData;
use DB;
use Exception;
use Carbon\Carbon;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Session;

class PabxAppointmentController extends Controller
{
    use LookupData;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $doctor_info = DB::table("doctor_info_vw")
                        ->where("status", 1)
                        ->where("au_entry_hospital_pk_no",  $ses_hospital_id)
                        ->select('person_no_pk', 'full_name')
                        ->orderBy("full_name", "asc")
                        ->get();

        $items = DB::table('patn_pabxappointment mst')
                    ->join('doctor_info_vw dr', 'mst.DOCTOR_NO_FK', 'dr.PERSON_NO_PK')
                    ->join('SYSC_LOOKUPDATA lookup', 'mst.sex', 'lookup.lookupdata_no_pk')
                    ->where('mst.status', true)
                    ->select('mst.pabxappointment_no_pk', 'mst.appoint_date', 'mst.pat_name', 'mst.dob', 'mst.sex', 'mst.mobile_no', 'dr.full_name', 'lookup.lookupdata_name')
                    ->orderByDesc('PABXAPPOINTMENT_NO_PK')
                    ->get();

        return Template::loadview("admin.pabx-appointment.index", compact('doctor_info', 'items'));
    }

    /**
     * Create New PABX Appointment
     */
    public function create()
    {
        $specialization = $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getPresLookupIDByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $visit_types = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $religion = $this->getLookupListByCode("RELIGION");
        $inform = $this->getLookupListByCode("INFORM");
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('ccm_client_name','Asc')->get();
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $doctor_info = DB::table("doctor_info_vw")
                    ->where("status", 1)
                    ->where("au_entry_hospital_pk_no",  $ses_hospital_id)
                    ->select('person_no_pk', 'full_name')
                    ->orderBy("full_name", "asc")
                    ->get();

        return Template::loadView("admin.pabx-appointment.create", ['religion' => $religion, 'inform' => $inform, 'chiefcom' => $chiefcom, 'priority' => $priority, 'gender' => $gender, 'marsts' => $marsts, 'bloodg' => $bloodg, 'visit_types' => $visit_types, 'specialization' => $specialization, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'district' => $district, 'doctor_info' => $doctor_info]);
    }

    /**
     * Store
     */
    public function store(PabxAppointmentRequest $request)
    {
        dd($request->all());

        DB::beginTransaction();

        try {
            $patient_no_fk = null;

            if($request->input('patient_type') == '1') {
                $patient_no_fk = $request->input('hdn_patient_id');
                $patient_name = $request->input('patient_code');
            } else {
                $patient_name = $request->input('patient_salutation') . ' ' . $request->input('patient_first_name') . ' ' . $request->input('patient_last_name');
            }

            DB::table('patn_pabxappointment')->insert([
                "PABXAPPOINTMENT_NO_PK"     => $this->getSequence('PABXAPPOINTMENT_NO_PK_SEQ'),
                "APPOINT_DATE"              => date('Y-m-d', strtotime($request->input('appoint_date'))),
                "DOCTOR_NO_FK"              => $request->input('doctor_no_fk'),
                "PATIENT_NO_FK"             => $patient_no_fk,
                "PAT_NAME"                  => $patient_name,
                "DOB"                       => date('Y-m-d', strtotime($request->input('dob'))),
                "SEX"                       => $request->input('sex'),
                "MOBILE_NO"                 => $request->input('mobile_no'),
                "STATUS"                    => 1,
                "AU_ENTRY_AT"               => Carbon::now()->toDateString(),
                "AU_ENTRY_BY"               => Auth::id(),
                "AU_ENTRY_SESSION"          => auth()->user()->user_name,
                "AU_ENTRY_HOSPITAL_NO_FK"   => session()->get('user.ses_hospital_no_pk'),
            ]);

            DB::commit();

            $response = response()->json(['title' => 'Success', 'success' => true, 'msg' => 'Appointment Created Successfully'], 200);
        } catch(Exception $exception) {
            DB::rollback();

            $response = response()->json(['title' => 'Error', 'success' => false, 'msg' => $exception->getMessage()], 422);
        }

        return $response;
    }

    /**
     * Filter
     */
    public function filter(Request $request)
    {
        $from_date = $request->input('from_date') != "" ? $this->formatDate($request->input('from_date')) : '';
        $to_date = $request->input('to_date') != "" ? $this->formatDate($request->input('to_date')) : '';

        $items = DB::table('patn_pabxappointment mst')
            ->join('doctor_info_vw dr', 'mst.DOCTOR_NO_FK', 'dr.PERSON_NO_PK')
            ->join('SYSC_LOOKUPDATA lookup', 'mst.sex', 'lookup.lookupdata_no_pk')
            ->where('mst.status', true)
            ->select('mst.pabxappointment_no_pk', 'mst.appoint_date', 'mst.pat_name', 'mst.dob', 'mst.sex', 'mst.mobile_no', 'dr.full_name', 'lookup.lookupdata_name');

        if($request->input('pabxappointment_no_pk') != "") {
            $items = $items->where('pabxappointment_no_pk', $request->input('pabxappointment_no_pk'));
        }

        if($request->input('doctor_no_fk') != "") {
            $items = $items->where('doctor_no_fk', $request->input('doctor_no_fk'));
        }

        if(!empty($from_date)) {
            $items = $items->where('APPOINT_DATE', '>=', $from_date);
        }

        if(!empty($to_date)) {
            $items = $items->where('APPOINT_DATE', '<=', $to_date);
        }

        $items = $items->orderByDesc('PABXAPPOINTMENT_NO_PK')->get();

        return Template::loadview("admin.pabx-appointment.appointment-table", compact('items'));
    }

    /**
     * Format Date Range fields (From Date, To Date)
     */
    protected function formatDate($dateString)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        return $myDateTime->format('Y-m-d');
    }
}
