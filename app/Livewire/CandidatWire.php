<?php

namespace App\Livewire;

use App\Models\Candidat;
use Livewire\Component;

class CandidatWire extends Component
{
    public $candidat;

    public function mount(Candidat $candidat){
        $this->candidat = $candidat->load('candidature');
    }
    public function render()
    {
        return view('livewire.candidat-wire');
    }
}
