<?php

namespace App\Rules;

use App\Models\Option;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Cache;

class EmailDomain implements ValidationRule
{
     protected array $allowedDomains;

    public function __construct(array $allowedDomains = [])
    {
        
        $options = Cache::rememberForever('options', function(){
            return Option::all();
        });
        $this->allowedDomains = [...$allowedDomains,...explode(',',$options->where('name','autorized_emails')->first()->value)];
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->allowedDomains)) {
            return;
        }
        $domain = substr(strrchr($value, "@"), 1);

        if (!in_array(strtolower($domain), $this->allowedDomains)) {
            $fail("Le champ :attribute doit appartenir à un domaine autorisé: ...@"  . implode(', ...@', $this->allowedDomains) );
        }
    }
}
