<?php

use Illuminate\Support\Facades\Log;

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

$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Finance สาขา');

$count_week = 1;
$coll = 1;
$coll_title = 1;


for ($i=0; $i <  count($week); $i++) { 
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_title += 1), 1, "Wks{$count_week}");
    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($coll_title),1,($coll_title += 2),1);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'ยอดจัด');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'เป้า');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%ยอดจัด');

    $count_week++;
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_title += 1), 1, "สรุปยอดรายเดือน");
$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($coll_title),1,($coll_title += 2),1);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'ยอดจัด');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'เป้า');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%ยอดจัด');

// $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
// $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Wks1');
// $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
// $objPHPExcel->getActiveSheet()->setCellValue('B2', 'ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('C2', 'เป้า');
// $objPHPExcel->getActiveSheet()->setCellValue('D2', '%ยอดจัด');


// $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Wks2');
// $objPHPExcel->getActiveSheet()->mergeCells('E1:G1');
// $objPHPExcel->getActiveSheet()->setCellValue('E2', 'ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('F2', 'เป้า');
// $objPHPExcel->getActiveSheet()->setCellValue('G2', '%ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Wks3');
// $objPHPExcel->getActiveSheet()->mergeCells('H1:J1');
// $objPHPExcel->getActiveSheet()->setCellValue('H2', 'ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('I2', 'เป้า');
// $objPHPExcel->getActiveSheet()->setCellValue('J2', '%ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Wks4');
// $objPHPExcel->getActiveSheet()->mergeCells('K1:M1');
// $objPHPExcel->getActiveSheet()->setCellValue('K2', 'ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('L2', 'เป้า');
// $objPHPExcel->getActiveSheet()->setCellValue('M2', '%ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('N1', 'เป้าประจำเดือน');
// $objPHPExcel->getActiveSheet()->mergeCells('N1:P1');
// $objPHPExcel->getActiveSheet()->setCellValue('N2', 'ยอดจัด');
// $objPHPExcel->getActiveSheet()->setCellValue('O2', 'เป้า');
// $objPHPExcel->getActiveSheet()->setCellValue('P2', '%ยอดจัด');


// $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
$row = 2;
$start = 3;
$groupBranch = NULL;
$collZn = 1;
$rows = 3;
$collSum = 1;

