<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $table        = 'sysc_lookup';
    protected $primaryKey   = 'lookup_no_pk';
    public $sequence        = 'sysc_lookup_no_pk_seq';


    protected $guarded = ['lookup_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['lookup_code', 'lookup_name', 'lookup_desc', 'status', 'au_entry_hospital_pk_no'];

    public function lookupList()
    {
        return $this->hasMany('App\Models\LookupItem', 'lookup_no_fk');
    }
}