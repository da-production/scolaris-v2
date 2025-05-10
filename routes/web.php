<?php

use App\Livewire\ClassificationWire;
use App\Livewire\InscriptionOptionWire;
use App\Livewire\ScolarisOptionWire;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\SpecialiteWire;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::prefix('administrateur')
->as('administrateur.')
->middleware(['auth'])
->group(function () {

    // options resources
    Route::prefix('options')
    ->as('options.')
    ->group(function () {
        Route::get('/scolaris', ScolarisOptionWire::class)->name('index');
        Route::get('/inscription', InscriptionOptionWire::class)->name('inscription');
        Route::get('/classifications', ClassificationWire::class)->name('classifications');
        Route::get('/specialites', SpecialiteWire::class)->name('specialites');
    });

});




require __DIR__.'/users.php';
require __DIR__.'/auth.php';
