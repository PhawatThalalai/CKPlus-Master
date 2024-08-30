<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<div class="card p-2 h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			<img class="" src="{{ URL::asset('assets/images/gif/layers.gif') }}" alt="" style="width: 50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">รายการสินเชื่อ ( Loan Informations )</h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<p class="border-primary border-bottom mt-2"></p>
			<input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
		</div>
	</div>
	<div class="table-responsive">
		<table class="table align-middle table-hover text-nowrap border border-light font-size-12 dateHide view-contract">
			<thead>
				<tr class="bg-light">
					<th class="text-center" style="width: 5%">#</th>
					<th class="text-center">เลขสัญญา</th>
					<th class="text-center">สถานะ</th>
					<th class="text-center">วันส่งสัญญา</th>
					<th class="text-center">ชื่อลูกค้า</th>
					<th class="text-center">ทะเบียน</th>
					<th class="text-center">ยอดจัด</th>
					<th class="text-center" style="width: 8%"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $row)
				{{-- @php
					$Check_image = true;
					$ch = curl_init(@$row->image_cus); 
			   
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
					curl_setopt($ch, CURLOPT_NOBODY, true);
					
					curl_exec($ch);
					
					$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
					
					curl_close($ch);
					
					if (strpos($content_type, 'image') !== false) {
						$Check_image = true;
					} else {
						$Check_image = false;
					}
				@endphp --}}
		   			
					<tr id="row{{ $row->id }}">
						<td class="text-center">
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
							<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$row->Contract_Con }}</a></h5>
							@if (@$row->Status_Con == 'active')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-info">สถานะ : {{@$row->StatusApp_Con}}</span>
							@elseif (@$row->Status_Con == 'pending')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : {{@$row->StatusApp_Con}}</span>
							@elseif (@$row->Status_Con == 'complete' or @$row->Status_Con == 'transfered' or @$row->Status_Con == 'close')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : {{@$row->StatusApp_Con}}</span>
							@elseif (@$row->Status_Con == 'cancel')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : {{@$row->StatusApp_Con}}</span>
							@endif
						</td>
						<td class="text-center">
							@if (@$row->ContractToTypeLoan->id_rateType != 'land' || @$row->ContractToTypeLoan->id_rateType != 'person')
								<button type="button" class="btn {{empty(@$row->DateCheck_Bookcar)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="เช็คเล่มทะเบียน : {{empty(@$row->DateCheck_Bookcar)? 'No' : 'Yes'}}">
									<i class="mdi mdi-shield-car prem"></i>
								</button>
							@endif
							<button type="button" class="btn {{empty(@$row->DocApp_Con)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="ขออนุมัติ : {{empty(@$row->DocApp_Con)? 'No' : 'Yes'}}">
								<i class="mdi mdi-book-check-outline prem"></i>
							</button>
							<button type="button" class="btn {{empty(@$row->statusDoc)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="ตรวจสอบเอกสาร : {{empty(@$row->statusDoc)? 'No' : 'Yes'}}">
								<i class="bx bx-receipt prem"></i>
							</button>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
								<i class="bx bx-calendar-event text-success"></i>
							</button>
							<span class="">{{ date('d-m-Y', strtotime($row->Date_con)) }}</span>
						</td>
						<td> {{ @$row->Name_Cus }} </td>
						<td> {{ @$row->licence }} </td>
						<td class="text-end"> {{ number_format(@$row->cash, 0) }} </td>
						<td class="text-center">
							<ul class="list-inline font-size-18 contact-links mb-0">
								<li class="list-inline-item px-2">
									<div class="btn-group">
										<a type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="พิมพ์"> 
											<i class="bx bxs-printer hover-up text-info bg-soft"></i>
										</a>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="{{ route('report.create') }}?report={{'PaymentForm'}}&id={{@$row->id}}" target="_blank"><i class="bx bx-customize"></i> Payments</a>
											<a class="dropdown-item" href="{{ route('report.create') }}?report={{'ContractForm'}}&id={{@$row->id}}" target="_blank"><i class="bx bx-id-card"></i> ฟอร์มสัญญา</a>
										</div>
									</div>
									<a href="{{ route('contract.edit', $row->id) }}?funs={{'contract'}}&loanCode={{ $loanCode }}" data-bs-toggle="tooltip" title="รายละเอียดสัญญา">
										<i class="bx bx-fridge hover-up text-warning bg-soft"></i>
									</a>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{{-- <table class="table table-hover text-nowrap viewWalkin dateHide text-center">
			<tbody>
				@foreach ($data as $row)
					<tr>
						<td class="text-left">
							<span class="{{ $row->Approve_monetary != null ? 'text-success' : '' }}">
								{{ $row->Contract_Con }}
							</span>
							@if (@$row->Status_Con != 'cancel')
								<small class="badge float-right ml-1 {{ $row->ConfirmApp_Con != null ? 'badge-success' : 'badge-warning' }}" title="สัญญาสมบูรณ์">
									<i class="fas fa-user-check text-warning"></i>
								</small>
								<small class="badge float-right ml-1 {{ $row->ConfirmDocApp_Con != null ? 'badge-success' : 'badge-warning' }}" title="อนุมัติ">
									<i class="fas fa-user-lock text-warning"></i>
								</small>
								<small class="badge float-right {{ $row->DocApp_Con != null ? 'badge-success' : 'badge-warning' }}" title="ขออนุมัติ">
									<i class="fas fa-file-signature text-warning"></i>
								</small>
							@else
								<span class="fa-stack float-right  text-danger" style="vertical-align: top;" data-toggle="tooltip" title="" data-original-title="ยกเลิกสัญญา">
									<i class="fas fa-circle fa-stack-2x"></i>
									<i class="fas fa-user-xmark fa-stack-1x fa-inverse"></i>
								</span>
							@endif
						</td>
						<td class="text-left">
							<p>{{ date_format(date_create(@$row->Date_con), 'Ymd') }} </p>
							{{ date('d-m-Y', strtotime($row->Date_con)) }}
						</td>
						<td class="text-left"> {{ $row->Name_Cus }} </td>
						<td class="text-center">
							@if (@$row->DateCheck_Bookcar == null && (@$row->id_rateType != 'land' || @$row->id_rateType != 'person'))
								<i class="fa fa-fire prem " style="color: red" title="ยังไม่เช็คเล่มทะเบียน"></i>
							@endif
							{{ @$row->brand }}
						</td>
						<td class="text-center">{{ @$row->licence }} </td>
						<td class="text-right"> {{ number_format(@$row->cash, 0) }} </td>
						<td class="text-right">
							<div class="dropdown" data-bs-toggle="tooltip" title="พิมพ์">
								<button class="btn btn-info btn-sm hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="avatar-title bg-transparent text-reset">
										<i class="fas fa-print"></i>
									</span>
								</button>
								<div class="dropdown-menu">
									<a href="{{ route('report.create') }}?type=2&id={{@$row->id}}" target="_blank" class="dropdown-item SizeText" title="ใบนำฝากชำระเงิน"><i class="fas fa-file-invoice-dollar fs-5"></i> Payments</a>
									<a href="{{ route('report.create') }}?type=1&id={{@$row->id}}" target="_blank" class="dropdown-item SizeText" title="แบบฟอร์มขออนุมัติสัญญา"><i class="fas fa-file-alt fs-5"></i> ฟอร์มสัญญา</a>
								</div>
								<a href="{{ route('contract.edit', $row->id) }}?type={{ 1 }}&loanCode={{ $loanCode }}" class="btn btn-warning btn-sm hover-up" title="แก้ไขรายการ">
									<i class="far fa-edit"></i>
								</a>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table> --}}
	</table>
</div>

<script>
	$(document).ready(function() {
		var table = $('.view-contract').DataTable({
			"drawCallback": function() {
				var position1Th = $('.view-contract thead th:nth-child(1)');
				var position2Th = $('.view-contract thead th:nth-child(2)');
				position2Th.attr('colspan', 2);
				position1Th.hide();
			},
			"responsive": false,
			"autoWidth": false,
			"ordering": true,
			"lengthChange": true,
			"order": [
				[0, "asc"]
			],
			"pageLength": 10,
		});
	});
</script>