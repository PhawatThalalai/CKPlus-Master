@include('public-js.scriptVehRate')
@include('components.content-calcufinance.Calculate_HY.script')
@include('components.content-calcufinance.Calculate_HY.scriptForSpeacialCase')

<style>
    .disabledDiv {
        pointer-events: none; /* Disable mouse interactions */
        opacity: 0.5; /* Visual indication of being disabled */
        background-color: #ccc; /* Gray out the background */
    }
</style>

<div class="modal-content">
  <div class="row me-4 mt-2">
      <div class="d-flex m-3">
            <div class="flex-shrink-0 me-4">
                  {{-- <img src="{{ URL::asset('\assets/images/calculator.png') }}" alt="" style="width: 40px;"> --}}
            </div>
            <div class="flex-grow-1 ">
                <h6 class="text-primary fw-semibold p1-2">ระบบคำนวณยอดจัดไฟแนนซ์ (System for Calculating)</h6>
                <p class="border-primary border-bottom mb-0"></p>
            </div>
        </div>


    </div>
  <div class="modal-body bg-light">
    <div class="container" style="max-width: 90%;">
        <form id="form-Calculates" class="needs-validation">
            @csrf
            <input type="hidden" name="funs" value="Interest-HYNK" />
            <input type="hidden" name="Flagtag" value="1" />
            <input type="hidden" name="DataTag_id" value="{{@$tags->id}}" />
            <input type="hidden" name="Cal_id" id="Cal_id" value="{{@$tags->TagToCulculate->id}}" />
            <input type="hidden" name="DataCus_id" value="{{@$tags->DataCus_id}}" />
            <input type="hidden" name="Type_Customer" id="Type_Customer" value="{{ @$tags->Type_Customer}}">
            <input type="hidden"  name = "Credo_Score" id = "Credo_Score" value="{{ @$tags->Credo_Score }}">
            <input type="hidden"  name = "checkCase" id = "checkCase" value="{{ @$tags->TagToCulculate->Note_Cal }}">
            <input type="hidden"  name = "FlagPage" id = "FlagPage" value="{{ @$FlagPage }}">


            <div class="row mb-2 g-2">
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="card h-100 border border-secondary border-opacity-25 border-2">
                        <div class="card-body">
                        <span id="formAsset">
                            <h6 class="fw-semibold mb-3">ข้อมูลทรัพย์สิน (Data Asset)</h6>
                            <div class="row mb-1 g-1 align-self-center">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger" >ประเภทสัญญา :</label> --}}
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-0">
                                <div class="form-floating">

                                <select name="Type_Customer" id="SLType_Customer" class="form-select text-dark bg-light" placeholder=" " required style="pointer-events: none;">
                                    <option value="" selected>--- ประเภทลูกค้า ---</option>
                                    @foreach ($typeCus as $key => $value)
                                    <option value="{{ $value->Code_Cus }}" {{ $value->Code_Cus == @$tags->Type_Customer ? 'selected' : '' }}>({{ $value->Code_Cus }}) - {{ $value->Name_Cus }}</option>
                                    @endforeach
                                </select>
                                <label  class="text-danger">ประเภทลูกค้า</label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select name="TypeLoans" id="TypeLoans" class="form-select  text-dark  TypeLoans" aria-label="Floating label select " style="pointer-events:{{@$tags->TagToContracts!=NULL?'none':'block'}}" required>
                                    <option value="" >--- ประเภทสัญญา ---</option>
                                    @foreach($TypeLoan as $key => $value)
                                        <option value="{{$value->id_rateType}}" {{(@$tags->TagToCulculate->CodeLoans==$value->Loan_Code)?'selected':''}} >{{$value->Loan_Code}} - {{$value->Loan_Name}}</option>
                                    @endforeach
                                    </select>
                                    <label class="text-danger">ประเภทสัญญา</label>
                                </div>
                                <input type="hidden" name="CodeLoans" id="CodeLoans" value="{{@$tags->TagToCulculate->CodeLoans}}" class="form-control "/>
                                <input type="hidden" id="assetType_input" name="assetType_input" value="{{@$tags->TagToCulculate->TypeLoans}}">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select name="TypeAssetsPoss" id="TypeAssetsPoss" class="form-select text-dark" aria-label="Floating label select " required>
                                    <option value="" >--- ประเภทการครอบครอง ---</option>
                                    @foreach($TypeAssetsPoss as $key => $value)
                                        <option value="{{$value->Name_TypePoss}}" data-code="{{$value->Code_TypePoss}}" {{(@$tags->TagToCulculate->TypeAssetsPoss==$value->Name_TypePoss)?'selected':''}} >{{$value->Name_TypePoss}}</option>
                                    @endforeach
                                    </select>
                                    <label class="text-danger">ประเภทการครอบครอง</label>
                                </div>
                            </div>

                            </div>

                            <div class="row  mb-1 g-1 align-self-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select name="RateCartypes" class="form-select text-dark  typeAsset" placeholder="ประเภทรถ">
                                        <option value="" >--- ประเภทรถ ---</option>
                                        @if(@$datatypeCar!=NULL)
                                        @foreach(@$datatypeCar as $typeCar)
                                            <option value="{{$typeCar->code_car}}" {{$typeCar->code_car==@$tags->TagToCulculate->RateCartypes ? 'selected':''}}>{{$typeCar->nametype_car}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="text-danger">ประเภทรถ</label>
                                </div>
                                <input type="hidden" id="v_RateCartypes" name="v_RateCartypes" value="{{@$tags->TagToCulculate->RateCartypes}}">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select class="form-select text-dark Type_PLT" id="Type_PLT" name="Type_PLT" data-bs-toggle="tooltip" title="ประเภทรถ 2" >
                                        <option value="" selected>-- ประเภทรถ 2 --</option>
                                    </select>
                                    <label class="text-danger">ประเภทรถ 2</label>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select class="form-select text-dark brandAsset"  name="RateBrands" data-bs-toggle="tooltip" title="ยี่ห้อรถ" >
                                        <option value="" selected>--- ยี่ห้อรถ ---</option>
                                    </select>
                                    <label class="text-danger">ยี่ห้อรถ</label>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select class="form-select text-dark groupAsset" name="RateGroups" data-bs-toggle="tooltip" title="กลุ่มรถ" >
                                        <option value="" selected>--- กลุ่มรถ ---</option>
                                    </select>
                                    <label class="text-danger">กลุ่มรถ</label>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select class="form-select text-dark yearAsset" data-bs-toggle="tooltip" name="Vehicle_Year" id="Vehicle_Year" title="ปีรถ" >
                                        <option value="" selected>--- ปีรถ ---</option>
                                    </select>
                                    <label class="text-danger">ปีรถ</label>
                                </div>
                                <input type="hidden" name="RateYears" id="RateYears" value="{{@$tags->TagToCulculate->RateYears}}"  class="rateYear">
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0">
                                <div class="form-floating">
                                    <select class="form-select text-dark modelAsset" id="Vehicle_Model" name="RateModals" data-bs-toggle="tooltip" title="รุ่นรถ" >
                                        <option value="" selected>--- รุ่นรถ ---</option>
                                    </select>
                                    <label class="text-danger">รุ่นรถ</label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-0 showGear" >
                                <div class="form-floating">
                                    <select class="form-select text-dark gearCar" id="RateGears" name="RateGears" data-bs-toggle="tooltip" title="เกียร์รถ">
                                        <option value="" selected>--- เกียร์รถ ---</option>
                                    </select>
                                    <label class='text-danger'>เกียร์รถ</label>
                                </div>
                            </div>
                            </div>

                            <div class="row mb-1 g-1" id="StatusInArea">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating">
                                <input type="date" value="{{ \Carbon\Carbon::parse(@$tags->TagToCulculate->DateInArea)->format('Y-m-d') }}" name="DateInArea" id="DateInArea" class="form-control "  max="{{date('Y-m-d')}}">
                                <label class="text-danger">อยู่ในพื้นที่</label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating">
                                    <input type="number" value="{{@$tags->TagToCulculate->NumDateInArea != NULL ? @$tags->TagToCulculate->NumDateInArea : 0}}"  name="NumDateInArea" id="NumDateInArea" class="form-control  " placeholder="อาศัยอยู่ในพื้นที่" style="cursor:no-drop;" readonly>
                                    <label class="text-danger">ปี</label>
                                </div>
                            </div>
                            </div>
                            <div class="row mb-1 g-1" id="StatusPossessday">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating">
                                <input type="date" value="{{ \Carbon\Carbon::parse(@$tags->TagToCulculate->DateOccupiedcar)->format('Y-m-d') }}" name="DateOccupiedcar" id="DateOccupiedcar" class="form-control  " max="{{date('Y-m-d')}}">
                                <!-- <input type="hidden" name="todayOcc" id="todayOcc" value="{{date('Y-m-d')}}" text> -->
                                <input type="hidden" name="todayOcc" id="todayOcc" value="{{ (@$tags->DataCusTagToContracts->Date_con != NULL) ? @$tags->DataCusTagToContracts->Date_con : date('Y-m-d')  }}">
                                <label class="text-danger">วันครอบครอง</label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating">
                                <input type="number" value="{{@$tags->TagToCulculate->NumDateOccupiedcar != NULL ? @$tags->TagToCulculate->NumDateOccupiedcar : 0 }}"  name="NumDateOccupiedcar" id="NumDateOccupiedcar" class="form-control   " placeholder="จำนวนวันครอบครอง" style="cursor:no-drop;" readonly>
                                <label class="text-danger">วัน</label>
                                </div>
                            </div>
                            </div>
                        </span>
                        {{-- <div class="row g-1 mt-2">
                            <div class="col d-grid">
                                <button type="button" onclick="clearInput('formAsset')" id="btn-clearAsset" class="btn btn-secondary rounded-pill btn-sm">ล้างค่าข้อมูลทรัพย์ <i class="bx bxs-eraser"></i></button>
                            </div>
                            <div class="col d-grid">
                                <button type="button" onclick="restore('formAsset')" id="btn-restoreAsset" class="btn btn-light rounded-pill btn-sm">เรียกคืนข้อมูลทรัพย์ <i class="bx bx-history"></i></button>
                            </div>
                        </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg-12 col-md-12 col-sm-12 ">
                    <div class="card h-100 border border-secondary border-opacity-25 border-2">
                    <div class="card-body">
                            <h6 class="fw-semibold mb-3">เรทยอดจัดและราคากลาง (Data Asset)</h6>
                            <div class="col-12 px-4 mt-2">
                                <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" value="ราคากลาง (ปัจจุบัน)" class="form-control fw-semibold" style="border: none;background-color: transparent;resize: none;outline: none;" readonly/>
                                            </td>
                                            <td class="text-end">
                                                <input type="text"  value="{{number_format(@$tags->TagToCulculate->RatePrices)}}"  name="RatePrices" id="RatePrices" class="form-control  Boxcolor-1 ratePrice text-end fw-semibold" style="border: none;background-color: transparent;resize: none;outline: none;"  placeholder="ราคากลาง" readonly/>
                                            </td>
                                        </tr>
                                        <tr class="border-bottom border-2 border-success">
                                            <td>
                                                <input type="text" value="ราคากลาง (คำนวน)" class="form-control fw-semibold" style="border: none;background-color: transparent;resize: none;outline: none;" readonly/>
                                            </td>
                                            <td class="text-end">
                                                <input type="text" value="{{number_format(@$tags->TagToCulculate->RatePrices)}}"  class="form-control Boxcolor-1 text-end fw-semibold" style="border: none;background-color: transparent;resize: none;outline: none;"  placeholder="ราคากลาง" readonly/>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div id="content-LTV">
                                @include('components\content-calcufinance\Calculate_HY\LTV-Rate')
                            </div>
                            </div>

                            {{-- credo score --}}
                            <div class="col-12">
                            <div class="form-group row mb-1 " id="rate_Mid">
                                <label class="col-sm-6 col-form-label text-end ">Credo Score :</label>
                                <div class="col-sm-3">
                                <input type="text" value="{{ @$tags->Credo_Score }}" name="Credo_Score" id="Credo_Score" class="form-control  Boxcolor-1" style="border: none;background-color: transparent;resize: none;outline: none; pointer-events:none;"  placeholder="Credo Score" readonly/>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(@$tags->Type_Customer == 'CUS-0009' || @$FlagPage == 'Y')
            <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link  {{  @$tags->TagToCulculate->Note_Cal != 'Balloon' ? 'active' : '' }}" id="pills-normalCase-tab" data-bs-toggle="pill" data-bs-target="#pills-normalCase" type="button" role="tab" aria-controls="pills-normalCase" aria-selected="true" onclick="disableDuplicateIDs('#pills-specialCase','#pills-normalCase')" >คำนวณปกติ</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link {{  @$tags->TagToCulculate->Note_Cal == 'Balloon' ? 'active' : '' }}" id="pills-specialCase-tab" data-bs-toggle="pill" data-bs-target="#pills-specialCase" type="button" role="tab" aria-controls="pills-specialCase" aria-selected="false" onclick="disableDuplicateIDs('#pills-normalCase','#pills-specialCase')">ปรับโครงสร้าง (Balloon)</button>
                </li>
            </ul>
            @endif

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade {{ @$tags->TagToCulculate->Note_Cal != 'Balloon' ? 'show active' : '' }} " id="pills-normalCase" role="tabpanel" aria-labelledby="pills-normalCase-tab" tabindex="0">
                    {{-- card calculate normal--}}
                    <div class="row mb-2 g-2">
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                            <div class="card h-100 border border-secondary border-opacity-25 border-2">
                                <div class="card-body">
                                    <span id="formFinance">
                                        <span id="formAppraisalPrice" style="{{ @$tags->TagToCulculate->TypeLoans == 'land' || @$tags->TagToCulculate->CodeLoans == '11' ? '' : 'display: none;' }}">
                                        <h6 class="fw-semibold mb-3 mt-3">ราคาประเมิน / ยอดค้างเดิม (Land and Micro)</h5>
                                        <div class="row mb-1 g-1 AppraisalPrice-land" style="{{ @$tags->TagToCulculate->TypeLoans == 'land' ? '' : 'display: none;' }}">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                            <input type="text" value="{{number_format(@$tags->TagToCulculate->RatePrices,2)}}" name="" id="AppraisalPrice" class="form-control input-user" placeholder="ราคาประเมิน" />
                                            <label class=""> ราคาประเมิน :</label>
                                            </div>
                                            </div>
                                            <div class="col-sm-6 d-grid">
                                                <button class="btn btn-secondary" type="button" data-toggle="tooltip" title="">ที่ดิน (Land)</button>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3 g-1 AppraisalPrice-micro" style="{{ @$tags->TagToCulculate->CodeLoans == '11' ? '' : 'display: none;' }}">
                                        <div class="col-sm-6">
                                            <div class="form-floating">
                                            <input type="text" value="" name="" id="" class="form-control input-user" placeholder="ยอดค้างเดิม"/>
                                            <label class=""> ยอดค้างเดิม :</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-grid">
                                            <button class="btn btn-secondary" type="button" data-toggle="tooltip" title="">ไมโคร (Micro)</button>
                                        </div>
                                        </div>
                                        </span>
                                        <h6 class="fw-semibold mb-3">ข้อมูลยอดจัดและดอกเบี้ย (Data Asset)</h6>
                                        <div class="row data-container mt-2">
                                            <div class="col-12">
                                                <div class="form-group row mb-1 g-1">
                                                    <div class="col-sm-6">
                                                        <div class="form-floating input-group">
                                                            <input type="text" value="{{ @$tags->TagToCulculate->Cash_Car != NULL ? number_format(@$tags->TagToCulculate->Cash_Car) : 0 }}" name="Cash_Car" id="Cash_Car" class="form-control" placeholder="ยอดจัด" required/>
                                                            <label class=""> ยอดจัด :</label>
                                                            <span class="input-group-text" id="basic-addon1"><span class="ShowRateLTV">{{number_format(@$tags->TagToCulculate->Percent_Car)}}</span> %</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 d-grid">
                                                        <div class="form-floating">
                                                            <input type="text" value="{{number_format(@$tags->TagToCulculate->Process_Car)}}" name="Process_Car" id="Process_Car"  class="form-control" title="ค่าดำเนินการ" placeholder="ค่าดำเนินการ" readonly/>
                                                            <label class="">ค่าดำเนินการ</label>
                                                        </div>
                                                        {{-- <button class="btn btn-outline-primary" type="button" data-toggle="tooltip" title="LTV(%)"><span class="ShowRateLTV">{{number_format(@$tags->TagToCulculate->Percent_Car)}}</span> %</button> --}}
                                                    </div>

                                                    <div class="row" id="text-alert">
                                                        <div class="col-sm-6" >
                                                            <p class="text-danger">กด Enter หลังใส่ยอดจัด</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <span id="inputCal">
                                                <div class="row mb-1 g-1">
                                                <div class="col-sm-6">
                                                    <div class="form-floating">
                                                        <select  class="form-select addOPR" name="StatusProcess_Car" id="StatusProcess_Car" required >
                                                            <option value="">-- เลือกค่าดำเนินการ --</option>
                                                            <option value="no" selected>- ไม่รวมค่าดำเนินการ </option>
                                                            <option value="yes" {{ ( @$tags->TagToCulculate->StatusProcess_Car == 'yes' ? 'selected' : '' ) }}>+ รวมค่าดำเนินการ </option>
                                                          @if(@$tags->Type_Customer == 'CUS-0009' || @$FlagPage == 'Y')  <option value="notHas" {{ ( strtolower(@$tags->TagToCulculate->StatusProcess_Car) == 'nothas' ? 'selected' : '' ) }}> ไม่คิดค่าดำเนินการ </option> @endif
                                                        </select>
                                                        <label class=""> ค่าดำเนินการ/งวด :</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <select name="Timelack_Car" id="Timelack_Car" class="form-select Timelack_Car" required>
                                                        <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                                        @for($t=12;$t<85;$t=$t+6)
                                                        <option value="{{$t}}"  {{(@$tags->TagToCulculate->Timelack_Car==$t)?'selected':''}}>{{$t}} งวด</option>
                                                        @endfor
                                                    </select>
                                                    <label class=""> ระยะเวลาผ่อน :</label>
                                                </div>
                                                </div>
                                                </div>
                                                <div class="row mb-1 g-1">
                                                <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="text" value="{{number_format(@$tags->TagToCulculate->Interest_Car,2)}}" name="Interest_Car" id="Interest_Car" class="form-control input-user Interest_Car" data-toggle="tooltip" title="ดอกเบี้ยต่อเดือน" placeholder="ดอกเบี้ย" required readonly/>
                                                    <label class=" "> ดอกเบี้ยต่อเดือน </label>
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="text" value="{{number_format(@$tags->TagToCulculate->InterestYear_Car,2)}}" name="InterestYear_Car" id="InterestYear_Car" class="form-control InterestYear_Car input-user"  data-toggle="tooltip" title="ดอกเบี้ยต่อปี" placeholder="ดอกเบี้ยปี" placeholder="รวมดอกเบี้ย" required readonly/>
                                                    <label class=" "> ดอกเบี้ยปี </label>
                                                </div>
                                                </div>
                                                </div>

                                                <h6 class="fw-semibold mb-3 mt-3">ข้อมูลประกัน (Data Asset)</h6>
                                                <div class="row mb-1 g-1">
                                                    <div class="col-sm-6">
                                                        <div class="form-floating">
                                                            <select  class="form-select  Buy_PA" name="Buy_PA" id="Buy_PA" required>
                                                                <option value="" selected>-- เลือกรายการ --</option>
                                                                <option value="no" {{ (@$tags->TagToCulculate->Buy_PA == 'no' ? 'selected' : '') }}>- ไม่ซื้อ </option>
                                                                <option value="yes" {{ (@$tags->TagToCulculate->Buy_PA == 'yes' ? 'selected' : '') }}>+ ซื้อ </option>
                                                            </select>
                                                        <label class="">ประกัน PA :</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-floating">
                                                            <select  class="form-select addPA" name ="Include_PA" id ="Include_PA" required>
                                                            <option value="" selected>-- เลือกรายการ --</option>
                                                            <option value="no" {{ (@$tags->TagToCulculate->Include_PA == 'no' ? 'selected' : '') }}>- ไม่รวม PA </option>
                                                            <option value="yes" {{ (@$tags->TagToCulculate->Include_PA == 'yes' ? 'selected' : '') }}>+ รวม PA </option>
                                                            </select>
                                                            <label class="">รวม PA :</label>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row mb-1">
                                                    <div class="col-sm-12">
                                                    <div class="form-floating">
                                                        <select name="Promotions" id="Promotions" class="form-select">
                                                        <option value="" selected>--- Promotions ---</option>
                                                            @foreach ($dataPro as $key => $item)
                                                            <option value="{{$item->id}}/{{$item->Value_pro}}/{{$item->Type_pro}}" {{ $item->id == @$tags->TagToCulculate->Promotions ? 'selected' : ''}}>{{$key+1}}. {{$item->Name_pro}}</option>
                                                            @endforeach
                                                            <option value="ยกเลิก" class="text-red">ยกเลิก</option>
                                                        </select>
                                                        <label class="text-danger fw-semibold"> <u>Promotions</u> :</label>
                                                    </div>
                                                    </div>
                                                </div>
                                                </span>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="card-footer">
                                    <div class="row g-1">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-grid" >
                                        <button type="button" id="btn-cal" class="btn btn-primary waves-effect waves-light rounded-pill btn-sm">
                                            คำนวณ <i class="bx bx-calculator icon-cal"></i>
                                        </button>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-grid" >
                                        <button type="button" onclick="clearInput('formFinance')" id="btn-clear" class="btn btn-secondary rounded-pill btn-sm">
                                            ล้างค่า <i class="bx bxs-eraser"></i>
                                        </button>
                                    </div>
                                    {{-- <div class="col d-grid restore">
                                        <button type="button" id="btn-restore" class="btn btn-light rounded-pill btn-sm" onclick="restore('formFinance')">
                                        กลับค่าเดิม <i class="bx bx-history"></i>
                                        </button>
                                    </div> --}}
                                    </div>
                                </div>
                                {{-- input text --}}
                                <div id="hiddenNormalCase" class="d-none" >

                                    <p class="mb-0">Note Cal</p>
                                    <input type="text" name="Note_Cal" class="form-control Note_Cal" id="Note_Cal" value="{{ @$tags->TagToCulculate->Note_cal ?? 'Normal' }}"/>

                                    <p class="mb-0">% LTV</p>
                                    <input type="text" name="Percent_Car" class="form-control" id="LTVRate" value="{{(@$tags->TagToCulculate->Percent_Car != NULL) ?(@$tags->TagToCulculate->Percent_Car) : 0}}" placeholder="vat"/>

                                    <p class="mb-0">Vat</p>
                                        <input type="text" name="Vat_Rate" class="form-control" id="Vat_Rate" value="{{(@$tags->TagToCulculate->Vat_Rate != NULL) ?(@$tags->TagToCulculate->Vat_Rate) : 7}}" placeholder="vat"/>
                                    <p class="mb-0">ภาษี</p>
                                        <input type="text" name="Tax_Rate" class="form-control" id="Tax_Rate" value="{{(@$tags->TagToCulculate->Tax_Rate != 0) ?(@$tags->TagToCulculate->Tax_Rate) : 0}}" placeholder="ภาษี"/>
                                    <p class="mb-0">ระยะผ่อน-1</p>
                                        <input type="text" name="Tax2_Rate" class="form-control" id="Tax2_Rate" value="{{(@$tags->TagToCulculate->Tax2_Rate != 0) ?(@$tags->TagToCulculate->Tax2_Rate) : 0}}" placeholder="ระยะผ่อน-1"/>
                                    <p class="mb-0">ค่างวด</p>
                                        <input type="text" name="Duerate_Rate" class="form-control" id="Duerate_Rate" value="{{(@$tags->TagToCulculate->Duerate_Rate != 0) ?(@$tags->TagToCulculate->Duerate_Rate) : 0}}" placeholder="ค่างวด"/>
                                    <p class="mb-0">ค่างวดต่เดือน</p>
                                        <input type="text" name="Period_Rate" id="Period_Rate" value="{{@$tags->TagToCulculate->Period_Rate}}" class="form-control " placeholder="ค่างวดต่อเดือน"/>

                                    <p class="mb-0">ระยะผ่อน-2</p>
                                        <input type="text" name="Duerate2_Rate" class="form-control" id="Duerate2_Rate" value="{{(@$tags->TagToCulculate->Duerate2_Rate != 0) ?(@$tags->TagToCulculate->Duerate2_Rate) : 0}}" placeholder="ระยะผ่อน-2"/>
                                    <p class="mb-0">กำไรจากยอดจัด (ดอกเบี้ยรวม)</p>
                                        <input type="text" name="Profit_Rate" class="form-control" id="Profit_Rate" value="{{(@$tags->TagToCulculate->Profit_Rate != 0) ?(@$tags->TagToCulculate->Profit_Rate) : 0}}" placeholder="กำไรจากยอดจัด"/>
                                    <p class="mb-0">Note_Credo</p>
                                        <input type="text" value="" name="Note_Credo" class="form-control" id="Note_Credo">

                                    {{-- <p class="mb-0">สถานะค่า ดนก</p> --}}
                                        {{-- <input type="text" id="StatusProcess_Car" name="StatusProcess_Car" class="form-control" value="{{@$tags->TagToCulculate->StatusProcess_Car}}"> --}}
                                    {{-- <p class="mb-0">ดอกเบี้ยรวม</p> --}}
                                        {{-- <input type="text" value="{{number_format(@$tags->TagToCulculate->totalInterest_Car,2)}}" name="totalInterest_Car" id="totalInterest_Car" class="form-control totalInterest_Car" placeholder="ดอกเบี้ย" required/> --}}
                                    <p class="mb-0">Promotion !</p>
                                        <input type="text" id="valuePromotion" name="valuePromotion" class="form-control" value="{{@$tags->TagToCulculate->Promotions}}">



                                    <p class="mb-0">PA</p>
                                        <input type="text" value="{{ @$tags->TagToCulculate->Insurance_PA }}" name="Insurance_PA" id="Insurance_PA" class="form-control"  data-toggle="tooltip" title="ประกันบุคคล" placeholder="ประกันบุคคล2"  readonly/>
                                    <p class="mb-0">plan</p>
                                        <input type="text" value="{{ @$tags->TagToCulculate->Plan_PA }}" name="Plan_PA" id="PlanID" class="form-control" data-toggle="tooltip" title="Plan" placeholder="Plan" readonly />
                                    <p class="mb-0">ประกันรถ</p>
                                        <input type="text" value="{{ (float)@$tags->TagToCulculate->Insurance }}" name="Insurance" id="Insurance" class="form-control  insurance" data-toggle="tooltip" title="ประกันรถ" placeholder="ประกันรถ" />
                                    <p class="mb-0">ค่าคอม ฯ</p>

                                    <input type="text" value="{{ number_format(@$tags->TagToCulculate->Commission, 2) }}" name="Commission" id="Commissions">
                                    <p class="mb-0">ยอดทั้งสัญญา</p>
                                    <input type="text" value="{{ number_format(@$tags->TagToCulculate->TotalPeriod_Rate, 2) }}" name="TotalPeriod_Rate" id="SumTotalPeriod">


                                </div>
                                {{-- end hidden --}}
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                            <div class="card h-100 border border-secondary border-opacity-25 border-2">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">ตารางค่างวด (Data Asset)</h6>
                                    <div id="content-table">
                                        @include('components.content-calcufinance.Calculate_HY.tb_install')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ @$tags->TagToCulculate->Note_Cal == 'Balloon' ? 'show active' : '' }} " id="pills-specialCase" role="tabpanel" aria-labelledby="pills-specialCase-tab" tabindex="0">
                    {{-- card calculate Special Case--}}
                    <div class="row mb-2 g-2">
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                            <div class="card h-100 border border-secondary border-opacity-25 border-2">
                                <div class="card-body">
                                    <span id="specialCase">
                                        <span id="formAppraisalPrice" style="display:none;">
                                            <h6 class="fw-semibold mb-3 mt-3">ราคาประเมิน / ยอดค้างเดิม (Land and Micro)</h5>
                                            <div class="row mb-1 g-1 AppraisalPrice-land" style="">
                                                <div class="col-sm-6">
                                                <div class="form-floating">
                                                <input type="text" value="" name="" id="AppraisalPrice" class="form-control input-user" placeholder="ราคาประเมิน" />
                                                <label class=""> ราคาประเมิน :</label>
                                                </div>
                                                </div>
                                                <div class="col-sm-6 d-grid">
                                                    <button class="btn btn-secondary" type="button" data-toggle="tooltip" title="">ที่ดิน (Land)</button>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3 g-1 AppraisalPrice-micro" style="">
                                                <div class="col-sm-6">
                                                    <div class="form-floating">
                                                    <input type="text" value="" name="" id="" class="form-control input-user" placeholder="ยอดค้างเดิม"/>
                                                    <label class=""> ยอดค้างเดิม :</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 d-grid">
                                                    <button class="btn btn-secondary" type="button" data-toggle="tooltip" title="">ไมโคร (Micro)</button>
                                                </div>
                                            </div>
                                        </span>


                                        <h6 class="fw-semibold mb-3">ข้อมูลยอดจัดและดอกเบี้ย (Data Asset)</h6>
                                        <div class="row data-container mt-2">
                                            <div class="col-12">
                                                <div class="form-group row mb-1 g-1">
                                                    <div class="col-sm-6">
                                                        <div class="form-floating input-group">
                                                            <input type="text" value="{{ @$tags->TagToCulculate->Cash_Car != NULL ? number_format(@$tags->TagToCulculate->Cash_Car) : 0 }}" name="Cash_Car" id="Cash_Car" class="form-control" placeholder="ยอดจัด" placeholder="ยอดจัด" required/>
                                                            <label class=""> ยอดจัด :</label>
                                                            <span class="input-group-text" id="basic-addon1"><span class="ShowRateLTVSpecial">{{number_format(@$tags->TagToCulculate->Percent_Car)}}</span> %</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 d-grid">
                                                        <div class="form-floating">
                                                            <input type="text" value="{{ @$tags->TagToCulculate->Period_Rate != NULL ? number_format(@$tags->TagToCulculate->Period_Rate) : 0 }}" name="InstallmentsWant" id="InstallmentsWant" class="form-control" placeholder="ค่างวดที่ต้องการ" placeholder="ค่างวดที่ต้องการ" required/>
                                                            <label class=""> ค่างวดที่ต้องการ :</label>
                                                        </div>
                                                    </div>

                                                </div>


                                                <span id="inputCal">
                                                    <div class="row mb-1 g-1">
                                                        <div class="col-sm-12">
                                                            <div class="form-floating">
                                                                <select name="Timelack_Car" id="Timelack_Car" class="form-select Timelack_Car" required>
                                                                    <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                                                    @for($t=12;$t<85;$t=$t+6)
                                                                    <option value="{{$t}}" {{ @$tags->TagToCulculate->Timelack_Car == $t ? 'selected' : '' }} >{{$t}} งวด</option>
                                                                    @endfor
                                                                </select>
                                                                <label class=""> ระยะเวลาผ่อน :</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-1 g-1">
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <input type="text" value="{{ @$tags->TagToCulculate->InterestYear_Car != NULL ? number_format(@$tags->TagToCulculate->InterestYear_Car,2) : 0.00 }}" name="InterestYear_Car" id="InterestYear_Car" class="form-control InterestYear_Car input-user"  data-toggle="tooltip" title="ดอกเบี้ยต่อปี" placeholder="ดอกเบี้ยปี" placeholder="รวมดอกเบี้ย" required />
                                                                <label class="text-semibold text-danger"> ดอกเบี้ยปี </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <input type="text" value="{{ @$tags->TagToCulculate->Interest_Car != NULL ? number_format(@$tags->TagToCulculate->Interest_Car,2) : 0.00 }}" name="Interest_Car" id="Interest_Car" class="form-control input-user Interest_Car" data-toggle="tooltip" title="ดอกเบี้ยต่อเดือน" placeholder="ดอกเบี้ย" required />
                                                                <label class="text-semibold text-danger"> ดอกเบี้ยต่อเดือน </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <h6 class="fw-semibold mb-3 mt-3">ค่าดำเนินการ (Operate Fee)</h6>
                                                    <div class="row mb-1 g-1">
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <select  class="form-select addOPR" name="StatusProcess_Car" id="StatusProcess_Car" onchange="calculateSpecialCase()"  >
                                                                    <option {{ @$tags->TagToCulculate->StatusProcess_Car == '' ? 'selected' : '' }} value="">-- เลือกค่าดำเนินการ --</option>
                                                                    <option {{ @$tags->TagToCulculate->StatusProcess_Car == 'no' ? 'selected' : '' }} value="no">- ไม่รวมค่าดำเนินการ </option>
                                                                    <option {{ @$tags->TagToCulculate->StatusProcess_Car == 'yes' ? 'selected' : '' }} value="yes">+ รวมค่าดำเนินการ </option>
                                                                </select>
                                                                <label class=""> ค่าดำเนินการ/งวด :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <input type="text" value="{{ @$tags->TagToCulculate->Process_Car ?? 0 }}" name="Process_Car" id="Process_Car"  class="form-control" title="ค่าดำเนินการ" placeholder="ค่าดำเนินการ" oninput="calculateSpecialCase()"/>
                                                                <label class="">ค่าดำเนินการ</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h6 class="fw-semibold mb-3 mt-3">ข้อมูลประกัน (Data Asset)</h6>
                                                    <div class="row mb-1 g-1">
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <select  class="form-select" name="Buy_PA" id="Buy_PA" onchange="calculateSpecialCase()" required>
                                                                    <option {{ strtolower(@$tags->TagToCulculate->Buy_PA) == '' ? 'selected' : '' }} value="" selected>-- เลือกรายการ --</option>
                                                                    <option {{ strtolower(@$tags->TagToCulculate->Buy_PA) == 'no' ? 'selected' : '' }} value="no">- ไม่ซื้อ </option>
                                                                    <option {{ strtolower(@$tags->TagToCulculate->Buy_PA) == 'yes' ? 'selected' : '' }} value="yes">+ ซื้อ </option>
                                                                </select>
                                                            <label class="">ประกัน PA :</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-floating">
                                                                <select  class="form-select addPA" name ="Include_PA" id ="Include_PA" onchange="calculateSpecialCase()">
                                                                <option {{ strtolower(@$tags->TagToCulculate->Include_PA) == '' ? 'selected' : '' }} value="" >-- เลือกรายการ --</option>
                                                                <option {{ strtolower(@$tags->TagToCulculate->Include_PA) == 'no' ? 'selected' : '' }} value="no">- ไม่รวม PA </option>
                                                                <option {{ strtolower(@$tags->TagToCulculate->Include_PA) == 'yes' ? 'selected' : '' }} value="yes">+ รวม PA </option>
                                                                </select>
                                                                <label class="">รวม PA :</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="card-footer">
                                    <div class="row g-1">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-grid" >
                                            <button type="button" id="" onclick="calculateSpecialCase()" class="btn btn-primary waves-effect waves-light rounded-pill btn-sm">
                                                คำนวณ <i class="bx bx-calculator icon-cal"></i>
                                            </button>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-grid" >
                                            <button type="button" onclick="" id="btn-clear" class="btn btn-secondary rounded-pill btn-sm">
                                                ล้างค่า <i class="bx bxs-eraser"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            <div id="hiddenSpecialCase" class="d-none" >
                                <p class="mb-0">Note_cal</p>
                                <input type="text" name="Note_Cal" class="form-control Note_Cal" id="Note_cal" value="{{ @$tags->TagToCulculate->Note_cal }}" placeholder="vat"/>
                                <p class="mb-0">% LTV</p>
                                    <input type="text" name="Percent_Car" class="form-control" id="LTVRate" value="{{(@$tags->TagToCulculate->Percent_Car != NULL) ?(@$tags->TagToCulculate->Percent_Car) : 0}}" placeholder="vat"/>
                                <p class="mb-0">Vat</p>
                                    <input type="text" name="Vat_Rate" class="form-control" id="Vat_Rate" value="{{(@$tags->TagToCulculate->Vat_Rate != NULL) ?(@$tags->TagToCulculate->Vat_Rate) : 7}}" placeholder="vat"/>
                                <p class="mb-0">ภาษี</p>
                                    <input type="text" name="Tax_Rate" class="form-control" id="Tax_Rate" value="{{(@$tags->TagToCulculate->Tax_Rate != 0) ?(@$tags->TagToCulculate->Tax_Rate) : 0}}" placeholder="ภาษี"/>
                                <p class="mb-0">ระยะผ่อน-1</p>
                                    <input type="text" name="Tax2_Rate" class="form-control" id="Tax2_Rate" value="{{(@$tags->TagToCulculate->Tax2_Rate != 0) ?(@$tags->TagToCulculate->Tax2_Rate) : 0}}" placeholder="ระยะผ่อน-1"/>
                                <p class="mb-0">ค่างวด</p>
                                    <input type="text" name="Duerate_Rate" class="form-control" id="Duerate_Rate" value="{{(@$tags->TagToCulculate->Duerate_Rate != 0) ?(@$tags->TagToCulculate->Duerate_Rate) : 0}}" placeholder="ค่างวด"/>
                                <p class="mb-0">ค่างวดต่เดือน</p>
                                    <input type="text" name="Period_Rate" id="Period_Rate" value="{{@$tags->TagToCulculate->Period_Rate}}" class="form-control " placeholder="ค่างวดต่อเดือน"/>

                                <p class="mb-0">ระยะผ่อน-2</p>
                                    <input type="text" name="Duerate2_Rate" class="form-control" id="Duerate2_Rate" value="{{(@$tags->TagToCulculate->Duerate2_Rate != 0) ?(@$tags->TagToCulculate->Duerate2_Rate) : 0}}" placeholder="ระยะผ่อน-2"/>
                                <p class="mb-0">กำไรจากยอดจัด (ดอกเบี้ยรวม)</p>
                                    <input type="text" name="Profit_Rate" class="form-control" id="Profit_Rate" value="{{(@$tags->TagToCulculate->Profit_Rate != 0) ?(@$tags->TagToCulculate->Profit_Rate) : 0}}" placeholder="กำไรจากยอดจัด"/>
                                <p class="mb-0">Note_Credo</p>
                                    <input type="text" value="{{ @$tags->TagToCulculate->Note_Credo }}" name="Note_Credo" class="form-control" id="Note_Credo">

                                <p class="mb-0">ดอกเบี้ยรวม</p>
                                    <input type="text" value="{{number_format(@$tags->TagToCulculate->totalInterest_Car,2)}}" name="totalInterest_Car" id="totalInterest_Car" class="form-control totalInterest_Car" placeholder="ดอกเบี้ย" required/>
                                <p class="mb-0">Promotion !</p>
                                    <input type="text" id="valuePromotion" name="valuePromotion" class="form-control" value="{{@$tags->TagToCulculate->Promotions}}">

                                <p class="mb-0">PA</p>
                                    <input type="text" value="{{ @$tags->TagToCulculate->Insurance_PA }}" name="Insurance_PA" id="Insurance_PA" class="form-control"  data-toggle="tooltip" title="ประกันบุคคล" placeholder="ประกันบุคคล2"  readonly/>
                                <p class="mb-0">plan</p>
                                    <input type="text" value="{{ @$tags->TagToCulculate->Plan_PA }}" name="Plan_PA" id="PlanID" class="form-control" data-toggle="tooltip" title="Plan" placeholder="Plan" readonly />
                                <p class="mb-0">ประกันรถ</p>
                                    <input type="text" value="{{ (float)@$tags->TagToCulculate->Insurance }}" name="Insurance" id="Insurance" class="form-control  insurance" data-toggle="tooltip" title="ประกันรถ" placeholder="ประกันรถ" />
                                <p class="mb-0">ค่าคอม ฯ</p>

                                <input type="text" value="{{ number_format(@$tags->TagToCulculate->Commission, 2) }}" name="Commission" id="Commissions">
                                <p class="mb-0">ยอดทั้งสัญญา</p>
                                <input type="text" value="{{ number_format(@$tags->TagToCulculate->TotalPeriod_Rate, 2) }}" name="TotalPeriod_Rate" id="SumTotalPeriod">


                            </div>

                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                            <div class="card h-100 border border-secondary border-opacity-25 border-2">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">ตารางค่างวด (Data Asset)</h6>
                                    <div id="content-table">
                                        <div class="table-responsive mt-2" style="max-height : 450px;">
                                            <table class="table table-sm text-center table-hover ">
                                                    <thead class="bg-secondary bg-soft">
                                                        <tr class="boerder border-1 border-bottom border-dark">
                                                            <th>งวด</th>
                                                            <th>ยอดจัด</th>
                                                            <th>ดอกเบี้ย</th>
                                                            <th>ยอดผ่อน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TB-InstallmentSpecials">
                                                        @for($i=1 ; $i<=@$tags->TagToCulculate->Timelack_Car ; $i++)
                                                        <tr class="">
                                                            <th>{{ @$i }}</th>
                                                            <td>{{number_format(@$tags->TagToCulculate->Cash_Car + @$tags->TagToCulculate->Process_Car + @$tags->TagToCulculate->Insurance_PA,0)}}</td>
                                                            <td>{{@$tags->TagToCulculate->InterestYear_Car}}</td>
                                                            <th>{{ $i==@$tags->TagToCulculate->Timelack_Car ? number_format(@$tags->TagToCulculate->TotalPeriod_Rate - (@$tags->TagToCulculate->Period_Rate * (@$tags->TagToCulculate->Timelack_Car -1)),0) : number_format(@$tags->TagToCulculate->Period_Rate,0)}}</th>
                                                        </tr>
                                                        @endfor
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>





            <div class="row">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card h-100 border border-secondary border-opacity-25 border-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-6 col-md-12">
                                  <div class="">
                                    <div class="">
                                      <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                          <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                            <i class="bx bx-copy-alt"></i>
                                          </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0 text-decoration-underline">ผลการคำนวณ</h5>
                                      </div>

                                      <div class="text-muted mt-0 ms-5 mt-n3">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                            <tbody class="" style="line-height: 130%;">
                                                <tr>
                                                <td>ค่างวดต่อเดือน :</td>
                                                <th class="text-end">
                                                    <span id="ShowPeriod">{{ @$tags->TagToCulculate->Period_Rate }}</span>
                                                    <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
                                                </th>
                                                </tr>
                                                <tr>
                                                <td>ยอดทั้งสัญญา :</td>
                                                <th class="text-end">
                                                    <span id="ShowTotalPeriod">{{number_format(@$tags->TagToCulculate->TotalPeriod_Rate,2)}}</span>
                                                    <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
                                                </th>
                                                </tr>
                                                <tr>
                                                <td>ค่าดำเนินการ :</td>
                                                <th class="text-end">
                                                    <span id="ShowOPR">{{ @$tags->TagToCulculate->Process_Car }}</span>
                                                    <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
                                                </th>
                                                </tr>
                                                <tr>
                                                <td>ค่าแนะนำ :</td>
                                                <th class="text-end">
                                                    <span id="viewCommision">{{ @$tags->TagToCulculate->Commission }}</span>
                                                    <i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
                                                </th>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-12 text-center">
                                          <div class="mt-3">
                                            <p class="text-muted mb-1">เปอร์เซ็นจัดไฟแนนซ์</p>
                                            <span id="" class="font-size-18 ShowRateLTV">{{ @$tags->TagToCulculate->Percent_Car }}</span>
                                            <i class="mdi mdi-percent ms-1 text-success"></i>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xl-6 col-md-12 ">
                                  <div class="">
                                    <div class="">
                                      <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                          <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                            <i class="bx bx-copy-alt"></i>
                                          </span>
                                        </div>
                                        <h5 class="font-size-14 mb-0 text-decoration-underline">รายละเอียดประกัน PA</h5>
                                      </div>
                                      <div class="text-muted mt-0 ms-5 mt-n3">
                                        <div class="table-responsive">
                                          <table class="table table-sm">
                                            <tbody class="" style="line-height: 130%;">
                                              <tr>
                                                <td>แผน :</td>
                                                <th class="text-end">
                                                 <span></span> <span class="showPlan_PA"> {{ @$tags->TagToCulculate->DataCalcuToPA->Plan_Insur }}</span>
                                                </th>
                                              </tr>
                                              <tr>
                                                <td>ทุนประกัน :</td>
                                                <th class="text-end">
                                                  <span class="capital_PA">{{ @$tags->TagToCulculate->DataCalcuToPA->Limit_Insur }} </span> <span><i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i></span>
                                                </th>
                                              </tr>
                                              <tr>
                                                <td>ระยะเวลาประกันภัย :</td>
                                                <th class="text-end">
                                                  <span class="TimeLackPA">{{ @$tags->TagToCulculate->Timelack_Car/12 }} </span> <span>ปี</span>
                                                </th>
                                              </tr>
                                              <tr>
                                                <td>เบี้ยประกันภัย(รวมภาษีอากร) :</td>
                                                <th class="text-end">
                                                  <span class="periodPAtotal">{{ @$tags->TagToCulculate->Insurance_PA }} </span> <span><i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i></span>
                                                </th>
                                              </tr>
                                            </tbody>
                                          </table>
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
        </form>
    </div>
  </div>
    <div class="modal-footer">
        @php
            $role = array('administrator','manager','audit');
            $roleNum =auth()->user()->roles()->whereIn('name',$role)->get()->count();
        @endphp

        @if(@$FlagPage!="Y")
            @if(@$tags->TagToContracts->Date_monetary==NULL||$roleNum>0)
                @if((@$tags->TagToContracts->ConfirmApp_Con==NULL)||$roleNum>0)
                    <button type="button" id="save" class="btn btn-success btn-sm  hover-up">
                        <i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
                    </button>
                @endif
            @endif
        @endif
            {{-- <button type="button" onclick="testPABTN()" class="btn btn-danger">test btn PA</button> --}}

        <button type="button" class="btn btn-danger btn-sm hover-up SizeText btn-closeCal" class="close" data-bs-dismiss="modal" aria-label="Close">ปิด</button>
    </div>
</div>




