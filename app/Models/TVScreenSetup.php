<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TVScreenSetup extends Model
{
    protected $table = 'sysc_tvscreen';
    protected $primaryKey   = 'tvscreen_no_pk';
    public $sequence        = 'tvscreen_no_pk_seq';
}
