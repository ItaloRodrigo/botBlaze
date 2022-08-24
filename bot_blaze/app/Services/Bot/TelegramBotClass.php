<?php

namespace App\Services\Bot;

use App\Console\Commands\BotTelegram;
use App\Models\Bot;
use App\Models\ChatBot;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\MessageBot;
use App\Services\Metrics\BlazeBotClass;
use DateTime;
use Illuminate\Support\Arr;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotClass{

    protected $token;
    protected $bot;
    protected $telegram;
    protected $datetimenow;
    protected BotTelegram $instance;

    public function __construct() {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->bot = Bot::where('bot_token',$this->token)->get()[0];
        $this->telegram = new Api($this->token);
        $this->datetimenow = new DateTime();
    }

    /**
     * Métodos públicos
     *
     */

    public function run($instance){
        $this->instance = $instance;
        //----
        if($this->bot->bot_active){
            $chats_bot = ChatBot::where('cha_bot_id',$this->bot->bot_id)->get();
            foreach($chats_bot as $chat_bot){
                $this->sendMessageBot("BOT ON",$chat_bot);
            }
        }else{
            return "Bot não está ativo!!";
        }
    }

    protected function sendMessageBot($text,$chat_bot){
        /**
         * Aqui eu envio a mensagem!!
         */
        $this->instance->comment($text);
        $response = $this->telegram->sendMessage([
            'chat_id' => $chat_bot->cha_key,
            'text' => $text
        ]);
        /**
         * Registra os envios do Bot
         */
        MessageBot::create([
            'mes_id' => 0,
            'mes_cha_id' => $chat_bot->cha_id,
            'mes_update_id' => $response->getMessageId(),
            'mes_text' => $text
        ]);
        //---
        return $response;
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
