<?php

namespace App\Livewire;

use App\CandidatureStatusEnum;
use App\Models\Candidature;
use App\Models\Domain;
use App\Models\Filiere;
use App\Models\Specialite;
use App\Models\SpecialiteConcour;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Rap2hpoutre\FastExcel\FastExcel;


class CandidaturesWire extends Component
{
    use \Livewire\WithPagination;
    public $specialite_concour_id;
    public $domain_id;
    public $specialite_id;
    public $filier_id;
    public $decision;
    public $nom;
    public $prenom;
    public $orderBy;
    public $orderDirection= 'DESC';

    public $specialite;
    public $bySpecialite = false;

    public $rejete;

    protected $queryString = [
        'specialite_concour_id',
        'domain_id',
        'specialite_id',
        'filier_id',
        'nom',
        'prenom',
        'orderBy' => [ 'as' => 'order_by', 'rules' => 'nullable|in:moyenne,created_at,decision'],
        'orderDirection' => ['as' => 'order_direction', 'default' => 'DESC', 'rules' => 'nullable|in:ASC,DESC'],
        'decision' => ['as' => 'decision'],
        'rejete'    => ['as'=>'status','rules'=>'nullable|boolean']
    ];

    public $domaines;
    public $filieres;
    public $specialites;
    public $specialiteConcours;

    public function mount($specialite_concour_id = null)
    {
        $this->specialite_concour_id = $specialite_concour_id;
        $this->specialite = $specialite_concour_id ? SpecialiteConcour::find($specialite_concour_id) : null;
        $this->bySpecialite = $specialite_concour_id ? true : false;

        $this->domainesLoad();
        $this->filiersLoad();
        $this->specialiteConcoursLoad();
        $this->specialitesLoad();
    }

    public function domainesLoad()
    {
        if(!$this->bySpecialite){
            $this->domaines = Domain::all();
        }
    }
    
    public function filiersLoad()
    {
        if(!$this->bySpecialite){
            $this->filieres = Filiere::where('domain_id', $this->domain_id)
                ->get();
        }
    }

    public function specialiteConcoursLoad(){
        if(!$this->bySpecialite){
            $this->specialiteConcours = SpecialiteConcour::all();
        }
    }


    public function specialitesLoad(){
        if(!$this->bySpecialite){
            $this->specialites = Specialite::where('filiere_id', $this->filier_id)
                ->get();
        }
    }


    public function render()
    {
        $query = Candidature::query();
        $query->orderBy("moyenne",'DESC')
        ->when($this->domain_id, function ($query) {
            $query->where('domain_id', $this->domain_id);
        })
        ->when($this->filier_id, function ($query) {
            $query->where('filiere_id', $this->filier_id);
        })
        ->when($this->specialite_id, function ($query) {
            $query->where('specialite_id', $this->specialite_id);
        })
        ->when($this->specialite_concour_id, function ($query) {
            $query->where('specialite_concour_id', $this->specialite_concour_id);
        })
        ->when($this->nom, function ($query) {
            $query->whereHas('candidat', function ($q) {
                $q->where('nom', 'like', '%' . $this->nom . '%')
                    ->orWhere('nom_ar', 'like', '%' . $this->nom . '%');
            });
        })
        ->when($this->prenom, function ($query) {
            $query->whereHas('candidat', function ($q) {
                $q->where('prenom', 'like', '%' . $this->prenom . '%')
                    ->orWhere('prenom_ar', 'like', '%' . $this->prenom . '%');
            });
        })
        ->when($this->orderBy, function ($query) {
            $query->orderBy($this->orderBy, $this->orderDirection);
        })
        ->when($this->decision && in_array($this->decision, array_column(CandidatureStatusEnum::cases(), 'value')), function ($query) {
            $query->where('decision', $this->decision);
        })
        ->when($this->rejete, function($query){
            return $query->where('decision','REJETE');
        })
        ->where('exercice',auth()->user()->exercice)
        ->with('candidat');
        if($this->bySpecialite && !$this->rejete) {
            $query->when($this->specialite_concour_id, function ($query) {
                $query->where('specialite_concour_id', $this->specialite_concour_id);
            });
            $candidatures = $query->whereIn('decision',['EN_ATTENTE','APPROUVE']);
            $candidatures = $query
            ->orderBy('classification_concour','ASC')
            ->orderBy('moyenne','DESC')
            ->limit(100)->get();
        }else{
            $candidatures = $query->paginate(15);
        }
        return view('livewire.candidatures-wire', compact('candidatures'));
    }

