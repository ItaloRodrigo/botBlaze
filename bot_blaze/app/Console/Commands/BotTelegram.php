<?php

namespace App\Console\Commands;

use App\Services\BotService;
use App\Services\MetricsBot;
use App\Services\TelegramBot;
use App\Services\TelegramBotClass;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\SignalableCommandInterface;

class BotTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para executar o bot do Telegram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $cont = 0;
        // $this->comment("Iniciando o teste");
        // while(true){
        //     $cont++;
        //     $this->warn("teste do comando:{{$cont}}");
        //     sleep(10);
        // }
        // $this->comment("Finalizando o teste");
        // $telegram = new TelegramBot();
        // TelegramBotClass::teste();
        MetricsBot::run($this);
        //---
        return 1;
    }

    // public function getSubscribedSignals(): array
    // {
    //     return [SIGINT, SIGTERM];
    // }

    // /**
    //  * Handle an incoming signal.
    //  *
    //  * @param  int  $signal
    //  * @return void
    //  */
    // public function handleSignal(int $signal): void
    // {
    //     if ($signal === SIGINT) {
    //         $this->info("teste do comando");
    //         $this->stopServer();

    //         return;
    //     }
    // }
}
