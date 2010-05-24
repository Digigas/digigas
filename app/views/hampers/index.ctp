<div class="hampers index">
	<h2><?php __('Hampers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('seller_id');?></th>
			<th><?php echo $this->Paginator->sort('start_date');?></th>
			<th><?php echo $this->Paginator->sort('end_date');?></th>
			<th><?php echo $this->Paginator->sort('checkout_date');?></th>
			<th><?php echo $this->Paginator->sort('delivery_date_on');?></th>
			<th><?php echo $this->Paginator->sort('delivery_date_off');?></th>
			<th><?php echo $this->Paginator->sort('delivery_position');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hampers as $hamper):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $hamper['Hamper']['id']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($hamper['User']['username'], array('controller' => 'users', 'action' => 'view', $hamper['User']['id'])); ?>
		</td>
		<td><?php echo $hamper['Hamper']['start_date']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['end_date']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['checkout_date']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['delivery_date_on']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['delivery_date_off']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['delivery_position']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['created']; ?>&nbsp;</td>
		<td><?php echo $hamper['Hamper']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $hamper['Hamper']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $hamper['Hamper']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $hamper['Hamper']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hamper['Hamper']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Hamper', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('controller' => 'ordered_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('controller' => 'ordered_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>