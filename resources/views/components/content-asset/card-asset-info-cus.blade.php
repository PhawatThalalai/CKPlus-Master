<!-- การ์ดทรัพย์ -->
<div style="min-height: 16rem;" @class([
	'card rounded-4 hover-up asset-card-hover cardasst cardAsset-' .
	@$data['assetId'],

	// หลังบ้าน เพิ่มเส้นขอบ
	'border-2 border border-light' => @$page == 'contract-f-end',

	// สถานะครอบครองแบบยกเลิก
	'asset-card-ownership-cencel' => @$data['ownershipState'] == 'Cancel',

	// สถานะทรัพย์ Blacklist
	'border border-danger text-danger' => @$data['assetState'] == 'Blacklist',

	// สถานะทรัพย์ Inactive
	'border border-lightgray-darker-5 text-gold' =>
		@$data['assetState'] == 'Inactive',

	//'asset-card-ownership-contract' => @$data['ownershipState'] == 'Contract',
	//'asset-card-ownership-cencel' => @$data['assetState'] == 'Inactive',
	//'asset-card-hide' => @$data['assetState'] == 'Hide',
])>
	<div @class([
		'card-header bg-transparent border-bottom text-uppercase rounded-top',
		'border-danger' => @$data['assetState'] == 'Blacklist',
		'border-lightgray-darker-5 bg-lightgray-darker-3' =>
			@$data['assetState'] == 'Inactive',
	]) style="--bs-border-radius: 1rem;">

		<div class="d-flex align-items-center">
			@if (@$page == 'cus')

				<span @class([
					'badge rounded-pill fs-6 px-3',
					'text-bg-info',
					'text-bg-danger' => @$data['assetState'] == 'Blacklist',
					'bg-lightgray-darker-5 text-warning' => @$data['assetState'] == 'Inactive',
				]) data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $data['assetCode'] }}"># {{ $index }}</span>

				@if (@$data['assetState'] == 'Blacklist')
					<span class="text-danger ps-2 fw-bold">- Blacklist -</span>
				@endif

				@if (@$data['assetState'] == 'Inactive')
					<span class="text-warning ps-2 fw-bold">Inactive</span>
				@endif

				@php
					if (@$data['ownershipState'] == 'Active' || @$data['ownershipState'] == 'Transfer' || @$data['ownershipState'] == 'Process' || @$data['ownershipState'] == 'TransferProcess') {
					    $can_edit_assetowner = true;
					} else {
					    // Process, TransferProcess, Contract, Completed, Cancel
					    if (roleEditAssetOwner() == 'enabled') {
					        $can_edit_assetowner = true;
					    } else {
					        $can_edit_assetowner = false;
					    }
					}
				@endphp

				<div class="ms-auto dropdown">
					<a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
						<i @class([
							'mdi mdi-dots-vertical m-0 h5',
							'text-muted' => @$data['assetState'] != 'Inactive',
							'text-warning' => @$data['assetState'] == 'Inactive',
						])></i>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						@if ($can_edit_assetowner)
							<a href="#" class="dropdown-item data-modal-xl-2 d-flex justify-content-between pe-auto" data-link="{{ route('asset.edit', $data['assetId']) }}?type=owner-asset&ownerid={{ @$data['ownershipId'] }}">แก้ไข <i class="bx bx-edit-alt fs-4 text-warning"></i></a>
						@endif
						<a href="#" class="dropdown-item d-flex justify-content-between data-modal-xl pe-auto" data-link="{{ route('asset.show', $data['assetId']) }}?type=asset&ownerid={{ @$data['ownershipId'] }}">ดูข้อมูล <i class="bx bx-show-alt fs-4 text-primary"></i></a>

						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<h6 class="dropdown-header">
								<i class="fas fa-scroll"></i> การครอบครอง
							</h6>
						</li>

						@if (@$data['ownershipState'] == 'Process' || @$data['ownershipState'] == 'TransferProcess')
							<p class="text-muted small px-3 m-0">
								ไม่สามารถดำเนินการกับทรัพย์ที่อยู่ระหว่างทำสัญญาได้
							</p>
						@elseif(@$data['ownershipState'] == 'Active' || @$data['ownershipState'] == 'Transfer')
							@php
								if (roleCancelAssetOwner() == 'enabled') {
								    $can_cencel_assetowner = true;
								} else {
								    $can_cencel_assetowner = false;
								}
							@endphp
							@if ($can_cencel_assetowner)
								<a class="dropdown-item deletetask d-flex justify-content-between updateStateOwnership-dataAssetBtn" href="#" data-newstate="Cancel" data-assetid="{{ @$data['assetId'] }}" data-ownerid="{{ @$data['ownershipId'] }}">ยกเลิก <i class="bx bxs-trash fs-4 text-danger"></i></a>
							@else
								<li data-bs-toggle="tooltip" title="ต้องการสิทธิ์">
									<a class="dropdown-item disabled d-flex justify-content-between text-muted bg-secondary bg-opacity-10" href="#">ยกเลิก <i class="bx bxs-trash fs-4"></i></a>
								</li>
							@endif
						@else
							@if (@$data['assetState'] == 'Blacklist')
								<p class="text-muted small px-3 m-0">
									ไม่สามารถดำเนินการกับทรัพย์ที่เป็นแบล็กลิสต์
								</p>
							@else
								@if (@$data['ownershipState'] == 'Contract')
									<a href="#" class="dropdown-item d-flex justify-content-between data-modal-xl-2 pe-auto" data-link="{{ route('asset.edit', $data['assetId']) }}?type=re-transfer&cusid={{ $data['cusId'] }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="สำหรับรีไฟแนนซ์เพื่อส่งขออนุมัติ"><span>รีไฟแนนซ์ <span class="pe-2">(คนเดิม)</span></span><i class="bx bx-revision fs-4 text-primary"></i></a>
								@elseif(@$data['ownershipState'] == 'Completed')
									<!-- ทำงานเหมือนกัน แค่เปลี่ยนชื่อปุ่ม -->
									<a href="#" class="dropdown-item d-flex justify-content-between data-modal-xl-2 pe-auto" data-link="{{ route('asset.edit', $data['assetId']) }}?type=re-transfer&cusid={{ $data['cusId'] }}" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="สร้างการครอบครองซ้ำ เพื่อใช้ทรัพย์นี้ส่งจัด">ครอบครองซ้ำ <i class="bx bx-revision fs-4 text-primary"></i></a>
								@endif

								<a href="#" class="dropdown-item d-flex justify-content-between data-modal-xl-2 pe-auto" data-link="{{ route('asset.edit', $data['assetId']) }}?type=transfer&ownerid={{ @$data['ownershipId'] }}">ย้ายทรัพย์ <i class="bx bx-export fs-4 text-primary"></i></a>

							@endif

						@endif

						{{--
								ระบบจัดการสถานะทรัพย์ เดี๋ยวจะย้ายไปหน้าหลักของทรัพย์

							<li><hr class="dropdown-divider"></li>
							<li><h6 class="dropdown-header">
								<i class="fas fa-suitcase"></i> สถานะทรัพย์</h6>
							</li>
							@if ($data['assetState'] == 'Inactive' || $data['assetState'] == 'Blacklist')
								<a class="dropdown-item deletetask d-flex justify-content-between updateState-dataAssetBtn" href="#" data-newstate="Active" data-assetid="{{ @$data['assetId'] }}">เปิดใช้งาน <i class="bx bx-check fs-4 text-success"></i></a>
							@endif
							@if ($data['assetState'] == 'Active')
								<a class="dropdown-item deletetask d-flex justify-content-between updateState-dataAssetBtn" href="#" data-newstate="Blacklist" data-assetid="{{ @$data['assetId'] }}">ตั้งแบล็กลิสต์ <i class="bx bx-block fs-4 text-danger"></i></a>
							@endif

							@if ($data['assetState'] != 'Hide')
								<a class="dropdown-item deletetask d-flex justify-content-between delete-dataAssetBtn" href="#" data-assetid="{{ @$data['assetId'] }}">ลบทรัพย์นี้ <i class="bx bxs-trash fs-4 text-danger"></i></a>
							@else
								<!--
									ยังไม่เปิดระบบกู้คืนทรัพย์
								<a class="dropdown-item deletetask d-flex justify-content-between updateState-dataAssetBtn" href="#" data-newstate="Inactive" data-assetid="{{ @$data['assetId'] }}">กู้คืน <i class="bx bx-revision fs-4 text-success"></i></a>
								-->
							@endif

						--}}

					</div>
				</div>
			@else
				<span class="badge rounded-pill text-bg-success fs-6 px-3">ทรัพย์ที่ {{ $index }}</span>
				<h6 class="m-0 px-2 w-100 align-center fw-semibold">{{ $data['assetCode'] }}</h6>
			@endif

		</div>

		@if ($data['typeAssetCode'] != 'land')
			<div class="d-flex flex-row-reverse asset-flag-bookmark-card-info" @style(['position: absolute;', 'right: 2.5rem;' => @$page == 'cus', 'right: 1rem;' => @$page != 'cus', 'top: -0.5rem;'])>

				@if (@$page == 'cus')
					<!-- badge สถานะ Ownership ของรถยนต์ / มอเตอร์ไซค์ -->
					<div class="align-self-end pb-1">
						<span @class([
							'badge rounded-pill font-size-12',
							'badge-soft-success' => @$data['ownershipState'] == 'Active',
							'badge-soft-warning' =>
								@$data['ownershipState'] == 'Process' ||
								@$data['ownershipState'] == 'TransferProcess',
							'badge-soft-dark' => @$data['ownershipState'] == 'Contract',
							'badge-soft-danger' =>
								@$data['ownershipState'] == 'Completed' ||
								@$data['ownershipState'] == 'Cancel',
							'badge-soft-info' => @$data['ownershipState'] == 'Transfer',
						])>
							{{ @$data['ownershipStateName'] }}
						</span>
					</div>
				@endif
				<div class="pe-2">
					<span class="badge rounded-0 font-size-13 text-white triangle-year flag-bookmark fw-bold"><i class="mdi mdi-calendar h5 m-0"></i> {{ $data['assetYear'] }}</span>
					<div class="triangle-year triangle"></div>
				</div>
				<div class="pe-2">
					<span class="badge rounded-0 font-size-13 text-white triangle-gear flag-bookmark fw-bold"><i class="mdi mdi-cog-outline h5 m-0"></i> {{ $data['assetBrand'] }}</span>
					<div class="triangle-gear triangle"></div>
				</div>
			</div>
		@elseif(@$page == 'cus')
			<div class="d-flex flex-row-reverse asset-flag-bookmark-card-info" @style(['position: absolute;', 'right: 2.5rem;', 'top: 0.5rem;'])>

				<!-- badge สถานะ Ownership ของที่ดิน -->
				<div class="align-self-end">
					<span @class([
						'badge rounded-pill font-size-12',
						'badge-soft-success' => @$data['ownershipState'] == 'Active',
						'badge-soft-warning' =>
							@$data['ownershipState'] == 'Process' ||
							@$data['ownershipState'] == 'TransferProcess',
						'badge-soft-dark' => @$data['ownershipState'] == 'Contract',
						'badge-soft-danger' =>
							@$data['ownershipState'] == 'Completed' ||
							@$data['ownershipState'] == 'Cancel',
						'badge-soft-info' => @$data['ownershipState'] == 'Transfer',
					])>
						{{ @$data['ownershipStateName'] }}
					</span>
				</div>

			</div>
		@endif

	</div>
	<div @class([
		'card-body p-2',
		'bg-lightgray-darker-2' => @$data['assetState'] == 'Inactive',
	])>

		<div class="row h-100">
			<div @class([
				'col border-end',
				'border-danger' => @$data['assetState'] == 'Blacklist',
				'border-lightgray-darker-5' => @$data['assetState'] == 'Inactive',
			])>

				<!-- แสดงสถานะประกัน เเฉพาะ รถยนต์ เท่านั้น -->
				@if ($data['typeAssetCode'] == 'car')
					<div class="float-start d-flex flex-column">
						@php
							$_tooltipText = 'ประกัน';
							if (@$InsuranceCar['InsEXP']) {
							    $_tooltipText = $_tooltipText . 'หมดอายุ';
							} elseif (@$InsuranceCar['InsWarning']) {
							    $_tooltipText = $_tooltipText . 'ใกล้หมดอายุ';
							} else {
							    $_tooltipText = $_tooltipText . 'ยังไม่หมดอายุ';
							}
						@endphp
						<span style="vertical-align: top;" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $_tooltipText }}" @class([
							'fa-stack',
							'fs-5',
							'text-danger' => @$InsuranceCar['InsEXP'],
							'text-warning' => @$InsuranceCar['InsWarning'],
							'text-success' =>
								@$InsuranceCar['InsEXP'] == false &&
								@$InsuranceCar['InsWarning'] == false,
						])>
							<i class="fas fa-square fa-stack-2x"></i>
							<i @class([
								'fas fa-car-crash fa-stack-1x fa-inverse',
								'text-dark' => @$InsuranceCar['InsWarning'],
							])></i>
						</span>
						@php
							$_tooltipText = 'วันคุ้มครอง พ.ร.บ. ';
							if (@$InsuranceCar['InsActEXP']) {
							    $_tooltipText = $_tooltipText . ' หมดอายุ';
							} elseif (@$InsuranceCar['InsActWarning']) {
							    $_tooltipText = $_tooltipText . 'ใกล้หมดอายุ';
							} else {
							    $_tooltipText = $_tooltipText . 'ยังไม่หมดอายุ';
							}
						@endphp
						<span style="vertical-align: top;" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $_tooltipText }}" พ.ร.บ. หมดอายุ" @class([
							'fa-stack',
							'fs-5',
							'text-danger' => @$InsuranceCar['InsActEXP'],
							'text-warning' => @$InsuranceCar['InsActWarning'],
							'text-success' =>
								@$InsuranceCar['InsActEXP'] == false &&
								@$InsuranceCar['InsActWarning'] == false,
						])>
							<i class="fas fa-square fa-stack-2x"></i>
							<i @class([
								'fas fa-road fa-stack-1x fa-inverse',
								'text-dark' => @$InsuranceCar['InsActWarning'],
							])></i>
						</span>
						@php
							$_tooltipText = 'วันคุ้มครองทะเบียน';
							if (@$InsuranceCar['InsRegisterEXP']) {
							    $_tooltipText = $_tooltipText . ' หมดอายุ';
							} elseif (@$InsuranceCar['InsRegisterWarning']) {
							    $_tooltipText = $_tooltipText . 'ใกล้หมดอายุ';
							} else {
							    $_tooltipText = $_tooltipText . 'ยังไม่หมดอายุ';
							}
						@endphp
						<span style="vertical-align: top;" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $_tooltipText }}" @class([
							'fa-stack',
							'fs-5',
							'text-danger' => @$InsuranceCar['InsRegisterEXP'],
							'text-warning' => @$InsuranceCar['InsRegisterWarning'],
							'text-success' =>
								@$InsuranceCar['InsRegisterEXP'] == false &&
								@$InsuranceCar['InsRegisterWarning'] == false,
						])>
							<i class="fas fa-square fa-stack-2x"></i>
							<i @class([
								'fas fa-address-card fa-stack-1x fa-inverse',
								'text-dark' => @$InsuranceCar['InsRegisterWarning'],
							])></i>
						</span>
					</div>
				@endif

				<!-- รูปภาพทรัพย์ -->
				<div class="col-12 m-auto text-center">
					@if ($data['typeAssetCode'] == 'car')
						<img src="{{ URL::asset('\assets\images\asset\astCar.png') }}" @class([
							'rounded-circle border border-3 p-1',
							'border-success' => @$data['assetState'] == 'Active',
							'border-danger' => @$data['assetState'] == 'Blacklist',
							'border-lightgray-darker-4' => @$data['assetState'] == 'Inactive',
							'border-dark' => @$data['assetState'] == 'Hide',
						]) alt="เพิ่ม" style="width: 6.5rem;">
					@elseif($data['typeAssetCode'] == 'moto')
						<img src="{{ URL::asset('\assets\images\asset\motorbike.png') }}" @class([
							'rounded-circle border border-3 p-1',
							'border-success' => @$data['assetState'] == 'Active',
							'border-danger' => @$data['assetState'] == 'Blacklist',
							'border-lightgray-darker-4' => @$data['assetState'] == 'Inactive',
							'border-dark' => @$data['assetState'] == 'Hide',
						]) alt="เพิ่ม" style="width: 6.5rem;">
					@elseif($data['typeAssetCode'] == 'land')
						<img src="{{ URL::asset('\assets\images\asset\real-estate.png') }}" @class([
							'rounded-circle border border-3 p-1',
							'border-success' => @$data['assetState'] == 'Active',
							'border-danger' => @$data['assetState'] == 'Blacklist',
							'border-lightgray-darker-4' => @$data['assetState'] == 'Inactive',
							'border-dark' => @$data['assetState'] == 'Hide',
						]) alt="เพิ่ม" style="width: 6.5rem;">
					@endif
				</div>

				<div @class([
					'col-12 mt-2 text-center',
					'text-lightgray-darker-4' => @$data['assetState'] == 'Inactive',
				])>
					<h5 @class([
						'fw-semibold',
						'text-lightgray-darker-4' => @$data['assetState'] == 'Inactive',
					])>{{ $data['assetMainType'] }}</h5>
					<div class="row">
						<div @class([
							'col-6 text-center border-end px-1',
							'border-lightgray-darker-5' => @$data['assetState'] == 'Inactive',
						])>
							<p class="fw-semibold fs-6 mb-0">ประเภท</p>
							<p class="m-0">{{ $data['typeAssetName'] }}</p>
						</div>
						<div class="col-6 text-center px-1">
							<p class="fw-semibold fs-6 mb-0">
								@if ($data['typeAssetCode'] == 'land')
									ราคาประเมิน
								@else
									ราคากลาง
								@endif
							</p>
							<p class="m-0">{{ number_format($data['assetPrice']) }} ฿</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-7 d-none d-md-block">
				<table @class([
					'table table-sm table-nowrap mb-0 asset-table-card-info',
					'table-asset-card-inactive text-lightgray-darker-4' =>
						@$data['assetState'] == 'Inactive',
				])>
					@php
						switch (@$data['assetState']) {
						    case 'Inactive':
						        $text_asset = 'text-lightgray-darker-5';
						        break;
						    case 'Blacklist':
						        $text_asset = 'text-danger';
						        break;
						    case 'Hide':
						        $text_asset = 'text-dark';
						        break;
						    case 'Active':
						    default:
						        $text_asset = 'text-success';
						        break;
						}
					@endphp
					<tbody>
						<tr>
							<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> วันที่ครอบครอง:</th>
							<td class="text-end">{{ formatDateThaiShort($data['assetOccupiedDT']) }}</td>
						</tr>
						<tr>
							<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> ระยะเวลา:</th>
							<td class="text-end">{{ $data['assetOccupiedTime'] }}</td>
						</tr>
						@if ($data['typeAssetCode'] == 'land')
							<tr>
								<th><i class="bx bx-info-circle {{ $text_asset }}"></i> เลขโฉนด:</th>
								<td class="text-end">{{ $data['assetLandId'] }}</td>
							</tr>
							<tr>
								<th><i class="bx bx-info-circle {{ $text_asset }}"></i> เลขที่ดิน:</th>
								<td class="text-end">{{ $data['assetParcelNumber'] }}</td>
							</tr>
							<tr>
								<th><i class="bx bx-info-circle {{ $text_asset }}"></i> ระวาง:</th>
								<td class="text-end">{{ $data['assetSheetNumber'] }}</td>
							</tr>
							<tr>
								<th><i class="bx bx-info-circle {{ $text_asset }}"></i> หน้าสำรวจ:</th>
								<td class="text-end">{{ $data['assetTambonNumber'] }}</td>
							</tr>
						@else
							<tr>
								<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> ทะเบียนเก่า:</th>
								<td class="text-end">{{ @$data['assetOldLicense'] }}</td>
							</tr>
							<tr>
								<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> ทะเบียนใหม่:</th>
								<td class="text-end">{{ @$data['assetNewLicense'] }}</td>
							</tr>
							<tr>
								<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> เลขถัง:</th>
								<td class="text-end">{{ @$data['assetChassis'] }}</td>
							</tr>
							<tr>
								<th scope="row"><i class="bx bx-info-circle {{ $text_asset }}"></i> เลขเครื่อง:</th>
								<td class="text-end">{{ @$data['assetEngine'] }}</td>
							</tr>
						@endif
					</tbody>
				</table>

			</div>
		</div>

	</div>
	<div @class([
		'card-footer rounded-bottom',
		'bg-transparent bg-danger bg-soft' => @$data['assetState'] == 'Blacklist',
		'bg-lightgray-darker-3' => @$data['assetState'] == 'Inactive',
	]) style="--bs-border-radius: 1rem;">
		<div class="row px-2">
			<div class="col-5">
				<div class="row">
					<div class="col d-grid text-center">
						<button @class([
							'rounded-pill btn-sm btn btn-outline-primary data-modal-xl',
							'btn-outline-danger' => @$data['assetState'] == 'Blacklist',
							'btn-outline-warning' => @$data['assetState'] == 'Inactive',
						]) data-link="{{ route('asset.show', $data['assetId']) }}?type=asset&ownerid={{ @$data['ownershipId'] }}" type="button" title="ดูข้อมูลทรัพย์">
							ดูข้อมูล
						</button>
					</div>
					@if (@$page == 'contract-f-end')
						<button class="col-auto rounded-circle btn-sm btn btn-danger removeAsst" type="button" data-id="{{ @$data['ownershipId'] }}" title="ลบออกจากสัญญา"><i class="bx bxs-trash"></i></button>
					@endif
				</div>
			</div>

			<div @class([
				'col d-flex justify-content-between align-items-center ps-4',
				'text-secondary' => @$data['assetState'] != 'Inactive',
				'text-warning' => @$data['assetState'] == 'Inactive',
			])>
				<small class="fw-semibold d-none d-sm-inline" data-bs-toggle="tooltip" title="{{ $data['assetLastUpdate'] }}">
					<span class="d-flex align-items-center">
						<i class="bx bxs-time-five fs-5 me-1"></i> {{ \Carbon\Carbon::parse($data['assetLastUpdate'])->locale('th_TH')->diffForHumans() }}
					</span>
				</small>
				<small class="fw-semibold d-flex align-items-center">
					<i class="bx bxs-user-circle fs-5 me-1"></i> {{ $data['assetUserInsert'] }}
				</small>
			</div>

		</div>
	</div>
</div>
