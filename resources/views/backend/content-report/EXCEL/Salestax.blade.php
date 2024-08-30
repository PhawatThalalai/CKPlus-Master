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
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานภาษีขาย (ปกติ)');
$objPHPExcel->getActiveSheet()->mergeCells('A2:Y2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'ระหว่างวันที่ '.formatDateThaiShort_monthNum(@$Fdate).' ถึงวันที่ '.formatDateThaiShort_monthNum(@$Tdate));

    $objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'สาขา');
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'เลขที่');
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('D3', 'วันที่');
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'เลขที่สัญญา');
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('F3', 'รหัสลูกค้า');
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'คำนำหน้าชื่อ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('H3', 'ชื่อ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
    $objPHPExcel->getActiveSheet()->setCellValue('I3', 'นามสกุล');
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('J3', 'เลขประจำตัวผู้เสียภาษี');
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('K3', 'เลขตัวถัง');
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'มูลค่า');
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('M3', 'อัตราภาษี');
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('N3', 'ภาษี');
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('O3', 'รวมภาษี');
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('P3', 'วันยกเลืก');
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'ประเภทใบกำกับ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('R3', 'สถานะ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('S3', 'รายการ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('T3', 'จากงวด');
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ถึงงวด');
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('V3', 'ประเภทภาษี');
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('W3', 'รหัสไฟแนนซ์');
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('X3', 'การขาย');
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'วันที่บันทึก');

    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
        
    $row = 3;
    $count = 0;
    $total_NETA = 0;
    $total_VAT = 0;
    $total_TOTAMT = 0;

   foreach ($response as $res) {
        $split_cusName = explode(" ", $res->CusName);

        $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $count+1);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),$res->locat);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),$res->TAXNO);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$res->TAXDT);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),$res->CONTNO);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),$res->IDCard_cus);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),$split_cusName[0]);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$split_cusName[1]);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),$split_cusName[2]);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),$res->IDCard_cus);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), '');
        $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),$res->NETAMT);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),$res->VATAMT);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),$res->TOTAMT);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), '');
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),$res->TAXTYP);
        $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1),'');
        $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1),$res->DECP);
        $objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1),$res->FPAY);
        $objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1),$res->LPAY);
        $objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1),$res->TAXFLG);
        $objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1),'');
        $objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1),'');
        $objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1),'');
        
        $count++;
        $row++;
   }
   
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

$fname = "tmp/Salestax.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Salestax.xlsx"');
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