<?php

namespace App\Services;

use App\Models\BetsDetail;
use App\Models\BettingUser;
use App\Models\GameType;
use App\Models\History;
use App\Models\StatisticsUser;
use Illuminate\Support\Facades\Http;

class BlazeBotClass{

    public static function saveBet(){
        $recent_crash = self::getRecentCrash();

        foreach($recent_crash as $key1 => $current){
            /**
             * Pego o id corrente da crash
             */
            $detail_crash = self::getDetailCrash($current['id']);
            //---
            /**
             * Gravo o histórico de jogadas
             */
            $count = History::where('his_key_blaze',$current['id'])->count();
            //---
            if($count == 0){
                $history = History::create([
                    'his_id' => 0,
                    'his_key_blaze' => $current['id'],
                    'his_crash_point' => $current['crash_point'],
                    'his_created' => date('Y-m-d H:i:s'),
                    'his_total_bets_placed' => $detail_crash['total_bets_placed']
                ]);
                /**
                 * Gravo os detalhes das apostas de usuários
                 */
                foreach($detail_crash['bets'] as $key2 => $bet){
                    /**
                     * Salvo e verifico se existe um usuário do bet
                     */
                    //---
                    $count =  BettingUser::where('beu_key_blaze',$bet['user']['id_str'])->count();
                    //---
                    $blaze_user = self::getBlazeUser($bet['user']['id_str']);
                    //---
                    if($count == 0){ //usuário inexsistente na base de dados
                        //---
                        $betting_user = BettingUser::create([
                            'beu_id' => 0,
                            'beu_key_number' => $bet['user']['id'],
                            'beu_key_blaze' => $bet['user']['id_str'],
                            'beu_username' => $blaze_user['username'],
                            'beu_rank' => $blaze_user['rank'],
                            'beu_level' => $blaze_user['level']
                        ]);
                    }else{ //usuário cadastrado no banco
                        // faço a busca do usuário
                        $betting_user = BettingUser::where('beu_key_blaze',$bet['user']['id_str'])->get()[0];
                    }
                    /**
                     * Gravo as apostas do usuário
                     */
                    $count = BetsDetail::where('bet_key_blaze',$history->his_key_blaze)->count();
                    //---
                    if($count == 0){
                        BetsDetail::create([
                            'bet_id' => 0,
                            'bet_his_id' => $history->his_id,
                            'bet_beu_id' => $betting_user->beu_id,
                            'bet_key_blaze' => $history->his_key_blaze,
                            'bet_cashed_out_at' => $bet['cashed_out_at'],
                            'bet_amount' => $bet['amount'],
                            'bet_win_amount' => $bet['win_amount'],
                            'bet_status' => $bet['status']
                        ]);
                    }
                    /**
                     * Gravo as estatísticas do jogador
                     */
                    foreach ($blaze_user['bet_statistics'] as $key3 => $estatistica){
                        /**
                         * Verifico se o tipo de game já existe no banco
                         */
                        $count = GameType::where('gat_name',$estatistica['game_type'])->count();
                        //---
                        if($count == 0){ // se não existir
                            $game_type = GameType::create([
                                'gat_id' => 0,
                                'gat_name' => $estatistica['game_type'],
                                'gat_created' => date('Y-m-d H:i:s'),
                            ]);
                        }else{
                            $game_type = GameType::where('gat_name',$estatistica['game_type'])->get()[0];
                        }
                        //---
                        $count = StatisticsUser::where('stu_beu_id',$betting_user->beu_id)
                                            ->where('stu_gat_id',$game_type->gat_id)
                                            ->count();
                        //---
                        if($count == 0){
                            /**
                             * Crio o primeiro registro
                             */
                            StatisticsUser::create([
                                'stu_beu_id' => $betting_user->beu_id,
                                'stu_gat_id' => $game_type->gat_id,
                                'stu_total_bets' => $estatistica['total_bets'],
                                'stu_total_bets_won' => $estatistica['total_bets_won'],
                                'stu_total_bets_lost' => $estatistica['total_bets_lost'],
                                'stu_updated' => date('Y-m-d H:i:s')
                            ]);
                        }else{
                            /**
                             * Atualizo as apostas do usuário
                             */
                            StatisticsUser::where('stu_beu_id',$betting_user->beu_id)
                            ->where('stu_gat_id',$game_type->gat_id)
                            ->update([
                                'stu_total_bets' => $estatistica['total_bets'],
                                'stu_total_bets_won' => $estatistica['total_bets_won'],
                                'stu_total_bets_lost' => $estatistica['total_bets_lost'],
                                'stu_updated' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            }
        }
        return true;
    }

    protected static function getRecentCrash(){
        // crash recentes
        $response = Http::get('https://blaze.com/api/crash_games/recent');
        //---
        return $response->json();
    }

    protected static function getDetailCrash($id){
        // crash detail
        /**
         * parâmetro 'V1eK5vGRlo' é o id do crash
         */
        $response = Http::get('https://blaze.com/api/crash_games/'.$id.'?page=1');

        return $response->json();
    }

    protected static function getBlazeUser($id_str){
        // Detalhes do Usuário Blaze
        /**
         * parâmetro 'OWld39KVk3' é o id do usuário
         */
        $response = Http::get('https://blaze.com/api/user_profiles/'.$id_str);

        return $response->json();
    }
}
