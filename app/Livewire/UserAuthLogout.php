<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAuthLogout extends Component
{

    public function getListeners()
    {
        $id =  Auth::user()->id;
        return [
            "echo-private:user.auth.{$id},UserAuthEvent" => 'handleLoginConflict',
        ];
    }

    public function handleLoginConflict($payload)
    {
        Auth::logout();
        return redirect()->route('login')->with('auth_conflict', 'Votre session a été fermée car votre compte a été utilisé sur un autre appareil.');
    }
    
    public function render()
    {
        return view('livewire.user-auth-logout');
    }
}
