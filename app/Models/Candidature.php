<?php

namespace App\Models;

use App\Casts\DecisionCast;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    //

    public function candidat(){
        return $this->belongsTo(Candidat::class);
    }

    protected $casts = [
        'decision' => DecisionCast::class,
    ];
}
