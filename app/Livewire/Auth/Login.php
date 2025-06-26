<?php

namespace App\Livewire\Auth;

use App\Actions\LogAction;
use App\Events\OtpEvent;
use App\Events\UserAuthEvent;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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
         * Delete it after
         */
        // return $this->LoginWithoutOtp();
        /**
         * TODO:
         * 1- check crediential 
         * 2- create otp code
         * 3- redirect to page with token
         */
        $this->validate();

        $this->ensureIsNotRateLimited();

        // return $this->LoginWithOtp();

        return $this->LoginWithoutOtp();
    }
    protected function LoginWithOtp(){
        $user = User::where('email',$this->email)->first();
        if(!is_null($user) && Hash::check($this->password,$user->password)){
            try{
                $otp    = random_int(000000,99999);
                $token  = Str::random(16);
                Otp::create([
                    'user_id'   => $user->id,
                    'token'     => $token,
                    'code'      => $otp,
                    'remember'  => $this->remember
                ]);

                LogAction::store(request(),$user->id,'attempt to login','User',[
                    'email' => $this->email,
                    'remember' => $this->remember
                ],'attempt to login with OTP');
                event(new OtpEvent($otp,$token,$user));

                // redirect to otp page with token
                return redirect(route('otp')."?token=".$token);
            }catch(\Exception $e){
                session()->flash('error', 'An error occurred while saving the specialite: ' . $e->getMessage());
                Log::error('Error creating specialite: ' . $e->getMessage());
                return;
            }
            
        }else{
            // display error message
            return;
        }
    }
    protected function LoginWithoutOtp(){
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        LogAction::store(request(),request()->user()->id,'login','User',[
            'email' => $this->email,
            'remember' => $this->remember
        ],'Login without OTP');

        if(config('app.enable_reverb')){
            Broadcast::event(new UserAuthEvent(Auth::user()->id));
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('settings.profile', absolute: false), navigate: true);
        return;
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
