
@if (count($data) > 0)

{{-- print_r($data) --}}
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<div class="table-responsive rounded-3" data-simplebar="init" style="max-height:15rem; min-height:10rem;">
    <table class="table table-sm align-middle table-nowrap text-nowrap table-hover font-size-12 mb-0">
        @if( $form_id == 'search-old-asset' )
            <thead class='table-light sticky-top text-center'>
                <tr>
                    <th scope="col" colspan="2">ประเภท</th>
                    <th scope="col">ชนิด</th>
                    <th scope="col">ทะเบียน/เลขที่โฉนด</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
        @endif
        @if( $form_id == 'search-new-cus' )
            <thead class='table-dark sticky-top text-center'>
                <tr>
                    <th scope="col" colspan="2">ข้อมูลลูกค้า</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
        @endif
        <tbody>
            @if( $form_id == 'search-old-asset' )
                @foreach (@$data as $item)
                    <tr>
                        <td class="text-center">
                            @if($item->TypeAsset_Code == "land")
                                <i class="fas fa-map text-primary"></i>
                                <img src="{{ URL::asset('\assets\images\asset\real-estate.png') }}" style="display: none;">
                            @elseif($item->TypeAsset_Code == "car")
                                <i class="fas fa-car text-success"></i>
                                <img src="{{ URL::asset('\assets\images\asset\astCar.png') }}" style="display: none;">
                            @else
                                <i class="fas fa-motorcycle text-info"></i> 
                                <img src="{{ URL::asset('\assets\images\asset\motorbike.png') }}" style="display: none;">
                            @endif
                        </td>
                        <td class="text-start">
                            <div class="d-flex flex-column">
                                <span @class([
                                    'text-primary' => $item->TypeAsset_Code == "land",
                                    'text-success' => $item->TypeAsset_Code == "car",
                                    'text-info' => $item->TypeAsset_Code == "moto",
                                ])>
                                    {{$item->AssetToTypeAsset->Name_TypeAsset}}
                                </span>
                                @if(@$item->TypeAsset_Code == "land")
                                    <span>{{$item->Land_Province}}, {{$item->Land_District}}</span>
                                @else
                                    <span>{{$item->Vehicle_Chassis}}</span>
                                @endif
                            </div>
                        </td>
                        @php
                            if(@$item->TypeAsset_Code == "land"){
                                $licence = @$item->Land_Id;
                                $brand = @$item->DataAssetToLandType->nametype_car;
                            }else{
                                if($item->Vehicle_NewLicense != NULL ){
                                    $licence = @$item->Vehicle_NewLicense;
                                }else{
                                    $licence = @$item->Vehicle_OldLicense;
                                }
                                if(@$item->TypeAsset_Code == "car"){
                                    $brand = @$item->AssetToCarBrand->Brand_car;
                                }else{
                                    $brand = @$item->AssetToMotoBrand->Brand_moto;
                                }
                           }  
                        @endphp
                        <td class="text-center">{{ @$brand }} </td>
                        <td class="text-center">{{ @$licence }} </td>
                        <td>
                            @if(@$item->isBlacklist())
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="ไม่สามารถครอบครองทรัพย์ใหม่ โดยใช้ทรัพย์ที่เป็นแบล็คลิสซ์ได้">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            @elseif(@$item->Status_Asset == 'Inactive')
                                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="tooltip" data-bs-title="ไม่สามารถเลือกทรัพย์นี้ได้ เนื่องจากเลิกใช้แล้ว กรุณาตรวจสอบทรัพย์อื่นที่คล้ายกันอีกครั้ง">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            @elseif(@$item->canTransfer())
                                <button type="button" class="btn btn-success btn-sm" data-assetid="{{@$item->id}}" data-assettype="{{@$item->TypeAsset_Code}}" onclick="tf_selectAssetBtn_on_clicked(this)"
                                @if( @$item->TypeAsset_Code == "land" )
                                    data-title="{{@$item->DataAssetToLandType->nametype_car}}"
                                    data-list1="{{@$item->Land_Id}}"
                                    data-list2="{{@$item->Land_ParcelNumber}}"
                                    data-list3="{{@$item->Land_SheetNumber}}"
                                    data-list4="{{@$item->Land_TambonNumber}}"
                                @else
                                    data-title="{{@$item->AssetToCarType->nametype_car}}"
                                    data-list1="{{@$item->Vehicle_OldLicense}}"
                                    data-list2="{{@$item->Vehicle_NewLicense}}"
                                    data-list3="{{@$item->Vehicle_Chassis}}"
                                    data-list4="{{@$item->Vehicle_Engine}}"
                                @endif>
                                    <i class="fas fa-check"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-title="ไม่สามารถย้ายได้ เนื่องจากมีลูกค้ากำลังถือครองทรัพย์นี้ หรือกำลังรอโอนย้าย กรุณายกเลิกการครอบครองทรัพย์นี้ของลูกค้าคนนั้นก่อน">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            @if( $form_id == 'search-new-cus' )
                @foreach (@$data as $item)
                    <tr>
                        <td>
                            <div>
                                <img class="rounded-circle avatar-xs" src="{{ isset($item->image_cus) ? URL::asset(@$item->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
                            </div>
                        </td>
                        <td class="text-start">
                            <div class="d-flex flex-column">
                                <span class="fw-bold">{{ @$item->Name_Cus }}</span>
                                @if (!empty(@$item->IDCard_cus))
                                    <span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$item->IDCard_cus }}</span>
                                @else
                                    <span class="text-danger">- ไม่มีเลขบัตร -</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if (@$item->Status_Cus == 'active')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">ปกติ</span>
                            @elseif (@$item->Status_Cus == 'cancel')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ยกเลิก</span>
                            @else
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">Blacklist</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" data-cusid="{{@$item->id}}" data-cusidcard="{{@$item->IDCard_cus}}" data-cusphone="{{@$item->Phone_cus}}" data-nameeng="{{@$item->NameEng_cus}}" onclick="tf_selectCusBtn_on_clicked(this)">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@else

    ไม่พบผลการค้นหา

@endif
