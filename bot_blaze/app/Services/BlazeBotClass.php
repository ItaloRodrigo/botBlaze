<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BlazeBotClass{

    public static function getBlaze(){
        //crashs atuais da hora corrente
        $response = Http::get('https://blaze.com/api/crash_games/current');

        return $response->json();
    }

    public static function getRecentCrash(){
        // crash recentes
        $response = Http::get('https://blaze.com/api/crash_games/recent');

        return $response->json();
    }

    public static function getDetailCrash(){
        // crash detail
        /**
         * parâmetro 'V1eK5vGRlo' é o id do crash
         */
        $response = Http::get('https://blaze.com/api/crash_games/V1eK5vGRlo?page=1');

        return $response->json();
    }

    public static function getBlazeUser(){
        // Detalhes do Usuário Blaze
        /**
         * parâmetro 'OWld39KVk3' é o id do usuário
         */
        $response = Http::get('https://blaze.com/api/user_profiles/OWld39KVk3');

        return $response->json();
    }
}
