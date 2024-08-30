<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

// $origin = new DateTime($datefrom);
// $target = new DateTime($dateto);
// $interval = $origin->diff($target);
// $date_diff =$interval->format('%m');
// $date_start = explode('-',$datefrom);

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
$marr[12] = "December";//มีเล่มทะเบียนเป็นประกัน มิใช่มีเล่มทะเบียนเป็นประกัน
$groupLoan = array('P03'=>array('1',	'มีเล่มทะเบียน'),
            'P04'=>array('1',	'มีเล่มทะเบียน'),
            'P02'=>array('0',	''),
            'P06'=>array('0',	''),
            'P07'=>array('0',	''),
            'P08'=>array('1',	'มีเล่มทะเบียน'),
            'P10'=>array('0',	''));
$groupCarUse[1] =   '0763900001';
$groupCarUse[2] =	'0763900002';
$groupCarUse[3] =	'0763900003';
$groupCarUse[4] =	'0763900004';
$groupCarUse[5] =	'0763900005';
$groupCarUse[6] =	'0763900006';
$groupCarUse[7] =	'0763900007';
$groupCarUse[8] =	'0763900005';
$groupCarUse[9] =	'0763900005';
        
$GRPCODE[1]= "ต่ำกว่า 10,000";
$GRPCODE[2]=	"10,000.01 - 20,000.00";
$GRPCODE[3]=	"20,000.01 - 30,000.00";
$GRPCODE[4]=	"30,000.01 - 40,000.00";
$GRPCODE[5]=	"40,000.01 - 50,000.00";
$GRPCODE[6]=	"50,000.01 - 75,000.00";
$GRPCODE[7]=	"75,000.01 - 100,000.00";
$GRPCODE[8]=	"100,000.01 - 125,000.00";
$GRPCODE[9]=	"125,000.01 - 150,000.00";
$GRPCODE[10]=	"150,000.01 - 200,000.00";
$GRPCODE[11]=	"200,000.01 - 250,000.00";
$GRPCODE[12]=	"250,000.01 - 500,000.00";
$GRPCODE[13]=	"500,000.01 - 1,000,000.00";
$GRPCODE[14]=	"มากกว่า 1,000,000.01";

$GCODE = array("108"=>"สัญญาผูกไมโครไฟแนนซ์ (N)","P01"=>"ขายฝากที่ดิน","P02"=>	"จำนองที่ดิน",
            "P03"=>	"รถยนต์ เงินกู้","P04"=>	"เงินกู้มอเตอร์ไซค์","P05"=>	"เงินกู้ที่ดิน","P06"=>	"เงินกู้ไมโครรถยนต์","P07"=>	"สินเชื่อส่วนบุคคล",
            "P08"=>	"เงินกู้บุคคลจำนอง","P09"=>	"สัญญาผ่อนดอกเบี้ย","P28"=>	"จำนองที่ดิน","P08"=>	"เงินกู้รถใหญ่","P10"=>	"ไมโครมอเตอร์ไซค์");

// $cusJob[01] =     "รัฐวิสาหกิจ";
// $cusJob[02] = 	"ราชการ";
// $cusJob[03] = 	"ค้าขาย";
// $cusJob[04] = 	"เกษตรกรรม";
// $cusJob[05] = 	"กิจการส่วนตัว";
// $cusJob[06] = 	"รับจ้าง";
// $cusJob[07] = 	"พนักงานบริษัท";
// $cusJob[08] = 	"ทำประมง";
// $cusJob[09] = 	"ลูกจ้างประจำ";
// $cusJob[10] = 	"ข้าราชการบำนาญ";
// $cusJob[11] = 	"แม่บ้าน";
// $cusJob[12] = 	"ผู้ใหญ่บ้าน";
// $cusJob[13] = 	"ลูกค้ากลุ่ม black list";
// $cusJob[14] = 	"อื่นๆ";
// $cusJob[15] = 	"นายหน้า";
// $cusJob[16] = 	"ชูเกียรติเคลื่อนที่";
// $cusJob[17] = 	"ผู้ใหญ่บ้าน";
// $cusJob[18] = 	"พนักงานราชการ";
// $cusJob[19] = 	"รับเหมา";
// $cusJob[20] = 	"นายก อบต.";
// $cusJob[21] = 	"ลูกจ้างชั่วคราว";

