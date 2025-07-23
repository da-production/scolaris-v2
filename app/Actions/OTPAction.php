<?php

namespace App\Actions;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OTPAction{
    
    public static function send($payload){
        
        try{

            setSmtpOption();
            $url = route('otp')."?token=".$payload->token;
            Mail::to($payload->user?->email)->send(new OtpMail($payload->otp,$url));

        }catch(\Exception $e){
            Log::error('OTP Send Error::'.$e->getMessage());
        }
    }

}