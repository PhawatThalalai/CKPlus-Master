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


$zone[10] = "ปัตตานี";
$zone[20] = "หาดใหญ่";
$zone[30] = "นครศรีธรรมราช";
$zone[40] = "กระบี่";
$zone[50] = "สุราษฎร์ธานี";


$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

$objPHPExcel->getProperties()->setCreator("Poobate Khunthong")
->setLastModifiedBy("Poobate Khunthong")
->setTitle("Office 2007 XLSX ")
->setSubject("Office 2007 XLSX ")
->setDescription("document for Office 2007 XLSX")
->setKeywords("office 2007 openxml php")
->setCategory("result file");


$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ลำดับ');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เลขที่สัญญาเช่าซื้อ');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'วันเริ่มคุ้มครอง(วันที่สัญญาเงินกู้อนุมัติ)');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'เวลาเริ่มคุ้มครอง');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'วันสิ้นสุดความคุ้มครอง');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'คำนำหน้าชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'ชื่อผู้เอาประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'นามสกุลผู้เอาประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'อาชีพ');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'เลขประจำตัวประชาชน');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'วัน/เดือน/ปี เกิด (DD/MM/YYYY)');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'เพศ');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'เชื้อชาติ');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'แผนประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'ทุนประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'ระยะเวลาคุ้มครอง (ปี)');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'บ้านเลขที่');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'หมู่');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'หมู่บ้าน');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'ซอย');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'ถนน');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'ตำบล');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'อำเภอ');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'จังหวัด');
$objPHPExcel->getActiveSheet()->setCellValue('Z1', "รหัสไปรษณีย์");
$objPHPExcel->getActiveSheet()->setCellValue('AA1', "เบอร์โทรศัพท์มือถือ");
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'อีเมล');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'ชื่อผู้รับประโยชน์อันดับ 1');
$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'ความสัมพันธ์ผู้รับประโยชน์อันดับ 1');
$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'ชื่อผู้รับประโยชน์อันดับ 2');
$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'ความสัมพันธ์ผู้รับประโยชน์อันดับ 2');
$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'สาขาใหญ่');
$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'สาขาย่อย ');
$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'Agent name');
$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'ชื่อพนักงานขาย');
$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'เบี้ยรับรวมอากร');
$objPHPExcel->getActiveSheet()->setCellValue('AL1', 'Producer code');
$objPHPExcel->getActiveSheet()->setCellValue('AM1', 'เลขแคมเปญใน S6');
$objPHPExcel->getActiveSheet()->setCellValue('AN1', 'Product code');
// $objPHPExcel->getActiveSheet()->setCellValue('AM1', 'ยอดเบี้ยลด');


// $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('############');

// $objPHPExcel->getActiveSheet()->getStyle('AG:AK')->getNumberFormat()->setFormatCode('#,##0.00');
// $objPHPExcel->getActiveSheet()->getStyle('AO:AQ')->getNumberFormat()->setFormatCode('#,##0.00');
// $objPHPExcel->getActiveSheet()->getStyle('BE:BT')->getNumberFormat()->setFormatCode('#,##0.00');

$row = 1; 
foreach($data as $key=>$res){
    
     
    $nameCom = $res->Company_Name;
    $nameAent = $res->Name_Agent;


//   $nameCom = $res->ContractToTypeLoan->TypeLoanToCompany2($res->UserZone);
//   dd( $nameCom);
//   $nameAent = $res->ContractToTypeLoan->TypeLoanToCompany2($res->UserZone)->Agent_Name;


if(strtoupper($res->Buy_PA) == 'YES'){


$objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $row);
$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.($row+1), @$res->Contract_Con, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1), @$res->Loan_Name);

if($res->Timelack_Car>84){
    $Timelack = 84;
}else{
    $Timelack =$res->Timelack_Car;
}
$yearPA = '+'.round(($Timelack)/12).' year';
@$datemonetary = explode(' ',@$res->Date_monetary);
$paStop = date('Y-m-d', strtotime($yearPA,strtotime( $datemonetary[0])));
// $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),(@$res->Date_monetary != NULL ?date('d/m/Y', strtotime(@$res->Date_monetary)) : NULL));

$objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1),(@$res->Date_monetary != NULL ? ParsetoDate(@$datemonetary[0]) : NULL));
$objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), '');
$objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  ParsetoDate($paStop));
$objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), @$res->Prefix);

