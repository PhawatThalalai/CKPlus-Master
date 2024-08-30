<script>
  $(document).ready(function(){
    //$('#YearTableBtn').click();
    $(".openDatepickerBtn").on('click', function() {
      $(this).siblings('input').focus();
    });

  });
</script>

<script>
  async function GetRuleByAjax() {
    var rule = [];
    var loan_code = $("#TypeLoans").find(':selected').data('loancode');
    if (loan_code != '00') {
      let yearCar = ($("#RateYears").val() != '') ? $( "#RateYears option:selected" ).text() : null;
      let total = $("#Cash_Car").val();
      total = total.replace(/,/g, '');
      let instl = $("#Timelack_Car").val();
      let code_cus = $("#Code_Cus-calTag").val();
      let loan_group = $("#TypeLoans").find(':selected').data('loangroup');
      let asset_poss = $("#TypeAssetsPoss").find(':selected').data('codetype');
      let num_occupied = $("#NumDateOccupiedcar").val();
      let code_car = $("#RateCartypes").val();
      let Brand_id = $("#RateBrands").val();
      let Group_car = $("#RateGroups").val();
      let Model_car = $("#RateModals").val();
      let _token = $('input[name="_token"]').val();
      var _result = [];
      await $.ajax({
        url: "{{ route('ControlCenter.SearchData') }}",
        method: "POST",
        data: {
          type: 7,
          loan_code: loan_code,
          yearCar:yearCar,
          total: total,
          instl: instl,
          code_cus: code_cus,
          loan_group: loan_group,
          asset_poss: asset_poss,
          num_occupied: num_occupied,

          code_car: code_car,
          Brand_id: Brand_id,
          Group_car: Group_car,
          Model_car: Model_car,

          _token:_token
        },
        success:function(result){ //เสร็จแล้วทำอะไรต่อ
          _result = result;
        }
      })
      rule = _result;
    }
    return rule;
  }
</script>

