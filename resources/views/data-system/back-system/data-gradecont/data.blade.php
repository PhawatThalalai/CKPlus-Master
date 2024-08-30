<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script> -->
<!-- <link href="{{ URL::asset('assets/css/jquery-editable.css') }}" rel="stylesheet"/> -->
<script src="{{ URL::asset('assets/js/jquery-editable.min.js') }}"></script>
<style>
    .editable-input input {
        width: 60px; /* Specify your desired width */
    }
    .editable-click, 
    a.editable-click, 
    a.editable-click:hover {
        color: black;
        text-decoration: none;
        border-bottom: none; /* Ensure no border-bottom is applied */
    }
    .table-container {
        position: relative;
        height: 60vh; /* Adjust the height as needed */
        overflow-y: auto;
    }
    .editable-striped-table tbody tr:nth-of-type(odd) {
        background-color: #e3f2fd; /* สีฟ้าอ่อนมาก */
    }
    .editable-striped-table tbody tr:nth-of-type(even) {
        background-color: #fffde7; /* สีเหลืองอ่อนมาก */
    }
    .editable-striped-table tbody tr:nth-of-type(odd):hover {
        background-color: #bbdefb; /* สีฟ้าเข้มขึ้นเมื่อ hover */
    }
    .editable-striped-table tbody tr:nth-of-type(even):hover {
        background-color: #fff9c4; /* สีเหลืองเข้มขึ้นเมื่อ hover */
    }
    .editable-table tbody tr td {
        cursor: pointer;
    }
    .editable-table tbody tr td:hover {
        background-color: #bfffbf
    }

    /* Dark mode styles */
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(odd) {
        background-color: #263238; /* สีเทาเข้ม */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(even) {
        background-color: #4f4b37; /* สีเทาเข้มขึ้น */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(odd):hover {
        background-color: #37474f; /* สีเทาเข้มขึ้นเมื่อ hover */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(even):hover {
        background-color: #646445; /* สีเทาเข้มขึ้นเมื่อ hover */
    }
    [data-layout-mode="dark"] .editable-table tbody tr td:hover {
        background-color: #5f7a54; /* สีเทาเข้มสำหรับ hover */
    }
</style>

<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">เกรดสัญญา ( TB_GRADECONT )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>
    <div class="table-responsive" data-simplebar="init" style="max-height: 500px;">
        <table class="table table-sm font-size-14 table-bordered border-primary editable-table editable-striped-table">
            <thead class="table-dark sticky-top">
                <tr>
                    <!-- <th scope="col">Action</th> -->
                    <th scope="col" class="text-center" style="width: 70px;">OVERDUE</th>
                    <th scope="col">  PAY02  </th>
                    <th scope="col">  PAY04  </th>
                    <th scope="col">  PAY06  </th>
                    <th scope="col">  PAY08  </th>
                    <th scope="col">  PAY10  </th>
                    <th scope="col">  PAY12  </th>
                    <th scope="col">  PAY14  </th>
                    <th scope="col">  PAY16  </th>
                    <th scope="col">  PAY18  </th>
                    <th scope="col">  PAY20  </th>
                    <th scope="col">  PAY22  </th>
                    <th scope="col">  PAY24  </th>
                    <th scope="col">  PAY26  </th>
                    <th scope="col">  PAY28  </th>
                    <th scope="col">  PAY30  </th>
                    <th scope="col">  PAY32  </th>
                    <th scope="col">  PAY34  </th>
                    <th scope="col">  PAY36  </th>
                    <th scope="col">  PAY38  </th>
                    <th scope="col">  PAY40  </th>
                    <th scope="col">  PAY42  </th>
                    <th scope="col">  PAY44  </th>
                    <th scope="col">  PAY46  </th>
                    <th scope="col">  PAY48  </th>
                    <th scope="col">  PAY50  </th>
                    <th scope="col">  PAY52  </th>
                    <th scope="col">  PAY54  </th>
                    <th scope="col">  PAY56  </th>
                    <th scope="col">  PAY58  </th>
                    <th scope="col">  PAY60  </th>
                    <th scope="col">  PAY62  </th>
                    <th scope="col">  PAY64  </th>
                    <th scope="col">  PAY66  </th>
                    <th scope="col">  PAY68  </th>
                    <th scope="col">  PAY70  </th>
                    <th scope="col">  PAY72  </th>
                    <th scope="col">  PAY74  </th>
                    <th scope="col">  PAY76  </th>
                    <th scope="col">  PAY78  </th>
                    <th scope="col">  PAY80  </th>
                    <th scope="col">  PAY82  </th>
                    <th scope="col">  PAY84  </th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr>
                        <td class="text-center">
                            <div class="avatar-xs text-center">
                                <span class="avatar-title rounded-circle bg-dark bg-gradient text-center">
                                    {{str_replace(" ","",$value->OVERDUE)}}
                                </span>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY02" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY02 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY04" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY04 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY06" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY06 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY08" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY08 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY10" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY10 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY12" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY12 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY14" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY14 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY16" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY16 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY18" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY18 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY20" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY20 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY22" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY22 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY24" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY24 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY26" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY26 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY28" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY28 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY30" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY30 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY32" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY32 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY34" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY34 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY36" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY36 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY38" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY38 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY40" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY40 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY42" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY42 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY44" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY44 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY46" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY46 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY48" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY48 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY50" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY50 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY52" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY52 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY54" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY54 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY56" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY56 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY58" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY58 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY60" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY60 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY62" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY62 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY64" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY64 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY66" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY66 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY68" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY68 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY70" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY70 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY72" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY72 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY74" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY74 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY76" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY76 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY78" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY78 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY80" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY80 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY82" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY82 }}</a>
                        </td>
                        <td>
                            <a href="#" class="update_record" data-name="PAY84" data-type="text" data-pk="{{$value->OVERDUE}}" data-title="Enter Grade">{{ $value->PAY84 }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
   
    $.fn.editable.defaults.mode = 'inline';
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
 
    $('.update_record').editable({
        url: "{{ route('dataStatic.update',0)}}",
        type: 'text',
        name: 'product_name',
        pk: 1,
        title: 'Enter Field',
        ajaxOptions: {
            type: 'put',
        },
        params: function(params) {
            // Add more parameters here
            params.update = 'gradecont';
            return params;
        },
        success: function(response, newValue) {
            // console.log('Success:', response);
            $(".toast-success").toast({
                delay: 5000
            }).toast("show");
            $(".toast-success .toast-body .text-body").text('อัพเดทสำเร็จ');
        },
        // error: function(response, newValue) {
        //     // Handle the error response here if needed
        //     console.log('Error:', response);
        // }
    }).on('shown', function(e, editable) {
        $(editable.input.$input).addClass('form-control form-control-sm col-1');
        $('.editable-submit').addClass('btn btn-sm btn-success');
        $('.editable-submit').empty();
        $('.editable-submit').append('<i class="mdi mdi-check"></i>'); // Example using Font Awesome icon
        $('.editable-cancel').addClass('btn btn-sm btn-danger');
        $('.editable-cancel').empty();
        $('.editable-cancel').append('<i class="mdi mdi-close"></i>'); // Example using Font Awesome icon
    });
</script>