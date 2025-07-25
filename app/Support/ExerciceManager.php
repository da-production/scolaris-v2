<?php

namespace App\Support;

use App\Models\Exercice;
use Illuminate\Support\Facades\Cache;

class ExerciceManager
{
    protected array $exercices;
    protected string $cacheKey;

    public function __construct(string $cacheKey = 'exercices')
    {
        $this->cacheKey = $cacheKey;
        
        $this->exercices = Cache::remember($this->cacheKey, now()->addHours(24), function () {
            $exercices = Exercice::all();
            $exs = [];
            foreach($exercices as $exercice){
                $exs[$exercice->annee] = $exercice->toArray();
            }
            return $exs;
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->exercices[$key] ?? $default;
    }

   

    public function all(): array
    {
        return $this->exercices;
    }

    public function refresh(): void
    {
        Cache::forget($this->cacheKey);
        $this->exercices = Cache::remember($this->cacheKey, now()->addHours(24), function () {
            return Exercice::all()->pluck('value', 'key')->toArray();
        });
    }
}