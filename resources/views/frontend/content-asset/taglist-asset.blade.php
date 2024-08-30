<div class="modal-content">
	
	<div class="modal-body">
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="" class="avatar-sm">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">{{ @$title }}</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">ลูกค้า : {{ @$nameCus }}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close btn-disabled btn_closeAsset" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

        @if( count(@$dataTag) == 0 )
            <div class="card bg-light bg-soft shadow-none">
                <div class="m-5 text-body">
                    <h5 class="text-center text-truncate mb-1">- ไม่มีบันทึกติดตาม -</h5>
                </div>
            </div>
        @else
        <div class="card card-body p-0 m-0">
            <div class="m-0 overflow-auto p-2" style="max-height: 30rem;">
                @foreach($dataTag as $tagItem)
                    <div class="card border rounded-3 shadow-none mb-2">
                        <div class="text-body p-2">
                            <div class="d-flex">
                                <div class="avatar-xs align-self-center me-2">
                                    <div class="avatar-title rounded bg-transparent font-size-20">
                                        @if( @$tagItem->Status_Tag == 'complete' )
                                            @switch( @$tagItem->TagToContracts->ContractToTypeLoan->id_rateType )
                                                @case('car')
                                                    <i class="fas fa-car text-success"></i>
                                                    @break
                                                @case('moto')
                                                    <i class="fas fa-motorcycle text-success"></i>
                                                    @break
                                                @case('land')
                                                    <i class="fas fa-map text-success"></i>
                                                    @break
                                                @case('person')
                                                    <i class="fas fa-user-tie text-success"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-question text-success"></i>  
                                            @endswitch
                                        @elseif( @$tagItem->Status_Tag == 'active' )
                                            <i class="fas fa-tag text-info"></i>
                                        @elseif( @$tagItem->Status_Tag == 'inactive' )
                                            <i class="fas fa-tag text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="overflow-hidden flex-fill">
                                    <h5 class="font-size-13 mb-1">
                                        {{ formatDateThaiShort($tagItem->date_Tag) }} ({{ @$tagItem->created_at->format('H:i:s') }})
                                    </h5>
                                    <h4 class="font-size-15 mb-1">{{ $tagItem->Code_Tag }}</h4>
                                    @if( @$tagItem->Status_Tag == 'complete' )
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-home-circle m-0 text-success h5 pe-2"></i>
                                                สาขา:
                                            </div>
                                            <div class="ps-3">
                                                {{ @$tagItem->TagBranchCont->Name_Branch }}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="bx bx-fridge bg-soft m-0 text-success h5 pe-2"></i>
                                                สัญญา:
                                            </div>
                                            <div class="ps-3">
                                                {{ @$tagItem->TagToContracts->Contract_Con }}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center bg-success bg-opacity-10">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="mdi mdi-label-variant-outline m-0 text-success h5 pe-2"></i>
                                                ประเภท:
                                            </div>
                                            <div class="ps-3">
                                                {{ @$tagItem->TagToContracts->ContractToTypeLoan->Loan_Name }}
                                            </div>
                                        </div>
                                    
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fw-semibold d-flex align-items-center">
                                                <i class="mdi mdi-clipboard-account-outline m-0 text-success h5 pe-2"></i>
                                                ผู้ส่ง:
                                            </div>
                                            <div class="ps-3">
                                                {{ @$tagItem->TagToContracts->ContractToUserBranch->name }}
                                            </div>
                                        </div>
                                    @elseif( @$tagItem->Status_Tag == 'active' )
                                        <p class="text-muted mb-0">อยู่ในระหว่างการติดตาม</p>
                                    @endif
                                </div>
                                <div class="d-flex flex-column ms-3">
                                    <p class="text-muted text-end mb-auto">
                                        @switch(@$tagItem->Status_Tag)
                                            @case('active')
                                                <span class="badge rounded-pill badge-soft-info font-size-11">กำลังติดตาม</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge rounded-pill badge-soft-danger font-size-11">ยกเลิกติดตาม</span>
                                                @break
                                            @case('complete')
                                                <span class="badge rounded-pill badge-soft-success font-size-11">ส่งจัดแล้ว</span>
                                                @break
                                            @default
                                                -
                                        @endswitch
                                    </p>
                                    
                                    @if( @$tagItem->TagToCulculate == NULL )
                                        <span class="d-grid" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ยังไม่ได้คำนวณยอดจัด">
                                            <button type="button" class="btn btn-warning waves-effect waves-light w-100 disabled">
                                                <i class="fas fa-exclamation-triangle"></i> ไม่มีข้อมูล
                                            </button>
                                        </span>
                                    @else
                                        @if( @$tagItem->TagToCulculate->hasCreatedAsset() )
                                            <span class="d-grid" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="สร้างไปแล้ว">
                                                <button type="button" class="btn btn-outline-primary waves-effect waves-light w-100 disabled">
                                                    <i class="fas fa-check"></i> สร้างแล้ว
                                                </button>
                                            </span>
                                        @else
                                            @if( in_array(@$tagItem->TagToCulculate->TypeLoans, array("car", "moto")) )
                                        
                                                @if( @$tagItem->TagToCulculate->CheckAssetNotCreated() )
                                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light data-modal-xl" type="button" data-link="{{ route('asset.create') }}?type=new&asset={{@$tagItem->TagToCulculate->TypeLoans}}&cusid={{@$tagItem->DataCus_id}}&tagcalid={{@$tagItem->TagToCulculate->id}}" data-bs-dismiss="modal">
                                                        <i class="fas fa-plus"></i> สร้าง
                                                    </button>
                                                @else
                                                    <span class="d-grid" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="มีทรัพย์รุ่นนี้แล้ว">
                                                        <button type="button" class="btn btn-outline-primary waves-effect waves-light w-100 disabled">
                                                            <i class="fas fa-check"></i> มีแล้ว
                                                        </button>
                                                    </span>
                                                @endif
                                        
                                            @else
                                                <span class="d-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="เฉพาะรถยนต์หรือมอเตอร์ไซค์เท่านั้น">
                                                    <button type="button" class="btn btn-warning text-dark waves-effect waves-light w-100 disabled">
                                                        <i class="fas fa-times"></i> สร้างไม่ได้
                                                    </button>
                                                </span>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
        @endif

        {{--
        <div class="card border shadow-none mb-2">
            <div class="p-2 text-body">
                <div class="d-flex">
                    <div class="avatar-xs align-self-center me-2">
                        <div class="avatar-title rounded bg-transparent text-danger font-size-20">
                            <i class="mdi mdi-play-circle-outline"></i>
                        </div>
                    </div>

                    <div class="overflow-hidden me-auto">
                        <h5 class="font-size-13 text-truncate mb-1">Video</h5>
                        <p class="text-muted text-truncate mb-0">45 Files</p>
                    </div>

                    <div class="ms-2">
                        <p class="text-muted">4.1 GB</p>
                    </div>
                </div>
            </div>
        </div>

        <table class="table w-100 text-center mb-3">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>ติดตามเมื่อ</th>
                    <th>สาขา</th>
                    <th>สัญญา</th>
                    <th>ผู้ส่ง</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if( count(@$dataTag) == 0 )
                    <tr>
                        <td class="text-center" colspan="6">
                            - ไม่มีงานติดตาม -
                        </td>
                    </tr>
                @else
                    @foreach($dataTag as $tagItem)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$tagItem->date_Tag}}</td>
                            <td>{{$tagItem->TagBranchCont->Name_Branch}}</td>
                            <td>{{$tagItem->TagToCulculate->DataCalcuToTypeLoan->Loan_Name}}</td>
                            <td>{{$tagItem->TagUserID->name}}</td>
                            <td>
                                
                                <button type="button" class="btn btn-success btn-sm waves-effect hover-up ">
                                    สร้าง
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        --}}

        <div class="modal-footer pb-0">
            
            <p class="me-auto">สร้างทรัพย์ได้เฉพาะงานติดตามที่<strong class="text-success px-1">คำนวณยอดจัด</strong>แล้วเท่านั้น</p>

            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn_closeAsset" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            
        </div>
        
    </div>
</div>

<script>
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>