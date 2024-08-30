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
	<form id="formContracts" class="needs-validation" >
		@csrf
		<input type="hidden" value="UpdateCardCon" name="funs">
		<input type="hidden" value="{{ @$data->id }}" name="PactCon_id">

		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-4">
				<img src="{{ URL::asset('\assets\images\signature.png') }}" alt="" style="width: 30px;">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h4 class="text-primary fw-semibold">แก้ไขข้อมูลสัญญา (Edit Contract)</h4>
				<p class="text-muted mt-n1 fw-semibold font-size-12">เลขสัญญา : {{@$data->Contract_Con}}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1" aria-label="Close"></button>
		</div>
		<div class="modal-body mx-3">

			<!-- content -->

			@php
				if(@$data->StatusApp_Con == 'อนุมัติ' || @$data->StatusApp_Con == 'โอนเงินเรียบร้อย' || @$data->StatusApp_Con == 'ปิดบัญชี'){
					$bordercolor = 'border-success';
					$badge = 'badge text-bg-success';
				}elseif(@$data->StatusApp_Con == 'รออนุมัติ'){
					$bordercolor = 'border-warning';
					$badge = 'badge text-bg-warning';
				}elseif(@$data->StatusApp_Con == 'สร้างสัญญา'){
					$bordercolor = 'border-info';
					$badge = 'badge text-bg-info';
				}
				else{
					$bordercolor = 'border-danger';
					$badge = 'badge text-bg-danger';
				}
			@endphp

			<div class="row g-2 mb-3">
				<div class="col-md-6 col-sm-12 text-center">
                    <div class="card bg-light h-100">
                        <div class="card-body">
                            <img src="{{ isset($data->ContractToCus->image_cus) ? URL::asset($data->ContractToCus->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="" class="p-1 mb-2 rounded-circle border border-3 {{$bordercolor}}" style="width: 100px; height: 100px;">
                            <br><span class="badge {{$badge}} mb-2 fs-6">{{ @$data->StatusApp_Con }}</span>
                            <h6><b>{{ @$data->Contract_Con }}</b></h6>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold text-secondary">อัพเดทล่าสุดเมื่อ</span>
                                <span class="fw-semibold text-secondary">{{ @$data->updated_at }}</span>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-md-6 col-sm-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="card-title">ข้อมูลทั่วไป (Data General)</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row"><i class="btn btn-soft-success btn-sm rounded-pill bx bx-map"></i> สาขา :</th>
                                            <td class="text-end">
                                                 {{ $data->ContractToBranch->Name_Branch }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="btn btn-soft-danger btn-sm rounded-pill bx bx-id-card"></i> ชื่อลูกค้า :</th>
                                            <td class="text-end">
                                                </i> {{ $data->ContractToCus->Name_Cus }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="btn btn-soft-info btn-sm rounded-pill bx bx-calendar-event"></i> วันที่สร้างสัญญา :</th>
                                            <td class="text-end">
                                                 {{@$data->Date_con}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="btn btn-soft-danger btn-sm rounded-pill mdi mdi-cellphone-nfc"></i> Credo Code :</th>
                                            <td class="text-end">
                                                 {{$data->ContractToDataCusTags->Credo_Code}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><i class="btn btn-soft-info btn-sm rounded-pill bx bx-message-square-dots"></i> Credo Note :</th>
                                            <td class="text-end">
                                                    {{ $data->ContractToDataCusTags->TagToCredo->Name_Credo }}
                                            </td>
                                        </tr>

                                        @if(auth()->user()->position == 'Admin')
                                            <tr>
                                                <th scope="row"><i class="btn btn-soft-danger btn-sm rounded-pill bx bxs-analyse"></i>  Credo Score :</th>
                                                <td class="text-end">
                                                        {{ @$data->ContractToDataCusTags->Credo_Score }} <i class="{{@$data->ContractToDataCusTags->Credo_Score > 490 ? 'bx bxs-up-arrow-circle text-success fs-5' : ''}}"></i>
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
            </div>


				<div class="row">

					<div class="col-md-12">
						<div class="mb-3" id="Date_con_datepicker">
							<label class="fw-semibold">วันที่ทำสัญญา</label>
							<div class="input-group">
								<input type="text" name="Date_con" id="Date_con" class="form-control" placeholder="วันที่ทำสัญญา" data-date-format="dd/mm/yyyy" data-date-container="#Date_con_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-clear-btn="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" readonly value="{{ !empty(@$data->Date_con) ? convertDatePHPToHuman(@$data->Date_con) : '' }}" autocomplete="off">

								<button class="btn btn-light border-secondary border-opacity-50 rounded-end d-flex align-items-center openDatepickerBtn" type="button">
									<i class="fas fa-calendar-alt"></i>
								</button>
							</div>
							{{--
							<input type="date" class="form-control" id="" name="Date_con" value="{{ @$data->Date_con }}" placeholder="วันที่ทำสัญญา"  >
							--}}
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label class="fw-semibold">ลิงก์เช็คเล่มทะเบียน (Link Contract)</label>
							<div class="input-group form-inline gap-1">
								<input type="text" value="{{ @$data->LinkBookcar }}" name="LinkBookcar" class="form-control {{ @$data->LinkBookcar == NULL ? 'bg-light' : '' }}" placeholder="Google Drives, One Drives" {{ @$data->LinkBookcar == NULL ? 'readonly' : '' }}>
								<span class="input-group-append">
									<a href="{{ @$data->LinkBookcar != NULL ? @$data->LinkBookcar : '#' }}" target="{{ @$data->LinkBookcar != NULL ? '_blank' : '' }}" rel="noopener noreferrer">
										<button type="button" class="btn btn-outline-primary">
											<i class="fas fa-link" aria-hidden="true"></i>
										</button>
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="fw-semibold">ลิงก์ลงพื้นที่ (Link Checkers)</label>
							<div class="input-group form-inline gap-1">
								<input type="text" value="{{@$data->linkChecker}}" name="linkChecker" class="form-control {{ @$data->linkChecker == NULL ? 'bg-light' : '' }}" placeholder="Google Drives, One Drives" {{ @$data->linkChecker == NULL ? 'readonly' : '' }}>
								<span class="input-group-append">
									<a href="{{ @$data->linkChecker != NULL ? @$data->linkChecker : '#' }}" target="{{ @$data->linkChecker != NULL ? '_blank' : '' }}" rel="noopener noreferrer">
										<button type="button" class="btn btn-outline-primary" >
											<i class="fas fa-link" aria-hidden="true"></i>
										</button>
									</a>
								</span>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mb-3">
							<label class="fw-semibold">ลิงก์รับเล่มทะเบียน (Link LinkBook Receive)</label>
							<div class="input-group form-inline gap-1">
								<input type="text" value="{{@$data->LinkBookSpecial}}" name="LinkBookSpecial" class="form-control {{ @$data->LinkBookSpecial == NULL ? 'bg-light' : '' }}" placeholder="Google Drives, One Drives" {{ @$data->LinkBookSpecial == NULL ? 'readonly' : '' }}>
								<span class="input-group-append">
									<a href="{{ @$data->LinkBookSpecial != NULL ? @$data->LinkBookSpecial : '#' }}" target="{{ @$data->LinkBookSpecial != NULL ? '_blank' : '' }}" rel="noopener noreferrer">
										<button type="button" class="btn btn-outline-primary" >
											<i class="fas fa-link" aria-hidden="true"></i>
										</button>
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="fw-semibold">ลิงก์สัญญา (Link Contract)</label>
							<div class="input-group form-inline gap-1">
								<input type="text" value="{{ @$data->LinkUpload_Con }}" name="LinkUpload_Con" class="form-control" placeholder="Google Drives, One Drives">
								<span class="input-group-append">
								<a href="{{@$data->LinkUpload_Con}}" target="_blank" rel="noopener noreferrer">
									<button type="button" class="btn btn-outline-primary">
										<i class="fas fa-link" aria-hidden="true"></i>
									</button>
								</a>
								</span>
							</div>
						</div>
					</div>


					<div class="col-md-6">
						<label class="fw-semibold">วัตถุประสงค์ : </label>
						<select name="dataPurpose" id="dataPurpose" class="form-control form-select" >
							{{-- <option value="">--- กรุณาเลือกรายการ ---</option> --}}
							@foreach(@$dataPurpose as $value)
							<option value="{{$value->Code_PLT}}" {{ @$data->Data_Purpose == $value->Code_PLT ? 'selected' : '' }}>{{$loop->iteration.'. '.$value->Name_Purpose}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label class="fw-semibold">สิทธิ์อนุมัติ</label>
							<select class="form-select" name="UserApp_Con">
								<option selected value="">--- สิทธิ์อนุมัติ ---</option>
								@foreach($userApp as $user)
									<option {{ @$data->UserApp_Con == $user->id ? 'selected' : '' }} value="{{$user->id}}">
										{{$loop->iteration}}. {{$user->name}} ({{ implode(', ', $user->getRoleNames()->toArray()) }})
									</option>
								@endforeach
							</select>
						</div>
					</div>
                    <div class="col-md-12">
						<label class="fw-semibold">ผู้เกี่ยวข้อง</label>
                        <div class="input-group">
                            <div class="form-floating mb-0">
                                <select class="form-control" id="UserApp_relevant" name="UserApp_relevant[]" multiple="multiple" placeholder="Choose anything" style="font-size: 3rem !important;">
                                    @foreach($userApp as $user)
                                        <option {{ in_array($user->id, explode(",",@$data->UserApp_relevant)) ? 'selected' : '' }} value="{{$user->id}}">
                                            {{$loop->iteration}}. {{$user->name}} ({{ implode(', ', $user->getRoleNames()->toArray()) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-light border-secondary border-opacity-50 rounded-end d-flex align-items-center openDatepickerBtn_formfloating" type="button">
                                <img src="{{ asset('assets/images/icon/microsoft-teams.svg') }}" alt="">
                            </button>
                        </div>
                    </div>

					<div class="col-md-12">
						<div class="">
							<label class="fw-semibold label_Memo">หมายเหตุ</label>
							<textarea type="text" class="form-control Memo_Contracts" name="Memo_Contracts" id="Memo_Contracts" rows="5">{{@$data->Memo_Con}}</textarea>
						</div>
						<div class="row {{ @$data->Status_Con == 'cancel' ? '' : 'd-none' }}">
							<div class="col text-end">
								<p class="text-danger">ผู้ยกเลิก : {{ $data->UserCancel_Con }} วันที่ยกเลิก : {{ $data->DateCancel_Con }} </p>
							</div>
						</div>
					</div>
				</div>


			<!-- endcontent -->

        </div>

		<div class="modal-footer">
			<button type="button" id="btn_UpdateCon" class="btn btn-primary btn-sm waves-effect waves-light hover-up"> <span class="spinner"></span> บันทึก</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
		</div>
</div>

<!-- สคิรปต์ปุ่มใส่วันที่ -->
<script>
	$(document).ready(function(){
	  //$('#YearTableBtn').click();
	  $(".openDatepickerBtn").on('click', function() {
		$(this).siblings('input').focus();
	  });

	});
  </script>

<script> // popover
	  document.querySelectorAll('[data-bs-toggle="popover"]')
		.forEach(popover => {
		new bootstrap.Popover(popover)
    })
</script>

{{-- บันทึกโปรไฟล์สัญญา --}}
<script>
	$('#btn_UpdateCon').click(()=>{
			let id = sessionStorage.getItem('PactCon_id');
			let url = '{{ route('contract.update','ID') }}';
			let Memo_Contracts = $('#Memo_Contracts').val()
			url = url.replace('ID', id);

			$('#btn_UpdateCon').prop('disabled', true);
			$('<span />', {
			class : "spinner-border spinner-border-sm",
			role : "status"
			}).appendTo(".spinner");
				$.ajax({
					url : url,
					method : 'put',
					data : $('#formContracts').serialize(),
					success :async (res)=>{
							$('#btn_UpdateCon').prop('disabled', false);
							$('.spinner').empty();

							await swal.fire({
								icon : 'success',
								title : 'บันทึกข้อมูลสำเร็จ',
								text :'อัพเดทข้อมูลเรียบร้อย',
								timer: 2000,
								showConfirmButton: false,
							})

							$('#section-cardCon').html(res.htmlheader)
							$('#section-Tab').html(res.renderTab);
							await $('#modal_lg').modal('toggle');

					},
					error :async (err)=>{
						$('#btn_UpdateCon').prop('disabled', false);
						$('.spinner').empty();

                        await swal.fire({
                            icon : 'error',
                            title : `${ err.responseJSON.message}`,
                            text : `${ err.responseJSON.text}`,
                            showConfirmButton: true,
                        })
					}
				})

	})
</script>


<script>
    // select2
    $(document).ready(function() {

        $('#UserApp_relevant').select2( {
            theme: 'bootstrap-5',
        } );
    });
</script>
