<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

<div class="modal-content" id="modal_history">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ประวัติการโอนเงิน (History transfer)</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">User. : {{ auth()->user()->name }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>

	<div class="modal-body">
		<div class="row search-box-top">
			<div class="col-12">
				<div class="float-sm-end d-sm-flex align-items-center">
					<div class="search-box">
						<div class="position-relative" id="search_box">
							<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
								<input type="text" class="form-control shadow-sm me-2" name="start" id="start" value="{{date('d-m-Y')}}" placeholder="Start Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
								<input type="text" class="form-control shadow-sm" name="end" id="end" value="{{date('d-m-Y')}}" placeholder="End Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
							</div>
						</div>
					</div>
					<div class="">
						<ul class="nav nav-pills product-view-nav justify-content-center mt-sm-0">
							<li class="nav-item">
								<div class="list-inline-item user-chat-nav btn-history">
									<div class="dropdown" data-bs-toggle="tooltip" title="ค้นหา">
										<button class="btn nav-btn section bg-white bg-soft shadow-sm hover-up" type="submit" aria-haspopup="true" aria-expanded="false">
											<i class="bx bx-search-alt"></i>
										</button>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-12">
				<div class="content-loading m-5" style="display: none !important">
					<br><br>
					<div class="lds-facebook mb-6">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>

				<div class="maintenance-img content-image p-3">
					<img src="{{ asset('assets/images/undraw/undraw_transfer_money.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
				</div>
				<div class="content-history"></div>
			</div>
		</div>
	</div>
</div>

<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<script>
	$('.btn-history').click(function() {
		var fdate = $('#start').val();
		var tdate = $('#end').val();
		var typeloan = $('#typeloan').val();

		$('.content-history').empty();
		$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
		$('.content-image,.content-history').slideUp();

		$.ajax({
			url: "{{ route('treas.create') }}",
			type: 'get',
			data: {
				page: 'show-transfer',
				fdate: fdate,
				tdate: tdate,
				typeloan: typeloan,
				_token: "{{ @csrf_token() }}",
			},
			success: function(result) {
				$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
				$('.content-history').html(result.html);
				$('.content-history').slideDown();
			}
		});
	});
</script>
