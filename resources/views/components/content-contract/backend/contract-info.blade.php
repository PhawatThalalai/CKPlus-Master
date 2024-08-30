<style>
	.reset {
		all: revert;
	}

	.input-fieldset {
		padding-bottom: 2px;
	}
</style>

<div class="card mb-2 hidden-tab-detail">
	<div class="card-body pt-2 mt-1">
		<div class="row content_cont">
			<div class="col-xl col-lg col-md col-sm-12" data-simplebar='init' style="max-height: 185px;">
				<h5 class="text-primary p-2 font-size-13 fw-semibold"><i class="bx bx-user"></i> รายละเอียดสัญญา (Contracts Details)</h5>
				<div class="row mb-1">
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-info border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-info"><strong><i class="bx bx-label"></i> เกรดสัญญา</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$grade }}</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-info border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-info"><strong><i class="bx bx-label"></i> ค่างวด</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$payamt }} บาท</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-info border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-info"><strong><i class="bx bx-wallet"></i> ยอดคงเหลือ</strong></legend>
							<p class="mb-0 text-end fw-semibold text_balance">{{ @$balance }} บาท</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-calendar"></i> วันชำระล่าสุด</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$LPAYD }}</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-wallet"></i> ยอดชำระล่าสุด</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$LPAYA }} บาท</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-wallet"></i> ยอดค้างชำระ</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$overdue_balance }} บาท</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-rotate-right"></i> งวดค้าง</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$hold_EXP_PRD }}</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-error"></i> งวดค้างจริง</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$hold_HLDNO }}</p>
						</fieldset>
					</div>
					<div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12 mb-0 px-1">
						<fieldset class="reset border border-danger border-opacity-50 rounded-3 input-fieldset">
							<legend class="reset font-size-12 m-0 text-danger"><strong><i class="bx bx-time"></i> ค้างงวดที่</strong></legend>
							<p class="mb-0 text-end fw-semibold">{{ @$hold_EXP_FRM }} - {{ @$hold_EXP_TO }}</>
							</p>
						</fieldset>
					</div>
				</div>
			</div>

			@if (@$active_memo == 'true')
				<div class="col col-xl col-lg col-md col-sm-12 mt-2">
					<p class="m-0 p-2 rounded-3 bg-light" data-simplebar style="max-height: 190px; min-height: 190px;">
						@isset($memo)
							{{ @$memo }}
						@else
							<em>- ยังไม่มีบันทึก -</em>
						@endisset
					</p>
				</div>
			@endif
		</div>

		<div class="loading_content_cont" style="display: none;">
			@include('components.content-loading.loading-cont')
		</div>
	</div>
</div>

