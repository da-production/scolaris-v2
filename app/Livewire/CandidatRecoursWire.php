<?php

namespace App\Livewire;

use App\Models\Recour;
use Flux\Flux;
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
        $this->recours = Recour::where('candidature_id',auth()->guard('candidat')->user()->candidature?->id)->get();
    }

    public function store(){
        if(count($this->recours) > 0){
            session()->flash('error', 'Vous avez déjà envoyé un recours.');
            return;
        }
        $this->validate([
            'content' => 'required|min:10|max:5000',
        ]);

        Recour::create([
            'candidature_id' => auth()->guard('candidat')->user()->candidature->id,
            'content' => $this->content,
            'status' => 'EN_ATTENTE'
        ]);
        $this->reset("content");
        $this->fetchAll();
    }

    public function clearForm(){
        $this->reset();
        Flux::modal("add-recours")->close();
    }
}
