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

	.scroll-slide {
		cursor: pointer;
		overflow-y: auto;
		overflow-x: hidden;
		height: auto;
		white-space: nowrap;
		scroll-snap-type: x mandatory;
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

	.selected-card {
		background-color: #FADCDC;
	}
</style>

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/mail-send.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">{{@$title}}</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">user. : {{ auth()->user()->name }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="card p-2 bg-light">
				<div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll-slide">
					<div class="d-flex pt-2">
						@foreach ($Branchs as $Branch)
							@component('components.content-card.card-branch-v2')
								@slot('data', [
									'index' => $loop->iteration,
									'NickName_Branch' => $Branch->NickName_Branch,
									'Name_Branch' => $Branch->Name_Branch,
									'countData' => @$countData[$Branch->id],
									'id_branch' => $Branch->id,
									])
								@endcomponent
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="content-loading mt-5 mb-5" style="display: none !important">
					<div class="lds-facebook h-loading">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>

				<input type="hidden" id="redirectUrl" value="{{ @$redirectUrl }}">
				<div class="col-12" id="content-BranchReceive"></div>
			</div>
		</div>

		<script>
			var ajaxInProgress = false;
			$('.card-branch').click(function(event) {
				if (ajaxInProgress) {
					event.preventDefault();
					event.stopPropagation();
					return;
				}

				let branch = $(this).attr('card-id');
				let redirectUrl = $('#redirectUrl').val();

				$('.card-branch').removeClass('selected-card');
				$(this).addClass('selected-card');

				$('#content-BranchReceive').slideUp('slow');
				$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

				ajaxInProgress = true; // เริ่มต้น AJAX

				$.ajax({
					url: "{{ route('audit.create') }}",
					type: 'get',
					data: {
						page: redirectUrl,
						branch: branch,
						_token: "{{ @csrf_token() }}",
					},
					success: (response) => {
						console.log(response);
						$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						$('#content-BranchReceive').html(response.html).slideDown('slow');
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
						ajaxInProgress = false; // เมื่อ AJAX สำเร็จหรือล้มเหลว, ตั้งค่าให้เป็นเท็จ
					}
				});
			});
		</script>

		<script>
			document.querySelector('.scroll-slide').addEventListener('wheel', (e) => {
				e.preventDefault();
				const delta = e.deltaY || e.detail || e.wheelDelta;
				document.querySelector('.scroll-slide').scrollLeft += delta;
			});
		</script>
