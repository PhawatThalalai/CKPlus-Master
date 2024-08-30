
<script>
  $(function () {
    $('[data-mask]').inputmask()
  });
</script>

{{-- Select type Search --}}
<script type="text/javascript">
  $('#Search_value2').hide();
  $('#Search_value3').hide();
  
  $('#Search_type').on("input" ,function() {
    var Gettype = $('#Search_type').val();
    if(Gettype == 1){
      $('#Search_value').show();
      $('#Search_value2').hide();
      $('#Search_value3').hide();

      $('#Search_value2,#Search_value3').val('');
    }
    else if(Gettype == 2){
      $('#Search_value').hide();
      $('#Search_value2').show();
      $('#Search_value3').hide();

      $('#Search_value,#Search_value3').val('');
    }
    else if(Gettype == 3){
      $('#Search_value').hide();
      $('#Search_value2').hide();
      $('#Search_value3').show();

      $('#Search_value,#Search_value2').val('');
    }
  });
</script>

{{-- Search Customers --}}
<script>
  $(function() {
    $("#btn_searchCus").click(function(){
      var FlagPage = $('#FlagPage').val();
      var SearchType = $('#Search_type').val();
      var type = 1;
      var _token = $('input[name="_token"]').val();

      if(SearchType == 1){
        var SearchValue = $('#Search_value').val();
      }
      else if(SearchType == 2){
        var SearchValue = $('#Search_value2').val();
      }
      else if(SearchType == 3){
        var SearchValue = $('#Search_value3').val();
      }

      if (SearchValue != '') {
        $.ajax({
          url:"{{ route('DataCustomer.SearchData') }}",
          method:"post",
          data:{SearchType:SearchType,SearchValue:SearchValue,_token:_token,type:type,FlagPage:FlagPage
            @if( @$FlagPage == 3 ) // ค้นหาผู้ค้ำ ให้ส่งตัวแปรเพิ่มอีก 2 อย่าง เอาไปกรอง
              ,contractId: '{{@$contractId}}',
              cusId: '{{@$cusId}}'
            @endif
          },

          success:function(result){
            $('#DataSearch').html(result);
          }
        })
      }
    });
  })
</script>

{{-- Search Brokers --}}
<script>
  $(function() {
    $("#btn_searchBroker").click(function(){
      var FlagPage = $('#FlagPage').val();
      var SearchType = $('#Search_type').val();
      var type = 1;
      var _token = $('input[name="_token"]').val();

      if(SearchType == 1){
        var SearchValue = $('#Search_value').val();
      }
      else if(SearchType == 2){
        var SearchValue = $('#Search_value2').val();
      }
      else if(SearchType == 3){
        var SearchValue = $('#Search_value3').val();
      }

      if (SearchValue != '') {
        $.ajax({
          url:"{{ route('DataBroker.SearchData') }}",
          method:"post",
          data:{SearchType:SearchType,SearchValue:SearchValue,_token:_token,type:type,FlagPage:FlagPage},

          success:function(result){ //เสร็จแล้วทำอะไรต่อ
            $('#Dataresoure').html(result);
          }
        })
      }
    });
  })
</script>

{{-- Search Assets --}}
<script type="text/javascript">
  $('#SearchAsset_type').on("input" ,function() {
    var Gettype = $('#SearchAsset_type').val();
    if (Gettype != null) {
      // ปิด disabled
      $("#Search_idCard").prop( "disabled", false );
      // Refresh
      $("input[name^='Search_']").val('');
      $("input[name^='Search_']").hide();
      $('#Search_' + Gettype).show();
      $('#Search_' + Gettype).focus();
    }
  });

  $(function() {
    $("#btn_searchAsset").click( async function(){
      var SearchType = $('#SearchAsset_type').val();
      var type = 1;
      var mode = 'query';
      var _token = $('input[name="_token"]').val();

      if (SearchType != null) {
        var SearchValue = $('#Search_' + SearchType).val();
        if (SearchValue != '') {

          $('#btn_searchAsset').prop('disabled', true);
          $('<span />', {
            class : "spinner-border spinner-border-sm",
            role : "status"
          }).appendTo(".addSpin");
          
          await $.ajax({
            url:"{{ route('DataAsset.SearchData') }}",
            method:"post",
            data:{SearchType:SearchType,SearchValue:SearchValue,_token:_token,type:type,mode:mode},

            success: function(result){ //เสร็จแล้วทำอะไรต่อ
              $('#Dataresoure').html(result);

              $('.addSpin').html('')
              $('#btn_searchAsset').prop('disabled', false);
            }
          })
        }
      }
    });
  })
</script>

{{-- All Fuctions --}}
<script>
  function EnterToSubmit(inputTagId, submitBtnId) {
    // Get the input field
    var _input = document.getElementById(inputTagId);
    // Execute a function when the user presses a key on the keyboard
    _input.addEventListener("keypress", function(event) {
      // If the user presses the "Enter" key on the keyboard
      if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        $("#" + submitBtnId).click();
      }
    });
  }
</script>

{{-- Search inside Contract --}}
<script>
  $(function() {
    // select Search
    $('#MainSelect li').click(function(){
      var type = this.id;
      if (type == 1) {
        $('#1').addClass('active');
        $('#2,#3').removeClass('active');

        $(".input-search").inputmask("999999999999");
        $(".input-search").val('');
        $(".input-search").attr("placeholder", "เลขที่สัญญา");
      }
      else if (type == 2) {
        $('#2').addClass('active');
        $('#1,#3').removeClass('active');

        $(".input-search").inputmask("remove");
        $(".input-search").val('');
        $(".input-search").attr("placeholder", "ชื่อ-นามสกุล");
      }
      else if (type == 3) {
        $('#3').addClass('active');
        $('#1,#2').removeClass('active');

        $(".input-search").inputmask("remove");
        $(".input-search").val('');
        $(".input-search").attr("placeholder", "ป้ายทะเบียน");
      }
      $('#TypeSelect').val(type);
    });

    $("#btn_SearchCont").click(function(){
      var type = 1;
      var value = $('#input-search').val();
      var TypeSelect = $('#TypeSelect').val();
      var FlagPage = $('#FlagPage').val();
      
      if (value != '') {
        $("#overlay_loading").attr('style', '');
        $("#modal-search").modal('show');
        $("#modal-search .modal-body .showdata").html("");
        
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url:"{{ route('ControlInside.SearchData') }}",
          method:"POST",
          dataType: 'JSON',
          data:{value:value,TypeSelect:TypeSelect,FlagPage:FlagPage,type:type},

          success:function(result){
            $("#overlay_loading").attr('style', 'display:none !important');
            $("#modal-search .modal-body .showdata").html(result.html);
          }
        })
      }
    });
  })
</script>