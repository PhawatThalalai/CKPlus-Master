<script>
	$(document).ready(function() {
		$('#PAYFOR_CODE').on('change', function() {
			let GetVal = $(this).val();
			let page = 'backend';
			let code = 'PAYFOR_CODE';

			if (GetVal != '') {
				$.ajax({
					url: "{{ route('constants.index') }}",
					method: "GET",
					data: {
						GetVal: GetVal,
						page: page,
						code: code,
						_token: '{{ csrf_token() }}'
					},

					success: function(respon) {
						if (respon.data != null) {
							$(".PAYFOR_NAME").val(respon.data.FORDESC);

							$(".toast-success").toast({
								delay: 1300
							});
							$(".toast-success").toast("show");
						} else {
							$(".PAYFOR_CODE").val('');
							$(".PAYFOR_NAME").val('');
						}
					}
				});
			} else {
				$(".PAYFOR_CODE").val('');
				$(".PAYFOR_NAME").val('');
			}
		});
		$('.PAYTYP_CODE').on('change', function(e) {
			let GetVal = $(this).val();
			let page = 'backend';
			let code = 'PAYTYP_CODE';
			let BILLDT = $('#BILLDT').val();
			let payTypValue = $('#PAYTYP_CODE').val();
			let enabaleFuns = false;

			if (e.type === 'change' || ((e.keyCode === 13 || e.which === 13))) {
				if (payTypValue == '01') {
					if (BILLDT != '{{ date('Y-m-d') }}') {
						$('#PAYTYP_CODE,#PAYTYP_NAME').val('');

						Swal.fire({
							icon: 'error',
							title: `ไม่สามารถดำเนินการ`,
							text: 'กรณีรับชำระเงินสด ต้องชำระเป็นวันปัจจุบันเท่านั้น !',
							showConfirmButton: true,
						});
						$('#CHQDT,#PAYINACC_NAME,#PAYINACC_CODE,#PAYINACC_NUMBER,#BANKNAME').val('');
						return;
					} else {
						enabaleFuns = true;
						$('#CHQDT,#PAYINACC_NAME,#PAYINACC_CODE,#PAYINACC_NUMBER,#BANKNAME').val('');
					}
				} else {
					enabaleFuns = true;
				}

				if (enabaleFuns == true) {
					$.ajax({
						url: "{{ route('constants.index') }}",
						method: "GET",
						data: {
							GetVal: GetVal,
							page: page,
							code: code,
							_token: '{{ csrf_token() }}'
						},

						success: function(respon) {
							if (respon.data != null) {
								$(".PAYTYP_NAME").val(respon.data.PAYDESC);
								if (respon.data.PAYCODE == 04) {
									$('#CHQDT').val('{{ date('d-m-Y') }}');
								}

								// $(".PAYFOR_CODE").focus();
								$(".toast-success").toast({
									delay: 1300
								}).toast("show");
								$(".toast-success .toast-body .text-body").text('ดำเนินการสำเร็จ !');
							} else {
								$(".PAYTYP_CODE").val('');
								$(".PAYTYP_NAME").val('');
							}
						}
					});
				}
			}
		});
		$('.FOLLOW_CODE').on('change', function() {
			var GetVal = $(this).val();
			var page = 'backend';
			var code = 'FOLCODE';

			if (GetVal != '') {
				$.ajax({
					url: "{{ route('constants.index') }}",
					method: "GET",
					data: {
						GetVal: GetVal,
						page: page,
						code: code,
						_token: '{{ csrf_token() }}'
					},

					success: function(respon) {
						if (respon.data != null) {
							$("#FOLLOWNAME").val(respon.data.name);
							$(".toast-success").toast({
								delay: 1300
							});
							$(".toast-success").toast("show");
						} else {
							$("#FOLLOWCODE").val('');
							$("#FOLLOWNAME").val('');
						}
					}
				});
			} else {
				$("#FOLLOWCODE").val('');
				$("#FOLLOWNAME").val('');
			}
		});
		$('.LOCAT').on('change', function() {
			var GetVal = $(this).val();
			var page = 'backend';
			var code = 'FOLCODE';

			if (GetVal != '') {
				$.ajax({
					url: "{{ route('constants.index') }}",
					method: "GET",
					data: {
						GetVal: GetVal,
						page: page,
						code: code,
						_token: '{{ csrf_token() }}'
					},

					success: function(respon) {
						if (respon.data != null) {
							$("#FOLLOWNAME").val(respon.data.name);
							$(".toast-success").toast({
								delay: 1300
							});
							$(".toast-success").toast("show");
						} else {
							$("#FOLLOWCODE").val('');
							$("#FOLLOWNAME").val('');
						}
					}
				});
			} else {
				$("#FOLLOWCODE").val('');
				$("#FOLLOWNAME").val('');
			}
		});
	});
</script>
