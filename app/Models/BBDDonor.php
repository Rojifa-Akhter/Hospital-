<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBDDonor extends Model
{
    protected $table        = 'bbd_donor';
    protected $primaryKey   = 'donor_no_pk';
    public $sequence        = 'donor_no_pk_seq';
    protected $guarded = ['donor_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'donor_no_pk','donor_uid','blood_req_no_fk','donor_name','fatherorhousbend_name','donor_dob','donor_gender','donor_mobile','donor_address','status','au_entry_by','au_entry_at','au_entry_session','au_entry_hospital_pk_no','au_update_by','au_update_at','au_update_session','au_update_hospital_pk_no','au_sync_hospital_pk_no','au_sync_at','remarks','last_blood_donat_date','donor_profession','marital_status', 'sleep_id', 'breakfast', 'following_72', 'vaccine', 'hepatitis', 'systolic', '
        '];
}
