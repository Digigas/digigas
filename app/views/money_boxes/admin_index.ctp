<div class="moneyBoxes index">
	<h2><?php __('Money Boxes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('ordered_product_id');?></th>
			<th><?php echo $this->Paginator->sort('value_in');?></th>
			<th><?php echo $this->Paginator->sort('value_out');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($moneyBoxes as $moneyBox):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $moneyBox['MoneyBox']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($moneyBox['User']['username'], array('controller' => 'users', 'action' => 'view', $moneyBox['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($moneyBox['OrderedProduct']['id'], array('controller' => 'ordered_products', 'action' => 'view', $moneyBox['OrderedProduct']['id'])); ?>
		</td>
		<td><?php echo $moneyBox['MoneyBox']['value_in']; ?>&nbsp;</td>
		<td><?php echo $moneyBox['MoneyBox']['value_out']; ?>&nbsp;</td>
		<td><?php echo $moneyBox['MoneyBox']['created']; ?>&nbsp;</td>
		<td><?php echo $moneyBox['MoneyBox']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $moneyBox['MoneyBox']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $moneyBox['MoneyBox']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $moneyBox['MoneyBox']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $moneyBox['MoneyBox']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Money Box', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('controller' => 'ordered_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('controller' => 'ordered_products', 'action' => 'add')); ?> </li>
	</ul>
</div>