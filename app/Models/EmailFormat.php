<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailFormat extends Model
{
    protected $table        = 'sysc_email_format';
    protected $primaryKey   = 'email_format_no_pk';
    public $sequence        = 'sysc_email_format_seq';


    //public $incrementing = false;
    // timestamp associate with it
    protected $guarded = ['email_format_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'email_format_no_pk', 'appoint_no_fk', 'invoice_no_fk', 'prescription_no_fk', 'email_event_lookup_no_pk', 'email_subject', 'email_body1', 'email_body2', 'comments', 'au_entry_by', 'au_entry_at', 'au_entry_session', 'au_entry_hospital_pk_no', 'au_update_by', 'au_update_at', 'au_update_session', 'au_update_hospital_pk_no', 'au_sync_hospital_pk_no', 'au_sync_at'
    ];
}
