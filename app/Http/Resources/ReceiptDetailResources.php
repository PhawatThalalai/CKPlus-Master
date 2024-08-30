<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptDetailResources extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  mixed  $R1
     * @param  mixed  $R2
     * @param  mixed  $QR
     * @param  mixed  $countDatalist
     * @return void
     */


    public function __construct($resource, $R1, $R2)
    {
        parent::__construct($resource);
        $this->R1 = $R1;
        $this->R2 = $R2;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'receiptId' => $this->receiptId,
            'receiptDate' => $this->receiptDate,
            'receiptAmount' => encryptredVariable($this->receiptAmount, $this->R1, $this->R2),
            'chookiatTaxNo' => encryptredVariable($this->chookiatTaxNo, $this->R1, $this->R2),
            'receiptNo' => encryptredVariable($this->receiptNo, $this->R1, $this->R2),
            'loanNo' => encryptredVariable($this->loanNo, $this->R1, $this->R2),
            'customerFullName' => $this->customerFullName,
            'customerAddr' => $this->customerAddr,
            'amountPrincipal' => encryptredVariable($this->totalAmount, $this->R1, $this->R2),
            'amountInterestOverdue' => encryptredVariable($this->amountInterestOverdue, $this->R1, $this->R2),
            'amountFollowUp' => encryptredVariable($this->amountFollowUp, $this->R1, $this->R2),
            'totalAmount' => encryptredVariable($this->totalAmount, $this->R1, $this->R2),
            'totalAmountText' => IntconvertThai($this->totalAmount),
            'totalBalance' => encryptredVariable(($this->totprc - $this->sumPay), $this->R1, $this->R2),
            'discount' => ($this->discount == 0) ? null : encryptredVariable($this->discount, $this->R1, $this->R2),
            'totalPayAmount' => encryptredVariable($this->totalPayAmount, $this->R1, $this->R2),
            'PayAmount' => $this->PayAmount,
            'totalBalanceTxt' => encryptredVariable($this->totalBalanceTxt, $this->R1, $this->R2),
            'discountInterestOverdue' => ($this->discountInterestOverdue == 0) ? null : encryptredVariable($this->discountInterestOverdue, $this->R1, $this->R2),
            'discountFollowUp' => ($this->discountFollowUp == 0) ? null : encryptredVariable($this->discountFollowUp, $this->R1, $this->R2),
            'chookiatAddr' => $this->chookiatAddr,
            'chookiatPhone' => $this->chookiatPhone,
            'chookiatName' => $this->chookiatName,
            'remarkTxt' => $this->remarkTxt,
        ];
    }
}
