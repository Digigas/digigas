<div class="sellers index">
	<h2><?php __('Sellers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('business_name');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('mobile');?></th>
			<th><?php echo $this->Paginator->sort('fax');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('website');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($sellers as $seller):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $seller['Seller']['id']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['name']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['business_name']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['address']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['phone']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['mobile']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['fax']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['email']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['website']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['notes']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['created']; ?>&nbsp;</td>
		<td><?php echo $seller['Seller']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $seller['Seller']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $seller['Seller']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $seller['Seller']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $seller['Seller']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Seller', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Hampers', true)), array('controller' => 'hampers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Hamper', true)), array('controller' => 'hampers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('controller' => 'ordered_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('controller' => 'ordered_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Products', true)), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('controller' => 'products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>