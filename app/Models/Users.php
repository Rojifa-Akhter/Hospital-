<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable;

    protected $table = 'wsec_user';
    protected $primaryKey = 'user_no_pk';
    public $sequence = 'wsec_user_user_no_pk_seq';

    //public $incrementing = false;
    // timestamp associate with it
    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_no_pk', 'user_code', 'user_fullname', 'user_name', 'email', 'user_pass', 'user_name_access_code','status', 'user_expire_date', 'password_expiry_date', 'hospital_no_pk', 'person_no_fk', 'user_lock_ind', 'pass_expiry_ind', 'user_expire_ind', 'user_type', 'patient_no_fk', 'phone_mobile', 'last_otp_text', 'last_otp_verified_ind',  'financial_ind', 'last_otp_expire_dttm','au_entry_hospital_pk_no'
    ];

    public function setUserExpireDateAttribute($value)
    {
        $this->attributes['user_expire_date'] = date('Y-m-d H:i:s', strtotime($value));
    }
    public function setPasswordExpiryDate($value)
    {
        $this->attributes['password_expiry_date'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Get the phone record associated with the user.
     */
    public function personnel()
    {
        return $this->hasOne('App\Models\Doctor', 'person_no_pk', 'person_no_fk');
    }

    public function user_personal()
    {
        return DB::table('hrms_personnel')->where('person_no_pk', $this->person_no_fk)->first();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass', 'remember_token',
    ];

    public function username()
    {
        return 'email';
    }

    public function getAuthPassword()
    {
        return $this->user_pass;
    }

}
