<!-- สคริปต์อัพเดต DropDown รถยนต์ -->
@include('public-js.scriptVehRate_variable') 

<!-- ฟช. เช็คตัวแปรมีค่ารึเปล่า ก่อนอัพเดตโดยส่ง ajax -->
<script>
     $('#TypeLoans:not(.TypeLoansNotRefresh)').on('change',function(){
        $('.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar,.Type_PLT').val('');
        $('.typeAsset,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar,.Type_PLT').attr("style", "pointer-events: none;");
         getTypeloan();
     });
     function rateprice_LTV(val){
        var config_rate = $('#config_rate').val();
        var config_score = $('#config_score').val();
        var Credo_Score = $('#Credo_Score').val();

        if (Credo_Score > config_score) {
            $('#RatePrice_Car').val((((config_rate/100) * val) + parseFloat(val)));
        }else{
            $('#RatePrice_Car').val((parseFloat(val)));
        }
    }
     function getTypeloan(){
      if ($('.TypeLoans').val() != '') {
        // var typeAsset = $(".typeRateAsset").val();
        var v_RateCartypes = $('#v_RateCartypes').val();
        var value = $('.TypeLoans').val();
        
        $('#assetType_input').val(value);
        var funs = 'rate';
        var _token = $('input[name="_token"]').val();
        var code = $(".TypeLoans option:selected").text().split('-');
        var result = code[0].trim();

        $('#CodeLoans').val(result);
        var url = "{{ route('ControlCenter.SearchData') }}";
       
       
        if (value == "car" || value == "moto" ) {
            // $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
               $.ajax({
                url: url,
                method: "POST",
                data:{funs:funs,value:value,asset:value,v_RateCartypes:v_RateCartypes,_token:_token},
                success:function(data){
                    if(value){
                        $('.typeAsset').empty();
                        $('.typeAsset').append(data);  
                    }
                    
                    $('.typeAsset,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar,.Type_PLT').attr("style", "pointer-events: block;");
                    // $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                }
             })
        }
        else{
            $.ajax({
                url: url,
                method: "POST",
                data:{funs:funs,value:value,asset:value,v_RateCartypes:v_RateCartypes,_token:_token},
                success:function(data){
                    if(value){
                        $('.typeAsset').empty();
                        $('.typeAsset').append(data);  
                    }
                    
                    $('.typeAsset,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar,.Type_PLT').attr("style", "pointer-events: block;");
                    // $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                }
             })
        }
      }
    }
</script>

<!-- อัพเดตรุ่นรถ และราคากลาง -->
<script>
    //const nf_ratePrice = new Intl.NumberFormat("th-TH");
    var nf_ratePrice = new Intl.NumberFormat("th-TH");
    //------------------------------------------------------------------------------------------
    function typeAsset_RefreshDropDown(element) {
        var typeAsset_value = $(element).val();
        $('.brandAsset,.groupAsset,.modelAsset,.yearAsset,.gearCar').each(function(index) {
            $(this).find('option:not(:first)').remove().end();
            $(this).trigger('change');
        });
        console.log( "typeAsset_value: " + typeAsset_value);
        // console.log(dataMoto[typeAsset_value]);
        $('.ratePrice,.rateYear').val('');
        if ( typeAsset_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            //--------------------------------------
            //await checkVehRateExist(typeAsset_input, 'ratetype', typeAsset_value)
            //--------------------------------------
            let _brand_key
            let _brand_name
            if (typeAsset_input == 'car' ) {
                _brand_key = Object.keys( dataCar[typeAsset_value] );
                _brand_name = brandCar_array;
            } else if (typeAsset_input == 'moto' ) {
                _brand_key = Object.keys( dataMoto[typeAsset_value] );
                _brand_name = brandMoto_array;
            }
            $.each( _brand_key, function( index, value ) {
                $('.brandAsset').append('<option value="' + value + '">' + _brand_name[value] + '</option>');
            });
            //--------------------------------------
        }
    }
    $('.typeAsset').on("change", function() { //TypeLoans
        typeAsset_RefreshDropDown(this);
    });
    //------------------------------------------------------------------------------------------
    function brand_RefreshDropDown(element) {
        var brand_value = $(element).val();
        console.log(brand_value);
        $('.groupAsset,.modelAsset,.yearAsset,.gearCar').each(function(index) {
            $(this).find('option:not(:first)').remove().end();
            $(this).trigger('change');
        });
        $('.ratePrice,.rateYear').val('');
        if ( brand_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            var typeAsset_value = $(".typeAsset").val();
            //--------------------------------------
            let _group_key
            let _group_name
            if (typeAsset_input == 'car' ) {
                _group_key = Object.keys( dataCar[typeAsset_value][brand_value] );
                _group_name = groupCar_array;
            } else if (typeAsset_input == 'moto' ) {
                _group_key = Object.keys( dataMoto[typeAsset_value][brand_value] );
                _group_name = groupMoto_array;
            }
            $.each( _group_key, function( index, value ) {
                $('.groupAsset').append('<option value="' + value + '">' + _group_name[value] + '</option>');
            });
            //--------------------------------------
        }
    }
    $('.brandAsset').on("change", function(e) { //TypeLoans
        console.log( 'brandAsset on change!' );
        //console.log( e );
        brand_RefreshDropDown(this);
    });
    //------------------------------------------------------------------------------------------
    function group_RefreshDropDown(element) {
        var group_value = $(element).val();
        $('.modelAsset,.yearAsset,.gearCar').each(function(index) {
            $(this).find('option:not(:first)').remove().end();
            $(this).trigger('change');
        });
        $('.ratePrice,.rateYear').val('');
        if ( group_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            var typeAsset_value = $(".typeAsset").val();
            var brand_value = $(".brandAsset").val();
            //--------------------------------------
            let _year_key
            if (typeAsset_input == 'car' ) {
                _year_key = Object.keys( dataCar[typeAsset_value][brand_value][group_value] );
            } else if (typeAsset_input == 'moto' ) {
                _year_key = Object.keys( dataMoto[typeAsset_value][brand_value][group_value] );
            }
            $.each( _year_key, function( index, value ) {
                $('.yearAsset').append('<option value="' + value + '">' + value + '</option>');
            });
            //--------------------------------------
        }
    }
    $('.groupAsset').on("change", function() { //TypeLoans
        group_RefreshDropDown(this);
    });
    //------------------------------------------------------------------------------------------
    function year_RefreshDropDown(element) {
        var year_value = $(element).val();
        $('.modelAsset,.gearCar').each(function(index) {
            $(this).find('option:not(:first)').remove().end();
            $(this).trigger('change');
        });
        $('.ratePrice,.rateYear').val('');
        if ( year_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            var typeAsset_value = $(".typeAsset").val();
            var brand_value = $(".brandAsset").val();
            var group_value = $(".groupAsset").val();
            //--------------------------------------
            /*
            let _model_key
            let _model_name
            if (typeAsset_input == 'car' ) {
                _model_key = Object.keys( dataCar[typeAsset_value][brand_value][group_value][year_value] );
                _model_name = modelCar_array;
            } else if (typeAsset_input == 'moto' ) {
                _model_key = Object.keys( dataMoto[typeAsset_value][brand_value][group_value][year_value] );
                _model_name = modelMoto_array;
            }
            $.each( _model_key, function( index, value ) {
                $('.modelAsset').append('<option value="' + value + '">' + _model_name[value] + '</option>');
            });
            */
            if (typeAsset_input == 'car' ) {
                let _model_key = Object.keys( dataCar[typeAsset_value][brand_value][group_value][year_value] );
                $.each( _model_key, function( index, value ) {
                    var option = new Option( modelCar_array[value]['name'], value );
                    if ( modelCar_array[value]['Topcar'] == 'yes' ) {
                        $(option).addClass('bg-warning bg-soft option-topcar');
                        $(option).attr('style', 'color: #a87d35 !important');
                        //$(option).css({"color":"#df9311 !important"});
                    }
                    $('.modelAsset').append( $(option) );
                });
            } else if (typeAsset_input == 'moto' ) {
                let _model_key = Object.keys( dataMoto[typeAsset_value][brand_value][group_value][year_value] );
                $.each( _model_key, function( index, value ) {
                    $('.modelAsset').append('<option value="' + value + '">' + modelMoto_array[value] + '</option>');
                });
            }
            //--------------------------------------
        }
    }
    $('.yearAsset').on("change", function() { //TypeLoans
        year_RefreshDropDown(this);
    });
    //------------------------------------------------------------------------------------------
    function model_RefreshDropDown(element) {
        var model_value = $(element).val();
        $('.gearCar').each(function(index) {
            $(this).find('option:not(:first)').remove().end();
            $(this).trigger('change');
        });
        $('.ratePrice,.rateYear').val('');
        if ( model_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            var typeAsset_value = $(".typeAsset").val();
            var brand_value = $(".brandAsset").val();
            var group_value = $(".groupAsset").val();
            var year_value = $(".yearAsset").val();
            if (typeAsset_input == 'car' ) {
                let _gear = dataCar[typeAsset_value][brand_value][group_value][year_value][model_value][0];
                if ( _gear["Auto"] != null) {
                    $('.gearCar').append('<option value="Auto">Auto</option>');
                }
                if ( _gear["Manual"] != null) {
                    $('.gearCar').append('<option value="Manual">Manual</option>');
                }
            } else if ( typeAsset_input == 'moto' ) {
                let results = dataMoto[typeAsset_value][brand_value][group_value][year_value][model_value][0];
                
                let midPrice = nf_ratePrice.format(results["price"]);
                let rateYear = results["year_id"]
                $('.ratePrice').val(midPrice);
                $('.rateYear').val(rateYear);
                $(document).trigger('ratePrice-search-completed'); // ***** ส่งทริกเกอร์ว่าหาราคากลางเสร็จแล้ว *****

                @if(auth()->user()->zone=='10')
                    rateprice_LTV(midPrice.replace(/,/g, ''));
                @endif
            }
        }
    }
    $('.modelAsset').on("change", function() { //TypeLoans
        model_RefreshDropDown(this);
    });
    //------------------------------------------------------------------------------------------
    function gear_RefreshDropDown(element) {
        var gear_value = $(element).val();
        $('.ratePrice,.rateYear').val('');
        if ( gear_value !== "" ) {
            var typeAsset_input = $("#assetType_input").val();
            var typeAsset_value = $(".typeAsset").val();
            var brand_value = $(".brandAsset").val();
            var group_value = $(".groupAsset").val();
            var year_value = $(".yearAsset").val();
            var model_value = $(".modelAsset").val();
            if (typeAsset_input == 'car' ) {
                let results = dataCar[typeAsset_value][brand_value][group_value][year_value][model_value][0];
                let midPrice = nf_ratePrice.format(results[gear_value]);
                let rateYear = results["year_id"]
                $('.ratePrice').val(midPrice);
                $('.rateYear').val(rateYear);
                @if(auth()->user()->zone=='10')
                    rateprice_LTV(midPrice.replace(/,/g, ''));
                @endif
                $(document).trigger('ratePrice-search-completed'); // ***** ส่งทริกเกอร์ว่าหาราคากลางเสร็จแล้ว *****
            }
        }
    }
    $('.gearCar').on("change", function() { //TypeLoans
        gear_RefreshDropDown(this);
    });

    function getPLTData(type) {
                const PLTTypeCarArray = TypeVehicle;
                var matchedPLT = [];
                PLTTypeCarArray.forEach(function(pltData) {
                    var regex = new RegExp(pltData.Cond_Regex, 'i');
                    if (regex.test(type)) {
                        matchedPLT.push(pltData);
                    }
                });
                return matchedPLT;
            }
            function Vehicle_Type_PLT(PLT_Array) {
                $('.Type_PLT').find('option').remove();
                if ( PLT_Array.length > 0 ) {
                    PLT_Array.forEach(element => {
                        @if( @$assetItem->Vehicle_Type_PLT != null || @$tags->TagToCulculate->Type_PLT != null )
                            // กรณีที่มีข้อมูลอยู่แล้ว ให้ติด selected ทันที (สำหรับหน้าแก้ไข)
                            if( '{{@$assetItem->Vehicle_Type_PLT}}' == element.Code_PLT || '{{@$tags->TagToCulculate->Type_PLT}}' == element.Code_PLT   ) {
                                $('.Type_PLT').append('<option value="' + element.Code_PLT + '" selected>' + element.Name_Vehicle + '</option>');
                            } else {
                                $('.Type_PLT').append('<option value="' + element.Code_PLT + '">' + element.Name_Vehicle + '</option>')
                            }
                        @else
                            // สำหรับหน้าสร้าง
                            $('.Type_PLT').append('<option value="' + element.Code_PLT + '">' + element.Name_Vehicle + '</option>')
                        @endif
                    });
                    if ( PLT_Array.length == 1 ) {
                        // มีค่าเดียว เลือกให้เลย
                        $(".Type_PLT").val( $(".Type_PLT option:first").val() );
                    }
                } else {
                    $('.Type_PLT').append('<option value="" selected>--- ประเภทรถ 2 ---</option>');
                    $('.Type_PLT').val('');
                }
                $(".Type_PLT").trigger('change');
            }
            $(".typeAsset").change( function() {
                Vehicle_Type_PLT( getPLTData( $(".typeAsset").val() ));
            });
    //------------------------------------------------------------------------------------------
</script>

@if(@$type == 'edit')
    <!-- สคิรปต์สำหรับฟอร์ม edit จะใส่ค่าลงไปใน dropdown รถต่าง ๆ -->
    <script>
        @if(!empty(@$assetItem))
            var _vehicleType = '{{$assetItem->Vehicle_Type}}';
            @if( @$assetItem->TypeAsset_Code == 'car' )
                if (dataCar[_vehicleType] != null) {
                    $('.typeAsset').trigger('change');
                    var _brand = '{{$assetItem->Vehicle_Brand}}';
                    var _group = '{{$assetItem->Vehicle_Group}}';
                    var _year = '{{$assetItem->getYearVehValue()}}';
                    var _model = '{{$assetItem->Vehicle_Model}}';
                    var _gear = '{{$assetItem->Vehicle_Gear}}';
                    var _year_id = '{{$assetItem->Vehicle_Year}}';
                    var _midPrice = '{{$assetItem->Price_Asset}}';
                    $('.brandAsset').val(_brand);
                    $('.brandAsset').trigger('change');
                    $('.groupAsset').val(_group);
                    $('.groupAsset').trigger('change');
                    $('.yearAsset').val(_year);
                    $('.yearAsset').trigger('change');
                    $('.modelAsset').val(_model);
                    $('.modelAsset').trigger('change');
                    
                        /*
                        if ( _gearItem["Auto"] != null) {
                            if (_gear == 'Auto') {
                                $('.gearCar').append('<option value="Auto" selected>Auto</option>');
                            } else {
                                $('.gearCar').append('<option value="Auto">Auto</option>');
                            }
                        }
                        if ( _gear["Manual"] != null) {
                            if (_gear == 'Manual') {
                                $('.gearCar').append('<option value="Manual" selected>Manual</option>');
                            } else {
                                $('.gearCar').append('<option value="Manual">Manual</option>');
                            }
                        }
                        */
                        $('.gearCar').val(_gear);
                        $('.gearCar').trigger('change');
                        
                    $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                    $('.rateYear').val(_year_id);
                }
            @elseif( @$assetItem->TypeAsset_Code == 'moto' )
                if (dataMoto[_vehicleType] != null) {
                    $('.typeAsset').trigger('change');
                    var _brand = '{{$assetItem->Vehicle_Brand}}';
                    var _group = '{{$assetItem->Vehicle_Group}}';
                    var _year = '{{$assetItem->getYearVehValue()}}';
                    var _model = '{{$assetItem->Vehicle_Model}}';
                    var _year_id = '{{$assetItem->Vehicle_Year}}';
                    var _midPrice = '{{$assetItem->Price_Asset}}';
                    $('.brandAsset').val(_brand);
                    $('.brandAsset').trigger('change');
                    $('.groupAsset').val(_group);
                    $('.groupAsset').trigger('change');
                    $('.yearAsset').val(_year);
                    $('.yearAsset').trigger('change');
                    $('.modelAsset').val(_model);
                    $('.modelAsset').trigger('change');
                    $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                    $('.rateYear').val(_year_id);
                }
            @endif
        @endif
    </script>
@endif

@if( @$type == 'new' && @$assetFromTagCal != NULL )
    <!-- สคริปต์ โหลดข้อมูลทรัพย์จาก Tag คำนวณ จะใส่ค่าลงไปใน dropdown รถต่าง ๆ -->
    <script>
        var _vehicleType = '{{$assetFromTagCal->Vehicle_Type}}';
        @if( @$assetFromTagCal->TypeAsset_Code == 'car' )
            if (dataCar[_vehicleType] != null) {
                $('.typeAsset').trigger('change');
                var _brand = '{{$assetFromTagCal->Vehicle_Brand}}';
                var _group = '{{$assetFromTagCal->Vehicle_Group}}';
                var _year = '{{$assetFromTagCal->getYearVehValue()}}';
                var _model = '{{$assetFromTagCal->Vehicle_Model}}';
                var _gear = '{{$assetFromTagCal->Vehicle_Gear}}';
                var _year_id = '{{$assetFromTagCal->Vehicle_Year}}';
                var _midPrice = '{{$assetFromTagCal->Price_Asset}}';
                $('.brandAsset').val(_brand);
                $('.brandAsset').trigger('change');
                $('.groupAsset').val(_group);
                $('.groupAsset').trigger('change');
                $('.yearAsset').val(_year);
                $('.yearAsset').trigger('change');
                $('.modelAsset').val(_model);
                $('.modelAsset').trigger('change');
                $('.gearCar').val(_gear);
                $('.gearCar').trigger('change');
                
                $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                $('.rateYear').val(_year_id);
            }
        @elseif( @$assetItem->TypeAsset_Code == 'moto' )
            if (dataMoto[_vehicleType] != null) {
                $('.typeAsset').trigger('change');
                var _brand = '{{$assetFromTagCal->Vehicle_Brand}}';
                var _group = '{{$assetFromTagCal->Vehicle_Group}}';
                var _year = '{{$assetFromTagCal->getYearVehValue()}}';
                var _model = '{{$assetFromTagCal->Vehicle_Model}}';
                var _year_id = '{{$assetFromTagCal->Vehicle_Year}}';
                var _midPrice = '{{$assetFromTagCal->Price_Asset}}';
                $('.brandAsset').val(_brand);
                $('.brandAsset').trigger('change');
                $('.groupAsset').val(_group);
                $('.groupAsset').trigger('change');
                $('.yearAsset').val(_year);
                $('.yearAsset').trigger('change');
                $('.modelAsset').val(_model);
                $('.modelAsset').trigger('change');
                $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                $('.rateYear').val(_year_id);
            }
        @endif
        $(document).trigger('asset-tagcal-search-completed'); // ***** ส่งทริกเกอร์ว่าโหลดข้อมูลทรัพย์จาก Tag เสร็จแล้ว*****
    </script>
@endif

@if(@$tags != NULL)
    <!-- สคิรปต์สำหรับฟอร์ม edit จะใส่ค่าลงไปใน dropdown รถต่าง ๆ -->
    <script>
        $(function() {
        @if(!empty(@$tags->TagToCulculate))
            @if( @$tags->TagToCulculate->TypeLoans == 'car')
                var _vehicleType = '{{$tags->TagToCulculate->RateCartypes}}';
                // var _vehicleType = '{{$tags->TagToCulculate->Vehicle_Type}}';
                if (dataCar[_vehicleType] != null) {
                    $('.typeAsset').trigger('change');
                    var _brand = '{{$tags->TagToCulculate->RateBrands}}';
                    var _group = '{{$tags->TagToCulculate->RateGroups}}';
                    var _year = '{{$tags->TagToCulculate->getYearVehValue()}}';
                    var _model = '{{$tags->TagToCulculate->RateModals}}';
                    var _gear = '{{$tags->TagToCulculate->RateGears}}';
                    var _year_id = '{{$tags->TagToCulculate->RateYears}}';
                    var _midPrice = '{{$tags->TagToCulculate->RatePrices}}';
                    var _gearItem = dataCar[_vehicleType][_brand][_group][_year][_model][0];

                    $('.brandAsset').val(_brand);
                    $('.brandAsset').trigger('change');
                    $('.groupAsset').val(_group);
                    $('.groupAsset').trigger('change');
                    $('.yearAsset').val(_year);
                    $('.yearAsset').trigger('change');
                    $('.modelAsset').val(_model);
                    $('.modelAsset').trigger('change');

            
                    $('.gearCar').val(_gear);
                    $('.gearCar').trigger('change');

                    $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                    $('.rateYear').val(_year_id);
                }
            @elseif( @$tags->TagToCulculate->TypeLoans == 'moto')
                var _vehicleType = '{{$tags->TagToCulculate->RateCartypes}}';
                if (dataMoto[_vehicleType] != null) {
                    $('.typeAsset').trigger('change');
                    var _brand = '{{$tags->TagToCulculate->RateBrands}}';
                    var _group = '{{$tags->TagToCulculate->RateGroups}}';
                    var _year = '{{$tags->TagToCulculate->getYearVehValue()}}';
                    var _model = '{{$tags->TagToCulculate->RateModals}}';
                    var _gear = '{{$tags->TagToCulculate->RateGears}}';
                    var _year_id = '{{$tags->TagToCulculate->RateYears}}';
                    var _midPrice = '{{$tags->TagToCulculate->RatePrices}}';
                    var _gearItem = dataMoto[_vehicleType][_brand][_group][_year][_model][0];

                    $('.brandAsset').val(_brand);
                    $('.brandAsset').trigger('change');
                    $('.groupAsset').val(_group);
                    $('.groupAsset').trigger('change');
                    $('.yearAsset').val(_year);
                    $('.yearAsset').trigger('change');
                    $('.modelAsset').val(_model);
                    $('.modelAsset').trigger('change');

            
                    // $('.gearCar').val(_gear);
                    // $('.gearCar').trigger('change');
                    $('.rateYear').val(_year_id);
                    $('.rateYear').trigger('change');

                    $('.ratePrice').val( nf_ratePrice.format(_midPrice));
                }
            @endif

            $(document).trigger('tagcal-search-completed'); // ***** ส่งทริกเกอร์ว่าโหลดข้อมูลจาก Tag เสร็จแล้ว*****

        @endif
    
    });
    </script>
@endif

<!-- สคริปต์ สร้าง Dropdown ประเภทรถ (ใช้จากหน้าคำนวณ) -->
<script>
    @empty($asset)
        var _temp_old_assetTypeInput = null;
    @else
        var _temp_old_assetTypeInput = '{{$asset}}';
    @endempty
    function RefreshDropDown_typeAsset() {
        //---------------------------------------------------------------------------------------
        var typeAsset_input = $("#assetType_input").val();
        //---------------------------------------------------------------------------------------
        if ( _temp_old_assetTypeInput == null || _temp_old_assetTypeInput != typeAsset_input) {
            _temp_old_assetTypeInput = typeAsset_input;
            // ล้างฟอร์มข้อมูลรถออก
            $('.typeAsset,.brandAsset,.groupAsset,.modelAsset,.yearAsset,.gearCar').each(function(index) {
                $(this).find('option:not(:first)').remove().end();
                $(this).trigger('change');
            });
            //---------------------------------------------------------------
            let _typeAsset_key;
            let _typeAsset_name = rateType_array;
            if (typeAsset_input == 'car' ) {
                _typeAsset_key = Object.keys( dataCar );
            } else if (typeAsset_input == 'moto' ) {
                _typeAsset_key = Object.keys( dataMoto );
            }
            $.each( _typeAsset_key, function( index, value ) {
                $('.typeAsset').append('<option value="' + value + '">' + _typeAsset_name[value] + '</option>');
            });
        }
        //---------------------------------------------------------------------------------------
    }
</script>