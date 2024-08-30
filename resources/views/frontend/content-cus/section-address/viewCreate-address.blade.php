@include('public-js.scriptAddress')
<div class="row mb-1 g-1">
    <div class="col-12">
        <div class="form-floating mb-0 ">
            <input type="text" class="form-control input-mask" data-inputmask="'mask': '99999999999'" name="Registration_number" id="Registration_number" value="{{ @$data['Registration_number'] }}" placeholder="เลขทะเบียนบ้าน" autocomplete="off">
            <label for="Name_Cus" class="fw-bold">เลขทะเบียนบ้าน  <span id="alertRegis"></span></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1 g-1">
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0 ">
                    <input type="text" class="form-control " name="houseNumber_Adds" id="houseNumber_Adds" value="{{ @$data['houseNumber_Adds'] }}" placeholder="บ้านเลขที่" autocomplete="off" required>
                    <label for="Name_Cus" class="fw-bold text-danger">บ้านเลขที่</label>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="houseGroup_Adds" id="houseGroup_Adds" value="{{ @$data['houseGroup_Adds'] }}" placeholder="หมู่" autocomplete="off" required>
                    <label for="Name_Cus" class="fw-bold text-danger">หมู่</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1 g-1">
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="building_Adds" id="building_Adds" value="{{ @$data['building_Adds'] }}" placeholder="อาคาร" autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">อาคาร</label>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="village_Adds" id="village_Adds" value="{{ @$data['village_Adds'] }}" placeholder="หมู่บ้าน" autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">หมู่บ้าน</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1 g-1">
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="roomNumber_Adds" id="roomNumber_Adds" value="{{ @$data['roomNumber_Adds'] }}" placeholder="เลขที่ห้อง" autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">เลขที่ห้อง</label>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="Floor_Adds" id="Floor_Adds" value="{{ @$data['Floor_Adds'] }}" placeholder="ชั้นที่" autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">ชั้นที่</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1 g-1">
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="alley_Adds" id="alley_Adds" value="{{ @$data['alley_Adds'] }}" placeholder="ซอย" autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">ซอย</label>
                </div>
            </div>
            <div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="road_Adds" id="road_Adds" value="{{ @$data['road_Adds'] }}" placeholder="ถนน " autocomplete="off">
                    <label for="Name_Cus" class="fw-bold">ถนน</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    @php
                        $dataZone = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::selectRaw('Zone_pro, count(*) as total')
                            ->groupBy('Zone_pro')
                            ->orderBY('Zone_pro', 'ASC')
                            ->get();
                    @endphp
                    <select id="houseZone_Adds" name="houseZone_Adds" class="form-control form-control-sm textSize-13 houseZone selectAdds" required>
                        <option value="" selected>--- ภูมิภาค --- </option>
                        @foreach ($dataZone as $key => $Zone)
                            @if($Zone->Zone_pro != 'Zone_pro')
                                <option value="{{ $Zone->Zone_pro }}" {{ $Zone->Zone_pro == @$data['houseZone_Adds'] ? 'selected' : '' }}>{{ $Zone->Zone_pro }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="Prefix" class="fw-bold text-danger">-- ภูมิภาค --</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    @php
                    $Province = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Zone_pro',@$data['houseZone_Adds'])
                        ->selectRaw('Province_pro, count(*) as total')
                        ->groupBy('Province_pro')
                        ->orderBY('Province_pro', 'ASC')
                        ->get();
                    @endphp
                    <select id="houseProvince_Adds" name="houseProvince_Adds" class="form-control form-control-sm textSize-13 houseProvince" required>
                    <option value="" selected>--- จังหวัด ---</option>
                    @foreach($Province as $key => $value)
                        <option value="{{$value->Province_pro}}" {{ $value->Province_pro == @$data['houseProvince_Adds'] ? 'selected' : '' }}>{{$value->Province_pro}}</option>
                    @endforeach
                    </select>
                    <label for="Prefix" class="fw-bold text-danger">-- จังหวัด --</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    @php
                    $District = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Province_pro',@$data['houseProvince_Adds'])
                        ->selectRaw('District_pro, count(*) as total')
                        ->groupBy('District_pro')
                        ->orderBY('District_pro', 'ASC')
                        ->get();
                    @endphp
                    <select id="houseDistrict_Adds" name="houseDistrict_Adds" class="form-control form-control-sm textSize-13 houseDistrict" required>
                    <option value="" selected>--- อำเภอ ---</option>
                    @foreach($District as $key => $value)
                        <option value="{{$value->District_pro}}" {{ ($value->District_pro == @$data['houseDistrict_Adds']) ? 'selected' : '' }}>{{$value->District_pro}}</option>
                    @endforeach
                    </select>
                    <label for="Prefix" class="fw-bold text-danger">-- อำเภอ --</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    @php
                    $Tambon = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('District_pro',@$data['houseDistrict_Adds'])
                        ->selectRaw('Tambon_pro, count(*) as total')
                        ->groupBy('Tambon_pro')
                        ->orderBY('Tambon_pro', 'ASC')
                        ->get();
                    @endphp
                    <select id="houseTambon_Adds" name="houseTambon_Adds" class="form-control form-control-sm textSize-13 houseTambon" required>
                    <option value="" selected>--- ตำบล ---</option>
                    @foreach($Tambon as $key => $value)
                        <option value="{{$value->Tambon_pro}}" {{ ($value->Tambon_pro == @$data['houseTambon_Adds']) ? 'selected' : '' }}>{{$value->Tambon_pro}}</option>
                    @endforeach
                    </select>
                    <label for="Prefix" class="fw-bold text-danger">-- ตำบล --</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control Postal" id="Postal_Adds" name="Postal_Adds" value="{{ @$data['Postal_Adds'] }}" placeholder="รหัสไปรษณีย์" autocomplete="off" required>
                    <label for="Name_Cus" class="fw-bold text-danger">รหัสไปรษณีย์</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" id="Cus_Coordinates_Adds3" name="Coordinates_Adds" value="{{ @$data['Coordinates_Adds'] }}" placeholder="พิกัด" autocomplete="off" required>
                    <label for="Name_Cus" class="fw-bold text-danger">พิกัด</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="row mb-1">
            <div class="col-sm-12">
                <div class="form-floating mb-0">
                    <input type="text" class="form-control" name="Detail_Adds" id="Detail_Adds" value="{{ @$data['Detail_Adds'] }}" placeholder="รายละเอียด" autocomplete="off" required>
                    <label for="Name_Cus" class="fw-bold text-danger">รายละเอียด</label>
                </div>
            </div>
        </div>
    </div>
</div>


