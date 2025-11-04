<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleCollection extends Model
{
    protected $table        = 'labt_samplecoll';
    protected $primaryKey   = 'lab_no_pk';
    public $sequence        = 'lab_no_pk_seq';


    protected $guarded = ['lab_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = ['sc_sample_coll_key_ind','sc_sample_coll_keyed_by','sc_sample_coll_keyed_time'];
}
