<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPaymentRequest extends Model
{
    protected $table        = 'inv_supp_payment_reqdtl';
    protected $primaryKey   = 'pmnt_reqdtl_no_pk';
    public $sequence        = 'pmnt_reqdtl_no_pk_seq';


    protected $guarded = ['pmnt_reqdtl_no_pk_seq'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    // protected $fillable = [];
}
