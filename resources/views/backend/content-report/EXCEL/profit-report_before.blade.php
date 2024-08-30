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




$objPHPExcel = new  Spreadsheet();

$objPHPExcel->getProperties()->setCreator("Poobate Khunthong")
->setLastModifiedBy("Poobate Khunthong")
->setTitle("Office 2007 XLSX ")
->setSubject("Office 2007 XLSX ")
->setDescription("document for Office 2007 XLSX")
->setKeywords("office 2007 openxml php")
->setCategory("result file");


$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->mergeCells('A1:Y1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานกำไรคงเหลือ (EFF)');
$objPHPExcel->getActiveSheet()->mergeCells('A2:Y2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'ลูกหนี้ ณ. วันที่ 00/00/0000');


    $objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'สาขา');
    $objPHPExcel->getActiveSheet()->mergeCells('C3:D3');
    $objPHPExcel->getActiveSheet()->mergeCells('C4:D4');
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'เลขที่สัญญา');
    $objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'ลูกค้า');
    $objPHPExcel->getActiveSheet()->mergeCells('E4:F4');
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'ชื่อลูกค้า');
    $objPHPExcel->getActiveSheet()->setCellValue('G4', 'รหัสลูกค้า');
    $objPHPExcel->getActiveSheet()->mergeCells('H3:I3');
    $objPHPExcel->getActiveSheet()->setCellValue('H3', 'วันดิว');
    $objPHPExcel->getActiveSheet()->setCellValue('H4', 'วันดิวงวดแรก');
    $objPHPExcel->getActiveSheet()->setCellValue('I4', 'ดิวงวดสุดท้าย');
    $objPHPExcel->getActiveSheet()->mergeCells('J3:K3');
    $objPHPExcel->getActiveSheet()->setCellValue('J3', 'ยอดผ่อน');
    $objPHPExcel->getActiveSheet()->setCellValue('J4', 'ยอดผ่อนชำระ');
    $objPHPExcel->getActiveSheet()->setCellValue('K4', 'ยอดเงินต้น');
    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'จำนวนงวด');
    $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ดอกผลเช่าซื้อ');
    $objPHPExcel->getActiveSheet()->mergeCells('N3:O3');
    $objPHPExcel->getActiveSheet()->setCellValue('N3', 'ถึงดิว');
    $objPHPExcel->getActiveSheet()->setCellValue('N4', 'ลูกหนี้้ถึงดิว');
    $objPHPExcel->getActiveSheet()->setCellValue('O4', 'ดอกผลถีงดิว');
    $objPHPExcel->getActiveSheet()->mergeCells('P3:Q3');
    $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ยอด');
    $objPHPExcel->getActiveSheet()->setCellValue('P4', 'ยอดหักลูกหนี้');
    $objPHPExcel->getActiveSheet()->setCellValue('Q4', 'รับดอกผลแล้ว');
    $objPHPExcel->getActiveSheet()->setCellValue('R3', 'ส่วนลด');
    $objPHPExcel->getActiveSheet()->mergeCells('S3:T3');
    $objPHPExcel->getActiveSheet()->setCellValue('S3', 'รับชำระ');
    $objPHPExcel->getActiveSheet()->setCellValue('S4', 'รับชำระสุทธิ');
    $objPHPExcel->getActiveSheet()->setCellValue('T4', 'ค้างงวด');
    $objPHPExcel->getActiveSheet()->mergeCells('U3:V3');
    $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ค่างวด');
    $objPHPExcel->getActiveSheet()->setCellValue('U4', 'เงินค่างวด');
    $objPHPExcel->getActiveSheet()->setCellValue('V4', 'ดอกผลค้างรับ');
    $objPHPExcel->getActiveSheet()->mergeCells('W3:X3');
    $objPHPExcel->getActiveSheet()->setCellValue('W3', 'ลูกหนี้');
    $objPHPExcel->getActiveSheet()->setCellValue('W4', 'ลูกหนี้คงเหลือ');
    $objPHPExcel->getActiveSheet()->setCellValue('X4', 'เงินต้นคงเหลือ');
    $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'ดอกผลคงเหลือที่ยังไม่ถึงดิว');
    



    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
        
    $row = 4;
    $count = 0;

        for ($i=0; $i < 50; $i++) { 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $count+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), 'KBHQ');
            $objPHPExcel->getActiveSheet()->mergeCells('C'.($row+1).':'.'D'.($row+1));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), 'P08-946464646');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), 'นาย ธรรมมมม กดกดก');
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), '2323223');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), '11/10/2022');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), '11/10/2022');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), '121212000');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), '121212000');
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), '32');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), '0.00');
            $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1), '56.00');
            $objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1), '56.00');
            $objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1), '3200200');
            $objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1), '56.00');
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1), '23232323.00');
            
            $count++;
            $row++;
        }

            $objPHPExcel->getActiveSheet()->mergeCells('A'.($row+1).':'.'Y'.($row+1));
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), 'รายงานการทั้งหมด '.($count).' รายการ');
    // foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
    //         $objPHPExcel->getActiveSheet()
    //                 ->getColumnDimension($col)
    //                 ->setAutoSize(true);
    //     } 
    
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
    $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($default_style);
    // Apply default style to whole sheet
    // $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

    $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
    // $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
    // // Apply title style to titles

    $objPHPExcel->getActiveSheet()->getStyle('A3:'.$last_col.$row)->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('StatusAuditDoc');

$fname = "tmp/profit.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="profit.xlsx"');
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