<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table        = 'sysc_module';
    protected $primaryKey   = 'module_no_pk';
    public $sequence        = 'sysc_module_seq';


    protected $guarded = ['module_no_pk'];

    // public $timestamps = false;
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['module_code','module_name','module_desc','status','au_entry_by','au_update_by','au_entry_session','au_entry_hospital_pk_no'];
}
