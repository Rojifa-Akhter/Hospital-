<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionFavourit extends Model
{
    protected $table        = 'psn_s_favorite';
    protected $primaryKey   = 'pres_fav_no_pk';
    public $sequence        = 'psn_t_prescription_seq';

    protected $guarded = ['pres_fav_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    
    protected $fillable = [ 'pres_fav_no_pk','user_no_fk','item_type_lookup_code', 'pres_fav_no_pk', 'favourite_name' , 'pres_lookup_no_fk','su_no_fk' ,'psn_lookupdata_no_fk' ,'favourite_item_no_fk', 'status' ];
      
}
