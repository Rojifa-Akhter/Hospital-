<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitemType extends Model
{
    protected $table        = 'ccm_corporatepolicy_itemtype';
    protected $primaryKey   = 'corppolicy_itemtype_no_pk';
    public $sequence        = 'corppolicy_itemtype_no_pk_seq';


    protected $guarded = ['corppolicy_itemtype_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['corppolicy_itemtype_no_pk', 'corporate_policy_no_fk', 'item_type', 'equal_percent', 'clinic_percent', 'referral_percent', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at', 'ref_mt_no_pk', 'ref_hospital_no_pk'];

}
