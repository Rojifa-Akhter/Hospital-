<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyFamilydose extends Model
{
   
    protected $table        = 'emr_familymedhistory'; 
    protected $primaryKey   = 'familymedhistory_no_pk';
    public $sequence        = 'familymedhistory_no_pk_seq';

    protected $guarded = ['familymedhistory_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['suffered_duration',
							'status',
							'severity',
							'service_number',
							'relation_name',
							'patient_no_fk',
							'familymedhistory_uid',
							'familymedhistory_no_pk',
							'disease_name',
							'death_bydisease_ind',
							'date_to',
							'date_from',
							'au_update_session',
							'au_update_hospital_no_fk',
							'au_update_by',
							'au_update_at',
							'au_sync_hospital_no_fk',
							'au_sync_at',
							'au_entry_session',
							'au_entry_hospital_no_fk',
							'au_entry_by',
							'au_entry_at'
						];
}
