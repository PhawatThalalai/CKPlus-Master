<?php
 
// require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
 
$reader = new Xlsx();
        $spreadSheet = $reader->load('tmp/contract.xlsx');
        $spreadSheet->setActiveSheetIndex(0);
        $activeSheet = $spreadSheet->getActiveSheet();
        // loaded excel file is edited here (hidde)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="test.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
        \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
        $writer->save('php://output');
?>