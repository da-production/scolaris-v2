<?php

namespace App\Livewire\Candidat;

use App\Models\Candidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;

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

    public function mount(){
        /**
         * Todo:
         * 1- check if the app is open in option or not
         */
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
            $this->addError('password','Candidat introuvable');
            return;
        }

        if(Hash::check($this->password,$candidat->password)){
            Auth::guard('candidat')->login($candidat);        
            return redirect()->route('candidat.profile');
        }else{
            $this->addError('password','crediential wrong');
            return;
        }

    }
}
