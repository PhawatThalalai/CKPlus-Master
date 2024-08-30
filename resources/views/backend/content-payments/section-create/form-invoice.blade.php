<form id="form-invoice">
    @component('components.content-invoice.form-invoice')
    @slot( 'data', [
        "data" => @$data,
        "FLAGINV" => @$FLAGINV,
        "contract" => @$contract
    ])
    @endcomponent
</form>

{{-- ตอนคีย์ยอดชำระ --}}
<script>
    $('#INPUTPAY').on("input",()=>{
        let CAPITALBLVAL = parseFloat($("#CAPITALBLVAL").val())
        let INPUTPAY = parseFloat($('#INPUTPAY').val())
        let PAYFOR_CODE = $('#PAYFOR_CODE').val()
        if(PAYFOR_CODE != '007' && INPUTPAY >= CAPITALBLVAL){
            $('#INPUTPAY').val(0)
            $('#INPUTPAY').trigger("click")

            Swal.fire({
                icon : "info",
                title: "กรุณาตรวจสอบยอดรับชำระ",
                html: `<ul style="text-align: left; font-size:14px;">
                        <li>ยอดชำระไม่ควรมากกว่าหรือเท่ากับยอดคงเหลือ</li>
                        <li>หากต้องการปิดบัญชี กรุณาเลือกรหัสชำระเป็น <br> 007 (รับชำระค่างวดปิดบัญชี)</li>
                    </ul>`,
            });
        }
    })
</script>


{{-- action ตอนเลือกรหัสชำระ --}}
<script>
    $('#PAYFOR_CODE').on("blur" , ()=>{
        let PAYFOR_CODE = $('#PAYFOR_CODE').val()
        let CAPITALBLVAL = parseFloat($('#CAPITALBLVAL').val())
        if(PAYFOR_CODE == '007'){
            $(".contentDisc").show()
            $("#INPUTPAY,#TOTPAY").val(CAPITALBLVAL).prop('readonly',true)
            $('#NETBALANCE').val(CAPITALBLVAL)

        }else{
            $(".contentDisc").hide()
            $("#INPUTPAY,#TOTPAY").prop('readonly',false)
        }
    })
</script>

 {{-- ตรวจสอบ input หลังกดคำนวนว่ามีการเปลี่ยนแปลงหรือไม่ให้ กดคำนวนใหม่ถ้ามีการเปลี่ยนแปลง --}}
<script>
	$(document).ready(function() {
		$('.SSinput').on("input", () => {
			let getSSinput = JSON.parse(sessionStorage.getItem('SSinput'))
			let r = $('.SSinput').map(function() {
				var obj = {
					index: $(this).attr('name'),
					value: $(this).val()
				};
				return obj
			}).get()
			if (typeof getSSinput !== 'undefined' && getSSinput !== null) {
				const findCheck = findObjectInObject(r, getSSinput);
				if (findCheck) {
					$('.content-PayOther').show()
					$('.btn-next,#btn-saveInvoice').prop('disabled', false)
				} else {
					$('.content-PayOther').hide()
					$('.btn-next,#btn-saveInvoice').prop('disabled', true)
				}
			}
		})


		$('#DISCOTH').on('input', () => {
			let PAYOTH = $('#PAYOTH').val() || 0
			let DISCOTH = $('#DISCOTH').val()
			RESULTOTH = parseFloat(PAYOTH) - parseFloat(DISCOTH)
			$('#RESULTOTH').val(RESULTOTH)
		})

		$('#HOLDCASH').on('blur', () => {
			let FLAGHOLDCASH = $('#FLAGHOLDCASH').val()
			let HOLDCASH = $('#HOLDCASH').val()
			if (HOLDCASH > FLAGHOLDCASH) {
				swal.fire({
					icon: 'warning',
					title: 'ยอดไม่ถูกต้อง !',
					text: 'ยอดตั้งพักคงเหลือไม่เพียงพอ'
				})
				$('#HOLDCASH').val(0)
			}
		})

		// enter next input
		$('.nextInputform').on('keypress', function(event) {
			if (event.which == 13) {
				event.preventDefault();
				var $this = $(event.target);
				var index = parseFloat($this.attr('data-index'));
				var $nextElement = $('[data-index="' + (index + 1).toString() + '"]');
				if ($nextElement.length > 0) {
					$nextElement.focus();
					if ($nextElement.val().length != 0) {
						$nextElement.get(0).setSelectionRange(0, $nextElement.val().length);
					}
				} else {
					// console.error("Element not found with data-index: " + (index + 1).toString());
				}

			}
		});



		let dateNopay = $('#DATENOPAY').val()
		SSdateNopay = sessionStorage.setItem('dateNopay', dateNopay)
		$('#btn-saveInvoice').prop('disabled', true);
		$('#form-invoice input[type="text"],input[type="number"],.btn-blocked').prop('disabled', true)
		$('#formStyle').removeClass('opacity-50');
	})
