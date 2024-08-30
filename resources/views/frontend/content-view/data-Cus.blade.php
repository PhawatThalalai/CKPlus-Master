<div class="card p-2 table-responsive h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			<img class="" src="{{ URL::asset('assets/images/add-user.png') }}" alt="" style="width: 50px;">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">รายการรับลูกค้า ( New Customers )</h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<p class="border-primary border-bottom mt-2"></p>
			<input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
		</div>
	</div>
	<div class="table-responsive">
		<table class="viewWalkin dateHide table table-hover createContract border border-light font-size-12" id="table1">
			<thead>
				<tr class="bg-light">
					<th>#</th>
					<th class="">ชื่อ-สกุล</th>
					<th class="">วันที่รับ</th>
					<th class="">Tags</th>
					<th class="">ประเภทสินเชื่อ</th>
					<th class="">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($dataCus as $row)
					<tr>
						<td class="">
							<div>
								<img class="rounded-circle avatar-xs" src="{{ isset($row->image_cus) ? URL::asset(@$row->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
							</div>
						</td>
						<td>
							<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$row->Prefix }} : {{ @$row->Name_Cus }}</a></h5>
							@if (@$row->Status_Cus == 'active')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
							@elseif (@$row->Status_Cus == 'cancel')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
							@else
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
							@endif
						</td>
						<td class="">
							<i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
							<p>{{ date_format(date_create(@$row->date_Cus), 'Ymd') }} </p>
							{{ date('d-m-Y', strtotime(substr($row->date_Cus, 0, 10))) }}
						</td>
						<td>
							@if (isset($row->Code_Tag))
								<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">Tag : {{ @$row->Code_Tag }}</a></h5>
								@if (@$row->Status_Tag == 'complete')
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ส่งจัดไฟแนนซ์</span>
								@elseif (@$row->Status_Tag == 'inactive')
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกติดตาม</span>
								@else
									<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ติดตาม</span>
								@endif
							@else
								<h5 class="font-size-12 mb-1"><a role="button" class="text-secondary fst-italic text-opacity-50">ไม่พบข้อมูล</a></h5>
							@endif
						</td>
						<td class="">
							@if (isset($row->Loan_Name))
								<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
									{{ @$row->Loan_Name }}
								</button>
							@else
								<h5 class="font-size-12 mb-1"><a role="button" class="text-secondary fst-italic text-opacity-50">ไม่พบข้อมูล</a></h5>
							@endif
						</td>
						<td class="">
							<ul class="list-inline font-size-20 contact-links mb-0">
								<li class="list-inline-item px-2">
									<a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$row->id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft"></i></a>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() {
		var table = $('.viewWalkin').DataTable({
			"responsive": false,
			// "autoWidth": true,
			"ordering": true,
			"lengthChange": true,
			"order": [
				[0, "asc"]
			],
			"pageLength": 10,
		});
	});
</script>
