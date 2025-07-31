<?php

namespace App\Livewire;

use App\CandidatureStatusEnum;
use App\Models\Candidature;
use App\Models\Document;
use App\Models\Motif;
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
    public $commentaire;

    #[Computed]
    public function profilePhotoUrl(): string | null
    {
        return imageToBase64($this->candidature->candidat->profile_picture);
    }
    public function mount(Candidature $candidature)
    {
        $this->candidature = $candidature->load('document','candidat', 'classification', 'specialite', 'filiere', 'specialite_concour','domain');
        $this->decision = $this->candidature->decision;
        $this->motif = !is_null($this->candidature->commentaire) ?? 'autre';
        $this->commentaire = $this->candidature->commentaire;
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
        $motifs = \App\Models\Motif::where('is_visible', true)
                ->orderBy('order','ASC')
                ->get();;

        return view('livewire.candidature-wire',compact('motifs'));
    }

    public function setDecision(){
        $this->validate([
            'decision'          => ['required',new Enum(CandidatureStatusEnum::class)],
            'motif'             => ['nullable',function ($attribute, $value, $fail) {
                                    // Si la valeur est "autre", on l'accepte
                                    if ($value === 'autre') {
                                        return;
                                    }

                                    // Si la valeur n'est pas "autre", on vérifie l'existence dans la table motifs
                                    $exists = Motif::where('id', $value)->exists();

                                    if (! $exists) {
                                        $fail("Le champ $attribute doit être un ID valide ou 'autre'.");
                                    }
                                }],
            'commentaire'       => ['nullable','max:255']
        ]);
        try{
            $this->candidature->update([
                'motif_id' => $this->motif == 'autre' ? null : $this->motif,
                'commentaire'=> $this->motif == 'autre' ? $this->commentaire : null,
                'decision' => CandidatureStatusEnum::from($this->decision)->name
            ]);
            Flux::toast('Candidature updated successfully');
            // display success message
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

   
}
