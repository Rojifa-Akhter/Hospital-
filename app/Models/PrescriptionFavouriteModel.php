<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionFavouriteModel extends Model
{
    protected $table = 'psn_s_favorite';
    protected $primaryKey = 'pres_fav_no_pk';
    public $sequence = 'pres_fav_no_pk_seq';

    protected $guarded = ['pres_fav_no_pk'];
    protected $fillable = [
        'pres_fav_no_pk',
        'doctor_person_no_fk',
        'su_no_fk',
        'item_type_lookup_code',
        'favourite_name',
        'status',
        'au_entry_by',
        'au_entry_hospital_no_fk',
        'au_entry_session',
        'route',
        'duration',
        'dosage', 
        'item_qty'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';
}
