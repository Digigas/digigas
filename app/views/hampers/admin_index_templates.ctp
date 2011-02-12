<div class="hampers index">
	<h2><?php __('Modelli di paniere');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort( __('Produttore', true), 'seller_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Nome', true), 'name');?></th>
			<th><?php echo $this->Paginator->sort(__('Data', true), 'end_date');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($hampers as $hamper):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($hamper['Seller']['name'], array('seller' => $hamper['Seller']['id'])); ?>
		</td>
		<td><?php echo $hamper['Hamper']['name']; ?>&nbsp;</td>
		<td><?php echo digi_date($hamper['Hamper']['end_date']); ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Html->link(__('Copia da questo', true), array('action' => 'copy', $hamper['Hamper']['id'])); ?>
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $hamper['Hamper']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $hamper['Hamper']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hamper['Hamper']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina %page% di %pages%, paniere da %start% a %end% di %count%', true)
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
        <li><?php echo $this->Html->link(__('Tutti i panieri', true), array('action' => 'index')); ?></li>
        <li><?php __('Visualizza per produttore'); ?>
            <ul>
                <li><?php echo $this->Html->link(__('Tutti', true), array('action' => 'index_templates')); ?></li>
                <?php foreach($sellers as $seller): ?>
                <li><?php echo $this->Html->link($seller['Seller']['name'], array('seller' => $seller['Seller']['id'])); ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
	</ul>
</div>