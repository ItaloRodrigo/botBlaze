<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessDataBlaze;
use App\Jobs\ProcessSaveDataBlaze;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use App\Models\Bot;
use App\Models\ChatUser;
use App\Services\Bot\TelegramBotClass;
use App\Services\Metrics\BlazeBotClass;
use App\Services\MetricsBot;

class BotController extends Controller
{
    protected TelegramBotClass $bot;
    protected $delay = 10;

    public function teste(){
        MetricsBot::runCrash();
        //---
        return true;
    }
}
