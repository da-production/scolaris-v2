<?php

namespace App\Livewire;

use App\Models\Candidature;
use Livewire\Component;

class CandidaturesWire extends Component
{
    public function render()
    {
        $candidatures = Candidature::orderBy("moyenne",'DESC')
        ->with('candidat')
        ->paginate(15);
        return view('livewire.candidatures-wire',compact('candidatures'));
    }
}
