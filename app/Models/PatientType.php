<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientType extends Model
{
    protected $table        = 'PATN_PATIENTTYPE';
    protected $primaryKey   = 'PATIENT_TYPE_NO_PK';
    public $sequence        = 'PATIENT_TYPE_NO_PK_seq';


    protected $guarded = ['patient_type_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = [
        'patient_type_no_pk', 'patient_type_code', 'patient_type_desc', 'discountpolicy_no_fk', 'lookupdata_no_fk', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at'
    ];
}