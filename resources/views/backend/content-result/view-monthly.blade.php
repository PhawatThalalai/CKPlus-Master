@extends('layouts.master')
@section('title', 'Task Group')
@section('datatrack2-active', 'mm-active')
@section('datatrack2-p2-active', 'mm-active')
@section('page-frontend', 'd-none')
@section('content')
	<style>
		.btnAdd:hover {
			opacity: 0.7;
			cursor: pointer;
		}

		#container {
			position: relative;
			width: 100%;
			white-space: nowrap;
			scroll-snap-type: x mandatory;
		}

		.slide-content {
			display: inline-block;
		}

		.scroll-slide::-webkit-scrollbar {
			width: 1em;
			height: 0.5em;
			background-color: #F5F5F5;
		}

		.scroll-slide::-webkit-scrollbar-thumb {
			border-radius: 10px;
			-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
			/* background-color: black; */
		}

		.resize {
			transform-origin: 100% 50%;
		}
	</style>
	<style>
		.animated-progress {
			width: 90%;
			height: 15px;
			border-radius: 5px;
			margin: 20px 10px;
			border: 1px solid rgb(189, 113, 11);
			overflow: hidden;
			position: relative;
		}

		.animated-progress span {
			height: 100%;
			display: block;
			width: 0;
			color: rgb(255, 251, 251);
			line-height: 15px;
			position: absolute;
			text-align: end;
			padding-right: 5px;
			font-size: 10px;
		}

		.progress-green span {
			background-color: green;
		}

		.progress-red span {
			background-color: red;
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('backend.content-result.script')
	@component('components.breadcrumb')
		@slot('title')
			Monthly
		@endslot
		@slot('title_small')
			(รายการแบ่งกลุ่มลูกหนี้งานโทร)
		@endslot
	@endcomponent
	{{-- <div class="row mt-n3">
        <div class="card shadow-sm p-2">
            <div style="cursor: pointer; overflow: auto;  height: auto;"  class="scroll-slide">
                <div id="container">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="slide-content">
                            <div class="card border border-secondary mini-stats-wid" style="width:300px; height:150px;">
                                <div class="card-body">
                                    
                                    <div class="d-flex flex-wrap mb-5">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">สาขา {{$i+1}}</p>
                                            <h5 class="mb-0">120</h5>
                                        </div>

                                        <div class="avatar-sm ms-auto">
                                            <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                <!-- <i class="bx bxs-book-bookmark"></i> -->
                                                <img src="{{ URL::asset('/assets/images/ck-logo.png') }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="animated-progress progress-green mb-2">
                                        <span data-progress="{{52}}"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div> --}}
	<div class="tab-content p-3 card">
		<div class="tab-pane active" id="all-order" role="tabpanel">
			<form id='filter-detail'>
				<div class="row">
					<input type="hidden" id="page" value="{{ $page }}" />
					<div class="col-xl col-sm-6">
						<div class="mb-3">
							<label class="form-label">ณ วันที่</label>

							<select class="form-select addOPR" id="month" name="month" required>
								<option>-- เดือน --</option>
								<option value="01">มกราคม </option>
								<option value="02">กุมภาพันธ์ </option>
								<option value="03">มีนาคม </option>
								<option value="04">เมษายน </option>
								<option value="05">พฤษภาคม </option>
								<option value="06">มิถุนายน </option>
								<option value="07">กรกฎาคม </option>
								<option value="08">สิงหาคม </option>
								<option value="09">กันยายน </option>
								<option value="10">ตุลาคม </option>
								<option value="11">พฤศจิกายน </option>
								<option value="12">ธันวาคม </option>
							</select>

							{{-- <input type="text" value="{{ formatDateThaiMY($todayformat) }}" class="form-control"
                                readonly="true"> --}}
							<input type="hidden" name="MonthHidden" id="MonthHidden" value="{{ $monthformat }}" class="form-control" readonly="true">
							<input type="hidden" name="page" id="page" value="{{ $page }}" class="form-control" readonly="true">
						</div>
					</div>

					<div class="col-xl col-sm-6">
						<div class="mb-3">
							<label class="form-label">ทุกสาขา</label>
							<select class="form-select addOPR" id="branch" name="branch" required>
								<option value="" data-select2-id="6">-- ทุกสาขา --</option>
								@foreach ($branch as $key => $item)
									{
									<option value="{{ $item->id }}">{{ $item->Name_Branch }}</option>
									}
								@endforeach

							</select>
						</div>
					</div>

					<div class="col-xl col-sm-6">
						<div class="mb-3">
							<label class="form-label">ทุกทีมตาม</label>
							<select class="form-select addOPR" id="team" name="team" required>
								<option>-- ทุกทีมตาม --</option>
								<option value="yes">ใช่ </option>
								<option value="no"> ไม่ใช่</option>
							</select>
						</div>
					</div>

					<div class="col-xl col-sm-6">
						<div class="mb-3">
							<label class="form-label">สถานะชำระ</label>
							<select name="pay_status" id="pay_status" class="form-select" data-select2-id="4" tabindex="-1" aria-hidden="true">
								<option value="" data-select2-id="6">-- สถานะชำระ --</option>
								@foreach ($pay_status as $key => $item)
									{
									<option value="{{ $item->name }}">{{ $item->name }}</option>
									}
								@endforeach

							</select>
						</div>
					</div>

					<div class="col-xl col-sm-6">
						<div class="mb-3">

							<label class="form-label" for="FInstallment">จากงวด</label>
							<input type="number" id="FInstallment" class="form-control form-icon-trailing" min="0" name="FInstallment" />
							{{-- <td>
                            <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
        
                                <input type="text" value="02" name="demo_vertical" class="form-control">
                                
                            </div>
                        </td> --}}
						</div>
					</div>

					<div class="col-xl col-sm-6">
						<div class="mb-3">
							<label class="form-label" for="LInstallment">ถึง</label>
							<input type="number" id="LInstallment" class="form-control form-icon-trailing" min="0" name="LInstallment" />
						</div>
					</div>

					<div class="col-xl col-sm-6 align-self-end">
						<div class="mb-3">
							<button type="button" class=" form-control form-icon-trailing btn btn-primary" id="searchMonthlyBtn">ค้นหาข้อมูล</button>
						</div>
					</div>
					<div class="col-xl col-sm-6 align-self-end">
						<div class="mb-3">
							<button type="button" class=" form-control form-icon-trailing btn btn-danger" id="clearBtn">ล้างค่า</button>
						</div>
					</div>
				</div>
			</form>

			<div id='contentTable'>
				@include('backend.content-result.view-table')
			</div>
		</div>

	</div>
	<div class="content-loading" style="display: none !important">
		<div class="lds-facebook h-loading">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>

	<div class="modal fade" id="Modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="ModalScrollableTitle" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-xl modal-dialog-scrollable"></div><!-- /.modal-dialog -->
	</div>

	<script>
		$(document).on('click', '.Modal-xl', function(e) {
			e.preventDefault();
			var url = $(this).attr('data-link');
			// console.log(url);
			$('#Modal-xl .modal-dialog').load(url);
		});
	</script>

	{{-- <script>
        $(function() {
            $("#dailytable").DataTable({
                "pageLength": 5,
                ordering: true,
                columnDefs: [{
                    orderable: true,
                    targets: "no-sort"
                }],
            });

        })
    </script> --}}

	<script>
		$(".animated-progress span").each(function() {
			$(this).animate({
					width: $(this).attr("data-progress") + "%",
				},
				1000
			);
			$(this).text($(this).attr("data-progress") + "%");
		});
	</script>

@endsection
