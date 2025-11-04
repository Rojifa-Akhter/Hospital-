<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCard extends Model
{
    protected $table        = 'hrms_card';
    protected $primaryKey   = 'card_no_pk';
    public $sequence        = 'card_no_pk_seq';


    protected $guarded = ['card_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['card_number','card_no_pk' ,'au_entry_by','au_entry_session','au_entry_hospital_pk_no','status'];
}