    private function candidaturesGenerator() {
        foreach (Candidature::cursor() as $candidature) {
            yield $candidature->load('candidat');
        }
    }

    private function processCandidatures() {
    return Candidature::with('candidat')
            ->orderBy('moyenne', 'DESC')
            ->chunk(100, function ($candidatures) {
                foreach ($candidatures as $candidature) {
                    // $candidature->candidat déjà chargé
                }
            });
    }

    public function exportExcelFile(){
        if($this->bySpecialite){
            $candidatures = Candidature::where([
                ['exercice', auth()->user()->exercice],
                ['decision', 'ACCEPTE']
            ])
            ->with('candidat')
            ->orderBy('moyenne', 'DESC')
            ->get();
            $today = str($candidatures[0]->specialite_concour->name_fr)->slug() . "-" . now()->format('Y-m-d_H:i:s');
            return (new FastExcel($candidatures))->download("candidatures-{$today}.xlsx", function ($candidature) {
                return [
                    'exercice' => $candidature->exercice,
                    'Candidat ID' => $candidature->candidat_id,
                    'Candidature ID' => $candidature->id,
                    'NIN' => optional($candidature->candidat)->nin,
                    'Nom complet' => optional($candidature->candidat)->nom . ' ' . optional($candidature->candidat)->prenom,
                    'Nom complet' => optional($candidature->candidat)->nom . ' ' . optional($candidature->candidat)->prenom,
                    'Adresse email' => optional($candidature->candidat)->email,
                    'Date de Naissance' => optional($candidature->candidat)->date_naissance,
                    'Lieu de Naissance' => optional($candidature->candidat)->lieu_naissance,
                    'adresse' => optional($candidature->candidat)->adresse,
                    'wilaya' => optional($candidature->wilaya)->name_fr,
                    'Telephone' => optional($candidature->candidat)->mobile_1 . " / " . optional($candidature->candidat)->mobile_2,
                    'domain' => optional($candidature->domain)->name_fr,
                    'filiere' => optional($candidature->filiere)->name_fr,
                    'specialite apparentée' => optional($candidature->specialite)->name_fr,
                    'specialite choisis' => optional($candidature->specialite_concour)->name_fr,
                    'moyenne' => $candidature->moyenne,
                    'moyenne semestres' => $candidature->moyenne_semestres,
                    'numero_bac' => $candidature->numero_bac,
                    'annee_bac' => $candidature->annnee_bac,
                    'moyenne_bac' => $candidature->moyenne_bac,
                    'type_diplome' => $candidature->type_diplome,
                    'annee_diplome' => $candidature->annee_diplome,
                    'etablissement_diplome' => $candidature->etablissement_diplome,
                    'classification du concour' => $candidature->classification_concour,
                    'classification du l\'universite' => $candidature->classification->code ?? 'N/A',
                    'decision' => $candidature->decision,
                    'motif de reje' => optional($candidature->motif)->name,
                    'commentaire' => $candidature->commentaire,
                    
                ];
            });
        }else{
            return (new FastExcel($this->candidaturesGenerator()))->download('candidatures.xlsx', function ($candidature) {
                return [
                    'Nom complet' => optional($candidature->candidat)->nom . ' ' . optional($candidature->candidat)->prenom,
                    'Adresse email' => optional($candidature->candidat)->email,
                ];
            });
        }
        
        
    }
}
