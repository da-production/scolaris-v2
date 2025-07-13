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
        ->where('exercice',auth()->user()->exercice)
        ->with('candidat');
        if($this->bySpecialite) {
            $query->when($this->specialite_concour_id, function ($query) {
                $query->where('specialite_concour_id', $this->specialite_concour_id);
            });
            $candidatures = $query->limit(100)->get();
        }else{
            $candidatures = $query->paginate(15);
        }
        
        return view('livewire.candidatures-wire',compact('candidatures'));
    }
}
