<?php

namespace App\Livewire;

use App\Models\Candidature;
use App\Models\Document;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CandidatureWire extends Component
{
    public $candidature;
    public $decision;
    public $motif;

    #[Computed]
    public function profilePhotoUrl(): string | null
    {
        return imageToBase64($this->candidature->candidat->profile_picture);
    }
    public function mount(Candidature $candidature)
    {
        $this->candidature = $candidature->load('document','candidat', 'classification', 'specialite', 'filiere', 'specialite_concour','domain');
        $this->decision = strtolower($this->candidature->decision);
    }


    public function download(Document $document)
    {
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
}
