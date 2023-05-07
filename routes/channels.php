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


//Broadcast::channel('newNotification', function ($user) {
//    return $user;
//});
////Broadcast::channel('newNotification.{id}', function ($user, $id) {
////    return (int) $user->id === (int) $id;
////});
//
//Broadcast::channel('order', function ($user, $orderId) {
//    return true;
//});

Broadcast::channel('App.User.{id}', function ($user, $id){

    return true;
});

Broadcast::channel('sd-tyres-{id}', function ($user, $id) {
//    dd($user);
    return (int) $user->id === (int) $id;
});

Broadcast::channel('sd-tyres-admin-{id}', function ($user, $id) {
//    dd($user);
    return (int) $user->id === (int) $id;
});
Broadcast::channel('sd-tyres-cart-{id}', function ($user, $id) {
//    dd($user);
    return (int) $user->id === (int) $id;
});