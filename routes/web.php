<?php

use App\Livewire\CacheWire;
use App\Livewire\Candidat\CandidatureWire;
use App\Livewire\Candidat\LoginWire;
use App\Livewire\Candidat\ProfileWire;
use App\Livewire\Candidat\RegisterWire;
use App\Livewire\CandidatsWire;
use App\Livewire\CandidaturesWire;
use App\Livewire\CandidatureWire as LivewireCandidatureWire;
use App\Livewire\CandidatWire;
use App\Livewire\ClassificationWire;
use App\Livewire\CreateExerciseWire;
use App\Livewire\DomainWire;
use App\Livewire\ExerciceWire;
use App\Livewire\FailedJobsWire;
use App\Livewire\FiliereWire;
use App\Livewire\HomeWire;
use App\Livewire\InscriptionOptionWire;
use App\Livewire\MotifWire;
use App\Livewire\ScolarisOptionWire;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\ShowExerciceWire;
use App\Livewire\SmtpOptionWire;
use App\Livewire\SpecialiteConcourWire;
use App\Livewire\SpecialiteWire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', HomeWire::class)->name('home');
Route::get('/fermeture', \App\Livewire\ClosedSiteWire::class)->name('fermeture');
Route::group([
    'middleware' => 'guest.candidat',
    'as' => 'guest.candidat.',
], function () {
    Route::get('candidat/connexion',LoginWire::class)->name('connexion');
    Route::get('inscription',RegisterWire::class)->middleware('can.register')->name('inscription');

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
        Route::get('/', CandidatsWire::class)->name('index')->middleware(['can:view all candidats']);
        Route::get('/detail/{candidat}', CandidatWire::class)->name('show')->middleware(['can:view candidat']);
        Route::get('/candidatures',CandidaturesWire::class)->name('candidatures')->middleware(['can:view all candidatures']);
        Route::get('/candidatures/{candidature}',LivewireCandidatureWire::class)->name('candidature.detail')->middleware(['can:view candidature']);
        Route::get('/candidatures/specialite/{specialite_concour_id}',CandidaturesWire::class)->name('candidatures.specialite')->middleware(['hasAnyPermission:view all candidatures, view candidatures']);
    });
    // options resources
    Route::prefix('options')
    ->as('options.')
    ->group(function () {
        Route::get('/scolaris', ScolarisOptionWire::class)->name('index')->middleware(['can:update apps options']);
        Route::get('/inscription', InscriptionOptionWire::class)->name('inscription')->middleware(['can:view apps options']);
        Route::get('/classifications', ClassificationWire::class)->name('classifications')->middleware(['can:view classifications']);
        Route::get('/domains', DomainWire::class)->name('domains')->middleware(['can:view domaines']);
        Route::get('/specialites', SpecialiteWire::class)->name('specialites')->middleware(['can:view specialites']);
        Route::get('/specialites-concours', SpecialiteConcourWire::class)->name('specialites.concours')->middleware(['can:view specialites concour']);
        Route::get('/exercices', ExerciceWire::class)->name('exercices')->middleware(['can:view exercices']);
        Route::get('/exercices/create', CreateExerciseWire::class)->name('exercices.create')->middleware(['can:view exercices']);
        Route::get('/exercices/detail/{exercice:annee}', ShowExerciceWire::class)->name('exercices.show')->middleware(['can:view exercices']);
        Route::get('/motifs', MotifWire::class)->name('motifs')->middleware(['can:view motifs']);
        Route::get('/filieres', FiliereWire::class)->name('filieres')->middleware(['can:view filieres']);
        Route::get('/cache', CacheWire::class)->name('cache')->middleware(['can:delete caches app']);
        Route::get('/smtp', SmtpOptionWire::class)->name('smtp')->middleware(['can:update smtp']);
        Route::get('/jobs', FailedJobsWire::class)->name('jobs')->middleware(['can:update jobs']);
    });

});


require __DIR__.'/users.php';
require __DIR__.'/auth.php';
