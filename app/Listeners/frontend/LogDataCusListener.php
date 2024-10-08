<?php

namespace App\Listeners\frontend;

use App\Events\frontend\LogDataCus;
use App\Models\TB_Logs\Log_DataCustomers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogDataCusListener implements ShouldQueue
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
     * @param  \App\Events\frontend\LogDataCus  $event
     * @return void
     */
    public function handle(LogDataCus $event)
    {
        try{
            $dataCusTagLog = new Log_DataCustomers;
            $dataCusTagLog->Data_id = $event->Data_id;
            $dataCusTagLog->date = date("Y-m-d");
            $dataCusTagLog->status = $event->Status;
            $dataCusTagLog->model = $event->Model;
            $dataCusTagLog->tagInput = $event->Taginput;
            $dataCusTagLog->details = $event->Detail;
            $dataCusTagLog->UserInsert =  $event->User;
            $dataCusTagLog->save();
        } catch (\Exception $e) {
            // ทำการ handle ข้อผิดพลาด
        }
    }
}
