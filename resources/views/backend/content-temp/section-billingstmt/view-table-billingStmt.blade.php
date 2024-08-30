<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<button id="selectAll" class="btn btn-outline-primary mb-3">เลือกทั้งหมด</button>
        	<button id="deselectAll" class="btn btn-outline-secondary mb-3">ยกเลิกการเลือก</button>
			<button id="printSelected" class="btn btn-soft-primary mb-3">
				<i class="bx bx-printer align-middle"></i> พิมพ์ที่เลือก
			</button>
			<table class="table display table-borderless table-striped table-hover text-center table-sm align-middle nowrap" id="table_billing_stmt">
				<thead class="table-light text-center">
					<tr>
						<th>
							<input type="checkbox" id="selectAllCheckbox">
						</th>
						<th scope="col" class="text-center">งวดที่</th>
						<th scope="col" class="text-center">สาขา</th>
						<th scope="col" class="text-center">วันที่ทำสัญญา</th>
						<th scope="col" class="text-center">เลขที่สัญญา</th>
						<th scope="col" class="text-center">เลขบัตรประชาชน</th>
						<th scope="col" class="text-center">ชื่อ-สกุลลูกค้า</th>
						<th scope="col" class="text-center">ค่างวด</th>
						<th scope="col" class="text-center">วันครบกำหนดชำระ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@if( count(@$data) > 0)
						@foreach( @$data as $key => $value)
							<tr class="pe-auto" data-invoiceid="{{$value->idInvoice}}">
								<td class="text-center">
									<input type="checkbox" class="rowCheckbox">
								</td>
								<td scope="row">{{@$value->NOPAY}}</td>
								<td>{{@$value->Name_Branch}}</td>
								<td>{{ formatDateThaiShort(@$value->SDATE) }}</td>
								<td>{{ @$value->CONTNO }}</td>
								<td>{{ textFormat(@$value->IDCard_cus,'','') }}</td>
								<td>{{ @$value->Name_Cus }}</td>
								<td class="text-end">{{ number_format(@$value->DUEAMT,2) }}</td>
								<td>{{ formatDateThaiShort(@$value->DUEDATE) }}</td>
								<td>
									<button class="btn btn-outline-dark btn-sm">
										<i class="bx bx-printer align-middle fs-5"></i>
									</button>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="10">- ไม่พบข้อมูล -</td>
						</tr>
					@endif
				</tbody>
			</table>

			<p id="selectedCount" class="mt-2"></p>

		</div>
	</div>
</div>

@if( count(@$data) > 0)
<script>
	$(document).ready(function() {
		var table = new DataTable('#table_billing_stmt');

		// Select/Deselect all checkboxes
		$('#selectAllCheckbox').on('click', function() {
			var rows = table.rows({ 'search': 'applied' }).nodes();
			$('input[type="checkbox"]', rows).prop('checked', this.checked);
			updateSelectedCount();
		});

		// Deselect "Select All" checkbox if one row checkbox is unchecked
		$('#table_billing_stmt tbody').on('change', 'input[type="checkbox"]', function() {
			if (!this.checked) {
				var el = $('#selectAllCheckbox').get(0);
				if (el && el.checked && ('indeterminate' in el)) {
					el.indeterminate = true;
				}
			}
			updateSelectedCount();
		});

		// Select all checkboxes in the table
		$('#selectAll').on('click', function() {
			table.$('input[type="checkbox"]').prop('checked', true);
			updateSelectedCount();
		});

		// Deselect all checkboxes in the table
		$('#deselectAll').on('click', function() {
			table.$('input[type="checkbox"]').prop('checked', false);
			updateSelectedCount();
		});

		// Click row to check/uncheck checkbox
		$('#table_billing_stmt tbody').on('click', 'tr', function(e) {
			if (e.target.type !== 'checkbox' && !$(e.target).closest('.btn').length) {
				var checkbox = $(this).find('input[type="checkbox"]');
				checkbox.prop('checked', !checkbox.prop('checked'));
				updateSelectedCount();
			}
		});

		// Update selected count
		function updateSelectedCount() {
			var count = table.$('input[type="checkbox"]:checked').length;
			$('#selectedCount').text(count + ' rows selected');
			table.$('input[type="checkbox"]').closest('tr').removeClass('selected');
			table.$('input[type="checkbox"]:checked').closest('tr').addClass('selected');
		}

		// Maintain the selected rows state on page change
		table.on('draw', function() {
			table.$('input[type="checkbox"]').each(function() {
				var checkbox = $(this);
				if(checkbox.prop('checked')) {
					checkbox.closest('tr').addClass('selected');
				} else {
					checkbox.closest('tr').removeClass('selected');
				}
			});
		});

		$('#printSelected').on('click', function() {
			var selectedIds = table.$('input[type="checkbox"]:checked').closest('tr').map(function() {
		    	//return $(this).find('td:eq(1)').text(); // Assuming ID is in the second column
				return $(this).data('invoiceid');
			}).get();

			console.log(selectedIds);
			printSelectedItemBtn(selectedIds);

		});

		function printSelectedItemBtn(itemArray) {
			var dataform = document.querySelectorAll('#form_billing_statement');
			var validate = validateForms(dataform);

			if (validate == true) {
				let form = document.createElement("form");
				form.setAttribute("method", "POST");
				form.setAttribute("action", "{{ route('report-backend.show', 1) }}");
				form.setAttribute("target", "formresult");

				let methodInput = document.createElement("input");
				methodInput.setAttribute("type", "hidden");
				methodInput.setAttribute("name", "_method");
				methodInput.setAttribute("value", "GET");
				form.appendChild(methodInput);

				let pageInput = document.createElement("input");
				pageInput.setAttribute("type", "hidden");
				pageInput.setAttribute("name", "page");
				pageInput.setAttribute("value", "billingstmt");
				form.appendChild(pageInput);

				let modeInput = document.createElement("input");
				modeInput.setAttribute("type", "hidden");
				modeInput.setAttribute("name", "mode");
				modeInput.setAttribute("value", "item");
				form.appendChild(modeInput);

				itemArray.forEach(element => {
					let input = document.createElement("input");
					input.setAttribute("type", "hidden");
					input.setAttribute("name", "items[]");
					input.setAttribute("value", element);
					form.appendChild(input);
				});

				document.body.appendChild(form);

				// เปิดหน้าต่างใหม่
				let newWindow = window.open("", "formresult", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
				if (newWindow) {
					form.submit();
					newWindow.focus();
				}

				document.body.removeChild(form);
			}
		}


	});
</script>
@endif