<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // CHAT_MESSAGE
    protected $table        = 'chat_message';
    protected $primaryKey   = 'message_no_pk';
    public $sequence        = 'message_no_pk_seq';
    protected $guarded = ['message_no_pk'];


    protected $fillable = ['message_text','au_entry_by','user_no_fk','to_user_no_fk','au_entry_session','au_entry_hospital_pk_no'];



    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';


}
