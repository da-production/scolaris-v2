<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'name_fr', 'name_ar', 'is_active', 'domain_id',
        'order',
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
    
}
