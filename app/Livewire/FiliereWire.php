<?php

namespace App\Livewire;

use App\Actions\OrderItem;
use App\Models\Domain;
use App\Models\Filiere;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class FiliereWire extends Component
{
    public $id;
    public $name_fr;
    public $name_ar;
    public $domain_id;
    public $is_active;

    public function render()
    {
        $filieres = Filiere::with('domain')->orderBy('order')->get();
        $domains = Domain::all();
        return view('livewire.filiere-wire',compact('filieres','domains'));
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

    protected function store(){
        $validate = $this->validate([
            'domain_id'     => ['required','exists:domains,id'],
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'is_active'   => ['nullable','boolean'],
        ]);

        Filiere::create($validate);

        $this->reset();

        Flux::modal('add-filiere-modal')->close();
    }

    protected function update(){
        $validate = $this->validate([
            'domain_id'     => ['required','exists:domains,id'],
            'name_fr'       => ['required','min:10','max:255'],
            'name_ar'       => ['required','min:10','max:255'],
            'is_active'    => ['nullable','boolean'],
        ]);
        Filiere::where('id',$this->id)
        ->update($validate);

        $this->reset();

        Flux::modal('add-filiere-modal')->close();
    }

    public function flushCache(){
        // Flush the cache 
        Cache::forget('filiers');
        Cache::flush('domain');
        Cache::flush('specialite_concours_filiers');
    }
    
    public function editMotif(Filiere $motif){
        $this->id = $motif->id;
        $this->name_fr = $motif->name_fr;
        $this->name_ar = $motif->name_ar;
        $this->domain_id = $motif->domain_id;
        $this->is_active = $motif->is_active ? true : false;
        Flux::modal('add-filiere-modal')->show();

    }

    public function clearForm(){
        Flux::modal('add-filiere-modal')->close();
        $this->reset();
    }

    public function delete(Filiere $motif){
        $motif->delete();
    }

    public function updateOrder($items){
        OrderItem::handle(
            $items,
            Filiere::class
        );
        $this->flushCache();
    }
}
