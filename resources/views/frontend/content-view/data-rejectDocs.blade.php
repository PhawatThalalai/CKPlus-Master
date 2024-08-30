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
	</div>

	<div class="card-body my-0 px-2">
		<form id="send_docForm">
			@csrf
			<div class="table-responsive">
				<table class="table align-middle table-hover text-nowrap border border-light font-size-12 dateHide view-sendcont">
					<thead class="">
						<tr class="bg-light">
							<th class="text-center" style="width: 5%"></th>
							<th class="text-center">เลขสัญญา</th>
							<th class="text-center">ประเภทสินเชื่อ</th>
							<th class="text-center">ชื่อลูกค้า</th>
							<th class="text-center">วันที่แจ้ง</th>
							<th class="text-center">สถานะ</th>
							<th class="text-center" style="width: 8%">#</th>
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
								<td class="">
									<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
										<i class="bx bx-calendar-event text-success"></i>
									</button>
									<span class="">{{ date('d-m-Y', strtotime($row->date_TrackPart)) }}</span>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-outline-danger btn-sm btn-rounded waves-effect waves-light">
										<i class="mdi mdi-file-question me-1"></i> {{ @$row->name_th }}
									</button>
								</td>
								<td class="text-center">
									<ul class="list-inline font-size-20 contact-links mb-0">
										<li class="list-inline-item px-2" data-bs-toggle="tooltip" title="รายละเอียด">
											<a href="{{ route('audit.edit', $row->id) }}?page={{ 'auditCheckContent' }}" class="hover-up"><i class="mdi mdi-file-document-edit text-info"></i></a>
										</li>
									</ul>
								</td>
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
