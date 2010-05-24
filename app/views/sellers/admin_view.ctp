<div class="sellers view">
<h2><?php  __('Seller');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Business Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['business_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mobile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['mobile']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fax'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['fax']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Website'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['website']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['notes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $seller['Seller']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Seller', true)), array('action' => 'edit', $seller['Seller']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Seller', true)), array('action' => 'delete', $seller['Seller']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $seller['Seller']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Sellers', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Seller', true)), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Hampers', true));?></h3>
	<?php if (!empty($seller['Hamper'])):?>
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
		foreach ($seller['Hamper'] as $hamper):
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
	<h3><?php printf(__('Related %s', true), __('Ordered Products', true));?></h3>
	<?php if (!empty($seller['OrderedProduct'])):?>
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
		foreach ($seller['OrderedProduct'] as $orderedProduct):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $orderedProduct['id'];?></td>
			<td><?php echo $orderedProduct['user_id'];?></td>
			<td><?php echo $orderedProduct['seller_id'];?></td>
			<td><?php echo $orderedProduct['product_id'];?></td>
			<td><?php echo $orderedProduct['hamper_id'];?></td>
			<td><?php echo $orderedProduct['quantity'];?></td>
			<td><?php echo $orderedProduct['value'];?></td>
			<td><?php echo $orderedProduct['paid'];?></td>
			<td><?php echo $orderedProduct['retired'];?></td>
			<td><?php echo $orderedProduct['created'];?></td>
			<td><?php echo $orderedProduct['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ordered_products', 'action' => 'view', $orderedProduct['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ordered_products', 'action' => 'edit', $orderedProduct['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ordered_products', 'action' => 'delete', $orderedProduct['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderedProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Ordered Product', true)), array('controller' => 'ordered_products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Products', true));?></h3>
	<?php if (!empty($seller['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Category Id'); ?></th>
		<th><?php __('Seller Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Text'); ?></th>
		<th><?php __('Packing'); ?></th>
		<th><?php __('Image'); ?></th>
		<th><?php __('Weight'); ?></th>
		<th><?php __('Number'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($seller['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['id'];?></td>
			<td><?php echo $product['product_category_id'];?></td>
			<td><?php echo $product['seller_id'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['text'];?></td>
			<td><?php echo $product['packing'];?></td>
			<td><?php echo $product['image'];?></td>
			<td><?php echo $product['weight'];?></td>
			<td><?php echo $product['number'];?></td>
			<td><?php echo $product['value'];?></td>
			<td><?php echo $product['created'];?></td>
			<td><?php echo $product['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'products', 'action' => 'view', $product['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'products', 'action' => 'edit', $product['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'products', 'action' => 'delete', $product['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Product', true)), array('controller' => 'products', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Users', true));?></h3>
	<?php if (!empty($seller['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('First Name'); ?></th>
		<th><?php __('Last Name'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Password'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Role'); ?></th>
		<th><?php __('Usergroup Id'); ?></th>
		<th><?php __('Seller Id'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($seller['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['first_name'];?></td>
			<td><?php echo $user['last_name'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['password'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['role'];?></td>
			<td><?php echo $user['usergroup_id'];?></td>
			<td><?php echo $user['seller_id'];?></td>
			<td><?php echo $user['active'];?></td>
			<td><?php echo $user['created'];?></td>
			<td><?php echo $user['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'users', 'action' => 'delete', $user['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
