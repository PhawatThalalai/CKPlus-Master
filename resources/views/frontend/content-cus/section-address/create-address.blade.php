<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

<style>
	/* ทำให้ form-floating มีขนาดเล็กลง */
	.form-floating>.form-select {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem;*/
		padding-top: 1rem;
		padding-bottom: 0.625rem;
	}

	.form-floating>.form-control:focus,
	.form-floating>.form-control:not(:placeholder-shown),
	.form-floating>.form-control-plaintext:focus,
	.form-floating>.form-control-plaintext:not(:placeholder-shown) {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem; */
		padding-top: 1rem;
		padding-bottom: 0.5rem;
	}

	.form-floating>.form-control,
	.form-floating>.form-control-plaintext {
		/* padding: 1rem 0.75rem; */
		padding: 1rem 0.75rem;
	}

	.form-floating>.form-control,
	.form-floating>.form-control-plaintext,
	.form-floating>.form-select {
		/* height: calc(3.5rem + 2px);
		line-height: 1.25; */
		height: calc(2.5rem + 2px);
		line-height: 1.25;
	}

	.form-floating>label {
		/* padding: 1rem 0.75rem; */
		padding: 0.8rem 0.6rem;
	}

	.form-floating>.form-control:focus~label,
	.form-floating>.form-control:not(:placeholder-shown)~label,
	.form-floating>.form-control-plaintext~label,
	.form-floating>.form-select~label {
		/* -webkit-transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem); */
		-webkit-transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
	}

	.card-adds:hover {
		scale: 1;
		transition: 0.3s;
		z-index: 1;
	}

	.card-adds {
		scale: 0.9;
		transition: 0.3s;
	}
</style>

<style>
	.content {
		/* width:100%; */
		padding: 0px 0px;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
		align-items: center;
		background: rgba(0, 0, 0, 0.582);
		color: white;
		transform: translateY(100%);
		transition: all 0.35s ease;
	}

	.tab-bottom:hover .content {
		transform: translateY(0);
	}

	.icons {
		width: 130px;
		display: flex;
		justify-content: space-evenly;
	}

	.icons i {
		font-size: 30px;
		color: rgba(255, 255, 255, 0.274);
		transition: all 0.2s ease;
	}

	.icons i:hover {
		color: rgba(255, 255, 255, 0.438);
	}
</style>

<style>
	.btn-hover {
		position: relative;
		display: flex;
		overflow: hidden;
		cursor: pointer;
		width: 150px;
		height: 40px;
		background-color: #eeeeed;
		border-radius: 30px;
		border: none;
		padding: 0 80px;
		transition: all .2s ease;
		justify-content: center;
		align-items: center;
	}

	.btn-hover:hover {
		transform: scale(1.1);
	}

	.btn-hover span {
		position: absolute;
		z-index: 99;
		width: 150px;
		height: 50px;
		border-radius: 80px;
		font-family: 'Courier New', Courier, monospace;
		font-weight: 600;
		font-size: 17px;
		text-align: center;
		line-height: 50px;
		letter-spacing: 2px;
		color: #eeeeed;
		background-color: #1f1f1f;
		padding: 0 10px;
		transition: all 1.2s ease;
	}

	.btn-hover .container {
		display: flex;
		width: 150px;
		border-radius: 80px;
		line-height: 50px;
	}

	.btn-hover svg {
		padding: 0 5px;
		opacity: 0;
	}

	.btn-hover .container svg:nth-of-type(1) {
		transition-delay: 0.65s;
	}

	.btn-hover .container svg:nth-of-type(2) {
		transition-delay: 0.8s;
	}

	.container svg:nth-of-type(3) {
		transition-delay: 0.5s;
	}

	.btn-hover:hover span {
		opacity: 0;
	}

	.btn-hover:hover svg {
		opacity: 1;
	}
</style>


<style>
	.btn-share {
	 /* --btn-inner-color: #e6e9ed; */
	 --btn-overlay-color: #556ee6;
	 --icon-color: #1c1d2a;
	 position: relative;
	 /* display: flex; */
	 border: none;
	 background: transparent;
	 border-radius: 80px;
	 outline: none;
	 cursor: pointer;
	 overflow: hidden;
	 transform: rotate(0);
	 transition: 0.2s ease-in-out;
	 scale: 0.8;
	}
 .btn-share .btn-overlay {
	 position: absolute;
	 top: 0;
	 left: 0;
	 z-index: 1;
	 display: flex;
	 justify-content: center;
	 align-items: center;
	 width: 100%;
	 height: 100%;
	 background: var(--btn-overlay-color);
	 border-radius: inherit;
	 transition: 0.6s linear;
	}
 .btn-share a {
	 padding: 7px;
	 color: var(--icon-color);
	 opacity: 0;
	 transform: translateX(-100%);
	 transition: 0.3s;
	}
 .btn-share a:nth-child(1) {
	 /* transition-delay: 0.8s; */
	}
 .btn-share a:nth-child(2) {
	 /* transition-delay: 0.6s; */
	}
 .btn-share a:nth-child(3) {
	 /* transition-delay: 0.4s; */
	}
 .btn-share:hover {
	 transform: scale(1.1);
	}
 .btn-share:hover .btn-overlay {
	 transform: translateX(-100%);
	 transition-delay: 0.25s;
	}
 .btn-share:hover a {
	 opacity: 1;
	 transform: translateX(0);
	}

	.custom-tooltip {
		--bs-tooltip-bg: var(--bs-primary);
	}

	.adds-tooltip {
		--bs-tooltip-bg: var(--bs-danger);
	}



