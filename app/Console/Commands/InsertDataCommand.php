<?php

namespace App\Console\Commands;

use App\Models\TB_Logs\Log_ContractsCon;
use Illuminate\Console\Command;

class InsertDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loginsert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $data =  new Log_ContractsCon;
        $data->details = 'test555';
        $data->save();
    }

    
}
