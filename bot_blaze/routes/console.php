<?php

use App\Console\Commands\BotTelegram;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('teste', function () {
    // $bot = new BotTelegram();
    // $bot->handle(new TelegramBot());
})->purpose('Display an inspiring quote');

// Artisan::command('bot:telegram', function () {
//     $this->comment("Iniciando o serviço!");
//     // BotTelegram::class;
//     $this->call('bot:telegram');
//     $this->comment("Finalizando o serviço!");
// })->purpose('Display an inspiring quote');
