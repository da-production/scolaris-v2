<?php

namespace App\Livewire\Candidat;

use App\Models\Candidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class LoginWire extends Component
{
    public $numero_bac;
    public $annee_bac;
    public $password;
    public Bool $processing = false;

    public function render()
    {
        return view('livewire.candidat.login-wire');
    }

    public function login(){
        sleep(1);
        /** 
         * Check the records
         * 
         */

        $this->validate([
            'numero_bac'    => ['required','string','max:255'],
            'annee_bac'     => ['required','string','max:255'],
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
