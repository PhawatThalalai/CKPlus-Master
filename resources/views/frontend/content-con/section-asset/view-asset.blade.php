@if(@$data != NULL && count(@$data) != 0)
    <div class="ms-4">
        <style>
            .scroll-slide::-webkit-scrollbar
            {
                width: 5px;
                height : 7px;
                background-color: #F5F5F5;
            }
            .scroll-slide::-webkit-scrollbar-thumb
            {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                background-color: #ddd;
            }
            .resize{
                    transform-origin: 100% 50%;
            }

        </style>

        <!-- hidden value -->
        <input type="hidden" value="{{ @$data['PactCon_id'] }}" id="PactCon_id">
        <input type="hidden" value="{{ @$data['DataCus_id'] }}" id="DataCus_id">
        <input type="hidden" value="{{ @$data['DataTag_id'] }}" id="DataTag_id">

        <div class="row" >
            <div class="col-12">
                <div>
                    <p id="demo" style="display:none;"></p>
                    <span class="showScroll" style="display:none;">
                        <!-- btn small -->
                        @component('components.content-user-about.btnAdd-small')
                            @slot('data', [
                                'datalink'=> ''
                            ]);
                        @endcomponent
                    </span>
                
                    <div style="cursor: pointer; overflow: auto;  height: auto;" onscroll="PositionScroll('scroll-slide-1')" id="scroll-slide-1" class="scroll-slide mx-4 my-2">
                        <div class="d-flex mt-2">
                        
                            <div class="resize d-flex align-items-center">
                                <div class="card rounded-4 bg-primary text-center bg-soft me-2 card-hover add-Asset" style = "min-width:10rem; max-width:10rem;  min-height:18rem; max-height:18rem; justify-content:center;" title="เพิ่มข้อมูลทรัพย์">
                                    <div class="row">
                                        <div class="col">
                                            <img src="{{ URL::asset('\assets\images\plus.png') }}" alt="เพิ่ม" style="width: 70%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="content-asset d-flex">
                                @foreach ($data as $value)
                                    <div class="h-100 " style="min-width: 30rem; max-width: 30rem">
                                        {{-- Asset Card --}}
                                        @php
                                            $_dataAssetCard = $value->IndenAssetToDataOwner;
                                        
                                        @endphp
                                        @component('components.content-asset.card-asset-info-cus')
                                            @slot( 'index', $loop->iteration )
                                            @slot( 'page', 'contract-f-end')
                                            @slot( 'data', [                                      
                                            'ownershipId'=>$_dataAssetCard->id,
                                            'assetId' => $_dataAssetCard->OwnershipToAsset->id,
                                            'assetCode' => $_dataAssetCard->OwnershipToAsset->Code_Asset,
                                            'assetState' => $_dataAssetCard->OwnershipToAsset->Status_Asset,

                                            'typeAssetCode' => $_dataAssetCard->OwnershipToAsset->TypeAsset_Code,
                                            'typeAssetName' => $_dataAssetCard->OwnershipToAsset->AssetToTypeAsset->Name_TypeAsset,

                                            'assetYear' => (
                                                $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "car" ?
                                                @$_dataAssetCard->OwnershipToAsset->AssetToCarYear->Year_car :
                                                (
                                                    $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "moto" ?
                                                    @$_dataAssetCard->OwnershipToAsset->AssetToMotoYear->Year_moto : ''
                                                )
                                            ),
                                            'assetBrand' => (
                                                $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "car" ?
                                                $_dataAssetCard->OwnershipToAsset->AssetToCarBrand->Brand_car :
                                                (
                                                    $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "moto" ?
                                                    $_dataAssetCard->OwnershipToAsset->AssetToMotoBrand->Brand_moto : ''
                                                )
                                            ),

                                            'assetMainType' => (
                                                $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "car" || $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "moto" ?
                                                $_dataAssetCard->OwnershipToAsset->AssetToCarType->nametype_car :
                                                (
                                                    $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "land" ?
                                                    $_dataAssetCard->OwnershipToAsset->DataAssetToLandType->nametype_car : '-'
                                                )
                                            ),

                                            'assetPrice' => $_dataAssetCard->OwnershipToAsset->Price_Asset,

                                            'assetOccupiedDT' => @$_dataAssetCard->OwnershipToAssetDetail->OccupiedDT,
                                            'assetOccupiedTime' => @$_dataAssetCard->OwnershipToAssetDetail->OccupiedTime,

                                            // ข้อมูลเฉพาะของรถ
                                            'assetOldLicense' => $_dataAssetCard->OwnershipToAsset->Vehicle_OldLicense,
                                            'assetNewLicense' => (
                                                $_dataAssetCard->OwnershipToAsset->Vehicle_NewLicense != null ?
                                                $_dataAssetCard->OwnershipToAsset->Vehicle_NewLicense : '-'
                                            ),
                                            'assetChassis' => $_dataAssetCard->OwnershipToAsset->Vehicle_Chassis,
                                            'assetEngine' => $_dataAssetCard->OwnershipToAsset->Vehicle_Engine,

                                            // ข้อมูลเฉพาะของที่ดิน
                                            'assetLandId' => $_dataAssetCard->OwnershipToAsset->Land_Id,
                                            'assetParcelNumber' => $_dataAssetCard->OwnershipToAsset->Land_ParcelNumber,
                                            'assetSheetNumber' => $_dataAssetCard->OwnershipToAsset->Land_SheetNumber,
                                            'assetTambonNumber' => $_dataAssetCard->OwnershipToAsset->Land_TambonNumber,

                                            'assetUserInsert' => $_dataAssetCard->OwnershipToAsset->getUserInsert(),
                                            'assetLastUpdate' => @$_dataAssetCard->OwnershipToAsset->getLastUpdate(),
                                            ])
                                            @if( $_dataAssetCard->OwnershipToAsset->TypeAsset_Code == "car" )
                                            @slot( 'InsuranceCar', [
                                                'InsEXP' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceDT', false),
                                                'InsWarning' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceDT', true),

                                                'InsActEXP' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceActDT', false),
                                                'InsActWarning' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceActDT', true),

                                                'InsRegisterEXP' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceRegisterDT', false),
                                                'InsRegisterWarning' => $_dataAssetCard->OwnershipToAssetDetail->CheckExpired('InsuranceRegisterDT', true),
                                            ])
                                            @endif
                                        @endcomponent
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row" >
        <div class="col text-center" style = " min-height:20rem; max-height:20rem;">
            @component('components.content-empty.view-empty')
                @slot('btn_icon')
                <i class="bx bx-search-alt-2"></i>
                @endslot
                @slot('data', [
                // 'id' => @$item->id,
                'headtitle' => 'ยังไม่มีทรัพย์ในสัญญานี้ !',
                'title' => 'สามารถเพิ่มทรัพย์ได้ที่นี่',
                'title_btn' => 'เพิ่มทรัพย์',
                'name_btn' => 'add-Asset',
                ])
            @endcomponent
        </div>
    </div>
@endif
@include('components.content-search.section-frontend.data-searchAsst',[
            'page_type' => 'frontend',
            'typeSreach' => 'selectAsset',
            'PactCon_id' => @$data[0]->PactCon_id,
            'DataCus_id' => @$data[0]->DataCus_id,
])

@include('frontend\content-con\section-asset\script-asset')

{{-- กดเพิ่มทรัพย์ --}}
<script>
    $(".add-Asset").click(function() {

        $('.content-search').empty();
        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('search') }}",
            method: "post",
            data: {
                DataCus_id: sessionStorage.getItem('DataCus_id') ,
                PactCon_id: sessionStorage.getItem('PactCon_id'),
                typeSr: 'selectAsset',
                page_type: 'frontend',
                _token: '{{ @csrf_token() }}',
            },
            success: function(result) {
                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                $('.modal-search-asst').modal('show');
                $('.modal-search-asst .modal-dialog .content-search').html(result.html);
            }
        })
    })
</script>






