<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanRegisterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(closeRegister()){
            // If the application is open for registration, allow the request to proceed
            return $next($request);
        }
        return redirect()->route('guest.candidat.connexion')->with([
            'error' => 'Les inscriptions sont clôturées. Vous ne pouvez plus vous inscrire pour l\'exercice en cours.'
        ]);
    }
}
