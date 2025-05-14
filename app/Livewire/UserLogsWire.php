<?php

namespace App\Livewire;

use App\Models\Log;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class UserLogsWire extends Component
{
    use WithPagination;

    public $log;
    public function render()
    {
        $logs = Log::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'DESC')
            ->with('user')
            ->paginate(15);
        return view('livewire.user-logs-wire',compact('logs'));
    }

    
    public function detail(Log $log){
        $this->log = $log;
        Flux::modal('log-detail-modal')->show();
    }

    public function clear(){
        $this->log = null;
        Flux::modal('log-detail-modal')->close();
    }
}
