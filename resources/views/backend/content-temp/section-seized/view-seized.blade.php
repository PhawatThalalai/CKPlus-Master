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
			บันทึกยึดรอไถ่ถอน
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			บันทึกยึดรอไถ่ถอน
		@endslot
	@endcomponent

	<div id="form-seized">
		@include('backend.content-temp.section-seized.form-seized')
	</div>
@endsection
