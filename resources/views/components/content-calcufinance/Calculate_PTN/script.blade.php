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

	$('#Cash_Car').on("input", () => {
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
		// var Process_Car = (parseFloat(Cash_Car) * 3) / 100;

		$("#Cash_Car").val(addCommas(Cash_Car));
		// $("#Process_Car").val(Process_Car);
	});
</script>

<script>
	$('.TypeLoans,.typeAsset,.brandAsset,.groupAsset,.yearAsset').change(function() {
		$("#Timelack_Car").val($("#Timelack_Car option:first").val());
		$('#Show-Timelack,.Show-interest').empty();
		$('#Interest_Car').val('');
	});

	$('#Timelack_Car').change(function() {
		$('.Show-interest').empty();
	});

	// $('.yearAsset').change(function() {
	//   // var Instalment = DataYearAsset();
	//   DataYearAsset().then((result) => {
	//     console.log(result);
	//   }).catch((err) => {
	//   });
	// });

	// $('.yearAsset').change(async function() {
	//   var CodeLoans = $('#CodeLoans').val();
	//   var typeAsset = $('.typeAsset').val();
	//   var yearAsset = $('.yearAsset').val();

	//   if (CodeLoans == '01') {
	//     var Instalment = await ReferenceYearAsset(CodeLoans,typeAsset,yearAsset);
	//     if (Instalment.InstalmentEnd_rate != null) {
	//       $('#Show-Timelack').append(Instalment.InstalmentEnd_rate);
	//     }else{
	//       swal({
	//         closeOnClickOutside: false,
	//         icon: "warning",
	//         title: "ไม่พบข้อมูล",
	//         text: "ไม่พบระยะเวลาผ่อนตามปีที่เลือกข้างต้น !",
	//       });
	//     }
	//   }
	// });

	$('#Timelack_Car').change(function() {
		var Timelack = $(this).val();
		var TypeLoans = $('#TypeLoans').val();
		var CodeLoans = $('#CodeLoans').val();
		var yearAsset = $(".yearAsset option:selected").text();
		var typeAsset = $('.typeAsset').val();

		if (CodeLoans == '11' || CodeLoans == '17') {
			$('#Show-interest').append(0.89);
		} else if (CodeLoans == '16') {
			$('#Show-interest').append(1.25);
		} else {
			ReferenceTimelack(Timelack, typeAsset, yearAsset);
		}
	});

	$('#Interestmore_Car').change(function() {
		if ($(this).val() != '') {
			$('#btn_InterestSelect').removeClass('disabled');
		} else {
			$('#btn_InterestSelect').addClass('disabled');
		}
	});

	$('#button-data1').click(function() {
		var CodeLoans = $('#CodeLoans').val();
		var RatePrices = $('#RatePrices').val().replace(/,/g, ''); //ราคากลาง
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
		var Timelack_Car = $('#Timelack_Car').val();
		var Interest_Car = $('#Interest_Car').val();
		var Type_Customer = $('#Type_Customer').val();
		var DateOccupiedcar = $('#DateOccupiedcar').val();
		var Buy_PA = $('#Buy_PA').val();
		var Include_PA = $('#Include_PA').val();

		var flagCheckLTV = 'alert';

		if (CodeLoans != '' && RatePrices != '' && Cash_Car != '' && Timelack_Car != '' && Interest_Car != '' && DateOccupiedcar != '') {
			if (Buy_PA != '') {
				if (Buy_PA == 'Yes') {
					if (Include_PA != '') {
						// Process table
						ProcessCalculate(CodeLoans, flagCheckLTV, Buy_PA);

						// disabled btn
						$('#button-data1').attr('disabled', true);
						$('#btn_SubmitCalculate').removeAttr('disabled');
					} else {
						Swal.fire({
							icon: 'error',
							title: "ประกัน PA",
							text: "โปรดเลือกแบบรวมราคา ของประกัน PA !",
						})
					}
				} else {
					// Process table
					ProcessCalculate(CodeLoans, flagCheckLTV, Buy_PA);

					// disabled btn
					// $('#button-data1').attr('disabled', true);
					$('#btn_SubmitCalculate').removeAttr('disabled');
				}
			} else {
				Swal.fire({
					icon: 'error',
					title: "ข้อมูลไม่ถูกต้อง",
					text: "โปรดตรวจสอบข้อมูล ประกัน PA ของลูกค้า !",
				})
			}
		} else {
			Swal.fire({
				icon: 'error',
				title: "ข้อมูลไม่ถูกต้อง",
				text: "โปรดตรวจสอบ ช่องที่ใช้ในการคำนวณให้ครบถ้วน !",
			})
		}
	});

	$('#button-Clear1').click(function() {
		// show input
		$('#Cash_Car,#Interest_Car,#Interestmore_Car').val("");

		$('#Process_Car,#Insurance,#Insurance_PA').val(0);
		$("#Timelack_Car").val($("#Timelack_Car option:first").val());

		$('#btn_InterestSelect').addClass('disabled');
		$('#Return,#Plus,#Delete').removeClass('active');
		$('#totalInterest_Car').val("");

		// show
		$("#showLTV").attr('style', 'display:none !important');
		$('#ShowPercent').val("%");
		$('#ShowPeriod,#ShowTotalPeriod').empty();
		$('#ShowPeriod,#ShowTotalPeriod').append(0.00);
		$('#tableBody').empty();

		// hidden
		$('#Flag_Interest').val("");
		$('#InterestYear_Car').val("");
		$('#Percent_Car,#Period_Rate,#TotalPeriod_Rate').val("");

		$('#Tax_Rate,#Tax2_Rate').val("");
		$('#Duerate_Rate,#Duerate2_Rate,#Profit_Rate').val("");

		// btn
		$('#button-data1').removeAttr('disabled');
		$('#btn_SubmitCalculate').attr('disabled', true);
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
		if ($("#createCalculates").valid() == true) {
			var Cal_id = $('#Cal_id').val();
			var Period_Rate = $('#Period_Rate').val();
			var data = $('#createCalculates').serialize();

			if (Cal_id != '') {
				var url = "{{ route('ControlCenter.update', 0) }}";
				var method = "PUT";
			} else {
				var url = "{{ route('ControlCenter.store') }}";
				var method = "POST";
			}

			if (Period_Rate != '') {
				$.ajax({
					url: url,
					method: method,
					dataType: 'JSON',
					data: data,
					success: function(data) {
						if (data.flag == 'success') {
							Swal.fire({
								icon: 'success',
								text: 'บันทึกข้อมูลสินเชือ เรียบร้อย. !',
								showConfirmButton: false,
								timer: 1000
							})
						} else {
							Swal.fire({
								icon: 'success',
								title: 'บันทึกล้มเหลว',
								text: "โปรดตรวจสอบความถูกต้องอีกครั้ง. !",
								showConfirmButton: false,
								timer: 1000
							})
						}

						$('#modal-xl').modal('hide');
						$(".typeLoan").val(data.datacal);
						$('.typeLoan').addClass('is-valid');

						$('.CashCarView').val(addCommas(data.Cash_Car));
						$('.Balance_Price0').val(addCommas(data.totalBalance));

						if (data.flagPage == true) {
							$('#dataExpenses_view').html(data.html);
						}
					}
				})
			} else {
				Swal.fire({
					icon: 'error',
					title: "ข้อมูลไม่ถูกต้อง",
					text: "โปรดตรวจสอบข้อมูลให้ครบถ้วนก่อนบันทึก. !",
				})
			}
		}
	});

	$('#Buy_PA').on('change', function() {
		if ($(this).val() == 'Yes') {
			CheckShowPA('Yes');
			$('#Include_PA').attr("style", "pointer-events: block;").removeClass("bg-secondary");
		} else {
			CheckShowPA('No');
			$('#Insurance_PA').val("");
			$('#Include_PA').val("");
			$('#Include_PA').attr("style", "pointer-events: none;").addClass("bg-secondary");
		}
	});

	// $('#Include_PA').on('change',function(){
	// 	var Buy_PA = $('#Buy_PA').val();                //ซื้อประกัน PA
	// 	var CodeLoans = $('#CodeLoans').val();
	//     var flagCheckLTV = 'alert';

	//     ProcessCalculate(CodeLoans, flagCheckLTV, Buy_PA);
	// });

	$('#RatePrices').on("input", () => {
		var RatePrices = $('#RatePrices').val().replace(/,/g, '');
		$("#RatePrices").val(addCommas(RatePrices));
		$("#RatePrice_Car").val(addCommas(RatePrices));
	});

	$('#Type_Customer').change(function() {
		$('#DateOccupiedcar').val("");
		$('#count-DateOccup').empty();
	});

	$('#DateOccupiedcar').change(function() {
		var Type_Customer = $('#Type_Customer').val();
		var dayOcc, countdate;
		$('#count-DateOccup').empty();

		if (Type_Customer != '') {
			dayOcc = jsDateDiff2($("#DateOccupiedcar").val(), $("#todayOcc").val());
			$('#count-DateOccup').append(dayOcc + " วัน");
			$('#NumDateOccupiedcar').val(dayOcc);

			if (Type_Customer == 'CUS-0002' || Type_Customer == 'CUS-0006' || Type_Customer == 'CUS-0008' || Type_Customer == 'CUS-0010') { //ลูกค้านายหน้าดีเด่น
				countdate = 99;
			} else {
				countdate = dayOcc;
			}
			CountDateRateLTV(countdate);

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
		var CodeLoans = $('#CodeLoans').val();
		var Timelack_Car = $('#Timelack_Car').val();
		var typeAsset = $('#showRateCartypes').val();
		var yearAsset = $('#showRateYear').val();
		var Buy_PA = $('#Buy_PA').val(); //ซื้อประกัน PA
		var flagPA;

		if (Cal_id != '') {
			var flagCheckLTV = 'null';

			if (Buy_PA != '') {
				flagPA = 'Yes';
			} else {
				flagPA = 'No';
			}

			// Process table
			CheckShowPA(flagPA);
			ProcessCalculate(CodeLoans, flagCheckLTV, flagPA);

			if (CodeLoans == '11' || CodeLoans == '17') {
				$('#Show-interest').append(0.89);
			} else {
				// get InstalmentEnd_rate (Leasing)
				// const Instalment = await ReferenceYearAsset(CodeLoans,typeAsset,yearAsset);
				// if (Instalment != '') {
				//   $('#Show-Timelack').append(Instalment.InstalmentEnd_rate);
				// }

				// get Interest_rate
				ReferenceTimelack(Timelack_Car, typeAsset, yearAsset);
			}

			// disabled btn
			$('#button-data1').attr('disabled', true);
		}
	})

	async function ProcessCalculate(Loan, flag, flagPA) {
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, ''); //ยอดจัด
		var Process_Car = $('#Process_Car').val().replace(/,/g, ''); //ค่าดำเนินการ
		var RatePrices = $('#RatePrice_Car').val().replace(/,/g, ''); //เรทจัด
		// var RatePrices = $('#RatePrices').val().replace(/,/g, '');    //ราคากลาง

		var CodeLoans = $('#CodeLoans').val();
		var Timelack_Car = $('#Timelack_Car').val();
		var Interest_Car = $('#Interest_Car').val();

		var Promotions = $('#Promotions').val();
		var typepromo = Promotions.split('/');

		var FlagInterest = $('#Flag_Interest').val();
		var Interestmore_Car = $('#Interestmore_Car').val();

		var Insurance = $('#Insurance').val(); //ประกันรถ
		var Insurance_PA = $('#Insurance_PA').val(); //ประกัน PA
		var Buy_PA = $('#Buy_PA').val(); //ซื้อประกัน PA
		var Include_PA = $('#Include_PA').val(); //รวมยอดจัด PA

		var NumDateOccup = $('#NumDateOccupiedcar').val();

		//กอล์ฟเพิ่ม
		var CheckPage = $('#CheckPage').val();
		var scoreCredo = $('#Credo_Score').val();

		
			if (parseInt(scoreCredo) > 0) {
				$('#Note_Credo').val('ใช้ Score คำนวณ');
			} else {
				$('#Note_Credo').val('ไม่ใช้ Score');
			}
		

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
		if (Buy_PA == 'Yes') {
			var interestPA = InsurancePA();
			$('#Include_PA').attr("style", "pointer-events: block;").removeClass("bg-secondary");
		} else {
			$('#Include_PA').attr("style", "pointer-events: none;").addClass("bg-secondary");
		}

		// set LTV
		if (flag != 'alert') {
			if (NumDateOccup != '') {
				CountDateRateLTV(NumDateOccup);
			}
		}

		$('#ShowPeriod,#ShowTotalPeriod,#ShowPercent').empty();
		$('#tableBody').empty();

		if (Loan == '01') { //เช่าซื้อ
			for (let index = 12; index <= 84; index = index + 6) {
				var Interest = valinterest * 12;
				var NewInterest = (Interest * (index / 12)) + 100;
				var Period = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / index) / 10) * 10;

				if (Buy_PA == 'Yes') {
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
					if (Include_PA == "Yes") {
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

					// set value PA
					if (Buy_PA == 'Yes') {
						$('#Insurance_PA').val(timeRack);
						$('#Plan_PA').val(id_pa);
					} else {
						$('#Insurance_PA').val(0);
						$('#Plan_PA').val('');
					}

					var textdata =
						'<tr class="bg-orange">' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				} else {
					var textdata =
						'<tr>' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				}
				$('#tableBody').append(textdata);
			}
		} else if (Loan == '16') { //ขายฝาก
			for (let index = 12; index <= 84; index = index + 6) {
				var Interest = valinterest * 12;
				var NewInterest = (Interest * (index / 12)) + 100;

				var Process = (parseFloat(valPrice)) * (parseFloat(valinterest) / 100);
				var str = Process.toString();
				var Setstring = parseInt(str.split(".", 1));
				var Period = Math.ceil(Setstring / 10) * 10;

				if (Buy_PA == 'Yes') {
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
					if (Include_PA == "Yes") {
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

					// set value PA
					if (Buy_PA == 'Yes') {
						$('#Insurance_PA').val(timeRack);
						$('#Plan_PA').val(id_pa);
					} else {
						$('#Insurance_PA').val(0);
						$('#Plan_PA').val('');
					}

					var textdata =
						'<tr class="bg-orange">' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				} else {
					var textdata =
						'<tr>' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				}
				$('#tableBody').append(textdata);
			}
		} else if (Loan == '02' || Loan == '03' || Loan == '11' || Loan == '17') { //เงินกู้
			for (let index = 12; index <= 84; index = index + 6) {
				var Interest = valinterest * 12;
				var NewInterest = (Interest * (index / 12)) + 100;

				var Process = (parseFloat(valPrice) + (parseFloat(valPrice) * (parseFloat(Interest) / 100) * (index / 12))) / index;
				var str = Process.toString();
				var Setstring = parseInt(str.split(".", 1));
				var Period = Math.ceil(Setstring / 10) * 10;

				if (Buy_PA == 'Yes') {
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
					if (Include_PA == "Yes") {
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

					// set value PA
					if (Buy_PA == 'Yes') {
						$('#Insurance_PA').val(timeRack);
						$('#Plan_PA').val(id_pa);
					} else {
						$('#Insurance_PA').val(0);
						$('#Plan_PA').val('');
					}

					var textdata =
						'<tr class="bg-orange">' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				} else {
					var textdata =
						'<tr>' +
						'<td>' + index + ' งวด</td>' +
						'<td>' + addCommas(Period) + ' บาท</td>' +
						(flagPA == 'Yes' ?
							'<td>' + plan_pa + ' ทุน ' + addCommas(Limit_Loan) + ' บาท</td>' +
							'<td>' + addCommas(Period2) + ' บาท</td>' :
							'') +
						'</tr>'
				}
				$('#tableBody').append(textdata);
			}
		}

		// checkrate LTV
		CheckRateLTV(percent, flag);

		// Data show views
		$('#ShowPeriod').append(addCommas(valPeriod)); //แสดง ค่างวดต่อเดือน
		$('#ShowTotalPeriod').append(addCommas(TotalPeriod)); //แสดง ยอดทั้งสัญญา
		$("#ShowPercent").val(Number(percent.toFixed(0)) % Infinity || 0); //แสดง % จัดไฟแนนซ์

		$("#totalInterest_Car").val(valinterest.toFixed(2)); //ดอกเบี้ยรวม
		$("#InterestYear_Car").val(YesrInterest.toFixed(2)); //ดอกเบี้ยรายปี

		$("#Period_Rate").val(valPeriod); //ค่างวดต่อเดือน
		$("#TotalPeriod_Rate").val(TotalPeriod); //ยอดทั้งสัญญา
		$("#Percent_Car").val(Number(percent.toFixed(0)) % Infinity || 0); //% จัดไฟแนนซ์
		$("#Profit_Rate").val(addCommas(Profit.toFixed(2))); //กำไรจากยอดจัด
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

	function ReferenceTimelack(Timelack, typeAsset, yearAsset) {
		var type = 5;
		var Flag = 2;
		var Cal_id = $('#Cal_id').val();
		var _token = $('input[name="_token"]').val();

		var CodeLoans = $('#CodeLoans').val();
		var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');

		if (CodeLoans != '' && Cash_Car != '') {
			$.ajax({
				url: "{{ route('ControlCenter.SearchData') }}",
				method: "post",
				data: {
					_token: _token,
					type: type,
					Flag: Flag,
					Cal_id: Cal_id,
					yearAsset: yearAsset,
					CodeLoans: CodeLoans,
					typeAsset: typeAsset,
					Timelack: Timelack
				},

				success: function(data) {
					if (data != '') {
						if (Timelack <= data.InstalmentEnd_rate) {
							$('#Show-interest').append(data.Interest_rate);
							$('#Interest_Car').val(data.Interest_rate);
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
				type: 10,
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
			$("#txtLTV").append('เปอรเซ็นยอดจัด (LTV) เกิน ' + rateLTV + '%');
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

		$.ajax({
			url: "{{ route('ControlCenter.SearchData') }}",
			method: "POST",
			type: "JSON",
			async: false,
			data: {
				type: 9,
				_token: _token
			},
			success: function(data) {
				dataPA = data.insurPrice;
			}
		});
		return dataPA;
	}

	function CheckShowPA(val) {
		if (val == 'Yes') {
			$('.showPA').removeClass('d-none');
		} else {
			$('.showPA').addClass('d-none');
		}
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

	// function rateprice_LTV(val){

	//   var config_rate = $('#config_rate').val();
	//   var config_score = $('#config_score').val();
	//   var Credo_Score = $('#Credo_Score').val();

	//   if (Credo_Score > config_score) {
	//     $('#RatePrice_Car').val(addCommas(((config_rate/100)*val) + parseFloat(val)));
	//   }else{
	//     $('#RatePrice_Car').val(addCommas(parseFloat(val)));
	//   }
	// }
</script>
