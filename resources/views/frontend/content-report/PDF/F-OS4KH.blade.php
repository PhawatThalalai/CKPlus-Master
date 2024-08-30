<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>อ.ส.4ข.</title>

</head>
<style>
     @page {
        size: portrait;
    }
    @font-face {
            font-family: 'TFPimpakarn';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('fonts/TF Pimpakarn.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
        }
        @font-face {
            font-family: 'TFPimpakarn';
            font-style: normal;
            font-weight: bold;
            src: url({{ asset('fonts/TF Pimpakarn Bol.ttf') }}) format('truetype');
        }
        /* @font-face {
            font-family: 'TFPimpakarn';
            font-style: italic;
            font-weight: normal;
            src: url({{ asset('fonts/THSarabunNew Italic.ttf') }}) format('truetype');
        }
        @font-face {
            font-family: 'TFPimpakarn';
            font-style: italic;
            font-weight: bold;
            src: url({{ asset('fonts/THSarabunNew BoldItalic.ttf') }}) format('truetype');
        } */
        body {
            font-family: "TFPimpakarn";
        }
    .circle {
        top:4rem;
        left:4rem;
    }
    .border_black {
        /* border: solid 1px black;


        height: 20px;*/

        display: inline-block;
        line-height: 0.3cm;
        border: solid 1px black;

        margin-right: 2px;
        width: 12px;
        /* margin: 1px; */
        /* vertical-align: 7px; */

    }

    html { margin: 20px}


    .borderTB  > table,.borderTB  >tr,.borderTB  >td,.borderTB  >th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .rectangle {
            height: 20px;
            width: 130px;
            background-color: #C9DCF1 ;
            border-color: green;
            border-style: groove;
        }
        .rectangle2 {
            height: 20px;
            width: 130px;
            background-color: #C9DCF1 ;
            border-color: green;
            border-radius: 5px;
            border-style: groove;
        }
        tr,td {
            border: 2px solid;
            border-color: rgb(0, 0, 0);
            /* border-collapse: collapse;  */
            }

</style>
<body>
    @php

     $logo =  'https://ckl.co.th/assets\images\logoRD.png';
     $qrlogo =  URL::asset('/assets/images/QROS4K.png');
      @$numCus = count(@$dataCusAll);
      @$numPag = ceil(@$numCus/7)  ;
      @$row = 0;
      $Tax_id =0;
      $branch =0;

    //   foreach (auth()->user()->UserToCom as $comName){
    //     if($comName->Company_Type==1){
    //         $Tax_id = $comName->Company_Id ;
    //         $branch = $comName->Company_Branch ;
    //         $nameCom = $comName->Company_Name;
    //     }
    //   }

      $comName =    auth()->user()->UserToCom->filter(function ($item) {
                return $item->Company_Type==1;
                })->first();

     $numSent = 1;
     $datef=date_create($Fdate);
     $dayStart = (int)(date_format($datef,"d"));
     if($dayStart>15){
        $numSent = 2;
     }

    @endphp
    <div class="" style="border : 2px solid; border-color : rgb(7, 7, 7);">
        <table style="width: 100%; border-collapse: collapse;">
            <tr  style="line-height:0.5cm; " >
                <td  style="width: 100px; border-style: hidden;" align="center">
                    <img src="{{$logo}}" height="7%">
                </td>
                <td  colspan="6"align="center" style="border-style: hidden; ">
                    <span style="font-size: 19pt;font-weight: bold">แบบขอเสียอากรแสตมป์เป็นตัวเงินสำหรับตราสารบางลักษณะ</span><br/>
                        <span style="font-size: 12pt;font-weight:normal">ตามประกาศอธิบดีกรมสรรพากร เกี่ยวกับอากรแสตมป์ </span>
                </td>
                <td   align="right" style="border-style: hidden;" >
                     <span style="font-size: 40pt;font-weight:bold;"> อ.ส.4ข </span>
                </td>

            </tr>
            <tr  style="line-height:0.4cm">
                <td  colspan="8" style="background-color: dimgray;border-style: hidden;border-bottom: 2px" align="center">
                    <span style="font-size: 16pt;font-weight:bold; color:rgb(252, 252, 252)">สำหรับตราสารตามลักษณะแห่งตราสาร     3.     5.     6.    14.    16.  17.  23.  และ  28.(ค)   แห่งบัญชีอัตราอากรแสตมป์</span>
                </td>
            </tr>
            <tr style="line-height:0.4cm">
                <td   colspan="4" style="width: 300px" style="border-style: hidden;border-top: 2px">
                    <span style="font-size:13pt;font-weight: bold">ชื่อ. {{$comName->Company_Name }} </span>
                </td>
                <td   colspan="3" align="center" style="border-style: hidden ;border-top: 2px" >
                    <span style="font-size:13pt;font-weight: bold"> เลขประจำตัวผู้เสียภาษีอากร </span>
                </td>
                <td  align="center" colspan="2" style="width: 100px;border-style: hidden ;border-top: 2px">
                    <span style="font-size:13pt;font-weight: bold;"> สาขาที่ </span>
                </td>

            </tr>
            <tr style="line-height:0.4cm">
                <td  colspan="4"  style="border-style: hidden;">
                    <span style="font-size: 10pt;font-weight: normal">(ธนาคาร บริษัทเงินทุน บริษัทหลักทรัพย์ บริษัทเครดิตฟองซิเอร์ บริษัทประกันภัย ฯลฯ) </span>
                </td>
                <td   colspan="3"  align="center" style="border-style: hidden ">
                    @php echo cardIDFrom($comName->Company_Id); @endphp
                </td>
                <td  align="center" style="width: 100px;border-style: hidden;border-right-color: 2px " >
                    <div class="border_black">0</div><div class="border_black">0</div><div class="border_black">0</div><div class="border_black">{{$branch}}</div>
                </td>

            </tr>
            <tr  style="line-height: 0.4cm;font-size: 13pt;font-weight: normal">
                <td   colspan="2"  style="border-style: hidden;">ที่อยู่ : อาคาร
                </td>
                <td style="border-style: hidden ">ห้องเลขที่
                </td>
                <td style="border-style: hidden ">ชั้นที่
                </td>
                <td  colspan="2" style="border-style: hidden;border-bottom: 2px">หมู่บ้าน
                </td>

                <td  style="border-style: hidden;border-bottom: 2px" > เลขที่ {{@$comName->Company_Addr1}}
                </td>
                <td style="width: 100px; ">หมู่ที่ {{@$comName->Company_HouseNum}}
                </td>
            </tr>
            <tr style="line-height: 0.4cm;font-size: 13pt;font-weight: normal">
                <td   colspan="2"   style="border-style: hidden;">ตรอก/ซอย
                </td>
                <td    colspan="2" style="border-style: hidden;border-right: 2px" >แยก
                </td >
                <td    colspan="4" rowspan="4" style="vertical-align: bottom;text-align:center;border : 2px solid rgb(5, 5, 5);border-right: 2px">
                    สำหรับบันทึกข้อมูลจากระบบ TCL
                </td>

            </tr>
            <tr style="line-height: 0.4cm;font-size: 13pt;font-weight: normal">
                <td   colspan="2"  style="border-style: hidden;">ถนน {{@$comName->Company_Road}}
                </td>
                <td   colspan="2" style="border-style: hidden;border-right: 2px">ตำบล/แขวง {{@$comName->Company_Tambon}}
                </td >


            </tr>
            <tr style="line-height: 0.4cm;font-size: 13pt;font-weight: normal">
                <td   colspan="2"   style="border-style: hidden;">อำเภอ/เขต {{@$comName->Company_District}}
                </td>
                <td   colspan="2" style="border-style: hidden;border-right: 2px">จังหวัด {{@$comName->Company_Province}}
                </td >

            </tr>
            <tr style="line-height: 0.4cm;font-size: 13pt;font-weight: normal">
                <td   colspan="4"  style="border-style: hidden;border-bottom:2px solid;border-right: 2px">รหัสไปรษณีย์ {{@$comName->Company_Zipcode}}
                </td>
            </tr>
            <tr style="line-height: 0.3cm;">
                <td colspan="8" style="border : 2px solid rgb(5, 5, 5);border-style: hidden;border-bottom:2px solid;border-top: 2px" >
                    <span style="font-size: 13pt;font-weight:normal;margin-left:50px">ขอเสียอากรแสตมป์เป็นตัวเงิน หรือได้รับชำระค่าอากรแสตมป์เป็นตัวเงินจากผู้ที่ต้องเสียอากรสำหรับตราสารที่ปรากฏรายละเอียด
                    <br/> <span style="font-size: 13pt;font-weight: normal">ตามรายการข้างล่างนี้ ประจำงวดที่
                    <div class="border_black">{{@$numSent}}</div> ตั้งแต่วันที่   <span style="font-size:13pt;font-weight: bold">{{formatDateThaiLongPS(@$Fdate)}}</span> ถึงวันที่ <span style="font-size:13pt;font-weight: bold">{{formatDateThaiLongPS(@$Tdate)}}</span></span>
                    <br/><span style="font-size: 13pt;font-weight: normal;margin-left:50px">จึงขอยื่นชำระค่าอากรแสตมป์เป็นตัวเงินต่อสำนักงานสรรพากรพื้นที่สาขา   {{@$comName->RD_Department}}</span>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="border : 2px solid  ;border-style: hidden;border-bottom:2px solid;border-top: 2px" >
                    <table style="width: 100% ;border-style: hidden;border-collapse: collapse;">
                        <tr style="line-height:0.3cm">
                            <td colspan="3" width="200px" align="center"  >
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; "> ตราสารตามบัญชีอัตราอากรแสตมป์</span>
                            </td>
                            <td rowspan="2"  style="width: 70px"   align="center">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">จำนวนตราสารที่ขอ ชำระอากรแสตมป์ เป็นตัวเงิน(ฉบับ)</span>
                            </td>
                            <td colspan="2"  width="100px"  align="center">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">มูลค่าของตราสาร</span>
                            </td>
                            <td colspan="2" width="100px" align="center" >
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">จำนวนเงินค่าอากร แสตมป์ที่ขอชำระ</span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm" align="center">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal; "> ข้อ</span>
                            </td>
                            <td colspan="2" align="center">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">รายการตราสารที่ขอชำระอากรแสตมป์เป็นตัวเงิน</span>
                            </td>

                            <td style="width: 90px" align="center">
                                <span style="font-size: 13pt;font-weight:normal; "> บาท</span>
                            </td>
                            <td style="width: 20px" align="center">
                                <span style="font-size: 13pt;font-weight:normal; "> สต.</span>
                            </td>
                            <td style="width: 90px" align="center">
                                <span style="font-size: 13pt;font-weight:normal; "> บาท</span>
                            </td>
                            <td style="width: 20px" align="center">
                                <span style="font-size: 13pt;font-weight:normal; ">สต.</span>
                            </td>
                        </tr>
                        <tr  >
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal;"> 3</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal;">เช่าซื้อทรัพย์สิน</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal;"> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;"> </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal;"> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;"></span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; "> 5</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">กู้ยืมเงิน หรือการตกลงให้เบิกเงินเกินบัญชีจากธนาคาร</span>
                            </td>
                            <td align="center">
                                {{number_format($totalCon,0)}}
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal; "> {{number_format($totalLoan,0)}}</span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; ">.00</span>
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal;  "> {{number_format($totalAK,0)}}</span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; ">00</span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal; "> 6</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal; ">กรมธรรม์ประกันภัย</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; "> </span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal; ">14</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal; ">เลตเตอร์ออฟเครดิต</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "></span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal; ">16</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal; ">ใบรับของ</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; "></span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal; ">17</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal; ">ค้ำประกัน</span>
                            </td>
                            <td align="center">
                                    {{number_format($totalGuar,2)}}
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "></span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal;  "> {{number_format($totalGuar*10,0)}}</span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">00</span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">23</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">คู่ฉบับหรือคู่ฉีกแห่งตราสาร</span>
                            </td>
                            <td align="center">

                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal;  ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; ">00</span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; ">28.(ค)</span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal;  ">ใบรับสำหรับการขาย ขายฝากให้เช่าซื้อหรือโอนกรรมสิทธิ์ยานพาหนะ</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal;  ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;  ">  </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal;  ">  </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal;  "> </span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td style="width: 5px">
                                <span style="font-size: 13pt;font-weight:normal;word-wrap: break-word; "></span>
                            </td>
                            <td colspan="2">
                                <span style="font-size: 13pt;font-weight:normal; ">ซึ่งมีการจดทะเบียนตามกฎหมายว่าด้วยยานพาหนะนั้น ๆ</span>
                            </td>
                            <td>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 90px">
                                <span style="font-size: 13pt;font-weight:normal; "> </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "></span>
                            </td>
                        </tr>
                        <tr style="line-height:0.3cm">
                            <td colspan="3" align="center">
                                <span style="font-size: 13pt;font-weight:normal; ">รวม</span>
                            </td>
                            <td align="center">
                                {{number_format(($totalCon+$totalGuar) ,0)}}
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal;  ">{{number_format($totalLoan,0)}}</span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; "> 00</span>
                            </td>
                            <td style="width: 90px" align="right">
                                <span style="font-size: 13pt;font-weight:normal;  ">{{number_format((($totalAK)+($totalGuar*10)),0)}} </span>
                            </td>
                            <td style="width: 20px">
                                <span style="font-size: 13pt;font-weight:normal; ">00</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="line-height:0.4cm">
                <td colspan="8" style="border : 2px solid  ;border-style: hidden;border-bottom:2px solid;border-top: 2px">
                    <span style="font-size: 13pt;font-weight:normal;"> หมายเหตุ โปรดระบุรายละเอียดของตราสาร คู่สัญญาหรือผู้ที่ต้องเสียอากร </span>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:200Px "> จำนวน {{@$numCus}} รายการ </span>
                    <br/>
                    <span style="font-size: 13pt;font-weight:normal;"> และจำนวนเงินค่าอากรที่ขอชำระ ในใบแนบ อ.ส.4ข :   </span>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:300Px "> จำนวน {{@$numPag}} แผ่น </span>
                </td>
            </tr>
            <tr style="line-height:0.4cm; background-color:rgb(221, 226, 230);border-style: hidden;border-bottom:2px solid;border-top: 2px">
                <td colspan="6" style="border-style: hidden;border-top:2px;border-bottom: 2px;border-left: 2px">
                    <span style="font-size: 13pt;font-weight:normal;">สำหรับเจ้ำหน้ำที่</span><br>
                    <span style="width:100%">
                    <span style="font-size: 13pt;font-weight:normal;margin-left:100Px"> สรุปรายการค่าอากรแสตมป์ที่ขอชำระ  </span><br>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:80Px"> 1.รวมมูลค่าของตราสารทั้งสิ้น </span><br>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:80Px"> 2.รวมจำนวนเงินค่าอากรแสตมป์ที่ขอชำระ.</span><br>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:80Px"> 3.งินเพิ่มอากร (ถ้ามี) </span><br>
                    <span style="font-size: 13pt;font-weight:normal;margin-left:80Px"> 4.รวมจำนวนเงินค่าอากรแสตมป์ที่ขอชำระ และเงินเพิ่มอากร (2. + 3.) .</span>
                    </span>
                </td>
                <td colspan="2" style="border-style: hidden;border-top:2px;border-bottom: 2px; ">
                    {{-- <div class="rectangle2"><span class="" style="font-size: 13pt;font-weight:normal;margin-left:20px"><b>จำนวนเงิน</b></span></div>
                    <div class="rectangle"><span  style="font-size: 13pt;font-weight:normal; margin-left:80Px"> </span></div>
                    <div class="rectangle"><span  style="font-size: 13pt;font-weight:normal; margin-left:80Px"> </span></div>
                    <div class="rectangle"><span  style="font-size: 13pt;font-weight:normal; margin-left:80Px"> </span></div>
                    <div class="rectangle"><span  style="font-size: 13pt;font-weight:normal; margin-left:80Px"> </span></div> --}}
                    <table style="width : 100%; margin-top : 13px; background-color: #C9DCF1 ;line-height:0.4cm;border-collapse: collapse; ">
                        <tr>
                            <td colspan="2"  style="text-align: center;">จำนวนเงิน</td>
                        </tr>
                        <tr>
                            <td style="width : 80%; text-align: right;">{{number_format($totalLoan,0)}} </td>
                            <td style="width : 20%">.00</td>
                        </tr>
                        <tr>
                            <td style="width : 80%; text-align: right;">{{number_format((($totalAK) +($totalGuar*10)),0)}}</td>
                            <td style="width : 20%">.00</td>
                        </tr>
                        <tr>
                            <td style="width : 80%; text-align: right;"></td>
                            <td style="width : 20%">.</td>
                        </tr>
                        <tr>
                            <td style="width : 80%; text-align: right;">{{number_format((($totalAK) +($totalGuar*10)),0)}}</td>
                            <td style="width : 20%">.00</td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr style="line-height:0.3cm">
                <td colspan="4"  align="center" style="font-size: 13pt;font-weight:normal; border-left-color: transparent;  border-bottom-color: transparent">
                    คำสั่งอนุมัติ<br/>
                    อนุมัติให้บุคคลตามชื่อข้างต้นเสียอากรแสตมป์เป็นตัวเงินตามมาตรา<br/>
                    113 แห่งประมวลรัษฎากร ตามข้อ 4. ซึ่งอยู่ในหัวข้อ "สำหรับเจ้าหน้าที่"
                    ข้างต้น
                    <br/>
                </td>
                <td colspan="4" align="center"  style="font-size: 13pt;font-weight:normal;border-style: hidden;border-top: 2px; border-left: 2px;">
                    ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้ เป็นรายการที่ถูกต้อง และเป็นจริงทุกประการ
                    <br/><br/>
                </td>
            </tr>
            <tr style="line-height:0.3cm">
                <td colspan="1" style="border-style: hidden; " >
                    <span style=""><img src="{{$qrlogo}}" width="100%"></span>
                </td>
                <td colspan="3"  align="center" style="font-size: 13pt; border-bottom-color: transparent ">
                    <br/>
                    <span style="margin-left: 30px">
                    ลงชื่อ........................................................<br/><br/>
                    (.............................................................)<br/>
                    ตำแหน่ง...................................................</span>

                </td>
                <td colspan="3" align="center"  style="font-size: 13pt;font-weight:normal;border-style: hidden; border-left: 2px;   ">
                    <br/>
                    <span style="margin-left: 30px">ลงชื่อ.............................................ผู้ขอชำระ<br/><br/>
                    <div style="position : absolute; left : 400px; bottom : 101px; width:200px;">{{ @$nameForm }}</div>
                    (........................................................)<br/>
                    <span style="position : absolute; left : 450px; bottom : 83px;"> {{ @$Position }}</span>
                   <span>ตำแหน่ง...................................................</span><br/>
                    <span style="position : absolute; left : 450px; bottom : 65px;"> {{ formatDateThaiLongPS(@$dateSend) }}</span>
                   <span> ยื่นวันที่...................................................</span>
                </td>
                <td colspan="1" align="right" style=";border-style: hidden;border-right: 2px; " >
                    <p style="font-size:8pt; border: solid 1px rgb(0, 0, 0); border-radius: 100%;line-height: 8px;  width:60px; height: 40px; text-align: center;padding-top:20px; position : absolute;"><span style="position : relative; bottom: 7px;"> ประทับตรา <br>นิติบุคคล <br>  (ถ้ามี)</span> </p>
                </td>
            </tr>

        </table>
    </div>

     {{-- @for(@$i=0;@$i<@$numPag;@$i++)
     <table border="0" >
         <tr style="font-size: 13pt;line-height: 15px;font-weight: bold" align="bottom">
             <td  width="200px"  >
                 ใบแนบ <font style="font-size: 40pt;font-weight: bold"> อ.ส.4ข </font>
             </td>
             <td align="center" width="500px" >
                เลขประจำตัวผู้เสียภาษีอากร :  @php  echo cardIDFrom($Tax_id); @endphp
             </td>
             <td width="300px" align="right" >

                 <div>สาขาที่ : <div class="border_black">0</div><div class="border_black">0</div><div class="border_black">0</div><div class="border_black">{{$branch}}</div></div>
                 <p>แผ่นที่_{{$i+1}}_ในจำนวน_{{@$numPag}}_แผ่น</p>
             </td>
         </tr>


     </table>
    <span class="borderTB">
        <table   style="font-size: 13pt;" width="100%">
            <tbody >
                <tr style="line-height: 12px" >
                    <td  rowspan="2" width="30px">ลำดับที่</td>
                    <td colspan="2" style="  margin-bottom: -20px;" align="center" width="200px">ตราสารตามบัญชีอัตราอากรแสตมป์</td>
                    <td align="center">เลขประจำตัวผู้เสียภาษีอากร</td>
                    <td rowspan="2" align="center" >เลขที่สัญญา</td>
                    <td colspan="2"  align="center">มูลค่าของตราสาร</td>
                    <td colspan="2"align="center">จำนวนเงินค่าอากร <br> แสตมป์ที่ขอชำระ</td>
                </tr>
                <tr style="line-height: 15px" >
                    <td  align="center">ข้อ</td>
                    <td  align="center" style="line-height: 12px ">
                        รายการตราสารที่ขอชำระ
                        อากรแสตมป์เป็นตัวเงิน
                        (ระบุชื่อตราสาร)</td>
                    <td align="center">ชื่อคู่สัญญาหรือผู้ที่ต้องเสียอากร (ให้ระบุชัดเจนว่าเป็น นาย นาง นางสาว หรือยศ)</td>
                    <td  align="center">บาท</td>
                    <td  align="center">สต.</td>
                    <td align="center">บาท</td>
                    <td  align="center">สต.</td>
                </tr>

                <tr style="font-size: 13pt;line-height: 15px;" >
                    <td width="30px" align="center">{{(@$row+1)}}</td>
                    <td width="30px" align="center">{{@$dataCusAll[(@$row+1)][0]}}</td>
                    <td  width="160px" align="center">{{@$dataCusAll[(@$row+1)][1]}}</td>
                    <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+1)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+1)][3]}}</td>
                    <td width="120px" align="center">{{@$dataCusAll[(@$row+1)][4]}}</td>
                    @php
                        @$rateTolal = explode('.', number_format( @$dataCusAll[(@$row+1)][5],2,'.','' ));
                        @$rateStamp = ceil( @$dataCusAll[(@$row+1)][6]);
                    @endphp
                    <td width="70px" align="right">{{number_format(@$rateTolal[0],0)}}</td>
                    <td width="30px" align="left">{{".".@$rateTolal[1]}}</td>
                    <td width="70px" align="right"> {{@$rateStamp}}</td>
                    <td width="30px" align="left">-</td>
                </tr>
                <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+2)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+2)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+2)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+2)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+2)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+2)][4]}}</td>
                     @php
                         @$rateTolal2 = explode('.', number_format( @$dataCusAll[(@$row+2)][5],2,'.','' ));
                         @$rateStamp2 = ceil( @$dataCusAll[(@$row+2)][6] );
                     @endphp
                     <td width="70px" align="right">{{number_format(@$rateTolal2[0],0)}}</td>
                     <td width="30px" align="left">{{".".@$rateTolal2[1]}}</td>
                     <td width="70px" align="right"> {{@$rateStamp2}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+3)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+3)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+3)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+3)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+3)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+3)][4]}}</td>
                     @php
                         @$rateTolal3 = explode('.', number_format( @$dataCusAll[(@$row+3)][5],2,'.','' ));
                         @$rateStamp3 =ceil( @$dataCusAll[(@$row+3)][6] );
                     @endphp
                     <td width="70px" align="right">{{number_format(@$rateTolal3[0],0)}}</td>
                     <td width="30px" align="left">{{".".@$rateTolal3[1]}}</td>
                     <td width="70px" align="right"> {{@$rateStamp3}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+4)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+4)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+4)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+4)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+4)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+4)][4]}}</td>
                     @php
                         @$rateTolal4 = explode('.', number_format( @$dataCusAll[(@$row+4)][5],2,'.','' ));
                         @$rateStamp4 = ceil( @$dataCusAll[(@$row+4)][6] );
                     @endphp
                     <td width="70px" align="right">{{number_format(@$rateTolal4[0],0)}}</td>
                     <td width="30px" align="left">{{".".@$rateTolal4[1]}}</td>
                     <td width="70px" align="right"> {{@$rateStamp4}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+5)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+5)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+5)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+5)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+5)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+5)][4]}}</td>
                     @php
                         @$rateTolal5 = explode('.', number_format( @$dataCusAll[(@$row+5)][5],2,'.','' ));
                         @$rateStamp5 = ceil( @$dataCusAll[(@$row+5)][6] );
                     @endphp
                     <td width="70px" align="right">{{number_format(@$rateTolal5[0],0)}}</td>
                     <td width="30px" align="left">{{".".@$rateTolal5[1]}}</td>
                     <td width="70px" align="right">{{ @$rateStamp5}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+6)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+6)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+6)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+6)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+6)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+6)][4]}}</td>
                     @php
                         @$rateTolal6 = explode('.', number_format( @$dataCusAll[(@$row+6)][5],2,'.','' ));
                         @$rateStamp6 = ceil( @$dataCusAll[(@$row+6)][6] );
                     @endphp
                     <td width="70px" align="right">{{@$dataCusAll[(@$row+6)][5]!=''?number_format(@$rateTolal6[0],0):''}}</td>
                     <td width="30px" align="left">{{@$dataCusAll[(@$row+6)][5]!=''?".".@$rateTolal6[1]:''}}</td>
                     <td width="70px" align="right"> {{ @$rateStamp6}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 <tr style="font-size: 13pt;line-height: 15px;" >
                     <td width="30px" align="center">{{(@$row+7)}}</td>
                     <td width="30px" align="center">{{@$dataCusAll[(@$row+7)][0]}}</td>
                     <td  width="160px" align="center">{{@$dataCusAll[(@$row+7)][1]}}</td>
                     <td  width="450px">&nbsp;&nbsp;บัตรประชชาชน : @php  echo cardIDFrom(@$dataCusAll[(@$row+7)][2]); @endphp<br> ชื่อคู่สัญญา : {{@$dataCusAll[(@$row+7)][3]}}</td>
                     <td width="120px" align="center">{{@$dataCusAll[(@$row+7)][4]}}</td>
                     @php
                         @$rateTolal7 = explode('.', number_format( @$dataCusAll[(@$row+7)][5],2,'.','' ));
                         @$rateStamp7 = ceil( @$dataCusAll[(@$row+7)][6] );
                     @endphp
                     <td width="70px" align="right">{{@$dataCusAll[(@$row+7)][5]!=''?number_format(@$rateTolal7[0],0):''}}</td>
                     <td width="30px" align="left">{{@$dataCusAll[(@$row+7)][5]!=''?".".@$rateTolal7[1]:''}}</td>
                     <td width="70px" align="right"> {{ @$rateStamp7}}</td>
                     <td width="30px" align="left">-</td>
                 </tr>
                 @php
                     $totalPageSum = @$dataCusAll[(@$row+1)][5]+@$dataCusAll[(@$row+2)][5]+@$dataCusAll[(@$row+3)][5]+@$dataCusAll[(@$row+4)][5]+@$dataCusAll[(@$row+5)][5]+@$dataCusAll[(@$row+6)][5]+@$dataCusAll[(@$row+7)][5];
                     $totalStamp = @$rateStamp+@$rateStamp2+@$rateStamp3+@$rateStamp4+@$rateStamp5+@$rateStamp6+@$rateStamp7;
                 @endphp
                <tr >
                    <td colspan="3"></td>
                    <td colspan="2" align="right" style="font-size: 16px">รวม (นำ ไปรวมกับ <font style="font-size: 20px;font-weight: bold">ใบแนบ อ.ส.4ข</font>  แผ่นอื่น (ถ้ามี))</td>
                    <td align="right">{{number_format($totalPageSum,0)}}</td>
                    <td align="left">.00</td>
                    <td align="right">{{number_format($totalStamp,0)}}</td>
                    <td align="left">-</td>
                </tr>
                <tr  style="line-height: 15px;" >

                    <td colspan="9" class="" align="right" >
                        <span>
                            <p style="font-size:8pt;top:590px; left :600px; border: solid 1px rgb(0, 0, 0); border-radius: 100%;line-height: 8px;  position:absolute;width:60px; height: 40px; text-align: center;padding-top:20px"><span style="position:absolute; top: 13px; left: 12px;"> ประทับตรา <br>นิติบุคคล <br>  (ถ้ามี)</span> </p>
                              <span style="position: inherit">  ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้เป็นรายการที่ถูกต้องและเป็นจริงทุกประการ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/> <br/>
                                 ลงชื่อ..................................................................................ผู้ขอชำระ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                 (................................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                 ตำแหน่ง............................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                 ยื่นวันที่..............เดือน......................................พ.ศ. ...................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              </span>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </span>
    @php
     @$row=@$row+7;
    @endphp
 @endfor --}}
</body>

</html>
