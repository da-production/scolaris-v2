<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousSpecialite extends Model
{
    //
    protected $fillable = [
        'specialite_id',
        'code',
        'name_fr',
        'name_ar',
        'ponderation',
        'description',
        'is_active'
    ];
    protected $casts = [
        'specialite_id' => 'integer',
        'ponderation' => 'decimal:2',
    ];
    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }
    
}
