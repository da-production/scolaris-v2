<?php

namespace App\Livewire\Candidat;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class CandidatureWire extends Component
{
    public function render()
    {
        return view('livewire.candidat.candidature-wire');
    }
}
