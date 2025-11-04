<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $table = 'ecom_delivery_charge';
    protected $primaryKey = 'delivery_charge_no_pk';
    public $sequence = 'delivery_charge_no_pk_seq';

    protected $guarded = ['delivery_charge_no_pk'];
    protected $fillable = [
        'delivery_charge_no_pk',
        'delivery_charge_type',
        'charge',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
