<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorFee extends Model
{
    protected $table        = 'hrms_doctorfee';
    protected $primaryKey   = 'doctorfee_no_pk';
    public $sequence        = 'doctorfee_no_pk_seq';


  

    //public $incrementing = false;
    // timestamp associate with it
    protected $guarded = ['doctorfee_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
