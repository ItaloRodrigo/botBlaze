<?php

namespace App\Services;

use App\Console\Commands\BotTelegram;
use App\Models\Bot;
use App\Models\ChatUser;
use Telegram\Bot\Api;

class BotService{

    protected static $delay = 10;
    protected static TelegramBotClass $bot;

    /**
     * Método para execução do Serviço do robô
     */

    public static function run(BotTelegram $instance){
        self::$bot = new TelegramBotClass();
        //---
        $count = 0;
        $instance->line("Iniciando o serviço.....");
        while(true){
            $count++;
            $now = now();
            $instance->comment("[{{$now}}] - linha {{$count}}");
            // $ok = self::$bot->sendMessage();

            $instance->comment("Linhas afetadas:");
            // $instance->comment(json_encode($ok));
            $instance->comment("histórico:");
            $instance->comment(self::$bot->getHistoryBotJSON());
            //---
            $instance->comment("----------------------------------");
            // $instance->comment("----------------------------------");
            sleep(self::$delay);
        }

    }
}
