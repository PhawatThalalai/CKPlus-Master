
<!-- สคริปต์ เมนูสรา้งทรัพย์ / เลือกประเภท -->
<script>
    $(document).ready(function() {
        $('.btn_createAsset').click(function() {
            var assetType = $("#assetType_input").val();
            var dataform = null;
            var assetform = null;
            var tokenform = null;
            if ( assetType == "land" ) {
                dataform = document.querySelectorAll('#formCreateLand');
                assetform = $("#formCreateLand");
                tokenform = $('#formCreateLand input[name="_token"]');
            } else {
                dataform = document.querySelectorAll('#formCreateVehicle');
                assetform = $("#formCreateVehicle");
                tokenform = $('#formCreateVehicle input[name="_token"]');
            }
            var validate = validateForms(dataform);
            var data = {};
            assetform.serializeArray().map( function(x) {
                data[x.name] = x.value;
            });

            var dataCus_Id = $("#newAsset_DataCusId").val();
            var filter_asset = $("#filter_asset").val();

            if ( assetType != "land" && ( $("#Vehicle_Chassis").length > 0 && $("#Vehicle_Chassis").data('fail') == true)  ) {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: "กรุณาใส่ข้อมูลเลขถังที่ถูกต้อง",
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }

            if (validate == true) {
                var _token = tokenform.val();
                $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                $('.btn_createAsset').prop('disabled', true);
                $('.btn_closeAsset').prop('disabled', true);
                $('<span />', {
                    class : "spinner-border spinner-border-sm",
                    role : "status"
                }).appendTo(".btn_createAsset .addSpin");
                
                $.ajax({
                    url: "{{ route('asset.store') }}",
                    method: "POST",
                    data: {
                        _token: _token,
                        AssetType: assetType,
                        dataCus_Id: dataCus_Id,
                        data: data,
                        filter_asset: filter_asset,
                    },
                    complete: function(data) {
                        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        $('.addSpin').html('')
                        $('.btn_createAsset').prop('disabled', false);
                        $('.btn_closeAsset').prop('disabled', false);
                        //$("#modal_xl").data('bs.modal')._config.backdrop = true;
                        //$('#modal_xl').data('modal').options.backdrop = true;
                    },
                    success: function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: result.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modal_xl').modal('hide');
                        $('#content_asset_container').html(result.html);
                    },
                    error: function(xhr, status, error) {
                        // Get the error message from the response
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                        var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                        errorFile = errorFile.replace(/^.*[\\\/]/, '');
                        var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                        var errorHtml = "<p>" + errorMessage +"</p>";
                        errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
                        // Display the error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: error,
                            html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                            showCancelButton: true,
                            confirmButtonText: 'ดูเพิ่มเติม',
                            cancelButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                                Swal.fire({
                                    icon: 'error',
                                    title: 'รายละเอียด',
                                    //text: errorMessage,
                                    html: errorHtml,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                })
            } else {
                invalidFormsAlert(dataform);
            }
        });

        $('.btn_editAsset').click(function() {
            var assetType = $("#assetType_input").val();
            var dataform = null;
            var assetform = null;
            var tokenform = null;
            if ( assetType == "land" ) {
                dataform = document.querySelectorAll('#formCreateLand');
                assetform = $("#formCreateLand");
                tokenform = $('#formCreateLand input[name="_token"]');
            } else {
                dataform = document.querySelectorAll('#formCreateVehicle');
                assetform = $("#formCreateVehicle");
                tokenform = $('#formCreateVehicle input[name="_token"]');
            }
            var validate = validateForms(dataform);

            var data = {};
            assetform.serializeArray().map( function(x) {
                data[x.name] = x.value;
            });
            
            var dataCus_Id = $("#newAsset_DataCusId").val();
            var dataOwn_Id = $("#asset_DataOwnId").val();
            var filter_asset = $("#filter_asset").val();

            if ( assetType != "land" && ( $("#Vehicle_Chassis").length > 0 && $("#Vehicle_Chassis").data('fail') == true ) ) {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: "กรุณาใส่ข้อมูลเลขถังที่ถูกต้อง",
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }
            if (validate == true) {
                let id = $("#asset_id").val();
                var _token = tokenform.val();

                let link = "{{ route('asset.update', 'id') }}";
				let url = link.replace('id', id);

                //$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

                $('.btn_editAsset').prop('disabled', true);
                $('.btn_closeAsset').prop('disabled', true);
                $('<span />', {
                    class : "spinner-border spinner-border-sm",
                    role : "status"
                }).appendTo(".btn_editAsset .addSpin");

                $.ajax({
                    url: url,
                    method: "PUT",
                    data: {
                        _token: _token,
                        mod: 'asset',
                        AssetType: assetType,
                        dataCus_Id: dataCus_Id,
                        dataOwn_Id: dataOwn_Id,
                        data: data,
                        filter_asset: filter_asset,
                    },
                    complete: function(data) {
                        //$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        $('.addSpin').html('')
                        $('.btn_editAsset').prop('disabled', false);
                        $('.btn_closeAsset').prop('disabled', false);
                    },
                    success: function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: result.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modal_xl_2').modal('hide');
                        $('#content_asset_container').html(result.html);
                    },
                    error: function(xhr, status, error) {
                        // Get the error message from the response
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                        var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                        errorFile = errorFile.replace(/^.*[\\\/]/, '');
                        var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                        var errorHtml = "<p>" + errorMessage +"</p>";
                        errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
                        // Display the error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: error,
                            html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                            showCancelButton: true,
                            confirmButtonText: 'ดูเพิ่มเติม',
                            cancelButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                                Swal.fire({
                                    icon: 'error',
                                    title: 'รายละเอียด',
                                    //text: errorMessage,
                                    html: errorHtml,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                })
            } else {
                invalidFormsAlert(dataform);
            }
        });

        //------------------------------------------------------------------------------------
        /*
        function RemoveVehicleValue() {
            $('#Vehicle_Brand,#Vehicle_Group,#Vehicle_Model,#Vehicle_Year,#Vehicle_Gear')
            .find('option')
            .filter(function(){return $(this).val() != ''})
            .remove()
            .end()
            .val('');
            $('#Mid_Price').val('');
        }
        */
    });
</script>

@if( @$dataForm != null)

    <!-- สคริปต์ ใส่ค่าคงที่ลงใน Form -->
    @if(@$type == 'new')
        <script>
            // ฟังก์ชัน สำหรับกำหนดค่าคงที่ลงใน dropdown
            // สำหรับฟอร์ม Create แสดง option ทั้งหมดที่เป็นค่าคงที่
            function SetDropDownCreateForm() {
                @foreach( @$dataForm as $nameAtb => $value)
                    @foreach( @$value as $index => $choice)
                        @if( is_array($choice) )  // เป็นอาร์เรย์ แบ่งค่า value กับค่าที่แสดง
                            $('.{{@$nameAtb}}').append('<option value="{{ $choice[0] }}">{{ $choice[1] }}</option>')
                        @else // ไม่ใช่อาร์เรย์ เอาค่ามาแสดงทันที
                            $('.{{@$nameAtb}}').append('<option value="{{ $choice }}">{{ $choice }}</option>')
                        @endif
                    @endforeach
                @endforeach
            }
            $(document).ready(function() {
                SetDropDownCreateForm();
                @if( @$assetFromTagCal != NULL )
                    SetValueFromTagCal();
                @endif
            });
        </script>
    @endif

    @if(@$type == 'edit')
        <script>
            // สำหรับฟอร์ม Edit แสดง option ทั้งหมด และ selected ค่าที่ถูกเลือก
            function SetDropDownEditForm( assetDetails ) {
                @foreach( @$dataForm as $nameAtb => $value)
                    @foreach( @$value as $index => $choice)
                        @if(is_array($choice) )
                            if (assetDetails['{{@$nameAtb}}'] == '{{$choice[0]}}') {
                                $('.{{@$nameAtb}}').append('<option value="{{ $choice[0] }}" selected >{{ $choice[1] }}</option>')
                            } else {
                                $('.{{@$nameAtb}}').append('<option value="{{ $choice[0] }}" >{{ $choice[1] }}</option>')
                            }
                        @else
                            if (assetDetails['{{@$nameAtb}}'] == '{{$choice}}') {
                                $('.{{@$nameAtb}}').append('<option value="{{ $choice }}" selected >{{ $choice }}</option>')
                            } else {
                                $('.{{@$nameAtb}}').append('<option value="{{ $choice }}" >{{ $choice }}</option>')
                            }
                        @endif
                    @endforeach
                @endforeach
            }
            $(document).ready(function() {
                SetDropDownEditForm(@json($assetItem));
            });
        </script>
    @endif

@endif

@if($type == 'new' || $type == 'edit')
    <!-- สคริปต์ เช็คเลขถังซ้ำ -->
    <script>
        function CheckChassisExits(textInputId, assetId_self = null) {
            var _element = document.getElementById(textInputId);
            var dataCus_Id = $("#newAsset_DataCusId").val();
            //---------------------------------------------
            var _dataAsset_Id = '';
            if (assetId_self != null) {
                // ถ้าเป็นการแก้ไข ให้จำเลข ID ทรัพย์ตัวเองด้วย
                _dataAsset_Id = assetId_self;
            }
            //---------------------------------------------
            //var old_oninput_function = _element.oninput;
            //_element.oninput = function () { //เช็คเลขถังซ้ำ
            $("#"+textInputId).on("input change", function() {

                /* แปลงตัวอักษรโค้ด */
                //var input = event.target;
                // Replace non-alphanumeric characters and convert to uppercase
                _element.value = _element.value.replace(/[^a-zA-Z0-9.]/g, '').toUpperCase();

                var SearchValue = _element.value;
                var _token = $('input[name="_token"]').val();
                if (SearchValue != '' && SearchValue.length >= 5) {
                    $("#Progress_Chassis").show();
                    $("#Progress_Chassis").addClass('d-flex');
                    $("#Fail_Chassis").removeClass('d-flex');
                    $("#Pass_Chassis").removeClass('d-flex');
                    $("#Fail_Chassis").hide();
                    $("#Pass_Chassis").hide();
                    $("#"+textInputId).data('fail',true);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:"{{ route('asset.SearchData') }}",
                        method:"post",
                        data:{
                            SearchValue:SearchValue,
                            _token:_token,
                            mode:'chassis',
                            cusId: dataCus_Id,
                            assetId: _dataAsset_Id
                        },
                        success:function(result){ //เสร็จแล้วทำอะไรต่อ

                            if (SearchValue != _element.value) { // เช็คว่าเลขที่ส่งไป กับ อินพุตปัจจุบัน ยังเป็นเลขเดียวกันหรือไม่
                                return;
                            }

                            $("#Progress_Chassis").removeClass('d-flex');
                            $("#Progress_Chassis").hide();

                            //console.log(result);
                            const href_tranfer = result['href_tranfer'];
                            const permissionTranfer = result['permissionTranfer'];
                            if ( result['duplicate'] == true) {
                                if (result['isblacklist'] == true) {
                                    Swal.fire({
                                        title: "Blacklist",
                                        icon: "error",
                                        text: "เลขถังนี้ถูกใช้ในระบบแล้ว นอกจากนี้ยังถูกตั้งเป็น Blacklist ด้วย",
                                        confirmButtonText: 'เข้าใจแล้ว'
                                    })
                                } else if ( result['canTranfer'] == true ) {
                                    Swal.fire({
                                        title: "รถที่ใช้เลขถังนี้มีในระบบแล้ว !",
                                        icon: "error",
                                        text: "กรุณาตรวจสอบเลขถังอีกครั้ง\nหรือโอนย้ายทรัพย์ที่ใช้เลขถังนี้จากลูกค้า ["+result['cusData']['Name_Cus']+"] เข้ามา",
                                        showCancelButton: true,
                                        confirmButtonColor: '#6F736F',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'ไปหน้าโอนย้าย',
                                        cancelButtonText: 'เข้าใจแล้ว',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            if (permissionTranfer == true ) {
                                                //window.location.href = href_tranfer;
                                                swal.fire({
                                                    title: "ขออภัย!",
                                                    icon: "error",
                                                    html: "ระบบย้ายทรัพย์อยู่ในระหว่างการพัฒนา<br>หากต้องการย้ายทรัพย์ในตอนนี้ กรุณาติดต่อโปรแกรมเมอร์",
                                                    confirmButtonText: 'เข้าใจแล้ว',
                                                });
                                            } else {
                                                swal.fire({
                                                    title: "ขออภัย!",
                                                    icon: "error",
                                                    text: "คุณต้องการสิทธิ์เพิ่มเติมเพื่อดำเนินการต่อ",
                                                    confirmButtonText: 'เข้าใจแล้ว',
                                                });
                                            }    
                                        }
                                    })
                                } else {
                                    swal.fire({
                                        title: "รถที่ใช้เลขถังนี้มีในระบบแล้ว !",
                                        icon: "error",
                                        text: "กรุณาตรวจสอบเลขถัง หรือรายการทรัพย์อีกครั้ง\nลูกค้าท่านนี้ได้ครอบครองรถที่ใช้เลขถังนี้ไปแล้ว",
                                        confirmButtonText: 'เข้าใจแล้ว',
                                    })
                                }
                                $("#Fail_Chassis").show();
                                $("#Fail_Chassis").addClass('d-flex');
                                $("#Pass_Chassis").removeClass('d-flex');
                                $("#Pass_Chassis").hide();
                                $("#"+textInputId).data('fail',true)
                            } else {
                                if (SearchValue == _element.value) { // เช็คว่าเลขที่ส่งไป กับ อินพุตปัจจุบัน ยังเป็นเลขเดียวกันหรือไม่
                                    $("#Fail_Chassis").removeClass('d-flex');
                                    $("#Fail_Chassis").hide();
                                    $("#Pass_Chassis").show();
                                    $("#Pass_Chassis").addClass('d-flex');
                                    $("#"+textInputId).data('fail',false)
                                } else {
                                    $("#Fail_Chassis").show();
                                    $("#Fail_Chassis").addClass('d-flex');
                                    $("#Pass_Chassis").removeClass('d-flex');
                                    $("#Pass_Chassis").hide();
                                    $("#"+textInputId).data('fail',true)
                                }
                            }
                            //if ( old_oninput_function != null) old_oninput_function.call();
                        }
                    })
                } else {
                    $("#Fail_Chassis").show();
                    $("#Pass_Chassis").removeClass('d-flex');
                    $("#Pass_Chassis").hide();
                    $("#"+textInputId).data('fail',true)
                }
                //if ( old_oninput_function != null)  old_oninput_function.call();
            //};
            });
            // เซ็ตค่าเริ่มต้น
            //$("#Fail_Chassis").hide();
            //$("#Pass_Chassis").hide();
            $("#Progress_Chassis").removeClass('d-flex');
            $("#Progress_Chassis").hide();
            $("#Fail_Chassis").removeClass('d-flex');
            $("#Pass_Chassis").removeClass('d-flex');
            $("#Fail_Chassis").hide();
            $("#Pass_Chassis").hide();
            @if($type == 'new')
                $("#"+textInputId).data('fail',true)
            @endif
        }
        $(document).ready(function() {
            @if( $type == 'new')
                CheckChassisExits("Vehicle_Chassis");
            @elseif( $type == 'edit' )
                CheckChassisExits("Vehicle_Chassis", '{{@$assetItem->id}}');
            @endif

            $("#Vehicle_HasNewChassis").change(function() {
                if(this.checked) {
                    $("#Vehicle_NewChassis").prop('required', true);
                    $("#Vehicle_NewChassis").attr('readonly', false);
                    $("span[data-inputid='Vehicle_NewChassis']").addClass("text-danger");
                } else {
                    $("#Vehicle_NewChassis").val('');
                    $("#Vehicle_NewChassis").prop('required', false);
                    $("#Vehicle_NewChassis").attr('readonly', true);
                    $("span[data-inputid='Vehicle_NewChassis']").removeClass("text-danger");
                }
            });

        });
    </script>

    <!-- สคริปต์ เช็คโฉนดซ้ำ -->
    <script>
        function CheckLandIdExits(textInputId, assetId_self = null) {
            var _element = document.getElementById(textInputId);
            var dataCus_Id = $("#newAsset_DataCusId").val();
            //---------------------------------------------
            var _dataAsset_Id = '';
            if (assetId_self != null) {
                // ถ้าเป็นการแก้ไข ให้จำเลข ID ทรัพย์ตัวเองด้วย
                _dataAsset_Id = assetId_self;
            }
            //---------------------------------------------
            //var old_oninput_function = _element.oninput;
            //_element.oninput = function () { //เช็คเลขถังซ้ำ
            
            function ajax_checklandid_exits() {
                var land_id = $("#Land_Id").val();
                var province_id = $("#Land_Province").val();
                var district_id = $("#Land_District").val();

                if (land_id == "") {
                    $("#Land_Id").addClass('is-invalid');
                }
                if (province_id == "") {
                    $("#Land_Province").addClass('is-invalid');
                }
                if (district_id == "") {
                    $("#Land_District").addClass('is-invalid');
                }

                if (land_id != "" && province_id != "" && district_id != "") {
                    $("#Progress_LandId").show();
                    $("#Progress_LandId").addClass('d-flex');
                    $("#Fail_LandId").removeClass('d-flex');
                    $("#Pass_LandId").removeClass('d-flex');
                    $("#Fail_LandId").hide();
                    $("#Pass_LandId").hide();
                    $("#Land_Id").data('fail',true);

                    var _token = $('input[name="_token"]').val();
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:"{{ route('asset.SearchData') }}",
                        method:"post",
                        data:{
                            search_landid: land_id,
                            search_district_id: province_id,
                            search_province_id: district_id,
                            _token:_token,
                            mode:'landid',
                            cusId: dataCus_Id,
                            assetId: _dataAsset_Id
                        },
                        success:function(result){ //เสร็จแล้วทำอะไรต่อ

                            if (land_id != $("#Land_Id").val() || province_id != $("#Land_Province").val() || district_id != $("#Land_District").val()) { // เช็คว่าเลขที่ส่งไป กับ อินพุตปัจจุบัน ยังเป็นเลขเดียวกันหรือไม่
                                return;
                            }

                            $("#Progress_LandId").removeClass('d-flex');
                            $("#Progress_LandId").hide();

                            //console.log(result);
                            const href_tranfer = result['href_tranfer'];
                            const permissionTranfer = result['permissionTranfer'];
                            if ( result['duplicate'] == true) {
                                if ( result['canTranfer'] == true ) {
                                    Swal.fire({
                                        title: "โฉนดที่ดินนี้มีในระบบแล้ว !",
                                        icon: "error",
                                        text: "กรุณาตรวจสอบเลขที่โฉนด จังหวัด และอำเภอ อีกครั้ง\nหรือโอนย้ายทรัพย์ที่ใช้เลขถังนี้จากลูกค้า ["+result['cusData']['Name_Cus']+"] เข้ามา",
                                        showCancelButton: true,
                                        confirmButtonColor: '#6F736F',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'ไปหน้าโอนย้าย',
                                        cancelButtonText: 'เข้าใจแล้ว',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            if (permissionTranfer == true ) {
                                                //window.location.href = href_tranfer;
                                                swal.fire({
                                                    title: "ขออภัย!",
                                                    icon: "error",
                                                    html: "ระบบย้ายทรัพย์อยู่ในระหว่างการพัฒนา<br>หากต้องการย้ายทรัพย์ในตอนนี้ กรุณาติดต่อโปรแกรมเมอร์",
                                                    confirmButtonText: 'เข้าใจแล้ว',
                                                });
                                            } else {
                                                swal.fire({
                                                    title: "ขออภัย!",
                                                    icon: "error",
                                                    text: "คุณต้องการสิทธิ์เพิ่มเติมเพื่อดำเนินการต่อ",
                                                    confirmButtonText: 'เข้าใจแล้ว',
                                                });
                                            }    
                                        }
                                    })
                                } else {
                                    swal.fire({
                                        title: "โฉนดที่ดินนี้มีในระบบแล้ว !",
                                        icon: "error",
                                        text: "กรุณาตรวจสอบเลขที่โฉนด จังหวัด และอำเภอ อีกครั้ง\nลูกค้าท่านนี้ได้ครอบครองโฉนดนี้ไปแล้ว",
                                        confirmButtonText: 'เข้าใจแล้ว',
                                    })
                                }
                                $("#Fail_LandId").show();
                                $("#Fail_LandId").addClass('d-flex');
                                $("#Pass_LandId").removeClass('d-flex');
                                $("#Pass_LandId").hide();
                                $("#Land_Id").data('fail',true)

                                $("#Land_Id").removeClass('is-valid');
                                $("#Land_Province").removeClass('is-valid');
                                $("#Land_District").removeClass('is-valid');
                                $("#Land_Id").addClass('is-invalid');
                                $("#Land_Province").addClass('is-invalid');
                                $("#Land_District").addClass('is-invalid');
                                
                            } else {
                                if (land_id == $("#Land_Id").val() && province_id == $("#Land_Province").val() && district_id == $("#Land_District").val()) { // เช็คว่าเลขที่ส่งไป กับ อินพุตปัจจุบัน ยังเป็นเลขเดียวกันหรือไม่
                                    $("#Fail_LandId").removeClass('d-flex');
                                    $("#Fail_LandId").hide();
                                    $("#Pass_LandId").show();
                                    $("#Pass_LandId").addClass('d-flex');
                                    $("#Land_Id").data('fail',false);

                                    $("#Land_Id").removeClass('is-invalid');
                                    $("#Land_Province").removeClass('is-invalid');
                                    $("#Land_District").removeClass('is-invalid');
                                    $("#Land_Id").addClass('is-valid');
                                    $("#Land_Province").addClass('is-valid');
                                    $("#Land_District").addClass('is-valid');

                                } else {
                                    /*
                                    $("#Fail_LandId").show();
                                    $("#Fail_LandId").addClass('d-flex');
                                    $("#Pass_LandId").removeClass('d-flex');
                                    $("#Pass_LandId").hide();
                                    $("#Land_Id").data('fail',true)
                                    */
                                    $("#Land_Id").data('fail',true);

                                    $("#Land_Id").removeClass('is-valid');
                                    $("#Land_Province").removeClass('is-valid');
                                    $("#Land_District").removeClass('is-valid');
                                    $("#Land_Id").addClass('is-invalid');
                                    $("#Land_Province").addClass('is-invalid');
                                    $("#Land_District").addClass('is-invalid');
                                }
                            }
                            //if ( old_oninput_function != null) old_oninput_function.call();
                        }
                    })

                } else {
                    $("#Progress_LandId").removeClass('d-flex');
                    $("#Progress_LandId").hide();
                    $("#Fail_LandId").removeClass('d-flex');
                    $("#Pass_LandId").removeClass('d-flex');
                    $("#Fail_LandId").hide();
                    $("#Pass_LandId").hide();
                    @if($type == 'new')
                        $("#Land_Id").data('fail',true)
                    @endif
                }

            }
        
            $("#Land_Id").on("input change", function() {
                ajax_checklandid_exits();
            });
            $("#Land_Province").on("change", function() {
                ajax_checklandid_exits();
            });
            $("#Land_District").on("change", function() {
                ajax_checklandid_exits();
            });

            // เซ็ตค่าเริ่มต้น
            //$("#Fail_Chassis").hide();
            //$("#Pass_Chassis").hide();
            $("#Progress_LandId").removeClass('d-flex');
            $("#Progress_LandId").hide();
            $("#Fail_LandId").removeClass('d-flex');
            $("#Pass_LandId").removeClass('d-flex');
            $("#Fail_LandId").hide();
            $("#Pass_LandId").hide();
            @if($type == 'new')
                $("#Land_Id").data('fail',true)
            @endif
        }
        $(document).ready(function() {
            @if( $type == 'new')
                CheckLandIdExits("Land_Id");
            @elseif( $type == 'edit' )
                CheckLandIdExits("Land_Id", '{{@$assetItem->id}}');
            @endif
        });
    </script>
    
