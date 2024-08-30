<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResources extends JsonResource
{
    protected $QR;
    protected $countDatalist;

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

        $this->countDatalist += ($resource->EXP_AMT != null) + ($resource->EXP_INTAMT != null) + ($resource->EXP_FOLLOW != null);
        $this->QR = '|' . $resource->Company_Id . sprintf("%02d", $resource->Company_Branch) . chr(13) . $resource->invoiceNo . chr(13) . '006' . chr(13) . 0;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $datalist = [];
        if ($this->EXP_AMT != null) {
            $datalist[] = [
                'description' => 'ค่างวด งวดที่ ' . (int) $this->loanPeriod ,
                'amountInBaht' => encryptredVariable((double) $this->DUEAMT, $this->R1, $this->R2),
            ];
        }

        if ($this->EXP_AMT != null) {
            $datalist[] = [
                'description' => 'ค้างชำระงวดที่ ' . (int) $this->EXP_FRM . ' - ' . (int) $this->EXP_TO,
                'amountInBaht' => encryptredVariable((double) $this->EXP_AMT, $this->R1, $this->R2),
            ];
        }

        if ($this->EXP_INTAMT != null) {
            $datalist[] = [
                'description' => 'เบี้ยปรับล่าช้า',
                'amountInBaht' => encryptredVariable((double) $this->EXP_INTAMT, $this->R1, $this->R2),
            ];
        }

        if ($this->EXP_FOLLOW != null) {
            $datalist[] = [
                'description' => 'ค่าใช่จ่ายในการถทวงถามหนี้',
                'amountInBaht' => encryptredVariable((double) $this->EXP_FOLLOW, $this->R1, $this->R2),
            ];
        }

        return [
            'invoiceId' => (int) $this->invoiceId,
            'invoiceDate' => $this->invoiceDate,
            'invoiceNo' => $this->invoiceNo,
            'customerFullName' => $this->customerFullName,
            'customerAddr' => $this->customerAddr,
            'type' => [
                'typeId' => $this->typeId,
                'typeName' => $this->typeName,
                'typeModel' => $this->typeModel,
                'typeLicense' => $this->typeLicense,
                'typeProvince' => $this->typeProvince
            ],
            'loanPeriod' => $this->loanPeriod,
            'paidPerPeriod' => encryptredVariable((double) $this->paidPerPeriod, $this->R1, $this->R2),
            'paymentDueDate' => $this->paymentDueDate,
            'datalist' => $datalist,
            'totalAmount' => encryptredVariable((double) $this->totalAmount, $this->R1, $this->R2),
            'totalAmountText' => IntconvertThai((double) $this->totalAmount),
            'ref1' => encryptredVariable($this->ref1, $this->R1, $this->R2),
            'ref2' => encryptredVariable($this->ref2, $this->R1, $this->R2),
            'qrCode' => encryptredVariable($this->QR, $this->R1, $this->R2),
            'chookiatAddr' => encryptredVariable($this->Company_Addr, $this->R1, $this->R2),
            'chookiatPhone' => encryptredVariable($this->Company_Tel, $this->R1, $this->R2),
            'chookiatTaxNo' => encryptredVariable($this->Company_Id, $this->R1, $this->R2),
            'chookiatBank' => null,
            'chookiatBranch' => encryptredVariable($this->Company_Branch, $this->R1, $this->R2),
            'chookiatName' => encryptredVariable($this->Company_Name, $this->R1, $this->R2),
        ];
    }
}
