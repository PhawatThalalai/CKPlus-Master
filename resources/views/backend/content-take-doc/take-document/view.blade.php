@extends('layouts.master')
@section('title', 'TAKE-DOC')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-savePrintlet', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('public-js.constants')
	@component('components.breadcrumb')
		@slot('title')
			ขอเบิกเอกสาร (TAKE DOCUMENT)
		@endslot
		@slot('menu')
			ระบบขอเบิกเอกสาร
		@endslot
		@slot('sub_menu')
			ขอเบิกเอกสาร
		@endslot
	@endcomponent

	@include('backend.content-take-doc.take-document.css')

	<div class="card py-2 px-2">
		<div class="cont__input">
			<img class="mock__up" src="{{ URL::asset('assets/images/svg/process.svg') }}" alt="">
			<div class="px-2" style="width: 100%">
				<div class="progress-container">
					<div class="d-flex">
						<div class="circle active">
							<i class="bx bx-news"></i>
						</div>
						<div class="circle__title">
							<span>ประเภทสัญญา</span>
						</div>
					</div>
					<div class="d-flex">
						<div class="circle">
							<i class="bx bx-paste"></i>
						</div>
						<div class="circle__title">
							<span>รายละเอียดการเบิก</span>
						</div>
					</div>
					<div class="d-flex">
						<div class="circle">
							<i class='bx bx-check-square'></i>
						</div>
						<div class="circle__title">
							<span>ดำเนินการขอเบิกเสร็จสิ้น</span>
						</div>
					</div>
				</div>
				<form id="searchData">
					<div class="step1">
						<div class="conn_title pb-2">
							<img class="doc__gif" src="{{ URL::asset('assets/images/gif/doc.gif') }}" alt="">
							<div>
								<span>ระบบขอเบิกเอกสาร</span>
								<div>
									<span id="typeLoan"></span>
								</div>
							</div>
						</div>
						<div class="conn_cardr">
							<div class="card-lable">
								<label class="card-radio-label mb-3">
									<input type="radio" id="Loans" name="typeLoan" value="PSL" id="pay-methodoption1" class="card-radio-input" checked>
									<div class="card-radio" style="gap: 10px; height: 50px;">
										<img src="{{ URL::asset('assets/images/gif/alms.gif') }}" style="width: 35px;" alt="">
										<span>เงินกู้</span>
									</div>
								</label>
							</div>
							<div class="card-lable">
								<label class="card-radio-label mb-3">
									<input type="radio" id="Loans" name="typeLoan" value="HP" id="pay-methodoption1" class="card-radio-input">
									<div class="card-radio" style="gap: 10px; height: 50px;">
										<img src="{{ URL::asset('assets/images/gif/money-bag.gif') }}" style="width: 35px;" alt="">
										<span>เช่าซื้อ</span>
									</div>
								</label>
							</div>
						</div>
						<div class="form-search">
							<div class="input-bx">
								<input type="text" class="form-control py-2 form-control-sm textSize-13" name="CONTNO" id="CONTNO" value="" placeholder="" required>
								<span>เลขที่สัญญา</span>
							</div>
						</div>
					</div>
					<div class="step2 visually-hidden">
						<div class="conn_title pb-2">
							<img class="doc__gif" src="{{ URL::asset('assets/images/gif/agreement.gif') }}" alt="">
							<div>
								<span>รายละเอียดการเบิกเอกสาร</span>
								<div>
									<span id="typeLoan"></span>
								</div>
							</div>
						</div>
						<div class="form-search">
							<div class="input-bx">
								<input type="text" class="form-control py-2 form-control-sm textSize-13" name="CONTNOs" id="CONTNOs" value="" placeholder="" readonly>
								<span>เลขที่สัญญา</span>
							</div>
							<div class="input-bx">
								<select id="docType" name="docType" class="form-control py-2 form-control-sm textSize-13">
									<option value="">--เลือกเอกสารที่ต้องการเบิก--</option>
									@foreach ($dataTypeTake as $item)
										<option value="{{ $item->id }}">{{ $item->name_th }} - ({{ $item->name_en }})</option>
									@endforeach
								</select>
								<span>ประเภทเอกสาร</span>
							</div>
						</div>
						<div class="form-search pt-3">
							<div class="input-bx">
								<textarea name="NOTE" id="NOTE" rows="3" style="width: 100%; padding: 10px; border: 1px solid #E0E0E0; border-radius: 5px; outline: none;" lass="form-control py-2 form-control-sm textSize-13 px-2" required></textarea>
								<span>หมายเหตุ</span>
							</div>
						</div>
					</div>
					<div class="step3 visually-hidden">
						<div class="conn_verify pb-2">
							<div>
								<div style="display: flex; justify-content: center;">
									<img class="verify_gif" src="{{ URL::asset('assets/images/gif/verified.gif') }}" alt="">
								</div>
								<span style="display: block;">คุณได้ดำเนินการขอเบิกสารเรียบร้อยแล้ว ระบบจะนำคุณไปยังหน้ารายการขอเอกสารภายใน <span id="countdownEl"></span> วินาที</span>
							</div>
						</div>
					</div>
				</form>
				<div class="d-flex justify-content-between mt-1 h-fit">
					<button type="submit" class="btn-pn" id="prev" class="btn btn-primary btn-block textSize-13 px-4">
						<i class="bx bx-left-arrow-alt"></i> ย้อนกลับ
					</button>
					<button type="submit" class="btn-pn" id="next" class="btn btn-primary btn-block textSize-13 px-4">
						ดำเนินการต่อ <i class="bx bx-right-arrow-alt"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	@include('backend.content-take-doc.take-document.script')
@endsection
