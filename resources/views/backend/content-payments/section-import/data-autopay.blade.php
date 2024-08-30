<link href="{{ asset('assets/css/dual-listbox.css') }}" rel="stylesheet">

{{-- <div class="clearfix mt-4 mt-lg-0">
	<div class="dropdown float-end">
		<button class="btn btn-primary" type="button" id="btn_selected">
			<i class="bx bxs-cog align-middle me-1"></i> รับชำระ
		</button>
	</div>
</div> --}}
<div class="row">
	<div class="col-12">
		<div class="dual-listbox-container">
			<select id="box2View" class="select1" multiple>
				@foreach ($data as $item)
					<option value="{{ $item->DETAIL_ID }}">{{ $item->contno }} | วันที่ : {{ date('d-m-Y', strtotime($item->PAYDATE)) }} | ยอด : {{ number_format(@$item->PAYAMOUNT, 2) }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
{{-- <div class="row justify-content-center">
	<div class="col-5">
		<div class="text-center">
			<p>รวม : <span id="availableCount">0</span> รายการ</p>
		</div>
	</div>
	<div class="col-5">
		<div class="text-center">
			<p>รวม : <span id="selectedCount">0</span> รายการ</p>
		</div>
	</div>
<div> --}}

<script src="{{ asset('assets/js/pages/dual-listbox.js') }}"></script>
<script>
	$(document).ready(function() {
		var dualListbox = new DualListbox('.select1', {
			addEvent: function(value) {
				console.log(value);
				updateCounts();
			},
			removeEvent: function(value) {
				console.log(value);
				updateCounts();
			},
			availableTitle: 'สัญญาที่ชำระได้',
			selectedTitle: 'สัญญาที่ต้องการชำระ',
			addButtonText: 'เลือก',
			removeButtonText: 'ยกเลิก',
			addAllButtonText: 'เลือกทั้งหมด',
			removeAllButtonText: 'ยกเลิกทั้งหมด',
		});
		updateCounts();

		dualListbox.addEventListener("added", function(event) {
			updateCounts();
		});
		dualListbox.addEventListener("removed", function(event) {
			updateCounts();
		});
		dualListbox.addEventListener("SelectAllEvent", function(event) {
			if (dualListbox.options.length != 0) {
				$('#btn_selected').fadeIn().removeClass('d-none');
			}
		});
		dualListbox.addEventListener("RemoveAllEvent", function(event) {
			$('#btn_selected').fadeOut().addClass('d-none');
		});

		$('#btn_selected').click(function() {
			updateCounts(); // Update counts when the button is clicked
			var selectedDataIds = [];

			// Ensure dualListbox is properly initialized
			if (dualListbox && dualListbox.selectedList) {
				var selectedItems = $(dualListbox.selectedList).find('.dual-listbox__item');
				selectedItems.each(function() {
					var dataId = $(this).data('id');
					selectedDataIds.push(dataId);
				});

				console.log(selectedDataIds);
			}
		});

		// function updateCounts() {
		// 	// อัปเดตจำนวนของรายการที่สามารถให้เลือก
		// 	var availableItems = $(dualListbox.availableList).find('.dual-listbox__item');
		// 	var availableCount = availableItems.length;
		// 	$('#availableCount').text(availableCount);

		// 	// อัปเดตจำนวนของรายการที่ถูกเลือก
		// 	var selectedItems = $(dualListbox.selectedList).find('.dual-listbox__item');
		// 	var selectedCount = selectedItems.length;
		// 	$('#selectedCount').text(selectedCount);

		// 	// เปลี่ยนการแสดงผลของปุ่ม 'btn_selected'
		// 	if (selectedCount !== 0) {
		// 		$('#btn_selected').removeClass('d-none');
		// 	} else {
		// 		$('#btn_selected').addClass('d-none');
		// 	}
		// }


		function updateCounts() {
			if (dualListbox && dualListbox.availableList) {
				var availableItems = $(dualListbox.availableList).find('.dual-listbox__item');

				if (availableItems && availableItems.length !== undefined) {
					var availableCount = availableItems.length;
					$('#CountavailableList').html("Count Available : " + availableCount + " item");
				}
			}

			if (dualListbox && dualListbox.selectedList) {
				var selectedItems = $(dualListbox.selectedList).find('.dual-listbox__item');

				if (selectedItems && selectedItems.length !== undefined) {
					var selectedCount = selectedItems.length;
					$('#CountselectedList').html("Count Selected : " + selectedCount + " item");

					if (selectedCount != 0) {
						$('#btn_selected').fadeIn().removeClass('d-none');
					} else {
						$('#btn_selected').fadeOut().addClass('d-none');
					}
				}
			}
		}
	});
</script>

{{-- <script>
	var dualListbox = new DualListbox('.select1', {
			addEvent: function(value) {
				console.log(value);
			},
			removeEvent: function(value) {
				console.log(value);
			},
			availableTitle: 'สัญญาที่ชำระได้',
			selectedTitle: 'สัญญาที่ต้องการชำระ',
			addButtonText: 'เลือก',
			removeButtonText: 'ยกเลิก',
			addAllButtonText: 'เลือกทั้งหมด',
			removeAllButtonText: 'ยกเลิกทั้งหมด'
		});

		dualListbox.addEventListener("added", function(event) {
			console.log(event);
			console.log(event.addedElement);
		});
		dualListbox.addEventListener("removed", function(event) {
			console.log(event);
			console.log(event.removedElement);
		});

		$('#btn_selected').click(function() {
			var selectedDataIds = [];
			var selectedItems = $(dualListbox.selectedList).find('.dual-listbox__item');
			selectedItems.each(function() {
				var dataId = $(this).data('id');
				selectedDataIds.push(dataId);
			});
		});
</script> --}}

{{-- <script>
	$('#btn_searchData').click(function() {
		$(".loading-overlay").fadeIn().attr('style', '');

		let typestatusPay = $('#typestatusPay').val();
		let fdate = $('#start').val();
		let tdate = $('#end').val();

		$.ajax({
			url: "{{ route('view-backend.store') }}",
			method: "POST",
			data: {
				typestatusPay: typestatusPay,
				fdate: fdate,
				tdate: tdate,
				page: 'imp-payslist',
				_token: "{{ @csrf_token() }}",
			},
			success: function(result) {
				$(".loading-overlay").fadeOut().attr('style', 'display:none !important');

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
			}
		})
	});
</script> --}}
