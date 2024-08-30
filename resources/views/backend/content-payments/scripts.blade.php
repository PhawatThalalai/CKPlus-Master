<script>
	$(document).ready(function() {
		//botton dateDue
		$('#btn_Due').click(function() {
			let id = $(this).data('id');
			let CODLOAN = $(this).data('codloan');
			let selectedDate = $("#dateDue").val();
			let dateDue = moment(selectedDate, 'DD-MM-YYYY').format('YYYY-MM-DD');

			// view contents
			$('.view-contentPay').hide();
			$('.view-contract').slideDown('slow');

			$('.content_cont,.content_cardpay').hide();
			$('.loading_content_cont,.loading_content_cardpay').show();

			$(this).prop('disabled', true);
			$('#btn_clearinputPay').prop('disabled', true);

			let _token = $('input[name="_token"]').val();
			$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			$('.view-tb-duepay').slideUp();
			$(".btn-typePay").removeClass("active");

			$.ajax({
				url: "{{ route('payments.create') }}",
				method: "get",
				data: {
					_token: "{{ @csrf_token() }}",
					funs: 'dateDue',
					id: id,
					dateDue: dateDue,
					CODLOAN: CODLOAN
				},

				success: function(result) {
					$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('.view-tb-duepay').slideDown(500).html(result.html);

					// contents
					$('.view-contract').slideDown('slow').html(result.viewContentCont);
					$('.content_cardpay').show()
					$('.view-contentPay,.loading_content_cardpay').hide();

					// input hide
					$('#priceCus').val(result.priceCus);
					$('#intamtCus').val(result.intamtCus);
					$('#vfollowCus').val(result.vfollowCus);
					$('#StatPayOther').val(result.StatPayOther);
					$('#StatPayOther_N').val(result.StatPayOther_N);
					$('#PactToAroth').val(result.PactToAroth);

					// reset show
					$('.btGroup-pay').val('');
					$('.btn-stantlog').val('');

					$('.btGroup-showPay').empty();
					$('.btGroup-showPay').append('0.00');
					$('#DateSer').val(result.DateSer);

					// reset btn
					$('#btn-Payments').prop("disabled", true);
					$('.btGroup-pay').prop("disabled", true);
					$('.btn-typePay').prop('checked', false);


					$(".toast-success").toast({
						delay: 1500
					}).toast("show");
					$(".toast-success .toast-body .text-body").text('Successful');
				},
				complete: function() {
					$('#btn_Due').prop('disabled', false);
					$('#dateDue').prop('disabled', false);
					$('#btn_clearinputPay').prop('disabled', false);
				}
			})
		});

		//botton typePay
		$('.btn-typePay').click(function() {
			let id = $(this).attr('id');
			let PactToAroth = $('#PactToAroth').val();
			let StatPayOther = $('#StatPayOther').val();
			let StatPayOther_N = $('#StatPayOther_N').val();

			$(".btn-typePay").removeClass("active");
			// เพิ่ม class active ให้กับปุ่มที่ถูกคลิก
			$(this).addClass("active");

			$('#btn-typePayments').val(id);
			if (id == 'Payment') {
				// if (PactToAroth != 0) {
				// 	if (StatPayOther_N == 'true') {
				// 		showAlert_V2('error', 'ดำเนินการไม่สำเร็จ !', 'ลูกค้ามีค่าธรรมเนียมอื่นๆ กรุณารับชำระค่าธรรมอื่นๆ ก่อน !.');
				// 	} else {
				// 		Swal.fire({
				// 			icon: 'error',
				// 			title: 'ดำเนินการไม่สำเร็จ',
				// 			html: `<span class="text-title"><span class="highlight-text-alert">ลูกค้ามีค่าธรรมเนียมอื่นๆ<br></span> กรุณาสร้างใบแจ้งหนี้เพื่อรับชำระ !.</span>`,
				// 			showConfirmButton: true,
				// 		});
				// 	}

				// 	$(this).prop('checked', false);
				// 	$('#btn-Payments').prop("disabled", true).blur();
				// 	$('.btGroup-pay').prop("disabled", true).val('');

				// 	return;
				// }

				$('.btGroup-pay').prop("disabled", false);
				$('.btGroup-showPay').empty().append('0.00');

				$('#btn-Payments').prop("disabled", true);
				$('#view_payment').focus(); //input
			} else {
				$('.btGroup-pay').prop("disabled", true).val('');
				$('.btn-stantlog').val('');
				$('.btGroup-showPay').empty();

				// if (StatPayOther_N == 'true') {
				$('#btn-Payments').prop("disabled", false).focus().click();
				// } else if (StatPayOther == 'true') {
				// 	showAlert('error', 'ดำเนินการไม่สำเร็จ', 'ลูกค้ามีค่าธรรมเนียมอื่นๆ', 'กรุณาสร้างใบแจ้งหนี้เพื่อรับชำระ !.');
				// }

				$('.view-contentPay').hide();
				$('.view-contract').slideDown('slow');
			}
		});

		//botton payments
		$('#btn-Payments').click(function() {
			$(this).prop("disabled", true);

			let id = $(this).data('id');
			let CODLOAN = $(this).data('codloan');
			let conttyp = $(this).data('conttyp');
			let payment = parseFloat($('#payment').val().replace(/,/g, ''));

			let status_PAYFOR = CheckClosingBalance(CODLOAN, conttyp, payment);
			// กรณีเงื่อนไขเป็น true
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

			let btn_typePay = $('#btn-typePayments').val();
			let dic_payint = $('#view_payint').val().replace(/,/g, '');
			let dic_dscint = $('#view_dscint').val().replace(/,/g, '');

			let paydue = $('#ip_paydue').val();
			let interest = $('#ip_interest').val();
			let payfollow = $('#ip_payfollow').val();

			let selectedDate = $("#dateDue").val();
			let BILLDT = moment(selectedDate, 'DD-MM-YYYY').format('YYYY-MM-DD');

			let link = "{{ route('payments.show', 'id') }}";
			let url = link.replace('id', id);

			$.ajax({
				url: url,
				method: "GET",
				data: {
					_token: '{{ csrf_token() }}',
					FlagBtn: 'create-Pay',
					btn_typePay: btn_typePay,
					payment: payment,
					dic_payint: dic_payint,
					dic_dscint: dic_dscint,
					paydue: paydue,
					interest: interest,
					payfollow: payfollow,
					CODLOAN: CODLOAN,
					BILLDT: BILLDT,
					status_PAYFOR: status_PAYFOR,
				},
				success: function(result) {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

					$('#modal_xl_2').modal('show');
					$('#modal_xl_2 .modal-dialog').html(result.html);

					let zIndex = 1040 + 10 * $(".modal:visible").length;

					setTimeout(function() {
						$('.modal-backdrop').css('z-index', zIndex - 1).addClass('modal-stack');
						console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));
					}, 0);
				},
				complete: function() {
					$('#btn-Payments').prop("disabled", false);
				}
			})
		});

		$('#btn_clearinputPay').click(function() {
			resetInputfied(this.id);
		});


		$('#view_payment, #view_payint, #view_dscint').on('blur', function() {
			let checkdate = checkDataInputays();

			if (checkdate) {
				// กรณีเงื่อนไขเป็น true
				var numericVal = parseFloat($(this).val().replace(/,/g, ''));
				if (isNaN(numericVal)) {
					numericVal = 0;
				}
				// กำหนดรูปแบบตัวเลขด้วยคอมม่าและทศนิยม
				var numberWithComma = numericVal.toLocaleString('en', {
					minimumFractionDigits: 2,
					maximumFractionDigits: 2
				});
				$(this).val(numberWithComma);
			} else {
				// กรณีเงื่อนไขเป็น false
				checkDataInputays();
			}
		});

		$('#view_payment').on('keypress input', function(e) {
			if (e.key === 'Enter' || e.type === 'change') {
				updatePaymentAndFocus(this.id);
			}
			$('#view_payint, #view_dscint').val('');

			var viewPayment = parseFloat($('#view_payment').val().replace(/,/g, '')) || 0;
			$('#payment').val(addCommas(viewPayment.toFixed(2)));
		});

		$('#view_payint, #view_dscint').on('keypress', function(e) {
			if (e.key === 'Enter' || e.type === 'change') {
				updatePaymentAndFocus(this.id);
			}
		});

		$('#view_payment, #view_payint, #view_dscint').on('click', function(e) {
			$(this).select();
		});

		function sendData(numericVal) {
			let id = $(this).data('id');
			let CODLOAN = $(this).data('codloan');
			let btn_typePay = $('#btn-typePayments').val();

			let dic_payint = $('#view_payint').val().replace(/,/g, '');
			let dic_dscint = $('#view_dscint').val().replace(/,/g, '');

			let paydue = $('#ip_paydue').val();
			let interest = $('#ip_interest').val();
			let payfollow = $('#ip_payfollow').val();

			let selectedDate = $("#dateDue").val();
			let BILLDT = moment(selectedDate, 'DD-MM-YYYY').format('YYYY-MM-DD');

			let link = "{{ route('payments.show', 'id') }}";
			let url = link.replace('id', id);

			$.ajax({
				url: url,
				method: "GET",
				data: {
					_token: '{{ csrf_token() }}',
					FlagBtn: 'create-Pay',
					btn_typePay: btn_typePay,
					payment: payment,
					dic_payint: dic_payint,
					dic_dscint: dic_dscint,
					paydue: paydue,
					interest: interest,
					payfollow: payfollow,
					CODLOAN: CODLOAN,
					BILLDT: BILLDT
				},
				success: function(result) {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

					$('#modal_xl_2').modal('show');
					$('#modal_xl_2 .modal-dialog').html(result.html);
				}
			})
		}

		// check date input payment
		function checkDataInputays() {
			let DateSer = $('#DateSer').val();
			let selectedDate = $("#dateDue").val();
			let dateDue = moment(selectedDate, 'DD-MM-YYYY').format('YYYY-MM-DD');
			return true;

			// if (dateDue != DateSer) {
			// 	resetInputfied();

			// 	Swal.fire({
			// 		icon: 'error',
			// 		title: "แจ้งเตือน",
			// 		text: "กรุณา เลือกวันที่ชำระเป็นวันปัจจุบันเท่านั้น !",
			// 		showConfirmButton: false,
			// 		timer: 2000,
			// 	});

			// 	return false;
			// } else {
			// 	return true;
			// }
		}

		function resetInputfied(FieldId) {
			$('.btGroup-pay').val('');
			$('.btGroup-pay').val('').prop('disabled', false);
			$('#view_payment').focus();

			$('#dateDue').prop('disabled', false);
			$('#btn-Payments').prop("disabled", true);
		}

		function updatePaymentAndFocus(currentFieldId) {
			let updatePay = updatePayment();
			if (updatePay === false) {
				return;
			}

			var nextFieldId = getNextFieldId(currentFieldId);
			$('#' + nextFieldId).focus().select();

			if (nextFieldId === 'btn_calculatePay') {
				let CODLOAN = $('#codloan').val();
				let viewPayment = parseFloat($('#payment').val().replace(/,/g, '')) || 0;
				let pricecus = parseFloat($("#priceCus").val());
				let intamtCus = parseFloat($('#intamtCus').val());
				let vfollowCus = parseFloat($('#vfollowCus').val());
				let sumAmount = null;

				if (CODLOAN == 1) {
					sumAmount = parseFloat(pricecus);
				} else {
					sumAmount = parseFloat(pricecus) + parseFloat(intamtCus) + parseFloat(vfollowCus);
				}

				if (viewPayment > sumAmount) {
					$('.btGroup-pay').val('');
					$('#view_payment').focus();
					$('#view_payment').select();
					showAlert_V2('error', 'ข้อมูลไม่ถูกต้อง !', 'ยอดหักลูกหนี้เกินในตาราง ไม่สามารถตัดค่างวดได้ !');
					return;
				}

				$('#btn_clearinputPay').prop('disabled', true);

				if ($('#' + nextFieldId).prop('disabled') === false) {
					let isCalculating = false; // กำหนดตัวแปรที่ระดับโกลบอล
					callCalculatePay(nextFieldId, isCalculating);
				}
			}
		}

		function getNextFieldId(currentFieldId) {
			switch (currentFieldId) {
				case 'view_payment':
					return 'view_payint';
				case 'view_payint':
					return 'view_dscint';
				case 'view_dscint':
					return 'btn_calculatePay';
				default:
					return 'view_payment'; // ถ้าไม่มีคำสั่งใน switch ให้กลับไป focus ที่ 'view_payment'
			}
		}

		function updatePayment() {
			let viewPaymentValue = parseFloat($('#view_payment').val().replace(/,/g, '')) || 0;
			let viewPayintValue = parseFloat($('#view_payint').val().replace(/,/g, '')) || 0;
			let viewDscintValue = parseFloat($('#view_dscint').val().replace(/,/g, '')) || 0;
			let viewPayment = parseFloat($('#payment').val().replace(/,/g, '')) || 0;

			let pricecus = $("#priceCus").val();
			let intamtCus = parseFloat($('#intamtCus').val());
			let vfollowCus = parseFloat($('#vfollowCus').val());
			let sumAmount = parseFloat(pricecus) + parseFloat(intamtCus) + parseFloat(vfollowCus);

			let errorMessage = '';
			if (viewPaymentValue > sumAmount) {
				errorMessage = 'ยอดรับชำระไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง !';
			}
			if (viewPayintValue > intamtCus) {
				errorMessage = 'ส่วนลดเบี้ยปรับล่าช้าไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง !';
			}
			if (viewDscintValue > vfollowCus) {
				errorMessage = 'ส่วนลดค่าทวงถามไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง !';
			}

			if (errorMessage) {
				$('.btGroup-pay').val('');
				$('#view_payment').focus();
				showAlert_V2('error', 'ข้อมูลไม่ถูกต้อง !', errorMessage);

				return false;
			}

			// let PaymentValue = viewPayment - (viewPayintValue + viewDscintValue);
			// $('#view_payment').val(addCommas(PaymentValue.toFixed(2)));

			let PaymentValue = calculateSum(viewPaymentValue, viewPayintValue, viewDscintValue);
			$('#payment').val(addCommas(PaymentValue.toFixed(2)));
		}

		function calculateSum(paymentValue, payintValue, dscintValue) {
			return paymentValue + payintValue + dscintValue;
		}

		function CheckClosingBalance(codloan, conttyp, payment) {
			let priceCus = parseFloat($('#priceCus').val()); // ยอดชำระทั้งหมด
			// let intamtCus = parseFloat($('#intamtCus').val()); //ยอดเบี้ยปรับล่าช้าทั้งหมด
			// let vfollowCus = parseFloat($('#vfollowCus').val()); //ยอดค่าทวงถามทั้งหมด

			let status_PAYFOR = (priceCus - payment) <= 0 ? '007' : '006';
			return status_PAYFOR;
		}


		function callCalculatePay(buttonId, isCalculating) {
			if (isCalculating) return; // ถ้ามีการทำงานอยู่แล้ว ให้กลับออกจากฟังก์ชันทันที
			isCalculating = true; // ตั้งค่าสถานะเป็นกำลังทำงาน

			$('#' + buttonId).prop('disabled', true); // disabled ปุ่มที่เรียกเข้ามา

			const getdate = $("#dateDue").datepicker("getDate");
			const datePay = moment(getdate).format('YYYY-MM-DD');
			// const datePay = getdate.toISOString().split('T')[0];

			const interest = $('#interest').val();
			let payment = parseFloat($('#payment').val().replace(/,/g, ''));
			let id = $("#cont_id").val();
			let CODLOAN = $('#codloan').val();

			$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			$('.view-tb-duepay').slideUp();

			$.ajax({
				url: "{{ route('payments.create') }}",
				method: "get",
				data: {
					_token: '{{ csrf_token() }}',
					funs: 'Payment',
					datePay: datePay,
					payment: payment,
					id: id,
					CODLOAN: CODLOAN,
					//arrayPaydue: arrayPaydue,
				},
				success: function(result) {
					if (result.flagdue == '') {
						isCalculating = false; // ตั้งค่าสถานะเป็นไม่ทำงาน
						$('#payment').prop('disabled', true);

						$('.view-contract').slideUp();
						$('.view-contentPay').slideDown(500).html(result.viewContentCont);
						$('.view-tb-duepay').slideDown(500).html(result.html);

						// var interest = (result.interest == '') ? 0 : result.interest;
						// var payfollow = (result.payfollow == '') ? 0 : result.payfollow;

						// input
						// $('#ip_paydue').val(result.payAmts);
						// $('#ip_interest').val(result.interest);
						// $('#ip_payfollow').val(result.payfollow);

						// text show
						// $('#sumAmount').append(addCommas((parseFloat(payment) + parseFloat(interest) + parseFloat(payfollow)).toFixed(2)));
						// $('#payinteff').append(addCommas((parseFloat(result.payinteff)).toFixed(2)));
						// $('#payton').append(addCommas((parseFloat(result.payton)).toFixed(2)));

						// show content

						// $('.view-contract').hide();
						// $('.view-contentPay').slideDown('slow').html(result.viewContentPay);

						$('#btn-Payments').prop("disabled", false).focus();
						$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					} else {
						showAlert_V2('error', 'แจ้งเตือน !', 'ยอดรับชำระ ไม่สามารถตัดค่างวดได้ !');
					}

					$('#' + buttonId).prop('disabled', false); // enabled ปุ่มที่เรียกเข้ามา
					$('.btGroup-pay').prop("disabled", true);
					$('#dateDue').prop("disabled", true);
				},
				complete: function() {
					$('#btn_clearinputPay').prop('disabled', false);
				}
			})
		}
	});
</script>

<script>
	function showAlert(icon, title, message, submmessages) {
		Swal.fire({
			icon: icon,
			title: title,
			html: `<span class="text-title"><span class="highlight-text-alert">${message}<br></span> ${submmessages}</span>`,
			showConfirmButton: true,
		});
	}

	function showAlert_V2(icon, title, text) {
		Swal.fire({
			icon: icon,
			title: title,
			text: text,
			showConfirmButton: (icon === 'error' || icon === 'warning') ? true : false,
			timer: (icon === 'error' || icon === 'warning') ? false : 2000,
		});
	}
</script>

<script>
	// $(document).ready(function() {
	// 	$("#dateDue").datepicker({
	// 		endDate: new Date() // Set the maximum date to today
	// 	});
	// });
</script>
