@if($type == 1)
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold">ให้สิทธิซื้อคืน (ผู้ซื้อ) </h5>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ออกจดหมาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">หมายเหตุ</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-password-input" class="col-sm-3 col-form-label">พนักงานเร่งรัด</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="Employee" id="">
                        <option value="">-- พนักงานเร่งรัด --</option>
                        @foreach (@$dataUser as $item )
                            <option value="{{ $item->name }}">{{ $loop->iteration }}. {{ $item->name }}</option>
                        @endforeach
                       
                      </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm" onclick="rpPayments(1,1,{{@$DataPact}})">ตกลง</button>
        </div>
    </div>
@elseif($type == 2)
<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">ให้สิทธิซื้อคืน (ผู้ซื้อ) </h5>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="dataForm">
            <div class="row mb-4">
                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ออกจดหมาย</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" name="DateLetter" id="horizontal-firstname-input" placeholder="Enter Your ">
                </div>
            </div>
            <div class="row mb-4">
                <label for="horizontal-email-input" class="col-sm-3 col-form-label">หมายเหตุ</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="memo" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row mb-4">
                <label for="horizontal-password-input" class="col-sm-3 col-form-label">พนักงานเร่งรัด</label>
                <div class="col-sm-9">
                  <select class="form-control" name="Employee" id="">
                    <option value="">-- พนักงานเร่งรัด --</option>
                    @foreach (@$dataUser as $item )
                        <option value="{{ $item->name }}">{{ $loop->iteration }}. {{ $item->name }}</option>
                    @endforeach
                   
                  </select>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="rpPayments(1,2,{{@$DataPact}})">ตกลง</button>
    </div>
</div>
@elseif($type == 3)
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold">Content </h5>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="dataForm">
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ออกจดหมาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="DateLetter" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">หมายเหตุ</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="memo" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-password-input" class="col-sm-3 col-form-label">พนักงานเร่งรัด</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="Employee" id="">
                        <option value="">-- พนักงานเร่งรัด --</option>
                        @foreach (@$dataUser as $item )
                            <option value="{{ $item->name }}">{{ $loop->iteration }}. {{ $item->name }}</option>
                        @endforeach
                       
                      </select>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm" onclick="rpPayments(1,3,{{@$DataPact}})">ตกลง</button>
        </div>
    </div>
@elseif($type == 4)
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold">Content </h5>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="dataForm">
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ออกจดหมาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="DateLetter" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">สถานที่ขาย</label>
                    <div class="col-sm-9">
                        <input type="text" name="SellPlace"  class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ขาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="DateSell"  id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">เวลา</label>
                    <div class="col-sm-9">
                      <input type="time" class="form-control" name="TimeSell"  id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-password-input" class="col-sm-3 col-form-label">พนักงานเร่งรัด</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="Employee" id="">
                        <option value="">-- พนักงานเร่งรัด --</option>
                        @foreach (@$dataUser as $item )
                            <option value="{{ $item->name }}">{{ $loop->iteration }}. {{ $item->name }}</option>
                        @endforeach
                       
                      </select>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-sm" onclick="rpPayments(1,4,{{@$DataPact}})">ตกลง</button>
        </div>
    </div>
@elseif($type == 5)
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold">Content </h5>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="dataForm">
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ออกจดหมาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="DateLetter" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">วันที่ขาย</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="DateSell" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">เวลา</label>
                    <div class="col-sm-9">
                      <input type="time" class="form-control" name="TimeSell" id="horizontal-firstname-input" placeholder="Enter Your ">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">ราคาขาย</label>
                    <div class="col-sm-9">
                        <input type="text" name = "prices" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">ขายขาดทุน</label>
                    <div class="col-sm-9">
                        <input type="text" name="loss" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">ค่าใช้จ่าย</label>
                    <div class="col-sm-9">
                        <input type="text" name="expenses" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-email-input" class="col-sm-3 col-form-label">รวมทั้งสิ้น</label>
                    <div class="col-sm-9">
                        <input type="text" name="totalSell" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="horizontal-password-input" class="col-sm-3 col-form-label">พนักงานเร่งรัด</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="Employee" id="">
                        <option value="">-- พนักงานเร่งรัด --</option>
                        @foreach (@$dataUser as $item )
                            <option value="{{ $item->name }}">{{ $loop->iteration }}. {{ $item->name }}</option>
                        @endforeach
                       
                      </select>
                    </div>
                </div>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primaru btn-sm" onclick="rpPayments(1,5,{{@$DataPact}})">ตกลง</button>
        </div>
    </div>
@endif





{{-- print --}}
<script>
    function rpPayments(codloan,typeReport,DataPact) {
        let data = $('#dataForm').serialize()
        console.log(data);
        let id = $('#print_payments').attr('data-mas_id');
        let url = `{{ route('report-backend.show', 'id') }}?page=rp-seized&status=true&typeReport=${typeReport}&codloan=${codloan}&DataPact=${DataPact}&${data}`;
        url = url.replace('id', id);

        let newWindow = window.open(url, "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");

    }
</script>
