<?php

namespace App\Core\HospitalCore\PatientRegistration;

use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Core\HospitalCore\PatientRegistration\PatientRegistrationContract;

class PatientRegistrationDetails implements PatientRegistrationContract
{
    use LookupData, UtilitiesTrait;

    public function create_patient() {
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $religion = $this->getLookupListByCode("RELIGION");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $relation = $this->getLookupListByCode("RELATION");
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $occupation = $this->getLookupListByCode("OCCUPATION");
        $patidentity = $this->getLookupListByCode("PATIDENTITY");
        $guardianship = $this->getLookupListByCode("GUARDIANSHIP");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $country =  DB::table('sysc_country')->where('status', 1)->get();
        $divisions =  DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        $district =  DB::table('sysc_district')->where('division_id', 6)->orderBy('name','asc')->get();
        $thanas =  DB::table('sysc_upazilas')->where('district_id', 47)->orderBy('name','asc')->get();
        $pat_type =  DB::table('patn_patienttype')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $payer_data = DB::table('ccm_corporateclient')->where('direct_pat_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        $sponser_data = DB::table('ccm_corporateclient')->where('sponser_ind', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();

        return [
            'thanas'=>$thanas,
            'district'=>$district,
            'divisions'=>$divisions,
            'marital_status' => $marital_status, 
            'gender' => $gender, 
            'religion' => $religion, 
            'bloodg' => $bloodg, 
            'relation' => $relation, 
            'page_type' => 'add', 
            'nationality' => $nationality, 
            'district' => $district, 
            'name_prefix' => $name_prefix, 
            'patient_type' => $patient_type, 
            'corporate_info' => $corporate_info, 
            'country' => $country, 
            'occupation' => $occupation, 
            'guardianship' => $guardianship, 
            'patidentity' => $patidentity, 
            'pat_type' => $pat_type, 
            'payer_data' => $payer_data, 
            'sponser_data' => $sponser_data
        ];
    }

    public function save_patient(array $data) {
        $pdo = DB::getPdo();
            $pat_salutation     = '';
            $corporate_id = $data['corporate_id'];
            $corporate_name = '';
            if ($corporate_id != "") {
                $corporate = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->get();
                $corporate_name = $corporate[0]->ccm_client_name;
            }


            //		$patient_type       = 0;


            $out_patient_no_pk = $out_patient_code = $out_error = "";

            $appoint_source     = $data['appoint_source'];
            $entry_session         = $data['entry_session'];
            $hospital_id         = $data['hospital_id'];
            $is_pay_consultation = $data['is_pay_consultation'];
            $dob =  $data['patient_dob'];
            $patient_name =  $data['full_name'];
            $pat_email =  $data['in_email'];
            $pat_age_d =  $data['pat_age_d'];
            $pat_age_m =  $data['pat_age_m'];
            $pat_age_y =  $data['pat_age_y'];
            $age =  $data['pat_age_y'];
            $patient_dob = $data['patient_dob'];
            $temp = $data['temp'];
            $patient_gender  = $data['patient_gender'];
            $gender_txt  = $data['gender_txt'];
            $temp = ['temp'];
            $marital_status = $data['marital_status'];
            $marital_status_txt = $data['marital_status_txt'];
            $phone_no =  $data['mobile'];
            $pat_religion =  $data['religion'];
            $pat_address =  $data['pat_address'];
            $pat_address1 =  $pat_address2 = '';
            $blood_group =  $data['blood_group'];
            $patient_type =  $data['reg_type'];
            $phone_no =  $data['mobile'];
            $zero = $data['zero'];
            $null = $data['null'];

            $in_father_name = $data['in_father_name'];
            $in_mother_name = $data['in_mother_name'];
            $in_spouse_name = $data['in_spouse_name'];
            $in_national_id = $data['in_national_id'];

            $in_pr_addr_thana = $data['in_pr_addr_thana'];
            $in_present_district = $data['in_present_district'];
            $in_present_post_code = $data['in_present_post_code'];
            $in_pr_addr_country = $data['in_pr_addr_country'];
            $in_permanent_addr = $data['in_permanent_addr'];
            $in_permanent_district = $data['in_permanent_district'];
            $in_pe_addr_country = $data['in_pe_addr_country'];
            $in_emergency_contact_name = $data['emr_name'];
            $in_emergency_contact_relation = $data['in_emergency_contact_relation'];
            $in_emergency_contact_contact = $data['in_emergency_contact_contact'];
            $in_payer_type_code = $data['payer_type'];
            $in_occupation = $data['in_occupation'];
            $in_vip_ind = $data['in_occupation'];
            $in_vip_narration = $data['in_vip_narration'];
            $in_reg_remarks = $data['in_reg_remarks'];
            $in_last_edit_reason = $data['in_last_edit_reason'];
            $passport_no = $data['passport_id'];
            $in_mobile2_alt = $data['in_mobile2_alt'];
            $hdn_patient_id = $data['hdn_patient_id'];
            $hdn_doctor_id = $data['hdn_doctor_id'];
            $realation_pat = $data['realation_pat'];
            $auth_id = $data['auth_id'];

            $imageName = $data['imageName'];

            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_patregistration(
                :in_salutation,
                :in_patient_name,
                :in_phone_mobile,
                :in_mobile2_alt,
                :in_email  ,
                :in_dob    ,
                :in_age_dd ,
                :in_age_mm ,
                :in_age_yy ,
                :in_age    ,
                :in_gender ,
                :in_gender_txt,
                :in_marital_status    ,
                :in_marital_status_txt,
                :in_religion  ,
                :in_address   ,
                :in_address1  ,
                :in_address2  ,
                :in_blood_group ,
                :in_patient_type_no_fk,
                :in_ref_patient_no_fk ,
                :in_ref_person_no_fk  ,
                :in_ref_person_no_fk_rel ,
                :in_father_name,
                :in_mother_name ,
                :in_spouse_name ,
                :in_national_id,
                :in_present_addr,
                :in_pr_addr_thana     ,
                :in_present_district  ,
                :in_present_post_code ,
                :in_pr_addr_country   ,
                :in_permanent_addr	,
                :in_pe_addr_thana	,
                :in_permanent_district	,
                :in_permanent_post_code 	,
                :in_pe_addr_country	 ,
                :in_emergency_contact_name	,
                :in_emergency_contact_addr	 ,
                :in_emergency_contact_relation	,
                :in_emergency_contact_contact	,
                :in_payer_type_code ,
                :in_occupation	 ,
                :in_vip_ind ,
                :in_vip_narration ,
                :in_last_edit_reason ,
                :in_reg_remarks ,
                :in_ccm_client_no_fk ,
                :in_ccm_client_name  ,
                :in_passport_no ,
                :in_patient_photo ,
                :in_au_entry_by ,
                :in_au_entry_session  ,
                :in_au_entry_hospital_pk_no ,
                :out_patient_no_pk,
                :out_patient_code ,
                :out_error
            ); end;");

            $stmt->bindParam(':in_salutation', $pat_salutation);
            $stmt->bindParam(':in_patient_name', $patient_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_mobile2_alt', $in_mobile2_alt);
            $stmt->bindParam(':in_email', $pat_email);
            $stmt->bindParam(':in_dob', $patient_dob);
            $stmt->bindParam(':in_age_dd', $pat_age_d);
            $stmt->bindParam(':in_age_mm', $pat_age_m);
            $stmt->bindParam(':in_age_yy', $pat_age_y);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $patient_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_religion', $pat_religion);
            $stmt->bindParam(':in_address', $pat_address);
            $stmt->bindParam(':in_address1', $pat_address1);
            $stmt->bindParam(':in_address2', $pat_address2);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_ref_patient_no_fk', $hdn_patient_id);
            $stmt->bindParam(':in_ref_person_no_fk', $hdn_doctor_id);
            $stmt->bindParam(':in_ref_person_no_fk_rel', $realation_pat);
            $stmt->bindParam(':in_father_name', $in_father_name);
            $stmt->bindParam(':in_mother_name', $in_mother_name);
            $stmt->bindParam(':in_spouse_name', $in_spouse_name);
            $stmt->bindParam(':in_national_id', $in_national_id);
            $stmt->bindParam(':in_present_addr', $pat_address);
            $stmt->bindParam(':in_pr_addr_thana', $in_pr_addr_thana);
            $stmt->bindParam(':in_present_district', $in_present_district);
            $stmt->bindParam(':in_present_post_code', $in_present_post_code);
            $stmt->bindParam(':in_pr_addr_country', $in_pr_addr_country);
            $stmt->bindParam(':in_permanent_addr', $in_permanent_addr);
            $stmt->bindParam(':in_pe_addr_thana', $zero);
            $stmt->bindParam(':in_permanent_district', $in_permanent_district);
            $stmt->bindParam(':in_permanent_post_code', $zero);
            $stmt->bindParam(':in_pe_addr_country', $in_pe_addr_country);
            $stmt->bindParam(':in_emergency_contact_name', $in_emergency_contact_name);
            $stmt->bindParam(':in_emergency_contact_addr', $null);
            $stmt->bindParam(':in_emergency_contact_relation', $in_emergency_contact_relation);
            $stmt->bindParam(':in_emergency_contact_contact', $in_emergency_contact_contact);
            $stmt->bindParam(':in_payer_type_code', $in_payer_type_code);
            $stmt->bindParam(':in_occupation', $in_occupation);
            $stmt->bindParam(':in_vip_ind', $in_vip_ind);
            $stmt->bindParam(':in_vip_narration', $in_vip_narration);
            $stmt->bindParam(':in_last_edit_reason', $in_last_edit_reason);
            $stmt->bindParam(':in_reg_remarks', $in_reg_remarks);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_passport_no', $passport_no);
            $stmt->bindParam(':in_patient_photo', $imageName);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_patient_code', $out_patient_code, PDO::PARAM_STR, 500);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

            $stmt->execute();
            DB::commit();
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $hospital_code = Session::get('user.ses_hospital_code');
            //billInvoice_wp

            $patient_type = DB::table('pat_registration_wl_vw reg')
                ->select('pt.patient_type_code', 'ptv.maximum_percent', 'ptv.patient_type_no_pk', 'ptv.item_level_disc_ind', 'reg.ccm_client_name', 'reg.ccm_client_no_fk', 'reg.contact_person', 'reg.contact_no')
                ->where('reg.patient_no_pk', $out_patient_no_pk)
                ->leftJoin('patn_patienttype_vw ptv', 'ptv.patient_type_no_pk', '=', 'reg.patient_type')
                ->join('patn_patienttype pt', 'pt.patient_type_no_pk', '=', 'reg.patient_type')
                ->first();
            //return $stmt;


            $address_data = [
                'present_addr' => $data['pat_address'],
                'patient_area_no_fk' => $data['hdn_area_code'],
                'patient_area_name' => $data['hdn_area_name']
            ];

            DB::table('patn_registration')->where('patient_no_pk', $out_patient_no_pk)->update($address_data);


            return [
                'msg' => 'Data Saved Successfully',
                'insert_id' => $out_patient_no_pk,
                'patient_code' => $out_patient_code,
                'patient_name' => $patient_name,
                'gender' => $gender_txt,
                'age' => $age,
                'phone_mobile' => $phone_no,
                'patient_type_code' => isset($patient_type->patient_type_code) ? $patient_type->patient_type_code : '',
                'maximum_percent' => $patient_type->maximum_percent != "" ? $patient_type->maximum_percent : "",
                'patient_type_no_pk' => $patient_type->patient_type_no_pk,
                'item_level_disc_ind' => $patient_type->item_level_disc_ind,
                'ccm_client_no_fk' => $patient_type->ccm_client_no_fk,
                'ccm_client_name' => $patient_type->ccm_client_name,
                'contact_person' => $patient_type->contact_person,
                'contact_no' => $patient_type->contact_no,
                'invoice_no' => isset($out_invoice_no1) ? $out_invoice_no1 : 0
            ];
    }

    public function update_patient(array $data) {

    }

}