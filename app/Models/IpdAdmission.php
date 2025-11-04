<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpdAdmission extends Model
{
    protected $table = 'ipd_admission';
    protected $primaryKey = 'admission_no_pk';
    public $sequence = 'ipd_admission_no_pk_seq';


    protected $guarded = ['admission_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = [
        'admission_no_pk',
        'admission_uid',
        'admission_date',
        'primary_doctor_no_fk',
        'duty_doc_person_no_fk',
        'initial_bed_no_fk',
        'curr_bed_no_fk',
        'curr_ward_no_fk',
        'reg_type_no_fk',
        'su_no_fk',
        'prescription_no_fk',
        'prescription_uid',
        'appointment_no_fk',
        'opd_department_su_no_fk',
        'opd_department_name',
        'opd_doc_person_no_fk',
        'opd_hospital_uid',
        'patient_no_fk',
        'service_number',
        'age',
        'adm_remarks',
        'dis_req_ind',
        'dis_req_by',
        'dis_req_time',
        'dis_ind',
        'dis_by',
        'dis_date',
        'dis_datetime',
        'mother_admission_no_fk',
        'death_ind',
        'death_declared_by',
        'death_declared_time',
        'cause_of_death',
        'status',
        'au_entry_by',
        'au_entry_at',
        'au_entry_session',
        'au_entry_hospital_no_fk',
        'au_update_by',
        'au_update_at',
        'au_update_session',
        'au_update_hospital_no_fk',
        'au_sync_hospital_no_fk',
        'au_sync_at',        
        'first_ref_doc_person_no_fk',
        'second_ref_doc_person_no_fk',
        'ref_doc_person_no_fk',
        ];
}
