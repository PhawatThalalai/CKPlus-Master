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


$objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'วันที่จัดไฟแนนซ์');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'สาขา');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ประเภทลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ชื่อลูกค้า');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'เบอร์ติดต่อ');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'ยี่ห้อ');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'รุ่นรถ');
$objPHPExcel->getActiveSheet()->setCellValue('K1', "ปี");
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ทะเบียน / เลขโฉนด');
$objPHPExcel->getActiveSheet()->setCellValue('M1', "ราคากลาง");
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'ยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'ค่าดำเนินการ');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'ประกันรถ');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'ประกันPA');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'ประกันรถหัก');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'ประกันPAหัก');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'วันที่ครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'จำนวนวันที่ครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'LTV');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'ดอกเบี้ย');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'จำนวนงวด');
$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'ยอดผ่อน');

$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Credo Score');
$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'หมายเหตุ');
$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'คำนวณ Credo');
$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'วันที่โอนเงิน');


																	

$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
$objPHPExcel->getActiveSheet()->getStyle('M:S')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('Y')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode('0%');   
$row = 1;
foreach($data as $res){
   
      $nameCom = @$res->ContractToTypeLoan->TypeLoanToCompany->Company_Name;
    
      $expen = @$res->ContractToOperated;
      
      $dataCus = @$res->ContractToDataCusTags->TagToDataCus;
      $asset =   @$res->ContractToIndenture->IndentureToAsset;
    $calculate = @$res->ContractToDataCusTags->TagToCulculate;    
 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $row);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), @$res->Date_con);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$res->ContractToBranch->Name_Branch );
    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), @$res->ContractToDataCusTags->TagToStatusCus->Name_Cus );
    
    //chk
        $brand = "";
        $group = "";
        $model = "";
        $gear = "";
        $year = "";
        $license = "";
     if(@$asset->TypeAsset_Code!='land'){   
         
       $id_license = @$asset->Vehicle_NewLicense!=NULL?@$asset->Vehicle_NewLicense:@$asset->Vehicle_OldLicense;
       if(@$asset->TypeAsset_Code == "car"){
                $brand = @$asset->AssetToCarBrand->Brand_car;
                $group = @$asset->AssetToCarGroup->Group_car;
                $model = @$asset->AssetToCarModel->Model_car;
                $gear = @$asset->Vehicle_Gear;
                $year = @$asset->AssetToCarYear->Year_car;
                $license = @$asset->Vehicle_OldLicense;
              }else{
                $brand = @$asset->AssetToMotoBrand->Brand_moto;
                $group = @$asset->AssetToMotoGroup->Group_moto;
                $model = @$asset->AssetToMotoModel->Model_moto;
                $gear = @$asset->Vehicle_Gear;
                $year  = @$asset->AssetToMotoYear->Year_moto;
                $license = @$asset->Vehicle_OldLicense;
              }
    }else{
        $brand = @$asset->DataAssetToLandType->nametype_car;
         $license =  @$asset->Land_Id;
       
    }
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), '('.@$res->CodeLoan_Con.')-'.@$res->ContractToTypeLoan->Loan_Name);
   
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  @$res->Contract_Con);
   // ,        \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), @$dataCus->Name_Cus);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1),  @$dataCus->Phone_cus);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), @$brand );
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), @$model);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1), @$year);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), @$license);
    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1),  @$calculate->RatePrices);

    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),  @$calculate->Cash_Car );
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),  @$calculate->StatusProcess_Car=='yes'?@$calculate->Process_Car:0 );
    $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1),  @$calculate->Insurance );
     $cal_pa =  0;
    if(@$calculate->Buy_PA == "Yes" && @$calculate->Include_PA == "Yes"){
        $cal_pa =  @$calculate->Insurance_PA;
        }
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),   $cal_pa );
    $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1),  @$res->ContractToOperated->P2_Price );
    $op_pa =  0;
    if(@$calculate->Buy_PA == "Yes" && @$calculate->Include_PA == "No"){
        $op_pa =  @$res->ContractToOperated->Insurance_PA;
        }
    $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1),   $op_pa );
    $objPHPExcel->getActiveSheet()->setCellValue('T'.($row+1),  @$calculate->DateOccupiedcar);
    $objPHPExcel->getActiveSheet()->setCellValue('U'.($row+1),  @$calculate->NumDateOccupiedcar);
    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1), "=IFERROR((N".($row+1)."+O".($row+1).")/M".($row+1).",0)" );
    $objPHPExcel->getActiveSheet()->setCellValue('W'.($row+1),  @$calculate->totalInterest_Car);
  
    $objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1),  @$calculate->Timelack_Car);
    $objPHPExcel->getActiveSheet()->setCellValue('Y'.($row+1), @$calculate->Period_Rate);
    
    $objPHPExcel->getActiveSheet()->setCellValue('Z'.($row+1), @$res->ContractToDataCusTags->Credo_Score);
    $objPHPExcel->getActiveSheet()->setCellValue('AA'.($row+1), @$res->ContractToDataCusTags->DataCusTagToCredo->Name_Credo);
    $objPHPExcel->getActiveSheet()->setCellValue('AB'.($row+1), @$calculate->Note_Credo);
    $objPHPExcel->getActiveSheet()->setCellValue('AC'.($row+1), @$res->Date_monetary);
    $row++;
    }


   
$default_style = [
    'font' => [
        'name' => 'Verdana',
        'color' => ['rgb' => '000000'],
        'size' => 11
],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
],
    'borders' => [
        'allborders' => [
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
];

// Apply default style to whole sheet
// $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

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
header('Content-Disposition: attachment;filename="Contract.xlsx"');
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