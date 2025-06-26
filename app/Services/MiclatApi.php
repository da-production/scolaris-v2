<?php

namespace App\Services;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MiclatApi{

    public static function Auth(){
        $token = Cache::remember('miclat_token', now()->addMinutes(15) , function ()  {
            
            $response = Http::post('http://172.16.18.52/api/Auth/Login' , [
                'user' => 'MinTESS05',
                'password' => 'MinTESS@$$06',
            ]);
            if($response->failed()){
                session()->flash('error', __('Failed to retrieve token from Miclat API.'));
                return null;
            }
            $data = $response->json();
            $option = Option::where('name', 'miclat_token')->first();
            if(is_null($option)){
                $option = new Option();
                $option->model_type = 'Api';
                $option->name = 'miclat_token';
                $option->value = $data['token'];
            }else{

                $option->value = $data['token'];
            }
            $option->save();
            return $option->value;
        });
        return $token;
    }

    public static function GetInformations($nin){
        
        $token = self::Auth();
        if(is_null($token)){
            return null;
        }
        $response = Http::withToken($token)->get('http://172.16.18.52/api/Miclat/GetIdentiteSecond', [
            'Nin' => $nin,
        ]);
        if($response->failed()){
            session()->flash('error', __('Failed to retrieve information from Miclat API.'));
            return null;
        }
        return $response;
    } 

}