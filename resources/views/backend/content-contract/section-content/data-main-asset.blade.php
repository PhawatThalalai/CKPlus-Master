<!-- Add Scrollbar -->
<div class="overflow-auto d-none" style="height: 29rem">
    @if(@$contract->PatchToPact->ContractToIndenAsst != NULL)
        @foreach(@$contract->PatchToPact->ContractToIndenAsst as $value)
            @component('components.content-user.card-asset-b-end')
                @slot('data', [
                    'TYPECON' => $value->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code,
                    'numGuaran' => $loop->iteration,
                    'Brand' => @$value->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car,
                    'GroupCar' => @$value->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarGroup->Group_car,
                    'Model' => @$value->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarModel->Model_car,
                    'TypeCar' => @$value->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarType->nametype_car,
                    'ColorCar' => $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Color,
                    'YearCar' => @$value->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarYear->Year_car,

                    'RegisNumber' => ( $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense == NULL ) ? $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense : $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense,
                    'ChasNumber' => $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis,
                    'MachNumber' => $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine,
                    'Mileage' => $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Miles,
                    'CC' => $value->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_CC,
                    'RegisStatus' => '',

                    'UserBranch' => $value->IndenAssetToDataOwner->OwnershipToAsset->UserBranch,
                    'UserInsert' => $value->IndenAssetToDataOwner->OwnershipToAsset->UserInsert,
                    'created_at' => $value->IndenAssetToDataOwner->OwnershipToAsset->created_at,


                    'OccupiedDT' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedDT,
                    'InsuranceState' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceState,
                    'InsuranceClass' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceClass,
                    'InsuranceDT' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceDT,
                    'PurposeType' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->PurposeType,
                    'PossessionOrder' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->PossessionOrder,
                    'History_18' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->History_18,
                    'OccupiedTime' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedTime,
                    'phoneGuar' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->phoneGuar,
                    'phoneGuar' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->phoneGuar,
                    'InsuranceActDT' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceActDT,
                    'PossessionState_Code' => @$value->IndenAssetToDataOwner->OwnershipToAssetDetail->AssetToTypePoss->Name_TypePoss,
                    'History_16' => $value->IndenAssetToDataOwner->OwnershipToAssetDetail->History_16,
                    'InsuranceCompany_Id' => @$value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceCompany_Id,
                    'PolicyNumber' => @$value->IndenAssetToDataOwner->OwnershipToAssetDetail->PolicyNumber,
                    'InsuranceRegisterDT' => @$value->IndenAssetToDataOwner->OwnershipToAssetDetail->InsuranceRegisterDT,

                    'Price_Asset' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Price_Asset,
                    'Land_Type' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Type,
                    'Land_Id' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Id,
                    'Land_ParcelNumber' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_ParcelNumber,
                    'Land_SheetNumber' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_SheetNumber,
                    'Land_TambonNumber' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_TambonNumber,
                    'Land_Book' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Book,
                    'Land_BookPage' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_BookPage,
                    'Land_SizeRai' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeRai,
                    'Land_SizeNgan' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeNgan,
                    'Land_SizeSquareWa' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeSquareWa,
                    'Land_Zone' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Zone,
                    'Land_Province' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Province,
                    'Land_District' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_District,
                    'Land_Tambon' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Tambon,
                    'Land_PostalCode' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_PostalCode,
                    'Land_Coordinates' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Coordinates,
                    'Land_Detail' => @$value->IndenAssetToDataOwner->OwnershipToAsset->Land_Detail
                ])
            @endcomponent
        @endforeach
    @endif
