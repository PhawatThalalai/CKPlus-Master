script@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub2-active', 'mm-active')
@section('account-p5-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			บันทึกรายการหนี้สูญ
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			บันทึกรายการหนี้สูญ
		@endslot
	@endcomponent

	@include('public-js.constants')
	<div id="contentForm">
		@include('backend.content-temp.section-badDebt.form')
	</div>
	<div class="row mt-4">
		<div class="col text-end">
			<div class="d-flex flex-wrap flex-row-reverse gap-2">
				<button type="button" id="PrintBTN" class="btn btn-info waves-effect waves-light w-sm" disabled>
					<i class="mdi mdi-printer-settings d-block font-size-16"></i> พิมพ์
				</button>
				<button id="btn-clear" type="button" class="btn btn-danger waves-effect waves-light w-sm" disabled>
					<i class="mdi mdi-book-cancel-outline d-block font-size-16"></i> ยกเลิก
				</button>
				<button id="btn-saveBadDebt" type="button" class="btn btn-success waves-effect waves-light w-sm" disabled>
					<i class="mdi mdi-content-save d-block font-size-16"></i> <i class="mdi mdi-spin mdi-loading d-block d-none font-size-16"></i> บันทึก
				</button>
				<button type="button" class="btn btn-dark waves-effect waves-light w-sm searchContract">
					<i class="mdi mdi mdi-account-search d-block font-size-16"></i> สอบถาม
				</button>
			</div>
		</div>
	</div>

	<script>
		$('#btn-clear').click(() => {
			$('#bad-debtForm input[type=text]').val("")
		})
	</script>

	<script>
		$("#btn-saveBadDebt").click(function() {
			var dataform = $('#bad-debtForm');
			var validate = validateForms(dataform);
			if (validate == true) {
				$('.mdi-loading').removeClass('d-none')
				$('.mdi-content-save').addClass('d-none')
				$.ajax({
					url: "{{ route('account.store') }}",
					method: 'POST',
					data: $("#bad-debtForm").serialize(),
					success: (result) => {
						$('.mdi-content-save').removeClass('d-none')
						$('.mdi-loading').addClass('d-none')
						$('#modal_xl').modal('hide');
						swal.fire({
							icon: 'success',
							title: 'บันทึกข้อมูลสำเร็จ',
							timer: 1500,
							showConfirmButton: false,
						})
						//   $("#TrackDetails").html(result);
					},
					error: (err) => {
						$('.mdi-content-save').removeClass('d-none')
						$('.mdi-loading').addClass('d-none')
					}
				});
			}
		});
	</script>

	{{-- Print BTN --}}
	<script>
		$(function() {
			$('#PrintBTN').click(function() {
				let id = $(this).data('id');
				let url =
					"{{ route('report-backend.show', ':id') }}?page={{ 'rp-terminate' }}&loadtype={{ @$contract->CODLOAN }}";
				url = url.replace(':id', id);
				// let url = "https://themesbrand.com/skote/layouts/layouts-hori-boxed-width.html";
				window.open(url, "_blank",
					"toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=200,width=1100,height=500");
			});
		});
	</script>

	{{-- สอบถาม --}}
	<script type="text/javascript">
		$(".searchContract").click(function() {
			var search = $('.header_inputSearch').val();
			var typeSr = 'contract';
			var page_type = $('.page_type').val();
			var page = $('.page').val();
			var pageUrl = 'bad-debt';
			var _token = $('input[name="_token"]').val();
			var flagTab = 'add-Broker';
			var dataFlag = 'bad-debt';
			$('.page_tmp').val('search-baddebt')
			getDataCus(search, typeSr, page, pageUrl, page_type, _token, flagTab, dataFlag)
		});
	</script>

@endsection