<script>
  var insurPrice = {!! json_encode($insurPrice) !!};
  var parseInsurPrice = JSON.parse(insurPrice);

  function GetInsurPrice_PA_ById(data, id) {
    return data.filter(
      function(data) {
        return data.id == id
      }
    );
  }

  function GetInsurPrice_PA(totalPeriod, installment, plan_PA = 0) {

    let premium, plan_name, limit_loan, id_pa;
    if (plan_PA != 0) {
      // มีไอดี Plan_PA แล้ว
      var _plan = GetInsurPrice_PA_ById(parseInsurPrice, Number(plan_PA))[0];
      premium = _plan[`TimeRack${installment}`];
      plan_name = _plan['Plan_Insur'];
      limit_loan = _plan['Limit_Insur'];
      id_pa = plan_PA;
    } else {
      // หาไอดี Plan_PA
      for(let val of parseInsurPrice){
        if(val.Limit_Insur > totalPeriod){
          premium = val[`TimeRack${installment}`];
          plan_name = val['Plan_Insur'];
          limit_loan = val['Limit_Insur'];
          id_pa = val['id'];
          break;
        }
      }
    }
    
    return {
      'premium': premium,
      'plan_name': plan_name,
      'limit_loan': limit_loan,
      'id_pa': id_pa
    };
  }
  //console.log( parseInsurPrice );

  function RefreshInsurance_PA_Input() {
    if ( $("#_Temp_Plan_PA").val() != "" ) {
      // มีแผนประกันแล้ว
      $('#buy_PA_toggle').prop('disabled', false);
      $("#Plan_PA_Show").val( $("#Plan_PA_Name").val() + ": " + addCommas($("#Plan_PA_Limit_loan").val()) + " บาท" );
      //--------------------------------------------------------------------
      let Premium = $("#_Temp_Insurance_PA").val();
      $("#Show_Insurance_PA").removeClass('text-success')
      $("#Show_Insurance_PA").removeClass('text-primary')
      $("#Show_Insurance_PA").addClass('text-primary');
        //-------------------
        // promotion
        let promotion_selected = $("#Promotions").val();
        if ( promotion_selected != "" ) {
          let data_promotion = promotion_selected.split('/');
          if (data_promotion[2]==3) { // ส่วนลดประกัน PA
            //Premium = Premium * (1 - data_promotion[1]);
            Premium = Math.ceil( Premium - ( Premium * data_promotion[1]) );
            Premium = Math.ceil(Premium/10)*10;
            $("#Show_Insurance_PA").removeClass('text-primary')
            $("#Show_Insurance_PA").addClass('text-success');
          }
        }
        //------------------
      if ( $('#buy_PA_toggle').is(":checked") ) {
        //--------------------------------------------------------------------
        $("#Plan_PA").val( $("#_Temp_Plan_PA").val() );
        $("#Insurance_PA").val(Premium);
        //-------------------
        $("#Buy_PA").val('Yes');
        $('#insur_PA_toggle').prop('disabled', false);
        //--------------------------------------------------------------------
      } else {
        //--------------------------------------------------------------------
        $("#Plan_PA").val('');
        $("#Insurance_PA").val('');
        //-------------------
        $('#insur_PA_toggle').prop('disabled', true);
        $('#insur_PA_toggle').prop('checked', false); // Unchecks it
        $("#Buy_PA").val('No');
        $("#Include_PA").val('No');
        //--------------------------------------------------------------------
      }
      $("#Show_Insurance_PA").val( addCommas(Premium) );
      //--------------------------------------------------------------------
    } else {
      $('#buy_PA_toggle').prop('disabled', true);
      $('#buy_PA_toggle').prop('checked', false); // Unchecks it
      $('#insur_PA_toggle').prop('disabled', true);
      $('#insur_PA_toggle').prop('checked', false); // Unchecks it

      $("#_Temp_Insurance_PA").val("");
      $("#Show_Insurance_PA").val("");

      $("#Plan_PA_Show").val("");
      $("#Plan_PA_Name").val("");
      $("#Plan_PA_Limit_loan").val(0);
    }
  }

  function UpdateCalCard() {
    let TypeLoans = $("#TypeLoans").find(':selected').data('loancode');
    let Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
    let Timelack = $('#Timelack_Car').val();
    let Interest_m = parseFloat($('#Interest_Car').val());
    let Interest_y = parseFloat($('#InterestYear_Car').val());
    //-------------------------------------------------------------------
    let Promotions = $('#Promotions').val();   
    let dataPromotion = Promotions.split('/');
    let MidPrice = $("#RatePrices").val()               //ราคากลาง
    MidPrice = Number( MidPrice.replace(/,/g, '') );
    //-------------------------------------------------------------------
    let Topcar = 0
    Topcar = parseFloat(Cash_Car);
    //-------------------------------------------------------------------
    if ( MidPrice != '') {
      let PCT_car = ( Topcar * 100 / MidPrice ).toFixed(0);
      $('#RatePrices_PCT').html( PCT_car + "%" );
      $('#Percent_Car').val(PCT_car);
    }
    //-------------------------------------------------------------------
    let Add_Fee = $('#Process_Car').val().replace(/,/g, '');
    //-------------------------------------------------------------------
    let Tax_Percent = 1;
    if (TypeLoans == '01') { // เช่าซื้อรถยนต์ มีภาษี
      Tax_Percent = 1.07;
    }
    $('#Vat_Rate').val( Tax_Percent * 100 - 100 );
    //-------------------------------------------------------------------
    let TopcarTotal;

    var Premium = $("#_Temp_Insurance_PA").val();
    if(dataPromotion[2]==3){
      Premium = Math.ceil( Premium - ( Premium * dataPromotion[1]) );
      Premium = Math.ceil(Premium/10)*10;
    }

    if ( $('#insur_PA_toggle').is(":checked") ) {
      // เช็คว่าคำนวณแบบรวมประกันสินเชื่อ
      TopcarTotal = Number(Topcar) + Number(Add_Fee) + Number(Premium);
    } else {
      TopcarTotal = Number(Topcar) + Number(Add_Fee);
    }
    var Period = Math.ceil(( ((TopcarTotal * (Interest_m/100) *(Timelack)) + TopcarTotal) * Tax_Percent / Timelack ) / 10) * 10;
    var TotalPeriod = Period * Timelack;
    //--------------------------------------------------
    var Duerate = (Period / Tax_Percent);
    var TotalDuerate = Duerate * Timelack;
    var Tax = Period - Duerate;
    var TotalTax = Tax.toFixed(2) * Timelack;
    var Interest_Price = (TopcarTotal * (Interest_m/100) * (Timelack));

    // เช็คว่าได้คำนวณแผนประกัน PA รึยัง
    if ( $("#_Temp_Plan_PA").val() == "" ) { // ยังไม่ได้คำนวณแผน
      //--------------------------------------------------
      // คำนวณแผนให้ แล้ว Refresh
      var insur_PA = GetInsurPrice_PA(TotalPeriod, Timelack);
      $("#_Temp_Plan_PA").val( insur_PA['id_pa'] );
      $("#_Temp_Insurance_PA").val( insur_PA['premium'] ); // เบี้ยประกัน
      $("#Plan_PA_Name").val( insur_PA['plan_name'] ); // ชื่อแผน
      $("#Plan_PA_Limit_loan").val( insur_PA['limit_loan'] ); // วงเงินประกัน
      RefreshInsurance_PA_Input();
      //--------------------------------------------------
    }
    
    //---------------------------------------------------------------------
    // ส่วนการแสดงผล
    $('#showPrice').show();
    
    if ( $('#insur_PA_toggle').is(":checked") ) {
      // เช็คว่าคำนวณแบบรวมประกันสินเชื่อ 
      //var Premium = $("#_Temp_Insurance_PA").val().replace(/,/g, '');
      $('#TotalTop').html( "<span class='font-italic mr-2' style='font-size:13px'>(" + addCommas(Topcar) + " + " + addCommas(Number(Add_Fee)) + " + " + addCommas(Number(Premium)) + ")</span>" + addCommas(TopcarTotal.toFixed(2)) + " ฿");
    } else {
      $('#TotalTop').html( "<span class='font-italic mr-2' style='font-size:13px'>(" + addCommas(Topcar) + " + " + addCommas(Number(Add_Fee)) + ")</span>" + addCommas(TopcarTotal.toFixed(2)) + " ฿");
    }

    // ส่วนการเก็บค่ารอบันทึก
    
    $('#Period').html(addCommas(Period.toFixed(2)) + " ฿");
    $('#TotalPeriod').html(addCommas(TotalPeriod.toFixed(2)) + " ฿");

    $('#Timelack').html(Timelack + " งวด");

    $('#Period_Rate').val(Period);
    $('#TotalPeriod_Rate').val(TotalPeriod);
    //console.log(TotalPeriod - Topcar);
    $('#Profit_Rate').val(TotalPeriod - Topcar);

    $('#Tax_Number').html(addCommas(Tax.toFixed(2)) + " ฿");
    $('#Tax_Total').html(addCommas(TotalTax.toFixed(2)) + " ฿");
    $('#Duerate').html(addCommas(Duerate.toFixed(2)) + " ฿");
    $('#Duerate_Total').html(addCommas(TotalDuerate.toFixed(2)) + " ฿");
    $('#Interest_Price').html(addCommas(Interest_Price.toFixed(2)) + " ฿");

    $('#Tax_Rate').val( Tax.toFixed(2) );
    $('#Tax2_Rate').val( TotalTax.toFixed(2) );
    $('#Duerate_Rate').val( Duerate.toFixed(2) );
    $('#Duerate2_Rate').val( TotalDuerate.toFixed(2) );

    //-----------------------------------------------------------
    // บันทึกค่าที่ตกหล่น
    $('#totalInterest_Car').val( $('#Interest_Car').val() );
  }

  $('#buy_PA_toggle').change(function() {
    RefreshInsurance_PA_Input();
    UpdateCalCard();
  }); 

  $('#insur_PA_toggle').change(function() {
    UpdateCalCard();
    if ( $('#insur_PA_toggle').is(":checked") ) {
      //--------------------------------------------------------------------
      $("#Buy_PA").val('Yes');
      $("#Include_PA").val('Yes');
      //--------------------------------------------------------------------
    } else {
      //--------------------------------------------------------------------
      $("#Buy_PA").val('Yes');
      $("#Include_PA").val('No');
      //--------------------------------------------------------------------
    }
  }); 

