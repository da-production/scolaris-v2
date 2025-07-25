<?php

namespace App\Livewire\Candidat;

use App\ClassificationEnum;
use App\Models\Candidature;
use App\Models\Classification;
use App\Models\Document;
use App\Models\Domain;
use App\Models\Filiere;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use App\Support\OptionsFactory;
use App\TypeDiplomEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\LivewireFilepond\WithFilePond;


#[Layout('components.layouts.guest')]
class CandidatureWire extends Component
{
    use WithFilePond;

    
    #[Validate('required|file|max:5120')] 
    public $file;

    public $files = [];
    public ?int $id = null;
    public int $candidat_id;
    public ?int $domain_id = null;
    public ?int $filiere_id = null;
    public ?int $specialite_id = null;
    public ?int $specialite_concour_id = null;
    public ?int $classification_id = null;
    public ?float $moyenne_semestres = null;
    public ?string $decision = null;
    public ?string $commentaire = null;
    public ?string $exercice = null;
    public ?string $numero_bac = null;
    public ?string $annnee_bac = null;
    public ?float $moyenne_bac = null;
    public ?string $type_diplome = null;
    public ?string $annee_diplome = null;
    public ?string $etablissement_diplome = null; 

    public $filieres = [];
    public $specialites = [];
    

    public function mount(){
        /**
         * Check if exercice is expired or not
         */
        $this->loadInformation();
        $this->loadFiles();
    }

    #[On('loadInformation')]
    public function loadInformation(){
        $candidature = Candidature::where('candidat_id',auth()->guard('candidat')->user()->id)->latest()->first();
        if($candidature){
            $this->id = $candidature->id;
            $this->candidat_id = $candidature->candidat_id;
            $this->domain_id = $candidature->domain_id;
            $this->filiere_id = $candidature->filiere_id;
            $this->specialite_id = $candidature->specialite_id;
            $this->specialite_concour_id = $candidature->specialite_concour_id;
            $this->classification_id = $candidature->classification_id;
            $this->moyenne_semestres = $candidature->moyenne_semestres;
            $this->decision = $candidature->decision;
            $this->commentaire = $candidature->commentaire;
            $this->exercice = $candidature->exercice;
            $this->numero_bac = $candidature->numero_bac;
            $this->annnee_bac = $candidature->annnee_bac;
            $this->moyenne_bac = $candidature->moyenne_bac;
            $this->type_diplome = $candidature->type_diplome;
            $this->annee_diplome = $candidature->annee_diplome;
            $this->etablissement_diplome = $candidature->etablissement_diplome; 

            $this->filieres = Filiere::where('domain_id',$candidature->domain_id)->get();
            $this->specialites = Specialite::where('filiere_id',$candidature->filiere_id)
                ->where('specialite_concour_id',$candidature->specialite_concour_id)
                ->get();
        }
    }

    #[On('loadFiles')]
    public function loadFiles(){
        $this->files = Document::where('candidature_id',$this->id)
                ->where('type','all')
                ->get();
    }

    public function updated($field,$value){
        if($field == 'domain_id'){
            $this->validate([
                'domain_id' => ['exists:domains,id']
            ]);
            $this->reset('filieres','specialites');
            $this->filieres = Cache::tags('domain')
                ->rememberForever('filieres_by_domain_'.$value, function () use ($value) {
                    return Filiere::where('domain_id',$value)->orderBy('order')->get();
                });
        }
        if($field == 'specialite_concour_id'){
            $this->validate([
                'specialite_concour_id' => ['exists:specialite_concours,id']
            ]);
            $this->reset('specialites');
            $this->specialites = Cache::tags('specialite_concours_filiers')
                ->rememberForever("specialites_by_specialite_concour_{$value}_{$this->filiere_id}", function () use ($value) {
                    return Specialite::where('filiere_id',$this->filiere_id)->where('specialite_concour_id',$value)->get();
                });
        }
        $this->saveFile();
    }
    public function render()
    {
        $domains = Cache::rememberForever('domains', function () {
            return Domain::where('is_active',true)->orderBy('order')->get();
        });
        $specialiteConcours = Cache::rememberForever('specialite_concours', function () {
            return SpecialiteConcour::where('is_active',true)->orderBy('order')->get();
        });
        $classifications = Cache::rememberForever('classifications', function () {
            return Classification::all();
        });

        $options = OptionsFactory::make('options_inscription');

        $documents = [];
        if($options->get('upload_multiple_files')){
            $documents = Document::where('candidature_id',$this->id)->get();
        }
        return view('livewire.candidat.candidature-wire', compact('domains','specialiteConcours','classifications','options','documents'));
    }

    public function save(){
        $this->candidatureStatus();
        abort_if(!canCandidatUpdate(),403,
            'le délai de mise à jour des informations est dépassé. Vous ne pouvez plus mettre à jour vos informations pour l\'exercice en cours.'
        );
        if(is_null($this->id)){
            $this->store();
        }else{
            $this->update();
        }
    }

