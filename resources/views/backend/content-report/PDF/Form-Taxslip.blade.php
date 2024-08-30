<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>

  </head>
  <style>
      @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('fonts/THSarabun.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
        }
        @font-face {
            font-family: 'THSarabun Bold';
            font-style: normal;
            font-weight: bold;
            src: url({{ asset('fonts/THSarabun Bold.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
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

      .page_break { page-break-before: always; }
      body {
        /* color : white; */
        font-family: 'TFPimpakarn';
        font-size: 12pt;
      }
      u {    
          border-bottom: 2px dotted #000;
          text-decoration: none;
          margin : 10px;
          /* position: absolute; */
          /* top: 80px; */
          /* right: 0; */
         
      }
      .fontBl{
        font-family: 'TFPimpakarn'; 
        font-weight: bolder; 
        font-size: 12pt;
      }

      .subtitle {
        margin-top: -10px;
        display: block;
      }

      .subtitle-box {
        display: block;
      }

      .title-layout td{
        width: 60% 40%;
      }

      .title {
        margin-top: -60px;
      }

      .text-box {
        background: #fefae0;
        padding: 0 10px 10px 10px;
        border-radius: 10px;
      }

      html { 
        margin: 40px ;
      }

      .table-heder {
        margin-top: -38px;
        font-size: 18px;
        background: #495057;
        opacity: ;
        color: #fff;
      }

      .table-heders {
        font-size: 18px;
        background: #495057;
        color: #fff;
      }

      .text-table {
        display: block;
        margin-top: -9px;
      }

      .table-style {
        border: none;
      }
      
      .text-2div  {
        width: 100%;
        padding: 20px 10px 0 10px;
        display: table;
      }

      .items-rigth {
        display: table-cell;
      }

      .items-left {
        display: table-cell;
      }
      
      .infor  {
        padding: 0 10px 0 10px;
      }

      .style-bath {
        padding: 0 10px 0 10px;
        width: 50px;
        border-radius: 0 20px 20px 0;
        background: #495057;
        color: #fff;
        font-size: 16px;
     }

     .footer {
        row-gap: 10px;
     }

     .body-data table,.body-data tr,.body-data th,.body-data td{
        border: 1px solid;
        border-collapse: collapse;
    }

    .headers {
        margin-bottom: 10px;
    }

    .sub-box {
        margin-top: -30px;
    }
  </style>
      
@foreach ($response as $res)
@php
    $total = $res->CRCOST + $res->VATAMT;
@endphp
<body class="body">
    {{-- <div class="headers">
        <center><img src="{{ asset('images/ck_logo.png') }}" width="100" alt=""></center>
    </div> --}}
    <div>
        <table width="100%">
                <tr class="title-layout">
                    <td class="title-box">
                        <h2 class="title">{{ $res->Company_Name }}</h2>
                        <div class="sub-box">
                            <span class="subtitle">{{ $res->Company_Addr }}</span>
                            <span class="subtitle">โทรศัพท์ (075) 650919 แฟกซ์ (075) 650683</span>
                        </div>
                    </td>
                    <td class="item-box">
                        <div class="text-box">
                            <center><h3 style="margin-top: -5px;">ใบกำกับภาษี/ใบแจ้งหนี้</h3></center>
                            <div style="margin-top: -20px;">
                                <span class="subtitle-box">เลขที่: {{ $res->TAXNO }}</span>
                                <span class="subtitle-box">วันที่: {{ $res->TAXDT }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
        </table>
    </div>

    <div class="body-data">
        <span>เลขที่ทะเบียนนิตืบุคคล/ประจำตัวผู้เสียภาษี: {{ $res->Company_Id }}</span>
        <table width="100%">
            <tr class="title-layout">
                <td rowspan="2" colspan="2">
                  <div class="infor">
                        <span class="text-table">ชื่อ: {{ $res->CusName }} เลขที่ผู้เสียภาษี {{ $res->IDCard_cus }}</span>
                        <span class="text-table">เลขที่บัญชี/เลขที่สัญญาเช่าซื้อ: {{ $res->CONTNO }}</span>
                        <span class="text-table">ที่อยู่: {{ $res->cusaddress }}</span>
                  </div>
                  <div class="text-2div">
                        {{-- <table width="100%">
                            <tr>
                                <td> --}}
                                <div class="items-left">
                                    <span class="text-table">ยี่ห้อ: {{ $res->Brands }}</span>
                                    <span class="text-table">แบบ: </span>
                                    <span class="text-table">ขนาด: {{ $res->Vehicle_CC }} </span>
                                    <span class="text-table">เลขตัวถัง: {{ $res->Vehicle_Chassis }} </span>
                                    <span class="text-table">เลขที่ทะเบียน: {{ $res->typeLicense }} </span>
                                    <span class="text-table">ของแถม: </span>
                                </div>
                                {{-- </td>
                                <td> --}}
                                <div class="items-rigth">
                                    <span class="text-table">รุ่น: {{ $res->Groups }}</span>
                                    <span class="text-table">สี: {{ $res->Vehicle_Color }}</span>
                                    <span class="text-table">สถานะ: </span>
                                    <span class="text-table">เลขเครื่อง: {{ $res->Vehicle_Engine }}</span>
                                    <span class="text-table">ค่าเช้าซื้องวดที่: {{ $res->FPAY }} - {{ $res->LPAY }} </span>
                                    <span class="text-table"></span>
                                </div>
                                {{-- </td>
                            </tr>
                        </table> --}}
                  </div>
                </td>
                <td align="center">
                    <div class="table-heder">
                        <span>รายการ</span>
                    </div>
                    <div>
                        <span>มูลค่าสินค้าหรือบริการ</span>
                    </div>
                </td>
                <td  align="center">
                    <div class="table-heder">
                        <span>บาท</span>
                    </div>
                    <div>
                        <span>{{ number_format($res->CRCOST, 2) }}</span>
                    </div>
                </td>
            </tr>
            <tr align="center">
                <td>
                    ภาษีมูลค้าเพิ่ม 7%
                </td>
                <td>
                    {{ number_format($res->VATAMT, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="style-bath">
                        <center><span>บาท</span></center>
                    </div>
                </td>
                <td style="background: #495057; color: #fff;" align="center">
                    <div>
                        <span>จำนวนสุทธิ</span>
                    </div>
                </td>
                <td align="center">
                    <div>
                        {{ number_format($total, 2) }}
                    </div>
                </td>
            </tr>
        </table>
        <div>
            <span>**เอกสารนี้ไม่ใช้ใบเสร็จรับเงิน ผู้เช้าชื้อมีหน้าที่ชำระภาษีมูลค่าเพิ่ม นับตั่งแต่วันที่ถึงกำหนดชำระค่าเช้าซื้อ กรุณาเก็บเอกสารเพื่อประกอบการโอนทะเบียนรถ</span>
        </div>
    </div>

    <div class="footer">
        <span>ผู้มีอำนาจลงนาม: .................................................................................</span>
        <span>ผู้จัดทำ: .................................................................................</span>
    </div>
</body>
@endforeach
</html>
