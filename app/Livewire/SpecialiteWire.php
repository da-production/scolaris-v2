<?php

namespace App\Livewire;

use App\Models\Specialite;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SpecialiteWire extends Component
{
    public $id;
    public $code;
    public $name_fr;
    public $name_ar;
    public $coefficient;
    public $description;
    public bool $is_active = false;


    public function render()
    {
        $specialites = Specialite::all();
        return view('livewire.specialite-wire', compact('specialites'));
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
            'code' => 'required|unique:specialites,code',
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'coefficient' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        try{
            Specialite::create([
                'code' => $this->code,
                'name_fr' => $this->name_fr,
                'name_ar' => $this->name_ar,
                'coefficient' => $this->coefficient,
                'description' => $this->description,
                'is_active' => $this->is_active
            ]);
            $this->reset();
            Flux::modal('add-specialite-modal')->close();
            session()->flash('message', 'Specialite created successfully.');
        }catch(\Exception $e){
            Log::error('Error creating specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while saving the specialite: ' . $e->getMessage());
            return;
        }
    }

    private function update(){
        $this->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('specialites')->ignore($this->id)],
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'coefficient' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try{
            Specialite::where('id',$this->id)->update([
                'code' => $this->code,
                'name_fr' => $this->name_fr,
                'name_ar' => $this->name_ar,
                'coefficient' => $this->coefficient,
                'description' => $this->description,
                'is_active' => $this->is_active
            ]);
            $this->reset();
            Flux::modal('add-specialite-modal')->close();
            session()->flash('message', 'Specialite updated successfully.');
        }catch(\Exception $e){
            Log::error('Error updating specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the specialite: ' . $e->getMessage());
            return;
        }
    }

    public function editSpecialite(Specialite $specialite){
        $this->reset();
        Flux::modal('add-specialite-modal')->show();
        $this->id = $specialite->id;
        $this->code = $specialite->code;
        $this->name_fr = $specialite->name_fr;
        $this->name_ar = $specialite->name_ar;
        $this->coefficient = $specialite->coefficient;
        $this->description = $specialite->description;
        $this->is_active = $specialite->is_active;
    }

    public function clearForm(){
        Flux::modal('add-specialite-modal')->close();
        $this->reset();
    }

    public function delete(Specialite $specialite){
        try{
            $specialite->delete();
            session()->flash('message', 'Specialite deleted successfully.');
        }catch(\Exception $e){
            Log::error('Error deleting specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while deleting the specialite: ' . $e->getMessage());
        }
    }
}
