<style>
	/* width */
	::-webkit-scrollbar {
		width: 5px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		box-shadow: inset 0 0 5px grey;
		border-radius: 10px;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #959696;
		border-radius: 10px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #b30000;
	}
</style>
<div id="ModalConstants" class="modal-content">
	<input type="hidden" id="modalID" value="#{{ $modalID }}">

	<div class="modal-header bg-info bg-soft">
		<h5 class="modal-title fw-semibold" id="exampleModalScrollableTitle">{{ @$title }}</h5>
		<button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#{{ @$modalID }}" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>

	<div class="modal-body">
		@if (count(@$data) != 0)
			@if (@$FlagBtn == 'OLDSTAT' or @$FlagBtn == 'NEWSTAT' or @$FlagBtn == 'CONTSTAT')
				<div class="table-responsive textSize-13" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm table-search" cellspacing="0" width="100%">
						<thead class="bg-light sticky-top">
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-left">สถานะ</th>
								<th class="text-left">รายละเอียด</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->CONTTYP }}</td>
									<td class="text-left">{{ $value->CONTDESC }}</td>
									<td class="text-center">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'FOLCODE' or @$FlagBtn == 'SALECODE')
				<div style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-sm table-FOLCODE" cellspacing="0" width="100%">
						<thead class="bg-light sticky-top">
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-left">รหัส</th>
								<th class="text-left">ชื่อ-สกุล</th>
								<th class="text-left">แผนก</th>
								<!-- <th class="text-center">เข้าระบบ</th> -->
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->id }}</td>
									<td class="text-left">{{ $value->name }}</td>
									<td class="text-left">{{ $value->type }}</td>
									<!-- <td class="text-center">{{ date('d-m-Y', strtotime($value->created_at)) }}</td> -->
									<td class="text-center">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'PAYTYP')
				<div class="px-2" data-simplebar="init" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm" cellspacing="0" width="100%">
						<thead class="bg-light sticky-top" style="line-height: 250%;">
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-left">รหัส</th>
								<th class="text-left">รายละเอียด</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->PAYCODE }}</td>
									<td class="text-left">{{ $value->PAYDESC }}</td>
									<td class="text-right">
										<button class="btn btn-success btn-sm" title="เลือกรายการ" data-bs-toggle="modal" data-bs-target="#{{ @$modalID }}" data-bs-dismiss="modal">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'PAYFOR')
				<div class="px-2" data-simplebar="init" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm" cellspacing="0" width="100%">
						<thead class="bg-light sticky-top" style="line-height: 250%;">
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-left">รหัส</th>
								<th class="text-left">รายละเอียด</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->FORCODE }}</td>
									<td class="text-left">{{ $value->FORDESC }}</td>
									<td class="text-right">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'PAYBY')
				<div class="table-responsive textSize-13" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm table-PAYBY" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-left">รหัส</th>
								<th class="text-left">รายละเอียด</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->PAYCODE }}</td>
									<td class="text-left">{{ $value->PAYDESC }}</td>
									<td class="text-right">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'PAYINACC')
				<div class="table-responsive textSize-13" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-center">รหัสบัญชี</th>
								<th class="text-center">ชื่อบัญชี</th>
								<th class="text-center">ธนาคาร</th>
								<th class="text-center">เลขบัญชี</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-center">{{ $value->id }}</td>
									<td class="text-left">{{ $value->company_bank }}</td>
									<td class="text-left">{{ $value->Account_Bank }}</td>
									<td class="text-left">{{ $value->Account_Number }}</td>
									<td class="text-center">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'LOCAT')
				<div class="table-responsive textSize-13" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm table-striped" cellspacing="0" width="100%">
						<thead class="table-light" style="position: sticky; top: 0px;">
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-center">เลขที่สาขา</th>
								<th class="text-center">รหัสสาขา</th>
								<th class="text-center">ชื่อสาขา</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center"><strong>{{ $key + 1 }}</strong></td>
									<td class="text-center">{{ $value->id }}</td>
									<td class="text-center">{{ $value->NickName_Branch }}</td>
									<td class="text-left">{{ $value->Name_Branch }}</td>
									<td class="text-center">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
							<tr id="999" class="btn_id">
								<td class="text-center"></td>
								<td class="text-center">999</td>
								<td class="text-center">ALL</td>
								<td class="text-left">ทั้งหมด</td>
								<td class="text-center">
									<button class="btn btn-success btn-sm" title="เลือกรายการ">
										<i class="dripicons-checkmark"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			@elseif(@$FlagBtn == 'USERS')
				<div class="table-responsive textSize-13" style="max-height: 450px;">
					<table class="table align-middle table-hover table-bordered table-nowrap table-sm" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-center">user</th>
								<th class="text-left">ชื่อ-สกุล</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $key => $value)
								<tr id="{{ $value->id }}" class="btn_id">
									<td class="text-center">{{ $key + 1 }}</td>
									<td class="text-left">{{ $value->username }}</td>
									<td class="text-left">{{ $value->name }}</td>
									<td class="text-right">
										<button class="btn btn-success btn-sm" title="เลือกรายการ">
											<i class="dripicons-checkmark"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		@else
			<div class="error-page pt-3">
				<div class="row">
					<div class="col-12 col-lg-4">
						<h1 class="headline text-center text-danger"> 404 </h1>
					</div>
					<div class="col-12 col-lg-8">
						<div class="error-content">
							<h5><i class="fas fa-exclamation-triangle text-danger prem"></i> ข้อมูลไม่ถูกต้อง ไม่พบข้อมูลที่ค้นหา.!!</h5>
							<p class="textSize-13">
								โปรดตรวจสอบข้อมูลธนาคาร หรือสอบถาม<span class="text-info"> เจ้าหน้าที่.</span><br>
							</p>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>