$cusJob[1] = '0787300011';
$cusJob[2] = '0787300005';
$cusJob[3] = '0787300019';
$cusJob[4] = '0787300019';
$cusJob[5] = '0787300019';
$cusJob[6] = '0787300019';
$cusJob[7] = '0787300015';
$cusJob[8] = '0787300022';
$cusJob[9] = '0787300022';
$cusJob[10] = '0787300022';
$cusJob[11] = '0787300015';
$cusJob[12] = '0787300005';
$cusJob[13] = '0787300026';
$cusJob[14] = '0787300006';
$cusJob[15] = '0787300026';
$cusJob[16] = '0787300022';
$cusJob[17] = '0787300022';
$cusJob[18] = '0787300019';
$cusJob[19] = '0787300022';
$cusJob[20] = '0787300006';
$cusJob[21] = '0787300005';
$cusJob[22] = '0787300019';
$cusJob[23] = '0787300006';
$cusJob[24] = '0787300022';

$work[1] = '0787400112';
$work[2] = '0787400112';
$work[3] = '0787400112';
$work[4] = '0787400112';
$work[5] = '0787400112';
$work[6] = '0787400112';
$work[7] = '0787400112';
$work[8] = '0787400112';
$work[9] = '0787400112';
$work[10] = '0787400112';
$work[11] = '0787400112';
$work[12] = '0787400112';
$work[13] = '';
$work[14] = '0787400101';
$work[15] = '';
$work[16] = '0787400112';
$work[17] = '0787400112';
$work[18] = '0787400112';
$work[19] = '0787400112';
$work[20] = '0787400101';
$work[21] = '0787400112';
$work[22] = '0787400112';
$work[23] = '0787400101';
$work[24] = '0787400112';



$workOth[1] = '0787500010';
$workOth[2] = '0787500011';
$workOth[3] = '0787500010';
$workOth[4] = '0787500010';
$workOth[5] = '0787500010';
$workOth[6] = '0787500010';
$workOth[7] = '0787500010';
$workOth[8] = '0787500010';
$workOth[9] = '0787500010';
$workOth[10] = '0787500010';
$workOth[11] = '0787500010';
$workOth[12] = '0787500011';
$workOth[13] = '';
$workOth[14] = '';
$workOth[15] = '';
$workOth[16] = '0787500010';
$workOth[17] = '0787500010';
$workOth[18] = '0787500010';
$workOth[19] = '0787500010';
$workOth[20] = '';
$workOth[21] = '0787500011';
$workOth[22] = '0787500010';
$workOth[23] = '';
$workOth[24] = '0787500010';






$objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

$objPHPExcel->getProperties()->setCreator("Chookiat Group")
->setLastModifiedBy("Chookiat Group")
->setTitle("Office 2007 XLSX ")
->setSubject("Office 2007 XLSX ")
->setDescription("document for Office 2007 XLSX")
->setKeywords("office 2007 openxml php")
->setCategory("result file");
// / a1.GCODE IN ('P03','P04','P06','P07') AND SMPAY < TOTPRC
// $sqlBot = DB::connection('ibmi2')->select("SELECT a1.CONTNO,a1.CUSCOD,a1.FDATE,a1.LDATE,a1.PARBAL,a1.LOSTDAY,a1.GCODE,a1.LASTNOPAY,
// b1.GROUP1,b1.SNAM,b1.NAME1,b1.NAME2,b1.BIRTHDT,b1.IDNO,b1.OCCUP,b1.OFFIC,b1.MREVENU,c1.BAAB,c1.BONUS,c1.CRCOST,d1.EFRATE FROM PSFHP.VWDEBT_SPASTDUE AS a1 
// LEFT JOIN PSFHP.ARMAST AS d1 ON a1.CONTNO = d1.CONTNO 
// LEFT JOIN PSFHP.CUSTMAST as b1 ON a1.CUSCOD = b1.CUSCOD
// LEFT JOIN PSFHP.INVTRAN AS c1 ON a1.STRNO = c1.STRNO
// WHERE a1.CONTNO IN (SELECT CONTNO FROM PSFHP.ARMAST WHERE substr(CONTNO ,1,3)  IN ('P02','P03','P04','P06','P07')   ) AND a1.SUMARYDATE = '".date('Y-m-d')."'
// ORDER BY a1.CONTNO");d1.CONTNO IN (SELECT CONTNO FROM PSFHP.ARMAST WHERE (substr(d1.CONTNO,1,3)  IN ('P02','P03','P04','P06','P07') or substr(d1.CONTNO,1,6)  IN ('P02','P03','P04','P06','P07')) AND SMPAY < TOTPRC )
//AND


