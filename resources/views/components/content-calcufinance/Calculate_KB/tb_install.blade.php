<div class="table-responsive mt-2">
    <table class="table table-sm">
        <thead>
            <tr class="bg-dark text-light">
                <th>ระยะเวลาผ่อน</th>
                <th>ยอดผ่อน NON PA</th>
                <th>แผน</th>
                <th>ยอดผ่อน + PA</th>
                <th>ส่วนต่าง</th>
            </tr>
        </thead>
        <tbody>
            @php

            //if ($request->CodeLoans != NULL && $request->Cash_Car != NULL && $request->Timelack_Car != NULL && $request->Interest_Car != NULL && $request->GetRatePrices !=NULL ) {
                $valPrice = 0;
                $SumInterest= $request->Interest_Car;
                $Type_Customer = $request->Type_Customer;
                $Timelack_Car = $request->Timelack_Car;
                $CodeLoans=$request->CodeLoans;
                $valPrice = floatval($request->Cash_Car) + floatval($request->Process_Car) + floatval($request->Insurance);
                $dataPromotion = explode('/',$request->Promotions);

                if (@$dataPromotion[2]==1) {
        
                  $valinterest = ((( $Timelack_Car- $dataPromotion[1]) * $SumInterest) / $Timelack_Car);
        
                }else{
                  $valinterest = $SumInterest;
                }
        
                // calculate
                $shortLoan = ['08','09','10','18','16'];
                $vatLoan = ['01','05','07'];
               
                if(in_array($CodeLoans,$shortLoan)==false){
                   
                  for ($i = 12; $i <= $request->time_for; $i = $i+6) {
                  
                      if($request->Type_Customer=="CUS-0009"){
                            $i =  $Timelack_Car;
                            $paindex = ceil( $Timelack_Car/12)*12 ;
                            if( $paindex>84){
                                $paindex = 84;
                            }
                        }else{
                            $paindex = $i;
                        }
        
                  $Interest = $valinterest * 12;
                  $NewInterest = ($Interest * ($i / 12)) + 100;
        
                 
        
                    if(in_array($CodeLoans,$vatLoan)==true){ // VAT
                       
                      $TangRatePeriod = ceil((((($valPrice * $NewInterest) / 100) * 1.07) / $Timelack_Car) / 10) * 10;
        
                      $TangRate = $TangRatePeriod*$Timelack_Car;
                     
        
                    }else{ // NO VAT 
                       // dd($valPrice,$NewInterest, $Timelack_Car);
                      $ProcessPR = ((floatval($valPrice) * (floatval($NewInterest) / 100) )) / $Timelack_Car;
                      $payR = ceil($ProcessPR);
                      $PeriodR = ceil($payR / 10) * 10;
                      $TangRate = $PeriodR*$Timelack_Car;
                     
                    }
                   
                    $totalRate = $TangRate;
                    $Installment = 'TimeRack'.$paindex;
                    $timeRack = '';
                    $plan_pa = '';
                    $Limit_Loan = '' ;
                    $id_pa = '';
                    $valTime = '';
        
                    foreach ($dataPA as $itemPA){

                      if( $totalRate < $dataPA[count($dataPA) -1]['Limit_Insur']){
                        if($itemPA['Limit_Insur']>$totalRate ){
                        if(@$dataPromotion[2]==3){
                          $timeRack = ceil( $itemPA[$Installment]-( $itemPA[$Installment]*$dataPromotion[1]) );
                          // timeRack = Math.ceil(plus10/10)*10;
                        }else{
                          $timeRack =  $itemPA[$Installment];
                        }
                        $valTime =  $itemPA[$Installment];
                        $plan_pa =  $itemPA['Plan_Insur'];
                        $Limit_Loan =  $itemPA['Limit_Insur'];
                        $id_pa =  $itemPA['id'];
        
                        break;
                      }
                      }else{
                        if(@$dataPromotion[2]==3){
                          $timeRack = ceil( $dataPA[count($dataPA) -1][$Installment]-($dataPA[count($dataPA) -1][$Installment]*$dataPromotion[1]) );
                          // timeRack = Math.ceil(plus10/10)*10;
                        }else{
                          $timeRack = $dataPA[count($dataPA)-1][$Installment];
                        }   
                        $valTime = $dataPA[count($dataPA)-1][$Installment];              
                        $plan_pa = $dataPA[count($dataPA)-1]['Plan_Insur'];
                        $Limit_Loan = $dataPA[count($dataPA)-1]['Limit_Insur'];
                        $id_pa = $dataPA[count($dataPA)-1]['id'];
                    }
                    }
        
                   //console.log(timeRack);
        
                    // var valPeriod = 0;
                    // var TotalPeriod = 0;
                    // var Profit = 0;
        
        
                              $Period2 = 0;
                            
                              if(in_array($CodeLoans,$vatLoan)==true){// VAT
                                $Period = ceil((((($valPrice * $NewInterest) / 100) * 1.07) / $i) / 10) * 10;
                                //insur
                                $newRate =  floatval($valPrice)+floatval($timeRack);
                                $Period2 = ceil((((($newRate * $NewInterest) / 100) * 1.07) / $i) / 10) * 10;
        
                              }else{ // NO VAT
                                $ProcessP = ((floatval($valPrice) * (floatval($NewInterest) / 100) )) / $i;
                                $pay = ceil($ProcessP);
                                $Period = ceil($pay / 10) * 10;
                                //insur
                                $newRate =  floatval($valPrice)+floatval($timeRack);
                                $ProcessP2 = ((floatval($newRate) * (floatval($NewInterest) / 100) )) / $i;
                                $pay2 = ceil($ProcessP2);
                                $Period2 = ceil($pay2 / 10) * 10;
        
                              }
                              
                              
                              if ($i == $Timelack_Car || $Type_Customer=="CUS-0009" ) {
        
                                if($request->selectPA=="Yes" ){
                                  $valPeriod = $Period2;
                                  $TotalPeriod = $Period2 * $Timelack_Car;
                                  $Profit = $TotalPeriod - $newRate;
        
                                }else{
                                  $valPeriod = $Period;
                                  $TotalPeriod = $Period * $Timelack_Car;
                                  $Profit = $TotalPeriod - $valPrice;
        
                                }
                                if(in_array($CodeLoans,$vatLoan)==true){// VAT
                                  if($request->selectPA=="Yes"){
                                    $Duerate = $Period2 / ((7 / 100) + 1); //ยอด no vat
                                    $Duerate2 = round($Duerate,2) * $Timelack_Car; //ยอดทั้งสัญญา no vat
                                    $Tax = floatval(Period2) - floatval(Duerate); //ภาษีต่องวด
                                    $Tax2 = round($Tax,2) * $Timelack_Car; //ภาษีทั้งสัญญา
        
                                  }else{
                                    $Duerate = $Period / ((7 / 100) + 1); //ยอด no vat
                                    $Duerate2 = round($Duerate,2) * $Timelack_Car; //ยอดทั้งสัญญา no vat
                                    $Tax = floatval($Period) - floatval($Duerate); //ภาษีต่องวด
                                    $Tax2 = round($Tax,2) * $Timelack_Car; //ภาษีทั้งสัญญา
        
                                  }
        
                                    //   $("#Tax_Rate").val(Tax.toFixed(2));
                                    //   $("#Tax2_Rate").val(Tax2.toFixed(2));
                                    //   $("#Duerate_Rate").val(Duerate.toFixed(2));
                                    //   $("#Duerate2_Rate").val(Duerate2.toFixed(2));
        
        
        
                                }else if($CodeLoans=="15"){
                                //   $('#ShowTotalLand').empty();
                                    if($request->selectPA=="Yes"){
                                      $normalPrice = floatval($newRate)+($ProcessP2 * $Timelack_Car);
                                      $splitL = intval($normalPrice / 1000);
                                      $str2 =  strval($splitL);
                                      $last = str2.substr(str2.length - 1);
                                    }else{
                                      $normalPrice = floatval($valPrice)+($ProcessP * $Timelack_Car);
                                      $splitL = intval($normalPrice / 1000);
                                      $str2 = strval($splitL);;
                                      $last = substr($str2,-1);
                                    }
        
                                  if (intval(substr(strval($normalPrice),-4)) < 5001) {
                                    $land_a = $splitL * 1000;
                                    $plus = intval(5000 - ($last * 1000));
                                  } else {
                                    $splitL2 = intval($normalPrice / 10000);
                                    $land_a = $splitL2 * 10000;
                                    $plus = 10000;
                                  }
                                  $landtotal = $land_a + $plus;
                                //   $('#ShowTotalLand').append((landtotal).toLocaleString());
                                //   $("#TotalLand_Rate").val(landtotal);
                                }
                            @endphp
                               <tr class="bg-success bg-gradient p-4">
                                  <td>{{$i}} งวด</td>
                                  <td>{{ strval($Period)}} บาท</td>
                                  <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}" > {{ $plan_pa }} ทุน {{ $Limit_Loan }} บาท </td>
                                  <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}"> {{ number_format($Period2,2) }} บาท </td>
                                   <td class="{{$request->buyPA ==  'Yes' ? '' : 'd-none'}}"> {{number_format(floatval($Period2)-floatval($Period),2)}} บาท</td>
                                </tr>
                            @php  
                                // if(buyPA=='Yes'){
                                //   $('#Insurance_PA').val(timeRack);
                                //   $('#Plan_PA').val(id_pa);
                                //   $('#Plan_Limit').val(plan_pa+' ทุน '+(Limit_Loan).toLocaleString());
        
                                //   $('.showPlan_PA').append(plan_pa);
                                //   $('.capital_PA').append((Limit_Loan).toLocaleString()+"  บาท");
                                //   $('.periodPA').append(Math.ceil(Timelack_Car/12 ));
                                //   $('.periodPAtotal').append((valTime).toLocaleString()+"  บาท" );
                                //   $('.viewPA').show();
                                 
                                // }else{
                                //   $('#Insurance_PA').val(0);
                                //   $('#Plan_PA').val('');
                                //   $('#Plan_Limit').val('');
                                //   $('.viewPA').hide();
                                // }
        
                              }else{
                        @endphp
                                <tr >
                                  <td>{{$i}} งวด</td>
                                  <td>{{ strval($Period)}} บาท</td>
                                  <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}" > {{ $plan_pa }} ทุน {{ $Limit_Loan }} บาท </td>
                                  <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}"> {{ number_format($Period2,2) }} บาท </td>
                                   <td class="{{$request->buyPA ==  'Yes' ? '' : 'd-none'}}"> {{number_format(floatval($Period2)-floatval($Period),2)}} บาท</td>
                                </tr>
                        @php
                              }
        
                            //   $('#tableBody').append(textdata);
        
                  }
                  
                }else{
                 
                 $Interest1 = $valinterest * 12;
                 $ProcessP1 = (($valPrice * floatval($Interest1) / 100) * ($Timelack_Car / 12)) / $Timelack_Car;
                 $pay1 = ceil($ProcessP1);
                 $Period1 = ceil($pay1 / 10) * 10;
                 $valPeriod1 = $Period1;
                 $TotalPeriod1 = floatval($valPrice)+($Period1 * $Timelack_Car);
                 $Profit1 = $TotalPeriod1 - $valPrice;
                 $totalRate1 = $TotalPeriod1;
        
                  $Installment = 'TimeRack'.$Timelack_Car;
                  foreach ($dataPA as $itemPA){
                      if($totalRate1< $dataPA [count($dataPA )-1]['Limit_Insur']){
                        if( $itemPA['Limit_Insur'] > $totalRate1 ){
                        if(@$dataPromotion[2]==3){
                          $timeRack = ceil($itemPA[$Installment]-($itemPA[$Installment]*$dataPromotion[1]) );
                          // timeRack = Math.ceil(plus10/10)*10;
                        }else{
                          $timeRack = $itemPA[$Installment];
                        }   
                        $valTime = $itemPA[$Installment];              
                        $plan_pa = $itemPA['Plan_Insur'];
                        $Limit_Loan = $itemPA['Limit_Insur'];
                        $id_pa = $itemPA['id'];
        
                        break;
                      }
                      }else{
                        if(@$dataPromotion[2]==3){
                          $timeRack = ceil( $dataPA [count($dataPA )-1][$Installment]-( $dataPA [count($dataPA )-1][$Installment]*$dataPromotion[1]) );
                          // timeRack = Math.ceil(plus10/10)*10;
                        }else{
                          $timeRack =  $dataPA [count($dataPA )-1][$Installment];
                        }   
                        $valTime =  $dataPA [count($dataPA )-1][$Installment];              
                        $plan_pa =  $dataPA [count($dataPA )-1]['Plan_Insur'];
                        $Limit_Loan =  $dataPA [count($dataPA )-1]['Limit_Insur'];
                        $id_pa =  $dataPA [count($dataPA )-1]['id'];
                    }
                    }
        
        
                  $Period2 = 0;
                  $Interest = $valinterest * 12;
        
                  $ProcessP = (($valPrice * floatval($Interest) / 100) * ($Timelack_Car / 12)) / $Timelack_Car;
                  $pay = ceil($ProcessP);
                  $Period = ceil($pay / 10) * 10;
                  //insure
                  $ProcessP2 = (((floatval($valPrice)+floatval($timeRack)) * floatval($Interest) / 100) * ($Timelack_Car / 12)) / $Timelack_Car;
                  $pay2 = ceil($ProcessP2);
                  $Period2 = ceil($pay2 / 10) * 10;
                    
                  if($request->selectPA=="Yes"){      
                    $valPeriod = $Period2;
                    $TotalPeriod = (floatval($valPrice)+floatval($timeRack))+($Period2 * $Timelack_Car);
                    $Profit = $TotalPeriod - (floatval($valPrice)+floatval($timeRack));
                    $totalRate = $TotalPeriod;
                   
                  }else{
                    $valPeriod = $Period;
                    $TotalPeriod = floatval($valPrice)+($Period * $Timelack_Car);
                    $Profit = $TotalPeriod - $valPrice;
                    $totalRate = $TotalPeriod;
                  }
                //   if(buyPA=='Yes'){
                //     $('#Insurance_PA').val(timeRack);
                //     $('#Plan_PA').val(id_pa);
                //     $('#Plan_Limit').val(plan_pa+' ทุน '+(Limit_Loan).toLocaleString());
        
                //     $('.showPlan_PA').append(plan_pa);
                //     $('.capital_PA').append((Limit_Loan).toLocaleString() +"  บาท");
                //     $('.periodPA').append(Math.ceil(Timelack_Car/12 ));
                //     $('.periodPAtotal').append((valTime).toLocaleString() +"  บาท");
                //     $('.viewPA').show();
                    
                //     }else{
                //       $('#Insurance_PA').val(0);
                //       $('#Plan_PA').val('');
                //       $('#Plan_Limit').val('');
                //       $('.viewPA').hide();
                //     }
                @endphp
                        <tr class="">
                            <td>{{$i}} งวด</td>
                            <td>{{ strval($Period)}} บาท</td>
                            <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}" > {{ $plan_pa }} ทุน {{ $Limit_Loan }} บาท </td>
                            <td class="{{$request->buyPA == 'Yes' ? '' : 'd-none'}}"> {{ number_format($Period2,2) }} บาท </td>
                            <td class="{{$request->buyPA ==  'Yes' ? '' : 'd-none'}}"> {{number_format(floatval($Period2)-floatval($Period),2)}} บาท</td>
                        </tr>
               @php                   
                //   if(CodeLoans=='16'){
                //     $('#ShowTotalLand').empty();
                //       if(selectPA=="Yes"){
                //         var normalPrice = (floatval(valPrice)+floatval(timeRack))+(ProcessP * Timelack_Car);
                //       }else{
                //         var normalPrice = floatval(valPrice)+(ProcessP * Timelack_Car);
                //       }
        
                //       var land_a = Math.ceil(normalPrice / 100) * 100;
        
                //         if (intval(land_a.toString().substr(-3)) - 100 > 0) {
                //           landtotal = land_a - 100;
                //         } else {
                //           landtotal = land_a;
                //         }
                //         $('#ShowTotalLand').append((landtotal).toLocaleString());
                //         $("#TotalLand_Rate").val(landtotal);
                //   }else if(CodeLoans=="18"){
                //         $('#ShowTotalLand').empty();
                //         if(selectPA=="Yes"){
                //           var normalPrice = (floatval(valPrice)+floatval(timeRack))+(ProcessP * Timelack_Car);
                //         }else{
                //           var normalPrice = floatval(valPrice)+(ProcessP * Timelack_Car);
                //         }
        
                //         var splitL = intval(normalPrice / 1000);
                //         var str2 = splitL.toString();
                //         var last = str2.substr(str2.length - 1);
        
                //         if (intval(normalPrice.toString().substr(-4)) < 5001) {
                //           var land_a = splitL * 1000;
                //           var plus = intval(5000 - (last * 1000));
                //         } else {
                //           var splitL2 = intval(normalPrice / 10000);
                //           var land_a = splitL2 * 10000;
                //           var plus = 10000;
                //         }
                //         landtotal = land_a + plus;
                //         $('#ShowTotalLand').append((landtotal).toLocaleString());
                //         $("#TotalLand_Rate").val(landtotal);
                //       }
                }
        
                // $("#Profit_Rate").val(Profit);
                // $('#ShowPeriod').append((valPeriod).toLocaleString());
                // $('#ShowTotalPeriod').append((TotalPeriod).toLocaleString());
                // $('#Percent_Car').val(Percent_Car.toFixed(0));
        
                // $("#Period_Rate").val(valPeriod);
                // $("#TotalPeriod_Rate").val(TotalPeriod);
                // $("#InterestYear_Car").val(floatval(Interest).toFixed(3));
                // $("#totalInterest_Car").val(SumInterest.toFixed(2));
                // $("#save").removeAttr('disabled');
            //  }
              @endphp
          
        </tbody>
    </table>
</div>