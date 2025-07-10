<?php

namespace App;

enum CandidatureStatusEnum:string
{
    //
    case EN_ATTENTE = 'en_attente';
    case APPROUVE = 'approuve';
    case REJETE = 'rejete';
    case NON_CLASSE = 'NON_CLASSE'; // Ne figure pas dans les 100

    public function label(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'En attente',
            self::APPROUVE => 'Approuvé',
            self::REJETE => 'Rejeté',
            self::NON_CLASSE => 'Ne figure pas dans les 100',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'Votre candidature est en attente de traitement.',
            self::APPROUVE => 'Votre candidature a été approuvée.',
            self::REJETE => 'Votre candidature a été rejetée.',
            self::NON_CLASSE => 'Votre candidature ne figure pas parmi les 100 premiers du classement.',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'bg-yellow-100 text-yellow-800',
            self::APPROUVE => 'bg-green-100 text-green-800',
            self::REJETE => 'bg-red-100 text-red-800',
            self::NON_CLASSE => 'bg-gray-100 text-gray-800',
        };
    }

    public static function default(): self
    {
        return self::EN_ATTENTE;
    }
}
