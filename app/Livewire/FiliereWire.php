<?php

namespace App\Livewire;

use App\Models\Filiere;
use Flux\Flux;
use Livewire\Component;

class FiliereWire extends Component
{
    public $id;
    public $name_fr;
    public $name_ar;
    public $is_visible;

    public function render()
    {
        $filieres = Filiere::orderBy('created_at','DESC')->get();
        return view('livewire.filiere-wire',compact('filieres'));
    }

    public function save(){
        if(is_null($this->id)){
            return $this->store();
        }else{
            return $this->update();
        }
    }

    protected function store(){
        $this->validate([
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'is_visible'   => ['nullable','boolean'],
        ]);

        Filiere::create([
            ...$this->only('name_fr','name_ar'),
            'is_visible'    => $this->is_visible ? true : false
        ]);

        $this->reset();

        Flux::modal('add-filiere-modal')->close();
    }

    protected function update(){
        $this->validate([
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'is_visible'   => ['nullable','boolean'],
        ]);
        Filiere::where('id',$this->id)
        ->update([
            ...$this->only('name_fr','name_ar'),
            'is_visible'    => $this->is_visible ? true : false
        ]);

        $this->reset();

        Flux::modal('add-filiere-modal')->close();
    }

    public function editMotif(Filiere $motif){
        $this->id = $motif->id;
        $this->name_fr = $motif->name_fr;
        $this->name_ar = $motif->name_ar;
        $this->is_visible = $motif->is_visible ? true : false;
        Flux::modal('add-filiere-modal')->show();

    }

    public function clearForm(){
        Flux::modal('add-filiere-modal')->close();
        $this->reset();
    }

    public function delete(Filiere $motif){
        $motif->delete();
    }
}