@endif



@if(@$asset == 'car' || @$asset == 'moto')
<!-- สคริปต์ สำหรับเมนูวันที่ ประกัน/พ.ร.บ./ทะเบียน -->
<script>
    function _7daysAdvance(element) {
        var input_daterange = $(element).parents(".input-daterange.input-group").find("input[type='text']");
        if (input_daterange.length >= 2) {
            $(input_daterange[0]).datepicker("update", moment().format("DD/MM/YYYY") );
            $(input_daterange[1]).datepicker("update", moment().add(7, 'days').format("DD/MM/YYYY") );
        }
    }
    function _1YearDateEXP(element) {
        var input_daterange = $(element).parents(".input-daterange.input-group").find("input[type='text']");
        if (input_daterange.length >= 2) {
            var start_date = $(input_daterange[0]).datepicker("getDate")
            if ( start_date == null ) {
                swal.fire({
                    title: "ไม่พบวันที่เริ่มต้น!",
                    icon: "warning",
                    html: "กรุณาใส่วันที่เริ่มต้นก่อน :'(<br>แล้วจึงค่อยใช้คำสั่งกำหนดวันหมดอายุ 1 ปี",
                });
            } else {
                var end_date = moment(start_date).add(1, 'years').format("DD/MM/YYYY");
                $(input_daterange[1]).datepicker("update", end_date);
            }
        }
    }
    $( "._7daysInsExpBtn" ).each(function(index) {
        $(this).on("click", function(){
            _7daysAdvance(this);
        });
    });
    $( "._1yearInsExpBtn" ).each(function(index) {
        $(this).on("click", function(){
            _1YearDateEXP(this);
        });
    });
