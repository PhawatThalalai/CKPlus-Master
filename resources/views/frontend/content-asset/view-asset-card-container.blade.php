
<!-- Style การ์ด Inactive -->
<style>
  :root {
    --bs-lightgray-darker-1 : #D0CECE;
    --bs-lightgray-darker-1-rgb : 208, 206, 206;
    
    --bs-lightgray-darker-2 : #AEAAAA;
    --bs-lightgray-darker-2-rgb : 174, 170, 170;
    
    --bs-lightgray-darker-3 : #757171;
    --bs-lightgray-darker-3-rgb : 117, 113, 113;
    
    --bs-lightgray-darker-4 : #3A3838;
    --bs-lightgray-darker-4-rgb : 58, 56, 56;

    --bs-lightgray-darker-5 : #161616;
    --bs-lightgray-darker-5-rgb : 22, 22, 22;
  }

  .bg-lightgray-darker-1 {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-lightgray-darker-1-rgb), var(--bs-bg-opacity)) !important;
  }

  .bg-lightgray-darker-2 {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-lightgray-darker-2-rgb), var(--bs-bg-opacity)) !important;
  }

  .bg-lightgray-darker-3 {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-lightgray-darker-3-rgb), var(--bs-bg-opacity)) !important;
  }

  .bg-lightgray-darker-4 {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-lightgray-darker-4-rgb), var(--bs-bg-opacity)) !important;
  }

  .bg-lightgray-darker-5 {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-lightgray-darker-5-rgb), var(--bs-bg-opacity)) !important;
  }

  .border-lightgray-darker-1 {
    --bs-border-opacity: 1;
    border-color: rgba(var(--bs-lightgray-darker-1-rgb), var(--bs-border-opacity)) !important;
  }

  .border-lightgray-darker-2 {
    --bs-border-opacity: 1;
    border-color: rgba(var(--bs-lightgray-darker-2-rgb), var(--bs-border-opacity)) !important;
  }

  .border-lightgray-darker-3 {
    --bs-border-opacity: 1;
    border-color: rgba(var(--bs-lightgray-darker-3-rgb), var(--bs-border-opacity)) !important;
  }

  .border-lightgray-darker-4 {
    --bs-border-opacity: 1;
    border-color: rgba(var(--bs-lightgray-darker-4-rgb), var(--bs-border-opacity)) !important;
  }

  .border-lightgray-darker-5 {
    --bs-border-opacity: 1;
    border-color: rgba(var(--bs-lightgray-darker-5-rgb), var(--bs-border-opacity)) !important;
  }

  .text-lightgray-darker-1 {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-lightgray-darker-1-rgb), var(--bs-text-opacity)) !important;
  }

  .text-lightgray-darker-2 {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-lightgray-darker-2-rgb), var(--bs-text-opacity)) !important;
  }

  .text-lightgray-darker-3 {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-lightgray-darker-3-rgb), var(--bs-text-opacity)) !important;
  }

  .text-lightgray-darker-4 {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-lightgray-darker-4-rgb), var(--bs-text-opacity)) !important;
  }

  .text-lightgray-darker-5 {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-lightgray-darker-5-rgb), var(--bs-text-opacity)) !important;
  }

  .table-asset-card-inactive > :not(caption) > * > * {
    border-bottom-width: 0px;
  }
  .table-asset-card-inactive > tbody tr:nth-child(odd) {
    background-color: var(--bs-lightgray-darker-1);
  }
  .table-asset-card-inactive > tbody tr:nth-child(even) {
    background-color: transparent;
  }

</style>

