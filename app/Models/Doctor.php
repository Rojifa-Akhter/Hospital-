<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table        = 'hrms_personnel';
    protected $primaryKey   = 'person_no_pk';
    public $sequence        = 'sysc_doctor_no_pk_seq';


    public function setDobAttribute($value)
    {
        $this->attributes['DOB'] = date('Y-m-d H:i:s', strtotime($value));
    }
    public function setRegDateAttribute($value)
    {
        $this->attributes['join_date'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Get the phone record associated with the user.
     */
    public function user()
    {
        return $this->hasOne('App\Models\Users', 'person_no_fk', 'person_no_pk');
    }

    //public $incrementing = false;
    // timestamp associate with it
    protected $guarded = ['person_no_pk'];
    protected $fillable = ['remarks_text', 'chamber_hospital_no_pk', 'salutation', 'person_code', 'full_name', 'fname', 'lname', 'gender_lookup_no_fk', 'phone_mobile', 'email_personal', 'pe_addr1', 'specialization_lookup_no_fk', 'referral_agent_ind', 'degree1', 'degree2', 'degree3','au_entry_hospital_pk_no', 'degree4', 'doctor_signature', 'photo_name', 'license_number', 'license_issue_date', 'doctor_ind', 'user_type','referal_ind','au_entry_by','doctor_signature_image','inv_director_admin_ind','inv_director_acc_ind','inv_gen_man_proc_ind','inv_manager_acc_ind','inv_proc_ind','inv_store_ind','ref_agent_person_no_fk','internal_doctor_ind','external_doctor_ind','emp_serial_in_salary_sheet', 'emp_status'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
