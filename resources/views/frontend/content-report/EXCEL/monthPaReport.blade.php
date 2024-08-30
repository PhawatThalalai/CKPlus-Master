<?php

$origin = new DateTime($Fdate);
$target = new DateTime($Tdate);
$interval = $origin->diff($target);
$date_diff =$interval->format('%a');
$date_start = explode('-',$Fdate);
$date_stop = explode('-',$Tdate);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

    $marr[1] = "January";
    $marr[2] = "February";
    $marr[3] = "March";
    $marr[4] = "April";
    $marr[5] = "May";
    $marr[6] = "June";
    $marr[7] = "July";
    $marr[8] = "August";
    $marr[9] = "September";
    $marr[10] = "October";
    $marr[11] = "November";
    $marr[12] = "December";
    


$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$objPHPExcel->getProperties()->setCreator("Poobate Khunthong")
                             ->setLastModifiedBy("Poobate Khunthong")
                             ->setTitle("Office 2007 XLSX ")
                             ->setSubject("Office 2007 XLSX ")
                             ->setDescription("document for Office 2007 XLSX")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("result file");


$zone[10]='ปัตตานี';
$zone[20]='หาดใหญ่';
$zone[30]='นครศรีธรรมราช';
$zone[40]='กระบี่';
$zone[50]='สุราษฎร์ธานี';

$zoneid[1]='10';
$zoneid[2]='20';
$zoneid[3]='30';
$zoneid[4]='40';
$zoneid[5]='50';

$head[]= 'AREA';
$head[]= 'จัดไฟแนนซ์';
$head[]= 'จัดไฟแนนซ์+PA';
$head[]= '%การจัด';
$head[]= 'ยอดPA ขาย';
// $head[]= 'จัดไฟแนนซ์';
// $head[]= 'จัดไฟแนนซ์+PA';
// $head[]= 'ยอดPA ขาย';
// $head[]= 'ยอดPA ซื้อ';

 $m1 = date_format($origin,"n");
 $m2 = date_format($origin,"m");

$objPHPExcel->setActiveSheetIndex(0);

$c_column = (($date_diff+1)*5);

 

