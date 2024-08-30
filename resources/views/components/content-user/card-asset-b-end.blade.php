
@if (@$data['TYPECON'] == 'land') <!-- ที่ดิน -->
    <div class="card mb-2">
        <div class="card-body ">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center border-end">
                        <div class="bg-light mini-stat-icon rounded-3 pb-4">
                            <img src="{{ URL::asset('\assets\images\land.png') }}" alt="" class="p-1 mb-2 rounded-circle bg-white border border-2 border-warning mt-4" style="max-width: 45%;">
                            <br><span class="badge text-bg-warning mb-2 fs-5">ทรัพย์ที่ {{ @$data['numGuaran'] }}</span>
                            <div class="accordion-flush" id="Landaccor-{{@$data['numGuaran']}}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{@$data['numGuaran']}}">
                                    <button class="btn btn-primary rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#Land-{{@$data['numGuaran']}}" aria-expanded="false" aria-controls="Land-{{@$data['numGuaran']}}">
                                        ดูรายละเอียดเพิ่มเติม
                                    </button>
                                    </h2>
                                </div>
                            </div> 
                        </div>
                    <div id="Land-{{@$data['numGuaran']}}" class="accordion-collapse collapse mt-2 mb-2" aria-labelledby="heading-{{@$data['numGuaran']}}" data-bs-parent="#Landaccor-{{@$data['numGuaran']}}" style="">
                        <div class="accordion-body">
                            <div class="table-responsive mt-1 ">
                                <table class="table table-sm table-nowrap mb-0 table-striped">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th class="text-start" scope="row">สาขาที่รับ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['UserBranch'] != NULL )  ? @$data['UserBranch'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start" scope="row">รหัสผู้รับ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['UserInsert'] != NULL )  ? @$data['UserInsert'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start" scope="row">วันที่รับสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['created_at'] != NULL )  ? @$data['created_at'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <h5 class="text-primary p-2"><i class="bx bxs-note"></i> หมายเหตุ (Land Details)</h5>
                                {{ ( @$data['Land_Detail'] != NULL )  ? @$data['Land_Detail'] : '-' }}
                            </div>

                        </div>
                    </div>


                    
                </div>
                <div class="col-xl col-lg col-md col-sm-12 mb-2">
                    <div class="row">
                        <div class="col border-end">
                            <h5 class="text-primary p-2"><i class="bx bx-user"></i> ตำแหน่งที่ดิน (Location Details)</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-nowrap mb-0 table-striped">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th scope="row">ภูมิภาค :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_Zone'] != NULL )  ? @$data['Land_Zone'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">จังหวัด :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_Province'] != NULL )  ? @$data['Land_Province'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">อำเภอ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_District'] != NULL )  ? @$data['Land_District'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ตำบล :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_Tambon'] != NULL )  ? @$data['Land_Tambon'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">รหัสไปรษณีย์ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_PostalCode'] != NULL )  ? @$data['Land_PostalCode'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">พิกัดที่อยู่ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_Coordinates'] != NULL )  ? @$data['Land_Coordinates'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">วันครอบครองล่าสุด :</th>
                                            <td class="text-end">
                                                {{ ( @$data['OccupiedDT'] != NULL )  ? @$data['OccupiedDT'] : '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="text-primary p-2"><i class="bx bxs-flag"></i> รายละเอียดที่ดิน (Land Details)</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-nowrap mb-0 table-striped">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th scope="row">ราคาประเมิณ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Price_Asset'] != NULL )  ? @$data['Price_Asset'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ประเภทหลักทรัพย์ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Land_Type'] != NULL )  ? @$data['Land_Type'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เลขที่โฉนด :</th>
                                            <td class="text-end">
                                                {{  @$data['Land_Id'].' เลขที่ดิน '.@$data['Land_ParcelNumber']  }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ระวาง :</th>
                                            <td class="text-end">
                                                {{  @$data['Land_SheetNumber'].' หน้าสำรวจ '.@$data['Land_TambonNumber']  }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เล่ม/หน้า :</th>
                                            <td class="text-end">
                                                {{ @$data['Land_Book'].' หน้า '.@$data['Land_BookPage']  }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เนื้อที่ :</th>
                                            <td class="text-end">
                                            {{ @$data['Land_SizeRai'].' ไร่ '.@$data['Land_SizeNgan'].' งาน '.@$data['Land_SizeSquareWa'].' วา' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ระยะเวลาครอบครอง :</th>
                                            <td class="text-end">
                                                {{ ( @$data['OccupiedTime'] != NULL )  ? @$data['OccupiedTime'] : '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="Land-{{@$data['numGuaran']}}" class="accordion-collapse collapse mt-2 mb-2" aria-labelledby="heading-{{@$data['numGuaran']}}" data-bs-parent="#accor-{{@$data['numGuaran']}}" style="">
                        <div class="accordion-body">

                            <div class="row">
                                <div class="col border-end">
                                    <h5 class="text-primary p-2"><i class="bx bxs-map"></i> ข้อมูลอื่นๆ (Other Details)</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-nowrap mb-0 table-striped">
                                            <tbody class="fs-6">
                                                <tr>
                                                    <th scope="row">เงินกู้ :</th>
                                                    <td class="text-end">
                                                        {{ ( @$data['cardIdGuar'] != NULL )  ? @$data['cardIdGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าอื่นๆ :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['phoneGuar'] != NULL )  ? @$data['phoneGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">เงินกู้ร่วม :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['phoneGuar'] != NULL )  ? @$data['phoneGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าธรรมเนียม :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['phoneGuar'] != NULL )  ? @$data['phoneGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">เงินกู้ร่วมสุทธิ :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['phoneGuar'] != NULL )  ? @$data['phoneGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">เงินลงทุน :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['phoneGuar'] != NULL )  ? @$data['phoneGuar'] : '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-primary p-2"><i class="bx bxs-note"></i> หมายเหตุ (Land Details)</h5>
                                    {{ ( @$data['Land_Detail'] != NULL )  ? @$data['Land_Detail'] : '-' }}
                                </div>
                            </div>


                        </div>
                    </div> -->


                </div>

            </div>
        </div>
    </div>
@else <!-- รถยนต์ -->
    <div class="card mb-2">
        <div class="card-body ">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center border-end">
                        <div class="bg-light mini-stat-icon rounded-3 pb-4">
                            <img src="{{ URL::asset('\assets\images\astCar.png') }}" alt="" class="p-1 mb-2 rounded-circle bg-white border border-2 border-warning mt-4" style="max-width: 45%;">
                            <br><span class="badge text-bg-warning mb-2 fs-5">ทรัพย์ที่ {{ @$data['numGuaran'] }}</span>
                            <div class="accordion-flush" id="accor-{{@$data['numGuaran']}}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{@$data['numGuaran']}}">
                                    <button class="btn btn-primary rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{@$data['numGuaran']}}" aria-expanded="false" aria-controls="flush-{{@$data['numGuaran']}}">
                                        ดูรายละเอียดเพิ่มเติม
                                    </button>
                                    </h2>
                                </div>
                            </div> 
                        </div>
                    <div id="flush-{{@$data['numGuaran']}}" class="accordion-collapse collapse mt-2 mb-2" aria-labelledby="heading-{{@$data['numGuaran']}}" data-bs-parent="#accor-{{@$data['numGuaran']}}" style="">
                        <div class="accordion-body">
                        <div class="table-responsive mt-1 ">
                            <table class="table table-sm table-nowrap mb-0 table-striped">
                                <tbody class="fs-6">
                                    <tr>
                                        <th class="text-start" scope="row">สาขาที่รับ :</th>
                                        <td class="text-end">
                                            {{ ( @$data['UserBranch'] != NULL )  ? @$data['UserBranch'] : '-' }}
                                                
                                        </td>
                                    </tr>
                                    <tr>
                                            <th class="text-start" scope="row">รหัสผู้รับ :</th>
                                            <td class="text-end">
                                                {{ ( @$data['UserInsert'] != NULL )  ? @$data['UserInsert'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                    <tr>
                                        <th class="text-start" scope="row">วันที่รับสินค้า :</th>
                                        <td class="text-end">
                                            {{ ( @$data['created_at'] != NULL )  ? @$data['created_at'] : '-' }}
                                                
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl col-lg col-md col-sm-12 mb-2">
                    <div class="row">
                        <div class="col border-end">
                            <h5 class="text-primary p-2"><i class="bx bx-user"></i> รายละเอียดรถ (Car Details)</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-nowrap mb-0 table-striped">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th scope="row">ยี่ห้อสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Brand'] != NULL )  ? @$data['Brand'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">กลุ่มสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['GroupCar'] != NULL )  ? @$data['GroupCar'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">รุ่นสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['Model'] != NULL )  ? @$data['Model'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ประเภทสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['TypeCar'] != NULL )  ? @$data['TypeCar'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">สีสินค้า :</th>
                                            <td class="text-end">
                                                {{ ( @$data['ColorCar'] != NULL )  ? @$data['ColorCar'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ปีที่ผลิต :</th>
                                            <td class="text-end">
                                                {{ ( @$data['YearCar'] != NULL )  ? @$data['YearCar'] : '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <h5 class="text-primary p-2"><i class="bx bxs-flag"></i> ข้อมูลเอกสาร (Car Documents)</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-nowrap mb-0 table-striped">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th scope="row">เลขทะเบียน :</th>
                                            <td class="text-end">
                                                {{ ( @$data['RegisNumber'] != NULL )  ? @$data['RegisNumber'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เลขตัวถัง :</th>
                                            <td class="text-end">
                                                {{ ( @$data['ChasNumber'] != NULL )  ? @$data['ChasNumber'] : '-' }}
                                                    
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เลขเครื่อง :</th>
                                            <td class="text-end">
                                                {{ ( @$data['MachNumber'] != NULL )  ? @$data['MachNumber'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">เลขไมล์ :</th>
                                            <td class="text-end">
                                            {{ ( @$data['Mileage'] != NULL )  ? @$data['Mileage'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ขนาด :</th>
                                            <td class="text-end">
                                            {{ ( @$data['CC'] != NULL )  ? @$data['CC'] : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">สถานะทะเบียน :</th>
                                            <td class="text-end">
                                            {{ ( @$data['RegisStatus'] != NULL )  ? @$data['RegisStatus'] : '-' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="flush-{{@$data['numGuaran']}}" class="accordion-collapse collapse mt-2 mb-2" aria-labelledby="heading-{{@$data['numGuaran']}}" data-bs-parent="#accor-{{@$data['numGuaran']}}" style="">
                        <div class="accordion-body">

                            <div class="row">
                                <div class="col border-end">
                                    <h5 class="text-primary p-2"><i class="bx bxs-map"></i> วันครอบครองและประกัน (Other Details)</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-nowrap mb-0 table-striped">
                                            <tbody class="fs-6">
                                                <tr>
                                                    <th scope="row">วันครอบครองล่าสุด :</th>
                                                    <td class="text-end">
                                                        {{ ( @$data['OccupiedDT'] != NULL )  ? @$data['OccupiedDT'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ประกันภัย :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['InsuranceState'] != NULL )  ? @$data['InsuranceState'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">เลขกรมธรรม์ :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['PolicyNumber'] != NULL )  ? @$data['PolicyNumber'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">คุ้มครอง พ.ร.บ. :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['InsuranceDT'] != NULL )  ? @$data['InsuranceDT'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">รูปแบบรถยนต์ :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['PurposeType'] != NULL )  ? @$data['PurposeType'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ลำดับครอบครอง :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['PossessionOrder'] != NULL )  ? @$data['PossessionOrder'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ประวัติหน้า 18 :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['History_18'] != NULL )  ? @$data['History_18'] : '-' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="text-primary p-2"> &nbsp;</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-nowrap mb-0 table-striped">
                                            <tbody class="fs-6">
                                                <tr>
                                                    <th scope="row">ระยะเวลาครอบครอง :</th>
                                                    <td class="text-end">
                                                        {{ ( @$data['OccupiedTime'] != NULL )  ? @$data['OccupiedTime'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">บริษัทประกัน :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['InsuranceCompany_Id'] != NULL )  ? @$data['InsuranceCompany_Id'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">คุ้มครอง ประกัน :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['InsuranceDT'] != NULL )  ? @$data['InsuranceDT'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">คุ้มครอง ทะเบียน :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['InsuranceRegisterDT'] != NULL )  ? @$data['InsuranceRegisterDT'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">สถานะครอบครอง :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['PossessionState_Code'] != NULL )  ? @$data['PossessionState_Code'] : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ประวัติหน้า 16. :</th>
                                                    <td class="text-end">
                                                    {{ ( @$data['History_16'] != NULL )  ? @$data['History_16'] : '-' }}
                                                    </td>
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
@endif