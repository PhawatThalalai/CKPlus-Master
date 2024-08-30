<style>
	.card-wrapper {
		background: #f5f9fa;
		color: #5c5a5a;
		padding: 0.85em 0.75em;
		margin: 1rem;
		position: relative;
		z-index: 1;
		overflow: hidden;
	}

	.card-wrapper:hover {
		color: #3498db;
	}

	.card-wrapper::after {
		content: "";
		background: #ffffff;
		position: absolute;
		z-index: -1;
		padding: 0.85em 0.75em;
		display: block;
	}

	.slide_from_bottom::after {
		transition: all 0.35s;
	}

	.slide_from_bottom:hover::after {
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		transition: all 0.35s;
	}

	.slide_from_bottom::after {
		left: 0;
		right: 0;
		top: 100%;
		bottom: -100%;
	}
</style>

<style>
	.ribbon-2 {
		--f: 10px;
		/* control the folded part*/
		--r: 15px;
		/* control the ribbon shape */
		--t: 10px;
		/* the top offset */
		position: absolute;
		inset: var(--t) calc(-1*var(--f)) auto auto;
		padding: 0 10px var(--f) calc(10px + var(--r));
		clip-path:
			polygon(0 0, 100% 0, 100% calc(100% - var(--f)), calc(100% - var(--f)) 100%,
				calc(100% - var(--f)) calc(100% - var(--f)), 0 calc(100% - var(--f)),
				var(--r) calc(50% - var(--f)/2));
		background: #f54462;
		box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
	}
</style>

<style>
	.highlight-text-style {
		color: rgb(12, 180, 12);
		text-decoration: underline;
	}

	.highlight-text-alert {
		color: rgb(235, 96, 4);
		text-decoration: underline;
	}

	.text-title {
		font-size: 0.9rem;
	}

	.tag-popover {
		--bs-popover-max-width: 200px;
		--bs-popover-border-color: var(--bs-info);
		--bs-popover-header-bg: var(--bs-info);
		--bs-popover-header-color: var(--bs-white);
		--bs-popover-body-padding-x: 1rem;
		--bs-popover-body-padding-y: .5rem;
	}
</style>

<script src="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/timeline.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

@include('public-js.searchCredo')
@include('components.content-toast.view-toast')

