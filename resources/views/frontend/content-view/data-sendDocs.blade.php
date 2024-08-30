<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<div class="card p-2 h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			<img class="" src="{{ URL::asset('assets/images/gif/layers.gif') }}" alt="" style="width: 50px">
		</div>
		<div class="flex-grow-1 overflow-hidden border-primary border-bottom">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">{{ @$title }} </h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}" data-nameBranh="{{ @$dataBranch2->Name_Branch }}">
		</div>
		<div class="flex-shrink-1 border-primary border-bottom">
			<button type="button" id="SendDocContract" class="btn btn-success hover-up btn-sm data-modal-xl-2" data-link="{{ route('audit.create') }}?page={{ 'select-Contracts' }}&branch={{ @$dataBranch2->id }}">
				<i class="mdi mdi-email-send-outline me-1"></i> ส่งเอกสาร
			</button>
			<button type="button" id="SendContHistory" class="btn btn-outline-secondary btn-sm hover-up">
				<i class="mdi mdi-file-clock me-1"></i> ประวัติการส่ง <span class="badge bg-success ms-1">{{ @$countCont }} </span>
			</button>
		</div>
	</div>

	<div class="card-body">
		<input type="hidden" id="userRole" value="{{ $Approve }}">
		<form id="send_docForm">
			@csrf
			<div class="table-responsive">
				<table class="table align-middle table-hover text-nowrap border border-light font-size-12 dateHide view-sendcont">
					<thead class="">
						<tr class="bg-light">
							<th class="text-center" style="width: 5%"></th>
							<th class="text-center">เลขสัญญา</th>
							<th class="text-center">ประเภทสินเชื่อ</th>
							<th class="text-center">วันที่โอนเงิน</th>
							<th class="text-center">ชื่อลูกค้า</th>
							<th class="text-center">รุ่นรถ/ประเภท</th>
							<th class="text-center">ทะเบียน/ทีดิน</th>
							<th class="text-center">สถานะเอกสาร</th>
							{{-- <th class="text-center" style="width: 8%">
								<div class="d-flex align-items-center">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="selectAll" />
										<label class="form-check-label fw-semibold" for="selectAll">
											Select All
										</label>
									</div>
								</div>
							</th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $row)
							<tr id="row{{ @$row->id }}">
								<td class="text-center">
									<div class="d-flex justify-content-center">
										<div class="flex-shrink-0 me-3">
											<div class="avatar-xs">
												@if (!empty(@$row->image_cus))
													<img class="avatar-title rounded-circle" src="{{ URL::asset(@$row->image_cus) }}" alt="">
												@else
													<div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
														{{ @$row->CodeLoan_Con }}
													</div>
												@endif
											</div>
										</div>
									</div>
								</td>
								<td>
									<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$row->Contract_Con }}</a></h5>
									@if (@$row->Status_Con == 'cancel')
										<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกสัญญา</span>
									@else
										<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : {{ @$row->StatusApp_Con }}</span>
									@endif
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
										{{ @$row->Loan_Name }}
									</button>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light  cl-reject" data-id="{{ @$row->id }}" data-reject="{{ @$row->Flag_Reject }}" data-bs-toggle="tooltip" title="{{ $row->Flag_Reject == 'y' ? 'เลยกำหนด' : '' }}">
										<i class="bx bx-calendar-event text-success {{ @$row->Flag_Reject == null ? '' : 'd-none' }} calendar{{ @$row->id }}"></i>

										<i class="bx bx-error text-danger bx-tada fs-4 {{ @$row->Flag_Reject == null ? 'd-none' : '' }} error{{ @$row->id }}"></i>

									</button>
									<span class="" data-bs-toggle="tooltip" title="ส่งเอกสาร :: {{ @$row->date_send }}">{{ date('d-m-Y', strtotime($row->Date_monetary)) }}</span>
								</td>
								<td class="">
									<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
								</td>
								<td> {{ @$row->brand }} </td>
								<td> {{ @$row->licence }} </td>
								<td><i class="bx bx-error text-danger bx-tada fs-4 {{ @$row->auditReject == null ? 'd-none' : '' }} error{{ @$row->id }}" data-bs-toggle="tooltip" title="{{ @$row->auditReject == 'y' ? 'Reject' : '' }}"></i> {{ @$row->Flag_Status != null ? @$row->name_th : 'สาขา' }} </td>
								{{-- <td class="text-center">
									<input type="checkbox" id="Branch_Sentdoc{{ @$row->id }}" name="Branch_Sentdoc[]" value="{{ @$row->id }}" class="form-check-input checkbox-item font-size-14">
								</td> --}}
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		var table = $('.view-sendcont').DataTable({
			"drawCallback": function() {
				var position1Th = $('.view-sendcont thead th:nth-child(1)');
				var position2Th = $('.view-sendcont thead th:nth-child(2)');
				position2Th.attr('colspan', 2);
				position1Th.hide();
			},
			"responsive": false,
			"autoWidth": false,
			"ordering": true,
			"lengthChange": true,
			"order": [
				[1, "asc"]
			],
			"pageLength": 10,
		});
	});
