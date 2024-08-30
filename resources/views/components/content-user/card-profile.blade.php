<!-- start page -->
<style>
	/* Variable Declaration */
	:root {
		--shadow: #507abd;
		--bgColor: #5d84c3;
		--ribbonColor: #f5b16e;
	}

	/* The Ribbon */
	.ribbon {
		width: 70px;
		height: 60px;
		background-color: var(--ribbonColor);
		position: absolute;
		left: 10px;
		/* right: 100px; */
		top: -350px;
		animation: drop forwards 0.8s 1s cubic-bezier(0.165, 0.84, 0.44, 1);
		/* box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2); */
		/* เพิ่มเงาให้กับ Ribbon */
		text-align: center;
		/* จัดกลางเพื่อให้ข้อความอยู่กลาง */
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 2;
	}

	.ribbon:before {
		content: '';
		position: absolute;
		z-index: 2;
		left: 0;
		bottom: -50px;
		border-left: 35.5px solid var(--ribbonColor);
		border-right: 35.5px solid var(--ribbonColor);
		border-bottom: 50px solid transparent;
	}

	.ribbon-text {
		margin: 0;
		font-size: 16px;
		font-weight: bold;
		color: var(--shadow);
		/* สีเงาที่กำหนด */
	}
	/* Animation Keyframes */
	@keyframes drop {
		0% {
			top: -350px;
		}

		100% {
			top: 0;
		}
	}
</style>

<div class="card overflow-hidden">
	<div class="ribbon shadow-lg" style="{{ (@$data_broker != 'false') ? '' : 'display: none;' }}">
		<p class="ribbon-text">Broker
			<br>
			<span class="font-size-12 mt-n4">ผู้แนะนำ</span>
		</p>
	</div>
	<div class="bg-primary bg-soft">
		<div class="row">
			<div class="col-7">
				<div class="text-primary p-3">
					<h5 class="text-primary">Welcome Back !</h5>
					{{-- <p>It will seem like simplified</p> --}}
				</div>
			</div>
			<div class="col-5 align-self-end">
				<img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
			</div>
		</div>
	</div>
	<div class="card-body pt-0">
		<div class="row py-3">
			<div class="avatar-md profile-user-wid mb-4 col text-center">
				<img id="ImageBrok" src="{{ isset($data['image']) ? URL::asset(@$data['image']) : asset('/assets/images/users/user-1.png') }}" style="width: 150px; height: 150px;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
			</div>
		</div>
		<div class="row pt-2 mb-0">
			<div class="col-sm-12">
				@isset($data['status'])
				<span class="text-muted mb-0 d-flex justify-content-center " >
					<span class="modal_sm" data-link="{{ route('cus.edit',$data['id']) }}?funs={{'edit-Status'}}">
						@if (@$data['status'] == 'active')
							<a class="btn btn-outline-success btn-sm mb-2 font-size-15 rounded-pill w-md" data-bs-toggle="tooltip" title="สถานะ"> 
								ปกติ <i class="mdi mdi-account-edit ms-1"></i>
							</a>
						@elseif(@$data['status'] == 'cancel')
							<a class="btn btn-outline-secondary btn-sm mb-2 font-size-15 rounded-pill w-md" data-bs-toggle="tooltip" title="สถานะ"> 
								ยกเลิก <i class="mdi mdi-account-edit ms-1"></i>
							</a>
						@else
							<a class="btn btn-outline-danger btn-sm mb-2 font-size-15 rounded-pill w-md" data-bs-toggle="tooltip" title="สถานะ"> 
								blacklist <i class="mdi mdi-account-edit ms-1"></i>
							</a>
						@endif
					</span>
					<span>
						<a class="btn {{ (@$data_broker != 'false') ? 'btn-outline-warning' : 'btn-outline-secondary' }} btn-sm mb-2 font-size-15 rounded-pill ms-1 modal_lg btn_Broker" data-link="{{ route('cus.show', @$data['id']) }}?funs={{ 'add-broker' }}"> 
							<span class="btn_IconBroker">
								@if ((@$data_broker != 'false'))
									<i class="mdi mdi-account-circle" data-bs-toggle="tooltip" title="ผู้แนะนำ"></i> 
								@else
									<i class="mdi mdi-dots-vertical" data-bs-toggle="tooltip" title="ลงทะเบียนผู้แนะนำ"></i>
								@endif
							</span>
						</a>
					</span>
				</span>
				@endisset
			</div>
		</div>
	</div>

	@if( !empty(@$data) )
	<!-- Nav tabs -->
	<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
		<li class="nav-item" role="presentation">
			<a class="nav-link active" data-bs-toggle="tab" href="#data_user" role="tab" aria-selected="true">
				<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
				<div class="d-none d-sm-block flex-fill">
					<div class="d-flex flex-column justify-content-center mini-stats-wid">
						<div class="flex-shrink-0 align-self-center">
							<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="ข้อมูลลูกค้า">
								<span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20">
									<i class="bx bx-user-circle"></i>
								</span>
							</div>
						</div>
						<div>
							<span class="badge bg-warning align-item-center">
								ลูกค้า
							</span>
						</div>
					</div>
				</div>
			</a>
		</li>
		<li class="nav-item {{ @$flag }}" role="presentation">
			<a class="nav-link" data-bs-toggle="tab" href="#data_asset" role="tab" aria-selected="false" tabindex="-1" data-loaded="false">
				<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
				<div class="d-none d-sm-block flex-fill">
					<div class="d-flex flex-column justify-content-center mini-stats-wid">
						<div class="flex-shrink-0 align-self-center">
							<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="ข้อมูลทรัพย์สิน">
								<span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20">
									<i class="bx bx-archive"></i>
								</span>
							</div>
						</div>
						<div>
							<span class="badge bg-warning align-item-center">
								ทรัพย์สิน
							</span>
						</div>
					</div>
				</div>
			</a>
		</li>
		<li class="nav-item" role="presentation">
			<a class="nav-link" data-bs-toggle="tab" href="#data_contract" role="tab" aria-selected="false" tabindex="-1">
				<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
				<div class="d-none d-sm-block flex-fill">
					<div class="d-flex flex-column justify-content-center mini-stats-wid">
						<div class="flex-shrink-0 align-self-center">
							<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
								<span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20">
									<i class="bx bx-sitemap"></i>
								</span>
							</div>
						</div>
						<div>
							<span class="badge bg-warning align-self-center">
								สัญญา
							</span>
						</div>
					</div>
				</div>
			</a>
		</li>
	</ul>
	@endif
