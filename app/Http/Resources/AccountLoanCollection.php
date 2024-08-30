<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountLoanCollection extends ResourceCollection
{
    protected $R1;
    protected $R2;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  mixed  $R1
     * @param  mixed  $R2
     * @return void
     */
    public function __construct($resource, $R1, $R2)
    {
        parent::__construct($resource);
        $this->R1 = $R1;
        $this->R2 = $R2;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'accountCount' => (int) $this->collection->count(),
            'accountList' => $this->collection->map(function ($item) {
                return [
                    'accountId' => $item->accountId,
                    'accountStatus' => $item->accountStatus,
                    'type' => [
                        'typeId' => (int) $item->typeId,
                        'typeName' => $item->typeName,
                        'typeModel' => $item->typeModel,
                        'typeLicense' => $item->typeLicense,
                        'typeProvince' => $item->typeProvince
                    ],
                    'info' => [
                        'totalAmount' => encryptredVariable((double) $item->totalAmount, $this->R1, $this->R2),
                        'totalPaid' => encryptredVariable((double) $item->totalPaid, $this->R1, $this->R2),
                        'totalBalance' => encryptredVariable((double) $item->totalBalance, $this->R1, $this->R2),
                        'periodNo' => (int) $item->periodNo,
                        'periodCount' => (int) $item->periodCount,
                        'paidPerPeriod' => encryptredVariable((double) $item->paidPerPeriod, $this->R1, $this->R2),
                        'paymentDueDate' => $item->paymentDueDate,
                        'updateTime' => $item->updateTime,
                        'creditHealth' => (int) $item->creditHealth,
                        'textBalance' => $item->textBalance,
                    ],
                    'contract' => [
                        'contractNo' => $item->contractNo,
                        'customerId' => $item->customerId,
                        'contractValue' => encryptredVariable($item->contractValue, $this->R1, $this->R2),
                        'capitalValue' => encryptredVariable($item->capitalValue, $this->R1, $this->R2),
                        'periodCount' => (int) $item->periodCount,
                        'paidPerPeriod' => encryptredVariable((double) $item->paidPerPeriod, $this->R1, $this->R2),
                        'startDate' => $item->startDate,
                        'paidDueDate' => $item->paidDueDate,
                    ],
                    'overdueInfo' => [
                        'overdueInterest' => encryptredVariable((double) $item->overdueInterest, $this->R1, $this->R2),
                        'overdueFollowUp' => encryptredVariable((double) $item->overdueFollowUp, $this->R1, $this->R2),
                        'overduePaid' => encryptredVariable((double) $item->overduePaid, $this->R1, $this->R2),
                        'overdueBalance' => encryptredVariable((double) $item->overdueBalance, $this->R1, $this->R2)
                    ]
                ];
            }),
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'version' => '1.0.0',
    //         'author_url' => url('https://www.google.com'),
    //     ];
    // }
}
