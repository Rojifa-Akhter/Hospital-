<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWiseRoomRadiology extends Model
{
    protected $table        = 'RADT_ROOM_SHEDULESETUP';
    protected $primaryKey   = 'room_shedsetup_no_pk';
    public $sequence        = 'room_shedsetup_no_pk_seq';


    protected $guarded = ['room_shedsetup_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'avg_time', 'end_time', 'person_no_fk', 'room_no_fk', 'room_shedsetup_no_pk', 'room_shedsetup_uid', 'start_time', 'status', 'su_no_fk'
    ];

}
