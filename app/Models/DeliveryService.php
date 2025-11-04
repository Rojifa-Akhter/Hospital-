<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    protected $table = 'ecom_delivery_service';
    protected $primarykey = 'delivery_service_no_pk';
    public $sequence = 'delivery_service_no_pk_seq';
    protected $guarded = ['delivery_service_no_pk'];
    protected $fillable = [
     'delivery_service_no_pk', 
     'input_type',
     'psn_lookupdata_no_fk',
     'su_no_fk',
     'detail_name',
     'status',
     'au_entry_by',
     'au_entry_hospital_pk_no',
     'au_entry_session'
 ];
 public $incrementing = false;

 const created_at = 'au_entry_at';

 const updated_at = 'au_update_at';
}
