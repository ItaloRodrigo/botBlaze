<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\ChatUser;
use App\Models\Message;
use DateTime;
use Telegram\Bot\Api;

class TelegramBotClass{

    protected $token;
    protected $bot;
    protected $telegram;
    protected $datetimenow;

    public function __construct() {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->bot = Bot::where('bot_token',$this->token)->get();
        $this->telegram = new Api($this->token);
        $this->datetimenow = new DateTime();
    }

    /**
     * Métodos públicos
     *
     */

    public function sendBotMessage(){

        $affected = $this->updateChatUser($this->getHistoryBot());
        //---
        dd($this->getHistoryBot());

        return $affected;
    }


    public function getHistoryBotJSON(){
        return json_encode($this->getHistoryBot()[0]);
    }

    protected function getHistoryBot(){
        //Requisita da API do Telegram o histório do chat
        $history = $this->telegram->getUpdates();
        return $history;
    }

    protected function updateChatUser($history){

        $affecteds = 0;
        // dd($this->bot);
        foreach ($history as $key => $chat){
            $newchat = ChatUser::getChat($chat);
            //---
            $ok = ChatUser::where('cha_key',$newchat['cha_key'])->get();

            if(count($ok) == 0){
                /**
                 * Registra um novo chat de usuário
                 */
                $chatuser= ChatUser::create([
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

                Message::create([
                    'mes_id' => 0,
                    'mes_cha_id' => $chatuser->cha_id,
                    'mes_text' => $newchat['message'],
                    'mes_status' => 1, // 0 - enviado, 1 - recebido
                ]);

                //---
                $affecteds ++;
            }
        }
        return $affecteds;
    }

}
