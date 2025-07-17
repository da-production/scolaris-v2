<?php

namespace App\Livewire;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScolarisOptionWire extends Component
{
    public $form = [];

    public function mount(){
        $options = Option::where('model_type', 'scolaris')->get();
        foreach ($options as $option) {
            $this->form[$option->name] = $option->value;
        }
    }
    public function render()
    {
        return view('livewire.scolaris-option-wire');
    }

    public function updated($fields, $v){
        if($fields == "form.autorized_emails"){
            $this->form["autorized_emails"] = preg_replace('/\s+/', '', $this->form["autorized_emails"]);
        }
        try{
            DB::beginTransaction();
            foreach ($this->form as $name => $value) {
                DB::table('options')->updateOrInsert(
                    ['name' => $name, 'model_type' => 'scolaris'],
                    ['value' => $value, 'updated_at' => now()]
                );
            }
            DB::commit();
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Les options ont été mises à jour avec succès.'
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Une erreur est survenue lors de la mise à jour des options.'
            ]);
            Log::error('Erreur lors de la mise à jour des options : ' . $e->getMessage());
        }
    }
}
