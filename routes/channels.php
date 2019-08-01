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


use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('Chat.{user_id}.{friend_id}', function ($user, $user_id,$friend_id){
    return (int)$user->id == $friend_id;
});

Broadcast::channel('Online',function ($user){
    return $user;
});


Broadcast::channel('chat',function($user){
    return $user;
});


Broadcast::channel('ch', function ($user) {
    return Auth::check();
});



Broadcast::channel('Typing.{user_id}.{friend_id}', function ($user, $user_id,$friend_id){
    if((int)$user->id == $friend_id)
    {
        return $user;
    }


});

