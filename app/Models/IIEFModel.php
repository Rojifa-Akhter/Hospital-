<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IIEFModel extends Model
{
    protected $table = 'psn_t_physio_shim';
    protected $primaryKey = 'physio_shim_no_pk';
    public $sequence = 'physio_shim_no_pk_seq';

    protected $guarded = ['physio_shim_no_pk'];
    protected $fillable = [
        'physio_shim_no_pk',
        'physio_shim_code',
        'lookupdata_no_fk',
        'lookupdata_name',
        'patient_no_fk',
        'patient_name',
        'dob',
        'date_completed',
        'very_low_ind',
        'low_ind',
        'moderate_ind',
        'high_ind',
        'very_high_ind',
       // 'almost_always_score',
        'au_entry_by',
        'au_entry_hospital_no_fk',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
