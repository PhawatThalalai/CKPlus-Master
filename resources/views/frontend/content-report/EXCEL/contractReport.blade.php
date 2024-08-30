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


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'วันทำสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'สถานะสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ผู้ส่งจัด');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'ผู้ขออนุมัติ');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ผู้อนุมัติ');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'วันอนุมัติ');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'CredoCode');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CredoScore');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'เช็คเล่มทะเบียน');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ขออนุมัติพิเศษ');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'รหัสลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'ชื่อ-นามสกุล');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'line');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'facebook');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'เบอร์ติดต่อ');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'ประเภทลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'แหล่งที่มา');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'รหัสทรัพย์ ');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'ประเภท');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'ยี่ห้อรถ');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'กลุ่มรถ');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'รุ่นรถ');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'ปีรถ');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', "เกียร์รถ");
$objPHPExcel->getActiveSheet()->setCellValue('AA1', "เลขถัง");
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'เลขเครื่อง');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'ป้ายทะเบียนเดิม');
$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'ป้ายทะเบียนใหม่');
$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'สถานะครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'วันครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'ราคากลาง');
$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'ยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'ค่าดำเนินการ');
$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'ค่าประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'ค่าPA');
$objPHPExcel->getActiveSheet()->setCellValue('AL1', "% LTV");
$objPHPExcel->getActiveSheet()->setCellValue('AM1', 'Vat');
$objPHPExcel->getActiveSheet()->setCellValue('AN1', 'ดอกเบี้ย');
$objPHPExcel->getActiveSheet()->setCellValue('AO1', 'จำนวนงวด');
$objPHPExcel->getActiveSheet()->setCellValue('AP1', 'ชำระต่องวด');
$objPHPExcel->getActiveSheet()->setCellValue('AQ1', 'ยอดทั้งสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('AR1', 'ผู้รับเงิน');
$objPHPExcel->getActiveSheet()->setCellValue('AS1', 'เลขบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('AT1', 'เบอร์โทร');
$objPHPExcel->getActiveSheet()->setCellValue('AU1', 'บัญชีโอนเงินออก');
$objPHPExcel->getActiveSheet()->setCellValue('AV1', 'ผู้แนะนำ');
$objPHPExcel->getActiveSheet()->setCellValue('AW1', 'เลขบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('AX1', 'เบอร์โทร');
$objPHPExcel->getActiveSheet()->setCellValue('AY1', 'บัญชีโอนเงินออกผู้เเนะนำ');
$objPHPExcel->getActiveSheet()->setCellValue('AZ1', 'ค่าแนะนำ');
$objPHPExcel->getActiveSheet()->setCellValue('BA1', 'วันชำระงวดแรก');
$objPHPExcel->getActiveSheet()->setCellValue('BB1', 'บัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('BC1', 'ผู้โอนเงิน');
$objPHPExcel->getActiveSheet()->setCellValue('BD1', 'วันที่โอนเงิน');
$objPHPExcel->getActiveSheet()->setCellValue('BE1', 'ยอดโอนลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('BF1', 'รวมค่าใช้จ่าย');
$objPHPExcel->getActiveSheet()->setCellValue('BG1', 'ยอดปิดบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('BH1', 'ค่าปิดบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('BI1', 'บัญชีโอนเงินออกปิดบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('BJ1', 'ค่าพรบ.');
$objPHPExcel->getActiveSheet()->setCellValue('BK1', 'ค่าภาษี');
$objPHPExcel->getActiveSheet()->setCellValue('BL1', 'ค่าขนส่ง');
$objPHPExcel->getActiveSheet()->setCellValue('BM1', 'ค่าอื่นๆ');
$objPHPExcel->getActiveSheet()->setCellValue('BN1', 'ค่าประเมิน');
$objPHPExcel->getActiveSheet()->setCellValue('BO1', 'ค่าอากร');
$objPHPExcel->getActiveSheet()->setCellValue('BP1', 'ค่าการตลาด');
$objPHPExcel->getActiveSheet()->setCellValue('BQ1', 'ค่าดำเนินการหัก');
$objPHPExcel->getActiveSheet()->setCellValue('BR1', 'ค่าประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('BS1', 'ค่าPA');
$objPHPExcel->getActiveSheet()->setCellValue('BT1', 'หักค่างวดล่วงหน้า');
$objPHPExcel->getActiveSheet()->setCellValue('BU1', 'การผ่อน');
$objPHPExcel->getActiveSheet()->setCellValue('BV1', 'วัตถุประสงค์/เหตุผล');
$objPHPExcel->getActiveSheet()->setCellValue('BW1', 'สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('BX1', 'Checkers');
$objPHPExcel->getActiveSheet()->setCellValue('BY1', 'BranchEng');
$objPHPExcel->getActiveSheet()->setCellValue('BZ1', 'ปิดบัญชีที่');
$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('############');


$row = 1;
foreach($data as $res){
   
 
$objPHPExcel->getActiveSheet()->setCellValue('A' . ($row + 1), ParsetoDate(@$res->Date_con))->getStyle('A' . ($row + 1))
->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

$objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), @$res->Contract_Con);
$objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), @$res->Name_Branch);
$objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), @$res->StatusApp_Con);
$objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), @$userZone[$res->UserSent_Con]);
$objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), @$userZone[$res->DocApp_Con]);
$objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), @$userZone[$res->ConfirmApp_Con]);
$objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), @$res->DateConfirmApp_Con);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), @$res->Credo_Code);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1),  @$res->Credo_Score);
$objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), @$res->Check_Bookcar);
$objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), @$res->Special_Bookcar);
$objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), @$res->Code_Cus);
$objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),  @$res->Name_Cus);
$objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),  @$res->Social_Line);
$objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1),  @$res->Social_facebook);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),  @$res->Phone_cus);
$objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), @$res->StatusCus_name);
$objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1), @$res->Name_CusResource);
$objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1),  '');


$objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1), @$res->typeCar);
$objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1), @$res->brand);
$objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1),'');
$objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1), @$res->model);
$objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1), @$res->years );
$objPHPExcel->getActiveSheet()->setCellValue('Z'.($row+1), @$res->Vehicle_Gear);
$objPHPExcel->getActiveSheet()->setCellValue('AA'.($row+1), @$res->Vehicle_Chassis );
$objPHPExcel->getActiveSheet()->setCellValue('AB'.($row+1), @$res->Vehicle_Engine );
$objPHPExcel->getActiveSheet()->setCellValue('AC'.($row+1), @$res->Vehicle_OldLicense);
$objPHPExcel->getActiveSheet()->setCellValue('AD'.($row+1), @$res->licence);
$objPHPExcel->getActiveSheet()->setCellValue('AE'.($row+1),  @$res->Name_TypePoss);
$objPHPExcel->getActiveSheet()->setCellValue('AF'.($row+1),  date('d-m-Y', strtotime(@$res->OccupiedDT)));
$objPHPExcel->getActiveSheet()->setCellValue('AG'.($row+1),  (@$res->Price_Asset));
$objPHPExcel->getActiveSheet()->setCellValue('AH'.($row+1),  (@$res->Cash_Car));
$objPHPExcel->getActiveSheet()->setCellValue('AI'.($row+1),  (@$res->StatusProcess_Car=='yes'? @$res->Process_Car:0));
$objPHPExcel->getActiveSheet()->setCellValue('AJ'.($row+1),  (@$res->Insurance));

$objPHPExcel->getActiveSheet()->setCellValue('AK'.($row+1),  @$res->PA);

$objPHPExcel->getActiveSheet()->setCellValue('AL'.($row+1),   "=IFERROR(AH".($row+1)."/AG".($row+1).",0)");
$objPHPExcel->getActiveSheet()->getStyle('AL'.($row+1))->getNumberFormat()->setFormatCode('0%');
$objPHPExcel->getActiveSheet()->setCellValue('AM'.($row+1),     @$res->Vat_Rate);
$objPHPExcel->getActiveSheet()->setCellValue('AN'.($row+1),     @$res->totalInterest_Car);
$objPHPExcel->getActiveSheet()->setCellValue('AO'.($row+1), @$res->Timelack_Car);
$objPHPExcel->getActiveSheet()->setCellValue('AP'.($row+1), @$res->Period_Rate);
$objPHPExcel->getActiveSheet()->setCellValue('AQ'.($row+1), (@$res->TotalPeriod_Rate));

