
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

<style>

	/* ทำให้ form-floating มีขนาดเล็กลง */
	.form-floating > .form-select {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem;*/
		padding-top: 1rem;
		padding-bottom: 0.625rem;
	}

	.form-floating > .form-control:focus, .form-floating > .form-control:not(:placeholder-shown), .form-floating > .form-control-plaintext:focus, .form-floating > .form-control-plaintext:not(:placeholder-shown) {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem; */
		padding-top: 1rem;
		padding-bottom: 0.5rem;
	}

	.form-floating > .form-control, .form-floating > .form-control-plaintext {
		/* padding: 1rem 0.75rem; */
		padding: 1rem 0.75rem;
	}

	.form-floating > .form-control, .form-floating > .form-control-plaintext, .form-floating > .form-select {
		/* height: calc(3.5rem + 2px);
		line-height: 1.25; */
		height: calc(2.5rem + 2px);
		line-height: 1.25;
	}

	.form-floating > label {
		/* padding: 1rem 0.75rem; */
		padding: 0.8rem 0.6rem;
	}

	.form-floating > .form-control:focus ~ label, .form-floating > .form-control:not(:placeholder-shown) ~ label, .form-floating > .form-control-plaintext ~ label, .form-floating > .form-select ~ label {
		/* -webkit-transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem); */
		-webkit-transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
	}
	.card-adds:hover{
		scale : 1;
		transition : 0.3s;
		z-index : 1;
	}
	.card-adds{
		scale:0.9;
		transition : 0.3s;
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
	<form id="edit_Address" class="needs-validation"  novalidate>
		@csrf
		<input type="hidden" name="type" value="2" />
		<input type="hidden" name="id" value="{{@$data->id}}" />
		<input type="hidden" name="last_id" id="last_id">
		<input type="hidden" name="DataCus_id" id="DataCus_id" value=" {{@$data->DataCus_id}}">
        <input type="hidden" name="Type_Adds" id="Type_Adds" value="{{ @$data->DataCusAddsToTypeAdds->Code_Address }}">

        <div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/home.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">แก้ไขที่อยู่ลูกค้า (Edit Address)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$data->Code_Adds }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-sm-12 mb-1 text-center bg-light">
					<div class="row pt-2 g-1 mb-2 mt-1">
						<div class="col-xl col-md col-sm-12">
							<h4 class="fw-semibold">{{ @$data->DataCusAddsToTypeAdds->Name_Address }}</h4>
						</div>
						<textarea name="" id="arrAdress" cols="30" rows="10" hidden>{{ @$dataAdds }}</textarea>
					</div>

					<div class="row align-items-start">
						<div class="col-12 text-center">
							<img src="assets/images/undraw/undraw_home.svg" alt="" style="width: 150px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{@$data->Code_Adds}}</h4>
						</div>
					</div>

					<div class="row">
						@if(count(@$data->DataCusAddsToDataCus->DataCusToDataCusAddsMany) > 0)
						<div class="col-12 text-center">
							<button class="btn-share btn-sm bg-secondary bg-opacity-25 px-2 py-1" type="button" style="{{ count(@$data->DataCusAddsToDataCus->DataCusToDataCusAddsMany) == 0 ? 'pointer-events: none;' : '' }}" >
								<span class="btn-overlay text-light"><i class="bx bxs-map me-1"></i> ที่อยู่ที่เพิ่มแล้ว</span>
								@foreach(@$typeAdds as $item)
									@php
										$CodeAdds = $item->Code_Address;
										@$isTypeHome = $dataAdds
											->filter(function ($e) use ($CodeAdds) {
												return $e->Type_Adds == $CodeAdds;
											});
									@endphp
									<a  class="btn section btn-sm rounded-circle px-2 {{  count(@$isTypeHome) == 0 ? 'bg-secondary btn-outline-light' : 'bg-white btn-outline-info' }}" onclick="getaddress('edit','{{ $data->DataCusAddsToDataCus->id }}','{{ $item->Code_Address }}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{@$item->Name_Address}}" {{  count(@$isTypeHome) == 0 ? 'disabled' : '' }} style="{{ count(@$isTypeHome) == 0 ? 'pointer-events: none;' : '' }}">
										<i class="bx bx-home-circle fs-5  {{  count(@$isTypeHome) == 0 ? 'text-light' : 'text-info' }}"></i>
									</a>
								@endforeach
							</button>
						</div>
						@endif
					</div>

                    <div class="row bg-white bg-opacity-50">
                        <div class="form-switch form-switch-md my-2">
                            <input class="form-check-input" type="checkbox" name="SwitchStatus_Adds" id="SwitchStatus_Adds" {{@$data->Status_Adds == 'active' ? 'checked' : ''}}>
                            <label class="form-check-label {{@$data->Status_Adds == 'active' ? 'text-success' : 'text-mute'}}" id="text-status" for="SwitchStatus_Adds">{{@$data->Status_Adds == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน'}}</label>
                            <input type="hidden" value="{{@$data->Status_Adds}}" name="Status_Adds" id="Status_Adds">
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
			<button type="button" id="btn_EditAdds" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editUser">
				<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
            </button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> ปิด
			</button>
		</div>
	</form>
 </div>
</div>