</script>

<!-- สคริปต์ เช็ควันหมดอายุประกัน -->
<script>

    function RefreshEXP_FeedBack(element_endDT, endDT = null, is_insurance = null) {
        if (is_insurance != null && is_insurance == true) {
            if ( $("#InsuranceState").val() == 'No' ) {
                return;
            }
        }
        let dateexp_fb = element_endDT.parent().siblings(".dateexp-feedback");
        let end_date;
        if (endDT == null) {
            end_date = element_endDT.datepicker("getDate");
            if (end_date == null) return;
            end_date = moment(end_date);
        } else {
            end_date = moment(endDT, "DD-MM-YYYY");
        }
        if ( moment().isAfter( end_date ) ) {
            dateexp_fb.show();
        } else {
            dateexp_fb.hide();
        }
    }

    // Find the date range picker
    $("#InsuranceDT_datepicker,#InsuranceActDT_datepicker,#InsuranceRegisterDT_datepicker").each(function(index) {
        var input_daterange = $(this).find("input[type='text']");
        if (input_daterange.length >= 2) {
            var dateexp_fb = $(this).find(".dateexp-feedback");
            if (dateexp_fb.length > 0) {
                dateexp_fb.hide();
                $(input_daterange[1]).on("change", function() {
                    RefreshEXP_FeedBack( $(this) );
                });
            }
        }
    });
