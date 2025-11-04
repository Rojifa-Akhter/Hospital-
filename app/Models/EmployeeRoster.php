<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRoster extends Model
{
     protected $table        = 'hrms_roster';
    protected $primaryKey   = 'roster_no_pk';
    public $sequence        = 'hrms_roster_seq';


    protected $guarded = ['roster_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'roster_no_pk', 
        'roster_code',
        'roster_date',
        'person_no_fk',
        'shift_no_fk',
        'duty_start_time',
        'duty_end_time',
        'schedule_day_fri',
        'schedule_day_sat',
        'schedule_day_sun',
        'schedule_day_mon',
        'schedule_day_tue',
        'schedule_day_wed',
        'schedule_day_thu',
        'duty_area_su_no_fk',
        'roster_temp_no_fk',
        'status',
        'dayoff_ind',
        'au_entry_by',
        'au_update_at',
        'au_entry_hospital_pk_no'];
}