<div class="hori-timeline" dir="ltr">
	<div class="owl-carousel owl-theme events navs-carousel timeline-carousel" id="timeline-carousel">
		@foreach ($data as $key => $item)
			@component('components.content-tags.card-tags')
				{{-- @slot('active')
                    {{ @$item->Status_Tag == 'active' ? $item->Status_Tag : '' }}
                @endslot --}}

				@slot('icon_state')
					@if (@$item->Status_Tag == 'complete')
						<i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
					@elseif(@$item->Status_Tag == 'inactive')
						<i class="bx bx-x-circle h1 text-danger down-arrow-icon"></i>
					@elseif(@$item->Status_Tag == 'active')
						<i class="bx bx bx-user-circle h1 text-primary down-arrow-icon"></i>
					@endif
				@endslot

				@slot('status_card')
					@if (@$item->Status_Tag == 'complete')
						ส่งจัดไฟแนนซ์
					@elseif(@$item->Status_Tag == 'inactive')
						ยกเลิกติดตาม
					@elseif(@$item->Status_Tag == 'active')
						ติดตาม
					@endif
				@endslot

				@slot('count_card')
					{{ count($data) - $key }}
				@endslot

				@slot('btn_cal')
					@if (empty($item->Credo_Score) and empty($item->Credo_Status))
						disabled
					@endif
				@endslot

				@slot('data', [
					'id' => @$item->id,
					'Status_Tag' => @$item->Status_Tag,
					'date_Tag' => @$item->date_Tag,
					'Code_Tag' => @$item->Code_Tag,

					'tagpart' => count(@$item->TagToTagPart),

					'PhoneNumber' => preg_match('/\d{10}/', @$item->TagToDataCus->Phone_cus, $matches) ? $matches[0] : null,
					'TypeCus' => @$item->TagToStatusCus->Name_Cus,
					'ReCus' => @$item->TagToTypeCusRe->Name_CusResource,

					'Contract_id' => @$item->TagToContracts->id,
					'Contract' => @$item->TagToContracts->Contract_Con,
					'ConBranch' => @$item->TagBranchCont->Name_Branch,
					'ConBranchNc' => @$item->TagBranchCont->NickName_Branch,

					'LoanCode' => @$item->TagToContracts->ContractToTypeLoan->Loan_Code,
					'LoanName' => @$item->TagToContracts->ContractToTypeLoan->Loan_Name,

					'UserSent' => @$item->TagToContracts->ContractToUserBranch->name,
					'UserPosition' => isset($item->TagToContracts) ? $item->TagToContracts->ContractToUserBranch->getRoleNames() : null,

					'CredoCode' => @$item->Credo_Code,
					'CredoScore' => @$item->Credo_Score,
					'CredoStat' => @$item->TagToCredo->Name_Credo,

					'successor' => @$item->successorID->name,
					'successorStatus' => @$item->successor_status,

					'successor_id' => @$item->successorID->id,

					'UserInsert' => @$item->TagUserID->name,
					'UserBranch' => @$item->TagToBranch->Name_Branch,
					'created_at' => @$item->created_at,
					])
				@endcomponent
			@endforeach
		</div>
	</div>

	<div class="modal fade form-SentGM" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="card-body p-4">
						<div class="text-center">
							<div class="avatar-md mx-auto mb-4 up-down">
								<div class="avatar-title bg-light rounded-circle text-primary h1">
									<i class="mdi mdi-account-switch"></i>
								</div>
							</div>

							<div class="row justify-content-center">
								<div class="col-xl-10">
									<h4 class="text-warning fw-semibold">ส่งมอบรายการ <span class="ms-1 sentGM-title"></span></h4>
									<p class="text-muted font-size-14 mb-4">หลังจากส่งมอบแล้ว สิทธิการเพิ่ม หรือ แก้ไขรายการ จะเป็นของผู้ใช้ดังกล่าวทันที.</p>
									<div class="input-group bg-light rounded">
										<select class="form-control form-select select2 user-select license-input border-danger" id="user_select" name="user_select" data-placeholder="รายชื่อ" aria-describedby="button-addon2" required>
											<option value="" selected>--- เลือกรายชื่อ ---</option>

										</select>
										<button class="btn btn-primary" type="button" id="btn_sentTags" disabled>
											<span class="addSpin"><i class="bx bxs-paper-plane"></i></span>
										</button>
									</div>
								</div>
							</div>
						</div>

						<input type="text" hidden id="tag_id">
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<script>
		$(document).ready(function() {
			$(function() {
				$(".input-mask").inputmask();
				$('[data-bs-toggle="tooltip"]').tooltip();
				$('[data-bs-toggle="popover"]').popover({
					html: true,
					trigger: 'hover'
				});
			});

			$('.card-event').click(function() {
				var id_cardEvent = $('#id_cardEvent').val();
				var funs = 'view-tagparts';

				if (id_cardEvent != $(this).data("id")) {
					let id = $(this).data("id");
					$('#id_cardEvent').val($(this).data("id"));

					$('.card-tagPart').removeClass('d-none');
					$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$('.data-tagPart').slideUp(500);

					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$.ajax({
						url: "{{ route('tags.index') }}",
						method: "GET",
						data: {
							funs: funs,
							id: id
						},
						success: function(result) {
							$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							$('.data-tagPart').slideDown(500).html(result);

							$('.event-list').removeClass('active');
							$('#active-' + id).addClass('active');

							// $('.data-tagPart').slideDown(500).html(result);

							$(".toast-success").toast({
								delay: 2000
							}).toast("show");
							$(".toast-success .toast-body .text-body").text('บันทึกสำเร็จ!');
						}
					})
				}
			});

			$('.btn-calculate').click(function() {
				let id = $(this).attr('id');

				if ($(this).attr("data-credoScore") != '') {
					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					var url = $(this).attr('data-link');

					$('#modal_xl_2 .modal-xl').load(url, function(response, status, xhr) {
						if (status === 'success') {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							$('#modal_xl_2').modal('show');
						} else {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							console.log('Load failed');
						}
					});
				} else {

					Swal.fire({
						icon: 'error',
						title: `error credo code !!!`,
						text: 'กรุณา active credo ก่อนคำนวณยอดจัด !',
						showConfirmButton: true,
					});
				}
			});

			$('.btn-sentGM').click(function(event) {
				event.preventDefault();
				ResetContainers();

				let id = $(this).attr('data-id');
				let tag = $(this).attr('data-tag');

				$('#user_select').empty();
				$('.sentGM-title').html(tag);
				$('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

				$.ajax({
					url: "{{ route('tags.create') }}",
					method: "GET",
					data: {
						funs: 'sent-GM',
						id: id
					},
					success: function(data) {
						if (data.users) {
							$('#user_select').append($('<option/>').attr("selected", "").val('').text("--- เลือกรายชื่อ ---"));

							data.users.forEach(function(userData) {
								var user = userData.user;
								var roles = userData.roles;
								$('#user_select').append($('<option/>').attr("value", user.id).text(user.name + " (" + roles.join(', ') + ")"));
							});

							$('#tag_id').val(data.tag['id']);
							$('#btn_sentTags').attr('disabled', false);

						} else {
							$('#user_select').append($('<option/>').attr("selected", "").val('').text("--- ไม่พบรายชื่อ ---"));
						}
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
					},
					complete: function() {
						$('.user-select').select2({
							theme: "bootstrap-5",
							language: "th",
							width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
							placeholder: $(this).data('placeholder'),
							allowClear: true,
							dropdownParent: $('.form-SentGM .modal-content'),
						});

						$('.addSpin').html('<i class="bx bxs-paper-plane"></i>');
					}
				});
			});

			$('#btn_sentTags').click(function(event) {
				event.preventDefault();
				let id = $('#tag_id').val();
				let user_select = $('#user_select').val();

				if (user_select == '') {
					Swal.fire({
						icon: 'error',
						title: `error user select !!!`,
						text: 'กรุณาเลือกรายชื่อผู้ใช้งานที่ต้องการส่งมอบ !',
						showConfirmButton: true,
					});
					return false;
				} else {
					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

					let url = "{{ route('tags.update', 'id') }}";
					url = url.replace('id', id);

					$.ajax({
						url: url,
						method: "PATCH",
						data: {
							_token: "{{ @csrf_token() }}",
							funs: 'update-sentGM',
							user_select: user_select
						},
						success: function(result) {
							$('.successor-' + result.tag_id).attr('style', '');
							$('#sentGM_' + result.tag_id).addClass('d-none');
							$('#sentBranch_' + result.tag_id).removeClass('d-none');

							$('.data-tagPart').html(result.html);
							$('#tagpart-' + result.tag_id).text(result.tagpart);

							Swal.fire({
								icon: 'success',
								text: result.message,
								showConfirmButton: false,
								timer: 1500
							});
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						},
						complete: function() {
							$('.addSpin').html('<i class="bx bxs-paper-plane"></i>');
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

							$('.form-SentGM').modal('hide');
						}
					});
				}
			});

			$('.btn-sentBranch').click(function(event) {
				event.preventDefault();

				let id = $(this).attr('data-id');
				let tag = $(this).attr('data-tag');
				let user = $(this).attr('data-user');
				console.log(user, user != "{{ auth()->user()->id }}", "{{ auth()->user()->id }}");
				if (user != "{{ auth()->user()->id }}") {
					Swal.fire({
						icon: 'error',
						title: `error user !!!`,
						text: 'ไม่สามารถส่งคืนสาขาได้ เนื่องจากคุณไม่ใช่ผู้ส่งมอบ !',
						showConfirmButton: true,
					});
					return false;
				}

				Swal.fire({
					icon: 'question',
					title: 'ส่งคืนสาขา',
					html: '<span class="text-title">ต้องการส่งคืน <span class="highlight-text-alert">' + tag + '</span> ให้สาขาหรือไม่ ?.</span>',

					showCancelButton: true,
					confirmButtonText: 'ตกลง',
					cancelButtonText: 'ยกเลิก',
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					preConfirm: async () => {
						Swal.showLoading();
						let link = "{{ route('tags.update', 'id') }}";
						let url = link.replace('id', id);

						try {
							let response = await $.ajax({
								url: url,
								method: 'PATCH',
								data: {
									_token: "{{ @csrf_token() }}",
									funs: 'update-sentBranch'
								},
							});

							$('.data_tag').html(response.html);
							$('#tagpart-' + id).text(response.tagpart);

							Swal.fire({
								icon: 'success',
								text: response.message,
								showConfirmButton: false,
								timer: 1500
							});
						} catch (err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						}
					},
					allowOutsideClick: () => !Swal.isLoading(),
					showLoaderOnConfirm: true,
					focusConfirm: false, // ปุ่มยกเลิกไม่สามารถคลิกได้ขณะที่กำลังทำงาน
				}).then((result) => {
					if (result.isConfirmed) {
						console.log('The user clicked "ตกลง"');
					}
				});

			});

			function ResetContainers() {
				$('#tag_id').val('');
				$('#btn_sentTags').attr('disabled', true);
			}
		});
	</script>
