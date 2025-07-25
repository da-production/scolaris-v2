<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Option extends Model
{
    //
    protected $fillable = [
        'name',
        'value',
        'model_type',
    ];


    /**
     * @how_to_use: 
     * @ $raw = "key1:fiche d'entre|carte identite|autre__key2:fichier 4|fichier 5";
     * @ $parsed = parseRawStringWithSlugs($raw);
     */
    static function parseRawStringWithSlugs(?string $raw = ""): array
    {
        if(is_null($raw)) return [];
        $result = [];

        // Étape 1 : Diviser la chaîne par "__"
        $pairs = explode('__', $raw);

        foreach ($pairs as $pair) {
            // Étape 2 : Diviser par ":" pour obtenir la clé et les valeurs
            [$key, $values] = explode(':', $pair, 2);

            // Étape 3 : Diviser les valeurs par "|"
            $items = explode('|', $values);

            // Étape 4 : Générer tableau associatif avec slugs comme clés
            $assoc = [];
            foreach ($items as $item) {
                $slug = Str::slug($item);
                $assoc[$slug] = $item;
            }

            $result[$key] = $assoc;
        }

        return $result;
    }

}
