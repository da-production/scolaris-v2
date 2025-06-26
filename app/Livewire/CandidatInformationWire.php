<?php

namespace App\Livewire;

use App\Models\Option;
use App\Services\MiclatApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CandidatInformationWire extends Component
{
    
    public $nin;
    public $nom;
    public $prenom;
    public $nom_ar;
    public $prenom_ar;
    public $situation_familiale;
    public $situation_professionnelle;
    public $genre;
    public $mobile_1;
    public $mobile_2;
    public $fix;
    public $date_naissance;
    public $lieu_naissance;
    public $adresse;
    public $adresse_ar;
    public $etat;
    public $lieu_naissance_id;
    public $wilaya_residence_id;

    public function mount()
    {
        $this->loadCandidatInformation();
    }
    public function render()
    {
        return view('livewire.candidat-information-wire');
    }

    public function loadCandidatInformation()
    {
        $candidat = auth()->guard('candidat')->user();
        if($candidat){
            $this->nin = $candidat->nin;
            $this->nom = $candidat->nom;
            $this->prenom = $candidat->prenom;
            $this->nom_ar = $candidat->nom_ar;
            $this->prenom_ar = $candidat->prenom_ar;
            $this->situation_familiale = $candidat->situation_familiale;
            $this->situation_professionnelle = $candidat->situation_professionnelle;
            $this->genre = $candidat->genre;
            $this->mobile_1 = $candidat->mobile_1;
            $this->mobile_2 = $candidat->mobile_2;
            $this->fix = $candidat->fix;
            $this->date_naissance = isset($candidat->date_naissance) ? date('Y-m-d', strtotime($candidat->date_naissance)) : null;
            $this->lieu_naissance = $candidat->lieu_naissance;
            $this->adresse = $candidat->adresse;
            $this->adresse_ar = $candidat->adresse_ar;
            // Load other fields as necessary
        }
    }

    public function updated($field, $value){
        if($field == 'nin' && strlen($value) == 18){

            $response = MiclatApi::GetInformations($value);
            if(is_null($response)){
                return;
            }
            if($response->status() == 200){
                $data = $response->json();
                if(isset($data['identite']) && !is_null($data['identite'])){
                    $this->nom = $data['identite']['nom_f'] ?? '';
                    $this->prenom = $data['identite']['pren_f'] ?? '';
                    $this->nom_ar = $data['identite']['nom_a'] ?? '';
                    $this->prenom_ar = $data['identite']['pren_a'] ?? '';
                    $this->genre = $data['identite']['sexe'] ?? '';
                    $this->date_naissance = isset($data['identite']['d_nais']) ? date('Y-m-d', strtotime($data['identite']['d_nais'])) : null;
                }
            }
        }
    }

    public function updateProfile(){
        $validate = $this->validate([
            'nin' => 'nullable|string|min:18|max:18',
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'nom_ar' => 'nullable|string|max:255',
            'prenom_ar' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:10',
            'mobile_1' => 'nullable|string|max:20',
            'mobile_2' => 'nullable|string|max:20',
            'fix' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            // Add validation for other fields as necessary
        ]);

        auth()->guard('candidat')->user()->update($validate);

        session()->flash('success', __('Profile updated successfully.'));
    }
}
