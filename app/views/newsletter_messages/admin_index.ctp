<div class="newsletterMessages index">
	<h2><?php __('Newsletter Messages');?></h2>

    <p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%', true)
	));
	?>	</p>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Titolo', 'title');?></th>
			<th><?php echo $this->Paginator->sort('Destinatari', 'usergroup_id');?></th>
			<th><?php echo $this->Paginator->sort('Inviato', 'sent_date');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($newsletterMessages as $newsletterMessage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $newsletterMessage['NewsletterMessage']['title']; ?>&nbsp;</td>
		<td>
			<?php echo $newsletterMessage['Usergroup']['name']; ?>
		</td>
		<td>
            <?php
            if(empty($newsletterMessage['NewsletterMessage']['sent_date'])) {
                __('Fallito');
            } else {
                echo digi_date($newsletterMessage['NewsletterMessage']['sent_date']);
            }
            ?>
            &nbsp;
        </td>
		<td class="actions">
			<?php echo $this->Html->link(__('Visualizza', true), array('action' => 'view', $newsletterMessage['NewsletterMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Invia', true), array('action' => 'send', $newsletterMessage['NewsletterMessage']['id']), null, __('Stai per inviare questa email, sei sicuro?', true)); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $newsletterMessage['NewsletterMessage']['id']), null, __('Sei sicuro di voler eliminare questo messaggio?', true)); ?>
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
		<li><?php echo $this->Html->link(__('Invia un nuovo messaggio', true), array('action' => 'add')); ?></li>
			</ul>
</div>