<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>อ.ส.4ข.</title>

</head>
<style>

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
        border: solid 1px black;
        padding: 2px;
        margin-right: 2px;
        height: 12px;
        width: 8px;
        margin: 1px;
        vertical-align: 7px;

    }
    html { margin: 20px}


    .borderTB  > table,.borderTB  >tr,.borderTB  >td,.borderTB  >th {
            border: 1px solid black;
            border-collapse: collapse;
        }


</style>
<body>
    @php
      @$numCus = count(@$dataCusAll);
      @$numPag = ceil(@$numCus/7)  ;
      @$row = 0;
      $Tax_id =0;
      $branch =0;

      foreach (auth()->user()->UserToCom as $comName){
        if($comName->Company_Type==1){
            $Tax_id = $comName->Company_Id ;
            $branch = $comName->Company_Branch ;
        }
      }
    @endphp
     @for(@$i=0;@$i<@$numPag;@$i++)
     <table border="0" >
         <tr style="font-size: 14pt;line-height: 15px;font-weight: bold" align="bottom">
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
        <table   style="font-size: 14pt;" width="100%">
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

                <tr style="font-size: 14pt;line-height: 15px;" >
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
                <tr style="font-size: 14pt;line-height: 15px;" >
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
                 <tr style="font-size: 14pt;line-height: 15px;" >
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
                 <tr style="font-size: 14pt;line-height: 15px;" >
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
                 <tr style="font-size: 14pt;line-height: 15px;" >
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
                 <tr style="font-size: 14pt;line-height: 15px;" >
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
                 <tr style="font-size: 14pt;line-height: 15px;" >
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

                            <p style="font-size:8pt;top:590px; left :600px; border: solid 1px rgb(0, 0, 0); border-radius: 100%;line-height: 8px;  position:absolute;width:60px; height: 40px; text-align: center;padding-top:20px"><span style="position:absolute; top: 13px; left: 12px;"> ประทับตรา <br>นิติบุคคล <br>  (ถ้ามี)</span> </p>
                              <span style="position: inherit">  ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้เป็นรายการที่ถูกต้องและเป็นจริงทุกประการ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/> <br/>
                                 ลงชื่อ..................................................................................ผู้ขอชำระ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                              </span>
                              <div style="text-align : right;">

                                <div style="position : absolute; right:100px; top : 630px;  width : 200px; text-align : center; important!">{{ @$nameForm }}</div>
                                (................................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>

                                <div style="position : absolute; right:100px; top : 655px;  width : 200px; text-align : center; important!">{{ @$Position }}</div>
                                ตำแหน่ง................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>

                                <div style="position : absolute; right:100px; top : 680px;  width : 200px; text-align : center; important!">{{ formatDateThaiLongPS(@$dateSend) }}</div>
                                ยื่นวันที่................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                             </div>

                              {{-- <span style="position: inherit">  ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้เป็นรายการที่ถูกต้องและเป็นจริงทุกประการ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/> <br/>
                                ลงชื่อ..................................................................................ผู้ขอชำระ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                (................................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                ตำแหน่ง............................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                ยื่นวันที่..............เดือน......................................พ.ศ. ...................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             </span> --}}

                    </td>
                </tr>
            </tbody>
        </table>
    </span>
    @php
     @$row=@$row+7;
    @endphp
 @endfor
</body>

</html>
