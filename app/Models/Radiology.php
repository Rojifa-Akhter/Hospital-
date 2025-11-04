<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radiology extends Model
{
    protected $table        = 'radt_invoicedtl';
    protected $primaryKey   = 'rabinvoicedtl_no_pk';
    public $sequence        = 'radinvoicedtl_no_pk_seq';


    protected $guarded = ['rabinvoicedtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
