<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeTax extends Model
{
    protected $table = 'income_tax_setup';
    protected $primaryKey = 'income_tax_setup_no_pk';
   // protected $primaryKey = 'delivery_charge_no_pk';
    public $sequence = 'income_tax_setup_no_pk_seq';

    protected $guarded = ['income_tax_setup_no_pk'];
    protected $fillable = [
        'income_tax_setup_no_pk',
        'tax_description',
        'tax_fee_amount',
        'min_tax_percent',
        'rem_next_one_lac',
        'rem_next_one_lac_percent',
        'rem_next_three_lac',
        'rem_next_three_lac_percent',
        'rem_next_four_lac',
        'rem_next_four_lac_percent',
        'rem_next_five_lac',
        'rem_next_five_lac_percent',
        'rem_next_everything_percent',
        'default_ind',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
