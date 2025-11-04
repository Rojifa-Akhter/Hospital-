<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveChild extends Model
{
   protected $table        = 'hrms_leave_entrydtl';
    protected $primaryKey   = 'leavedtl_no_pk';
    public $sequence        = 'leavedtl_no_pk';


    protected $guarded = ['leavedtl_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['leave_type_lkp_no_fk','leave_dates','leave_reason','au_entry_by','au_update_by','au_update_at','au_entry_at','au_entry_session','au_entry_hospital_pk_no','leave_status','status'];
}
