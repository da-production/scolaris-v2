<?php

namespace App\Listeners;

use App\Actions\OTPAction;
use App\Events\OtpEvent;
use App\Jobs\SendOtpEmail;

use Illuminate\Support\Facades\Log;

class OtpListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OtpEvent $event): void
    {
        // Run the job if enable else run as sync
        if(config('app.otp_cronjob')){
            SendOtpEmail::dispatch($event);
        }else{
            OTPAction::send($event);
        }
    }
}
