<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

$objPHPExcel->getProperties()->setCreator('CKPlus')->setLastModifiedBy('CKPlus')->setTitle('Office 2007 XLSX ')->setSubject('Office 2007 XLSX ')->setDescription('document for Office 2007 XLSX')->setKeywords('office 2007 openxml php')->setCategory('result file');

$objPHPExcel->setActiveSheetIndex(0);

// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'วันทำสัญญา');
// $objPHPExcel->getActiveSheet()->setCellValue('B1', 'เลขที่สัญญา');
// $objPHPExcel->getActiveSheet()->setCellValue('C1', 'สาขา');
// $objPHPExcel->getActiveSheet()->setCellValue('D1', 'สถานะสัญญา');
// $objPHPExcel->getActiveSheet()->setCellValue('E1', 'ผู้ส่งจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('F1', 'ผู้ขออนุมัติ');
// $objPHPExcel->getActiveSheet()->setCellValue('G1', 'ผู้อนุมัติ');
// $objPHPExcel->getActiveSheet()->setCellValue('H1', 'วันอนุมัติ');
// $objPHPExcel->getActiveSheet()->setCellValue('I1', 'CredoCode');

$row = 3;
$i = 4;

$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(2, 3, 2, 4);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'LOCAT');

$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(3, 3, 3, 4);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, 'SIZE');

// $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(4, 3, 4, 4);
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 3, 'Marketing');

// $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(5, 3, 5, 4);
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 3, 'Name');

for ($h = 0; $h < count($Loans); $h++) {
    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i, 3, $i + 4, 3);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $row, $Loans[$h]);

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $row + 1, 'ลูกค้าปิดจัดใหม่');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i + 1, $row + 1, 'ลูกค้าใหม่');

    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow($i + 2, 4, $i + 4, 4);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i + 2, $row + 1, 'ยอดเงินค่าคอมฯ');

    $i = $i + 5;

    $br = 5;
    foreach ($branchs as $key => $branch) {
        $branchUsers = $users->where('branch', $branch->id); // เลือกข้อมูลผู้ใช้ที่ branch ตรงกับสาขาที่กำหนด
        $rowCount = count($branchUsers);

        // กำหนด mergeCellsByColumnAndRow ตามจำนวนของผู้ใช้ในแต่ละสาขา
        $startRow = $br;
        $endRow = $br + $rowCount - 1;
        // $objPHPExcel->getActiveSheet()->mergeCells("B$startRow:B$endRow"); // ใช้ mergeCells แทน mergeCellsByColumnAndRow
        $objPHPExcel->getActiveSheet()->setCellValue("B$startRow", $branch->Name_Branch);

        // $objPHPExcel->getActiveSheet()->mergeCells("C$startRow:C$endRow");
        $objPHPExcel->getActiveSheet()->setCellValue("C$startRow", 'XL');

        $filteredData = $data
            ->where('Loan_Name', $Loans[$h])
            ->where('BranchSent_Con', $branch->id)
            ->count();

        dd($Loans[$h], $branch->id, $filteredData, $data);

        // ตรวจสอบว่ามีผู้ใช้หรือไม่ ถ้ามีจะวนลูปเพื่อกำหนดข้อมูลผู้ใช้ในแต่ละเซลล์
        // foreach ($branchUsers as $user) {
        //     $objPHPExcel->getActiveSheet()->setCellValue("D$startRow", $user->roles->pluck('name')->implode(', '));
        //     $objPHPExcel->getActiveSheet()->setCellValue("E$startRow", $user->name);
        //     $startRow++;

        //     $checkCont = $data
        //         ->where('Loan_Name', $Loans[$h])
        //         ->where('UserSent_Con', $user->id)
        //         ->count();

        //     dd($Loans[$h], $user->id);
        // }

        // $br = $endRow + 1; // อัปเดตค่า $br ให้เริ่มต้นที่แถวถัดไป
        $br++;
    }
}

// foreach ($data as $res) {
//     // $objPHPExcel
//     //     ->getActiveSheet()
//     //     ->setCellValue('A' . ($row + 1), ParsetoDate(@$res->Date_con))
//     //     ->getStyle('A' . ($row + 1))
//     //     ->getNumberFormat()
//     //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

