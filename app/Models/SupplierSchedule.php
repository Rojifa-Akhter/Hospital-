<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierSchedule extends Model
{
    //
    protected $table = 'inv_supp_sdle_delivery';
    protected $primaryKey = 'supp_schedule_no_pk';
    public $sequence = 'supp_schedule_no_pk_seq';

    protected $guarded = ['supp_schedule_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['supp_schedule_no_pk', 'supplier_no_fk', 'po_no_fk', 'challan_no',
             'challan_date', 'item_no_fk', 'item_name', 'order_quantity', 'item_quantity',
             'delivery_date', 'status','au_entry_by','au_entry_session','au_entry_hospital_pk_no','module_no_fk'];
}
