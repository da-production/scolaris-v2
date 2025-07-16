<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasAnyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Si l'utilisateur est authentifié
        if (!auth()->check()) {
            abort(403, 'Non autorisé');
        }

        // Vérifie s'il a au moins une des permissions passées
        if (!auth()->user()->canany($permissions)) {
            abort(403, 'Vous n\'avez pas la permission nécessaire.');
        }

        return $next($request);
    }
}
