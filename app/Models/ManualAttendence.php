<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualAttendence extends Model
{
    protected $table = 'hrms_attendance_daily_manual';
    protected $primaryKey = "mattendance_no_pk";
    public $sequence = 'mattendance_no_pk_seq';


    protected $guarded = ['mattendance_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['attendance_date', 'attendance_status', 'au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'duty_in_time', 'duty_out_time', 'duty_shift_no_fk', 'entry_by', 'entry_date', 'entry_type', 'in_time', 'late_time_min', 'mattendance_no_pk', 'out_time', 'over_time_min', 'person_card_no','lunch_out_time','lunch_in_time', 'remarks'];

}
