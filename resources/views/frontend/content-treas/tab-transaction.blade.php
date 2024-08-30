@if (@$flag == true)
	<div style="max-height: 300px; min-height: 300px;  overflow-y : scroll; overflow-x : hidden;">
		@if (count(@$banktransaction) != 0)
			@foreach ($banktransaction as $item)
				<div class="card rounded border border-2 border-light mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#transaction-{{ $item->id }}" aria-expanded="true" aria-controls="transaction-{{ $item->id }}">
					<div class="row p-2">
						<div class="col">
							<p class="fw-semibold mb-0">{{ @$item->TransactionTxt }}</p>
							<sup class="fw-semibold text-secondary mb-0">{{ date('d-m-Y', strtotime(@$item->transactionDate)) }}</sup>
						</div>
						<div class="col">
							<p class="fw-semibold {{ @$item->TransactionDetail == 'add-credit' || @$item->TransactionDetail == 'receive' ? 'text-success' : 'text-danger' }} text-end">{{ number_format($item->expenses,2) }} <span class="text-dark">บาท</span> </p>
						</div>
					</div>
				</div>
				<div id="transaction-{{ $item->id }}" class="accordion-collapse collapse">
					<div class="accordion-body bg-light p-2">
						<div class="row">
							<div class="col">
								<p class="fw-semibold">ผู้ทำรายการ</p>
								<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' ? 'hidden' : '' }}>ไปยังสัญญา</p>
								<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' ? 'hidden' : '' }}>ผู้รับ</p>
								<p class="fw-semibold">วันที่ทำรายการ</p>
								<p class="fw-semibold btn-memo-{{ @$item->id }}">บันทึก <a type="button" class="text-warning hover-up edit-memo" onclick="$('.content-memo-{{ @$item->id }} , .btn-memo-{{ @$item->id }}').toggle()"><i class="bx bx-pencil"></i></a> </p>
							</div>
							<div class="col text-end">
								<p class="fw-semibold">{{ @$item->CreditToUser->name }}</p>
								<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' ? 'hidden' : '' }}>{{ @$item->ConRecieveToCon->Contract_Con != null ? @$item->ConRecieveToCon->Contract_Con : '-' }}
								<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' ? 'hidden' : '' }}>{{ @$item->CusRecieveToCus->Name_Cus != null ? @$item->CusRecieveToCus->Name_Cus : '-' }}</p>
								<p class="fw-semibold">{{ @$item->created_at }}</p>
								<p class="fw-semibold text-memo-{{ @$item->id }} btn-memo-{{ @$item->id }}">{{ @$item->Memo != null ? @$item->Memo : '-' }}</p>
							</div>
							<span class="content-memo-{{ @$item->id }}" style="display:none;">
								<div class="row mb-1">
									<div class="col-12">
										<div class="form-floating">
											<textarea class="form-control" placeholder="Leave a comment here" id="memo-{{ @$item->id }}">{{ @$item->Memo != null ? @$item->Memo : '-' }}</textarea>
											<label for="floatingTextarea">บันทึก</label>
										</div>
									</div>
								</div>
								<div class="row g-1">
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-success btn-sm btn-saveMemo rounded-pill" onclick="saveMemo('{{ @$item->id }}')">บันทึก <i class="bx bx-save"></i></button>
									</div>
									<div class="col-6 d-grid">
										<button type="button" class="btn btn-secondary btn-sm  rounded-pill" onclick="$('.content-memo-{{ @$item->id }} , .btn-memo-{{ @$item->id }}').toggle()">ยกเลิก <i class="bx bx-x"></i></button>
									</div>
								</div>
							</span>
						</div>
					</div>
				</div>
			@endforeach
		@else
			<div class="row">
				<div class="col text-center">
					<div class="card" style="min-height : 200px; justify-content: space-evenly; align-items: center;">
						<img src="{{ asset('assets/images/empty-cart.png') }}" alt="report" class="" style="width:140px;">
						<p class="text-warning fw-semibold">ไม่มีข้อมูล !</p>
					</div>
				</div>
			</div>
		@endif
	</div>
