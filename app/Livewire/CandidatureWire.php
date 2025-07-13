<?php

namespace App\Livewire;

use App\CandidatureStatusEnum;
use App\Models\Candidature;
use App\Models\Document;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CandidatureWire extends Component
{
    public $candidature;
    public $decision;
    public $motif;
    public $description;

    #[Computed]
    public function profilePhotoUrl(): string | null
    {
        return imageToBase64($this->candidature->candidat->profile_picture);
    }
    public function mount(Candidature $candidature)
    {
        $this->candidature = $candidature->load('document','candidat', 'classification', 'specialite', 'filiere', 'specialite_concour','domain');
        $this->decision = $this->candidature->decision;
    }


    public function download(Document $document)
    {
        abort_unless(auth()->user()->can(['view candidature files']),403);
        $disk = 'private';
        $path = $document->file_path;
        if (!Storage::disk($disk)->exists($path)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk($disk)->download($path, $document->file_name);
    }

    public function render()
    {
        $motifs = Cache::remember('motifs', 60, function () {
            return \App\Models\Motif::where('is_visible', true)
                ->orderBy('name_fr')
                ->get();
        });
        return view('livewire.candidature-wire',compact('motifs'));
    }

    public function setDecision(){
        $validated = $this->validate([
            'decision'          => ['required',new Enum(CandidatureStatusEnum::class)],
            'motif'             => ['nullable','exists:motifs,id'],
            'description'       => ['nullable','max:255']
        ]);
        try{
            $this->candidature->update([
                ...$validated,
                'decision' => CandidatureStatusEnum::from($this->decision)->name
            ]);
            Flux::toast('Candidature updated successfully');
            // display success message
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
}
