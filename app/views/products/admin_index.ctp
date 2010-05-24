<div class="products index">
	<h2>
    <?php
    __('Archivio prodotti');
    if(isset($categoryName)) {
        echo ' '.__('nella categoria', true).' '.$categoryName;
    }
    if(isset($sellerName)) {
        echo ' '.__('del produttore', true).' '.$sellerName;
    }
    ?>
    </h2>
    
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort(__('Categoria', true), 'product_category_id');?></th>
			<th><?php echo $this->Paginator->sort(__('Nome', true), 'name');?></th>
			<th><?php echo $this->Paginator->sort(__('Produttore', true), 'seller_id');?></th>
			<th class="actions"><?php __('Azioni');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($product['ProductCategory']['name'], array('category' => $product['ProductCategory']['id']), array('title' => __('Visualizza solo questa categoria di prodotti', true))); ?>
		</td>		
		<td><?php echo $product['Product']['name']; ?>&nbsp;</td>
        <td>
			<?php echo $this->Html->link($product['Seller']['name'], array('seller' => $product['Seller']['id']), array('title' => __('Visualizza solo prodotti di questo produttore', true))); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Modifica', true), array('action' => 'edit', $product['Product']['id'])); ?>
			<?php echo $this->Html->link(__('Elimina', true), array('action' => 'delete', $product['Product']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
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
        <li><?php echo $this->Html->link(__('Nuovo prodotto', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Gestisci i produttori', true), array('controller' => 'sellers', 'action' => 'index')); ?> </li>
        <li>
            Visualizza per categoria
            <ul>
                <li><?php echo $this->Html->link('Tutte le categorie', array('action' => 'index')) ?></li>
                <?php
                foreach($productCategories as $id => $productCategory) {
                    echo $this->Html->tag('li',
                        $this->Html->link($productCategory,
                            array('category' => $id)));
                }
                ?>
            </ul>
        </li>
        <li><?php echo $this->Html->link(__('Gestisci le categorie', true), array('controller' => 'product_categories', 'action' => 'index')); ?> </li>
	</ul>
</div>