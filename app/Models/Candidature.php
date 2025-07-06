<?php

namespace App\Models;

use App\Casts\DecisionCast;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    //

    protected $fillable = [
        'candidat_id',
        'domain_id',
        'filiere_id',
        'specialite_id',
        'specialite_concour_id',
        'classification_id',
        'motif_id',
        'moyenne_semestres',
        'moyenne',
        'decision',
        'commentaire',
        'exercice',
        'numero_bac',
        'annnee_bac',
        'moyenne_bac',
        'type_diplome',
        'annee_diplome',
        'etablissement_diplome',
    ];

    public function candidat(){
        return $this->belongsTo(Candidat::class);
    }

    public function classification(){
        return $this->belongsTo(Classification::class);
    }

    public function specialite(){
        return $this->belongsTo(Specialite::class);
    }

    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

    public function specialite_concour()
    {
        return $this->belongsTo(SpecialiteConcour::class);
    }

    protected $casts = [
        // 'decision' => DecisionCast::class,
    ];
}
