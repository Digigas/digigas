<div class="date" style="background:#7CAF00;
                color:#fff;
                padding:5px 8px;
                width:auto;
                float:right;">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<h1 style="font-size:18px;">
Riepilogo ordine per il paniere <?php echo $hamper['Hamper']['name'] ?>
 di <?php echo $hamper['Seller']['name']; ?>
 del <?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?>
</h1>

Devi ritirare i prodotti ordinati presso  <?php echo $hamper['Hamper']['delivery_position']; ?>
 dal <?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?>
 al <?php echo digi_date($hamper['Hamper']['delivery_date_off']); ?>.
 Il termine ultimo per il pagamento è <?php echo digi_date($hamper['Hamper']['checkout_date']); ?>

<br/><br/>
<strong>Hai ordinato:</strong>

<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
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
<?php foreach($products as $orderedProduct): ?>
    <tr>
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
                text-align:left;"><?php echo $this->Number->currency($orderedProduct['OrderedProduct']['value'], 'EUR'); ?></td>
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
			if(!date_is_empty($hamper['Hamper']['delivery_date_on'])) {
				__('Ritiralo ');
				echo digi_date($hamper['Hamper']['delivery_date_on']);
			} else {
				echo __('La data per il ritiro non è ancora stata comunicata');
			}
            echo '</strong>';
        }
        ?></td>
	</tr>
<?php endforeach; ?>
	<tr>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;" colspan="2">
			<strong>Totale</strong>
		</td>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;">
			<?php echo $this->Number->currency($total, 'EUR'); ?>
		</td>
		<td style="border-bottom:1px solid #ccc;
                padding:3px;
                text-align:left;" colspan="2">
			&nbsp;
		</td>
	</tr>
</table>