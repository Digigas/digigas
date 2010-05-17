<div class="moneyBoxes form">
<?php echo $this->Form->create('MoneyBox');?>
	<fieldset>
 		<legend><?php printf(__('Admin Add %s', true), __('Money Box', true)); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('ordered_product_id');
        echo $this->Form->input('text');
		echo $this->Form->input('value_in');
		echo $this->Form->input('value_out');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Money Boxes', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('controller' => 'ordered_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('controller' => 'ordered_products', 'action' => 'add')); ?> </li>
	</ul>
</div>