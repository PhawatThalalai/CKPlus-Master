{{-- clear input --}}
<script>
  $('#btn-clear').click(()=>{
    $('.input-user , input[type=date]').val('')
    $('select').val('').find('option :eq(0)').attr('selected', true)
  })

$(function() {
  var Type_Customer =  $("#Type_Customer").val();
  var Cal_id = $("#Cal_id").val();
  var code = $(".TypeLoans option:selected").text().split('-');
    var result = code[0].trim();
  if($('#buyPA').val()=='Yes'){
    $('#selectPA').attr("style", "pointer-events: block;").removeClass("bg-secondary");
  }else{
    $('#selectPA').attr("style", "pointer-events: none;").addClass("bg-secondary");
  }

  // if(Cal_id!=''){
  //   getDataRate();
  // }
  if(Type_Customer=="CUS-0006"||Type_Customer=="CUS-0008"){
    $("#Cus_grade").removeAttr("disabled");
    $("#Cus_grade").attr("required", "true");

    $("#Payment_Due").removeAttr("disabled");
    $("#Payment_Due").attr("required", "true");
    if(result=='02'){
       $("#Interest_old").removeAttr("disabled");
      $("#Interest_old").attr("required", "true");
      $("#DateOldCon").removeAttr("disabled");
      $("#DateOldCon").attr("required", "true");
    }
   
  }
  if($("#TypeLoans").val()=="car"){
      $('.showGear').show();
    }else if($("#TypeLoans").val()=="moto"){
      $('.showGear').hide();
    }

  if(Type_Customer=="CUS-0009"){
    $("#time_normal").hide();
    $("#time_debt").show();
  }else{
    $("#time_debt").hide();
    $("#time_normal").show();
  }

 
    $('#CodeLoans').val(result);
    var landCode = ['15','16'];
      if($("#TypeLoans").val()=="person"){
        $('.rate_price,.Occ_status').hide();
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
    getDataRate();
  });

  function getDataRate() {
    $('#Occ').empty();
    var dayOcc = jsDateDiff2($("#DateOccupiedcar").val() ,$("#todayOcc").val());
    var dayOccOld = jsDateDiff2($("#DateOccupiedcar").val() ,$("#DateOldCon").val());

     $("#NumDateOccupiedcar").val(dayOcc);
    $('#Occ').append(dayOcc);
    var TypeLoans =  $('#CodeLoans').val();
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

                  if(data[1]==0 && TypeLoans!="17"){
                      swal.fire({
                        text : "ไม่อยู่ในเงื่อนไขที่บริษัทกำหนดโปรด สอบถาม (ุผู้จัดการ). !",
                        icon: "warning",
                        timer: 5000,
                      })
                      $("#save").attr('disabled','disabled');
                  }else{

                    $("#save").removeAttr('disabled');

                    if(CheckPage!="disabled"){
                      if(parseInt(scoreCredo)>0){
                      $('#Note_Credo').val('ใช้ Score คำนวณ');
                      }else{
                        $('#Note_Credo').val('ไม่ใช้ Score');
                      }
                    }


                    if(parseInt(scoreCredo)>parseInt(data[5])){
                      ltv = (parseInt(data[0])+parseInt(data[6]));

                    }else{
                      ltv = data[0];
                    }
                   // console.log(ltv);
                    if(data[9]!=3){
                      var priceLoan = (parseFloat(RatePrices)*parseInt(ltv))/ 100;
                    }else{
                      var priceLoan = data[8];
                    }

                    $('#Timelack_Car option:not(:first)').remove();
                    $('#Process').empty();

                    //$('#Percent_Car').val(data[0]);
                    $('#RatePrice_Car').val((priceLoan.toLocaleString()));
                    if(Interest_sql==""){
                      if(yearAsset<2000 && TypeLoans=="car" ){
                      $('#Interest_Car').val('1');
                    }else{
                      $('#Interest_Car').val(data[1]);
                    }
                    }


                    $('.chkIncome').val(data[2]);
                    $('.guarantee').val(data[3]);
                    if(TypeLoans!="17"){
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
                  
                }
              });
  };
