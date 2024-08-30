<div class="card p-2 table-responsive h-100" id="appendTB" style="overflow: hidden;">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-4 mt-2">
			<img class="" src="{{ URL::asset('assets/images/add-user.png') }}" alt="" style="width: 50px;">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold pt-2 font-size-15">ข้อมูลบันทึกทรัพย์สิน ( ASSET DATA DAILY )</h5>
			<h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>สาขา {{ @$dataBranch2->Name_Branch }}</h6>
			<p class="border-primary border-bottom mt-2"></p>
			<input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
		</div>
	</div>
	<div class="table-responsive">
		<table class="viewWalkin dateHide table align-middle table-hover text-nowrap createContract border border-light font-size-12" id="table1">
			<thead>
				<tr class="bg-light">
					<th class="text-center" style="width: 5%">#</th>
					<th class="text-center">วันที่สร้าง</th>
					<th class="text-center">ทะเบียนรถ</th>
					<th class="text-center">ประเภทรถ</th>					
					<th class="text-center">ยี่ห้อรถ</th>
					<th class="text-center">รุ่นรถ</th>
					{{-- <th class="text-center">ปีรถ</th> --}}
					<th class="text-center" style="width: 8%"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($dataAsset as $row)
					<tr>
						<td class="text-center">
							
						</td>
						<td class="text-center">
							<p>{{ date_format(date_create(@$row->created_at), 'Ymd') }} </p>
							{{ date('d-m-Y', strtotime(substr($row->created_at, 0, 10))) }}
						</td>
						<td>
							@php
								if(@$row->OwnershipToAsset->TypeAsset_Code=='car' || @$row->OwnershipToAsset->TypeAsset_Code=='moto' ){
									$license = strlen(@$row->OwnershipToAsset->Vehicle_NewLicense)>3?@$row->OwnershipToAsset->Vehicle_NewLicense:@$row->OwnershipToAsset->Vehicle_OldLicense ;
									if(@$row->OwnershipToAsset->TypeAsset_Code=='car'){
										$brand = $row->OwnershipToAsset->AssetToCarBrand->Brand_car;
										$model = $row->OwnershipToAsset->AssetToCarModel->Model_car;
										$typeAss = $row->OwnershipToAsset->AssetToTypeVehicle->Name_Vehicle;
									}else{
										$brand = $row->OwnershipToAsset->AssetToMotoBrand->Brand_moto;
										$model = $row->OwnershipToAsset->AssetToMotoModel->Model_moto;
										$typeAss = $row->OwnershipToAsset->AssetToTypeVehicle->Name_Vehicle;
									}									
									
								}else{
									$license = @$row->OwnershipToAsset->Land_Id;
									$brand = '';
									$model = @$row->OwnershipToAsset->Land_Province." ".@$row->OwnershipToAsset->Land_District." ".@$row->OwnershipToAsset->Land_Tambon;
									$typeAss = @$row->OwnershipToAsset->TypeCar;
								}

							@endphp
							<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$license}}</a></h5>
							@if (Str::upper(@$row->OwnershipToAsset->Status_Asset) == 'ACTIVE')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
							@elseif (Str::upper(@$row->Status_Asset) ==  'CANCEL')
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
							@else
								<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
							@endif
						</td>
						{{-- <td class="text-center"> {{ @$row->Phone_cus }} </td> --}}
					
						<td>
								<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">{{ @$typeAss}}</a></h5>
						</td>
						<td class="text-center">
							{{@$brand}}
						</td>
						<td class="text-center">
							{{@$model}}
						</td>
						<td class="text-center">
							<ul class="list-inline font-size-20 contact-links mb-0">
								<li class="list-inline-item px-2">
									<a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$row->DataCus_Id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft"></i></a>
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
			"drawCallback": function() {
				var position1Th = $('.viewWalkin thead th:nth-child(1)');
				var position2Th = $('.viewWalkin thead th:nth-child(2)');
				position2Th.attr('colspan', 2);
				position1Th.hide();
			},
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
