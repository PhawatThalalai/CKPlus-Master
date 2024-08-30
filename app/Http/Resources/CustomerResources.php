<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResources extends JsonResource
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
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'customerId' => encryptredVariable($this->id, $this->R1, $this->R2),
            'profile' => [
                'prefix' => $this->Prefix,
                'firstname' => $this->Firstname_Cus,
                'lastname' => $this->Surname_Cus,
                'province' => optional($this->DataCusToDataCusAddsMany->whereIn('Type_Adds', ['ADR-0001', 'ADR-0002'])->first())->houseProvince_Adds,
            ]
        ];

    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('https://www.google.com'),
        ];
    }
}
