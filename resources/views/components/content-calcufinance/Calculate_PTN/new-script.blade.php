<script>
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
</script>

<script>
	$('.TypeLoans').change(function() {
		enableInputs($(this).val());
	});

	$('#RatePrices').on("input", () => {
		var RatePrices = $('#RatePrices').val().replace(/,/g, '');
		$("#RatePrices").val(addCommas(RatePrices));
		$("#RatePrice_Car").val(addCommas(RatePrices));
	});

	$('#Cash_Car').on("input", () => {
		var CodeLoans = $('#CodeLoans').val();
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
		// var Process_Car = (parseFloat(Cash_Car) * 2.8) / 100;
		if (CodeLoans == '04') {
			var Process_Car = Math.floor(((parseFloat(Cash_Car) * 5.0) / 100) / 100) * 100;
		} else {
			var Process_Car = Math.floor(((parseFloat(Cash_Car) * 2.8) / 100) / 100) * 100;
		}

		$("#Cash_Car").val(addCommas(Cash_Car));
		$("#Process_Car").val(Process_Car);
	});

	$('#Timelack_Car').change(function() {
		var Timelack = $(this).val();
		var TypeLoans = $('#TypeLoans').val();
		var CodeLoans = $('#CodeLoans').val();
		var yearAsset = $(".yearAsset option:selected").text();
		var typeAsset = $('.typeAsset').val();

		$('.Show-interest').empty();
		$('#Interest_Car').attr('readonly', true);

		if (CodeLoans == '11' || CodeLoans == '17') {
			$('#Show-interest').html(0.89);
			$('#Interest_Car').attr('readonly', false);
		} else if (CodeLoans == '16') {
			$('#Show-interest').html(1.25);
			$('#Interest_Car').attr('readonly', false);
		} else {
			ReferenceTimelack(Timelack, typeAsset, yearAsset, null);
		}
	});

	$('#Interestmore_Car').change(function() {
		if ($(this).val() != '') {
			$('#btn_InterestSelect').removeClass('disabled');
		} else {
			$('#btn_InterestSelect').addClass('disabled');
		}
	});

	$('#button-data1').click(async function() {
		var CodeLoans = $('#CodeLoans').val();
		var RatePrices = $('#RatePrices').val().replace(/,/g, ''); //ราคากลาง
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
		var Timelack_Car = $('#Timelack_Car').val();
		var Interest_Car = $('#Interest_Car').val();
		var Type_Customer = $('#Type_Customer').val();
		var DateOccupiedcar = $('#DateOccupiedcar').val();

		let Buy_PA = $('#showBuy_PA').prop('checked');
		let Include_PA = $('#showInclude_PA').prop('checked');
		var flagCheckLTV = 'alert';

		if (CodeLoans != '' && RatePrices != '' && Cash_Car != '' && Timelack_Car != '' && Interest_Car != '' && DateOccupiedcar != '') {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			$('#button-Clear1').prop('disabled', true);
			$('.cal-addSpin').empty();

			$('<span />', {
				class: "spinner-border spinner-border-sm text-danger fs-2",
				role: "status"
			}).appendTo(".cal-addSpin");

			try {
				// Process table
				const result = await ProcessCalculate(CodeLoans, flagCheckLTV, Buy_PA, Include_PA, Type_Customer);

				$('#data_empty').removeClass('d-flex');
				$('#data_empty').hide();

				$('.data-show').slideDown();
				$('.showdata-result').slideDown();

				$('.cal-addSpin').empty();
				$('.cal-addSpin').append('<i class="bx bx-calculator"></i>');

				$("#btn_SubmitCalculate").prop("disabled", false);
				$("#button-Clear1").prop("disabled", false);
				$('#button-data1').prop('disabled', true);

				// set show input
				$("#createCalculates :input").prop("readonly", true);
				$('#createCalculates select').addClass('disabled-select');
				$('#showBuy_PA,#showInclude_PA').prop('disabled', true);

				$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
				lock_input();
			} catch (error) {
				Swal.fire({
					icon: 'error',
					title: "เกิดข้อผิดพลาด",
					text: "ไม่สามารถดำเนินการต่อได้ในขณะนี้ โปรดลองใหม่อีกครั้ง !",
				});
			}
		} else {
			Swal.fire({
				icon: 'error',
				title: "ข้อมูลไม่ถูกต้อง",
				text: "โปรดตรวจสอบ ช่องที่ใช้ในการคำนวณให้ครบถ้วน !",
			});
		}
	});

	$('#button-Clear1').click(function() {
		unlock_input();
		reset_value();
	});

	$('#InterestSelect li').click(function() {
		var FlagInterest = this.id;
		if (FlagInterest == 'Plus') {
			$('#Plus').addClass('active');
			$('#Delete,#Return').removeClass('active');
		} else if (FlagInterest == 'Delete') {
			$('#Delete').addClass('active');
			$('#Plus,#Return').removeClass('active');
		} else if (FlagInterest == 'Return') {
			$('#Interestmore_Car').val('');
			$('#Return,#Plus,#Delete').removeClass('active');
		}

		$("#Flag_Interest").val(FlagInterest);
	});

	$('#btn_SubmitCalculate').click(function() {
		var dataform = document.querySelectorAll('.needs-validation');
		var validate = validateForms(dataform);

		console.log(validate, dataform);

		if (validate == true) {
			let Cal_id = $('#Cal_id').val();
			let _token = $('input[name="_token"]').val();
			let sess = sessionStorage.getItem('element');
			let data = {};
			$("#form_createCal").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$('#btn_SubmitCalculate,#btn_closeCal,.btn-close').prop('disabled', true);
			$('.addSpin').empty();
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpin");

			if (Cal_id != '') {
				let link = "{{ route('ControlCenter.update', 'id') }}";
				var url = link.replace('id', Cal_id);
				var method = "PUT";
			} else {
				var url = "{{ route('ControlCenter.store') }}";
				var method = "POST";
			}

			$.ajax({
				url: url,
				method: method,
				data: {
					_token: _token,
					type: 6,
					data: data
				},

				success: function(result) {
					Swal.fire({
						icon: 'success',
						text: result.message,
						showConfirmButton: false,
						timer: 1500
					});

					if (sess == 'section-expens') {
						$('#section-content').html(result.html);
					}

					$('#modal_xl_2').modal('hide');
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});

					$('#modal_xl_2').modal('hide');
				}
			})
		}
	});

	$('#showBuy_PA').on('change', function() {
		var Include_PA;
		if ($(this).prop('checked') == true) {
			Include_PA = true;
		} else {
			Include_PA = false;
		}

		activeData_PA($(this).prop('checked'), Include_PA);
	});

	$('#showInclude_PA').on('change', function() {
		activeData_InPa($(this).prop('checked'));
	});

	$('#ShowStatusProcess_Car').on('change', function() {
		let Process_Car = $('#ShowStatusProcess_Car').prop('checked');
		activeProcess_Car(Process_Car);
	});

	$('#Type_Customer').change(function() {
		$('#DateOccupiedcar').val("");
		$('#count-DateOccup').empty();

		if ($(this).val() == 'CUS-0009') {
			$('.show-Timelack_PRD').attr('style', '');
		} else {
			$('.show-Timelack_PRD').attr('style', 'display:none !important');
			$('#Timelack_PRD').val('');
		}
	});

	$('#DateOccupiedcar').change(function() {
		var Type_Customer = $('#Type_Customer').val();
		var dayOcc, countdate, ymd;

		$('#count-DateOccup').empty();
		if (Type_Customer != '') {
			// ฟังก์ชั่นแปลงรูปแบบวันที่
			const formatDate = dateStr => dateStr.split('-').reverse().join('-');
			// รับค่าและแปลงรูปแบบวันที่
			const formattedDate = formatDate($("#DateOccupiedcar").val());

			dayOcc = jsDateDiff2(formattedDate, $("#todayOcc").val());
			ymd = convertDaysToYMD(dayOcc);

			$('#count-DateOccup').append('<i class="bx bx-calendar-event"></i> : ' + ymd.years + " ปี " + ymd.months + " เดือน " + ymd.days + " วัน");
			$('#NumDateOccupiedcar').val(dayOcc);

			if (Type_Customer == 'CUS-0002' || Type_Customer == 'CUS-0006' || Type_Customer == 'CUS-0008' || Type_Customer == 'CUS-0010') { //ลูกค้านายหน้าดีเด่น
				countdate = 99;
			} else {
				countdate = dayOcc;
			}
			CountDateRateLTV(countdate);

			// set dispaly
			$('#tab-datarate').attr('disabled', false);
			$('#flush-collapseOne').collapse('show');
		} else {
			$('#DateOccupiedcar').val("");
			Swal.fire({
				icon: 'error',
				title: "ข้อมูลไม่ถูกต้อง",
				text: "โปรดเลือกประเภทลูกค้า ก่อนเลือกวันครอบครอง !",
			})
		}
	});

	$('#Promotions').change(function() {
		var typepromo = $(this).val().split('/');
		$('#valuePromotion').val(typepromo[0]);
	});