</script>

<!-- สคริปต์ ประเภทรถ ธปท. (ประเภทรถ 2) -->
<script>
    @if( @$PLTTypeCarArray != null)
        // $(()=>{
        //     function getMatchingPLTData(typeVehicle) {
        //         const PLTTypeCarArray = @json($PLTTypeCarArray);
        //         var matchedPLT = [];
        //         PLTTypeCarArray.forEach(function(pltData) {
        //             var regex = new RegExp(pltData.Cond_Regex, 'i');
        //             if (regex.test(typeVehicle)) {
        //                 matchedPLT.push(pltData);
        //             }
        //         });
        //         return matchedPLT;
        //     }

        //     function RefreshDropDown_Vehicle_Type_PLT(PLT_Array) {
        //         $('#Vehicle_Type_PLT').find('option').remove();
        //         if ( PLT_Array.length > 0 ) {
        //             PLT_Array.forEach(element => {
        //                 @if( @$assetItem->Vehicle_Type_PLT != null )
        //                     // กรณีที่มีข้อมูลอยู่แล้ว ให้ติด selected ทันที (สำหรับหน้าแก้ไข)
        //                     if( '{{@$assetItem->Vehicle_Type_PLT}}' == element.Code_PLT ) {
        //                         $('#Vehicle_Type_PLT').append('<option value="' + element.Code_PLT + '" selected>' + element.Name_Vehicle + '</option>');
        //                     } else {
        //                         $('#Vehicle_Type_PLT').append('<option value="' + element.Code_PLT + '">' + element.Name_Vehicle + '</option>')
        //                     }
        //                 @else
        //                     // สำหรับหน้าสร้าง
        //                     $('#Vehicle_Type_PLT').append('<option value="' + element.Code_PLT + '">' + element.Name_Vehicle + '</option>')
        //                 @endif
        //             });
        //             if ( PLT_Array.length == 1 ) {
        //                 // มีค่าเดียว เลือกให้เลย
        //                 $("#Vehicle_Type_PLT").val( $("#Vehicle_Type_PLT option:first").val() );
        //             }
        //         } else {
        //             $('#Vehicle_Type_PLT').append('<option value="" selected>--- ประเภทรถ 2 ---</option>');
        //             $('#Vehicle_Type_PLT').val('');
        //         }
        //         $("#Vehicle_Type_PLT").trigger('change');
        //     }
        
        //     // typeAsset
        //     $(".typeAsset").change( function() {
        //         RefreshDropDown_Vehicle_Type_PLT( getMatchingPLTData( $(".typeAsset").val() ));
        //     });
        
        //     @if( @$type == 'edit')
        //         RefreshDropDown_Vehicle_Type_PLT( getMatchingPLTData( $(".typeAsset").val() ));
        //     @endif

        //     /*
        //     // ทำงานเมื่อโหลดข้อมูลไอดีทรัพย์สำเร็จแล้ว
        //     $(document).on('calid-search-completed', function() {
        //         RefreshDropDown_Vehicle_Type_PLT( getMatchingPLTData( $(".typeAsset").val() ));
        //         @if( @$assetItem->Vehicle_Type_PLT != null )
        
        //         @endif
        //     });
        //     */
        // });
    @endif