</div>
<div class="card profile-user-card-margin">
	<div class="card-body">
		<h4 class="card-title text-muted mb-3">Personal Information</h4>
		<div data-simplebar style="cursor: pointer;">
			<ul class="list-unstyled">
				<li>
					<div class="d-flex">
						<i class="bx bx-user-circle text-primary fs-4"></i>
						<div class="ms-3">
							<h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
							<p class="text-muted fs-14 mb-0">
								{{--
								{{ @$data['Prefix'] . ' ' . @$data['name'] . ' ' . @$data['surname'] }}
								--}}
								{{ @$data['fullname'] }}
								@isset($data['nickname'])
									{{ ' (' . @$data['nickname'] . ')' }}
								@endisset
								@isset($data['NameEng'])
									<br>
									<span class="text-primary">
										<b>{{ '' . @$data['NameEng'] . '' }}</b>
									</span>
								@endisset
							</p>
						</div>
					</div>
				</li>
				<li class="mt-3">
					<div class="d-flex">
						{{ @$id_card_icon }}
						<div class="ms-3">
							{{-- <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{@$data['idcard']}}</p> --}}
							<h6 class="fs-14 mb-2 fw-semibold">{{ @$id_card_name }}</h6>
							@isset($data['idcard'])
								<p @if (empty(@$data['typeidcard']) || $data['typeidcard'] == '324001') class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'"
                                    @else
                                    class="text-muted fs-14 mb-0" @endif>
									{{ @$data['idcard'] }}
								</p>
								{{ @$id_card_exp }}
							@endisset
						</div>
					</div>
				</li>
				<li class="mt-3">
					<div class="d-flex">
						<i class="bx bx-phone text-primary fs-4"></i>
						<div class="ms-3">
							<h6 class="fs-14 mb-2 fw-semibold">เบอร์ติดต่อ</h6>

							{{--
							<p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-999-9999,999-999-9999'">{{ @$data['phone'] }}</p>
							--}}
							@if ( !empty( getFirstPhone_php(@$data['phone']) ) )
								<p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '99 9999 9999'">{{getFirstPhone_php(@$data['phone'])}}</p>
							@endif

							@php
								$phone_cus_2 = "";
								if ( empty(@$data['phone2']) ) {
									$_phone_numbers = explode(',', @$data['phone']);
									if ( isset($_phone_numbers[1]) ) {
										$phone_cus_2 = $_phone_numbers[1];
									}
								} else {
									$phone_cus_2 = @$data['phone2'];
								}
							@endphp
							@if ( !empty( $phone_cus_2 ) )
								<p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '99 9999 9999'">{{$phone_cus_2}}</p>
							@endif

						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="card-body profile-user-card-margin">
		<h4 class="card-title text-muted mb-3">General Information</h4>
		<div data-simplebar style="max-height: 230px;cursor: pointer;">
			<ul class="list-unstyled">
				<li>
					<div class="d-flex">
						<i class="bx bx-calendar-event text-primary fs-4"></i>
						<div class="ms-3">
							<h6 class="fs-14 mb-2 fw-semibold">วันที่เข้าระบบ</h6>
							<p class="text-muted fs-14 mb-0">{{ isset($data['dateinput']) ? date('d-m-Y', strtotime(@$data['dateinput'])) : '' }}</p>
						</div>
					</div>
				</li>
				<li class="mt-3">
					<div class="d-flex">
						<i class="bx bx-user text-primary fs-4"></i>
						<div class="ms-3">
							<h6 class="fs-14 mb-2 fw-semibold">ผู้ลงบันทึก</h6>
							<p class="text-muted fs-14 mb-0">{{ @$data['UserInsert'] }}</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- end page -->

@if( !empty(@$data['id']) )
	<!-- สคริปต์สำหรับดึงข้อมูลแท็บทรัพย์มาแสดง -->
	<script>
		$(document).ready(function() {

			$('a[data-bs-toggle="tab"][href="#data_asset"]').on('shown.bs.tab', function(e){
				if ( $("#data_asset").data('loaded') == 'complete' ) {
					return;
				}
				//event.target // newly activated tab
				//event.relatedTarget // previous active tab
				//console.log(e);

				var cus_id = {{ $data['id'] }};
				/*
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				*/
				//$("#data_asset .content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

				$.ajax({
					method: "get",
					url: "{{ route('asset.index') }}",
					data: {
						//_token: "{{ @csrf_token() }}",
						type: 'tab',
						cus_id: cus_id
					},
					complete: function(data) {
						//$("#data_asset .content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					success: function (data) {
						if (data.status == true) {
							//toastr.success(data.message);
							$("#data_asset").data('loaded', 'complete');
							$('#content_asset').html(data.html);
						} else {
							//toastr.error(data.message);
						}
					},
				});

			});

		});
	</script>
@endif