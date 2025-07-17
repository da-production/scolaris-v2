<?php

namespace App\Livewire;

use App\Actions\OrderItem;
use App\Models\Domain;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
        $specialites = SpecialiteConcour::orderBy('order')->paginate();
        return view('livewire.specialite-concour-wire',compact('specialites'));
    }

    public function save()
    {
        if(is_null($this->id)){
            $this->store();
            $this->flushCache();
        }else{
            $this->update();
            $this->flushCache();
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

    public function flushCache(){
        // Flush the cache 
        Cache::forget('specialite_concours');
        Cache::flush('specialite_concours_filiers');
    }

    public function clearForm(){
        Flux::modal('add-specialite-concour-modal')->close();
        $this->reset();
    }

    public function updateOrder($items){
        OrderItem::handle(
            $items,
            SpecialiteConcour::class
        );
        $this->flushCache();
    }

    public function delete(SpecialiteConcour $specialite){
        try{
            $specialite->delete();
            session()->flash('message', 'Specialite deleted successfully.');
        }catch(\Exception $e){
            Log::error('Error deleting specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while deleting the specialite: ' . $e->getMessage());
        }
    }
}
