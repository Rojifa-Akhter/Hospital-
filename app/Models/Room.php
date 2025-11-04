<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table        = 'sysc_room';
    protected $primaryKey   = 'room_no_pk';
    public $sequence        = 'sysc_room_no_pk_seq';


    protected $guarded = ['room_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['room_code','room_name','room_description','room_capacity','room_size','serviceunit_no_fk','room_category_lookup_no_fk','status','au_entry_by','au_entry_session','au_entry_hospital_pk_no','ipd_ind','opd_ind','ot_ind','physio_ind','au_entry_hospital_no_fk','store_location_ind','open_location_ind','physicalstrucure_no_fk','asset_location_ind','duty_location_ind'];
}
