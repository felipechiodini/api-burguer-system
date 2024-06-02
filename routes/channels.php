<?php

use App\Models\User;
use App\Models\UserStore;
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

Broadcast::channel('notifications.{id}', function ($user, $id) {
    return $user->id == $id;
});

Broadcast::channel('orders.{slug}', function(User $user, String $slug) {
    return UserStore::query()
        ->where('user_id', $user->id)
        ->where('slug', $slug)
        ->exists();
});