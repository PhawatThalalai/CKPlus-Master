<style>
	.popover-header {
		color: var(--bs-dark);
		background-color: var(--bs-light);
	}

	.contract-info-arrow:after {
		border-bottom-color: var(--bs-info) !important;
	}

	.content-info-row:nth-child(4n),
	.content-info-row:nth-child(4n-1) {
		color: var(--bs-dark);
		background-color: var(--bs-light);
	}

	.dblUnderlined {
		border-bottom: 3px double;
	}

	.overlay-exist-ac {
		position: absolute;
		display: none;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0,0,0,0.5);
		z-index: 4;
		cursor: auto;
		outline-color: rgba(0,0,0,0.5);
		outline-style: solid;
		outline-width: 1px;
	}
	
</style>

<div class="modal-content" id="modal-closeAC-content">

	@if( @$existing_close->count() > 0 )
		<script>
			var existing_close = @json($existing_close);
		</script>
		<!-- ส่วนสอบถาม จะแสดงก็ต่อเมื่อมีรายการบันทึกเก่า -->
		<div class="overlay-exist-ac d-flex flex-column justify-content-center align-items-center" id="overlay-existing-close">
			<h4 class="d-flex text-white">มีรายการบันทึกขอปิดบัญชีอยู่แล้ว</h4>
			<div class="mt-2 overflow-auto p-2" style="max-height: 15rem;">

				<?php
					$_CLA_today = strtotime("today midnight");
				?>
				@foreach( @$existing_close as $key => $value)
					<?php
						$_CLA_expireDate = strtotime( $value->EXPDATE );
						if( $_CLA_today > $_CLA_expireDate ) {
							$_CLA_expired = true;
						} else {
							$_CLA_expired = false;
						}
					?>
					<div class="bg-white rounded-3 hover-up shadow-lg">
						<div @class([
							'card bg-soft border mb-2 card-exisit-cla',
							'border-danger' => $_CLA_expired,
							])>
							<a href="javascript: void(0);" class="text-body exist-cla-load" data-indexcla="{{$loop->index}}">
								<div class="p-2">
									<div class="d-flex">
										<div class="avatar-xs align-self-center me-2">
											<div @class([
												'avatar-title rounded bg-transparent font-size-20',
												'text-primary' => !$_CLA_expired,
												'text-danger' => $_CLA_expired,
											])>
												<i class="bx bx-file"></i>
											</div>
										</div>
										<div class="overflow-hidden me-auto">
											<h5 class="font-size-14 fw-bolder mb-1">
												{{ formatDateThaiShort($value->created_at) }} 
												{{ displayTime($value->created_at) }} 
												@if($_CLA_expired)
													<small class='text-danger fw-bold'>เอกสารหมดอายุแล้ว</small>
												@endif
											</h5>
											<p class="text-muted mb-0 text-truncate">ผู้ทำรายการ {{ $value->UserInsert }}</p>
											<p class="text-muted mb-0 text-truncate">กำหนดชำระ <strong>{{ formatDateThaiShort($value->EXPDATE) }}</strong> รวมต้องชำระ <strong>{{ number_format($value->PAYAMT, 2) }}</strong> บาท</p>
										</div>
										<div class="ms-2">
											<p class="text-muted">{{ $value->AccCloseToBranch->NickName_Branch }}</p>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				@endforeach
				
			</div>

			<div class="row mt-2">
				<div class="col text-right">
					<button type="button" id="newAccClose_Btn" class="btn btn-warning btn-sm waves-effect waves-light w-sm textSize-13 hover-up">
						<span class="textSize-13"><i class="fas fa-file-medical"></i> สร้างใหม่</span>
					</button>
					<button type="button" class="btn btn-dark btn-sm waves-effect waves-light w-sm hover-up" data-bs-dismiss="modal"><i class="fas fa-share"></i> ปิด</button>
				</div>
			</div>
		</div>
	@endif

	<form name="form_closeAC" action="#" method="post" class="form-Validate needs-validation" enctype="multipart/form-data" id="form_closeAC">
	  @csrf
	  <input type="hidden" name="LastPayDT" id="LastPayDT" value="{{ (@$contract->LPAYD != NULL) ? @$contract->LPAYD : @$contract->SDATE }}"> <!-- วะนชำระล่าสุด -->

	  <div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/coins.gif') }}" alt="icon" class="avatar-sm">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">บันทึกขอปิดบัญชี</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">
				<button class="btn btn-sm btn-info" type="button" id="popover-document-info">
					<i class="mdi mdi-eye font-size-10"></i>
				</button> เลขที่เอกสาร : <span id="cla-docno">{{ @$docno }}</span><br>

				{{ var_dump(@$calCloseAC) }}

				<!-- เงินต้นคงเหลือ -->
				<input type="hidden" name="_balance" id="_balance" value="{{ @$calCloseAC->tonbalance }}"> 
				<!-- ดอกเบี้ยคงค้าง : ดอกเบี้ยที่เกิดจากการค้างแต่ละดิว -->
				<input type="hidden" name="_payintkang" id="_payintkang" value="{{ @$calCloseAC->payintkang }}"> 

				<!-- ดอกเบี้ยคงเหลือ : ดอกเบี้ยคงเหลือที่จะถูกนำมาคิดส่วนลด-->
				<input type="hidden" name="_intkangtotal" id="_intkangtotal" value="{{ @$calCloseAC->intkangtotal }}"> 
				
				<!-- ส่วนลดดอกเบี้ย -->
				<input type="hidden" name="_dscint" id="_dscint" value="{{ @$calCloseAC->dscint }}"> 
				<!-- ค้างค่าปรับ -->
				<input type="hidden" name="_int_late_amt" id="_int_late_amt" value="{{ @$calCloseAC->INTLATEAMT }}"> 
				<!-- ค้างค่าทวงถาม -->
				<input type="hidden" name="_letter" id="_letter" value="{{ @$calCloseAC->PAYFOLLOW }}"> 
				<!-- ค้างค่า ลูกหนี้อื่น (ค่าติดตาม) -->
				<input type="hidden" name="_tam" id="_tam" value=""> 
				<!-- ส่วนลดดอกเบี้ย % -->
				<input type="hidden" name="_dscpercen" id="_dscpercen" value="{{@$calCloseAC->dscpercen}}"> 

				<!-- โค้ดโลน 1 เงินกู้ 2 เช่าซื้อ -->
				<input type="hidden" name="codeloan" id="codeloan" value="{{@$contract->CODLOAN}}"> 

				<input type="hidden" name="patch_id" id="patch_id" value="{{@$contract->id}}">
				<input type="hidden" name="conttyp" id="conttyp" value="{{@$contract->CONTTYP}}">
				<input type="hidden" name="contno" id="contno" value="{{@$contract->CONTNO}}">
				<input type="hidden" name="contlocat" id="contlocat" value="{{@$contract->LOCAT}}">

				<!-- รวมต้องชำระ -->
				<input type="hidden" name="_summary" id="_summary" value="">
				<!-- รวมยอดค้าง -->
				<input type="hidden" name="_subTotal" id="_subTotal" value="">

				</p>
				<p class="border-primary border-bottom mt-n2"></p>
				{{-- var_dump($calCloseAC) --}}
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="mx-3">
			<div class="row">
				<div class="col-lg-6 col-12">
					<div class="row g-2 mb-1">
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="date" placeholder=" " value="{{ @$contract->SDATE }}" class="form-control text-end" required="" required readonly />
								<span>วันที่ทำสัญญา</span>
							</div>
						</div>
						<div class="col-6 my-2">
							<div class="input-bx">
								@if( @$contract->CODLOAN == 1 )     {{-- เงินกู้ --}}
									<input type="text" name="intlateday" id="intlateday" placeholder=" " value="{{ @$contract->CONTTYP == 3 ? 0 : '' }}" class="form-control text-end" required="" required readonly/>
									<span>วันคิดดอกเบี้ย</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">วัน</button>
								@elseif( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
									<input type="date" name="paylateday" id="paylateday" placeholder=" " value="{{ (@$contract->LPAYD != NULL) ? @$contract->LPAYD : @$contract->SDATE }}" class="form-control text-end" required="" readonly/>
									<span>วันชำระล่าสุด</span>
								@endif
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">
						<div class="col-4 my-2">
							<div class="input-bx">
								<input type="text" id="locat_cla" class="form-control" placeholder=" " value="{{ ($LOCAT->NickName_Branch != null)?$LOCAT->NickName_Branch : $LOCAT->Name_Branch }}" required="" readonly />
								<span>ผู้ทำรายการ</span>
							</div>
						</div>
						<div class="col-8 my-2">
							<div class="input-bx">
								<input type="text" id="userinsert_cla" class="form-control" value="{{ auth()->user()->name }}" readonly />
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">
						<div class="col-4 my-2">
							<div class="input-bx">
								<input type="text" name="PAYFOR_CODE" id="PAYFOR_CODE" value="{{ $_payfor->FORCODE }}" class="form-control" placeholder=" " required="" readonly />
								<span>ชำระค่า</span>
							</div>
						</div>
						<div class="col-8 my-2">
							<div class="input-bx">
								<input type="text" name="PAYFOR_NAME" id="PAYFOR_NAME" class="form-control" value="{{ $_payfor->FORDESC }}" readonly />
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">
						<div class="col my-2">
							<div class="input-bx">
								<select class="form-select text-danger fw-bold" name="speedBookFee_option" id="speedBookFee_option">
									<option value="N">ไม่ต้องการเร่งเล่ม</option>
									<option value="Y">ต้องการเร่งเล่ม</option>
								</select>
							</div>
						</div>
						<div class="col my-2" id="input_speedBookFee" style="display: none;">
							<div class="input-bx">
								<input type="text" name="speedBookFee_value" id="speedBookFee_value" class="form-control" placeholder=" " />
								<span>ค่าบริการเร่งเล่ม</span>
								<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">
						<div class="col-6 my-2">

							{{-- 
							<div class="input-bx">
								<input type="date" name="paymentDueDate" id="paymentDueDate" class="form-control border-danger" placeholder=" " required=""
									@if( $contract->CONTTYP == 3)
										readonly value="{{date('Y-m-d')}}"
									@endif />
								<span class="text-danger">กำหนดชำระถึงวันที่</span>
							</div>
							--}}

							<div class="input-bx">
								
								<input type="text" name="paymentDueDate" id="paymentDueDate"
									class="datepicker form-control rounded-0 rounded-start text-center border-danger" placeholder=" " autocomplete="off" required readonly
									@if( $contract->CONTTYP == 3)
										value="{{date('Y-m-d')}}"
									@endif  />
								<button class="btn btn-light rounded-0 rounded-end border-dark border-opacity-10 border-top-1 border-bottom-1 border-start-0 d-flex align-items-center openDatepickerBtn" type="button" @disabled( @$contract->CONTTYP == 3 )>
									<i class="fas fa-calendar-alt"></i>
								</button>
								<span class="text-danger floating-label">กำหนดชำระถึงวันที่</span>
							</div>

						</div>
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="text" name="discount_value" id="discount_value" class="form-control" placeholder=" " value="0" autocomplete="off" />
								<span class="">หักส่วนลดเพิ่ม</span>
								<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">
						<div class="col-md-12">
							<div class="form-floating">
								<textarea class="form-control" placeholder="Leave a comment here" name="Note_CloseAC" id="Note_CloseAC" maxlength="65535" style="height: 100px"></textarea>
								<label for="Note_CloseAC" class="fw-bold">หมายเหตุ</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">
					<h3 class="text-primary font-size-15 fw-bold">สรุปรายการ</h3>
					<div class="table-responsive">
						<table class="table table-nowrap table-sm">
							<tbody>
								<tr>
									<td></td>
									<td>ลูกหนี้คงเหลือ</td>
									<td class="text-end text-info" id="dp_balance"></td>
								</tr>
								@if(@$contract->CODLOAN==1) {{-- เฉพาะเงินกู้ แสดงดอกเบี้ยที่ลดแล้ว --}}
									<tr>
										<td></td>
										<td>ดอกเบี้ยคงค้าง</td>
										<td class="text-end text-info" id="dp_interest"></td>
									</tr>
									<tr>
										<td></td>
										<td>ดอกเบี้ยคงเหลือ</td>
										<td class="text-end text-info" id="dp_intkangtotal"></td>
									</tr>
								@endif
								<tr>
									<td></td>
									<td>ค้างค่าปรับ</td>
									<td class="text-end" id="dp_fine"></td>
								</tr>
								<tr>
									<td></td>
									<td>ค้างค่าทวงถาม</td>
									<td class="text-end" id="dp_letter"></td>
								</tr>
								<tr>
									<td></td>
									<td>ลูกหนี้อื่น</td>
									<td class="text-end" id="dp_trackingFee"></td>
								</tr>
								<tr id="tb_row_speedBookFee">
									<td></td>
									<td class="text-danger">ค่าบริการเร่งเล่ม</td>
									<td class="text-end" id="dp_speedBookFee"></td>
								</tr>
								<tr>
									<td colspan="2" class="text-end">ยอดรวมย่อย</td>
									<td class="text-end" id="dp_subTotal"></td>
								</tr>
								@if(@$contract->CODLOAN==2)
									<tr>
										<td colspan="2" class="border-0 text-end">
											<strong>ส่วนลดดอกเบี้ย</strong>
										</td>
										<td class="border-0 text-end text-success" id="dp_dscint"></td>
									</tr>
								@endif
								<tr id="tr_discount_value">
									<td colspan="2" class="border-0 text-end">
										<strong>หักส่วนลดเพิ่ม</strong>
									</td>
									<td class="border-0 text-end text-success" id="dp_discount"></td>
								</tr>
								<tr>
									<td colspan="2" class="border-0 text-end">
										<strong>รวมต้องชำระ</strong>
									</td>
									<td class="border-0 text-end text-danger">
										<h4 class="m-0 dblUnderlined" id="dp_summary"></h4>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- <h3 class="text-danger text-end font-size-15 fw-bold"><u>กำหนดชำระถึงวันที่ <span id="dp_paymentDueDate"></span></u></h3> -->
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col text-right">
					@if( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
						<button type="button" id="discountAC_btn" class="btn btn-info btn-sm waves-effect waves-light w-sm textSize-13 hover-up discountAC_btn" data-link="{{ route('payments.show', @$contract->id )}}?FlagBtn=discountAC&id={{@$contract->id}}&CODLOAN={{@$contract->CODLOAN}}&flagPage=create&payDueDT=" role="button" disabled>
							<span class="textSize-13 text-white"><i class="far fa-eye"></i> ส่วนลดปิดบัญชี <span class="addSpin"></span></span>
						</button>
					@endif
					<div class="btn-group">
						<button type="button" id="printDataAC_btn" class="btn btn-primary dropdown-toggle btn-sm waves-effect waves-light w-sm hover-up" data-bs-toggle="dropdown" aria-expanded="false" disabled>
							<i class="fa fa-print"></i> พิมพ์ <i class="mdi mdi-chevron-down"></i>
						</button>

						<a class="d-none" href="{{ route('report-backend.show', @$contract->id) }}?page=close-ac&CODLOAN={{ @$contract->CODLOAN }}&type=1" target="_blank" class="dropdown-item">ใบอนุมัติทางการเงิน</a>

						<div class="dropdown-menu">
							<a class="dropdown-item" href="#" id="print_dropdown_1" target="_blank">ใบอนุมัติทางการเงิน</a>
							<a class="dropdown-item" href="#" id="print_dropdown_2" target="_blank">Payin Slip</a>
						</div>
					</div>
					<button type="button" id="SaveDataAC_btn" class="btn btn-success btn-sm waves-effect waves-light w-sm textSize-13 hover-up SaveDataAC_btn">
						<span class="textSize-13 text-white"><i class="fas fa-download"></i> บันทึก <span class="addSpin"></span></span>
					</button>
					<button type="button" class="btn btn-secondary btn-sm waves-effect waves-light w-sm hover-up" data-bs-dismiss="modal"><i class="fas fa-share"></i> ปิด</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {

		$('#newAccClose_Btn').click(function() {
			$('.overlay-exist-ac').fadeOut( function() {
				$('.overlay-exist-ac').attr('style','display:none!important;')
			});
		});

		$('.SaveDataAC_btn').click(function() {
			var dataform = document.querySelectorAll('.needs-validation');
			var validate = validateForms(dataform);
			if (validate == true) {
				var type = 1;
				var _token = $('input[name="_token"]').val();
				var data = {};
				$("#form_closeAC").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('<span />', {
					class : "spinner-border spinner-border-sm",
					role : "status"
				}).appendTo("#SaveDataAC_btn.addSpin");
				$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
				
				$.ajax({
					url: "{{ route('payments.store') }}",
					method: "POST",
					data: {
						_token: '{{ csrf_token() }}',
						page: 'closeAC',
						data: data
					},
					complete: function() {
						$('#SaveDataAC_btn.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					success: function(result) {
						Swal.fire({
							icon: 'success',
							title: 'บันทึกสำเร็จ!',
							text: 'บันทึกสำเร็จแล้ว ในตอนนี้สามารถพิมพ์ได้',
							confirmButtonText: 'เข้าใจแล้ว',
						});
						$('#printDataAC_btn').prop('disabled', false);
						$('#SaveDataAC_btn').prop('disabled', true);
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

		function LoadExistingCLA(index) {
			$('#cla-docno').html( existing_close[index]['docno'] );
			
			// เงินต้นคงเหลือ
			$('#_balance').val( existing_close[index]['TOTBAL'] );

			// ดอกเบี้ยคงค้าง : ดอกเบี้ยที่เกิดจากการค้างแต่ละดิว
			$('#_payintkang').val( existing_close[index]['PROFBAL'] );
			
			// ดอกเบี้ยคงเหลือ : ดอกเบี้ยคงเหลือที่จะถูกนำมาคิดส่วนลด
			$('#_intkangtotal').val( existing_close[index]['INTKANGTOTAL'] );

			// ส่วนลดดอกเบี้ย
			$('#_dscint').val( existing_close[index]['DISCT'] );
			
			// ค้างค่าปรับ
			$('#_int_late_amt').val( existing_close[index]['KANGINT'] );

			// ค้างค่าทวงถาม
			$('#_letter').val( existing_close[index]['KANGFOLL'] );
			// ค้างค่า ลูกหนี้อื่น (ค่าติดตาม)
			$('#_tam').val( existing_close[index]['KANGOTH'] );

			// ส่วนลดดอกเบี้ย %
			$('#_dscpercen').val( existing_close[index]['DSCPERCEN'] );

			//$('#intlateday').val('');
			//$('#paylateday').val('');

			$('#locat_cla').val( existing_close[index]['LOCAT'] );
			$('#userinsert_cla').val( existing_close[index]['UserInsert'] );

			$('#PAYFOR_CODE').val( existing_close[index]['PAYFOR'] );
			//$('#PAYFOR_NAME').val('');

			$('#speedBookFee_option').val( existing_close[index]['HOTBOOK'] );
			refreshSpeedBookFee();
			$('#speedBookFee_value').val( existing_close[index]['EXPRESSAMT'] );

			$('#paymentDueDate').val( existing_close[index]['EXPDATE'] );

			
		}

		$('.card-exisit-cla a').click(function() {
			console.log( "indexcla: " + $(this).data('indexcla') );
			LoadExistingCLA( $(this).data('indexcla') )
			//console.log( existing_close[ $(this).data('indexcla') ] );

			var claid = existing_close[ $(this).data('indexcla') ]['id']
			console.log( "claid: " + claid );

			var href_original = "{{ route('report-backend.show', 'claid') }}?page=close-ac&CODLOAN={{ @$contract->CODLOAN }}&type=typrint"
			var href_t1 = href_original.replace('claid', claid).replace('typrint', 'approve')
			var href_t2 = href_original.replace('claid', claid).replace('typrint', 'payment')

			$('#printDataAC_btn').prop('disabled', false);
			$('#SaveDataAC_btn').prop('disabled', true);

			$('#print_dropdown_1').attr("href", href_t1);
			$('#print_dropdown_2').attr("href", href_t2);
			
			$('.overlay-exist-ac').fadeOut( function() {
				$('.overlay-exist-ac').attr('style','display:none!important;')
			});

		});

	});
</script>


<script>
	$(document).ready(function() {
		$('#paymentDueDate').datepicker({
			//format: 'dd/mm/yyyy',
			format: {
				/*
				* Say our UI should display a week ahead,
				* but textbox should store the actual date.
				* This is useful if we need UI to select local dates,
				* but store in UTC
				*/
				toDisplay: function (date, format, language) {
					/*
					console.log( "to Display" );
					var d = new Date(date);
					return d.toLocaleDateString('th-TH', {year: "numeric", month: "2-digit", day: "2-digit" });
					*/
					var d = new Date(date)
					var year = d.getFullYear()
					var month = `${d.getMonth() + 1}`.padStart(2, "0")
					var day = `${d.getDate()}`.padStart(2, "0")
					return [day, month, year].join("/");
				},
				toValue: function (date, format, language) {
					// แยกวันที่, เดือน, และปีออกจากสตริง
					var parts = date.split('/');
					var day = parseInt(parts[0], 10);
					var month = parseInt(parts[1] - 1, 10); // เดือนจะถูกลบออก 1 เนื่องจากมันเริ่มต้นที่ 0 (มกราคม)
					var year = parseInt(parts[2], 10);
					if (year >= 2500) year -= 543;
					// สร้างวัตถุ Date
					var date = new Date(year, month, day);
					// ตรวจสอบว่าวัตถุ Date ถูกสร้างขึ้นอย่างถูกต้อง
					if (isNaN(date.getTime())) {
						return null; // วันที่ไม่ถูกต้อง
					}
					return date;
				}
			},
			container: '#modal-closeAC-content',
			autoclose: true,
			language: 'th',
			todayHighlight: true,
			enableOnReadonly: {{ (@$contract->CONTTYP == 3) ? false : true }},
			clearBtn: true,
			toggleTooltip: true,
			tooltipPlacement: 'top',
			disableTouchKeyboard: true,
			startDate: '{{ (@$contract->LPAYD != NULL) ? convertDatePHPToHuman(@$contract->LPAYD) : convertDatePHPToHuman(@$contract->SDATE) }}',
		}).on('changeDate', function(e) {
			console.log(e.date);
			if ( e.date !== "undefined" ) {
				$("#dp_paymentDueDate").html(e.date.toLocaleString('th-TH', {
					dateStyle: 'long'
				}));
				$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: "{{ route('payments.create') }}",
					type: 'GET',
					data: {
						id: '{{ $contract->id }}',
						funs: 'closeAC',
						flag: 'ajax',
						_token: '{{ @csrf_token() }}',
						codloan: '{{ $contract->CODLOAN }}',
						conttyp: '{{ $contract->CONTTYP }}',
						contno: '{{ $contract->CONTNO }}',
						locat: '{{ $contract->LOCAT }}',
						dateDuePay: $("#paymentDueDate").val()
					},
					complete: function() {
						$('.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					success: function(response) {
						//console.log('success');
						//console.log(response);
						$("#_balance").val( response['tonbalance'] ); // เงินต้นคงเหลือ
						$("#_payintkang").val( response['payintkang'] ); // ดอกเบี้ยคงค้าง
						$("#_int_late_amt").val( response['INTLATEAMT'] ); // ค้างค่าปรับ
						@if( @$contract->CODLOAN == 1 ) {{-- เงินกู้ --}}
							$("#intlateday").val( response['intlateday'] ); // จำนวนวันคิดดอก
							$("#_intkangtotal").val( response['intkangtotal'] ); // ดอกเบี้ยคงเหลือ
						@endif
						@if( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
							$("#_dscint").val( response['dscint'] ); // ส่วนลดดอกเบี้ย
							$("#discountAC_btn").prop('disabled', false);
							$('.addSpin').html('')
						@endif
						updateSummary();
						//-----------------------------------------------------------------------------------------
						@if( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
							// อัพเดต URL ของปุ่มดูส่วนลดปิดบัญชี (เติมวันที่เข้าไปใน input)
							var url = $("#discountAC_btn").data('link');
							var valueToAdd = $("#paymentDueDate").val();
							if (url.includes('payDueDT=')) {
								// If the parameter exists, replace its value with the new one
								url = url.replace(/payDueDT=([^&]*)/, 'payDueDT=' + encodeURIComponent(valueToAdd));
							} else {
								url += encodeURIComponent('&payDueDT=' + valueToAdd);
							}
							$("#discountAC_btn").attr('data-link', url);
						@endif
						//-----------------------------------------------------------------------------------------
						$('.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
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
				});
			}
		});

		$(".openDatepickerBtn").on('click', function() {
			//$(this).siblings('input').focus();
			$('#paymentDueDate').datepicker('show');
		});
	});

	
	
</script>


<script>

	
	/*
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})
	*/

	/*
	[].slice.call($('[data-bs-toggle="popover"]')).map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})
	*/

	var popover = new bootstrap.Popover($('#popover-document-info'), {
		placement: 'bottom',
		fallbackPlacements: ['top', 'right'],
		html: true,
		trigger: 'hover',
		customClass: 'shadow-lg border-info',
		template: '<div class="popover" role="tooltip"><div class="popover-arrow contract-info-arrow"></div><h3 class="popover-header fw-bold text-center"></h3><div class="popover-body font-size-12 p-2"></div></div>',
		title: 'ข้อมูลเอกสาร',
		content: `
		<div class="row px-2">
			<div class="col-5 fw-bold content-info-row">รหัสสาขา:</div>
			<div class="col-7 text-end content-info-row">{{ ($LOCAT->NickName_Branch != null)?$LOCAT->NickName_Branch : $LOCAT->Name_Branch }}</div>
			<div class="col-5 fw-bold content-info-row">เลขที่เอกสาร:</div>
			<div class="col-7 text-end content-info-row">{{ @$docno }}</div>
			<div class="col-5 fw-bold content-info-row">วันที่เอกสาร:</div>
			<div class="col-7 text-end content-info-row">{{ date('Y-m-d') }}</div>
		</div>`
	})

	/*
	var _content_contract = `
		<div class="row">
			<div class="col-5 fw-bold content-info-row">เลขที่สัญญา:</div>
			<div class="col-7 text-end content-info-row">{{ @$contract->PatchToPact->Contract_Con }}</div>

			<div class="col-5 fw-bold content-info-row">เลขตัวถัง:</div>
			<div class="col-7 text-end content-info-row">MRO53ZEC10704008</div>
			
			<div class="col-5 fw-bold content-info-row">เลขทะเบียน:</div>
			<div class="col-7 text-end content-info-row">กน-974</div>
			
			<div class="col-5 fw-bold content-info-row">ทีมตาม:</div>
			<div class="col-7 text-end content-info-row">TOME</div>
			
			<div class="col-5 fw-bold content-info-row">ยอดเงินกู้:</div>
			<div class="col-7 text-end content-info-row">100,000.00 บาท</div>
			
			<div class="col-5 fw-bold content-info-row">ชำระเงินต้น:</div>
			<div class="col-7 text-end content-info-row">14,334.50 บาท</div>
			
			<div class="col-5 fw-bold content-info-row">เงินต้นคงเหลือ:</div>
			<div class="col-7 text-end content-info-row">85,665.50 บาท</div>
			
			<div class="col-5 fw-bold content-info-row">ชำระดอกเบี้ย:</div>
			<div class="col-7 text-end content-info-row">10,601.50 บาท</div>
		</div>
	`;

	var popover = new bootstrap.Popover($('#popover-contract-info'), {
		placement: 'right',
		fallbackPlacements: ['top', 'right'],
		html: true,
		trigger: 'hover',
		customClass: 'shadow-lg border-info',
		template: '<div class="popover" role="tooltip"><div class="popover-arrow contract-info-arrow"></div><h3 class="popover-header fw-bold text-center"></h3><div class="popover-body font-size-12"></div></div>',
		title: "ข้อมูลสัญญา",
		content: _content_contract
	})
	*/

	function refreshSpeedBookFee() {
		if ($("#speedBookFee_option").val() == "Y") {
			// ต้องการเร่งเล่ม
			document.getElementById("speedBookFee_value").required = true;
			$("#speedBookFee_value").val(null);
			$("#input_speedBookFee").show(300);
		} else {
			// ไม่ต้องการเร่งเล่ม
			document.getElementById("speedBookFee_value").required = false;
			$("#speedBookFee_value").val(null);
			$("#input_speedBookFee").hide(300);
		}
	}

	refreshSpeedBookFee();

	function updateSummary() {
		let balance; // เงินต้นคงเหลือ
		let interest; // ดอกเบี้ยคงค้าง
		let intkangtotal; // ดอกเบี้ยคงเหลือ
		let fine; // ค่าปรับ
		let trackingFee = 0; // ค่าคิดตาม

		if ($("#_balance").val() != '') {
			balance = Number($("#_balance").val());
		} else {
			balance = 0;
		}
		if ($("#_payintkang").val() != '') {
			interest = Number($("#_payintkang").val());
		} else {
			interest = 0;
		}
		if ($("#_intkangtotal").val() != '') {
			intkangtotal = Number($("#_intkangtotal").val());
		} else {
			intkangtotal = 0;
		}
		if ($("#_int_late_amt").val() != '') {
			fine = Number($("#_int_late_amt").val());
		} else {
			fine = 0;
		}
		if ($("#_letter").val() != '') {
			letter = Number($("#_letter").val());
		} else {
			letter = 0;
		}
		if($('#_dscint').val()!=''){
			dscint = Number($("#_dscint").val());
		} else {
			dscint = 0;
		}
		if($('#_dscpercen').val()!=''){
			dscpercen = Number($("#_dscpercen").val());
		} else {
			dscpercen = 0;
		}
		var codeloan = $('#codeloan').val();
		
		
		var intrate = 0;
		if(codeloan==1){
			intrate = interest;
		}
		

		let speedBookFee = Number( $("#speedBookFee_value").val() );
		let discount = Number( $("#discount_value").val() );

		let subTotal = ( balance + fine + trackingFee + speedBookFee + letter ) + intrate;
		let summary = subTotal - dscint - discount;

		const nf = new Intl.NumberFormat("th-TH", {
			//style: "currency",
			//currency: "THB",
			//currencyDisplay: "name",
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
		const thb_currency = " บาท";

		$("#dp_balance").html(nf.format(balance) + thb_currency);
		$("#dp_interest").html(nf.format(interest) + thb_currency);	
		$("#dp_intkangtotal").html(nf.format(intkangtotal) + thb_currency);		
		$("#dp_dscint").html(nf.format(dscint*-1) + thb_currency);
		$("#dp_fine").html(nf.format(fine) + thb_currency);
		$("#dp_letter").html(nf.format(letter) + thb_currency);
		$("#dp_trackingFee").html(nf.format(trackingFee) + thb_currency);
		if (speedBookFee > 0) {
			$("#dp_speedBookFee").html(nf.format(speedBookFee) + thb_currency);
			$("#tb_row_speedBookFee").show();
		} else {
			$("#dp_speedBookFee").html('');
			$("#tb_row_speedBookFee").hide();
		}
		$("#dp_subTotal").html(nf.format(subTotal) + thb_currency);
		if (discount != 0) {
			$("#dp_discount").html(nf.format(discount*-1) + thb_currency);
			$('#tr_discount_value').show();
		} else {
			$("#dp_discount").html('');
			$('#tr_discount_value').hide();
		}
		$("#dp_summary").html(nf.format(summary) + thb_currency);
		//---------------------------------------------------------------------------
		$('#_subTotal').val(subTotal)
		$('#_summary').val(summary)
		//---------------------------------------------------------------------------
	}

	updateSummary()

	$("#speedBookFee_option").change(function() {
		refreshSpeedBookFee();
		updateSummary();
	});

	$("#speedBookFee_value,#discount_value").on("input", function() {
		updateSummary();
	});

</script>

<script>
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

	$('[data-bs-toggle="tooltip"]').tooltip();
	
</script>
