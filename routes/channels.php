<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// Broadcast::channel('agora-online-channel.{data}', function ($user, $data) {
//     return $user->user_no_pk === $data->user_to_call;
// });
Broadcast::channel('agora-online-channel', function ($user) {

   return ['id' => $user->user_no_pk, 'name' => $user->user_fullname];
});
//
//
//Broadcast::channel('chat', function ($user) {
//    return Auth::check();
//});


Broadcast::channel('TVUpdate', function () {
    return true;
});
Broadcast::channel('PharmacyTVUpdate', function () {
    return true;
});

