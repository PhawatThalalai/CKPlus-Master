<style>
    @page {
    size: A4;
    margin: 0;
    }
    @media print {
    .setpage {
        width: 210mm;
        height: 297mm;
    }
    }

    .item {
  width: fit-content;
  background-color: #8ca0ff;
  padding: 5px;
  margin-bottom: 1em;
}
</style>

@php
    @$asset =  @$dataPact->ContractToIndentureAsset ;
@endphp

@if(@$asset->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == "car")
    @php
        $id = @$asset->IndenAssetToDataOwner->OwnershipToAsset->id;
        $brand = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car;
        $group = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarGroup->Group_car;
        $model = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarModel->Model_car;
        $gear =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Gear;
        $year =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarYear->Year_car;
        $Vehicle_OldLicense =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense;
        $Vehicle_Chassis =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis;
        $Vehicle_Engine =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine;
        $Vehicle_Color =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Color;



    @endphp
@else
    @php
        $id = @$asset->IndenAssetToDataOwner->OwnershipToAsset->id;
        $brand = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoBrand->Brand_moto;
        $group = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoGroup->Group_moto;
        $model = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoModel->Model_moto;
        $gear =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Gear;
        $year  = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoYear->Year_moto;
        $Vehicle_OldLicense =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense;
        $Vehicle_Chassis =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis;
        $Vehicle_Engine =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine;
        $Vehicle_Color =  @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Color;
    @endphp
@endif

{{-- @php
    dump($brand,$group,$model,$gear,$year,$id);
@endphp --}}


