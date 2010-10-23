<div class="orderedProducts form">
<?php echo $this->Form->create('OrderedProduct');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Ordered Product', true)); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('seller_id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('hamper_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('value');
		echo $this->Form->input('paid');
		echo $this->Form->input('retired');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('action' => 'index'));?></li>
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