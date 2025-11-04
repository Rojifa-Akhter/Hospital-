<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatHistoryTracking extends Model
{
    protected $table        = 'pat_history_tracking';
    protected $primaryKey   = 'pat_tracking_no_pk';
    public $sequence        = 'pat_tracking_no_seq';


    protected $guarded = ['pat_tracking_no_pk'];
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'au_entry_at',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session',
        'au_sync_at',
        'au_sync_hospital_pk_no',
        'au_update_at',
        'au_update_by',
        'au_update_hospital_pk_no',
        'au_update_session',
        'call_ind',
        'email_ind',
        'email_text',
        'mobile_no',
        'note_text',
        'pat_tracking_no_pk',
        'patient_no_fk',
        'sms_ind',
        'sms_text',
        'status',
        'traking_date',
        'user_no_fk',
    ];

}
