@extends('layouts.master')
@section('title', 'Tax System')
@section('tax-active', 'mm-active')
@section('tax-sub1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')

	@component('components.breadcrumb')
		@slot('title')
			ออกใบกำกับค่างวดปกติ
		@endslot
		@slot('title_small')
			(Invoice Normal Due)
		@endslot
		@slot('menu')
			<a href="http://ckplus.com:8011/ckplus-logs" target="_blank">Logs</a>
		@endslot
	@endcomponent

	<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

	<style>
		/* width */
		::-webkit-scrollbar {
			width: 10px;
		}

		/* Track */
		::-webkit-scrollbar-track {
			/* box-shadow: inset 0 0 5px grey;  */
			border-radius: 10px;
		}

		/* Handle */
		::-webkit-scrollbar-thumb {
			/* background: red;  */
			border-radius: 10px;
		}

		/* Add background color on hover for the table row */
		tr:hover {
			background-color: #f5f5f5;
		}
	</style>

	<style>
		.progress {
			position: absolute;
			/* top: 50%; */
			left: 50%;
			transform: translate(-50%, -50%);
			background: #ddd;
			height: 50px;
			width: 98%;
			text-align: center;
			border-radius: 20px;
		}

		.progress-done {
			font-family: sans-serif;
			font-weight: bolder;
			color: #fff;
			height: 100%;
			background: linear-gradient(to left, rgb(54, 114, 6),
					rgb(179, 250, 124));
			border-radius: 20px;
			display: grid;
			place-items: center;
			width: 10;
			box-shadow: 0 0 3px -5px rgb(54, 114, 6), 0 3px 150px rgb(179, 240, 122);
			transition: width .5s ease;
		}
	</style>

	<div class="card">
		<form id="form_tax" class="needs-validation" novalidate>
			<div class="row">
				<div class="col">
					<!-- <div class="card"> -->
					<div class="card-body border-bottom">
						<div class="row g-3">
							<div class="col-xxl-5 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" id="LOCAT" name="LOCAT" value="{{ auth()->user()->UserToBranch->NickName_Branch }}" class="form-control LOCAT" required placeholder=" " />
											<span>ออกใบกำกับที่</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'LOCAT' }}&modalID={{ 'modal_lg' }}">
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" class="form-control LOCATNAME" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly />
										</div>
									</div>

									<input type="hidden" name="HLOCAT" class="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id_Contract }}">
								</div>
								<div class="row g-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" id="CONTNO" name="CONTNO" value="" class="form-control" placeholder=" " />
											<span>เลขที่สัญญา</span>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" class="form-control" placeholder=" " readonly />
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-5 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-6">
										<div class="input-bx" id="datepicker1">
											<input type="text" name="tax_startdate" id="tax_startdate" value="{{ date('d/m/Y') }}" class="form-control text-start" placeholder="" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true" required>
											<span class="text-danger">สร้างวันที่</span>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx" id="datepicker2">
											<input type="text" name="tax_enddate" id="tax_enddate" value="{{ date('d/m/Y') }}" class="form-control text-start" placeholder="" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true" required>
											<span class="text-danger">ถึงวันที่</span>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-2">
									<div class="col-6">
										<div class="input-bx" id="datepicker1">
											<input type="text" class="form-control text-start" id="DATE_TAX" value="{{ date('d/m/Y', strtotime(@$CODENUM[0]->TAXDT)) }}" readonly>
											<span>วันที่สร้างใบกำกับล่าสุด</span>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" class="form-control" id="NUM_TAX" value="{{ @$CODENUM[0]->NUM }}" readonly />
											<span>ใบกำกับภาษีเลขที่ล่าสุด</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-2 col-lg-12">
								<div class="position-relative h-100 gap-2 p-3 d-flex justify-content-center">
									<button type="button" id="btn_search" class="btn btn-success h-100 w-sm">
										<i class="mdi mdi-filter-outline"></i> ประมวล
									</button>
									<button type="button" class="btn btn-primary h-100 w-sm modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('tax.create') }}?page={{'print-invoice-normal'}}">
										<i class="bx bx-printer"></i> พิมพ์
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- </div> -->
				</div>
			</div>
		</form>

		<input type="hidden" id="counter" value="0">

		<div class="tab-content" id="v-tabContent" style="max-height: 100vh;">
			<div class="card card-body h-100">
				<div class="row">
					<div class="col-12">
						<img src="{{ URL::asset('assets/images/undraw/undraw_receipt_re_fre3.svg') }}" alt="" class="img-fluid mx-auto d-block mt-5" style="width:350px;">
					</div>
				</div>
			</div>
		</div>
		<div class="card mt-5" id="progress" style="display:none;">
			<div class="col-12">
				<!-- <div class="progress mb-5">
						<div class="progress-done" data-done="100"></div>
					</div> -->
				<div class="progress text-center">
					<div class="progress-done text-center">10%</div>
				</div>
				<br>
				<br>
				<br>
			</div>
		</div>

	</div>

	{{-- btn --}}
	<script>
		$('#btn_search').click(function() {
			var dataform = document.querySelectorAll('#form_tax');
			var validate = validateForms(dataform);
			$("#btn_search").attr('disabled', true);
			$("#counter").val(1);

			if (validate == true) {
				$("#v-tabContent").hide();
				$("#progress").show();
				// $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **//
				let data = {};
				$("#form_tax").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$.ajax({
					url: "{{ route('tax.create') }}",
					method: "get",
					data: {
						data: data,
						_token: "{{ @csrf_token() }}",
						page: 'invoice-normal',
					},

					success: async function(result) {
						counterRun();
						var Getnewdate = result.dateTax;
						var newdate = new Date(Getnewdate);
						newdate.setDate(newdate.getDate());
						var dd = newdate.getDate();
						var mm = newdate.getMonth() + 1;
						var yyyy = newdate.getFullYear();
						if (dd < 10) {
							var Newdd = '0' + dd;
						} else {
							var Newdd = dd;
						}
						if (mm < 10) {
							var Newmm = '0' + mm;
						} else {
							var Newmm = mm;
						}
						var resultST = Newdd + '/' + Newmm + '/' + yyyy;
						$("#DATE_TAX").val(resultST);
						$("#NUM_TAX").val(result.numTax);
						$("#btn_search").attr('disabled', false);
						// $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						// Swal.fire({
						// 	icon: 'success',
						// 	text: 'ประมวลข้อมูลสำเร็จ',
						// 	showConfirmButton: false,
						// 	timer: 1500
						// });
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
					}
				})
			}
		});
	</script>

	<script>
		$('#create-more').click(function() {
			$("#CONTNO").removeAttr('readonly', true);
			$("#CONTNO").attr('required', true);
		});
	</script>

	<script>
		function counterRun() {
			var counter = parseInt(document.getElementById("counter").value);
			if (counter === 1) {
				var elem = document.querySelector(".progress-done");
				var width = 10;
				var main = setInterval(frame, 50);

				function frame() {
					if (width >= 100) {
						clearInterval(main);
						Swal.fire({
							icon: 'success',
							text: 'ประมวลข้อมูลสำเร็จ',
							showConfirmButton: false,
							timer: 1500
						});
					} else {
						width++;
						elem.style.width = width + "%";
						elem.innerHTML = width + "%";
					}
				}
			}
		}
	</script>
@endsection
