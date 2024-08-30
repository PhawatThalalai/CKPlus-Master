<div id="btn_RevicedGroup" class="clearfix mb-1" style="display: none;">
	<div class="dropdown float-end">
		<a role="button" id="btn_receivedDoc" class="btn btn-success btn-sm waves-effect waves-light hover-up">รับเอกสาร</a>
		<button class="btn btn-light btn-sm hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="mdi mdi-dots-vertical"></i>
		</button>
		<div class="dropdown-menu dropdown-menu-end" style="">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<a class="dropdown-item" href="#">Something else</a>
		</div>
	</div>
</div>
<div class="table-responsive" data-simplebar="init" style="max-height: 350px;">
	<form id="auditDoc_form">
		@csrf
		<input type="hidden" id="branch_id" value="{{@$branch_id}}">

		<table class="table align-middle table-hover text-nowrap border border-light font-size-12 dateHide">
			<thead class="">
				<tr class="bg-light">
					<th class="text-center" style="width: 5%"></th>
					<th class="text-center">เลขสัญญา</th>
					<th class="text-center">ประเภทสินเชื่อ</th>
					<th class="text-center">ผู้นำส่ง</th>
					<th class="text-center">ส่งโดย</th>
					<th class="text-center">วันที่นำส่ง</th>
					<th class="text-center">ระยะเวลา</th>
					<th class="text-center" style="width: 8%">
						<div class="d-flex align-items-center">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="audit_selectAll" />
								<label class="form-check-label fw-semibold" for="audit_selectAll">
									Select All
								</label>
							</div>
						</div>
					</th>
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
							<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
								<i class="bx bx-user-circle text-info"></i>
							</button>
							<span class="">{{ @$row->nameTagpart }}</span>
						</td>
						<td> 
							<h5 class="font-size-13 mb-1"><a role="button" class="text-dark" data-bs-toggle="tooltip" title=""> {{ @$row->Send_by }}</a></h5>
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">หมายเหตุ : {{ @$row->ems_detail!=NULL?@$row->ems_detail:@$row->message_send }}</span>
						</td>
						<td>
							<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
								<i class="bx bx-calendar-event text-success"></i>
							</button>
							<span class="">{{ date('d-m-Y', strtotime($row->date_TrackPart)) }}</span>
						</td>
						<td class="text-center">
							@php
								$createdDate = \Carbon\Carbon::parse($row->createdTagpart)->locale('th_TH');
								$diffForHumans = $createdDate->diffForHumans();
							@endphp

							<button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light">
								<i class="bx bxs-bell bx-tada"></i>
							</button>
							<ins class="text-danger">{{ @$diffForHumans }}</ins>
						</td>
						<td class="text-center">
							<input type="checkbox" id="auditCont_{{ @$row->tag_id }}" name="auditCont[]" value="{{ @$row->tag_id }}" class="form-check-input font-size-14 checkbox-auditCont">
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</form>
</div>

<script>
	$('#btn_receivedDoc').click(function() {
		let branch = $('#branch_id').val();
		var auditCont = [];

		var avalableCont = 0;
		$('#auditDoc_form input.checkbox-auditCont').each(function() {
			if ($(this).prop('checked')) {
				auditCont.push($(this).val());
			} else {
				avalableCont ++;
			}
		});

		if (auditCont != '') {
			$(".loading-overlay").fadeIn().attr('style', '');
			$.ajax({
				url: "{{ route('audit.store') }}",
				method: "post",
				data: {
					_token: "{{ @csrf_token() }}",
					page: 'received-document',
					auditCont: auditCont,
				},

				success: function(result) {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important');
					if (avalableCont != 0) {
						$('#countDoc_'+branch).html('<i class="mdi mdi-email-plus up-down me-1"></i>เอกสารใหม่ '+avalableCont+' รายการ');

						// udpate countReceived-all
						let countReceived = $('.countReceived-all').text();
						if (countReceived == '') {
							countReceived = 0;
						}

						$('.countReceived-all').html(parseFloat(countReceived) - parseFloat(auditCont.length));
					}else{
						$('.div-countDoc-'+branch).slideDown().html('<span class="text-secondary text-opacity-50"><em>-- ว่าง --</em></span>');
					}

					// udpate countDoc to branch
					let countCont = $('.countBranch-'+branch).eq(1).text();
					if (countCont == '') {
						countCont = 0;
					}
					$('.countBranch-'+branch).html(parseFloat(countCont) + parseFloat(auditCont.length));
					$('#content-BranchReceive').slideUp('slow');

					Swal.fire({
						icon: 'success',
						text: result.message,
						showConfirmButton: false,
						timer: 1500
					});
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				},
				complete: function() {
					$('.card-branch').removeClass('selected-card');
				}
			});
		} else {
			Swal.fire({
				icon: 'warning',
				text: 'กรุณาเลือกสัญญาข้างต้น ก่อนจัดส่งเอกสาร !',
				showConfirmButton: true,
				timer: 1500
			});
		}
	});

	$("#audit_selectAll").change(function() {
		if ($(this).prop("checked")) {
			$('input[type="checkbox"]').prop('checked', $(this).prop("checked"));
		} else {
			$(".checkbox-auditCont").prop("checked", false);
		}

		// เพิ่มการเรียกฟังก์ชันตรวจสอบเพื่อแสดง/ซ่อนปุ่ม
		checkSelectedItems();
	});

	$(".checkbox-auditCont").change(function() {
		if ($(".checkbox-auditCont:checked").length === $(".checkbox-auditCont").length) {
			$("#audit_selectAll").prop("checked", true);
		} else {
			$("#audit_selectAll").prop("checked", false);
		}

		// เพิ่มการเรียกฟังก์ชันตรวจสอบเพื่อแสดง/ซ่อนปุ่ม
		checkSelectedItems();
	});

	function checkSelectedItems() {
		var anyItemSelected = $('#auditDoc_form input.checkbox-auditCont:checked').length > 0;
		if (anyItemSelected) {
			$('#btn_RevicedGroup').slideDown();
		} else {
			$('#btn_RevicedGroup').slideUp();
		}
	}
	$('[data-bs-toggle="tooltip"]').tooltip();
</script>
