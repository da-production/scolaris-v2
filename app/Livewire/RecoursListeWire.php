<?php

namespace App\Livewire;

use App\Models\Recour;
use Livewire\Component;
use Livewire\WithPagination;

class RecoursListeWire extends Component
{
    use WithPagination;
    public function render()
    {
        $recours = Recour::query()
            ->with(['candidature', 'candidature.candidat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.recours-liste-wire',compact('recours'));
    }
}
