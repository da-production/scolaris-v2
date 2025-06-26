<?php

namespace App\Livewire;

use App\Models\Candidature;
use App\Models\Specialite;
use Livewire\Component;

class CandidaturesWire extends Component
{
    public $specialite_id;
    public $specialite;

    public function mount($specialite_id = null)
    {
        $this->specialite_id = $specialite_id;
        $this->specialite = $specialite_id ? Specialite::find($specialite_id) : null;
    }
    public function render()
    {
        $candidatures = Candidature::when($this->specialite_id, function ($query) {
            $query->where('specialite_id', $this->specialite_id);
        })
        ->orderBy("moyenne",'DESC')
        ->with('candidat')
        ->paginate(15);
        return view('livewire.candidatures-wire',compact('candidatures'));
    }
}