{{-- 
<div class="card mb-3 d-none">
    <div class="card-body p-3">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                
                <div class="d-flex mini-stats-wid mb-2">
                    <div class="p-2 flex-fill align-self-center">สถานะสัญญา</div>
                    <div class="p-2 flex-fill align-self-center h2 m-0 text-info fw-bold">{{ @$state }}</div>
                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-info">
                            <span class="avatar-title">
                                <i class="bx bx-check-circle font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-info">
                        <h4 class="font-size-14 m-0"><strong><i class="bx bx-label"></i> เกรดสัญญา</strong></h4>
                        <p class="mb-0 text-end">{{ @$grade }}</p>
                    </div>

                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-danger">
                        <h4 class="font-size-14 m-0"></h4>
                        
                    </div>

                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-danger">
                        <h4 class="font-size-14 m-0"><strong><i class="bx bx-wallet"></i> ยอดค้างชำระ</strong></h4>
                        <p class="mb-0 text-end">{{ @$overdue_balance }} บาท</p>
                    </div>

                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-danger">
                        <h4 class="font-size-14 m-0"><strong><i class="bx bx-rotate-right"></i> งวดค้าง</strong></h4>
                        <p class="mb-0 text-end">{{ @$hold_current }}</p>
                    </div>
                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-danger">
                        <h4 class="font-size-14 m-0"><strong><i class="bx bx-error"></i> งวดค้างจริง</strong></h4>
                        <p class="mb-0 text-end">{{ @$hold_real }}</p>
                    </div>
                    <div class="col-xxl-4 col-lg-4 col-md-4 col-sm-4 col-6 mb-2 text-danger">
                        <h4 class="font-size-14 m-0"><strong><i class="bx bx-time"></i> ค้างงวดที่</strong></h4>
                        <p class="mb-0 text-end">{{ @$hold_no_from }} - {{ @$hold_no_to }}</></p>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <p class="m-0 d-none" style="color: var(--bs-table-color); --bs-table-color: var(--bs-body-color);"><strong>หมายเหตุ :</strong></p>
                <p class="m-0 p-3 rounded-3 bg-light" data-simplebar style="max-height: 140px; min-height: 140px;">
                    @isset($memo)
                        {{ @$memo }}
                    @else
                        <em>- ยังไม่มีบันทึก -</em>
                    @endisset
                </p>
            </div>
        </div>
        
	</div>
</div>

<div class="row d-none">
    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-info shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-help-circle h2 text-info mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">สถานะสัญญา</p>
                        <h5 class="mb-0 text-end text-info"><strong>-</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-info shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-label h2 text-info mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">เกรดสัญญา</p>
                        <h5 class="mb-0 text-end text-info"><strong>-</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-danger shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-calendar h2 text-danger mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">วันชำระล่าสุด</p>
                        <h5 class="mb-0 text-end text-danger"><strong>{{ formatDateThai(@$last_pay_dt) }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-danger shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-wallet h2 text-danger mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">ยอดค้างชำระ</p>
                        <h5 class="mb-0 text-end text-danger"><strong>{{ @$overdue_balance }}</strong> บาท</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-danger shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-rotate-right h2 text-danger mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">งวดค้าง</p>
                        <h5 class="mb-0 text-end text-danger"><strong>{{ @$hold_current }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-danger shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-error h2 text-danger mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">งวดค้างจริง</p>
                        <h5 class="mb-0 text-end text-danger"><strong>{{ @$hold_real }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-4 col-6 px-2">
        <div class="card border border-danger shadow mini-stats-wid mb-2">
            <div class="card-body p-2">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 align-self-center">
                        <i class="bx bx-time h2 text-danger mb-0"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0">ค้างงวดที่</p>
                        <h5 class="mb-0 text-end text-danger"><strong>{{ @$hold_no_from }}</strong> - <strong>{{ @$hold_no_to }}</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-auto px-2 my-auto pe-auto">
        <i class="bx bxs-comment-detail bx-tada h2 text-info mb-0 pe-auto"></i>
    </div>

</div>

<div class="card border border-danger mb-2 d-none">
    <div class="row no-gutters align-items-center">
        <div class="col">
            <div class="card-body pb-3">
                <h5 class="card-title text-primary">Contract Info <small class="font-small">(ข้อมูลสัญญา)</small></h5>

                <div class="row font-size-16">
                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0"><i class="bx bx-help-circle text-primary"></i> สถานะสัญญา</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ @$state }}</b></p>
                    </div>
                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0"><i class="bx bx-label text-primary"></i> เกรดสัญญา</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ @$grade }}</b></p>
                    </div>

                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0"><i class="bx bx-calendar text-primary"></i> วันชำระล่าสุด</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ formatDateThai(@$last_pay_dt) }}</b></p>
                    </div>

                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0 bg-danger bg-soft rounded"><i class="bx bx-wallet text-primary"></i> ยอดค้างชำระ</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ @$overdue_balance }}</b> บาท</p>
                    </div>

                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0 bg-danger bg-soft rounded"><i class="bx bx-rotate-right text-primary"></i> งวดค้าง</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ @$hold_current }}</b></p>
                    </div>
                    <div class="col-xxl-2 col-lg-4 col-md-4 col-sm-4 col-6 mb-2">
                        <h4 class="font-size-15 m-0 bg-danger bg-soft rounded"><i class="bx bx-error text-primary"></i> งวดค้างจริง</h4>
                        <p class="mb-0 text-end text-danger"><b>{{ @$hold_real }}</b></p>
                    </div>
                </div>
                <div class="row">

                    @if (@$hold_no_from !== null)
                        <div class="col-12 mb-2 align-self-center badge bg-danger bg-soft text-wrap">
                            <p class="font-size-13 mb-0 align-self-center flex-fill text-dark"><i class="bx bx-time fs-5 text-danger"></i> ค้างงวดที่ <b class="text-danger font-size-16">{{ @$hold_no_from }}</b> ถึงงวดที่ <b class="text-danger font-size-16">{{ @$hold_no_to }}</b></p>
                        </div>
                    @endif

                    <div class="col-12 align-self-center">
                        <p class="card-text overflow-hidden m-0 note-contract-info" style="height: 1.5em;">
                            {{ @$memo }}
                        </p>
                        <i class="bx bx-chevrons-down fs-3 pe-auto waves-effect" style="position: absolute; top: 0; right: 0px; cursor: pointer;" onclick="ShowNoteContract(this)"></i>
                        <i class="bx bx-chevrons-up fs-3 pe-auto waves-effect" style="position: absolute; right: 0px; bottom: 0px; cursor: pointer; display: none;" onclick="ShowNoteContract(this)"></i>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-auto me-3 d-none d-sm-none d-md-block d-lg-block d-xl-block d-xxl-block">
            <img class="card-img img-fluid" src="{{ URL::asset('assets/images/contract.png') }}" alt="Contract icon" style="max-width: 5rem;">
        </div>
        
    </div>
</div>

@pushOnce('scripts')
<script>
    /*
    document.getElementsByClassName("note-contract").onclick = function() {
        this.style.height = 'auto';
    }
    */

    function ShowNoteContract(el) {
        el.style.display = 'none';
        var pe = el.parentElement;
        var x = pe.getElementsByClassName('note-contract-info')[0];
        if (x.style.height === "auto") {
            x.style.height = "1.5em";
            pe.getElementsByClassName('bx-chevrons-down')[0].style.display = 'block';
        } else {
            x.style.height = 'auto';
            pe.getElementsByClassName('bx-chevrons-up')[0].style.display = 'block';
        }
    }
</script>
@endPushOnce --}}
