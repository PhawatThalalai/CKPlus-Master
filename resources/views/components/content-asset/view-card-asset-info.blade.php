<style>
    .card-view-info-car {
        min-width: 100%;
        background-image: url("{{  asset('/assets/images/asset/astCar.png') }}"), linear-gradient(to bottom, rgba( var(--bs-success-rgb), 0.3) 0%, rgba( var(--bs-success-rgb),0.9) 100%);
        background-repeat: no-repeat;
        background-position: -45% 65%;
    }
    .card-view-info-moto {
        min-width: 100%;
        background-image: url("{{  asset('/assets/images/asset/motorbike.png') }}"), linear-gradient(to bottom, rgba( var(--bs-info-rgb), 0.3) 0%, rgba( var(--bs-info-rgb),0.9) 100%);
        background-repeat: no-repeat;
        background-position: -45% 65%;
    }
    .card-view-info-land {
        min-width: 100%;
        background-image: url("{{  asset('/assets/images/asset/real-estate.png') }}"), linear-gradient(to bottom, rgba( var(--bs-primary-rgb), 0.3) 0%, rgba( var(--bs-primary-rgb),0.9) 100%);
        background-repeat: no-repeat;
        background-position: -45% 65%;
    }
    .card-asset-view-info-text {
        background-color: rgba(var(--bs-white-rgb), 0.9) !important;
    }
    [data-layout-mode=dark] .card-asset-view-info-text {
        background-color: rgba(var(--bs-black-rgb), 0.9) !important;
    }

    .table-header-sticky {
        position:sticky;
        top: 0 ;
    }
</style>


