<style>
	/* width */
	::-webkit-scrollbar {
	width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	/* box-shadow: inset 0 0 5px grey;  */
	border-radius: 10px;
	}
	
	/* Handle */
	::-webkit-scrollbar-thumb {
	/* background: red;  */
	border-radius: 10px;
	}
	/* Add background color on hover for the table row */
	tr:hover {
		background-color: #f5f5f5;
	}
</style>

<div class="card">
	<input type="hidden" id="ConSelected" name="ConSelected[]">
	<input type="hidden" id="IdSelected" name="IdSelected[]">
	<div class="row p-3 mt-n2">
		<div class="col-lg-6">
			<!-- <br> -->
			<div class="font-size-11 border" data-simplebar="init" style="max-height: 440px; min-height : 440px;">
				<table class="table table-bordered table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%" id="dataTable">
					<thead class="table-info sticky-top">
						<tr class="text-left">
							<th>สาขา</th>
							<th>วันออกจดหมาย</th>
							<th>เลขที่สัญญา</th>
							<th class="d-none">id_kang</th>
							<th>ค้างงวด</th>
							<th>จำนวนเงินค้าง</th>
							<!-- <th>ค้างค่าปรับ</th> -->
							<th>กลุ่มค้าง</th>
							<th class="text-center">#</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $row)
						<tr id="{{@$row->id}}" class="text-left" style="cursor:pointer;">
							<td>{{@$row->LOCAT}}</td>
							<td>{{date('d/m/Y')}}</td>
							<td>{{@$row->CONTNO}}</td>
							<td class="d-none">{{@$row->id}}</td>
							<td>{{@$row->EXP_PRD}}</td>
							<td>{{number_format(@$row->EXP_AMT,2)}}</td>
							<!-- <td>{{@$row->KINTAMT}}</td> -->
							<td>{{@$row->FORCODE}}</td>
							<td class="text-center">
								<!-- <input type="checkbox"> -->
								 @if(@$row->FLAG != 'Y')
									<div class="form-check font-size-16 d-flex justify-content-center">
										<input class="form-check-input check-input" type="checkbox" id="transactionCheck01">
										<label class="form-check-label" for="transactionCheck01"></label>
									</div>
								@else 
									<i class="mdi mdi-calendar-check-outline mdi-18px text-success"></i>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<p class="text-end">
				<span>จำนวนรายการ : </span><span id="dataTableCount" class="me-2">{{count(@$data)}}</span>
			</p>
		</div>
		<div class="col-lg-1">
			<div class="button-container text-center">
				<button type="button" id="btn_printlet" class="btn btn-success waves-effect w-sm font-size-12 mt-1 mb-1" disabled>
					<span class="addSpin"></span> บันทึก
				</button>
				<button type="button" id="btn_printform" class="btn btn-success waves-effect w-sm font-size-12 mt-1 mb-1 d-none">
					พิมพ์ฟอร์ม
				</button>
				<button type="button" class="btn btn-soft-dark w-sm font-size-11 mb-1 btnControl" onclick="moveAllRows()">
					เลือกทั้งหมด
				</button>
				<button type="button" class="btn btn-soft-dark w-sm font-size-11 mb-1 btnControl" onclick="moveSelectedRows()">
					เลือก <i class="bx bx-skip-next align-middle"></i>
				</button>
				<button type="button" class="btn btn-soft-dark w-sm font-size-11 mb-1 btnControl" onclick="removeSelectedRows(true)">
					<i class="bx bx bx-skip-previous align-middle"></i> ยกเลิก
				</button>
				<button type="button" class="btn btn-soft-dark w-sm font-size-11 mb-1 btnControl" onclick="removeAllRows()">
					ยกเลิกทั้งหมด
				</button>
			</div>
		</div>
		<div class="col-lg-5">
			<br>
			<br>
			<div class="font-size-11 border" data-simplebar="init" style="max-height: 400px; min-height : 400px;">
				<table class="table table-bordered table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%" id="selectedTable">
					<thead class="table-info sticky-top">
						<tr class="text-left">
							<th>สาขา</th>
							<th>วันออกจดหมาย</th>
							<th>เลขที่สัญญา</th>
							<th class="d-none">id_kang</th>
							<th>ค้างงวด</th>
							<th>จำนวนเงินค้าง</th>
							<!-- <th>ค้างค่าปรับ</th> -->
							<th>กลุ่มค้าง</th>
							<th class="text-center">#</th>
						</tr>
					</thead>
					<tbody>
						<!-- Selected rows will be displayed here -->
					</tbody>
				</table>
			</div>
			<p class="text-end">
				<span>เลือกรายการ : </span><span id="selectedTableCount" class="me-2">0</span>
			</p>
		</div>
	</div>
