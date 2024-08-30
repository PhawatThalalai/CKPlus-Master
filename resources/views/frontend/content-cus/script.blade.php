<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script>
	$(document).on('click', '.data-modal-xl', function(e) {
		e.preventDefault();
		var url = $(this).attr('data-link');
		$('#data-modal-xl .data-modal-xl-body').load(url);
	});
</script>

<!-- สคริปต์ อัพเดตอายุลูกค้า -->
<script>
	$(document).ready(function() {
		var Type_Card = $('#Type_Card').val();
		if (Type_Card == '324003') {
			$('#branch_show,#StatusCom_show').show();
		} else {
			$('#branch_show,#StatusCom_show').hide();
		}

		$('.Birthday_cus').on('change', function(ev) {
			var birthday = $(this).datepicker("getDate");
			if (birthday != null) {
				var age = moment().diff(birthday, 'years');
				$('#display_age').val(age);
				if (age < 20 || age > 100) {
					Swal.fire({
						icon: 'warning',
						title: 'กรุณาตรวจสอบความถูกต้อง',
						html: 'อายุลูกค้าไม่อยู่ในเงื่อนไข <i>(' + age + ' ปี)</i><br><u class="text-danger">วันเดือนปีเกิดต้องเป็นปี <b>ค.ศ.</b> เท่านั้น</u>',
						confirmButtonText: 'เข้าใจแล้ว',
					});
				}
			}
		});

		$(".openDatepickerBtn").on('click', function() {
			$(this).siblings('input').focus();
		});
	});
</script>

<!-- สคริปต์ เช็ตเลขบัตรประชาชน -->
<script>
	$(function() {
		$('#IDCard_cus').unbind("input change").bind("input change", function() { //เช็คเลขบัตรประชาชนซ้ำ
			//var dataCon = $('#dataCon').val();
			//var userRole = $('#userRole').val();
			var Type_Card = $('#Type_Card').val();
			var Branch_id = $('#Branch_id').val();
			var idCard_Input = $('#IDCard_cus').val();
			var idCard_Number = idCard_Input.replaceAll("_", "").replace(/-/g, "");
			var _token = $('input[name="_token"]').val();

			var old_idCard = ''
			if ($('#IDCard_cus').data('originalvalue') != null) {
				old_idCard = $('#IDCard_cus').data('originalvalue');
			}

			if (idCard_Number.length == 13) {
				if (Type_Card == '324003') {
					var result = true;
				} else {
					var result = Script_checkID(idCard_Number);
				}

				if (result == false) {
					// เลขบัตรประชาชนผิด
					$('.Show-alert').show();
					$('span.error').text('เลขบัตรประชาชนไม่ถูกต้อง !');
					$("#PassIdCard").hide();
					$("#FailIdCard").hide();

					$("#ProgressIdCard").hide();
					$("#IDCard_cus").data('fail', true);

					$('#Type_Card,#IdcardExpire_cus').attr('required', false);
					$('.btn_createCus').attr('disabled', true);
				} else {
					// เลขบัตรประชาชนถูก

					//console.log(dataCon+''+userRole+''+dataCon);
					//if((dataCon!="" && userRole > 0 )|| dataCon=="" ){

					$('.Show-alert').slideUp();
					$("#PassIdCard").hide();
					$("#FailIdCard").hide();

					$('#Type_Card,#IdcardExpire_cus').attr('required', true);

					//เช็คเลขบัตรซ้ำกันในฐานข้อมูล
					if ($('#IDCard_cus').data('originalvalue') != null && idCard_Number == $(this).data('originalvalue')) {
						$("#IDCard_cus").data('fail', false);
						$('.btn_createCus').attr('disabled', false);
						return;
					}
					// เช็คว่าเป็นเลขที่เคยตรวจสอบไปแล้ว
					if ($('#IDCard_cus').data('checkedvalue') != null && idCard_Number == $(this).data('checkedvalue')) {
						//$("#IDCard_cus").data('fail',false);
						return;
					}
					// เช็คว่าเป็นเเลขที่ส่งไปตรวจอยู่รึเปล่า
					if (idCard_Number == $('#IDCard_cus').data('checkingvalue')) {
						return;
					}

					$("#IDCard_cus").data('checkingvalue', idCard_Number);
					$("#IDCard_cus").data('fail', true);
					$("#ProgressIdCard").show();

					$.ajax({
						url: "{{ route('cus.SearchData') }}",
						method: "post",
						data: {
							type: 'searchIdCard',
							IdCard: idCard_Number,
							IdCard_old: old_idCard,
							Type_Card: Type_Card,
							Branch_id: Branch_id,
							_token: _token
						},
						success: function(result) {
							// เช็คว่าเลขที่ส่งไป กับ อินพุตปัจจุบัน ยังเป็นเลขเดียวกันหรือไม่
							if (idCard_Input == $('#IDCard_cus').val()) {
								$("#ProgressIdCard").hide();
								if (idCard_Number == $("#IDCard_cus").data('checkedvalue')) {
									// ถ้าตรงกัน แสดงว่าเคยเช็คไปแล้ว
									return;
								}
								if (result['duplicate'] == true) {
									swal.fire({
										title: "เลขบัตรนี้มีในระบบแล้ว !",
										icon: "error",
										text: "กรุณาตรวจสอบ หรือกรอกเลขบัตรประชาชนอีกครั้ง !",
									})
									$('.Show-alert').show();
									$('span.error').text('เลขบัตรนี้มีในระบบแล้ว !');

									$("#FailIdCard").show();
									$("#PassIdCard").hide();
									$("#IDCard_cus").data('fail', true);
									$('.btn_createCus').attr('disabled', true);
								} else {
									// เลขบัตรไม่ซ้ำ
									$("#PassIdCard").show();
									$("#FailIdCard").hide();
									$("#IDCard_cus").data('fail', false);
									$('.btn_createCus').attr('disabled', false);
								}
								$("#IDCard_cus").data('checkedvalue', idCard_Number);
								$("#IDCard_cus").data('checkingvalue', '');
							}
						}
					});
					/*
					}else{
						Swal.fire({
							icon: 'warning',
							title: `ERROR `,
							text: "ไม่สามารถแก้ไขได้",
							showConfirmButton: true,
						});
						// $(".toast-success").toast({
						// 		delay: 1500
						// 		}).toast("show");
						// $(".toast-success .toast-body .text-body").text("Refresh successful");
						$('#IDCard_cus').val(old_idCard);
					}
					*/
				}
			} else {
				// ไม่ถึง 13 หลัก
				$('.Show-alert').slideUp();
				$("#PassIdCard").hide();
				$("#FailIdCard").hide();

				$("#ProgressIdCard").hide();
				$("#IDCard_cus").data('fail', true);
				$("#IDCard_cus").data('checkedvalue', '');

				if (idCard_Number.length > 0) {
					$('.btn_createCus').attr('disabled', true);
					$('#Type_Card,#IdcardExpire_cus').attr('required', true);
				} else {
					$('.btn_createCus').attr('disabled', false);
					$('#Type_Card,#IdcardExpire_cus').attr('required', false);
				}
			}
		});
	})

	// ฟังก์ชันตรวจสอบเลขบัตรประชาชน
	function Script_checkID(id) {
		if (id.substring(0, 1) == 0) {
			return false;
		}
		if (id.length != 13) {
			return false;
		}
		for (i = 0, sum = 0; i < 12; i++) {
			sum += parseFloat(id.charAt(i)) * (13 - i);
		}
		if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12))) {
			return false;
		} else {
			return true;
		}
	}
