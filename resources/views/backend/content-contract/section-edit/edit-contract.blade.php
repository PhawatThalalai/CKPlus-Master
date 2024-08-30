<!-- Modal Content -->
<form id="edit_contract" class="modal-content needs-validation" action="#" novalidate>
    @csrf
    <input type="hidden" name="page" id="page" value="viewContract">
    <input type="hidden" name="funs" value="edit">
    {{-- <input type="hidden" name="id" value="{{@$contract->id}}"> --}}
    <input type="hidden" name="id" value="{{@$pact->id}}">

    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/edit.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">เปลี่ยนแปลงสถานะสัญญา ( Edit Contract )</h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">เลขที่สัญญา {{@$pact->Contract_Con}}</p>
            <p class="border-primary border-bottom mt-n2 m-2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-0">
        <div class="row mx-2">
            <div class="col-xl-4 col-12 p-1">
                <fieldset class="reset border-1 border-primary border-opacity-25 rounded-3">
                    <legend class="reset"><h6 class="text-primary fw-semibold mb-3"><i class="mdi mdi-finance fs-4"></i> ข้อมูลดอกเบี้ย</h6></legend>
                    <div class="row g-2">
                        <div class="col-xl-6 col-lg-4 col-6 mb-xl-3 mb-lg-2">
                            <div class="input-bx">
                                <input type="text" name="INTLATE" id="INTLATE" class="form-control text-end" placeholder=" " value="{{ number_format(@$contract->INTLATE, 2) }}" required/>
                                <span class="text-danger">เบี้ยปรับต่อเดือน</span>
                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-6 mb-xl-3 mb-lg-1">
                            <div class="input-bx">
                                <input type="text" name="DLDAY" id="DLDAY" class="form-control text-end" placeholder=" " value="{{@$contract->DLDAY}}" required/>
                                <span class="text-danger">วันล่าช้า</span>
                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">วัน</button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-6 mb-xl-3 mb-lg-1">
                            <div class="input-bx">
                                <input type="text" name="VATRT" id="VATRT" class="form-control text-end" placeholder=" " value="{{number_format(@$contract->VATRT,2)}}" @required(@$contract->CODLOAN == 2) @readonly(@$contract->CONTTYP != 2)/>
                                <span class="text-danger">ภาษี</span>
                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4 col-6 mb-xl-3 mb-lg-1">
                            <div class="input-bx">
                                <input type="text" name="MAXINT" id="MAXINT" class="form-control text-end" placeholder=" " value="24" readonly/>
                                <span>ดอกเบี้ยต่อปี</span>
                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-8 col-6 mb-xl-3 mb-lg-1">
                            <span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">วิธีคำนวณส่วนลดตัดสด</span>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault1" value="skb">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    เปอร์เซ็นส่วนลด สคบ
                                </label>
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault2" value="n" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    เปอร์เซ็นส่วนลดปกติ
                                </label>
                            </div>
                        </div>
                        <div class="col-6 mb-2 d-none">
                            <span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">การคำนวณเบี้ยปรับ</span>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="MTHDFINE" id="flexRadioDefault_2_1" value="mmr">
                                <label class="form-check-label" for="flexRadioDefault_2_1">
                                    อัตรา MRR. + ค่าคงที่
                                </label>
                            </div>
                            <div class="form-check my-2">
                                <input class="form-check-input" type="radio" name="MTHDFINE" id="flexRadioDefault_2_2" value="month" checked>
                                <label class="form-check-label" for="flexRadioDefault_2_2">
                                    อัตราเปอร์เซ็นต่อเดือน
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-xl-8 col-12 p-1">
                <fieldset class="reset border-1 border-primary border-opacity-25 rounded-3">
                    <legend class="reset"><h6 class="text-primary fw-semibold mb-3"><i class="mdi mdi-file-document-outline fs-4"></i> ข้อมูลสัญญาและเอกสาร</h6></legend>
                    <div class="col-sm-12">
                        <div class="row g-2 d-flex align-items-center">
                            <div class="col-4">
                                <div class="input-bx">
                                    <input type="type" name="CONTSTAT" id="CONTSTAT" class="form-control" placeholder=" " value="{{@$contract->CONTSTAT}}" readonly required/>
                                    <span class="text-danger">สถานะสัญญา</span>
                                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50">
                                        <i class="bx bx-dots-horizontal-rounded fs-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-8">
                                <input type="type" name="CONTDESC" id="CONTDESC" class="form-control" placeholder=" " value="{{ @$contract->PactToStatus->CONTDESC }}" readonly/>
                            </div>
                        </div>
                        <div class="row g-2 mt-3 d-flex align-items-center">
                            <div class="col-4 mb-2">
                                <div class="input-bx">
                                    <input type="text" name="RECONTNO" id="RECONTNO" class="form-control" placeholder=" " value=""/>
                                    <span>สัญญาที่ Re.</span>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="input-bx">
                                    <input type="date" name="CARRDT" id="CARRDT" class="form-control" placeholder=" " value=""/>
                                    <span>วันที่ปล่อยรถ</span>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="input-bx">
                                    <input type="text" name="SO" id="SO" class="form-control" placeholder=" " value=""/>
                                    <span>ใบอนุมัติขาย</span>
                                </div>
                            </div>

                            @php
                                $data['dataCus'] = @$contract->PatchToPact->ContractToCus;
                                $CusAdds01 = null;
                                $CusAdds02 = null;
                                $CusAdds03 = null;
                                if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                                    $CusAdds01 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                                        return $row->Type_Adds == 'ADR-0001' && $row->Status_Adds == 'active';
                                    })->first();
                                }
                                if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                                    $CusAdds02 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                                        return $row->Type_Adds == 'ADR-0002' && $row->Status_Adds == 'active';
                                    })->first();
                                }
                                if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                                    $CusAdds03 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                                        return $row->Type_Adds == 'ADR-0003' && $row->Status_Adds == 'active';
                                    })->first();
                                }
                                //----------------------------
                                $AddsCheck = ($CusAdds02 != NULL) ? 2 : ($CusAdds01 != NULL ? 1 : 3);
                                //----------------------------
                                if (@$contract->USEADD != NULL) {
                                    if ( $contract->USEADD == 'ADR-0001' ) {
                                        $AddsCheck = ($CusAdds01 != NULL) ? 1 : ($CusAdds02 != NULL ? 2 : 3);
                                    } elseif ($contract->USEADD == 'ADR-0003') {
                                        $AddsCheck = ($CusAdds03 != NULL) ? 3 : ($CusAdds02 != NULL ? 2 : 1);
                                    }
                                }
                                //----------------------------
                            @endphp
                                
                            <div class="col-12 mb-2 flex-column">
                                <span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">ที่อยู่ออกเอกสาร</span>
                                <div class="form-check-label mt-2">
                                    <div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="USEADD" id="useAdds01" value="ADR-0001" autocomplete="off"
                                            @disabled($CusAdds01 == NULL)
                                            @if($AddsCheck == 1)
                                                checked
                                            @endif
                                            >
                                        <label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds01">
                                            <i class="mdi mdi mdi-home fs-5"></i>
                                            ที่อยู่ปัจจุบัน
                                        </label>
                                    
                                        <input type="radio" class="btn-check" name="USEADD" id="useAdds02" value="ADR-0002" autocomplete="off"
                                            @disabled($CusAdds02 == NULL)
                                            @if($AddsCheck == 2)
                                                checked
                                            @endif
                                            >
                                        <label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds02">
                                            <i class="mdi mdi-home-export-outline fs-5"></i>
                                            ที่อยู่จัดส่งเอกสาร
                                        </label>
                                    
                                        <input type="radio" class="btn-check" name="USEADD" id="useAdds03" value="ADR-0003" autocomplete="off"
                                            @disabled($CusAdds03 == NULL)
                                            @if($AddsCheck == 3)
                                                checked
                                            @endif
                                            >
                                        <label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds03">
                                            <i class="mdi mdi-home-account fs-5"></i>
                                            ที่อยู่ตามสำเนาทะเบียนบ้าน
                                        </label>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="col-12 p-1">
                <fieldset class="reset border-1 border-primary border-opacity-25 rounded-3">
                    <legend class="reset"><h6 class="text-primary fw-semibold mb-3"><i class="mdi mdi-tooltip-edit-outline fs-4"></i> ข้อมูลอื่น ๆ</h6></legend>
                    <div class="col-md-12 p-3 pt-0">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" name="MEMO" id="MEMO" maxlength="65535" style="height: 100px">{{ @$contract->MEMO }}</textarea>
                            <label for="Note_cus" class="fw-bold">หมายเหตุ</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <div class="col text-end">
            <button type="button" id="edit_contract_Save" class="btn btn-success btn-sm waves-effect waves-light w-sm textSize-13 hover-up">
                <span class="textSize-13 text-white">
                    <i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
                </span>
            </button>
            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light w-sm hover-up btn-close-modal" data-bs-dismiss="modal">
                <i class="fas fa-share"></i> ปิด
            </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#edit_contract_Save').click(function() {
            var dataform = document.querySelectorAll('#edit_contract');
		    var validate = validateForms(dataform);
            if (validate == true) {

                $(this).prop('disabled', true);
                $('.btn-close-modal').prop('disabled', true);
                $('<span />', {
                    class : "spinner-border spinner-border-sm",
                    role : "status"
                }).appendTo(".addSpin");
                
                var type = 1;
                var _token = $('input[name="_token"]').val();
                var data = {};$("#edit_contract").serializeArray().map(function(x){data[x.name] = x.value;});

                /*
                if ($('#page').val() == 'Customer') {
                    var url = '{{ route("cus.update",0) }}';
                }
                */
                var url = '{{ route("contracts.update", @$contract->id) }}';

                $.ajax({
                    url: url,
                    method: "PUT",
                    data: {
                        _token: _token,
                        type: type,
                        CODLOAN: {{@$contract->CODLOAN}},
                        data:data
                    },
                    success:function(result){
                        $('#modal_editContract').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            text: 'successful !',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // อัพเดตสถานะ กับ หมายเหตุด้านนอก หลังจากกดเซฟ

                        $('#card-profile-b-end').html(result.viewProfile);
                        $('#card-contracts').html(result.viewCon);

                        //$('#content_cus').html(result);
                    },
                    error: function(err){
                        console.log(err);
                        $('.addSpin').hide();
                        $(this).prop('disabled', false);
                        $('.btn-close-modal').prop('disabled', false);
                        swal.fire({
                            icon : 'error',
                            title : `ERROR ! ${err.status} บันทึกข้อมูลไม่สำเร็จ`,
                            // text :'ไม่สามารถบันทึกข้อมูลได้ในขณะนี้ โปรดติดต่อ Programmer',
                            text : `${err.responseJSON.message}`,
                            showConfirmButton: true,
                        })
                    }
                })

                
            } else {
                console.log('not validate !!');
            }
        });
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
</script>