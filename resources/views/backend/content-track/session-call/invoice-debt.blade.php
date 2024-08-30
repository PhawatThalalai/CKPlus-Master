<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<div class="modal-content">
    <div class="modal-header" id="Modal-drag" style="cursor:move;">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h4 class="text-primary fw-semibold placeholder-glow d-block d-sm-none">ใบแจ้งหนี้</h4>
            <h4 class="text-primary fw-semibold placeholder-glow d-none d-sm-block">ออกใบแจ้งหนี้</h4>
            <!-- <p class="text-muted mt-n1 placeholder-glow">{{@$runBill}}</p> -->
        </div>
        <button id="download" class="btn btn-primary">บันทึกรูป</button>
        <button type="button" class="btn btn-danger closeModal ms-1" title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
            ปิด
        </button>
    </div>
    <div class="modal-body">
            
        <form id="form-invoice" class="mt-n2">
            <input type="hidden" name="DataCus_id" id="DataCus_id">
            <input type="hidden" name="page" value="save-invoice">
            <input type="hidden" name="dateNow" id="dateNow" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="IDAROTH" id="AROTHR" value="{{@$data["data"]->IDAROTH}}">
            <input type="hidden" name="EXP_FRM" id="EXP_FRM" >
            <input type="hidden" name="EXP_TO" id="EXP_TO" >
            <input type="hidden" name="DOCDATE" id="DOCDATE" value="{{ @$data["data"]->DOCDATE }}" placeholder="วันที่สร้างบิล" alt="วันที่สร้างบิล">
            <input type="hidden" name="TOTALPAYMENTS" id="TOTALPAYMENTS" value="{{ @$data["data"]->TOTALPAYMENTS }}" placeholder="ยอดที่ต้องชำระ" alt="ยอดที่ต้องชำระ">
            <input type="hidden" name="PERIODDEBT" id="PERIODDEBT" value="{{ @$data["data"]->PERIODDEBT }}" placeholder="ยอดจาก Seaech" alt="ยอดจาก Seaech">
            <input type="hidden" name="INTLATEAMT" id="INTLATEAMT" value="{{ @$data["data"]->INTLATEAMT }}" placeholder="ค้างเบี้ยปรับ"  alt="ค้างเบี้ยปรับ">
            <input type="hidden" name="FOLLOWAMT" id="FOLLOWAMT" value="{{ @$data["data"]->FOLLOWAMT }}" placeholder="ค้างค่าทวงถาม" alt="ค้างค่าทวงถาม">
            <input type="hidden" name="DEBTOTH" id="DEBTOTH" value="{{ @$data["data"]->TOTOTH }}" placeholder="ลูกหนี้อื่น" alt="ลูกหนี้อื่น">
            <input type="hidden" value="0" name="DSCINT" id="DSCINT" value="{{ @$data["data"]->DSCINT }}" placeholder="ส่วนลดเบี้ยปรับ" alt="ส่วนลดเบี้ยปรับ">
            <input type="hidden" value="0" name="DSCPAYFL" id="DSCPAYFL" value="{{ @$data["data"]->DSCPAYFL }}" placeholder="ส่วนลดค่าทวงถาม" alt="ส่วนลดค่าทวงถาม">
            <input type="hidden" name="B_INTAMT" id="B_INTAMT" value="{{ @$data["data"]->B_INTAMT }}" placeholder="เบี้ยปรับ" alt="เบี้ยปรับ">
            <input type="hidden" name="PAYFOLLOW" id="PAYFOLLOW" value="{{ @$data["data"]->PAYFOLLOW }}" placeholder="ค่าทวงถาม" alt="ค่าทวงถาม">
            <input type="hidden" name="TOTBLCOTH" id="TOTBLCOTH" value="{{ @$data["data"]->TOTBLC }}" placeholder="ยอดหลังหักลูกหนี้อื่น" alt="ยอดหลังหักลูกหนี้อื่น">
            <input type="hidden" name="PAYAMT" id="PAYAMT" value="{{ @$data["data"]->PAYAMT }}" placeholder="ยอดหลังหักค่าปรับและค่าทวงถาม" alt="ยอดหลังหักค่าปรับและค่าทวงถาม">
            <input type="hidden" name="OUTSBL" id="OUTSBL" value="{{ @$data["data"]->OUTSBL }}" placeholder="เงินค้างงวด" alt="เงินค้างงวด">
            <input type="hidden" id="deleted_at" value="{{ @$data["data"]->deleted_at }}" placeholder="deleted_at" alt="deleted_at">
            <input type="hidden" id="STATUSPAY" value="{{ @$data["data"]->STATUSPAY }}" placeholder="STATUSPAY" alt="STATUSPAY">
            <input type="hidden" name ="CAPITALBLVAL" id="CAPITALBLVAL" value="{{ @$data["data"]->CAPITALBLVAL }}" placeholder="CAPITALBLVAL" alt="CAPITALBLVAL">
            <div class="row mb-2 d-flex justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 float-end">
                    <div class="row g-1">
                        <div class="col-9">
                            <div class="input-bx">
                                <input type="date" name="DATENOPAY" id="DATENOPAY" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="form-control" required placeholder=" " />
                            </div>
                        </div>
                        <div class="col-3 d-grid">
                            <button type="button" class="btn btn-info btn_date">
                                <span class="d-block d-sm-none"><i class="bx bx-search-alt-2 icon-dateSearch bx-tada"></i></span>
                                <span class="d-none d-sm-block"><span class="number">ค้นหา <i class="bx bx-search-alt-2 icon-dateSearch bx-tada"></i><span class="spinner-border spinner-border-sm spinner-dateSearch" style="display: none;"></span></span></span> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form id = "dataContract">
            <input type="hidden" value="{{ @$data->CODLOAN ?? @$contract->CODLOAN}}" name="CODLOAN" id="CODLOAN" class="CODLOAN">
            <input type="hidden" value="{{ @$data->PactCon_id ?? @$contract->DataPact_id}}" name="PactCon_id" id="PactCon_id">
            <input type="hidden" value="{{ @$data->PatchCon_id ?? @$contract->id }}" id="PatchCon_id" name="PatchCon_id">
            <input type="hidden" value="{{ @$data->LOCAT ?? @$contract->LOCAT }}" name="LOCAT">
            <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
        </form>

        @php 
            $dataComp = \App\Models\TB_Constants\TB_Frontend\TB_Company::where('Company_Zone', $contract->UserZone)->where('id', $contract->Id_Com)->first();
            @$Address = @$contract->PactToCus->DataCusToDataCusAdds;
            @$Asset = @$contract->PactToCus->DataCusToDataAssetOne;
        @endphp

        @php 
            @$Guarantor1 = @$contract->PatchToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus;
            @$GuarantorAdds1 = @$Guarantor1->DataCusToDataCusAdds;
            @$Guarantor2 = @$contract->PatchToPact->ContractToGuarantor[1]->GuarantorToGuarantorCus;
            @$GuarantorAdds2 = @$Guarantor2->DataCusToDataCusAdds;
        @endphp
            
        <div class="row mt-n2">
            <div class="col-xl-12">
                <!-- <div class="card"> -->
                    <!-- <div class="card-header text-center"><h4 class="card-title">ใบแจ้งหนี้</h4></div> -->
                    <div class="card-body">
                        <div id="capture" class="p-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <address>
                                        <strong>{{@$dataComp->Company_Name}}</strong><br>
                                    </address>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <address>
                                        <strong>วันที่พิมพ์ :</strong> {{formatDateThaiShort_monthNum(date('dd-m-Y'))}}<br>
                                        <!-- <small>{{date('H:i:s')}}</small> -->
                                    </address>
                                </div>
                                <div class="table-responsive mt-n3">
                                    <table class="table table-borderless table-sm table-nowrap">
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;"><b>ประวัติผู้เช่าซื้อ</b></td>
                                            <td>{{@$contract->CONTNO}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>ชื่อ-สกุล</td>
                                            <td>{{@$contract->PactToCus->Name_Cus}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>ที่อยู่</td>
                                            <td>{{@$Address->houseNumber_Adds}} {{@$Address->houseGroup_Adds}} ต. {{@$Address->houseTambon_Adds}} อ. {{@$Address->houseDistrict_Adds}} จ. {{@$Address->houseProvince_Adds}} {{@$Address->Postal_Adds}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>เบอร์โทร</td>
                                            <td>{{@$contract->PatchToPact->ContractToCus->Phone_cus}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>ที่ทำงาน</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <address>
                                        <strong>&nbsp;&nbsp;&nbsp;ผู้ค้ำประกัน</strong><br>
                                    </address>
                                </div>
                                <div class="table-responsive mt-n3">
                                    <table class="table table-borderless table-sm table-nowrap">
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">ชื่อ-สกุล</td>
                                            <td>{{@$Guarantor1->Name_Cus}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>ที่อยู่</td>
                                            <td>{{@$GuarantorAdds1->houseNumber_Adds}} {{@$GuarantorAdds1->houseGroup_Adds}} {{@$GuarantorAdds1->village_Adds}} ต.{{@$GuarantorAdds1->houseTambon_Adds}} อ.{{@$GuarantorAdds1->houseDistrict_Adds}} จ.{{@$GuarantorAdds1->houseProvince_Adds}} {{@$GuarantorAdds1->Postal_Adds}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>เบอร์โทร</td>
                                            <td>{{@$Guarantor1->Phone_cus}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>ที่ทำงาน</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <address>
                                        <strong>&nbsp;&nbsp;&nbsp;รายละเอียดรถ</strong><br>
                                    </address>
                                </div>
                                <div class="table-responsive mt-n3">
                                    <table class="table table-borderless table-sm table-nowrap">
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">ยี่ห้อ</td>
                                            <td>{{@$Asset->AssetToCarBrand->Brand_car}}</td>
                                            <td style="width: 70px;">แบบ</td>
                                            <td>{{@$Asset->AssetToCarGroup->Group_car}}</td>
                                            <td style="width: 70px;"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">สี</td>
                                            <td>{{@$Asset->Vehicle_Color}}</td>
                                            <td style="width: 70px;">หมายเลขตัวถัง</td>
                                            <td>{{(@$Asset->Vehicle_NewChassis != NULL)?@$Asset->Vehicle_NewChassis:@$Asset->Vehicle_Chassis}}</td>
                                            <td style="width: 70px;">หมายเลขเครื่อง</td>
                                            <td>{{@$Asset->Vehicle_Engine}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">ทะเบียน</td>
                                            <td>{{(@$Asset->Vehicle_NewLicense != NULL)?@$Asset->Vehicle_NewLicense:@$Asset->Vehicle_OldLicense}}</td>
                                            <td style="width: 70px;"></td>
                                            <td></td>
                                            <td style="width: 70px;"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <address>
                                        <strong>&nbsp;&nbsp;&nbsp;รายละเอียดสัญญา</strong><br>
                                    </address>
                                </div>
                                <div class="table-responsive mt-n3">
                                    <table class="table table-borderless table-sm table-nowrap">
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">วันที่ทำสัญญา</td>
                                            <td>{{formatDateThaiShort_monthNum(@$contract->SDATE)}}</td>
                                            <td style="width: 70px;">จำนวนงวด</td>
                                            <td>{{number_format(@$contract->T_NOPAY,0)}}</td>
                                            <td style="width: 70px;">ผ่อนงวดละ</td>
                                            <td>{{number_format(@$contract->TOT_UPAY,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">วันที่ผ่อนงวดแรก</td>
                                            <td>{{formatDateThaiShort_monthNum(@$contract->FDATE)}}</td>
                                            <td style="width: 70px;">ชำระแล้ว</td>
                                            <td>{{number_format(@$contract->SMPAY,2)}}</td>
                                            <td style="width: 70px;">คงค้างงวด</td>
                                            <td>{{@$contract->HLDNO}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5px;"></td>
                                            <td style="width: 70px;">วันที่ผ่อนงวดสุดท้าย</td>
                                            <td>{{formatDateThaiShort_monthNum(@$contract->LDATE)}}</td>
                                            <td style="width: 70px;">งวดที่</td>
                                            <td>{{number_format(@$contract->EXP_FRM,0)}}</td>
                                            <td style="width: 70px;">ถึงงวดที่</td>
                                            <td>{{number_format(@$contract->EXP_TO,0)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm border border-warning">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-sm table-nowrap">
                                                    <tr>
                                                        <td style="width: 15px;"></td>
                                                        <td style="width: 70px;"></td>
                                                        <td class="text-white"><span id="fs-6">  </span></td>
                                                        <td style="width: 70px;">ยอดเงินคงค้าง</td>
                                                        <!-- <td>{{(@$contract->EXP_AMT > 0)?number_format(@$contract->EXP_AMT,0):'0.00'}}</td> -->
                                                        <td class="OutstandingBalance">{{ @$data['data']->OUTSBL ?? 0.00 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 15px;"></td>
                                                        <td style="width: 70px;">วันที่ชำระล่าสุด</td>
                                                        <td>{{formatDateThaiShort_monthNum(@$contract->LPAYD)}}</td>
                                                        <td style="width: 70px;">เบี้ยปรับ</td>
                                                        <td><span class="INTLATEAMT fs-6"> {{ @$data['data']->INTLATEAMT ?? 0.00 }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 51px;"></td>
                                                        <td style="width: 70px;">จำนวนเงินชำระล่าสุด</td>
                                                        <td>{{number_format(@$contract->LPAYA,0)}}</td>
                                                        <td style="width: 70px;">ค่าทวงถาม</td>
                                                        <td class="FOLLOWAMT border-bottom">{{ @$data['data']->FOLLOWAMT ?? 0.00 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 5px;"></td>
                                                        <td style="width: 70px;">ลูกหนี้คงเหลือ</td>
                                                        <td>{{number_format(@$contract->BALANC - @$contract->SMPAY,0)}}</td>
                                                        <td style="width: 70px;">ค่าผิดสัญญา</td>
                                                        <td class="border-bottom"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 5px;"></td>
                                                        <td style="width: 70px;"></td>
                                                        <td></td>
                                                        <td style="width: 70px;">รวมยอด</td>
                                                        <td class="border-bottom"><span id="TOTALPAYMENT">{{ @$data['data']->TOTALPAYMENTS ?? 0.00 }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 5px;"></td>
                                                        <td style="width: 70px;"></td>
                                                        <td></td>
                                                        <td style="width: 70px;">ยอดขั้นต่ำ</td>
                                                        <td class="border-bottom">{{number_format(@$contract->ContractToSPASTDUE->MinPay,0)}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <span>* หมายเหตุ : ยอดชำระในใบแจ้งหนี้ ต้องชำระภายในวันเท่านั้น อื่นๆ กรุณาติดต่อสาขาที่ท่านสมัครสินเชื่อ</span>
                        </div>
                    </div>
                <!-- </div> -->
            </div><!--end col-->
        </div>
    </div>
</div>

{{-- search date --}}
<script>
	$('.btn_date').click(() => {
		let datepay = $('#DATENOPAY').val();
		let id = $('#PatchCon_id').val();
		let CODLOAN = $('.CODLOAN').val();
		SSdateNopay = sessionStorage.setItem('dateNopay', datepay);
		if (datepay == '') {
			$('#DATENOPAY').addClass('border border-2 border-danger text-danger')
			swal.fire({
				icon: 'warning',
				title: 'ไม่มีวันที่ค้นหา !',
				text: 'กรุณาเลือกวันที่ก่อนทำการค้นหา',
			})
		} else {
			$('#DATENOPAY').removeClass('border border-2 border-danger text-danger')
			$('.icon-dateSearch').toggle()
			$('.spinner-dateSearch').toggle()
			$('.btn_date').prop('disabled', true)

			$.ajax({
				url: "{{ route('payments.create') }}",
				type: 'GET',
				data: {
					funs: 'OVRDUE',
					CODLOAN: CODLOAN,
					date: datepay,
					id: id,
					flag: 'search-datedue',
					_token: '{{ @csrf_token() }}',

				},
				success: (res) => {
					$('#btn-print').show();
					$('.btn_date').prop('disabled', false)
					$('#form-invoice input[type="text"],input[type="number"],.btn-blocked').prop('disabled', false)
					$('#formStyle').removeClass('opacity-50');
					$('.icon-dateSearch').toggle();
					$('.spinner-dateSearch').toggle();

					// ---- constant ----

					// TOTALPAYMENT = ((parseFloat(res['peroid'][0].PAYMENT) + parseFloat(res['peroid'][0].INTLATEAMT - parseFloat(res.payint.PAYINT))) + parseFloat(res.arth.PAYAMT) );
					TOTALPAYMENT = (
						(
							(
								parseFloat(res['peroid'][0].PAYMENT) +
								parseFloat(res['peroid'][0].PAYFOLLOW) +
								parseFloat(res['peroid'][0].INTLATEAMT ?? 0) -
								parseFloat(res.payint.PAYINT ?? 0)
							) +
							parseFloat(res.arth.BALANCE ?? 0)
						)
					);
					TOTLAPAY = parseFloat(TOTALPAYMENT ?? 0)
					DEBTOTH = parseFloat(res.arth.BALANCE ?? 0)

					// ---- Assign Value ----

					$('#TOTALPAYMENT').html(( TOTLAPAY ).toLocaleString('th-TH')) // ยอดที่ต้องชำระ
					$('#CAPITALBL').html(addCommas(res.dataPatch.BALANC)); // ยอดทั้งหมด
					$('#CAPITALBLVAL').val(res.dataPatch.BALANC); // ยอดทั้งหมด
                    $(".DISCCloseAC").val(res.calCloseAC.dscint)
                    $('#ShowDISCCloseAC').html(addCommas(res.calCloseAC.dscint))

					$('.OutstandingBalance').html(addCommas(res['peroid'][0].PAYMENT)); // เงินค้างงวด
					$('#OUTSBL').val(res['peroid'][0].PAYMENT) // เงินค้างงวด
					$('.INTLATEAMT').html(addCommas(res['peroid'][0].INTLATEAMT - res.payint.PAYINT)); // แสดงค้างเบี้ยปรับ
					$('#INTLATEAMT,#B_INTAMT').val(res['peroid'][0].INTLATEAMT - res.payint.PAYINT) // ค้างเบี้ยปรับ
					$('.FOLLOWAMT').html(addCommas(parseFloat(res['peroid'][0].PAYFOLLOW))) // แสดงค่าทวงถาม
					$('#FOLLOWAMT,#PAYFOLLOW').val(res['peroid'][0].PAYFOLLOW) // ค่าทวงถาม


					$('.DEBTOTH').html(addCommas(DEBTOTH)); // ลูกหนี้อื่น
					$('#DEBTOTH').val(DEBTOTH) // ลูกหนี้อื่น

					$('#TOTALPAYMENTS,#PERIODDEBT').val(TOTLAPAY)
					$('#DISCAROTH').val(res.arth.DISCOUNT)
					$('#DOCDATE').val(res.docDate)

				},
				error: () => {
					$('.icon-dateSearch').toggle()
					$('.spinner-dateSearch').toggle()
					$('.btn_date,#btn-saveInvoice').prop('disabled', false)
				}
			})
		}
	})
</script>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script>
    document.getElementById("download").addEventListener("click", function() {
        html2canvas(document.getElementById("capture")).then(canvas => {
            // Convert the canvas to a data URL
            let imgData = canvas.toDataURL("image/png");

            // Create a link element
            let link = document.createElement('a');

            // Set the download attribute with a filename
            link.download = 'div_image.png';

            // Set the href attribute to the data URL
            link.href = imgData;

            // Append the link to the body
            document.body.appendChild(link);

            // Programmatically click the link to trigger the download
            link.click();

            // Remove the link from the document
            document.body.removeChild(link);
        });
    });
</script>