@extends('layouts.master')
@section('title', 'Print letter')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-printlet', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')

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

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			พิมพ์จดหมายลูกหนี้
		@endslot
		@slot('title_small')
			(Print letter)
		@endslot
		@slot('menu')
			รายงานติดตามลูกหนี้
		@endslot
		@slot('sub_menu')
			พิมพ์จดหมายลูกหนี้ | <a href="http://ckplus.com:8011/ckplus-logs" target="_blank">Logs</a>
		@endslot
	@endcomponent

	<div class="card">
		<form id="form_printlet" class="needs-validation" novalidate>
			<div class="row">
				<div class="card-body border-bottom">
					<div class="row g-3">
						<div class="col-xxl-4 col-lg-6">
							<div class="row g-2 mb-2">
								<div class="col-6">
									<div class="input-bx">
										<input type="text" id="LOCAT" name="LOCAT" value="{{ auth()->user()->UserToBranch->NickName_Branch }}" class="form-control LOCAT" required placeholder=" " />
										<input type="hidden" id="ID_LOCAT" name="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id }}" class="form-control ID_LOCAT" required placeholder=" " />
										<span>สาขา</span>
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

								<input type="hidden" name="ID_LOCAT" class="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id_Contract }}">
							</div>
							<div class="row g-2">
								<div class="col-6">
									<div class="input-bx">
										<select id="GCODE" name="GCODE" class="form-select text-dark" data-bs-toggle="tooltip" required placeholder=" ">
											<option value="" selected>-- ค้างงวด --</option>
											@foreach (@$GCODE as $row)
												<option value="{{ @$row->GCODE }}">{{ @$row->GCODE }} | {{ @$row->GDESC }}</option>
											@endforeach
										</select>
										<span>ค้างงวด</span>
									</div>
								</div>
								<div class="col-6">
									<div class="input-bx">
										<select id="FLAG" name="FLAG" class="form-select text-dark" data-bs-toggle="tooltip" placeholder=" ">
											<option value="">ทั้งหมด</option>
											<option value="Y">บันทึกแล้ว</option>
											<option value="N" selected>ยังไม่บันทึก</option>
										</select>
										<span>แสดงรายการ</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-2 col-lg-6">
							<div class="row g-2 mb-2">
								<div class="col-12">
									<div class="input-bx" id="datepicker1">
										<input type="text" name="START" id="START" value="{{ date('d/m/Y') }}" class="form-control text-start" placeholder="" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true" required>
										<span>จากวันที่</span>
									</div>
								</div>
							</div>
							<div class="row g-2 mb-2">
								<div class="col-12">
									<div class="input-bx" id="datepicker2">
										<input type="text" name="END" id="END" value="{{ date('d/m/Y') }}" class="form-control text-start" placeholder="" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true" required>
										<span>ถึงวันที่</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-4 col-lg-6">
							<div class="row g-2 mb-3">
								<div class="col-lg-12">
									<fieldset class="reset border-1 border-primary border-opacity-25 rounded-3 w-1">
										<legend class="reset">
											<h6 class="text-primary fw-semibold"><i class="mdi mdi-finance fs-4"></i> เลือกฟอร์มติดตามหนี้</h6>
										</legend>
										<div class="d-flex justify-content-around" id="mainForm">
											<div class="form-check mb-2">
												<input class="form-check-input" type="radio" name="form-letter" id="type-radio1" value="หนังสือทวงถาม" required>
												<label class="form-check-label" for="type-radio1">
													หนังสือทวงถาม
												</label>
											</div>
											<div class="form-check mb-2">
												<input class="form-check-input" type="radio" name="form-letter" id="type-radio2" value="หนังสือบอกเลิก" required>
												<label class="form-check-label" for="type-radio2">
													หนังสือบอกเลิก
												</label>
											</div>
											<div class="form-check mb-2">
												<input class="form-check-input" type="radio" name="form-letter" id="type-radio3" value="หนังสือโนติส" required>
												<label class="form-check-label" for="type-radio3">
													หนังสือโนติส
												</label>
											</div>
										</div>
										<input type="hidden" id="form-selcted" name="form-letter" value="">
									</fieldset>
								</div>
							</div>
						</div>
						<div class="col-xxl-2 col-lg-6">
							<div class="position-relative h-100 gap-3 p-3 d-flex justify-content-center">
								<button type="button" id="btn_search" class="btn btn-secondary h-100 w-sm">
									<i class="mdi mdi-filter-outline"></i> Filter
								</button>
								<button type="button" id="btn_reprint" class="btn btn-primary h-100 w-sm modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('letter.create') }}?page={{ 'print-letter' }}">
									<span data-bs-toggle="tooltip" title="รีปรินท์"><i class="bx bx-printer"></i> Reprint</span>
								</button>
								<!-- <button type="button" id="btn_printlet" class="btn btn-success h-100 w-sm" disabled><i class="bx bx-printer"></i> save</button> -->

								<!-- <button type="button" id="btn_search" class="btn btn-secondary"><i class="mdi mdi-filter-outline"></i> Filter</button>
										<button type="button" id="btn_saveStopvat" class="btn btn-primary"><i class="bx bxs-printer"></i> Reprint</button>
										<button type="button" id="btn_printlet" class="btn btn-success" disabled><i class="bx bx-save"></i> บันทึก</button>
										<button type="button" id="btn_form" class="btn btn-warning" disabled><i class="bx bxs-printer"></i> พิมพ์</button> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="contentData h-loading"></div>
		<div class="contentPrinted h-loading"></div>
		<div id="v-tabContent" style="max-height: 100vh;">
			<div class="row">
				<div class="col-12">
					<img src="{{ URL::asset('assets/images/undraw/undraw_user_flow.svg') }}" alt="" class="img-fluid mx-auto d-block mt-5">
				</div>
			</div>
		</div>

	</div>

	<script>
		$(function() {
			$("#GCODE").change(function() {
				var data = $(this).val();
				$("#Get_IDCard_cus").val('');
				$("#IDCard_cus").val('');
				$("#IDCard_cus2").val('');

				if (data == 'P2') {
					$("#type-radio1").attr('checked', true);
					$("#type-radio2").attr('required', false);
					$("#type-radio3").attr('required', false);
					$("#form-selcted").val('หนังสือทวงถาม');
				} else if (data == 'P3') {
					$("#type-radio2").attr('checked', true);
					$("#type-radio3").attr('required', false);
					$("#type-radio1").attr('required', false);
					$("#form-selcted").val('หนังสือบอกเลิก');
				} else if (data == 'P4') {
					$("#type-radio3").attr('checked', true);
					$("#type-radio2").attr('required', false);
					$("#type-radio1").attr('required', false);
					$("#form-selcted").val('หนังสือโนติส');
				} else {
					$("#type-radio1").attr('required', true);
					$("#type-radio1").attr('checked', false);
					$("#type-radio2").attr('required', true);
					$("#type-radio2").attr('checked', false);
					$("#type-radio3").attr('required', true);
					$("#type-radio3").attr('checked', false);
					$("#form-selcted").val('');
				}
			});
		});
	</script>

	{{-- btn_search --}}
	<script>
		$('#btn_search').click(function() {
			// $("#btn_reprint").attr('disabled',true);
			var dataform = document.querySelectorAll('#form_printlet');
			var validate = validateForms(dataform);

			if (validate == true) {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				let data = {};
				$("#form_printlet").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$.ajax({
					url: "{{ route('letter.show', [0]) }}",
					method: "get",
					data: {
						data: data,
						_token: "{{ @csrf_token() }}",
						page: 'print-letter',
					},

					success: async function(result) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						// Swal.fire({
						// 	icon: 'success',
						// 	text: 'ดึงข้อมูลสำเร็จ',
						// 	showConfirmButton: false,
						// 	timer: 1500
						// });
						$('.btnControl,.check-input').prop('disabled', false);
						$('#v-tabContent').hide();
						$('.contentPrinted').hide();
						$('.contentData').html(result.viewData).fadeIn('slow');

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
		$(function() {
			$("#btn_printlet").on('click', function() {
				const selectedTable = document.getElementById('selectedTable');
				const rows = selectedTable.querySelectorAll('tbody tr');

				var contno = '';

				rows.forEach(row => {
					const cells = row.querySelectorAll('td');
					const columnValue = cells[2].textContent || cells[2].innerText;
					contno += columnValue + ',\n';
				});
				$('#ConSelected').val(contno);

				var getContno = $('#ConSelected').val();
			});
		})
	</script>

	<script>
		$('#btn_reprint').click(function() {
			$("#btn_search").attr('disabled', true);
			$('#v-tabContent').show();
			$('.contentData').html('').fadeIn('slow');
		});
	</script>

	<script>
		$("#mainForm").on('click', function() {
			var form = document.querySelector("input[name = 'form-letter']:checked").value;
			$('#form-selcted').val(form);
		});
	</script>
@endsection
