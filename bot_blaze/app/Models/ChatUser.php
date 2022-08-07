<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = 'chat_user';

    protected $primaryKey = 'cha_id';

    public $timestamps = false;

    public $incrementing = true;

    protected $fillable = [
        'cha_id',
        'cha_bot_id',
        'cha_key',
        'cha_firstname',
        'cha_lastname',
        'cha_update_id',
        'cha_type',
        'cha_boot'
    ];


    public static function getTypeInt($type){
        if($type == "private"){
            return 1;
        }elseif($type == "group"){
            return 2;
        }else{
            return 3;
        }
    }

    public static function getTypeString($type){
        if($type == 1){
            return "private";
        }elseif($type == 2){
            return "group";
        }else{
            return "channel";
        }
    }

    public static function getChat($chat){
        $ok = Arr::has($chat, 'message');

        if($ok){ //padrão mensagem {message}
            return [
                'cha_key' => $chat->message->chat->id,
                'cha_firstname' => $chat->message->chat->first_name,
                'cha_lastname' => $chat->message->chat->last_name,
                'cha_update_id' => $chat->update_id,
                'cha_type' => ChatUser::getTypeInt($chat->message->chat->type),
                'cha_boot' => $chat->message->from->is_bot,
                'message' => $chat->message->text
            ];
        }else{ //padrão Canal {channel_post}
            return [
                'cha_key' => $chat->channel_post->chat->id,
                'cha_firstname' => $chat->channel_post->chat->title,
                'cha_lastname' => null,
                'cha_update_id' => $chat->update_id,
                'cha_type' => ChatUser::getTypeInt($chat->channel_post->chat->type),
                'cha_boot' => false,
                'message' => $chat->channel_post->text
            ];
        }
    }
}
