{{-- <div class="modal-content">
    <div class="card">
        <div>
            <div class="row">
                <div class="col-lg-9 col-sm-8">
                    <div class="p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-4">
                                <img src="{{asset('assets/images/companies/img-1.png')}}" alt="" class="avatar-sm">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h4 class="text-primary fw-semibold">เพิ่มรายการติดตาม</h4>
                                <p class="text-muted mt-n1">{{@$CodeJob}}.</p>
                                <p class="border-primary border-bottom mt-n2"></p>
                            </div>
                        </div>
	                    <form id="create_datatag" class="needs-validation" action="#" novalidate>
                            @csrf
                            <input type="hidden" name="id" value="{{@$id}}"/>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="Type_Customer" aria-label="Floating label select example" required>
                                            <option value="" selected>-- ประเภทลูกค้า --</option>
                                            @foreach (@$typeCus as $value)
                                                <option value="{{$value->Code_Cus}}">{{$value->Name_Cus}}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelectGrid">ประเภทลูกค้า</label>
                                    </div>
                                </div><div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="Resource_Customer" aria-label="Floating label select example" required>
                                            <option value="" selected>--- แหล่งที่มาลูกค้า ---</option>
                                            @foreach ($typeCusRs as $key => $value)
                                              <option value="{{$value->Code_CusResource}}">{{$value->Name_CusResource}}</option>
                                            @endforeach
                                        </select>
                                        <label for="floatingSelectGrid">แหล่งที่มาลูกค้า</label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary w-md float-end hover-up create_tag">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 align-self-center">
                    <div>
                        <img src="{{ asset('assets/images/crypto/features-img/img-1.png') }}" alt="" class="img-fluid d-block">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal-content">
	<form name="create_datatag" id="create_datatag" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="id" value="{{ @$id }}" />

		<div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/demand.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">เพิ่มรายการติดตาม (New TagNumbers)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$CodeJob }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			{{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
		</div>
		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-md-12 col-lg-12 col-sm-12 text-center bg-light">
					<div class="row align-items-start mt-2">
						<div class="col-12 text-center">
							<img src="assets/images/network.png" alt="" style="width: 140px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{ @$CodeJob }}</h4>
						</div>
					</div>
				</div>
				<div class="col-xl col-md-12 col-lg-12 col-sm-12">
					<div class="row mx-auto g-2">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating">
										<select class="form-select border-danger" name="BranchCont" aria-label="Floating label select example" required>
											<option value="" selected>--- สาขาที่รับ ---</option>
											@foreach (@$Branchs as $value)
												<option value="{{ $value->id }}">{{ $value->Name_Branch }}</option>
											@endforeach
										</select>
										<label for="BranchCont" class="fw-bold text-danger">สาขาที่รับ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating">
										<select class="form-select" name="Type_Customer" aria-label="Floating label select example" required>
											<option value="" selected>-- ประเภทลูกค้า --</option>
											@foreach (@$typeCus as $value)
												<option value="{{ $value->Code_Cus }}">{{ $value->Name_Cus }}</option>
											@endforeach
										</select>
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
												<option value="{{ $value->Code_CusResource }}">{{ $value->Name_CusResource }}</option>
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
										<input type="date" class="form-control text-end" name="date_Tag" value="{{ date('Y-m-d') }}" placeholder="วันที่รับ" autocomplete="off" readonly>
										<label for="date_Tag" class="fw-bold text-danger">วันที่รับ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0 ">
										<input type="text" class="form-control text-end" value="{{ auth()->user()->name }}" placeholder="ผู้รับ" autocomplete="off" readonly>
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
			<button type="button" id="create_tag" class="btn btn-primary btn-sm waves-effect waves-light hover-up create_tag">
				<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
			</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up close-create_tag" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> ปิด
			</button>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		$('.create_tag').click(function() {
			var dataform = document.querySelectorAll('.needs-validation');
			var validate = validateForms(dataform);

			if (validate == true) {
				let funs = 'create-tag';
				let _token = $('input[name="_token"]').val();
				let data = {};
				$("#create_datatag").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('#create_tag,.close-create_tag').prop('disabled', true);
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
						data: data
					},

					success: function(result) {
						$('.btn-createTag').attr('disabled', true).css('cursor', 'no-drop');
						if (result.code == 200) {
							$('.data_tag').html(result.html);
							$('.card-tagPart').addClass('d-none');

							Swal.fire({
								icon: 'success',
								text: 'New Tag successful !',
								showConfirmButton: false,
								timer: 1500
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + result.code + ` !!!`,
								text: 'บันทึกล้มเหลว '+ result.message,
								showConfirmButton: true,
							});
						}

						$('#modal_xl_2').modal('hide');
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + result.code + ` !!!`,
							text: 'บันทึกล้มเหลว !',
							showConfirmButton: true,
						});

						$('#modal_xl_2').modal('hide');
					}
				})
			}
		});
	});
</script>