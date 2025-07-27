<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Opcodes\LogViewer\Facades\LogViewer;

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
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->can('view log'), [
                    'view log',
                ]);
        });
        Blade::directive('isnull', function ($expression) {
            $parts = str_getcsv($expression); // Gère correctement les virgules dans les chaînes
            $var = $parts[0] ?? 'null';
            $default = $parts[1] ?? '""';

            return "<?php echo isset($var) && !is_null($var) ? $var : $default; ?>";
        });

        Blade::if('hasAnyOf', function ($roles = [], $permissions = []) {
            $user = Auth::user();

            if (!$user) return false;

            return $user->hasAnyRole($roles) || $user->hasAnyPermission($permissions);
        });

        
        try {
            DB::connection()->getPDO();
            
        } catch (\Exception $e) {
            Log::error('❌ Impossible de se connecter à la base de données : ' . $e->getMessage());
            abort(502, 'Database connection error: ' . $e->getMessage());
        }
    }
}