for ($i=0; $i < count($week); $i++) { 
    foreach ($zoneSup as $key => $value) {
        if($groupBranch!=$value->zone_sup && $groupBranch != NULL){       
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
           for ($i=0; $i < count($week); $i++) { 
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");

            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");
            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");


            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_C}" . ($row+1) .",0)");
            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_C}" . ($row+1) .",0)");

            $objPHPExcel->getActiveSheet()->getStyle(($getColl_SumPP).($row+1))->getNumberFormat()->setFormatCode('0%');
            // dd("{$getColl_B}{$start}:{$getColl_B}{$row}");
            // dd();
           }
    
           
            $row++;
            $rows++;
            $collZn = 1;
            $start = $row+1;
        } 

        // if($groupBranch!=$value->zone_sup && $groupBranch != NULL){   
        //         for ($i=0; $i < count($week); $i++) { 
        //             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
        //             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),($row+1), "Test" );
        //             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),($row+1), "Test" );
        //             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),($row+1), "=iferror(B".($row+1)."/C".($row+1).",0)" );
        //             $objPHPExcel->getActiveSheet()->getStyle(($coll_zn).($row+1))->getNumberFormat()->setFormatCode('0%');
        //         }
                
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),($row+1),"=B".($row+1)."+E".($row+1)."+H".($row+1)."+K".($row+1)."+N".($row+1));
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),($row+1),"=C".($row+1)."+F".($row+1)."+I".($row+1)."+L".($row+1)."+O".($row+1));
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_zn += 1),$row+1,"=IFERROR(Q".($row+1)."/R".($row+1).",0)");
        //         // $objPHPExcel->getActiveSheet()->getStyle("S".($row+1))->getNumberFormat()->setFormatCode('0%');
                
        //         // $row++;
        //         // $start = $row+1;
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+1), "=SUM(B".($start).":B".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((3),($row+1), "=SUM(C".($start).":C".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((4),($row+1), "=iferror(B".($row+1)."/C".($row+1).",0)" );
        //         // $objPHPExcel->getActiveSheet()->getStyle("D".($row+1))->getNumberFormat()->setFormatCode('0%');
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((5),($row+1), "=SUM(E".($start).":E".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((6),($row+1), "=SUM(F".($start).":F".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((7),($row+1), "=iferror(E".($row+1)."/F".($row+1).",0)" );
        //         // $objPHPExcel->getActiveSheet()->getStyle("G".($row+1))->getNumberFormat()->setFormatCode('0%');
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((8),($row+1), "=SUM(H".($start).":H".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((9),($row+1), "=SUM(I".($start).":I".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((10),($row+1), "=iferror(H".($row+1)."/I".($row+1).",0)" );
        //         // $objPHPExcel->getActiveSheet()->getStyle("J".($row+1))->getNumberFormat()->setFormatCode('0%');
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((11),($row+1), "=SUM(K".($start).":K".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((12),($row+1), "=SUM(L".($start).":L".($row).")" );
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((13),($row+1), "=iferror(K".($row+1)."/L".($row+1).",0)" );
        //         // $objPHPExcel->getActiveSheet()->getStyle("M".($row+1))->getNumberFormat()->setFormatCode('0%');
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((14),($row+1),"=B".($row+1)."+E".($row+1)."+H".($row+1)."+K".($row+1));
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((15),($row+1),"=C".($row+1)."+F".($row+1)."+I".($row+1)."+L".($row+1));
        //         // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((16),$row+1,"=IFERROR(N".($row+1)."/O".($row+1).",0)");
        //         // $objPHPExcel->getActiveSheet()->getStyle("P".($row+1))->getNumberFormat()->setFormatCode('0%');
        //         $row++;
        //         $coll_zn = 1;
        //         $start = $row+1;
        //     } 
        

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),$row+1,$value->Name_Branch);
            for ($i=0; $i < count($week); $i++) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),$rows,@$arrData[$week[$i]->weekly][$value->Target_Branch][0]);
                $coll_01 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn();
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),$rows,@$arrData[$week[$i]->weekly][$value->Target_Branch][1]);
                $coll_02 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn();

                // dd($coll_01, $coll_02);
                // dd("H".($rows)."/I".($rows)."", "{$coll_01}{$rows}");
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),$rows,"=IFERROR({$coll_01}{$rows}/{$coll_02}{$rows},0)");
                $coll_03 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn();
                $objPHPExcel->getActiveSheet()->getStyle(($coll_03).($rows))->getNumberFormat()->setFormatCode('0%');
            }





        

        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((5),$row+1,@$arrData['2'][$value->Target_Branch][0]);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((6),$row+1,$value->amont);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((7),$row+1,"=IFERROR(E".($row+1)."/F".($row+1).",0)");
        //    $objPHPExcel->getActiveSheet()->getStyle("G".($row+1))->getNumberFormat()->setFormatCode('0%');
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((8),$row+1,@$arrData['3'][$value->Target_Branch][0]);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((9),$row+1,$value->amont);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((10),$row+1,"=IFERROR(H".($row+1)."/I".($row+1).",0)");
        //    $objPHPExcel->getActiveSheet()->getStyle("J".($row+1))->getNumberFormat()->setFormatCode('0%');
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((11),$row+1,@$arrData['4'][$value->Target_Branch][0]);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((12),$row+1,$value->amont);
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((13),$row+1,"=IFERROR(K".($row+1)."/L".($row+1).",0)");
        //    $objPHPExcel->getActiveSheet()->getStyle("M".($row+1))->getNumberFormat()->setFormatCode('0%');
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((14),($row+1),"=B".($row+1)."+E".($row+1)."+H".($row+1)."+K".($row+1));
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((15),($row+1),"=C".($row+1)."+F".($row+1)."+I".($row+1)."+L".($row+1));
        //    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((16),$row+1,"=IFERROR(N".($row+1)."/O".($row+1).",0)");
        //    $objPHPExcel->getActiveSheet()->getStyle("P".($row+1))->getNumberFormat()->setFormatCode('0%');
        

        $groupBranch =  $value->zone_sup;
        $row++;
        $rows++;
        $collSum = 1;
    }
}

$collZn = 1;

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
           for ($i=0; $i < count($week); $i++) { 
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");

            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");
            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");


            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_C}" . ($row+1) .",0)");
            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_C}" . ($row+1) .",0)");

            $objPHPExcel->getActiveSheet()->getStyle(($getColl_SumPP).($row+1))->getNumberFormat()->setFormatCode('0%');
            // dd("{$getColl_B}{$start}:{$getColl_B}{$row}");
            // dd();
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


$objPHPExcel->getActiveSheet()->getStyle('A1:P'.($row+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:P'.($row+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($Brow+1))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:P'.($row+1))->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('PPAmont');

$objPHPExcel->createSheet();    
$objPHPExcel->setActiveSheetIndex(1);

$count_week = 1;
$coll = 1;
$coll_title = 1;

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PP Report สาขา');
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');

for ($i=0; $i < count($week); $i++) { 
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_title += 1), 1, "Wks{$count_week}");
    $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($coll_title),1,($coll_title += 5),1);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'PP');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'Booking');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'Target');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%PP');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%Booking');
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%PP_1_Days');

    // $coll++;
    $count_week++;
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll_title += 1), 1, "ยอดรายเดือน");
$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(($coll_title),1,($coll_title += 5),1);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'PP');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'Booking');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), 'Target');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%PP');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%Booking');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($coll += 1),(2), '%PP_1_Days');

