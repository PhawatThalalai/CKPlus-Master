<style>
	/* Custom CSS based on SCSS */
	.verification {
		flex-direction: column;
		width: 100%;
	}

	.verification__wrap {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 1rem;
		width: 100%;
	}

	.verification__title {
		margin-bottom: 0.30rem;
		color: #212529;
		/* Bootstrap 5 text-dark */
	}

	.verification__description {
		text-align: justify;
		line-height: 1.6rem;
		font-size: 0.8rem;
		margin: 0;
		color: #6c757d;
		/* Bootstrap 5 text-secondary */
	}

	.verification__field {
		width: 100%;
		display: flex;
		gap: 0.5rem;
	}

	.verification__input {
		flex: 1;
		height: 45px;
		width: 50px;
		text-align: center;
		font-family: inherit;
		font-size: 1rem;
		font-weight: bold;
		border: 1px solid #ced4da;
		border-radius: 0.25rem;
	}

	.verification__input:focus {
		border: 2.5px solid #2c4a6b;
		border-radius: 0.25rem;
		/* เปลี่ยนสี border เมื่อ input ได้รับ focus */
		outline: none;
		/* ลบเส้นโค้งรอบ input เมื่อได้รับ focus */
	}

	.verification__input:hover {
		border: 2.5px solid #2c4a6b;
		border-radius: 0.25rem;
		box-shadow: #2c4a6b;
	}

	.verification__timeout {
		text-align: center;
		color: #6c757d;
		/* Bootstrap 5 text-secondary */
	}

	.verification__counter {
		display: inline-block;
		width: 55px;
		text-align: center;
	}
</style>

<div class="row g-2">
	<div class="col-xl-4 col-lg-12">
		<div class="input-bx">
			<input type="text" name="dis_amount" id="intput_dis_amount" value="0" class="form-control text-end border-danger" data-bs-toggle="tooltip" title="ระบุเฉพาะตัวเลข (0 - 9) เท่านั้น" autocomplete="off" placeholder=" " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
			<span class="text-danger font-size-10 mt-n2">ระบุส่วนลด</span>
		</div>
	</div>
	<div class="col-xl-8 col-lg-12">
		<div class="input-group bg-light rounded">
			<select class="form-control form-control-sm form-select select2 license-input border-danger" id="user_sentOTP" name="user_sentOTP" data-placeholder="รายชื่อ" aria-describedby="button-addon2">
				<option value="" selected>--- เลือกรายชื่อ ---</option>
				@foreach ($userSentOTP as $user)
					<option value="{{ $user->id }}">{{ $user->name }}</option>
				@endforeach
			</select>
			<button class="btn btn-primary" type="button" id="btn_sentOTP">
				<small class="addSpin"><i class="bx bxs-paper-plane"></i></small>
			</button>
		</div>
	</div>
</div>

<br>
<form class="verification shadow-none bg-light rounded-3 pt-1">
	<section class="verification__wrap">
		<header class="verification__header">
			<h5 class="verification__title text-success">กรอกรหัสขอส่วนลด</h5>
			<p class="verification__description">กรุณากรอกรหัสส่วนลด ที่ส่งไปยังผู้ที่มีสิทธิ์อนุมัติข้างต้น.</p>
		</header>

		<section class="verification__fields">
			<div class="verification__field">
				<input type="text" class="verification__input verification__input--1" id="verification-input-1" placeholder="-" maxlength="1" autocomplete="off" />
				<input type="text" class="verification__input verification__input--2" id="verification-input-2" placeholder="-" maxlength="1" autocomplete="off" />
				<input type="text" class="verification__input verification__input--3" id="verification-input-3" placeholder="-" maxlength="1" autocomplete="off" />
				<input type="text" class="verification__input verification__input--4" id="verification-input-4" placeholder="-" maxlength="1" autocomplete="off" />
				<input type="text" class="verification__input verification__input--5" id="verification-input-5" placeholder="-" maxlength="1" autocomplete="off" />
			</div>
		</section>
		<div class="d-grid gap-2 col-8 mx-auto">
			<button id="btn_confimOTP" class="btn btn-primary waves-effect waves-light" type="button" disabled>ยืนยัน</button>
		</div>

		<section class="verification__timeout">
			<p>
				กรุณากรอกภายใน <strong class="verification__counter">00 : 00</strong> นาที
				<br>
				{{-- <button type="button" class="verification__send_new text-primary" style="border: none; cursor: pointer;">ขอรหัสส่วนลดใหม่</button> --}}
			</p>
		</section>

	</section>
</form>