$objPHPExcel->getActiveSheet()->setCellValue('AR'.($row+1),  @$res->payName);
$objPHPExcel->getActiveSheet()->setCellValue('AS'.($row+1), @$res->payAccount);
$objPHPExcel->getActiveSheet()->setCellValue('AT'.($row+1),  @$res->payPhone);
$objPHPExcel->getActiveSheet()->setCellValue('AU'.($row+1), 'บัญชีโอนเงินออก');
$objPHPExcel->getActiveSheet()->setCellValue('AV'.($row+1),  @$res->Name_Broker);
$objPHPExcel->getActiveSheet()->setCellValue('AW'.($row+1), @$res->Account_Broker);
$objPHPExcel->getActiveSheet()->setCellValue('AX'.($row+1), @$res->Phone_Broker);
$objPHPExcel->getActiveSheet()->setCellValue('AY'.($row+1), 'บัญชีโอนเงินออกผู้เเนะนำ');
$objPHPExcel->getActiveSheet()->setCellValue('AZ'.($row+1), (@$res->SumCom_Broker));
$objPHPExcel->getActiveSheet()->setCellValue('BA'.($row+1), (@$res->DateDue_Con != NULL ?date('d-m-Y', strtotime(@$res->DateDue_Con)) : NULL));
$objPHPExcel->getActiveSheet()->setCellValue('BB'.($row+1), '');
$objPHPExcel->getActiveSheet()->setCellValue('BC'.($row+1), (@$res->Approve_monetary != NULL ?@$res->Approve_monetary : NULL));
$objPHPExcel->getActiveSheet()->setCellValue('BD'.($row+1), (@$res->Date_monetary != NULL ?date('d-m-Y', strtotime(@$res->Date_monetary)) : NULL));
$objPHPExcel->getActiveSheet()->setCellValue('BE'.($row+1),  (@$res->Balance_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BF'.($row+1), (@$res->Total_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BG'.($row+1), (@$res->AccountClose_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BH'.($row+1), (@$res->AccountClose_Price_fee));
$objPHPExcel->getActiveSheet()->setCellValue('BI'.($row+1), 'บัญชีโอนเงินออกปิดบัญชี');
$objPHPExcel->getActiveSheet()->setCellValue('BJ'.($row+1),  (@$res->Act_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BK'.($row+1), (@$res->Tax_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BL'.($row+1), (@$res->Tran_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BM'.($row+1), (@$res->Other_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BN'.($row+1), (@$res->Evaluetion_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BO'.($row+1), (@$res->Duty_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BP'.($row+1), (@$res->Marketing_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BQ'.($row+1), (@$res->Process_Price));
$objPHPExcel->getActiveSheet()->setCellValue('BR'.($row+1), (@$res->P2_Price));

$objPHPExcel->getActiveSheet()->setCellValue('BS'.($row+1), ( $res->Insurance_PA));
$objPHPExcel->getActiveSheet()->setCellValue('BT'.($row+1), (@$res->DuePrepaid_Price));

$objPHPExcel->getActiveSheet()->setCellValue('BU'.($row+1), @$res->Installment);
$objPHPExcel->getActiveSheet()->setCellValue('BV'.($row+1), @$res->Memo_Con);
$objPHPExcel->getActiveSheet()->setCellValue('BW'.($row+1), '('.@$res->CodeLoan_Con.')-'.@$res->Loan_Name);
$objPHPExcel->getActiveSheet()->setCellValue('BX'.($row+1), @$res->Checkers_Con);
$objPHPExcel->getActiveSheet()->setCellValue('BY'.($row+1), @$res->NickName_Branch);
$objPHPExcel->getActiveSheet()->setCellValue('BZ'.($row+1), @$res->closeName);

$objPHPExcel->getActiveSheet()->getStyle('AG'.($row+1).':AK'.($row+1))->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('AO'.($row+1).':AQ'.($row+1))->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('BE'.($row+1).':BT'.($row+1))->getNumberFormat()->setFormatCode('#,##0.00');



    if ($res->Status_Con=="cancel") {
               
            $style = $objPHPExcel->getActiveSheet()->getStyle('A'.($row+1).':AG'.($row+1)) ;

			// Set the fill color
			$style->getFill()->setFillType(PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
			$style->getFill()->getStartColor()->setARGB('FFFF0000'); 
				}
    
    $row++;
    }

 $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

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
$objPHPExcel->getActiveSheet()->setTitle('Contacts');


$fname = "tmp/contract.xlsx";


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