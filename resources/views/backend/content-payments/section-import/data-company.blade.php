<style>
	.card-bank {
		position: relative;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		border-radius: 10px;
		/* border: solid 4px rgba(255, 255, 255, 0.1); */
		background-image: url("{{ asset('assets/images/layouts/bg-company.webp') }}");
		background-position: center;
		background-size: cover;
		/* box-shadow: rgba(255, 255, 255, 0.25) 0px 54px 55px,
			rgba(255, 255, 255, 0.12) 0px -12px 30px,
			rgba(255, 255, 255, 0.12) 0px 4px 6px,
			rgba(255, 255, 255, 0.17) 0px 12px 13px,
			rgba(255, 255, 255, 0.09) 0px -3px 5px; */
	}

	.card-bank input[type="text"] {
		background: inherit;
		color: rgb(59, 58, 58);
		border-radius: 10px;
		padding: 5px;
	}

	.Image1 {
		margin-top: 5px;
		width: 120px;
		/* height: 120px; */
	}
</style>

{{-- <div class="card card-bank mb-3">
	<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			@foreach ($detailBank as $key => $bank)
				<div class="carousel-item {{ $loop->last ? 'active' : '' }}" data-bs-interval="3000">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-shrink-0 me-5 up-down">
								<div class="avatar-md">
									<img class="Image1" src="https://i.ibb.co/hgJ7z3J/6375aad33dbabc9c424b5713-card-mockup-01.png" alt="credit" border="0"></a>
								</div>
							</div>
							<div class="flex-grow-1 overflow-hidden">
								<h5 class="text-truncate font-size-15 fw-semibold"><a href="javascript: void(0);" class="text-muted"><ins>{{ @$bank->company_th }}</ins></a></h5>
								<p class="text-truncate text-muted mb-3 mt-n2 d-flex align-items-center"><i class=" mdi mdi-bank text-info me-1 font-size-13"></i>สาขา : {{ @$bank->zone_th }}</p>

								<p class="text-truncate fw-semibold font-size-18 mb-0 d-flex align-items-center"><i class="bx bx-credit-card text-info me-1"></i>{{ @$bank->bank_th }}</p>
								<form>
									<div class="row mt-1">
										<div class="col-6">
											<div class="form-floating">
												<input type="text" class="form-control font-size-14 border-0 text-decoration-underline fw-semibold" id="number" value="{{ @$bank->accountbank }}">
												<label for="number" class="text-info">card number</label>
											</div>
										</div>
										<div class="col-6">
											<div class="form-floating">
												<input type="text" class="form-control font-size-14 border-0 text-decoration-underline fw-semibold" id="code" value="{{ @$bank->code }}">
												<label for="code" class="text-info">code</label>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="px-4 py-0 border-top">
						<div class="table-responsive">
							<table class="table align-middle mb-0">
								<tbody>
									<tr>
										<td>
											<button type="button" class="btn btn-warning btn-sm btn-rounded font-size-13">
												<i class="bx bx-bell bx-tada"></i>
												@if (@$bank->company_type == 1)
													ประเภท สินเชื่อเงินกู้
												@else
													ประเภท สินเชื่อเช่าซื้อ
												@endif
											</button>
										</td>
										<td class="text-end">
											<p class="text-muted mb-1 fw-semibold font-size-13">จำนวนราย</p>
											<span class="badge bg-success font-size-13 text-opacity-75"> {{ count(@$mergedDetails) }} ราย</span>
										</td>
										<td class="text-end">
											@php
												$totalAmount = array_sum(array_map(function ($item) {
														return (int) $item['AMOUNT'];
													}, $mergedDetails),
												);
											@endphp
											<p class="text-muted mb-1 fw-semibold font-size-13 ">ยอดรวม</p>
											<span class="badge bg-success font-size-13 text-opacity-75"> {{ number_format(@$totalAmount, 2) }}</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div> --}}

<div class="card card-bank mb-3">
	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			@foreach ($detailBank as $key => $bank)
				<div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="3000">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-shrink-0 me-5 up-down">
								<div class="avatar-md">
									<img class="Image1" src="https://i.ibb.co/hgJ7z3J/6375aad33dbabc9c424b5713-card-mockup-01.png" alt="credit" border="0"></a>
								</div>
							</div>
							<div class="flex-grow-1 overflow-hidden">
								<h5 class="text-truncate font-size-14 fw-semibold"><a href="javascript: void(0);" class="text-muted"><ins>{{ @$bank->company_th }}</ins></a></h5>
								<p class="text-truncate text-muted mb-3 mt-n2 d-flex align-items-center"><i class=" mdi mdi-bank text-info me-1 font-size-12"></i>สาขา : {{ @$bank->zone_th }}</p>

								<p class="text-truncate fw-semibold font-size-16 mb-0 d-flex align-items-center"><i class="bx bx-credit-card text-info me-1"></i>{{ @$bank->bank_th }}</p>
								<form>
									<div class="row mt-1">
										<div class="col-6">
											<div class="form-floating">
												<input type="text" class="form-control font-size-13 border-0 text-decoration-underline fw-semibold" id="number" value="{{ @$bank->accountbank }}">
												<label for="number" class="text-info">card number</label>
											</div>
										</div>
										<div class="col-6">
											<div class="form-floating">
												<input type="text" class="form-control font-size-13 border-0 text-decoration-underline fw-semibold" id="code" value="{{ @$bank->code }}">
												<label for="code" class="text-info">code</label>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="px-4 py-0 border-top">
						<div class="table-responsive">
							<table class="table align-middle mb-0">
								<tbody>
									<tr>
										<td>
											<button type="button" class="btn btn-warning btn-sm btn-rounded font-size-11">
												<i class="bx bx-bell bx-tada"></i>
												@if (@$bank->company_type == 1)
													ประเภท สินเชื่อเงินกู้
												@else
													ประเภท สินเชื่อเช่าซื้อ
												@endif
											</button>
										</td>
										<td class="text-end">
											<p class="text-muted mb-1 fw-semibold font-size-11">จำนวนราย</p>
											<span class="badge bg-success font-size-11 text-opacity-75"> {{ count(@$details[$key]) }} ราย</span>
										</td>
										<td class="text-end">
											@php
												$totalAmount = array_sum(array_map(function ($item) {
														return (int) $item['AMOUNT'];
													}, @$details[$key]),
												);
											@endphp
											<p class="text-muted mb-1 fw-semibold font-size-11">ยอดรวม</p>
											<span class="badge bg-success font-size-11 text-opacity-75"> {{ number_format(@$totalAmount, 2) }}</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>

<script>
	$(document).ready(function() {
		var myCarousel = document.querySelector('#carouselExampleIndicators')
		var carousel = new bootstrap.Carousel(myCarousel)
	});
</script>
