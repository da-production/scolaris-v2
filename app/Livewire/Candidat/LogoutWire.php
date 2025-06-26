<?php

namespace App\Livewire\Candidat;

use Livewire\Component;

class LogoutWire extends Component
{
    public function render()
    {
        return view('livewire.candidat.logout-wire');
    }

    public function logout()
    {
        auth()->guard('candidat')->logout();
        
        // Invalidate session and regenerate token
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        session()->flash('success', 'Vous avez été déconnecté avec succès.');
        return redirect()->route('home');
    }
}
