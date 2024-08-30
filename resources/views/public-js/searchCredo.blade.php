<script>
	$(document).ready(function() {
		$(".search-credo").click(function(ev) {
			ev.preventDefault();
			// Disable the element to prevent multiple clicks
			$(this).prop("disabled", true);

			let tag = $(this).attr('id');
			let PhoneNumber = $(this).attr('data-PhoneNumber');
			let credo_score = $(this).attr('data-credoScore');
			let type = 3;
			let _token = $('input[name="_token"]').val();

			if (credo_score == 0) {
				$.ajax({
					url: "{{ route('ControlCenter.SearchData') }}",
					method: "POST",
					data: {
						type: type,
						PhoneNumber: PhoneNumber,
						tag: tag,
						_token: _token
					},

					success: function(data) {
						// Enable the element after the request is finished
						$(".search-credo").prop("disabled", false);
						console.log(data);

						if (data.credoScore != '' && data.credoScore != 0) {
							$('#credoCode-' + tag).html('Credo : ' + data.credoCode);
							$('#credoStat-' + tag).html('ลงสำเร็จ');

							$("#btn_cal-" + tag).prop("disabled", false);
							$("#btn_cal-" + tag).attr("data-credoScore", data.credoScore);

							Swal.fire({
								icon: 'success',
								title: 'Credo Connected',
								text: "เชื่อมต่อสำเร็จ",
								showConfirmButton: false,
								timer: 1500
							});
						} else {
							Swal.fire({
								icon: 'warning',
								title: 'เชื่อมต่อล้มเหลว',
								text: "โปรดระบุสถานะ Credo ต่อไปนี้ !",
								input: 'select',
								inputOptions: {
									'CD-0001': '(CD-0001) - ใช้ IOS',
									'CD-0002': '(CD-0002) - ลงโปรแกรมไม่ได้',
									'CD-0003': '(CD-0003) - สัญญาณของ Credo',
									'CD-0004': '(CD-0004) - ใช้ Huawei',
									'CD-0006': '(CD-0006) - ไม่ได้ใช้เลข Credo'
								},
								inputPlaceholder: 'Select Status',
								showCancelButton: false,
								inputValidator: (value) => {
									return new Promise((resolve) => {
										if (value != '') {
											let type = 8;
											let _token = $('input[name="_token"]').val();

											$.ajax({
												url: "{{ route('ControlCenter.SearchData') }}",
												method: "POST",
												data: {
													type: type,
													tag: tag,
													value: value,
													_token: _token
												},

												success: function(data) {
													$('#credoCode-' + tag).html('Credo : ' + data.credoCode);
													$('#credoStat-' + tag).html(data.credoName);

													$("#btn_cal-" + tag).prop("disabled", false);
													$("#btn_cal-" + tag).attr("data-credoscore", data.credoScore);

													Swal.fire({
														icon: 'success',
														text: "Saved",
														showConfirmButton: false,
														timer: 1500
													});
												},
												error: function() {
													Swal.fire({
														icon: 'error',
														text: "เชื่อมต่อล้มเหลว โปรดลองอีกครั้ง",
														showConfirmButton: false,
														timer: 1500
													});
												}
											})
											resolve()
										} else {
											resolve('กรุณาเลือกสถานะข้างต้น :)')
										}
									})
								}
							})
						}
					},
					error: function(err) {
						// Enable the element in case of an error
						$(".search-credo").prop("disabled", false);

						Swal.fire({
							icon: 'error',
							title: err.responseJSON.title,
							text: err.responseJSON.massage,
							showConfirmButton: true,
						});
					}
				})
			} else {
				// Enable the element if credo_score is not 0
				$(".search-credo").prop("disabled", false);

				Swal.fire({
					icon: 'warning',
					title: `credo connected !`,
					text: 'credo นี้ได้ทำการเชื่อมต่อแล้ว',
					showConfirmButton: false,
					timer: 2000
				});
			}
		});
	});
</script>