$row = 3;
$c1 = 2;
$m=0;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),$row,$head[0]);  
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+1),$zone[10]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+2),$zone[20]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+3),$zone[30]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+4),$zone[40]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+5),$zone[50]);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+6),'Total');
//$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($i-3),2,($i-1),2);
for($i=3;$i<($c_column+1);$i++){

      $today = sprintf("%02d",(intval($date_start[2])+$m)).'-'.$date_start[1].'-'.$date_start[0];
      $y_m = $date_start[0].'-'.sprintf("%02d",($m1+$m));

    for($h=1;$h<count($head);$h++){

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i),$row,$head[$h]);    
             $i++;
        }
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($i-4),2,($i-1),2);
       
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-4),2,$today);

        
        $d4=1; //DATE_FORMAT(date_create, '%Y-%m-%d') between '".$datefrom."' AND '".$dateto."' AND 
                
                $AllZone = DB::select("SELECT a.UserZone , 
                                   count(a.UserZone) as CountCaseToday,
                                    SUM(Case When  b.Buy_PA = 'Yes' then 1 else 0 end) as CountPAToday,
                                    SUM(Case When  b.Buy_PA = 'Yes' then b.Insurance_PA else 0 end) as sumCaseToday
                                    from Pact_Contracts a
                                    left join Data_CusTagCalculates b on a.DataTag_id = b.DataTag_id
                                    left join TB_InsurancePA c on c.id = b.Plan_PA
                                    where FORMAT (cast(a.Date_monetary as date), 'dd-MM-yyyy')='".$today."' group by a.UserZone");
                
            
                $i2=0;
				$res2 =array();  
                 foreach( $AllZone as $data){  
                                                              
                        $b = array();
                  
                            $b[] = $data->CountCaseToday;
                            $b[] = $data->CountPAToday;
                            $b[] = $data->sumCaseToday;
                            $b[] = 0;
                            $res2[$data->UserZone] = $b;
                        
						
                    }
                      
                for($uz=1;$uz<=count($zoneid);$uz++){
                        if(@$res2[$zoneid[$uz]]!=NULL){                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-4)),($row+$d4), $res2[$zoneid[$uz]][0]);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-3)),($row+$d4), $res2[$zoneid[$uz]][1]);
                            $Col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-4)),($row+$d4))->getColumn();
                            $Col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-3)),($row+$d4))->getColumn();
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), "=IFERROR(".($Col3.($row+$d4))."/".$Col4.($row+$d4).",0)" );
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), $res2[$zoneid[$uz]][2]);
                          
                            $Col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-2)),($row+$d4))->getColumn();
                            $objPHPExcel->getActiveSheet()->getStyle($Col2.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                           
                        }else{
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-4)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-3)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), 0);
                            
                            
                        } 
                       
                     $d4++;   
                }

                    for($c=1;$c<5;$c++){
                        $Col = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-(5-$c)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-(5-$c)),($row+$d4),'=SUM('.$Col.'4:'.$Col.'8)');
                        $Col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-2)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->getStyle($Col2.($row+$d4))->getNumberFormat()->setFormatCode('0%');

                        $Col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-4)),($row+$d4))->getColumn();
                        $Col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-3)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), "=IFERROR(".($Col3.($row+$d4))."/".$Col4.($row+$d4).",0)" );
                    }
                    
                    // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-4)),($row+$d4), 'Total');
                    // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-3)),($row+$d4), 'Total');
                    // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), 'Total');
                    // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), 'Total');
                    // for($c=1;$c<8;$c++){
                    //     $Col = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-(9-$c)),($row+$d4))->getColumn();
                    //     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-(9-$c)),($row+$d4),'=SUM('.$Col.'4:'.$Col.'8)');
                    // }
                    //     $total_col1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-5),($row+$d4))->getColumn();
                    //     $total_col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-7)),($row+$d4))->getColumn();
                    //     $total_col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-2)),($row+$d4))->getColumn();
                    //     $total_col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-3)),($row+$d4))->getColumn();
                    //     $total_col5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-1)),($row+$d4))->getColumn();
                    //     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), '=IFERROR('.$total_col1.($row+$d4).'/'.$total_col2.($row+$d4).',0)');
                    //     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), '=IFERROR('.$total_col4.($row+$d4).'/'.$total_col2.($row+$d4).',0)');
                    //     $objPHPExcel->getActiveSheet()->getStyle($total_col3.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                    //     $objPHPExcel->getActiveSheet()->getStyle($total_col5.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                   
                  
        
     $i=$i-1;
    $m++;   
        
}
//total
 $t_column = ($c_column+3);

 for($h=1;$h<count($head);$h++){

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column),$row,$head[$h]);    
             $t_column++;
        }
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($t_column-4),2,($t_column-1),2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column-4),2,$marr[intval($date_start[1])].'-'.$date_start[0]);

        $d4=1; //DATE_FORMAT(date_create, '%Y-%m-%d') between '".$datefrom."' AND '".$dateto."' AND 
                 $AllZoneM = DB::select("SELECT a.UserZone , 
                                   count(a.UserZone) as CountCaseToday,
                                    SUM(Case When  b.Buy_PA = 'Yes' then 1 else 0 end) as CountPAToday,
                                    SUM(Case When  b.Buy_PA = 'Yes' then b.Insurance_PA else 0 end) as sumCaseToday
                                    from Pact_Contracts a
                                    left join Data_CusTagCalculates b on a.DataTag_id = b.DataTag_id
                                    left join TB_InsurancePA c on c.id = b.Plan_PA
                                    where FORMAT (cast(a.Date_monetary as date), 'MM-yyyy')='".$date_start[1].'-'.$date_start[0]."' group by a.UserZone");
                

                
				$res3 =array();  
                 foreach( $AllZoneM as $data){  
                                                              
                        $b = array();
                  
                            $b[] = $data->CountCaseToday;
                            $b[] = $data->CountPAToday;
                            $b[] = $data->sumCaseToday;
                            $b[] = 0;
                            $res3[$data->UserZone] = $b;
                        
						
                    }
                      
                for($uz=1;$uz<=count($zoneid);$uz++){
                        if(@$res3[$zoneid[$uz]]!=NULL){                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-4)),($row+$d4), $res3[$zoneid[$uz]][0]);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-3)),($row+$d4), $res3[$zoneid[$uz]][1]);
                            $Col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-4)),($row+$d4))->getColumn();
                            $Col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-3)),($row+$d4))->getColumn();
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-2)),($row+$d4),"=IFERROR(".($Col3.($row+$d4))."/".$Col4.($row+$d4).",0)" );
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-1)),($row+$d4),  $res3[$zoneid[$uz]][2]);
                          
                            $Col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-2)),($row+$d4))->getColumn();
                            $objPHPExcel->getActiveSheet()->getStyle($Col2.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                        
                           
                        }else{
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-4)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-3)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-2)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-1)),($row+$d4), 0);
                            
                            
                        } 
                       
                     $d4++;   
                }
                for($c=1;$c<5;$c++){
                        $Col = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($t_column-(5-$c)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column-(5-$c)),($row+$d4),'=SUM('.$Col.'4:'.$Col.'8)');
                      
                        $Col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-2)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->getStyle($Col2.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                        $Col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-4)),($row+$d4))->getColumn();
                        $Col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($t_column-3)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-2)),($row+$d4),"=IFERROR(".($Col3.($row+$d4))."/".$Col4.($row+$d4).",0)" );
                } 


$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.'3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.'3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// Apply title style to titles

$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.$t_column)->applyFromArray(
    ['borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]
        );  

                
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75); // กำหนดระยะขอบ บน
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25); // กำหนดระยะขอบ ขวา
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25); // กำหนดระยะขอบ ซ้าย
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75); // กำหนดระยะขอบ ล่าง
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Zone');