<div class="setpage">
    @if(@$typeReport == 1)

    @elseif(@$typeReport == 2)
        <div style="text-align: center; line-height : 2px;">
            <span style="font-size: 20 px;">{{ $getCompany->Company_Name }}</span><br>
            <span>{{ $getCompany->Company_Addr }}</span>
        </div>
        <hr>

        <table>
            <tr>
                <td width="70%"></td>
                <td width="30%"><br><br><b>{{ formatDateThaiLong(@$dataArr["DateLetter"]) }}</b> <p></p></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรื่อง</b> </td>
                <td>ให้ใช้สิทธิซื้อคืน<br></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรียน</b></td>
                <td width="30%">{{ @$dataPact->ContractToCus->Name_Cus }}<br> </td>
                <td>(ผู้เช่าซื้อ) </td>
            </tr>


            <tr>
                <td width="10%"></td>
                <td width="87%" style="text-align: justify;"><span style="letter-spacing: 70rem;">&nbsp;</span>ตามที่ {{ $getCompany->Company_Name }} ได้ให้ท่านเช่าซื้อรถยนต์ <b>{{ @$brand }}</b>  คันหมายเลขทะเบียน <b>{{ @$Vehicle_OldLicense }}</b> หมายเลขตัวถัง
                    <b>{{ @$Vehicle_Chassis }}</b> หมายเลขเครื่อง <b> {{ @$Vehicle_Engine }}</b> สี <b>{{ @$Vehicle_Color }}</b>                    ตามเลขที่สัญญา <b>{{ @$dataPact->Contract_Con }}</b>  ลงวันที่ <b>{{ @$dataPact->Date_con }}</b> ปรากฏว่าท่านได้ผิดสัญญาเช่าซื้อ บริษัท ฯ ได้บอกเลิกสัญญาเช่าซื้อกับท่านและกลับเข้าครอบครอง
                    รถยนต์คันที่เช่าซื้อแล้ว เพื่อให้ท่านได้ใช้สิทธิซื้อก่อน โดยกำหนดให้มาซื้อคืนภายใน 7 วัน นับตั้งแต่วันที่ท่านได้รับหนังสือฉบับนี้
                </td>
                <td ></td>
            </tr>
            <tr>
                <td width="100%"><br><br><span style="letter-spacing: 120rem;">&nbsp;</span> จึงเรียนมาเพื่อทราบ</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><p>ขอแสดงความนับถือ</p></td>

            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><br><br><br> {{ @$dataArr["Employee"] }}</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%">ฝ่ายสินเชื่อ</td>
            </tr>
        </table>


    @elseif(@$typeReport == 3)
        @php
            $Guarantor = [];
        @endphp
        <div style="text-align: center; line-height : 2px;">
            <b><span style="font-size: 20 px;">{{ $getCompany->Company_Name }}</span><br></b>
            <b><span>{{ $getCompany->Company_Addr }}</span></b>
        </div>
        <hr>

        <table>
            <tr>
                <td width="70%"></td>
                <td width="30%"><br><br><b>{{ formatDateThaiLong(@$dataArr["DateLetter"]) }}</b> <p></p></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรื่อง</b> </td>
                <td>ให้ใช้สิทธิซื้อคืน<br></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรียน</b></td>
            @foreach (@$dataPact->ContractToGuarantor as $item )
                <td width="30%">{{ @$item->GuarantorToGuarantorCus->Name_Cus }}<br> </td>
                <td>(ผู้ค้ำประกัน) </td>
            </tr>
            @php
                array_push($Guarantor,@$item->GuarantorToGuarantorCus->Name_Cus);
            @endphp
            @endforeach

            <tr>
                <td width="10%"></td>
                <td width="87%">
                    <span style="letter-spacing: 70rem;">&nbsp;</span>ตามที่ทาง {{ $getCompany->Company_Name }} ได้ให้ <b>{{ @$dataPact->ContractToCus->Name_Cus }}</b> ผู้เช่าซื้อรถยนต์ยี่ห้อ <b>{{ @$brand }}</b> คันหมายเลขทะเบียน <b>{{@$Vehicle_OldLicense}}</b>
                    หมายเลขตัวถัง <b>{{@$Vehicle_Chassis}}</b> หมายเลขเครื่อง <b>{{ @$Vehicle_Engine }}</b> สี <b>{{ @$Vehicle_Color }}</b> ตามเลขที่สัญญา <b>{{ @$dataPact->Contract_Con }}</b>
                    และท่านเป็นผู้ค้ำประกันตามสัญญาเช่าซื้อดังหล่าวตามที่ท่านทราบดีแล้วนั้น ปรากฏว่า ผู้เช่าซื้อได้ผิดสัญญาเช่าซื้อทาง บรืษัท ฯ ได้บอกเลิกสัญญาเช่าซื้อ และกลับเข้าครอบครองรถยนต์คันดังกล่าวแล้ว และทางบริษัทได้แจ้งให้ผู้เช่าซื้อ ให้สิทธิซื้อคืนภายใน 7 วันแล้ว แต่ผู้เช่าซื้อไม่ได้ใช้สิทธิซื้อคืนภายในกำหนดเวลาดังกล่าว เพื่อให้ท่านในฐานะผู้ค้ำประกันมีสิทธิซื้อคืน โดยกำหนดเวลาซื้อคืนได้ภายในกำหนด 15 วัน นับตั้งแต่วันที่ท่านได้รับหนังสือฉบับนี้
                </td>
                <td></td>
            </tr>
            <tr>
                <td width="100%"><br><br><span style="letter-spacing: 120rem;">&nbsp;</span> จึงเรียนมาเพื่อทราบ</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><p>ขอแสดงความนับถือ</p></td>

            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><br><br><br> {{ @$dataArr["Employee"] }}</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%">ฝ่ายสินเชื่อ</td>
            </tr>
        </table>
    @elseif(@$typeReport == 4)
        @php
            $Guarantor = [];
        @endphp
        <div style="text-align: center; line-height : 2px;">
            <b><span style="font-size: 20 px;">{{ $getCompany->Company_Name }}</span><br></b>
            <b><span>{{ $getCompany->Company_Addr }}</span></b>
        </div>
        <hr>

        <table>
            <tr>
                <td width="70%"></td>
                <td width="30%"><br><br><b>{{ formatDateThaiLong(@$dataArr["DateLetter"]) }}</b> <p></p></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรื่อง</b> </td>
                <td>ให้ใช้สิทธิซื้อคืน<br></td>
            </tr>
            <tr>
                <td width="10%"></td>
                <td width="5%"><b>เรียน</b> </td>
                <td width="30%">{{  @$dataPact->ContractToCus->Name_Cus }}<br></td>
                <td>(ผู้เช่าซื้อ) </td>

            </tr>
            @foreach (@$dataPact->ContractToGuarantor as $item )
            <tr>
                <td width="10%"></td>
                <td width="5%"> </td>
                <td width="30%">{{ @$item->GuarantorToGuarantorCus->Name_Cus }}<br> </td>
                <td>(ผู้ค้ำประกัน) </td>

            </tr>
            @php
                array_push($Guarantor,@$item->GuarantorToGuarantorCus->Name_Cus);
            @endphp
            @endforeach

            <tr>
                <td width="10%"></td>
                <td width="87%" style="text-align: justify;"><span style="letter-spacing: 70rem;">&nbsp;</span>ตามที่
                        {{ $getCompany->Company_Name }} ได้ให้ท่านเช่าซื้อรถยนต์ยี่ห้อ  <b>{{ @$brand }}</b> คันหมายเลขทะเบียน <b>{{ @$Vehicle_OldLicense }}</b>
                        หมายเลขตัวถัง <b>{{ @$Vehicle_Chassis }}</b> หมายเลขเครื่อง <b> {{ @$Vehicle_Engine }}</b> สี <b>{{ @$Vehicle_Color }}</b> ตามเลขที่สัญญา <b>{{ @$dataPact->Contract_Con }}</b>
                        ลงวันที่ <b>{{ formatDateThaiLong(@$dataPact->Date_con) }}</b> โดยมี <b>{{ implode("และ",@$Guarantor) }}</b> เป็นผู้ค้ำประกัน
                        บริษัทขอแจ้งให้ทราบว่า จะนำรถยนต์คันดังกล่าวออกขายทอดตลาดให้กับบุคคลทั่วไปใน วันที่ <b>{{ formatDateThaiLong(@$dataArr["DateSell"]) }}</b> ณ <b>{{ @$dataArr["SellPlace"] }}</b> โดยเริ่มทำการขายตั้งแต่เวลา <b>{{ @$dataArr["TimeSell"] }}</b>  น.
                        หากขายทอดตลาดไม่ได้หรือขายไม่ได้ตามราคาขั้นต่ำตามที่กำหนดไว้บริษัทจะทำการขายทุกวันจนกว่าจะขายได้โดยถือว่าผู้เช่าซื้อและผู้ค้ำประกันได้รับทราบการแจ้งประกาศขายดังกล่าวแล้ว
                </td>
                <td></td>
            </tr>
            <tr>
                <td width="100%"><br><br><span style="letter-spacing: 120rem;">&nbsp;</span> จึงเรียนมาเพื่อทราบ</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><p>ขอแสดงความนับถือ</p></td>

            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%"><br><br><br><br> {{ @$dataArr["Employee"] }}</td>
            </tr>
            <tr align="center">
                <td width="55%"></td>
                <td width="45%">ฝ่ายสินเชื่อ</td>
            </tr>
        </table>
    @elseif(@$typeReport == 5)



    @endif
</div>