$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสสถาบัน');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'งวดข้อมูล');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'รหัสของผู้กู้ ');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ประเภทรหัสของผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ชื่อผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'วันเกิดของผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ภาวะการทำงาน');
$objPHPExcel->getActiveSheet()->setCellValue('H1', "อาชีพของผู้กู้");
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'อาชีพของผู้กู้ อื่น ๆ');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'ประเภทธุรกิจของกิจการที่ผู้กู้ทำงาน');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'การพิจารณารายได้รวมของผู้บริโภค / การพิจาณาวงเงินสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'รายได้');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'วันที่เริ่มสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('O1', 'วันที่สิ้นสุดสัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('P1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('Q1', "วัตถุประสงค์การกู้");
$objPHPExcel->getActiveSheet()->setCellValue('R1', 'วงเงินสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('S1', 'อัตราดอกเบี้ย เบี้ยปรับ ค่าปรับ ค่าบริการ ค่าธรรมเนียมใด ๆ');
$objPHPExcel->getActiveSheet()->setCellValue('T1', 'หลักประกัน');
$objPHPExcel->getActiveSheet()->setCellValue('U1', 'ประเภทรถ');
$objPHPExcel->getActiveSheet()->setCellValue('V1', 'มูลค่ารถ');
$objPHPExcel->getActiveSheet()->setCellValue('W1', 'ประเภทสินเชื่อภายใต้การกำกับ');
$objPHPExcel->getActiveSheet()->setCellValue('X1', 'สินเชื่อดิจิทัล');

// $PLC = '"รหัสสถาบัน"';
// $PLC .= '|"งวดข้อมูล"';
// $PLC .= '|"รหัสของผู้กู้"';
// $PLC .= '|"ประเภทรหัสของผู้กู้"';
// $PLC .= '|"ชื่อผู้กู้"';
// $PLC .= '|"วันเกิดของผู้กู้"';
// $PLC .= '|"ภาวะการทำงาน"';
// $PLC .= '|"อาชีพของผู้กู้"';
// $PLC .= '|"อาชีพของผู้กู้ อื่น ๆ"';
// $PLC .= '|"ประเภทธุรกิจของกิจการที่ผู้กู้ทำงาน"';
// $PLC .= '|"การพิจารณารายได้รวมของผู้บริโภค / การพิจาณาวงเงินสินเชื่อ"';
// $PLC .= '|"รายได้"';
// $PLC .= '|"เลขที่สัญญา"';
// $PLC .= '|"วันที่เริ่มสัญญา"';
// $PLC .= '|"วันที่สิ้นสุดสัญญา"';
// $PLC .= '|"ประเภทสินเชื่อ"';
// $PLC .= '|"วัตถุประสงค์การกู้"';
// $PLC .= '|"วงเงินสินเชื่อ"';
// $PLC .= '|"อัตราดอกเบี้ย เบี้ยปรับ ค่าปรับ ค่าบริการ ค่าธรรมเนียมใด ๆ"';
// $PLC .= '|"หลักประกัน"';
// $PLC .= '|"ประเภทรถ"';
// $PLC .= '|"มูลค่ารถ"';
// $PLC .= '|"ประเภทสินเชื่อภายใต้การกำกับ"';
// $PLC .= '|"สินเชื่อดิจิทัล"'.PHP_EOL;

// foreach($sqlBot as $res){
//     $PLC .= '"0815559000291"';
//     $PLC .= '|"'.date('Y-m-d').'"';
//     $PLC .= '|"'.trim($res->CUSCOD).'"';
//     $PLC .= '|"324001"';
//     $PLC .= '|"'.trim(iconv('Tis-620', 'utf-8',$res->SNAM))." ".trim(iconv('Tis-620', 'utf-8',$res->NAME1))." ".trim(iconv('Tis-620', 'utf-8',$res->NAME2)).'"';
//     $dateBirth =date_create($res->BIRTHDT);
     
//     $PLC .= '|"'.date_format($dateBirth,"Y-m-d").'"';
//     $PLC .= '|"'.$cusJob[intval($res->GROUP1)].'"';
//     $PLC .= '|"'.$work[intval($res->GROUP1)].'"';
//     $PLC .= '|"'.$workOth[intval($res->GROUP1)].'"';
//     $PLC .= '|""';
//     $PLC .= '|"0760900002"';
//     if(trim($res->MREVENU)>0){
//         $salary = trim($res->MREVENU);
//     }else{
//         $salary = 15000;
//     }
//     $PLC .= '|"'. $salary.'"';
//     $PLC .= '|"'.trim($res->CONTNO).'"';
//     $dateStart =date_create($res->FDATE);
//     $PLC .= '|"'.date_format($dateStart,"Y-m-d").'"';
   
//     $dateEnd =date_create($res->LDATE);
//     $PLC .= '|"'.date_format($dateEnd,"Y-m-d").'"';
//     $PLC .= '|"018022"';
//     $PLC .= '|"012001"';
//     $PLC .= '|"'.trim($res->CRCOST).'"';
//     $PLC .= '|"'.trim($res->EFRATE).'"';
//     $carUse = "";
//     $typeLoan = substr(trim($res->CONTNO),0,3);

//     if($res->BAAB!=NULL && (int)$res->BAAB>0 && ($typeLoan!="P06" && $typeLoan!="P07")){
//        $carUse =  $groupCarUse[(int)$res->BAAB];
//        $rate = $res->BONUS;
//        $typeCar = $groupLoan[$res->GCODE][0];
//     }else{
//         $rate = "";
//         $typeCar ="0";
//     }
//     $PLC .= '|"'.$typeCar.'"';
//     $PLC .= '|"'.$carUse.'"';
//     $PLC .= '|"'.$rate.'"';
//     $PLC .= '|"0786700001"';
//     $PLC .= '|"0"'.PHP_EOL;
    

// }
// $fname = "tmp/PLC.txt";
// $fp = fopen($fname,"w");
// fwrite($fp,$PLC);
// fclose($fp);


   

    

$sqlBot = DB::connection('sqlsrv')->select("SELECT * from view_ReportBOT where Company_Id='".$Company_Id."' and sdate <= '".$dateMonth."' ");   
$row = 1;
foreach($sqlBot as $res){
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.($row+1), trim($res->Company_Id), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row+1), date('Y-m-d'));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.($row+1), trim($res->IDCard_cus) , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row+1), $res->Type_Card);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row+1), trim($res->Name_Cus));
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row+1), trim($res->Birthday_cus));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.($row+1), $res->Code_EmpStatus , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.($row+1),$res->Code_PTL , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.($row+1), $res->othCareer , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.($row+1), $res->Code_Occupation , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.($row+1), $res->Factors, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    if(trim($res->Income_Cus)>0){
        $salary = trim($res->Income_Cus);
    }else{
        $salary = 15000;
    }
    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row+1), $salary);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('M'.($row+1),trim($res->contno), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $dateStart =date_create($res->sdate);
    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row+1), date_format($dateStart,"Y-m-d"));
    $dateEnd =date_create($res->ldate);
    $objPHPExcel->getActiveSheet()->setCellValue('O'.($row+1), date_format($dateEnd,"Y-m-d"));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('P'.($row+1), $res->Code_PLT, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q'.($row+1),  $res->Purpose, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $credit = "";
    // if($res->GRPCREDIT!=NULL && (int)$res->GRPCREDIT>0){
    //    $credit =  $GRPCODE[(int)$res->GRPCREDIT];
    // }
    $objPHPExcel->getActiveSheet()->setCellValue('R'.($row+1), trim($res->tcshprc) );
    $objPHPExcel->getActiveSheet()->setCellValue('S'.($row+1), trim($res->INTFLATRATE));
   
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('T'.($row+1),  $res->guarantee , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.($row+1),  $res->Vehicle_Type_PLT , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row+1), $res->Price_Asset);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('W'.($row+1), $res->Ploan , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('X'.($row+1), $res->digital);
    $row++;
    }

   
