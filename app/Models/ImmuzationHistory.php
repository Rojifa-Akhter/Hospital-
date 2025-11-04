<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmuzationHistory extends Model
{
     protected $table        = 'emr_patimmunization';
    protected $primaryKey   = 'immunization_no_pk';
    public $sequence        = 'emr_patimmunization_seq';


    protected $guarded = ['immunization_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['au_entry_at',
'au_entry_by',
'au_entry_hospital_no_fk',
'au_entry_session',
'au_sync_at',
'au_sync_hospital_no_fk',
'au_update_at',
'au_update_by',
'au_update_hospital_no_fk',
'au_update_session',
'dose_number',
'immunization_end_date',
'immunization_name',
'immunization_no_pk',
'immunization_start_date',
'immunization_uid',
'patient_no_fk',
'service_number',
'status'];
}
