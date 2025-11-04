<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplate extends Model
{
    //
    protected $table = 'psn_s_template';
    protected $primaryKey = 'psn_template_no_pk';
    public $sequence = 'psn_s_template_seq';

    protected $guarded = ['psn_template_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['template_name', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_hospital_no_fk'];
}
