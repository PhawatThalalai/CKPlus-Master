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
          text-align: left;
        }
  </style>
      
    <body class="body">
        <div style="text-align: center;">
            <p>รายงานกำไรคงเหลือ (EFF)</p>
            <p>ลูกหนี้ ณ. วันที่ 00/00/0000 </p>
        </div>
        <div>
            <span>บริษัท ชูเกิยรติลิสซิ่ง กระบี่ จำกัด</span><br>
            <table width="100%">
                <thead>
                    <tr>
                        <td>วันที่พิมพ์: 00/00/0000 00:00:00</td>
                        <td style="text-align: right;">หน้า: 1/..</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr style="background-color: gray;color: #000;">
                        <th rowspan="2">
                            สาขา
                        </th>
                        <th rowspan="2">
                            เลขที่สัญญา
                        </th>
                        <th rowspan="2">
                            ชื่อ-สกุล
                        </th>
                        <th rowspan="2">
                            ดิวงวดแรก<br>
                            ดิวงวดสุดท้าย
                        </th>
                        <th rowspan="2">
                            จำนวนงวด
                        </th>
                        <th rowspan="2">
                            เงินลงทุน
                        </th>
                        <th rowspan="2">
                            ดอกผล
                        </th>
                        <th rowspan="2">
                            ค่างวด
                        </th>
                        <th rowspan="2">
                            ลูกหนี้ทั้งสัญญา
                        </th>
                        <th rowspan="2">
                            ลูกหนี้คงเหลือ<br>
                            เงินต้นคงเหลือ
                        </th>
                        <th rowspan="2">
                            ดอกผลสะสม<br>
                            ดอกผลงวดนี้
                        </th>
                        <th rowspan="2">
                            ดอกผลคงเหลือ<br>
                            รับชำระ
                        </th>
                        <th rowspan="2">
                            ดอกผลสะสม<br>
                            ดอกผลงวดนี้
                        </th>
                        <th rowspan="2">
                            ดอกผลงวดนี้<br>
                            ดอกผลคงเหลือ
                        </th>
                        <th rowspan="2">
                            ส่วนลดสะสม
                        </th>
                    </tr>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($dataProfit as $key => $value)
                        <tr style="border-bottom: 1px solid #000;">
                            <td>
                                {{ $value->locat }}
                            </td>
                            <td>
                                {{ $value->contno }}
                            </td>
                            <td>
                                {{ $value->Name_Cus }}
                            </td>
                            <td>
                                {{ $value->fdate }}<br>
                                {{ $value->ldate }}
                            </td>
                            <td>
                                {{ $value->t_nopay }}
                            </td>
                            <td>
                                {{ number_format($value->tcshprc, 2) }}
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
                                {{ number_format($value->Arbl, 2) }}<br>
                                {{ number_format($value->capitalbl, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->payintbefore, 2) }}<br>
                                {{ number_format($value->inteffmonth, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->intbalance, 2) }}<br>
                                {{ number_format($value->sumDamt, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->sumIntdue, 2) }}<br>
                                {{ number_format($value->sumPayamt, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->sumPayInt, 2) }}<br>
                                {{ number_format($value->sumKangInt, 2) }}
                            </td>
                            <td>
                                {{ $value->DISCT != '' ? $value->DISCT : '0' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