</div>
<div style="overflow-y: auto; overflow-x: hidden; height: 29rem">
    <div class="row p-3">
        @if(@$contract->PatchToPact->ContractToIndenAsst != NULL)
            @foreach(@$contract->PatchToPact->ContractToIndenAsst as $value)
                <div class="col-md-6">
                    @php
                        $_dataOwnership = $value->IndenAssetToDataOwner;

                        $_dataAssetCard = $_dataOwnership->OwnershipToAsset;
                        $_dataAssetDeatil = $_dataOwnership->OwnershipToAssetDetail;
                    @endphp
                    @component('components.content-asset.card-asset-info-cus')
                        @slot( 'index', $loop->iteration,  )
                        @slot( 'page', 'contract-b-end')
                        @slot( 'data', [
                        'assetId' => $_dataAssetCard->id,

                        'ownershipId' => $_dataOwnership->id,
                        'ownershipState' => $_dataOwnership->State_Ownership,
                        'ownershipStateName' => $_dataOwnership->StatusOwnership->name_th,
                        'cusId' => $_dataOwnership->DataCus_Id,

                        'assetCode' => $_dataAssetCard->Code_Asset,
                        'assetState' => $_dataAssetCard->Status_Asset,

                        'typeAssetCode' => $_dataAssetCard->TypeAsset_Code,
                        'typeAssetName' => $_dataAssetCard->AssetToTypeAsset->Name_TypeAsset,

                        'assetYear' => (
                            $_dataAssetCard->TypeAsset_Code == "car" ?
                            @$_dataAssetCard->AssetToCarYear->Year_car :
                            (
                                $_dataAssetCard->TypeAsset_Code == "moto" ?
                                @$_dataAssetCard->AssetToMotoYear->Year_moto : ''
                            )
                        ),
                        'assetBrand' => (
                            $_dataAssetCard->TypeAsset_Code == "car" ?
                            @$_dataAssetCard->AssetToCarBrand->Brand_car :
                            (
                                $_dataAssetCard->TypeAsset_Code == "moto" ?
                                @$_dataAssetCard->AssetToMotoBrand->Brand_moto : ''
                            )
                        ),

                        'assetMainType' => (
                            $_dataAssetCard->TypeAsset_Code == "car" || $_dataAssetCard->TypeAsset_Code == "moto" ?
                            $_dataAssetCard->AssetToCarType->nametype_car :
                            (
                                $_dataAssetCard->TypeAsset_Code == "land" ?
                                $_dataAssetCard->DataAssetToLandType->nametype_car : '-'
                            )
                        ),

                        'assetPrice' => $_dataAssetCard->Price_Asset,

                        'assetOccupiedDT' => @$_dataAssetDeatil->OccupiedDT,
                        'assetOccupiedTime' => @$_dataAssetDeatil->OccupiedTime,

                        // ข้อมูลเฉพาะของรถ
                        'assetOldLicense' => $_dataAssetCard->Vehicle_OldLicense,
                        'assetNewLicense' => (
                            $_dataAssetCard->Vehicle_NewLicense != null ?
                            $_dataAssetCard->Vehicle_NewLicense : '-'
                        ),
                        'assetChassis' => $_dataAssetCard->Vehicle_Chassis,
                        'assetEngine' => $_dataAssetCard->Vehicle_Engine,

                        // ข้อมูลเฉพาะของที่ดิน
                        'assetLandId' => $_dataAssetCard->Land_Id,
                        'assetParcelNumber' => $_dataAssetCard->Land_ParcelNumber,
                        'assetSheetNumber' => $_dataAssetCard->Land_SheetNumber,
                        'assetTambonNumber' => $_dataAssetCard->Land_TambonNumber,

                        'assetUserInsert' => $_dataAssetCard->getUserInsert(),
                        'assetLastUpdate' => @$_dataAssetCard->getLastUpdate(),
                        ])
                        @if( $_dataAssetCard->TypeAsset_Code == "car" )
                            @if( @$_dataAssetDeatil == NULL)
                                @slot( 'InsuranceCar', [
                                    'InsEXP' => false,
                                    'InsWarning' => false,
                                    'InsActEXP' => false,
                                    'InsActWarning' => false,
                                    'InsRegisterEXP' => false,
                                    'InsRegisterWarning' => false,
                                ])
                            @else
                                @slot( 'InsuranceCar', [
                                    'InsEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', false),
                                    'InsWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', true),

                                    'InsActEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', false),
                                    'InsActWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', true),

                                    'InsRegisterEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', false),
                                    'InsRegisterWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', true),
                                ])
                            @endif
                        @endif
                    @endcomponent
                </div>
            @endforeach
        @endif
    </div>
</div>
