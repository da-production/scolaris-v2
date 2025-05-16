<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    //
    protected $fillable = [
        'code',
        'name_fr',
        'name_ar',
        'coefficient',
        'description',
        'is_active'
    ];

    public function sousSpecialites()
    {
        return $this->hasMany(SousSpecialite::class);
    }
}
