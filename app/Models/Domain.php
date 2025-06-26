<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    //

    protected $fillable = [
        'name_fr',
        'name_ar',
        'description',
        'is_active',
    ];
}
