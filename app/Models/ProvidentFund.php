<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvidentFund extends Model
{
    protected $table        = 'hrms_provident_fund_setup';
    protected $primaryKey   = 'pf_no_pk';
    public $sequence        = 'pf_no_pk_seq';


    protected $guarded = ['pf_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['value_percent', 'value_percen', 'value_amount', 'status', 'pf_no_pk', 'pf_loan_percent', 'pf_bank_name', 'pf_bank_account', 'pf_amount_type', 'fixed_amount', 'effective_date', 'comp_value_percent', 'comp_payment_amount', 'callculate_on', 'au_update_session', 'au_update_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_sync_hospital_pk_no', 'au_sync_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_entry_by', 'au_entry_at'];

}
