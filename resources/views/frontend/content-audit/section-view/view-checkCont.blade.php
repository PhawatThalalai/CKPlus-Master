@extends('layouts.master')
@section('title', 'check documents')
@section('audit-active', 'mm-active')
@section('auditCheck-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		.list-checkdoc {
			width: 20px;
			/* Adjust the width of the entire radio button */
			height: 20px;
			/* Adjust the height of the entire radio button */
		}
	</style>
	<style>
		/* Custom style swal to adjust text font size */
		.highlight-text-style {
			color: rgb(12, 180, 12);
			text-decoration: underline;
		}
		.highlight-text-alert {
			color: rgb(235, 96, 4);
			text-decoration: underline;
		}

		.text-title {
			font-size: 0.9rem;
		}
	</style>

	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>


	@include('components.content-search.view-search', ['page_type' => @$page_type, 'page' => @$page, 'pageUrl' => @$pageUrl, 'typeSreach' => @$typeSreach, 'dataSreach' => @$dataSreach])
	@include('frontend.content-con.view-headerCon')
	@include('components.content-toast.view-toast')

	<div class="card" id="card_default" style="display:{{ $audit->Flag_Status != 2 ? 'none' : '' }};">
		<div class="card-body">
			<div class="row"> 
				<div class="col-xl-4 col-lg-3 col-md-6 col-sm-12">
					<div>
						<img src="{{ URL::asset('assets/images/crypto/features-img/img-1.png') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 280px;">
					</div>
				</div>
				<div class="col-xl-8 col-lg-9 col-md-6 col-sm-12">
					<div class="h-100">
						<div class="px-4 border-bottom">
							<div class="row">
								<div class="col">
									<h5 class="font-size-15 mb-1 fw-semibold text-primary"><i class="bx bxs-chat"></i> รายละเอียดเอกสาร (Document details)</h5>
								</div>
							</div>
							<div class="row mt-1 mb-0">
								<div class="mt-4 mt-md-auto">
									<div class="d-flex align-items-center mb-2">
										<div class="features-number fw-semibold display-4 me-3">สถานะ</div>
										<h4 class="mb-0 text-success up-down">{{ @$audit->StatusAudit->name_th }}</h4>
									</div>
									<p class="text-muted">
										<ins>รายละเอียดการนำส่ง</ins>
										<span> : {{ @$audit->message_send }}</span>
									</p>
									<div class="text-muted mt-4">
										<p class="mb-2">
											<i class="mdi mdi-account-circle text-success me-1"></i>ผู้นำส่งเอกสาร : {{ @$audit->auditTaguserInt->name }}
										</p>
										<p>
											<i class="mdi mdi-calendar text-success me-1"></i>วันที่นำส่งเอกสาร : {{ date('d-m-Y H:i:s', strtotime(@$audit->date_send)) }}
										</p>
									</div>
								</div>
								<div class="d-flex justify-content-center mb-2">
									<button type="button" id="btn_auditCheck" class="btn btn-primary btn-rounded w-lg w-50 waves-effect waves-light" data-PactID="{{ @$data->id }}" data-auditID="{{ @$audit->id }}">
										<i class="mdi mdi-file-document-edit-outline me-1"></i> ตรวจสอบเอกสาร
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card" id="card_showdata" style="display:{{ $audit->Flag_Status == 2 ? 'none' : '' }};">
		<div class="card-body">
			<div class="row">
				<div class="col-xl-5 col-lg-12 col-md-12">
					<div class="mb-2" id="content_checklist">
						@include('frontend.content-audit.section-data.data-listCheckCont')
					</div>
				</div>
				<div class="col-xl-7 col-lg-12 col-md-12">
					<div class="h-100">
						<div class="px-4 border-bottom">
							<div class="row">
								<div class="col">
									<h5 class="font-size-15 mb-1 fw-semibold text-primary"><i class="bx bxs-chat"></i> รายละเอียดเอกสาร (Document details)</h5>
								</div>
							</div>
							<div class="row mt-1 mb-0" id="content_status">
								@if ($audit->Flag_Status != 2)
									@include('frontend.content-audit.section-data.data-statusDoc')
								@endif
							</div>
							<div>
								<div id="content_massages" class="p-3">
									@if ($audit->Flag_Status != 2)
										@include('frontend.content-audit.section-data.data-chatContent')
									@endif
								</div>
								<div class="p-3 chat-input-section">
									{{-- <form id="formChat"> --}}
									<div class="row">
										<div class="col">
											<div class="position-relative">
												<input type="text" name="Detail_TrackPart" id="Detail_TrackPart" class="form-control chat-input" placeholder="รายละเอียด" autocomplete="off">
												<div class="chat-input-links" id="tooltip-container">
													<ul class="list-inline mb-0">
														<li class="list-inline-item"><a href="javascript: void(0);" title="Emoji"><i class="mdi mdi-emoticon-happy-outline"></i></a></li>
														<li class="list-inline-item"><a href="javascript: void(0);" title="Images"><i class="mdi mdi-file-image-outline"></i></a></li>
														<li class="list-inline-item"><a href="javascript: void(0);" title="Add Files"><i class="mdi mdi-file-document-outline"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="col-auto">
											<button type="button" id="btn_sendMassages" data-PactID="{{ $data->id }}" data-auditID="{{ $audit->id }}" class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light" data-bs-toggle="tooltip" title="ส่งข้อความ">
												<span class="d-none d-sm-inline-block me-2">Send</span>
												<span class="addSpin"><i class="mdi mdi-send"></i></span>
											</button>
											<button type="button" id="btn_refresh" data-auditID="{{ $audit->id }}" class="btn btn-light btn-rounded chat-send waves-effect waves-light" data-bs-toggle="tooltip" title="Refresh">
												<i class="mdi mdi-refresh addSpin-refresh"></i>
											</button>
										</div>
									</div>
									{{-- </form> --}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" name="Flag_Status" id="Flag_Status" value="{{ @$audit->Flag_Status }}">
	<input type="hidden" name="audit_id" id="audit_id" value="{{ @$audit->id }}">
	<input type="hidden" name="count_tagpart" id="count_tagpart" value="{{ @$audit->auditTagToTagpart->count() }}">

	<script>
		$(document).ready(function() {
			var Flag_Status = $('#Flag_Status').val();
			if (Flag_Status == 7) {
				$('#listCheck input[type="radio"]').attr('disabled', true);
				$('#btn_sendMassages,#Detail_TrackPart').attr('disabled', true);
			}
		});

		$('#btn_auditCheck').click(function(event) {
			let Pact_id = $(this).attr('data-PactID');
			let audit_id = $(this).attr('data-auditID');
			let count_tagpart = $('#count_tagpart').val();

			event.preventDefault();
			$(".loading-overlay").fadeIn().attr('style', '');

			$.ajax({
				url: "{{ route('audit.store') }}",
				type: 'post',
				data: {
					page: 'send-message',
					Pact_id: Pact_id,
					audit_id: audit_id,
					Flag_Status: 2,
					count_tagpart:count_tagpart,
					_token: "{{ @csrf_token() }}",
				},
				success: function(result) {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important');
					$('#Detail_TrackPart').val('');
					$('#Flag_Status').val(result.Flag_Status);

					$('#card_default').slideUp('slow');
					$('#card_showdata').slideDown('slow');
					$('#content_status').html(result.view_status);
					$('#content_massages').html(result.view_massage);

					$('#count_tagpart').val(result.count_tagpart );
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
		});

		$('#btn_refresh').click(function(event) {
			event.preventDefault();
			let audit_id = $(this).attr('data-auditID');

			refreshFn(audit_id);
		});

		$('#Detail_TrackPart').on('keypress', function(e) {
			if (e.key === 'Enter') {
				// Focus on btn_sendMassages
				$('#btn_sendMassages').focus();
				// Trigger click event on btn_sendMassages
				$('#btn_sendMassages').click();
			}
		});

		$('#btn_sendMassages').click(function(event) {
			event.preventDefault();

			const Pact_id = $(this).attr('data-PactID');
			const audit_id = $(this).attr('data-auditID');
			var Flag_Status = $('#Flag_Status').val();
			const Detail_TrackPart = $('#Detail_TrackPart').val();
			const radiosData = {};

			const classes = ['check-edit', 'check-edited', 'check-complete'];
			classes.forEach(className => {
				const radios = $(`#listCheck input[type="radio"].${className}:checked`).map(function() {
					return $(this).val();
				}).get();
				radiosData[className] = radios;
			});

			const checklistNull = $('#listCheck tbody').find('tr').filter(function() {
				return $(this).find('input[type="radio"]:checked').length === 0;
			}).length === 0;

			if (Detail_TrackPart !== '' && checklistNull) {
				$('#listCheck input[type="radio"]').attr('disabled', true);
				$(this).attr('disabled', true).find('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status"></span>');

				let Listquestion = false;
				let comState = false;
				let textSwal = '';

				if (radiosData['check-edit'].length != 0) {
					Listquestion = true;
				} else if (radiosData['check-edited'].length != 0 && Flag_Status != 5 && Flag_Status != 6) {
					Flag_Status = 5;
					textSwal = '<span class="text-title"><span class="highlight-text-style">เอกสารได้รับการแก้ไขหมดแล้ว</span> ระบบจะทำการเปลี่ยนสถานะให้ทันที.</span>';
				} else if (radiosData['check-complete'].length != 0 && Flag_Status != 6) {
					// เช็ตสิทธิ์การเข้าถึงข้อมูล
					/* if (checkPermission('audit', 'edit')) {
						Flag_Status = 6;
					} else {
						Flag_Status = 5;
					} */
					
					Flag_Status = 6;
					textSwal = '<span class="text-title"><span class="highlight-text-style">เอกสารครบสมบูรณ์</span> ระบบจะทำการเปลี่ยนสถานะให้ทันที.</span>';
				} else {
					comState = true;
				}

				if (Listquestion && Flag_Status != 4) {
					Swal.fire({
						icon: 'question',
						title: 'แจ้งเตือนจากระบบ',
						text: 'ตรวจพบรายการ แก้ไข คุณต้องการนำส่งสัญญาเพื่อแก้ไขหรือไม่ ?',
						showCancelButton: true,
						showDenyButton: true,
						confirmButtonColor: '#4fc3f7',
						denyButtonColor: '#e84e40',
						cancelButtonColor: '#bdbdbd',
						confirmButtonText: 'ใช้',
						denyButtonText: 'ไม่ใช้',
						cancelButtonText: 'ยกเลิก',
						allowOutsideClick: false,
						allowEscapeKey: false
					}).then(result => {
						if (result.isConfirmed || result.isDenied) {
							if (result.isConfirmed) {
								Flag_Status = 4;
							}
							callMassages(Pact_id, audit_id, Flag_Status, radiosData);
						} else {
							resetForm();
						}
					});
				} else {
					// if ((Flag_Status == 5 || Flag_Status == 6) && !comState) {
					// 	Swal.fire({
					// 		icon: 'question',
					// 		title: 'แจ้งเตือนจากระบบ',
					// 		html: textSwal,
					// 		showCancelButton: true,
					// 		confirmButtonColor: '#4fc3f7',
					// 		cancelButtonColor: '#bdbdbd',
					// 		confirmButtonText: 'ตกลง',
					// 		cancelButtonText: 'ยกเลิก',
					// 		allowOutsideClick: false,
					// 		allowEscapeKey: false
					// 	}).then(result => {
					// 		if (result.isConfirmed) {
					// 			callMassages(Pact_id, audit_id, Flag_Status, radiosData);
					// 		} else {
					// 			resetForm();
					// 		}
					// 	});
					// } else {
					callMassages(Pact_id, audit_id, Flag_Status, radiosData);
					// }
				}
			} else {
				const errorMessage = checklistNull ? 'กรุณา ระบุรายละเอียดก่อนบันทึก !' : 'กรุณา ตรวจสอบรายการทั้งหมดก่อนลงบันทึก !';
				showErrorSwal(errorMessage);
			}
		});

		$('.check-edit,.check-edited,.check-complete').click(function(event) {
			if ($(this).hasClass('check-edit') || $(this).hasClass('check-complete')) {
				var checkrole = '{{ roleAuditcheckLists() }}'
				if (checkrole != 'enabled') {
					event.preventDefault();
					showErrorSwal('คุณไม่มีสิทธิ์ในการแก้ไขข้อมูลดังกล่าว');

					return false;
				}
			} else if ($(this).hasClass('check-edited')) {
				var checkrole = '{{ roleAuditothercheckLists() }}'
				if (checkrole != 'enabled') {
					event.preventDefault();
					showErrorSwal('คุณไม่มีสิทธิ์ในการแก้ไขข้อมูลดังกล่าว');

					return false;
				}
			}

			return true;
		});

		function refreshFn(audit_id) {
			let url = `{{ route('audit.show', 'id') }}`;
			url = url.replace('id', audit_id);

			$('.addSpin-refresh').addClass('mdi-spin');
			$('#listCheck input[type="radio"]').attr('disabled', true);
			$('#btn_sendMassages').attr('disabled', true);

			$.ajax({
				url: url,
				type: 'get',
				data: {
					funs: 'refresh-content',
				},
				success: function(result) {
					$('#Flag_Status').val(result.Flag_Status);
					$('#count_tagpart').val(result.count_tagpart);

					$('#content_checklist').html(result.view_checklist);
					$('#content_status').html(result.view_status);
					$('#content_massages').html(result.view_massage);

					$(".toast-success").toast({
						delay: 1500
					}).toast("show");
					$(".toast-success .toast-body .text-body").text("Refresh successful");
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
					$('#listCheck input[type="radio"]').attr('disabled', false);
					$('#btn_sendMassages').attr('disabled', false);
					$('.addSpin-refresh').removeClass('mdi-spin');
				}
			});
		}

		function callMassages(Pact_id, audit_id, Flag_Status, radiosData) {
			const Detail_TrackPart = $('#Detail_TrackPart').val();
			const count_tagpart = $('#count_tagpart').val();

			$.ajax({
				url: "{{ route('audit.store') }}",
				type: 'post',
				data: {
					page: 'send-message',
					Pact_id,
					audit_id,
					Flag_Status,
					radiosData,
					Detail_TrackPart,
					count_tagpart,
					_token: "{{ @csrf_token() }}",
				},
				success: function(result) {
					$('#content_status').html(result.view_status);
					$('#content_massages').html(result.view_massage);

					showSuccessToast('send completed');

					$('#Flag_Status').val(result.Flag_Status);
					$('#count_tagpart').val(result.count_tagpart );
				},
				error: function(err) {
					if (err.responseJSON.code == 205) {
						Swal.fire({
							icon: 'error',
							title: 'แจ้งเตือนจากระบบ',
							html: '<span class="text-title"><span class="highlight-text-alert">มีบันทึกเข้ามาใหม่</span> กรุณากดตกลงเพื่อรีเฟรชข้อมูลใหม่อีกครั้ง !.</span>',
							confirmButtonColor: '#e84e40',
							confirmButtonText: 'ตกลง',
							allowOutsideClick: false,
							allowEscapeKey: false
						}).then(result => {
							if (result.isConfirmed) {
								refreshFn(err.responseJSON.audit_id);
							}
						});
					} else {
						showErrorSwal(`ERROR ${err.status} !!! ${err.responseJSON.message}`);
					}
				},
				complete: function() {
					resetForm();
				}
			});
		}

		function showErrorSwal(message) {
			Swal.fire({
				icon: 'error',
				title: 'แจ้งเตือนจากระบบ',
				text: message,
				showConfirmButton: false,
				timer: 1500,
			});
		}

		function showSuccessToast(message) {
			$(".toast-success").toast({
				delay: 1500
			}).toast("show");
			$(".toast-success .toast-body .text-body").text(message);
		}

		function resetForm() {
			$('#listCheck input[type="radio"]').attr('disabled', false);
			$('#btn_sendMassages').attr('disabled', false).find('.addSpin').html('<i class="mdi mdi-send"></i>');
			$('#Detail_TrackPart').val('');
		}

		function checkPermission(params) {
			
		}
	</script>
@endsection
