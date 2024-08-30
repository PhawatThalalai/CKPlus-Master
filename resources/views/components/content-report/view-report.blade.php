<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">
<section class="content" style="font-family: 'Prompt', sans-serif;">
    <div class="modal-content">
        <div class="d-flex m-3">
            <div class="flex-shrink-0 me-2">
                <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                <lord-icon src="https://cdn.lordicon.com/rfbqeber.json" trigger="loop" style="width:50px;height:50px">
                </lord-icon>
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">{{ $data['reportTitle'] != '' ? $data['reportTitle'] : 'รายงาน (Report)' }}</h4>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form name="Report_Contract" id="formdata" target="_blank" class="form-Validate" action="{{ route('ReportAcc.create') }}" method="GET" enctype="multipart/form-data">
            @csrf
            @method('put')
        {{--================================================
            body form input
            ================================================ --}}
            @include('components.content-report.input')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary waves-effect waves-light">
                    <i class="bx bxs-printer me-1"></i> พิมพ์
                </button>
            </div>
        </form>
    </div>
</section>
<script>
    $(document).ready(function () {
       // $('#slEmpy').prop('disabled', true);
        
        // ================================================
        // func get user role financial follow zone
        // ================================================
        // $("#slZone").change(function() {
        //     $('#slEmpy').prop('disabled', true);
        //     var selectedValue = $(this).val();
        //     $("#slEmpy").html("<option value='%' selected>--- เจ้าหน้าที่ ---</option>").slideDown('slow');
        //     if (selectedValue === '%') {
        //         $('#slEmpy').prop('disabled', true);
        //     }
        //     let data = {};
        //     $("#formdata").serializeArray().map(function(x) {
        //         data[x.name] = x.value;
        //     });

        //     $.ajax({
        //         url: "{{ route('ReportAcc.getRole') }}",
        //         type: "GET",
        //         data: {
        //             data: data,
        //             getName: 'empy',
        //             token: "{{ csrf_token() }}",
        //         },
        //         success: async function(res) {
        //             $('#slEmpy').prop('disabled', true);
        //             if (res.body.length != 0) {
        //                 $('#slEmpy').prop('disabled', false);
        //                 const selectOPEL = document.getElementById('slEmpy');
        //                 for(const items of res.body) {
        //                     const option = document.createElement("option");
        //                     option.value = items.id;
        //                     option.text = items.name;
        //                     selectOPEL.add(option);
        //                 }
        //             }
        //         },
        //         error: async function(err) {
        //             console.log(err);
        //         }
        //     });
        // });

        // $("#formdata").submit(function(e) {
        //     e.preventDefault();
        //     $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        //     let data = {};
        //     $("#formdata").serializeArray().map(function(x) {
        //         data[x.name] = x.value;
        //     });
        //     $.ajax({
        //         url: "{{ route('ReportAcc.create') }}",
        //         type: "GET",
        //         data: data,
        //         success: async function(res) {
        //             $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        //             const UrlParams = data;
        //             window.open("{{ route('ReportAcc.create') }}" + '?' + new URLSearchParams(UrlParams),"_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");
        //         },
        //         error: async function(err) {
        //             $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        //         }
        //     });
        // });
    });
</script>