<?php

namespace App\Http\Middleware;

use App\Models\Option;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\WithOptions;

class CanCandidatResetPasswordMiddleware
{
    use WithOptions;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->initOptions('options_inscription');
        if(!is_null($this->options) && $this->options instanceof Collection){
            if($this->options->get('candidat_login_otp')){
                return $next($request);
            }
        }
        abort(404);
    }
}
