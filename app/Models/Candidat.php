<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    //
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
    protected $casts = [
        'genre' => \App\Casts\GenderCast::class,
    ];
}
