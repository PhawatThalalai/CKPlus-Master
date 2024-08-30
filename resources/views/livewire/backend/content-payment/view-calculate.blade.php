
@include('public-js.constants')
@include('components.content-modal.modal-sd')
@include('components.content-modal.modal-lg')
@include('components.content-toast.view-toast')
@include('livewire.backend.content-payment.create-payment')

<div class="card">
    <div class="card-header bg-transparent border-bottom">
        <div class="d-flex flex-wrap align-items-start">
            <div class="me-2">
                <h5 class="card-title mt-1 mb-0 font-size-13 text-primary">คำนวณยอดรับชำระ</h5>
            </div>
        </div>
    </div>
	<div class="card-body">
		<div class="tab-content">
            <div class="mb-1 d-flex justify-content-end font-size-12">
                <div class="btn-group btn-group-example" role="group">
                    <button type="button" wire:click="activeBtn('period')" class="btn btn-outline-success w-xs {{(@$btn_active == 'period')?'active' : ''}}">ชำระค่างวด</button>
                    <button type="button" wire:click="activeBtn('period_orther')" class="btn btn-outline-success w-xs {{(@$btn_active == 'period_orther')?'active' : ''}}">ชำระค่าอื่นๆ</button>
                </div>
                {{-- <div class="d-flex text-danger">
                    <h5 class="font-size-13 fw-semibold"><i class="bx bxs-bell font-size-18"></i> ประเภทการชำระเงิน</h5>
                </div> --}}
            </div>
            <div class="mb-3">
                <div class="input-group mb-1">
                    <label class="input-group-text font-size-12">ชำระค่างวด</label>
                    <input type="text" wire:model.defer="inputPayment" wire:keydown.enter='checkPayments' class="form-control text-end" autofocus {{@$isDisabled}}>
                    <label class="input-group-text">฿</label>
                </div>

                <div class="input-group mb-1">
                    <label class="input-group-text font-size-12">เบี้ยปรับล่าช้า</label>
                    <input type="text" id="interest" wire:model.defer="interest" wire:keydown.enter='addInterest' class="form-control text-end" {{@$isDisabled}}>
                    <label class="input-group-text">฿</label>
                </div>
            </div>
            <div class="float-end ms-2">
                <h5 class="font-size-12"><i class="bx bx-wallet text-primary align-middle me-1"></i> {{number_format(@$sumAmount,2)}}</h5>
            </div>
            <h5 class="font-size-12 mb-3 text-danger"><ins>รวมต้องชำระ</ins></h5>
            <div class="float-end ms-2">
                <h5 class="font-size-12"><i class="bx bx-wallet text-primary align-middle me-1"></i> {{number_format(@$payinteff,2)}}</h5>
            </div>
            <h5 class="font-size-12 mb-3">ตัดดอกเบี้ย</h5>
            <div class="float-end ms-2">
                <h5 class="font-size-12"><i class="bx bx-wallet text-primary align-middle me-1"></i> {{number_format(@$payton,2)}}</h5>
            </div>
            <h5 class="font-size-12 mb-3">ตัดเงินต้น</h5>
            <div class="d-flex justify-content-center gap-2">
                <div class="btn-group" data-bs-toggle="tooltip" title="เพิ่มเติม">
                    <button type="button" class="btn btn-outline-info btn-rounded chat-send w-md waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-list-plus bx-xs"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                        <a class="dropdown-item" href="#">
                            <span class="me-2"><i class="bx bx-right-arrow-circle text-info"></i> action</span>
                        </a>
                        <button class="dropdown-item data-modal-xl" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('constants.index') }}">
                            <span class="me-2"><i class="bx bx-right-arrow-circle text-info"></i> บันทึกปิดบัญชี</span>
                        </button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="#">
                                <span class="me-2"><i class="bx bx-right-arrow-circle text-info"></i> action</span>
                            </a>
                            <button class="dropdown-item data-modal-lg" type="button" data-bs-toggle="modal" data-bs-target="#data-modal-lg" data-link="{{ route('payments.show', 4 )}}?type={{1}}">
                                <span class="me-2"><i class="bx bx-right-arrow-circle text-info"></i> บันทึกปิดบัญชี</span>
                            </button>
                        </div>
                    </div>
                </div>
                @if ($flagModeAdd)
                    <button type="button" id="openModal" wire:click='openModal' data-bs-toggle="modal" data-bs-target=".modal-data-xl" class="btn btn-sm btn-outline-success btn-rounded chat-send w-md waves-effect waves-light" data-bs-toggle="tooltip" title="รับชำระ">
                        <i class="bx bx-dollar-circle bx-xs bx-tada"></i>
                    </button>
                @else
                    <button type="button" wire:click='openModal' class="btn btn-sm btn-outline-danger btn-rounded chat-send w-md waves-effect waves-light" data-bs-toggle="tooltip" title="รับชำระ" {{@$btn_add}}>
                        <i class="bx bx-dollar-circle bx-xs bx-tada"></i>
                    </button>
                @endif
            </div>
		</div>
	</div>
</div>

<script>
    $(document).on('click', '.data-modal-lg', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-link');
        $('#data-modal-lg .modal-dialog').load(url);
    });
</script>
