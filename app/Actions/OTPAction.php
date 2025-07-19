<?php

namespace App\Actions;

use App\Mail\OtpMail;
use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class OTPAction{
    public static function send($payload){
        
        try{
            $options = [];
            $getOptionsFromCache = Cache::rememberForever('options', function(){
                return Option::all();
            });

            foreach ($getOptionsFromCache as $option) {
                $options[$option->name] = $option->value;
            }

            $options = collect($options);

            if(!is_null($options->get('smtp_host')) && !empty($options->get('smtp_host'))){
                Config::set('mail.mailers.smtp.host', $options->get('smtp_host'));
                Config::set('mail.mailers.smtp.port', $options->get('smtp_port'));  // Default to 587 for TLS
                Config::set('mail.mailers.smtp.encryption', $options->get('smtp_encryption')); // Enable TLS
                Config::set('mail.mailers.smtp.username', $options->get('smtp_username'));
                Config::set('mail.mailers.smtp.password', $options->get('smtp_password'));
                Config::set('mail.mailers.smtp.from.address', $options->get('smtp_sender')); // Disable encryption
                Config::set('mail.mailers.smtp.from.name', $options->get('smtp_name')); // Disable encryption
            }
            
            $url = route('otp')."?token=".$payload->token;
            Mail::to($payload->user?->email)->send(new OtpMail($payload->otp,$url));

        }catch(\Exception $e){
            Log::error('OTP Send Error::'.$e->getMessage());
        }
    }
}