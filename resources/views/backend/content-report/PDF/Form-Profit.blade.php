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
          font-size: 14px;
          text-align: left;
        }
  </style>
      
    <body class="body">
        <div style="text-align: center;">
            <p>รายงานกำไรคงเหลือ (EFF)</p>
            <p>ลูกหนี้ ณ. วันที่ {{ $Fdate }} ถึงวันที่ {{ $Tdate }}</p>
        </div>
        <div>
            <span>บริษัท ชูเกิยรติลิสซิ่ง กระบี่ จำกัด</span><br>
            <table width="100%">
                <thead>
                    <tr>
                        <td>วันที่พิมพ์: {{ $datePrint }}</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr style="background-color: gray;color: #000;">
                        <th rowspan="2">
                            ลำดับ<br>
                        </th>
                        <th rowspan="2">
                            สาขา
                        </th>
                        <th rowspan="2">
                            เลขที่สัญญา
                        </th>
                        <th rowspan="2">
                            ชื่อลูกค้า
                        </th>
                        <th rowspan="2">
                            วันดิวงวดแรก<br>
                            ดิวงวดสุดท้าย
                        </th>
                        <th rowspan="2">
                            ยอดผ่อนชำระ<br>
                            เงินลงทุน
                        </th>
                        <th rowspan="2">
                            จำนวนงวด
                        </th>
                        <th rowspan="2">
                            ดอกผล
                        </th>
                        <th rowspan="2">
                            ลูกหนี้ถึงดิว<br>
                            ดอกผลถีงดิว
                        </th>
                        <th rowspan="2">
                            ยอดหักลูกหนี้<br>
                            รับดอกผลแล้ว
                        </th>
                        @if (!empty($value->DISCT))
                            <th rowspan="2">
                                ส่วนลด
                            </th>
                        @endif
                        <th rowspan="2">
                            รับชำระสุทธิ<br>
                            ค้างงวด
                        </th>
                        <th rowspan="2">
                            เงินค่างวด<br>
                            ดอกผลค้างรับ
                        </th>
                        <th rowspan="2">
                            ลูกหนี้คงเหลือ<br>
                            เงินต้นคงเหลือ
                        </th>
                        <th rowspan="2">
                            ดอกผลคงเหลือ<br>
                            ที่ยังไม่ถึงดิว
                        </th>
                    </tr>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = $countPage == 1 ? 1 : $ArrayCount + 1;
                    @endphp
                    @foreach ($dataCut as $key => $value)
                        <tr style="border-bottom: 1px solid #000;">
                            <td>
                                {{ $count++ }}
                            </td>
                            <td>
                                {{ $value->locat }}
                            </td>
                            <td>
                                {{ $value->contno }}
                            </td>
                            <td>
                                {{ $value->Name_Cus }}<br>
                            </td>
                            <td>
                                {{ $value->fdate }}<br>
                                {{ $value->ldate }}
                            </td>
                            <td>
                                121211.00 <br>
                                {{ number_format($value->tcshprc, 2) }}
                            </td>
                            <td>
                                {{ $value->t_nopay }}
                            </td>
                            <td>
                                {{ number_format($value->NETPROFIT, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->sumDamt, 2) }} <br>
                                {{ number_format( $value->sumIntdue, 2) }}
                            </td>
                            <td>
                                12121.00 <br>
                                10232.00
                            </td>
                            @if (!empty($value->DISCT))
                                <td>
                                    {{ $value->DISCT != '' ? number_format($value->DISCT ,2) : 0.00 }}
                                </td>
                            @endif
                            <td>
                                120121.00 <br>
                                2.00
                            </td>
                            <td>
                                {{ number_format($value->tot_upay, 2) }} <br>
                                {{ number_format($value->sumKangInt, 2) }}
                            </td>
                            <td>
                                {{ number_format($value->Arbl, 2) }} <br>
                                {{ number_format($value->capitalbl , 2) }}
                            </td>
                            <td>
                                9121.00 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
