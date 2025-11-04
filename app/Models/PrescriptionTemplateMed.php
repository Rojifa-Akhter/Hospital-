<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplateMed extends Model
{
    //
    protected $table = 'psn_s_template_med';
    protected $primaryKey = 'psn_template_med_no_pk';
    public $sequence = 'psn_s_template_med_seq';

    protected $guarded = ['psn_template_med_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
