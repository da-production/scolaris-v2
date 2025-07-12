<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name_fr',
        'name_ar',
        'description',
        'is_active',
        'order',
    ];
}
