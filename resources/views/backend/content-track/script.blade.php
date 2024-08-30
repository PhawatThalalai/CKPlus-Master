{{-- Code --}}
<script>
    $('#PAYFOR_CODE').on('change', function postinput(){
        var GetVal = $(this).val();
        var code = 'PAYFOR_CODE';
        var page = 'backend';
        if(GetVal != ''){
            $.ajax({
                // url: "{{ route('datatrack.show', 0) }}",
                url: "{{ route('constants.index') }}",
                method:"GET",
                data:{GetVal:GetVal,page:page,code:code,_token:'{{ csrf_token() }}'},
                success:function(respon){ //เสร็จแล้วทำอะไรต่อ
                    // console.log(respon.data);
                    if(respon.data != null){
                        $("#PAYFOR_NAME").val(respon.data.FORDESC);
                        $(".toast-success").toast({delay: 1000}); 
                        $(".toast-success").toast("show");
                    }
                    else{
                        $("#PAYFOR_CODE").val('');
                        $("#PAYFOR_NAME").val('');
                        $(".myToast2").toast({delay: 1000}); 
                        $(".myToast2").toast("show");
                    }
                }
            });
        }
        else{
            $("#PAYCODE").val('');
            $("#PAYNAME").val('');
        }
    });
    $('#FOLLOWCODE').on('change', function postinput(){
        var GetVal = $(this).val();
        var code = 'FOLCODE';
        var page = 'backend';
        if(GetVal != ''){
            $.ajax({
                url: "{{ route('constants.index') }}",
                method:"GET",
                data:{GetVal:GetVal,page:page,code:code,_token:'{{ csrf_token() }}'},
                // data:{type:2,page:'backend',_token:'{{ csrf_token() }}',GetVal:GetVal},
                success:function(respon){ //เสร็จแล้วทำอะไรต่อ
                    //   console.log(respon.data);
                    if(respon.data != null){
                        $("#FOLLOWNAME").val(respon.data.name);
                        $(".toast-success").toast({delay: 1000}); 
                        $(".toast-success").toast("show");
                    }
                    else{
                        $("#FOLLOWCODE").val('');
                        $("#FOLLOWNAME").val('');
                        $(".myToast2").toast({delay: 1000}); 
                        $(".myToast2").toast("show");
                    }
                }
            });
        }
        else{
            $("#FOLLOWCODE").val('');
            $("#FOLLOWNAME").val('');
        }
    });
    $('#SALECODE').on('change', function postinput(){
        var GetVal = $(this).val();
        var code = 'SALECODE';
        var page = 'backend';
        if(GetVal != ''){
            $.ajax({
                url: "{{ route('constants.index') }}",
                method:"GET",
                data:{GetVal:GetVal,page:page,code:code,_token:'{{ csrf_token() }}'},
                // data:{type:2,page:'backend',_token:'{{ csrf_token() }}',GetVal:GetVal},
                success:function(respon){ //เสร็จแล้วทำอะไรต่อ
                    //   console.log(respon.data);
                    if(respon.data != null){
                        $("#SALENAME").val(respon.data.name);
                        $(".toast-success").toast({delay: 1000}); 
                        $(".toast-success").toast("show");
                    }
                    else{
                        $("#SALECODE").val('');
                        $("#SALENAME").val('');
                        $(".myToast2").toast({delay: 1000}); 
                        $(".myToast2").toast("show");
                    }
                }
            });
        }
        else{
            $("#FOLLOWCODE").val('');
            $("#FOLLOWNAME").val('');
        }
    });
    $('#OLDCODE').on('change', function postinput(){
        var GetVal = $(this).val();
        var code = 'OLDSTAT';
        var page = 'backend';
        if(GetVal != ''){
            $.ajax({
                url: "{{ route('constants.index') }}",
                method:"GET",
                data:{GetVal:GetVal,page:page,code:code,_token:'{{ csrf_token() }}'},
                success:function(respon){ //เสร็จแล้วทำอะไรต่อ
                    console.log(respon.data);
                    if(respon.data != null){
                        $("#OLDNAME").val(respon.data.CONTDESC);
                        $(".toast-success").toast({delay: 1000}); 
                        $(".toast-success").toast("show");
                    }
                    else{
                        $("#OLDCODE").val('');
                        $("#OLDNAME").val('');
                        $(".myToast2").toast({delay: 1000}); 
                        $(".myToast2").toast("show");
                    }
                }
            });
        }
        else{
            $("#OLDCODE").val('');
            $("#OLDNAME").val('');
        }
    });
    $('#NEWCODE').on('change', function postinput(){
        var GetVal = $(this).val();
        var code = 'NEWSTAT';
        var page = 'backend';
        if(GetVal != ''){
            $.ajax({
                url: "{{ route('constants.index') }}",
                method:"GET",
                data:{GetVal:GetVal,page:page,code:code,_token:'{{ csrf_token() }}'},
                success:function(respon){ //เสร็จแล้วทำอะไรต่อ
                    // console.log(respon.data);
                    if(respon.data != null){
                        $("#NEWNAME").val(respon.data.CONTDESC);
                        $(".toast-success").toast({delay: 1000}); 
                        $(".toast-success").toast("show");
                    }
                    else{
                        $("#NEWCODE").val('');
                        $("#NEWNAME").val('');
                        $(".myToast2").toast({delay: 1000}); 
                        $(".myToast2").toast("show");
                    }
                }
            });
        }
        else{
            $("#NEWCODE").val('');
            $("#NEWNAME").val('');
        }
    });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd,#formDA').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

{{-- carousel --}}
<script>
    function PositionScroll(ElementID) {
      const element = document.getElementById(ElementID);
      let x = element.scrollLeft;
      let y = element.scrollTop;
      let result = 1 - (x/165) ;
      document.getElementById ("demo").innerHTML = "Horizontally: " + x.toFixed() + "<br>Vertically: " +result;
      let size = $('.resize').width();

      if (x >= 120){
        $('.showScroll').show();
      }else{
        $('.showScroll').hide();
          $('.resize').css('scale',`${result}`);
      }
    }
    function resetScroll(ElementID) {
      const element = document.getElementById(ElementID);
      element.scrollLeft = 0;
      PositionScroll(ElementID);
    }
</script>