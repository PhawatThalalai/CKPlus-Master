<div class="card">
	<div class="card-header bg-transparent border-bottom">
        <div class="d-flex flex-wrap align-items-start">
            <div class="me-2">
                <h5 class="card-title mt-1 mb-0 font-size-13 fs-6 text text-primary">ข้อมูลยอดจัด</h5>
            </div>
        </div>
    </div>

	<div class="card-body">
		<div class="mb-4">
			<div data-simplebar style="max-height: 180px;cursor: pointer;">
				<table class="table table-nowrap table-sm mb-1 font-size-12">
					<tbody>
						<tr>
							<th scope="col">ค่างวด :</th>
							<td scope="col">{{number_format(@$data->TOT_UPAY,0)}} บาท</td>
						</tr>
						<tr>
							<th scope="col">เงินต้นคงเหลือ :</th>
							<td scope="col">{{number_format(@$data->TONBALANCE,0)}} บาท</td>
						</tr>
						<tr>
							<th scope="col">วันที่ดิว :</th>
							<td scope="col">10-10-2023</td>
						</tr>
						<tr>
							<th scope="col">วันที่ชำระล่าสุด :</th>
							<td scope="col">10-10-2023</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<h5 class="card-title mb-3 font-size-13 fs-6 text text-primary">คำนวณตามวันที่ชำระ</h5>
		<div class="hstack gap-3">
			<input class="form-control me-auto" wire:model='Duepay' type="date" aria-label="Add your item here...">
			<div class="vr"></div>
			<button type="button" wire:click="CalupDuePayment({{ $contract }},{{ $branchCon }})" class="btn btn-outline-danger btn-rounded chat-send w-xs waves-effect waves-light" data-bs-toggle="tooltip" title="คำนวณ" {{ @$btn_cal }}>
				<i class="bx bx-calculator bx-xs bx-tada"></i>
			</button>
		</div>
	</div>
</div>
