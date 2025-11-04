<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralConfigaration extends Model
{
	protected $table        = 'sysc_referralpolicy';
	protected $primaryKey   = 'referralpolicy_no_pk';
	public $sequence        = 'referralpolicy_no_pk_seq';


	protected $guarded = ['referralpolicy_no_pk'];

	const CREATED_AT = 'au_entry_at';
	const UPDATED_AT = 'au_update_at';

	protected $fillable = ['applied_to_agent_ind',
	'applied_to_ref_doctor_ind',
	'applied_to_seconnd_ref_ind',
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
	'default_2nd_ref_percent',
	'default_agent_percnet',
	'default_ref_percnet',
	'referralpolicy_code',
	'referralpolicy_name',
	'referralpolicy_no_pk',
	'status',];
}
