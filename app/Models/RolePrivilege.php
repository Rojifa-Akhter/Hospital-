<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    protected $table        = 'wsec_rolefeaturesprivs';
    protected $primaryKey   = 'rolefeatures_no_pk';
    public $sequence        = 'rolefeatures_no_pk_seq';


    protected $guarded = ['rolefeatures_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
      protected $fillable = [ 'role_no_fk','menu_no_fk', 'features_no_fk', 'au_entry_by','status'];
}
