<div class="comments index">
	<h2><?php __('Gestione commenti');?></h2>

	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, commenti da %start% a %end% di %count%', true)
	));
	?>	</p>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Pagina', 'model');?></th>
			<th><?php echo $this->Paginator->sort('Utente', 'user_id');?></th>
			<th><?php echo $this->Paginator->sort('Testo', 'text');?></th>
			<th><?php echo $this->Paginator->sort('Data', 'created');?></th>
			<th><?php echo $this->Paginator->sort('Attivo', 'active');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($comments as $comment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>		
		<td><?php echo $this->Html->link($comment['Comment']['pagetitle'], $comment['Comment']['url']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($comment['User']['fullname'], array('controller' => 'comments', 'action' => 'index', 'user' => $comment['User']['id'])); ?>
		</td>
		<td><?php echo $this->Text->truncate($comment['Comment']['text']); ?>&nbsp;</td>
		<td><?php echo digi_date($comment['Comment']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($comment['Comment']['active'] ? 'si' : 'no', array('action' => 'toggle_active', $comment['Comment']['id'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modera', true), array('action' => 'edit', $comment['Comment']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $comment['Comment']['id']), null, sprintf(__('Sei sicuro di voler eliminare il Commento # %s?', true), $comment['Comment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('preecedente', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('successiva', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Pannello strumenti', true), array('controller' => 'tools')); ?></li>
		<li><?php echo $this->Html->link(__('Vedi tutti i commenti', true), array('controller' => 'comments')); ?></li>
	</ul>
</div>