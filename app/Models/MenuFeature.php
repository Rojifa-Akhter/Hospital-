<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuFeature extends Model
{
    protected $table        = 'wsec_menufeatures';
    protected $primaryKey   = 'features_no_pk';
    public $sequence        = 'features_no_pk_seq';

    protected $guarded = ['features_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'features_code', 'menu_no_pk', 'features_name', 'sl_no', 'page_url', 'status',  'features_no_pk', 'au_entry_hospital_pk_no'
    ];
}