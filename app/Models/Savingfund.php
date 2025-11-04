<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Savingfund extends Model
{
    protected $table        = 'hrms_personnel_save_fund';
    protected $primaryKey   = 'monthly_save_fund_no_pk';
    public $sequence        = 'hrms_personnel_save_fund_seq';


    protected $guarded = ['monthly_save_fund_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['au_entry_at',
                            'au_entry_by',
                            'au_entry_hospital_pk_no',
                            'au_entry_session',
                            'au_sync_at',
                            'au_sync_hospital_pk_no',
                            'au_update_at',
                            'au_update_by',
                            'au_update_hospital_pk_no',
                            'au_update_session',
                            'cancel_by',
                            'cancel_date',
                            'cancel_ind',
                            'finalyzed_by',
                            'finalyzed_by_ind',
                            'finalyzed_date',
                            'monthly_salary_no_fk',
                            'monthly_save_fund_no_pk',
                            'person_no_fk',
                            'personal_savings_amount',
                            'personal_savings_amount_total',
                            'process_no_fk',
                            'salary_no_fk',
                            'salary_process_date',
                            'salary_yyyymm',
                            'status',
                            'withdraw_ind'
    ];

}
