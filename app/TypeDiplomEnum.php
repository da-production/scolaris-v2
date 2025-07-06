<?php

namespace App;

enum TypeDiplomEnum : string
{
    //
    case LICENCE = 'Licence';
    case MASTER = 'Master';
    case DOCTORAT = 'Doctorat';
    case INGENIEUR = 'Ingénieur';
    /**
     * Get the label for the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::LICENCE => 'Licence',
            self::MASTER => 'Master',
            self::DOCTORAT => 'Doctorat',
            self::INGENIEUR => 'Ingénieur',
            default => 'la moyenne des deux dernières semestres',
        };
    }
    public static  function labelFromValue($value): string
    {
        return match ($value) {
            self::LICENCE->value => 'la moyenne des deux dernières semestres (S5 et S6)',
            self::MASTER->value => 'la moyenne des deux dernières semestres (S3 et S4)',
            self::INGENIEUR->value => 'la moyenne des deux dernières semestres (S9 et S10)',
            default => 'la moyenne des deux dernières semestres',

        };
    }
}
