<div class="modal-content">
	<div class="modal-header">
		<h5 class="text-primary fw-semibold modal-title"> <i class="bx bx-receipt"></i> จัดการเอกสารการขออนุมัติ ( Manage documents )</h5>
		@if(@$is_flag == true)
			<button type="button" class="btn-close bg-danger" data-bs-toggle="modal" data-bs-target="#modal_xl_2" data-bs-dismiss="modal" aria-label="Close"></button>
		@else
			<button type="button" class="btn-close btntest" data-bs-dismiss="modal" aria-label="Close"></button>
		@endif

	</div>
	<div class="modal-body">
		<form action="" id="formDocument">
			{{-- hodden input --}}
			<input type="hidden" name="func" value="addDocument">
			<input type="hidden" name="PactCon_id" id="id" value="">
			<input type="hidden" name="StatusApprove" id="StatusApprove" value="{{ @$data->StatusApprove }}">
			<textarea name="textarr" id="textarr" cols="30" rows="10" hidden></textarea>

			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 text-center m-auto mb-2">
					<img src="{{ URL::asset('\assets\images\undraw\docu.svg') }}" alt="" style="width: 70%;">
					@hasrole(roleDocumentloans(@$data->PactChecktoCon->CodeLoan_Con))
						@if (@$data->PactChecktoCon->DateDocApp_Con != null)
							<span class="">
								<div class="row">
									<div class="col-4 text-end">
										<label class="fw-semibold" for="">สถานะเอกสาร</label>
									</div>
									<div class="col m-auto">
										<div class="border border-bottom"></div>
									</div>
								</div>
								<div class="row px-4 g-2">
									<div class="col-6 text-center d-grid">
										<button type="button" class="btn btn btn-sm rounded-pill statDoc Pass shadow-sm {{(@$data->statusDoc == 'Pass')? 'disabled btn-success' : 'btn-light'}}" id="btnPass" value="Pass">
                                            <i class="bx bx-check"></i> ผ่าน
                                        </button>
									</div>

									<div class="col-6 text-center d-grid">
										<button type="button" class="btn btn btn-sm rounded-pill statDoc notPass shadow-sm {{(@$data->statusDoc == 'notPass' or empty(@$data->statusDoc))?? 'btn-light'}} {{ (@$data->statusDoc == 'Pass') ? 'disabled btn-light' : '' }}" id="btnNotPass" value="notPass">
                                            <i class="bx bx-x"></i> ไม่ผ่าน
                                        </button>
									</div>
								</div>
							</span>
                        @endif
					@endhasrole
				</div>
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 ">
					@php
						$DateDocApp_Con = @$data->PactChecktoCon->DateDocApp_Con;

						function checklist($name, $DateDocApp_Con, $data)
						{
						    $UserApp = @$data->UserAppCheck;
						    $ArrUserApp = explode(',', $UserApp);

						    $UserBranch = @$data->UserBranchCheck;
						    $ArrUserBranch = explode(',', $UserBranch);

						    if ($UserApp != null || $UserBranch != null || (@$data->statusDoc == null || @$data->statusDoc == 'notPass')) {
						        $checkUserApp = in_array($name, $ArrUserApp) == true ? 'text-success ' : 'text-danger';
						        $checkUserBranch = in_array($name, $ArrUserBranch) == true ? 'text-success' : 'text-danger';

						        // if(@$DateDocApp_Con != NULL) {
						        if (@$data->statusDoc == 'notPass' || @$data->statusDoc == null || @$DateDocApp_Con == null) {
						            echo '<i class="bx bxs-user-circle fs-5 ' . $name . ' ' . $checkUserApp . '"></i> ';
						        } elseif (@$DateDocApp_Con != null) {
						            echo '<i class="bx bxs-user-circle fs-5 ' . $name . ' ' . $checkUserBranch . '"></i> ';
						        }

						        //  } else {
						        //     // if (@$data->statusDoc != NULL){
						        //     //      echo '<i class="bx bxs-user-circle fs-5 '.$name.' '. $checkUserApp.'"></i>';
						        //     // } else {
						        //         echo '<i class="bx bxs-user-circle fs-5 '.$name.' '. $checkUserBranch.'"></i>';
						        //     // }
						        // }
						    } else {
						        if (@$data->statusDoc == 'Pass') {
						            echo '<i class="bx bxs-user-circle fs-5 ' . $name . ' text-success"></i>';
						        }
						    }
						}

					@endphp
					<span id="loop">
						<div class="form-check">
							@php checklist('B1_Check_1',$DateDocApp_Con,$data) @endphp

							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_1" name="B1_Check_1" {{ @$data->B1_Check_1 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" class="" for="B1_Check_1" style="cursor : pointer;">1.เล่มทะเบียนตัวจริงและรายการต่อภาษี </label>
						</div>

						<div class="form-check">
							@php checklist('B1_Check_2',$DateDocApp_Con,$data) @endphp

							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_2" name="B1_Check_2" {{ @$data->B1_Check_2 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_2" style="cursor : pointer;">2.วันครอบครองและยอดจัด ตรงตามกำหนด</label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_3',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_3" name="B1_Check_3" {{ @$data->B1_Check_3 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_3" style="cursor : pointer;">3.บัตรประชาชนตัวจริงและไม่หมดอายุ</label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_4',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_4" name="B1_Check_4" {{ @$data->B1_Check_4 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_4" style="cursor : pointer;">4.ตรวจสอบทะเบียนบ้าน</label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_5',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_5" name="B1_Check_5" {{ @$data->B1_Check_5 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_5" style="cursor : pointer;">5.รายละเอียดในเล่มทะเบียนตรงกับรูปในอัลบั้ม </label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_6',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_6" name="B1_Check_6" {{ @$data->B1_Check_6 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_6" style="cursor : pointer;">6.รูปถ่ายลูกค้าคู่กับรถ</label>
						</div>
						<div class="form-check">

							@php checklist('B1_Check_7',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_7" name="B1_Check_7" {{ @$data->B1_Check_7 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_7" style="cursor : pointer;">7.รูปถ่ายลูกค้าตอนเซ็นสัญญา </label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_8',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_8" name="B1_Check_8" {{ @$data->B1_Check_8 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_8" style="cursor : pointer;">8.เอกสารเซ็นต์รับเงินลูกค้า(ใบสั้นสีขาว)</label>
						</div>
						<div class="form-check">
							@php checklist('B1_Check_9',$DateDocApp_Con,$data) @endphp
							<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_9" name="B1_Check_9" {{ @$data->B1_Check_9 == 'Y' ? 'checked' : '' }}>
							<label class="custom-control-label" for="B1_Check_9" style="cursor : pointer;">9.แผนที่บ้าน </label>
						</div>
					</span>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
					<div class="form-check text-red">
						@php checklist('B1_Check_10',$DateDocApp_Con,$data) @endphp
						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_10" name="B1_Check_10" {{ @$data->B1_Check_10 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_10" style="cursor : pointer;">10.ยอดจัด ยอดผ่อน จำนวนงวดและดอกเบี้ย</label>
					</div>
					<div class="form-check text-red">
						@php checklist('B1_Check_11',$DateDocApp_Con,$data) @endphp

						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_11" name="B1_Check_11" {{ @$data->B1_Check_11 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_11" style="cursor : pointer;">11.รายการตรวจสอบเล่มทะเบียน</label>
					</div>
					<div class="form-check text-red">
						@php checklist('B1_Check_12',$DateDocApp_Con,$data) @endphp
						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_12" name="B1_Check_12" {{ @$data->B1_Check_12 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_12" style="cursor : pointer;">12.เอกสาร PDPA</label>
					</div>
					<div class="form-check text-red">
						@php checklist('B1_Check_13',$DateDocApp_Con,$data) @endphp
						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_13" name="B1_Check_13" {{ @$data->B1_Check_13 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_13" style="cursor : pointer;">13.เบอร์โทรศัพท์ผู้กู้หรือผู้เช่าซื้อ / ผู้ค้ำ</label>
					</div>
					<div class="form-check text-red">
						@php checklist('B1_Check_14',$DateDocApp_Con,$data) @endphp
						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_14" name="B1_Check_14" {{ @$data->B1_Check_14 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_14" style="cursor : pointer;">14.เลขที่บัญชีผู้กู้หรือผู้เช่าซื้อ</label>
					</div>
					<div class="form-check text-red">
						@php checklist('B1_Check_15',$DateDocApp_Con,$data) @endphp
						<input class="custom-control-input" type="checkbox" value="Y" id="B1_Check_15" name="B1_Check_15" {{ @$data->B1_Check_15 == 'Y' ? 'checked' : '' }}>
						<label class="custom-control-label" for="B1_Check_15" style="cursor : pointer;">15.เซ็นสัญญาลูกค้าครบถ้วนตรงตามประเภทสัญญา</label>
					</div>

					<div class="col-12 d-grid px-4 mb-1 mt-2">
						<button type="button" class="btn btn-primary btn-sm rounded-pill checkAll"><i class="bx bx-check-square"></i> เลิอกทั้งหมด</button>
						<button type="button" class="btn btn-secondary btn-sm rounded-pill clearAll" style="display:none;"><i class="bx bxs-eraser"></i> นำออกทั้งหมด</button>
					</div>

					{{-- hidden value --}}
					<input type="hidden" class="valCheck" name="valCheck" readonly>
					<input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}" readonly>
					{{-- end hidden value --}}
					@hasrole(roleDocumentloans(@$data->PactChecktoCon->CodeLoan_Con))
						@if(auth()->user()->zone == 40)
						<div class="row px-4 mt-2 border-top">
							<label class="form-label fw-semibold">เงื่อนไขการอนุมัติ</label>
							<select name = "App_Outlet" class="form-control form-control-sm">
								@foreach ($App_Outlet as $item)
								<option value="{{ $item->id }}" {{ @$data->PactChecktoCon->App_Outlet == $item->id ? 'selected' : '' }} >{{ $item->Status_Approve }}</option>
								@endforeach
							</select>
						</div>
						@endif
					@endhasrole
				</div>
			</div>

		</form>
	</div>
	<input type="hidden" id="dataArr" value="{{ @$data->UserBranchCheck }}">
	<input type="hidden" id="dataArrApp" value="{{ @$data->UserAppCheck }}">
	<div class="modal-footer mt-4">

        @if(@$is_flag == true)
            <button type="button" id="ConfirmApp_Con" data-val="{{ auth()->user()->id }}" class="btn btn-primary btn-sm waves-effect waves-light hover-up" style="display: none;">
                <span class="addSpin"></span> อนุมัติเคส
            </button>

            <button type="button" id="CancelApp_Con" class="btn btn-danger btn-sm waves-effect waves-light hover-up btn-saveDoc" style="display: none;">
                <span class="addSpin"></span> ไม่อนุมัติ
            </button>
            <button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up btn-closeDetail" >
                <i class="mdi mdi-close-circle-outline"></i> ย้อนกลับ
            </button>
        @else
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn-saveDoc {{(@$data->statusDoc == 'Pass')? 'disabled' : ''}}">
                <span class="addSpin"></span> บันทึก
            </button>
            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
        @endif
	</div>

