<?php

namespace App\Livewire\Candidat;

use App\Models\Candidat;
use App\Rules\UniqueConcatenatedColumns;
use App\Services\OptionSingleton;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\Rules;

#[Layout('components.layouts.guest')]
class RegisterWire extends Component
{
    // Rate limit
    public string $rateErrorMessage = '';
    public int $rateTentatives = 0;
    public int $rateDuration = 0;
    
    // public $nin;
    public $numero_bac;
    public $annee_bac;
    public $email;
    public $password;
    public $password_confirmation;
    public $processing = false;
    public $valide;

    protected $optionSingleton;
    public function mount(OptionSingleton $optionSingleton){
        $this->optionSingleton = $optionSingleton;
        /**
         * Todo:
         * 1- check if the app is open in option or not
         * 2- check if the exercice is closed or not
         * 3- check if incsription is expired or not
         */
    }

    public function render()
    {
        return view('livewire.candidat.register-wire');
    }

    public function updated(){
        
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

    public function register()
    {
        abort_if(!canCandidatUpdate(),403,
            'Les inscriptions sont clôturées. Vous ne pouvez plus vous inscrire pour l\'exercice en cours.'
        );

        $this->rateLimiter();

        /**
         * TODO Check if user can register using date clôture in admin panel
         */
        $validated = $this->validate([
            'email'         => ['required', 'string', 'email', 'max:255'],
            'numero_bac'    => ['required', 'numeric','digits:8'],
            'annee_bac'     => ['required', 'integer','digits:4', 'max:' . now()->year],
            'password'      => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if($this->exist()){
            $this->addError('email', 'Un compte existe déjà avec ce numéro de bac, cette année de bac et cet email pour l\'exercice en cours.');
            return;
        }

        $validated['password'] = Hash::make($validated['password']);
        // Ensure the NIN + email + exercie is unique across all candidates
        $candidat = Candidat::create([
            'email'     => $validated['email'],
            'numero_bac'=> $validated['numero_bac'],
            'annee_bac' => $validated['annee_bac'],
            'password'  => $validated['password'],
            'exercice'  => now(),
        ]);

        Auth::guard('candidat')->login($candidat);

        session()->flash('success', 'Inscription réussie ! Bienvenue dans votre espace candidat.');

        return redirect()->route('candidat.profile');
    }

    public function exist(){

        $this->valide = Candidat::where('numero_bac', $this->numero_bac)
            ->where('annee_bac', $this->annee_bac)
            ->where('email', $this->email)
            ->where('exercice', date('Y'))
            ->exists();

        return $this->valide;
    }
}