</script>

<!-- สคริปต์ เช็คเบอร์โทรซ้ำ -->
<script>

	$(document).ready(function() {

		var phoneInput = document.getElementById('Phone_cus');//$('#formCreateCus #Phone_cus_1');
		var phone_old = '';

		var PhoneSuccess = $("#PhoneSuccess");
		var phoneError = $("#PhoneError");
		var PhoneLoading = $("#PhoneLoading");

		// Function to strip non-numeric characters from phone number
		function stripNonNumeric(input) {
			return input.replace(/\D/g, '');
		}
		
		function showErrorMessage(message) {
			$(phoneError).html(`<i class="fa fa-times"></i> ${message}`);
			$(PhoneError).slideDown();
			hideSuccessMessage();
			hideLoadingMessage();
		}

		function hideErrorMessage() {
			$(phoneError).slideUp().hide();
		}

		function showSuccessMessage(message) {
			$(PhoneSuccess).html(`<i class="fa fa-check"></i> ${message}`);
			$(PhoneSuccess).slideDown();
			hideErrorMessage();
			hideLoadingMessage();
		}

		function hideSuccessMessage() {
			$(PhoneSuccess).slideUp().hide();
		}

		function showLoadingMessage(message) {
			$(PhoneLoading).html(`<div class="spinner-border spinner-border-sm" style="--bs-spinner-width: 0.75rem; --bs-spinner-height: 0.75rem;" role="status"><span class="visually-hidden">Loading...</span></div> ${message}`);
			$(PhoneLoading).slideDown();
			hideErrorMessage();
			hideSuccessMessage();
		}

		function hideLoadingMessage() {
			$(PhoneLoading).slideUp().hide();
		}

		//var phoneValue = $(phoneInput).val();
		//var phoneNumber = phoneValue.replaceAll("_", "").replace(/-/g, "");

		function isPhoneTaken(phoneValue, phoneOldValue = '') {
			var _token = $('input[name="_token"]').val();
			return new Promise((resolve, reject) => {
				$.ajax({
					url: "{{ route('cus.SearchData') }}",
					method: "post",
					data: {
						type: 'searchPhone',
						phone: phoneValue,
						phone_old: phoneOldValue,
						_token: _token,
					},
					success: function(result) {
						resolve(result['duplicate']);
					},
					error: function(xhr, status, error) {
						reject(error);
					}
				});
			});
		}


		@if( !empty($data['Phone_cus']) )
			@php
				// แยกเบอร์โทรศัพท์ออกจากกันโดยใช้ ',' เป็นตัวแบ่ง
				$_old_phone_numbers = explode(',', $data['Phone_cus']);
				// ตรวจสอบว่ามีเบอร์โทรอันแรกอยู่หรือไม่
				$first_phone_number = isset($_old_phone_numbers[0]) ? $_old_phone_numbers[0] : '';
			@endphp
			var old_phone_number = "{{ $first_phone_number }}";
			console.log("เบอร์โทรอันแรกคือ: " + old_phone_number);
		@else
			var old_phone_number = '';
		@endif

		$(phoneInput).unbind("input change").bind("input change", async function(event) {
			var rawPhoneValue = $(phoneInput).val();
			var phoneNumber = stripNonNumeric(rawPhoneValue); // Strip non-numeric characters
			console.log( phoneNumber.length, phoneNumber.length == 10, phoneNumber.length === 10);
			console.log( "old_phone_number: " + old_phone_number );
			if (phoneNumber.length === 10) {
				showLoadingMessage('กำลังตรวจสอบ...');
				try {
					const taken = await isPhoneTaken(phoneNumber, old_phone_number);
					if (taken) {
						phoneInput.setCustomValidity('เบอร์โทรนี้มีในระบบแล้ว');
						showErrorMessage('เบอร์โทรนี้มีในระบบแล้ว');
					} else {
						phoneInput.setCustomValidity('');
						showSuccessMessage('สามารถใช้เบอร์โทรนี้ได้');
					}
				} catch (error) {
					console.error('Error checking phone number:', error);
					showErrorMessage('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');
					phoneInput.setCustomValidity('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');
				}
			} else {
				phoneInput.setCustomValidity('กรุณาใส่เบอร์ 10 หลัก');
				showErrorMessage('กรุณาใส่เบอร์ 10 หลัก');
			}

			/*
			if (!phoneInput.validity.valid) {
				showErrorMessage(phoneInput.validationMessage);
				//phoneError.textContent = phone.validationMessage;
			} else {
				hideErrorMessage();
				//phoneError.textContent = ''; // Clear error message if valid
				//showSuccessMessage('สามารถใช้เบอร์โทรนี้ได้');
			}
				*/
		});

	});

