<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\ChatUser;
use Illuminate\Support\Arr;
use Telegram\Bot\Api;

class TelegramBotClass{

    protected $token;
    protected $bot;

    public function __construct() {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->bot = Bot::where('bot_token',$this->token)->get();
    }

    /**
     * Métodos públicos
     *
     */

    public function sendMessage(){

        $affected = $this->updateChatUser($this->getHistoryBot());
        // dd($response[0]["message"]);

        return $affected;
    }


    public function getHistoryBotJSON(){
        return json_encode($this->getHistoryBot()[0]);
    }

    protected function getHistoryBot(){
        //Requisita da API do Telegram o histório do chat
        $telegram = new Api($this->token);

        $history = $telegram->getUpdates();
        return $history;
    }

    protected function updateChatUser($history){

        $affecteds = 0;
        dd($history);
        foreach ($history as $key => $chat){
            $newchat = ChatUser::getChat($chat);
            //---
            $ok = ChatUser::where('cha_key',$newchat['cha_key'])->get();

            if(count($ok) == 0){
                /**
                 * Registra um novo chat de usuário
                 */
                ChatUser::create([
                    'cha_id' => 0,
                    'cha_bot_id' => $this->bot[0]->bot_id,
                    'cha_key' => $newchat['cha_key'],
                    'cha_firstname' => $newchat['cha_firstname'],
                    'cha_lastname' => $newchat['cha_lastname'],
                    'cha_update_id' => $newchat['cha_update_id'],
                    'cha_type' => $newchat['cha_type'],
                    'cha_boot' => $newchat['cha_boot'],
                ]);
                /**
                 * Registra a mensagem do usuário
                 * [FALTA FAZER um COUNT(*) NA TABELA MENSAGEM FILTRANDO POR DIA PRA IDENTIFICAR AS NOVAS MENSAGENS]
                 */


                //---
                $affecteds ++;
            }
        }
        return $affecteds;
    }

}