// $default_style = array(
//     'font' => array(
//         'name' => 'Verdana',
//         'color' => array('rgb' => '000000'),
//         'size' => 11
//     ),
//     'alignment' => array(
//         'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//         'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER
//     ),
//     'borders' => array(
//         'allborders' => array(
//             'style' => \PHPExcel_Style_Border::BORDER_THIN,
//             'color' => array('rgb' => '000000')
//         )
//     )
// );

// Apply default style to whole sheet
// $objPHPExcel->getActiveSheet()->getDefaultStyle()->applyFromArray($default_style);

// $last_col = $objPHPExcel->getActiveSheet()->getHighestColumn(); // Get last column, as a letter
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('C3:'.$last_col.'3')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row)->getNumberFormat()->setFormatCode('0');
// // Apply title style to titles

// $objPHPExcel->getActiveSheet()->getStyle('C2:'.$last_col.'32')->applyFromArray(
//     array(

//         'borders' => array(
//             'allborders' => array(
//               'style' => PHPExcel_Style_Border::BORDER_THIN
//           )
//         )
//     )
// );  


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
$objPHPExcel->getActiveSheet()->setTitle('PLC');

// $PLO = '"รหัสสถาบัน"';
// $PLO .= '|"งวดข้อมูล"';
// $PLO .= '|"เลขที่สัญญา"';
// $PLO .= '|"รหัสของผู้กู้"';
// $PLO .= '|"ประเภทรหัสของผู้กู้"';
// $PLO .= '|"ชื่อผู้กู้"';
// $PLO .= '|"ประเภทสินเชื่อ"';
// $PLO .= '|"ยอดค้าง"';
// $PLO .= '|"อัตราดอกเบี้ยที่ผิดนัดชำระหนี้"';
// $PLO .= '|"จำนวนวันที่ค้างชำระ"';
// $PLO .= '|"การตัดหนี้สูญ(write-off)"'.PHP_EOL;
// foreach($sqlBot as $res){
//     $PLO .= '"0815559000291"';
//     $PLO .= '|"'.date('Y-m-d').'"';
//     $PLO .= '|"'.trim($res->CONTNO).'"';
//     $PLO .= '|"'.trim($res->CUSCOD).'"';
//     $PLO .= '|"324001"';
//     $PLO .= '|"'.trim(iconv('Tis-620', 'utf-8',$res->SNAM))." ".trim(iconv('Tis-620', 'utf-8',$res->NAME1))." ".trim(iconv('Tis-620', 'utf-8',$res->NAME2)).'"';
//     $PLO .= '|"018022"';
//     $PLO .= '|"'.trim($res->PARBAL).'"';
//     $PLO .= '|""';
//     $PLO .= '|"'.trim($res->LOSTDAY).'"';
//     $PLO .= '|""'.PHP_EOL;
// }

