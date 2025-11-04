<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table        = 'hrms_leavetype_days';
    protected $primaryKey   = 'leavetypedays_no_pk';
    public $sequence        = 'leavetypedays_no_pk_seq';


    protected $guarded = ['leavetypedays_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'leave_type_lkp_name', 'leave_type_lkp_no_fk', 'leave_code', 'leavetypedays_no_pk', 'no_of_days', 'status', 'gender', 'leave_category_lookup_no_fk', 'carry_forword_ind'];

}
