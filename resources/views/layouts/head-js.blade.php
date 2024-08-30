@section('script')
	<!-- form mask && form mask init -->
	<script src="{{ URL::asset('/assets/libs/inputmask/inputmask.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/js/pages/form-mask.init.js') }}"></script>

	<!-- datepicker -->
	<script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/js/bootstrap-datepicker.th.js') }}"></script>
	<!-- <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script> -->

	<script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/libs/select2/translation/th.js') }}"></script> <!-- เพิ่มภาษาไทย -->

	<script src="{{ URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

	<!-- validation -->
	<script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>
	<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js') }}"></script>

	<!-- form advanced init -->
	<script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

	<!-- apex charts -->
	<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

	<script>
		function validateForms(dataform) {
			var isvalid = false;
			Array.prototype.slice.call(dataform).forEach(function(form) {
				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();

					form.classList.add('was-validated');
					isvalid = false;
					$('.cl-select2').addClass('border border-danger');

					// แสดงข้อความแจ้งเตือนสำหรับฟิลด์ที่ไม่ผ่านการตรวจสอบ
					Array.prototype.slice.call(form.elements).forEach(function(input) {
						if (!input.checkValidity()) {
							// input.classList.add('border-danger');
							console.log("Field without data:", input.name); // แสดงชื่อฟิลด์ที่ไม่มีข้อมูล
						} else {
							// input.classList.remove('border-danger');
						}
					});

				} else {
					isvalid = true;
				}
			});
			return isvalid;
		}

		function addCommas(nStr) {
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}

		function addCommaStr(number) {
			return number.toLocaleString('en-US');
		}
	</script>

	{{-- <script>
		// Enable pusher logging - don't include this in production
		Pusher.logToConsole = true;

		var pusher = new Pusher('853cdb01d5e54186916f', {
			cluster: 'ap1'
		});

		var channel = pusher.subscribe('audits-channel');
		channel.bind('audits-event', function(data) {
			// alert(JSON.stringify(data));
			// console.log(JSON.stringify(data.audit));
			let url = `{{ route('audit.show', 'id') }}`;
			url = url.replace('id', parseInt(data.audit.replace(/"/g, '')));

			$.ajax({
				url: url,
				type: 'get',
				data: {
					funs: 'refresh-content',
				},
				success: function(result) {
					$('#Flag_Status').val(result.Flag_Status);

					$('#content_checklist').html(result.view_checklist);
					$('#content_status').html(result.view_status);
					$('#content_massages').html(result.view_massage);

					$(".toast-success").toast({
						delay: 1500
					}).toast("show");
					$(".toast-success .toast-body .text-body").text("Refresh successful");
				},
			});
		});
	</script> --}}
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="{{ URL::asset('assets\js\sweetalert2.js') }}"></script>
