<?php

namespace App\Livewire;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SmtpOptionWire extends Component
{
    public $form = [];
    public function mount(){
        $options = Option::where('model_type', 'smtp')->get();
        foreach ($options as $option) {
            $this->form[$option->name] = $option->value;
        }
    }

    public function updated($fields, $v){
        try{
            DB::beginTransaction();
            foreach ($this->form as $name => $value) {
                DB::table('options')->updateOrInsert(
                    ['name' => $name, 'model_type' => 'smtp'],
                    ['value' => $value, 'updated_at' => now()]
                );
            }
            DB::commit();
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Les options ont été mises à jour avec succès.'
            ]);
            Cache::forget('smtp');
        }catch (\Exception $e){
            DB::rollBack();
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Une erreur est survenue lors de la mise à jour des options.'
            ]);
            Log::error('Erreur lors de la mise à jour des options : ' . $e->getMessage());
        }
    }

    public function clearCache(){
        Cache::forget('smtp');
        // TODO: add toaster
    }

    public function render()
    {
        return view('livewire.smtp-option-wire');
    }
}
