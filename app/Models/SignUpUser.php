<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignUpUser extends Model
{

    protected $table        = 'wsec_user';
    protected $primaryKey   = 'shift_no_pk';
    public $sequence        = 'seq_shift_no_pk';

    protected $guarded = ['person_no_pk'];
    protected $fillable = ['salutation','person_code','full_name','fname','lname','gender_lookup_no_fk','phone_mobile','email_personal','pe_addr1','specialization_lookup_no_fk','referral_agent_ind','degree1','degree2','degree3','degree4','doctor_signature','photo_name'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';
}
