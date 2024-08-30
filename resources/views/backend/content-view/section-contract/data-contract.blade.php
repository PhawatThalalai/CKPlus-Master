<div class="card p-2 h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			{{-- <img src="assets/images/signature.png" alt="" style="width: 50px;"> --}}
			<img class="" src="{{ URL::asset('assets/images/gif/layers.gif') }}" alt="" style="width: 50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">สร้างสัญญา ( Create Contracts )</h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<p class="border-primary border-bottom mt-2"></p>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table align-middle table-hover text-nowrap dateHide createContract border border-light font-size-12">
			<thead>
				<tr class="bg-light">
					<th class="text-center" style="width: 5%">#</th>
					<th class="text-center">เลขสัญญา</th>
					<th class="text-center">ชื่อลูกค้า</th>
					<th class="text-center">ประเภท</th>
					<th class="text-center">วันที่โอนเงิน</th>
					<th class="text-center">ดิวงวดแรก</th>
					<th class="text-center" style="width: 8%"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data as $row)
					<tr id="row{{ $row->id }}">
						<td class="text-center">
							<div class="d-flex justify-content-center">
								<div class="flex-shrink-0 me-3">
									<div class="avatar-xs">
										<div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
											{{ $row->CodeLoan_Con }}
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>
							<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$row->Contract_Con }}</a></h5>
							@if (@$row->Flag_Inside != null)
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">card : active</span>
							@else
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">card : wait</span>
							@endif
						</td>
						<td> {{ @$row->Name_Cus }} </td>
						<td class="text-center">
							<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
								{{ @$row->Loan_Name }}
							</button>
						</td>
						<td class="text-center">
							<p>{{ date_format(date_create(@$row->Date_monetary), 'Ymd') }} </p>
							{{ date('d-m-Y', strtotime($row->Date_monetary)) }}
						</td>
						<td class="text-center">
							<p>{{ date_format(date_create(@$row->DateDue_Con), 'Ymd') }} </p>
							{{ date('d-m-Y', strtotime($row->DateDue_Con)) }}
						</td>
						<td class="text-center">
							<ul class="list-inline font-size-18 contact-links mb-0">
								<li class="list-inline-item px-2">
									@if ($row->Flag_Inside == 'Y')
										<a href="{{ route('contracts.edit', $row->id) }}?page={{ 'contract' }}" data-bs-toggle="tooltip" title="รายละเอียดสัญญา">
											{{-- <i class="bx bx-user-circle hover-up text-info bg-soft"></i> --}}
											<i class="bx bx-food-menu hover-up text-info bg-soft"></i>
										</a>
										@hasrole(['superadmin','administrator'])

                                        <a onclick="deleteContract({{@$row->id}})">
											<i class="bx bx-trash text-danger hover-up"></i>
										</a>
										@endhasrole
									@else
										<a href="#" data-link="{{ route('view-backend.create') }}?type={{ 1 }}&id={{ $row->id }}&newtdate={{ @$newtdate }}&newfdate={{ @$newfdate }}" class="data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="สร้างการ์ด">
											<i class="mdi mdi-book-plus-outline hover-up text-warning bg-soft"></i>
										</a>
									@endif
								</li>
							</ul>
						</td>

						{{-- <td>
							<button type="button" class="btn btn-soft-primary btn-sm hover-up" data-toggle="dropdown" title="พิมพ์">
								<i class="fas fa-print"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="?type=10" target="_blank" class="dropdown-item SizeText" title="ใบนำฝากชำระเงิน"><i class="fa-solid fa-qrcode pr-1"></i> Payments</a></li>
								<li class="dropdown-divider"></li>
								<li><a href="?type=9" target="_blank" class="dropdown-item SizeText" title="แบบฟอร์มขออนุมัติสัญญา"><i class="fa-solid fa-address-card pr-1"></i> ฟอร์มสัญญา</a></li>
							</ul>

							@if ($row->Flag_Inside == 'Y')
								<a href="{{ route('contracts.edit', $row->id) }}?type={{ 1 }}" class="btn btn-success btn-sm hover-up" title="เลือกรายการ">
									<i class="fas fa-share-square"></i>
								</a>
							@else
								<a href="#" data-bs-toggle="modal" data-bs-target="#modal_xl_2" data-link="{{ route('view-backend.create') }}?type={{ 1 }}&id={{ $row->id }}&newtdate={{ @$newtdate }}&newfdate={{ @$newfdate }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">
									<i class="far fa-edit"></i>
								</a>
							@endif
						</td> --}}
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function() {
		var table = $('.createContract').DataTable({
			"drawCallback": function() {
				var position1Th = $('.createContract thead th:nth-child(1)');
				var position2Th = $('.createContract thead th:nth-child(2)');
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

        deleteContract = (id) => {
            Swal.fire({
                text: "ต้องการลบสัญญานี้ ใช่หรือไม่ ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่, ต้องการนำออก!"
            }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('contracts.destroy','ID') }}"
                url = url.replace('ID',id)
                $.ajax({
                    url : url,
                    type : 'DELETE',
                    data : {
                        _token : '{{ @CSRF_TOKEN() }}'
                    },
                    success : (res)=>{
                        swal.fire({
                            icon : 'success',
                            text : 'success',
                            timer : 2000
                        })
                        $('#viewDataBranch').html(res.html)
                        $(`#row${res.idNow}`).addClass('bg-success bg-soft');
                    },
                    error : (err)=>{
                        swal.fire({
                            icon : 'error',
                            text : `${err.responseJSON.message}`,
                            timer : 2000
                        })
                    }
                });
                }
            });
        }

	});
</script>


