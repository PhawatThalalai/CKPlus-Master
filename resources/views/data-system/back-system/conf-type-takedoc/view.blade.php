@extends('layouts.master')
@section('title', 'CONFIG-DOC')
@section('page-frontend', 'd-none')

@section('content')
    @include('public-js.constants')
    @component('components.breadcrumb')
        @slot('title')
            จัดการการเบิกเอกสาร (TAKE DOCUMENT MANAGEMENT)
        @endslot
        @slot('menu')
            จัดการการเบิกเอกสาร
        @endslot
        @slot('sub_menu')
            Mega Menu
        @endslot
    @endcomponent

    @include('data-system.back-system.conf-type-takedoc.css')

    <div class="master d-flex justify-center gap-3">
        <div class="card px-2 py-2" style="width: 20%;">

        </div>
        <div class="card px-2 py-2" style="width: 80%;">
           <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class='bx bx-folder-plus' ></i> เพิ่มประเภทการเบิกเอกสาร
                </button>
                @component('data-system.back-system.conf-type-takedoc.modal')
                @endcomponent
           </div>
           <div id="dataTable" class="pt-3">
                @include('data-system.back-system.conf-type-takedoc.table')
           </div>
        </div>
    </div>
@endsection