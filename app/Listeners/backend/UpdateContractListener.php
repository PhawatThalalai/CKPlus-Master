<?php

namespace App\Listeners\backend;

use App\Events\backend\EventPayments;
use App\Models\TB_Assets\Data_AssetsOwnership;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;

class UpdateContractListener implements ShouldQueue
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
     * @param  \App\Events\backend\EventPayments  $event
     * @return void
     */
    public function handle(EventPayments $event)
    {
        if ($this->shouldRun($event)) {
            $this->updateContract($event);
        }
    }

    protected function shouldRun(EventPayments $event)
    {
        if ($event->someCondition == 'UpdateContract') {
            return $event->someCondition == true;
        } else {
            return false;
        }
    }

    protected function updateContract(EventPayments $event)
    {
        try {
            DB::transaction(function () use ($event) {
                $contract = $event->PatchCont->CODLOAN == 1
                    ? PatchPSL_Contracts::find($event->PatchCont->id)
                    : PatchHP_Contracts::find($event->PatchCont->id);

                if ($event->status == 'UpdatePayfor') {    //บันทึกการชำระเงิน 007
                    if ($contract) {
                        $contract->update([
                            'CONTSTAT' => 'C',
                            'CLOSTAT' => 'Y',
                            // 'CLOSAR' => date('Y-m-d'),
                        ]);

                        $related = $contract->PatchToPact()->first();
                        if ($related) {
                            $related->update([
                                'Status_Con' => 'close',
                                'StatusApp_Con' => 'ปิดบัญชี'
                            ]);

                            $asset = $related->ContractToIndentureAsset2->pluck('Asset_id');
                            Data_AssetsOwnership::whereIn('id', $asset)->update([
                                'State_Ownership' => 'Completed'
                            ]);

                        } else {
                            Log::error('Related PatchToPact not found for contract ID: ' . $event->PatchCont->id);
                        }
                    } else {
                        Log::error('Contract not found: ' . $event->PatchCont->id);
                    }
                } elseif ($event->status == 'Update-save-seized') {     //บันทึกรอไถ่ถอน
                    if ($contract) {
                        $contract->update([
                            "YSTAT" => "Y",
                            "YDATE" => $contract->ContractToHLD->YDATE,
                            "CONTSTAT" => "Y"
                        ]);
                    }
                } elseif ($event->status == 'Update-save-Stock') {    //บันทึกยึด
                    //dd($contract->ContractToHLD->YDATE,$contract->CONTNO);
                    if ($contract) {
                        $contract->update([
                            "CLOSAR" => $contract->ContractToHLD->YDATE,
                            "CONTSTAT" => "H"
                        ]);

                        $related = $contract->PatchToPact;
                        $asset = $related->ContractToIndentureAsset2->pluck('Asset_id');
                        Data_AssetsOwnership::whereIn('id', $asset)->update([
                            'CONTSTAT' => 'Y',
                            "CLOSAR" => $contract->ContractToHLD->YDATE,
                        ]);
                    }
                } elseif ($event->status == 'Update-removeStock') {    //ยกเลิกยึด
                    if ($contract) {
                        $contract->update([
                            "CLOSAR" => null,
                            "CONTSTAT" => "Y"
                        ]);

                        $related = $contract->PatchToPact;
                        $asset = $related->ContractToIndentureAsset2->pluck('Asset_id');
                        Data_AssetsOwnership::whereIn('id', $asset)->update([
                            'CONTSTAT' => 'N',
                            "CLOSAR" => null,
                        ]);
                    }
                } elseif ($event->status == 'Update-deleteSeized') {    //ยกเลิกรอไถ่ถอน
                    if ($contract) {
                        $contract->update([
                            "YSTAT" => 'N',
                            "YDATE" => null,
                            "CONTSTAT" => $event->_CONTSTAT
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to update contract: ' . $e->getMessage());
        }
    }
}
