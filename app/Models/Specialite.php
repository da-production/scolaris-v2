<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    //
    protected $fillable = [
        'code',
        'specialite_concour_id',
        'filiere_id',
        'name_fr',
        'name_ar',
        'coefficient',
        'description',
        'is_active'
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function sousSpecialites()
    {
        return $this->hasMany(SousSpecialite::class);
    }

    public function specialiteConcour()
    {
        return $this->belongsTo(SpecialiteConcour::class);
    }
}
