<?php

namespace App\Livewire\Auth;

use App\Actions\LogAction;
use App\Events\UserAuthEvent;
use App\Livewire\Actions\Login;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
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
        $this->code = preg_replace('/\s+/', '', $this->code);
        $otp = Otp::where('code',$this->code)->first();
        Auth::loginUsingId($otp->user_id,$this->remember);
        Otp::where('user_id',$otp->user_id)->delete();
        LogAction::store(request(),request()->user()->id,'otp login','User',[
            'email' => $otp->email,
        ],'Login with OTP');

        $this->broadcastLogoutEvent();
        
        Session::regenerate();
        // login user
        return redirect()->route('settings.profile');
    }

    private function broadcastLogoutEvent(){
        if(config('app.enable_reverb')){
            Broadcast::event(new UserAuthEvent(Auth::user()->id));
        }
    }
}
