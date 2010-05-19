<div class="orderedProducts index">
	<h2><?php __('Ordered Products');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('seller_id');?></th>
			<th><?php echo $this->Paginator->sort('product_id');?></th>
			<th><?php echo $this->Paginator->sort('hamper_id');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('value');?></th>
			<th><?php echo $this->Paginator->sort('paid');?></th>
			<th><?php echo $this->Paginator->sort('retired');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
		<td><?php echo $orderedProduct['OrderedProduct']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['User']['username'], array('controller' => 'users', 'action' => 'view', $orderedProduct['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Seller']['username'], array('controller' => 'users', 'action' => 'view', $orderedProduct['Seller']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $orderedProduct['Product']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderedProduct['Hamper']['name'], array('controller' => 'hampers', 'action' => 'view', $orderedProduct['Hamper']['id'])); ?>
		</td>
		<td><?php echo $orderedProduct['OrderedProduct']['quantity']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['value']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['paid']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['retired']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['created']; ?>&nbsp;</td>
		<td><?php echo $orderedProduct['OrderedProduct']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $orderedProduct['OrderedProduct']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $orderedProduct['OrderedProduct']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $orderedProduct['OrderedProduct']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderedProduct['OrderedProduct']['id'])); ?>
		</td>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Hampers', true)), array('controller' => 'hampers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Hamper', true)), array('controller' => 'hampers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Payments', true)), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Payment', true)), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>