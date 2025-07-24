<?php

namespace App\Support;

class OptionsFactory
{
    /**
     * Créer une instance d’Options avec cacheKey personnalisée
     */
    public static function make(string $cacheKey = 'app_options'): OptionsManager
    {
        return new OptionsManager($cacheKey);
    }
}
