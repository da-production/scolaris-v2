<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class CacheWire extends Component
{
    public function clearConfig() {
        Artisan::call('config:clear');
        session()->flash('message', 'Configuration cache cleared!');
    }

    public function clearRoute() {
        Artisan::call('route:clear');
        session()->flash('message', 'Route cache cleared!');
    }

    public function clearView() {
        Artisan::call('view:clear');
        session()->flash('message', 'View cache cleared!');
    }

    public function clearAppCache() {
        Artisan::call('cache:clear');
        session()->flash('message', 'Application cache cleared!');
    }

    public function clearAll() {
        Artisan::call('optimize:clear');
        session()->flash('message', 'All caches cleared!');
    }

    public function render()
    {
        return view('livewire.cache-wire');
    }
}
