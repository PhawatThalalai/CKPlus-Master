<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<div class="card p-2 h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			<img class="" src="{{ URL::asset('assets/images/gif/layers.gif') }}" alt="" style="width: 50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">{{ @$title }} </h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<p class="border-primary border-bottom mt-2"></p>
			<input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
		</div>
	</div>

	<div class="card-body my-0 pt-0 px-2">
		<div class="table-responsive">
			<table class="table align-middle table-hover text-nowrap border border-light font-size-12 dateHide view-sendcont">
				<thead class="">
					<tr class="bg-light">
						<th class="text-center" style="width: 5%"></th>
						<th class="text-center">เลขสัญญา</th>
						<th class="text-center">ประเภทสินเชื่อ</th>
						<th class="text-center">ชื่อลูกค้า</th>
						<th class="text-center">วันที่บันทึก</th>
						<th class="text-center">สถานะเอกสาร</th>
						<th class="text-center" style="width: 8%">#</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $row)
						<tr id="row{{ @$row->id }}">
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
								@if (@$row->Status_Con == 'cancel')
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกสัญญา</span>
								@else
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : {{ @$row->StatusApp_Con }}</span>
								@endif
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
									{{ @$row->Loan_Name }}
								</button>
							</td>
							<td class="">
								<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
									<i class="bx bx-calendar-event text-success"></i>
								</button>
								<span class="">{{ date('d-m-Y', strtotime($row->date_TrackPart)) }}</span>
							</td>
							<td class="text-center">
								<button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect waves-light">
									<i class="mdi mdi-file-document-edit me-1"></i>{{ @$row->name_th }}
								</button>
							</td>
							<td class="text-center">
								<ul class="list-inline font-size-20 contact-links mb-0">
									<li class="list-inline-item px-2" data-bs-toggle="tooltip" title="รายละเอียด">
										<a href="{{ route('audit.edit', $row->id) }}?page={{ 'auditCheckContent' }}" class="hover-up"><i class="mdi mdi-file-document-edit text-info"></i></a>
									</li>
								</ul>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var table = $('.view-sendcont').DataTable({
			"drawCallback": function() {
				var position1Th = $('.view-sendcont thead th:nth-child(1)');
				var position2Th = $('.view-sendcont thead th:nth-child(2)');
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
