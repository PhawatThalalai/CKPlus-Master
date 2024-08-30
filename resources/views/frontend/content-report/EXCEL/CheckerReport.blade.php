<?php


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
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'ยี่ห้อ');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'รุ่นรถ');
$objPHPExcel->getActiveSheet()->setCellValue('J1', "ปี");
$objPHPExcel->getActiveSheet()->setCellValue('K1', "ราคากลาง");
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'ยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'LTV');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'ดอกเบี้ย');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'จำนวนงวด');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'ยอดผ่อน');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'วันที่ครอบครอง');
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'สถานะเอกสาร');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'ตรวจลงพื้นที่');

$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
    
$row = 1;
foreach($data as $res){
    $flagStatus = !empty(@$res->ContractToStatusCon->Flag_Status)?@$res->ContractToStatusCon->Flag_Status:'สาขา';
   if(@$flagStatus==$Status||$Status==NULL){

      $nameCom = @$res->ContractToTypeLoan->TypeLoanToCompany->Company_Name;
    
      $expen = @$res->ContractToOperated;
      
      $dataCus = @$res->ContractToDataCusTags->DataCusTagToDataCus;
      $asset =   @$res->ContractToIndenture->IndentureToAsset;
    $calculate = @$res->ContractToDataCusTags->DataCusTagToDataCulcu;    
 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row+1), $row);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), @$res->Date_con );
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row+1),@$res->ContractToBranch->Name_Branch );
    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), @$res->ContractToDataCusTags->DataCusTagToStatusCus->Name_Cus );
    //chk
     if(@$asset->TypeAsset_Code!='land'){   
         
       $id_license = @$asset->Vehicle_NewLicense!=NULL?@$asset->Vehicle_NewLicense:@$asset->Vehicle_OldLicense;
       if(@$asset->TypeAsset_Code == "car"){
                $brand = @$asset->AssetToCarBrand->Brand_car;
                $group = @$asset->AssetToCarGroup->Group_car;
                $model = @$asset->AssetToCarModel->Model_car;
                $gear = @$asset->Vehicle_Gear;
                $year = @$asset->AssetToCarYear->Year_car;
              }else{
                $brand = @$asset->AssetToMotoBrand->Brand_moto;
                $group = @$asset->AssetToMotoGroup->Group_moto;
                $model = @$asset->AssetToMotoModel->Model_moto;
                $gear = @$asset->Vehicle_Gear;
                $year  = @$asset->AssetToMotoYear->Year_moto;
              }
    }else{
        $brand = @$asset->DataAssetToLandType->nametype_car;
         $model= @$asset->Land_Id;
        
        $year = "";
    }
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), '('.@$res->CodeLoan_Con.')-'.@$res->ContractToTypeLoan->Loan_Name);
   
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1),  @$res->Contract_Con);

    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row+1), @$dataCus->Name_Cus);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row+1), @$brand );
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row+1), @$model);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row+1), @$year);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row+1),  @$calculate->RatePrices);

    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1),  @$calculate->Cash_Car );
    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row+1), "=IFERROR(L".($row+1)."/K".($row+1).",0)" );
    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1),  @$calculate->totalInterest_Car);
  
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1),  @$calculate->Timelack_Car);
    $objPHPExcel->getActiveSheet()->setCellValue('P'.($row+1), @$calculate->Period_Rate);
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.($row+1),  @$calculate->DateOccupiedcar);
    $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), !empty(@$res->ContractToStatusCon->Flag_Status)?@$res->ContractToStatusCon->Flag_Status:'สาขา');
    $text_location = "ยังไม่ตรวจสอบ";
    if(@$res->ContractToAudittor->Checker_Location!=NULL){
        $text_location ="ตรวจสอบเเล้ว";
    }
    $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1),$text_location);
    $row++;
    }
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


// Apply default style to whole sheet
// $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

 $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
// $objPHPExcel->getActiveSheet()->getStyle('A1:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_col.'32')->applyFromArray(
    array(

        'borders' => array(
            'allborders' => array(
              'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
          )
        )
    )
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
$objPHPExcel->getActiveSheet()->setTitle('ContactsChecker');

$fname = "tmp/ContactsChecker.xlsx";
$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ContactsChecker.xlsx"');
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