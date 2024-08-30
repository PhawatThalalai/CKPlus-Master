<style>
	.custom-tooltip {
		--bs-tooltip-bg: var(--bs-primary);
	}
</style>
<input type="hidden" id="arrType" value="{{ @$data['SpApp'] }}">
<div class="row px-4 gap-2">
	<div class="col-xl col-lg col-md-12 col-sm-12">
		<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> ข้อมูลการอนุมัติ</h5>
		<div class="row bg-light">
			<div class="col py-3">
				<span class="fw-semibold">สิทธิ์อนุมัติ :</span>
			</div>
			<div class="col m-auto pe-4">
				<span class="fw-semibold">{{ @$data['UserApp_Con'] != null ? @$data['UserApp_Con'] : 'รอสัญญาอนุมัติ' }}</span>
			</div>
			<div class="col-3  m-auto text-end">
				<span class="">
					<i class="bx bx-info-circle fs-4 text-info" title="{{ @$data['UserApp_ConPosition'] }}" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip"></i>
				</span>
			</div>
		</div>

		<div class="row">
			<div class="col py-3">
				<span class="fw-semibold">ผู้ขออนุมัติ :</span>
			</div>
			<div class="col m-auto pe-4">
				<span class="fw-semibold">{{ @$data['DocApp_Con'] != null ? @$data['DocApp_Con'] : 'รอการกดขออนุมัติ' }}</span>
			</div>
			<div class="col-3 m-auto text-end">
				<span class="">
					<i class="bx bx-info-circle fs-4 text-info" title="{{ @$data['DocApp_ConBranch'] }}" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip"></i>
				</span>
			</div>
		</div>

		<div class="row bg-light">
			<div class="col py-3">
				<span class="fw-semibold">วันที่ชำระงวดแรก :</span>
			</div>
			<div class="col m-auto pe-4">
				<span class="fw-semibold {{ @$data['DateDue_Con'] != null ? 'text-success' : 'text-danger' }}">{{ @$data['DateDue_Con'] != null ? @$data['DateDue_Con'] : 'รอสัญญาโอนเงิน' }}</span>
			</div>
			<div class="col-3  m-auto">
				{{-- <span class="d-none d-md-block">
                        ...
                    </span>
                    <span class="d-md-none">
                        <i class="bx bx-info-circle fs-4 text-info" title="..." data-bs-toggle="tooltip"></i>
                    </span> --}}
			</div>
		</div>

		<div class="row">
			<div class="col py-3">
				<span class="fw-semibold">ตรวจสอบอกสาร :</span>
			</div>
			<div class="col m-auto pe-4">
				{{-- @if (@$data['StatusApprove'] != null && @$data['statusDoc'])
					<span class="text-success fw-semibold">เอกสารสมบูรณ์</span>
				@else
					<span class="{{ @$data['StatusApprove'] != null ? 'text-success' : 'text-danger' }}">
						{{ @$data['StatusApprove'] != null ? 'ตรวจเอกสารแล้ว(รอการอนุมัติ)' : 'เอกสารไม่ครบ !' }}
					</span>
				@endif --}}

                @if (@$data['statusDoc'] == 'Pass' && @$data['StatusApprove'] == 'Y')
					<span class="text-success fw-semibold">เอกสารสมบูรณ์ <i class="mdi mdi-check-circle bx bx-tada"></i> </span>
                @elseif(@$data['statusDoc'] == NULL && @$data['StatusApprove'] == 'Y')
                    @if(@$data['DateDocApp_Con'] == NULL)
                        <span class="text-success fw-semibold">ตรวจเอกสารแล้ว <i class="mdi mdi-check-circle bx bx-tada"></i></span> <br>
                    @else
                        <span class="text-danger fw-semibold">รอการตรวจจากผู้อนุมัติ <i class="mdi mdi-reflect-vertical bx bx-tada"></i></span> <br>
                    @endif
                @elseif(@$data['statusDoc'] == 'notPass' && @$data['StatusApprove'] == NULL)
                    <span class="text-danger fw-semibold">เอกสารไม่ครบ ! โปรดแก้เอกสาร <i class="mdi mdi-close-circle bx bx-tada"></i></span>
                @else
					<span class="text-danger fw-semibold">กรุณาตรวจเอกสารก่อนดำเนินการ <i class="mdi mdi-information bx bx-tada"></i></span>
                @endif


			</div>
			<div class="col-3 m-auto  text-end">
				<a id="" class="col-xl col-lg col-md col-sm text-center btn btn-outline-primary btn-sm rounded-pill mb-1 data-modal-xl-2" data-link="{{ route('contract.edit', @$data['idCon']) }}?funs={{ 'editDoc' }}&TypeLoans={{ @$data['TypeLoans'] }}"> <span class="d-flex"> <span class="d-none d-lg-block me-1">ตรวจเอกสาร</span><i class="bx bx-edit-alt"></i> </span> </a>
			</div>
		</div>

	</div>
	<div class="col-xl col-lg col-md-12 col-sm-12">
		<h5 class="fw-semibold text-primary"><i class="bx bx-book-bookmark"></i> ข้อมูลทะเบียน</h5>
		<div class="row bg-light">
			<div class="col py-3">
				<span class="fw-semibold">เช็คเล่มทะเบียน :
					{{-- @isset($data['LinkBookcar'])
                        <a href="{{ @$data['LinkBookcar'] }}" class="" target = "_blank">ดูอัลบั้ม <i class="bx bxs-share bx-tada"></i> </a>
                    @endisset --}}
				</span>
			</div>
			<div class="col m-auto">
				<div class="input-group pe-4">
					<div class="input-group-text">
						<input class="form-check-input mt-0" type="checkbox" id="DateCheck_Bookcar" value="{{ @$data['DateCheck_Bookcar'] != null ? @$data['DateCheck_Bookcar'] : auth()->user()->id }}" aria-label="Checkbox for following text input" {{ @$data['DateCheck_Bookcar'] != null ? 'checked disabled' : '' }}>
					</div>
					<input type="date" id="DateCheck_Bookcar1" name="DateCheck_Bookcar" value="{{ @$data['DateCheck_Bookcar'] != null ? date_format(date_create(@$data['DateCheck_Bookcar']), 'Y-m-d') : '' }}" class="form-control" aria-label="Text input with checkbox" readonly>
					@if (@$data['DateCheck_Bookcar'] != null)
						<span class="input-group-text" style="cursor: pointer;">
							<a href="{{ @$data['LinkBookcar'] }}" class="" target = "_blank"><i class="bx bx-link text-info fs-5 bx-tada"></i> </a>
						</span>
						@hasrole(roleCancelCheckApprove())
							<span class="input-group-text" style="cursor: pointer;" onclick="ClearApprove('RemoveCheckBookCar')"><i class="bx bx-trash text-danger fs-5"></i></span>
						@endhasrole
					@endif
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col py-3">
				<span class="fw-semibold">ขออนุมัติพิเศษ :</span>
			</div>
			<div class="col m-auto">
				<div class="input-group pe-4">
					<div class="input-group-text">
						<input class="form-check-input mt-0 " type="checkbox" id="DateSpecial_Bookcar" value=" {{ @$data['DateSpecial_Bookcar'] != null ? $data['DateSpecial_Bookcar'] : auth()->user()->id }} " aria-label="Checkbox for following text input" {{ @$data['DateSpecial_Bookcar'] != null ? 'checked disabled' : '' }}>
					</div>
					<input type="text" id="DateSpecial_Bookcar1" value="{{ @$data['Special_Name'] }}" class="form-control" aria-label="Text input with checkbox" placeholder="ยังไม่มีเงื่อนไขการขออนุมัติพิเศษ" readonly>
                    {{-- @if (@$data['DateSpecial_Bookcar'] != null)
                        @if(@$data['ConfirmDocApp_Con'] == NULL)
                            @if(rolebetterSup(['administrator']))
                                <span class="input-group-text" style="cursor: pointer;" onclick="ApproveSpecialCase()"><i class="fas fa-gavel text-success fs-5"></i></span>
                            @else
                                <span class="input-group-text" style="cursor: pointer;" onclick=""><i class="bx bxs-hourglass bx-tada text-warning fs-5"></i></span>
                            @endif
                            <span class="input-group-text" style="cursor: pointer;" onclick="ClearApprove('RemoveSpecialApprove')"><i class="bx bx-trash text-danger fs-5"></i></span>
                        @endif
                    @else
                        @if(@$data['ConfirmDocApp_Con'] != NULL)
						    <span class="input-group-text bg-success bg-soft" style="cursor: pointer;"><i class="mdi mdi-check-bold text-success fs-5"></i></span>
                        @endif
                    @endif --}}
                    @if(@$data['ConfirmDocApp_Con'] == NULL && @$data['DateSpecial_Bookcar'] != NULL)
                            @if(rolebetterSup(auth()->user()->zone))
                                <span class="input-group-text" style="cursor: pointer;" onclick="ApproveSpecialCase()"><i class="fas fa-gavel text-success fs-5"></i></span>
                            @else
                                <span class="input-group-text" style="cursor: pointer;" onclick=""><i class="bx bxs-hourglass bx-tada text-warning fs-5"></i></span>
                            @endif
                                <span class="input-group-text" style="cursor: pointer;" onclick="ClearApprove('RemoveSpecialApprove')"><i class="bx bx-trash text-danger fs-5"></i></span>
                    @elseif(@$data['ConfirmDocApp_Con'] != NULL && @$data['DateSpecial_Bookcar'] != NULL)
                            <span class="input-group-text bg-success bg-soft" style="cursor: pointer;"><i class="mdi mdi-check-bold text-success fs-5"></i></span>
                    @endif
				</div>
			</div>
		</div>

		<div class="row bg-light">
			<div class="col py-3">
				<span class="fw-semibold">
					@if (@$data['TypeLoan'] == 'car' || @$data['TypeLoan'] == 'moto')
						ได้รับเล่มทะเบียน :
					@else
						ได้รับเอกสาร :
					@endif
					{{-- @isset($data['LinkBookSpecial'])
                            <a href="{{ @$data['LinkBookSpecial'] }}" class="btn btn-primary btn-sm rounded-pill" target = "_blank">ดูอัลบั้ม <i class="bx bxs-share "></i> </a>
                        @endisset --}}
				</span>
			</div>
			<div class="col m-auto">
				<div class="input-group pe-4">
					{{-- <span class="">
						<i class="bx bx-info-circle fs-4 text-info" title="{{ @$data['UserApp_ConPosition'] }}" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip"></i>
					</span> --}}
					<div class="input-group-text">
						<input class="form-check-input mt-0" id="Date_BookSpecial" type="checkbox" value="{{ @$data['BookSpecial_Trans'] != null ? @$data['BookSpecial_Trans'] : auth()->user()->id }} " aria-label="Checkbox for following text input" {{ @$data['BookSpecial_Trans'] != null || $data['DateConfirmApp_Con'] == null ? 'disabled' : '' }} {{ @$data['BookSpecial_Trans'] != null ? 'checked' : '' }}>
					</div>
					<input type="date" value="{{ @$data['Date_BookSpecial'] != null ? date_format(date_create(@$data['Date_BookSpecial']), 'Y-m-d') : '' }}" class="form-control" aria-label="Text input with checkbox" readonly>
					@if (@$data['Date_BookSpecial'] != null)
						<span class="input-group-text" style="cursor: pointer;">
							<a href="{{ @$data['LinkBookSpecial'] }}" class="" target = "_blank"><i class="bx bx-link text-info fs-5 bx-tada"></i> </a>
						</span>
						@hasrole(roleCancelCheckApprove())
							<span class="input-group-text" style="cursor: pointer;" onclick="ClearApprove('Removeapprove')"><i class="bx bx-trash text-danger fs-5"></i></span>
						@endhasrole
					@endif
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col py-3">
				<span class="fw-semibold">Checker :</span>
			</div>
			<div class="col m-auto">
				<div class="input-group pe-4">
					<div class="input-group-text">
						<input class="form-check-input mt-0" id="Checkers_Con" type="checkbox" value="{{ @$data['Checkers_Con'] != null ? @$data['Checkers_Con'] : auth()->user()->id }}" aria-label="Checkbox for following text input" {{ @$data['Checkers_Con'] != null ? 'checked disabled' : '' }}>
					</div>
					<input type="date" id="Checkers_Con1" value="{{ @$data['Date_Checkers'] != null ? date_format(date_create(@$data['Date_Checkers']), 'Y-m-d') : '' }}" class="form-control" aria-label="Text input with checkbox" readonly>
					@if (@$data['Date_Checkers'] != null)
						<span class="input-group-text" style="cursor: pointer;">
							<a href="{{ @$data['linkChecker'] }}" class="" target = "_blank"><i class="bx bx-link text-info fs-5 bx-tada"></i> </a>
						</span>
						@hasrole(roleCancelCheckApprove())
							<span class="input-group-text" style="cursor: pointer;" onclick="ClearApprove('Removechecker')"><i class="bx bx-trash text-danger fs-5"></i></span>
						@endhasrole
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row px-4 gap-2 mt-4">
	<div class="col-xl col-lg-12 col-md-12 col-sm-12">
		<div id="cusref">
			<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> บุคคลอ้างอิง</h5>
			<div class="row bg-light py-3">
				<div class="col m-auto">
					<span class="fw-semibold fs-3"><i class="bx bx-user-check text-success"></i> </span>
				</div>
				<div class="col-7 m-auto">
					<span class="RefText fw-semibold {{ @$data['Cus_Ref'] != null ? '' : 'text-danger' }}"> {{ @$data['Cus_Ref'] != null ? @$data['Cus_Ref'] : 'ไม่มีข้อมูล !' }}</span>
				</div>
				<div class="col-3 m-auto text-end">
					<div class="dropdown">
						<button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="d-flex"> <span class="d-none d-lg-block me-1">แก้ไข</span><i class="bx bx-edit-alt"></i> </span>
						</button>
						<ul class="dropdown-menu" style="cursor:pointer;">
							<li><a class="dropdown-item modal_lg  fw-semibold" data-link="{{ route('contract.edit', @$data['idCon']) }}?type={{ 'editRef' }}"><i class="bx bx-edit-alt"></i> แก้ไข </a></li>
							<li class=" {{ @$data['Cus_Ref'] == null ? 'd-none' : '' }}"><a class="dropdown-item text-danger fw-semibold removeRef" onclick="removeRef('removeRef','cusref')"><i class="bx bxs-eraser"></i> นำออก</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

    @if(strtolower(@$data['buyPA'])  == 'yes')
    <div class="col-xl col-lg-12 col-md-12 col-sm-12">
		<div id="cusBeneficiary">
			<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> ผู้รับผลประโยชน์ (PA)</h5>
			<div class="row bg-light py-3">
				<div class="col m-auto">
					<span class="fw-semibold fs-3"><i class="bx bx-user-check text-success"></i> </span>
				</div>
				<div class="col-7 m-auto">
					<span class="RefText fw-semibold {{ @$data['Beneficiary_PA'] != null ? '' : 'text-danger' }}">{{ @$data['Beneficiary_PA'] != null ? @$data['Beneficiary_PA'] : 'ไม่มีข้อมูล !' }}</span>
				</div>
				<div class="col-3 m-auto text-end">
					<div class="dropdown">
						<button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="d-flex"> <span class="d-none d-lg-block me-1">แก้ไข</span><i class="bx bx-edit-alt"></i> </span>
						</button>
						<ul class="dropdown-menu" style="cursor:pointer;">
							<li><a class="dropdown-item modal_lg  fw-semibold" data-link="{{ route('contract.edit', @$data['idCon']) }}?type={{ 'editBeneficiary' }}"><i class="bx bx-edit-alt"></i> แก้ไข </a></li>
							<li class=" {{ @$data['Beneficiary_PA'] == null ? 'd-none' : '' }}"><a class="dropdown-item text-danger fw-semibold removeRef" onclick="removeRef('removeBeneficiary','cusBeneficiary')"><i class="bx bxs-eraser"></i> นำออก</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
    @endif

	<div class="col-xl col-lg-12 col-md-12 col-sm-12">
		<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> ที่อยู่ใช้ทำสัญญา</h5>
		<div class="row bg-light py-3">
            <div class="col m-auto">
                <span class="fw-semibold fs-3"><i class="bx bx-home-circle text-success"></i> </span>
            </div>
            <div class="col-7 m-auto">
				<span class="fw-semibold addressText {{ @$data['Adds_Con'] != null ? '' : 'text-danger' }}">{{ @$data['Adds_Con'] != null ? @$data['Adds_Con'] : 'ไม่มีข้อมูล !' }}</span>
			</div>
			<div class="col-3 text-end m-auto ">
				<button type="button" class="btn btn-outline-primary btn-sm rounded-pill modal_lg" data-link="{{ route('contract.edit', @$data['idCon']) }}?funs={{ 'editAddsCon' }}"><span class="d-flex"> <span class="d-none d-lg-block me-1">แก้ไข</span><i class="bx bx-edit-alt"></i> </span></button>
			</div>
		</div>
	</div>
