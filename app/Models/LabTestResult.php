<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestResult extends Model
{
    protected $table        = 'labt_testresult';
    protected $primaryKey   = 'testresult_no_pk';
    public $sequence        = 'labt_testresult_pk_seq';


//    protected $guarded = array();
    protected $fillable = [
        "testresult_no_pk", "testresult_code", "pathinvoicedtl_no_fk", "invoice_no_fk", "invoicedtl_no_fk", "report_no_fk", "analyzerdtl_no_fk", "lab_no_fk", "item_no_fk", "analyzer_no_fk", "teststruct_no_fk", "sl_no", "attr", "machine_attrib", "analyzer_desc", "result0", "result1", "result2", "result3", "comments_text", "note_text", "interpretation", "plain_text", "unit", "test_group_no_fk", "group_txt", "referencevalue_no_fk", "referencevalue", "test_method", "show_in_rep", "result_type", "machine_int", "machine_val_arrived", "mac_res_arr_on", "mac_res_done", "original_result", "factor_value", "group_seq", "repeat_request_ind", "repeat_done_ind", "repeat_qty", "status", "au_entry_by", "au_entry_at", "au_entry_session", "au_entry_hospital_pk_no", "au_update_by", "au_update_at", "au_update_session", "au_update_hospital_pk_no", "au_sync_hospital_pk_no", "au_sync_at", "labinvoicedtl_no_fk"
    ];
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
