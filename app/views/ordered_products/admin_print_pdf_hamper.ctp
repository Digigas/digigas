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
$pdf->Cell(130,6, __('Prodotto', true));
$pdf->Cell(30,6, __('Quantita', true));
$pdf->Cell(40,6, __('Totale euro', true));
$pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($totals as $product) {
    $pdf->Cell(130,6, $product['Product']['name']);
    $pdf->Cell(30,6, $product['0']['quantity']);
    $pdf->Cell(40,6, $product['0']['total']);
    if($product['OrderedProduct']['option_1'].$product['OrderedProduct']['option_2'])
    {
            $pdf->Ln(3);
            $option_string = "";
        if($product['OrderedProduct']['option_1'])
            $option_string .= $product['Product']['option_1'].": ".$product['OrderedProduct']['option_1'];
        if($product['OrderedProduct']['option_2'])
        {
            if($option_string)
                $option_string .= "; ";
            $option_string .= $product['Product']['option_2'].": ".$product['OrderedProduct']['option_2'];
        }
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(130,6, $option_string);
        $pdf->Ln();
        $pdf->SetFont('Arial','',9);
    }
    else 
        $pdf->Ln();
    $h = $pdf->GetY();
    $pdf->Line(10,$h, 200,$h);
}
//totale
$pdf->SetFont('Arial','B',9);
$pdf->Cell(130,6, __('Totale', true));
$pdf->Cell(30,6, '');
$pdf->Cell(40,6, $total);
$pdf->Ln();
$h = $pdf->GetY();
$pdf->Line(10,$h, 200,$h);
$pdf->SetFont('Arial','',9);

//dettaglio
$pdf->h1(__('Dettaglio per utente', true));

//dettaglio utente
foreach($orderedProducts as $products) {
	//utente
	$pdf->Ln(4);
	$pdf->h2($products['User']['fullname']);

	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,6, __('Prodotto', true));
	$pdf->Cell(30,6, __('Quantita', true));
	$pdf->Cell(40,6, __('Totale euro', true));
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	foreach ($products['Products'] as $orderedProduct) {
        $name = $orderedProduct['Product']['name'];
        $pdf->Cell(130,6, $name);
		$pdf->Cell(30,6, $orderedProduct['OrderedProduct']['quantity']);
		$pdf->Cell(40,6, $orderedProduct['OrderedProduct']['value']);
		
		if($orderedProduct['OrderedProduct']['option_1'].$orderedProduct['OrderedProduct']['option_2'])
        {
            $pdf->Ln(4);
            $option_string = "";
            if($orderedProduct['OrderedProduct']['option_1'])
                $option_string .= $orderedProduct['Product']['option_1'].": ".$orderedProduct['OrderedProduct']['option_1'];
            if($orderedProduct['OrderedProduct']['option_2'])
            {
                if($option_string)
                    $option_string .= "; ";
                $option_string .= $orderedProduct['Product']['option_2'].": ".$orderedProduct['OrderedProduct']['option_2'];
            }
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(130,6, $option_string);
            $pdf->SetFont('Arial','',9);
        }
        if($orderedProduct['OrderedProduct']['note']) 
        {
            $pdf->Ln(4);
            $pdf->SetFont('Arial','I',7);
            $pdf->Cell(130,3, $orderedProduct['OrderedProduct']['note']);
            $pdf->SetFont('Arial','',9);
        }
        $pdf->Ln();
		$h = $pdf->GetY();
		$pdf->Line(10,$h, 200,$h);
	}

	//totale
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,6, __('Totale', true));
	$pdf->Cell(30,6, '');
	$pdf->Cell(40,6, $products['Total']);
	$pdf->Ln();
	$h = $pdf->GetY();
	$pdf->Line(10,$h, 200,$h);
	$pdf->SetFont('Arial','',9);
}

$pdf->Ln();

//stampa pdf
echo $pdf->output($pageTitle, 'I');