<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\Login;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]

class OtpWire extends Component
{

    public $code;
    public $token;
    public $remember;

    protected $queryString = ['token'];

    public function mount()
    {
        if(is_null($this->token)) redirect()->route('login');

        $token = Otp::where('token',$this->token)->firstOrFail();
        if($token->created_at->addMinutes(15)->isPast()) {
            $token->delete();
            redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.auth.otp-wire');
    }

    public function login()
    {
        /**
         * Login
         */
        $this->validate([
            'code'       => ['required','exists:otps,code'],
        ]);

        $otp = Otp::where('code',$this->code)->first();
        Auth::loginUsingId($otp->user_id,$this->remember);
        Otp::where('user_id',$otp->user_id)->delete();
        Session::regenerate();
        // login user
        return redirect()->route('home');
    }
}
