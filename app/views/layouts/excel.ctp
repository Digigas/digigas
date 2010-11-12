<?php
if(!isset($filename))
    $filename = 'excel.xls';
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");;
echo $content_for_layout;


?>