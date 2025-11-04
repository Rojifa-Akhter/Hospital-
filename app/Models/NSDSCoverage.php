<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NSDSCoverage extends Model
{
    protected $table        = 'ipds_wardcoverage_nsds';
    protected $primaryKey   = 'nsdscoverage_no_pk';
    public $sequence        = 'ipds_wardcoverage_nsds_seq';


    protected $guarded = ['nsdscoverage_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

   // protected $fillable = ['room_uid','room_name','room_description','room_capacity','room_size','su_no_fk','room_category_lup_no_fk','status','au_entry_by','au_entry_session','au_entry_hospital_pk_no'];
}
