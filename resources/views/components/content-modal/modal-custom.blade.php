{{-- start page --}}
<div class="modal fade" id="{{@$data['id']}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="some-modal" aria-hidden="true">
    <div class="modal-dialog {{@$data['class']}}">
        {{-- contens page --}}
    </div>
</div>
{{-- end page --}}
 
@push('scripts')
<script>
    $(document).on('click', '.{{@$data["btn_class"]}}', function(e) {
		$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
		e.preventDefault();
        $('#{{@$data["id"]}} .modal-dialog').empty();
		var url = $(this).attr('data-link');
		$('#{{@$data["id"]}} .modal-dialog').load(url, function(response, status, xhr) {
			if (status === 'success') {
				$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
				$('#{{@$data["id"]}}').modal('show');
			} else {
				$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
				console.log('Load failed');
			}
		});
	});
    $(document).on('click', '.bckTo_{{@$data["btn_class"]}}', function(e) {
		e.preventDefault();
		$('#{{@$data["id"]}}').modal('show');
	});
</script>
@endPush