</div>

<script>
    // --------- button-to-top --------------
    var btn = $('#button');
    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
        btn.addClass('show');
        } else {
        btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });

    // -------- DataTable ------------
    $("#dataTable").DataTable({
        // dom: 'Bfrtip',
        // buttons: [
        // 'pageLength',
        // {
        //     extend: 'excelHtml5',
        //     title: 'รายการชื่องานโทร',
        //     messageTop: 'ข้อมูลเดือน {{date('m')}}'
        // },
        // ],
        // lengthMenu: [
        //     [ 7, 10, 25, 50, -1 ],
        //     ['7 rows', '10 rows', '25 rows', '50 rows', 'Show all' ]
        // ],
        "searching": true,
        "responsive": true,
        "autoWidth": false,
        "ordering": true,
        "order": [[ 0, "asc" ]],
        "pageLength": -1,
    });
</script>

{{-- auto selected on click  --}}
<!-- <script>
	$(function() {
		const allRows = document.querySelectorAll('#dataTable tbody tr');
		const selectedTableBody = document.getElementById('selectedTable').querySelector('tbody');
		allRows.forEach(row => {
			row.addEventListener('click', function () {
				const clonedRow = row.cloneNode(true);
				document.getElementById('selectedTable').querySelector('tbody').appendChild(clonedRow);
				row.remove();

				const remainingRowsCount = document.querySelectorAll('#dataTable tbody tr').length;
				const selectedRowsCount = selectedTableBody.children.length;

				$('#btn_printlet').removeClass('d-none');
				$('#btn_printform').addClass('d-none');
				$('#btn_printlet').removeAttr('disabled', true);
				$('#dataTableCount').text(remainingRowsCount);
				$('#selectedTableCount').text(selectedRowsCount);
			});
		});
	})
</script> -->

<script>
	function moveSelectedRows() {
		const sourceTable = document.getElementById('dataTable');
		const targetTable = document.getElementById('selectedTable');
		const checkboxes = sourceTable.querySelectorAll('tbody input[type="checkbox"]:checked');
		
		checkboxes.forEach(checkbox => {
			const row = checkbox.closest('tr').cloneNode(true);
			targetTable.querySelector('tbody').appendChild(row);
			checkbox.closest('tr').remove();

			const RowsCount = document.querySelectorAll('#dataTable tbody tr').length;
			const selectedTableBody = document.getElementById('selectedTable').querySelector('tbody');
			const remaining = selectedTableBody.children.length;
			$('#dataTableCount').text(RowsCount);
			$('#selectedTableCount').text(remaining);
		});
		$('#btn_printlet').removeClass('d-none');
		$('#btn_printlet').removeAttr('disabled', true);
	}

	function removeSelectedRows() {
		const sourceTable = document.getElementById('selectedTable');
		const targetTable = document.getElementById('dataTable');
		const checkboxes = sourceTable.querySelectorAll('tbody input[type="checkbox"]:checked');
		
		checkboxes.forEach(checkbox => {
			const row = checkbox.closest('tr').cloneNode(true);
			targetTable.querySelector('tbody').appendChild(row);
			checkbox.closest('tr').remove();

			const RowsCount = document.querySelectorAll('#dataTable tbody tr').length;
			const selectedTableBody = document.getElementById('selectedTable').querySelector('tbody');
			const remaining = selectedTableBody.children.length;
			$('#dataTableCount').text(RowsCount);
			$('#selectedTableCount').text(remaining);
			if(remaining == 0){
				$('#btn_printlet').prop('disabled', true);
				$('#btn_printlet').addClass('d-none');
			}
		});

	}

	function moveAllRows(isReverse = false) {
		const sourceTable = isReverse ? document.getElementById('selectedTable') : document.getElementById('dataTable');
		const targetTable = isReverse ? document.getElementById('dataTable') : document.getElementById('selectedTable');
		const rows = sourceTable.querySelectorAll('tbody tr');

		rows.forEach(row => {
			const clonedRow = row.cloneNode(true);
			targetTable.querySelector('tbody').appendChild(clonedRow);

			const selectedTableBody = document.getElementById('selectedTable').querySelector('tbody');
			const remaining = selectedTableBody.children.length;
			$('#dataTableCount').text(0);
			$('#selectedTableCount').text(remaining);
		});
		sourceTable.querySelector('tbody').innerHTML = '';
		$('#btn_printlet').removeClass('d-none');
		$('#btn_printlet').removeAttr('disabled', true);
	}

	function removeAllRows() {
		const sourceTable = document.getElementById('selectedTable');
		const targetTable = document.getElementById('dataTable');
		const rows = sourceTable.querySelectorAll('tbody tr');

		rows.forEach(row => {
			const clonedRow = row.cloneNode(true);
			targetTable.querySelector('tbody').appendChild(clonedRow);

			const RowsCount = document.querySelectorAll('#dataTable tbody tr').length;
			$('#dataTableCount').text(RowsCount);
			$('#selectedTableCount').text(0);
		});
		sourceTable.querySelector('tbody').innerHTML = '';
		$('#btn_printlet').prop('disabled', true);
		$('#ConSelected').val('');
	}
