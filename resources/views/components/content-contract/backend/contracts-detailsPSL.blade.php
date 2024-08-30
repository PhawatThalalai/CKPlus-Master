
<div class="card p-2">
	@if (true)
		<div class="col text-end">
			<div class="btn-group" data-bs-toggle="tooltip" title="เพิ่มเติม">
				<button type="button" id="btn-Payother" class="btn btn-soft-info btn-rounded chat-send waves-effect waves-light dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="bx bx-list-plus"></i>
				</button>
				<div class="dropdown-menu" style="cursor:pointer;">
					{{-- <button type="button" class="dropdown-item d-flex justify-content-start editContract_btn" href="#modal_editContract" data-link="{{ route('contracts.edit', @$data['DataPact_id']) }}?CODLOAN={{ 1 }}&page={{ 'viewContract' }}&funs={{ 'edit' }}" role="button" data-bs-toggle="tooltip" title="เปลี่ยนแปลงสถานะสัญญา">
						<i class="bx bx-edit-alt text-info fs-4"></i><span class="ms-2"> เปลี่ยนแปลงสถานะสัญญา</span>
					</button> --}}
					<button type="button" class="dropdown-item d-flex justify-content-start btn_printForm" data-id="{{@$data['DataPact_id']}}" data-bs-toggle="tooltip" title="ฟอร์มสัญญาเงินกู้">
						<i class="bx bx-receipt text-info fs-4"></i><span class="ms-2"> ฟอร์มสัญญาเงินกู้</span>
					</button>
					<button type="button" class="dropdown-item d-flex justify-content-start btn_printFormGrant" data-id="{{@$data['DataPact_id']}}" data-bs-toggle="tooltip" title="ฟอร์มสัญญาค้ำประกัน">
						<i class="bx bx-receipt text-info fs-4"></i><span class="ms-2"> ฟอร์มสัญญาค้ำประกัน</span>
					</button>
					<button type="button" class="dropdown-item d-flex justify-content-start btn_printFormLand" data-id="{{@$data['DataPact_id']}}" data-bs-toggle="tooltip" title="ฟอร์มสัญญาเงินกู้ที่ดิน">
						<i class="bx bx-receipt text-info fs-4"></i><span class="ms-2"> ฟอร์มสัญญาเงินกู้ที่ดิน</span>
					</button>
					<button type="button" class="dropdown-item data-modal-xl-2 d-flex justify-content-start">
						<i class="bx bx-table text-info fs-4"></i><span class="ms-2"> คำยินยอม</span>
					</button>
				</div>
			</div>
			<!-- <a class="btn btn-sm editContract_btn hover-up text-primary" href="#modal_editContract" data-link="{{ route('contracts.edit', @$data['DataPact_id']) }}?CODLOAN={{ 1 }}&page={{ 'viewContract' }}&funs={{ 'edit' }}" role="button">
				<i class="bx bx-edit-alt bx-xs"></i>
			</a> -->
		</div>
	@endif
	<div class="row mb-2">
		<div class="col border-end 1">
			<div class="table-responsive ">
				<table class="table table-nowrap table-sm mb-0">
					<tbody class="fs-6">
						<tr>
							<th scope="row">ยอดกู้ :</th>
							<td class="text-end">{{ @$data['LoanAmount'] }}</td>
						</tr>
						<tr>
							<th scope="row">จำนวนผ่อน :</th>
							<td class="text-end">{{ @$data['Period'] }}</td>
						</tr>
						<tr>
							<th scope="row">เบี้ยปรับ :</th>
							<td class="text-end">{{ @$data['fine'] }}</td>
						</tr>
						<tr>
							<th scope="row">ดอกเบี้ยต่อเดือน :</th>
							<td class="text-end">{{ @$data['Interest'] }} %</td>
						</tr>

						<tr>
							<th scope="row">ค่างวด :</th>
							<td class="text-end">{{ @$data['installments'] }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col border-end">
			<div class="table-responsive">
				<table class="table table-nowrap table-sm mb-0">
					<tbody class="fs-6">
						<tr>
							<th scope="row">ดอกเบี้ยรวม :</th>
							<td class="text-end">{{ @$data['Total'] }}</td>
						</tr>
						<tr>
							<th scope="row">ผ่อนรวมดอกเบี้ย :</th>
							<td class="text-end">{{ @$data['InstallPInt'] }}</td>
						</tr>
                        <tr>
							<th scope="row">วันที่ทำสัญญา :</th>
							<td class="text-end">{{ @$data['SDATE'] }}</td>
						</tr>
						<tr>
							<th scope="row">งวดแรก :</th>
							<td class="text-end">{{ @$data['FirstPeriod'] }}</td>
						</tr>
						<tr>
							<th scope="row">งวดสุดท้าย :</th>
							<td class="text-end">{{ @$data['LastPeriod'] }}</td>
						</tr>
						<tr>
							<th scope="row">วันที่หยุดรับรู้รายได้ :</th>
							<td class="text-end">{{ @$data['VatStopDate'] }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="">
				<div class="">
					<div class="table-responsive">
						<table class="table table-nowrap mb-0">
							<tbody class="fs-6">
								<tr>
									<th class="bg-info bg-soft" scope="row">ชำระแล้ว :</th>
									<td class="text-end bg-info bg-soft">{{ @$data['Paid'] }}</td>

									<th class="text-danger" scope="row">ลูกหนี้คงเหลือ :</th>
									<td class="text-danger text-end">{{ @$data['OutstandingDebt'] }}</td>

									<th class="text-primary bg-info bg-soft" scope="row">วันที่หยุด Vat :</th>
									<td class="text-primary bg-info bg-soft text-end">{{ @$data['DTSTOPV'] != NULL ? @$data['DTSTOPV'] : '-' }}</td>
								</tr>
								<tr>
									<th class="bg-info bg-soft" scope="row">ผู้ตรวจสอบ :</th>
									<td class="text-end bg-info bg-soft">{{ @$data['inspector'] }}</td>

									<th class="" scope="row">พนักงานเก็บเงิน :</th>
									<td class="text-end ">{{ @$data['Cashier'] }}</td>

									<th class="bg-info bg-soft" scope="row">พนักงานขาย :</th>
									<td class="text-end bg-info bg-soft">{{ @$data['Salesperson'] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(".btn_printForm").click(function(){
		let id = $(this).data('id');
		let getForm = 'PSL_Cus';
		let url = "{{route('contracts.show', ':id')}}?page={{'print-contractform'}}&form={{':getForm'}}";
			url = url.replace(':id', id);
            url = url.replace(':getForm', getForm);
		window.open(url, "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");

	});
	$(".btn_printFormGrant").click(function(){
		let id = $(this).data('id');
		let getForm = 'PSL_Grant';
		let url = "{{route('contracts.show', ':id')}}?page={{'print-contractform'}}&form={{':getForm'}}";
			url = url.replace(':id', id);
            url = url.replace(':getForm', getForm);
		window.open(url, "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");

	});
	$(".btn_printFormLand").click(function(){
		let id = $(this).data('id');
		let getForm = 'PSL_Land';
		let url = "{{route('contracts.show', ':id')}}?page={{'print-contractform'}}&form={{':getForm'}}";
			url = url.replace(':id', id);
            url = url.replace(':getForm', getForm);
		window.open(url, "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");

	});
</script>
