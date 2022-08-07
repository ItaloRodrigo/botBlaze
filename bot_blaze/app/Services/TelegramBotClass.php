<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\MessageBot;
use DateTime;
use Illuminate\Support\Arr;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

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

        // dd($this->getHistoryBot());

        dd(BlazeBotClass::getBlaze());

        $updates = $this->updatesMessage($this->getHistoryBot());
        //---
        $affected = $this->saveNewMessage($updates);
        //---
        $text = "testando - italo";
        $response = $this->telegram->sendMessage([
            'chat_id' => '5507982458',
            'text' => $text
        ]);
        $this->saveNewMessageBot($response->getMessageId(), $text);

        //---
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

    protected function updatesMessage($history){
        $update_id = Message::max('mes_update_id');
        //---
        if($update_id == null){
            $last = $history;
        }else{
            $last = Arr::where($history, function ($value, $key) use($update_id) {
                return $value['update_id'] > $update_id;
            });
        }
        //---
        return $last;
    }

    protected function saveNewMessageBot($update_id, $text){

        /**
         * Registra os envios do Bot
         */
        MessageBot::create([
            'mes_id' => 0,
            'mes_bot_id' => $this->bot[0]->bot_id,
            'mes_update_id' => $update_id,
            'mes_text' => $text
        ]);
    }

    protected function saveNewMessage($history){
        $affecteds = 0;
        foreach($history as $key => $chat){
            $newchat = ChatUser::getChat($chat);
            //---
            $chatquery = ChatUser::where('cha_key',$newchat['cha_key'])->get();
            // verifica se o usuário existe no banco
            if(count($chatquery) == 0){
                /**
                 * Registra um novo chat de usuário
                 */
                $chatuser= ChatUser::create([
                    'cha_id' => 0,
                    'cha_bot_id' => $this->bot[0]->bot_id,
                    'cha_key' => $newchat['cha_key'],
                    'cha_firstname' => $newchat['cha_firstname'],
                    'cha_lastname' => $newchat['cha_lastname'],
                    'cha_type' => $newchat['cha_type'],
                    'cha_boot' => $newchat['cha_boot'],
                ]);
            }else{
                $chatuser = $chatquery[0];
            }
            /**
             * Registra a mensagem do usuário
             */
            Message::create([
                'mes_id' => 0,
                'mes_cha_id' => $chatuser->cha_id,
                'mes_update_id' => $newchat['cha_update_id'],
                'mes_text' => $newchat['message'],
                'mes_status' => 1, // 0 - enviado, 1 - recebido
            ]);
            $affecteds++;
        }
        //---
        return $affecteds;
    }

}
