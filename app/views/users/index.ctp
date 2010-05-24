<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('First Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['role']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Usergroup Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['usergroup_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('User', true)), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('User', true)), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Wallets', true)), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Wallet', true)), array('controller' => 'wallets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Ordered Products', true)), array('controller' => 'ordered_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sent Order', true)), array('controller' => 'ordered_products', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Hampers', true)), array('controller' => 'hampers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Hamper', true)), array('controller' => 'hampers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Payments', true)), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Payment', true)), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php printf(__('Related %s', true), __('Wallets', true));?></h3>
	<?php if (!empty($user['Wallet'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['user_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value In');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['value_in'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value Out');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['value_out'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['created'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $user['Wallet']['modified'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Wallet', true)), array('controller' => 'wallets', 'action' => 'edit', $user['Wallet']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php printf(__('Related %s', true), __('Ordered Products', true));?></h3>
	<?php if (!empty($user['SentOrder'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Seller Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Hamper Id'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Paid'); ?></th>
		<th><?php __('Retired'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['SentOrder'] as $sentOrder):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $sentOrder['id'];?></td>
			<td><?php echo $sentOrder['user_id'];?></td>
			<td><?php echo $sentOrder['seller_id'];?></td>
			<td><?php echo $sentOrder['product_id'];?></td>
			<td><?php echo $sentOrder['hamper_id'];?></td>
			<td><?php echo $sentOrder['quantity'];?></td>
			<td><?php echo $sentOrder['value'];?></td>
			<td><?php echo $sentOrder['paid'];?></td>
			<td><?php echo $sentOrder['retired'];?></td>
			<td><?php echo $sentOrder['created'];?></td>
			<td><?php echo $sentOrder['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ordered_products', 'action' => 'view', $sentOrder['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ordered_products', 'action' => 'edit', $sentOrder['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ordered_products', 'action' => 'delete', $sentOrder['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sentOrder['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Sent Order', true)), array('controller' => 'ordered_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Ordered Products', true));?></h3>
	<?php if (!empty($user['RecievedOrder'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Seller Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Hamper Id'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Paid'); ?></th>
		<th><?php __('Retired'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['RecievedOrder'] as $recievedOrder):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $recievedOrder['id'];?></td>
			<td><?php echo $recievedOrder['user_id'];?></td>
			<td><?php echo $recievedOrder['seller_id'];?></td>
			<td><?php echo $recievedOrder['product_id'];?></td>
			<td><?php echo $recievedOrder['hamper_id'];?></td>
			<td><?php echo $recievedOrder['quantity'];?></td>
			<td><?php echo $recievedOrder['value'];?></td>
			<td><?php echo $recievedOrder['paid'];?></td>
			<td><?php echo $recievedOrder['retired'];?></td>
			<td><?php echo $recievedOrder['created'];?></td>
			<td><?php echo $recievedOrder['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ordered_products', 'action' => 'view', $recievedOrder['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ordered_products', 'action' => 'edit', $recievedOrder['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ordered_products', 'action' => 'delete', $recievedOrder['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $recievedOrder['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Recieved Order', true)), array('controller' => 'ordered_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Hampers', true));?></h3>
	<?php if (!empty($user['Hamper'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Seller Id'); ?></th>
		<th><?php __('Start Date'); ?></th>
		<th><?php __('End Date'); ?></th>
		<th><?php __('Checkout Date'); ?></th>
		<th><?php __('Delivery Date On'); ?></th>
		<th><?php __('Delivery Date Off'); ?></th>
		<th><?php __('Delivery Position'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Hamper'] as $hamper):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $hamper['id'];?></td>
			<td><?php echo $hamper['name'];?></td>
			<td><?php echo $hamper['seller_id'];?></td>
			<td><?php echo $hamper['start_date'];?></td>
			<td><?php echo $hamper['end_date'];?></td>
			<td><?php echo $hamper['checkout_date'];?></td>
			<td><?php echo $hamper['delivery_date_on'];?></td>
			<td><?php echo $hamper['delivery_date_off'];?></td>
			<td><?php echo $hamper['delivery_position'];?></td>
			<td><?php echo $hamper['created'];?></td>
			<td><?php echo $hamper['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'hampers', 'action' => 'view', $hamper['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'hampers', 'action' => 'edit', $hamper['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'hampers', 'action' => 'delete', $hamper['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hamper['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Hamper', true)), array('controller' => 'hampers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Payments', true));?></h3>
	<?php if (!empty($user['Payment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Wallet Id'); ?></th>
		<th><?php __('Ordered Product Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Payment'] as $payment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $payment['id'];?></td>
			<td><?php echo $payment['value'];?></td>
			<td><?php echo $payment['user_id'];?></td>
			<td><?php echo $payment['wallet_id'];?></td>
			<td><?php echo $payment['ordered_product_id'];?></td>
			<td><?php echo $payment['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'payments', 'action' => 'view', $payment['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'payments', 'action' => 'edit', $payment['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'payments', 'action' => 'delete', $payment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Payment', true)), array('controller' => 'payments', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
