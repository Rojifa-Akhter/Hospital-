<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplateDtl extends Model
{
    //
    protected $table = 'psn_s_template_dtl';
    protected $primaryKey = 'psn_template_dtl_no_pk';
    public $sequence = 'psn_s_template_dtl_seq';
    public $incrementing = true;

    protected $guarded = ['psn_template_dtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['psn_template_dtl_no_pk', 'psn_template_no_fk', 'lookupdata_item_no_fk', 'lookup_uid', 'lookupdata_uid', 'prescrition_data', 'entry_serial', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_no_fk'];
}
