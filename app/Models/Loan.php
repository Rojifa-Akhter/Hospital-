<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table        = 'hrms_loan';
    protected $primaryKey   = 'loan_no_pk';
    public $sequence        = 'loan_no_pk_seq';


    protected $guarded = ['loan_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['person_no_pk','original_amount','interest_perc','loan_amount','installment_no','installment_amount','installment_date','au_update_by','au_update_at','au_entry_at','au_entry_session','au_entry_hospital_pk_no','au_entry_by'];
}
