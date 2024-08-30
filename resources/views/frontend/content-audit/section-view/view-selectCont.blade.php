<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/document.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">รายการนําส่งเอกสาร (Document delivery)</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">สาขา. : {{ @$nameBranch }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<form id="formsend_DocCont" class="needs-validation" action="#" novalidate>
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-4 col-lg-12">
						<div class="card h-100">
							<div class="card-body pb-0">
								<div class="d-flex flex-wrap align-items-start">
									<div class="me-2">
										<h5 class="card-title mb-3 text-primary">จำนวนรายการ</h5>
									</div>
									<div class="dropdown ms-auto" data-bs-toggle="tooltip" title="เพิ่มเติม">
										<a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
											<i class="mdi mdi-dots-horizontal"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-end">
											<a id="selectAll" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
												เลือกทั้งหมด <i class="mdi mdi-format-list-checks fs-5 text-info"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="text-center">
									<div class="avatar-md mx-auto mb-4 up-down">
										<div id="countData" class="avatar-title bg-light rounded-circle text-primary h1">0</div>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-xl-12 ">
										<div class="input-bx">
											<select name="Send_by" class="form-select text-dark" id="Send_by" required>
												<option value="" selected>--- วิธีส่งเอกสาร ---</option>
												<option value="ฝากส่ง">ฝากส่ง</option>
												<option value="ส่งด้วยตัวเอง">ส่งด้วยตัวเอง</option>
												<option value="บริษัทขนส่ง">บริษัทขนส่ง</option>
											</select>
											<span class="text-danger">วิธีส่งเอกสาร</span>
										</div>
									</div>
								</div>
								<div class="row mb-2 d-none" id="ems_show">
									<div class="col-xl-12 ">
										<div class="input-bx">
											<input class="form-control " id="ems_detail" name="ems_detail">
											<span class="text-danger">เลขที่ส่งเอกสาร</span>
										</div>
									</div>
								</div>
								<div class="row justify-content-center mb-2">
									<div class="col-xl-12">
										<div class="form-floating">
											<textarea class="form-control" placeholder="Leave a comment here" id="message_send" maxlength="65535" style="height: 100px" required></textarea>
											<label for="message_send" class="fw-bold text-danger font-size-12">รายละเอียด</label>
										</div>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-xl-12">
										<div class="input-bx">
											<input type="text" class="form-control text-end" value="{{ auth()->user()->name }}" data-bs-toggle="tooltip" title="ผู้นำส่ง" placeholder=" " readonly />
											<span class="text-danger">ผู้นำส่ง</span>
											<button class="btn btn-light border border-secondary border-opacity-50" type="button">
												<i class="bx bxs-user-circle"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="text-center">
									<button type="button" id="btn_sendDocCont" class="btn btn-success btn-rounded w-lg w-75 waves-effect waves-light hover-up">
										<i class="bx bxs-paper-plane me-1"></i> ยืนยัน
									</button>
								</div>
							</div>
							<div class="card-footer">
								<div class="row text-end font-size-10" data-bs-toggle="tooltip" title="วันที่นำส่ง">
									<div class="col-12">
										<i class="bx bx-calendar me-1"></i>{{ date('d-m-Y H:i:s') }}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-12 px-0">
						<div class="table-responsive h-100" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
							<table class="table align-middle table-nowrap text-nowrap table-hover font-size-11">
								<thead class="table-light sticky-top text-center">
									<tr>
										<th class="text-center" style="width: 5%"></th>
										<th class="text-center">เลขสัญญา</th>
										<th class="text-center">ประเภท</th>
										<th class="text-center">ชื่อลูกค้า</th>
										<th class="text-center">#</th>
									</tr>
								</thead>
								<tbody>
									@foreach (@$data as $row)
										<tr id="row{{ $row->id }}">
											<td class="">
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
												<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$row->Contract_Con }}</a></h5>
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : {{ @$row->StatusApp_Con }}</span>
											</td>
											<td class="text-center">
												<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light font-size-12">
													{{ @$row->Loan_Name }}
												</button>
											</td>
											<td>
												<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
											</td>
											<td class="text-center">
												<input type="checkbox" id="docCont_{{ @$row->id }}" name="docCont[]" value="{{ @$row->id }}" class="form-check-input font-size-14 checkbox-docCont">
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(function() {
		$('#Send_by').change(function() {
			if ($('#Send_by').val() == 'บริษัทขนส่ง') {
				$('#ems_show').removeClass('d-none');
				$("#ems_detail").attr("required", "true");
			} else {
				$('#ems_show').addClass('d-none');
				$("#ems_detail").removeAttr("required");
			}

		});
		$('#btn_sendDocCont').click(function() {
			let id_branch = $('#id_branch').val();
			let Send_by = $('#Send_by').val();
			let ems_detail = $('#ems_detail').val();
			let message = $('#message_send').val();
			let fdate = $('#start').val();
			let tdate = $('#end').val();

			$(this).attr('disabled', true);

			var idcont = [];
			$('#formsend_DocCont input.checkbox-docCont').each(function() {
				if ($(this).prop('checked')) {
					idcont.push($(this).val());
				}
			});

			var dataform = document.querySelectorAll('.needs-validation');
			var validate = validateForms(dataform);

			var alert = null;
			if (idcont == '') {
				alert = 'กรุณาเลือกสัญญา ก่อนยืนยันการนำส่งเอกสาร !';
			} else {
				if (validate == false) {
					alert = 'กรุณาระบุรายละเอียด ก่อนนำส่งเอกสาร !';
				}
			}


			if (alert == null) {

				//if (alert == null) {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: "{{ route('audit.store') }}",
					method: "post",
					data: {
						_token: "{{ @csrf_token() }}",
						page: 'send-DocCont',
						idcont: idcont,
						id_branch: id_branch,
						Send_by: Send_by,
						ems_detail: ems_detail,
						message: message,
						fdate: fdate,
						tdate: tdate,
					},

					success: function(result) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						$('.countBranch-' + result.idBranch).html(result.data);
						$('#viewDataBranch').html(result.html).slideDown('slow');

						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});

						$('#modal_xl_2').modal('hide');
						$('#modal_xl_2 .modal-dialog').empty();
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
						$($this).attr('disabled', false);
					}
				});
			} else {
				Swal.fire({
					icon: 'error',
					text: alert,
					showConfirmButton: true,
					timer: 1500
				});
			}
		});

		$("#selectAll").click(function() {
			$('.checkbox-docCont').prop('checked', true);
			$("#countData").text($('.checkbox-docCont').length);
		});

		$('.checkbox-docCont').click(function() {
			let count = parseInt($("#countData").text());
			if ($(this).prop("checked")) {
				count++;
			} else {
				count--;
			}

			$("#countData").text(count);
		});

		$('[data-bs-toggle="tooltip"]').tooltip();
	});
</script>
