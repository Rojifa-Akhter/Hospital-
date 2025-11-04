<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table        = 'hrms_leave_entry';
    protected $primaryKey   = 'leave_no_pk';
    public $sequence        = 'leave_no_pk_seq';


    protected $guarded = ['leave_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['leave_code', 'leave_type_lkp_no_fk', 'person_no_fk', 
    'from_date', 'to_dates', 'leave_reason', 'au_entry_by', 'au_update_by', 'au_update_at', 
    'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'status', 'leave_for_extra_duty', 
    'leave_for_extra_assignto', 'leave_attch', 'manual_lv_ind', 'approved_ind', 'al_dayoff_date'];
}
