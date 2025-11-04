<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table        = 'ipds_ward';
    protected $primaryKey   = 'ward_no_pk';
    public $sequence        = 'ipds_ward_seq';


    protected $guarded = ['ward_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

     protected $fillable = [
                            'wardtype_lookup_no_fk',
                            'ward_uid',
                            'ward_no_pk',
                            'ward_name',
                            'vip_ind',
                            'status',
                            'service_unit_no_fk',
                            'room_no_fk',
                            'nicu_ind',
                            'icu_ind',
                            'hdu_ind',
                            'gender_ind',
                            'emr_ind',
                            'ccu_ind',
                            'category_lookup_no_fk',
                            'au_update_session',
                            'au_update_hospital_no_fk',
                            'au_update_by',
                            'au_update_at',
                            'au_sync_hospital_no_fk',
                            'au_sync_at',
                            'au_entry_session',
                            'au_entry_hospital_no_fk',
                            'au_entry_by',
                            'au_entry_at',
                            'au_entry_hospital_pk_no'
     ];
}
