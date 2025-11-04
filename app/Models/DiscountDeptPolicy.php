<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountDeptPolicy extends Model
{
    protected $table        = 'SYSC_DISCOUNTPOLICY_SU';
    protected $primaryKey   = 'dispolicy_su_no_pk';
    public $sequence        = 'dispolicy_su_no_pk_seq';
    protected $guarded = ['dispolicy_su_no_pk'];


    protected $fillable = ['dispolicy_su_no_pk', 'su_no_fk', 'equal_percent', 'clinic_percent', 'referral_percent', 'discountpolicy_no_fk', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at', 'ref_mt_no_pk', 'ref_hospital_no_pk'];


    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
