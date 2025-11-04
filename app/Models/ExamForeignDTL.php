<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamForeignDTL extends Model
{
    protected $table        = 'MEDICAL_EXAM_FOREIGN_WORKER_DTL';
    protected $primaryKey   = 'exam_foreign_wor_dtl_no_pk';
    public $sequence        = 'exam_foreign_wor_dtl_no_pk_seq';


    protected $guarded = ['exam_foreign_wor_dtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['EXAM_FOREIGN_WOR_DTL_NO_PK', 'PATIENT_NO_FK', 'PATIENT_NAME', 'ITEM_NO_FK', 'INVOICE_NO_FK', 'ITEM_NAME', 'ITEM_ABNORMAL_IND', 'STATUS', 'AU_ENTRY_BY', 'AU_ENTRY_AT', 'AU_ENTRY_SESSION', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at'];
}
