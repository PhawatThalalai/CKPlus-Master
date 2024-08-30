<script>
    function rateprice_LTV(val){
        var config_rate = $('#config_rate').val();
        var config_score = $('#config_score').val();
        var Credo_Score = $('#Credo_Score').val();

        if (Credo_Score > config_score) {
        $('#RatePrice_Car').val((((config_rate/100)*val) + parseFloat(val)));
        }else{
        $('#RatePrice_Car').val((parseFloat(val)));
        }
    }

    $('.TypeLoans').change(function() { //TypeLoans
      if ($(this).val() != '') {
        var value = $(this).val();
        var type = 10;
        var _token = $('input[name="_token"]').val();
        var code = $(".TypeLoans option:selected").text().split('-');
        var result = code[0].trim();

        $('.typeAsset,.brandAsset,.groupAsset,.modelAsset,.yearAsset,.gearCar').empty();
        $('.typeAsset').append($('<option/>').attr("selected","").val('').text("--- ประเภทรถ ---"));
        $('.brandAsset').append($('<option/>').attr("selected","").val('').text("--- ยี่ห้อรถ ---"));
        $('.groupAsset').append($('<option/>').attr("selected","").val('').text("--- กลุ่มรถ ---"));
        $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
        $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
        $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
        $('.ratePrice').val('');

        $('#CodeLoans').val(result);
        if(value == "car"){
            var url = "{{ route('CarRate.show',0) }}";
            $('.gearShow').show();
        }else if(value == "moto"){
            var url = "{{ route('MotoRate.show',0) }}";
            $('.gearShow').hide();
        }

        if (value == "car" || value == "moto") {
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,_token:_token},
                success:function(data){
                    $('.typeAsset').append(data);
                    $('.ratePrice').prop('readonly', true);
                }
            })
        }else{
            $(".ratePrice").removeAttr("readonly");
        }
      }
    });
    $('.typeAsset').change(function() {  //typecar -> brand
      if ($(this).val() != '') {
        var typeAsset = $(".typeRateAsset").val();
        var value = $(this).val();
        var type = 4;
        var _token = $('input[name="_token"]').val();

        $('.brandAsset,.groupAsset,.modelAsset,.yearAsset,.gearCar').empty();
        $('.brandAsset').append($('<option/>').attr("selected","").val('').text("--- ยี่ห้อรถ ---"));
        $('.groupAsset').append($('<option/>').attr("selected","").val('').text("--- กลุ่มรถ ---"));
        $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
        $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
        $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
        $('.ratePrice').val('');

        if(typeAsset == "car"){
            var url = "{{ route('CarRate.show',0) }}";
        }else if(typeAsset == "moto"){
            var url = "{{ route('MotoRate.show',0) }}";
        }

        $.ajax({
            url: url,
            method: "GET",
            data:{type:type,value:value,_token:_token},
            success:function(data){
                $('.brandAsset').append(data);
            }
        })
      }
    });
    $('.brandAsset').change(function() { //brand -> Group
        if ($(this).val() != '') {
            var typeAsset = $(".typeRateAsset").val();
            var value = $(this).val();
            var type_car = $('.typeAsset').val();
            var type = 5;
            var _token = $('input[name="_token"]').val();

            $('.groupAsset,.modelAsset,.yearAsset,.gearCar').empty();
            $('.groupAsset').append($('<option/>').attr("selected","").val('').text("--- กลุ่มรถ ---"));
            $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
            $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
            $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
            $('.ratePrice').val('');

            if(typeAsset == "car"){
                var url = "{{ route('CarRate.show',0) }}";
            }else if(typeAsset == "moto"){
                var url = "{{ route('MotoRate.show',0) }}";
            }
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,type_car:type_car,_token:_token},
                success:function(data){
                    $('.groupAsset').append(data);
                }
            });
        }
    });
    $('.groupAsset').change(function() { //Group -> year
        if ($(this).val() != '') {
            var typeAsset = $(".typeRateAsset").val();
            var value = $(this).val();
            var type_car = $('.typeAsset').val();
            var Brand_id = $('.brandAsset').val();
            var type = 7;
            var _token = $('input[name="_token"]').val();

            $('.yearAsset,.modelAsset,.gearCar').empty();
            $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
            $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
            $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
            $('.ratePrice').val('');

            if(typeAsset == "car"){
                var url = "{{ route('CarRate.show',0) }}";
            }else if(typeAsset == "moto"){
                var url = "{{ route('MotoRate.show',0) }}";
            }
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,type_car:type_car,Brand_id:Brand_id,_token:_token},
                success:function(data){
                    $('.yearAsset').append(data);
                }
            });
        }
    });
    $('.yearAsset').change(function() { //model -> year
        if ($(this).val() != '') {
            var typeAsset = $(".typeRateAsset").val();
            var value = $(this).val();
            var type_car = $('.typeAsset').val();
            var Brand_id = $('.brandAsset').val();
            var Group_id = $('.groupAsset').val();
            // var Model_id = $('.yearAsset').val();
            var type = 6;
            var _token = $('input[name="_token"]').val();

            $('.modelAsset,.gearCar').empty();
            $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
            $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
            $('.ratePrice').val('');

            if(typeAsset == "car"){
                var url = "{{ route('CarRate.show',0) }}";
            }else if(typeAsset == "moto"){
                var url = "{{ route('MotoRate.show',0) }}";
            }
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,type_car:type_car,Brand_id:Brand_id,Group_id:Group_id,_token:_token},
                success:function(data){
                    $('.modelAsset').append(data);
                }
            });
        }
    });
    $('.modelAsset').change(function() { //year -> gear
        if ($(this).val() != '') {
            var typeAsset = $(".typeRateAsset").val();
            var value = $(this).val();
            var type_car = $('.typeAsset').val();
            var Brand_id = $('.brandAsset').val();
            var Group_id = $('.groupAsset').val();
            var Val_year = $('.yearAsset').val();
            var zone = {{Auth::user()->zone}};
            var _token = $('input[name="_token"]').val();
            var type = 8;

            $('.gearCar').empty();
            $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
            $('.ratePrice').val('');

            if(typeAsset == "car"){
                var url = "{{ route('CarRate.show',0) }}";
            }else if(typeAsset == "moto"){
                var url = "{{ route('MotoRate.show',0) }}";

            }
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,type_car:type_car,Brand_id:Brand_id,Val_year:Val_year,Group_id:Group_id,_token:_token},
                success:function(data){
                    if(typeAsset == "car"){
                        $('.gearCar').append(data);
                    }else if(typeAsset == "moto"){
                        $('.ratePrice').val((data[0]));
                        if(zone==10){
                            rateprice_LTV(data[0]); 
                        }

                        $('input[name="RateYears"]').val(data[1]);
                        $('input[name="Vehicle_Year"]').val(data[1]);
                        $('#clickShowrate').trigger('click'); // Rate HY NK
                        $(document).trigger('ratePrice-search-completed'); // ***** ส่งทริกเกอร์ว่าหาราคากลางเสร็จแล้ว *****

                    }
                }
            });
        }

    });
    $('.gearCar').change(function () { //gear -> rate
        if ($(this).val() != '') {
            var value = $(this).val();
            var typeAsset = $(".typeRateAsset").val();
            var type_car = $('.typeAsset').val();
            var Brand_id = $('.brandAsset').val();
            var Group_id = $('.groupAsset').val();
            var Model_id = $('.modelAsset').val();
            var Val_year = $('.yearAsset').val();
            var zone = {{auth::user()->zone}};
            var _token = $('input[name="_token"]').val();
            var type = 9;

            $('.ratePrice').val('');
            var url = "{{ route('CarRate.show',0) }}";
            $.ajax({
                url: url,
                method: "GET",
                dataType: 'JSON',
                data:{type:type,value:value,type_car:type_car,Brand_id:Brand_id,Val_year:Val_year,Model_id:Model_id,Group_id:Group_id,_token:_token},
                success:function(data){
                    $('.ratePrice').val((data[0]));
                    if(zone==10){
                        rateprice_LTV(data[0]); 
                    }
                       
                    $('input[name="RateYears"]').val(data[1]);
                    $('input[name="Vehicle_Year"]').val(data[1]);
                    $('#clickShowrate').trigger('click'); // Rate HY NK
                    $(document).trigger('ratePrice-search-completed'); // ***** ส่งทริกเกอร์ว่าหาราคากลางเสร็จแล้ว *****

                }
            });
        }
    });

