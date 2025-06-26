<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.auth.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('app', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('logout.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});