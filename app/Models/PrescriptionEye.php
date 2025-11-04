<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionEye extends Model
{
    //
    protected $table        = 'psn_t_prescription_eye';
    protected $primaryKey   = 'pres_eye_no_pk';
    public $sequence        = 'pres_eye_no_pk_seq';

    protected $guarded = ['pres_eye_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
