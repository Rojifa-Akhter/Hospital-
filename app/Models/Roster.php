<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
   protected $table        = 'hrms_roster_template';
    protected $primaryKey   = 'roster_temp_no_pk';
    public $sequence        = 'hrms_roster_template_seq';


    protected $guarded = ['roster_temp_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [ 
        'roster_temp_code' ,
        'shift_no_fk'  ,
        'duty_start_time'  ,
        'duty_end_time' ,
        'schedule_day_fri' ,
        'schedule_day_sat' ,
        'schedule_day_sun' ,
        'schedule_day_mon' ,
        'schedule_day_tue' ,
        'schedule_day_wed' ,
        'schedule_day_thu',
        'duty_area_su_no_fk_fri',
        'duty_area_su_no_fk_sat',
        'duty_area_su_no_fk_sun',
        'duty_area_su_no_fk_mon', 
        'duty_area_su_no_fk_tue', 
        'duty_area_su_no_fk_wed', 
        'duty_area_su_no_fk_thu',
        'status',
        'AU_UPDATE_AT',
        'ROSTER_TEMP_NO_PK',
        'au_entry_hospital_pk_no'
    ];
}
