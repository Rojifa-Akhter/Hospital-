<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryBonus extends Model
{
	protected $table        = 'hrms_salary_bonus';
	protected $primaryKey   = 'bonus_no_pk';
	public $sequence        = 'bonus_no_pk_seq';


	protected $guarded = ['bonus_no_pk'];

	const CREATED_AT = 'AU_ENTRY_AT';
	const UPDATED_AT = 'AU_UPDATE_AT';

	protected $fillable = [
		'person_card_no',
		'value_percent',
		'value_amount',
		'status',
		'festival_bonus_ind',
		'effective_date',
		'callculate_on',
		'bonus_percent_ind',
		'bonus_no_pk',
		'bonus_name',
		'bonus_amount_ind',
		'au_update_session',
		'au_update_hospital_pk_no',
		'au_update_by',
		'au_update_at',
		'au_sync_hospital_pk_no',
		'au_sync_at',
		'au_entry_session',
		'au_entry_hospital_pk_no',
		'au_entry_by',
		'au_entry_at',
	];
}
