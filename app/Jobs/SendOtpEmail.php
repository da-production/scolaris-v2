<?php

namespace App\Jobs;

use App\Actions\OTPAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendOtpEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $event)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        OTPAction::send($this->event);
    }
}
