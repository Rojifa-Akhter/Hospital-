<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderMaster extends Model
{
    protected $table = 'inv_purchaseorder_mst';
    protected $primaryKey = 'purchaseorder_no_pk';
    public $sequence = 'purchaseorder_no_pk_seq';

    protected $guarded = ['purchaseorder_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_entry_hospital_no_fk','purchase_date', 'status', 'finalized_ind', 'finalized_by', 'finalized_at', 'issue_ind', 'issue_by', 'issue_at'];
}
