<?php

namespace App\Support;

class ExerciceFactory
{
    /**
     * Créer une instance d’Exercice avec cacheKey personnalisée
     */
    public static function make(string $cacheKey = 'exercices'): ExerciceManager
    {
        return new ExerciceManager($cacheKey);
    }
}
