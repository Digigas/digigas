<?php
App::import('Vendor', 'PDF', array('file' => 'pdf.php'));
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->setLeftMargin(10);
$pdf->SetAutoPageBreak(true ,15);


//titolo della pagina
$pdf->SetFont('Arial','',14);
$pdf->SetTextColor(124, 175, 0);
$pdf->SetY(20);
$pdf->Cell(0, 6, __('Riepilogo ordini per il produttore', true) . ' ' . $seller['Seller']['name'], 0, 2);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Line(10,27, 200,27);
$pdf->SetX(150);
$pdf->Cell(0, 8, digi_date(date('Y-m-d H:i')));

$pdf->SetDrawColor(200,200,200);

//ordini pendenti
$pdf->h1(__('Ordini pendenti', true));
$pdf->SetFont('Arial','B',9);
$pdf->Cell(70,4, __('Prodotto', true));
$pdf->Cell(30,4, __('Quantita', true));
$pdf->Cell(50,4, __('Totale', true));
$pdf->Cell(50,4, __('Data di consegna', true));
$pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($totals as $product) {
    $pdf->Cell(70,4, $product['Product']['name']);
    $pdf->Cell(30,4, $product['0']['quantity']);
    $pdf->Cell(50,4, $product['0']['total']);
    $pdf->Cell(50,4, digi_date($product['Hamper']['delivery_date_on']));
    $pdf->Ln();
    $h = $pdf->GetY();
    $pdf->Line(10,$h, 200,$h);
}


//totali per consegna
$pdf->h1(__('Totali per consegna', true));
$pdf->SetFont('Arial','B',9);
$pdf->Cell(100,4, __('Data di consegna', true));
$pdf->Cell(100,4, __('Totale', true));
$pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($totalsByHamper as $date => $total) {
    $pdf->Cell(100,4, digi_date($date));
    $pdf->Cell(100,4, $total);
    $pdf->Ln();
    $h = $pdf->GetY();
    $pdf->Line(10,$h, 200,$h);
}


//dettaglio
$pdf->h1(__('Dettaglio', true));
$pdf->SetFont('Arial','B',9);
$pdf->Cell(70,4, __('Acquirente', true));
$pdf->Cell(70,4, __('Prodotto', true));
$pdf->Cell(30,4, __('Quantita', true));
$pdf->Cell(30,4, __('Totale', true));
$pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach ($orderedProducts as $orderedProduct) {
    $pdf->Cell(70,4, $orderedProduct['User']['fullname']);
    $pdf->Cell(70,4, $orderedProduct['Product']['name']);
    $pdf->Cell(30,4, $orderedProduct['OrderedProduct']['quantity']);
    $pdf->Cell(30,4, $orderedProduct['OrderedProduct']['value']);
    $pdf->Ln();
    $h = $pdf->GetY();
    $pdf->Line(10,$h, 200,$h);
}

$pdf->Ln();


//stampa pdf
echo $pdf->output($pageTitle, 'D');
?>