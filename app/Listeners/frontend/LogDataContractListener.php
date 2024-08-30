<?php

namespace App\Listeners\frontend;

use App\Events\frontend\LogDataContract;
use App\Models\TB_Logs\Log_ContractsCon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogDataContractListener implements ShouldQueue
{

    public function __construct()
    {
        //
    }

    
    public function handle(LogDataContract $event)
    {
            $dataContractLog = new Log_ContractsCon;
            $dataContractLog->Data_id = $event->Data_id;
            $dataContractLog->date = date("Y-m-d");
            $dataContractLog->status = $event->Status;
            $dataContractLog->model = $event->Model;
            $dataContractLog->tagInput = $event->Taginput;
            $dataContractLog->details = $event->Detail;
            $dataContractLog->UserInsert =  $event->User;
            $dataContractLog->save();
        


    }
}


