<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoItemType extends Model
{
    protected $table = 'sysc_serviceitem_auto';
    protected $primaryKey = 'autoitemlst_no_pk';
    public $sequence = 'autoitemlst_no_pk_seq';

    protected $guarded = ['autoitemlst_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = [
        'autoitemlst_no_pk', 'autoitemlst_code', 'item_no_fk', 'auto_item_no_fk', 'item_uom', 'item_qty', 'free_ind', 'pkg_item_ind', 'stockable_ind', 'discount_applicable_ind','status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at'
    ];
}
