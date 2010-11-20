<div class="productCategories index">
	<h2><?php __('Categorie di prodotti');?></h2>
	<table cellpadding="0" cellspacing="0" id="tree-table">
	<tr>
			<th><?php __('Nome'); ?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($productCategories as $productCategory):
		$class = '';
        if($productCategory['ProductCategory']['parent_id'] > 0) {
            $class .= 'child-of-node-'.$productCategory['ProductCategory']['parent_id'].' ';
        }
		if ($i++ % 2 == 0) {
			$class .= 'altrow';
		}

        $class = ' class="'.$class.'"';
	?>
	<tr<?php echo $class;?> id="node-<?php echo $productCategory['ProductCategory']['id'] ?>">
		<td class="first"><?php echo $productCategory['ProductCategory']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $productCategory['ProductCategory']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $productCategory['ProductCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productCategory['ProductCategory']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Nuova categoria', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Torna a produttori', true), array('controller' => 'sellers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Torna a prodotti', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
	</ul>
</div>