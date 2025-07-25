<?php

namespace App\Livewire;

use App\Actions\OrderItem;
use App\Models\Filiere;
use App\Models\SousSpecialite;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class SpecialiteWire extends Component
{
    public $id;
    public $sous_specialite_id;
    public $specialite_concour_id;
    public $filiere_id;
    public $code;
    public $name_fr;
    public $name_ar;
    public $coefficient;
    public $description;
    public $ponderation;
    public $sous_specialites;
    public bool $is_active = false;


    public function render()
    {
        $specialites = Specialite::with('specialiteConcour')->orderBy('order')->get();
        $cSpecialites = SpecialiteConcour::all();
        $filieres = Filiere::all();
        return view('livewire.specialite-wire', compact('specialites','filieres','cSpecialites'));
    }

    public function save(){
        if(is_null($this->id)){
            $this->store();
            $this->flushCache();
        }else{
            $this->update();
            $this->flushCache();
        }
    }
    private function store(){
        $validate = $this->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'coefficient' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);
        
        try{
            Specialite::create($validate);
            $this->reset();
            Flux::modal('add-specialite-modal')->close();
            Toaster::success('User created!'); // 👈
            session()->flash('message', 'Specialite created successfully.');
        }catch(\Exception $e){
            Log::error('Error creating specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while saving the specialite: ' . $e->getMessage());
            return;
        }
    }

    private function update(){
        $validate = $this->validate([
            'filiere_id'            => 'required|exists:filieres,id',
            'specialite_concour_id' => 'required|exists:specialite_concours,id',
            'name_fr'               => 'required',
            'name_ar'               => 'nullable',
            'coefficient' => 'nullable|numeric',
            'description'           => 'nullable|string',
            'is_active'             => 'nullable|boolean'
        ]);

        try{
            Specialite::where('id',$this->id)->update($validate);
            $this->reset();
            Flux::modal('add-specialite-modal')->close();
            session()->flash('message', 'Specialite updated successfully.');
        }catch(\Exception $e){
            Log::error('Error updating specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the specialite: ' . $e->getMessage());
            return;
        }
    }

    public function flushCache(){
        // Flush the cache 
        Cache::flush('specialite_concours_filiers');
    }

    public function editSpecialite(Specialite $specialite){
        $this->reset();
        Flux::modal('add-specialite-modal')->show();
        $this->id                       = $specialite->id;
        $this->filiere_id               = $specialite->filiere_id;
        $this->specialite_concour_id    = $specialite->specialite_concour_id;
        $this->name_fr                  = $specialite->name_fr;
        $this->name_ar                  = $specialite->name_ar;
        $this->coefficient = $specialite->coefficient;
        $this->description              = $specialite->description;
        $this->is_active                = $specialite->is_active;
    }

    public function clearForm(){
        Flux::modal('add-specialite-modal')->close();
        Flux::modal('add-sous-specialite-modal')->close();
        Flux::modal('display-sous-specialites-modal')->close();
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

    public function deleteSousSpecialite(SousSpecialite $sousSpecialite){
        try{
            $sousSpecialite->delete();
            session()->flash('message', 'Sous Specialite deleted successfully.');
            $this->sous_specialites = $sousSpecialite->specialite->sousSpecialites;
        }catch(\Exception $e){
            Log::error('Error deleting sous specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while deleting the sous specialite: ' . $e->getMessage());
        }
    }

    public function createSousSpecialite(Specialite $specialite){
        $this->reset();
        Flux::modal('add-sous-specialite-modal')->show();
        $this->id = $specialite->id;
    }

    public function saveSousSpecialite(){
        if(is_null($this->sous_specialite_id)){
            $this->storeSousSpecialite();
        }else{
            $this->updateSousSpecialite();
        }
    }

    public function storeSousSpecialite(){
        $this->validate([
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'ponderation' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        try{
            Specialite::find($this->id)->sousSpecialites()->create([
                'name_fr' => $this->name_fr,
                'name_ar' => $this->name_ar,
                'ponderation' => $this->ponderation,
                'description' => $this->description,
                'is_active' => $this->is_active
            ]);
            $this->reset();
            Flux::modal('add-sous-specialite-modal')->close();
            session()->flash('message', 'la Sous Specialite a été créée avec succès.');
        }catch(\Exception $e){
            Log::error('Error creating sous specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while saving the sous specialite: ' . $e->getMessage());
        }
    }

    public function updateSousSpecialite(){
        $this->validate([
            // 'code' => ['required', 'string', 'max:255', Rule::unique('sous_specialites')->ignore($this->sous_specialite_id)],
            'name_fr' => 'required',
            'name_ar' => 'nullable',
            'ponderation' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        try{
            SousSpecialite::where('id',$this->sous_specialite_id)->update([
                'name_fr' => $this->name_fr,
                'name_ar' => $this->name_ar,
                'ponderation' => $this->ponderation,
                'description' => $this->description,
                'is_active' => $this->is_active
            ]);
            session()->flash('message', 'Sous Specialite updated successfully.');
        }catch(\Exception $e){
            Log::error('Error updating sous specialite: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the sous specialite: ' . $e->getMessage());
        }
    }

    public function editSousSpecialite(SousSpecialite $sousSpecialite){
        $this->sous_specialite_id = $sousSpecialite->id;
        $this->code = $sousSpecialite->code;
        $this->name_fr = $sousSpecialite->name_fr;
        $this->name_ar = $sousSpecialite->name_ar;
        $this->ponderation = $sousSpecialite->ponderation;
        $this->description = $sousSpecialite->description;
        $this->is_active = $sousSpecialite->is_active;
    }

    public function displaySousSpecialites(Specialite $specialite){
        $this->reset();
        Flux::modal('display-sous-specialites-modal')->show();
        $this->sous_specialites = $specialite->sousSpecialites;
    }

    public function updateOrder($items){
        OrderItem::handle(
            $items,
            Specialite::class
        );
        $this->flushCache();
    }
}
