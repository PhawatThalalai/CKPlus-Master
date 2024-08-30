<div class="modal-content">
	<form class="needs-validation" action="#" novalidate>
		<div class="modal-body">
			@if (count($data) != 0)
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
						<div class="card card-body">
							<div class="d-flex flex-wrap align-items-start">
								<div class="me-2">
									<h5 class="card-title mb-3">Top Visitors</h5>
								</div>
								<div class="dropdown ms-auto">
									<a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
										<i class="mdi mdi-dots-horizontal"></i>
									</a>

									<div class="dropdown-menu dropdown-menu-end">
										<a class="dropdown-item" href="#">Action</a>
										<a class="dropdown-item" href="#">Another action</a>
										<a class="dropdown-item" href="#">Something else here</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#">Separated link</a>
									</div>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-6">
									<div class="mt-3">
										<p class="text-warning mb-1">ยอดจัดรวม</p>
										<h6>{{ count($data) }} เคส</h6>
									</div>
								</div>

								<div class="col-6">
									<div class="mt-3">
										<p class="text-success mb-1">ยอดรวม (บาท)</p>
										<h6>{{ number_format($data->sum('Balance_Price'), 2) }} บาท</h6>
									</div>
								</div>
							</div>

							<div>
								<ul class="list-group list-group-flush">
									@foreach ($typeloans as $typeloan)
										@php
											$count = $data->where('Loan_Code', $typeloan->Loan_Code)->count();
										@endphp
										<li class="list-group-item" id="v-pills-tab-{{ $typeloan->id }}" data-bs-toggle="pill" href="#v-pills-{{ $typeloan->id }}" role="tab" aria-controls="v-pills-{{ $typeloan->id }}" aria-selected="false" tabindex="-1">
											<div class="py-2">
												<h5 class="font-size-13"><i class="bx bxs-label me-1 text-danger"></i>{{ $typeloan->Loan_Name }} <span class="float-end badge badge-pill badge-soft-warning font-size-12">{{ number_format(($count / count($data)) * 100,2) }} %</span></h5>
												<div class="progress animated-progess progress-sm">
													<div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($count / count($data)) * 100 }}%" aria-valuenow="{{ ($count / count($data)) * 100 }}" aria-valuemin="0" aria-valuemax="{{ count($data) }}"></div>
												</div>
												<h5 class="font-size-11 mt-1">จำนวน {{ $count }} เคส<span class="float-end text-success">{{ number_format(@$data->where('Loan_Code', $typeloan->Loan_Code)->sum('Balance_Price'), 2) }} บาท</span></h5>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 px-0">
						<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
							@foreach ($typeloans as $typeloan)
								<div class="tab-pane fade" id="v-pills-{{ $typeloan->id }}" role="tabpanel" aria-labelledby="v-pills-tab-{{ $typeloan->id }}">
									<div class="table-responsive" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
										<table class="table align-middle table-nowrap text-nowrap table-hover">
											<thead class="table-light sticky-top text-center">
												<tr class="font-size-12">
													<th class="text-center" style="width: 5%"></th>
													<th class="text-center">เลขสัญญา</th>
													<th class="text-center">สาขา</th>
													<th class="text-center">ชื่อลูกค้า</th>
													<th class="text-center">ยอดจัด</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach (@$data->where('Loan_Code', $typeloan->Loan_Code) as $row)
													<tr id="row{{ $row->id }}" class="font-size-11">
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
														<td class="text-center"> {{ @$row->Name_Branch }} </td>
														<td class="">
															<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
															<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
														</td>
														<td class="text-center">
															<button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect waves-light font-size-12">
																{{ number_format(@$row->Balance_Price, 2) }}
															</button>
														</td>
														<td class="text-center">
															<a type="button" class="btn btn-primary btn btn-sm detail-transfer" data-bs-toggle="modal" onclick="openModal('{{ route('treas.show',$row->id) }}?funs={{ 'show-transferCont' }}')">ทำรายการ <i class="bx bx-transfer"></i></a>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							@endforeach
							<div class="maintenance-img content-image p-3" id="content-image">
								<img src="{{ asset('assets/images/undraw/undraw_transfer_money.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="card-body p-4 m-4">
					<div class="text-center">
						<div class="avatar-md mx-auto mb-4">
							<div class="avatar-title bg-light rounded-circle text-primary h1">
								<img src="{{ asset('assets/images/gif/error.gif') }}" alt="report" class="avatar-sm" style="width:80px;height:80px">
							</div>
						</div>

						<div class="row justify-content-center">
							<div class="col-xl-10">
								<h4 class="text-warning">ไม่พบข้อมูล !</h4>
								<p class="text-muted font-size-14 mb-4">ไม่พบข้อมูลที่ค้นหา โปรดตรวจสอบความถูกต้องอีกครั้ง.</p>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</form>
</div>

<script>
	// $(document).on('click', '.detail-transfer', function(e) {
	// 	e.preventDefault();
	// 	var url = $(this).attr('data-link');

	// 	$('#modal_xl_static .modal-dialog').empty();
	// 	$('#modal_xl_static .modal-dialog').load(url, function(response, status, xhr) {
	// 		if (status === 'success') {
	// 			$('#modal_xl_static').modal('show');
	// 		} else {
	// 			// console.log('Load failed');
	// 		}
	// 	});
	// });

	openModal = (link) => {
		var url = link;
		$('#modal_xl_static .modal-dialog').empty();
		$('#modal_xl_static .modal-dialog').load(url, function(response, status, xhr) {
			if (status === 'success') {
				$('#modal_xl_static').modal('show');
			} else {
				// console.log('Load failed');
			}
		});
	}

	$('.list-group-item').click(function() {
		$('#content-image').hide();
	});
	
	$(".table-search").DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": false,
		"order": [
			[0, "asc"]
		],
		"pageLength": 10,
	});
</script>
