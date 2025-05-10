<?php

namespace App\Listeners;

use App\Events\OtpEvent;
use App\Mail\OtpMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

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
        //
        $url = route('otp')."?token=".$event->token;
        Mail::to($event->user?->email)->send(new OtpMail($event->otp,$url));
    }
}
