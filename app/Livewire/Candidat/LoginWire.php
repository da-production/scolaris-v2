<?php

namespace App\Livewire\Candidat;

use App\Events\OtpEvent;
use App\Models\Candidat;
use App\Models\Option;
use App\Models\Otp;
use App\Support\OptionsFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;


#[Layout('components.layouts.guest')]
class LoginWire extends Component
{
     // Rate limit
    public string $rateErrorMessage = '';
    public int $rateTentatives = 0;
    public int $rateDuration = 0;


    public $numero_bac;
    public $annee_bac;
    public $password;
    public Bool $processing = false;

    public $candidat;

    protected  $options;

    public function mount(){
        /**
         * Todo:
         * 1- check if the app is open in option or not
         */
        // $getOptions = Cache::rememberForever('options_inscription', function(){
        //     return Option::where('model_type', 'inscription')->get();
        // });
        // foreach ($getOptions as $option) {
        //     $options[$option->name] = $option->value;
        // }
        // $this->options = collect($options);
        $this->options = OptionsFactory::make('options_inscription');
        
        
    }

    public function resetRateLimiter()
    {
        $this->reset('rateErrorMessage','rateTentatives','rateDuration');
        $this->resetErrorBag('rateErrorMessage');
    }

    public function rateLimiter()
    {
        $cle = 'envoyer-message:' . request()->ip();
        // Stocke les infos
        $this->rateTentatives = RateLimiter::attempts($cle);
        $this->rateDuration = RateLimiter::availableIn($cle);

        if (RateLimiter::tooManyAttempts($cle, 10)) {
            $this->addError('rateErrorMessage', "Trop de tentatives ({$this->rateTentatives}). Réessayez dans {$this->rateDuration} secondes.");
            return;
        }
        RateLimiter::hit($cle, 10); // Reset dans 60 secondes
    }
    
    public function render()
    {
        return view('livewire.candidat.login-wire');
    }

    public function login(){
        $this->rateLimiter();
        /** 
         * Check the records
         * 
         */

        $this->validate([
            'numero_bac'    => ['required','numeric','digits:8'],
            'annee_bac'     => ['required','numeric','digits:4', 'max:' . now()->year],
            'password'      => ['required','max:255']
        ]);

        $candidat = Candidat::where('numero_bac',$this->numero_bac)
        ->where('annee_bac',$this->annee_bac)
        ->whereYear('exercice',Date('Y'))
        ->first();
        if(is_null($candidat)){
            $this->addError('password','Identifiants incorrects. Veuillez réessayer.');
            return;
        }

        if(Hash::check($this->password,$candidat->password)){
            $this->candidat = $candidat;     
        }else{
            $this->addError('password','Identifiants incorrects. Veuillez réessayer.');
            return;
        }

        if(!is_null($this->options) && $this->options instanceof Collection){
            if($this->options->get('candidat_login_otp')){
                $this->loginWithOtp();
                return;
            }
        }
        $this->loginWithoutOtp();
    }

    protected function loginWithoutOtp(){
        /**
         * 
         */
        
        Auth::guard('candidat')->login($this->candidat);
        return redirect()->route('candidat.profile');
    }

    protected function loginWithOtp(){
        /**
         * TODO
         * check if is enabled otp
         * add the logic
         * check if the job is enabled
         */
        $otp    = random_int(000000,999999);
        $token  = Str::random(16);
        Otp::create([
            'candidat_id'   => $this->candidat->id,
            'token'     => $token,
            'code'      => $otp,
            'remember'  => false
        ]);
        
        // run the job
        event(new OtpEvent($otp,$token,$this->candidat));
        return redirect(route('guest.candidat.otp')."?token={$token}");
    }
}
