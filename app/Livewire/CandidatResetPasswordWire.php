<?php

namespace App\Livewire;

use App\Models\Candidat;
use App\Models\PasswordResetToken;
use App\Rules\StrongPassword;
use App\Traits\WithRateLimiter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Validation\Rules;

#[Layout('components.layouts.guest')]
class CandidatResetPasswordWire extends Component
{
    use WithRateLimiter;
    public $token = null;
    public $message;
    public $password_confirmation;
    public $password;
    public function mount($token){
        $token = PasswordResetToken::where('token',$token)->firstOrFail();
        $this->token = $token;

        if(Carbon::parse($token->created_at)->addMinutes(15)->isPast()){
            $token->delete();
            abort(404,'token expire');
        }


    }

    public function save(){
        $this->rateLimiter();
        $validated = $this->validate([
            'password'      => ['required', 'string', 'confirmed', Rules\Password::defaults(), new StrongPassword],
        ]);

        $candidat = Candidat::where('email',$this->token->email)->first();
        $candidat->password = Hash::make($validated['password']);
        try{
            $candidat->save();
            $this->token->delete();
            // todo set message with redirection
            session('mot de passe reset');
            redirect()->route('guest.candidat.connexion');
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        
    }
    public function render()
    {
        return view('livewire.candidat-reset-password-wire');
    }
}
