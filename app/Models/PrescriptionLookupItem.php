<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionLookupItem extends Model
{
    protected $table        = 'pres_lookupdata';
    protected $primaryKey   = 'pres_lookupdata_no_pk';
    public $sequence        = 'pres_lookupdata_seq';


    protected $guarded = ['pres_lookupdata_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['pres_lookupdata_code','pres_lookupdata_name','pres_lookup_no_fk','serial','status','au_entry_hospital_pk_no','au_entry_by','au_update_by','doctor_person_no_fk'];

    public function lookup()
    {
        return $this->belongsTo('App\Models\PrescriptionLookup');
    }
}
