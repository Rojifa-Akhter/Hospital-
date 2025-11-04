<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestReferenceValue extends Model
{
    protected $table        = 'labs_testreferencevalue';
    protected $primaryKey   = 'referencevalue_no_pk';
    public $sequence        = 'referencevalue_no_pk_seq';


    protected $guarded = array();

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
