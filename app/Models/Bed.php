<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table        = 'ipds_bed';
    protected $primaryKey   = 'bed_no_pk';
    public $sequence        = 'ipds_bed_seq';


    protected $guarded = ['bed_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

     protected $fillable = ['bed_no_pk',
                            'bed_uid',
                            'bed_name',
                            'bed_sl_no',
                            'ward_no_fk',
                            'dummy_ind',
                            'bed_status',
                            'bed_status_ind',
                            'bed_status_by',
                            'bed_status_datetime',
                            'admission_fee_item_no_fk',
                            'bed_charge_item_no_fk',
                            'service_charge_item_no_fk',
                            'others_charge_item_no_fk',
                            'minimum_deposit_amount',
                            'su_no_fk',
                            'bed_cat_lookup_no_fk',
                            'remarks',
                            'status',
                            'au_entry_by',
                            'au_entry_at',
                            'au_entry_session',
                            'au_entry_hospital_no_fk',
                            'au_update_by',
                            'au_update_at',
                            'au_update_session',
                            'au_update_hospital_no_fk',
                            'au_sync_hospital_no_fk',
                            'au_sync_at',
         'bed_charge_amount','authorized_bed_ind'
];
}
