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

    public static function default(): self
    {
        return self::EN_ATTENTE;
    }
}
