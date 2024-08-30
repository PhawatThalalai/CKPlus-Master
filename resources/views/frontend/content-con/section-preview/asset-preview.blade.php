<!-- asset -->
<div class="card p-3 mb-2">
    <div class="row">
        <div class="col-12 pt-4">
            <div class="d-flex">
                <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ข้อมูลทรัพย์ (Asset Detail)</h5>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="scroll-slide">
                <div class="d-flex p-2" id="v-pillsAsset-tab" role="tablist" aria-orientation="vertical">

                    @foreach(@$data->ContractToIndentureAsset2 as $asst)
                    
                    @php
                    if(@$asst->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'car'){
                        $image = "\assets\images\asset\astCar.png";
                    }
                    elseif(@$asst->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'moto'){
                        $image = "\assets\images\asset\motorbike.png";
                    }
                    else {
                        $image = "\assets\images\asset\real-estate.png";
                    }
                   
                    @endphp

                    <div class="card card-hover border border-2 border-primary border-opacity-50 mb-1 me-1 {{ $loop->index == 0 ? 'show active' : ' ' }}" id="tab-{{$asst->id}}" data-bs-toggle="pill" data-bs-target="#v-pills-{{$asst->id}}" role="tab" aria-controls="v-pills-{{$asst->id}}" aria-selected="true" style="max-width:250px; min-width:250px; cursor:pointer;">
                        <div class="py-2 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center mx-3">
                                    <img src="{{ URL::asset($image) }}" class="rounded-circle p-1 border border-2 border-primary border-opacity-50" style="width: 50px;">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <h5 class="font-size-15 mb-1 fw-semibold">{{ @$asst->IndenAssetToDataOwner->OwnershipToAsset->AssetToTypeAsset->Name_TypeAsset }}</h5>
                                    <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i>ข้อมูลทรัพย์ {{$loop->iteration}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-12 mt-2">
            <div class="tab-content" id="v-pillsAsset-tabContent">

            @foreach(@$data->ContractToIndentureAsset2 as $asst)
            <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : ' ' }}" id="v-pillsAsset-{{$asst->id}}" role="tabpanel" aria-labelledby="tab-{{$asst->id}}" tabindex="0">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        <tr>
                            <th>รหัสทรัพย์ :</th>
                            <td class="text-end"> {{ @$asst->IndenAssetToDataOwner->OwnershipToAsset->Code_Asset }}</td>
                            <th>ประเภททรัพย์ :</th>
                            <td class="text-end">{{ @$asst->IndenAssetToDataOwner->OwnershipToAsset->AssetToTypeAsset->Name_TypeAsset }}</td>
                        </tr>
                        <tr>
                            <th>วันที่ครอบครอง :</th>
                            <td class="text-end">{{ @$asst->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedDT }}</td>
                            <th>ระยะเวลา :</th>
                            <td class="text-end">{{ @$asst->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedTime }}</td>
                        </tr>
                        <tr>
                            <th>ทะเบียนเก่า :</th>
                            <td class="text-end">{{ $asst->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense }}</td>
                            <th>ทะเบียนใหม่ :</th>
                            <td class="text-end">{{ $asst->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense }}</td>
                        </tr>
                        <tr>
                            <th>เลขถัง :</th>
                            <td class="text-end">{{ $asst->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis }}</td>
                            <th>เลขเครื่อง :</th>
                            <td class="text-end">{{ $asst->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach

            </div>
        </div>
    </div>
</div>
<!-- endasset -->
