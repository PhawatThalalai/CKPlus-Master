<script>

  $(function() {
    var Type_Customer =  $("#Type_Customer").val();
    var Cal_id = $("#Cal_id").val();
    var code = $(".TypeLoans option:selected").text().split('-');
      var result = code[0].trim();
    if($('#buyPA').val()=='yes'){
      $('#selectPA').attr("style", "pointer-events: block;").removeClass("bg-light");
    }else{
      $('#selectPA').attr("style", "pointer-events: none;").addClass("bg-light");
    }

    if(Cal_id!='' && Type_Customer !="" && code !="" ){
     //calculateRate();
      //getDataRate();
    }
//
    if(Type_Customer=="CUS-0006"||Type_Customer=="CUS-0012"){
      $("#Cus_grade").removeAttr("disabled");
      $("#Cus_grade").attr("required", "true");
      $("#Payment_Due").removeAttr("disabled");
      $("#Payment_Due").attr("required", "true");
      if(Type_Customer=="CUS-0012"){
         $("#Interest_old").removeAttr("disabled");
        $("#Interest_old").attr("required", "true");
        $("#DateOldCon").removeAttr("disabled");
        $("#DateOldCon").attr("required", "true");
        $("#Contract_old").removeAttr("disabled");
        $("#Contract_old").attr("required", "true");
      }

    }
    if($("#TypeLoans").val()=="car"){
      //  $('#Insurance').removeAttr('readonly');
        $(".ratePrice").prop('readonly', true);
        $('.showGear').show();
      }else if($("#TypeLoans").val()=="moto"){
        $(".ratePrice").prop('readonly', true);
        $('.showGear').hide();
      }else{
       // $('#Insurance').prop('readonly', true);
        $(".ratePrice").removeAttr("readonly");
        $(".ratePrice").attr("required", "true");
      }


    if(Type_Customer=="CUS-0009"){
      $("#time_normal").hide();
      $("#time_debt").show();
      $("#Timelack_Car2").attr("required", "true");

    }else{
      $("#time_debt").hide();
      $("#time_normal").show();
      $("#Timelack_Car").attr("required", "true");
    }


      $('#CodeLoans').val(result);
      var landCode = ['15','16'];
        if($("#TypeLoans").val()=="person"){
          $('.rate_price,.Occ_status').hide();
          $("#TypeAssetsPoss").removeAttr("required");
        }else{
          $('.rate_price,.Occ_status').show();
        }
        if(landCode.includes(result)==true){
          $('#ShowLand').show();
        }else{
          $('#ShowLand').hide();
        }
      if($("#TypeAssetsPoss").val()=="รถรีไฟแนนซ์"){
        $("#Payment_Status").removeAttr("disabled");
      }


  });
    //จำนวนวันครอบครอง

    function jsDateDiff2(strDate1, strDate2) {
      date1 = new Date(strDate1);
      date2 = new Date(strDate2);

      var one_day = 1000 * 60 * 60 * 24;
      var defDate = (date2.getTime() - date1.getTime()) / one_day;

      return defDate;
    }


    $("#DateOccupiedcar,#Cus_grade,#Payment_Status").on('change', function(){
      $('#interest_sql').val('');
      $('#Cash_Car').val('');
      getDataRate();
    });

    function getDataRate() {
      $("#save").attr('disabled', true);
      $('#Occ').empty();
      var dayOcc = jsDateDiff2($("#DateOccupiedcar").val() ,$("#todayOcc").val());
      var dayOccOld = jsDateDiff2($("#DateOccupiedcar").val() ,$("#DateOldCon").val());

      $("#NumDateOccupiedcar").val(dayOcc);
      $('#Occ').append(dayOcc);
      var TypeLoans =  $('#CodeLoans').val();
      var TypeLoans2 =$("#TypeLoans").val();
      var Type_Customer = $('#Type_Customer').val();
      var TypeAssetsPoss = $('#TypeAssetsPoss').val();
      var typeAsset = $('.typeAsset').val();
      var numDateOccupiedcar = dayOcc;
      var GetRatePrices = $('#RatePrices').val();           //ราคากลาง
      var RatePrices = GetRatePrices.replace(/,/g, '');
      var cus_grade = $('#Cus_grade').val();
      var Payment_Status = $('#Payment_Status').val();
      var _token = $('input[name="_token"]').val();
      var scoreCredo = $('#Credo_Score').val();
      var valueTime = $('#valueTime').val();
      var yearAsset = $(".yearAsset").val();
      var DateOldCon = dayOccOld
      var Interest_old = $("#Interest_old").val();
      var Interest_sql = $('#interest_sql').val();
      var CheckPage = $('#CheckPage').val();
      $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
      $.ajax({
                  url: "{{ route('ControlCenter.SearchData') }}",
                  method: "POST",
                  type:"JSON",
                  data: {
                    funs:'CalKB',
                    Flagtag: 1,
                    TypeLoans: TypeLoans,
                    Type_Customer: Type_Customer,
                    typeAsset:typeAsset,
                    yearAsset:yearAsset,
                    DateOldCon:DateOldCon,
                    Interest_old:Interest_old,
                    TypeAssetsPoss: TypeAssetsPoss,
                    numDateOccupiedcar: numDateOccupiedcar,
                    cus_grade:cus_grade,
                    Payment_Status:Payment_Status,
                    _token: _token
                  },

                  success: function(data) {
                    console.log(data);
                    if(data[1]==0 && TypeLoans!="17"){
                        swal.fire({
                          text : "ไม่อยู่ในเงื่อนไขที่บริษัทกำหนดโปรด สอบถาม (ุผู้จัดการ). !",
                          icon: "warning",
                          timer: 5000,
                        })
                        $("#save").attr('disabled','disabled');
                    }else{

                        if(parseInt(scoreCredo)>0){
                        $('#Note_Credo').val('ใช้ Score คำนวณ');
                        }else{
                          $('#Note_Credo').val('ไม่ใช้ Score');
                        }

                      // if(parseInt(scoreCredo)>parseInt(data[5])){
                      //   ltv = (parseInt(data[0])+parseInt(data[6]));

                      // }else{
                        ltv = data[0];
                      //}
                     // console.log(ltv);
                     if(data[9]!=3){
                        var calrate = (parseFloat(RatePrices)*parseInt(ltv))/ 100;
                        if(calrate>data[8]){
                          var priceLoan =data[8];
                        }else{
                          var priceLoan =calrate;
                        }

                      }else{
                        var priceLoan = data[8];
                      }

                      $('#Timelack_Car option:not(:first)').remove();
                      $('#Process').empty();

                      //$('#Percent_Car').val(data[0]);
                      $('#RatePrice_Car').val((priceLoan.toLocaleString()));
                      // if(Interest_sql==""){
                      //     if(yearAsset<2000 && TypeLoans2=="car" ){
                      //     $('#Interest_Car').val('1');
                      //   }else{
                      $('#Interest_Car').val(data[1]);
                      $('#intRatesql').val(data[1]);

                      //   }
                      // }
                      $('#Flag_Interest').val(data[10]);
                      console.log(data[10]);

                      $('.chkIncome').val(data[2]);
                      $('.guarantee').val(data[3]);
                      if(TypeLoans2!="person"){
                        $('#Process_Rate').val(data[4]);
                        $('#Process').append(data[4].toFixed(2));
                      }else{
                        $('#Process_Rate').val(0);
                        $('#Process').append(0);
                      }

                      $('#Loan_Group').val(data[9]);

                      $('#max_timelack').val(data[7]);

                      for (var i = 12; i <= data[7]; i=i+6) {

                           $('#Timelack_Car').append($('<option/>').attr("value", i).text(i+ ' งวด'));
                         }

                        var $option = $('#Timelack_Car').children('option[value="'+ valueTime +'"]').attr('selected', true);
                    }
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                  }
                });
    };

    $('#Type_Customer').on('change',function(){
      $("#save").attr('disabled', true);
      var Type_Customer =  $("#Type_Customer").val();
      var TypeLoansCode = $("#TypeLoans option:selected").text();
      var loanCode = TypeLoansCode.split(" - ");
      $("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
      $('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
      $('.chkIncome,.guarantee').val('');
      //
      if(Type_Customer=="CUS-0006"||Type_Customer=="CUS-0012"){
        $("#Cus_grade").removeAttr("disabled");
        $("#Cus_grade").attr("required", "true");

        $("#Payment_Due").removeAttr("disabled");
        $("#Payment_Due").attr("required", "true");
      if(Type_Customer=="CUS-0012"){
         $("#Interest_old").removeAttr("disabled");
        $("#Interest_old").prop("required", true);
        $("#DateOldCon").removeAttr("disabled");
        $("#DateOldCon").prop("required", true);
        $("#Contract_old").removeAttr("disabled");
        $("#Contract_old").prop("required", true);
      }else{
        $("#Interest_old").prop("disabled",true);
        $("#Interest_old").removeAttr("required");
        $("#DateOldCon").prop("disabled",true);
        $("#DateOldCon").removeAttr("required");
        $("#Contract_old").prop("disabled",true);
        $("#Contract_old").removeAttr("required");
      }

    }else{
        $("#Interest_old").prop("disabled",true);
        $("#Interest_old").removeAttr("required");
        $("#DateOldCon").prop("disabled",true);
        $("#DateOldCon").removeAttr("required");
        $("#Contract_old").prop("disabled",true);
        $("#Contract_old").removeAttr("required");

        $("#Cus_grade").removeAttr("required");
        $("#Cus_grade").prop("disabled",true);

        $("#Payment_Due").removeAttr("required");
        $("#Payment_Due").prop("disabled",true);

      }


      if(Type_Customer=="CUS-0009"){
        $("#time_normal").hide();
        $("#time_debt").show();
        $("#Timelack_Car2").attr("required", "true");

      }else{
        $("#time_debt").hide();
        $("#time_normal").show();
        $("#Timelack_Car").attr("required", "true");
      }


    });

//,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar
   $('#TypeLoans').on('change',function(){
    $("#save").attr('disabled', true);
      var TypeLoansCode = $("#TypeLoans option:selected").text();
      var Type_Customer =  $("#Type_Customer").val();
      var loanCode = TypeLoansCode.split(" - ");
      $("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
      $('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
      $('.chkIncome,.guarantee').val('');
      $('#Occ').empty();
      $('#CodeLoans').val(loanCode[0]);
      $('.typeAsset').empty();
      var landCode = ['15','16','18'];
      if($("#TypeLoans").val()=="person"){
        $('.rate_price,.Occ_status').hide();
        $("#TypeAssetsPoss").removeAttr("required");
      }else{
        $('.rate_price,.Occ_status').show();
      }

      if($("#TypeLoans").val()=="car"){
      //  $('#Insurance').removeAttr('readonly');
        $(".ratePrice").prop('readonly', true);
        $('.showGear').show();
      }else if($("#TypeLoans").val()=="moto"){
        $(".ratePrice").prop('readonly', true);
        $('.showGear').hide();
      }else{
    //    $('#Insurance').prop('readonly', true);
        $(".ratePrice").removeAttr("readonly");
        $(".ratePrice").attr("required", "true");
      }

    //
      if(Type_Customer=="CUS-0006"||Type_Customer=="CUS-0008"||Type_Customer=="CUS-0012"){
      if(Type_Customer=="CUS-0012"){
         $("#Interest_old").removeAttr("disabled");
        $("#Interest_old").prop("required", true);
        $("#DateOldCon").removeAttr("disabled");
        $("#DateOldCon").prop("required", true);
        $("#Contract_old").removeAttr("disabled");
        $("#Contract_old").prop("required", true);
      }else{
        $("#Interest_old").prop("disabled",true);
        $("#Interest_old").removeAttr("required");
        $("#DateOldCon").prop("disabled",true);
        $("#DateOldCon").removeAttr("required");
        $("#Contract_old").prop("disabled",true);
        $("#Contract_old").removeAttr("required");
      }

    }else{
        $("#Interest_old").prop("disabled",true);
        $("#Interest_old").removeAttr("required");
        $("#DateOldCon").prop("disabled",true);
        $("#DateOldCon").removeAttr("required");
        $("#Contract_old").prop("disabled",true);
        $("#Contract_old").removeAttr("required");
      }

      if(landCode.includes(loanCode[0])==true){
        $('#ShowLand').show();
      }else{
        $('#ShowLand').hide();
      }

   });



    $('#price,#price_2').on("input", function () {
      var Getprice = document.getElementById('price').value;
      var Setprice = Getprice.replace(",", "");

      var Getprice_2 = document.getElementById('price_2').value;
      var Setprice_2 = Getprice_2.replace(",", "");

      $("#price").val((Setprice));
      $("#price_2").val((Setprice_2));
    });
    $('#TypeAssetsPoss').change(function(){
      var TypeAssetsPoss = $('#TypeAssetsPoss').val();
      if(TypeAssetsPoss=="รถรีไฟแนนซ์"){
        $("#Payment_Status").removeAttr("disabled");
      }else{
        $("#Payment_Status").val('');
        $("#Payment_Status").attr('disabled', 'disabled');
      }
    });
    $('#Cash_Car').keyup(function(){
      $("#save").attr('disabled', true);
      var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
      var GetRatePrice_Car = $('#RatePrice_Car').val().replace(/,/g, '');
      var Process_Rate = $('#Process_Rate').val();
      var CodeLoans = $('#CodeLoans').val();
      var RatePrices = $('#RatePrices').val().replace(/,/g, '');
      $('#showRate').empty();
      $('#showRateLTV').empty();

      if(GetRatePrice_Car>0){
        var Percent_Car =  (parseFloat(Cash_Car)/parseFloat(GetRatePrice_Car))*100;
      }else{
        var Percent_Car = 0;
      }

      if(RatePrices>0){
        var ltvRate = (parseFloat(Cash_Car)/parseFloat(RatePrices))*100;
      }else{
        var ltvRate = 0;
      }

      $('#ltvRate').val(ltvRate.toFixed(0));

      $('#Percent_Car').val(Percent_Car.toFixed(0));

        $('#showRate').append(Percent_Car.toFixed(0)+'%');

        $('#showRateLTV').append(ltvRate.toFixed(0)+'%');
      var Process_Car1 =Math.ceil((parseFloat(Cash_Car)*Process_Rate)/100);
      var land = ['04','10','13','15','16','18'];

      if(land.includes(CodeLoans)==true){
        var Process_Car = Process_Car1;
      }else{
        var Process_Car = Math.floor(Process_Car1/100)*100;
      }

      calint();

      $('#Process_Car').val(Process_Car.toFixed(0));
       if(parseFloat(Cash_Car)>parseFloat(GetRatePrice_Car)||ltvRate>70){
        Swal.fire({
          icon: 'warning',
          title: "การแจ้งเตือน",
          text: "กรุณาตรวจสอบยอดจัด",
          allowOutsideClick : true
        })
       }
    });
    $('#buyPA').on('change',function(){
      if($('#buyPA').val()=='yes'){
        $('#selectPA').attr("style", "pointer-events: block;").removeClass("bg-light");
        $("#selectPA").attr("required", "true");
        $('.viewPA').show();
      }else{
        $('#selectPA').attr("style", "pointer-events: none;").addClass("bg-light");
        $('#selectPA').removeAttr('required');
        $('#selectPA').val('');
        $('.viewPA').hide();
      }
      calculateRate();
    });
    // $('#selectPA,#Promotions').on('change',function(){
    //   calculateRate();
    // });
    $('#button-data1').click(function(){
      //getDataRate();
      calculateRate();
      $("#save").removeAttr('disabled');
    });

    function calint(){
      var RatePrices = $('#RatePrices').val().replace(/,/g, '');
      var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
      var Type_Customer = $('#Type_Customer').val();
      var Vehicle_Year = $('#Vehicle_Year').val();
      //var RateBrands = $('#RateBrands').val();
      var RateBrands = $("#RateBrands option:selected").text();
      var TypeLoans = $('#TypeLoans').val();
      var Interest_Car = $('#intRatesql').val();
      var CodeLoans = $('#CodeLoans').val();
      var typloan = ['04','15'];
      var Flag_Interest  = $('#Flag_Interest').val();
      var newIntRate = 0;
      var ltvRate=0;
        ltvRate = (parseFloat(Cash_Car)/parseFloat(RatePrices));

        console.log(parseFloat(Cash_Car),parseFloat(RatePrices));
      if(Flag_Interest=='yes' && (TypeLoans=='car' || TypeLoans=='moto')){
        $('#Interest_Car').val('');
        var listBrand = ["TOYOTA", "HONDA", "ISUZU",  "MITSUBISHI",  "YAMAHA",  "HINO"];

        //เช็ต
        console.log(TypeLoans);
          if(listBrand.includes(RateBrands)==false && (TypeLoans=='car' || TypeLoans=='moto')){
            newIntRate = newIntRate+0.04;
            console.log('brand : '+newIntRate);
          }

          if(Type_Customer=='CUS-0001'){
            newIntRate = newIntRate+0.02;
            console.log('Cus : '+newIntRate);
          }

          if(ltvRate>0.6){
            newIntRate = newIntRate+((ltvRate.toFixed(2)-0.6)*0.35);
            console.log('ltv :'+(ltvRate.toFixed(2)-0.6)*0.35,ltvRate.toFixed(2));
          }

          if(2024-parseFloat(Vehicle_Year)>=0){
            newIntRate = newIntRate+(((2024-parseFloat(Vehicle_Year))/10)*0.02);
          }

          $('#Interest_Car').val((parseFloat(newIntRate)+parseFloat(Interest_Car)).toFixed(3));
          $("#totalInterest_Car").val((parseFloat(newIntRate)+parseFloat(Interest_Car)).toFixed(3));
      }

      if(TypeLoans=='land' && typloan.includes(CodeLoans) == true ){
        $('#Interest_Car').val('');
        if(ltvRate>1){
            newIntRate = 0.85;
          }else{
            newIntRate =Interest_Car;
          }
          $('#Interest_Car').val(parseFloat(newIntRate));
          $("#totalInterest_Car").val(parseFloat(newIntRate));
      }


    }

    function calculateRate() {
      $("#save").attr('disabled', true);
      var Type_Customer = $('#Type_Customer').val();
      var CodeLoans = $('#CodeLoans').val();
      var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
      var Process_Car = $('#Process_Car').val().replace(/,/g, '');
     // var Insurance = $('#Insurance').val().replace(/,/g, '');
      var _token = $('input[name="_token"]').val();
      var selectPA= $('#selectPA').val();
      var Promotions = $('#Promotions').val();
      var buyPA = $('#buyPA').val();
      var StatusProcess_Car = $('#StatusProcess_Car').val();
      var Limit_Insur = $('#Limit_Insur').val();
      var Process_carnew = 0;
      var dataPromotion = Promotions.split('/');
      var sumLimit_Insur = 0;
      $('.showPlan_PA').empty();
      $('.capital_PA').empty();
      $('.periodPA').empty();
      $('.periodPAtotal').empty();
      var DataTag_id =$('#DataTag_id').val();


      if(Process_Car==0){
        $('#Process_CarErr').append('ค่าดำเนินการเท่ากับ 0');
      }else{
        $('#Process_CarErr').empty();
      }

      if(Type_Customer=="CUS-0009"){
        var Timelack_Car = $('#Timelack_Car2').val();
        var time_for = Timelack_Car;
      }else{
        var Timelack_Car = $('#Timelack_Car').val();
        if($('#max_timelack').val()==""){
          var maxtime = 84;
        }else{
          var maxtime = $('#max_timelack').val();
        }
        if(CodeLoans!='17'){
          var time_for = maxtime;
        }else{
          var time_for = 36;
        }

      }
      var valueTime = $('#valueTime').val(Timelack_Car);
      var Timelack_Car3 =$('#Timelack_Car3').val(Timelack_Car);
      var Interest_Car = $('#Interest_Car').val();

      var valueTime = $('#valueTime').val(Timelack_Car);


      var totalInterest_Car = $('#totalInterest_Car').val();

      var GetRatePrices = $('#RatePrices').val();           //ราคากลาง
      var GetRatePrice_Car = $('#RatePrice_Car').val().replace(/,/g, '');           //ราคาเรทยอดจัด
      var RatePrices = GetRatePrices.replace(/,/g, '');

      // if (totalInterest_Car != '') {
      //   var SumInterest = parseFloat(totalInterest_Car);

      // }else{
        var SumInterest = parseFloat(Interest_Car);
      //}


       function myFunction() {
                var getData;
                    $.ajax({
                          url: "{{ route('ControlCenter.SearchData') }}",
                          method: "POST",
                          type:"JSON",
                          async: false,
                          data: {
                            type: 9,
                            DataTag_id:DataTag_id,
                            _token: _token
                          },

                          success: function(data) {
                            getData = data.insurPrice;
                           // callback.call(getData);
                            //callback(data.insurPrice);
                          }
                        });
                        return getData;
                     }

          var getPA = myFunction();

        console.log(CodeLoans, Cash_Car , Timelack_Car , SumInterest ,GetRatePrices);
      if (CodeLoans != '' && Cash_Car != '' && Timelack_Car != '' && SumInterest != '' && GetRatePrices !='' ) {
        var valPrice = 0;
        if(StatusProcess_Car == 'yes'){
          Process_carnew =Process_Car;
        }else{
          Process_carnew =0;
        }

        valPrice = parseFloat(Cash_Car) + parseFloat(Process_carnew); //+ parseFloat(Insurance)

        $('#ShowPeriod,#ShowTotalPeriod').empty();
        $('#tableBody').empty();

        $('#valuePromotion').val(dataPromotion[0]);

        if (dataPromotion[2]==1) {

          valinterest = (((Timelack_Car - dataPromotion[1]) * SumInterest) / Timelack_Car);

        }else{
          valinterest = SumInterest;
        }

        // calculate
        var shortLoan = ['08','09','10','18','16'];
        var vatLoan = ['01','05','07'];

        if(shortLoan.includes(CodeLoans)==false){

          for (let index = 12; index <= time_for; index = index+6) {

              if(Type_Customer=="CUS-0009" || Timelack_Car>84){
                    index = Timelack_Car;
                    paindex = Math.ceil(Timelack_Car/12)*12 ;


                 if(paindex>84){
                      paindex = 84;
                    }
                  }else{
                    paindex = index;
                  }

            var Interest = valinterest * 12;
            var NewInterest = (Interest * (index / 12)) + 100;



            if(vatLoan.includes(CodeLoans)==true){ // VAT
              var TangRatePeriod = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / Timelack_Car) / 10) * 10;

              var TangRate = TangRatePeriod*Timelack_Car;


            }else{ // NO VAT
              var ProcessPR = ((parseFloat(valPrice) * (parseFloat(NewInterest) / 100) )) / Timelack_Car;
              var payR = Math.ceil(ProcessPR);
              var PeriodR = Math.ceil(payR / 10) * 10;
              var TangRate = PeriodR*Timelack_Car;
            }

            let totalRate = TangRate;
            var Installment = `TimeRack${paindex}`;
            var timeRack,plan_pa,Limit_Loan,id_pa ,valTime;

            for(let val of getPA){
              if(totalRate< getPA[getPA.length -1].Limit_Insur){
                if(val.Limit_Insur>totalRate ){
                if(dataPromotion[2]==3){
                  timeRack = Math.ceil(val[Installment]-(val[Installment]*dataPromotion[1]) );
                  // timeRack = Math.ceil(plus10/10)*10;
                }else{
                  timeRack = val[Installment];
                }
                valTime = val[Installment];
                plan_pa = val['Plan_Insur'];
                Limit_Loan = val['Limit_Insur'];
                id_pa = val['id'];

                break;
              }
              }else{
                if(dataPromotion[2]==3){
                  timeRack = Math.ceil(getPA[getPA.length -1][Installment]-(getPA[getPA.length -1][Installment]*dataPromotion[1]) );
                  // timeRack = Math.ceil(plus10/10)*10;
                }else{
                  timeRack = getPA[getPA.length -1][Installment];
                }
                valTime = getPA[getPA.length -1][Installment];
                plan_pa = getPA[getPA.length -1]['Plan_Insur'];
                Limit_Loan = getPA[getPA.length -1]['Limit_Insur'];
                id_pa = getPA[getPA.length -1]['id'];
            }
            }


           //console.log(timeRack);

            // var valPeriod = 0;
            // var TotalPeriod = 0;
            // var Profit = 0;


                      var Period2 = 0;

                      if(vatLoan.includes(CodeLoans)==true){ // VAT
                        var Period = Math.ceil(((((valPrice * NewInterest) / 100) * 1.07) / index) / 10) * 10;
                        //insur
                        var newRate =  parseFloat(valPrice)+parseFloat(timeRack);
                        var Period2 = Math.ceil(((((newRate * NewInterest) / 100) * 1.07) / index) / 10) * 10;

                      }else{ // NO VAT
                        var ProcessP = ((parseFloat(valPrice) * (parseFloat(NewInterest) / 100) )) / index;
                        var pay = Math.ceil(ProcessP);
                        var Period = Math.ceil(pay / 10) * 10;
                        //insur
                        var newRate =  parseFloat(valPrice)+parseFloat(timeRack);
                        var ProcessP2 = ((parseFloat(newRate) * (parseFloat(NewInterest) / 100) )) / index;
                        var pay2 = Math.ceil(ProcessP2);
                        var Period2 = Math.ceil(pay2 / 10) * 10;

                      }


                      if (index == Timelack_Car || Type_Customer=="CUS-0009" ) {
                        $('#TotalPeriodNonPa').val(totalRate);
                        if(selectPA=="yes" ){
                          var valPeriod = Period2;
                          var TotalPeriod = Period2 * Timelack_Car;
                          var Profit = TotalPeriod - newRate;

                        }else{
                          var valPeriod = Period;
                          var TotalPeriod = Period * Timelack_Car;
                          var Profit = TotalPeriod - valPrice;

                        }
                        if(vatLoan.includes(CodeLoans)==true){
                          if(selectPA=="yes"){
                            var Duerate = Period2 / ((7 / 100) + 1); //ยอด no vat
                            var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
                            var Tax = parseFloat(Period2) - parseFloat(Duerate); //ภาษีต่องวด
                            var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา

                          }else{
                            var Duerate = Period / ((7 / 100) + 1); //ยอด no vat
                            var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
                            var Tax = parseFloat(Period) - parseFloat(Duerate); //ภาษีต่องวด
                            var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา

                          }

                              $("#Tax_Rate").val(Tax.toFixed(2));
                              $("#Tax2_Rate").val(Tax2.toFixed(2));
                              $("#Duerate_Rate").val(Duerate.toFixed(2));
                              $("#Duerate2_Rate").val(Duerate2.toFixed(2));



                        }else if(CodeLoans=="15"){
                          $('#ShowTotalLand').empty();
                            if(selectPA=="yes" && buyPA=='yes'){
                              var normalPrice = (ProcessP2 * Timelack_Car);
                              var splitL = parseInt(normalPrice / 1000);
                              var str2 = splitL.toString();
                              var last = str2.substr(str2.length - 1);
                            }else{
                              var normalPrice = (ProcessP * Timelack_Car);
                              var splitL = parseInt(normalPrice / 1000);
                              var str2 = splitL.toString();
                              var last = str2.substr(str2.length - 1);
                            }

                          if (parseInt(normalPrice.toString().substr(-4)) < 5001) {
                            var land_a = splitL * 1000;
                            var plus = parseInt(5000 - (last * 1000));
                          } else {
                            var splitL2 = parseInt(normalPrice / 10000);
                            var land_a = splitL2 * 10000;
                            var plus = 10000;
                          }
                          landtotal = land_a + plus;
                          $('#ShowTotalLand').append((landtotal).toLocaleString());
                          $("#TotalLand_Rate").val(landtotal);
                        }
                        var textdata =
                        `<tr class="bg-success bg-gradient p-4">
                          <td>${index} งวด</td>
                          <td>${ (Period).toLocaleString()} บาท</td>
                          <td class="${buyPA == 'yes' ? '' : 'd-none'}">${plan_pa}ทุน ${(Limit_Loan).toLocaleString()} บาท</td>
                          <td class="${buyPA == 'yes' ? '' : 'd-none'}">${(Period2).toLocaleString() } บาท</td>
                           <td class="${buyPA == 'yes' ? '' : 'd-none'}">${ (Period2-Period).toLocaleString() } บาท</td>
                        </tr>`;

                        if(buyPA=='yes'){

                          sumLimit_Insur = parseInt(Limit_Insur)+parseInt(Limit_Loan);
                            if(sumLimit_Insur>1000000){
                                  Swal.fire({
                                    icon: 'error',
                                    title: `ERROR ` + 'ประกัน PA' + ` !!!`,
                                    text: 'ไม่สามารถซื้อประกัน PA เพิ่มได้',
                                    showConfirmButton: true,
                              });
                              //$("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
                              //$('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
                            }
                          $('#Insurance_PA').val(timeRack);
                          $('#Plan_PA').val(id_pa);
                          $('#Plan_Limit').val(plan_pa+' ทุน '+(Limit_Loan).toLocaleString());

                          $('.showPlan_PA').append(plan_pa);
                          $('.capital_PA').append((Limit_Loan).toLocaleString()+"  บาท");
                          $('.periodPA').append(Math.ceil(Timelack_Car/12 ));
                          $('.periodPAtotal').append((valTime).toLocaleString()+"  บาท" );
                          $('.viewPA').show();

                        }else{
                          $('#Insurance_PA').val(0);
                          $('#Plan_PA').val('');
                          $('#Plan_Limit').val('');
                          $('.viewPA').hide();
                        }

                      }else{
                        var textdata =
                        `<tr>
                          <td>${index} งวด</td>
                          <td>${ (Period).toLocaleString()} บาท</td>
                          <td class="${buyPA == 'yes' ? '' : 'd-none'}">${plan_pa}ทุน ${(Limit_Loan).toLocaleString()} บาท</td>
                          <td class="${buyPA == 'yes' ? '' : 'd-none'}">${(Period2).toLocaleString() } บาท</td>
                           <td class="${buyPA == 'yes' ? '' : 'd-none'}">${ (Period2-Period).toLocaleString() } บาท</td>
                        </tr>`;
                      }

                      $('#tableBody').append(textdata);

          }

        }else{

          var Interest1 = valinterest * 12;
          var ProcessP1 = ((valPrice * parseFloat(Interest1) / 100) * (Timelack_Car / 12)) / Timelack_Car;
          var pay1 = Math.ceil(ProcessP1);
          var Period1 = Math.ceil(pay1 / 10) * 10;
          var valPeriod1 = Period1;
          var TotalPeriod1 = parseFloat(valPrice)+(Period1 * Timelack_Car);
          var Profit1 = TotalPeriod1 - valPrice;
          var totalRate1 = TotalPeriod1;
          $('#TotalPeriodNonPa').val(totalRate1);
          var Installment = `TimeRack${Timelack_Car}`;
          for(let val of getPA){
              if(totalRate1< getPA[getPA.length -1].Limit_Insur){
                if(val.Limit_Insur>totalRate1 ){
                if(dataPromotion[2]==3){
                  timeRack = Math.ceil(val[Installment]-(val[Installment]*dataPromotion[1]) );
                  // timeRack = Math.ceil(plus10/10)*10;
                }else{
                  timeRack = val[Installment];
                }
                valTime = val[Installment];
                plan_pa = val['Plan_Insur'];
                Limit_Loan = val['Limit_Insur'];
                id_pa = val['id'];

                break;
              }
              }else{
                if(dataPromotion[2]==3){
                  timeRack = Math.ceil(getPA[getPA.length -1][Installment]-(getPA[getPA.length -1][Installment]*dataPromotion[1]) );
                  // timeRack = Math.ceil(plus10/10)*10;
                }else{
                  timeRack = getPA[getPA.length -1][Installment];
                }
                valTime = getPA[getPA.length -1][Installment];
                plan_pa = getPA[getPA.length -1]['Plan_Insur'];
                Limit_Loan = getPA[getPA.length -1]['Limit_Insur'];
                id_pa = getPA[getPA.length -1]['id'];
            }
            }



          var Period2 = 0;
          var Interest = valinterest * 12;

          var ProcessP = ((valPrice * parseFloat(Interest) / 100) * (Timelack_Car / 12)) / Timelack_Car;
          var pay = Math.ceil(ProcessP);
          var Period = Math.ceil(pay / 10) * 10;
          //insure
          var ProcessP2 = (((parseFloat(valPrice)+parseFloat(timeRack)) * parseFloat(Interest) / 100) * (Timelack_Car / 12)) / Timelack_Car;
          var pay2 = Math.ceil(ProcessP2);
          var Period2 = Math.ceil(pay2 / 10) * 10;

          if(selectPA=="yes"){
            var valPeriod = Period2;
            var TotalPeriod = (parseFloat(valPrice)+parseFloat(timeRack))+(Period2 * Timelack_Car);
            var Profit = TotalPeriod - (parseFloat(valPrice)+parseFloat(timeRack));
            var totalRate = TotalPeriod;

          }else{
            var valPeriod = Period;
            var TotalPeriod = parseFloat(valPrice)+(Period * Timelack_Car);
            var Profit = TotalPeriod - valPrice;
            var totalRate = TotalPeriod;

          }
          if(buyPA=='yes'){

            sumLimit_Insur = parseInt(Limit_Insur)+parseInt(Limit_Loan);
              if(sumLimit_Insur>1000000){
                    Swal.fire({
                    icon: 'error',
                    title: `ERROR ` + 'ประกัน PA' + ` !!!`,
                    text: 'ไม่สามารถซื้อประกัน PA เพิ่มได้',
                    showConfirmButton: true,
              });
              $("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
              $('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
            }

            $('#Insurance_PA').val(timeRack);
            $('#Plan_PA').val(id_pa);
            $('#Plan_Limit').val(plan_pa+' ทุน '+(Limit_Loan).toLocaleString());

            $('.showPlan_PA').append(plan_pa);
            $('.capital_PA').append((Limit_Loan).toLocaleString() +"  บาท");
            $('.periodPA').append(Math.ceil(Timelack_Car/12 ));
            $('.periodPAtotal').append((valTime).toLocaleString() +"  บาท");
            $('.viewPA').show();

            }else{
              $('#Insurance_PA').val(0);
              $('#Plan_PA').val('');
              $('#Plan_Limit').val('');
              $('.viewPA').hide();
            }

          var textdata =
                        `<tr>
                            <td>${Timelack_Car} งวด</td>
                            <td>${ (Period).toLocaleString()} บาท</td>
                            <td class="${buyPA == 'yes' ? '' : 'd-none'}">${plan_pa}ทุน ${(Limit_Loan).toLocaleString()} บาท</td>
                            <td class="${buyPA == 'yes' ? '' : 'd-none'}">${(Period2).toLocaleString() } บาท</td>
                              <td class="${buyPA == 'yes' ? '' : 'd-none'}">${ (Period2-Period).toLocaleString() } บาท</td>
                          </tr>`;
          $('#tableBody').append(textdata);


          if(CodeLoans=='16'){
            $('#ShowTotalLand').empty();
              if(selectPA=="yes" && buyPA=='yes'){
                var normalPrice = parseFloat(valPrice)+(ProcessP2 * Timelack_Car);
              }else{
                var normalPrice = parseFloat(valPrice)+(ProcessP * Timelack_Car);
              }

              var land_a = Math.ceil(normalPrice / 100) * 100;

                if (parseInt(land_a.toString().substr(-3)) - 100 > 0) {
                  landtotal = land_a - 100;
                } else {
                  landtotal = land_a;
                }
                $('#ShowTotalLand').append((landtotal).toLocaleString());
                $("#TotalLand_Rate").val(landtotal);
          }else if(CodeLoans=="18"){
                $('#ShowTotalLand').empty();
                if(selectPA=="yes" && buyPA=='yes'){
                  var normalPrice = parseFloat(valPrice)+(ProcessP2 * Timelack_Car);
                }else{
                  var normalPrice = parseFloat(valPrice)+(ProcessP * Timelack_Car);
                }

                var splitL = parseInt(normalPrice / 1000);
                var str2 = splitL.toString();
                var last = str2.substr(str2.length - 1);

                if (parseInt(normalPrice.toString().substr(-4)) < 5001) {
                  var land_a = splitL * 1000;
                  var plus = parseInt(5000 - (last * 1000));
                } else {
                  var splitL2 = parseInt(normalPrice / 10000);
                  var land_a = splitL2 * 10000;
                  var plus = 10000;
                }
                landtotal = land_a + plus;
                $('#ShowTotalLand').append((landtotal).toLocaleString());
                $("#TotalLand_Rate").val(landtotal);
              }
        }

        $("#Profit_Rate").val(Profit);
        $('#ShowPeriod').append((valPeriod).toLocaleString());
        $('#ShowTotalPeriod').append((TotalPeriod).toLocaleString());


        $("#Period_Rate").val(valPeriod);
        $("#TotalPeriod_Rate").val(TotalPeriod);
        $("#InterestYear_Car").val(parseFloat(Interest).toFixed(3));
       


      }else{
        Swal.fire({
          icon: 'error',
          title: "ข้อมูลไม่ถูกต้อง",
          text: "โปรดตรวจสอบ ช่องที่ใช้ในการคำนวณให้ถูกต้อง !",
          allowOutsideClick : true
        })
        $("#save").attr('disabled','disabled');
      }

    }

    // $('#InterestSelect li').click(function() {
    //   var FlagInterest = this.id;
    //   var Getinterest = $('#Interest_Car').val();
    //   var Getinterestmore = $('#Interestmore_Car').val();
    //   if (FlagInterest == 'Plus') {
    //     $('#Plus').addClass('active');
    //     $('#Delete,#Return').removeClass('active');
    //   } else if (FlagInterest == 'Delete') {
    //     $('#Delete').addClass('active');
    //     $('#Plus,#Return').removeClass('active');
    //   } else if (FlagInterest == 'Return') {
    //     $('#Return').addClass('active');
    //     $('#Plus,#Delete').removeClass('active');

    //   }

    //   if (FlagInterest == 'Plus') {
    //       var Setinterest = parseFloat(Getinterest) + parseFloat(Getinterestmore);
    //     } else if (FlagInterest == 'Delete') {
    //       var Setinterest = parseFloat(Getinterest) - parseFloat(Getinterestmore);
    //     } else {
    //       var Setinterest = parseFloat(Getinterest);
    //       $('#Interestmore_Car').val('');
    //     }
    //     var totalInterest = Setinterest;
    //     $('#totalInterest_Car').val(totalInterest);
    // });

    $('#button-Clear1').click(function(){
      $('.groupAsset,.modelAsset,.yearAsset,.gearCar,.Type_PLT').empty();
        $('.groupAsset').append($('<option/>').attr("selected","").val('').text("--- กลุ่มรถ ---"));
        $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
        $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
        $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
        $('.ratePrice').val('');
      $("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
      $('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
      $("#timelack").val($("#timelack option:first").val());
      $('.chkIncome,.guarantee').val('');
      $('#ShowPrice,#ShowPeriod,#ShowTotalPeriod').empty();
      $('#tableBody').empty();
      $('#ShowPrice,#ShowPeriod,#ShowTotalPeriod').append("0.00");
      $("#save").prop("disabled",true);


    });

    $('#save').click(function(){
      var dataform = document.querySelectorAll('.needs-validation');
		var validate = validateForms(dataform);

		if (validate == true) {
      //if ($("#createCalculates").valid() == true) {
        let _token = $('input[name="_token"]').val();
        let data = {};
        $('#createCalculates').serializeArray().map(function(x){
            data[x.name] = x.value;
        });
        $('.addSpin').empty();
        $('<span />', {
                      class : "spinner-border spinner-border-sm",
                      role : "status"
                    }).appendTo(".addSpin");

        var flag = $('#flag').val();
        var Cal_id = $('#Cal_id').val();
        var Period_Rate = $('#Period_Rate').val();
        var type =6;
        let sess = sessionStorage.getItem('element');
        if(Cal_id!=""){
            let link = "{{ route('ControlCenter.update', 'id') }}";
            var url = link.replace('id', Cal_id);
            var method = "put";
          }else{
            var url = "{{ route('ControlCenter.store') }}";
				    var method = "post";
          }

          if (Period_Rate != '') {
            $('#save').prop('disabled', true);
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

                      if(sess == 'section-expens' ){
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
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: "ข้อมูลไม่ถูกต้อง",
              text: "โปรดตรวจสอบข้อมูลให้ครบถ้วนก่อนบันทึก. !",
            })
          }
     // }
    }
    });

    function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');
				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}


  $('#btn_sentMI').click(function(event) {
				event.preventDefault();
				let id = $('#DataTag_id').val();

					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

					let url = "{{ route('tags.update', 'id') }}";
					url = url.replace('id', id);

					$.ajax({
						url: url,
						method: "PATCH",
						data: {
							_token: "{{ @csrf_token() }}",
							funs: 'update-MI',

						},
						success: function(result) {
							$('.data-tagPart').html(result.html);
							$('#tagpart-'+ result.tag_id).text(result.tagpart);

							Swal.fire({
								icon: 'success',
								text: result.message,
								showConfirmButton: false,
								timer: 1500
							});
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						},
						complete: function() {
							$('.addSpin').html('<i class="bx bxs-paper-plane"></i>');
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

						}
					});

			});
  </script>
