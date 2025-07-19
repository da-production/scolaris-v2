<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    //

    protected $fillable = [
        'user_id','candidat_id', 'code', 'token'
    ];
}
