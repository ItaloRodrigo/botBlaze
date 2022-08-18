<?php

namespace App\Jobs;

use App\Services\Metrics\BlazeBotClass;
use App\Services\MetricsBot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDataBlaze implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue('process_data_blaze');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        BlazeBotClass::saveDetailBet();
        return true;
    }
}
