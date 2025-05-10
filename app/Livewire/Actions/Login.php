<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class Login
{
    /**
     * Log the current user in the application.
     */
    public static function attempt($user,$remember = false)
    {
        if (! Auth::attempt(['email' => $user->email, 'password' => $user->password], $remember)) {

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        Session::regenerate();

        return redirect(route('dashboard'));
    }
}