</script>

<!-- สคริปต์เช็คสถานะประกัน/ชั้นประกัน/อัตเดตวันที่ประกันอัติโนมัติ -->
<script>
    function RefreshInsuranceInput() {
        if ( $("#InsuranceState").val() == 'No' || $("#InsuranceState").val() == '' ) { // ไม่มีประกัน
            $("#InsuranceClass").val('');
            $('#InsuranceClass').prop('required', false);
            $("span[data-inputid='InsuranceClass']").removeClass("text-danger");
            $("#InsuranceClass").attr('readonly', true);
            $('#InsuranceClass').attr("style", "pointer-events: none; background-color: #e9ecef");//.addClass("bg-secondary");
            
            $("#InsuranceCompany_Id").val('');
            $("#InsuranceCompany_Id").attr('readonly', true);
            $('#InsuranceCompany_Id').attr("style", "pointer-events: none; background-color: #e9ecef");

            $('#InsuranceClass,#InsuranceCompany_Id').trigger('change');

            $("#PolicyNumber").val('');
            $("#PolicyNumber").prop('readonly', true);
            //--------------------------------
            $("#InsuranceDT_start").prop('readonly', true);
            $("#InsuranceDT_end").prop('readonly', true);
            //$("#InsuranceDT_start").focus().blur(); // แก้บัค - datepicker ต้องโฟกัสก่อนใช้สคริปต์ update
            $("#InsuranceDT_start").focus();
            //--------------------------------
            //if ( $("#create_from_AssetType").val() == "car" || ( $("#editAssetDetails").length && $("#AssetType").val() == 'รถยนต์' ) || ( $('#transferAsset').length ) ) {
            if ( $("#assetType_input").val() == "car" ) {
                if ( $("#InsuranceState").val() == 'No' ) {
                    // ตั้งวันที่ 7 วันให้ประกัน
                    $("#InsuranceDT_start").datepicker("update", moment().format("DD/MM/YYYY") );
                    $("#InsuranceDT_end").datepicker("update", moment().add(7, 'days').format("DD/MM/YYYY") );
                }
            } else if ( $("#assetType_input").val() == "moto" ) {
                $("#InsuranceDT_start").datepicker("update", '');
                $("#InsuranceDT_end").datepicker("update", '');
            }
            $("#InsuranceDT_start").attr("style", "pointer-events: none;");
            $("#InsuranceDT_end").attr("style", "pointer-events: none;");
            $(".dropdown-InsuranceDT").addClass('disabled');
            $("#InsuranceDT_start").blur();
        } else {
            $('#InsuranceClass').attr("style", "pointer-events: block; style","background-color: #ffffff");//.removeClass("bg-secondary");
            $('#InsuranceClass').prop('required', true);
            $("#InsuranceClass").attr('readonly', false);
            $("span[data-inputid='InsuranceClass']").addClass("text-danger");
            $('#InsuranceCompany_Id').attr("style", "pointer-events: block; style","background-color: #ffffff");//.removeClass("bg-secondary");
            $("#InsuranceCompany_Id").attr('readonly', false);
            $("#PolicyNumber").prop('readonly', false);
            $("#InsuranceDT_start").prop('readonly', false);
            $("#InsuranceDT_end").prop('readonly', false);
            $("#InsuranceDT_start").attr("style", "pointer-events: block;");
            $("#InsuranceDT_end").attr("style", "pointer-events: block;");
            $(".dropdown-InsuranceDT").removeClass('disabled');
        }
    }
    
    $(document).ready(function() {
        $("#InsuranceState").on("change", function() {
            RefreshInsuranceInput();
        });
        RefreshInsuranceInput();
    });
    
