<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsYear implements ValidationRule
{
    public function __construct(protected int $year)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $date = Carbon::parse($value);
            if ($date->year !== $this->year) {
                $fail("Le champ :attribute doit contenir une date de l’année {$this->year}.");
            }
        } catch (\Exception $e) {
            $fail("Le champ :attribute doit être une date valide.");
        }
    }
}
