<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateModel extends Model
{
    protected $table = 'CCM_CorporateClient';
    protected $primaryKey = 'ccm_client_no_pk';
    public $sequence = 'corporate_client_no_pk_seq';

    protected $guarded = ['ccm_client_no_pk'];
    public $incrementing = false;

    const CREATED_AT = 'AU_ENTRY_AT';

    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = [
        'ccm_client_no_pk',
        'ccm_client_code',
        'ccm_client_name',
        'client_address',
        'contact_no',
        'web',
        'phone',
        'contact_person',
        'contact_mobile',
        'designation_name',
        'official_email',
        'payment_ind',
        'employee_listed_ind',
        'employee_id_ind',
        'employee_approval_ind',
        'deposit_ind',
        'threshold_employee',
        'threshold_company',
        'start_date',
        'expire_date',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session',
        'signatory_name',
        'signatory_designation',
        'signatory_contact_number',
        'signatory_email',
        'active_status',
        'corporate_policy_no_fk',
        'contract_sign_date'
    ];
}
