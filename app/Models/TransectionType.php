<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransectionType extends Model
{
    protected $table        = 'finc_trntype';
    protected $primaryKey   = 'trn_type_no_pk';
    public $sequence        = 'finc_trntype_seq';


    protected $guarded = ['trn_type_no_pk'];

    // public $timestamps = false;
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['trn_type_code','trn_type_name','au_entry_hospital_pk_no'];
}