</script>

<script>
	$('.cl-reject').click(function() {
		var id = $(this).attr('data-id');
		var reject = $(this).attr('data-reject');
		let urltxt = "{{ route('audit.update', 'ID') }}";
		let url = urltxt.replace('ID', id);
		let userRole = $('#userRole').val();

		if (reject == 'y' && userRole > 0) {
			Swal.fire({
				title: 'ต้องการยกเลิก Reject หรือไม่?',
				text: "",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่, ต้องการยกเลิก !'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: url,
						method: "PUT",
						data: {
							_token: "{{ @csrf_token() }}",
							page: 'update-reject',
						},
						success: function(result) {
							swal.fire({
								icon: 'success',
								title: 'Success !',
								text: 'ยกเลิก Reject เรียบร้อย',
								timer: 2000,
							})
							$('.calendar' + id).removeClass('d-none');
							$('.error' + id).addClass('d-none');
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						}
					});
				}
			});
		}

	});

	// $('#SendDocContract').click(function() {
	// 	var nameBranch = $('#id_branch').attr('data-nameBranh');
	// 	var idcont = [];
	// 	$('#send_docForm input.checkbox-item').each(function() {
	// 		if ($(this).prop('checked')) {
	// 			idcont.push($(this).val());
	// 		}
	// 	});

	// 	if (idcont != '') {
	// 		$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
	// 		$.ajax({
	// 			url: "{{ route('audit.store') }}",
	// 			method: "post",
	// 			data: {
	// 				_token: "{{ @csrf_token() }}",
	// 				page: 'select-Contracts',
	// 				idcont: idcont,
	// 				nameBranch: nameBranch,
	// 			},

	// 			success: function(result) {
	// 				$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

	// 				$('#modal_xl_2 .modal-dialog').html(result.html);
	// 				$('#modal_xl_2').modal('show');
	// 			},
	// 			error: function(err) {
	// 				Swal.fire({
	// 					icon: 'error',
	// 					title: `ERROR ` + err.status + ` !!!`,
	// 					text: err.responseJSON.message,
	// 					showConfirmButton: true,
	// 				});
	// 			}
	// 		});
	// 	} else {
	// 		Swal.fire({
	// 			icon: 'warning',
	// 			text: 'กรุณาเลือกสัญญาข้างต้น ก่อนจัดส่งเอกสาร !',
	// 			showConfirmButton: true,
	// 			timer: 1500
	// 		});
	// 	}
	// });

	// $("#selectAll").change(function() {
	// 	if ($(this).prop("checked")) {
	// 		$('input[type="checkbox"]').prop('checked', $(this).prop("checked"));
	// 		// $(".checkbox-item").prop("checked", $(this).prop("checked"));
	// 	} else {
	// 		$(".checkbox-item").prop("checked", false);
	// 	}
	// });

	// Individual checkboxes
	// $(".checkbox-item").change(function() {
	// 	if ($(".checkbox-item:checked").length === $(".checkbox-item").length) {
	// 		$("#selectAll").prop("checked", true);
	// 	} else {
	// 		$("#selectAll").prop("checked", false);
	// 	}
	// });
</script>
