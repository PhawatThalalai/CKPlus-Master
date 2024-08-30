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

$objPHPExcel->getActiveSheet()->mergeCells('A1:N2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานสถานะสัญญา '.$marr[(int)substr($Fdate,6,2)].' '.substr($Fdate,0,4));
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'สาขา');
$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'จำนวนสัญญา');
$objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'สนง รับเอกสาร');
$objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
$objPHPExcel->getActiveSheet()->setCellValue('D3', '%รับเอกสาร');
$objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
$objPHPExcel->getActiveSheet()->mergeCells('E3:K3');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'สถานะของสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('E4', 'ส่งเอกสาร');
$objPHPExcel->getActiveSheet()->setCellValue('F4', 'รับเอกสาร');
$objPHPExcel->getActiveSheet()->setCellValue('G4', 'กำลังตรวจสอบ');
$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Rejected');
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'แก้ไขเรียบร้อย');
$objPHPExcel->getActiveSheet()->setCellValue('J4', 'สัญญาสมบูรณ์');
$objPHPExcel->getActiveSheet()->setCellValue('K4', 'เข้าเซฟ');
$objPHPExcel->getActiveSheet()->setCellValue('L3', '%เข้าเซฟ');
$objPHPExcel->getActiveSheet()->mergeCells('L3:L4');
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'จำนวนสัญญา Reject');
$objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'จำนวนสัญญาส่งล่าช้า');
$objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
$objPHPExcel->getActiveSheet()->setCellValue('O3', '%การReject');
$objPHPExcel->getActiveSheet()->mergeCells('O3:O4');

//$objPHPExcel->getActiveSheet()->setCellValue('H1', 'วันอนุมัติ');

$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('############');


$row = 4;
foreach($data as $res){
    
    
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($row + 1), @$res->Name_Branch);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), @$res->numCon);                    
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), @$res->received);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),  '=IFERROR(C'.($row+1).'/B'.($row+1).',0)');
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), @$res->delivered);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), @$res->receivedoff);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), @$res->check_documents);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),  @$res->rejects);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), @$res->edited);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), @$res->complete);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), @$res->Filing);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),  '=IFERROR(K'.($row+1).'/B'.($row+1).',0)');
    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1),  @$res->rejected);
    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),  @$res->rejectedSend);
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),  '=IFERROR((M'.($row+1).'+N'.($row+1).')/B'.($row+1).',0)');
  
    $objPHPExcel->getActiveSheet()->getStyle('D'.($row+1))->getNumberFormat()->setFormatCode('0%');
    $objPHPExcel->getActiveSheet()->getStyle('L'.($row+1))->getNumberFormat()->setFormatCode('0%');
    $objPHPExcel->getActiveSheet()->getStyle('O'.($row+1))->getNumberFormat()->setFormatCode('0%');
    $row++;
}
   

 $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_col.$row)->applyFromArray(
    ['borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
   ]
);  
$default_style = array(
    'font' => array(
        'name' => 'Verdana',
        'color' => array('rgb' => '000000'),
        'size' => 11
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ),
    'borders' => array(
        'allborders' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:N4')->applyFromArray($default_style);

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
$objPHPExcel->getActiveSheet()->setTitle('StatusAudit');


$fname = "tmp/StatusAudit.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="StatusAudit.xlsx"');
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