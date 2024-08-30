<div class="row">
	<div class="col-xl-6 col-lg-12">
		<div class="table-responsive">
			<table class="table table-sm" style="line-height: 25px;">
				<tbody class="">
					<tr>
						<td>ประเภทผู้แนะนำ :</td>
						<th class="text-end">
							<span class="">{{ @$data->DataCusToBroker->BrokerToType->Name_typeBroker }}</span>
						</th>
					</tr>
					<tr>
						<td>เลขบัตร ปชช. :</td>
						<th class="text-end">
							<span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$data->IDCard_cus }}</span>
						</th>
					</tr>
					<tr>
						<td>ชื่อเล่น / ฉายา :</td>
						<th class="text-end">
							<span class="">{{ @$data->DataCusToBroker->nickname_Broker }}</span>
						</th>
					</tr>
					<tr>
						<td>สถานที่ตั้ง :</td>
						<th class="text-end">
                            <span class="d-inline-block text-truncate mb-0" style="max-width: 150px;">
                                {{ @$data->DataCusToBroker->location_Broker }}
                            </span>
						</th>
					</tr>
					<tr>
						<td>อัลบั้มนายหน้า :</td>
						<th class="text-end">
                            <span class="d-inline-block text-truncate mb-0" style="max-width: 150px;">
                                <a href="{{ @$data->DataCusToBroker->Link_Broker }}" target="_blank" rel="noopener noreferrer">{{ @$data->DataCusToBroker->Link_Broker }}</a>
                            </span>
						</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-xl-6 col-lg-12">
		<div class="card border border-2 border-warning rounded-4 bg-soft border-opacity-75 pb-0 mb-0">
			<div class="card-header rounded-bottom rounded-4">
				<div class="row">
					<div class="col">
						<i class="fab fa-cc-mastercard fs-1 text-danger align-middle me-2"></i>
					</div>
					<div class="col m-auto text-end">
						<span class="fw-semibold">ข้อมูลธนาคาร</span>
					</div>
				</div>
			</div>
			<div class="px-3 py-2 font-size-12">
				<div class="row mb-2 fw-semibold">
					<div class="col">ธนาคาร : </div>
					<div class="col fw-semibold">{{ @$data->Name_Account != null ? @$data->Name_Account : '-' }}</div>
				</div>

				<div class="row mb-2 fw-semibold">
					<div class="col">สาขา : </div>
					<div class="col fw-semibold">{{ @$data->Branch_Account != null ? @$data->Branch_Account : '-' }}</div>
				</div>

				<div class="row mb-2 fw-semibold">
					<div class="col">เลขที่บัญชี : </div>
					<div class="col fw-semibold">{{ @$data->Number_Account != null ? @$data->Number_Account : '-' }}</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-12 col-lg-12">
		<p class="m-0" style="color: var(--bs-table-color); --bs-table-color: var(--bs-body-color);">
			<strong>หมายเหตุ :</strong>
		</p>
		<p class="m-0 p-3 rounded-3 bg-light" data-simplebar style="max-height: 80px; min-height: 80px;">
			@isset($data->DataCusToBroker->note_Broker)
				{{ @$data->DataCusToBroker->note_Broker }}
			@else
				<em>- ยังไม่มีบันทึก -</em>
			@endisset
		</p>
	</div>
</div>
