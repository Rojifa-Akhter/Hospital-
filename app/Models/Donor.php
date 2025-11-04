<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $table        = 'labt_donerinfo';
    protected $primaryKey   = 'doner_no_pk';
    public $sequence        = 'doner_no_pk_seq';




// test

    protected $guarded = ['doner_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

     protected $fillable = ['au_entry_at',
                            'au_entry_by',
                            'au_entry_hospital_pk_no',
                            'au_entry_session',
                            'au_sync_at',
                            'au_sync_hospital_pk_no',
                            'au_update_at',
                            'au_update_by',
                            'au_update_hospital_pk_no',
                            'au_update_session',
                            'doner_age',
                            'doner_beg_no',
                            'doner_blood',
                            'doner_code',
                            'doner_gender',
                            'doner_hbsag',
                            'doner_hcp',
                            'doner_hiv',
                            'doner_mp',
                            'doner_name',
                            'doner_no_pk',
                            'doner_rh_typing',
                            'doner_room_temp',
                            'doner_vdrl',
                            'invoice_no_fk',
                            'patient_age',
                            'patient_blood_group',
                            'patient_gender',
                            'patient_name',
                            'patient_no_fk',
                            'patient_rh_typing',
                            'status',
                            'type_of_blood_component',
                            'type_of_donations',
                            'report_no_fk',
                            'donor_marital_status',
                            'donor_blood_group',
                            'anti_hbc_total'
];
}
