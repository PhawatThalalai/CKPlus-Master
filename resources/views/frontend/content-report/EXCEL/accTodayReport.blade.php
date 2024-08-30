<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

$objPHPExcel->getProperties()->setCreator("Poobate Khunthong")
->setLastModifiedBy("Poobate Khunthong")
->setTitle("Office 2007 XLSX ")
->setSubject("Office 2007 XLSX ")
->setDescription("document for Office 2007 XLSX")
->setKeywords("office 2007 openxml php")
->setCategory("result file");

			// Create a first sheet, representing sales data
 $marr = [ 1=>"January",
				2=>"February",
				3=>"March",
				4=>"April",
				5=> "May",
				6=> "June",
				7=> "July",
				8=> "August",
				9=> "September",
				10=> "October",
				11=>"November",
				12=> "December"];

$objPHPExcel->setActiveSheetIndex(0);




$objPHPExcel->getActiveSheet()->setCellValue('A5', 'สาขา/ประเภทลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'จำนวนสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'ผลรวมยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'รวมสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'รวมยอดจัด');







			// Set alignments จัดรูปแบบหน้า ตรงกลางซ้ายขวากึ่งกลาง
			//echo date('H:i:s') . " Set alignments\n";
$objPHPExcel->getActiveSheet()->getStyle('B1:U2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1:U2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1:U2')->getAlignment()->setWrapText(true);
			
$c_status = 0;
$row = 6;
$sumB ="=";
$sumC ="=";
$sumD ="=";
$sumE ="=";



		foreach ($status_cus as $value) {
               # code...
          
              $sum_r = (($row+count($n_branch)));
	         $objPHPExcel->getActiveSheet()->setCellValue('A'.($row), $value->Name_Cus);        
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($row), '=SUM(B'.($row+1).':B'.$sum_r.')');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.($row), '=SUM(C'.($row+1).':C'.$sum_r.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.($row), '=SUM(D'.($row+1).':D'.$sum_r.')');
			$objPHPExcel->getActiveSheet()->setCellValue('E'.($row), '=SUM(E'.($row+1).':E'.$sum_r.')');

			$objPHPExcel->getActiveSheet()->getStyle('A'.($row).':E'.($row))->applyFromArray(
							[
								'font'    => [
									'bold'      => true
                                ],
								'fill' => [
									'fillType'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
									'rotation'   => 90,
									'startcolor' => [
										'argb' => 'FFFF0000'
                                    ],
									'endcolor'   => [
										'argb' => '16FF0E'
									]
								]
							]
						);

			$sumB .='+B'.($row);
			$sumC .='+C'.($row);
			$sumD .='+D'.($row);
			$sumE .='+E'.($row);

          
             $r = 0 ; 
             $total_all = 0;
             $substrY = '';
     
         for($i=0;$i<count($n_branch);$i++){ 
               $sum_R1 = 0;
               $sum_R2 = 0;
               $sum_P1 = 0;
               $sum_P2 = 0;
               $sum_R1Y = 0;
               $sum_R2Y = 0;
               $sum_P1Y = 0;
               $sum_P2Y = 0;

              

               for($i2=1;$i2<3;$i2++){ 
                    $substrY = explode('-', $Fdate);

                $dataP = App\Models\TB_PactContracts\Pact_Contracts::where('Status_Con','<>','cancel')
                    ->when(!empty($Fdate)  && !empty($Tdate) && $i2==1, function($q) use ($Fdate, $Tdate) {                    
						return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$Fdate, $Tdate]);                                
                         })
                   ->when(!empty($Fdate) && $i2==2, function($q) use ($Fdate) {
                       return $q->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM')"), "=",substr($Fdate,0,7) );                        
                    })
                    ->where('BranchSent_Con','=',$n_branch[$i][0])
                    ->where('UserZone',auth()->user()->zone)
                    ->get();
               foreach ($dataP as $res_p ) {
                    if($res_p->ContractToDataCusTags->Type_Customer==$value->Code_Cus){
						if(@$res_p->ContractToDataCusTags->TagToCulculate->Buy_PA == "yes" && @$res_p->ContractToDataCusTags->TagToCulculate->Include_PA == "yes"){
							$cal_pa =  @$calculate->Insurance_PA;
							}else{
								$cal_pa =  0;
							}
                              if(@$res_p->ContractToDataCusTags->TagToCulculate->StatusProcess_Car=='yes'){
                                   $processCar = floatval($res_p->ContractToDataCusTags->TagToCulculate->Process_Car);
                              }else{
                                   $processCar = 0 ;
                              }
                         if($i2==1){
                              $sum_P1++;
                              $sum_P2 = $sum_P2+(floatval($res_p->ContractToDataCusTags->TagToCulculate->Cash_Car)+ $processCar+floatval($cal_pa));
                         }else if($i2==2){
                              $sum_P1Y++;
                              $sum_P2Y = $sum_P2Y+(floatval($res_p->ContractToDataCusTags->TagToCulculate->Cash_Car)+ $processCar+floatval($cal_pa));
                         }
                    }
               }
          }

               $total_num = $sum_R1+$sum_P1;
               $total_top = $sum_R2+$sum_P2;
               $total_numY = $sum_R1Y+$sum_P1Y;
               $total_topY = $sum_R2Y+$sum_P2Y;
               $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $n_branch[$i][1]);        
               $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), $total_num);
               $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), $total_top);
               $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), $total_numY);
               $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), $total_topY);
                $row++;
         }
		 $row=$row+1;
         $c_status++;	
     }
	 		   $objPHPExcel->getActiveSheet()->setCellValue('A'.($row), "TOTAL");        
               $objPHPExcel->getActiveSheet()->setCellValue('B'.($row), $sumB);
               $objPHPExcel->getActiveSheet()->setCellValue('C'.($row),$sumC);
               $objPHPExcel->getActiveSheet()->setCellValue('D'.($row), $sumD);
               $objPHPExcel->getActiveSheet()->setCellValue('E'.($row), $sumE);

// $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->applyFromArray(
// 	array(
// 		'font'    => array(
// 			'bold'      => true
// 		),
		
// 		'borders' => array(
// 			'allborders' => array(
// 				'style' => PHPExcel_Style_Border::BORDER_THIN
// 			)
// 		),
// 		'fill' => array(
// 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
// 			'rotation'   => 90,
// 			'startcolor' => array(
// 				'argb' => 'FFA0A0A0'
// 			),
// 			'endcolor'   => array(
// 				'argb' => 'FFFFFFFF'
// 			)
// 		)
// 	)
// );


						//}
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.($row+1))->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.($row+1))->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.($row+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
$objPHPExcel->getActiveSheet()->getStyle('A3:E'.($row+1))->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('Cash Contract');

$fname = "tmp/Cash Contract.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="PPCUS.xlsx"');
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