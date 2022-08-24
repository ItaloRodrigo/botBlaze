<?php

namespace App\Services\Metrics;

class MetricsBot{
    protected static $delay = 10;

    public static function runCrash(){
        // AnalisadorCrash::analyser();
        return true;
    }

    public static function runDouble(){
        return false;
    }
}
