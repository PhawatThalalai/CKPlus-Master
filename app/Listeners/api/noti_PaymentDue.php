<?php

namespace App\Listeners\api;

use App\Events\api\sendNotificationApp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Services\ClicknextApiService;
use Illuminate\Support\Facades\Log;

class noti_PaymentDue implements ShouldQueue
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
     * @param  \App\Events\api\sendNotificationApp  $event
     * @return void
     */
    public function handle(sendNotificationApp $event)
    {
        $clicknextApiService = new ClicknextApiService();
        $KeyResponse = $clicknextApiService->getR2();

        $decryptedCredentials = encryptredVariable($event->data, $KeyResponse['r1'], $KeyResponse['r2']);
        $sendData = $clicknextApiService->sendData($decryptedCredentials, $KeyResponse['r1'], '/sendNotification');

        // Log the response
        Log::info('Notification sent: ' . json_encode($sendData));
    }
}
