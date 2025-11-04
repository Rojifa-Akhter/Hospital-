<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table        = 'hrms_grade';
    protected $primaryKey   = 'grade_no_pk';
    public $sequence        = 'grade_no_pk_seq';


    protected $guarded = ['grade_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['attendance_bonus','grade_name', 'basic_pay_factor', 'basic_salary', 'conveyance_allow', 'entertainment', 'grade_no_pk', 'gross_salary', 'house_rent', 'house_rent_perc', 'medical_allow', 'status', 'total_wages', 'utility','au_entry_by','au_update_by','au_entry_session','au_entry_hospital_pk_no', 'salary_grade_factor', 'basic_salary_perc', 'house_rent_perc', 'medical_allow_perc', 'conveyance_allow_perc', 'utility_perc', 'entertainment_perc', 'festival_bonus', 'festival_bonus_perc', 'ta_da', 'ta_da_perc'];

   
}
