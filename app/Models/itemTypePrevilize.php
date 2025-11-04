<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    //
    protected $table        = 'SYSC_ITEMTYPEUSERPRIVS';
    protected $primaryKey   = 'USERITEMTYPE_NO_PK';
    public $sequence        = 'USERITEMTYPE_NO_PK_SEQ';


    protected $guarded = ['USERITEMTYPE_NO_PK'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'itemtype_no_fk', 'si_item_type', 'sl_no', 'status', 'user_no_fk', 'useritemtype_no_pk'];

}