$objPHPExcel->getActiveSheet()->getStyle('D'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
$objPHPExcel->getActiveSheet()->getStyle('F'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
$objPHPExcel->getActiveSheet()->getStyle('L'.($row+1))->getNumberFormat()->setFormatCode('dd/mm/yyyy');
$parts = explode(" ", @$res->Name_Cus);
if(count($parts) > 1) {
    $lastname = array_pop($parts);
    $firstname = implode(" ", $parts);
}

$dataCusJob = @$dataCus->DataCusToDataCusCareerMany;
$CusJob = "";


        if($res->Career_Cus=='CR-0018'){
          $CusJob = $res->DetailCareer_Cus;  
        }else{
            $CusJob = $res->Name_Career;  
        }
 


$objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), @$res->Firstname_Cus);
$objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), @$res->Surname_Cus);
$objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), @$CusJob);
$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.($row+1), @$res->IDCard_cus, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),(@$res->Birthday_cus != NULL ?  ParsetoDate(@$res->Birthday_cus) : NULL) );
$objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), @$res->Detail_Sex);
$objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),  'ไทย');
$objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),  @$res->Plan_Insur);
$objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), @$res->Limit_Insur);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),  round((@$Timelack)/12));
              
            $add_num = @$res->houseNumber_Adds;
            $add_Group =  @$res->houseGroup_Adds ;
            $add_building = @$res->building_Adds;
            $add_village = @$res->village_Adds;
            $add_room = @$res->roomNumber_Adds;
            $add_Floor = @$res->Floor_Adds;
            $add_alley = @$res->alley_Adds;
            $add_road = @$res->road_Adds;
            $add_Tambon = @$res->houseTambon_Adds ;
            $add_District = @$res->houseDistrict_Adds ;
            $add_Province = @$res->houseProvince_Adds ;
            $add_Postal = @$res->Postal_Adds;
     
$objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), @$add_num);
$objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1), @$add_Group);
$objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1), @$add_building." ".@$add_village);

$objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1), @$add_alley);
$objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1), @$add_road );
$objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1), @$add_Tambon);
$objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1), @$add_District);
$objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1), @$add_Province );
$objPHPExcel->getActiveSheet()->setCellValue('Z'.($row+1), @$add_Postal);
$objPHPExcel->getActiveSheet()->setCellValueExplicit('AA'.($row+1), @$res->Phone_cus, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->setCellValue('AB'.($row+1), ''  );
$objPHPExcel->getActiveSheet()->setCellValue('AC'.($row+1), @$nameCom);
$objPHPExcel->getActiveSheet()->setCellValue('AD'.($row+1), 'เจ้าหนี้');
$objPHPExcel->getActiveSheet()->setCellValue('AE'.($row+1),  @$res->Beneficiary_PA != NULL ? @$res->Beneficiary_PA: 'ทายาทโดยธรรม');
$objPHPExcel->getActiveSheet()->setCellValue('AF'.($row+1),  @$res->Relations_PA  != NULL ? @$res->Relations_PA : 'ทายาทโดยธรรม');
$objPHPExcel->getActiveSheet()->setCellValue('AG'.($row+1),  @$zone[$res->UserZone]);
$objPHPExcel->getActiveSheet()->setCellValue('AH'.($row+1),  @$res->Name_Branch);
$objPHPExcel->getActiveSheet()->setCellValue('AI'.($row+1), $nameAent);

if(@$res->Timelack_Car>84){
    $timeR = 84;
}else{
    $timeR = @$res->Timelack_Car;
}

@$timePa = 'TimeRack'.$timeR;
$objPHPExcel->getActiveSheet()->setCellValue('AJ'.($row+1),  @$res->name);
$objPHPExcel->getActiveSheet()->setCellValue('AK'.($row+1),  @$res->$timePa );
$objPHPExcel->getActiveSheet()->setCellValue('AL'.($row+1),  '=IFERROR(VLOOKUP(O'.($row+1).'&AI'.($row+1).',Table!$C:$N,10,0),"")');
$objPHPExcel->getActiveSheet()->setCellValue('AM'.($row+1),  '=IFERROR(VLOOKUP(O'.($row+1).'&AI'.($row+1).',Table!$C:$N,7,0),"")');
$objPHPExcel->getActiveSheet()->setCellValue('AN'.($row+1),  '=IFERROR(VLOOKUP(O'.($row+1).'&AI'.($row+1).',Table!$C:$N,8,0),"")');
// $objPHPExcel->getActiveSheet()->setCellValue('AM'.($row+1),  @$res->Insurance_PA );            
    
    $row++;
}  
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
$objPHPExcel->getActiveSheet()->setTitle('ContactsPA');

$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->setTitle('Table');


$fname = "tmp/ContactsPA.xlsx";


$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ContactsPA.xlsx"');
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