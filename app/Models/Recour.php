<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recour extends Model
{
    //

    protected $fillable = ['candidature_id','user_id','content','status'];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
