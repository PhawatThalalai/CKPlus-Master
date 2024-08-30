<?php

namespace App\Listeners;

use App\Events\frontend\checklistEvents;
use App\Models\TB_PactContracts\Pact_AuditChecklists;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class checklistListener implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  \App\Events\frontend\checklistEvents  $event
     * @return void
     */
    public function handle(checklistEvents $event)
    {
        $checklist = Pact_AuditChecklists::where('audit_id',$event->audit_id)->first();
        if ($checklist) {
            $checklist->delete();
        }

        
    }
}
