<div class="usergroups index">
	<h2><?php __('Gruppi di utenti');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Nome del gruppo', 'name');?></th>
			<th><?php echo $this->Paginator->sort('Attivo', 'active');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($usergroups as $usergroup):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $usergroup['Usergroup']['name']; ?>&nbsp;</td>
		<td><?php echo $usergroup['Usergroup']['active']?'si':'no'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $usergroup['Usergroup']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $usergroup['Usergroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usergroup['Usergroup']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Nuovo gruppo', true), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('Gestisci gli utenti', true), array('controller' => 'users', 'action' => 'index')); ?></li>
	</ul>
</div>