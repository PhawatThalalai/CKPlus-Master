
@include('public-js.scriptVehRate')

{{-- @include('public-js.scriptDataRate') --}}
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>
<style>
  .category {
      text-transform: capitalize;
      font-weight: 700;
      color: #9A9A9A;
  }
  .nav-item .nav-link,
  .nav-tabs .nav-link {
      -webkit-transition: all 300ms ease 0s;
      -moz-transition: all 300ms ease 0s;
      -o-transition: all 300ms ease 0s;
      -ms-transition: all 300ms ease 0s;
      transition: all 300ms ease 0s;
  }
  .tab-Calculate .nav-tabs {
      border: 0;
      padding: 5px 0.7rem;
  }
  .tab-Calculate .nav-tabs>.nav-item>.nav-link {
      color: #888888;
      margin: 0;
      margin-right: 5px;
      background-color: transparent;
      border: 1px solid transparent;
      border-radius: 30px;
      font-size: 14px;
      padding: 11px 23px;
      line-height: 1.5;
  }
  .tab-Calculate .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
      color: #FFFFFF;
  }
  .tab-Calculate .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
      background-color: rgba(255, 255, 255, 0.2);
      color: #FFFFFF;
  }
  .card[data-background-color="orange"] {
      background-color: #f96332;
  }
  [data-background-color="orange"] {
      background-color: #e95e38;
  }
  .data-container {
    background: #eeeeee75;
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .btn-orange {
    background-color: #f96332;
    color: #FFFFFF;
  }
  .showData {
    background: #f96332;
    border-radius: 6px;
    padding: 20px;
    padding-top: 5pt;
    height: 28pt;
  }

  input[type='date']::-webkit-inner-spin-button {
	display: none;
	-webkit-appearance: none;
}

input[type="date"]::-webkit-calendar-picker-indicator {
	opacity: 1;
	background: transparent;
	bottom: 0;
	color: transparent;
	cursor: pointer;
	height: auto;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	width: auto;

}
</style>

  
  <div class="modal-content">
    <div class="modal-body">
      {{-- <div class="loading-overlay d-flex flex-column justify-content-center align-items-center" id="loading-close-AC" style="display: none !important">
        <div class="spinner-border d-flex text-light" style="width: 5rem; height: 5rem;" role="status">
        </div>
        <h3 class="d-flex text-light mt-3">กำลังโหลด...</h3>
      </div> --}}
    <form name="createCalculates" id="createCalculates"  class="form-Validate needs-validation" method="post"  enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="type" value="6" />
      <input type="hidden" name="DataTag_id" id="DataTag_id" value="{{@$tags->id}}" />
      <input type="hidden" name="Cal_id" id="Cal_id" value="{{@$tags->TagToCulculate->id}}" />
      <input type="hidden" name="DataCus_id" value="{{@$tags->DataCus_id}}" />
      <input type="hidden" name="Loan_Group" value="{{@$tags->TagToCulculate->DataCalcuToTypeLoan->Loan_Group}}" />
      <input type="hidden" id="CheckPage" value="{{$disable}}">
      <input type="hidden" id="Limit_Insur" value="{{$Limit_Insur}}">
      <input type="hidden" name="TotalPeriodNonPa" id="TotalPeriodNonPa" value="{{@$tags->TagToCulculate->TotalPeriodNonPa}}"  />
      <input type="hidden" name="Flag_Interest" id="Flag_Interest" value="{{@$tags->TagToCulculate->Flag_Interest}}"  />
      @php
            
      $roleNum = 0;
      $userArr = ['administrator', 'manager','superadmin','audit'];
      $userRole = auth()->user()->getRoleNames();
      $chkRole = $userRole->filter(function ($item) use ($userArr) {
          return in_array($item, $userArr);
      });
      $roleNum = count($chkRole);

    
  @endphp
      <div class="row">
        <div class="d-flex m-3">
          <div class="flex-shrink-0 me-4 mt-2">
            <img src="{{ URL::asset('\assets/images/contract/money.png') }}" alt="" style="width: 40px;">
          </div>
          <div class="flex-grow-1 overflow-hidden">
            <div class="float-end">
            
                <button type="button" class="btn btn-white" data-bs-dismiss="modal" tabindex="-1" aria-label="Close" style="font-size: 15pt; margin-top: -10pt">
                  <span aria-hidden="true">x</span>
                </button>
              </div> 
              <h5 class="text-primary fw-semibold pt-2">ระบบคำนวณยอดจัดไฟแนนซ์</h5>
              <p class="border-primary border-bottom mt-2"></p>
          </div>
        </div>
        <div class="content-loading m-3" style="display: none !important">
          <br><br>
          <div class="lds-facebook mb-6">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
        <div class="col-md-12 content-rate"  >
          <div class="card ">
            <div class="card-body">
              <div class="tab-content text-center">
                <div class="tab-pane active" id="Page1" role="tabpanel">
                  <div class="row mb-3">
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    
                        <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pb-md-4 border-top">
                          <div class="row g-2 align-self-center">
                          {{-- <label class="col-sm-3 col-form-label text-end text-danger" >ประเภทสัญญา :</label> --}}
                          <div class="col-6 col-md-6 mb-0">
                            <div class="input-bx">
                              
                              <select name="Type_Customer" id="Type_Customer" class="form-select text-dark" placeholder=" " required>
                                <option value="" selected>--- ประเภทลูกค้า ---</option>
                                @foreach ($typeCus as $key => $value)
                                  <option value="{{ $value->Code_Cus }}" {{ $value->Code_Cus == @$tags->Type_Customer ? 'selected' : '' }}>({{ $value->Code_Cus }}) - {{ $value->Name_Cus }}</option>
                                @endforeach
                              </select>
                              <span class="text-danger">ประเภทลูกค้า</span>
                            </div>
                          </div>
                          <div class="col-6 col-md-6 mb-0"> 
                              <div class="input-bx">   
                                <select name="TypeLoans" id="TypeLoans" class="form-select text-dark  TypeLoans" aria-label="Floating label select " style="pointer-events:{{@$tags->TagToContracts!=NULL?'none':'block'}}" required>
                                  <option value="" >--- ประเภทสัญญา ---</option>
                                  @foreach($TypeLoan as $key => $value)
                                    <option value="{{$value->id_rateType}}" {{(@$tags->TagToCulculate->CodeLoans==$value->Loan_Code)?'selected':''}} >{{$value->Loan_Code}} - {{$value->Loan_Name}}</option>
                                  @endforeach
                                </select>
                                <span class="text-danger">ประเภทสัญญา</span>
                              </div>                            
                            <input type="hidden" name="CodeLoans" id="CodeLoans" value="{{@$tags->TagToCulculate->CodeLoans}}" class="form-control "/>
                            <input type="hidden" id="assetType_input" name="assetType_input" value="{{@$tags->TagToCulculate->TypeLoans}}">
                          </div>
                         
                          </div>
                        </div>
                        <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pb-md-4 border-top" >
                          <div class="row g-2 align-self-center">
                              <div class="col-6 col-md-6 mb-0">
                                  <div class="input-bx">                          
                                      <select name="RateCartypes" class="form-select text-dark  typeAsset" placeholder="ประเภทรถ">
                                        <option value="" >--- ประเภทรถ ---</option>
                                        @if(@$datatypeCar!=NULL)
                                          @foreach(@$datatypeCar as $typeCar)                                          
                                            <option value="{{$typeCar->code_car}}" {{$typeCar->code_car==@$tags->TagToCulculate->RateCartypes ? 'selected':''}}>{{$typeCar->nametype_car}}</option>
                                          @endforeach 
                                        @endif
                                      </select>
                                      <span class="text-danger">ประเภทรถ</span>
                                  </div>
                                  <input type="hidden" id="v_RateCartypes" name="v_RateCartypes" value="{{@$tags->TagToCulculate->RateCartypes}}">
                              </div>
                              <div class="col-6 col-md-6 mb-0">
                                  <div class="input-bx">
                                      <select class="form-select text-dark Type_PLT" id="Type_PLT" name="Type_PLT" data-bs-toggle="tooltip" title="ประเภทรถ 2" >
                                          <option value="" selected>-- ประเภทรถ 2 --</option>
                                      </select>
                                      <span class="text-danger">ประเภทรถ 2</span>
                                  </div>
                              </div>
                              

                              <div class="col-6 col-md-6 col-lg-5 col-xl-6 mb-0">
                                  <div class="input-bx">
                                      <select class="form-select text-dark brandAsset"  name="RateBrands" id="RateBrands" data-bs-toggle="tooltip" title="ยี่ห้อรถ" >
                                          <option value="" selected>--- ยี่ห้อรถ ---</option>
                                      </select>
                                      <span class="text-danger">ยี่ห้อรถ</span>
                                  </div>
                              </div>

                              <div class="col-6 col-md-6 col-lg-4 col-xl-6 mb-0">
                                  <div class="input-bx">
                                      <select class="form-select text-dark groupAsset" name="RateGroups" data-bs-toggle="tooltip" title="กลุ่มรถ" >
                                          <option value="" selected>--- กลุ่มรถ ---</option>
                                      </select>
                                      <span class="text-danger">กลุ่มรถ</span>
                                  </div>
                              </div>

                              <div class="col-6 col-md-6 col-lg-3 col-xl-6 mb-0">
                                  <div class="input-bx">
                                      <select class="form-select text-dark yearAsset" data-bs-toggle="tooltip" id="Vehicle_Year" title="ปีรถ" >
                                          <option value="" selected>--- ปีรถ ---</option>
                                      </select>
                                      <span class="text-danger">ปีรถ</span>
                                  </div>
                                  <input type="hidden" name="RateYears" value="{{@$tags->TagToCulculate->RateYears}}"  class="rateYear">
                              </div>

                              <div class="col-6 col-md-6 col-lg col-xl-6 mb-0">
                                  <div class="input-bx">
                                      <select class="form-select text-dark modelAsset" id="Vehicle_Model" name="RateModals" data-bs-toggle="tooltip" title="รุ่นรถ" >
                                          <option value="" selected>--- รุ่นรถ ---</option>
                                      </select>
                                      <span class="text-danger">รุ่นรถ</span>
                                  </div>
                              </div>               
                              <div class="col-6 col-md-6 col-lg-auto col-xl-6 mb-0 showGear" >
                                  <div class="input-bx">
                                      <select class="form-select text-dark gearCar" id="Vehicle_Gear" name="RateGears" data-bs-toggle="tooltip" title="เกียร์รถ">
                                          <option value="" selected>--- เกียร์รถ ---</option>
                                      </select>
                                      <span class='text-danger'>เกียร์รถ</span>
                                  </div>
                              </div>
                          </div>
                      </div>          
                        {{-- <div class="form-group row mb-1 mt-2 g-1">
                          <label class="col-sm-3 col-form-label  text-end "> ยี่ห้อรถ :</label>
                          <div class="col-sm-4">
                            <select name="RateCartypes" class="form-control form-select typeAsset" placeholder="ประเภทรถ">
                              <option value="" selected>--- ประเภทรถ ---</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <select name="RateBrands" class="form-control form-select brandAsset" placeholder="ยี่ห้อรถ">
                              <option value="" selected>--- ยี่ห้อรถ ---</option>
                            
                            </select>
                          </div>
                          
                        </div>                    
                                        
                        <div class="form-group row mb-1 mt-2 g-1"> 
                          <label class="col-sm-3 col-form-label text-end"> กลุ่มรถ / ปีรถ :</label>
                          <div class="col-sm-4">
                            <select name="RateGroups" class="form-control form-select groupAsset" placeholder="กลุ่มรถ">
                              <option value="" selected>--- กลุ่มรถ ---</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <select  class="form-control form-select yearAsset" placeholder="ปีรถ">
                              <option value="" selected>--- ปีรถ ---</option>                           
                            </select>
                          </div>
                          <input type="hidden" name="RateYears" value="{{@$tags->TagToCulculate->RateYears}}">
                        </div>                  
                      <div class="form-group row mb-1 mt-2 g-1">
                        <label class="col-sm-3 col-form-label  text-end"> รุ่นรถ :</label>
                        <div class="col-sm-8">
                          <select name="RateModals" class="form-control form-select modelAsset" placeholder="รุ่นรถ">
                            <option value="" selected>--- รุ่นรถ ---</option>
                          </select>                        
                        </div>
                      </div>
                      <div class="form-group row mb-1 mt-2 g-1 gearShow"> 
                        <label class="col-sm-3 col-form-label  text-end"> เกียร์รถ :</label>
                        <div class="col-sm-4">
                          <select name="RateGears" class="form-control form-select  gearCar" placeholder="เกียร์รถ">
                            <option value="" selected>--- เกียร์รถ ---</option>
                            @if(@$tags->TagToCulculate!=NULL)
                            <option value="{{ $tags->TagToCulculate->RateGears}}" selected>{{$tags->TagToCulculate->RateGears}}</option>
                          @endif
                          
                          </select>
                        </div>
                      </div> --}}
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group row mb-1 mt-2 g-1">
                        <label class="col-sm-3 col-form-label text-end text-danger"><u>ราคากลาง</u> :</label>
                        <div class="col-sm-8">
                          <input type="text" name="RatePrices" id="RatePrices" value="{{number_format(@$tags->TagToCulculate->RatePrices,2)}}" class="form-control  ratePrice  "   readonly/>
                        </div>
                      </div>
                      <div class="form-group row mb-1 mt-2 g-1">
                        <label class="col-sm-3 col-form-label text-end text-red"><u>ประเมินรายได้</u> :</label>
                        <div class="col-sm-8">
                          <input type="text" value="" class="form-control  Boxcolor-1 chkIncome  bg-secondary bg-opacity-25" style="background-color: #FFFFFF" readonly/>
                        </div>
                      </div>
                      <div class="form-group row mb-1 mt-2 g-1">
                        <label class="col-sm-3 col-form-label text-end text-red"><u>ค้ำประกัน</u> :</label>
                        <div class="col-sm-8">
                          <input type="text"  value="" class="form-control  Boxcolor-1 guarantee  bg-secondary bg-opacity-25" style="background-color: #FFFFFF" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                      <div class="row data-container">
                        <div class="col-12">
                          <div class="form-group row mb-1 mt-2 g-1 d-none">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> <u> (สัญญาเก่า) </u> :</label> --}}
                            <div class="col-sm-6" id="old_interest">
                              <div class="input-bx">
                                <input type="text" id="Contract_old" name="Contract_old" value="{{@$tags->TagToCulculate->Contract_old}}" class="form-control" disabled>
                                <span class='text-danger'>สัญญาเก่า</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mb-1 mt-2 g-1 d-none">
                            <div class="col-sm-6" id="old_dateCon">
                              <div class="input-bx">
                                <input type="date" name="DateOldCon" id="DateOldCon" value="{{@$tags->TagToCulculate->DateOldCon}}" class="form-control " placeholder="จัดไฟแนนซ์" disabled />
                                <span class='text-danger'>วันที่จัด</span>
                              </div>
                            </div>
                            <div class="col-sm-6 d-none" id="old_interest">
                              <div class="input-bx">
                                <input type="text" id="Interest_old" name="Interest_old" value="{{@$tags->TagToCulculate->Interest_old}}" class="form-control" disabled>
                                <span class='text-danger'>ดอกเบี้ย</span>
                              </div>
                            </div>                           
                          </div>
                          <div class="form-group row mb-1 mt-2 g-1 Occ_status">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> <u>สถานะครอบครอง</u> :</label> --}}
                            <div class="col-sm-6 ">
                              <div class="input-bx">
                                <select name="TypeAssetsPoss" id="TypeAssetsPoss" class="form-control form-select text-dark " required>
                                  <option value="" selected>--- สถานะครอบครอง ---</option>
                                    @foreach ($TypeAssetsPoss as $key => $item)
                                      <option value="{{$item->Name_TypePoss}}" {{(@$tags->TagToCulculate->TypeAssetsPoss==$item->Name_TypePoss)?'selected':''}}>{{$key+1}}. {{$item->Name_TypePoss}}</option>
                                    @endforeach                                
                                </select>
                                <span class='text-danger'>สถานะ</span>   
                              </div>
                                   
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <div class="input-group input-bx">                                 
                                    <input type="date" name="DateOccupiedcar" id="DateOccupiedcar" autocomplete="off" value="{{@$tags->TagToCulculate->DateOccupiedcar}}" class="form-control " />
                                    <button type="button"  class="btn btn-secondary btn-sm"id="Occ">{{@$tags->TagToCulculate->NumDateOccupiedcar!=NULL?@$tags->TagToCulculate->NumDateOccupiedcar:0}}</button>
                                    <span class='text-danger'>วันครอบครอง</span>                                  
                                </div>
                              </div>
                              <input type="hidden" name="NumDateOccupiedcar" id="NumDateOccupiedcar" value="{{@$tags->TagToCulculate->NumDateOccupiedcar}}">
                              <input type="date" name="todayOcc" id="todayOcc" value="{{date('Y-m-d')}}" hidden>
                            </div>
                          </div>                          
                          <div class="form-group row mb-1 mt-2 g-1 ">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> <u>เกรดสัญญา / สถานะ</u> :</label> --}}
                            <div class="col-sm-6" id="grade">
                              <div class="input-bx">
                                <select id="Cus_grade" name="Cus_grade" class="form-control form-select text-dark" disabled>
                                  <option value="" >--Grade--</option>
                                  <option value="A" {{(@$tags->TagToCulculate->Cus_grade=='A')?'selected':''}} >A</option>
                                  <option value="B" {{(@$tags->TagToCulculate->Cus_grade=='B')?'selected':''}}>B</option>
                                  <option value="C" {{(@$tags->TagToCulculate->Cus_grade=='C')?'selected':''}}>C</option>
                                </select>
                                <span class='text-danger'>เกรด</span> 
                              </div>
                            </div>
                            <div class="col-sm-6" id="status_pay">
                              <div class="input-bx">
                                <select id="Payment_Status" name="Payment_Status" class="form-control form-select text-dark" disabled>
                                  <option value="" >--สถานะการจ่าย--</option>
                                  <option value="ค้างจ่าย" {{(@$tags->TagToCulculate->Payment_Status=='ค้างจ่าย')?'selected':''}} >ค้างจ่าย</option>
                                  <option value="ไม่ค้างจ่าย" {{(@$tags->TagToCulculate->Payment_Status=='ไม่ค้างจ่าย')?'selected':''}}>ไม่ค้างจ่าย</option>
                                </select>
                                <span class='text-danger'>สถานะ</span> 
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mb-1 mt-2 g-1">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> <u>การผ่อน / เรทยอดจัด </u> :</label> --}}
                            <div class="col-sm-6" id="status_due">
                              <div class="input-bx">
                                <select id="Payment_Due" name="Payment_Due" class="form-control form-select text-dark" disabled>
                                  <option value="" >--สถานะการผ่อน--</option>
                                  <option value="less" {{(@$tags->TagToCulculate->Payment_Due=='less')?'selected':''}} >น้อยกว่า 6 งวด</option>
                                  <option value="more" {{(@$tags->TagToCulculate->Payment_Due=='more')?'selected':''}}>มากกว่า 6 งวด</option>
                                </select>
                                <span class='text-danger'>การผ่อน</span> 
                              </div>
                            </div> 
                            <div class="col-sm-6">
                              <div class="form-group">
                                <div class=" input-bx">
                                  <input type="text" name="RatePrice_Car" id="RatePrice_Car" value="{{number_format(@$tags->TagToCulculate->RatePrice_Car,2)}}" class="form-control  bg-secondary bg-opacity-25"  readonly/>
                                  <button type="button" id="showRate" class="btn btn-secondary btn-sm">{{@$tags->TagToCulculate->Percent_Car!=NULL?$tags->TagToCulculate->Percent_Car:0}}%</button>
                                  <span class='text-danger'>เรทยอดจัด</span>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              
                              <input type="hidden" name="Percent_Car" id="Percent_Car" value="{{@$tags->TagToCulculate->Percent_Car}}"  placeholder="% จัดไฟแนนซ์" />
                            </div>                         
                          </div>                        
                          <div class="form-group row mb-1 mt-2 g-1">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> ยอดจัด :</label> --}}
                            
                            <div class="col-sm-6">
                              <div class="form-group">
                                <div class="input-group input-bx">
                                  <input type="text" name="Cash_Car" id="Cash_Car" value="{{number_format(@$tags->TagToCulculate->Cash_Car,2)}}" class="form-control  is-warning" required/>
                                  <button type="button" id="showRateLTV" class="btn btn-secondary btn-sm">{{@$tags->TagToCulculate->Cash_Car>0 && @$tags->TagToCulculate->RatePrices>0?number_format((@$tags->TagToCulculate->Cash_Car/$tags->TagToCulculate->RatePrices)*100,0):0}}%</button>
                                  <span class='text-danger'>ยอดจัด</span> 
                                </div>
                              </div>                              
                            </div>                           
                          </div>
                          <div class="form-group row mb-1 mt-2 g-1">
                            {{-- <label class="col-sm-3 col-form-label text-end"> ค่าดำเนินการ</label> --}}
                            <div class="col-sm-6"> 
                              <div class="input-bx">                            
                                <select  id="StatusProcess_Car" name="StatusProcess_Car" class="form-control form-select is-warning text-dark" required>                                                    
                                  <option value="yes"  {{(@$tags->TagToCulculate->StatusProcess_Car=='yes')?'selected':''}}> รวมค่าดำเนินการ</option>
                                  <option value="no"  {{(@$tags->TagToCulculate->StatusProcess_Car=='no')?'selected':''}}> ไม่รวมค่าดำเนินการ</option>                           
                                </select>
                                <span class='text-danger'></span>
                              </div>                              
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <div class="input-group input-bx">
                                  <input type="text" name="Process_Car" id="Process_Car" value="{{number_format(@$tags->TagToCulculate->Process_Car,2)}}"  class="form-control " title="ค่าดำเนินการ" required/>
                                  <button type="button" class="btn btn-secondary btn-sm" id="Process"> </button>
                                  <span class='text-danger'>ค่าดำเนินการ</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                          <div class="form-group row mb-1 mt-2 g-1">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> ระยะเวลาผ่อน :</label> --}}
                            <div class="col-sm-6" id="time_normal">
                              <div class="input-bx">
                                <select  id="Timelack_Car" class="form-control form-select is-warning text-dark" >
                                  <option value="" selected>--- ระยะเวลาผ่อน ---</option>
                                  @for($t=12;$t<97;$t=$t+6)
                                  <option value="{{$t}}"  {{(@$tags->TagToCulculate->Timelack_Car==$t)?'selected':''}}>{{$t}} งวด</option>
                                  @endfor                              
                                </select>
                                <span class='text-danger'>จำนวนงวด</span>
                              </div>
                              <input type="hidden" id="valueTime" value="{{@$tags->TagToCulculate->Timelack_Car}}">
                            </div>
                            <div class="col-sm-6" id="time_debt">
                              <div class="input-bx">
                                <input type="text"  id="Timelack_Car2" value="{{@$tags->TagToCulculate->Timelack_Car}}" class="form-control  is-warning" >
                                <span class='text-danger'>จำนวนงวด</span>
                              </div>
                            </div>
                            <input type="hidden" name="Timelack_Car"  id="Timelack_Car3"  value="{{@$tags->TagToCulculate->Timelack_Car}}" class="form-control  is-warning" >
                            <input type="hidden" id="max_timelack" />
                            <div class="col-sm-6">
                              <div class="input-bx">
                                <input type="text" name="Interest_Car" id="Interest_Car" value="{{number_format(@$tags->TagToCulculate->Interest_Car,3)}}"  class="form-control  is-warning" {{$roleNum>0?'':'readonly'}}     required/>
                                <input type="hidden" id="Show-interest" class="form-control  bg-secondary bg-opacity-25 " placeholder="แสดงดอกเบี้ย" readonly/>
                                <input type="hidden" name="InterestYear_Car" id="InterestYear_Car" value="{{number_format(@$tags->TagToCulculate->InterestYear_Car,3)}}" class="form-control bg-secondary bg-opacity-25" title="ดอกเบี้ยปี"   readonly/>
                                <span class='text-danger'>ดอกเบี้ย</span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row mb-1 mt-2 g-1">
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> ซื้อ PA / รวมยอดจัด:</label> --}}
                            <div class="col-sm-6">
                              <div class="input-bx">
                                <select  id="buyPA" name="Buy_PA" class="form-control form-select is-warning text-dark" required>
                                  <option value="" selected>--- เลือก ซื้อPA ---</option>                      
                                  <option value="no"  {{(@$tags->TagToCulculate->Buy_PA=='no')?'selected':''}}> ไม่ซื้อ PA</option>
                                  <option value="yes"  {{(@$tags->TagToCulculate->Buy_PA=='yes')?'selected':''}}> ซื้อ PA</option>                           
                                </select>
                                <span class='text-danger'>ซื้อ PA</span>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="input-bx">
                                <select  id="selectPA" name="Include_PA" class="form-control form-select is-warning text-dark" >
                                  <option value="" selected>--- เลือกรวมยอดจัด ---</option>                      
                                  <option value="no"  {{(@$tags->TagToCulculate->Include_PA=='no')?'selected':''}}> ไม่รวมประกันสินเชื่อ</option>
                                  <option value="yes"  {{(@$tags->TagToCulculate->Include_PA=='yes')?'selected':''}}> รวมประกันสินเชื่อ</option>                           
                                </select>
                                <span class='text-danger'>รวมยอดจัด</span>
                              </div>
                            </div>
                          </div>
                          {{-- <div class="form-group row mb-1 mt-2 g-1">
                            <label class="col-sm-3 col-form-label text-end"> ประกัน รถ/สินเชื่อ PA:</label>
                            <div class="col-sm-6">
                              <div class="input-bx">
                                <input type="text" value="{{ number_format(@$tags->TagToCulculate->Insurance,2) }}" name="Insurance" id="Insurance" class="form-control  insurance" data-toggle="tooltip" title="ประกันรถ"  />
                                <span class='text-danger'>ประกัน รถ</span>
                              </div>
                            </div>
                            
                          </div> --}}
                          <div class="form-group row mb-1 mt-2 g-1">
                            <div class="col-sm-6">
                              <div class="input-bx">
                                <input type="text" value="{{ number_format(@$tags->TagToCulculate->Insurance_PA,2) }}" name="Insurance_PA" id="Insurance_PA" class="form-control   Insurance_person  bg-secondary bg-opacity-25"  data-toggle="tooltip" title="ประกันสินเชื่อ"   readonly/>
                                <span class='text-danger'>ประกัน PA</span>
                              </div>
                            </div>
                            @php
                                if(count($dataPro)>0){
                                  $disable_pro = "";
                                }else{
                                  $disable_pro = "disabled";
                                }
                            @endphp
                            {{-- <label class="col-sm-3 col-form-label text-end text-danger"> <u>Promotions</u> :</label> --}}
                            <div class="col-sm-6">  
                              <div class="input-bx">                       
                                <select name="Promotions" id="Promotions" class="form-control form-select text-dark" {{$disable_pro}}>
                                  <option value="" selected>--- Promotions ---</option>
                                    @foreach ($dataPro as $key => $item)
                                      <option value="{{$item->id}}/{{$item->Value_pro}}/{{$item->Type_pro}}" {{(@$item->id == @$tags->TagToCulculate->Promotions) ? 'selected' : '' }}>{{$key+1}}. {{$item->Name_pro}}</option>
                                    @endforeach
                                    <option value="ยกเลิก" class="text-danger">ยกเลิก</option>
                                </select>
                                <span class='text-danger'>Promotions</span>
                              </div>
                              <input type="hidden" id="valuePromotion" name="valuePromotion" value="{{@$tags->TagToCulculate->Promotions}}">
                            </div>                          
                          </div>
                            {{-- <div class="col-sm-4">
                              <div class="input-group">
                                <input type="text" id="Interestmore_Car" name="Interestmore_Car" value="{{number_format(@$tags->TagToCulculate->Interestmore_Car,2)}}"  class="form-control " title="ดอกเบี้ยพิเศษ" placeholder="ดอกเบี้ยพิเศษ">
                                <div class="input-group-append">
                                  <button type="button" class="btn btn-sm form-control-navbar bg-orange" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-caret-down"></i>
                                  </button>
                                  <ul class="dropdown-menu" x-placement="bottom-start" id="InterestSelect">
                                    <li class="dropdown-item" id="Plus">01. บวกดอกเบี้ย (+)</li>
                                    <li class="dropdown-item" id="Delete">02. ลบดอกเบี้ย (-)</li>
                                    <li class="dropdown-item" id="Return">03. คืนค่า</li>
                                  </ul>
                                  <input type="hidden" name="Flag_Interest" id="Flag_Interest">
                                </div>
                              </div>
                            </div> --}}
                          
                          {{-- <div class="form-group row mb-1 mt-2 g-1">
                            <label class="col-sm-3 col-form-label text-end"> รวมดอกเบี้ย :</label>
                            <div class="col-sm-4">
                              <input type="text" name="totalInterest_Car" id="totalInterest_Car" value="{{number_format(@$tags->TagToCulculate->totalInterest_Car,2)}}" class="form-control " placeholder="รวมดอกเบี้ย" style="background-color: #FFFFFF" readonly/>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="InterestYear_Car" id="InterestYear_Car" value="{{number_format(@$tags->TagToCulculate->InterestYear_Car,2)}}" class="form-control " title="ดอกเบี้ยปี" placeholder="ดอกเบี้ยปี" placeholder="รวมดอกเบี้ย" style="background-color: #FFFFFF" readonly/>
                            </div>
                          </div> --}}
                        </div>
                        <div class="col-12 mt-4">
                          <div class="row">
                            <div class="col-6 d-grid">
                              <button type="button" id="button-data1" class="btn btn-block ClickHover text-light " style="background: #F2583E;">
                                คำนวณ
                              </button>
                            </div>
                            <div class="col-6 d-grid">
                              <button type="button" id="button-Clear1"  class="btn bg-dark btn-block ClickHover text-light">
                                คืนค่า
                              </button>
                            </div>
                          </div>
                        </div>
                        <!-- <p class="category mt-3 ml-2"><u>ผลการคำนวณ</u></p> -->
                        
                        <div class="col-12">
                          <div class="row">
                            {{-- TOP แก้
                            <div class="col-12">
                              <div class="form-group row mb-1">
                                <label class="col-sm-4 col-form-label text-end"> ค่างวดต่อเดือน :</label>
                                <div class="col-sm-7">
                                  <p id="ShowPeriod" class="text-white showData">{{(@$tags->TagToCulculate->Period_Rate!=NULL)?number_format(@$tags->TagToCulculate->Period_Rate,2):'0.00'}}</p>
                                  <input type="hidden" name="Period_Rate" id="Period_Rate" value="{{@$tags->TagToCulculate->Period_Rate}}" class="form-control " placeholder="ค่างวดต่อเดือน"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="form-group row mb-1">
                                <label class="col-sm-4 col-form-label text-end"> ยอดทั้งสัญญา :</label>
                                <div class="col-sm-7">
                                  <p id="ShowTotalPeriod" class="text-white showData">{{(@$tags->TagToCulculate->TotalPeriod_Rate!=NULL)?number_format(@$tags->TagToCulculate->TotalPeriod_Rate,2):'0.00'}}</p>
                                  <input type="hidden" name="TotalPeriod_Rate" id="TotalPeriod_Rate" value="{{@$tags->TagToCulculate->TotalPeriod_Rate}}" class="form-control " placeholder="ยอดทั้งสัญญา"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-12" id="ShowLand">
                              <div class="form-group row mb-1">
                                <label class="col-sm-4 col-form-label text-end"> ยอดจดที่ดิน :</label>
                                <div class="col-sm-7">
                                  <p id="ShowTotalLand" class="text-white showData">{{(@$tags->TagToCulculate->TotalLand_Rate!=NULL)?@$tags->TagToCulculate->TotalLand_Rate:'0.00'}}</p>
                                  <input type="hidden" name="TotalLand_Rate" id="TotalLand_Rate" value="{{@$tags->TagToCulculate->TotalLand_Rate}}" class="form-control " placeholder="ยอดทั้งสัญญา"/>
                                </div>
                              </div>
                            </div>
                            -- }}
                            {{-- input hidden --}}
                            <input type="hidden" id="Note_Credo" name="Note_Credo" value="{{@$tags->TagToCulculate->Note_Credo}}">
                            <input type="hidden" name="totalInterest_Car" id="totalInterest_Car" value="{{@$tags->TagToCulculate->totalInterest_Car}}">
                            <input type="hidden"  name="Process_Rate" id="Process_Rate" value=""/>
                            <input type="hidden" id="Credo_Score" value="{{@$tags->Credo_Score}}" />
                            {{-- <input type="hidden" name="Type_Customer" id="Type_Customer" value="{{@$tags->Type_Customer}}" /> --}}
                            <input type="hidden" name="Vat_Rate" id="Vat_Rate" value="7" placeholder="vat"/>
                            <input type="hidden" name="Tax_Rate" id="Tax_Rate" value="{{@$tags->TagToCulculate->Tax_Rate}}" placeholder="ภาษี"/>
                            <input type="hidden" name="Tax2_Rate" id="Tax2_Rate"  value="{{@$tags->TagToCulculate->Tax2_Rate}}" placeholder="ระยะผ่อน-1"/>
                            <input type="hidden" name="Duerate_Rate" id="Duerate_Rate"  value="{{@$tags->TagToCulculate->Duerate_Rate}}" placeholder="ค่างวด"/>
                            <input type="hidden" name="Duerate2_Rate" id="Duerate2_Rate"  value="{{@$tags->TagToCulculate->Duerate2_Rate}}" placeholder="ระยะผ่อน-2"/>
                            <input type="hidden" name="Profit_Rate" id="Profit_Rate"  value="{{@$tags->TagToCulculate->Profit_Rate}}" placeholder="กำไรจากยอดจัด"/>
                            <input type="hidden" id="interest_sql" value="{{@$tags->TagToCulculate->Interest_Car}}">
                            <input type="hidden" id="Plan_PA" name="Plan_PA" value="{{@$tags->TagToCulculate->Plan_PA}}">
                            <input type="hidden" id="ltvRate" name="ltvRate" value="">
                            <input type="hidden" id="intRatesql" name="intRatesql" value="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                      <div class="table-responsive" id="content-table">
                        <table class="table table-hover table-sm" id="table1">
                          <thead>
                            <tr class="bg-dark text-light">
                              <th class="text-center">ระยะเวลาผ่อน</th>
                              <th class="text-center">ยอดผ่อน NON PA</th>                           
                              <th class="text-center">แผน</th>
                              <th class="text-center">ยอดผ่อน + PA</th>
                              <th class="text-center">ส่วนต่าง</th>                            
                            </tr>
                          </thead>
                          <tbody id="tableBody">
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
      <div class="row">
        <div class="col-xl-6 col-md-6 col-sm-12">
          <div class="card h-100">
              <div class="card-body text-left">
                <div class="card-title"><b>ผลการคำนวณ</b></div><br> <hr>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-end"> ค่างวดต่อเดือน :</label>
                      <div class="col-sm-7">
                        <p id="ShowPeriod" class="text-white showData">{{(@$tags->TagToCulculate->Period_Rate!=NULL)?number_format(@$tags->TagToCulculate->Period_Rate,2):'0.00'}}</p>
                        <input type="hidden" name="Period_Rate" id="Period_Rate" value="{{@$tags->TagToCulculate->Period_Rate}}" class="form-control " placeholder="ค่างวดต่อเดือน"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-end"> ยอดทั้งสัญญา :</label>
                      <div class="col-sm-7">
                        <p id="ShowTotalPeriod" class="text-white showData">{{(@$tags->TagToCulculate->TotalPeriod_Rate!=NULL)?number_format(@$tags->TagToCulculate->TotalPeriod_Rate,2):'0.00'}}</p>
                        <input type="hidden" name="TotalPeriod_Rate" id="TotalPeriod_Rate" value="{{@$tags->TagToCulculate->TotalPeriod_Rate}}" class="form-control " placeholder="ยอดทั้งสัญญา"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-12" id="ShowLand">
                    <div class="form-group row mb-1">
                      <label class="col-sm-4 col-form-label text-end"> ยอดจดที่ดิน :</label>
                      <div class="col-sm-7">
                        <p id="ShowTotalLand" class="text-white showData">{{(@$tags->TagToCulculate->TotalLand_Rate!=NULL)?@$tags->TagToCulculate->TotalLand_Rate:'0.00'}}</p>
                        <input type="hidden" name="TotalLand_Rate" id="TotalLand_Rate" value="{{@$tags->TagToCulculate->TotalLand_Rate}}" class="form-control " placeholder="ยอดทั้งสัญญา"/>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-xl col-md col-sm-12 mt-2 viewPA">
          <div class="card h-100">
            <div class="card-body text-left">
              <div class="card-title"><b>รายละเอียดประกัน PA</b></div>
              <div class="table-responsive">
                <table class="table table">
                  <tbody class="">
                    {{-- <tr>
                      <td>ระยะเวลาประกันภัย :</td>
                      <th>
                      {{@$tags->TagToCulculate->Date_Calcu}} เวลา 00.00 น. ถึง ( {{@$tags->TagToCulculate->Date_Calcu}} - วันที่สิ้นสุดสัญญา ) เวลา 23.59 น.
                      </th>
                    </tr> --}}
                    <tr>
                      <td>แผน :</td>
                    <th>
                      <span class="showPlan_PA"></span>
                    </th></tr>
                    <tr><td>ทุนประกัน :</td>
                    <th>
                      <span class="capital_PA"></span>
                    </th></tr>
                    <tr><td>ระยะเวลาเอาประกันภัย :</td>
                    <th>
                      <span class="periodPA"></span>
                    </th></tr>
                    <tr><td>เบี้ยประกันภัย(รวมภาษีอากร) :</td>
                    <th>
                      <span class="periodPAtotal"></span>
                    </th></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">   
        <span id="Process_CarErr" style="color: #F2583E"></span>
       
        
          @if(@$FlagPage!="Y")
          @if(@$tags->TagToContracts->Date_monetary==NULL||$roleNum>0)
            @if((@$tags->TagToContracts->ConfirmApp_Con==NULL)||$roleNum>0)
              <button type="button" id="save" class="btn btn-success btn-sm  hover-up" disabled>
                <i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
              </button>
             @if(@$tags->TagToCulculate->id!=NULL)
              <button type="button" class="btn btn-warning btn-sm  hover-up" id="btn_sentMI"  >
                <span aria-hidden="true">พิเศษ</span>
              </button>
              @endif
            @endif
          @endif
        @endif
      
              <button type="button" class="btn btn-danger btn-sm hover-up SizeText" class="close" data-bs-dismiss="modal" aria-label="Close">ปิด</button>
      </div>
    </form>
  </div>
</div>
@include('components.content-calcufinance.Calculate_KB.script')
