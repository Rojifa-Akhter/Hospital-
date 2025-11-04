<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    //
    protected $table = 'emr_allergies';
    protected $primaryKey = 'pat_allergies_no_pk';
    public $sequence = 'emr_allergies_seq';

    protected $guarded = ['pat_allergies_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
