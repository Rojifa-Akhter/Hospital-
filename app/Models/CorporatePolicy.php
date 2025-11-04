<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporatePolicy extends Model
{
    protected $table = 'ccm_corporatepolicy';
    protected $primaryKey = 'corporate_policy_no_pk';
    public $sequence = 'corporate_policy_no_pk_seq';

    protected $guarded = ['corporate_policy_no_pk'];
    protected $fillable = [
        'corporate_policy_no_pk' ,
        'corporatepolicy_code',
        'corporatepolicy_name',
        'commission_percent',
        'commission_taka',
        'authorization_ind',
        'authorization_code_ind',
        'not_doctor_ind' ,
        'signed_copy_ind',
        'corporate_emp_id_ind',
        'management_sms_ind',
        'management_email_ind' ,
        'corporate_sms_ind',
        'staff_id_ind',
        'corporate_code_ind' ,
        'corporate_email_ind' ,
        'active_status_ind' ,
        'applied_consult_ind',
        'applied_consult_percent',
        'gen_billing_ind',
        'gen_billing_percent',
        'applied_lab_percent',
        'applied_lab_ind',
        'applied_rad_ind',
        'applied_rad_percent',
        'applied_ipdbed_ind',
        'applied_ipdbed_percent',
        'applied_ot_ind',
        'applied_ot_percent',
        'applied_considerdtl_ind',
        'applied_others_ind',
        'applied_others_percent',
        'item_level_disc_ind'

    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';

}
