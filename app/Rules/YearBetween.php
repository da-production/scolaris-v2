<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YearBetween implements ValidationRule
{
    protected $startYear;
    protected $endYear;
    protected $customMessage;

    /**
     * Create a new rule instance.
     *
     * @param  int  $startYear
     * @param  int  $endYear
     * @param  string|null  $customMessage
     * @return void
     */
    public function __construct(int $startYear, int $endYear, $customMessage = null)
    {
        $this->startYear = $startYear;
        $this->endYear = $endYear;
        $this->customMessage = $customMessage;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If the value is not a valid number or it's not within the range, fail the validation
        if (!is_numeric($value) || $value < $this->startYear || $value > $this->endYear) {
            // Use the custom message if provided, otherwise use the default French message
            $message = $this->customMessage ?: "L'année doit être comprise entre {$this->startYear} et {$this->endYear}.";
            $fail($message);
        }
    }
}
