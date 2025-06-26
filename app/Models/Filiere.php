<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    //
    protected $fillable = [
        'name_fr', 'name_ar', 'is_active', 'domain_id'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
    
}
