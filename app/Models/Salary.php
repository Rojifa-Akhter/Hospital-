<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
     protected $table        = 'hrms_personnel_salary';
    protected $primaryKey   = 'salary_no_pk';
    public $sequence        = 'hrms_personnel_salary';


    protected $guarded = ['salary_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    // protected $fillable = [ 'bonus_name','bonus_amount_ind','bonus_percent_ind', 'callculate_on',  'value_amount','value_percent','festival_bonus_ind','effective_date','au_entry_by','au_entry_session','au_entry_hospital_pk_no'];
}
