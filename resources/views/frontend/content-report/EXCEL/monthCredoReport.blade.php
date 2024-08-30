<?php

$origin = new DateTime($Fdate);
$target = new DateTime($Tdate);
$interval = $origin->diff($target);
$date_diff =$interval->format('%m');
$date_start = explode('-',$Fdate);

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
$head[]= 'รายการลูกค้า';
$head[]= 'จัดไฟแนนซ์';
$head[]= 'มีscoreไม่ส่งจัด';
$head[]= 'มีscore';
$head[]= 'ไม่มี score';
$head[]= 'ใช้ Score คำนวณ';
$head[]= 'Score / จัดไฟแนนซ์';
$head[]= 'Score คำนวณ / จัดไฟแนนซ์';

 $m1 = date_format($origin,"n");
 $m2 = date_format($origin,"m");

$objPHPExcel->setActiveSheetIndex(0);

$c_column = (($date_diff+1)*6);

 

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

      $month_year = $marr[($m1+$m)].'-'.$date_start[0];
      $y_m = $date_start[0].'-'.sprintf("%02d",($m1+$m));

    for($h=1;$h<count($head);$h++){

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i),$row,$head[$h]);    
             $i++;
        }
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($i-7),2,($i-1),2);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-7),2,$month_year);

        
        $d4=1; //DATE_FORMAT(date_create, '%Y-%m-%d') between '".$datefrom."' AND '".$dateto."' AND 
                
                $AllZone = DB::select("SELECT c.UserZone,count(c.Code_Tag)as tag,count(a.Contract_Con) as con,
                     SUM(Case When c.Credo_Score>0 AND c.Status_Tag<>'complete' then 1 else 0 end) as more0nc,
                     SUM(Case When c.Credo_Score>0 AND c.Status_Tag='complete' then 1 else 0 end) as more0c,
                     SUM(Case When (c.Credo_Score=0 or c.Credo_Score is NULL) AND c.Status_Tag='complete'  then 1 else 0 end) as less0c,
		            SUM(Case When e.Note_Credo is not NULL AND e.Note_Credo='ใช้ Score คำนวณ' then 1 else 0 end) as noteCount
                     
                     from Data_CusTags c 
                     left join Pact_Contracts a on a.DataTag_id= c.id
                     left join TB_Branchs d on d.id = c.UserBranch
                     left join Data_CusTagCalculates e on e.DataTag_id= c.id
                     where FORMAT (cast(c.date_Tag as date), 'yyyy-MM')='".$y_m."' group by c.UserZone order by c.UserZone");
                

                 foreach( $AllZone as $data){  
                    for($uz=1;$uz<=count($zoneid);$uz++){
                        if($zoneid[$uz] == $data->UserZone){                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-8)),($row+$d4), $data->tag);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-7)),($row+$d4), $data->con);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-6)),($row+$d4), $data->more0nc);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-5)),($row+$d4), $data->more0c);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-4)),($row+$d4), $data->less0c);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-3)),($row+$d4), $data->noteCount);
                            $per_col1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-5),($row+$d4))->getColumn();
                            $per_col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-7)),($row+$d4))->getColumn();
                            $per_col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-2)),($row+$d4))->getColumn();
                            $per_col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-3)),($row+$d4))->getColumn();
                            $per_col5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-1)),($row+$d4))->getColumn();
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), '=IFERROR('.$per_col1.($row+$d4).'/'.$per_col2.($row+$d4).',0)');
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), '=IFERROR('.$per_col4.($row+$d4).'/'.$per_col2.($row+$d4).',0)');
                            
                            $objPHPExcel->getActiveSheet()->getStyle($per_col3.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                            $objPHPExcel->getActiveSheet()->getStyle($per_col5.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                            $d4++;
                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-8)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-7)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-6)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-5)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-4)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-3)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), 0);
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), 0);
                        } 
                    }
                }
                
                    for($c=1;$c<8;$c++){
                        $Col = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-(9-$c)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-(9-$c)),($row+$d4),'=SUM('.$Col.'4:'.$Col.'8)');
                    }
                        $total_col1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($i-5),($row+$d4))->getColumn();
                        $total_col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-7)),($row+$d4))->getColumn();
                        $total_col3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-2)),($row+$d4))->getColumn();
                        $total_col4 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-3)),($row+$d4))->getColumn();
                        $total_col5 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow((($i-1)),($row+$d4))->getColumn();
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-2)),($row+$d4), '=IFERROR('.$total_col1.($row+$d4).'/'.$total_col2.($row+$d4).',0)');
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($i-1)),($row+$d4), '=IFERROR('.$total_col4.($row+$d4).'/'.$total_col2.($row+$d4).',0)');
                        $objPHPExcel->getActiveSheet()->getStyle($total_col3.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                        $objPHPExcel->getActiveSheet()->getStyle($total_col5.($row+$d4))->getNumberFormat()->setFormatCode('0%');
                   
                  
        
     $i=$i-1;
    $m++;   
        
}
// //total
//  $t_column = ($c_column+4);

