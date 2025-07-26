<?php

namespace App\Livewire;

use App\Models\Recour;
use Livewire\Component;

class CandidatRecoursWire extends Component
{
    public $content;
    public $recours;
    public function render()
    {
        $this->fetchAll();
        return view('livewire.candidat-recours-wire');
    }

    public function fetchAll(){
        $this->recours = Recour::where('candidature_id',auth()->guard('candidat')->user()->candidature->id)->get();
    }

    public function clearForm(){
        $this->reset();
    }
}
