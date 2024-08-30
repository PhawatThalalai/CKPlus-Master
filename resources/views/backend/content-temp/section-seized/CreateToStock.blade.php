<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">นำเข้าสต็อก </h5>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body px-4">

        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center m-2">
                    <img class="img-fluid" src="{{ URL::asset('assets/images/carStock.png') }}" style="width:25%" alt="Card image cap">
                </div>
            </div>
        </div>
        <form id="formStock">
            <input type="hidden" name="page" value="save-Stock">
            <input type="hidden" name="IDHLD" id="IDHLD" value="{{@$id}} ">
            <input type="hidden" name="CONTNO" id="CONTNO" value="{{@$data[0]["contno"]}} ">
            <input type="hidden" name="CODLOAN" id="CODLOAN" value="{{@$data[0]["codloan"]}} ">
            <input type="hidden" name="CONTTYP" id="CONTTYP" value="{{@$CONTTYP}} ">
            <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">


            @if(@$data[0]["codloan"] == 1)
                <p class="fw-semibold">ตามรับเงินจริง</p>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">มูลค่าคงเหลือตามบัญชี</label>
                    <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="RBOOKVALUE" value="{{ @$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TBOOKVALUE : (@$data[0]["totprc"]  -@$data[0]["smpay"] )-(@$data[0]["netprofit"]-@$data[0]["payinterest"] ) }}" id="horizontal-firstname-input" placeholder="มูลค่าคงเหลือตามบัญชี" autocomplete="off" required>
                        <span class="input-group-text">บาท</span>
                    </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ดอกผลคงเหลือ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="RINT" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TINT : (@$data[0]["netprofit"]-@$data[0]["payinterest"] )}}" id="horizontal-firstname-input" placeholder="ดอกผลคงเหลือ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>


                <p class="fw-semibold">ตามตามบัญชี</p>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">มูลค่าคงเหลือตามบัญชี</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TBOOKVALUE" value="{{ @$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->RBOOKVALUE :(@$data[0]["totprc"]  -@$data[0]["smpay"] )- @$data[0]["profbal"] }}" id="horizontal-firstname-input" placeholder="มูลค่าคงเหลือตามบัญชี" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ดอกผลคงเหลือ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TINT" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->RINT : @$data[0]["profbal"] }}" id="horizontal-firstname-input" placeholder="ดอกผลคงเหลือ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">******************</div>
                </div>

                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ราคาประเมิณ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="BEFORETAX" id="BEFORETAX" value="{{ @$data->BEFORETAX }}" id="horizontal-firstname-input" placeholder="ราคาประเมิณ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>


            @else
                <p class="fw-semibold">ตามรับเงินจริง</p>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">มูลค่าคงเหลือตามบัญชี</label>
                    <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="RBOOKVALUE" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TBOOKVALUE:(@$data->totprc-@$data->smpay) }}" id="horizontal-firstname-input" placeholder="มูลค่าคงเหลือตามบัญชี" autocomplete="off" required>
                        <span class="input-group-text">บาท</span>
                    </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ภาษีคงเหลือ</label>
                    <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="RTAX" value="{{ @$data->Vatbl }}" id="horizontal-firstname-input" placeholder="ภาษีคงเหลือ" autocomplete="off" required>
                        <span class="input-group-text">บาท</span>
                    </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ดอกผลคงเหลือ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="RINT" value="{{ @$data->inteff }}" id="horizontal-firstname-input" placeholder="ดอกผลคงเหลือ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>


                <p class="fw-semibold">ตามใบกำกับภาษี</p>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">มูลค่าคงเหลือตามบัญชี</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TBOOKVALUE" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TBOOKVALUE:(@$data->totprc-@$data->smpay) }}" id="horizontal-firstname-input" placeholder="มูลค่าคงเหลือตามบัญชี" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ภาษีคงเหลือ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TTAX" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TTAX:@$data->taxbalance }}" id="horizontal-firstname-input" placeholder="ภาษีคงเหลือ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ดอกผลคงเหลือ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TINT" value="{{@$dataHLD->RBOOKVALUE!=NULL? @$dataHLD->TINT:@$data->profbal }}" id="horizontal-firstname-input" placeholder="ดอกผลคงเหลือ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">******************</div>
                </div>

                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ราคาประเมิณก่อนภาษี</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="BEFORETAX" id="BEFORETAX" value="{{ @$data->BEFORETAX }}" id="horizontal-firstname-input" placeholder="ราคาประเมิณก่อนภาษี" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label">ภาษีตามราคาประเมิณ</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" name="TAXVALUE" id="TAXVALUE" value="{{ @$data->TAXVALUE }}" id="horizontal-firstname-input" placeholder="ภาษีตามราคาประเมิณ" autocomplete="off" required>
                            <span class="input-group-text">บาท</span>
                        </div>
                    </div>
                </div>
            @endif



        </form>
    </div>
    <div class="modal-footer">
        @if(@$data->STSSTOCK == 'Y' || @$data->ContractToHLD->YSTAT == 'Y')
            <button type="button" id="btn-saveStock" class="btn btn-warning btn-sm"> <i class="mdi mdi-spin mdi-loading" style="display:none;"></i> อัพเดท</button>
            <button type="button" id="btn-removeStock" class="btn btn-danger btn-sm">  นำออกจากสต๊อก <i class="mdi mdi-car-arrow-right"></i></button>

        @else
            <button type="button" id="btn-saveStock" class="btn btn-primary btn-sm"> <i class="mdi mdi-spin mdi-loading" style="display:none;"></i> ตกลง</button>
        @endif
    </div>
