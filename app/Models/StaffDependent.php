<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDependent extends Model
{
    protected $table = 'CCM_CorporateStaff_dep';
    protected $primaryKey = 'ccm_staffdep_no_pk';
    public $sequence = 'ccm_staffdep_no_pk_seq';

    protected $guarded = ['ccm_staffdep_no_pk'];
    protected $fillable = [
        'ccm_staffdep_no_pk',
        'patient_no_fk' ,
        'ccm_staff_no_fk',
        'ccm_patient_name',
        'ccm_dep_dob',
        'ccm_patient_relation' ,
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
