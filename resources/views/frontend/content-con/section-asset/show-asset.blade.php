<style>
    .dataSearch-popover {
    --bs-popover-max-width: 300px;
    --bs-popover-border-color: var(--bs-danger);
    --bs-popover-header-bg: var(--bs-danger);
    --bs-popover-header-color: var(--bs-white);
    --bs-popover-body-padding-x: 1rem;
    --bs-popover-body-padding-y: .5rem;
	}
</style>

<div class="row">
    <div class="col mt-2">
        @if(count($data) != 0)
            <div class="table-responsive">
                <table class="table align-middle table-nowrap text-nowrap table-hover">
                    <thead class="table-light sticky-top text-center">
                        <tr>
                            <th scope="col">ลำดับ</th>
                            {{-- <th scope="col">รหัสทรัพย์</th> --}}
                            <th scope="col">ประเภททรัพย์</th>
                            <th scope="col">ชื่อ - สกุล</th>
                            <th scope="col">ชนิด</th>
                            <th scope="col">ทะเบียน</th>
                            <th scope="col">เข้าระบบ</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (@$data as $item)

                            @php 	
                                $typeAsset = $contract->ContractToTypeLoan->id_rateType	;	
                                $Asset_id = $item->id;
                                @$Data_Asset = $contract->ContractToIndentureAsset2
                                ->filter(function ($e) use ($Asset_id) {
                                    return $e->Asset_id == $Asset_id;
                                });	
                                $statusAsset = ['Active','Transfer','Process','TransferProcess'];
                                $microlist = ['11','12','13','17'];
                                //
                            @endphp
                            @if( count($Data_Asset) == 0 &&$item->OwnershipToAsset->TypeAsset_Code ==  $typeAsset && (in_array($item->State_Ownership, $statusAsset)==true || in_array($contract->CodeLoan_Con,$microlist) == true ))
                                <tr>
                                    <td>{{ @$loop->iteration }}</td>
                                    {{-- <td>{{ @$item->OwnershipToAsset->Code_Asset }}</td> --}}
                                    <td>{{ @$item->OwnershipToAsset->AssetToTypeAsset->Name_TypeAsset }}</td>
                                    <td>{{ @$item->OwnershipToCus->Name_Cus }}</td>
                                    @php
                                         $model = "";
                                        if(@$item->OwnershipToAsset->TypeAsset_Code=='car'){
                                            $license = (@$item->OwnershipToAsset->Vehicle_NewLicense!=NULL && strlen(@$item->OwnershipToAsset->Vehicle_NewLicense)>3)?@$item->OwnershipToAsset->Vehicle_NewLicense:@$item->OwnershipToAsset->Vehicle_OldLicense;
                                            $model = @$item->OwnershipToAsset->AssetToCarModel->Model_car;
                                        }elseif( @$item->OwnershipToAsset->TypeAsset_Code=='moto'){
                                            $license = (@$item->OwnershipToAsset->Vehicle_NewLicense!=NULL && strlen(@$item->OwnershipToAsset->Vehicle_NewLicense))?@$item->OwnershipToAsset->Vehicle_NewLicense:@$item->OwnershipToAsset->Vehicle_OldLicense;
                                            $model = @$item->OwnershipToAsset->AssetToMotoModel->Model_moto;
                                        }elseif(@$item->OwnershipToAsset->TypeAsset_Code=='land'){
                                            $license = @$item->OwnershipToAsset->Land_Id;
                                            $model = @$item->OwnershipToAsset->DataAssetToLandType->nametype_car;
                                        }else{
                                            $license = '';
                                        }
                                    @endphp
                                    <td align="center">{{ @$model }}</td>
                                    <td  align="center">{{ @$license }}</td>
                                    <td align="center">{{ @$item->OwnershipToAsset->created_at }}</td>
                                    @php
                                        if(in_array($item->State_Ownership, $statusAsset)==true || in_array($contract->CodeLoan_Con,$microlist) == true ){
                                            $disabled = '';
                                            $txterr = '';
                                            $editCus = 'hidden';
                                        }else{
                                            $disabled = 'disabled';
                                            $editCus = '';
                                            $txterr = '';
                                        }   
                                    @endphp
                                    <td class="d-flex">
                                        <a {{$editCus}} type="button" class="font-size-20" href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$item->DataCus_id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft me-1"></i></a>
                                        <span
                                        data-bs-toggle="{{ $disabled == 'disabled' ? 'popover' : '' }}" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ไม่สามารถเลือกได้ ! </p>" data-bs-custom-class="dataSearch-popover" data-bs-content="
                                        <div class='row'>
                                            <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> กรุณาอัพเดทข้อมูลทรัพย์หน้าลูกค้า <br> ก่อนทำการเลือกใช้งาน</div>
                                        </div>" >

                                        <a type="button" class="font-size-20 addAsset" idasst="{{@$item->id}}" {{$disabled}} style="{{ $disabled == 'disabled' ? 'pointer-events:none;' : '' }}"><i class="bx bx-check-square hover-up {{ $disabled == 'disabled' ? 'text-secondary' : 'text-success' }} bg-soft"></i></a>
                                        <a type="button" class="font-size-20 iconLoading" idasst="{{@$item->id}}" style="display: none;"><i class="bx bxs-hourglass-top text-secondary bg-soft bx-tada"></i></a>

                                        </span>

                                    </td>
                                </tr>
                            @else    
                            ....
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else 
            <div class="row mb-3">
                <div class="col text-center">
                    <h4 class="text-warning">ไม่พบข้อมูลทรัพย์ !</h4>
                    <p class="text-muted font-size-14 mb-4">ไม่พบข้อมูลทรัพย์ โปรดตรวจสอบว่าได้มีการเพิ่มทรัพย์ของลูกค้าคนนี้ในระบบแล้วใน <span class="text-primary">ฐานข้อมูลลูกค้า</span></p>
                    <a href="{{ route('cus.index') }}?page={{'profile-cus'}}&id={{@$DataCus_id}}" target="_blank" class="btn btn-success btn-rounded w-lg w-75 waves-effect waves-ligh" >โปรไฟล์</a>
                </div>
            </div>
        @endif

    </div>
</div>

@include('frontend.content-con.section-asset.script-asset')

<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover focus'
	})
</script>


