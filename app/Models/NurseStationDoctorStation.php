<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseStationDoctorStation extends Model
{
    protected $table        = 'ipds_nsds';
    protected $primaryKey   = 'nsds_no_pk';
    public $sequence        = 'ipds_nsds_seq';


    protected $guarded = ['nsds_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [

        'au_entry_at',
        'au_entry_by',
        'au_entry_hospital_no_fk',
        'au_entry_session',
        'au_sync_at',
        'au_sync_hospital_no_fk',
        'au_update_at', 'au_update_by',
        'au_update_hospital_no_fk',
        'au_update_session',
        'ds_ind',
        'ns_ind',
        'nsds_name',
        'nsds_no_pk',
        'nsds_uid',
        'nursestation_type',
        'ref_hospital_no_pk',
        'ref_mt_no_pk',
        'room_no_fk',
        'status',
        'sup_person_no_fk',
        'su_no_fk'
    ];
}
