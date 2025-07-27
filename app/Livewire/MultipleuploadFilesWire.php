<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\Option;
use App\Support\OptionsFactory;
use Livewire\Component;
use Livewire\WithFileUploads;

class MultipleuploadFilesWire extends Component
{
    use WithFileUploads;
    public $files = [];
    public $file = [];

    public function mount(){
        $options = OptionsFactory::make('options_inscription');
        $files = Option::parseRawStringWithSlugs($options->get('files_liste_to_upload'));
        $this->files = $files[strtolower(auth()->guard('candidat')->user()->candidature?->type_diplome)] ?? [];

    }

    public function render()
    {
        return view('livewire.multipleupload-files-wire');
    }

    public function updated(){
        $this->upload();
    }

    protected function rules()
    {
        return [
            'file.*' => "file|max:".(1024 * 5), // 5MB max
        ];
    }

    public function upload()
    {
        /**
         * TODO: delete file if exist
         * check if file exist don't add to database
         */
        abort_if(!canCandidatUpdate(),403,
            'le délai de mise à jour des informations est dépassé. Vous ne pouvez plus mettre à jour vos informations pour l\'exercice en cours.'
        );
        $this->validate();
        $file = $this->file[array_key_first($this->file)];
        $id = auth()->guard('candidat')->user()->id;
        $originalName = $file->getClientOriginalName(); // Exemple: "cv.pdf"
        $extension = $file->getClientOriginalExtension(); // Exemple: "pdf"
        $size = $file->getSize();

        $user = auth()->guard('candidat')->user();
        // Option 1 : Utiliser le nom d'origine
        $customFileName = "{$user->numero_bac}-{$user->annee_bac}___{$user->id}-{$id}___single__" . array_key_first($this->file) . '.' . $extension;

        // Option 2 : Générer un nom personnalisé
        // $customFileName = 'candidature_' . $id . '.' . $extension;

        // Stocker le fichier avec le nom personnalisé
        $path = $file->storeAs('documents/' . date('Y'), $customFileName, 'private');

        $uiqueType = strtolower(auth()->guard('candidat')->user()->candidature?->type_diplome) . "__single__" . array_key_first($this->file);

        $doc = Document::where('type',$uiqueType)->first();
        if(is_null($doc)){
        // Enregistrer dans la base de données
            Document::create([
                'candidature_id'    => $id,
                'type'              => $uiqueType,
                'file_path'         => $path,
                'file_name'         => strtolower(auth()->guard('candidat')->user()->candidature?->type_diplome) . " - " . array_key_first($this->file),
                'file_extension'    => $extension,
                'file_size'         => $size,
                // 'comments' => $this->comments,
            ]);
        }else{
            $doc->file_path = $path;
            $doc->file_name = strtolower(auth()->guard('candidat')->user()->candidature?->type_diplome) . " - " . array_key_first($this->file);
            $doc->file_extension = $extension;
            $doc->file_size = $size;
            $doc->save();
        }
        
        $this->dispatch('loadFiles'); // Rafraîchir le composant pour mettre à jour la liste des fichiers
        session()->flash('success', 'Document uploaded successfully!');
        $this->reset(['file']);
    }
}
