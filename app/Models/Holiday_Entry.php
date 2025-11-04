<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday_Entry extends Model
{
     protected $table        = 'hrms_holiday';
    protected $primaryKey   = 'holiday_no_pk';
    public $sequence        = 'holiday_no_pk_seq';


    protected $guarded = ['holiday_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'holiday_date', 'holiday_name', 'holiday_no_pk', 'holiday_year', 'status'];
}
