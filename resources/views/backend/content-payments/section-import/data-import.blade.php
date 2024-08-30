<div class="card">
	<div class="card-body border-bottom pb-2">
		<div class="d-flex align-items-center">
			<h5 class="mb-0 card-title flex-grow-1">Jobs Lists</h5>
			<div class="flex-shrink-0">
				{{-- <ul class="list-inline user-chat-nav text-end pb-0 mb-0">
					<li class="list-inline-item d-none d-sm-inline-block me-0">
						<div class="dropdown">
							<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-cog"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#">View Profile</a>
								<a class="dropdown-item" href="#">Clear chat</a>
								<a class="dropdown-item" href="#">Muted</a>
								<a class="dropdown-item" href="#">Delete</a>
							</div>
						</div>
					</li>
					<li class="list-inline-item">
						<div class="dropdown">
							<button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-horizontal-rounded"></i>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else</a>
							</div>
						</div>
					</li>
				</ul> --}}
				<button type="button" class="btn btn-light waves-effect btn-label waves-light btn-rounded btn_process">
					<i class="mdi mdi-cog-clockwise mdi-spin label-icon text-warning"></i> ประมวลผล
				</button>
				<div class="dropdown d-inline-block">
					<button type="menu" class="btn btn-light rounded-circle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bx bx-dots-horizontal-rounded"></i>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						<li><a class="dropdown-item" href="#">Action</a></li>
						<li><a class="dropdown-item" href="#">Another action</a></li>
						<li><a class="dropdown-item" href="#">Something else here</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered align-middle nowrap table-striped table-hover font-size-12 table-datatable">
				<thead>
					<tr>
						<th class="text-center" scope="col">No</th>
						{{-- <th class="text-center" scope="col">เลขบัญชี</th> --}}
						<th class="text-center" scope="col">วันที่</th>
						<th class="text-center" scope="col">ชื่อ - นามสกุล</th>
						<th class="text-center" scope="col">REF1</th>
						<th class="text-center" scope="col">REF2</th>
						<th class="text-center" scope="col">trans kind</th>
						<th class="text-center" scope="col">trans code</th>
						<th class="text-center" scope="col">ยอดสุทธิ</th>
						{{-- <th class="text-center" scope="col">#</th> --}}
					</tr>
				</thead>
				<tbody>
					@foreach ($mergedDetails as $key => $item)
						<tr>
							<th class="text-center" scope="row">{{ $key + 1 }}</th>
							{{-- <td class="text-center input-mask" data-inputmask="'mask': '999-9-99999-9'">{{ @$item['COMPANY_ACCOUNT'] }}</td> --}}
							<td class="text-center">
								@php
									$date = \Carbon\Carbon::createFromFormat('dmY', @$item['PAYMENT_DATE']);
									$formattedDate = $date->format('d-m-Y');
								@endphp
								<i class="bx bx-time-five text-info me-1"></i>{{ $formattedDate }} {{substr(@$item['PAYMENT_TIME'], 0, 2) . ':' . substr(@$item['PAYMENT_TIME'], 2, 2)}}
							</td>
							<td><i class="bx bx-user-circle text-success me-1"></i>{{ $item['CUSTOMER_NAME'] }}</td>
							<td>
								<button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect waves-light">
									{{ $item['REF1'] }}
								</button>
							</td>
							<td>
								@if ($item['REF2'])
									<span class="badge badge-pill badge-soft-success font-size-12">{{ $item['REF2'] }}</span>
								@endif
							</td>
							<td class="text-center">{{ $item['TRANSACTION_KIND'] }}</td>
							<td class="text-center">{{ $item['TRANSACTION_CODE'] }}</td>
							<td class="text-end">
								{{ number_format(preg_replace('/^0+|00$/', '', $item['AMOUNT']),2) }}
							</td>
							{{-- <td class="text-center">
								<ul class="list-unstyled hstack gap-1 mb-0">
									<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
										<a href="#" class="btn btn-sm btn-soft-info"><i class="mdi mdi-pencil-outline"></i></a>
									</li>
									<li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Delete">
										<a href="#jobDelete" data-bs-toggle="modal" class="btn btn-sm btn-soft-danger"><i class="mdi mdi-delete-outline"></i></a>
									</li>
								</ul>
							</td> --}}
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(function () {
		$('.btn_process').click(function() {
			$('.content-import').addClass('d-none');
			$('.content-data').fadeIn('slow').attr('style', '');
		});
	});
</script>

<script>
	$(document).ready(function() {
		var table = $('.table-datatable').DataTable({
			"responsive": false,
			"autoWidth": true,
			"ordering": true,
			"lengthChange": true,
			"order": [
				[0, "asc"]
			],
			"pageLength": 10,
		});
	});

	$(function () {
		$(".input-mask").inputmask();
		$('[data-bs-toggle="tooltip"]').tooltip();
	});
</script>