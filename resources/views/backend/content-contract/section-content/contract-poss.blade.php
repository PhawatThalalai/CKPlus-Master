<div class="card">
    <div class="card-body">
        <p class="fw-semibold">สัญญาที่ครอบครอง (Contract Possession)
            <span class="badge rounded-pill text-bg-danger">{{ count(@$data->DataCusToContracts) }} รายการ</span>
        </p>

        @if(count(@$data->DataCusToContracts) != 0)
            <div class="d-flex py-2 scroll" style="overflow-x: scroll;">
                @foreach (@$data->DataCusToContracts->reverse() as $item )
                @if($item->Status_Con != 'cancel')
                    @component('components.content-contract.section-cardCon.Card-Possession')
                        @slot('data', [
                            'img' => @$item->PayeetoCus->image_cus,
                            'id' => @$item->id,
                            'name-index' => @$item->Contract_Con, //ชื่อ index
                            'title-left' => 'ประเภทสัญญา', // หัวข้อการ์ดฝั่งซ้าย
                            'Name_Cus' => @$item->ContractToTypeLoan->Loan_Name,
                            'data-left' => @$item->PayeetoCus->Nickname_cus,
                            'title-right' => 'เบอร์ติดต่อ',
                            'data-right' => @$item->PayeetoCus->Phone_cus,
                            'content-head' => 'ข้อมูลสัญญา (Contract Details)',
                            'content-1' => 'วันทำสัญญา',
                            'data-1' => @$item->Date_con,
                            'content-2' => 'สาขา',
                            'data-2' => @$item->ContractToBranch->Name_Branch,
                            'content-3' => 'Credo Code',
                            'data-3' => @$item->ContractToDataCusTags->Credo_Code,
                            'content-4' => 'ลิงก์สัญญา',
                            'data-4' => @$item->LinkUpload_Con,
                            'content-5' => 'ลิงก์ลงพื้นที่',
                            'data-5' => @$item->linkChecker,
                            'UserInsert' => @$item->PayeetoUser->name,
                            'LastUpdate' => @$item->updated_at,
                            'StatusCon' => @$item->StatusApp_Con,
                            'Status_Con' => @$item->Status_Con,
                            'TOTPRC' => @$item->ContractToTypeLoan->Loan_Com == 1 ? @$item->ContractToConPSL->TOTPRC : @$item->ContractToConHP->TOTPRC,
                            'SMPAY' => @$item->ContractToTypeLoan->Loan_Com == 1 ? @$item->ContractToConPSL->SMPAY : @$item->ContractToConHP->SMPAY,

                        ])
                    @endcomponent
                    @endif
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col text-center">
                    <img id="ImageBrok" src="{{ asset('/assets/images/empty-cart.png') }}" style="min-width: 8rem;height: 8rem;" class="img-thumbnail rounded-circle hover-up mb-1 boreder-img">
                    <p class="text-danger fw-semibold">ไม่มีข้อมูลสัญญาที่ครอบครอง !</p>
                </div>
            </div>
        @endif


        <p class="fw-semibold mt-2">สัญญาที่เป็นผู้ค้ำ (Contract Guarantor)
            <span class="badge rounded-pill text-bg-danger">{{ count(@$data->DataCusToContractsGuarantor) }} รายการ</span>

        </p>
        @if(count(@$data->DataCusToContractsGuarantor) != 0 )
            <div class="d-flex py-2 scroll" style="overflow-x: scroll;">
                @foreach (@$data->DataCusToContractsGuarantor->reverse() as $item )
                {{-- @for ($i=0 ; $i<10 ; $i++) --}}
                    @component('components.content-contract.section-cardCon.Card-Possession')
                        @slot('data', [
                            'img' => @$item->PayeetoCus->image_cus,
                            'id' => @$item->id,
                            'name-index' => @$item->GuarantorToContract->Contract_Con, //ชื่อ index
                            'title-left' => 'ประเภทสัญญา', // หัวข้อการ์ดฝั่งซ้าย
                            'content-head' => 'ข้อมูลสัญญา (Contract Details)',
                            'content-1' => 'วันทำสัญญา',
                            'data-1' => @$item->GuarantorToContract->Date_con,
                            'content-2' => 'สาขา',
                            'data-2' => @$item->GuarantorToContract->ContractToBranch->Name_Branch,
                            'content-3' => 'Credo Code',
                            'data-3' => @$item->GuarantorToContract->ContractToDataCusTags->Credo_Code,
                            'content-4' => 'ลิงก์สัญญา',
                            'data-4' => @$item->GuarantorToContract->LinkUpload_Con,
                            'content-5' => 'ลิงก์ลงพื้นที่',
                            'data-5' => @$item->GuarantorToContract->linkChecker,
                            'UserInsert' => @$item->PayeetoUser->name,
                            'LastUpdate' => @$item->updated_at,
                            'StatusCon' => @$item->StatusApp_Con,
                            'Status_Con' => @$item->Status_Con,
                            'TOTPRC' => @$contract->TOTPRC,
                            'SMPAY' => @$contract->SMPAY,
                        ])
                    @endcomponent
                {{-- @endfor --}}
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col text-center">
                    <img id="ImageBrok" src="{{ asset('/assets/images/empty-cart.png') }}" style="min-width: 8rem;height: 8rem;" class="img-thumbnail rounded-circle hover-up mb-1 boreder-img">
                    <p class="text-danger fw-semibold">ไม่มีข้อมูลการค้ำ !</p>
                </div>
            </div>
        @endif

        @if(@$data->DataCusToBroker!=NULL)
        <p class="fw-semibold mt-2">สัญญาที่เป็นผู้แนะนำ (Contract Brokers)
            <span class="badge rounded-pill text-bg-danger">{{ count(@$data->DataCusToConBrokerCount) }} รายการ</span>

        </p>
        @if(count(@$data->DataCusToContractsBroker) != 0  )
            <div class="d-flex py-2 scroll" style="overflow-x: scroll;">
                @foreach (@$data->DataCusToContractsBroker->reverse() as $item )
                {{-- @for ($i=0 ; $i<10 ; $i++) --}}
                    @component('components.content-contract.section-cardCon.Card-Possession')
                        @slot('data', [
                            'img' => @$item->BrokertoCon->ContractToCus->image_cus,
                            'id' => @$item->BrokertoCon->id,
                            'name-index' => @$item->BrokertoCon->Contract_Con, //ชื่อ index
                            'title-left' => 'ประเภทสัญญา', // หัวข้อการ์ดฝั่งซ้าย
                            'content-head' => 'ข้อมูลสัญญา (Contract Details)',
                            'content-1' => 'วันทำสัญญา',
                            'data-1' => @$item->BrokertoCon->Date_con,
                            'content-2' => 'สาขา',
                            'data-2' => @$item->BrokertoCon->ContractToBranch->Name_Branch,
                            'content-3' => 'Credo Code',
                            'data-3' => @$item->BrokertoCon->ContractToDataCusTags->Credo_Code,
                            'content-4' => 'ลิงก์สัญญา',
                            'data-4' => @$item->BrokertoCon->LinkUpload_Con,
                            'content-5' => 'ลิงก์ลงพื้นที่',
                            'data-5' => @$item->BrokertoCon->linkChecker,
                            'UserInsert' => @$item->BrokertoUser->name,
                            'LastUpdate' => @$item->updated_at,
                            'StatusCon' => @$item->StatusApp_Con,
                            'Status_Con' => @$item->Status_Con,
                        ])
                    @endcomponent
                {{-- @endfor --}}
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col text-center">
                    <img id="ImageBrok" src="{{ asset('/assets/images/empty-cart.png') }}" style="min-width: 8rem;height: 8rem;" class="img-thumbnail rounded-circle hover-up mb-1 boreder-img">
                    <p class="text-danger fw-semibold">ไม่มีข้อมูลนายหน้า !</p>
                </div>
            </div>
        @endif
        @endif
    </div>
    <div class="card-footer">
        ...
    </div>
</div>


{{-- mouse scroll-slide --}}
<script>
    document.querySelector('.scroll').addEventListener('wheel', (e) => {
        e.preventDefault();
        const delta = e.deltaY || e.detail || e.wheelDelta;
        document.querySelector('.scroll').scrollLeft += delta;
    });
</script>
