<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestStructureAnalyzer extends Model
{
    protected $table        = 'labs_teststructure_analyzer';
    protected $primaryKey   = 'analyzerattr_no_pk';
    public $sequence        = 'analyzerattr_no_pk_seq';


    protected $guarded = array();

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
