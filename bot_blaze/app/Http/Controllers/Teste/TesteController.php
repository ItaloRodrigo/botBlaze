<?php

namespace App\Http\Controllers\Teste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TesteController extends Controller
{

    public function teste(){
        $telegram = new Api('5546066078:AAGu7OdrsRjiGQwl_IY2kBIgNnqy_7OSKCU');
        // $telegram = new Api('TELEGRAM_BOT_TOKEN');
        $teste = $telegram->getUpdates();

        // acessos
        /**
         * 1 - $teste[0]['update_id']
         * 2 - $teste[0]['message']
         * 3 -
         */

        dd($teste[0]['message']);


        //140321351
        // $response = $telegram->sendMessage([
        //     'chat_id' => '-1001546814958',
        //     'text' => 'Hello World!! Oi amor deu certo, de novo!!!!'
        // ]);
        // $messageId = $response->getMessageId();
        // dd($teste);

        return $teste;
    }
}
