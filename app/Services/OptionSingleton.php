<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Option;

class OptionSingleton
{
    // Instance of the class to implement Singleton pattern
    private static $instance;

    // Cached options
    private $options;

    // Private constructor to prevent direct creation of instance
    private function __construct()
    {
        // Load the options once from cache or database
        $this->loadOptions();
    }

    // Get the instance of OptionSingleton
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new OptionSingleton();
        }

        return self::$instance;
    }

    // Load options from cache or database
    public function loadOptions()
    {
        // Using Laravel Cache to avoid repeated DB queries
        $this->options = Cache::rememberForever('options', function () {
            return Option::all()->pluck('name', 'value')->toArray(); // Cache options as key-value pairs
        });
    }

    // Retrieve the value for a specific option by key
    public function getOption($key)
    {
        return $this->options[$key] ?? null; // Return null if not found
    }

    // You can add more methods to update cache, etc.
    public function refreshOptions()
    {
        Cache::forget('options');
        $this->loadOptions();
    }
}
