<?php

namespace App\Livewire;

use App\Actions\OrderItem;
use App\Models\Motif;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MotifWire extends Component
{
    
    public $id;
    public $name_fr;
    public $name_ar;
    public $is_visible;

    public function render()
    {
        $motifs = Motif::orderBy('order')->get();
        return view('livewire.motif-wire', compact('motifs'));
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
        $this->validate([
            'name_fr'      => ['required','min:1','max:255'],
            'name_ar'      => ['required','min:1','max:255'],
            'is_visible'   => ['nullable','boolean'],
        ]);

        Motif::create([
            ...$this->only('name_fr','name_ar'),
            'is_visible'    => $this->is_visible ? true : false
        ]);

        $this->reset();

        Flux::modal('add-motif-modal')->close();
    }

    protected function update(){
        $this->validate([
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'is_visible'   => ['nullable','boolean'],
        ]);
        Motif::where('id',$this->id)
        ->update([
            ...$this->only('name_fr','name_ar'),
            'is_visible'    => $this->is_visible ? true : false
        ]);

        $this->reset();

        Flux::modal('add-motif-modal')->close();
    }

    public function editMotif(Motif $motif){
        $this->id = $motif->id;
        $this->name_fr = $motif->name_fr;
        $this->name_ar = $motif->name_ar;
        $this->is_visible = $motif->is_visible ? true : false;
        Flux::modal('add-motif-modal')->show();

    }

    public function clearForm(){
        Flux::modal('add-motif-modal')->close();
        $this->reset();
    }

    public function delete(Motif $motif){
        $motif->delete();
    }

    public function flushCache(){
        // Flush the cache 
        Cache::forget('motifs');
    }

    public function updateOrder($items){
        OrderItem::handle(
            $items,
            Motif::class
        );
        $this->flushCache();
    }
}
