@extends('layouts.master')
@section('title', 'Task Group')
@section('datatrack-active', 'mm-active')
@section('datatrack-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')

	<!-- ปุ่มแท็บ FormStpe เรืองแสง  -->
	<style>
		@keyframes anim-glow-primary {
			0% {
				box-shadow: 0 0 rgba(var(--bs-primary-rgb), 1);
			}

			100% {
				box-shadow: 0 0 1rem 0.8rem transparent;
			}
		}

		.glow-primary {
			animation: anim-glow-primary 1s ease infinite;
		}

		@keyframes anim-glow-danger {
			0% {
				box-shadow: 0 0 rgba(var(--bs-danger-rgb), 1);
			}

			100% {
				box-shadow: 0 0 1rem 0.8rem transparent;
			}
		}

		.glow-danger {
			animation: anim-glow-danger 1s ease infinite;
		}

		/*.tab-form-step-btn.nav-link.active {
															/* background-color: initial; /* กลับไปใช้สีพื้นหลังเริ่มต้น */
		/* color: initial; /* กลับไปใช้สีตัวอักษรเริ่มต้น */
		.tab-form-step-btn.nav-link {
			width: 2rem;
			height: 2rem;
			font-size: 0.8rem;
			transition: width .5s ease, height .5s ease, font-size .5s ease
		}

		.tab-form-step-btn.nav-link.active {
			width: 2.75rem;
			height: 2.75rem;
			font-size: 1.125rem;
		}

		@keyframes anim-glow-secondary {
			0% {
				box-shadow: 0 0 rgba(var(--bs-secondary-rgb), 1);
			}

			100% {
				box-shadow: 0 0 1rem 0.8rem transparent;
			}
		}

		.glow-secondary {
			animation: anim-glow-secondary 1s ease infinite;
		}
	</style>

	<!-- CSS ของ edit-assign -->
	<style>
		/* กำหนดค่าเริ่มต้นให้ div เรียงเป็นแนวนอน */
		.edit-assign-setsubgroup {
			display: flex;
			flex-direction: row;
			/* hstack แนวนอน */
		}

		/* กำหนดให้เมื่อหน้าจอมีขนาด XL (1200px) หรือมากกว่า */
		@media (min-width: 1200px) {
			.edit-assign-setsubgroup {
				flex-direction: column;
				/* vstack แนวตั้ง */
			}
		}
	</style>

	<!-- หัวตาราง ติดขอบ -->
	<style>
		.table-subgroup thead th {
			position: sticky;
			top: 0;
		}
	</style>

	<style>
		/* Hide scrollbar for all elements */
		.no-scrollbar {
			-ms-overflow-style: none;
			/* Internet Explorer 10+ */
			scrollbar-width: none;
			/* Firefox */
		}

		/* Hide scrollbar for webkit browsers */
		.no-scrollbar::-webkit-scrollbar {
			display: none;
			/* Safari and Chrome */
		}

		.overflow-billcoll {
			overflow-y: auto;
			overflow-x: auto;
			max-height: 10rem;
			touch-action: auto;
			-webkit-overflow-scrolling: touch;
			white-space: nowrap;
		}
	</style>

	<!-- ลูกศร collapse หมุนได้ -->
	<style>
		.collapse-arrow-icon {
			display: inline-block;
			transition: transform 0.3s ease;
		}

		.collapsed .collapse-arrow-icon {
			transform: rotate(-90deg);
		}
	</style>

	<!-- ตาราง editbillcoll -->
	<style>
		.table-editbillcoll {}

		.table-editbillcoll tbody tr {
			cursor: pointer;
		}

		.table-editbillcoll tbody tr:hover {
			transform: scale(1.01);
			font-weight: 600;
		}

		.table-editbillcoll .table-active {
			font-weight: 600;
			color: var(--bs-link-color);
		}

		.table-editbillcoll tr.table-active:hover {
			color: var(--bs-link-hover-color);
		}
	</style>

	<!-- edit-billcoll panel ของ Tab 3 -->
	<style>
		.sliding-edit-billcoll-panel {
			position: fixed;
			bottom: 0;
			left: 5%;
			width: 100%;
			max-width: 300px;
			height: 50px;
			transition: height 0.3s ease;
			overflow: hidden;
			z-index: 1050;
			overflow: visible
		}

		.sliding-edit-billcoll-panel.open {
			height: 50%;
		}

		.toggle-billcoll-btn-icon {
			display: inline-block;
			transition: transform 0.3s ease;
		}

		.sliding-edit-billcoll-panel.open .toggle-billcoll-btn-icon {
			transform: rotate(-180deg);
		}

		.edit-billcoll-panel-content {
			height: 100%;
			display: flex;
			flex-direction: column;
		}

		.edit-billcoll-itemlist {
			flex-grow: 1;
			overflow-y: auto;
			padding: 10px;
			scrollbar-width: thin;
		}

		.edit-billcoll-itemselected {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 5px 0;
			border-bottom: 1px solid rgba(var(--bs-dark-rgb), .1);
		}

		.edit-billcoll-itemselected:last-child {
			border-bottom: none;
		}
	</style>

	<!-- option แบบ disabled -->
	<style>
		.TYPECONT option:disabled {
			background: #ccc;
		}

		[data-layout-mode="dark"] .form-select:disabled {
			color: #74788d;
			background-color: #222;
		}
	</style>

	<style>
		.nav-success {
			--bs-link-hover-color: #2a9c72;
			--bs-nav-pills-link-active-bg: var(--bs-success);
			--bs-nav-link-color: var(--bs-success);
			--bs-nav-link-hover-color: var(--bs-link-hover-color);
		}

		.nav-warning {
			--bs-link-hover-color: #c1903d;
			--bs-nav-pills-link-active-bg: var(--bs-warning);
			--bs-nav-link-color: var(--bs-warning);
			--bs-nav-link-hover-color: var(--bs-link-hover-color);
		}

		.link-warning-darker {
			--bs-link-color: #c0903c;
			--bs-link-hover-color: #906c2d;
		}
	</style>

	<style>
		.checkout-tabs .nav-pills .nav-link.active {
			background-color: var(--bs-nav-pills-link-active-bg)
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			Track Task
		@endslot
		@slot('title_small')
			(บันทึกแบ่งกลุ่มลูกหนี้)
		@endslot
	@endcomponent

	<!--
									<option value="" selected>--- เลือกกลุ่มงาน ---</option>
									<option value="phone">1. กลุ่มงานโทร</option>
									<option value="track">2. กลุ่มงานตาม</option>
									<option value="land">3. กลุ่มงานที่ดิน</option>
		-->
	<div class="checkout-tabs">
		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-12">
				<div class="nav flex-row flex-lg-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active d-none" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">

						<i class="bx bxs-home d-block check-nav-icon mt-4 mb-2"></i>
						<p class="fw-bold mb-4">Home</p>

					</a>
					<a class="nav-link flex-fill d-flex align-items-center position-relative" id="v-pills-phone-tab" data-bs-toggle="pill" href="#v-pills-phone" role="tab" aria-controls="v-pills-phone" aria-selected="false" tabindex="-1">

						@if ($phone_unassigned > 0 || $phone_unconfirmed > 0)
							<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
								{{ $phone_unassigned + $phone_unconfirmed }}
								<span class="visually-hidden">unassing group</span>
							</span>
						@endif

						<span class="d-block d-sm-none flex-fill">
							<i @class([
								'bx bxs-phone-call fs-4',
								'bx-tada' => $phone_unassigned > 0 || $phone_unconfirmed > 0,
							])></i>
						</span>
						<div class="d-none d-sm-block flex-fill">
							<i @class([
								'bx bxs-phone-call d-block check-nav-icon mt-4 mb-2',
								'bx-tada' => $phone_unassigned > 0 || $phone_unconfirmed > 0,
							])></i>
							<p class="fw-bold mb-4">กลุ่มงานโทร</p>
						</div>

					</a>
					<a class="nav-link nav-warning flex-fill d-flex align-items-center position-relative ms-lg-0 ms-3" id="v-pills-track-tab" data-bs-toggle="pill" href="#v-pills-track" role="tab" aria-controls="v-pills-track" aria-selected="false" tabindex="-1">

						@if ($track_unassigned > 0 || $track_unconfirmed > 0)
							<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
								{{ $track_unassigned + $track_unconfirmed }}
								<span class="visually-hidden">unassing group</span>
							</span>
						@endif

						<span class="d-block d-sm-none flex-fill">
							<i @class([
								'bx bx-rocket fs-4',
								'bx-tada' => $track_unassigned > 0 || $track_unconfirmed > 0,
							])></i>
						</span>
						<div class="d-none d-sm-block flex-fill">
							<i @class([
								'bx bx-rocket d-block check-nav-icon mt-4 mb-2',
								'bx-tada' => $track_unassigned > 0 || $track_unconfirmed > 0,
							])></i>
							<p class="fw-bold mb-4">กลุ่มงานตาม</p>
						</div>

					</a>
					<a class="nav-link nav-success flex-fill d-flex align-items-center position-relative ms-lg-0 ms-3" id="v-pills-land-tab" data-bs-toggle="pill" href="#v-pills-land" role="tab" aria-controls="v-pills-land" aria-selected="false" tabindex="-1">

						@if ($land_unassigned > 0 || $land_unconfirmed > 0)
							<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
								{{ $land_unassigned + $land_unconfirmed }}
								<span class="visually-hidden">unassing group</span>
							</span>
						@endif

						<span class="d-block d-sm-none flex-fill">
							<i @class([
								'bx bx-map-alt fs-4',
								'bx-tada' => $land_unassigned > 0 || $land_unconfirmed > 0,
							])></i>
						</span>
						<div class="d-none d-sm-block flex-fill">
							<i @class([
								'bx bx-map-alt d-block check-nav-icon mt-4 mb-2',
								'bx-tada' => $land_unassigned > 0 || $land_unconfirmed > 0,
							])></i>
							<p class="fw-bold mb-4">กลุ่มงานที่ดิน</p>
						</div>

					</a>
				</div>
			</div>
			<div class="col-xl-10 col-lg-10 col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

								<div class="row justify-content-center">
									<div class="col-12">
										<div class="maintenance-img">
											<img src="{{ asset('assets/images/undraw/undraw_selecting_team_re_ndkb.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
										</div>
									</div>
								</div>

							</div>
							<!-- แท็บ ทีมโทร Phone -->
							<div class="tab-pane fade" id="v-pills-phone" role="tabpanel" aria-labelledby="v-pills-phone-tab">
								<!-- เนื้อหาแท็บ ทีมโทร Phone -->
								<div id="phone-tabContent">

									@include('backend.content-track.session-task.tabContent.phone')

								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-track" role="tabpanel" aria-labelledby="v-pills-track-tab">
								<div id="track-tabContent">
									@include('backend.content-track.session-task.tabContent.track')
								</div>
							</div>
							<div class="tab-pane fade" id="v-pills-land" role="tabpanel" aria-labelledby="v-pills-land-tab">
								<div id="land-tabContent">
									@include('backend.content-track.session-task.tabContent.land')
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- ปลายการ์ด -->
				<div class="row mt-4 d-none">
					<div class="col-sm-6">
						<a href="ecommerce-cart.html" class="btn text-muted d-none d-sm-inline-block btn-link">
							<i class="mdi mdi-arrow-left me-1"></i> Back to Shopping Cart </a>
					</div> <!-- end col -->
					<div class="col-sm-6">
						<div class="text-end">
							<a href="ecommerce-checkout.html" class="btn btn-success">
								<i class="mdi mdi-truck-fast me-1"></i> Proceed to Shipping </a>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->

			</div>
		</div>
	</div>

	<script>
		var myModalEl = document.getElementById('modal_xl_2')
		myModalEl.addEventListener('hidden.bs.modal', function(event) {
			$('#modal_xl_2 .modal-xl').empty();
			//console.log('Clear modal successfully!');
		})
	</script>

	<script>
		var elem = document.documentElement;

		function openFullscreen() {
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			} else if (elem.webkitRequestFullscreen) {
				/* Safari */
				elem.webkitRequestFullscreen();
			} else if (elem.msRequestFullscreen) {
				/* IE11 */
				elem.msRequestFullscreen();
			}
		}

		function closeFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				/* Safari */
				document.webkitExitFullscreen();
			} else if (document.msExitFullscreen) {
				/* IE11 */
				document.msExitFullscreen();
			}
		}
	</script>

	<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

	<!-- จัดการการแสดงผลเรื่อง badge danger -->
	<script>
		document.querySelectorAll('a[data-bs-toggle="pill"]').forEach(function(buttonElement) {

			buttonElement.addEventListener('shown.bs.tab', function(e) {
				var currentTab = e.target.getAttribute('href'); // แท็บปัจจุบันที่แสดงแล้ว
				var tabBtn = $(`a[data-bs-toggle="pill"][href="${currentTab}"]`)[0];
				$(tabBtn).children(".badge.bg-danger").remove();
				$(tabBtn).children().children("i").removeClass("bx-tada");
			});

		});
	</script>

	<!-- สคริปตจัดการเรื่อง EditBillcoll Tab 3 -->
	<script>
		// ฟังก์ชันเพิ่มรายการที่เลือก
		function addEditBillCollPortItem(typeport, portid, display_text, tooltipText = "") {
			var panel = null;
			var itemlist_div = null;
			var exampleItem = null;
			//-------------------------------------------------------------
			if (typeport == 'phone') {
				panel = $("#EditBillColl_Phone_Panel");
			}
			if (typeport == 'track') {
				panel = $("#EditBillColl_Track_Panel");
			}
			if (typeport == 'land') {
				panel = $("#EditBillColl_Land_Panel");
			}
			itemlist_div = $(panel).find(".edit-billcoll-itemlist");
			exampleItem = $(itemlist_div).siblings(".exampleItem");
			//-------------------------------------------------------------
			var newItem = exampleItem.clone().removeClass('d-none exampleItem');

			//var portItem = editbillcoll_phone.find((item) => { return item.id === portid })

			newItem.find('span').text(display_text);
			newItem.find('input').val(portid);
			if (tooltipText != "") {
				newItem.find('span').attr('title', tooltipText); // Add custom tooltip text
				newItem.find('span').data('tooltiptext', tooltipText);
				newItem.find('span').tooltip(); // Initialize Bootstrap tooltip
			}

			newItem.find('.remove-billcoll-item-btn').on('click', function() {
				$(`.table-editbillcoll tr[data-portid="${portid}"] input[type='checkbox']`).click();
			});

			itemlist_div.append(newItem);

			$(itemlist_div).find('.placeholder-message').hide();
			updateSelectedCount(typeport);
		}

		function removeEditBillCollPortItem(typeport, portid) {
			var panel = null;
			var itemlist_div = null;
			var exampleItem = null;
			//-------------------------------------------------------------
			if (typeport == 'phone') {
				panel = $("#EditBillColl_Phone_Panel");
			}
			if (typeport == 'track') {
				panel = $("#EditBillColl_Track_Panel");
			}
			if (typeport == 'land') {
				panel = $("#EditBillColl_Land_Panel");
			}
			//-------------------------------------------------------------
			//$(this).tooltip('dispose');  // Dispose tooltip before removing
			var itemselected = $(panel).find(`.edit-billcoll-itemlist input[value="${portid}"]`).parent();
			$(itemselected).find('span').tooltip('dispose');
			$(itemselected).remove();
			//-------------------------------------------------------------
			updateSelectedCount(typeport);
		}

		// Function to update the count of selected items
		function updateSelectedCount(typeport) {
			var panel = null;
			var itemlist_div = null;
			var exampleItem = null;
			//-------------------------------------------------------------
			if (typeport == 'phone') {
				panel = $("#EditBillColl_Phone_Panel");
			}
			if (typeport == 'track') {
				panel = $("#EditBillColl_Track_Panel");
			}
			if (typeport == 'land') {
				panel = $("#EditBillColl_Land_Panel");
			}
			itemlist_div = $(panel).find(".edit-billcoll-itemlist");
			//------------------------------------------------------------
			var count = $(itemlist_div).find('.edit-billcoll-itemselected').length;
			$(panel).find('.selectedCount').text(count);
			if (count === 0) {
				$(itemlist_div).find('.placeholder-message').show();
			}

			var toggleButton = $(panel).find(".editBillCollToggleBtn");

			if (count > 0) {
				$(panel).find('.count-billcoll-hold').text(`(${count})`);
				if (!$(panel).hasClass("open")) {
					$(toggleButton).addClass("glow-danger");
					$(toggleButton).find(".noti-dot").show();
				}
			} else {
				$(panel).find('.count-billcoll-hold').empty();
				if (!$(panel).hasClass("open")) {
					$(toggleButton).removeClass("glow-danger");
					$(toggleButton).find(".noti-dot").hide();
				}
			}

		}
	</script>

@endsection
