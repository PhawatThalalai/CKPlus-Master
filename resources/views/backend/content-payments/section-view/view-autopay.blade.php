@extends('layouts.master')
@section('title', 'list auto payments')
@section('payments-active', 'mm-active')
@section('payments-auto-active', 'mm-active')
@section('autopayment-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<style>
		@import url("https://fonts.googleapis.com/css?family=Raleway:300,400,400i,700");

		.main-container {
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
		}

		.main-container h2 {
			margin: 0 0 80px 0;
			color: #555;
			font-size: 30px;
			font-weight: 300;
		}

		.radio-buttons {
			width: 100%;
			margin: 0 auto;
			text-align: center;
		}

		.custom-radio input {
			display: none;
		}

		.radio-btn {
			margin: 10px;
			width: 220px;
			height: 240px;
			border: 3px solid transparent;
			display: inline-block;
			border-radius: 10px;
			position: relative;
			text-align: center;
			box-shadow: 0 0 20px #c3c3c367;
			cursor: pointer;
		}

		.radio-btn>i {
			color: #ffffff;
			background-color: #f76342;
			font-size: 20px;
			position: absolute;
			top: -15px;
			left: 50%;
			transform: translateX(-50%) scale(2);
			border-radius: 50px;
			padding: 3px;
			transition: 0.5s;
			pointer-events: none;
			opacity: 0;
		}

		.radio-btn .hobbies-icon {
			width: 150px;
			height: 150px;
			position: absolute;
			top: 40%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

		.radio-btn .hobbies-icon img {
			display: block;
			width: 100%;
			margin-bottom: 20px;
		}

		.radio-btn .hobbies-icon i {
			color: #f76342;
			line-height: 80px;
			font-size: 60px;
		}

		.radio-btn .hobbies-icon h3 {
			color: #555;
			font-size: 18px;
			font-weight: 300;
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.custom-radio input:checked+.radio-btn {
			border: 2px solid #f76342;
		}

		.custom-radio input:checked+.radio-btn>i {
			opacity: 1;
			transform: translateX(-50%) scale(1);
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			รายการเตรียมชำระ
		@endslot
		@slot('title_small')
			(auto payments)
		@endslot
		@slot('menu')
			ระบบการเงิน
		@endslot
		@slot('sub_menu')
			ระบบตัดเงินอัตโนมัติ
		@endslot
	@endcomponent

	<div class="card">
		<div class="card-body border-bottom pb-1">
			<div class="d-flex align-items-center">
				<h6 class="mb-0 card-title flex-grow-1 text-muted d-inline-flex font-size-14">
					<i class="mdi mdi-reorder-horizontal font-size-14 me-1"></i> Lists :
					<span class="h-title d-none ms-1">หน้าหลัก</span>
					<span class="a-title"></span>
				</h6>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="content-loading m-5" style="display: none !important">
						<br><br>
						<div class="lds-facebook mb-6">
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
					<div class="text-center conten-codloans">
						<div class="row justify-content-center">
							<div class="col-xl-10">
								<h4 class="text-primary">โปรดเลือกประเภทสินเชื่อ !</h4>
							</div>
						</div>
						<div class="main-container">
							<div class="radio-buttons">
								<label class="custom-radio hover-slide">
									<input type="radio" name="radio" value="2" class="codloan">
									<span class="radio-btn"><i class="bx bxs-check-circle"></i>
										<div class="hobbies-icon">
											<img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-poetry-illustration_23-2149279810.jpg?size=626&ext=jpg">
											<h3 class="">เช่าซื้อ (HP)</h3>
										</div>
									</span>
								</label>
								<label class="custom-radio hover-slide">
									<input type="radio" name="radio" value="1" class="codloan">
									<span class="radio-btn"><i class="bx bxs-check-circle"></i>
										<div class="hobbies-icon">
											<img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-poetry-illustration_23-2149279810.jpg?size=626&ext=jpg">
											<h3 class="">เงินกู้ (PSL)</h3>
										</div>
									</span>
							</div>
						</div>
						<div class="row justify-content-center mx-3">
							<div class="col-6">
								<button type="button" id="btn_selectLoan" class="btn btn-warning btn-rounded w-lg w-75 waves-effect waves-light">
									<i class="mdi mdi-layers-triple label-icon"></i> ยืนยัน
								</button>
							</div>
						</div>
					</div>
					<div class="content-showdata"></div>
				</div>
			</div>

			{{-- <div class="text-center" style="min-height:15rem; max-height:15rem;">
				<img src="{{ URL::asset('\assets\images\asset\setting.png') }}" class="up-down mt-4" style="width:150px;">
				<h6 class="fw-semibold mt-2"></h6>
				<button type="button" class="btn btn-warning w-lg rounded-pill" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
					<i class="mdi mdi-cog-clockwise mdi-spin label-icon"></i> ประมวลรายการ
				</button>
			</div> --}}
		</div>
		<div class="card-footer bg-transparent border-top text-muted">
			<div class="text-center">
				<button class="btn btn-success d-none btn-rounded w-lg w-50 waves-effect waves-light" type="button" id="btn_selected">
					<i class="mdi mdi-checkbox-multiple-marked me-1"></i> ยืนยันรายการ
				</button>
			</div>
		</div>
	</div>

	<div class="modal fade bs-example-modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="d-flex m-3">
					<div class="flex-shrink-0 me-2">
						<img src="{{ asset('\assets\images\asset\setting.png') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
					</div>
					<div class="flex-grow-1 overflow-hidden">
						<h5 class="text-primary fw-semibold">ประมวลผลสัญญา ( Process contracts )</h5>
						<p class="text-muted mt-n1 fw-semibold font-size-12">ประจำวันที่ : {{ date('d-m-Y') }}</p>
						<p class="border-primary border-bottom mt-n2 m-2"></p>
					</div>
				</div>
				<div class="modal-body">
					<div class="text-center">
						<div class="row justify-content-center">
							<div class="col-xl-10">
								<h4 class="text-primary">โปรดเลือกประเภทสัญญา !</h4>
							</div>
						</div>

						<div class="main-container">
							<div class="radio-buttons">
								<label class="custom-radio">
									<input type="radio" name="radio" value="2" class="codloan">
									<span class="radio-btn"><i class="bx bxs-check-circle"></i>
										<div class="hobbies-icon">
											<img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-poetry-illustration_23-2149279810.jpg?size=626&ext=jpg">
											<h3 class="">เช่าซื้อ (HP)</h3>
										</div>
									</span>
								</label>
								<label class="custom-radio">
									<input type="radio" name="radio" value="1" class="codloan">
									<span class="radio-btn"><i class="bx bxs-check-circle"></i>
										<div class="hobbies-icon">
											<img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-poetry-illustration_23-2149279810.jpg?size=626&ext=jpg">
											<h3 class="">เงินกู้ (PSL)</h3>
										</div>
									</span>
							</div>
						</div>

						<div class="row justify-content-center mx-3">
							<div class="col-4">
								<div class="input-bx">
									<input type="text" value="{{ auth()->user()->name }}" class="form-control text-end" placeholder=" " readonly />
									<span>ผู้บันทึก</span>
									<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">
										<i class="bx bx-user"></i>
									</button>
								</div>
							</div>
							<div class="col-4">
								<div class="input-bx">
									<input type="text" value="{{ date('d-m-Y H:i:s') }}" class="form-control text-end" placeholder=" " readonly />
									<span>วัน - เวลา</span>
									<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">
										<i class="bx bx-calendar"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer float-end">
					<button type="button" id="btn_process" class="btn btn-warning btn-sm w-md hover-up">
						<span class="addSpin"><i class="fas fa-download"></i></span> ประมวลผล
					</button>
					<button type="button" id="btn_closeProcess" class="btn btn-secondary btn-sm w-md waves-effect hover-up" data-bs-dismiss="modal">
						<i class="mdi mdi-close-circle-outline"></i> ปิด
					</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var hTitleElement = document.querySelector('.h-title');

			hTitleElement.addEventListener('mouseover', function() {
				hTitleElement.style.cursor = "pointer";
				hTitleElement.style.color = 'blue'; // เปลี่ยนสีตัวอักษรเป็นสีน้ำเงินเมื่อชี้เมาส์
				hTitleElement.style.textDecoration = "underline";
			});

			hTitleElement.addEventListener('mouseout', function() {
				hTitleElement.style.cursor = "pointer";
				hTitleElement.style.color = ''; // ล้างสีตัวอักษรเมื่อถอยเมาส์
				hTitleElement.style.textDecoration = "none";
			});
		});
	</script>

	<script>
		$('.h-title').click(function() {
			$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			$('.content-showdata').slideUp();

			$('.h-title').addClass('d-none');
			$('.a-title').empty();

			$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
			$('.conten-codloans').slideDown('slow');
			$('#btn_selected').fadeOut('slow');
		});

		$('#btn_selectLoan').click(function() {
			var codloan = $("input[name='radio']:checked").val();

			if (typeof codloan != 'undefined' && codloan != '') {
				$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$('.conten-codloans').slideUp();

				let link = "{{ route('import.show', 'id') }}";
				let url = link.replace('id', codloan);
				$.ajax({
					url: url,
					method: "get",
					data: {
						funs: 'select-codloans',
						_token: "{{ @csrf_token() }}",
					},
					success: function(result) {
						$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						$('.content-showdata').html(result.viewData);
						$('.content-showdata').slideDown('slow');


						$('.h-title').removeClass('d-none');
						var aTitleElement = document.querySelector(".a-title");

						if (aTitleElement) {
							aTitleElement.textContent = " / " + result.a_tite;
							// aTitleElement.style.color = "blue";
							aTitleElement.style.cursor = "pointer";
							// aTitleElement.classList.add("text-muted");
						}
					},
					error: function(xhr, textStatus, errorThrown) {
						// กรณีมีข้อผิดพลาด
						console.log('เกิดข้อผิดพลาด: ' + textStatus);
						console.log('ข้อความข้อผิดพลาด: ' + errorThrown);
						// แสดงข้อความข้อผิดพลาดหรือดำเนินการอื่น ๆ ตามต้องการ
					}
				})
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'แจ้งเตือน !',
					text: 'โปรดเลือกประเภทสินเชื่อ ก่อนกดยืนยัน !!',
					showConfirmButton: false,
					timer: 2000
				})
			}
		});

		$('#btn_process').click(function() {
			var codloan = $("input[name='radio']:checked").val();

			if (typeof codloan != 'undefined' && codloan != '') {
				Swal.fire({
					icon: 'question',
					text: 'ยืนยันการประมวลสัญญา ?',
					showConfirmButton: true,
					showCancelButton: true,
					confirmButtonText: 'ตกลง',
					cancelButtonText: 'ยกเลิก',
					confirmButtonColor: '#42bd41',
					cancelButtonColor: '#fde0dc',
					allowOutsideClick: false,
				}).then((result) => {
					if (result.isConfirmed) {
						$(".loading-overlay").fadeIn().attr('style', '');
						$.ajax({
							url: "{{ route('import.create') }}",
							method: "get",
							data: {
								codloan: codloan,
								funs: 'process-data',
								_token: "{{ @csrf_token() }}",
							},
							success: function(result) {
								$(".loading-overlay").fadeOut().attr('style', 'display:none !important');
								Swal.fire({
									icon: 'success',
									text: 'Success !',
									showConfirmButton: false,
									timer: 1500
								})
								$('#btn_process').addClass('d-none');
							},
							error: function(xhr, textStatus, errorThrown) {
								// กรณีมีข้อผิดพลาด
								console.log('เกิดข้อผิดพลาด: ' + textStatus);
								console.log('ข้อความข้อผิดพลาด: ' + errorThrown);
								// แสดงข้อความข้อผิดพลาดหรือดำเนินการอื่น ๆ ตามต้องการ
							}
						})
					}
				});
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'แจ้งเตือน !',
					text: 'โปรดเลือกประเภทสัญญา ก่อนกดประมวล !!',
					showConfirmButton: false,
					timer: 1500
				})
			}
		});
	</script>
@endsection
