<?php echo $this->Html->tag('h1', __('Invio riepilogo ordini', true)); ?>
<?php echo date('D j M Y, H:i'); ?>

<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Produttore');?></th>
			<th><?php __('Prodotto');?></th>
			<th><?php __('Quantità');?></th>
			<th><?php __('Totale');?></th>
			<th class="actions"><?php __('Pagato');?></th>
			<th class="actions"><?php __('Ritirato');?></th>
	</tr>
<?php foreach($orderedProducts as $orderedProduct): ?>
    <tr>
		<td>
			<?php echo $orderedProduct['Seller']['name']; ?>
		</td>
		<td>
			<?php echo $orderedProduct['Product']['name']; ?>
		</td>
		<td><?php echo $orderedProduct['OrderedProduct']['quantity']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;&euro;</td>
		<td class="actions"><?php
        echo $orderedProduct['OrderedProduct']['paid']?'si':'no';
        ?></td>
		<td class="actions"><?php
        echo $orderedProduct['OrderedProduct']['retired']?'si':'no';
        ?></td>
	</tr>
<?php endforeach; ?>
</table>