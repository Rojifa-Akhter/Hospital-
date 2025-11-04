<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $table        = 'pcrm_comission_policymst';
    protected $primaryKey   = 'policy_no_pk';
    public $sequence        = 'pcrm_com_policy_no_pk_seq';


    protected $guarded = ['policy_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
