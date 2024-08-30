<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">ส่วนลดการปิดบัญชี</h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">( Account Closing Discount ) เลขที่สัญญา {{@$contract->CONTNO}}</p>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <button type="button" class="btn-close bckTo_closeAC_btn" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="row mx-3">
      <div class="col-12 mb-3 row m-0 g-2">
        
        <div class="col-lg-8 col-12">
          <fieldset class="reset form-group border p-3 border-info border-1 rounded-3">
            <legend class="reset w-auto px-2 text-center text-bold text-info h6">ตัดสดตามวันชำระล่วงหน้าเป็นเปอร์เซ็น</legend>
            <div class="row textSize-13">
              <div class="col-lg-6 col-md-12" >
                <div class="input-bx">
                    <input type="text" name="sum_ton" id="sum_ton" class="form-control" placeholder=" " value="{{ number_format(@$calCloseAC->tonbalance+@$calCloseAC->payintkang,2) }}" readonly/>
                    <span class>ค่างวดคงเหลือ</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

              <div class="col-lg-6 col-md-12 mt-md-3 mt-lg-0" >
                <div class="input-bx">
                    <input type="text" name="dscint" id="dscint" class="form-control" placeholder=" " value="{{ number_format(@$calCloseAC->dscint,2) }}" readonly/>
                    <span class>ส่วนลดตัดสด</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

              <div class="col-lg-6 col-md-12 mt-3" >
                <div class="input-bx">
                    <input type="text" name="sum1" id="sum1" class="form-control" placeholder=" " value="{{ number_format(@$calCloseAC->tonbalance + @$calCloseAC->payintkang - @$calCloseAC->dscint,2) }}" readonly/>
                    <span class>ต้องชำระค่างวด</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

              <div class="col-lg-6 col-md-12 mt-3" >
                <div class="input-bx">
                    <input type="text" name="intLateAmt" id="intLateAmt" class="form-control" placeholder=" " value="{{ number_format(@$calCloseAC->INTLATEAMT,2) }}" readonly/>
                    <span class>เบี้ยปรับค้างชำระ</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

              <div class="col-lg-6 col-md-12 mt-3" >
                <div class="input-bx">
                    <input type="text" name="fee_value" id="fee_value" class="form-control" placeholder=" " value=""/>
                    <span class>ค่าดำเนินการ</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

              <div class="col-lg-6 col-md-12 mt-3" >
                <div class="input-bx">
                    <input type="text" name="sum_all" id="sum_all" class="form-control" placeholder=" " value="" readonly/>
                    <span class>ยอดตัดสดต้องชำระ</span>
                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                </div>
              </div>

            </div>
          </fieldset>
        </div>

        <div class="col-lg-4 col-12 d-flex flex-column align-self-center">
          <div class="d-flex my-2">
              <div class="input-bx">
                <input type="date" name="PAYFOR_CODE" id="paymentDueDate" class="form-control" placeholder=" " value="{{ date_format( date_create(@$calCloseAC->paydate) , 'Y-m-d' ) }}" required="" @readonly(@$calCloseAC != NULL)/>
                <span class="text-primary">กำหนดชำระถึงวันที่</span>
              </div>
          </div>
          @if( false )
            <fieldset class="reset form-group border p-3 border-danger border-1 rounded-3">
                <legend class="reset w-auto px-2 text-center text-bold text-danger h6">
                  ดอกผลคงเหลือแบบ EFF
                  <i class="bx bx-info-circle" id="tooltip_eff"></i>
                </legend>
                  <div class="row">

                    <div class="col-12" >
                      <div class="input-bx">
                          <input type="text" name="tax_rate" id="tax_rate" class="form-control" placeholder=" " value="0.00"/>
                          <span class>ดอกผลคงเหลือ</span>
                          <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                      </div>
                    </div>

                    <div class="col-12 mt-3" >
                      <div class="input-bx">
                          <input type="text" name="tax_rate" id="tax_rate" class="form-control" placeholder=" " value="0.00"/>
                          <span class>ดอกผลคงเหลือ 50%</span>
                          <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">บาท</button>
                      </div>
                    </div>

                  </div>
            </fieldset>
          @else
            <fieldset class="reset form-group border border-danger border-1 rounded-3 d-flex align-items-center d-flex justify-content-center">
              <legend class="reset w-auto px-2 text-center text-bold text-danger h6">
                ส่วนลด 60% 70% 100%
              </legend>
              <div class="d-flex">
                <div class="card-body p-0">
                  
                  <div class="progress animated-progess mb-1">
                    <div class="progress-bar" role="progressbar" style="width: {{ @$calCloseAC->nopay / $contract->T_NOPAY }}%"></div>
                  </div>

                  <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium mb-0">ส่วนลดทั้งหมด<span class="text-success" id="copy_complete" style="display:none; position: absolute; right: 1em;">คัดลอกสำเร็จแล้ว!</span></p>
                        {{-- <h4 id="disIns" class>1,452 บาท</h4> --}}
                        <input type="text" id="disInsInput" class="h4 form-control-plaintext" value="{{ number_format(@$calCloseAC->dscint, 2) }} บาท">
                        <div class="d-flex">
                          <span class="badge badge-soft-success font-size-12"> {{ number_format(@$calCloseAC->dscpercen,0) }}% </span><span class="ms-2 text-truncate">ส่วนลดดอกเบี้ย</span>
                      </div>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                      <div class="avatar-xs me-3 btn btn-soft-primary hover-up" onclick="copyFunction()" id="copyBtn">
                        <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                          <i class="bx bx-copy-alt"></i>
                        </span>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </fieldset>
          @endif
        </div>

      </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col text-right">
                <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up bckTo_closeAC_btn" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
  @if( false )
    var exampleEl = document.getElementById('tooltip_eff')
    var tooltip = new bootstrap.Tooltip(exampleEl, {
      placement: 'top',
      title: 'ส่วนลดที่ให้ลูกค้าต้องไม่ต่ำกว่า 50% ของดอกผลคงเหลือ',
    })
  @endif

  function copyFunction() {
    var copyText = (document.getElementById("disInsInput").value).replace(/[^0-9\.]+/g, "");
    copyToClipboard(copyText)
  }

  var unsecuredCopyToClipboard = (text) => { const textArea = document.createElement("textarea"); textArea.value=text; document.body.appendChild(textArea); textArea.focus();textArea.select(); try{document.execCommand('copy')}catch(err){console.error('Unable to copy to clipboard',err)}document.body.removeChild(textArea)};

  var tooltip_copy = new bootstrap.Tooltip( document.getElementById('copyBtn'), {
    placement: 'top',
    title: 'คัดลอกไปยังคลิปบอร์ด',
  })

  /**
   * Copies the text passed as param to the system clipboard
   * Check if using HTTPS and navigator.clipboard is available
   * Then uses standard clipboard API, otherwise uses fallback
  */
  var copyToClipboard = (content) => {
    if (window.isSecureContext && navigator.clipboard) {
      console.log("navigator.clipboard.writeText");
      navigator.clipboard.writeText(content);
    } else {
      console.log("unsecuredCopyToClipboard");
      //unsecuredCopyToClipboard(content);
      var textArea = document.createElement("textarea");
      textArea.value= content;
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select(0,9999);
      document.execCommand('copy');
      document.body.removeChild(textArea);
    }
    tooltip_copy.hide();
    $("#copy_complete").show();
  };

  $("#fee_value").on("input", function() {
		let summary = Number( $("#sum1").val().replace(/[^0-9\.]+/g, "") ) + Number( $("#intLateAmt").val().replace(/[^0-9\.]+/g, "") ) +  Number( $(this).val().replace(/[^0-9\.]+/g, "") )
    var nf = new Intl.NumberFormat("th-TH", {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
    $("#sum_all").val( nf.format(summary) );
	});

</script>

{{--
<section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="card card-info card-outline textSize-13">
      <div class="card-header" style=" background: linear-gradient(45deg, #EAEEF5 60%, #F7F8FA  60%); ">
        <h6 class="card-title" style="font-size: 13px;">ส่วนลดการปิดบัญชี <span class="small">(Closing Entries Discount)</span></h6>
        <div class="card-tools">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 15pt;margin-bottom: -25pt">
            <span aria-hidden="true">x</span>
          </button>
        </div>
      </div>  
      <div class="card-body">

        <fieldset class="form-group border p-3">
          <legend class="w-auto px-2 text-center text-bold text-primary h6">ตัดสดตามที่ 1</legend>
          <div class="row textSize-13">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ค่างวดคงเหลือ: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ส่วนลดตัดสด: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ต้องชำระค่างวด: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">+ เบี้ยปรับค้างชำระ: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="0.01-" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ค่าดำเนินการ: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ยอดตัดสดต้องชำระ: </label>
                <div class="col-sm-7 input-group">
                  <input type="text" value="0.01-" class="form-control form-control-sm textSize-13"/>
                </div>
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset class="form-group border p-3">
          <legend class="w-auto px-2 text-center text-bold text-danger h6">ส่วนลดที่ให้ลูกค้าต้องไม่ต่ำกว่า 50% ของดอกผลคงเหลือ</legend>
          <fieldset class="form-group border p-3">
            
            <div class="row">
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ดอกผลคงเหลือแบบ SYD</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">50% ของดอกผลคงเหลือ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ยอดตัดสดต้องชำระ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.01-" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
            </div>

          </fieldset>
          <fieldset class="form-group border p-3">
            
            <div class="row">
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ดอกผลคงเหลือแบบ STR</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.04-" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">50% ของดอกผลคงเหลือ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.02-" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ยอดตัดสดต้องชำระ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.01" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
            </div>

          </fieldset>
          <fieldset class="form-group border p-3">
            
            <div class="row">
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ดอกผลคงเหลือแบบ EFF</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">50% ของดอกผลคงเหลือ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.00" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
              <div class="col-12 form-group row mb-0">
                <label class="col-sm-5 col-form-label text-right">ยอดตัดสดต้องชำระ</label>
                <div class="col-sm-6 input-group">
                  <input type="text" value="0.01" class="form-control form-control-sm textSize-13">
                  <div class="input-group-append">
                    <span class="form-control form-control-sm input-group-text textSize-13"><small>บาท</small></span>
                  </div>
                </div>
              </div>
            </div>

          </fieldset>
        </fieldset>

      </div>
      <div class="card-footer">
        
      </div>
    </div>
  </section>

--}}