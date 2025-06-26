<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class HomeWire extends Component
{
    public function render()
    {
        return view('livewire.home-wire');
    }
}
