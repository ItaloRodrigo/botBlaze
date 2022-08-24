<?php

namespace App\Services;

use App\Console\Commands\BotTelegram;
use App\Jobs\ProcessDataBlaze;
use App\Jobs\ProcessDetailBlaze;
use App\Jobs\ProcessSaveDataBlaze;
use App\Services\Metrics\AnalisadorCrash;
use App\Services\Metrics\BlazeBotClass;
use Illuminate\Support\Facades\Log;

class MetricsBot{
    protected static $delay = 10;

    public static function runCrash(){
        /**
         * Salva os registros de apostas no banco de dados
         *
         */
        BlazeBotClass::saveMinimalBet();
        ProcessDetailBlaze::dispatch();
        // AnalisadorCrash::analyser();

        return true;
    }

    public static function runDouble(){
        return false;
    }
}