</script>

<script>

  /*
  $('#DateOccupiedcar').daterangepicker({
      "singleDatePicker": true,
      "showDropdowns": true,
      "autoApply": true,
      ranges: {
          'วันนี้': [moment()],
          '30 วัน': [moment().subtract(30, 'days')],
          '60 วัน': [moment().subtract(60, 'days')],
          '90 วัน': [moment().subtract(90, 'days')]
      },
      "locale": {
          "format": "YYYY-MM-DD",
          "separator": " - ",
      },
      "linkedCalendars": false,
      "showCustomRangeLabel": false,
      "alwaysShowCalendars": true,
      "drops": "auto"
  }, function(start, end, label) {
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    var days = GetDayOccupied( start.format('YYYY-MM-DD') );
    //$('#NumDateOccupiedcar').val(days);
    Occupied_Badge_Update(days);
    //-----------------------------------------------------------------
    CardHelpUpdate();
    RefreshDropDownTypeLoans();
    HideCalPrice();
    //-----------------------------------------------------------------
    //$('#BuddhistEraTooltip').attr()
    // toBuddhistEra(inputDate);
    UpdateTooltipBuddhistEra( toBuddhistEra(start) );
    
  });
  */

  function UpdateTooltipBuddhistEra(newTitle) {
    //$('#BuddhistEraTooltip').attr('title', newTitle);
    $('#BuddhistEraTooltip').attr('title', newTitle)
      .attr('data-original-title', newTitle)
      .tooltip('update');
  }
  function toBuddhistEra(dateString) {
    let date = new Date(dateString);
    let year = date.getFullYear() + 543;
    return "พ.ศ. " + year;
  }
  UpdateTooltipBuddhistEra( toBuddhistEra( (new Date()).toString() ));

    function HideCalPrice() {
      $('#showPrice').hide();
      $('#tableBody').empty();
      $('#RatePrices_PCT').html('0%');
      //----------------------------------
      $("#_Temp_Plan_PA").val("");
      RefreshInsurance_PA_Input();
    }

    $('#Cash_Car,#Process_Car').on("input", function () {
      var Getprice = document.getElementById($(this).attr('id')).value;
      var Setprice = Getprice.replace(/,/g, '');
      $(this).val(addCommas(Setprice));
      HideCalPrice();
    });

    $('#Cash_Car').on("input", function () {
      CardHelpUpdate();
      HideCalPrice();
    });

    function GetDayOccupied(date) {
      var date_now = new Date();
      var date_input = new Date( date );
      date_input.setHours(date_now.getHours());
      date_input.setMinutes(date_now.getMinutes());
      date_input.setSeconds(date_now.getSeconds());
      date_input.setMilliseconds(date_now.getMilliseconds());
      var diff = date_now - date_input;
      var days = diff/1000/60/60/24;
      $('#NumDateOccupiedcar').val(days);
      return days;
    }

    function roundNumberFee(num) {
      return Math.ceil(num / 50) * 50;
    }

    async function CardHelpUpdate(params) {
      let _helpText = "";
      //-----------------------------------------------------
      var CheckPage = $('#CheckPage').val();
      var scoreCredo = $('#Credo_Score').val();
      if(CheckPage!="disabled"){
        if(parseInt(scoreCredo)>0){
          $('#Note_Credo').val('ใช้ Score คำนวณ');
        }else{
          $('#Note_Credo').val('ไม่ใช้ Score');
        }
      }
      //-----------------------------------------------------
      if ($('#DateOccupiedcar').val() == '') {

        $('#CardHelp_Text').html("กรุณาใส่ <b>'วันครอบครองล่าสุด'</b> เพื่อเลือก <b>'ประเภทสัญญา'</b>");



      } else if ( $("#TypeLoans").val() == null ) {

        //var days = GetDayOccupied( $('#DateOccupiedcar').val() );
        //$v('#NumDateOccupiedcar').val(days);
        var days = $('#NumDateOccupiedcar').val();
        @foreach ($InterstRule->unique('TypeLoan_Id') as $_InterstRule)
          if (! (days >= {{$_InterstRule->Cond_OccupiedTime}})) {
            _helpText += '<b>{{$_InterstRule->InterestToTypeLoan->Loan_Code}} - {{$_InterstRule->InterestToTypeLoan->Loan_Name}}</b> ต้องถือครอง <b>{{$_InterstRule->Cond_OccupiedTime}}</b> วัน<br>';
          }
        @endforeach
        _helpText += "กรุณาเลือก 'ประเภทสัญญา'";
        $('#CardHelp_Text').html(_helpText);

      } else {
        $('#CardHelp_Text').html("กำลังโหลด...");
        let rule = await GetRuleByAjax();
        //console.log( rule );
        let Interest_Display = "-";
        let InterestYear_Display = "-";
        let InstallmentMax_Display = "-";
        let InstallmentYear_Display = "-";
        let FeeRate_Display = "-";
        let FeeMin_Display = "-";
        let FeeMax_Display = "";
        let FineRate_Display = "";
        let InstallmentREC_Display = "-";
        let ltv = [];
        let credo_cond = 0;
        let credo_bonusLTV = 0;
        //if ( Object.keys(rule).length > 0 ) {
        if (rule['state'] == 'success') {
          if (rule['Type_Success'] == 1) {
            //rule.sort((a, b) => b['Rating'] - a['Rating'])
            Interest_Display = parseFloat(rule['Interest']).toFixed(2);
            InterestYear_Display = (Interest_Display*12).toFixed(2);
            FeeRate_Display = rule['Fee_Rate'];
            FeeMin_Display = rule['Fee_Min'];
            FeeMax_Display = rule['Fee_Max'];
            FineRate_Display = rule['Fine_Rate'];
            InstallmentREC_Display = rule['Installment_REC'];
            $('#Interest_Car').val(Interest_Display);
            $('#InterestYear_Car').val(InterestYear_Display);
            $('#totalInterest_Car') .val(Interest_Display);
            //--------------------------------------------------------------
            ltv = rule['LTV'];
            credo_cond = rule['Credo_Cond'];
            credo_bonusLTV = rule['Credo_BonusLTV'];
            //--------------------------------------------------------------

            $('#CardHelp_Text').html("ดอกเบี้ย: <b>"+Interest_Display+"%</b> ต่อเดือน ( <b>"+InterestYear_Display+"%</b> ต่อปี)  จำนวนงวดที่จัดได้: <b>"+InstallmentREC_Display+"</b> งวด<br>ค่าธรรมเนียม: <b id='FeeRate'>"+FeeRate_Display+"%</b> ขั้นต่ำ <b id='FeeMin'>"+addCommas(FeeMin_Display)+"</b> บาท" + (FeeMax_Display > "0" ? " (ไม่เกิน " + addCommas(FeeMax_Display) + " บาท)" : '') + "  เบี้ยปรับ: <b>" + FineRate_Display + "%</b> ต่อปี" );
          }
          if (rule['Type_Success'] == 2) {
            ltv = rule['LTV'];
            $('#CardHelp_Text').html("ไม่พบเงื่อนไขที่ตรงกันในระบบ กรุณาเปลี่ยนเงื่อนไขหรือกรอกข้อมูลให้ครบถ้วน");
          }
        } else {
          $('#CardHelp_Text').html("ไม่พบเงื่อนไขที่ตรงกันในระบบ กรุณาเปลี่ยนเงื่อนไขหรือกรอกข้อมูลให้ครบถ้วน");
        }
        //---------------------
        if (InstallmentREC_Display!="-") { // ไฮไลต์แถบสี จำนวนงวด
          var array_of_instl = [];
          if (InstallmentREC_Display.indexOf('-') > -1) { // เป็นช่วงจำนวนงวด
            let instl_range = InstallmentREC_Display.split("-");
            var instl_start = Number(instl_range[0]);
            var instl_end = Number(instl_range[1]);
            for (let i = instl_start; i < instl_end; i = i + 6) {
              array_of_instl.push( String(i) );
            }
          } else { // เป็นจำนวนงวดนั้นงวดเดียว
            array_of_instl.push(InstallmentREC_Display);
          }
          // style="background-color: lightgreen;"
          $("#Timelack_Car option").attr("style", '');
          $('#Timelack_Car').find('option')
            .attr('style', 'background-color: lightGrey')
            .filter(function(){
              return array_of_instl.includes( $(this).val() ) }) // หา option
            .attr('style', 'background-color: lightgreen');
        }
        //---------------------
        if (!isNaN(+FeeRate_Display)) {
          /*
          let Topcar = $("#Cash_Car").val();
          Topcar = Topcar.replace(/,/g, '');
          let Add_Fee = addCommas((Number(Topcar) * FeeRate_Display / 100 ).toFixed(2));
          Add_Fee = Add_Fee < FeeMin_Display ? FeeMin_Display : Add_Fee;
          if (FeeMax_Display != 0) Add_Fee = Add_Fee > FeeMax_Display ? FeeMax_Display : Add_Fee;
          $('#Process_Car').val(Add_Fee);
          */
          let Topcar = $("#Cash_Car").val();
          Topcar = Topcar.replace(/,/g, '');
          let Add_Fee = (Number(Topcar) * FeeRate_Display / 100);
          if (Add_Fee < FeeMin_Display) Add_Fee = FeeMin_Display;
          //------------------------------------------------------
          Add_Fee = roundNumberFee(Add_Fee);
          //------------------------------------------------------
          if (FeeMax_Display != 0 && Add_Fee > FeeMax_Display) Add_Fee = FeeMax_Display;
          $('#Process_Car').val(addCommas(Number(Add_Fee).toFixed(2)));
        }
        //---------------------
        var MidPrice = $("#RatePrices").val()               //ราคากลาง
        MidPrice = Number( MidPrice.replace(/,/g, '') );
        //---------------------
        $(".LTV_ownership").hide();
        $(".LTV_trade").hide();
        //console.log("scoreCredo: " + parseInt(scoreCredo) );
        if(CheckPage!="disabled"){
          if( parseInt(scoreCredo) > credo_cond && $("#TypeAssetsPoss").val() == 'รถกรรมสิทธิ์' ) {
            // เข้าเงื่อนไช credo
            ltv.forEach(function(number, index, array) {
              if (array[index] != 0) array[index] = number + parseInt(credo_bonusLTV);
            });
            console.log("เข้าเงื่อนไขเครโด้");
            console.log(ltv);
          } else {
            // ไม่เข้าเงื่อนไช credo
            console.log("ไม่เข้าเงื่อนไข credo");
          }
        }
        if ( $("#TypeAssetsPoss").val() == 'รถกรรมสิทธิ์' ) { // ซื้อขาย
          //$("#LTV_ownership_pct").val(ltv[0]); ไม่แสดงเปอร์เซ็น LTV แล้ว
          //-----------------------------------------------------------------
          if ( MidPrice != '') {
            $("#LTV_ownership_value").val( addCommas((ltv[0] * MidPrice / 100 ).toFixed(0)) );
          }
          //-----------------------------------------------------------------
          $(".LTV_ownership").show();
        } else if ( $("#TypeAssetsPoss").val() == 'รถซื้อขาย' ) { // กรรมสิทธิ์
          //$("#LTV_trade_pct_1").val(ltv[0]); ไม่แสดงเปอร์เซ็น LTV แล้ว
          //$("#LTV_trade_pct_2").val(ltv[1]);
          //$("#LTV_trade_pct_3").val(ltv[2]);
          //-----------------------------------------------------------------
          if ( MidPrice != '') {
            $("#LTV_trade_value_1").val( addCommas((ltv[0] * MidPrice / 100 ).toFixed(0)) );
            $("#LTV_trade_value_2").val( addCommas((ltv[1] * MidPrice / 100 ).toFixed(0)) );
            $("#LTV_trade_value_3").val( addCommas((ltv[2] * MidPrice / 100 ).toFixed(0)) );
          }
          //-----------------------------------------------------------------
          $(".LTV_trade").show();
        }
        //---------------------
      }
    }

    function Occupied_Badge_Update(days) {
      $("#Occupied_Badge").removeClass (function (index, className) {
        return (className.match (/(^|\s)badge-\S+/g) || []).join(' ');
      });
      if (days >= 60) {
        // 2 เดือน
        $("#Occupied_Badge").addClass('badge-success');
        $("#Occupied_Time").html('>= 2 เดือน');
      } else if (days >= 30) {
        // 1 เดือน
        $("#Occupied_Badge").addClass('badge-primary');
        $("#Occupied_Time").html('>= 1 เดือน');
      } else if (days >= 0) {
        // มากกว่า 1 วัน
        $("#Occupied_Badge").addClass('badge-warning');
        $("#Occupied_Time").html('< 1 เดือน');
      } else {
        // ติดลบ
        $("#Occupied_Badge").addClass('badge-danger');
        $("#Occupied_Time").html('< 0 วัน');
      }
    }

