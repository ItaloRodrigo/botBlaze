<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Models\Bot;
use App\Models\ChatUser;

class BotController extends Controller
{
    // protected $TOKEN = env('TELEGRAM_BOT_TOKEN');

    private function getToken(){
        return env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessageBot(){
        $bot = Bot::where('bot_token',$this->getToken())->get();
        $telegram = new Api($this->getToken());
        $response = $telegram->getUpdates();
        $teste = ChatUser::updateAllChats($response);
        // dd($response[0]["message"]);

        return $teste;
    }
}
