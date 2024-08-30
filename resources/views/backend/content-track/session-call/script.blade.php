<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js')}}"></script>
@include('public-js\reRender')

{{-- icon on select tab --}}
<script>
    $(document).on('click', '.tabSelected', function(e) {
        var Tabli = $(this).attr('id');
        if(Tabli == 'tracktab'){
            $(".SaveDT").removeClass("d-none");
            $("#SaveAROTH").addClass("d-none");
            $("#SaveIntoArea").addClass("d-none");
        }
        else if(Tabli == 'tracklist'){
            $(".SaveDT").addClass("d-none");
            $("#SaveAROTH").addClass("d-none");
            $("#SaveIntoArea").addClass("d-none");
        }
        else if(Tabli == 'switch1'){
            $(".SaveDT").addClass("d-none");
            $("#SaveAROTH").removeClass("d-none");
            $("#SaveIntoArea").addClass("d-none");
        }
        else if(Tabli == 'switch2'){
            $(".SaveDT").addClass("d-none");
            $("#SaveAROTH").addClass("d-none");
            $("#SaveIntoArea").removeClass("d-none");
        }
    });
</script>

{{-- select score --}}
<script>
    $(document).on('click', '.score', function(e) {
        var Getscore = $(this).text();

        var idName = $(this).attr("id");
        var id = idName.split("-");

        $(`.score`).removeClass('btn-primary text-white');
        $(`.active-${idName}`).addClass('btn-primary text-white');
        // console.log(Getscore);
        if(Getscore == 1){
            $("#RESULT").val($("#Score1").text());
            $("#DDATE").removeAttr("required",true);
            $("#MustPay").removeAttr("required",true);
        }
        else if(Getscore == 2){
            $("#RESULT").val($("#Score2").text());
            $("#DDATE").removeAttr("required",true);
            $("#MustPay").removeAttr("required",true);
        }
        else if(Getscore == 3){
            $("#RESULT").val($("#Score3").text());
            $("#DDATE").removeAttr("required",true);
            $("#MustPay").removeAttr("required",true);
        }
        else if(Getscore == 4){
            $("#RESULT").val($("#Score4").text());
            $("#DDATE").removeAttr("required",true);
            $("#MustPay").removeAttr("required",true);
        }
        else if(Getscore == 5){
            $("#RESULT").val($("#Score5").text());
            $("#DDATE").attr("required",true);
            $("#MustPay").attr("required",true);
        }
        $("#RESULT_SCORE").val(Getscore);
    });
</script>

{{-- Drag Modal --}}
<script>
    $('.modal-content').resizable({
        minHeight: 300,
        minWidth: 300
    });
    $('.modal-dialog').draggable({
        handle: "#Modal-drag"
    });
</script>

{{-- on-off tab extra --}}
<script>
  $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
  $("#Setswitch1").click(function(){
    if($(this).prop('checked')) {
        $("#switch1").removeClass('d-none');
    } else {
        $("#switch1").addClass('d-none');
    }
  });
  $("#Setswitch2").click(function(){
    if($(this).prop('checked')) {
        $("#switch2").removeClass('d-none');
    } else {
        $("#switch2").addClass('d-none');
    }
  });
  $("#STATUS_TRACK").click(function(){
    var status_track = $(this).val();
    if(status_track == 'ลงพื้นที่') {
        $("#switch2").removeClass('d-none');
    } else {
        $("#switch2").addClass('d-none');
    }
  });
</script>

{{-- validate form --}}
<script>
    function validateForms(dataform) {
        var isvalid = false;
        Array.prototype.slice.call(dataform).forEach(function(form) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.classList.add('was-validated');
                isvalid = false;
            } else {
                isvalid = true;
            }
        });
        return isvalid;
    }
</script>

{{-- open modal 2 --}}
<script>
    $(document).ready(function(){
        $(".Modal2").on('click',function(e) {
            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            $('#ModalToggle2').modal('show');
            // $('.modal-content').addClass('bg-dark');
            $('#Modal-drag').css('z-index',1097200);
            e.preventDefault();
          let id = $(this).attr('id');
          var loanType = $(this).attr('loanType');

          $.ajax({
            url: '{{ route('datatrack.edit',0) }}',
            method: 'get',
            data: {id: id,_token: '{{ csrf_token() }}',loanType:loanType,page:'edit-tracklist'},
            success: function(response) {
              $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
              $("#ID").val(response.data.id);
              $("#INPUTDT_ED").val(response.data.INPUTDT);
              $("#DDATE_ED").val(response.data.DDATE);
              $("#DDATE_ED").val(response.data.DDATE);
              $("#MinPay_ED").val(response.data.MinPay);
              $("#MustPay_ED").val(response.data.PAYDUE);
              $("#PASS_ED").val(response.data.PASS);
              $("#NOTE_ED").val(response.data.NOTE);
            }
          });
        });
        $('#CloseModal2').click(function(){
          $('#ModalToggle2').modal('hide');
          $("#ConstantData input[type=text], textarea").val("");
        });
    });
</script>

