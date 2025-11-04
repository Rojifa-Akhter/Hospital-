<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeTaxCale extends Model
{
    protected $table        = 'acc_incometax_calc';
    protected $primaryKey   = 'incometax_calc_no_pk';
    public $sequence        = 'incometax_calc_no_pk_seq';


    protected $guarded = ['incometax_calc_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['incometax_calc_no_pk', 'incometax_calc_code', 'payroll_breakdown_code', 'payroll_breakdown_desc', 'percent_of_gross', 'taxableincome_percent', 'taxableincome_loweramount', 'active_status', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no'];
}
