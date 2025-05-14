<?php

namespace App\Livewire;

use App\Models\Candidat;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CandidatsWire extends Component
{
    use WithPagination;
    public function render()
    {
        $candidats = Candidat::orderBy('id','ASC')->paginate();
        return view('livewire.candidats-wire',compact('candidats'));
    }
}
