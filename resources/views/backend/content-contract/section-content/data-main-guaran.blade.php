@if( @count(@$contract->PatchToPact->ContractToGuarantor) !== 0 )
@foreach(@$contract->PatchToPact->ContractToGuarantor as $value)
    @component('components.content-user.card-guarantor-b-end')
        @slot('data', [
            'numGuaran' =>  $loop->iteration, //ผู้ค้ำคนที่
            'nameGuaran' => $value->GuarantorToGuarantorCus->Name_Cus,
            'nickname' => $value->GuarantorToGuarantorCus->Nickname_cus,
            'cardIdGuar' => textFormat($value->GuarantorToGuarantorCus->IDCard_cus),
            'phoneGuar' => formatPhone($value->GuarantorToGuarantorCus->Phone_cus),
            'Code_Cus' => $value->GuarantorToGuarantorCus->Code_Cus,
            'TypeRelation_Cus' => $value->GuarantorToTypeRelation->Name_Rela,

            'Birthday_cus' => $value->GuarantorToGuarantorCus->Birthday_cus,
            'Namechange_cus' => $value->GuarantorToGuarantorCus->Namechange_cus,
            'TypeSecurities_Guar' => $value->GuarantorToTypeSecurities->Name_Secur,

            'CareerMany' => $value->GuarantorToGuarantorCus->DataCusToDataCusCareerMany,
            'AddsMany' => $value->GuarantorToGuarantorCus->DataCusToDataCusAddsMany,
            'asstMany' => $value->GuarantorToGuarantorCus->DataCusToDataCusAssetsMany,

        ])
    @endcomponent
@endforeach
@else
<div class="row" style="margin-top : 3rem; margin-bottom : 3rem;">
    <div class="col text-center m-auto">
        <img src="{{ URL::asset('\assets\images\out-of-stock.png') }}" style="width:15%;">
        <h5 class="text-danger fw-semibold mt-2">สัญญานี้ไม่มีผู้ค้ำประกัน</h5>
    </div>
</div>
@endif
