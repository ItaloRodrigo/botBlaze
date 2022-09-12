<?php

namespace App\Services;

use App\Console\Commands\BotTelegram;
use App\Jobs\ProcessDetailBlaze;
use App\Models\Bot;
use App\Models\ChatUser;
use App\Services\Bot\TelegramBotClass;
use App\Services\Metrics\BlazeBotClass;
use DateTime;
use Telegram\Bot\Api;

class BotService{

    protected static $delay = 10;
    protected static TelegramBotClass $bot;

    /**
     * Método para execução do Serviço do robô
     */

    public static function run(BotTelegram $instance){
        $count = 0;
        $instance->line("Iniciando o serviço.....");

        /**
         * Verifico se o Bot está ativo!
         */

        self::$bot = new TelegramBotClass($instance);
        self::$bot->isActive();
        //---
        while(true){
            $count++;
            $now = now();
            $instance->comment("[{{$now}}] - linha {{$count}}");
            /**
             * Registra os dados de aposta do Blaze
             */

            $counth = BlazeBotClass::saveMinimalBet();

            /**
             * Job que processa em segundo plano os registros de detalhes das apostas Blaze
             */
            ProcessDetailBlaze::dispatch();

            /**
             * Aqui eu executo o bot da Classe TelegramBotClass
             * método ::run();
             */
            self::$bot->run();
            //---
            $instance->info("Históricos registrados: ".$counth);
            //---
            $instance->comment("----------------------------------");
            // $instance->comment("----------------------------------");
            sleep(self::$delay);
        }
    }
}
