<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailResources extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  mixed  $R1
     * @param  mixed  $R2
     * @param  mixed  $amount
     * @param  mixed  $QR
     * @return void
     */

    public function __construct($resource, $R1, $R2, $amount)
    {
        parent::__construct($resource);
        $this->R1 = $R1;
        $this->R2 = $R2;
        $this->amount = $amount;
        $this->QR = '|' . $resource->Company_Id . sprintf("%02d", $resource->Company_Branch) . chr(13) . $resource->ref1 . chr(13) . $resource->ref2 . chr(13) .  $amount;
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
            'ref1' => encryptredVariable($this->ref1, $this->R1, $this->R2),
            'ref2' => encryptredVariable($this->ref2, $this->R1, $this->R2),
            'amount' => encryptredVariable((double) $this->amount, $this->R1, $this->R2),
            'qrcodePayment' => encryptredVariable($this->QR, $this->R1, $this->R2),
        ];
    }
}
