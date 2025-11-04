<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceInvoiceMaster extends Model
{
    protected $table = 'finc_invoicemst_sum_vw';
    protected $primaryKey = "INVOICE_NO_PK";


    public function patientInfo(){

    	return $this->belongsTo(DoctorInfoView::class,'person_no_fk');

    }
 
}
