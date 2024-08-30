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
            <h3>รายงานภาษีขาย (ปกติ)</h3>
            <p>จากวันที่ {{ $Fdate }} ถึงวันที่ {{ $Tdate }}</p>
        </div>
        <div>
            <span>ชื่อผู้ประกอบการ: {{ $response[0]->Company_Name }}</span><br>
            <span>ชื่อสถานประกอบการ: {{ $response[0]->Company_Name }}</span><br>
            <span>เลขประจำตัวผู้เสียภาษี: {{ $response[0]->Company_Id }}</span><br>
            <table width="100%">
                <thead>
                    <tr>
                        <td>วันที่พิมพ์: {{ $currentTime }}</td>
                        <td style="text-align: right">หน้า: 1/..</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div>
            <table class="tables" width="100%" align="center">
                <thead>
                    <tr style="background-color: gray;color: #000;">
                        <th>ลำดับ</th>
                        <th>วันที่ใบกำกับ</th>
                        <th>เลขที่ใบกำกับ</th>
                        <th>เลขที่สัญญา</th>
                        <th>ชื่อลูกค้า</th>
                        <th>เลขประจำตัวผู้เสียภาษี</th>
                        <th>รายการ</th>
                        <th>มูลค่าสินค้า</th>
                        <th>ภาษี 7%</th>
                        <th>มูลค่ารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $n = 0;
                        $total_NETA = 0;
                        $total_VAT = 0;
                        $total_TOTAMT = 0;
                    @endphp
                    @foreach ($response as $item)
                        @php
                            $n++;
                            $total_NETA += $item->NETAMT;
                            $total_VAT += $item->VATAMT;
                            $total_TOTAMT += $item->TOTAMT;
                        @endphp
                        <tr>
                            <td>{{ $n }}</td>
                            <td>{{ $item->TAXDT }}</td>
                            <td>{{ $item->TAXNO }}</td>
                            <td>{{ $item->CONTNO }}</td>
                            <td>{{ $item->CusName }}</td>
                            <td>{{ $item->IDCard_cus }}</td>
                            <td>{{ $item->DECP }}</td>
                            <td>{{  number_format($item->NETAMT, 2) }}</td>
                            <td>{{  number_format($item->VATAMT, 2) }}</td>
                            <td>{{  number_format($item->TOTAMT, 2) }}</td>
                        </tr>
                    @endforeach
                        <tr style="border-top: 4px solid #003049; background:#fdf0d5;">
                            <td colspan="4" rowspan="4">รวมทั้งสิน {{ $n }} รายการ <br><br><br></td>
                            <td colspan="3" rowspan="4">
                                ยอดกำกับรวมที่ออกใบกำกับภาษีขาย <br>
                                ยอดกำกับรวมที่ออกใบกำกับภาษีขาย <br>
                                ยอดกำกับรวมที่ออกใบกำกับภาษีขาย <br>
                                ยอดกำกับรวมที่ออกใบกำกับภาษีขาย 
                            </td>
                            <td rowspan="4">
                                {{ number_format($total_NETA, 2) }} <br>
                                (0.00) <br>
                                (0.00) <br>
                                {{ number_format($total_NETA, 2) }}
                            </td>
                            <td rowspan="4">  
                                {{ number_format($total_VAT, 2) }} <br>
                                (0.00) <br>
                                (0.00) <br>
                                {{ number_format($total_VAT, 2) }}
                            </td>
                            <td rowspan="4">
                                {{  number_format($total_TOTAMT, 2) }} <br>
                                (0.00) <br>
                                (0.00) <br>
                                {{  number_format($total_TOTAMT, 2) }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