</script>

<script>
	$(document).ready(function() {
		$('.btn_createCus').click(function() {
			var dataform = document.querySelectorAll('#formCreateCus');
			var assetform = $("#formCreateCus");
			var tokenform = $('#formCreateCus input[name="_token"]');
			var validate = validateForms(dataform);


			if (validate == true) {
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$('.btn-disabled').prop('disabled', true);
				$(this).prop('disabled', true);

				var data = {};
				assetform.serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('.addSpin').empty();
				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				$.ajax({
					url: "{{ route('cus.store') }}",
					method: "POST",
					data: {
						_token: "{{ @csrf_token() }}",
						funs: 'new-cus',
						data: data
					},
					success: function(result) {
						Swal.fire({
							icon: 'success',
							title: 'สำเร็จ!',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});

						window.location.href = result.href_newCus;
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
					},
					complete: function(data) {
						$('.btn-disabled').prop('disabled', false);
						$('.btn_createCus').prop('disabled', false);
						$('.addSpin').html('<i class="fas fa-download"></i>');

						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					}
				})
			}
		});

		// other_option
		$('#Prefix').change(function() {
			if ($('#Prefix').val() == "อื่น ๆ") {
				$('#PrefixOther').val('');
				//$('.other_option').show(200);
				$('#PrefixOther').siblings('span').addClass('text-danger');
				$('#PrefixOther').attr('readonly', false);
				$('#PrefixOther').attr('required', true);
			} else {
				//$('.other_option').hide(100);
				$('#PrefixOther').val('');
				$('#PrefixOther').siblings('span').removeClass('text-danger');
				$('#PrefixOther').attr('readonly', true);
				$('#PrefixOther').attr('required', false);
			}
		});

		// สถานะสมรส - โสด
		$('#Marital_cus').change(function() {
			if ($('#Marital_cus').val().includes("สมรส")) {
				$("#Mate_cus").attr("readonly", false);
				$("#Mate_Phone").attr("readonly", false);
			} else {
				$('#Mate_cus').val('');
				$('#Mate_Phone').val('');
				$("#Mate_cus").attr("readonly", true);
				$("#Mate_Phone").attr("readonly", true);
			}
		});

		// ชนิดเลขบัตร - เลือกเลขผู้เสียภาษี
		$('#Type_Card').change(function() {
			if ($('#Type_Card').val() == '324003') {
				console.log("เลขผู้เสียภาษี");
				$('#branch_show,#StatusCom_show').show();
				$('#Surname_Cus').val('');
				$("#Surname_Cus").attr("readonly", true);
				$('#Nickname_cus').val('');
				$("#Nickname_cus").attr("readonly", true);
				$(".col-input-surname,.col-input-nickname").hide(500);
			} else {
				console.log("ไม่ใช่ - เลขผู้เสียภาษี");
				$("#Surname_Cus").attr("readonly", false);
				$("#Nickname_cus").attr("readonly", false);
				$('#branch_show,#StatusCom_show').hide();
				$(".col-input-surname,.col-input-nickname").show(500);
			}
		});
	});
</script>
