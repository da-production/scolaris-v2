<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.closed')]
class ClosedSiteWire extends Component
{
    public function mount()
    {
        // You can add any initialization logic here if needed
        if(canCandidatUpdate()){
            // If the application is open for registration, redirect to the registration page
            return redirect()->route('guest.candidat.inscription');
        }
    }
    public function render()
    {
        return view('livewire.closed-site-wire');
    }
}
