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

$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
if ($tableLoan != 'PSL') {
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานการลูกหนี้หยุดรับรู้ vat');
} else {
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานการลูกหนี้หยุดรับรู้รายได้');
}

$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'ระหว่างวันที่ '.formatDateThaiShort_monthNum(@$Fdate).' ถึงวันที่ '.formatDateThaiShort_monthNum(@$Tdate));


    $objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'สาขา');
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'เลขที่สัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('D3', 'ชื่อลูกค้า');
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'วันที่ทำสัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('F3', 'ยอดผ่อน');
    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'ค้างงวด');
    $objPHPExcel->getActiveSheet()->setCellValue('H3', 'ค้างงวดที่');
    $objPHPExcel->getActiveSheet()->setCellValue('I3', 'ถึงงวดที่');
    $objPHPExcel->getActiveSheet()->setCellValue('J3', 'เงินค้างงวด');
    $objPHPExcel->getActiveSheet()->setCellValue('K3', 'วันหยุดรับรู้');


    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
        
    $row = 3;
    $count = 06;

    foreach ($response as $key=> $res) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $key+1);          
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),$res->StopVATLocat->NickName_Branch);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1),$res->StopVATLocat->NickName_Branch);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),$res->CONTNO);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),$res->UserStopVat->Name_Cus);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),$res->SDATE);
            //chk
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),$res->TOTPRC);        
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),$res->EXP_PRD);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),$res->EXP_FRM);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),$res->EXP_TO);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),$res->EXP_AMT);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),$res->STOPVDT);

            $count++;
            $row++;
    }
    $objPHPExcel->getActiveSheet()->mergeCells('A'.($row+1).':'.'K'.($row+1));
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

$fname = "tmp/debtor-stopincome.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="debtor stopincome.xlsx"');
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