</div>

<div class="row mt-4">
	<div class="col text-center">
		{{-- @if ($data['DocApp_Con'] == null)
                <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-primary me-1 data-modal-xl-2 rounded-pill"  data-link="{{ route('contract.show',@$data['idCon']) }}?type={{'PreviewCon'}}">ขออนุมัติสัญญา</a>
            @elseif($data['DocApp_Con']!=NULL && $data['ConfirmDocApp_Con']==NULL)
                <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-warning me-1 data-modal-xl-2 rounded-pill"  data-link="{{ route('contract.show',@$data['idCon']) }}?type={{'PreviewCon'}}"><i class="fas fa-dna"></i> กำลังรอการอนุมติ</a>
            @elseif(($data['DocApp_Con']!=NULL && $data['ConfirmDocApp_Con']!=NULL) && $data['ConfirmApp_Con']!=NULL   )
                <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-success me-1 data-modal-xl-2 rounded-pill px-2"  data-link="{{ route('contract.show',@$data['idCon']) }}?type={{'PreviewCon'}}"><i class="fas fa-gavel"></i> อนุมัติสัญญา</a>
            @else
            <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-success me-1 data-modal-xl-2 rounded-pill px-2" data-link="{{ route('contract.show',@$data['idCon']) }}?type={{'PreviewCon'}}"><i class="fas fa-gavel"></i> อนุมัติสัญญา</a>
            @endif --}}
		<a id="" class="col-xl col-lg col-md col-sm text-center btn btn-outline-success me-1 data-modal-xl-2 rounded-pill px-2" data-link="{{ route('contract.show', @$data['idCon']) }}?type={{ 'PreviewCon' }}">ดูข้อมูลสัญญา <i class="mdi mdi-dresser-outline"></i> </a>
        @if(@$data['Status_Con'] == 'pending')
		    <a id="cancelApprove" class="col-xl col-lg col-md col-sm text-center btn btn-danger btn-rounded waves-effect waves-light me-1 rounded-pill  px-2">ยกเลิกการขออนุมัติ <i class="mdi mdi-close-thick"></i></a>
        @endif


	</div>
