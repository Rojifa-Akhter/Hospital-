<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPrivilege extends Model
{
    protected $table        = 'wsec_userfeaturesprivs';
    protected $primaryKey   = 'userfeatures_no_pk';
    public $sequence        = 'userfeatures_no_pk_seq';

    protected $guarded = ['userfeatures_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_no_fk', 'features_no_fk', 'grant_dt', 'role_no_fk', 'status', 'au_update_by', 'menu_no_fk', 'au_entry_at', 'au_entry_hospital_pk_no'];
}