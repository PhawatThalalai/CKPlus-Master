{{-- @include('components.content-modal.modal-search') --}}

<div class="row mb-1 search-box-top">
	<div class="col-12">
		<form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
			<div class="search-box me-2">
				<div class="position-relative">
					<input type="text" class="form-control border-0 shadow-sm input-search" placeholder="Search...">
					<span class="btn_search">
						<i class="bx bx-search-alt search-icon hover-up" style="cursor: pointer"></i>
					</span>
				</div>
			</div>
			<li class="list-inline-item user-chat-nav">
				<div class="btn-group">
					<div class="dropdown" data-bs-toggle="tooltip" title="เลือก">
						<button class="btn btn-light position-relative p-0 avatar-xs rounded-circle shadow-sm section bg-white bg-soft hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="avatar-title bg-transparent text-reset">
								<i class="bx bx-menu"></i>
							</span>
							<span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-success p-1"></span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item type-search typ-namecus {{ empty(@$dataSreach['namecus']) ? 'd-none' : '' }}" id="1" value="namecus">ชื่อ-สกุล</a>
							<a class="dropdown-item type-search typ-idcardcus {{ empty(@$dataSreach['idcardcus']) ? 'd-none' : '' }}" id="2" value="idcardcus">เลขบัตรประชาชน</a>
							<a class="dropdown-item type-search typ-license {{ empty(@$dataSreach['license']) ? 'd-none' : '' }}" id="4" value="license">เลขป้ายทะเบียน</a>
							<a class="dropdown-item type-search typ-contract {{ empty(@$dataSreach['contract']) ? 'd-none' : '' }}" id="3" value="contract">เลขที่สัญญา</a>
							<a class="dropdown-item type-search typ-phone {{ empty(@$dataSreach['phone']) ? 'd-none' : '' }}" id="5" value="phone">เบอร์โทรศัพท์</a>
						</div>

						<input type="hidden" class="page-typeSr" value="{{ @$typeSreach }}">
					</div>
				</div>
			</li>
		</form>
	</div>
</div>

<script>
	$(".btn_search").click(function() {
		var search = $('.input-search').val();
		var typeSr = $('.page-typeSr').val();
		var page_type = $('.page_type').val();
		var page = $('.page').val();
        var flagTab = $('.flagTab').val();
		var pageUrl = $('.pageUrl').val();
		var _token = $('input[name="_token"]').val();
		var page_tmp = $('.page_tmp').val();
        // alert(flag)
		if (search != '') {
			$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			$('.content-image,.content-search').slideUp();

			$.ajax({
				url: "{{ route('search') }}",
				method: "post",
				data: {
					search: search,
					typeSr: typeSr,
					page: page,
					pageUrl: pageUrl,
					page_type: page_type,
                    flagTab:flagTab,
					page_tmp:page_tmp,
					_token: _token
				},
				success: function(result) {
					$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('.content-search').html(result);
					$('.content-search').slideDown();
				}
			})
		}
	});

	$('.type-search').click(function() {
		var typeSr = $(this).attr('value');
		typeSr_Select(typeSr);

		$('.page-typeSr').val(typeSr);
	});

	function typeSr_Select(type) {
		if (type == 'namecus') {
			$('#1').addClass('active');
			$('#2,#3,#4,#5').removeClass('active');

			$(".input-search").val('');
			$(".input-search").attr("placeholder", "ชื่อ-นามสกุล").inputmask("remove");
		} else if (type == 'idcardcus') {
			$('#2').addClass('active');
			$('#1,#3,#4,#5').removeClass('active');

			$(".input-search").val('');
			$(".input-search").attr("placeholder", "เลขบัตรประชาชน").inputmask("9-9999-99999-99-9");
		} else if (type == 'contract') {
			$('#3').addClass('active');
			$('#1,#2,#4,#5').removeClass('active');

			$(".input-search").val('');
			$(".input-search").attr("placeholder", "เลขที่สัญญา").inputmask("remove");
		} else if (type == 'license') {
			$('#4').addClass('active');
			$('#1,#2,#3,#5').removeClass('active');

			$(".input-search").val('');
			$(".input-search").attr("placeholder", "เลขป้ายทะเบียน").inputmask("remove");
		} else if (type == 'phone') {
			$('#5').addClass('active');
			$('#1,#2,#3,#4').removeClass('active');

			$(".input-search").val('');
			$(".input-search").attr("placeholder", "เบอร์โทรศัพท์").inputmask("999-9999999");
		}

		return type;
	}
</script>
