<?php

if(!class_exists('FPDF')) {
    App::import('Vendor', 'FPDF', array('file' => 'fpdf'.DS.'fpdf.php'));
    $PDF = new FPDF();
}

class PDF extends FPDF {

    function header() {
        $this->setCreator('Digigas3 - www.digigas.org');
        $this->SetFont('Arial','',12);
        $this->Image(WWW_ROOT.'img'.DS.'digigas.jpg', 150, 10, 50, 10);
        }

    function footer() {
        $this->SetFont('Arial','',8);
        $this->SetTextColor(124, 175, 0);
        $this->Cell(0,0,'Digigas3');
        $this->SetTextColor(0, 0, 0);
    }

    function adaptiveCell($actualsize, $w ="", $h="" , $txt="", $border="" , $ln="" ,$align="" , $fill="" , $link="") {
        $size=$actualsize;
        if($w) {
            $this->SetFont('','',$size);
            while($this->GetStringWidth($txt)>$w) {
                $size -= .1;
                $this->SetFont('','',$size);
            }
            $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        }
        $this->SetFont('','',$actualsize);
    }

    function h1($text) {
        $this->Ln();
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(255, 153, 0);
        $this->Cell(0, 15, $text);
        $this->Ln();
        $this->SetFont('Arial','',9);
        $this->SetTextColor(0, 0, 0);
    }
    
}