<?php

namespace App\Livewire;

use App\Events\LogoutUserEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Livewire\Attributes\On;
use Livewire\Component;

class ConnectedUserWire extends Component
{
    public array $onlineUsers = [];
    protected $listeners = [
        'user-joined' => 'handleUserJoined',
        'user-left' => 'handleUserLeft',
    ];
    public function render()
    {
        return view('livewire.connected-user-wire');
    }
    public function handleUserJoined($user)
    {
        $user = User::find($user['id']);
        if($user->id != auth()->user()->id){
            $this->onlineUsers[] = $user;
        }
    }

    public function handleUserLeft($user)
    {
        $this->onlineUsers = collect($this->onlineUsers)
            ->reject(fn ($u) => $u->id === $user['id'])
            ->values()
            ->all();
    }

    public function logoutUser($id){
        Broadcast::event(new LogoutUserEvent($id));
    }

    #[On('Login:logoutUser')]
    public function logoutUserAction($id)
    {
        if($id == Auth::user()->id){
            Auth::logout();
            return redirect()->route('login')->with('auth_conflict', 'Votre session a été fermée par un administrateur.');
        }
    }
}
