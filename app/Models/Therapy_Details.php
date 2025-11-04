<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Therapy_Details extends Model
{
    protected $table = 'patient_therapy_details';
    protected $primaryKey = 'patient_therapy_no_pk';
    public $sequence = 'patieent_therapy_no_pk_seq';

    protected $guarded = ['patient_therapy_no_pk'];
    protected $fillable = [
        'patient_therapy_no_pk',
        'therapy_day_no',
        'therapy_week_no',
        'therapy_date',
        'therapy_dosage',
        'prescription_no_fk',
        'patient_no_fk',
        'patient_code',
        'therapy_treated_by',
        //'au_entry_at',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