</script>

<script>
    
    /*
    $('#DateOccupiedcar').change(function() {
      var days = GetDayOccupied( $(this).val() );
      $('#NumDateOccupiedcar').val(days);
      //-----------------------------------------------------------------
      Occupied_Badge_Update(days);
      //-----------------------------------------------------------------
      CardHelpUpdate();
      RefreshDropDownTypeLoans();
      HideCalPrice();
    });
    */

    var all_TypeLoan = [];
    @foreach($TypeLoan as $_TypeLoan)
      all_TypeLoan.push("{{$_TypeLoan->Loan_Code}}");
    @endforeach

    function RefreshDropDownTypeLoans() {

      // ถ้าอยู่ในหน้าสัญญา ให้ข้ามการทำงานฟังก์ชันนี้
      @if( !empty(@$idCont) )
        return
      @endif
      
      $("#TypeLoans option").attr("disabled", true);
      //---------------------------------------------------
      //$("#TypeLoans").val('')
      //$("#TypeLoans").trigger("change");
      if ( $('#DateOccupiedcar').val() != '' && $("#Code_Cus-calTag").val() != null ) {
        $("#TypeLoans").removeAttr("disabled");
        //var days = GetDayOccupied( $('#DateOccupiedcar').val() );
        //$('#NumDateOccupiedcar').val(days);
        var days = $('#NumDateOccupiedcar').val();
        //--------------------------------------------------------------------------------
        let typeLoan_Available = [];
        @foreach ($InterstRule->unique('TypeLoan_Id') as $_InterstRule)
          all_TypeLoan.forEach(element => {
            if (element == "{{$_InterstRule->InterestToTypeLoan->Loan_Code}}") {
              if (days >= {{$_InterstRule->Cond_OccupiedTime}}) {
                typeLoan_Available.push(element);
              }
            }
          });
        @endforeach
        typeLoan_Available.sort();
        //--------------------------------------------------------------------------------
        $('#TypeLoans').find('option')
          .filter(function(){
            return typeLoan_Available.includes( $(this).data('loancode').toString() ) }) // หาสัญญาที่จัดได้
          .removeAttr("disabled");
        //--------------------------------------------------------------------------------
        let selectedOption = $('#TypeLoans').find("option:selected");
        if (selectedOption.prop("disabled")) {
          //console.log("The selected option is disabled.");
          //console.log( selectedOption.data('loancode').toString() );
          var loancode_now = selectedOption.data('loancode').toString();
          var indexSelect = 0;
          if (loancode_now == '02') {
            var dataAttributeValue = "01";
            indexSelect = $("#TypeLoans option[data-loancode='" + dataAttributeValue + "']").index();
          } else if (loancode_now == '03' || loancode_now == '04') {
            indexSelect = 0;
          }
          $('#TypeLoans').prop("selectedIndex", indexSelect);
          $("#TypeLoans").trigger("change");
        } 
      } else {
        $("#TypeLoans").attr("disabled", true);
      }
      //---------------------------------------------------
    }

