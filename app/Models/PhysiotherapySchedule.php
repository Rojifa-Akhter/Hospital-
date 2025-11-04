<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysiotherapySchedule extends Model
{
    protected $table        = 'patn_service_schedule';
    protected $primaryKey   = 'schedule_no_pk';
    public $sequence        = 'patn_service_schedule_no_pk_seq';


    protected $guarded = ['schedule_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
