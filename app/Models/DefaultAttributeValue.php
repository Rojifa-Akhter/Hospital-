<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultAttributeValue extends Model
{
    protected $table        = 'labs_teststructval';
    protected $primaryKey   = 'teststructval_no_pk';
    public $sequence        = 'teststructval_no_pk_seq';
    public $incrementing = false;
    public $timestamps = false;


    protected $guarded = ['teststructval_no_pk'];

    const created_at = 'au_entry_at';
    const updated_at = 'au_update_at';

    protected $fillable = [
        'analyzer_no_fk', 'au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'default_ind', 'status', 'test_result', 'teststruct_no_fk', 'teststructval_code', 'teststructval_no_pk', 'item_no_fk'
    ];
}