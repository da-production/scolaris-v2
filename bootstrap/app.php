<?php

use App\Http\Middleware\AuthenticateCandidat;
use App\Http\Middleware\RedirectIfCandidatAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
        'guest.candidat' => RedirectIfCandidatAuthenticated::class,
        'auth.candidat' => AuthenticateCandidat::class,
        'can.register' => \App\Http\Middleware\CanRegisterMiddleware::class,
        'hasAnyPermission' =>\App\Http\Middleware\HasAnyPermission::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
