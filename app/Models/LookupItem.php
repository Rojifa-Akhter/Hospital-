<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LookupItem extends Model
{
    protected $table        = 'sysc_lookupdata';
    protected $primaryKey   = 'lookupdata_no_pk';
    public $sequence        = 'sysc_lookupdata_no_pk';


    protected $guarded = ['lookupdata_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['lookupdata_code','lookupdata_name','lookupdata_pk_no_parent','lookupdata_desc','lookup_no_fk','au_entry_hospital_pk_no','lookupdata_name_bangla','serial_no', 'status','lookupdata_no_pk'];

    public function lookup()
    {
        return $this->belongsTo('App\Models\Lookup');
    }
}