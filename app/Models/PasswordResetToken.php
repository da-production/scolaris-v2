<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    //
    protected $table = 'password_reset_tokens';
    public $incrementing = false; // Si la clé n’est pas auto-incrémentée
    protected $primaryKey = 'token'; // Clé primaire utilisée
    protected $keyType = 'string'; // Si le token est une chaîne
}
