<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\PatientRegistration;
use App\Models\ServiceUnit;
use App\Models\PrescriptionLookup;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\PatientRegistrationRepository;
use App\Traits\PrescriptionData;
use Illuminate\Http\Request;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Grade;
use Illuminate\Support\Facades\Hash;
use App\Models\DoctorFee;
use App\Models\Designation;
use App\Models\Doctor;
use App\Traits\DoctorData;
use Illuminate\Support\Facades\Session;
use App\Traits\PatientData;
use App\Datatables\DataTableClass;
use App\User;

class AdminPanelController extends Controller
{
    use LookupData, PrescriptionData;
    protected $ServiceUnit;
    protected $doctor;
    protected $model;

    public function __construct(ServiceUnit $serviceunit, PatientRegistration $patReg, Doctor $doctor)
    {
        $this->middleware('auth');
        $this->model = new Repo($patReg);
        $this->patRegRepository = new PatientRegistrationRepository($patReg);
        $this->ServiceUnit = new Repo($serviceunit);
        $this->doctor = new Repo($doctor);
    }
    public function docAdminPanel()
    {
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();

        // dashboard data

        $doctor_id = Auth::user()->person_no_fk;

        $dashboard_data = DB::table('PATN_APNT_DOCTORWISE_CAL_VW')
            ->where('DOCTOR_NO_FK', $doctor_id)
            ->first();
        $dashboard_data_today = DB::select("SELECT DOCTOR_NO_FK,
                                        FULL_NAME,
                                        SUM (
                                           NVL (CASE WHEN NVL (APPOINT_STATUS, 0) = 0 THEN 1 ELSE 0 END, 0))
                                           future_appoint_pat,
                                        SUM (
                                           NVL (CASE WHEN NVL (APPOINT_STATUS, 0) = 1 THEN 1 ELSE 0 END, 0))
                                           Appointed_patient,
                                        SUM (
                                           NVL (CASE WHEN NVL (APPOINT_STATUS, 0) = 2 THEN 1 ELSE 0 END, 0))
                                           Prescribed_patient,
                                        SUM (
                                           NVL (
                                              CASE WHEN NVL (APPOINT_STATUS, 0) IN (1, 2) THEN 1 ELSE 0 END,
                                              0))
                                           total_prescribed,
                                        SUM (NVL (sales_price, 0)) sales_price
                                   FROM PATN_APPOINTMENT_VW where trunc(APPOINT_DATE) = trunc(sysdate)

                                   and DOCTOR_NO_FK = $doctor_id
                               --where APPOINT_STATUS=2 and
                               -- WHERE DOCTOR_NO_FK = 12654
                               GROUP BY DOCTOR_NO_FK, FULL_NAME
                               ORDER BY 1");
        $dashboard_data_sevenday = DB::select("SELECT DOCTOR_NO_FK,
                                    FULL_NAME,
                                    SUM (
                                    NVL (CASE WHEN NVL (APPOINT_STATUS, 0) = 0 THEN 1 ELSE 0 END, 0))
                                    future_appoint_pat

                            FROM PATN_APPOINTMENT_VW where trunc(sysdate) <= sysdate  + 7

                            and DOCTOR_NO_FK = $doctor_id
                            --where APPOINT_STATUS=2 and
                            -- WHERE DOCTOR_NO_FK = 12654
                            GROUP BY DOCTOR_NO_FK, FULL_NAME
                            ORDER BY 1");

        $dashboard_data_pie_chart =  json_encode($dashboard_data);

        return view('iCure-Home.admin.doctor.doctor_admin_index', [
            'current_page' => $current_page,
            'po_hospital_details' => $po_hospital_details,
            'dashboard_data' => $dashboard_data,
            'dashboard_data_today' => $dashboard_data_today,
            'dashboard_data_sevenday' => $dashboard_data_sevenday,
            'dashboard_data_pie_chart' => $dashboard_data_pie_chart,
        ]);
    }

    public function patAdminPanel()
    {
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        //dd($po_hospital_details);
        $gender = $this->getLookupListByCode("GENDER");
        $bank_name = $this->getLookupListByCode("PAYMODE");
        //dd(Auth::user());
        $patient_id = Auth::user()->patient_no_fk;
        if ($po_hospital_details->hospital_code == 'CHPC') {
            $service_schedule = DB::table('patn_service_schedule_vw')
                ->where([
                    ['patient_no_fk', '=', $patient_id],
                    ['invoice_no_fk', '=', null]
                ])->get();
            $service_taken = DB::table('patn_service_schedule_vw')->where([
                ['patient_no_fk', '=', $patient_id],
                ['invoice_no_fk', '!=', null]
            ])->get();

            return view('iCure-Home.patient_admin_panel', compact('service_schedule', 'service_taken'));
        }

        //dd($service_schedule);
        // dd($patient_id);
        $visited_doctors = DB::select(DB::raw("SELECT pat.*, psn.prescription_no_pk
                                    FROM    patn_appointment_vw pat
                                         LEFT JOIN
                                            psn_t_prescription_vw psn
                                         ON pat.appoint_no_pk = psn.appoint_no_fk
                                   WHERE appoint_status = 2
                                     and patient_no_pk = $patient_id
                                ORDER BY appoint_no_pk DESC"));

        $active_appointment = DB::select(DB::raw("SELECT pat.*, psn.prescription_no_pk
                                    FROM    patn_appointment_vw pat
                                         LEFT JOIN
                                            psn_t_prescription_vw psn
                                         ON pat.appoint_no_pk = psn.appoint_no_fk
                                   WHERE appoint_status = 1  and patient_no_pk = $patient_id
                                ORDER BY appoint_no_pk DESC"));
        $prescribed_patient_list = DB::select(DB::raw("SELECT pat.*, psn.prescription_no_pk
                                    FROM    patn_appointment_vw pat
                                         LEFT JOIN
                                            psn_t_prescription_vw psn
                                         ON pat.appoint_no_pk = psn.appoint_no_fk
                                   WHERE appoint_status = 2 and patient_no_pk = $patient_id
                                ORDER BY appoint_no_pk DESC"));
        $active_med_list = DB::table('psn_t_prescription_med_vw')
            ->select('psn_t_prescription_med_vw.*', 'sysc_serviceunit.serviceunit_name')
            ->where('psn_t_prescription_med_vw.patient_no_fk', $patient_id)
            ->leftjoin('sysc_serviceunit', 'psn_t_prescription_med_vw.serviceunit_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            //->where('continue_ind', 1)
            ->orderby('psn_t_prescription_med_vw.au_entry_at', 'desc')
            ->orderby('psn_t_prescription_med_vw.au_entry_at', "asc")
            ->get();


        //  dd($active_med_list);




        return view('iCure-Home.patient_admin_panel', [
            'current_page' => $current_page, 'gender' => $gender, 'bank_name' => $bank_name, 'po_hospital_details' => $po_hospital_details, 'visited_list' => $visited_doctors, 'active_appointment' => $active_appointment, 'prescribed_patient_list' => $prescribed_patient_list, 'active_med_list' => $active_med_list
        ]);
    }

    //    doctor admin part
    public function doctorAppointment()
    {
        $doc_id = Auth::user()->person_no_fk;
        //       $appointment_data = DB::table('patn_appointment_vw')
        //           ->select('su_name','patient_name','patient_no_pk','age','gender_txt','patient_photo','chif_complain','appoint_code','appoint_no_pk')
        //           ->where('doctor_no_fk',$doc_id)
        //           //->where('appoint_source','WEB')
        //           ->where(DB::raw('trunc(appoint_date)'),date('Y-m-d'))
        //           ->get();

        $appointment_data = DB::select(DB::raw("select pat.*,psn.prescription_no_pk from patn_appointment_vw pat
                        left join psn_t_prescription_vw psn
                        on pat.appoint_no_pk = psn.appoint_no_fk where appoint_status = 1 and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk = $doc_id
                        order by appoint_no_pk DESC"));
        $appointment_data_count = DB::table('patn_appointment_vw')
            ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
            ->where('doctor_no_fk', $doc_id)
            //->where('appoint_source','WEB')
            ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
            ->get()->count();
        return view('iCure-Home.admin.doctor.admin_doctor_appointments', [
            'appointment_data' => $appointment_data,
            'appointment_data_count' => $appointment_data_count,
        ]);
    }
    public function doctorPrescreate()
    {
        //        $ses_hospital_id = Session::get('user.ses_hospital_id');
        //        $appointment_date       = date("Y-m-d");
        //
        //        $followup_num = $followup_mu_name = $template_name = "";
        //        $absent_ind = 0;
        //        if($department_id != "")
        //        {
        //            $appointment_rs = DB::table("pat_appoint_wl_vw a")
        //                ->select("a.*","b.prescription_no_pk")
        //                ->leftJoin('psn_t_prescription_vw b', function($join)
        //                {
        //                    $appointment_date = date("Y-m-d");
        //                    $join->on('a.patapp_no_pk', '=', 'b.appoint_no_fk')
        //                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
        //                })
        //                ->leftJoin("sys_lookuplist c", "a.priority_lup_no_fk", "=", "c.lookuplist_no_pk")
        //                ->orderBy("c.serial_no", "asc")
        //                ->orderBy("a.app_sl", "asc")
        //                ->where("a.su_no_fk", $department_id)
        //                ->where("a.room_no_fk", $room_id)
        //                ->where("a.au_entry_hospital_no_fk", $ses_hospital_id)
        //                ->where("a.patapp_date", $appointment_date)->get();
        //
        //            $app_arr = [];
        //            $pending_ind = $prescription_ind =  0;
        //            if(!empty($appointment_rs))
        //            {
        //                foreach ($appointment_rs as $app_data) {
        //                    if($app_data->appoint_status == 1)
        //                    {
        //                        $pending_ind++;
        //                    }
        //                    elseif ($app_data->appoint_status == 3) {
        //                        $absent_ind++;
        //                    }
        //                    else
        //                    {
        //                        $prescription_ind++;
        //                    }
        //                }
        //            }
        //
        //            $su_info = $this->ServiceUnit->findByColumn("su_no_pk", $department_id);
        //            $su_arr = [];
        //        }
        //        else
        //        {
        //            $room_info = Room::select("room_no_pk", "room_name", "room_uid")->where("room_uid", "EXTERNALROOM")->first();
        //            if(!empty($room_info))
        //            {
        //                $room_id = $room_info->room_no_pk;
        //            }
        //            else
        //            {
        //                $room_id = 0;
        //            }
        //            $pending_ind = $prescription_ind = 0;
        //            $appointment_rs = $su_info = [];
        //            $su_arr = ServiceUnit::select("su_no_pk", "su_name", "eye_ind", "dental_ind")->where("external_hosp_su_ind", 1)->get();
        //        }
        //
        //
        //        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        //        $lookup_id_arr = $this->getPresLookupIDByCode(["CHIEFCOM","CLINICHIST","PROVDIAG","DISEASE", "ADVICE", "INVFIND", "ICD"]);
        //
        //        $priority = $this->getLookupListByCode("PRIORITY");
        //        $duration_mu = $this->getPresLookupListByCode("DURMU", "lookup_data");
        //
        //        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "lookup_data");
        //        $route = $this->getPresLookupListByCode("ROUTE", "lookup_data");
        //        $dose = $this->getPresLookupListByCode("DOSE", "lookup_data");
        //        $meddurmu = $this->getPresLookupListByCode("DURMU", "psn_lookupdata_uid");
        //        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "psn_lookupdata_uid");
        //        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        //        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        //        $dental_arr=$selected_dental_arr=[];

        return view(
            "iCure-Home.admin.doctor.prescription.prescription_engine"

        );
    }


    public function prescreateDoctorWise($appoint_id = "")
    {
        // dd($department_id);
        // $ses_hospital_id = Session::get('user.ses_hospital_id');
        $doctor_id = Session::get('user.ses_user_pk_no');

        $appointment_date = date("Y-m-d");

        $followup_num = $followup_mu_name = $template_name = "";
        $absent_ind = 0;
        $department_id = 0;
        if ($appoint_id != "") {
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                //    ->where("a.su_no_fk", $department_id)
                //    ->where("a.room_no_fk", $room_id)
                //    ->where("a.au_entry_hospital_no_fk", $ses_hospital_id)
                ->where("a.appoint_no_pk", $appoint_id)->get();
            //    dd($appointment_rs);

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    } elseif ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    } else {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }

            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);

            $su_arr = [];
        } else {
            $appointment_date = date("Y-m-d");
            $appointment_rs = DB::table("patn_appointment_vw a")
                ->select("a.*")
                ->select("a.*", "b.prescription_no_pk")
                ->leftJoin('psn_t_prescription_vw b', function ($join) {
                    $appointment_date = date("Y-m-d");
                    $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                        ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
                })
                ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
                ->where("a.doctor_no_fk", Session::get('user.ses_person_no_fk'))
                ->orderBy("c.serial_no", "asc")
                ->orderBy("a.slot_sl", "asc")
                ->whereRaw(" trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")
                ->get();

            $app_arr = [];
            $pending_ind = $prescription_ind = 0;
            if (!empty($appointment_rs)) {
                foreach ($appointment_rs as $app_data) {
                    if ($app_data->appoint_status == 1) {
                        $pending_ind++;
                    }
                    if ($app_data->appoint_status == 3) {
                        $absent_ind++;
                    }
                    if ($app_data->prescription_no_pk != '') {
                        $prescription_ind++;
                    }
                }
            }
            foreach ($appointment_rs as $value) {
                $department_id = $value->su_no_fk;
            }
            //$department_id = 12;
            //$pending_ind = $prescription_ind = 0;
            $su_info = $this->ServiceUnit->findByColumn("serviceunit_no_pk", $department_id);
            $su_arr = ServiceUnit::select("serviceunit_no_pk", "serviceunit_name", "eye_ind", "dental_ind")->get();
        }
        $room_id = 0;

        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $lookup_id_arr = $this->getDocPresLookupIDByCode(["CHIEFCOM", "CLINICHIST", "PROVDIAG", "DISEASE", "ADVICE", "INVFIND", "ICD"]);

        $priority = $this->getLookupListByCode("PRIORITY");
        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");

        $instructions = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        and PRES_LOOKUP_CODE='INSTRUCTION'
        and (data.AU_ENTRY_BY    =  $doctor_id
        or DEFAULT_IND=1)");
        // $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $route = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        and PRES_LOOKUP_CODE='ROUTE'
        and (data.AU_ENTRY_BY    =  $doctor_id
        or DEFAULT_IND=1)");
        // $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $dose = DB::select("select PRES_LOOKUPDATA_NO_PK,PRES_LOOKUPDATA_NAME
        from PRES_LOOKUPDATA data, PRES_LOOKUP lookup
        where data.PRES_LOOKUP_NO_FK=lookup.PRES_LOOKUP_NO_PK
        and PRES_LOOKUP_CODE='DOSE'
        and (data.AU_ENTRY_BY    =  $doctor_id
        or DEFAULT_IND=1)");
        // $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $duration_mu_phy = $this->getPresLookupListByCode("DURMU");
        $followup_mu = $this->getPresLookupListByCode("FOLLOWUPMU", "pres_lookupdata_code");
        $extarnal_hospitals = $this->getPresLookupListByCode("EXTHOSPITAL");
        $eye_ocular_arr = $this->getPresLookupListByMultipleCode(["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"]);
        $dental_arr = $selected_dental_arr = [];

        $tr_lk_id_arr = [];
        $treatment_item_lk_ids = PrescriptionLookup::whereIn("pres_lookup_code", ["THRPEX", "ETHER"])->get();
        if (!empty($treatment_item_lk_ids)) {
            foreach ($treatment_item_lk_ids as $tr_lk_id) {
                $tr_lk_id_arr[$tr_lk_id->pres_lookup_code] = $tr_lk_id->pres_lookup_no_pk;
            }
        }

        return view("iCure-Home.admin.doctor.prescription.prescription_engine_doctor_wise", ['chiefcom' => $chiefcom, 'lookup_id_arr' => $lookup_id_arr, 'duration_mu' => $duration_mu, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'appointment_date' => $appointment_date, 'appointment_rs' => $appointment_rs, "priority" => $priority, 'department_id' => $department_id, 'room_id' => $room_id, 'followup_mu' => $followup_mu, 'prescription_ind' => $prescription_ind, 'pending_ind' => $pending_ind, 'followup_num' => $followup_num, 'followup_mu_name' => $followup_mu_name, 'template_name' => $template_name, "su_info" => $su_info, "dental_arr" => $dental_arr, "selected_dental_arr" => $selected_dental_arr, "eye_ocular_arr" => $eye_ocular_arr, "su_arr" => $su_arr, "absent_ind" => $absent_ind, 'route' => $route, 'tr_lk_id_arr' => $tr_lk_id_arr, 'duration_mu_phy' => $duration_mu_phy]);
    }
    public function adminAppointmenList(Request $request)
    {
        $data_id = $request->data_id;
        $doc_id = $request->hdn_doctor_id;
        if ($data_id == 1) {
            $appointment_data = DB::select(DB::raw("select pat.*,psn.prescription_no_pk from patn_appointment_vw pat
                        left join psn_t_prescription_vw psn
                        on pat.appoint_no_pk = psn.appoint_no_fk where appoint_status = 1 and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk = $doc_id
                        order by appoint_no_pk DESC"));
            $appointment_data_count = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 1)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get()->count();
            return view('iCure-Home.admin.doctor.admin_doctor_appointments', [
                'appointment_data' => $appointment_data,
                'appointment_data_count' => $appointment_data_count,
            ]);
        } elseif ($data_id == 4) {
            $appointment_data = DB::select(DB::raw("select pat.*,psn.prescription_no_pk from patn_appointment_vw pat
                        left join psn_t_prescription_vw psn
                        on pat.appoint_no_pk = psn.appoint_no_fk where appoint_status = 2 and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk = $doc_id
                        order by appoint_no_pk DESC"));
            $appointment_data_count = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 1)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get()->count();
            return view('iCure-Home.admin.doctor.admin_doctor_appointments', [
                'appointment_data' => $appointment_data,
                'appointment_data_count' => $appointment_data_count,
            ]);
        } elseif ($data_id == 5) {
            $appointment_data = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 1)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get();
            $appointment_data_count = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 1)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get()->count();
            return view('iCure-Home.admin.doctor.admin_doctor_appointments', [
                'appointment_data' => $appointment_data,
                'appointment_data_count' => $appointment_data_count,
            ]);
        } elseif ($data_id == 6) {
            $appointment_data = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk', 'patient_code')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 2)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get();
            $prescription_data_count = DB::table('patn_appointment_vw')
                ->select('su_name', 'patient_name', 'patient_no_pk', 'age', 'gender_txt', 'patient_photo', 'chif_complain', 'appoint_code', 'appoint_no_pk')
                ->where('doctor_no_fk', $doc_id)
                ->where('appoint_status', 1)
                ->where(DB::raw('trunc(appoint_date)'), date('Y-m-d'))
                ->get()
                ->count();
            return view('iCure-Home.admin.doctor.prescribed_patient_list', [
                'appointment_data' => $appointment_data
            ]);
        }
        //        elseif(){

        //        }
    }

    public function mcareDoctorProfile($id)
    {

        $doctor = DB::select(DB::raw("select count (case when appoint_status = 1 then 1 else null end)
                                                        as appointment_patient,
                                                     count (case when appoint_status = 2 then 1 else null end)
                                                        as prescribed_list
                                                    from    patn_appointment_vw pat
                                                         left join
                                                            psn_t_prescription_vw psn
                                                         on pat.appoint_no_pk = psn.appoint_no_fk
                                                   where  pat.doctor_no_fk = $id
                                                order by appoint_no_pk desc"));
        return view('iCure-Home.admin.doctor.profile', [
            'doctor_info' => DB::table('doctor_info_vw')->where('person_no_pk', $id)->first(),
            'app_patient_list' => db::table('patn_appointment_vw')
                ->select('patient_name', 'patient_no_pk', 'age', 'gender_txt')
                ->groupBy('patient_no_pk', 'patient_name', 'age', 'gender_txt')
                ->where('doctor_no_fk', $id)->groupBy()->paginate(6),
            'doctor' => $doctor,

        ]);
    }

    public function show($id)
    {
        $data = DB::table('hrms_personnel AS d')
            ->select('d.person_no_pk', 'd.salutation', 'd.full_name', 'd.father_name', 'd.mother_name', 'd.spouse_name', 'gen.lookupdata_name AS gender', 'mar.lookupdata_name AS marital', 'd.dob', 'ser.serviceunit_name AS service_unit', 'd.join_date', 'jti.lookupdata_name AS job_title', 'jty.lookupdata_name AS job_type', 'hrt.lookupdata_name AS hr_type', 'empt.lookupdata_name AS emp_type', 'blo.lookupdata_name AS blood_group', 'rel.lookupdata_name AS religion', 'spe.lookupdata_name AS specialization', 'd.phone_home', 'd.phone_mobile', 'd.phone_office', 'd.nationality', 'd.pe_addr1', 'd.pe_addr_dist', 'd.pe_addr_country', 'd.pr_addr1', 'd.pr_addr_dist', 'd.pr_addr_country', 'd.emergency_contact_name', 'd.emergency_contact_addr', 'd.emergency_contact_relation', 'd.emergency_contact_contact', 'd.email_personal', 'd.passport_no', 'd.place_of_birth', 'd.card_no')
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

        return $data;
    }



    public function mcareDoctorEditProfile($id)
    {
        $doctor_data = DB::table('doctor_info_vw')->where('person_no_pk', $id)->first();
        $data = $this->doctor->show($id);
        $chamber_doctor_details = DB::table("wsec_chamber_hospital hospital")->leftJoin('hrms_personnel per', 'per.chamber_hospital_no_pk', 'hospital.chamber_hospital_no_pk')->where('per.person_no_pk', $id)->first();
        $degree = $this->getLookupListByCode("DEGREE");
        $educationInfo = DB::table("hrms_personnel_education")->where("person_no_fk", $id)->get();
        $doctor_list = DB::select(DB::raw("select count (case when appoint_status = 1 then 1 else null end)
                            as appointment_patient,
                        count (case when appoint_status = 2 then 1 else null end)
                            as prescribed_list
                        from    patn_appointment_vw pat
                            left join
                                psn_t_prescription_vw psn
                            on pat.appoint_no_pk = psn.appoint_no_fk
                    where  pat.doctor_no_fk = $id
                    order by appoint_no_pk desc"));
        $nationality = $this->getLookupListByCode("NATIONALITY");

        return view('iCure-Home.admin.doctor.editProfile', [
            'doctor_data' => $doctor_data,
            'degree' => $degree,
            'page_type' => 'edit',
            'chamber_doctor_details' => $chamber_doctor_details,
            'data' => $data,
            'educationInfo' => $educationInfo,
            'doctor_list' => $doctor_list,
            'nationality' => $nationality

        ]);
    }

    public function patAppointmentBook($id)
    {
        $current_page = "apointment";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $country_name = $this->getLookupListByCode("COUNTRY");
        $docspl = DB::table('SPECIALIZATION_WISE_DOC_COUNT_VW')->get();
        $doctor_list = DB::select(DB::raw("SELECT *
                              FROM (  SELECT d.person_no_pk,sc.schedule_dt,d.doctor_fee,d.photo_name,sc.start_time,d.doctor_signature, d.full_name,d.person_code,d.phone_mobile,d.specialization,d.nationality,d.experience,d.degree1,d.degree2,d.degree3,d.doctor_ratings
                                        from hrms_schedule sc
                                        left join doctor_info_vw d on sc.doctor_person_no_fk = d.person_no_pk
                                        where trunc(sc.schedule_dt) = trunc(sysdate)
                                        group by d.person_no_pk,sc.schedule_dt,d.photo_name,sc.start_time,d.doctor_signature,d.full_name,d.person_code,d.phone_mobile,d.specialization,d.doctor_fee,d.nationality,d.experience,d.degree1,d.degree2,d.degree3,d.doctor_ratings
                                    ORDER BY doctor_fee Asc)
                             WHERE ROWNUM < 7"));


        return view('iCure-Home.patient.patient_appointment_form', [
            'po_hospital_details' => $po_hospital_details,
            'country_name' => $country_name,
            'docspl' => $docspl,
            'doctor_list' => $doctor_list,
            'current_page' => $current_page
        ]);
    }

    public function coverBookAppointmentSignDoctorByPatient($doctor_id)
    {
        // dd($doctor_id);
        $current_page = "";
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $gender = $this->getLookupListByCode("GENDER");
        $bank_name = $this->getLookupListByCode("PAYMODE");
        //        $doc_data = DB::table('doctor_info_vw')
        //                ->where('person_no_pk',$doctor_id)
        //                ->first();
        $doc_data = DB::select(DB::raw("SELECT d.person_no_pk,
       sc.schedule_dt,
       d.doctor_fee,
       d.photo_name,
       sc.start_time,
       d.doctor_signature,
       d.full_name,
       d.person_code,
       d.phone_mobile,
       d.specialization,
       d.specialization_lookup_no_fk,
       d.nationality,
       d.experience,
       sc.schedule_no_pk,
       d.au_entry_hospital_pk_no,
       d.serviceunit_no_fk,d.email_personal
  FROM    doctor_info_vw d
       LEFT JOIN
          hrms_schedule sc
       ON sc.doctor_person_no_fk = d.person_no_pk
 WHERE TRUNC (sc.schedule_dt) = TRUNC (SYSDATE) AND d.person_no_pk = $doctor_id"));

        // dd($doc_data);
        return view('iCure-Home.patient.cover_appointment_form_for_patient', [
            'doc_data' => $doc_data,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
            'gender' => $gender,
            'bank_name' => $bank_name
        ]);
    }
    public function doctorSpecializedByPatient(Request $request)
    {
        //        dd($request->all());

        $doctor_data = $request->doctor_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->country != "") ? " $clause d.person_no_pk = $request->country" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($request->specialization != "") ? " $clause d.specialization_lookup_no_fk = $request->specialization" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_data != "") ? " $clause d.person_no_pk = $doctor_data" : "";
        $query = DB::select("SELECT *
                      FROM ( SELECT
    d.person_no_pk,
    sc.schedule_dt,
    d.doctor_fee,
    d.photo_name,
    sc.start_time,
    d.doctor_signature,
    d.full_name,
    d.person_code,
    d.phone_mobile,
    d.specialization,
    d.specialization_lookup_no_fk,
    d.nationality,
    d.experience
FROM
   doctor_info_vw d
    LEFT JOIN hrms_schedule sc ON sc.doctor_person_no_fk = d.person_no_pk
    and trunc(sc.schedule_dt) = trunc(sysdate)
    $sql_cond
GROUP BY
    d.person_no_pk,
    sc.schedule_dt,
    d.photo_name,
    sc.start_time,
    d.doctor_signature,
    d.full_name,
    d.person_code,
    d.phone_mobile,
    d.specialization,
    d.doctor_fee,
    d.specialization_lookup_no_fk,
     d.nationality,
     d.experience
    ORDER BY DBMS_RANDOM.RANDOM)");
        return Template::loadview("iCure-Home.patient.doctor_list_for_patient", [
            'doctor_list' => $query,
        ]);
    }


    //    Edit patient

    public function editpatientProfile($id)
    {
        $data = $this->model->show($id);
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $thana_pre = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->present_district)->orderBy("name", "asc")->get();
        $thana_per = DB::table('sysc_upazilas')->select('id', 'name', 'district_id')->where('district_id', $data->permanent_district)->orderBy("name", "asc")->get();

        return view("iCure-Home.patient.patient_profile_edit", ['marital_status' => $marital_status, 'gender' => $gender, 'religion' => $religion, 'bloodg' => $bloodg, 'data' => $data, 'relation' => $relation, 'nationality' => $nationality, 'district' => $district, 'page_type' => 'edit', 'name_prefix' => $name_prefix, 'thana_pre' => $thana_pre, 'thana_per' => $thana_per]);
    }
    public function PatientShow($id)
    {
        $data = DB::table('patient_info_vw AS p')->where('p.patient_no_pk', '=', $id)->first();
        return view("iCure-Home.patient.patient_details_data", [
            'data' => $data,
        ]);
    }

    public function DoctorShow(Request $request)
    {

        $doctor_data = DB::table('doctor_info_vw')
            ->select('doctor_info_vw.*')
            ->leftJoin('hrms_schedule_vw', 'doctor_info_vw.person_no_pk', 'hrms_schedule_vw.person_no_pk')
            ->where('doctor_info_vw.person_no_pk', $request->data_id)
            //             ->where('hrms_schedule_vw.schedule_dt between trunc(sysdate) and trunc(sysdate + 7)')
            ->first();

        $schedul_date = DB::table("hrms_schedule_vw")->select(DB::raw('trunc(schedule_dt) schedule_dt'), "start_time", "end_time")
            ->where('person_no_pk', $request->data_id)
            ->where(DB::raw("trunc(schedule_dt)"), '>=', date('Y-m-d'))
            ->where(DB::raw("trunc(schedule_dt)"), '<=', date('Y-m-d', strtotime('+7 days')))
            ->orderBy('schedule_dt', 'ASC')
            ->get();


        //        $doctor_data = DB::table('doctor_info_vw')
        //            ->select('doctor_info_vw.*',DB::raw(TO_CHAR(hrms_schedule_vw.schedule_dt, 'DAY')),hrms_schedule_vw.start_time",'hrms_schedule_vw.end_time')
        //->leftJoin('hrms_schedule_vw','doctor_info_vw.person_no_pk','hrms_schedule_vw.person_no_pk')
        //->where('doctor_info_vw.person_no_pk',7492)
        //->first();

        return response()->json([$doctor_data, $schedul_date]);
    }

    public function appModal(Request $request)
    {
        $gender = $this->getLookupListByCode("GENDER");
        $doc_data = DB::select(DB::raw("SELECT d.person_no_pk,
       sc.schedule_dt,
       d.doctor_fee,
       d.photo_name,
       sc.start_time,
       d.doctor_signature,
       d.full_name,
       d.person_code,
       d.phone_mobile,
       d.specialization,
       d.specialization_lookup_no_fk,
       d.nationality,
       d.experience,
       sc.schedule_no_pk,
       d.au_entry_hospital_pk_no,
       d.serviceunit_no_fk,d.email_personal
  FROM    doctor_info_vw d
       LEFT JOIN
          hrms_schedule sc
       ON sc.doctor_person_no_fk = d.person_no_pk
 WHERE TRUNC (sc.schedule_dt) = TRUNC (SYSDATE) AND d.person_no_pk = $request->doctor_id"));
        return response()->json($doc_data);
    }

    public function eCommerceOrderList(Request $request, $patient_id)
    {
        // $ecommerce_data = DB::table('ecom_orders')
        //     ->select(DB::raw("SUM(ecom_order_items.product_price) as total_price"), 'ecom_orders.order_no_pk', 'ecom_order_items.au_entry_at', 'ecom_order_list_vw.assign_name', 'ecom_order_list_vw.delivery_date')



        //     ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
        //     ->leftJoin('ecom_order_list_vw', 'ecom_orders.order_no_pk', 'ecom_order_list_vw.order_no')
        //     ->where('ecom_orders.user_no_fk', $patient_id)
        //     ->groupBy('ecom_orders.order_no_pk', 'ecom_order_items.au_entry_at', 'ecom_order_list_vw.assign_name', 'ecom_order_list_vw.delivery_date')
        //     ->orderBy('ecom_orders.order_no_pk', 'desc')
        //     ->paginate(10);
        $ecommerce_data = DB::select('select * from ecom_orderlist_com_vw where user_no_fk = ' . $patient_id . ' and ROWNUM <= 11 order by order_no_pk desc');
        // dd($ecommerce_data);

        $ecom_order = [];
        foreach ($ecommerce_data as $ecom_row) {
            $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->total_price . "_" . $ecom_row->au_entry_at . '_' . $ecom_row->assign_name . '_' . $ecom_row->delivery_date . '_' . $ecom_row->product_price . '_' . $ecom_row->product_name . '_' . $ecom_row->quantity;

            // $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->product_name . "_" . $ecom_row->product_price . "_" . $ecom_row->address_name . "_" . $ecom_row->au_entry_at . "_" . $ecom_row->quantity;
        }



        $data = DB::table('ecom_orders')
            ->select(DB::raw("ecom_order_items.product_price"), 'ecom_orders.order_no_pk', 'ecom_order_items.product_name')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
            ->leftJoin('ecom_order_list_vw', 'ecom_orders.order_no_pk', 'ecom_order_list_vw.order_no')
            ->where('ecom_orders.user_no_fk', $patient_id)
            ->orderBy('ecom_orders.order_no_pk', 'desc')
            ->paginate(10);


        $row = [];
        foreach ($data as $data_row) {
            $row[$data_row->order_no_pk][] = $data_row->order_no_pk . "-" . $data_row->product_price . "-" . $data_row->product_name;

            // $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->product_name . "_" . $ecom_row->product_price . "_" . $ecom_row->address_name . "_" . $ecom_row->au_entry_at . "_" . $ecom_row->quantity;
        }


        $total_orders = DB::table('ecom_orders')
            ->select(DB::raw("SUM(ecom_order_items.quantity) as total_quantity"), 'ecom_orders.order_no_pk')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
            ->where('ecom_orders.user_no_fk', $patient_id)
            ->groupBy(DB::raw("ecom_orders.order_no_pk"))
            ->get();

        $orders_row = [];
        foreach ($total_orders as $orders_data) {
            $orders_row[$orders_data->order_no_pk] = $orders_data->total_quantity;
        }


        return view('iCure-Home.patient.ecommerce_list', [
            'ecommerce_data' => $ecommerce_data, 'ecom_order' => $ecom_order, 'orders_row' => $orders_row, 'row' => $row
        ]);
    }

    public function eCommerceOrderListSearch(Request $request)
    {
        // dd($request->all());
        $patient_id = $request->user_id;
        $from_date = $request->search_date_from != "" ? date("d-m-Y", strtotime($request->search_date_from)) : '';
        $to_date = $request->search_date_to != "" ? date("d-m-Y", strtotime($request->search_date_to)) : "";

        // $ecommerce_data = DB::table('ecom_orders')
        //     ->select(DB::raw("SUM(ecom_order_items.product_price) as total_price"), 'ecom_orders.order_no_pk', 'ecom_order_items.au_entry_at', 'ecom_order_list_vw.assign_name', 'ecom_order_list_vw.delivery_date')
        //     ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk')
        //     ->leftJoin('ecom_order_list_vw', 'ecom_orders.order_no_pk', 'ecom_order_list_vw.order_no');

        $ecommerce_data = DB::select('select * from ecom_orderlist_com_vw where user_no_fk = ' . $patient_id . ' and ROWNUM <= 11 order by order_no_pk desc');



        if ($from_date != "" && $to_date != "") {
            $ecommerce_data->where(DB::raw("trunc(au_entry_at)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
            $ecommerce_data->where(DB::raw("trunc(au_entry_at)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            $ecommerce_data = $ecommerce_data->where('user_no_fk', $patient_id)->groupBy('order_no_pk', 'au_entry_at', 'assign_name', 'delivery_date')->paginate(10);
        } elseif ($from_date != "") {
            $ecommerce_data->where(DB::raw("trunc(au_entry_at)"), '=', date('Y/m/d', strtotime(request('search_date_from'))))->where('user_no_fk', $patient_id)->groupBy('order_no_pk', 'au_entry_at', 'assign_name', 'delivery_date')->paginate(10);
        }

        // dd($ecommerce_data);



        $ecom_order = [];
        foreach ($ecommerce_data as $ecom_row) {
            $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->total_price . "_" . $ecom_row->au_entry_at . '_' . $ecom_row->assign_name . '_' . $ecom_row->delivery_date;

            // $ecom_order[$ecom_row->order_no_pk][] = $ecom_row->order_no_pk . "_" . $ecom_row->product_name . "_" . $ecom_row->product_price . "_" . $ecom_row->address_name . "_" . $ecom_row->au_entry_at . "_" . $ecom_row->quantity;
        }

        $total_orders = DB::table('ecom_orders')
            ->select(DB::raw("SUM(ecom_order_items.quantity) as total_quantity"), 'ecom_orders.order_no_pk')
            ->leftjoin('ecom_order_items', 'ecom_orders.order_no_pk', 'ecom_order_items.order_no_fk');
        // ->where('ecom_orders.user_no_fk', $patient_id)
        // ->groupBy(DB::raw("ecom_orders.order_no_pk"))
        // ->get();



        if ($from_date != "" && $to_date != "") {
            $total_orders->where(DB::raw("trunc(ecom_orders.au_entry_at)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
            $total_orders->where(DB::raw("trunc(ecom_orders.au_entry_at)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            // $total_orders->where('ecom_orders.user_no_fk', $patient_id);
            // ->groupBy("ecom_orders.order_no_pk")
            // ->get();
        } elseif ($from_date != "") {
            $total_orders->where(DB::raw("trunc(ecom_orders.au_entry_at)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            // ->groupBy("ecom_orders.order_no_pk")
            // ->get();
        }
        // dd($total_orders->where('ecom_orders.user_no_fk', $patient_id)->groupBy("ecom_orders.order_no_pk")
        // ->get());


        $orders_row = [];
        foreach ($total_orders->where('ecom_orders.user_no_fk', $patient_id)->groupBy("ecom_orders.order_no_pk")
            ->get() as $orders_data) {
            // dd($orders_data->total_quantity);
            $orders_row[$orders_data->order_no_pk] = $orders_data->total_quantity;
        }


        return view('iCure-Home.patient.ecommerce_list_data', [
            'ecommerce_data' => $ecommerce_data, 'ecom_order' => $ecom_order, 'orders_row' => $orders_row
        ]);
    }


    // update doctor
    public function updateDoctor(Request $request, $id)
    {
        $this->validate($request, [

            'old_password' => 'required',
            'password' => 'required',
        ]);

        $hashedPassword = Auth::user()->user_pass;

        if (\Hash::check($request->old_password, $hashedPassword)) {
            if (!\Hash::check($request->password, $hashedPassword)) {
                $users = DB::table('wsec_user')->where('user_no_pk', auth()->user()->user_no_pk)->first();
                $users->user_pass = bcrypt($request->password);
                DB::table('wsec_user')->where('user_no_pk', auth()->user()->user_no_pk)->update(array('user_pass' =>  $users->user_pass));


                DB::commit();
                $message = ['msg' => 'Password Updated Successfully', 'title' => 'Success'];
                return response()->json($message);
            } else {

                DB::rollback();
                $message = ['msg' => 'New Password Can Not Be The Old Password!', 'title' => 'Error'];
                return response()->json($message);
            }
        } else {
            DB::rollback();
            $message = ['msg' => 'Old Password Doesnt Matched ', 'title' => 'Error'];
            return response()->json($message);
        }
    }

    public function updateDoctorInfo(Request $request, $id)
    {

        try {
            DB::table('hrms_personnel')
                ->where('person_no_pk', $id)
                ->update([
                    'full_name' => $request->doctor_first_name . ' ' . $request->doctor_last_name,
                    'fname' => $request->doctor_first_name,
                    'lname' => $request->doctor_last_name,
                    'phone_mobile' => $request->doctor_mobile_no,
                    'email_personal' => $request->doctor_email,
                    'contact_number' => $request->doctor_mobile_no,
                    'hospital_address' => $request->chamber_add,
                    'doc_lic_no' => $request->doctor_lic_no,
                    'license_number' => $request->doctor_lic_no,
                    'license_issue_date' => $request->doctor_lic_issue_date != null ? date("Y/m/d", strtotime($request->doctor_lic_issue_date)) : "",
                    'pr_post_code' => $request->zip_code,
                    'pr_addr_country' => $request->country,
                    'remarks_text' => $request->bio,



                    // 'gender_lookup_no_fk' => $request->doctor_gender,
                    // 'blood_group_lookup_no_fk' => $request->doctor_blood_group,
                    // 'place_of_birth' => $request->place_of_birth,
                    // 'marital_lookup_no_fk' => $request->doctor_marital_status,
                    // 'religion_lookup_no_fk' => $request->doctor_religion,
                    // 'passport_no' => $request->passport_no,
                    // 'passport_issue_date' => ($request->issue_date != null) ? date("Y/M/d", strtotime($request->issue_date)) : null,
                    // 'passport_expire_date' => ($request->expired_date != null) ? date("Y/M/d", strtotime($request->expired_date)) : null,
                    // 'passport_issue_place' => $request->issue_place,
                    // 'nid_no' => $request->doctor_nid,
                    'nationality' => $request->country,
                    'pr_addr1' => $request->present_address,
                    // 'pr_addr_dist' => $request->doctor_present_district,
                    // 'pr_addr_thana' => $request->doctor_pr_thana,
                    'pr_addr_country' => $request->country,
                    'pe_addr1' => $request->doctor_parmanent_address,
                    'pe_addr_dist' => $request->doctor_par_district,
                    'pe_addr_thana' => $request->doctor_pe_thana,
                    'pe_addr_country' => $request->parmanent_country,
                    // 'father_name' => $request->doctor_father,
                    // 'father_name_bangla' => $request->doctor_father_bangla,
                    // 'mother_name' => $request->doctor_mother,
                    // 'mother_name_bangla' => $request->doctor_mother_bangla,
                    // 'spouse_name' => $request->doctor_spouse,
                    // 'spouse_name_bangla' => $request->doctor_spouse_bangla,
                    // 'degree1' => $request->doctor_degree1,
                    // 'degree2' => $request->doctor_degree2,
                    // 'degree3' => $request->doctor_degree3,
                    // 'degree4' => $request->doctor_degree4,
                    // 'job_type_lookup_no_fk' => $request->doctor_job_type,
                    // 'jobtitle_lookup_no_fk' => $request->doctor_job_title,
                    // 'duty_roster_type' => $request->roster_type,
                    // 'grade_no_fk' => $request->grade_no_fk,
                    // 'bank_name' => $request->bank_name,
                    // 'bank_acc_no' => $request->bank_acc_no,
                    // 'bank_acc_name' => $request->bank_acc_name,
                    // 'agent_banking_type' => $request->agent_banking_type,
                    // 'agent_banking_no' => $request->agent_banking_no,

                    // 'security_money_amount' => $request->security_money,
                    // 'security_money_received_date' => ($request->receive_date != null) ? date('Y/M/d', strtotime($request->receive_date)) : null,
                    // 'serviceunit_no_fk' => $request->doctor_ser_unit,
                    // 'join_date' => ($request->doctor_join_date != null) ? date("Y-m-d", strtotime($request->doctor_join_date)) : null,
                    // 'card_no' => $request->doctor_card_number,
                    // 'hr_type_lookup_no_fk' => $request->doctor_hr_type,
                    // 'emp_type_lookup_no_fk' => $request->emp_type,
                    // 'accomodation_ind' => $request->accommodation,
                    // 'transport_ind' => $request->transport_ind,
                    // 'provident_fund_type' => $request->provident_fund_type,
                    // 'ot_payable_ind' => $request->ot_payable_ind,
                    // 'inactivate_date' => ($request->inactivate_date != null) ? date('Y/M/d', strtotime($request->inactivate_date)) : null,
                    // 'inactivate_resson' => $request->inactivate_resson,
                    // 'weekly_offday' => $request->weekly_offday,
                    // 'area_no_pk' => $request->coverage_area,

                    // 'employee_ind' => $request->employee_ind,
                    // 'doctor_ind' => $request->referral_doctor_ind,
                    // 'salary_ind' => $request->salary_ind,

                    // 'doc_chamber_day_sat' => ($request->saturday) ? $request->saturday : 0,
                    // 'doc_chamber_day_sun' => ($request->sunday) ? $request->sunday : 0,
                    // 'doc_chamber_day_mon' => ($request->monday) ? $request->monday : 0,
                    // 'doc_chamber_day_tue' => ($request->tuesday) ? $request->tuesday : 0,
                    // 'doc_chamber_day_wed' => ($request->wednesday) ? $request->wednesday : 0,
                    // 'doc_chamber_day_thu' => ($request->thursday) ? $request->thursday : 0,
                    // 'doc_chamber_day_fri' => ($request->friday) ? $request->friday : 0,
                    // 'doc_chamber_time_txt' => $request->time_text,
                    // 'remarks_text' => $request->doctor_remarks,

                    // 'hospital_name' => $request->hos_name,
                    // 'chamber_hospital_no_pk' => $request->hos_name,

                    // 'chamber_schedule_time' => $request->chamber_time,
                    // 'chamber_schedule_days' => $request->chamber_days,



                    // 'referral_agent_ind' => ($request->marketing_type) ? $request->marketing_type : '',
                    // 'referal_ind' => ($request->referral_ind) ? 1 : '',
                    // 'specialization_lookup_no_fk' => $request->doctor_specialization,
                    // 'doctor_signature' => $request->doctor_signature,
                    // 'dob' => ($request->doctor_date_of_birth != null) ? date("Y/m/d", strtotime($request->doctor_date_of_birth)) : null,
                    // 'bonus_elig_ind' => ($request->bonus_eligibility) ? 1 : 0,
                    // 'apps_user_ind' => ($request->apps_user) ? 1 : "",
                    // 'agent_access_code' => $request->passcode,
                    // 'agent_access_code' => $request->passcode,

                    'status' => ($request->status_ind) ? 0 : 1,
                    'doctor_ind' => 1,

                ]);




            $last_id = $id;

            DB::table("hrms_personnel_education")->where("person_no_fk", $id)->delete();
            $edu_array_count = sizeof($request->input("name"));
            $name = $request->input("name");
            $institution = $request->input("institution");
            $result = $request->input("result");
            $p_year = $request->input("p_year");

            //dd( $name,$institution,$result,$p_year);
            for ($i = 0; $i < $edu_array_count; $i++) {
                if ($name[0] != 0) {
                    $sequence = DB::getSequence();
                    $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                    $educationData = [
                        "education_no_pk" => $education_no_pk_seq,
                        'person_no_fk' => $last_id,
                        'degree_name' => $name[$i],

                        'institute_name' => $institution[$i + 1],
                        'passing_year' => $p_year[$i + 1],
                        'result_text' => $result[$i + 1],
                        'au_entry_session' => "session",
                        'au_entry_hospital_pk_no' => 1
                    ];
                    $educationData['au_entry_by'] = 1;
                    $educationData['au_entry_at'] = date("Y-m-d");
                    DB::table('hrms_personnel_education')->insert($educationData);
                } else {
                    if ($name[$i] != '0') {
                        $sequence = DB::getSequence();
                        $education_no_pk_seq = $sequence->nextValue('education_no_pk_seq');
                        $educationData = [
                            "education_no_pk" => $education_no_pk_seq,
                            'person_no_fk' => $last_id,
                            'degree_name' => $name[$i],

                            'institute_name' => $institution[$i],
                            'passing_year' => $p_year[$i],
                            'result_text' => $result[$i],
                            'au_entry_session' => "session",
                            'au_entry_hospital_pk_no' => 1
                        ];
                        $educationData['au_entry_by'] = 1;
                        $educationData['au_entry_at'] = date("Y-m-d");
                        DB::table('hrms_personnel_education')->insert($educationData);
                    }
                }
            }



            $this->message = ['msg' => 'Doctor Information Successfully', 'title' => 'Success',];
        } catch (\Exception $e) {
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }


    public function orderDetails(Request $request)
    {
        // dd($request->data_id);
        $id = $request->data_id;
        $ecomerce_status = DB::select(DB::raw("select order_no,assign_name,customer_name,delivery_status,phone_mobile,quantity,to_char(order_date, 'dd-mm-yyyy ') order_date,to_char(delivery_date, 'dd-mm-yyyy ') delivery_date,tot_amount from ecom_order_list_vw where order_no  = $id order by delivery_date Desc"));
        // dd($ecomerce_status);
        return view('iCure-Home.patient.status_details_modal', [
            'id' => $id,
            'ecomerce_status' => $ecomerce_status
        ]);
    }



    // public function searchDoctorList(Request $request)
    // {
    //     // dd($request->all());

    //     $search_doctor = $request->search_doctor;
    //     $category = $request->category;


    //     $sql_cond = "";
    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($search_doctor != "") ? " $clause  UPPER (FULL_NAME) LIKE UPPER('%$search_doctor%')" : "";

    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($category != "") ? " $clause UPPER (LOOKUPDATA_NAME) LIKE UPPER ('%$category%') " : "";


    //     $query = DB::select(DB::raw("SELECT *
    //                                 FROM doctor_info_vw
    //                                     JOIN
    //                                         sysc_lookupdata
    //                                     ON lookupdata_no_pk = chamber_hospital_country $sql_cond"));

    //     // dd($query);

    //     return Template::loadview("mCare.doctor_wise_list", [
    //         'doctor_indian_list' => $query
    //     ]);
    // }

    // public function searchHospitalList(Request $request)
    // {
    //     // dd($request->all());

    //     $hospital_search_id = $request->hospital_search_id;
    //     $category = $request->hosptial_category;


    //     $sql_cond = "";
    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($hospital_search_id != "") ? " $clause  UPPER (wsec_chamber_hospital.CHAMBER_HOSPITAL_NAME) LIKE UPPER('%$hospital_search_id%')" : "";

    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($category != "") ? " $clause UPPER (sysc_lookupdata.LOOKUPDATA_NAME) LIKE UPPER ('%$category%') " : "";


    //     $query = DB::select(DB::raw(" select * from wsec_chamber_hospital  join  sysc_lookupdata
    //     ON lookupdata_no_pk = chamber_hospital_country $sql_cond  and wsec_chamber_hospital.status= 1 "));

    //     //  dd($query);

    //     return Template::loadview("mCare.search_hospital_list", [
    //         'hospital_india' => $query
    //     ]);
    // }

    // public function searchProductList(Request $request)
    // {
    //     //dd($request->all());

    //     $hospital_search_id = $request->pro_id;
    //     $category = $request->cat_id;


    //     $sql_cond = "";
    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($hospital_search_id != "") ? " $clause  UPPER (wsec_chamber_hospital.CHAMBER_HOSPITAL_NAME) LIKE UPPER('%$hospital_search_id%')" : "";

    //     $clause = ($sql_cond == "") ? " where" : " and";
    //     $sql_cond .= ($category != "") ? " $clause  item_cat_lookupdata_no_fk = $category " : "";



    //     $code = 'ECITEMCAT';
    //     $category = DB::table('sysc_lookupdata_vw')->where('lookup_code', $code)->get();

    //     $cate_arr = [];
    //     $sub_cate_arr = [];
    //     $cate_wise_product = [];
    //     if (!empty($category)) {
    //         foreach ($category as $cate) {
    //             if ($cate->lookupdata_pk_no_parent == null) {
    //                 $cate_arr[$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
    //                 $cate_wise_product[$cate->lookupdata_name] = DB::select(DB::raw('select * from sysc_serviceitem_vw ' . $sql_cond . 'and item_cat_lookupdata_no_fk = ' . $cate->lookupdata_no_pk));



    //                 // DB::table('sysc_serviceitem_vw')->where('item_cat_lookupdata_no_fk', $cate->lookupdata_no_pk)->where('item_cat_lookupdata_no_fk',$category)->orderBy('au_update_at', 'asc')->orderBy('au_entry_at', 'asc')->paginate(20);
    //             }
    //             if ($cate->lookupdata_pk_no_parent != null) {

    //                 $sub_cate_arr[$cate->lookupdata_pk_no_parent][$cate->lookupdata_no_pk] =  $cate->lookupdata_name;
    //             }
    //         }
    //     }

    //     // $query = DB::select(DB::raw(" select * from wsec_chamber_hospital  join  sysc_lookupdata
    //     // ON lookupdata_no_pk = chamber_hospital_country $sql_cond  and wsec_chamber_hospital.status= 1 "));

    //     //  dd($query);

    //     return Template::loadview("mCare.search_product_list", [
    //         'cate_wise_product' => $cate_wise_product,
    //     ]);
    // }
}
