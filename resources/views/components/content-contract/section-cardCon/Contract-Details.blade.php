<div class="d-flex m-3">
    <div class="flex-shrink-0 me-4">
         <img src="{{ URL::asset('/assets/images/signature.png') }}" alt="" style="width: 40px;">
    </div>
    <div class="flex-grow-1 overflow-hidden">
        <h5 class="text-primary fw-semibold">ข้อมูลสัญญา (Contract Details)</h5>
        <h6 class="fw-semibold">{{ @$data['CONTNO'] }} ({{@$data['typeCon']}})</h6>
        <p class="border-primary border-bottom"></p>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-nowrap mb-0">
        <tbody>
            <tr>
                <th scope="row">วันทำสัญญา :</th>
                <td>
                    @isset($data['Date_con'])
                        <i class="btn btn-soft-info btn-sm rounded-pill bx bx-calendar-event"></i> {{ formatDateThai(@$data['Date_con']) }}
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">สาขา :</th>
                <td>
                    @isset($data['Name_Branch'])
                     <i class="btn btn-soft-success btn-sm rounded-pill bx bx-map"></i> {{ @$data['Name_Branch'] }}
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">Credo Code :</th>
                <td>
                    @isset($data['Credo_Code'])
                        <i class="btn btn-soft-danger btn-sm rounded-pill mdi mdi-cellphone-nfc"></i> {{ @$data['Credo_Code'] }}
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">ลิงก์สัญญา (Link Contract) :</th>
                <td>
                    @isset($data['LinkUpload_Con'])
                      <a href="{{ @$data['LinkUpload_Con'] }}" class="btn btn-soft-primary btn-sm rounded-pill" target = "_blank">ดูอัลบั้ม <i class="fas fa-link ms-1"></i> </a>
                    @else
                        <span class="modal_lg" data-link="{{ route('contract.edit',@$data['Con_id']) }}?funs={{'EditCardCon'}}" style="cursor: pointer;">
                            <i class="btn btn-soft-warning btn-sm rounded-pill mdi mdi-camera-plus bx-tada"></i> <span class="text-danger fs-6 fw-semibold"> <u>กรุณาเพิ่มลิงก์ !</u></span>
                        </span>
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">ลิงก์ลงพื้นที่ (Link Checkers) :</th>
                <td>
                    @isset($data['linkChecker'])
                      <a href="{{ @$data['linkChecker'] }}" class="btn btn-soft-primary btn-sm rounded-pill" target = "_blank">ดูอัลบั้ม <i class="fas fa-link ms-1"></i> </a>
                    @else
                        -
                    @endisset
                </td>
            </tr>
        </tbody>
    </table>
</div>