</div>

<script>
	$(function() {
		// tooltip js
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
			.forEach(tooltip => {
				new bootstrap.Tooltip(tooltip)
			})


		let arr = [1, 6, 9, 4, 12] // ช่องที่สามารถเว้นว่างได้
		let count = 1
		let e = 0
		let status = ''
		$('#formDocument input[type=checkbox]').each(function() {
			let eleID = $(this).attr('id')
			let coutCheck = $('#' + eleID).prop('checked')
			if (arr.includes(count) == false) {
				if (coutCheck == true) {
					//
				} else {
					//
					return false;
				}
			}
			count++

		});
	})
	// ขออนุมัติพิเศษ
	$('#DateSpecial_Bookcar').on('click',async function() {
        let dataString = $('#arrType').val();

        const TypeSpecial = {};
        dataString.split(',').forEach(item => {
            const [key, value] = item.split(':').map(str => str.trim().replace(/"/g, ''));
            TypeSpecial[key] = value;
        });

        const { value: TypeSpecialVal } = await Swal.fire({
            title: "กรุณาเลือกเงื่อนไขการขออนุมัติพิเศษ",
            input: "select",
            inputOptions: TypeSpecial,
            inputPlaceholder: "เงื่อนไขการขออนุมัติพิเศษ",
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value != "") {
                        resolve();
                        var type = 'SpecialApprove';
                        var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
                        var title = 's';
                        var attName = 's';
                        var elements = '#DateSpecial_Bookcar';
                        var titleSuccess = 'ส่งการขออนุมัติพิเศษ เรียบร้อย';
                        sendLinkUpdate(type, title, attName, elements, titleSuccess ,value);
                    } else {
                        resolve("กรุณาระบุรายการที่ขออนุมัติพิเศษ !");
                    }
                });
            }
        });
	});

	//เช็คเล่มทะเบียน
	$('#DateCheck_Bookcar').on('click', function() {
        let TypeSpecialVal = '';
		var type = 'CheckBookCar';
		var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
		var title = 'กรุณาเพิ่มลิงก์เอกสาร การเช็คเล่มทะเบียน';
		var attName = 'LinkBookcar';
		var elements = '#DateCheck_Bookcar';
		var titleSuccess = 'เช็คเล่มทะเบียน เรียบร้อย';
		sendLinkUpdate(type, title, attName, elements, titleSuccess,TypeSpecialVal);

	});

	//ได้รับเล่มทะเบียน
	$('#Date_BookSpecial').on('click', function() {
        let TypeSpecialVal = '';
		var type = 'approve';
		var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
		var title = 'กรุณาเพิ่มลิงก์เอกสาร ขนส่ง หรือ ที่ดิน ';
		var attName = 'LinkBookSpecial';
		var elements = '#Date_BookSpecial';
		var titleSuccess = 'ทำเครื่องหมายได้รับเล่มทะเบียน เรียบร้อย';
		sendLinkUpdate(type, title, attName, elements, titleSuccess,TypeSpecialVal);

	});

	// checker
	$('#Checkers_Con').click(function() {
        let TypeSpecialVal = '';
		var type = 'checker';
		var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
		var title = 'กรุณาเพิ่มลิงก์การลงพื้นที่ ';
		var attName = 'linkChecker';
		var elements = '#Checkers_Con';
		var titleSuccess = 'บันทึกการลงพื้นที่เรียบร้อย เรียบร้อย';
		sendLinkUpdate(type, title, attName, elements, titleSuccess,TypeSpecialVal);

	});


    // ยกเลิกขออนุมัติ
	$('#cancelApprove').click(function() {
        Swal.fire({
			icon: "warning",
			text: 'ต้องการยกเลิกการขออนุมัติสัญญาใช่หรือไม่ ?',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
		}).then((value) => {
			if (value.isConfirmed == true) {
                let url = '{{ route('contract.update', 'ID') }}'
			        url = url.replace('ID', sessionStorage.getItem('PactCon_id'))
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: url,
					method: "PUT",
					dataType: 'JSON',
					data : {
                        _token : '{{ @CSRF_TOKEN() }}',
                        cancel_app : 'yes',
                        type : 'approve',
						PactCon_id : sessionStorage.getItem('PactCon_id')
                    },
					success: function(res) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        swal.fire({
							icon: 'success',
							title: 'Success !',
							text: 'ยกเลิกการขออนุมัติเรียบร้อย',
							timer: 2000,
						})

                        $('#section-cardCon').html(res.htmlHeader)
                        $('#section-content').html(res.html)
                        $('#section-Tab').html(res.renderTab);

					},
					error: function(err) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        swal.fire({
                            icon : 'error',
                            title : `${ err.responseJSON.message}`,
                            text : `${ err.responseJSON.text}`,
                            showConfirmButton: true,
                        })
					}
				});

			}
		});

	});
