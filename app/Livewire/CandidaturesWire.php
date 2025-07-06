<?php

namespace App\Livewire;

use App\Models\Candidature;
use App\Models\SpecialiteConcour;
use Livewire\Component;

class CandidaturesWire extends Component
{
    use \Livewire\WithPagination;
    public $specialite_concour_id;
    public $specialite;
    public $bySpecialite = false;

    public function mount($specialite_concour_id = null)
    {
        $this->specialite_concour_id = $specialite_concour_id;
        $this->specialite = $specialite_concour_id ? SpecialiteConcour::find($specialite_concour_id) : null;
        $this->bySpecialite = $specialite_concour_id ? true : false;
    }
    public function render()
    {
        $query = Candidature::query();
        $query->orderBy("moyenne",'DESC')
        ->with('candidat');
        if($this->bySpecialite) {
            $query->when($this->specialite_concour_id, function ($query) {
                $query->where('specialite_concour_id', $this->specialite_concour_id);
            });
            $candidatures = $query->limit(100)->get();
        }else{
            $candidatures = $query->paginate(1);
        }
        
        return view('livewire.candidatures-wire',compact('candidatures'));
    }
}
