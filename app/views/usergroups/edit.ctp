<div class="usergroups form">
<?php echo $this->Form->create('Usergroup');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Usergroup', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('text');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Usergroup.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Usergroup.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Usergroups', true)), array('action' => 'index'));?></li>
	</ul>
</div>