$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);
$head[]= 'AREA';
$head[]= 'จัดไฟแนนซ์';
$head[]= 'จัดไฟแนนซ์+PA';
$head[]= 'ยอดPA ขาย';
$head[]= 'ยอดPA ซื้อ';
$head[]= 'จัดไฟแนนซ์';
$head[]= 'จัดไฟแนนซ์+PA';
$head[]= 'ยอดPA ขาย';
$head[]= 'ยอดPA ซื้อ';
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', $marr[intval(substr($Tdate,5,2))].' - '.substr($Tdate,0,4));
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'จัดไฟแนนซ์+PA');
$objPHPExcel->getActiveSheet()->setCellValue('D2', '% การจัด');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'ยอดPA ขาย');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'จัดไฟแนนซ์+PA');
$objPHPExcel->getActiveSheet()->setCellValue('H2', '% การจัด');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'ยอดPA ขาย');

$credoBranch = DB::select("SELECT d.Name_Branch , 
                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM-dd') = FORMAT (cast(GETDATE() as date), 'yyyy-MM-dd')  then 1 else 0 end) as CountCaseToday,
                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM-dd') = FORMAT (cast(GETDATE() as date), 'yyyy-MM-dd') and b.Buy_PA = 'Yes' then 1 else 0 end) as CountPAToday,
                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM-dd') = FORMAT (cast(GETDATE() as date), 'yyyy-MM-dd') and b.Buy_PA = 'Yes' then b.Insurance_PA else 0 end) as sumCaseToday,

                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM') = '".$date_stop[0].'-'.$date_stop[1]."'  then 1 else 0 end) as CountCaseMonth,
                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM') = '".$date_stop[0].'-'.$date_stop[1]."' and b.Buy_PA = 'Yes' then 1 else 0 end) as CountPAMonth,
                            SUM(Case When FORMAT (cast( a.Date_monetary as date), 'yyyy-MM') = '".$date_stop[0].'-'.$date_stop[1]."' and b.Buy_PA = 'Yes' then b.Insurance_PA else 0 end) as sunCaseMonth

                            from Pact_Contracts a
                            left join Data_CusTagCalculates b on a.DataTag_id = b.DataTag_id
                            left join TB_InsurancePA c on c.id = b.Plan_PA
                            left join TB_Branchs d on a.UserBranch = d.id
                            where FORMAT (cast(a.Date_monetary as date), 'yyyy-MM')='".$date_stop[0].'-'.$date_stop[1]."' and a.UserZone ='".auth()->user()->zone."'   
                            group by d.Name_Branch order by sunCaseMonth DESC");
                            
$Brow = 2;
        foreach( $credoBranch as $data){  
           
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($Brow+1),  $data->Name_Branch);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($Brow+1),  $data->CountCaseToday);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($Brow+1), $data->CountPAToday);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($Brow+1), "=IFERROR(C".($Brow+1)."/B".($Brow+1).",0)");
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($Brow+1), $data->sumCaseToday);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($Brow+1), $data->CountCaseMonth);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($Brow+1), $data->CountPAMonth);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($Brow+1), "=IFERROR(G".($Brow+1)."/F".($Brow+1).",0)");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($Brow+1), $data->sunCaseMonth);
            $objPHPExcel->getActiveSheet()->getStyle('D'.($Brow+1))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->getStyle('H'.($Brow+1))->getNumberFormat()->setFormatCode('0%');
            $Brow++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.($Brow+1),  "TOTAL");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($Brow+1), "=SUM(B3:B".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($Brow+1), "=SUM(C3:C".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($Brow+1),  "=IFERROR(C".($Brow+1)."/B".($Brow+1).",0)");
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($Brow+1), "=SUM(E3:E".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($Brow+1), "=SUM(F3:F".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($Brow+1), "=SUM(G3:G".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($Brow+1),  "=IFERROR(G".($Brow+1)."/F".($Brow+1).",0)");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($Brow+1), "=SUM(I3:I".($Brow).")");

            $objPHPExcel->getActiveSheet()->getStyle('D'.($Brow+1))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->getStyle('H'.($Brow+1))->getNumberFormat()->setFormatCode('0%');


$objPHPExcel->getActiveSheet()->getStyle('A1:I'.($Brow+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.($Brow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($Brow+1))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.($Brow+1))->applyFromArray(
        ['borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ]
        );  

                
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75); // กำหนดระยะขอบ บน
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25); // กำหนดระยะขอบ ขวา
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25); // กำหนดระยะขอบ ซ้าย
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75); // กำหนดระยะขอบ ล่าง
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Branch');

$fname = "tmp/PAReport.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="PAReport.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
for ($i = 0; $i < ob_get_level(); $i++) {
   ob_end_flush();
}
ob_implicit_flush(1);
ob_clean();
$xlsxWriter->save($fname);

exit($xlsxWriter->save('php://output'));

?>