</div>

<script>
    $(".btn-closeDetail").on('click', function(){
      $('#modal_xl_static').modal('hide');
      $('#modal_xl_2').modal('show');
    });
</script>


<script>
	$(function() {

		$('#formDocument input[type="checkbox"]').on('change', () => {
			let d = $('#formDocument input[type="checkbox"]:checked').map(function() {
				let id = $(this).attr('id');
				$('.' + id).removeClass('text-danger');
				return $(this).attr('id');
			}).get();
			$('#textarr').val(d + '')
		})

		$('#id').val(sessionStorage.getItem('PactCon_id'))
		// $('.btn-saveDoc').prop('disabled',true);
		$('.statDoc').click((e) => {
			const value = $(e.currentTarget).attr('value');
			const id = $(e.currentTarget).attr('id');
			$('.statDoc').removeClass('btn-success btn-danger').addClass('btn-light');
			if (value == 'Pass') {
				$('.Pass').addClass('btn-success').removeClass('btn-light');
				$('.btn-saveDoc').prop('disabled', false);
				$('.valCheck').val(value);
                $('#ConfirmApp_Con').show();
                $('#CancelApp_Con').hide();

			} else if (value == 'notPass') {
				$('.notPass').addClass('btn-danger').removeClass('btn-light');
				$('.btn-saveDoc').prop('disabled', false);
				$('.valCheck').val(value);
                $('#CancelApp_Con').show();
                $('#ConfirmApp_Con').hide();


			} else {
				// $('.btn-saveDoc').prop('disabled',true);
			}

		})

		$('.checkAll').click(() => {
			$('.checkAll').toggle();
			$('.clearAll').toggle();
			$('#formDocument input[type=checkbox]').prop('checked', true);
		})
		$('.clearAll').click(() => {
			$('.checkAll').toggle();
			$('.clearAll').toggle();
			$('#formDocument input[type=checkbox]').prop('checked', false);
		})

		$('.btn-saveDoc').click(() => {
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");
            $('.btn-saveDoc').prop('disabled', true);
            CheckInput()
            $.ajax({
                url: "{{ route('contract.store') }}",
                type: 'post',
                data: $('#formDocument').serialize(),
                success: (res) => {
                    if (res.FlagCon == 'fail') {
                        swal.fire({
                            icon: 'error',
                            title: 'Success !',
                            text: 'ไม่สามารถบันทึกการตรวจสอบได้ สัญญารอนุมัติเเล้ว',
                            timer: 2000,
                        })
                    } else if (res.FlagCon == 'error') {
                        swal.fire({
                            icon: 'error',
                            title: 'Success !',
                            text: res.text,
                            timer: 2000,
                        });
                        $('.modal').modal('hide');
                    } else {
                        $('.addSpin').empty()
                        $('.btn-saveDoc').prop('disabled', false);
                        swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'อัพเดทรายการตรวจเอกสารแล้ว',
                            timer: 2000,
                        })
                        $('.modal').modal('hide')
                        $('#section-content').html(res.html)
                        $('#section-Tab').html(res.renderTab);
                        $('#section-cardCon').html(res.htmlheader)
                    }

                },
                error: (err) => {
                    $('.addSpin').empty()
                    $('.btn-saveDoc').prop('disabled', false);
                     swal.fire({
                        icon : 'error',
                        title : `${ err.responseJSON.message}`,
                        text : `${ err.responseJSON.text}`,
                        showConfirmButton: true,
                    })
                }
            })
		})

		CheckInput = () => {
			let arr = [1, 6, 9, 4, 12]
			let count = 1
			let e = 0
			let status = ''
			$('#formDocument input[type=checkbox]').each(function() {
				let eleID = $(this).attr('id')
				let coutCheck = $('#' + eleID).prop('checked')
				if (arr.includes(count) == false) {
					if (coutCheck == true) {
						$('#StatusApprove').val('Y')

					} else {
						$('#StatusApprove').val('')
						return false;
					}
				}
				count++

			});
		}

	})