@else
	<div style="max-height: 300px; min-height: 300px; overflow-y : scroll; overflow-x : hidden;">
		@php
			$DataTransaction = @$data['transaction']->filter(function ($value, $key) {
			    return $value->transactionDate == date('Y-m-d');
			});
		@endphp
		@if (count($DataTransaction) != 0)
			@foreach (@$data['transaction'] as $item)
				@if (@$item->transactionDate == date('Y-m-d'))
					<div class="card rounded border border-2 border-light mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#transaction-{{ $item->id }}" aria-expanded="true" aria-controls="transaction-{{ $item->id }}">
						<div class="row p-2">
							<div class="col">
								<p class="fw-semibold mb-0">{{ @$item->TransactionTxt }}</p>
                                <sup class="fw-semibold text-secondary mb-0">{{ date('d-m-Y', strtotime($item->transactionDate)) }}</sup>
							</div>
							<div class="col">
								<p class="fw-semibold {{ @$item->TransactionDetail == 'add-credit' || @$item->TransactionDetail == 'receive' ? 'text-success' : 'text-danger' }} text-end">{{number_format($item->expenses,2) }} <span class="text-dark">บาท</span> </p>
							</div>
						</div>
					</div>
					<div id="transaction-{{ $item->id }}" class="accordion-collapse collapse">
						<div class="accordion-body bg-light p-2">
							<div class="row">
								<div class="col">
									<p class="fw-semibold">ผู้ทำรายการ</p>
									<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail  == 'withdraw-credit' || @$item->TransactionDetail == 'receive' ? 'hidden' : '' }}>ไปยังสัญญา</p>
									<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail  == 'withdraw-credit' || @$item->TransactionDetail == 'receive' ? 'hidden' : '' }}>ผู้รับ</p>
									<p class="fw-semibold">วันที่ทำรายการ</p>
									<p class="fw-semibold btn-memo-{{ @$item->id }}">บันทึก <a type="button" class="text-warning hover-up edit-memo" onclick="$('.content-memo-{{ @$item->id }} , .btn-memo-{{ @$item->id }}').toggle()"><i class="bx bx-pencil"></i></a> </p>
								</div>
								<div class="col text-end">
									<p class="fw-semibold">{{ @$item->CreditToUser->name }}</p>
									<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' || @$item->TransactionDetail == 'receive' ? 'hidden' : '' }}>{{ @$item->ConRecieveToCon->Contract_Con != null ? @$item->ConRecieveToCon->Contract_Con : '-' }}
									<p class="fw-semibold" {{ $item->TransactionDetail == 'add-credit' || $item->TransactionDetail == 'withdraw-credit' || @$item->TransactionDetail == 'receive' ? 'hidden' : '' }}>{{ @$item->CusRecieveToCus->Name_Cus != null ? @$item->CusRecieveToCus->Name_Cus : '-' }}</p>
									<p class="fw-semibold">{{ @$item->created_at }}</p>
									<p class="fw-semibold text-memo-{{ @$item->id }} btn-memo-{{ @$item->id }}">{{ @$item->Memo != null ? @$item->Memo : '-' }}</p>
								</div>
								<span class="content-memo-{{ @$item->id }}" style="display:none;">
									<div class="row">
										<div class="col-12 m-auto">
											<div class="form-floating">
												<textarea class="form-control" placeholder="Leave a comment here" id="memo-{{ @$item->id }}">{{ @$item->Memo != null ? @$item->Memo : '-' }}</textarea>
												<label for="floatingTextarea">บันทึก</label>
											</div>
										</div>
										<div class="row g-1">
											<div class="col-6 d-grid">
												<button type="button" class="btn btn-success btn-sm btn-saveMemo rounded-pill" onclick="saveMemo('{{ @$item->id }}')">บันทึก <i class="bx bx-save"></i></button>
											</div>
											<div class="col-6 d-grid">
												<button type="button" class="btn btn-secondary btn-sm  rounded-pill" onclick="$('.content-memo-{{ @$item->id }} , .btn-memo-{{ @$item->id }}').toggle()">ยกเลิก <i class="bx bx-x"></i></button>
											</div>
										</div>
									</div>
								</span>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		@else
			<div class="row">
				<div class="col text-center">
					<div class="card" style="min-height : 200px; justify-content: space-evenly; align-items: center;">
						<img src="{{ asset('assets/images/empty-cart.png') }}" alt="report" class="" style="width:140px;">
						<p class="text-warning fw-semibold">ไม่มีข้อมูล !</p>
					</div>
				</div>
			</div>
		@endif
	</div>
@endif

<script>
	saveMemo = (dataId) => {
		// let dataId = $(e.currentTarget).attr('data-id')
		let Memo = $('#memo-' + dataId).val()
		let url = '{{ route('treas.update', ':ID') }}'
		$.ajax({
			url: url.replace(':ID', dataId),
			type: 'PUT',
			data: {
				Memo: Memo,
				fun: 'editMemo',
				_token: '{{ @CSRF_TOKEN() }}'
			},
			success: (res) => {
				$('.text-memo-' + dataId).html(res.Memo)
				$('#memo-' + dataId).val(res.Memo)
				$('.content-memo-' + dataId + ', .btn-memo-' + dataId).toggle()
			},
			error: (err) => {

			}
		})

	}
</script>
