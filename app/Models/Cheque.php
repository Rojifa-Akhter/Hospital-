<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    //
    protected $table = 'acc_chequeprint';
    protected $primarykey = 'acc_chequeprint_no_pk';
    public $sequence = 'acc_chequeprint_no_pk_seq';

    protected $guarded = ['acc_chequeprint_no_pk'];
    protected $fillable = [
        'acc_chequeprint_no_pk',
        'account_number',
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
        'chq_account_pay_ind',
        'chq_amount',
        'chq_amount_text',
        'chq_bank_name',
        'chq_date',
        'chq_id',
        'chq_pay_to',
        'print_count',
        'status',
        'remarks',
    ];
    public $incrementing = false;
    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';
}