<script>
	$("#btn_sentOTP").click(async function() {
		let user_sentOTP = $('#user_sentOTP').val();
		let dis_amount = $('#intput_dis_amount').val().replace(/,/g, '');

		if (user_sentOTP == '' || dis_amount == '') {
			$(".toast-error").toast({
				delay: 5000
			}).toast("show");
			$(".toast-error .toast-body .text-body").text('กรุณากรอกข้อมูลให้ครบถ้วน');

			return false;
		}

		$(this).html('<small class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></small>').attr('disabled', true);

		$.ajax({
			url: "{{ route('search') }}",
			type: "POST",
			data: {
				"_token": "{{ csrf_token() }}",
				"page_type": 'otp',
				"patchCont_id": '{{ @$patchCont_id }}',
				"codloan": '{{ @$codloan }}'
			},
			success: function(response) {
				let fiveMinutes = 60 * 5;
				let display = $('.verification__counter');
				startCountdown(fiveMinutes, display);

				$('#btn_sentOTP').attr('disabled', true);
				$('#user_sentOTP,#intput_dis_amount').attr('disabled', true);
				$('.verification__send_new').attr('disabled', true).css('cursor', 'not-allowed');
				$('#btn_confimOTP').attr('disabled', false);

				$(".toast-success").toast({
					delay: 5000
				}).toast("show");
				$(".toast-success .toast-body .text-body").text(response.message);

				$("#btn_sentOTP").html('<i class="bx bxs-user-check font-size-13"></i>').attr('disabled', true);
			},
			error: function(xhr, status, error) {
				$(".toast-error").toast({
					delay: 5000
				}).toast("show");
				$(".toast-error .toast-body .text-body").text(response.message);

				$("#btn_sentOTP").html('<i class="bx bxs-paper-plane"></i>').attr('disabled', false);
			}
		});
	});

	$('.verification__send_new').click(function() {
		var fiveMinutes = 60 * 5;
		var display = $('.verification__counter');
		startCountdown(fiveMinutes, display);
		$('.verification__send_new').attr('disabled', true).css('cursor', 'not-allowed');
	});

	$('#intput_dis_amount').on('blur', function() {
		let value = $(this).val().replace(/,/g, ''); // ลบคอมม่าทั้งหมด
		if (!isNaN(value) && value !== '') {
			let numericVal = parseFloat(value);
			$(this).val(numericVal.toLocaleString('en'));
		} else {
			$(this).val('');
		}
	});

	$('#intput_dis_amount').on('click', function() {
		$(this).select()

	});

	$('.verification__input').on('input', function() {
		if (this.value.length === this.maxLength) {
			$(this).next('.verification__input').focus();
		}
	});

	$('#btn_confimOTP').click(function() {
		let otpComplete = true;
		$('.verification__input').each(function() {
			if ($(this).val() === '') {
				otpComplete = false;
				return false; // break loop
			}
		});

		if (!otpComplete || $('#intput_dis_amount').val() === '') {
			$(".toast-error").toast({
				delay: 5000
			}).toast("show");
			$(".toast-error .toast-body .text-body").text('กรุณากรอกข้อมูลให้ครบถ้วน');
			return false;
		} else {
			let disamount = $('#intput_dis_amount').val().replace(/,/g, '');
			let PAYAMT = $('#PAYAMT').val().replace(/,/g, '');
			let sumAmounts = parseFloat(PAYAMT) - parseFloat(disamount);

			// process check otp
			$('.DISCT').val(parseFloat(disamount).toLocaleString('en'));
			$('#sumPay').val(sumAmounts.toLocaleString('en'));

			$(".toast-success").toast({
				delay: 5000
			}).toast("show");
			$(".toast-success .toast-body .text-body").text('เพิ่มส่วนลดสำเร็จ');

			$('#modal_sd').modal('hide');
		}
	});

	function startCountdown(duration, display) {
		var timer = duration,
			minutes, seconds;
		var countdown = setInterval(function() {
			minutes = parseInt(timer / 60, 10);
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.text(minutes + " : " + seconds);

			if (--timer < 0) {
				clearInterval(countdown);
				// เมื่อนับถอยหลังเสร็จสิ้น
				// คุณสามารถเพิ่มโค้ดสำหรับการดำเนินการหลังจากนับถอยหลังเสร็จสิ้นที่นี่
				$('.verification__send_new').attr('disabled', false).css('cursor', 'pointer');

				$('#btn_confimOTP').attr('disabled', true);
				$('#intput_dis_amount,#user_sentOTP').attr('disabled', false);
			}
		}, 1000);
	}
</script>
