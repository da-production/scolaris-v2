<?php

namespace App\Livewire\Candidat;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

class UploadProfilePictureWire extends Component
{

    public $file;

    use WithFileUploads;

    #[Computed]
    public function profilePhotoUrl(): string | null
    {
        $path = auth()->guard('candidat')->user()->profile_picture;

        return imageToBase64($path);
    }

    public function save()
    {
        $extension = $this->file->getClientOriginalExtension(); // Exemple: "pdf"

        $user = auth()->guard('candidat')->user();
        // Option 1 : Utiliser le nom d'origine
        $customFileName = Str::slug("{$user->nom}-{$user->prenom}___{$user->id}") . "." . $extension;

        
        $path = $this->file->storeAs('profile-pictures/' . date('Y'), $customFileName, 'private');
        $user->update([
            'profile_picture' => $path,
        ]);
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|image|max:2048', // max 2MB
        ]);
        $this->save();
        session()->flash('success', 'Photo de profil mise à jour avec succès !');
    }
    public function render()
    {
        return view('livewire.candidat.upload-profile-picture-wire');
    }
}
