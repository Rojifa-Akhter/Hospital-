<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRegistrationRequest;
use App\Library\Template;
use App\Repositories\PatientRegistrationRepository;
use App\Traits\PatientData;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Traits\LookupData;
use App\Models\currentEquiment;
use App\Models\DailyFamilydose;
use App\Models\ImmuzationHistory;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository as Repo;
use App\Traits\MailEngine;
use Auth;
use \PDF;
use Session;
use App\Traits\DatatablesLoader;
use App;
use App\Models\Company;

class EMRController extends Controller
{
    protected $model;
    use MailEngine;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(currentEquiment $currentEquiment, ImmuzationHistory $ImmuzationHistory, DailyFamilydose $DailyFamilydose)
    {
        // $this->middleware('auth');
        $this->model_equiment = new Repo($currentEquiment);
        $this->model3 = new Repo($ImmuzationHistory);
        $this->model2 = new Repo($DailyFamilydose);
    }



    public function emr($patient_id = null)
    {



        $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $patient_id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('a.au_entry_at', 'desc')->get();
        //       $vitals_data = DB::select("select * from psn_t_patvitals_ipd_vw where patient_no_fk = $patient_id order by  au_entry_at desc");

        $date_data = json_encode($vitals_data);

        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $patient_id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('au_entry_at', 'desc')->get();
        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('au_entry_at', 'desc')->get();

        return Template::loadView("admin.EMR.emr", [
            'patient_info' => $patient_info,
            'alergies_data' => $alergies_data,
            'chronic_data' => $chronic_data,
            'date_data' => $date_data,
            'vitals_data' => $vitals_data,
            'patient_id' => $patient_id
        ]);
    }


    public function emrUHL($patient_id = null)
    {
        $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')
            ->select(
                'h.hospital_code',
                'a.chief_complaints',
                'a.temp_val',
                'a.temp_val_time',
                'a.height_val',
                'a.h_mu_name',
                'a.weight_val',
                'a.w_mu_name',
                'a.bp_val_dia',
                'a.bp_val_sys',
                'a.pulse_val',
                'a.ofc',
                'a.vital_date',
                'a.bmi',
                'a.spo2_value',
                'a.au_entry_at'
            )
            ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $patient_id)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('a.au_entry_at', 'desc')
            ->get();
        $date_data = json_encode($vitals_data);
        // dd($patient_info);
        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $patient_id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('au_entry_at', 'desc')->get();
        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('au_entry_at', 'desc')->get();

