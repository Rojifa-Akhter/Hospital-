<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionLookup extends Model
{
    protected $table        = 'pres_lookup';
    protected $primaryKey   = 'pres_lookup_no_pk';
    public $sequence        = 'pres_lookup_seq';


    protected $guarded = ['pres_lookup_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['pres_lookup_code','pres_lookup_name','pres_lookup_no_fk','serial','status','au_entry_hospital_pk_no'];

    public function lookupList()
    {
        return $this->hasMany('App\Models\PrescriptionLookupItem', 'pres_lookup_no_pk');
    }
}