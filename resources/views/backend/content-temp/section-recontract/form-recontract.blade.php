<span class="formPage">
    <form id="formReContract">
        {{-- hidden value --}}
        <input type="hidden"  name="CUSCOD" value="{{ @$data->PactToCus->IDCard_cus }}" >
        <input type="hidden"  name="PatchCon_id" value="{{ @$data->id }}" >
        <input type="hidden"  name="DataPact_id" value="{{ @$data->DataPact_id }}" >
        <input type="hidden"  name="DataCus_id" value="{{ @$data->DataCus_id }}" >

        <input type="hidden"  name="CANDATE" value="{{ date('Y-m-d') }}" >
        <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
        <input type="hidden" name="page" value="save-recontract" >
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-center m-5">
                            <img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_resume_folder.svg') }}" style="height:40vh;" alt="Card image cap">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row g-2 mb-2">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text"  name="CONTNO" value="{{ @$data->CONTNO }}" class="form-control" required placeholder=" " />
                                    <span class="text-danger">เลขที่สัญญา</span>
                                    <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 addContract">
                                        <i class="dripicons-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="NEWCONTNO" value="{{  @$data->CONTNO }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">เลขที่ต่อสัญญา</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="" value="{{ @$data->ContractLocat->Name_Branch }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">สัญญาสาขา</span>
                                </div>
                                <input type="hidden" name="LOCAT" value="{{ @$data->ContractLocat->id }}" class="form-control" required placeholder=" " required/>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="date" name="" value="{{ date('Y-m-d') }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">วันที่ต่อสัญญา</span>
                                </div>
                            </div>
                        </div>
                        @php
                            $land = @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset;
                        @endphp
                        <div class="row g-2 mb-2">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="" value="{{ @$land->Land_SizeRai>0 ? trim(@$land->Land_SizeRai)."ไร่ ":" "}}{{@$land->Land_SizeNgan>0 ? trim(@$land->Land_SizeNgan)."งาน ":" "}} {{@$land->Land_SizeSquareWa>0 ?trim(@$land->Land_SizeSquareWa)."ตรว.":" "}}" class="form-control" required placeholder=" " required/>
                                    <span class="">เนื้อที่</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="" value="{{ @$land->Land_Id }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">เลขโฉนด</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text"   name="NAME1" value="{{ @$data->PactToCus->Firstname_Cus }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">ชื่อลูกค้า</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="NAME2" value="{{ @$data->PactToCus->Surname_Cus }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">นามสกุล</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text"   name="SMPAY"  id="SMPAY" value="{{ @$data->SMPAY }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">ยอดชำระแล้ว</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name=""  id='T_UPAY' value="{{ @$data->TOT_UPAY }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">ค่างวด</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-4">
                                <div class="input-bx">
                                    <input type="text" name="REXP_PRD" value="{{ @$data->EXP_PRD }}" class="form-control border-info" required placeholder=" " required/>
                                    <span class="text-danger">ค้างงวด</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-bx">
                                    <input type="text" name="EXP_FRM" value="{{ @$data->EXP_FRM }}" class="form-control border-info" required placeholder=" " required/>
                                    <span class="text-danger">ค้างจาก</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-bx">
                                    <input type="text" name="EXP_TO" value="{{ @$data->EXP_TO }}" class="form-control border-info" required placeholder=" " required/>
                                    <span class="text-danger">ค้างถึง</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name=""   data-index="1" value="0" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">ค้างค่าปรับ</span>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="input-bx">
                                    <input type="text"   name="" value="{{ @$data->TOTPRC - @$data->SMPAY }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">ยอดคงเหลือ</span>
                                    <input type="hidden" id="totprc_old" value="{{ @$data->TOTPRC}}">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="T_NOPAY" id='T_NOPAY' value="{{ @$data->T_NOPAY }}" class="form-control" required placeholder=" " required/>
                                    <span class="text-danger">งวดทั้งหมด</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="card border border-primary h-100 bg-light">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="input-bx" id="datepicker1">
                                    <input type="text" name="LASTCANDT" id="LASTCANDT"
                                        class="form-control rounded-0 rounded-start text-start" placeholder=""
                                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker1"
                                        data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                        data-date-language="th" data-date-today-highlight="true"
                                        data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                        autocomplete="off" data-date-autoclose="true" required>
                                        <span class="text-danger">วันที่ต่อสัญญา</span>

                                </div>
                            </div>
                        </div>


                        <div class="row mb-2 g-2">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="blRETCSHPRC" id="blRETCSHPRC"   data-index="1" value="{{ @$data->TCSHPRC }}" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">เงินต้น</span>
                                    <input type="hidden" id="RETCSHPRC"  name="RETCSHPRC" value="{{ @$data->TCSHPRC }}">
                                    <input type="hidden" id="OLDPROFIT"  name="OLDPROFIT" value="{{ @$data->NETPROFIT }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="otherPay"  id="otherPay"  data-index="1" value="" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">ค่าอิ่นๆ</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 g-2">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="FEERATE"  id="FEERATE"  data-index="1" value="" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">อัตราค่าธรรมเนียม</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="FLRATE"   id="FLRATE"  data-index="1" value="" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">อัตราดอกเบี้ย</span>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-2 g-2">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="RETNOPAY" id="RETNOPAY"   data-index="1" value="" class="form-control " required="" placeholder=" ">
                                    <span class="text-danger">ระยะผ่อน</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="REFUPAY" id="REFUPAY"   data-index="1" value="" class="form-control " required="" placeholder=" "  >
                                    <span class="text-danger">ค่างวด งวดแรก</span>
                                    <button type="button" id="btn_calculatePay" class="mx-0 btn btn-danger border border-danger border-opacity-50 font-size-8 w-xs" data-bs-toggle="tooltip" aria-label="คำนวณ">
                                        <i class="bx bx-calculator"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 g-2">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="FEEAMT"  id="FEEAMT"  data-index="1" value="" class="form-control " required  placeholder=" "  >
                                    <span>ค่าธรรมเนียม</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="NPROFIT" id="NPROFIT"   data-index="1" value="" class="form-control " required  placeholder=" "  >
                                    <span>ดอกเบี้ย</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 g-2">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="FEETOTAMT" id="FEETOTAMT"   data-index="1" value="" class="form-control " required  placeholder=" "  >
                                    <span>ยอดดอกเบี้ย+ค่าดำเนินการ</span>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="ALLTOTPRC" id="ALLTOTPRC"   data-index="1" value="" class="form-control " required placeholder=" " >
                                    <span>รวมยอดผ่อน</span>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 g-2">
                            {{-- <div class="col-sm-6">
                                <div class="input-bx">
                                    <input type="text" name="RENUPAY"  id="RENUPAY"  data-index="1" value="" class="form-control " required="" placeholder=" ">
                                    <span>งวดต่อไป</span>
                                </div>
                            </div> --}}
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text" name="RELUPAY" id="RELUPAY"   data-index="1" value="" class="form-control " required placeholder=" "  >
                                    <span>งวดสุดท้าย</span>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="input-bx">
                                    <input type="text"   id="totallprc" name="totallprc"  data-index="1" value="" class="form-control " required  placeholder=" "  >
                                    <span>ยอดรวมทั้งสัญญา</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <div class="">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="MEMO1" id="floatingTextarea"></textarea>
                                        <label for="floatingTextarea">Comments</label>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col text-end">
                <button type="button" class="btn btn-dark waves-effect waves-light w-sm searchContract">
                    <i class="mdi mdi-account-search d-block font-size-16"></i> สอบถาม
                </button>
                <button type="button" id="btn-add" class="btn btn-success waves-effect waves-light w-sm btn-saveRecon">
                    <i class="mdi mdi-content-save d-block font-size-16"></i> บันทึก
                </button>
            </div>
        </div>

    </form>
</span>



    {{-- กดเพิ่มสัญญา --}}
    <script type="text/javascript">
        $(".addContract").click(function() {
            var search = $('.header_inputSearch').val();
            var typeSr = 'contract';
            var page_type = $('.page_type').val();
            var page = $('.page').val();
            var pageUrl = 'view-recontracts';
            var _token = $('input[name="_token"]').val();
            var flagTab = '';
            $('.page_tmp').val('')
            getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab)
        });
    </script>

    <script>
        $('.btn-saveRecon').click(()=>{
            let dataform = $('#formReContract')
            let validate = validateForms(dataform);
            if(validate){
                    Swal.fire({
                    icon : "info",
                    title: "ยืนยันการบันทึกต่อสัญญาที่ดิน",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยัน",
                }).then((result) => {
                    if (result.isConfirmed) {

                            $(".btn-saveRecon").attr('disabled',true);
                            $.ajax({
                                url : '{{ route('account.store') }}',
                                type : 'POST',
                                data : $("#formReContract").serialize(),

                                success : (res)=>{
                                    Swal.fire({
                                            icon: 'success',
                                            text: result.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                },
                                error : (err)=>{
                                    $(".btn-saveRecon").attr('disabled',false);
                                    Swal.fire({
                                            icon: 'error',
                                            title: `ERROR ` + err.status + ` !!!`,
                                            text: err.responseJSON.message,
                                            showConfirmButton: true,
                                        });
                                }
                            })
                    }
                })
            }
        });
    </script>

    <script>
         $('#btn_calculatePay').click(()=>{
            var blRETCSHPRC = $('#blRETCSHPRC').val().replace(/,/g, '');  //เงินต้น
            var RETCSHPRC = $('#RETCSHPRC').val().replace(/,/g, '');  //เงินต้น
            var OLDPROFIT = $('#OLDPROFIT').val().replace(/,/g, '');  //ดอกเบี้ยเดิม
            var FEERATE = $('#FEERATE').val().replace(/,/g, '');  //ค่าธรรมเนียม
            var RETNOPAY = $('#RETNOPAY').val().replace(/,/g, '');  //จำนวนงวด
            var FLRATE = $('#FLRATE').val().replace(/,/g, '');  // ดอกเบี้ย
            var totprc_old = $('#totprc_old').val().replace(/,/g, '');
            var REFUPAY = $('#REFUPAY').val().replace(/,/g, ''); //ยอดผ่อน
            var SMPAY = $('#SMPAY').val().replace(/,/g, ''); //ยอดผ่อน
            var otherPay = $('#otherPay').val().replace(/,/g, ''); //ค่าอิ่นๆ
            var T_UPAY = $('#T_UPAY').val().replace(/,/g, ''); //ค่างวดเก่า
            var T_NOPAY = $('#T_NOPAY').val().replace(/,/g, ''); //จำนวนงวดเก่า
            var profitmonth = 0
            var feetotamt = 0;
            var totprc = 0;
            var alltotprc = 0;
            var lastpay = 0;
            var PeriodAll = 0;
            var PeriodCheck = 0;
            var LPeriod = 0;
            var allprofit = 0;
            console.log(RETCSHPRC);
            var Process = ((parseFloat(blRETCSHPRC) * (parseFloat(FEERATE) / 100) ));
            var ProcessR = Math.ceil(Process);           

            $('#FEEAMT').val(ProcessR);

            var ProfitRate = ((parseFloat(blRETCSHPRC) * ((parseFloat(FLRATE)*RETNOPAY) / 100) ));
            var ProfitTotal = Math.ceil(ProfitRate);
            
            $('#NPROFIT').val(ProfitTotal) ;//ยอดดอกเบี้ย
            allprofit = (parseFloat(ProcessR)+ parseFloat(ProfitTotal) + parseFloat(otherPay));
            
            profitmonth   = Math.ceil(allprofit)/RETNOPAY;

            feetotamt =  REFUPAY*(RETNOPAY-1);
            
            //$('#REFUPAY').val(profitmonth) ;// ค่างวด

           // PeriodAll = parseFloat(profitmonth)*parseFloat(RETNOPAY);

            PeriodCheck = parseFloat(allprofit) - parseFloat(feetotamt);

            // if(PeriodCheck>=0){
            //     LPeriod = parseFloat(REFUPAY)+parseFloat(PeriodCheck);
            // }else{
                LPeriod =  parseFloat(PeriodCheck);
            // }

            console.log(LPeriod);

            lastpay = parseFloat(LPeriod)+parseFloat(RETCSHPRC);

            $('#RELUPAY').val(lastpay);

            totprc =parseFloat(RETCSHPRC)+parseFloat(allprofit);

            $('#ALLTOTPRC').val(totprc);

            alltotprc = parseFloat(totprc)+parseFloat(OLDPROFIT);

            $('#totallprc').val(alltotprc);

            $('#FEETOTAMT').val(allprofit);
         })

    </script>

    {{-- สอบถาม --}}
    <script type="text/javascript">
        $(".searchContract").click(function() {
            var search = $('.header_inputSearch').val();
            var typeSr = 'contract';
            var page_type = $('.page_type').val();
            var page = $('.page').val();
            var pageUrl = 'search-recontract';
            var _token = $('input[name="_token"]').val();
            var flagTab = 'add-Broker';
            var dataFlag = 'search-recontract';
            $('.page_tmp').val('search-recontract')
            getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab,dataFlag)
        });
    </script>
