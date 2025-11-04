<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateStaff extends Model
{
    protected $table = 'CCM_CorporateStaff';
    protected $primaryKey = 'ccm_staff_no_pk';
    public $sequence = 'ccm_staff_no_pk_seq';

    protected $guarded = ['ccm_staff_no_pk'];
    protected $fillable = [
        'ccm_staff_no_pk',
        'ccm_company_id' ,
        'ccm_company_name',
        'ccm_contact_person',
        'ccm_contact_number',
        'ccm_staff_id' ,
        'ccm_staff_name',
        'ccm_designation_no_fk',
        'ccm_staff_contact' ,
        'ccm_staff_email' ,
        'ccm_patient_no_fk',
        'ccm_staff_dob' ,
        'ccm_gender_no_fk' ,
        'ccm_age',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