// $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PP Report สาขา');
// $objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
// $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Wks1');
// $objPHPExcel->getActiveSheet()->mergeCells('B1:G1');
// $objPHPExcel->getActiveSheet()->setCellValue('B2', 'PP');
// $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Target');
// $objPHPExcel->getActiveSheet()->setCellValue('E2', '%PP');
// $objPHPExcel->getActiveSheet()->setCellValue('F2', '%Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('G2', '%PP_1_Days');
// $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Wks2');
// $objPHPExcel->getActiveSheet()->mergeCells('H1:M1');
// $objPHPExcel->getActiveSheet()->setCellValue('H2', 'PP');
// $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Target');
// $objPHPExcel->getActiveSheet()->setCellValue('K2', '%PP');
// $objPHPExcel->getActiveSheet()->setCellValue('L2', '%Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('M2', '%PP_1_Days');
// $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Wks3');
// $objPHPExcel->getActiveSheet()->mergeCells('N1:S1');
// $objPHPExcel->getActiveSheet()->setCellValue('N2', 'PP');
// $objPHPExcel->getActiveSheet()->setCellValue('O2', 'Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('P2', 'Target');
// $objPHPExcel->getActiveSheet()->setCellValue('Q2', '%PP');
// $objPHPExcel->getActiveSheet()->setCellValue('R2', '%Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('S2', '%PP_1_Days');
// $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Wks4');
// $objPHPExcel->getActiveSheet()->mergeCells('T1:Y1');
// $objPHPExcel->getActiveSheet()->setCellValue('T2', 'PP');
// $objPHPExcel->getActiveSheet()->setCellValue('U2', 'Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('V2', 'Target');
// $objPHPExcel->getActiveSheet()->setCellValue('W2', '%PP');
// $objPHPExcel->getActiveSheet()->setCellValue('X2', '%Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('Y2', '%PP_1_Days');
// $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'PP ประจำเดือน');
// $objPHPExcel->getActiveSheet()->mergeCells('Z1:AE1');
// $objPHPExcel->getActiveSheet()->setCellValue('Z2', 'PP');
// $objPHPExcel->getActiveSheet()->setCellValue('AA2', 'Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('AB2', 'Target');
// $objPHPExcel->getActiveSheet()->setCellValue('AC2', '%PP');
// $objPHPExcel->getActiveSheet()->setCellValue('AD2', '%Booking');
// $objPHPExcel->getActiveSheet()->setCellValue('AE2', '%PP_1_Days');


