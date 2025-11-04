<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RadiologyReportTemplate extends Model
{
    protected $table        = 'rads_resulttemplate';
    protected $primaryKey   = 'result_template_no_pk';
    public $sequence        = 'rad_result_template_no_pk_seq';


    protected $guarded = ['result_template_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_update_by','au_entry_by','au_entry_hospital_no_fk','su_no_fk', 'result_template_uid' ,'template_name', 'template_date' ,'default_ind', 'share_ind', 'general_ind','sl_no','report_text_html', 'status'];
}
