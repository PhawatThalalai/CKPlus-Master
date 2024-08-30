<div class="card mb-1" style="max-height: 220px; min-height: 220px;">
	<div class="card-body">
		<h5 class="card-title mb-3 font-size-13 fs-6 text text-primary">
			<i class="bx bx-calculator"></i> รายละเอียดการรับชำระ
		</h5>
		<div class="row">
			<div class="col-12 mb-1">
				<div class="input-bx">
					<input type="text" name="paydue" id="ip_paydue" value="{{ @$payAmts ?? 0 }}" class="form-control text-end font-size-14 btn-stantlog"" placeholder=" " disabled />
					<span class="text-danger">ยอดค่างวด</span>
					<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
						บาท
					</button>
				</div>
			</div>
		</div>
		<div class="row g-2 mb-2">
			<div class="col-6">
				<div class="input-bx">
					<input type="text" name="interest" id="ip_interest" value="{{ @$interest ?? 0 }}" class="form-control text-end font-size-14 btn-stantlog" placeholder=" " disabled />
					<span class="text-danger">เบี้ยปรับล่าช้า</span>
					<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
						บาท
					</button>
				</div>
			</div>
			<div class="col-6">
				<div class="input-bx">
					<input type="text" name="payfollow" id="ip_payfollow" value="{{ @$payfollow ?? 0 }}" class="form-control text-end font-size-14 btn-stantlog" placeholder=" " disabled />
					<span class="text-danger">ค่าทวงถาม</span>
					<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
						บาท
					</button>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				@if (@$contract->CODLOAN == 1)
					@if (@$contract->CONTTYP == 1)
						<div class="float-end">
							<h5 class="font-size-13">
								<span class="btGroup-showPay" id="payinteff">{{ number_format(@$payinteff, 2) }}</span>
								<i class="bx bx-wallet text-primary align-middle me-1"></i>
							</h5>
						</div>
						<h5 class="font-size-13 mb-3"><i class="bx bx-checkbox-square text-primary me-2"></i>ตัดดอกเบี้ย</h5>
						<div class="float-end">
							<h5 class="font-size-13">
								<span class="btGroup-showPay" id="payton">{{ number_format(@$payton, 2) }}</span>
								<i class="bx bx-wallet text-primary align-middle me-1"></i>
							</h5>
						</div>
						<h5 class="font-size-13 mb-3"><i class="bx bx-checkbox-square text-primary me-2"></i>ตัดเงินต้น</h5>
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
