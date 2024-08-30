@extends('layouts.master')
@section('title', 'TAKE-DOC')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-savePrintlet', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
    @include('public-js.constants')
    @component('components.breadcrumb')
        @slot('title')
            ขอเบิกเอกสาร (TAKE DOCUMENT)
        @endslot
        @slot('menu')
            ระบบขอเบิกเอกสาร
        @endslot
        @slot('sub_menu')
            ขอเบิกเอกสาร
        @endslot
    @endcomponent

    @include('backend.content-take-doc.take-document.css')

    <div class="card py-2 px-2">
        <div class="cont__input">
            <div class="mock__up rounded-3">
                <img src="{{ URL::asset('assets/images/svg/process.svg') }}" alt="">
            </div>
            <div class="px-2" style="width: 100%">
                <div class="conn_title pb-2">
                    <img class="doc__gif" src="{{ URL::asset('assets/images/gif/doc.gif') }}" alt="">
                    <div>
                        <span>ระบบขอเบิกเอกสาร</span>
                        <div>
                            <span id="typeLoan"></span>
                        </div>
                    </div>
                </div>
                <div class="conn_cardr">
                    <div class="card-lable">
                        <label class="card-radio-label mb-3">
                            <input type="radio" name="pay-method" id="pay-methodoption1" class="card-radio-input" checked>
                            <div class="card-radio">
                                <i class="fab fa-cc-mastercard font-size-14 text-primary align-middle me-2"></i>
                                <span>เงินกู้</span>
                            </div>
                        </label>
                    </div>
                    <div class="card-lable">
                        <label class="card-radio-label mb-3">
                            <input type="radio" name="pay-method" id="pay-methodoption1" class="card-radio-input" checked>
                            <div class="card-radio">
                                <i class="fab fa-cc-mastercard font-size-14 text-primary align-middle me-2"></i>
                                <span>เช่าซื้อ</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection