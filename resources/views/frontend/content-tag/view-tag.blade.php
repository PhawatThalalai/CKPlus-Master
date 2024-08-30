@isset($data)
	<div class="card mt-n1">
		<div class="card-header bg-transparent border-bottom fw-semibold d-inline mt-2">
			<span class="card-title fs-6 text-primary">
				<span class="d-block d-sm-none"><i class="fas fa-user-tag"></i> บันทึกติดตาม</span>
				<span class="d-none d-sm-block">
					<i class="fas fa-user-tag"></i> บันทึกติดตาม (Tracking Details)
				</span>
			</span>
			@can('create-tag')
				<span class="float-end mt-n4" data-bs-toggle="tooltip" title="สร้างติดตาม">
					<ul class="list-inline user-chat-nav text-end mb-0">
						<li class="list-inline-item d-sm-inline-block me-auto">
							<div class="dropdown">
								<button class="btn nav-btn hover-up btn-createTag data-modal-xl-2" type="button" data-link="{{ route('tags.create') }}?funs={{ 'create-tag' }}&id={{ @$id }}">
									{{-- <button class="btn nav-btn hover-up btn-createTag {{ !empty(@$filter_tag)? $filter_tag : 'data-modal-xl-2' }}" type="button" data-link="{{ route('tags.create') }}?funs={{ 'create-tag' }}&id={{ @$id }}"> --}}
									<i class="mdi mdi-plus-box-multiple-outline bx-xs"></i>
								</button>
							</div>
						</li>
					</ul>
				</span>
			@endcan
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="card-tag data_tag" id="data_tag">
						@include('frontend.content-tag.section-tag.data-tags')
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card d-none card-tagPart mt-n3">
		<div class="card-body">
			<div class="content-loading m-3" style="display: none !important">
				<br><br>
				<div class="lds-facebook mb-6">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
			<div class="data-tagPart">
				{{-- @include('frontend.content-tag.section-tagPart.data-tagParts') --}}
			</div>
		</div>
	</div>

	<script>
		// $('.btn_tagdisabled').on('click', function() {
			// Swal.fire({
			// 	icon: 'error',
			// 	title: 'ไม่สามารถดำเนินการได้',
			// 	text: 'มีรายการติดตาม หรือสัญญาที่อยู่ในสถานะรอดำเนินการแล้ว กรุณาตรวจสอบอีกครั้ง',
			// 	confirmButtonText: 'ตกลง',
			// 	confirmButtonColor: '#0d6efd',
			// })
		// })
	</script>
@endisset