$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('############');
$row = 2;
$start = 3;
$groupBranch = NULL;
$collSum = 1;
$collZn = 1;
$rows = 3;
foreach ($zoneSupPP as $key => $value) {
    if($groupBranch!=$value->zone_sup && $groupBranch != NULL){       
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
           for ($i=0; $i < count($week); $i++) { 
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");

            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");
            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");

            $getColl_D = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_D}{$start}:{$getColl_D}{$row})");
            $getColl_D = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_D}{$start}:{$getColl_D}{$row})");

            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_D}" . ($row+1) .",0)");
            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_D}" . ($row+1) .",0)");

            $getColl_Sumbook = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_C}" . ($row+1) ."/{$getColl_B}" . ($row+1) .",0)");
            $getColl_Sumbook = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_C}" . ($row+1) ."/{$getColl_B}" . ($row+1) .",0)");

            $objPHPExcel->getActiveSheet()->getStyle(($getColl_SumPP).($row+1))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->getStyle(($getColl_Sumbook).($row+1))->getNumberFormat()->setFormatCode('0%');

            $getColl_G = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_G}{$start}:{$getColl_G}{$row})");
            $getColl_G = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_G}{$start}:{$getColl_G}{$row})");
            // dd("{$getColl_B}{$start}:{$getColl_B}{$row}");
            // dd();
           }
        

            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((2),($row+1), "=SUM(B".($start).":B".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((3),($row+1), "=SUM(C".($start).":C".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((4),($row+1), "=SUM(D".($start).":D".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((5),($row+1), "=iferror(B".($row+1)."/D".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((6),($row+1), "=iferror(C".($row+1)."/B".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->getStyle("E".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->getStyle("F".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((7),($row+1), "=SUM(G".($start).":G".($row).")" );
            // //
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((8),($row+1), "=SUM(H".($start).":H".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((9),($row+1), "=SUM(I".($start).":I".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((10),($row+1), "=SUM(J".($start).":J".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((11),($row+1), "=iferror(H".($row+1)."/J".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((12),($row+1), "=iferror(I".($row+1)."/H".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->getStyle("K".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->getStyle("L".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((13),($row+1), "=SUM(M".($start).":M".($row).")" );
            // //
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((14),($row+1), "=SUM(N".($start).":N".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((15),($row+1), "=SUM(O".($start).":O".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((16),($row+1), "=SUM(P".($start).":P".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((17),($row+1), "=iferror(N".($row+1)."/P".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((18),($row+1), "=iferror(O".($row+1)."/N".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->getStyle("Q".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->getStyle("R".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((19),($row+1), "=SUM(S".($start).":S".($row).")" );
            // //
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((20),($row+1), "=SUM(T".($start).":T".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((21),($row+1), "=SUM(U".($start).":U".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((22),($row+1), "=SUM(V".($start).":V".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((23),($row+1), "=iferror(T".($row+1)."/V".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((24),($row+1), "=iferror(U".($row+1)."/U".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->getStyle("W".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->getStyle("X".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((25),($row+1), "=SUM(Y".($start).":Y".($row).")" );
            // //
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((26),($row+1), "=SUM(Z".($start).":Z".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((27),($row+1), "=SUM(AA".($start).":AA".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((28),($row+1), "=SUM(AB".($start).":AB".($row).")" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((29),($row+1), "=iferror(Z".($row+1)."/AB".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((30),($row+1), "=iferror(AA".($row+1)."/Z".($row+1).",0)" );
            // $objPHPExcel->getActiveSheet()->getStyle("AC".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->getStyle("AD".($row+1))->getNumberFormat()->setFormatCode('0%');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((31),($row+1), "=SUM(AE".($start).":AE".($row).")" );
           
            $row++;
            $rows++;
            $collZn = 1;
            $start = $row+1;
        } 

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),$row+1,$value->Name_Branch);
        for ($i=0; $i < count($week); $i++) { 
            // dd($week[$i]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), @$arrDatapp[$week[$i]->weekly][$value->Target_Branch][0]);
            $getColl_1 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), @$arrDatapp[$week[$i]->weekly][$value->Target_Branch][1]);
            $getColl_2 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), $value->amont);
            $getColl_3 = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn(); 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), "=iferror({$getColl_1}{$rows}/{$getColl_3}{$rows},0)");
            $getSum_PP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn(); 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), "=iferror({$getColl_2}{$rows}/{$getColl_1}{$rows},0)");
            $getSum_Booking = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$rows)->getColumn(); 
            $objPHPExcel->getActiveSheet()->getStyle(($getSum_PP).($rows))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->getStyle(($getSum_Booking).($rows))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collSum += 1),($rows), @$arrDatapp[$week[$i]->weekly][$value->Target_Branch][3] );
        }
        
    

     $groupBranch =  $value->zone_sup;
       $row++;
       $rows++;
       $collSum = 1; 
}
        
// $collZn = 1;
// // dd("{$getColl_B}{$start}:{$getColl_B}{$rows}");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow((1),($row+1),$groupBranch);
           for ($i=0; $i < count($week); $i++) { 
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");
            $getColl_B = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_B}{$start}:{$getColl_B}{$row})");

            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");
            $getColl_C = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_C}{$start}:{$getColl_C}{$row})");

            $getColl_D = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_D}{$start}:{$getColl_D}{$row})");
            $getColl_D = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_D}{$start}:{$getColl_D}{$row})");

            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_D}" . ($row+1) .",0)");
            $getColl_SumPP = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_B}" . ($row+1) ."/{$getColl_D}" . ($row+1) .",0)");

            $getColl_Sumbook = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=iferror({$getColl_C}" . ($row+1) ."/{$getColl_B}" . ($row+1) .",0)");
            $getColl_Sumbook = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collZn),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=iferror({$getColl_C}" . ($row+1) ."/{$getColl_B}" . ($row+1) .",0)");

            $objPHPExcel->getActiveSheet()->getStyle(($getColl_SumPP).($row+1))->getNumberFormat()->setFormatCode('0%');
            $objPHPExcel->getActiveSheet()->getStyle(($getColl_Sumbook).($row+1))->getNumberFormat()->setFormatCode('0%');

            $getColl_G = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn += 1),($row+1), "=SUM({$getColl_G}{$start}:{$getColl_G}{$row})");
            $getColl_G = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(($collSum),$row)->getColumn();
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($collZn),($row+1), "=SUM({$getColl_G}{$start}:{$getColl_G}{$row})");
            // dd("{$getColl_B}{$start}:{$getColl_B}{$row}");
            // dd();
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



$objPHPExcel->getActiveSheet()->getStyle('A1:AE'.($row+1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AE'.($row+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle('A1:G'.($Brow+1))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AE'.($row+1))->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setTitle('PP');


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