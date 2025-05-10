<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Blade::directive('isnull', function ($expression) {
            $parts = str_getcsv($expression); // Gère correctement les virgules dans les chaînes
            $var = $parts[0] ?? 'null';
            $default = $parts[1] ?? '""';

            return "<?php echo isset($var) && !is_null($var) ? $var : $default; ?>";
        });
    }
}