// $fname2 = "tmp/PLO.txt";
// $fp2 = fopen($fname2,"w");
// fwrite($fp2,$PLO);
// fclose($fp2);


//echo $data;

// $PLU = '"รหัสสถาบัน"';
// $PLU .= '|"งวดข้อมูล"';
// $PLU .= '|"ประเภทสินเชื่อ"';
// $PLU .= '|"ยอดค้าง"'.PHP_EOL;

// // foreach($sqlBot as $res){
// //     $PLU .= '"0815559000291"';
// //     $PLU .= '|"'.date('Y-m-d').'"';
// //     $PLU .= '|"0786700001"';
// //     $PLU .= '|"'.$res->PARBAL.'"' .PHP_EOL;

// //     }
//     $fname3 = "tmp/PLU.txt";
//     $fp3 = fopen($fname3,"w");
//     fwrite($fp3,$PLU);
//     fclose($fp3);


$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสสถาบัน');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'งวดข้อมูล');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เลขที่สัญญา');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'รหัสของผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ประเภทรหัสของผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'ชื่อผู้กู้');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('H1', "ยอดค้าง");
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'อัตราดอกเบี้ยที่ผิดนัดชำระหนี้');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'จำนวนวันที่ค้างชำระ');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'การตัดหนี้สูญ(write-off)');

// $sqlBot2 =   DB::connection('sqlsrv')->select("SELECT * from view_ReportBOT where userzone='40' and sdate <= '2023-12-31' ");    
$row2 = 1;
foreach($sqlBot as $res){
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.($row2+1), $res->Company_Id, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row2+1), date('Y-m-d'));
    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row2+1), trim($res->contno));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.($row2+1), trim($res->IDCard_cus) , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row2+1), $res->Type_Card);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row2+1),  $res->Name_Cus );
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.($row2+1),$res->Code_PTL , \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row2+1), trim($res->balance));
    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row2+1), '');
    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row2+1), trim($res->exp_day));
    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row2+1), '');
   
    $row2++;
    }

$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row)->getNumberFormat()->setFormatCode('0' );
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
// // Rename sheet
// //echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('PLO');   

$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(2);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสสถาบัน');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'งวดข้อมูล');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ประเภทสินเชื่อ');
$objPHPExcel->getActiveSheet()->setCellValue('D1', "ยอดค้าง");


$row3 = 1;
// foreach($sqlBot as $res){
//     $objPHPExcel->getActiveSheet()->setCellValue('A'.($row3+1), '815559000291');
//     $objPHPExcel->getActiveSheet()->setCellValue('B'.($row3+1), date('Y-m-d'));
//     $objPHPExcel->getActiveSheet()->setCellValue('C'.($row3+1), $GCODE[$res->GCODE]);
//     $objPHPExcel->getActiveSheet()->setCellValue('D'.($row3+1), $res->PARBAL);

   
//     $row3++;
//     }

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
// // Rename sheet
// //echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('PLU');

$fname = "tmp/ReportBOT.xlsx";


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