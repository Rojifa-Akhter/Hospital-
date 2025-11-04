<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysioAssementModel extends Model
{
    protected $table = 'psn_t_prescription_physio_assm';
    protected $primaryKey = 'prescription_physio_no_pk';
    public $sequence = 'prescription_physio_no_pk_seq';

    protected $guarded = ['prescription_physio_no_pk'];
    protected $fillable = [
        'prescription_physio_no_pk',
        'prescription_no_fk',
        'prescription_uid',
        'lookup_uid',
        'lookupdata_uid',
        'prescrition_data',
        'prescrition_data_resp',
        'prescrition_data1',
        'prescrition_data_resp1',
        'admission_pk_no',
        'admission_uid',
        'appointment_pk_no',
        'patient_no_fk',
        'au_entry_by',
        'au_entry_hospital_no_fk',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
