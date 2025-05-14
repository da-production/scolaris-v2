<?php

namespace App\Livewire;

use App\Models\Exercice;
use Livewire\Component;

class CreateExerciseWire extends Component
{
    public $opened_at;
    public $closed_at;
    public $closed_trait;
    public $displayed_at;
    public $conditions;
    public $note;
    public $is_closed = false;

    public $error = null;
    public function render()
    {
        return view('livewire.create-exercise-wire');
    }

    public function store()
    {
        $this->reset('error');
        $currentYear = now()->year;
        $exists = Exercice::where('annee', $currentYear)->exists();
        if ($exists) {
            $this->error = "L'exercice $currentYear existe déjà.";
            return;
        }
        $this->validate([
            'opened_at' => 'required|date',
            'closed_at' => 'required|date',
            'closed_trait' => 'required|date',
            'displayed_at' => 'required|date',
            'conditions' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        try{
            $exercice = Exercice::create([
                'annee' => date('Y'),
                'opened_at' => $this->opened_at,
                'closed_at' => $this->closed_at,
                'closed_trait' => $this->closed_trait,
                'displayed_at' => $this->displayed_at,
                'conditions' => $this->conditions,
                'note' => $this->note,
                'is_closed' => $this->is_closed,
                // Exercice::CREATED_AT => now(),
            ]);
            Exercice::where('id','!=',$exercice->id)
            ->update([
                'is_closed' => true
            ]);
            // Reset the form
            $this->reset();
            // Optionally, you can redirect or show a success message
            session()->flash('message', 'Exercise created successfully.');
            return redirect()->route('administrateur.options.exercices');
        }catch(\Exception $e){
            // Handle the exception
            session()->flash('error', 'An error occurred while creating the exercise: ' . $e->getMessage());
            return;
        }
        

    }
}