<!-- การ์ด สำหรับใส่ ที่แสดงการ์ดทรัพย์ -->
<div class="card m-0" style="overflow: hidden;">

    <!-- ปุ่มสร้างทรัพย์ แบบลอยซ้ายบน -->
    <div style ="position: absolute; top: 3rem; left:2rem; z-index: 2;">
        
      <div id="circularMenu1" class="circular-menu circular-menu-left">
  
        <a class="floating-btn" onclick="document.getElementById('circularMenu1').classList.toggle('active');">
          <i class="fas fa-plus"></i>
        </a>
      
        <menu class="items-wrapper">
          <a href="#" class="menu-item bg-warning text-dark modal_md" type="button" data-link="{{ route('asset.create') }}?type=load&cusid={{@$dataCusId}}">
            <i class="fas fa-tag"></i>
            <!-- <span class="badge bg-warning text-dark text-center align-items-center my-1 rounded-pill fw-bold">ใช้ทรัพย์จากบันทึกติดตาม</span> -->
            <span class="badge rounded-pill newAssetMenu-helptext">ใช้ทรัพย์จากบันทึกติดตาม</span>
          </a>
          <a href="#" class="menu-item bg-success text-white data-modal-xl" type="button" data-link="{{ route('asset.create') }}?type=new&asset=car&cusid={{@$dataCusId}}">
            <i class="fas fa-car"></i>
            <span class="badge rounded-pill newAssetMenu-helptext">รถยนต์</span>
          </a>
          <a href="#" class="menu-item bg-info text-white data-modal-xl" type="button" data-link="{{ route('asset.create') }}?type=new&asset=moto&cusid={{@$dataCusId}}">
            <i class="fas fa-motorcycle"></i>
            <span class="badge rounded-pill newAssetMenu-helptext">มอเตอร์ไซค์</span>
          </a>
          <a href="#" class="menu-item bg-primary text-white data-modal-xl" type="button" data-link="{{ route('asset.create') }}?type=new&asset=land&cusid={{@$dataCusId}}">
            <i class="fas fa-map"></i>
            <span class="badge rounded-pill newAssetMenu-helptext">ที่ดิน</span>
          </a>

          <a href="#" class="menu-item bg-light text-dark data-modal-xl" type="button" data-link="{{ route('asset.create') }}?type=own&cusid={{@$dataCusId}}">
            <i class="fas fa-people-arrows"></i>
            <span class="badge rounded-pill newAssetMenu-helptext">ย้ายการครอบครอง</span>
          </a>
        </menu>
      
      </div>
  
    </div>
  
    @if( count(@$dataAsset) > 0 )

      <input type="hidden" name="filter_asset" id="filter_asset" value="{{@$filter_asset}}">

      <!-- card-body Asset View 4 Card -->
      <div class="card-body bg-light assetView-card-body-4-card px-0 pb-0">
        @php
          $countAssetCard = count(@$dataAsset);
          $maxAssetPage = max(ceil($countAssetCard / 4), 1);
        @endphp
        <nav aria-label="filter asset card" class="position-absolute end-0 pe-5 filter-asset">
          <ul class="nav nav-pills justify-content-end">
              <li class="nav-item">
                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ตัวกรอง :</a>
              </li>
              <li class="nav-item filter-lastest-asset" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="ดูเฉพาะทรัพย์ล่าสุด" aria-label="List">
                  <a @class(['nav-link', 'active' => @$filter_asset == 'lastest']) onclick="FilterAsset(this)" data-filter="lastest" data-cusid="{{@$dataCusId}}">
                      <i class="fas fa-box"></i>
                  </a>
              </li>
              <li class="nav-item filter-log-asset" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="ดูประวัติทรัพย์ทั้งหมด" aria-label="Grid">
                  <a @class(['nav-link', 'active' => @$filter_asset == 'log']) onclick="FilterAsset(this)" data-filter="log" data-cusid="{{@$dataCusId}}">
                    <i class="fas fa-boxes"></i>
                  </a>
              </li>
          </ul>
        </nav>
        <nav @style([
          'visibility: visible;'
          //'visibility: hidden;' => ($maxAssetPage == 1),
        ])>
          <ul class="pagination justify-content-center pagination-asset-4card">
            <li class="page-item prev">
              <a class="page-link" href="#carouselAssetList_c4" role="button" data-bs-slide="prev" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            {{-- Create Asset Page Button --}}
            @for ($i = 0; $i < $maxAssetPage; $i++)
              <li class="page-item {{ $i == 0 ? "active" : '' }} assetPageBtn4Card"><a class="page-link" data-bs-target="#carouselAssetList_c4" data-bs-slide-to="{{ $i }}">{{ $i+1 }}</a></li>
            @endfor
            <li class="page-item next">
              <a class="page-link" href="#carouselAssetList_c4" role="button" data-bs-slide="next" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
        {{-- var_dump(@$dataAsset) --}}
        {{-- $countAssetCard --}}
        <div id="carouselAssetList_c4" class="carousel carousel-asset-4card slide" data-bs-interval="false">
          <div class="carousel-inner" style="min-height: 42rem; max-height: 40rem;">
            {{-- Create All Asset Pages (1 Page have 4 Card) --}}
            @for($assetPageIndex = 0; $assetPageIndex < $maxAssetPage; $assetPageIndex++)
              <div class="carousel-item {{ $assetPageIndex == 0 ? 'active' : ''}}">
                <div class="row p-3 px-4">
                  @php
                    $is_last_asset_page = ($assetPageIndex + 1 == $maxAssetPage);
                    if ($is_last_asset_page) {
                      $assetCardMax = fmod( $countAssetCard, 4);
                      if ($assetCardMax == 0) {
                        $assetCardMax = 4;
                      }
                    } else {
                      $assetCardMax = 4;
                    }
                  @endphp
                  {{-- Create Each Asset Card --}}
                  @for($assetCardIndex = 0; $assetCardIndex < $assetCardMax; $assetCardIndex++)
                    <div class="col-lg-6 px-3" >
                        {{-- Asset Card --}}
                        @php
                          $assetCardNumber = ($assetPageIndex * 4) + $assetCardIndex + 1;
                          $_dataOwnership = $dataAsset[$assetCardNumber - 1];
                          $_dataAssetCard = $_dataOwnership->OwnershipToAsset;
                          $_dataAssetDeatil = $_dataOwnership->OwnershipToAssetDetail;
                        @endphp
                        @component('components.content-asset.card-asset-info-cus')
                          @slot( 'index', $assetCardNumber )
                          @slot( 'page', 'cus')
                          @slot( 'data', [
                            'assetId' => $_dataAssetCard->id,

                            'ownershipId' => $_dataOwnership->id,
                            'ownershipState' => $_dataOwnership->State_Ownership,
                            'ownershipStateName' => $_dataOwnership->StatusOwnership->name_th,
                            'cusId' => $_dataOwnership->DataCus_Id,
                            
                            'assetCode' => $_dataAssetCard->Code_Asset,
                            'assetState' => $_dataAssetCard->Status_Asset,
  
                            'typeAssetCode' => $_dataAssetCard->TypeAsset_Code,
                            'typeAssetName' => @$_dataAssetCard->AssetToTypeAsset->Name_TypeAsset,
  
                            'assetYear' => (
                              $_dataAssetCard->TypeAsset_Code == "car" ?
                                @$_dataAssetCard->AssetToCarYear->Year_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "moto" ?
                                  @$_dataAssetCard->AssetToMotoYear->Year_moto : ''
                                )
                            ),
                            'assetBrand' => (
                              $_dataAssetCard->TypeAsset_Code == "car" ?
                                $_dataAssetCard->AssetToCarBrand->Brand_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "moto" ?
                                  $_dataAssetCard->AssetToMotoBrand->Brand_moto : ''
                                )
                            ),
  
                            'assetMainType' => (
                              $_dataAssetCard->TypeAsset_Code == "car" || $_dataAssetCard->TypeAsset_Code == "moto" ?
                                @$_dataAssetCard->AssetToCarType->nametype_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "land" ?
                                  @$_dataAssetCard->DataAssetToLandType->nametype_car : '-'
                                )
                            ),
  
                            'assetPrice' => $_dataAssetCard->Price_Asset,
  
                            'assetOccupiedDT' => @$_dataAssetDeatil->OccupiedDT,
                            'assetOccupiedTime' => @$_dataAssetDeatil->OccupiedTime,
  
                            // ข้อมูลเฉพาะของรถ
                            'assetOldLicense' => $_dataAssetCard->Vehicle_OldLicense,
                            'assetNewLicense' => ( 
                              $_dataAssetCard->Vehicle_NewLicense != null ?
                                $_dataAssetCard->Vehicle_NewLicense : '-'
                            ),
                            'assetChassis' => $_dataAssetCard->Vehicle_Chassis,
                            'assetEngine' => $_dataAssetCard->Vehicle_Engine,
  
                            // ข้อมูลเฉพาะของที่ดิน
                            'assetLandId' => $_dataAssetCard->Land_Id,
                            'assetParcelNumber' => $_dataAssetCard->Land_ParcelNumber,
                            'assetSheetNumber' => $_dataAssetCard->Land_SheetNumber,
                            'assetTambonNumber' => $_dataAssetCard->Land_TambonNumber,
  
                            'assetUserInsert' => $_dataAssetCard->getUserInsert(),

                            'assetLastUpdate' => @$_dataAssetCard->getLastUpdate(),
                          ])
                         
                          @if( $_dataAssetCard->TypeAsset_Code == "car" )
                            @if( @$_dataAssetDeatil == NULL)
                              @slot( 'InsuranceCar', [
                                'InsEXP' => false,
                                'InsWarning' => false,
                                'InsActEXP' => false,
                                'InsActWarning' => false,
                                'InsRegisterEXP' => false,
                                'InsRegisterWarning' => false,
                              ])
                            @else
                              @slot( 'InsuranceCar', [
                                'InsEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', false),
                                'InsWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', true),
    
                                'InsActEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', false),
                                'InsActWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', true),
    
                                'InsRegisterEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', false),
                                'InsRegisterWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', true),
                              ])
                            @endif
                          @endif
                        @endcomponent
                    </div>
                  @endfor
                </div>
              </div>
            @endfor
  
  
          </div>
        </div>
      </div>
  
      <!-- card-body Asset View 2 Card -->
      <div class="card-body bg-light assetView-card-body-2-card px-0 pb-0">
        @php
          $countAssetCard = count(@$dataAsset);
          $maxAssetPage = max(ceil($countAssetCard / 2), 1);
        @endphp
        <nav aria-label="filter asset card" class="position-absolute end-0 pe-5 filter-asset">
          <ul class="nav nav-pills justify-content-end">
              <li class="nav-item">
                  <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ตัวกรอง :</a>
              </li>
              <li class="nav-item filter-lastest-asset" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="ดูเฉพาะทรัพย์ล่าสุด" aria-label="List">
                  <a @class(['nav-link', 'active' => @$filter_asset == 'lastest']) onclick="FilterAsset(this)" data-filter="lastest" data-cusid="{{@$dataCusId}}">
                      <i class="fas fa-box"></i>
                  </a>
              </li>
              <li class="nav-item filter-log-asset" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="ดูประวัติทรัพย์ทั้งหมด" aria-label="Grid">
                  <a @class(['nav-link', 'active' => @$filter_asset == 'log']) onclick="FilterAsset(this)" data-filter="log" data-cusid="{{@$dataCusId}}">
                    <i class="fas fa-boxes"></i>
                  </a>
              </li>
          </ul>
        </nav>
        <nav @style([
          'visibility: visible;'
          //'visibility: hidden;' => ($maxAssetPage == 1),
        ])>
          <ul class="pagination justify-content-center pagination-asset-2card">
            <li class="page-item">
              <a class="page-link" href="#carouselAssetList_c2" role="button" data-bs-slide="prev" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            {{-- Create Asset Page Button --}}
            @for ($i = 0; $i < $maxAssetPage; $i++)
              <li class="page-item {{ $i == 0 ? "active" : '' }}"><a class="page-link" data-bs-target="#carouselAssetList_c2" data-bs-slide-to="{{ $i }}">{{ $i+1 }}</a></li>
            @endfor
            <li class="page-item">
              <a class="page-link" href="#carouselAssetList_c2" role="button" data-bs-slide="next" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
        {{-- @$dataAsset --}}
        {{-- $countAssetCard --}}
        <div id="carouselAssetList_c2" class="carousel carousel-asset-2card slide" data-bs-interval="false">
          <div class="carousel-inner" style="min-height: 42rem; max-height: 40rem;">
            {{-- Create All Asset Pages (1 Page have 2 Card) --}}
            @for($assetPageIndex = 0; $assetPageIndex < $maxAssetPage; $assetPageIndex++)
              <div class="carousel-item {{ $assetPageIndex == 0 ? 'active' : ''}}">
                <div class="row py-3">
                  @php
                    $is_last_asset_page = ($assetPageIndex + 1 == $maxAssetPage);
                    if ($is_last_asset_page) {
                      $assetCardMax = fmod( $countAssetCard, 2);
                      if ($assetCardMax == 0) {
                        $assetCardMax = 2;
                      }
                    } else {
                      $assetCardMax = 2;
                    }
                  @endphp
                  {{-- Create Each Asset Card --}}
                  @for($assetCardIndex = 0; $assetCardIndex < $assetCardMax; $assetCardIndex++)
                    <div class="col-12 px-5">
                        {{-- Asset Card --}}
                        @php
                          $assetCardNumber = ($assetPageIndex * 2) + $assetCardIndex + 1;
                          $_dataOwnership = $dataAsset[$assetCardNumber - 1];
                          $_dataAssetCard = $_dataOwnership->OwnershipToAsset;
                          $_dataAssetDeatil = $_dataOwnership->OwnershipToAssetDetail;
                          
                        @endphp
                        @component('components.content-asset.card-asset-info-cus')
                          @slot( 'index', $assetCardNumber )
                          @slot( 'page', 'cus')
                          @slot( 'data', [
                            'assetId' => $_dataAssetCard->id,

                            'ownershipId' => $_dataOwnership->id,
                            'ownershipState' => $_dataOwnership->State_Ownership,
                            'ownershipStateName' => $_dataOwnership->StatusOwnership->name_th,
                            'cusId' => $_dataOwnership->DataCus_Id,

                            'assetCode' => $_dataAssetCard->Code_Asset,
                            'assetState' => $_dataAssetCard->Status_Asset,
  
                            'typeAssetCode' => $_dataAssetCard->TypeAsset_Code,
                            'typeAssetName' => @$_dataAssetCard->AssetToTypeAsset->Name_TypeAsset,
  
                            'assetYear' => (
                              $_dataAssetCard->TypeAsset_Code == "car" ?
                                @$_dataAssetCard->AssetToCarYear->Year_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "moto" ?
                                  @$_dataAssetCard->AssetToMotoYear->Year_moto : ''
                                )
                            ),
                            'assetBrand' => (
                              $_dataAssetCard->TypeAsset_Code == "car" ?
                                $_dataAssetCard->AssetToCarBrand->Brand_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "moto" ?
                                  $_dataAssetCard->AssetToMotoBrand->Brand_moto : ''
                                )
                            ),
  
                            'assetMainType' => (
                              $_dataAssetCard->TypeAsset_Code == "car" || $_dataAssetCard->TypeAsset_Code == "moto" ?
                                @$_dataAssetCard->AssetToCarType->nametype_car :
                                (
                                  $_dataAssetCard->TypeAsset_Code == "land" ?
                                  @$_dataAssetCard->DataAssetToLandType->nametype_car : '-'
                                )
                            ),
  
                            'assetPrice' => $_dataAssetCard->Price_Asset,
  
                            'assetOccupiedDT' => @$_dataAssetDeatil->OccupiedDT,
                            'assetOccupiedTime' => @$_dataAssetDeatil->OccupiedTime,
  
                            // ข้อมูลเฉพาะของรถ
                            'assetOldLicense' => $_dataAssetCard->Vehicle_OldLicense,
                            'assetNewLicense' => ( 
                              $_dataAssetCard->Vehicle_NewLicense != null ?
                                $_dataAssetCard->Vehicle_NewLicense : '-'
                            ),
                            'assetChassis' => $_dataAssetCard->Vehicle_Chassis,
                            'assetEngine' => $_dataAssetCard->Vehicle_Engine,
  
                            // ข้อมูลเฉพาะของที่ดิน
                            'assetLandId' => $_dataAssetCard->Land_Id,
                            'assetParcelNumber' => $_dataAssetCard->Land_ParcelNumber,
                            'assetSheetNumber' => $_dataAssetCard->Land_SheetNumber,
                            'assetTambonNumber' => $_dataAssetCard->Land_TambonNumber,
  
                            'assetUserInsert' => $_dataAssetCard->getUserInsert(),
                            'assetLastUpdate' => @$_dataAssetCard->getLastUpdate(),
                          ])
                          @if( $_dataAssetCard->TypeAsset_Code == "car" )
                            @if( @$_dataAssetDeatil == NULL)
                              @slot( 'InsuranceCar', [
                                'InsEXP' => false,
                                'InsWarning' => false,
                                'InsActEXP' => false,
                                'InsActWarning' => false,
                                'InsRegisterEXP' => false,
                                'InsRegisterWarning' => false,
                              ])
                            @else
                              @slot( 'InsuranceCar', [
                                'InsEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', false),
                                'InsWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceDT', true),
    
                                'InsActEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', false),
                                'InsActWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceActDT', true),
    
                                'InsRegisterEXP' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', false),
                                'InsRegisterWarning' => @$_dataAssetDeatil->CheckExpired('InsuranceRegisterDT', true),
                              ])
                            @endif
                          @endif
                          @slot( 'dataAsset', $_dataAssetCard )

                        @endcomponent
                    </div>
                  @endfor
                </div>
              </div>
            @endfor
  
  
          </div>
        </div>
      </div>
  
      <div class="card-footer py-3">
        <div class="d-flex justify-content-between row">
          <div class="d-flex col-12 col-lg-6">
            <span class="text-dark pe-1">
              <i class="bx bx-archive fs-5 me-1"></i> ทรัพย์ทั้งหมด <strong>{{count(@$dataAsset)}}</strong> รายการ</span>
            {{-- 
            <span>
              <em>(รถยนต์: <strong class="text-success">{{count(@$dataAsset->where('TypeAsset_Code', 'car'))}}</strong>, มอเตอร์ไซค์: <strong class="text-info">{{count(@$dataAsset->where('TypeAsset_Code', 'moto'))}}</strong>, ที่ดิน: <strong class="text-primary">{{count(@$dataAsset->where('TypeAsset_Code', 'land'))}}</strong>)</em>
            </span>
            --}}
          </div>
          <div class="d-flex flex-row-reverse col-12 col-lg-6">
            <em>
              <span><i class="bx bxs-time-five fs-5 me-1"></i> แก้ไขครั้งสุดท้ายเมื่อ</span>
              <span>{{ \Carbon\Carbon::parse( max( @$dataAsset->max('updated_at'), @$dataAsset->max('Data_AssetsDetails.updated_at') ) )->locale('th_TH')->diffForHumans() }}</span>
            </em>
          </div>
        </div>
      </div>
  
    @else
  
      <div class="card h-100 m-0 assetView-nodata-card">
        <div class="card-body h-100 d-flex">
          <div class="m-auto d-flex flex-column align-items-center justify-content-center opacity-50">
            <h1 class="fw-bold">- ไม่มีทรัพย์ที่กำลังครอบครอง -</h1>
            <h1 class="card-title align-center">สามารถกดปุ่ม <i class="bx bx-plus-circle"></i> ซ้ายบนเพื่อสร้างทรัพย์ใหม่</h1>
          </div>
        </div>
      </div>
  
    @endif
  
</div>

<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>