</script>

{{-- ลบบุคคลอ้างอิง --}}
<script>
	removeRef = (func,append) => {
		var StatusCon = $('#Status_Con').val();
		var StatusAudit = $('#Status_Audit').val();
		let PactCon_id = sessionStorage.getItem('PactCon_id');
		if (StatusCon == "active" || StatusAudit > 0) {
			let url = '{{ route('contract.update', 'ID') }}'
			url = url.replace('ID', sessionStorage.getItem('PactCon_id'))
			$.ajax({
				url: url,
				type: 'PUT',
				data: {
					PactCon_id: PactCon_id,
					funs: func,
					_token: '{{ @csrf_token() }}'
				},
				success: (res) => {
					if (res.FlagCon == 'fail') {
						swal.fire({
							icon: 'error',
							title: 'Success !',
							text: 'ไม่สามารถนำบุคคลอ้างอิงออกได้ สัญญาอนุมัติเเล้ว',
							timer: 2000,
						})
					} else {
						swal.fire({
							icon: 'success',
							title: 'Success !',
							text: 'ลบบุคคลอ้างอิงออกจากสัญญาเรียบร้อย',
							timer: 2000
						})
						$('#section-cardCon').html(res.htmlHeaderCard)
						$('#'+append).html(res.html)
					}
				},
				error: (err) => {
					swal.fire({
						icon: 'error',
						title: 'ERROR !',
						text: 'ลบบุคคลอ้างอิงออกจากสัญญาไม่สำเร็จ',
						timer: 2000
					})
				}
			})
		} else {
			swal.fire({
				icon: 'error',
				title: `ERROR !`,
				text: `ไม่สามารถนำบุคคลอ้างอิงออกได้ สัญญาอนุมัติเเล้ว`,
				// timer : 2000,
			})
		}
	}