</script>

<script>
    $(document).ready(function(){
        var Cal_id = $("#Cal_id").val();
        var Asst_id = $("#Asstid").val();
        if(typeof Cal_id != 'undefined'|| typeof Asst_id!='undefined'){
            var value = "";
            var typeloan = $('.TypeLoans').val();

            //เพิ่มให้รับค่า TypeLoansNotRefresh แทน
            if ($('.TypeLoansNotRefresh').length) typeloan = $('.TypeLoansNotRefresh').val();

            var typeRateAsset = $('.typeRateAsset').val();
            if ( typeof typeloan != 'undefined' || typeof typeRateAsset!='undefined') {
                if(typeof typeloan != 'undefined' ){
                     value = typeloan;
                }else if(typeof typeRateAsset!='undefined'){
                     value = typeRateAsset;
                }
                var type = 11;
                var _token = $('input[name="_token"]').val();

                if(value == "car" ){
                    var url = "{{ route('CarRate.show',0) }}";
                    $('.gearShow').show();
                }else if(value == "moto" ){
                    var url = "{{ route('MotoRate.show',0) }}";
                    $('.gearShow').hide();
                }

                if (value == "car" || value == "moto") {
                    $("#overlay_loading").attr('style', ''); // ***** แสดงตัวโหลด *****
                    $.ajax({
                        url: url,
                        method: "GET",
                        dataType: 'JSON',

                        data:{type:type,value:value,Cal_id:Cal_id,Asst_id:Asst_id,_token:_token},
                        success:function(data){
                            $('.typeAsset').append(data[0]);
                            $('.brandAsset').append(data[1]);
                            $('.groupAsset').append(data[2]);
                            $('.modelAsset').append(data[3]);
                            $('.yearAsset').append(data[4]);
                            $('.ratePrice').prop('readonly', true);

                            $("#overlay_loading").attr('style', 'display:none !important'); // ***** ซ่อนตัวโหลด *****
                            $(document).trigger('calid-search-completed'); // ***** ส่งทริกเกอร์ว่าโหลดเสร็จแล้ว *****
                        }
                    })
                }else{
                    $(".ratePrice").removeAttr("readonly");
                }
            }
        }
    });
