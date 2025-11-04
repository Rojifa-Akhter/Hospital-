<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralPaymentDtls extends Model
{
    protected $table        = 'pcrm_comission_paydtl';
    protected $primaryKey   = 'paydtl_no_pk';
    public $sequence        = '';


    protected $guarded = ['paydtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
