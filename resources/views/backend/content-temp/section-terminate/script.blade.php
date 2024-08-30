{{-- select contract terminate --}}
<script>
    $(".terminate").click(function(){
        let id = $(this).data('id');
        let pageSub = $(this).data('sub');

        $.ajax({
            url: "{{ route('account.show',0) }}",
            type : 'GET',
            data : {
                page : 'terminate-letter',
                id : id,
                pageSub : pageSub,
                _token : '{{ @csrf_token() }}'
            },

            success: function(result) {
                $('#data-modal-search').modal('hide');
                $(".header_btnSearch").attr('disabled',true);
                $("#info").html(result);
                $("#card-1").addClass('d-none');
                $("#card-2").removeClass('d-none');
                if(pageSub != ''){
                    $("#PrintBTN").removeAttr('disabled',true);
                    $("#CancleBTN").removeAttr('disabled',true);
                }
                else{
                    $("#SaveBTN").removeAttr('disabled',true);
                    $("#CancleBTN").removeAttr('disabled',true);
                }
                swal.fire({
                    icon : 'success',
                    title : 'ค้นหาข้อมูลสำเร็จ',
                    timer: 1500,
                    showConfirmButton: false,
                })
            }
        });
    });
</script>

<script>
    $(function() {
        var GetCont = $("#CONTNO").val();
        if(GetCont != ""){
            $("#PrintBTN").removeAttr('disabled',true);
            $("#SaveBTN").removeAttr('disabled',true);
            $("#CancleBTN").removeAttr('disabled',true);
        }
    });
</script>

{{-- Save Trackings --}}
<script>
    $("#SaveBTN").click(function(){

        var dataform = document.querySelectorAll('#form_terminate');
        var validate = validateForms(dataform);
        var data = $('#form_terminate').serialize();
            
        if (validate == true) {
            $.ajax({
                url: "{{ route('account.store') }}",
                method: 'POST',
                data:data,

                success: function(result) {
                    swal.fire({
                        icon : 'success',
                        title : 'บันทึกข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $('#form_terminate').removeClass('was-validated');
                    $("#PrintBTN").removeAttr('disabled',true);
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: `ERROR ` + err.status + ` !!!`,
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                    });
                }
            });
        }
        else{
            swal.fire({
                icon : 'warning',
                title : 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 2000,
                showConfirmButton: false,
            })
        }      
    });
</script>

<script>
    $(function() {
        $("#CancleBTN").click(function() {
            $('#form_terminate').removeClass('was-validated');
            $('form :input').val('');
            $(".header_btnSearch").removeAttr('disabled',true);
            $("#card-1").removeClass('d-none');
            $("#card-2").addClass('d-none');
        });
    });
</script>

{{-- call print option --}}
<script>
    $("#PrintBTN").click(function(){
        var data = {};$("#form_terminate").serializeArray().map(function(x){data[x.name] = x.value;});
        let pact_id = $("#pact_id").val();
        let codloan = $("#loanType").val();
        let candate = $("#LASTCANDT").val();
        let url = "{{ route('report-backend.create') }}?page={{'rp-terminate'}}&pact_id={{':pact_id'}}&codloan={{':codloan'}}";
            url = url.replace(':pact_id', pact_id);
            url = url.replace(':codloan', codloan);
        // window.open(url);
        $.ajax({
            url: url,
            method: 'GET',
            // data:data,
            success: function(result) {
                $('#md_loanType').val(codloan);
                $('#md_pact_id').val(pact_id);
                $('#DateTerminate').val(candate);
                $('#myModal').modal('show');
            },
        });
    
    });
</script>

{{-- Print btn --}}
<script>
    $("#PrintData").click(function(){
        let id = $("#md_pact_id").val();
        let codloan = $("#md_loanType").val();
        let datePrint = $("#DatePrint").val();
        let dateTerminate = $("#DateTerminate").val();
        let staff = $("#NameStaff").val();
        let Note = $("#Note").val();
        let url = "{{route('report-backend.show', ':id')}}?page={{'rp-terminate'}}&codloan={{':codloan'}}&datePrint={{':datePrint'}}&dateTerminate={{':dateTerminate'}}&Note={{':Note'}}&staff={{':staff'}}";
            url = url.replace(':id', id);
            url = url.replace(':datePrint', datePrint);
            url = url.replace(':dateTerminate', dateTerminate);
            url = url.replace(':codloan', codloan);
            url = url.replace(':Note', Note);
            url = url.replace(':staff', staff);
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=20,left=100,width=1200,height=600");     
    });
</script>

<script>
    $(".header_btnSearch,.header_btnSearch2").click(function() {
        $('.data-modal-search').modal('show');
    });
</script>


<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>