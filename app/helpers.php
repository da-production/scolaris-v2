<?php

use App\Models\Exercice;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

if( !function_exists('convertSize')){
    function convertSize($sizeInBytes) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $unitIndex = 0;
    
        while ($sizeInBytes >= 1024 && $unitIndex < count($units) - 1) {
            $sizeInBytes /= 1024;
            $unitIndex++;
        }
    
        return round($sizeInBytes, 2) . ' ' . $units[$unitIndex];
    }
}


/**
 * How to calculate the average of the candidate's 
 * (coefficient CLASS * Coefficient SPEC) + (0.2 * MOYEN S5S6) / (0.2+ Coefficient SPEC)
 */

if( !function_exists('calculateAverage')){

    /**
     * Calculate the average based on coefficients and semester average.
     *
     * @param float $coefficientClass Coefficient for the class.
     * @param float $coefficientSpec Coefficient for the specialization.
     * @param float $moyenneSemestres Average of the semesters.
     * @return float The calculated average, rounded to 2 decimal places.
     */
    function calculateAverage($coefficientClass, $coefficientSpec, $moyenneSemestres) {
        if($coefficientClass <= 0 || $coefficientSpec <= 0 || $moyenneSemestres < 0){
            return 0;
        }
        return round((($coefficientClass * $coefficientSpec) + (0.2 * $moyenneSemestres)) / (0.2 + $coefficientSpec), 2);
    }
}

if( !function_exists('closeRegister')){
    function imageToBase64($path)
    {
        if(is_null($path) || empty($path)) {
            return null;
        }
        if (!Storage::disk('private')->exists($path)) {
            return null;
        }

        $file = Storage::disk('private')->get($path);
        $mime = Storage::disk('private')->mimeType($path);
        $base64 = base64_encode($file);

        return "data:$mime;base64,$base64";
    }
}

if( !function_exists('closeRegister')){
    function closeRegister(){
        $exercice = Cache::rememberForever('exercice', function () {
            return Exercice::where('annee', now()->year)->first();
        });
        if(is_null($exercice)){
            return false;
        }
        if($exercice->is_closed){
            return false;
        }
        if(Carbon::parse($exercice->closed_at)->isPast()){
            return false;
        }
        return true;
    }
}

if( !function_exists('canCandidatUpdate')){
    function canCandidatUpdate(){
        $exercice = Cache::rememberForever('exercice', function () {
            return Exercice::where('annee', now()->year)->first();
        });
        if(is_null($exercice)){
            return false;
        }
        if($exercice->is_closed){
            return false;
        }
        if(!Carbon::parse($exercice->closed_at)->isPast()){
            return true;
        }
        return false;
    }
}

if(!function_exists('setSmtpOption')){
    function setSmtpOption(){
        $options = [];
            $getOptionsFromCache = Cache::rememberForever('smtp', function(){
                return Option::where('model_type', 'smtp')->get();
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
            
    }
}