{{-- Save Trackings --}}
<script>
  $(".SaveDT").click(function(){

    var dataform = document.querySelectorAll('#formDA');
    var validate = validateForms(dataform);
    var data = $('#formDA').serialize();
    var result = $('#RESULT').val();

    if (validate == true) {
        $('.SaveDT').prop('disabled', true);
        $('.addSpin').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin");

        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            data:data,

            success: function(result) { //
              $('#modal_lg').modal('hide');
              $('#modal_xl').modal('hide');
              $('#modal-xxl').modal('hide');
              $('.modal-backdrop').hide();
              $('#SaveDT').prop('disabled', false);
              $('.addSpin').empty();
              swal.fire({
                icon : 'success',
                title : 'บันทึกข้อมูลสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
            //   $("#HistoryDetails").html(result);
              $("#TrackDetails").html(result.html);
              appendDataByColumnValue('CONTNO', result.CONTNO, { stdept: result.RESULT , Appointment : result.DDATE },".createContract")
            }
        });
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
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

{{-- update Trackings --}}
<script>
    $("#UpdateDT").click(function(){
        var dataform = document.querySelectorAll('#update-detail');
        var validate = validateForms(dataform);
        var data = $('#update-detail').serialize();

        if (validate == true) {
            $.ajax({
                url: "{{ route('datatrack.update',0) }}",
                method: 'PUT',
                data:data,

                success: function(result) {
                    $('#ModalToggle2').modal('hide');
                    $('#modal_lg').modal('hide');
                    $('#modal_xl').modal('hide');
                    // $('.savetrack').removeClass('active');
                    // $('.history').addClass('active');
                    // $('#DDATE').val('');
                    // $('#RESULT').val('');
                    // $('.OtherCall').val('');
                    // $('#NOTE').val('');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#TrackDetails").html(result);
                    // $("#HistoryDetails").html(result);
                }
            });
        }
    });
</script>

{{-- Create Track Fee --}}
<script>
  $("#SaveAROTH").click(function(){

    // var data = {};$("#formAroth").serializeArray().map(function(x){data[x.name] = x.value;});
    var TextAroth = $("#BILL").val();
    var dataform = document.querySelectorAll('#formAroth');
    var validateAroth = validateForms(dataform);
    var data = $('#formAroth').serialize();

    if (validateAroth == true) {

    // if ($("#formAroth").valid() == true) {
        $('#SaveAROTH').prop('disabled', true);
        $('.addSpin').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin");

        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              page: 'store-aroth-track',
              data:data,
            },

            success: function(result) {
              $('#modal_lg').modal('hide');
              $('#modal_xl').modal('hide');
              swal.fire({
                icon : 'success',
                title : 'บันทึกข้อมูลสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
              $("#TextAroth").text(TextAroth);
              $("#ArotherDetails").html(result);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: `ERROR ` + err.status + ` !!!`,
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                });
                $('#modal_lg').modal('hide');
                $('#modal_xl').modal('hide');
            }
        });
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
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

{{-- Create Into Area Fee --}}
<script>
  $("#SaveIntoArea").click(function(){

    var dataform = document.querySelectorAll('#formIntoArea');
    var validateArea = validateForms(dataform);
    var data = $('#formIntoArea').serialize();
    var data = {};$("#formIntoArea").serializeArray().map(function(x){data[x.name] = x.value;});

    var TextNote = $("#summernote").val();
    if(TextNote != ''){
        $(".note-frame").removeAttr('style');
    }

    if (validateArea == true) {
    // if ($("#formIntoArea").valid() == true) {

        $('#SaveIntoArea').prop('disabled', true);
        $('.addSpin').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin");

        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            // data:{
            //   _token:'{{ csrf_token() }}',
            //   page: 'store-intoArea',
            //   data:data,
            // },
            data:data,

            success: function(result) {
              $('#modal_lg').modal('hide');
              $('#modal_xl').modal('hide');
              swal.fire({
                icon : 'success',
                title : 'บันทึกข้อมูลสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
              $("#ArotherDetails").html(result);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: `ERROR ` + err.status + ` !!!`,
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                });
                $('#modal_lg').modal('hide');
                $('#modal_xl').modal('hide');
            }
        });
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
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

{{-- preview image --}}
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#Image1").change(function() {
        readURL(this);
    });
</script>

{{-- Delete Job Aro --}}
<script type="text/javascript">
  $(function() {
    $(".DelAroth").click( function() {
      moveAroth('{{@$contract->id}}' ,$(this).data('id'), $(this).data('title'), $(this).data('loan'),$(this).data('cusid'))
    });
  });
  function moveAroth(pact_id, id, title, loan, cusid){
    //------------------------------------------------------
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "ยกเลิกใบเสร็จ " + title,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    })
    .then( (value) => {
      if (value.isConfirmed) { // กด OK
        var page = 'del-aroth';
        var _url = "{{ route('datatrack.destroy', ':id' ) }}";
        _url = _url.replace(':id', id);
        $.ajax({
          url: _url,
          method:"DELETE",
          data:{page:page,_token:'{{ csrf_token() }}',pact_id:pact_id,loan:loan,cusid:cusid},
			success:function(result){ //เสร็จแล้วทำอะไรต่อ
				Swal.fire({
					icon: 'success',
					// title: 'ยกเลิกสำเร็จ!',
					text: "ยกเลิกใบเสร็จเรียบร้อย",
					timer: 3000
				});
				$("#ArotherDetails").html(result);
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
        // Swal.fire('Changes are not saved', '', 'info');
      }
    });
  }
</script>

<script>
  $(document).on('click', '.Modal-xxl', function(e) {
    $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
    e.preventDefault();

    var url = $(this).attr('data-link');
    $('#Modal-xxl .Modal-xxl').load(url, function(response, status, xhr) {
      if (status === 'success') {
        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        $('#Modal-xxl').modal('show');
      } else {
        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

        if (xhr.status == 401) {
          Swal.fire({
            icon: 'error',
            title: xhr.status + ' ' + xhr.statusText + ` !!!`,
            text: response,
            showConfirmButton: true,
            // timer: 1500
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: xhr.status + ' ' + xhr.statusText + ` !!!`,
            text: response,
            showConfirmButton: true,
            // timer: 1500
          });
        }
      }
    });
  });
</script>

{{-- show map --}}
<script>
  $("#ShowMaps").click(function(){
    $("#map").toggle();
  });
</script>
