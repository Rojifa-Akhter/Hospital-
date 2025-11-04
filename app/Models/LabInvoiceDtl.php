<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabInvoiceDtl extends Model
{
    protected $table        = 'labt_invoicedtl';
    protected $primaryKey   = 'labinvoicedtl_no_pk';
    public $sequence        = 'labinvoicedtl_no_pk_seq';


    protected $guarded = ['labinvoicedtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
protected $fillable = ['sc_sample_coll_key_ind','sc_sample_coll_keyed_by','sc_sample_coll_keyed_time',
'report_delivery_date','lab_result_con_key_ind','lab_result_con_keyed_by','lab_result_con_keyed_time','lab_rcv_from_sp_key_ind','lab_result_verify_key_ind','lab_result_final_key_ind'];


}
