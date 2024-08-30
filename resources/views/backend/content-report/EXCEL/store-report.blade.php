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

    $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานการสรุปผลการจัดเก็บ');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', "ประจำเดือน {$Fdate}");

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->setCellValue('A4', '#');
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'ประเภทสัญญา');

    $objPHPExcel->getActiveSheet()->mergeCells('C3:F3');
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'ยอดต้องจัดเก็บ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'จำนวน');
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'เงินตามดิว');
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'เงินค้างงวด');
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('F4', 'รวมต้องชำระ');

    $objPHPExcel->getActiveSheet()->mergeCells('G3:K3');
    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'ยอดจัดเก็บ');
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('G4', 'รับล่างหน้า');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('H4', 'เงินตามดิว');
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('I4', 'เงินค้างงวด');
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('J4', 'รายเก็บได้');
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('K4', 'ลูกหนี้คงเหลือ 2');

    $objPHPExcel->getActiveSheet()->mergeCells('L3:N3');
    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'เปอร์เซ็นจัดเก็บได้');
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('L4', 'ตามดิว');
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('M4', 'ค้างงวด');
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $objPHPExcel->getActiveSheet()->setCellValue('N4', 'รวมเก็บได้');

    $row = 4;
    $start = 5;
    $count = 1;

    
    foreach ($response as $res) {
        $perSum = ($res->totPay/$res->blAmount);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $count);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), $res->Loan_Name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), $res->numContract);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), $res->DAMT);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), $res->KDAMT);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), $res->blAmount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), $res->PAYBEFOR);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), $res->paydue);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), $res->PAYKANG);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), $res->totPay);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), $res->totBalance);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), $res->perDuePay);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), $res->perKPay);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), $perSum);
        $objPHPExcel->getActiveSheet()->getStyle("L".($row+1))->getNumberFormat()->setFormatCode('0%');
        $objPHPExcel->getActiveSheet()->getStyle("M".($row+1))->getNumberFormat()->setFormatCode('0%');
        $objPHPExcel->getActiveSheet()->getStyle("N".($row+1))->getNumberFormat()->setFormatCode('0%');

        $row++;
        $count++;
    }

    $objPHPExcel->getActiveSheet()->mergeCells('A'.($row+1).':'.'B'.($row+1));
    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), 'รวม');
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), "=SUM(C".($start).":C".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), "=SUM(D".($start).":D".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), "=SUM(E".($start).":E".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), "=SUM(F".($start).":F".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), "=SUM(G".($start).":G".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), "=SUM(H".($start).":H".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), "=SUM(I".($start).":I".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), "=SUM(J".($start).":J".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), "=SUM(K".($start).":K".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), "=SUM(L".($start).":L".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), "=SUM(M".($start).":M".($row+1).")");
    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), "=SUM(N".($start).":N".($row+1).")");

      $objPHPExcel->getActiveSheet()->getStyle("L".($row+1))->getNumberFormat()->setFormatCode('0%');
      $objPHPExcel->getActiveSheet()->getStyle("M".($row+1))->getNumberFormat()->setFormatCode('0%');
      $objPHPExcel->getActiveSheet()->getStyle("N".($row+1))->getNumberFormat()->setFormatCode('0%');
      $objPHPExcel->getActiveSheet()->getStyle("A".($row+1).":"."N".($row+1))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffb703');

      $objPHPExcel->getActiveSheet()->getStyle('C3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffb703');
      $objPHPExcel->getActiveSheet()->getStyle('G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffb703');
      $objPHPExcel->getActiveSheet()->getStyle('L3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fb8500');
      

    foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        } 
    
    // ==========================================================
    // config default style
    // ==========================================================
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

    // ==========================================================
    // set default style
    // ==========================================================
    $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($default_style);
    $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($default_style);
    $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($default_style);
    $objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray($default_style);
    $objPHPExcel->getActiveSheet()->getStyle('A'.($row+1))->applyFromArray($default_style);
    // Apply default style to whole sheet
    // $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

    // ==========================================================
    // get last colums
    // ==========================================================
    $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
    // $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
    // // Apply title style to titles

    // ==========================================================
    // set border
    // ==========================================================
    $objPHPExcel->getActiveSheet()->getStyle('A3:'.$last_col.($row+1))->applyFromArray(
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


$objPHPExcel->getActiveSheet()->setTitle('PPAmont');

  // ==========================================================
  // Sheet 2
  // ==========================================================

$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->mergeCells('A1:R1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานการสรุปผลการจัดเก็บ');
$objPHPExcel->getActiveSheet()->mergeCells('A2:R2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', "ประจำเดือน {$Fdate}");

$objPHPExcel->getActiveSheet()->getStyle('A3:R3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffb703');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'ประเภทสัญญา');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'ตำนำ');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'ชื่อลูกค้า');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'นามสกุล');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'วันที่ชำระล่าสุด');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'สายเก็บเงิน');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'PAST');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'ดิวงวดแรก');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'REXP_PRD');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('L3', 'DAMT');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('M3', 'KDAMT');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('N3', 'KARBAL');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('O3', 'PAYBEFOR');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('P3', 'PAYDUE');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'PAYKANG');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->setCellValue('R3', 'PARBAL');

$row = 3;
$count = 1;

foreach ($res_all as $res) { 
    $cus_name = explode(' ', $res->Name_Cus);

    // dd($cus_name);

    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $res->NickName_Branch);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), '');
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), $res->CONTNO);
    if (isset($cus_name[2])) {
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), $cus_name[0]);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), $cus_name[1]);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), $cus_name[2]);
    } else {
        if (isset($cus_name[1])) {
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), 'ไม่มีคำนำหน้า');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), $cus_name[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), $cus_name[1]);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), 'ไม่มีคำนำหน้า');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), $cus_name[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), 'ไม่ใส่นามสกุล');
        }
    }
    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), $res->LPAYD);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), '');
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), '');
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), $res->FDATE);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), $res->REXP_PRD);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), $res->DAMT);
    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), $res->KDAMT);
    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), $res->KARBAL);
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1), $res->PAYBEFOR);
    $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), $res->PAYDUE);
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1), $res->PAYKANG);
    $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), $res->PARBAL);

    $row++;
}

foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        } 
    
    // ==========================================================
    // config default style
    // ==========================================================
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

    // ==========================================================
    // set default style
    // ==========================================================
    $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($default_style);
    // Apply default style to whole sheet
    // $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

    // ==========================================================
    // get last colums
    // ==========================================================
    $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    // $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
    // $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
    // // Apply title style to titles

    // ==========================================================
    // set border
    // ==========================================================
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


$objPHPExcel->getActiveSheet()->setTitle('PPAmont');



// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('store-report');

$fname = "tmp/store-report.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="store-report.xlsx"');
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