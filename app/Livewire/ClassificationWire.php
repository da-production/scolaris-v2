<?php

namespace App\Livewire;

use App\Models\Classification;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ClassificationWire extends Component
{
    public $id;
    public $code;
    public $moyen;
    public $description;

    public function render()
    {
        $classifications = Classification::all();
        return view('livewire.classification-wire',compact('classifications'));
    }

    public function save(){
        if(is_null($this->id)){
            $this->store();
        }else{
            $this->update();
        }
    }

    private function store(){
        $this->validate([
            'code' => 'required|unique:classifications,code',
            'moyen' => 'required',
            'description' => 'nullable|string'
        ]);
        try{
            Classification::create([
                'code' => $this->code,
                'moyen' => $this->moyen,
                'description' => $this->description
            ]);
            Flux::modal('add-class-modal')->close();
            $this->reset();
            session()->flash('message', 'Classification created successfully.');
        }catch(\Exception $e){
            session()->flash('error', 'An error occurred while saving the classification: ' . $e->getMessage());
            return;
        }
    }

    private function update(){
        $this->validate([
            'code' => ['required', Rule::unique('classifications')->ignore($this->id)],
            'moyen' => 'required',
            'description' => 'nullable|string'
        ]);
        try{
            Classification::where('id',$this->id)->update([
                'code' => $this->code,
                'moyen' => $this->moyen,
                'description' => $this->description
            ]);
            Flux::modal('add-class-modal')->close();
            $this->reset();
            session()->flash('message', 'Classification updated successfully.');
        }catch(\Exception $e){
            session()->flash('error', 'An error occurred while updating the classification: ' . $e->getMessage());
            return;
        }
    }

    public function editClassification(Classification $classification){
        $this->reset();
        $this->id = $classification->id;
        $this->code = $classification->code;
        $this->moyen = $classification->moyen;
        $this->description = $classification->description;
        Flux::modal('add-class-modal')->show();
    }

    
    public function clearForm(){
        Flux::modal('add-class-modal')->close();
        $this->reset();
    }
}
