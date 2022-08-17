<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Models\Bot;
use App\Models\ChatUser;
use App\Services\Bot\TelegramBotClass;
use App\Services\MetricsBot;

class BotController extends Controller
{
    protected TelegramBotClass $bot;
    protected $delay = 10;

    public function teste(){
        // $telegram = new Api('5546066078:AAGu7OdrsRjiGQwl_IY2kBIgNnqy_7OSKCU');
        // $telegram = new Api('TELEGRAM_BOT_TOKEN');
        // $teste = $telegram->getUpdates();
        // $bot = TelegramBotClass();


        // acessos
        /**
         * 1 - $teste[0]['update_id']
         * 2 - $teste[0]['message']
         * 3 -
         */
        // dd($teste);
        // dd($teste[0]['message']);


        //140321351
        // id do italo = 5507982458
        // id do canal teste = -1001546814958
        // $response = $telegram->sendMessage([
        //     'chat_id' => '5507982458',
        //     'text' => 'Hello World!! Oi amor deu certo, de novo!!!!'
        // ]);

        // $response = $telegram->getChat([
        //     'chat_id' => 5507982458
        // ]);

        // dd($response);

        // $messageId = $response->getMessageId();
        // dd($teste);

        // $this->bot = new TelegramBotClass();
        // //---
        // $count = 0;
        // while(true){
        //     $count++;
        //     $this->
        //     sleep($this->delay);
        // }

        MetricsBot::runCrash();

        // $this->bot = new TelegramBotClass();
        // $afetadas = $this->bot->sendBotMessage();

        return true;
    }
}
