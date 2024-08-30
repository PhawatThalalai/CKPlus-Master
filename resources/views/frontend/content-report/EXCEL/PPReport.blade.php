<?php
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


$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'วันที่รับลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'สถานะ');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ชื่อลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'เบอร์โทร');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ยอดขอ');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'แหล่งที่มา');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'จำนวนครั้งติดตาม');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'หมายเหตุ');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'delay');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ติดตาม');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'ยกเลิก');
if($Approve>0){
  $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Credo Score'); 
  $objPHPExcel->getActiveSheet()->setCellValue('P1', 'MI Score');   
}

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(45);
//$objPHPExcel->getActiveSheet()->setCellValue('H1', 'วันอนุมัติ');

$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('############');


$row = 1;
foreach($dataCus as $res){


$objPHPExcel->getActiveSheet()->setCellValue('A' . ($row + 1), ParsetoDate(@$res->date_Tag))->getStyle('A' . ($row + 1))
->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
$objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), @$res->Name_Branch);
$statusTag ='';
if(@$res->Status_Tag == 'complete'){
	$statusTag = 'ส่งจัดไฟแนนซ์';

}elseif (@$res->Status_Tag == 'inactive'){
	$statusTag = 'ยกเลิกติดตาม';

}elseif (@$res->Status_Tag == 'active'){
	$statusTag = 'ติดตาม';
}
 $delayTam = 0;
 $tag = '';
 $cancel='';
 $finance ='';
 $dateTag = '';
 $note = '';
    if(count(@$res->TagToTagPart)>0){
        foreach (@$res->TagToTagPart->reverse() as  $value) {
            if( @$value->TagPartToStateTagParts->id == 1){
                $tag = '1';
            }elseif (@$value->TagPartToStateTagParts->id == 3) {
                $finance ='1';
            }else{
                $cancel='1';
            }
            $note .= @$value->date_TrackPart." ".@$value->TagPartToStateTagParts->Name_StatusTag." ".@$value->Detail_TrackPart.",";
            if(@$value->date_TrackPart!=NULL){
                $dateTag = $value->date_TrackPart;

                $date1 = new DateTime($value->date_TrackPart);
                $date2 = new DateTime($dateTag);
                $interval = $date1->diff($date2);
                if( $interval->format("%R%a")>0 ){
                    $delayTam += $interval->format("%R%a");
                }
            }
        }  
    }else{
        $dateTag = $res->date_Tag;
        $dateTagpart = date('Y-m-d');  
        
            $date1 = new DateTime($dateTagpart);
            $date2 = new DateTime($dateTag);
            $interval = $date1->diff($date2);
            if( $interval->format("%R%a")>0 ){
                $delayTam += $interval->format("%R%a");
            }
    }

           
        

// if(@$res->date_TrackPart!=NULL){
//     $date_TrackPart = explode(",",@$res->date_TrackPart);
//     $Duedate_TrackPart = explode(",",@$res->Duedate_TrackPart);
//     $dateTag = '';
//     $dueTag = '';
   
//     for($i=0;$i<count($date_TrackPart);$i++){
//         $dateTag1= explode('/',$date_TrackPart[$i]);
//         $key = count($dateTag1)>0?$dateTag1[1]:'';
//         if(  $key=='1'){
//             $tag = 1;
//             $dueTagSub = explode('/',$Duedate_TrackPart[$i]);
//             $dueTag = count($dueTagSub)>0?$dueTagSub[0]:date('Y-m-d');  

//             $dateTagSub = count($date_TrackPart)-1>$i?explode('/',$date_TrackPart[($i+1)]):[];
//             $dateTag = count($dateTagSub)>0?$dateTagSub[0]:date('Y-m-d');
//         }else{
//             if($key=='2'){
//                 $cancel='1';
//             }else{
//                 $finance ='1';
//             }
//             $dateTag = @$res->date_Tag!=NULL?@$res->date_Tag:date('Y-m-d') ;
//             $dateTagSub = explode('/',$date_TrackPart[$i] );
//             $dueTag = count($dateTagSub)>0?$dateTagSub[0]:date('Y-m-d'); 
//         }

//         if($dueTag <=date('Y-m-d')){
//              $date1 = new DateTime($dueTag);
//             $date2 = new DateTime($dateTag);
//             $interval = $date1->diff($date2);
//             if( $interval->format("%R%a")>0 ){
//                 $delayTam += $interval->format("%R%a");
//             }
//         }
           
            
            
//     }

// }


$objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), @$value->TagPartToStateTagParts->Name_StatusTag);
$objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), @$res->Name_Cus);
$objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), @$res->Phone_cus);
$objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  @$res->Loan_Name);
$objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),  @$res->Cash_Car);
$objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),  @$res->Name_CusResource);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),  count(@$res->TagToTagPart));
$objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),  @$note);
$objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),  @$delayTam);
$objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), @$tag);
$objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), @$cancel);
$objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), @$finance );
if($Approve>0){
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1), @$res->Credo_Score);
    $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), @$res->MI_label);
}
$objPHPExcel->getActiveSheet()->getStyle('J'.($row+1))->getAlignment()->setWrapText(true);
    $row++;
    }

 $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles
// foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
//         $objPHPExcel->getActiveSheet()
//                 ->getColumnDimension($col)
//                 ->setAutoSize(true);
//     } 
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_col.($row+1))->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('PPCustomer');


$fname = "tmp/PPCustomer.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="PPCustomer.xlsx"');
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
