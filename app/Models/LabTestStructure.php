<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestStructure extends Model
{
    protected $table        = 'labs_teststructure';
    protected $primaryKey   = 'teststruct_no_pk';
    public $sequence        = 'teststruct_no_pk_seq';


    protected $guarded = array();

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
