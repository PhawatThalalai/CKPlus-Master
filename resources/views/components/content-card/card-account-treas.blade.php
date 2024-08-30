<style>
	.detail-tooltip {
		--bs-tooltip-bg: var(--bs-info);
	}
</style>

<div class="card rounded-4 bg-info bg-soft m-1" style="max-width : 400px; min-width : 320px;">
	<div class="card-header">
		<div class="row py-1">
			<div class="col-9 text-nowrap ">
				<h5 class="mb-1 fw-semibold text-secondary"> {{ @$data['nameCusTH'] }} </h5>
				<p class="mb-1 text-secondary"> ( {{ $data['nameCusENG'] != null ? @$data['nameCusENG'] : '' }} ) </p>
				@if (@$data['status'] == 'Payee')
					<span class="text-secondary d-inline-block text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="detail-tooltip" data-bs-title="{{ @$data['typeStatus'] }} ({{ @$data['typeCus'] }})">
						สถานะ : {{ @$data['typeStatus'] }} ({{ @$data['typeCus'] }})</span>
				@elseif(@$data['status'] == 'Broker')
					<span class="text-secondary d-inline-block text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="detail-tooltip" data-bs-title="({{ @$data['typeBroker'] }})">
						สถานะ : ({{ @$data['typeBroker'] }})</span>
				@else
					<span class="text-secondary d-inline-block text-truncate">.</span>
				@endif
			</div>
			<div class="col-3 text-end">
				@isset($data['imageCus'])
					<img src="{{ URL::asset($data['imageCus']) }}" alt="" class="avatar-sm rounded-4 d-block mx-auto bg-primay bg-soft p-1 border border-2 border-light">
				@else
					<img src="{{ URL::asset('assets/images/userTreas.png') }}" alt="" class="avatar-sm rounded-4 d-block mx-auto bg-primay bg-soft p-1 border border-2 border-light">
				@endisset
				<div class="row mt-1 px-2">
					<div class="badge rounded-pill  {{ @$data['status'] == 'Broker' ? 'bg-warning' : 'bg-success' }} "><span class="font-size-10">{{ @$data['statusTxt'] }}</span> </div>
				</div>
			</div>
		</div>
	</div>
	<form id="transfer{{ @$data['status'] }}-{{ @$data['idCus'] }}">
		<div class="card-body pb-2 pt-3 section bg-white rounded-4">
			<div class="row">
				<div class="col">
					<div class="">
						<input type="hidden" name="page" value="manage-credit">
						<input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
						<input type="hidden" name="TransactionDetail" value="withdraw">
						<input type="hidden" name="TransactionTxt" value="โอนเงิน (WITHDRAW)">
						<input type="hidden" name="status" value="{{ @$data['status'] }}">
						<input type="hidden" name="pact_id" value="{{ @$data['pact_id'] }}">
						<input type="hidden" name="CusID" value="{{ @$data['idCus'] }}">
						<input type="hidden" name="accout_status" class="accout_status" value="">
						<h5 class="card-title font-size-12">ข้อมูลการโอน (Tranfer Details)</h5>
						<div class="table-responsive">
							<table class="table table-sm mb-0 font-size-11">
								<tbody>
									<tr data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="detail-tooltip" data-bs-title="{{ @$data['numberAccount'] }}">
										<th>เลขบัญชี : </th>
										<th class="text-end">{{ Str::limit(@$data['numberAccount'], 20) }}</th>
									</tr>
									<tr data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="detail-tooltip" data-bs-title="{{ @$data['nameAccount'] }}">
										<th>ธนาคาร :</th>
										<th class="text-end">{{ Str::limit(@$data['nameAccount'], 20) }}</th>
									</tr>
									<tr data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="detail-tooltip" data-bs-title="{{ @$data['Phone'] }}">
										<th>เบอร์ติดต่อ :</th>
										<th class="text-end">{{ Str::limit(@$data['Phone'], 20) }}</th>
									</tr>
									<tr>
										<th>จำนวนเงิน :</th>
										<th class="text-end text-success">{{ number_format(@$data['balance'],2) }}</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row py-2">
				<div class="row g-2">
					<div class="col-12">
						<h6 class="card-title font-size-12 text-decoration-underline">การชำระ</h6>
					</div>
					<div class="col-6">
						<label class="card-radio-label mb-3">
							<input type="radio" value="Transfer-money" name="Pay_method" id="Pay_method-{{ @$data['status'] }}-{{ @$data['id'] }}" class="card-radio-input typeCash" {{ @$data['Pay_method'] == 'Transfer-money' ? 'checked' : '' }} >
							<div class="card-radio"><i class="fab fa-cc-paypal font-size-24 text-primary align-middle me-2"></i><span> เงินโอน </span></div>
						</label>
					</div>
					<div class="col-6">
						<label class="card-radio-label mb-3">
							<input type="radio" value="Cash" name="Pay_method" id="Pay_method-{{ @$data['status'] }}-{{ @$data['id'] }}"  class="card-radio-input typeCash" {{ @$data['Pay_method'] == 'Cash' ? 'checked' : '' }} >
							<div class="card-radio"><i class="fab fas fa-money-bill-alt font-size-24 text-warning align-middle me-2"></i><span> เงินสด </span></div>
						</label>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-12">
						<h6 class="card-title font-size-12">เลือกบัญชีเงินออก</h6>
					</div>
					<div class="col-12">
						<div class=" border-1 border-bottom border-primary border-opacity-50">
							<select name="Bank_id" id="Bank_id-{{ @$data['status'] }}-{{ @$data['id'] }}" class="form-control Bank_id form-select border-0" style="pointer-events : {{ @$data['statusTransfer'] == 'yes' ? 'none;' : 'block;' }}">
								<option value="">--- เลือกบัญชีเงินออก ---</option>
								@foreach ($data['bankAccount'] as $item)
									<option value="{{ $item->id }}" {{ @$data['transferBank'] == $item->id ? 'selected' : '' }} cusID = "{{ @$data['idCus'] }}" Bank_Zone = "{{ @$item->User_Zone }}" amount = "{{ @$item->Amount_after }}" accout-status="reansfer">{{ $item->Account_Number }} ( {{ $item->Account_Bank }} )</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				@if ( (@$data['checkCom'] && @$data['bankAccountReceive'] && @$data['status'] == 'CloseAcount') || @$data['Status_Com'] == 'IN' )
					<div class="row mb-2">
						<div class="col-12">
							<h6 class="card-title font-size-12">บัญชีที่รับเงิน</h6>
						</div>
						<div class="col-12">
							<div class=" border-1 border-bottom border-primary border-opacity-50">
								<select name="Bank_idReceive" id="Bank_idReceive-{{ @$data['status'] }}-{{ @$data['id'] }}" class="form-control Bank_id form-select border-0" style="pointer-events : {{ @$data['statusTransfer'] == 'yes' ? 'none;' : 'block;' }}">
									<option value="">--- เลือกบัญชีที่รับเงิน ---</option>
									@foreach (@$data['bankAccountReceive'] as $item)
										<option value="{{ $item->id }}" {{ @$data['transferBank'] == $item->id ? 'selected' : '' }} cusID = "{{ @$data['idCus'] }}" Bank_Zone = "{{ @$item->User_Zone }}" amount = "{{ @$item->Amount_after }}" accout-status="receive">{{ $item->Account_Number }} ( {{ $item->Account_Bank }} )</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				@else
					<div class="row mb-2">
						<div class="col-12">
							<h6 class="card-title font-size-12">บัญชีที่รับเงิน</h6>
							<div class=" border-1 border-bottom border-primary border-opacity-50">
								<input value="{{ Str::limit(@$data['numberAccount'], 20) }}" class="form-control border-0 text-end" placeholder="บัญชีที่รับเงิน" readonly>
							</div>
						</div>
					</div>
				@endif

				<div class="row mb-2">
					<div class="col-12">
						<h6 class="card-title font-size-12">ยอดโอน </h6>
						<div class="d-flex border-1 border-bottom border-primary border-opacity-50">
                            @if(auth()->user()->zone == 50)
                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend" onClick="myFunction('expenses{{ @$data['status'] }}-{{ @$data['idCus'] }}')">
                                    <a class="ms-1" type="button" onclick="$('#expenses{{ @$data['status'] }}-{{ @$data['idCus'] }}').prop('readonly',false).removeClass('bg-light')" {{ @$data['statusTransfer'] == 'yes' ? 'disabled' : '' }}> <i class="bx bx-edit-alt"></i> </a>
                                </span>
                            @endif
							<input type="number" value="{{ @$data['amount'] }}" name="expenses" id="expenses{{ @$data['status'] }}-{{ @$data['idCus'] }}" data-bts-prefix="1" class="form-control form-control-sm text-end border-0 " readonly>
						</div>
					</div>
				</div>
				@if ( (@$data['checkCom'] && @$data['bankAccountReceive'] && @$data['status'] == 'CloseAcount') || @$data['Status_Com'] == 'IN')
					<div class="row mb-2">
						<div class="col-12">
							<h6 class="card-title font-size-12">ผู้รับเงินสด</h6>
							<div class=" border-1 border-bottom border-primary border-opacity-50">
								<input value="{{ @$data['Person_Close'] }}" name="Person_Close" type="text" class="form-control border-0 text-end" placeholder="กรอกชื่อผู้รับเงินสด">
							</div>
						</div>
					</div>
				@else
					<div class="row mb-2">
						<div class="col-12">
							<h6 class="card-title font-size-12">ผู้รับเงินสด</h6>
							<div class=" border-1 border-bottom border-primary border-opacity-50">
								<input value="" name="Person_Close" type="text" class="form-control border-0 text-end" placeholder="-" readonly>
							</div>
						</div>
					</div>
				@endif

				<div class="row mt-2">
					<div class="col d-grid">
						<button id="{{ $data['btn_idTransfer'] }}" class="btn {{ @$data['statusTransfer'] == 'yes' ? ' btn-success' : ' btn-primary' }} btn-transfer rounded-pill btn-sm" bank = "{{ @$data['status'] }}-{{ @$data['id'] }}" status = "{{ @$data['status'] }}" cusID = "{{ @$data['idCus'] }}" type="button">
							<span class="transfered">
								{{ @$data['statusTransfer'] == 'yes' ? 'โอนเงินแล้ว' : 'โอนเงิน' }} <i class="bx bx-transfer"></i>
							</span>
							<span class="loading" style="display: none;">
								<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
								กำลังทำรายการ...
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	document.querySelectorAll('[data-bs-toggle="tooltip"]')
		.forEach(tooltip => {
			new bootstrap.Tooltip(tooltip)
		})
</script>


<script>
    function myFunction(input) {
      var selectAll = document.getElementById(input);
      selectAll.select();
    }
</script>
