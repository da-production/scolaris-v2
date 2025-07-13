<?php

namespace App;

enum CandidatureStatusEnum:string
{
    //
    case EN_ATTENTE = 'EN_ATTENTE';
    case APPROUVE = 'APPROUVE';
    case REJETE = 'REJETE';
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
            self::EN_ATTENTE => 'candidature est en attente de traitement.',
            self::APPROUVE => 'candidature a été approuvée.',
            self::REJETE => 'candidature a été rejetée.',
            self::NON_CLASSE => 'candidature ne figure pas parmi les 100 premiers du classement.',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            self::APPROUVE => 'bg-green-100 text-green-800 border-green-200',
            self::REJETE => 'bg-red-100 text-red-800 border-red-200',
            self::NON_CLASSE => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public static function default(): self
    {
        return self::EN_ATTENTE;
    }
}
