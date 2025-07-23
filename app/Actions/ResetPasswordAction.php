<?php

namespace App\Actions;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResetPasswordAction{
    public static function send($email, $token){
        try{
            setSmtpOption();
            Mail::to($email)->send(new ResetPasswordMail(route('guest.candidat.password.reset',['token'=>$token])));
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }
}