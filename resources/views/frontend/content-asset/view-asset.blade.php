<style>
  .assetView-nodata-card {
    min-height: 46rem;
    max-height: 46rem;
    background-image: linear-gradient(to bottom, rgba( var(--bs-light-rgb), 0.6) 0%,rgba( var(--bs-light-rgb),0.9) 100%),url('{{ asset('assets/images/undraw/undraw_empty_street.svg') }}');
  }
  .assetView-card-body-4-card, .assetView-card-body-2-card {
    background-image: linear-gradient(to bottom, rgba( var(--bs-light-rgb), 0.6) 0%,rgba( var(--bs-light-rgb),0.9) 100%), url('{{ asset('assets/images/undraw/undraw_empty_street.svg') }}');
  }
</style>

<style>

  .circular-menu {
    --menu-radius: 7em; /* รัศมีของวงกลม */
    --menu-items: 12; /* จำนวนเมนู */
    --rotation-offset: -10deg; /* ตำแหน่งเริ่มต้นของเมนู (offset การหมุน) */

    position: relative;
    bottom: 1em;
    right: 1em;
    font-size: large;
  }

  .circular-menu .floating-btn {
    display: block;
    width: 3.5em;
    height: 3.5em;
    border-radius: 50%;
    background-color: hsl(4, 98%, 60%);
    /* box-shadow: 0 2px 5px 0 hsla(0, 0%, 0%, .26);  */
    box-shadow: 0 4px 10px 0 hsla(0, 0%, 0%, .26);  
    color: rgb(59, 130, 246);
    text-align: center;
    line-height: 3.9;
    cursor: pointer;
    /* outline: 0; 
    outline: thick solid hsla(0, 0%, 0%, .5) !important;
    outline-offset: 0.3rem */
  }
  .circular-menu.active .floating-btn {
    box-shadow: inset 0 0 3px hsla(0, 0%, 0%, .3);
  }

  .circular-menu .floating-btn:active {
    box-shadow: 0 4px 8px 0 hsla(0, 0%, 0%, .4);
  }

  .circular-menu .floating-btn i {
    font-size: 2em;
    transition: transform .2s;  
    line-height: 4rem;
  }

  .circular-menu.active .floating-btn i {
    transform: rotate(-45deg);
  }

  .circular-menu:after {
    display: block;
    content: ' ';
    width: 3.5em;
    height: 3.5em;
    border-radius: 50%;
    position: absolute;
    top: 0;
    right: 0;
    z-index: -2;
    background-color: hsl(4, 98%, 60%);
    transition: all .3s ease;
  }
  .circular-menu.active:after {
    transform: scale3d(5.5, 5.5, 1);
    transition-timing-function: cubic-bezier(.68, 1.55, .265, 1);
  }

  .circular-menu .items-wrapper {
    padding: 0;
    margin: 0;
  }

  .circular-menu .menu-item {
    position: absolute;
    top: .2em;
    right: .2em;
    z-index: -1;
    display: block;
    text-decoration: none;
    color: rgb(59, 130, 246);
    font-size: 1em;
    width: 3em;
    height: 3em;
    border-radius: 50%;
    text-align: center;
    line-height: 3;
    /* background-color: hsla(0,0%,0%,.1); */
    transition: transform .3s ease, background .2s ease, background-color 0.5s ease;
  }

  .circular-menu .menu-item:hover {
    /* background-color: hsla(0,0%,0%,.3); */
    --bs-bg-opacity: 1;
  }

  .circular-menu .menu-item {
    --bs-bg-opacity: 0.66;
  }

  .circular-menu.active .menu-item {
    -webkit-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    -moz-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    -o-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    -ms-transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  /**
  * The other theme for this menu
  */

  .circular-menu.circular-menu-left {
    right: auto; 
    left: 1em;
  }

  .circular-menu.circular-menu-left .floating-btn {
    background-color: rgba(186, 209, 246, 1);
  }

  .circular-menu.circular-menu-left:after {
    background-color: rgba(186, 209, 246, 0.5);
  }

  [data-layout-mode=dark] .circular-menu.circular-menu-left .floating-btn {
    background-color: rgba(81, 104, 137, 1);
  }
  [data-layout-mode=dark] .circular-menu.circular-menu-left:after {
    background-color: rgba(81, 104, 137, 0.5);
  }

  .circular-menu.circular-menu-left.active .floating-btn i {
    transform: rotate(90deg);
  }
  
  .circular-menu.circular-menu-left.active .menu-item:nth-child(1) {
    /*
    transform: translate3d(-1em,7em,0);
    */
    --angle: calc(var(--rotation-offset) + 0 * (360deg / var(--menu-items)));
    -webkit-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -moz-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -o-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -ms-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
  }

  .circular-menu.circular-menu-left.active .menu-item:nth-child(2) {
    /*
    transform: translate3d(3.5em,6.3em,0);
    */

    --angle: calc(var(--rotation-offset) + 1 * (360deg / var(--menu-items)));
    -webkit-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -moz-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -o-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -ms-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
  }

  .circular-menu.circular-menu-left.active .menu-item:nth-child(3) {
    /*
    transform: translate3d(6.5em,3.2em,0);
    */
    --angle: calc(var(--rotation-offset) + 2 * (360deg / var(--menu-items)));
    -webkit-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -moz-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -o-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -ms-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
  }

  .circular-menu.circular-menu-left.active .menu-item:nth-child(4) {
    /*
    transform: translate3d(7em,-1em,0);
    */
    --angle: calc(var(--rotation-offset) + 3 * (360deg / var(--menu-items)));
    -webkit-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -moz-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -o-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -ms-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
  }

  .circular-menu.circular-menu-left.active .menu-item:nth-child(5) {
    
    --angle: calc(var(--rotation-offset) + 4 * (360deg / var(--menu-items)));
    -webkit-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -moz-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -o-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    -ms-transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );
    transform: translate3d(
      calc(var(--menu-radius) * cos(var(--angle))),
      calc(var(--menu-radius) * sin(var(--angle))),
      0
    );

  }

  .newAssetMenu-helptext {
    position: absolute;
    top: 90%;
    left: 0%;
    text-align: center;
    font-weight: 600;
    background-color: inherit;
    color: inherit;
    /* font-size: smaller; */
    transition: left .5s ease, opacity .3s ease-out, width .5s ease-in, font-sizt .5s ease-in;
    opacity : 0;
    width: 0%;
    font-size: 0px;
  }

  .circular-menu.circular-menu-left.active .menu-item .newAssetMenu-helptext {
    opacity : 0;
  }

  .circular-menu.circular-menu-left.active .menu-item:hover .newAssetMenu-helptext {
    left: 90%;
    opacity: 1;
    width: auto;
    font-size: smaller;
  }

  /* การ์ด Inactive */
	.asset-card-ownership-cencel {
		background-color: #ffe2e2!important;
	}
	[data-layout-mode=dark] .asset-card-ownership-cencel {
		background-color: #622224!important;
	}

  .asset-card-ownership-contract {
		background-color: #BFC4C8!important;
	}
	[data-layout-mode=dark] .asset-card-ownership-contract {
		background-color: #000000!important;
	}

