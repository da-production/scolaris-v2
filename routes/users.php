<?php

use App\Livewire\Administrateur\PermissionsWire;
use App\Livewire\Administrateur\RolesWire;
use App\Livewire\Administrateur\UtilisateursWire;
use App\Livewire\UserLogsWire;
use Illuminate\Support\Facades\Route;

Route::prefix('administrateur/utilisateurs')
->as('administrateur.utilisateurs.')
->middleware(['auth'])
->group(function () {
    Route::get('/', UtilisateursWire::class)->name('index');
    Route::get('/roles', RolesWire::class)->name('roles');
    Route::get('/permissions', PermissionsWire::class)->name('permissions');
    Route::get('/logs', UserLogsWire::class)->name('logs');
});

