<?php

namespace App\Livewire;

use App\Models\Domain;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class SpecialiteConcourWire extends Component
{
    use WithPagination;
    public $id= null;
    public $code;
    public $name_fr;
    public $name_ar;
    public $is_active;
    public $description;


    public function render()
    {
        $specialites = SpecialiteConcour::paginate();
        return view('livewire.specialite-concour-wire',compact('specialites'));
    }

    public function save()
    {
        if(is_null($this->id)){
            $this->store();
        }else{
            $this->update();
        }
    }

    protected function store(){
        $validate = $this->validate([
            'code' => 'required|unique:specialite_concours,code',
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        SpecialiteConcour::create($validate);

        $this->reset();
        Flux::modal('add-specialite-concour-modal')->close();
    }

    public function edit(SpecialiteConcour $specialiteConcour)
    {
        $this->id = $specialiteConcour->id;
        $this->code = $specialiteConcour->code;
        $this->name_fr = $specialiteConcour->name_fr;
        $this->name_ar = $specialiteConcour->name_ar;
        $this->description = $specialiteConcour->description;
        $this->is_active = $specialiteConcour->is_active;
        Flux::modal('add-specialite-concour-modal')->show();

    }

    public function update()
    {
        $validate = $this->validate([
            'code' => ['required', 'unique:specialite_concours,code,' . $this->id],
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        SpecialiteConcour::where('id', $this->id)->update($validate);

        $this->reset();
        Flux::modal('add-specialite-concour-modal')->close();
    }

    public function clearForm(){
        Flux::modal('add-specialite-concour-modal')->close();
        $this->reset();
    }
}
