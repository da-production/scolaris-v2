<?php

namespace App;

enum ClassificationEnum: string
{
    //
    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';

    public function range(): array
    {
        return match ($this) {
            self::A => [16.00, 18.00],
            self::B => [14.00, 15.99],
            self::C => [12.00, 13.99],
            self::D => [10.00, 11.99],
            self::E => [0.00, 9.99],
        };
    }

    /**
     * Retourne la classification à partir d'une note.
     */
    public static function fromNote(float $note): self
    {
        foreach (self::cases() as $classification) {
            [$min, $max] = $classification->range();
            if ($note >= $min && $note <= $max) {
                return $classification;
            }
        }

        throw new \InvalidArgumentException("Note invalide : $note");
    }
}
