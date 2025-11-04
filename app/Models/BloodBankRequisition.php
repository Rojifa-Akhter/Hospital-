<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodBankRequisition extends Model
{
    protected $table        = 'bbd_requisition';
    protected $primaryKey   = 'requsition_no_pk';
    public $sequence        = 'requsition_no_pk_seq';


    protected $guarded = ['requsition_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'patient_no_fk','patient_code','patient_name','patient_age','patient_gender','admission_no_fk','admission_date','bed_cabin_name','blood_group','blood_bag_qty','trensmission_date','trensmission_time','blood_taken_type','blood_type','exam_type','hemoglobin','bp','pulse','tamprature','last_blood_donation_date','last_blood_history','last_blood_sideeffect','prev_trensmission_date','pledge_donor','donor_name','doctor_no_fk','doctor_name','doctor_code','status','au_entry_at','au_entry_session','au_entry_hospital_no_fk','requsition_no_pk','is_selected_donate', 'donor_type'
    ];
}
