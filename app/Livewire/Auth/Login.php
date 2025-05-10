<?php

namespace App\Livewire\Auth;

use App\Events\OtpEvent;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        /**
         * TODO:
         * 1- check crediential 
         * 2- create otp code
         * 3- redirect to page with token
         */
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = User::where('email',$this->email)->first();
        if(!is_null($user) && Hash::check($this->password,$user->password)){
            // todo create otp code
            $otp    = random_int(000000,99999);
            $token  = Str::random(16);
            Otp::create([
                'user_id'   => $user->id,
                'token'     => $token,
                'code'      => $otp,
                'remember'  => $this->remember
            ]);
            event(new OtpEvent($otp,$token,$user));

            // redirect to otp page with token
            return redirect(route('otp')."?token=".$token);
            
        }else{
            // display error message
            return;
        }

        /**
         * old code
         */
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
