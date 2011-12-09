<div class="date" style="background:#7CAF00;
                color:#fff;
                padding:5px 8px;
                width:auto;
                float:right;">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<?php echo $this->Html->tag('h1', __('Invio riepilogo ordini', true), array('style' => 'font-size:18px;')); ?>

<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Prodotto'); ?></th>
        <th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Consegna'); ?></th>
        <th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Quantità'); ?></th>
        <th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Totale'); ?></th>
    </tr>
    <?php foreach($totals as $product => $values): ?>
    <tr class="total">
        <td class="name" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;">
		<?php
		echo $product;
		
		$details = '';
		if (!empty($product['OrderedProduct']['option_1'])) {
			$details .= $product['Product']['option_1'] . ': ' . $product['OrderedProduct']['option_1'];
		}
		if (!empty($product['OrderedProduct']['option_2'])) {
			$details .= ' | ' . $product['Product']['option_2'] . ': ' . $product['OrderedProduct']['option_2'];
		}
		if (!empty($product['OrderedProduct']['note'])) {
			$details .= '<br/>' . $product['OrderedProduct']['option_2'];
		}
		if (!empty($details)) {
			echo $html->div('product_details', $details, array('style' => 'color: #ccc; font-size:10px;'));
		}
		?>
		</td>
        <td class="date" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php echo digi_date($values['Hamper']['delivery_date_on']); ?></td>
        <td class="quantity" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php echo $values['0']['quantity']; ?></td>
        <td class="value" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php echo $this->Number->currency($values['0']['total'], 'EUR'); ?> </td>
    </tr>
    <?php endforeach; ?>
</table>