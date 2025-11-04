<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UomLookup extends Model
{
    protected $table        = 'sysc_serviceitem_uom';
    protected $primaryKey   = 'uom_no_pk';
    public $sequence        = 'uom_no_pk_seq';


    protected $guarded = ['uom_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['uom_code', 'uom_label_desc', 'status', 'au_entry_hospital_no_fk'];

    // public function lookupList()
    // {
    //     return $this->hasMany('App\Models\LookupItem', 'lookup_no_fk');
    // }
}