<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalChain extends Model
{
    protected $table        = 'wsec_hospitalchain';
    protected $primaryKey   = 'hospitalchain_no_pk';
    public $sequence        = 'wsec_hospitalchain_seq';


    protected $guarded = ['hospitalchain_no_pk'];

    // public $timestamps = false;
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['hospitalchain_code','hospitalchain_name','hospitalchain_alias','hospitalchain_slogan','addrress1','addrress2','village','thana_po','district','division','country','telephone1','telephone2','email','website','logo','status','logon_url','au_entry_by','au_update_by','au_entry_session','au_entry_hospital_pk_no'];
}

