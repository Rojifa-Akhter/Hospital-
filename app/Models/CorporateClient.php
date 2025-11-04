<?php

namespace app\models;

use illuminate\database\eloquent\model;

class corporateclient extends model
{
    protected $table        = 'ccm_corporate_client';
    protected $primarykey   = 'ccm_client_no_pk';
    public $sequence        = 'ccm_client_no_pk_seq';


    protected $guarded = ['ccm_client_no_pk'];

    const created_at = 'au_entry_at';
    const updated_at = 'au_update_at';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'au_entry_at',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session',
        'au_sync_at',
        'au_sync_hospital_pk_no',
        'au_update_at',
        'au_update_by',
        'au_update_hospital_pk_no',
        'au_update_session',
        'ccm_client_address',
        'ccm_client_city',
        'ccm_client_code',
        'ccm_client_contact_ad',
        'ccm_client_contact_no',
        'ccm_client_country',
        'ccm_client_email',
        'ccm_client_employee',
        'ccm_client_logo',
        'ccm_client_name',
        'ccm_client_no_pk',
        'ccm_client_phone_no',
        'is_emp_health_checking_ind',
        'is_post_bill_ind',
        'is_proosal_approval_ind',
        'status',
        'corporate_policy_no_fk'
    ];
}
