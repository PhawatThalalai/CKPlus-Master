<style>
    .reset {
        all: revert;
    }
    .input-fieldset{
        padding-bottom: 2px;
    }
</style>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}
    
	.signup-form input[type=text],
	select {
		border: none;
		border-bottom: 2px solid darkgrey;
		background-color: inherit;
		display: block;
		width: 100%;
		margin: none;
	}

	.signup-form input[type=text]:focus,
	select:focus {
		outline: none;
	}

	.form-group .line {
		height: 1px;
		width: 0px;
		position: absolute;
		background-color: darkgrey;
		display: inline-block;
		transition: .3s width ease-in-out;
		position: relative;
		top: -14px;
		margin-bottom: 0;
		padding-bottom: 0;
	}

	.signup-form input[type=text]:focus+.line,
	select:focus+.line {
		width: 100%;
		background-color: #02add7;
	}
</style>

<div class="card mb-2">
    <div class="card-body">
        <form name="formExcute" id="formExcute" action="#" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-sm-8">
                    <!-- <h5 class="text-primary p-2 font-size-14 fw-semibold"><i class="bx bx-user"></i> จัดกลุ่มงานติดตาม (Group Details)</h5> -->
                    <fieldset class="reset form-group border p-3">
                        <legend class="reset w-auto px-2 text-left text-bold text-primary font-size-14 fw-semibold">จัดกลุ่มงานติดตาม</legend>
                        <div class="row g-2 mb-1">
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <select id="TYPECONT" name="TYPECONT" class="form-select TYPECONT" required>
                                        <option value="">- เลือกประเภท -</option>
                                        <option value="HP">1. สินเชื่อเช่าซื้อ (HP)</option>
                                        <option value="PSL">2. สินเชื่อเงินกู้ (PSL)</option>
                                    </select>
                                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> ประเภทสัญญา</strong></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6" id="GroupCall">
                                <div class="form-floating">
                                    <select id="GROUP" name="GROUP" class="form-select GROUP" required>
                                        <option value="">- เลือกกลุ่มงาน -</option>
                                        <option value="กลุ่มงานโทร">1. กลุ่มงานโทร</option>
                                        <option value="กลุ่มงานตาม">2. กลุ่มงานตาม</option>
                                    </select>
                                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> กลุ่มงาน</strong></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3" id="GroupFollow" style="display:none;">
                                <div class="form-floating">
                                    <input type="number" id="AMOUNTG" name="AMOUNTG" class="form-control" placeholder="จำนวนกลุ่ม" required>
                                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> จำนวนกลุ่ม</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-4">
                            <div class="col-12 col-sm-6">
                                <div class="form-floating">
                                    <input type="date" id="DATE" name="DATE" class="form-control" value="{{date('Y-m-d')}}" placeholder="ข้อมุล ณ วันที่">
                                    <label for="floatingnameInput"><strong><i class="bx bx-calendar text-danger"></i> ข้อมุล ณ วันที่</strong></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-floating">
                                    <input type="text" id="F_PERIOD" name="F_PERIOD" class="form-control" placeholder="ค้างงวดที่" required>
                                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> ค้างงวดที่</strong></label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-floating">
                                    <input type="text" id="T_PERIOD" name="T_PERIOD" class="form-control" placeholder="ถึงงวดที่" required>
                                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> ถึงงวดที่</strong></label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-4">
                    <fieldset class="reset form-group border p-3">
                        <legend class="reset w-auto px-2 text-left text-bold text-primary font-size-14 fw-semibold">การรายงาน</legend>
                        <div class="row textSize-13">
                            <div class="col-lg-12">
                                <div class="form-check form-checkbox-outline form-check-success mb-2">
                                    <input class="form-check-input" type="checkbox" id="customCheckcolor">
                                    <label class="form-check-label" for="customCheckcolor">
                                        เฉพาะรถยึด
                                    </label>
                                </div>
                                <div class="form-check form-checkbox-outline form-check-success mb-2">
                                    <input class="form-check-input" type="checkbox" id="customCheckcolor2" checked="">
                                    <label class="form-check-label" for="customCheckcolor2">
                                        ไม่รวมรถยึด
                                    </label>
                                </div>
                                <div class="form-check form-checkbox-outline form-check-success mb-2">
                                    <input class="form-check-input" type="checkbox" id="customCheckcolor3">
                                    <label class="form-check-label" for="customCheckcolor3">
                                        ทั้งหมด
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-1">
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="button" id="ExcuteBtn1" class="btn btn-primary waves-effect d-none">
                                        <!-- <i class="bx bx-search-alt bx-spin font-size-14 align-middle"></i> สอบถาม -->
                                        <i class="bx bx-hourglass bx-spin font-size-14 align-middle"></i> ประมวล
                                    </button>
                                    <button type="button" id="ExcuteBtn2" class="btn btn-dark waves-effect d-none">
                                        <i class="bx bx-hourglass bx-spin font-size-14 align-middle"></i> ประมวล
                                    </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
	</div>
</div>

<script type="text/javascript">
  $(function() {
    $("#GROUP").click( function() {
        let GetVal = $(this).val();
        if(GetVal == 'กลุ่มงานโทร'){
            // $('#F_PERIOD').val('1.00');
            // $('#T_PERIOD').val('1.99');
            $('#GroupCall').removeClass('col-sm-3',true);
            $('#GroupCall').addClass('col-sm-6');
            $('#GroupFollow').hide();
            $("#ExcuteBtn1").removeClass('d-none');
            $("#ExcuteBtn2").addClass('d-none');
        }
        else if(GetVal == 'กลุ่มงานตาม'){
            // $('#F_PERIOD').val('2.00');
            // $('#T_PERIOD').val('2.99');
            $('#GroupCall').removeClass('col-sm-6',true);
            $('#GroupCall').addClass('col-sm-3');
            $('#GroupFollow').show();
            $("#ExcuteBtn1").addClass('d-none');
            $("#ExcuteBtn2").removeClass('d-none');
        }
    });
  });
</script>

<script>
  $("#ExcuteBtn1").click(function(){
    var data = {};$("#formExcute").serializeArray().map(function(x){data[x.name] = x.value;});
    
    if ($("#formExcute").valid() == true) {
        $('#Modal-Excute').modal('show');
        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              type: 4,
              data:data,
            },

            success: function(result) {
             $('#Modal-Excute').modal('hide');
            
             $("#Lordicon").hide();
              swal.fire({
                icon : 'success',
                title : 'แบ่งกลุ่มสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
              $("#GroupDetails").show();
              $("#GroupDetails").html(result);
            }
        });
    }
    else{
      swal.fire({
        icon : 'warning',
        title : 'ข้อมูลไม่ครบ !',
        text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
        timer: 2000,
        showConfirmButton: false,
      })
    }      
  });
  $("#ExcuteBtn2").click(function(){
    var data = {};$("#formExcute").serializeArray().map(function(x){data[x.name] = x.value;});
    
    if ($("#formExcute").valid() == true) {
        $('#Modal-Excute').modal('show');
        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              type: 5,
              data:data,
            },

            success: function(result) {
             $('#Modal-Excute').modal('hide');
            
             $("#Lordicon").hide();
              swal.fire({
                icon : 'success',
                title : 'แบ่งกลุ่มสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
              $("#GroupDetails").show();
              $("#GroupDetails").html(result);
            }
        });
    }
    else{
      swal.fire({
        icon : 'warning',
        title : 'ข้อมูลไม่ครบ !',
        text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
        timer: 2000,
        showConfirmButton: false,
      })
    }      
  });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formExcute').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>