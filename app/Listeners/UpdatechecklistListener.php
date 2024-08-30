<?php

namespace App\Listeners;

use App\Events\frontend\checklistEvents;
use App\Models\TB_PactContracts\Pact_AuditChecklists;

use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatechecklistListener implements ShouldQueue
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
        try {
            $list = new Pact_AuditChecklists;
            $list->PactCon_id = $event->Pact_id;
            $list->audit_id = $event->audit_id;
            $list->auditTagprt_id = $event->tagPart_id;
            $list->check_complete = (isset($event->radiosData['check-complete'])? implode(",", $event->radiosData['check-complete']) : null);
            $list->check_edit = (isset($event->radiosData['check-edit'])? implode(",", $event->radiosData['check-edit']) : null);
            $list->check_edited = (isset($event->radiosData['check-edited'])? implode(",", $event->radiosData['check-edited']) : null);
            $list->save();
    
            $result = 'success';
        } catch (\Exception $e) {
            // ทำการ handle ข้อผิดพลาด
            $result = 'fail';
        }
    
        return $result;
    }
}
