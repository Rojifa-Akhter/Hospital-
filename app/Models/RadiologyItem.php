<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadiologyItem extends Model
{

    protected $table        = 'sysc_serviceitem';
    protected $primaryKey   = 'item_no_pk';
    public $sequence        = 'sysc_serv_item_no_pk_seq';


    protected $guarded = ['item_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'item_code',
        'active_stat',
        'serviceunit_no_fk',
        'sales_price',
        'normal_delivery_hour',
        'urgent_delivery_hour',
        'stat_delivery_hour',
        'report_header',
        'status',
        'item_name',
        'item_short_name',
        'urgent_fee_amt',
        'item_type',
        'au_entry_hospital_pk_no'

    ];
}