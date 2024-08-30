<style>
	.scroll-slide::-webkit-scrollbar {
		height: 5px;
		background-color: #fff;
	}

	.scroll-slide::-webkit-scrollbar-thumb {
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
		background-color: #fff;
	}

	.scroll-slide {
		overflow-x: scroll;
	}

	.btnBranch:hover {
		scale: 1.05;
		transition: 0.3s;
	}

	.btnBranch {
		transition: 0.3s;
	}
</style>
@php
	$checkFill = true;
@endphp

<div class="modal-content" style="max-height : 600px; overflow-x:scroll; ">
	<input type="hidden" value="{{ @$data->id }}" id="idCon">
	<input type="hidden" value="{{ count(@$CheckIndent) }}" id="CheckIndent">
	<input type="hidden" value="{{ @$data->CodeLoan_Con }}" id="CodeLoan_con">
	<input type="hidden" value="{{ count(@$CheckIndent) > 0 ? implode(', ', @$CheckIndent->pluck('Contract_Con')->toArray()) : 0 }}" id="Contract_Con">
	<input type="hidden" id="chkConType" value="{{ @$data->ContractToDataCusTags->TagToCulculate->TypeLoans }}">

	<div class="row">
		<div class="col pt-2">
			<nav id="navbar-Preview" class="navbar px-3 border-2 border-bottom border-secondary border-opacity-50">
				<a class="navbar-brand text-primary fw-semibold" href="#"><i class="bx bx-select-multiple"></i> Preview</a>
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent1">ข้อมูลสัญญา</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent2">ข้อมูลทรัพย์</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent3">ข้อมูลผู้ค้ำ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent4">ข้อมูลผู้รับเงิน</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent5">ข้อมูลผู้แนะนำ</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent6">รายละเอียดค่าใช้จ่าย</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#scrollContent7">เอกสารอนุมัติ</a>
					</li>

				</ul>
			</nav>
		</div>
	</div>
	<div class="modal-body bg-light px-3">

		<div data-bs-spy="scroll" data-bs-target="#navbar-Preview" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example p-3 rounded-2" tabindex="0">
			<span id="scrollContent1"></span>
			{{-- header title --}}
			@include('frontend\content-con\section-preview\header-preview')
			<span id="scrollContent2"></span>
			{{-- content asset  --}}
			@include('frontend\content-con\section-preview\asset-preview')
			<span id="scrollContent3"></span>
			{{-- content Guaran --}}
			@include('frontend\content-con\section-preview\guaran-preview')
			<span id="scrollContent4"></span>
			{{-- content payee --}}
			@include('frontend\content-con\section-preview\payee-preview')
			<span id="scrollContent5"></span>
			{{-- content Broker --}}
			@include('frontend\content-con\section-preview\broker-preview')

			<span id="scrollContent6"></span>
			{{-- content OPR --}}
			@include('frontend\content-con\section-preview\operate-preview')

			<span id="scrollContent7"></span>
			{{-- content Doc --}}
			@include('frontend\content-con\section-preview\doc-preview')
		</div>

	</div>
	<div class="modal-footer">

		<input type="hidden" id="Approve_Position" value="{{ @$Approve[0] }}">
		<input type="hidden" id="user_position" value="{{ @$userApprove[0] }}">
		@php
			@$land_type = $data->ContractToTypeLoan->id_rateType;

			$chkClosePayee = true;
			$chkPayee = true;
			$closePayee = 0;
			$Type_Customer = @$data->ContractToDataCusTags->Type_Customer;
			$closePayee = @$data->ContractToPayee->filter(function ($item) {
			    return $item['status_Payee'] == 'CloseAcount';
			});

			$Payee = 0;

			$Payee = @$data->ContractToPayee->filter(function ($item) {
			    return $item['status_Payee'] == 'Payee';
			});

			if (count($Payee) == 0 && $Type_Customer != "CUS-0009" ) {
			    $chkPayee = false;
			} else {
			    $chkPayee = true;
			}

			if (@$data->ContractToOperated->AccountClose_Price > 0 && count($closePayee) == 0) {
			    $chkClosePayee = false;
			} else {
			    $chkClosePayee = true;
			}
			$chkBroker = true;
			if (count(@$data->ContractToBrokers) > 0 && @$data->ContractToBrokers != null) {
			    $chkBroker = @$data->ContractToBrokers->pluck('SumCom_Broker')->filter(function ($item) {
			        return $item == null;
			    });
			    if (count(@$chkBroker) > 0) {
			        $chkBroker = false;
			    }
			}
			// elseif(@$data->DocApp_Con != NULL && @$data->ConfirmDocApp_Con != NULL && @$data->ConfirmApp_Con == NULL){
			//   $btnApprove = 'ConfirmDocApp_Con';
			//   $btnTxt = 'อนุมัติสัญญา';
			// }

			// @$data->DateCheck_Bookcar == NULL || @$data->DateSpecial_Bookcar == NULL || @$data->LinkUpload_Con == NULL
			if (count(@$data->ContractToIndentureAsset2) == 0 || @$data->ContractToOperated == null) {
			    // เช็คว่ามีการเลือก ทรัพย์ ผู้รับเงิน หรือเพิ่มค่าใช้จ่ายในหน้าสัญญาแล้วยัง
			    if (@$data->CodeLoan_Con == '17') {
			        $dataCheck = true;
			    } else {
			        $dataCheck = false;
			    }
			} else {
			    $dataCheck = true;
			}

			if ((@$data->DateCheck_Bookcar == null && @$data->DateSpecial_Bookcar == null && $land_type != 'land') || @$data->LinkUpload_Con == null) {
			    // เช็คว่ามีการเลือก ทรัพย์ ผู้รับเงิน หรือเพิ่มค่าใช้จ่ายในหน้าสัญญาแล้วยัง
			    $dataCheckCon = false;
			} else {
			    $dataCheckCon = true;
			}
		@endphp

		@if (@$data->Adds_Con != null && $dataCheck != false && $dataCheckCon != false && $chkClosePayee != false && $chkPayee != false && $dataCheck != false)
			@if (@$data->DocApp_Con == null && @$data->ContractToAudittor->StatusApprove == 'Y')
				<button type="button" id="DocApp_Con" data-val="{{ auth()->user()->id }}" class="btn btn-primary btn-sm waves-effect waves-light hover-up"> <span class="spinner"></span>ขออนุมัติสัญญา</button>
			@elseif(@$data->DocApp_Con != null && @$data->ConfirmApp_Con == null && count($userApprove) > 0 )
                @if(@$data->ContractToAudittor->statusDoc != 'Pass') {{-- ถ้าเอกสารยังไม่ผ่านให้เด้ง pop-up ตรวจเอกสารก่อนการอนุมัติ --}}
                    <a type="button" class="btn btn-primary btn btn-sm detail-transfer" onclick="openModal('{{ route('contract.edit',@$data->id) }}?funs={{ 'editDoc' }}&flagModal={{ 'yes' }}&TypeLoans={{ @$land_type }}')" data-bs-toggle="modal" data-bs-target="#modal_xl_static">ทำรายการ <i class="bx bx-transfer"></i></a>
                @else
				    <button type="button" id="ConfirmApp_Con" data-val="{{ auth()->user()->id }}" class="btn btn-primary btn-sm waves-effect waves-light hover-up"> <span class="spinner"></span>อนุมัติสัญญา</button>
                @endif
			@endif

		@endif

		<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
	</div>
</div>




<script>
	openModal = (link) => {
		var url = link;
		$('#modal_xl_static .modal-dialog').empty();
		$('#modal_xl_static .modal-dialog').load(url, function(response, status, xhr) {
			if (status === 'success') {
				$('#modal_xl_static').modal('show');
				// $('#modal_xl_2').modal('hide');
			} else {
				// console.log('Load failed');
			}
		});
	}
</script>


<script>
	$('#DocApp_Con,#ConfirmDocApp_Con,#ConfirmApp_Con,#Date_BookSpecial').on('click', function() {
		var url = "{{ route('contract.update', $data->id) }}";
		var _token = $('input[name="_token"]').val();
		var idName = $(this).attr("id");
		var data = {};
		data[$(this).attr("id")] = $(this).attr("data-val");
		data['type'] = 'approve';
		data['_token'] = _token;
		data['PactCon_id'] = '{{ $data->id }}';

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
