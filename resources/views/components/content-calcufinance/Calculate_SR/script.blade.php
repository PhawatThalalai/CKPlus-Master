<!-- สคริปต์ หา กฎ ดอกเบี้ย -->
<script>
    $(document).ready(function() {
        $('#YearTableBtn').click();
        $('.openDatepickerBtn').click();
    });

    var all_TypeLoan = @json($TypeLoan->pluck('Loan_Code')->toArray());

    function RefreshCalPage() {
        console.log( "RefreshCalPage" );
        Refresh_TypeLoanDropDown();
        //--------------------------------------------------------------------------------------
        // ถ้าประเภทสัญญา ไม่ใช่ ค่าว่าง
        if ( $('#TypeLoans').val() != "" ) {
            let TypeLoansValue = $('#TypeLoans').val();
            $('#CodeLoans').val( $('#TypeLoans').find(':selected').data('loancode') );
            $('#assetType_input').val( $('#TypeLoans').find(':selected').data('idratetype') );
            //-----------------------------------
            if (TypeLoansValue == "car" || TypeLoansValue == "moto") {
                $(".showRatePrice").slideUp();
                $(".input_PossessionState_Code").slideDown();
                $('#TypeAssetsPoss').attr('required', true); // บังคับประเภทครอบครอง
                //-------------------------------
                // อัพเดต Dropdown เริ่มต้นของประเภทรถ
                RefreshDropDown_typeAsset();
                //-------------------------------
                $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears").slideDown();
                if ( TypeLoansValue == "car" ) {
                    $(".input_RateGear").slideDown();
                } else {
                    $(".input_RateGear").slideUp();
                }
                //-------------------------------
                // อัพเดตสถานครอบครองทรัพย์ (เลือกซื้อขายได้เฉพาะวันครอบครองไม่ถึง 30 วันเท่านั้น)
                Refresh_TypeAssetsPossDropDown(); 
            } else if (TypeLoansValue == "land") {
                $(".showRatePrice").slideDown();
                $("#TypeAssetsPoss").val('');
                $('#TypeAssetsPoss').attr('required', false); // ที่ดิน ไม่บังคับประเภทครอบครอง
                $(".input_PossessionState_Code").slideUp();
                $(".LTV_ownership").slideUp();
                $(".LTV_trade").slideUp();
                //-------------------------------
                $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears,.input_RateGear").slideUp();
            } else if (TypeLoansValue == "person") {
                $(".showRatePrice").slideUp();
                $("#TypeAssetsPoss").val('');
                $('#TypeAssetsPoss').attr('required', false); // ที่ดิน ไม่บังคับประเภทครอบครอง
                $(".input_PossessionState_Code").slideUp();
                $(".LTV_ownership").slideUp();
                $(".LTV_trade").slideUp();
                $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears,.input_RateGear").slideUp();
            }
        } else {
            // ประเภทสัญญาเป็นค่าว่าง
            $('#CodeLoans').val('');
            $('#assetType_input').val('');
            //-----------------------------------------------
            $(".showRatePrice").slideUp();
            $("#TypeAssetsPoss").val('');
            $(".input_PossessionState_Code").slideUp();
            $(".LTV_ownership").slideUp();
            $(".LTV_trade").slideUp();
            $(".input_RateCartypes,.input_RateBrands,.input_RateGroups,.input_RateModals,.input_RateYears,.input_RateGear").slideUp();
        }
        //--------------------------------------------------------------------------------------
        // ถ้าสถานะครอบครอง ไม่ใช่ค่าว่าง
        if ( $('#TypeAssetsPoss').val() != "" ) {
            var _codeTypeAssetPoss = $('#TypeAssetsPoss').find(':selected').data('codetype');
            if (_codeTypeAssetPoss == 'APS-0001') { // รถกรรมสิทธิ์
                $(".LTV_ownership").slideDown();
                $(".LTV_trade").slideUp();
                $("#helptext_rate3").slideUp();
            } else if (_codeTypeAssetPoss == 'APS-0002') { // รถซื้อขาย
                $(".LTV_ownership").slideUp();
                $(".LTV_trade").slideDown();
                $("#helptext_rate3").slideDown();
            }
        }
        //--------------------------------------------------------------------------------------
        UpdateInterstRule();
        UpdateInstallmentDropDown();
        UpdateFee();
        //------------------------------------------------
        UpdatePAInput();
        //------------------------------------------------
        UpdateCal();
    }

</script>

