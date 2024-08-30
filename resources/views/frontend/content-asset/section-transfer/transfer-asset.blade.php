<style>
    [data-resultfor="search-old-asset"] .feedback-search {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url("{{ asset('assets/images/crypto/features-img/img-1.png') }}");
        background-repeat: no-repeat;
        background-position: center left -4rem;
        background-size: contain;
    }

    [data-resultfor="search-new-cus"] .feedback-search {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url("{{ asset('assets/images/career1.png') }}");
        background-repeat: no-repeat;
        background-position: center right -4rem;
        background-size: contain;
    }

    [data-resultfor="search-old-asset"] .feedback-search:before, [data-resultfor="search-new-cus"] .feedback-search:before {
        content: "";
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        background-color: rgba(var(--bs-light-rgb), 0.65);
    }

    input:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
    }

</style>

<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<div class="modal-content">
	
	<div class="modal-body">
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="" class="avatar-sm">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">{{ @$title }}</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">{{ @$subtitle }}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close btn-disabled btn_closeTransfer" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

        @if( !empty($assetItem) && $assetItem->canTransfer() == false )

            <!-- ไม่สามารถย้ายทรัพย์ได้ แสดง Error + รายการครอบครองทั้งหมด -->
            <div class="card-body p-4 m-4">
                <div class="text-center">
                    <div class="avatar-md mx-auto mb-4">
                        <div class="avatar-title bg-light rounded-circle text-primary h1">
                            <img src="{{ asset('assets/images/gif/error.gif') }}" alt="report" class="avatar-sm" style="width:80px;height:80px">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <h4 class="text-warning">ขออภัย! ไม่สามารถย้ายทรัพย์นี้ได้</h4>
                            <p class="text-muted font-size-14 mb-4">เนื่องจากมีลูกค้ากำลังถือครองทรัพย์นี้ หรือกำลังรอโอนย้าย กรุณายกเลิกการครอบครองทรัพย์นี้ของลูกค้าท่านนั้นก่อน</p>
                        </div>
                    </div>

                    <table class="table table-sm table-striped">
                        <caption>รายการครอบครองทั้งหมดของทรัพย์นี้</caption>
                        <thead class="table-light">
                            <th>#</th>
                            <th>ลูกค้า</th>
                            <th>สถานะ</th>
                            <th>ผู้ลงบันทึก</th>
                            <th>วันที่บันทึก</th>
                            <th>ผู้แก้ไขล่าสุด</th>
                            <th>อัพเดตล่าสุด</th>
                        </thead>
                        <tbody>
                            @foreach($assetItem->AssetToManyOwner as $i => $owner)
                                @php
                                    $text_danger_class = $owner->State_Ownership == 'Active' || $owner->State_Ownership == 'Transfer'
                                @endphp
                                <tr>
                                    <td @class([
                                        'position-relative',
                                        'text-danger' => @$text_danger_class,
                                    ])>
                                        @if( $owner->State_Ownership == 'Active' || $owner->State_Ownership == 'Transfer' )
                                            <span class="position-absolute top-50 start-0 translate-middle text-danger">
                                                <i class="fas fa-exclamation-circle fs-5 me-2"></i>
                                                <span class="visually-hidden">Alerts</span>
                                            </span>
                                        @endif
                                        {{$i+1}}</td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        {{ $owner->OwnershipToCus->Name_Cus }}
                                    </td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        <span @class([
                                            'badge rounded-pill font-size-12 fw-blod',
                                            'badge-soft-success' => $owner->State_Ownership == 'Active',
                                            'badge-soft-warning' => $owner->State_Ownership == 'Process',
                                            'badge-soft-dark' => $owner->State_Ownership == 'Contract',
                                            'badge-soft-danger' => $owner->State_Ownership == 'Completed' || $owner->State_Ownership == 'Cancel',
                                            'badge-soft-info' => $owner->State_Ownership == 'Transfer',
                                        ])>
                                            {{ $owner->StatusOwnership->name_th }}
                                        </span>
                                    </td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        @if( empty($owner->OwnershipToUser) )
                                            -
                                        @else
                                            {{ @$owner->OwnershipToUser->name }}
                                        @endif
                                    </td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        {{ $owner->created_at }}
                                    </td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        @if( empty($owner->OwnershipToUserUpdate) )
                                            -
                                        @else
                                            {{ @$owner->OwnershipToUserUpdate->name }}
                                        @endif
                                    </td>
                                    <td @class(['text-danger' => @$text_danger_class])>
                                        {{ $owner->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        @else
        
        <!-- assetType สำหรับใช้แยกประเภทว่าสร้างทรัพย์อะไร -->
        <input type="hidden" id="assetType_input" name="assetType_input" value="{{@$asset}}">
        <!-- newAsset_DataCusId สำหรับใช้จำไอดีลูกค้า -->
        <input type="hidden" id="newAsset_DataCusId" name="newAsset_DataCusId" value="{{@$dataCusId}}">

        <!-- page_DataCusId ใช้จำว่าเปิดหน้าลูกค้าคนไหนอยู่ หลังอัพเดตจะส่งกลับไปหน้าเดิม-->
        <input type="hidden" id="page_DataCusId" name="page_DataCusId" value="{{@$page_DataCusId}}">
        
        <div class="row g-0">
            <div class="col-md-12 col-lg-6 col-xl-6">
                
                <!-- Form ข้อมูลทรัพย์ที่จะย้าย -->
                <div class="col-12 bg-light bg-soft border-opacity-25 text-center px-4 py-2">
                    <p class="fw-bold my-2">
                        <i class="fas fa-briefcase"></i> ข้อมูลทรัพย์ที่จะย้าย
                    </p>
                    <form id="search-old-asset" class="form-search-transfer" @style(['display: none;' => !empty($assetItem)])>
                        @csrf
                        <div class="input-group rounded-pill bg-primary bg-opacity-10 pe-0">
                            <input type="search" class="form-control border-0 bg-transparent input-search-old-asset" placeholder="ป้ายทะเบียน / เลขถัง / เลขที่โฉนด" data-inputclass="input-search-old-asset" data-submitclass="submit-search-old-asset" @disabled(!empty($assetItem))>
                            <button type="button" class="btn btn-rounded btn-outline-primary waves-effect waves-light submit-search-old-asset" @disabled(!empty($assetItem))>
                                <i class="fas fa-search hover-up"></i>
                            </button>
                        </div>
                    </form>

                    <div class="bg-transparent border border-primary border-opacity-50 rounded-3 my-2" data-resultfor="search-old-asset" @style(['display: none;' => !empty($assetItem)])>

                        <div class="p-5 m-0 feedback-search" @style(['display: none;' => isset($assetItem)])>
                            <span class="text-muted" style="position: relative">- กรุณาป้อนข้อมูลเพื่อทำการค้นหา -</span>
                        </div>

                        <div class="spinner-border text-primary m-5" role="status" style="display: none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <div class="feedback-data-search">
                            
                        </div>
                        
                    </div>

                    <div class="card border rounded-3 shadow-sm mb-2" id="tf_NewAssetCard" data-cardformid="search-old-asset" @style([
                        'display: none;' => empty($assetItem)
                        ])>
                        <div class="text-body p-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center me-3">

                                    @if(@$asset == 'car')
                                        <img class="rounded-circle avatar-sm" src="{{ asset('/assets/images/asset/astCar.png') }}" alt="">
                                    @elseif(@$asset == 'moto')
                                        <img class="rounded-circle avatar-sm" src="{{ asset('/assets/images/asset/motorbike.png') }}" alt="">
                                    @elseif(@$asset == 'land')
                                        <img class="rounded-circle avatar-sm" src="{{ asset('/assets/images/asset/real-estate.png') }}" alt="">
                                    @else
                                        <img class="rounded-circle avatar-sm" src="" alt="">
                                    @endif

                                </div>
                                <div class="overflow-hidden flex-fill">

                                    @php
                                        if(@$asset == "land"){
                                            $asset_title = @$assetItem->DataAssetToLandType->nametype_car;
                                            $asset_titlesub = @$assetItem->Land_Province.", ".@$assetItem->Land_District;
                                        } else {
                                            $asset_title = @$assetItem->AssetToCarType->nametype_car;
                                            $asset_titlesub = @$assetItem->Vehicle_Chassis;
                                        }
                                    @endphp
                                    <input type="text" name="asset_title" id="asset_title" readonly class="form-control-plaintext font-size-16 fw-bold p-0" value="{{@$asset_title}}">
                                    <input type="text" name="asset_titlesub" id="asset_titlesub" readonly class="form-control-plaintext font-size-14 text-primary fw-bold p-0" value="{{@$asset_titlesub}}">

                                    <input type="hidden" name="asset_id" id="asset_id" class="form-control" value="{{@$assetItem->id}}" readonly>
                                    
                                    <div class="veh_list" @style(['display: none;' => @$asset == 'land'])>
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-card m-0 text-success h5 pe-2"></i>
                                                ทะเบียนเก่า:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="veh_oldlicense" id="veh_oldlicense" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Vehicle_OldLicense}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-card bg-soft m-0 text-success h5 pe-2"></i>
                                                ทะเบียนใหม่:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="veh_newlicense" id="veh_newlicense" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Vehicle_NewLicense}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-dna m-0 text-success h5 pe-2"></i>
                                                เลขถัง:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="veh_chassis" id="veh_chassis" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Vehicle_Chassis}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-bot bg-soft m-0 text-success h5 pe-2"></i>
                                                เลขเครื่อง:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="veh_engine" id="veh_engine" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Vehicle_Engine}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="land_list" @style(['display: none;' => @$asset != 'land'])>
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-id-card m-0 text-success h5 pe-2"></i>
                                                เลขที่โฉนด:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="land_id" id="land_id" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Land_Id}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-map bg-soft m-0 text-success h5 pe-2"></i>
                                                เลขที่ดิน:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="land_parcelnum" id="land_parcelnum" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Land_ParcelNumber}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-map-alt m-0 text-success h5 pe-2"></i>
                                                ระวาง:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="land_sheetnum" id="land_sheetnum" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Land_SheetNumber}}">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-book bg-soft m-0 text-success h5 pe-2"></i>
                                                หน้าสำรวจ:
                                            </div>
                                            <div class="ps-3">
                                                <input type="text" name="land_tambonnum" id="land_tambonnum" readonly class="form-control-plaintext text-end p-0" value="{{@$assetItem->Land_TambonNumber}}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex flex-column ms-3">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="tf_cancelSelectBtn_on_clicked(this)" @disabled(!empty($assetItem))>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Form เจ้าของทรัพย์ใหม่ -->
                <div class="col-12 bg-primary bg-soft border-opacity-25 text-center px-4 py-2">
                    <p class="fw-bold my-2">
                        <i class="fas fa-user"></i> ข้อมูลเจ้าของทรัพย์ใหม่
                    </p>

                    <form id="search-new-cus" class="form-search-transfer" @style(['display: none;' => !empty($preload_cus)])>
                        @csrf
                        <div class="input-group rounded-pill bg-light pe-0">
                            <input type="search" class="form-control border-0 bg-transparent input-search-new-cus" placeholder="ชื่อ-นามสกุล / เลขบัตรประชาชน" data-inputclass="input-search-new-cus" data-submitclass="submit-search-new-cus" @disabled(!empty($preload_cus))>
                            <button type="button" class="btn btn-rounded btn-outline-primary waves-effect waves-light submit-search-new-cus" @disabled(!empty($preload_cus))>
                                <i class="fas fa-search hover-up"></i>
                            </button>
                        </div>
                    </form>

                    <div class="bg-light rounded-3 my-2" data-resultfor="search-new-cus" @style(['display: none;' => !empty($preload_cus)])>
                        <div class="p-5 m-0 feedback-search" @style(['display: none;' => isset($preload_cus)])>
                            <span class="text-muted" style="position: relative">- กรุณาป้อนข้อมูลเพื่อทำการค้นหา -</span>
                        </div>

                        <div class="spinner-border text-primary m-5" role="status" style="display: none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>

                        <div class="feedback-data-search">

                        </div>
                    </div>

                    <div class="card border rounded-3 shadow-sm my-2" id="tf_NewCusCard" data-cardformid="search-new-cus" @style([
                        'display: none;' => empty($preload_cus)
                        ])>
                        <div class="text-body p-2">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center me-3">
                                    <img class="rounded-circle avatar-sm" src="{{ isset($preload_cus->image_cus) ? URL::asset(@$preload_cus->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
                                </div>
                                <div class="overflow-hidden flex-fill">

                                    <input type="text" name="cus_name" id="cus_name" readonly class="form-control-plaintext font-size-16 fw-bold p-0" value="{{@$preload_cus->Name_Cus}}">
                                    <input type="text" name="cus_nameeng" id="cus_nameeng" readonly class="form-control-plaintext font-size-14 text-primary fw-bold p-0" value="{{@$preload_cus->NameEng_cus}}">

                                    <input type="hidden" name="cus_id" id="cus_id" class="form-control" value="{{@$preload_cus->id}}" readonly>

                                    <div class="d-flex align-items-center bg-success bg-opacity-10">
                                        <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                            <i class="bx bx-id-card m-0 text-success h5 pe-2"></i>
                                            เลขบัตรประจำตัวประชาชน:
                                        </div>
                                        <div class="ps-3">
                                            <input type="text" name="cus_idcard" id="cus_idcard" readonly class="form-control-plaintext text-end input-mask p-0" data-inputmask="'mask': '9-9999-99999-99-9'" value="{{@$preload_cus->IDCard_cus}}">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                            <i class="bx bx-phone bg-soft m-0 text-success h5 pe-2"></i>
                                            เบอร์ติดต่อ:
                                        </div>
                                        <div class="ps-3">
                                            <input type="text" name="cus_phone" id="cus_phone" readonly class="form-control-plaintext text-end input-mask p-0" data-inputmask="'mask': '999-999-9999,999-999-9999'" value="{{@$preload_cus->Phone_cus}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex flex-column ms-3">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="tf_cancelSelectBtn_on_clicked(this)" @disabled(!empty($preload_cus))>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-12 col-lg-6 col-xl-6 px-2">
                <p class="fw-bold my-2 text-center">
                    <i class="fas fa-scroll"></i> ข้อมูลการครอบครอง
                </p>

                <div class="w-100 text-center py-2">

                    <div class="spinner-border text-primary m-5" role="status" style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    
                    <!-- ฟอร์ม AssetDetails -->
                    <form id="formCreateDetails" class="needs-validation" action="#" novalidate>
                        @csrf
                        <input type="hidden" name="funs" id="funs" value="transfer">
                        <div id="formAssetDetail">
                            @includeWhen(!empty($assetItem), 'frontend.content-asset.section-details.create-asset-details', [
                                'type' => 'new',
                                'asset' => @$asset,
                                'dataForm' => @$dataForm,
                                'typePoss' => @$typePoss,
                                'CompanyInsurance' => @$CompanyInsurance,
                                'midPrice' => @$assetItem ? @$assetItem->getMidPrice() : 0,
                                ])
                        </div>
                    </form>

                    <div class="text-center m-5" id="formAssetDetails_info" @style([
                        'padding-top: 6rem;',
                        'display: none;' => !empty($assetItem)
                        ])>

                        <div class="d-flex flex-column justify-content-center">

                            <span class="d-flex text-muted pt-3 justify-content-center">
                                กรุณาเลือกทรัพย์ก่อน จึงจะสามารถป้อนข้อมูลรายละเอียดทรัพย์ได้
                            </span>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        @endif

        <div class="modal-footer">
            
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_createOwnership" @disabled(!empty($assetItem) && $assetItem->canTransfer() == false)>
                <i class="fas fa-download"></i> สร้างการครอบครองใหม่ <span class="addSpin">
            </button>

            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn_closeTransfer" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            
        </div>
        
    </div>
</div>

@include('frontend.content-asset.section-transfer.script')
