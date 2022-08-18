<?php

namespace App\Services;

use App\Jobs\ProcessDataBlaze;
use App\Services\Metrics\AnalisadorCrash;
use App\Services\Metrics\BlazeBotClass;

class MetricsBot{

    public static function runCrash(){
        /**
         * Salva os registros de apostas no banco de dados
         *
         */
        BlazeBotClass::saveMinimalBet();
        ProcessDataBlaze::dispatch()->onQueue('process_data_blaze');

        // AnalisadorCrash::analyser();

        return true;
    }

    public static function runDouble(){
        return false;
    }
}
