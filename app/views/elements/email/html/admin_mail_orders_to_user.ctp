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
                text-align:left;"><?php __('Produttore');?></th>
			<th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Prodotto');?></th>
			<th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Quantità');?></th>
			<th style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Totale');?></th>
			<th class="actions" style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Pagato');?></th>
			<th class="actions" style="border-bottom:2px solid #999;
                padding:5px;
                text-align:left;"><?php __('Ritirato?');?></th>
	</tr>
<?php foreach($orderedProducts as $orderedProduct): ?>
    <tr>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;">
			<?php echo $orderedProduct['Seller']['name']; ?>
		</td>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;">
			<?php echo $orderedProduct['Product']['name']; ?>
		</td>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php echo $orderedProduct['OrderedProduct']['quantity']; ?>&nbsp;</td>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
		<td class="actions" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php
        echo $orderedProduct['OrderedProduct']['paid']?'si':'no';
        ?></td>
		<td class="actions" style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;"><?php
        if($orderedProduct['OrderedProduct']['retired']) {
            __('si');
        } else {
            echo '<strong>';
			if(!date_is_empty($orderedProduct['Hamper']['delivery_date_on'])) {
				__('Ritiralo ');
				echo digi_date($orderedProduct['Hamper']['delivery_date_on']);
			} else {
				echo __('La data per il ritiro non è ancora stata comunicata');
			}
            echo '</strong>';
        }
        ?></td>
	</tr>
<?php endforeach; ?>
</table>