<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemWisePolicy extends Model
{
	protected $table        = 'sysc_referralpolicy_item';
	protected $primaryKey   = 'referralpolicy_item_no_pk';
	public $sequence        = 'referralpolicy_item_no_pk_seq';


	protected $guarded = ['referralpolicy_item_no_pk'];

	const CREATED_AT = 'AU_ENTRY_AT';
	const UPDATED_AT = 'AU_UPDATE_AT';

	protected $fillable = [
		'au_entry_by',
		'au_entry_hospital_pk_no',
		'au_entry_session',
		'au_sync_at',
		'au_sync_hospital_pk_no',
		'au_update_by',
		'au_update_hospital_pk_no',
		'au_update_session',
		'commission_percent',
		'commission_taka',
		'default_2nd_referral_percent',
		'default_agent_percnet',
		'default_referral_percnet',
		'exclude_ind',
		'item_no_fk',
		'referralpolicy_item_no_pk',
		'referralpolicy_no_fk',
		'status',
		'no_other_item_apply_an_lvl',
		'no_other_item_apply_vn_lvl',
	];
}
