<?php
function getCol($col)
{
    $col++;
    $alph =array("", 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');  
    $ret = $alph[floor($col/26)].$alph[$col%26];
    return $ret;
}

App::import('Vendor', 'phpexcel', array('file' => 'PHPExcel.php'));
App::import('Vendor', 'iofactory', array('file' => 'PHPExcel'.DS.'IOFactory.php'));
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)->setTitle("Paniere");  
// debug($users); 
// debug($totals); 
// die();

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Descrizione');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Opzione 1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Opzione 2');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'UM');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Prezzo');

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:E1')->getFont()->setBold("true");



$rownum = 2;
foreach($totals as $product)
{
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$rownum", $product['Product']['name']);
    if(!empty($product['Product']['option_1'])) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$rownum", $product['Product']['option_1'].': '.$product['OrderedProduct']['option_1']);
	}
    if(!empty($product['Product']['option_2'])) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$rownum", $product['Product']['option_2'].': '.$product['OrderedProduct']['option_2']);
	}
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$rownum", $product['Product']['units']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$rownum", $product['Product']['value']);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("E$rownum")->getNumberFormat()->setFormatCode( '[$€ ]#,##0.00_-');

    $colnum = 5;
    foreach($product['Users'] as $user)
    {
        if(!empty($user))
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colnum, $rownum, $user[0]['quantity']);
        $colnum++;
    }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colnum, $rownum, "=SUM(F$rownum:".getCol($colnum-1)."$rownum)");
//     echo "=SUM(E$rownum:".getCol($colnum)."$rownum)";
    $rownum++;
}
$colnum = 5;
foreach($users as $user)
{
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colnum, 1, $user['User']['last_name']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colnum, $rownum, $user['0']['total']);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colnum,$rownum)->getNumberFormat()->setFormatCode( '[$€ ]#,##0.00_-');
    $colnum++;
    
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>