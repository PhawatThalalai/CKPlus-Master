<?php

namespace App\Listeners\frontend;

use App\Events\frontend\LogDataCusTag;
use App\Models\TB_Logs\Log_DataCustomersTags;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
class LogDataCusTagListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
   
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\frontend\LogDataCusTag  $event
     * @return void
     */
    public function handle(LogDataCusTag $event)
    {
        $dataCusTagLog = new Log_DataCustomersTags();
        $dataCusTagLog->Data_id = $event->Data_id;
        $dataCusTagLog->date = date("Y-m-d");
        $dataCusTagLog->status = $event->Status;
        $dataCusTagLog->model = $event->Model;
        $dataCusTagLog->tagInput = $event->Taginput;
        $dataCusTagLog->details = $event->Detail;
        $dataCusTagLog->UserInsert =  $event->User;
        $dataCusTagLog->save();
    }
}