</script>

<script>
    $('.TypeLoansNotRefresh').change(function() { //TypeLoans
      if ($(this).val() != '') {

        //Add
        if (!($(this).data("oldvalue") == null || $(this).data("oldvalue") == '')) {
            //console.log("มีค่า oldvalue แล้ว :" + $(this).data("oldvalue"));
            if ($(this).data("oldvalue") == $(this).val()) {
                return;
            }
        }
        $(this).data("oldvalue", $(this).val());
        //End - Add

        var value = $(this).val();
        var type = 10;
        var _token = $('input[name="_token"]').val();
        var code = $(".TypeLoansNotRefresh option:selected").text().split('-');
        var result = code[0].trim();

        $('.typeAsset,.brandAsset,.groupAsset,.modelAsset,.yearAsset,.gearCar').empty();
        $('.typeAsset').append($('<option/>').attr("selected","").val('').text("--- ประเภทรถ ---"));
        $('.brandAsset').append($('<option/>').attr("selected","").val('').text("--- ยี่ห้อรถ ---"));
        $('.groupAsset').append($('<option/>').attr("selected","").val('').text("--- กลุ่มรถ ---"));
        $('.modelAsset').append($('<option/>').attr("selected","").val('').text("--- รุ่นรถ ---"));
        $('.yearAsset').append($('<option/>').attr("selected","").val('').text("--- ปีรถ ---"));
        $('.gearCar').append($('<option/>').attr("selected","").val('').text("--- เกียร์รถ ---"));
        $('.ratePrice').val('');

        $('#CodeLoans').val(result);
        if(value == "car"){
            var url = "{{ route('CarRate.show',0) }}";
            $('.gearShow').show();
        }else if(value == "moto"){
            var url = "{{ route('MotoRate.show',0) }}";
            $('.gearShow').hide();
        }

        if (value == "car" || value == "moto") {
            $.ajax({
                url: url,
                method: "GET",
                data:{type:type,value:value,_token:_token},
                success:function(data){
                    $('.typeAsset').append(data);
                    $('.ratePrice').prop('readonly', true);
                }
            })
        }else{
            $(".ratePrice").removeAttr("readonly");
        }
      }
    });

</script>
