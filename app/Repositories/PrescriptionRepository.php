<?php

namespace App\Repositories;


use PDO;
use Auth;
use Session;
use Exception;
use DateTime;
use Carbon\Carbon;
use App\Events\TVUpdate;
use App\Models\IIEFModel;
use App\Models\IPSSModel;
use App\Core\TV\TVService;
use App\Traits\LookupData;
use App\Traits\PatientData;
use App\Models\Prescription;
use GuzzleHttp\Psr7\Request;
use App\Models\PrescriptionEye;
use App\Models\Therapy_Details;
use Illuminate\Support\Facades\DB;
use App\Models\PhysioAssementModel;
use App\Models\PrescriptionTemplate;
use App\Repositories\BaseRepository;
use App\Models\PrescriptionTemplateDtl;
use App\Models\PrescriptionTemplateMed;
use App\Models\ErectileDysFunctionModel;

class PrescriptionRepository extends BaseRepository
{
    use LookupData, PatientData;

    protected $baseRepository, $physioassementmodel, $erectileModel, $ipssmodel, $iiefmodel, $therapy_details;
    protected $tv_information;
    public function __construct(Prescription $prescription, PhysioAssementModel $physioassementmodel, IPSSModel $IPSSModel, IIEFModel $IIEFModel, ErectileDysFunctionModel $erectileModel, Therapy_Details $therapy_details, TVService $tv_information)
    {
        $this->prescription = $prescription;
        $this->physioassementmodel = new BaseRepository($physioassementmodel);
        $this->erectileModel = new BaseRepository($erectileModel);
        // $this->erectileModel = new BaseRepository($erectileModel);
        $this->baseRepository = new BaseRepository($prescription);
        $this->ipssmodel = new BaseRepository($IPSSModel);
        $this->iiefmodel = new BaseRepository($IIEFModel);
        $this->therapy_details = new BaseRepository($therapy_details);
        $this->tv_information = $tv_information;
    }

    public function all()
    {
        return $this->prescription->all();
    }

