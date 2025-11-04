<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderChild extends Model
{
    protected $table        = 'inv_purchaseorder_chd';
    protected $primaryKey   = 'purchaseorderdtl_no_pk';
    public $sequence        = 'purchaseorderdtl_no_pk_seq';


    protected $guarded = ['purchaseorderdtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['purchaseorder_no_fk','item_no_fk' ,'itemtype_no_fk', 'entry_qty', 'item_rate'];
}