</script>


{{-- search date --}}
<script>
	$('.btn_date').click(() => {
		let datepay = $('#DATENOPAY').val();
		let id = $('#PatchCon_id').val();
		let CODLOAN = $('.CODLOAN').val();
		SSdateNopay = sessionStorage.setItem('dateNopay', datepay);
		if (datepay == '') {
			$('#DATENOPAY').addClass('border border-2 border-danger text-danger')
			swal.fire({
				icon: 'warning',
				title: 'ไม่มีวันที่ค้นหา !',
				text: 'กรุณาเลือกวันที่ก่อนทำการค้นหา',
			})
		} else {
			$('#DATENOPAY').removeClass('border border-2 border-danger text-danger')
			$('.icon-dateSearch').toggle()
			$('.spinner-dateSearch').toggle()
			$('.btn_date').prop('disabled', true)

			$.ajax({
				url: "{{ route('payments.create') }}",
				type: 'GET',
				data: {
					funs: 'OVRDUE',
					CODLOAN: CODLOAN,
					date: datepay,
					id: id,
					flag: 'search-datedue',
					_token: '{{ @csrf_token() }}',

				},
				success: (res) => {
                    console.log(res);
                    $('#contentTBAroth').html(res.html)
					$('#btn-print').show();
					$('.btn_date').prop('disabled', false)
					$('#form-invoice input[type="text"],input[type="number"],.btn-blocked').prop('disabled', false)
					$('#formStyle').removeClass('opacity-50');
					$('.icon-dateSearch').toggle();
					$('.spinner-dateSearch').toggle();

					// ---- constant ----

					// TOTALPAYMENT = ((parseFloat(res['peroid'][0].PAYMENT) + parseFloat(res['peroid'][0].INTLATEAMT - parseFloat(res.payint.PAYINT))) + parseFloat(res.arth.PAYAMT) );
					TOTALPAYMENT = (
						(
							(
								parseFloat(res['peroid'][0].PAYMENT) +
								parseFloat(res['peroid'][0].PAYFOLLOW) +
								parseFloat(res['peroid'][0].INTLATEAMT ?? 0) -
								parseFloat(res.payint.PAYINT ?? 0)
							) +
							parseFloat(res.arth.BALANCE ?? 0)
						)
					);
					TOTLAPAY = parseFloat(TOTALPAYMENT ?? 0)
					DEBTOTH = parseFloat(res.arth.BALANCE ?? 0)

					// ---- Assign Value ----
                    let CAPITALBLVAL = parseFloat(res.dataPatch.TOTPRC) - parseFloat(res.dataPatch.SMPAY)

					$('#TOTALPAYMENT').html(( TOTLAPAY ).toLocaleString('th-TH')) // ยอดที่ต้องชำระ
					$('#CAPITALBL').html(addCommas(CAPITALBLVAL )); // ยอดทั้งหมด
					$('#CAPITALBLVAL').val(CAPITALBLVAL); // ยอดทั้งหมด
                    $(".DISCCloseAC").val(res.calCloseAC.dscint)
                    $('#ShowDISCCloseAC').html(addCommas(res.calCloseAC.dscint))

					$('.OutstandingBalance').html(addCommas(res['peroid'][0].PAYMENT)); // เงินค้างงวด
					$('#OUTSBL').val(res['peroid'][0].PAYMENT) // เงินค้างงวด
					$('.INTLATEAMT').html(addCommas(res['peroid'][0].INTLATEAMT - res.payint.PAYINT)); // แสดงค้างเบี้ยปรับ
					$('#INTLATEAMT,#B_INTAMT').val(res['peroid'][0].INTLATEAMT - res.payint.PAYINT) // ค้างเบี้ยปรับ
					$('.FOLLOWAMT').html(addCommas(parseFloat(res['peroid'][0].PAYFOLLOW))) // แสดงค่าทวงถาม
					$('#FOLLOWAMT,#PAYFOLLOW').val(res['peroid'][0].PAYFOLLOW) // ค่าทวงถาม


					$('.DEBTOTH').html(addCommas(DEBTOTH)); // ลูกหนี้อื่น
					$('#DEBTOTH').val(DEBTOTH) // ลูกหนี้อื่น

					$('#TOTALPAYMENTS,#PERIODDEBT').val(TOTLAPAY)
					$('#DISCAROTH').val(res.arth.DISCOUNT)
					$('#DOCDATE').val(res.docDate)

				},
				error: () => {
					$('.icon-dateSearch').toggle()
					$('.spinner-dateSearch').toggle()
					$('.btn_date,#btn-saveInvoice').prop('disabled', false)
				}
			})
		}
	})
