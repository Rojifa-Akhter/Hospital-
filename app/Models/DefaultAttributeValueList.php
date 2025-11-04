<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultAttributeValueList extends Model
{
    protected $table        = 'labs_teststructval';
    protected $primaryKey   = 'teststructval_no_pk';
    public $sequence        = 'teststructval_no_pk_seq';

    protected $guarded = ['teststructval_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'teststructval_no_pk','sl_no', 'teststructval_code', 'teststruct_no_fk', 'analyzer_no_fk', 'test_result', 'default_ind', 'status', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at', 'item_no_fk'
    ];
}
