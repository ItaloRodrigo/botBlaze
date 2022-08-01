<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\ChatUser;
use Telegram\Bot\Api;

class TelegramBotClass{

    protected $token;
    protected $bot;

    public function __construct() {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->bot = Bot::where('bot_token',$this->token)->get();
    }

    public function getHistoryBot(){
        //Requisita da API do Telegram o histório do chat
        $telegram = new Api($this->token);

        $history = $telegram->getUpdates();
        return $history;
    }

    public static function teste(){
        return "teste do telegram bot";
    }

    public function sendMessage(){


        $teste = $this->updateChatUser($this->getHistoryBot());
        // dd($response[0]["message"]);

        return $teste;
    }

    protected function updateChatUser($history){
        $teste = '';

        foreach ($history as $key => $chat){

            $ok = ChatUser::where('cha_key',$chat["message"]['chat']['id'])->get();

            if(count($ok) == 0){
                /**
                 * Preciso chamar a ChatUser e inserir o novo registro
                 */
                ChatUser::create([
                    'cha_id' => 0,
                    'cha_bot_id' => $this->bot->cha_bot_id,
                    'cha_key' => $chat["message"]['chat']['id'],
                    'cha_firstname' => $chat["message"]['chat']['id'],
                    'cha_lastname' => $chat["message"]['chat']['id'],
                    'cha_updated_id' => $chat["message"]['chat']['id'],
                    'cha_type' => $chat["message"]['chat']['id'],
                    'cha_boot' => $chat["message"]['chat']['id']
                ]);
            }
        }

        return $teste;
    }

}