</script>

<script>
	$(async function() {
		var Cal_id = $('#Cal_id').val();
		var Type_Customer = $('#Type_Customer').val();
		var CodeLoans = $('#CodeLoans').val();
		var assetType_input = $('#assetType_input').val();

		var Timelack_Car = $('#Timelack_Car').val();
		var Interest_Car = $('#Interest_Car').val();

		var typeAsset = $('#showRateCartypes').val();
		var yearAsset = $('#showRateYear').val();

		let Buy_PA = $('#showBuy_PA').prop('checked');
		let Include_PA = $('#showInclude_PA').prop('checked');

		let Process_Car = $('#ShowStatusProcess_Car').prop('checked');

		if (Type_Customer == 'CUS-0009') {
			$('.show-Timelack_PRD').attr('style', '');
		} else {
			$('.show-Timelack_PRD').attr('style', 'display:none !important');
			$('#Timelack_PRD').val('');
		}

		if (Cal_id != '') {
			var flagCheckLTV = 'null';

			// Process table
			activeData_PA(Buy_PA, Include_PA);
			activeProcess_Car(Process_Car);

			await ProcessCalculate(CodeLoans, flagCheckLTV, Buy_PA, Include_PA, Type_Customer);
			enableInputs(assetType_input);
			lock_input();

			if (CodeLoans == '11' || CodeLoans == '17') {
				$('#Show-interest').html(0.89);
			} else {
				// get Interest_rate
				await ReferenceTimelack(Timelack_Car, typeAsset, yearAsset, Interest_Car);
			}

			// set dispaly
			$('#tab-datarate').attr('disabled', false);
			$('#flush-collapseOne').collapse('show');

			$('.showdata-result').slideDown("slow").attr('style', '');

			var ymd = convertDaysToYMD($('#NumDateOccupiedcar').val());
			$('#count-DateOccup').append('<i class="bx bx-calendar-event"></i> : ' + ymd.years + " ปี " + ymd.months + " เดือน " + ymd.days + " วัน");
		} else {
			// set dispaly
			$('#tab-datarate').attr('disabled', true);
			$('#flush-collapseOne').collapse('hide');

			activeData_PA(true, true);
			activeProcess_Car(true);
		}
	})

	async function ProcessCalculate(Loan, flag, flagPA, flagInPA, typCus) {
		return new Promise((resolve, reject) => {
			var Cash_Car = $('#Cash_Car').val().replace(/,/g, ''); //ยอดจัด
			var Process_Car = $('#Process_Car').val().replace(/,/g, ''); //ค่าดำเนินการ
			var RatePrices = $('#RatePrice_Car').val().replace(/,/g, ''); //เรทจัด
			// var RatePrices = $('#RatePrices').val().replace(/,/g, '');    //ราคากลาง

			var CodeLoans = $('#CodeLoans').val();
			var Timelack_Car = $('#Timelack_Car').val(); //ระยะเวลาผ่อน
			var Timelack_PRD = $('#Timelack_PRD').val(); //งวดค้างจริง
			var Interest_Car = $('#Interest_Car').val();

			var Promotions = $('#Promotions').val();
			var typepromo = Promotions.split('/');

			var FlagInterest = $('#Flag_Interest').val();
			var Interestmore_Car = $('#Interestmore_Car').val();

			var Insurance = $('#Insurance').val(); //ประกันรถ
			var Insurance_PA = $('#Insurance_PA').val(); //ประกัน PA

			var NumDateOccup = $('#NumDateOccupiedcar').val();

			//กอล์ฟเพิ่ม
			var CheckPage = $('#CheckPage').val();
			var scoreCredo = $('#Credo_Score').val();

			// if (CheckPage != "disabled") {
			if (parseInt(scoreCredo) > 0) {
				$('#Note_Credo').val('ใช้ Score คำนวณ');
			} else {
				$('#Note_Credo').val('ไม่ใช้ Score');
			}
			// }

			var sh_planPa, sh_LimitLoan, sh_timelack, sh_periodPa;
			var valPrice = 0
			valPrice = parseFloat(Cash_Car) + parseFloat(Process_Car) + parseFloat(Insurance);


			if (FlagInterest != '') {
				if (FlagInterest == 'Plus') {
					var SumInterest = parseFloat(Interest_Car) + parseFloat(Interestmore_Car);
				} else if (FlagInterest == 'Delete') {
					var SumInterest = parseFloat(Interest_Car) - parseFloat(Interestmore_Car);
				} else if (FlagInterest == 'Return') {
					var SumInterest = parseFloat(Interest_Car);
				}
			} else {
				var SumInterest = parseFloat(Interest_Car);
			}

			if (Promotions != '' && Promotions != 'ยกเลิก') {
				if (typepromo[2] == 1) {
					valinterest = (((Timelack_Car - typepromo[2]) * SumInterest) / Timelack_Car);
				} else {
					valinterest = SumInterest;
				}
			} else {
				valinterest = SumInterest;
			}

			// set data PA
			if (flagPA == true) {
				var interestPA = InsurancePA();
			}

			// set LTV
			if (flag != 'alert') {
				if (NumDateOccup != '') {
					CountDateRateLTV(NumDateOccup);
				}
			}

			$('#ShowPeriod,#ShowTotalPeriod,#ShowPercent').empty();
			$('#tb_showdata').empty();

			if (Loan == '01') { //เช่าซื้อ
				if (typCus == 'CUS-0009') { //ปรับโครงสร้างหนี้
					// var Interest = valinterest * 12;
					// var NewInterest = (valinterest * (Timelack_PRD)) + 100;
					// var Period = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / Timelack_Car) / 10) * 10;

					// var valPeriod = Period;
					// var TotalPeriod = Period * Timelack_Car;
					// var Profit = TotalPeriod - valPrice;

					// var Duerate = Period / ((7 / 100) + 1); //ยอด no vat
					// var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
					// var Tax = parseFloat(Period) - parseFloat(Duerate); //ภาษีต่องวด
					// var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา

					// var percent = (Cash_Car / RatePrices) * 100;
					// var YesrInterest = valinterest * 12; //ดอกเบี้ยต่อปี

					// $("#Tax_Rate").val(addCommas(Tax.toFixed(2))); //ภาษี
					// $("#Tax2_Rate").val(addCommas(Tax2.toFixed(2))); //ระยะผ่อน-1
					// $("#Duerate_Rate").val(addCommas(Duerate.toFixed(2))); //ค่างวด
					// $("#Duerate2_Rate").val(addCommas(Duerate2.toFixed(2))); //ระยะผ่อน-2

					// var textdata = '<span class="text-muted m-5 mt-3 align-center"><i>ไม่พบข้อมูล</i></span>';
					// $('#tb_showdata').append(textdata);


					for (let index = 12; index <= 84; index = index + 6) {
						var NewInterest = (valinterest * (index)) + 100;
						var Period = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / index) / 10) * 10;

						if (flagPA == true) {
							var TangRatePeriod = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / Timelack_Car) / 10) * 10;
							var TangRate = TangRatePeriod * Timelack_Car;

							let totalRate = TangRate;
							var Installment = `TimeRack${index}`;
							var timeRack, plan_pa, Limit_Loan, id_pa, valTime;

							for (let val of interestPA) {
								if (totalRate < interestPA[interestPA.length - 1].Limit_Insur) {
									if (val.Limit_Insur > totalRate) {
										if (typepromo[2] == 3) {
											// plus10 = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
											timeRack = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
											// timeRack = Math.ceil(plus10 / 10) * 10;
										} else {
											timeRack = val[Installment];
										}
										valTime = val[Installment];
										plan_pa = val['Plan_Insur'];
										Limit_Loan = val['Limit_Insur'];
										id_pa = val['id'];
										break;
									}
								} else {
									if (typepromo[2] == 3) {
										// plus10 = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
										timeRack = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
										// timeRack = Math.ceil(plus10 / 10) * 10;
									} else {
										timeRack = interestPA[interestPA.length - 1][Installment];
									}
									valTime = interestPA[interestPA.length - 1][Installment];
									plan_pa = interestPA[interestPA.length - 1]['Plan_Insur'];
									Limit_Loan = interestPA[interestPA.length - 1]['Limit_Insur'];
									id_pa = interestPA[interestPA.length - 1]['id'];
								}
							}

							var newRate = parseFloat(valPrice) + parseFloat(timeRack);
							var Period2 = Math.ceil(((((newRate * NewInterest) / 100) * 1.07) / index) / 10) * 10;
						}

						if (index == Timelack_Car) {
							// set value PA
							if (flagPA == true) {
								$('#Insurance_PA').val(timeRack);
								$('#Plan_PA').val(id_pa);

								sh_planPa = id_pa;
								sh_LimitLoan = addCommas(Limit_Loan);
								sh_timelack = (Math.ceil(Timelack_Car / 12));
								sh_periodPa = addCommas(timeRack);

								var show_paPlan = plan_pa;
								var show_paLimit = sh_LimitLoan;
								var show_paTime = sh_timelack;
								var show_paPeriod = sh_periodPa;
							} else {
								$('#Insurance_PA').val(0);
								$('#Plan_PA').val('');

								var show_paPlan = '',
									show_paLimit = '',
									show_paTime = '',
									show_paPeriod = '';
							}

							if (flagInPA == true) {
								var valPeriod = Period2;
								var TotalPeriod = Period2 * Timelack_Car;
								var Profit = TotalPeriod - newRate;

								var Duerate = Period2 / ((7 / 100) + 1); //ยอด no vat
								var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
								var Tax = parseFloat(Period2) - parseFloat(Duerate); //ภาษีต่องวด
								var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา

							} else {
								var valPeriod = Period;
								var TotalPeriod = Period * Timelack_Car;
								var Profit = TotalPeriod - valPrice;

								var Duerate = Period / ((7 / 100) + 1); //ยอด no vat
								var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
								var Tax = parseFloat(Period) - parseFloat(Duerate); //ภาษีต่องวด
								var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา
							}

							var percent = (Cash_Car / RatePrices) * 100;
							var YesrInterest = valinterest * 12;

							$("#Tax_Rate").val(addCommas(Tax.toFixed(2))); //ภาษี
							$("#Tax2_Rate").val(addCommas(Tax2.toFixed(2))); //ระยะผ่อน-1
							$("#Duerate_Rate").val(addCommas(Duerate.toFixed(2))); //ค่างวด
							$("#Duerate2_Rate").val(addCommas(Duerate2.toFixed(2))); //ระยะผ่อน-2

							var textdata =
								'<tr class="table-danger">' +
								'<td>' + index + ' งวด</td>' +
								'<td>' + addCommas(Period) + ' บาท</td>' +
								(flagPA == true ?
									'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
									'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
									'') +
								'</tr>'
						} else {
							var textdata =
								'<tr>' +
								'<td>' + index + ' งวด</td>' +
								'<td>' + addCommas(Period) + ' บาท</td>' +
								(flagPA == true ?
									'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
									'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
									'') +
								'</tr>'
						}
						$('#tb_showdata').fadeIn("slow").append(textdata);
					}
				} else {
					for (let index = 12; index <= 84; index = index + 6) {
						var Interest = valinterest * 12;
						var NewInterest = (Interest * (index / 12)) + 100;
						var Period = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / index) / 10) * 10;

						if (flagPA == true) {
							var TangRatePeriod = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / Timelack_Car) / 10) * 10;
							var TangRate = TangRatePeriod * Timelack_Car;

							let totalRate = TangRate;
							var Installment = `TimeRack${index}`;
							var timeRack, plan_pa, Limit_Loan, id_pa, valTime;

							for (let val of interestPA) {
								if (totalRate < interestPA[interestPA.length - 1].Limit_Insur) {
									if (val.Limit_Insur > totalRate) {
										if (typepromo[2] == 3) {
											// plus10 = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
											timeRack = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
											// timeRack = Math.ceil(plus10 / 10) * 10;
										} else {
											timeRack = val[Installment];
										}
										valTime = val[Installment];
										plan_pa = val['Plan_Insur'];
										Limit_Loan = val['Limit_Insur'];
										id_pa = val['id'];
										break;
									}
								} else {
									if (typepromo[2] == 3) {
										// plus10 = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
										timeRack = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
										// timeRack = Math.ceil(plus10 / 10) * 10;
									} else {
										timeRack = interestPA[interestPA.length - 1][Installment];
									}
									valTime = interestPA[interestPA.length - 1][Installment];
									plan_pa = interestPA[interestPA.length - 1]['Plan_Insur'];
									Limit_Loan = interestPA[interestPA.length - 1]['Limit_Insur'];
									id_pa = interestPA[interestPA.length - 1]['id'];
								}
							}

							var newRate = parseFloat(valPrice) + parseFloat(timeRack);
							var Period2 = Math.ceil(((((newRate * NewInterest) / 100) * 1.07) / index) / 10) * 10;
						}

						if (index == Timelack_Car) {
							// set value PA
							if (flagPA == true) {
								$('#Insurance_PA').val(timeRack);
								$('#Plan_PA').val(id_pa);

								sh_planPa = id_pa;
								sh_LimitLoan = addCommas(Limit_Loan);
								sh_timelack = (Math.ceil(Timelack_Car / 12));
								sh_periodPa = addCommas(timeRack);

								var show_paPlan = plan_pa;
								var show_paLimit = sh_LimitLoan;
								var show_paTime = sh_timelack;
								var show_paPeriod = sh_periodPa;
							} else {
								$('#Insurance_PA').val(0);
								$('#Plan_PA').val('');

								var show_paPlan = '',
									show_paLimit = '',
									show_paTime = '',
									show_paPeriod = '';
							}

							if (flagInPA == true) {
								var valPeriod = Period2;
								var TotalPeriod = Period2 * Timelack_Car;
								var Profit = TotalPeriod - newRate;

								var Duerate = Period2 / ((7 / 100) + 1); //ยอด no vat
								var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
								var Tax = parseFloat(Period2) - parseFloat(Duerate); //ภาษีต่องวด
								var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา
							} else {
								var valPeriod = Period;
								var TotalPeriod = Period * Timelack_Car;
								var Profit = TotalPeriod - valPrice;

								var Duerate = Period / ((7 / 100) + 1); //ยอด no vat
								var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
								var Tax = parseFloat(Period) - parseFloat(Duerate); //ภาษีต่องวด
								var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา
							}

							var percent = (Cash_Car / RatePrices) * 100;
							var YesrInterest = valinterest * 12;

							// var Duerate = valPeriod / ((7 / 100) + 1);
							// var Duerate2 = Duerate.toFixed(2) * Timelack_Car;
							// var Tax = valPeriod - Duerate;
							// var Tax2 = Tax.toFixed(2) * Timelack_Car;

							$("#Tax_Rate").val(addCommas(Tax.toFixed(2))); //ภาษี
							$("#Tax2_Rate").val(addCommas(Tax2.toFixed(2))); //ระยะผ่อน-1
							$("#Duerate_Rate").val(addCommas(Duerate.toFixed(2))); //ค่างวด
							$("#Duerate2_Rate").val(addCommas(Duerate2.toFixed(2))); //ระยะผ่อน-2

							var textdata =
								'<tr class="table-danger">' +
								'<td>' + index + ' งวด</td>' +
								'<td>' + addCommas(Period) + ' บาท</td>' +
								(flagPA == true ?
									'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
									'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
									'') +
								'</tr>'
						} else {
							var textdata =
								'<tr>' +
								'<td>' + index + ' งวด</td>' +
								'<td>' + addCommas(Period) + ' บาท</td>' +
								(flagPA == true ?
									'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
									'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
									'') +
								'</tr>'
						}
						$('#tb_showdata').fadeIn("slow").append(textdata);
					}
				}
			} else if (Loan == '16') { //ขายฝาก
				for (let index = 12; index <= 84; index = index + 6) {
					var Interest = valinterest * 12;
					var NewInterest = (Interest * (index / 12)) + 100;

					var Process = (parseFloat(valPrice)) * (parseFloat(valinterest) / 100);
					var str = Process.toString();
					var Setstring = parseInt(str.split(".", 1));
					var Period = Math.ceil(Setstring / 10) * 10;

					if (flagPA == true) {
						var Process = ((parseFloat(valPrice) * (parseFloat(NewInterest) / 100))) / Timelack_Car;
						var payR = Math.ceil(Process);
						var Period2 = Math.ceil(payR / 10) * 10;
						var TangRate = (Period2 * Timelack_Car);

						let totalRate = TangRate;
						var Installment = `TimeRack${index}`;
						var timeRack, plan_pa, Limit_Loan, id_pa, valTime;

						for (let val of interestPA) {
							if (totalRate < interestPA[interestPA.length - 1].Limit_Insur) {
								if (val.Limit_Insur > totalRate) {
									if (typepromo[2] == 3) {
										// plus10 = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
										timeRack = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
										// timeRack = Math.ceil(plus10 / 10) * 10;
									} else {
										timeRack = val[Installment];
									}
									valTime = val[Installment];
									plan_pa = val['Plan_Insur'];
									Limit_Loan = val['Limit_Insur'];
									id_pa = val['id'];
									break;
								}
							} else {
								if (typepromo[2] == 3) {
									// plus10 = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
									timeRack = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
									// timeRack = Math.ceil(plus10 / 10) * 10;
								} else {
									timeRack = interestPA[interestPA.length - 1][Installment];
								}
								valTime = interestPA[interestPA.length - 1][Installment];
								plan_pa = interestPA[interestPA.length - 1]['Plan_Insur'];
								Limit_Loan = interestPA[interestPA.length - 1]['Limit_Insur'];
								id_pa = interestPA[interestPA.length - 1]['id'];
							}
						}

						var ProcessP2 = (((parseFloat(valPrice) + parseFloat(timeRack)) * parseFloat(Interest) / 100) * (Timelack_Car / 12)) / Timelack_Car;
						var pay2 = Math.ceil(ProcessP2);
						var Period2 = Math.ceil(pay2 / 10) * 10;
					}

					if (index == Timelack_Car) {
						// set value PA
						if (flagPA == true) {
							$('#Insurance_PA').val(timeRack);
							$('#Plan_PA').val(id_pa);

							sh_planPa = id_pa;
							sh_LimitLoan = addCommas(Limit_Loan);
							sh_timelack = (Math.ceil(Timelack_Car / 12));
							sh_periodPa = addCommas(timeRack);

							var show_paPlan = plan_pa;
							var show_paLimit = sh_LimitLoan;
							var show_paTime = sh_timelack;
							var show_paPeriod = sh_periodPa;
						} else {
							$('#Insurance_PA').val(0);
							$('#Plan_PA').val('');

							var show_paPlan = '',
								show_paLimit = '',
								show_paTime = '',
								show_paPeriod = '';
						}

						if (flagInPA == true) {
							var valPeriod = Period2;
							var TotalPeriod = (parseFloat(valPrice) + parseFloat(timeRack)) + (Period2 * Timelack_Car);
							var Profit = TotalPeriod - (parseFloat(valPrice) + parseFloat(timeRack));
							var totalRate = TotalPeriod;
						} else {
							var valPeriod = Period;
							var TotalPeriod = parseFloat(valPrice) + (Period * Timelack_Car);
							var Profit = TotalPeriod - valPrice;
							var totalRate = TotalPeriod;

						}

						var YesrInterest = valinterest * 12;
						var percent = (Cash_Car / RatePrices) * 100;

						var textdata =
							'<tr class="table-danger">' +
							'<td>' + index + ' งวด</td>' +
							'<td>' + addCommas(Period) + ' บาท</td>' +
							(flagPA == true ?
								'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
								'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
								'') +
							'</tr>'
					} else {
						var textdata =
							'<tr>' +
							'<td>' + index + ' งวด</td>' +
							'<td>' + addCommas(Period) + ' บาท</td>' +
							(flagPA == true ?
								'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
								'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
								'') +
							'</tr>'
					}
					$('#tb_showdata').fadeIn("slow").append(textdata);
				}
			} else if (Loan == '02' || Loan == '03' || Loan == '11' || Loan == '17' || Loan == '04') { //เงินกู้
				for (let index = 12; index <= 84; index = index + 6) {
					var Interest = valinterest * 12;
					var NewInterest = (Interest * (index / 12)) + 100;

					var Process = (parseFloat(valPrice) + (parseFloat(valPrice) * (parseFloat(Interest) / 100) * (index / 12))) / index;
					var str = Process.toString();
					var Setstring = parseInt(str.split(".", 1));
					var Period = Math.ceil(Setstring / 10) * 10;

					if (flagPA == true) {
						var Process = ((parseFloat(valPrice) * (parseFloat(NewInterest) / 100))) / Timelack_Car;
						var payR = Math.ceil(Process);
						var Period2 = Math.ceil(payR / 10) * 10;
						var TangRate = (Period2 * Timelack_Car);

						let totalRate = TangRate;
						var Installment = `TimeRack${index}`;
						var timeRack, plan_pa, Limit_Loan, id_pa, valTime;

						for (let val of interestPA) {
							if (totalRate < interestPA[interestPA.length - 1].Limit_Insur) {
								if (val.Limit_Insur > totalRate) {
									if (typepromo[2] == 3) {
										// plus10 = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
										timeRack = Math.ceil(val[Installment] - (val[Installment] * typepromo[1]));
										// timeRack = Math.ceil(plus10 / 10) * 10;
									} else {
										timeRack = val[Installment];
									}
									valTime = val[Installment];
									plan_pa = val['Plan_Insur'];
									Limit_Loan = val['Limit_Insur'];
									id_pa = val['id'];
									break;
								}
							} else {
								if (typepromo[2] == 3) {
									// plus10 = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
									timeRack = Math.ceil(interestPA[interestPA.length - 1][Installment] - (interestPA[interestPA.length - 1][Installment] * typepromo[1]));
									// timeRack = Math.ceil(plus10 / 10) * 10;
								} else {
									timeRack = interestPA[interestPA.length - 1][Installment];
								}
								valTime = interestPA[interestPA.length - 1][Installment];
								plan_pa = interestPA[interestPA.length - 1]['Plan_Insur'];
								Limit_Loan = interestPA[interestPA.length - 1]['Limit_Insur'];
								id_pa = interestPA[interestPA.length - 1]['id'];
							}
						}

						var newRate = parseFloat(valPrice) + parseFloat(timeRack);
						var ProcessP2 = ((parseFloat(newRate) * (parseFloat(NewInterest) / 100))) / index;
						var pay2 = Math.ceil(ProcessP2);
						var Period2 = Math.ceil(pay2 / 10) * 10;
					}

					if (index == Timelack_Car) {
						// set value PA
						if (flagPA == true) {
							$('#Insurance_PA').val(timeRack);
							$('#Plan_PA').val(id_pa);

							sh_planPa = id_pa;
							sh_LimitLoan = addCommas(Limit_Loan);
							sh_timelack = (Math.ceil(Timelack_Car / 12));
							sh_periodPa = addCommas(timeRack);

							var show_paPlan = plan_pa;
							var show_paLimit = sh_LimitLoan;
							var show_paTime = sh_timelack;
							var show_paPeriod = sh_periodPa;
						} else {
							$('#Insurance_PA').val(0);
							$('#Plan_PA').val('');

							var show_paPlan = '',
								show_paLimit = '',
								show_paTime = '',
								show_paPeriod = '';
						}

						if (flagInPA == true) {
							var valPeriod = Period2;
							var TotalPeriod = Period2 * Timelack_Car;
							var Profit = TotalPeriod - newRate;
						} else {
							var valPeriod = Period;
							var TotalPeriod = Period * Timelack_Car;
							var Profit = TotalPeriod - valPrice;
						}

						var YesrInterest = valinterest * 12;
						var percent = (valPrice / RatePrices) * 100;

						var Duerate = valPeriod / ((7 / 100) + 1);
						var Duerate2 = Duerate.toFixed(2) * Timelack_Car;
						var Tax = valPeriod - Duerate;
						var Tax2 = Tax.toFixed(2) * Timelack_Car;

						var textdata =
							'<tr class="table-danger">' +
							'<td>' + index + ' งวด</td>' +
							'<td>' + addCommas(Period) + ' บาท</td>' +
							(flagPA == true ?
								'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
								'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
								'') +
							'</tr>';

					} else {
						var textdata =
							'<tr>' +
							'<td>' + index + ' งวด</td>' +
							'<td>' + addCommas(Period) + ' บาท</td>' +
							(flagPA == true ?
								'<td class="showPA">' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
								'<td class="showPA">' + addCommas(Period2) + ' บาท</td>' :
								'') +
							'</tr>'
					}
					$('#tb_showdata').fadeIn("slow").append(textdata);
				}
			}

			// checkrate LTV
			CheckRateLTV(percent, flag);

			// Data show views
			$("#ShowPercent").html(Number(percent.toFixed(0)) % Infinity || 0); //แสดง % จัดไฟแนนซ์
			$('#ShowPeriod').html(addCommas(valPeriod)); //แสดง ค่างวดต่อเดือน
			$('#ShowTotalPeriod').html(addCommas(TotalPeriod)); //แสดง ยอดทั้งสัญญา

			// data show pa view
			$('.showPlan_PA').html(show_paPlan); //แผน
			$('.capital_PA').html(show_paLimit + ' <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>'); //ทุนประกัน
			$('.periodPA').html(show_paTime + ' ปี'); //ระยะเวลาประกันภัย
			$('.periodPAtotal').html(show_paPeriod + ' <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>'); //ระยะเวลาประกันภัย

			$("#totalInterest_Car").val(valinterest.toFixed(2)); //ดอกเบี้ยรวม
			$("#InterestYear_Car").val(YesrInterest.toFixed(2)); //ดอกเบี้ยรายปี

			$("#Percent_Car").val(Number(percent.toFixed(0)) % Infinity || 0); //% จัดไฟแนนซ์
			$("#Period_Rate").val(valPeriod); //ค่างวดต่อเดือน
			$("#TotalPeriod_Rate").val(TotalPeriod); //ยอดทั้งสัญญา
			$("#Profit_Rate").val(addCommas(Profit.toFixed(2))); //กำไรจากยอดจัด

			resolve(true);
		});
	}

	async function ReferenceYearAsset(CodeLoans, typeAsset, yearAsset) {
		var type = 5;
		var Flag = 1;
		var _token = $('input[name="_token"]').val();

		// $("#Timelack_Car").val($("#Timelack_Car option:first").val());
		// $('.Show-Timelack,.Show-interest').empty();
		result = await $.ajax({
			url: "{{ route('ControlCenter.SearchData') }}",
			method: "post",
			data: {
				_token: _token,
				type: type,
				Flag: Flag,
				yearAsset: yearAsset,
				CodeLoans: CodeLoans,
				typeAsset: typeAsset
			},

			success: function(data) {
				return data;
			}
		})
		return result;
	}

	async function ReferenceTimelack(Timelack, typeAsset, yearAsset, Interest) {
		var Flag = 2;
		var Cal_id = $('#Cal_id').val();
		var _token = $('input[name="_token"]').val();

		var CodeLoans = $('#CodeLoans').val();
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');

		if (CodeLoans != '' && Cash_Car != '') {
			await $.ajax({
				url: "{{ route('ControlCenter.SearchData') }}",
				method: "post",
				data: {
					_token: _token,
					funs: 'Interest-PTN',
					Flag: Flag,
					Cal_id: Cal_id,
					yearAsset: yearAsset,
					CodeLoans: CodeLoans,
					typeAsset: typeAsset,
					Timelack: Timelack,
					Cash_Car: Cash_Car
				},

				success: await
				function(data) {
					if (data != '') {
						if (Timelack <= data.InstalmentEnd_rate) {
							$('#Show-interest').html(data.Interest_rate);
							if (Interest != '') {
								$('#Interest_Car').val(Interest); //ดึงค่าเดิมมาแสดง
							} else {
								$('#Interest_Car').val(data.Interest_rate);
							}
						} else {
							Swal.fire({
								icon: 'error',
								title: "ข้อมูลไม่ถูกต้อง",
								text: "โปรดเลือกระยะเวลาผ่อนที่สามารถจัดได้ !",
							})

							$("#Timelack_Car").val($("#Timelack_Car option:first").val());
							$('#Show-interest').empty();
						}
					} else {
						Swal.fire({
							icon: 'error',
							title: "ไม่พบข้อมูล",
							text: "ไม่พบข้อมูลระยะเวลาที่เลือกข้างต้น !",
						})

						$("#Timelack_Car").val($("#Timelack_Car option:first").val());
						$('#Show-interest').empty();
					}

					$('#Interest_Car').attr('readonly', false);
				}
			})
		} else {
			Swal.fire({
				icon: 'error',
				title: "ข้อมูลไม่ถูกต้อง",
				text: "โปรดตรวจสอบ ช่องที่ใช้ในการคำนวณให้ถูกต้อง !",
			})

			$("#Timelack_Car").val($("#Timelack_Car option:first").val());
		}
	}

	function CountDateRateLTV(countdate) {
		var _token = $('input[name="_token"]').val();
		$.ajax({
			url: "{{ route('ControlCenter.SearchData') }}",
			method: "POST",
			type: "JSON",
			async: false,
			data: {
				funs: 'cal-LTV',
				_token: _token,
				countdate: countdate
			},
			success: function(data) {
				$("#rateLTV").val(data.value_LTV);
			}
		});
	}

	function CheckRateLTV(val, flag) {
		var rateLTV = $('#rateLTV').val();
		$("#txtLTV").empty();

		if (val > rateLTV) {
			$("#showLTV").attr('style', '');
			$("#txtLTV").html('เกิน LTV <span class="badge badge-soft-danger font-size-18">' + rateLTV + ' % </span>');
			// $("#txtLTV").append('เกิน LTV ' + rateLTV + ' %');
		} else {
			$("#showLTV").attr('style', 'display:none !important');
		}

		if (flag == 'alert') {
			if (val > rateLTV) {
				Swal.fire({
					icon: 'info',
					title: "แจ้งเตือน",
					text: "เปอรเซ็นยอดจัด (LTV) เกิน " + rateLTV + "% ที่กำหนด",
					showConfirmButton: false,
					timer: 3000
				})
			}
		}
	}

	function InsurancePA() {
		var dataPA = '';
		var _token = $('input[name="_token"]').val();
		var DataTag_id = $('input[name="DataTag_id"]').val();

		$.ajax({
			url: "{{ route('ControlCenter.SearchData') }}",
			method: "POST",
			type: "JSON",
			async: false,
			data: {
				type: 9,
				_token: _token,
				DataTag_id: DataTag_id
			},
			success: function(data) {
				dataPA = data.insurPrice;
			}
		});
		return dataPA;
	}

	function getDataPA(getPA, totalRate, Installment, dataPromotion) {
		var timeRack, plan_pa, Limit_Loan, id_pa, valTime;
		var dataPA = [];
		for (let val of getPA) {
			if (totalRate < getPA[getPA.length - 1].Limit_Insur) {
				if (val.Limit_Insur > totalRate) {
					if (dataPromotion[2] == 3) {
						plus10 = Math.ceil(val[Installment] - (val[Installment] * dataPromotion[1]));
						timeRack = Math.ceil(plus10 / 10) * 10;
					} else {
						timeRack = val[Installment];
					}
					valTime = val[Installment];
					plan_pa = val['Plan_Insur'];
					Limit_Loan = val['Limit_Insur'];
					id_pa = val['id'];
					dataPA = [timeRack, plan_pa, Limit_Loan, id_pa, valTime];
					break;
				}
			} else {
				if (dataPromotion[2] == 3) {
					plus10 = Math.ceil(getPA[getPA.length - 1][Installment] - (getPA[getPA.length - 1][Installment] * dataPromotion[1]));
					timeRack = Math.ceil(plus10 / 10) * 10;
				} else {
					timeRack = getPA[getPA.length - 1][Installment];
				}
				valTime = getPA[getPA.length - 1][Installment];
				plan_pa = getPA[getPA.length - 1]['Plan_Insur'];
				Limit_Loan = getPA[getPA.length - 1]['Limit_Insur'];
				id_pa = getPA[getPA.length - 1]['id'];
				dataPA = [timeRack, plan_pa, Limit_Loan, id_pa, valTime];
			}
		}
		return dataPA;
	}

	function jsDateDiff2(strDate1, strDate2) {
		date1 = new Date(strDate1);
		date2 = new Date(strDate2);

		var one_day = 1000 * 60 * 60 * 24;
		var defDate = (date2.getTime() - date1.getTime()) / one_day;

		return defDate;
	}

	function convertDaysToYMD(days) {
		var years = Math.floor(days / 365);
		var months = Math.floor((days % 365) / 30);
		var remainingDays = days - (years * 365) - (months * 30);

		return {
			years: years,
			months: months,
			days: remainingDays
		};
	}
