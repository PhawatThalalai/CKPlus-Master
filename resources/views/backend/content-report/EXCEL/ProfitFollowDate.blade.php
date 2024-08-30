<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$marr[1] = 'January';
$marr[2] = 'February';
$marr[3] = 'March';
$marr[4] = 'April';
$marr[5] = 'May';
$marr[6] = 'June';
$marr[7] = 'July';
$marr[8] = 'August';
$marr[9] = 'September';
$marr[10] = 'October';
$marr[11] = 'November';
$marr[12] = 'December';

$objPHPExcel = new Spreadsheet();

$objPHPExcel->getProperties()->setCreator('Poobate Khunthong')->setLastModifiedBy('Poobate Khunthong')->setTitle('Office 2007 XLSX ')->setSubject('Office 2007 XLSX ')->setDescription('document for Office 2007 XLSX')->setKeywords('office 2007 openxml php')->setCategory('result file');

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->mergeCells('A1:X1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานกำไรตามวันครบกำหนดชำระ (EFF)');
$objPHPExcel->getActiveSheet()->mergeCells('A2:X2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', "ลูกหนี้ ณ. วันที่ {$Fdate} ถึง {$Tdate}");

$objPHPExcel
    ->getActiveSheet()
    ->getStyle('T3:V3')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('fb8500');
$objPHPExcel->getActiveSheet()->mergeCells('T3:V3');
$objPHPExcel->getActiveSheet()->setCellValue('T3', 'ดอกผลตามภาระหนี้');

$objPHPExcel
    ->getActiveSheet()
    ->getStyle('A4:X4')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('ffb703');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('A4', '#');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('B4', 'สาขา');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('C4', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('D4', 'CONTTYP');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('E4', 'CODLOAN');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('F4', 'ชื่อ-สกุล');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('G4', 'วันทำสัญญา');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('H4', 'ดิวงวดแรก');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('I4', 'ดิวงวดสุดท้าย');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('J4', 'ดิวงวดนี้');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('K4', 'จำนวนงวด');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('L4', 'เงินลงทุน');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('M4', 'ดอกผล');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('N4', 'ค่างวด');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('O4', 'ลูกหนี้ทั้งสัญญา');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('P4', 'ค่างวด');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('Q4', 'ภาษีงวดนี้');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('R4', 'ลูกหนี้คงเหลือ');
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('S4', 'วันที่หยุดรับรู้รายได้');
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('T4', 'ดอกผลสะสม');
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('U4', 'ดอกผลงวดนี้');
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('V4', 'ดอกผลคงเหลือ');
if ($tableLoan == 'PSL') {
    if ($conttype == 3) {
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('W4', 'ค่าธรรมเนียมสะสม');
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('X4', 'ค่าธรรมเนียมงวดนี้');
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('Y4', 'ค่าธรรมเนียมคงเหลือ');
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
        $objPHPExcel->getActiveSheet()->setCellValue('Z4', 'ส่วนลด');
    } else {
            if ($conttype == 1) {
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                $objPHPExcel->getActiveSheet()->setCellValue('W4', 'ชำระดอกเบี้ย');
                $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
                $objPHPExcel->getActiveSheet()->setCellValue('X4', 'ส่วนลด');
              
            } else {
                $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
                $objPHPExcel->getActiveSheet()->setCellValue('W4', 'ส่วนลด');
            }
        } 
} else {
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('W4', 'ภาษีคงเหลือ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('X4', 'ส่วนลด');
}

$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');

$row = 4;
$count = 0;

foreach ($dataProfitfollow as $key => $value) {
    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($row + 1), $count + 1);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . ($row + 1), @$branchsAll[$value->locat]);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . ($row + 1), @$value->contno);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . ($row + 1), @$value->CONTTYP);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . ($row + 1), @$value->CODLOAN);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . ($row + 1), @$value->Name_Cus);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . ($row + 1), @$value->sdate);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . ($row + 1), @$value->fdate);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . ($row + 1), @$value->ldate);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . ($row + 1), @$value->duedate);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 1), @$value->t_nopay);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . ($row + 1), @$value->tcshprc);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . ($row + 1), @$value->netprofit);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . ($row + 1), @$value->dueamt);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . ($row + 1), @$value->totprc);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . ($row + 1), @$value->DueCs);
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($row + 1), @$value->vatDue);
    $objPHPExcel->getActiveSheet()->setCellValue('R' . ($row + 1), @$value->totprc - $value->smpay);
    $objPHPExcel->getActiveSheet()->setCellValue('S' . ($row + 1), @$value->dtstopv);
    $objPHPExcel->getActiveSheet()->setCellValue('T' . ($row + 1), @$value->profDuea);
    $objPHPExcel->getActiveSheet()->setCellValue('U' . ($row + 1), $value->interest == null ? $value->profkang : $value->interest);
    $objPHPExcel->getActiveSheet()->setCellValue('V' . ($row + 1), $value->profbal == null ? 0 : $value->profbal);
    if ($tableLoan == 'PSL') {
        if ($conttype == 3) {
            $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), $value->profeeDuea);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . ($row + 1), $value->feeint);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . ($row + 1), @$value->profeebal);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . ($row + 1), $value->disct);
        } else {
            if ($conttype == 1) {
                $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), $value->payinterest);
                $objPHPExcel->getActiveSheet()->setCellValue('X' . ($row + 1), $value->disct);
               
            } else {
                //$objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1),  $value->payinterest);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), $value->disct == null ? 0 : $value->disct);
            }
        }
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), $value->taxbalance);
        $objPHPExcel->getActiveSheet()->setCellValue('X' . ($row + 1), $value->disct == null ? 0 : $value->disct);
    }
    $count++;
    $row++;
}

// $objPHPExcel->getActiveSheet()->mergeCells('A'.($row+1).':'.'Y'.($row+1));
// $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), 'รายงานการทั้งหมด '.($count).' รายการ');
// foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
//         $objPHPExcel->getActiveSheet()
//                 ->getColumnDimension($col)
//                 ->setAutoSize(true);
//     }

$default_style = [
    'font' => [
        'name' => 'Verdana',
        'color' => ['rgb' => '000000'],
        'size' => 11,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allborders' => [
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($default_style);
// Apply default style to whole sheet
// $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

$objPHPExcel
    ->getActiveSheet()
    ->getStyle('A3:' . $last_col . $row)
    ->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel
    ->getActiveSheet()
    ->getHeaderFooter()
    ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
//echo date('H:i:s') . " Set page orientation and size\n";
$objPHPExcel
    ->getActiveSheet()
    ->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel
    ->getActiveSheet()
    ->getPageSetup()
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75); // กำหนดระยะขอบ บน
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25); // กำหนดระยะขอบ ขวา
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.25); // กำหนดระยะขอบ ซ้าย
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75); // กำหนดระยะขอบ ล่าง
// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('รายงานกำไรตามวันครบกำหนดชำระ');

$fname = 'tmp/profitfollow.xlsx';

$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="รายงานกำไรตามวันครบกำหนดชำระ.xlsx"');
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
