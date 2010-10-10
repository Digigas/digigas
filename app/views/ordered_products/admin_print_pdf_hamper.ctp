<?php
App::import('Vendor', 'PDF', array('file' => 'pdf.php'));
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->setLeftMargin(10);
$pdf->setTopMargin(25);
$pdf->SetAutoPageBreak(true ,15);


//titolo della pagina
$pdf->SetFont('Arial','',14);
$pdf->SetTextColor(124, 175, 0);
$pdf->SetY(20);
$pdf->MultiCell(0, 6, __('Ordini per il paniere ', true)
	.$hamper['Hamper']['name'] . "\n"
	.__(' di ', true)
	.$hamper['Seller']['name'] . "\n"
	.__(' in consegna ', true)
	.digi_date($hamper['Hamper']['delivery_date_on']),
	0, 2);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0, 0, 0);
$h = $pdf->GetY();
$pdf->Line(10,$h, 200,$h);
$pdf->SetX(150);
$pdf->Cell(0, 8, digi_date(date('Y-m-d H:i')));

$pdf->SetDrawColor(200,200,200);

//ordini pendenti
$pdf->h1(__('Ordine', true));
$pdf->SetFont('Arial','B',9);
$pdf->Cell(130,5, __('Prodotto', true));
$pdf->Cell(30,5, __('Quantita', true));
$pdf->Cell(40,5, __('Totale euro', true));
$pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($totals as $product) {
    $pdf->Cell(130,4, $product['Product']['name']);
    $pdf->Cell(30,4, $product['0']['quantity']);
    $pdf->Cell(40,4, $product['0']['total']);
    $pdf->Ln();
    $h = $pdf->GetY();
    $pdf->Line(10,$h, 200,$h);
}

//dettaglio
$pdf->h1(__('Dettaglio per utente', true));

//dettaglio utente
foreach($orderedProducts as $products) {
	//utente
	$pdf->h2($products['User']['fullname']);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,5, __('Prodotto', true));
	$pdf->Cell(30,5, __('Quantita', true));
	$pdf->Cell(40,5, __('Totale euro', true));
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	foreach ($products['Products'] as $orderedProduct) {
		$pdf->Cell(130,4, $orderedProduct['Product']['name']);
		$pdf->Cell(30,4, $orderedProduct['OrderedProduct']['quantity']);
		$pdf->Cell(40,4, $orderedProduct['OrderedProduct']['value']);
		$pdf->Ln();
		$h = $pdf->GetY();
		$pdf->Line(10,$h, 200,$h);
	}

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,4, __('Totale', true));
	$pdf->Cell(30,4, '');
	$pdf->Cell(40,4, $products['Total']);
	$pdf->Ln();
	$h = $pdf->GetY();
	$pdf->Line(10,$h, 200,$h);

	$pdf->SetFont('Arial','',9);
}

$pdf->Ln();

//stampa pdf
echo $pdf->output($pageTitle, 'D');