//     // $objPHPExcel->getActiveSheet()->setCellValue('B' . ($row + 1), @$res->Contract_Con);
//     // $objPHPExcel->getActiveSheet()->setCellValue('C' . ($row + 1), @$res->Name_Branch);
//     // $objPHPExcel->getActiveSheet()->setCellValue('D' . ($row + 1), @$res->StatusApp_Con);
//     // $objPHPExcel->getActiveSheet()->setCellValue('E' . ($row + 1), @$userZone[$res->UserSent_Con]);
//     // $objPHPExcel->getActiveSheet()->setCellValue('F' . ($row + 1), @$userZone[$res->DocApp_Con]);
//     // $objPHPExcel->getActiveSheet()->setCellValue('G' . ($row + 1), @$userZone[$res->ConfirmApp_Con]);
//     // $objPHPExcel->getActiveSheet()->setCellValue('H' . ($row + 1), @$res->DateConfirmApp_Con);
//     // $objPHPExcel->getActiveSheet()->setCellValue('I' . ($row + 1), @$res->Credo_Code);
//     // $objPHPExcel->getActiveSheet()->setCellValue('J' . ($row + 1), @$res->Credo_Score);
//     // $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 1), @$res->Check_Bookcar);
//     // $objPHPExcel->getActiveSheet()->setCellValue('L' . ($row + 1), @$res->Special_Bookcar);
//     // $objPHPExcel->getActiveSheet()->setCellValue('M' . ($row + 1), @$res->Code_Cus);
//     // $objPHPExcel->getActiveSheet()->setCellValue('N' . ($row + 1), @$res->Name_Cus);
//     // $objPHPExcel->getActiveSheet()->setCellValue('O' . ($row + 1), @$res->Social_Line);
//     // $objPHPExcel->getActiveSheet()->setCellValue('P' . ($row + 1), @$res->Social_facebook);
//     // $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($row + 1), @$res->Phone_cus);
//     // $objPHPExcel->getActiveSheet()->setCellValue('R' . ($row + 1), @$res->StatusCus_name);
//     // $objPHPExcel->getActiveSheet()->setCellValue('S' . ($row + 1), @$res->Name_CusResource);
//     // $objPHPExcel->getActiveSheet()->setCellValue('T' . ($row + 1), '');

//     // $objPHPExcel->getActiveSheet()->setCellValue('U' . ($row + 1), @$res->typeCar);
//     // $objPHPExcel->getActiveSheet()->setCellValue('V' . ($row + 1), @$res->brand);
//     // $objPHPExcel->getActiveSheet()->setCellValue('W' . ($row + 1), '');
//     // $objPHPExcel->getActiveSheet()->setCellValue('X' . ($row + 1), @$res->model);
//     // $objPHPExcel->getActiveSheet()->setCellValue('Y' . ($row + 1), @$res->years);
//     // $objPHPExcel->getActiveSheet()->setCellValue('Z' . ($row + 1), @$res->Vehicle_Gear);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AA' . ($row + 1), @$res->Vehicle_Chassis);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AB' . ($row + 1), @$res->Vehicle_Engine);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AC' . ($row + 1), @$res->Vehicle_OldLicense);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AD' . ($row + 1), @$res->licence);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AE' . ($row + 1), @$res->Name_TypePoss);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AF' . ($row + 1), date('d-m-Y', strtotime(@$res->OccupiedDT)));
//     // $objPHPExcel->getActiveSheet()->setCellValue('AG' . ($row + 1), @$res->Price_Asset);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AH' . ($row + 1), @$res->Cash_Car);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AI' . ($row + 1), @$res->StatusProcess_Car == 'yes' ? @$res->Process_Car : 0);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AJ' . ($row + 1), @$res->Insurance);

//     // $objPHPExcel->getActiveSheet()->setCellValue('AK' . ($row + 1), @$res->PA);

//     // $objPHPExcel->getActiveSheet()->setCellValue('AL' . ($row + 1), '=IFERROR(AH' . ($row + 1) . '/AG' . ($row + 1) . ',0)');
//     // $objPHPExcel
//     //     ->getActiveSheet()
//     //     ->getStyle('AL' . ($row + 1))
//     //     ->getNumberFormat()
//     //     ->setFormatCode('0%');
//     // $objPHPExcel->getActiveSheet()->setCellValue('AM' . ($row + 1), @$res->Vat_Rate);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AN' . ($row + 1), @$res->totalInterest_Car);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AO' . ($row + 1), @$res->Timelack_Car);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AP' . ($row + 1), @$res->Period_Rate);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AQ' . ($row + 1), @$res->TotalPeriod_Rate);

