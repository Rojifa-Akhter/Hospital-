<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseMemo extends Model
{
    protected $table        = 'finc_expense';
    protected $primaryKey   = 'expense_no_pk';
    public $sequence        = 'expense_no_pk_seq';


    protected $guarded = ['expense_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'expense_no_pk', 'memo_no', 'expense_name', 'amount', 'charge_to',
        'status', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_no_fk',
        'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 
        'expense_date', 'expense_to'
    ];
}