</script>


{{-- clearinput --}}
<script>
	$('#btn-clear').click(() => {
		// $('#discount-content,#btn-clear,#btn-discount').hide()
		$('.content-PayOther').empty()
		$('.clearValue').val(0)
		$('.btn-next').prop('disabled', true)
	})
</script>

{{-- คำนวนคงเหลือตัดงวดสุทธิ --}}
<script>

    $('.calPay').on('input', () => {
        let INPUTPAY = $('#INPUTPAY').val() || 0
        let sumPay = 0 , sumDsc = 0

        TOTPAY = parseFloat(INPUTPAY)

		$('.calPay').each(function() {
			sumPay += parseFloat($(this).val()) || 0;
		});

		$('.caldsc').each(function() {
			sumDsc += parseFloat($(this).val()) || 0;
		});

		$('#TOTBLC').val(sumPay + sumDsc)
		$('#TOTPAY').val(TOTPAY)
	})

    $('.calpayments').on('input',()=>{
        let TOTPAY = $('#TOTPAY').val()
        let DISCPAYOTH = $('#DISCPAYOTH').val() || 0 // ส่วนลดลูกหนี้อื่น
        let DISCCloseAC = $('#DISCCloseAC').val() || 0
        let sumPay = 0;
        let sumDsc = 0;

		$('.calPay').each(function() {
			sumPay += parseFloat($(this).val()) || 0;
		});

		$('.caldsc').each(function() {
			sumDsc += parseFloat($(this).val()) || 0;
		});

        $('#TOTBLC').val(sumPay + sumDsc)
        $('#NETBALANCE').val(sumPay - sumDsc)
    })
</script>

