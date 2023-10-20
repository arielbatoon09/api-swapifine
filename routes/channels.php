<?php

use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// Broadcast::channel('private-channel.{msg_inbox_key}', function ($user, $msg_inbox_key) {
//     // Check if the user can access this channel
//     return (int) $user->id === (int) $msg_inbox_key;
//     // return true;
// });

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('test-channel.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('private-chat.{msg_inbox_key}', function ($user, $msg_inbox_key) {
    // Your authorization logic here
    return false; // or return false if the user is not authorized
});