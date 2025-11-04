<?php

namespace App\Repositories;

use PDO;
use Auth;
use DateTime;
use Carbon\Carbon;
use App\Traits\LookupData;
use Carbon\Traits\Creator;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\DB;
use App\Models\PatientRegistration;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PatientRegistrationRepository extends BaseRepository
{
    use LookupData, UtilitiesTrait;

    protected $pat_reg = null;
    protected $baseRepository;

    public function __construct(PatientRegistration $pat_reg)
    {
        $this->pat_reg = $pat_reg;
        $this->baseRepository = new BaseRepository($pat_reg);
    }

    public function all()
    {
        return $this->pat_reg->all();
    }

    public function createOrUpdate($request, $id = null)
    {
        //dd($request->all());
        $auth_id = Auth::id();

        // dd($request->file('pat_photo'));
        $person_seq_count = PatientRegistration::latest('patient_no_pk')->where('patient_no_pk','!=',1000)->first();
       // dd( $person_seq_count);
        
       $sequence = DB::getSequence();
       $person_id = $sequence->nextValue('SYSC_REG_PATIENT_code_PK_SEQ');
        
        $agent_id = 0;
        if($request->inform == 'Marketing Agent'){
           $agent_id = $request->agent_id_hdn;
        }elseif($request->inform == 'Staff'){
           $agent_id = $request->hdn_staff__id;
        }
        $inform = isset($request->inform) ? $request->inform : '';
        $in_cor_member_no_pk = isset($request->corporate_id) ? $request->corporate_id : '';

        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $gender_txt             = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
        $marital_status_txt     = isset($marital_status[$request->pat_marital_status]) ? $marital_status[$request->pat_marital_status] : '';
        $age = (($request->pat_age_y != "") ? $request->pat_age_y . " Y " : "")  . (($request->pat_age_m != "") ? ", " . $request->pat_age_m . " M " : "") . (($request->pat_age_d != "") ? ", " . $request->pat_age_d . " D " : "");
        $pat_dob = $request->pat_dob;

        if(Session::get('user.ses_hospital_code') != 'IMPALA'){
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->pat_dob);
            $dob = $dateTime->format('Y-m-d');
        }
        else{
            $dob =  date("Y-m-d", strtotime($request->pat_dob));
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
        $corporate_name = '';
        if ($corporate_id != "") {
            $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
        }
        DB::beginTransaction();
        try {
            $data = [
                // 'patient_code'                => $person_id,
                'salutation'                  => $request->pat_salutation,
                'first_name'                  => ucwords($request->pat_f_name),
                'last_name'                   => ucwords($request->pat_l_name),
                'patient_name'                => ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name),
                'age_dd'                      => ($request->pat_age_d == "") ? "0" : $request->pat_age_d,
                'age_mm'                      => ($request->pat_age_m == "") ? "0" : $request->pat_age_m,
                'age_yy'                      => $request->pat_age_y,
                'age'                         => $age,
                'dob'                         => $dob,
                'emergency_contact_addr'      => $request->emergency_contact_address,
                'present_addr'                => $request->present_address,
                'permanent_addr'              => $request->parmanent_address,
                'blood_group'                 => $request->pat_blood_group,
                'national_id'                 => $request->pat_nid,
                'mobile1'                     => $request->mobile_no,
                'mobile2'                     => $request->phone_no,
                'father_name'                 => $request->pat_father,
                'mother_name'                 => $request->pat_mother,
                'spouse_name'                 => $request->pat_spouse,
                'email'                       => $request->pat_email,
                'nationality'                 => $request->pat_nationality,
                'passport_no'                 => $request->pat_passport,
                'gender'                      => $request->pat_gender,
                'gender_txt'                  => $gender_txt,
                'marital_status'              => $request->pat_marital_status,
                'marital_status_txt'          => $marital_status_txt,
                'religion'                    => $request->pat_religion,
                'present_district'            => $request->present_district,
                'permanent_district'          => $request->par_district,
                'pr_addr_thana'               => $request->doctor_pr_thana,
                'pe_addr_thana'               => $request->doctor_pe_thana,
                'pr_addr_country'             => $request->present_country,
                'pe_addr_country'             => $request->parmanent_country,
                'emergency_contact_name'      => $request->emergency_contact_name,
                'relation_lookup_pk_no'       => $request->emergency_contact_relation,
                'emergency_contact_contact'   => $request->emergency_contact_contact,

                'membershid_id'               => $request->emp_id,
                'cardnumber'                  => $request->card_no,
                'membership_organization_name'=> $request->organization,
                'currentdesignationname'      => $request->designation,
                'pat_relation_name_stf_oth'   => $request->relation_data,
                'ref_person_no_fk'            => $request->hospital_emp_id_hidden,
                'status'                      => $request->status,
                'au_entry_hospital_pk_no'     => $hospital_id,
                'patient_type'                => $request->patient_type,
                'ccm_client_no_fk'            => $corporate_id,
                'ccm_client_name'             => $corporate_name,
                'occupation'                  => $request->occupation,
                'inform_text'                 => $inform,
                'agent_no_fk'                 => $agent_id,
                'cor_member_no_pk'            => $in_cor_member_no_pk,
                // 'spouse_name'                 => $request->spouse_name,
                'oi_health_ins'               =>$request->is_health_insurance,// ($request->is_health_insurance == 'Yes') ? "Yes" : "No",
                'oi_ins_comp_name'            => $request->insurance_company_name,
                'oi_locar_guardian'           => $request->local_guardian,
                'oi_relation_with_guar'       => $request->relationship_with_local_guardian,
                'oi_guar_mobile_no'           => $request->local_guardian_mobile,
                'fi_passport_no'              => $request->passport_no_foreign,
                'fi_visa_no'                  => $request->visa_no_foreign,
                'fi_visa_validity'            => ($request->visa_validity) ? date('Y-M-d', strtotime($request->visa_validity)) : '',
                'fi_visa_type'                => $request->visa_type
            ];

            $dataUpdate = [
                // 'patient_code'                => $person_id,
                'salutation'                  => $request->pat_salutation,
                'first_name'                  => ucwords($request->pat_f_name),
                'last_name'                   => ucwords($request->pat_l_name),
                'patient_name'                => ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name),
                'age_dd'                      => ($request->pat_age_d == "") ? "0" : $request->pat_age_d,
                'age_mm'                      => ($request->pat_age_m == "") ? "0" : $request->pat_age_m,
                'age_yy'                      => $request->pat_age_y,
                'age'                         => $age,
                'dob'                         => $dob,
                'emergency_contact_addr'      => $request->emergency_contact_address,
                'present_addr'                => $request->present_address,
                'permanent_addr'              => $request->parmanent_address,
                'blood_group'                 => $request->pat_blood_group,
                'national_id'                 => $request->pat_nid,
                'mobile1'                     => $request->mobile_no,
                'mobile2'                     => $request->phone_no,
                'father_name'                 => $request->pat_father,
                'mother_name'                 => $request->pat_mother,
                'spouse_name'                 => $request->pat_spouse,
                'email'                       => $request->pat_email,
                'nationality'                 => $request->pat_nationality,
                'passport_no'                 => $request->pat_passport,
                'gender'                      => $request->pat_gender,
                'gender_txt'                  => $gender_txt,
                'marital_status'              => $request->pat_marital_status,
                'marital_status_txt'          => $marital_status_txt,
                'religion'                    => $request->pat_religion,
                'present_district'            => $request->present_district,
                'permanent_district'          => $request->par_district,
                'pr_addr_thana'               => $request->doctor_pr_thana,
                'pe_addr_thana'               => $request->doctor_pe_thana,
                'pr_addr_country'             => $request->present_country,
                'pe_addr_country'             => $request->parmanent_country,
                'emergency_contact_name'      => $request->emergency_contact_name,
                'relation_lookup_pk_no'       => $request->emergency_contact_relation,
                'emergency_contact_contact'   => $request->emergency_contact_contact,

                'membershid_id'               => $request->emp_id,
                'cardnumber'                  => $request->card_no,
                'membership_organization_name'=> $request->organization,
                'currentdesignationname'      => $request->designation,
                'pat_relation_name_stf_oth'   => $request->relation_data,
                'ref_person_no_fk'            => $request->hospital_emp_id_hidden,

                'status'                      => $request->status,
                'au_entry_hospital_pk_no'     => $hospital_id,
                'patient_type'                => $request->patient_type,
                'ccm_client_no_fk'            => $corporate_id,
                'ccm_client_name'             => $corporate_name,
                'occupation'                  => $request->occupation,
                'cor_member_no_pk'            => $in_cor_member_no_pk,
                // 'spouse_name'              => $request->spouse_name,
                'oi_health_ins'               => $request->is_health_insurance,//($request->is_health_insurance == 'Yes') ? "Yes" : "No",
                'oi_ins_comp_name'            => $request->insurance_company_name,
                'oi_locar_guardian'           => $request->local_guardian,
                'oi_relation_with_guar'       => $request->relationship_with_local_guardian,
                'oi_guar_mobile_no'           => $request->local_guardian_mobile,
                'fi_passport_no'              => $request->passport_no_foreign,
                'fi_visa_no'                  => $request->visa_no_foreign,
                'fi_visa_validity'            => ($request->visa_validity) ? date('Y-M-d', strtotime($request->visa_validity)) : '',
                'fi_visa_type'                => $request->visa_type,
                'inform_text'                 => $inform
            ];
            // dd($request->status);
            if ($id == null) {
                // dd($data);
                $data['au_entry_by'] = $auth_id;
                $data['reg_date']    = date('Y-m-d');
                $data['patient_code']    = $person_id;

                $response = $this->baseRepository->create($data);
                $last_id  = $response->patient_no_pk;

                $image_name = "";
                if ($files = $request->file('pat_photo')) {
                    $image_name = $last_id . "." . $files->getClientOriginalExtension();
                }

                $update_image['patient_photo'] = $image_name;
                $this->baseRepository->update($update_image, $last_id);
            } else {
                $dataUpdate['au_update_at'] = date('Y-m-d');
                $dataUpdate['au_update_by'] = $auth_id;
                if ($files = $request->file('pat_photo')) {
                    //echo  $id . "." . $files->getClientOriginalExtension();die;
                    $data['patient_photo'] = $id . "." . $files->getClientOriginalExtension();
                }
                $this->baseRepository->update($dataUpdate, $id);
                $last_id = $id;
                // $user_info = [];
                // $user_info =[
                // 	'user_name' => $data['patient_name'],
                // 	'phone_mobile' => $data['mobile1']
                // ];
                // DB::table('wsec_user')->where('user_no_pk',$auth_id)->update($user_info);

            }

            if ($files = $request->file('pat_photo')) {
                $this->uploadImages($files, $last_id, 'images/uploads/patient_images/', 'images/uploads/patient_images/thumb/');
            }

            DB::commit();

            //Edit Appointment and Finc Information On Demand of JKMS Requirement
            if (isset($id)) {
                $appointment_info = [];
                if (isset($request->pat_salutation)) {
                    $appointment_info['salutation'] = $request->pat_salutation;
                }
                if (isset($request->pat_f_name)) {
                    $appointment_info['patient_name'] = ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name);
                }
                if (isset($request->pat_salutation)) {
                    $appointment_info['phone_mobile'] = $request->mobile_no;
                }
                if (isset($request->pat_salutation)) {
                    $appointment_info['email'] = $request->pat_email;
                }
                if (isset($dob)) {
                    $appointment_info['dob'] = $dob;
                }
                if (isset($request->pat_age_d)) {
                    $appointment_info['age_dd'] = $request->pat_age_d;
                }
                if (isset($request->pat_age_m)) {
                    $appointment_info['age_mm'] = $request->pat_age_m;
                }
                if (isset($request->pat_age_y)) {
                    $appointment_info['age_yy'] = $request->pat_age_y;
                }
                if (isset($age)) {
                    $appointment_info['age'] = $age;
                }
                if (isset($request->pat_gender)) {
                    $appointment_info['gender'] = $request->pat_gender;
                    $appointment_info['gender_txt'] = $gender_txt;
                }

                if (isset($request->present_address)) {
                    $appointment_info['address'] = $request->present_address;
                }
                $appointment_info['au_update_at'] = date('Y-m-d');
                DB::table('patn_appointment')->where('patient_no_fk', $id)->update($appointment_info);
            }
            //End
             if (isset($request->appoint_no_pk) && !empty($request->appoint_no_pk)) {
                DB::table('patn_appointment')->where('appoint_no_pk', $request->appoint_no_pk)->update(['patient_no_fk' => $last_id]);
            }
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

     public function createOrUpdateV2($request, $id = null)
    {
        //dd($request->all());
        $auth_id = Auth::id();

        // dd($request->file('pat_photo'));
        $person_seq_count = PatientRegistration::latest('patient_no_pk')->where('patient_no_pk', '!=', 1000)->first();
        // dd( $person_seq_count);
        if (Session::get('user.ses_hospital_code') == 'JKMH') {

            $person_id =  $person_seq_count->patient_no_pk + 1;
        } else {
            if (Session::get('user.ses_hospital_code') == 'DMHL') {
                if (!empty($person_seq_count)) {
                    $person_id = "P" . date("ymd") . str_pad(($person_seq_count->patient_no_pk + 1), 6, '0', STR_PAD_LEFT);
                } else {
                    $person_id = "P" . date("ymd") . str_pad(1, 6, '0', STR_PAD_LEFT);
                }
            } else {
                if (!empty($person_seq_count)) {
                    $person_id = "P" . date("dmy") . str_pad(($person_seq_count->patient_no_pk + 1), 6, '0', STR_PAD_LEFT);
                } else {
                    $person_id = "P" . date("dmy") . str_pad(1, 6, '0', STR_PAD_LEFT);
                }
            }
        }
        $agent_id = 0;
        if ($request->inform == 'MARKETING AGENT') {
            $agent_id = $request->agent_id_hdn;
        } elseif ($request->inform == 'STAFF') {
            $agent_id = $request->hdn_staff__id;
        }elseif ($request->inform == 'REFERRAL DOCTOR') {
            $agent_id = $request->ref_doc_hdn;
        }
        $inform = isset($request->inform) ? $request->inform : '';

        // Determine what to save in the single column
        $inform_text_details = null;

        if ($request->filled('inform')) {
            switch ($request->inform) {
                case 'MARKETING AGENT':
                    $inform_text_details = $request->agent_hdn_id ? $request->agent_hdn_id : $request->agent;
                    break;
                case 'STAFF':
                    $inform_text_details = $request->staff_hdn_id ? $request->staff_hdn_id : $request->staff;
                    break;
                case 'CAMPAIGN':
                    $inform_text_details = $request->campaign;
                    break;
                case 'SOCIAL MEDIA':
                    $inform_text_details = $request->social_media;
                    break;
                case 'REFERRAL DOCTOR':
                    $inform_text_details = $request->ref_doc_hdn ? $request->ref_doc_hdn : $request->ref_doc;
                    break;
                case 'INSTITUTE':
                    $inform_text_details = $request->institute;
                    break;
                case 'OTHERS':
                    $inform_text_details = $request->others;
                    break;
                default:
                    $inform_text_details = null;
            }
        }

        $in_cor_member_no_pk = isset($request->corporate_id) ? $request->corporate_id : '';

        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $gender_txt             = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
        $marital_status_txt     = isset($marital_status[$request->pat_marital_status]) ? $marital_status[$request->pat_marital_status] : '';
        $age = (($request->pat_age_y != "") ? $request->pat_age_y . " Y " : "")  . (($request->pat_age_m != "") ? ", " . $request->pat_age_m . " M " : "") . (($request->pat_age_d != "") ? ", " . $request->pat_age_d . " D " : "");
        $pat_dob = $request->pat_dob;

        if (Session::get('user.ses_hospital_code') != 'IMPALA') {
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->pat_dob);
            $dob = $dateTime->format('Y-m-d');
        } else {
            $dob =  date("Y-m-d", strtotime($request->pat_dob));
        }

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
        $corporate_name = '';
        if ($corporate_id != "") {
            $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
        }
        DB::beginTransaction();
        try {
            $data = [
                // 'patient_code'                => $person_id,
                'salutation'                  => $request->pat_salutation,
                'first_name'                  => ucwords($request->pat_f_name),
                'last_name'                   => ucwords($request->pat_l_name),
                'patient_name'                => ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name),
                'age_dd'                      => ($request->pat_age_d == "") ? "0" : $request->pat_age_d,
                'age_mm'                      => ($request->pat_age_m == "") ? "0" : $request->pat_age_m,
                'age_yy'                      => $request->pat_age_y,
                'age'                         => $age,
                'dob'                         => $dob,
                'emergency_contact_addr'      => $request->emergency_contact_address,
                'present_addr'                => $request->present_address,
                'permanent_addr'              => $request->parmanent_address,
                'blood_group'                 => $request->pat_blood_group,
                'national_id'                 => $request->pat_nid,
                'mobile1'                     => $request->mobile_no,
                'mobile2'                     => $request->phone_no,
                'father_name'                 => $request->pat_father,
                'mother_name'                 => $request->pat_mother,
                'spouse_name'                 => $request->pat_spouse,
                'email'                       => $request->pat_email,
                'nationality'                 => $request->pat_nationality,
                'passport_no'                 => $request->pat_passport,
                'gender'                      => $request->pat_gender,
                'gender_txt'                  => $gender_txt,
                'marital_status'              => $request->pat_marital_status,
                'marital_status_txt'          => $marital_status_txt,
                'religion'                    => $request->pat_religion,
                'present_district'            => $request->present_district,
                'permanent_district'          => $request->par_district,
                'pr_addr_thana'               => $request->doctor_pr_thana,
                'pe_addr_thana'               => $request->doctor_pe_thana,
                'pr_addr_country'             => $request->present_country,
                'pe_addr_country'             => $request->parmanent_country,
                'emergency_contact_name'      => $request->emergency_contact_name,
                'relation_lookup_pk_no'       => $request->emergency_contact_relation,
                'emergency_contact_contact'   => $request->emergency_contact_contact,

                'membershid_id'               => $request->emp_id,
                'cardnumber'                  => $request->card_no,
                'membership_organization_name' => $request->organization,
                'currentdesignationname'      => $request->designation,
                'pat_relation_name_stf_oth'   => $request->relation_data,
                'ref_person_no_fk'            => $request->hospital_emp_id_hidden,
                'status'                      => $request->status,
                'au_entry_hospital_pk_no'     => $hospital_id,
                'patient_type'                => $request->patient_type,
                'ccm_client_no_fk'            => $corporate_id,
                'ccm_client_name'             => $corporate_name,
                'occupation'                  => $request->occupation,
                'inform_text'                 => $inform,
                'agent_no_fk'                 => $agent_id,
                'cor_member_no_pk'            => $in_cor_member_no_pk,
                // 'spouse_name'                 => $request->spouse_name,
                'oi_health_ins'               => $request->is_health_insurance, // ($request->is_health_insurance == 'Yes') ? "Yes" : "No",
                'oi_ins_comp_name'            => $request->insurance_company_name,
                'oi_locar_guardian'           => $request->local_guardian,
                'oi_relation_with_guar'       => $request->relationship_with_local_guardian,
                'oi_guar_mobile_no'           => $request->local_guardian_mobile,
                'fi_passport_no'              => $request->passport_no_foreign,
                'fi_visa_no'                  => $request->visa_no_foreign,
                'fi_visa_validity'            => ($request->visa_validity) ? date('Y-M-d', strtotime($request->visa_validity)) : '',
                'fi_visa_type'                => $request->visa_type,
                'inform_txt_details'          => $inform_text_details
            ];

            $dataUpdate = [
                // 'patient_code'                => $person_id,
                'salutation'                  => $request->pat_salutation,
                'first_name'                  => ucwords($request->pat_f_name),
                'last_name'                   => ucwords($request->pat_l_name),
                'patient_name'                => ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name),
                'age_dd'                      => ($request->pat_age_d == "") ? "0" : $request->pat_age_d,
                'age_mm'                      => ($request->pat_age_m == "") ? "0" : $request->pat_age_m,
                'age_yy'                      => $request->pat_age_y,
                'age'                         => $age,
                'dob'                         => $dob,
                'emergency_contact_addr'      => $request->emergency_contact_address,
                'present_addr'                => $request->present_address,
                'permanent_addr'              => $request->parmanent_address,
                'blood_group'                 => $request->pat_blood_group,
                'national_id'                 => $request->pat_nid,
                'mobile1'                     => $request->mobile_no,
                'mobile2'                     => $request->phone_no,
                'father_name'                 => $request->pat_father,
                'mother_name'                 => $request->pat_mother,
                'spouse_name'                 => $request->pat_spouse,
                'email'                       => $request->pat_email,
                'nationality'                 => $request->pat_nationality,
                'passport_no'                 => $request->pat_passport,
                'gender'                      => $request->pat_gender,
                'gender_txt'                  => $gender_txt,
                'marital_status'              => $request->pat_marital_status,
                'marital_status_txt'          => $marital_status_txt,
                'religion'                    => $request->pat_religion,
                'present_district'            => $request->present_district,
                'permanent_district'          => $request->par_district,
                'pr_addr_thana'               => $request->doctor_pr_thana,
                'pe_addr_thana'               => $request->doctor_pe_thana,
                'pr_addr_country'             => $request->present_country,
                'pe_addr_country'             => $request->parmanent_country,
                'emergency_contact_name'      => $request->emergency_contact_name,
                'relation_lookup_pk_no'       => $request->emergency_contact_relation,
                'emergency_contact_contact'   => $request->emergency_contact_contact,

                'membershid_id'               => $request->emp_id,
                'cardnumber'                  => $request->card_no,
                'membership_organization_name' => $request->organization,
                'currentdesignationname'      => $request->designation,
                'pat_relation_name_stf_oth'   => $request->relation_data,
                'ref_person_no_fk'            => $request->hospital_emp_id_hidden,

                'status'                      => $request->status,
                'au_entry_hospital_pk_no'     => $hospital_id,
                'patient_type'                => $request->patient_type,
                'ccm_client_no_fk'            => $corporate_id,
                'ccm_client_name'             => $corporate_name,
                'occupation'                  => $request->occupation,
                'cor_member_no_pk'            => $in_cor_member_no_pk,
                // 'spouse_name'              => $request->spouse_name,
                'oi_health_ins'               => $request->is_health_insurance, //($request->is_health_insurance == 'Yes') ? "Yes" : "No",
                'oi_ins_comp_name'            => $request->insurance_company_name,
                'oi_locar_guardian'           => $request->local_guardian,
                'oi_relation_with_guar'       => $request->relationship_with_local_guardian,
                'oi_guar_mobile_no'           => $request->local_guardian_mobile,
                'fi_passport_no'              => $request->passport_no_foreign,
                'fi_visa_no'                  => $request->visa_no_foreign,
                'fi_visa_validity'            => ($request->visa_validity) ? date('Y-M-d', strtotime($request->visa_validity)) : '',
                'fi_visa_type'                => $request->visa_type,
                'inform_text'                 => $inform,
                'agent_no_fk'                 => $agent_id,
            ];
            // dd($request->status);
            if ($id == null) {
                // dd($data);
                $data['au_entry_by'] = $auth_id;
                $data['reg_date']    = date('Y-m-d');
                $data['patient_code']    = $person_id;

                $response = $this->baseRepository->create($data);
                $last_id  = $response->patient_no_pk;

                $image_name = "";
                if ($files = $request->file('pat_photo')) {
                    $image_name = $last_id . "." . $files->getClientOriginalExtension();
                }

                $update_image['patient_photo'] = $image_name;
                $this->baseRepository->update($update_image, $last_id);
            } else {
                $dataUpdate['au_update_at'] = date('Y-m-d');
                $dataUpdate['au_update_by'] = $auth_id;
                if ($files = $request->file('pat_photo')) {
                    //echo  $id . "." . $files->getClientOriginalExtension();die;
                    $data['patient_photo'] = $id . "." . $files->getClientOriginalExtension();
                }
                $this->baseRepository->update($dataUpdate, $id);
                $last_id = $id;
                // $user_info = [];
                // $user_info =[
                // 	'user_name' => $data['patient_name'],
                // 	'phone_mobile' => $data['mobile1']
                // ];
                // DB::table('wsec_user')->where('user_no_pk',$auth_id)->update($user_info);

            }

            if ($files = $request->file('pat_photo')) {
                $this->uploadImages($files, $last_id, 'images/uploads/patient_images/', 'images/uploads/patient_images/thumb/');
            }

            DB::commit();

            //Edit Appointment and Finc Information On Demand of JKMS Requirement
            if (isset($id)) {
                $appointment_info = [];
                if (isset($request->pat_salutation)) {
                    $appointment_info['salutation'] = $request->pat_salutation;
                }
                if (isset($request->pat_f_name)) {
                    $appointment_info['patient_name'] = ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name);
                }
                if (isset($request->pat_salutation)) {
                    $appointment_info['phone_mobile'] = $request->mobile_no;
                }
                if (isset($request->pat_salutation)) {
                    $appointment_info['email'] = $request->pat_email;
                }
                if (isset($dob)) {
                    $appointment_info['dob'] = $dob;
                }
                if (isset($request->pat_age_d)) {
                    $appointment_info['age_dd'] = $request->pat_age_d;
                }
                if (isset($request->pat_age_m)) {
                    $appointment_info['age_mm'] = $request->pat_age_m;
                }
                if (isset($request->pat_age_y)) {
                    $appointment_info['age_yy'] = $request->pat_age_y;
                }
                if (isset($age)) {
                    $appointment_info['age'] = $age;
                }
                if (isset($request->pat_gender)) {
                    $appointment_info['gender'] = $request->pat_gender;
                    $appointment_info['gender_txt'] = $gender_txt;
                }

                if (isset($request->present_address)) {
                    $appointment_info['address'] = $request->present_address;
                }
                $appointment_info['au_update_at'] = date('Y-m-d');
                DB::table('patn_appointment')->where('patient_no_fk', $id)->update($appointment_info);
            }
            //End
            // dd($request->appoint_no_pk);
            if (isset($request->appoint_no_pk) && !empty($request->appoint_no_pk)) {
                DB::table('patn_appointment')->where('appoint_no_pk', $request->appoint_no_pk)->update(['patient_no_fk' => $last_id]);
            }

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function CreateOrUpdateQuickRegister($request, $id = null)
    {
        $out_patient_no_pk = $out_patient_code = $patient_name = $gender_txt = $age = $phone_no = $patient_type_code = $maximum_percent = $patient_type_no_pk = $corporate_info = "";
        DB::beginTransaction();
        try {
            if (Session::get('user.ses_hospital_version') == "V0") {
                return $this->storeQuickRegisterV1($request);
            } else {
                return $this->storeQuickRegister($request);
            }
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $out_patient_no_pk, 'patient_code' => $out_patient_code, 'patient_name' => $patient_name, 'gender' => $gender_txt, 'age' => $age, 'phone_mobile' => $phone_no, 'patient_type_code' => $patient_type_code, 'maximum_percent' => $maximum_percent, 'patient_type_no_pk' => $patient_type_no_pk, 'corporate_info' => $corporate_info];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function CreateOrUpdateGuestRegister($request, $id = null)
    {
        $out_patient_no_pk = $out_patient_code = $patient_name = $gender_txt = $age = $phone_no = "";
        DB::beginTransaction();
        try {

            return $this->storeGuestRegister($request);

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $out_patient_no_pk, 'patient_code' => $out_patient_code, 'patient_name' => $patient_name, 'gender' => $gender_txt, 'age' => $age, 'phone_mobile' => $phone_no];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function storeQuickRegister($request)
    {
        // dd($request->inform);
        $auth_id = Auth::id();
        // $person_seq_count = PatientRegistration::latest('patient_no_pk')->first();
        // $person_id = isset($person_seq_count) ? "PAT-".($person_seq_count->patient_no_pk + 1) : "PAT-". 1;

        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $pat_dob = new Carbon($request->pat_dob);
        $dob = date("Y-m-d", strtotime($pat_dob->toDateString()));

        $marital = $this->getLookupListByCode("MARSTS");
        $gender        = $this->getLookupListByCode("GENDER");
        try {

            $pdo = DB::getPdo();
            $pat_salutation     = $request->pat_salutation;
            $pat_f_name         = ucwords($request->pat_f_name);
            $pat_l_name         = ucwords($request->pat_l_name);
            $patient_name       = ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name);
            $pat_age_y          = $request->pat_age_y ? sprintf("%02d", $request->pat_age_y)  : "";
            $pat_age_m          = $request->pat_age_m ?  sprintf("%02d", $request->pat_age_m) : "";
            $pat_age_d          = $request->pat_age_d ?  sprintf("%02d", $request->pat_age_d)  : "";
            $pat_gender         = $request->pat_gender;
            $gender_txt         = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
            $marital_status     = $request->pat_marital_status;
            $marital_status_txt = isset($marital[$request->pat_marital_status]) ? $marital[$request->pat_marital_status] : '';
            $pat_address        = $request->pat_address;
            $pat_address1       = '';
            $pat_address2       = '';
            $passport_no        = $request->passport_no;

            $blood_group         = $request->pat_blood_group;
            $phone_no            = $request->phone_no;
            $pat_email           = $request->pat_email;
            $patient_type        = isset($request->patienttype) ? $request->patienttype : '0';
            $corporate_id        = isset($request->corporate_name) ? $request->corporate_name : 0;
            $corporate_name      = '';
            if ($corporate_id != "") {
                $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }


            //		$patient_type       = 0;

            $appoint_source     = 'WEB';
            $entry_session         = 'session';
            $hospital_id         = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $y = $pat_age_y ? $pat_age_y . " " . "Y " : "";
            $m = $pat_age_m ? "," . $pat_age_m . " " . "M " : "";
            $d = $pat_age_d ? "," . $pat_age_d . " " . "D" : "";
            $age = $y . " " . $m . " " . $d;

            // OUT PAREMETER INITIALIZE
            $out_patient_no_pk = $out_patient_code = $out_error = "";


            $stmt = $pdo->prepare("begin pkg_patmanagement.prc_quickregistration(:in_salutation,:in_patient_name,:in_phone_mobile,:in_email,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt, :in_address,:in_address1,:in_address2,:in_blood_group,:in_patient_type_no_fk,:in_ccm_client_no_fk,:in_ccm_client_name,:in_passport_no,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_patient_no_pk,:out_patient_code,:out_error); end;");

            $stmt->bindParam(':in_salutation', $pat_salutation);
            $stmt->bindParam(':in_patient_name', $patient_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_email', $pat_email);
            $stmt->bindParam(':in_dob', $dob);
            $stmt->bindParam(':in_age_dd', $pat_age_d);
            $stmt->bindParam(':in_age_mm', $pat_age_m);
            $stmt->bindParam(':in_age_yy', $pat_age_y);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $pat_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_address', $pat_address);
            $stmt->bindParam(':in_address1', $pat_address1);
            $stmt->bindParam(':in_address2', $pat_address2);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_passport_no', $passport_no);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            $stmt->execute();
            DB::commit();
            //billInvoice_wp

            $out_invoice_no2 = $out_ledger_no = $out_invoice_no = $out_invoice_id = $out_error = "";
            $pdo = DB::getPdo();
            $billinvoice = $pdo->prepare("begin pkg_billing.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:out_invoice_no,:out_invoice_id,:out_error); end;");
            //Preparating Data
            $cur_date = date("Y-M-d H:i:s");
            $cur_datetime = date("Y-M-d h:i:s");
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $null = '';
            $zero = 0;
            $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
            $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
            $auth_id = Auth::id();
            $entry_session = "Session";
            $hdn_doctor_id = $request->doctor_id;
            $billinvoice->bindParam(':in_invoice_date', $cur_date);
            $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
            $billinvoice->bindParam(':in_module_no_fk', $module_id);
            $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
            $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
            $billinvoice->bindParam(':in_admission_no_pk', $zero);
            $billinvoice->bindParam(':in_admission_code', $null);
            $billinvoice->bindParam(':in_appointment_no_fk', $zero);
            $billinvoice->bindParam(':in_prescription_no_fk', $zero);
            $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
            $billinvoice->bindParam(':in_first_ref_doc', $zero);
            $billinvoice->bindParam(':in_second_ref_doc', $zero);
            $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
            $billinvoice->bindParam(':in_report_deli_datetime', $cur_date);
            $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
            $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
            $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
            $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
            $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $zero);
            $billinvoice->bindParam(':in_dob', $cur_date);
            $billinvoice->bindParam(':in_age', $null);
            $billinvoice->bindParam(':in_age_dd', $null);
            $billinvoice->bindParam(':in_age_mm', $null);
            $billinvoice->bindParam(':in_age_yy', $null);
            $billinvoice->bindParam(':in_customer_addr', $null);
            $billinvoice->bindParam(':in_customer_name', $null);

            $billinvoice->bindParam(':in_gender_txt', $null);
            $billinvoice->bindParam(':in_marital_status_txt', $null);
            $billinvoice->bindParam(':in_blood_group', $null);
            $billinvoice->bindParam(':in_phone_mobile', $null);

            $billinvoice->bindParam(':in_invoice_remarks', $null);
            $billinvoice->bindParam(':in_urgent_fee_total', $null);
            $billinvoice->bindParam(':in_invoice_type', $null);
            $billinvoice->bindParam(':in_au_entry_by', $auth_id);
            $billinvoice->bindParam(':in_au_entry_session', $entry_session);
            $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $hdn_item_id = [
                0 => $request->item_no_pk,
            ];
            $batch_no_arr = [
                0 => '',
            ];
            $expire_dt_arr = [
                0 => '',
            ];


            $hdn_item_name = [
                0 => $request->item_name,
            ];
            $hdn_item_type = [
                0 => $request->item_no_pk,
            ];
            $hdn_item_rate = [
                0 => $request->sales_price,
            ];
            $item_total = $request->sales_price;
            $hdn_item_qnty = [
                0 => 1,
            ];
            $item_mu_arr = $in_package_item_ind = $package_ind_arr = [
                0 => 0,
            ];
            $item_level_remarks = $deli_dt_arr = $deli_dt_arr  = [
                0 => '',
            ];
            $item_delivery_status_arr = $item_disc_percent =  $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
                0 => 0,
            ];
            $numelems = 5000;
            $total_item = count($hdn_item_id);
            $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
            $billinvoice->bindParam(':in_item_count', $total_item);
            $billinvoice->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_batch_fk', $batch_no_arr, count($batch_no_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_expiry_dt', $expire_dt_arr, count($expire_dt_arr), $numelems, SQLT_CHR);

            $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
            $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

            $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
            $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
            $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);



            $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
            $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
            $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);


            $billinvoice->execute();
            $out_invoice_no1  = $out_invoice_no;

            if ($out_error == 999) {
                // dd($out_error);
                DB::rollback();
                $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error',];
            } else {
                $pdo1 = DB::getPdo();
                $billpayment = $pdo1->prepare("begin pkg_billing.prc_billpayment_wp(
                     :in_payment_date,
                     :in_payment_datetime,
                     :in_invoice_no_fk,
                     :in_module_no_fk,
                     :in_patient_no_fk,
                     :in_admission_no_fk,
                     :in_prescription_no_fk,
                     :in_counter_su_no_fk,
                     :in_ledger_amt_sales,
                     :in_ledger_amt_payment,
                     :in_ledger_amt_discount,
                     :in_urgent_fee,
                     :in_service_charge,
                     :in_cor_client_no_fk,
                     :in_pay_mode,
                     :in_pay_cqcc_holder_name,
                     :in_pay_cqcc_number,
                     :in_pay_cqcc_deduct_percent,
                     :in_pay_bank_name,
                     :in_pay_remarks,
                     :in_given_amt,
                     :in_disc_type_lookup_no_fk,
                     :in_disc_remarks,
                     :in_disc_amt_by_doc,
                     :in_disc_amt_by_doc_no_fk,
                     :in_disc_amt_by_hosp,
                     :in_disc_amt_by_hosp_auth_by,
                     :in_disc_amt_request_by_name,
                     :in_au_entry_by,
                     :in_au_entry_session,
                     :in_au_entry_hospital_pk_no,
                     :in_item_count,
                     :in_item_no_fk,
                     :in_item_name,
                     :in_itemtype_no_fk,
                     :in_item_qty,
                     :in_item_rate,
                     :in_item_vat,
                     :in_itemurgent_fee,
                     :in_itemservice_charge,
                     :in_package_item_ind,
                     :out_invoice_no,
                     :out_invoice_id,
                     :out_ledger_no,
                     :out_error);
                     end;");

                // :in_paymood,
                // :in_pay_mood_type,
                // :in_bank_name,
                // :in_transaction_id,
                // :in_bank_card_no,
                // :in_acc_holder_name,
                // :in_payment_amt,
                // :in_paymood_count,

                $item_default_discont = DB::table('sysc_serviceitem_vw')->where('item_no_pk', $request->item_no_pk)->first();
                $discount = $item_default_discont->default_discount != "" ? $item_default_discont->default_discount : 0;
                $corporate_id =  isset($corporate_id) ? $corporate_id : 0;
                $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($request->item_no_pk,'$patient_type',$corporate_id, $item_total,0,$discount,'PCT') as def_discount from dual"));
                $pay_mode = [0 => 'CASH'];
                $pay_mode1 = 'CASH';
                $discount = isset($def_dis[0]->def_discount) ?  $def_dis[0]->def_discount : 0;
                $payment_amount =  $item_total -  $item_total * ($discount / 100);
                $discount =  $item_total * ($discount / 100);
                $billpayment->bindParam(':in_payment_date', $cur_date);
                $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
                $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
                $billpayment->bindParam(':in_module_no_fk', $module_id);
                $billpayment->bindParam(':in_patient_no_fk', $out_patient_no_pk);
                $billpayment->bindParam(':in_admission_no_fk', $zero);
                $billpayment->bindParam(':in_prescription_no_fk', $zero);
                $billpayment->bindParam(':in_counter_su_no_fk', $module_id);
                $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
                $billpayment->bindParam(':in_ledger_amt_payment', $item_total);
                $billpayment->bindParam(':in_ledger_amt_discount', $discount);
                $billpayment->bindParam(':in_urgent_fee', $zero);
                $billpayment->bindParam(':in_service_charge', $zero);
                $billpayment->bindParam(':in_cor_client_no_fk', $zero);
                $billpayment->bindParam(':in_pay_mode', $pay_mode1);
                $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
                $billpayment->bindParam(':in_pay_cqcc_number', $null);
                $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
                $billpayment->bindParam(':in_pay_bank_name', $null);
                $billpayment->bindParam(':in_pay_remarks', $null);
                $billpayment->bindParam(':in_given_amt', $item_total);

                // DISCOUNT COLUMN PREPARATION START

                $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;


                //dd($in_paymood_arr);
                // DISCOUNT COLUMN PREPARATION END
                $lookupdata_no_pk = !empty($discount_info) ? $discount_info->lookupdata_no_pk : 0;
                $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
                $billpayment->bindParam(':in_disc_remarks', $null);
                $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_disc_amt);
                $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
                $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_disc_amt);
                $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $auth_id); // will be adjust later
                $billpayment->bindParam(':in_disc_amt_request_by_name', $null);

                $billpayment->bindParam(':in_au_entry_by', $auth_id);
                $billpayment->bindParam(':in_au_entry_session', $entry_session);
                $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $billpayment->bindParam(':in_item_count', $total_item);
                $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
                $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);

                $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
                $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
                $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                $billpayment->execute();

                if ($out_error == 999) {
                    DB::rollback();
                    $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
                } else {


                    $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                    // dd($paymood_count);
                    //$query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();


                    $auth_id = Auth::id();

                    $date = date('Y-m-d');
                    $in_paymood_arr_t = $request->pay_method_mode;
                    $in_pay_mood_type_arr_t = $request->mBank_types;
                    $in_bank_name_arr_t = $request->pay_bank_name;
                    $in_transaction_id_arr_t = $request->trans_id_no;
                    $in_bank_card_no_arr_t = $request->card_number;
                    $in_acc_holder_name_arr_t = $request->acc_holder_name;
                    $in_payment_amt_arr_t = $request->total_amt;
                    $in_paymood_count = $paymood_count;
                    $in_au_entry_by = $auth_id;
                    $in_au_entry_session = "session";
                    $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
                    $invoice_no = $out_invoice_no;
                    $ledger_no = $out_ledger_no;


                    $i = 0;
                    if (!empty($in_paymood_arr_t)) {
                        foreach ($in_paymood_arr_t as $key => $value) {

                            $sc_date = date("d-m-Y");


                            $in_paymood_arr_val[$i] = (!empty($value) ? $value : "");
                            $in_pay_mood_type_arr_val[$i] = (!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "");
                            $in_bank_name_arr_val[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "");
                            $in_transaction_id_arr_val[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "");
                            $in_bank_card_no_arr_val[$i] = (!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "");
                            $in_acc_holder_name_arr_val[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "");
                            $in_payment_amt_arr_val[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "");

                            $i++;
                        }
                    }
                    $in_paymood_arr = (!empty($in_paymood_arr_t) ? count($in_paymood_arr_t) : 1);
                    $in_pay_mood_type_arr = (!empty($in_pay_mood_type_arr_t) ? count($in_pay_mood_type_arr_t) : 1);
                    $in_bank_name_arr = (!empty($in_bank_name_arr_t) ? count($in_bank_name_arr_t) : 1);
                    $in_transaction_id_arr = (!empty($in_transaction_id_arr_t) ? count($in_transaction_id_arr_t) : 1);
                    $in_bank_card_no_arr = (!empty($in_bank_card_no_arr_t) ? count($in_bank_card_no_arr_t) : 1);
                    $in_acc_holder_name_arr = (!empty($in_acc_holder_name_arr_t) ? count($in_acc_holder_name_arr_t) : 1);
                    $in_payment_amt_arr = (!empty($in_payment_amt_arr_t) ? count($in_payment_amt_arr_t) : 1);

                    // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                    $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                    $pdo2 = DB::getPdo();
                    $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
                        :in_payment_date,
                        :in_invoice_no_fk,
                        :in_ledger_no_fk,
                        :in_paymood,
                        :in_pay_mood_type,
                        :in_bank_name,
                        :in_transaction_id,
                        :in_bank_card_no,
                        :in_acc_holder_name,
                        :in_payment_amt,
                        :in_paymood_count,
                        :in_au_entry_by ,
                        :in_au_entry_session ,
                        :in_au_entry_hospital_pk_no ,
                        :out_error);
                        end;");
                    if (!empty($pay_mode)) {
                        for ($i = 0; $i < count($pay_mode); $i++) {
                            $in_paymood_arr_val[$i] = $pay_mode[$i];
                            $in_pay_mood_type_arr_val[$i] = '';
                            $in_bank_name_arr_val[$i] = '';
                            $in_transaction_id_arr_val[$i] = '';
                            $in_bank_card_no_arr_val[$i] = '';
                            $in_acc_holder_name_arr_val[$i] = '';
                            $in_payment_amt_arr_val[$i] = $item_total;
                        }
                    }
                    //dd($pay_mode, $in_payment_amt_arr_val);
                    $in_paymood_count = count($in_paymood_arr_val);

                    $finc_ledger_paymood->bindParam(':in_payment_date', $date);
                    $finc_ledger_paymood->bindParam(':in_invoice_no_fk', $invoice_no);
                    $finc_ledger_paymood->bindParam(':in_ledger_no_fk', $ledger_no);
                    $finc_ledger_paymood->bindArray(':in_paymood', $in_paymood_arr_val, $in_paymood_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_pay_mood_type', $in_pay_mood_type_arr_val, $in_pay_mood_type_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_bank_name', $in_bank_name_arr_val, $in_bank_name_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_transaction_id', $in_transaction_id_arr_val, $in_transaction_id_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_bank_card_no', $in_bank_card_no_arr_val, $in_bank_card_no_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_acc_holder_name', $in_acc_holder_name_arr_val, $in_acc_holder_name_arr, $numelems, SQLT_CHR);
                    $finc_ledger_paymood->bindArray(':in_payment_amt', $in_payment_amt_arr_val, $in_payment_amt_arr, $numelems, SQLT_FLT);
                    $finc_ledger_paymood->bindParam(':in_paymood_count', $in_paymood_count);
                    $finc_ledger_paymood->bindParam(':in_au_entry_by', $in_au_entry_by);
                    $finc_ledger_paymood->bindParam(':in_au_entry_session', $in_au_entry_session);
                    $finc_ledger_paymood->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
                    $finc_ledger_paymood->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                    $finc_ledger_paymood->execute();

                    if ($out_error == 999) {
                        DB::rollback();
                        $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                    } else {
                        DB::commit();
                        $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
                    }
                }
            }
            $patient_type = DB::table('pat_registration_wl_vw reg')
                ->select('pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'reg.ccm_client_name', 'reg.ccm_client_no_fk', 'reg.contact_person', 'reg.contact_no')
                ->where('reg.patient_no_pk', $out_patient_no_pk)
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'reg.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'reg.patient_type')
                ->first();
            //return $stmt;


            $address_data = [
                'present_addr' => $request->pat_address,
                'patient_area_no_fk' => $request->hdn_area_code,
                'patient_area_name' => $request->hdn_area_name
            ];
            DB::table('patn_registration')->where('patient_no_pk', $out_patient_no_pk)->update($address_data);


            // End

            return [
                'msg' => 'Data Saved Successfully',
                'insert_id' => $out_patient_no_pk,
                'patient_code' => $out_patient_code,
                'patient_name' => $patient_name,
                'gender' => $gender_txt,
                'age' => $age,
                'phone_mobile' => $phone_no,
                'patient_type_code' => $patient_type->patient_type_code,
                'maximum_percent' => $patient_type->maximum_percent != "" ? $patient_type->maximum_percent : "",
                'patient_type_no_pk' => $patient_type->patient_type_no_pk,
                'item_level_disc_ind' => $patient_type->item_level_disc_ind,
                'ccm_client_no_fk' => $patient_type->ccm_client_no_fk,
                'ccm_client_name' => $patient_type->ccm_client_name,
                'contact_person' => $patient_type->contact_person,
                'contact_no' => $patient_type->contact_no,
                'invoice_no' => $out_invoice_no1
            ];
        } catch (\Exception $e) {
            //return response()->json(['msg' => $e->getMessage()],406);

        }
    }



    public function storeGuestRegister($request)
    {
        $auth_id = Auth::id();
        // $person_seq_count = PatientRegistration::latest('patient_no_pk')->first();
        // $person_id = isset($person_seq_count) ? "PAT-".($person_seq_count->patient_no_pk + 1) : "PAT-". 1;

        $passwordMatch = true;
        if ($passwordMatch == true) {
            if ($request->password == $request->c_password) {
                $passwordMatch = true;
            } else {
                $passwordMatch = false;
            }
        }

        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $pat_dob = new Carbon($request->pat_dob);
        $dob = date("Y-m-d", strtotime($pat_dob->toDateString()));

        $p_expire_date = new Carbon($request->expire_date);
        $p_expiredate = date("Y-m-d", strtotime($p_expire_date->toDateString()));

        $marital = $this->getLookupListByCode("MARSTS");
        $gender        = $this->getLookupListByCode("GENDER");

        $pdo = DB::getPdo();
        $pat_salutation     = $request->pat_salutation;
        $pat_f_name         = ucwords($request->pat_f_name);
        $pat_l_name         = ucwords($request->pat_l_name);
        $patient_name       = ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name);
        $pat_age_y          = $request->pat_age_y ? sprintf("%02d", $request->pat_age_y)  : "";
        $pat_age_m             = $request->pat_age_m ?  sprintf("%02d", $request->pat_age_m) : "";
        $pat_age_d             = $request->pat_age_d ?  sprintf("%02d", $request->pat_age_d)  : "";
        $pat_gender         = $request->pat_gender;
        $gender_txt         = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
        $marital_status     = $request->pat_marital_status;
        $marital_status_txt = isset($marital[$request->pat_marital_status]) ? $marital[$request->pat_marital_status] : '';
        $pat_address        = $request->pat_address;
        $pat_address1       = $request->pat_address;
        $pat_address2       = '';

        $blood_group         = $request->pat_blood_group;
        $phone_no             = $request->phone_no;
        $pat_email             = $request->pat_email;
        $p_guest_ind          = $request->guest_ind;


        $p_password             = Hash::make($request->password);

        $patient_type       = 0;

        $appoint_source     = 'WEB';
        $entry_session         = 'session';
        $hospital_id         = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
        $is_pay_consultation = $request->is_pay_consultation;
        $y = $pat_age_y ? $pat_age_y . " " . "Y " : "";
        $m = $pat_age_m ? "," . $pat_age_m . " " . "M " : "";
        $d = $pat_age_d ? "," . $pat_age_d . " " . "D" : "";
        $age = $y . " " . $m . " " . $d;

        // OUT PAREMETER INITIALIZE
        $out_patient_no_pk = $out_patient_code = $out_error = "";

        $stmt = $pdo->prepare("begin pkg_patmanagement.prc_quickregistration_guest(:in_salutation,:in_patient_name,:in_phone_mobile,:in_email,:in_password,:in_access_expire_date,:in_guest_ind,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt, :in_address,:in_address1,:in_address2,:in_blood_group,:in_patient_type_no_fk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_patient_no_pk,:out_patient_code,:out_error); end;");

        $stmt->bindParam(':in_salutation', $pat_salutation);
        $stmt->bindParam(':in_patient_name', $patient_name);
        $stmt->bindParam(':in_phone_mobile', $phone_no);
        $stmt->bindParam(':in_email', $pat_email);
        $stmt->bindParam(':in_password', $p_password);
        $stmt->bindParam(':in_access_expire_date', $p_expiredate);
        $stmt->bindParam(':in_guest_ind', $p_guest_ind);
        $stmt->bindParam(':in_dob', $dob);
        $stmt->bindParam(':in_age_dd', $pat_age_d);
        $stmt->bindParam(':in_age_mm', $pat_age_m);
        $stmt->bindParam(':in_age_yy', $pat_age_y);
        $stmt->bindParam(':in_age', $age);
        $stmt->bindParam(':in_gender', $pat_gender);
        $stmt->bindParam(':in_gender_txt', $gender_txt);
        $stmt->bindParam(':in_marital_status', $marital_status);
        $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
        $stmt->bindParam(':in_address', $pat_address);
        $stmt->bindParam(':in_address1', $pat_address1);
        $stmt->bindParam(':in_address2', $pat_address2);
        $stmt->bindParam(':in_blood_group', $blood_group);
        $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
        $stmt->bindParam(':in_au_entry_by', $auth_id);
        $stmt->bindParam(':in_au_entry_session', $entry_session);
        $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
        $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
        $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        $stmt->execute();
        if ($stmt->execute()) {
            DB::commit();
            $message = ['msg' => 'Data Save successfully.', 'title' => 'Success'];
        } else {

            DB::rollback();
            $message = ['msg' => 'Something Went Wrong', 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function createOrUpdatePatientOnlineProfile($request, $id = null)
    {
        //dd($request->all());
        $auth_id = Auth::id();

        // dd($request->file('pat_photo'));
        $person_seq_count = PatientRegistration::latest('patient_no_pk')->first();
        if (!empty($person_seq_count)) {
            $person_id = "P" . date("dmy") . str_pad(($person_seq_count->patient_no_pk + 1), 4, '0', STR_PAD_LEFT);
        } else {
            $person_id = "P" . date("dmy") . str_pad(1, 4, '0', STR_PAD_LEFT);
        }


        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $gender_txt             = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
        $marital_status_txt     = isset($marital_status[$request->pat_marital_status]) ? $marital_status[$request->pat_marital_status] : '';
        $age = (($request->pat_age_y != "") ? $request->pat_age_y . " Y " : "")  . (($request->pat_age_m != "") ? ", " . $request->pat_age_m . " M " : "") . (($request->pat_age_d != "") ? ", " . $request->pat_age_d . " D " : "");
        $pat_dob = $request->pat_dob;
        $dob =  date("Y-m-d", strtotime($request->pat_dob));
        // dd($dob);
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {


            $data = [
                // 'patient_code'                => $person_id,
                'salutation'                  => $request->pat_salutation,
                'first_name'                  => ucwords($request->pat_f_name),
                'last_name'                   => ucwords($request->pat_l_name),
                'patient_name'                => ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name),
                'age_dd'                      => ($request->pat_age_d == "") ? "01" : $request->pat_age_d,
                'age_mm'                      => ($request->pat_age_m == "") ? "01" : $request->pat_age_m,
                'age_yy'                      => $request->pat_age_y,
                'age'                         => $age,
                'dob'                         => $dob,
                'emergency_contact_addr'      => $request->emergency_contact_address,
                'present_addr'                => $request->present_address,
                'permanent_addr'              => $request->parmanent_address,
                'blood_group'                 => $request->pat_blood_group,
                'national_id'                 => $request->pat_nid,
                'mobile1'                     => $request->mobile_no,
                'mobile2'                     => $request->phone_no,
                'father_name'                 => $request->pat_father,
                'mother_name'                 => $request->pat_mother,
                'spouse_name'                 => $request->pat_spouse,
                'email'                       => $request->pat_email,
                'nationality'                 => $request->pat_nationality,
                'passport_no'                 => $request->pat_passport,
                'gender'                      => $request->pat_gender,
                'gender_txt'                  => $gender_txt,
                'marital_status'              => $request->pat_marital_status,
                'marital_status_txt'          => $marital_status_txt,
                'religion'                    => $request->pat_religion,
                'present_district'            => $request->present_district,
                'permanent_district'          => $request->par_district,
                'pr_addr_thana'               => $request->doctor_pr_thana,
                'pe_addr_thana'               => $request->doctor_pe_thana,
                'pr_addr_country'               => $request->present_country,
                'pe_addr_country'               => $request->parmanent_country,
                'emergency_contact_name'      => $request->emergency_contact_name,
                'relation_lookup_pk_no'       => $request->emergency_contact_relation,
                'emergency_contact_contact'   => $request->emergency_contact_contact,
                'status'                      => $request->status,
                'au_entry_hospital_pk_no'     =>  $hospital_id,
            ];

            if ($id == null) {
                // dd($data);
                $data['au_entry_by'] = $auth_id;
                $data['reg_date']    = date('Y-m-d');
                $data['patient_code']    = $person_id;

                $response = $this->baseRepository->create($data);
                $last_id  = $response->patient_no_pk;

                $image_name = "";
                if ($files = $request->file('pat_photo')) {
                    $image_name = $last_id . "." . $files->getClientOriginalExtension();
                }

                $update_image['patient_photo'] = $image_name;
                $this->baseRepository->update($update_image, $last_id);
            } else {
                $data['au_update_by'] = $auth_id;
                if ($files = $request->file('pat_photo')) {
                    //echo  $id . "." . $files->getClientOriginalExtension();die;
                    $data['patient_photo'] = $id . "." . $files->getClientOriginalExtension();
                }
                $this->baseRepository->update($data, $id);
                $last_id = $id;
                $user_info = [];
                $user_info = [
                    'user_name' => $data['patient_name'],
                    'phone_mobile' => $data['mobile1']
                ];
                DB::table('wsec_user')->where('user_no_pk', $auth_id)->update($user_info);
            }

            if ($files = $request->file('pat_photo')) {
                $this->uploadImages($files, $last_id, 'images/uploads/patient_images/', 'images/uploads/patient_images/thumb/');
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function storeQuickRegisterV1($request)
    {

        //  dd($request->inform);
         $agent_id = 0;
         if($request->inform == 'Marketing Agent'){
            $agent_id = $request->agent_id_hdn;
         }elseif($request->inform == 'Staff'){
            $agent_id = $request->hdn_staff__id;
         }


        $auth_id = Auth::id();
        // $person_seq_count = PatientRegistration::latest('patient_no_pk')->first();
        // $person_id = isset($person_seq_count) ? "PAT-".($person_seq_count->patient_no_pk + 1) : "PAT-". 1;

        $marital_status         = $this->getLookupListByCode("MARSTS");
        $gender                 = $this->getLookupListByCode("GENDER");
        $pat_dob = new Carbon($request->pat_dob);
        $dob = date("Y-m-d", strtotime($pat_dob->toDateString()));

        $marital = $this->getLookupListByCode("MARSTS");
        $gender        = $this->getLookupListByCode("GENDER");
        try {

            $pdo = DB::getPdo();
            $pat_salutation     = $request->pat_salutation;
            $pat_f_name         = ucwords($request->pat_f_name);
            $pat_l_name         = ucwords($request->pat_l_name);
            $patient_name       = ucwords($request->pat_f_name) . ' ' . ucwords($request->pat_l_name);
            $pat_age_y          = $request->pat_age_y ? sprintf("%02d", $request->pat_age_y)  : "";
            $pat_age_m             = $request->pat_age_m ?  sprintf("%02d", $request->pat_age_m) : "";
            $pat_age_d             = $request->pat_age_d ?  sprintf("%02d", $request->pat_age_d)  : "";
            $pat_gender         = $request->pat_gender;
            $gender_txt         = isset($gender[$request->pat_gender]) ? $gender[$request->pat_gender] : '';
            $marital_status     = $request->pat_marital_status;
            $marital_status_txt = isset($marital[$request->pat_marital_status]) ? $marital[$request->pat_marital_status] : '';
            $pat_address        = $request->pat_address;
            $pat_address1       = '';
            $pat_address2       = '';
            $passport_no = $request->passport_no;
            $inform = isset($request->inform) ? $request->inform : '';
            $in_cor_member_no_pk = isset($request->corporate_id) ? $request->corporate_id : '';

            $blood_group         = $request->pat_blood_group;
            $pat_religion         = $request->pat_religion;
            $phone_no             = $request->phone_no;
            $pat_email             = $request->pat_email;
            $patient_type       = isset($request->patienttype) ? $request->patienttype : '0';
            $corporate_id       = isset($request->corporate_name) ? $request->corporate_name : 0;
            $corporate_name = '';
            if ($corporate_id != "") {
                $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }


            //		$patient_type       = 0;

            $appoint_source     = 'WEB';
            $entry_session         = 'session';
            $hospital_id         = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $y = $pat_age_y ? $pat_age_y . " " . "Y " : "";
            $m = $pat_age_m ? "," . $pat_age_m . " " . "M " : "";
            $d = $pat_age_d ? "," . $pat_age_d . " " . "D" : "";
            $age = $y . " " . $m . " " . $d;
            $zero = 0;
            $null = '';
            // OUT PAREMETER INITIALIZE
            $out_patient_no_pk = $out_patient_code = $out_error = "";


            $stmt = $pdo->prepare("begin pkg_patmanagement.prc_quickregistration(:in_salutation,:in_patient_name,:in_phone_mobile,:in_email,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt,:in_religion, :in_address,:in_address1,:in_address2,:in_blood_group,:in_patient_type_no_fk,:in_ccm_client_no_fk,:in_ccm_client_name,:in_passport_no,:in_agent_no_fk,:in_inform_text,:in_cor_member_no_pk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_patient_no_pk,:out_patient_code,:out_error); end;");

            $stmt->bindParam(':in_salutation', $pat_salutation);
            $stmt->bindParam(':in_patient_name', $patient_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_email', $pat_email);
            $stmt->bindParam(':in_dob', $dob);
            $stmt->bindParam(':in_age_dd', $pat_age_d);
            $stmt->bindParam(':in_age_mm', $pat_age_m);
            $stmt->bindParam(':in_age_yy', $pat_age_y);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $pat_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_religion', $pat_religion);
            $stmt->bindParam(':in_address', $pat_address);
            $stmt->bindParam(':in_address1', $pat_address1);
            $stmt->bindParam(':in_address2', $pat_address2);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_passport_no', $passport_no);
            $stmt->bindParam(':in_agent_no_fk', $agent_id);
            $stmt->bindParam(':in_inform_text', $inform);
            $stmt->bindParam(':in_cor_member_no_pk', $in_cor_member_no_pk);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd(  $stmt);
            $stmt->execute();
            DB::commit();
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_code = Session::get('user.ses_hospital_code');
            //billInvoice_wp
            if ($hospital_code == "EWMCH" && $hospital_code == "GMC") {
                $out_invoice_no2 = $out_ledger_no = $out_invoice_no = $out_invoice_id = $out_error = "";
                $pdo = DB::getPdo();
                $billinvoice = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_wp(:in_invoice_date,:in_invoice_datetime,:in_module_no_fk,:in_patient_no_fk,:in_patient_code,:in_admission_no_pk,:in_admission_code,:in_appointment_no_fk,:in_prescription_no_fk,:in_doc_person_no_fk,:in_first_ref_doc,:in_second_ref_doc,:in_report_delivary_date,:in_report_deli_datetime,:in_counter_su_no_fk,:in_cor_client_no_fk,:in_cor_client_card_no_fk,:in_relation_lookup_no_fk,:in_ref_invoice_no_fk,:in_pat_type_lookup_no_fk,:in_dob,:in_age,:in_age_dd,:in_age_mm,:in_age_yy,:in_customer_addr,:in_customer_name,:in_gender_txt,:in_marital_status_txt,:in_blood_group,:in_phone_mobile,:in_invoice_remarks,:in_urgent_fee_total,:in_invoice_type,:in_emergency_ind,:in_daycare_ind,:in_ot_ind,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:in_item_level_disc_ind,:in_item_count,:in_item_no_fk,:in_item_batch_fk,:in_item_expiry_dt,:in_item_name,:in_itemtype_no_fk,:in_item_qty,:in_item_mu,:in_item_rate,:in_item_disc_percent,:in_item_disc_amount,:in_item_vat,:in_urgent_fee,:in_service_charge,:in_report_deli_date,:in_report_deli_time,:in_deli_status_lookup,:in_package_item_ind,:in_item_level_remarks,:in_provider_no_fk,:in_ledgertrn_no,:out_invoice_no,:out_invoice_id,:out_ledgertrn_no,:out_error); end;");
                //Preparating Data
                $cur_date = date("Y-M-d H:i:s");
                $cur_datetime = date("Y-M-d h:i:s");

                $null = '';
                $zero = 0;
                $module_info = DB::table("sysc_module")->where("module_code", "OPD")->select("module_no_pk")->where('au_entry_hospital_pk_no', $hospital_id)->first();
                $module_id = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                $auth_id = Auth::id();
                $entry_session = "Session";
                $hdn_doctor_id = $request->doctor_id;
                $billinvoice->bindParam(':in_invoice_date', $cur_date);
                $billinvoice->bindParam(':in_invoice_datetime', $cur_datetime);
                $billinvoice->bindParam(':in_module_no_fk', $module_id);
                $billinvoice->bindParam(':in_patient_no_fk', $out_patient_no_pk);
                $billinvoice->bindParam(':in_patient_code', $out_patient_no_pk);
                $billinvoice->bindParam(':in_admission_no_pk', $zero);
                $billinvoice->bindParam(':in_admission_code', $null);
                $billinvoice->bindParam(':in_appointment_no_fk', $zero);
                $billinvoice->bindParam(':in_prescription_no_fk', $zero);
                $billinvoice->bindParam(':in_doc_person_no_fk', $zero);
                $billinvoice->bindParam(':in_first_ref_doc', $zero);
                $billinvoice->bindParam(':in_second_ref_doc', $zero);
                $billinvoice->bindParam(':in_report_delivary_date', $cur_date);
                $billinvoice->bindParam(':in_report_deli_datetime', $cur_date);
                $billinvoice->bindParam(':in_counter_su_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_no_fk', $zero);
                $billinvoice->bindParam(':in_cor_client_card_no_fk', $null);
                $billinvoice->bindParam(':in_relation_lookup_no_fk', $null);
                $billinvoice->bindParam(':in_ref_invoice_no_fk', $null);
                $billinvoice->bindParam(':in_pat_type_lookup_no_fk', $zero);
                $billinvoice->bindParam(':in_dob', $cur_date);
                $billinvoice->bindParam(':in_age', $null);
                $billinvoice->bindParam(':in_age_dd', $null);
                $billinvoice->bindParam(':in_age_mm', $null);
                $billinvoice->bindParam(':in_age_yy', $null);
                $billinvoice->bindParam(':in_customer_addr', $null);
                $billinvoice->bindParam(':in_customer_name', $null);

                $billinvoice->bindParam(':in_gender_txt', $null);
                $billinvoice->bindParam(':in_marital_status_txt', $null);
                $billinvoice->bindParam(':in_blood_group', $null);
                $billinvoice->bindParam(':in_phone_mobile', $null);

                $billinvoice->bindParam(':in_invoice_remarks', $null);
                $billinvoice->bindParam(':in_urgent_fee_total', $null);
                $billinvoice->bindParam(':in_invoice_type', $null);
                $billinvoice->bindParam(':in_emergency_ind', $null);
                $billinvoice->bindParam(':in_daycare_ind', $null);
                $billinvoice->bindParam(':in_ot_ind', $null);
                $billinvoice->bindParam(':in_au_entry_by', $auth_id);
                $billinvoice->bindParam(':in_au_entry_session', $entry_session);
                $billinvoice->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $hdn_item_id = [
                    0 => $request->item_no_pk,
                ];
                $batch_no_arr = [
                    0 => '',
                ];
                $expire_dt_arr = [
                    0 => '',
                ];


                $hdn_item_name = [
                    0 => $request->item_name,
                ];
                $hdn_item_type = [
                    0 => $request->item_no_pk,
                ];
                $hdn_item_rate = [
                    0 => $request->sales_price,
                ];
                $item_total = $request->sales_price;
                $hdn_item_qnty = [
                    0 => 1,
                ];
                $item_mu_arr = $in_package_item_ind = $package_ind_arr = [
                    0 => 0,
                ];
                $item_level_remarks = $deli_dt_arr = $deli_dt_arr =$provider_no = [
                    0 => '',
                ];
                $item_delivery_status_arr = $item_disc_percent =  $item_disc_amount = $item_vat_prse = $hdn_item_urgent_fee_amt = [
                    0 => 0,
                ];
                $numelems = 5000;
                $total_item = count($hdn_item_id);
                $billinvoice->bindParam(':in_item_level_disc_ind', $zero);
                $billinvoice->bindParam(':in_item_count', $total_item);
                $billinvoice->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_batch_fk', $batch_no_arr, count($batch_no_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_expiry_dt', $expire_dt_arr, count($expire_dt_arr), $numelems, SQLT_CHR);

                $billinvoice->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_mu', $item_mu_arr, count($item_mu_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_percent', $item_disc_percent, count($item_disc_percent), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_disc_amount', $item_disc_amount, count($item_disc_amount), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_urgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                $billinvoice->bindArray(':in_service_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);

                $billinvoice->bindArray(':in_report_deli_date', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_report_deli_time', $deli_dt_arr, count($deli_dt_arr), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_deli_status_lookup', $item_delivery_status_arr, count($item_delivery_status_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                $billinvoice->bindArray(':in_item_level_remarks', $item_level_remarks, count($item_level_remarks), $numelems, SQLT_CHR);
                $billinvoice->bindArray(':in_provider_no_fk', $provider_no, count($provider_no), $numelems, SQLT_INT);
                $in_ledgertrn_no = $out_ledgertrn_no = "";
                $billinvoice->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);

                $billinvoice->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                $billinvoice->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
                $billinvoice->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);


                $billinvoice->execute();
                $out_invoice_no1  = $out_invoice_no;

                if ($out_error == 999) {
                    // dd($out_error);
                    DB::rollback();
                    $message = ['msg' => 'Bill create Failled.' . $out_error, 'title' => 'Error',];
                } else {

                    $pdo1 = DB::getPdo();

                    $billpayment = $pdo1->prepare("begin pkg_billing_v0.prc_billpayment_wp(
                     :in_payment_date,
                     :in_payment_datetime,
                     :in_invoice_no_fk,
                     :in_module_no_fk,
                     :in_patient_no_fk,
                     :in_admission_no_fk,
                     :in_prescription_no_fk,
                     :in_counter_su_no_fk,
                     :in_ledger_amt_sales,
                     :in_ledger_amt_payment,
                     :in_ledger_amt_discount,
                     :in_urgent_fee,
                     :in_service_charge,
                     :in_cor_client_no_fk,
                     :in_pay_mode,
                     :in_pay_cqcc_holder_name,
                     :in_pay_cqcc_number,
                     :in_pay_cqcc_deduct_percent,
                     :in_pay_bank_name,
                     :in_pay_remarks,
                     :in_given_amt,
                     :in_disc_type_lookup_no_fk,
                     :in_disc_remarks,
                     :in_disc_amt_by_doc,
                     :in_disc_amt_by_doc_no_fk,
                     :in_disc_amt_by_hosp,
                     :in_disc_amt_by_hosp_auth_by,
                     :in_disc_amt_request_by_name,
                     :in_au_entry_by,
                     :in_au_entry_session,
                     :in_au_entry_hospital_pk_no,
                     :in_item_count,
                     :in_item_no_fk,
                     :in_item_name,
                     :in_itemtype_no_fk,
                     :in_item_qty,
                     :in_item_rate,
                     :in_item_vat,
                     :in_itemurgent_fee,
                     :in_itemservice_charge,
                     :in_package_item_ind,
                     :in_ledgertrn_no,
                     :out_invoice_no,
                     :out_invoice_id,
                     :out_ledgertrn_no,
                     :out_ledger_no,
                     :out_error);
                     end;");

                    // :in_paymood,
                    // :in_pay_mood_type,
                    // :in_bank_name,
                    // :in_transaction_id,
                    // :in_bank_card_no,
                    // :in_acc_holder_name,
                    // :in_payment_amt,
                    // :in_paymood_count,

                    $item_default_discont = DB::table('sysc_serviceitem_vw')->where('item_no_pk', $request->item_no_pk)->first();
                    $discount = $item_default_discont->default_discount != "" ? $item_default_discont->default_discount : 0;
                    $corporate_id =  isset($corporate_id) ? $corporate_id : 0;
                    $def_dis = DB::select(DB::raw("select pkg_corporate.fnc_get_item_discount($request->item_no_pk,'$patient_type',$corporate_id, $item_total,0,$discount,'PCT') as def_discount from dual"));
                    $pay_mode = [0 => 'CASH'];
                    $pay_mode1 = 'CASH';
                    $discount = isset($def_dis[0]->def_discount) ?  $def_dis[0]->def_discount : 0;
                    $payment_amount =  $item_total -  $item_total * ($discount / 100);
                    $discount =  $item_total * ($discount / 100);
                    $billpayment->bindParam(':in_payment_date', $cur_date);
                    $billpayment->bindParam(':in_payment_datetime', $cur_datetime);
                    $billpayment->bindParam(':in_invoice_no_fk', $out_invoice_no);
                    $billpayment->bindParam(':in_module_no_fk', $module_id);
                    $billpayment->bindParam(':in_patient_no_fk', $out_patient_no_pk);
                    $billpayment->bindParam(':in_admission_no_fk', $zero);
                    $billpayment->bindParam(':in_prescription_no_fk', $zero);
                    $billpayment->bindParam(':in_counter_su_no_fk', $module_id);
                    $billpayment->bindParam(':in_ledger_amt_sales', $item_total);
                    $billpayment->bindParam(':in_ledger_amt_payment', $item_total);
                    $billpayment->bindParam(':in_ledger_amt_discount', $discount);
                    $billpayment->bindParam(':in_urgent_fee', $zero);
                    $billpayment->bindParam(':in_service_charge', $zero);
                    $billpayment->bindParam(':in_cor_client_no_fk', $zero);
                    $billpayment->bindParam(':in_pay_mode', $pay_mode1);
                    $billpayment->bindParam(':in_pay_cqcc_holder_name', $null);
                    $billpayment->bindParam(':in_pay_cqcc_number', $null);
                    $billpayment->bindParam(':in_pay_cqcc_deduct_percent', $zero);
                    $billpayment->bindParam(':in_pay_bank_name', $null);
                    $billpayment->bindParam(':in_pay_remarks', $null);
                    $billpayment->bindParam(':in_given_amt', $item_total);

                    // DISCOUNT COLUMN PREPARATION START

                    $doctor_disc_amt = $doctor_id_for_disc = $hospital_disc_amt = 0;


                    //dd($in_paymood_arr);
                    // DISCOUNT COLUMN PREPARATION END
                    $lookupdata_no_pk = !empty($discount_info) ? $discount_info->lookupdata_no_pk : 0;
                    $billpayment->bindParam(':in_disc_type_lookup_no_fk', $lookupdata_no_pk);
                    $billpayment->bindParam(':in_disc_remarks', $null);
                    $billpayment->bindParam(':in_disc_amt_by_doc', $doctor_disc_amt);
                    $billpayment->bindParam(':in_disc_amt_by_doc_no_fk', $doctor_id_for_disc);
                    $billpayment->bindParam(':in_disc_amt_by_hosp', $hospital_disc_amt);
                    $billpayment->bindParam(':in_disc_amt_by_hosp_auth_by', $auth_id); // will be adjust later
                    $billpayment->bindParam(':in_disc_amt_request_by_name', $null);

                    $billpayment->bindParam(':in_au_entry_by', $auth_id);
                    $billpayment->bindParam(':in_au_entry_session', $entry_session);
                    $billpayment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                    $billpayment->bindParam(':in_item_count', $total_item);
                    $billpayment->bindArray(':in_item_no_fk', $hdn_item_id, count($hdn_item_id), $numelems, SQLT_INT);
                    $billpayment->bindArray(':in_item_name', $hdn_item_name, count($hdn_item_name), $numelems, SQLT_CHR);
                    $billpayment->bindArray(':in_itemtype_no_fk', $hdn_item_type, count($hdn_item_type), $numelems, SQLT_INT);
                    $billpayment->bindArray(':in_item_qty', $hdn_item_qnty, count($hdn_item_qnty), $numelems, SQLT_FLT);
                    $billpayment->bindArray(':in_item_rate', $hdn_item_rate, count($hdn_item_rate), $numelems, SQLT_FLT);
                    $billpayment->bindArray(':in_item_vat', $item_vat_prse, count($item_vat_prse), $numelems, SQLT_FLT);
                    $billpayment->bindArray(':in_itemurgent_fee', $hdn_item_urgent_fee_amt, count($hdn_item_urgent_fee_amt), $numelems, SQLT_FLT);
                    $billpayment->bindArray(':in_itemservice_charge', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_FLT);
                    $billpayment->bindArray(':in_package_item_ind', $package_ind_arr, count($package_ind_arr), $numelems, SQLT_INT);
                    $out_ledgertrn_no2 = "";
                    $billpayment->bindParam(':in_ledgertrn_no', $out_ledgertrn_no);
                    $billpayment->bindParam(':out_invoice_no', $out_invoice_no2, PDO::PARAM_INT);
                    $billpayment->bindParam(':out_invoice_id', $null, PDO::PARAM_STR, 500);
                    $billpayment->bindParam(':out_ledgertrn_no', $out_ledgertrn_no2, PDO::PARAM_INT);
                    $billpayment->bindParam(':out_ledger_no', $out_ledger_no, PDO::PARAM_INT);
                    $billpayment->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                    $billpayment->execute();

                    if ($out_error == 999) {
                        DB::rollback();
                        $message = ['msg' => 'Bill create Failled.', 'title' => 'Error'];
                    } else {


                        $paymood_count = (!empty($request->pay_method_mode) ? count($request->pay_method_mode) : 0);
                        // dd($paymood_count);
                        //$query = DB::table('finc_ledgermst')->select('ledger_no_pk', 'invoice_no_fk')->where('ledger_no_pk', $out_ledger_no)->first();


                        $auth_id = Auth::id();

                        $date = date('Y-m-d');
                        $in_paymood_arr_t = $request->pay_method_mode;
                        $in_pay_mood_type_arr_t = $request->mBank_types;
                        $in_bank_name_arr_t = $request->pay_bank_name;
                        $in_transaction_id_arr_t = $request->trans_id_no;
                        $in_bank_card_no_arr_t = $request->card_number;
                        $in_acc_holder_name_arr_t = $request->acc_holder_name;
                        $in_payment_amt_arr_t = $request->total_amt;
                        $in_paymood_count = $paymood_count;
                        $in_au_entry_by = $auth_id;
                        $in_au_entry_session = "session";
                        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
                        $invoice_no = $out_invoice_no;
                        $ledger_no = $out_ledger_no;


                        $i = 0;
                        if (!empty($in_paymood_arr_t)) {
                            foreach ($in_paymood_arr_t as $key => $value) {

                                $sc_date = date("d-m-Y");


                                $in_paymood_arr_val[$i] = (!empty($value) ? $value : "");
                                $in_pay_mood_type_arr_val[$i] = (!empty($in_pay_mood_type_arr_t[$i]) ? $in_pay_mood_type_arr_t[$i] : "");
                                $in_bank_name_arr_val[$i] = (!empty($in_bank_name_arr_t[$i]) ? $in_bank_name_arr_t[$i] : "");
                                $in_transaction_id_arr_val[$i] = (!empty($in_transaction_id_arr_t[$i]) ? $in_transaction_id_arr_t[$i] : "");
                                $in_bank_card_no_arr_val[$i] = (!empty($in_bank_card_no_arr_t[$i]) ? $in_bank_card_no_arr_t[$i] : "");
                                $in_acc_holder_name_arr_val[$i] = (!empty($in_acc_holder_name_arr_t[$i]) ? $in_acc_holder_name_arr_t[$i] : "");
                                $in_payment_amt_arr_val[$i] = (!empty($in_payment_amt_arr_t[$i]) ? $in_payment_amt_arr_t[$i] : "");

                                $i++;
                            }
                        }
                        $in_paymood_arr = (!empty($in_paymood_arr_t) ? count($in_paymood_arr_t) : 1);
                        $in_pay_mood_type_arr = (!empty($in_pay_mood_type_arr_t) ? count($in_pay_mood_type_arr_t) : 1);
                        $in_bank_name_arr = (!empty($in_bank_name_arr_t) ? count($in_bank_name_arr_t) : 1);
                        $in_transaction_id_arr = (!empty($in_transaction_id_arr_t) ? count($in_transaction_id_arr_t) : 1);
                        $in_bank_card_no_arr = (!empty($in_bank_card_no_arr_t) ? count($in_bank_card_no_arr_t) : 1);
                        $in_acc_holder_name_arr = (!empty($in_acc_holder_name_arr_t) ? count($in_acc_holder_name_arr_t) : 1);
                        $in_payment_amt_arr = (!empty($in_payment_amt_arr_t) ? count($in_payment_amt_arr_t) : 1);

                        // dd($in_paymood_arr_val,$in_pay_mood_type_arr_val, $in_bank_name_arr_val, $in_transaction_id_arr_val,$in_bank_card_no_arr_val, $in_acc_holder_name_arr_val, $in_payment_amt_arr_val);

                        $out_invoice_no3 = $out_ledger_no3 = $out_error = "";
                        $pdo2 = DB::getPdo();
                        $finc_ledger_paymood = $pdo2->prepare("begin pkg_billing.prc_finc_ledger_paymood(
                        :in_payment_date,
                        :in_invoice_no_fk,
                        :in_ledger_no_fk,
                        :in_paymood,
                        :in_pay_mood_type,
                        :in_bank_name,
                        :in_transaction_id,
                        :in_bank_card_no,
                        :in_acc_holder_name,
                        :in_payment_amt,
                        :in_paymood_count,
                        :in_au_entry_by ,
                        :in_au_entry_session ,
                        :in_au_entry_hospital_pk_no ,
                        :out_error);
                        end;");
                        if (!empty($pay_mode)) {
                            for ($i = 0; $i < count($pay_mode); $i++) {
                                $in_paymood_arr_val[$i] = $pay_mode[$i];
                                $in_pay_mood_type_arr_val[$i] = '';
                                $in_bank_name_arr_val[$i] = '';
                                $in_transaction_id_arr_val[$i] = '';
                                $in_bank_card_no_arr_val[$i] = '';
                                $in_acc_holder_name_arr_val[$i] = '';
                                $in_payment_amt_arr_val[$i] = $item_total;
                            }
                        }
                        //dd($pay_mode, $in_payment_amt_arr_val);
                        $in_paymood_count = count($in_paymood_arr_val);

                        $finc_ledger_paymood->bindParam(':in_payment_date', $date);
                        $finc_ledger_paymood->bindParam(':in_invoice_no_fk', $invoice_no);
                        $finc_ledger_paymood->bindParam(':in_ledger_no_fk', $ledger_no);
                        $finc_ledger_paymood->bindArray(':in_paymood', $in_paymood_arr_val, $in_paymood_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_pay_mood_type', $in_pay_mood_type_arr_val, $in_pay_mood_type_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_bank_name', $in_bank_name_arr_val, $in_bank_name_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_transaction_id', $in_transaction_id_arr_val, $in_transaction_id_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_bank_card_no', $in_bank_card_no_arr_val, $in_bank_card_no_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_acc_holder_name', $in_acc_holder_name_arr_val, $in_acc_holder_name_arr, $numelems, SQLT_CHR);
                        $finc_ledger_paymood->bindArray(':in_payment_amt', $in_payment_amt_arr_val, $in_payment_amt_arr, $numelems, SQLT_FLT);
                        $finc_ledger_paymood->bindParam(':in_paymood_count', $in_paymood_count);
                        $finc_ledger_paymood->bindParam(':in_au_entry_by', $in_au_entry_by);
                        $finc_ledger_paymood->bindParam(':in_au_entry_session', $in_au_entry_session);
                        $finc_ledger_paymood->bindParam(':in_au_entry_hospital_pk_no', $in_au_entry_hospital_pk_no);
                        $finc_ledger_paymood->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                        $finc_ledger_paymood->execute();

                        if ($out_error == 999) {
                            DB::rollback();
                            $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
                        } else {
                            DB::commit();
                            $message = ['msg' => 'New Bill created successfully.Invoice ID = ' . $out_invoice_no, 'title' => 'Success', 'insert_id' => $out_invoice_no2];
                        }
                    }
                }
            }

            $patient_type = DB::table('pat_registration_wl_vw reg')
                ->select('pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'reg.ccm_client_name', 'reg.ccm_client_no_fk', 'reg.contact_person', 'reg.contact_no')
                ->where('reg.patient_no_pk', $out_patient_no_pk)
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'reg.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'reg.patient_type')
                ->first();
            //return $stmt;


            $address_data = [
                'present_addr' => $request->pat_address,
                'patient_area_no_fk' => $request->hdn_area_code,
                'patient_area_name' => $request->hdn_area_name
            ];
            DB::table('patn_registration')->where('patient_no_pk', $out_patient_no_pk)->update($address_data);


            // End

            return [
                'msg' => 'Data Saved Successfully',
                'insert_id' => $out_patient_no_pk,
                'patient_code' => $out_patient_code,
                'patient_name' => $patient_name,
                'gender' => $gender_txt,
                'age' => $age,
                'phone_mobile' => $phone_no,
                'patient_type_code' => $patient_type->patient_type_code,
                'maximum_percent' => $patient_type->maximum_percent != "" ? $patient_type->maximum_percent : "",
                'patient_type_no_pk' => $patient_type->patient_type_no_pk,
                'item_level_disc_ind' => $patient_type->item_level_disc_ind,
                'ccm_client_no_fk' => $patient_type->ccm_client_no_fk,
                'ccm_client_name' => $patient_type->ccm_client_name,
                'contact_person' => $patient_type->contact_person,
                'contact_no' => $patient_type->contact_no,
                'invoice_no' => isset($out_invoice_no1) ? $out_invoice_no1 : 0
            ];
        } catch (\Exception $e) {
            //return response()->json(['msg' => $e->getMessage()],406);

        }
    }
}
