<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialiteConcour extends Model
{
    //
    
    protected $fillable = [
        'code', 'name_fr', 'name_ar', 'description','is_active', 
    ];
}
