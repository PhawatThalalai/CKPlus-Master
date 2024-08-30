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

$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานลูกหนี้คงเหลือเพื่อแผนกบัญชี');
$objPHPExcel->getActiveSheet()->mergeCells('A2:Q2');
$objPHPExcel->getActiveSheet()->setCellValue('A2', ' ณ วันที่ '.formatDateThaiShort_monthNum(date('Y-m-d')) );

//if($tableLoan == 'PSL'){
    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'สาขา');
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'เลขที่สัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'ชื่อลูกค้า');
    $objPHPExcel->getActiveSheet()->setCellValue('D3', 'วันที่ทำสัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'วันที่ชำระงวดแรก');
    $objPHPExcel->getActiveSheet()->setCellValue('F3', 'วันครบอายุสัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'ทุนกู้');
    $objPHPExcel->getActiveSheet()->setCellValue('H3', 'ดอกเบี้ยเงินกู้');
    $objPHPExcel->getActiveSheet()->setCellValue('I3', 'ภาษีทั้งสัญญา');
    $objPHPExcel->getActiveSheet()->setCellValue('J3', 'ยอดผ่อนชำระ');
    $objPHPExcel->getActiveSheet()->setCellValue('K3', 'จำนวนเดือนต่องวด');
    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'จำนวนงวดทั้งหมด');
    $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ชำระแล้ว');
    $objPHPExcel->getActiveSheet()->setCellValue('N3', 'ค้างชำระ');
    $objPHPExcel->getActiveSheet()->setCellValue('O3', 'ลูกหนี้คงเหลือ');
    $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ดอกผลคงเหลือ');
    $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'ภาษีคงเหลือ');
    $objPHPExcel->getActiveSheet()->setCellValue('R3', 'วันค้างชำระ ณ สิ้นเดือน');
    



    $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
        
    $row = 3;
    foreach($data as $key=> $res){
        
        $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), @$res->Name_Branch);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.($row+1), @$res->contno, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$res->Name_Cus );
        $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), ParsetoDate(@$res->sdate ));
        //chk
        $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),  ParsetoDate(@$res->fdate));
    
        $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  ParsetoDate(@$res->ldate));
        $objPHPExcel->getActiveSheet()->getStyle('D'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $objPHPExcel->getActiveSheet()->getStyle('E'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $objPHPExcel->getActiveSheet()->getStyle('F'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');

        $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1),  (@$res->tcshprc));
        $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),  (@$res->NETPROFIT ));
        $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1),  0);
 
        $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),  @$res->totprc );
        $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), 1 );
        $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),@$res->t_nopay);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1),@$res->SMPAY);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),@$res->EXP_AMT);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),@$res->arbl);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), ' ');
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),'');
        $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1),'');
        $row++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('J:L')->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00');
    foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        } 
    
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
    // }else{
    //     $objPHPExcel->getActiveSheet()->setCellValue('A3', '#');
    //     $objPHPExcel->getActiveSheet()->setCellValue('B3', 'เลขที่สัญญา');
    //     $objPHPExcel->getActiveSheet()->setCellValue('C3', 'ชื่อลูกค้า');
    //     $objPHPExcel->getActiveSheet()->setCellValue('D3', 'เลขตัวถัง');
    //     $objPHPExcel->getActiveSheet()->setCellValue('E3', 'ยี่ห้อ');
    //     $objPHPExcel->getActiveSheet()->setCellValue('F3', 'ทะเบียน');
    //     $objPHPExcel->getActiveSheet()->setCellValue('G3', 'วันทำสัญญา');
    //     $objPHPExcel->getActiveSheet()->setCellValue('H3', 'งวดแรก');
    //     $objPHPExcel->getActiveSheet()->setCellValue('I3', 'งวดสุดท้าย');

    //     $objPHPExcel->getActiveSheet()->setCellValue('J3', 'จำนวนงวด');
    //     $objPHPExcel->getActiveSheet()->setCellValue('K3', 'ค่างวดรวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('L3', 'ค่างวดไม่รวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('M3', 'ภาษีค่างวด');
    //     $objPHPExcel->getActiveSheet()->setCellValue('N3', 'มูลค่าขายสด');
    //     $objPHPExcel->getActiveSheet()->setCellValue('O3', 'ภาษีขายสด');
    //     $objPHPExcel->getActiveSheet()->setCellValue('P3', 'ขายสดรวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'มูลค่าดาวน์');
    //     $objPHPExcel->getActiveSheet()->setCellValue('R3', 'ภาษีดาวน์');
    //     $objPHPExcel->getActiveSheet()->setCellValue('S3', 'ดาวน์รวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('T3', 'มูลค่าทุน');
    //     $objPHPExcel->getActiveSheet()->setCellValue('U3', 'ภาษีทุน');
    //     $objPHPExcel->getActiveSheet()->setCellValue('V3', 'ทุนรวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('W3', 'กำไรขายสด');
    //     $objPHPExcel->getActiveSheet()->setCellValue('X3', 'ดอกผลเช้าซื้อ');
    //     $objPHPExcel->getActiveSheet()->setCellValue('Y3', 'ภาษีขาย');
    //     $objPHPExcel->getActiveSheet()->setCellValue('Z3', 'ราคารวมภาษี');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AA3', 'กำไรขายผ่อน');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AB3', 'มูลค่าขายผ่อน');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AC3', 'ลูกหนี้ทั้งสัญญา');



    //     $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
            
    //     $row = 3;
    //     foreach($data as $key=> $res){
            
    //         $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), ($key+1));
    //         $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.($row+1), @$res->CONTNO, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    //         $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$res->Name_Cus );
    //         $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), @$res->Vehicle_Chassis );
    //         //chk
    //         $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1),  @$res->typeModel);
        
    //         $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  @$res->typeLicense);

    //         $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), ParsetoDate(@$res->SDATE));
    //         $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), ParsetoDate(@$res->FDATE ));
    //         $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), ParsetoDate(@$res->LDATE));
    //         $objPHPExcel->getActiveSheet()->getStyle('G'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
    //         $objPHPExcel->getActiveSheet()->getStyle('H'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
    //         $objPHPExcel->getActiveSheet()->getStyle('I'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');

    //         $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),  @$res->T_NOPAY );
    //         $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),@$res->dueNoVat+@$res->VatDue);
    //         $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),@$res->dueNoVat);
    //         $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1),@$res->VatDue);
    //         $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),@$res->TonNoVat);
    //         $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),@$res->VatTon);
    //         $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1),@$res->TotTon);
    //         $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),@$res->NDAWN);
    //         $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1),@$res->VATDAWN);
    //         $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1),@$res->TOTDAWN);
    //         $objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1),@$res->CRNOVAT);
    //         $objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1),@$res->CRVAT);
    //         $objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1),@$res->TOTCOST);
    //         $objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1),@$res->NETPROFIT);
    //         $objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1),@$res->VATPRICE);
    //         $objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1),@$res->TonNoVat-@$res->CRNOVAT);
    //         $objPHPExcel->getActiveSheet()->setCellValue('Z'.($row+1), @$res->TOTPRC);
    //         $objPHPExcel->getActiveSheet()->setCellValue('AA'.($row+1),(@$value->TOTPRC-@$value->VATPRICE)-@$value->CRNOVAT);
    //         $objPHPExcel->getActiveSheet()->setCellValue('AB'.($row+1),@$res->TOTPRC-@$res->VATPRICE);
    //         $objPHPExcel->getActiveSheet()->setCellValue('AC'.($row+1),@$res->balance);
        

    //         $row++;
    //         }

    //         $objPHPExcel->getActiveSheet()->getStyle('J:L')->getNumberFormat()->setFormatCode('#,##0.00');
    //         $objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#,##0.00');
    //     foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
    //             $objPHPExcel->getActiveSheet()
    //                     ->getColumnDimension($col)
    //                     ->setAutoSize(true);
    //         } 
        
    //     $default_style = array(
    //         'font' => array(
    //             'name' => 'Verdana',
    //             'color' => array('rgb' => '000000'),
    //             'size' => 11
    //         ),
    //         'alignment' => array(
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    //         ),
    //         'borders' => array(
    //             'allborders' => array(
    //                 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => array('rgb' => '000000')
    //             )
    //         )
    //     );
    //     $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($default_style);
    //     // Apply default style to whole sheet
    //     // $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

    //     $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
    //     // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    //     // $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //     // $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
    //     // $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
    //     // // Apply title style to titles

    //     $objPHPExcel->getActiveSheet()->getStyle('A3:'.$last_col.$row)->applyFromArray(
    //         ['borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ]
    //     );
    // }


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

$fname = "tmp/StatusAuditDoc.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="granting_credit.xlsx"');
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