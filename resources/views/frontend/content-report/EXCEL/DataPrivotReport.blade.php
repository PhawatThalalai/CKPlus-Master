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

$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

$objPHPExcel->getProperties()->setCreator('Poobate Khunthong')->setLastModifiedBy('Poobate Khunthong')->setTitle('Office 2007 XLSX ')->setSubject('Office 2007 XLSX ')->setDescription('document for Office 2007 XLSX')->setKeywords('office 2007 openxml php')->setCategory('result file');

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'วันที่จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ประเภทลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Credo Num');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Credo Score');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Credo สำเร็จ');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Credo คำนวณ');

$objPHPExcel->getActiveSheet()->setCellValue('K1', 'คำนำหน้า');

$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ชื่อลูกค้า');

$objPHPExcel->getActiveSheet()->setCellValue('M1', 'วันเดือนปีเกิด');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'อายุ');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'อาชีพ');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'สถานะสมรส');

$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'ยี่ห้อ');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'รุ่นรถ');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'ปี');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'วันที่ครอบครอง');

$objPHPExcel->getActiveSheet()->setCellValue('U1', 'จำนวนวันครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'ลำดับการครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'รถยนต์ หน้า 16');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'รถยนต์ หน้า 18');

$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'ราคากลาง');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'ยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'LTV');
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'ดอกเบี้ย');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'จำนวนงวด');
$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'ยอดผ่อน');
$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'LABEL');
$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'probability');
$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'หมายเหตุ');

// $objPHPExcel->getActiveSheet()->setCellValue('AE1', '1_st_instalment_due_date');
// $objPHPExcel->getActiveSheet()->setCellValue('AF1', '1_st_payment_date');
// $objPHPExcel->getActiveSheet()->setCellValue('AG1', '2_nd_instalment_due_date');
// $objPHPExcel->getActiveSheet()->setCellValue('AH1', '2_nd_payment_date');
// $objPHPExcel->getActiveSheet()->setCellValue('AI1', '3_rd_instalment_due_date');
// $objPHPExcel->getActiveSheet()->setCellValue('AJ1', '3_rd_payment_date');

// $objPHPExcel->getActiveSheet()->setCellValue('AK1', 'obs_5_dpd_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('AL1', 'obs_5_dpd_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('AM1', 'obs_5_dpd_mob_3');
// $objPHPExcel->getActiveSheet()->setCellValue('AN1', 'obs_15_dpd_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('AO1', 'obs_15_dpd_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('AP1', 'obs_15_dpd_mob_3');
// $objPHPExcel->getActiveSheet()->setCellValue('AQ1', 'obs_30_dpd_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('AR1', 'obs_30_dpd_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('AS1', 'obs_30_dpd_mob_3');
// $objPHPExcel->getActiveSheet()->setCellValue('AT1', 'dpd_5_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('AU1', 'dpd_5_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('AV1', 'dpd_5_mob_3');
// $objPHPExcel->getActiveSheet()->setCellValue('AW1', 'dpd_15_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('AX1', 'dpd_15_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('AY1', 'dpd_15_mob_3');
// $objPHPExcel->getActiveSheet()->setCellValue('AZ1', 'dpd_30_mob_1');
// $objPHPExcel->getActiveSheet()->setCellValue('BA1', 'dpd_30_mob_2');
// $objPHPExcel->getActiveSheet()->setCellValue('BB1', 'dpd_30_mob_3');

$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');

