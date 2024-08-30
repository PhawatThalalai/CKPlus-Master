<div class="modal fade bs-example-modal-xl data-modal-search" id="data-modal-search" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="d-flex m-3 mb-0">
				<div class="flex-shrink-0 me-2">
					<img src="{{ asset('assets/images/gif/video-confer.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h5 class="text-primary fw-semibold">ค้นหาลูกค้า / เลขที่สัญญา</h5>
					<p class="text-muted mt-n1 fw-semibold font-size-12">( Search Data informations )</p>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" id="closeSerach" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body mt-2">
				{{-- <div class="row ">
                    <div class="col-6">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated testProgress" role="progressbar" aria-label="Example with label" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
						</div>
                    </div>
                </div> --}}
				@component('components.content-search.search')
					@slot('page_type')
						{{ @$page_type }}
					@endslot
					@slot('page')
						{{ @$page }}
					@endslot
					@slot('pageUrl')
						{{ @$pageUrl }}
					@endslot
					@slot('typeSreach')
						{{ @$typeSreach }}
					@endslot
					@slot('dataSreach', @$dataSreach)
				@endcomponent

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

						<div class="maintenance-img content-image">
							<img src="{{ asset('assets/images/undraw/search-people.png') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
						</div>
						<div class="content-search"></div>
					</div>
				</div>

				<input type="hidden" class="page_type" value="{{ @$page_type }}">
				<input type="text" hidden class="page" value="{{ @$page }}">
				<input type="hidden" class="pageUrl" value="{{ @$pageUrl }}">
				<input type="hidden" class="page_tmp" value="">
			</div>
		</div>
	</div>
</div>

@pushOnce('scripts')
	<!-- กด Enter เพื่อค้นหา -->
	<script>
		function EnterToSubmit(inputTagClass, submitBtnClass) {
			// Get the input field using class
			var _input = document.querySelector('.' + inputTagClass);
			// Function to handle the key press event
			function handleKeyPress(event) {
				// If the user presses the "Enter" key on the keyboard
				if (event.key === "Enter") {
					// Check if the input field is focused
					if (document.activeElement === _input) {
						// Cancel the default action, if needed
						event.preventDefault();
						// Trigger the button element with a click
						$("." + submitBtnClass).click();
					}
				}
			}
			// Remove any existing key press event listener
			_input.removeEventListener("keypress", handleKeyPress);
			// Add a new key press event listener
			_input.addEventListener("keypress", handleKeyPress);
		}
	</script>

	<script>
		EnterToSubmit('input-search', 'btn_search');
		EnterToSubmit('header_inputSearch', 'header_btnSearch');
	</script>

	<script>
		$(document).ready(function() {
			let typeSr = $('.header-typeSr').val();
			typeSelect(typeSr);
		})

		$('.type-Select').click(function() {
			var typeSr = $(this).attr('value');
			typeSelect(typeSr);

			$('.header-typeSr').val(typeSr);
		});

		$(".header_btnSearch,.header_btnSearch_Mobile").click(function() {
			var search = $('.header_inputSearch').val();
			var typeSr = $('.header-typeSr').val();
			var page_type = $('.page_type').val();
			var page = $('.page').val();
			var pageUrl = $('.pageUrl').val();
			var _token = $('input[name="_token"]').val();
			var flagTab = '';
			$('.page_tmp').val('');

			getDataCus(search, typeSr, page, pageUrl, page_type, _token, flagTab)
		});

		$(".header_btnSearch2").click(function() {
			$('.page_tmp').val('ask_terminate');
			var search = $('.header_inputSearch').val();
			var typeSr = $('.header-typeSr').val();
			var page_type = $('.page_type').val();
			var page = $('.page').val();
			var pageUrl = $('.pageUrl').val();
			var _token = $('input[name="_token"]').val();
			var flagTab = '';

			getDataCus(search, typeSr, page, pageUrl, page_type, _token, flagTab)
		});

		function typeSelect(type) {
			if (type == 'namecus') {
				$('.typ-namecus').addClass('active');
				$('.typ-idcardcus,.typ-license,.typ-contract,.typ-phone').removeClass('active');

				$(".header_inputSearch").inputmask("remove");
				$(".header_inputSearch").val('');
				$(".header_inputSearch").attr("placeholder", "ชื่อ-นามสกุล").inputmask("remove");
			} else if (type == 'idcardcus') {
				$('.typ-idcardcus').addClass('active');
				$('.typ-namecus,.typ-license,.typ-contract,.typ-phone').removeClass('active');

				$(".header_inputSearch").val('');
				$(".header_inputSearch").attr("placeholder", "เลขบัตรประชาชน").inputmask("9-9999-99999-99-9");
			} else if (type == 'contract') {
				$('.typ-contract').addClass('active');
				$('.typ-namecus,.typ-idcardcus,.typ-license,.typ-phone').removeClass('active');

				$(".header_inputSearch").val('');
				$(".header_inputSearch").attr("placeholder", "เลขที่สัญญา").inputmask("remove");
			} else if (type == 'license') {
				$('.typ-license').addClass('active');
				$('.typ-namecus,.typ-idcardcus,.typ-contract,.typ-phone').removeClass('active');

				$(".header_inputSearch").val('');
				$(".header_inputSearch").attr("placeholder", "เลขป้ายทะเบียน").inputmask("remove");
			} else if (type == 'phone') {
				$('.typ-phone').addClass('active');
				$('.typ-namecus,.typ-license,.typ-contract,.typ-idcardcus').removeClass('active');

				$(".header_inputSearch").val('');
				$(".header_inputSearch").attr("placeholder", "เบอร์โทรศัพท์").inputmask("999-9999999");
			}

			return type;
		}


		getDataCus = (search, typeSr, page, pageUrl, page_type, _token, flagTab, dataFlag) => {
			// let flag = $('.flag').val();
			let page_tmp = $('.page_tmp').val()
			let arrpage_tmp = ['search-seized', 'search-baddebt', 'search-recontract', 'search-inv']
			$('.content-search').empty();
			if (search != '' || pageUrl == 'add-Guaran' || pageUrl == 'add-Payee' || pageUrl == 'add-Broker' || page_tmp == 'search-seized' || page_tmp == 'search-baddebt' || page_tmp == 'search-recontract' || page_tmp == 'search-inv') {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$('.content-image').hide();

				$.ajax({
					url: "{{ route('search') }}",
					method: "post",
					data: {
						search: search,
						typeSr: typeSr,
						page: page,
						pageUrl: pageUrl,
						page_type: page_type,
						flagTab: flagTab,
						dataFlag: dataFlag,
						page_tmp: page_tmp,
						_token: _token,

					},
					success: function(result) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						$('.input-search').val(search);
						$('.page-typeSr').val(typeSr);

						$('.data-modal-search').modal('show');
						$('.data-modal-search .modal-dialog .content-search').html(result);
					}
				})
			} else {
				$('.data-modal-search').modal('show');
				$('.content-image').show();
				$('.input-search').val('');
				$(".input-search").attr("placeholder", "Search...").inputmask("remove");

				$('#1').addClass('active');
				$('#2,#3,#4,#5').removeClass('active');
				$('.page-typeSr').val(typeSr);
				$('.pageUrl').val(pageUrl)
			}
		}
	</script>
@endPushOnce