</script>

@endif

<!-- สคริปต์ กำหนดค่าวันครอบครอง - ระยะเวลาครอบครอง -->
<script>
    function SetOccupiedTimeValue(diff_months) {
        $(".OccupiedDT").each(function(index) {
            if (diff_months > -1 ) {
                // 'น้อยกว่า 1 เดือน'
                select_index = 1;
            } else if (diff_months > -2) {
                // '1 เดือน - 2 เดือน'
                select_index = 2;
            } else if (diff_months >= -3) {
                // '2 เดือน - 3 เดือน'
                select_index = 3;
            } else {
                // '3 เดือนขึ้นไป'
                select_index = 4;
            }
            $(".OccupiedTime").each(function(j) {
                $(this).find('option').eq(select_index).prop('selected', true);
                $(this).trigger('change');
            });
        });
    }

    $(".OccupiedDT").each(function(index) {
        $(this).on("change", function() {
            let pickedDate = $(this).datepicker("getDate")
            if ( pickedDate != null ) {
                let moment_now = moment();
                moment_now.set('hour', 0);
                moment_now.set('minute', 0);
                moment_now.set('second', 0);
                moment_now.set('millisecond', 0);
                let diff_months = moment(pickedDate).diff( moment_now, 'months', true);
                SetOccupiedTimeValue(diff_months);
            }
        });
    });
