<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $table = 'chat_user';

    protected $primaryKey = 'cha_id';


    public static function updateAllChats($telegram){

        $teste = '';

        foreach ($telegram as $key => $tel){

            $ok = ChatUser::where('cha_key',$tel["message"]['chat']['id'])->get();

            if(count($ok) == 1){
                /**
                 * Preciso chamar a ChatUser e inserir o novo registro
                 */
            }
        }

        return $teste;
    }
}
