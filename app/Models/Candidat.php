<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidat extends Authenticatable
{
    //
    protected $fillable = [
        'numero_bac',
        'annee_bac',
        'nin',
        'nom',
        'prenom',
        'nom_ar',
        'prenom_ar',
        'situation_familiale',
        'situation_professionnelle',
        'genre',
        'mobile_1',
        'mobile_2',
        'fix',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'adresse_ar',
        'etablissement_diplome',
        'email',
        'password',
        'etat',
        'exercice',
        'lieu_naissance_id',
        'wilaya_residence_id',
        'wilaya_id',
        'profile_picture',
        'valide',
    ];

    public function candidature()
    {
        return $this->hasOne(Candidature::class);
    }

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }
    protected $casts = [
        'genre' => \App\Casts\GenderCast::class,
    ];
}
