<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineAttendance extends Model
{
  protected $table = 'hrms_attendance_machine_data';
    protected $primaryKey = "machine_data_no_pk";
    public $sequence = 'hrms_attendance_machine_data_seq';


    protected $guarded = ['machine_data_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['person_card_no', 'attendance_date', 'attandance_data', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'punch_time_photo'];
}
