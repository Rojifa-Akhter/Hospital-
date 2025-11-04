<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountPolicy extends Model
{
    protected $table        = 'sysc_discountpolicy';
    protected $primaryKey   = 'discountpolicy_no_pk';
    public $sequence        = 'discountpolicy_no_pk_seq';


    protected $guarded = ['discountpolicy_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

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
        'discount_name',
        'discountpolicy_no_pk',
        'dispolicy_code',
        'maximum_amount',
        'maximum_percent',
        'req_authorization_code_ind',
        'req_authorization_ind',
        'req_corporate_code_ind',
        'req_corporate_email_ind',
        'req_corporate_employee_id_ind',
        'req_corporate_sms_ind',
        'req_doctor_ind',
        'req_management_email_ind',
        'req_management_sms_ind',
        'req_signed_copy_ind',
        'req_staff_id_ind',
        'status',
        'applied_consult_ind',
        'gen_billing_ind',
        'applied_lab_ind',
        'applied_rad_ind',
        'applied_ipdbed_ind',
        'applied_ot_ind',
        'applied_considerdtl_ind',
        'applied_others_ind',
        'applied_consult_percent',
        'gen_billing_percent',
        'applied_lab_percent',
        'applied_rad_percent',
        'applied_ipdbed_percent',
        'applied_ot_percent',
        'applied_conultation_percent',
        'applied_others_percent',
        'item_level_disc_ind'
    ];
}
