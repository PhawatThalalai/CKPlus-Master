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
        font-size:12pt;
      }

      html { 
        margin: 40px ;
      }

      table {
          border-collapse: collapse;
          width: 100%;
        }

        th {
          background: rgba(72, 191, 227, 0.9);
          border-top: 4px solid rgba(105, 48, 192, 0.6);
        }

        th, td {
            font-size: 12px;
          text-align: left;
        }
        
  </style>
      
    <body class="body">
        <div style="text-align: center;">
            <p>รายงานกำไรตามวันครบกำหนดชำระ (EFF) <br>
            สาขา KBHQ ลูกหนี้ ณ. วันที่ {{ @$Fdate }} ถึง {{ @$Tdate }}
            </p>
        </div>
        <div>
            <span>บริษัท ชูเกิยรติลิสซิ่ง กระบี่ จำกัด</span><br>
            <table width="100%">
                <thead>
                    <tr>
                        <td>วันที่พิมพ์: 00/00/0000 00:00:00</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            @if ($tableLoan == 'HP')
                <table width="100%">
                    <thead>
                        <tr style="background-color: gray;color: #000;">
                            <th>
                                ลำดับ
                            </th>
                            <th>
                                เลขที่สัญญา
                            </th>
                            <th>
                                ชื่อ-สกุล
                            </th>
                            <th>
                                ดิวงวดแรก
                            </th>
                            <th>
                                ดิวงวดสุดท้าย
                            </th>
                            <th>
                                ดิวงวดนี้
                            </th>
                            <th>
                                จำนวนงวด
                            </th>
                            <th>
                                เงินลงทุน
                            </th>
                            <th>
                                ดอกผล
                            </th>
                            <th>
                                ค่างวด
                            </th>
                            <th>
                                ลูกหนี้ทั้งสัญญา
                            </th>
                            <th>
                                ลูกหนี้คงเหลือ
                            </th>
                            <th>
                                เงินต้นคงเหลือ
                            </th>
                            <th>
                                ดอกผลสะสม
                            </th>
                            <th>
                                ดอกผลงวดนี้
                            </th>
                            <th>
                                ดอกผลตามรับชำระจริง
                            </th>
                            <th>
                                ส่วนลด
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = $countPage == 1 ? 1 : $ArrayCount + 1;
                        @endphp
                        @foreach ($dataCut as $key => $value)
                            <tr style="border-bottom: 1px solid #000; text-align: center;">
                                <td>
                                    {{ $count++ }}
                                </td>
                                <td>
                                    {{ $value->contno }}
                                </td>
                                <td>
                                    {{ $value->Name_Cus }}
                                </td>
                                <td>
                                    {{ $value->fdate }}
                                </td>
                                <td>
                                    {{ $value->ldate }}
                                </td>
                                <td>
                                    {{ $conttype == 2 || $conttype == 3 || $tableLoan == 'HP' ? $value->ddate : $value->DUEDATE }}
                                </td>
                                <td>
                                    {{ $value->t_nopay }}
                                </td>
                                <td>
                                    {{ $value->tcshprc }}
                                </td>
                                <td>
                                    {{ number_format($value->NETPROFIT, 2) }}
                                </td>
                                <td>
                                {{ number_format($value->tot_upay, 2) }}
                                </td>
                                <td>
                                    {{ number_format($value->totprc, 2) }}
                                </td>
                                <td>
                                    {{ number_format($value->Arbl, 2) }}
                                </td>
                                <td>
                                    {{ number_format($value->payintbefore, 2) }}
                                </td>
                                <td>
                                    {{ number_format($value->inteffmonth , 2) }}
                                </td>
                                <td>
                                    {{ number_format($value->intbalance, 2) }} 
                                </td>
                                <td>
                                    0 
                                </td>
                                <td>
                                    {{ $value->DISCT != '' ? $value->DISCT : '0' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table width="100%">
                    <thead>
                        <tr style="background-color: gray;color: #000;">
                            <th rowspan="2">
                                ลำดับ
                            </th>
                            <th rowspan="2">
                                เลขที่สัญญา
                            </th>
                            <th rowspan="2">
                                ชื่อ-สกุล
                            </th>
                            <th rowspan="2">
                                ดิวงวดแรก
                            </th>
                            <th rowspan="2">
                                ดอกผลทั้งหมด
                            </th>
                            <th rowspan="2">
                                จำนวนงวด
                            </th>
                            <th rowspan="2">
                                งวดที่
                            </th>
                            <th rowspan="2">
                                วันครบกำหนด
                            </th>
                            <th rowspan="2">
                                ค่างวด
                            </th>
                            <th rowspan="2">
                                ภาษีงวดนี้
                            </th>
                            <th rowspan="2">
                                ดอกผลสะสม<br>
                                ถึงงวดก่อน
                            </th>
                            <th rowspan="2">
                                เงินต้นงวดนี้
                            </th>
                            <th rowspan="2">
                                รับรู้ดอกผลงวดนี้
                            </th>
                            <th rowspan="2">
                                ส่วนลด
                            </th>
                            <th rowspan="2">
                                ดอกผลคงเหลือ
                            </th>
                            <th rowspan="2">
                                ภาษีคงเหลือ
                            </th>
                            <th rowspan="2">
                                วันที่หยุด<br>
                                รับรู้รายได้
                            </th>
                        </tr>
                        <tr></tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($dataCut as $key => $value)
                            <tr style="border-bottom: 0.5px solid #000; text-align: center;">
                                <td> 
                                    {{ $count++ }}
                                </td>
                                <td> 
                                    {{ $value->contno }}
                                </td>
                                <td> 
                                    {{ $value->Name_Cus }}
                                </td>
                                <td> 
                                    {{ $value->fdate }}
                                </td>
                                <td> 
                                    {{  number_format($value->netprofit, 2) }}
                                </td>
                                <td> 
                                    {{ $value->t_nopay }}
                                </td>
                                <td> 
                                    {{ $value->t_nopay }}
                                </td>
                                <td> 
                                    {{ $value->ldate }}
                                </td>
                                <td> 
                                    {{ number_format($value->tot_upay, 2) }}
                                </td>
                                <td> 
                                    {{ number_format((($value->tot_upay * 7)/107), 2) }}
                                </td>
                                <td> 
                                    {{ number_format($value->payintbefore, 2) }}
                                </td>
                                <td> 
                                    {{ number_format($value->tcshprc, 2) }}
                                </td>
                                <td> 
                                    {{ number_format($value->inteffmonth, 2) }}
                                </td>
                                <td> 
                                    {{ $value->DISCT !== null ? number_format($value->DISCT, 2) : 0.00 }}
                                </td>
                                <td> 
                                    {{ number_format($value->intbalance, 2) }}
                                </td>
                                <td> 
                                    {{ number_format($value->NETPROFIT, 2) }}
                                </td>
                                <td style="color: blueviolet;"> 
                                    {{ $value->DTSTOPV }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </body>
</html>
