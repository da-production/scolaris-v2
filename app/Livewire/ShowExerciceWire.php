<?php

namespace App\Livewire;

use App\Models\Exercice;
use App\Rules\IsYear;
use Carbon\Carbon;
use Livewire\Component;

class ShowExerciceWire extends Component
{
    public Exercice $exercice;

    public $opened_at;
    public $closed_at;
    public $closed_trait;
    public $displayed_at;
    public $conditions;
    public $note;
    public $is_closed = false;

    public $error;

    public function mount(Exercice $exercice){
        $this->exercice     = $exercice;
        $this->opened_at    = $exercice->opened_at;
        $this->closed_at    = $exercice->closed_at;
        $this->closed_trait = $exercice->closed_trait;
        $this->displayed_at = $exercice->displayed_at;
        $this->conditions   = $exercice->conditions;
        $this->note         = $exercice->note;
        $this->is_closed    = $exercice->is_closed ? true : false;
    }

    public function render()
    {
        return view('livewire.show-exercice-wire');
    }

    public function update(){
        $this->validate([
            'opened_at'    => new IsYear($this->exercice->annee),
            'closed_at'    => new IsYear($this->exercice->annee),
            'closed_trait' => new IsYear($this->exercice->annee),
            'displayed_at' => new IsYear($this->exercice->annee),
            'conditions'   => 'nullable',
            'note'         => 'nullable',
            'is_closed'    => 'nullable|boolean',
        ]);

        $this->exercice->update([
            ...$this->except('error','exercice'),
        ]);

        /**
         * TODO if the exercice is closed, 
         * update all candidature to closed for current exercice
         */

    }
}
