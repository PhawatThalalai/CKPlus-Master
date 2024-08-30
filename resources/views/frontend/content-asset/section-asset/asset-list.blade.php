<h5 class="fw-semibold text-start">ผลการค้นหา</h5>
<div class="table-responsive" data-simplebar="init">
	@if (count($assets) != 0)
        @if ($typeSreach == 'license' || $typeSreach == 'chassis')
            <table class="table align-middle table-nowrap text-nowrap table-hover font-size-12">
                <thead class="table-light sticky-top text-center">
                    <tr>
                        <th scope="col" colspan="2">เลขทะเบียน</th>
                        <th scope="col">ประเภn</th>
                        <th scope="col">ประเภทรถ</th>
                        <th scope="col">ยี่ห้อรถ</th>
                        <th scope="col">รุ้นรถ</th>
                        <th scope="col">ปีรถ</th>
                        <th scope="col">เกียร์รถ</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$assets as $asset)
                        <tr>
                            <td class="text-center">
                                <div>
                                    <img class="rounded-circle avatar-xs" src="{{ $asset->TypeAsset_Code == 'moto' ? URL::asset('/assets/images/asset/motorbike.png') : asset('/assets/images/asset/astCar.png') }}" alt="">
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">เลขทะเบียน : {{ @$asset->Vehicle_OldLicense . ' / ' . @$asset->Vehicle_NewLicense }}</a></h5>
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">เลขถัง : {{ @$asset->Vehicle_Chassis }}</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm btn-rounded waves-effect waves-light">
                                    {{ @$asset->AssetToTypeAsset->Name_TypeAsset }}
                                </button>
                            </td>
                            <td class="text-center">{{ @$asset->AssetToCarType->nametype_car }}</td>
                            <td class="text-center">{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoBrand->Brand_moto : @$asset->AssetToCarBrand->Brand_car }}</td>
                            <td class="text-center">{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoModel->Model_moto : @$asset->AssetToCarModel->Model_car }}</td>
                            <td class="text-center">{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoYear->Year_moto : @$asset->AssetToCarYear->Year_car }}</td>
                            <td class="text-center">{{ @$asset->Vehicle_Gear }}</td>
                            <td class="text-center">
                                <ul class="list-inline font-size-20 contact-links mb-0">
                                    <li class="list-inline-item px-2">
                                        <a role="button" class="hover-up selected-asset" data-id="{{ $asset->id }}" data-bs-toggle="tooltip" title="เลือกทรัพย์">
                                            <i class="mdi mdi-text-box-search text-info"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <table class="table align-middle table-nowrap text-nowrap table-hover font-size-12">
                <thead class="table-light sticky-top text-center">
                    <tr>
                        <th scope="col" colspan="2">เลขที่โฉนด</th>
                        <th scope="col">ประเภn</th>
                        <th scope="col">เลขที่ดิน</th>
                        <th scope="col">หน้าสำรวจ</th>
                        <th scope="col">สิ่งปลูกสร้าง</th>
                        <th scope="col">พื้นที</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$assets as $asset)
                        <tr>
                            <td class="text-center">
                                <div>
                                    <img class="rounded-circle avatar-xs" src="{{ URL::asset('/assets/images/asset/real-estate.png') }}" alt="">
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">เลขที่โฉนด : {{ @$asset->Land_Id }}</a></h5>
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">ระวาง : {{ @$asset->Land_SheetNumber }}</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm btn-rounded waves-effect waves-light">
                                    {{ @$asset->DataAssetToLandType->nametype_car }}
                                </button>
                            </td>
                            <td class="text-center">{{ @$asset->Land_ParcelNumber }}</td>
                            <td class="text-center">{{ @$asset->Land_TambonNumber }}</td>
                            <td class="text-center">{{ @$asset->AssetToTypeAssetsBldg->Name_TypeBldg }}</td>
                            <td class="text-center">
                                @if (@$asset->Land_SizeRai != null)
                                    {{ @$asset->Land_SizeRai }} ไร่
                                @endif
                                @if (@$asset->Land_SizeNgan != null)
                                    {{ @$asset->Land_SizeNgan }} งาน
                                @endif
                                @if (@$asset->Land_SizeSquareWa != null)
                                    {{ @$asset->Land_SizeSquareWa }} ตารางวา
                                @endif
                            </td>
                            <td class="text-center">
                                <ul class="list-inline font-size-20 contact-links mb-0">
                                    <li class="list-inline-item px-2">
                                        <a role="button" class="hover-up selected-asset" data-id="{{ $asset->id }}" data-bs-toggle="tooltip" title="เลือกทรัพย์">
                                            <i class="mdi mdi-text-box-search text-info"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
	@else
		<div class="card-body p-4 m-4">
			<div class="text-center">
				<div class="avatar-md mx-auto mb-4">
					<div class="avatar-title bg-light rounded-circle text-primary h1">
						<img src="{{ asset('assets/images/gif/error.gif') }}" alt="report" class="avatar-sm" style="width:80px;height:80px">
					</div>
				</div>

				<div class="row justify-content-center">
					<div class="col-xl-10">
						<h4 class="text-warning">ไม่พบข้อมูล !</h4>
						<p class="text-muted font-size-14 mb-4">ไม่พบข้อมูลที่ค้นหา โปรดตรวจสอบความถูกต้อง หรือค้นหาอีกครั้ง.</p>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>

<script>
	$(document).ready(function() {
		$('.selected-asset').click(function() {
            let asset_id = $(this).data('id');
            let link = "{{ route('asset.update', 'id') }}";
			let url = link.replace('id', asset_id);

			$('.container-asset').slideUp();
			$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

            $.ajax({
                url: url,
                type: "get",
                data: {
                    _token: "{{ csrf_token() }}",
                    type: 'selected-asset' 
                },
                success: function(result) {
					$('.asset-detail').slideDown('slow').html(result.html);
                    $('.text-search-selected').html(' / ทรัพย์ที่เลือก : <span class="text-primary">' + result.asset.id + '</span>');

                    $(".toast-success").toast({
                        delay: 1500
                    }).toast("show");
                    $(".toast-success .toast-body .text-body").text(result.message);
                },
                error: function(err) {
					$('.container-asset').slideDown('slow');

                    $(".toast-error").toast({
                        delay: 1500
                    }).toast("show");
                    $(".toast-error .toast-body .text-body").text("selected asset error.");
                },
                complete: function() {
                    $(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                }
            });
		});

		$(function() {
			$(".input-mask").inputmask();
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});
</script>
