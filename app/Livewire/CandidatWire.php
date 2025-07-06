<?php

namespace App\Livewire;

use App\Models\Candidat;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CandidatWire extends Component
{
    public $candidat;

    #[Computed]
    public function profilePhotoUrl(): string | null
    {
        return imageToBase64($this->candidat->profile_picture);
    }

    public function mount(Candidat $candidat){
        $this->candidat = $candidat->load('candidature');
    }
    public function render()
    {
        return view('livewire.candidat-wire');
    }
}
