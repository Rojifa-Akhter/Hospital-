<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Traits\LookupData;
use App\Traits\PrescriptionData;
use App\Models\Prescription;
use App\Models\PresFavourit;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\PrescriptionRepository;
use App\Models\ServiceUnit;
use DB;
use Session;
use Illuminate\Http\Request;

class EmergencyPrescriptionController extends Controller
{
    use LookupData, PrescriptionData;
    protected $prescriptionRepository, $ServiceUnit;
    public function __construct(Prescription $prescription, PresFavourit $presfavourit, ServiceUnit $serviceunit)
    {
        $this->middleware('auth');
        $this->model = new Repo($prescription);
        $this->favouritmodel = new Repo($presfavourit);
        // $this->prescriptionRepository = new PrescriptionRepository($prescription);
        $this->ServiceUnit = new Repo($serviceunit);
    }
    //
    public function emergencyPres()
    {


        $room_id = 0;
        $followup_num = $followup_mu_name = $template_name = "";
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD", "FINDINGS", "PASTHI", "TREATMENTHISTORY"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");
        $bloodg = $this->getLookupListByCode("BLOODG");

        // $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='INSTRUCTION'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        // $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='ROUTE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        // $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='DOSE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");


        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->where("status", 1)->get();
        $chief_com = [];
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        $doctor_info = DB::table('hrms_personnel')->select('person_no_pk', 'full_name', 'person_code')->where('person_code', 'CONSULTANT')->first();
        $su_info =  $this->ServiceUnit->findByColumn("serviceunit_no_pk", Session::get("user.su_pk_no"));
        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::table("psn_t_prescription_vw")
            ->select("*")
            ->whereRaw(" trunc(au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
            // ->where("doctor_person_no_fk", Session::get('user.ses_person_no_fk'))
            ->where("appoint_no_fk", null)
            // ->orderBy("c.serial_no", "asc")
            // ->orderBy("a.slot_sl", "asc")
            ->get();
        $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
                s.SERVICEUNIT_NO_PK
            FROM sysc_serviceunit s
                JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
            WHERE p.doctor_ind = 1 AND p.employee_ind = 1
                group by s.SERVICEUNIT_NAME,
                s.SERVICEUNIT_NO_PK
                order by 1 asc");

        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
            FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        return Template::loadView("admin.prescription.emergency.emergency_prescription", ['appointment_rs' => $appointment_rs, 'su_arr' => $su_arr, 'followup_mu_name' => $followup_mu_name, 'clinical_arr' => $clinical_arr, 'history_arr' => $history_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, "priority" => $priority, 'room_id' => $room_id, 'followup_mu' => $followup_mu, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, 'route' => $route, 'chief_com' => $chief_com, 'po_hospital_details' => $po_hospital_details, 'duration_mu_phy' => $duration_mu_phy, 'doctor_info' => $doctor_info, 'su_info' => $su_info, 'bloodg' => $bloodg, 'intervention' => $intervention, 'doctor_departments' => $doctor_departments]);
    }
    public function emergencyPresIpd($pat_id,$adm_id,$doctor_id)
    {

        $room_id = 0;
        $followup_num = $followup_mu_name = $template_name = "";
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD", "FINDINGS", "PASTHI", "TREATMENTHISTORY"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");
        $bloodg = $this->getLookupListByCode("BLOODG");

        // $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='INSTRUCTION'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        // $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='ROUTE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        // $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='DOSE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");


        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->where("status", 1)->get();
        $chief_com = [];
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        $doctor_info = DB::table('hrms_personnel')->select('person_no_pk', 'full_name', 'person_code')->where('person_code', 'CONSULTANT')->first();
        $su_info =  $this->ServiceUnit->findByColumn("serviceunit_no_pk", Session::get("user.su_pk_no"));
        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::table("psn_t_prescription_vw")
            ->select("*")
            ->whereRaw(" trunc(au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
            // ->where("doctor_person_no_fk", Session::get('user.ses_person_no_fk'))
            ->where("appoint_no_fk", null)
            // ->orderBy("c.serial_no", "asc")
            // ->orderBy("a.slot_sl", "asc")
            ->get();
            $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
        FROM sysc_serviceunit s
            JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
        WHERE p.doctor_ind = 1 AND p.employee_ind = 1
            group by s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
            order by 1 asc");

        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
            FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        return Template::loadView("admin.prescription.emergency.emergency_prescription", ['appointment_rs' => $appointment_rs, 'su_arr' => $su_arr, 'followup_mu_name' => $followup_mu_name, 'clinical_arr' => $clinical_arr, 'history_arr' => $history_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, "priority" => $priority, 'room_id' => $room_id, 'followup_mu' => $followup_mu, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, 'route' => $route, 'chief_com' => $chief_com, 'po_hospital_details' => $po_hospital_details, 'duration_mu_phy' => $duration_mu_phy, 'doctor_info' => $doctor_info, 'su_info' => $su_info, 'bloodg' => $bloodg, 'intervention' => $intervention, 'doctor_departments' => $doctor_departments]);
    }
     public function emergencyPresAnes($pat_id,$doctor_id)
    {

        $room_id = 0;
        $followup_num = $followup_mu_name = $template_name = "";
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD", "FINDINGS", "PASTHI", "TREATMENTHISTORY"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");
        $bloodg = $this->getLookupListByCode("BLOODG");