</script>

{{-- function app --}}
<script>
	function sendUpdate(data, url, idName, tital_txt) {
		Swal.fire({
			icon: "warning",
			text: tital_txt,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
		}).then((value) => {
			if (value.isConfirmed == true) {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: url,
					method: "PUT",
					dataType: 'JSON',
					data,

					success: function(data) {
						if (data.status == "success") {
							Swal.fire({
								icon: 'success',
								text: data.text,
								// timer: 2000
							})

							if (data.id == "DocApp_Con") {
								$('.' + data.id).hide();
								$('.cancel_app').show();
							} else if (data.id == "cancel_app") {
								$('.DocApp_Con').show();
								$('.cancel_app').hide();
								$('#DocApp_Con1').val('');
								$('#DocApp_Con').prop("checked", false);
							}

							$('#' + data.id + '1').val(data.textValue);
							$('#' + data.id).prop("checked", true);
							$('#' + data.id).prop("disabled", true);
							$('#section-content').html(data.html)
							$('#section-cardCon').html(data.htmlHeader)
							$('#section-Tab').html(data.renderTab);
							$('.modal').modal('hide')
						} else if (data.status == "error") {
							Swal.fire({
								icon: 'error',
								text: data.text,
								// timer: 1000
							})
							$('#' + idName).prop("checked", false);
						}
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							text: `ไม่สามารถบันทึกข้อมูลได้ ${err.status} โปรดเเจ้ง Programmer`,
							timer: 1500,
							showConfirmButton: false,
						})
					},
					complete: function() {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					}
				});
			} else {
				$('#' + idName).prop("checked", false);
				return false;
			}
		});
	}

	function sendLinkUpdate(type, title, attName, elements, titleSuccess,TypeSpecialVal) {
		console.log(type, title, attName);
		var _token = $('input[name="_token"]').val();
		var idName = $(elements).attr("id");
		var dataid = $(elements).attr("data-id");
		var data = {};
		data[$(elements).attr("id")] = $(elements).val();
		data['type'] = type;
		data['_token'] = _token;
		data['PactCon_id'] = '{{ @$data['idCon'] }}';
        data['BookSpecial_Type'] = TypeSpecialVal;

		var url = "{{ route('contract.update', @$data['idCon']) }}";
		var attrName = attName;

		if (type != 'SpecialApprove') { // ถ้าไม่ใช่ขออนุมัติพิเศษ
			Swal.fire({
					icon: 'warning',
					title: title,
					input: 'text',
					inputAttributes: {
						autocapitalize: 'off'
					},
					showCancelButton: true,
					confirmButtonColor: '#3F7CCF',
					confirmButtonText: 'เพิ่มลิงก์',
					showLoaderOnConfirm: true,
					preConfirm: (attName) => {
						if (attName == '') {
							Swal.showValidationMessage(title)
						} else {
							$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
							data[attrName] = attName;
							$.ajax({
								url: url,
								method: 'PUT',
								dataType: 'JSON',
								data,
								success: function(res) {
									Swal.fire({
										icon: 'success',
										title: 'Suceess !',
										text: titleSuccess,
										timer: 1500
									})
									$('#section-cardCon').html(res.htmlheader)
									$('#section-content').html(res.html)
									$('#section-Tab').html(res.renderTab);
								},
								error: function(err) {
									Swal.fire({
										icon: 'error',
										title: 'ERROR !',
										text: 'ผิดพลาด กรุณาลองใหม่อีกครั้ง',
										timer: 2000
									})
								},
								complete: function() {
									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
								}
							})
						}
					},
				})
				.then((value) => {
					if (value.isConfirmed == true) {
						$('#' + idName).prop("disabled", true);
					} else {
						$('#' + idName).prop("disabled", false);
						$('#' + idName).prop("checked", false);
					}
				});
		} else { // ขออนุมัติพิเศษ ต่างกันที่ไม่มีลิงก์
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			data[attrName] = attName;
			$.ajax({
				url: url,
				method: 'PUT',
				dataType: 'JSON',
				data,
				success: function(res) {
					Swal.fire({
						icon: 'success',
						title: 'Suceess !',
						text: titleSuccess,
						timer: 1500
					})
					$('#section-cardCon').html(res.htmlheader)
					$('#section-content').html(res.html)
					$('#section-Tab').html(res.renderTab);
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: 'ERROR !',
						text: 'ผิดพลาด กรุณาลองใหม่อีกครั้ง',
						timer: 2000
					})
				},
				complete: function() {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
				}
			})
		}
	}

	function ClearApprove(funs) {
		Swal.fire({
			text: "ต้องการนำเครื่องหมายออก ใช่หรือไม่ ?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "ใช่, ต้องการนำออก!"
		}).then((result) => {
			if (result.isConfirmed) {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				let id = sessionStorage.getItem('PactCon_id')
				let url = "{{ route('contract.update', ':ID') }}"
				url = url.replace(':ID', id)
				$.ajax({
					url: url,
					type: 'PUT',
					data: {
						_token: '{{ @CSRF_TOKEN() }}',
						funs: funs,
						PactCon_id: id,
					},
					success: async (res) => {
						await swal.fire({
							icon: 'success',
							title: 'นำเครื่องหมายออกแล้ว',
							timer: 2000,
						})
						$('#section-cardCon').html(res.htmlheader)
						$('#section-content').html(res.html)
						$('#section-Tab').html(res.renderTab);
					},
					error: (err) => {
                        console.log(err);
						    swal.fire({
							icon: 'error',
							title: err.responseJSON.message,
						})
					},
					complete: () => {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					}
				})
			}
		});
	}
</script>

{{-- อนุมัติเคสพิเศษ --}}
<script>
    ApproveSpecialCase = () => {
            var url = "{{ route('contract.update', @$data['idCon']) }}";
            var _token = $('input[name="_token"]').val();
            var idName = "ConfirmDocApp_Con";
            var data = {};
            data['ConfirmDocApp_Con'] = '{{ auth()->user()->id }}';
            data['type'] = 'approve';
            data['_token'] = _token;
            data['PactCon_id'] = '{{ @$data['idCon'] }}';
            var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
            sendUpdate(data, url, idName, tital_txt);


    }
</script>


