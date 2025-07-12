<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motif extends Model
{
    //

    protected $fillable = [
        'name_fr', 'name_ar', 'is_visible','order'
    ];
}
