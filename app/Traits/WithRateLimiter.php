<?php

namespace App\Traits;

use Illuminate\Support\Facades\RateLimiter;

trait WithRateLimiter
{
    //
    public string $rateErrorMessage = '';
    public int $rateTentatives = 0;
    public int $rateDuration = 0;

    public function rateLimiter()
    {
        $cle = 'envoyer-message:' . request()->ip();
        // Stocke les infos
        $this->rateTentatives = RateLimiter::attempts($cle);
        $this->rateDuration = RateLimiter::availableIn($cle);

        if (RateLimiter::tooManyAttempts($cle, 10)) {
            $this->addError('rateErrorMessage', "Trop de tentatives ({$this->rateTentatives}). ");
            return;
        }
        RateLimiter::hit($cle, 60 * 5); // Reset dans 60 secondes
    }

    public function resetRateLimiter()
    {
        $this->reset('rateErrorMessage','rateTentatives','rateDuration');
        $this->resetErrorBag('rateErrorMessage');
    }
}
