<?php

namespace App\Listeners\backend;

use App\Events\backend\EventPayments;
use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatINVListener implements ShouldQueue
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\backend\EventPayments  $event
     * @return void
     */
    public function handle(EventPayments $event)
    {
        if ($this->shouldRun($event)) {
            if ($event->status == 'UpStatINV') {
                TMP_INVOICE::where('PatchCon_id', $event->PatchCont)
                    ->update([
                        'STATUSPAY' => 'yes',
                    ]);
            } elseif ($event->status == 'DeleteINV') {
                TMP_INVOICE::where('PatchCon_id', $event->PatchCont)->whereNull('STATUSPAY')->latest('id')->delete();
            }
        }
    }

    protected function shouldRun(EventPayments $event)
    {
        if ($event->someCondition == 'UpdateStatINV') {
            return $event->someCondition == true;
        } else {
            return false;
        }
    }
}
