<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceDeduction extends Model
{
  
    protected $table        = 'hrms_personnel_sal_add_ded';
    protected $primaryKey   = 'addded_no_pk';
    public $sequence        = 'addded_no_pk_seq';


    protected $guarded = ['addded_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['addded_date', 'addded_no_pk', 'addded_type', 'amount', 'au_entry_at','remarks', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session',  'person_no_fk', 'status','year_yyyymm'];

   

}
