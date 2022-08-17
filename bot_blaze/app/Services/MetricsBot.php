<?php

namespace App\Services;

use App\Services\Metrics\AnalisadorCrash;
use App\Services\Metrics\BlazeBotClass;

class MetricsBot{

    public static function runCrash(){
        /**
         * Salva os registros de apostas no banco de dados
         *
         */
        BlazeBotClass::saveMinimalBet();

        // AnalisadorCrash::analyser();

        return true;
    }

    public static function runDouble(){
        return false;
    }
}
