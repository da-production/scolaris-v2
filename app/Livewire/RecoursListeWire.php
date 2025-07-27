<?php

namespace App\Livewire;

use App\Models\Recour;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class RecoursListeWire extends Component
{
    use WithPagination;
    public $recour;
    public $candidatureRecours = [];
    public $content;
    public function render()
    {
        $recours = Recour::query()
            ->whereNull('user_id')
            ->with(['candidature', 'candidature.candidat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.recours-liste-wire',compact('recours'));
    }

    public function openModal(Recour $recour)
    {
        $this->loadRecoursModal($recour);
        Flux::modal('display-recour')
            ->show();
    }

    public function loadRecoursModal(Recour $recour){
        $this->recour = $recour;
        $this->candidatureRecours = Recour::where('candidature_id', $recour->candidature_id)->get();
    }

    public function save(){
        $this->validate([
            'content' => 'required|min:10|max:5000',
        ]);

        Recour::create([
            'candidature_id' => $this->recour->candidature->id,
            'user_id' => auth()->user()->id,
            'content' => $this->content,
            'status' => 'EN_ATTENTE'
        ]);
        $this->reset("content");
        $this->loadRecoursModal($this->recour);
        $this->dispatch('$refresh');
    }

    public function setStatus($status)
    {
        $this->recour->update(['status' => $status]);
        $this->loadRecoursModal($this->recour);
        $this->dispatch('$refresh');
    }

    public function clearForm()
    {
        Flux::modal("display-recour")->close();
        $this->reset("content","recour","candidatureRecours");
    }
}
