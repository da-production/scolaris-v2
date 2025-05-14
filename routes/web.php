<?php

use App\Livewire\CandidatsWire;
use App\Livewire\CandidaturesWire;
use App\Livewire\CandidatWire;
use App\Livewire\ClassificationWire;
use App\Livewire\CreateExerciseWire;
use App\Livewire\ExerciceWire;
use App\Livewire\FiliereWire;
use App\Livewire\InscriptionOptionWire;
use App\Livewire\MotifWire;
use App\Livewire\ScolarisOptionWire;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ShowExerciceWire;
use App\Livewire\SpecialiteWire;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'livewire.candidat-wire')
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

    Route::prefix('candidats')
    ->as('candidats.')
    ->group(function () {
        Route::get('/', CandidatsWire::class)->name('index');
        Route::get('/detail/{candidat}', CandidatWire::class)->name('show');
        Route::get('/candidatures',CandidaturesWire::class)->name('candidatures');
    });
    // options resources
    Route::prefix('options')
    ->as('options.')
    ->group(function () {
        Route::get('/scolaris', ScolarisOptionWire::class)->name('index');
        Route::get('/inscription', InscriptionOptionWire::class)->name('inscription');
        Route::get('/classifications', ClassificationWire::class)->name('classifications');
        Route::get('/specialites', SpecialiteWire::class)->name('specialites');
        Route::get('/exercices', ExerciceWire::class)->name('exercices');
        Route::get('/exercices/create', CreateExerciseWire::class)->name('exercices.create');
        Route::get('/exercices/detail/{exercice:annee}', ShowExerciceWire::class)->name('exercices.show');
        Route::get('/motifs', MotifWire::class)->name('motifs');
        Route::get('/filieres', FiliereWire::class)->name('filieres');
    });

});


require __DIR__.'/users.php';
require __DIR__.'/auth.php';
