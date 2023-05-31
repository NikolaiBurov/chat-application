<?php

use App\Models\User;
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
    return (int)$user->id === (int)$id;
});
//

Broadcast::channel('chat-channel', function (User $user) {
    return true;
});

Broadcast::channel('private-chat.{roomId}', function (User $sender, User $receiver, string $message, int $roomId) {
//    dd($sender, $receiver, $message, $roomId);
//    return [
//        'user_id' => $user->id,
//        'name' => $user->name,
//        'room_id' => $roomId,
//    ];
    return true;
});
