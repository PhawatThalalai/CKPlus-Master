<style>
    .select2-selection__choice{
  background-color: var(--bs-gray-200);
  border: none !important;
  font-size: 0.85rem !important;
}

  .select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
  font-size: 0.85 rem;
}

.select2-results__option[aria-selected=true]:before {
  color: #fff;
  background-color: #93c1e7;
  border: 0;
  display: inline-block;
  padding-top: 1px;
  padding-left: 2px;
}

</style>
<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/rules.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">เพิ่มรายละเอียดติดตาม (New TagParts)</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$data->Code_Tag }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
		</div>
		{{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-lg-12">
				<div class="vertical-nav">
					<div class="row">
						<div class="col-lg-3 col-sm-4">
							<div class="nav flex-column nav-pills" role="tablist">
								@foreach ($StateTagPart as $item)
									<a class="nav-link status-tagPart" id="{{ @$item->Code_StatusTag }}" data-bs-toggle="pill" href="{{ @$item->Code_StatusTag }}" role="tab">
										@if (@$item->Code_StatusTag == 'TAG-0001')
											<i class="mdi mdi-tag-plus nav-icon d-block mb-2 text-warning"></i>
										@elseif (@$item->Code_StatusTag == 'TAG-0002')
											<i class="mdi mdi-tag-remove nav-icon d-block mb-2 text-danger"></i>
										@elseif (@$item->Code_StatusTag == 'TAG-0003')
											<i class="mdi mdi-text-box-check mdi-24px d-block mb-2 text-success"></i>
										@endif
										<p class="fw-bold mb-0">{{ @$item->Name_StatusTag }}</p>
									</a>
								@endforeach

								<input type="hidden" id="Status_TrackPart" name="Status_TrackPart">
								<input type="hidden" id="idTag" value="{{ @$data->id }}" />
								<input type="hidden" id="idCus" value="{{ @$data->DataCus_id }}" />
							</div>
						</div>
						<div class="col-lg-9 col-sm-8">
							<div class="card">
								<div class="card-body">
									<div class="tab-content">
										<form id="form_tracking" class="needs-validation" action="#" novalidate>
											<div class="tab-pane fade show" id="part_tracking" role="tabpanel" style="display: none">
												<h5 class="card-title mb-3 text-warning bx-fade-right align-middle"><i class="bx bxs-bell font-size-16"></i> รายละเอียดติตดาม</h5>
												<div>
													<div class="row mb-1 g-1">
														<div class="col-md-12 col-lg-6">
															<div class="form-floating mb-0">
																<input type="date" name="Duedate_TrackPart" id="Duedate_TrackPart" class="form-control input-track" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
																<label for="Duedate_TrackPart" class="fw-bold text-danger">วันที่นัดหมาย</label>
															</div>
														</div>
														<div class="col-md-12 col-lg-6">
															<div class="form-floating mb-0">
																<input type="text" value="{{ auth()->user()->name }}" class="form-control" placeholder="ผู้ติดตาม" readonly>
																<label for="Userfollow_TrackPart" class="fw-bold">ผู้ติดตาม</label>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="form-floating">
																<textarea name="tracking_details" id="tracking_details" style="height: 170px" class="form-control input-track" placeholder="Leave a comment here" maxlength="65535" required></textarea>
																<label for="tracking_details" class="fw-bold text-danger">หมายเหตุ</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>

										<form id="form_trackCancel" class="needs-validation" action="#" novalidate>
											<div class="tab-pane fade show" id="part_trackCancel" data-roles='{{ roleCancelTagparts() }}' role="tabpanel" style="display: none">
												<h5 class="card-title mb-3 text-warning bx-fade-right align-middle"><i class="bx bxs-bell font-size-16"></i> รายละเอียดยกเลิกติตดาม</h5>
												<div>
													<div class="row mb-1">
														<div class="col-md-12">
															<div class="form-floating mb-0">
																<select name="cancel_status" class="form-select input-cancel" aria-label="Floating label select example" required>
																	<option value="" selected>-- สถานะยกเลิก --</option>
																	@foreach (@$CancelTag as $value)
																		<option value="{{ $value->Code_type }}">({{ $value->Code_type }}) - {{ $value->Name_type }}</option>
																	@endforeach
																</select>
																<label for="cancel_status" class="fw-bold text-danger">สถานะยกเลิก</label>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="form-floating">
																<textarea name="cancel_deatails" id="cancel_deatails" style="height: 170px" class="form-control input-cancel" placeholder="Leave a comment here" maxlength="65535" required></textarea>
																<label for="cancel_deatails" class="fw-bold text-danger">หมายเหตุ</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>

										<form id="form_sentFinance" class="needs-validation" action="#" novalidate>
											<div class="tab-pane fade show" id="part_sentFinance" role="tabpanel" style="display: none">
												<h5 class="card-title mb-3 text-warning bx-fade-right align-middle"><i class="bx bxs-bell font-size-16"></i> รายละเอียดส่งจัดไฟแนนซ์</h5>
												<div class="row mb-1 g-1">
													<div class="col-md-12 col-lg-6">
														<div class="form-floating mb-0">
															<input type="text" id="UsernameSent" value="{{ auth()->user()->name }}" class="form-control" placeholder="ผู้ส่งจัดไฟแนนซ์" readonly>
															<label for="UsernameSent" class="fw-bold text-danger">ผู้ส่งจัดไฟแนนซ์</label>
														</div>
														<input type="hidden" id="UserSent" value="{{ auth()->user()->position }}" />
													</div>
													<div class="col-md-12 col-lg-6" id="DateSent_Con_datepicker">
														<div class="input-group">

															<div class="form-floating mb-0">

																<input type="text" name="DateSent_Con" id="DateSent_Con" class="form-control input-finance" placeholder="วันที่ทำสัญญา" data-date-format="dd/mm/yyyy" data-date-container="#DateSent_Con_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-clear-btn="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" readonly data-date-start-date="{{convertDatePHPToHuman(date('Y-m-d'))}}" value="{{convertDatePHPToHuman(date('Y-m-d'))}}" autocomplete="off" required>
																{{--
																<input type="date" name="DateSent_Con" min="{{ date('Y-m-d') }}" class="form-control input-finance" required>
																--}}
																<label for="DateSent_Con" class="fw-bold text-danger">วันทำสัญญา</label>
															</div>

															<button class="btn btn-light border-secondary border-opacity-50 rounded-end d-flex align-items-center openDatepickerBtn_formfloating" type="button">
																<i class="fas fa-calendar-alt"></i>
															</button>

														</div>

													</div>
												</div>
												<div class="row mb-1 g-1">
													<div class="col-md-12 col-lg-6">
														<div class="form-floating mb-0">
															<input type="text" name="Branch_Con" id="Branch_Con" value="{{ @$data->TagBranchCont->Name_Branch }}" data-BranchID="{{ @$data->BranchCont }}" data-BranchZone="{{ @$data->TagBranchCont->Zone_Branch }}" class="form-control" placeholder="สาขา" readonly required>
															<label for="Branch_Con" class="fw-bold text-danger">สาขา</label>
														</div>
													</div>
													<div class="col-md-12 col-lg-6">
														<div class="form-floating mb-0">
															<select name="UserApp_Con" id="UserApp_Con" class="form-select UserApp_Con input-finance" aria-label="Floating label select example" required>
																<option value="" selected>-- ผู้อนุมัติ --</option>
															</select>
															<label for="UserApp_Con" class="fw-bold text-danger">ผู้อนุมัติ</label>
														</div>
													</div>
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <div class="form-floating mb-0">
                                                                <select class="form-control" id="UserApp_relevant" multiple="multiple" placeholder="Choose anything" style="font-size: 3rem !important;">
                                                                </select>
                                                                <label for="UserApp_relevant" class="fw-bold text-danger">ผู้เกี่ยวข้อง</label>
                                                            </div>
                                                            <button class="btn btn-light border-secondary border-opacity-50 rounded-end d-flex align-items-center openDatepickerBtn_formfloating" type="button">
																<img src="{{ asset('assets/images/icon/microsoft-teams.svg') }}" alt="">
															</button>
                                                        </div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-floating">
															<textarea name="finance_details" id="finance_details" style="height: 120px" class="form-control input-finance" placeholder="Leave a comment here" maxlength="65535" required></textarea>
															<label for="finance_details" class="fw-bold text-danger">หมายเหตุ</label>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" id="create_tagPart" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up d-none btn-tagpart">
			<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
		</button>
		<button type="button" class="btn btn-secondary btn-sm waves-effect w-md hover-up btn-tagpart" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script>
	$(document).ready(function() {

		$('.status-tagPart').click(function() {
			$('#create_tagPart').removeClass('d-none');
			$('#Status_TrackPart').val($(this).attr('id'));

			if ($(this).attr('id') == 'TAG-0001') {
				$('#part_tracking').show();
				$(".input-track").val('');
				$(".input-finance").val('');

				$('#part_trackCancel').hide();
				$('#part_sentFinance').hide();
			} else if ($(this).attr('id') == 'TAG-0002') {
				let checkRole = $('#part_trackCancel').attr('data-roles');

				if (checkRole == 'disabled') {
					Swal.fire({
						icon: 'error',
						title: `ERROR (403) !`,
						text: 'คุณไม่มีสิทธิ์ในการยกเลิกติดตาม',
						showConfirmButton: false,
						timer: 1500
					});

					$('#TAG-0002').removeClass('active');
					$('#create_tagPart').addClass('d-none');

					return false;
				}

				$('#part_trackCancel').show();
				$(".input-cancel").val('');
				$(".input-finance").val('');

				$('#part_tracking').hide();
				$('#part_sentFinance').hide();
			} else if ($(this).attr('id') == 'TAG-0003') {
				$('#part_sentFinance').show();
				$('#finance_details').val('ส่งจัดไฟแนนซ์เรียบร้อย');
				$(".input-track").val('');
				$(".input-cancel").val('');

				$('#part_tracking').hide();
				$('#part_trackCancel').hide();
				$('#create_tagPart').prop('disabled', true).css('cursor', 'not-allowed');

				let _token = $('input[name="_token"]').val();
				let idCus = $('#idCus').val();
				let tag_id = $('#idTag').val();
				let Br_id = $('#Branch_Con').attr("data-BranchID");
				let Br_zone = $('#Branch_Con').attr("data-BranchZone");

				let funs = 'check-datacus';
				$.ajax({
					url: "{{ route('ControlCenter.create') }}",
					method: "get",
					data: {
						_token: _token,
						funs: funs,
						idCus: idCus,
						tag_id: tag_id,
						Br_id: Br_id,
						Br_zone: Br_zone,
					},

					success: function(data) {

						console.log(data);
						console.log(data.userApp);
						if (data.userApp) {
							$('.UserApp_Con').empty();
							$('.UserApp_Con').append($('<option/>').attr("selected", "").val('').text("--- ผู้อนุมัติ ---"));

							for (var i = 0, len = data.userApp.length; i < len; ++i) {
								var result = data.userApp[i];
								$('.UserApp_Con').append($('<option/>').attr("value", result.id).text(result.name + " - " + "(" + result.position + ")"));
                                $('#UserApp_relevant').append($('<option/>').attr("value", result.id).text(result.name + " - " + "(" + result.position + ")"));
							}
						}
					},
					error: function(err) {
						if (err.responseJSON.code == 401) {
							var span = document.createElement("span");
							span.classList.add('text-muted');
							span.innerHTML = "กรุณาตรวจสอบข้อมูลลูกค้าต่อไปนี้ ก่อนส่งจัดไฟแนนซ์ \n<ul style='text-align: left;font-size: 13px;'>" +
								"<li class='text-danger'>ตรวจสอบ : ประเภทบัตร</li>" +
								"<li class='text-danger'>ตรวจสอบ : เลขบัตรประชาชน</li>" +
								"<li class='text-danger'>ตรวจสอบ : วัน/เดือน/ปี เกิด</li>" +
								"<li class='text-danger'>ตรวจสอบ : เบอร์โทรศัพท์</li>" +
								"</ul>";

							Swal.fire({
								icon: 'error',
								title: `ข้อมูลไม่ครบถ้วน (` + err.responseJSON.code + `) !`,
								html: span,
								showConfirmButton: true,
							});
						} else if (err.responseJSON.code == 406) {
							let ExpireCard = '';
							let filterAdds = '';
							let filterCareer = '';

							if (err.responseJSON.ExpireCard != true) {
								ExpireCard = "<li class='text-danger'>" + err.responseJSON.ExpireCard + "</li>";
							}
							if (err.responseJSON.filterAdds != true) {
								filterAdds = "<li class='text-danger'>" + err.responseJSON.filterAdds + "</li>";
							}
							if (err.responseJSON.filterCareer != true) {
								filterCareer = "<li class='text-danger'>" + err.responseJSON.filterCareer + "</li>";
							}

							var span = document.createElement("span");
							span.classList.add('text-muted');
							span.innerHTML = "กรุณาตรวจสอบข้อมูลลูกค้าต่อไปนี้ ก่อนส่งจัดไฟแนนซ์ \n<ul style='text-align: left;font-size: 13px;'>" +
								ExpireCard + filterAdds + filterCareer + "</ul>";

							Swal.fire({
								icon: 'warning',
								title: `ข้อมูลไม่ครบถ้วน (` + err.responseJSON.code + `) !`,
								html: span,
								showConfirmButton: true,
							});
						} else if (err.responseJSON.code == 428) {
							Swal.fire({
								icon: 'error',
								title: `ERROR (` + err.responseJSON.code + `) !`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						}

						$(".input-finance").val('');
						$('#part_sentFinance').hide();

						$('#TAG-0003').removeClass('active');
						$('#create_tagPart').addClass('d-none');

					},
					complete: function() {
						$('#create_tagPart').prop('disabled', false).css('cursor', 'default');
					}
				})
			}
		});

		$('#create_tagPart').click(function() {
			var tagpart = $('#Status_TrackPart').val();
            var UserApp_relevant = $('#UserApp_relevant').val()
			if (tagpart == 'TAG-0001') {
				var dataform = document.querySelectorAll('#form_tracking');
				var data = {};
				$("#form_tracking").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});
			} else if (tagpart == 'TAG-0002') {
				var dataform = document.querySelectorAll('#form_trackCancel');
				var data = {};
				$("#form_trackCancel").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});
			} else if (tagpart == 'TAG-0003') {
				var dataform = document.querySelectorAll('#form_sentFinance');
				var data = {};
				$("#form_sentFinance").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});
			}

			var validate = validateForms(dataform);
			if (validate == true) {
				var idCus = $('#idCus').val();
				var idTag = $('#idTag').val();
				var funs = 'create-tagPart';
				var _token = $('input[name="_token"]').val();

				$('.btn-tagpart').prop('disabled', true);
				$('.addSpin').empty();
				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				$.ajax({
					url: "{{ route('tags.store') }}",
					method: "post",
					data: {
						_token: _token,
						funs: funs,
						tagpart: tagpart,
						idCus: idCus,
						idTag: idTag,
						data: data,
                        UserApp_relevant : UserApp_relevant
					},

					success: function(result) {
						$('#data_contract').html(result.viewPoss)
						$('.data-tagPart').html(result.html);
						$('#tagpart-' + idTag).text(result.tagpart); //update count tagpart

						if (tagpart == 'TAG-0002') {
							$('.active_tag').empty();
							$('.btn-createTag').attr('disabled', false).css('cursor', 'default');

							$('#icon-' + idTag).empty();
							$('#tagstatus-' + idTag).empty();

							$('#icon-' + idTag).append('<i class="bx bx-x-circle h1 text-danger down-arrow-icon"></i>');
							$('#tagstatus-' + idTag).append('ยกเลิกติดตาม');
						} else if (tagpart == 'TAG-0003') {
							$('.active_tag').empty();
							$('.btn-createTag').attr('disabled', false).css('cursor', 'default');

							$('#icon-' + idTag).empty();
							$('#tagstatus-' + idTag).empty();

							$('#icon-' + idTag).append('<i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>');
							$('#tagstatus-' + idTag).append('ส่งจัดไฟแนนซ์');

							let Url = '{{ route('contract.edit', ':id') }}';
							Url = Url.replace(':id', result.id_cont);

							$('.tag03-' + idTag).empty();
							$('#contract-' + idTag).append('<a href="' + Url + '?funs=contract" target="_blank">' + result.contract + '</a>');
							$('#typecont-' + idTag).append(result.Br_cont);
							$('#sentcont-' + idTag).append(result.nameSent);
						}

						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: true,
							timer: 1500
						});

						$('#modal_lg').modal('hide');
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});

						$('#modal_lg').modal('hide');
					}
				})
			}
		});

		$(".openDatepickerBtn_formfloating").on('click', function() {
			$(this).siblings('.form-floating').find('input').focus();
		});

	});
</script>

<script>
    // select2
    $(document).ready(function() {

        $('#UserApp_relevant').select2( {
            theme: 'bootstrap-5',
        } );
    });
</script>
