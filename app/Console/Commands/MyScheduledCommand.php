<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TB_Logs\Log_ContractsCon;

class MyScheduledCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:scheduled-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My scheduled command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data =  new Log_ContractsCon;
           $data->details = 'test';
        $data->save();
        
        return Command::SUCCESS;
    }
}
