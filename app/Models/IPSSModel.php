<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPSSModel extends Model
{
    protected $table = 'psn_t_physio_ipss';
    protected $primaryKey = 'physio_ipss_no_pk';
    public $sequence = 'physio_ipss_no_pk_seq';

    protected $guarded = ['physio_ipss_no_pk'];
    protected $fillable = [
        'physio_ipss_no_pk',
        'physio_ipss_code',
        'lookupdata_no_fk',
        'lookupdata_name',
        'patient_no_fk',
        'patient_name',
        'dob',
        'date_completed',
        'not_at_all_score',
        'less_than_1_to_5_tiems_scr',
        'less_than_half_time_score',
        'about_half_time_score',
        'more_than_half_time_scr',
        'almost_always_score',
        'au_entry_by',
        'au_entry_hospital_no_fk',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
