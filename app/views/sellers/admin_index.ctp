<div class="sellers index">
	<h2><?php __('Produttori - profili aziendali');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort(__('Nome', true), 'name');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($sellers as $seller):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $seller['Seller']['name']; ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Html->link(__('Vedi i prodotti', true), array('controller' => 'products', 'action' => 'index', 'seller' => $seller['Seller']['id'])); ?>
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $seller['Seller']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $seller['Seller']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $seller['Seller']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Nuovo profilo aziendale', true), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('Gestisci i prodotti', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
    </ul>
</div>