//  for($h=1;$h<count($head);$h++){

//             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column),$row,$head[$h]);    
//              $t_column++;
//         }
//         $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($t_column-3),2,($t_column-1),2);
//         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column-3),2,'TOTAL');

//         $d4=1; //DATE_FORMAT(date_create, '%Y-%m-%d') between '".$datefrom."' AND '".$dateto."' AND 
//                 for($i2=1;$i2<6;$i2++){
//                      $sql = "SELECT COUNT(IF(score='0',1,NULL))AS score1,COUNT(IF(score>0,1,NULL))AS score2,COUNT(IF(flag='yes',1,NULL)) AS c_flag ,zone,DATE_FORMAT(date_input, '%Y-%m-%d')as date1  FROM tb_credo_cus 
//                         WHERE zone = '".$i2."'  GROUP BY zone";
//                         $result = mysql_query($sql) or die(mysql_rerror());
//                         $rs = mysql_fetch_array($result);
//                         $row_data = mysql_num_rows($result);

//                     //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column-4),($row+$d4),$zone[$i2]);
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-3)),($row+$d4),$rs['score1']);
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-2)),($row+$d4),$rs['score2']);
                  
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((($t_column-1)),($row+$d4),$rs['c_flag']);
                        
//                         $d4++;

//                     }
//                  $sumT_col1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($t_column-3),($row+$d4))->getColumn();
//                     $sumT_col2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($t_column-2),($row+$d4))->getColumn();
//                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($t_column-2),($row+$d4),'=SUM('.$sumT_col1.'4:'.$sumT_col2.'8)');



$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.'3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.'3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// Apply title style to titles

$objPHPExcel->getActiveSheet()->getStyle('B2:'.$last_col.'9')->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('Month');



$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', $marr[intval(substr($Tdate,5,2))].' - '.substr($Tdate,0,4));
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'รายการลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'มีscoreไม่ส่งจัด');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'มีscore');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'ไม่มี score');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'ใช้ Score คำนวณ');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Score / จัดไฟแนนซ์');

$credoBranch = DB::select("SELECT d.Name_Branch,count(c.Code_Tag)as tag,count(a.Contract_Con) as con,
            SUM(Case When c.Credo_Score>0 AND c.Status_Tag<>'complete' then 1 else 0 end) as more0nc,
            SUM(Case When c.Credo_Score>0 AND c.Status_Tag='complete' then 1 else 0 end) as more0c,
            SUM(Case When (c.Credo_Score=0 or c.Credo_Score is NULL) AND c.Status_Tag='complete'  then 1 else 0 end) as less0c,
		    SUM(Case When e.Note_Credo is not NULL AND e.Note_Credo='ใช้ Score คำนวณ' then 1 else 0 end) as noteCount
            from Data_CusTags c 
            left join Pact_Contracts a on a.DataTag_id= c.id
            left join TB_Branchs d on d.id = c.UserBranch
            left join Data_CusTagCalculates e on e.DataTag_id= c.id
            where FORMAT (cast(c.date_Tag as date), 'yyyy-MM')='".substr($Tdate,0,7)."' and c.UserZone='".auth()->user()->zone."' group by d.Name_Branch");
                            
$Brow = 2;
        foreach( $credoBranch as $data){  
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($Brow+1),  $data->Name_Branch);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($Brow+1), $data->tag);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($Brow+1), $data->con);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($Brow+1), $data->more0nc);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($Brow+1), $data->more0c);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($Brow+1), $data->less0c);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($Brow+1), $data->noteCount);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($Brow+1), '=IFERROR(E'.($Brow+1).'/C'.($Brow+1).',0)');
            $Brow++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.($Brow+1),  "TOTAL");
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($Brow+1), "=SUM(B3:B".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($Brow+1), "=SUM(C3:C".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($Brow+1), "=SUM(D3:D".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($Brow+1), "=SUM(E3:E".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($Brow+1), "=SUM(F3:F".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($Brow+1), "=SUM(G3:G".($Brow).")");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($Brow+1), '=IFERROR(E'.($Brow+1).'/C'.($Brow+1).',0)');


$objPHPExcel->getActiveSheet()->getStyle('H3:H'.($Brow+1))->getNumberFormat()->setFormatCode('0%');

$objPHPExcel->getActiveSheet()->getStyle('A1:H'.($Brow+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.($Brow+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($Brow+1))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.($Brow+1))->applyFromArray(
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

$fname = "tmp/CredoReport.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="CredoReport.xlsx"');
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