<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReceiptCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $groupedByYear = $this->collection->groupBy('receiptYear');

        $result = $groupedByYear->map(function ($receipts, $year) {
            return [
                'year' => $year,
                'receiptList' => $receipts->map(function ($receipt) {
                    return [
                        'receiptId' => $receipt->receiptId,
                        'receiptDate' => $receipt->receiptDate,
                        'receiptAmount' => $receipt->receiptAmount,
                    ];
                })
            ];
        })->sortKeysDesc();

        return $result;
    }
}