</script>

<script>
	async function activeData_PA(param_Pa, param_InPa) {
		if (param_Pa == true) {
			let spanElement = $('<span>');
			spanElement.addClass('text-success');
			spanElement.text('ซื้อประกัน PA');

			$('#setBuy_PA').val('yes');
			$('#showBuy_PA').prop("checked", true);
			$('#txt-Buy_PA').html(spanElement);
			$('#showInclude_PA').prop("disabled", false);

			var setparam_InPa = param_InPa;
			$('.input-Include_PA').removeClass('d-none');
			$('.showPA').removeClass('d-none');

		} else if (param_Pa == false) {
			let spanElement = $('<span>');
			spanElement.addClass('text-danger');
			spanElement.text('ไม่ซื้อประกัน PA');

			$('#setBuy_PA').val('no');
			$('#showBuy_PA').prop("checked", false);
			$('#txt-Buy_PA').html(spanElement);
			$('#showInclude_PA').prop("disabled", true);

			var setparam_InPa = param_Pa;
			$('.input-Include_PA').addClass('d-none');
			$('.showPA').addClass('d-none');
		}

		await activeData_InPa(setparam_InPa);
	}

	function activeData_InPa(param_InPa) {
		if (param_InPa == true) {
			let spanElement = $('<span>');
			spanElement.addClass('text-success');
			spanElement.text('รวมยอดประกันในสินเชื่อ');

			$('#setInclude_PA').val('yes');

			$('#txt-Include_PA').html(spanElement);
			$('#showInclude_PA').attr("required");
			$('#showInclude_PA').prop("checked", true);
		} else if (param_InPa == false) {
			let spanElement = $('<span>');
			spanElement.addClass('text-danger');
			spanElement.text('ไม่รวมยอดประกันในสินเชื่อ');

			$('#setInclude_PA').val('no');

			$('#txt-Include_PA').html(spanElement);
			$('#showInclude_PA').attr("required");
			$('#showInclude_PA').prop("checked", false);
		}
	}

	function activeProcess_Car(param_process) {
		if (param_process == true) {
			let spanElement = $('<span>');
			spanElement.addClass('text-success');
			spanElement.text('รวมค่าดำเนินการ');

			$('#StatusProcess_Car').val('yes');

			$('#txt-StatusProcess_Car').html(spanElement);
			$('#ShowStatusProcess_Car').prop("checked", true);
		} else if (param_process == false) {
			let spanElement = $('<span>');
			spanElement.addClass('text-danger');
			spanElement.text('หักค่าดำเนินการ');

			$('#StatusProcess_Car').val('no');

			$('#txt-StatusProcess_Car').html(spanElement);
			$('#ShowStatusProcess_Car').prop("checked", false);
		}
	}

	function rateprice_LTV(val) {
		var config_rate = $('#config_rate').val();
		var config_score = $('#config_score').val();
		var Credo_Score = $('#Credo_Score').val();

		if (Credo_Score > config_score) {
			$('#RatePrice_Car').val(addCommas(((config_rate / 100) * val) + parseFloat(val)));
		} else {
			$('#RatePrice_Car').val(addCommas(parseFloat(val)));
		}
	}

	function unlock_input() {
		$("#createCalculates :input").prop("readonly", false);
		$('#createCalculates select').removeClass('disabled-select');
		$('#showBuy_PA,#showInclude_PA,#ShowStatusProcess_Car').prop('disabled', false);
	}

	function lock_input() {
		$("#createCalculates :input").prop("readonly", true);
		$('#createCalculates select').addClass('disabled-select');
		$('#showBuy_PA,#showInclude_PA,#ShowStatusProcess_Car').prop('disabled', true);
	}

	function reset_value() {
		$('#Cash_Car,#Interest_Car,#Interestmore_Car').val("");
		$('#Process_Car,#Insurance,#Insurance_PA').val(0);
		$("#Timelack_Car").val($("#Timelack_Car option:first").val());
		$('#Show-Timelack,.Show-interest').empty();
		$('#Timelack_PRD').val("");

		$('#btn_InterestSelect').addClass('disabled');
		$('#Return,#Plus,#Delete').removeClass('active');
		$('#totalInterest_Car').val("");

		// show
		$("#showLTV").attr('style', 'display:none !important');
		$('#ShowPercent').html('0.0');
		$('#ShowPeriod,#ShowTotalPeriod').html('0.0');

		$('.data-show').hide();
		$('#tb_showdata').empty();

		$('#data_empty').fadeIn("slow");
		$('#data_empty').addClass('d-flex');

		// hidden input
		$('#Flag_Interest').val("");
		$('#InterestYear_Car').val("");
		$('#Percent_Car,#Period_Rate,#TotalPeriod_Rate').val("");

		$('#Tax_Rate,#Tax2_Rate').val("");
		$('#Duerate_Rate,#Duerate2_Rate,#Profit_Rate').val("");

		// set btn
		$('.showdata-result').slideUp('slow');
		$('#button-data1').prop('disabled', false);
		$("#btn_SubmitCalculate").prop("disabled", false);
	}

	function enableInputs(ratetype) {
		if (ratetype == 'land' || ratetype == 'person') {
			$('#RatePrices').attr('readonly', false).attr('required', true);
			$('#input_ratetype').addClass('d-none');
		} else {
			$('#RatePrices').attr('readonly', true).attr('required', false);
			$('#input_ratetype').removeClass('d-none');
		}
	}
</script>
