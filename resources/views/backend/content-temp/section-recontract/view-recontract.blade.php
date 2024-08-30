@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub1-active', 'mm-active')
@section('account-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			บันทึกต่อสัญญาขายฝาก
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			บันทึกต่อสัญญาขายฝาก
		@endslot
	@endcomponent
	<div class="row">
		<div class="col">
			<div id="form-recontracts">
				@include('backend.content-temp.section-recontract.form-recontract')
			</div>
		</div>
	</div>

@endsection
