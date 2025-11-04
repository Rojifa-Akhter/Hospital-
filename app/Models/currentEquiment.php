<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class currentEquiment extends Model
{
    protected $table        = 'emr_medicalequipment';
	protected $primaryKey   = 'medequ_no_pk';
	public $sequence        = 'emr_medicalequipment_seq';

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

	 protected $fillable = [
        'medequ_no_pk',
        'medequ_uid',
        'medequ_name',
        'medequ_start_date',
        'start_time_of_engage',
        'medequ_end_date',
        'end_time_of_engage',
        'patient_no_fk',
        'service_number',
        'status',
        'au_entry_by',
        'au_entry_at',
        'au_entry_session',
        'au_entry_hospital_no_fk',
        'au_update_by',
        'au_update_at',
        'au_update_session',
        'au_update_hospital_no_fk',
        'au_sync_hospital_no_fk',
        'au_sync_at'
     ];
}