</script>


 {{-- อนุมัติสัญญา --}}

<script>
	$('#ConfirmApp_Con').on('click', function() {
		let valCheck = $('.valCheck').val()
		let id = sessionStorage.getItem('PactCon_id')
		var url = "{{ route('contract.update',':ID') }}"
		url = url.replace(':ID',id)
		var _token = $('input[name="_token"]').val();
		var idName = $(this).attr("id");
		var data = {};
		data[$(this).attr("id")] = $(this).attr("data-val");
		data['type'] = 'approve';
        data['page'] = 'DocumentsApprove';
		data['_token'] = _token;
		data['PactCon_id'] = id;
		data['statusDoc'] = valCheck;

		var tital_txt = "ตรวจสอบข้อมูลให้เรียบร้อยก่อนกด ตกลง";
		var Confirm_Position = $('#Confirm_Position').val();
		var Approve_Position = $('#Approve_Position').val();
		var user_position = $('#user_position').val();
		var chkConType = $('#chkConType');
		var CodeLoan_con = $('#CodeLoan_con').val();
		var DateCheckBookcar = $('#DateCheck_Bookcar').val();
		var DateSpecialBookcar = $('#DateSpecial_Bookcar').val();
		var Contract_Con = $('#Contract_Con').val();

		if (chkConType.val() == 'person') {
			var C_Asset = chkConType;
		} else {
			var C_Asset = $('#C_Asset');
		}

		var addr_cus = $('#addr_cus');
		var IDCard_cus = $('#IDCard_cus');
		var CusCareer = $('.CusCareer');
		var Name_Account = $('#Name_Account');
		var Number_Account = $('#Number_Account');
		var Link_Upload = $('#Link_Upload');
		var Balance_Price0 = $('.Balance_Price0');

		var Name_Broker = $('#Name_Broker');
		var IDCard_Broker = $('#IDCard_Broker');
		var NameAccount_Broker = $('#NameAccount_Broker');
		var Account_Broker = $('#Account_Broker');
		var Type_Commission = $('#Type_Commission');

		var dataPurpose = $('#dataPurposes');
		var dataUnReg = $('#dataUnRegs');
		var dataReg = $('#dataRegs');
		var PhoneCus_Refs = $('#PhoneCus_Refs');
		var Cus_Refs = $('#Cus_Refs');

		var chcekApp = false;

		var val_empty = new Array(IDCard_cus, Name_Account, Number_Account, Link_Upload, C_Asset, Balance_Price0);
		var error_cus = "";
		var chcekCus = true;

		var microlist = new Array('11', '12', '13', '17');
		var CheckIndent = $('#CheckIndent').val()
		console.log(idName, CheckIndent);
		for (let i = 0; i < val_empty.length; i++) {
			if (val_empty[i].val() == "") {
				error_cus += "<li class='text-red'>" + val_empty[i].attr('placeholder') + "</li>";
				val_empty[i].addClass('is-invalid');
				chcekCus = false;
			}
		}

		var val_empty_broker = new Array(Name_Broker, IDCard_Broker, NameAccount_Broker, Account_Broker, Type_Commission);
		var error_broker = "";
		var chcekbroker = true;

		var arr_app = new Array(Approve_Position, 'administrator', 'manager');
		//val_empty.includes('')
		if (chcekCus == false) {
			// $('#C_Asset').addClass('is-invalid');
			// $('.CusCareer').addClass('is-invalid');
			// $('#addr_cus').addClass('is-invalid');
			// $('#IDCard_cus').addClass('is-invalid');
			// $('#Name_Account').addClass('is-invalid');
			// $('#Number_Account').addClass('is-invalid');
			// $('#Link_Upload').addClass('is-invalid');
			// $('#Balance_Price0').addClass('is-invalid');


			var span = document.createElement("span");
			span.classList.add('text-muted');
			span.innerHTML = "กรุณาตรวจสอบข้อมูลลูกค้าที่จำเป็น ก่อนขออนุมัติ \n<ul style='text-align: left'>" +
				error_cus +
				"</ul>";

			Swal.fire({
				icon: 'error',
				title: 'ข้อมูลไม่ครบถ้วน',
				html: span,
			});

		} else {
			if (Name_Broker.val() != "") {
				for (let i = 0; i < val_empty_broker.length; i++) {
					if (val_empty_broker[i].val() == "") {
						error_broker += "<li class='text-red'>" + val_empty_broker[i].attr('placeholder') + "</li>";
						val_empty_broker[i].addClass('is-invalid');
						chcekbroker = false;
					}
				}
				if (chcekbroker == false) {
					var span = document.createElement("span");
					span.classList.add('text-muted');
					span.innerHTML = "กรุณาตรวจสอบข้อมูลผู้แนะนำที่จำเป็น ก่อนขออนุมัติ \n<ul style='text-align: left'>" +
						error_broker +
						"</ul>";

					Swal.fire({
						icon: 'error',
						title: 'ข้อมูลไม่ครบถ้วน',
						html: span,
					});

				} else {
					chcekApp = true;
				}
			} else {
				chcekApp = true;
			}
		}

		if (chcekApp == true) {
			if (idName == "ConfirmApp_Con" && !arr_app.includes(user_position)) {
				Swal.fire({
					icon: 'error',
					text: 'ผู้ใช้งาน USER นี้ไม่มีสิทธิ์ในการอนุมัติ',
				})

			} else {
					sendUpdate(data, url, idName, tital_txt);

				// if(chkConType.val()=='car'||chkConType.val()=='moto'){
				//   if ($('#DateCheck_Bookcar').prop('checked')==true ||$('#DateSpecial_Bookcar').prop('checked')==true) {
				//     sendUpdate(data,url,idName,tital_txt);
				//   }else{
				//     Swal.fire({
				//       icon: 'error',
				//       text: 'กรุณาตรวจสอบเล่มทะเบียน หรือ อนุมัติพิเศษ',
				//     })
				//   }
				// }else{
				// if ((CheckIndent > 0 && idName == "ConfirmApp_Con") && microlist.includes(CodeLoan_con) == false) {
				// 	Swal.fire({
				// 		icon: 'info',
				// 		title: 'อนุมัติไม่สำเร็จ !',
				// 		text: 'ยังมีทรัพย์ที่ใช้งานในสัญญาอื่น  กรุณาปิดสัญญา ' + Contract_Con + ' ให้เรียบร้อยก่อนทำการอนุมัติ ',
				// 	})
				// } else {
				// 	sendUpdate(data, url, idName, tital_txt);
				// }
				//}   
			}
		}
	});
</script>
