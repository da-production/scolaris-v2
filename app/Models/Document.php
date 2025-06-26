<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable = [
        'candidature_id',
        'type',
        'file_path',
        'file_name',
        'file_extension',
        'file_size',
        'comments',
    ];
}