<div class="modal-content">
	<div class="modal-body">
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="" class="avatar-sm">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">{{ @$title }}</h5>
				<p class="text-muted mt-n1 fw-semibold  font-size-12">{{ @$subtitle }}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close btn-disabled btn_closeAsset" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
        
        <div class="container">

            <div class="row g-0 mb-0">
                <div class="col-xl-2 col-lg-3 col-12">
    
                    <!-- การ์ดกำแพงฝั่งซ้าย -->
                    <div class="card rounded-0 m-0 text-center bg-primary bg-soft h-100">
                        <div class="card-body px-2 h-100">

                            <div class="d-flex flex-column align-items-stretch h-100">
                                
                                <h5 class="fw-bold py-2 d-flex align-items-center px-2">
                                    <span id="createAsset_label_veh" class="flex-fill">
                                        @if( @$asset == 'car')
                                            รถยนต์
                                        @elseif( @$asset == 'moto')
                                            มอเตอร์ไซค์
                                        @elseif( @$asset == 'land')
                                            ที่ดิน
                                        @endif
                                    </span>
                                </h5>

                                @switch(@$assetItem->Status_Asset)
                                    @case('Active')
                                        <span class="m-auto mb-3 badge rounded-pill badge-success bg-success font-size-12" id="task-status">กำลังใช้งาน</span>
                                        @break
                                    @case('Inactive')
                                        <span class="m-auto mb-3 badge rounded-pill bg-lightgray-darker-5 text-warning font-size-12 fw-bold" id="task-status">Inactive</span>
                                        @break
                                    @case('Blacklist')
                                        <span class="m-auto mb-3 badge rounded-pill badge-danger bg-danger font-size-12" id="task-status">แบล็กลิสต์</span>
                                        @break
                                    @case('Hide')
                                        <span class="m-auto mb-3 badge rounded-pill badge-dark bg-dark font-size-12" id="task-status">ถูกลบแล้ว</span>
                                        @break
                                    @default

                                @endswitch

                                <!-- แท็บแนวตั้ง สำหรับจอใหญ่ -->
                                <div class="d-none d-lg-flex flex-column" style="min-height: 15rem;">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                            <span class="d-flex">
                                                <i class="fas fa-suitcase fs-4 me-2"></i> ข้อมูลทรัพย์
                                            </span>
                                        </button>
                                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                            <span class="d-flex">
                                                <i class="fas fa-file-contract fs-4 me-2"></i> สัญญาที่เกี่ยวข้อง
                                            </span>
                                        </button>
                                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                            <span class="d-flex">
                                                <i class="fas fa-list-alt fs-4 me-2"></i> ประวัติ
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <!-- แท็บแนวนอน สำหรับจอเล็ก -->
                                <div class="d-flex d-lg-none flex-column">
                                    <div class="nav nav-fill nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                            <span class="d-flex">
                                                <i class="fas fa-suitcase fs-4 me-2"></i> ข้อมูลทรัพย์
                                            </span>
                                        </button>
                                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                            <span class="d-flex">
                                                <i class="fas fa-file-contract fs-4 me-2"></i> สัญญาที่เกี่ยวข้อง
                                            </span>
                                        </button>
                                        <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                            <span class="d-flex">
                                                <i class="fas fa-list-alt fs-4 me-2"></i> ประวัติ
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-none d-lg-flex h-100 d-flex align-items-center">
                                    <div class="avatar-md col text-center mb-md-4">
                                        <img
                                            id="createAsset_profile_veh"
                                            @if( @$asset == 'car')
                                                src="{{ asset('/assets/images/asset/astCar.png') }}" 
                                            @elseif( @$asset == 'moto')
                                                src="{{ asset('/assets/images/asset/motorbike.png') }}" 
                                            @elseif( @$asset == 'land')
                                                src="{{ asset('/assets/images/asset/real-estate.png') }}" 
                                            @endif
                                            style="min-width: 8rem;height: 8rem;"
                                            class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
                                    </div>
                                </div>
                                
                            </div>
    
                        </div>
                    </div>
    
                </div>

                @php
                    switch (@$asset) {
                        case 'moto':
                            $text_asset = 'text-info';
                            $bg_asset = 'bg-info';
                            break;
                        case 'land':
                            $text_asset = 'text-primary';
                            $bg_asset = 'bg-primary';
                            break;
                        case 'car':
                        default:
                            $text_asset = 'text-success';
                            $bg_asset = 'bg-success';
                            break;
                    }
                @endphp

                <div class="col-xl-10 col-lg-9 col-md-12 col-12">
                    <div class="tab-content h-100" id="v-pills-tabContent">
                        <div class="tab-pane fade show active h-100" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                            <div class="card m-0 h-100">
                                <div @class([
                                    'h-100',
                                    'card-view-info-car' => @$asset == 'car',
                                    'card-view-info-moto' => @$asset == 'moto',
                                    'card-view-info-land' => @$asset == 'land',
                                ])>
                                <div class="card-asset-view-info-text h-100 d-flex">

                                    <div class="row col px-3 align-self-center">
                                        <div class="col-12 col-xl-6">

                                            @if( @$asset == 'car' || @$asset == 'moto')
                                                <table class="table table-sm table-nowrap mb-0">
                                                    <tbody>
                                                        @if( empty($assetItem->Vehicle_NewLicense) )
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ทะเบียนเก่า:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty(@$assetItem->Vehicle_OldLicense_Text) )
                                                                    {{@$assetItem->Vehicle_OldLicense}}
                                                                @else
                                                                    {{@$assetItem->Vehicle_OldLicense}} {{@$assetItem->Vehicle_OldLicense_Text}} {{@$assetItem->Vehicle_OldLicense_Province}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @else
                                                            <tr>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> ทะเบียนเก่า:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">
                                                                    @if( empty(@$assetItem->Vehicle_OldLicense_Text) )
                                                                        {{@$assetItem->Vehicle_OldLicense}}
                                                                    @else
                                                                        {{@$assetItem->Vehicle_OldLicense}} {{@$assetItem->Vehicle_OldLicense_Text}} {{@$assetItem->Vehicle_OldLicense_Province}}
                                                                    @endif
                                                                </td>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> ทะเบียนใหม่:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">
                                                                    @if( empty(@$assetItem->Vehicle_NewLicense_Text) )
                                                                        {{@$assetItem->Vehicle_NewLicense}}
                                                                    @else
                                                                        {{@$assetItem->Vehicle_NewLicense}} {{@$assetItem->Vehicle_NewLicense_Text}} {{@$assetItem->Vehicle_NewLicense_Province}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขถัง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">{{@$assetItem->Vehicle_Chassis}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขเครื่อง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Vehicle_Engine}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขไมล์:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Vehicle_Miles}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลข CC:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Vehicle_CC}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> สีรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Vehicle_Color}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="pt-4">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ประเภทรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center pt-4" colspan="3">{{@$assetItem->Type_Name}} ({{@$assetItem->Type_PLT_Name}})</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ยี่ห้อรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Brand_Name}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> กลุ่มรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Group_Name}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ปีรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">{{@$assetItem->Year_Number}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> รุ่นรถ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">{{@$assetItem->Model_Name}}</td>
                                                        </tr>
                                                        @if( @$asset == 'car')
                                                            <tr>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> เกียร์รถ:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center" colspan="3">{{@$assetItem->Vehicle_Gear}}</td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th scope="row" class="pt-4">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ราคากลาง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center pt-4" colspan="3">{{ number_format(@$assetItem->Price_Asset, 0) }} บาท</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            @elseif( @$asset == 'land')
                                                <table class="table table-sm table-nowrap mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ประเภทหลักทรัพย์:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">{{@$assetItem->Type_Name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขที่โฉนด:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_Id}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขที่ดิน:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_ParcelNumber}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ระวาง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_SheetNumber}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> หน้าสำรวจ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_TambonNumber}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เล่ม:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_Book}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> หน้า:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_BookPage}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="pt-4">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เนื้อที่:
                                                                </span>
                                                            </th>
                                                            <td class="text-center pt-4" colspan="3">
                                                                {{@$assetItem->Land_SizeRai}} - {{@$assetItem->Land_SizeNgan}} - {{@$assetItem->Land_SizeSquareWa}}

                                                                <i class="bx bx-help-circle text-end text-info px-2" data-bs-toggle="tooltip"  title="ไร่-งาน-ตารางวา"></i>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ราคาประเมินที่ดิน:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">{{ number_format(@$assetItem->Price_Asset, 0) }} บาท</td>
                                                        </tr>

                                                        @if ( $assetItem->Land_BuildingType == 'BLD-0001')
                                                            <tr>
                                                                <th scope="row" class="pt-4">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> สิ่งปลูกสร้าง:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center pt-4" colspan="3">{{@$assetItem->BuildingType_Name}}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <th scope="row" class="pt-4">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> สิ่งปลูกสร้าง:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center pt-4">{{@$assetItem->BuildingType_Name}}</td>
                                                                <th scope="row" class="pt-4">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> ชนิดบ้าน:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center pt-4">{{@$assetItem->Land_BuildingKind}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> จำนวนชั้น:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">{{@$assetItem->Land_BuildingStorey}}</td>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> พื้นที่สิ่งปลูกสร้าง:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">{{@$assetItem->Land_BuildingSize}} ตร.ม.</td>
                                                            </tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            @endif


                                        </div>
                                        <div class="col-12 col-xl-6">

                                            <table class="table table-sm table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">
                                                            <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                <i class="bx bx-info-circle {{$text_asset}}"></i> วันครอบครองล่าสุด:
                                                            </span>
                                                        </th>
                                                        <td class="text-center">{{ formatDateThaiShort(@$assetItem->OccupiedDT) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">
                                                            <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                <i class="bx bx-info-circle {{$text_asset}}"></i> ระยะเวลาครอบครอง:
                                                            </span>
                                                        </th>
                                                        <td class="text-center">{{@$assetItem->OccupiedTime}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <table class="table table-sm mb-0 mt-4">
                                                <tbody>
                                                    @if( @$asset == 'car' || @$asset == 'moto')
                                                        @php
                                                            $insr_text = '';
                                                            foreach ($dataForm['InsuranceState'] as &$insr_state) {
                                                                if ($insr_state[0] == @$assetItem->InsuranceState) {
                                                                    $insr_text = $insr_state[1];
                                                                    break;
                                                                }
                                                            }
                                                            //-------------------------------------------------------
                                                            $insr_class_text = '';
                                                            if( @$assetItem->InsuranceState != 'No') {
                                                                foreach ($dataForm['InsuranceClass'] as &$insr_class) {
                                                                    if ($insr_class[0] == @$assetItem->InsuranceClass) {
                                                                        $insr_class_text = $insr_class[1];
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            //-------------------------------------------------------
                                                            $ins_date_exp = $assetItem->getAllInsEXP()->first();
                                                        @endphp
                                                        @if( @$assetItem->InsuranceState == 'No')
                                                            <tr>
                                                                <tr>
                                                                    <th scope="row">
                                                                        <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                            <i class="bx bx-info-circle {{$text_asset}}"></i> สถานะประกัน:
                                                                        </span>
                                                                    </th>
                                                                    <td class="text-center">{{$insr_text}}</td>
                                                                </tr>
                                                            <tr>
                                                        @else
                                                            <tr>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> สถานะประกัน:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">{{$insr_text}}</td>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> ชั้นประกันภัย:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">{{$insr_class_text}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> บริษัทประกัน:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">
                                                                    @if( empty($assetItem->CompananyIns_Name) )
                                                                        -
                                                                    @else
                                                                        {{@$assetItem->CompananyIns_Name}}
                                                                    @endif
                                                                </td>
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> เลขกรมธรรม์:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center">
                                                                    @if( empty($assetItem->PolicyNumber) )
                                                                    -
                                                                    @else
                                                                        {{@$assetItem->PolicyNumber}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                @php                                                               
                                                                    $insr_date = '- ไม่ได้ระบุ -';
                                                                    if ( !empty($assetItem->InsuranceDT) ) {
                                                                        list($ins_startDate, $ins_endDate) = convertDateRangePHPToPHPOne($assetItem->InsuranceDT);
                                                                        $ins_startDate = formatDateThaiShort($ins_startDate);
                                                                        $ins_endDate = formatDateThaiShort($ins_endDate);
                                                                        $insr_date = $ins_startDate." - ".$ins_endDate;
                                                                    }
                                                                @endphp
                                                                <th scope="row">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1 text-nowrap">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> วันคุ้มครองประกัน:
                                                                    </span>
                                                                </th>
                                                                <td class="text-center" colspan="3">
                                                                    {{$insr_date}}

                                                                    @if ( !empty($assetItem->InsuranceDT) )
                                                                        @if( @$ins_date_exp['InsEXP'] == true )
                                                                            <i class="bx bx-error fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" title="วันคุ้มครองประกันหมดอายุแล้ว"></i>
                                                                        @elseif( @$ins_date_exp['InsWarning'] == true )
                                                                            <i class="bx bx-error fs-5 fa-fade bx-tada text-warning" data-bs-toggle="tooltip" title="วันคุ้มครองประกันใกล้หมดอายุแล้ว"></i>
                                                                        @else
                                                                            <i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" title="วันคุ้มครองประกันยังไม่หมดอายุ"></i>
                                                                        @endif
                                                                    @endif
                                                                    
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            @php
                                                                $insrAct_date = '- ไม่ได้ระบุ -';
                                                                if ( !empty($assetItem->InsuranceActDT) ) {
                                                                    list($insAct_startDate, $insAct_endDate) = convertDateRangePHPToPHPOne($assetItem->InsuranceActDT);
                                                                    $insAct_startDate = formatDateThaiShort($insAct_startDate);
                                                                    $insAct_endDate = formatDateThaiShort($insAct_endDate);
                                                                    $insrAct_date = $insAct_startDate." - ".$insAct_endDate;
                                                                }
                                                                
                                                            @endphp
                                                            <th scope="row" class="pt-4">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1 text-nowrap">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> วันคุ้มครอง พ.ร.บ.:
                                                                </span>
                                                            </th>
                                                            <td class="text-center pt-4" colspan="3">
                                                                {{$insrAct_date}}
                                                                @if ( !empty($assetItem->InsuranceActDT) )
                                                                    @if( @$ins_date_exp['InsActEXP'] == true )
                                                                        <i class="bx bx-error fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" title="วันคุ้มครอง พ.ร.บ. หมดอายุแล้ว"></i>
                                                                    @elseif( @$ins_date_exp['InsActWarning'] == true )
                                                                        <i class="bx bx-error fs-5 fa-fade bx-tada text-warning" data-bs-toggle="tooltip" title="วันคุ้มครอง พ.ร.บ. ใกล้หมดอายุแล้ว"></i>
                                                                    @else
                                                                        <i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" title="วันคุ้มครอง พ.ร.บ. ยังไม่หมดอายุ"></i>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            @php
                                                                $insrReg_date = '- ไม่ได้ระบุ -';
                                                                if ( !empty($assetItem->InsuranceRegisterDT) ) {
                                                                    list($insReg_startDate, $insReg_endDate) = convertDateRangePHPToPHPOne($assetItem->InsuranceRegisterDT);
                                                                    $insReg_startDate = formatDateThaiShort($insReg_startDate);
                                                                    $insReg_endDate = formatDateThaiShort($insReg_endDate);
                                                                    $insrReg_date = $insReg_startDate." - ".$insReg_endDate;
                                                                }
                                                            @endphp
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1 text-nowrap">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> วันคุ้มครองทะเบียน:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                {{$insrReg_date}}
                                                                @if ( !empty($assetItem->InsuranceRegisterDT) )
                                                                    @if( @$ins_date_exp['InsRegisterEXP'] == true )
                                                                        <i class="bx bx-error fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" title="วันคุ้มครองทะเบียนหมดอายุแล้ว"></i>
                                                                    @elseif( @$ins_date_exp['InsRegisterWarning'] == true )
                                                                        <i class="bx bx-error fs-5 fa-fade bx-tada text-warning" data-bs-toggle="tooltip" title="วันคุ้มครองทะเบียนใกล้หมดอายุแล้ว"></i>
                                                                    @else
                                                                        <i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" title="วันคุ้มครองทะเบียนยังไม่หมดอายุ"></i>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> รูปแบบรถยนต์:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty($assetItem->PurposeType) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->PurposeType}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> สถานะครอบครอง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty($assetItem->TypePoss_Name) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->TypePoss_Name}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ลำดับครองครอง:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty($assetItem->PossessionOrder) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->PossessionOrder}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ประวัติหน้า 16.:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty($assetItem->History_16) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->History_16}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ประวัติหน้า 18.:
                                                                </span>
                                                            </th>
                                                            <td class="text-center" colspan="3">
                                                                @if( empty($assetItem->History_18) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->History_18}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @elseif( @$asset == 'land' )
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ภูมิภาค:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_Zone}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> จังหวัด:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_Province}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> อำเภอ:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_District}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> ตำบล:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_Tambon}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> เลขไปรษณีย์:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">{{@$assetItem->Land_PostalCode}}</td>
                                                            <th scope="row">
                                                                <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                    <i class="bx bx-info-circle {{$text_asset}}"></i> พิกัด:
                                                                </span>
                                                            </th>
                                                            <td class="text-center">
                                                                @if( empty($assetItem->Land_Coordinates) )
                                                                    -
                                                                @else
                                                                    {{@$assetItem->Land_Coordinates}}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        @if( !empty( @$assetItem->Land_Detail ))
                                                            <tr>
                                                                <th scope="row" class="pt-4">
                                                                    <span class="rounded-0 {{$bg_asset}} bg-soft p-1">
                                                                        <i class="bx bx-info-circle {{$text_asset}}"></i> รายละเอียดที่ดิน:
                                                                    </span>
                                                                </th>
                                                                <td class="text-left pt-4" colspan="3">
                                                                    @php
                                                                        echo nl2br($assetItem->Land_Detail,false);
                                                                    @endphp
                                                                </td>
                                                            </tr>
                                                        @endif

                                                    @endif
                                                    
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                                </div>
                            </div>

                            
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <table class="table table-sm table-hover text-sm" id="table1">
                                <thead>
                                  <tr>
                                    <th class="text-center">สาขา</th>
                                    <th class="text-center">ส่งสัญญา</th>
                                    <th class="text-center">เลขที่สัญญา</th>
                                    <th class="text-center">ประเภทสัญญา</th>
                                    <th class="text-center">พนักงานขาย</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">ยอดจัด</th>
                                    <th class="text-center">ถูกเพิ่มเมื่อ</th>
                                  </tr>
                                </thead>
                                <tbody>                                            
                                    @if( count(@$contractRelate) == 0 )
                                        <tr>
                                            <td class="text-center" colspan="8">
                                                - ไม่มีสัญญาที่เกี่ยวข้อง -
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($contractRelate as $contractItem)
                                            <tr class="">
                                                <td class="text-center">
                                                    @if( empty($contractItem->NickName_B) )
                                                        {{$contractItem->Name_B}}
                                                    @else
                                                        <span data-bs-toggle="tooltip" title="{{$contractItem->Name_B}}">{{$contractItem->NickName_B}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <p style="display: none;">{{ date_format(date_create($contractItem->Date_con), 'Ymd')}} </p>
                                                    {{ date('d-m-Y', strtotime($contractItem->Date_con)) }}  
                                                </td>
                                                <td class="text-center">
                                                    <span @class(['text-success' => !empty($contractItem->Approve_monetary) ])>
                                                        {{ $contractItem->Contract_Con }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{$contractItem->Loan_Name}}
                                                </td>
                                                <td class="text-center">
                                                    {{$contractItem->Name_U}}
                                                </td>
                                                <td class="text-center">
                                                    @if( empty($contractItem->DateCheck_Bookcar) && (@$assetItem->TypeAsset_Code != "land" || @$assetItem->TypeAsset_Code != "person"))
                                                        <i class="fas fa-fire-alt text-danger" data-bs-toggle="tooltip" title="ยังไม่เช็คเล่มทะเบียน"></i> 
                                                    @endif
                                                    {{-- $contractItem->Status_Con --}}
                                                    
                                                    @if ($contractItem->Status_Con == 'active')
                                                        <i class="fas fa-book-open text-info align-middle text-info"></i>
                                                    @elseif($contractItem->Status_Con == 'cancel')
                                                        <i class="fas fa-times text-primary align-middle text-danger"></i>
                                                    @elseif($contractItem->Status_Con == 'complete')
                                                        <i class="fas fa-check text-primary align-middle text-success"></i>
                                                    @elseif($contractItem->Status_Con == 'transfered')
                                                        <i class="fas fa-donate text-primary align-middle text-success"></i>
                                                    @elseif($contractItem->Status_Con == 'close')
                                                        <i class="fas fa-file-archive text-primary align-middle text-success"></i>
                                                    @elseif($contractItem->Status_Con == 'pending')
                                                        <i class="fas fa-user-clock text-primary align-middle text-warning"></i>
                                                    @endif
                                                    <span>{{ $contractItem->Memo_StatusCon }}</span>
                                                    
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($contractItem->Cash_Car + $contractItem->Process_Car,0) }}
                                                </td>   
                                                <td class="text-center">
                                                    @if( empty($contractItem->created_at) )
                                                        -
                                                    @else
                                                        {{ date('d-m-Y', strtotime($contractItem->created_at)) }}
                                                    @endif
                                                </td>                           
                                            </tr>     
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                            <div class="row mb-3">
                                <div class="col-12 col-xl-6">
                                    <table class="table table-sm table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <span class="rounded-0 bg-secondary bg-soft p-1">
                                                        <i class="bx bx-info-circle text-secondary"></i> วันที่เข้าระบบ:
                                                    </span>
                                                </th>
                                                <td class="text-center">{{@$assetItem->created_at}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-xl-6">
                                    <table class="table table-sm table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <span class="rounded-0 bg-secondary bg-soft p-1">
                                                        <i class="bx bx-info-circle text-secondary"></i> ผู้ลงบันทึก:
                                                    </span>
                                                </th>
                                                <td class="text-center">{{@$Name_UserInsert}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div style="max-height: 26rem; overflow:auto;">
                                <table class="table table-sm table-hover text-sm" id="table1">
                                    <thead class="table-light table-header-sticky">
                                      <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">วันที่กิจกรรม</th>
                                        <th class="text-center">ทำอะไร</th>
                                        <th class="text-center">Tag Input</th>
                                        <th class="text-center">รายละเอียด</th>
                                        <th class="text-center">User</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @if( count(@$logAsset) == 0 )
                                            <tr>
                                                <td class="text-center" colspan="6">
                                                    - ไม่มีประวัติ -
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($logAsset as $key => $logItem)
                                                <tr class="">
                                                    <td class="text-center"> {{($key+1)}} </td>
                                                    <td class="text-center"> {{ $logItem->created_at }} </td>
                                                    <td class="text-center"> {{ $logItem->status }} </td>
                                                    <td class="text-center"> {{ $logItem->tagInput }} </td>
                                                    <td class="text-center"> {{ $logItem->details }} </td>
                                                    <td class="text-center"> {{ $logItem->Name_U }} </td>                               
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn_closeAsset" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
