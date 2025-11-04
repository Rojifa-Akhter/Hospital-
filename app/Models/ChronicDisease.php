<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChronicDisease extends Model
{
    protected $table        = 'emr_chronic_disease';
	protected $primaryKey   = 'chronic_dis_no_pk';
	public $sequence        = 'emr_chronic_disease_seq';


	protected $guarded = ['chronic_dis_no_pk'];

	const CREATED_AT = 'AU_ENTRY_AT';
	const UPDATED_AT = 'AU_UPDATE_AT';
}
