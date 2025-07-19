<?php

namespace App\Actions;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class OTPAction{
    public static function send($payload){
        $url = route('otp')."?token=".$payload->token;
        Mail::to($payload->user?->email)->send(new OtpMail($payload->otp,$url));
    }
}