</script>

@if(@$asset == 'land')
<!-- สคริปต์เช็คสถานะสิ่งปลูกสร้าง -->
<script>
    function RefreshBuildingInput() {
        if ( $("#Land_BuildingType").find("option:selected").data('nobuilding') == 'Y' || $("#Land_BuildingType").val() == '' ) { // ไม่มีประกัน

            $("#Land_BuildingKind").val('');
            $('#Land_BuildingKind').prop('required', false);
            $("#Land_BuildingKind").attr('readonly', true);
            $('#Land_BuildingKind').attr("style", "pointer-events: none; background-color: #e9ecef");
            $("span[data-inputid='Land_BuildingKind']").removeClass("text-danger");
            
            $("#Land_BuildingStorey").val('');
            $('#Land_BuildingStorey').prop('required', false);
            $("#Land_BuildingStorey").attr('readonly', true);
            $('#Land_BuildingStorey').attr("style", "pointer-events: none; background-color: #e9ecef");
            $("span[data-inputid='Land_BuildingStorey']").removeClass("text-danger");

            $("#Land_BuildingSize").val('');
            $('#Land_BuildingSize').prop('required', false);
            $("#Land_BuildingSize").attr('readonly', true);
            $("span[data-inputid='Land_BuildingSize']").removeClass("text-danger");

            $('#Land_BuildingKind,#Land_BuildingStorey').trigger('change');
        } else {
            $('#Land_BuildingKind').attr("style", "pointer-events: block; style","background-color: #ffffff");
            $('#Land_BuildingKind').prop('required', true);
            $("#Land_BuildingKind").attr('readonly', false);
            $("span[data-inputid='Land_BuildingKind']").addClass("text-danger");
            $('#Land_BuildingStorey').attr("style", "pointer-events: block; style","background-color: #ffffff");
            $('#Land_BuildingStorey').prop('required', true);
            $("#Land_BuildingStorey").attr('readonly', false);
            $("span[data-inputid='Land_BuildingStorey']").addClass("text-danger");
            $("#Land_BuildingSize").prop('required', true);
            $("#Land_BuildingSize").attr('readonly', false);
            $("span[data-inputid='Land_BuildingSize']").addClass("text-danger");
        }
    }
    
    $(document).ready(function() {
        $("#Land_BuildingType").on("change", function() {
            RefreshBuildingInput();
        });
        RefreshBuildingInput();
    });
    
</script>
@endif

<!-- สคริปต์ validateForms -->
<script>
    function validateForms(dataform) {
        var isvalid = true; // เริ่มต้นด้วยสมมติฐานว่าทุกฟอร์มถูกต้อง
        Array.prototype.slice.call(dataform).forEach(function(form) {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                // ถ้าเจอฟอร์มที่ไม่ถูกต้อง ตั้งค่า isvalid เป็น false
                isvalid = false;
            }
        });
        // ส่งคืนสถานะความถูกต้องโดยรวมของฟอร์ม
        return isvalid;
    }

    // ต้องมีการเรียก jQuery และ SweetAlert2 ให้พร้อมใช้งานก่อนที่จะใช้งานสคริปต์นี้
    function invalidFormsAlert(dataform) {
        var invalidInputsDetails = []; // ใช้เก็บรายละเอียดของ input ที่ไม่ถูกต้อง
        // วนซ้ำผ่านทุก input ใน dataform
        Array.prototype.slice.call(dataform[0].elements).forEach(function(input) {
            // ตรวจสอบความถูกต้องของ input
            if (!input.checkValidity()) {
                // ตรวจสอบว่า input มี attribute 'name' หรือ 'id' และเก็บรายละเอียดไว้
                var span_name = null;
                if ( $(input).siblings("span").length > 0 ) {
                    span_name = $($(input).siblings("span")[0]).html();
                }
                var inputNameOrId = span_name || input.dataset.namealert || input.name || input.id;
                invalidInputsDetails.push(inputNameOrId);
            }
        });
        // ถ้ามีฟอร์มไม่ถูกต้อง แสดงแจ้งเตือนด้วย SweetAlert2
        if (invalidInputsDetails.length > 0) {
            let contrainerHtml = "<div class='input-invalid-alert text-danger fw-bold overflow-auto font-size-14 bg-danger bg-opacity-10 rounded-5 py-2' style='max-height:10rem; scrollbar-width: thin;'>" + invalidInputsDetails.join('<br>') + "</div>";
            Swal.fire({
                title: "กรุณาใส่ข้อมูลต่อไปนี้ให้ถูกต้อง",
                icon: "warning",
                html: contrainerHtml, //invalidInputsDetails.join('<br>'), // รวมชื่อหรือ ID ของฟอร์มไม่ถูกต้องเป็นรายการ
                confirmButtonText: 'เข้าใจแล้ว'
            });
        }

    }
