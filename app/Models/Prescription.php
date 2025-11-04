<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table        = 'prest_entryprescription_eye';
    protected $primaryKey   = 'prescription_no_pk';
    public $sequence        = 'prest_prescription_no_pk_eye_seq';

    protected $guarded = ['prescription_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