<!-- สคริปต์ หา LTV -->
<script>
    var ltv_table = @json($ltv_table);
    var ltv_rate = @json($ltv_rate);

    var typeAsset = @json($typeAsset);

    function convertToJavaScriptRegex(phpRegex) {
        // Remove delimiters and flags
        var parts = phpRegex.match(/\/(.*?)\/([a-z]*)/i);
        
        if (parts) {
            var pattern = parts[1];
            var flags = parts[2];
            
            // Convert PHP flags to JavaScript flags
            var jsFlags = '';
            if (flags.includes('i')) jsFlags += 'i';
            if (flags.includes('g')) jsFlags += 'g';
            if (flags.includes('m')) jsFlags += 'm';
            
            // Construct JavaScript regex
            var jsRegex = new RegExp(pattern, jsFlags);
            return jsRegex;
        } else {
            throw new Error('Invalid PHP regex format.');
        }
    }

    function countLTVNotNull(ltv_rate_item) {
        var count = 0;
        var array_check = ['code_car', 'Brand_id', 'Group_car_name', 'Model_car_name', 'Year_Start', 'Year_End'];
        $.each( array_check, function( index, key ) {
            if ( key in ltv_rate_item && ltv_rate_item[key] != null ) {
                count += 1;
            }
        });
        return count;
    }

    function compareLTVRateRating( a, b ) {
        var countA = countLTVNotNull(a);
        var countB = countLTVNotNull(b);
        return countB - countA;
    }

    var updateLTV_asset_poss = null;
    var updateLTV_id_rateType = null;
    var updateLTV_typeCus = null;
    var updateLTV_num_occupied = null;

    var updateLTV_code_car = null;
    var updateLTV_brand_id = null;
    var updateLTV_group_car = null;
    var updateLTV_modal_car = null;
    var updateLTV_year_car = null;

    var LTV_Display = [0,0,0];

    function UpdateLTV() {
        var asset_poss = ($('#TypeAssetsPoss').val() != '') ? $('#TypeAssetsPoss').find(':selected').data('codetype') : null;
        var id_rateType = ($('#TypeLoans').val() != '') ? $('#TypeLoans').find(':selected').data('idratetype') : null;
        var typeCus = ($('#Code_Cus-calTag').val() != '') ? $('#Code_Cus-calTag').val() : null;
        var num_occupied = ($('#NumDateOccupiedcar').val() != '') ? $('#NumDateOccupiedcar').val() : null;

        var code_car = ($('#RateCartypes').val() != '') ? $('#RateCartypes').val() : null;
        var brand_id = ($('#RateBrands').val() != '') ? $('#RateBrands').val() : null;
        var group_car = ($('#RateGroups').val() != '') ? $('#RateGroups option:selected').text() : null;
        var modal_car = ($('#RateModals').val() != '') ? $('#RateModals option:selected').text() : null;
        var year_car = ($("#RateYears").val() != '') ? $( "#RateYears option:selected" ).text() : null;

        //-------------------------------------------
        if ( updateLTV_asset_poss != asset_poss || updateLTV_id_rateType != id_rateType || updateLTV_typeCus != typeCus || updateLTV_num_occupied != num_occupied || updateLTV_code_car != code_car || updateLTV_brand_id != brand_id || updateLTV_group_car != group_car || updateLTV_modal_car != modal_car || updateLTV_year_car != year_car) {
            updateLTV_asset_poss = asset_poss;
            updateLTV_id_rateType = id_rateType;
            updateLTV_typeCus = typeCus;
            updateLTV_num_occupied = num_occupied;
            updateLTV_code_car = code_car;
            updateLTV_brand_id = brand_id;
            updateLTV_group_car = group_car;
            updateLTV_modal_car = modal_car;
            updateLTV_year_car = year_car;
        } else {
            return;
        }
        //-------------------------------------------
        
        var typeAsset_item;
        if (id_rateType == 'person') {
            typeAsset_item = '';
        } else {
            typeAsset_item = typeAsset[id_rateType];
        }

        var _ltv_rule = [];
        $.each( ltv_table, function( index, item ) {
            if (item.TypeAsset == typeAsset_item) {
                var check_rule = [];
                //------------------------------------
                if (item.TypeAssetsPoss != null) {
                    check_rule.push( ( asset_poss != null && asset_poss == item.TypeAssetsPoss ) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.Code_Cus != null) {
                    check_rule.push( ( typeCus != null && typeCus == item.Code_Cus ) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.OccupiedDay_Start != null) {
                    if (item.OccupiedDay_End != null) {
                        check_rule.push( ( num_occupied != null && parseInt(num_occupied) >= parseInt(item.OccupiedDay_Start) && parseInt(num_occupied) <= parseInt(item.OccupiedDay_End) ) );
                    } else {
                        check_rule.push( ( num_occupied != null && parseInt(num_occupied) >= parseInt(item.OccupiedDay_Start) ) );
                    }
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.code_car != null) {
                    check_rule.push( ( code_car != null && code_car == item.code_car ) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.Brand_id != null) {
                    check_rule.push( ( brand_id != null && brand_id == item.Brand_id ) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.Group_car != null) {
                    check_rule.push( ( group_car != null && group_car == item.Group_car ) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if ( !check_rule.includes(false) ) {
                    _ltv_rule.push( item );
                }
                //------------------------------------
            }
        });

        console.log( "_ltv_rule");
        console.log( _ltv_rule );

        _ltv_rule = _ltv_rule.sort( compareRuleRating );
        let _ltv_rule_remain = [];
        if ( _ltv_rule.length > 0 ) {
            console.log( 'ทำการสร้าง LTV' );
            //--------------------------------------------------------
            if (asset_poss == 'APS-0002') { // รถซื้อขาย
                let _ltv_guar_income = null;
                let _ltv_guar_land = null;
                let _ltv_guar_asset = null;
                $.each( _ltv_rule, function( index, item ) {
                    if (item.Evaluate_guar == 'guar_income') {
                        _ltv_guar_income = item;
                    } else if (item.Evaluate_guar == 'guar_land') {
                        _ltv_guar_land = item;
                    } else if (item.Evaluate_guar == 'guar_asset') {
                        _ltv_guar_asset = item;
                    }
                });
                _ltv_rule_remain = [
                    _ltv_guar_income,
                    _ltv_guar_land,
                    _ltv_guar_asset
                ]
            } else {
                _ltv_rule_remain = [ _ltv_rule[0] ];
            }
            //-------------------------------------------------------
            console.log( "_ltv_rule_remain:");
            console.log( _ltv_rule_remain );
            //--------------------------------------------------------
            let ltv_result = [];
            let allNull = _ltv_rule_remain.every(item => item === null);
            if (allNull) { // LTV เป็นค่าว่าง
                ltv_result = _ltv_rule_remain;
                ltv_result.forEach((item, index, array) => ltv_result[index] = 0);
            } else { // LTV มีค่าอยู่
                let allDirect_LTV = _ltv_rule_remain.every(item => item.LTV == 'direct');
                if (allDirect_LTV) {
                    ltv_result = _ltv_rule_remain;
                    ltv_result.forEach((item, index, array) => ltv_result[index] = item.RatePrice * 100);
                } else {
                    // หา LTV Ref เลย
                    let _ltv_real = [];
                    $.each( ltv_rate, function( index, item ) {
                        if (code_car != null && item.code_car != null && item.code_car != code_car) {
                            return true;
                        }
                        if (brand_id != null && item.Brand_id != null && item.Brand_id != brand_id) {
                            return true;
                        }
                        //------------------------------------------------------
                        var check_rule = [];
                        //------------------------------------
                        if (item.Group_car_name != null) {
                            if ( group_car != null ) {
                                if ( (item.Group_car_name).match(/\/(.*?)\/([a-z]*)/i) ) {
                                    // เป็น RegEx
                                    check_rule.push( convertToJavaScriptRegex(item.Group_car_name).test(group_car) );
                                } else {
                                    // ไม่เป็น RegEx
                                    check_rule.push( item.Group_car_name == group_car );
                                }
                            } else {
                                check_rule.push(false);
                            }
                        } else {
                            check_rule.push(true);
                        }
                        //------------------------------------
                        if (item.Model_car_name != null) {
                            if ( modal_car != null ) {
                                if ( (item.Model_car_name).match(/\/(.*?)\/([a-z]*)/i) ) {
                                    // เป็น RegEx
                                    check_rule.push( convertToJavaScriptRegex(item.Model_car_name).test(modal_car) );
                                } else {
                                    // ไม่เป็น RegEx
                                    check_rule.push( item.Model_car_name == modal_car );
                                }
                            } else {
                                check_rule.push(false);
                            }
                        } else {
                            check_rule.push(true);
                        }
                        //------------------------------------
                        if (item.Year_Start != null) {
                            check_rule.push( ( year_car != null && year_car >= item.Year_Start && year_car <= item.Year_End) );
                        } else {
                            check_rule.push(true);
                        }
                        //------------------------------------
                        //console.log( !check_rule.includes(false) );
                        if ( !check_rule.includes(false) ) {
                            _ltv_real.push( item );
                        }
                        //------------------------------------
                    });
                    // sort _ltv_real ต่อ
                    // sort โดยใช้หลักว่า ให้เอาแถวที่มีค่าว่างน้อยที่สุดขึ้นมาก่อน หรือจะนับคอลัมน์ที่ไม่ใช่ null ก็ได้
                    _ltv_real = _ltv_real.sort( compareLTVRateRating );
                    console.log("_ltv_real:");
                    console.log(_ltv_real);
                    //_ltv_real = _ltv_real[0]; // เลือกอันแรกจากที่ sort
                    //--------------------------------------------------------
                    // จากนั้น อ่านค่า ltv_result ที่ได้มา แล้วเราจะได้ LTV
                    //--------------------------------------------------------
                    $.each( _ltv_rule_remain, function( index, item ) {
                        
                        if (item.LTV == 'direct') {
                            ltv_result.push( item.RatePrice * 100 )
                        } else {
                            let mod_ltv = 0;
                            let ltv_ref;
                            if ( 'Mod_PCT' in item && item.Mod_PCT != null ) {
                                mod_ltv = parseInt( item.Mod_PCT );
                            }
                            if ( _ltv_real.length == 0 ) {
                                mod_ltv = 0;
                                ltv_ref = 0;
                            } else {
                                ltv_ref = _ltv_real[0][ String(item.LTV) ];
                            }
                            ltv_result.push( (ltv_ref * item.RatePrice) + mod_ltv )
                        }
                        
                    });
                }
                //console.log( "ltv_result" );
                //console.log( ltv_result );
                LTV_Display = ltv_result;
            }
            //--------------------------------------------------------
            // นำ ltv_result ที่ได้ ไปคำนวณกับราคากลาง เพื่อแสดง วงเงินประเมิน
            UpdateLTV_display();
            //--------------------------------------------------------
        } else {
            // ไม่เจอกฎอะไรเลย
            // เซ็ตค่าราคาเป็น 0
            LTV_Display = [0,0,0];
            UpdateLTV_display();
        }
    }

    function UpdateLTV_display() {
        //------------------------------------------------------
        var CheckPage = $('#CheckPage').val();
        var scoreCredo = $('#Credo_Score').val();
        //--------------
        var credo_cond = parseInt( $("#Credo_Cond").val() );
        var credo_bonusLTV = parseInt( $("#Credo_BonusLTV").val() );
        //--------------
        var type_assetPost = $("#TypeAssetsPoss").val();
        var MidPrice = $("#RatePrices").val();               //ราคากลาง
        MidPrice = Number( MidPrice.replace(/,/g, '') );
        //------------------------------------------------------
        
            if(parseInt(scoreCredo)>0){
                $('#Note_Credo').val('ใช้ Score คำนวณ');
            }else{
                $('#Note_Credo').val('ไม่ใช้ Score');
            }
        
        //------------------------------------------------------
        console.log("ราคากลาง: " + MidPrice);
        console.log(LTV_Display);
        //------------------------------------------------------
        if(CheckPage!="disabled"){
            if( parseInt(scoreCredo) > credo_cond && type_assetPost == 'รถกรรมสิทธิ์' ) {
                // เข้าเงื่อนไช credo
                LTV_Display.forEach(function(number, index, array) {
                    if (array[index] != 0) array[index] = number + credo_bonusLTV;
                });
                console.log("เข้าเงื่อนไขเครโด้");
                console.log(LTV_Display);
            } else {
                // ไม่เข้าเงื่อนไช credo
                console.log("ไม่เข้าเงื่อนไข credo");
            }
        }
        //------------------------------------------------------
        if ( type_assetPost == 'รถกรรมสิทธิ์' ) { // ซื้อขาย
            //-----------------------------------------------------------------
            /*
            if ( MidPrice != '') {
                $("#LTV_ownership_value").val( addCommas((LTV_Display[0] * MidPrice / 100 ).toFixed(0)) );
            }
            */
            $("#LTV_ownership_value").val( addCommas((LTV_Display[0] * MidPrice / 100 ).toFixed(0)) );
          //-----------------------------------------------------------------
        } else if ( type_assetPost == 'รถซื้อขาย' ) { // กรรมสิทธิ์
            //-----------------------------------------------------------------
            /*
            if ( MidPrice != '') {
                $("#LTV_trade_value_1").val( addCommas((LTV_Display[0] * MidPrice / 100 ).toFixed(0)) );
                $("#LTV_trade_value_2").val( addCommas((LTV_Display[1] * MidPrice / 100 ).toFixed(0)) );
                $("#LTV_trade_value_3").val( addCommas((LTV_Display[2] * MidPrice / 100 ).toFixed(0)) );
            }
            */
            $("#LTV_trade_value_1").val( addCommas((LTV_Display[0] * MidPrice / 100 ).toFixed(0)) );
            $("#LTV_trade_value_2").val( addCommas((LTV_Display[1] * MidPrice / 100 ).toFixed(0)) );
            $("#LTV_trade_value_3").val( addCommas((LTV_Display[2] * MidPrice / 100 ).toFixed(0)) );
            //-----------------------------------------------------------------
        }

        //------------------------------------------------------
    }
    
</script>

<!-- สคริปต์ อัพเดตราคากลาง -->
<script>
    // Here you register for the event and do whatever you need to do.
    $(document).off('ratePrice-search-completed').on('ratePrice-search-completed', function() {
        //$(document).off('ratePrice-search-completed');
        //console.log("price completed!");
        UpdateLTV_display();
    });
</script>

<!-- สคริปต์ ประเภทลูกค้า -->
<script>
    $("#Code_Cus-calTag").change(function() {
        if ($("#Code_Cus-calTag").val() != null) {
            //$('#DateOccupiedcar').attr("disabled", false);
            //Refresh_TypeLoanDropDown();
        }
        RefreshCalPage();
        UpdateLTV();
    });
</script>

<!-- สคริปต์ วันครอบครอง เมนูวันที่ -->
<script>
    $(document).ready(function() {
        $(".openDatepickerBtn").on('click', function() {
            $(this).siblings('input').focus();
        });
        RefreshCalPage();
    });

    //----------------------------------------------------------------
    function setDateOccupied(day) {
        var input_daterange = $("#DateOccupiedcar");
        if (input_daterange.length >= 0) {
            if (day == 0) {
                input_daterange.datepicker("update", moment().format("DD/MM/YYYY"));
            } else {
                input_daterange.datepicker("update", moment().subtract(day, 'days').format("DD/MM/YYYY"));
            }
        }
    }
    
    $("._Today_DateOccupied").each(function(index) {
        $(this).on("click", function() {
            setDateOccupied(0);
        });
    });
    $("._30Day_DateOccupied").each(function(index) {
        $(this).on("click", function() {
            setDateOccupied(30);
        });
    });
    $("._60Day_DateOccupied").each(function(index) {
        $(this).on("click", function() {
            setDateOccupied(60);
        });
    });
    $("._90Day_DateOccupied").each(function(index) {
        $(this).on("click", function() {
            setDateOccupied(90);
        });
    });
    //----------------------------------------------------------------
    $("#DateOccupiedcar").on("change", function() {
        _date = $(this).datepicker("getDate");
        console.log(_date);
        if (_date == null) return;
        date_moment = moment(_date);
        if ( date_moment.isBefore( moment() ) ) {
            let moment_now = moment();
            moment_now.set('hour', 0);
            moment_now.set('minute', 0);
            moment_now.set('second', 0);
            moment_now.set('millisecond', 0);
            let diff_days = moment(date_moment).diff( moment_now, 'days', true);
            $("#NumDateOccupiedcar").val(diff_days * -1);
        } else {
            $("#NumDateOccupiedcar").val(0);
        }
        RefreshCalPage();
        UpdateLTV();
    });
    //----------------------------------------------------------------
    function Refresh_TypeLoanDropDown() {
        @if( @$tags->TagToContracts != NULL )
            // ถ้าสัญญาส่งจัดแล้ว จะแก้ประเภทสัญญาไม่ได้ ไม่มีการอัพเดต TypeLoanDropDown
            return
        @endif
        $("#TypeLoans option:not(:first)").attr("disabled", true);
        if ( $("#Code_Cus-calTag").val() == null ) {
            return;
        }
        if ( $("#DateOccupiedcar").val() == "" ) {
            return;
        }
        //---------------------------------------------------------
        $("#TypeLoans").removeAttr("disabled");
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
    }

</script>

<!-- สคริปต์ของ สถานะครอบครอง -->
<script>

    // Refresh_TypeAssetsPossDropDown
    function Refresh_TypeAssetsPossDropDown() {
        if ( $("#Code_Cus-calTag").val() == null ) {
            return;
        }
        if ( $("#DateOccupiedcar").val() == "" ) {
            return;
        }
        //---------------------------------------------------------
        var days = $('#NumDateOccupiedcar').val();
        if (days > 30) {
            // ถ้าวันครอบครอง ตั้งแต่ 31 จะเลือกครอบครอง ซื้อขาย ไม่ได้
            $('#TypeAssetsPoss').find('option[data-codetype="APS-0002"]').attr("disabled", true);
        } else {
            // วันครอบครองตั้งแต่ 30 ลงมา จะเลือก ซื้อขาย ได้
            $('#TypeAssetsPoss').find('option[data-codetype="APS-0002"]').removeAttr("disabled");
        }
        //---------------------------------------------------------
        // เช็คว่า selected โดน disabled รึเปล่า ถ้าใช่ ก็ให้ unselected เลย
        let selectedOption = $('#TypeAssetsPoss').find("option:selected");
        if (selectedOption.prop("disabled")) {
            $('#TypeAssetsPoss').prop("selectedIndex", 0);
            $("#TypeAssetsPoss").trigger("change");
        }
    }

    // UpdateLTV

    $("#TypeLoans,#TypeAssetsPoss,#RateYears").change(function() {
        RefreshCalPage();
        UpdateLTV();
    });

    $("#Timelack_Car").change(function() {
        RefreshCalPage();
    });

    $("#RateCartypes,#RateBrands,#RateGroups,#RateModals").change(function() {
        UpdateLTV();
    });

    $("#Buy_PA_Yes,#Buy_PA_No,#Include_PA_Yes,#Include_PA_No").change(function() {
        UpdatePAInput();
        UpdateCal();
    });

    $("#StatusProcess_Car_Yes,#StatusProcess_Car_No,#Promotions").change(function() {
        //------------------------------------------------------
        // อัพเดต ดอกเบี้ยก่อนจะ UpdateCal
        //------------------------------------------------------
        let Promotions = $('#Promotions').val();   
        let dataPromotion = Promotions.split('/');
        if(dataPromotion[2]==4){
            $('#Interest_Car').val(dataPromotion[1]);
            $('#InterestYear_Car').val( (dataPromotion[1]*12).toFixed(2) );
        }
        //------------------------------------------------------
        UpdateCal();
        //------------------------------------------------------
        // อัพเดต valuePromotion
        let promotion_selected = $("#Promotions").val();
        if ( promotion_selected != "" ) {
            let data_promotion = promotion_selected.split('/');
            $("#valuePromotion").val(data_promotion[0]);
        } else {
            $("#valuePromotion").val('');
        }
    });

    $('#Interest_Car').on('input', function() {
        var currentInput = $(this).val();
        $( '#' + $(this).data('input-y') ).val( (currentInput*12).toFixed(2) );
        $('#totalInterest_Car').val(currentInput);
        UpdateCal();
    });

    $('#InterestYear_Car').on('input', function() {
        var currentInput = $(this).val();
        let ins_m = (currentInput/12).toFixed(2)
        $( '#' + $(this).data('input-m') ).val( ins_m );
        $('#totalInterest_Car').val(ins_m);
        UpdateCal();
    });

    $('#Cash_Car').on("input", function () {
        var Getprice = document.getElementById($(this).attr('id')).value;
        var Setprice = Getprice.replace(/,/g, '');
        $(this).val(addCommas(Setprice));
        //HideCalPrice();
        RefreshCalPage();
        UpdateCal();
    });

    $('#Process_Car').on("input", function () {
        var Getprice = document.getElementById($(this).attr('id')).value;
        var Setprice = Getprice.replace(/,/g, '');
        $(this).val(addCommas(Setprice));
        UpdateCal();
    });


</script>

<!-- sweetalert2 Toast -->
<script>

    //const Cal_SR_Toast = Swal.mixin({
    var Cal_SR_Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: true,
        confirmButtonText: "เข้าใจแล้ว",
        timer: 5000,
        customClass: {
            popup: "cal-sr-toast-popup",
            confirmButton: "btn btn-sm btn-info mx-auto",
            //cancelButton: "btn btn-danger"
        },
        buttonsStyling: false,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // sweetalert2 Toast
    var rule_not_found_alert = false;

</script>

<script>

    function compareRuleRating( a, b ) {
        if ( a.Rating < b.Rating ){
            return 1;
        }
        if ( a.Rating > b.Rating ){
            return -1;
        }
        return 0;
    }

    var interst_rule = @json($InterstRule);
    function UpdateInterstRule() {
        var loan_code = ($('#CodeLoans').val() != '') ? $('#CodeLoans').val() : null;
        var year = ($("#RateYears").val() != '') ? $( "#RateYears option:selected" ).text() : null;
        var instl = ($("#Timelack_Car").val() != '') ? $("#Timelack_Car").val() : null;
        var total = ($("#Cash_Car").val() != '') ? $("#Cash_Car").val().replace(/,/g, '') : null;
        
        var _rule = [];
        $.each( interst_rule, function( index, item ) {
            if (item.Loan_Code == loan_code) {
                var check_rule = [];
                //------------------------------------
                if (item.Cond_YearStart != null) {
                    check_rule.push( ( year != null && year >= item.Cond_YearStart && year <= item.Cond_YearEnd) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.Cond_InstallmentStart != null) {
                    check_rule.push( ( instl != null && instl >= item.Cond_InstallmentStart && instl <= item.Cond_InstallmentEnd) );
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if (item.TotalStart != null) {
                    if (item.TotalEnd != null) {
                        check_rule.push( ( total != null && total >= item.TotalStart && total <= item.TotalEnd) );
                    } else {
                        check_rule.push( ( total != null && total >= item.TotalStart ) );
                    }
                } else {
                    check_rule.push(true);
                }
                //------------------------------------
                if ( !check_rule.includes(false) ) {
                    _rule.push( item );
                }
                //------------------------------------
            }
        });
        _rule = _rule.sort( compareRuleRating );
        var rule_update_alert = false;
        if ( _rule.length > 0 ) {
            // เช็คโปรโมชั่น ปรับดอกเบี้ย
            let Promotions = $('#Promotions').val();   
            let dataPromotion = Promotions.split('/');
            if( dataPromotion[2]==4 ){
                $('#Interest_Car').val(dataPromotion[1]);
                $('#InterestYear_Car').val( (dataPromotion[1]*12).toFixed(2) );
            } else {
                if ( parseFloat(_rule[0].Interest).toFixed(2) != $("#Interest_Car").val() ) {
                    $("#Interest_Car").val( parseFloat(_rule[0].Interest).toFixed(2) );
                    rule_update_alert = true;
                }
                if ( parseFloat(_rule[0].Interest*12).toFixed(2) != $("#InterestYear_Car").val() ) {
                    $("#InterestYear_Car").val( parseFloat(_rule[0].Interest*12).toFixed(2) );
                    rule_update_alert = true;
                }
                /*
                $("#Interest_Car").val( parseFloat(_rule[0].Interest).toFixed(2) );
                $("#InterestYear_Car").val( parseFloat(_rule[0].Interest*12).toFixed(2) );
                */
            }

            /*
            $("#Fee_Max").val(  _rule[0].Fee_Max );
            $("#Fee_Min").val(  _rule[0].Fee_Min );
            $("#Fee_Rate").val(  _rule[0].Fee_Rate );
            $("#Fine_Rate").val(  _rule[0].Fine_Rate );
            $("#Credo_Cond").val(  _rule[0].Credo_Cond );
            $("#Credo_BonusLTV").val(  _rule[0].Credo_BonusLTV );
            $("#Installment_REC").val(  _rule[0].Installment_REC );
            */
            if ($("#Fee_Max").val() != _rule[0].Fee_Max) {
                $("#Fee_Max").val( _rule[0].Fee_Max );
                rule_update_alert = true;
            }
            if ($("#Fee_Min").val() != _rule[0].Fee_Min) {
                $("#Fee_Min").val( _rule[0].Fee_Min );
                rule_update_alert = true;
            }
            if ($("#Fee_Rate").val() != _rule[0].Fee_Rate) {
                $("#Fee_Rate").val( _rule[0].Fee_Rate );
                rule_update_alert = true;
            }
            if ($("#Credo_Cond").val() != _rule[0].Credo_Cond) {
                $("#Credo_Cond").val( _rule[0].Credo_Cond );
                rule_update_alert = true;
            }
            if ($("#Credo_BonusLTV").val() != _rule[0].Credo_BonusLTV) {
                $("#Credo_BonusLTV").val( _rule[0].Credo_BonusLTV );
                rule_update_alert = true;
            }
            if ($("#Installment_REC").val() != _rule[0].Installment_REC) {
                $("#Installment_REC").val( _rule[0].Installment_REC );
                rule_update_alert = true;
            }

        } else {
            $("#Interest_Car").val( parseFloat(0).toFixed(2) );
            $("#InterestYear_Car").val( parseFloat(0).toFixed(2) )
            $("#Fee_Max").val('');
            $("#Fee_Min").val('');
            $("#Fee_Rate").val('');
            $("#Fine_Rate").val('');
            $("#Credo_Cond").val('');
            $("#Credo_BonusLTV").val('');
            $("#Installment_REC").val('');
            if (rule_not_found_alert == false) {
                Cal_SR_Toast.fire({
                    icon: "warning",
                    title: "<span class='fw-semibold'>ไม่อยู่ในเงื่อนไขของบริษัท !</span>",
                    //text: "(ดอกเบี้ย/ค่าธรรมเนียม/ระยะเวลาผ่อน/เบี้ยปรับล่าช้า/LTV)"
                    html: `<ul class="list-unstyled m-0 small"><li>กรุณาระบุ ดอกเบี้ย/ค่าธรรมเนียม/งวดที่จัด ด้วยตนเอง</li></ul>`,
                });
                rule_not_found_alert = true;
            }
        }

        if (rule_update_alert == true) {
            let fee_text = "";
            if ($("#Fee_Rate").val() == '') {
                fee_text = "<em>ไม่อยู่ในเงื่อนไข</em>";
            } else {
                fee_text = `<strong>${ parseFloat($("#Fee_Rate").val()).toFixed(2) }%</strong>`;
                let fee_info_text = "";
                if ($("#Fee_Min").val() != '0') {
                    fee_info_text = `ขั้นต่ำ: <strong>${ addCommas(Number( $("#Fee_Min").val() )) }</strong>`;
                } else if ($("#Fee_Min").val() == '0') {
                    fee_info_text = "ไม่มีขั้นต่ำ"
                }
                if ($("#Fee_Max").val() != '0') {
                    fee_info_text = `<strong>${ addCommas(Number( $("#Fee_Min").val() )) }</strong> - <strong>${ addCommas(Number( $("#Fee_Max").val() )) }</strong>`;
                }
                if (fee_info_text != "") {
                    fee_text += ` (${fee_info_text})`;
                }
            }

            let installment_rec_text = "";
            if ($("#Installment_REC").val() == '') {
                installment_rec_text = "<em>ไม่อยู่ในเงื่อนไข</em>";
            } else {
                installment_rec_text = `<strong>${$("#Installment_REC").val()}</strong>`;
            }

            Cal_SR_Toast.fire({
                icon: "info",
                title: "<span class='fw-semibold'>เงื่อนไขการเงินมีการอัปเดต !</span>",
                //text: "(ดอกเบี้ย/ค่าธรรมเนียม/ระยะเวลาผ่อน/เบี้ยปรับล่าช้า/LTV)"
                html: `<ul class="list-unstyled m-0 small">
                    <li><strong class="text-primary">ดอกเบี้ย:</strong> <strong>${$("#Interest_Car").val()}%</strong> (เดือน) <strong>${$("#InterestYear_Car").val()}%</strong> (ปี)</li>
                    <li><strong class="text-primary">ค่าธรรมเนียม:</strong> ${fee_text}</li>
                    <li><strong class="text-primary">งวดที่จัดได้:</strong> ${installment_rec_text}</li>
                </ul>`,
            });
        }
        
    }

    function UpdateInstallmentDropDown() {
        //------------------------------------------------------
        if ( $("#Installment_REC").val() != '') {
            var inst_range = $("#Installment_REC").val();
            var array_instl = inst_range.replaceAll(' ', '').split("-");
            if ( array_instl.length > 1 ) {
                let flag_color = false;
                $("#Timelack_Car option:not(:first)").each(function() {
                    $(this).removeClass("bg-secondary bg-success bg-soft");
                    $(this).attr('style', '');
                    if ( flag_color == true ) {
                        $(this).addClass("bg-success bg-soft");
                        $(this).attr('style', 'color: #248763 !important');
                        if ( $(this).val() == array_instl[1] ) {
                            flag_color = false;
                        }
                    } else if (flag_color == false) {
                        // Start
                        if ( $(this).val() == array_instl[0] ) {
                            $(this).addClass("bg-success bg-soft");
                            $(this).attr('style', 'color: #248763 !important');
                            flag_color = true;
                        } else {
                            $(this).addClass("bg-secondary bg-soft");
                            $(this).attr('style', 'color: #515463 !important');
                        }
                    }
                });
            } else {
                $("#Timelack_Car option:not(:first)").each(function() {
                    $(this).removeClass("bg-secondary bg-success bg-soft");
                    $(this).addClass("bg-secondary bg-soft");
                });
                $(`#Timelack_Car option[value="${array_instl[0]}"]`).addClass("bg-success bg-soft");
            }
        } else {
            $("#Timelack_Car option:not(:first)").each(function() {
                $(this).removeClass("bg-secondary bg-success bg-soft");
                $(this).addClass("bg-secondary bg-soft");
            });
        }
        //--------------------------------------
        // ถ้าเป็น ขายฝาก / จำนอง ให้แสดง 6 งวด
        let loan_code = $("#TypeLoans").find(':selected').data('loancode');
        let display_6_installments = (loan_code == '18' || loan_code == '16')
        if (display_6_installments == true) {
            $('#Timelack_Car option[value="6"]').show();
        } else {
            $('#Timelack_Car option[value="6"]').hide();
        }
        //------------------------------------------------------
    }

    function roundNumberFee(num) {
        return Math.ceil(num / 50) * 50;
    }

    function UpdateFee() {
        //------------------------------------------------------
        if (!isNaN(+($("#Fee_Rate").val()))) {
            var FeeRate_Display = $("#Fee_Rate").val();
            var FeeMin_Display = $("#Fee_Min").val();
            var FeeMax_Display = $("#Fee_Max").val();
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
        } else {
            //$('#Process_Car').val(Number(0));
        }
    }

    function UpdateCal() {
        let TypeLoans = $("#TypeLoans").find(':selected').data('loancode');
        let Cash_Car = $('#Cash_Car').val().replace(/,/g, '');
        let Timelack = $('#Timelack_Car').val();
        let Interest_m = parseFloat($('#Interest_Car').val());
        let Interest_y = parseFloat($('#InterestYear_Car').val());
        //-------------------------------------------------------------------
        let Promotions = $('#Promotions').val();   
        let dataPromotion = Promotions.split('/');
        let MidPrice = $("#RatePrices").val();            //ราคากลาง
        MidPrice = Number( MidPrice.replace(/,/g, '') );
        //-------------------------------------------------------------------
        let Topcar = ( Cash_Car != '') ? parseFloat(Cash_Car) : 0;
        //-------------------------------------------------------------------
        if ( MidPrice != '') {
            let PCT_car = ( Topcar * 100 / MidPrice ).toFixed(0);
            $('#Percent_Car').val(PCT_car);
        }
        //-------------------------------------------------------------------
        
        //-------------------------------------------------------------------
        let Tax_Percent = 1;
        if (TypeLoans == '01') { // เช่าซื้อรถยนต์ มีภาษี
            Tax_Percent = 1.07;
        }
        $('#Vat_Rate').val( Tax_Percent * 100 - 100 );
        //-------------------------------------------------------------------
        // โปรโมชั่น ลดค่าประกัน
        var Premium = $("#_Temp_Insurance_PA").val();
        if(dataPromotion[2]==3){
            Premium = Math.ceil( Premium - ( Premium * dataPromotion[1]) );
            Premium = Math.ceil(Premium/10)*10;
        }
        //-------------------------------------------------------------------
        // หายอดจัด
        
        /*
        if ( $('#Include_PA_Yes').is(":checked") ) {
            // เช็คว่าคำนวณแบบรวมค่าธรรมเนียม
            TopcarTotal += Number(Premium);
        }
        */
        //-------------------------------------------------------------------
        // หาตารางดอกเบี้ย ของแต่ละงวด
        var Instl_Table = [];
        //------------------------------------------------------
        // หา ช่วง จำนวนงวดที่แนะนำ
        if ( $("#Installment_REC").val() != '') {
            //---------------------------------------------------------
            // ลูป เพื่อสร้างตารางจำนวนงวด ก่อน
            var instl_range = $("#Installment_REC").val();
            var array_instl = instl_range.replaceAll(' ', '').split("-");
            if ( array_instl.length > 1 ) {
                var end_loop_create_ins_table = false;
                var _instl = Number(array_instl[0]);
                do {
                    if (_instl == Number( array_instl[1] ) ) {
                        end_loop_create_ins_table = true;
                    }
                    Instl_Table[_instl] = -1; // ค่าเริ่มต้น -1
                    _instl += 6;
                }
                while (end_loop_create_ins_table == false);
            } else {
                Instl_Table[ array_instl[0] ] = -1; // ค่าเริ่มต้น -1
            }
            console.log( Instl_Table );
            
        }
        //-----------------------------------
        //---------------------------------------------------------
            // ใส่ข้อมูลของ จำนวนงวดปัจจุบันลงไป
            if ( $("#Timelack_Car").val() != '' ) {
                Instl_Table[ $("#Timelack_Car").val() ] = {
                    ins: parseFloat( $("#Interest_Car").val() ),
                    fee_rate: parseFloat( $("#Fee_Rate").val() ),
                    fee_min: Number( $("#Fee_Min").val() ),
                    fee_max: Number( $("#Fee_Max").val() ),
                };
            }
            //---------------------------------------------------------
            // ใส่ข้อมูลของงวดอื่น ๆ ลงไปให้ครบ
            while( Instl_Table.includes(-1) ) {
                // หากฎ
                var year = ($("#RateYears").val() != '') ? $( "#RateYears option:selected" ).text() : null;
                var instl = Instl_Table.indexOf(-1);
                //var total = ($("#Cash_Car").val() != '') ? $("#Cash_Car").val().replace(/,/g, '') : null;
                // Topcar
                
                var _rule = [];
                $.each( interst_rule, function( index, item ) {
                    if (item.Loan_Code == TypeLoans) {
                        var check_rule = [];
                        if (item.Cond_YearStart != null) {
                            check_rule.push( ( year != null && year >= item.Cond_YearStart && year <= item.Cond_YearEnd) );
                        } else {
                            check_rule.push(true);
                        }
                        if (item.Cond_InstallmentStart != null) {
                            check_rule.push( ( instl != null && instl >= item.Cond_InstallmentStart && instl <= item.Cond_InstallmentEnd) );
                        } else {
                            check_rule.push(true);
                        }
                        if (item.Cond_YearStart != null) {
                            check_rule.push( ( year != null && year >= item.Cond_YearStart && year <= item.Cond_YearEnd) );
                        } else {
                            check_rule.push(true);
                        }
                        if ( !check_rule.includes(false) ) {
                            _rule.push( item );
                        }
                    }
                });
                _rule = _rule.sort( compareRuleRating );
                if ( _rule.length > 0 ) {
                    // เจอกฎแล้ว

                    // เช็คว่าเงื่อนไขที่เจอมี จำนวนงวดเป็นเงื่อนไขหรือไม่
                    if (_rule[0].Cond_InstallmentStart != null) {
                        // ใส่ข้อมูลลงไปตามทุกเงื่อนไขในกฎข้อนั้น
                        var _instl_start = _rule[0].Cond_InstallmentStart;
                        var _instl_end = _rule[0].Cond_InstallmentEnd;
                        // ตรวจสอบว่า เงื่อนไขเป็นช่วงหลายจำนวนงวดรึเปล่า
                        if ( _instl_start != _instl_end ) {
                            // ถ้าเป็นหลายจำนวนงวด ให้นำค่ามาใส่ให้หมด
                            // ใส่ค่าดอกเบี้ย ค่าธรรมเนียม ลงไปในตาราง
                            var end_loop_update_ins_table = false;
                            var _instl = Number(_instl_start);
                            do {
                                if (_instl == Number(_instl_end) ) {
                                    end_loop_update_ins_table = true;
                                }

                                // เช็ค โปรโมชั่น ปรับดอกเบี้ยเท่ากับค่าที่กำหนด
                                let _interest = 0;
                                if(dataPromotion[2]==4) {
                                    _interest = parseFloat(dataPromotion[1]);
                                } else {
                                    _interest = parseFloat(_rule[0].Interest);
                                };

                                // ใส่ค่าลงไป
                                Instl_Table[_instl] = {
                                    ins: _interest,
                                    fee_rate: parseFloat( _rule[0].Fee_Rate ),
                                    fee_min: Number( _rule[0].Fee_Min ),
                                    fee_max: Number( _rule[0].Fee_Max ),
                                };
                                _instl += 6;
                            }
                            while (end_loop_update_ins_table == false);
                        } else {

                            // เช็ค โปรโมชั่น ปรับดอกเบี้ยเท่ากับค่าที่กำหนด
                            let _interest = 0;
                            if(dataPromotion[2]==4) {
                                 _interest = parseFloat(dataPromotion[1]);
                            } else {
                                _interest = parseFloat(_rule[0].Interest);
                            };

                            // ถ้าเป็นงวดเดียวกัน ให้เติมค่าลงไป 1 ค่า
                            Instl_Table[_instl_start] = {
                                ins: _interest,
                                fee_rate: parseFloat( _rule[0].Fee_Rate ),
                                fee_min: Number( _rule[0].Fee_Min ),
                                fee_max: Number( _rule[0].Fee_Max ),
                            };
                        }
                    } else {
                        //--------------------------------------------------
                        // กรณีที่ ไม่มีจำนวนงวดเป็นเงื่อนไขของกฎนี้
                        // ให้ถือว่า ทุกงวด มีดอกเบี้ยเท่าเทียมกัน
                        // สร้างกราฟ แค่ จำนวนงวดที่แนะนำก็พอ
                        //     array_instl คือ ช่วงจำนวนงวดที่แนะนำ (เป็นข้อมูลเดิม)
                        //--------------------------------------------------
                        // ใส่ข้อมูลลงไปตามทุกเงื่อนไขในกฎข้อนั้น
                        var _instl_start = Number(array_instl[0]);
                        var _instl_end = Number(array_instl[1]);
                        // ตรวจสอบว่า เงื่อนไขเป็นช่วงหลายจำนวนงวดรึเปล่า
                        if ( _instl_start != _instl_end ) {
                            // ถ้าเป็นหลายจำนวนงวด ให้นำค่ามาใส่ให้หมด
                            // ใส่ค่าดอกเบี้ย ค่าธรรมเนียม ลงไปในตาราง
                            var end_loop_update_ins_table = false;
                            var _instl = Number(_instl_start);
                            do {
                                if (_instl == Number(_instl_end) ) {
                                    end_loop_update_ins_table = true;
                                }

                                // เช็ค โปรโมชั่น ปรับดอกเบี้ยเท่ากับค่าที่กำหนด
                                let _interest = 0;
                                if(dataPromotion[2]==4) {
                                    _interest = parseFloat(dataPromotion[1]);
                                } else {
                                    _interest = parseFloat(_rule[0].Interest);
                                };

                                // ใส่ค่าลงไป
                                Instl_Table[_instl] = {
                                    ins: _interest,
                                    fee_rate: parseFloat( _rule[0].Fee_Rate ),
                                    fee_min: Number( _rule[0].Fee_Min ),
                                    fee_max: Number( _rule[0].Fee_Max ),
                                };
                                _instl += 6;
                            }
                            while (end_loop_update_ins_table == false);
                        } else {

                            // เช็ค โปรโมชั่น ปรับดอกเบี้ยเท่ากับค่าที่กำหนด
                            let _interest = 0;
                            if(dataPromotion[2]==4) {
                                 _interest = parseFloat(dataPromotion[1]);
                            } else {
                                _interest = parseFloat(_rule[0].Interest);
                            };

                            // ถ้าเป็นงวดเดียวกัน ให้เติมค่าลงไป 1 ค่า
                            Instl_Table[_instl_start] = {
                                ins: _interest,
                                fee_rate: parseFloat( _rule[0].Fee_Rate ),
                                fee_min: Number( _rule[0].Fee_Min ),
                                fee_max: Number( _rule[0].Fee_Max ),
                            };
                        }
                    }
                    
                } else {
                    // กรณีที่ไม่เจอกฎไหนเลย :'(
                    // ให้ใส่ค่า 0 ลงไป ทำจนกว่าจะจบ loop
                    Instl_Table[instl] = {
                        ins: 0.00,
                        fee_rate: 0,
                        fee_min: 0,
                        fee_max: 0,
                    };
                }
            }
            //---------------------------------------------------------
        //---------------------------------------------------------

        RemovePA_Data();
        RefreshInstlTable();

        if ( Instl_Table.length > 0 ) {

            // loop ตารางจำนวนงวด เพื่อสร้างข้อมูลแต่ละชุด
            $.each( Instl_Table, function( index, item ) {
                if ( typeof(item) != 'undefined') {
                    
                    //var calculation = Get_Cal_And_PA(Topcar, item.ins, index, TypeLoans);

                    /*
                        'cal_period': period,
                        'cal_totalPeriod': totalPeriod,
                        'pa': {
                            'premium': Number(pa_obj[`TimeRack${installment}`]),
                            'plan_name': pa_obj['Plan_Insur'],
                            'limit_loan': Number(pa_obj['Limit_Insur']),
                            'id_pa': pa_obj['id']
                        },
                        'cal_PA_period': calPeriod_withPA['period'],
                        'cal_PA_totalPeriod': calPeriod_withPA['totalPeriod'],
                        'pa_include': {
                            'premium': Number(pa_obj_include[`TimeRack${installment}`]),
                            'plan_name': pa_obj_include['Plan_Insur'],
                            'limit_loan': Number(pa_obj_include['Limit_Insur']),
                            'id_pa': pa_obj_include['id']
                        }
                    */

                    let row_selected = false;
                    // เช็คว่า ระยะเวลาผ่อน ที่กำลังแสดงเป็น ระยะเวลาผ่อนที่ลูกค้าเลือกหรือไม่ ถ้าเลือกให้ปรับดอกเบี้ย
                    if ( $('#Timelack_Car').val() != '' && index == $('#Timelack_Car').val() ) {
                        var _ins_timelack = parseFloat( $("#Interest_Car").val() );
                        var calculation = Get_Cal_And_PA(Topcar, _ins_timelack, index, TypeLoans);
                        // ส่งค่าไปแสดง
                        UpdatePA_Data(calculation);
                        SetCalculationValue(calculation,  $('#Timelack_Car').val(), Topcar, _ins_timelack);
                        row_selected = true;
                    } else {
                        var calculation = Get_Cal_And_PA(Topcar, item.ins, index, TypeLoans);
                    }

                    var _tbdy = document.getElementById('table_instl_container').getElementsByTagName('table')[0].getElementsByTagName('tbody')[0];
                    let new_row = _tbdy.insertRow();
                    if (row_selected == true) new_row.classList.add("table-success");
                    /*
                    let row_data = {
                        timelack: index,
                        period: addCommas(calculation['cal_period']),
                        total_period: addCommas(calculation['cal_totalPeriod']),
                        period_PA: addCommas(calculation['cal_PA_period']),
                        total_period_PA: addCommas(calculation['cal_PA_totalPeriod']),
                        plan_name: calculation['plan_name'] + ' <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip" title="วงเงิน ' + addCommas(calculation['limit_loan']) + ' บาท"></i>', addCommas(calculation['limit_loan']), addCommas(calculation['premium']) };
                    for (let key of row_data) {
                        let td = document.createElement("td");
                        let text = document.createTextNode(key);
                        td.appendChild(text);
                        new_row.appendChild(td);
                    }
                    */

                    let pa_plane_name = Number( calculation['pa']['plan_name'].split(" ")[1]);
                    let pa_include_plane_name = Number( calculation['pa_include']['plan_name'].split(" ")[1]);
                    
                    $(new_row).append(`<th>${index}</th>
                        <td>${addCommas(calculation['cal_period'])}</td>
                        <td>${addCommas(calculation['cal_totalPeriod'])}</td>
                        <td><span class="pe-2">${pa_plane_name}</span><i class="fas fa-question-circle text-info" data-bs-toggle="tooltip" title="วงเงิน ${addCommas(calculation['pa']['limit_loan'])} บาท"></i></td>
                        <td>${addCommas(calculation['pa']['premium'])}</td>

                        <td>${addCommas(calculation['cal_PA_period'])}</td>
                        <td>${addCommas(calculation['cal_PA_totalPeriod'])}</td>
                        <td><span class="pe-2">${pa_include_plane_name}</span><i class="fas fa-question-circle text-info" data-bs-toggle="tooltip" title="วงเงิน ${addCommas(calculation['pa_include']['limit_loan'])} บาท"></i></td>
                        <td>${addCommas(calculation['pa_include']['premium'])}</td>`);

                    //5px var(--bs-success) solid

                    /*
                    $('#table_instl_container table tbody').append(`<tr><td>${index}</td><td>${ calculation['cal_period'] }</td><td>${ calculation['cal_totalPeriod'] }</td><td>${ calculation['cal_PA_period'] }</td><td>${ calculation['cal_PA_totalPeriod'] }</td><td>${ calculation['plan_name'] }</td><td>${ calculation['limit_loan'] }</td><td>${ calculation['premium'] }</td></tr>`);
                    */

                }
            });
            //------------------------------------------------------------------------------------------
            // ใส่สีขอบให้ตาราง
            let head_item;
            let column_array;
            let last_index;
            if ( $('#Include_PA_Yes').is(":checked") ) {
                head_item = $("#table_instl_container table thead tr:nth-child(2) th:nth-child(5)");
                column_array = $("#table_instl_container table tbody tr td:nth-child(6)");
            } else {  // ไม่ได้ซื้อ PA
                head_item = $("#table_instl_container table thead tr:nth-child(2) th:nth-child(1)");
                column_array = $("#table_instl_container table tbody tr td:nth-child(2)");
            }
            last_index = column_array.length - 1;
            head_item.css({"border-top": "3px var(--bs-success) solid", "border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid"});
            column_array.each(function( index, item ) {
                if ( index != last_index ) {
                    $(item).css({"border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid"});
                } else {
                    $(item).css({"border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid", "border-bottom": "3px var(--bs-success) solid"});
                }
            });
            //------------------------------------------------------------------------------------------
            $('[data-bs-toggle="tooltip"]').tooltip();

            //--------------------------------------------------------
            // ทำให้กลายเป็น datatable
            var table = $('#table_instl_container table').DataTable({
                dom: "t",//'tB',
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                    //'print',
                    {
                        extend: "print",
                        text: '<i class="bx bx-printer align-middle"></i> ปริ้นต์',
                        className: 'btn-sm p-1 printTableBtn',
                        messageTop: 'ตารางแสดงอัตราการผ่อนชำระต่อเดือน Chookiat Surat',
                        customize: function(win) {
                            let timelack = $('#Timelack_Car').val();
                            if (timelack != '') {
                                $(win.document.body)
                                    .find(`table tbody tr`)
                                    .each(function (index) {
                                        let table_timelack = $(this).find("td:eq(0)").text();
                                        if (table_timelack == timelack) {
                                            $(this).addClass('table-success');
                                        }
                                    });
                            }
                            let head_item;
                            let column_array;
                            let last_index;
                            if ( $('#Include_PA_Yes').is(":checked") ) {
                                head_item = $(win.document.body).find("table thead tr th:nth-child(6)");
                                column_array = $(win.document.body).find("table tbody tr td:nth-child(6)");
                            } else {  // ไม่ได้ซื้อ PA
                                head_item = $(win.document.body).find("table thead tr th:nth-child(2)");
                                column_array = $(win.document.body).find("table tbody tr td:nth-child(2)");
                            }
                            last_index = column_array.length - 1;
                            head_item.css({"border-top": "3px var(--bs-success) solid", "border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid"});
                            column_array.each(function( index, item ) {
                                if ( index != last_index ) {
                                    $(item).css({"border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid"});
                                } else {
                                    $(item).css({"border-left": "3px var(--bs-success) solid", "border-right": "3px var(--bs-success) solid", "border-bottom": "3px var(--bs-success) solid"});
                                }
                            });
                            $(win.document.body).find("table thead tr th").each(function( index, item ) {
                                $(item).addClass('text-center');
                            });
                            $(win.document.body).find("table thead").prepend("<tr><th></th><th colspan='4' class='text-center'>ไม่รวมประกัน PA ในยอดจัด</th><th colspan='4' class='text-center'>รวมประกัน PA ในยอดจัด</th></tr>");
                            
                            /*
                            $(win.document.body)
                                .find("table tbody tr")
                                .each(function (index) {
                                    

                                    var status = $(this).find("td:eq(7)").text();
                                    console.log(status);

                                    if (status === "Offer") {
                                        $(this).css("background-color", "#42f5f5");
                                    }
                                    if (status === "Pending") {
                                        $(this).css("background-color", "#ca97ca");
                                    }
                                    if (status === "Pocket") {
                                        $(this).css("background-color", "#85f56e");
                                    }
                                    if (status === "TOM") {
                                        $(this).css("background-color", "#f5da6e");
                                    }
                                });
                            */
                        
                        }
                    }

                ],
                ordering: false,
                paging: false,
                keys: true, //enable KeyTable extension
            });
        }
        //-------------------------------------------------------------------
    }

    function RemovePA_Data() {
        $("#Plan_PA_Show").val('');
        $("#Show_Insurance_PA").val( '' );
    }

    function UpdatePA_Data(cal_obj) {

        if ( $('#Include_PA_Yes').is(":checked") ) {
            $("#Plan_PA_Show").val( cal_obj['pa_include']['plan_name'] + ': ' + addCommas( cal_obj['pa_include']['limit_loan'] ) + ' บาท');
            $("#Show_Insurance_PA").val( addCommas( cal_obj['pa_include']['premium'] ) );
        } else {
            $("#Plan_PA_Show").val( cal_obj['pa']['plan_name'] + ': ' + addCommas( cal_obj['pa']['limit_loan'] ) + ' บาท');
            $("#Show_Insurance_PA").val( addCommas( cal_obj['pa']['premium'] ) );
        }
        
    }

    function SetCalculationValue(cal_obj, Timelack, Topcar, Interest_m) {

        if ( $('#Buy_PA_Yes').is(":checked") ) {
            if ( $('#Include_PA_Yes').is(":checked") ) {
                $("#Plan_PA").val( cal_obj['pa_include']['id_pa'] );
                $("#Insurance_PA").val( cal_obj['pa_include']['premium'] );
            } else {
                $("#Plan_PA").val( cal_obj['pa']['id_pa'] );
                $("#Insurance_PA").val( cal_obj['pa']['premium'] );
            }
        } else {
            $("#Plan_PA").val('');
            $("#Insurance_PA").val('');
        }
        
        // ส่วนการเก็บค่ารอบันทึก
        let _period;
        let _totalPeriod;
        if ( $('#Include_PA_Yes').is(":checked") ) {
            _period = cal_obj['cal_PA_period'];
            _totalPeriod = cal_obj['cal_PA_totalPeriod'];
        } else {
            _period = cal_obj['cal_period'];
            _totalPeriod = cal_obj['cal_totalPeriod'];
        }

        let _topcarTotal = Topcar;
        let text_totaltop_sum = '(' + addCommas(Topcar);
        let Add_Fee = $('#Process_Car').val().replace(/,/g, '');
        if ( $('#StatusProcess_Car_Yes').is(":checked") ) {
            // เช็คว่าคำนวณแบบรวมค่าธรรมเนียม
            _topcarTotal += Number( Add_Fee );
            text_totaltop_sum += ' + ' + Number(Add_Fee);
        }
        if ( $('#Include_PA_Yes').is(":checked") ) {
            // เช็คว่าคำนวณแบบรวมค่าธรรมเนียม
            _topcarTotal += Number( cal_obj['pa_include']['premium'] );
            text_totaltop_sum += " + " + addCommas(Number( cal_obj['pa_include']['premium'] ));
        }
        text_totaltop_sum += ')';

        //$('#TotalTop').html( "<span class='font-italic mr-2' style='font-size:13px'>(" + addCommas(Topcar) + " + " + addCommas(Number(Add_Fee)) + " + " + addCommas(Number(Premium)) + ")</span>" + addCommas(TopcarTotal.toFixed(2)) + " ฿");
        $('#TotalTop').html(addCommas(_topcarTotal.toFixed(2)) + " ฿");
        $('#TotalTop_sum span').html( text_totaltop_sum );

        $('#Period').html(addCommas(_period.toFixed(2)) + " ฿");
        $('#TotalPeriod').html(addCommas(_totalPeriod.toFixed(2)) + " ฿");

        $('#Timelack').html(Timelack + " งวด");

        $('#Period_Rate').val(_period);
        $('#TotalPeriod_Rate').val(_totalPeriod);

        let Tax_Percent = 1;
        let TypeLoans = String( $("#TypeLoans").find(':selected').data('loancode') );
        if (TypeLoans == '01') { // เช่าซื้อรถยนต์ มีภาษี
            Tax_Percent = 1.07;
            $('.tax-display').show();
        } else {
            $('.tax-display').hide();
        }

        //----------------------------------
        // โปรโมชั่น ส่วนลดดอกเบี้ย
        // dataPromotion[2] == 1
        let Promotions = $('#Promotions').val();
        let dataPromotion = Promotions.split('/');
        var month_with_ins = Timelack;
        if (dataPromotion[2]==1) { // โปรโมชั่น ส่วนลดดอกเบี้ย
            month_with_ins -= dataPromotion[1];
        }
        //----------------------------------

        var Duerate = (_period / Tax_Percent);
        var TotalDuerate = Duerate * Timelack;
        var Tax = _period - Duerate;
        var TotalTax = Tax.toFixed(2) * Timelack;
        var Interest_Price = (_topcarTotal * (Interest_m/100) * ( month_with_ins ));
        
        //console.log(TotalPeriod - Topcar);
        $('#Profit_Rate').val(_totalPeriod - Topcar);

        $('#Tax_Number').html(addCommas(Tax.toFixed(2)) + " ฿");
        $('#Tax_Total').html(addCommas(TotalTax.toFixed(2)) + " ฿");
        $('#Duerate').html(addCommas(Duerate.toFixed(2)) + " ฿");
        $('#Duerate_Total').html(addCommas(TotalDuerate.toFixed(2)) + " ฿");
        $('#Interest_Price').html(addCommas(Interest_Price.toFixed(2)) + " ฿");

        $('#Tax_Rate').val( Tax.toFixed(2) );
        $('#Tax2_Rate').val( TotalTax.toFixed(2) );
        $('#Duerate_Rate').val( Duerate.toFixed(2) );
        $('#Duerate2_Rate').val( TotalDuerate.toFixed(2) );
        $('#totalInterest_Car').val( $('#Interest_Car').val() );
        
    }

    function UpdatePAInput() {
        if ( $('#Buy_PA_Yes').is(":checked") ) {
            $('#Include_PA_Yes').attr('readonly',false);
            $('#Include_PA_No').attr('readonly',false);
            $('.input_PA_include').removeClass('opacity-25');
        } else {
            $('#Include_PA_Yes').attr('readonly',true);
            $('#Include_PA_No').attr('readonly',true);
            $('#Include_PA_No').prop( "checked", true );
            $('.input_PA_include').addClass('opacity-25');
        }
    }

</script>

<!-- หาประกัน PA และสร้างตาราง -->
<script>
    var parseInsurPrice = @json($insurPrice);
    function comparePlanPA( a, b ) {
        if ( Number(a.Limit_Insur) < Number(b.Limit_Insur) ){
            return -1;
        }
        if ( Number(a.Limit_Insur) > Number(b.Limit_Insur) ){
            return 1;
        }
        return 0;
    }
    parseInsurPrice = parseInsurPrice.sort( comparePlanPA );

    function GetInsurPrice_PA_ByTotalPay(totalPeriod) {
        let pa_by_total = null;
        for( let val of parseInsurPrice ){
            if(val.Limit_Insur > totalPeriod){
                pa_by_total = val;
                break;
            }
        }
        //-----------------------------------------------------------
        if (pa_by_total == null ) {
            return GetInsurPrice_PA_LastPlan();
        } else {
            return pa_by_total;
        }
    }

    function GetInsurPrice_PA_ById(id) {
        var pa_with_id = parseInsurPrice.filter(
            function(data) {
                return data.id == id
            }
        );
        return pa_with_id[0];
    }

    function GetInsurPrice_PA_NextPlan(plan_name) {
        let old_plan = Number(plan_name.split(" ")[1]);
        let new_plan_name = 'Plan ' + (old_plan + 1).toString();
        let pa_with_name = parseInsurPrice.filter(
            function(data) {
                return data.Plan_Insur == new_plan_name
            }
        );
        //-----------------------------------------------------------
        if (pa_with_name.length == 0 ) {
            return GetInsurPrice_PA_LastPlan();
        } else {
            return pa_with_name[0];
        }
        
    }

    function GetInsurPrice_PA_LastPlan() {
        let lastest_pa_index = parseInsurPrice.length - 1;
        return parseInsurPrice[lastest_pa_index];
    }

    function CalPeriodAndTotal(topCar, ins, installment, loanCode) {
        // คำนวณ ยอดชำระทั้งหมด
        var tax_rate, principle;
        //------------------------
        if (loanCode == '01') {
            tax_rate = 1.07;
            principle = topCar;
        } else if (loanCode == '18' || loanCode == '16') {
            tax_rate = 1;
            principle = 0;
        } else {
            tax_rate = 1;
            principle = topCar;
        }
        //----------------------------------
        // โปรโมชั่น ส่วนลดดอกเบี้ย
        // dataPromotion[2] == 1
        let Promotions = $('#Promotions').val();
        let dataPromotion = Promotions.split('/');
        var month_with_ins = installment;
        if (dataPromotion[2]==1) { // โปรโมชั่น ส่วนลดดอกเบี้ย
            month_with_ins -= dataPromotion[1];
        }
        //----------------------------------
        var interest = topCar * ( ins / 100 ) * month_with_ins;
        //var period = Math.ceil( ( (interest + principle) * tax_rate / installment ).toFixed(2) / 10 ) * 10;
        var period = 0;
        if (loanCode == '18' || loanCode == '16') {
            // 18 16 ไม่มีการปัด
            period = ( (interest + principle) * tax_rate / installment ).toFixed(2) / 10 * 10;
        } else {
            period = Math.ceil( ( (interest + principle) * tax_rate / installment ).toFixed(2) / 10 ) * 10;
        }
        var totalPeriod = period * installment;
        //------------------------
        if (loanCode == '18' || loanCode == '16') {
            totalPeriod += topCar;
        } 
        //------------------------
        return {
            period: period,
            totalPeriod: totalPeriod,
        }
    }

    function Get_Cal_And_PA(topCar, ins, installment, loanCode) {
        //---------------------------------------------------
        let Add_Fee = $('#Process_Car').val().replace(/,/g, '');
        if ( $('#StatusProcess_Car_Yes').is(":checked") ) {
            // เช็คว่าคำนวณแบบรวมค่าธรรมเนียม
            topCar += Number(Add_Fee);
        }
        //-------------------------------------------------------------------------
        var calPeriod = CalPeriodAndTotal(topCar, ins, installment, loanCode);
        var period = calPeriod['period'];
        var totalPeriod = calPeriod['totalPeriod'];
        //-------------------------------------------------------------------------
        let pa_obj = GetInsurPrice_PA_ByTotalPay(totalPeriod);
        let premium = Number(pa_obj[`TimeRack${installment}`]);
        let limit_loan = Number(pa_obj['Limit_Insur']);
        //-------------------------------------------------------------------------
        // โปรโมชั่น ลดค่าประกัน PA 
        // dataPromotion[2] == 3
        let Promotions = $('#Promotions').val();   
        let dataPromotion = Promotions.split('/');
        if(dataPromotion[2]==3){
            premium = Math.ceil( premium - ( premium * dataPromotion[1]) );
            premium = Math.ceil(premium/10)*10;
        }
        //----------------------------------
        let pa_obj_include;
        //----------------------------------
        // เช็คว่า PA แผนนี้ ถ้ารวมจะเกินแผนวงเงินหรือไม่
        var calPeriod_withPA = CalPeriodAndTotal(topCar + premium, ins, installment, loanCode);
        if ( calPeriod_withPA['totalPeriod'] > limit_loan ) {
            // เกินวงเงิน ขยับ PA ไปข้างหน้าอีก 1 แผน
            pa_obj_include = GetInsurPrice_PA_NextPlan( pa_obj['Plan_Insur'] );
            premium = Number(pa_obj_include[`TimeRack${installment}`]);
            //----------------------------------
            // โปรโมชั่น ลดค่าประกัน PA 
            // dataPromotion[2] == 3
            if(dataPromotion[2]==3){
                premium = Math.ceil( premium - ( premium * dataPromotion[1]) );
                premium = Math.ceil(premium/10)*10;
            }
            //----------------------------------
            calPeriod_withPA = CalPeriodAndTotal(topCar + premium, ins, installment, loanCode);
        } else {
            pa_obj_include = pa_obj;
        }
        //-------------------------------------------------------------------------
        // ส่ง Cal ธรรมดาไป
        // ส่ง Cal with PA
        // ส่ง PA 
        return {
            'cal_period': period,
            'cal_totalPeriod': totalPeriod,
            'pa': {
                'premium': Number(pa_obj[`TimeRack${installment}`]),
                'plan_name': pa_obj['Plan_Insur'],
                'limit_loan': Number(pa_obj['Limit_Insur']),
                'id_pa': pa_obj['id']
            },
            'cal_PA_period': calPeriod_withPA['period'],
            'cal_PA_totalPeriod': calPeriod_withPA['totalPeriod'],
            'pa_include': {
                'premium': Number(pa_obj_include[`TimeRack${installment}`]),
                'plan_name': pa_obj_include['Plan_Insur'],
                'limit_loan': Number(pa_obj_include['Limit_Insur']),
                'id_pa': pa_obj_include['id']
            }
        };
    }

    //-------------------------------------------------------------------
    // วาดตาราง
    function RefreshInstlTable() {
        var table_container = document.getElementById('table_instl_container');
        table_container.innerHTML = '';
        var tbl = document.createElement('table');
        tbl.style.width = '100%';
        //tbl.setAttribute('border', '1');
        tbl.classList.add("table", "table-sm", "table-striped-col", "text-center", "align-middle", "m-0");

        let thead = tbl.createTHead();
        thead.classList.add("table-light");
        let row0 = thead.insertRow();
        //----------------------------------------------------
        var th0 = document.createElement('th');
        th0.classList.add("align-middle", "text-center");
        var text0 = document.createTextNode('ระยะเวลาผ่อน');
        th0.setAttribute('rowSpan', '2')
        th0.appendChild(text0);
        row0.appendChild(th0);
        //----------------------------------------------------
        var th1 = document.createElement('th');
        th1.classList.add("align-middle", "text-center");
        var text1 = document.createTextNode('ไม่รวมประกัน PA ในยอดจัด');
        th1.setAttribute('colspan', '4')
        th1.appendChild(text1);
        row0.appendChild(th1);
        //----------------------------------------------------
        var th2 = document.createElement('th');
        th2.classList.add("align-middle", "text-center");
        var text2 = document.createTextNode('รวมประกัน PA ในยอดจัด');
        th2.setAttribute('colspan', '4')
        th2.appendChild(text2);
        row0.appendChild(th2);

        //----------------------------------------------------

        let row = thead.insertRow();
        let head_data = ['ค่างวด', 'รวมยอดชำระ', 'แผนประกัน', 'เบี้ยประกัน', 'ค่างวด', 'รวมยอดชำระ', 'แผนประกัน', 'เบี้ยประกัน']
        for (let key of head_data) {
            let th = document.createElement("th");
            th.classList.add("align-middle", "text-center");
            let text = document.createTextNode(key);
            th.appendChild(text);
            row.appendChild(th);
        }

        var tbdy = document.createElement('tbody');
        var tfot = document.createElement('tfoot');

        tbl.appendChild(thead);
        tbl.appendChild(tbdy);
        tbl.appendChild(tfot);
        table_container.appendChild(tbl)
    }


</script>


<!-- addCommas -->
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

<!-- ปุ่มบันทึก -->
<script>
    $('#btn_SubmitCalculate').click(function() {
		var dataform = document.querySelectorAll('#createCalculates');
		var validate = validateForms(dataform);
		if (validate == true) {
            let Cal_id = $('#Cal_id').val();
            let _token = $('input[name="_token"]').val();
            let data = {};
            $("#createCalculates").serializeArray().map(function(x) {
                data[x.name] = x.value;
            });

            $('#btn_SubmitCalculate,.btn_closeCal').prop('disabled', true);
            $('.addSpin').empty();
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");

            if (Cal_id != '') {
                var link = "{{ route('ControlCenter.update', 'id') }}";
                var url = link.replace('id', Cal_id);
                var method = "put";
            } else {
                var url = "{{ route('ControlCenter.store') }}";
                var method = "post";
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
                    $('#modal_xl_2').modal('hide');
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: `ERROR ` + err.status + ` !!!`,
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                    });
                    $('#btn_SubmitCalculate,.btn_closeCal').prop('disabled', false);
                }
            })
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

    /*
    function ProcessAjaxSave() {
        let Cal_id = $('#Cal_id').val();
		let _token = $('input[name="_token"]').val();
		let data = {};
		$("#createCalculates").serializeArray().map(function(x) {
			data[x.name] = x.value;
		});

		$('#btn_SubmitCalculate,.btn_closeCal').prop('disabled', true);
		$('.addSpin').empty();
		$('<span />', {
			class: "spinner-border spinner-border-sm",
			role: "status"
		}).appendTo(".addSpin");

		if (Cal_id != '') {
			var link = "{{ route('ControlCenter.update', 'id') }}";
			var url = link.replace('id', Cal_id);
			var method = "put";
		} else {
			var url = "{{ route('ControlCenter.store') }}";
			var method = "post";
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
				$('#modal_xl_2').modal('hide');
			},
			error: function(err) {
				Swal.fire({
					icon: 'error',
					title: `ERROR ` + err.status + ` !!!`,
					text: err.responseJSON.message,
					showConfirmButton: true,
				});
                  $('#btn_SubmitCalculate,.btn_closeCal').prop('disabled', false);
			}
		})

    }
    */

</script>

<!-- หากเปิดหน้านี้จากการกดแก้ไข จะโหลดข้อมูลเดิมมาแสดง -->
<script>
    $(document).on('tagcal-search-completed', async function() {
        $(document).off('tagcal-search-completed');
        @if( @$tags->TagToCulculate != NULL )
            // ถ้าเป็นการโหลดข้อมูลจาก Tag หลังจากโหลดข้อมูลรถเสร็จแล้ว
            // เอาดอกเบี้ย ค่าธรรมเนียม ราคากลาง ณ วันที่ดูข้อมูล มาใส่ แล้วคำนวณใหม่
            console.log( "ใส่ข้อมูลเดิม" );
            @empty(!$tags->TagToCulculate->Rate_ownership1)
                $("input[name='Rate_ownership1']").val( nf_ratePrice.format({{$tags->TagToCulculate->Rate_ownership1}}) );
            @endempty
            @if ($tags->TagToCulculate->Interest_Car != NULL)
                $("input[name='Interest_Car']").val( {{$tags->TagToCulculate->Interest_Car}} );
            @endif
            @if ($tags->TagToCulculate->totalInterest_Car != NULL)
                $("input[name='totalInterest_Car']").val( {{$tags->TagToCulculate->totalInterest_Car}} );
            @endif
            @if ($tags->TagToCulculate->InterestYear_Car != NULL)
                $("input[name='InterestYear_Car']").val( {{$tags->TagToCulculate->InterestYear_Car}} );
            @endif
            @if ($tags->TagToCulculate->Process_Car != NULL)
                $("input[name='Process_Car']").val( nf_ratePrice.format({{$tags->TagToCulculate->Process_Car}}) );
            @endif
            console.log( "ใส่ข้อมูลเดิมเสร็จแล้ว - ก่อนคำนวณ" );
            console.log( $("input[name='Interest_Car']").val() );
            UpdateCal();
            console.log( $("input[name='Interest_Car']").val() );
            console.log( "ใส่ข้อมูลเดิมเสร็จแล้ว - หลังคำนวณ" );
        @endif
    });
</script>

<!-- ปุ่มปริ้นต์ตารางค่างวด -->
<script>
    
    $('#PrintTableBtn').off('click').on('click', function() {
        // ตรวจสอบว่าองค์ประกอบเป็น DataTable หรือไม่
        if ( $.fn.dataTable.isDataTable( '#table_instl_container table' ) ) {
            // หากเป็น DataTable แล้ว, รับ instance ของ DataTable
            var table = $('#table_instl_container table').DataTable();
            // ดำเนินการกับ 'table' ตามที่ต้องการ
            table.button('.buttons-print').trigger();
        } else {
            // หากยังไม่เป็น DataTable, ดำเนินการอื่นหรือไม่ดำเนินการเลย
            // console.log('DataTable ยังไม่ถูกสร้าง');
            Swal.fire({
                title: "ยังไม่มีตารางค่างวด",
                icon: "warning",
                text: 'ลองตรวจสอบเงื่อนไขของบริษัท หรือติดต่อโปรแกรมเมอร์',
                confirmButtonText: "เข้าใจแล้ว",
            })
        }
    });

</script>