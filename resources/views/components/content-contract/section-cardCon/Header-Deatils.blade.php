
    {{-- หมายเหตุสัญญา --}}
    <div class="col-12 text-end">

        <i tabindex="0" id="popover_memo_con" class="bx bx-notepad fs-4 btn btn-outline-primary" role="checkbox"
            {{-- data-bs-toggle="popover"
            data-bs-trigger="hover" --}}
            data-bs-trigger="focus"
            data-bs-title="หมายเหตุ"
            data-bs-custom-class="custom-popover"
            {{-- data-bs-content="{{ @$data['Memo_Con'] }}"> --}}
            data-bs-content="
            <div class='row'>
                <div class='col-12'>
                    @php
                        echo nl2br( @$data['Memo_Con'],false);
                    @endphp
                </div>
            </div>">
        </i>
    </div>
    <img src="{{ isset($data['image']) ? URL::asset(@$data['image']) : asset('/assets/images/users/user-1.png') }}" alt="" class="p-1 mb-2 rounded-circle border border-3 {{ $bordercolor }}" style="width: 120px; height: 120px;">

    <br>
    {{-- <span class="badge {{$colorbadge}} mb-2 fs-6 modal_lg" data-link="{{ route('contract.edit',@$data['Con_id']) }}?funs={{'EditStatusCon'}}">{{ @$data['StatusApp_Con'] }}</span> --}}
    <span class="modal_lg" data-link="{{ route('contract.edit',@$data['Con_id']) }}?funs={{'EditStatusCon'}}">
        <a class="btn {{$colorbadge}} btn-sm mb-2 font-size-15 rounded-pill w-md" data-bs-toggle="tooltip">
            {{ @$data['StatusApp_Con'] }} <i class="bx bx-edit-alt"></i>
        </a>
    </span>

    @php
        // ตัวแปร เช็คสถานะสัญญา เพื่อ กำหนดสีของสัญญา
        $state_active = false;
        $state_pending = false;
        $state_success = false;
        $state_cancel = false;
        switch (@$data['Status_Con']) {
            case 'active':
                $state_active = true;
                break;
            case 'pending':
                $state_pending = true;
                break;
            case 'complete':
            case 'transfered':
            case 'close':
                $state_success = true;
                break;
            default:
                // cancel
                $state_cancel = true;
                break;
        }
    @endphp

        <h4 class="fw-semibold mb-0" @style([
            'background: rgb(156,27,236);
            background: -moz-linear-gradient(90deg, rgba(63,251,243,1) 0%, rgba(156,27,236,1) 50%, rgba(252,70,245,1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(63,251,243,1) 0%, rgba(156,27,236,1) 50%, rgba(252,70,245,1) 100%);
            background: linear-gradient(90deg, rgba(63,251,243,1) 0%, rgba(156,27,236,1) 50%, rgba(252,70,245,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#3ffbf3\',endColorstr=\'#fc46f5\',GradientType=1);' => $state_active,

            'background: rgb(209,152,7);
            background: -moz-linear-gradient(90deg, rgba(255,222,0,1) 0%, rgba(231,107,35,1) 65%, rgba(209,152,7,1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(255,222,0,1) 0%, rgba(231,107,35,1) 65%, rgba(209,152,7,1) 100%);
            background: linear-gradient(90deg, rgba(255,222,0,1) 0%, rgba(231,107,35,1) 65%, rgba(209,152,7,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#ffde00\',endColorstr=\'#d19807\',GradientType=1);' => $state_pending,

            'background: rgb(12,111,16);
            background: -moz-linear-gradient(90deg, rgba(209,223,28,1) 0%, rgba(12,111,16,1) 50%, rgba(0,255,175,1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(209,223,28,1) 0%, rgba(12,111,16,1) 50%, rgba(0,255,175,1) 100%);
            background: linear-gradient(90deg, rgba(209,223,28,1) 0%, rgba(12,111,16,1) 50%, rgba(0,255,175,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#d1df1c\',endColorstr=\'#00ffaf\',GradientType=1);' => $state_success,

            'background: rgb(241,64,64);
            background: -moz-linear-gradient(90deg, rgba(235,50,178,1) 0%, rgba(241,64,64,1) 51%, rgba(255,108,21,1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(235,50,178,1) 0%, rgba(241,64,64,1) 51%, rgba(255,108,21,1) 100%);
            background: linear-gradient(90deg, rgba(235,50,178,1) 0%, rgba(241,64,64,1) 51%, rgba(255,108,21,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#eb32b2\',endColorstr=\'#ff6c15\',GradientType=1);' => $state_cancel,

            '-webkit-background-clip: text;',
            '-moz-background-clip: text;',
            '-webkit-text-fill-color: transparent;',
            '-moz-text-fill-color: transparent;',

        ])>{{ @$data['CONTNO'] }}</h4>
        <h6>{{ @$data['NameCus'] }}</h6>
    <div class="row mx-2 mt-2 g-1">
        <a id="edit-about-cus" class="col-xl col-lg col-md col-sm text-center btn btn-warning rounded-pill me-1 modal_lg" data-link="{{ route('contract.edit',@$data['Con_id']) }}?funs={{'EditCardCon'}}">แก้ไข</a>
        <a href="{{ route('cus.index') }}?page={{'profile-cus'}}&id={{@$data['Cus_id']}}" target="_blank" class="col-xl col-lg col-md col-sm text-center btn btn-outline-primary rounded-pill me-1" >โปรไฟล์</a>
        <a  class="col-xl col-lg col-md col-sm text-center btn btn-outline-primary rounded-pill me-1 data-modal-xl-2" data-link="{{ route('ControlCenter.create') }}?funs={{'calculates'}}&zone={{Auth::user()->zone}}&id={{@$data['Cus_tag']}}" >คำนวณ</a>
        <div class="col-xl-1 col-lg-1 col-md-1 col-sm text-center d-none d-sm-none d-md-block">
            <div class="dropdown">
                <button class="btn btn-outline-primary rounded-circle dropdown-toggle" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <ul class="dropdown-menu">
                    <li style="cursor:pointer;"><a class="dropdown-item data-modal-xl-2 text-primary" data-link="{{ route('contract.show',@$data['Con_id']) }}?type={{'HistoryCon'}}" ><i class="fas fa-history fs-5"></i> ประวัติ</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'PaymentForm'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-invoice-dollar fs-5"></i> Payments</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'ContractForm'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มอนุมัติ</a></li>
                    {{-- <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{''}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มผู้ค้ำ</a></li> --}}
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'LoanContract'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มสัญญา</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'Letter'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มจดหมาย</a></li>

                </ul>
            </div>
        </div>
        <div class="col-xl col-lg col-md col-sm text-center d-xl-none d-lg-none d-md-none">
            <div class="dropdown d-grid">
                <button type="button" class="btn btn-outline-primary rounded-pill dropdown-toggle" data-bs-toggle="dropdown" ><i class="bx bx-dots-vertical-rounded"></i></button>
                <ul class="dropdown-menu">
                    <li style="cursor:pointer;"><a class="dropdown-item data-modal-xl-2 text-primary" data-link="{{ route('contract.show',@$data['Con_id']) }}?type={{'HistoryCon'}}" ><i class="fas fa-history fs-5"></i> ประวัติ</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'PaymentForm'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-invoice-dollar fs-5"></i> Payments</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'ContractForm'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มอนุมัติ</a></li>
                    {{-- <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{''}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มผู้ค้ำ</a></li> --}}
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'LoanContract'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มสัญญา</a></li>
                    <li style="cursor:pointer;"><a href="{{ route('report.create') }}?report={{'Letter'}}&id={{ @$data['Con_id'] }}" target="_blank" class="dropdown-item text-primary"><i class="fas fa-file-alt fs-5"></i> ฟอร์มจดหมาย</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            /*
            $('[data-bs-toggle="popover"]').popover({
                html: true,
                trigger: 'hover',
            })
            */
            $('#popover_memo_con').popover({
                html: true,
                trigger: 'focus',
            });
        })
    </script>
