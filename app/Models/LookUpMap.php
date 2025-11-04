<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LookUpMap extends Model
{

    protected $table        = 'sysc_lookupmap';
    protected $primaryKey   = 'lookupmap_no_pk';
    public $sequence        = 'sysc_room_seq';


    protected $guarded = ['lookupmap_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['lookupmap_no_pk','lookup_no_fk','pres_lookup_no_pk','user_no_fk','su_no_fk','hospital_no_fk','room_no_fk','item_no_fk','mapping_pk_no1','mapping_pk_no2','lookupmap_desc','serial_no' , 'status','au_entry_hospital_no_fk','au_update_hospital_no_fk'];
}
