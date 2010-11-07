<div class="orderedProducts index">
	<h2><?php __('Storico dei tuoi ordini');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort(__('Data dell\' ordine', true), 'created');?></th>
			<th><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Prodotto', true), 'product_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Quantità', true), 'quantity');?></th>
			<th><?php echo $this->Paginator->sort(__('Prezzo totale', true), 'value');?></th>
			<th><?php echo $this->Paginator->sort(__('Pagato', true), 'paid');?></th>
			<th><?php echo $this->Paginator->sort(__('Ritirato', true), 'retired');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderedProducts as $orderedProduct):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
        <td>
            <?php echo digi_date($orderedProduct['OrderedProduct']['created']); ?>
        </td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Seller']['name'], array('controller' => 'sellers', 'action' => 'view', $orderedProduct['Seller']['id']), array('title' => __('Visualizza la scheda dell\'azienda', true))); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $orderedProduct['Product']['id'])); ?>
		</td>
		<td><?php echo rtrim($orderedProduct['OrderedProduct']['quantity'], '.0'); ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['value']; ?> &euro;</td>
		<td class="actions"><?php
        if($orderedProduct['OrderedProduct']['paid']) {
            echo $this->Html->image('oxygen/16x16/actions/apply.png', array('title' => __('Pagato', true)));
        } else {
            echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('title' => __('Non ancora pagato', true)));
        }
        ?></td>
		<td class="actions"><?php
        if($orderedProduct['OrderedProduct']['retired']) {
            echo $this->Html->image('oxygen/16x16/actions/apply.png', array('title' => __('Ritirato', true)));
        } else {
            echo $this->Html->image('oxygen/16x16/actions/mail_mark_important.png', array('title' => __('Non ancora ritirato', true)));
        }
        ?></td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Continua gli acquisti', true), array('controller' => 'hampers', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('I tuoi ordini attuali', true), array('controller' => 'ordered_products', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Quanto hai  speso', true), array('controller' => 'money_boxes', 'action' => 'index')); ?></li>
    </ul>
</div>