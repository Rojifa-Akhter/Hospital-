<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PatientRegistration extends Authenticatable
{
    protected $table        = 'patn_registration';
    protected $primaryKey   = 'patient_no_pk';
    public $sequence        = 'sysc_reg_patient_no_pk_seq';

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mobile1;
    }

    public function setDobAttribute($value)
    {
        $this->attributes['DOB'] = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setRegDateAttribute($value)
    {
        $this->attributes['REG_DATE'] = date('Y-m-d H:i:s', strtotime($value));
    }

    public function getGenderName()
    {
        return $this->belongsTo('App\LookupItem', 'pay_source_pk_no');
    }

    public static function getPatientWithPersonnel($id)
    {
        return DB::table('patn_registration')
            ->leftJoin('HRMS_PERSONNEL', 'patn_registration.ref_person_no_fk', '=', 'HRMS_PERSONNEL.PERSON_NO_PK')
            ->select('patn_registration.*', 'HRMS_PERSONNEL.full_name')
            ->where('patn_registration.patient_no_pk', $id)
            ->get();
    }
    //public $incrementing = false;
    // timestamp associate with it
    protected $guarded = ['PATIENT_NO_PK'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_entry_hospital_pk_no', 'patient_code',
                            'salutation', 'first_name', 'last_name',
                            'patient_name', 'age_dd', 'age_mm', 
                            'age_yy', 'age', 'dob', 
                            'emergency_contact_addr', 
                            'present_addr', 'permanent_addr', 
                            'blood_group', 'national_id', 
                            'mobile1', 'mobile2', 
                            'father_name', 'mother_name', 
                            'spouse_name', 'email', 
                            'nationality', 'passport_no', 
                            'gender', 'gender_txt', 
                            'marital_status', 'marital_status_txt', 
                            'religion', 'present_district', 
                            'permanent_district', 'emergency_contact_name', 
                            'relation_lookup_pk_no', 'emergency_contact_contact', 
                            'status', 'au_entry_by', 'reg_date', 
                            'pat_photo', 'au_update_by', 'pr_addr_thana', 
                            'pe_addr_thana', 'pr_addr_country', 'pe_addr_country', 
                            'patient_photo', 'patient_type','ccm_client_no_fk',
                           'ccm_client_name','occupation','inform_text',
                           'agent_no_fk','cor_member_no_pk', 'oi_health_ins', 
                           'oi_ins_comp_name', 'oi_locar_guardian', 
                           'oi_relation_with_guar', 'oi_guar_mobile_no', 
                           'fi_passport_no', 'fi_visa_no', 'fi_visa_validity', 
                           'fi_visa_type','membershid_id','cardnumber',
                           'membership_organization_name','currentdesignationname',
                           'pat_relation_name_stf_oth','ref_person_no_fk'];
}