$row = 1;
foreach ($data->sortBy('Date_monetary') as $res) {
    $nameCom = @$res->ContractToTypeLoan->TypeLoanToCompany->Company_Name;

    $expen = @$res->ContractToOperated;

    $dataCus = @$res->ContractToDataCusTags->TagToDataCus;
    $asset = @$res->ContractToIndenture->IndentureToAsset;
    $calculate = @$res->ContractToDataCusTags->TagToCulculate;

    $objPHPExcel->getActiveSheet()->setCellValue('A' . ($row + 1), $row);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . ($row + 1), @$res->Date_monetary);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . ($row + 1), @$res->Name_Branch);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . ($row + 1), @$res->type_cus);
    //chk
    //  if(@$asset->TypeAsset_Code!='land'){

    //    $id_license = @$asset->Vehicle_NewLicense!=NULL?@$asset->Vehicle_NewLicense:@$asset->Vehicle_OldLicense;
    //    if(@$asset->TypeAsset_Code == "car"){
    //             $brand = @$asset->AssetToCarBrand->Brand_car;
    //             $group = @$asset->AssetToCarGroup->Group_car;
    //             $model = @$asset->AssetToCarModel->Model_car;
    //             $gear = @$asset->Vehicle_Gear;
    //             $year = @$asset->AssetToCarYear->Year_car;
    //           }else{
    //             $brand = @$asset->AssetToMotoBrand->Brand_moto;
    //             $group = @$asset->AssetToMotoGroup->Group_moto;
    //             $model = @$asset->AssetToMotoModel->Model_moto;
    //             $gear = @$asset->Vehicle_Gear;
    //             $year  = @$asset->AssetToMotoYear->Year_moto;
    //           }
    // }else{
    //     $brand = @$asset->DataAssetToLandType->nametype_car;
    //      $model= @$asset->Land_Id;

    //     $year = "";
    // }
    $objPHPExcel->getActiveSheet()->setCellValue('E' . ($row + 1), '(' . @$res->CodeLoan_Con . ')-' . @$res->Loan_Name);

    $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . ($row + 1), @$res->Contract_Con, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . ($row + 1), @$res->Credo_Code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . ($row + 1), @$res->Credo_Score);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . ($row + 1), @$res->Name_Credo);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . ($row + 1), @$res->Note_Credo);

    $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 1), @$res->Prefix);

    $objPHPExcel->getActiveSheet()->setCellValue('L' . ($row + 1), @$res->Name_Cus);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . ($row + 1), @$res->Birthday_cus);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . ($row + 1), '');
    $objPHPExcel->getActiveSheet()->setCellValue('O' . ($row + 1), @$res->Marital_cus);
    $objPHPExcel->getActiveSheet()->setCellValue('P' . ($row + 1), @$res->Name_Career);
    $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($row + 1), @$res->brand);
    $objPHPExcel->getActiveSheet()->setCellValue('R' . ($row + 1), @$res->model);
    $objPHPExcel->getActiveSheet()->setCellValue('S' . ($row + 1), @$res->years);
    $objPHPExcel->getActiveSheet()->setCellValue('T' . ($row + 1), $res->OccupiedDT);
    $objPHPExcel->getActiveSheet()->setCellValue('U' . ($row + 1), '=B' . ($row + 1) . '-T' . ($row + 1));
    $objPHPExcel->getActiveSheet()->setCellValue('V' . ($row + 1), @$res->PossessionOrder);
    $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), @$res->History_16);
    $objPHPExcel->getActiveSheet()->setCellValue('X' . ($row + 1), @$res->History_18);

    $objPHPExcel->getActiveSheet()->setCellValue('Y' . ($row + 1), @$res->Price_Asset);
    $objPHPExcel->getActiveSheet()->setCellValue('Z' . ($row + 1), @$res->Cash_Car + (@$res->StatusProcess_Car == 'yes' ? @$res->Process_Car : 0));
    $objPHPExcel->getActiveSheet()->setCellValue('AA' . ($row + 1), '=IFERROR(L' . ($row + 1) . '/K' . ($row + 1) . ',0)');
    $objPHPExcel->getActiveSheet()->setCellValue('AB' . ($row + 1), @$res->totalInterest_Car);
    $objPHPExcel->getActiveSheet()->setCellValue('AC' . ($row + 1), @$res->Timelack_Car);
    $objPHPExcel->getActiveSheet()->setCellValue('AD' . ($row + 1), @$res->Period_Rate);
    $objPHPExcel->getActiveSheet()->setCellValue('AE' . ($row + 1), @$res->MI_label);
    $objPHPExcel->getActiveSheet()->setCellValue('AF' . ($row + 1), @$res->MI_probability);
    $objPHPExcel->getActiveSheet()->setCellValue('AG' . ($row + 1), @$res->Memo_Con);

    //    $objPHPExcel->getActiveSheet()->setCellValue('AE'.($row+1), @$DUEDATE_1);
    //     $objPHPExcel->getActiveSheet()->getStyle('AE'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AF'.($row+1), @$DATEPAY_1);
    //     $objPHPExcel->getActiveSheet()->getStyle('AF'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AG'.($row+1), @$DUEDATE_2);
    //     $objPHPExcel->getActiveSheet()->getStyle('AG'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AH'.($row+1), @$DATEPAY_2);
    //     $objPHPExcel->getActiveSheet()->getStyle('AH'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AI'.($row+1), @$DUEDATE_3);
    //     $objPHPExcel->getActiveSheet()->getStyle('AI'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AJ'.($row+1), @$DATEPAY_3);
    //     $objPHPExcel->getActiveSheet()->getStyle('AJ'.($row+1))->getNumberFormat()
    //              ->setFormatCode('yyyy-mm-dd');

    //     $objPHPExcel->getActiveSheet()->setCellValue('AK'.($row+1), '=IFERROR(IF(TODAY()-AE'.($row+1).'>5,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AL'.($row+1), '=IFERROR(IF(TODAY()-AG'.($row+1).'>5,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AM'.($row+1), '=IFERROR(IF(TODAY()-AI'.($row+1).'>5,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AN'.($row+1), '=IFERROR(IF(TODAY()-AE'.($row+1).'>15,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AO'.($row+1), '=IFERROR(IF(TODAY()-AG'.($row+1).'>15,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AP'.($row+1), '=IFERROR(IF(TODAY()-AI'.($row+1).'>15,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AQ'.($row+1), '=IFERROR(IF(TODAY()-AE'.($row+1).'>30,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AR'.($row+1), '=IFERROR(IF(TODAY()-AG'.($row+1).'>30,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AS'.($row+1), '=IFERROR(IF(TODAY()-AI'.($row+1).'>30,1,0),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AT'.($row+1), '=IFERROR(IF(AF'.($row+1).'<>"",IF(AF'.($row+1).'-AE'.($row+1).'>5,1,0),IF(AK'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AU'.($row+1), '=IFERROR(IF(AH'.($row+1).'<>"",IF(AH'.($row+1).'-AF'.($row+1).'>5,1,0),IF(AL'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AV'.($row+1), '=IFERROR(IF(AJ'.($row+1).'<>"",IF(AJ'.($row+1).'-AI'.($row+1).'>5,1,0),IF(AM'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AW'.($row+1), '=IFERROR(IF(AF'.($row+1).'<>"",IF(AF'.($row+1).'-AE'.($row+1).'>15,1,0),IF(AN'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AX'.($row+1), '=IFERROR(IF(AH'.($row+1).'<>"",IF(AH'.($row+1).'-AF'.($row+1).'>15,1,0),IF(AO'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AY'.($row+1), '=IFERROR(IF(AJ'.($row+1).'<>"",IF(AJ'.($row+1).'-AI'.($row+1).'>15,1,0),IF(AP'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('AZ'.($row+1), '=IFERROR(IF(AF'.($row+1).'<>"",IF(AF'.($row+1).'-AE'.($row+1).'>30,1,0),IF(AQ'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('BA'.($row+1), '=IFERROR(IF(AH'.($row+1).'<>"",IF(AH'.($row+1).'-AF'.($row+1).'>30,1,0),IF(AR'.($row+1).'=1,1,0)),0)');
    //     $objPHPExcel->getActiveSheet()->setCellValue('BB'.($row+1), '=IFERROR(IF(AJ'.($row+1).'<>"",IF(AJ'.($row+1).'-AI'.($row+1).'>30,1,0),IF(AS'.($row+1).'=1,1,0)),0)');

    // $objPHPExcel
    //     ->getActiveSheet()
    //     ->getStyle('AB' . ($row + 1) . ':AS' . ($row + 1))
    //     ->getNumberFormat()
    //     ->setFormatCode('###0');
    $row++;
}

$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

$objPHPExcel
    ->getActiveSheet()
    ->getStyle('A1:' . $last_col . '32')
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
$objPHPExcel->getActiveSheet()->setTitle('ContactsPrivot');

$fname = 'tmp/ContactsPrivot.xlsx';

$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ContactsPrivot.xlsx"');
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
