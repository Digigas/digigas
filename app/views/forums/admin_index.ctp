<div class="forums index">
	<h2><?php __('Gestione Forum');?></h2>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, %count% forum totali, dal %start% al %end%', true)
	));
	?>	</p>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Nome del forum', 'name');?></th>
			<th><?php echo $this->Paginator->sort('Livello di accesso', 'access_level');?></th>
			<th><?php echo $this->Paginator->sort('Attivo', 'active');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($forums as $forum):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $forum['Forum']['name']; ?>&nbsp;</td>
		<td><?php echo Configure::read('roles.' . $forum['Forum']['access_level']); ?>&nbsp;</td>
		<td><?php echo $forum['Forum']['active'] ? 'si' : 'no'; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Vai al forum', true), array('action' => 'view', $forum['Forum']['id'], 'admin' => false)); ?>
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $forum['Forum']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $forum['Forum']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $forum['Forum']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

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
		<li><?php echo $this->Html->link(__('Nuovo forum', true), array('action' => 'add')); ?></li>
	</ul>
</div>