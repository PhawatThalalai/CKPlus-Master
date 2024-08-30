@extends('layouts.master')
@section('title', 'Brokers')
@section('broker-active', 'mm-active')
@section('page-backend','d-none')

@section('content')
	@component('components.breadcrumb')
		@slot('title')
            Broker info
		@endslot
		@slot('title_small')
			(ข้อมูลผู้แนะนำ)
		@endslot
	@endcomponent

	@component('components.content-search.search')
        @slot('page')
			broker
		@endslot
	@endcomponent

	<div class="row">
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
			@component('components.content-user.card-profile')
                @slot('flag')
                    d-none
                @endslot
				@slot('data', [
					"status" => @$data->Status_Broker,
					"name" => @$data->Name_Broker,
					"idcard" => @$data->IDCard_Broker,
					"phone" => @$data->Phone_Broker,
					"code" => @$data->Code_Broker,

					"dateinput" => @$data->date_Broker,
					"UserInsert" => @$data->UserInsert,
				])
			@endcomponent
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
            <div class="tab-content text-muted">
                <div class="tab-pane active show" id="data_user" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <!-- header Tab panes -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#card-user" role="tab" aria-selected="true">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">รายละเอียดลูกค้า</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content pt-1 text-muted">
                                <div class="tab-pane active show" id="card-user" role="tabpanel">
                                    <div id="content_cus">
                                        @include('components.content-user.card-user')
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                            <li class="nav-item waves-effect waves-light" role="presentation">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#user-address" role="tab" aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">ข้อมูลที่อยู่</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active show" id="user-address" role="tabpanel">
                                                <div class=" border-bottom">
                                                    <div class="row">
                                                        <div class="col-md-4 col-4">
                                                            <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i> Active</p>
                                                            <h6 class="font-size-13 mb-1">Tag Code : CRS-230100325</h6>
                                                        </div>
                                                        <div class="col-md-8 col-8">
                                                            <ul class="list-inline user-chat-nav text-end mb-0">
                                                                <li class="list-inline-item d-none d-sm-inline-block me-auto">
                                                                    <div class="dropdown">
                                                                        <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bx bx-search-alt-2"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-end py-0 dropdown-menu-md" style="">
                                                                            <form class="p-3">
                                                                                <div class="form-group m-0">
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">

                                                                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="list-inline-item d-none d-sm-inline-block me-auto">
                                                                    <div class="dropdown">
                                                                        <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bx bx-cog"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                                            <a class="dropdown-item" href="#">View Profile</a>
                                                                            <a class="dropdown-item" href="#">Clear chat</a>
                                                                            <a class="dropdown-item" href="#">Muted</a>
                                                                            <a class="dropdown-item" href="#">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="list-inline-item me-auto">
                                                                    <div class="dropdown">
                                                                        <button class="btn nav-btn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bx bx-edit-alt bx-xs hover-up"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                                            <a class="dropdown-item" href="#">Action</a>
                                                                            <a class="dropdown-item" href="#">Another action</a>
                                                                            <a class="dropdown-item" href="#">Something else</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="data_contract" role="tabpanel">
                    sdfdsfdsf
                </div>
            </div>
		</div>
	</div>
@endsection



