@extends('layouts.master')
@section('title', 'System Setting')
@section('System-p1-active', 'mm-active')
@section('page-frontend','d-none')
@section(@$set,'show')

@section('content')
  @include('components.content-toast.view-toast')
  <div class="row">
    <div class="col-lg-12">
      <span class="showScroll2 float-end">
          <a class="Modal-xl hover-up" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.create') }}?page={{'backend'}}&modal={{'gradecont'}}&mode={{'create'}}" style="cursor:pointer;">
            <div class="bg-dark" style="left:-43px; top:10px; z-index:1; position:relative; width: 100%; opacity:0.9;">
              <div class="bg-dark bg-gradient" style="z-index:-1; left: -6px; position:absolute; width: 50px; height: 45px; border-radius:30px 0px 0px 30px;"></div>
              <div class="bg-light border border-light border-5" style="z-index:3; position:absolute; top: 5px; left: 2px; border-radius:50px;">
                <div style="width:25px;">
                  <img src="{{ asset('assets/images/plus.png') }}" alt="เพิ่ม" width="100%" height="100%">
                </div>
              </div>
            </div>
          </a>
      </span>
    </div>
  </div>

  <div class="row">
      <div class="col-12">
          <div id="datagradecont">
              @include('data-system.back-system.data-gradecont.data')
          </div>
      </div> <!-- end col -->
  </div>

  <div class="modal fade bs-example-modal-center" id="Modal-xl" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"></div><!-- /.modal-dialog -->
  </div>

  <div class="modal fade bs-example-modal-center" id="Modal-xxl" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable"></div><!-- /.modal-dialog -->
  </div>

  <script>
      $(document).on('click', '.Modal-xl', function(e) {
          e.preventDefault();
          var url = $(this).attr('data-link');
          $('#modal-xl .modal-dialog').empty();
          $('#Modal-xl .modal-dialog').load(url);
      });
      $(document).on('click', '.Modal-xxl', function(e) {
          e.preventDefault();
          var url = $(this).attr('data-link');
          $('#modal-xxl .modal-dialog').empty();
          $('#Modal-xxl .modal-dialog').load(url);
      });
  </script>

  <!-- <a id="button" href="#top" class="font-size-14"><i class="mdi mdi-triangle mdi-24px"></i></a> -->
  <script>
      // --------- button-to-top --------------
      var btn = $('#button');
      $(window).scroll(function() {
          if ($(window).scrollTop() > 300) {
          btn.addClass('show');
          } else {
          btn.removeClass('show');
          }
      });
      btn.on('click', function(e) {
          e.preventDefault();
          $('html, body').animate({scrollTop:0}, '300');
      });
  </script>

@endsection
