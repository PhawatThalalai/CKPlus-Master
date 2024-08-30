
<div class="modal-content">
	<div class="loading-overlay d-flex flex-column justify-content-center align-items-center" style="display: none !important">
		<div class="d-flex text-light" role="status">
			<span class="loader">Loading...</span>
		</div>
	</div>

	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ตารางค่างวดและตารางรับชำระ</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">( Installment and Payments )</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<ul class="nav nav-pills nav-justified" role="tablist">
			<li class="nav-item waves-effect waves-light" role="presentation">
				<a class="nav-link active" data-bs-toggle="tab" href="#tab-paydue1" role="tab" aria-selected="true">
					<span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-calendar-day"></i>
						<b>ตารางค่างวด</b>
					</span>
				</a>
			</li>
			<li class="nav-item waves-effect waves-light" role="presentation">
				<a class="nav-link" data-bs-toggle="tab" href="#tab-paydue2" id="tb-install" role="tab" aria-selected="false" tabindex="-1">
					<span class="d-block d-sm-none"><i class="fas fa-file-invoice-dollar"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-file-invoice-dollar"></i>
						<b>ตารางรับชำระ</b>
					</span>
				</a>
			</li>
			<li class="nav-item waves-effect waves-light" role="presentation">
				<a class="nav-link" data-bs-toggle="tab" href="#tab-fee" role="tab" aria-selected="false" tabindex="-1">
					<span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i></span>
					<span class="d-none d-sm-block">
						<i class="mdi mdi-cash-plus font-size-16"></i>
						<b>ค่าธรรมเนียมอื่นๆ</b>
					</span>
				</a>
			</li>
		</ul>
		<div class="tab-content mt-1 text-muted">
			<div class="tab-pane active show" id="tab-paydue1" role="tabpanel">
				<div class="p-0" style="overflow-y:hidden;">
					@include('backend.content-contract.section-view.table-install', ['at_heading' => false, 'tb_height' => 'max-height: 400px'])
				</div>
			</div>
			<div class="tab-pane" id="tab-paydue2" role="tabpanel">
				<div class="p-0" style="overflow-y:hidden;">
					@include('backend.content-contract.section-view.table-payment', ['at_heading' => false, 'item_btn' => true, 'tb_height' => 'max-height: 400px'])
				</div>
			</div>
			<div class="tab-pane" id="tab-fee" role="tabpanel">
				<div class="p-0" style="overflow-y:hidden;">
					@include('backend.content-contract.section-view.table-fee',['at_heading' => false, 'item_btn' => true, 'tb_height' => 'max-height: 400px'])
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer float-end">
		<button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
	</div>
</div>

<script>
	$('[data-bs-toggle="tooltip"]').tooltip();
	$('[data-bs-toggle="popover"]').popover();
</script>
