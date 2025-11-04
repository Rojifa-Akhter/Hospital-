<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Mail;
use App\Mail\MailNotify;

class TestController extends Controller
{
    public function sendEmail()
    {
        $user = "jahid0209@gmail.com";
        Mail::to($user)->send(new MailNotify($user));

        if (Mail::failures()) {
           return response()->Fail('Sorry! Please try again latter');
       }else{
           return response()->success('Great! Successfully send in your mail');
       }
   }
}