//     // $objPHPExcel->getActiveSheet()->setCellValue('AR' . ($row + 1), @$res->payName);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AS' . ($row + 1), @$res->payAccount);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AT' . ($row + 1), @$res->payPhone);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AU' . ($row + 1), 'บัญชีโอนเงินออก');
//     // $objPHPExcel->getActiveSheet()->setCellValue('AV' . ($row + 1), @$res->Name_Broker);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AW' . ($row + 1), @$res->Account_Broker);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AX' . ($row + 1), @$res->Phone_Broker);
//     // $objPHPExcel->getActiveSheet()->setCellValue('AY' . ($row + 1), 'บัญชีโอนเงินออกผู้เเนะนำ');
//     // $objPHPExcel->getActiveSheet()->setCellValue('AZ' . ($row + 1), @$res->SumCom_Broker);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BA' . ($row + 1), @$res->DateDue_Con != null ? date('d-m-Y', strtotime(@$res->DateDue_Con)) : null);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BB' . ($row + 1), '');
//     // $objPHPExcel->getActiveSheet()->setCellValue('BC' . ($row + 1), @$res->Approve_monetary != null ? @$res->Approve_monetary : null);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BD' . ($row + 1), @$res->Date_monetary != null ? date('d-m-Y', strtotime(@$res->Date_monetary)) : null);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BE' . ($row + 1), @$res->Balance_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BF' . ($row + 1), @$res->Total_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BG' . ($row + 1), @$res->AccountClose_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BH' . ($row + 1), @$res->AccountClose_Price_fee);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BI' . ($row + 1), 'บัญชีโอนเงินออกปิดบัญชี');
//     // $objPHPExcel->getActiveSheet()->setCellValue('BJ' . ($row + 1), @$res->Act_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BK' . ($row + 1), @$res->Tax_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BL' . ($row + 1), @$res->Tran_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BM' . ($row + 1), @$res->Other_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BN' . ($row + 1), @$res->Evaluetion_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BO' . ($row + 1), @$res->Duty_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BP' . ($row + 1), @$res->Marketing_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BQ' . ($row + 1), @$res->Process_Price);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BR' . ($row + 1), @$res->P2_Price);

//     // $objPHPExcel->getActiveSheet()->setCellValue('BS' . ($row + 1), $res->Insurance_PA);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BT' . ($row + 1), @$res->DuePrepaid_Price);

//     // $objPHPExcel->getActiveSheet()->setCellValue('BU' . ($row + 1), @$res->Installment);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BV' . ($row + 1), @$res->Memo_Con);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BW' . ($row + 1), '(' . @$res->CodeLoan_Con . ')-' . @$res->Loan_Name);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BX' . ($row + 1), @$res->Checkers_Con);
//     // $objPHPExcel->getActiveSheet()->setCellValue('BY' . ($row + 1), @$res->NickName_Branch);

//     // $objPHPExcel
//     //     ->getActiveSheet()
//     //     ->getStyle('AG' . ($row + 1) . ':AK' . ($row + 1))
//     //     ->getNumberFormat()
//     //     ->setFormatCode('#,##0.00');
//     // $objPHPExcel
//     //     ->getActiveSheet()
//     //     ->getStyle('AO' . ($row + 1) . ':AQ' . ($row + 1))
//     //     ->getNumberFormat()
//     //     ->setFormatCode('#,##0.00');
//     // $objPHPExcel
//     //     ->getActiveSheet()
//     //     ->getStyle('BE' . ($row + 1) . ':BT' . ($row + 1))
//     //     ->getNumberFormat()
//     //     ->setFormatCode('#,##0.00');

//     // if ($res->Status_Con == 'cancel') {
//     //     $objPHPExcel
//     //         ->getActiveSheet()
//     //         ->getStyle('A' . ($row + 1) . ':AG' . ($row + 1))
//     //         ->applyFromArray([
//     //             'font' => [
//     //                 'bold' => true,
//     //             ],
//     //             'fill' => [
//     //                 'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
//     //                 'rotation' => 90,
//     //                 'startcolor' => [
//     //                     'argb' => 'FFFF0000',
//     //                 ],
//     //                 'endcolor' => [
//     //                     'argb' => 'FFFFFFFF',
//     //                 ],
//     //             ],
//     //         ]);
//     // }

//     // $row++;
// }

$last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

$objPHPExcel
    ->getActiveSheet()
    ->getStyle('A1:' . $last_col . ($row + 1))
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
$objPHPExcel->getActiveSheet()->setTitle('Contacts');

$fname = 'tmp/contract.xlsx';

$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ContractAllData.xlsx"');
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
