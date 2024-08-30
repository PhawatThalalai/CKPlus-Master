<script>

    $(function(){
        let checkCase = $('#checkCase').val()
        let FlagPage = $('#FlagPage').val()
        if(FlagPage != 'Y'){ // ตอนคำนวนหน้า Tags
            if(checkCase.toLowerCase() == 'normal'){
                $('#pills-specialCase input, #pills-specialCase select').prop('disabled', true);
                $('#pills-normalCase input, #pills-normalCase select').prop('disabled', false);

            }else if(checkCase.toLowerCase() == 'balloon'){
                $('#pills-normalCase input, #pills-normalCase select').prop('disabled', true);
                $('#pills-specialCase input, #pills-specialCase select').prop('disabled', false);


            }else{
                $('#pills-specialCase input, #pills-specialCase select').prop('disabled', true);
                $('#pills-normalCase input, #pills-normalCase select').prop('disabled', false);
                console.log(111);
            }

        }else{
            $('#pills-specialCase input, #pills-specialCase select').prop('disabled', true);
            $('#pills-normalCase input, #pills-normalCase select').prop('disabled', false);
        }


    })

    $('#specialCase #Cash_Car').on("input",()=>{
        let RatePrices = parseFloat($('#RatePrices').val().replace(/,/g, ''))
        let Cash_Car = parseFloat($('#specialCase #Cash_Car').val().replace(/,/g, ''))
        let per = ((Cash_Car / RatePrices) * 100).toFixed(0)

        $('.ShowRateLTVSpecial').html(per)


        $('#hiddenSpecialCase #LTVRate').val(per)
        $('#hiddenSpecialCase #Percent_Car').val(per)

    })

    $('#specialCase #InterestYear_Car').on("input",()=>{
        let InterestYear_Car = parseFloat($('#specialCase #InterestYear_Car').val())
        $('#specialCase #Interest_Car').val((InterestYear_Car / 12).toFixed(2))
    })

    calculateSpecialCase = async () =>{
        let CodeLoans = $('#CodeLoans').val()
        let Cash_Car = parseFloat($('#specialCase #Cash_Car').val().replace(/,/g, ''))
        let InstallmentsWant = parseFloat($('#specialCase #InstallmentsWant').val().replace(/,/g, '')) // ยอดผ่อนที่ต้องการ
        let Timelack_Car = parseInt($('#specialCase #Timelack_Car').val())
        let StatusProcess_Car =  $('#specialCase #StatusProcess_Car').val()
        let Process_Car =  parseFloat($('#specialCase #Process_Car').val()) || 0
        let Interest_Car =  $('#specialCase #Interest_Car').val()
        let InterestYear_Car =  parseFloat($('#specialCase #InterestYear_Car').val())
        let totalInterest_Car =  parseFloat($('#specialCase #Interest_Car').val())

        let Buy_PA =  $('#specialCase #Buy_PA').val()
        let Include_PA =  $('#specialCase #Include_PA').val()
        let getPA = parseFloat($('#hiddenSpecialCase #Insurance_PA').val())
        let topup = 0

        if(StatusProcess_Car.toLowerCase() == 'yes'){
            topup+=Process_Car
            $('#specialCase #Process_Car').prop('readonly',false)
        }else{
            topup+=0
            $('#specialCase #Process_Car').val(0).prop('readonly',true)
        }

        if(Buy_PA.toLowerCase() == 'no'){
            $('#specialCase #Include_PA').prop('disabled',true).css('pointer-events','none')
        } else{
            $('#specialCase #Include_PA').prop('disabled',false).css('pointer-events','')
        }

        if(Buy_PA.toLowerCase() == 'yes' && Include_PA.toLowerCase() == 'yes'){
            topup += getPA
        }else{
            topup += 0
        }


            var Duerate = 0; //ยอด no vat
            var Duerate2 = 0; //ยอดทั้งสัญญา no vat
            var Tax = 0; //ภาษีต่องวด
            var Tax2 = 0; //ภาษีทั้งสัญญา


        let totalInstallments = Math.ceil(((Cash_Car + topup) * (100 + InterestYear_Car)) / 100) // ยอดทั้งสัญญา
        if(CodeLoans == '01'){
             totalInstallments = Math.ceil( (((Cash_Car + topup) * (100 + InterestYear_Car)) / 100) * 107 / 100 )

            var Duerate = (parseFloat(InstallmentsWant) * 100) / 107; //ยอด no vat
            var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
            var Tax = parseFloat(InstallmentsWant) - parseFloat(Duerate); //ภาษีต่องวด
            var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา

        }
        var Profit = totalInstallments - (Cash_Car + topup);




        let result = {
            "topup" : topup,
            "Cash_Car" : Cash_Car + topup,
            "InterestYear_Car" : InterestYear_Car,
            "totalInstallments" : totalInstallments,
            "InstallmentsWant" : InstallmentsWant,
            "LastPay" : totalInstallments - ( InstallmentsWant * (Timelack_Car - 1)),
            "Duerate" : Duerate,
            "Duerate2" : Duerate2,
            "Tax" : Tax,
            "Tax2" : Tax2,
            "Profit" : Profit,
            "totalInterest_Car" : totalInterest_Car
        }

        console.log("result" , result);


      $('#specialCase #totalInstallments').val(totalInstallments)
      $('#ShowPeriod').html(InstallmentsWant.toLocaleString())
      $('#ShowTotalPeriod').html(totalInstallments.toLocaleString())
      $('#ShowOPR').html(Process_Car.toLocaleString())
      $('#viewCommision').html(0.00)


      $('#hiddenSpecialCase #Tax_Rate').val(result.Tax)
      $('#hiddenSpecialCase #Tax2_Rate').val(result.Tax2)
      $('#hiddenSpecialCase #Duerate_Rate').val(result.InstallmentsWant)
      $('#hiddenSpecialCase #Period_Rate').val(result.InstallmentsWant)
      $('#hiddenSpecialCase #Duerate2_Rate').val(result.Duerate2)
      $('#hiddenSpecialCase #Profit_Rate').val(result.Profit)
      $('#hiddenSpecialCase #totalInterest_Car').val(result.totalInterest_Car)
      $('#hiddenSpecialCase #Commissions').val()
      $('#hiddenSpecialCase #SumTotalPeriod').val(result.totalInstallments)


       await callPa(totalInstallments,Timelack_Car)
        let text = ''
        for(let i = 1 ; i<= Timelack_Car ; i++){
            text +=
            `<tr>
                <th>${i}</th>
                <td>${(Cash_Car + topup).toLocaleString()}</td>
                <td>${result.InterestYear_Car}</td>
                <th>${i == Timelack_Car ? result.LastPay.toLocaleString() :result.InstallmentsWant.toLocaleString()}</th>
            </tr>`
        }
        $('#TB-InstallmentSpecials').html(text)

        let data = {};
            $('#form-Calculates').serializeArray().map(function(x) {
                data[x.name] = x.value;
            });

            console.log(data);


        let Credo_Score = $('#Credo_Score').val()
        if(Credo_Score > 0){
            $('#hiddenSpecialCase #Note_Credo').val('ใช้ Score คำนวณ')
        }else{
            $('#hiddenSpecialCase #Note_Credo').val('ไม่ใช้ Score')
        }


    }

    callPa = (totalInstallments,Timelack_Car) => {
        return $.ajax({
            url : '{{ route('ControlCenter.SearchData') }}',
            type : 'GET',
            data : {
                type : 'getInsurance',
                totalInstallments : totalInstallments,
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res) => {
                var prop = 'TimeRack'+Timelack_Car
                console.log(res.insuranceData);
                $('.showPlan_PA').html(res.insuranceData.Plan_Insur)
                $('.capital_PA').html(res.insuranceData.Limit_Insur)
                $('.TimeLackPA').html(Timelack_Car / 12)
                $('.periodPAtotal').html(res.insuranceData[prop])
                $('#hiddenSpecialCase #Insurance_PA').val(res.insuranceData[prop])
                $('#hiddenSpecialCase #PlanID').val(res.insuranceData.PlanId)


            },
            error : (err) => {
                console.log(err);
            }

        })

    }



     disableDuplicateIDs = (divId , divIdunlock) => {

            if(divIdunlock == '#pills-specialCase'){
                $('.Note_Cal').val('Balloon')
                $(`${divIdunlock} input[type=text]:not(.Note_Cal)`).val('')
                $(divIdunlock + ' select').val('').find('option :eq(0)').attr('selected', true)
                $('#TB-InstallmentSpecials').empty()

            }else{
                $('.Note_Cal').val('Normal')
                $(`${divIdunlock} input[type=text]:not(.Note_Cal)`).val('')
                $(divIdunlock + ' select').val('').find('option :eq(0)').attr('selected', true)
                $('#content-table').empty()
            }

            $(`${divId} input`).prop('disabled', true);
            $(`${divId} select`).prop('disabled', true);

            $(`${divIdunlock} input`).prop('disabled', false);
            $(`${divIdunlock} select`).prop('disabled', false);





    }



</script>
