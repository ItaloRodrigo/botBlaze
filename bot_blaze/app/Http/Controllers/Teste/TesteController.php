<?php

namespace App\Http\Controllers\Teste;

use App\Http\Controllers\Controller;
use App\Services\TelegramBotClass;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TesteController extends Controller
{

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

        return $teste;
    }
}