</script>

<script>
	$(function() {
		$("#btn_printlet").on('click', function() {
			const selectedTable = document.getElementById('selectedTable');
			const rows = selectedTable.querySelectorAll('tbody tr');
			var contno = '';
			var getid = '';
			rows.forEach(row => {
				const cells = row.querySelectorAll('td');
				const columnValue = cells[2].textContent || cells[2].innerText;
				contno += columnValue + ',';

				const columnValue2 = cells[3].textContent || cells[3].innerText;
				getid += columnValue2 + ',';
			});
			$('#ConSelected').val(contno);
			$('#IdSelected').val(getid);

			var getContno = $('#ConSelected').val();
			var getGcode = $('#GCODE').val();
			// var getLocat = $('#LOCAT').val();
			var getLocat = $('#ID_LOCAT').val();
			var getForm = $('#form-selcted').val();
			// console.log(getContno);
			$('.addSpin').empty();
			$('<span/>', {
					class: "spinner-border spinner-border-sm",
					role: "status"
			}).appendTo(".addSpin");
			$('#btn_printlet').prop('disabled', true);

			$.ajax({
				url: "{{ route('letter.store') }}",
				method: 'POST',
				data:{
					_token : '{{ @csrf_token() }}',
					page:'print-letter',
					getContno:getContno,
					getGcode:getGcode,
					getLocat:getLocat,
					getid:getid,
					getForm:getForm,
				},
				success: function(result) {
					$('#btn_printlet').addClass('d-none');
					$('.addSpin').addClass('d-none');
					$('#btn_printform').removeClass('d-none');
					$('.btnControl,.check-input').prop('disabled', true);
					swal.fire({
						icon : 'success',
						text : 'บันทึกข้อมูลสำเร็จ',
						timer: 3500,
						// dangerMode: true,
					})
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				}
			});
		});
	})
</script>

<script>
	$("#btn_printform").click(function(){
		let getForm = $('#form-selcted').val();
		let getCode = $("#GCODE").val();
		let getStart = $("#START").val();
		let getEnd = $("#END").val();
		var getContno = $('#ConSelected').val();
		let url = "{{route('letter.show', 0)}}?page={{'print-form'}}&form={{':getForm'}}&gcode={{':gcode'}}&start={{':start'}}&end={{':end'}}&contno={{':contno'}}";
			url = url.replace(':getForm', getForm);
			url = url.replace(':gcode', getCode);
			url = url.replace(':start', getStart);
			url = url.replace(':end', getEnd);
			url = url.replace(':contno', getContno);
		window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
		  
	});
</script>