<?php

namespace App\Listeners\frontend;

use App\Events\frontend\LogDataAsset;
use App\Models\TB_Logs\Log_DataAssets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogDataAssetListener
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
     * @param  \App\Events\frontend\LogDataAsset  $event
     * @return void
     */
    public function handle(LogDataAsset $event)
    {
        try{
            $dataCusTagLog = new Log_DataAssets;
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
