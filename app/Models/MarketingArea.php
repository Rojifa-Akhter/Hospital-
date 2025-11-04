<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingArea extends Model
{
	protected $table        = 'pcrm_marketing_area';
	protected $primaryKey   = 'area_no_pk';
	public $sequence        = 'pcrm_marketing_area_seq';

	protected $guarded = ['area_no_pk'];

	const CREATED_AT = 'AU_ENTRY_AT';
	const UPDATED_AT = 'AU_UPDATE_AT';

	protected $fillable = ['area_code',
	'area_no_pk',
	'au_entry_at',
	'au_entry_by',
	'au_entry_hospital_pk_no',
	'au_entry_session',
	'au_sync_at',
	'au_sync_hospital_pk_no',
	'au_update_at',
	'au_update_by',
	'au_update_hospital_pk_no',
	'au_update_session',
	'district',
	'post_code',
	'status',
	'supervisor_person_no_fk',
];
}
