<?php

namespace App\Livewire;

use App\Models\Exercice;
use Livewire\Component;
use Livewire\WithPagination;

class ExerciceWire extends Component
{
    use WithPagination;
    public function render()
    {
        $exercices = Exercice::orderBy('annee','DESC')->get();
        return view('livewire.exercice-wire',compact('exercices'));
    }
}
