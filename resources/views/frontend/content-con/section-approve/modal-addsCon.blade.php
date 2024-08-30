<style>
	.cardAdds {
		cursor: pointer;
	}
</style>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="text-primary fw-semibold modal-title"> <i class="bx bx-home"></i> ที่อยู่ใช้ทำสัญญา ( Address Contract )</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<form id="addsCon">
			<input type="hidden" name="funs" value="addAddCon">
			<input type="hidden" name="PactCon_id" value="{{ @$data->id }}">
			<input type="hidden" name="_token" value="{{ @csrf_token() }}">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 pt-2 bg-light fs-5">
					<div class="nav">
						<div class="card card-hover py-4 px-3 mb-2 cardAdds addCon1 nav-item nav-link {{ @$data->Adds_Con == null ? 'show active' : '' }}  d-none" for="addCon1" data-bs-toggle="pill" data-bs-target="#tablDefualt">
						</div>

						@foreach (@$data->ContractToCus->DataCusToDataCusAddsMany as $item)
							<div class="card card-hover py-4 px-3 mb-2 cardAdds addCon-{{ $item->id }} {{ @$data->Adds_Con == $item->id ? 'show active' : '' }} nav-item nav-link" for="addCon-{{ $item->id }}" data-bs-toggle="pill" data-bs-target="#TabaddCon-{{ $item->id }}">
								<div class="row">
									<div class="col-3 m-auto">
										<input class="form-check-input" type="radio" name="Adds_Con" value="{{ $item->id }}" id="addCon-{{ $item->id }}" {{ @$data->Adds_Con == $item->id ? 'checked' : '' }}>
									</div>
									<div class="col m-auto">
										<label class="form-check-label fw-semibold" for="addCon-{{ $item->id }}">
											<i class="bx bx-select-multiple"></i> {{ $item->DataCusAddsToTypeAdds->Name_Address }}
										</label>
									</div>
									<div class="col-3 ">
										<img src="{{ URL::asset('\assets\images\add-pin.png') }}" alt="" style="width: 60%;">
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center">
					<div class="tab-content mt-2">
						<div class="tab-pane fade  {{ @$data->Adds_Con == null ? 'show active' : '' }} " id="tablDefualt">
							<img src="{{ URL::asset('\assets\images\undraw\address-2.svg') }}" alt="" style="width: 90%;">
						</div>
						@foreach (@$data->ContractToCus->DataCusToDataCusAddsMany as $item)
							<div class="tab-pane fade {{ @$data->Adds_Con == $item->id ? 'show active' : '' }}" id="TabaddCon-{{ $item->id }}">
								<h5 class="fw-semibold">รายละเอียด{{ $item->Name_Address }} ( Address Details )</h5>
								<div class="border border-bottom mb-1"></div>
								<table class="table table-sm table-striped">
									<tr>
										<th class="text-start">บ้านเลขที่</th>
										<td class="text-end">{{ $item->houseNumber_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">หมู่</th>
										<td class="text-end">{{ $item->houseGroup_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">อาคาร</th>
										<td class="text-end">{{ $item->building_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">หมู่บ้าน</th>
										<td class="text-end">{{ $item->village_Adds }}</td>
									</tr>

									<tr>
										<th class="text-start">จังหวัด</th>
										<td class="text-end">{{ $item->houseProvince_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">อำเภอ</th>
										<td class="text-end">{{ $item->houseDistrict_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">ตำบล</th>
										<td class="text-end">{{ $item->houseTambon_Adds }}</td>
									</tr>
									<tr>
										<th class="text-start">รหัสไปรษณีย์</th>
										<td class="text-end">{{ $item->Postal_Adds }}</td>
									</tr>
								</table>
							</div>
						@endforeach

					</div>
				</div>

			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn-saveAddCon">
            <span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
        </button>
		<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn-closeAddCon" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
        </button>
	</div>
</div>

<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})

	$('.cardAdds').click((e) => {
		const getfor = $(e.currentTarget).attr("for")

		$('.cardAdds').removeClass('border border-2 border-success')
		$('.' + getfor).addClass('border border-2 border-success')
		$('#' + getfor).prop("checked", true)
	})


	$('.btn-saveAddCon').click((ev) => {
        ev.preventDefault();
			let id = sessionStorage.getItem('PactCon_id')
			let url = " {{ route('contract.update', 'ID') }}"

            $('.btn-saveAddCon,.btn-closeAddCon').prop('disabled', true);
            $('.addSpin').empty();
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");

			$.ajax({
				url: url.replace('ID', id),
				type: 'PUT',
				data: $('#addsCon').serialize(),
				success: async (res) => {
					if (res.FlagCon == 'fail') {
						swal.fire({
							icon: 'error',
							title: 'Success !',
							text: 'ไม่สามารถแก้ไขที่อยู่ในสัญญาได้ สัญญาอนุมัติเเล้ว',
							timer: 2000,
						})
					} else {
						$('.addressText').html(res.addressText)
						await swal.fire({
							icon: 'success',
							title: 'Success!',
							text: 'เพิ่มที่อยู่ที่ใช้ทำสัญญาเรียบร้อย',
							timer: 1500,
						})
						$('#section-cardCon').html(res.htmlHeaderCard)
						$('#section-Tab').html(res.renderTab);
						$('.modal').modal('hide');
					}
				},
				error: (err) => {
                        $('.btn-saveAddCon,.btn-closeAddCon').prop('disabled', false);
                        swal.fire({
                        icon : 'error',
                        title : `${ err.responseJSON.message}`,
                        text : `${ err.responseJSON.text}`,
                        showConfirmButton: true,
                    })
				},
                complete: () => {
                    $('.btn-saveAddCon,.btn-closeAddCon').prop('disabled', false);
                    $('.addSpin').html('<i class="fas fa-download"></i>');
                }
			})

	})
</script>