        return Template::loadView("admin.EMR.uhl.emr_uhl", [
            'patient_info' => $patient_info,
            'alergies_data' => $alergies_data,
            'chronic_data' => $chronic_data,
            'date_data' => $date_data,
            'vitals_data' => $vitals_data,
            'patient_id' => $patient_id
        ]);
    }

    public function patientEmr($patient_id = null)
    {
        $patient_id = Auth::user()->patient_no_fk;



        $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();
        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $patient_id)->orderBy('a.au_entry_at', 'desc')->get();
        //       $vitals_data = DB::select("select * from psn_t_patvitals_ipd_vw where patient_no_fk = $patient_id order by  au_entry_at desc");

        $date_data = json_encode($vitals_data);

        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();

        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $current_page = "";
        return view("iCure-Home.patient.partials.emr.patient_emr", [
            'patient_info' => $patient_info,
            'alergies_data' => $alergies_data,
            'chronic_data' => $chronic_data,
            'date_data' => $date_data,
            'vitals_data' => $vitals_data,
            'patient_id' => $patient_id,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
        ]);
    }
    public function doctorEmr($patient_id = null)
    {


        $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();
        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $patient_id)->orderBy('a.au_entry_at', 'desc')->get();
        //       $vitals_data = DB::select("select * from psn_t_patvitals_ipd_vw where patient_no_fk = $patient_id order by  au_entry_at desc");

        $date_data = json_encode($vitals_data);

        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();
        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $current_page = "";

        //        return $patient_info;
        return view("iCure-Home.admin.doctor.doctor_emr", [
            'patient_info' => $patient_info,
            'alergies_data' => $alergies_data,
            'chronic_data' => $chronic_data,
            'date_data' => $date_data,
            'vitals_data' => $vitals_data,
            'patient_id' => $patient_id,
            'po_hospital_details' => $po_hospital_details,
            'current_page' => $current_page,
        ]);
    }

    public function emrTabAllData($patient_id = null, Request $request)
    {

        $tab_type = $request->tab_type;
        $patient_id = $request->patient_id;
        if ($tab_type == 1) {
            $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();

            return Template::loadView("admin.EMR.tabs.demographic_details", [
                'patient_info' => $patient_info,
            ]);
        }
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //medical Documents
     
        if ($tab_type == 13) {
            $pat_med_activities_wl = DB::select("select h.hospital_code, a.pat_medical_activity_no_pk, a.activity_no_fk, a.activity_name, a.patient_no_fk, a.pat_medical_activity_no_uid,
                 a.blood_group, a.patient_name, a.patient_photo,a.service_number,
                 a.gender_txt,a.marital_status_txt,a.age,
                 a.overall_status,a.pathology_cnt,a.radiology_cnt,a.appoint_cnt,a.vitals_cnt,
                 a.final_form, a.final_form_url, a.final_form_pages, a.final_report, a.final_report_url, a.final_report_pages, a.certificate_name, a.certificate_url, a.certificate_pages,
                 a.dms_ind, a.occmb_ind, a.smo_ind, a.flightsur_ind,
                 b.au_entry_at
                 from cmb_t_med_act_execute_wl_vw a
                 left join cmb_t_pat_medical_activitydtl b on a.pat_medical_activity_no_pk = b.pat_medical_activity_no_fk left join wsec_hospital h on h.hospital_no_pk  = a.au_entry_hospital_no_fk
                 where a.section_code = 'CMB' and A.PATIENT_NO_FK = '$patient_id'
                 group by a.pat_medical_activity_no_pk,h.hospital_code, a.activity_no_fk, a.activity_name, a.patient_no_fk, a.pat_medical_activity_no_uid,
                 a.blood_group, a.patient_name, a.patient_photo,a.service_number,
                 a.gender_txt,a.marital_status_txt,a.age,
                 a.overall_status,a.pathology_cnt,a.radiology_cnt,a.appoint_cnt,a.vitals_cnt,
                 a.final_form, a.final_form_url, a.final_form_pages, a.final_report, a.final_report_url, a.final_report_pages, a.certificate_name, a.certificate_url, a.certificate_pages,
                 a.dms_ind, a.occmb_ind, a.smo_ind, a.flightsur_ind,
                 b.au_entry_at
                 order by  b.au_entry_at desc
                 ");

            $activity_lists = DB::table('cmb_s_medical_activity')
                ->select("activity_no_pk", "activity_name", "activity_uid")->where('section_code', 'CMB')
                ->get()
                ->toArray();


            return Template::loadView("admin.EMR.tabs.medical_documents.medical_documents", [
                'pat_med_activities_wl' => $pat_med_activities_wl,
                'activity_lists' => $activity_lists,
            ]);
        }

        if ($tab_type == 14) {

            $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();
            // dd($patient_info);


            return Template::loadView("admin.EMR.tabs.demographic_details.demographic_details", [
                'patient_info' => $patient_info
            ]);
        }

        // vitals_data

        if ($tab_type == 12) {

            $patient_id = $request->patient_id;
            $alergies_data = DB::table('emr_allergies a')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();
            $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();

            $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')
                ->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.au_entry_at', 'desc')->get();
            // dd($vitals_data);

            return Template::loadView("admin.EMR.tabs.demographic_details.vitals", [
                'alergies_data' => $alergies_data,
                'chronic_data' => $chronic_data,
                'vitals_data' => $vitals_data,
                'patient_id' => $patient_id
            ]);
        }



        // medical equiment
        if ($tab_type == 2) {
            $patient_id = $request->patient_id;
            $medical_equiment = DB::table('psn_t_prescription_med_vw a')
                ->select('h.hospital_code', 'h.hospital_name', 'a.generic_name', 'a.brand_name', 'a.dosage', 'a.duration', 'a.duration_mu', 'a.item_qty')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.prescription_med_no_pk', 'desc')
                ->get();
            $current_equiment_data = DB::table('emr_medicalequipment a')
                ->select('h.hospital_code', 'h.hospital_name', 'a.medequ_name', 'a.medequ_start_date', 'a.medequ_end_date', 'a.start_time_of_engage', 'a.end_time_of_engage')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                // ->where('a.au_entry_hospital_no_fk',  Session::get('user.ses_hospital_no_pk'))
                ->where('a.patient_no_fk', $patient_id)->orderBy('a.au_entry_at', 'desc')->get();
            // dd($current_equiment_data);
            return Template::loadView(
                "admin.EMR.tabs.current_medical_usage.current_medical_usage",
                [
                    'medical_equiment' => $medical_equiment,
                    'current_equiment_data' => $current_equiment_data,
                    'patient_id' => $patient_id
                ]
            );
        }


        // past_medical_records
       
        if ($tab_type == 3) {
            $prescription_data = DB::table('psn_t_prescription_vw a')
                ->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.admission_no_fk', 0)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.au_entry_at', 'desc')->get();
            // dd($prescription_data);


            return Template::loadView(
                "admin.EMR.tabs.past_medical_records.past_medical_records",
                ['prescription_data' => $prescription_data]
            );
        }


        // family_disease

        if ($tab_type == 10) {
            $family_disease_data = DB::table("emr_familymedhistory a")
                ->select('h.hospital_code', 'a.relation_name', 'a.disease_name', 'a.disease_name', 'a.date_from', 'a.date_to', 'a.severity', 'a.suffered_duration', 'a.death_bydisease_ind', 'a.familymedhistory_no_pk')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->orderBy('a.au_entry_at', 'desc')->get();

            // dd($family_disease_data);

            return Template::loadView("admin.EMR.tabs.family_disease.family_disease", [
                'patient_id' => $patient_id,
                'family_disease_data' => $family_disease_data
            ]);
        }

        // sub tab for past medical records


        if ($tab_type == 5) {
            $lab_data = DB::table('labt_invoicedtl_vw a')
                ->select('a.item_name', 'report_url', 'a.report_delivery_date', 'a.invoice_no_fk', 'a.invoice_code', 'a.lab_code', 'a.report_no_fk', 'a.prescription_no_fk', 'a.lab_result_verify_key_ind', 'a.lab_result_final_key_ind', 'a.mail_ind', 'a.email')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->whereNotNull('a.lab_result_final_key_ind')
                ->whereNull('a.cancel_ind')
                ->orderBy('a.invoice_no_fk', 'desc')->get();
            // dd($patient_id,$lab_data);

            return Template::loadView("admin.EMR.tabs.past_medical_records.lab_report", [
                'lab_data' => $lab_data,
                'patient_id' => $patient_id
            ]);
        }

        // for prescription return

        if ($tab_type == 11) {
            $prescription_data = DB::table('psn_t_prescription_vw')
                ->where('patient_no_fk', $patient_id)
                // ->where('au_entry_hospital_no_fk', $ses_hospital_id)
                ->orderBy('au_entry_at', 'desc')->get();



            return Template::loadView("admin.EMR.tabs.past_medical_records.prescription", [
                'prescription_data' => $prescription_data
            ]);
        }


        if ($tab_type == 6) {
            $radiology_data = DB::table("radt_invoicedtl_app_wl_vw a")
                ->select('a.hospital_code', 'a.prescription_no_fk', 'a.invoice_code', 'a.item_name', 'a.report_delivary_date', 'a.radinvoicedtl_no_pk', 'a.finalize_key_ind')
                //->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                // ->leftJoin('radt_reporting_img img','a.radinvoicedtl_no_pk','img.radinvoicedtl_no_pk')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->whereNull('a.cancel_ind')
                ->orderBy('a.invoice_no_pk', 'desc')
                ->get();
            // dd($patient_id);
            $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->get();

            return Template::loadView("admin.EMR.tabs.past_medical_records.radiology", [
                'radiology_data' => $radiology_data,
                'patient_id' => $patient_id,
                'image_capture' => $image_capture
            ]);
        }

        if ($tab_type == 7) {
            $sergical_data = DB::table("opt_ot_confirmlist_wl_vw a")
                ->select('h.hospital_code', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.age', 'a.surg_doctor_name', 'a.ot_date', 'a.surg_doctor_name')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.ot_req_no_pk', 'desc')
                ->get();
            //             dd($sergical_data);

            return Template::loadView("admin.EMR.tabs.past_medical_records.surgical_history", [
                'sergical_data' => $sergical_data
            ]);
        }


        if ($tab_type == 8) {
            $hospitalized_data = DB::table("ipd_admitted_patlist_vw a")
                ->select('a.admission_date', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.dis_date', 'a.dis_reason')
                // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.admission_no_pk', 'desc')
                ->get();
            return Template::loadView("admin.EMR.tabs.past_medical_records.hospitalized_history", [
                'hospitalized_data' => $hospitalized_data
            ]);
        }

        if ($tab_type == 9) {
            $immunization_data = DB::table("emr_patimmunization a")
                ->select('a.immunization_start_date', 'a.immunization_name', 'a.dose_number', 'a.immunization_no_pk')
                // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.au_entry_at', 'desc')
                ->get();


            return Template::loadView("admin.EMR.tabs.past_medical_records.immunization_history", [
                'immunization_data' => $immunization_data,
                'patient_id' => $patient_id
            ]);
        }

        // Physiotherapy details
        if ($tab_type == 20) {

            $physiotherapy_details = db::table("prest_prescriptionmst_physio_vw a")
                ->leftjoin('prest_prescriptiondtl_physio_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
                ->select('a.prescription_no_pk', 'a.prescription_date', 'a.prescription_code', 'a.doctor_name', 'b.presdtl_data')
                ->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE', 'ACUP'])
                ->where('a.patient_no_fk', $patient_id)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.status", 1)
                //->where("a.prescription_date", date('Y-m-d'))
                //->whereRaw(DB::raw("a.prescription_date=to_date('$DstartDate','YY-MM-DD')"))
                //->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE','ACUP'])
                // ->groupby('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_photo', 'a.patient_code', 'a.gender_txt', 'a.mobile1')
                ->orderBy('a.prescription_no_pk', 'desc')
                ->get();
            return Template::loadView("admin.EMR.tabs.past_medical_records.physiotherapy_history", [
                'physiotherapy_details' => $physiotherapy_details
            ]);
        }
    }


    public function dueCalculate($invoice_no)
    {
        $account_info = DB::table('finc_voucherwise_vw')
            ->select('patient_name', 'age', 'gender_txt', 'mobile1', DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(collection) as collection'))
            ->where('invoice_code', $invoice_no)
            ->groupBy('patient_name', 'age', 'gender_txt', 'mobile1')
            ->first();

        $due = ($account_info->sales - $account_info->discount) - $account_info->collection;
        // dd($account_info,$due);
        return round($due);
    }
    // public function sendMailLabReport(Request $request)
    // {
    //     try {
    //         $report_id = $request->report_id;
    //         $pat_info = DB::table('patn_registration')->select('email')->where('patient_no_pk', $request->pat_id)->first();
    //         if ($pat_info->email != "") {
    //             $auth_id = Auth::id();
    //             $to_date = date('Y-m-d');
    //             $report_header = DB::table("labt_testreportresultprint_vw")->select(
    //                 'invoice_code',
    //                 'patient_code',
    //                 'report_code',
    //                 'patient_name',
    //                 'age',
    //                 'dob',
    //                 'gender_txt',
    //                 'ref_doc_name',
    //                 'ref_doc_name_degree1',
    //                 'ref_doc_name_degree2',
    //                 'ref_doc_name_degree3',
    //                 'ward_name',
    //                 'bed_name',
    //                 'passport_no',
    //                 'sam_name',
    //                 'admission_no_pk',
    //                 'lab_code',
    //                 'order_date',
    //                 'item_code_list',
    //                 'report_test_name_list',
    //                 'sc_sample_coll_keyed_time',
    //                 'sample_received_time',
    //                 'serviceunit_name',
    //                 'analyzer_desc',
    //                 'test_method',
    //                 'interpretation',
    //                 'comments_text',
    //                 'note_text',
    //                 'prepared_by',
    //                 'pr_digital_signature_ind',
    //                 'pr_doctor_signature_image',
    //                 'pr_doctor_signature',
    //                 'verified_by',
    //                 'vr_digital_signature_ind',
    //                 'vr_doctor_signature_image',
    //                 'vr_doctor_signature',
    //                 'finalized_by',
    //                 'fin_digital_signature_ind',
    //                 'fin_doctor_signature_image',
    //                 'fin_doctor_signature',
    //                 'ent_digital_signature_ind',
    //                 'ent_doctor_signature_image',
    //                 'ent_doctor_signature',
    //             )->where('report_no_pk', $report_id)->first();
    //             $po_hospital_details = DB::table("wsec_hospital")->first();
    //             $report_varcode = "";
    //             $invoice_varcode = "";
    //             $patient_varcode = "";
    //             if (!empty($report_header)) {
    //                 $barcode = new BarcodeGenerator();
    //                 $barcode->setText($report_header->report_code);
    //                 $barcode->setType(BarcodeGenerator::Code128);
    //                 $barcode->setLabel('');
    //                 $barcode->setScale(1);
    //                 $barcode->setThickness(25);
    //                 $barcode->setFontSize(10);
    //                 $report_varcode = $barcode->generate();

    //                 $barcode1 = new BarcodeGenerator();
    //                 $barcode1->setText($report_header->invoice_code);
    //                 $barcode1->setType(BarcodeGenerator::Code128);
    //                 $barcode1->setScale(1);
    //                 $barcode1->setLabel('');
    //                 $barcode1->setThickness(25);
    //                 $barcode1->setFontSize(10);
    //                 $invoice_varcode = $barcode1->generate();

    //                 $barcode2 = new BarcodeGenerator();
    //                 $barcode2->setText($report_header->patient_code);
    //                 $barcode2->setType(BarcodeGenerator::Code128);
    //                 $barcode2->setScale(1);
    //                 $barcode2->setLabel('');
    //                 $barcode2->setThickness(25);
    //                 $barcode2->setFontSize(10);
    //                 $patient_varcode = $barcode2->generate();
    //             }
    //             $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

    //             $report_data = DB::table("labt_testresultstruct_vw")
    //                 ->where('report_no_fk', $report_id)
    //                 ->where('show_in_rep', 1)
    //                 ->where('cancel_ind', null)
    //                 ->orderBy('sl_no', 'ASC')
    //                 ->orderBy('group_seq', 'ASC')
    //                 ->get()
    //                 ->toArray();

    //             $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
    //                 ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
    //                 ->where('report_no_fk', $report_id)
    //                 ->where('show_in_rep', 1)
    //                 ->orderBy('sl_no', 'ASC')
    //                 ->orderBy('group_seq', 'ASC')
    //                 ->first();

    //             $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

    //             $attr_group = [];
    //             $result_data = [];
    //             $pat_dob = new \DateTime($report_header->dob);
    //             $invoice_date = new \DateTime($report_header->order_date);
    //             $interval = $invoice_date->diff($pat_dob);
    //             $dob = $interval->format('%y');
    //             $gender_text = strtoupper($report_header->gender_txt);
    //             foreach ($report_data as $k => $value) {
    //                 if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
    //                     $ference_value = DB::table('labs_testreferencevalue')
    //                         ->where('teststruct_no_fk', $value->teststruct_no_fk)
    //                         ->get()->toArray();

    //                     if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

    //                         $result_data_ind = 0;
    //                         $result_arrow_sign_ind = '';
    //                         $referencevalue_value = '';

    //                         foreach ($ference_value as $kye => $data) {

    //                             $age_range = range($data->low_age_yy, $data->high_age_yy);
    //                             $filteredArray = in_array($dob, $age_range) ? true : false;

    //                             if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) >= $data->low_result && (float) str_replace(',', '', $value->result0) <= $data->high_result) {
    //                                 $result_data_ind = 1;
    //                             }
    //                             if (in_array(Session::get('user.ses_hospital_code'), ["UNICO"])) {

    //                                 if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) < $data->low_result) {
    //                                     $result_arrow_sign_ind = '↓';
    //                                 } elseif ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) > $data->high_result) {
    //                                     $result_arrow_sign_ind = '↑';
    //                                 }
    //                             }
    //                             if ($filteredArray == true && strtoupper($data->gender) == $gender_text) {
    //                                 $referencevalue_value = $data->normal_result;
    //                             }
    //                         }

    //                         $result_data = [
    //                             'attr' => $value->attr,
    //                             'result0' => $value->result0,
    //                             'unit' => $value->unit,
    //                             'referencevalue' => $referencevalue_value,
    //                             'result_data_ind' => $result_data_ind,
    //                             'result_arrow_sign_ind' => $result_arrow_sign_ind,
    //                             'graph_ind' => $value->graph_ind,
    //                         ];
    //                     } else {

    //                         $result_data_ind = 0;
    //                         $result_arrow_sign_ind = '';
    //                         $result_data = [
    //                             'attr' => $value->attr,
    //                             'result0' => $value->result0,
    //                             'unit' => $value->unit,
    //                             'referencevalue' => $value->referencevalue,
    //                             'result_data_ind' => $result_data_ind,
    //                             'result_arrow_sign_ind' => $result_arrow_sign_ind,
    //                             'graph_ind' => $value->graph_ind,
    //                         ];
    //                     }
    //                     $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
    //                 } else {

    //                     $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
    //                 }
    //             }
    //             $data = [
    //                 'result_print_key_ind' => 1,
    //                 'result_print_keyed_by' => $auth_id,
    //                 'result_print_keyed_time' => $to_date,
    //             ];
    //             // AU_UPDATE_BY
    //             $data['au_update_by'] = $auth_id;
    //             $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
    //             DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
    //             $pdf = App::make('dompdf.wrapper');
    //             $pdf = PDF::loadView('admin.patient-portal.report.invoice', [
    //                 "report_varcode" => $report_varcode,
    //                 "report_label" => $report_label,
    //                 "invoice_varcode" => $invoice_varcode,
    //                 "report_header" => $report_header,
    //                 'po_hospital_details' => $po_hospital_details,
    //                 'data' => $data,
    //                 "report_data" => $report_data,
    //                 'attr_group' => $attr_group,
    //                 'patient_varcode' => $patient_varcode
    //             ]);

    //             $subject = "Medical Report";
    //             $messageBody = $report_header->patient_name . " your  Patient Id " . $report_header->patient_code . ' and Invoice No ' . $report_header->invoice_code . ' ' . $report_header->report_test_name_list . ' report completed.';
    //             // $pat_info->email

    //             $this->sendCustomMail($pat_info->email, '', $subject, $messageBody, $pdf);

    //             $message = ['msg' => 'Email Send to User', 'title' => 'Success'];

    //             $data = [
    //                 'mail_ind' => 1
    //             ];
    //             DB::table('labt_invoicedtl')->where('report_no_fk', $report_id)->update($data);
    //             DB::commit();
                
    //         }
    //         $message = ['msg' => 'No Patient Email Id', 'title' => 'Error'];
    //     } catch (\Throwable $th) {
    //         DB::rollback();
    //         $message = ['msg' => 'Email not Send', 'title' => 'Error'];
    //     }
    //     return response()->json($message);
    // }


    public function sendMailLabReport(Request $request)
{
    try {
      
        $report_ids = is_array($request->report_id) ? $request->report_id : [$request->report_id];
       
        $pat_info = DB::table('patn_registration')->select('email')->where('patient_no_pk', $request->pat_id)->first();
      
        if ($pat_info->email != "") {
          
            $auth_id = Auth::id();
            $to_date = date('Y-m-d');
            $po_hospital_details = DB::table("wsec_hospital")->first();
            
            $pdfs = [];
            $report_test_names = [];
            $invoice_codes ='';
            $patient_name ='';
            $patient_code ='';
            $email ='';
            $reportUrl =[];
            
            foreach ($report_ids as $report_id) {
                  
                // $report_header = DB::table("labt_testreportresultprint_vw")->select(
                //     'invoice_code',
                //     'patient_code',
                //     'report_code',
                //     'patient_name',
                //     'age',
                //     'dob',
                //     'gender_txt',
                //     'ref_doc_name',
                //     'ref_doc_name_degree1',
                //     'ref_doc_name_degree2',
                //     'ref_doc_name_degree3',
                //     'ward_name',
                //     'bed_name',
                //     'passport_no',
                //     'sam_name',
                //     'admission_no_pk',
                //     'lab_code',
                //     'order_date',
                //     'item_code_list',
                //     'report_test_name_list',
                //     'sc_sample_coll_keyed_time',
                //     'sample_received_time',
                //     'serviceunit_name',
                //     'analyzer_desc',
                //     'test_method',
                //     'interpretation',
                //     'comments_text',
                //     'note_text',
                //     'prepared_by',
                //     'pr_digital_signature_ind',
                //     'pr_doctor_signature_image',
                //     'pr_doctor_signature',
                //     'verified_by',
                //     'vr_digital_signature_ind',
                //     'vr_doctor_signature_image',
                //     'vr_doctor_signature',
                //     'finalized_by',
                //     'fin_digital_signature_ind',
                //     'fin_doctor_signature_image',
                //     'fin_doctor_signature',
                //     'ent_digital_signature_ind',
                //     'ent_doctor_signature_image',
                //     'ent_doctor_signature',
                // )->where('report_no_pk', $report_id->report_no_fk)->first();                
                // if (!empty($report_header)) {
                //     // Generate barcodes
                //     $barcode = new BarcodeGenerator();
                //     $barcode->setText($report_header->report_code);
                //     $barcode->setType(BarcodeGenerator::Code128);
                //     $barcode->setLabel('');
                //     $barcode->setScale(1);
                //     $barcode->setThickness(25);
                //     $barcode->setFontSize(10);
                //     $report_varcode = $barcode->generate();

                //     $barcode1 = new BarcodeGenerator();
                //     $barcode1->setText($report_header->invoice_code);
                //     $barcode1->setType(BarcodeGenerator::Code128);
                //     $barcode1->setScale(1);
                //     $barcode1->setLabel('');
                //     $barcode1->setThickness(25);
                //     $barcode1->setFontSize(10);
                //     $invoice_varcode = $barcode1->generate();

                //     $barcode2 = new BarcodeGenerator();
                //     $barcode2->setText($report_header->patient_code);
                //     $barcode2->setType(BarcodeGenerator::Code128);
                //     $barcode2->setScale(1);
                //     $barcode2->setLabel('');
                //     $barcode2->setThickness(25);
                //     $barcode2->setFontSize(10);
                //     $patient_varcode = $barcode2->generate();
                    
                //     // Get report data
                //     $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id->report_no_fk)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

                //     $report_data = DB::table("labt_testresultstruct_vw")
                //         ->where('report_no_fk', $report_id->report_no_fk)
                //         ->where('show_in_rep', 1)
                //         ->where('cancel_ind', null)
                //         ->orderBy('sl_no', 'ASC')
                //         ->orderBy('group_seq', 'ASC')
                //         ->get()
                //         ->toArray();

                //     $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                //         ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                //         ->where('report_no_fk', $report_id->report_no_fk)
                //         ->where('show_in_rep', 1)
                //         ->orderBy('sl_no', 'ASC')
                //         ->orderBy('group_seq', 'ASC')
                //         ->first();

                //     $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

                //     // Process report data
                //     $attr_group = [];
                //     $result_data = [];
                //     $pat_dob = new \DateTime($report_header->dob);
                //     $invoice_date = new \DateTime($report_header->order_date);
                //     $interval = $invoice_date->diff($pat_dob);
                //     $dob = $interval->format('%y');
                //     $gender_text = strtoupper($report_header->gender_txt);
                    
                //    foreach ($report_data as $k => $value) {
                //     if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
                //         $ference_value = DB::table('labs_testreferencevalue')
                //             ->where('teststruct_no_fk', $value->teststruct_no_fk)
                //             ->get()->toArray();

                //         if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

                //             $result_data_ind = 0;
                //             $result_arrow_sign_ind = '';
                //             $referencevalue_value = '';

                //             foreach ($ference_value as $kye => $data) {

                //                 $age_range = range($data->low_age_yy, $data->high_age_yy);
                //                 $filteredArray = in_array($dob, $age_range) ? true : false;

                //                 if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) >= $data->low_result && (float) str_replace(',', '', $value->result0) <= $data->high_result) {
                //                     $result_data_ind = 1;
                //                 }
                //                 if (in_array(Session::get('user.ses_hospital_code'), ["UNICO"])) {

                //                     if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) < $data->low_result) {
                //                         $result_arrow_sign_ind = '↓';
                //                     } elseif ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) > $data->high_result) {
                //                         $result_arrow_sign_ind = '↑';
                //                     }
                //                 }
                //                 if ($filteredArray == true && strtoupper($data->gender) == $gender_text) {
                //                     $referencevalue_value = $data->normal_result;
                //                 }
                //             }

                //             $result_data = [
                //                 'attr' => $value->attr,
                //                 'result0' => $value->result0,
                //                 'unit' => $value->unit,
                //                 'referencevalue' => $referencevalue_value,
                //                 'result_data_ind' => $result_data_ind,
                //                 'result_arrow_sign_ind' => $result_arrow_sign_ind,
                //                 'graph_ind' => $value->graph_ind,
                //             ];
                //         } else {

                //             $result_data_ind = 0;
                //             $result_arrow_sign_ind = '';
                //             $result_data = [
                //                 'attr' => $value->attr,
                //                 'result0' => $value->result0,
                //                 'unit' => $value->unit,
                //                 'referencevalue' => $value->referencevalue,
                //                 'result_data_ind' => $result_data_ind,
                //                 'result_arrow_sign_ind' => $result_arrow_sign_ind,
                //                 'graph_ind' => $value->graph_ind,
                //             ];
                //         }
                //         $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
                //     } else {

                //         $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                //     }
                // }
                // // Generate PDF
                // $pdf = PDF::loadView('admin.patient-portal.report.invoice', [
                //     "report_varcode" => $report_varcode,
                //     "report_label" => $report_label,
                //     "invoice_varcode" => $invoice_varcode,
                //     "report_header" => $report_header,
                //     'po_hospital_details' => $po_hospital_details,
                //     'data' => $data,
                //     "report_data" => $report_data,
                //     'attr_group' => $attr_group,
                //     'patient_varcode' => $patient_varcode
                // ]);
                  
                    $reportHeader=DB::table('labt_invoicedtl_vw')->select('invoice_code','item_name','report_no_fk','patient_code','patient_name','email','report_url')->where('report_no_fk',$report_id)->whereNull('cancel_ind')->first();
                  
                    $pdfs[] = [];
                    $report_test_names[] = $reportHeader->item_name;
                    $invoice_codes = $reportHeader->invoice_code;
                    $patient_name = $reportHeader->patient_name;
                    $patient_code = $reportHeader->patient_code;
                    $email = $reportHeader->email;
                    $url = route($reportHeader->report_url,$reportHeader->report_no_fk);

                     $repUrl=preg_replace('/^.*(?=\/public)/', 'http://115.127.139.2:8085/h360_uhl', $url);
                    
                    $reportUrl[] = $reportHeader->report_url !=''?  '<a href="'. $repUrl.'" class="btn btn-sm btn-warning" target="_blank">' . $reportHeader->item_name . '</a>':'No Report Url';

                    // Update database
                    $data = [
                        'result_print_key_ind' => 1,
                        'result_print_keyed_by' => $auth_id,
                        'result_print_keyed_time' => $to_date,
                        'au_update_by' => $auth_id,
                        'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                    ];
                    DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
                    
                    DB::table('labt_invoicedtl')->where('report_no_fk', $report_id)->update(['mail_ind' => 1]);
                // }
                
            }
            if ($email !='') {
              
                $subject = "Medical Report";
                $messageBody = $patient_name . " your Patient Id " . $patient_code . 
                    ' and Invoice No ' . $invoice_codes . ' report completed. Click For Print .'  . implode(', ', $reportUrl) ;
              
                $this->sendCustomMail($pat_info->email, '', $subject, $messageBody, $pdfs);
                
                $message = ['msg' => 'Email Sent to User with ' . count($pdfs) . ' reports', 'title' => 'Success'];
                DB::commit();
            } else {
                $message = ['msg' => 'No valid reports found', 'title' => 'Error'];
            }
        } else {
            $message = ['msg' => 'No Patient Email Id', 'title' => 'Error'];
        }
    } catch (\Throwable $th) {
        DB::rollback();
        $message = ['msg' => 'Email not Send: ' . $th->getMessage(), 'title' => 'Error'];
    }
    return response()->json($message);
}

    public function sendSmsRadReport(Request $request,$radinvoicedtl_no_pk)
    {
        try {
            $report_id = $request->report_id;
            $pat_info = DB::table('patn_registration')->select('email')->where('patient_no_pk', $request->pat_id)->first();
            if ($pat_info->email != "") {
                $auth_id = Auth::id();
                $to_date = date('Y-m-d');
                $report_header = DB::table("labt_testreportresultprint_vw")->select(
                    'invoice_code',
                    'patient_code',
                    'report_code',
                    'patient_name',
                    'age',
                    'dob',
                    'gender_txt',
                    'ref_doc_name',
                    'ref_doc_name_degree1',
                    'ref_doc_name_degree2',
                    'ref_doc_name_degree3',
                    'ward_name',
                    'bed_name',
                    'passport_no',
                    'sam_name',
                    'admission_no_pk',
                    'lab_code',
                    'order_date',
                    'item_code_list',
                    'report_test_name_list',
                    'sc_sample_coll_keyed_time',
                    'sample_received_time',
                    'serviceunit_name',
                    'analyzer_desc',
                    'test_method',
                    'interpretation',
                    'comments_text',
                    'note_text',
                    'prepared_by',
                    'pr_digital_signature_ind',
                    'pr_doctor_signature_image',
                    'pr_doctor_signature',
                    'verified_by',
                    'vr_digital_signature_ind',
                    'vr_doctor_signature_image',
                    'vr_doctor_signature',
                    'finalized_by',
                    'fin_digital_signature_ind',
                    'fin_doctor_signature_image',
                    'fin_doctor_signature',
                    'ent_digital_signature_ind',
                    'ent_doctor_signature_image',
                    'ent_doctor_signature',
                )->where('report_no_pk', $report_id)->first();
                $po_hospital_details = DB::table("wsec_hospital")->first();
                $report_varcode = "";
                $invoice_varcode = "";
                $patient_varcode = "";
                if (!empty($report_header)) {
                    $barcode = new BarcodeGenerator();
                    $barcode->setText($report_header->report_code);
                    $barcode->setType(BarcodeGenerator::Code128);
                    $barcode->setLabel('');
                    $barcode->setScale(1);
                    $barcode->setThickness(25);
                    $barcode->setFontSize(10);
                    $report_varcode = $barcode->generate();

                    $barcode1 = new BarcodeGenerator();
                    $barcode1->setText($report_header->invoice_code);
                    $barcode1->setType(BarcodeGenerator::Code128);
                    $barcode1->setScale(1);
                    $barcode1->setLabel('');
                    $barcode1->setThickness(25);
                    $barcode1->setFontSize(10);
                    $invoice_varcode = $barcode1->generate();

                    $barcode2 = new BarcodeGenerator();
                    $barcode2->setText($report_header->patient_code);
                    $barcode2->setType(BarcodeGenerator::Code128);
                    $barcode2->setScale(1);
                    $barcode2->setLabel('');
                    $barcode2->setThickness(25);
                    $barcode2->setFontSize(10);
                    $patient_varcode = $barcode2->generate();
                }
                $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

                $report_data = DB::table("labt_testresultstruct_vw")
                    ->where('report_no_fk', $report_id)
                    ->where('show_in_rep', 1)
                    ->where('cancel_ind', null)
                    ->orderBy('sl_no', 'ASC')
                    ->orderBy('group_seq', 'ASC')
                    ->get()
                    ->toArray();

                $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                    ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                    ->where('report_no_fk', $report_id)
                    ->where('show_in_rep', 1)
                    ->orderBy('sl_no', 'ASC')
                    ->orderBy('group_seq', 'ASC')
                    ->first();

                $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

                $attr_group = [];
                $result_data = [];
                $pat_dob = new \DateTime($report_header->dob);
                $invoice_date = new \DateTime($report_header->order_date);
                $interval = $invoice_date->diff($pat_dob);
                $dob = $interval->format('%y');
                $gender_text = strtoupper($report_header->gender_txt);
                foreach ($report_data as $k => $value) {
                    if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
                        $ference_value = DB::table('labs_testreferencevalue')
                            ->where('teststruct_no_fk', $value->teststruct_no_fk)
                            ->get()->toArray();

                        if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

                            $result_data_ind = 0;
                            $result_arrow_sign_ind = '';
                            $referencevalue_value = '';

                            foreach ($ference_value as $kye => $data) {

                                $age_range = range($data->low_age_yy, $data->high_age_yy);
                                $filteredArray = in_array($dob, $age_range) ? true : false;

                                if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) >= $data->low_result && (float) str_replace(',', '', $value->result0) <= $data->high_result) {
                                    $result_data_ind = 1;
                                }
                                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO"])) {

                                    if ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) < $data->low_result) {
                                        $result_arrow_sign_ind = '↓';
                                    } elseif ($filteredArray == true && strtoupper($data->gender) == $gender_text && (float) str_replace(',', '', $value->result0) > $data->high_result) {
                                        $result_arrow_sign_ind = '↑';
                                    }
                                }
                                if ($filteredArray == true && strtoupper($data->gender) == $gender_text) {
                                    $referencevalue_value = $data->normal_result;
                                }
                            }

                            $result_data = [
                                'attr' => $value->attr,
                                'result0' => $value->result0,
                                'unit' => $value->unit,
                                'referencevalue' => $referencevalue_value,
                                'result_data_ind' => $result_data_ind,
                                'result_arrow_sign_ind' => $result_arrow_sign_ind,
                                'graph_ind' => $value->graph_ind,
                            ];
                        } else {

                            $result_data_ind = 0;
                            $result_arrow_sign_ind = '';
                            $result_data = [
                                'attr' => $value->attr,
                                'result0' => $value->result0,
                                'unit' => $value->unit,
                                'referencevalue' => $value->referencevalue,
                                'result_data_ind' => $result_data_ind,
                                'result_arrow_sign_ind' => $result_arrow_sign_ind,
                                'graph_ind' => $value->graph_ind,
                            ];
                        }
                        $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
                    } else {

                        $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                    }
                }
                $data = [
                    'result_print_key_ind' => 1,
                    'result_print_keyed_by' => $auth_id,
                    'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
                $pdf = App::make('dompdf.wrapper');
                $pdf = PDF::loadView('admin.patient-portal.report.invoice', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode
                ]);

                $subject = "Medical Report";
                $messageBody = $report_header->patient_name . " your  Patient Id " . $report_header->patient_code . ' and Invoice No ' . $report_header->invoice_code . ' ' . $report_header->report_test_name_list . ' report completed.';
                // $pat_info->email

                $this->sendCustomMail($pat_info->email, '', $subject, $messageBody, $pdf);

                $message = ['msg' => 'Email Send to User', 'title' => 'Success'];

                $data = [
                    'mail_ind' => 1
                ];
                DB::table('labt_invoicedtl')->where('report_no_fk', $report_id)->update($data);
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => 'Email not Send', 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function sendSmsLabReport(Request $request)
    {

        try {
            // dd($request->all());
           
                $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
                $company_profile = Company::orderBy('hospital_no_pk', 'desc')->where('hospital_no_pk', $ses_hospital_id)->first();
                $sendAction=true;//false;
              
                if (in_array($company_profile->hospital_code, ["UNICO"]) &&  $sendAction) {
                    
                $company_name = isset($company_profile->hospital_name) ? $company_profile->hospital_name : '';
                $company_adderss = isset($company_profile->addrress1) ? $company_profile->addrress1 : '';
                $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';


                // Phone number formatting
                $customer_phone = ltrim($request->mobileNo, '+');
                $check_88 = substr($customer_phone, 0, 2);
                $cust_phone = ($check_88 == "88") ? substr($customer_phone, 2) : $customer_phone; // Remove 88 if present                   
                $url = "https://smpp.revesms.com:7790/sendtext";
                $text = $request->text;
                $newText = str_replace(":COMPANYNAME", $company_name, $text);
                // dd($newText);
                $data = [
                    "apikey" => "94545627a85de3f5", // Your API key
                    "secretkey" => "6a148cb0", // You're missing this required field
                    "callerID" => "UNICO.Hosp", // Sender ID
                    "toUser" => $cust_phone, // Recipient number (without 88)
                    "messageContent" => $newText
                ];
                // dd(  $data);
                $ch = curl_init();

                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($data),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_CAINFO => '/etc/pki/tls/certs/ca-bundle.crt',
                    // Add these security options:
                    CURLOPT_SSL_CIPHER_LIST => 'DEFAULT:@SECLEVEL=1',
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_VERBOSE => true
                ]);


                // this for only xampp local 
                    // curl_setopt_array($ch, [
                    //     CURLOPT_URL => $url,
                    //     CURLOPT_POST => true,
                    //     CURLOPT_POSTFIELDS => http_build_query($data),
                    //     CURLOPT_RETURNTRANSFER => true,
                    //     CURLOPT_SSL_VERIFYHOST => 0, 
                    //     CURLOPT_SSL_VERIFYPEER => 0,  
                    //     CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,                
                    //     // Add timeout to prevent hanging
                    //     CURLOPT_TIMEOUT => 30,                
                    //     // Enable verbose for debugging
                    //     CURLOPT_VERBOSE => true,
                    //     CURLOPT_STDERR => fopen('curl_log.txt', 'w+') // Log to file
                    // ]);
                // end local code



                $response = curl_exec($ch);
                $error = curl_error($ch);
                curl_close($ch);
                // Properly handle the response
                if ($response === false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'SMS sending failed: ' . $error
                    ], 500);
                } else {
                    DB::table('labt_invoicedtl')->where('invoice_no_fk', $request->id)->update(['sms_ind', 1]);
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'SMS sent successfully',
                        'response' => $response
                    ]);
                }

                
            }

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }


    public function emrTabAllDataUHL($patient_id = null, Request $request)
    {
        $tab_type = $request->tab_type;
        $patient_id = $request->patient_id;
        if ($tab_type == 1) {
            $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();
            return Template::loadView("admin.EMR.uhl.tabs.demographic_details_uhl", [
                'patient_info' => $patient_info,
            ]);
        }
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //medical Documents
        if ($tab_type == 13) {
            $pat_med_activities_wl = DB::select("select h.hospital_code, a.pat_medical_activity_no_pk, a.activity_no_fk, a.activity_name, a.patient_no_fk, a.pat_medical_activity_no_uid,
                 a.blood_group, a.patient_name, a.patient_photo,a.service_number,
                 a.gender_txt,a.marital_status_txt,a.age,
                 a.overall_status,a.pathology_cnt,a.radiology_cnt,a.appoint_cnt,a.vitals_cnt,
                 a.final_form, a.final_form_url, a.final_form_pages, a.final_report, a.final_report_url, a.final_report_pages, a.certificate_name, a.certificate_url, a.certificate_pages,
                 a.dms_ind, a.occmb_ind, a.smo_ind, a.flightsur_ind,
                 b.au_entry_at
                 from cmb_t_med_act_execute_wl_vw a
                 left join cmb_t_pat_medical_activitydtl b on a.pat_medical_activity_no_pk = b.pat_medical_activity_no_fk left join wsec_hospital h on h.hospital_no_pk  = a.au_entry_hospital_no_fk
                 where a.section_code = 'CMB' and A.PATIENT_NO_FK = '$patient_id'
                 group by a.pat_medical_activity_no_pk,h.hospital_code, a.activity_no_fk, a.activity_name, a.patient_no_fk, a.pat_medical_activity_no_uid,
                 a.blood_group, a.patient_name, a.patient_photo,a.service_number,
                 a.gender_txt,a.marital_status_txt,a.age,
                 a.overall_status,a.pathology_cnt,a.radiology_cnt,a.appoint_cnt,a.vitals_cnt,
                 a.final_form, a.final_form_url, a.final_form_pages, a.final_report, a.final_report_url, a.final_report_pages, a.certificate_name, a.certificate_url, a.certificate_pages,
                 a.dms_ind, a.occmb_ind, a.smo_ind, a.flightsur_ind,
                 b.au_entry_at
                 order by  b.au_entry_at desc
                 ");

            $activity_lists = DB::table('cmb_s_medical_activity')
                ->select("activity_no_pk", "activity_name", "activity_uid")->where('section_code', 'CMB')
                ->get()
                ->toArray();


            return Template::loadView("admin.EMR.tabs.medical_documents.medical_documents", [
                'pat_med_activities_wl' => $pat_med_activities_wl,
                'activity_lists' => $activity_lists,
            ]);
        }

        if ($tab_type == 14) {
            $patient_info = DB::table('pat_registration_wl_vw')->where('patient_no_pk', $patient_id)->first();
            return Template::loadView("admin.EMR.tabs.demographic_details.demographic_details", [
                'patient_info' => $patient_info
            ]);
        }

        // vitals_data

        if ($tab_type == 12) {
            $patient_id = $request->patient_id;
            $alergies_data = DB::table('emr_allergies a')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();
            $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $patient_id)->orderBy('au_entry_at', 'desc')->get();

            $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')
                ->select(
                    'h.hospital_code',
                    'a.chief_complaints',
                    'a.temp_val',
                    'a.temp_val_time',
                    'a.height_val',
                    'a.h_mu_name',
                    'a.weight_val',
                    'a.w_mu_name',
                    'a.bp_val_dia',
                    'a.bp_val_sys',
                    'a.pulse_val',
                    'a.ofc',
                    'a.vital_date',
                    'a.bmi',
                    'a.spo2_value',
                    'a.au_entry_at'
                )
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.au_entry_at', 'desc')->get();

            // return Template::loadView("admin.EMR.uhl.tabs.demographic_details_uhl.vitals_uhl", [
            //     'alergies_data' => $alergies_data,
            //     'chronic_data' => $chronic_data,
            //     'vitals_data' => $vitals_data,
            //     'patient_id' => $patient_id
            // ]);
            return Template::loadView("admin.EMR.uhl.tabs.demographic_details_uhl", [
                'alergies_data' => $alergies_data,
                'chronic_data' => $chronic_data,
                'vitals_data' => $vitals_data,
                'patient_id' => $patient_id
            ]);
        }



        // medical equiment
        if ($tab_type == 2) {
            $patient_id = $request->patient_id;
            $medical_equiment = DB::table('psn_t_prescription_med_vw a')
                ->select('h.hospital_code', 'h.hospital_name', 'a.generic_name', 'a.brand_name', 'a.dosage', 'a.duration', 'a.duration_mu', 'a.item_qty', 'a.au_entry_at')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.au_entry_at', 'desc')
                ->get();
            $current_equiment_data = DB::table('emr_medicalequipment a')
                ->select('h.hospital_code', 'h.hospital_name', 'a.medequ_name', 'a.medequ_start_date', 'a.medequ_end_date', 'a.start_time_of_engage', 'a.end_time_of_engage')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                // ->where('a.au_entry_hospital_no_fk',  Session::get('user.ses_hospital_no_pk'))
                ->where('a.patient_no_fk', $patient_id)->orderBy('a.au_entry_at', 'desc')->get();
            // dd($medical_equiment);
            return Template::loadView(
                "admin.EMR.uhl.tabs.current_medical_usage_uhl.current_medical_usage_uhl",
                [
                    'medical_equiment' => $medical_equiment,
                    'current_equiment_data' => $current_equiment_data,
                    'patient_id' => $patient_id
                ]
            );
        }


        // past_medical_records

        if ($tab_type == 3) {
            $prescription_data = DB::table('psn_t_prescription_vw a')
                ->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.au_entry_at', 'desc')->get();
            return Template::loadView(
                "admin.EMR.uhl.tabs.past_medical_records_uhl.past_medical_records_uhl",
                ['prescription_data' => $prescription_data]
            );
        }


        // family_disease

        if ($tab_type == 10) {
            $family_disease_data = DB::table("emr_familymedhistory a")
                ->select('h.hospital_code', 'a.relation_name', 'a.disease_name', 'a.disease_name', 'a.date_from', 'a.date_to', 'a.severity', 'a.suffered_duration', 'a.death_bydisease_ind', 'a.familymedhistory_no_pk')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.patient_no_fk', $patient_id)
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->orderBy('a.au_entry_at', 'desc')->get();

            // dd($family_disease_data);

            return Template::loadView("admin.EMR.uhl.tabs.family_disease_uhl.family_disease_uhl", [
                'patient_id' => $patient_id,
                'family_disease_data' => $family_disease_data
            ]);
        }

        // sub tab for past medical records


        if ($tab_type == 5) {
            $lab_data = DB::table('labt_invoicedtl_vw a')
                ->select('a.item_name', 'a.invoice_date', 'a.report_delivary_date', 'a.invoice_code', 'a.lab_code', 'a.report_no_fk', 'a.prescription_no_fk')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.invoice_date', 'desc')->get();
            // dd($lab_data);

            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.lab_report_uhl", [
                'lab_data' => $lab_data,
                'patient_id' => $patient_id
            ]);
        }

        // for prescription return

        if ($tab_type == 11) {
            $prescription_data = DB::table('psn_t_prescription_vw')
                ->where('patient_no_fk', $patient_id)
                // ->where('au_entry_hospital_no_fk', $ses_hospital_id)
                ->orderBy('au_entry_at', 'desc')->get();
            // dd($prescription_data);
            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.prescription_uhl", [
                'prescription_data' => $prescription_data
            ]);
        }


        if ($tab_type == 6) {
            $radiology_data = DB::table("radt_invoicedtl_app_wl_vw a")
                ->select('a.hospital_code', 'a.prescription_no_fk', 'a.invoice_code', 'a.item_name', 'a.invoice_date', 'a.radinvoicedtl_no_pk')
                //->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                // ->leftJoin('radt_reporting_img img','a.radinvoicedtl_no_pk','img.radinvoicedtl_no_pk')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.au_entry_at', 'desc')
                ->get();
            $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->get();

            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.radiology_uhl", [
                'radiology_data' => $radiology_data,
                'patient_id' => $patient_id,
                'image_capture' => $image_capture
            ]);
        }

        if ($tab_type == 7) {
            $sergical_data = DB::table("opt_ot_confirmlist_wl_vw a")
                ->select('h.hospital_code', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.age', 'a.surg_doctor_name', 'a.ot_date', 'a.surg_doctor_name')
                ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.ot_req_no_pk', 'desc')
                ->get();
            // dd($sergical_data);

            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.surgical_history_uhl", [
                'sergical_data' => $sergical_data
            ]);
        }


        if ($tab_type == 8) {
            $hospitalized_data = DB::table("ipd_admitted_patlist_vw a")
                ->select('a.admission_date', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.dis_date', 'a.dis_reason')
                // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_pk_no', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.admission_no_pk', 'desc')
                ->get();
            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.hospitalized_history_uhl", [
                'hospitalized_data' => $hospitalized_data
            ]);
        }

        if ($tab_type == 9) {
            $immunization_data = DB::table("emr_patimmunization a")
                ->select('a.immunization_start_date', 'a.immunization_name', 'a.dose_number', 'a.immunization_no_pk')
                // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
                ->where('a.au_entry_hospital_no_fk', $ses_hospital_id)
                ->where('a.patient_no_fk', $patient_id)
                ->orderBy('a.au_entry_at', 'desc')
                ->get();

            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.immunization_history_uhl", [
                'immunization_data' => $immunization_data,
                'patient_id' => $patient_id
            ]);
        }

        // Physiotherapy details
        if ($tab_type == 20) {
            $physiotherapy_details = db::table("prest_prescriptionmst_physio_vw a")
                ->leftjoin('prest_prescriptiondtl_physio_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
                ->select('a.prescription_no_pk', 'a.prescription_date', 'a.prescription_code', 'a.doctor_name', 'b.presdtl_data')
                ->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE', 'ACUP'])
                ->where('a.patient_no_fk', $patient_id)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.status", 1)
                ->where("a.doctor_specialization", "=", "physiotherapist")
                //->where("a.prescription_date", date('Y-m-d'))
                //->whereRaw(DB::raw("a.prescription_date=to_date('$DstartDate','YY-MM-DD')"))
                //->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE','ACUP'])
                // ->groupby('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_photo', 'a.patient_code', 'a.gender_txt', 'a.mobile1')
                ->orderBy('a.prescription_no_pk', 'desc')
                ->get();
            return Template::loadView("admin.EMR.uhl.tabs.past_medical_records_uhl.physiotherapy_history_uhl", [
                'physiotherapy_details' => $physiotherapy_details
            ]);
        }
    }



    // vitalSearch
    public function vitalSearch(Request $request, $patient_id = "")
    {
        $patient_id = $request->patient_id;
        $vital_date = date("Y-m-d", strtotime($request->vital_date));
        $vitals_data = DB::select("select  h.hospital_code,h.hospital_name, a.chief_complaints,a.temp_val, a.temp_val_time,a.height_val,a.h_mu_name, a.weight_val, a.w_mu_name,a.bp_val_dia, a.bp_val_sys, a.pulse_val, a.ofc,a.vital_date from psn_t_patvitals_ipd_vw a left join wsec_hospital h
            on h.hospital_no_pk = a.au_entry_hospital_no_fk where PATIENT_NO_FK = $patient_id and trunc(vital_date) = '$vital_date'");
        return Template::loadview("admin.EMR.tabs.demographic_details.vitals_data", ["vitals_data" => $vitals_data, 'patient_id' => $patient_id]);
    }


    // lab report search
    public function labReportSearch(Request $request, $patient_id = "")
    {
        $patient_id = $request->patient_id;
        $query = DB::table('labt_invoicedtl_vw a')
            ->where('a.patient_no_fk', $patient_id);

        if (!empty($request->hdn_invoice_id)) {
            $query->where('a.invoice_no_fk', $request->hdn_invoice_id);
        }
        if (!empty($request->lab_test_name)) {
            $query->where('a.item_name', 'like', "%{$request->lab_test_name}%");
        }

        if (!empty($request->lab_test_date)) {
            $query->where(DB::raw("trunc(a.report_delivery_date)"), '=', date('Y/m/d', strtotime($request->lab_test_date)));
        }

        $lab_data = $query->get();
        // dd($lab_data);
        return Template::loadView("admin.EMR.tabs.past_medical_records.lab_report_data", ['lab_data' => $lab_data, 'patient_id' => $patient_id]);
    }

    public function currentMedicationSearch(Request $request, $patient_id = "")
    {
        $patient_id = $request->patient_id;
        $genetic_name = $request->item_number;
        $medical_equiment = DB::table('psn_t_prescription_med_vw a')->select('a.*')
            ->where('patient_no_fk', $patient_id)
            ->where('a.item_no_fk', $genetic_name)
            ->get();


        return Template::loadview("admin.EMR.tabs.current_medical_usage.current_medical_data", [
            'medical_equiment' => $medical_equiment
        ]);
    }

    public function currentPatientStore(Request $request)
    {
        $id = $request->patient_id;
        $auth_id = Auth::id();
        //   dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            $data = [
                'medequ_name' => $request->equipment_name,
                'medequ_start_date' => ($request->date_of_engage) ? date("Y-m-d", strtotime($request->date_of_engage)) : '',
                'start_time_of_engage' => ($request->start_time_of_engage) ? date('Y-m-d h:i:s', strtotime($request->start_time_of_engage)) : '',
                'medequ_end_date' => ($request->date_of_discharge) ? date("Y-m-d", strtotime($request->date_of_discharge)) : '',
                'end_time_of_engage' => ($request->end_time_of_engage) ? date('Y-m-d h:i:s', strtotime($request->end_time_of_engage)) : '',
                'patient_no_fk' => $id,
                'au_update_session' => 1,
                'au_sync_hospital_no_fk' => $ses_hospital_id,
                'au_sync_at' => date('Y-m-d'),
                'au_entry_session' => 1

            ];
            // dd($data);
            if ($id != null) {
                $data['au_entry_by'] = $auth_id;
                $this->model_equiment->create($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    // family_disease
    public function familyDiseaseStore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        if (!empty($request->lp_report_from)) {

            $date_from = date("Y/m/d", strtotime($request->lp_report_from));
        } else {
            $date_from = "";
        }

        if (!empty($request->lp_report_to)) {

            $date_to = date("Y/m/d", strtotime($request->lp_report_to));
        } else {
            $date_to = "";
        }

        DB::beginTransaction();
        try {
            $data = [
                'relation_name' => $request->relative,
                'disease_name' => $request->family_disease,
                'severity' => $request->family_severity,
                'suffered_duration' => $request->suffered_duration,
                'death_bydisease_ind' => $request->death_yes,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'patient_no_fk' => $request->patient_id,
                'au_update_session' => 1,
                'au_sync_hospital_no_fk' => 1,
                'au_sync_at' => date('Y/m/d'),
                'au_entry_session' => 1

            ];



            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_no_fk'] = $ses_hospital_id;
                $this->model2->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_no_fk'] = $ses_hospital_id;
                $this->model2->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    // emr radiology search

    public function emrRadiologySearch(Request $request, $patient_id = "")
    {

        $patient_id = $request->patient_id;
        $query = DB::table("radt_invoicedtl_app_wl_vw a")
            //            ->select('h.hospital_code','a.prescription_uid', 'a.item_name', 'a.prescription_dttm', 'a.radinvoicedtl_no_pk')
            //            ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $patient_id);

        if (!empty($request->invoice_id)) {
            $query->where('a.invoice_no_pk', $request->invoice_id);
        }
        if (!empty($request->lab_test_name)) {
            $query->where('a.item_name', 'like', "%{$request->lab_test_name}%");
        }

        if (!empty($request->lab_test_date)) {
            $query->where(DB::raw("trunc(a.invoice_date)"), '=', date('Y/m/d', strtotime($request->lab_test_date)));
        }

        $radiology_data = $query->get();

        return Template::loadView("admin.EMR.tabs.past_medical_records.radiology_data", ['radiology_data' => $radiology_data, 'patient_id' => $patient_id]);
    }

    //imuzation History
    public function immuzationHistoryStore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        if (!empty($request->immunization_date)) {

            $immunization_date = date("Y/m/d", strtotime($request->immunization_date));
        } else {
            $immunization_date = "";
        }

        DB::beginTransaction();
        try {
            $data = [
                'immunization_name' => $request->immunization_name,
                'dose_number' => $request->dose_numer,
                'immunization_start_date' => $immunization_date,
                'patient_no_fk' => $request->patient_id,
                'au_update_session' => 1,
                'au_sync_hospital_no_fk' => 1,
                'au_sync_at' => date('Y/m/d'),
                'au_entry_session' => 1

            ];


            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->model3->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model3->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function immuzationDataDelete(Request $request, $id, $patient_id = "")
    {
        $patient_id = $request->patient_id;
        $data = DB::table('emr_patimmunization')->where('immunization_no_pk', $id)->delete();
        return Template::loadView("admin.EMR.tabs.past_medical_records.immunization_history", ['patient_id' => $patient_id]);
    }

    public function familyDeseaseDataDelete(Request $request, $id, $patient_id = "")
    {
        $patient_id = $request->patient_id;
        $data = DB::table('emr_familymedhistory')->where('familymedhistory_no_pk', $id)->delete();
        return Template::loadView("admin.EMR.tabs.family_disease.family_disease", ['patient_id' => $patient_id]);
    }

    public function emrReport(Request $request, $id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $id)
            ->get()->first();
        $alergies_data = DB::table('emr_allergies')->where('patient_no_fk', $id)->orderBy('au_entry_at', 'desc')->get();
        $medical_equiment = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $id)->get();

        $past_medical_records = DB::table('psn_t_prescription_vw a')->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $lab_data = DB::table('labt_invoicedtl_vw a')->select('a.item_name', 'a.report_delivary_date', 'a.invoice_code', 'a.lab_code', 'a.report_no_fk', 'a.prescription_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.labinvoicedtl_no_pk', 'desc')->get();
        $radiology_data = DB::table("radt_invoicedtl_app_wl_vw a")
            ->select('a.hospital_code', 'a.prescription_no_fk', 'a.invoice_code', 'a.item_name', 'a.invoice_date', 'a.radinvoicedtl_no_pk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.au_entry_at', 'desc')
            ->get();

        $image = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk", "rad_report_imgno_pk", "resultimg_path", "image_caption")->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy("rad_report_imgno_pk", "asc")->get();


        $vitals_data = DB::table('psn_t_patvitals_ipd_vw a')->select('h.hospital_code', 'a.chief_complaints', 'a.temp_val', 'a.temp_val_time', 'a.height_val', 'a.h_mu_name', 'a.weight_val', 'a.w_mu_name', 'a.bp_val_dia', 'a.bp_val_sys', 'a.pulse_val', 'a.ofc', 'a.vital_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $prescription_data = DB::table('psn_t_prescription_vw a')->select('h.hospital_code', 'a.prescription_no_pk', 'a.prescription_uid', 'a.patient_name', 'a.gender_txt', 'a.age', 'a.su_name', 'a.au_entry_at', 'a.hospital_uid', 'a.doctor_name', 'a.doctor_signature')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $current_equiment_data = DB::table('emr_medicalequipment a')->select('h.hospital_code', 'h.hospital_name', 'a.medequ_name', 'a.medequ_start_date', 'a.medequ_end_date')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $sergical_data = DB::table("opt_ot_confirmlist_wl_vw a")
            ->select('h.hospital_code', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.age', 'a.surg_doctor_name', 'a.ot_date', 'a.surg_doctor_name')
            ->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.ot_req_no_pk', 'desc')
            ->get();
        $hospitalized_data = DB::table("ipd_admitted_patlist_vw a")
            ->select('a.admission_date', 'a.admission_uid', 'a.ward_name', 'a.bed_name', 'a.dis_date', 'a.dis_reason')
            // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.admission_no_pk', 'desc')
            ->get();
        $immunization_data = DB::table("emr_patimmunization a")
            ->select('a.immunization_start_date', 'a.immunization_name', 'a.dose_number', 'a.immunization_no_pk')
            // ->leftjoin('wsec_hospital h', 'h.hospital_no_pk','=', 'a.au_entry_hospital_no_fk')
            ->where('a.patient_no_fk', $id)
            ->orderBy('a.au_entry_at', 'desc')
            ->get();
        $chronic_data = DB::table('emr_chronic_disease')->where('patient_no_fk', $id)->orderBy('au_entry_at', 'desc')->get();

        $family_disease_data = DB::table("emr_familymedhistory a")->select('h.hospital_code', 'a.relation_name', 'a.disease_name', 'a.disease_name', 'a.date_from', 'a.date_to', 'a.severity', 'a.suffered_duration', 'a.death_bydisease_ind', 'a.familymedhistory_no_pk')->leftjoin('wsec_hospital h', 'h.hospital_no_pk', '=', 'a.au_entry_hospital_no_fk')->where('a.patient_no_fk', $id)->orderBy('a.au_entry_at', 'desc')->get();
        $patient_barcode = $patient_info->patient_no_pk;

        $title = $patient_barcode;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();



        $pdf = PDF::loadView('admin.EMR.emr_report', [

            'patient_info' => $patient_info,
            'po_hospital_details' => $po_hospital_details,
            'alergies_data' => $alergies_data,
            'past_medical_records' => $past_medical_records,
            'lab_data' => $lab_data,
            'radiology_data' => $radiology_data,
            'vitals_data' => $vitals_data,
            'medical_equiment' => $medical_equiment,
            'prescription_data' => $prescription_data,
            'current_equiment_data' => $current_equiment_data,
            'sergical_data' => $sergical_data,
            'hospitalized_data' => $hospitalized_data,
            'immunization_data' => $immunization_data,
            'family_disease_data' => $family_disease_data,
            'patient_barcode' => $patient_barcode,
            'chronic_data' => $chronic_data,
            'pat_barcode' => $barcode_no,
            'image' => $image,
        ]);
        return $pdf->download('Emr-report.pdf');
    }
}
