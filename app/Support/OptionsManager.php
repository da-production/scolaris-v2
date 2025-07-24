<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use App\Models\Option;

class OptionsManager
{
    protected array $options;
    protected string $cacheKey;

    public function __construct(string $cacheKey = 'app_options')
    {
        $this->cacheKey = $cacheKey;

        $this->options = Cache::remember($this->cacheKey, now()->addHours(24), function () {
            return Option::all()->pluck('value','name')->toArray();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->options;
    }

    public function refresh(): void
    {
        Cache::forget($this->cacheKey);
        $this->options = Cache::remember($this->cacheKey, now()->addHours(24), function () {
            return Option::all()->pluck('value', 'key')->toArray();
        });
    }
}
