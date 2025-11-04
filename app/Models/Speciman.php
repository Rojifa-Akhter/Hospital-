<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciman extends Model
{
    protected $table        = 'microbiology_antibiotic';
    protected $primarykey   = 'microbiology_no_pk ';
    public $sequence        = 'microbiology_no_pk _seq';



    protected $guarded = ['microbiology_no_pk'];

    const created_at = 'au_entry_at';
    const updated_at = 'au_update_at';
    public $incrementing = false;
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

     protected $fillable = [
        'au_entry_at',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session',
        'au_sync_at',
        'au_sync_hospital_pk_no',
        'au_update_at',
        'au_update_by',
        'au_update_hospital_pk_no',
        'au_update_session',
        'microbilology_uid',
        'microbiology_name',
        'microbiology_no_pk',
        'status',
    ];
}
