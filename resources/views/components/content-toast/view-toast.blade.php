<div class="toast-container position-fixed top-0 end-0 p-3">
	<div class="toast toast-success" id="toast-success">
		<div class="toast-header">
			<span class="rounded me-2">
				<i class="mdi mdi-22px mdi-checkbox-marked-outline"></i>
			</span>
			<strong class="me-auto"><i class="bi-gift-fill"></i> success !</strong>
			<small>{{ date('d-m-Y') }}</small>
			<button type="button" class="btn-close" data-bs-dismiss="toast"></button>
		</div>
		<div class="toast-body">
			<span class="text-body text-light">Connection Successful</span>
		</div>
	</div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
	<div class="toast myToast2 bg-danger" id="myToast">
		<div class="toast-header">
			<strong class="me-auto"><i class="bi-gift-fill"></i> Error!</strong>
			<small>{{ date('d-m-Y') }}</small>
			<button type="button" class="btn-close" data-bs-dismiss="toast"></button>
		</div>
		<div class="toast-body">
			ไม่มีข้อมูล
		</div>
	</div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
	<div class="toast toast-error bg-danger" id="toast-error">
		<div class="toast-header">
			<span class="rounded me-2">
				<i class="mdi mdi-24px mdi-checkbox-marked-outline"></i>
			</span>
			<strong class="me-auto"><i class="bi-gift-fill"></i> Error!</strong>
			<small>{{ date('d-m-Y') }}</small>
			<button type="button" class="btn-close" data-bs-dismiss="toast"></button>
		</div>
		<div class="toast-body">
			<span class="text-light text-body">Connection fails</span>
		</div>
	</div>
</div>
