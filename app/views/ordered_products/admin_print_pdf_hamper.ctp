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
$title = __('Ordini per il paniere ', true)
	.$hamper['Hamper']['name'] . "\n"
	.$hamper['Seller']['name'];
if(!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
	$title .= "\n"
		.__('in consegna ', true)
		.digi_date($hamper['Hamper']['delivery_date_on']);
}
$pdf->MultiCell(0, 6, $title, 0, 2);
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0, 0, 0);
$h = $pdf->GetY();
$pdf->Line(10,$h, 200,$h);
$pdf->Cell(190, 8, digi_date(date('Y-m-d H:i')), '', '',  'R');

$pdf->SetDrawColor(200,200,200);


//ordini pendenti ($categories)
$pdf->h1(__('Ordine', true));
foreach($categories as $category)
{
    $pdf->h2($category['ProductCategory']['name']);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(20,6, __('Codice', true));
    $pdf->Cell(110,6, __('Prodotto', true));
    $pdf->Cell(30,6, __('Quantita', true));
    $pdf->Cell(28,6, __('Totale euro', true), '', '',  'R');
    $pdf->SetFont('Arial','',9);
    $pdf->Ln();
    foreach($category['Product'] as $product) {
        $pdf->Cell(20,6, $product['Product']['code']);
        $pdf->Cell(110,6, $product['Product']['name']);
        $pdf->Cell(30,6, clean_number($product['OrderedProduct']['quantity']) . ' ' . $product['Product']['units']);
        $pdf->Cell(28,6, $product['OrderedProduct']['total'] . EURO, '', '',  'R');
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
            $pdf->Cell(20,6, '');
            $pdf->Cell(110,6, $option_string);
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
    $pdf->Cell(130,6, __('Totale categoria', true));
    $pdf->Cell(30,6, '');
    // $pdf->Cell(40,6, $this->Number->currency($total, 'EUR', array('escape' => true)));
	$cat_total = array_sum(Set::extract('/Product/OrderedProduct/total', $category));
    $pdf->Cell(28,6, money_format('%.2n', $cat_total) . EURO, '', '',  'R');

    $pdf->Ln();

}
//Gran totale
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(130,6, __('Totale', true));
$pdf->Cell(30,6, '');
// $pdf->Cell(40,6, $this->Number->currency($total, 'EUR', array('escape' => true)));
$pdf->Cell(28,6, money_format('%.2n', $total) . EURO, '', '',  'R');

$pdf->Ln();
$h = $pdf->GetY();
$pdf->Line(10,$h, 200,$h);
$pdf->SetFont('Arial','',9);


//dettaglio per utente ($orderedProducts)
$pdf->AddPage();

$pdf->h1(__('Dettaglio per utente', true));

//dettaglio utente
foreach($orderedProducts as $products) {
	//utente
	$pdf->Ln(4);
	$pdf->h2($products['User']['fullname']);
	$tel = "";
	if($products['User']['phone'])
        $tel = "Tel: ".$products['User']['phone'];
    if($products['User']['mobile'])
        $tel = $tel? $tel. ", Cell: ".$products['User']['mobile']: "Cell: ".$products['User']['mobile'];
    if($tel) $pdf->h3($tel);
    
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(20,6, __('codice', true));
    $pdf->Cell(110,6, __('Prodotto', true));
    $pdf->Cell(30,6, __('Quantita', true));
	$pdf->Cell(28,6, __('Totale euro', true), '', '',  'R');
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	foreach ($products['Products'] as $orderedProduct) {
        $pdf->Cell(20,6, $orderedProduct['Product']['code']);
        $name = $orderedProduct['Product']['name'];
        $pdf->Cell(110,6, $name);
		$pdf->Cell(30,6, clean_number($orderedProduct['OrderedProduct']['quantity']) . ' ' . $orderedProduct['Product']['units']);
		$pdf->Cell(28,6, $orderedProduct['OrderedProduct']['value'], '', '',  'R');
		
		if($orderedProduct['OrderedProduct']['option_1'].$orderedProduct['OrderedProduct']['option_2'])
        {
            $pdf->Ln(4);
            $option_string = "";
            if($orderedProduct['OrderedProduct']['option_1']) {
                $option_string .= $orderedProduct['Product']['option_1'].": ".$orderedProduct['OrderedProduct']['option_1'];
			}
			if($orderedProduct['OrderedProduct']['option_2']) {
                if($option_string) {
                    $option_string .= "; ";
				}
                $option_string .= $orderedProduct['Product']['option_2'].": ".$orderedProduct['OrderedProduct']['option_2'];
            }
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(20,6, '');
            $pdf->Cell(110,6, $option_string);
            $pdf->SetFont('Arial','',9);
        }
        if($orderedProduct['OrderedProduct']['note']) 
        {
            $pdf->Ln(4);
            $pdf->SetFont('Arial','I',7);
            $pdf->Cell(20,6, '');
            $pdf->Cell(110,3, $orderedProduct['OrderedProduct']['note']);
            $pdf->SetFont('Arial','',9);
        }
        $pdf->Ln();
		$h = $pdf->GetY();
		$pdf->Line(10,$h, 200,$h);
	}

	//totale
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,6, __('Totale ', true).$products['User']['fullname']);
	$pdf->Cell(30,6, '');
	$pdf->Cell(28,6, money_format('%.2n', $products['Total']) . EURO, '', '',  'R');
	$pdf->Ln();
	$h = $pdf->GetY();
	$pdf->Line(10,$h, 200,$h);
	$pdf->SetFont('Arial','',9);
}

$pdf->Ln();

//stampa pdf
echo $pdf->output($pageTitle, 'I');