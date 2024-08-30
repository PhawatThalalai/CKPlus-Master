<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoicesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $groupedByYear = $this->collection->groupBy('invoiceYear');
        $result = $groupedByYear->map(function ($invoices, $year) {
            return [
                'year' => $year,
                'invoiceList' => $invoices->map(function ($invoice) {
                    return [
                        'invoiceId' => $invoice->invoiceId,
                        'invoiceDate' => $invoice->invoiceDate,
                    ];
                })
            ];
        })->sortKeysDesc();

        return $result;
    }
}
