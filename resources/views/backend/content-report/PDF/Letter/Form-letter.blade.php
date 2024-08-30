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
          text-align: center;
        }
  </style>
      
    <body class="body">
       <div>
            <h4 style="text-align: center;">ใบนำส่งสิ่งของทางไปรษณีย์</h4>
            <span>ได้ฝากส่งสิ่งของทางไปรษณีย์โดยชำระค่าบริการเป็นเงินชื่อ ดังรายการต่อไปนี้</span>
       </div>
       <div>
            <table border="1">
                <thead>
                    <tr>
                        <th rowspan="2">ลำดับ</th>
                        <th rowspan="2">ผู้รับ</th>
                        <th rowspan="2">รหัสไปรษณีย์ปลายทาง</th>
                        <th colspan="2">
                            เลขที่บริการ
                        </th>
                        <th rowspan="2">ค่าบริการ</th>
                        <th rowspan="2">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <th>EMS</th>
                        <th>ลงทะเบียน</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($dataResToArr as $key => $item)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ @$item->Name_Cus }}</td>
                            <td>81100</td>
                            <td>{{ @$item->EMSNO }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" style="text-align: right;">ค่าบริการรวมทั้งสิ้น</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div>
                <h6>ยอดฝากครั้งนี้</h6>
                <div style="display: flex; justify-content: center;">
                    <table border="1" class="total_tb">
                        <thead>
                            <tr>
                                <th rowspan="2">ประเภทบริการ</th>
                                <th colspan="2">ในประเทศ</th>
                                <th colspan="2">ต่างประเทศ</th>
                                <th rowspan="2">รวมเงิน <br> (1+2)</th>
                            </tr>
                            <tr>
                                <th>ชิ้น</th>
                                <th>เงิน(1)</th>
                                <th>ชิ้น</th>
                                <th>เงิน(2)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>EMS</td>
                                <td>{{ $count-1 }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>ลงทะเบียน</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>พัสดุไปรษณีย์</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>ธรรมดา</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>ยอดรวม</td>
                                <td>{{ $count-1 }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table>
                    <tbody>
                        <tr>
                            <td rowspan="3">
                                ได้ตรวจสอบถูกต้องแล้ว <br>
                                (ลงชื่อ) ...........................................<br>
                                ผู้รับผิดชอบในการฝาก
                            </td>
                            <td rowspan="3">
                                ได้ตรวจสอบถูกต้องแล้ว <br>
                                (ลงชื่อ) ...........................................<br>
                                ผู้รับผิดชอบในการฝาก
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
       </div>
    </body>
</html>
