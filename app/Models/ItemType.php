<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    //
    protected $table        = 'sysc_itemtype';
    protected $primaryKey   = 'itemtype_no_pk';
    public $sequence        = 'sysc_itemtype_no_pk_seq';


    protected $guarded = ['itemtype_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'itemtype_code', 'item_type_name', 'par_itemtype_no_fk', 'sl_no', 'acc_ledger_no_fk', 'type_auto_con_flag', 'acc_par_itemtype_no_fk', 'au_entry_by', 'au_entry_at', 'au_entry_hospital_pk_no', 'status', 'default_discount', 'major_group_ind', "minor_group_ind", "ipd_bill_summary_head_ind", "ipd_discount_head_ind", "referral_payment_head_ind", "inventory_head_ind", "asset_group_ind", "asset_su_no_fk", "asset_depreciation_pct", "asset_depreciation_life_year", "depreciation_residual_val_pct"



    ];
}
