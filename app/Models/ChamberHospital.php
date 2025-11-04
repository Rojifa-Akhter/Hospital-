<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamberHospital extends Model
{
    //
    protected $table        = 'wsec_chamber_hospital';
    protected $primaryKey   = 'chamber_hospital_no_pk';
    public $sequence        = 'chamber_hospital_no_pk_seq';
    public $incrementing = false;

    protected $guarded = ['chamber_hospital_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
    protected $fillable = [
        'chamber_hospital_no_pk',
        'chamber_hospital_name',
        'chamber_hospital_description',
        'chamber_hospital_location',
        'chamber_hospital_country',
        'establishe_year',
        'number_of_bed',
        'status',
        'chamber_hospital_speciality',
        'image_url',
        'au_entry_by',
        'au_entry_session'

    ];
}
