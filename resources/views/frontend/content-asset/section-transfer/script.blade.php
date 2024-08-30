
<!-- สคริปต์ เมนูค้นหา -->
<script>
    $(document).ready(function() {

        function searchText_on_change(searchText) {
            $(searchText).removeClass("is-invalid");
        }

        function searchBtn_on_clicked(searchBtn) {
            let inputEle = $(searchBtn).siblings("input");
            if (inputEle.length) {
                let serachText = $(inputEle).val();
                if ( serachText.length <= 0) {
                    inputEle.addClass("is-invalid");
                    Swal.fire({
                        title: "กรุณาตรวจสอบ",
                        icon: "warning",
                        text: "กรุณาป้อนข้อมูลที่ต้องการจะค้นหา",
                        confirmButtonText: 'เข้าใจแล้ว',
                    });
                    return;
                } else {
                    var input_tag_class = $(inputEle).data("inputclass");
                    var submit_tag_class = $(inputEle).data("submitclass");
                    $(`.${input_tag_class}`).prop('disabled', true);
                    $(`.${submit_tag_class}`).prop('disabled', true);
                    $('.btn_closeTransfer').prop('disabled', true);

                    var form_id = $(searchBtn).parentsUntil("form").parent().attr('id');
                    var _token = $(`#${form_id} input[name="_token"]`).val();

                    // ซ่อนการ์ดผลลัทธ์
                    $(`[data-cardformid='${form_id}']`).fadeOut();
                    if ( form_id == 'search-old-asset') {
                        HideAssetDetailsForm();
                    }
                    
                    $(`[data-resultfor='${form_id}'] .feedback-data-search`).fadeOut(null, function() {
                        $(`[data-resultfor='${form_id}'] .feedback-search`).fadeOut( null, function() {
                            $(`[data-resultfor='${form_id}'] .spinner-border`).fadeIn().attr('style', ''); //** แสดงตัวโหลด **

                            //------------------------------------------------------
                            $.ajax({
                                url: "{{ route('asset.SearchData') }}",
                                method: "POST",
                                data: {
                                    _token: _token,
                                    mode: 'transfer',
                                    form_id: form_id,
                                    SearchValue: serachText,
                                },
                                complete: function(data) {
                                    $(`[data-resultfor='${form_id}'] .spinner-border`).fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                                    $(`.${input_tag_class}`).prop('disabled', false);
                                    $(`.${submit_tag_class}`).prop('disabled', false);
                                    $('.btn_closeTransfer').prop('disabled', false);

                                    console.log( "AJAX complete!!");
                                },
                                success: function(result){
                                    //----------------------------------------------
                                    if (result["feedback-search"] != '') {
                                        $(`[data-resultfor='${form_id}'] .feedback-search span`).html( result["feedback-search"] );
                                        $(`[data-resultfor='${form_id}'] .feedback-search`).fadeIn();
                                    } else {
                                        $(`[data-resultfor='${form_id}'] .feedback-search span`).html('');
                                    }
                                    //----------------------------------------------
                                    if (result["feedback-data-search"] != '') {
                                        $(`[data-resultfor='${form_id}'] .feedback-data-search`).html( result["feedback-data-search"] );
                                        $(`[data-resultfor='${form_id}'] .feedback-data-search`).fadeIn();
                                    }
                                    //----------------------------------------------
                                },
                                error: function(xhr, status, error) {
                                    // Get the error message form the response
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
                            });
                            //------------------------------------------------------

                        });
                    });      
                    //$(`[data-resultfor='${form_id}'] .spinner-border`).fadeIn().attr('style', ''); //** แสดงตัวโหลด **

                    
                }
            }
            
        }

        $(".form-search-transfer").each(function(index) {
            var input_search_tag = $(this).find(".input-group input");
            $(input_search_tag).off('input change').on("input change", function () {
                searchText_on_change(this);
            });
            if ( $.isFunction(EnterToSubmit) ) {
                console.log( "EnterToSubmit Exist." ); 
                var input_tag_class = $(input_search_tag).data("inputclass");
                var submit_tag_class = $(input_search_tag).data("submitclass");
                EnterToSubmit(input_tag_class, submit_tag_class);
            } else {
                console.log( "EnterToSubmit Does't exist." ); 
            }

            $(this).find(".input-group button").off('click').on("click", function () {
                searchBtn_on_clicked(this);
            });

        });

    });
</script>


<!-- สคริปต์ กดเลือกรายการที่ค้นหา -->
<script>

    function tf_selectAssetBtn_on_clicked(buttonEle) {
        let asset_id = $(buttonEle).data('assetid');
        $("#tf_NewAssetCard input[name='asset_id']").val(asset_id);

        // อัพเดตข้อมูลลงบนการ์ดที่เลือก
        let asset_pic = $(buttonEle).parent().siblings().first().find("img").attr('src');
        let asset_titlesub = $(buttonEle).parent().siblings().eq( 1 ).find("span").eq( 1 ).html();
        let asset_title = $(buttonEle).data('title');
        let asset_list1 = $(buttonEle).data('list1');
        let asset_list2 = $(buttonEle).data('list2');
        let asset_list3 = $(buttonEle).data('list3');
        let asset_list4 = $(buttonEle).data('list4');

        let asset_type = $(buttonEle).data('assettype');

        $("#tf_NewAssetCard input[name='asset_title']").val(asset_title);
        $("#tf_NewAssetCard input[name='asset_titlesub']").val(asset_titlesub);

        $("#tf_NewAssetCard .veh_list").hide();
        $("#tf_NewAssetCard .land_list").hide();

        if (asset_type == 'land') {
            $("#tf_NewAssetCard input[name='land_id']").val(asset_list1);
            $("#tf_NewAssetCard input[name='land_parcelnum']").val(asset_list2);
            $("#tf_NewAssetCard input[name='land_sheetnum']").val(asset_list3);
            $("#tf_NewAssetCard input[name='land_tambonnum']").val(asset_list4);
            $("#tf_NewAssetCard .land_list").show();
        } else {
            $("#tf_NewAssetCard input[name='veh_oldlicense']").val(asset_list1);
            $("#tf_NewAssetCard input[name='veh_newlicense']").val(asset_list2);
            $("#tf_NewAssetCard input[name='veh_chassis']").val(asset_list3);
            $("#tf_NewAssetCard input[name='veh_engine']").val(asset_list4);
            $("#tf_NewAssetCard .veh_list").show();
        }
        $("#tf_NewAssetCard img.avatar-sm").attr("src", asset_pic);

        $("[data-resultfor='search-old-asset'] .feedback-data-search").fadeOut(null, function() {
            $("#tf_NewAssetCard").fadeIn();
        });

        LoadAssetDetailsForm(asset_type);
    }

    function tf_selectCusBtn_on_clicked(buttonEle) {
        let cus_id = $(buttonEle).data('cusid');
        $("#tf_NewCusCard input[name='cus_id']").val(cus_id);

        // อัพเดตข้อมูลลงบนการ์ดที่เลือก
        let cus_pic = $(buttonEle).parent().siblings().first().find("img").attr('src');
        let cus_name = $(buttonEle).parent().siblings().eq( 1 ).find("span").first().html();
        let cus_nameeng = $(buttonEle).data('nameeng');
        let cus_idcard = $(buttonEle).data('cusidcard');
        let cus_phone = $(buttonEle).data('cusphone');
        
        $("#tf_NewCusCard img.avatar-sm").attr("src", cus_pic);
        $("#tf_NewCusCard input[name='cus_name']").val(cus_name);
        $("#tf_NewCusCard input[name='cus_nameeng']").val(cus_nameeng);
        $("#tf_NewCusCard input[name='cus_idcard']").val(cus_idcard);
        $("#tf_NewCusCard input[name='cus_phone']").val(cus_phone);
        
        $("[data-resultfor='search-new-cus'] .feedback-data-search").fadeOut(null, function() {
            $("#tf_NewCusCard").fadeIn();
        });
        
    }

    // สคริปต์ เมื่อกดเลือกทรัพย์แล้ว จะส่ง ajax เรียกหน้า details มาแสดง

    function LoadAssetDetailsForm(asset_type) {
        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        //------------------------------------------------------
        $.ajax({
            url: "{{ route('asset.index') }}",
            method: "GET",
            data: {
                type: 'form-datails',
                asset: asset_type,
                asset_id: $("#tf_NewAssetCard input[name='asset_id']").val(),
            },
            complete: function(data) {
                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
            },
            success: function(result){
                if (result.status == true) {
                    $("#formAssetDetails_info").fadeOut(null, function() {
                        $('#formAssetDetail').html(result.html);
                        $('#formAssetDetail').show();
                    });
				} else {
					//toastr.error(data.message);
				}
            },
            error: function(xhr, status, error) {

                return
                /*
                // Get the error message form the response
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
                */
            }
        });
        //------------------------------------------------------
    }

    function HideAssetDetailsForm() {
        $('#formAssetDetail').html("");
        $('#formAssetDetail').hide();
        $("#formAssetDetails_info").show();
    }

</script>

<!-- สคริปต์กดยกเลิกการเลือกการ์ด -->
<script>

    function tf_cancelSelectBtn_on_clicked(cancelBtn) {
        let cardEle = $(cancelBtn).parentsUntil(".card").parent();
        let card_id = $(cardEle).attr('id');
        let form_id = $(cardEle).data('cardformid');

        if (form_id == 'search-old-asset') {
            $("#tf_NewAssetCard #asset_id").val('');
        }
        if (form_id == 'search-new-cus') {
            $("#tf_NewCusCard #cus_id").val('');
        }

        $(`#${card_id}`).fadeOut(null, function() {
            $(`[data-resultfor='${form_id}'] .feedback-data-search`).fadeIn();
            HideAssetDetailsForm();
        });

    }

</script>

<!-- สคริปต์ openDatepickerBtn -->
<script>
	$(document).ready(function() {
		$(".openDatepickerBtn").on('click', function() {
			$(this).siblings('input').focus();
		});
	});
</script>

<!-- สคริปต์ เมนูสรา้งทรัพย์ / เลือกประเภท -->
<script>
    $(document).ready(function() {
        $('.btn_createOwnership').click(function() {

            var asset_id = $("#tf_NewAssetCard #asset_id").val();
            var cus_id = $("#tf_NewCusCard #cus_id").val();

            var dataform = document.querySelectorAll('#formCreateDetails');
            var assetform = $("#formCreateDetails");
            var tokenform = $('#formCreateDetails input[name="_token"]');
            var validate = validateForms(dataform);

            var assetType = $('#formCreateDetails input[name="assetType_input_details"]').val();
            var page_dataCusId = $("#page_DataCusId").val();
            if (page_dataCusId == '') {
                page_dataCusId = cus_id;
            }

            var filter_asset = $("#filter_asset").val();
            
            var data = {};
            assetform.serializeArray().map( function(x) {
                data[x.name] = x.value;
            });
            
            if (asset_id == '') {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: "กรุณาเลือกทรัพย์ที่จะสร้างการครอบครอง",
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }
            if (cus_id == '') {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: "กรุณาเลือกลูกค้าที่จะมอบทรัพย์ให้",
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }

            if (validate == true) {
                var _token = tokenform.val();
                $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                $('.btn_createOwnership').prop('disabled', true);
                $('.btn_closeAsset').prop('disabled', true);
                $('<span />', {
                    class : "spinner-border spinner-border-sm",
                    role : "status"
                }).appendTo(".btn_createOwnership .addSpin");
                
                let link = "{{ route('asset.update', 'id') }}";
				let url = link.replace('id', asset_id);

                $.ajax({
                    url: url,
                    method: "PUT",
                    data: {
                        _token: _token,
                        mod: 'transfer',
                        type: '{{@$type}}',
                        AssetType: assetType,
                        dataCus_Id: cus_id,
                        page_dataCusId: page_dataCusId,
                        data: data,
                        filter_asset: filter_asset,
                    },
                    complete: function(data) {
                        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        $('.btn_createOwnership .addSpin').html('')
                        $('.btn_createOwnership').prop('disabled', false);
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
            }
        });

    });
</script>