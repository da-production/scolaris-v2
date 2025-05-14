<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    //
    protected $fillable = [
        'annee',
        'closed_at',
        'opened_at',
        'closed_trait',
        'displayed_at',
        'conditions',
        'note',
        'is_closed'
    ];

    protected $casts = [
        'annee' => 'integer',
    ];
}