    public function opdPresCreateOrUpdate($request, $id = null)
    {
        date_default_timezone_set('Asia/Dhaka');
        $auth_id = Auth::id();
        $user_info = Auth::user();
        // $doctor_id='';
        // $in_service_unit_no_fk='';

        if ($request->hdn_external_ind == 1) {
            $doctor_id = $request->hdn_doctor_id;
            $in_service_unit_no_fk = $request->su_no;
        } else {
            $doctor_id = Session::get("user.ses_person_no_fk");
            $in_service_unit_no_fk = $request->hdn_su_no;
        }


        try {

            DB::beginTransaction();
            $prescription_id = $request->hdn_prescription_id;
            $in_appointment_no_fk = ($request->hdn_appointment_id != "") ? $request->hdn_appointment_id : '';
            // $this->quickAppointment($request->hdn_patient_id, $request->hdn_doctor_id, $request->hdn_room_no);
            $in_doctor_person_no_fk = $request->hdn_doctor_id;
            $in_hospital_code = 'HC';
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;

            $in_admission_no_fk = isset($request->hdn_admission_id) ? $request->hdn_admission_id : 0;
            // $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = $request->hdn_room_no;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp_sys = $request->txt_bp_sys;
            $txt_bp_dia = $request->txt_bp_dia;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $height_unit = isset($request->height_unit) ? $request->height_unit : "";
            $weight_unit = isset($request->weight_unit) ? $request->weight_unit : "";
            $txt_ofc = $request->txt_ofc;
            $txt_bmi = $request->txt_bmi;

            $sfh = $request->sfh;
            $fm = $request->fm;
            $fhs = $request->fhs;
            $pr = $request->pr;
            $hq = $request->hq;

            $swelling = $request->swelling;
            $scar_work = $request->scar_work;
            $tenderness = $request->tenderness;
            $pae_note = $request->pae_note;

            $alc = $request->alc;
            $menstrual_cycle = $request->menstrual_cycle;
            $mp = $request->mp;
            $mf = $request->mf;
            $dysmenorrhoea = $request->dysmenorrhoea;
            // $lmp = $request->lmp;
            $contraceptive_history = $request->contraceptive_history;
            $drug_history = $request->drug_history;
            $surgical_history = $request->surgical_history;
            $medical_history = $request->medical_history;
            $perineum_and_vulva = $request->perineum_and_vulva;
            $cx = $request->cx;
            $vaginal_wall = $request->vaginal_wall;
            $discharge = $request->discharge;
            $uterus = $request->uterus;
            $adnexa = $request->adnexa;
            $bme_note = $request->bme_note;
            $d_r_e = $request->d_r_e;
            $breast_examination = $request->breast_examination;


            $disposal_item = $request->disposal_item_ewmch;

            // New Added 08/11/2023
            $color = $request->color;
            $lung = $request->lung;
            $heart = $request->heart;
            $abdomen = $request->abdomen;
            $red_eye_reflex = $request->red_eye_reflex;
            $g_a = $request->g_a;
            $mb_g = $request->mb_g;
            $gdm = $request->gdm;
            $dih = $request->dih;
            $hypothyroidism = $request->hypothyroidism;
            $brochial_astma = $request->brochial_astma;
            $birth_order = $request->birth_order;
            $birth_weight = $request->birth_weight;
            $rr_val = empty($request->rr_val) ? "" : $request->rr_val;
            $spo2_val = empty($request->spo2_val) ? "" : $request->spo2_val;

            // end

            $txt_heart_rate = $request->txt_heart_rate;
            $txt_lung_condition = $request->txt_lung_condition;
            $txt_bowel_condition = $request->txt_bowel_condition;
            $txt_bladder_condition = $request->txt_bladder_condition;

            $next_followup = strval($request->next_followup);
            $pres_date = isset($request->pres_date) ? date('Y-m-d h:i', strtotime($request->pres_date)) : date('Y-m-d H:i');
            $empty = '';

            $next_followup_dt = ($request->next_followup != "") ? date("Y-m-d", strtotime($next_followup)) : "";

            $followup_after = trim($request->followup_after);
            $followup_after_mu = $request->followup_after_mu;
            $referred_doctor = $request->ref_doc_card_hidn;
            // $referred_doctor = '';old
            /* $referred_doctor        = trim($request->txt_referred_doctor); */
            $expected_session = $request->expected_session != "" ? $request->expected_session . " " . $request->expected_session_mu : "";

            // $rx_note = trim($request->txt_rx_note) . "^" . $expected_session;
            // $rx_note = $request->txt_rx_note != '' ? (trim($request->txt_rx_note) . "^" . $expected_session) : '';
            $rx_note = $request->txt_rx_note != '' ? (trim($request->txt_rx_note) . $expected_session) : '';
            $template_name = trim($request->template_name);
            $treatment_plan = trim($request->txt_treatment_plan);

            $txt_r_dv_sph = $request->txt_r_dv_sph;
            $txt_r_dv_cyl = $request->txt_r_dv_cyl;
            $txt_r_dv_axis = $request->txt_r_dv_axis;
            $txt_r_dv_va = $request->txt_r_dv_va;
            $txt_r_nv_sph = $request->txt_r_nv_sph;
            $txt_r_nv_cyl = $request->txt_r_nv_cyl;
            $txt_r_nv_axis = $request->txt_r_nv_axis;
            $txt_r_nv_va = $request->txt_r_nv_va;

            $txt_l_dv_sph = $request->txt_l_dv_sph;
            $txt_l_dv_cyl = $request->txt_l_dv_cyl;
            $txt_l_dv_axis = $request->txt_l_dv_axis;
            $txt_l_dv_va = $request->txt_l_dv_va;
            $txt_l_nv_sph = $request->txt_l_nv_sph;
            $txt_l_nv_cyl = $request->txt_l_nv_cyl;
            $txt_l_nv_axis = $request->txt_l_nv_axis;
            $txt_l_nv_va = $request->txt_l_nv_va;

            $txt_r_add = $request->txt_r_add;
            $txt_l_add = $request->txt_l_add;
            $txt_ipd = $request->txt_ipd;
            $txt_spec_remarks = $request->txt_spec_remarks;
            $txt_glass = $request->txt_glass;
            $txt_usage_type = $request->txt_usage_type;

            $item_id = $request->item_id;
            $item_name = $request->item_name;

            $outcome_measurement = isset($request->in_outcome_measurement) ? $request->in_outcome_measurement : '';
            $family_history = isset($request->family_history) ? $request->family_history : '';
            $complaints_history = isset($request->complaints_history) ? $request->complaints_history : '';
            $past_history = isset($request->past_history) ? $request->past_history : '';

            $item_dtl_val = $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_code = $in_ocular_position = $unit_intensity_arr = $session_duration_arr = $no_of_session_arr = $session_mu_arr = $requency = $mode = $in_m_repetition = $in_m_duration = $in_e_location = [];

            if (!empty($item_name)) {
                for ($i = 0; $i < sizeof($item_name); $i++) {
                    if ($item_name[$i] != "") {
                        $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                        $in_report_serial_dtl[$i] = 0;
                        //$item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';

                        $item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';


                        $in_presdtl_data[$i] = $item_name[$i];
                        $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                        $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                        $unit_intensity_arr[$i] = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : 0;
                        $session_duration_arr[$i] = isset($request->session_duration[$i]) ? $request->session_duration[$i] : 0;
                        $no_of_session_arr[$i] = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : 0;
                        $session_mu_arr[$i] = isset($request->session_mu[$i]) ? $request->session_mu[$i] : 0;
                        $unit_intensity_mu_arr[$i] = 0;
                        $in_ocular_position[$i] = isset($request->ocular_position[$i]) ? $request->ocular_position[$i] : '';
                        $requency[$i] = isset($request->frequency[$i]) ? $request->frequency[$i] : '';
                        $mode[$i] = isset($request->mode[$i]) ? $request->mode[$i] : '';

                        // $in_m_repetition[$i] = isset($request->in_m_repetition[$i]) ? $request->in_m_repetition[$i] : '';
                        // $in_m_duration[$i] = isset($request->in_m_duration) ? $request->in_m_duration[$i] : '';
                        // $in_e_location[$i] = isset($request->in_e_location) ? $request->in_e_location[$i] : '';

                        $in_m_repetition[$i] = null;
                        $in_m_duration[$i] = null;
                        $in_e_location[$i] = null;
                    }
                }
            }

            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = isset($request->is_continue) ? array_flip($request->is_continue) : $request->is_continue;
            $is_chronic = isset($request->is_chronic) ? array_flip($request->is_chronic) : $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;

            $array_count_med = count($medicine_item);
            $array_count_mul = count($request->multidose);

            if ($array_count_med === $array_count_mul) {
                $multidose_dt = $request->multidose;
                // dd($multidose_dt);
            } elseif ($array_count_med < $array_count_mul) {
                // dd(array_slice($request->multidose,1));
                $multidose_dt = array_slice($request->multidose, 1);
            } elseif ($array_count_med > $array_count_mul) {
                $a = array("");
                $multidose_dt = array_push($a, $request->multidose);
            }


            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $chronic_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = $in_med_serial_dtl = $in_med_multidose_dtl = [];

            if (!empty($medicine_item)) {
                for ($j = 1; $j < sizeof($medicine_item); $j++) {
                    if ($medicine_item[$j] != "") {
                        $medicine_item_id_arr[$j] = $medicine_item_id[$j];
                        $medicine_item_arr[$j] = $medicine_item[$j];
                        $medicine_dose_arr[$j] = $medicine_dose[$j];
                        $medicine_duration_type_arr[$j] = $medicine_duration_type[$j] ? $medicine_duration_type[$j] : 0;
                        $medicine_duration_mu_arr[$j] = $medicine_duration_mu[$j];
                        $medicine_quantity_arr[$j] = $medicine_quantity[$j];
                        $instruction_arr[$j] = $instruction[$j];
                        $report_serial_med_arr[$j] = $report_serial_med[$j] ? $report_serial_med[$j] : 0;

                        $continue_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;
                        $chronic_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;

                        $duration_comment_arr[$j] = "";
                        $route_arr[$j] = $medicine_route[$j];
                        $strength_arr[$j] = "";
                        $brand_ud_arr[$j] = "";
                        $in_med_serial_dtl[$j] = $report_serial_med_arr[$j];
                        // multidose
                        $in_med_multidose_dtl[$j] = $multidose_dt[$j];
                    }
                }
            }
            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $lmp = ($request->lmp != "") ? date("Y-m-d", strtotime($request->lmp)) : "";
            $lmp_remarks = ($request->lmp_remarks != "") ? $request->lmp_remarks : "";
            $obs = $request->obs;

            $married_for = $request->married_for;
            $para = $request->para;
            $gravida = $request->gravida;
            $edd = ($request->edd != "") ? date("Y-m-d", strtotime($request->edd)) : "";
            $edd_remarks = ($request->edd_remarks != "") ? $request->edd_remarks : "";
            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;
            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';

            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();
            $prescription = $pdo->prepare("begin pkg_emr.prescription_opd(
                :in_prescription_no_pk,
                :in_patient_no_fk,
                :in_appoint_no_fk,
                :in_doctor_person_no_fk,
                :in_su_no_fk,
                :in_room_no_fk,
                :in_admission_no_fk,
                :in_admission_uid,
                :in_continue_psn_ind,
                :in_continue_psn_no_fk,
                :in_note,
                :in_disposal,
                :in_ref_doctor,
                :in_diagnosis,
                :in_chief_complaints,
                :in_psn_state,
                :in_dental_treatement,
                :in_advice,
                :in_ipd_ind,
                :in_opd_ind,
                :in_hospital_uid,
                :in_is_patient_in,
                :in_is_patient_out,
                :in_followup_num,
                :in_followup_mu,
                :in_next_followup_dt,
                :template_name,
                :in_height_val,
                :in_hight_mu_name,
                :in_weight_val,
                :in_weight_mu_name,
                :in_bmi_val,
                :in_temp_val,
                :in_temp_mu_name,
                :in_temp_time,
                :in_pulse_val ,
                :in_pulse_time,
                :in_bp_val_sys,
                :in_bp_val_dia,
                :in_bp_time,
                :in_heart_rate,
                :in_heart_rate_time,
                :in_ofc,
                :in_heart_condition,
                :in_lung_condition,
                :in_bowel_condition,
                :in_bladder_condition,
                :in_prescription_date,
                :in_prescription_text_1,
                :in_prescription_text_2,
                :in_prescription_text_3,
                :in_lmp,
                :in_obs,
                :in_edd,
                :in_sfh,
                :in_fm,
                :in_fhs,
                :in_pr,
                :in_hq,
                :in_gestational_age,
                :in_mblood_group,
                :in_gdm,
                :in_dih,
                :in_hypothyroidism,
                :in_brochial_asthma,
                :in_birthorder,
                :in_birth_weight,
                :in_colour,
                :in_abdomen,
                :in_red_eye_reflex,
                :in_RR,
                :in_SPO2,
                :in_swelling,
                :in_scar_work,
                :in_tenderness,
                :in_pae_note,
                :in_alc,
                :in_menstrual_cycle,
                :in_mp,
                :in_mf,
                :in_dysmenorrhoea,
                :in_contraceptive_history,
                :in_drug_history,
                :in_surgical_history,
                :in_medical_history,
                :in_perineum_and_vulva,
                :in_cx,
                :in_vaginal_wall,
                :in_discharge,
                :in_uterus,
                :in_adnexa,
                :in_bme_note,
                :in_d_r_e,
                :in_breast_examination,
                :in_lmp_remarks,
                :in_edd_remarks,
                :in_outcome_measurement,
                :in_family_history,
                :in_complaints_history,
                :in_past_history,
                :in_a_lookupdata_item_no_fk,
                :in_a_lookup_uid,
                :in_a_lookupdata_uid,
                :in_a_entry_serial_dtl,
                :in_a_prescrition_data,
                :in_a_left_right_ind,
                :in_a_prescrition_data_dtl,
                :in_a_prescrition_data_dtlval,
                :in_a_prescrition_phy_frequency,
                :in_a_prescrition_phy_mode,
                :in_a_item_no_fk,
                :in_a_entry_serial,
                :in_a_generic_name,
                :in_a_brand_name,
                :in_a_dosage,
                :in_a_duration,
                :in_a_item_qty,
                :in_a_instruction_take,
                :in_a_medicine_comment,
                :in_a_route,
                :in_a_strength,
                :in_a_continue_ind,
                :in_a_duration_comment,
                :in_a_duration_mu,
                :in_a_chronic_ind,
                :in_session_duration,
                :in_session_mu,
                :in_no_of_session,
                :in_unit_intensity,
                :in_unit_intensity_mu,
                :in_multidose,
                :in_m_repetition,
                :in_e_location,
                :in_m_duration,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_prescription_no_pk,
                :out_prescription_uid,
                :out_error); end;");

            $prescription->bindparam(':in_prescription_no_pk', $prescription_id);
            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_appoint_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_doctor_person_no_fk', $doctor_id);
            $prescription->bindparam(':in_su_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_room_no_fk', $in_room_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_uid', $in_admission_code);
            $prescription->bindparam(':in_continue_psn_ind', $zero);
            $prescription->bindparam(':in_continue_psn_no_fk', $zero);
            $prescription->bindparam(':in_note', $rx_note);
            $prescription->bindparam(':in_disposal', $disposal_item);
            $prescription->bindparam(':in_ref_doctor', $referred_doctor);
            //$prescription->bindparam(':in_ref_su_no_fk', $in_ref_su_fk_no);
            $prescription->bindparam(':in_diagnosis', $null);
            $prescription->bindparam(':in_chief_complaints', $null);
            $prescription->bindparam(':in_psn_state', $zero);
            $prescription->bindparam(':in_dental_treatement', $treatment_plan);
            $prescription->bindparam(':in_advice', $null);
            $prescription->bindparam(':in_ipd_ind', $in_ipd_ind);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_hospital_uid', $in_hospital_code);
            $prescription->bindparam(':in_is_patient_in', $zero);
            $prescription->bindparam(':in_is_patient_out', $zero);
            $prescription->bindparam(':in_followup_num', $followup_after);
            $prescription->bindparam(':in_followup_mu', $followup_after_mu);
            $prescription->bindparam(':in_next_followup_dt', $next_followup_dt);
            $prescription->bindparam(':template_name', $template_name);

            //--------vitals----------------
            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $height_unit);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $weight_unit);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp_sys);
            $prescription->bindparam(':in_bp_val_dia', $txt_bp_dia);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $null);
            $prescription->bindparam(':in_ofc', $txt_ofc); //44

            $prescription->bindparam(':in_heart_condition', $txt_heart_rate);
            $prescription->bindparam(':in_lung_condition', $lung);
            $prescription->bindparam(':in_bowel_condition', $txt_bowel_condition);
            $prescription->bindparam(':in_bladder_condition', $txt_bladder_condition);
            $prescription->bindparam(':in_prescription_date', $pres_date); //44
            $prescription->bindparam(':in_prescription_text_1', $married_for); //44
            $prescription->bindparam(':in_prescription_text_2', $para); //44
            $prescription->bindparam(':in_prescription_text_3', $gravida); //44
            $prescription->bindparam(':in_lmp', $lmp);
            $prescription->bindparam(':in_obs', $obs);
            $prescription->bindparam(':in_edd', $edd);
            $prescription->bindparam(':in_sfh', $sfh);
            $prescription->bindparam(':in_fm', $fm);
            $prescription->bindparam(':in_fhs', $fhs);
            $prescription->bindparam(':in_pr', $pr);
            $prescription->bindparam(':in_hq', $hq);
            $prescription->bindparam(':in_gestational_age', $g_a);
            $prescription->bindparam(':in_mblood_group', $mb_g);
            $prescription->bindparam(':in_gdm', $gdm);
            $prescription->bindparam(':in_dih', $dih);
            $prescription->bindparam(':in_hypothyroidism', $hypothyroidism);
            $prescription->bindparam(':in_brochial_asthma', $brochial_astma);
            $prescription->bindparam(':in_birthorder', $birth_order);
            $prescription->bindparam(':in_birth_weight', $birth_weight);
            $prescription->bindparam(':in_colour', $color);
            $prescription->bindparam(':in_abdomen', $abdomen);
            $prescription->bindparam(':in_red_eye_reflex', $red_eye_reflex);
            $prescription->bindparam(':in_RR', $rr_val);
            $prescription->bindparam(':in_SPO2', $spo2_val);
            $prescription->bindparam(':in_swelling', $swelling);
            $prescription->bindparam(':in_scar_work', $scar_work);
            $prescription->bindparam(':in_tenderness', $tenderness);
            $prescription->bindparam(':in_pae_note', $pae_note);
            $prescription->bindparam(':in_alc', $alc);
            $prescription->bindparam(':in_menstrual_cycle', $menstrual_cycle);
            $prescription->bindparam(':in_mp', $mp);
            $prescription->bindparam(':in_mf', $mf);
            $prescription->bindparam(':in_dysmenorrhoea', $dysmenorrhoea);
            $prescription->bindparam(':in_contraceptive_history', $contraceptive_history);
            $prescription->bindparam(':in_drug_history', $drug_history);
            $prescription->bindparam(':in_surgical_history', $surgical_history);
            $prescription->bindparam(':in_medical_history', $medical_history);
            $prescription->bindparam(':in_perineum_and_vulva', $perineum_and_vulva);
            $prescription->bindparam(':in_cx', $cx);
            $prescription->bindparam(':in_vaginal_wall', $vaginal_wall);
            $prescription->bindparam(':in_discharge', $discharge);
            $prescription->bindparam(':in_uterus', $uterus);
            $prescription->bindparam(':in_adnexa', $adnexa);
            $prescription->bindparam(':in_bme_note', $bme_note);
            $prescription->bindparam(':in_d_r_e', $d_r_e);
            $prescription->bindparam(':in_breast_examination', $breast_examination);
            $prescription->bindparam(':in_lmp_remarks', $lmp_remarks);
            $prescription->bindparam(':in_edd_remarks', $edd_remarks);

            $prescription->bindparam(':in_outcome_measurement', $outcome_measurement);
            $prescription->bindparam(':in_family_history', $family_history);
            $prescription->bindparam(':in_complaints_history', $complaints_history);
            $prescription->bindparam(':in_past_history', $past_history);

            //------- prescription details----
            $prescription->bindArray(':in_a_lookupdata_item_no_fk', $in_item_lookupdata_no_fk, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_lookup_uid', $in_itemtype_lookup_code, (!empty($in_itemtype_lookup_code) ? count($in_itemtype_lookup_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_lookupdata_uid', $in_itemtype_lookupdata_code, (!empty($in_itemtype_lookupdata_code) ? count($in_itemtype_lookupdata_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_entry_serial_dtl', $in_report_serial_dtl, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_prescrition_data', $in_presdtl_data, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_left_right_ind', $in_ocular_position, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtl', $item_dtl_val, (!empty($item_dtl_val) ? count($item_dtl_val) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtlval', $in_report_serial_dtl, (!empty($in_report_serial_dtl) ? count($in_report_serial_dtl) : 1), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_a_prescrition_phy_frequency', $requency, (!empty($requency) ? count($requency) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_phy_mode', $mode, (!empty($mode) ? count($mode) : 1), $numelems, SQLT_CHR);

            //---- prescription medicine ----
            $prescription->bindArray(':in_a_item_no_fk', $medicine_item_id_arr, (!empty($medicine_item_id_arr) ? count($medicine_item_id_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_entry_serial', $in_med_serial_dtl, (!empty($in_med_serial_dtl) ? count($in_med_serial_dtl) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_generic_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_brand_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_dosage', $medicine_dose_arr, (!empty($medicine_dose_arr) ? count($medicine_dose_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration', $medicine_duration_type_arr, (!empty($medicine_duration_type_arr) ? count($medicine_duration_type_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_item_qty', $medicine_quantity_arr, (!empty($medicine_quantity_arr) ? count($medicine_quantity_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_instruction_take', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_medicine_comment', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_route', $route_arr, (!empty($route_arr) ? count($route_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_strength', $strength_arr, (!empty($strength_arr) ? count($strength_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_continue_ind', $continue_ind_arr, (!empty($continue_ind_arr) ? count($continue_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_duration_comment', $duration_comment_arr, (!empty($duration_comment_arr) ? count($duration_comment_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration_mu', $medicine_duration_mu_arr, (!empty($medicine_duration_mu_arr) ? count($medicine_duration_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_chronic_ind', $chronic_ind_arr, (!empty($chronic_ind_arr) ? count($chronic_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_duration', $session_duration_arr, (!empty($session_duration_arr) ? count($session_duration_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_session_mu', $session_mu_arr, (!empty($session_mu_arr) ? count($session_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_no_of_session', $no_of_session_arr, (!empty($no_of_session_arr) ? count($no_of_session_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_unit_intensity', $unit_intensity_arr, (!empty($unit_intensity_arr) ? count($unit_intensity_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_unit_intensity_mu', $unit_intensity_mu_arr, (!empty($unit_intensity_mu_arr) ? count($unit_intensity_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_multidose', $in_med_multidose_dtl, (!empty($in_med_multidose_dtl) ? count($in_med_multidose_dtl) : 1), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_m_repetition', $in_m_repetition, (!empty($in_m_repetition) ? count($in_m_repetition) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_e_location', $in_e_location, (!empty($in_e_location) ? count($in_e_location) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_m_duration', $in_m_duration, (!empty($in_m_duration) ? count($in_m_duration) : 1), $numelems, SQLT_CHR);

            //--- audit and out parameters-------
            // $prescription->bindParam(':in_external_hospital_ind', $hdn_external_ind);
            //$prescription->bindParam(':in_external_hospital_no_fk', $cmb_external_hospital);
            $prescription->bindParam(':in_au_entry_by', $auth_id);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $prescription->bindParam(':out_prescription_no_pk', $out_prescription_no_pk, PDO::PARAM_INT);
            $prescription->bindParam(':out_prescription_uid', $null, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $prescription->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
                return response()->json($message, 422);
            } else {
                DB::table('patn_registration')->where('patient_no_pk', $request->hdn_patient_id)
                    ->update(['blood_group' => $request->pat_blood_group]);

                if ($request->hdn_eye_ind == 1) {
                    // delete previous spectacles and insert again
                    PrescriptionEye::where('prescription_no_fk', $out_prescription_no_pk)->delete();

                    $prescriptionEye = new PrescriptionEye();
                    $prescriptionEye->prescription_no_fk = $out_prescription_no_pk;
                    $prescriptionEye->axis_left_dv = $txt_r_dv_axis;
                    $prescriptionEye->axis_right_dv = $txt_l_dv_axis;
                    $prescriptionEye->cyl_left_dv = $txt_l_dv_cyl;
                    $prescriptionEye->cyl_right_dv = $txt_r_dv_cyl;
                    $prescriptionEye->sph_left_dv = $txt_l_dv_sph;
                    $prescriptionEye->sph_right_dv = $txt_r_dv_sph;
                    $prescriptionEye->va_left_dv = $txt_l_dv_va;
                    $prescriptionEye->va_right_dv = $txt_r_dv_va;
                    $prescriptionEye->axis_left_nv = $txt_l_nv_axis;
                    $prescriptionEye->axis_right_nv = $txt_r_nv_axis;
                    $prescriptionEye->cyl_left_nv = $txt_l_nv_cyl;
                    $prescriptionEye->cyl_right_nv = $txt_r_nv_cyl;
                    $prescriptionEye->sph_left_nv = $txt_l_nv_sph;
                    $prescriptionEye->sph_right_nv = $txt_r_nv_sph;
                    $prescriptionEye->va_left_nv = $txt_l_nv_va;
                    $prescriptionEye->va_right_nv = $txt_r_nv_va;
                    $prescriptionEye->add_left = $txt_l_add;
                    $prescriptionEye->add_right = $txt_r_add;
                    $prescriptionEye->i_p_d = $txt_ipd;
                    $prescriptionEye->remarks_txt = $txt_spec_remarks;
                    $prescriptionEye->glass_type = $txt_glass;
                    $prescriptionEye->usage_type = $txt_usage_type;
                    $prescriptionEye->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $prescriptionEye->save();
                }
                DB::commit();
                $message = ['msg' => 'New Prescription created successfully.Prescription ID = ' . $out_prescription_no_pk, 'title' => 'Success', 'insert_id' => $out_prescription_no_pk];
                return response()->json($message, 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message, 422);
        }
    }



    public function opdPresCreateOrUpdateUHL($request, $id = null)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Dhaka');
        $auth_id = Auth::id();
        $user_info = Auth::user();
        // $doctor_id='';
        // $in_service_unit_no_fk='';
        // if ($request->hdn_external_ind == 1) {
        //     $doctor_id = $request->hdn_doctor_id;
        //     $in_service_unit_no_fk = $request->su_no;
        // } else {
        //     $doctor_id = Session::get("user.ses_person_no_fk");
        //     $in_service_unit_no_fk = $request->hdn_su_no;
        // }
        $doctor_id = Session::get("user.ses_person_no_fk");
        $in_service_unit_no_fk = $request->hdn_su_no;
        //    dd($request->spo2_value, $request->respiration);
        try {
            DB::beginTransaction();
            $prescription_id = $request->hdn_prescription_id;
            $in_appointment_no_fk = ($request->hdn_appointment_id != "") ? $request->hdn_appointment_id : '';
            // $this->quickAppointment($request->hdn_patient_id, $request->hdn_doctor_id, $request->hdn_room_no);
            $in_doctor_person_no_fk = $request->hdn_doctor_id;
            $in_hospital_code = Session::get("user.ses_hospital_code");
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;

            $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = $request->hdn_room_no;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp_sys = $request->txt_bp_sys;
            $txt_bp_dia = $request->txt_bp_dia;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $height_unit = isset($request->height_unit) ? $request->height_unit : "";
            $weight_unit = isset($request->weight_unit) ? $request->weight_unit : "";
            $txt_ofc = $request->txt_ofc;
            $txt_bmi = $request->txt_bmi;

            $sfh = $request->sfh;
            $fm = $request->fm;
            $fhs = $request->fhs;
            $pr = $request->pr;
            $hq = $request->hq;

            $swelling = $request->swelling;
            $scar_work = $request->scar_work;
            $tenderness = $request->tenderness;
            $pae_note = $request->pae_note;

            $alc = $request->alc;
            $menstrual_cycle = $request->menstrual_cycle;
            $mp = $request->mp;
            $lmp_remarks = ($request->lmp_remarks != "") ? $request->lmp_remarks : "";
            $edd_remarks = ($request->edd_remarks != "") ? $request->edd_remarks : "";
            $mf = $request->mf;
            $dysmenorrhoea = $request->dysmenorrhoea;
            // $lmp = $request->lmp;
            $contraceptive_history = $request->contraceptive_history;
            $drug_history = $request->drug_history;
            $surgical_history = $request->surgical_history;
            $medical_history = $request->medical_history;
            $perineum_and_vulva = $request->perineum_and_vulva;
            $cx = $request->cx;
            $vaginal_wall = $request->vaginal_wall;
            $discharge = $request->discharge;
            $uterus = $request->uterus;
            $adnexa = $request->adnexa;
            $bme_note = $request->bme_note;
            $d_r_e = $request->d_r_e;
            $breast_examination = $request->breast_examination;

            $disposal_item = $request->admission_referred;
            // $disposal_item          = $request->disposal_item_ewmch;

            $color = $request->color;
            $lung = $request->lung;
            $heart = $request->heart;
            $abdomen = $request->abdomen;
            $red_eye_reflex = $request->red_eye_reflex;
            $g_a = $request->g_a;
            $mb_g = $request->mb_g;
            $gdm = $request->gdm;
            $dih = $request->dih;
            $hypothyroidism = $request->hypothyroidism;
            $brochial_astma = $request->brochial_astma;
            $birth_order = $request->birth_order;
            $birth_weight = $request->birth_weight;
            $rr_val = empty($request->rr_val) ? "" : $request->rr_val;
            $spo2_val = empty($request->spo2_value) ? "" : $request->spo2_value;
            // end
            $txt_heart_rate = $request->txt_heart_rate;
            $txt_lung_condition = $request->txt_lung_condition;
            $txt_bowel_condition = $request->txt_bowel_condition;
            $txt_bladder_condition = $request->txt_bladder_condition;

            $next_followup = strval($request->next_followup);
            $pres_date = isset($request->pres_date) ? date('Y-m-d h:i', strtotime($request->pres_date)) : date('Y-m-d H:i');
            $empty = '';

            $next_followup_dt = ($request->next_followup != "") ? date("Y-m-d", strtotime($next_followup)) : "";

            $followup_after = trim($request->followup_after);
            $followup_after_mu = $request->followup_after_mu;
            $referred_doctor = $request->ref_doc_card_hidn;
            // $referred_doctor     = '';old
            /* $referred_doctor     = trim($request->txt_referred_doctor); */
            $expected_session = $request->expected_session != "" ? $request->expected_session . " " . $request->expected_session_mu : "";

            // $rx_note             = trim($request->txt_rx_note) . "^" . $expected_session;
            // $rx_note             = $request->txt_rx_note != '' ? (trim($request->txt_rx_note) . "^" . $expected_session) : '';
            $rx_note = $request->txt_rx_note != '' ? (trim($request->txt_rx_note) . $expected_session) : '';
            $template_name = trim($request->template_name);
            $treatment_plan = trim($request->txt_treatment_plan);
            $global_hidden_note = trim($request->global_hidden_note);
            $investigation_findings_txt = trim($request->investigation_findings_txt);

            $txt_r_dv_sph = $request->txt_r_dv_sph;
            $txt_r_dv_cyl = $request->txt_r_dv_cyl;
            $txt_r_dv_axis = $request->txt_r_dv_axis;
            $txt_r_dv_va = $request->txt_r_dv_va;
            $txt_r_nv_sph = $request->txt_r_nv_sph;
            $txt_r_nv_cyl = $request->txt_r_nv_cyl;
            $txt_r_nv_axis = $request->txt_r_nv_axis;
            $txt_r_nv_va = $request->txt_r_nv_va;

            $txt_l_dv_sph = $request->txt_l_dv_sph;
            $txt_l_dv_cyl = $request->txt_l_dv_cyl;
            $txt_l_dv_axis = $request->txt_l_dv_axis;
            $txt_l_dv_va = $request->txt_l_dv_va;
            $txt_l_nv_sph = $request->txt_l_nv_sph;
            $txt_l_nv_cyl = $request->txt_l_nv_cyl;
            $txt_l_nv_axis = $request->txt_l_nv_axis;
            $txt_l_nv_va = $request->txt_l_nv_va;

            $txt_r_add = $request->txt_r_add;
            $txt_l_add = $request->txt_l_add;
            $txt_ipd = $request->txt_ipd;
            $txt_spec_remarks = $request->txt_spec_remarks;
            $txt_glass = $request->txt_glass;
            $txt_usage_type = $request->txt_usage_type;

            $reffered_reason = isset($request->reffered_reason) ? $request->reffered_reason : '';
            $referred_clinic = isset($request->referred_clinic) ? $request->referred_clinic : '';
            $note = isset($request->note) ? $request->note : '';
            // $ot_date_time = isset($request->ot_date_time) ? $request->ot_date_time : null;
            // $formated_ot_date = $ot_date_time ? Carbon::parse($ot_date_time)->format('Y-m-d') : "";
            $ot_date_time = $request->ot_date_time ?? null;

            $formated_ot_date = '';

            if ($ot_date_time) {
                $formated_ot_date = Carbon::createFromFormat('d/m/Y', $ot_date_time)
                    ->format('Y-m-d');
            }
            $advice = isset($request->advice) ? $request->advice : '';

            $item_id = $request->item_id;
            $item_name = $request->item_name;
            $outcome_measurement = isset($request->in_outcome_measurement) ? $request->in_outcome_measurement : '';
            $family_history = isset($request->family_history) ? $request->family_history : '';
            $complaints_history = isset($request->complaints_history) ? $request->complaints_history : '';
            $past_history = isset($request->past_history) ? $request->past_history : '';
            $risk_factor = isset($request->risk_factor) ? $request->risk_factor : '';
            $item_dtl_val = $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_code = $in_ocular_position = $unit_intensity_arr = $session_duration_arr = $no_of_session_arr = $session_mu_arr = $requency = $mode = $in_m_repetition = $in_m_duration = $in_e_location = [];

            $procedure_items = [];
            $procedure_item_ids = [];

            if (!empty($item_name)) {
                for ($i = 0; $i < sizeof($item_name); $i++) {
                    if ($item_name[$i] != "") {
                        $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                        $in_report_serial_dtl[$i] = 0;
                        //$item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';
                        $item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';
                        $in_presdtl_data[$i] = $item_name[$i];
                        $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                        $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                        $unit_intensity_arr[$i] = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : 0;
                        $session_duration_arr[$i] = isset($request->session_duration[$i]) ? $request->session_duration[$i] : 0;
                        $no_of_session_arr[$i] = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : 0;
                        $session_mu_arr[$i] = isset($request->session_mu[$i]) ? $request->session_mu[$i] : 0;
                        $unit_intensity_mu_arr[$i] = 0;
                        $in_ocular_position[$i] = isset($request->ocular_position[$i]) ? $request->ocular_position[$i] : '';
                        $requency[$i] = isset($request->frequency[$i]) ? $request->frequency[$i] : '';
                        $mode[$i] = isset($request->mode[$i]) ? $request->mode[$i] : '';

                        $in_m_repetition[$i] = isset($request->in_m_repetition[$i]) ? $request->in_m_repetition[$i] : '';
                        $in_m_duration[$i] = isset($request->in_m_duration) ? $request->in_m_duration[$i] : '';
                        $in_e_location[$i] = isset($request->in_e_location) ? $request->in_e_location[$i] : '';
                        if ($request->lookup_code[$i] == 'PROCEDURE' || $request->lookup_code[$i] == 'PROC') {
                            $procedure_items[] = $item_name[$i];
                            $procedure_item_ids[] = $item_id[$i];
                        }
                    }
                }
            }


            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            // $is_continue = isset($request->is_continue) ? array_flip($request->is_continue) : $request->is_continue;
            $is_continue = $request->is_continue ?? [];

            $is_chronic = isset($request->is_chronic) ? array_flip($request->is_chronic) : $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;
            $array_count_med = count($medicine_item);
            $array_count_mul = count($request->multidose);

            if ($array_count_med === $array_count_mul) {
                $multidose_dt = $request->multidose;
            } elseif ($array_count_med < $array_count_mul) {
                $multidose_dt = array_slice($request->multidose, 1);
            } elseif ($array_count_med > $array_count_mul) {
                $a = array("");
                $multidose_dt = array_push($a, $request->multidose);
            }

            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $chronic_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = $in_med_serial_dtl = $in_med_multidose_dtl = [];

            // if (!empty($medicine_item)) {
            //     for ($j = 1; $j < sizeof($medicine_item); $j++) {
            //         if ($medicine_item[$j] != "") {
            //             $medicine_item_id_arr[$j]       = is_numeric($medicine_item_id[$j])?$medicine_item_id[$j]:0;
            //             $medicine_item_arr[$j]          = $medicine_item[$j];
            //             $medicine_dose_arr[$j]          = $medicine_dose[$j];
            //             $medicine_duration_type_arr[$j] = $medicine_duration_type[$j] ? $medicine_duration_type[$j] : 0;
            //             $medicine_duration_mu_arr[$j]   = $medicine_duration_mu[$j];
            //             $medicine_quantity_arr[$j]      = $medicine_quantity[$j];
            //             $instruction_arr[$j]            = $instruction[$j];
            //             $report_serial_med_arr[$j]      = $report_serial_med[$j] ? $report_serial_med[$j] : 0;
            //             $continue_ind_arr[$j]           = isset($is_continue[$j]) ? 1 : 0;
            //             $chronic_ind_arr[$j]            = isset($is_continue[$j]) ? 1 : 0;
            //             $duration_comment_arr[$j]       = "";
            //             $route_arr[$j]                  = $medicine_route[$j];
            //             $strength_arr[$j]               = "";
            //             $brand_ud_arr[$j]               = "";
            //             $in_med_serial_dtl[$j]          = $report_serial_med_arr[$j];
            //             // multidose
            //             $in_med_multidose_dtl[$j]       = $multidose_dt[$j];
            //         }
            //     }
            // }
            if (!empty($medicine_item)) {
                for ($j = 1; $j < count($medicine_item); $j++) {
                    if (!empty($medicine_item[$j])) {
                        $medicine_item_id_arr[$j] = (isset($medicine_item_id[$j]) && is_numeric($medicine_item_id[$j])) ? $medicine_item_id[$j] : 0;
                        $medicine_item_arr[$j] = $medicine_item[$j];
                        $medicine_dose_arr[$j] = isset($medicine_dose[$j]) ? $medicine_dose[$j] : '';
                        $medicine_duration_type_arr[$j] = isset($medicine_duration_type[$j]) ? $medicine_duration_type[$j] : 0;
                        $medicine_duration_mu_arr[$j] = isset($medicine_duration_mu[$j]) ? $medicine_duration_mu[$j] : '';
                        $medicine_quantity_arr[$j] = 0; //isset($medicine_quantity[$j]) ? $medicine_quantity[$j] : '';
                        $instruction_arr[$j] = isset($instruction[$j]) ? $instruction[$j] : '';
                        $report_serial_med_arr[$j] = isset($report_serial_med[$j]) ? $report_serial_med[$j] : 0;
                        // $continue_ind_arr[$j] = (isset($is_continue[$j]) && $is_continue[$j] == 1) ? 1 : 0;
                        $continue_ind_arr[$j] = (isset($medicine_duration_type[$j]) && $medicine_duration_type[$j] === 'Continue') ? 1 : 0;
                        $chronic_ind_arr[$j] = (isset($is_chronic[$j]) && $is_chronic[$j] == 1) ? 1 : 0;

                        $duration_comment_arr[$j] = "";
                        $route_arr[$j] = isset($medicine_route[$j]) ? $medicine_route[$j] : '';
                        $strength_arr[$j] = "";
                        $brand_ud_arr[$j] = "";
                        $in_med_serial_dtl[$j] = $report_serial_med_arr[$j];
                        $in_med_multidose_dtl[$j] = isset($multidose_dt[$j]) ? $multidose_dt[$j] : '';
                    }
                }
            }

            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            $lmp = ($request->lmp != "") ? date("Y-m-d", strtotime($request->lmp)) : "";
            $obs = $request->obs;

            $married_for = $request->married_for;
            $para = $request->para;
            $gravida = $request->gravida;
            $edd = ($request->edd != "") ? date("Y-m-d", strtotime($request->edd)) : "";
            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;
            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';
            $ipd_referred_advice = $request->ipd_referred_advice;
            $ipd_referred_date = ($request->ipd_referred_date != "") ? date("Y-m-d", strtotime($request->ipd_referred_date)) : "";


            // Radio buttons
            $diabetes_type1 = $request->input('diabetes_type1'); // 'Yes' or 'No'
            $diabetes_type2 = $request->input('diabetes_type2'); // 'Yes' or 'No'

            // Checkboxes
            $hypertension = $request->input('hypertension'); // 'Yes' or 'No'
            $dyslipidemia = $request->input('dyslipidemia'); // 'Yes' or 'No'

            // Text inputs
            $obesity = $request->input('obesity');
            $sedentary_lifestyle = $request->input('sedentary_lifestyle');
            $smoking = $request->input('smoking');
            $dietary_factors = $request->input('dietary_factors');
            $stress = $request->input('stress');
            $anemia = $request->input('anemia');
            $inflammation = $request->input('inflammation');
            $genetic_factors = $request->input('genetic_factors');
            $heredity = $request->input('heredity');

            // referred Purpose
            $referredToAnesthesia = $request->input('referredToAnesthesia');
            $purpose = $request->input('purpose');
            $diagnosis = $request->input('diagnosis');
            $investigationResult = $request->input('investigationResult');
            $plannedProcedure = $request->input('plannedProcedure');
            $procedureDate = $request->input('procedureDate');
            $procedureTime = $request->input('procedureTime');
            $estimatedDuration = $request->input('estimatedDuration');
            $specificRequirements = $request->input('specificRequirements');



            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();

            // $prescription = $pdo->prepare("begin pkg_emr.prescription_opd(
            $prescription = $pdo->prepare("begin pkg_emr.prescription_opd_v1(
                :in_prescription_no_pk,
                :in_patient_no_fk,
                :in_appoint_no_fk,
                :in_doctor_person_no_fk,
                :in_su_no_fk,
                :in_room_no_fk,
                :in_admission_no_fk,
                :in_admission_uid,
                :in_continue_psn_ind,
                :in_continue_psn_no_fk,
                :in_note,
                :in_disposal,
                :in_ref_doctor,
                :in_diagnosis,
                :in_chief_complaints,
                :in_psn_state,
                :in_dental_treatement,
                :in_advice,
                :in_ipd_ind,
                :in_opd_ind,
                :in_hospital_uid,
                :in_is_patient_in,
                :in_is_patient_out,
                :in_followup_num,
                :in_followup_mu,
                :in_next_followup_dt,
                :template_name,
                :in_diabetes_mel_typ1,
                :in_diabetes_mel_typ2,
                :in_hypertension,
                :in_dyslipdemia,
                :in_obesity,
                :in_sedentary_lifestyle,
                :in_smoking,
                :in_dietary_factors,
                :in_stress,
                :in_anemia,
                :in_inflammation,
                :in_genetic_factors,
                :in_heredity,
                :in_height_val,
                :in_hight_mu_name,
                :in_weight_val,
                :in_weight_mu_name,
                :in_bmi_val,
                :in_temp_val,
                :in_temp_mu_name,
                :in_temp_time,
                :in_pulse_val ,
                :in_pulse_time,
                :in_bp_val_sys,
                :in_bp_val_dia,
                :in_bp_time,
                :in_heart_rate,
                :in_heart_rate_time,
                :in_ofc,
                :in_heart_condition,
                :in_lung_condition,
                :in_bowel_condition,
                :in_bladder_condition,
                :in_prescription_date,
                :in_prescription_text_1,
                :in_prescription_text_2,
                :in_prescription_text_3,
                :in_lmp,
                :in_obs,
                :in_edd,
                :in_sfh,
                :in_fm,
                :in_fhs,
                :in_pr,
                :in_hq,
                :in_gestational_age,
                :in_mblood_group,
                :in_gdm,
                :in_dih,
                :in_hypothyroidism,
                :in_brochial_asthma,
                :in_birthorder,
                :in_birth_weight,
                :in_colour,
                :in_abdomen,
                :in_red_eye_reflex,
                :in_RR,
                :in_SPO2,
                :in_swelling,
                :in_scar_work,
                :in_tenderness,
                :in_pae_note,
                :in_alc,
                :in_menstrual_cycle,
                :in_mp,
                :in_mf,
                :in_dysmenorrhoea,
                :in_contraceptive_history,
                :in_drug_history,
                :in_surgical_history,
                :in_medical_history,
                :in_perineum_and_vulva,
                :in_cx,
                :in_vaginal_wall,
                :in_discharge,
                :in_uterus,
                :in_adnexa,
                :in_bme_note,
                :in_d_r_e,
                :in_breast_examination,
                :in_lmp_remarks,
                :in_edd_remarks,
                :in_outcome_measurement,
                :in_family_history,
                :in_complaints_history,
                :in_past_history,
                :in_ref_reason,
                :in_ref_clinic_no_fk,
                :in_management_plan_note,
                :in_ot_date_time,
                :in_ot_advice,
                :in_ipd_referred_advice,
                :in_ipd_referred_date,
                :in_global_hidden_note,
                :in_investigation_findings_note,
                :in_a_lookupdata_item_no_fk,
                :in_a_lookup_uid,
                :in_a_lookupdata_uid,
                :in_a_entry_serial_dtl,
                :in_a_prescrition_data,
                :in_a_left_right_ind,
                :in_a_prescrition_data_dtl,
                :in_a_prescrition_data_dtlval,
                :in_a_prescrition_phy_frequency,
                :in_a_prescrition_phy_mode,
                :in_a_item_no_fk,
                :in_a_entry_serial,
                :in_a_generic_name,
                :in_a_brand_name,
                :in_a_dosage,
                :in_a_duration,
                :in_a_item_qty,
                :in_a_instruction_take,
                :in_a_medicine_comment,
                :in_a_route,
                :in_a_strength,
                :in_a_continue_ind,
                :in_a_duration_comment,
                :in_a_duration_mu,
                :in_a_chronic_ind,
                :in_session_duration,
                :in_session_mu,
                :in_no_of_session,
                :in_unit_intensity,
                :in_unit_intensity_mu,
                :in_multidose,
                :in_m_repetition,
                :in_e_location,
                :in_m_duration,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_prescription_no_pk,
                :out_prescription_uid,
                :out_error); end;");

            $prescription->bindparam(':in_prescription_no_pk', $prescription_id);
            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_appoint_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_doctor_person_no_fk', $doctor_id);
            $prescription->bindparam(':in_su_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_room_no_fk', $in_room_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_uid', $in_admission_code);
            $prescription->bindparam(':in_continue_psn_ind', $zero);
            $prescription->bindparam(':in_continue_psn_no_fk', $zero);
            $prescription->bindparam(':in_note', $rx_note);
            $prescription->bindparam(':in_disposal', $disposal_item);
            $prescription->bindparam(':in_ref_doctor', $referred_doctor);
            //$prescription->bindparam(':in_ref_su_no_fk', $in_ref_su_fk_no);
            $prescription->bindparam(':in_diagnosis', $null);
            $prescription->bindparam(':in_chief_complaints', $null);
            $prescription->bindparam(':in_psn_state', $zero);
            $prescription->bindparam(':in_dental_treatement', $treatment_plan);
            $prescription->bindparam(':in_advice', $null);
            $prescription->bindparam(':in_ipd_ind', $in_ipd_ind);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_hospital_uid', $in_hospital_code);
            $prescription->bindparam(':in_is_patient_in', $zero);
            $prescription->bindparam(':in_is_patient_out', $zero);
            $prescription->bindparam(':in_followup_num', $followup_after);
            $prescription->bindparam(':in_followup_mu', $followup_after_mu);
            $prescription->bindparam(':in_next_followup_dt', $next_followup_dt);
            $prescription->bindparam(':template_name', $template_name);
            $prescription->bindparam(':in_diabetes_mel_typ1', $diabetes_type1);
            $prescription->bindparam(':in_diabetes_mel_typ2', $diabetes_type2);
            $prescription->bindparam(':in_hypertension', $hypertension);
            $prescription->bindparam(':in_dyslipdemia', $dyslipidemia);
            $prescription->bindparam(':in_obesity', $obesity);
            $prescription->bindparam(':in_sedentary_lifestyle', $sedentary_lifestyle);
            $prescription->bindparam(':in_smoking', $smoking);
            $prescription->bindparam(':in_dietary_factors', $dietary_factors);
            $prescription->bindparam(':in_stress', $stress);
            $prescription->bindparam(':in_anemia', $anemia);
            $prescription->bindparam(':in_inflammation', $inflammation);
            $prescription->bindparam(':in_genetic_factors', $genetic_factors);
            $prescription->bindparam(':in_heredity', $heredity);

            //--------vitals----------------
            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $height_unit);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $weight_unit);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp_sys);
            $prescription->bindparam(':in_bp_val_dia', $txt_bp_dia);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $null);
            $prescription->bindparam(':in_ofc', $txt_ofc);

            $prescription->bindparam(':in_heart_condition', $txt_heart_rate);
            $prescription->bindparam(':in_lung_condition', $lung);
            $prescription->bindparam(':in_bowel_condition', $txt_bowel_condition);
            $prescription->bindparam(':in_bladder_condition', $txt_bladder_condition);
            $prescription->bindparam(':in_prescription_date', $pres_date);
            $prescription->bindparam(':in_prescription_text_1', $married_for);
            $prescription->bindparam(':in_prescription_text_2', $para);
            $prescription->bindparam(':in_prescription_text_3', $gravida);
            $prescription->bindparam(':in_lmp', $lmp);
            $prescription->bindparam(':in_obs', $obs);
            $prescription->bindparam(':in_edd', $edd);
            $prescription->bindparam(':in_sfh', $sfh);
            $prescription->bindparam(':in_fm', $fm);
            $prescription->bindparam(':in_fhs', $fhs);
            $prescription->bindparam(':in_pr', $pr);
            $prescription->bindparam(':in_hq', $hq);
            $prescription->bindparam(':in_gestational_age', $g_a);
            $prescription->bindparam(':in_mblood_group', $mb_g);
            $prescription->bindparam(':in_gdm', $gdm);
            $prescription->bindparam(':in_dih', $dih);
            $prescription->bindparam(':in_hypothyroidism', $hypothyroidism);
            $prescription->bindparam(':in_brochial_asthma', $brochial_astma);
            $prescription->bindparam(':in_birthorder', $birth_order);
            $prescription->bindparam(':in_birth_weight', $birth_weight);
            $prescription->bindparam(':in_colour', $color);
            $prescription->bindparam(':in_abdomen', $abdomen);
            $prescription->bindparam(':in_red_eye_reflex', $red_eye_reflex);
            $prescription->bindparam(':in_rr', $rr_val);
            $prescription->bindparam(':in_spo2', $spo2_val);
            $prescription->bindparam(':in_swelling', $swelling);
            $prescription->bindparam(':in_scar_work', $scar_work);
            $prescription->bindparam(':in_tenderness', $tenderness);
            $prescription->bindparam(':in_pae_note', $pae_note);
            $prescription->bindparam(':in_alc', $alc);
            $prescription->bindparam(':in_menstrual_cycle', $menstrual_cycle);
            $prescription->bindparam(':in_mp', $mp);
            $prescription->bindparam(':in_mf', $mf);
            $prescription->bindparam(':in_dysmenorrhoea', $dysmenorrhoea);
            $prescription->bindparam(':in_contraceptive_history', $contraceptive_history);
            $prescription->bindparam(':in_drug_history', $drug_history);
            $prescription->bindparam(':in_surgical_history', $surgical_history);
            $prescription->bindparam(':in_medical_history', $medical_history);
            $prescription->bindparam(':in_perineum_and_vulva', $perineum_and_vulva);
            $prescription->bindparam(':in_cx', $cx);
            $prescription->bindparam(':in_vaginal_wall', $vaginal_wall);
            $prescription->bindparam(':in_discharge', $discharge);
            $prescription->bindparam(':in_uterus', $uterus);
            $prescription->bindparam(':in_adnexa', $adnexa);
            $prescription->bindparam(':in_bme_note', $bme_note);
            $prescription->bindparam(':in_d_r_e', $d_r_e);
            $prescription->bindparam(':in_breast_examination', $breast_examination);
            $prescription->bindparam(':in_lmp_remarks', $lmp_remarks);
            $prescription->bindparam(':in_edd_remarks', $edd_remarks);

            $prescription->bindparam(':in_outcome_measurement', $outcome_measurement);
            $prescription->bindparam(':in_family_history', $family_history);
            $prescription->bindparam(':in_complaints_history', $complaints_history);
            $prescription->bindparam(':in_past_history', $past_history);

            $prescription->bindparam(':in_ref_reason', $reffered_reason);
            $prescription->bindparam(':in_ref_clinic_no_fk', $referred_clinic);
            $prescription->bindparam(':in_management_plan_note', $note);
            $prescription->bindparam(':in_ot_date_time', $formated_ot_date);
            $prescription->bindparam(':in_ot_advice', $advice);
            $prescription->bindparam(':in_ipd_referred_advice', $ipd_referred_advice);
            $prescription->bindparam(':in_ipd_referred_date', $ipd_referred_date);
            $prescription->bindparam(':in_global_hidden_note', $global_hidden_note);
            $prescription->bindparam(':in_investigation_findings_note', $investigation_findings_txt);

            //------- prescription details----
            $prescription->bindArray(':in_a_lookupdata_item_no_fk', $in_item_lookupdata_no_fk, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_lookup_uid', $in_itemtype_lookup_code, (!empty($in_itemtype_lookup_code) ? count($in_itemtype_lookup_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_lookupdata_uid', $in_itemtype_lookupdata_code, (!empty($in_itemtype_lookupdata_code) ? count($in_itemtype_lookupdata_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_entry_serial_dtl', $in_report_serial_dtl, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_prescrition_data', $in_presdtl_data, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_left_right_ind', $in_ocular_position, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtl', $item_dtl_val, (!empty($item_dtl_val) ? count($item_dtl_val) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtlval', $in_report_serial_dtl, (!empty($in_report_serial_dtl) ? count($in_report_serial_dtl) : 1), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_a_prescrition_phy_frequency', $requency, (!empty($requency) ? count($requency) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_phy_mode', $mode, (!empty($mode) ? count($mode) : 1), $numelems, SQLT_CHR);

            //---- prescription medicine ----
            $prescription->bindArray(':in_a_item_no_fk', $medicine_item_id_arr, (!empty($medicine_item_id_arr) ? count($medicine_item_id_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_entry_serial', $in_med_serial_dtl, (!empty($in_med_serial_dtl) ? count($in_med_serial_dtl) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_generic_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_brand_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_dosage', $medicine_dose_arr, (!empty($medicine_dose_arr) ? count($medicine_dose_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration', $medicine_duration_type_arr, (!empty($medicine_duration_type_arr) ? count($medicine_duration_type_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_item_qty', $medicine_quantity_arr, (!empty($medicine_quantity_arr) ? count($medicine_quantity_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_instruction_take', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_medicine_comment', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_route', $route_arr, (!empty($route_arr) ? count($route_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_strength', $strength_arr, (!empty($strength_arr) ? count($strength_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_continue_ind', $continue_ind_arr, (!empty($continue_ind_arr) ? count($continue_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_duration_comment', $duration_comment_arr, (!empty($duration_comment_arr) ? count($duration_comment_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration_mu', $medicine_duration_mu_arr, (!empty($medicine_duration_mu_arr) ? count($medicine_duration_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_chronic_ind', $chronic_ind_arr, (!empty($chronic_ind_arr) ? count($chronic_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_duration', $session_duration_arr, (!empty($session_duration_arr) ? count($session_duration_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_session_mu', $session_mu_arr, (!empty($session_mu_arr) ? count($session_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_no_of_session', $no_of_session_arr, (!empty($no_of_session_arr) ? count($no_of_session_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_unit_intensity', $unit_intensity_arr, (!empty($unit_intensity_arr) ? count($unit_intensity_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_unit_intensity_mu', $unit_intensity_mu_arr, (!empty($unit_intensity_mu_arr) ? count($unit_intensity_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_multidose', $in_med_multidose_dtl, (!empty($in_med_multidose_dtl) ? count($in_med_multidose_dtl) : 1), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_m_repetition', $in_m_repetition, (!empty($in_m_repetition) ? count($in_m_repetition) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_e_location', $in_e_location, (!empty($in_e_location) ? count($in_e_location) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_m_duration', $in_m_duration, (!empty($in_m_duration) ? count($in_m_duration) : 1), $numelems, SQLT_CHR);

            //--- audit and out parameters-------
            //$prescription->bindParam(':in_external_hospital_ind', $hdn_external_ind);
            //$prescription->bindParam(':in_external_hospital_no_fk', $cmb_external_hospital);
            $prescription->bindParam(':in_au_entry_by', $auth_id);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $prescription->bindParam(':out_prescription_no_pk', $out_prescription_no_pk, PDO::PARAM_INT);
            $prescription->bindParam(':out_prescription_uid', $null, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $prescription->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
                return response()->json($message, 422);
            } else {

                // for admission purpose
                if ($disposal_item === 'HOSPITALIZED') {
                    // Check if a record with the given appointment_no_fk exists
                    $existingRequest = DB::table('ipd_admissionrequest')
                        ->where('appointment_no_fk', $in_appointment_no_fk)
                        ->first();

                    if ($existingRequest) {
                        // Update the existing record
                        DB::table('ipd_admissionrequest')
                            ->where('appointment_no_fk', $in_appointment_no_fk)
                            ->update([
                                'admission_req_date' => $ipd_referred_date,
                                'status' => 1,
                                'au_update_at' => date('Y-m-d'),
                                'au_update_session' => 'from opd pres Update',
                                'au_update_by' => auth()->id(),
                            ]);
                    } else {
                        // Retrieve the next sequence value
                        $sequence = DB::getSequence();
                        $admission_req_no_pk_seq = $sequence->nextValue('admission_req_no_pk_seq');
                        // $sequence = DB::select("SELECT nextval('admission_req_no_pk_seq') AS seq");
                        // $admission_req_no_pk_seq = $sequence[0]->seq;
                        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
                        // Insert a new record
                        DB::table('ipd_admissionrequest')->insert([
                            'admission_req_no_pk' => $admission_req_no_pk_seq,
                            'admission_req_date' => $ipd_referred_date,
                            'admission_req_uid' => 'IR' . date('ym') . $admission_req_no_pk_seq,
                            'prescription_no_fk' => $out_prescription_no_pk,
                            'prescription_uid' => $out_prescription_no_pk,
                            'appointment_no_fk' => $in_appointment_no_fk,
                            'opd_department_no_fk' => $in_service_unit_no_fk,
                            'opd_doctor_no_fk' => $doctor_id,
                            'patient_no_fk' => $in_patient_no_fk,
                            'status' => 1,
                            'au_entry_at' => date('Y-m-d'),
                            'au_entry_session' => 'from opd pres',
                            'au_entry_by' => auth()->id(),
                            'au_entry_hospital_no_fk' => $hospital_pk_no,
                        ]);
                    }
                }



                // OT Part Start
                $last_id = 0;
                if (isset($procedure_items[0]) && $procedure_items[0] != '') {
                    $sequencePRO = DB::getSequence();
                    $seq = $sequencePRO->nextValue('OT_REQ_NO_PK_SEQ');
                    $au_entry_at = new DateTime('now');
                    $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
                    $entry_session = Session()->get('user.ses_user_pk_no');

                    $ot_date = $formated_ot_date;

                    $data = [
                        'patient_no_fk' => $in_patient_no_fk,
                        'admission_no_fk' => $request->admission_no_fk,
                        'prescription_no_fk' => $out_prescription_no_pk,
                        'item_no_fk' => $procedure_item_ids[0],
                        'ot_req_date' => $au_entry_at,
                        'OT_DATE' => $formated_ot_date,
                        'item_name' => $procedure_items[0],
                        'doc_person_no_fk' => $doctor_id,
                        'status' => 1,
                    ];

                    $last_id = $request->ot_req_no_fk;

                    if (!empty($last_id)) {
                        $data['au_update_at'] = $au_entry_at;
                        $data['au_update_by'] = Auth::id();
                        $data['au_update_session'] = $entry_session;
                        $data['ot_comfirmation_ind'] = 1;
                        $data['anest_clearance_ind'] = 1;
                        $data['prescription_no_fk'] = $out_prescription_no_pk;
                        $data['au_update_hospital_no_fk'] = $hospital_pk_no;

                        DB::table('opt_prescribed_ot')
                            ->where('ot_req_no_pk', $last_id)
                            ->update($data);
                    } else {
                        $data['ot_req_no_pk'] = $seq;
                        $data['au_entry_at'] = $au_entry_at;
                        $data['au_entry_by'] = Auth::id();
                        $data['au_entry_session'] = $entry_session;
                        $data['ot_comfirmation_ind'] = 1;
                        $data['anest_clearance_ind'] = 1;
                        $data['au_entry_hospital_no_fk'] = $hospital_pk_no;
                        DB::table('opt_prescribed_ot')->insert($data);
                        $last_id = DB::table('opt_prescribed_ot')->orderByDesc('ot_req_no_pk')->value('ot_req_no_pk');
                    }



                    // if (DB::table('OT_SCHEDULE_SLOT')->whereIn('OT_SLOT_NO_PK', $request->ot_time)->whereDate('SCHEDULE_DT', $ot_date)->where('PATIENT_NO_FK', '!=', $request->patient_no_fk, )->where('AVAILABLE_IND', 0)->count() > 0) {
                    //     return response()->json(['success' => false, 'message' => 'Already Booked For Another Patient. Refresh and Try again', 'title' => 'Failed'], 422);
                    // }

                    // DB::table('OT_SCHEDULE_SLOT')->whereIn('OT_SLOT_NO_PK', $request->ot_slot_id)->whereDate('SCHEDULE_DT', $formated_ot_date)->where('AVAILABLE_IND', 1)
                    //     ->update([
                    //         'AVAILABLE_IND' => 0,
                    //         'OT_REQ_NO_FK' => $last_id,
                    //         'PATIENT_NO_FK' => $in_patient_no_fk,
                    //         'admission_no_fk' => $request->admission_no_fk,
                    //     ]);
                    // }

                    DB::table('ot_schedule_slot')->where('ot_slot_no_pk', $request->ot_slot_id)->wheredate('schedule_dt', $formated_ot_date)->where('available_ind', 1)
                        ->update([
                            'available_ind' => 0,
                            'ot_req_no_fk' => $last_id,
                            'patient_no_fk' => $in_patient_no_fk,
                        ]);
                }
                DB::commit();
                // dd($last_id,$procedure_items[0],$procedure_items[0]);


                // for Referral to OT purpase

                $combined = date('Y-m-d H:i:s', strtotime("$procedureDate $procedureTime"));

                if ($referredToAnesthesia) {
                    $ref_doc = $request->ref_doc;
                    $sequenceanesRef = DB::getSequence();
                    $seqRef = $sequenceanesRef->nextValue('REFF_ANES_DEPT_NO_PK_SEQ');
                    DB::table('OPD_REFF_ANESTHESIA_DEPT')->insert([
                        'REFF_ANES_DEPT_NO_PK' => $seqRef,
                        'PATIENT_NO_FK' => $in_patient_no_fk,
                        'APPOINT_NO_FK' => $in_appointment_no_fk,
                        'PRESCRIPTION_NO_FK' => $out_prescription_no_pk,
                        'REFF_DOC_NO_FK' => $ref_doc,
                        'PATIENT_TYPE' => 'OPD',
                        'PURPOSE_OFF_REFF' => $purpose,
                        'DIAGNOSIS' => $diagnosis,
                        'OT_REQ_NO_FK' => $last_id,
                        'RESULT_OF_INV_NOTE' => $investigationResult,
                        'PLANE_PROC_WITHDATE' => $plannedProcedure,
                        'REFF_DATE' => $combined,
                        'ESTIMATED_DURATION_SURGE' => $estimatedDuration,
                        'URGENCY_DETAILS' => $request->urgency,
                        'SPECEFIC_REQ_N_REMARKS' => $specificRequirements,
                        'STATUS' => 1, //refered
                        'AU_ENTRY_BY' => $auth_id,
                        'AU_ENTRY_AT' => date('Y-m-d'),
                        'AU_ENTRY_SESSION' => $in_au_entry_session,
                        'AU_ENTRY_HOSPITAL_PK_NO' => $in_au_entry_hospital_pk_no,
                    ]);
                }
                DB::commit();

                // OT Part End


                DB::table('patn_registration')->where('patient_no_pk', $request->hdn_patient_id)
                    ->update(['blood_group' => $request->pat_blood_group]);

                if ($request->hdn_eye_ind == 1) {
                    // delete previous spectacles and insert again
                    PrescriptionEye::where('prescription_no_fk', $out_prescription_no_pk)->delete();

                    $prescriptionEye = new PrescriptionEye();
                    $prescriptionEye->prescription_no_fk = $out_prescription_no_pk;
                    $prescriptionEye->axis_left_dv = $txt_r_dv_axis;
                    $prescriptionEye->axis_right_dv = $txt_l_dv_axis;
                    $prescriptionEye->cyl_left_dv = $txt_l_dv_cyl;
                    $prescriptionEye->cyl_right_dv = $txt_r_dv_cyl;
                    $prescriptionEye->sph_left_dv = $txt_l_dv_sph;
                    $prescriptionEye->sph_right_dv = $txt_r_dv_sph;
                    $prescriptionEye->va_left_dv = $txt_l_dv_va;
                    $prescriptionEye->va_right_dv = $txt_r_dv_va;
                    $prescriptionEye->axis_left_nv = $txt_l_nv_axis;
                    $prescriptionEye->axis_right_nv = $txt_r_nv_axis;
                    $prescriptionEye->cyl_left_nv = $txt_l_nv_cyl;
                    $prescriptionEye->cyl_right_nv = $txt_r_nv_cyl;
                    $prescriptionEye->sph_left_nv = $txt_l_nv_sph;
                    $prescriptionEye->sph_right_nv = $txt_r_nv_sph;
                    $prescriptionEye->va_left_nv = $txt_l_nv_va;
                    $prescriptionEye->va_right_nv = $txt_r_nv_va;
                    $prescriptionEye->add_left = $txt_l_add;
                    $prescriptionEye->add_right = $txt_r_add;
                    $prescriptionEye->i_p_d = $txt_ipd;
                    $prescriptionEye->remarks_txt = $txt_spec_remarks;
                    $prescriptionEye->glass_type = $txt_glass;
                    $prescriptionEye->usage_type = $txt_usage_type;
                    $prescriptionEye->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $prescriptionEye->save();
                }

                // throw new Exception('error');

                if ($request->reply_type != '') {
                    DB::table('OPD_REFF_ANESTHESIA_DEPT')
                        ->where('REFF_ANES_DEPT_NO_PK', $request->reff_anes_dept_no_pk)
                        ->update([
                            'REPLY_LETTER' => $request->replyMessage,
                            'REPLY_TYPE' => $request->reply_type === 'DEFERRED' ? 'REJECT' : 'ACCEPT',
                            'ANESTH_DOC_NO_FK' => Session::get('user.ses_person_no_fk'),
                            'FEEDBACK_DATE' => date('Y-m-d'),
                        ]);

                    if ($request->reply_type !== 'DEFERRED') {
                        $prescription_no_fk = DB::table('opd_reff_anesthesia_dept')
                            ->where('reff_anes_dept_no_pk', (int) $request->reff_anes_dept_no_pk)
                            ->value('prescription_no_fk');
                        if ($prescription_no_fk) {
                            DB::table('opt_prescribed_ot')
                                ->where('prescription_no_fk', (int) $prescription_no_fk)
                                ->update(['reff_anes_dept_no_fk' => $request->reff_anes_dept_no_pk]);
                        }
                    }
                }


                // TV Update
                if (DB::table('SYSC_TVSCREENSETUP')->where('TVTAG', 'APPOINTMENTTV')->value('status') == 1) {
                    DB::table('opd_patdisplay')->where('APPOINT_NO_FK', $in_appointment_no_fk)->update(['movement_type_no' => 3]);
                    DB::commit();
                    $data = $this->tv_information->get_tv_data(null);
                    event(new TVUpdate($data));
                } else {
                    DB::commit();
                }
                // TV Update
                $message = ['msg' => 'New Prescription created successfully.Prescription ID = ' . $out_prescription_no_pk . '-' . $in_appointment_no_fk, 'title' => 'Success', 'insert_id' => $out_prescription_no_pk];
                return response()->json($message, 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];

            $error_taxt = substr($e->getMessage(), 0, 4000);
            $sequence = DB::getSequence();
            $errorcach_no_fk = $sequence->nextValue('errorcach_no_fk_seq');

            $error_data = [
                'errorcach_no_fk' => $errorcach_no_fk,
                'source_name' => 'Prescription',
                'user_id' => auth::user()->user_no_pk,
                "error_taxt" => $error_taxt
            ];

            DB::table("db_errorcache")->insert($error_data);

            return response()->json($message, 422);
        }
    }



    public function opdPresCreateOrUpdateImpala($request, $id = null)
    {
        date_default_timezone_set('Asia/Dhaka');
        $auth_id = Auth::id();
        $user_info = Auth::user();
        // $doctor_id='';
        // $in_service_unit_no_fk='';

        if ($request->hdn_external_ind == 1) {
            $doctor_id = $request->hdn_doctor_id;
            $in_service_unit_no_fk = $request->su_no;
        } else {
            $doctor_id = Session::get("user.ses_person_no_fk");
            $in_service_unit_no_fk = $request->hdn_su_no;
        }
        DB::beginTransaction();

        try {
            $prescription_id = $request->hdn_prescription_id;
            $in_appointment_no_fk = ($request->hdn_appointment_id != "") ? $request->hdn_appointment_id : '';
            // $this->quickAppointment($request->hdn_patient_id, $request->hdn_doctor_id, $request->hdn_room_no);
            $in_doctor_person_no_fk = $request->hdn_doctor_id;
            $in_hospital_code = 'HC';
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;

            $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = $request->hdn_room_no;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp_sys = $request->txt_bp_sys;
            $txt_bp_dia = $request->txt_bp_dia;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $txt_ofc = $request->txt_ofc;
            $txt_bmi = $request->txt_bmi;

            $sfh = $request->sfh;
            $fm = $request->fm;
            $fhs = $request->fhs;
            $pr = $request->pr;
            $hq = $request->hq;

            //Added By EMON 24/03/2024
            $swelling = $request->swelling;
            $scar_work = $request->scar_work;
            $tenderness = $request->tenderness;
            $pae_note = $request->pae_note;

            $alc = $request->alc;
            $menstrual_cycle = $request->menstrual_cycle;
            $mp = $request->mp;
            $mf = $request->mf;
            $dysmenorrhoea = $request->dysmenorrhoea;
            $contraceptive_history = $request->contraceptive_history;
            $drug_history = $request->drug_history;
            $surgical_history = $request->surgical_history;
            $medical_history = $request->medical_history;
            $perineum_and_vulva = $request->perineum_and_vulva;
            $cx = $request->cx;
            $vaginal_wall = $request->vaginal_wall;
            $discharge = $request->discharge;
            $uterus = $request->uterus;
            $adnexa = $request->adnexa;
            $bme_note = $request->bme_note;
            $d_r_e = $request->d_r_e;
            $breast_examination = $request->breast_examination;


            $txt_heart_rate = $request->txt_heart_rate;
            $txt_lung_condition = $request->txt_lung_condition;
            $txt_bowel_condition = $request->txt_bowel_condition;
            $txt_bladder_condition = $request->txt_bladder_condition;

            $next_followup = strval($request->next_followup);
            $pres_date = isset($request->pres_date) ? date('Y-m-d h:i:s', strtotime($request->pres_date)) : date('Y-m-d h:i:s');
            $empty = '';


            $next_followup_dt = ($request->next_followup != "") ? date("Y-m-d", strtotime($next_followup)) : "";

            $followup_after = trim($request->followup_after);
            $followup_after_mu = $request->followup_after_mu;
            $referred_doctor = $request->ref_doc_card_hidn;
            // $referred_doctor = '';old
            /* $referred_doctor        = trim($request->txt_referred_doctor); */
            $expected_session = $request->expected_session != "" ? $request->expected_session . " " . $request->expected_session_mu : "";

            // $rx_note = trim($request->txt_rx_note) . "^" . $expected_session;
            $rx_note = $request->txt_rx_note != '' ? (trim($request->txt_rx_note) . "^" . $expected_session) : '';
            $template_name = trim($request->template_name);
            $treatment_plan = trim($request->txt_treatment_plan);

            $txt_r_dv_sph = $request->txt_r_dv_sph;
            $txt_r_dv_cyl = $request->txt_r_dv_cyl;
            $txt_r_dv_axis = $request->txt_r_dv_axis;
            $txt_r_dv_va = $request->txt_r_dv_va;
            $txt_r_nv_sph = $request->txt_r_nv_sph;
            $txt_r_nv_cyl = $request->txt_r_nv_cyl;
            $txt_r_nv_axis = $request->txt_r_nv_axis;
            $txt_r_nv_va = $request->txt_r_nv_va;

            $txt_l_dv_sph = $request->txt_l_dv_sph;
            $txt_l_dv_cyl = $request->txt_l_dv_cyl;
            $txt_l_dv_axis = $request->txt_l_dv_axis;
            $txt_l_dv_va = $request->txt_l_dv_va;
            $txt_l_nv_sph = $request->txt_l_nv_sph;
            $txt_l_nv_cyl = $request->txt_l_nv_cyl;
            $txt_l_nv_axis = $request->txt_l_nv_axis;
            $txt_l_nv_va = $request->txt_l_nv_va;

            $txt_r_add = $request->txt_r_add;
            $txt_l_add = $request->txt_l_add;
            $txt_ipd = $request->txt_ipd;
            $txt_spec_remarks = $request->txt_spec_remarks;
            $txt_glass = $request->txt_glass;
            $txt_usage_type = $request->txt_usage_type;

            $item_id = $request->item_id;
            $item_name = $request->item_name;
            $lmp = date("Y-m-d", strtotime($request->lmp));
            $obs = $request->obs;

            $married_for = $request->married_for;
            $para = $request->para;
            $gravida = $request->gravida;
            $edd = date("Y-m-d", strtotime($request->edd));
            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;

            $item_dtl_val = $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_code = $in_ocular_position = $unit_intensity_arr = $session_duration_arr = $no_of_session_arr = $session_mu_arr = $requency = $mode = [];

            if (!empty($item_name)) {
                for ($i = 0; $i < sizeof($item_name); $i++) {
                    if ($item_name[$i] != "") {
                        $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                        $in_report_serial_dtl[$i] = 0;
                        //$item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';

                        $item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';

                        $in_presdtl_data[$i] = $item_name[$i];
                        $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                        $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                        $unit_intensity_arr[$i] = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : 0;
                        $session_duration_arr[$i] = isset($request->session_duration[$i]) ? $request->session_duration[$i] : 0;
                        $no_of_session_arr[$i] = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : 0;
                        $session_mu_arr[$i] = isset($request->session_mu[$i]) ? $request->session_mu[$i] : 0;
                        $unit_intensity_mu_arr[$i] = 0;
                        $in_ocular_position[$i] = isset($request->ocular_position[$i]) ? $request->ocular_position[$i] : '';

                        $requency[$i] = isset($request->frequency[$i]) ? $request->frequency[$i] : '';
                        $mode[$i] = isset($request->mode[$i]) ? $request->mode[$i] : '';
                    }
                }
            }

            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = isset($request->is_continue) ? array_flip($request->is_continue) : $request->is_continue;
            $is_chronic = isset($request->is_chronic) ? array_flip($request->is_chronic) : $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;


            $array_count_med = count($medicine_item_id);
            $array_count_mul = count($request->multidose);

            if ($array_count_med === $array_count_mul) {
                $multidose_dt = $request->multidose;
            } elseif ($array_count_med < $array_count_mul) {
                $multidose_dt = array_slice($request->multidose, 1);
            } elseif ($array_count_med > $array_count_mul) {
                $a = array("");
                $multidose_dt = array_push($a, $request->multidose);
            }


            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $chronic_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = $in_med_serial_dtl = $in_med_multidose_dtl = [];

            if (!empty($medicine_item)) {
                for ($j = 1; $j < sizeof($medicine_item); $j++) {
                    if ($medicine_item[$j] != "") {
                        $medicine_item_id_arr[$j] = $medicine_item_id[$j];
                        $medicine_item_arr[$j] = $medicine_item[$j];
                        $medicine_dose_arr[$j] = $medicine_dose[$j];
                        $medicine_duration_type_arr[$j] = $medicine_duration_type[$j];
                        $medicine_duration_mu_arr[$j] = $medicine_duration_mu[$j];
                        $medicine_quantity_arr[$j] = $medicine_quantity[$j];
                        $instruction_arr[$j] = $instruction[$j];
                        $report_serial_med_arr[$j] = $report_serial_med[$j] ? 1 : 0;

                        $continue_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;
                        $chronic_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;

                        $duration_comment_arr[$j] = "";
                        $route_arr[$j] = $medicine_route[$j];
                        $strength_arr[$j] = "";
                        $brand_ud_arr[$j] = "";
                        $in_med_serial_dtl[$j] = 0;
                        // multidose
                        $in_med_multidose_dtl[$j] = $multidose_dt[$j];
                    }
                }
            }
            //   dd($in_med_multidose_dtl);
            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;

            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';

            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();
            $prescription = $pdo->prepare("begin pkg_emr.prescription_opd(
                :in_prescription_no_pk,
                :in_patient_no_fk,
                :in_appoint_no_fk,
                :in_doctor_person_no_fk,
                :in_su_no_fk,
                :in_room_no_fk,
                :in_admission_no_fk,
                :in_admission_uid,
                :in_continue_psn_ind,
                :in_continue_psn_no_fk,
                :in_note,
                :in_disposal,
                :in_ref_doctor,
                :in_diagnosis,
                :in_chief_complaints,
                :in_psn_state,
                :in_dental_treatement,
                :in_advice,
                :in_ipd_ind,
                :in_opd_ind,
                :in_hospital_uid,
                :in_is_patient_in,
                :in_is_patient_out,
                :in_followup_num,
                :in_followup_mu,
                :in_next_followup_dt,
                :template_name,
                :in_height_val,
                :in_hight_mu_name,
                :in_weight_val,
                :in_weight_mu_name,
                :in_bmi_val,
                :in_temp_val,
                :in_temp_mu_name,
                :in_temp_time,
                :in_pulse_val ,
                :in_pulse_time,
                :in_bp_val_sys,
                :in_bp_val_dia,
                :in_bp_time,
                :in_heart_rate,
                :in_heart_rate_time,
                :in_ofc,
                :in_heart_condition,
                :in_lung_condition,
                :in_bowel_condition,
                :in_bladder_condition,
                :in_prescription_date,
                :in_prescription_text_1,
                :in_prescription_text_2,
                :in_prescription_text_3,
                :in_lmp,
                :in_obs,
                :in_edd,
                :in_sfh,
                :in_fm,
                :in_fhs,
                :in_pr,
                :in_hq,
                :in_gestational_age,
                :in_mblood_group,
                :in_gdm,
                :in_dih,
                :in_hypothyroidism,
                :in_brochial_asthma,
                :in_birthorder,
                :in_birth_weight,
                :in_colour,
                :in_abdomen,
                :in_red_eye_reflex,
                :in_RR,
                :in_SPO2,
                :in_swelling,
                :in_scar_work,
                :in_tenderness,
                :in_pae_note,
                :in_alc,
                :in_menstrual_cycle,
                :in_mp,
                :in_mf,
                :in_dysmenorrhoea,
                :in_contraceptive_history,
                :in_drug_history,
                :in_surgical_history,
                :in_medical_history,
                :in_perineum_and_vulva,
                :in_cx,
                :in_vaginal_wall,
                :in_discharge,
                :in_uterus,
                :in_adnexa,
                :in_bme_note,
                :in_d_r_e,
                :in_breast_examination,
                :in_a_lookupdata_item_no_fk,
                :in_a_lookup_uid,
                :in_a_lookupdata_uid,
                :in_a_entry_serial_dtl,
                :in_a_prescrition_data,
                :in_a_left_right_ind,
                :in_a_prescrition_data_dtl,
                :in_a_prescrition_data_dtlval,
                :in_a_prescrition_phy_frequency,
                :in_a_prescrition_phy_mode,
                :in_a_item_no_fk,
                :in_a_entry_serial,
                :in_a_generic_name,
                :in_a_brand_name,
                :in_a_dosage,
                :in_a_duration,
                :in_a_item_qty,
                :in_a_instruction_take,
                :in_a_medicine_comment,
                :in_a_route,
                :in_a_strength,
                :in_a_continue_ind,
                :in_a_duration_comment,
                :in_a_duration_mu,
                :in_a_chronic_ind,
                :in_session_duration,
                :in_session_mu,
                :in_no_of_session,
                :in_unit_intensity,
                :in_unit_intensity_mu,
                :in_multidose,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_prescription_no_pk,
                :out_prescription_uid,
                :out_error); end;");

            $prescription->bindparam(':in_prescription_no_pk', $prescription_id);
            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_appoint_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_doctor_person_no_fk', $doctor_id);
            $prescription->bindparam(':in_su_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_room_no_fk', $in_room_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_uid', $in_admission_code);
            $prescription->bindparam(':in_continue_psn_ind', $zero);
            $prescription->bindparam(':in_continue_psn_no_fk', $zero);
            $prescription->bindparam(':in_note', $rx_note);
            $prescription->bindparam(':in_disposal', $null);
            $prescription->bindparam(':in_ref_doctor', $referred_doctor);
            //$prescription->bindparam(':in_ref_su_no_fk', $in_ref_su_fk_no);
            $prescription->bindparam(':in_diagnosis', $null);
            $prescription->bindparam(':in_chief_complaints', $null);
            $prescription->bindparam(':in_psn_state', $zero);
            $prescription->bindparam(':in_dental_treatement', $treatment_plan);
            $prescription->bindparam(':in_advice', $null);
            $prescription->bindparam(':in_ipd_ind', $in_ipd_ind);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_hospital_uid', $in_hospital_code);
            $prescription->bindparam(':in_is_patient_in', $zero);
            $prescription->bindparam(':in_is_patient_out', $zero);
            $prescription->bindparam(':in_followup_num', $followup_after);
            $prescription->bindparam(':in_followup_mu', $followup_after_mu);
            $prescription->bindparam(':in_next_followup_dt', $next_followup_dt);
            $prescription->bindparam(':template_name', $template_name);

            //--------vitals----------------
            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $null);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $null);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp_sys);
            $prescription->bindparam(':in_bp_val_dia', $txt_bp_dia);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $null);
            $prescription->bindparam(':in_ofc', $txt_ofc); //44

            $prescription->bindparam(':in_heart_condition', $txt_heart_rate);
            $prescription->bindparam(':in_lung_condition', $txt_lung_condition);
            $prescription->bindparam(':in_bowel_condition', $txt_bowel_condition);
            $prescription->bindparam(':in_bladder_condition', $txt_bladder_condition);
            $prescription->bindparam(':in_prescription_date', $pres_date); //44
            $prescription->bindparam(':in_prescription_text_1', $empty); //44
            $prescription->bindparam(':in_prescription_text_2', $empty); //44
            $prescription->bindparam(':in_prescription_text_3', $empty); //44
            $prescription->bindparam(':in_lmp', $lmp);
            $prescription->bindparam(':in_obs', $obs);
            $prescription->bindparam(':in_edd', $edd);
            $prescription->bindparam(':in_sfh', $sfh);
            $prescription->bindparam(':in_fm', $fm);
            $prescription->bindparam(':in_fhs', $fhs);
            $prescription->bindparam(':in_pr', $pr);
            $prescription->bindparam(':in_hq', $hq);
            $prescription->bindparam(':in_gestational_age', $null);
            $prescription->bindparam(':in_mblood_group', $null);
            $prescription->bindparam(':in_gdm', $null);
            $prescription->bindparam(':in_dih', $null);
            $prescription->bindparam(':in_hypothyroidism', $null);
            $prescription->bindparam(':in_brochial_asthma', $null);
            $prescription->bindparam(':in_birthorder', $null);
            $prescription->bindparam(':in_birth_weight', $null);
            $prescription->bindparam(':in_colour', $null);
            $prescription->bindparam(':in_abdomen', $null);
            $prescription->bindparam(':in_red_eye_reflex', $null);
            $prescription->bindparam(':in_RR', $null);
            $prescription->bindparam(':in_SPO2', $null);
            //Added by EMON 24/03/2024
            $prescription->bindparam(':in_swelling', $swelling);
            $prescription->bindparam(':in_scar_work', $scar_work);
            $prescription->bindparam(':in_tenderness', $tenderness);
            $prescription->bindparam(':in_pae_note', $pae_note);
            $prescription->bindparam(':in_alc', $alc);
            $prescription->bindparam(':in_menstrual_cycle', $menstrual_cycle);
            $prescription->bindparam(':in_mp', $mp);
            $prescription->bindparam(':in_mf', $mf);
            $prescription->bindparam(':in_dysmenorrhoea', $dysmenorrhoea);
            $prescription->bindparam(':in_contraceptive_history', $contraceptive_history);
            $prescription->bindparam(':in_drug_history', $drug_history);
            $prescription->bindparam(':in_surgical_history', $surgical_history);
            $prescription->bindparam(':in_medical_history', $medical_history);
            $prescription->bindparam(':in_perineum_and_vulva', $perineum_and_vulva);
            $prescription->bindparam(':in_cx', $cx);
            $prescription->bindparam(':in_vaginal_wall', $vaginal_wall);
            $prescription->bindparam(':in_discharge', $discharge);
            $prescription->bindparam(':in_uterus', $uterus);
            $prescription->bindparam(':in_adnexa', $adnexa);
            $prescription->bindparam(':in_bme_note', $bme_note);
            $prescription->bindparam(':in_d_r_e', $d_r_e);
            $prescription->bindparam(':in_breast_examination', $breast_examination);

            //------- prescription details----
            $prescription->bindArray(':in_a_lookupdata_item_no_fk', $in_item_lookupdata_no_fk, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_lookup_uid', $in_itemtype_lookup_code, (!empty($in_itemtype_lookup_code) ? count($in_itemtype_lookup_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_lookupdata_uid', $in_itemtype_lookupdata_code, (!empty($in_itemtype_lookupdata_code) ? count($in_itemtype_lookupdata_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_entry_serial_dtl', $in_report_serial_dtl, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_prescrition_data', $in_presdtl_data, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_left_right_ind', $in_ocular_position, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtl', $item_dtl_val, (!empty($item_dtl_val) ? count($item_dtl_val) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtlval', $in_report_serial_dtl, (!empty($in_report_serial_dtl) ? count($in_report_serial_dtl) : 1), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_a_prescrition_phy_frequency', $requency, (!empty($requency) ? count($requency) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_phy_mode', $mode, (!empty($mode) ? count($mode) : 1), $numelems, SQLT_CHR);

            //---- prescription medicine ----
            $prescription->bindArray(':in_a_item_no_fk', $medicine_item_id_arr, (!empty($medicine_item_id_arr) ? count($medicine_item_id_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_entry_serial', $in_med_serial_dtl, (!empty($in_med_serial_dtl) ? count($in_med_serial_dtl) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_generic_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_brand_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_dosage', $medicine_dose_arr, (!empty($medicine_dose_arr) ? count($medicine_dose_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration', $medicine_duration_type_arr, (!empty($medicine_duration_type_arr) ? count($medicine_duration_type_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_item_qty', $medicine_quantity_arr, (!empty($medicine_quantity_arr) ? count($medicine_quantity_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_instruction_take', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_medicine_comment', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_route', $route_arr, (!empty($route_arr) ? count($route_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_strength', $strength_arr, (!empty($strength_arr) ? count($strength_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_continue_ind', $continue_ind_arr, (!empty($continue_ind_arr) ? count($continue_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_duration_comment', $duration_comment_arr, (!empty($duration_comment_arr) ? count($duration_comment_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration_mu', $medicine_duration_mu_arr, (!empty($medicine_duration_mu_arr) ? count($medicine_duration_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_chronic_ind', $chronic_ind_arr, (!empty($chronic_ind_arr) ? count($chronic_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_duration', $session_duration_arr, (!empty($session_duration_arr) ? count($session_duration_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_session_mu', $session_mu_arr, (!empty($session_mu_arr) ? count($session_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_no_of_session', $no_of_session_arr, (!empty($no_of_session_arr) ? count($no_of_session_arr) : 1), $numelems, SQLT_FLT);
            $prescription->bindArray(':in_unit_intensity', $unit_intensity_arr, (!empty($unit_intensity_arr) ? count($unit_intensity_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_unit_intensity_mu', $unit_intensity_mu_arr, (!empty($unit_intensity_mu_arr) ? count($unit_intensity_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_multidose', $in_med_multidose_dtl, (!empty($in_med_multidose_dtl) ? count($in_med_multidose_dtl) : 1), $numelems, SQLT_CHR);

            //--- audit and out parameters-------
            // $prescription->bindParam(':in_external_hospital_ind', $hdn_external_ind);
            //$prescription->bindParam(':in_external_hospital_no_fk', $cmb_external_hospital);
            $prescription->bindParam(':in_au_entry_by', $auth_id);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $prescription->bindParam(':out_prescription_no_pk', $out_prescription_no_pk, PDO::PARAM_INT);
            $prescription->bindParam(':out_prescription_uid', $null, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $prescription->execute();
            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
            } else {
                if ($request->hdn_eye_ind == 1) {
                    // delete previous spectacles and insert again
                    PrescriptionEye::where('prescription_no_fk', $out_prescription_no_pk)->delete();

                    $prescriptionEye = new PrescriptionEye();
                    $prescriptionEye->prescription_no_fk = $out_prescription_no_pk;
                    $prescriptionEye->axis_left_dv = $txt_r_dv_axis;
                    $prescriptionEye->axis_right_dv = $txt_r_dv_axis;
                    $prescriptionEye->cyl_left_dv = $txt_l_dv_cyl;
                    $prescriptionEye->cyl_right_dv = $txt_r_dv_cyl;
                    $prescriptionEye->sph_left_dv = $txt_l_dv_sph;
                    $prescriptionEye->sph_right_dv = $txt_r_dv_sph;
                    $prescriptionEye->va_left_dv = $txt_l_dv_va;
                    $prescriptionEye->va_right_dv = $txt_r_dv_va;
                    $prescriptionEye->axis_left_nv = $txt_l_nv_axis;
                    $prescriptionEye->axis_right_nv = $txt_r_nv_axis;
                    $prescriptionEye->cyl_left_nv = $txt_l_nv_cyl;
                    $prescriptionEye->cyl_right_nv = $txt_r_nv_cyl;
                    $prescriptionEye->sph_left_nv = $txt_l_nv_sph;
                    $prescriptionEye->sph_right_nv = $txt_r_nv_sph;
                    $prescriptionEye->va_left_nv = $txt_l_nv_va;
                    $prescriptionEye->va_right_nv = $txt_r_nv_va;
                    $prescriptionEye->add_left = $txt_l_add;
                    $prescriptionEye->add_right = $txt_r_add;
                    $prescriptionEye->i_p_d = $txt_ipd;
                    $prescriptionEye->remarks_txt = $txt_spec_remarks;
                    $prescriptionEye->glass_type = $txt_glass;
                    $prescriptionEye->usage_type = $txt_usage_type;
                    $prescriptionEye->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $prescriptionEye->save();
                }
                DB::commit();
                $message = ['msg' => 'New Prescription created successfully.Prescription ID = ' . $out_prescription_no_pk, 'title' => 'Success', 'insert_id' => $out_prescription_no_pk];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function opdPresCreateOrUpdate2($request, $id = null)
    {
        date_default_timezone_set('Asia/Dhaka');
        // dd($request->hdn_patient_code);
        $dt = new \DateTime('now', new \DateTimezone('Asia/Dhaka'));
        $dateTime = $dt->format('Y-m-d H:i');
        $auth_id = Auth::id();
        $user_info = Auth::user();
        // $doctor_id='';
        // $in_service_unit_no_fk='';

        if ($request->hdn_external_ind == 1) {
            $doctor_id = $request->hdn_doctor_id;
            $in_service_unit_no_fk = $request->su_no;

            // dd($request->hdn_external_ind, $in_service_unit_no_fk );
        } else {
            $doctor_id = Session::get("user.ses_person_no_fk");
            $in_service_unit_no_fk = $request->hdn_su_no;
        }
        //    dd($in_service_unit_no_fk);
        DB::beginTransaction();

        try {
            $prescription_id = ''; //$request->hdn_prescription_id;
            $in_appointment_no_fk = ($request->hdn_appointment_id != "") ? $request->hdn_appointment_id : '';
            // $this->quickAppointment($request->hdn_patient_id, $request->hdn_doctor_id, $request->hdn_room_no);
            $in_doctor_person_no_fk = $request->hdn_doctor_id;
            $in_hospital_code = 'HC';
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;

            $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = $request->hdn_room_no;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp_sys = $request->txt_bp_sys;
            $txt_bp_dia = $request->txt_bp_dia;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $txt_ofc = $request->txt_ofc;
            $txt_bmi = $request->txt_bmi;

            $next_followup = strval($request->next_followup);
            // $pres_date = $dateTime;
            // dd($pres_date);
            $empty = '';


            $next_followup_dt = ($request->next_followup != "") ? date("Y-m-d", strtotime($next_followup)) : "";

            $followup_after = trim($request->followup_after);
            $followup_after_mu = $request->followup_after_mu;
            $referred_doctor = '';
            /* $referred_doctor        = trim($request->txt_referred_doctor); */
            $expected_session = $request->expected_session != "" ? $request->expected_session . " " . $request->expected_session_mu : "";
            $rx_note = trim($request->txt_rx_note) . "^" . $expected_session;
            $template_name = trim($request->template_name);
            $treatment_plan = trim($request->txt_treatment_plan);

            $txt_r_dv_sph = $request->txt_r_dv_sph;
            $txt_r_dv_cyl = $request->txt_r_dv_cyl;
            $txt_r_dv_axis = $request->txt_r_dv_axis;
            $txt_r_dv_va = $request->txt_r_dv_va;
            $txt_r_nv_sph = $request->txt_r_nv_sph;
            $txt_r_nv_cyl = $request->txt_r_nv_cyl;
            $txt_r_nv_axis = $request->txt_r_nv_axis;
            $txt_r_nv_va = $request->txt_r_nv_va;

            $txt_l_dv_sph = $request->txt_l_dv_sph;
            $txt_l_dv_cyl = $request->txt_l_dv_cyl;
            $txt_l_dv_axis = $request->txt_l_dv_axis;
            $txt_l_dv_va = $request->txt_l_dv_va;
            $txt_l_nv_sph = $request->txt_l_nv_sph;
            $txt_l_nv_cyl = $request->txt_l_nv_cyl;
            $txt_l_nv_axis = $request->txt_l_nv_axis;
            $txt_l_nv_va = $request->txt_l_nv_va;

            $txt_r_add = $request->txt_r_add;
            $txt_l_add = $request->txt_l_add;
            $txt_ipd = $request->txt_ipd;
            $txt_spec_remarks = $request->txt_spec_remarks;
            $txt_glass = $request->txt_glass;
            $txt_usage_type = $request->txt_usage_type;

            $item_id = $request->item_id;
            $item_name = $request->item_name;


            $item_dtl_val = $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_code = $in_ocular_position = $unit_intensity_arr = $session_duration_arr = $no_of_session_arr = $session_mu_arr = $frequency_arr = $mode_arr = []; //$frequency_arr = $mode_arr =

            if (!empty($item_name)) {
                for ($i = 0; $i < sizeof($item_name); $i++) {
                    if ($item_name[$i] != "") {
                        $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                        $in_report_serial_dtl[$i] = 0;
                        //$item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';

                        $item_dtl_val[$i] = isset($request->item_dtl_val[$i]) ? $request->item_dtl_val[$i] : '';


                        $in_presdtl_data[$i] = $item_name[$i];
                        $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                        $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                        $unit_intensity_arr[$i] = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : 0;
                        $session_duration_arr[$i] = isset($request->session_duration[$i]) ? $request->session_duration[$i] : 0;
                        $no_of_session_arr[$i] = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : 0;
                        $session_mu_arr[$i] = isset($request->session_mu[$i]) ? $request->session_mu[$i] : 0;
                        $unit_intensity_mu_arr[$i] = 0;
                        $in_ocular_position[$i] = isset($request->ocular_position[$i]) ? $request->ocular_position[$i] : '';
                        $frequency_arr[$i] = isset($request->frequency[$i]) ? $request->frequency[$i] : '';
                        $mode_arr[$i] = isset($request->mode[$i]) ? $request->mode[$i] : '';
                    }
                }
            }
            //dd($request->unit_intensity, $request->session_duration, $request->no_of_session , $request->session_mu,$in_presdtl_data );
            //dd($unit_intensity_arr, $session_duration_arr , $no_of_session_arr,$session_mu_arr, $in_presdtl_data,$in_item_lookupdata_no_fk , $in_itemtype_lookupdata_code,$item_dtl_val, $unit_intensity_mu_arr,$in_ocular_position,$frequency_arr, $mode_arr);
            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = isset($request->is_continue) ? array_flip($request->is_continue) : $request->is_continue;
            $is_chronic = isset($request->is_chronic) ? array_flip($request->is_chronic) : $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;

            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $chronic_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = $in_med_serial_dtl = [];

            if (!empty($medicine_item)) {
                for ($j = 1; $j < sizeof($medicine_item); $j++) {
                    if ($medicine_item[$j] != "") {

                        $medicine_item_id_arr[$j] = $medicine_item_id[$j];
                        $medicine_item_arr[$j] = $medicine_item[$j];
                        $medicine_dose_arr[$j] = $medicine_dose[$j];
                        $medicine_duration_type_arr[$j] = $medicine_duration_type[$j];
                        $medicine_duration_mu_arr[$j] = $medicine_duration_mu[$j];
                        $medicine_quantity_arr[$j] = $medicine_quantity[$j];
                        $instruction_arr[$j] = $instruction[$j];
                        $report_serial_med_arr[$j] = $report_serial_med[$j];

                        $continue_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;
                        $chronic_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;

                        $duration_comment_arr[$j] = "";
                        $route_arr[$j] = $medicine_route[$j];
                        $strength_arr[$j] = "";
                        $brand_ud_arr[$j] = "";
                        $in_med_serial_dtl[$j] = 0;
                    }
                }
            }
            // dd($medicine_item_id_arr , $medicine_item_arr);
            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;

            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';

            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();
            $prescription = $pdo->prepare("begin pkg_emr.prescription_opd(
                :in_prescription_no_pk,
                :in_patient_no_fk,
                :in_appoint_no_fk,
                :in_doctor_person_no_fk,
                :in_su_no_fk,
                :in_room_no_fk,
                :in_admission_no_fk,
                :in_admission_uid,
                :in_continue_psn_ind,
                :in_continue_psn_no_fk,
                :in_note,
                :in_disposal,
                :in_ref_doctor,
                :in_diagnosis,
                :in_chief_complaints,
                :in_psn_state,
                :in_dental_treatement,
                :in_advice,
                :in_ipd_ind,
                :in_opd_ind,
                :in_hospital_uid,
                :in_is_patient_in,
                :in_is_patient_out,
                :in_followup_num,
                :in_followup_mu,
                :in_next_followup_dt,
                :template_name,
                :in_height_val,
                :in_hight_mu_name,
                :in_weight_val,
                :in_weight_mu_name,
                :in_bmi_val,
                :in_temp_val,
                :in_temp_mu_name,
                :in_temp_time,
                :in_pulse_val ,
                :in_pulse_time,
                :in_bp_val_sys,
                :in_bp_val_dia,
                :in_bp_time,
                :in_heart_rate,
                :in_heart_rate_time,
                :in_ofc,
                :in_prescription_date,
                :in_prescription_text_1,
                :in_prescription_text_2,
                :in_prescription_text_3,
                :in_a_lookupdata_item_no_fk,
                :in_a_lookup_uid,
                :in_a_lookupdata_uid,
                :in_a_entry_serial_dtl,
                :in_a_prescrition_data,
                :in_a_left_right_ind,
                :in_a_prescrition_data_dtl,
                :in_a_prescrition_data_dtlval,
                :in_a_prescrition_phy_frequency,
                :in_a_prescrition_phy_mode,
                :in_a_item_no_fk,
                :in_a_entry_serial,
                :in_a_generic_name,
                :in_a_brand_name,
                :in_a_dosage,
                :in_a_duration,
                :in_a_item_qty,
                :in_a_instruction_take,
                :in_a_medicine_comment,
                :in_a_route,
                :in_a_strength,
                :in_a_continue_ind,
                :in_a_duration_comment,
                :in_a_duration_mu,
                :in_a_chronic_ind,
                :in_session_duration,
                :in_session_mu,
                :in_no_of_session,
                :in_unit_intensity,
                :in_unit_intensity_mu,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :out_prescription_no_pk,
                :out_prescription_uid,
                :out_error); end;");

            $prescription->bindparam(':in_prescription_no_pk', $prescription_id);
            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_appoint_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_doctor_person_no_fk', $doctor_id);
            $prescription->bindparam(':in_su_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_room_no_fk', $in_room_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_uid', $in_admission_code);
            $prescription->bindparam(':in_continue_psn_ind', $zero);
            $prescription->bindparam(':in_continue_psn_no_fk', $zero);
            $prescription->bindparam(':in_note', $rx_note);
            $prescription->bindparam(':in_disposal', $null);
            $prescription->bindparam(':in_ref_doctor', $referred_doctor);
            //$prescription->bindparam(':in_ref_su_no_fk', $in_ref_su_fk_no);
            $prescription->bindparam(':in_diagnosis', $null);
            $prescription->bindparam(':in_chief_complaints', $null);
            $prescription->bindparam(':in_psn_state', $zero);
            $prescription->bindparam(':in_dental_treatement', $treatment_plan);
            $prescription->bindparam(':in_advice', $null);
            $prescription->bindparam(':in_ipd_ind', $in_ipd_ind);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_hospital_uid', $in_hospital_code);
            $prescription->bindparam(':in_is_patient_in', $zero);
            $prescription->bindparam(':in_is_patient_out', $zero);
            $prescription->bindparam(':in_followup_num', $followup_after);
            $prescription->bindparam(':in_followup_mu', $followup_after_mu);
            $prescription->bindparam(':in_next_followup_dt', $next_followup_dt);
            $prescription->bindparam(':template_name', $template_name);

            //--------vitals----------------
            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $null);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $null);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp_sys);
            $prescription->bindparam(':in_bp_val_dia', $txt_bp_dia);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $null);
            $prescription->bindparam(':in_ofc', $txt_ofc); //44
            $prescription->bindparam(':in_prescription_date', $dateTime); //44
            $prescription->bindparam(':in_prescription_text_1', $empty); //44
            $prescription->bindparam(':in_prescription_text_2', $empty); //44
            $prescription->bindparam(':in_prescription_text_3', $empty); //44

            //------- prescription details----
            $prescription->bindArray(':in_a_lookupdata_item_no_fk', $in_item_lookupdata_no_fk, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_lookup_uid', $in_itemtype_lookup_code, (!empty($in_itemtype_lookup_code) ? count($in_itemtype_lookup_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_lookupdata_uid', $in_itemtype_lookupdata_code, (!empty($in_itemtype_lookupdata_code) ? count($in_itemtype_lookupdata_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_entry_serial_dtl', $in_report_serial_dtl, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_prescrition_data', $in_presdtl_data, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_left_right_ind', $in_ocular_position, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtl', $item_dtl_val, (!empty($item_dtl_val) ? count($item_dtl_val) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtlval', $in_report_serial_dtl, (!empty($in_report_serial_dtl) ? count($in_report_serial_dtl) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_phy_frequency', $requency, (!empty($requency) ? count($requency) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_phy_mode', $mode, (!empty($mode) ? count($mode) : 1), $numelems, SQLT_CHR);
            //---- prescription medicine ----
            $prescription->bindArray(':in_a_item_no_fk', $medicine_item_id_arr, (!empty($medicine_item_id_arr) ? count($medicine_item_id_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_entry_serial', $in_med_serial_dtl, (!empty($in_med_serial_dtl) ? count($in_med_serial_dtl) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_generic_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_brand_name', $medicine_item_arr, (!empty($medicine_item_arr) ? count($medicine_item_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_dosage', $medicine_dose_arr, (!empty($medicine_dose_arr) ? count($medicine_dose_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration', $medicine_duration_type_arr, (!empty($medicine_duration_type_arr) ? count($medicine_duration_type_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_item_qty', $medicine_quantity_arr, (!empty($medicine_quantity_arr) ? count($medicine_quantity_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_instruction_take', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_medicine_comment', $instruction_arr, (!empty($instruction_arr) ? count($instruction_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_route', $route_arr, (!empty($route_arr) ? count($route_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_strength', $strength_arr, (!empty($strength_arr) ? count($strength_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_continue_ind', $continue_ind_arr, (!empty($continue_ind_arr) ? count($continue_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_duration_comment', $duration_comment_arr, (!empty($duration_comment_arr) ? count($duration_comment_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_duration_mu', $medicine_duration_mu_arr, (!empty($medicine_duration_mu_arr) ? count($medicine_duration_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_chronic_ind', $chronic_ind_arr, (!empty($chronic_ind_arr) ? count($chronic_ind_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_duration', $session_duration_arr, (!empty($session_duration_arr) ? count($session_duration_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_mu', $session_mu_arr, (!empty($session_mu_arr) ? count($session_mu_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_no_of_session', $no_of_session_arr, (!empty($no_of_session_arr) ? count($no_of_session_arr) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_unit_intensity', $unit_intensity_arr, (!empty($unit_intensity_arr) ? count($unit_intensity_arr) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_unit_intensity_mu', $unit_intensity_mu_arr, (!empty($unit_intensity_mu_arr) ? count($unit_intensity_mu_arr) : 1), $numelems, SQLT_CHR);

            //--- audit and out parameters-------
            // $prescription->bindParam(':in_external_hospital_ind', $hdn_external_ind);
            //$prescription->bindParam(':in_external_hospital_no_fk', $cmb_external_hospital);
            $prescription->bindParam(':in_au_entry_by', $auth_id);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $prescription->bindParam(':out_prescription_no_pk', $out_prescription_no_pk, PDO::PARAM_INT);
            $prescription->bindParam(':out_prescription_uid', $null, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            //dd($prescription);
            $prescription->execute();
            // dd($out_error);
            /* PRESCRIPTION_PHYSIO OTHERS*/
            $physio_data = [];
            $sequence = DB::getSequence();
            $erec_dysfunction_no_pk = $sequence->nextValue('erec_dysfunction_no_pk_seq');
            $physio_data = [
                'erec_dysfunction_no_pk' => $erec_dysfunction_no_pk,
                'prescription_no_fk' => $out_prescription_no_pk,
                'problem_duration' => $request->problem_duration,
                'onset_problem' => $request->onset_problem,
                'related_onset' => $request->onset_sudden,
                'psf_sexually_stimulated' => $request->present_sexual_1,
                'psf_sexual_raltion' => $request->present_sexual_2,
                'psf_penetrate_partner' => $request->present_sexual_3,
                'psf_completion_intercourse' => $request->present_sexual_4,
                'psf_satisfactory_opinion' => $request->present_sexual_5,
                'psf_sexual_desire' => $request->present_sexual_6,
                'psf_during_past_month' => $request->present_sexual_7,
                'psf_achieving_orgasm' => $request->present_sexual_8,
                'psf_sexual_partner' => $request->present_sexual_9,
                'achieve_orgasm' => $request->present_sexual_9_1,
                'ejaculate_normally' => $request->present_sexual_9_2,
                'premature_ejaculation' => $request->present_sexual_9_3,
                'emotional_cause' => $request->present_sexual_9_4,
                'pain_erection' => $request->present_sexual_9_5,
                'abnormaly_bend' => $request->present_sexual_9_6,
                'directions_bend' => $request->present_sexual_9_7,
                'degrees_bend' => $request->present_sexual_9_8,
                'bend_during' => $request->present_sexual_9_9,
                'pev_level_measure' => $request->previous_evaluation_1,
                'pev_testosterone_result' => $request->previous_evaluation_1_1,
                'pev_full_erection_result' => $request->previous_evaluation_2_1,
                'pev_penile_blood_result' => $request->previous_evaluation_3_1,
                'pev_erection_result' => $request->previous_evaluation_4_1,
                'pev_penile_injection' => $request->previous_evaluation_2,
                'pev_blood_flow' => $request->previous_evaluation_3,
                'pev_erections_sleep' => $request->previous_evaluation_4,
                'pt_cialis' => $request->previous_treatment_1,
                'pt_vigra_work' => $request->previous_treatment_1_1,
                'pt_muse' => $request->previous_treatment_2,
                'pt_muse_produce' => $request->previous_treatment_2_1,
                'pt_using_muse' => $request->previous_treatment_2_2,
                'pt_injection_therapy' => $request->previous_treatment_3,
                'pt_injection_produce' => $request->previous_treatment_3_1,
                'pt_doing_injection' => $request->previous_treatment_3_2,
                'pt_vacuum_device' => $request->previous_treatment_4,
                'pt_vacuum_device_work' => $request->previous_treatment_4_1,
                'pt_like_vacuum_device' => $request->previous_treatment_4_2,
                'pt_treatment_ind' => $request->previous_treatment_5,
                'pt_treatments' => $request->previous_treatment_5_1,
                'rsd_injureid_penis' => $request->risk_factor_1,
                'rsd_forcible_bent' => $request->risk_factor_2,
                'rsd_straddle_injury' => $request->risk_factor_3,
                'rsd_bicyle_regularly' => $request->risk_factor_4,
                'rsd_cigarettes_regularly' => $request->risk_factor_5,
                'rsd_currnetly_smoke' => $request->risk_factor_5_1,
                'rsd_alcohol_driking' => $request->risk_factor_6,
                'rsd_spinal_cord' => $request->risk_factor_7,
                'rsd_removed_cancer' => $request->risk_factor_8,
                'rsd_prostate_cancer' => $request->risk_factor_9,
                'rsd_prostatic_growth' => $request->risk_factor_10,
                'rsd_children' => $request->risk_factor_11,
                'pmh_diabetes' => $request->medical_history_1,
                'pmh_control_sugar' => $request->medical_history_1_1,
                'pmh_blood_pressure' => $request->medical_history_2,
                'pmh_blood_cholesterol_level' => $request->medical_history_3,
                'pmh_heart_diseas' => $request->medical_history_4,
                'pmh_stroke' => $request->medical_history_5,
                'pmh_hardening_arteries' => $request->medical_history_6,
                'pmh_drepressions' => $request->medical_history_7,
                'pmh_medical_illness' => $request->medical_history_8,
                'past_surgery' => $request->medical_history_9,
                'list_medications' => $request->medical_history_10,
                'take_aspiring' => $request->medical_history_11,
                'allergic' => $request->medical_history_12,
                'fh_blood_pressure_ind' => $request->family_history_1,
                //'fh_blood_pressure'=> $request->family_history_2,
                'fh_heart_diseae_ind' => $request->family_history_2,
                //'fh_heart_disease'=> $request->family_history_4,
                'fh_peyronie_disease_ind' => $request->family_history_3,
                //'fh_peyronie_disease'=> $request->family_history_6,
                'daibets_ind' => $request->family_history_4,
                //'diabetes'=> $request->,
                'prostate_cancer_ind' => $request->family_history_5,
                // 'prostate_cancer'=> $request->,
                'cancer_ind' => $request->family_history_6,
                // 'cancer'=> $request->,
                'pe_weight' => $request->weight,
                'per_height' => $request->height,
                'race' => $request->race,
                'temp' => $request->temp,
                'pulse' => $request->pulse,
                'resp' => $request->resp,
                'phallus' => $request->phallus,
                'meatus' => $request->meatus,
                'circumcised' => $request->circumcised,
                'plaque' => $request->plaque,
                'sex_characteristics' => $request->sec_sex,
                'dupuytren_contrature' => $request->dupu_contra,
                // 'testes_exam'=> $request->,
                //'rigt_location'=> $request->siao_right,
                'left_location' => $request->siao_left,
                'left_varicocele' => $request->varico_left,
                'left_size' => $request->size_left,
                'left_hydrocele' => $request->hydro_left,
                'left_hernia' => $request->herni_left,
                'right_location' => $request->siao_right,
                'right_size' => $request->size_right,
                'right_hydrocele' => $request->hydro_right,
                'right_varicocele' => $request->varico_right,
                'right_hernia' => $request->herni_right,
                'prostate' => $request->prostate,
                'pulses_id' => $request->pulse_bottom,
                'carotid_bruit' => $request->carotid_bruit,
                'blt_testosterone' => $request->textosterone,
                'blt_tsh' => $request->tsh,
                'blt_prolactin' => $request->prolactin,
                'blt_hba1c' => $request->hba1c,
                'blt_bsh_lh' => $request->fsh,
                'blt_psa' => $request->psa,
                'blt_others' => $request->blood_others,
                'urine_test_exam' => $request->routine_urine,
                'usg_penile_vasculature' => $request->duplex_study,
                'usg_others' => $request->usg_others,
                'x_ray_mri' => $request->xray_mri,
                'mp_dx' => $request->d_dx,
                'mp_treatment' => $request->treat_ment,
                'mp_number_of_sessions' => $request->number_session,
                'advice' => $request->advice,

                'au_entry_at' => date('Y-m-d'),
                'au_entry_by' => $auth_id,
                'au_entry_hospital_pk_no' => $in_au_entry_hospital_pk_no,
                'au_entry_session' => $in_au_entry_session

            ];
            //dd($physio_data);
            $this->erectileModel->insert($physio_data);


            //$id = $request->id;
            // dd($request->all());
            $total_ipss_score = $request->total_ipss_score;
            $urinary_symtom_ind = $request->urinary_symptom_ind;
            $patient_no_fk = $in_patient_no_fk;
            $patient = DB::table('patn_registration')->where('patient_no_pk', $patient_no_fk)->select('dob', 'patient_name')->first(); //->select('')
            $dob = $patient->dob != "" ? date("Y-m-d", strtotime($patient->dob)) : '';
            $patient_name = $patient->patient_name != "" ? $patient->patient_name : '';
            $doc = date('Y-m-d');
            $psn_t_physio_ipss = DB::table("psn_t_physio_ipss")->latest('physio_ipss_no_pk')->select('physio_ipss_visit_no_nuq')->first();
            $visit_number = $psn_t_physio_ipss ? $psn_t_physio_ipss->physio_ipss_visit_no_nuq : null;
            if ($visit_number) {
                $visit_number += 1;
            } else {
                $visit_number = 1;
            }
            //dd($visit_number);
            $ipss = [];
            if (isset($request->row1)) {
                $ipss[] = $request->row1;
            }
            if (isset($request->row2)) {
                $ipss[] = $request->row2;
            }
            if (isset($request->row3)) {
                $ipss[] = $request->row3;
            }
            if (isset($request->row4)) {
                $ipss[] = $request->row4;
            }
            if (isset($request->row5)) {
                $ipss[] = $request->row5;
            }
            if (isset($request->row6)) {
                $ipss[] = $request->row6;
            }
            if (isset($request->row7)) {
                $ipss[] = $request->row7;
            }
            // $ipss [] = $request->row1;
            // $ipss [] = $request->row2;

            // $ipss [] = $request->row3;

            // $ipss [] = $request->row4;

            // $ipss [] = $request->row5;

            // $ipss [] = $request->row6;

            // $ipss [] = $request->row7;
            //dd($ipss);
            // DB::beginTransaction();
            // try {
            if (isset($ipss)) {
                foreach ($ipss as $row) {
                    $explode_row = explode("~", $row);
                    $score = $explode_row[0];
                    $pres_lookupdata_name = $explode_row[1];
                    $pres_lookupdata_no_pk = $explode_row[2];
                    $pres_lookupdata_code = $explode_row[3];
                    $sequence = DB::getSequence();
                    $physio_ipss_no_pk_seq = $sequence->nextValue('physio_ipss_no_pk_seq');
                    $ipss_record = [];
                    //$auth_id = Auth::id();
                    $ipss_record = [
                        'physio_ipss_no_pk' => $physio_ipss_no_pk_seq,
                        'physio_ipss_code' => $pres_lookupdata_code,
                        'lookupdata_no_fk' => $pres_lookupdata_no_pk,
                        'lookupdata_name' => $pres_lookupdata_name,
                        'patient_no_fk' => $patient_no_fk,
                        'patient_name' => $patient_name,
                        'total_ipss_score' => $total_ipss_score,
                        'dob' => $dob,
                        'date_completed' => $doc,
                        'physio_ipss_visit_no_nuq' => $visit_number,
                        // 'not_at_all_score' => 0,
                        // 'less_than_1_to_5_tiems_scr' => ,
                        // 'less_than_half_time_score',
                        // 'about_half_time_score',
                        // 'more_than_half_time_scr',
                        // 'almost_always_score',
                        'urinary_symptoms_ind' => $urinary_symtom_ind,
                        'au_entry_at' => date('Y-m-d'),
                        'au_entry_by' => $auth_id,
                        'prescription_no_fk' => $out_prescription_no_pk,
                        'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        'au_entry_session' => 'hospital',
                    ];
                    if ($score == '0') {
                        $ipss_record['not_at_all_score'] = 0;
                    } elseif ($score == '1') {
                        $ipss_record['less_than_1_to_5_tiems_scr'] = 1;
                    } elseif ($score == '2') {
                        $ipss_record['less_than_half_time_score'] = 2;
                    } elseif ($score == '3') {
                        $ipss_record['about_half_time_score'] = 3;
                    } elseif ($score == '4') {
                        $ipss_record['more_than_half_time_scr'] = 4;
                    } else {
                        if ($score == '5') {
                            $ipss_record['almost_always_score'] = 5;
                        } else {
                            $ipss_record['almost_always_score'] = '';
                        }
                    }
                    // if($id==null)
                    // {
                    // $ipss_record['au_entry_by']= $auth_id;
                    $this->ipssmodel->insert($ipss_record);
                    // }
                    // else
                    // {
                    //     $ipss_record['au_update_by'] = $auth_id;
                    //     DB::table('psn_t_physio_ipss')->where('physio_ipss_visit_no_nuq',$id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->update($ipss_record);
                    // }
                    // $this->ipssmodel->insert($ipss_record);

                }
            }
            /*ipss end*/


            //dd($request->all());
            $total_shim_score = $request->total_shim_score;
            //$urinary_symtom_ind = $request->urinary_symptom_ind;
            $patient_no_fk = $in_patient_no_fk;
            $patient = DB::table('patn_registration')->where('patient_no_pk', $patient_no_fk)->select('dob', 'patient_name')->first(); //->select('')
            $dob = $patient->dob != "" ? date("Y-m-d", strtotime($patient->dob)) : '';
            $patient_name = $patient->patient_name != "" ? $patient->patient_name : '';
            $doc = date('Y-m-d');
            $psn_t_physio_shim = DB::table("psn_t_physio_shim")->latest('physio_shim_no_pk')->select('physio_shim_visit_no_nuq')->first();
            // dd($visit_number);
            $visit_number = $psn_t_physio_shim ? $psn_t_physio_shim->physio_shim_visit_no_nuq : null;
            if ($visit_number) {
                $visit_number += 1;
            } else {
                $visit_number = 1;
            }



            $shim = [];
            if (isset($request->iief_row1)) {
                $shim[] = $request->iief_row1;
            }
            if (isset($request->iief_row2)) {
                $shim[] = $request->iief_row2;
            }
            if (isset($request->iief_row3)) {
                $shim[] = $request->iief_row3;
            }
            if (isset($request->iief_row4)) {
                $shim[] = $request->iief_row4;
            }
            if (isset($request->iief_row5)) {
                $shim[] = $request->iief_row5;
            }

            // DB::beginTransaction();
            //try {
            if (isset($shim)) {
                foreach ($shim as $row) {
                    $explode_row = explode("~", $row);
                    $score = $explode_row[0];
                    $pres_lookupdata_name = $explode_row[1];
                    $pres_lookupdata_no_pk = $explode_row[2];
                    $pres_lookupdata_code = $explode_row[3];
                    $sequence = DB::getSequence();
                    $physio_shim_no_pk_seq = $sequence->nextValue('physio_shim_no_pk_seq');
                    $shim_record = [];
                    // $auth_id = Auth::id();
                    $shim_record = [
                        'physio_shim_no_pk' => $physio_shim_no_pk_seq,
                        'physio_shim_code' => $pres_lookupdata_code,
                        'lookupdata_no_fk' => $pres_lookupdata_no_pk,
                        'lookupdata_name' => $pres_lookupdata_name,
                        'patient_no_fk' => $patient_no_fk,
                        'patient_name' => $patient_name,
                        'total_shim_score' => $total_shim_score,
                        'dob' => $dob,
                        'date_completed' => $doc,
                        'physio_shim_visit_no_nuq' => $visit_number,
                        // 'not_at_all_score' => 0,
                        // 'less_than_1_to_5_tiems_scr' => ,
                        // 'less_than_half_time_score',
                        // 'about_half_time_score',
                        // 'more_than_half_time_scr',
                        // 'almost_always_score',
                        //'urinary_symptoms_ind' => $urinary_symtom_ind,
                        'au_entry_at' => date('Y-m-d'),
                        'au_entry_by' => $auth_id,
                        'prescription_no_fk' => $out_prescription_no_pk,
                        'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                        'au_entry_session' => 'hospital',
                    ];
                    if ($score == '1') {
                        $shim_record['very_low_ind'] = 1;
                    } elseif ($score == '2') {
                        $shim_record['low_ind'] = 2;
                    } elseif ($score == '3') {
                        $shim_record['moderate_ind'] = 3;
                    } elseif ($score == '4') {
                        $shim_record['high_ind'] = 4;
                    } else {
                        if ($score == '5') {
                            $shim_record['very_high_ind'] = 5;
                        } else {
                            $shim_record['very_high_ind'] = '';
                        }
                    }
                    $this->iiefmodel->insert($shim_record);
                }
            }


            /*iief end*/


            $therapy_details = [];
            $sequence = DB::getSequence();
            $patient_therapy_no_pk_seq = $sequence->nextValue('patieent_therapy_no_pk_seq');
            $therapy_details = [
                'patient_therapy_no_pk' => $patient_therapy_no_pk_seq,
                'therapy_day_no' => $request->day_number,
                'therapy_week_no' => $request->week_number,
                'therapy_dosage' => $request->dosage,
                'therapy_date' => $dateTime,
                'patient_no_fk' => $in_patient_no_fk,
                'patient_code' => $in_petient_code,
                'prescription_no_fk' => $out_prescription_no_pk,
                'therapy_treated_by' => $doctor_id,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_by' => $auth_id,
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            $this->therapy_details->insert($therapy_details);
            // dd($therapy_details);



            // physio others end

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
            } else {
                if ($request->hdn_eye_ind == 1) {
                    // delete previous spectacles and insert again
                    PrescriptionEye::where('prescription_no_fk', $out_prescription_no_pk)->delete();

                    $prescriptionEye = new PrescriptionEye();
                    $prescriptionEye->prescription_no_fk = $out_prescription_no_pk;
                    $prescriptionEye->axis_left_dv = $txt_r_dv_axis;
                    $prescriptionEye->axis_right_dv = $txt_r_dv_axis;
                    $prescriptionEye->cyl_left_dv = $txt_l_dv_cyl;
                    $prescriptionEye->cyl_right_dv = $txt_r_dv_cyl;
                    $prescriptionEye->sph_left_dv = $txt_l_dv_sph;
                    $prescriptionEye->sph_right_dv = $txt_r_dv_sph;
                    $prescriptionEye->va_left_dv = $txt_l_dv_va;
                    $prescriptionEye->va_right_dv = $txt_r_dv_va;
                    $prescriptionEye->axis_left_nv = $txt_l_nv_axis;
                    $prescriptionEye->axis_right_nv = $txt_r_nv_axis;
                    $prescriptionEye->cyl_left_nv = $txt_l_nv_cyl;
                    $prescriptionEye->cyl_right_nv = $txt_r_nv_cyl;
                    $prescriptionEye->sph_left_nv = $txt_l_nv_sph;
                    $prescriptionEye->sph_right_nv = $txt_r_nv_sph;
                    $prescriptionEye->va_left_nv = $txt_l_nv_va;
                    $prescriptionEye->va_right_nv = $txt_r_nv_va;
                    $prescriptionEye->add_left = $txt_l_add;
                    $prescriptionEye->add_right = $txt_r_add;
                    $prescriptionEye->i_p_d = $txt_ipd;
                    $prescriptionEye->remarks_txt = $txt_spec_remarks;
                    $prescriptionEye->glass_type = $txt_glass;
                    $prescriptionEye->usage_type = $txt_usage_type;
                    $prescriptionEye->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $prescriptionEye->save();
                }

                DB::commit();
                $message = ['msg' => 'New Prescription created successfully', 'title' => 'Success'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function opdNurseStationVitalsCreateOrUpdate($request, $id = null)
    {


        $auth_id = Auth::id();
        $user_info = Auth::user();
        $doctor_id = Session::get("user.ses_person_no_fk");
        DB::beginTransaction();

        try {
            $ch_com = [
                'chif_complain' => null,
            ];
            DB::table('patn_appointment')->where('appoint_no_pk', $request->hdn_appointment_id)->update($ch_com);

            $prescription_id = $request->hdn_prescription_id;
            $in_appointment_no_fk = ($request->hdn_appointment_id != "") ? $request->hdn_appointment_id : $this->quickAppointment($request->hdn_patient_id, $request->hdn_doctor_id, $request->hdn_room_no);
            $in_doctor_person_no_fk = $request->hdn_doctor_id;
            $in_hospital_code = 'HC';
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;
            $in_service_unit_no_fk = $request->hdn_su_no;
            $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = $request->hdn_room_no;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp_sys = $request->txt_bp_sys;
            $txt_bp_dia = $request->txt_bp_dia;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $txt_ofc = $request->txt_ofc;
            $txt_lung = $request->txt_lung;
            $txt_bowel = $request->txt_bowel;
            $txt_bladder = $request->txt_bladder;

            $next_followup = new Carbon($request->next_followup);
            $next_followup_dt = ($request->next_followup != "") ? date("Y-m-d", strtotime($next_followup->toDateString())) : null;
            $followup_after = trim($request->followup_after);
            $followup_after_mu = $request->followup_after_mu;
            $referred_doctor = '';
            /* $referred_doctor        = trim($request->txt_referred_doctor); */
            $rx_note = trim($request->txt_rx_note);
            $template_name = trim($request->template_name);
            $treatment_plan = trim($request->txt_treatment_plan);

            $txt_r_dv_sph = $request->txt_r_dv_sph;
            $txt_r_dv_cyl = $request->txt_r_dv_cyl;
            $txt_r_dv_axis = $request->txt_r_dv_axis;
            $txt_r_dv_va = $request->txt_r_dv_va;
            $txt_r_nv_sph = $request->txt_r_nv_sph;
            $txt_r_nv_cyl = $request->txt_r_nv_cyl;
            $txt_r_nv_axis = $request->txt_r_nv_axis;
            $txt_r_nv_va = $request->txt_r_nv_va;

            $txt_l_dv_sph = $request->txt_l_dv_sph;
            $txt_l_dv_cyl = $request->txt_l_dv_cyl;
            $txt_l_dv_axis = $request->txt_l_dv_axis;
            $txt_l_dv_va = $request->txt_l_dv_va;
            $txt_l_nv_sph = $request->txt_l_nv_sph;
            $txt_l_nv_cyl = $request->txt_l_nv_cyl;
            $txt_l_nv_axis = $request->txt_l_nv_axis;
            $txt_l_nv_va = $request->txt_l_nv_va;

            $txt_r_add = $request->txt_r_add;
            $txt_l_add = $request->txt_l_add;
            $txt_ipd = $request->txt_ipd;
            $txt_spec_remarks = $request->txt_spec_remarks;
            $txt_glass = $request->txt_glass;
            $txt_usage_type = $request->txt_usage_type;
            $txt_bmi = $request->txt_bmi;
            $txt_rr_value = $request->txt_rr_value;
            $txt_heart_rate = $request->txt_heart_rate;
            $heart_rate_time = date('Y/m/d H:i:s', strtotime(date("d-m-Y H:i:s")));
            $item_id = $request->item_id;
            $item_name = $request->item_name;
            $lookup_id = $request->lookup_id;

            $oxygen = isset($request->oxygen) ? $request->oxygen : '';
            $respiration = isset($request->respiration) ? $request->respiration : '';
            $txt_spo2_value = isset($request->txt_spo2_value) ? $request->txt_spo2_value : '';
            $lmp = date("Y-m-d", strtotime($request->lmp));
            $obs = $request->obs;

            $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_code = $in_ocular_position = $item_dtl_val = [];
            // dd($request->item_dtl_val);
            if (!empty($lookup_id)) {
                for ($i = 0; $i < sizeof($lookup_id); $i++) {
                    if ($item_name[$i] != "") {

                        $item_dtl_val[$i] = $request->item_dtl_val[$i];

                        $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                        $in_report_serial_dtl[$i] = 0;
                        $in_presdtl_data[$i] = $item_name[$i];

                        $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                        $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';

                        $in_ocular_position[$i] = isset($request->ocular_position[$i]) ? $request->ocular_position[$i] : '';
                    }
                }
            }
            // dd([$in_item_lookupdata_no_fk, $in_presdtl_data, $item_dtl_val, $in_itemtype_lookup_code,  $in_itemtype_lookupdata_code,$in_ocular_position]);
            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = isset($request->is_continue) ? array_flip($request->is_continue) : $request->is_continue;
            $is_chronic = isset($request->is_chronic) ? array_flip($request->is_chronic) : $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;

            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $chronic_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = $in_med_serial_dtl = [];

            if (!empty($medicine_item)) {
                for ($j = 1; $j < sizeof($medicine_item); $j++) {
                    if ($medicine_item[$j] != "") {

                        $medicine_item_id_arr[$j] = $medicine_item_id[$j];
                        $medicine_item_arr[$j] = $medicine_item[$j];
                        $medicine_dose_arr[$j] = $medicine_dose[$j];
                        $medicine_duration_type_arr[$j] = $medicine_duration_type[$j];
                        $medicine_duration_mu_arr[$j] = $medicine_duration_mu[$j];
                        $medicine_quantity_arr[$j] = $medicine_quantity[$j];
                        $instruction_arr[$j] = $instruction[$j];
                        $report_serial_med_arr[$j] = $report_serial_med[$j];

                        $continue_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;
                        $chronic_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;

                        $duration_comment_arr[$j] = "";
                        $route_arr[$j] = $medicine_route[$j];
                        $strength_arr[$j] = "";
                        $brand_ud_arr[$j] = "";
                        $in_med_serial_dtl[$j] = 0;
                    }
                }
            }
            //die;
            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');

            $hdn_external_ind = $request->hdn_external_ind;
            $cmb_external_hospital = $request->cmb_external_hospital;

            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';

            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();
            $prescription = $pdo->prepare("begin pkg_emr.opd_vitals(
            :in_patient_no_fk,
            :in_appoint_no_fk,
            :in_prescription_no_pk,
            :in_doctor_person_no_fk,
            :in_su_no_fk,
            :in_room_no_fk,
            :in_admission_no_fk,
            :in_admission_uid,
            :in_ipd_ind,
            :in_opd_ind,
            :in_hospital_uid,
            :in_is_patient_in,
            :in_is_patient_out,
            :in_height_val,
            :in_hight_mu_name,
            :in_weight_val,
            :in_weight_mu_name,
            :in_bmi_val,
            :in_temp_val,
            :in_temp_mu_name,
            :in_temp_time,
            :in_pulse_val,
            :in_pulse_time,
            :in_bp_val_sys,
            :in_bp_val_dia,
            :in_bp_time,
            :in_heart_rate,
            :in_heart_rate_time,
            :in_ofc,
            :in_spo2_value,
            :in_rr_value,
            :in_heart_condition,
            :in_lung_condition,
            :in_bowel_condition,
            :in_bladder_condition,
            :in_lmp,
            :in_obs,
            :in_oxygen,
            :in_respiration,
            :in_a_lookupdata_item_no_fk,
            :in_a_lookup_uid,
            :in_a_lookupdata_uid,
            :in_a_entry_serial_dtl,
            :in_a_prescrition_data,
            :in_a_left_right_ind,
            :in_a_prescrition_data_dtl,
            :in_a_prescrition_data_dtlval,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :out_error);
            end;");


            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_appoint_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_prescription_no_pk', $prescription_id);
            $prescription->bindparam(':in_doctor_person_no_fk', $doctor_id);
            $prescription->bindparam(':in_su_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_room_no_fk', $in_room_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_uid', $in_admission_code);
            $prescription->bindparam(':in_ipd_ind', $in_ipd_ind);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_hospital_uid', $in_hospital_code);
            $prescription->bindparam(':in_is_patient_in', $zero);
            $prescription->bindparam(':in_is_patient_out', $zero);

            //--------vitals----------------
            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $null);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $null);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp_sys);
            $prescription->bindparam(':in_bp_val_dia', $txt_bp_dia);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $heart_rate_time);
            $prescription->bindparam(':in_ofc', $txt_ofc); //44
            $prescription->bindparam(':in_spo2_value', $txt_spo2_value);
            $prescription->bindparam(':in_rr_value', $txt_rr_value);
            $prescription->bindparam(':in_heart_condition', $txt_heart_rate);
            $prescription->bindparam(':in_lung_condition', $txt_lung);
            $prescription->bindparam(':in_bowel_condition', $txt_bowel);
            $prescription->bindparam(':in_bladder_condition', $txt_bladder);
            $prescription->bindparam(':in_lmp', $lmp);
            $prescription->bindparam(':in_obs', $obs);
            $prescription->bindparam(':in_oxygen', $oxygen);
            $prescription->bindparam(':in_respiration', $respiration);

            //------- prescription details----
            $prescription->bindArray(':in_a_lookupdata_item_no_fk', $in_item_lookupdata_no_fk, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_lookup_uid', $in_itemtype_lookup_code, (!empty($in_itemtype_lookup_code) ? count($in_itemtype_lookup_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_lookupdata_uid', $in_itemtype_lookupdata_code, (!empty($in_itemtype_lookupdata_code) ? count($in_itemtype_lookupdata_code) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_entry_serial_dtl', $in_report_serial_dtl, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_INT);
            $prescription->bindArray(':in_a_prescrition_data', $in_presdtl_data, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_left_right_ind', $in_ocular_position, (!empty($in_item_lookupdata_no_fk) ? count($in_item_lookupdata_no_fk) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtl', $item_dtl_val, (!empty($item_dtl_val) ? count($item_dtl_val) : 1), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_a_prescrition_data_dtlval', $in_report_serial_dtl, (!empty($in_report_serial_dtl) ? count($in_report_serial_dtl) : 1), $numelems, SQLT_CHR);

            //---- prescription medicine ----


            //--- audit and out parameters-------

            $prescription->bindParam(':in_au_entry_by', $auth_id);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd( $prescription);
            $prescription->execute();
            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
            } else {

                DB::commit();
                $message = ['msg' => 'New Vitals created successfully', 'title' => 'Success', 'insert_id' => $in_appointment_no_fk];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function createOrUpdatePatientAppointmentEr($request, $id = null)
    {
        //dd($request->all());
        $agent_id = 0;
        if ($request->inform == 'Marketing Agent') {
            $agent_id = $request->agent_id_hdn;
        } elseif ($request->inform == 'Staff') {
            $agent_id = $request->hdn_staff__id;
        }

        // dd($request->inform,$agent_id);
        $empty_str = "";
        $auth_id = Auth::id();
        $doctor_no_fk = $request->doctor_name;

        DB::beginTransaction();

        // try {
        $appointment_dt = new Carbon($request->hdn_appointment_date);
        $app_date = date("Y-M-d", strtotime($appointment_dt->toDateString()));

        $patient_dob = new Carbon($request->patient_dob);
        $pat_dob = date("Y-M-d", strtotime($patient_dob->toDateString()));

        $marital_status_arr = $this->getLookupListByCode("MARSTS");
        $gender_arr = $this->getLookupListByCode("GENDER");

        $pdo = DB::getPdo();
        $doctor_id = $request->hdn_doctor_id;
        $hdn_schedule_id = $request->hdn_schedule_id;
        $slot_no_pk = $request->slot_no_pk;
        // dd( $slot_no_pk);
        $appointment_type = $request->visit_type;
        $patient_id = $request->hdn_patient_id;
        $patient_code = $request->patient_code;
        $patient_salutation = $request->patient_salutation;
        $patient_first_name = $request->patient_first_name;
        $patient_last_name = $request->patient_last_name;
        $phone_no = $request->phone_no;
        $patient_gender = $request->patient_gender;
        $gender_txt = isset($gender_arr[$request->patient_gender]) ? $gender_arr[$request->patient_gender] : '';
        $marital_status = $request->patient_marital_status;
        $marital_status_txt = isset($marital_status[$request->patient_marital_status]) ? $marital_status[$request->patient_marital_status] : '';

        $blood_group = $request->patient_blood_group;
        $patient_email = $request->patient_email;
        $patient_age_dd = $request->patient_age_dd ? sprintf("%02d", $request->patient_age_dd) : "";
        $patient_age_mm = $request->patient_age_mm ? sprintf("%02d", $request->patient_age_mm) : "";
        $patient_age_yy = $request->patient_age_yy ? sprintf("%02d", $request->patient_age_yy) : "";
        $y = $patient_age_yy ? $patient_age_yy . " " . "Y " : "";
        $m = $patient_age_mm ? "," . $patient_age_mm . " " . "M " : "";
        $d = $patient_age_dd ? "," . $patient_age_dd . " " . "D" : "";
        $age = $y . " " . $m . " " . $d;

        // $patient_type = $request->patient_type;
        $patient_type = $request->patienttype;
        $priority = $request->appointment_priority;
        $hdn_first_refer = isset($request->hdn_first_refer) ? $request->hdn_first_refer : "";
        $hdn_second_refer = isset($request->hdn_second_refer) ? $request->hdn_second_refer : "";

        $priority = $request->appointment_priority;
        $address = $request->address;
        $inform = isset($request->inform) ? $request->inform : '';
        $in_cor_member_no_pk = isset($request->corporate_id) ? $request->corporate_id : '';

        $item_name = $request->item_name;
        $in_chief_comp_name = "";
        if (isset($item_name)) {
            for ($i = 0; $i < sizeof($item_name); $i++) {
                if ($item_name[$i] != "") {
                    $in_chief_comp_name .= $item_name[$i] . ",";
                }
            }
            $chif_complain = rtrim($in_chief_comp_name, ", ");
        } else {
            $chif_complain = null;
        }

        $service_unit = $request->hdn_service_unit;
        $appoint_source = 'WEB';
        $entry_session = 'session';
        $hospital_id = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
        $is_pay_consultation = $request->is_pay_consultation;
        $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
        $patient_note = $request->patient_note;
        $app_start_time = $request->start_time;
        $app_end_time = $request->end_time;
        $in_start_time = isset($app_start_time) ? date("Y-m-d H:i", strtotime($app_date . " " . $app_start_time)) : null;
        $in_end_time = isset($app_end_time) ? date("Y-m-d H:i", strtotime($app_date . " " . $app_end_time)) : null;
        $in_manual_time_ind = (isset($in_start_time) || isset($in_end_time)) ? 1 : 0;


        // $start_time = $request->start_time;
        //$end_time = $request->end_time;
        // OUT PAREMETER INITIALIZE
        $in_religion =  isset($request->patient_religion) ? $request->patient_religion : '';
        $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
        $corporate_name = '';
        if ($corporate_id != "") {
            $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
        }

        $out_sl_no = $out_appoint_no = $out_appoint_id = $out_start_time = $out_end_time = $out_patient_no_pk  = $out_error = "";

        $stmt = $pdo->prepare("begin pkg_patmanagement.prc_appointment(:in_appoint_date,:in_doctor_no_fk,:in_schedule_no_fk,:in_slot_no_pk,:in_manual_time_ind,:in_start_time,:in_end_time,:in_appoint_type,:in_patient_no_fk,:in_salutation,:in_patient_fname,:in_patient_lname,:in_phone_mobile,:in_email,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt,:in_address,:in_address1,:in_address2,:in_blood_group,:in_religion,:in_chif_complain,:in_patient_type_no_fk,:in_su_no_fk,:in_priority_no_fk,:in_appoint_source,:in_first_referral,:in_second_referral,:in_is_manual_sl,:in_appoint_note,:in_ccm_client_no_fk,:in_ccm_client_name,:in_cor_member_no_pk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_sl_no,:out_appoint_no,:out_appoint_id,:out_patient_no_pk,:out_start_time,:out_end_time,:out_error); end;"); //,:in_is_manual_sl

        $stmt->bindParam(':in_appoint_date', $app_date);
        $stmt->bindParam(':in_doctor_no_fk', $doctor_id);
        $stmt->bindParam(':in_schedule_no_fk', $hdn_schedule_id);
        $stmt->bindParam(':in_slot_no_pk', $slot_no_pk);
        $stmt->bindParam(':in_manual_time_ind', $in_manual_time_ind);
        $stmt->bindParam(':in_start_time', $in_start_time);
        $stmt->bindParam(':in_end_time', $in_end_time);
        $stmt->bindParam(':in_appoint_type', $appointment_type);
        $stmt->bindParam(':in_patient_no_fk', $patient_id);
        $stmt->bindParam(':in_salutation', $patient_salutation);
        $stmt->bindParam(':in_patient_fname', $patient_first_name);
        $stmt->bindParam(':in_patient_lname', $patient_last_name);
        $stmt->bindParam(':in_phone_mobile', $phone_no);
        $stmt->bindParam(':in_email', $patient_email);
        $stmt->bindParam(':in_dob', $pat_dob);
        $stmt->bindParam(':in_age_dd', $patient_age_dd);
        $stmt->bindParam(':in_age_mm', $patient_age_mm);
        $stmt->bindParam(':in_age_yy', $patient_age_yy);
        $stmt->bindParam(':in_age', $age);
        $stmt->bindParam(':in_gender', $patient_gender);
        $stmt->bindParam(':in_gender_txt', $gender_txt);
        $stmt->bindParam(':in_marital_status', $marital_status);
        $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
        $stmt->bindParam(':in_address', $address);
        $stmt->bindParam(':in_address1', $empty_str);
        $stmt->bindParam(':in_address2', $empty_str);
        $stmt->bindParam(':in_blood_group', $blood_group);
        $stmt->bindParam(':in_religion', $in_religion);
        $stmt->bindParam(':in_chif_complain', $chif_complain);
        $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
        $stmt->bindParam(':in_su_no_fk', $service_unit);
        $stmt->bindParam(':in_priority_no_fk', $priority);
        $stmt->bindParam(':in_appoint_source', $appoint_source);
        $stmt->bindParam(':in_first_referral', $hdn_first_refer);
        $stmt->bindParam(':in_second_referral', $hdn_second_refer);
        $stmt->bindParam(':in_is_manual_sl', $is_manual_sl);
        $stmt->bindParam(':in_appoint_note', $patient_note);
        $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
        $stmt->bindParam(':in_ccm_client_name', $corporate_name);
        $stmt->bindParam(':in_cor_member_no_pk', $in_cor_member_no_pk);
        $stmt->bindParam(':in_au_entry_by', $auth_id);
        $stmt->bindParam(':in_au_entry_session', $entry_session);
        $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $stmt->bindParam(':out_sl_no', $out_sl_no, PDO::PARAM_INT);
        $stmt->bindParam(':out_appoint_no', $out_appoint_no, PDO::PARAM_INT);
        $stmt->bindParam(':out_appoint_id', $out_appoint_id, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
        $stmt->bindParam(':out_start_time', $out_start_time, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_end_time', $out_end_time, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($stmt);
        $stmt->execute();




        if ($out_error == "000") {
            DB::table('patn_appointment')
                ->where('appoint_no_pk', $out_appoint_no)
                ->update([
                    'online_ind' => $request->input('patient_type')
                ]);
            if ($request->slot_no_pk != '') {
                $slot_no_pk = $request->slot_no_pk;
                $slot_info = [
                    'available_ind' => 0,
                    'appoint_no_fk' => $out_appoint_no
                ];
                DB::table('hrms_schedule_slot')->where('slot_no_pk', $slot_no_pk)->update($slot_info);
            }
            $app_info = DB::table("patn_appointment_vw")
                ->where("appoint_no_pk", $out_appoint_no)
                ->first();

            $patient_id = $app_info->patient_no_pk;

            // update patient info Start
            if (Session::get('user.ses_hospital_code') == 'IMPALA' && $request->patient_type == '1') {
                $address_data = [
                    'patient_area_no_fk' => $request->hdn_area_code,
                    'patient_area_name' => $request->hdn_area_name,
                    'agent_no_fk' => $agent_id
                ];
            } else {
                $address_data = [
                    'present_addr' => $request->patient_address,
                    'patient_area_no_fk' => $request->hdn_area_code,
                    'patient_area_name' => $request->hdn_area_name,
                    'agent_no_fk' => $agent_id,
                    'inform_text' => $inform
                ];
            }

            DB::table('patn_registration')->where('patient_no_pk', $patient_id)->update($address_data);

            // End
            $patient_code = $app_info->patient_code;
            $app_code = $app_info->appoint_code;

            $appointment_date = date("l, d/m/Y", strtotime($out_start_time));
            $prescription_route = ""; //route('prescription-print');
            $msg = "<table class='table table-borderless'>
				<thead>
				<tr>
				<th scope='col' colspan='2'>New Appointment ( $app_info->appoint_code ) created.</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<th scope='row' class='text-right'>Doctor Name : </th>
				<td scope='row' class='text-left'>$app_info->full_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Patient Name : </th>
				<td scope='row' class='text-left'>$app_info->patient_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Chief Complain : </th>
				<td scope='row' class='text-left'>$app_info->chif_complain</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Appointment Date : </th>
				<td scope='row' class='text-left'>" . date("d-m-Y", strtotime($app_info->appoint_date)) . "</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Serial No : </th>
				<td scope='row' class='text-left text-danger'>$app_info->slot_sl</td>
				</tr>
				<tr>
				<th scope='col' colspan='2' class='text-center'>
				<br />
                <a href='" . route('patient-appointment-print', $out_appoint_no) . "' class='btn btn-md btn-success noprint '
                           target='_blank' data-id='{{ $out_appoint_no }}' id='apointment_card'
                           title=' Print Appointment Card'>App. Print </a>

				<a href='" . route('home') . "' class='btn btn-danger btn-md' rel='tab' title='Click here to go back to Dashboard'>Exit</a>
				</th>
				</tr>
				</tbody>
				</table>";
            // <button data-dismiss='modal' class='btn btn-md btn-success open-modal cursor-pointer mb-2' data-id='" . $out_appoint_no . "' data-action='" . route('appointment-card-pat', $out_appoint_no) . "' data-title='Appointment card' title='Appointment card' data-modal='common-modal-sm'>App. card</button>
            // <a class='btn btn-primary btn-md' href='" . route('appointments.list-view') . "' rel='tab' data-dismiss='modal' >Appointment List</a>

            $doctor_name = ($app_info->full_name_bangla == "") ? $app_info->full_name :   $app_info->full_name_bangla;
            $doctor_name_english = $app_info->full_name;
            // dd($doctor_name_english);
            $update_ind = 0;

            //    if (Session::get('user.sms_send_ind')==1) {
            //     $sms = $this->sendSms($app_info->appoint_date,$app_info->start_time,$app_info->end_time, $app_info->mobile1, $doctor_name,$doctor_name_english, $app_info->slot_sl, $app_info->specialization_bangla, $app_info->phone_mobile, $app_info->au_entry_at,$update_ind);
            //    }

            DB::commit();
            $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
        } else {
            DB::rollback();
            $message = ["msg" => "Appointment Create Failed $out_error $is_manual_sl", 'title' => 'Error', 'out_sl_no' => ''];
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }
    public function physioPresCreateOrUpdate($request, $id = null)
    {
        $auth_id = Auth::id();
        $user_info = Auth::user();

        DB::beginTransaction();

        try {
            $in_appointment_no_fk = $request->hdn_appointment_id;
            $in_doctor_person_no_fk = 62;
            $in_hospital_code = 'HC';
            $in_patient_no_fk = $request->hdn_patient_id;
            $in_petient_code = $request->hdn_patient_code;
            $in_service_unit_no_fk = 0;
            $in_admission_no_fk = 0;
            $in_admission_code = '';
            $in_opd_ind = 1;
            $in_ipd_ind = 0;
            $in_room_no_fk = 0;
            $in_bed_no_fk = 0;
            $in_ward_fk_no = 0;
            $in_note_text = '';
            $in_ref_doctor_fk_no = 0;
            $in_ref_su_fk_no = 0;
            $in_prescription_state = 'NEW';

            $txt_pulse = $request->txt_pulse;
            $txt_bp = $request->txt_bp;
            $txt_temperature = $request->txt_temperature;
            $txt_height = $request->txt_height;
            $txt_weight = $request->txt_weight;
            $txt_ofc = $request->txt_ofc;
            $txt_bmi = $request->txt_bmi;

            $next_followup = new Carbon($request->txt_next_followup);
            $next_followup_dt = date("Y-m-d", strtotime($next_followup->toDateString()));
            $referred_doctor = $request->txt_referred_doctor;
            $rx_note = $request->txt_rx_note;

            $item_id = $request->item_id;

            $in_item_lookupdata_no_fk = $in_report_serial_dtl = $in_presdtl_data = $in_itemtype_lookupdata_code = $in_itemtype_lookup_no_fk = $in_itemtype_lookup_code = $in_session_duration = $in_session_mu = $in_no_of_session = $in_unit_intensity = $in_unit_intensity_mu = $serial_dtl_arr = $in_pysio_instruction = $in_note_text_dtl = [];
            //$i=0;
            for ($i = 0; $i < sizeof($item_id); $i++) {
                if ($item_id[$i] != "") {
                    $in_item_lookupdata_no_fk[$i] = $item_id[$i];
                    $in_report_serial_dtl[$i] = 0;
                    $in_presdtl_data[$i] = $request->item_name[$i];
                    $in_itemtype_lookupdata_code[$i] = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                    $in_itemtype_lookup_no_fk[$i] = isset($request->lookup_id[$i]) ? $request->lookup_id[$i] : 0;
                    $in_itemtype_lookup_code[$i] = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                    $in_session_duration[$i] = isset($request->session_duration[$i]) ? $request->session_duration[$i] : 0;
                    $in_session_mu[$i] = isset($request->session_mu[$i]) ? $request->session_mu[$i] : '';
                    $in_no_of_session[$i] = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : '';
                    $in_unit_intensity[$i] = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : '';
                    $in_unit_intensity_mu[$i] = isset($request->unit_intensity_mu[$i]) ? $request->unit_intensity_mu[$i] : '';
                    $in_pysio_instruction[$i] = 0;
                    $in_note_text_dtl[$i] = 0;
                }
            }

            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = $request->is_continue;
            $report_serial_med = $request->hdn_report_serial_med;

            $medicine_item_id_arr = $medicine_item_arr = $medicine_dose_arr = $medicine_duration_type_arr = $medicine_duration_mu_arr = $medicine_quantity_arr = $instruction_arr = $report_serial_med_arr = $continue_ind_arr = $duration_comment_arr = $route_arr = $strength_arr = $brand_ud_arr = [];

            for ($j = 0; $j < sizeof($medicine_item_id); $j++) {
                if ($medicine_item_id[$j] != "") {
                    $medicine_item_id_arr[$j] = $medicine_item_id[$j];
                    $medicine_item_arr[$j] = $medicine_item[$j];
                    $medicine_dose_arr[$j] = $medicine_dose[$j];
                    $medicine_duration_type_arr[$j] = $medicine_duration_type[$j];
                    $medicine_duration_mu_arr[$j] = $medicine_duration_mu[$j];
                    $medicine_quantity_arr[$j] = $medicine_quantity[$j];
                    $instruction_arr[$j] = $instruction[$j];
                    $report_serial_med_arr[$j] = $report_serial_med[$j];

                    $continue_ind_arr[$j] = isset($is_continue[$j]) ? 1 : 0;
                    $duration_comment_arr[$j] = "";
                    $route_arr[$j] = "";
                    $strength_arr[$j] = "";
                    $brand_ud_arr[$j] = "";
                }
            }

            $in_au_entry_by = $auth_id;
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = 1;

            $empty_arr = [];
            $numelems = 500;
            $zero = 0;
            $null = '';

            // OUT PAREMETER INITIALIZE
            $out_prescription_no_pk = $out_prescription_code = $out_error = "";

            $pdo = DB::getPdo();
            $prescription = $pdo->prepare("begin pkg_emr.prescription_physio(:in_appointment_no_fk,:in_doctor_person_no_fk,:in_hospital_code,:in_patient_no_fk,:in_petient_code,:in_service_unit_no_fk,:in_admission_no_fk,:in_admission_code,:in_opd_ind,:in_ipd_ind,:in_room_no_fk,:in_bed_no_fk,:in_ward_fk_no,:in_note_text,:in_ref_doctor_fk_no,:in_ref_su_fk_no,:in_prescription_state,:in_height_val,:in_hight_mu_name,:in_weight_val,:in_weight_mu_name,:in_bmi_val,:in_temp_val,:in_temp_mu_name,:in_temp_time,:in_pulse_val,:in_pulse_time,:in_bp_val_sys,:in_bp_val_dia,:in_bp_time,:in_heart_rate,:in_heart_rate_time,:in_ofc,:in_item_lookupdata_no_fk,:in_report_serial_dtl,:in_presdtl_data,:in_itemtype_lookupdata_code,:in_itemtype_lookup_no_fk,:in_itemtype_lookup_code,:in_session_duration,:in_session_mu,:in_no_of_session,:in_unit_intensity,:in_unit_intensity_mu,:in_pysio_instruction,:in_note_text_dtl, :in_item_no_fk,:in_brand_name,:in_brand_name_ud,:in_generic_name,:in_dosage,:in_duration,:in_duration_mu,:in_duration_comment,:in_route,:in_strength,:in_report_serial_med,:in_item_qty,:in_relation_with_meal,:in_continue_ind,:in_medicine_comment,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_prescription_no_pk,:out_prescription_code,:out_error); end;"); //:in_next_followup_dt,:in_refered_doc,:in_presc_note,

            $prescription->bindparam(':in_appointment_no_fk', $in_appointment_no_fk);
            $prescription->bindparam(':in_doctor_person_no_fk', $in_doctor_person_no_fk);
            $prescription->bindparam(':in_hospital_code', $in_hospital_code);
            $prescription->bindparam(':in_patient_no_fk', $in_patient_no_fk);
            $prescription->bindparam(':in_petient_code', $in_petient_code);
            $prescription->bindparam(':in_service_unit_no_fk', $in_service_unit_no_fk);
            $prescription->bindparam(':in_admission_no_fk', $in_admission_no_fk);
            $prescription->bindparam(':in_admission_code', $in_admission_code);
            $prescription->bindparam(':in_opd_ind', $in_opd_ind);
            $prescription->bindparam(':in_ipd_ind', $zero);
            $prescription->bindparam(':in_room_no_fk', $zero);
            $prescription->bindparam(':in_bed_no_fk', $zero);
            $prescription->bindparam(':in_ward_fk_no', $zero);
            $prescription->bindparam(':in_note_text', $null);
            $prescription->bindparam(':in_ref_doctor_fk_no', $zero);
            $prescription->bindparam(':in_ref_su_fk_no', $zero);
            $prescription->bindparam(':in_prescription_state', $in_prescription_state);

            // $prescription->bindparam(':in_next_followup_dt', $next_followup_dt);
            // $prescription->bindparam(':in_refered_doc', $referred_doctor);
            // $prescription->bindparam(':in_presc_note', $rx_note);

            $prescription->bindparam(':in_height_val', $txt_height);
            $prescription->bindparam(':in_hight_mu_name', $null);
            $prescription->bindparam(':in_weight_val', $txt_weight);
            $prescription->bindparam(':in_weight_mu_name', $null);
            $prescription->bindparam(':in_bmi_val', $txt_bmi);
            $prescription->bindparam(':in_temp_val', $txt_temperature);
            $prescription->bindparam(':in_temp_mu_name', $null);
            $prescription->bindparam(':in_temp_time', $null);
            $prescription->bindparam(':in_pulse_val', $txt_pulse);
            $prescription->bindparam(':in_pulse_time', $null);
            $prescription->bindparam(':in_bp_val_sys', $txt_bp);
            $prescription->bindparam(':in_bp_val_dia', $zero);
            $prescription->bindparam(':in_bp_time', $null);
            $prescription->bindparam(':in_heart_rate', $zero);
            $prescription->bindparam(':in_heart_rate_time', $null);
            $prescription->bindparam(':in_ofc', $txt_ofc);

            $prescription->bindArray(':in_item_lookupdata_no_fk', $in_item_lookupdata_no_fk, count($in_item_lookupdata_no_fk), $numelems, SQLT_INT);
            $prescription->bindArray(':in_report_serial_dtl', $in_report_serial_dtl, count($in_report_serial_dtl), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_presdtl_data', $in_presdtl_data, count($in_presdtl_data), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_itemtype_lookupdata_code', $in_itemtype_lookupdata_code, count($in_itemtype_lookupdata_code), $numelems, SQLT_CHR);

            $prescription->bindArray(':in_itemtype_lookup_no_fk', $in_itemtype_lookup_no_fk, count($in_itemtype_lookup_no_fk), $numelems, SQLT_INT);
            $prescription->bindArray(':in_itemtype_lookup_code', $in_itemtype_lookup_code, count($in_itemtype_lookup_code), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_session_duration', $in_session_duration, count($in_session_duration), $numelems, SQLT_INT);
            $prescription->bindArray(':in_session_mu', $in_session_mu, count($in_session_mu), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_no_of_session', $in_no_of_session, count($in_no_of_session), $numelems, SQLT_INT);
            $prescription->bindArray(':in_unit_intensity', $in_unit_intensity, count($in_unit_intensity), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_unit_intensity_mu', $in_unit_intensity_mu, count($in_unit_intensity_mu), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_pysio_instruction', $in_pysio_instruction, count($in_pysio_instruction), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_note_text_dtl', $in_note_text_dtl, count($in_note_text_dtl), $numelems, SQLT_CHR);

            //---- prescription medicine ----
            $prescription->bindArray(':in_item_no_fk', $medicine_item_id_arr, count($medicine_item_id_arr), $numelems, SQLT_INT);
            $prescription->bindArray(':in_brand_name', $medicine_item_arr, count($medicine_item_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_brand_name_ud', $brand_ud_arr, count($brand_ud_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_generic_name', $medicine_item_arr, count($medicine_item_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_dosage', $medicine_dose_arr, count($medicine_dose_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_duration', $medicine_duration_type_arr, count($medicine_duration_type_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_duration_mu', $medicine_duration_mu_arr, count($medicine_duration_mu_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_duration_comment', $duration_comment_arr, count($duration_comment_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_route', $route_arr, count($route_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_strength', $strength_arr, count($strength_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_report_serial_med', $report_serial_med_arr, count($report_serial_med_arr), $numelems, SQLT_INT);
            $prescription->bindArray(':in_item_qty', $medicine_quantity_arr, count($medicine_quantity_arr), $numelems, SQLT_INT);
            $prescription->bindArray(':in_relation_with_meal', $instruction_arr, count($instruction_arr), $numelems, SQLT_CHR);
            $prescription->bindArray(':in_continue_ind', $continue_ind_arr, count($continue_ind_arr), $numelems, SQLT_INT);
            $prescription->bindArray(':in_medicine_comment', $instruction_arr, count($instruction_arr), $numelems, SQLT_CHR);

            $prescription->bindParam(':in_au_entry_by', $in_au_entry_by);
            $prescription->bindParam(':in_au_entry_session', $in_au_entry_session);
            $prescription->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);

            $prescription->bindParam(':out_prescription_no_pk', $out_prescription_no_pk, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_prescription_code', $null, PDO::PARAM_STR, 500);
            $prescription->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            $prescription->execute();
            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Prescription create Failled.', 'title' => 'Error'];
            } else {
                DB::commit();
                $message = ['msg' => 'New Prescription created successfully.Invoice ID = ' . $out_prescription_no_pk, 'title' => 'Success', 'insert_id' => $out_prescription_no_pk];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function quickAppointment($patient_id, $doctor_id, $room_id)
    {
        $appointment_id = 0;
        $patient_info = $this->getPatientDetails($patient_id);
        if (!empty($patient_info)) {
            $priority = DB::table('sysc_lookupdata')->select("lookupdata_no_pk")->where("lookupdata_code", "Routine")->first();
            $ses_hospital_id = Session::get('user.ses_hospital_id');

            $procedureName = 'pkg_patmanagement.prc_bafappointment';
            $outSlNo = $outAppointNo = $outAppointId = $outError = "";

            $dataBindingArr = [
                'in_appoint_date' => date('Y-m-d'),
                'in_room_no_fk' => $room_id,
                'in_doctor_person_no_fk' => $doctor_id,
                'in_patient_no_fk' => $patient_id,
                'in_chif_complain' => 0,
                'in_height' => '',
                'in_weight' => '',
                'in_temp' => '',
                'in_pulse' => '',
                'in_bp_sys' => '',
                'in_bp_dias' => '',
                'in_ofc' => '',
                'in_priority_no_fk' => $priority->lookupdata_no_pk,
                'in_au_entry_by' => Auth::id(),
                'in_au_entry_session' => 'session',
                'in_au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            $dataBindingArr['out_sl_no'] = [
                'value' => &$outSlNo,
                'type' => PDO::PARAM_INT,
            ];
            $dataBindingArr['out_appoint_no'] = [
                'value' => &$outAppointNo,
                'type' => PDO::PARAM_INT,
                'length' => 500,
            ];
            $dataBindingArr['out_appoint_id'] = [
                'value' => &$outAppointId,
                'type' => PDO::PARAM_STR,
                'length' => 500,
            ];
            $dataBindingArr['out_error'] = [
                'value' => &$outError,
                'type' => PDO::PARAM_STR,
                'length' => 500,
            ];

            $result = DB::executeProcedure($procedureName, $dataBindingArr);
            $appointment_id = $outAppointNo;
        }

        return $outAppointNo;
    }
    public function opdPresCreateOrUpdateTemplate($request, $id = null)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Dhaka');
        $auth_id = Auth::id();
        $user_info = Auth::user();
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        $sequence = DB::getSequence();
        // try {
        $prescription_id = $request->hdn_prescription_id;
        $in_appointment_no_fk = $request->hdn_appointment_id;
        $in_doctor_person_no_fk = Session::get('user.ses_person_no_fk');
        $in_hospital_code = 'HC';
        $in_patient_no_fk = $request->hdn_patient_id;
        $in_petient_code = $request->hdn_patient_code;
        $in_service_unit_no_fk = $request->hdn_su_no;
        $in_admission_no_fk = 0;
        $in_admission_code = '';
        $in_opd_ind = 1;
        $in_ipd_ind = 0;
        $in_room_no_fk = $request->hdn_room_no;
        $in_bed_no_fk = 0;
        $in_ward_fk_no = 0;
        $in_note_text = '';
        $in_ref_doctor_fk_no = 0;
        $in_ref_su_fk_no = 0;
        $in_prescription_state = 'NEW';

        $txt_pulse = $request->txt_pulse;
        $txt_bp_sys = $request->txt_bp_sys;
        $txt_bp_dia = $request->txt_bp_dia;
        $txt_temperature = $request->txt_temperature;
        $txt_height = $request->txt_height;
        $txt_weight = $request->txt_weight;
        $txt_ofc = $request->txt_ofc;
        $txt_bmi = $request->txt_bmi;

        $next_followup = new Carbon($request->next_followup);
        $next_followup_dt = date("Y-m-d", strtotime($next_followup->toDateString()));
        $followup_after = $request->followup_after;
        $followup_after_mu = $request->followup_after_mu;
        $referred_doctor = '';
        /* $referred_doctor        = $request->txt_referred_doctor; */
        $rx_note = $request->txt_rx_note;
        $template_name = $request->template_name;

        $item_id = !empty($request->item_id) ? $request->item_id : 0;
        $item_name = $request->item_name;

        $pres_data = new PrescriptionTemplate();
        $pres_data->template_name = $template_name;
        $pres_data->doctor_no_fk = $in_doctor_person_no_fk;
        $pres_data->su_no_fk = $in_service_unit_no_fk;
        $pres_data->opd_ind = 1;
        $pres_data->status = 1;
        $pres_data->au_entry_by = $auth_id;
        $pres_data->au_entry_session = 'session';
        $pres_data->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;

        if ($pres_data->save()) {
            $template_id = $pres_data->psn_template_no_pk;
            $pres_dtl_arr = $pres_med_arr = [];

            for ($i = 0; $i < sizeof($item_name); $i++) {
                if (!empty($item_name[$i])) {
                    $psn_template_dtl_no_pk = $sequence->nextValue('psn_s_template_dtl_seq');
                    $pres_dtldata = new PrescriptionTemplateDtl();

                    $pres_dtldata->psn_template_dtl_no_pk = $psn_template_dtl_no_pk;
                    $pres_dtldata->psn_template_no_fk = $template_id;
                    $pres_dtldata->lookupdata_item_no_fk = is_object($item_id[$i]) ? 0 : $item_id[$i];

                    $pres_dtldata->lookup_uid = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : '';
                    $pres_dtldata->lookupdata_uid = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : '';
                    $pres_dtldata->prescrition_data = $request->item_name[$i];

                    $pres_dtldata->unit_intensity = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : '';
                    $pres_dtldata->session_duration = isset($request->session_duration[$i]) ? $request->session_duration[$i] : '';
                    $pres_dtldata->no_of_session = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : '';
                    $pres_dtldata->session_mu = isset($request->session_mu[$i]) ? $request->session_mu[$i] : '';

                    // $in_m_repetition[$i] = isset($request->in_m_repetition[$i]) ? $request->in_m_repetition[$i] : '';
                    // $in_m_duration[$i] = isset($request->in_m_duration) ? $request->in_m_duration[$i] : '';
                    // $in_e_location[$i] = isset($request->in_e_location) ? $request->in_e_location[$i] : '';

                    $pres_dtldata->entry_serial = 0;
                    $pres_dtldata->status = 1;
                    $pres_dtldata->au_entry_by = $auth_id;
                    $pres_dtldata->au_entry_session = 'session';
                    $pres_dtldata->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;
                    $pres_dtl_arr[] = $pres_dtldata->attributesToArray();
                    //$pres_dtldata->save();
                }
            }
            // dd($pres_dtl_arr);
            DB::table('psn_s_template_dtl')->insert($pres_dtl_arr);

            // for ($i = 0; $i < sizeof($item_id); $i++) {
            //     if (!empty($item_id[$i])) { // Ensure item_id is not empty
            //         $psn_template_dtl_no_pk = $sequence->nextValue('psn_s_template_dtl_seq');
            //         $pres_dtldata = new PrescriptionTemplateDtl();

            //         $pres_dtldata->psn_template_dtl_no_pk = $psn_template_dtl_no_pk;
            //         $pres_dtldata->psn_template_no_fk = $template_id;
            //         $pres_dtldata->lookupdata_item_no_fk = $item_id[$i];
            //         $pres_dtldata->lookup_uid = isset($request->lookup_code[$i]) ? $request->lookup_code[$i] : null; // Use null if not set
            //         $pres_dtldata->lookupdata_uid = isset($request->lookupdata_code[$i]) ? $request->lookupdata_code[$i] : null; // Use null if not set
            //         $pres_dtldata->prescrition_data = isset($request->item_name[$i]) ? $request->item_name[$i] : ''; // Default to empty string if not set

            //         $pres_dtldata->unit_intensity = isset($request->unit_intensity[$i]) ? $request->unit_intensity[$i] : null;
            //         $pres_dtldata->session_duration = isset($request->session_duration[$i]) ? $request->session_duration[$i] : null;
            //         $pres_dtldata->no_of_session = isset($request->no_of_session[$i]) ? $request->no_of_session[$i] : null;
            //         $pres_dtldata->session_mu = isset($request->session_mu[$i]) ? $request->session_mu[$i] : null;

            //         $pres_dtldata->entry_serial = 0;
            //         $pres_dtldata->status = 1;
            //         $pres_dtldata->au_entry_by = $auth_id;
            //         $pres_dtldata->au_entry_session = 'session'; // Ensure this is a valid session identifier
            //         $pres_dtldata->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;

            //         // Include AU_UPDATE_* and AU_SYNC_* fields if needed
            //         $pres_dtldata->au_update_by = null;
            //         $pres_dtldata->au_update_at = null;
            //         $pres_dtldata->au_update_session = null;
            //         $pres_dtldata->au_update_hospital_no_fk = null;
            //         $pres_dtldata->au_sync_hospital_no_fk = null;
            //         $pres_dtldata->au_sync_at = null;

            //         $pres_dtl_arr[] = $pres_dtldata->attributesToArray();
            //     }
            // }


            //PrescriptionTemplateDtl::insert($pres_dtl_arr);

            $medicine_item_id = $request->hdn_medicine_item_id;
            $medicine_item = $request->medicine_item;
            $medicine_route = $request->medicine_route;
            $medicine_dose = $request->medicine_dose;
            $medicine_duration_type = $request->medicine_duration_type;
            $medicine_duration_mu = $request->medicine_duration_mu;
            $medicine_quantity = $request->medicine_quantity;
            $instruction = $request->instruction;
            $is_continue = $request->is_continue;
            $is_chronic = $request->is_chronic;
            $report_serial_med = $request->hdn_report_serial_med;

            for ($j = 1; $j < sizeof($medicine_item); $j++) {
                if (!empty($medicine_item[$j])) {
                    $psn_template_med_no_pk = $sequence->nextValue('psn_s_template_med_seq');

                    $pres_meddata = new PrescriptionTemplateMed();
                    $pres_meddata->psn_template_med_no_pk = $psn_template_med_no_pk;
                    $pres_meddata->psn_template_no_fk = $template_id;

                    // Numeric columns
                    $pres_meddata->item_no_fk = (isset($medicine_item_id[$j]) && is_numeric($medicine_item_id[$j]))
                        ? (int)$medicine_item_id[$j] : 0;
                    $pres_meddata->item_qty = (isset($medicine_quantity[$j]) && is_numeric($medicine_quantity[$j]))
                        ? (int)$medicine_quantity[$j] : 0;
                    $pres_meddata->continue_ind = !empty($is_continue[$j]) ? 1 : 0;
                    $pres_meddata->status = 1;
                    $pres_meddata->au_entry_by = $auth_id;
                    $pres_meddata->au_entry_session = 'session';
                    $pres_meddata->au_entry_hospital_no_fk = $in_au_entry_hospital_pk_no;

                    // String / VARCHAR columns
                    $pres_meddata->generic_name = !empty($medicine_item[$j]) ? (string)$medicine_item[$j] : '0';
                    $pres_meddata->brand_name = !empty($medicine_item[$j]) ? (string)$medicine_item[$j] : '0';
                    $pres_meddata->route = !empty($medicine_route[$j]) ? (string)$medicine_route[$j] : '0';
                    $pres_meddata->dosage = !empty($medicine_dose[$j]) ? (string)$medicine_dose[$j] : '0';
                    $pres_meddata->duration = !empty($medicine_duration_type[$j]) ? (string)$medicine_duration_type[$j] : '0';
                    $pres_meddata->instruction_take = !empty($instruction[$j]) ? (string)$instruction[$j] : '0';

                    $pres_med_arr[] = $pres_meddata->attributesToArray();
                }
            }



            DB::table('psn_s_template_med')->insert($pres_med_arr);
            //PrescriptionTemplateMed::create($pres_med_arr);

            DB::commit();
            $message = ['msg' => 'Prescription saved as Template successfully.', 'title' => 'Success'];
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }
}
