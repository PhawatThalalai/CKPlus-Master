<div class="row">
  <div class="col-lg-12">
    <span class="showScroll2 float-end">
        <a class="Modal-xl hover-up" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.create') }}?page={{'backend'}}&modal={{'trlist'}}&mode={{'create'}}" style="cursor:pointer;">
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
        <div id="dataCompanies">
            @include('data-system.back-system.data-trlist.data')
        </div>
    </div> <!-- end col -->
</div>