{{-- Select data from Popup --}}
<script>
	$(function() {
		$(".btn_id").on('click', function() {
			var FlagPage = $('#FlagPage').val();
			var FlagBtn = '{{ $FlagBtn }}';
			var modalID = $('#modalID').val();
			let BILLDT = $('#BILLDT').val()
			var getCode = $(this).find("td:eq(1)").text();
			var getName = $(this).find("td:eq(2)").text();
			var getNumber = $(this).find("td:eq(3)").text();
			var getNumberBank = $(this).find("td:eq(4)").text();
			let payTypValue = $('#PAYTYP_CODE').val()


			if (getCode != '' && getName != '') {
				if (FlagBtn == 'OLDSTAT') {
					$('#OLDCODE').val(getCode);
					$('#OLDCODE').removeClass('is-invalid', true);
					$('#OLDNAME').val(getName);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'NEWSTAT') {
					$('#NEWCODE').val(getCode);
					$('#NEWCODE').removeClass('is-invalid', true);
					$('#NEWNAME').val(getName);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'CONTSTAT') {
					$('#CONTSTAT').val(getCode);
					$('#CONTSTAT').removeClass('is-invalid', true);
					$('#CONTDESC').val(getName);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'FOLCODE') {
					$('#FOLLOWCODE').val(getCode);
					$('#FOLLOWCODE').removeClass('is-invalid', true);
					$('#FOLLOWNAME').val(getName);

					$('.modal').modal('hide');
				} else if (FlagBtn == 'SALECODE') {
					$('#SALECODE').val(getCode);
					$('#SALECODE').removeClass('is-invalid', true);
					$('#SALENAME').val(getName);

					$('.modal').modal('hide');
				} else if (FlagBtn == 'PAYTYP') {
					$('.PAYTYP_CODE').val(getCode);
					$('.PAYTYP_CODE').removeClass('is-invalid', true);
					$('.PAYTYP_NAME').val(getName);

					$('#modal_sd').modal('hide');


				} else if (FlagBtn == 'PAYFOR') {
					$('.PAYFOR_CODE').val(getCode);
					$('.PAYFOR_CODE').removeClass('is-invalid', true);
					$('.PAYFOR_NAME').val(getName);

					$('#modal_sd').modal('hide');
					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'PAYINACC') {
					$('.PAYINACC_CODE').val(getCode);
					$('.PAYINACC_CODE').removeClass('is-invalid', true);
					$('.PAYINACC_NAME').val(getName);
					$('.BANKNAME').val(getNumber);
					$('.PAYINACC_NUMBER').val(getNumberBank);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'LOCAT') {
					$('.LOCAT').val(getName);
					$('.LOCAT').removeClass('is-invalid', true);
					$('.LOCATNAME').val(getNumber);
					$('.ID_LOCAT').val(getCode);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'USERS') {
					$('.USERS').val(getCode);
					$('.USERS').removeClass('is-invalid', true);
					$('.USERSNAME').val(getName);

					$('#modal_lg').modal('hide');
					$('.modal').modal('hide');
				} else if (FlagBtn == 'PAYBY') {
					$('#PAYBY').val(getCode);
					$('#PAYBY').removeClass('is-invalid', true);
					$('#PAYBYNAME').val(getName);
				} else {

				}

				$(".toast-success").toast({
					delay: 1300
				}).toast("show");
				$(".toast-success .toast-body .text-body").text('ดำเนินการสำเร็จ !');

				console.log(modalID);
				// $(modalID).modal('toggle');
				$(modalID).modal('show');
				// $('#Modal-xl-2').modal('hide');
			}
		});
	})
</script>

<script>
	$(".table-FOLCODE,.table-PAYBY").DataTable({
		destroy: true,
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"autoWidth": false,
		"order": [
			[0, "asc"]
		],
		"pageLength": 7,
	});
</script>