//,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar
 $('#TypeLoans').on('change',function(){
    var TypeLoansCode = $("#TypeLoans option:selected").text();
    var Type_Customer =  $("#Type_Customer").val();
    var loanCode = TypeLoansCode.split(" - ");
    $("#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#Timelack_Car,#Interest_Car,#InterestYear_Car").val('');
    $('#Interest_old,#DateOldCon,#TypeAssetsPoss,#DateOccupiedcar,#RatePrice_Car,#Percent_Car,#Promotions,#Cus_grade,#Payment_Due,#Cash_Car,#Process_Car,#buyPA,#selectPA,#Plan_PA,#Insurance_PA').val('');
    $('.chkIncome,.guarantee,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar').val('');
    $('#Occ').empty();
    $('#CodeLoans').val(loanCode[0]);
    $('.typeAsset').empty();
    var landCode = ['15','16','18'];
    if($("#TypeLoans").val()=="person"){
      $('.rate_price,.Occ_status').hide();
    }else{
      $('.rate_price,.Occ_status').show();
    }

    if($("#TypeLoans").val()=="car"){
      $('#Insurance').removeAttr('readonly');
      $(".ratePrice").prop('readonly', true);
      $('.showGear').show();
    }else if($("#TypeLoans").val()=="moto"){
      $(".ratePrice").prop('readonly', true);
      $('.showGear').hide();
    }else{
      $('#Insurance').prop('readonly', true);
      $(".ratePrice").removeAttr("readonly");
    }
   
  
    if(Type_Customer=="CUS-0006"||Type_Customer=="CUS-0008"){
    if(loanCode[0]=='02'){
       $("#Interest_old").removeAttr("disabled");
      $("#Interest_old").prop("required", true);
      $("#DateOldCon").removeAttr("disabled");
      $("#DateOldCon").prop("required", true);
    }else{
      $("#Interest_old").prop("disabled",true);
      $("#Interest_old").removeAttr("required");
      $("#DateOldCon").prop("disabled",true);
      $("#DateOldCon").removeAttr("required");
    }
   
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
      $("#Payment_Status").attr('disabled', 'disabled');
    }
  });
  $('#Cash_Car').keyup(function(){
    var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
    var GetRatePrice_Car = $('#RatePrice_Car').val().replace(/,/g, '');
    var Process_Rate = $('#Process_Rate').val();
    var CodeLoans = $('#CodeLoans').val();

    var Process_Car1 =Math.ceil((parseFloat(Cash_Car)*Process_Rate)/100);
    var land = ['04','10','13','15','16','18'];

    if(land.includes(CodeLoans)==true){
      var Process_Car = Process_Car1;
    }else{
      var Process_Car = Math.floor(Process_Car1/100)*100;
    }
    
    
    $('#Process_Car').val(Process_Car.toFixed(0));
     if(parseFloat(Cash_Car)>parseFloat(GetRatePrice_Car)){
      Swal.fire({
        icon: 'warning',
        title: "การแจ้งเตือน",
        text: "กรุณาตรวจสอบยอดจัด",
        allowOutsideClick : true
      })
     }
  });
  $('#buyPA').on('change',function(){
    if($('#buyPA').val()=='Yes'){
      $('#selectPA').attr("style", "pointer-events: block;").removeClass("bg-secondary");
      $("#selectPA").attr("required", "true");
      $('.viewPA').show();
    }else{
      $('#selectPA').attr("style", "pointer-events: none;").addClass("bg-secondary");
      $('#selectPA').removeAttr('required');
      $('.viewPA').hide();
    }
    calculateRate();
  });
  $('#selectPA,#Promotions').on('change',function(){
    calculateRate();
  });
  $('#button-data1').click(function(){
    getDataRate();
    calculateRate();
  });

  function calculateRate() {
      var Type_Customer = $('#Type_Customer').val();
        var CodeLoans = $('#CodeLoans').val();
        var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
        var Process_Car = $('#Process_Car').val().replace(/,/g, '');
        var Insurance = $('#Insurance').val().replace(/,/g, '');
        var _token = $('input[name="_token"]').val();
        var selectPA= $('#selectPA').val();
        var Promotions = $('#Promotions').val();
        var buyPA = $('#buyPA').val();
        
        var dataPromotion = Promotions.split('/');
        $('.showPlan_PA').empty();
        $('.capital_PA').empty();
        $('.periodPA').empty();
        $('.periodPAtotal').empty();
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
        
        var totalInterest_Car = $('#totalInterest_Car').val();

        var GetRatePrices = $('#RatePrices').val();           //ราคากลาง
        var GetRatePrice_Car = $('#RatePrice_Car').val().replace(/,/g, '');           //ราคาเรทยอดจัด
        var RatePrices = GetRatePrices.replace(/,/g, '');

        var Percent_Car = (Cash_Car/GetRatePrice_Car)*100;

        $('#valuePromotion').val(dataPromotion[0]);

    $.ajax({
      url: "{{ route('ControlCenter.SearchData') }}",
      type : 'POST',
      data : {
        funs:'CalKB',
        Flagtag: 2,
        _token:_token,
        Type_Customer:Type_Customer,
        CodeLoans:CodeLoans,
        Cash_Car:Cash_Car,
        Process_Car:Process_Car,
        Insurance:Insurance,
        selectPA:selectPA,
        Promotions:Promotions,
        buyPA:buyPA,
        time_for:time_for,
        Interest_Car:Interest_Car,
        GetRatePrices:GetRatePrices,
        RatePrices:RatePrices,
        Percent_Car:Percent_Car,
        totalInterest_Car:totalInterest_Car,
        Timelack_Car:Timelack_Car,



      },
      success : (res)=>{
        console.log(res);
        $('#content-table').html(res.html)
      },
      error : (err)=>{

      }
    })
  }
</script>

<script>
  $('#save').click(()=>{
    console.log($('#form-Calculates').serialize());
  })
</script>