<?php

namespace App\Jobs;

use App\Actions\ResetPasswordAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ResetPasswordJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $email, public $token)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        ResetPasswordAction::send($this->email,$this->token);
    }
}
