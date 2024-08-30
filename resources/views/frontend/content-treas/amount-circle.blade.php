<div class="row">
    <div class="col-12 text-center">
        @if( @$data['countBank'] > 1 )
          <button class="carousel-control-prev btn-NextPre" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next btn-NextPre" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        @endif

        <div class="avatar-xl" style="display: inline-flex">
            <span class="avatar-title rounded-circle bg-white border border-warning border-2 text-danger font-size-16">
                <div class="mt-4 mt-sm-0">
                    <div class="font-size-24 text-primary">
                        <i class="bx bx-wallet"></i>
                    </div>
                    <p class="text-muted mb-1 fs-6">ยอดคงเหลือ </p>
                    <h6 class="fw-semibold" id="Show_Amount_after-{{ @$data['Bankid'] }}">{{ @$data['Amount_after'] != NULL ? number_format(@$data['Amount_after'],2) : number_format(@$Amoutbank->BankToCredit->Amount_after,0) }}</h6>
                </div>
            </span>
        </div>
    </div>
</div>
