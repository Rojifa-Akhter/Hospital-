<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankWiseService extends Model
{
	protected $table        = 'finc_bankcard_charge';
	protected $primaryKey   = 'bank_charge_no_pk';
	public $sequence        = 'bank_charge_no_pk_seq';


	protected $guarded = ['bank_charge_no_pk'];

	const CREATED_AT = 'AU_ENTRY_AT';
	const UPDATED_AT = 'AU_UPDATE_AT';

	protected $fillable = [

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
		'bank_charge_code',
		'bank_charge_no_pk',
		'card_type',
		'lookup_no_fk',
		'service_charge_percent',
		'status',
		'bank_no_fk'
	];
}
