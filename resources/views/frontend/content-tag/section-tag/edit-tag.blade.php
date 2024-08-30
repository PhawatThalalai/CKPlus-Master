<div class="modal-content">
	<form name="edit_datatag" id="edit_datatag" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
		@csrf
		<div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/demand.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">แก้ไขรายการติดตาม ( edit TagNumbers )</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$tag->Code_Tag }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
		</div>
		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-md-12 col-lg-12 col-sm-12 text-center bg-light">
					<div class="row align-items-start mt-2">
						<div class="col-12 text-center">
							<img src="assets/images/network.png" alt="" style="width: 140px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{ @$tag->Code_Tag }}</h4>
						</div>
					</div>
				</div>
				<div class="col-xl col-md-12 col-lg-12 col-sm-12">
					<div class="row mx-auto g-2">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating">
										@if (@$tag->Status_Tag == 'active')
											<select class="form-select border-danger" name="BranchCont" aria-label="Floating label select example" required>
												<option value="" selected>--- สาขาที่รับ ---</option>
												@foreach (@$Branchs as $value)
													<option value="{{ $value->id }}" {{($value->id == $tag->BranchCont)? 'selected' : ''}}>{{ $value->Name_Branch }}</option>
												@endforeach
											</select>
										@else
											<select class="form-select border-danger" aria-label="Floating label select example" disabled>
												<option value="" selected>--- สาขาที่รับ ---</option>
												@foreach (@$Branchs as $value)
													<option value="{{ $value->id }}" {{($value->id == $tag->BranchCont)? 'selected' : ''}}>{{ $value->Name_Branch }}</option>
												@endforeach
											</select>
											<input type="hidden" name="BranchCont" class="form-control" value="{{$tag->BranchCont}}">
										@endif
										<label for="BranchCont" class="fw-bold text-danger">สาขาที่รับ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating">
										@if (@$tag->Status_Tag == 'active')
											<select class="form-select" name="Type_Customer" aria-label="Floating label select example" required>
												<option value="" selected>-- ประเภทลูกค้า --</option>
												@foreach (@$typeCus as $value)
													<option value="{{ $value->Code_Cus }}" {{($value->Code_Cus == $tag->Type_Customer)? 'selected' : ''}}>{{ $value->Name_Cus }}</option>
												@endforeach
											</select>
										@else
											<select class="form-select" aria-label="Floating label select example" disabled>
												<option value="" selected>-- ประเภทลูกค้า --</option>
												@foreach (@$typeCus as $value)
													<option value="{{ $value->Code_Cus }}" {{($value->Code_Cus == $tag->Type_Customer)? 'selected' : ''}}>{{ $value->Name_Cus }}</option>
												@endforeach
											</select>
											<input type="hidden" name="Type_Customer" class="form-control" value="{{$tag->Type_Customer}}">
										@endif
										<label for="Type_Customer" class="fw-bold text-danger">ประเภทลูกค้า</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating">
										<select class="form-select" name="Resource_Customer" aria-label="Floating label select example" required>
											<option value="" selected>--- แหล่งที่มาลูกค้า ---</option>
											@foreach ($typeCusRs as $key => $value)
												<option value="{{ $value->Code_CusResource }}" {{($value->Code_CusResource == $tag->Resource_Customer)? 'selected' : ''}}>{{ $value->Name_CusResource }}</option>
											@endforeach
										</select>
										<label for="Resource_Customer" class="fw-bold text-danger">แหล่งที่มาลูกค้า</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0 ">
										<input type="date" class="form-control text-end" value="{{ $tag->date_Tag }}" placeholder="วันที่รับ" readonly>
										<label for="date_Tag" class="fw-bold text-danger">วันที่รับ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0 ">
										@if (date('Y-m-d', strtotime($tag->created_at)) >= '2023-07-01')
											<input type="text" class="form-control text-end" value="{{ $tag->TagUserID->name }}" placeholder="ผู้รับ" readonly>
										@else
											<input type="text" class="form-control text-end" value="{{ $tag->UserInsert }}" placeholder="ผู้รับ" readonly>
										@endif
										<label for="" class="fw-bold text-danger">ผู้รับ</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" id="edit_tag" data-idtag="{{$tag->id}}" class="btn btn-warning btn-sm waves-effect waves-light hover-up edit_tag">
				<span class="addSpin"><i class="fas fa-download"></i></span> อัพเดต
			</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up close-edit_tag" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> ปิด
			</button>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		$('.edit_tag').click(function() {
			var dataform = document.querySelectorAll('.needs-validation');
			var validate = validateForms(dataform);

			if (validate == true) {
				let funs = 'update-tag';
				let id = $(this).attr('data-idtag');
				let _token = $('input[name="_token"]').val();
				let data = {};
				$("#edit_datatag").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('#edit_tag,.close-edit_tag').prop('disabled', true);
				$('.addSpin').empty();
				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				let link = "{{ route('tags.update', 'id') }}";
				let url = link.replace('id', id);

				$.ajax({
					url: url,
					method: "put",
					data: {
						_token: _token,
						funs: funs,
						data: data
					},

					success: function(result) {
						$('.data_tag').html(result.html);
						$('.card-tagPart').addClass('d-none');

						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});

						$('#modal_xl_2').modal('hide');
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});

						$('#modal_xl_2').modal('hide');
					}
				})
			}
		});
	});
</script>

<script>
	function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');

				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}
</script>
