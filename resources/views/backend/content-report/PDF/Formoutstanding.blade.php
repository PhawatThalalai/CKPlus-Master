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
            <p>รายงานลูกหนี้ Curent-Non-Curent</p>
            <p>ลูกหนี้ ณ. วันที่ 00/00/0000 </p>
        </div>
        <div>
            <span>บริษัท ชูเกิยรติลิสซิ่ง กระบี่ จำกัด</span><br>
            <table width="100%">
                <thead>
                    <tr>
                        <td>วันที่พิมพ์: 00/00/0000 00:00:00</td>
                        <td align="right">หน้า: 1/..</td>
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
                            เลขที่สัญญา<br>
                            วันทำสัญญา
                        </th>
                        <th rowspan="2" colspan="2">
                            ชื่อลูกค้า<br>
                            รหัสลูกค้า
                        </th>
                        <th rowspan="2">
                            วันดิวงวดแรก<br>
                            ดิวงวดสุดท้าย
                        </th>
                        <th rowspan="2">
                            ยอดก่อนชำระ<br>
                            ยอดเงินต้น
                        </th>
                        <th colspan="4">
                            จำนวนงวด
                        </th>
                        <th colspan="2">
                            จำนวนเงินค่างวด
                        </th>
                        <th colspan="2">
                            ดอกผลรอตัด
                        </th>
                        <th rowspan="2">
                            ลูกหนี้คงเหลือ
                        </th>
                    </tr>
                    <tr style="background-color: gray;color: #000;">
                        <th style="border-top: 4px solid #fdf0d5">
                            ทั้งหมด
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            ทีเหลือ
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Current
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Long Term
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Current
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Long Term
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Current
                        </th>
                        <th style="border-top: 4px solid #fdf0d5">
                            Long Term
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $n = 0;
                    @endphp
                    @for ($i = 0; $i < 20; $i++)
                    @php
                        $n++;
                    @endphp
                        <tr>
                            <td>{{ $n }}</td>
                            <td>
                                KBHQ
                            </td>
                            <td>
                                P08-946464646 <br>
                                11/10/2022
                            </td>
                            <td colspan="2">
                                นาย ธรรมมมม กดกดก<br>
                                2323232323
                            </td>
                            <td>
                                11/10/2022 <br>
                                11/10/2022
                            </td>
                            <td>
                                121212000 <br>
                                121212000
                            </td>
                            <td>
                                60
                            </td>
                            <td>
                                40
                            </td>
                            <td>
                                40 
                            </td>
                            <td>
                                40 
                            </td>
                            <td>
                                406565
                            </td>
                            <td>
                                565656 
                            </td>
                            <td>
                                5656 
                            </td>
                            <td>
                                005656500 
                            </td>
                            <td>
                                65656566 
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </body>
</html>
