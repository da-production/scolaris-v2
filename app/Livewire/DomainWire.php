<?php

namespace App\Livewire;

use App\Actions\OrderItem;
use App\Models\Domain;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class DomainWire extends Component
{
    use WithPagination;


    public $id;
    public $name_fr;
    public $name_ar;
    public $description;
    public $is_active;

    public function render()
    {
        $domains = Domain::orderBy('order')->get();
        return view('livewire.domain-wire', compact('domains'));
    }

    public function save()
    {
        if (is_null($this->id)) {
            $this->store();
            $this->flushCache();
        } else {
            $this->update();
            $this->flushCache();
        }
    }

    protected function store(){
        $validate = $this->validate([
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'description'  => ['nullable','max:255'],
            'is_active'   => ['nullable','boolean'],
        ]);

        Domain::create($validate);

        $this->reset();

        Flux::modal('add-domain-modal')->close();
    }

    protected function update(){
        $validate = $this->validate([
            'name_fr'      => ['required','min:10','max:255'],
            'name_ar'      => ['required','min:10','max:255'],
            'description'  => ['nullable','max:255'],
            'is_active'   => ['nullable','boolean'],
        ]);
        Domain::where('id',$this->id)
        ->update($validate);
        $this->reset();

        Flux::modal('add-domain-modal')->close();
    }

    
    public function editDomain(Domain $motif){
        $this->id = $motif->id;
        $this->name_fr = $motif->name_fr;
        $this->name_ar = $motif->name_ar;
        $this->is_active = $motif->is_active ? true : false;
        Flux::modal('add-domain-modal')->show();

    }

    public function flushCache(){
        Cache::forget('domains');
        Cache::flush('domain');
    }

    public function updateOrder($items){
        OrderItem::handle(
            $items,
            Domain::class
        );
        $this->flushCache();
    }
}