</style>

<div id="content_asset_container">
  @include('frontend.content-asset.view-asset-card-container', ['dataCusId' => $dataCusId, 'dataAsset' => $dataAsset, 'filter_asset' => $filter_asset])
</div>


<!-- สคริปต์สำหรับใช้ใส่ PopUp Modal ในหน้าทรัพย์ -->
<script>

  $("#modal_lg,#modal_xl,#modal_xl_static").on('hidden.bs.modal', function() {
    $(this).find('.modal-dialog').empty();
  })

  //-----------------------------------------------------------------------

  $(document).off('click', '.updateState-dataAssetBtn').on('click', '.updateState-dataAssetBtn', function(e) {
    e.preventDefault();
    console.log( $(this).data('assetid') );
    console.log( $(this).data('newstate') );
    var assetId = $(this).data('assetid');
    var newState = $(this).data('newstate');

    var filter_asset = $("#filter_asset").val();

    var helpText = "";
    switch (newState) {
      case 'Active':
        helpText = "<p class='m-0 text-dark'>อัปเดตสถานะทรัพย์นี้เป็น <strong class='text-success'><i class='bx bx-check fs-4'></i> เปิดใช้งาน</strong> ?</p>"
        break;
      case 'Blacklist':
        helpText = "<p class='m-0 text-dark'>อัปเดตสถานะทรัพย์นี้เป็น <strong class='text-danger'><i class='bx bx-x fs-4'></i> แบล็กลิสต์</strong> ?</p>"
        break;
      case 'Hide':
        helpText = "<p class='m-0 text-dark'>คุณต้องการที่จะ <strong class='text-danger'><i class='bx bxs-trash fs-4'></i> ลบทรัพย์</strong> นี้ ?</p>"
        break;
      default:
        return;
        break;
    }
    //-----------------------------------------------------------
    Swal.fire({
      icon: 'warning',
      title: 'กรุณาตรวจสอบ',
      html: helpText,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก',
      confirmButtonColor: '#d33',
      showLoaderOnConfirm: true,
      allowEscapeKey: false,
      allowEnterKey: false,
      preConfirm: function(login) {
        var link = `{{ route('asset.update', 'id') }}`;
				var url = link.replace('id', assetId);
        return $.ajax({
          url: url,
          type: 'put',
          data: {
            _token: '{{ csrf_token() }}',
            mod: 'state',
            Status_Asset: newState,
            filter_asset: filter_asset,
            dataCusId: '{{@$dataCusId}}',
          },
          complete: function(data) {
            console.log( data );
          },
          success: function(result){
            console.log( "success!" );
            console.log( result );
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: result.message,
              showConfirmButton: false,
              timer: 1500
            });
            $('#content_asset_container').html(result.html);  
          },
          error: function(xhr, status, error) {
              // Get the error message from the response
              var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
              var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
              errorFile = errorFile.replace(/^.*[\\\/]/, '');
              var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
              var errorHtml = "<p>" + errorMessage +"</p>";
              errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
              // Display the error message using SweetAlert2
              Swal.fire({
                  icon: 'error',
                  title: error,
                  html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                  showCancelButton: true,
                  confirmButtonText: 'ดูเพิ่มเติม',
                  cancelButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                      Swal.fire({
                          icon: 'error',
                          title: 'รายละเอียด',
                          //text: errorMessage,
                          html: errorHtml,
                          confirmButtonText: 'OK'
                      });
                  }
              });
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    });
    //-----------------------------------------------------------

  });

  $(document).off('click', '.updateStateOwnership-dataAssetBtn').on('click', '.updateStateOwnership-dataAssetBtn', function(e) {
    e.preventDefault();
    console.log( $(this).data('assetid') );
    console.log( $(this).data('ownerid') );
    console.log( $(this).data('newstate') );
    var assetId = $(this).data('assetid');
    var ownerId = $(this).data('ownerid');
    var newState = $(this).data('newstate');

    var filter_asset = $("#filter_asset").val();

    var helpText = "";
    switch (newState) {
      case 'Cancel':
        helpText = "<p class='m-0 text-dark'>คุณต้องการที่จะ <strong class='text-danger'><i class='bx bxs-trash fs-4'></i> ยกเลิกการครอบครอง</strong> ทรัพย์นี้ ?</p>"
        break;
      default:
        return;
        break;
    }
    //-----------------------------------------------------------
    Swal.fire({
      icon: 'warning',
      title: 'กรุณาตรวจสอบ',
      html: helpText,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก',
      confirmButtonColor: '#d33',
      showLoaderOnConfirm: true,
      allowEscapeKey: false,
      allowEnterKey: false,
      preConfirm: function(login) {
        var link = `{{ route('asset.update', 'id') }}`;
				var url = link.replace('id', ownerId);
        return $.ajax({
          url: url,
          type: 'put',
          data: {
            _token: '{{ csrf_token() }}',
            mod: 'owner-state',
            Status_Owner: newState,
            filter_asset: filter_asset,
          },
          complete: function(data) {
            console.log( data );
          },
          success: function(result){
            console.log( "success!" );
            console.log( result );
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: result.message,
              showConfirmButton: false,
              timer: 1500
            });
            $('#content_asset_container').html(result.html);  
          },
          error: function(xhr, status, error) {

              
              // Get the error message from the response
              var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
              var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
              errorFile = errorFile.replace(/^.*[\\\/]/, '');
              var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
              var errorHtml = "<p>" + errorMessage +"</p>";
              errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
              // Display the error message using SweetAlert2
              Swal.fire({
                  icon: 'error',
                  title: error,
                  html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                  showCancelButton: true,
                  confirmButtonText: 'ดูเพิ่มเติม',
                  cancelButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                      Swal.fire({
                          icon: 'error',
                          title: 'รายละเอียด',
                          //text: errorMessage,
                          html: errorHtml,
                          confirmButtonText: 'OK'
                      });
                  }
              });
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    });
    //-----------------------------------------------------------

  });

  $(document).off('click', '.delete-dataAssetBtn').on('click', '.delete-dataAssetBtn', function(e) {
    e.preventDefault();
    console.log( $(this).data('assetid') );
    var assetId = $(this).data('assetid');
    var filter_asset = $("#filter_asset").val();
    var helpText = "<p class='m-0 text-dark'>คุณต้องการที่จะ <strong class='text-danger'><i class='bx bxs-trash fs-4'></i> ลบทรัพย์</strong> นี้ ?</p><p class='m-0 pt-2 text-danger fw-bold small'>* การดำเนินการนี้จะเป็นการลบทรัพย์นี้ทิ้ง *<br>* ข้อมูลการครอบครองทรัพย์นี้จากลูกค้าทุกคนจะหายไปด้วย *</p>";
    //-----------------------------------------------------------
    Swal.fire({
      icon: 'warning',
      title: 'กรุณาตรวจสอบ',
      html: helpText,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: 'ยืนยัน',
      cancelButtonText: 'ยกเลิก',
      confirmButtonColor: '#d33',
      showLoaderOnConfirm: true,
      allowEscapeKey: false,
      allowEnterKey: false,
      preConfirm: function(login) {
        var link = `{{ route('asset.destroy', 'id') }}`;
				var url = link.replace('id', assetId);
        return $.ajax({
          url: url,
          type: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}',
            mod: 'asset',
            dataCusId: '{{@$dataCusId}}',
          },
          complete: function(data) {
            console.log( data );
          },
          success: function(result){
            console.log( "success!" );
            console.log( result );
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: result.message,
              showConfirmButton: false,
              timer: 1500
            });
            $('#content_asset_container').html(result.html);  
          },
          error: function(xhr, status, error) {
              // Get the error message from the response
              var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
              var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
              errorFile = errorFile.replace(/^.*[\\\/]/, '');
              var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
              var errorHtml = "<p>" + errorMessage +"</p>";
              errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
              // Display the error message using SweetAlert2
              Swal.fire({
                  icon: 'error',
                  title: error,
                  html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                  showCancelButton: true,
                  confirmButtonText: 'ดูเพิ่มเติม',
                  cancelButtonText: 'OK'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                      Swal.fire({
                          icon: 'error',
                          title: 'รายละเอียด',
                          //text: errorMessage,
                          html: errorHtml,
                          confirmButtonText: 'OK'
                      });
                  }
              });
          }
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    });
    //-----------------------------------------------------------

  });

  function FilterAsset(atagbtn) {
    var btnObj = $(atagbtn);
    if (btnObj.hasClass('active')) {
      return;
    }

    // ซ่อน tooltip ที่ค้างออก
    var tooltips = $('.filter-asset li[data-bs-toggle="tooltip"]').tooltip();
    tooltips.tooltip('hide');

    $('#content_asset').empty();
    $("#data_asset .content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

    var filter_asset = btnObj.data('filter');
    var cus_id = btnObj.data('cusid');

    $.ajax({
      method: "get",
      url: "{{ route('asset.index') }}",
      data: {
        type: 'tab',
        cus_id: cus_id,
        filter_asset: filter_asset,
      },
      complete: function(data) {
        //$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        $("#data_asset .content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        $("#data_asset").data('loaded', 'complete');
      },
      success: function (data) {
        if (data.status == true) {
          //toastr.success(data.message);
          $('#content_asset').html(data.html);
        } else {
          //toastr.error(data.message);
        }
      },
    });

  }

    function updateActiveAssetPage4Card(targetPage, withClick = false) {
      $('.pagination-asset-4card .page-item').removeClass('active');
      $( $('.pagination-asset-4card .page-item')[targetPage+1] ).addClass('active');
      /*
      if (withClick == true) {
        $('.carousel-asset-4card').carousel(targetPage)
      }
      */
    }

    $('.carousel-asset-4card').on('slide.bs.carousel',function(e){
      var slideFrom = $(this).find('.active').index();
      var slideTo = $(e.relatedTarget).index();
       console.log(slideFrom+' => '+slideTo);
      // console.log('P4: ' + slideTo + ", P2: " + Math.ceil(slideTo / 2) );
       updateActiveAssetPage4Card(slideTo);
      // updateActiveAssetPage2Card( Math.floor(slideTo * 2), true );
    });

  $(document).ready(function() {

    
    function updateActiveAssetPage2Card(targetPage, withClick = false) {
      $('.pagination-asset-2card .page-item').removeClass('active');
      $( $('.pagination-asset-2card .page-item')[targetPage+1] ).addClass('active');
      if (withClick == true) {
        $('.carousel-asset-2card').carousel(targetPage)
      }
    }

    $('.carousel-asset-2card').on('slide.bs.carousel',function(e){
      var slideFrom = $(this).find('.active').index();
      var slideTo = $(e.relatedTarget).index();
      //console.log(slideFrom+' => '+slideTo);
      //console.log('P2: ' + slideTo + ", P4: " + Math.floor(slideTo * 2) );
      updateActiveAssetPage2Card(slideTo);
      // updateActiveAssetPage4Card( Math.floor(slideTo / 2), true );
    });

  });

</script>
