<style>
    /* width */
    ::-webkit-scrollbar {
      width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #b6b6b6;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
    </style>

<div class="row px-4">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center">
        <p class="fw-semibold fs-6 text-nowrap">{{ @$data['company_name'] }}</p>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center">
        <p class="fw-semibold mb-0 fs-6 text-nowrap">{{ @$data['Account_Bank'] }}</p> <p class="fw-semibold">( {{ @$data['Account_num'] }} )</p>
    </div>
</div>
<div class="px-4 my-4">
    <div >
        <div class="row">
            <div class="col-12 text-center">
                @if( @$data['countBank'] > 1 )
                  <button class="carousel-control-prev btn-NextPre" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next btn-NextPre" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                @endif
            @include('frontend.content-treas.amount-circle')
        </div>
    </div>
    </div>
</div>
<div class="px-4">
    <div class="row nav nav-pills mb-2 bg-light rounded-pill g-0 py-1" id="pills-tab" role="tablist">
        <div class="col d-grid " role="presentation">
            <button class="nav-link active rounded-pill first-tab" id="pills-history-{{ @$data['Bankid'] }}-tab" data-bs-toggle="pill" data-bs-target="#pills-history-{{ @$data['Bankid'] }}" type="button" role="tab" aria-controls="pills-history-{{ @$data['Bankid'] }}" aria-selected="true">รายการ</button>
        </div>
        <div class="col d-grid " role="presentation">
            <button class="nav-link rounded-pill" id="pills-Credit-{{ @$data['Bankid'] }}-tab" data-bs-toggle="pill" data-bs-target="#pills-Credit-{{ @$data['Bankid'] }}" type="button" role="tab" aria-controls="pills-Credit-{{ @$data['Bankid'] }}" aria-selected="false">เพิ่ม/ถอน-เครดิต</button>
        </div>
    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active px-2" id="pills-history-{{ @$data['Bankid'] }}" role="tabpanel" aria-labelledby="pills-history-{{ @$data['Bankid'] }}-tab" >
            <div class="row my-3 gap-1">
                <div class="col-12 text-center">
                <span class="fs-6 fw-semibold">รายการบัญชี (Account list)</span>
                </div>
                <div class="col-12 d-grid m-auto">
                    {{-- <input type="text" id="Bankid" value="{{ @$data['Bankid'] }}"> --}}
                    <select class="form-select form-select-sm rounded-pill border border-warning" name="" id="dateTran-{{ @$data['Bankid'] }}">
                        <option value="">-- เดือน --</option>
                        <option value="{{ carbon\carbon::today() }}">วันนี้</option>
                        <option value="{{ carbon\carbon::now()->subDays(3) }}">3 วันที่แล้ว</option>
                        <option value="{{ carbon\carbon::now()->subDays(7) }}">7 วันที่แล้ว</option>
                        <option value="{{ carbon\carbon::now()->subDays(30) }}">1 เดือนที่แล้ว</option>
                    </select>
                </div>
                <div class="col-12 d-grid m-auto">
                    <button type="button" class="btn btn-primary btn-sm rounded-pill search-transfer" id="search-transfer" Bankid = "{{ @$data['Bankid'] }}" onclick="searchTransfer('{{ @$data['Bankid'] }}');">เลือก <i class="bx bx-search-alt-2"></i> </button>
                </div>
            </div>
            <div id="content-transaction-{{ @$data['Bankid'] }}"  style="min-height: 300px;">
                @include('frontend.content-treas.tab-transaction')
            </div>
            {{-- loading --}}
            <div id="loading-tran" style="display: none;">
                @include('components.content-card.transaction-empty')
            </div>
        </div>
        <div class="tab-pane fade" id="pills-Credit-{{ @$data['Bankid'] }}" role="tabpanel" aria-labelledby="pills-Credit-{{ @$data['Bankid'] }}-tab" >
            <div style="min-height: 300px;">
                <form id="formCredit-{{ @$data['Bankid'] }}">
                    <input type="hidden" name="totalBalance" value="{{ @$data['Amount_after'] }}">
                    <input type="hidden" name="page" value="manage-credit">
                    <input type="hidden" name="status" value="manage-credit">
                    <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
                    <input type="hidden" name="Bank_id" value="{{ @$data['Bankid'] }}">
                    <input type="hidden" name="Bank_Zone" value="{{ @$data['BankZone'] }}">
                    <input type="hidden" name="TransactionDetail" id="TransactionDetail-{{ @$data['Bankid'] }}" value="">
                    <input type="hidden" name="TransactionTxt" id="TransactionTxt-{{ @$data['Bankid'] }}" value="">

                    <div class="row mb-1">
                        <div class="col-12">
                            <label class="fw-semibold">เพิ่ม/ถอน-เครดิต :</label>
                            <div class="input-group">
                                <input type="number" name="expenses" class="form-control expenses" placeholder="กรอกยอดเงินในการ เพิ่ม/ถอน เครดิต" data-bankid="{{ @$data['Bankid'] }}">
                                <span class="input-group-text" id="basic-addon2">บาท</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="fw-semibold">บันทึก :</label>
                            <div class="input-group">
                                <textarea name="Memo" class="form-control Memo" id="" cols="100" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col text-start d-grid m-auto">
                            <button type="button" class="btn btn-danger mb-3 btn-sm btn-submitCredit rounded-pill" tran="withdraw-credit" tranTxt="ลดเครดิต (TOP-DOWN)" dataBank = "{{ @$data['Bankid'] }}" >ถอนเครดิต <span class="addSpin"></span><i class=" icon bx bxs-minus-circle fs-5"></i></button>
                        </div>
                        <div class="col text-end d-grid border-start border-light m-auto">
                            <button type="button" class="btn btn-success mb-3 btn-sm btn-submitCredit rounded-pill" tran="add-credit" tranTxt="เพิ่มเครดิต (TOP-UP)" dataBank = "{{ @$data['Bankid'] }}" data-bankid="{{ @$data['Bankid'] }}" >เพิ่มเครดิต <span class="addSpin"></span><i class=" icon bx bxs-plus-circle fs-5"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

searchTransfer = (Bankid) =>{

        let loading = $('#loading-tran').html()
        let dateTran = $('#dateTran-'+Bankid).val()

        $('#content-transaction-'+Bankid).html(loading)
        $('.search-transfer').prop('disabled', true)

        $.ajax({
            url : '{{ route('treas.show',0) }}',
            type : 'GET',
            data : {
                dateTran : dateTran,
                Bankid : Bankid,
                funs : 'getTransaction',
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res) => {
                $('#content-transaction-'+Bankid).html(res.html)
                $('.search-transfer').prop('disabled', false)
            },
            error : (err) => {
                let text = `
                    <h1 class="text-danger fw-semibold"> ERROR !</h1>
                `;
                $('#content-transaction-'+Bankid).html(text)
                $('.search-transfer').prop('disabled', false)
            }
        })
}

    // $('.search-transfer').click((e) => {

    //     let Bankid = $(e.currentTarget).attr('Bankid')
    //     let loading = $('#loading-tran').html()
    //     let dateTran = $('#dateTran-'+Bankid).val()

    //     $('#content-transaction-'+Bankid).html(loading)
    //     $('.search-transfer').prop('disabled', true)

    //     $.ajax({
    //         url : '{{ route('treas.show',0) }}',
    //         type : 'GET',
    //         data : {
    //             dateTran : dateTran,
    //             Bankid : Bankid,
    //             funs : 'getTransaction',
    //             _token : '{{ @CSRF_TOKEN() }}'
    //         },
    //         success : (res) => {
    //             $('#content-transaction-'+Bankid).html(res.html)
    //             $('.search-transfer').prop('disabled', false)
    //         },
    //         error : (err) => {
    //             let text = `
    //                 <h1 class="text-danger fw-semibold"> ERROR !</h1>
    //             `;
    //             $('#content-transaction-'+Bankid).html(text)
    //             $('.search-transfer').prop('disabled', false)
    //         }
    //     })
    // })
</script>
