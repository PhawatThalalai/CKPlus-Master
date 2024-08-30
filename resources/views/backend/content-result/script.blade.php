<script>
    $(function() {

        // let currentDate = document.getElementById('date-input').valueAsDate = new Date();
        // console.log(currentDate);

        var MonthHidden = $('#MonthHidden').val();
        var page = $('#page').val();
        var filterdetail = $('#filter-detail').val();
 
        let data = {};


        if (page == 'monthly') {
            document.getElementById("month").selectedIndex = MonthHidden;
        }


        $('#searchDailyBtn').click(function() {

            $('#filter-detail-daily').serializeArray().map(function(x) {
                data[x.name] = x.value;
            });
            console.log(data);

            $.ajax({
                url: '{{ route('spast.show', 0) }}',
                type: 'GET',
                data: {
                    page: 'daily',
                    _token: '{{ @CSRF_TOKEN() }}',
                    data : data
                },
                success: (res) => {
                    $(".content-loading").fadeOut().attr('style',
                        'display:none !important'); // ** ซ่อนตัวโหลด **
                    $('#contentTable').html('');
                    $('#contentTable').html(res.html).slideDown('slow');
                },
                error: (err) => {
                    console.log(err);
                }

            })

        });

        $('#searchMonthlyBtn').click(function() {
            // $('#showAll').hide();
            // $(".content-loading").fadeIn().attr('style', '');

            //** แสดงตัวโหลด **
            $('#filter-detail').serializeArray().map(function(x) {
                data[x.name] = x.value;
            });
            console.log(data);
            $('#show-all-table').DataTable({

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
                serverSide: true,
                ordering: true,
                columnDefs: [{
                    orderable: false,
                    targets: "no-sort"
                }],
                scrollX: true,

                ajax: {
                    url: '{{ route('spast.show', 0) }}',
                    type: 'GET',
                    data: {
                        page: 'monthly',
                            data : data,
                        _token: '{{ @CSRF_TOKEN() }}'
                    },

                },


                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'Name_Branch'
                    },
                    {
                        data: 'CON_NO'
                    },
                    {
                        data: 'Name_Cus'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'DUEDATE'
                    },
                    {
                        data: 'TOTUPAY'
                    },
                    {
                        data: 'EXPREAL'
                    },
                    {
                        data: 'NEXT_EXPREAL'
                    },
                    {
                        data: 'SWEXPPRD'
                    },
                    {
                        data: 'EXP_FRM'
                    },
                    {
                        data: 'EXP_TO'
                    },
                    {
                        data: 'NEXT_KDAMT'
                    },
                    {
                        data: 'LPAYD'
                    },
                    {
                        data: 'LPAYA'
                    },
                    {
                        data: 'PAYINT'
                    },
                    {
                        data: 'stdept'
                    },
                ],
                bDestroy: true,
            });

            // $(".content-loading").fadeOut().attr('style','display:none !important'); // ** ซ่อนตัวโหลด **
            // $.ajax({
            //     url: '{{ route('spast.show', 0) }}',
            //     type: 'GET',
            //     data: {
            //         page: 'monthly',
            //         month: $('#month').val(),
            //         branch: $('#branch').val(),
            //         // DateHidden : $('#DateHidden').val(),
            //         // DateHidden : $('#DateHidden').val(),
            //         // DateHidden : $('#DateHidden').val(),

            //         _token: '{{ @CSRF_TOKEN() }}'
            //     },
            //     success: (res) => {
            //         console.log(res);
            //         $(".content-loading").fadeOut().attr('style',
            //         'display:none !important'); // ** ซ่อนตัวโหลด **
            //         $('#showAll').html(res.html).slideDown('slow');
            //         $('#contentTable').html(res)
            //     },
            //     error: (err) => {
            //         console.log(err);
            //     }

            // })

        });


        $('#clearBtn').click(function() {
            document.getElementById("filter-detail").reset();
        });
        // $('#date-input').on('change input', () => {
        //     let currentDate = $('#date-input').val();
        //     console.log(currentDate);
        // })

    })
</script>
