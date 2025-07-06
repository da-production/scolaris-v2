<?php

use App\Livewire\Candidat\CandidatureWire;
use App\Livewire\Candidat\LoginWire;
use App\Livewire\Candidat\ProfileWire;
use App\Livewire\Candidat\RegisterWire;
use App\Livewire\CandidatsWire;
use App\Livewire\CandidaturesWire;
use App\Livewire\CandidatWire;
use App\Livewire\ClassificationWire;
use App\Livewire\CreateExerciseWire;
use App\Livewire\DomainWire;
use App\Livewire\ExerciceWire;
use App\Livewire\FiliereWire;
use App\Livewire\HomeWire;
use App\Livewire\InscriptionOptionWire;
use App\Livewire\MotifWire;
use App\Livewire\ScolarisOptionWire;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ShowExerciceWire;
use App\Livewire\SpecialiteConcourWire;
use App\Livewire\SpecialiteWire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', HomeWire::class)->name('home');
Route::group([
    'middleware' => 'guest.candidat',
    'as' => 'guest.candidat.',
], function () {
    Route::get('candidat/connexion',LoginWire::class)->name('connexion');
    Route::get('inscription',RegisterWire::class)->name('inscription');

    // Route::get('candidat/forgot-password', ForgotPassword::class)->name('password.request');
    // Route::get('candidat/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::group([
    'middleware' => 'auth.candidat',
    'prefix' => 'candidat',
    'as' => 'candidat.'
], function(){
    Route::get('/', ProfileWire::class)->name('profile');
    Route::get('/candidature', CandidatureWire::class)->name('candidature');
    Route::get('/profile/photo/{filename}', function ($path) {
    // Optionnel : empêcher les utilisateurs de voir les photos des autres
        

        if (Storage::disk('private')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('private')->path($path));
    })->name('profile.photo');
});


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
        Route::get('/candidatures/specialite/{specialite_concour_id}',CandidaturesWire::class)->name('candidatures.specialite');
    });
    // options resources
    Route::prefix('options')
    ->as('options.')
    ->group(function () {
        Route::get('/scolaris', ScolarisOptionWire::class)->name('index');
        Route::get('/inscription', InscriptionOptionWire::class)->name('inscription');
        Route::get('/classifications', ClassificationWire::class)->name('classifications');
        Route::get('/domains', DomainWire::class)->name('domains');
        Route::get('/specialites', SpecialiteWire::class)->name('specialites');
        Route::get('/specialites-concours', SpecialiteConcourWire::class)->name('specialites.concours');
        Route::get('/exercices', ExerciceWire::class)->name('exercices');
        Route::get('/exercices/create', CreateExerciseWire::class)->name('exercices.create');
        Route::get('/exercices/detail/{exercice:annee}', ShowExerciceWire::class)->name('exercices.show');
        Route::get('/motifs', MotifWire::class)->name('motifs');
        Route::get('/filieres', FiliereWire::class)->name('filieres');
    });

});


require __DIR__.'/users.php';
require __DIR__.'/auth.php';
