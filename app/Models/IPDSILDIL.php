<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPDSILDIL extends Model
{
    protected $table        = 'ipd_sil_dil';
    protected $primaryKey   = 'ipd_sil_dil_no_pk';
    public $sequence        = 'ipd_sil_dil_no_pk_seq';


    protected $guarded = ['ipd_sil_dil_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT'; 
    const UPDATED_AT = 'AU_UPDATE_AT';
}