</div>


<script>


// คำนวนภาษี

    $('#BEFORETAX').on("input",()=>{
        let BEFORETAX = $('#BEFORETAX').val()
        $('#TAXVALUE').val((BEFORETAX) *7/ 107)
    })
    $('#btn-saveStock').click(()=>{
        let dataform = $('#formStock')
        let validate = validateForms(dataform);
        if(validate){
            $('.mdi-loading').show()
            $('#btn-saveStock').prop('disabled',true)
            let data = $('#formStock').serialize()
            $.ajax({
                url : '{{ route('account.store') }}',
                type : 'POST',
                data : data,
                success : async (res)=>{
                    $('.mdi-loading').hide()
                    $('#btn-saveStock').prop('disabled',false)
                    $(".textStock").html('ข้อมูลสต็อก')
                  await swal.fire({
                        icon : 'success',
                        title : 'สำเร็จ !',
                        text : 'บันทึกเข้าสต็อกเรียบร้อย',
                        timer : 2000
                    })

                    $(".modal").modal("hide")
                    $('#form-seized').html(res.html)
                },
                error : ()=>{
                    $('.mdi-loading').hide()
                    $('#btn-saveStock').prop('disabled',false)
                    swal.fire({
                        icon : 'error',
                        title : 'ไม่สำเร็จ !',
                        text : 'บันทึกเข้าสต็อกไม่สำเร็จ',
                        timer : 2000
                    })
                }
            })
        }
    })


    $('#btn-removeStock').click(()=>{
        let IDHLD = $('#IDHLD').val()
        let CODLOAN = $('#CODLOAN').val()
        let CONTTYP= $('#CONTTYP').val()
        $('#btn-removeStock').prop('disabled',true)
        $.ajax({
            url : '{{ route('account.store') }}',
            type : 'POST',
            data : {
                page : 'removeStock',
                IDHLD : IDHLD,
                CODLOAN : CODLOAN,
                CONTTYP:CONTTYP,
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : async (res)=>{
                $('#btn-removeStock').prop('disabled',false)
                $('#form-seized').html(res.html)
                await swal.fire({
                    icon : 'success',
                    title : 'สำเร็จ !',
                    text : 'นำรถออกจากสต๊อกเรียบร้อย',
                    timer : 2000
                })
                 $('.modal').modal('hide')
            },
            error : ()=>{
                $('#btn-removeStock').prop('disabled',false)
                swal.fire({
                    icon : 'error',
                    title : 'ไม่สำเร็จ !',
                    text : 'นำรถออกจากสต๊อกเรียบร้อยไม่สำเร็จ',
                    timer : 2000
                })
            }
        })
    })
</script>
