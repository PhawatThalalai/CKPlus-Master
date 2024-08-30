<style>
    .custom-popover {
        --bs-popover-border-color: var(--bs-info);
        --bs-popover-header-bg: var(--bs-info);
        --bs-popover-header-color: var(--bs-white);
        --bs-popover-body-padding-x: 1rem;
        --bs-popover-body-padding-y: .5rem;
}

/* .contno {

  background: -webkit-linear-gradient(rgb(252, 79, 79), rgb(255, 230, 3));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
} */

</style>



<div class="table-responsive" style="min-height: 500px;">

    <div class="content-empty" style="display: none;">
        <div class="row">
            <div class="col m-auto pb-2">
                <span class="placeholder col-2 bg-secondary"></span>
            </div>
            <div class="col m-auto text-end pb-2">
                <span class="placeholder col-4 bg-secondary"></span>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover createContract align-middle w-100 h-100 table-sm text-center fs-6">
        <thead class="bg-info bg-soft text-secondary">
            <tr class="">
                {{-- <th>#</th> --}}
                <th class="text-center">เลขที่สัญญา</th>
                <th class="no-sort text-center">
                    <div class="btn-group">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" data-bs-auto-close="outside">
                            สถานะ <i class="mdi mdi-chevron-down i-filter-defult"></i> <i
                                class="bx bxs-filter-alt i-filter-has text-primary" style="display: none;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light h-auto text-dark p-2"
                            style="width:15rem; z-index : 999;">
                            <li>
                                <div class="">
                                    <div class="row">
                                        <div class="d-grid">
                                            <button class="btn btn-primary rounded-pill mb-1 btn-sm" type="button"
                                                disabled>สถานะ</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <form action="" id="formStatus">
                                                @foreach (@$statusdebt as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="StatusDebt[]"
                                                            value="{{ $item->NAME }}" id="{{ $item->NAME }}">
                                                        <label class="form-check-label" for="{{ $item->NAME }}">
                                                            {{ $loop->iteration }}. {{ $item->NAME }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-grid">
                                            <button class="btn btn-warning btn-clear rounded-pill mt-1 btn-sm"
                                                type="button" onclick="getBranchAll(1);">ล้างการค้นหา</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </th>
                <th class="text-center">ชื่อ-นามสกุล</th>
                <th class="no-sort text-center">
                        <div class="btn-group">
                            @if (@$flag == 'allBranch')
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-auto-close="outside">
                                    ทีมตาม <i class="mdi mdi-chevron-down i-filter-team-defult"></i> <i
                                        class="bx bxs-filter-alt i-filter-team-has text-primary"
                                        style="display: none;"></i>
                                </a>

                            <ul class="dropdown-menu dropdown-menu-light h-auto text-dark p-2" style="width:15rem;">
                                <li>
                                    <div class="">
                                        <div class="row">
                                            <div class="d-grid">
                                                <button class="btn btn-primary rounded-pill mb-1 btn-sm" type="button"
                                                    disabled>ทีมตาม</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div style="max-height : 15rem; overflow-y:scroll; overflow-x:hidden;">
                                                    <form action="" id="formTeam">
                                                            @foreach (@$branch as $item)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="BranchDebt[]" value="{{ $item->id }}"
                                                                       >
                                                                    <label class="form-check-label"
                                                                        for="{{ $item->name_billcoll }}">
                                                                        {{ $loop->iteration }}. {{ $item->name_billcoll }}
                                                                    </label>
                                                                </div>
                                                            @endforeach

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="d-grid">
                                                <button class="btn btn-warning btn-clear rounded-pill mt-1 btn-sm"
                                                    type="button" onclick="getBranchAll(1);">ล้างการค้นหา</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @else
                        จนท.ตาม
                    @endif
                </th>
                <th class="text-center">วันดีลงวด</th>
                <th class="no-sort text-center">
                    <div class="btn-group">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            กลุ่มค้างงวด <i class="mdi mdi-chevron-down i-filter-group-defult"></i> <i
                                class="bx bxs-filter-alt i-filter-group-has text-primary" style="display: none;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light text-dark h-auto p-2"
                            aria-labelledby="navbarDarkDropdownMenuLink" style="width:15rem; z-index : 999;">
                            <li>
                                <div class="">
                                    <div class="row">
                                        <div class="d-grid">
                                            <button class="btn btn-primary rounded-pill mb-1 btn-sm" type="button"
                                                disabled>กลุ่มค้างงวด</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <form action="" id="formGroupDebt">
                                                @foreach (@$groupdebt as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="GroupDebt[]" value="{{ $item->CODE }}"
                                                            id="{{ $item->CODE }}">
                                                        <label class="form-check-label" for="{{ $item->CODE }}">
                                                            {{ $item->CODE }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-grid">
                                            <button class="btn btn-warning btn-clear rounded-pill mt-1 btn-sm"
                                                type="button" onclick="getBranchAll(1);">ล้างการค้นหา</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </th>
                <th class="text-center">ยอดขั้นต่ำ</th>
                {{-- <th>วันที่ชำระล่าสุด</th> --}}
                <th class="text-center">วันที่นัดชำระ</th>
                {{-- <th class="no-sort">Detail</th> --}}
                <th class="no-sort text-center">Action</th>
            </tr>
        </thead>
        <tbody class="fs-6">
            @for ($i=1;$i<=10;$i++)
            <tr>
                {{-- <th>#</th> --}}
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td>
                {{-- <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td> --}}
                {{-- <td><span class="placeholder-glow"><span class="placeholder col-12"></span></span></td> --}}

            </tr>
            @endfor
        </tbody>
    </table>


</div>

<script>
    $(function() {
    $('[data-toggle="popover"]').popover({
        html: true,
    sanitize: false,
    })
    })
</script>

<script>
    $(function() {
        let GroupType = $('#GroupType').val()
        $('input[name="StatusDebt[]"] , input[name="GroupDebt[]"] , input[name="BranchDebt[]"] , input[name="SALECOD[]"]')
            .on('change', () => {
                manageChecked()

                var StatusDebt = $('input[name="StatusDebt[]"]:checked').map(function() {
                    return $(this).attr('id');
                }).get();

                var GroupDebt = $('input[name="GroupDebt[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                var BranchDebt = $('input[name="BranchDebt[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                var SALECOD = $('input[name="SALECOD[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                $(".createContract").DataTable({
                    processing: true, // for show progress bar,
                        "language": {
                        'processing': `
                            <span class="">
                                <span id="loading-spinner-ck" >
                                <img src="{{ URL::asset('/assets/images/CK-LOGO3.png') }}" alt=""  class="t rounded-circle" alt="">
                                <span class="spinner outer">
                                    <span class="spinner inner">
                                        <span class="spinner eye">
                                            <span >
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </span>`
                    },
                    pageLength: 10,
                    serverSide: true,
                    searching: true,
                    ordering: true,
                    columnDefs: [{
                        orderable: false,
                        targets: "no-sort"
                    }],
                    ajax: {
                        url : '{{ route('spast.store') }}',
                            type : 'POST',
                            data : {
                                StatusDebt : StatusDebt,
                                GroupDebt : GroupDebt,
                                BranchDebt : BranchDebt,
                                SALECOD : SALECOD,
                                GroupType : GroupType,
                                page : 'searchDebt',
                                _token : '{{ @CSRF_TOKEN() }}'
                            },
                    },
                    columns: [
                        { data: 'CONTNO' ,"className": "bg-info bg-soft fw-semibold text-secondary" },
                        { data: 'stdept' },
                        { data: 'Name_Cus' },
                        { data: 'BILLCOLL' },
                        { data: 'DUEDATE' },
                        { data: 'SWEXPPRD' },
                        { data: 'INSTALL'},
                        { data: 'Appointment' },
                        { data: 'trackFollow' },
                    ],
                    bDestroy: true,
                });
            })

    })


    manageChecked = () => {
       var StatusDebt = $('input[name="StatusDebt[]"]:checked').map(function() {
            return $(this).attr('id');
        }).get();

        var GroupDebt = $('input[name="GroupDebt[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var BranchDebt = $('input[name="BranchDebt[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        var SALECOD = $('input[name="SALECOD[]"]:checked').map(function() {
            return $(this).val();
        }).get();



        $('#filterStatus').html( StatusDebt.join(" / ") )
        $('#filterTeam').html( BranchDebt.join(" / ") )
        $('#filterGroupdebt').html( GroupDebt.join(" / ") )

        if (StatusDebt.length > 0) { // ตรวจสอบการกรอง
            $('#tabStatus').show()
            $('.i-filter-defult').hide()
            $('.i-filter-has').show()
        } else {
            $('#tabStatus').hide()
            $('.i-filter-defult').show()
            $('.i-filter-has').hide()
        }

        if (BranchDebt.length > 0) { // ตรวจสอบการกรอง
            $('#tabTeam').show()
            $('.i-filter-team-defult').hide()
            $('.i-filter-team-has').show()
        } else {
            $('#tabTeam').hide()
            $('.i-filter-team-defult').show()
            $('.i-filter-team-has').hide()
        }

        if (GroupDebt.length > 0) { // ตรวจสอบการกรอง
            $('#tabGroupdebt').show()
            $('.i-filter-group-defult').hide()
            $('.i-filter-group-has').show()
        } else {
            $('#tabGroupdebt').hide()
            $('.i-filter-group-defult').show()
            $('.i-filter-group-has').hide()
        }

        if (SALECOD.length > 0) { // ตรวจสอบการกรอง
            $('.i-filter-sale-defult').hide()
            $('.i-filter-sale-has').show()
        } else {
            $('.i-filter-sale-defult').show()
            $('.i-filter-sale-has').hide()
        }

        if(StatusDebt.length > 0 || BranchDebt.length > 0 || GroupDebt.length > 0 || SALECOD.length > 0){
            $('#clearBtn').show()
        } else {
            $('#clearBtn').hide()
        }

    }

    clearChecked = (form) => {
        if(form == 'all'){
            $('input[type=checkbox]').prop('checked', false);
        } else {
            $('#'+form+' input[type=checkbox]').prop('checked', false);
        }
        manageChecked()
    }


</script>
