<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTypeWisePolicy extends Model
{
	protected $table        = 'sysc_referralpolicy_itemtype';
	protected $primaryKey   = 'refpolicy_itemtype_no_pk';
	public $sequence        = 'refpolicy_itemtype_no_pk_seq';


	protected $guarded = ['refpolicy_itemtype_no_pk'];

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
		'default_2nd_referral_percent',
		'default_agent_percnet',
		'default_referral_percnet',
		'item_type',
		'referralpolicy_no_fk',
		'refpolicy_itemtype_no_pk',
		'status',
	];
}
