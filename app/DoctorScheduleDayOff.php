<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorScheduleDayOff extends Model
{
    protected $table        = 'hrms_schedule_dayoff';
    protected $primaryKey   = 'schedule_dayoff_no_pk';
    public $sequence        = 'SCHEDULE_DAYOFF_no_pk_seq';

    protected $guarded = ['schedule_dayoff_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    // protected $fillable = ['', ''];

}
