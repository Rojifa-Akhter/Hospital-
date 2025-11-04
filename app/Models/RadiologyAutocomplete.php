<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadiologyAutocomplete extends Model
{
    protected $table        = 'RADT_TEMPPLATE_TEXT_AUTOCOMPLETE';
    protected $primaryKey   = 'TEMP_TEXT_AC_NO_PK';
    public $sequence        = 'TEMP_TEXT_AC_NO_PK_SEQ';


    protected $guarded = ['TEMP_TEXT_AC_NO_PK'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'au_entry_at', 'au_entry_by', 'au_entry_hospital_pk_no', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_pk_no', 'au_update_at', 'au_update_by', 'au_update_hospital_pk_no', 'au_update_session', 'status', 'temp_text_ac_code', 'temp_text_ac_no_pk', 'text_content', 'text_content_clob', 'text_name'
      ];
}

