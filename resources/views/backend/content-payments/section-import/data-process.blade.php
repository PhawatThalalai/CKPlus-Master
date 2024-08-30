{{-- <div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-sm-4">
						<div class="search-box me-2 mb-2 d-inline-block">
							<div class="position-relative">
								<input type="text" class="form-control" placeholder="Search...">
								<i class="bx bx-search-alt search-icon"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="text-sm-end">
							<button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> New Customers</button>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table align-middle table-nowrap">
						<thead>
							<tr>
								<th>Username</th>
								<th>Phone / Email</th>
								<th>Address</th>
								<th>Rating</th>
								<th>Wallet Balance</th>
								<th>Joining Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Stephen Rash</td>
								<td>
									<p class="mb-1">325-250-1106</p>
									<p class="mb-0">StephenRash@teleworm.us</p>
								</td>

								<td>2470 Grove Street
									Bethpage, NY 11714</td>
								<td><span class="badge bg-success font-size-12"><i class="mdi mdi-star me-1"></i> 4.2</span></td>
								<td>$5,412</td>
								<td>07 Oct, 2019</td>
								<td>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="mdi mdi-dots-horizontal font-size-18"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div> --}}


<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0 me-3">
						<img src="{{ asset('assets/images/gif/plus-circle.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
					</div>
					<div class="flex-grow-1 align-self-center">
						<div class="text-muted">
							<div class="d-flex">
								<div class="flex-grow-1">
									<h6 class="text-success fw-semibold font-size-14">รายชื่อที่สามารถตัดได้</h6>
									<p class="mt-n1 fw-semibold font-size-11 badge badge-soft-success">จำนวน 0 รายการ</p>
								</div>
								<div class="ms-3">
									<div class="d-flex align-items-center">
										<div class="flex-shrink-0">
											<a href="#!" role="button" class="btn btm-sm btn-soft-success hover-up font-size-12"><i class="mdi mdi-content-save-move me-1"></i>บันทึก</a>
											<div class="dropdown d-inline-block">
												<button type="menu" class="btn btm-sm btn-light hover-up font-size-12" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
												<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
													<li><a class="dropdown-item" href="#">Action</a></li>
													<li><a class="dropdown-item" href="#">Another action</a></li>
													<li><a class="dropdown-item" href="#">Something else here</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<p class="border-primary border-bottom mt-n2"></p>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table align-middle table-nowrap font-size-11">
						<thead>
							<tr>
								<th>เลขสัญญา</th>
								<th>ประเภท</th>
								<th>ชื่อ - สกุล</th>
								<th>ยอดสุทธิ</th>
								<th>Wallet Balance</th>
								<th>Joining Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Stephen Rash</td>
								<td>
									<p class="mb-1">325-250-1106</p>
									<p class="mb-0">StephenRash@teleworm.us</p>
								</td>

								<td>2470 Grove Street
									Bethpage, NY 11714</td>
								<td><span class="badge bg-success font-size-12"><i class="mdi mdi-star me-1"></i> 4.2</span></td>
								<td>$5,412</td>
								<td>07 Oct, 2019</td>
								<td>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="mdi mdi-dots-horizontal font-size-18"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-6 col-lg-6 col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="d-flex align-items-start">
					<div class="flex-shrink-0 me-3">
						<img src="{{ asset('assets/images/gif/minus-circle.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
					</div>
					<div class="flex-grow-1 align-self-center">
						<div class="text-muted">
							<div class="d-flex">
								<div class="flex-grow-1">
									<h6 class="text-danger fw-semibold font-size-14">รายชื่อที่ไม่สามารถตัดได้</h6>
									<p class="mt-n1 fw-semibold font-size-11 badge badge-soft-danger">จำนวน 0 รายการ</p>
								</div>
								<div class="ms-3">
									<div class="d-flex align-items-center">
										<div class="flex-shrink-0">
											<button type="button" class="btn btm-sm btn-soft-info hover-up font-size-12" onclick="rpTransferPayt()">
												<i class="mdi mdi-printer-eye me-1"></i>พิมพ์
											</a>
										</div>
									</div>
								</div>
							</div>
							<p class="border-primary border-bottom mt-n2"></p>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table align-middle table-nowrap font-size-11">
						<thead>
							<tr>
								<th>เลขสัญญา</th>
								<th>ประเภท</th>
								<th>ชื่อ - สกุล</th>
								<th>ยอดสุทธิ</th>
								<th>Wallet Balance</th>
								<th>Joining Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Stephen Rash</td>
								<td>
									<p class="mb-1">325-250-1106</p>
									<p class="mb-0">StephenRash@teleworm.us</p>
								</td>

								<td>2470 Grove Street
									Bethpage, NY 11714</td>
								<td><span class="badge bg-success font-size-12"><i class="mdi mdi-star me-1"></i> 4.2</span></td>
								<td>$5,412</td>
								<td>07 Oct, 2019</td>
								<td>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="mdi mdi-dots-horizontal font-size-18"></i>
										</a>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
											<li><a href="#" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function rpTransferPayt() {
		let url = `{{ route('report-backend.show', 'id') }}?page=rp-transferPay`;
		let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=รายชื่อลูกหนี้เงินโอน");
		let flag_pt = "{{ session()->put('flag_pt', 'active') }}";

		if (newWindow) {
			let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

			window.blur();  // ล่วงหน้าต่างของเบราว์เซอร์

        	newWindow.focus();  // กลับมาโฟกัสที่หน้าต่าง Modal
			newWindow.resizeTo(browserWidth, browserHeight);
		}
	}
</script>