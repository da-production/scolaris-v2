<?php

namespace App\Livewire;

use App\Helpers\JobPayloadParser;
use App\Support\ExerciceFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class FailedJobsWire extends Component
{
    use WithPagination;

    public $search = '';

    public $job = null;

    public function retry($id)
    {
        try {
            Artisan::call("queue:retry", ['id' => $id]);
            session()->flash('message', "Job $id relancé avec succès.");
        } catch (\Exception $e) {
            session()->flash('error', "Échec du relancement du job $id : " . $e->getMessage());
        }
    }

    public function forget($id)
    {
        try {
            Artisan::call("queue:forget", ['id' => $id]);
            session()->flash('message', "Job $id supprimé avec succès.");
        } catch (\Exception $e) {
            session()->flash('error', "Échec de la suppression du job $id : " . $e->getMessage());
        }
    }

    public function displayFialed($id){
        $this->job = DB::table('failed_jobs')
            ->where('id', $id)
            ->first();
        $this->job->payload = JobPayloadParser::parse($this->job->payload);
        Flux::modal('display-detail')->show();
    }

    public function clear()
    {
        $this->reset('job');
        Flux::modal('display-detail')->close();
    }

    public function render()
    {
        
        $failedJobs = DB::table('failed_jobs')
            ->when($this->search, fn($q) => $q->where('exception', 'like', "%{$this->search}%"))
            ->orderBy('failed_at', 'desc')
            ->paginate(10);
        return view('livewire.failed-jobs-wire', [
            'failedJobs' => $failedJobs,
        ]);
    }

    public function deleteJobs(){
        DB::table('failed_jobs')->delete();
        // todo: add success message
    }
}