{{-- กดคำนวณ --}}
<script>
	$('.calInvoice').on('keypress click', async (event) => {
		$('.calInvoice,.btn-close').prop('disabled', true)
		$('.spinner-cal').toggle()
		$('.icon-cal').hide()
		if (event.which == 13 || event.type === 'click') {

			let TOTPAY = $('#TOTPAY').val()
			let TOTBLC = $('#TOTBLC').val()
            let INPUTPAYPLUS = $('#INPUTPAYPLUS').val()

			// เช็คว่ามีส่วนลดหรือไม่ถ้ามี เอาตัวแปรนั้น
			let datepay = $('#DATENOPAY').val();
			let id = $('#PatchCon_id').val();
			let CODLOAN = $('.CODLOAN').val();

			let FOLLOWAMT = $('#FOLLOWAMT').val()
			let DISCPAYFOLLOW = $('#DISCPAYFOLLOW').val()
			let B_INTAMT = $('#B_INTAMT').val()
			let DISCB_INTAMT = $('#DISCB_INTAMT').val()

            if( parseFloat(DISCPAYFOLLOW) != parseFloat(FOLLOWAMT) && parseFloat(DISCPAYFOLLOW)  > 0){
                await swal.fire({
                    icon : 'error',
                    title : 'จำนวนเงินไม่ถูกต้อง !',
                    text : 'ไม่สามารถใส่ยอดเกินค่าทวงถามได้',
                })
                $('#DISCPAYFOLLOW').val(0)
                $('#DISCPAYFOLLOW').focus();
                $('#DISCPAYFOLLOW').get(0).setSelectionRange(0, 1);
                $('.calInvoice,.btn-close').prop('disabled', false)
                $('.spinner-cal').toggle()
                $('.icon-cal').show()
                return 0
            }


			if (parseFloat(DISCB_INTAMT) > parseFloat(B_INTAMT)) {
				await swal.fire({
					icon: 'error',
					title: 'จำนวนเงินไม่ถูกต้อง !',
					text: 'ไม่สามารถใส่ยอดเกินจำนวนเบี้ยปรับได้',
				})

				$('#DISCB_INTAMT').val(0)
				$('#DISCB_INTAMT').focus();
				$('#DISCB_INTAMT').get(0).setSelectionRange(0, 1);
				$('.calInvoice,.btn-close').prop('disabled', false)
				$('.spinner-cal').toggle()
				$('.icon-cal').show()
				return 0


			}

			if (TOTPAY > 0) {
				$.ajax({
					url: "{{ route('payments.create') }}",
					type: 'GET',
					data: {
                        AROTHR : $('#AROTHR').val(),
						INPUTPAY: TOTBLC != '' ? TOTBLC : TOTPAY,
						funs: 'OVRDUE',
						CODLOAN: CODLOAN,
						date: datepay,
						id: id,
						flag: 'cal-Invoice',
						_token: '{{ @csrf_token() }}',

					},
					success: async (res) => {
                        console.log(res);

                        $('#HLDCASH').val(res.HLDCASH)
						// เก็บ input ลง session
						let SSinput = [];
						$('.SSinput').each(function() {
							var obj = {
								index: $(this).attr('name'),
								value: $(this).val()
							};
							SSinput.push(obj);
						})
						sessionStorage.setItem('SSinput', JSON.stringify(SSinput))

						// constant
						let TOTBLCPAY = parseFloat(res.TOTBLC) - (parseFloat(res.dataPayduePayment[0].b_intamt) + parseFloat(res.dataPayduePayment[0].payfollow))
						let PAYAMT = parseFloat(res.TOTBLC) - ((parseFloat(res.dataPayduePayment[0].followamt) - parseFloat(res.dataPayduePayment[0].payfollow) + parseFloat(res.dataPayduePayment[0].intamt))) || 0.00


						// เช็คว่ามีลูกหนี้อื่นหรือไม่มี
						if (sumBalance(res.dataPayOther) == 0) {
							// await swal.fire({
							// 	icon: '',
							// 	title: 'ไม่สามารถเพิ่มข้อมูลได้',
							// 	text: 'สัญญานี้ไม่มีรายการลูกหนี้อื่นที่ต้องชำระ !',
							// })

							// $('.modal').modal('hide')
							// return 0
						}


						// ยอดรวมเบี้ยปรับ
						const sumIntamt = (res.dataPayduePayment).reduce((i, object) => {
							return parseFloat(i) + parseFloat(object.intamt);
						}, 0);

						// ยอดรวมค่าทวงถาม
						const sumFollowamt = (res.dataPayduePayment).reduce((i, object) => {
							return parseFloat(i) + parseFloat(object.followamt);
						}, 0);

						$('#btn-discount').show(500) // แสดงปุ่มให้ส่วนลดกับคืนค่า
						$('.calInvoice,.btn-next,#btn-saveInvoice').prop('disabled', false)
						$('.spinner-cal').hide()
						$('.icon-cal').show()

						if (res.hold == true) {
							$('#HOLDCASHNEXT').val(res.TOTBLC)
							swal.fire({
								icon: 'warning',
								title: 'เก็บเป็นเงินตั้งพัก',
								text: 'เนื่องจากได้มีการตัดค่างวดหมดก่อนค่าปรับอื่นๆ',
							})
						} else {
							$('#HOLDCASHNEXT').val(0)
						}
						$('.content-PayOther').show()
						$('.content-PayOther,.content-PaymentOther').html(res.PayOther)


						$('.TOTBLC,#TOTBLC-PAY').val(TOTBLCPAY)
						$('.payoth').val(res.PAYAROTR)
						$('#AROTHR').val(res.AROTHR)
						$('#SMPAY').val(res.TOTBLC)
						$('#DISCPAYOTH').val(res.DISCOUNT)
						$('#TOTBLCOTH').val((parseFloat(res.TOTBLC)))
						$('#PAYAMT').val(PAYAMT)


						// คำนวนคงเหลือสุทธิ
						let sum = 0;
						let TOTBLC = res.TOTBLC
						$('#form-payments .calperiod').each(function() {
							sum += parseFloat($(this).val()) || 0;
						});
						$('.TOTBLINT').val(parseFloat(res.TOTBLC) + parseFloat(res.DISCOUNT))

						$(".toast-success").toast({
							delay: 1300
						});
						$(".toast-success").toast("show");
					},
					error: (err) => {
						$('.calInvoice').prop('disabled', false)
						$('.icon-cal').show()
						$('.spinner-cal').hide()
						swal.fire({
							icon: "error",
							title: "Error",
							text: err.message
						})
					}
				})
			} else {
				$('.calInvoice').prop('disabled', false)
				$('.icon-cal').show()
				$('.spinner-cal').hide()
				swal.fire({
					icon: 'warning',
					title: 'ข้อมูลไม่ครบ !',
					text: 'กรุณากรอกข้อมูลยอดชำระ ! ก่อนกดคำนวณ',
				})
			}
		}
	})
