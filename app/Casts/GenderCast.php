<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class GenderCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return match ($value) {
            'H' => 'Homme',
            'F' => 'Femme',
            default => 'Unknown',
        };
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return match (strtolower($value)) {
            'male' => 'H',
            'female' => 'F',
            default => null,
        };
    }
}