        // $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='INSTRUCTION'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $instructions = $this->getPresLookupListByCodeEwmch("INSTRUCTION", "pres_lookupdata_name");
        // $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='ROUTE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $route = $this->getPresLookupListByCodeEwmch("ROUTE", "pres_lookupdata_name");
        // $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        // from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        // where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        // and PRES_LOOKUP_CODE='DOSE'
        // and (data.AU_ENTRY_BY    = $doctor_id
        // or DEFAULT_IND=1)");
        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
                FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
            WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                    AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        $dose = $this->getPresLookupListByCodeEwmch("DOSE", "pres_lookupdata_name");


        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->where("status", 1)->get();
        $chief_com = [];
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        $doctor_info = DB::table('hrms_personnel')->select('person_no_pk', 'full_name', 'person_code')->where('person_code', 'CONSULTANT')->first();
        $su_info =  $this->ServiceUnit->findByColumn("serviceunit_no_pk", Session::get("user.su_pk_no"));
        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::table("psn_t_prescription_vw")
            ->select("*")
            ->whereRaw(" trunc(au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
            // ->where("doctor_person_no_fk", Session::get('user.ses_person_no_fk'))
            ->where("appoint_no_fk", null)
            // ->orderBy("c.serial_no", "asc")
            // ->orderBy("a.slot_sl", "asc")
            ->get();
            $doctor_departments = DB::select("SELECT s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
        FROM sysc_serviceunit s
            JOIN hrms_personnel p ON p.serviceunit_no_fk = s.SERVICEUNIT_NO_PK
        WHERE p.doctor_ind = 1 AND p.employee_ind = 1
            group by s.SERVICEUNIT_NAME,
            s.SERVICEUNIT_NO_PK
            order by 1 asc");

        $intervention = DB::select("SELECT PRES_LOOKUPDATA_NO_PK, PRES_LOOKUPDATA_NAME
            FROM PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        WHERE data.PRES_LOOKUP_NO_FK = lookup.PRES_LOOKUP_NO_PK
                AND PRES_LOOKUP_CODE = 'DISPOSAL'");
        return Template::loadView("admin.prescription.emergency.emergency_prescription_anes", ['appointment_rs' => $appointment_rs, 'su_arr' => $su_arr, 'followup_mu_name' => $followup_mu_name, 'clinical_arr' => $clinical_arr, 'history_arr' => $history_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, "priority" => $priority, 'room_id' => $room_id, 'followup_mu' => $followup_mu, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, 'route' => $route, 'chief_com' => $chief_com, 'po_hospital_details' => $po_hospital_details, 'duration_mu_phy' => $duration_mu_phy, 'doctor_info' => $doctor_info, 'su_info' => $su_info, 'bloodg' => $bloodg, 'intervention' => $intervention, 'doctor_departments' => $doctor_departments]);
    }
    public function getPrescriptionOderEntry()
    {
        $room_id = 0;
        $followup_num = $followup_mu_name = $template_name = "";
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $history_arr = $this->getPresLookupDTLListByCode("HISTORY");
        $clinical_arr = $this->getPresLookupDTLListByCode("EXAMINATION");


        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];
        $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->where("status", 1)->get();
        $chief_com = [];
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->get();
        $doctor_info = DB::table('hrms_personnel')->select('person_no_pk', 'full_name', 'person_code')->where('person_code', 'CONSULTANT')->first();
        // dd($doctor_info);
        return Template::loadView("admin.prescription.pres_order_entry", ['su_arr' => $su_arr, 'followup_mu_name' => $followup_mu_name, 'clinical_arr' => $clinical_arr, 'history_arr' => $history_arr, 'chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, "priority" => $priority, 'room_id' => $room_id, 'followup_mu' => $followup_mu, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, 'route' => $route, 'chief_com' => $chief_com, 'po_hospital_details' => $po_hospital_details, 'duration_mu_phy' => $duration_mu_phy, 'doctor_info' => $doctor_info]);
    }
    public function getDoctorWiseEmrPrescribedPatientList(Request $request)
    {
        $doctor_id = Session::get("user.ses_person_no_fk");
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        // $sql_cond .= ($patient_id != "") ? " $clause  pat.patient_no_pk = $patient_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($request->search_date_from != "") ? " trunc(au_entry_at) between TO_DATE('$request->search_date_from', 'DD/MM/YYYY') and TO_DATE('$request->search_date_to', 'DD/MM/YYYY')" : "";
        $hospital_id =  Session::get('user.ses_hospital_no_pk');

        $appointment_rs = DB::select(DB::raw("select * from psn_t_prescription_vw where $sql_cond and au_entry_hospital_no_fk = $hospital_id and doctor_person_no_fk = $doctor_id"));
        // dd($appointment_rs);
        return Template::loadView("admin.prescription.completed_emergency_prescription", ['appointment_rs' => $appointment_rs]);
    }
}
