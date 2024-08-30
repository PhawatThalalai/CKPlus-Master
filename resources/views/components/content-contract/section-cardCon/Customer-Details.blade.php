<div class="d-flex m-3">
    <div class="flex-shrink-0 me-4">
         <img src="{{ URL::asset('\assets/images/user.png') }}" alt="" style="width: 40px;">
    </div>
    <div class="flex-grow-1 overflow-hidden">
        <h5 class="text-primary fw-semibold">ข้อมูลลูกค้า (Customer Details)</h5>
        <h6 class="fw-semibold">ประเภทลูกค้า : {{@$data['typeCus']}} ({{ @$data['typeCusRe'] }})</h6> 
        <p class="border-primary border-bottom"></p>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-sm table-nowrap mb-0">
        <tbody>
            <tr>
                <th scope="row">วันเดือนปีเกิด :</th>
                <td>
                    @isset($data['Birthday_cus'])
                        <i class="btn btn-soft-info btn-sm rounded-pill bx bx-calendar-event"></i> {{ formatDateThai(@$data['Birthday_cus']) }} <em> ({{calculateAge(@$data['Birthday_cus'])}} ปี)</em>
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">เบอร์ติดต่อ :</th>
                <td>
                    @isset($data['Phone_cus'])
                        <i class="btn btn-soft-info btn-sm rounded-pill fas fa-phone"></i> 
                        <span class="input-mask" data-inputmask="'mask': '999-9999999,999-9999999'">{{ @$data['Phone_cus'] }}</span>
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">เลข ปชช :</th>
                <td>
                    @isset($data['IDCard_cus'])
                        <i class="btn btn-soft-danger btn-sm rounded-pill bx bx-id-card"></i> 
                        <span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$data['IDCard_cus'] }}</span>
                    @else
                        -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">บุคคลอ้างอิง :</th>
                <td>
                    @isset( $data['Cus_Ref'] )
                        {{ @$data['Cus_Ref']  }}
                    @else
                       -
                    @endisset
                </td>
            </tr>
            <tr>
                <th scope="row">ที่อยู่ใช้ทำสัญญา :</th>
                <td>
                    @isset( $data['Adds_Con'] )
                        {{ @$data['Adds_Con']  }}
                    @else
                     -
                    @endisset
                </td>
            </tr>
        </tbody>
    </table>
</div>
