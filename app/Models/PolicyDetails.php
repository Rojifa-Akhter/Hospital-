<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyDetails extends Model
{
    protected $table        = 'pcrm_comission_policydtl';
    protected $primaryKey   = 'policydtl_no_pk';
    public $sequence        = 'pcrm_com_policydtl_no_pk_seq';

    protected $fillable = ['AU_ENTRY_HOSPITAL_PK_NO'];
    protected $guarded = ['policydtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}