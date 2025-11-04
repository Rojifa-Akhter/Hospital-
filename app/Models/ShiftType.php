<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    protected $table        = 'hrms_shift';
    protected $primaryKey   = 'shift_no_pk';
    public $sequence        = 'seq_shift_no_pk';


    protected $guarded = ['shift_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['shift_code','shift_desc','start_time','end_time','status','au_entry_by','au_entry_session','au_entry_hospital_pk_no', 'minimum_in_time', 'maximum_out_time', 'grace_in_time_min', 'grace_out_time_min', 'sheft_hour'];


}
