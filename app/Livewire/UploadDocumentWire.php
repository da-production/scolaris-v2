<?php

namespace App\Livewire;

use App\Models\Document;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDocumentWire extends Component
{
    use WithFileUploads;
    public $type;
    public $comments;

    // #[Validate('required|file|max:5120')] // max 5MB
    public $file;

    public function updatedFile()
    {
        $this->validate();
        dd("cc");
        return true;
    }
    public function save()
    {
        dd(auth()->guard('candidat')->user()->load('candidature'));

        $this->validate();

        $originalName = $this->file->getClientOriginalName();
        $extension = $this->file->getClientOriginalExtension();
        $size = $this->file->getSize();

        // Store file in private storage
        $path = $this->file->store('documents', 'private') . '/' . Date('Y');
        Document::create([
            'candidature_id' => auth()->guard('candidat')->user()->load('candidature')->candidature->id,
            'type' => "all",
            'file_path' => $path,
            'file_name' => $originalName,
            'file_extension' => $extension,
            'file_size' => $size,
            'comments' => $this->comments,
        ]);

        session()->flash('success', 'Document uploaded successfully!');
        $this->reset(['file', 'type', 'comments']);
    }
    public function render()
    {
        return view('livewire.upload-document-wire');
    }
}
