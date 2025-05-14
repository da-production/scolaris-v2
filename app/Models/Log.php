<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //

    protected $fillable = [
        'action',
        'user_id',
        'model_type',
        'payload',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPayloadAttribute($value)
    {
        return json_decode($value, true);
    }

}