</script>

@if( @$type == 'edit')
    <!-- สคริปต์สำหรับเรียกใช้ในตอนที่เปิดหน้าแก้ไขครั้งแรก -->
    <script>
        $(document).ready(function() {
            $(".input-bx select").not('.typeAsset,#Vehicle_Type_PLT,.brandAsset,.groupAsset,.yearAsset,.modelAsset,.gearCar')
                .not('.houseZone,.houseProvince,.houseDistrict,.houseTambon').each( function(index) {
                $(this).trigger('change');
            });
            // เช็ควันหมดอายุประกัน ในจังหวะที่กำลัง เปิดหน้าแก้ไขครั้งแรก
            // ตัวแปร $ins_endDate $insAct_endDate $insReg_endDate มาจากหน้า view
            // โดยจะถูกสร้างเมื่อมีข้อมูล และนำไปใส่รอใน input
            @if( !empty($ins_endDate) )
                RefreshEXP_FeedBack( $("#InsuranceDT_end"), '{{$ins_endDate}}', true);
            @endif
            @if( !empty($insAct_endDate) )
                RefreshEXP_FeedBack( $("#InsuranceActDT_end"), '{{$insAct_endDate}}');
            @endif
            @if( !empty($insReg_endDate) )
                RefreshEXP_FeedBack( $("#InsuranceRegisterDT_end"), '{{$insReg_endDate}}');
            @endif
        });
    </script>
@endif

@if( @$type == 'new' && @$assetFromTagCal != NULL )
    <!-- สคริปต์ โหลดข้อมูลทรัพย์จาก Tag คำนวณ -->
    <script>
        $(document).on('asset-tagcal-search-completed', function() {
            $(document).off('asset-tagcal-search-completed');
            console.log("asset-tagcal-search-completed");
            // ใส่ข้อมูลอื่น ๆ ของทรัพย์ ที่ได้จากหน้าคำนวณ เช่น ประเภทรถ 2 เป็นต้น
            @if(@$assetFromTagCal->Vehicle_Type_PLT != null)
                $("#Vehicle_Type_PLT").val('{{$assetFromTagCal->Vehicle_Type_PLT}}');
            @endif
            //-------------------------------------------------
        });

        function SetValueFromTagCal() {
            $('#OccupiedDT_Veh').trigger('change');  // ให้อัพเดตวันครอบครอง แล้วจะอัพเดตระยะเวลาครอบครอง (เดือน) ต่อไป
        }
        
    </script>
@endif

@if(@$asset == 'car' || @$asset == 'moto')
    <!-- สคริปต์ สำหรับป้ายทะเบียนรถ -->
    <script>

        function RefreshLicensePlate() {
            var _text_license = '';
            var _number_license = '';
            var _province_license = '';
            if ( $("#Vehicle_NewLicense_Text").val() != "" || $("#Vehicle_NewLicense_Number").val() != "" || $("#Vehicle_NewLicense_Province").val() != '' ) {
                _text_license = $("#Vehicle_NewLicense_Text").val();
                _number_license = $("#Vehicle_NewLicense_Number").val();
                _province_license = $("#Vehicle_NewLicense_Province").val();
            } else if ( $("#Vehicle_OldLicense_Text").val() != "" || $("#Vehicle_OldLicense_Number").val() != "" || $("#Vehicle_OldLicense_Province").val() != '' ) {
                _text_license = $("#Vehicle_OldLicense_Text").val();
                _number_license = $("#Vehicle_OldLicense_Number").val();
                _province_license = $("#Vehicle_OldLicense_Province").val();
            }
            //-----------------------------------------------------------------------
            $('#license_text').html(_text_license);
            $('#license_number').html(_number_license);
            $('#license_province').html(_province_license);
        }

        $(document).ready(function() {
            $( '.province-license-select' ).select2( {
                theme: "bootstrap-5",
                language: "th",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: true,
                @if( @$type == 'new' )
                    dropdownParent: $('#modal_xl .modal-content'),
                @endif
                @if( @$type == 'edit' )
                    dropdownParent: $('#modal_xl_2 .modal-content'),
                @endif
                //data: dataArray_user,
            } );
            $(".license-input").on("input change", function() {
                RefreshLicensePlate();
            });
            RefreshLicensePlate();
        });

        
    </script>
@endif

<!-- สคริปต์ openDatepickerBtn -->
<script>
	$(document).ready(function() {
		$(".openDatepickerBtn").on('click', function() {
			$(this).siblings('input').focus();
		});
	});
</script>

@includeWhen($asset == 'car' || $asset == 'moto', 'public-js.scriptVehRate')

@includeWhen($asset == 'land', 'public-js.scriptAddress')