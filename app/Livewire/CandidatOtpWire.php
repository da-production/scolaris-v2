<?php

namespace App\Livewire;

use App\Models\Candidat;
use App\Models\Option;
use App\Models\Otp;
use App\Traits\WithRateLimiter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class CandidatOtpWire extends Component
{
    
    use WithRateLimiter;
    public $code;
    public $token;
    public $remember;

    protected $queryString = ['token'];

    public function mount(){

        $options = [];
        $getOptions = Cache::rememberForever('options_inscription', function(){
            return Option::where('model_type', 'inscription')->get();
        });
        foreach ($getOptions as $option) {
            $options[$option->name] = $option->value;
        }
        $options = collect($options);
        if(!is_null($options) && $options instanceof Collection){
            if(!$options->get('candidat_login_otp')){
                return redirect()->route('guest.candidat.connexion');
            }

        }

        if(is_null($this->token)) redirect()->route('login');

        $token = Otp::where('token',$this->token)->firstOrFail();
        if($token->created_at->addMinutes(15)->isPast()) {
            $token->delete();
            return redirect()->route('guest.candidat.connexion');
        }

        
    }
    public function render()
    {
        return view('livewire.candidat-otp-wire');
    }

    public function login(){
        $this->rateLimiter();
        $otp = Otp::where([
                ['token',$this->token],
                ['code',$this->code]
            ])->first();
        if(is_null($otp)){
            $this->addError('code','Le code OTP est incorrect. Veuillez réessayer.');
        }else{
            $candidat = Candidat::where('id',$otp->candidat_id)->first();
            if(is_null($candidat)){
                $this->addError('code','Le candidat est introuvable.');
            }else{
                Auth::guard('candidat')->login($candidat);
                $otp->delete();
                return redirect()->route('candidat.profile');
            }
        }
    }
}
