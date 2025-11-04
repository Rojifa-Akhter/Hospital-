<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    //
    protected $table        = 'hrms_designation';
    protected $primaryKey   = 'designation_no_pk';
    public $sequence        = 'designation_no_pk_seq';


    protected $guarded = ['designation_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['designation_name','designation_code','status','strength','grade_no_fk','au_entry_by','au_update_by','au_update_at','au_entry_at','au_entry_session','au_entry_hospital_pk_no'];
}
