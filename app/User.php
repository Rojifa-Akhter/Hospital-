<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'oracle';

    protected $table = 'wsec_user';

    protected $primaryKey = 'user_no_pk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_code', 'user_fullname', 'user_name', 'user_email', 'user_pass', 'status','user_type','patient_no_fk','person_no_fk'
    ];

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
        return 'user_email';
    }

    public function getAuthPassword()
    {
        return $this->user_pass;
    }
    public function messages()
    {
      return $this->hasMany(Models\Message::class);
    }
}
