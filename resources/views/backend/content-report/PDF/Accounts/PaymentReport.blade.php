<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      @page {
         size:landscape;
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
          padding: 0 5px 0 5px;
          text-align: left;
        }
 </style>
  </head>
  <body style="">
    <div  style=" text-align: center; height: 0.4cm">
       <h3 style=" text-align: center; height: 0.4cm">รายงานการรับชำระประจำวัน</h3> 
       <h4>ระหว่างวันที่ {{formatDateThaiShort_monthNum(@$Fdate)}} ถึงวันที่ {{formatDateThaiShort_monthNum(@$Tdate)}}</h4>
    </div> 
    <p align="right">วันที่พิมพ์ : {{FormatDatethaiLong(date('d-m-Y'))}} <br/>ผู้พิมพ์ : {{auth()->user()->name}}</p>
  <hr  >
  
 
  
  <table width="100%">
    <thead>
      <tr style="line-height:100%;background-color:#F2F0EF;">
        <th align="center" >สาขา</th>
        <th align="center" >เลขที่ใบรับ </th>
        <th align="center" >วันที่รับชำระ </th>
        <th align="center" >ชื่อลูกค้า / เลขสัญญา</th>
        <th align="center" >ค่างวด</th>
        <th align="center" >{{ $tableLoan=="PSL"?'เงินต้น':'ยอดไม่รวมVAT'}}</th>
        <th align="center" >{{ $tableLoan=="PSL"?'ดอกเบี้ย':'VAT'}}</th>
        <th align="center" >ส่วนลด</th>
        <th align="center" >ค่าปรับ</th>
        <th align="center" >ส่วนลดค่าปรับ</th>
        <th align="center" >ค่าทวงถาม</th>
        <th align="center" >ส่วนลดทวงถาม</th>
        <th align="center" >รับสุทธิ</th>
        <th align="center" >ชำระค่า</th>
      </tr>
    </thead>
    <tbody>
       @php
          $countCancel = 0;
          $countNumTran = 0;        
        @endphp
      @foreach($dataCut as $key => $value)
            @php
              $countNumTran++;
              if($value->flag=="C"){
                $countCancel++;
              }   
            @endphp
          <tr style="background: {{ $value->flag === 'C' ? '#ff4d6d' : '' }}; color: {{ $value->flag === 'C' ? '#fff' : '' }}; border-top: {{ $value->flag === 'C' ? '4px solid #ffe5d9' : '' }};">
            <td>{{$value->blpay}}  </td>
            <td>{{$value->TMBILL}}  </td>
            <td>{{$value->TMBILDT}}  </td>
            <td >{{$value->Name_Cus}} {{$value->CONTNO}}</td>
            <td align="right">{{ substr($value->PAYFOR,0,1)=="0"? number_format($value->payamt, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->PAYAMT_N, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->PAYAMT_V, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->DISCT, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->PAYINT, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->DSCINT, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->PAYFL, 2) : ''}} </td>
            <td align="right">{{substr($value->PAYFOR,0,1)=="0"? number_format($value->DSCPAYFL, 2) : ''}} </td>
            <td align="right">{{ number_format($value->NETPAY, 2) }} </td>
            <td align="right">{{ $value->PAYFOR }} </td>
          </tr> 
          @endforeach
          <tr style="background: #ffd6ff; border-top: 3px solid #ffd8be; margin-top: 10px;">
            <td>  </td>
            <td>  </td>
            <td>รวมชำระ</td>
            <td align="center"> {{count($dataCut)}} </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                  return $objpay->payamt;
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                  return $objpay->PAYAMT_N;
              }, $dataCut)),2)}} 
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                return $objpay->PAYAMT_V;
              }, $dataCut)),2)}} 
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                return $objpay->DISCT;
              }, $dataCut)),2)}} 
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                return $objpay->PAYINT;
              }, $dataCut)),2)}} 
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                return $objpay->DSCINT;
              }, $dataCut)),2)}} 
            </td>
            <td align="right">
              {{ number_format(array_sum( array_map(function($objpay) {
                return $objpay->PAYFL;
              }, $dataCut)),2)}}
            </td>
            <td align="right"> 
              {{ number_format(array_sum( array_map(function($objpay) {
                  return $objpay->DSCPAYFL;
              }, $dataCut)),2)}} 
            </td>
            <td align="right"> 
              {{ number_format(array_sum( array_map(function($objpay) {
                  return $objpay->NETPAY;
              }, $dataCut)),2)}}
            </td>
            <td></td>
          </tr>
          <tr style="background: #f1ffd6;">
            <td>  </td>
            <td>  </td>
            <td>รวมยกเลิก</td>
            <td align="center"> 
              {{ 
                count(array_filter($dataCut, function($objpay) {
                  return $objpay->flag == "C"; // Condition: number is positive
                }))
              }}
            </td>
            <td align="right">
                {{ number_format(array_sum(array_map(function($objpay) {
                  if ($objpay->flag == "C") {
                    return $objpay->payamt;
                  }
                }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->PAYAMT_N;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->PAYAMT_V;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->DISCT;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->PAYINT;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->DSCINT;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->PAYFL;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right"> 
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->DSCPAYFL;
                }
              }, $dataCut)),2)}}
            </td>
            <td align="right"> 
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "C") {
                  return $objpay->NETPAY;
                }
              }, $dataCut)),2)}}`
            </td>
            <td></td>
          </tr>
          <tr style="background:  #f1ffd6;">
            <td>  </td>
            <td>  </td>
            <td>รวมชำระ</td>
            <td align="center"> 
              {{ 
                count(array_filter($dataCut, function($objpay) {
                  return $objpay->flag == "H"; // Condition: number is positive
                }))
              }}
          </td>
          <td align="right">
              {{ number_format(array_sum(array_map(function($objpay) {
                if ($objpay->flag == "H") {
                  return $objpay->payamt;
                }
              }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->PAYAMT_N;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->PAYAMT_V;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->DISCT;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->PAYINT;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->DSCINT;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right">
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->PAYFL;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right"> 
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->DSCPAYFL;
              }
            }, $dataCut)),2)}}
          </td>
          <td align="right"> 
            {{ number_format(array_sum(array_map(function($objpay) {
              if ($objpay->flag == "H") {
                return $objpay->NETPAY;
              }
            }, $dataCut)),2)}}`
          </td>
            <td>

            </td>
          </tr>
          
    </tbody>
  </table> 
  
</body>
</html>