</script>

<script>

    function RefreshInputCar(rateType) {
      $(".input_PossessionState_Code").hide();
      $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears,.input_RateGear").hide();
      switch ( rateType ) {
        case 'car':
          $(".input_PossessionState_Code").show();
          $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears,.input_RateGear").show();
          break;
        case 'moto':
          $(".input_PossessionState_Code").show();
          $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears").show();
          break;
        case 'land':
          break;
      }
    }

    $('#TypeLoans').change(function() {
      let value = $('#TypeLoans').get(0).value;
      $('#CodeLoans').val( $('#TypeLoans').find(':selected').data('loancode') );
      RefreshInputCar( value );
      //-----------------------------------
      $(".showRatePrice").hide();
      if (value == "car" || value == "moto") {
        
      } else if (value == "land") {
        $(".showRatePrice").show();
        $("#TypeAssetsPoss").val('');
        $(".LTV_ownership").hide();
        $(".LTV_trade").hide();
      }
      //-----------------------------------
      CardHelpUpdate();
      HideCalPrice();
    });

    $("#Code_Cus-calTag").change(function() {
      if ($("#Code_Cus-calTag").val() != null) {
        $('#DateOccupiedcar').attr("disabled", false);
        CardHelpUpdate();
        HideCalPrice();
      }
    });

    function Load_PA_data_from_Tag() {
      @if( @$dataTag->DataCusTagToDataCulcu->Buy_PA == "Yes" )

        var _insur_PA = GetInsurPrice_PA(0, Number({{@$dataTag->DataCusTagToDataCulcu->Timelack_Car}}), Number({{@$dataTag->DataCusTagToDataCulcu->Plan_PA}}) );
        $("#_Temp_Plan_PA").val( _insur_PA['id_pa'] );
        $("#_Temp_Insurance_PA").val( _insur_PA['premium'] ); // เบี้ยประกัน
        $("#Plan_PA_Name").val( _insur_PA['plan_name'] ); // ชื่อแผน
        $("#Plan_PA_Limit_loan").val( _insur_PA['limit_loan'] ); // วงเงินประกัน

        $('#buy_PA_toggle').prop('disabled', false);
        $('#buy_PA_toggle').prop('checked', true);
        $('#insur_PA_toggle').prop('disabled', false);
        @if( @$dataTag->DataCusTagToDataCulcu->Include_PA == "Yes" )
          $('#insur_PA_toggle').prop('checked', true);
          UpdateCalCard();
        @endif
        RefreshInsurance_PA_Input();

      @endif
    }

    function Load_Interest_from_Tag() {
      $('#Interest_Car').val('{{number_format(@$dataTag->DataCusTagToDataCulcu->Interest_Car,2)}}');
      $('#InterestYear_Car').val('{{number_format(@$dataTag->DataCusTagToDataCulcu->InterestYear_Car,2)}}');
      @if( @$dataTag->DataCusTagToDataCulcu->Process_Car != null )
        // ค่าธรรมเนียม
        $('#Process_Car').val('{{number_format(@$dataTag->DataCusTagToDataCulcu->Process_Car,2)}}');
      @endif
    }

    @if( @$dataTag == null) // ยังไม่มีข้อมูล
      if ( $("#Code_Cus-calTag").val() == null ) {
        $('#DateOccupiedcar').attr("disabled", true);
        $('#TypeLoans').attr("disabled", true);
        $('#CheckPage').val('disabled');
      }
      CardHelpUpdate();
      RefreshDropDownTypeLoans();
      RefreshInputCar('');
      $('#showPrice').hide();
      $(".LTV_ownership").hide();
      $(".LTV_trade").hide();
      $("#Buy_PA").val('No');
      $("#Include_PA").val('No');
    @else // มีข้อมูลอยู่แล้ว ให้ทำการอัปเดต
      $("#Code_Cus-calTag").attr("disabled", true);
      if ( $('#DateOccupiedcar').val() != '' ) {
        let days = GetDayOccupied( $('#DateOccupiedcar').val() );
        //$('#NumDateOccupiedcar').val(days);
        Occupied_Badge_Update(days);
      }
      
      @if( !empty(@$idCont) ) // ถ้ามีการเลือกส่งจัดแล้ว ให้ล็อคประเภทสัญญา ห้ามเปลี่ยน
        $("#TypeLoans").attr("disabled", true);
      @endif

      RefreshDropDownTypeLoans();
      $('#TypeLoans').find('option')
        .filter(function(){
          return $(this).data('loancode') == '{{@$dataTag->DataCusTagToDataCulcu->CodeLoans}}' // เลือกประเภทสัญญา
        }).attr("selected", true);
      $('#CodeLoans').val( $('#TypeLoans').find(':selected').data('loancode') );
      RefreshInputCar( $('#TypeLoans').val() );
      $('#TypeLoans').data('oldvalue', $('#TypeLoans').val() );
      if ( '{{@$dataTag->DataCusTagToDataCulcu->Timelack_Car}}' != '' ) {
        $('#Timelack_Car').val('{{@$dataTag->DataCusTagToDataCulcu->Timelack_Car}}');
      }
      CardHelpUpdate();
      Load_Interest_from_Tag();
      // + เช็คเพิ่มว่า ถ้าไม่ใช่รถยนต์ ให้กดคำนวณทันที
      var _typeLoan_Asset = $("#TypeLoans").find(':selected').data('idrateType');
      if ( _typeLoan_Asset != 'car' && _typeLoan_Asset != 'moto') {
        UpdateCalCard();
      }
      Load_PA_data_from_Tag();

      @if( !empty(@$idCont) ) // กดคำนวณให้ เนื่องจากอยู่ในหน้าส่งจัด 
        //console.log("คำนวณ!");
        // ยังไม่คำนวณ... 
        //$('#button-data1').click();
      @endif

    @endif

    $('.yearAsset').change(function() { //year -> gear
        if ($(this).val() != '') {
          CardHelpUpdate();
          HideCalPrice();
        }
    });

    $('#Timelack_Car').change(function() {
        if ($(this).val() != '') {
          CardHelpUpdate();
          HideCalPrice();
        }
    });

    $('#Code_Cus,#TypeAssetsPoss,#RateCartypes,#RateBrands,#RateGroups').change(function() { //สถานะครอบครอง และทุก ๆ  อย่าง
        if ($(this).val() != '') {
          CardHelpUpdate();
          HideCalPrice();
        }
    });

    $('#button-data1').click(function(){
      HideCalPrice();
      var TypeLoans = $("#TypeLoans").find(':selected').data('loancode');
      var Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
      var Timelack = $('#Timelack_Car').val();
      var Interest_m = parseFloat($('#Interest_Car').val());
      var Interest_y = parseFloat($('#InterestYear_Car').val());
      if (TypeLoans == '00') {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้เลือกประเภทสัญญา",
          text: "กรุณาเลือกกรอกข้อมูลให้ครบถ้วน",
        });
      }
      if (Cash_Car == '') {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้ใส่ยอดจัด",
          text: "กรุณาเลือกกรอกข้อมูลให้ครบถ้วน",
        });
      }
      var TypeLoan_Asset = $("#TypeLoans").find(':selected').data('idrateType');
      if ( (TypeLoan_Asset == 'car' || TypeLoan_Asset == 'moto') && ($("#RateYears").val() == '') ) {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้ใส่ปีรถ",
          text: "กรุณาใส่ปีรถ เพื่อคำนวณดอกเบี้ยและระยะเวลาผ่อน",
        });
      }
      if (Timelack == '') {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้เลือกระยะเวลาผ่อน",
          text: "กรุณาเลือกกรอกข้อมูลให้ครบถ้วน",
        });
      }
      if (Interest_m == '') {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้ใส่ดอกเบี้ย",
          text: "กรุณาเลือกกรอกข้อมูลให้ครบถ้วน",
        });
      }
      
      UpdateCalCard();

      // ย้ายคำสั่งข้างล่างไปทำในฟังก์ชันหมดแล้ว
    });

    $('#button-Clear1').click(function(){
      //ลบค่า hidden
      $('#NumDateOccupiedcar,#CodeLoans,#Percent_Car,#RatePrice_Car').val('');
      $('#Vat_Rate,#Period_Rate,#Tax_Rate,#Tax2_Rate,#Duerate_Rate,#Duerate2_Rate,#Profit_Rate,#TotalPeriod_Rate').val(0);

      $('#DateOccupiedcar,#TypeLoans,#TypeAssetsPoss,#RateCartypes,#RateBrands,#RateGroups,#RateModals,#RateYears,#RateGear,#Promotions').val("");
      $('#RatePrices,#Cash_Car,#Timelack_Car,#Interest_Car,#totalInterest_Car,#InterestYear_Car,#Process_Car').val('');
      
      CardHelpUpdate();
      RefreshDropDownTypeLoans();
      RefreshInputCar('');
      HideCalPrice();
    });

    $('#Interest_Car').on('input', function() {
      var currentInput = $(this).val();
      //$( '#' + $(this).data('input-y') ).val( Math.round(currentInput*12) );
      $( '#' + $(this).data('input-y') ).val( (currentInput*12).toFixed(2) );
      $('#totalInterest_Car').val(currentInput);
      HideCalPrice();
    });

    $('#InterestYear_Car').on('input', function() {
      var currentInput = $(this).val();
      $( '#' + $(this).data('input-m') ).val( (currentInput/12).toFixed(2) );
      HideCalPrice();
    });

    $("#Promotions").change(function() {
      /*
      let promotion_selected = $("#Promotions").val();
      let data_promotion = Promotions.split('/');
      if ($("#Promotions").val() != null) {
        $('#DateOccupiedcar').attr("disabled", false);
        CardHelpUpdate();
        HideCalPrice();
      }
      */
      //HideCalPrice();
      RefreshInsurance_PA_Input();
      UpdateCalCard();
      let promotion_selected = $("#Promotions").val();
      if ( promotion_selected != "" ) {
        let data_promotion = promotion_selected.split('/');
        $("#valuePromotion").val(data_promotion[0]);
      } else {
        $("#valuePromotion").val('');
      }
    });

    $('#save').click(async function(){

      if ($('#showPrice').is(":hidden") ) {
        return swal.fire({
          //closeOnClickOutside: false,
          allowOutsideClick: false,
          icon: "error",
          title: "ยังไม่ได้คำนวณ",
          text: "กรุณาเลือกกรอกข้อมูลให้ครบถ้วน แล้วกดคำนวณ",
        });
      }

      var data = $('#createCalculates').serialize();
      var flag = $('#flag').val();
      var Cal_id = $('#Cal_id').val();

     if(Cal_id!=""){
        var url = "{{route('ControlCenter.update',0)}}";     
        var method = "PUT";  
      }else{
        var url = "{{route('ControlCenter.store')}}";  
        var method = "POST";       
      }

      $('.btn_SaveCal').prop('disabled', true);
      $('<span />', {
        class : "spinner-border spinner-border-sm",
        role : "status"
      }).appendTo(".addSpin");

      await $.ajax({
          url : url,
          type : method,
          data :  data,
          success : async function(data) {

            if(data['flag'] == 'success'){
              toastr.success('อัพเดตข้อมูลเรียบร้อย');

              $('#modal-xl').modal('toggle');

              //$('#modal-xl').modal('hide');
              $(".typeLoan").val(data.datacal);
              $('.typeLoan').addClass('is-valid');
              $('.CashCarView').val(addCommas(data.Cash_Car));
              $('.Balance_Price0').val(addCommas(data.totalBalance));
              if(data.flagPage==true){
                $('#dataExpenses_view').html(data.html);  
              }
              
            }else{
              toastr.error('อัพเดตข้อมูลไม่ได้');
            }

            $('.addSpin').html('')
            $('.btn_SaveCal').prop('disabled', false);
          }
      });
    });

</script>

<script>
$(function() {  
  // Here you register for the event and do whatever you need to do.
  $(document).on('calid-search-completed', async function() {
    $(document).off('calid-search-completed');
    //console.log("load completed!");
    await CardHelpUpdate();
    Load_Interest_from_Tag();
    $('#button-data1').click();
    Load_PA_data_from_Tag();
    
  });

  // Here you register for the event and do whatever you need to do.
  $(document).on('ratePrice-search-completed', function() {
    //$(document).off('ratePrice-search-completed');
    //console.log("price completed!");
    CardHelpUpdate();
  });

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });

});
</script>