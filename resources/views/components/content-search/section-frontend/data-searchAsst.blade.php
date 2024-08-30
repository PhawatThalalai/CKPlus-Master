<div class="modal fade modal-search-asst " tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="d-flex m-3 mb-0">
				<div class="flex-shrink-0 me-2">
					<img src="{{ asset('assets/images/gif/video-confer.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h5 class="text-primary fw-semibold">ค้นหาข้อมูลทรัพย์</h5>
					<p class="text-muted mt-n1 fw-semibold font-size-12">( Search Data informations )</p>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body mt-2">
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

						<div class="content-search"></div>
					</div>
				</div>

                <input type="hidden" class="page_type" value="{{ @$page_type }}">
			</div>
		</div>
	</div>
</div>