</style>

 @include('public-js.scriptAddress')
 @include('frontend.content-cus.section-address.script-address')

<div class="modal-content">
	<form id="CreateAddress" class="needs-validation" novalidate>
		@csrf
		<input type="hidden" name="DataCus_id" value="{{ @$data->id }}" />

        <div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/home.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">เพิ่มที่อยู่ลูกค้า (New Address)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$CodeJob }}</p>
				<p class="border-primary border-bottom mt-n2 "></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
            <div class="row ms-1">
                <div class="col-xl-5 col-sm-12 text-center bg-light">
                    <div id="case-1">
                        {{-- เลือกที่อยู่ที่ใช้ในการเพิ่ม --}}
                        <div class="row pt-2 g-1">
                            @foreach ($dataTBAdds as $key => $value)
                                @php
                                    $typeAdds = $value->Code_Address;
                                    @$isTypeHome = $dataAdds
                                        ->filter(function ($e) use ($typeAdds) {
                                            return $e->Type_Adds == $typeAdds;
                                        });
                                @endphp
                                <div class="col-xl col-md col-sm-12 ">
                                    <div class="card-adds card p-3 adds-01 {{ count(@$isTypeHome) != 0 ? 'bg-secondary bg-soft' : '' }}" {{  count(@$isTypeHome) != 0 ? 'disabled' : '' }} >
                                        <div class="form-check">
                                            <input class="form-check-input fs-5 getAdds {{  count(@$isTypeHome) != 0 ? '' : 'Type_Adds' }}" type="radio" value="{{ $value->Code_Address }}" name="Type_Adds" id="adds-{{ $key }}" {{ count(@$isTypeHome) != 0 ? 'disabled' : '' }}>
                                            <label class="form-check-label fs-6" for="adds-{{ $key }}">
                                                {{ $value->Name_Address }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <textarea name="" id="arrAdress" cols="30" rows="10" hidden>{{ @$dataAdds }}</textarea> --}}
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="assets/images/undraw/undraw_home.svg" alt="" style="width: 150px;">
                            </div>
                            <div class="col-12 mt-2">
                                <h4 class="text-danger fw-bold">{{ @$CodeJob }}</h4>
                            </div>
                        </div>
                        <div class="row">
                            @if(count(@$data->DataCusToDataCusAddsMany) > 0)
                            <div class="col-12 text-center">
                                <button class="btn-share btn-sm bg-secondary bg-opacity-25 px-2 py-1" type="button" style="{{ count(@$data->DataCusToDataCusAddsMany) == 0 ? 'pointer-events: none;' : '' }} display:none;" >
                                    <span class="btn-overlay text-light"><i class="bx bxs-map me-1"></i> ที่อยู่ก่อนหน้า</span>
                                    @foreach(@$dataTBAdds as $item)
                                        @php
                                            $typeAdds = $item->Code_Address;
                                            @$isTypeHome = $dataAdds
                                                ->filter(function ($e) use ($typeAdds) {
                                                    return $e->Type_Adds == $typeAdds;
                                                });
                                        @endphp
                                        <a class="btn section btn-sm rounded-circle px-2 {{  count(@$isTypeHome) == 0 ? 'bg-secondary btn-outline-light' : 'bg-white btn-outline-info' }}" onclick="getaddress('create','{{ $data->id }}','{{ $item->Code_Address }}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{@$item->Name_Address}}" {{  count(@$isTypeHome) == 0 ? 'disabled' : '' }} style="{{ count(@$isTypeHome) == 0 ? 'pointer-events: none;' : '' }}">
                                            <i class="bx bx-home-circle fs-5  {{  count(@$isTypeHome) == 0 ? 'text-light' : 'text-info' }}"></i>
                                        </a>
                                    @endforeach
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="content-view">
                        @include('frontend.content-cus.section-address.viewCreate-address')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn_SubmitAdds" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editUser">
                <i class="fas fa-download"></i></span> บันทึก <span class="addSpin">
            </button>
            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
        </div>
	</form>
</div>


<script>
	 document.querySelectorAll('[data-bs-toggle="tooltip"]')
    .forEach(tooltip => {
      new bootstrap.Tooltip(tooltip)
    })
</script>




