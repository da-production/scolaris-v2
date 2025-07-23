<?php

namespace App\Traits;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;

trait WithOptions{

    public $options = [];
        
    public function initOptions($key){
        $options = Cache::rememberForever($key, function(){
            return Option::where('model_type', 'inscription')->get();
        });
        foreach ($options as $option) {
            $this->options[$option->name] = $option->value;
        }
        $this->options = collect($options);
        
    }

}