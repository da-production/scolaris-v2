<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CheckSessionSize extends Command
{
    protected $signature = 'session:check-size';
    protected $description = 'Affiche la taille des sessions stockées dans Redis';

    public function handle(): void
    {
        $prefix = config('session.prefix', 'esss');
        $keys = Redis::keys("{$prefix}*");

        if (empty($keys)) {
            $this->info("Aucune session trouvée avec le préfixe [$prefix]");
            return;
        }

        foreach ($keys as $key) {
            $size = Redis::connection()->command('STRLEN', [$key]);
            $this->line("🔑 $key → Taille : {$size} octets (" . round($size / 1024, 2) . " Ko)");
        }
    }
}