    private function validateData(){
        return $this->validate([   
            'domain_id' => ['required', 'exists:domains,id'],
            'filiere_id' => ['required', 'exists:filieres,id'],
            'specialite_id' => ['required', 'exists:specialites,id'],
            'specialite_concour_id' => ['required', 'exists:specialite_concours,id'],
            'classification_id' => ['required', 'exists:classifications,id'],
            'moyenne_semestres' => ['required', 'numeric', 'min:0', 'max:20'],
            'moyenne_bac' => ['nullable', 'numeric', 'min:0', 'max:20'],
            'type_diplome' => ['nullable', 'string',Rule::in(array_column(TypeDiplomEnum::cases(), 'value')),],
            'annee_diplome' => ['nullable', 'integer', 'max:' . date('Y')],
            'etablissement_diplome' => ['nullable', 'string']
        ]);
    }
    public function store(){
        $validate = $this->validateData();
        try{
            $candidature = Candidature::create([
                ...$validate,
                'exercice' => now()->year,
                'candidat_id' => auth()->guard('candidat')->user()->id,
                'numero_bac' => $this->numero_bac,
                'annnee_bac' => $this->annnee_bac,
                'decision' => 'EN_ATTENTE',
            ]);
            $this->id = $candidature->id;
            $this->dispatch('$refresh');
            session()->flash('success', 'Candidature enregistrée avec succès.');
        }catch(\Exception $e){
            Log::error('Error while saving candidature: '.$e->getMessage());
            return;
        }
    }

    public function update(){
        $validate = $this->validateData();
        try{

            $classification = Classification::where("id",$this->classification_id)->pluck('moyen')->first();
            $coefficient_spec = Specialite::where("id",$this->specialite_id)->pluck('coefficient')->first();

            $moyenne = calculateAverage($classification, $coefficient_spec, $this->moyenne_semestres);
            Candidature::find($this->id)->update([
                ...$validate,
                'exercice'      => now()->year,
                'numero_bac'    => $this->numero_bac,
                'annnee_bac'    => $this->annnee_bac,
                'decision'      => 'EN_ATTENTE',
                'moyenne'       => $moyenne,
            ]);
        }catch(\Exception $e){
            Log::error('Error while saving candidature: '.$e->getMessage());
            return;
        }
    }

    public function saveFile()
    {
        abort_if(!canCandidatUpdate(),403,
            'le délai de mise à jour des informations est dépassé. Vous ne pouvez plus mettre à jour vos informations pour l\'exercice en cours.'
        );
        $this->validate();

        $originalName = $this->file->getClientOriginalName(); // Exemple: "cv.pdf"
        $extension = $this->file->getClientOriginalExtension(); // Exemple: "pdf"
        $size = $this->file->getSize();

        $user = auth()->guard('candidat')->user();
        // Option 1 : Utiliser le nom d'origine
        $customFileName = "{$user->numero_bac}-{$user->annee_bac}___{$user->id}-{$this->id}___" .time() . '.' . $extension;

        // Option 2 : Générer un nom personnalisé
        // $customFileName = 'candidature_' . $this->id . '.' . $extension;

        // Stocker le fichier avec le nom personnalisé
        $path = $this->file->storeAs('documents/' . date('Y'), $customFileName, 'private');

        // Enregistrer dans la base de données
        Document::create([
            'candidature_id'    => $this->id,
            'type'              => "all",
            'file_path'         => $path,
            'file_name'         => $originalName,
            'file_extension'    => $extension,
            'file_size'         => $size,
            // 'comments' => $this->comments,
        ]);
        $this->dispatch('loadFiles'); // Rafraîchir le composant pour mettre à jour la liste des fichiers
        session()->flash('success', 'Document uploaded successfully!');
        $this->reset(['file']);
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

    public function deleteFile(Document $document)
    {
        abort_if(!canCandidatUpdate(),403,
            'le délai de mise à jour des informations est dépassé. Vous ne pouvez plus mettre à jour vos informations pour l\'exercice en cours.'
        );
        try {
            // Démarrer la transaction
            DB::beginTransaction();

            // Supprimer le fichier du disque
            if (Storage::disk('private')->exists($document->file_path)) {
                $deleted = Storage::disk('private')->delete($document->file_path);
                if (! $deleted) {
                    // Échec suppression fichier => rollback + exception
                    throw new \Exception("Le fichier n'a pas pu être supprimé du disque.");
                }
            }
            
            // Supprimer l'enregistrement en base de données
            $document->delete();
            // Commit si tout est OK
            DB::commit();
            

            // Message de confirmation (optionnel)
            session()->flash('success', 'Fichier supprimé avec succès.');
            $this->dispatch('loadFiles'); // pour notification front
        } catch (\Exception $e) {
            // Annuler la transaction
            DB::rollBack();

            $this->dispatch('file-deletion-failed', message: $e->getMessage());
        }
        
    }

    private function candidatureStatus()
    {
        if(is_null($this->decision)){
            return true;
        }

        if($this->decision != 'EN_ATTENTE'){
            abort(403, 'Vous ne pouvez pas soumettre une candidature avec une décision deja prise.');
        }

        return true;
    }

}
