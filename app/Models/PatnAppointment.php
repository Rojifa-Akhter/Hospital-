<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatnAppointment extends Model
{
    protected $table        = 'patn_appointment';
    protected $primaryKey   = 'appoint_no_pk';
    public $sequence        = 'patn_appointment_no_pk_seq';


    protected $guarded = ['appoint_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['cancel_ind','cancel_reason', 'au_update_by'];
}
