<div class="usergroups index">
	<h2><?php __('Gruppi di utenti');?></h2>
	<table id="tree-table" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('Nome del gruppo');?></th>
			<th><?php __('Attivo');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($usergroups as $usergroup):
        if($usergroup['Usergroup']['parent_id'] > 0) {
            $class = 'child-of-node-'.$usergroup['Usergroup']['parent_id'];
        }
        else {
            $class = '';
        }

        if ($i++ % 2 == 0) {
            $class .= ' altrow';
        }
	?>
	<tr class="<?php echo $class;?>" id="node-<?php echo $usergroup['Usergroup']['id'] ?>">
		<td class="first"><?php echo $usergroup['Usergroup']['name']; ?>&nbsp;</td>
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
	'format' => __('Pagina %page% di %pages%, riga da %start% a %end% di %count%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('precedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nuovo gruppo', true), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('Gestisci gli utenti', true), array('controller' => 'users', 'action' => 'index')); ?></li>
	</ul>
</div>