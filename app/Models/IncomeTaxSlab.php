<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeTaxSlab extends Model
{

    protected $table        = 'acc_incometax_slab';
    protected $primaryKey   = 'incometax_slab_no_pk';
    public $sequence        = 'incometax_slab_no_pk_seq';


    protected $guarded = ['incometax_slab_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['incometax_slab_no_pk', 'incometax_slab_code', 'payroll_breakdown_code', 'payroll_breakdown_desc', 'person_type', 'income_start_amt', 'income_end_amt', 'taxpercent', 'active_status', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no'];
}