</script>

{{-- ดึงใบแจ้งหนี้ล่าสุด ภายในวัน --}}
<script>
    $('#getIctiveInv').click(()=>{
        $('.spinnerINV').show()
        let url = "{{ route('payments.show',':ID') }}"
        let DataPact_id = sessionStorage.getItem("DataPact_id")
        $.ajax({
            url : url.replace(":ID" , DataPact_id),
            type : "GET",
            data : {
                FlagBtn : "getActiveINV",
                PactCon_id : DataPact_id,
                _token : "{{ @CSRF_TOKEN() }}"
            },
            success : (res)=>{
                $('#content-form').html(res.html)
                $('.content-PayOther').html(res.htmlTB)
                    $('.spinnerINV').hide()
                    $("#btn-selectINV").prop('disabled',false)
                    sessionStorage.setItem('TOTBLC',res.TOTBLC)
					$("#btn-newInvoice").show()
                    $('#btn-saveInvoice').hide()
                    $('.btn-next').show().prop('disabled',false)
                    $('#id_invoice').val(res.data.id)
                    $('#paymentPatch').val( $("#PatchCon_id").val())


            },
            error : ()=>{
                $('.spinnerINV').hide()

            }
        })
    })
</script>



{{-- function --}}

<script>
    function sumBalance(array) {
        let sum = 0;
        array.forEach(obj => {
            sum += parseFloat(obj.BALANCE); // Parse the value to a float before summing
        });
        return sum;
    }
</script>

<script>
	function findObjectInObject(arrayA, arrayB) {
		// Check if arrays have the same length
		if (arrayA.length !== arrayB.length) {
			return false;
		}

		// Sort arrays by index property to ensure consistent comparison
		const sortedArrayA = arrayA.slice().sort((a, b) => a.index.localeCompare(b.index));
		const sortedArrayB = arrayB.slice().sort((a, b) => a.index.localeCompare(b.index));

		// Compare each object in the sorted arrays
		for (let i = 0; i < sortedArrayA.length; i++) {
			const objA = sortedArrayA[i];
			const objB = sortedArrayB[i];
			if (JSON.stringify(objA) !== JSON.stringify(objB)) {
				return false;
			}
		}

		return true;
	}
</script>

