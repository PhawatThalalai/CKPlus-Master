@extends('layouts.master')
@section('title', 'Void Receipt')
@section('payments-active', 'mm-active')
@section('payments-cancel-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<style>
		.reset {
			all: revert;
		}

		.input-fieldset {
			padding-bottom: 2px;
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])

	@component('components.breadcrumb')
		@slot('title')
			Void Receipt
		@endslot
		@slot('title_small')
			(แจ้งขอยกเลิกใบรับ)
		@endslot
		@slot('menu')
			การเงิน
		@endslot
		@slot('sub_menu')
			ยกเลิกใบรับค่างวด
		@endslot
	@endcomponent

	@component('components.content-date.date-range')
		@slot('data', [
			'page' => @$page,
			'Fdate' => @$Fdate1,
			'Tdate' => @$Tdate1,
			])
			@slot('btn', [
				'btn_statuscus' => false,
				'btn_print' => false,
				'btn_refresh' => true,
				])
			@endcomponent

			<div id="content">
				@include('backend.content-payments.section-CnPay.view-content-Cnpay', ['dataHp' => @$dataHp, 'dataPsl' => @$dataPsl])
			</div>

			<!-- สคริปต์จัดการปุ่ม Refresh -->
			<script>
				$('.btn_refresh').off('click').on('click', function() {
					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$.ajax({
						url: "{{ route('payments.index') }}",
						method: "get",
						data: {
							page: 'cn-pays',
							func: 'fresh',
							start: $("#start").val() ? $("#start").val() : null,
							end: $("#end").val() ? $("#end").val() : null,
						},
						complete: function(data) {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						},
						success: function(result) {
							if (result.message == 'success') {
								Swal.fire({
									icon: 'success',
									title: 'รีเฟรชสำเร็จ!',
									text: 'อัปเดตข้อมูลที่แสดงเป็นข้อมูลล่าสุดแล้ว',
									showConfirmButton: false,
									timer: 1500
								});
								$("#content").html(result.html).show('slow');
							}
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: 'ล้มเหลว !',
								text: 'ขออภัย กรุณาลองอีกครั้งในภายหลัง !',
								showConfirmButton: false,
								timer: 1500
							});
						}
					});
				})
			</script>

		@endsection
