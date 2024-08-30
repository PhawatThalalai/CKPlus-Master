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
			<input type="hidden" name="Typeloan" id="Typeloan" value="{{@$Pact->ContractToCal->TypeLoans}}">
			<input type="text" name="TagComm_id" id="TagComm_id" value="{{@$Pact->DataTag_id}}">
			<input type="hidden" id="countList" value="{{ count(@$dataList) }}">

			@php
				// checklist('{{ @$item->CodePact }}',$DateDocApp_Con,$data);
				// $datalist= @$data->toArray();
				$arrUserAppCheck = explode(",",@$data->UserAppCheck);
				$arrUserBranchCheck = explode(",",@$data->UserBranchCheck);
				$arrCorrect = @$data->Correct != NULL ? explode(",",@$data->Correct) : [];
			@endphp
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2 text-center border-2 border-end">
					<div class="col-12">
                        @php
                            if(count(@$dataList) != 0){
                                @$per = (count(@$arrUserAppCheck) / count(@$dataList)) * 100;
                            }else {
                                @$per = 0;

                            }
                            if($per == 100){
                                $color = 'bg-success';
                            }else{
                                $color = 'bg-warning';
                            }
                        @endphp
						<label class="fw-semibold" for="">ความสมบูรณ์ของเอกสาร</label>
						<div class="progress animated-progess mb-4">
							<div class="progress-bar progressDoc {{ $color }}" role="progressbar" style="width: {{ number_format(@$per,0) }}%" aria-valuenow="{{ count(@$arrUserAppCheck) }}" aria-valuemin="0" aria-valuemax="{{ count(@$dataList) }}">{{ number_format( @$per,0) }} %</div>
						</div>
					</div>
					<img src="{{ URL::asset('\assets\images\undraw\docu.svg') }}" alt="" style="width: 70%;">
						@if (@$Pact->UserApp_Con == auth()->user()->id || @$roleNum > 0)
							<span class="">
								<div class="row">
									<div class="col-4 text-end ">
										<label class="fw-semibold" for="">สถานะเอกสาร</label>
									</div>
									<div class="col m-auto">
										<div class="border border-bottom"></div>
									</div>
								</div>
								<div class="row px-4 g-2">
									<div class="col-6 text-center d-grid">
										<button type="button" class="btn btn btn-sm rounded-pill statDoc Pass shadow-sm {{(@$data->statusDoc == 'Pass')? ' btn-success' : 'btn-light'}}" id="btnPass" value="Pass">
                                            <i class="bx bx-check"></i> ผ่าน
                                        </button>
									</div>
									<div class="col-6 text-center d-grid">
										<button type="button" class="btn btn btn-sm rounded-pill statDoc notPass shadow-sm {{(@$data->statusDoc == 'notPass' or empty(@$data->statusDoc))?? 'btn-light'}} {{ (@$data->statusDoc == 'Pass') ? ' btn-light' : '' }}" id="btnNotPass" value="notPass">
                                            <i class="bx bx-x"></i> ไม่ผ่าน
                                        </button>
									</div>
								</div>
							</span>
                        @endif
				</div>
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
					<div class="row">
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 text-center">
							<div class="form-check form-radio-success mb-3">
								<input class="form-check-input" type="radio" name="series1" id="series1" checked="">
								<label class="form-check-label" for="series1">
									อนุมัติแล้ว
								</label>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 text-center">
							<div class="form-check form-radio-info mb-3">
								<input class="form-check-input" type="radio" name="series2" id="series2" checked="">
								<label class="form-check-label" for="series2">
									ตรวจสอบแล้ว
								</label>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 text-center">
							<div class="form-check form-radio-danger mb-3">
								<input class="form-check-input" type="radio" name="series3" id="series3" checked="">
								<label class="form-check-label" for="series3">
									ต้องแก้ไข
								</label>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 text-center">

									<label class="form-check-label" for="series4" onclick="reData()">
										คืนค่า <i class="bx bx-rotate-right "></i>
									</label>

							{{-- <button type="button" class="btn btn-primary rounded-pill btn-sm"  onclick="reData()">คืนค่า <i class="bx bx-rotate-right "></i></button> --}}
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							@if(count(@$arrCorrect) > 0)
							<div class="alert alert-danger  d-flex align-items-center" role="alert">
								<i class="bx bxs-info-circle fs-5 mx-2"></i>  มี <b class="mx-2">{{ count(@$arrCorrect) }} รายการ</b> เอกสารที่ต้องแก้ไข
							</div>
							@endif
						</div>

					</div>
					@php
						$DateDocApp_Con = @$data->PactChecktoCon->DateDocApp_Con;
                        dump(@$roleNum);
					@endphp
						<table class="table table-sm table-striped ">
							<thead>
								<tr>
									<th>รายการ</th>
									<th class="text-center">สาขา </th>
									<th class="text-center">แก้ไข </th>
									<th class="text-center">อนุมัติ </th>


								</tr>
							</thead>
							<tbody>
								@foreach(@$dataList as $item)
								<tr>
										{{-- <input class="custom-control-input" type="checkbox" value="Y" id="{{ @$item->CodePact }}" name="{{ @$item->CodePact }}" {{ $datalist[@$item->CodePact]  == 'Y' ? 'checked' : '' }}> --}}
										<td>
											<label class="custom-control-label" class="" for="{{ @$item->CodePact }}" style="cursor : pointer;">{{ $loop->iteration }}. {{ $item->name_th }}</label>
										</td>
										<td class="text-center">
											<div class="form-radio-info UserBranchCheck">
												<input class="form-check-input UserBranchCheck" type="radio"  code="{{ @$item->CodePact }}" name="{{ @$item->CodePact }}" value="{{ @$item->id }}"{{ in_array(@$item->id,$arrUserBranchCheck) == true ? 'checked' : '' }} style="{{ @$Pact->Status_Con == 'pending' || @$Pact->Status_Con == 'complete' || @$Pact->Status_Con == 'transfered' ||  in_array(@$item->id,$arrUserAppCheck) == true ? 'pointer-events:none;' : '' }}">
											</div>
										</td>
										<td class="text-center">
											<div class="form-radio-danger correct">
												<input class="form-check-input {{ @$Pact->UserApp_Con != auth()->user()->id ? 'disabled' : '' }} correct" type="radio" code="{{ @$item->CodePact }}" name="{{ @$item->CodePact }}" value="{{ @$item->id }}"{{ in_array(@$item->id,$arrCorrect) == true ? 'checked' : '' }} style="{{ @$roleNum > 0 ? '' : 'pointer-events:none;' }}" >
											</div>
										</td>
										<td class="text-center">
											<div class="form-radio-success UserAppCheck">
												<input class="form-check-input {{ @$Pact->UserApp_Con != auth()->user()->id ? 'disabled' : '' }} UserAppCheck" type="radio" code="{{ @$item->CodePact }}" name="{{ @$item->CodePact }}" value="{{ @$item->id }}" {{ in_array(@$item->id,$arrUserAppCheck) == true  ? 'checked' : '' }} style="{{  @$roleNum == 0 || @$Pact->Status_Con == 'complete' || @$Pact->Status_Con == 'transfered' ? 'pointer-events:none;' : '' }}">
											</div>
										</td>

								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th>เลือกทั้งหมด</th>
									<td class="text-center"><label class="custom-control-label"><input class="custom-control-input checkBranch" name="checkall" type="checkbox" onchange="checkAll('checkBranch','UserBranchCheck')" {{ @$Pact->Status_Con == 'pending' || @$Pact->Status_Con == 'complete' || @$Pact->Status_Con == 'transfered' || @$roleNum > 0 ? 'disabled' : '' }}></label></td>
									<td class="text-center"></td>
									<td class="text-center"><label class="custom-control-label"><input class="custom-control-input checkApprove" name="checkall" type="checkbox" onchange="checkAll('checkApprove','UserAppCheck')" {{  @$Pact->Status_Con == 'complete' || @$Pact->Status_Con == 'transfered' || @$roleNum == 0 ? 'disabled' : '' }}></label></td>
								</tr>
							</tfoot>

						</table>

					{{-- hidden value --}}
					<div style="display: non;">
						<div class="form-floating mb-3">
						  <textarea class="form-control AreaHidden" name="UserAppCheck" id="UserAppCheck" cols="30" rows="10">{{ @$data->UserAppCheck}}</textarea>
						  <label for="UserAppCheck">ผู้อนุมัติ</label>
						</div>

						<div class="form-floating mb-3">
						  <textarea class="form-control AreaHidden" name="UserBranchCheck" id="UserBranchCheck" cols="30" rows="10">{{ @$data->UserBranchCheck}}</textarea>
						  <label for="UserBranchCheck">สาขา</label>
						</div>

						<div class="form-floating mb-3">
						  <textarea class="form-control AreaHidden" name="correct" id="correct" cols="30" rows="10">{{ @$data->Correct}}</textarea>
						  <label for="correct">ต้องแก้ไข</label>
						</div>
					</div>

					  {{-- <div class="form-floating mb-3">
						<textarea class="form-control" name="list" id="list" cols="30" rows="10"></textarea>
						<label for="list">List</label>
					  </div>
					 --}}
					 <input type="hidden" class="valCheck" name="valCheck" readonly>




					<input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}" readonly>
					{{-- end hidden value --}}
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
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn-saveDoc">
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
		let correct = $('#correct').val()
		let UserBranchCheck = $('#UserBranchCheck').val()
		let UserAppCheck = $('#UserAppCheck').val()

		sessionStorage.setItem('UserAppCheck',UserAppCheck)
		sessionStorage.setItem('UserBranchCheck',UserBranchCheck)
		sessionStorage.setItem('correct',correct)


		$('#formDocument input[type="radio"]').on('change', () => {
			let correct = $('#formDocument .correct:checked').map(function() {
				let id = $(this).attr('value');
				return $(this).attr('value');
			}).get();

			let UserBranchCheck = $('#formDocument .UserBranchCheck:checked').map(function() {
				let id = $(this).attr('value');
				return $(this).attr('value');
			}).get();

			let UserAppCheck = $('#formDocument .UserAppCheck:checked').map(function() {
				let id = $(this).attr('value');
				return $(this).attr('value');
			}).get();

			$('#correct').val(correct + '')
			$('#UserBranchCheck').val(UserBranchCheck + '')
			$('#UserAppCheck').val(UserAppCheck + '')

			let countProgrss = parseInt($('#countList').val())
			let countApp = UserAppCheck.length
			let per = (countApp / countProgrss) * 100 || 0
			$('.progressDoc').css('width', per+'%').html(per.toFixed(0) + '% ')


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

		checkAll = (classCheck,elements) => {
			return new Promise((resolve,reject) => {
				setTimeout(() => {
						let ssCorrect = sessionStorage.getItem('correct')
						let Check = $('.'+classCheck).prop('checked')
						if(ssCorrect.split(',').length > 0 && ssCorrect.split(',') != ''){
							if(Check == true) {
								if(elements == 'UserBranchCheck') {
									let getCorrect = ssCorrect.split(',').map(function(item){
										return `#formDocument .${elements} input[value='${item}']`
									}).join(',')
									$(getCorrect).prop('checked', true);
								}else{
									$('#formDocument .'+elements).prop('checked', true);
								}
								console.log(ssCorrect.split(',').length, ssCorrect.split(',') != '');

							}else{
								let getCorrect = ssCorrect.split(',').map(function(item){
									return `#formDocument .correct input[name='${item}'] `
								}).join(',')
								$('#formDocument .'+elements).prop('checked', false);
								console.log(4);

							}
						}else{
							if(Check == true){
								if(elements == 'UserBranchCheck') {
									let getCorrect =  $('#formDocument .UserAppCheck').map(function(item){
										if ($(this).is(':not(:checked)')){
											let code = $(this).attr('code')
											return `#formDocument .UserBranchCheck input[type='radio'][name='${code}'] `
										}
									}).get().join(',')
									$(getCorrect).prop('checked', true);
									console.log(1,elements,getCorrect);
								} else {
									$('#formDocument .'+elements).prop('checked', true);
								}
							}else{
								if(elements == 'UserBranchCheck') {
									let getCorrect =  $('#formDocument .UserAppCheck').map(function(item){
										if ($(this).is(':not(:checked)')){
											let code = $(this).attr('code')
											return `#formDocument .UserBranchCheck input[type='radio'][name='${code}'] `
										}
									}).get().join(',')
									console.log(getCorrect);
									$(getCorrect).prop('checked', false);
								} else {
									$('#formDocument .'+elements).prop('checked', false);
								}
								console.log(2);
							}
						}
						resolve( getDataTotextBox(classCheck,elements) );

				}, 200);
			})
		}

		getDataTotextBox = (classCheck,elements) =>{
			return new Promise((resolve, reject) => {
				setTimeout(() => {
					let ssCorrect = sessionStorage.getItem('correct')
					let ssUserAppCheck = sessionStorage.getItem('UserAppCheck')
					let ssBranchCheck = sessionStorage.getItem('UserBranchCheck')
					let concatenatedArray = Array.from(new Set(ssCorrect.split(',').concat(ssUserAppCheck.split(',') , ssBranchCheck.split(','))));
					concatenatedArray = concatenatedArray.filter(value => value !== '');

					let Check = $('.'+classCheck).prop('checked')

					if(ssCorrect.split(',').length > 0  && ssCorrect.split(',') != '') {
						if(Check == true){
							if(elements == 'UserBranchCheck') {
								$('.AreaHidden').val('')
								$('#UserBranchCheck').val(ssCorrect)
								$('#UserAppCheck').val(ssUserAppCheck)
								console.log('t1');
							}else{
								$('.AreaHidden').val('')
								$('#UserAppCheck').val(ssCorrect+','+ssUserAppCheck)
								console.log('t5');
							}

						} else {
							if(Check == true){
								if(elements == 'UserBranchCheck') {
									console.log('t2');
									$('.AreaHidden').val('')
									// $('#correct').val(ssCorrect)
									$('#UserAppCheck').val(ssUserAppCheck)

								}else{
									$('.AreaHidden').val('')
									console.log('t3');
								}
							}else{
								$('#'+elements).val('')
								console.log('t4');

							}
						}

					} else {
						if(Check == true){
							if(elements == 'UserBranchCheck') {
							 let all =  $('#formDocument .UserAppCheck').map(function(item){
									if ($(this).is(':not(:checked)')){
										return  $(this).attr('value')
									}
								}).get().join(',')
								$('#'+elements).val(all)
							}else{
								$('.AreaHidden').val('')
                                if(concatenatedArray.length != 0){
                                    $('#'+elements).val(concatenatedArray +' ')
                                    console.log('get ss');
                                }else{
                                    let UserAppCheck = $('#formDocument .UserAppCheck:checked').map(function() {
                                        let id = $(this).attr('value');
                                        return $(this).attr('value');
                                    }).get();
                                    $('#'+elements).val(UserAppCheck +' ')
                                    console.log('get ele');

                                }

								console.log('t6');

							}
						}else{
							$('#'+elements).val('')
						}


					}
						resolve('Add Success !');
						console.log('test');

						// คำนวณเปอร์เซ็น
						let UserAppCheck = $('#formDocument .UserAppCheck:checked').map(function() {
							return $(this).attr('value');
						}).get();
						let countProgrss = parseInt($('#countList').val())
						let countApp = parseInt(UserAppCheck.length)
						let per = ((countApp / countProgrss) * 100) || 0
						$('.progressDoc').css('width', per+'%').html(per.toFixed(0) + '% ')
                        console.log( (countApp / countProgrss) * 100 );
						console.log('Add Success !');
				}, 200);
			});
		}


		reData = () => {
			let SSAppCheck = sessionStorage.getItem('UserAppCheck');
			let SSBranch = sessionStorage.getItem('UserBranchCheck');
			let ssCorrect = sessionStorage.getItem('correct');

			let selectAppCheck = SSAppCheck.split(',').map((itemName)=>{
				return `#formDocument .UserAppCheck input[value='${itemName}'][type='radio'] `;
			}).join(", ");

			let selectBranch = SSBranch.split(',').map((itemName)=>{
				return `#formDocument .UserBranchCheck input[value='${itemName}'][type='radio'] `;
			}).join(", ");

			let selectCorrect = ssCorrect.split(',').map((itemName)=>{
				return `#formDocument .correct input[value='${itemName}'][type='radio'] `;
			}).join(", ");


			$(selectAppCheck).prop('checked', true);
			$(selectBranch).prop('checked', true);
			$(selectCorrect).prop('checked', true);

			$('#correct').val(ssCorrect)
			$('#UserBranchCheck').val(SSBranch)
			$('#UserAppCheck').val(SSAppCheck)

			$('#formDocument input[type=checkbox]').prop('checked', false)

		}

		CheckInput = () => {
			let Typeloan = $('#Typeloan').val()
			if(Typeloan == 'car'){
				let arr = ['B1_Check_1','B1_Check_6','B1_Check_9','B1_Check_4','B1_Check_12'] //บังคับ รถ
				let count = 1
				let e = 0
				let status = ''
				let UserAppCheck = sessionStorage.getItem('UserAppCheck').split(',')
				let UserBranchCheck = $('#UserBranchCheck').val().split(',')
				var combinedArray = Array.from(new Set(UserAppCheck.concat(UserBranchCheck,arr)));
				console.log(combinedArray);
				for(let item of combinedArray){
					let attr = item
					let EditCheck = $(` #formDocument .correct input[name='${attr}']`).prop('checked')
					let BranchCheck = $(` #formDocument .UserBranchCheck input[name='${attr}']`).prop('checked')
					let AppchCheck = $(` #formDocument .UserAppCheck input[name='${attr}']`).prop('checked')


					if (arr.includes(attr) == true ) {
						if(  EditCheck == false && (BranchCheck == true || AppchCheck == true)){
							$('#StatusApprove').val('Y')
						}else{
							$('#StatusApprove').val('')
							return false;
						}
					}


				}



			}else{
				let arr = ['B1_Check_1','B1_Check_6','B1_Check_9','B1_Check_4','B1_Check_12'] //ที่ดิน
				let count = 1
				let e = 0
				let status = ''
				let UserAppCheck = sessionStorage.getItem('UserAppCheck').split(',')
				let UserBranchCheck = $('#UserBranchCheck').val().split(',')
				var combinedArray = Array.from(new Set(UserAppCheck.concat(UserBranchCheck,arr)));
				console.log(combinedArray);
				for(let item of combinedArray){
					let attr = item
					let EditCheck = $(` #formDocument .correct input[name='${attr}']`).prop('checked')
					let BranchCheck = $(` #formDocument .UserBranchCheck input[name='${attr}']`).prop('checked')
					let AppchCheck = $(` #formDocument .UserAppCheck input[name='${attr}']`).prop('checked')


					if (arr.includes(attr) == true ) {
						if(  EditCheck == false && (BranchCheck == true || AppchCheck == true)){
							$('#StatusApprove').val('Y')
						}else{
							$('#StatusApprove').val('')
							return false;
						}
					}


				}
			}
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
