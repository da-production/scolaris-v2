<?php

namespace App\Livewire\Candidat;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ProfileWire extends Component
{
    public function render()
    {
        return view('livewire.candidat.profile-wire');
    }
}
